<div class="page-block">
<h2 class="login-title"><?php echo __l('Forgot your password?');?></h2>
<br style="line-height: 30px;"/>
<div class="forgot-info-md">
	<?php echo __l('Enter your Email, and we will send you instructions for resetting your password.'); ?>
</div>
<br style="line-height: 30px;"/>
<?php
	echo $form->create('User', array('action' => 'forgot_password', 'class' => 'normal'));
	echo $form->input('email', array('type' => 'text','label' => __l('Email'))); ?>

<div class="submit-block clearfix">
<a class="pink_button" href="#" onclick="javascript:$('#UserForgotPasswordForm').submit()"><span><?php echo __l('Send'); ?></span></a>
<?php
	/*echo $form->submit(__l('Send'));*/
?>
</div>
<?php
	echo $form->end();
?>
</div>
<div style="height:4px;"></div>
<!--[if IE]>
<div style="height : 3px;">&nbsp;</div>
<![endif]-->