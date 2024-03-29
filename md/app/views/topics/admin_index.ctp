<?php /* SVN: $Id: admin_index.ctp 42544 2011-01-27 12:37:07Z saranya_127act10 $ */ ?>
	<?php 
		if(!empty($this->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<?php if(empty($this->params['named']['type']) && empty($this->params['named']['deal_id'])): ?>
	<div class="js-tabs">
        <ul class="clearfix">
                <li><?php echo $html->link(__l('All'), array('controller' => 'topics', 'action' => 'index', 'type' => 'all'), array('title' => __l('All')));?></li>
                <?php foreach($topicTypes as $topicType){ ?>
                    <?php if($topicType['TopicType']['id'] == ConstTopicType::CityTalk) { ?>
                        <li><?php echo $html->link(__l('City Talk'), array('controller' => 'topics', 'action' => 'index', 'type' => $topicType['TopicType']['slug']), array('title' => __l('City Talk')));?></li>
                    <?php } elseif($topicType['TopicType']['id'] == ConstTopicType::GlobalTalk) {?>
                      <li><?php echo $html->link(sprintf(__l('%s'),Configure::read('site.name').' Global') , array('controller' => 'topics', 'action' => 'index', 'type' => $topicType['TopicType']['slug']), array('title' => sprintf(__l('%s'),$topicType['TopicType']['name'])));?></li>
                    <?php } else { ?>
                        <li><?php echo $html->link(sprintf(__l('%s'),$topicType['TopicType']['name']), array('controller' => 'topics', 'action' => 'index', 'type' => $topicType['TopicType']['slug']), array('title' =>  sprintf(__l('%s'),$topicType['TopicType']['name'])));?></li>
                    <?php } ?>
                <?php }?>
        </ul>
    </div>
<?php else: ?>
<div class="topics index js-response js-responses js-search-responses">
<h2><?php echo $pageTitle;?></h2>
<?php   echo $form->create('Topic' , array('class' => 'normal js-ajax-form','action' => 'update')); ?>
<?php echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url'])); ?>
<?php echo $this->element('paging_counter');?>
<div class="overflow-block">
<table class="list">
    <tr>
        <th><?php echo __l('Select'); ?></th>
        <?php if(empty($this->params['named']['deal_id'])): ?>
            <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Type'), 'TopicType.name');?></div></th>
            <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Deal'), 'Deal.name');?></div></th>
        <?php endif; ?>
        <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('City'), 'City.name');?></div></th>
        <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Name'), 'Topic.name');?></div></th>
        <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Content'), 'Topic.content');?></div></th>
        <th><div class="js-pagination"><?php echo $paginator->sort(__l('Posted On'), 'Topic.created');?></div></th>
        <th><div class="js-pagination"><?php echo $paginator->sort(__l('Topic Discussion Count'), 'Topic.topic_discussion_count');?></div></th>
        <th><div class="js-pagination"><?php echo $paginator->sort(__l('Last Replied On'), 'Topic.last_replied_time');?></div></th>
        
    </tr>
<?php
if (!empty($topics)):

$i = 0;
foreach ($topics as $topic):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
        <td>
            <div class="actions-block">
    			<div class="actions round-5-left">
    				<span><?php echo $html->link(__l('Edit'), array('action' => 'edit', $topic['Topic']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span>
    				<span><?php echo $html->link(__l('Delete'), array('action' => 'delete', $topic['Topic']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
    			</div>
    		</div>
            <?php echo $form->input('Topic.'.$topic['Topic']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$topic['Topic']['id'], 'label' => false, 'class' =>' js-checkbox-list')); ?>
        </td>
        <?php if(empty($this->params['named']['deal_id'])): ?>
            <td class="dl">
            <?php
			   echo $html->cText($topic['TopicType']['name']);
			 ?>
            </td>
            <td class="dl"><?php echo $html->link($html->cText($topic['Deal']['name']), array('controller'=> 'deals', 'action'=>'view', $topic['Deal']['slug'],'admin' => false), array('title'=>$html->cText($topic['Deal']['name'], false),'escape' => false));?></td>
        <?php endif; ?>
		<td class="dl"><?php echo $html->cText($topic['City']['name']);?></td>
		<td><?php echo $html->link($html->cText($topic['Topic']['name'], false),array('controller'=>'topic_discussions', 'action'=>'index', 'topic_id'=>$topic['Topic']['id']),array('title'=>$html->cText($topic['Topic']['name'], false)));?></td>
		<td class="dl"><div class="js-truncate"><?php echo $html->cText($topic['Topic']['content']);?></div></td>
		<td><?php echo $html->cDateTime($topic['Topic']['created']);?></td>
        <td><?php echo $html->link($html->cInt($topic['Topic']['topic_discussion_count'], false),array('controller'=>'topic_discussions', 'action'=>'index', 'topic_id'=>$topic['Topic']['id']),array('title'=>$html->cInt($topic['Topic']['topic_discussion_count'], false)));?></td>
		<td><?php if(empty($topic['Topic']['last_replied_time'])){
                    echo 'N/A';
                }else{
                echo $html->cDateTime($topic['Topic']['last_replied_time']);
                }?></td>

		</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="12" class="notice"><?php echo __l('No Topics available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($topics)) {?>
      <div class="admin-select-block">
            <div>
                <?php echo __l('Select:'); ?>
                <?php echo $html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
                <?php echo $html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
            </div>
            <div class="admin-checkbox-button"><?php echo $form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
        </div>
        <div class="hide">
            <?php echo $form->submit('Submit'); ?>
        </div>
		<div class="js-pagination">
			<?php     echo $this->element('paging_links');?>
		</div>
<?php
}
?>
<?php echo $form->end(); ?>
</div>
<?php endif; ?>
