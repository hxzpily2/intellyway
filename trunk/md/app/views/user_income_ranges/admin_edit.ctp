<?php /* SVN: $Id: $ */ ?>
<div class="userIncomeRanges form">
<?php echo $form->create('UserIncomeRange', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo $html->link(__l('User Income Ranges'), array('action' => 'index'));?> &raquo; <?php echo __l('Edit User Income Range');?></h2>
	<?php
		echo $form->input('id');
		echo $form->input('income');
		echo $form->input('is_active');
	?>
	</fieldset>
  <div class="submit-block clearfix">
    <?php echo $form->submit(__l('Update'));?>
    </div>
    <?php echo $form->end();?>
</div>
