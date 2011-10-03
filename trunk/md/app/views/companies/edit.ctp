<?php /* SVN: $Id: edit.ctp 44735 2011-02-19 07:44:54Z usha_111at09 $ */ ?>
<?php if($auth->user('user_type_id') == ConstUserTypes::Company):?> 
	<?php if(empty($this->params['isAjax']) or !$this->params['isAjax']):?>		 
		 <?php echo $this->element('js_tiny_mce_setting', array('cache' => array('time' => Configure::read('site.element_cache'))));?>
   <?php endif; ?>
<?php endif; ?>
<div class="companies form js-responses">
<div class="js-tabs">
	<ul class="clearfix">
		<li><?php echo $html->link(__l('My Profile'), '#my-profile'); ?></li>
		 <li><?php echo $html->link(__l('Branch Addresses'), array('controller' => 'company_addresses', 'action' => 'index', 'admin' => false), array('title' => __l('Branch Addresses')));?></li>
		<li><?php echo $html->link(__l('Change Password'),array('controller'=> 'users', 'action'=>'change_password'),array('title' => __l('Change Password'))); ?></li>
        <li><?php echo $html->link(__l('Privacy Settings'), array('controller' => 'user_permission_preferences', 'action' => 'edit', $auth->user('id'), 'admin' => false), array('title' => __l('Privacy Settings')));?></li>
        <!--<li><?php //echo $html->link(__l('My API'), array('controller' => 'users', 'action' => 'my_api', $auth->user('id'), 'admin' => false), array('title' => __l('Request API Key')));?></li>-->
	</ul>
	<div id='my-profile' class="clearfix">
		<?php echo $form->create('Company', array('class' => 'normal js-company-map js-ajax-form', 'enctype' => 'multipart/form-data'));?>
			<div>
				<h2><?php echo __l('Edit Company');?></h2>
			</div>
			<h2 class="legend"><?php echo __l('Account'); ?></h2>
           <!-- <fieldset class="form-block round-5">
               <legend class="round-5"><?php echo __l('Account'); ?></legend> -->
                <?php
                    echo $form->input('id');
                    echo $form->input('name',array('label' => __l('Company Name')));
                    echo $form->input('phone',array('label' => __l('Phone')));
                    echo $form->input('url',array('label' => __l('URL'), 'info' => __l('eg. http://www.example.com')));
				?>
			<!-- </fieldset> -->
			<?php if(Configure::read('company.is_user_can_withdraw_amount')): ?>
				<h2 class="legend"><?php echo __l('PayPal'); ?></h2>
				<!-- <fieldset class="form-block round-5">
	               <legend class="round-5"><?php echo __l('PayPal'); ?></legend>-->
					<?php echo $form->input('User.UserProfile.paypal_account', array('label' => __l('PayPal Account'))); ?>
				<!-- </fieldset> -->
			<?php endif; ?>
			<h2 class="legend"><?php echo __l('Address'); ?></h2>
           <!-- <fieldset class="form-block round-5">
               <legend class="round-5"><?php echo __l('Address'); ?></legend> -->
					<?php
                        echo $form->input('address1',array('label' => __l('Address1')));
                        echo $form->input('address2',array('label' => __l('Address2')));
                        echo $form->input('country_id',array('label' => __l('Country')));
                        echo $form->autocomplete('State.name', array('label' => __l('State'), 'acFieldKey' => 'State.id', 'acFields' => array('State.name'), 'acSearchFieldNames' => array('State.name'), 'maxlength' => '255'));
						echo $form->error('state_id');
                        echo $form->autocomplete('City.name', array('label' => __l('City'), 'acFieldKey' => 'City.id', 'acFields' => array('City.name'), 'acSearchFieldNames' => array('City.name'), 'maxlength' => '255'));
						echo $form->error('city_id');						
                        echo $form->input('zip',array('label' => __l('Zip')));
					?>	
           <!-- </fieldset> --> 
           <h2 class="legend"><?php echo __l('Company Profile'); ?></h2>
		   <!-- <fieldset class="form-block round-5">
               <legend class="round-5"><?php echo __l('Company Profile'); ?></legend> -->
			   <?php
						echo $form->input('is_company_profile_enabled', array('label' => __l('Enable company profile'), 'class' => 'js_company_profile_enable', 'info' => __l('Whether other users can view the company profile or not')));
						?>
                        <div class = "js-company_profile_show">
							<?php echo $form->input('Company.company_profile', array('label' => __l('Company profile'),'type' => 'textarea', 'class' => 'js-editor'));   ?>
                        </div>
			<!-- </fieldset> -->
			<h2 class="legend"><?php echo __l('Logo'); ?></h2>
           <!-- <fieldset class="form-block round-5">
               <legend class="round-5"><?php echo __l('Logo'); ?></legend>-->
                <div class="company-profile-image">
					<?php echo $html->getUserAvatarLink($this->data['User'], 'normal_thumb');
					echo $form->input('UserProfile.language_id', array('empty' => __l('Please Select'),'label' => __l('Profile Language'), 'value' => $this->data['User']['UserProfile']['language_id'], 'info'=>__l('This will be the default site languge after logged in')));
					?>
                </div>               
				<?php 
                    echo $form->input('UserAvatar.filename', array('type' => 'file','size' => '33', 'label' => __l('Upload Logo'),'class' =>'browse-field'));
                    echo $form->input('User.id',array('type' => 'hidden'));
                ?>
           <!-- </fieldset> -->
        <div class="js-company_profile_show">
        <h2 class="legend"><?php echo __l('Locate Yourself on Google Maps'); ?></h2>
        <br/>
		<!-- <fieldset class="form-block round-5"> -->		
			 <?php
					echo $form->input('latitude',array('type' => 'hidden', 'id'=>'latitude'));
					echo $form->input('longitude',array('type' => 'hidden', 'id'=>'longitude'));
			?>
			
			<!-- <legend class="round-5"><?php echo __l('Locate Yourself on Google Maps'); ?></legend> -->
				<div class="show-map">
					<div id="js-map-container"><?php echo __l('Please update address info to generate location Map'); ?></div>
					<p><?php echo __l('You can change the google map zooming level here, else default zooming level will be taken.'); ?></p>
				</div>
				
			<?php
				$map_zoom_level = !empty($this->data['Company']['map_zoom_level']) ? $this->data['Company']['map_zoom_level'] : Configure::read('GoogleMap.static_map_zoom_level');
				echo $form->input('Company.map_zoom_level',array('type' => 'hidden','value' => $map_zoom_level,'id'=>'zoomlevel'));
			?>
		<!-- </fieldset> -->
		</div>
		<br/><br/>
	    <div class="submit-block clearfix">
	    <a class="blue_button" href="#" onclick="javascript:$('#CompanyEditForm').submit()"><span><?php echo __l('Add'); ?></span></a>
        <!--<?php
        	echo $form->submit(__l('Update'));
        ?>-->
        </div>
        <?php
        	echo $form->end();
        ?>
	</div>
</div>
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