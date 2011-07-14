<?php /* SVN: $Id: admin_add.ctp 40719 2011-01-10 09:27:33Z josephine_065at09 $ */ ?>
<div class="userComments form">
<?php echo $form->create('UserComment', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo __l('Add User Comment');?></h2>
	<?php
		echo $form->input('user_id',array('label' => __l('User')));
		echo $form->input('posted_user_id',array('label' => __l('Posted User')));
		echo $form->input('comment',array('label' => __l('Comment')));
	?>
	</fieldset>
    <div class="submit-block clearfix">
    <?php echo $form->submit(__l('Add'));?>
    </div>
    <?php echo $form->end();?>
</div>
