<div class="userProfiles form js-responses">
	<div class="main-content-block js-corner round-5">
		  <?php if($this->params['action'] == 'my_account') { ?>
	    <div class="js-tabs">
			<ul class="clearfix">
				<li><?php echo $html->link(__l('My Profile'), '#my-profile'); ?></li>
				<?php if(!$auth->user('fb_user_id') && !$auth->user('is_openid_register')){?>
				    <li><?php  echo $html->link(__l('Change Password'),array('controller'=> 'users', 'action'=>'change_password'),array('title' => __l('Change Password'))); ?></li>
				<?php } ?>
					  <li><?php echo $html->link(__l('Privacy Settings'), array('controller' => 'user_permission_preferences', 'action' => 'edit', $this->data['UserProfile']['user_id'], 'admin' => false), array('title' => __l('Privacy Settings')));?></li>
			</ul>
		</div>
		<?php } ?>
		<div id='my-profile'>
			<h2><?php echo sprintf(__l('Edit Profile - %s'), $this->data['User']['username']); ?></h2>
			<div class="form-blocks  js-corner round-5">
				<?php echo $form->create('UserProfile', array('action' => 'edit', 'class' => 'normal js-ajax-form', 'enctype' => 'multipart/form-data'));?>
					<h2 class="legend"><?php echo __l('Personal'); ?></h2>
					<!-- <fieldset class="form-block round-5">
						<legend class="round-5"><?php echo __l('Personal'); ?></legend> --> 
						<div class="profile-image">
							<?php 
								$user_details = array(
									'username' => $this->data['User']['username'],
									'user_type_id' =>  $this->data['User']['user_type_id'],
									'id' =>  $this->data['User']['id'],
									'fb_user_id' =>  $this->data['User']['fb_user_id'],
									'UserAvatar' => $this->data['UserAvatar']
								);
								echo $html->getUserAvatarLink($user_details, 'normal_thumb').' ';
							?>
						</div>
						<?php
							if($auth->user('user_type_id') == ConstUserTypes::Admin):
								echo $form->input('User.id',array('label' => __l('User')));
							endif;
							if($this->data['User']['user_type_id'] == ConstUserTypes::Admin):
								echo $form->input('User.username');
							endif;
							echo $form->input('first_name',array('label' => __l('First Name')));
							echo $form->input('last_name',array('label' => __l('Last Name')));
							echo $form->input('middle_name',array('label' => __l('Middle Name')));
							echo $form->input('gender_id', array('empty' => __l('Please Select'),'label' => __l('Gender')));
							if($this->data['User']['user_type_id'] == ConstUserTypes::Admin):
								echo $form->input('User.email',array('label' => __l('Email')));
							endif;
						?>
						<div class="date-time-block clearfix">
						<div class="input date-time clearfix required">
							<div class="js-datetime">
								<?php echo $form->input('dob', array('label' => __l('DOB'),'empty' => __l('Please Select'), 'div' => false, 'maxYear' => date('Y'), 'minYear' => date('Y') - 100)); ?>
							</div>
						</div>
                        </div>
							<?php
								if(Configure::read('site.currency_symbol_place') == 'left'):
									$currecncy_place = 'before';
								else:
									$currecncy_place = 'after';
								endif;	
							?>		
						<?php echo $form->input('about_me', array('label' => __l('About Me'))); ?>
						<?php echo $form->hidden('user_education_id', array('empty' => 'Please Select','label' => __l('Education'))); ?>
						<?php echo $form->hidden('user_employment_id', array('empty' =>'Please Select','label' => __l('Employment Status'))); ?>
						<?php echo $form->hidden('user_incomerange_id', array('empty' =>'Please Select','label' => __l('Income range '), $currecncy_place => Configure::read('site.currency'))); ?>
						<?php
                         $options = array('1' => 'Yes', '0' => 'No');
                         echo $form->hidden('own_home', array('options' => $options, 'type' => 'radio', 'legend' => false, 'before' => '<span class="label-content label-content-radio">Own home?</span>'));
                        ?>
						<?php echo $form->hidden('user_relationship_id', array('empty' => 'Please Select','label' => __l('Relationship status'))); ?>
						<?php
                           $options=array('1'=>'Yes','0'=>'No');
                           echo $form->hidden('have_children', array('options' => $options, 'type' => 'radio', 'legend' => false, 'before' => '<span class="label-content label-content-radio">Have Children?</span>'));
                        ?>
					<!-- </fieldset> -->
					<h2 class="legend"><?php echo __l('Address'); ?></h2>
					<!-- <fieldset class="form-block round-5">
						<legend class="round-5"><?php echo __l('Address'); ?></legend> --> 
						<?php
							echo $form->input('address',array('label' => __l('Address')));
							echo $form->input('country_id', array('empty' => __l('Please Select'),'label' => __l('Country')));
							echo $form->autocomplete('State.name', array('label' => __l('State'), 'acFieldKey' => 'State.id', 'acFields' => array('State.name'), 'acSearchFieldNames' => array('State.name'), 'maxlength' => '255'));
							echo $form->autocomplete('City.name', array('label' => __l('City'), 'acFieldKey' => 'City.id', 'acFields' => array('City.name'), 'acSearchFieldNames' => array('City.name'), 'maxlength' => '255'));
                            echo $form->input('zip_code',array('label' => __l('Zip Code')));
						?>
					<!-- </fieldset> -->
					<?php if($auth->user('user_type_id') == ConstUserTypes::Admin || Configure::read('user.is_user_can_with_draw_amount')): ?>
						<h2 class="legend"><?php echo __l('Paypal'); ?></h2>
						<!--  <fieldset class="form-block round-5">
							<legend class="round-5"><?php echo __l('Paypal'); ?></legend>-->
							<?php echo $form->input('paypal_account', array('label' => __l('PayPal').' '.__l('Account'))); ?>
						<!-- </fieldset> -->
					<?php endif; ?>
					<h2 class="legend"><?php echo __l('Other'); ?></h2>
					<!-- <fieldset class="form-block round-5">
						<legend class="round-5"><?php echo __l('Other'); ?></legend>-->
						<?php
							if($auth->user('user_type_id') == ConstUserTypes::Admin):
								if($this->data['User']['id'] != ConstUserIds::Admin):
									echo $form->input('User.is_active', array('label' => __l('Active')));
								endif;
								echo $form->input('User.is_email_confirmed', array('label' => __l('Email confirmed')));
							endif;
							echo $form->input('UserAvatar.filename', array('type' => 'file','size' => '33', 'label' => __l('Upload Photo'),'class' =>'browse-field'));
							echo $form->input('language_id', array('empty' => __l('Please Select'),'label' => __l('Profile Language'), 'info'=>__l('This will be the default site languge after logged in')));
						?>
					<!-- </fieldset> -->
				  <div class="submit-block clearfix">
				  	<a class="blue_button" href="#" onclick="javascript:$('#UserProfileEditForm').submit()"><span><?php echo __l('Update'); ?></span></a>
                    <!-- 
					<?php
                    	echo $form->submit(__l('Update'));
                    ?>
                     -->
                    </div>
                <?php
                	echo $form->end();
                ?>
			
			</div>
		</div>
	</div>
</div>
<div style="height : 11px;">&nbsp;</div>