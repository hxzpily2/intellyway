<?php /* SVN: $Id: $ */ ?>
<div class="dealCategories form">
<?php echo $form->create('DealCategory', array('class' => 'normal'));?>
	<fieldset>
 		<legend><?php echo $html->link(__l('Deal Subscription Categories'), array('action' => 'index'));?> &raquo; <?php echo __l('Add Deal Subscription Category');?></legend>
	<?php
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end(__l('Add'));?>
</div>
