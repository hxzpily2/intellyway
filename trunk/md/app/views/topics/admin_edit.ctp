<?php /* SVN: $Id: admin_edit.ctp 40786 2011-01-10 13:00:28Z aravindan_111act10 $ */ ?>
<div class="topics form">
<?php echo $form->create('Topic', array('class' => 'normal'));?>
    <h2><?php echo sprintf(__l('Edit Topic')); ?></h2>
	<?php
		echo $form->input('id');
		echo $form->input('topic_type_id',array('label' => __l('Topic Type')));
		if($topic['Topic']['topic_type_id'] == ConstTopicType::DealTalk && !empty($topic['Deal']['name'])):
			echo $form->input('Deal.name',array('label' => __l('Deal Name'), 'readonly' => true, 'value' => $topic['Deal']['name']));
		endif;
		echo $form->input('name',array('label' => __l('Name')));
		echo $form->input('content',array('label' => __l('Content')));
	?>
   <div class="submit-block clearfix">
            <?php
            	echo $form->submit(__l('Update'));
            ?>
            </div>
        <?php
        	echo $form->end(); ?>
</div>
