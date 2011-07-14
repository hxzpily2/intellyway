<?php /* SVN: $Id: admin_edit.ctp 41708 2011-01-19 13:49:31Z anandam_023ac09 $ */ ?>
<div class="cities form">
	<div>
		<h2><?php echo __l('Edit City - ').$html->cText($this->data['City']['name'], false); ?></h2>
	</div>
	<div>
	<?php
		echo $form->create('City', array('class' => 'normal','action'=>'edit','enctype' => 'multipart/form-data'));
		echo $form->input('id');
   ?>
   <?php
		if (!empty($id_default_city)) {
			echo $form->input('name',array('label' => __l('Name'), 'readonly' => true, 'info' => __l('You can not change default city name.')));
		} else {
			echo $form->input('name',array('label' => __l('Name')));
		}
		echo $form->input('country_id', array('label' => __l('Country'), 'empty' => __l('Please Select')));
		echo $form->input('state_id', array('label' => __l('State'), 'empty' => __l('Please Select')));
		echo $form->input('language_id', array('label' => __l('Default Language'),'empty'=>'Please Select','info' => __l('select the default language for this city. If not selected, Site default language will be set.')));
		echo $form->input('latitude',array('label' => __l('Latitude')));
		echo $form->input('longitude',array('label' => __l('Longitude')));
		echo $form->input('code',array('label' => __l('Code')));
	?>
	<fieldset class="form-block round-5">
		<legend class="round-5"><?php echo __l('Facebook Details'); ?></legend>
		<?php echo $form->input('facebook_url',array('label' =>__l('Facebook URL'))); ?>
	</fieldset>
	<fieldset class="form-block round-5">
		<legend class="round-5"><?php echo __l('Twitter Details'); ?></legend>
		<?php
			echo $form->input('twitter_url',array('label' =>__l('Twitter URL')));
			if(Configure::read('site.city') != $this->data['City']['slug']):
				echo $form->input('is_approved', array('label' =>__l('Approved?')));
			endif;
		?>
	</fieldset>
	<div>
	<?php
	 if(!empty($this->data['Attachment']['id'])):
	      
		  echo $form->input('OldAttachment.id',array('type' => 'checkbox', 'label' => __l('Delete?')));
		  echo $form->input('Attachment.id',array('type' => 'hidden', 'value' => $this->data['Attachment']['id']));
		  echo $html->showImage('City', $this->data['Attachment'], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($this->data['City']['name'], false)), 'title' => $html->cText($this->data['City']['name'], false)));
	 endif;
	?>
	</div>
	<div>
        <?php
    	   	echo $form->input('Attachment.filename', array('type' => 'file', 'label' => __l('City Image')));
	   	?>
	   	</div>
	<div class="submit-block">
		<?php echo $form->submit(__l('Update'));	?>
	</div>
	<?php echo $form->end(); ?>
	</div>
</div>