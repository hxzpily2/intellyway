<div class="page-block">
<h2 class="login-title"><?php echo __l('Forgot your password?');?></h2>
<div class="forgot-info">
	<?php echo __l('Enter your Email, and we will send you instructions for resetting your password.'); ?>
</div>
<?php
	echo $form->create('User', array('action' => 'forgot_password', 'class' => 'normal'));
	echo $form->input('email', array('type' => 'text','label' => __l('Email'))); ?>

<div class="submit-block clearfix">
<?php
	echo $form->submit(__l('Send'));
?>
</div>
<?php
	echo $form->end();
?>
</div>