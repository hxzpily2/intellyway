<?php /* SVN: $Id: admin_add.ctp 196 2009-05-25 14:59:50Z siva_43ag07 $ */ ?>
<div class="translations form">
	<h2><?php echo __l('Add New Language Variable');?></h2>
	<?php echo $form->create('Translation', array('class' => 'normal', 'action' => 'add_text'));
		echo $form->input('Translation.'.$lang_id.'.key');
		foreach ($languages as $lang_id => $lang_name) :
	?>
	<h4><?php echo $lang_name;?></h4>
	
	<?php	
		echo $form->input('Translation.'.$lang_id.'.lang_text');
		endforeach;
		?>
		<div class="submit-block  clearfix">
		<?php
		echo $form->submit(__l('Add'));
	?>
	<?php
		echo $form->end();
	?>
	</div>
</div>
