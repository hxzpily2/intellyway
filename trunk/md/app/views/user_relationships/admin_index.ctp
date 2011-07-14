<?php /* SVN: $Id: $ */ ?>
<div class="userRelationships index">
<h2><?php echo __l('User Relationships');?></h2>
<div class="add-block"><?php echo $html->link(__l('Add'), array('controller' => 'user_relationships', 'action' => 'add'), array('class' => 'add','title'=>__l('Add'))); ?></div>
<?php echo $this->element('paging_counter');?>
<table class="list">
    <tr>
        <th class="actions"><?php echo __l('Actions');?></th>
       <th><?php echo $paginator->sort('relationship');?></th>
        <th><?php echo $paginator->sort('is_active');?></th>
    </tr>
<?php
if (!empty($userRelationships)):

$i = 0;
foreach ($userRelationships as $userRelationship):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="actions"><span><?php echo $html->link(__l('Edit'), array('action' => 'edit', $userRelationship['UserRelationship']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span> <span><?php echo $html->link(__l('Delete'), array('action' => 'delete', $userRelationship['UserRelationship']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></td>
		<td><?php echo $html->cText($userRelationship['UserRelationship']['relationship']);?></td>
		<td><?php echo $html->cBool($userRelationship['UserRelationship']['is_active']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="6" class="notice"><?php echo __l('No User Relationships available');?></td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($userRelationships)) {
    echo $this->element('paging_links');
}
?>
</div>
