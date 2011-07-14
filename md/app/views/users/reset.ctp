<h2><?php echo __l('Reset your password'); ?></h2>
<div id="reset-block">
<?php
	echo $form->create('User', array('action' => 'reset' ,'class' => 'normal'));
	echo $form->input('user_id', array('type' => 'hidden'));
	echo $form->input('hash', array('type' => 'hidden'));
	echo $form->input('passwd', array('type' => 'password','label' => __l('Enter a new password') ,'id' => 'password'));
	echo $form->input('confirm_password', array('type' => 'password','label' => __l('Confirm Password')));
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