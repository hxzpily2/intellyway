<?php /* SVN: $Id: $ */ ?>
<div class="userIncomeRanges form">
<?php echo $form->create('UserIncomeRange', array('class' => 'normal'));?>
	<fieldset>
 		<legend><?php echo $html->link(__l('User Income Ranges'), array('action' => 'index'));?> &raquo; <?php echo __l('Edit User Income Range');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('income');
		echo $form->input('is_active');
	?>
	</fieldset>
<?php echo $form->end(__l('Update'));?>
</div>
