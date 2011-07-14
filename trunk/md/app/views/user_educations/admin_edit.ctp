<?php /* SVN: $Id: $ */ ?>
<div class="userEducations form">
<?php echo $form->create('UserEducation', array('class' => 'normal'));?>
	<fieldset>
 		<h2> <?php echo __l('Edit User Education');?></h2>
	<?php
		echo $form->input('id');
		echo $form->input('education');
		echo $form->input('is_active');
	?>
	</fieldset>
    <div class="submit-block clearfix">
    <?php echo $form->submit(__l('Update'));?>
    </div>
    <?php echo $form->end();?>
</div>
