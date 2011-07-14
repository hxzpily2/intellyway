<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="userEducations index">
<h2><?php echo __l('User Educations');?></h2>
<?php echo $this->element('paging_counter');?>
<ol class="list" start="<?php echo $paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($userEducations)):

$i = 0;
foreach ($userEducations as $userEducation):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li<?php echo $class;?>>
		<p><?php echo $html->cInt($userEducation['UserEducation']['id']);?></p>
		<p><?php echo $html->cDateTime($userEducation['UserEducation']['created']);?></p>
		<p><?php echo $html->cDateTime($userEducation['UserEducation']['modified']);?></p>
		<p><?php echo $html->cText($userEducation['UserEducation']['education']);?></p>
		<p><?php echo $html->cBool($userEducation['UserEducation']['is_active']);?></p>
		<div class="actions"><?php echo $html->link(__l('Edit'), array('action'=>'edit', $userEducation['UserEducation']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $html->link(__l('Delete'), array('action'=>'delete', $userEducation['UserEducation']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<p class="notice"><?php echo __l('No User Educations available');?></p>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($userEducations)) {
    echo $this->element('paging_links');
}
?>
</div>
