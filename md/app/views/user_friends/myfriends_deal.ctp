<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="userFriends index js-response">


<?php
if (!empty($userFriends)) {?>
<?php echo $form->create('UserFriend',array('class' => 'normal','action' => 'deal_invite')); ?>
<ol class="friends clearfix " start="<?php echo $paginator->counter(array('format' => '%start%')); ?>">
<?php foreach ($userFriends as $userFriend) {
?>
	<li id="friend-<?php echo $userFriend['UserFriend']['id']; ?>" class="friend">
    	<?php echo $html->getUserAvatarLink($userFriend['FriendUser'], 'medium_thumb');?>          
		<?php echo $html->link($userFriend['FriendUser']['username'], array('controller' => 'users', 'action' => 'view', $userFriend['FriendUser']['username']), array('title' => $userFriend['FriendUser']['username']));?>
		<?php echo $form->input('UserFriend.'.$userFriend['FriendUser']['id'].'.id',array('type' => 'checkbox', 'id' => "admin_checkbox_".$userFriend['FriendUser']['id'],'label' => false));?>
	</li>
<?php
    } ?>
	<?php echo $form->input('deal_slug',array('type' => 'hidden', 'label' => false));?>
</ol>
 <?php
	echo $form->submit(__l('Invite to deal'));  
	echo $form->end(); 
 }
else {
?>
<div>
		<p class="notice"><?php echo __l('No friends available'); ?></p>
</div>

<?php
 	}
?>

<?php
if (!empty($userFriends) and $total_friends > 12) {
	?>
	 <div class="js-pagination">
    <?php echo $this->element('paging_links'); ?>
	</div>
	<?php
}
?>
</div>