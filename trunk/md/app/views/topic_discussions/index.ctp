<?php /* SVN: $Id: index.ctp 40786 2011-01-10 13:00:28Z aravindan_111act10 $ */ ?>
<div class="topicDiscussions index">
<h2><?php echo $html->cText($pageTitle);?></h2>
<div class="add-block">
<?php if(!empty($follow_topic_id)){ ?>
    <?php echo $html->link(__l('Unfollow Topics'), array('controller' => 'topics_users', 'action'=>'delete', $follow_topic_id), array('class' => 'add', 'title' => __l('UnFollow')));?>
 <?php }else{ ?>
    <?php echo $html->link(__l('Follow  Topics'), array('controller' => 'topics_users', 'action'=>'add',$this->data['TopicDiscussion']['topic_id']), array('class' => 'add', 'title' => __l('Follow')));?>
<?php } ?>
</div>
<?php echo $this->element('paging_counter');?>
<ol class="commment-list clearfix js-comment-responses" >
<?php
if (!empty($topicDiscussions)):

$i = 0;
foreach ($topicDiscussions as $topicDiscussion):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = 'altrow';
	}
?>
	<li class="list-row clearfix <?php echo $class;?>">
	    <div class="avatar">
        	<?php echo $html->getUserAvatarLink($topicDiscussion['User'], 'medium_thumb');?>
			<span class="comment-arrow">&nbsp;</span>
        </div>
		<div class="data round-5">
            <p> <?php echo $html->getUserLink($topicDiscussion['User']).' commented '.$time->timeAgoInWords(_formatDate($topicDiscussion['TopicDiscussion']['created']));?></p>
		  <?php echo $html->cText($topicDiscussion['TopicDiscussion']['comment']);?>
		</div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
        	<p class="notice"><?php echo __l('No Topic Discussions available');?></p>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($topicDiscussions)) {
    echo $this->element('paging_links');
}
?>
<div>
        <?php
			if($auth->user('id')):
				echo $this->element('../topic_discussions/add', array('cache' => array('time' => Configure::read('site.element_cache'))));
			endif;		
		 ?>
</div>
</div>
