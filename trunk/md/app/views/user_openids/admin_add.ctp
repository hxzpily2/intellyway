<?php /* SVN: $Id: admin_add.ctp 6518 2010-06-02 11:06:56Z sreedevi_140ac10 $ */ ?>
<div class="userOpenids form">
<?php echo $form->create('UserOpenid', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo __l('Add User Openid');?></h2>
	<?php
		echo $form->input('user_id',array('label' => __l('User')));
		echo $form->input('openid',array('label' => __l('OpenID')));
		echo $form->input('verify',array('type' => 'checkbox','label' => __l('Verify')));
	?>
	</fieldset>
<?php echo $form->end(__l('Add'));?>
</div>
