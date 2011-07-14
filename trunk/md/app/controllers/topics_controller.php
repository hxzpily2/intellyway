<?php
class TopicsController extends AppController
{
    var $name = 'Topics';
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Deal.name',
        );
        parent::beforeFilter();
    }
    function index()
    {
        $type = '';
        $heading = __l('All Topics');
        $conditions = array();
        $this->pageTitle = __l('All Topics');
        if (!empty($this->params['named']['type']) && $this->params['named']['type'] != 'all') {
            $topicTypes = $this->Topic->TopicType->find('first', array(
                'conditions' => array(
                    'TopicType.slug' => $this->params['named']['type']
                ) ,
                'fields' => array(
                    'TopicType.id',
                    'TopicType.name',
                ) ,
                'recursive' => -1,
            ));
            $conditions['Topic.topic_type_id'] = $topicTypes['TopicType']['id'];
            $this->pageTitle.= ' - ' . $topicTypes['TopicType']['name'];
            $heading = $topicTypes['TopicType']['name'];
        }
        // If global, getting all topics excluding city
        if (!empty($this->params['named']['type']) && $this->params['named']['type'] != 'global-talk') {
            if (!empty($this->params['named']['city'])) {
                $city_id = $this->Topic->City->find('first', array(
                    'conditions' => array(
                        'City.slug' => $this->params['named']['city']
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'all') {
                    $conditions['OR'][]['Topic.city_id'] = 0;
                    $conditions['OR'][]['Topic.city_id'] = $city_id['City']['id'];
                } else {
                    $conditions['Topic.city_id'] = $city_id['City']['id'];
                }
            }
        }
        if (!empty($this->params['named']['city']) && (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'city-talk')) {
            $heading = $city_id['City']['name'] . ' ' . __l('Talk');
        }
        $this->paginate = array(
            'conditions' => array(
                $conditions
            ) ,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                    'fields' => array(
                        'User.username',
                        'User.id',
                        'User.user_type_id',
						'User.fb_user_id',
                    )
                ) ,
                'Deal' => array(
                    'Attachment'
                ) ,
                'LastRepliedUser' => array(
                    'UserAvatar',
                    'Company',
                    'fields' => array(
                        'LastRepliedUser.user_type_id',
                        'LastRepliedUser.username',
                        'LastRepliedUser.id',
				 		'LastRepliedUser.fb_user_id',
                    )
                ) ,
                'TopicType' => array(
                    'fields' => array(
                        'TopicType.name'
                    )
                ) ,
                'City' => array(
                    'fields' => array(
                        'City.name'
                    )
                )
            ) ,
            'order' => array(
                'Topic.id' => 'desc'
            ) ,
            'recursive' => 2,
        );
        $topicTypes = $this->Topic->TopicType->find('all', array(
            'recursive' => -1
        ));
        $this->set('topics', $this->paginate());
        if (!empty($this->params['named']['type'])) {
            $type = $this->params['named']['type'];
        }
        if (!empty($city_slug)) {
            $get_current_city = $this->params['named']['city'];
        } else {
            $get_current_city = Configure::read('site.city');
        }
        $this->set('get_current_city', $get_current_city);
        $city = $this->params['named']['city'];
        $this->set('city', $city);
        $this->set('type', $type);
        $this->set('heading', $heading);
        $this->set('topicTypes', $topicTypes);
    }
    function add($topic_type = null)
    {
        $this->pageTitle = __l('Add Topic');
        if (!empty($this->data)) {
            $this->data['Topic']['user_id'] = $this->Auth->user('id');
            $city = $this->Topic->City->find('first', array(
                'conditions' => array(
                    'City.slug' => $this->params['named']['city']
                ) ,
                'fields' => array(
                    'City.id',
                ) ,
                'recursive' => -1,
            ));
            if ($this->data['Topic']['topic_type_id'] != ConstTopicType::GlobalTalk) {
                $this->data['Topic']['city_id'] = $city['City']['id'];
            }
            $this->Topic->create();
            $this->data['Topic']['last_replied_user_id'] = $this->Auth->user('id');
            $this->data['Topic']['last_replied_time'] = date('Y-m-d H:i:s');
            if ($this->Topic->save($this->data)) {
                $this->Session->setFlash(__l('Topic has been added') , 'default', null, 'success');
                $this->data['TopicDiscussion']['user_id'] = $this->Auth->user('id');
                $this->data['TopicDiscussion']['ip'] = $this->RequestHandler->getClientIP();
                $this->data['TopicDiscussion']['dns'] = gethostbyaddr($this->RequestHandler->getClientIP());
                $this->data['TopicDiscussion']['topic_id'] = $this->Topic->getLastInsertId();
                $this->data['TopicDiscussion']['comment'] = $this->data['Topic']['content'];
                $this->Topic->TopicDiscussion->create();
                $this->Topic->TopicDiscussion->save($this->data['TopicDiscussion']);
                if (!empty($this->data['Topic']['follow'])) {
                    $topicuser = array();
                    $topicuser['user_id'] = $this->Auth->user('id');
                    $topicuser['topic_id'] = $this->Topic->getLastInsertId();
                    $this->Topic->TopicsUser->create();
                    $this->Topic->TopicsUser->save($topicuser);
                }
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Topic could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        if (empty($topic_type) || $topic_type == 'all') {
            $topicTypes = $this->Topic->TopicType->find('list');
            foreach($topicTypes as $key => $value) {
                if ($key == ConstTopicType::CityTalk) {
                    $topicTypes[$key] = sprintf(__l('%s Talk') , $this->params['named']['city']);
                }
            }
            $this->set(compact('topicTypes'));
        } else {
            $topicTypes = $this->Topic->TopicType->find('first', array(
                'conditions' => array(
                    'TopicType.slug' => $topic_type
                ) ,
                'fields' => array(
                    'TopicType.id',
                ) ,
                'recursive' => -1,
            ));
            $this->data['Topic']['topic_type_id'] = $topicTypes['TopicType']['id'];
        }
        $get_user = $this->Topic->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->User('id')
            ) ,
            'fields' => array(
                'User.user_type_id',
                'User.username',
                'User.id',
				 'User.fb_user_id',
            ) ,
            'recursive' => -1
        ));
        $this->set('user', $get_user);
        $topicTypes = $this->Topic->TopicType->find('all', array(
            'recursive' => -1
        ));
        $topicsTypes = $this->Topic->TopicType->find('list');
        $this->set('topicTypes', $topicTypes);
        $this->set('topic_type', $topic_type);
        $this->set('topicsTypes', $topicsTypes);
    }
    function edit($id = null)
    {
        $this->pageTitle = __l('Edit Topic');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->Topic->save($this->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Topic has been updated') , $this->data['Topic']['name']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Topic could not be updated. Please, try again.') , $this->data['Topic']['name']) , 'default', null, 'error');
            }
        } else {
            $this->data = $this->Topic->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['Topic']['name'];
        $users = $this->Topic->User->find('list');
        $topicTypes = $this->Topic->TopicType->find('list');
        $cities = $this->Topic->City->find('list', array(
            'conditions' => array(
                'City.is_approved =' => 1
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
        $deals = $this->Topic->Deal->find('list');
        $this->set(compact('users', 'topicTypes', 'cities', 'deals'));
    }
    function delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->Topic->del($id)) {
            $this->Session->setFlash(__l('Topic deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function admin_index()
    {
        $this->pageTitle = __l('Topics');
        $conditions = array();
        if (!empty($this->params['named']['type']) && $this->params['named']['type'] != 'all') {
            $topicTypes = $this->Topic->TopicType->find('first', array(
                'conditions' => array(
                    'TopicType.slug' => $this->params['named']['type']
                ) ,
                'fields' => array(
                    'TopicType.id',
                    'TopicType.name',
                ) ,
                'recursive' => -1,
            ));
            $conditions['Topic.topic_type_id'] = $topicTypes['TopicType']['id'];
            $this->pageTitle.= ' - ' . $topicTypes['TopicType']['name'];
        }
        if (!empty($this->params['named']['deal_id'])) {
            $deal = $this->Topic->Deal->find('first', array(
                'conditions' => array(
                    'Deal.id' => $this->params['named']['deal_id']
                ) ,
                'fields' => array(
                    'Deal.name',
                ) ,
                'recursive' => -1,
            ));
            if (empty($deal)) {
                $this->cakeError('error404');
            }
            $conditions['Topic.deal_id'] = $this->params['named']['deal_id'];
            $this->pageTitle.= ' - ' . $deal['Deal']['name'];
        }
        // Citywise admin filter //
        $city_filter_id = $this->Session->read('city_filter_id');
        if (!empty($city_filter_id) && !empty($this->params['named']['type']) && $this->params['named']['type'] != 'global-talk') {
            $conditions['Topic.city_id'] = $city_filter_id;
        }
        $this->paginate = array(
            'conditions' => array(
                $conditions
            ) ,
            'contain' => array(
                'Deal' => array(
                    'fields' => array(
                        'Deal.name',
                        'Deal.slug',
                    )
                ) ,
                'City' => array(
                    'fields' => array(
                        'City.name',
                    )
                ) ,
                'User' => array(
                    'UserAvatar',
                    'fields' => array(
                        'User.username',
                        'User.id',
                    )
                ) ,
                'LastRepliedUser' => array(
                    'UserAvatar',
                    'fields' => array(
                        'LastRepliedUser.user_type_id',
                        'LastRepliedUser.username',
                        'LastRepliedUser.id',
                    )
                ) ,
                'TopicType' => array(
                    'fields' => array(
                        'TopicType.name'
                    )
                )
            ) ,
            'order' => array(
                'Topic.id' => 'desc'
            ) ,
            'recursive' => 1,
        );
        $this->set('topics', $this->paginate());
        $moreActions = $this->Topic->moreActions;
        $this->set(compact('moreActions'));
        $topicTypes = $this->Topic->TopicType->find('all', array(
            'recursive' => -1
        ));
        $this->set('topics', $this->paginate());
        $type = '';
        if (!empty($this->params['named']['type'])) {
            $type = $this->params['named']['type'];
        }
        if (!empty($city_slug)) {
            $get_current_city = $this->params['named']['city'];
        } else {
            $get_current_city = Configure::read('site.city');
        }
        $this->set('get_current_city', $get_current_city);
        $city = $this->params['named']['city'];
        $this->set('city', $city);
        $this->set('type', $type);
        $this->set('pageTitle', $this->pageTitle);
        $this->set('topicTypes', $topicTypes);
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Topic');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $id = (!empty($this->data['Topic']['id'])) ? $this->data['Topic']['id'] : $id;
        if (!empty($this->data)) {
            if ($this->Topic->save($this->data)) {
                $this->Session->setFlash(__l('Topic has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index',
                ));
            } else {
                $this->Session->setFlash(__l('Topic could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->data = $this->Topic->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['Topic']['name'];
        $users = $this->Topic->User->find('list');
        $topicTypes = $this->Topic->TopicType->find('list');
        $cities = $this->Topic->City->find('list', array(
            'conditions' => array(
                'City.is_approved =' => 1
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
        $topic = $this->Topic->find('first', array(
            'conditions' => array(
                'Topic.id =' => $id
            ) ,
            'contain' => array(
                'Deal' => array(
                    'fields' => array(
                        'Deal.name'
                    )
                )
            ) ,
            'fields' => array(
                'Topic.name',
                'Topic.id',
                'Topic.deal_id',
                'Topic.topic_type_id'
            ) ,
            'recursive' => 0
        ));
        $this->set('topic', $topic);
        $this->set(compact('users', 'topicTypes', 'cities'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->Topic->del($id)) {
            $this->Session->setFlash(__l('Topic deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function admin_update()
    {
        $this->autoRender = false;
        if (!empty($this->data['Topic'])) {
            $r = $this->data[$this->modelClass]['r'];
            $actionid = $this->data[$this->modelClass]['more_action_id'];
            unset($this->data[$this->modelClass]['r']);
            unset($this->data[$this->modelClass]['more_action_id']);
            $topicIds = array();
            foreach($this->data['Topic'] as $topic_id => $is_checked) {
                if ($is_checked['id']) {
                    $topicIds[] = $topic_id;
                }
            }
            if ($actionid && !empty($topicIds)) {
                if ($actionid == ConstMoreAction::Delete) {
                    $this->Topic->deleteAll(array(
                        'Topic.id' => $topicIds
                    ));
                    $this->Session->setFlash(__l('Checked topic has been deleted') , 'default', null, 'success');
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