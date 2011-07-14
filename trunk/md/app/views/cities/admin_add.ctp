<?php /* SVN: $Id: admin_add.ctp 42099 2011-01-22 04:35:32Z usha_111at09 $ */ ?>
<div class="cities form">
	<div>
		<h2><?php echo __l('Add Cities');?></h2>
	</div>
	<div>
		<?php echo $form->create('City', array('class' => 'normal','action'=>'add', 'enctype' => 'multipart/form-data'));?>
		<?php
			echo $form->input('country_id', array('label' => __l('Country'),'empty'=>'Please Select'));
			echo $form->input('state_id', array('label' => __l('State'),'empty'=>'Please Select'));
			echo $form->input('language_id', array('label' => __l('Default Language'),'empty'=>'Please Select','info' => __l('select the default language for this city. If not selected, Site default language will be set.')));
			echo $form->input('name',array('label' => __l('Name')));
			echo $form->input('latitude',array('label' => __l('Latitude')));
			echo $form->input('longitude',array('label' => __l('Longitude')));
			echo $form->input('code',array('label' => __l('Code')));?>
			 <fieldset class="form-block round-5">
                <legend class="round-5"><?php echo __l('Facebook Details'); ?></legend>
    			<?php
        			echo $form->input('facebook_url',array('label' =>__l('Facebook URL')));
                ?>
              </fieldset>
              <fieldset class="form-block round-5">
                <legend class="round-5"><?php echo __l('Twitter Details'); ?></legend>
                <?php
        			echo $form->input('twitter_url',array('label' =>__l('Twitter URL')));
                ?>
              </fieldset>
	    <div>
        <?php
    	   	echo $form->input('Attachment.filename', array('type' => 'file', 'label' => __l('City Image')));
	   	?>
	   	</div>
		<div class="submit-block">
		<?php echo $form->submit(__l('Add'));?>
		</div>
		<?php echo $form->end(); ?>
	</div>
</div>