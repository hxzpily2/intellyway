<?php
/* SVN FILE: $Id: app_helper.php 44785 2011-02-19 10:54:51Z aravindan_111act10 $ */
/**
 * Short description for file.
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
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
 * @subpackage    cake.cake
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7904 $
 * @modifiedby    $LastChangedBy: mark_story $
 * @lastmodified  $Date: 2008-12-05 22:19:43 +0530 (Fri, 05 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::import('Core', 'Helper');
/**
 * This is a placeholder class.
 * Create the same file in app/app_helper.php
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake
 */
class AppHelper extends Helper
{
    function getUserAvatar($user_id)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
            ) ,
            'fields' => array(
                'UserAvatar.id',
                'UserAvatar.dir',
                'UserAvatar.filename'
            ) ,
            'recursive' => 0
        ));
        return $user['UserAvatar'];
    }
    function checkForPrivacy($field_to_check = null, $logged_in_user = null, $user_id = null, $is_boolean = false)
    {
        App::import('Model', 'UserPermissionPreference');
        $this->UserPermissionPreference = new UserPermissionPreference();
        $privacy = $this->UserPermissionPreference->getUserPrivacySettings($user_id);
        $is_show = true;
        if (Configure::read($field_to_check)) {
            if ($privacy['UserPermissionPreference'][$field_to_check] == ConstPrivacySetting::Users && !$logged_in_user) {
                $is_show = false;
            } else if ($privacy['UserPermissionPreference'][$field_to_check] == ConstPrivacySetting::Nobody) {
                $is_show = false;
            } else if ($privacy['UserPermissionPreference'][$field_to_check] == ConstPrivacySetting::Friends) {
                // To write user friends lists in config
                App::import('Model', 'UserFriend');
                $this->UserFriend = new UserFriend();
                $is_show = $this->UserFriend->checkIsFriend($logged_in_user, $user_id);
            } else if ($is_boolean) {
                $is_show = $privacy['UserPermissionPreference'][$field_to_check];
            }
        }
        return $is_show;
    }
    function getLanguage()
    {
        App::import('Model', 'Translation');
        $this->Translation = new Translation();
        $languages = $this->Translation->find('all', array(
            'conditions' => array(
                'Language.id !=' => 0
            ) ,
            'fields' => array(
                'DISTINCT(Translation.language_id)',
                'Language.name',
                'Language.iso2'
            ) ,
            'order' => array(
                'Language.name' => 'ASC'
            )
        ));
        $languageList = array();
        if (!empty($languages)) {
            foreach($languages as $language) {
                $languageList[$language['Language']['iso2']] = $language['Language']['name'];
            }
        }
        return $languageList;
    }
    function getCity()
    {
        App::import('Model', 'City');
        $this->City = new City();
        $cities = $this->City->find('all', array(
            'conditions' => array(
                'City.is_approved' => 1
            ) ,
            'fields' => array(
				'City.id',
                'City.name',
                'City.slug',
                'City.active_deal_count'
            ) ,
            'order' => array(
                'City.name' => 'asc'
            ) ,
			'recursive' => -1
        ));
        $cityList = array();
        if (!empty($cities)) {
            foreach($cities as $city) {
                $cityList[$city['City']['id']] = $city['City']['name'];
            }
        }
        return $cityList;
    }
    function getCompany($user_id = null)
    {
        App::import('Model', 'Company');
        $this->Company = new Company();
        $company = $this->Company->find('first', array(
            'conditions' => array(
                'Company.user_id' => $user_id,
            ) ,
            'fields' => array(
                'Company.id',
                'Company.name',
                'Company.slug',
                'Company.is_company_profile_enabled',
                'Company.is_online_account'
            ) ,
            'recursive' => -1
        ));
        return $company;
    }
    function siteLogo()
    {
        App::import('Model', 'Attachment');
        $this->Attachment = new Attachment();
        $attachment = $this->Attachment->find('first', array(
            'conditions' => array(
                'Attachment.class' => 'SiteLogo'
            ) ,
            'fields' => array(
                'Attachment.id',
                'Attachment.dir',
                'Attachment.filename',
                'Attachment.width',
                'Attachment.height'
            ) ,
            'recursive' => -1
        ));
        return $attachment;
    }
    function isAllowed($user_type = null)
    {
        if ($user_type == ConstUserTypes::Company && !Configure::read('user.is_company_actas_normal_user')) {
            return false;
        }
        return true;
    }
    function getCityTwitterFacebookURL($slug = null)
    {
        App::import('Model', 'City');
        $this->City = new City();
        $city = $this->City->find('first', array(
            'conditions' => array(
                'City.slug' => $slug
            ) ,
            'fields' => array(
                'City.twitter_url',
                'City.facebook_url'
            ) ,
            'recursive' => -1
        ));
        return $city;
    }
    public function url($url = null, $full = false)
    {
        if (Cache::read('site.city_url', 'long') == 'prefix') {
            return parent::url(router_url_city($url, $this->params['named']) , $full);
        }
        return parent::url($url, $full);
    }
    function total_saved()
    {
        App::import('Model', 'DealUser');
        $this->DealUser = new DealUser();
        $total_saved = $this->DealUser->Deal->find('first', array(
            'conditions' => array(
                'Deal.deal_status_id' => ConstDealStatus::PaidToCompany
            ) ,
            'fields' => array(
                'SUM(Deal.savings * Deal.deal_user_count) as total_saved'
            ) ,
            'recursive' => -1
        ));
        $total_bought = $this->DealUser->find('first', array(
            'fields' => array(
                'SUM(DealUser.quantity) as total_bought'
            ) ,
            'recursive' => -1
        ));
        $total_array = array(
            'total_saved' => (!empty($total_saved[0]['total_saved'])) ? $total_saved[0]['total_saved'] : 0,
            'total_bought' => (!empty($total_bought[0]['total_bought'])) ? $total_bought[0]['total_bought'] : 0,
        );
        return $total_array;
    }
    function truncate($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false)
    {
        return $this->Text->truncate($this->cText($text, false) , $length, $ending, $exact, $considerHtml);
    }
    function cCurrency($str, $wrap = 'span', $title = false)
    {
        $_precision = 2;
        $changed = (($r = floatval($str)) != $str);
        $rounded = (($rt = round($r, $_precision)) != $r);
        $r = $rt;
        if ($wrap) {
            if (!$title) {
                $title = ucwords(Numbers_Words::toCurrency($r, 'en_US', Configure::read('paypal.currency_code')));
            }
            $r = '<' . $wrap . ' class="c' . $changed . ' cr' . $rounded . '" title="' . $title . '">' . number_format($r, $_precision, '.', ',') . '</' . $wrap . '>';
        }
        return $r;
    }
    function getUserLink($user_details)
    {
        if ($user_details['user_type_id'] == ConstUserTypes::Admin || $user_details['user_type_id'] == ConstUserTypes::User) {
            return $this->link($this->cText($user_details['username']) , array(
                'controller' => 'users',
                'action' => 'view',
                $user_details['username'],
                'admin' => false
            ) , array(
                'title' => $this->cText($user_details['username'], false) ,
                'escape' => false
            ));
        }
        //for company
        if ($user_details['user_type_id'] == ConstUserTypes::Company) {
            $companyDetails = $this->getCompany($user_details['id']);
            if (!$companyDetails['Company']['is_company_profile_enabled'] || !$companyDetails['Company']['is_online_account']) {
                return $this->cText($companyDetails['Company']['name']);
            }
            return $this->link($this->cText($companyDetails['Company']['name'], false) , array(
                'controller' => 'companies',
                'action' => 'view',
                $companyDetails['Company']['slug'],
                'admin' => false
            ) , array(
                'title' => $this->cText($companyDetails['Company']['name'], false) ,
                'escape' => false
            ));
        }
    }
    function getUserAvatarLink($user_details, $dimension = 'medium_thumb', $is_link = true)
    {
		App::import('Model', 'Setting');
        $this->Setting = new Setting();
        if ($user_details['user_type_id'] == ConstUserTypes::Admin || $user_details['user_type_id'] == ConstUserTypes::User) {
			$user_image = '';
			//print_r($user_details['UserAvatar']);
			if(isset($user_details['fb_user_id']) && !empty($user_details['fb_user_id']) && empty($user_details['UserAvatar']['id'])){
				$width = $this->Setting->find('first', array('conditions' => array('Setting.name' => 'thumb_size.'.$dimension.'.width'), 'recursive' => -1));
				$height = $this->Setting->find('first', array('conditions' => array('Setting.name' => 'thumb_size.'.$dimension.'.height'), 'recursive' => -1));
				$user_image = $this->getFacebookAvatar($user_details['fb_user_id'], $height['Setting']['value'],$width['Setting']['value']);
			}
			else{
				//get user image
				$user_image = $this->showImage('UserAvatar', (!empty($user_details['UserAvatar'])) ? $user_details['UserAvatar'] : '', array(
					'dimension' => $dimension,
					'alt' => sprintf('[Image: %s]', $user_details['username']) ,
					'title' => $user_details['username']
				));
			}
            //return image to user
            return (!$is_link) ? $user_image : $this->link($user_image, array(
                'controller' => 'users',
                'action' => 'view',
                $user_details['username'],
                'admin' => false
            ) , array(
                'title' => $this->cText($user_details['username'], false) ,
                'escape' => false
            ));
        }
        //for company
        if ($user_details['user_type_id'] == ConstUserTypes::Company) {
            $companyDetails = $this->getCompany($user_details['id']);
            //get user image
            $user_image = $this->showImage('UserAvatar', $user_details['UserAvatar'], array(
                'dimension' => $dimension,
                'alt' => sprintf('[Image: %s]', $this->cText($companyDetails['Company']['name'], false)) ,
                'title' => $this->cText($companyDetails['Company']['name'], false)
            ));
            //return image to user
            return (!$companyDetails['Company']['is_company_profile_enabled'] || !$is_link) ? $user_image : $this->link($user_image, array(
                'controller' => 'companies',
                'action' => 'view',
                $companyDetails['Company']['slug'],
                'admin' => false
            ) , array(
                'title' => $this->cText($companyDetails['Company']['name'], false) ,
                'escape' => false
            ));
        }
    }
	function getFacebookAvatar($fbuser_id,$height=35,$width=35)
	{
		return $this->image("http://graph.facebook.com/{$fbuser_id}/picture",array('height'=>$height, 'width'=> $width));
	}
    function transactionDescription($transaction)
    {
        $deal_name = $deal_slug = $friend_link = $user_link = '';
        if ($transaction['Transaction']['class'] == 'DealUser') {
            $deal_name = (!empty($transaction['DealUser']['Deal']['name'])) ? $transaction['DealUser']['Deal']['name'] : '';
            $deal_slug = (!empty($transaction['DealUser']['Deal']['slug'])) ? $transaction['DealUser']['Deal']['slug'] : '';
            if ($transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::DealGift) {
                $friend_link = $this->cText($transaction['DealUser']['gift_email'], false);
            }
        } elseif ($transaction['Transaction']['class'] == 'Deal') {
            $deal_name = (!empty($transaction['Deal']['display_field'])) ? $transaction['Deal']['display_field'] : '';
            $deal_slug = (!empty($transaction['Deal']['slug'])) ? $transaction['Deal']['slug'] : '';
            if (!empty($transaction['Deal']['Company'])) {
                $company_name = $transaction['Deal']['Company']['name'];
                $company_slug = $transaction['Deal']['Company']['slug'];
            }
        }
        if ($transaction['Transaction']['class'] == 'GiftUser') {
            if ($transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::GiftSent) {
                if ($transaction['GiftUser']['gifted_to_user_id']) {
                    $friend_link = $this->getUserLink($transaction['GiftUser']['GiftedToUser']);
                } else {
                    $friend_link = $transaction['GiftUser']['friend_mail'];
                }
            } else {
                $friend_link = $this->getUserLink($transaction['GiftUser']['User']);
            }
        }
        if ($transaction['Transaction']['class'] == 'SecondUser') {
            if ($transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::AmountRefundedForRejectedWithdrawalRequest || $transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::AdminRejecetedWithdrawalRequest || $transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::UserWithdrawalRequest || $transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::AmountApprovedForUserCashWithdrawalRequest || $transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::FailedWithdrawalRequestRefundToUser || $transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::AdminApprovedWithdrawalRequest || $transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::AcceptCashWithdrawRequest || $transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::DeductedAmountForOfflineCompany || $transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::FailedWithdrawalRequest) {
                $user_link = $this->getUserLink($transaction['User']);
            } else {
                $user_link = $this->getUserLink($transaction['SecondUser']);
            }
        }
        if ($transaction['Transaction']['class'] == 'User') {
            $user_link = $this->getUserLink($transaction['User']);
        }
        $transactionReplace = array(
            '##DEAL_LINK##' => (!empty($deal_slug) && !empty($deal_name)) ? $this->link($this->cText($deal_name) , array(
                'controller' => 'deals',
                'action' => 'view',
                $deal_slug,
                'admin' => false
            ) , array(
                'escape' => false,
                'title' => $this->cText($deal_name, false)
            )) : '',
            '##DEAL_NAME##' => (!empty($deal_slug) && !empty($deal_name)) ? $this->link($this->cText($deal_name) , array(
                'controller' => 'deals',
                'action' => 'view',
                $deal_slug,
                'admin' => false
            ) , array(
                'escape' => false,
                'title' => __l('View this deal')
            )) : '',
            '##COMPANY_NAME##' => (!empty($company_slug) && !empty($company_name)) ? $this->link($this->cText($company_name) , array(
                'controller' => 'company',
                'action' => 'view',
                $company_slug,
                'admin' => false
            ) , array(
                'escape' => false,
                'title' => __l('View this company')
            )) : '',
            '##FRIEND_LINK##' => $friend_link,
            '##USER_LINK##' => $user_link
        );
        return strtr($transaction['TransactionType']['message'], $transactionReplace);
    }
    public function formGooglemap($companydetails = array() , $size = '320x320')
    {
        $companyfulldetails = $companydetails;
        $companydetails = !empty($companydetails['Company']) ? $companydetails['Company'] : $companydetails;
        if ((Configure::read('GoogleMap.embedd_map') == 'Static') || (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'print')) {
            if ((!(is_array($companydetails))) || empty($companydetails)) {
                return false;
            }
            $color_array = array(
                array(
                    'A',
                    'green'
                ) ,
                array(
                    'B',
                    'orange'
                ) ,
                array(
                    'C',
                    'blue'
                ) ,
                array(
                    'D',
                    'yellow'
                )
            );
            $mapurl = 'http://maps.google.com/maps/api/staticmap?center=';
            $mapcenter[] = str_replace(' ', '+', $companydetails['latitude']) . ',' . $companydetails['longitude'];
            $mapcenter[] = 'zoom=' . (!empty($companydetails['map_zoom_level']) ? $companydetails['map_zoom_level'] : Configure::read('GoogleMap.static_map_zoom_level'));
            $mapcenter[] = 'size=' . $size;
            $mapcenter[] = 'markers=color:pink|label:M|' . $companydetails['latitude'] . ',' . $companydetails['longitude'];
            if (!empty($companydetails['CompanyAddress'])) {
                $count = 0;
                foreach($companydetails['CompanyAddress'] as $address) {
                    if (!empty($address['latitude']) && !empty($address['longitude']) && !empty($color_array[$count][0]) && !empty($color_array[$count][1])) {
                        $mapcenter[] = 'markers=color:' . $color_array[$count][1] . '|label:' . $color_array[$count][0] . '|' . $address['latitude'] . ',' . $address['longitude'];
                        $count++;
                    }
                }
            }
            $mapcenter[] = 'sensor=false';
            return $mapurl . implode('&amp;', $mapcenter);
        } else {
            $map_size = explode('x', $size);
            $company_address = !empty($companyfulldetails['address1']) ? $companyfulldetails['address1'] . '+' : '';
            $company_address.= !empty($companyfulldetails['address2']) ? $companyfulldetails['address2'] . '+' : '';
            $company_address.= !empty($companyfulldetails['City']['name']) ? $companyfulldetails['City']['name'] . '+' : '';
            $company_address.= !empty($companyfulldetails['State']['name']) ? $companyfulldetails['State']['name'] . '+' : '';
            $company_address.= !empty($companyfulldetails['Country']['name']) ? $companyfulldetails['Country']['name'] . '+' : '';
            $company_address.= !empty($companyfulldetails['Company']['zip']) ? $companyfulldetails['Company']['zip'] : '';
            $embeddmapurl[] = 'http://maps.google.com/maps?f=q&amp;hl=en&amp;geocode=;';
            $embeddmapurl[] = 'q=' . $company_address;
            //	$embeddmapurl[] = 'll=' . str_replace(' ', '+', $companydetails['latitude']) . ',' . $companydetails['longitude'];
            $embeddmapurl[] = 'z=' . (!empty($companydetails['map_zoom_level']) ? $companydetails['map_zoom_level'] : Configure::read('GoogleMap.static_map_zoom_level'));
            //$embeddmapurl[] = 'markers=color:pink|label:M|' . $companydetails['latitude'] . ',' . $companydetails['longitude'];
            $embeddmapurl[] = 'output=embed';
            //$embeddmapurl[] = '&amp;iwloc=near';
            $embeddmapurl = implode('&amp;', $embeddmapurl);
            $embbedd = "<iframe width='" . $map_size['0'] . "' height='" . $map_size['1'] . "' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='" . $embeddmapurl . "'></iframe>";
            return $embbedd;
        }
    }
    function cDate($str, $wrap = 'span', $title = false)
    {
        $changed = (($r = $this->htmlPurifier->purify(strftime(Configure::read('site.date.format') , strtotime($str . ' GMT')))) != strftime(Configure::read('site.date.format') , strtotime($str . ' GMT')));
        if ($wrap) {
            if (!$title) {
                $title = ' title="' . strftime(Configure::read('site.datetime.tooltip') , strtotime($str . ' GMT')) . ' ' . Configure::read('site.timezone_offset') . '"';
            }
            $r = '<' . $wrap . ' class="c' . $changed . '"' . $title . '>' . $r . '</' . $wrap . '>';
        }
        return $r;
    }
    function cDateTime($str, $wrap = 'span', $title = false)
    {
        $changed = (($r = $this->htmlPurifier->purify(strftime(Configure::read('site.datetime.format') , strtotime($str . ' GMT')))) != strftime(Configure::read('site.datetime.format') , strtotime($str . ' GMT')));
        if ($wrap) {
            if (!$title) {
                $title = ' title="' . strftime(Configure::read('site.datetime.tooltip') , strtotime($str . ' GMT')) . ' ' . Configure::read('site.timezone_offset') . '"';
            }
            $r = '<' . $wrap . ' class="c' . $changed . '"' . $title . '>' . $r . '</' . $wrap . '>';
        }
        return $r;
    }
    function cTime($str, $wrap = 'span', $title = false)
    {
        $changed = (($r = $this->htmlPurifier->purify(strftime(Configure::read('site.time.format') , strtotime($str . ' GMT')))) != strftime(Configure::read('site.time.format') , strtotime($str . ' GMT')));
        if ($wrap) {
            if (!$title) {
                $title = ' title="' . strftime(Configure::read('site.datetime.tooltip') , strtotime($str . ' GMT')) . ' ' . Configure::read('site.timezone_offset') . '"';
            }
            $r = '<' . $wrap . ' class="c' . $changed . '"' . $title . '>' . $r . '</' . $wrap . '>';
        }
        return $r;
    }
    function cBool($str, $wrap = 'span', $title = false)
    {
        $_options = array(
            0 => __l('No') ,
            1 => __l('Yes')
        );
        if (isset($_options[$str])) {
            $str = $_options[$str];
        }
        return $this->cText($str, $wrap, $title);
    }
    function cDateTimeHighlight($str, $wrap = 'span', $title = false)
    {
        if (strtotime(_formatDate('Y-m-d', strtotime($str))) == strtotime(date('Y-m-d'))) {
            $str = strftime('%I:%M %p', strtotime($str . ' GMT'));
        } else if (strtotime(date('Y-m-d', strtotime(_formatDate('Y-m-d', strtotime($str))))) > strtotime(date('Y-m-d')) || mktime(0, 0, 0, 0, 0, date('Y', strtotime(_formatDate('Y-m-d', strtotime($str))))) < mktime(0, 0, 0, 0, 0, date('Y'))) {
            $str = strftime('%b %d, %Y', strtotime($str . ' GMT'));
        } else {
            $str = strftime('%b %d', strtotime($str . ' GMT'));
        }
        $changed = (($r = $this->htmlPurifier->purify($str)) != $str);
        if ($wrap) {
            if (!$title) {
                $title = ' title="' . strftime(Configure::read('site.datetime.tooltip') , strtotime($str . ' GMT')) . ' ' . Configure::read('site.timezone_offset') . '"';
            }
            $r = '<' . $wrap . ' class="c' . $changed . '"' . $title . '>' . $r . '</' . $wrap . '>';
        }
        return $r;
    }
    function isWalletEnabled($field = null)
    {
        App::import('Model', 'PaymentGatewaySetting');
        $this->PaymentGatewaySetting = new PaymentGatewaySetting();
        $paymentGatewaySetting = $this->PaymentGatewaySetting->find('first', array(
            'conditions' => array(
                'PaymentGatewaySetting.key' => 'is_enable_wallet',
                'PaymentGatewaySetting.payment_gateway_id' => ConstPaymentGateways::Wallet
            ) ,
			'contain' => array(
				'PaymentGateway'
			),
            'recursive' => 1
        ));
        if (!empty($paymentGatewaySetting['PaymentGatewaySetting']['test_mode_value']) && !empty($paymentGatewaySetting['PaymentGateway']['is_active'])) {
            return true;
        }
        return false;
    }
	function isAuthorizeNetEnabled()
    {
        App::import('Model', 'PaymentGateway');
        $this->PaymentGateway = new PaymentGateway();
        $paymentGateway = $this->PaymentGateway->find('first', array(
            'conditions' => array(
                'PaymentGateway.id' => ConstPaymentGateways::AuthorizeNet,
                'PaymentGateway.is_active' => 1
            ) ,
            'recursive' => -1
        ));
        if (!empty($paymentGateway)) {
            return true;
        }
        return false;
    }
	function siteCurrencyFormat($amount)
    {
        if (Configure::read('site.currency_symbol_place') == 'left') {
            return Configure::read('site.currency') . $amount;
        } else {
            return $amount . Configure::read('site.currency');
        }
    }
}
?>