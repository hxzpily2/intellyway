<div class="curve-top"></div>
<div class="curve-middle">
  <div class="curve-inner">
  <?php if(isset($success)) : ?>
    <div class="success-msg">
        <?php echo __l('Thank you, we received your message and will get back to you as soon as possible.'); ?>
    </div>
<?php else: ?>
    <h2 class="green-head"><?php echo __l('Contact Us'); ?></h2>
    <?php
        echo $form->create('Contact', array('class' => 'normal js-contact-form'));
        echo $form->input('first_name', array('label' => __l('First Name')));
        echo $form->input('last_name', array('label' => __l('Last Name')));
        echo $form->input('email',array('label' => __l('Email')));
        echo $form->input('telephone',array('label' => __l('Telephone')));
        echo $form->input('subject',array('label' => __l('Subject')));
        echo $form->input('message', array('label' => __l('Message'),'type' => 'textarea'));
    ?>
    <!--  <div class="captcha-block clearfix js-captcha-container">
        <div class="captcha-left">
            <?php echo $html->image($html->url(array('controller' => 'contacts', 'action' => 'show_captcha', md5(uniqid(time()))), true), array('alt' => __l('[Image: CAPTCHA image. You will need to recognize the text in it; audible CAPTCHA available too.]'), 'title' => __l('CAPTCHA image'), 'class' => 'captcha-img'));?>
        </div>
        <div class="captcha-right">
            <?php echo $html->link(__l('Reload CAPTCHA'), '#', array('class' => 'js-captcha-reload captcha-reload', 'title' => __l('Reload CAPTCHA')));?>
			<div>
			  <?php echo $html->link(__l('Click to play'), Router::url('/', true)."flash/securimage/play.swf?audio=". $html->url(array('controller' => 'users', 'action'=>'captcha_play'), true) ."&amp;bgColor1=#777&amp;bgColor2=#fff&amp;iconColor=#000&amp;roundedCorner=5&amp;height=19&amp;width=19&amp;wmode=transparent", array('class' => 'js-captcha-play')); ?>
		  </div>
        </div>
    </div> -->
    	<div class="input required clearfix">
    			<label><?php echo __l('Security Code'); ?></label>
    			<script type="text/javascript">
 					var RecaptchaOptions = {
    					theme : 'white',    					
    					lang : '<?php echo Configure::read('lang_code'); ?>'
 					};
 					$(window).load(function() {
 						$('label[for*="ContactCaptcha"]').css('display','none');
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
            </div>
    <?php
        echo $form->input('captcha', array('label' => __l('Security Code'), 'class' => 'js-captcha-input'));

 ?>
    <div class="submit-block clearfix">
    	<a class="pink_button" href="#" onclick="javascript:$('#ContactAddForm').submit()"><span><?php echo __l('Send'); ?></span></a>
        <?php
        	/*echo $form->submit(__l('Send'));*/
        ?>
    </div>
        <?php
        	echo $form->end();
        ?>
   
<?php endif; ?>
</div>
  <div class="curve-bot"></div>
</div>
<div style="height:4px;"></div>
<!--[if IE]>
<div style="height : 3px;">&nbsp;</div>
<![endif]-->