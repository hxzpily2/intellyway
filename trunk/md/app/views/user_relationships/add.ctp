<?php /* SVN: $Id: $ */ ?>
<div class="userRelationships form">
<?php echo $form->create('UserRelationship', array('class' => 'normal'));?>
	<fieldset>
 		<legend><?php echo $html->link(__l('User Relationships'), array('action' => 'index'));?> &raquo; <?php echo __l('Add User Relationship');?></legend>
	<?php
		echo $form->input('relationship');
		echo $form->input('is_active');
	?>
	</fieldset>
<?php echo $form->end(__l('Add'));?>
</div>
