<?php
class BusinessSuggestionsController extends AppController
{
    var $name = 'BusinessSuggestions';
    function add()
    {
        $this->pageTitle = __l('Suggest a Business');
        if (!empty($this->data)) {
            if ($this->Auth->user('id')) {
                $this->data['BusinessSuggestion']['user_id'] = $this->Auth->user('id');
            }
            $this->BusinessSuggestion->create();
            if ($this->BusinessSuggestion->save($this->data)) {
                $this->Session->setFlash(__l('Suggestion has been sent') , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'controller' => 'deals',
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Suggestion could not be sent. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        }
        if ($this->Auth->user('id')) {
            $this->data['BusinessSuggestion']['email'] = $this->Auth->user('email');
        }
    }
    function admin_index()
    {
        $this->pageTitle = __l('Business Suggestions');
        $conditions = array();
        $this->paginate = array(
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.user_type_id',
                        'User.username',
                        'User.id',
                    ) ,
                    'UserAvatar'
                ) ,
            ) ,
            'recursive' => 1,
            'order' => 'BusinessSuggestion.id desc'
        );
        $this->set('businessSuggestions', $this->paginate());
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $businessSuggestion = $this->BusinessSuggestion->find('first', array(
            'conditions' => array(
                'BusinessSuggestion.id' => $id,
            ) ,
            'recursive' => -1
        ));
        if (!empty($businessSuggestion['BusinessSuggestion']['id']) && $this->BusinessSuggestion->del($businessSuggestion['BusinessSuggestion']['id'])) {
            $this->Session->setFlash(__l('Business suggestion deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
}
?>