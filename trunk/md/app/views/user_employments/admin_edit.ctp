<?php /* SVN: $Id: $ */ ?>
<div class="userEmployments form">
<?php echo $form->create('UserEmployment', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo $html->link(__l('User Employments'), array('action' => 'index'));?> &raquo; <?php echo __l('Edit User Employment');?></h2>
	<?php
		echo $form->input('id');
		echo $form->input('employment');
		echo $form->input('is_active');
	?>
	</fieldset>
 <div class="submit-block clearfix">
    <?php echo $form->submit(__l('Update'));?>
    </div>
    <?php echo $form->end();?>
</div>
