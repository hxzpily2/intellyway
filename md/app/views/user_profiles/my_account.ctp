<div style="height: 10px;">&nbsp;</div>
<div class="js-tabs">	
	<ul class="clearfix">		
		<li><?php echo $html->link(__l('My Profile'), array('controller' => 'user_profiles', 'action' => 'edit', $user_id, 'admin' => false), array('title' => 'My Profile', 'rel'=> 
		'#Request_API_Key')); ?></li>
		<?php $is_show_credit_cards = $html->isAuthorizeNetEnabled(); ?>
		<?php if (!empty($is_show_credit_cards)): ?>
			<li><?php echo $html->link(__l('Credit Cards'), array('controller' => 'user_payment_profiles', 'action' => 'index', 'admin' => false), array('title' => 'Credit Cards', 'rel' => '#Credit_cards')); ?></li>
		<?php endif; ?>
		<?php if(!$auth->user('fb_user_id') && !$auth->user('is_openid_register')){?>
			<li><?php  echo $html->link(__l('Change Password'),array('controller'=> 'users', 'action'=>'change_password'),array('title' => 'Change Password', 'rel' => '#Change_Password')); ?></li>
		<?php } ?>
		<?php if($auth->user('user_type_id') != ConstUserTypes::Company):?>
			  <li><?php echo $html->link(__l('Privacy Settings'), array('controller' => 'user_permission_preferences', 'action' => 'edit', $user_id, 'admin' => false), array('title' => 'Privacy Settings', 'rel' => '#Privacy_Settings'));?></li>
		<?php endif; ?>
		<?php if (Configure::read('site.is_api_enabled')): ?>
			 <!--<li>-->
			 <?//php echo $html->link(__l('My').' '.Configure::read('site.name').' '.__l(' API'), array('controller' => 'users', 'action' => 'my_api', $auth->user('id'), 'admin' => false), array('title' => 'Request API Key', 'rel'=> '#Request_API_Key'));?>
			<!--</li>-->
		 <?php endif; ?>
		 <li><?php echo $html->image('sousmenu.png',array('style'=>'display:inline;')); ?></li>
	</ul>
</div>