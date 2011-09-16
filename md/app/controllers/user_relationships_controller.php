<?php
class UserRelationshipsController extends AppController
{
    var $name = 'UserRelationships';
    function index() 
    {
        $this->pageTitle = __l('User Relationships');
        $this->UserRelationship->recursive = 0;
        $this->set('userRelationships', $this->paginate());
    }
    function view($id = null) 
    {
        $this->pageTitle = __l('User Relationship');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $userRelationship = $this->UserRelationship->find('first', array(
            'conditions' => array(
                'UserRelationship.id = ' => $id
            ) ,
            'fields' => array(
                'UserRelationship.id',
                'UserRelationship.created',
                'UserRelationship.modified',
                'UserRelationship.relationship',
                'UserRelationship.is_active',
            ) ,
            'recursive' => -1,
        ));
        if (empty($userRelationship)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $userRelationship['UserRelationship']['id'];
        $this->set('userRelationship', $userRelationship);
    }
    function add() 
    {
        $this->pageTitle = __l('Add User Relationship');
        if (!empty($this->data)) {
            $this->UserRelationship->create();
            if ($this->UserRelationship->save($this->data)) {
                $this->Session->setFlash(__l('User Relationship has been added'), 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('User Relationship could not be added. Please, try again.'), 'default', array('lib' => __l('Error')), 'error');
            }
        }
    }
    function edit($id = null) 
    {
        $this->pageTitle = __l('Edit User Relationship');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->UserRelationship->save($this->data)) {
                $this->Session->setFlash(__l('User Relationship has been updated'), 'default', array('lib' => __l('Success')), 'success');
            } else {
                $this->Session->setFlash(__l('User Relationship could not be updated. Please, try again.'), 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->UserRelationship->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['UserRelationship']['id'];
    }
    function delete($id = null) 
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->UserRelationship->del($id)) {
            $this->Session->setFlash(__l('User Relationship deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function admin_index() 
    {
        $this->pageTitle = __l('User Relationships');
        $this->UserRelationship->recursive = 0;
        $this->set('userRelationships', $this->paginate());
    }
    function admin_view($id = null) 
    {
        $this->pageTitle = __l('User Relationship');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $userRelationship = $this->UserRelationship->find('first', array(
            'conditions' => array(
                'UserRelationship.id = ' => $id
            ) ,
            'fields' => array(
                'UserRelationship.id',
                'UserRelationship.created',
                'UserRelationship.modified',
                'UserRelationship.relationship',
                'UserRelationship.is_active',
            ) ,
            'recursive' => -1,
        ));
        if (empty($userRelationship)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $userRelationship['UserRelationship']['id'];
        $this->set('userRelationship', $userRelationship);
    }
    function admin_add() 
    {
        $this->pageTitle = __l('Add User Relationship');
        if (!empty($this->data)) {
            $this->UserRelationship->create();
            if ($this->UserRelationship->save($this->data)) {
                $this->Session->setFlash(__l('User Relationship has been added') , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('User Relationship could not be added. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        }
    }
    function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Edit User Relationship');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->UserRelationship->save($this->data)) {
                $this->Session->setFlash(__l('User Relationship has been updated') , 'default', array('lib' => __l('Success')), 'success');
				$this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('User Relationship could not be updated. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->UserRelationship->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['UserRelationship']['id'];
    }
    function admin_delete($id = null) 
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->UserRelationship->del($id)) {
            $this->Session->setFlash(__l('User Relationship deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
}
?>