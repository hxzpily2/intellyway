<?php
class CompaniesController extends AppController
{
    var $name = 'Companies';
    var $components = array(
        'Email',
    );
    var $uses = array(
        'Company',
        'EmailTemplate',
        'Attachment',
    );
    var $helpers = array(
        'Csv',
    );
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'City',
            'State',
            'Company.latitude',
            'Company.longitude',
            'Company.map_zoom_level',
            'UserAvatar.filename',
            'User.id',
            'Company.id',
            'Company.address1',
            'Company.address2',
            'Company.company_profile',
            'Company.country_id',
            'Company.is_company_profile_enabled',
            'Company.name',
            'Company.phone',
            'Company.url',
            'Company.zip',
            'User.UserProfile.paypal_account'
        );
        parent::beforeFilter();
    }
    function view($slug = null)
    {
        $this->pageTitle = __l('Company');
        if (is_null($slug)) {
            $this->cakeError('error404');
        }
        $conditions['Company.slug'] = $slug;
        if (ConstUserTypes::Admin != $this->Auth->user('user_type_id')) {
            $conditions['Company.is_company_profile_enabled'] = 1;
            if (!$this->RequestHandler->prefers('kml')) {
                $conditions['Company.is_online_account'] = 1;
            }
        }
        $company = $this->Company->find('first', array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.email',
                        'User.user_type_id',
                        'User.username',
                        'User.id',
                        'User.available_balance_amount',
                        'User.is_email_confirmed',
                        'User.is_active'
                    ) ,
                    'UserAvatar',
                ) ,
                'CompanyAddress' => array(
                    'City' => array(
                        'fields' => array(
                            'City.name'
                        )
                    ) ,
                    'State' => array(
                        'fields' => array(
                            'State.name'
                        )
                    ) ,
                    'Country' => array(
                        'fields' => array(
                            'Country.name'
                        )
                    ) ,
                    'order' => array(
                        'CompanyAddress.id' => 'desc'
                    )
                ) ,
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                    )
                ) ,
                'State' => array(
                    'fields' => array(
                        'State.id',
                        'State.name'
                    )
                ) ,
                'Country' => array(
                    'fields' => array(
                        'Country.id',
                        'Country.name',
                        'Country.slug',
                    )
                ) ,
                'Deal' => array(
                    'conditions' => array(
                        'Deal.deal_status_id' => array(
                            ConstDealStatus::Open,
                            ConstDealStatus::Expired,
                            ConstDealStatus::Tipped,
                            ConstDealStatus::Closed,
                            ConstDealStatus::PaidToCompany
                        )
                    ) ,
                    'fields' => array(
                        'Deal.id',
                        'Deal.name',
                        'Deal.slug',
                        'Deal.description'
                    ) ,
                    'limit' => 5
                )
            ) ,
            'recursive' => 2,
        ));
        if ($this->RequestHandler->prefers('kml')) {
            $this->set('company', $company);
        } else {
            $statistics = array();
            $statistics['referred_users'] = $this->Company->User->find('count', array(
                'conditions' => array(
                    'User.referred_by_user_id' => $company['Company']['user_id']
                )
            ));
            $deal_status_conditions = array(
                ConstDealStatus::Open,
                ConstDealStatus::Expired,
                ConstDealStatus::Tipped,
                ConstDealStatus::Closed,
                ConstDealStatus::PaidToCompany
            );
            if ($company['Company']['user_id'] == $this->Auth->user('id')) {
                $deal_status_conditions[] = ConstDealStatus::Draft;
                $deal_status_conditions[] = ConstDealStatus::PendingApproval;
                $deal_status_conditions[] = ConstDealStatus::Upcoming;
                $deal_status_conditions[] = ConstDealStatus::Refunded;
                $deal_status_conditions[] = ConstDealStatus::Canceled;
            }
            $statistics['deal_created'] = $this->Company->Deal->find('count', array(
                'conditions' => array(
                    'OR' => array(
                        'Deal.user_id' => $company['Company']['user_id'],
                        'Deal.company_id' => $company['Company']['id'],
                    ) ,
                    'Deal.deal_status_id' => $deal_status_conditions
                )
            ));
            $statistics['deal_purchased'] = $this->Company->User->DealUser->find('count', array(
                'conditions' => array(
                    'DealUser.user_id' => $company['Company']['user_id'],
                    'DealUser.is_gift' => 0
                )
            ));
            $statistics['gift_sent'] = $this->Company->User->GiftUser->find('count', array(
                'conditions' => array(
                    'GiftUser.user_id' => $company['Company']['user_id']
                )
            ));
            $statistics['gift_received'] = $this->Company->User->GiftUser->find('count', array(
                'conditions' => array(
                    'GiftUser.friend_mail' => $company['Company']['user_id']
                )
            ));
            $statistics['user_friends'] = $this->Company->User->UserFriend->find('count', array(
                'conditions' => array(
                    'UserFriend.user_id' => $company['Company']['user_id'],
                    'UserFriend.friend_status_id' => 2,
                    'UserFriend.is_requested' => 0,
                )
            ));
            if (empty($company)) {
                $this->cakeError('error404');
            }
            $this->set('statistics', $statistics);
            $this->pageTitle.= ' - ' . $company['Company']['name'];
            $this->set('company', $company);
            $this->data['UserComment']['user_id'] = $company['User']['id'];
        }
    }
    function edit($id = null)
    {
        $this->pageTitle = __l('Edit Company');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $this->Company->User->UserAvatar->Behaviors->attach('ImageUpload', Configure::read('avatar.file'));
        if (!empty($this->data)) {
            $user = $this->Company->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->data['User']['id']
                ) ,
                'contain' => array(
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    ),
					'UserProfile' => array(
						'fields' => array(
								'UserProfile.paypal_account',
								'UserProfile.language_id'
						 )		
					),
                ) ,
                'recursive' => 0
            ));
            if (!empty($user['UserAvatar']['id'])) {
                $this->data['UserAvatar']['id'] = $user['UserAvatar']['id'];
            }
            if (!empty($this->data['UserAvatar']['filename']['name'])) {
                $this->data['UserAvatar']['filename']['type'] = get_mime($this->data['UserAvatar']['filename']['tmp_name']);
            }
            if (!empty($this->data['UserAvatar']['filename']['name']) || (!Configure::read('avatar.file.allowEmpty') && empty($this->data['UserAvatar']['id']))) {
                $this->Company->User->UserAvatar->set($this->data);
            }
            $ini_upload_error = 1;
            if ($this->data['UserAvatar']['filename']['error'] == 1) {
                $ini_upload_error = 0;
            }
            $this->data['Company']['city_id'] = !empty($this->data['City']['id']) ? $this->data['City']['id'] : $this->Company->City->findOrSaveAndGetId($this->data['City']['name']);
            $this->data['Company']['state_id'] = !empty($this->data['State']['id']) ? $this->data['State']['id'] : $this->Company->State->findOrSaveAndGetId($this->data['State']['name']);
            unset($this->Company->validate['city_id']);
            unset($this->Company->validate['state_id']);
            $this->Company->State->set($this->data);
            $this->Company->City->set($this->data);
            $this->Company->set($this->data['Company']);
			//pr($this->Company->City->validates());
			unset($this->Company->City->validate['City']);	
            if ($this->Company->validates() && $this->Company->State->validates() && $this->Company->City->validates() && $this->Company->User->UserAvatar->validates() && $ini_upload_error) {
                if ($this->Company->save($this->data, false)) {
                    if (!empty($this->data['UserProfile']['language_id'])) {

						$this->Company->User->UserProfile->updateAll(array(
                            'UserProfile.language_id' => $this->data['UserProfile']['language_id']
                        ) , array(
                            'UserProfile.user_id' => $this->Auth->user('id')
                        ));
                    }
					if ($this->data['UserProfile']['language_id'] != $user['UserProfile']['language_id']) {
                        $this->Company->User->UserProfile->User->UserLogin->updateUserLanguage();
                    }
                    if (!empty($this->data['User']['UserProfile']['paypal_account'])) {
                        $this->Company->User->UserProfile->updateAll(array(
                            'UserProfile.paypal_account' => '\'' . $this->data['User']['UserProfile']['paypal_account'] . '\'',
                            'UserProfile.language_id' => '\'' . $this->data['UserProfile']['language_id'] . '\''
                        ) , array(
                            'UserProfile.user_id' => $this->Auth->user('id')
                        ));
                    }
                    if (!empty($this->data['UserAvatar']['filename']['name'])) {
                        $this->Attachment->create();
                        $this->data['UserAvatar']['class'] = 'UserAvatar';
                        $this->data['UserAvatar']['foreign_id'] = $this->data['User']['id'];
                        $this->Attachment->save($this->data['UserAvatar']);
                    }
                    $this->Session->setFlash(__l('Company has been updated') , 'default', array('lib' => __l('Success')), 'success');
                    if (!empty($this->params['form']['is_iframe_submit'])) {
                        $this->layout = 'ajax';
                    }
                } else {
                    $this->Session->setFlash(__l('Company could not be updated. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
                }
                if ($this->Company->User->isAllowed($this->Auth->user('user_type_id'))) {
                    $ajax_url = Router::url(array(
                        'controller' => 'users',
                        'action' => 'my_stuff',
                    ) , true);
                    $success_msg = 'redirect*' . $ajax_url;
                    echo $success_msg;
                    exit;
                }
            } else {
                $this->Session->setFlash(__l('Company could not be updated. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
		unset($this->Company->City->validate['City']);
            $this->data = $this->Company->find('first', array(
                'conditions' => array(
                    'Company.id = ' => $id,
                ) ,
                'contain' => array(
                    'User' => array(
                        'UserAvatar' => array(
                            'fields' => array(
                                'UserAvatar.id',
                                'UserAvatar.dir',
                                'UserAvatar.filename',
                                'UserAvatar.width',
                                'UserAvatar.height'
                            )
                        ) ,
                        'UserProfile' => array(
                            'fields' => array(
                                'UserProfile.paypal_account',
                                'UserProfile.language_id'
                            )
                        ) ,
                        'fields' => array(
                            'User.user_type_id',
                            'User.username',
                            'User.id',
                            'User.available_balance_amount'
                        )
                    ) ,
                    'City' => array(
                        'fields' => array(
                            'City.name'
                        )
                    ) ,
                    'State' => array(
                        'fields' => array(
                            'State.name'
                        )
                    )
                ) ,
                'recursive' => 2
            ));
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
            if (!empty($this->data['Company']['City'])) {
                $this->data['City']['name'] = $this->data['Company']['City']['name'];
            }
            if (!empty($this->data['Company']['State']['name'])) {
                $this->data['State']['name'] = $this->data['Company']['State']['name'];
            }
        }
        $this->pageTitle.= ' - ' . $this->data['Company']['name'];
        $cities = $this->Company->City->find('list', array(
            'conditions' => array(
                'City.is_approved =' => 1
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
        $states = $this->Company->State->find('list');
        $countries = $this->Company->Country->find('list');
        //get languages
		$languageLists = $this->Company->User->UserProfile->Language->Translation->find('all', array(
            'conditions' => array(
                'Language.id !=' => 0
            ) ,
            'fields' => array(
                'DISTINCT(Translation.language_id)',
                'Language.name',
                'Language.id'
            ) ,
            'order' => array(
                'Language.name' => 'ASC'
            )
        ));
        $languages = array();
        if (!empty($languageLists)) {
            foreach($languageLists as $languageList) {
                $languages[$languageList['Language']['id']] = $languageList['Language']['name'];
            }
        }
        //end
        $this->set(compact('cities', 'states', 'countries', 'languages'));
    }
    function delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->Company->del($id)) {
            $this->Session->setFlash(__l('Company deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function admin_index()
    {
 		$this->disableCache();
        $this->pageTitle = __l('Companies');
        if (!empty($this->data['Company']['q'])) {
            $this->params['named']['q'] = $this->data['Company']['q'];
            $this->pageTitle.= __l(' - Search - ') . $this->params['named']['q'];
        }
        if (!empty($this->data['Company']['main_filter_id'])) {
            $this->params['named']['filter_id'] = $this->data['Company']['main_filter_id'];
        }
        $this->set('online', $this->Company->find('count', array(
            'conditions' => array(
                'Company.is_online_account = ' => 1,
            ) ,
            'recursive' => -1
        )));
        // total approved users list
        $this->set('offline', $this->Company->find('count', array(
            'conditions' => array(
                'Company.is_online_account = ' => 0,
            ) ,
            'recursive' => -1
        )));
        // total openid users list
        $this->set('all', $this->Company->find('count', array(
            'recursive' => -1
        )));
        $conditions = $count_conditions = array();
        if (!empty($this->params['named']['main_filter_id'])) {
            if ($this->params['named']['main_filter_id'] == ConstMoreAction::Online) {
                $conditions['Company.is_online_account'] = 1;
                $this->pageTitle.= __l(' - Online Account');
            } else if ($this->params['named']['main_filter_id'] == ConstMoreAction::Offline) {
                $conditions['Company.is_online_account'] = 0;
                $this->pageTitle.= __l(' - Offline Account');
            }
            $this->data['Company']['main_filter_id'] = $this->params['named']['main_filter_id'];
            $count_conditions = $conditions;
        }
        if (!empty($this->params['named']['filter_id'])) {
            if ($this->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['User.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['User.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            }
        }
        if (isset($this->params['named']['stat']) && $this->params['named']['stat'] == 'day') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Company.created) <= '] = 0;
            $this->pageTitle.= __l(' - Registered today');
        }
        if (isset($this->params['named']['stat']) && $this->params['named']['stat'] == 'week') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Company.created) <= '] = 7;
            $this->pageTitle.= __l(' - Registered in this week');
        }
        if (isset($this->params['named']['stat']) && $this->params['named']['stat'] == 'month') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Company.created) <= '] = 30;
            $this->pageTitle.= __l(' - Registered in this month');
        }
        if ($this->RequestHandler->prefers('csv')) {
            Configure::write('debug', 0);
            $this->set('company', $this);
            $this->set('conditions', $conditions);
            if (isset($this->data['Company']['q'])) {
                $this->set('q', $this->data['Company']['q']);
            }
            $this->set('contain', $contain);
        } else {
            $this->paginate = array(
                'conditions' => array(
                    $conditions,
                ) ,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.email',
                            'User.user_type_id',
                            'User.username',
                            'User.id',
                            'User.available_balance_amount',
                            'User.is_email_confirmed',
                            'User.is_active'
                        ) ,
                        'UserAvatar'
                    )
                ) ,
                'order' => array(
                    'Company.id' => 'desc'
                ) ,
                'recursive' => 2,
            );
            if (!empty($this->params['named']['q'])) {
                $this->paginate['search'] = $this->data['Company']['q'] = $this->params['named']['q'];
            }
            if (!empty($this->params['named']['main_filter_id']) && $this->params['named']['main_filter_id'] == ConstMoreAction::Offline) {
                $moreActions[ConstMoreAction::DeductAmountFromWallet] = __l('Set As Paid');
            } else {
                $moreActions = $this->Company->moreActions;
            }
            $this->set(compact('moreActions'));
            $this->set('companies', $this->paginate());
            $this->set('pageTitle', $this->pageTitle);
            // total approved users list
            $this->set('active', $this->Company->find('count', array(
                'conditions' => array(
                    'User.is_active' => 1,
                    $count_conditions
                ) ,
                'recursive' => 1
            )));
            // total approved users list
            $this->set('inactive', $this->Company->find('count', array(
                'conditions' => array(
                    'User.is_active' => 0,
                    $count_conditions
                ) ,
                'recursive' => 1
            )));
        }
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Company');
        if (!empty($this->data)) {
            if (!empty($this->data['City']['name'])) {
                $this->data['Company']['city_id'] = !empty($this->data['City']['id']) ? $this->data['City']['id'] : $this->Company->City->findOrSaveAndGetId($this->data['City']['name']);
            }
            if (!empty($this->data['State']['name'])) {
                $this->data['Company']['state_id'] = !empty($this->data['State']['id']) ? $this->data['State']['id'] : $this->Company->State->findOrSaveAndGetId($this->data['State']['name']);
            }
            $this->Company->create();
            $this->Company->set($this->data);
            $this->Company->User->set($this->data);
            $this->Company->State->set($this->data);
            $this->Company->City->set($this->data);
			unset($this->Company->City->validate['City']);	
            if ($this->Company->User->validates() &$this->Company->validates() &$this->Company->City->validates() &$this->Company->State->validates()) {
                if (empty($this->data['Company']['user_id'])) {
                    $this->data['User']['user_type_id'] = ConstUserTypes::Company;
                    $this->data['User']['password'] = $this->Auth->password($this->data['User']['passwd']);
                    if ($this->data['Company']['is_online_account']) {
                        $this->data['User']['is_email_confirmed'] = '1';
                        $this->data['User']['is_active'] = '1';
                    } else {
                        $this->data['User']['is_email_confirmed'] = '0';
                        $this->data['User']['is_active'] = '0';
                    }
                    if ($this->Company->User->save($this->data)) {
                        $user_id = $this->Company->User->getLastInsertId();
                        $this->data['Company']['user_id'] = $user_id;
                        $this->data['UserProfile']['user_id'] = $user_id;
                        $this->data['UserProfile']['address'] = $this->data['Company']['address1'];
                        $this->data['UserProfile']['city_id'] = $this->data['Company']['city_id'];
                        $this->data['UserProfile']['state_id'] = $this->data['Company']['state_id'];
                        $this->data['UserProfile']['zip_code'] = $this->data['Company']['zip'];
                        $this->data['UserProfile']['paypal_account'] = $this->data['User']['UserProfile']['paypal_account'];
                        $this->Company->User->UserProfile->create();
                        $this->Company->User->UserProfile->save($this->data);
                    }
                }
                if ($this->Company->save($this->data)) {
                    if (!empty($this->data['Company']['is_online_account'])) {
                        $email = $this->EmailTemplate->selectTemplate('Admin User Add');
                        $emailFindReplace = array(
                            '##FROM_EMAIL##' => $this->Company->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
                            '##USERNAME##' => $this->data['User']['username'],
                            '##LOGINLABEL##' => ucfirst(Configure::read('user.using_to_login')) ,
                            '##USEDTOLOGIN##' => $this->data['User'][Configure::read('user.using_to_login') ],
                            '##SITE_NAME##' => Configure::read('site.name') ,
                            '##PASSWORD##' => $this->data['User']['passwd'],
                            '##SITE_LINK##' => Router::url('/', true) ,
                            '##CONTACT_URL##' => Router::url(array(
                                'controller' => 'contacts',
                                'action' => 'add',
                                'city' => $this->params['named']['city'],
                                'admin' => false
                            ) , true) ,
                            '##SITE_LOGO##' => Router::url(array(
                                'controller' => 'img',
                                'action' => 'theme-image',
                                'logo-email.png',
                                'admin' => false
                            ) , true) ,
                        );
                        $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
                        $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
                        $this->Email->to = $this->data['User']['email'];
                        $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                        $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                        $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                    }
                    $this->Session->setFlash(__l('Company has been added') , 'default', array('lib' => __l('Success')), 'success');
                    $this->redirect(array(
                        'action' => 'index'
                    ));
                } else {
                    $this->Session->setFlash(__l('Company could not be added. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
                }
            } else {
                $this->Session->setFlash(__l('Company could not be added. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        }
		unset($this->Company->City->validate['City']);	
        $countries = $this->Company->Country->find('list');
        $this->set(compact('countries'));
        unset($this->data['User']['passwd']);
        unset($this->data['User']['confirm_password']);
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Company');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $id = (!empty($this->data['Company']['id'])) ? $this->data['Company']['id'] : $id;
        $company = $this->Company->find('first', array(
            'conditions' => array(
                'Company.id' => $id
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.email',
                        'User.user_type_id',
                        'User.username',
                        'User.id',
                    )
                )
            ) ,
            'fields' => array(
                'Company.id',
            ) ,
            'recursive' => 0
        ));
        if (!empty($this->data)) {
            $this->data['Company']['city_id'] = !empty($this->data['City']['id']) ? $this->data['City']['id'] : $this->Company->City->findOrSaveAndGetId($this->data['City']['name']);
            $this->data['Company']['state_id'] = !empty($this->data['State']['id']) ? $this->data['State']['id'] : $this->Company->State->findOrSaveAndGetId($this->data['State']['name']);
            $this->Company->set($this->data);
            $this->Company->State->set($this->data);
            $this->Company->City->set($this->data);
            $this->Company->User->set($this->data);
			unset($this->Company->City->validate['City']);	
            if ($company['User']['email'] == $this->data['User']['email']) {
                unset($this->Company->User->validate['email']['rule3']);
            }
            if ($this->Company->validates() && $this->Company->City->validates() && $this->Company->State->validates() && $this->Company->User->validates()) {
                if ($this->Company->save($this->data)) {
                    $company = $this->Company->find('first', array(
                        'fields' => array(
                            'Company.user_id'
                        ) ,
                        'recursive' => -1,
                    ));
                    if ($this->data['Company']['is_online_account']) {
                        $this->data['User']['is_email_confirmed'] = '1';
                        $this->data['User']['is_active'] = '1';
                    } else {
                        $this->data['User']['is_email_confirmed'] = '0';
                        $this->data['User']['is_active'] = '0';
                    }
                    $this->data['User']['id'] = $company['Company']['user_id'];
                    $this->Company->User->save($this->data);
                    $this->Company->User->UserProfile->updateAll(array(
                        'UserProfile.paypal_account' => '\'' . $this->data['User']['UserProfile']['paypal_account'] . '\''
                    ) , array(
                        'UserProfile.user_id' => $company['Company']['user_id']
                    ));
                    $this->Session->setFlash(__l('Company has been updated') , 'default', array('lib' => __l('Success')), 'success');
                } else {
                    $this->Session->setFlash(__l('Company could not be updated. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
                }
            } else {
                $this->Session->setFlash(__l('Company could not be updated. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->Company->find('first', array(
                'conditions' => array(
                    'Company.id ' => $id,
                ) ,
                'contain' => array(
                    'User' => array(
                        'UserAvatar' => array(
                            'fields' => array(
                                'UserAvatar.id',
                                'UserAvatar.dir',
                                'UserAvatar.filename',
                                'UserAvatar.width',
                                'UserAvatar.height'
                            )
                        ) ,
                        'UserProfile' => array(
                            'fields' => array(
                                'UserProfile.first_name',
                                'UserProfile.last_name',
                                'UserProfile.middle_name',
                                'UserProfile.gender_id',
                                'UserProfile.about_me',
                                'UserProfile.address',
                                'UserProfile.country_id',
                                'UserProfile.state_id',
                                'UserProfile.city_id',
                                'UserProfile.zip_code',
                                'UserProfile.dob',
                                'UserProfile.language_id',
                                'UserProfile.paypal_account'
                            ) ,
                        ) ,
                    ) ,
                    'City' => array(
                        'fields' => array(
                            'City.name'
                        )
                    ) ,
                    'State' => array(
                        'fields' => array(
                            'State.name'
                        )
                    ) ,
                    'CompanyAddress' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name'
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name'
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name'
                            )
                        ) ,
                        'order' => array(
                            'CompanyAddress.id' => 'desc'
                        )
                    ) ,
                ) ,
                'recursive' => 2
            ));
            if (!empty($this->data['City'])) {
                $this->data['City']['name'] = $this->data['City']['name'];
            }
            if (!empty($this->data['State']['name'])) {
                $this->data['State']['name'] = $this->data['State']['name'];
            }
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
		unset($this->Company->City->validate['City']);	
        $this->pageTitle.= ' - ' . $this->data['Company']['name'];
        $users = $this->Company->User->find('list');
        $cities = $this->Company->City->find('list', array(
            'conditions' => array(
                'City.is_approved =' => 1
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
        $states = $this->Company->State->find('list');
        $countries = $this->Company->Country->find('list');
        $this->set(compact('users', 'cities', 'states', 'countries'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $company = $this->Company->find('first', array(
            'conditions' => array(
                'Company.id' => $id,
            ) ,
            'recursive' => -1
        ));
        if (!empty($company['Company']['user_id']) && $this->Company->User->del($company['Company']['user_id'])) {
            $this->Session->setFlash(__l('Company deleted') , 'default', array('lib' => __l('Success')), 'success');
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
        if (!empty($this->data['Company'])) {
            $r = $this->data[$this->modelClass]['r'];
            $actionid = $this->data[$this->modelClass]['more_action_id'];
            unset($this->data[$this->modelClass]['r']);
            unset($this->data[$this->modelClass]['more_action_id']);
            $companyIds = array();
            foreach($this->data['Company'] as $company_id => $is_checked) {
                if ($is_checked['id']) {
                    $companyIds[] = $company_id;
                }
            }
            if ($actionid && !empty($companyIds)) {
                if ($actionid == ConstMoreAction::EnableCompanyProfile) {
                    $this->Company->updateAll(array(
                        'Company.is_company_profile_enabled' => 1
                    ) , array(
                        'Company.id' => $companyIds
                    ));
                    $this->Session->setFlash(__l('Checked companies has been enabled') , 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstMoreAction::DisableCompanyProfile) {
                    $this->Company->updateAll(array(
                        'Company.is_company_profile_enabled' => 0
                    ) , array(
                        'Company.id' => $companyIds
                    ));
                    $this->Session->setFlash(__l('Checked companies has been disabled') , 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstMoreAction::Active) {
                    foreach($companyIds as $companyId) {
                        $get_company_user = $this->Company->find('first', array(
                            'conditions' => array(
                                'Company.id' => $companyId
                            ) ,
                            'recursive' => -1
                        ));
                        $this->Company->User->updateAll(array(
                            'User.is_active' => 1
                        ) , array(
                            'User.id' => $get_company_user['Company']['user_id']
                        ));
                        $this->_sendAdminActionMail($companyId, 'Admin User Active');
                    }
                    $this->Session->setFlash(__l('Checked companies user has been activated') , 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstMoreAction::Inactive) {
                    foreach($companyIds as $companyId) {
                        $get_company_user = $this->Company->find('first', array(
                            'conditions' => array(
                                'Company.id' => $companyId
                            ) ,
                            'recursive' => -1
                        ));
                        $this->Company->User->updateAll(array(
                            'User.is_active' => 0
                        ) , array(
                            'User.id' => $get_company_user['Company']['user_id']
                        ));
                        $this->_sendAdminActionMail($companyId, 'Admin User Deactivate');
                    }
                    $this->Session->setFlash(__l('Checked companies user has been deactivated') , 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstMoreAction::DeductAmountFromWallet) {
                    $this->Session->write('companies_list.data', $companyIds);
                    $this->redirect(array(
                        'controller' => 'companies',
                        'action' => 'admin_deductamount',
                        'admin' => true
                    ));
                }
            }
        }
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect(Router::url('/', true) . $r);
        } else {
            $this->redirect($r);
        }
    }
    function _sendAdminActionMail($company_id, $email_template)
    {
        $company = $this->Company->find('first', array(
            'conditions' => array(
                'Company.id' => $company_id
            ) ,
            'fields' => array(
                'Company.id',
                'Company.name',
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                    )
                )
            ) ,
            'recursive' => 1
        ));
        if (!empty($company['User']['email'])) {
            $email = $this->EmailTemplate->selectTemplate($email_template);
            $emailFindReplace = array(
                '##SITE_LINK##' => Router::url('/', true) ,
                '##USERNAME##' => $company['User']['username'],
                '##SITE_NAME##' => Configure::read('site.name') ,
                '##FROM_EMAIL##' => $this->Company->User->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
                '##CONTACT_URL##' => Router::url(array(
                    'controller' => 'contacts',
                    'action' => 'add',
                    'city' => $this->params['named']['city'],
                    'admin' => false
                ) , true) ,
                '##SITE_LOGO##' => Router::url(array(
                    'controller' => 'img',
                    'action' => 'blue-theme',
                    'logo-email.png',
                    'admin' => false
                ) , true) ,
            );
            $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
            $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
            $this->Email->to = $this->Company->User->formatToAddress($company);
            $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
            $this->Email->subject = strtr($email['subject'], $emailFindReplace);
            $this->Email->send(strtr($email['email_content'], $emailFindReplace));
        }
    }
    function admin_deductamount($companies_list = null)
    {
        if (empty($companies_list)) {
            $companies_list = $this->Session->read('companies_list.data');
        }
        if (!empty($companies_list)) {
            $companies = $this->Company->find('all', array(
                'conditions' => array(
                    'Company.id' => $companies_list
                ) ,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.user_type_id',
                            'User.username',
                            'User.id',
                            'User.available_balance_amount'
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            $this->set('companies', $companies);
        } else {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            foreach($this->data['Company'] as $company_id => $company) {
                $get_company = $this->Company->find('first', array(
                    'conditions' => array(
                        'Company.id' => $company_id
                    ) ,
                    'contain' => array(
                        'User' => array(
                            'fields' => array(
                                'User.user_type_id',
                                'User.username',
                                'User.id',
                                'User.available_balance_amount'
                            )
                        )
                    ) ,
                    'recursive' => 0
                ));
                if ($this->data['Company'][$company_id]['amount'] > $get_company['User']['available_balance_amount']) {
                    $this->Company->validationErrors[$company_id]['amount'] = __l('Should be less than available balance amount');
                }
                if (empty($company['amount'])) {
                    $this->Company->validationErrors[$company_id]['amount'] = __l('Required');
                }
            }
            if (empty($this->Company->validationErrors)) {
                $transactions = array();
                $transactions['Transaction']['foreign_id'] = $this->Auth->user('id');
                foreach($this->data['Company'] as $company_id => $company) {
                    $transactions['Transaction']['user_id'] = $company['user_id'];
                    $transactions['Transaction']['class'] = 'SecondUser';
                    $transactions['Transaction']['amount'] = $company['amount'];
                    $transactions['Transaction']['description'] = $company['description'];
                    $transactions['Transaction']['transaction_type_id'] = ConstTransactionTypes::DeductedAmountForOfflineCompany;
                    $this->Company->User->Transaction->log($transactions);
                    $this->Company->User->updateAll(array(
                        'User.available_balance_amount' => 'User.available_balance_amount -' . $company['amount'],
                    ) , array(
                        'User.id' => $company['user_id']
                    ));
                }
                $this->Session->del('companies_list');
                $this->Session->setFlash(__l('Amount deducted for the selected companies') , 'default', array('lib' => __l('Success')), 'success');
                $r = "san-diego/admin/companies/main_filter_id:10/city:san-diego";
                if (!$this->RequestHandler->isAjax()) {
                    $this->redirect(Router::url('/', true) . $r);
                } else {
                    $this->redirect($r);
                }
            } else {
                $this->Session->setFlash(__l('Amount could not be deducted for the selected companies. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        }
    }
}
?>