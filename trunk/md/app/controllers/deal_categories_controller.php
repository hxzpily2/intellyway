<?php
class DealCategoriesController extends AppController
{
    var $name = 'DealCategories';
    function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = __l('Deal Subscription Categories');
        $this->DealCategory->recursive = 0;
        if (isset($this->params['named']['q'])) {
            $this->data['DealCategory']['q'] = $this->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->params['named']['q']);
        }
        $this->paginate = array(
            'order' => array(
                'DealCategory.id' => 'desc'
            ) ,
        );
        if (isset($this->data['DealCategory']['q'])) {
            $this->paginate['search'] = $this->data['DealCategory']['q'];
        }
        $this->set('dealCategories', $this->paginate());
        $moreActions = $this->DealCategory->moreActions;
        $this->set(compact('moreActions'));
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Deal Subscription  Category');
        if (!empty($this->data)) {
            $this->DealCategory->create();
            if ($this->DealCategory->save($this->data)) {
                $this->Session->setFlash(__l('Deal subscription category has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Deal subscription category could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $subscriptions = $this->DealCategory->Subscription->find('list');
        $this->set(compact('subscriptions'));
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Deal Subscription Category');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->DealCategory->save($this->data)) {
                $this->Session->setFlash(__l('Deal subscription category has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Deal subscription category could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->data = $this->DealCategory->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['DealCategory']['name'];
        $subscriptions = $this->DealCategory->Subscription->find('list');
        $this->set(compact('subscriptions'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->DealCategory->del($id)) {
            $this->Session->setFlash(__l('Deal subscription category deleted') , 'default', null, 'success');
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
                    $this->Session->setFlash(__l('Checked deal subscription categories has been deleted') , 'default', null, 'success');
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