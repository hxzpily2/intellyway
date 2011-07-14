<li class="list-row clearfix">
	    <div class="avatar">
        	<?php echo $html->getUserAvatarLink($topicDiscussion['User'], 'medium_thumb');?>
			<span class="comment-arrow">&nbsp;</span>
        </div>
		<div class="data round-5">
            <p> <?php echo $html->getUserLink($topicDiscussion['User']).' commented '.$time->timeAgoInWords($topicDiscussion['TopicDiscussion']['created']);?></p>
		  <?php echo $html->cText($topicDiscussion['TopicDiscussion']['comment']);?>
		</div>
	</li>