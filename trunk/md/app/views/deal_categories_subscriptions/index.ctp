<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="dealCategoriesSubscriptions index">
<h2><?php echo __l('Deal Categories Subscriptions');?></h2>
<?php echo $this->element('paging_counter');?>
<ol class="list" start="<?php echo $paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($dealCategoriesSubscriptions)):

$i = 0;
foreach ($dealCategoriesSubscriptions as $dealCategoriesSubscription):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li<?php echo $class;?>>
		<p><?php echo $html->cInt($dealCategoriesSubscription['DealCategoriesSubscription']['id']);?></p>
		<p><?php echo $html->cInt($dealCategoriesSubscription['DealCategoriesSubscription']['deal_category_id']);?></p>
		<p><?php echo $html->cInt($dealCategoriesSubscription['DealCategoriesSubscription']['subscription_id']);?></p>
		<div class="actions"><?php echo $html->link(__l('Edit'), array('action'=>'edit', $dealCategoriesSubscription['DealCategoriesSubscription']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $html->link(__l('Delete'), array('action'=>'delete', $dealCategoriesSubscription['DealCategoriesSubscription']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<p class="notice"><?php echo __l('No Deal Categories Subscriptions available');?></p>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($dealCategoriesSubscriptions)) {
    echo $this->element('paging_links');
}
?>
</div>
