<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="userIncomeRanges index">
<h2><?php echo __l('User Income Ranges');?></h2>
<?php echo $this->element('paging_counter');?>
<ol class="list" start="<?php echo $paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($userIncomeRanges)):

$i = 0;
foreach ($userIncomeRanges as $userIncomeRange):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li<?php echo $class;?>>
		<p><?php echo $html->cInt($userIncomeRange['UserIncomeRange']['id']);?></p>
		<p><?php echo $html->cDateTime($userIncomeRange['UserIncomeRange']['created']);?></p>
		<p><?php echo $html->cDateTime($userIncomeRange['UserIncomeRange']['modified']);?></p>
		<p><?php echo $html->cText($userIncomeRange['UserIncomeRange']['income']);?></p>
		<p><?php echo $html->cBool($userIncomeRange['UserIncomeRange']['is_active']);?></p>
		<div class="actions"><?php echo $html->link(__l('Edit'), array('action'=>'edit', $userIncomeRange['UserIncomeRange']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $html->link(__l('Delete'), array('action'=>'delete', $userIncomeRange['UserIncomeRange']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<p class="notice"><?php echo __l('No User Income Ranges available');?></p>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($userIncomeRanges)) {
    echo $this->element('paging_links');
}
?>
</div>
