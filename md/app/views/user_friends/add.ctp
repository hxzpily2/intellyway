<?php /* SVN: $Id: add.ctp 6392 2010-06-01 12:42:41Z subingeorge_082at09 $ */ ?>
<?php
	echo $html->link(__l('Remove Friend'), array('controller' => 'user_friends', 'action' => 'remove', $username,'sent'), array('class' => 'delete js-add-friend','title' => __l('Remove Friend')));
?>
