<?php /* SVN: $Id: view.ctp 6866 2010-06-03 16:00:30Z senthilkumar_017ac09 $ */ ?>
<div class="userFriends view">
<h2><?php echo __l('User Friend');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cInt($userFriend['UserFriend']['id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Created');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cDateTime($userFriend['UserFriend']['created']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Modified');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cDateTime($userFriend['UserFriend']['modified']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('User');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->getUserLink($userFriend['User']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Friend User Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cInt($userFriend['UserFriend']['friend_user_id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Friend Status');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->link($html->cText($userFriend['FriendStatus']['name']), array('controller' => 'friend_statuses', 'action' => 'view', $userFriend['FriendStatus']['id']), array('escape' => false));?></dd>
	</dl>
</div>

