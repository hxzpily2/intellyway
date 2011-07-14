<?php
class UserOpenidsController extends AppController
{
    var $name = 'UserOpenids';
    var $components = array(
        'Openid'
    );
    function beforeFilter()
    {
        if (!Configure::read('user.is_enable_openid')) {
            $this->cakeError('error404');
        }
        parent::beforeFilter();
    }
    function index()
    {
        $this->pageTitle = __l('User Openids');
        $this->paginate = array(
            'conditions' => array(
                'UserOpenid.user_id' => $this->Auth->user('id')
            )
        );
        $this->UserOpenid->recursive = -1;
        $this->set('userOpenids', $this->paginate());
    }
    function add()
    {
        $this->pageTitle = __l('Add New Openid');
        if (!empty($this->data)) {
            $this->UserOpenid->set($this->data);
            if ($this->UserOpenid->validates()) {
                // send to openid function with open id url and redirect page
                if ((!empty($this->data['UserOpenid']['openid']) && $this->data['UserOpenid']['openid'] != 'Click to Sign In' && $this->data['UserOpenid']['openid'] != 'http://')) {
                    $check = true;
                    if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin && !$this->data['UserOpenid']['verify']) {
                        $check = false;
                    }
                    if ($check) {
                        $this->data['UserOpenid']['redirect_page'] = 'add';
                        $this->_openid();
                    }
                }
            }
        }
        // handle the fields return from openid
        if (count($_GET) > 1) {
            $returnTo = Router::url(array(
                'controller' => 'user_openids',
                'action' => 'add'
            ) , true);
            $response = $this->Openid->getResponse($returnTo);
            if ($response->status == Auth_OpenID_SUCCESS) {
                $this->data['UserOpenid']['openid'] = $response->identity_url;
                $this->data['UserOpenid']['user_id'] = $this->Auth->user('id');
            } else {
                $this->Session->setFlash(__l('Authenticated failed or you may not have profile in your OpenID account'));
            }
        }
        // check the auth user id is set in the useropenid data
        if (!empty($this->data['UserOpenid']['user_id'])) {
            $this->UserOpenid->create();
            if ($this->UserOpenid->save($this->data)) {
                $this->Session->setFlash(__l('User Openid has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('User Openid could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
            $users = $this->UserOpenid->User->find('list');
            $this->set(compact('users'));
        }
    }
    function _openid()
    {
        $returnTo = Router::url(array(
            'controller' => 'user_openids',
            'action' => $this->data['UserOpenid']['redirect_page']
        ) , true);
        $siteURL = Router::url(array(
            '/'
        ) , true);
        // send openid url and fields return to our server from openid
        if (!empty($this->data)) {
            try {
                $this->Openid->authenticate($this->data['UserOpenid']['openid'], $returnTo, $siteURL, array() , array());
            }
            catch(InvalidArgumentException $e) {
                $this->Session->setFlash(__l('Invalid OpenID') , 'default', null, 'error');
            }
            catch(Exception $e) {
                $this->Session->setFlash(__l($e->getMessage()));
            }
        }
    }
    function delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $user = $this->UserOpenid->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'User.is_openid_register'
            ) ,
            'recursive' => -1
        ));
        //Condition added to check user should have atleast one OpenID account for login
        if ($this->UserOpenid->find('count', array(
            'conditions' => array(
                'UserOpenid.user_id' => $this->Auth->user('id')
            )
        )) > 1 || $user['User']['is_openid_register'] == 0) {
            if ($this->UserOpenid->del($id)) {
                $this->Session->setFlash(__l('User Openid deleted') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->cakeError('error404');
            }
        } else {
            $this->Session->setFlash(__l('Sorry, you registered through OpenID account. So you should have atleast one OpenID account for login') , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
    }
    function admin_index()
    {
        $this->_redirectGET2Named(array(
            'username',
            'q'
        ));
        $this->pageTitle = __l('User Openids');
        $conditions = array();
        if (!empty($this->params['named']['username']) || !empty($this->params['named']['user_id'])) {
            $userConditions = !empty($this->params['named']['username']) ? array(
                'User.username' => $this->params['named']['username']
            ) : array(
                'User.id' => $this->params['named']['user_id']
            );
            $user = $this->{$this->modelClass}->User->find('first', array(
                'conditions' => $userConditions,
                'fields' => array(
                    'User.user_type_id',
                    'User.username',
                    'User.id',
                ) ,
                'recursive' => -1
            ));
            if (empty($user)) {
                $this->cakeError('error404');
            }
            $conditions['User.id'] = $this->data[$this->modelClass]['user_id'] = $user['User']['id'];
            $this->pageTitle.= ' - ' . $user['User']['username'];
        }
        if (isset($this->params['named']['q'])) {
            $this->data['UserOpenid']['q'] = $this->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->params['named']['q']);
        }
        $this->UserOpenid->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'UserOpenid.id',
                'UserOpenid.created',
                'UserOpenid.user_id',
                'UserOpenid.openid',
                'User.user_type_id',
                'User.username',
                'User.id',
            ) ,
            'order' => array(
                'UserOpenid.id' => 'desc'
            ) ,
        );
        if (isset($this->data['UserOpenid']['q'])) {
            $this->paginate['search'] = $this->data['UserOpenid']['q'];
        }
        $this->set('userOpenids', $this->paginate());
        $moreActions = $this->UserOpenid->moreActions;
        $this->set(compact('moreActions'));
    }
    function admin_add()
    {
        $this->setAction('add');
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->UserOpenid->del($id)) {
            $this->Session->setFlash(__l('User Openid deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function admin_update()
    {
        if (!empty($this->data[$this->modelClass])) {
            $r = $this->data[$this->modelClass]['r'];
            $actionid = $this->data[$this->modelClass]['more_action_id'];
            unset($this->data[$this->modelClass]['r']);
            unset($this->data[$this->modelClass]['more_action_id']);
            $selectedIds = array();
            foreach($this->data[$this->modelClass] as $primary_key_id => $is_checked) {
                if ($is_checked['id']) {
                    $selectedIds[] = $primary_key_id;
                }
            }
            if ($actionid && !empty($selectedIds)) {
                if ($actionid == ConstMoreAction::Delete) {
                    $this->{$this->modelClass}->deleteAll(array(
                        $this->modelClass . '.id' => $selectedIds
                    ));
                    $this->Session->setFlash(__l('Checked user OpenIDs has been deleted') , 'default', null, 'success');
                }
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
}
?>