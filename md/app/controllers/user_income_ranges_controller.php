<?php
class UserIncomeRangesController extends AppController
{
    var $name = 'UserIncomeRanges';
    function index() 
    {
        $this->pageTitle = __l('User Income Ranges');
        $this->UserIncomeRange->recursive = 0;
        $this->set('userIncomeRanges', $this->paginate());
    }
    function view($id = null) 
    {
        $this->pageTitle = __l('User Income Range');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $userIncomeRange = $this->UserIncomeRange->find('first', array(
            'conditions' => array(
                'UserIncomeRange.id = ' => $id
            ) ,
            'fields' => array(
                'UserIncomeRange.id',
                'UserIncomeRange.created',
                'UserIncomeRange.modified',
                'UserIncomeRange.income',
                'UserIncomeRange.is_active',
            ) ,
            'recursive' => -1,
        ));
        if (empty($userIncomeRange)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $userIncomeRange['UserIncomeRange']['id'];
        $this->set('userIncomeRange', $userIncomeRange);
    }
    function add() 
    {
        $this->pageTitle = __l('Add User Income Range');
        if (!empty($this->data)) {
            $this->UserIncomeRange->create();
            if ($this->UserIncomeRange->save($this->data)) {
                $this->Session->setFlash(__l('User Income Range has been added'), 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('User Income Range could not be added. Please, try again.'), 'default', null, 'error');
            }
        }
    }
    function edit($id = null) 
    {
        $this->pageTitle = __l('Edit User Income Range');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->UserIncomeRange->save($this->data)) {
                $this->Session->setFlash(__l('User Income Range has been updated'), 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('User Income Range could not be updated. Please, try again.'), 'default', null, 'error');
            }
        } else {
            $this->data = $this->UserIncomeRange->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['UserIncomeRange']['id'];
    }
    function delete($id = null) 
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->UserIncomeRange->del($id)) {
            $this->Session->setFlash(__l('User Income Range deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function admin_index() 
    {
        $this->pageTitle = __l('User Income Ranges');
        $this->UserIncomeRange->recursive = 0;
        $this->set('userIncomeRanges', $this->paginate());
    }
    function admin_view($id = null) 
    {
        $this->pageTitle = __l('User Income Range');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $userIncomeRange = $this->UserIncomeRange->find('first', array(
            'conditions' => array(
                'UserIncomeRange.id = ' => $id
            ) ,
            'fields' => array(
                'UserIncomeRange.id',
                'UserIncomeRange.created',
                'UserIncomeRange.modified',
                'UserIncomeRange.income',
                'UserIncomeRange.is_active',
            ) ,
            'recursive' => -1,
        ));
        if (empty($userIncomeRange)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $userIncomeRange['UserIncomeRange']['id'];
        $this->set('userIncomeRange', $userIncomeRange);
    }
    function admin_add() 
    {
        $this->pageTitle = __l('Add User Income Range');
        if (!empty($this->data)) {
            $this->UserIncomeRange->create();
            if ($this->UserIncomeRange->save($this->data)) {
                $this->Session->setFlash(__l('User Income Range has been added'), 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('User Income Range could not be added. Please, try again.'), 'default', null, 'error');
            }
        }
    }
    function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Edit User Income Range');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->UserIncomeRange->save($this->data)) {
                $this->Session->setFlash(__l('User Income Range has been updated'), 'default', null, 'success');
				$this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('User Income Range could not be updated. Please, try again.'), 'default', null, 'error');
            }
        } else {
            $this->data = $this->UserIncomeRange->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['UserIncomeRange']['id'];
    }
    function admin_delete($id = null) 
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->UserIncomeRange->del($id)) {
            $this->Session->setFlash(__l('User Income Range deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
}
?>