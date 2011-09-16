<?php
/* SVN FILE: $Id: app_controller.php 44740 2011-02-19 08:13:56Z aravindan_111act10 $ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7805 $
 * @modifiedby    $LastChangedBy: AD7six $
 * @lastmodified  $Date: 2008-10-30 23:00:26 +0530 (Thu, 30 Oct 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for class.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller
{
    var $components = array(
        'RequestHandler',
        'Security',
        'Auth',
        'XAjax',
        'DebugKit.Toolbar',
        'Cookie',
        'Pdf'
    );
    var $helpers = array(
        'Html',
        'Javascript',
        'AutoLoadPageSpecific',
        'Form',
        'Asset',
        'Auth',
        'Time',
        'RestXml',
        'RestJson',
    );
    var $cookieTerm = '+4 weeks';
    //    var $view = 'Theme';
    //    var $theme = 'default';
    function beforeRender()
    {
        $this->set('meta_for_layout', Configure::read('meta'));
        $this->set('js_vars_for_layout', (isset($this->js_vars)) ? $this->js_vars : '');
		if (Configure::read('site.is_api_enabled')) {
            if (!empty($this->params['url']['api_key']) && !empty($this->params['url']['api_token'])) {
                if (!empty($this->viewVars['api_response'])) {
                    $this->set('response', $this->viewVars['api_response']);
                } else {
                    $this->set('response', array(
                        'status' => 404,
                        'message' => __l('Unknown Error') ,
                        'deals' => array()
                    ));
                }
            }
        }
        parent::beforeRender();
    }
    function __construct()
    {
        parent::__construct();
        include_once (APP . DS . 'vendors' . DS . 'mobileDeviceDetect.php');
        // <-- For iPhone App code
		if(empty($_GET['key'])){ 
			_mobile_device_detect();
		}
		// For iPhone App code -->
        App::import('Model', 'Setting');
        $setting_model_obj = new Setting();
        $settings = $setting_model_obj->getKeyValuePairs();
        Configure::write($settings);
        // languages are set in globals
        $current_city_slug = Configure::read('site.city');
        if (!empty($_GET['url'])) {
            $city_slug = explode('/', $_GET['url']);
            $current_city_slug = (!empty($city_slug[0])) ? $city_slug[0] : Configure::read('site.city');
        }
        $lang_code = Configure::read('site.language');
        if (!empty($_COOKIE['CakeCookie']['user_language'])) {
            $lang_code = $_COOKIE['CakeCookie']['user_language'];
        } else if (!empty($current_city_slug)) {
            $cookie_city_slug = !empty($_COOKIE['CakeCookie']['city_slug']) ? $_COOKIE['CakeCookie']['city_slug'] : '';
            if (empty($cookie_city_slug) || ($current_city_slug != $cookie_city_slug)) {
                App::import('Model', 'City');
                $city_model_obj = new City();
                $city = $city_model_obj->find('first', array(
                    'conditions' => array(
                        'City.slug' => $current_city_slug,
                        'City.is_approved' => 1
                    ) ,
                    'contain' => array(
                        'Language' => array(
                            'fields' => array(
                                'Language.iso2'
                            )
                        )
                    ) ,
                    'fields' => array(
                        'City.language_id'
                    ) ,
                    'recursive' => 1
                ));
                if (!empty($city['Language']['iso2'])) {
                    setcookie('CakeCookie[city_language]', $city['Language']['iso2']);
                    $lang_code = $city['Language']['iso2'];
                } else {
                    setcookie('CakeCookie[city_language]', $lang_code);
                }
            } elseif (!empty($_COOKIE['CakeCookie']['city_language'])) {
                $lang_code = $_COOKIE['CakeCookie']['city_language'];
            }
        }
        Configure::write('lang_code', $lang_code);
        App::import('Model', 'Translation');
        $translation_model_obj = new Translation();
        Cache::set(array(
            'duration' => '+100 days'
        ));
        $translations = Cache::read($lang_code . '_translations');
        if (empty($translations) and $translations === false) {
            $translations = $translation_model_obj->find('all', array(
                'conditions' => array(
                    'Language.iso2' => $lang_code
                ) ,
                'fields' => array(
                    'Translation.key',
                    'Translation.lang_text'
                ) ,
                'contain' => array(
                    'Language' => array(
                        'fields' => array(
                            'Language.iso2'
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            Cache::set(array(
                'duration' => '+100 days'
            ));
            Cache::write($lang_code . '_translations', $translations);
        }
        if (!empty($translations)) {
            foreach($translations as $translation) {
                $GLOBALS['_langs'][$translation['Language']['iso2']][$translation['Translation']['key']] = $translation['Translation']['lang_text'];
            }
        }
        $js_trans_array = array(
            'Are you sure you want to ',
            'Please select atleast one record!',
            'Are you sure you want to do this action?',
            'Please enter valid original price.',
            'Discount percentage should be less than 100.',
            'Discount amount should be less than original price.',
            'Are you sure do you want to change the status? Once the status is changed you cannot undo the status.',
            'By clicking this button you are confirming your purchase. Once you confirmed amount will be deducted from your wallet and you can not undo this process. Are you sure you want to confirm this purchase?',
            'Since you don\'t have sufficent amount in wallet, your purchase process will be proceeded to PayPal. Are you sure you want to confirm this purchase?',
            'Google map could not find your location, please enter known location to google',
            'Invalid extension, Only csv, txt are allowed',
        );
        foreach($js_trans_array as $trans) {
            if (!empty($GLOBALS['_langs'][$lang_code][$trans])) {
                $this->js_vars['cfg']['lang'][$trans] = $GLOBALS['_langs'][$lang_code][$trans];
            }
        }
    }
    function beforeFilter()
    {
        // Coding done to disallow demo user to change the admin settings
		if ($this->params['action'] != 'flashupload') {
			$cur_page = $this->params['controller'] . '/' . $this->params['action'];
			$admin_demomode_updation_not_allowed_array = Configure::read('site.admin_demomode_updation_not_allowed_array');
			if ($this->Auth->user('user_type_id') && $this->Auth->user('user_type_id') == ConstUserTypes::Admin && !Configure::read('site.is_admin_settings_enabled') && (!empty($this->data) || $this->params['action'] == 'admin_delete' || $this->params['action'] == 'admin_update') && in_array($cur_page, $admin_demomode_updation_not_allowed_array)) {
				$this->Session->setFlash(__l('Sorry. You cannot update or delete in demo mode') , 'default', array('lib' => __l('Error')), 'error');
				$this->redirect(array(
					'controller' => $this->params['controller'],
					'action' => 'index',
				));
			}
		}
        // End of Code
        if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'geocity') {
            App::import('Model', 'City');
            $cityObj = new City();
            $city = $cityObj->find('first', array(
                'conditions' => array(
                    'City.name' => $_COOKIE['city_name'],
                    'City.is_approved' => 1
                ) ,
                'contain' => array(
                    'Language' => array(
                        'fields' => array(
                            'Language.iso2'
                        )
                    )
                ) ,
                'fields' => array(
                    'City.language_id',
                    'City.slug'
                ) ,
                'recursive' => 1
            ));
            if (!empty($city)) {
                $this->params['named']['city'] = $city['City']['slug'];
                if (!empty($city['Language']['iso2'])) {
                    Configure::write('lang_code', $city['Language']['iso2']);
                }
            } else {
                $this->params['named']['city'] = Configure::read('site.city');
                //$this->redirect(Router::url('/', true));

            }
        }
        $timezone_code = Configure::read('site.timezone_offset');
        if (!empty($timezone_code)) {
            date_default_timezone_set($timezone_code);
        }
        if (Configure::read('site.is_ssl_for_deal_buy_enabled')) {
            $secure_array = array(
                'deals/buy',
                'users/add_to_wallet',
                'gift_users/add',
                'users/login',
                'users/admin_login',
                'users/register',
                'users/company_register'
            );
            $cur_page = $this->params['controller'] . '/' . $this->params['action'];
            if (in_array($cur_page, $secure_array) && $this->params['action'] != 'flashupload') {
                $this->Security->blackHoleCallback = 'forceSSL';
                $this->Security->requireSecure($this->params['action']);
            } else if (env('HTTPS') && !$this->RequestHandler->isAjax()) {
                $this->_unforceSSL();
            }
        }
        if ($this->params['controller'] != 'images' && $this->params['action'] != 'flashupload') {
            $_SESSION['city_attachment'] = '';
            App::import('Model', 'City');
            $cityObj = new City();
            $city = $cityObj->find('first', array(
                'conditions' => array(
                    'City.slug' => !empty($this->params['named']['city']) ? $this->params['named']['city'] : Configure::read('site.city') ,
                    'City.is_approved' => 1
                ) ,
                'contain' => array(
                    'Attachment'
                ) ,
                'recursive' => 0
            ));
            if (!empty($this->params['named']['city']) and empty($city)) {
                $this->Session->setFlash(__l('City you have reqested is not available in') . ' ' . Configure::read('site.name') . '. ' . __l('Please select a valid city from Visit More Cities') , 'default', array('lib' => __l('Error')), 'error');
                if (empty($this->params['requested'])) {
                    $this->cakeError('error404');
                }
            }
            $this->set('city_id', $city['City']['id']);
            $this->set('city_name', $city['City']['name']);
            $this->set('city_slug', $city['City']['slug']);
            $this->set('city_attachment', $city['Attachment']);
            // user avail balance
            if ($this->Auth->user('id')) {
                App::import('Model', 'User');
                $user_model_obj = new User();
                $this->set('user_available_balance', $user_model_obj->checkUserBalance($this->Auth->user('id')));
            }
        }
		if(isset($this->data['Subscription']['city_id'])){
			$city_info = $cityObj->find('first', array(
                'conditions' => array(
                    'City.id' => $this->data['Subscription']['city_id'] ,
                    'City.is_approved' => 1
                ) ,
                'recursive' => -1
            ));
			setcookie('CakeCookie[city_slug]',$city_info['City']['slug']);
		}else if (!empty($this->params['named']['city']) && empty($this->params['isAjax']) && empty($this->params['requested'])) {
			setcookie('CakeCookie[city_slug]', $this->params['named']['city']);
            setcookie('CakeCookie[city_slug]', $this->params['named']['city'],time()+60*60*24*30,'/');
        }
        if (!empty($this->params['named']['city'])) {
            setcookie('CakeCookie[city_slug]', $this->params['named']['city']);
        }
        // Writing site name in cache, required for getting sitename retrieving in routes
        Cache::write('site.name', strtolower(Inflector::slug(Configure::read('site.name'))) , array(
            'config' => 'long'
        ));
        if (!(Cache::read('site_url_for_shell', 'long'))) {
            Cache::write('site_url_for_shell', Router::url('/', true) , array(
                'config' => 'long'
            ));
        }
        // Writing city routing url in cache
        if (($city_url = Cache::read('site.city_url', 'long')) === false) {
            Cache::write('site.city_url', Configure::read('site.city_url') , array(
                'config' => 'long'
            ));
        }
        // Writing default city name in cache
        $default_city = Cache::read('site.default_city', 'long');
        if (($default_city = Cache::read('site.default_city', 'long')) === false) {
            Cache::write('site.default_city', Configure::read('site.city') , array(
                'config' => 'long'
            ));
            $this->redirect(Router::url('/', true));
        }
        // check ip is banned or not. redirect it to 403 if ip is banned
        $this->loadModel('BannedIp');
        $bannedIp = $this->BannedIp->checkIsIpBanned($this->RequestHandler->getClientIP());
        if (empty($bannedIp)) {
            $bannedIp = $this->BannedIp->checkRefererBlocked(env('HTTP_REFERER'));
        }
        if (!empty($bannedIp)) {
            if (!empty($bannedIp['BannedIp']['redirect'])) {
                header('location: ' . $bannedIp['BannedIp']['redirect']);
            } else {
                $this->cakeError('error403');
            }
        }
        $cur_page = $this->params['controller'] . '/' . $this->params['action'];
        // check site is under maintenance mode or not. admin can set in settings page and then we will display maintenance message, but admin side will work.
        if (empty($this->params['requested']) and $cur_page != 'images/view' and $cur_page != 'devs/robots' and Configure::read('site.maintenance_mode') && (($this->Auth->user('user_type_id') && $this->Auth->user('user_type_id') != ConstUserTypes::Admin) or (empty($this->params['prefix']) or ($this->params['prefix'] != 'admin' and $cur_page != 'users/admin_login')))) {
            $this->cakeError('error500');
        }
        //Fix to upload the file through the flash multiple uploader
        if ((isset($_SERVER['HTTP_USER_AGENT']) and ((strtolower($_SERVER['HTTP_USER_AGENT']) == 'shockwave flash') or (strpos(strtolower($_SERVER['HTTP_USER_AGENT']) , 'adobe flash player') !== false))) and isset($this->params['pass'][0]) and ($this->action == 'flashupload')) {
            session_id($this->params['pass'][0]);
            session_start();
        }
        if ($this->Auth->user('fb_user_id') || (!$this->Auth->user() && Configure::read('facebook.is_enabled_facebook_connect')) || ($this->params['controller'] == 'cities' && ($this->params['action'] == 'admin_index' || $this->params['action'] == 'fb_update')) || $this->params['controller'] == 'settings') {
            App::import('Vendor', 'facebook/facebook');
            // Prevent the 'Undefined index: facebook_config' notice from being thrown.
            $GLOBALS['facebook_config']['debug'] = NULL;
            // Create a Facebook client API object.
            $this->facebook = new Facebook(array(
                'appId' => Configure::read('facebook.fb_api_key') ,
                'secret' => Configure::read('facebook.fb_secrect_key') ,
                'cookie' => true
            ));
            $this->set('facebookObj', $this->facebook);
            if ($this->Auth->user('id')) {
                $this->set('fb_logout_url', $this->facebook->getLogoutUrl(array(
                    'next' => (Router::url(array(
                        'controller' => $this->params['named']['city'],
                        'action' => 'users',
                        'logout',
                        'admin' => false
                    ) , true))
                )));
            } else {
                if (!empty($this->params['named']['city'])) {
                    $this->set('fb_login_url', $this->facebook->getLoginUrl(array(
                        'cancel_url' => Router::url(array(
                            'controller' => $this->params['named']['city'],
                            'action' => 'users',
                            'register',
                            'admin' => false
                        ) , true) ,
                        'next' => Router::url(array(
                            'controller' => $this->params['named']['city'],
                            'action' => 'users',
                            'register',
                            'admin' => false
                        ) , true) ,
                        'req_perms' => 'email,publish_stream'
                    )));
                } else {
                    $this->set('fb_login_url', $this->facebook->getLoginUrl(array(
                        'cancel_url' => Router::url(array(
                            'controller' => 'users',
                            'action' => 'register',
                            'admin' => false
                        ) , true) ,
                        'next' => Router::url(array(
                            'controller' => 'users',
                            'action' => 'register',
                            'admin' => false
                        ) , true) ,
                        'req_perms' => 'email,publish_stream'
                    )));
                }
            }
        }
        if (strpos($this->here, '/view/') !== false) {
            trigger_error('*** dev1framework: Do not view page through /view/; use singular/slug', E_USER_ERROR);
        }
        // check the method is exist or not in the controller
        $methods = array_flip($this->methods);
        if (!isset($methods[strtolower($this->params['action']) ])) {
            return $this->cakeError('missingAction', array(
                array(
                    'className' => Inflector::camelize($this->params['controller'] . "Controller") ,
                    'action' => $this->params['action'],
                    'webroot' => $this->webroot,
                    'url' => $this->here,
                    'base' => $this->base
                )
            ));
        }
        if (Configure::read('site.is_api_enabled')) {
            // check rest action or not
            $this->_handleRest();
        }
		// <-- For iPhone App code
        if (!empty($_GET['key'])) {
            $this->_handleIPhoneApp();
        }
        // For iPhone App code -->
        $this->_checkAuth();        
        $this->js_vars['cfg']['icm'] = $GLOBALS['_city']['icm'];
        $this->js_vars['cfg']['path_relative'] = Router::url('/');
        $this->js_vars['cfg']['path_absolute'] = Router::url('/', true);
        $this->js_vars['cfg']['date_format'] = 'M d, Y';
        $this->js_vars['cfg']['today_date'] = date('Y-m-d');
        $this->js_vars['cfg']['site_name'] = strtolower(Inflector::slug(Configure::read('site.name')));
        parent::beforeFilter();
    }
    function _checkAuth()
    {
        $this->Auth->fields = array(
            'username' => Configure::read('user.using_to_login') ,
            'password' => 'password'
        );
        $exception_array = array(
            'cities/check_city',
            'pages/view',
            'pages/display',
            'pages/home',
            'deals/index',
            'deals/view',
            'users/processpayment',
            'gift_users/processpayment',
            'subscriptions/add',
            'cities/index',
            'companies/view',
            'contacts/show_captcha',
            'users/register',
            'users/company_register',
            'users/login',
            'users/logout',
            'users/reset',
            'users/forgot_password',
            'users/openid',
            'users/activation',
            'users/resend_activation',
            'users/view',
            'users/show_captcha',
            'users/captcha_play',
            'images/view',
            'devs/robots',
            'contacts/add',
            'contacts/show_captcha',
            'contacts/captcha_play',
            'images/view',
            'cities/autocomplete',
            'states/autocomplete',
            'users/admin_login',
            'users/admin_logout',
            'languages/change_language',
            'subscriptions/add',
            'subscriptions/index',
            'subscriptions/unsubscribe',
            'users/referred_users',
            'users/resend_activemail',
            'subscriptions/home',
            'subscriptions/unsubscribe_mailchimp',
            'subscriptions/city_suggestions',
            'subscriptions/skip',
            'pages/refer_a_friends',
            'users/refer',
            'user_cash_withdrawals/process_masspay_ipn',
            'deals/barcode',
            'city_suggestions/add',
            'cities/twitter_facebook',
            'topics/index',
            'topic_discussions/index',
            'user_comments/index',
            'deals/buy',
            'deals/process_user',
            'deals/processpayment',
            'deals/_buyDeal',
            'deals/payment_success',
            'deals/payment_cancel',
            'companies/view',
            'page/learn',
            'deals/company_deals',
            'gift_users/view_gift_card',
            'devs/sitemap',
            'devs/robotos',
            'business_suggestions/add',
            'crons/update_deal',
            'users/validate_user',
        );
        $cur_page = $this->params['controller'] . '/' . $this->params['action'];
        if (!in_array($cur_page, $exception_array) && $this->params['action'] != 'flashupload') {
            if (!$this->Auth->user('id')) {
                // check cookie is present and it will auto login to account when session expires
                $cookie_hash = $this->Cookie->read('User.cookie_hash');
                if (!empty($cookie_hash)) {
                    if (is_integer($this->cookieTerm) || is_numeric($this->cookieTerm)) {
                        $expires = time() +intval($this->cookieTerm);
                    } else {
                        $expires = strtotime($this->cookieTerm, time());
                    }
                    App::import('Model', 'User');
                    $user_model_obj = new User();
                    $this->data = $user_model_obj->find('first', array(
                        'conditions' => array(
                            'User.cookie_hash =' => md5($cookie_hash) ,
                            'User.cookie_time_modified <= ' => date('Y-m-d h:i:s', $expires) ,
                        ) ,
                        'fields' => array(
                            'User.' . Configure::read('user.using_to_login') ,
                            'User.password'
                        ) ,
                        'recursive' => -1
                    ));
                    // auto login if cookie is present
                    if ($this->Auth->login($this->data)) {
                        $user_model_obj->UserLogin->insertUserLogin($this->Auth->user('id'));
                        $this->redirect(Router::url('/', true) . $this->params['url']['url']);
                    }
                }
                $this->Session->setFlash(__l('Authorization Required'));
                $is_admin = false;
                if (isset($this->params['prefix']) and $this->params['prefix'] == 'admin') {
                    $is_admin = true;
                }
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login',
                    'admin' => $is_admin,
                    '?f=' . $this->params['url']['url']
                ));
            }
            if (isset($this->params['prefix']) and $this->params['prefix'] == 'admin' and $this->Auth->user('user_type_id') != ConstUserTypes::Admin) {
                $this->redirect(Router::url('/', true));
            }
        } else {
            $this->Auth->allow('*');
        }
        $this->Auth->autoRedirect = false;
        $this->Auth->userScope = array(
            'User.is_active' => 1,
            'User.is_email_confirmed' => 1
        );
        if (isset($this->Auth)) {
            $this->Auth->loginError = __l(sprintf('Sorry, login failed.  Either your %s or password are incorrect or admin deactivated your account.', Configure::read('user.using_to_login')));
        }
        $this->layout = 'default';
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin && (isset($this->params['prefix']) and $this->params['prefix'] == 'admin')) {
            $this->layout = 'admin';
        }
        if (!empty($this->params['url']['api_key']) && !empty($this->params['url']['api_token'])) {
            $this->layout = false;
            $this->viewPath = 'api';
        }
        // if the site is accessed with m.domain; e.g., m.videomyne.com
        if (Configure::read('site.is_mobile_app') and stripos(getenv('HTTP_HOST') , 'm.') === 0) {
            // different layout and view for mobile application
            $this->layoutPath = 'mobile';
            //If mobile views folder and necessary .ctp file exist then using that, otherwise using the normal view folder ctp
            if (file_exists(VIEWS . $this->viewPath . DS . 'mobile' . DS . $this->params['action'] . $this->ext)) {
                $this->viewPath.= DS . 'mobile';
            }
        }
        // Layout Changes for API
        if (Configure::read('site.is_api_enabled')) {
            if (!empty($this->params['url']['api_key']) && !empty($this->params['url']['api_token'])) {
                $this->layout = false;
                $this->viewPath = 'api';
            }
        }
    }
    function autocomplete($param_encode = null, $param_hash = null)
    {
        $modelClass = Inflector::singularize($this->name);
        $conditions = false;
        if (isset($this->{$modelClass}->_schema['is_approved'])) {
            $conditions['is_approved = '] = '1';
        }
        $this->XAjax->autocomplete($param_encode, $param_hash, $conditions);
    }
    function show_captcha()
    {
        include_once VENDORS . DS . 'securimage' . DS . 'securimage.php';
        $img = new securimage();
        $img->show(); // alternate use:  $img->show('/path/to/background.jpg');
        $this->autoRender = false;
    }
    function captcha_play()
    {
        App::import('Vendor', 'securimage/securimage');
        $img = new Securimage();
        $this->disableCache();
        $this->RequestHandler->respondAs('mp3', array(
            'attachment' => 'captcha.mp3'
        ));
        $img->audio_format = 'mp3';
        echo $img->getAudibleCode('mp3');
    }
    function _uuid()
    {
        return sprintf('%07x%1x', mt_rand(0, 0xffff) , mt_rand(0, 0x000f));
    }
    function _unum()
    {
        $acceptedChars = '0123456789';
        $max = strlen($acceptedChars) -1;
        $unique_code = '';
        for ($i = 0; $i < 8; $i++) {
            $unique_code.= $acceptedChars{mt_rand(0, $max) };
        }
        return $unique_code;
    }
    function _redirectGET2Named($whitelist_param_names = null)
    {
        $query_strings = array();
        $ajax_query_strings = '';
        if (is_array($whitelist_param_names)) {
            foreach($whitelist_param_names as $param_name) {
                if (!empty($this->params['url'][$param_name])) { // querystring
                    if ($this->params['isAjax']) {
                        $ajax_query_strings.= $param_name . ':' . $this->params['url'][$param_name] . '/';
                    } else {
                        $query_strings[$param_name] = $this->params['url'][$param_name];
                    }
                }
            }
        } else {
            $query_strings = $this->params['url'];
            unset($query_strings['url']); // Can't use ?url=foo

        }
        if (!empty($query_strings) || !empty($ajax_query_strings)) {
            if ($this->params['isAjax']) {
                $this->redirect(array(
                    'controller' => $this->params['controller'],
                    'action' => $this->params['action'],
                    $ajax_query_strings
                ) , null, true);
            } else {
                $query_strings = array_merge($this->params['named'], $query_strings);
                $this->redirect($query_strings, null, true);
            }
        }
    }
    public function redirect($url, $status = null, $exit = true)
    {
        if (Cache::read('site.city_url', 'long') == 'prefix') {
            parent::redirect(router_url_city($url, $this->params['named']) , $status, $exit);
        }
        parent::redirect($url, $status, $exit);
    }
    public function flash($message, $url, $pause = 1)
    {
        if (Cache::read('site.city_url', 'long') == 'prefix') {
            parent::flash($message, router_url_city($url, $this->params['named']) , $pause);
        }
        parent::redirect($message, $url, $pause);
    }
    //Force a secure connection
    function forceSSL()
    {
        if (!env('HTTPS')) {
            $this->redirect('https://' . env('SERVER_NAME') . $this->here);
        }
    }
    function _unforceSSL()
    {
        if (empty($this->params['requested'])) $this->redirect('http://' . $_SERVER['SERVER_NAME'] . $this->here);
    }
    function _handleRest()
    {
        if (!empty($this->params['url']['api_key']) && !empty($this->params['url']['api_token'])) {
            $this->Security->enabled = false;
            $this->loadModel('User');
            $this->data = $this->User->find('first', array(
                'conditions' => array(
                    'User.api_key' => $this->params['url']['api_key'],
                    'User.api_token' => $this->params['url']['api_token'],
                ) ,
                'fields' => array(
                    'User.' . Configure::read('user.using_to_login') ,
                    'User.password'
                ) ,
                'recursive' => -1
            ));
            // auto login if api key and token is present
            if (!$this->Auth->login($this->data)) {
                $this->Session->setFlash(__l('Your API authorization request failed. Please try again'));
                $this->cakeError('error404');
            }
        }
    }
    // <-- For iPhone App code
    function _handleIPhoneApp()
    {
        
		$this->Security->enabled = false;
		if (!empty($this->params['form'])) {
            foreach($this->params['form'] as $controller => $values) {
                $this->data[Inflector::camelize(Inflector::singularize($controller)) ] = $values;
            }
        }
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') === false) {
            $this->set('iphone_response', array(
                'status' => 1,
                'message' => __l('Unknown Application')
            ));
        } elseif (Configure::read('site.iphone_app_key') != $_GET['key']) {
            $this->set('iphone_response', array(
                'status' => 2,
                'message' => __l('Invalid App key')
            ));
        }        
		elseif(!empty($_GET['username']) && $this->params['action'] != 'validate_user'){
			 $this->data['User']['username'] = $_GET['username'];
			 $this->data['User']['password'] = $this->Auth->password($_GET['passwd']);
			 if (!$this->Auth->login($this->data)) {
				$this->set('iphone_response', array(
                    'status' => 1,
                    'message' => sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login'))
                ));
			 }			 
		}
		if($this->params['action'] == 'buy'){
			$this->data['Deal']['user_id'] = $this->Auth->user('id');						
			$this->data['Deal']['payment_gateway_id'] = 4;
			$this->data['Deal']['is_gift']	= 0;       
		} elseif($this->params['controller'] == 'user_payment_profiles' && $this->params['action'] == 'add'){
			$this->data['UserPaymentProfile']['user_id'] = $this->Auth->user('id');	
		}
    }
    // For iPhone App code -->

}
?>