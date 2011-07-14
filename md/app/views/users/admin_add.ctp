<?php /* SVN: $Id: admin_add.ctp 40719 2011-01-10 09:27:33Z josephine_065at09 $ */ ?>
<div class="users form">
	<h2> <?php echo __l('Add User');?></h2>
<?php echo $form->create('User', array('class' => 'normal'));?>
	<fieldset>
 	
	<?php
        echo $form->input('user_type_id',array('label' => __l('User Type')));
		echo $form->input('email',array('label' => __l('Email')));
		echo $form->input('username',array('label' => __l('Username')));
		echo $form->input('passwd', array('label' => __l('Password')));
		//echo $form->input('UserProfile.first_name');
		//echo $form->input('UserProfile.last_name');
		//echo $form->input('UserProfile.dob', array('empty' => __l('Please Select'), 'maxYear' => date('Y') - 18, 'minYear' => date('Y') - 100,'label' => 'Date of birth'));
		//echo $form->input('UserProfile.city_id');
		//echo $form->input('UserProfile.state_id');
	?>
	</fieldset>
<div class="submit-block clearfix">
    <?php echo $form->submit(__l('Add'));?>
    </div>
    <?php echo $form->end();?>
</div>