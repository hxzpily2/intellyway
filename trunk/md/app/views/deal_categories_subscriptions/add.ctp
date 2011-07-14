<?php /* SVN: $Id: $ */ ?>
<div class="dealCategoriesSubscriptions form">
<?php echo $form->create('DealCategoriesSubscription', array('class' => 'normal'));?>
	<fieldset>
 		<legend><?php echo $html->link(__l('Deal Categories Subscriptions'), array('action' => 'index'));?> &raquo; <?php echo __l('Add Deal Categories Subscription');?></legend>
	<?php
		echo $form->input('deal_category_id');
		echo $form->input('subscription_id');
	?>
	</fieldset>
<?php echo $form->end(__l('Add'));?>
</div>
