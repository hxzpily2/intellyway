<?php /* SVN: $Id: view.ctp 38708 2010-12-23 15:58:50Z anandam_023ac09 $ */ ?>
<div class="users view">
    <h2><?php echo ucfirst($html->cText($user['User']['username'], false)); ?></h2>
	<div class="add-block js-login-form">
    <?php
			 if($auth->user('username')!=$user['User']['username'] && Configure::read('friend.is_enabled') && $user['User']['user_type_id'] != ConstUserTypes::Admin):
				if (!empty($friend)):
					if ($friend['UserFriend']['friend_status_id'] == ConstUserFriendStatus::Pending):
						$is_requested = ($friend['UserFriend']['is_requested']) ? 'sent' : 'received';
						echo $html->link(__l('Friend Request is Pending'), array('controller' => 'user_friends', 'action' => 'remove', $user['User']['username'], $is_requested), array('class' => 'user-pending js-friend', 'title' => __l('Click to remove from friend\'s list')));
					else:
						$is_requested = ($friend['UserFriend']['is_requested']) ? 'sent' : 'received';
						echo $html->link(__l('Remove Friend'), array('controller' => 'user_friends', 'action' => 'remove', $user['User']['username'], $is_requested), array('class' => 'js-delete remove-user delete js-add-friend', 'title' => __l('Click to remove from friend\'s list')));
					endif;
				else:
					if($html->isAllowed($auth->user('user_type_id'))):  // If company user logged in.
						if($user['User']['user_type_id'] == ConstUserTypes::Company && Configure::read('user.is_company_actas_normal_user')):  // On viewing company user profile
							echo $html->link(__l('Add as Friend'), array('controller' => 'user_friends', 'action' => 'add', $user['User']['username']), array('class' => 'add add-friend js-add-friend', 'title' => __l('Add as Friend')));
						elseif($user['User']['user_type_id'] != ConstUserTypes::Company):
							echo $html->link(__l('Add as Friend'), array('controller' => 'user_friends', 'action' => 'add', $user['User']['username']), array('class' => 'add add-friend', 'title' => __l('Add as Friend')));
						endif;
					endif;
				endif;
			endif;
        ?>
	 </div>
	 <?php if (Configure::read('user.is_show_user_statistics')): ?>
		<div class="main-content-block clearfix">
			<div class="js-responses">
				<dl class="list statistics-list clearfix">
					<?php if (Configure::read('user.is_show_referred_friends') && Configure::read('user.is_referral_system_enabled')) {?>
					<dt><?php echo __l('Referred Users');?></dt>
						<dd>(<?php echo $html->cInt($statistics['referred_users']);?>)</dd>
					<?php } ?>	
					<?php if (Configure::read('user.is_show_friend') && Configure::read('friend.is_enabled')) {?>
					<dt><?php echo __l('Friends');?></dt>
						<dd>(<?php echo $html->cInt($statistics['user_friends']);?>)</dd>	
					<?php } ?>	
					<?php if (Configure::read('user.is_show_deal_purchased')) {?>
					<dt><?php echo __l('Deal Purchased');?></dt>
						<dd>(<?php echo $html->cInt($statistics['deal_purchased']);?>)</dd>
					<?php } ?>	
					<dt><?php echo __l('Gift Sent');?></dt>
						<dd>(<?php echo $html->cInt($statistics['gift_sent']);?>)</dd>
					<dt><?php echo __l('Gift Received');?></dt>
						<dd>(<?php echo $html->cInt($statistics['gift_received']);?>)</dd>
				</dl>
			</div>
		</div>	
	<?php endif; ?>
	 <div class="clearfix viewpage-content">
	 <div class="clearfix">
	 <div class="user-avatar user-view-image">
     
	 <?php 
	 		if(isset($user['User']['fb_user_id']) && !empty($user['User']['fb_user_id']) && empty($user['UserAvatar']['id'])){
				echo $html->getFacebookAvatar($user['User']['fb_user_id'], Configure::read('thumb_size.big_thumb.height'),Configure::read('thumb_size.big_thumb.width'));
			}
			else{	 
	 			echo $html->showImage('UserAvatar', $user['UserAvatar'], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($user['User']['username'], false)), 'title' => $html->cText($user['User']['username'], false)));
	 	}
	 ?>
	 </div>
	 <?php if(!empty($user['UserProfile'])){ ?>
	 <div class="user-view-content">
    <?php if(!empty($user['UserProfile']['about_me'])){ ?>
     <div class="about-content round-5">
	    <?php if(!empty($user['UserProfile']['about_me'])): ?>
			<h3><?php echo __l('About Me');?></h3>
			<p><?php echo nl2br($html->cText($user['UserProfile']['about_me']));?></p>
		<?php endif; ?>
    </div>
    <?php } ?>
		<dl class="list company-list clearfix round-5">
        <?php if($user['UserProfile']['created'] != '0000-00-00 00:00:00'){ ?>
			<dt><?php echo __l('Member Since');?></dt>
			<dd><?php echo $html->cDate($user['User']['created']);?></dd>
		<?php } ?>
        <?php
			if (Configure::read('Profile-is_show_name') && ($html->checkForPrivacy('Profile-is_show_name', $auth->user('id'), $user['User']['id']) || $auth->user('user_type_id') == ConstUserTypes::Admin)):
				$name = array();
				if(!empty($user['UserProfile']['first_name'])):
					$name[]= $html->cText($user['UserProfile']['first_name']);
				endif;
				if(!empty($user['UserProfile']['middle_name'])):
					$name[]= $html->cText($user['UserProfile']['middle_name']);
				endif;
				if(!empty($user['UserProfile']['last_name'])):
					$name[]= $html->cText($user['UserProfile']['last_name']);
				endif;
				if($name):
				?>
				<dt><?php echo __l('Name');?></dt>
					<dd>
					<?php echo implode(' ',$name);?>

					</dd>

				<?php
				endif;
			endif;
		?>
		<?php
			if (Configure::read('Profile-is_show_gender') && ($html->checkForPrivacy('Profile-is_show_gender', $auth->user('id'), $user['User']['id']) || $auth->user('user_type_id') == ConstUserTypes::Admin)):
				if (!empty($user['UserProfile']['Gender']['name'])):
		?>
					<dt><?php echo __l('Gender');?></dt>
						<dd><?php echo $html->cText($user['UserProfile']['Gender']['name']);?></dd>
		<?php
				endif;
			endif;
		?>
		<?php
			if (Configure::read('Profile-is_show_address') && ($html->checkForPrivacy('Profile-is_show_address', $auth->user('id'), $user['User']['id']) || $auth->user('user_type_id') == ConstUserTypes::Admin)):
				if(!empty($user['UserProfile']['address'])):
		?>
					<dt><?php echo __l('Address');?></dt>
						<dd>
                            <?php if(!empty($user['UserProfile']['address'])) { ?>
                                <p><?php echo $html->cText($user['UserProfile']['address']);?></p>
                            <?php } ?>
                            <?php if(!empty($user['UserProfile']['City']['name'])) { ?>
                                <p><?php echo $html->cText($user['UserProfile']['City']['name']);?></p>
                            <?php } ?>
                            <?php if(!empty($user['UserProfile']['State']['name'])) { ?>
                                <p><?php echo $html->cText($user['UserProfile']['State']['name']);?></p>
                            <?php } ?>
                              <?php if(!empty($user['UserProfile']['Country']['name'])) { ?>
                                <p><?php echo $html->cText($user['UserProfile']['Country']['name']);?></p>
                            <?php } ?>
                             <?php if(!empty($user['UserProfile']['zip_code'])) { ?>
                                <p><?php echo $html->cText($user['UserProfile']['zip_code']);?></p>
                            <?php } ?>
                        </dd>
		<?php
				endif;
			endif;
		?>
		<?php
			if ($auth->user('username')== $user['User']['username'] || $auth->user('user_type_id') == ConstUserTypes::Admin):
				if (!empty($user['UserProfile']['paypal_account'])):
		?>
					<dt><?php echo __l('Paypal Account');?></dt>
						<dd><?php echo $html->cText($user['UserProfile']['paypal_account']);?></dd>
		<?php
				endif;
			endif;
		?>
		<?php
			if (!empty($user['UserProfile']['language_id'])):
		?>
				<dt><?php echo __l('Language');?></dt>
					<dd><?php echo $html->cText($user['UserProfile']['Language']['name']);?></dd>
		<?php
			endif;
		?>
	</dl>


	 </div>

<?php }?>
	 </div>

		</div>
	<div class="js-tabs user-view-tabs">
        <ul class="clearfix">
			<?php if (Configure::read('Profile-is_allow_comment_add') && $html->isAllowed($auth->user('user_type_id')) && ($html->checkForPrivacy('Profile-is_allow_comment_add', $auth->user('id'), $user['User']['id']) || $auth->user('user_type_id') == ConstUserTypes::Admin)): ?>
				<li><?php echo $html->link(__l('Comments'), '#tabs-1');?></li>
			<?php endif; ?>
            <?php if($auth->user('id')): ?>
				<?php if (Configure::read('user.is_show_deal_purchased')): ?>
                    <li><?php echo $html->link(__l('Deal Purchased'), array('controller' => 'deal_users', 'action' => 'user_deals', 'user_id' =>  $user['User']['id']),array('title' => __l('Deals Purchased'))); ?></li>
                <?php endif; ?>
                <?php if (Configure::read('user.is_show_friend') && Configure::read('friend.is_enabled')): ?>
                    <li><?php echo $html->link(__l('Friends'), array('controller' => 'user_friends', 'action' => 'myfriends', 'user_id' =>  $user['User']['id'], 'status' => ConstFriendRequestStatus::Approved),array('title' => __l('Friends'))); ?></li>
                <?php endif; ?>
                <?php if (Configure::read('user.is_show_referred_friends') && Configure::read('user.is_referral_system_enabled')): ?>
                    <li><?php echo $html->link(__l('Referred Users'), array('controller' => 'users', 'action' => 'referred_users', 'user_id' =>  $user['User']['id']),array('title' => __l('Referred Users'))); ?></li>
                <?php endif; ?>
              <?php endif; ?>
        </ul>
		<?php if (Configure::read('Profile-is_allow_comment_add') && $html->isAllowed($auth->user('user_type_id')) && $html->checkForPrivacy('Profile-is_allow_comment_add', $auth->user('id'), $user['User']['id']) || $auth->user('user_type_id') == ConstUserTypes::Admin): ?>
			<div id='tabs-1'>
				<div class="main-content-block js-corner round-5">
					<div class="js-responses">
						<?php echo $this->element('user_comments-index', array('username' => $user['User']['username'], 'cache' => array('time' => Configure::read('site.element_cache')), 'key' => $user['User']['username']));?>
					</div>
				</div>
                <?php if($auth->user('id') and $auth->user('id')!= $user['User']['id']): ?>
                    <div class="main-content-block js-corner round-5">
                        <h2><?php echo __l('Add Your comments'); ?></h2>
                        <?php echo $this->element('../user_comments/add');?>
                    </div>
                <?php endif; ?>
			</div>
		<?php endif; ?>
    </div>
</div>