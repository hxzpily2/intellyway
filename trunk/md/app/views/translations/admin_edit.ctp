<?php /* SVN: $Id: admin_edit.ctp 40719 2011-01-10 09:27:33Z josephine_065at09 $ */ ?>
<div class="translations form">
<?php echo $form->create('Translation', array('class' => 'normal'));?>
	<fieldset>
 		<legend><?php echo $html->link(__l('Translations'), array('action' => 'index'),array('title' => __l('Translations')));?> &raquo; <?php echo __l('Edit Translation');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('language_id');
		echo $form->input('key');
		echo $form->input('lang_text');
	?>
	</fieldset>
   <div class="submit-block clearfix">
            <?php
            	echo $form->submit(__l('Update'));
            ?>
            </div>
        <?php
        	echo $form->end(); ?>
</div>
