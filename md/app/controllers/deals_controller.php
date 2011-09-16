<?php
class DealsController extends AppController
{
    var $name = 'Deals';
    var $components = array(
        'Email',
        'Paypal',
        'RequestHandler',
        'PagSeguro',
    );
    var $helpers = array(
        'Csv',
        'Gateway',
        'PagSeguro',
    );
    var $uses = array(
        'Deal',
        'Attachment',
        'EmailTemplate',
        'DealCategory',
        'TempPaymentLog'
    );
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Attachment',
            'Deal.calculator_min_limit',
            'Deal.calculator_discounted_price',
            'Deal.calculator_bonus_amount',
            'Deal.calculator_commission_percentage',
            'Deal.calculator_bonus_amount',
            'Deal.calculator_commission_percentage',
            'Deal.start_date',
            'Deal.end_date',
            'Deal.coupon_expiry_date',
            'DealStatus.id',
            'DealStatus.name',
            'Deal.original_price',
            'Deal.savings',
            'Deal.is_save_draft',
            'Deal.id',
            'Deal.save_as_draft',
            'Deal.send_to_admin',
            'Deal.gift_email',
            'Deal.gift_from',
            'Deal.gift_to',
            'Deal.message',
            'Deal.quantity',
            'Deal.message',
            'Deal.deal_amount',
            'Deal.deal_id',
            'Deal.is_gift',
            'User.confirm_password',
            'User.email',
            'User.passwd',
            'User.username',
            'Deal.user_available_balance',
            'Deal.gift_to',
            'Deal.is_purchase_via_wallet',
            'Deal.is_show_new_card',
			'Deal.payment_gateway_id'
        );
        parent::beforeFilter();
    }
    function index($city_slug = null)
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        if (!empty($this->data['Deal']['q'])) {
            $this->params['named']['q'] = $this->data['Deal']['q'];
        }
        if (!empty($this->data['Deal']['filter_id'])) {
            $this->params['named']['filter_id'] = $this->data['Deal']['filter_id'];
        }
        if (!empty($this->data['Deal']['company_slug'])) {
            $this->params['named']['company'] = $this->data['Deal']['company_slug'];
        }
        if (!empty($this->data['Deal']['type'])) {
            $this->params['named']['type'] = $this->data['Deal']['type'];
        }
		$city_conditions = array();
		// deal add sucess message
		if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'success') {
			$this->Session->setFlash(__l('Deal has been added.') , 'default', array('lib' => __l('Success')), 'success');
		}

        //home page deals
        if (empty($this->params['named']['company'])) {
            $city_slug = $this->params['named']['city'];
            $city = $this->Deal->City->find('first', array(
                'conditions' => array(
                    'City.slug' => $city_slug
                ) ,
                'fields' => array(
                    'City.name',
					 'City.id'
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
            if (empty($city)) {
                $this->cakeError('error404');
            }
			$city_deal_ids = array();
			foreach($city['Deal'] as $deal){
				$city_deal_ids[] = $deal['id'];
			}
			$conditions['Deal.id'] = $city_deal_ids;
            $city_conditions['Topic.city_id'] = $city['City']['id'];
        }
        //company users deals list ends
        $order = array(
            'Deal.id' => 'desc'
        );
        //recent and company deals list
        if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'recent') {
        	if(!empty($this->params['named'][ConstMissdealSpecialType::PARAM])){
        		$conditions['Deal.private_note like'] = "%".$this->params['named'][ConstMissdealSpecialType::PARAM]."%";
        	}
            $conditions['Deal.deal_status_id'] = array(
            	/** RZER : ADD STATUT OPEN **/
                ConstDealStatus::Open,
            	ConstDealStatus::Closed,
                ConstDealStatus::Expired,
                ConstDealStatus::Canceled,
                ConstDealStatus::PaidToCompany
            );
            $conditions['Deal.end_date <'] = _formatDate('Y-m-d H:i:s', date('Y-m-d H:i:s') , true);
            $this->pageTitle = __l('Recent Deals');
            if(!empty($this->params['named'][ConstMissdealSpecialType::PARAM])){
            	$this->pageTitle = __l('Voyages');
            }
            $order = array(
                'Deal.end_date' => 'DESC'
            );
        } elseif (empty($this->params['named']['company'])) {
            if (Configure::read('deal.is_side_deal_enabled')) {
                $conditions['Deal.is_side_deal'] = 0;
            }
            $conditions['Deal.deal_status_id'] = array(
                ConstDealStatus::Open,
                ConstDealStatus::Tipped,
            );
            $this->pageTitle = ' ' . __l('Deals of the Day'). ' ' . __l('onon') . ' ' . ucfirst($city['City']['name']);
            $order = array(
                'Deal.end_date' => 'desc'
            );
            $this->set('city_name', $city['City']['name']);
        }
        //for company
        if (!empty($this->params['named']['company'])) {
            $company = $this->Deal->Company->find('first', array(
                'conditions' => array(
                    'Company.slug = ' => $this->params['named']['company'],
                ) ,
                'fields' => array(
                    'Company.id',
                    'Company.name',
                    'Company.slug',
                    'Company.user_id',
                ) ,
                'recursive' => -1
            ));
            if ((!$this->Auth->user('id')) || ($company['Company']['user_id'] != $this->Auth->user('id'))) {
                $this->cakeError('error404');
            }
            $conditions['Deal.company_id'] = $company['Company']['id'];
            if (!empty($this->params['named']['filter_id'])) {
                $conditions['Deal.deal_status_id'] = $this->params['named']['filter_id'];
            }
            $headings = __l('My Deals');
            $this->pageTitle = __l('My Deals');
            $this->set('headings', $headings);
            $this->set('company_slug', $company['Company']['slug']);
        }
        if (isset($this->params['named']['q'])) {
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->params['named']['q']);
        }
        $not_conditions = array();
        if ($this->Auth->user('user_type_id') == ConstUserTypes::User) {
            $not_conditions['Not']['Deal.deal_status_id'] = array(
                ConstDealStatus::PendingApproval,
                ConstDealStatus::Upcoming
            );
        }
		if (!empty($this->params['url']['ext']) && ($this->params['url']['ext'] == 'rss')) {
			unset($conditions['Deal.is_side_deal']);
		}
        $this->paginate = array(
            'conditions' => array(
                $conditions,
                $not_conditions,
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.user_type_id',
                        'User.username',
                        'User.id',
                        'User.email',
                        'User.password',
                    )
                ) ,
                'Company' => array(
                    'fields' => array(
                        'Company.name',
                        'Company.slug',
                        'Company.id',
                        'Company.user_id',
                        'Company.url',
                        'Company.zip',
                        'Company.address1',
                        'Company.address2',
                        'Company.city_id',
                        'Company.latitude',
                        'Company.longitude',
                        'Company.is_company_profile_enabled',
                        'Company.is_online_account',
                        'Company.map_zoom_level'
                    ) ,
                    'CompanyAddress' => array(
                        'limit' => 5,
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
                    )
                ) ,
                'Attachment' => array(
                    'fields' => array(
                        'Attachment.id',
                        'Attachment.dir',
                        'Attachment.filename',
                        'Attachment.width',
                        'Attachment.height'
                    )
                ) ,
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                        'City.latitude',
                        'City.longitude',
                        'City.fb_access_token'
                    )
                ) ,
                'DealStatus' => array(
                    'fields' => array(
                        'DealStatus.name',
                    )
                ) ,
                'Topic' => array(
                    'TopicDiscussion' => array(
                        'limit' => 1,
                        'order' => array(
                            'TopicDiscussion.id' => 'desc'
                        )
                    ) ,
                    'LastRepliedUser' => array(
                        'fields' => array(
                            'LastRepliedUser.id',
                            'LastRepliedUser.user_type_id',
                            'LastRepliedUser.username',
                            'LastRepliedUser.id',
                        ) ,
                        'UserAvatar' => array(
                            'fields' => array(
                                'UserAvatar.id',
                                'UserAvatar.filename',
                                'UserAvatar.dir',
                                'UserAvatar.width',
                                'UserAvatar.height'
                            )
                        ) ,
                    ) ,
					'conditions' => $city_conditions,
                    'limit' => 1,
                    'fields' => array(
                        'Topic.topic_discussion_count',
                        'Topic.id',
                        'Topic.deal_id'
                    )
                ) ,
            ) ,
            'order' => $order,
            'recursive' => 3,
        );
        if (!empty($this->params['named']['q'])) {
            $this->paginate['search'] = $this->params['named']['q'];
        }
        $deals = $this->paginate();
        $this->set('deals', $deals);
        // Coding for API Call
        if (Configure::read('site.is_api_enabled') and !empty($this->params['url']['api_key']) and !empty($this->params['url']['api_token'])) {
            $response['status'] = (empty($deals)) ? 0 : 1001; // Not Deals found Eror Code
            $response['message'] = (empty($deals)) ? __l('No Deals available') : __l('Deals found');
            $response['deals'] = array();
            if (!empty($deals)) {
                foreach($deals as $deal) {
                    $image_options = array(
                        'dimension' => 'small_thumb',
                        'class' => '',
                        'alt' => $deal['Deal']['name'],
                        'title' => $deal['Deal']['name'],
                        'type' => 'jpg'
                    );
                    $small_image_url = $this->Deal->getImageUrl('Deal', $deal['Attachment'][0], $image_options);
                    $image_options = array(
                        'dimension' => 'normal_thumb',
                        'class' => '',
                        'alt' => $deal['Deal']['name'],
                        'title' => $deal['Deal']['name'],
                        'type' => 'jpg'
                    );
                    $medium_image_url = $this->Deal->getImageUrl('Deal', $deal['Attachment'][0], $image_options);
                    $image_options = array(
                        'dimension' => 'medium_big_thumb',
                        'class' => '',
                        'alt' => $deal['Deal']['name'],
                        'title' => $deal['Deal']['name'],
                        'type' => 'jpg'
                    );
                    $large_image_url = $this->Deal->getImageUrl('Deal', $deal['Attachment'][0], $image_options);
                    $deal_xml_content = array(
                        'id' => $deal['Deal']['id'],
                        'deal_url' => Router::url(array(
                            'controller' => 'deals',
                            'action' => 'view',
                            $deal['Deal']['slug']
                        ) , true) ,
                        'title' => $deal['Deal']['name'],
                        'small_image_url' => $small_image_url,
                        'medium_image_url' => $medium_image_url,
                        'large_image_url' => $large_image_url,
                        'division_id' => $deal['City']['id'],
                        'division_name' => $deal['City']['name'],
                        'division_lat' => $deal['City']['latitude'],
                        'division_lng' => $deal['City']['longitude'],
                        'vendor_id' => $deal['Company']['id'],
                        'vendor_name' => $deal['Company']['name'],
                        'vendor_website_url' => $deal['Company']['url'],
                        'status' => $deal['DealStatus']['name'],
                        'start_date' => strftime(Configure::read('site.datetime.format') , strtotime(_formatDate('Y-m-d H:i:s', strtotime($deal['Deal']['start_date'])))) ,
                        'end_date' => strftime(Configure::read('site.datetime.format') , strtotime(_formatDate('Y-m-d H:i:s', strtotime($deal['Deal']['end_date'])))) ,
                        'tipped' => ($deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped) ? __l('true') : __l('false') ,
                        'tipping_point' => $deal['Deal']['min_limit'],
                        'tipped_date' => ($deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped) ? strftime(Configure::read('site.datetime.format') , strtotime(_formatDate('Y-m-d H:i:s', strtotime($deal['Deal']['deal_tipped_time'])))) : __l('Not Yet Tipped') ,
                        'quantity_sold' => $deal['Deal']['deal_user_count'],
                        'price' => Configure::read('site.currency') . $deal['Deal']['discounted_price'],
                        'value' => Configure::read('site.currency') . $deal['Deal']['original_price'],
                        'discount_amount' => Configure::read('site.currency') . $deal['Deal']['savings'],
                        'discount_percent' => $deal['Deal']['discount_percentage'] . "%",
                        'conditions' => array(
                            'limited_quantity' => (!empty($deal['Deal']['max_limit'])) ? __l('true') : __l('false') ,
                            'initial_quantity' => $deal['Deal']['min_limit'],
                            'quantity_remaining' => (empty($deal['Deal']['max_limit'])) ? __l('No Limit') : ($deal['Deal']['max_limit']-$deal['Deal']['deal_user_count']) ,
                            'minimum_purchase' => $deal['Deal']['buy_min_quantity_per_user'],
                            'maximum_purchase' => $deal['Deal']['buy_max_quantity_per_user'],
                            'expiration_date' => strftime(Configure::read('site.datetime.format') , strtotime(_formatDate('Y-m-d H:i:s', strtotime($deal['Deal']['coupon_expiry_date'])))) ,
                            'details' => array(
                                'detail' => $deal['Deal']['coupon_condition']
                            )
                        )
                    );
                    $response['deals'][] = $deal_xml_content;
                }
            }
            $this->set('api_response', $response);
        } else {
            //for side deal in index page
            if (Configure::read('deal.is_side_deal_enabled')) {
                $conditions['Deal.is_side_deal'] = 1;
                $side_deals = $this->Deal->find('all', array(
                    'conditions' => array(
                        $conditions,
                        $not_conditions,
                    ) ,
                    'contain' => array(
                        'City',
                        'Attachment' => array(
                            'fields' => array(
                                'Attachment.id',
                                'Attachment.dir',
                                'Attachment.filename',
                                'Attachment.width',
                                'Attachment.height'
                            )
                        ) ,
                    ) ,
                    'recursive' => 1,
                    'limit' => 5,
                ));
               
                if (!$deals and $side_deals) {                	 
                    $this->paginate['conditions'] = array(
                        $conditions,
                        $not_conditions,
                    );
                    //$side_deals = array();
                    $deals = $this->paginate();
                    $this->set('deals', $deals);
                }
                $this->set('side_deals', $side_deals);
            }
            //for company user
            if (empty($deals) && $this->Auth->user('user_type_id') == ConstUserTypes::Company && !$this->Deal->User->isAllowed($this->Auth->user('user_type_id')) && empty($this->params['named']['company'])) {
                $company = $this->Deal->Company->find('first', array(
                    'conditions' => array(
                        'Company.user_id = ' => $this->Auth->user('id')
                    ) ,
                    'fields' => array(
                        'Company.slug',
                    ) ,
                    'recursive' => -1
                ));
                $this->Session->setFlash(__l('No deals available in this city.') , 'default', array('lib' => __l('Error')), 'error');
                $this->redirect(array(
                    'controller' => 'deals',
                    'action' => 'index',
                    'company' => $company['Company']['slug'],
                    'admin' => false
                ));
            }
            if (!empty($this->params['named']['city'])) {
                $get_current_city = $this->params['named']['city'];
            } else {
                $get_current_city = Configure::read('site.city');
            }
            $this->set('get_current_city', $get_current_city);
            //render view file depends on the page
            if (!empty($this->params['named']['company'])) {
                $dealStatuses = $this->Deal->DealStatus->find('list');
                $dealStatusesCount = array();
                foreach($dealStatuses as $id => $dealStatus) {
                    $dealStatusesCount[$id] = $this->Deal->find('count', array(
                        'conditions' => array(
                            'Deal.deal_status_id' => $id,
                            'Deal.company_id' => $company['Company']['id'],
                        ) ,
                        'recursive' => -1
                    ));
                }
                $this->set('dealStatusesCount', $dealStatusesCount);
                $this->set('dealStatuses', $dealStatuses);
                $this->render('index_company_deals');
            } else if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'recent') {
                $this->render('index_recent_deals');
            }
        }
        // Subscrition page
        if (Configure::read('site.enable_three_step_subscription') && (empty($deals) || (!$this->Auth->user('user_type_id') && !isset($_COOKIE['CakeCookie']['is_subscribed']))) && empty($this->layoutPath)) {
            if (!empty($_COOKIE['CakeCookie']['is_subscribed']) || $this->Auth->user('id')) { // Already Subscribed
				if(isset($this->params['named']['type']) && $this->params['named']['type'] == 'recent'){
					$this->Session->setFlash(__l('Its seems that the current select city does\'t have any recent deals. Please select another city') , 'default', array('lib' => __l('Success')), 'success');
				}
				else{
	                $this->Session->setFlash(__l('Its seems that the current select city does\'t have any open deals. Please select another city') , 'default', array('lib' => __l('Success')), 'success');
				}	
                $this->redirect(array(
                    'controller' => 'page',
                    'action' => 'view',
                    'learn'
                ));
            }
            $this->layout = 'subscriptions';
            $deal_categories = $this->DealCategory->find('list', array(
                'order' => array(
                    'DealCategory.name' => 'asc'
                )
            ));
            $selected = array_keys($deal_categories);
            $this->set('options', $deal_categories);
            $this->set('selected', $selected);
        }
        // <-- For iPhone App code
        if ($this->RequestHandler->prefers('json')) {
            $this->view = 'Json';
            $deals = $this->paginate();
            $total_deals = count($deals);
            for ($i = 0; $i < $total_deals; $i++) {               
                $this->Deal->saveiPhoneAppThumb($deals[$i]['Attachment']);
				$image_options = array(
                    'dimension' => 'iphone_big_thumb',
                    'class' => '',
                    'alt' => $deals[$i]['Deal']['name'],
                    'title' => $deals[$i]['Deal']['name'],
                    'type' => 'jpg'
                );				
                $iphone_big_thumb = $this->Deal->getImageUrl('Deal', $deals[$i]['Attachment'][0], $image_options);                
                $deals[$i]['Deal']['iphone_big_thumb'] = $iphone_big_thumb;
				$image_options = array(
                    'dimension' => 'iphone_small_thumb',
                    'class' => '',
                    'alt' => $deals[$i]['Deal']['name'],
                    'title' => $deals[$i]['Deal']['name'],
                    'type' => 'jpg'
                );				
                $iphone_small_thumb = $this->Deal->getImageUrl('Deal', $deals[$i]['Attachment'][0], $image_options);                
                $deals[$i]['Deal']['iphone_small_thumb'] = $iphone_small_thumb;
                $deals[$i]['Deal']['end_time'] = intval(strtotime($deals[$i]['Deal']['end_date'] . ' GMT') -time());
				$deals[$i]['Deal']['end_date'] = date('m/d/Y', strtotime($deals[$i]['Deal']['end_date']));
				$deals[$i]['Deal']['start_date'] = date('m/d/Y', strtotime($deals[$i]['Deal']['start_date']));
				$deals[$i]['Deal']['coupon_expiry_date'] = ($deals[$i]['Deal']['coupon_expiry_date'])? date('m/d/Y', strtotime($deals[$i]['Deal']['coupon_expiry_date'])) : $deals[$i]['Deal']['coupon_expiry_date']; 
				$deals[$i]['Deal']['coupon_start_date'] = date('m/d/Y', strtotime($deals[$i]['Deal']['coupon_start_date']));
            }
            $this->view = 'Json';
            $this->set('json', (empty($this->viewVars['iphone_response'])) ? $deals : $this->viewVars['iphone_response']);
        }
        // For iPhone App code -->
    }
    //comapny deals listing
    function company_deals()
    {
        $conditions = array();
        if (!empty($this->params['named']['company_id'])) {
            $statusList = array(
                ConstDealStatus::Open,
                ConstDealStatus::Expired,
                ConstDealStatus::Tipped,
                ConstDealStatus::Closed,
                ConstDealStatus::PaidToCompany
            );
            $companyUser = $this->Deal->Company->find('first', array(
                'conditions' => array(
                    'Company.id' => $this->params['named']['company_id'],
                    'Company.user_id' => $this->Auth->user('id')
                ) ,
                'fields' => array(
                    'Company.user_id'
                ) ,
                'recursive' => -1
            ));
            if (!empty($companyUser) || $this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                $statusList[] = ConstDealStatus::Draft;
                $statusList[] = ConstDealStatus::PendingApproval;
                $statusList[] = ConstDealStatus::Upcoming;
                $statusList[] = ConstDealStatus::Refunded;
                $statusList[] = ConstDealStatus::Canceled;
            }
            $conditions = array(
                'Deal.company_id' => $this->params['named']['company_id'],
                'Deal.deal_status_id' => $statusList
            );
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'City' => array(
                    'fields' => array(
                        'City.id'
                    )
                ) ,
                'DealUser' => array(
                    'fields' => array(
                        'DealUser.discount_amount'
                    )
                ) ,
                'Attachment' => array(
                    'fields' => array(
                        'Attachment.id',
                        'Attachment.dir',
                        'Attachment.filename',
                        'Attachment.width',
                        'Attachment.height'
                    )
                ) ,
                'City',
                'DealStatus' => array(
                    'fields' => array(
                        'DealStatus.name',
                    )
                )
            ) ,
            'recursive' => 1,
        );
        $this->set('company_deals', $this->paginate());
    }
    //export deal listing in csv file
    function coupons_export()
    {
        if (empty($this->params['named']['deal_id'])) {
            $this->cakeError('error404');
        }
        $dealusers = $this->Deal->DealUser->find('all', array(
            'conditions' => array(
                'DealUser.deal_id' => $this->params['named']['deal_id'],
                'DealUser.is_canceled' => 0
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.user_type_id',
                        'User.username',
                        'User.id',
                    )
                ) ,
                'Deal' => array(
                    'fields' => array(
                        'Deal.id',
                        'Deal.name',
                        'Deal.coupon_start_date',
                        'Deal.coupon_expiry_date'
                    )
                ) ,
                'DealUserCoupon'
            ) ,
            'fields' => array(
                'DealUser.id',
                'DealUser.discount_amount',
                'DealUser.quantity'
            ) ,
            'recursive' => 1
        ));
        Configure::write('debug', 0);
        if (!empty($dealusers)) {
            foreach($dealusers as $dealuser) {
                $coupon_array = array();
                $unique_coupon_array = array();
                foreach($dealuser['DealUserCoupon'] as $deal_user_coupon) {
                    $coupon_array[] = $deal_user_coupon['coupon_code'];
                    $unique_coupon_array[] = $deal_user_coupon['unique_coupon_code'];
                }
                $data[]['Deal'] = array(
                    __l('User name') => $dealuser['User']['username'],
                    __l('Quantity') => $dealuser['DealUser']['quantity'],
                    __l('Amount') => Configure::read('site.currency') . $dealuser['DealUser']['discount_amount'],
                    __l('Top Code') => !empty($coupon_array) ? implode(',', $coupon_array) : '',
                    __l('Bottom Code') => !empty($unique_coupon_array) ? implode(',', $unique_coupon_array) : '',
                    __l('Valid From') => strftime(Configure::read('site.datetime.format') , strtotime(_formatDate('Y-m-d H:i:s', strtotime($dealuser['Deal']['coupon_start_date'])))) ,
                    __l('Expires On') => !empty($dealuser['Deal']['coupon_expiry_date'])? strftime(Configure::read('site.datetime.format') , strtotime(_formatDate('Y-m-d H:i:s', strtotime($dealuser['Deal']['coupon_expiry_date'])))) : '-',
                );
                $deal_name = $dealuser['Deal']['name'];
            }
        }
        $this->set('data', $data);
        $this->set('deal_name', $deal_name);
    }
    //admin export deal listing in csv file
    function admin_export()
    {
        $this->setAction('coupons_export');
    }
    function view($slug = null, $count = null)
    {
        $this->pageTitle = __l('Deal');
        if (is_null($slug)) {
            $this->cakeError('error404');
        }
        $deal = $this->Deal->find('first', array(
            'conditions' => array(
                'Deal.slug = ' => $slug
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.user_type_id',
                        'User.username',
                        'User.id',
                        'User.email',
                        'User.password',
                    )
                ) ,
                'Company' => array(
                    'fields' => array(
                        'Company.name',
                        'Company.slug',
                        'Company.id',
                        'Company.user_id',
                        'Company.url',
                        'Company.zip',
                        'Company.address1',
                        'Company.address2',
                        'Company.city_id',
                        'Company.latitude',
                        'Company.longitude',
                        'Company.is_company_profile_enabled',
                        'Company.is_online_account',
                        'Company.map_zoom_level',
                    ) ,
                    'CompanyAddress' => array(
                        'limit' => 5,
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
                    )
                ) ,
                'Attachment' => array(
                    'fields' => array(
                        'Attachment.id',
                        'Attachment.dir',
                        'Attachment.filename',
                        'Attachment.width',
                        'Attachment.height'
                    )
                ) ,
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                    )
                ) ,
                'Topic' => array(
                    'TopicDiscussion' => array(
                        'limit' => 1,
                        'order' => array(
                            'TopicDiscussion.id' => 'desc'
                        )
                    ) ,
                    'LastRepliedUser' => array(
                        'fields' => array(
                            'LastRepliedUser.id',
                            'LastRepliedUser.username',
                            'LastRepliedUser.user_type_id',
                            'LastRepliedUser.fb_user_id',
                        ) ,
                        'UserAvatar' => array(
                            'fields' => array(
                                'UserAvatar.id',
                                'UserAvatar.filename',
                                'UserAvatar.dir',
                                'UserAvatar.width',
                                'UserAvatar.height'
                            )
                        ) ,
                    ) ,
                    'limit' => 1,
                    'fields' => array(
                        'Topic.topic_discussion_count',
                        'Topic.id',
                        'Topic.deal_id'
                    )
                ) ,
            ) ,
            'recursive' => 3,
        ));
        if (empty($deal)) {
            $this->cakeError('error404');
        }
        if (!empty($deal['Deal']['meta_keywords'])) {
            Configure::write('meta.keywords', $deal['Deal']['meta_keywords']);
        }
        if (!empty($deal['Deal']['meta_description'])) {
            Configure::write('meta.description', $deal['Deal']['meta_description']);
        }
        if (!empty($deal['Deal']['name'])) {
            Configure::write('meta.deal_name', $deal['Deal']['name']);
        }
        if (!empty($deal['Attachment'])) {
            $image_options = array(
                'dimension' => 'medium_thumb',
                'class' => '',
                'alt' => $deal['Deal']['name'],
                'title' => $deal['Deal']['name'],
                'type' => 'png'
            );
            $deal_image = $this->Deal->getImageUrl('Deal', $deal['Attachment'][0], $image_options);
            Configure::write('meta.deal_image', $deal_image);
        }
        // Check For Normal User
        if (($this->Auth->user('user_type_id') == ConstUserTypes::User or !$this->Auth->user('user_type_id')) && ($deal['Deal']['deal_status_id'] == ConstDealStatus::PendingApproval || $deal['Deal']['deal_status_id'] == ConstDealStatus::Upcoming || $deal['Deal']['deal_status_id'] == ConstDealStatus::Draft)) {
            $this->cakeError('error404');
        }
        // Check for Company User
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Company && ($deal['Deal']['deal_status_id'] == ConstDealStatus::PendingApproval || $deal['Deal']['deal_status_id'] == ConstDealStatus::Upcoming || $deal['Deal']['deal_status_id'] == ConstDealStatus::Draft)) {
            $companyUser = $this->Deal->Company->find('first', array(
                'conditions' => array(
                    'Company.user_id' => $this->Auth->user('id')
                ) ,
                'fields' => array(
                    'Company.id'
                ) ,
                'recursive' => -1
            ));
            if ($deal['Deal']['company_id'] != $companyUser['Company']['id']) $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $deal['Deal']['name'];
        if (!empty($this->params['named']['city'])) {
            $get_current_city = $this->params['named']['city'];
        } else {
            $get_current_city = Configure::read('site.city');
        }
        $this->set('get_current_city', $get_current_city);
        $this->set('count', $count);
        $this->set('deal', $deal);
        $this->set('from_page', 'deal_view');
    }
    function edit($id = null)
    {
        $this->pageTitle = __l('Edit Deal');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if (!empty($this->data['OldAttachment'])) {
                $attachmentIds = array();
                foreach($this->data['OldAttachment'] as $attachment_id => $is_checked) {
                    if (isset($is_checked['id']) && ($is_checked['id'] == 1)) {
                        $attachmentIds[] = $attachment_id;
                    }
                }
                $attachmentIds = array(
                    'Attachment' => $attachmentIds
                );
                if (!empty($attachmentIds)) {
                    $this->Deal->Attachment->del($attachmentIds);
                }
            }
            unset($this->data['OldAttachment']);
            unset($this->Deal->validate['start_date']['rule2']);
            //update button
            if (!empty($this->data['Deal']['send_to_admin'])) {
                $this->data['Deal']['deal_status_id'] = ConstDealStatus::PendingApproval;
            }
            //payment calculation
            $this->data['Deal']['savings'] = (!empty($this->data['Deal']['discount_percentage'])) ? ($this->data['Deal']['original_price']*($this->data['Deal']['discount_percentage']/100)) : $this->data['Deal']['discount_amount'];
            $this->data['Deal']['discounted_price'] = $this->data['Deal']['original_price']-$this->data['Deal']['savings'];           
			// Free deal validation unset process
            if ($this->data['Deal']['discounted_price'] == 0) {
                unset($this->Deal->validate['discounted_price']['rule2']);
                unset($this->Deal->validate['commission_percentage']['rule2']);
            } else {
                unset($this->Deal->validate['discounted_price']['rule3']);
                unset($this->Deal->validate['commission_percentage']['rule3']);
                unset($this->Deal->validate['bonus_amount']['rule2']);
            }			
			// An time deal validation unset process
			if ($this->data['Deal']['is_anytime_deal']) {
                unset($this->Deal->validate['end_date']);
                unset($this->Deal->validate['coupon_expiry_date']);	
				unset($this->Deal->validate['coupon_start_date']['rule2']);						
				unset($this->data['Deal']['coupon_expiry_date']);
				unset($this->data['Deal']['end_date']);
			}
            if ($this->Deal->validates()) {
                if ($this->Deal->save($this->data)) {
                    $deals = $this->Deal->find('first', array(
                        'conditions' => array(
                            'Deal.id' => $id
                        ) ,
                        'contain' => array(
                            'City' => array(
                                'fields' => array(
                                    'City.id',
                                    'City.name',
                                    'City.slug',
                                )
                            ) ,
                            'Attachment',
                            'Company',
                        ) ,
                        'recursive' => 2
                    ));
                    $slug = $deals['Deal']['slug'];
                    $city_name = $deals['City']['slug'];
                    $this->Deal->_updateDealBitlyURL($deals['Deal']['slug'], $city_name);
					 $this->Deal->_updateCityDealCount();
                    //attachement file changes
                    /* if (!empty($this->data['Attachment']['filename']['name'])) {
                    $this->data['Attachment']['filename']['type'] = get_mime($this->data['Attachment']['filename']['tmp_name']);
                    }
                    if (!empty($this->data['Attachment']['filename']['name']) || (!Configure::read('image.file.allowEmpty') && empty($this->data['Attachment']['id']))) {
                    $this->Deal->Attachment->set($this->data);
                    }
                    $this->Deal->set($this->data);
                    if (!empty($this->data['Attachment']['filename'])) {
                    $is_attachment_error = true;
                    if (!empty($this->data['Attachment']['filename']['name'])) {
                    $data['Attachment']['filename'] = $this->data['Attachment']['filename'];
                    $this->Attachment->Behaviors->attach('ImageUpload', Configure::read('image.file'));
                    $this->Attachment->set($data);
                    if ($this->Attachment->validates() && $is_attachment_error) {
                    $is_attachment_error = true;
                    } else {
                    $is_attachment_error = false;
                    }
                    }
                    }*/
                    $foreign_id = $this->data['Deal']['id'];
                    /* $attach = $this->Attachment->find('first', array(
                    'conditions' => array(
                    'Attachment.foreign_id = ' => $foreign_id
                    ) ,
                    'fields' => array(
                    'Attachment.id'
                    ) ,
                    'recursive' => -1,
                    ));
                    if (!empty($this->data['Attachment']['filename']['name'])) {
                    $this->data['Attachment']['filename'] = $this->data['Attachment']['filename'];
                    $this->data['Attachment']['class'] = $this->modelClass;
                    $this->data['Attachment']['description'] = 'Product Image';
                    $this->data['Attachment']['id'] = $attach['Attachment']['id'];
                    $this->data['Attachment']['foreign_id'] = $this->data['Deal']['id'];
                    $this->Attachment->Behaviors->attach('ImageUpload', Configure::read('product.file'));
                    $this->Attachment->set($this->data);
                    if ($this->Attachment->validates()) $this->Attachment->save($this->data['Attachment']);
                    }*/
                    $this->Deal->Attachment->create();
                    if (!isset($this->data['Attachment']) && $this->RequestHandler->isAjax()) { // Flash Upload
                        $this->data['Attachment']['foreign_id'] = $foreign_id;
                        $this->data['Attachment']['description'] = 'Deal';
                        $this->XAjax->flashuploadset($this->data);
                    } else { // Normal Upload
                        $is_form_valid = true;
                        $upload_photo_count = 0;
                        for ($i = 0; $i < count($this->data['Attachment']); $i++) {
                            if (!empty($this->data['Attachment'][$i]['filename']['tmp_name'])) {
                                $upload_photo_count++;
                                $image_info = getimagesize($this->data['Attachment'][$i]['filename']['tmp_name']);
                                $this->data['Attachment']['filename'] = $this->data['Attachment'][$i]['filename'];
                                $this->data['Attachment']['filename']['type'] = $image_info['mime'];
                                $this->data['Attachment'][$i]['filename']['type'] = $image_info['mime'];
                                $this->Deal->Attachment->Behaviors->attach('ImageUpload', Configure::read('photo.file'));
                                $this->Deal->Attachment->set($this->data);
                                if (!$this->Deal->validates() |!$this->Deal->Attachment->validates()) {
                                    $attachmentValidationError[$i] = $this->Deal->Attachment->validationErrors;
                                    $is_form_valid = false;
                                    $this->Session->setFlash(__l('Deal could not be added. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
                                }
                            }
                        }
                        if (!$upload_photo_count) {
                            $this->Deal->validates();
                            $this->Deal->Attachment->validationErrors[0]['filename'] = __l('Required');
                            $is_form_valid = false;
                        }
                        if (!empty($attachmentValidationError)) {
                            foreach($attachmentValidationError as $key => $error) {
                                $this->Deal->Attachment->validationErrors[$key]['filename'] = $error;
                            }
                        }
                        if ($is_form_valid) {
                            $this->data['foreign_id'] = $foreign_id;
                            $this->data['Attachment']['description'] = 'Deal';
                            $this->XAjax->normalupload($this->data, false);
                            $this->Session->setFlash(__l('Deal has been added.') , 'default', array('lib' => __l('Success')), 'success');
                        }
                    }
                    $this->Session->setFlash(__l('Deal has been updated') , 'default', array('lib' => __l('Success')), 'success');
                    $deal = $this->Deal->find('first', array(
                        'conditions' => array(
                            'Deal.id' => $this->data['Deal']['id']
                        ) ,
                        'contain' => array(
                            'City' => array(
                                'fields' => array(
                                    'City.id',
                                    'City.name',
                                    'City.slug',
                                )
                            ) ,
                            'Attachment',
                            'Company',
                        ) ,
                        'recursive' => 2
                    ));
                    $slug = $deal['Deal']['slug'];
                    $city_name = $deal['City']['name'];
                    $this->Session->setFlash(__l('Deal has been updated') , 'default', array('lib' => __l('Success')), 'success');
                    if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                        $this->redirect(array(
                            'controller' => 'deals',
                            'action' => 'index',
                        ));
                    } else {
                        $this->redirect(array(
                            'controller' => 'deals',
                            'action' => 'company',
                            $deal['Company']['slug']
                        ));
                    }
                }
            } else {
                $this->Session->setFlash(__l('Deal could not be updated. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
            $attachment = $this->Attachment->find('first', array(
                'conditions' => array(
                    'Attachment.foreign_id = ' => $this->data['Deal']['id']
                ) ,
                'recursive' => -1,
            ));
            $this->data['Attachment'] = $attachment['Attachment'];
        } else {
            $conditions = array();
            if ($this->Auth->user('id') != ConstUserTypes::Admin) {
                $companyUser = $this->Deal->Company->find('first', array(
                    'conditions' => array(
                        'Company.user_id' => $this->Auth->user('id')
                    ) ,
                    'fields' => array(
                        'Company.id',
                        'Company.slug'
                    ) ,
                    'recursive' => -1
                ));
                $conditions['Deal.company_id'] = $companyUser['Company']['id'];
                $this->set('company_slug', $companyUser['Company']['slug']);
            }
            $conditions['Deal.id'] = $id;
            $this->data = $this->Deal->find('first', array(
                'conditions' => array(
                    $conditions,
                ) ,
                'recursive' => 1
            ));
            if (!empty($this->data['Deal']['start_date'])) {
                $this->data['Deal']['start_date'] = _formatDate('Y-m-d H:i:s', strtotime($this->data['Deal']['start_date']));
            }
            if (!empty($this->data['Deal']['end_date'])) {
                $this->data['Deal']['end_date'] = _formatDate('Y-m-d H:i:s', strtotime($this->data['Deal']['end_date']));
            }
            if (!empty($this->data['Deal']['coupon_start_date'])) {
                $this->data['Deal']['coupon_start_date'] = _formatDate('Y-m-d H:i:s', strtotime($this->data['Deal']['coupon_start_date']));
            }
            if (!empty($this->data['Deal']['coupon_expiry_date'])) {
                $this->data['Deal']['coupon_expiry_date'] = _formatDate('Y-m-d H:i:s', strtotime($this->data['Deal']['coupon_expiry_date']));
            }
            if (empty($this->data) || ($this->data['Deal']['deal_status_id'] != ConstDealStatus::Draft)) {
                $this->cakeError('error404');
            }
            //set values for deal amount calculator
            $this->data['Deal']['calculator_discounted_price'] = $this->data['Deal']['discounted_price'];
            $this->data['Deal']['calculator_min_limit'] = $this->data['Deal']['min_limit'];
            $this->data['Deal']['calculator_commission_percentage'] = $this->data['Deal']['commission_percentage'];
            $this->data['Deal']['calculator_bonus_amount'] = $this->data['Deal']['bonus_amount'];
        }
        //set values for deal amount calculator
        if (!empty($this->data['Deal']['calculator_discounted_price']) && !empty($this->data['Deal']['calculator_min_limit']) && !empty($this->data['Deal']['calculator_commission_percentage']) && !empty($this->data['Deal']['calculator_bonus_amount'])) {
            $this->data['Deal']['calculator_total_purchased_amount'] = $this->data['Deal']['calculator_discounted_price']*$this->data['Deal']['calculator_min_limit'];
            $this->data['Deal']['calculator_total_commission_amount'] = ($this->data['Deal']['calculator_total_purchased_amount']*($this->data['Deal']['calculator_commission_percentage']/100)) +$this->data['Deal']['calculator_bonus_amount'];
            $this->data['Deal']['calculator_net_profit'] = $this->data['Deal']['calculator_total_commission_amount'];
        }
        $this->pageTitle.= ' - ' . $this->data['Deal']['name'];
        $discounts = array();
        for ($i = 1; $i <= 100; $i++) {
            $discounts[$i] = $i;
        }
        $cities = $this->Deal->City->find('list', array(
            'conditions' => array(
                'City.is_approved =' => 1
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
        $companies = $this->Deal->Company->find('list');
        $dealStatuses = $this->Deal->DealStatus->find('list');
        $this->set(compact('cities', 'dealStatuses', 'companies', 'discounts'));
    }
    function add()
    {
        $this->pageTitle = __l('Add Deal');
        $this->Deal->Behaviors->attach('ImageUpload', Configure::read('image.file'));
        if (!empty($this->data)) {
		//pr($this->data);
            $this->data['Deal']['bonus_amount'] = (!empty($this->data['Deal']['bonus_amount'])) ? $this->data['Deal']['bonus_amount'] : 0;
            $this->data['Deal']['commission_percentage'] = (!empty($this->data['Deal']['commission_percentage'])) ? $this->data['Deal']['commission_percentage'] : 0;
            //pricing calculation
            $this->data['Deal']['savings'] = (!empty($this->data['Deal']['discount_percentage'])) ? ($this->data['Deal']['original_price']*($this->data['Deal']['discount_percentage']/100)) : $this->data['Deal']['discount_amount'];
            $this->data['Deal']['discounted_price'] = $this->data['Deal']['original_price']-$this->data['Deal']['savings'];
            if (!empty($this->data['OldAttachment'])) {
                $attachmentIds = array();
                foreach($this->data['OldAttachment'] as $attachment_id => $is_checked) {
                   if (isset($is_checked['id']) && ($is_checked['id'] == 1)) {
                        $attachmentIds[] = $attachment_id;
                    }
                }
                $attachmentIds = array(
                    'Attachment' => $attachmentIds
                );

				if (!empty($attachmentIds)) {
                    $this->Deal->Attachment->del($attachmentIds);
                }
            }
            unset($this->data['OldAttachment']);
			$ini_clone_attachment = 0;
            if (!empty($this->data['CloneAttachment'])) {
                $ini_clone_attachment = 1;
            }
			// Free deal validation unset process
            if ($this->data['Deal']['discounted_price'] == 0) {
                unset($this->Deal->validate['discounted_price']['rule2']);
                unset($this->Deal->validate['commission_percentage']['rule2']);
            } else {
                unset($this->Deal->validate['discounted_price']['rule3']);
                unset($this->Deal->validate['commission_percentage']['rule3']);
                unset($this->Deal->validate['bonus_amount']['rule2']);
            }			
			// An time deal validation unset process
			if ($this->data['Deal']['is_anytime_deal']) {
                unset($this->Deal->validate['end_date']);
                unset($this->Deal->validate['coupon_expiry_date']);	
				unset($this->Deal->validate['coupon_start_date']['rule2']);						
				unset($this->data['Deal']['coupon_expiry_date']);
				unset($this->data['Deal']['end_date']);
			}
            $this->Deal->set($this->data);
			$this->Deal->City->set($this->data);
            if ($this->Deal->validates() &$this->Deal->City->validates()) {
                if (($ini_clone_attachment || $this->Deal->Attachment->validates())) {
                    $this->Deal->create();
					if (!empty($this->data['Deal']['save_as_draft']) || !empty($this->data['Deal']['is_save_draft'])) {
                        $this->data['Deal']['deal_status_id'] = ConstDealStatus::Draft;
                    } elseif ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                        $this->data['Deal']['deal_status_id'] = ConstDealStatus::Upcoming;
                    } else {
                        $this->data['Deal']['deal_status_id'] = ConstDealStatus::PendingApproval;
                    }
                    $this->Deal->save($this->data);					
					$this->Deal->Attachment->create();	
					if (!empty($ini_clone_attachment)) {
                        $this->Deal->Attachment->enableUpload(false); //don't trigger upload behavior on save
                        $this->Deal->Attachment->create();
						foreach($this->data['CloneAttachment'] as $key => $value){							
							$cloneAttachment = $this->Deal->Attachment->find('first', array(
								'conditions' => array(
									'Attachment.id' => $value['id']
								)
							));
							$this->Deal->Attachment->create();
							$deal_id = $this->Deal->getLastInsertId();
							$data['Attachment']['foreign_id'] = $deal_id;
							$data['Attachment']['class'] = 'Deal';
							$data['Attachment']['mimetype'] = $cloneAttachment["Attachment"]['mimetype'];
							$data['Attachment']['dir'] = 'Deal/' . $deal_id;
							$data['Attachment']['filename'] = $cloneAttachment["Attachment"]['filename'];
							$upload_path = APP . 'media' . DS . 'Deal' . DS . $deal_id . DS;
							new Folder($upload_path, true);
							$upload_path = $upload_path . $cloneAttachment["Attachment"]['filename'];
							$source_path = APP . 'media' . DS . 'Deal' . DS . $cloneAttachment["Attachment"]['foreign_id'] . DS . $cloneAttachment["Attachment"]['filename'];
							copy($source_path, $upload_path);
							$this->Deal->Attachment->save($data['Attachment']);
						}
                    }
					if (!isset($this->data['Attachment']) && $this->RequestHandler->isAjax()) { // Flash Upload
						$this->data['Attachment']['foreign_id'] = $this->Deal->getLastInsertId();
						$this->data['Attachment']['description'] = 'Deal';
						$this->XAjax->flashuploadset($this->data);
					}else { // Normal Upload
						$is_form_valid = true;
						$upload_photo_count = 0;
						for ($i = 0; $i < count($this->data['Attachment']); $i++) {
							if (!empty($this->data['Attachment'][$i]['filename']['tmp_name'])) {
								$upload_photo_count++;
								$image_info = getimagesize($this->data['Attachment'][$i]['filename']['tmp_name']);
								$this->data['Attachment']['filename'] = $this->data['Attachment'][$i]['filename'];
								$this->data['Attachment']['filename']['type'] = $image_info['mime'];
								$this->data['Attachment'][$i]['filename']['type'] = $image_info['mime'];
								$this->Deal->Attachment->Behaviors->attach('ImageUpload', Configure::read('photo.file'));
								$this->Deal->Attachment->set($this->data);
								if (!$this->Deal->validates() |!$this->Deal->Attachment->validates()) {
									$attachmentValidationError[$i] = $this->Deal->Attachment->validationErrors;
									$is_form_valid = false;
									$this->Session->setFlash(__l('Deal could not be added. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
								}
							}
						}
						if (!$upload_photo_count) {
							$this->Deal->validates();
							$this->Deal->Attachment->validationErrors[0]['filename'] = __l('Required');
							$is_form_valid = false;
						}
						if (!empty($attachmentValidationError)) {
							foreach($attachmentValidationError as $key => $error) {
								$this->Deal->Attachment->validationErrors[$key]['filename'] = $error;
							}
						}
						if ($is_form_valid) {
							$this->data['foreign_id'] = $this->Deal->getLastInsertId();
							$this->data['Attachment']['description'] = 'Deal';
							$this->XAjax->normalupload($this->data, false);
							$this->Session->setFlash(__l('Deal has been added.') , 'default', array('lib' => __l('Success')), 'success');
						}
					}	
                    $deals = $this->Deal->find('first', array(
                        'conditions' => array(
                            'Deal.id' => $this->Deal->getLastInsertId()
                        ) ,
                        'contain' => array(
                            'City' => array(
                                'fields' => array(
                                    'City.id',
                                    'City.name',
                                    'City.slug',
                                )
                            ) ,
                            'Attachment',
                            'Company',
                        ) ,
                        'recursive' => 2
                    ));
                    $slug = $deals['Deal']['slug'];
                    $city_name = $deals['City']['slug'];
                    $this->Deal->_updateDealBitlyURL($deals['Deal']['slug'], $city_name);
                    $this->Session->setFlash(__l('Deal has been added') , 'default', array('lib' => __l('Success')), 'success');
                    if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                        $this->redirect(array(
                            'action' => 'index',
                        ));
                    } else {
                        $this->redirect(array(
                            'action' => 'company',
                            $deals['Company']['slug']
                        ));
                    }
                }
            } else {
                $this->Session->setFlash(__l('Deal could not be added. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
				if (!empty($this->data['Deal']['clone_deal_id'])) {
					$cloneDeal = $this->Deal->find('first', array(
						'conditions' => array(
							'Deal.id' => $this->data['Deal']['clone_deal_id'],
						) ,
						'contain' => array(
							'Attachment'
						) ,
						'fields' => array(
							'Deal.user_id',
							'Deal.name',							
						) ,
						'recursive' => 2
					));							
					$this->data['CloneAttachment'] = $cloneDeal['Attachment'];
				}
            }
        } else {
            if ($this->Auth->user('user_type_id') == ConstUserTypes::User) {
                $this->cakeError('error404');
            } elseif ($this->Auth->user('user_type_id') == ConstUserTypes::Company) {
                $company = $this->Deal->Company->find('first', array(
                    'conditions' => array(
                        'Company.user_id' => $this->Auth->user('id')
                    ) ,
                    'fields' => array(
                        'Company.id',
                        'Company.slug'
                    ) ,
                    'recursive' => -1
                ));
					
                if (empty($company)) {
                    $this->cakeError('error404');
                }
                $this->data['Deal']['company_id'] = $company['Company']['id'];
                $this->data['Deal']['company_slug'] = $company['Company']['slug'];
            }
            if (!empty($this->params['named']['clone_deal_id'])) {
                $cloneDeal = $this->Deal->find('first', array(
                    'conditions' => array(
                        'Deal.id' => $this->params['named']['clone_deal_id'],
                    ) ,
                    'contain' => array(
                        'Attachment',
						'CitiesDeal',
						'Company' => array(
							'fields' => array(
							   'Company.id',
							   'Company.slug'
							),         
						
						),

                    ) ,
                    'fields' => array(
                        'Deal.user_id',
                        'Deal.name',
                        'Deal.description',
                        'Deal.private_note',
                        'Deal.original_price',
                        'Deal.discounted_price',
                        'Deal.discount_percentage',
                        'Deal.discount_amount',
						'Deal.is_anytime_deal',
                        'Deal.savings',
                        'Deal.min_limit',
                        'Deal.max_limit',
                        'Deal.company_id',
                        'Deal.review',
                        'Deal.buy_min_quantity_per_user',
                        'Deal.buy_max_quantity_per_user',
                        'Deal.coupon_condition',
                        'Deal.coupon_highlights',
                        'Deal.comment',
                        'Deal.meta_keywords',
                        'Deal.meta_description',
                        'Deal.bonus_amount',
                        'Deal.commission_percentage',
                        'Deal.is_side_deal',
                    ) ,
                    'recursive' => 2
                ));
                $this->data['Deal'] = $cloneDeal['Deal'];
                $this->data['Deal']['clone_deal_id'] = $this->params['named']['clone_deal_id'];
				$this->data['Deal']['company_slug'] =  $cloneDeal['Company']['slug'];
                $this->data['CloneAttachment'] = $cloneDeal['Attachment'];
                if ($this->Auth->user('user_type_id') == ConstUserTypes::Company && $this->data['Deal']['company_id'] != $company['Company']['id']) {
                    $this->cakeError('error404');
                }
				foreach($cloneDeal['CitiesDeal'] as $city_deal){
					$city_id[] = $city_deal['city_id'];
				}
				$this->set('city_id', $city_id);
            }
            $this->data['Deal']['user_id'] = $this->Auth->user('id');
            $this->data['Deal']['buy_min_quantity_per_user'] = 1;
            //set values for deal amount calculator
            $this->data['Deal']['calculator_discounted_price'] = (!empty($this->data['Deal']['discounted_price'])) ? $this->data['Deal']['discounted_price'] : '';
            $this->data['Deal']['calculator_min_limit'] = (!empty($this->data['Deal']['min_limit'])) ? $this->data['Deal']['min_limit'] : '';
            $this->data['Deal']['calculator_commission_percentage'] = (!empty($this->data['Deal']['commission_percentage'])) ? $this->data['Deal']['commission_percentage'] : '';
            $this->data['Deal']['calculator_bonus_amount'] = (!empty($this->data['Deal']['bonus_amount'])) ? $this->data['Deal']['bonus_amount'] : '';
            if (empty($this->params['named']['clone_deal_id']) && $this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                $this->data['Deal']['city_id'] = $this->Session->read('city_filter_id');
            }
        }
        //set values for deal amount calculator
        if (!empty($this->data['Deal']['calculator_discounted_price']) && !empty($this->data['Deal']['calculator_min_limit']) && !empty($this->data['Deal']['calculator_commission_percentage']) && !empty($this->data['Deal']['calculator_bonus_amount'])) {
            $this->data['Deal']['calculator_total_purchased_amount'] = $this->data['Deal']['calculator_discounted_price']*$this->data['Deal']['calculator_min_limit'];
            $this->data['Deal']['calculator_total_commission_amount'] = ($this->data['Deal']['calculator_total_purchased_amount']*($this->data['Deal']['calculator_commission_percentage']/100)) +$this->data['Deal']['calculator_bonus_amount'];
            $this->data['Deal']['calculator_net_profit'] = $this->data['Deal']['calculator_total_commission_amount'];
        }
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
            $companies = $this->Deal->Company->find('list');
            $this->set(compact('companies'));
        }
        $cities = $this->Deal->City->find('list', array(
            'conditions' => array(
                'City.is_approved =' => 1
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
        $this->set(compact('cities'));
    }
    function flashupload()
    {
        $this->Deal->Attachment->Behaviors->attach('ImageUpload', Configure::read('photo.file'));
        $this->XAjax->flashupload();
    }
    function invite_friends()
    {
    }
    function delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->Deal->del($id)) {
			$this->Deal->_updateCityDealCount();
            $this->Session->setFlash(__l('Deal deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function update_status($deal_id = null)
    {
        if (is_null($deal_id)) {
            $this->cakeError('error404');
        }
        $this->Deal->updateAll(array(
            'Deal.deal_status_id' => ConstDealStatus::PendingApproval
        ) , array(
            'Deal.id' => $deal_id
        ));
        $deal = $this->Deal->find('first', array(
            'conditions' => array(
                'Deal.id' => $deal_id
            ) ,
            'contain' => array(
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                    )
                ) ,
                'Attachment',
                'Company',
            ) ,
            'recursive' => 2
        ));
        $slug = $deal['Deal']['slug'];
        $city_name = $deal['City']['name'];
		$this->Deal->_updateCityDealCount();
        $this->Session->setFlash(__l('Deal has been updated') , 'default', array('lib' => __l('Success')), 'success');
        $this->redirect(array(
            'controller' => 'deals',
            'action' => 'company',
            $deal['Company']['slug']
        ));
    }
    function admin_index()
    {
        $this->disableCache();
        $title = '';
        $this->_redirectGET2Named(array(
            'filter_id',
            'q'
        ));
        $conditions = array();
        if (!empty($this->params['named']['company'])) {
            $company_id = $this->Deal->Company->find('first', array(
                'conditions' => array(
                    'Company.slug' => $this->params['named']['company']
                ) ,
                'recursive' => -1
            ));
            $conditions['Deal.company_id'] = $company_id['Company']['id'];
        }
        if (!empty($this->params['named']['city_slug'])) {
            $city_id = $this->Deal->City->find('first', array(
                'conditions' => array(
                    'City.slug' => $this->params['named']['city_slug']
                ) ,
                'recursive' => -1
            ));
			$city_filter_id = $city_id['City']['id'];
        }
        if (!empty($this->data['Deal']['filter_id'])) {
            $this->params['named']['filter_id'] = $this->data['Deal']['filter_id'];
        }

        if (!empty($this->data['Deal']['q'])) {
            $this->params['named']['q'] = $this->data['Deal']['q'];
        }

        if (!empty($this->params['named']['filter_id'])) {
            $conditions['Deal.deal_status_id'] = $this->params['named']['filter_id'];
            $status = $this->Deal->DealStatus->find('first', array(
                'conditions' => array(
                    'DealStatus.id' => $this->params['named']['filter_id'],
                ) ,
                'fields' => array(
                    'DealStatus.name'
                ) ,
                'recursive' => -1
            ));
            $title = $status['DealStatus']['name'];
        }
        $this->pageTitle = sprintf(__l(' %s Deals') , $title);
        if (isset($this->params['named']['q'])) {
			$conditions['Deal.name LIKE'] = '%' . $this->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->params['named']['q']);
        }
        // check the filer passed through named parameter
        if (isset($this->params['named']['stat']) && $this->params['named']['stat'] == 'day') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Deal.created) <= '] = 0;
            $this->pageTitle.= __l(' - Created today');
        }
        if (isset($this->params['named']['stat']) && $this->params['named']['stat'] == 'week') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Deal.created) <= '] = 7;
            $this->pageTitle.= __l(' - Created in this week');
        }
        if (isset($this->params['named']['stat']) && $this->params['named']['stat'] == 'month') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Deal.created) <= '] = 30;
            $this->pageTitle.= __l(' - Created in this month');
        }
        // Citywise admin filter //
        if (!empty($this->data['Deal']['deal_city_id'])) {
            $city_filter_id = $this->data['Deal']['deal_city_id'];
        }
        if (empty($city_filter_id)) {
            $city_filter_id = $this->Session->read('city_filter_id');
        }
		if(!empty($city_filter_id)){
            $deal_cities = $this->Deal->City->find('first', array(
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
			if(!empty($city_deal_id)){
				$conditions['Deal.id'] = $city_deal_id;
			}
		}
		
        //$this->Deal->recursive = 2;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                    'fields' => array(
                        'User.user_type_id',
                        'User.username',
                        'User.id',
                        'User.email',
                        'User.password',
                        'User.fb_user_id'
                    )
                ) ,
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                    )
                ) ,
                'DealStatus' => array(
                    'fields' => array(
                        'DealStatus.name',
                    )
                ) ,
                'DealUser' => array(
                    'fields' => array(
                        'distinct(DealUser.user_id) as count_user'
                    )
                ) ,
                'Company' => array(
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
                    'fields' => array(
                        'Company.id',
                        'Company.name',
                        'Company.slug',
                        'Company.address1',
                        'Company.address2',
                        'Company.city_id',
                        'Company.state_id',
                        'Company.country_id',
                        'Company.zip',
                        'Company.url',
                    )
                ) ,
                'Attachment' => array(
                    'fields' => array(
                        'Attachment.id',
                        'Attachment.dir',
                        'Attachment.filename'
                    )
                ) ,
            ) ,
            'order' => array(
                'Deal.id' => 'desc'
            )
        );
        if (!empty($this->params['named']['q'])) {
            $this->paginate['search'] = $this->params['named']['q'];
        }
        $dealStatuses = $this->Deal->DealStatus->find('list');
        $dealStatusesCount = array();
        $count_conditions = array();
        if (!empty($this->params['named']['company'])) {
            $company_id = $this->Deal->Company->find('first', array(
                'conditions' => array(
                    'Company.slug' => $this->params['named']['company']
                ) ,
                'recursive' => -1
            ));
            $count_conditions['Deal.company_id'] = $company_id['Company']['id'];
        }
        if (!empty($this->params['named']['city_slug'])) {
            $city_id = $this->Deal->City->find('first', array(
                'conditions' => array(
                    'City.slug' => $this->params['named']['city_slug']
                ) ,
                'recursive' => -1
            ));
			$city_filter_id = $city_id['City']['id'];
        }
        // Citywise admin filter //
		if(!empty($city_filter_id)){
            $deal_cities = $this->Deal->City->find('first', array(
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
			if(!empty($city_deal_id)){
				$count_conditions['Deal.id'] = $city_deal_id;
			}
		}
        foreach($dealStatuses as $id => $dealStatus) {
            $count_conditions['Deal.deal_status_id'] = $id;
            $dealStatusesCount[$id] = $this->Deal->find('count', array(
                'conditions' => $count_conditions,
                'recursive' => -1
            ));
        }
        $this->set('dealStatusesCount', $dealStatusesCount);
        $this->set('dealStatuses', $dealStatuses);
        $this->set('deals', $this->paginate());
        //add more actions depends on the deal status
        $moreActions = array();
        if (!empty($this->params['named']['filter_id']) && $this->params['named']['filter_id'] == ConstDealStatus::Upcoming) {
            $moreActions = array(
                ConstDealStatus::Open => __l('Open') ,
                ConstDealStatus::Canceled => __l('Canceled') ,
                ConstDealStatus::Rejected => __l('Rejected') ,
            );
        } elseif (!empty($this->params['named']['filter_id']) && $this->params['named']['filter_id'] == ConstDealStatus::Open) {
            $moreActions = array(
                ConstDealStatus::Canceled => __l('Cancel and refund') ,
                ConstDealStatus::Expired => __l('Expired') ,
            );
        } elseif (!empty($this->params['named']['filter_id']) && $this->params['named']['filter_id'] == ConstDealStatus::Canceled) {
            $moreActions = array(
                ConstDealStatus::Open => __l('Open') ,
            );
        } elseif (!empty($this->params['named']['filter_id']) && $this->params['named']['filter_id'] == ConstDealStatus::Expired) {
            $moreActions = array(
                ConstDealStatus::Refunded => __l('Refunded') ,
            );
        } elseif (!empty($this->params['named']['filter_id']) && $this->params['named']['filter_id'] == ConstDealStatus::Tipped) {
            $moreActions = array(
                ConstDealStatus::Closed => __l('Closed') ,
            );
        } elseif (!empty($this->params['named']['filter_id']) && $this->params['named']['filter_id'] == ConstDealStatus::PendingApproval) {
            $moreActions = array(
                ConstDealStatus::Upcoming => __l('Upcoming') ,
                ConstDealStatus::Open => __l('Open') ,
                ConstDealStatus::Canceled => __l('Canceled') ,
                ConstDealStatus::Rejected => __l('Rejected') ,
            );
        } elseif (!empty($this->params['named']['filter_id']) && $this->params['named']['filter_id'] == ConstDealStatus::Rejected) {
            $moreActions = array(
                ConstDealStatus::Upcoming => __l('Upcoming') ,
                ConstDealStatus::Open => __l('Open') ,
                ConstDealStatus::Canceled => __l('Canceled') ,
            );
        } elseif (!empty($this->params['named']['filter_id']) && $this->params['named']['filter_id'] == ConstDealStatus::Draft) {
            $moreActions = array(
                ConstDealStatus::Upcoming => __l('Upcoming') ,
                ConstDealStatus::Delete => __l('Delete') ,
                ConstDealStatus::Canceled => __l('Canceled') ,
            );
        } elseif (!empty($this->params['named']['filter_id']) && $this->params['named']['filter_id'] == ConstDealStatus::Closed) {
            $moreActions = array(
                ConstDealStatus::PaidToCompany => __l('Pay To Company')
            );
        }
        if (!empty($moreActions)) {
            $this->set(compact('moreActions'));
        }
        $cities = $this->Deal->City->find('list', array(
            'conditions' => array(
                'City.is_approved =' => 1
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
		if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'success') {
			$this->Session->setFlash(__l('Deal has been added.') , 'default', array('lib' => __l('Success')), 'success');
		}	
        $this->set('deal_selected_city', $city_filter_id);
        $this->set('cities', $cities);
        $this->set('pageTitle', $this->pageTitle);
    }
    function deals_print()
    {
        //print deal details and deal users list
        $this->autoRender = false;
        // Checking whether the deal belows to the logged in company user.
        $company = $this->Deal->Company->find('first', array(
            'conditions' => array(
                'Company.user_id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        if (!empty($this->params['named']['page_type']) && ((!empty($company) && $this->Auth->user('user_type_id') == ConstUserTypes::Company) || ($this->Auth->user('user_type_id') == ConstUserTypes::Admin)) && $this->params['named']['page_type'] == 'print') {
            $this->layout = 'print';
            if ($this->Auth->user('user_type_id') != ConstUserTypes::Admin) {
                $conditions['Deal.company_id'] = $company['Company']['id']; // Checking whether the deal belows to the logged in company user.

            }
            if (!empty($this->params['named']['deal_id'])) {
                $conditions['Deal.id'] = $this->params['named']['deal_id'];
            }
            if (!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] != 'all')) {
                $conditions['Deal.deal_status_id'] = $this->params['named']['filter_id'];
            }
            $deals = $this->Deal->find('all', array(
                'conditions' => $conditions,
                'contain' => array(
                    'DealUser' => array(
                        'User' => array(
                            'fields' => array(
                                'id',
                                'username',
                                'email',
                            )
                        ) ,
                        'fields' => array(
                            'id',
                            'discount_amount',
                            'quantity',
                            'is_canceled'
                        ) ,
                        'DealUserCoupon'
                    ) ,
                    'DealStatus' => array(
                        'fields' => array(
                            'DealStatus.id',
                            'DealStatus.name',
                        )
                    ) ,
                ) ,
                'fields' => array(
                    'Deal.id',
                    'Deal.name',
                    'Deal.deal_user_count',
                    'Deal.coupon_expiry_date',
                ) ,
                'recursive' => 2
            ));
            Configure::write('debug', 0);
            if (!empty($deals)) {
                foreach($deals as $deal) {
                    foreach($deal['DealUser'] as $dealusers) {
                        if ($dealusers['is_canceled'] == 0) {
                            $data[]['Deal'] = array(
                                'dealname' => $deal['Deal']['name'],
                                'username' => $dealusers['User']['username'],
                                'quantity' => $dealusers['quantity'],
                                'discount_amount' => $dealusers['discount_amount'],
                                'coupon_code' => $dealusers['DealUserCoupon'],
                                'coupon_expiry_date' => strftime(Configure::read('site.datetime.format') , strtotime(_formatDate('Y-m-d H:i:s', strtotime($deal['Deal']['coupon_expiry_date'])))) ,
                                'is_used' => $dealusers['DealUserCoupon']
                            );
                        }
                    }
                }
                $deal_list['deal_name'] = $deals['0']['Deal']['name'];
                $deal_list['coupon_expiry_date'] = !empty($deals['0']['Deal']['coupon_expiry_date']) ? $deals['0']['Deal']['coupon_expiry_date'] : '-';
                $deal_list['deal_user_count'] = $deals['0']['Deal']['deal_user_count'];
                $deal_list['deal_status'] = $deals['0']['DealStatus']['name'];
                $this->set('deals', $data);
                $this->set('deal_list', $deal_list);
                $this->render('index_print_deal_users');
            }
        }
    }
    function admin_deals_print()
    {
        $this->setAction('deals_print');
    }
    function admin_add()
    {
        $this->setAction('add');
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Deal');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $id = !empty($id) ? $id : $this->data['Deal']['id'];
        $deal = $this->Deal->find('first', array(
            'conditions' => array(
                'Deal.id' => $id
            ) ,
            'contain' => array(
                'City'
            ) ,
            'recursive' => 1
        ));
        if (empty($deal)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if (!empty($this->data['OldAttachment'])) {
                $attachmentIds = array();
                foreach($this->data['OldAttachment'] as $attachment_id => $is_checked) {
                    if (isset($is_checked['id']) && ($is_checked['id'] == 1)) {
                        $attachmentIds[] = $attachment_id;
                    }
                }
                $attachmentIds = array(
                    'Attachment' => $attachmentIds
                );
                if (!empty($attachmentIds)) {
                    $this->Deal->Attachment->del($attachmentIds);
                }
            }
            unset($this->data['OldAttachment']);
            unset($this->Deal->validate['start_date']['rule2']);
            $this->data['Deal']['savings'] = (!empty($this->data['Deal']['discount_percentage'])) ? ($this->data['Deal']['original_price']*($this->data['Deal']['discount_percentage']/100)) : $this->data['Deal']['discount_amount'];
            $this->data['Deal']['discounted_price'] = $this->data['Deal']['original_price']-$this->data['Deal']['savings'];
            if (!empty($this->data['Deal']['send_to_admin']) && $deal['Deal']['deal_status_id'] == ConstDealStatus::Draft) {
                $this->data['Deal']['deal_status_id'] = ConstDealStatus::Upcoming;
            }
            if ($this->data['Deal']['discounted_price'] == 0) {
                unset($this->Deal->validate['discounted_price']['rule2']);
                unset($this->Deal->validate['commission_percentage']['rule2']);
            } else {
                unset($this->Deal->validate['discounted_price']['rule3']);
                unset($this->Deal->validate['commission_percentage']['rule3']);
                unset($this->Deal->validate['bonus_amount']['rule2']);
            }
			// An time deal validation unset process
			if ($this->data['Deal']['is_anytime_deal']) {
                unset($this->Deal->validate['end_date']);
                unset($this->Deal->validate['coupon_expiry_date']);	
				unset($this->Deal->validate['coupon_start_date']['rule2']);						
				unset($this->data['Deal']['coupon_expiry_date']);
				unset($this->data['Deal']['end_date']);
			}
            if ($this->Deal->validates()) {
                if ($this->Deal->save($this->data)) {
                    // finding again, coz deal slug has been changed during edit and forming Bitly Url based on the new slug
                    $deal = $this->Deal->find('first', array(
                        'conditions' => array(
                            'Deal.id' => $this->data['Deal']['id']
                        ) ,
                        'contain' => array(
                            'City'
                        ) ,
                        'recursive' => 1
                    ));
                    $slug = $deal['Deal']['slug'];
                    $city_name = $deal['City']['slug'];
					 $this->Deal->_updateCityDealCount();
                    $this->Deal->_updateDealBitlyURL($deal['Deal']['slug'], $city_name);
                    // Tipping Deals
                    if (($this->data['Deal']['min_limit'] <= $deal['Deal']['deal_user_count']) && $deal['Deal']['deal_status_id'] == ConstDealStatus::Open) {
                        $this->Deal->updateAll(array(
                            'Deal.deal_status_id' => ConstDealStatus::Tipped,
                            'Deal.deal_tipped_time' => '\'' . date('Y-m-d H:i:s') . '\''
                        ) , array(
                            'Deal.deal_status_id' => ConstDealStatus::Open,
                            'Deal.id' => $deal['Deal']['id']
                        ));
                        $this->Deal->processDealStatus($deal['Deal']['id']);
                    }
                    $this->Deal->set($this->data);
                    $foreign_id = $this->data['Deal']['id'];
                    /*$attach = $this->Attachment->find('first', array(
                    'conditions' => array(
                    'Attachment.foreign_id' => $foreign_id,
                    'Attachment.class' => 'Deal'
                    ) ,
                    'fields' => array(
                    'Attachment.id'
                    ) ,
                    'recursive' => -1
                    ));
                    if (!empty($this->data['Attachment']['filename']['name'])) {
                    $this->data['Attachment']['filename'] = $this->data['Attachment']['filename'];
                    $this->data['Attachment']['class'] = $this->modelClass;
                    $this->data['Attachment']['description'] = 'Product Image';
                    $this->data['Attachment']['id'] = $attach['Attachment']['id'];
                    $this->data['Attachment']['foreign_id'] = $this->data['Deal']['id'];
                    $this->Attachment->Behaviors->attach('ImageUpload', Configure::read('product.file'));
                    $this->Attachment->set($this->data);
                    if ($this->Attachment->validates()) {
                    $this->Attachment->save($this->data['Attachment']);
                    }
                    }*/
                    $this->Deal->Attachment->create();
                    if (!isset($this->data['Attachment']) && $this->RequestHandler->isAjax()) { // Flash Upload
                        $this->data['Attachment']['foreign_id'] = $foreign_id;
                        $this->data['Attachment']['description'] = 'Deal';
                        $this->XAjax->flashuploadset($this->data);
                    } else { // Normal Upload
                        $is_form_valid = true;
                        $upload_photo_count = 0;
                        for ($i = 0; $i < count($this->data['Attachment']); $i++) {
                            if (!empty($this->data['Attachment'][$i]['filename']['tmp_name'])) {
                                $upload_photo_count++;
                                $image_info = getimagesize($this->data['Attachment'][$i]['filename']['tmp_name']);
                                $this->data['Attachment']['filename'] = $this->data['Attachment'][$i]['filename'];
                                $this->data['Attachment']['filename']['type'] = $image_info['mime'];
                                $this->data['Attachment'][$i]['filename']['type'] = $image_info['mime'];
                                $this->Deal->Attachment->Behaviors->attach('ImageUpload', Configure::read('photo.file'));
                                $this->Deal->Attachment->set($this->data);
                                if (!$this->Deal->validates() |!$this->Deal->Attachment->validates()) {
                                    $attachmentValidationError[$i] = $this->Deal->Attachment->validationErrors;
                                    $is_form_valid = false;
                                    $this->Session->setFlash(__l('Deal could not be added. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
                                }
                            }
                        }
                        if (!$upload_photo_count) {
                            $this->Deal->validates();
                            $this->Deal->Attachment->validationErrors[0]['filename'] = __l('Required');
                            $is_form_valid = false;
                        }
                        if (!empty($attachmentValidationError)) {
                            foreach($attachmentValidationError as $key => $error) {
                                $this->Deal->Attachment->validationErrors[$key]['filename'] = $error;
                            }
                        }
                        if ($is_form_valid) {
                            $this->data['foreign_id'] = $foreign_id;
                            $this->data['Attachment']['description'] = 'Deal';
                            $this->XAjax->normalupload($this->data, false);
                            $this->Session->setFlash(__l('Deal has been added.') , 'default', array('lib' => __l('Success')), 'success');
                        }
                    }
                    $this->Session->setFlash(__l('Deal has been updated') , 'default', array('lib' => __l('Success')), 'success');
                    $this->redirect(array(
                        'controller' => 'deals',
                        'action' => 'index'
                    ));
                }
            } else {
                $this->Session->setFlash(__l('Deal could not be updated. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
            $attachment = $this->Attachment->find('first', array(
                'conditions' => array(
                    'Attachment.foreign_id = ' => $this->data['Deal']['id']
                ) ,
                'recursive' => -1,
            ));
            $this->data['Attachment'] = $attachment['Attachment'];
        } else {
            $this->data = $this->Deal->find('first', array(
                'conditions' => array(
                    'Deal.id' => $id
                ) ,
                'recursive' => 1
            ));
            if (!empty($this->data['Deal']['start_date'])) {
                $this->data['Deal']['start_date'] = _formatDate('Y-m-d H:i:s', strtotime($this->data['Deal']['start_date']));
            }
            if (!empty($this->data['Deal']['end_date'])) {
                $this->data['Deal']['end_date'] = _formatDate('Y-m-d H:i:s', strtotime($this->data['Deal']['end_date']));
            }
            if (!empty($this->data['Deal']['coupon_start_date'])) {
                $this->data['Deal']['coupon_start_date'] = _formatDate('Y-m-d H:i:s', strtotime($this->data['Deal']['coupon_start_date']));
            }
            if (!empty($this->data['Deal']['coupon_expiry_date'])) {
                $this->data['Deal']['coupon_expiry_date'] = _formatDate('Y-m-d H:i:s', strtotime($this->data['Deal']['coupon_expiry_date']));
            }
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
            //set values for deal amount calculator
            $this->data['Deal']['calculator_discounted_price'] = $this->data['Deal']['discounted_price'];
            $this->data['Deal']['calculator_min_limit'] = $this->data['Deal']['min_limit'];
            $this->data['Deal']['calculator_commission_percentage'] = $this->data['Deal']['commission_percentage'];
            $this->data['Deal']['calculator_bonus_amount'] = $this->data['Deal']['bonus_amount'];
        }
        //set values for deal amount calculator
        if (!empty($this->data['Deal']['calculator_discounted_price']) && !empty($this->data['Deal']['calculator_min_limit']) && !empty($this->data['Deal']['calculator_commission_percentage']) && !empty($this->data['Deal']['calculator_bonus_amount'])) {
            $this->data['Deal']['calculator_total_purchased_amount'] = $this->data['Deal']['calculator_discounted_price']*$this->data['Deal']['calculator_min_limit'];
            $this->data['Deal']['calculator_total_commission_amount'] = ($this->data['Deal']['calculator_total_purchased_amount']*($this->data['Deal']['calculator_commission_percentage']/100)) +$this->data['Deal']['calculator_bonus_amount'];
            $this->data['Deal']['calculator_net_profit'] = $this->data['Deal']['calculator_total_commission_amount'];
        }
        $this->pageTitle.= ' - ' . $this->data['Deal']['name'];
        $discounts = array();
        for ($i = 1; $i <= 100; $i++) {
            $discounts[$i] = $i;
        }
        $cities = $this->Deal->City->find('list', array(
            'conditions' => array(
                'City.is_approved =' => 1
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
        $companies = $this->Deal->Company->find('list');
        $dealStatuses = $this->Deal->DealStatus->find('list');
        $this->set('deal', $deal);
        $this->set(compact('cities', 'dealStatuses', 'companies', 'discounts'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->Deal->del($id)) {
			$this->Deal->_updateCityDealCount();
            $this->Session->setFlash(__l('Deal deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    //more actions in admin index page
    function admin_update()
    {
        $this->autoRender = false;
        if (!empty($this->data['Deal'])) {
            $r = $this->data[$this->modelClass]['r'];
            $actionid = $this->data[$this->modelClass]['more_action_id'];
            unset($this->data[$this->modelClass]['r']);
            unset($this->data[$this->modelClass]['more_action_id']);
            $dealIds = array();
            foreach($this->data['Deal'] as $deal_id => $is_checked) {
                if ($is_checked['id']) {
                    $dealIds[] = $deal_id;
                }
            }
            if ($actionid && !empty($dealIds)) {
                if ($actionid == ConstDealStatus::Open) {
                    $dealsLeft = false;
                    foreach($this->data['Deal'] as $deal_id => $is_checked) {
                        if ($is_checked['id']) {
                            $deal = $this->Deal->find('first', array(
                                'conditions' => array(
                                    'Deal.id' => $deal_id
                                ) ,
                                'fields' => array(
                                    'Deal.end_date',
                                    'Deal.coupon_expiry_date',
                                    'Deal.is_anytime_deal'
                                ) ,
                                'recursive' => -1
                            ));
							if ((strtotime(_formatDate('Y-m-d H:i:s', strtotime($deal['Deal']['end_date']))) >= strtotime(date('Y-m-d H:i:s')) && strtotime(_formatDate('Y-m-d H:i:s', strtotime($deal['Deal']['coupon_expiry_date']))) >= strtotime(date('Y-m-d H:i:s'))) || !empty($deal['Deal']['is_anytime_deal'])) {
                                $this->Deal->updateAll(array(
                                    'Deal.deal_status_id' => ConstDealStatus::Open,
                                    'Deal.start_date' => '"' . date('Y-m-d H:i:s') . '"',
                                ) , array(
                                    'Deal.id' => $deal_id
                                ));
                                $this->Deal->_processOpenStatus($deal_id);
                            } else {
                                $dealsLeft = true;
                            }
                        }
                    }
                    $this->Deal->_sendSubscriptionMail();
                    $msg = __l('Checked deals have been moved to open status. ');
                    if ($dealsLeft) {
                        $msg.= __l('Some of the deals are not opened due to the end date and coupon expiry date in past.');
                    }
                    $this->Session->setFlash($msg, 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstDealStatus::Canceled) {
                    $openDealIds = $this->Deal->find('list', array(
                        'conditions' => array(
                            'Deal.id' => $dealIds,
                            'Deal.deal_status_id' => ConstDealStatus::Open,
                        ) ,
                        'recursive' => -1,
                    ));
                    if (!empty($openDealIds)) {
                        $this->Deal->_refundDealAmount('update', array_keys($openDealIds));
                    }
                    //manual refund for deals. So deals are not closed
                    $conditions['Deal.deal_status_id !='] = ConstDealStatus::Refunded;
                    $conditions['Deal.id'] = $dealIds;
                    $this->Deal->updateAll(array(
                        'Deal.deal_status_id' => ConstDealStatus::Canceled,
                        'Deal.deal_user_count' => 0,
                        'Deal.deal_tipped_time' => "'0000-00-00 00:00:00'",
                        'Deal.is_coupon_mail_sent' => 0,
                        'Deal.is_subscription_mail_sent' => 0,
                        'Deal.total_purchased_amount' => 0,
                        'Deal.total_commission_amount' => 0,
                    ) , $conditions);
                    $this->Session->setFlash(__l('Checked deals have been canceled') , 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstDealStatus::Rejected) {
                    $this->Deal->updateAll(array(
                        'Deal.deal_status_id' => ConstDealStatus::Rejected
                    ) , array(
                        'Deal.id' => $dealIds
                    ));
                    $this->Session->setFlash(__l('Checked deals have been rejected') , 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstDealStatus::Expired) {
                    //Get the Quantity for selected deals.
                    $quantities = $this->Deal->find('all', array(
                        'conditions' => array(
                            'Deal.id' => $dealIds
                        ) ,
                        'fields' => array(
                            'Deal.deal_user_count',
                            'Deal.id',
                            'Deal.is_anytime_deal'
                        ) ,
                        'recursive' => -1
                    ));
                    foreach($quantities as $quantity) {
						if(empty($quantity['Deal']['is_anytime_deal'])){
							if ($quantity['Deal']['deal_user_count'] == 0) {
								$this->Deal->updateAll(array(
									'Deal.deal_status_id' => ConstDealStatus::Expired,
								) , array(
									'Deal.id' => $quantity['Deal']['id']
								));
							} else {
								$this->Deal->_refundDealAmount('admin_update', $quantity['Deal']['id']);
								$this->Deal->updateAll(array(
									'Deal.end_date' => '"' . date('Y-m-d H:i:s') . '"',
								) , array(
									'Deal.id' => $quantity['Deal']['id']
								));
							}
						}else {
							$dealsLeft = true;
						}
                    }
					$msg = __l('Deals have been changed as expired. ');
                    if ($dealsLeft) {
						$msg.= __l('Some of the deals are not expired becasue "AnyTime" Deal cannot be expired. It can be either cancelled or closed.');
                    }
                    $this->Session->setFlash($msg, 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstDealStatus::Refunded) {
                    $this->Deal->_refundDealAmount('admin_update', $dealIds);
                    $this->Session->setFlash(__l('Expired deals have been refunded') , 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstDealStatus::Closed) {
                    $this->Deal->_closeDeals($dealIds);
                    $this->Session->setFlash(__l('Checked deals have been closed') , 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstDealStatus::PaidToCompany) {
                    $this->Deal->updateAll(array(
                        'Deal.total_purchased_amount' => '(Deal.discounted_price * Deal.deal_user_count)',
                        'Deal.total_commission_amount' => '(Deal.bonus_amount + ( Deal.total_purchased_amount * ( Deal.commission_percentage / 100 )))',
                    ) , array(
                        'Deal.deal_status_id' => ConstDealStatus::Closed,
                        'Deal.id' => $dealIds
                    ));
                    $this->Deal->_payToCompany('admin_update', $dealIds);
                    $this->Session->setFlash(__l('Checked deals amount have been transferred') , 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstDealStatus::Upcoming) {
                    $dealsLeft = false;
                    foreach($this->data['Deal'] as $deal_id => $is_checked) {
                        if ($is_checked['id']) {
                            $deal = $this->Deal->find('first', array(
                                'conditions' => array(
                                    'Deal.id' => $deal_id
                                ) ,
                                'fields' => array(
                                    'Deal.end_date',
                                    'Deal.coupon_expiry_date',
                                    'Deal.is_anytime_deal',
                                ) ,
                                'recursive' => -1
                            ));
                            if ((strtotime(_formatDate('Y-m-d H:i:s', strtotime($deal['Deal']['end_date']))) >= strtotime(date('Y-m-d H:i:s')) && strtotime(_formatDate('Y-m-d H:i:s', strtotime($deal['Deal']['coupon_expiry_date']))) >= strtotime(date('Y-m-d H:i:s'))) || !empty($deal['Deal']['is_anytime_deal'])) {
                                $this->Deal->updateAll(array(
                                    'Deal.deal_status_id' => ConstDealStatus::Upcoming
                                ) , array(
                                    'Deal.id' => $deal_id
                                ));
                            } else {
                                $dealsLeft = true;
                            }
                        }
                    }
                    $msg = __l('Checked deals have been moved to upcoming status. ');
                    if ($dealsLeft) {
                        $msg.= __l('Some of the deals are not upcoming due to the end date and coupon expiry date in past.');
                    }
                    $this->Session->setFlash($msg, 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstDealStatus::Delete) {
                    $this->Deal->deleteAll(array(
                        'Deal.id' => $dealIds
                    ));
                    $this->Session->setFlash(__l('Checked deals have been deleted') , 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstDealStatus::PendingApproval) {
                    $this->Deal->updateAll(array(
                        'Deal.deal_status_id' => ConstDealStatus::PendingApproval
                    ) , array(
                        'Deal.id' => $dealIds
                    ));
                    $this->Session->setFlash(__l('Checked deals have been inactive') , 'default', array('lib' => __l('Success')), 'success');
                }
            }
        }
		$this->Deal->_updateCityDealCount();
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect(Router::url('/', true) . $r);
        } else {
            $this->redirect($r);
        }
    }
    //run cron manually from admin side
    function admin_update_status()
    {
        App::import('Component', 'cron');
        $this->Cron = &new CronComponent();
        $this->Cron->update_deal();
		$this->Deal->_updateCityDealCount();
        $this->redirect(array(
            'controller' => 'deals',
            'action' => 'index'
        ));
    }
    //buy a new deal
    function buy($deal_id = null)
    {
		$this->pageTitle = __l('Buy Deal');
        if ((!$this->Deal->User->isAllowed($this->Auth->user('user_type_id'))) || (is_null($deal_id) && empty($this->data['Deal']['deal_id']))) {
            $this->cakeError('error404');
        }
        if (!$this->Auth->user('id') and !empty($this->params['url']['url'])) $this->Session->write('Auth.redirectUrl', $this->params['url']['url']);
        if (!empty($this->data['Deal']['deal_id'])) {
            $deal_id = $this->data['Deal']['deal_id'];
        }
        $deal = $this->Deal->find('first', array(
            'conditions' => array(
                'Deal.id' => $deal_id,
                'Deal.deal_status_id' => array(
                    ConstDealStatus::Open,
                    ConstDealStatus::Tipped
                )
            ) ,
            'fields' => array(
                'Deal.id',
                'Deal.name',
                'Deal.slug',
                'Deal.original_price',
                'Deal.discount_amount',
                'Deal.discounted_price',
                'Deal.description',
                'Deal.discount_percentage',
                'Deal.min_limit',
                'Deal.max_limit',
                'Deal.deal_user_count',
                'Deal.discounted_price',
                'Deal.buy_min_quantity_per_user',
                'Deal.buy_max_quantity_per_user',
                'Deal.end_date',
                'Deal.is_anytime_deal',
            ) ,
            'recursive' => -1
        ));
        $user = $this->Deal->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id') ,
            ) ,
            'fields' => array(
                'User.id',
                'User.fb_user_id',
                'User.email',
            ) ,
            'contain' => array(
                'DealUser'
            ) ,
            'recursive' => 1
        ));
        if (empty($deal)) {
            $this->cakeError('error404');
        }
		if(empty($deal['Deal']['is_anytime_deal']) && $deal['Deal']['end_date'] <= _formatDate('Y-m-d H:i:s', date('Y-m-d H:i:s') , true)){
			$this->Session->setFlash(__l('You\'re too late, this deal has been expired.') , 'default', array('lib' => __l('Error')), 'error');
			$this->redirect(array(
				'controller' => 'deals',
				'action' => 'view',
				$deal['Deal']['slug']
			));
		}
        $user_quantity = '';
        if (!empty($user) && !empty($deal['Deal']['buy_max_quantity_per_user'])) {
            foreach($user['DealUser'] as $user_coupon) {
                if ($user_coupon['deal_id'] == $deal_id) {
                    $user_quantity+= $user_coupon['quantity'];
                }
            }
        }
        $user_available_balance = 0;
        if ($this->Auth->user('id')) {
            $user_available_balance = $this->Deal->User->checkUserBalance($this->Auth->user('id'));
        }
        if (!empty($this->data)) {
            if ($this->data['Deal']['user_id'] == $this->Auth->user('id')) {
                //purchase deal before login and do the validations
                if (!$this->Auth->user('id')) {
                    $this->Deal->User->set($this->data);
                    $this->Deal->User->validates();
                }
                //before login user_id is null
                if (empty($this->data['Deal']['user_id'])) {
                    unset($this->Deal->validate['user_id']);
                }
                // If wallet act like groupon enabled, and purchase with wallet enabled, setting below for making purchase through wallet //
                if (Configure::read('wallet.is_handle_wallet_as_in_groupon') && !empty($this->data['Deal']['is_purchase_via_wallet'])) {
                    $this->data['Deal']['payment_gateway_id'] = ConstPaymentGateways::Wallet;
                }
                // Free deal check
                if ($deal['Deal']['discounted_price'] != 0) {
                    //validation for credit card details
                    if ($this->data['Deal']['payment_gateway_id'] == ConstPaymentGateways::CreditCard) {
                        $this->Deal->validate = array_merge($this->Deal->validate, $this->Deal->validateCreditCard);
                    } else if (($this->data['Deal']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet && isset($this->data['Deal']['payment_profile_id']) && empty($this->data['Deal']['payment_profile_id']))) {
                        $this->Deal->validate = array_merge($this->Deal->validate, $this->Deal->validateCreditCard);
                        if ($this->data['Deal']['is_show_new_card'] == 0) {
                            $payment_gateway_id_validate = array(
                                'payment_profile_id' => array(
                                    'rule1' => array(
                                        'rule' => 'notempty',
                                        'message' => __l('Required')
                                    )
                                )
                            );
                            $this->Deal->validate = array_merge($this->Deal->validate, $payment_gateway_id_validate);
                        }
                    } else if ($this->data['Deal']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet && (!isset($this->data['Deal']['payment_profile_id']))) {
                        $this->Deal->validate = array_merge($this->Deal->validate, $this->Deal->validateCreditCard);
                    }
                } else {
                    $this->data['Deal']['payment_gateway_id'] == ConstPaymentGateways::Wallet;
                }
                $this->Deal->set($this->data);
                $total_deal_amount = $this->data['Deal']['total_deal_amount'] = $deal['Deal']['discounted_price']*$this->data['Deal']['quantity'];
                $this->Deal->validates();
                $user_details_updated = true;
                //for facebook users need to update email address at first time
                if (!empty($user['User']['fb_user_id']) && empty($user['User']['email'])) {
                    $this->data['User']['id'] = $this->Auth->user('id');
                    $this->Deal->User->set($this->data['User']);
                    if ($this->Deal->User->validates() && empty($this->Deal->User->validationErrors)) {
                        $this->Deal->User->save($this->data['User']);
                        if (empty($_SESSION['Auth']['User']['cim_profile_id'])) {
                            $this->Deal->User->_createCimProfile($this->Auth->user('id'));
                        }
                    } else {
                        $user_details_updated = false;
                    }
                }
                if (empty($this->Deal->validationErrors) && $user_details_updated) {
					
                    //for wallet payment if user have enough wallet amt send to _buyDeal method
                    if ($this->Auth->user('id') && $this->data['Deal']['payment_gateway_id'] == ConstPaymentGateways::Wallet && $user_available_balance >= $total_deal_amount) {
                        $this->_buyDeal($this->data);						
						
                    } else {
                        //guset users and users who have less amount in wallet or credit card payment or paypal auth payment
                        $this->process_user($deal);
                    }
                }
                //ehrn validation errors for user fields unset passwords
                if (!$this->Auth->user('id')) {
                    unset($this->data['User']['passwd']);
                    unset($this->data['User']['confirm_password']);
                }
            } else {
                $this->Session->setFlash(__l('Invalid data entered. Your purchase has been cancelled.') , 'default', array('lib' => __l('Error')), 'error');
                $this->redirect(array(
                    'controller' => 'deals',
                    'action' => 'view',
                    $deal['Deal']['slug']
                ));
            }
        } else {
            $this->data['Deal']['is_gift'] = (!empty($this->params['named']['type'])) ? 1 : 0;
            $this->data['Deal']['quantity'] = 1;
            $this->data['Deal']['deal_amount'] = $deal['Deal']['discounted_price'];
            $this->data['Deal']['deal_id'] = $deal_id;
            $this->data['Deal']['total_deal_amount'] = $deal['Deal']['discounted_price'];
            $this->data['Deal']['is_show_new_card'] = 0;
            //if user logged in check whether user eligible to buy deal
            if ($this->Auth->user('id')) {
                if (!$this->Deal->isEligibleForBuy($deal_id, $this->Auth->user('id') , $deal['Deal']['buy_max_quantity_per_user'])) {
                    $this->Session->setFlash(sprintf(__l('You can\'t buy this deal. Your maximum allowed limit %s is over') , $deal['Deal']['buy_max_quantity_per_user']) , 'default', array('lib' => __l('Error')), 'error');
                    $this->redirect(array(
                        'controller' => 'deals',
                        'action' => 'view',
                        $deal['Deal']['slug']
                    ));
                }
            }
            //intially merge credit card validation array
            $this->Deal->validate = array_merge($this->Deal->validate, $this->Deal->validateCreditCard);
        }
        $this->data['Deal']['user_id'] = $this->Auth->user('id');
        // Checking payment settings enabled
        $payment_options = $this->Deal->getGatewayTypes('is_enable_for_buy_a_deal');
        // If 'handle like groupon' enabled, unset wallet. Since, all purchase should proceed through wallet first, coz it is compulsary.
        if (Configure::read('wallet.is_handle_wallet_as_in_groupon')) {
            unset($payment_options[ConstPaymentGateways::Wallet]);
        }
        if ($deal['Deal']['discounted_price'] != 0) {
            //credit card related fields
            if (!empty($payment_options[ConstPaymentGateways::CreditCard]) || !empty($payment_options[ConstPaymentGateways::AuthorizeNet])) {
                $gateway_options['cities'] = $this->Deal->Company->City->find('list', array(
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
                $gateway_options['states'] = $this->Deal->Company->State->find('list', array(
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
                $gateway_options['countries'] = $this->Deal->Company->Country->find('list', array(
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
                $gateway_options['creditCardTypes'] = array(
                    'Visa' => __l('Visa') ,
                    'MasterCard' => __l('MasterCard') ,
                    'Discover' => __l('Discover') ,
                    'Amex' => __l('Amex')
                );
                if (empty($this->data['Deal']['payment_gateway_id'])) {
                    if (!empty($payment_options[ConstPaymentGateways::AuthorizeNet])) {
                        $this->data['Deal']['payment_gateway_id'] = ConstPaymentGateways::AuthorizeNet;
                    } elseif (!empty($payment_options[ConstPaymentGateways::CreditCard])) {
                        $this->data['Deal']['payment_gateway_id'] = ConstPaymentGateways::CreditCard;
                    }
                }
            } elseif (!empty($payment_options[ConstPaymentGateways::PayPalAuth]) && empty($this->data['Deal']['payment_gateway_id'])) {
                $this->data['Deal']['payment_gateway_id'] = ConstPaymentGateways::PayPalAuth;
            } elseif (!empty($payment_options[ConstPaymentGateways::Wallet]) && empty($this->data['Deal']['payment_gateway_id'])) {
                $this->data['Deal']['payment_gateway_id'] = ConstPaymentGateways::Wallet;
            }
        } else {
            $this->data['Deal']['payment_gateway_id'] = ConstPaymentGateways::Wallet;
        }
        $gateway_options['paymentGateways'] = $payment_options;
        if (!$this->Auth->user()) {
            unset($gateway_options['paymentGateways'][ConstPaymentGateways::Wallet]);
        } else {
            $userPaymentProfiles = $this->Deal->User->UserPaymentProfile->find('all', array(
                'fields' => array(
                    'UserPaymentProfile.masked_cc',
                    'UserPaymentProfile.cim_payment_profile_id',
                    'UserPaymentProfile.is_default'
                ) ,
                'conditions' => array(
                    'UserPaymentProfile.user_id' => $this->Auth->user('id')
                ) ,
            ));
            foreach($userPaymentProfiles as $userPaymentProfile) {
                $gateway_options['Paymentprofiles'][$userPaymentProfile['UserPaymentProfile']['cim_payment_profile_id']] = $userPaymentProfile['UserPaymentProfile']['masked_cc'];
                if (!empty($userPaymentProfile['UserPaymentProfile']['is_default'])) {
                    $this->data['Deal']['payment_profile_id'] = $userPaymentProfile['UserPaymentProfile']['cim_payment_profile_id'];
                }
            }
        }
        $states = $this->Deal->Company->State->find('list', array(
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
        if (empty($gateway_options['Paymentprofiles'])) {
            $this->data['Deal']['is_show_new_card'] = 1;
        }
        $this->set('states', $states);
        $this->set('gateway_options', $gateway_options);
        $this->set('deal', $deal);
        $this->set('user', $user);
        $this->set('user_quantity', $user_quantity);
        $this->set('user_available_balance', $user_available_balance);
        $this->data['Deal']['cvv2Number'] = $this->data['Deal']['creditCardNumber'] = '';
    }
    //for new users or who have low balance amount or credit card payment or paypal auth
    function process_user($deal)
    {
        $is_purchase_with_wallet_amount = 0;
        $this->Session->write('Auth.last_bought_deal_slug', $deal['Deal']['slug']);
        if (!empty($this->data)) {
            $total_deal_amount = $deal['Deal']['discounted_price']*$this->data['Deal']['quantity'];
            $valid_user = true;
            //already registered users
            if ($this->Auth->user('id')) {
                //already logged in user
                $user_available_balance = $this->Deal->User->checkUserBalance($this->Auth->user('id'));
                $amount_needed = $total_deal_amount;
                //when wallet amount less than total amount check needed amount
                if ($this->data['Deal']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
                    $valid_user = false;
                    $is_show_credit_card = 0;
                    $this->set('is_show_credit_card', $is_show_credit_card);
                    $this->Session->setFlash(__l('Purchase via wallet not possible as the total purchase amount exceeded your wallet balance.') , 'default', array('lib' => __l('Error')), 'error');
                    //$amount_needed = $total_deal_amount-$user_available_balance;

                }
            } else {
                //new users register process
                $amount_needed = $total_deal_amount;
                $this->Deal->User->create();
                $this->Deal->User->set($this->data['User']);
                if ($this->Deal->User->validates()) {
                    $this->data['User']['is_active'] = 1;
                    $this->data['User']['is_email_confirmed'] = 1;
                    $this->data['User']['password'] = $this->Auth->password($this->data['User']['passwd']);
                    $this->data['User']['user_type_id'] = ConstUserTypes::User;
                    $this->data['User']['signup_ip'] = $this->RequestHandler->getClientIP();
                    $this->data['User']['dns'] = gethostbyaddr($this->RequestHandler->getClientIP());
                    if ($this->Deal->User->save($this->data['User'], false)) {
                        $user_id = $this->Deal->User->getLastInsertId();
                        $this->Deal->User->_createCimProfile($user_id);
                        $this->_sendWelcomeMail($user_id, $this->data['User']['email'], $this->data['User']['username']);
                        $this->data['UserProfile']['user_id'] = $user_id;
                        $this->Deal->User->UserProfile->create();
                        $this->Deal->User->UserProfile->save();
                        $this->Auth->login($this->data['User']);
                        $this->data['Deal']['user_id'] = $user_id;
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
                                '##FROM_EMAIL##' => $this->Deal->User->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
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
                    }
                } else {
                    $valid_user = false;
                }
            }
            //payment process
            if ($valid_user) {
                if ($this->data['Deal']['payment_gateway_id'] == ConstPaymentGateways::CreditCard) {
                    $this->_buyDeal($this->data);
                } else if ($this->data['Deal']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
                    $this->_buyDeal($this->data);
                } else {
                    //paypal process
                    if ($this->data['Deal']['payment_gateway_id'] == ConstPaymentGateways::CreditCard) {
                        $payment_gateway_id = ConstPaymentGateways::PayPalAuth;
                    } elseif ($this->data['Deal']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
                        $payment_gateway_id = ConstPaymentGateways::AuthorizeNet;
                    } elseif ($this->data['Deal']['payment_gateway_id'] == ConstPaymentGateways::PagSeguro) {
                        $payment_gateway_id = ConstPaymentGateways::PagSeguro;
                    } else {
                        $payment_gateway_id = ConstPaymentGateways::PayPalAuth;
                    }
                    $paymentGateway = $this->Deal->User->Transaction->PaymentGateway->find('first', array(
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
                    $this->pageTitle.= sprintf(__l('Buy %s Deal') , $deal['Deal']['name']);
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
                        // If enabled, purchase amount is first taken with amount in wallet and then passed to CreditCard //
                        if (Configure::read('wallet.is_handle_wallet_as_in_groupon')) {
                            $user_available_balance = $this->Deal->User->checkUserBalance($this->Auth->user('id'));
                            $amount_needed = $amount_needed-$user_available_balance;
                            $is_purchase_with_wallet_amount = 1;
                        }
                        $cmd = '_xclick';
                        //gateway options set
                        $gateway_options = array(
                            'cmd' => $cmd,
                            'notify_url' => Router::url('/', true).'deals/processpayment/paypal',
                            'cancel_return' => Router::url('/', true).'deals/payment_cancel/'.$payment_gateway_id,
                            'return' => Router::url('/', true).'deals/payment_success/'.$payment_gateway_id.'/'.$this->data['Deal']['deal_id'],                                
                            'item_name' => $deal['Deal']['name'],
                            'currency_code' => Configure::read('paypal.currency_code') ,
                            'amount' => $amount_needed,
                            'user_defined' => array(
                                'user_id' => $this->Auth->user('id') ,
                                'deal_id' => $this->data['Deal']['deal_id'],
                                'is_gift' => $this->data['Deal']['is_gift'],
                                'quantity' => $this->data['Deal']['quantity'],
                                'payment_gateway_id' => $this->data['Deal']['payment_gateway_id'],
                                'is_purchase_with_wallet_amount' => $is_purchase_with_wallet_amount
                            ) ,
                            'g_defined' => array(
                                'gift_to' => !empty($this->data['Deal']['gift_to']) ? $this->data['Deal']['gift_to'] : '',
                                'gift_from' => !empty($this->data['Deal']['gift_from']) ? $this->data['Deal']['gift_from'] : '',
                                'gift_email' => !empty($this->data['Deal']['gift_email']) ? $this->data['Deal']['gift_email'] : '',
                            ) ,
                            'system_defined' => array(
                                'ip' => $this->RequestHandler->getClientIP() ,
                                'amount_needed' => $amount_needed,
                                'currency_code' => Configure::read('paypal.currency_code') ,
                            ) ,
                            'm_defined' => array(
                                'message' => !empty($this->data['Deal']['message']) ? $this->data['Deal']['message'] : '',
                            )
                        );
                        //for paypal auth
                        if ($this->data['Deal']['payment_gateway_id'] == ConstPaymentGateways::PayPalAuth) {
                            $gateway_options['paymentaction'] = 'authorization';
                        }
                        $this->set('gateway_options', $gateway_options);
                    } elseif ($paymentGateway['PaymentGateway']['name'] == 'AuthorizeNet') {
                        // If enabled, purchase amount is first taken with amount in wallet and then passed to CreditCard //
                        if (Configure::read('wallet.is_handle_wallet_as_in_groupon')) {
                            $user_available_balance = $this->Deal->User->checkUserBalance($this->Auth->user('id'));
                            $amount_needed1 = $amount_needed-$user_available_balance;
                            $is_purchase_with_wallet_amount = 1;
                        }
						if (Configure::read('wallet.is_handle_wallet_as_in_groupon')) {
							$this->data['Deal']['amount'] = $amount_needed1;
						}else{
							$this->data['Deal']['amount'] = $amount_needed;
						}
                        $user = $this->Deal->User->find('first', array(
                            'conditions' => array(
                                'User.id' => $this->Auth->user('id')
                            ) ,
                            'fields' => array(
                                'User.id',
                                'User.cim_profile_id'
                            )
                        ));
                        if (!empty($this->data['Deal']['creditCardNumber'])) {
                            //create payment profile
                            $data = $this->data['Deal'];
                            $data['expirationDate'] = $this->data['Deal']['expDateYear']['year'] . '-' . $this->data['Deal']['expDateMonth']['month'];
                            $data['customerProfileId'] = $user['User']['cim_profile_id'];
                            $payment_profile_id = $this->Deal->User->_createCimPaymentProfile($data);
                            if (is_array($payment_profile_id) && !empty($payment_profile_id['payment_profile_id']) && !empty($payment_profile_id['masked_cc'])) {
                                $payment['UserPaymentProfile']['user_id'] = $this->Auth->user('id');
                                $payment['UserPaymentProfile']['cim_payment_profile_id'] = $payment_profile_id['payment_profile_id'];
                                $payment['UserPaymentProfile']['masked_cc'] = $payment_profile_id['masked_cc'];
                                $payment['UserPaymentProfile']['is_default'] = 0;
                                $this->Deal->User->UserPaymentProfile->save($payment);
                                $this->data['Deal']['payment_profile_id'] = $payment_profile_id['payment_profile_id'];
                            } else {
                                $this->Session->setFlash(sprintf(__l('Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.') , $payment_profile_id['message']) , 'default', array('lib' => __l('Error')), 'error');
                                $this->redirect(array(
                                    'controller' => 'deals',
                                    'action' => 'index'
                                ));
                            }
                        }
                        if (!empty($this->data['Deal']['payment_profile_id'])) {
                            $data['customerProfileId'] = $user['User']['cim_profile_id'];
                            $data['customerPaymentProfileId'] = $this->data['Deal']['payment_profile_id'];
                            $data['amount'] = $this->data['Deal']['amount'];
                            $data['quantity'] = $this->data['Deal']['quantity'];
                            $data['deal_id'] = $this->data['Deal']['deal_id'];
                            $tmp_deal = $this->Deal->find('first', array(
                                'conditions' => array(
                                    'Deal.id' => $this->data['Deal']['deal_id'],
                                    'Deal.deal_status_id' => array(
                                        ConstDealStatus::Open,
                                        ConstDealStatus::Tipped
                                    )
                                ) ,
                                'recursive' => -1
                            ));
                            if ($tmp_deal['Deal']['min_limit'] <= ($tmp_deal['Deal']['deal_user_count']+$this->data['Deal']['quantity'])) {
                                // is going to tipped or already tipped. so no need to authorize the transaction
                                $type = 'profileTransAuthCapture';
                            } else {
                                $type = 'profileTransAuthOnly';
                            }
                            $response = $this->Deal->User->_createCustomerProfileTransaction($data, $type);
                            if (!empty($response['cim_approval_code'])) {
                                if (!empty($response['cim_approval_code'])) {
                                    $deal_user['DealUser']['cim_approval_code'] = $response['cim_approval_code'];
                                }
                                if (!empty($response['cim_transaction_id'])) {
                                    $deal_user['DealUser']['cim_transaction_id'] = $response['cim_transaction_id'];
                                }
                                $deal_user['DealUser']['quantity'] = $this->data['Deal']['quantity'];
                                $deal_user['DealUser']['deal_id'] = $this->data['Deal']['deal_id'];
                                $deal_user['DealUser']['is_paid'] = (!empty($response['capture'])) ? 1 : 0;
                                $deal_user['DealUser']['is_gift'] = $this->data['Deal']['is_gift'];
                                $deal_user['DealUser']['user_id'] = $this->Auth->user('id');
                                $deal_user['DealUser']['discount_amount'] = $amount_needed;
                                $deal_user['DealUser']['payment_gateway_id'] = !empty($this->data['Deal']['payment_gateway_id']) ? $this->data['Deal']['payment_gateway_id'] : ConstPaymentGateways::AuthorizeNet;
                                $deal_user['DealUser']['payment_profile_id'] = $this->data['Deal']['payment_profile_id'];
                                $coupon_code = $this->_uuid();
                                $deal_user['DealUser']['coupon_code'] = $coupon_code;
                                if ($this->data['Deal']['is_gift']) {
                                    $deal_user['DealUser']['gift_email'] = $this->data['Deal']['gift_email'];
                                    $deal_user['DealUser']['message'] = $this->data['Deal']['message'];
                                    $deal_user['DealUser']['gift_to'] = $this->data['Deal']['gift_to'];
                                    $deal_user['DealUser']['gift_from'] = $this->data['Deal']['gift_from'];
                                }
                                $this->Deal->DealUser->create();
                                $this->Deal->DealUser->set($deal_user);
                                if ($this->Deal->DealUser->save($deal_user)) {
                                    $last_inserted_id = $this->Deal->DealUser->getLastInsertId();
                                    $this->Deal->DealUser->AuthorizenetDocaptureLog->updateAll(array(
                                        'AuthorizenetDocaptureLog.deal_user_id' => $last_inserted_id,
                                    ) , array(
                                        'AuthorizenetDocaptureLog.id' => $response['pr_authorize_id']
                                    ));
                                    if (!empty($response['capture'])) {
                                        $deal_user['DealUser']['is_gift'] = (!empty($this->data['Deal']['is_gift'])) ? 1 : 0;
                                        $deal_user['DealUser']['id'] = $last_inserted_id;
                                        $this->Deal->_updateTransaction($deal_user['DealUser']);
                                    }
                                    $deal_user_coupons = array();
                                    $coupon_code = $this->_uuid();
                                    for ($i = 1; $i <= $deal_user['DealUser']['quantity']; $i++) {
                                        $this->Deal->DealUser->DealUserCoupon->create();
                                        $deal_user_coupons['deal_user_id'] = $last_inserted_id;
                                        $deal_user_coupons['coupon_code'] = $coupon_code . '-' . $i;
                                        $deal_user_coupons['unique_coupon_code'] = $this->_unum();
                                        $this->Deal->DealUser->DealUserCoupon->save($deal_user_coupons);
                                    }
                                    // If enabled, and after purchase, deduct partial amount from wallet //
                                    if (Configure::read('wallet.is_handle_wallet_as_in_groupon') && (!empty($is_purchase_with_wallet_amount))) {
                                        // Deduct amount ( zero will be updated ) //
                                        $user_available_balance = $this->Deal->User->checkUserBalance($this->Auth->user('id'));
                                        $this->Deal->User->updateAll(array(
                                            'User.available_balance_amount' => 'User.available_balance_amount -' . $user_available_balance,
                                        ) , array(
                                            'User.id' => $deal_user['DealUser']['user_id']
                                        ));
                                        // Update transaction, This is firs transaction, to notify user that partial amount taken from wallet. Second transaction will be updated after deal gets tipped.//
                                        if (!empty($user_available_balance) && $user_available_balance != '0.00') {
                                            $amount_taken_from_wallet = $total_deal_amount-$user_available_balance;
                                            $transaction['Transaction']['user_id'] = $deal_user['DealUser']['user_id'];
                                            $transaction['Transaction']['foreign_id'] = $last_inserted_id;
                                            $transaction['Transaction']['class'] = 'DealUser';
                                            $transaction['Transaction']['amount'] = $amount_taken_from_wallet;
                                            $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::PartallyAmountTakenForDealPurchase;
                                            $this->Deal->User->Transaction->log($transaction);
                                        }
                                    }
                                    $last_inserted_id = $this->Deal->DealUser->getLastInsertId();
                                    $this->_dealPurchaseViaAuthorizeNet($this->data, $last_inserted_id);
                                } else {
                                    $this->Session->setFlash(__l('Payment failed. Please try again.') , 'default', array('lib' => __l('Error')), 'error');
                                    $this->redirect(array(
                                        'controller' => 'deals',
                                        'action' => 'index'
                                    ));
                                }
                            } else {
                                $this->Session->setFlash(sprintf(__l('Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.') , $response['message']) , 'default', array('lib' => __l('Error')), 'error');
                                $this->redirect(array(
                                    'controller' => 'deals',
                                    'action' => 'index'
                                ));
                            }
                        } else {
                            $this->Session->setFlash(__l('Credit card could not be updated. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
                            $this->redirect(array(
                                'controller' => 'deals',
                                'action' => 'index'
                            ));
                        }
                    } else if ($paymentGateway['PaymentGateway']['name'] == 'PagSeguro') {
                        Configure::write('PagSeguro.is_testmode', $paymentGateway['PaymentGateway']['is_test_mode']);
                        if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                            foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                                if ($paymentGatewaySetting['key'] == 'payee_account') {
                                    $email = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                                }
                                if ($paymentGatewaySetting['key'] == 'token') {
                                    $token = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                                }
                            }
                        }
                        //gateway options set
                        $ref = time();
                        $gateway_options['init'] = array(
                            'pagseguro' => array( // Array com informações pertinentes ao pagseguro
                                'email' => $email,
                                'token' => $token,
                                'type' => 'CBR', // Obrigatório passagem para pagseguro:tipo
                                'reference' => $ref, // Obrigatório passagem para pagseguro:ref_transacao
                                'freight_type' => 'EN', // Obrigatório passagem para pagseguro:tipo_frete
                                'theme' => 1, // Opcional Este parametro aceita valores de 1 a 5, seu efeito é a troca dos botões padrões do pagseguro
                                'currency' => 'BRL', // Obrigatório passagem para pagseguro:moeda,
                                'extra' => 0
                                // Um valor extra que você queira adicionar no valor total da venda, obs este valor pode ser negativo

                            ) ,
                            'definitions' => array( // Array com informações para manusei das informações
                                'currency_type' => 'dolar', // Especifica qual o tipo de separador de decimais, suportados (dolar, real)
                                'weight_type' => 'kg', // Especifica qual a medida utilizada para peso, suportados (kg, g)
                                'encode' => 'utf-8'
                                // Especifica o encode não implementado

                            ) ,
                            'format' => array(
                                'item_id' => '0000' . $deal['Deal']['id'],
                                'item_descr' => 'Bought Deal', //used to differ return array fron payment
                                'item_quant' => $this->data['Deal']['quantity'],
                                'item_valor' => $amount_needed,
                                'item_frete' => '0',
                                'item_peso' => '20',
                            ) ,
                        );
                        $transaction_data['TempPaymentLog'] = array(
                            'trans_id' => $ref,
                            'payment_type' => 'Buy deal',
                            'user_id' => $this->Auth->user('id') ,
                            'deal_id' => $this->data['Deal']['deal_id'],
                            'is_gift' => $this->data['Deal']['is_gift'],
                            'quantity' => $this->data['Deal']['quantity'],
                            'payment_gateway_id' => $this->data['Deal']['payment_gateway_id'],
                            'gift_to' => !empty($this->data['Deal']['gift_to']) ? $this->data['Deal']['gift_to'] : '',
                            'gift_from' => !empty($this->data['Deal']['gift_from']) ? $this->data['Deal']['gift_from'] : '',
                            'gift_email' => !empty($this->data['Deal']['gift_email']) ? $this->data['Deal']['gift_email'] : '',
                            'ip' => $this->RequestHandler->getClientIP() ,
                            'amount_needed' => $amount_needed,
                            'currency_code' => Configure::read('paypal.currency_code') ,
                            'message' => !empty($this->data['Deal']['message']) ? $this->data['Deal']['message'] : '',
                        );
                        $this->TempPaymentLog->save($transaction_data);
                        //	$this->Session->write('transaction_data',$transaction_data);
                        $this->set('gateway_options', $gateway_options);
                    }
                    $this->set('action', $action);
                    $this->set('amount', $amount_needed);
                    $this->set('deal', $deal);
                    $this->render('do_payment');
                }
            }
        }
    }
    function _dealPurchaseViaAuthorizeNet($data, $last_inserted_id)
    {
        if (!empty($data)) {
            $gateways = $this->Deal->User->Transaction->PaymentGateway->find('first', array(
                'conditions' => array(
                    'PaymentGateway.id' => ConstPaymentGateways::AuthorizeNet
                ) ,
                'recursive' => -1
            ));
            //Process for deals pay
            $deal_id = $data['Deal']['deal_id'];
            $deal = $this->Deal->find('first', array(
                'conditions' => array(
                    'Deal.id' => $data['Deal']['deal_id'],
                    'Deal.deal_status_id' => array(
                        ConstDealStatus::Open,
                        ConstDealStatus::Tipped
                    )
                ) ,
                'contain' => array(
                    'DealStatus' => array(
                        'fields' => array(
                            'DealStatus.name',
                        )
                    ) ,
                    'Company' => array(
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
                    )
                ) ,
                'recursive' => 2
            ));
            if (empty($deal)) {
                $this->cakeError('error404');
            } else {
                $deal_user['DealUser']['quantity'] = $data['Deal']['quantity'];
                if (!empty($data['Deal']['is_gift'])) {
                    $deal_user['DealUser']['gift_to'] = $data['Deal']['gift_to'];
                }
                $total_deal_amount = $data['Deal']['amount'];
                //in paypal process we will not get Auth
                $user = $this->Deal->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $this->Auth->user('id')
                    ) ,
                    'fields' => array(
                        'User.available_balance_amount',
                        'User.referred_by_user_id',
                        'User.username',
                        'User.email',
                        'User.created',
                        'User.id'
                    ) ,
                    'recursive' => -1
                ));
                $this->Deal->updateAll(array(
                    'Deal.deal_user_count' => 'Deal.deal_user_count +' . $data['Deal']['quantity'],
                ) , array(
                    'Deal.id' => $deal_id
                ));
                //update deal is on
                if ($deal['Deal']['deal_status_id'] == ConstDealStatus::Open) {
                    $db = $this->Deal->getDataSource();
                    $this->Deal->updateAll(array(
                        'Deal.deal_status_id' => ConstDealStatus::Tipped,
                        'Deal.deal_tipped_time' => '\'' . date('Y-m-d H:i:s') . '\''
                    ) , array(
                        'Deal.deal_status_id' => ConstDealStatus::Open,
                        'Deal.deal_user_count >=' => $db->expression('Deal.min_limit') ,
                        'Deal.id' => $deal_id
                    ));
                    $this->Deal->processDealStatus($deal_id, $last_inserted_id = null);
                } else {
                    //send coupon mail to users or close the deal
                    $this->Deal->processDealStatus($deal_id, $last_inserted_id);
                }
                //pay to referer
                $referred_by_user_id = $user['User']['referred_by_user_id'];
                if (Configure::read('user.is_referral_system_enabled') && !empty($referred_by_user_id)) {
                    $this->_pay_to_referrer($deal_id, $user['User']);
                }
                //deal on end
                $company_address = ($deal['Company']['address1']) ? $deal['Company']['address1'] : '';
                $company_address.= ($deal['Company']['address2']) ? ', ' . $deal['Company']['address2'] : '';
                $company_address.= !empty($deal['Company']['City']['name']) ? ', ' . $deal['Company']['City']['name'] : '';
                $company_address.= !empty($deal['Company']['State']['name']) ? ', ' . $deal['Company']['State']['name'] : '';
                $company_address.= !empty($deal['Company']['Country']['name']) ? ', ' . $deal['Company']['Country']['name'] : '';
                $company_address.= '.';
				$language_code = $this->Deal->getUserLanguageIso($this->Auth->user('id'));
				$email_message = $this->EmailTemplate->selectTemplate('Deal Bought', $language_code);
                $emailFindReplace = array(
                    '##FROM_EMAIL##' => $this->Deal->changeFromEmail(($email_message['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email_message['from']) ,
                    '##SITE_NAME##' => Configure::read('site.name') ,
                    '##USERNAME##' => $user['User']['username'],
                    '##DEAL_TITLE##' => $deal['Deal']['name'],
                    '##DEAL_AMOUNT##' => Configure::read('site.currency') . $total_deal_amount,
                    '##SITE_LINK##' => Router::url('/', true) ,
                    '##QUANTITY##' => $deal_user['DealUser']['quantity'],
                    '##PURCHASE_ON##' => strftime(Configure::read('site.datetime.format')) ,
                    '##DEAL_STATUS##' => $deal['DealStatus']['name'],
                    '##COMPANY_NAME##' => $deal['Company']['name'],
                    '##COMPANY_ADDRESS##' => ($company_address) ? $company_address : '',
                    '##CONTACT_URL##' => Router::url(array(
                        'controller' => 'contacts',
                        'action' => 'add',
                        'city' => $this->params['named']['city'],
                        'admin' => false
                    ) , true) ,
                    '##GIFT_RECEIVER##' => !empty($deal_user['DealUser']['gift_to']) ? $deal_user['DealUser']['gift_to'] : '',
                    '##SITE_LOGO##' => Router::url(array(
                        'controller' => 'img',
                        'action' => 'blue-theme',
                        'logo-email.png',
                        'admin' => false
                    ) , true) ,
                );
                $this->_sendMail($emailFindReplace, $email_message, $user['User']['email']);
                $this->Session->setFlash(__l('You have bought a deal sucessfully.') , 'default', array('lib' => __l('Success')), 'success');
                $get_updated_status = $this->Deal->find('first', array(
                    'conditions' => array(
                        'Deal.id' => $deal_id
                    ) ,
                    'recursive' => -1
                ));
                if ($this->RequestHandler->prefers('json')) {
                    $resonse = array(
                        'status' => 0,
                        'message' => __l('Success')
                    );
                    $this->view = 'Json';
                    $this->set('json', (empty($this->viewVars['iphone_response'])) ? $resonse : $this->viewVars['iphone_response']);
                } else {
                    if (Configure::read('Deal.invite_after_deal_add') && $get_updated_status['Deal']['deal_status_id'] != ConstDealStatus::Closed) {
                        $this->redirect(array(
                            'controller' => 'user_friends',
                            'action' => 'deal_invite',
                            'type' => 'deal',
                            'deal' => $deal['Deal']['slug']
                        ));
                    } else {
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'my_stuff#My_Purchases'
                        ));
                    }
                }
            }
        } else {
            $this->Session->setFlash(__l('Payment failed.Please try again.') , 'default', array('lib' => __l('Error')), 'error');
            $this->redirect(array(
                'controller' => 'deals',
                'action' => 'index'
            ));
        }
    }
    //send welcome mail for new user
    function _sendWelcomeMail($user_id, $user_email, $username)
    {
        $email = $this->EmailTemplate->selectTemplate('Welcome Email');
        $emailFindReplace = array(
            '##FROM_EMAIL##' => $this->Deal->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
            '##SITE_LINK##' => Router::url('/', true) ,
            '##SITE_NAME##' => Configure::read('site.name') ,
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
    function processpayment($gateway_name, $return_details = null)
    {
        //paypal ipn
        $return_details = $_REQUEST;
        $gateway = array(
            'paypal' => ConstPaymentGateways::PayPalAuth,
            'pagseguro' => ConstPaymentGateways::PagSeguro
        );
        //$gateway['paypal'] = ConstPaymentGateways::PayPalAuth;
        $gateway_id = (!empty($gateway[$gateway_name])) ? $gateway[$gateway_name] : 0;
        $paymentGateway = $this->Deal->User->Transaction->PaymentGateway->find('first', array(
            'conditions' => array(
                'PaymentGateway.id' => $gateway_id
            ) ,
            'contain' => array(
                'PaymentGatewaySetting' => array(
                    'fields' => array(
                        'PaymentGatewaySetting.key',
                        'PaymentGatewaySetting.test_mode_value',
                        'PaymentGatewaySetting.live_mode_value',
                    )
                )
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
                $allow_to_process = 0;
                $deal_id = $this->Paypal->paypal_post_arr['deal_id'];
                $quantity = $this->Paypal->paypal_post_arr['quantity'];
                $paid_amount = $this->Paypal->paypal_post_arr['mc_gross'];
                $payer_user_id = $this->Paypal->paypal_post_arr['user_id'];
                $is_purchase_with_wallet_amount = $this->Paypal->paypal_post_arr['is_purchase_with_wallet_amount'];
                $get_deal = $this->Deal->find('first', array(
                    'conditions' => array(
                        'Deal.id' => $deal_id
                    ) ,
                    'recursive' => -1
                ));
                $get_user = $this->Deal->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $payer_user_id
                    ) ,
                    'recursive' => -1
                ));
                $payment_gateway_id = !empty($this->Paypal->paypal_post_arr['auth_id']) ? $this->Paypal->paypal_post_arr['payment_gateway_id'] : ConstPaymentGateways::Wallet;
                if ($payment_gateway_id == ConstPaymentGateways::Wallet) {
                    if ((($get_deal['Deal']['discounted_price']*$quantity) -$get_user['User']['available_balance_amount']) == ($paid_amount)) {
                        $allow_to_process = 1;
                    }
                } elseif ($payment_gateway_id == ConstPaymentGateways::PayPalAuth) {
                    if (($get_deal['Deal']['discounted_price']*$quantity) == $paid_amount) {
                        $allow_to_process = 1;
                    } elseif (!empty($is_purchase_with_wallet_amount)) {
                        $allow_to_process = 1;
                    }
                } elseif ($payment_gateway_id == ConstPaymentGateways::CreditCard) {
                    $allow_to_process = 1;
                }
                if (!empty($get_deal) && !empty($allow_to_process)) {
                    $this->Paypal->amount_for_item = $this->Paypal->paypal_post_arr['amount_needed'];
                    if ($this->Paypal->process() || (!empty($this->Paypal->paypal_post_arr['auth_id']))) {
                        //for normal payment through wallet
                        if ($this->Paypal->paypal_post_arr['payment_status'] == 'Completed' && empty($this->Paypal->paypal_post_arr['auth_id'])) {
                            $id = $this->Paypal->paypal_post_arr['user_id'];
                            //add amount to wallet for normal paypal
                            $data['Transaction']['user_id'] = $id;
                            $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                            $data['Transaction']['class'] = 'SecondUser';
                            $data['Transaction']['amount'] = $this->Paypal->paypal_post_arr['mc_gross'];
                            $data['Transaction']['payment_gateway_id'] = $paymentGateway['PaymentGateway']['id'];
                            $data['Transaction']['gateway_fees'] = $this->Paypal->paypal_post_arr['mc_fee'];
                            $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
                            $transaction_id = $this->Deal->User->Transaction->log($data);
                            if (!empty($transaction_id)) {
                                $this->Paypal->paypal_post_arr['transaction_id'] = $transaction_id;
                                $this->Deal->User->updateAll(array(
                                    'User.available_balance_amount' => 'User.available_balance_amount +' . $this->Paypal->paypal_post_arr['mc_gross'],
                                ) , array(
                                    'User.id' => $id
                                ));
                            }
                            //buy deal
                            $deal_data['Deal']['deal_id'] = $deal_id;
                            $deal_data['Deal']['quantity'] = $this->Paypal->paypal_post_arr['quantity'];
                            $deal_data['Deal']['is_gift'] = $this->Paypal->paypal_post_arr['is_gift'];
                            $deal_data['Deal']['gift_to'] = $this->Paypal->paypal_post_arr['gift_to'];
                            $deal_data['Deal']['gift_from'] = $this->Paypal->paypal_post_arr['gift_from'];
                            $deal_data['Deal']['gift_email'] = $this->Paypal->paypal_post_arr['gift_email'];
                            $deal_data['Deal']['message'] = $this->Paypal->paypal_post_arr['message'];
                            $deal_data['Deal']['user_id'] = $this->Paypal->paypal_post_arr['user_id'];
                            $deal_data['Deal']['payment_gateway_id'] = !empty($this->Paypal->paypal_post_arr['auth_id']) ? $this->Paypal->paypal_post_arr['payment_gateway_id'] : ConstPaymentGateways::Wallet;
                            $paypal_transaction_log_id = $this->Paypal->logPaypalTransactions();
                            $deal_data['Deal']['paypal_transaction_log_id'] = $paypal_transaction_log_id;
                            $deal_data['Deal']['is_process_payment'] = 1;
                            $this->_buyDeal($deal_data);
                        } else if ($this->Paypal->paypal_post_arr['payment_status'] == 'Pending' && !empty($this->Paypal->paypal_post_arr['auth_id']) && $this->Paypal->paypal_post_arr['pending_reason'] == 'authorization') {
                            //for paypal auth first time
                            //buy deal
                            $deal_data['Deal']['deal_id'] = $deal_id;
                            $deal_data['Deal']['quantity'] = $this->Paypal->paypal_post_arr['quantity'];
                            $deal_data['Deal']['is_gift'] = $this->Paypal->paypal_post_arr['is_gift'];
                            $deal_data['Deal']['gift_to'] = $this->Paypal->paypal_post_arr['gift_to'];
                            $deal_data['Deal']['gift_from'] = $this->Paypal->paypal_post_arr['gift_from'];
                            $deal_data['Deal']['gift_email'] = $this->Paypal->paypal_post_arr['gift_email'];
                            $deal_data['Deal']['message'] = $this->Paypal->paypal_post_arr['message'];
                            $deal_data['Deal']['user_id'] = $this->Paypal->paypal_post_arr['user_id'];
                            $deal_data['Deal']['payment_gateway_id'] = $this->Paypal->paypal_post_arr['payment_gateway_id'];
                            $paypal_transaction_log_id = $this->Paypal->logPaypalTransactions();
                            $deal_data['Deal']['is_purchase_with_wallet_amount'] = $this->Paypal->paypal_post_arr['is_purchase_with_wallet_amount'];
                            $deal_data['Deal']['paypal_transaction_log_id'] = $paypal_transaction_log_id;
                            $deal_data['Deal']['is_process_payment'] = 1;
                            $this->_buyDeal($deal_data);
                        } else if (!empty($this->Paypal->paypal_post_arr['auth_id'])) {
                            //for paypal auth second time ipn
                            exit;
                        }
                    }
                }
                $this->Paypal->logPaypalTransactions();
                break;

            case 'pagseguro':
                if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                    foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                        if ($paymentGatewaySetting['key'] == 'payee_account') {
                            $email = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                        }
                        if ($paymentGatewaySetting['key'] == 'token') {
                            $token = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                        }
                    }
                }
                $post_array = $_POST;
                if (!empty($post_array) && $post_array['Referencia']) {
                    $temp_ary = $this->TempPaymentLog->find('first', array(
                        'conditions' => array(
                            'TempPaymentLog.trans_id' => $post_array['Referencia']
                        )
                    ));
                    $transaction_data = $temp_ary['TempPaymentLog'];
                } else {
                    $this->Session->setFlash(__l('Error in payment.') , 'default', array('lib' => __l('Error')), 'error');
                    $this->redirect(array(
                        'controller' => 'transactions',
                        'action' => 'index',
                        'admin' => false
                    ));
                }
                $this->PagSeguro->init(array(
                    'pagseguro' => array(
                        'email' => $email,
                        'token' => $token,
                    ) ,
                    'format' => array(
                        'item_id' => $transaction_data['deal_id'],
                        'item_descr' => 'Bought Deal',
                        'item_quant' => $transaction_data['quantity'],
                        'item_valor' => $transaction_data['amount_needed'],
                    )
                ));
                if (empty($transaction_data['deal_id'])) {
                    $this->redirect(array(
                        'controller' => 'transactions',
                        'action' => 'index',
                        'admin' => false
                    ));
                }
                $allow_to_process = 1;
                $verified = 0;
                $pagseguro_data = $return_details;
                $verificado = $this->PagSeguro->confirm();
                if ($verificado == 'VERIFICADO') {
                    $verified = 1;
                    $result = $this->PagSeguro->getDataPayment();
                    $log_data = array_merge($pagseguro_data, $transaction_data);
                    $pagseguro_transaction_log_id = $this->Deal->DealUser->PagseguroTransactionLog->logPagSeguroTransactions($log_data);
                } elseif ($verificado == 'FALSO') {
                    $verified = 0;
                    $log_data = array_merge($pagseguro_data, $transaction_data);
                    $pagseguro_transaction_log_id = $this->Deal->DealUser->PagseguroTransactionLog->logPagSeguroTransactions($log_data);
                }
                if ($transaction_data['payment_type'] == 'Buy deal') {
                    $this->log($return_details);
                    $deal_id = $transaction_data['deal_id'];
                    $quantity = $transaction_data['quantity'];
                    $paid_amount = $transaction_data['amount_needed'];
                    $payer_user_id = $transaction_data['user_id'];
                    $get_deal = $this->Deal->find('first', array(
                        'conditions' => array(
                            'Deal.id' => $deal_id
                        ) ,
                        'recursive' => -1
                    ));
                    $get_user = $this->Deal->User->find('first', array(
                        'conditions' => array(
                            'User.id' => $payer_user_id
                        ) ,
                        'recursive' => -1
                    ));
                    if (!empty($get_deal) && !empty($allow_to_process)) {
                        if (!empty($verified)) {
                            $id = $transaction_data['user_id'];
                            //add amount to wallet for normal paypal
                            $data['Transaction']['user_id'] = $id;
                            $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                            $data['Transaction']['class'] = 'SecondUser';
                            $data['Transaction']['amount'] = $paid_amount;
                            $data['Transaction']['payment_gateway_id'] = $paymentGateway['PaymentGateway']['id'];
                            $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
                            $transaction_id = $this->Deal->User->Transaction->log($data);
                            if (!empty($transaction_id)) {
                                $transaction_id = $transaction_id;
                                $this->Deal->User->updateAll(array(
                                    'User.available_balance_amount' => 'User.available_balance_amount +' . $paid_amount,
                                ) , array(
                                    'User.id' => $id
                                ));
                            }
                            //buy deal
                            $deal_data['Deal']['deal_id'] = $deal_id;
                            $deal_data['Deal']['quantity'] = $transaction_data['quantity'];
                            $deal_data['Deal']['is_gift'] = $transaction_data['is_gift'];
                            $deal_data['Deal']['gift_to'] = $transaction_data['gift_to'];
                            $deal_data['Deal']['gift_from'] = $transaction_data['gift_from'];
                            $deal_data['Deal']['gift_email'] = $transaction_data['gift_email'];
                            $deal_data['Deal']['message'] = $transaction_data['message'];
                            $deal_data['Deal']['user_id'] = $transaction_data['user_id'];
                            $deal_data['Deal']['payment_gateway_id'] = ConstPaymentGateways::PagSeguro;
                            $deal_data['Deal']['pagseguro_transaction_log_id'] = $pagseguro_transaction_log_id;
                            $deal_data['Deal']['is_process_payment'] = 1;
                            $this->TempPaymentLog->del($transaction_data['id']);
                            $this->_buyDeal($deal_data);
                        } else {
                            //buy deal
                            $deal_data['Deal']['deal_id'] = $deal_id;
                            $deal_data['Deal']['quantity'] = $transaction_data['quantity'];
                            $deal_data['Deal']['is_gift'] = $transaction_data['is_gift'];
                            $deal_data['Deal']['gift_to'] = $transaction_data['gift_to'];
                            $deal_data['Deal']['gift_from'] = $transaction_data['gift_from'];
                            $deal_data['Deal']['gift_email'] = $transaction_data['gift_email'];
                            $deal_data['Deal']['message'] = $transaction_data['message'];
                            $deal_data['Deal']['user_id'] = $transaction_data['user_id'];
                            $deal_data['Deal']['payment_gateway_id'] = ConstPaymentGateways::PagSeguro;
                            $deal_data['Deal']['pagseguro_transaction_log_id'] = $pagseguro_transaction_log_id;
                            $deal_data['Deal']['is_process_payment'] = 1;
                            $this->_buyDeal($deal_data);
                        }
                    }
                } else if ($transaction_data['payment_type'] == 'wallet' && $verified) {
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'processpayment',
                        'pagseguro',
                        'order' => $transaction_data['trans_id'],
                        'admin' => false
                    ));
                } elseif ($transaction_data['payment_type'] == 'gift card' && $verified) {
                    $this->redirect(array(
                        'controller' => 'gift_users',
                        'action' => 'processpayment',
                        'pagseguro',
                        'order' => $transaction_data['trans_id'],
                        'admin' => false
                    ));
                } else {
                    $this->Session->setFlash(__l('Error in payment.') , 'default', array('lib' => __l('Error')), 'error');
                    $this->redirect(array(
                        'controller' => 'transactions',
                        'action' => 'index',
                        'admin' => false
                    ));
                }
                break;

            default:
                $this->cakeError('error404');
            } // switch
            $this->autoRender = false;
        }
        //before login deal buy process
        function _buyDeal($data)
        {
            $is_purchase_with_wallet_amount = 0; // Used for 'handle with wallet like groupon //
            $deal_id = $data['Deal']['deal_id'];
            $deal = $this->Deal->find('first', array(
                'conditions' => array(
                    'Deal.id' => $data['Deal']['deal_id'],
                    'Deal.deal_status_id' => array(
                        ConstDealStatus::Open,
                        ConstDealStatus::Tipped
                    )
                ) ,
                'contain' => array(
                    'DealStatus' => array(
                        'fields' => array(
                            'DealStatus.name',
                        )
                    ) ,
                    'Company' => array(
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
                        )
                    )
                ) ,
                'recursive' => 2
            ));
            if (empty($deal)) {
                $this->cakeError('error404');
            } else {
                $total_deal_amount = $deal['Deal']['discounted_price']*$data['Deal']['quantity'];
                //in paypal process we will not get Auth
                $user = $this->Deal->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $data['Deal']['user_id']
                    ) ,
                    'fields' => array(
                        'User.available_balance_amount',
                        'User.referred_by_user_id',
                        'User.username',
                        'User.created',
                        'User.email',
                        'User.id'
                    ) ,
                    'recursive' => -1
                ));
                $paymentGateway = $this->Deal->User->Transaction->PaymentGateway->find('first', array(
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
                //deal user table record add
                $deal_user['DealUser']['quantity'] = $data['Deal']['quantity'];
                $deal_user['DealUser']['deal_id'] = $data['Deal']['deal_id'];
                $deal_user['DealUser']['is_gift'] = $data['Deal']['is_gift'];
                $deal_user['DealUser']['user_id'] = $data['Deal']['user_id'];
                $deal_user['DealUser']['discount_amount'] = $total_deal_amount;
                $deal_user['DealUser']['payment_gateway_id'] = !empty($data['Deal']['payment_gateway_id']) ? $data['Deal']['payment_gateway_id'] : ConstPaymentGateways::Wallet;
                //    $coupon_code = $this->_uuid();
                //    $deal_user['DealUser']['coupon_code'] = $coupon_code;
                if ($data['Deal']['is_gift']) {
                    $deal_user['DealUser']['gift_email'] = $data['Deal']['gift_email'];
                    $deal_user['DealUser']['message'] = $data['Deal']['message'];
                    $deal_user['DealUser']['gift_to'] = $data['Deal']['gift_to'];
                    $deal_user['DealUser']['gift_from'] = $data['Deal']['gift_from'];
                }
                //for credit card and paypal auth it should be 0
                if (($data['Deal']['payment_gateway_id'] == ConstPaymentGateways::CreditCard) || ($data['Deal']['payment_gateway_id'] == ConstPaymentGateways::PayPalAuth)) {
                    $deal_user['DealUser']['is_paid'] = 0;
                }
                $this->Deal->DealUser->create();
                $this->Deal->DealUser->set($deal_user);
                //for credit card doDirectPayment function call in paypal component
                if ($data['Deal']['payment_gateway_id'] == ConstPaymentGateways::CreditCard) {
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
                    // If enabled, purchase amount is first taken with amount in wallet and then passed to CreditCard //
                    if (Configure::read('wallet.is_handle_wallet_as_in_groupon')) {
                        $user_available_balance = $this->Deal->User->checkUserBalance($this->Auth->user('id'));
                        $total_deal_amount = $total_deal_amount-$user_available_balance;
                        $is_purchase_with_wallet_amount = 1;
                    }
                    $sender_info['is_testmode'] = $paymentGateway['PaymentGateway']['is_test_mode'];
                    $data_credit_card['firstName'] = $data['Deal']['firstName'];
                    $data_credit_card['lastName'] = $data['Deal']['lastName'];
                    $data_credit_card['creditCardType'] = $data['Deal']['creditCardType'];
                    $data_credit_card['creditCardNumber'] = $data['Deal']['creditCardNumber'];
                    $data_credit_card['expDateMonth'] = $data['Deal']['expDateMonth'];
                    $data_credit_card['expDateYear'] = $data['Deal']['expDateYear'];
                    $data_credit_card['cvv2Number'] = $data['Deal']['cvv2Number'];
                    $data_credit_card['address'] = $data['Deal']['address'];
                    $data_credit_card['city'] = $data['Deal']['city'];
                    $data_credit_card['state'] = $data['Deal']['state'];
                    $data_credit_card['zip'] = $data['Deal']['zip'];
                    $data_credit_card['country'] = $data['Deal']['country'];
                    $data_credit_card['paymentType'] = 'Authorization';
                    $data_credit_card['amount'] = $total_deal_amount;
                    //calling doDirectPayment fn in paypal component
                    $payment_response = $this->Paypal->doDirectPayment($data_credit_card, $sender_info);
                    //if not success show error msg as it received from paypal
                    if (!empty($payment_response) && $payment_response['ACK'] != 'Success') {
                        $this->Session->setFlash(sprintf(__l('%s') , $payment_response['L_LONGMESSAGE0']) , 'default', array('lib' => __l('Error')), 'error');
                        return;
                    }
                }
                //save deal user record
                if ($this->Deal->DealUser->save($deal_user)) {
                    $last_inserted_id = $this->Deal->DealUser->getLastInsertId();
                    // Multiple coupon - Saving //
                    $deal_user_coupons = array();
                    $coupon_code = $this->_uuid();
                    for ($i = 1; $i <= $deal_user['DealUser']['quantity']; $i++) {
                        $deal_user_coupons['id'] = '';
                        $deal_user_coupons['deal_user_id'] = $last_inserted_id;
                        $deal_user_coupons['coupon_code'] = $coupon_code . '-' . $i;
                        $deal_user_coupons['unique_coupon_code'] = $this->_unum();
                        $this->Deal->DealUser->DealUserCoupon->save($deal_user_coupons);
                    }
                    if ($this->data['Deal']['payment_gateway_id'] == ConstPaymentGateways::CreditCard && !empty($payment_response)) {
                        $data_paypal_docapture_log['PaypalDocaptureLog']['authorizationid'] = $payment_response['TRANSACTIONID'];
                        $data_paypal_docapture_log['PaypalDocaptureLog']['deal_user_id'] = $last_inserted_id;
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
                        $this->Deal->DealUser->PaypalDocaptureLog->save($data_paypal_docapture_log);
                    } else if ($data['Deal']['payment_gateway_id'] == ConstPaymentGateways::PayPalAuth) {
                        $is_purchase_with_wallet_amount = $data['Deal']['is_purchase_with_wallet_amount'];
                        //update deal user id in PaypalTransactionLog table
                        $this->Deal->DealUser->PaypalTransactionLog->updateAll(array(
                            'PaypalTransactionLog.deal_user_id' => $last_inserted_id
                        ) , array(
                            'PaypalTransactionLog.id' => $data['Deal']['paypal_transaction_log_id']
                        ));
                    } else {
                        if ($data['Deal']['payment_gateway_id'] == ConstPaymentGateways::PagSeguro) {
                            //update deal user id in PaypalTransactionLog table
                            $this->Deal->DealUser->PagseguroTransactionLog->updateAll(array(
                                'PagseguroTransactionLog.deal_user_id' => $last_inserted_id
                            ) , array(
                                'PagseguroTransactionLog.id' => $data['Deal']['pagseguro_transaction_log_id']
                            ));
                        }
                        //buy deal through wallet
                        $transaction['Transaction']['user_id'] = $deal_user['DealUser']['user_id'];
                        $transaction['Transaction']['foreign_id'] = $last_inserted_id;
                        $transaction['Transaction']['class'] = 'DealUser';
                        $transaction['Transaction']['amount'] = $total_deal_amount;
                        $transaction['Transaction']['transaction_type_id'] = (!empty($data['Deal']['is_gift'])) ? ConstTransactionTypes::DealGift : ConstTransactionTypes::BuyDeal;
                        $this->Deal->User->Transaction->log($transaction);
                        //user update
                        $this->Deal->User->updateAll(array(
                            'User.available_balance_amount' => 'User.available_balance_amount -' . $total_deal_amount,
                        ) , array(
                            'User.id' => $deal_user['DealUser']['user_id']
                        ));
                    }
                    // If enabled, and after purchase, deduct partial amount from wallet //
                    if (Configure::read('wallet.is_handle_wallet_as_in_groupon') && (!empty($is_purchase_with_wallet_amount))) {
                        // Deduct amount ( zero will be updated ) //
                        $user_available_balance = $this->Deal->User->checkUserBalance($deal_user['DealUser']['user_id']);
                        $this->Deal->User->updateAll(array(
                            'User.available_balance_amount' => 'User.available_balance_amount -' . $user_available_balance,
                        ) , array(
                            'User.id' => $deal_user['DealUser']['user_id']
                        ));
                        // Update transaction, This is firs transaction, to notify user that partial amount taken from wallet. Second transaction will be updated after deal gets tipped.//
                        if (!empty($user_available_balance) && $user_available_balance != '0.00') {
                            $transaction['Transaction']['user_id'] = $deal_user['DealUser']['user_id'];
                            $transaction['Transaction']['foreign_id'] = $last_inserted_id;
                            $transaction['Transaction']['class'] = 'DealUser';
                            $transaction['Transaction']['amount'] = $user_available_balance;
                            $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::PartallyAmountTakenForDealPurchase;
                            $this->Deal->User->Transaction->log($transaction);
                        }
                    }
                    //increasing deal_user_count
                    $this->Deal->updateAll(array(
                        'Deal.deal_user_count' => 'Deal.deal_user_count +' . $data['Deal']['quantity'],
                    ) , array(
                        'Deal.id' => $deal_id
                    ));
                    //update deal is on
                    if ($deal['Deal']['deal_status_id'] == ConstDealStatus::Open) {
                        $db = $this->Deal->getDataSource();
                        $this->Deal->updateAll(array(
                            'Deal.deal_status_id' => ConstDealStatus::Tipped,
                            'Deal.deal_tipped_time' => '\'' . date('Y-m-d H:i:s') . '\''
                        ) , array(
                            'Deal.deal_status_id' => ConstDealStatus::Open,
                            'Deal.deal_user_count >=' => $db->expression('Deal.min_limit') ,
                            'Deal.id' => $deal_id
                        ));
                    }
                    //send coupon mail to users or close the deal
                    $this->Deal->processDealStatus($deal_id, $last_inserted_id);
                    //pay to referer
                    $referred_by_user_id = $user['User']['referred_by_user_id'];
                    //pay referral amount of referred users
                    if (Configure::read('user.is_referral_system_enabled') && !empty($referred_by_user_id)) {
                        $this->_pay_to_referrer($deal_id, $user['User']);
                    }
                    //deal on end
                    $company_address = ($deal['Company']['address1']) ? $deal['Company']['address1'] : '';
                    $company_address.= ($deal['Company']['address2']) ? ', ' . $deal['Company']['address2'] : '';
                    $company_address.= !empty($deal['Company']['City']['name']) ? ', ' . $deal['Company']['City']['name'] : '';
                    $company_address.= !empty($deal['Company']['State']['name']) ? ', ' . $deal['Company']['State']['name'] : '';
                    $company_address.= !empty($deal['Company']['Country']['name']) ? ', ' . $deal['Company']['Country']['name'] : '';
                    $company_address.= '.';
					$language_code = $this->Deal->getUserLanguageIso($deal_user['DealUser']['user_id']);
					$email_message = $this->EmailTemplate->selectTemplate('Deal Bought', $language_code);
                    $emailFindReplace = array(
                        '##FROM_EMAIL##' => $this->Deal->changeFromEmail(($email_message['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email_message['from']) ,
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##USERNAME##' => $user['User']['username'],
                        '##DEAL_TITLE##' => $deal['Deal']['name'],
                        '##DEAL_AMOUNT##' => Configure::read('site.currency') . $total_deal_amount,
                        '##SITE_LINK##' => Router::url('/', true) ,
                        '##QUANTITY##' => $deal_user['DealUser']['quantity'],
                        '##PURCHASE_ON##' => strftime(Configure::read('site.datetime.format')) ,
                        '##DEAL_STATUS##' => $deal['DealStatus']['name'],
                        '##COMPANY_NAME##' => $deal['Company']['name'],
                        '##COMPANY_ADDRESS##' => ($company_address) ? $company_address : '',
                        '##CONTACT_URL##' => Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add',
                            'city' => $this->params['named']['city'],
                            'admin' => false
                        ) , true) ,
                        '##GIFT_RECEIVER##' => !empty($deal_user['DealUser']['gift_to']) ? $deal_user['DealUser']['gift_to'] : '',
                        '##SITE_LOGO##' => Router::url(array(
                            'controller' => 'img',
                            'action' => 'blue-theme',
                            'logo-email.png',
                            'admin' => false
                        ) , true) ,
                    );
                    $this->_sendMail($emailFindReplace, $email_message, $user['User']['email']);
                    if (!empty($data['Deal']['is_gift'])) { // Deal gift mail
                        $emailFindReplace['##USERNAME##'] = $deal_user['DealUser']['gift_to'];
                        $emailFindReplace['##FRIEND_NAME##'] = $deal_user['DealUser']['gift_from'];
						$language_code = $this->Deal->getUserLanguageIso($deal_user['DealUser']['user_id']);
						$email_message = $this->EmailTemplate->selectTemplate('Deal gift mail', $language_code);
                        $this->_sendMail($emailFindReplace, $email_message, $deal_user['DealUser']['gift_email']);
                    }
                    $this->Session->setFlash(__l('You have bought a deal successfully.') , 'default', array('lib' => __l('Success')), 'success');
                    $get_updated_status = $this->Deal->find('first', array(
                        'conditions' => array(
                            'Deal.id' => $deal_id
                        ) ,
                        'recursive' => -1
                    ));
                    if (empty($data['Deal']['is_process_payment'])) {
                        if (Configure::read('Deal.invite_after_deal_add') && $get_updated_status['Deal']['deal_status_id'] != ConstDealStatus::Closed) {
                            $this->redirect(array(
                                'controller' => 'user_friends',
                                'action' => 'deal_invite',
                                'type' => 'deal',
                                'deal' => $deal['Deal']['slug']
                            ));
                        } else {
                            $this->redirect(array(
                                'controller' => 'users',
                                'action' => 'my_stuff#My_Purchases'
                            ));
                        }
                    }
                } else {
                    if (empty($data['Deal']['is_process_payment'])) {
                        $this->Session->setFlash(__l('You can\'t buy this deal.') , 'default', array('lib' => __l('Error')), 'error');
                        $this->redirect(array(
                            'controller' => 'deals',
                            'action' => 'index'
                        ));
                    }
                }
            }
        }
        //pay referal amount to user when the new user buy his first deal
        function _pay_to_referrer($deal_id, $deal_buyer_data)
        {
            $dealUserCount = $this->Deal->DealUser->find('count', array(
                'conditions' => array(
                    'DealUser.user_id' => $deal_buyer_data['id']
                ) ,
                'recursive' => -1
            ));
            $today = strtotime(date('Y-m-d H:i:s'));
            $registered_date = strtotime(_formatDate('Y-m-d H:i:s', strtotime($deal_buyer_data['created'])));
            $hours_diff = intval(($today-$registered_date) /60/60);
            //check whether this is user's first deal and bought with in correct limit
            if (($dealUserCount == 1) && $hours_diff <= Configure::read('user.referral_deal_buy_time')) {
                //pay amount to referred user
                $transaction['Transaction']['user_id'] = $deal_buyer_data['referred_by_user_id'];
                $transaction['Transaction']['foreign_id'] = ConstUserIds::Admin;
                $transaction['Transaction']['class'] = 'SecondUser';
                $transaction['Transaction']['amount'] = Configure::read('user.referral_amount');
                $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::ReferralAmount;
                $this->Deal->User->Transaction->log($transaction);
                $transaction = array();
                //admin record for referral amount
                $transaction['Transaction']['user_id'] = ConstUserIds::Admin;
                $transaction['Transaction']['foreign_id'] = $deal_buyer_data['referred_by_user_id'];
                $transaction['Transaction']['class'] = 'SecondUser';
                $transaction['Transaction']['amount'] = Configure::read('user.referral_amount');
                $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::ReferralAmountPaid;
                $this->Deal->User->Transaction->log($transaction);
                $this->Deal->User->updateAll(array(
                    'User.available_balance_amount' => 'User.available_balance_amount +' . Configure::read('user.referral_amount')
                ) , array(
                    'User.id' => $deal_buyer_data['referred_by_user_id']
                ));
            }
        }
        function _sendMail($email_content_array, $template, $to, $sendAs = 'text')
        {
            $this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $template['from'];
            $this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $template['reply_to'];
            $this->Email->to = $to;
            $this->Email->subject = strtr($template['subject'], $email_content_array);
            $this->Email->content = strtr($template['email_content'], $email_content_array);
            $this->Email->sendAs = ($template['is_html']) ? 'html' : 'text';
            $this->Email->send($this->Email->content);
        }
        //commission calcualtor
        function commission_calculator()
        {
            $this->pageTitle = __l('Commission Calculator');
            if (!empty($this->data)) {
                if (!empty($this->data['Deal']['calculator_discounted_price']) && !empty($this->data['Deal']['calculator_min_limit']) && !empty($this->data['Deal']['calculator_commission_percentage']) && !empty($this->data['Deal']['calculator_bonus_amount'])) {
                    $this->data['Deal']['calculator_total_purchased_amount'] = $this->data['Deal']['calculator_discounted_price']*$this->data['Deal']['calculator_min_limit'];
                    $this->data['Deal']['calculator_total_commission_amount'] = ($this->data['Deal']['calculator_total_purchased_amount']*($this->data['Deal']['calculator_commission_percentage']/100)) +$this->data['Deal']['calculator_bonus_amount'];
                    $this->data['Deal']['net_profit'] = $this->data['Deal']['calculator_total_commission_amount'];
                    $this->Session->setFlash(__l('Deal commission amount calculated successfully.') , 'default', array('lib' => __l('Success')), 'success');
                } else {
                    $this->Session->setFlash(__l('Please enter all the values.') , 'default', array('lib' => __l('Error')), 'error');
                }
            } else {
                $this->data['Deal']['calculator_total_purchased_amount'] = $this->data['Deal']['calculator_total_commission_amount'] = $this->data['Deal']['calculator_net_profit'] = 0;
            }
        }
        function payment_success($gateway_id, $deal_id = null)
        {
            $this->pageTitle = __l('Payment Success');
            $pay_pal_repsonse = $_POST;
            $deal_slug = $this->Session->read('Auth.last_bought_deal_slug');
            $this->Session->del('Auth.last_bought_deal_slug');
            if (!is_null($deal_id)) {
                $deal = $this->Deal->find('first', array(
                    'conditions' => array(
                        'Deal.id' => $deal_id
                    ) ,
                    'fields' => array(
                        'Deal.slug'
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($deal)) {
                    $deal_slug = $deal['Deal']['slug'];
                }
            }
            if (!empty($pay_pal_repsonse['auth_status'])) {
                $this->Session->write('Message.TransactionSuccessMessage', __l('Your payment has been successfully finished. We will update this transactions after deal has been tipped.'));
                $this->Session->setFlash(__l('Your payment has been successfully finished. We will update this transactions after deal has been tipped.') , 'default', array('lib' => __l('Success')), 'success');
                $get_updated_status = $this->Deal->find('first', array(
                    'conditions' => array(
                        'Deal.id' => $deal_id
                    ) ,
                    'recursive' => -1
                ));
                if (Configure::read('Deal.invite_after_deal_add') && $get_updated_status['Deal']['deal_status_id'] != ConstDealStatus::Closed) {
                    $this->redirect(array(
                        'controller' => 'user_friends',
                        'action' => 'deal_invite',
                        'type' => 'deal',
                        'deal' => $deal_slug
                    ));
                } else {
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'my_stuff#My_Purchases'
                    ));
                }
            }
            $this->Session->write('Message.TransactionSuccessMessage', __l('Your payment has been successfully finished. We will update this transactions page after receiving the confirmation from PayPal'));
            $this->Session->setFlash(__l('Your payment has been successfully finished. We will update this transactions page after receiving the confirmation from PayPal') , 'default', array('lib' => __l('Success')), 'success');
            if (Configure::read('Deal.invite_after_deal_add') && $get_updated_status['Deal']['deal_status_id'] != ConstDealStatus::Closed) {
                $this->redirect(array(
                    'controller' => 'user_friends',
                    'action' => 'deal_invite',
                    'type' => 'deal',
                    'deal' => $deal_slug
                ));
            } else {
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'my_stuff#My_Purchases'
                ));
            }
        }
        function payment_cancel()
        {
            $this->pageTitle = __l('Payment Cancel');
            $this->Session->setFlash(__l('Transaction failure. Please try once again.') , 'default', array('lib' => __l('Error')), 'error');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'my_stuff',
                '#My_Transactions'
            ));
        }
        function admin_update_bitlyurl()
        {
            $deals = $this->Deal->find('all', array(
                'contain' => array(
                    'City',
                ) ,
                'recursive' => 2
            ));
            foreach($deals as $deal) $this->Deal->_updateDealBitlyURL($deal['Deal']['slug'], $deal['City']['slug']);
            $this->Session->setFlash(__l('Bitly URL has been successfully updated for all the deals in the site') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index',
            ));
        }
        //generate barcode
        function barcode($barcode = null)
        {
            $this->autoRender = false;
            define(__TRACE_ENABLED__, false);
            define(__DEBUG_ENABLED__, false);
            include_once (APP . DS . 'vendors' . DS . 'barcode' . DS . 'barcode.php');
            include_once (APP . DS . 'vendors' . DS . 'barcode' . DS . Configure::read('barcode.symbology') . 'object.php');
            $output = "png";
            $width = Configure::read('barcode.width');
            $height = Configure::read('barcode.height');
            $xres = "2";
            $font = "5";
            $type = Configure::read('barcode.symbology');
            if (!empty($barcode)) {
                $style = BCS_ALIGN_CENTER;
                $style|= ($output == "png") ? BCS_IMAGE_PNG : 0;
                $style|= ($output == "jpeg") ? BCS_IMAGE_JPEG : 0;
                $style|= ($border == "on") ? BCS_BORDER : 0;
                $style|= ($drawtext == "on") ? BCS_DRAW_TEXT : 0;
                $style|= ($stretchtext == "on") ? BCS_STRETCH_TEXT : 0;
                $style|= ($negative == "on") ? BCS_REVERSE_COLOR : 0;
                switch ($type) {
                    case "i25":
                        $obj = new I25Object($width, $height, $style, $barcode);
                        break;

                    case "c39":
                        $obj = new C39Object($width, $height, $style, $barcode);
                        break;

                    case "c128a":
                        $obj = new C128AObject($width, $height, $style, $barcode);
                        break;

                    case "c128b":
                        $obj = new C128BObject($width, $height, $style, $barcode);
                        break;

                    case "c128c":
                        $obj = new C128CObject($width, $height, $style, $barcode);
                        break;

                    default:
                        $obj = false;
                }
                if ($obj) {
                    if ($obj->DrawObject($xres)) {
                        $obj->SetFont($font);
                        $obj->DrawObject($xres);
                        $obj->FlushObject();
                        $obj->DestroyObject();
                        unset($obj);
                    }
                }
            }
        }
    }
?>