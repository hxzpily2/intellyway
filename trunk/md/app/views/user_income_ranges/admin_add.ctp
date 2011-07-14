<?php /* SVN: $Id: $ */ ?>
<div class="userIncomeRanges form">
<?php echo $form->create('UserIncomeRange', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo __l('Add User Income Range');?></h2>
	<?php
		echo $form->input('income');
		echo $form->input('is_active');
	?>
	</fieldset>
   <div class="submit-block clearfix">
    <?php echo $form->submit(__l('Add'));?>
    </div>
    <?php echo $form->end();?>
</div>
