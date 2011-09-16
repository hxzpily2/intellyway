<?php
class UserEducationsController extends AppController
{
    var $name = 'UserEducations';
    function index() 
    {
        $this->pageTitle = __l('User Educations');
        $this->UserEducation->recursive = 0;
        $this->set('userEducations', $this->paginate());
    }
    function view($id = null) 
    {
        $this->pageTitle = __l('User Education');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $userEducation = $this->UserEducation->find('first', array(
            'conditions' => array(
                'UserEducation.id = ' => $id
            ) ,
            'fields' => array(
                'UserEducation.id',
                'UserEducation.created',
                'UserEducation.modified',
                'UserEducation.education',
                'UserEducation.is_active',
            ) ,
            'recursive' => -1,
        ));
        if (empty($userEducation)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $userEducation['UserEducation']['id'];
        $this->set('userEducation', $userEducation);
    }
    function add() 
    {
        $this->pageTitle = __l('Add User Education');
        if (!empty($this->data)) {
            $this->UserEducation->create();
            if ($this->UserEducation->save($this->data)) {
                $this->Session->setFlash(__l('User Education has been added') , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('User Education could not be added. Please, try again.'), 'default', array('lib' => __l('Error')), 'error');
            }
        }
    }
    function edit($id = null) 
    {
        $this->pageTitle = __l('Edit User Education');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->UserEducation->save($this->data)) {
                $this->Session->setFlash(__l('User Education has been updated'), 'default', array('lib' => __l('Success')), 'success');
            } else {
                $this->Session->setFlash(__l('User Education could not be updated. Please, try again.'), 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->UserEducation->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['UserEducation']['id'];
    }
    function delete($id = null) 
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->UserEducation->del($id)) {
            $this->Session->setFlash(__l('User Education deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function admin_index() 
    {
        $this->pageTitle = __l('User Educations');
        $this->UserEducation->recursive = 0;
        $this->set('userEducations', $this->paginate());
    }
    function admin_view($id = null) 
    {
        $this->pageTitle = __l('User Education');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $userEducation = $this->UserEducation->find('first', array(
            'conditions' => array(
                'UserEducation.id = ' => $id
            ) ,
            'fields' => array(
                'UserEducation.id',
                'UserEducation.created',
                'UserEducation.modified',
                'UserEducation.education',
                'UserEducation.is_active',
            ) ,
            'recursive' => -1,
        ));
        if (empty($userEducation)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $userEducation['UserEducation']['id'];
        $this->set('userEducation', $userEducation);
    }
    function admin_add() 
    {
        $this->pageTitle = __l('Add User Education');
        if (!empty($this->data)) {
            $this->UserEducation->create();
            if ($this->UserEducation->save($this->data)) {
                $this->Session->setFlash(__l('User Education has been added') , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('User Education could not be added. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        }
    }
    function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Edit User Education');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->UserEducation->save($this->data)) {
                $this->Session->setFlash(__l('User Education has been updated') , 'default', array('lib' => __l('Success')), 'success');
				$this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('User Education could not be updated. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->UserEducation->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['UserEducation']['id'];
    }
    function admin_delete($id = null) 
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->UserEducation->del($id)) {
            $this->Session->setFlash(__l('User Education deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
}
?>