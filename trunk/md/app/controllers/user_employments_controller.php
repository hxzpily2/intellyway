<?php
class UserEmploymentsController extends AppController
{
    var $name = 'UserEmployments';
    function index() 
    {
        $this->pageTitle = __l('User Employments');
        $this->UserEmployment->recursive = 0;
        $this->set('userEmployments', $this->paginate());
    }
    function view($id = null) 
    {
        $this->pageTitle = __l('User Employment');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $userEmployment = $this->UserEmployment->find('first', array(
            'conditions' => array(
                'UserEmployment.id = ' => $id
            ) ,
            'fields' => array(
                'UserEmployment.id',
                'UserEmployment.created',
                'UserEmployment.modified',
                'UserEmployment.employment',
                'UserEmployment.is_active',
            ) ,
            'recursive' => -1,
        ));
        if (empty($userEmployment)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $userEmployment['UserEmployment']['id'];
        $this->set('userEmployment', $userEmployment);
    }
    function add() 
    {
        $this->pageTitle = __l('Add User Employment');
        if (!empty($this->data)) {
            $this->UserEmployment->create();
            if ($this->UserEmployment->save($this->data)) {
                $this->Session->setFlash(__l('User Employment has been added'), 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('User Employment could not be added. Please, try again.'), 'default', array('lib' => __l('Error')), 'error');
            }
        }
    }
    function edit($id = null) 
    {
        $this->pageTitle = __l('Edit User Employment');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->UserEmployment->save($this->data)) {
                $this->Session->setFlash(__l('User Employment has been updated'), 'default', array('lib' => __l('Success')), 'success');
            } else {
                $this->Session->setFlash(__l('User Employment could not be updated. Please, try again.'), 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->UserEmployment->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['UserEmployment']['id'];
    }
    function delete($id = null) 
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->UserEmployment->del($id)) {
            $this->Session->setFlash(__l('User Employment deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function admin_index() 
    {
        $this->pageTitle = __l('User Employments');
        $this->UserEmployment->recursive = 0;
        $this->set('userEmployments', $this->paginate());
    }
    function admin_view($id = null) 
    {
        $this->pageTitle = __l('User Employment');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $userEmployment = $this->UserEmployment->find('first', array(
            'conditions' => array(
                'UserEmployment.id = ' => $id
            ) ,
            'fields' => array(
                'UserEmployment.id',
                'UserEmployment.created',
                'UserEmployment.modified',
                'UserEmployment.employment',
                'UserEmployment.is_active',
            ) ,
            'recursive' => -1,
        ));
        if (empty($userEmployment)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $userEmployment['UserEmployment']['id'];
        $this->set('userEmployment', $userEmployment);
    }
    function admin_add() 
    {
        $this->pageTitle = __l('Add User Employment');
        if (!empty($this->data)) {
            $this->UserEmployment->create();
            if ($this->UserEmployment->save($this->data)) {
                $this->Session->setFlash(__l('User Employment has been added'), 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('User Employment could not be added. Please, try again.'), 'default', array('lib' => __l('Error')), 'error');
            }
        }
    }
    function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Edit User Employment');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->UserEmployment->save($this->data)) {
                $this->Session->setFlash(__l('User Employment has been updated'), 'default', array('lib' => __l('Success')), 'success');
				$this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('User Employment could not be updated. Please, try again.'), 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->UserEmployment->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['UserEmployment']['id'];
    }
    function admin_delete($id = null) 
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->UserEmployment->del($id)) {
            $this->Session->setFlash(__l('User Employment deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
}
?>