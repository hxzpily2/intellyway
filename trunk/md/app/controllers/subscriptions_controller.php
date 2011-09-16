<?php
class SubscriptionsController extends AppController
{
    var $name = 'Subscriptions';
    var $uses = array(
        'Subscription',
        'User',
        'DealCategory',
        'MailChimpList'
    );
    function beforeFilter()
    {
        if (!$this->User->isAllowed($this->Auth->user('user_type_id'))) {
            $this->cakeError('error404');
        }
        parent::beforeFilter();
    }
    function add()
    {
        $this->pageTitle = __l('Add Subscription');
		$Currentstep = 1;
        if (Configure::read('site.enable_three_step_subscription') && !$this->Auth->user('id') && empty($this->layoutPath)) {
            $this->layout = 'subscriptions';
        }
        if (!empty($this->data)) {
            $subscription = $this->Subscription->find('first', array(
                'conditions' => array(
                    'Subscription.email' => $this->data['Subscription']['email'],
                    'Subscription.city_id' => $this->data['Subscription']['city_id']
                ) ,
                'fields' => array(
                    'Subscription.id',
                    'Subscription.is_subscribed'
                ) ,
                'recursive' => -1
            ));
            if (!empty($this->data['Subscription']['city_id'])) {
                $get_city = $this->Subscription->City->find('first', array(
                    'conditions' => array(
                        'City.id' => $this->data['Subscription']['city_id']
                    ) ,
                    'recursive' => -1
                ));
            }
            $this->data['Subscription']['user_id'] = $this->Auth->user('id');
            if (empty($subscription)) {
                $this->Subscription->create();
                if ($this->Subscription->save($this->data)) {
					// Saving record in MailChimp Server //
					if(Configure::read('mailchimp.is_enabled') == 1){
						$city_list_id = $this->MailChimpList->find('first', array(
							'conditions' => array(
								'MailChimpList.city_id' => $this->data['Subscription']['city_id']
							) ,
							'fields' => array(
								'MailChimpList.list_id'
							)
						));
						include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'MCAPI.class.php');
						include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'config.inc.php');
						$api = new MCAPI(Configure::read('mailchimp.api_key'));
						$email = $this->data['Subscription']['email'];
						$unsub_link = Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
							'controller' => 'subscriptions',
							'action' => 'unsubscribe',
							$this->Subscription->getLastInsertId(),
							'admin' => false
						) , false) , 1);
						$merge_vars = array('UNSUBSCRIB'=>$unsub_link);
						$retval = $api->listSubscribe( $city_list_id['MailChimpList']['list_id'], $email, $merge_vars, 'html', false);
						$retval = $api->listUpdateMember($city_list_id['MailChimpList']['list_id'], $email, $merge_vars, 'html', false);
					}
					// END OF MAIL CHIMP SAVING //
                    $city = $this->Subscription->City->find('first', array(
                        'conditions' => array(
                            'City.id' => $this->data['Subscription']['city_id']
                        ) ,
                        'recursive' => -1
                    ));
                    App::import('Model', 'EmailTemplate');
                    $this->EmailTemplate = &new EmailTemplate();
                    App::import('Component', 'Email');
                    $this->Email = &new EmailComponent();
					$language_code = $this->Subscription->getUserLanguageIso($this->Auth->user('id'));
					$template = $this->EmailTemplate->selectTemplate('Subscription Welcome Mail', $language_code);
                    $emailFindReplace = array(
                        '##FROM_EMAIL##' => $this->Subscription->changeFromEmail(Configure::read('EmailTemplate.from_email')) ,
                        '##SITE_LINK##' => Router::url('/', true) ,
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##FROM_EMAIL##' => ($template['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $template['from'],
                        '##LEARN_HOW_LINK##' => Router::url(array(
                            'controller' => 'pages',
                            'action' => 'view',
                            'whitelist'
                        ) , true) ,
                        '##REFERRAL_AMOUNT##' => Configure::read('site.currency') . Configure::read('user.referral_amount') ,
                        '##REFER_FRIEND_LINK##' => Router::url(array(
                            'controller' => 'pages',
                            'action' => 'refer_a_friend',
                        ) , true) ,
                        '##FACEBOOK_LINK##' => ($city['City']['facebook_url']) ? $city['City']['facebook_url'] : Configure::read('facebook.site_facebook_url') ,
                        '##TWITTER_LINK##' => ($city['City']['twitter_url']) ? $city['City']['twitter_url'] : Configure::read('twitter.site_twitter_url') ,
                        '##RECENT_DEALS##' => Router::url(array(
                            'controller' => 'deals',
                            'action' => 'index',
                            'admin' => false,
                            'type' => 'recent'
                        ) , true) ,
                        '##CONTACT_US_LINK##' => Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add',
                            'admin' => false
                        ) , true) ,
                        '##SITE_LOGO##' => Router::url(array(
                            'controller' => 'img',
                            'action' => 'blue-theme',
                            'logo-email.png',
                            'admin' => false
                        ) , true) ,
                        '##UNSUBSCRIBE_LINK##' => Router::url(array(
                            'controller' => 'subscriptions',
                            'action' => 'unsubscribe',
                            $this->Subscription->getLastInsertId() ,
                            'admin' => false
                        ) , true) ,
                        '##CONTACT_URL##' => Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add',
                            'city' => $this->params['named']['city'],
                            'admin' => false
                        ) , true) ,
                    );
                    $this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $template['from'];
                    $this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $template['reply_to'];
                    $this->Email->to = $this->data['Subscription']['email'];
                    $this->Email->subject = strtr($template['subject'], $emailFindReplace);
                    $this->Email->content = strtr($template['email_content'], $emailFindReplace);
                    $this->Email->sendAs = ($template['is_html']) ? 'html' : 'text';
                    $this->Email->send($this->Email->content);
                    $this->Session->setFlash(__l('You are now subscribed to') . ' ' . Configure::read('site.name') . ' ' . $get_city['City']['name'] . '.', 'default', array('lib' => __l('Success')), 'success');
                } else {
					$Currentstep = 2;
                    if (empty($this->Subscription->validationErrors)) {
                        $this->Session->setFlash(__l('You\'ll start receiving your emails soon.') , 'default', array('lib' => __l('Success')), 'success');
                    } else {
                        $this->Session->setFlash(__l('Could not be subscribed. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
                    }
                }
            } elseif (!empty($subscription) && !$subscription['Subscription']['is_subscribed']) {
                $this->data['Subscription']['is_subscribed'] = 1;
                $this->data['Subscription']['id'] = $subscription['Subscription']['id'];
                $this->Subscription->save($this->data);
                $this->Session->setFlash(__l('You are now subscribed to') . ' ' . Configure::read('site.name') . ' ' . $get_city['City']['name'] . '. ' . __l('Thanks for subscribing again.') , 'default', array('lib' => __l('Success')), 'success');
            } else {
                $this->Session->setFlash(__l('You\'ll start receiving your emails soon.') , 'default', array('lib' => __l('Success')), 'success');
            }
            if (empty($this->Subscription->validationErrors) && Configure::read('site.enable_three_step_subscription')) {
                $this->Cookie->write('is_subscribed', 1, false); // For skipping subscriptions
                $check_deal_exist = $this->Subscription->User->DealUser->Deal->find('first', array(
                    'conditions' => array(
                        'Deal.deal_status_id' => array(
                            ConstDealStatus::Open,
                            ConstDealStatus::Tipped,
                        ) ,
                        'city_id' => $get_city['City']['id']
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($check_deal_exist)) {
                    $this->redirect(array(
                        'controller' => 'deals',
                        'action' => 'index',
                        'city' => $get_city['City']['slug']
                    ));
                } else {
                    $this->redirect(array(
                        'controller' => 'page',
                        'action' => 'view',
						'city' => $get_city['City']['slug'],
                        'learn'
                    ));
                }
            }
        } else {
            $city = $this->Subscription->City->find('first', array(
                'conditions' => array(
                    'City.slug' => $this->params['named']['city']
                ) ,
                'fields' => array(
                    'City.id'
                ) ,
                'recursive' => -1
            ));
            $this->data['Subscription']['city_id'] = $city['City']['id'];
        }
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Company) {
            $company = $this->Subscription->User->Company->find('first', array(
                'conditions' => array(
                    'Company.user_id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            $this->set('company', $company);
        }
        $cities = $this->Subscription->City->find('list', array(
            'conditions' => array(
                'City.is_approved =' => 1
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
        $deal_categories = $this->DealCategory->find('list', array(
            'order' => array(
                'DealCategory.name' => 'asc'
            )
        ));
        $this->set(compact('cities'));
        $selected = array_keys($deal_categories);
        $this->set('options', $deal_categories);
        $this->set('Currentstep', $Currentstep);
        $this->set('selected', $selected);
        $this->set('pageTitle', __l('Deal of the Day'));
    }
	function admin_update_subscribers(){
		$this->Subscription->_updateSubscribersList();
		$this->Session->setFlash(__l('Subscribers list has been updated.') , 'default', array('lib' => __l('Success')), 'success');
		$this->redirect(array(
			'action' => 'index'
		));
	}
	function skip(){
		$this->Cookie->write('is_subscribed', 1, false); // For skipping subscriptions
		$this->redirect(array(
			'controller' => 'deals',
			'action' => 'index'
		));
	}
    function unsubscribe($id = null)
    {
        $this->pageTitle = __l('Unsubscribe');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            $subscription = $this->Subscription->find('first', array(
                'conditions' => array(
                    'Subscription.id' => $this->data['Subscription']['id']
                ) ,
                'fields' => array(
                    'Subscription.id'
                ) ,
                'recursive' => -1
            ));
            if (empty($subscription)) {
                $this->Session->setFlash(__l('Please provide a subscribed email') , 'default', array('lib' => __l('Error')), 'error');
            } else {
                $this->data['Subscription']['is_subscribed'] = 0;
                if ($this->Subscription->save($this->data)) {
					if(Configure::read('mailchimp.is_enabled') == 1){
						//unsubscribe the email in mail chimp
						$city_list_id = $this->MailChimpList->find('first', array(
							'conditions' => array(
								'MailChimpList.city_id' => $subscription['Subscription']['city_id']
							) ,
							'fields' => array(
								'MailChimpList.list_id'
							)
						));
						include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'MCAPI.class.php');
						include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'config.inc.php');
						$api = new MCAPI(Configure::read('mailchimp.api_key'));
						$retval = $api->listUnsubscribe($city_list_id['MailChimpList']['list_id'],$subscription['Subscription']['email']);
                    }
                    $this->Session->setFlash(__l('You have unsubscribed from the subscribers list') , 'default', array('lib' => __l('Success')), 'success');
                    $this->redirect(array(
                        'controller' => 'deals',
                        'action' => 'index'
                    ));
                }
            }
        } else {
            $this->data['Subscription']['id'] = $id;
        }
    }
	function unsubscribe_mailchimp()
    {
       $this->pageTitle = __l('Unsubscribe');
	   if(!empty($this->params['named']['sub_city']) && !empty($this->params['named']['email'])){
			$city = $this->Subscription->City->find('first', array(
				'conditions' => array(
					'City.slug' => $this->params['named']['sub_city'],
				),
				'recursive' => -1
			));
			$get_subscriber = $this->Subscription->find('first', array(
				'conditions' => array(
					'Subscription.email' => $this->params['named']['email'],
				),
				'recursive' => -1
			));
			if(!empty($get_subscriber)){		
				$this->Subscription->updateAll(array(
					'Subscription.is_subscribed' => 0
				) , array(
					'Subscription.id' => $get_subscriber['Subscription']['id'],
				));
				if(Configure::read('mailchimp.is_enabled') == 1){
					//unsubscribe the email in mail chimp
					$city_list_id = $this->MailChimpList->find('first', array(
						'conditions' => array(
							'MailChimpList.city_id' => $city['City']['id']
						) ,
						'fields' => array(
							'MailChimpList.list_id'
						)
					));
					include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'MCAPI.class.php');
					include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'config.inc.php');
					$api = new MCAPI(Configure::read('mailchimp.api_key'));
					$retval = $api->listUnsubscribe($city_list_id['MailChimpList']['list_id'], $this->params['named']['email']);
				}
				$this->Session->setFlash(__l('You have unsubscribed from the subscribers list.') , 'default', array('lib' => __l('Success')), 'success');
				$this->redirect(array(
					'controller' => 'deals',
					'action' => 'index'
				));
			}
	   }
		$this->redirect(array(
			'controller' => 'deals',
			'action' => 'index'
		));
    }
    function admin_index()
    {
		$this->_redirectGET2Named(array(
			'q'
		));
		$this->pageTitle = __l('Subscriptions');
            
            $conditions = array();
            $param_string = '';
            $param_string.= !empty($this->params['named']['type']) ? '/type:' . $this->params['named']['type'] : $param_string;
            if (!empty($this->data['Subscription']['type'])) {
                $this->params['named']['type'] = $this->data['Subscription']['type'];
            }
            if (empty($this->data['Subscription']['q']) && !empty($this->params['named']['q'])) {
                $this->data['Subscription']['q'] = $this->params['named']['q'];
            }
            if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'subscribed') {
                $this->data['Subscription']['type'] = $this->params['named']['type'];
                $conditions['Subscription.is_subscribed'] = 1;
                $this->pageTitle = __l('Subscribed Users');
            } elseif (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'unsubscribed') {
                $this->data['Subscription']['type'] = $this->params['named']['type'];
                $conditions['Subscription.is_subscribed'] = 0;
                $this->pageTitle = __l('Unsubscribed Users');
            }
            if (isset($this->data['Subscription']['q']) && !empty($this->data['Subscription']['q'])) {
                $this->params['named']['q'] = $this->data['Subscription']['q'];
                $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->data['Subscription']['q']);
            }
            // Citywise admin filter //
            $city_filter_id = $this->Session->read('city_filter_id');
            if (!empty($city_filter_id)) {
                $conditions['Subscription.city_id'] = $city_filter_id;
            }
        if ($this->RequestHandler->prefers('csv')) {
			Configure::write('debug', 0);
            $this->set('SubscriptionObj', $this);
            $this->set('conditions', $conditions);
			
            if (isset($this->params['named']['q'])) {
                $this->set('q', $this->params['named']['q']);
            }
            $this->set('contain', $contain);
        } else {
            $this->Subscription->recursive = 0;
            $this->paginate = array(
                'conditions' => $conditions,
				'contain' => array(
						'User' => array('fields' => array('User.email', 'User.id', 'User.username',),),
						'City',
					),
				'recursive' => 1,
                'order' => array(
                    'Subscription.id' => 'desc'
                ) ,
            );
            $export_subscriptions = $this->Subscription->find('all', array(
                'conditions' => $conditions,
                'recursive' => -1
            ));
            if (!empty($export_subscriptions)) {
                $ids = array();
                foreach($export_subscriptions as $export_subscription) {
                    $ids[] = $export_subscription['Subscription']['id'];
                }
                $hash = $this->Subscription->getIdHash(implode(',', $ids));
                $_SESSION['export_subscriptions'][$hash] = $ids;
                $this->set('export_hash', $hash);
            }
            if (!empty($this->data['Subscription']['q'])) {
                $this->paginate['search'] = $this->data['Subscription']['q'];
            }
            $this->set('subscriptions', $this->paginate());
            // Citywise admin filter //
            $count_conditions = array();
            if (!empty($city_filter_id)) {
                $count_conditions['Subscription.city_id'] = $city_filter_id;
            }
            $this->set('subscribed', $this->Subscription->find('count', array(
                'conditions' => array_merge(array(
                    'Subscription.is_subscribed' => 1,
                ) , $count_conditions) ,
                'recursive' => 0
            )));
            $this->set('unsubscribed', $this->Subscription->find('count', array(
                'conditions' => array_merge(array(
                    'Subscription.is_subscribed' => 0,
                ) , $count_conditions) ,
                'recursive' => 0
            )));
            $this->set('pageTitle', $this->pageTitle);
            $moreActions = $this->Subscription->moreActions;
            if (!empty($this->params['named']['type']) && ($this->params['named']['type'] == 'unsubscribed')) {
                unset($moreActions[ConstMoreAction::UnSubscripe]);
            }
            $this->set(compact('moreActions'));
            $this->set('param_string', $param_string);
        }
    }
    function admin_update()
    {
        $this->autoRender = false;
        if (!empty($this->data['Subscription'])) {
            $r = $this->data[$this->modelClass]['r'];
            $actionid = $this->data[$this->modelClass]['more_action_id'];
            unset($this->data[$this->modelClass]['r']);
            unset($this->data[$this->modelClass]['more_action_id']);
            $userIds = array();
            foreach($this->data['Subscription'] as $subscription_id => $is_checked) {
                if ($is_checked['id']) {
                    $subscriptionIds[] = $subscription_id;
                }
            }
            if ($actionid && !empty($subscriptionIds)) {
                if ($actionid == ConstMoreAction::Delete) {
                    $this->Subscription->deleteAll(array(
                        'Subscription.id' => $subscriptionIds
                    ));
                    $this->Session->setFlash(__l('Checked subscriptions has been deleted') , 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstMoreAction::UnSubscripe) {
                    $this->Subscription->updateAll(array(
                        'Subscription.is_subscribed' => 0,
                    ) , array(
                        'Subscription.id' => $subscriptionIds
                    ));
                    $this->Session->setFlash(__l('Checked subscriptions has been un subscribed') , 'default', array('lib' => __l('Success')), 'success');
                }
            }
        }
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect(Router::url('/', true) . $r);
        } else {
            $this->redirect($r);
        }
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->Subscription->del($id)) {
            $this->Session->setFlash(__l('Subscription deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
	
}
?>