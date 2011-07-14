<?php /* SVN: $Id: admin_edit.ctp 40719 2011-01-10 09:27:33Z josephine_065at09 $ */ ?>
<div class="topicDiscussions form">
<?php echo $form->create('TopicDiscussion', array('class' => 'normal'));?>
    <h2><?php echo sprintf(__l('Edit Topic Discussion')); ?></h2>
    <h3><?php echo __l('Topic: ').$html->cText($topic['Topic']['name']); ?></h3>
	<?php
		echo $form->input('id');
		echo $form->input('comment',array('label' => __l('Comment')));
	?>
   <div class="submit-block clearfix">
            <?php
            	echo $form->submit(__l('Update'));
            ?>
            </div>
        <?php
        	echo $form->end(); ?>
</div>
