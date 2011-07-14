<?php
class UserLoginsController extends AppController
{
    var $name = 'UserLogins';
    function admin_index()
    {
        $this->_redirectGET2Named(array(
            'user_id',
            'q'
        ));
        $conditions = array();
        $this->pageTitle = __l('User Logins');
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
            $this->data['UserLogin']['q'] = $this->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->params['named']['q']);
        }
        $this->UserLogin->recursive = 1;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                )
            ) ,
            'order' => array(
                'UserLogin.id' => 'desc'
            ) ,
        );
        if (isset($this->data['UserLogin']['q'])) {
            $this->paginate['search'] = $this->data['UserLogin']['q'];
        }
        $this->set('userLogins', $this->paginate());
        $moreActions = $this->UserLogin->moreActions;
        $this->set(compact('moreActions'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->UserLogin->del($id)) {
            $this->Session->setFlash(__l('User Login deleted') , 'default', null, 'success');
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
                    $this->Session->setFlash(__l('Checked user logins has been deleted') , 'default', null, 'success');
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