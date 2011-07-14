<?php /* SVN: $Id: edit.ctp 6561 2010-06-02 12:32:45Z sreedevi_140ac10 $ */ ?>
<div class="topics form">
<?php echo $form->create('Topic', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo __l('Edit Topic');?></h2>
	<?php
		echo $form->input('id');
		echo $form->input('topic_type_id',array('label' => __l('Topic Type')));
		echo $form->input('city_id',array('label' => __l('City')));
		echo $form->input('deal_id',array('label' => __l('Deal')));
		echo $form->input('name',array('label' => __l('Name')));
		echo $form->input('content',array('label' => __l('Content')));		
	?>
	</fieldset>
<?php echo $form->end(__l('Update'));?>
</div>
