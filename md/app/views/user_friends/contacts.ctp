<div class="messages contacts">
<div class="main-content-block js-corner round-5">
<h2><?php echo __l('Contacts'); ?></h2>
<div class="form-blocks js-corner round-5">
<?php echo $form->create('UserFriend', array('controller' => 'user_friends' , 'action' => 'contacts' , 'class' => 'normal'));?>
<?php echo $form->input('search',array('label' => __l('Search'))); ?>
<?php echo $form->submit(__l('Search'));?>
<?php echo $form->end();?>
</div>
<div class=" message-list">
<ol class="list">
<?php if (!empty($contacts)) { ?>
<?php
$i = 0;
$class = null;
if ($i++ % 2 == 0) {
	$class = ' class="altrow"';
}
foreach($contacts as $contact) { ?>
<li class="list-row clearfix">
	<div class="avatar">
	<?php echo $html->getUserAvatarLink($contact['FriendUser'], 'medium_thumb');?>        
</div>
	<div class="data"><?php echo $html->getUserLink($contact['FriendUser']); ?></div>
</li>
<?php }
} else { ?>
    <li class="notice"><p class="notice"><?php echo __l('No user contacts available.');?></p></li>
<?php } ?>
</ol>
</div>
</div>
</div>

