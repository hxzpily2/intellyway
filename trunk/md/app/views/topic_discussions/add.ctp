<?php /* SVN: $Id: add.ctp 40719 2011-01-10 09:27:33Z josephine_065at09 $ */ ?>
<div class="topicDiscussions form js-ajax-form-container">
<h2><?php echo __l('Comment'); ?></h2>



<?php echo $form->create('TopicDiscussion', array('class' => "normal js-comment-form {container:'js-ajax-form-container',responsecontainer:'js-responses'}"));?>
	<fieldset>
	
	<div class="input text">
        <label><?php echo __l('Author'); ?></label>
        <div class="fromleft">
        <?php 
			$user_details = array(
				'username' => $user['User']['username'],
				'user_type_id' =>  $user['User']['user_type_id'],
				'id' =>  $user['User']['id'],
				'UserAvatar' => $user['UserAvatar']
			);
		echo $html->getUserAvatarLink($user_details, 'micro_thumb').' ';
		echo (!empty($user['Company']['name'])) ? $user['Company']['name'] : $user['User']['username'];?>
        </div>
    </div>
	<?php
		echo $form->input('topic_id', array('type' => 'hidden'));
		 if(empty($this->data['TopicDiscussion']['follow']))
            {
		      echo $form->input('follow', array('type' => 'checkbox', 'label' => __l('Follow this topic by email')));
		    }
		echo $form->input('comment',array('label' => __l('Comment')));
		
	?>
	</fieldset>
   <div class="submit-block clearfix">
            <?php
            	echo $form->submit(__l('Post your comment'));
            ?>
            </div>
        <?php
        	echo $form->end(); ?>
</div>
