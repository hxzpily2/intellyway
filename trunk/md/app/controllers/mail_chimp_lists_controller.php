<?php
class MailChimpListsController extends AppController
{
    var $name = 'MailChimpLists';
    function index() 
    {
        $this->pageTitle = __l('Mail Chimp Lists');
        $this->MailChimpList->recursive = 0;
        $this->set('mailChimpLists', $this->paginate());
    }
    function view($id = null) 
    {
        $this->pageTitle = __l('Mail Chimp List');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $mailChimpList = $this->MailChimpList->find('first', array(
            'conditions' => array(
                'MailChimpList.id = ' => $id
            ) ,
            'fields' => array(
                'MailChimpList.id',
                'MailChimpList.created',
                'MailChimpList.modified',
                'MailChimpList.city_id',
                'MailChimpList.list_id',
                'City.id',
                'City.created',
                'City.modified',
                'City.country_id',
                'City.state_id',
                'City.language_id',
                'City.name',
                'City.slug',
                'City.latitude',
                'City.longitude',
                'City.dma_id',
                'City.county',
                'City.code',
                'City.deal_count',
                'City.active_deal_count',
                'City.is_approved',
                'City.fb_user_id',
                'City.fb_access_token',
                'City.twitter_username',
                'City.twitter_password',
                'City.twitter_access_token',
                'City.twitter_access_key',
                'City.twitter_url',
                'City.facebook_url',
            ) ,
            'recursive' => 0,
        ));
        if (empty($mailChimpList)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $mailChimpList['MailChimpList']['id'];
        $this->set('mailChimpList', $mailChimpList);
    }
    function add() 
    {
        $this->pageTitle = __l('Add Mail Chimp List');
        if (!empty($this->data)) {
            $this->MailChimpList->create();
            if ($this->MailChimpList->save($this->data)) {
                $this->Session->setFlash(__l('Mail Chimp List has been added'), 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Mail Chimp List could not be added. Please, try again.'), 'default', null, 'error');
            }
        }
        $cities = $this->MailChimpList->City->find('list');
        $this->set(compact('cities'));
    }
    function edit($id = null) 
    {
        $this->pageTitle = __l('Edit Mail Chimp List');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->MailChimpList->save($this->data)) {
                $this->Session->setFlash(__l('Mail Chimp List has been updated'), 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('Mail Chimp List could not be updated. Please, try again.'), 'default', null, 'error');
            }
        } else {
            $this->data = $this->MailChimpList->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['MailChimpList']['id'];
        $cities = $this->MailChimpList->City->find('list');
        $this->set(compact('cities'));
    }
    function delete($id = null) 
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->MailChimpList->del($id)) {
            $this->Session->setFlash(__l('Mail Chimp List deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function admin_index() 
    {
        $this->pageTitle = __l('Mail Chimp Lists');
        $this->MailChimpList->recursive = 0;
        $this->set('mailChimpLists', $this->paginate());
    }
    function admin_view($id = null) 
    {
        $this->pageTitle = __l('Mail Chimp List');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $mailChimpList = $this->MailChimpList->find('first', array(
            'conditions' => array(
                'MailChimpList.id = ' => $id
            ) ,
            'fields' => array(
                'MailChimpList.id',
                'MailChimpList.created',
                'MailChimpList.modified',
                'MailChimpList.city_id',
                'MailChimpList.list_id',
                'City.id',
                'City.created',
                'City.modified',
                'City.country_id',
                'City.state_id',
                'City.language_id',
                'City.name',
                'City.slug',
                'City.latitude',
                'City.longitude',
                'City.dma_id',
                'City.county',
                'City.code',
                'City.deal_count',
                'City.active_deal_count',
                'City.is_approved',
                'City.fb_user_id',
                'City.fb_access_token',
                'City.twitter_username',
                'City.twitter_password',
                'City.twitter_access_token',
                'City.twitter_access_key',
                'City.twitter_url',
                'City.facebook_url',
            ) ,
            'recursive' => 0,
        ));
        if (empty($mailChimpList)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $mailChimpList['MailChimpList']['id'];
        $this->set('mailChimpList', $mailChimpList);
    }
    function admin_add() 
    {
        $this->pageTitle = __l('Add Mail Chimp List');
        if (!empty($this->data)) {
            $this->MailChimpList->create();
            if ($this->MailChimpList->save($this->data)) {
                $this->Session->setFlash(__l('Mail Chimp List has been added'), 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Mail Chimp List could not be added. Please, try again.'), 'default', null, 'error');
            }
        }
        $cities = $this->MailChimpList->City->find('list');
        $this->set(compact('cities'));
    }
    function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Edit Mail Chimp List');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->MailChimpList->save($this->data)) {
                $this->Session->setFlash(__l('Mail Chimp List has been updated'), 'default', null, 'success');
				$this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Mail Chimp List could not be updated. Please, try again.'), 'default', null, 'error');
            }
        } else {
            $this->data = $this->MailChimpList->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['MailChimpList']['id'];
        $cities = $this->MailChimpList->City->find('list');
        $this->set(compact('cities'));
    }
    function admin_delete($id = null) 
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->MailChimpList->del($id)) {
            $this->Session->setFlash(__l('Mail Chimp List deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
}
?>