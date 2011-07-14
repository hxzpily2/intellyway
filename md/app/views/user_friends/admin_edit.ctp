<?php /* SVN: $Id: $ */ ?>
<div class="userFriends form">
<?php echo $form->create('UserFriend', array('class' => 'normal'));?>
	<fieldset>
 		<legend><?php echo $html->link(__l('User Friends'), array('action' => 'index'), array('title' => __l('User Friends')));?> &raquo; <?php echo __l('Edit User Friend');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('user_id');
		echo $form->input('friend_user_id');
		echo $form->input('friend_status_id');
	?>
	</fieldset>
<?php echo $form->end(__l('Update'));?>
</div>
