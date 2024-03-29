<?php /* SVN: $Id: admin_index.ctp 42545 2011-01-27 12:37:27Z saranya_127act10 $ */ ?>
<div class="pages index">
<h2><?php echo __l('Pages');?></h2>
<div class="clearfix add-block1">
	<?php echo $html->link(__l('Add'), array('controller' => 'pages', 'action' => 'add'), array('class' => 'add','title' => __l('Add'))); ?>
</div>
<div class="staticpage index">
<?php echo $this->element('paging_counter');?>
<div class="overflow-block">
<table class="list">
    <tr>
        <th class="dl"><?php echo $paginator->sort(__l('Title'),'title');?></th>
        <th class="dl"><?php echo $paginator->sort(__l('Content'),'content');?></th>
    </tr>
<?php
if (!empty($pages)):

$i = 0;
foreach ($pages as $page):
	$class = null;
	if ($i++ % 2 == 0) :
		$class = ' class="altrow"';
    endif;
?>
	<tr<?php echo $class;?>>
		<td class="dl">
        <div class="actions-block">
            <div class="actions round-5-left">
                <span><?php echo $html->link(__l('View'), array('controller' => 'pages', 'action' => 'view', $page['Page']['slug']), array('class' => 'view', 'title' => __l('View')));?></span>
                <span><?php echo $html->link(__l('Edit'), array('action' => 'edit', $page['Page']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span>
                <span><?php echo $html->link(__l('Delete'), array('action' => 'delete', $page['Page']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
            </div>
        </div>
		<?php echo $html->cText($page['Page']['title']);?></td>
		<td class="dl"><?php echo $html->cText($html->truncate($html->cText($page['Page']['content'])));?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="17" class="notice"><?php echo __l('No Pages available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($pages)) :
    echo $this->element('paging_links');
endif;
?>

</div>
</div>
