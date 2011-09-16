<script type="text/javascript">
	function submitForm(){		
		$('form').submit();
	}
</script>
<?php if(!empty($type)){
    $action = "company_register";
  }
  else{
    $action = "register";
  }
?>
<div class="users form page-block register-block <?php echo !empty($this->data['User']['is_requested']) ? 'js-login-response ajax-login-block' : ''; ?>">
<div class="deal-side1">
   <div class="content-top-l">
      <div class="content-top-r">
        <div class="content-top-m"> </div>
      </div>
    </div>
    <div class="content-r clearfix">
<h2 class="login-title"><?php echo __l('Sign Up'); ?>
</h2>
<?php
  		$formClass = !empty($this->data['User']['is_requested']) ? 'js-ajax-login' : '';
?>
<?php echo $form->create('User', array('action' => $action, 'class' => 'normal js-company-map js-register-form '.$formClass)); ?>
	<fieldset>
    	<?php if(!empty($type)): ?>
    		   <!--<fieldset class="form-block round-5">-->
               <!--<legend class="round-5"><?php echo __l('Account'); ?></legend>-->
               <div style="height:20px;">&nbsp;</div>
               <h2 class="legend"><?php echo __l('Account'); ?></h2>
        <?php endif; ?>
	<?php
		if(!empty($this->data['User']['openid_url'])):
			echo $form->input('openid_url', array('type' => 'hidden', 'value' => $this->data['User']['openid_url']));
		endif;
		echo $form->input('username',array('info' => __l('Must start with an alphabet. <br/> Must be minimum of 3 characters and <br/> Maximum of 20 characters <br/> No special characters and spaces allowed'),'label' => __l('Username')));
		echo $form->input('email',array('label' => __l('Email')));
		echo $form->input('referred_by_user_id',array('type' => 'hidden',));
		if(empty($this->data['User']['openid_url']) && empty($this->data['User']['fb_user_id'])):
			echo $form->input('passwd', array('label' => __l('Password')));
			echo $form->input('confirm_password', array('type' => 'password', 'label' => __l('Password Confirmation')));
			  echo $form->input('type',array('type' => 'hidden', 'value' => $type));
		endif;
        if(!empty($type)):
    		echo $form->input('Company.name',array('label' => __l('Company Name')));    		
			echo $form->input('Company.phone',array('label' => __l('Phone')));
    		echo $form->input('Company.url',array('label' => __l('URL'), 'help' => __l('eg. http://www.example.com')));
		endif;
		if(!empty($this->data['User']['is_requested'])):
			echo $form->input('is_requested', array('type' => 'hidden'));
		endif;
		if (!empty($this->data['User']['f'])):
			echo $form->input('f', array('type' => 'hidden'));
		endif;
		?>
    	<?php if(!empty($type)): ?>
    		   <!--</fieldset>-->
        <?php endif; ?>
    	<?php if(!empty($type)): ?>
    		   <!--<fieldset class="form-block round-5">
               <legend class="round-5"><?php echo __l('Address'); ?></legend>-->
               <h2 class="legend"><?php echo __l('Address'); ?></h2>
        <?php endif; ?>
        <?php
        if(!empty($type))
        {
    		echo $form->input('Company.address1',array('label' => __l('Address1')));
    		echo $form->input('Company.address2',array('label' => __l('Address2')));
    		echo $form->input('Company.country_id',array('empty'=> __l('Please Select'), 'label' => __l('Country')));
			echo $form->autocomplete('State.name', array('label' => __l('State'), 'acFieldKey' => 'State.id', 'acFields' => array('State.name'), 'acSearchFieldNames' => array('State.name'), 'maxlength' => '255'));
    	    echo $form->autocomplete('City.name', array('label' => __l('City'), 'acFieldKey' => 'City.id', 'acFields' => array('City.name'), 'acSearchFieldNames' => array('City.name'), 'maxlength' => '255'));
			echo $form->input('Company.zip',array('label' => __l('Zip')));
		}else{
			echo $form->input('country_iso_code', array('type' => 'hidden','id' => 'country_iso_code'));
			echo $form->input('State.name', array('type' => 'hidden'));
			echo $form->input('City.name', array('type' => 'hidden'));
		}
		if(!empty($refer)){
    		if(isset($_GET['refer']) && ($_GET['refer']!='')) {
    			$refer = $_GET['refer'];
    		}
    		echo $form->input('referer_name', array('value' => $refer, 'label'=>__l('Reference Code')));
    	}else{
    		echo $form->input('referer_name', array('type' => 'hidden'));
    	}
		?>
    	<?php if(!empty($type)): ?>
    		   <!--</fieldset>-->
        <?php endif; ?>
	
	<?php  	if(!empty($type)):  ?>
	   <!--<fieldset class="form-block round-5">-->
               <!--<legend class="round-5"><?php echo __l('Locate Yourself on Google Maps'); ?></legend>-->
               <h2 class="legend"><?php echo __l('Locate Yourself on Google Maps'); ?></h2>
               <div style="height:10px;">&nbsp;</div>
		<?php 		
			echo $form->input('Company.latitude',array('type' => 'hidden', 'id'=>'latitude'));
			echo $form->input('Company.longitude',array('type' => 'hidden', 'id'=>'longitude'));
		?>
		<?php
				$map_zoom_level = !empty($this->data['Company']['map_zoom_level']) ? $this->data['Company']['map_zoom_level'] : Configure::read('GoogleMap.static_map_zoom_level');
				echo $form->input('Company.map_zoom_level',array('type' => 'hidden','value' => $map_zoom_level,'id'=>'zoomlevel'));
			?>
		<div class="show-map" style="">				
				<div id="js-map-container"></div>
				<div style="height:10px;">&nbsp;</div>
				<p><?php echo __l('You can change the google map zooming level here, else default zooming level will be taken.'); ?></p>
			</div>
		 <!--</fieldset>-->
		 <h2 class="legend">&nbsp;</h2>
		 <div style="height:10px;">&nbsp;</div>
   <?php endif; ?>


		<?php
		if(empty($this->data['User']['openid_url'])): ?>
            <?php if(empty($this->data['User']['fb_user_id']) && empty($type) && Configure::read('user.is_enable_openid')) : ?>
        		<span class="or"> <?php	echo __l('(OR)'); ?> </span>
            		<?php	echo $form->input('openid', array('id' => 'register_openid_identifier', 'class' => 'bg-openid-input', 'label' => __l('OpenID'))); ?>
                <?php endif; ?>
			<?php
				if(!empty($this->data['User']['fb_user_id'])):
					echo $form->input('fb_user_id', array('type' => 'hidden', 'value' => $this->data['User']['fb_user_id']));
				endif;
			?>
    		<div class="input required clearfix">
    			<label><?php echo __l('Security Code'); ?></label>
    			<script type="text/javascript">
 					var RecaptchaOptions = {
    					theme : 'white',    					
    					lang : '<?php echo Configure::read('lang_code'); ?>'
 					};
 					$(window).load(function() {
 						$('label[for*="UserCaptcha"]').css('display','none');
 						$('.js-captcha-input').css('display','none');
 						$('#recaptcha_response_field').keyup(function() { 							
  							$('.js-captcha-input').val($('#recaptcha_response_field').val());  
						});
					});
 				</script> 				
 				
 				<div style="padding-left:180px;">
    				<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6LesCcgSAAAAAClLi_Z3JEcGgmAPcdL4mrrrg2su">
    				</script>
    				<noscript>
       					<iframe src="http://www.google.com/recaptcha/api/noscript?k=6LesCcgSAAAAAClLi_Z3JEcGgmAPcdL4mrrrg2su"
           					height="300" width="500" frameborder="0"></iframe><br>
       						<textarea name="recaptcha_challenge_field" rows="3" cols="40">
       						</textarea>
       						<input type="hidden" name="recaptcha_response_field"
           					value="manual_challenge">
			    	</noscript>
    			</div>
    		
    		
    			<!--<div class="captcha-left">
    	           <?php echo $html->image($html->url(array('controller' => 'users', 'action' => 'show_captcha', md5(uniqid(time()))), true), array('alt' => __l('[Image: CAPTCHA image. You will need to recognize the text in it; audible CAPTCHA available too.]'), 'title' => __l('CAPTCHA image'), 'class' => 'captcha-img'));?>
    	        </div>
    	        <div class="captcha-right">
        	        <?php echo $html->link(__l('Reload CAPTCHA'), '#', array('class' => 'js-captcha-reload captcha-reload', 'title' => __l('Reload CAPTCHA')));?>
        			<div>
		              <?php echo $html->link(__l('Click to play'), Router::url('/', true)."flash/securimage/play.swf?audio=". $html->url(array('controller' => 'users', 'action'=>'captcha_play'), true) ."&amp;bgColor1=#777&amp;bgColor2=#fff&amp;iconColor=#000&amp;roundedCorner=5&amp;height=19&amp;width=19&amp;wmode=transparent", array('class' => 'js-captcha-play')); ?>
			      </div>
    	        </div>-->
            </div>
        	<?php 
				echo $form->input('captcha', array('label' => __l('Security Code'), 'class' => 'js-captcha-input'));
				$terms = $html->link(__l('Terms & Policies'), array('controller' => 'pages', 'action' => 'view', 'term-and-conditions'), array('target' => '_blank','class'=>'mdlink'));
			?>
    		<?php echo $form->input('is_agree_terms_conditions', array('label' => __l('I have read, understood &amp; agree to the ') .' ' . $terms)); ?>
            <?php
        endif; ?>
   	<div class="registerForogtDiv">
		<!--<?php echo $form->submit(__l('Submit'));?>-->
		<a class="pink_button" href="#" onclick="javascript:submitForm()"><span><?php echo __l('Submit'); ?></span></a>							
		<?php
		echo $html->link($html->tag('span', __l('Cancel'), array('class' => '')), array('controller' => 'deals', 'action' => 'index'),array('escape'=>false,'class'=>'darkgrey_button'));
		?>
		
    </div>
</fieldset>
 <?php  echo $form->end();?>
 </div>
     <div class="content-bott-l">
      <div class="content-bott-r">
        <div class="content-bott-m"> </div>
      </div>
    </div>
</div>
<?php if(empty($type) && Configure::read('facebook.is_enabled_facebook_connect') && empty($this->data['User']['is_requested'])): ?>
    <div class="deal-side2 login-side2 deal">
            <div class="deal-inner-block deal-bg clearfix">
                <h3><?php echo __l('Connect'); ?></h3>
                <p class="already-info"><?php echo __l('Already have an account on Facebook?'); ?></p>
                <p><?php sprintf(__l('Use it to sign in to %s'), Configure::read('site.name').'!');   ?></p>
                <p>
					<?php
						if (env('HTTPS')) {
							$fb_prefix_url = 'https://www.facebook.com/images/fbconnect/login-buttons/connect_dark_medium_short.gif';
						} else {
							$fb_prefix_url = 'http://static.ak.fbcdn.net/images/fbconnect/login-buttons/connect_light_medium_short.gif';
						}
					?>
					<?php echo $html->link($html->image($fb_prefix_url, array('alt' => __l('[Image: Facebook Connect]'), 'title' => __l('Facebook connect'))), $fb_login_url, array('escape' => false)); ?>
                </p>
				<div class="deal-bot-bg"> </div> 
          </div>
           
    </div>
<?php endif; ?>
</div>
<?php if(Configure::read('user.is_enable_openid') && (!isset($this->params['requested']))): ?>
	<script type="text/javascript">
		window.idselector_input_id = 'register_openid_identifier';
	</script>
	<script type="text/javascript" id="__openidselector" src="https://www.idselector.com/widget/button/1"></script>
<?php endif; ?>
<div style="height:10px;"></div>
<!--[if IE]>
<div style="height : 3px;">&nbsp;</div>
<![endif]-->