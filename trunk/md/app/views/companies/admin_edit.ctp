<?php /* SVN: $Id: admin_edit.ctp 44735 2011-02-19 07:44:54Z usha_111at09 $ */ ?>
<?php echo $this->element('js_tiny_mce_setting', array('cache' => array('time' => Configure::read('site.element_cache'))));?>
<div class="companies form clearfix js-responses js-response">
	<h2><?php echo __l('Edit Company');?></h2>
	<?php
		echo $form->create('Company', array('class' => 'normal js-company-map'));
		echo $form->input('id');
	?>
	<fieldset class="form-block round-5">
			<legend class="round-5"><?php echo __l('Account'); ?></legend>
	<?php
		echo $form->input('name',array('label' => __l('Name')));
		echo $form->input('phone',array('label' => __l('Phone')));
		echo $form->input('url',array('label' => __l('URL'), 'info' => __l('eg. http://www.example.com')));
		echo $form->input('User.email',array('label' => __l('Email')));
		echo $form->input('is_online_account',array('label' =>__l('Online Account'), 'info' => __l('Only online company can login and make payment via site. Offline company can process manually. ')));
	?>
	</fieldset>
	<fieldset class="form-block round-5">
			<legend class="round-5"><?php echo __l('Address'); ?></legend>
	<?php
		echo $form->input('address1',array('label' => __l('Address1')));
		echo $form->input('address2',array('label' => __l('Address2')));
		
		echo $form->input('country_id',array('label' => __l('Country'),'empty' => 'Please Select'));
		echo $form->autocomplete('State.name', array('label' => __l('State'), 'acFieldKey' => 'State.id', 'acFields' => array('State.name'), 'acSearchFieldNames' => array('State.name'), 'maxlength' => '255'));
		echo $form->error('state_id');
		echo $form->autocomplete('City.name', array('label' => __l('City'), 'acFieldKey' => 'City.id', 'acFields' => array('City.name'), 'acSearchFieldNames' => array('City.name'), 'maxlength' => '255'));		
		echo $form->error('city_id');
		echo $form->input('zip',array('label' => __l('Zip')));
		
		
					
	?>
	</fieldset>	
	<fieldset class="form-block round-5">
			<legend class="round-5"><?php echo __l('Company Profile'); ?></legend>
	<?php
			echo $form->input('is_company_profile_enabled', array('label' => __l('Enable company profile'), 'class' => 'js_company_profile', 'info' => __l('Whether other users can view the company profile or not'))); ?>
           <div class = "js-company_profile_show">		 		
            <?php echo $form->input('Company.company_profile', array('label' => __l('Company Profile'),'type' => 'textarea', 'class' => 'js-editor'));?>
		</div>
	</fieldset>
    <fieldset class="form-block round-5">
		<legend class="round-5"><?php echo __l('Paypal Account'); ?></legend>
            <?php echo $form->input('User.UserProfile.paypal_account');?>
	</fieldset>
	<fieldset class="form-block round-5">
		<legend class="round-5"><?php echo __l('Branch Address'); ?></legend>
		<div class="add-block">
			<?php echo $html->link(__l('Add address'),array('controller' => 'company_addresses', 'action' => 'add', 'company' => $this->data['Company']['slug']),array('title'=>__l('Add address'),'class' => "add")); ?>
		</div>
			<ol class="list clearfix">
				<?php
				$companyAddresses = $this->data['CompanyAddress'];
				if (!empty($companyAddresses)):

				$i = 0;
				foreach ($companyAddresses as $companyAddress):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = "altrow";
					}
					?>
					 <li class= "vcard clearfix <?php echo $class;?>" >
							<div class="address-actions">

									<?php echo $html->link(__l('Edit'), array('controller' => 'company_addresses', 'action' => 'edit', $companyAddress['id']), array('class' => 'edit js-inline-edit', 'title' => __l('Edit')));?>

									<?php echo $html->link(__l('Delete'), array('controller' => 'company_addresses', 'action' => 'delete', $companyAddress['id']), array('class' => 'delete js-on-the-fly-delete', 'title' => __l('Delete')));?>

							</div>
							<address>
								<?php echo $html->cText($companyAddress['address1']);?>
								<?php
									if(!empty($companyAddress['address2'])):
										 echo $html->cText($companyAddress['address2']);
									endif;
								?>
								<?php echo $html->cText($companyAddress['City']['name']);?>, <?php echo $html->cText($companyAddress['State']['name']);?>
								<?php echo $html->cText($companyAddress['Country']['name']);?>
								<?php echo $html->cText($companyAddress['zip']);?>
							</address>
							<span class="phone"><?php echo  !empty($companyAddress['phone'])? $html->cText($companyAddress['phone']) : '&nbsp;';?></span>
							<span class="url"><?php echo  !empty($companyAddress['url'])? $html->cText($companyAddress['url']) : '&nbsp;';?></span>
					</li>
				<?php
					endforeach;
				else:
				?>
					<li class="notice"><?php echo __l('No Company Addresses available');?></li>
				<?php
				endif;
				?>
				</ol>
	</fieldset>
	<div class="js-company_profile_show">
	<fieldset class="form-block round-5">
			<legend class="round-5"><?php echo __l('Locate yourself on google maps'); ?></legend>
			<div class="show-map" style="">			
			<div id="js-map-container"></div>
			<p><?php echo __l('You can change the google map zooming level here, else default zooming level will be taken.'); ?></p>
			</div>

			<?php
			echo $form->input('latitude',array('type' => 'hidden', 'id'=>'latitude'));
			echo $form->input('longitude',array('type' => 'hidden', 'id'=>'longitude'));
			?>
			<?php
				$map_zoom_level = !empty($this->data['Company']['map_zoom_level']) ? $this->data['Company']['map_zoom_level'] : Configure::read('GoogleMap.static_map_zoom_level');
				echo $form->input('Company.map_zoom_level',array('type' => 'hidden','value' => $map_zoom_level,'id'=>'zoomlevel'));
			?>
	</fieldset>
	</div>
		<div class="submit-block clearfix">
		<?php echo $form->submit(__l('Update')); ?>
		</div>
		<?php echo $form->end(); ?>
</div>

<?php
if(!empty($this->data['Company']['is_company_profile_enabled']) and $this->data['Company']['is_company_profile_enabled']==1)
{
   $show_company_profile = 1;
}
else{
	$show_company_profile = 0;
}
?>
<script type="text/javascript">
        $(document).ready(function() {
        $('.js_company_profile').companyprofile(<?php echo $show_company_profile; ?>);
        });
</script>