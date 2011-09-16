<?php
class BlockedUsersController extends AppController
{
    var $name = 'BlockedUsers';
    function index()
    {
        $this->pageTitle = __l('Blocked Users');
        $this->BlockedUser->recursive = 0;
        $this->paginate = array(
            'conditions' => array(
                'BlockedUser.user_id' => $this->Auth->user('id')
            ) ,
            'contain' => array(
                'Blocked' => array(
                    'UserAvatar'
                )
            )
        );
        $this->set('blockedUsers', $this->paginate());
    }
    function view($id = null)
    {
        $this->pageTitle = __l('Blocked User');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $blockedUser = $this->BlockedUser->find('first', array(
            'conditions' => array(
                'BlockedUser.id = ' => $id
            ) ,
            'fields' => array(
                'BlockedUser.id',
                'BlockedUser.created',
                'BlockedUser.modified',
                'BlockedUser.user_id',
                'BlockedUser.blocked_user_id',
                'User.id',
                'User.created',
                'User.modified',
                'User.user_type_id',
                'User.username',
                'User.email',
                'User.password',
                'User.helper_rating_count',
                'User.total_helper_rating',
                'User.photo_album_count',
                'User.photo_count',
                'User.blog_count',
                'User.question_count',
                'User.answer_count',
                'User.user_comment_count',
                'User.user_openid_count',
                'User.cookie_hash',
                'User.cookie_time_modified',
                'User.is_openid_register',
                'User.is_agree_terms_conditions',
                'User.is_active',
                'User.is_email_confirmed',
                'User.last_login_ip',
                'User.last_logged_in_time',
                'User.user_login_count',
                'User.answer_total_ratings',
                'User.answer_rating_count',
            ) ,
            'recursive' => 0,
        ));
        if (empty($blockedUser)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $blockedUser['BlockedUser']['id'];
        $this->set('blockedUser', $blockedUser);
    }
    function add($username = null)
    {
        $this->pageTitle = __l('Add Blocked User');
        // check is user exists
        $user = $this->BlockedUser->User->find('first', array(
            'conditions' => array(
                'User.username' => $username
            ) ,
            'fields' => array(
                'User.id'
            ) ,
            'recursive' => -1
        ));
        if (empty($user)) {
            $this->cakeError('error404');
        }
        // Check is already added
        $blocked = $this->BlockedUser->find('first', array(
            'conditions' => array(
                'BlockedUser.user_id' => $this->Auth->user('id') ,
                'BlockedUser.blocked_user_id' => $user['User']['id']
            ) ,
            'fields' => array(
                'BlockedUser.id'
            ) ,
            'recursive' => -1
        ));
        if (empty($blocked)) {
            $this->data['BlockedUser']['user_id'] = $this->Auth->user('id');
            $this->data['BlockedUser']['blocked_user_id'] = $user['User']['id'];
            $this->BlockedUser->create();
            if ($this->BlockedUser->save($this->data)) {
                $this->Session->setFlash(__l('User blocked successfully.') , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'view',
                    $username
                ));
            } else {
            }
        } else {
            $this->Session->setFlash(__l('Already added') , 'default', array('lib' => __l('Error')), 'error');
        }
    }
    function edit($id = null)
    {
        $this->pageTitle = __l('Edit Blocked User');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->BlockedUser->save($this->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Blocked User has been updated') , $this->data['BlockedUser']['id']) , 'default', array('lib' => __l('Success')), 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Blocked User could not be updated. Please, try again.') , $this->data['BlockedUser']['id']) , 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->BlockedUser->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['BlockedUser']['id'];
        $users = $this->BlockedUser->User->find('list');
        $this->set(compact('users'));
    }
    function delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $blocked = $this->BlockedUser->find('first', array(
            'conditions' => array(
                'BlockedUser.user_id' => $this->Auth->user('id') ,
                'BlockedUser.id' => $id
            ) ,
            'contain' => array(
                'Blocked' => array(
                    'fields' => array(
                        'Blocked.username'
                    ) ,
                )
            ) ,
            'fields' => array(
                'BlockedUser.blocked_user_id'
            ) ,
        ));
        if (!$blocked) {
            $this->cakeError('error404');
        }
        if ($this->BlockedUser->del($id)) {
            $this->Session->setFlash(__l('Blocked User deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'view',
                $blocked['Blocked']['username']
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function admin_index()
    {
        $this->_redirectGET2Named(array(
            'user_id',
            'blocked_user_id',
            'q'
        ));
        $conditions = array();
        if (isset($this->params['named']['user_id'])) {
            $this->data['BlockedUser']['user_id'] = $this->params['named']['user_id'];
            $conditions['BlockedUser.user_id'] = $this->params['named']['user_id'];
        }
        if (isset($this->params['named']['blocked_user_id'])) {
            $this->data['BlockedUser']['blocked_user_id'] = $this->params['named']['blocked_user_id'];
            $conditions['BlockedUser.blocked_user_id'] = $this->params['named']['blocked_user_id'];
        }
        if (isset($this->params['named']['q'])) {
            $this->data['BlockedUser']['q'] = $this->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->params['named']['q']);
        }
        $this->pageTitle = __l('Blocked Users');
        $this->BlockedUser->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'BlockedUser.id' => 'desc'
            )
        );
        if (isset($this->data['BlockedUser']['q'])) {
            $this->paginate['search'] = $this->data['BlockedUser']['q'];
        }
        $this->set('blockUsers', $this->paginate());
        $users = $this->BlockedUser->User->find('list', array(
            'conditions' => array(
                'User.user_type_id !=' => ConstUserTypes::Admin
            )
        ));
        $blockedUsers = $this->BlockedUser->User->find('list', array(
            'conditions' => array(
                'User.user_type_id !=' => ConstUserTypes::Admin
            )
        ));
        $moreActions = $this->BlockedUser->moreActions;
        $this->set(compact('users', 'blockedUsers', 'moreActions'));
    }
    function admin_view($id = null)
    {
        $this->pageTitle = __l('Blocked User');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $blockedUser = $this->BlockedUser->find('first', array(
            'conditions' => array(
                'BlockedUser.id = ' => $id
            ) ,
            'fields' => array(
                'BlockedUser.id',
                'BlockedUser.created',
                'BlockedUser.modified',
                'BlockedUser.user_id',
                'BlockedUser.blocked_user_id',
                'User.id',
                'User.created',
                'User.modified',
                'User.user_type_id',
                'User.username',
                'User.email',
                'User.password',
                'User.helper_rating_count',
                'User.total_helper_rating',
                'User.user_comment_count',
                'User.user_openid_count',
                'User.cookie_hash',
                'User.cookie_time_modified',
                'User.is_openid_register',
                'User.is_agree_terms_conditions',
                'User.is_active',
                'User.is_email_confirmed',
                'User.last_login_ip',
                'User.last_logged_in_time',
                'User.user_login_count',
            ) ,
            'recursive' => 0,
        ));
        if (empty($blockedUser)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $blockedUser['BlockedUser']['id'];
        $this->set('blockedUser', $blockedUser);
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Blocked User');
        if (!empty($this->data)) {
            $this->BlockedUser->create();
            if ($this->BlockedUser->save($this->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Blocked User has been added') , $this->data['BlockedUser']['id']) , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Blocked User could not be added. Please, try again.') , $this->data['BlockedUser']['id']) , 'default', array('lib' => __l('Error')), 'error');
            }
        }
        $users = $this->BlockedUser->User->find('list');
        $this->set(compact('users'));
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Blocked User');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->BlockedUser->save($this->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Blocked User has been updated') , $this->data['BlockedUser']['id']) , 'default', array('lib' => __l('Success')), 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Blocked User could not be updated. Please, try again.') , $this->data['BlockedUser']['id']) , 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->BlockedUser->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['BlockedUser']['id'];
        $users = $this->BlockedUser->User->find('list');
        $this->set(compact('users'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->BlockedUser->del($id)) {
            $this->Session->setFlash(__l('Blocked User deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function admin_update()
    {
        if (!empty($this->data['BlockedUser'])) {
            $r = $this->data[$this->modelClass]['r'];
            $actionid = $this->data[$this->modelClass]['more_action_id'];
            unset($this->data[$this->modelClass]['r']);
            unset($this->data[$this->modelClass]['more_action_id']);
            $blockedUserIds = array();
            foreach($this->data['BlockedUser'] as $user_id => $is_checked) {
                if ($is_checked['id']) {
                    $blockedUserIds[] = $user_id;
                }
            }
            if (!empty($blockedUserIds) && !empty($actionid)) {
                $this->BlockedUser->deleteAll(array(
                    'BlockedUser.id' => $blockedUserIds
                ));
                $this->Session->setFlash(__l('Checked blocked users has been deleted') , 'default', array('lib' => __l('Success')), 'success');
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
}
?>