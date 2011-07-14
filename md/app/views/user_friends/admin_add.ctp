<?php /* SVN: $Id: $ */ ?>
<div class="userFriends form">
<?php echo $form->create('UserFriend', array('class' => 'normal'));?>
	<fieldset>
 		<legend><?php echo $html->link(__l('User Friends'), array('action' => 'index'), array('title' => __l('User Friends')));?> &raquo; <?php echo __l('Add User Friend');?></legend>
	<?php
		echo $form->input('user_id',array('label' => __l('User')));
		echo $form->input('friend_user_id',array('label' => __l('Friend User')));
		echo $form->input('friend_status_id',array('label' => __l('Friend Status')));
	?>
	</fieldset>
<?php echo $form->end(__l('Add'));?>
</div>
