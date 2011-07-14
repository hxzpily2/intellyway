<?php /* SVN: $Id: $ */ ?>
<?php 
		if(!empty($this->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<div class="dealCategories index js-response js-responses">
<h2><?php echo __l('Deal Subscription Categories');?></h2>
<?php echo $form->create('DealCategory' , array('type' => 'get', 'class' => 'normal search-form clearfix','action' => 'index')); ?>
		<?php echo $form->input('q', array('label' => __l('Keyword'))); ?>
		<?php echo $form->submit(__l('Search'));?>
	<?php echo $form->end(); ?>
	<div class="add-block">
            <?php echo $html->link(__l('Add'),array('controller'=>'deal_categories','action'=>'add'),array('class' => 'add', 'title' => __l('Add Category')));?>
        </div>
    <?php echo $form->create('DealCategory' , array('class' => 'normal js-ajax-form','action' => 'update')); ?>
    <?php echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url'])); ?>
    <?php echo $this->element('paging_counter');?>
<table class="list">
    <tr>
        <th><?php echo __l('Select'); ?></th>             
        <th><div class="js-pagination"><?php echo $paginator->sort('name');?></div></th>
		<th><div class="js-pagination"><?php echo $paginator->sort(__l('Added On'),'created');?></div></th>
    </tr>
<?php
if (!empty($dealCategories)):

$i = 0;
foreach ($dealCategories as $dealCategory):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="actions">
		<div class="actions-block">
			<div class="actions round-5-left">
						<span><?php echo $html->link(__l('Edit'), array('action' => 'edit', $dealCategory['DealCategory']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span> <span><?php echo $html->link(__l('Delete'), array('action' => 'delete', $dealCategory['DealCategory']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
		</div>
					</div>
					<?php echo $form->input('DealCategory.'.$dealCategory['DealCategory']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$dealCategory['DealCategory']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?>
		</td>		
		<td><?php echo $html->cText($dealCategory['DealCategory']['name']);?></td>
		<td><?php echo $html->cDateTimeHighlight($dealCategory['DealCategory']['created']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="5" class="notice"><?php echo __l('No Deal Categories available');?></td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($dealCategories)):
    ?>
	<div class="admin-select-block">
        <div>
            <?php echo __l('Select:'); ?>
            <?php echo $html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
            <?php echo $html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
        </div>
         <div class="admin-checkbox-button">
            <?php echo $form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
        </div>
         <div class="js-pagination">
            <?php echo $this->element('paging_links'); ?>
        </div>
        <div class = "hide">
            <?php echo $form->submit('Submit');  ?>
        </div>
        <?php
    echo $form->end();
endif;
?>
</div>
