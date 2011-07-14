<div class="js-password-responses">
<h2><?php echo __l('Change Password'); ?></h2>
<div class="js-response js-responses">
<?php echo $form->create('User', array('action' => 'change_password' ,'class' => 'normal js-ajax-form {"container" : "js-password-responses"}')); ?>
<?//php echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url'])); ?>
	<?php
		if($auth->user('user_type_id') == ConstUserTypes::Admin) :
			echo $form->input('user_id', array('empty' => 'Select'));
		endif;
		if($auth->user('user_type_id') != ConstUserTypes::Admin) :
			echo $form->input('user_id', array('type' => 'hidden', 'readonly' => 'readonly'));
			echo $form->input('old_password', array('type' => 'password','label' => __l('Old Password') ,'id' => 'old-password'));
		endif;
		echo $form->input('passwd', array('type' => 'password','label' => __l('Enter a new Password') , 'id' => 'new-password'));
		echo $form->input('confirm_password', array('type' => 'password', 'label' => __l('Confirm Password')));
    ?>
    <div class="submit-block clearfix">
        <?php
        	echo $form->submit(__l('Change Password'));
        ?>
    </div>
        <?php
        	echo $form->end();
        ?>
    </div>
</div>