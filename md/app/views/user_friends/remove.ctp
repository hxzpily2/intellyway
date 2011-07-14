<?php /* SVN: $Id: remove.ctp 6393 2010-06-01 12:43:01Z subingeorge_082at09 $ */ ?>
<?php
	echo $html->link(__l('Add as Friend'), array('controller' => 'user_friends', 'action' => 'add', $username), array('class' => 'add add-friend js-add-friend','title' => __l('Remove Friend')));
?>
