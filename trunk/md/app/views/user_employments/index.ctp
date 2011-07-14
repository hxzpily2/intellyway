<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="userEmployments index">
<h2><?php echo __l('User Employments');?></h2>
<?php echo $this->element('paging_counter');?>
<ol class="list" start="<?php echo $paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($userEmployments)):

$i = 0;
foreach ($userEmployments as $userEmployment):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li<?php echo $class;?>>
		<p><?php echo $html->cInt($userEmployment['UserEmployment']['id']);?></p>
		<p><?php echo $html->cDateTime($userEmployment['UserEmployment']['created']);?></p>
		<p><?php echo $html->cDateTime($userEmployment['UserEmployment']['modified']);?></p>
		<p><?php echo $html->cText($userEmployment['UserEmployment']['employment']);?></p>
		<p><?php echo $html->cBool($userEmployment['UserEmployment']['is_active']);?></p>
		<div class="actions"><?php echo $html->link(__l('Edit'), array('action'=>'edit', $userEmployment['UserEmployment']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $html->link(__l('Delete'), array('action'=>'delete', $userEmployment['UserEmployment']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<p class="notice"><?php echo __l('No User Employments available');?></p>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($userEmployments)) {
    echo $this->element('paging_links');
}
?>
</div>
