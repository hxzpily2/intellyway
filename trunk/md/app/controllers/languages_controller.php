<?php
class LanguagesController extends AppController
{
    var $name = 'Languages';
    function admin_index()
    {
        $param_string = "";
        $this->pageTitle = __l('Languages');
        $conditions = array();
        if (!empty($this->data['Language']['filter_id'])) {
            $this->params['named']['filter_id'] = $this->data['Language']['filter_id'];
        }
        if (!empty($this->data['Language']['q'])) {
            $this->params['named']['q'] = $this->data['Language']['q'];
        }
        $param_string.= !empty($this->params['named']['filter_id']) ? '/filter_id:' . $this->params['named']['filter_id'] : $param_string;
        if (isset($this->params['named']['q']) && !empty($this->params['named']['q'])) {
            $this->data['Language']['q'] = $this->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->params['named']['q']);
            $param_string = '/q:' . $this->params['named']['q'];
        }
        if (!empty($this->params['named']['filter_id'])) {
            if ($this->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['Language.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['Language.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            }
        }
        $this->Language->recursive = -1;
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'Language.name' => 'asc'
            )
        );
        if (!empty($this->params['named']['q'])) {
            $this->paginate['search'] = $this->params['named']['q'];
        }
        $this->set('param_string', $param_string);
        $this->set('languages', $this->paginate());
        $this->set('pending', $this->Language->find('count', array(
            'conditions' => array(
                'Language.is_active = ' => 0
            )
        )));
        $this->set('approved', $this->Language->find('count', array(
            'conditions' => array(
                'Language.is_active = ' => 1
            )
        )));
        $moreActions = $this->Language->moreActions;
        $this->set(compact('moreActions'));
        $this->set('pageTitle', $this->pageTitle);
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Language');
        if (!empty($this->data)) {
            $this->Language->create();
            if ($this->Language->save($this->data)) {
                $this->Session->setFlash(__l('Language has been added') , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Language could not be added. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        }
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Language');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->Language->save($this->data)) {
                $this->Session->setFlash(__l('Language  has been updated') , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Language  could not be updated. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->Language->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['Language']['name'];
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
                if ($actionid == ConstMoreAction::Inactive) {
                    $this->{$this->modelClass}->updateAll(array(
                        $this->modelClass . '.is_active' => 0
                    ) , array(
                        $this->modelClass . '.id' => $selectedIds
                    ));
                    $this->Session->setFlash(__l('Checked languages has been inactivated') , 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstMoreAction::Active) {
                    $this->{$this->modelClass}->updateAll(array(
                        $this->modelClass . '.is_active' => 1
                    ) , array(
                        $this->modelClass . '.id' => $selectedIds
                    ));
                    $this->Session->setFlash(__l('Checked languages has been activated') , 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstMoreAction::Delete) {
                    $this->{$this->modelClass}->deleteAll(array(
                        $this->modelClass . '.id' => $selectedIds
                    ));
                    $this->Session->setFlash(__l('Checked languages has been deleted') , 'default', array('lib' => __l('Success')), 'success');
                }
            }
        }
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect(Router::url('/', true) . $r);
        } else {
            $this->redirect($r);
        }
    }
    function change_language()
    {
        if (!empty($this->data)) {
            if ($this->Auth->user('id')) {
                $this->Cookie->write('user_language', $this->data['Language']['language_id'], false);
            } else {
                $this->Cookie->write('user_language', $this->data['Language']['language_id'], false, time() +60*60*4);
            }
            $this->redirect(Router::url('/', true) . $this->data['Language']['r']);
        } else {
            $this->redirect(Router::url('/', true) . $this->params['named']['city']);
        }
    }
}
?>