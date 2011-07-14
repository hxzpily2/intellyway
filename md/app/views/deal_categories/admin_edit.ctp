<?php /* SVN: $Id: $ */ ?>
<div class="dealCategories form">
<?php echo $form->create('DealCategory', array('class' => 'normal'));?>
	<h2><?php echo __l('Edit Deal Subscription Category');?></h2>
	<?php
		echo $form->input('id');
		echo $form->input('name');
	?>
<?php echo $form->end(__l('Update'));?>
</div>
