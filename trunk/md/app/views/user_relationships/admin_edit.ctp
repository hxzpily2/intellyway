<?php /* SVN: $Id: $ */ ?>
<div class="userRelationships form">
<?php echo $form->create('UserRelationship', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo $html->link(__l('User Relationships'), array('action' => 'index'));?> &raquo; <?php echo __l('Edit User Relationship');?></h2>
	<?php
		echo $form->input('id');
		echo $form->input('relationship');
		echo $form->input('is_active');
	?>
	</fieldset>
 <div class="submit-block clearfix">
    <?php echo $form->submit(__l('Update'));?>
    </div>
    <?php echo $form->end();?>
</div>
