<?php /* SVN: $Id: admin_add.ctp 40719 2011-01-10 09:27:33Z josephine_065at09 $ */ ?>
<div class="translations form">
<h2><?php echo __l('Add New Translation');?></h2>
<?php echo $form->create('Translation', array('class' => 'normal'));?>
	<fieldset>
 		<h3><?php echo $html->link(__l('Translations'), array('action' => 'index'));?> &raquo; <?php echo __l('Add New Translation');?></h3>
	<?php
		echo $form->input('from_language', array('value' => __l('English'), 'disabled' => true));
		echo $form->input('language_id', array('label' => __l('To Language')));?>
        <div class="submit-block clearfix">
        <?php
		echo $form->submit('Manual Translate', array('name' => 'data[Translation][manualTranslate]'));
	?>
	</div>
    <div class="notice">
	<p><?php echo __l('Manual Translate: It will only populate site labels for selected new language. You need to manually enter all the equivalent translated label');?>
</div>
        <div class="submit-block clearfix">
		<?php
		echo $form->submit('Google Translate', array('name' => 'data[Translation][googleTranslate]'));
	?>
	</div>
    <div class="notice">
	<p><?php echo __l('Google Translate: It will automatically translate site labels into selected language with Google');?>
</div>
	</fieldset>
<?php echo $form->end();?>
</div>
