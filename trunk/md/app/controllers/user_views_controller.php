<?php
class UserViewsController extends AppController
{
    var $name = 'UserViews';
    function admin_index()
    {
        $this->_redirectGET2Named(array(
            'user_id',
            'q'
        ));
        $this->pageTitle = __l('User Views');
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
					'User.fb_user_id',
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
            $this->data['UserView']['q'] = $this->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->params['named']['q']);
        }
        $this->UserView->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar'
                ) ,
                'ViewingUser' => array(
                    'UserAvatar'
                ) ,
            ) ,
            'order' => array(
                'UserView.id' => 'desc'
            ) ,
        );
        if (isset($this->data['UserView']['q'])) {
            $this->paginate['search'] = $this->data['UserView']['q'];
        }
        $this->set('userViews', $this->paginate());
        $users = $this->UserView->User->find('list');
        $moreActions = $this->UserView->moreActions;
        $this->set(compact('moreActions', 'users'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->UserView->del($id)) {
            $this->Session->setFlash(__l('User View deleted') , 'default', array('lib' => __l('Success')), 'success');
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
                    $this->Session->setFlash(__l('Checked user views has been deleted') , 'default', array('lib' => __l('Success')), 'success');
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