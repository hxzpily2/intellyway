<div class="userFriends form js-ajax-form-container">
	<div class="main-content-block round-5">
		<h2 class="login-title"><?php echo __l('Invite Friends'); ?></h2>
		<div class="form-blocks round-5">
			<?php
				echo $form->create('UserFriend', array('action' => 'invite_friend', 'class' => "normal js-ajax-form {container:'js-friends-responses'}"));
				echo $form->input('friends_email',array('type' => 'textarea', 'label' => __l('Friend\'s Email'), 'info' => __l('Comma separated e-mails')));
				echo $form->end('Invite');
			?>
		</div>
	</div>
</div>