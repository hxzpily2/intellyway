<?php /* SVN: $Id: add.ctp 4730 2010-05-14 13:50:53Z mohanraj_109at09 $ */ ?>
<div class="companyAddresses form clearfix">
<?php echo $form->create('CompanyAddress', array('class' => 'normal js-company-map'));?>
	<fieldset class="form-block round-5">
	   <legend class="round-5"><?php echo __l('Address'); ?></legend>
		<?php
			echo $form->input('address1', array('id'=> 'CompanyAddress1'));
			echo $form->input('address2');
			echo $form->autocomplete('State.name', array('label' => __l('State'), 'acFieldKey' => 'State.id', 'acFields' => array('State.name'), 'acSearchFieldNames' => array('State.name'), 'maxlength' => '255'));
			echo $form->autocomplete('City.name', array('id'=> 'CityName','label' => __l('City'), 'acFieldKey' => 'City.id', 'acFields' => array('City.name'), 'acSearchFieldNames' => array('City.name'), 'maxlength' => '255'));
			echo $form->input('country_id', array('options' => $countries, 'empty' => __l('Please Select')));
			echo $form->input('phone');
			echo $form->input('zip');
			//echo $form->input('url');
			echo $form->input('url', array('label' => __l('URL'), 'info' => __l('eg. http://www.example.com')));
			echo $form->input('company_id', array('type' => 'hidden', 'value'=>$this->params['named']['company_id']));

		?>
	</fieldset>
	<fieldset class="form-block round-5">
		 <?php
				echo $form->input('latitude',array('type' => 'hidden','id'=>'latitude'));
				echo $form->input('longitude',array('type' => 'hidden','id'=>'longitude'));
		?>
		<legend class="round-5"><?php echo __l('Locate Yourself on Google Maps'); ?></legend>
			<div class="show-map">
				<div id="js-map-container"><?php echo __l('Please update address info to generate location Map'); ?></div>
			</div>
			
		<?php
			$map_zoom_level = !empty($this->data['Company']['map_zoom_level']) ? $this->data['Company']['map_zoom_level'] : Configure::read('GoogleMap.static_map_zoom_level');
			echo $form->input('Company.map_zoom_level',array('type' => 'hidden','value' => $map_zoom_level,'id'=>'zoomlevel'));
		?>
	</fieldset>
	<div class="submit-block clearfix">
        <?php echo $form->submit(__l('Update'));?>
    	<div class="cancel-block">
    	   <?php echo $html->link(__l('Cancel'), array('controller' => 'companies', 'action'=> 'edit', $this->data['Company']['id']), array('title' => __l('Cancel'),'class' => 'cancel-button'));?>
    	</div>
	</div>
	 <?php echo $form->end();?>
</div>
