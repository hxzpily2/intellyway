<?php
class UserPaymentProfilesController extends AppController
{
    var $name = 'UserPaymentProfiles';
	function beforeFilter()
    {
        if (!$this->UserPaymentProfile->isAuthorizeNetEnabled()) {
            $this->cakeError('error404');
        }
        parent::beforeFilter();
    }
    function index()
    {
        $this->pageTitle = __l('Credit Cards');
        $this->paginate = array(
            'conditions' => array(
                'UserPaymentProfile.user_id' => $this->Auth->user('id')
            ) ,
            'recursive' => 1,
            'order' => array(
                'UserPaymentProfile.id' => 'desc'
            )
        );
		// <-- For iPhone App code 
		if ($this->RequestHandler->prefers('json')) {
            $this->view = 'Json';
            $this->set('json', (empty($this->viewVars['iphone_response'])) ? $this->paginate() : $this->viewVars['iphone_response']);
        }else{
			$this->set('userPaymentProfiles', $this->paginate());
		}
		// For iPhone App code -->        
    }
    function add()
    {
        $this->pageTitle = __l('Add New Credit Card');
        if (!empty($this->data)) {
		    $user = $this->UserPaymentProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->Auth->user('id')
                ) ,
                'fields' => array(
                    'User.id',
                    'User.cim_profile_id'
                )
            ));
            $data = $this->data['UserPaymentProfile'];
            $data['expirationDate'] = $this->data['UserPaymentProfile']['expDateYear']['year'] . '-' . $this->data['UserPaymentProfile']['expDateMonth']['month'];
            $data['customerProfileId'] = $user['User']['cim_profile_id'];
			$check_expire = $this->UserPaymentProfile->_checkExpiryMonthAndYear($this->data['UserPaymentProfile']['expDateMonth']['month'], $this->data['UserPaymentProfile']['expDateYear']['year']);
			if(empty($check_expire)){
				$payment_profile_id = $this->UserPaymentProfile->User->_createCimPaymentProfile($data);
				if (is_array($payment_profile_id) && !empty($payment_profile_id['payment_profile_id']) && !empty($payment_profile_id['masked_cc'])) {
					$payment['UserPaymentProfile']['user_id'] = $this->Auth->user('id');
					$payment['UserPaymentProfile']['cim_payment_profile_id'] = $payment_profile_id['payment_profile_id'];
					$payment['UserPaymentProfile']['masked_cc'] = $payment_profile_id['masked_cc'];
					$this->UserPaymentProfile->save($payment, false);
					// <-- For iPhone App code 
					if ($this->RequestHandler->prefers('json')) {
						$resonse = array(
							'status' => 0,
							'message' => __l('Success')
						);						
					}else{
						$this->redirect(array(
							'controller' => 'user_payment_profiles',
							'action' => 'index'
						));
					}
					// For iPhone App code --> 					
				} else {
					$this->Session->setFlash(sprintf(__l('Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.'), $payment_profile_id['message']), 'default', array('lib' => __l('Error')), 'error');
					// <-- For iPhone App code 
					if ($this->RequestHandler->prefers('json')) {
						$resonse = array(
							'status' => 1,
							'message' => sprintf(__l('Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.'), $payment_profile_id['message'])
						);
					}
					// For iPhone App code --> 	
				}
			}else{
				$this->Session->setFlash(__l('Invalid expire date'), 'default', array('lib' => __l('Error')), 'error');		
				// <-- For iPhone App code 
				if ($this->RequestHandler->prefers('json')) {
					$resonse = array(
						'status' => 2,
						'message' => __l('Invalid expire date')
					);
				}
				// For iPhone App code --> 
			}
        }
        $credit_card_types = array(
            'Visa' => __l('Visa') ,
            'MasterCard' => __l('MasterCard') ,
            'Discover' => __l('Discover') ,
            'Amex' => __l('Amex')
        );
        $this->set('credit_card_types', $credit_card_types);
        $this->set('user_id', $this->Auth->user('id'));
        $countries = $this->UserPaymentProfile->User->UserProfile->Country->find('list', array(
            'fields' => array(
                'Country.iso2',
                'Country.name'
            ) ,
            'conditions' => array(
                'Country.iso2 != ' => '',
            ) ,
            'order' => array(
                'Country.name' => 'asc'
            ) ,
        ));
        $this->set('countries', $countries);
		$this->data['UserPaymentProfile']['cvv2Number'] = $this->data['UserPaymentProfile']['creditCardNumber'] = '';
		$states = $this->UserPaymentProfile->User->UserProfile->State->find('list', array(
            'conditions' => array(
                'State.is_approved =' => 1
            ) ,
            'fields' => array(
                'State.code',
                'State.name'
            ) ,
            'order' => array(
                'State.name' => 'asc'
            )
        ));    
		$this->set('states', $states);
		// <-- For iPhone App code 
		if ($this->RequestHandler->prefers('json')) {						
			$this->view = 'Json';
			$this->set('json', (empty($this->viewVars['iphone_response'])) ? $resonse : $this->viewVars['iphone_response']);
		}
		// For iPhone App code --> 
    }
    function edit($id)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $this->pageTitle = __l('Edit Credit Card');
        $user = $this->UserPaymentProfile->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'User.id',
                'User.cim_profile_id'
            )
        ));
        $userPaymentProfile = $this->UserPaymentProfile->find('first', array(
            'conditions' => array(
                'UserPaymentProfile.id' => $id
            ) ,
            'recursive' => -1
        ));
        if (empty($userPaymentProfile)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
			$check_expire = $this->UserPaymentProfile->_checkExpiryMonthAndYear($this->data['UserPaymentProfile']['expDateMonth']['month'], $this->data['UserPaymentProfile']['expDateYear']['year']);
			if(empty($check_expire)){
				$data = $this->data['UserPaymentProfile'];
				$data['expirationDate'] = $this->data['UserPaymentProfile']['expDateYear']['year'] . '-' . $this->data['UserPaymentProfile']['expDateMonth']['month'];
				$data['customerProfileId'] = $user['User']['cim_profile_id'];
				$data['customerPaymentProfileId'] = $userPaymentProfile['UserPaymentProfile']['cim_payment_profile_id'];
				$payment_profile_id = $this->UserPaymentProfile->User->_updateCimPaymentProfile($data);
				if (!is_array($payment_profile_id)) {
					$this->Session->setFlash(__l('Credit card has been updated.') , 'default', array('lib' => __l('Success')), 'success');
					$this->redirect(array(
						'controller' => 'user_payment_profiles',
						'action' => 'index'
					));
				} else {
					$this->Session->setFlash(sprintf(__l('Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.'), $payment_profile_id['message']), 'default', array('lib' => __l('Error')), 'error');
				}
			} else {
				$this->Session->setFlash(__l('Invalid expire date'), 'default', array('lib' => __l('Error')), 'error');
			}
        } else {
            $data['customerProfileId'] = $user['User']['cim_profile_id'];
            $data['customerPaymentProfileId'] = $userPaymentProfile['UserPaymentProfile']['cim_payment_profile_id'];
            $credit_info = $this->UserPaymentProfile->User->_getCimPaymentProfile($data);
            $this->data['UserPaymentProfile'] = $credit_info;
            $this->data['UserPaymentProfile']['id'] = $id;
            $this->data['UserPaymentProfile']['cvv2Number'] = 'XXX';
        }
        $credit_card_types = array(
            'Visa' => __l('Visa') ,
            'MasterCard' => __l('MasterCard') ,
            'Discover' => __l('Discover') ,
            'Amex' => __l('Amex')
        );
        $this->set('credit_card_types', $credit_card_types);
        $this->set('user_id', $this->Auth->user('id'));
        $countries = $this->UserPaymentProfile->User->UserProfile->Country->find('list', array(
            'fields' => array(
                'Country.iso2',
                'Country.name'
            ) ,
            'order' => array(
                'Country.name' => 'asc'
            ) ,
        ));
        $this->set('countries', $countries);
		$states = $this->UserPaymentProfile->User->UserProfile->State->find('list', array(
            'conditions' => array(
                'State.is_approved =' => 1
            ) ,
            'fields' => array(
                'State.code',
                'State.name'
            ) ,
            'order' => array(
                'State.name' => 'asc'
            )
        ));    
		$this->set('states', $states);
		$this->data['UserPaymentProfile']['cvv2Number'] = $this->data['UserPaymentProfile']['creditCardNumber'] = '';
    }
    function delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $userPaymentProfile = $this->UserPaymentProfile->find('first', array(
            'conditions' => array(
                'UserPaymentProfile.id' => $id
            ) ,
            'recursive' => -1
        ));
        $user = $this->UserPaymentProfile->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'User.id',
                'User.cim_profile_id'
            )
        ));
        $data['customerProfileId'] = $user['User']['cim_profile_id'];
        $data['customerPaymentProfileId'] = $userPaymentProfile['UserPaymentProfile']['cim_payment_profile_id'];
        if ($this->UserPaymentProfile->User->_deleteCimPaymentProfile($data)) {
            if ($this->UserPaymentProfile->del($userPaymentProfile['UserPaymentProfile']['id'])) {
                $this->Session->setFlash(__l('Credit card deleted') , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'my_stuff#Credit_Cards'
                ));
            } else {
                $this->cakeError('error404');
            }
        } else {
            $this->Session->setFlash(__l('Credit card could not be deleted. Please, try again.'), 'default', array('lib' => __l('Error')), 'error');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'my_stuff#Credit_Cards'
            ));
        }
    }
    function update($id)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $this->UserPaymentProfile->updateAll(array(
            'UserPaymentProfile.is_default' => 0
        ) , array(
            'UserPaymentProfile.user_id' => $this->Auth->user('id')
        ));
        $this->UserPaymentProfile->updateAll(array(
            'UserPaymentProfile.is_default' => 1
        ) , array(
            'UserPaymentProfile.id' => $id
        ));
        $this->Session->setFlash(__l('Credit card set as default successfully') , 'default', array('lib' => __l('Success')), 'success');
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'my_stuff#Credit_Cards'
        ));
    }
}
?>