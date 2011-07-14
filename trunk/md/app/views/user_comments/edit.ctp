<?php /* SVN: $Id: edit.ctp 37 2010-04-07 07:39:04Z aravindan_111act10 $ */ ?>
<div class="userComments form">
<?php echo $form->create('UserComment', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo __l('Edit User Comment');?></h2>
	<?php
		echo $form->input('id');
		echo $form->input('user_id');
		echo $form->input('posted_user_id');
		echo $form->input('comment');
	?>
	</fieldset>
<?php echo $form->end(__l('Update'));?>
</div>
