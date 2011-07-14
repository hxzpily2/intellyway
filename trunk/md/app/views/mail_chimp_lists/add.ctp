<?php /* SVN: $Id: $ */ ?>
<div class="mailChimpLists form">
<?php echo $form->create('MailChimpList', array('class' => 'normal'));?>
	<fieldset>
 		<legend><?php echo $html->link(__l('Mail Chimp Lists'), array('action' => 'index'));?> &raquo; <?php echo __l('Add Mail Chimp List');?></legend>
	<?php
		echo $form->input('city_id');
		echo $form->input('list_id');
	?>
	</fieldset>
	<div class="submit-block clearfix">
<?php echo $form->end(__l('Add'));?>
</div>
</div>
