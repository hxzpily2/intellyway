<?php /* SVN: $Id: $ */ ?>
<div class="userEducations form">
<?php echo $form->create('UserEducation', array('class' => 'normal'));?>
	<fieldset>
 		<legend><?php echo $html->link(__l('User Educations'), array('action' => 'index'));?> &raquo; <?php echo __l('Edit User Education');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('education');
		echo $form->input('is_active');
	?>
	</fieldset>
<?php echo $form->end(__l('Update'));?>
</div>
