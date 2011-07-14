<?php /* SVN: $Id: $ */ ?>
<div class="blockedUsers form">
<?php echo $form->create('BlockedUser', array('class' => 'normal'));?>
	<fieldset>
 		<legend><?php echo $html->link(__l('Blocked Users'), array('action' => 'index'));?> &raquo; <?php echo __l('Edit Blocked User');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('user_id',array('label' => __l('User')));
		echo $form->input('blocked_user_id',array('label' => __l('Blocked User')));
	?>
	</fieldset>
<?php echo $form->end(__l('Update'));?>
</div>
