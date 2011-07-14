<?php /* SVN: $Id: $ */ ?>
<div class="mailChimpLists form">
<?php echo $form->create('MailChimpList', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo __l('Add Mail Chimp List');?></h2>
	<?php
		echo $form->input('city_id');
		echo $form->input('list_id');
	?>
	</fieldset>
		<div class="submit-block clearfix">
<?php echo $form->end(__l('Add'));?>
</div>
</div>
