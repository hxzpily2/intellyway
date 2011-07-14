<?php /* SVN: $Id: $ */ ?>
<div class="mailChimpLists form">
<?php echo $form->create('MailChimpList', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo __l('Edit Mail Chimp List');?></h2>
	<?php
		echo $form->input('id');
		echo $form->input('city_id');
		echo $form->input('list_id');
	?>
	</fieldset>
<?php echo $form->end(__l('Update'));?>
</div>
