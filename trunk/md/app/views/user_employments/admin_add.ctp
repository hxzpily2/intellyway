<?php /* SVN: $Id: $ */ ?>
<div class="userEmployments form">
<?php echo $form->create('UserEmployment', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo __l('Add User Employment');?></h2>
	<?php
		echo $form->input('employment');
		echo $form->input('is_active');
	?>
	</fieldset>
     <div class="submit-block clearfix">
    <?php echo $form->submit(__l('Add'));?>
    </div>
    <?php echo $form->end();?>
</div>
