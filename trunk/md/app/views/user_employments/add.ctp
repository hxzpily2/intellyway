<?php /* SVN: $Id: $ */ ?>
<div class="userEmployments form">
<?php echo $form->create('UserEmployment', array('class' => 'normal'));?>
	<fieldset>
 		<legend><?php echo $html->link(__l('User Employments'), array('action' => 'index'));?> &raquo; <?php echo __l('Add User Employment');?></legend>
	<?php
		echo $form->input('employment');
		echo $form->input('is_active');
	?>
	</fieldset>
<?php echo $form->end(__l('Add'));?>
</div>
