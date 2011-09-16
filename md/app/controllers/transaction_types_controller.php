<?php
class TransactionTypesController extends AppController
{
    var $name = 'TransactionTypes';
    function admin_index()
    {
        $this->pageTitle = __l('Transaction Types');
        $this->TransactionType->recursive = 0;
        $this->set('transactionTypes', $this->paginate());
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Transaction Type');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->TransactionType->save($this->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Transaction Type has been updated') , $this->data['TransactionType']['name']) , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Transaction Type could not be updated. Please, try again.') , $this->data['TransactionType']['name']) , 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->TransactionType->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['TransactionType']['name'];
    }
}
?>