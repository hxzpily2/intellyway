<?php /* SVN: $Id: admin_index.ctp 13910 2010-07-16 14:34:46Z siva_063at09 $ */ ?>
	<?php 
		if(!empty($this->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<div class="userFriends index js-response">
<h2><?php echo __l('User Friends');?></h2>
<?php echo $form->create('UserFriend', array('type' => 'get', 'class' => 'normal', 'action'=>'index')); ?>
	<div class="filter-section">
		<div>
			<?php echo $form->autocomplete('User.username', array('label' => __l('User'), 'acFieldKey' => 'UserFriend.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));?>
			<?php echo $form->autocomplete('FriendUser.username', array('label' => __l('Friend User'), 'acFieldKey' => 'UserFriend.friend_user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));?>
            <?php echo $form->input('filter_id',array('label' => __l('Filter'),'empty' => __l('Please Select'))); ?>
            <?php echo $form->input('q', array('label' =>__l('Keyword'))); ?>
        </div>
		<div>
			<?php echo $form->submit(__l('Search'));?>
		</div>
	</div>
<?php echo $form->end(); ?>
<?php 
	echo $form->create('UserFriend' , array('class' => 'normal','action' => 'update'));
	echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url']));
	
?>
<?php echo $this->element('paging_counter');?>
<table class="list">
    <tr>
    	<th><?php echo __l('Select'); ?></th>
        
        <th><?php echo $paginator->sort(__l('User'), 'User.username');?></th>
        <th><?php echo $paginator->sort(__l('Friend User'), 'FriendUser.username');?></th>
        <th><?php echo __l('Friends Status');?></th>
        <th><?php echo __l('Request');?></th>
    </tr>
<?php
if (!empty($userFriends)):

$i = 0;
foreach ($userFriends as $userFriend):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
    	<td>
		 <div class="actions-block">
            <div class="actions round-5-left">
            <span><?php echo $html->link(__l('Delete'), array('action' => 'delete', $userFriend['UserFriend']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>                   
			</div>
          </div>
            <?php echo $form->input('UserFriend.'.$userFriend['UserFriend']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userFriend['UserFriend']['id'], 'label' => false, 'class' => ' js-checkbox-list')); ?>
		</td>
		
		<td><?php echo $html->getUserLink($userFriend['User']);?></td>
		<td><?php echo $html->getUserLink($userFriend['FriendUser']);?></td>
		<td><?php echo $html->cText($userFriend['FriendStatus']['name']);?></td>
		<td><?php echo $html->cBool($userFriend['UserFriend']['is_requested']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="8" class="notice"><?php echo __l('No User Friends available');?></td>
	</tr>
<?php
endif;
?>
</table>
<?php
if (!empty($userFriends)):
?>
	<div>
		<?php echo __l('Select:'); ?>
		<?php echo $html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
		<?php echo $html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
	</div>
	<div class="js-pagination">
        <?php echo $this->element('paging_links'); ?>
    </div>
	<div class="admin-checkbox-button"><?php echo $form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
    <div class="hide">
	    <?php echo $form->submit('Submit'); ?>
    </div>
<?php
endif;
echo $form->end();
?>
</div>
