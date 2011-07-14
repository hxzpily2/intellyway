<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="userRelationships index">
<h2><?php echo __l('User Relationships');?></h2>
<?php echo $this->element('paging_counter');?>
<ol class="list" start="<?php echo $paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($userRelationships)):

$i = 0;
foreach ($userRelationships as $userRelationship):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li<?php echo $class;?>>
		<p><?php echo $html->cInt($userRelationship['UserRelationship']['id']);?></p>
		<p><?php echo $html->cDateTime($userRelationship['UserRelationship']['created']);?></p>
		<p><?php echo $html->cDateTime($userRelationship['UserRelationship']['modified']);?></p>
		<p><?php echo $html->cText($userRelationship['UserRelationship']['relationship']);?></p>
		<p><?php echo $html->cBool($userRelationship['UserRelationship']['is_active']);?></p>
		<div class="actions"><?php echo $html->link(__l('Edit'), array('action'=>'edit', $userRelationship['UserRelationship']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $html->link(__l('Delete'), array('action'=>'delete', $userRelationship['UserRelationship']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<p class="notice"><?php echo __l('No User Relationships available');?></p>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($userRelationships)) {
    echo $this->element('paging_links');
}
?>
</div>
