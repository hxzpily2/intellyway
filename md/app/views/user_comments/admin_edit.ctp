<?php /* SVN: $Id: admin_edit.ctp 40719 2011-01-10 09:27:33Z josephine_065at09 $ */ ?>
<div class="userComments form">
<?php echo $form->create('UserComment', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo __l('Edit User Comment');?></h2>
	<?php
		echo $form->input('id');
		echo $form->input('user_id',array('label' => __l('User')));
		echo $form->input('posted_user_id',array('label' => __l('Posted user')));
		echo $form->input('comment',array('label' => __l('Comment')));
	?>
	</fieldset>
 <div class="submit-block clearfix">
    <?php echo $form->submit(__l('Update'));?>
    </div>
    <?php echo $form->end();?>
</div>
