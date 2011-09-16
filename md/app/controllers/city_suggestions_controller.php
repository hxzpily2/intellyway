<?php
class CitySuggestionsController extends AppController
{
    var $name = 'CitySuggestions';
    function add()
    {
        $this->pageTitle = __l('Suggest a City');
        if (!empty($this->data)) {
            if ($this->Auth->user('id')) {
                $this->data['CitySuggestion']['user_id'] = $this->Auth->user('id');
            }
            $this->CitySuggestion->create();
            if ($this->CitySuggestion->save($this->data)) {
                $this->Session->setFlash(__l('City Suggestion has been sent') , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(Router::url('/', true));
            } else {
                $this->Session->setFlash(__l('City Suggestion could not be sent. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        }
        if ($this->Auth->user('id')) {
            $this->data['CitySuggestion']['email'] = $this->Auth->user('email');
        }
        $this->data['CitySuggestion']['email'] = $this->Auth->user('email');
    }
    function admin_index()
    {
        $this->pageTitle = __l('City Suggestions');
        if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'recent_suggestion') {
            $conditions = array();
            if (!empty($this->params['named']['name'])) {
                $conditions['CitySuggestion.name'] = $this->params['named']['name'];
            }
            $this->paginate = array(
                'conditions' => array(
                    $conditions,
                ) ,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.user_type_id',
                            'User.username',
                            'User.id',
                        )
                    ) ,
                ) ,
                'recursive' => 0,
                'order' => 'CitySuggestion.id desc'
            );
        } else {
            $this->paginate = array(
                'group' => array(
                    'CitySuggestion.name'
                ) ,
                'fields' => array(
                    'CitySuggestion.name',
                    'Count(CitySuggestion.name) as count',
                ) ,
                'order' => 'count desc',
                'recursive' => -1,
            );
        }
        $this->set('citySuggestions', $this->paginate());
        if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'recent_suggestion') {
            $this->render('city_suggest_index');
        }
    }
}
?>