<?php
/* SVN: $Id: config.php 39887 2011-01-03 11:08:37Z usha_111at09 $ */
/**
 * Custom configurations
 */
// site actions that needs random attack protection...
$config['site']['_hashSecuredActions'] = array(
    'edit',
    'delete',
    'update',
    'refer',
    'unsubscribe',
    'barcode',
    'update_status',
    'resend',
    'my_account',
    'view_gift_card'
);
$config['site']['domain'] = 'MissDeal';
$config['photo']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
		'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
	'allowEmpty' => true
);
$config['image']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => false
);
$config['avatar']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => true
);
class ConstPaymentStatus
{
    const Success = 'Success';
    const Refund = 'Refund';
    const Cancel = 'Cancel';
    const Pending = 'Pending';
}
class ConstDealStatus
{
    const Upcoming = 1;
    const Open = 2;
    const Canceled = 3;
    const Expired = 4;
    const Tipped = 5;
    const Closed = 6;
    const Refunded = 7;
    const PaidToCompany = 8;
    const PendingApproval = 9;
    const Rejected = 10;
    const Draft = 11;
    const Delete = 12; //Not available in table. only for coding purpose
    
}
class ConstTopicType
{
    const DealTalk = 1;
    const CityTalk = 2;
    const GlobalTalk = 3;
}
class ConstUserTypes
{
    const Admin = 1;
    const User = 2;
    const Company = 3;
}
class ConstUserIds
{
    const Admin = 1;
}
class ConstAttachment
{
    const UserAvatar = 1;
    const Deal = 0;
}
class ConstFriendRequestStatus
{
    const Pending = 1;
    const Approved = 2;
    const Reject = 3;
}
class ConstMoreAction
{
    const Inactive = 1;
    const Active = 2;
    const Delete = 3;
    const OpenID = 4;
    const Export = 5;
    const EnableCompanyProfile = 6;
    const Used = 7;
    const DisableCompanyProfile = 8;
    const Online = 9;
    const Offline = 10;
    const FaceBook = 11;
    const DeductAmountFromWallet = 12;
    const NotUsed = 13;
    const UnSubscripe = 14;
    const Checked = 15;
    const Unchecked = 16;
}
class ConstUserFriendStatus
{
    const Pending = 1;
    const Approved = 2;
    const Rejected = 3;
}
// setting for one way and two way friendships
class ConstUserFriendType
{
    const IsTwoWay = true;
}
// Banned ips types
class ConstBannedTypes
{
    const SingleIPOrHostName = 1;
    const IPRange = 2;
    const RefererBlock = 3;
}
// Banned ips durations
class ConstBannedDurations
{
    const Permanent = 1;
    const Days = 2;
    const Weeks = 3;
}
class ConstReferralRule
{
    const Referral = 1;
    const Referred = 2;
    const BuyedFirst = 3;
    const BuyedSecond = 4;
}
class ConstWithdrawalStatus
{
    const Pending = 1;
    const Approved = 2;
    const Rejected = 3;
    const Failed = 4;
    const Success = 5;
}
class ConstMyGiftStatus
{
    const Pending = 'Pending';
    const Success = 'Not Yet Redeemed';
    const ToCredit = 'Redeemed By Recipient';
}
class ConstTransactionTypes
{
    const AddedToWallet = 1;
    const BuyDeal = 2;
    const DealGift = 3;
    const GiftSent = 4;
    const GiftReceived = 5;
    const ReferralAmount = 6;
    const PaidDealAmountToCompany = 7;
    const UserCashWithdrawalAmount = 8;
    const DealBoughtRefund = 9;
    const DealGiftRefund = 10;
    const ReferralAmountPaid = 11;
    const ReceivedDealPurchasedAmount = 12;
    const AcceptCashWithdrawRequest = 13;
    const DeductedAmountForOfflineCompany = 14;
    const DealBoughtCancel = 15;
    const DealGiftCancel = 16;
    const UserWithdrawalRequest = 17;
    const AdminApprovedWithdrawalRequest = 18;
    const AdminRejecetedWithdrawalRequest = 19;
    const FailedWithdrawalRequest = 20;
    const AmountRefundedForRejectedWithdrawalRequest = 21;
    const AmountApprovedForUserCashWithdrawalRequest = 22;
    const FailedWithdrawalRequestRefundToUser = 24;
	const AddFundToWallet = 25;
	const DeductFundFromWallet = 26;
	const PartallyAmountTakenForDealPurchase = 28;
	const PartallyAmountTakenForGiftPurchase = 29;
}
// Setting for privacy setting
class ConstPrivacySetting
{
    const EveryOne = 1;
    const Users = 2;
    const Friends = 3;
    const Nobody = 4;
}
class ConstPaymentGateways
{
    const Wallet = 1;
    const CreditCard = 2;
    const PayPalAuth = 3;
    const AuthorizeNet = 4;
	const PagSeguro = 5;
}
class ConstPaymentGatewayFilterOptions
{
    const Active = 1;
    const Inactive = 2;
    const TestMode = 3;
    const LiveMode = 4;
}
class ConstPaymentGatewayMoreActions
{
    const Activate = 1;
    const Deactivate = 2;
    const MakeTestMode = 3;
    const MakeLiveMode = 4;
    const Delete = 5;
}

class ConstMissdealSpecialType
{
    const TRAVEL = "SP_TR";
    const FAMILY = "SP_TM";
    const PARAM = "sp";
}

$config['cdn']['images'] = null; // 'http://images.localhost/';
$config['cdn']['css'] = null; // 'http://static.localhost/';
/*
date_default_timezone_set('Asia/Calcutta');

Configure::write('Config.language', 'spa');
setlocale (LC_TIME, 'es');
*/
/*
** to do move to settings table
*/
$config['sitemap']['models'] = array(
    'Deal',
	'Topic'
);
$config['site']['is_admin_settings_enabled'] = true;
if ($_SERVER['HTTP_HOST'] == 'groupdeal.dev.agriya.com' && !in_array($_SERVER['REMOTE_ADDR'], array('118.102.143.2', '119.82.115.146', '122.183.135.202', '122.183.136.34','122.183.136.36'))) {
	$config['site']['is_admin_settings_enabled'] = false;
	$config['site']['admin_demomode_updation_not_allowed_array'] = array(
		'cities/admin_delete',
		'cities/admin_update',
		'cities/admin_edit',
		'cities/admin_update_status',
		'countries/admin_update',
		'countries/admin_delete',
		'countries/admin_edit',
		'countries/admin_update_status',
		'states/admin_update',
		'states/admin_delete',
		'states/admin_edit',
		'states/admin_update_status',
		'pages/admin_edit',
		'pages/admin_delete',
	);
}
?>