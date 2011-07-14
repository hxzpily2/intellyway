<?php /* SVN: $Id: edit.ctp 6550 2010-06-02 12:13:00Z sreedevi_140ac10 $ */ ?>
<div class="userFriends form">
<?php echo $form->create('UserFriend', array('class' => 'normal'));?>
	<fieldset>
 		<legend><?php echo $html->link(__l('User Friends'), array('action' => 'index'));?> &raquo; <?php echo __l('Edit User Friend');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('user_id',array('label' => __l('User')));
		echo $form->input('friend_user_id',array('label' => __l('Friend User')));
		echo $form->input('friend_status_id',array('label' => __l('Friend Status')));
	?>
	</fieldset>
<?php echo $form->end(__l('Update'));?>
</div>
