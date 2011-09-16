<?php
class TopicDiscussionsController extends AppController
{
    var $components = array(
        'Email',
    );
    var $uses = array(
        'TopicDiscussion',
        'EmailTemplate',
    );
    var $name = 'TopicDiscussions';
    function index($topic_id = null)
    {
        if (is_null($topic_id)) {
            $this->cakeError('error404');
        }
        $conditions = array();
        $follow_topic_id = '';
        $this->pageTitle = __l('Topic');
        if (!empty($this->data['TopicDiscussion']['topic_id'])) {
            $topic_id = $this->data['TopicDiscussion']['topic_id'];
        }
        if (!empty($topic_id)) {
            $conditions['TopicDiscussion.topic_id'] = $topic_id;
            $topic = $this->TopicDiscussion->Topic->find('first', array(
                'conditions' => array(
                    'Topic.id' => $topic_id
                ) ,
                'fields' => array(
                    'Topic.name'
                ) ,
                'recursive' => -1
            ));
            $heading = $topic['Topic']['name'];
            $this->pageTitle.= ' - ' . $topic['Topic']['name'];
        }
        if (empty($topic)) {
            $this->cakeError('error404');
        }
        $this->paginate = array(
            'conditions' => array(
                $conditions
            ) ,
            'contain' => array(
                'Topic' => array(
                    'fields' => array(
                        'Topic.name'
                    ) ,
                ) ,
                'User' => array(
                    'UserAvatar',
                    'fields' => array(
                        'User.user_type_id',
                        'User.username',
                        'User.id',
						'User.fb_user_id',
                    )
                ) ,
            ) ,
            'order' => array(
                'TopicDiscussion.id' => 'asc'
            ) ,
            'recursive' => 1,
        );
        if (!empty($topic_id)) {
            $deal_topic = $this->TopicDiscussion->Topic->find('first', array(
                'conditions' => array(
                    'Topic.id' => $topic_id
                ) ,
                'contain' => array(
                    'Deal' => array(
                        'Company'
                    ) ,
                ) ,
                'recursive' => 2
            ));
        }
        $topicsuser = $this->TopicDiscussion->Topic->TopicsUser->find('first', array(
            'conditions' => array(
                'TopicsUser.topic_id' => $topic_id,
                'TopicsUser.user_id' => $this->Auth->user('id') ,
            ) ,
            'recursive' => -1
        ));
        if (!empty($topicsuser)) {
            $follow_topic_id = $topic_id;
            $this->data['TopicDiscussion']['follow'] = 1;
        }
        $user = $this->TopicDiscussion->User->find('first', array(
            'conditions' => array(
                'User.id = ' => $this->Auth->user('id')
            ) ,
            'contain' => array(
                'UserAvatar',
                'Company',
            ) ,
            'recursive' => 1,
        ));
        $this->set('user', $user);
        if (!empty($deal_topic)) {
            $this->set('deal', $deal_topic);
        }
        $this->set('follow_topic_id', $follow_topic_id);
        $this->data['TopicDiscussion']['topic_id'] = $topic_id;
        $this->set('topicDiscussions', $this->paginate());
        $this->set('pageTitle', $heading);
    }
    function add()
    {
        $this->pageTitle = __l('Add Topic Discussion');
        if (!empty($this->data)) {
            $this->data['TopicDiscussion']['user_id'] = $this->Auth->user('id');
            $this->TopicDiscussion->create();
            $this->data['TopicDiscussion']['ip'] = $this->RequestHandler->getClientIP();
            $this->data['TopicDiscussion']['dns'] = gethostbyaddr($this->RequestHandler->getClientIP());
            if ($this->TopicDiscussion->save($this->data)) {
                $this->Session->setFlash(__l('Topic Discussion has been added') , 'default', array('lib' => __l('Success')), 'success');
                $this->TopicDiscussion->Topic->updateAll(array(
                    'Topic.last_replied_user_id' => $this->Auth->user('id') ,
                    'Topic.last_replied_time' => '"' . date('Y-m-d H:i:s') . '"',
                ) , array(
                    'Topic.id' => $this->data['TopicDiscussion']['topic_id']
                ));
                $usersTopics = $this->TopicDiscussion->Topic->TopicsUser->find('all', array(
                    'conditions' => array(
                        'TopicsUser.topic_id' => $this->data['TopicDiscussion']['topic_id'],
                        'TopicsUser.user_id !=' => $this->Auth->user('id') ,
                    ) ,
                    'fields' => array(
                        'TopicsUser.id',
                        'TopicsUser.user_id'
                    ) ,
                    'recursive' => 0
                ));
                $topic = $this->TopicDiscussion->Topic->find('first', array(
                    'conditions' => array(
                        'Topic.id' => $this->data['TopicDiscussion']['topic_id'],
                    ) ,
                    'fields' => array(
                        'Topic.name'
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($usersTopics)) {
                    //send follow mail
                    foreach($usersTopics as $usersTopic) {
                        $user = $this->TopicDiscussion->User->find('first', array(
                            'conditions' => array(
                                'User.id' => $usersTopic['TopicsUser']['user_id'],
                            ) ,
                            'contain' => array(
                                'UserProfile'
                            ) ,
                            'recursive' => 1
                        ));											
						$language_code = $this->TopicDiscussion->getUserLanguageIso($usersTopic['TopicsUser']['user_id']);
						$email = $this->EmailTemplate->selectTemplate('Topic Discussion', $language_code);
                        $emailFindReplace = array(
                            '##FROM_EMAIL##' => $this->TopicDiscussion->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
                            '##SITE_LINK##' => Router::url('/', true) ,
                            '##TONAME##' => $user['User']['username'],
                            '##SITE_NAME##' => Configure::read('site.name') ,
                            '##FROMUSER##' => $this->Auth->user('username') ,
                            '##COMMENT##' => $this->data['TopicDiscussion']['comment'],
                            '##TOPICNAME##' => $topic['Topic']['name'],
                            '##TOPIC_LINK##' => Router::url(array(
                                'controller' => 'topic_discussions',
                                'action' => 'index',
                                $this->data['TopicDiscussion']['topic_id']
                            ) , true) ,
                            '##UNFOLLOW_LINK##' => Router::url(array(
                                'controller' => 'topics_users',
                                'action' => 'delete',
                                $this->data['TopicDiscussion']['topic_id']
                            ) , true) ,
                            '##CONTACT_URL##' => Router::url(array(
                                'controller' => 'contacts',
                                'action' => 'add',
                                'city' => $this->params['named']['city'],
                                'admin' => false
                            ) , true) ,
                            '##SITE_LOGO##' => Router::url(array(
                                'controller' => 'img',
                                'action' => 'blue-theme',
                                'logo-email.png',
                                'admin' => false
                            ) , true) ,
                        );
                        $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
                        $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
                        $this->Email->to = $this->TopicDiscussion->formatToAddress($user);
                        $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                        $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                        $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                    }
                }
                if (!empty($this->data['TopicDiscussion']['follow'])) {
                    $topicuser = array();
                    $topicuser['user_id'] = $this->Auth->user('id');
                    $topicuser['topic_id'] = $this->data['TopicDiscussion']['topic_id'];
                    $this->TopicDiscussion->Topic->TopicsUser->create();
                    $this->TopicDiscussion->Topic->TopicsUser->save($topicuser);
                }
                if (!$this->RequestHandler->isAjax()) {
                    $this->redirect(array(
                        'action' => 'index',
                        $this->data['TopicDiscussion']['topic_id']
                    ));
                } else {
                    // Ajax: return added answer
                    $this->setAction('view', $this->TopicDiscussion->getLastInsertId() , 'view_ajax');
                }
            } else {
                $this->Session->setFlash(__l('Topic Discussion could not be added. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
                $this->redirect(array(
                    'action' => 'index',
                    $this->data['TopicDiscussion']['topic_id']
                ));
            }
            $topicsuser = $this->TopicDiscussion->Topic->TopicsUser->find('first', array(
                'conditions' => array(
                    'TopicsUser.topic_id' => $this->data['TopicDiscussion']['topic_id'],
                    'TopicsUser.user_id' => $this->Auth->user('id') ,
                ) ,
                'recursive' => -1
            ));
            if (!empty($topicsuser)) {
                $follow_topic_id = $topic_id;
                $this->data['TopicDiscussion']['follow'] = 1;
            }
        }
        $topic = $this->TopicDiscussion->Topic->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id') ,
            ) ,
            'contain' => array(
                'UserAvatar',
                'Company',
                'fields' => array(
                    'User.user_type_id',
                    'User.username',
                    'User.id',
					'User.fb_user_id',
                )
            ) ,
            'recursive' => 1,
        ));
        $this->set('user', $topic);
    }
    function view($id = null, $view_name = 'view')
    {
        $this->pageTitle = __l('Topic Discussion');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $topicDiscussion = $this->TopicDiscussion->find('first', array(
            'conditions' => array(
                'TopicDiscussion.id = ' => $id
            ) ,
            'contain' => array(
                'Topic' => array(
                    'fields' => array(
                        'Topic.name'
                    ) ,
                ) ,
                'User' => array(
                    'UserAvatar',
                    'fields' => array(
                        'User.user_type_id',
                        'User.username',
                        'User.id',
						'User.fb_user_id',
                    )
                ) ,
            ) ,
            'recursive' => 2,
        ));
        if (empty($topicDiscussion)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $topicDiscussion['TopicDiscussion']['id'];
        $this->set('topicDiscussion', $topicDiscussion);
        $this->render($view_name);
    }
    function admin_index()
    {
        $this->pageTitle = __l('Topic Discussions');
        $conditions = array();
        if (isset($this->params['named']['topic_id'])) {
            $conditions['Topic.id'] = $this->params['named']['topic_id'];
        }
        // Citywise admin filter //
        $city_filter_id = $this->Session->read('city_filter_id');
        if (!empty($city_filter_id)) {
            $conditions['Topic.city_id'] = $city_filter_id;
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'Topic' => array(
                    'fields' => array(
                        'Topic.name',
                        'Topic.slug',
                        'Topic.id'
                    ) ,
                ) ,
                'User' => array(
                    'UserAvatar',
                    'fields' => array(
                        'User.user_type_id',
                        'User.username',
                        'User.id',
						'User.fb_user_id',
                    )
                ) ,
            ) ,
            'order' => array(
                'TopicDiscussion.id' => 'desc'
            ) ,
            'recursive' => 1,
        );
        if (!empty($this->params['named']['topic_id'])) {
            $topic = $this->TopicDiscussion->Topic->find('first', array(
                'conditions' => array(
                    'Topic.id' => $this->params['named']['topic_id']
                ) ,
                'fields' => array(
                    'Topic.name'
                ) ,
                'recursive' => -1
            ));
            $this->set('topic', $topic);
        }
        $this->set('topicDiscussions', $this->paginate());
        $moreActions = $this->TopicDiscussion->moreActions;
        $this->set(compact('moreActions'));
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Topic Discussion');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $topic = $this->TopicDiscussion->find('first', array(
            'conditions' => array(
                'TopicDiscussion.id' => (!(empty($this->data['TopicDiscussion']['TopicDiscussion']))) ? $this->data['TopicDiscussion']['TopicDiscussion'] : $id
            ) ,
            'contain' => array(
                'Topic' => array(
                    'fields' => array(
                        'Topic.name'
                    )
                )
            ) ,
            'fields' => array(
                'TopicDiscussion.id'
            ) ,
            'recursive' => 0
        ));
        if (!empty($this->data)) {
            $this->data['TopicDiscussion']['ip'] = $this->RequestHandler->getClientIP();
            if ($this->TopicDiscussion->save($this->data)) {
                $this->Session->setFlash(__l('Topic Discussion has been updated') , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'action' => 'index',
                ));
            } else {
                $this->Session->setFlash(__l('Topic Discussion could not be updated. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->TopicDiscussion->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['TopicDiscussion']['id'];
        $topics = $this->TopicDiscussion->Topic->find('list');
        $users = $this->TopicDiscussion->User->find('list');
        $this->set(compact('topics', 'users'));
        $this->set('topic', $topic);
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->TopicDiscussion->del($id)) {
            $this->Session->setFlash(__l('Topic Discussion deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function admin_update()
    {
        if (!empty($this->data['TopicDiscussion'])) {
            $r = $this->data[$this->modelClass]['r'];
            $actionid = $this->data[$this->modelClass]['more_action_id'];
            unset($this->data[$this->modelClass]['r']);
            unset($this->data[$this->modelClass]['more_action_id']);
            $topicDiscussionIds = array();
            foreach($this->data['TopicDiscussion'] as $topicDiscussion_id => $is_checked) {
                if ($is_checked['id']) {
                    $topicDiscussionIds[] = $topicDiscussion_id;
                }
            }
            if ($actionid && !empty($topicDiscussionIds)) {
                if ($actionid == ConstMoreAction::Delete) {
                    $this->TopicDiscussion->deleteAll(array(
                        'TopicDiscussion.id' => $topicDiscussionIds
                    ));
                    $this->Session->setFlash(__l('Checked topic discussions has been deleted') , 'default', array('lib' => __l('Success')), 'success');
                }
            }
        }
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect(Router::url('/', true) . $r);
        } else {
            $this->redirect($r);
        }
    }
}
?>