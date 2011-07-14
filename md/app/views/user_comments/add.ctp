<?php /* SVN: $Id: add.ctp 40929 2011-01-11 12:15:19Z ramkumar_136act10 $ */ ?>
<div class="userComments form js-ajax-form-container">
    <div class="userComments-add-block js-corner round-5">
        <?php echo $form->create('UserComment', array('class' => "normal comment-form clearfix js-comment-form {container:'js-ajax-form-container',responsecontainer:'js-responses'}"));?>
        	<fieldset>
        	<?php
        		echo $form->input('user_id', array('type' => 'hidden'));
        		echo $form->input('comment', array('type' => 'textarea','label' => __l('Comment')));
        	?>
        	</fieldset>
<div class="submit-block clearfix">
<?php
	echo $form->submit(__l('Add'));
?>
</div>
<?php
	echo $form->end();
?>
    </div>
</div>