<?php /* SVN: $Id: $ */ ?>
<div class="userRelationships form">
<?php echo $form->create('UserRelationship', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo __l('Add User Relationship');?></h2>
	<?php
		echo $form->input('relationship');
		echo $form->input('is_active');
	?>
	</fieldset>

   <div class="submit-block clearfix">
    <?php echo $form->submit(__l('Add'));?>
    </div>
    <?php echo $form->end();?>
</div>
