<div>
	<?php if (!empty($myFriends)): ?>
		<ol class="deal-user-list">
			<?php foreach ($myFriends as $myFriend): ?>
			<li class="clearfix">
				<div class="company-list-image">
					<?php
						echo $html->showImage('UserAvatar', $myFriend['FriendUser']['Attachment'], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($myFriend['FriendUser']['username'], false)), 'title' => $html->cText($myFriend['FriendUser']['username'], false)));
                        ?>
                   </div>
                      <div class="company-list-content">
                        <?php 	echo $html->getUserLink($myFriend['FriendUser']);
					?>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>
	<?php else: ?>
        <p class="notice"><?php echo __l('No Friends Available');?></p>
    <?php endif ?>
</div>