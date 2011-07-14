<?php /* SVN: $Id: index.ctp 15559 2010-07-26 05:23:23Z sakthivel_135at10 $ */ ?>
<div class="userComments index js-response">
<h2>
<?php
if (!empty($username)):
    echo __l('Comments on ').$username;
else:
	echo __l('Comments');
endif;
?>
</h2>
<?php echo $this->element('paging_counter'); ?>
<ol class="commment-list clearfix js-comment-responses" start="<?php echo $paginator->counter(array('format' => '%start%')); ?>">
<?php
if (!empty($userComments)):
    foreach($userComments as $userComment):
?>
    <li class="list-row clearfix <?php echo $class;?>" id="comment-<?php echo $userComment['UserComment']['id']; ?>" >
	    <div class="avatar">
			<?php echo $html->getUserAvatarLink($userComment['PostedUser'], 'medium_thumb');?>                    
			<span class="comment-arrow"></span>
        </div>
		<div class="data round-5">
            <p> <?php echo $html->getUserLink($userComment['PostedUser']).' commented '.$time->timeAgoInWords($userComment['UserComment']['created']);?></p>
		  <?php echo $html->cText(nl2br($userComment['UserComment']['comment']));?>
		  <?php if ($user['User']['id'] == $auth->user('id') or $userComment['PostedUser']['id'] == $auth->user('id')) { ?>
        <div class="actions">
        	<?php echo $html->link(__l('Delete'), array('controller' => 'user_comments', 'action' => 'delete', $userComment['UserComment']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?>
		</div>
		<?php } ?>
		</div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<p  class="notice"><?php echo __l('No comments available'); ?></p>
	</li>
<?php
endif;
?>
</ol>
<div class="js-pagination">
<?php
if (!empty($userComments)) {
    echo $this->element('paging_links');
}
?>
</div>
</div>