<?php /* SVN: $Id: $ */ ?>
<div class="mailChimpLists index">
<h2><?php echo __l('Mail Chimp Lists');?></h2>
<?php echo $this->element('paging_counter');?>
<table class="list">
    <tr>
        <th class="actions"><?php echo __l('Actions');?></th>
        <th><?php echo $paginator->sort('id');?></th>
        <th><?php echo $paginator->sort('created');?></th>
        <th><?php echo $paginator->sort('modified');?></th>
        <th><?php echo $paginator->sort('city_id');?></th>
        <th><?php echo $paginator->sort('list_id');?></th>
    </tr>
<?php
if (!empty($mailChimpLists)):

$i = 0;
foreach ($mailChimpLists as $mailChimpList):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="actions"><span><?php echo $html->link(__l('Edit'), array('action' => 'edit', $mailChimpList['MailChimpList']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span> <span><?php echo $html->link(__l('Delete'), array('action' => 'delete', $mailChimpList['MailChimpList']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></td>
		<td><?php echo $html->cInt($mailChimpList['MailChimpList']['id']);?></td>
		<td><?php echo $html->cDateTime($mailChimpList['MailChimpList']['created']);?></td>
		<td><?php echo $html->cDateTime($mailChimpList['MailChimpList']['modified']);?></td>
		<td><?php echo $html->link($html->cText($mailChimpList['City']['name']), array('controller'=> 'cities', 'action'=>'view', $mailChimpList['City']['slug']), array('escape' => false));?></td>
		<td><?php echo $html->cText($mailChimpList['MailChimpList']['list_id']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="6" class="notice"><?php echo __l('No Mail Chimp Lists available');?></td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($mailChimpLists)) {
    echo $this->element('paging_links');
}
?>
</div>
