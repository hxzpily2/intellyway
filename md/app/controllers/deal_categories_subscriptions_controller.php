<?php
class DealCategoriesSubscriptionsController extends AppController
{
    var $name = 'DealCategoriesSubscriptions';
    function index()
    {
        $this->pageTitle = __l('Deal Categories Subscriptions');
        $this->DealCategoriesSubscription->recursive = 0;
        $this->set('dealCategoriesSubscriptions', $this->paginate());
    }
    function view($id = null)
    {
        $this->pageTitle = __l('Deal Categories Subscription');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $dealCategoriesSubscription = $this->DealCategoriesSubscription->find('first', array(
            'conditions' => array(
                'DealCategoriesSubscription.id = ' => $id
            ) ,
            'fields' => array(
                'DealCategoriesSubscription.id',
                'DealCategoriesSubscription.deal_category_id',
                'DealCategoriesSubscription.subscription_id',
                'DealCategory.id',
                'DealCategory.created',
                'DealCategory.modified',
                'DealCategory.name',
                'Subscription.id',
                'Subscription.created',
                'Subscription.modified',
                'Subscription.user_id',
                'Subscription.city_id',
                'Subscription.email',
                'Subscription.is_subscribed',
            ) ,
            'recursive' => 0,
        ));
        if (empty($dealCategoriesSubscription)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $dealCategoriesSubscription['DealCategoriesSubscription']['id'];
        $this->set('dealCategoriesSubscription', $dealCategoriesSubscription);
    }
    function add()
    {
        $this->pageTitle = __l('Add Deal Categories Subscription');
        if (!empty($this->data)) {
            $this->DealCategoriesSubscription->create();
            if ($this->DealCategoriesSubscription->save($this->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Deal Categories Subscription has been added') , $this->data['DealCategoriesSubscription']['id']) , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Deal Categories Subscription could not be added. Please, try again.') , $this->data['DealCategoriesSubscription']['id']) , 'default', array('lib' => __l('Error')), 'error');
            }
        }
        $dealCategories = $this->DealCategoriesSubscription->DealCategory->find('list');
        $subscriptions = $this->DealCategoriesSubscription->Subscription->find('list');
        $this->set(compact('dealCategories', 'subscriptions'));
    }
    function edit($id = null)
    {
        $this->pageTitle = __l('Edit Deal Categories Subscription');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->DealCategoriesSubscription->save($this->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Deal Categories Subscription has been updated') , $this->data['DealCategoriesSubscription']['id']) , 'default', array('lib' => __l('Success')), 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Deal Categories Subscription could not be updated. Please, try again.') , $this->data['DealCategoriesSubscription']['id']) , 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->DealCategoriesSubscription->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['DealCategoriesSubscription']['id'];
        $dealCategories = $this->DealCategoriesSubscription->DealCategory->find('list');
        $subscriptions = $this->DealCategoriesSubscription->Subscription->find('list');
        $this->set(compact('dealCategories', 'subscriptions'));
    }
    function delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->DealCategoriesSubscription->del($id)) {
            $this->Session->setFlash(__l('Deal Categories Subscription deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function admin_index()
    {
        $this->pageTitle = __l('Deal Categories Subscriptions');
        $this->DealCategoriesSubscription->recursive = 0;
        $this->set('dealCategoriesSubscriptions', $this->paginate());
    }
    function admin_view($id = null)
    {
        $this->pageTitle = __l('Deal Categories Subscription');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $dealCategoriesSubscription = $this->DealCategoriesSubscription->find('first', array(
            'conditions' => array(
                'DealCategoriesSubscription.id = ' => $id
            ) ,
            'fields' => array(
                'DealCategoriesSubscription.id',
                'DealCategoriesSubscription.deal_category_id',
                'DealCategoriesSubscription.subscription_id',
                'DealCategory.id',
                'DealCategory.created',
                'DealCategory.modified',
                'DealCategory.name',
                'Subscription.id',
                'Subscription.created',
                'Subscription.modified',
                'Subscription.user_id',
                'Subscription.city_id',
                'Subscription.email',
                'Subscription.is_subscribed',
            ) ,
            'recursive' => 0,
        ));
        if (empty($dealCategoriesSubscription)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $dealCategoriesSubscription['DealCategoriesSubscription']['id'];
        $this->set('dealCategoriesSubscription', $dealCategoriesSubscription);
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Deal Categories Subscription');
        if (!empty($this->data)) {
            $this->DealCategoriesSubscription->create();
            if ($this->DealCategoriesSubscription->save($this->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Deal Categories Subscription has been added') , $this->data['DealCategoriesSubscription']['id']) , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Deal Categories Subscription could not be added. Please, try again.') , $this->data['DealCategoriesSubscription']['id']) , 'default', array('lib' => __l('Error')), 'error');
            }
        }
        $dealCategories = $this->DealCategoriesSubscription->DealCategory->find('list');
        $subscriptions = $this->DealCategoriesSubscription->Subscription->find('list');
        $this->set(compact('dealCategories', 'subscriptions'));
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Deal Categories Subscription');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->DealCategoriesSubscription->save($this->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Deal Categories Subscription has been updated') , $this->data['DealCategoriesSubscription']['id']) , 'default', array('lib' => __l('Success')), 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Deal Categories Subscription could not be updated. Please, try again.') , $this->data['DealCategoriesSubscription']['id']) , 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->DealCategoriesSubscription->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['DealCategoriesSubscription']['id'];
        $dealCategories = $this->DealCategoriesSubscription->DealCategory->find('list');
        $subscriptions = $this->DealCategoriesSubscription->Subscription->find('list');
        $this->set(compact('dealCategories', 'subscriptions'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->DealCategoriesSubscription->del($id)) {
            $this->Session->setFlash(__l('Deal Categories Subscription deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
}
?>