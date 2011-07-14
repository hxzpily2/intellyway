<?php
class UsersController extends AppController
{
    var $name = 'Users';
    var $components = array(
        'Email',
        'Openid',
        'Paypal',
		'PagSeguro',
        'OauthConsumer'
    );
    var $uses = array(
        'User',
        'EmailTemplate',
		'TempPaymentLog'
    );
    var $helpers = array(
        'Csv',
        'Gateway',
		'PagSeguro',
    );
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'City.id',
            'City.name',
            'State.id',
            'State.name',
            'Company.name',
            'Company.phone',
            'Company.url',
            'Company.address1',
            'Company.address2',
            'Company.country_id',
            'Company.zip',
            'Company.latitude',
            'Company.longitude',
            'Company.map_zoom_level',
            'User.referer_name',
            'UserProfile.country_id',
            'UserProfile.state_id',
            'UserProfile.city_id',
            'User.geobyte_info',
            'User.maxmind_info',
            'User.referred_by_user_id',
            'User.type',
            'User.is_agree_terms_conditions',
            'User.country_iso_code',
            'User.is_requested',
            'User.is_remember',
			'User.is_show_new_card'
        );
        parent::beforeFilter();
        $this->disableCache();
    }
    function view($username = null)
    {
        $this->pageTitle = __l('User');
        if (is_null($username)) {
            $this->cakeError('error404');
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.username = ' => $username
            ) ,
            'contain' => array(
                'UserProfile' => array(
                    'fields' => array(
                        'UserProfile.created',
                        'UserProfile.first_name',
                        'UserProfile.last_name',
                        'UserProfile.middle_name',
                        'UserProfile.about_me',
                        'UserProfile.dob',
                        'UserProfile.address',
                        'UserProfile.zip_code',
                        'UserProfile.paypal_account',
                    ) ,
                    'Gender' => array(
                        'fields' => array(
                            'Gender.name'
                        )
                    ) ,
                    'City' => array(
                        'fields' => array(
                            'City.name'
                        )
                    ) ,
                    'Language' => array(
                        'fields' => array(
                            'Language.id',
                            'Language.name'
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
                    )
                ) ,
                'UserAvatar' => array(
                    'fields' => array(
                        'UserAvatar.id',
                        'UserAvatar.dir',
                        'UserAvatar.filename',
                        'UserAvatar.width',
                        'UserAvatar.height'
                    )
                )
            ) ,
            'fields' => array(
                'User.id',
                'User.username',
                'User.email',
                'User.user_type_id',
				'User.fb_user_id',
                'User.created'
            ) ,
            'recursive' => 2
        ));
        $statistics = array();
        $statistics['referred_users'] = $this->User->find('count', array(
            'conditions' => array(
                'User.Referred_by_user_id' => $user['User']['id']
            ) ,
            'recursive' => -1
        ));
        $statistics['deal_purchased'] = $this->User->DealUser->find('count', array(
            'conditions' => array(
                'DealUser.user_id' => $user['User']['id'],
                'DealUser.is_gift' => 0
            ) ,
            'recursive' => -1
        ));
        $statistics['gift_sent'] = $this->User->GiftUser->find('count', array(
            'conditions' => array(
                'GiftUser.user_id' => $user['User']['id']
            ) ,
            'recursive' => -1
        ));
        $statistics['gift_received'] = $this->User->GiftUser->find('count', array(
            'conditions' => array(
                'GiftUser.friend_mail' => $user['User']['email']
            ) ,
            'recursive' => -1
        ));
        if (ConstUserFriendType::IsTwoWay) {
            $statistics['user_friends'] = $this->User->UserFriend->find('count', array(
                'conditions' => array(
                    'UserFriend.user_id' => $user['User']['id'],
                    'UserFriend.friend_status_id' => 2,
                    'UserFriend.is_requested' => array(
                        0,
                        1
                    ) ,
                ) ,
                'recursive' => -1
            ));
        } else {
            $statistics['user_friends'] = $this->User->UserFriend->find('count', array(
                'conditions' => array(
                    'UserFriend.user_id' => $user['User']['id'],
                    'UserFriend.friend_status_id' => 2,
                    'UserFriend.is_requested' => 0,
                ) ,
                'recursive' => -1
            ));
        }
        if (empty($user)) {
            $this->cakeError('error404');
        }
        // To set is this user in current user friends lists
        $friend = $this->User->UserFriend->find('first', array(
            'conditions' => array(
                'UserFriend.user_id' => $this->Auth->user('id') ,
                'UserFriend.friend_user_id' => $user['User']['id'],
                'UserFriend.friend_status_id' => ConstUserFriendStatus::Approved
            ) ,
            'recursive' => -1
        ));
        $this->set('statistics', $statistics);
        $this->set('friend', $friend);
        $this->data['UserComment']['user_id'] = $user['User']['id'];
        $this->User->UserView->create();
        $this->data['UserView']['user_id'] = $user['User']['id'];
        $this->data['UserView']['viewing_user_id'] = $this->Auth->user('id');
        $this->data['UserView']['ip'] = $this->RequestHandler->getClientIP();
        $this->data['UserView']['dns'] = gethostbyaddr($this->RequestHandler->getClientIP());
        $this->User->UserView->save($this->data);
        $this->pageTitle.= ' - ' . $username;
        $this->set('user', $user);
    }
    function register($type = null)
    {
        $this->pageTitle = __l('User Registration');
        $fbuser = $this->Session->read('fbuser');
        if (!empty($fbuser['fb_user_id'])) {
            $this->data['User']['username'] = $fbuser['username'];
            $this->data['User']['email'] = '';
            $this->data['User']['fb_user_id'] = $fbuser['fb_user_id'];
            $this->Session->del('fbuser');
        } else if (empty($this->data)) {
            if (Configure::read('facebook.is_enabled_facebook_connect') && !$this->Auth->user() && $this->facebook->getSession()) {
                // Quick fix for facebook issue //
                if ($_GET['session']) {
                    $this->_facebook_login();
                }
            }
        }
        //open id component included
        App::import('Component', 'Openid');
        $this->Openid = &new OpenidComponent();
        $openid = $this->Session->read('openid');
        if (!empty($openid['openid_url'])) {
            if (isset($openid['email'])) {
                $this->data['User']['email'] = $openid['email'];
                $this->data['User']['username'] = $openid['username'];
                $this->data['User']['openid_url'] = $openid['openid_url'];
                $this->Session->delete('openid');
            }
        }
        // handle the fields return from openid
        if ((count($_GET) > 1) && !empty($_GET['openid_identity'])) {
            $returnTo = Router::url(array(
                'controller' => 'users',
                'action' => 'register'
            ) , true);
            $response = $this->Openid->getResponse($returnTo);
            if ($response->status == Auth_OpenID_SUCCESS) {
                // Required Fields
                if ($user = $this->User->UserOpenid->find('first', array(
                    'conditions' => array(
                        'UserOpenid.openid' => $response->identity_url
                    )
                ))) {
                    //Already existing user need to do auto login
                    $this->data['User']['email'] = $user['User']['email'];
                    $this->data['User']['username'] = $user['User']['username'];
                    $this->data['User']['password'] = $user['User']['password'];
                    if ($this->Auth->login($this->data)) {
                        $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'my_stuff'
                        ));
                    } else {
                        $this->Session->setFlash($this->Auth->loginError, 'default', null, 'error');
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'login'
                        ));
                    }
                } else {
                    if (Configure::read('user.is_referral_system_enabled')) {
                        //user id will be set in cookie
                        $cookie_value = $this->Cookie->read('referrer');
                        if (!empty($cookie_value)) {
                            $this->data['User']['referred_by_user_id'] = $cookie_value;
                        }
                    }
                    $sregResponse = Auth_OpenID_SRegResponse::fromSuccessResponse($response);
                    $sreg = $sregResponse->contents();
                    $this->data['User']['username'] = isset($sreg['nickname']) ? $sreg['nickname'] : '';
                    $this->data['User']['email'] = isset($sreg['email']) ? $sreg['email'] : '';
                    $this->data['User']['openid_url'] = $response->identity_url;
                }
            } else {
                $this->Session->setFlash(__l('Authenticated failed or you may not have profile in your OpenID account'));
            }
        }
        // send to openid function with open id url and redirect page
        if (!empty($this->data['User']['openid']) && preg_match('/^http?:\/\/+[a-z]/', $this->data['User']['openid'])) {
            $this->User->set($this->data);
            unset($this->User->validate[Configure::read('user.using_to_login') ]);
            unset($this->User->validate['passwd']);
            unset($this->User->validate['email']);
            unset($this->User->validate['confirm_password']);
            if ($this->User->validates()) {
                $this->data['User']['redirect_page'] = 'register';
                $this->_openid();
            } else {
                $this->Session->setFlash(__l('Your registration process is not completed. Please, try again.') , 'default', null, 'error');
            }
        } else {
            if (!empty($this->data)) {
                if (!empty($this->data['User']['type'])) {
                    $type = $this->data['User']['type'];
                }
                if (!empty($this->data['City']['name'])) {
                    $this->data['UserProfile']['city_id'] = !empty($this->data['City']['id']) ? $this->data['City']['id'] : $this->User->Company->City->findOrSaveAndGetId($this->data['City']['name']);
                }
                if (!empty($this->data['State']['name'])) {
                    $this->data['UserProfile']['state_id'] = !empty($this->data['State']['id']) ? $this->data['State']['id'] : $this->User->Company->State->findOrSaveAndGetId($this->data['State']['name']);
                }
                if (!empty($this->data['User']['country_iso_code'])) {
                    $this->data['UserProfile']['country_id'] = $this->User->UserProfile->Country->findCountryIdFromIso2($this->data['User']['country_iso_code']);
                    if (empty($this->data['UserProfile']['country_id'])) {
                        unset($this->data['UserProfile']['country_id']);
                    }
                }
                $this->User->set($this->data);
                $this->User->UserProfile->set($this->data);
                $this->User->Company->set($this->data);
                if (!empty($this->data['User']['type'])) {
                    $this->User->Company->City->set($this->data);
                    $this->User->Company->State->set($this->data);
                }
                if ($this->User->validates() &$this->User->UserProfile->validates() &$this->User->Company->validates() &$this->User->Company->City->validates() &$this->User->Company->State->validates()) {
                    $this->User->create();
                    if (!empty($this->data['User']['openid_url']) or !empty($this->data['User']['fb_user_id'])) {
                        $this->data['User']['password'] = $this->Auth->password($this->data['User']['email'] . Configure::read('Security.salt'));
                        //For open id register no need for email confirm, this will override is_email_verification_for_register setting
                        $this->data['User']['is_agree_terms_conditions'] = 1;
                        $this->data['User']['is_email_confirmed'] = 1;
                        if (empty($this->data['User']['fb_user_id'])) {
                            $this->data['User']['is_openid_register'] = 1;
                        }
                    } else {
                        $this->data['User']['password'] = $this->Auth->password($this->data['User']['passwd']);
                        $this->data['User']['is_email_confirmed'] = (Configure::read('user.is_email_verification_for_register')) ? 0 : 1;
                    }
                    $this->data['User']['is_active'] = (Configure::read('user.is_admin_activate_after_register')) ? 0 : 1;
                    $this->data['User']['user_type_id'] = ConstUserTypes::User;
                    if ($this->Session->read('gift_user_id')) {
                        $this->data['User']['gift_user_id'] = $this->Session->read('gift_user_id');
                        $this->Session->del('gift_user_id');
                    }
                    $this->data['User']['signup_ip'] = $this->RequestHandler->getClientIP();
                    $this->data['User']['dns'] = gethostbyaddr($this->RequestHandler->getClientIP());
                    if (!empty($type)) {
                        $this->data['User']['user_type_id'] = ConstUserTypes::Company;
                    }
                    if ($this->User->save($this->data, false)) {
                        $this->User->_createCimProfile($this->User->getLastInsertId());
                        if (!empty($type)) {
                            if (!empty($this->data['City']['name'])) {
                                $this->data['UserProfile']['city_id'] = $this->data['Company']['city_id'] = !empty($this->data['City']['id']) ? $this->data['City']['id'] : $this->User->Company->City->findOrSaveAndGetId($this->data['City']['name']);
                            }
                            if (!empty($this->data['State']['name'])) {
                                $this->data['UserProfile']['state_id'] = $this->data['Company']['state_id'] = !empty($this->data['State']['id']) ? $this->data['State']['id'] : $this->User->Company->State->findOrSaveAndGetId($this->data['State']['name']);
                            }
                            $this->data['Company']['user_id'] = $this->User->getLastInsertId();
                            $this->data['Company']['is_online_account'] = 1;
                            $this->data['Company']['is_company_profile_enabled'] = 1;
                            $this->User->Company->create();
                            $this->User->Company->save($this->data['Company']);
                            $company_id = $this->User->Company->getLastInsertId();
                        }
                        $this->data['UserProfile']['user_id'] = $this->User->getLastInsertId();
                        $this->User->UserProfile->create();
                        $this->User->UserProfile->save($this->data);
                        $this->data['UserPermissionPreference']['user_id'] = $this->User->id;
                        $this->User->UserPermissionPreference->create();
                        $this->User->UserPermissionPreference->save($this->data);
                        // send to admin mail if is_admin_mail_after_register is true
                        if (Configure::read('user.is_admin_mail_after_register')) {
                            $email = $this->EmailTemplate->selectTemplate('New User Join');
                            $emailFindReplace = array(
                                '##SITE_LINK##' => Router::url('/', true) ,
                                '##USERNAME##' => $this->data['User']['username'],
                                '##SITE_NAME##' => Configure::read('site.name') ,
                                '##SIGNUP_IP##' => $this->RequestHandler->getClientIP() ,
                                '##EMAIL##' => $this->data['User']['email'],
                                '##CONTACT_URL##' => Router::url(array(
                                    'controller' => 'contacts',
                                    'action' => 'add',
                                    'city' => $this->params['named']['city'],
                                    'admin' => false
                                ) , true) ,
                                '##FROM_EMAIL##' => $this->User->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
                                '##SITE_LOGO##' => Router::url(array(
                                    'controller' => 'img',
                                    'action' => 'blue-theme',
                                    'logo-email.png',
                                    'admin' => false
                                ) , true) ,
                            );
                            // Send e-mail to users
                            $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
                            $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
                            $this->Email->to = Configure::read('site.contact_email');
                            $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                            $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                            $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                        }
                        $this->Session->setFlash(__l('You have successfully registered with our site.') , 'default', null, 'success');
                        if (!empty($this->data['User']['openid_url']) || !empty($this->data['User']['fb_user_id'])) {
                            // send welcome mail to user if is_welcome_mail_after_register is true
                            if (Configure::read('user.is_welcome_mail_after_register')) {
                                $this->_sendWelcomeMail($this->User->id, $this->data['User']['email'], $this->data['User']['username']);
                            }
                            if (empty($this->data['User']['fb_user_id'])) {
                                $this->data['UserOpenid']['openid'] = $this->data['User']['openid_url'];
                                $this->data['UserOpenid']['user_id'] = $this->User->id;
                                $this->User->UserOpenid->create();
                                $this->User->UserOpenid->save($this->data);
                            }
                            if ($this->Auth->login($this->data)) {
                                $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                                if ($this->Auth->user('user_type_id') == ConstUserTypes::Company) {
                                    $company = $this->User->Company->find('first', array(
                                        'conditions' => array(
                                            'Company.user_id = ' => $company_id
                                        ) ,
                                        'fields' => array(
                                            'Company.slug',
                                        ) ,
                                        'recursive' => -1
                                    ));
                                    $this->redirect(array(
                                        'controller' => 'deals',
                                        'action' => 'index',
                                        'company' => $company['Company']['slug']
                                    ));
                                } else {
									if ($redirectUrl = $this->Session->read('Auth.redirectUrl')) {
										$this->Session->del('Auth.redirectUrl');
										$this->redirect(Router::url('/', true) . $redirectUrl);
									}
									else {
										$this->redirect(array(
											'controller' => 'users',
											'action' => 'my_stuff#My_Purchases'
										));
									}
                                }
                            }
                        } else {
                            //For openid register no need to send the activation mail, so this code placed in the else
                            if (Configure::read('user.is_email_verification_for_register')) {
                                $this->Session->setFlash(__l('You have successfully registered with our site and your activation mail has been sent to your mail inbox.') , 'default', null, 'success');
                                $this->_sendActivationMail($this->data['User']['email'], $this->User->id, $this->User->getActivateHash($this->User->id));
                            }
                        }
                        // send welcome mail to user if is_welcome_mail_after_register is true
                        if (!Configure::read('user.is_email_verification_for_register') and !Configure::read('user.is_admin_activate_after_register') and Configure::read('user.is_welcome_mail_after_register')) {
                            $this->_sendWelcomeMail($this->User->id, $this->data['User']['email'], $this->data['User']['username']);
                        }
                        if (!Configure::read('user.is_email_verification_for_register') and Configure::read('user.is_auto_login_after_register')) {
                            $this->Session->setFlash(__l('You have successfully registered with our site.') , 'default', null, 'success');
                            if ($this->Auth->login($this->data)) {
                                $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                                if ($this->RequestHandler->isAjax()) {
                                    echo 'redirect*' . Router::url('/', true) . $this->data['User']['f'];
                                    exit;
                                } else if (!empty($this->data['User']['f'])) {
                                    $this->redirect(Router::url('/', true) . $this->data['User']['f']);
                                }
                                if ($this->data['User']['user_type_id'] == ConstUserTypes::Company) {
                                    $company = $this->User->Company->find('first', array(
                                        'conditions' => array(
                                            'Company.user_id = ' => $this->Auth->user('id')
                                        ) ,
                                        'fields' => array(
                                            'Company.slug',
                                        ) ,
                                        'recursive' => -1
                                    ));
                                    $this->redirect(array(
                                        'controller' => 'deals',
                                        'action' => 'index',
                                        'company' => $company['Company']['slug']
                                    ));
                                } else {
                                    $this->redirect(array(
                                        'controller' => 'users',
                                        'action' => 'my_stuff#My_Purchases'
                                    ));
                                }
                            }
                        }
                        if ($this->params['isAjax'] == 1) {
                            $ajax_url = Router::url('/', true) . 'users/login?f=' . $this->data['User']['f'];
                            $success_msg = 'redirect*' . $ajax_url;
                            echo $success_msg;
                            exit;
                        }
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'login'
                        ));
                    }
                } else {
                    if (empty($this->data['User']['openid_url'])) {
                        $this->Session->setFlash(__l('Your registration process is not completed. Please, try again.') , 'default', null, 'error');
                    } else {
                        $this->Session->setFlash(__l('OpenID verification is completed successfully. But you have to fill the following required fields to complete our registration process.') , 'default', null, 'error');
                    }
                }
            }
        }
        if (!empty($this->params['named']['f'])) {
            $this->data['User']['f'] = $this->params['named']['f'];
        }
        if (!empty($this->params['requested'])) {
            $this->data['User']['is_requested'] = 1;
        }
        unset($this->data['User']['passwd']);
		unset($this->User->Company->City->validate['City']);
        // When already logged user trying to access the registration page we are redirecting to site home page
        if ($this->Auth->user()) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'my_stuff#My_Purchases'
            ));
        }
        //for user referral system
        if (empty($this->data) && Configure::read('user.is_referral_system_enabled')) {
            //user id will be set in cookie
            $cookie_value = $this->Cookie->read('referrer');
            if (!empty($cookie_value)) {
                $this->data['User']['referred_by_user_id'] = $cookie_value;
            }
        }
        //end
        $countries = $this->User->UserProfile->Country->find('list');
        $this->set('type', $type);
        $this->set(compact('countries'));
        unset($this->data['User']['passwd']);
        unset($this->data['User']['confirm_password']);
        unset($this->data['User']['captcha']);
        //printArray($this->params);

    }
    function admin_export($hash = null)
    {
        Configure::write('debug', 0);
        $conditions = array();
        if (isset($this->params['named']['from_date']) || isset($this->params['named']['to_date'])) {
            $conditions['DATE(User.created) BETWEEN ? AND ? '] = array(
                _formatDate('Y-m-d H:i:s', $this->params['named']['from_date'], true) ,
                _formatDate('Y-m-d H:i:s', $this->params['named']['to_date'], true)
            );
        }
        if (!empty($this->params['named']['main_filter_id'])) {
            if ($this->params['named']['main_filter_id'] == ConstMoreAction::OpenID) {
                $conditions['User.is_openid_register'] = 1;
                $this->pageTitle.= __l(' - Registered through OpenID ');
            } else if ($this->params['named']['main_filter_id'] == ConstMoreAction::FaceBook) {
                $conditions['User.fb_user_id != '] = NULL;
                $this->pageTitle.= __l(' - Registered through FaceBook ');
            } else if ($this->params['named']['main_filter_id'] == ConstUserTypes::User) {
                $conditions['User.user_type_id'] = ConstUserTypes::User;
                $conditions['User.fb_user_id = '] = NULL;
                $conditions['User.is_openid_register'] = 0;
            } else if ($this->params['named']['main_filter_id'] == ConstUserTypes::Admin) {
                $conditions['User.user_type_id'] = ConstUserTypes::Admin;
                $this->pageTitle.= __l(' - Admin ');
            } else if ($this->params['named']['main_filter_id'] == 'all') {
                $conditions['User.user_type_id != '] = ConstUserTypes::Company;
                $this->pageTitle.= __l(' - All ');
            }
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
            $conditions['TO_DAYS(NOW()) - TO_DAYS(User.created) <= '] = 0;
            $this->pageTitle.= __l(' - Registered today');
        }
        if (isset($this->params['named']['stat']) && $this->params['named']['stat'] == 'week') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(User.created) <= '] = 7;
            $this->pageTitle.= __l(' - Registered in this week');
        }
        if (isset($this->params['named']['stat']) && $this->params['named']['stat'] == 'month') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(User.created) <= '] = 30;
            $this->pageTitle.= __l(' - Registered in this month');
        }
        if (!empty($hash) && isset($_SESSION['user_export'][$hash])) {
            $user_ids = implode(',', $_SESSION['user_export'][$hash]);
            if ($this->User->isValidUserIdHash($user_ids, $hash)) {
                $conditions['User.id'] = $_SESSION['user_export'][$hash];
            } else {
                $this->cakeError('error404');
            }
        }
        if (isset($this->params['named']['q']) && !empty($this->params['named']['q'])) {
            $conditions['User.username like'] = '%' . $this->params['named']['q'] . '%';
        }
        $users = $this->User->find('all', array(
            'conditions' => $conditions,
            'contain' => array(
                'RefferalUser'
            ) ,
            'recursive' => 1
        ));
        if (!empty($users)) {
            foreach($users as $user) {
                $data[]['User'] = array(
                    __l('Username') => $user['User']['username'],
                    __l('Email') => $user['User']['email'],
                    __l('Login count') => $user['User']['user_login_count'],
                    __l('Referred User') => !empty($user['RefferalUser']['username']) ? $user['RefferalUser']['username'] : '-',
                    __l('Email Confirmed') => !empty($user['User']['is_email_confirmed']) ? __l('Yes') : __l('No') ,
                    __l('Signup IP') => $user['User']['signup_ip'],
                    __l('Created on') => $user['User']['created'],
                    __l('Available balance amount') => $user['User']['available_balance_amount'],
                );
            }
        }
        $this->set('data', $data);
    }
    function refer($referrer = null)
    {
        if (is_null($referrer)) {
            $this->cakeError('error404');
        }
        $cookie_value = $this->Cookie->read('referrer');
        //cookie value should be empty or same user id should not be over written
        if (!empty($referrer) && (empty($cookie_value) || (!empty($cookie_value) && $cookie_value != $referrer))) {
            $user_refername = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $referrer
                ) ,
                'recursive' => -1
            ));
            if (empty($user_refername)) {
                $this->Session->setFlash(__l('Referrer username does not exist.') , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'register'
                ));
            } else {
                $this->Cookie->del('referrer');
                $this->Cookie->write('referrer', $referrer, true, sprintf('+%s hours', Configure::read('user.referral_cookie_expire_time')));
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'register'
                ));
            }
        } else {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'register'
            ));
        }
    }
    function _openid()
    {
        $returnTo = Router::url(array(
            'controller' => 'users',
            'action' => $this->data['User']['redirect_page']
        ) , true);
        $siteURL = Router::url('/', true);
        // send openid url and fields return to our server from openid
        if (!empty($this->data)) {
            try {
                $this->Openid->authenticate($this->data['User']['openid'], $returnTo, $siteURL, array(
                    'email',
                    'nickname'
                ) , array());
            }
            catch(InvalidArgumentException $e) {
                $this->Session->setFlash(__l('Invalid OpenID') , 'default', null, 'error');
            }
            catch(Exception $e) {
                $this->Session->setFlash(sprintf(__l('%s') , $e->getMessage()));
            }
        }
    }
    function _sendActivationMail($user_email, $user_id, $hash)
    {
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.email' => $user_email
            ) ,
            'recursive' => -1
        ));
        $email = $this->EmailTemplate->selectTemplate('Activation Request');
        $emailFindReplace = array(
            '##SITE_LINK##' => Router::url('/', true) ,
            '##USERNAME##' => $user['User']['username'],
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##FROM_EMAIL##' => $this->User->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
            '##ACTIVATION_URL##' => Router::url(array(
                'controller' => 'users',
                'action' => 'activation',
                $user_id,
                $hash
            ) , true) ,
            '##CONTACT_URL##' => Router::url(array(
                'controller' => 'contacts',
                'action' => 'add',
                'city' => (!empty($this->params['named']['city'])) ? $this->params['named']['city'] : '',
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
        $this->Email->to = $user_email;
        $this->Email->subject = strtr($email['subject'], $emailFindReplace);
        $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
        if ($this->Email->send(strtr($email['email_content'], $emailFindReplace))) {
            return true;
        }
    }
    function _sendWelcomeMail($user_id, $user_email, $username)
    {
        $email = $this->EmailTemplate->selectTemplate('Welcome Email');
        $emailFindReplace = array(
            '##SITE_LINK##' => Router::url('/', true) ,
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##FROM_EMAIL##' => $this->User->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
            '##USERNAME##' => $username,
            '##SUPPORT_EMAIL##' => Configure::read('site.contact_email') ,
            '##SITE_URL##' => Router::url('/', true) ,
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
        $this->Email->to = $user_email;
        $this->Email->subject = strtr($email['subject'], $emailFindReplace);
        $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
        $this->Email->send(strtr($email['email_content'], $emailFindReplace));
    }
    function activation($user_id = null, $hash = null)
    {
        $this->pageTitle = __l('Activate your account');
        if (is_null($user_id) or is_null($hash)) {
            $this->cakeError('error404');
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
                'User.is_email_confirmed' => 0,
            ) ,
            'recursive' => -1
        ));
        if (empty($user)) {
            $this->Session->setFlash(__l('Invalid activation request, please register again'));
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'register'
            ));
        }
        if (!$this->User->isValidActivateHash($user_id, $hash)) {
            $hash = $this->User->getActivateHash($user_id);
            $this->Session->setFlash(__l('Invalid activation request'));
            $this->set('show_resend', 1);
            $resend_url = Router::url(array(
                'controller' => 'users',
                'action' => 'resend_activation',
                $user_id,
                $hash
            ) , true);
            $this->set('resend_url', $resend_url);
        } else {
            $this->data['User']['id'] = $user_id;
            $this->data['User']['is_email_confirmed'] = 1;
            // admin will activate the user condition check
            $this->data['User']['is_active'] = (Configure::read('user.is_admin_activate_after_register')) ? 0 : 1;
            $this->User->save($this->data);
            // active is false means redirect to home page with message
            if (!$this->data['User']['is_active']) {
                $this->Session->setFlash(__l('You have successfully activated your account. But you can login after admin activate your account.') , 'default', null, 'success');
                $this->redirect(Router::url('/', true));
            }
            // send welcome mail to user if is_welcome_mail_after_register is true
            if (Configure::read('user.is_welcome_mail_after_register')) {
                $this->_sendWelcomeMail($user['User']['id'], $user['User']['email'], $user['User']['username']);
            }
            // after the user activation check script check the auto login value. it is true then automatically logged in
            if (Configure::read('user.is_auto_login_after_register')) {
                $this->Session->setFlash(__l('You have successfully activated and logged in to your account.') , 'default', null, 'success');
                $this->data['User']['email'] = $user['User']['email'];
                $this->data['User']['username'] = $user['User']['username'];
                $this->data['User']['password'] = $user['User']['password'];
                if ($this->Auth->login($this->data)) {
                    $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                    if ($user['User']['user_type_id'] == ConstUserTypes::Company) {
                        if (!Configure::write('user.is_company_actas_normal_user')) {
                            $company = $this->User->Company->find('first', array(
                                'conditions' => array(
                                    'Company.user_id = ' => $user_id
                                ) ,
                                'fields' => array(
                                    'Company.slug',
                                ) ,
                                'recursive' => -1
                            ));
                            $this->redirect(array(
                                'controller' => 'deals',
                                'action' => 'index',
                                'company' => $company['Company']['slug']
                            ));
                        } else {
                            $this->redirect(array(
                                'controller' => 'users',
                                'action' => 'my_stuff'
                            ));
                        }
                    } else {
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'my_stuff'
                        ));
                    }
                }
            }
            // user is active but auto login is false then the user will redirect to login page with message
            $this->Session->setFlash(sprintf(__('You have successfully activated your account. Now you can login with your %s.') , Configure::read('user.using_to_login')) , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
    }
    function resend_activation($user_id = null, $hash = null)
    {
        if (is_null($user_id)) {
            $this->cakeError('error404');
        }
        $hash = $this->User->getActivateHash($user_id);
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
        if ($this->_sendActivationMail($user['User']['email'], $user_id, $hash)) {
            if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                $this->Session->setFlash(__l('Activation mail has been resent.') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('A Mail for activating your account has been sent.') , 'default', null, 'success');
            }
        } else {
            $this->Session->setFlash(__l('Try some time later as mail could not be dispatched due to some error in the server') , 'default', null, 'error');
        }
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
            $this->redirect(array(
                'controller' => (!empty($this->params['named']['type'])) ? 'companies' : 'users',
                'action' => 'index',
                'admin' => true
            ));
        } else {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
    }
    function _facebook_login()
    {
        try {
            $me = $this->facebook->api('/me');
        }
        catch(Exception $e) {
            $this->Session->setFlash(__l('Problem in Facebook connect. Please try again') , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.fb_user_id' => $me['id']
            ) ,
            'fields' => array(
                'User.id',
                'User.email',
                'User.username',
                'User.password',
                'User.fb_user_id',
                'User.is_active',
            ) ,
        ));
        $this->Auth->fields['username'] = 'username';
        //create new user
        if (empty($user)) {
            $this->User->create();
            $this->data['UserProfile']['first_name'] = !empty($me['first_name']) ? $me['first_name'] : '';
            $this->data['UserProfile']['middle_name'] = !empty($me['middle_name']) ? $me['middle_name'] : '';
            $this->data['UserProfile']['last_name'] = !empty($me['last_name']) ? $me['last_name'] : '';
            $this->data['UserProfile']['about_me'] = !empty($me['about_me']) ? $me['about_me'] : '';
            if (empty($this->data['User']['username']) && strlen($me['first_name']) > 2) {
                $this->data['User']['username'] = $this->User->checkUsernameAvailable(strtolower($me['first_name']));
            }
            if (empty($this->data['User']['username']) && strlen($me['first_name'] . $me['last_name']) > 2) {
                $this->data['User']['username'] = $this->User->checkUsernameAvailable(strtolower($me['first_name'] . $me['last_name']));
            }
            if (empty($this->data['User']['username']) && strlen($me['first_name'] . $me['middle_name'] . $me['last_name']) > 2) {
                $this->data['User']['username'] = $this->User->checkUsernameAvailable(strtolower($me['first_name'] . $me['middle_name'] . $me['last_name']));
            }
            $this->data['User']['username'] = str_replace(' ', '', $this->data['User']['username']);
            $this->data['User']['username'] = str_replace('.', '_', $this->data['User']['username']);
            // A condtion to avoid unavilability of user username in our sites
            if (strlen($this->data['User']['username']) <= 2) {
                $this->data['User']['username'] = !empty($me['first_name']) ? str_replace(' ', '', strtolower($me['first_name'])) : 'fbuser';
                $i = 1;
                $created_user_name = $this->data['User']['username'] . $i;
                while (!$this->User->checkUsernameAvailable($created_user_name)) {
                    $created_user_name = $this->data['User']['username'] . $i++;
                }
                $this->data['User']['username'] = $created_user_name;
            }
            $this->data['User']['email'] = !empty($me['email']) ? $me['email'] : '';
            if (!empty($this->data['User']['email'])) {
                $check_user = $this->User->find('first', array(
                    'conditions' => array(
                        'User.email' => $this->data['User']['email']
                    ) ,
                    'recursive' => -1
                ));
				$this->data['User']['id'] = $check_user['User']['id'];
            }
			$this->data['User']['password'] = $this->Auth->password($me['id'] . Configure::read('Security.salt'));
            if (!empty($check_user['User']['email'])) {
                $this->data['User']['email'] = $check_user['User']['email'];
                $this->data['User']['username'] = $check_user['User']['username'];
                $this->data['User']['password'] = $check_user['User']['password'];
            }
            $this->data['User']['fb_user_id'] = $me['id'];
            $fb_session = $this->facebook->getSession();
            $this->data['User']['fb_access_token'] = $fb_session['access_token'];            
            $this->data['User']['is_agree_terms_conditions'] = '1';
            $this->data['User']['is_email_confirmed'] = 1;
            $this->data['User']['is_active'] = 1;
            $this->data['User']['user_type_id'] = ConstUserTypes::User;
            $this->data['User']['signup_ip'] = $this->RequestHandler->getClientIP();
            $this->data['User']['dns'] = gethostbyaddr($this->RequestHandler->getClientIP());
            $referrer_id = $this->Cookie->read('referrer');
            $this->data['User']['referred_by_user_id'] = !empty($referrer_id) ? $this->Cookie->read('referrer') : '';
            if ($this->Session->read('gift_user_id')) {
                $this->data['User']['gift_user_id'] = $this->Session->read('gift_user_id');
                $this->Session->del('gift_user_id');
            }
            //for user referral system
            if (Configure::read('user.is_referral_system_enabled')) {
                //user id will be set in cookie
                $cookie_value = $this->Cookie->read('referrer');
                if (!empty($cookie_value)) {
                    $this->data['User']['referred_by_user_id'] = $cookie_value;
                }
            }
            //end
            $this->User->save($this->data, false);
            $this->data['UserProfile']['user_id'] = $this->User->id;
            $this->User->UserProfile->save($this->data);
            if ($this->Auth->login($this->data)) {
				$this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                $this->Session->setFlash(__l('You have successfully registered with our site.') , 'default', null, 'success');
				 // send to admin mail if is_admin_mail_after_register is true
                        if (Configure::read('user.is_admin_mail_after_register')) {
                            $email = $this->EmailTemplate->selectTemplate('New User Join');
                            $emailFindReplace = array(
                                '##SITE_LINK##' => Router::url('/', true) ,
                                '##USERNAME##' => $this->data['User']['username'],
                                '##SITE_NAME##' => Configure::read('site.name') ,
                                '##SIGNUP_IP##' => $this->RequestHandler->getClientIP() ,
                                '##EMAIL##' => $this->data['User']['email'],
                                '##CONTACT_URL##' => Router::url(array(
                                    'controller' => 'contacts',
                                    'action' => 'add',
                                    'city' => $this->params['named']['city'],
                                    'admin' => false
                                ) , true) ,
                                '##FROM_EMAIL##' => $this->User->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
                                '##SITE_LOGO##' => Router::url(array(
                                    'controller' => 'img',
                                    'action' => 'blue-theme',
                                    'logo-email.png',
                                    'admin' => false
                                ) , true) ,
                            );
                            // Send e-mail to users
                            $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
                            $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
                            $this->Email->to = Configure::read('site.contact_email');
                            $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                            $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                            $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                        }
                if ($redirectUrl = $this->Session->read('Auth.redirectUrl')) {
                    $this->Session->del('Auth.redirectUrl');
                    $this->redirect(Router::url('/', true) . $redirectUrl);
                } else {
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'my_stuff#My_Purchases',
                    ));
                }
            }
        } else {
            if (!$user['User']['is_active']) {
                $this->Session->setFlash(__l('Sorry, login failed.  Your account has been blocked') , 'default', null, 'error');
                $this->redirect(Router::url('/', true));
            }
            $this->data['User']['fb_user_id'] = $me['id'];
            $fb_session = $this->facebook->getSession();
            $this->User->updateAll(array(
                'User.fb_access_token' => '\'' . $fb_session['access_token'] . '\'',
                'User.fb_user_id' => '\'' . $me['id'] . '\'',
            ) , array(
                'User.id' => $user['User']['id']
            ));
            $this->data['User']['email'] = $user['User']['email'];
            $this->data['User']['username'] = $user['User']['username'];
            $this->data['User']['password'] = $user['User']['password'];
            if ($this->Auth->login($this->data)) {
                $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                if ($redirectUrl = $this->Session->read('Auth.redirectUrl')) {
                    $this->Session->del('Auth.redirectUrl');
                    $this->redirect(Router::url('/', true) . $redirectUrl);
                } else {
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'my_stuff#My_Purchases',
                    ));
                }
            }
        }
    }
    function login($username = null)
    {
        if (!is_null($username)) {
            $this->set('username', $username);
        }
        isset($this->params['named']['qty']) ? $temp['User']['qty'] = $this->params['named']['qty'] : $temp['User']['qty'] = '';
        isset($this->params['named']['id']) ? $temp['User']['deal_id'] = $this->params['named']['id'] : $temp['User']['deal_id'] = '';
        if (isset($this->params['named']['id']) && isset($this->params['named']['id'])) {
            $temp['User']['thru_login'] = '1';
            $this->Session->write('fbuser_pymnt', $temp);
        }
        if (empty($this->data) and Configure::read('facebook.is_enabled_facebook_connect') && !$this->Auth->user() && $this->facebook->getSession() && !$this->Session->check('is_fab_session_cleared')) {
            $this->_facebook_login();
        }
        $this->pageTitle = __l('Login');
        // Twitter Login //
        if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'twitter') {
            App::import('Component', 'OauthConsumer');
            $this->OauthConsumer = &new OauthConsumerComponent();
            $requestToken = $this->OauthConsumer->getRequestToken('Twitter', 'http://twitter.com/oauth/request_token');
            $this->Session->write('requestToken', $requestToken);
            $this->redirect('http://twitter.com/oauth/authorize?oauth_token=' . $requestToken->key);
        }
        // check open id is given or not
        if (Configure::read('user.is_enable_openid') && !empty($this->data['User']['openid']) && $this->data['User']['openid'] != 'Click to Sign In' && $this->data['User']['openid'] != 'http://') {
            // Fix for given both email and openid url in login page....@todo
            $this->Auth->logout();
            $this->data['User']['email'] = '';
            $this->data['User']['password'] = '';
            $this->data['User']['redirect_page'] = 'login';
            $this->_openid();
        }
        // handle the fields return from openid
        if (!empty($_GET['openid_identity']) && Configure::read('user.is_enable_openid')) {
            $returnTo = Router::url(array(
                'controller' => 'users',
                'action' => 'login'
            ) , true);
            $response = $this->Openid->getResponse($returnTo);
            if ($response->status == Auth_OpenID_SUCCESS) {
                // Required Fields
                if ($user = $this->User->UserOpenid->find('first', array(
                    'conditions' => array(
                        'UserOpenid.openid' => $response->identity_url
                    )
                ))) {
                    //Already existing user need to do auto login
                    $this->data['User']['email'] = $user['User']['email'];
                    $this->data['User']['username'] = $user['User']['username'];
                    $this->data['User']['password'] = $user['User']['password'];
                    if ($this->Auth->login($this->data)) {
                        $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                        if ($redirectUrl = $this->Session->read('Auth.redirectUrl')) {
                            $this->Session->del('Auth.redirectUrl');
                            $this->redirect(Router::url('/', true) . $redirectUrl);
                        } else {
                            if ($this->Auth->user('user_type_id') == ConstUserTypes::Company) {
                                $company = $this->User->Company->find('first', array(
                                    'conditions' => array(
                                        'Company.user_id = ' => $this->Auth->user('id')
                                    ) ,
                                    'fields' => array(
                                        'Company.slug',
                                    ) ,
                                    'recursive' => -1
                                ));
                                $this->redirect(array(
                                    'controller' => 'deals',
                                    'action' => 'index',
                                    'company' => $company['Company']['slug'],
                                    'admin' => false
                                ));
                            } else {
                                $this->redirect(array(
                                    'controller' => 'deals',
                                    'action' => 'index'
                                ));
                            }
                        }
                    } else {
                        $this->Session->setFlash($this->Auth->loginError, 'default', null, 'error');
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'login'
                        ));
                    }
                } else {
                    $sregResponse = Auth_OpenID_SRegResponse::fromSuccessResponse($response);
                    $sreg = $sregResponse->contents();
                    $temp['username'] = isset($sreg['nickname']) ? $sreg['nickname'] : '';
                    $temp['email'] = isset($sreg['email']) ? $sreg['email'] : '';
                    $temp['openid_url'] = $response->identity_url;
                    $this->Session->write('openid', $temp);
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'register'
                    ));
                }
            } else {
                $this->Session->setFlash(__l('Authenticated failed or you may not have profile in your OpenID account'));
            }
        }
        // check the openid url is given or not
        if (empty($this->data['User']['openid']) || $this->data['User']['openid'] == 'Click to Sign In' || $this->data['User']['openid'] == 'http://') {
            // remember me for user
            if (!empty($this->data)) {
                $this->data['User'][Configure::read('user.using_to_login') ] = trim($this->data['User'][Configure::read('user.using_to_login') ]);
                //Important: For login unique username or email check validation not necessary. Also in login method authentication done before validation.
                unset($this->User->validate[Configure::read('user.using_to_login') ]['rule3']);
                $this->User->set($this->data);
                if ($this->User->validates()) {
                    $this->data['User']['password'] = $this->Auth->password($this->data['User']['passwd']);
                    if ($this->Auth->login($this->data)) {
                        $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                        if ($this->Auth->user()) {
                            $this->Session->write('is_normal_login', 1); // fix for user can login with facebook or normal with same account.
							if (!empty($this->data['User']['is_remember']) and $this->data['User']['is_remember'] == 1) {
                                $this->Cookie->del('User');
                                $cookie = array();
                                $remember_hash = md5($this->data['User'][Configure::read('user.using_to_login') ] . $this->data['User']['password'] . Configure::read('Security.salt'));
                                $cookie['cookie_hash'] = $remember_hash;
                                $this->Cookie->write('User', $cookie, true, $this->cookieTerm);
                                $this->User->updateAll(array(
                                    'User.cookie_hash' => '\'' . md5($remember_hash) . '\'',
                                    'User.cookie_time_modified' => '\'' . date('Y-m-d h:i:s') . '\'',
                                ) , array(
                                    'User.id' => $this->Auth->user('id')
                                ));
                            } else {
                                $this->Cookie->del('User');
                            }
                            if ($this->RequestHandler->isAjax()) {
                                if (!empty($this->data['User']['f'])) {
                                    echo 'redirect*' . Router::url('/', true) . $this->data['User']['f'];
                                } else {
                                    echo 'success';
                                }
                                exit;
                            } else if (!empty($this->data['User']['f'])) {
                                if ($this->Auth->user('user_type_id') == ConstUserTypes::Company) {
                                    $company = $this->User->Company->find('first', array(
                                        'conditions' => array(
                                            'Company.user_id = ' => $this->Auth->user('id')
                                        ) ,
                                        'fields' => array(
                                            'Company.slug',
                                        ) ,
                                        'recursive' => -1
                                    ));
                                    $this->redirect(array(
                                        'controller' => 'deals',
                                        'action' => 'index',
                                        'company' => $company['Company']['slug'],
                                        'admin' => false
                                    ));
                                } else {
                                    $this->redirect(Router::url('/', true) . $this->data['User']['f']);
                                }
                            } else if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                                $this->redirect(array(
                                    'controller' => 'users',
                                    'action' => 'stats',
                                    'admin' => true
                                ));
                            } elseif ($this->Auth->user('user_type_id') == ConstUserTypes::User) {
                                $this->redirect(array(
                                    'controller' => 'users',
                                    'action' => 'my_stuff#My_Purchases',
                                    'admin' => false
                                ));
                            } elseif ($this->Auth->user('user_type_id') == ConstUserTypes::Company) {
                                $company = $this->User->Company->find('first', array(
                                    'conditions' => array(
                                        'Company.user_id = ' => $this->Auth->user('id')
                                    ) ,
                                    'fields' => array(
                                        'Company.slug',
                                    ) ,
                                    'recursive' => -1
                                ));
                                $this->redirect(array(
                                    'controller' => 'deals',
                                    'action' => 'index',
                                    'company' => $company['Company']['slug'],
                                    'admin' => false
                                ));
                            }
                        }
                    } else {
                        if (!empty($this->params['prefix']) && $this->params['prefix'] == 'admin') {
                            $this->Session->setFlash(sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login')) , 'default', null, 'error');
                        } else {
                            $this->Session->setFlash($this->Auth->loginError, 'default', null, 'error');
                        }
                    }
                } else {
                    $this->Session->setFlash($this->Auth->loginError, 'default', null, 'error');
                }
            } else {
                if (!empty($this->params['named']['f'])) {
                    $this->data['User']['f'] = $this->params['named']['f'];
                }
                if (!empty($this->params['requested'])) {
                    $this->data['User']['is_requested'] = 1;
                }
            }
        }
        //When already logged user trying to access the login page we are redirecting to site home page
        if ($this->Auth->user()) {
            $this->redirect(Router::url('/', true));
        }
        $this->data['User']['passwd'] = '';
    }
    function oauth_callback()
    {
        $this->autoRender = false;
        $requestToken = $this->Session->read('requestToken');
        $accessToken = $this->OauthConsumer->getAccessToken('Twitter', 'http://twitter.com/oauth/access_token', $requestToken);
        $this->Session->write('accessToken', $accessToken);
        $xml = $this->OauthConsumer->get('Twitter', $accessToken->key, $accessToken->secret, 'https://twitter.com/account/verify_credentials.xml');
        $this->data['User']['twitter_access_token'] = (isset($accessToken->key)) ? $accessToken->key : '';;
        $this->data['User']['twitter_access_key'] = (isset($accessToken->secret)) ? $accessToken->secret : '';
        $twitter_city_id = $this->Session->read('twitter_city_id');
        // So this to check whether it is  admin login to get its twiiter acces tocken
        if (!empty($twitter_city_id)) {
            $this->User->Company->City->updateAll(array(
                'City.twitter_access_token' => '\'' . $this->data['User']['twitter_access_token'] . '\'',
                'City.twitter_access_key' => '\'' . $this->data['User']['twitter_access_key'] . '\'',
            ) , array(
                'City.id' => $twitter_city_id
            ));
            $this->Session->delete('twitter_city_id');
            $this->Session->setFlash(__l('City Twitter credentials are updated') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'cities',
                'admin' => true
            ));
        } else if ($this->Auth->user('id') and $this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
            App::import('Model', 'Setting');
            $setting = new Setting;
            $setting->updateAll(array(
                'Setting.value' => '\'' . $this->data['User']['twitter_access_token'] . '\'',
            ) , array(
                'Setting.name' => 'twitter.site_user_access_token'
            ));
            $setting->updateAll(array(
                'Setting.value' => '\'' . $this->data['User']['twitter_access_key'] . '\''
            ) , array(
                'Setting.name' => 'twitter.site_user_access_key'
            ));
            $this->Session->setFlash(__l('Your Twitter credentials are updated') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'settings',
                'admin' => true
            ));
        }
        App::import('Xml');
        $Xml = new Xml($xml);
        $data = $Xml->toArray();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.twitter_user_id =' => $data['User']['id']
            ) ,
            'fields' => array(
                'User.id',
                'UserProfile.id',
                'User.user_type_id'
            ) ,
            'recursive' => 0
        ));
        if (empty($user)) {
            $this->data['User']['is_email_confirmed'] = 1;
            $this->data['User']['is_active'] = 1;
            $this->data['User']['is_agree_terms_conditions'] = '1';
            $this->data['User']['user_type_id'] = ConstUserTypes::User;
            $this->data['User']['signup_ip'] = $this->RequestHandler->getClientIP();
            $this->data['User']['dns'] = gethostbyaddr($this->RequestHandler->getClientIP());
            $this->data['User']['pin'] = ($data['User']['id']+Configure::read('user.pin_formula')) %10000;
            $this->data['User']['twitter_user_id'] = $data['User']['id'];
            $created_user_name = $this->User->checkUsernameAvailable($data['User']['screen_name']);
            if (strlen($created_user_name) <= 2) {
                $this->data['User']['username'] = !empty($data['User']['screen_name']) ? $data['User']['screen_name'] : 'twuser';
                $i = 1;
                $created_user_name = $this->data['User']['username'] . $i;
                while (!$this->User->checkUsernameAvailable($created_user_name)) {
                    $created_user_name = $this->data['User']['username'] . $i++;
                }
            }
            $this->data['User']['username'] = $created_user_name;
        } else {
            $this->data['User']['id'] = $user['User']['id'];
        }
        unset($this->User->validate['username']['rule2']);
        unset($this->User->validate['username']['rule3']);
        $this->data['User']['password'] = $this->Auth->password($data['User']['id'] . Configure::read('Security.salt'));
        $this->data['User']['avatar_url'] = $data['User']['profile_image_url'];
        $this->data['User']['twitter_url'] = (isset($data['User']['url'])) ? $data['User']['url'] : '';
        $this->data['User']['description'] = (isset($data['User']['description'])) ? $data['User']['description'] : '';
        $this->data['User']['location'] = (isset($data['User']['location'])) ? $data['User']['location'] : '';
        if ($this->User->save($this->data)) {
            if ($this->Auth->login($this->data)) {
                $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                $this->redirect(array(
                    'controller' => 'deals',
                    'action' => 'index',
                ));
            }
        }
        if (!empty($this->data['User']['f'])) {
            $this->redirect(Router::url('/', true) . $this->data['User']['f']);
        }
        $this->redirect(Router::url('/', true));
    }
    function logout()
    {
        if ($this->Auth->user('fb_user_id')) {
            $this->facebook->setSession(); // Quick fix for facebook redirect loop issue.
            $this->Session->write('is_fab_session_cleared', 1); // Quick fix for facebook redirect loop issue.

        }
		$this->Session->del('is_normal_login');
        $this->Auth->logout();
        $this->Cookie->del('User');
        $this->Cookie->del('user_language');
        $this->Session->setFlash(__l('You are now logged out of the site.') , 'default', null, 'success');
        $this->Session->del('fbuser_pymnt');
        $redirect_url = array(
            'controller' => 'users',
            'action' => 'login'
        );
        if (!empty($this->params['named']['city'])) {
            $redirect_url['city'] = $this->params['named']['city'];
        }
        $this->redirect($redirect_url);
    }
    function forgot_password()
    {
        $this->pageTitle = __l('Forgot Password');
        if ($this->Auth->user('id')) {
            $this->redirect(Router::url('/', true));
        }
        if (!empty($this->data)) {
            $this->User->set($this->data);
            //Important: For forgot password unique email id check validation not necessary.
            unset($this->User->validate['email']['rule3']);
            if ($this->User->validates()) {
                $user = $this->User->find('first', array(
                    'conditions' => array(
                        'User.email =' => $this->data['User']['email'],
                        'User.is_active' => 1
                    ) ,
                    'fields' => array(
                        'User.id',
                        'User.email'
                    ) ,
                    'contain' => array(
                        'UserProfile'
                    ) ,
                    'recursive' => 1
                ));
                if (!empty($user['User']['email'])) {
                    $user = $this->User->find('first', array(
                        'conditions' => array(
                            'User.email' => $user['User']['email']
                        ) ,
                        'recursive' => -1
                    ));
					$language_code = $this->User->getUserLanguageIso($user['User']['id']);
					$email = $this->EmailTemplate->selectTemplate('Forgot Password', $language_code);
                    $emailFindReplace = array(
                        '##SITE_LINK##' => Router::url('/', true) ,
                        '##USERNAME##' => (isset($user['User']['username'])) ? $user['User']['username'] : '',
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##SUPPORT_EMAIL##' => Configure::read('site.contact_email') ,
                        '##RESET_URL##' => Router::url(array(
                            'controller' => 'users',
                            'action' => 'reset',
                            $user['User']['id'],
                            $this->User->getResetPasswordHash($user['User']['id'])
                        ) , true) ,
                        '##FROM_EMAIL##' => $this->User->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
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
                    $this->Email->to = $this->User->formatToAddress($user);
                    $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                    $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                    $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                    $this->Session->setFlash(__l('An email has been sent with a link where you can change your password') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'login'
                    ));
                } else {
                    $this->Session->setFlash(sprintf(__l('There is no user registered with the email %s or admin deactivated your account. If you spelled the address incorrectly or entered the wrong address, please try again.') , $this->data['User']['email']) , 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(__l('Please Enter valid Email id') , 'default', null, 'error');
            }
        }
    }
    function reset($user_id = null, $hash = null)
    {
        $this->pageTitle = __l('Reset Password');
        if (!empty($this->data)) {
            if ($this->User->isValidResetPasswordHash($this->data['User']['user_id'], $this->data['User']['hash'])) {
                $this->User->set($this->data);
                if ($this->User->validates()) {
                    $this->User->updateAll(array(
                        'User.password' => '\'' . $this->Auth->password($this->data['User']['passwd']) . '\'',
                    ) , array(
                        'User.id' => $this->data['User']['user_id']
                    ));
                    $this->Session->setFlash(__l('Your password changed successfully, Please login now') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'login'
                    ));
                }
                $this->Session->setFlash(__l('Could not update your password, please enter password.') , 'default', null, 'error');
                $this->data['User']['passwd'] = '';
                $this->data['User']['confirm_password'] = '';
            } else {
                $this->Session->setFlash(__l('Invalid change password request'));
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login'
                ));
            }
        } else {
            if (is_null($user_id) or is_null($hash)) {
                $this->cakeError('error404');
            }
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id,
                    'User.is_active' => 1,
                ) ,
                'recursive' => -1
            ));
            if (empty($user)) {
                $this->Session->setFlash(__l('User cannot be found in server or admin deactivated your account, please register again'));
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'register'
                ));
            }
            if (!$this->User->isValidResetPasswordHash($user_id, $hash)) {
                $this->Session->setFlash(__l('Invalid change password request'));
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login'
                ));
            }
            $this->data['User']['user_id'] = $user_id;
            $this->data['User']['hash'] = $hash;
        }
    }
    function change_password($user_id = null)
    {
        $this->pageTitle = __l('Change Password');
        if (($this->Auth->user('user_type_id') == ConstUserTypes::Company) || ($this->Auth->user('user_type_id') == ConstUserTypes::User)) {
            if ($this->Auth->User('id') != $user_id && !is_null($user_id)) {
                $this->cakeError('error404');
            }
            if ($this->Auth->user('fb_user_id') || $this->Auth->user('is_openid_register')) {
                $this->cakeError('error404');
            }
        }
        if (!empty($this->data)) {
			if (Configure::read('site.is_admin_settings_enabled')) {
            $this->User->set($this->data);
            if ($this->User->validates()) {
                if ($this->User->updateAll(array(
                    'User.password' => '\'' . $this->Auth->password($this->data['User']['passwd']) . '\'',
                ) , array(
                    'User.id' => $this->data['User']['user_id']
                ))) {
                    if ($this->Auth->user('user_type_id') != ConstUserTypes::Admin && Configure::read('user.is_logout_after_change_password')) {
                        $this->Auth->logout();
                        $this->Session->setFlash(__l('Your password changed successfully. Please login now') , 'default', null, 'success');
                        if ($this->RequestHandler->isAjax()) {
                            echo 'redirect*' . Router::url(array(
                                'controller' => 'users',
                                'action' => 'login',
                            ) , true);
                            exit;
                        } else {
                            $this->redirect(array(
                                'controller' => 'users',
                                'action' => 'login'
                            ));
                        }
                    } elseif ($this->Auth->user('user_type_id') == ConstUserTypes::Admin && $this->Auth->user('id') != $this->data['User']['user_id']) {
                        $user = $this->User->find('first', array(
                            'conditions' => array(
                                'User.id' => $this->data['User']['user_id']
                            ) ,
                            'fields' => array(
                                'User.username',
                                'User.email',
                                'User.id'
                            ) ,
                            'contain' => array(
                                'UserProfile'
                            ) ,
                            'recursive' => 1
                        ));
						$language_code = $this->User->getUserLanguageIso($user['User']['id']);
						$email = $this->EmailTemplate->selectTemplate('Admin Change Password', $language_code);
                        $emailFindReplace = array(
                            '##SITE_LINK##' => Router::url('/', true) ,
                            '##PASSWORD##' => $this->data['User']['passwd'],
                            '##USERNAME##' => $user['User']['username'],
                            '##SITE_NAME##' => Configure::read('site.name') ,
                            '##FROM_EMAIL##' => $this->User->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
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
                        // Send e-mail to users
                        $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
                        $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
                        $this->Email->to = $this->User->formatToAddress($user);
                        $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                        $this->Email->subject = strtr($email['subject'], $emailFindReplace);
						$this->Email->send(strtr($email['email_content'], $emailFindReplace));
                    }
                    if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin && $this->Auth->user('id') != $this->data['User']['user_id']) {
                        $this->Session->setFlash(sprintf(__l('%s \'s password changed successfully.') , $user['User']['username']) , 'default', null, 'success');
                    } else {
                        $this->Session->setFlash(__l('Your password changed successfully') , 'default', null, 'success');
                    }
                } else {
                    $this->Session->setFlash(__l('Password could not be changed') , 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(__l('Password could not be changed') , 'default', null, 'error');
            }
            unset($this->data['User']['old_password']);
            unset($this->data['User']['passwd']);
            unset($this->data['User']['confirm_password']);
			}
			else {
                $this->Session->setFlash(__l('Sorry. You Cannot Update the password in Demo Mode') , 'default', null, 'error');
            }
        } else {
            if (empty($user_id)) {
                $user_id = $this->Auth->user('id');
            }
        }
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
            $users = $this->User->find('list', array(
                'conditions' => array(
					'OR' => array(
						array(
							'User.fb_user_id =' => NULL,
							'User.is_openid_register = ' => 0,
							'User.user_type_id' => 2,
						),
						array(
							'User.user_type_id' => 3,
							'Company.is_online_account' => 1
						),
						array(
							'User.user_type_id' => 1,
						),							
					)
				) ,
				'contain' => array(
					'Company'
				),
				'recursive' => 1
            ));
            $this->set(compact('users'));
        }
        $this->data['User']['user_id'] = (!empty($this->data['User']['user_id'])) ? $this->data['User']['user_id'] : $user_id;
    }
    function admin_index()
    {
        $count_conditions = array();
        $this->_redirectGET2Named(array(
            'company_type',
            'q',
        ));
        $this->pageTitle = __l('Users');
        $conditions = array();
        if (!empty($this->data['User']['main_filter_id'])) {
            $this->params['named']['main_filter_id'] = $this->data['User']['main_filter_id'];
        }
        if (!empty($this->data['User']['filter_id'])) {
            $this->params['named']['filter_id'] = $this->data['User']['filter_id'];
        }
        if (isset($this->params['named']['stat']) && $this->params['named']['stat'] == 'day') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(User.created) <= '] = 0;
            $this->pageTitle.= __l(' - Registered today');
        }
        if (isset($this->params['named']['stat']) && $this->params['named']['stat'] == 'week') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(User.created) <= '] = 7;
            $this->pageTitle.= __l(' - Registered in this week');
        }
        if (isset($this->params['named']['stat']) && $this->params['named']['stat'] == 'month') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(User.created) <= '] = 30;
            $this->pageTitle.= __l(' - Registered in this month');
        }
        if (isset($this->params['named']['stat'])) {
            $conditions['User.user_type_id !='] = ConstUserTypes::Company;
        }
        $param_string = "";
        $param_string.= !empty($this->params['named']['filter_id']) ? '/filter_id:' . $this->params['named']['filter_id'] : $param_string;
        $param_string.= !empty($this->params['named']['main_filter_id']) ? '/main_filter_id:' . $this->params['named']['main_filter_id'] : $param_string;
        if (!empty($this->params['named']['stat'])) {
            $param_string.= !empty($this->params['named']['stat']) ? '/stat:' . $this->params['named']['stat'] : $param_string;
        }
        if (!empty($this->params['named']['main_filter_id'])) {
            if ($this->params['named']['main_filter_id'] == ConstMoreAction::OpenID) {
                $conditions['User.is_openid_register'] = 1;
                $this->pageTitle.= __l(' - Registered through OpenID ');
            } else if ($this->params['named']['main_filter_id'] == ConstMoreAction::FaceBook) {
                $conditions['User.fb_user_id != '] = NULL;
                $this->pageTitle.= __l(' - Registered through Facebook ');
            } else if ($this->params['named']['main_filter_id'] == ConstUserTypes::User) {
                $conditions['User.user_type_id'] = ConstUserTypes::User;
                $conditions['User.fb_user_id'] = Null;
                $conditions['User.is_openid_register'] = 0;
            } else if ($this->params['named']['main_filter_id'] == ConstUserTypes::Admin) {
                $conditions['User.user_type_id'] = ConstUserTypes::Admin;
                $this->pageTitle.= __l(' - Admin ');
            } else if ($this->params['named']['main_filter_id'] == 'gift_card') {
                $conditions['User.gift_user_id != '] = NULL;
                $this->pageTitle.= __l(' - Registered Via Gift Card');
            } else if ($this->params['named']['main_filter_id'] == 'all') {
                $conditions['User.user_type_id != '] = ConstUserTypes::Company;
                $this->pageTitle.= __l(' - All ');
            }
        }
        $count_conditions = $conditions;
        if (!empty($this->params['named']['filter_id'])) {
            if ($this->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['User.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['User.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            }
        }
        if (isset($this->data['User']['q']) && !empty($this->data['User']['q'])) {
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->data['User']['q']);
            $param_string.= '/q:' . $this->data['User']['q'];
            $this->params['named']['q'] = $this->data['User']['q'];
        } else if (isset($this->params['named']['q'])) {
            $this->data['User']['q'] = $this->params['named']['q'];
        }
        if (!Configure::read('user.is_enable_openid')) {
            $count_conditions['User.is_openid_register'] = 0;
            $conditions['User.is_openid_register'] = 0;
        }
        if (!Configure::read('facebook.is_enabled_facebook_connect')) {
            $conditions['User.fb_user_id'] = null;
            $count_conditions['User.fb_user_id'] = null;
        }
        if ($this->RequestHandler->prefers('csv')) {
            Configure::write('debug', 0);
            $this->set('user', $this);
            $this->set('conditions', $conditions);
            if (isset($this->data['User']['q'])) {
                $this->set('q', $this->data['User']['q']);
            }
            $this->set('contain', $contain);
        } else {
            $this->User->recursive = 2;
            $this->paginate = array(
                'conditions' => $conditions,
                'contain' => array(
                    'Company',
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.dir',
                            'UserAvatar.filename',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    ) ,
                    'RefferalUser' => array(
                        'UserAvatar' => array(
                            'fields' => array(
                                'UserAvatar.id',
                                'UserAvatar.dir',
                                'UserAvatar.filename',
                                'UserAvatar.width',
                                'UserAvatar.height'
                            )
                        )
                    ) ,
                    'GiftRecivedFromUser' => array(
                        'fields' => array(
                            'GiftRecivedFromUser.user_type_id',
                            'GiftRecivedFromUser.username',
                            'GiftRecivedFromUser.id',
							'GiftRecivedFromUser.fb_user_id',
                        ) ,
                        'UserAvatar' => array(
                            'fields' => array(
                                'UserAvatar.id',
                                'UserAvatar.dir',
                                'UserAvatar.filename',
                                'UserAvatar.width',
                                'UserAvatar.height'
                            )
                        )
                    ) ,
                ) ,
                'order' => array(
                    'User.id' => 'desc'
                )
            );
            $export_users = $this->User->find('all', array(
                'conditions' => $conditions,
                'recursive' => -1
            ));
            if (!empty($export_users)) {
                $ids = array();
                foreach($export_users as $export_user) {
                    $ids[] = $export_user['User']['id'];
                }
                $hash = $this->User->getIdHash(implode(',', $ids));
                $_SESSION['export_users'][$hash] = $ids;
                $this->set('export_hash', $hash);
            }
            if (isset($this->data['User']['q']) && !empty($this->data['User']['q'])) {
                $this->paginate['search'] = $this->data['User']['q'];
            }
            $this->set('param_string', $param_string);
            $this->set('users', $this->paginate());
            $this->set('pageTitle', $this->pageTitle);
            if (!empty($this->params['named']['main_filter_id']) && $this->params['named']['main_filter_id'] == ConstUserTypes::Admin) {
                $moreActions = $this->User->adminMoreActions;
            } else {
                $moreActions = $this->User->moreActions;
            }
            $this->set(compact('moreActions'));
            // total approved users list
            $this->set('active', $this->User->find('count', array(
                'conditions' => array(
                    'User.is_active' => 1,
                    $count_conditions
                ) ,
                'recursive' => -1
            )));
            // total approved users list
            $this->set('inactive', $this->User->find('count', array(
                'conditions' => array(
                    'User.is_active' => 0,
                    $count_conditions
                ) ,
                'recursive' => -1
            )));
        }
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add New User/Admin');
        if (!empty($this->data)) {
            $this->data['User']['password'] = $this->Auth->password($this->data['User']['passwd']);
            $this->data['User']['is_agree_terms_conditions'] = '1';
            $this->data['User']['is_email_confirmed'] = 1;
            $this->data['User']['is_active'] = 1;
            $this->data['User']['signup_ip'] = $this->RequestHandler->getClientIP();
            $this->data['User']['dns'] = gethostbyaddr($this->RequestHandler->getClientIP());
            $this->User->create();
            $this->User->UserProfile->set($this->data);
            if ($this->User->save($this->data) &$this->User->UserProfile->validates()) {
                $this->data['UserProfile']['user_id'] = $this->User->getLastInsertId();
                $this->User->UserProfile->create();
                $this->User->UserProfile->save($this->data);
                // Send mail to user to activate the account and send account details
                $email = $this->EmailTemplate->selectTemplate('Admin User Add');
                $emailFindReplace = array(
                    '##SITE_LINK##' => Router::url('/', true) ,
                    '##USERNAME##' => $this->data['User']['username'],
                    '##LOGINLABEL##' => ucfirst(Configure::read('user.using_to_login')) ,
                    '##USEDTOLOGIN##' => $this->data['User'][Configure::read('user.using_to_login') ],
                    '##SITE_NAME##' => Configure::read('site.name') ,
                    '##PASSWORD##' => $this->data['User']['passwd'],
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
                    '##FROM_EMAIL##' => $this->User->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
                );
                $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
                $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
                $this->Email->to = $this->data['User']['email'];
                $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                $this->Session->setFlash(__l('User has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                unset($this->data['User']['passwd']);
                $this->Session->setFlash(__l('User could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $userTypes = $this->User->UserType->find('list', array(
            'conditions' => array(
                'UserType.id !=' => ConstUserTypes::Company
            )
        ));
        $this->set(compact('userTypes'));
        if (!isset($this->data['User']['user_type_id'])) {
            $this->data['User']['user_type_id'] = ConstUserTypes::User;
        }
        $cities = $this->User->UserProfile->City->find('list', array(
            'conditions' => array(
                'City.is_approved =' => 1
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
        $states = $this->User->UserProfile->State->find('list');
        $this->set(compact('cities', 'states'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id) && $id == ConstUserTypes::Admin) {
            $this->cakeError('error404');
        }
        $this->_sendAdminActionMail($id, 'Admin User Delete');
        if ($this->User->del($id)) {
            $this->Session->setFlash(__l('User deleted') , 'default', null, 'success');
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
        if (!empty($this->data['User'])) {
            $r = $this->data[$this->modelClass]['r'];
            $actionid = $this->data[$this->modelClass]['more_action_id'];
            unset($this->data[$this->modelClass]['r']);
            unset($this->data[$this->modelClass]['more_action_id']);
            $userIds = array();
            foreach($this->data['User'] as $user_id => $is_checked) {
                if ($is_checked['id']) {
                    $userIds[] = $user_id;
                }
            }
            if ($actionid && !empty($userIds)) {
                if ($actionid == ConstMoreAction::Inactive) {
                    $this->User->updateAll(array(
                        'User.is_active' => 0,
                    ) , array(
                        'User.id' => $userIds
                    ));
                    foreach($userIds as $key => $user_id) {
                        $this->_sendAdminActionMail($user_id, 'Admin User Deactivate');
                    }
                    $this->Session->setFlash(__l('Checked users has been inactivated') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Active) {
                    $this->User->updateAll(array(
                        'User.is_active' => 1
                    ) , array(
                        'User.id' => $userIds
                    ));
                    foreach($userIds as $key => $user_id) {
                        $this->_sendAdminActionMail($user_id, 'Admin User Active');
                    }
                    $this->Session->setFlash(__l('Checked users has been activated') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Delete) {
                    foreach($userIds as $key => $user_id) {
                        $this->_sendAdminActionMail($user_id, 'Admin User Delete');
                    }
                    $this->User->deleteAll(array(
                        'User.id' => $userIds
                    ));
                    $this->Session->setFlash(__l('Checked users has been deleted') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Export) {
                    $user_ids = implode(',', $userIds);
                    $hash = $this->User->getUserIdHash($user_ids);
                    $_SESSION['user_export'][$hash] = $userIds;
                    echo 'redirect*' . Router::url(array(
                        'controller' => 'users',
                        'action' => 'export',
                        'ext' => 'csv',
                        $hash,
                        'admin' => true
                    ) , true);
                    exit;
                } else if ($actionid == ConstMoreAction::EnableCompanyProfile) {
                    $this->User->Company->updateAll(array(
                        'Company.is_company_profile_enabled' => 1
                    ) , array(
                        'Company.user_id' => $userIds
                    ));
                    $this->Session->setFlash(__l('Checked companies profile has been enabled') , 'default', null, 'success');
                }
            }
        }
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect(Router::url('/', true) . $r);
        } else {
            $this->redirect($r);
        }
    }
    function _sendAdminActionMail($user_id, $email_template)
    {
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'fields' => array(
                'User.username',
                'User.id',
                'User.email'
            ) ,
            'contain' => array(
                'UserProfile'
            ) ,
            'recursive' => 1
        ));
		$language_code = $this->User->getUserLanguageIso($user['User']['id']);
		$email = $this->EmailTemplate->selectTemplate($email_template, $language_code);
        $emailFindReplace = array(
            '##SITE_LINK##' => Router::url('/', true) ,
            '##USERNAME##' => $user['User']['username'],
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##FROM_EMAIL##' => $this->User->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
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
        $this->Email->to = $this->User->formatToAddress($user);
        $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
        $this->Email->subject = strtr($email['subject'], $emailFindReplace);
        $this->Email->send(strtr($email['email_content'], $emailFindReplace));
    }
    function admin_stats()
    {
        $this->loadModel('Deal');
        $this->loadModel('Company');
        $this->loadModel('UserCashWithdrawal');
        $this->loadModel('Transaction');
        $this->pageTitle = __l('Site Stats');
        $periods = array(
            'day' => array(
                'display' => __l('Today') ,
                'conditions' => array(
                    'TO_DAYS(NOW()) - TO_DAYS(created) <= ' => 0,
                )
            ) ,
            'week' => array(
                'display' => __l('This week') ,
                'conditions' => array(
                    'TO_DAYS(NOW()) - TO_DAYS(created) <= ' => 7,
                )
            ) ,
            'month' => array(
                'display' => __l('This month') ,
                'conditions' => array(
                    'TO_DAYS(NOW()) - TO_DAYS(created) <= ' => 30,
                )
            ) ,
            'total' => array(
                'display' => __l('Total') ,
                'conditions' => array()
            )
        );
        $user_conditions = array();
        $user_conditions['User.user_type_id !='] = 3;
        if (!Configure::read('user.is_enable_openid')) {
            $user_conditions['User.is_openid_register'] = '';
        }
        $models[] = array(
            'User' => array(
                'display' => __l('Users') ,
                'conditions' => $user_conditions,
                'link' => array(
                    'controller' => 'users',
                    'action' => 'index'
                ) ,
                'colspan' => 2
            )
        );
        $models[] = array(
            'Company' => array(
                'display' => __l('Companies') ,
                'link' => array(
                    'controller' => 'companies',
                    'action' => 'index'
                ) ,
                'colspan' => 2
            )
        );
        //Configure::write('debug', 1);
        // Admin Citywise Filter //
        $city_filter_id = $this->Session->read('city_filter_id');
        $conditions = array();
		if(!empty($city_filter_id)){
            $deal_cities = $this->User->UserProfile->City->find('first', array(
                'conditions' => array(
                    'City.id' => $city_filter_id
                ) ,
                'fields' => array(
                    'City.name'
                ) ,
				'contain'=>array(
					'Deal'=>array(
						'fields' => array(
							'Deal.id'
						),
					)	
				),
                'recursive' => 1
            ));
			foreach($deal_cities['Deal'] as $deal_city){
				$city_deal_id[] = $deal_city['id'];
			}
			$conditions['Deal.id'] = $city_deal_id;
		}
        $models[] = array(
            'Deal' => array(
                'display' => __l('Deals') ,
                'link' => array(
                    'controller' => 'deals',
                    'action' => 'index'
                ) ,
                'rowspan' => 7
            )
        );
        $models[] = array(
            'Deal' => array(
                'display' => __l('Open') ,
                'link' => array(
                    'controller' => 'deals',
                    'action' => 'index',
                    'filter_id' => ConstDealStatus::Open
                ) ,
                'conditions' => array_merge(array(
                    'Deal.deal_status_id' => ConstDealStatus::Open
                ) , $conditions) ,
                'alias' => 'DealOpen',
                'isSub' => 'Deal'
            )
        );
        $models[] = array(
            'Deal' => array(
                'display' => __l('Draft') ,
                'link' => array(
                    'controller' => 'deals',
                    'action' => 'index',
                    'filter_id' => ConstDealStatus::Draft
                ) ,
                'conditions' => array_merge(array(
                    'Deal.deal_status_id' => ConstDealStatus::Draft
                ) , $conditions) ,
                'alias' => 'DealDraft',
                'isSub' => 'Deal'
            )
        );
        $models[] = array(
            'Deal' => array(
                'display' => __l('Pending') ,
                'link' => array(
                    'controller' => 'deals',
                    'action' => 'index',
                    'filter_id' => ConstDealStatus::PendingApproval
                ) ,
                'conditions' => array_merge(array(
                    'Deal.deal_status_id' => ConstDealStatus::PendingApproval
                ) , $conditions) ,
                'alias' => 'DealPending',
                'isSub' => 'Deal'
            )
        );
        $models[] = array(
            'Deal' => array(
                'display' => __l('Tipped') ,
                'link' => array(
                    'controller' => 'deals',
                    'action' => 'index',
                    'filter_id' => ConstDealStatus::Tipped
                ) ,
                'conditions' => array_merge(array(
                    'Deal.deal_status_id' => ConstDealStatus::Tipped
                ) , $conditions) ,
                'alias' => 'DealTipped',
                'isSub' => 'Deal'
            )
        );
        $models[] = array(
            'Deal' => array(
                'display' => __l('Closed') ,
                'link' => array(
                    'controller' => 'deals',
                    'action' => 'index',
                    'filter_id' => ConstDealStatus::Closed
                ) ,
                'conditions' => array_merge(array(
                    'Deal.deal_status_id' => ConstDealStatus::Closed
                ) , $conditions) ,
                'alias' => 'DealClosed',
                'isSub' => 'Deal'
            )
        );
        $models[] = array(
            'Deal' => array(
                'display' => __l('Paid To Company') ,
                'link' => array(
                    'controller' => 'deals',
                    'action' => 'index',
                    'filter_id' => ConstDealStatus::PaidToCompany
                ) ,
                'conditions' => array_merge(array(
                    'Deal.deal_status_id' => ConstDealStatus::PaidToCompany
                ) , $conditions) ,
                'alias' => 'DealPaidToCompany',
                'isSub' => 'Deal'
            )
        );
        $models[] = array(
            'Deal' => array(
                'display' => __l('All') ,
                'link' => array(
                    'controller' => 'deals',
                    'action' => 'index',
                ) ,
                'conditions' => $conditions,
                'alias' => 'DealAll',
                'isSub' => 'Deal'
            )
        );
        $models[] = array(
            'Transaction' => array(
                'display' => __l('Transactions') . ' (' . Configure::read('site.currency') . ')',
                'link' => array(
                    'controller' => 'Transaction',
                    'action' => 'index'
                ) ,
                'rowspan' => 4
            )
        );
        $models[] = array(
            'Transaction' => array(
                'display' => __l('Paid Referral Amount') ,
                'link' => array(
                    'controller' => 'transactions',
                    'action' => 'index',
                    'type' => 11
                ) ,
                'conditions' => array(
                    'Transaction.transaction_type_id' => ConstTransactionTypes::ReferralAmountPaid
                ) ,
                'alias' => 'TransactionReferral',
                'isSub' => 'Transaction'
            )
        );
        $models[] = array(
            'Transaction' => array(
                'display' => __l('Paid Amount to Company') ,
                'link' => array(
                    'controller' => 'transactions',
                    'action' => 'index',
                    'type' => 7
                ) ,
                'conditions' => array(
                    'Transaction.transaction_type_id' => ConstTransactionTypes::PaidDealAmountToCompany
                ) ,
                'alias' => 'TransactionPaidToCompany',
                'isSub' => 'Transaction'
            )
        );
        $models[] = array(
            'Transaction' => array(
                'display' => __l('Withdrawn Amount by Users and Companies') ,
                'link' => array(
                    'controller' => 'transactions',
                    'action' => 'index',
                    'type' => 13
                ) ,
                'conditions' => array(
                    'Transaction.transaction_type_id' => ConstTransactionTypes::AcceptCashWithdrawRequest
                ) ,
                'alias' => 'TransactionWithdrawAmount',
                'isSub' => 'Transaction'
            )
        );
        $models[] = array(
            'Transaction' => array(
                'display' => __l('Deposits to Wallet') ,
                'link' => array(
                    'controller' => 'transactions',
                    'action' => 'index',
                    'type' => 1
                ) ,
                'conditions' => array(
                    'Transaction.transaction_type_id' => ConstTransactionTypes::AddedToWallet
                ) ,
                'alias' => 'TransactionAmountToWallet',
                'isSub' => 'Transaction'
            )
        );
        $models[] = array(
            'UserCashWithdrawal' => array(
                'display' => __l('No. of Pending Withdraw Request') ,
                'link' => array(
                    'controller' => 'user_cash_withdrawals',
                    'action' => 'index',
                    'filter_id' => ConstWithdrawalStatus::Pending,
                ) ,
                'conditions' => array(
                    'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Pending,
                ) ,
                'colspan' => 2
            )
        );
        $models[] = array(
            'Deal' => array(
                'display' => __l('Total Commission Amount Earned') . ' (' . Configure::read('site.currency') . ')',
                'conditions' => array_merge(array(
                    'Deal.deal_status_id' => array(
                        ConstDealStatus::PaidToCompany
                    )
                ) , $conditions) ,
                'alias' => 'DealCommssionAmount',
                'type' => 'cFloat',
                'colspan' => 2
            )
        );
        foreach($models as $unique_model) {
            foreach($unique_model as $model => $fields) {
                foreach($periods as $key => $period) {
                    $conditions = $period['conditions'];
                    if (!empty($fields['conditions'])) {
                        $conditions = array_merge($periods[$key]['conditions'], $fields['conditions']);
                    }
                    $aliasName = !empty($fields['alias']) ? $fields['alias'] : $model;
                    if ($model == 'Transaction') {
                        $TransTotAmount = $this->{$model}->find('first', array(
                            'conditions' => $conditions,
                            'fields' => array(
                                'SUM(Transaction.amount) as total_amount'
                            ) ,
                            'recursive' => -1
                        ));
                        $this->set($aliasName . $key, $TransTotAmount['0']['total_amount']);
                    } else if ($model == 'Deal' && $aliasName == 'DealCommssionAmount') {
                        $TransTotAmount = $this->{$model}->find('first', array(
                            'conditions' => $conditions,
                            'fields' => array(
                                'SUM(Deal.total_commission_amount) as total_amount'
                            ) ,
                            'recursive' => -1
                        ));
                        $this->set($aliasName . $key, $TransTotAmount['0']['total_amount']);
                    } else {
                        $this->set($aliasName . $key, $this->{$model}->find('count', array(
                            'conditions' => $conditions,
                            'recursive' => -1
                        )));
                    }
                }
            }
        }
        //recently registered users
        $recentUsers = $this->User->find('all', array(
            'conditions' => array(
                'User.is_active' => 1,
                'User.user_type_id != ' => ConstUserTypes::Admin
            ) ,
            'fields' => array(
                'User.user_type_id',
                'User.username',
                'User.id',
            ) ,
            'recursive' => -1,
            'limit' => 10,
            'order' => array(
                'User.id' => 'desc'
            )
        ));
        //recently logged in users
        $loggedUsers = $this->User->find('all', array(
            'conditions' => array(
                'User.is_active' => 1,
                'User.user_type_id != ' => ConstUserTypes::Admin
            ) ,
            'fields' => array(
                'User.user_type_id',
                'User.username',
                'User.id',
            ) ,
            'recursive' => -1,
            'limit' => 10,
            'order' => array(
                'User.last_logged_in_time' => 'desc'
            )
        ));
        //online users
        $onlineUsers = $this->User->find('all', array(
            'conditions' => array(
                'User.is_active' => 1,
                'CkSession.user_id != ' => 0,
                'User.user_type_id != ' => ConstUserTypes::Admin
            ) ,
            'contain' => array(
                'CkSession' => array(
                    'fields' => array(
                        'CkSession.user_id'
                    )
                )
            ) ,
            'fields' => array(
                'DISTINCT User.username',
                'User.user_type_id',
                'User.id',
            ) ,
            'recursive' => 0,
            'limit' => 10,
            'order' => array(
                'User.last_logged_in_time' => 'desc'
            )
        ));
        // Cache file read
        $error_log_path = APP . '/tmp/logs/error.log';
        $error_log = $debug_log = '';
        if (file_exists($error_log_path)) {
            $handle = fopen($error_log_path, "r");
            fseek($handle, -10240, SEEK_END);
            $error_log = fread($handle, 10240);
            fclose($handle);
        }
        $debug_log_path = APP . '/tmp/logs/debug.log';
        if (file_exists($debug_log_path)) {
            $handle = fopen($debug_log_path, "r");
            fseek($handle, -10240, SEEK_END);
            $debug_log = fread($handle, 10240);
            fclose($handle);
        }
        $this->set('error_log', $error_log);
        $this->set('debug_log', $debug_log);
        $this->set('tmpCacheFileSize', bytes_to_higher(dskspace(TMP . 'cache')));
        $this->set('tmpLogsFileSize', bytes_to_higher(dskspace(TMP . 'logs')));
        $this->set(compact('loggedUsers', 'recentUsers', 'onlineUsers', 'periods', 'models'));
    }
    function admin_change_password($user_id = null)
    {
        $this->setAction('change_password', $user_id);
    }
    function admin_login()
    {
        $this->setAction('login');
    }
    function admin_logout()
    {
        $this->setAction('logout');
    }
    function resend_activemail($username = NUll, $status = NULL)
    {
        if (!empty($username) && !empty($status)) {
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.username' => $username,
                )
            ));
            $this->_sendActivationMail($user['User']['email'], $user['User']['id'], $this->User->getActivateHash($user['User']['id']));
        }
        $this->set('username', $username);
    }
    function company_register()
    {
        $this->setAction('register', 'company');
    }
    function add_to_wallet()
    {
        $payment_options = $this->User->getGatewayTypes('is_enable_for_add_to_wallet');
        if (empty($payment_options[ConstPaymentGateways::Wallet])) {
            $this->cakeError('error404');
        }
        $this->pageTitle = __l('Add amount to wallet');
        if (!$this->User->isAllowed($this->Auth->user('user_type_id'))) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            //for conflict credit card and user city
            unset($this->User->validate['city']);
            if ($this->data['User']['payment_gateway_id'] == ConstPaymentGateways::CreditCard ) {
                $this->User->validate = array_merge($this->User->validate, $this->User->validateCreditCard);
            }
			else if (($this->data['User']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet && isset($this->data['User']['payment_profile_id']) && empty($this->data['User']['payment_profile_id']))) {				
				$this->User->validate = array_merge($this->User->validate, $this->User->validateCreditCard);
				if($this->data['User']['is_show_new_card'] == 0){
					$payment_gateway_id_validate = array(
						'payment_profile_id' => array(
							'rule1' => array(
								'rule' => 'notempty',
								'message' => __l('Required')
							)
						)
					);
					$this->User->validate = array_merge($this->User->validate, $payment_gateway_id_validate);				
				}
            }
			else if ($this->data['User']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet && (!isset($this->data['User']['payment_profile_id']))) {
                $this->User->validate = array_merge($this->User->validate, $this->User->validateCreditCard);
            }
            $this->User->set($this->data);
            $this->User->_checkAmount($this->data['User']['amount']);
            if ($this->User->validates()) {
                if ($this->data['User']['payment_gateway_id'] == ConstPaymentGateways::CreditCard) {
                    $this->_addWalletFromCreditCard($this->data);
                } elseif ($this->data['User']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
                    if (!empty($this->data['User']['creditCardNumber'])) {
                        $user = $this->User->find('first', array(
                            'conditions' => array(
                                'User.id' => $this->Auth->user('id')
                            ) ,
                            'fields' => array(
                                'User.id',
                                'User.cim_profile_id'
                            )
                        ));
                        //create payment profile
                        $data = $this->data['User'];
                        $data['expirationDate'] = $this->data['User']['expDateYear']['year'] . '-' . $this->data['User']['expDateMonth']['month'];
                        $data['customerProfileId'] = $user['User']['cim_profile_id'];
                        $payment_profile_id = $this->User->_createCimPaymentProfile($data);
                        if (is_array($payment_profile_id) && !empty($payment_profile_id['payment_profile_id']) && !empty($payment_profile_id['masked_cc'])) {
                            $payment['UserPaymentProfile']['user_id'] = $this->Auth->user('id');
                            $payment['UserPaymentProfile']['cim_payment_profile_id'] = $payment_profile_id['payment_profile_id'];
                            $payment['UserPaymentProfile']['masked_cc'] = $payment_profile_id['masked_cc'];
                            $payment['UserPaymentProfile']['is_default'] = 0;
                            $this->User->UserPaymentProfile->save($payment);
                            $this->data['User']['payment_profile_id'] = $payment_profile_id['payment_profile_id'];
                        } else {
                            $this->Session->setFlash(sprintf(__l('Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.') , $payment_profile_id['message']) , 'default', null, 'error');
                        }
                    }
                    if (!empty($this->data['User']['payment_profile_id'])) {
                        $this->_addWalletFromAuthorizeNet($this->data);
                    }
                } else {
					if ($this->data['User']['payment_gateway_id'] == ConstPaymentGateways::PagSeguro) {
                        $payment_gateway_id = ConstPaymentGateways::PagSeguro;
                    } else {
                        $payment_gateway_id = ConstPaymentGateways::PayPalAuth;
                    }
                    
                    $paymentGateway = $this->User->Transaction->PaymentGateway->find('first', array(
                        'conditions' => array(
                            'PaymentGateway.id' => $payment_gateway_id,
                        ) ,
                        'contain' => array(
                            'PaymentGatewaySetting' => array(
                                'fields' => array(
                                    'PaymentGatewaySetting.key',
                                    'PaymentGatewaySetting.test_mode_value',
                                    'PaymentGatewaySetting.live_mode_value',
                                ) ,
                            ) ,
                        ) ,
                        'recursive' => 1
                    ));
                    $this->pageTitle.= ' - ' . $paymentGateway['PaymentGateway']['name'];
                    $this->set('gateway_name', $paymentGateway['PaymentGateway']['name']);
                    if (empty($paymentGateway)) {
                        $this->cakeError('error404');
                    }
                    $action = strtolower(str_replace(' ', '', $paymentGateway['PaymentGateway']['name']));
                    if ($paymentGateway['PaymentGateway']['name'] == 'PayPal') {
                        Configure::write('paypal.is_testmode', $paymentGateway['PaymentGateway']['is_test_mode']);
                        if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                            foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                                if ($paymentGatewaySetting['key'] == 'payee_account') {
                                    Configure::write('paypal.account', $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value']);
                                }
                                if ($paymentGatewaySetting['key'] == 'receiver_emails') {
                                    $this->Paypal->paypal_receiver_emails = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                                }
                            }
                        }
                        $cmd = '_xclick';
                        $gateway_options = array(
                            'cmd' => $cmd,
                            'notify_url' => Router::url('/', true).'users/processpayment/paypal',
                            'cancel_return' => Router::url('/', true).'users/payment_cancel/'.$payment_gateway_id,
                            'return' => Router::url('/', true).'users/payment_success/'.$payment_gateway_id,
                            'item_name' => __l('Add amount to wallet') ,
                            'currency_code' => Configure::read('paypal.currency_code') ,
                            'amount' => $this->data['User']['amount'],
                            'user_defined' => array(
                                'user_id' => $this->Auth->user('id') ,
                                'ip' => $this->RequestHandler->getClientIP()
                            )
                        );
                        $this->set('gateway_options', $gateway_options);
                    }else if ($paymentGateway['PaymentGateway']['name'] == 'PagSeguro') {
                        Configure::write('PagSeguro.is_testmode', $paymentGateway['PaymentGateway']['is_test_mode']);
                        if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                            foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                                if ($paymentGatewaySetting['key'] == 'payee_account') {
                                   $email= $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                                }
                            }
                        }
                        //gateway options set
                        $ref = time();
                        $gateway_options['init'] = array(
							'pagseguro' => array( // Array com informações pertinentes ao pagseguro
									'email' =>$email,
									'type' => 'CBR', // Obrigatório passagem para pagseguro:tipo
									'reference' => $ref, // Obrigatório passagem para pagseguro:ref_transacao
									'freight_type' => 'EN', // Obrigatório passagem para pagseguro:tipo_frete
									'theme' => 1, // Opcional Este parametro aceita valores de 1 a 5, seu efeito é a troca dos botões padrões do pagseguro
									'currency' => 'BRL',// Obrigatório passagem para pagseguro:moeda,
									'extra' => 0 // Um valor extra que você queira adicionar no valor total da venda, obs este valor pode ser negativo
								),
								'definitions' => array( // Array com informações para manusei das informações
									'currency_type' => 'dolar', // Especifica qual o tipo de separador de decimais, suportados (dolar, real)
									'weight_type' => 'kg', // Especifica qual a medida utilizada para peso, suportados (kg, g)
									'encode' => 'utf-8' // Especifica o encode não implementado
								),
								'format' => array(
									'item_id' => $this->Auth->user('id'),
									'item_descr' => __l('wallet'),
									'item_quant' => '1',
									'item_valor' => $this->data['User']['amount'],
									'item_frete' => '0',
									'item_peso' => '20'
								),
                                'customer_info'
                          
                        );

						$transaction_data['TempPaymentLog'] = array(
                                'trans_id'=>$ref,
                                'payment_type'=>'wallet',
                                'user_id' => $this->Auth->user('id') ,
                                'ip' => $this->RequestHandler->getClientIP() ,
                                'amount_needed' => $this->data['User']['amount'],
								'payment_gateway_id' => $this->data['User']['payment_gateway_id'],
                                'currency_code' => Configure::read('paypal.currency_code') ,
						);
                	$this->TempPaymentLog->save($transaction_data);
						//$this->Session->write('transaction_data',$transaction_data);

						$this->set('gateway_options', $gateway_options);
                    }
                    $this->set('action', $action);
                    $this->set('amount', $this->data['User']['amount']);
                    $this->render('do_payment');
                }
            } else {
                $this->Session->setFlash(__l('Your amount can not be added. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->User->validate = array_merge($this->User->validate, $this->User->validateCreditCard);
			$this->data['User']['is_show_new_card'] = 0;
        }
		
        $payment_options = $this->User->getGatewayTypes('is_enable_for_add_to_wallet');
        unset($payment_options[ConstPaymentGateways::Wallet]);
		if(empty($this->data['User']['payment_gateway_id'])){
			if (!empty($payment_options[ConstPaymentGateways::AuthorizeNet])) {
				$this->data['User']['payment_gateway_id'] = ConstPaymentGateways::AuthorizeNet;
			} elseif (!empty($payment_options[ConstPaymentGateways::CreditCard])) {
				$this->data['User']['payment_gateway_id'] = ConstPaymentGateways::CreditCard;
			} elseif (!empty($payment_options[ConstPaymentGateways::PayPalAuth])) {
				$this->data['User']['payment_gateway_id'] = ConstPaymentGateways::PayPalAuth;
			}
		}	
        $gateway_options = array();
        $gateway_options['paymentGateways'] = $payment_options;
        $gateway_options['countries'] = $this->User->UserProfile->Country->find('list', array(
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
        $gateway_options['cities'] = $this->User->UserProfile->City->find('list', array(
            'conditions' => array(
                'City.is_approved =' => 1
            ) ,
            'fields' => array(
                'City.name',
                'City.name'
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
        $gateway_options['states'] = $this->User->UserProfile->State->find('list', array(
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
        $gateway_options['creditCardTypes'] = array(
            'Visa' => __l('Visa') ,
            'MasterCard' => __l('MasterCard') ,
            'Discover' => __l('Discover') ,
            'Amex' => __l('Amex')
        );
        $Paymentprofiles = $this->User->UserPaymentProfile->find('all', array(
            'fields' => array(
                'UserPaymentProfile.masked_cc',
                'UserPaymentProfile.cim_payment_profile_id',
                'UserPaymentProfile.is_default'
            ) ,
            'conditions' => array(
                'UserPaymentProfile.user_id' => $this->Auth->user('id')
            ) ,
        ));
        foreach($Paymentprofiles as $pay_profile) {
            $gateway_options['Paymentprofiles'][$pay_profile['UserPaymentProfile']['cim_payment_profile_id']] = $pay_profile['UserPaymentProfile']['masked_cc'];
            if ($pay_profile['UserPaymentProfile']['is_default']) {
                $this->data['User']['payment_profile_id'] = $pay_profile['UserPaymentProfile']['cim_payment_profile_id'];
            }
        }
		if(empty($gateway_options['Paymentprofiles']))
		{
			$this->data['User']['is_show_new_card'] = 1;
		}
		 $states = $this->User->UserProfile->State->find('list', array(
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
        $this->set('gateway_options', $gateway_options);
        $this->data['User']['cvv2Number'] = $this->data['User']['creditCardNumber'] = '';
    }
    function _addWalletFromAuthorizeNet($data)
    {
        if (!empty($this->data)) {
            $cim = $this->User->_getCimObject();
            if (!empty($cim)) {
                $user = $this->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $this->Auth->user('id')
                    ) ,
                    'fields' => array(
                        'User.id',
                        'User.cim_profile_id'
                    )
                ));
                $cim->setParameter('amount', $data['User']['amount']);
                $cim->setParameter('refId', time());
                $cim->setParameter('customerProfileId', $user['User']['cim_profile_id']);
                $cim->setParameter('customerPaymentProfileId', $data['User']['payment_profile_id']);
                $title = Configure::read('site.name') . ' - added to wallet';
                $description = 'Amount added to wallet in ' . Configure::read('site.name');
                // CIM accept only 30 character in title
                if (strlen($title) > 30) {
                    $title = substr($title, 0, 27) . '...';
                }
                $cim->setLineItem($this->Auth->user('id') , $title, $description, 1, $data['User']['amount']);
                $cim->createCustomerProfileTransaction();
                $response = $cim->getDirectResponse();
                $approval_code = $cim->getAuthCode();
                if (!empty($approval_code) && !empty($response)) {
                    $response_array = explode(',', $response);
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_response_text'] = $cim->getResponseText();
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_authorization_code'] = $cim->getAuthCode();
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_avscode'] = $cim->getAVSResponse();
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['transactionid'] = $cim->getTransactionID();
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_amt'] = $response_array[9];
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_gateway_feeamt'] = $response[32];
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_cvv2match'] = $cim->getCVVResponse();
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_response'] = $response;
                    $this->User->DealUser->AuthorizenetDocaptureLog->save($data_authorize_docapture_log);
                    if ($response_array[0] == 1) {
                        $capture = 1;
                    }
                }
                if (!empty($capture)) {
                    $data['Transaction']['user_id'] = $this->Auth->user('id');
                    $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                    $data['Transaction']['class'] = 'SecondUser';
                    $data['Transaction']['amount'] = $this->data['User']['amount'];
                    $data['Transaction']['payment_gateway_id'] = ConstPaymentGateways::AuthorizeNet;
                    $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
                    $this->User->Transaction->save($data);
                    $this->User->updateAll(array(
                        'User.available_balance_amount' => 'User.available_balance_amount +' . $this->data['User']['amount'],
                    ) , array(
                        'User.id' => $this->Auth->user('id')
                    ));
                    $this->Session->setFlash(__l('Amount added in wallet successfully.') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'my_stuff',
                        '#My_Transactions'
                    ));
                } else {
                    $this->Session->setFlash(__l('Transaction failure. Please try once again. ') . $response['L_LONGMESSAGE0'], 'default', null, 'error');
                    $this->redirect(array(
                        'controller' => 'deals',
                        'action' => 'index'
                    ));
                }
            }
        }
    }
    function processpayment($gateway_name)
    {
         $gateway = array(
					'paypal' => ConstPaymentGateways::PayPalAuth,
					'pagseguro' => ConstPaymentGateways::PagSeguro
					);
        $gateway_id = (!empty($gateway[$gateway_name])) ? $gateway[$gateway_name] : 0;
		$transaction_data = $this->Session->read('transaction_data');
		if(empty($transaction_data) && $gateway_name == 'pagseguro' ){
				 $this->cakeError('error404');
		}else{
			 $this->Session->del('transaction_data');
		}
        $paymentGateway = $this->User->Transaction->PaymentGateway->find('first', array(
            'conditions' => array(
                'PaymentGateway.id' => $gateway_id
            ) ,
            'contain' => array(
                'PaymentGatewaySetting' => array(
                    'fields' => array(
                        'PaymentGatewaySetting.key',
                        'PaymentGatewaySetting.test_mode_value',
                        'PaymentGatewaySetting.live_mode_value',
                    ) ,
                ) ,
            ) ,
            'recursive' => 1
        ));
        switch ($gateway_name) {
            case 'paypal':
                $this->Paypal->initialize($this);
                if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                    foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                        if ($paymentGatewaySetting['key'] == 'payee_account') {
                            $this->Paypal->payee_account = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                        }
                        if ($paymentGatewaySetting['key'] == 'receiver_emails') {
                            $this->Paypal->paypal_receiver_emails = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                        }
                    }
                }
                $this->Paypal->sanitizeServerVars($_POST);
                $this->Paypal->is_test_mode = $paymentGateway['PaymentGateway']['is_test_mode'];
                $this->Paypal->amount_for_item = !empty($this->Paypal->paypal_post_arr['amount']) ? $this->Paypal->paypal_post_arr['amount'] : 0;
                //paypal quick fix
                $paid_amount = $this->Paypal->paypal_post_arr['mc_gross'];
                $min_wallet_amount = Configure::read('wallet.min_wallet_amount');
                $max_wallet_amount = Configure::read('wallet.max_wallet_amount');
                $allow_to_process = 0;
                if (!empty($max_wallet_amount) && !empty($min_wallet_amount)) {
                    if ($paid_amount >= $min_wallet_amount && $paid_amount <= $max_wallet_amount) {
                        $allow_to_process = 1;
                    }
                } elseif (!empty($min_wallet_amount)) {
                    if ($paid_amount >= $min_wallet_amount) {
                        $allow_to_process = 1;
                    }
                } elseif (!empty($max_wallet_amount)) {
                    if ($paid_amount <= $max_wallet_amount) {
                        $allow_to_process = 1;
                    }
                } elseif (empty($min_wallet_amount) && empty($max_wallet_amount)) {
                    $allow_to_process = 1;
                }
                if (!empty($allow_to_process)) {
                    if ($this->Paypal->process()) {
                        if ($this->Paypal->paypal_post_arr['payment_status'] == 'Completed') {
                            $id = $this->Paypal->paypal_post_arr['user_id'];
                            $data['Transaction']['user_id'] = $id;
                            $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                            $data['Transaction']['class'] = 'SecondUser';
                            $data['Transaction']['amount'] = $this->Paypal->paypal_post_arr['mc_gross'];
                            $data['Transaction']['payment_gateway_id'] = $paymentGateway['PaymentGateway']['id'];
                            $data['Transaction']['gateway_fees'] = $this->Paypal->paypal_post_arr['mc_fee'];
                            $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
                            $transaction_id = $this->User->Transaction->log($data);
                            if (!empty($transaction_id)) {
                                $this->Paypal->paypal_post_arr['transaction_id'] = $transaction_id;
                                $this->User->updateAll(array(
                                    'User.available_balance_amount' => 'User.available_balance_amount +' . $this->Paypal->paypal_post_arr['mc_gross'],
                                ) , array(
                                    'User.id' => $id
                                ));
                            }
                        } else {
                            $this->pageTitle = __l('Payment Failure');
                            $this->Session->setFlash(__l('Error in payment') , 'default', null, 'error');
                            $this->redirect(array(
                                'controller' => 'transactions',
                                'action' => 'index',
                            ));
                        }
                    } else {
                        //place to handle the failure of process
                        $this->pageTitle = __l('Payment Failure');
                        $this->Session->setFlash(__l('Error in payment') , 'default', null, 'error');
                        $this->redirect(array(
                            'controller' => 'transactions',
                            'action' => 'index'
                        ));
                    }
                }
                $this->Paypal->logPaypalTransactions();
                break;
				case 'pagseguro':
                     $temp= $this->TempPaymentLog->find('first',array(
                     'conditions'=>array(
                      'TempPaymentLog.trans_id'=>$this->params['named']['order']
                     )
                    ));
                     $transaction_data = $temp['TempPaymentLog'];
                     $verificado = $this->PagSeguro->confirm();
                        if($verificado == 'VERIFICADO'){
                            $allow_to_process = 1;
                            $get_result = $this->PagSeguro->getDataPayment();
                        }elseif($verificado == 'FALSO'){
                            $allow_to_process = 0;
                        }
					 if (!empty($transaction_data)&& $allow_to_process) {
							$id = $transaction_data['user_id'];
							$paid_amount=$transaction_data['amount_needed'];
							//add amount to wallet for normal paypal
							$data['Transaction']['user_id'] = $id;
							$data['Transaction']['foreign_id'] = ConstUserIds::Admin;
							$data['Transaction']['class'] = 'SecondUser';
							$data['Transaction']['amount'] = $paid_amount;
							$data['Transaction']['payment_gateway_id'] = $paymentGateway['PaymentGateway']['id'];
							$data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
							$transaction_id = $this->User->Transaction->log($data);
							if (!empty($transaction_id)) {
								$transaction_id= $transaction_id;
								$this->User->updateAll(array(
									'User.available_balance_amount' => 'User.available_balance_amount +' . $paid_amount,
								) , array(
									'User.id' => $id
								));
							$this->redirect(array(
								'controller' => 'transactions',
								'action' => 'index',
							));
                        $this->TempPaymentLog->del($transaction_data['id']);
							}
						}else {
							//place to handle the failure of process
							$this->pageTitle = __l('Payment Failure');
							$this->Session->setFlash(__l('Error in payment') , 'default', null, 'error');
							$this->redirect(array(
								'controller' => 'transactions',
								'action' => 'index'
							));
						}
					
				break;
            default:
                $this->cakeError('error404');
        } // switch
        $this->autoRender = false;
    }
    function payment_success()
    {
        $this->pageTitle = __l('Payment Success');
        $this->Session->setFlash(__l('Your payment has been successfully transferred.') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'my_stuff',
            '#My_Transactions'
        ));
    }
    function payment_cancel()
    {
        $this->pageTitle = __l('Payment Cancel');
        $this->Session->setFlash(__l('Transaction failure. Please try once again.') , 'default', null, 'error');
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'my_stuff',
            '#My_Transactions'
        ));
    }
    function _addWalletFromCreditCard($data)
    {
        $paymentGateway = $this->User->Transaction->PaymentGateway->find('first', array(
            'conditions' => array(
                'PaymentGateway.id' => ConstPaymentGateways::CreditCard,
            ) ,
            'contain' => array(
                'PaymentGatewaySetting' => array(
                    'fields' => array(
                        'PaymentGatewaySetting.key',
                        'PaymentGatewaySetting.test_mode_value',
                        'PaymentGatewaySetting.live_mode_value',
                    ) ,
                ) ,
            ) ,
            'recursive' => 1
        ));
        if (!empty($paymentGateway['PaymentGatewaySetting'])) {
            foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                if ($paymentGatewaySetting['key'] == 'directpay_API_UserName') {
                    $sender_info['API_UserName'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                }
                if ($paymentGatewaySetting['key'] == 'directpay_API_Password') {
                    $sender_info['API_Password'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                }
                if ($paymentGatewaySetting['key'] == 'directpay_API_Signature') {
                    $sender_info['API_Signature'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                }
            }
        }
        $sender_info['is_testmode'] = $paymentGateway['PaymentGateway']['is_test_mode'];
        $data_credit_card['firstName'] = $data['User']['firstName'];
        $data_credit_card['lastName'] = $data['User']['lastName'];
        $data_credit_card['creditCardType'] = $data['User']['creditCardType'];
        $data_credit_card['creditCardNumber'] = $data['User']['creditCardNumber'];
        $data_credit_card['expDateMonth'] = $data['User']['expDateMonth'];
        $data_credit_card['expDateYear'] = $data['User']['expDateYear'];
        $data_credit_card['cvv2Number'] = $data['User']['cvv2Number'];
        $data_credit_card['address'] = $data['User']['address'];
        $data_credit_card['city'] = $data['User']['city'];
        $data_credit_card['state'] = $data['User']['state'];
        $data_credit_card['zip'] = $data['User']['zip'];
        $data_credit_card['country'] = $data['User']['country'];
        $data_credit_card['paymentType'] = 'Sale';
        $data_credit_card['amount'] = $this->data['User']['amount'];
        //calling doDirectPayment fn in paypal component
        $payment_response = $this->Paypal->doDirectPayment($data_credit_card, $sender_info);
        //if not success show error msg as it received from paypal
        if (!empty($payment_response) && $payment_response['ACK'] != 'Success') {
            $this->Session->setFlash(sprintf(__l('%s') , $payment_response['L_LONGMESSAGE0']) , 'default', null, 'error');
            return;
        }
        $data['Transaction']['user_id'] = $this->Auth->user('id');
        $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
        $data['Transaction']['class'] = 'SecondUser';
        $data['Transaction']['amount'] = $payment_response['AMT'];
        $data['Transaction']['payment_gateway_id'] = $paymentGateway['PaymentGateway']['id'];
        $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
        $transaction_id = $this->User->Transaction->log($data);
        if (!empty($transaction_id)) {
            $this->Paypal->paypal_post_arr['transaction_id'] = $transaction_id;
            $this->User->updateAll(array(
                'User.available_balance_amount' => 'User.available_balance_amount +' . $payment_response['AMT'],
            ) , array(
                'User.id' => $this->Auth->user('id')
            ));
        }
        $data_paypal_docapture_log['PaypalDocaptureLog']['authorizationid'] = $payment_response['TRANSACTIONID'];
        $data_paypal_docapture_log['PaypalDocaptureLog']['wallet_user_id'] = $this->Auth->user('id');
        $data_paypal_docapture_log['PaypalDocaptureLog']['dodirectpayment_correlationid'] = $payment_response['CORRELATIONID'];
        $data_paypal_docapture_log['PaypalDocaptureLog']['dodirectpayment_ack'] = $payment_response['ACK'];
        $data_paypal_docapture_log['PaypalDocaptureLog']['dodirectpayment_build'] = $payment_response['BUILD'];
        $data_paypal_docapture_log['PaypalDocaptureLog']['dodirectpayment_amt'] = $payment_response['AMT'];
        $data_paypal_docapture_log['PaypalDocaptureLog']['dodirectpayment_avscode'] = $payment_response['AVSCODE'];
        $data_paypal_docapture_log['PaypalDocaptureLog']['dodirectpayment_cvv2match'] = $payment_response['CVV2MATCH'];
        $data_paypal_docapture_log['PaypalDocaptureLog']['dodirectpayment_response'] = serialize($payment_response);
        $data_paypal_docapture_log['PaypalDocaptureLog']['version'] = $payment_response['VERSION'];
        $data_paypal_docapture_log['PaypalDocaptureLog']['currencycode'] = $payment_response['CURRENCYCODE'];
        //save do capture log records
        $this->User->DealUser->PaypalDocaptureLog->save($data_paypal_docapture_log);
        $this->Session->setFlash(__l('Your payment has been successfully transferred.') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'my_stuff',
            '#My_Transactions'
        ));
    }
    function my_stuff()
    {
        if (!$this->User->isAllowed($this->Auth->user('user_type_id'))) {
            $this->cakeError('error404');
        }
        $this->pageTitle = __l('My Stuff');
    }
    function referred_users()
    {
        if (!empty($this->params['named']['user_id'])) {
            $conditions = array(
                'User.Referred_by_user_id' => $this->params['named']['user_id'],
            );
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'UserAvatar' => array(
                    'fields' => array(
                        'UserAvatar.id',
                        'UserAvatar.filename',
                        'UserAvatar.dir'
                    )
                ) ,
                'DealUser' => array(
                    'fields' => array(
                        'DealUser.id'
                    ) ,
                )
            ) ,
        );
        $users = $this->paginate();
        foreach($users as $user) $userlist[] = $user['User']['id'];
        $referred_users_deal_counts = $this->User->DealUser->find('all', array(
            'conditions' => array(
                'DealUser.user_id' => $userlist
            ) ,
            'fields' => array(
                'Count(DealUser.user_id) as deal_count',
                'DealUser.user_id'
            ) ,
            'group' => array(
                'DealUser.user_id'
            ) ,
            'recursive' => -1
        ));
        foreach($referred_users_deal_counts as $referred_users_deal_count) $new_count[$referred_users_deal_count['DealUser']['user_id']] = $referred_users_deal_count['0']['deal_count'];
        foreach($users as &$user) $user['User']['deal_count'] = ($new_count[$user['User']['id']]) ? $new_count[$user['User']['id']] : 0;
        $this->User->recursive = 2;
        $this->set('referredFriends', $users);
    }
    function whois($ip = null)
    {
        if (!empty($ip)) {
            $this->redirect(Configure::read('site.look_up_url') . $ip);
        }
    }
    function my_api($user_id = null)
    {
        if (is_null($user_id)) {
            $this->cakeError('error404');
        }
        $this->pageTitle = __l('My API');
        $api_key = $this->Auth->user('api_key');
        $api_token = $this->Auth->user('api_token');
        if (empty($api_key) && empty($api_token)) {
            $api_key = $this->_uuid();
            $api_token = substr(md5($this->Auth->user('username') . Configure::read('Security.salt')) , 0, 15);
            $this->User->updateAll(array(
                'User.api_key' => '\'' . $api_key . '\'',
                'User.api_token' => '\'' . $api_token . '\''
            ) , array(
                'User.id' => $user_id
            ));
        }
        $this->set('api_key', $api_key);
        $this->set('api_token', $api_token);
    }
    function admin_clear_logs()
    {
        if (!empty($this->params['named']['type'])) {
            if ($this->params['named']['type'] == 'error_log') {
                unlink(APP . '/tmp/logs/error.log');
                $this->Session->setFlash(__l('Error log has been cleared') , 'default', null, 'success');
            } elseif ($this->params['named']['type'] == 'debug_log') {
                unlink(APP . '/tmp/logs/debug.log');
                $this->Session->setFlash(__l('Debug log has been cleared') , 'default', null, 'success');
            }
        }
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'admin_stats'
        ));
    }
    function admin_clear_cache()
    {
        App::import('Folder');
        $folder = &new Folder();
        $folder->delete(CACHE . DS . 'models');
        $folder->delete(CACHE . DS . 'persistent');
        $folder->delete(CACHE . DS . 'views');
        $this->Session->setFlash(__l('Cache Files has been cleared') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'admin_stats'
        ));
    }
    function admin_add_fund($id = null)
    {
        $this->pageTitle = __l('Add Fund');
        if (!empty($this->data['Transaction']['user_id'])) {
            $id = $this->data['Transaction']['user_id'];
        }
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $id
            ) ,
            'recursive' => -1
        ));
        if (empty($user)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $user['User']['username'];
        if (!empty($this->data)) {
            $this->data['Transaction']['foreign_id'] = ConstUserIds::Admin;
            $this->data['Transaction']['class'] = 'SecondUser';
            $this->data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddFundToWallet;
            if ($this->User->Transaction->save($this->data['Transaction'])) {
                $this->User->updateAll(array(
                    'User.available_balance_amount' => 'User.available_balance_amount +' . $this->data['Transaction']['amount'],
                ) , array(
                    'User.id' => $this->data['Transaction']['user_id']
                ));
                $this->Session->setFlash(__l('Fund has been added successfully') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Fund could not be added. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->data['Transaction']['user_id'] = $id;
        }
        $this->set('user', $user);
    }
    function admin_deduct_fund($id = null)
    {
        $this->pageTitle = __l('Deduct Fund');
        if (!empty($this->data['Transaction']['user_id'])) {
            $id = $this->data['Transaction']['user_id'];
        }
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $id
            ) ,
            'recursive' => -1
        ));
        if (empty($user)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $user['User']['username'];
        if (!empty($this->data)) {
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->data['Transaction']['user_id']
                )
            ));
            if ($user['User']['available_balance_amount'] < $this->data['Transaction']['amount']) {
                $this->Session->setFlash(__l('Deduct amount should be less than the available balance amount') , 'default', null, 'error');
            } else {
                $this->data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                $this->data['Transaction']['class'] = 'SecondUser';
                $this->data['Transaction']['transaction_type_id'] = ConstTransactionTypes::DeductFundFromWallet;
                if ($this->User->Transaction->save($this->data['Transaction'])) {
                    $this->User->updateAll(array(
                        'User.available_balance_amount' => 'User.available_balance_amount -' . $this->data['Transaction']['amount'],
                    ) , array(
                        'User.id' => $this->data['Transaction']['user_id']
                    ));
                    $this->Session->setFlash(__l('Fund has been deducted successfully') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'index'
                    ));
                } else {
                    $this->Session->setFlash(__l('Fund could not be deducted. Please, try again.') , 'default', null, 'error');
                }
            }
        } else {
            $this->data['Transaction']['user_id'] = $id;
        }
        $this->set('user', $user);
    }
    // <-- For iPhone App code
    function validate_user()
    {                
		if ($this->Auth->login($this->data)) {
			$resonse = array(
				'status' => 0,
				'message' => __l('Success')
			);
		} else {
			$resonse = array(
				'status' => 1,
				'message' => sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login'))
			);
		}        
        if ($this->RequestHandler->prefers('json')) {
            $this->view = 'Json';
            $this->set('json', (empty($this->viewVars['iphone_response'])) ? $resonse: $this->viewVars['iphone_response']);
        }
    }
    // For iPhone App code -->

}
?>