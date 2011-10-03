<div style="position:absolute;" class="users form register-block <?php echo !empty($this->data['User']['is_requested']) ? 'js-login-response ajax-login-block' : ''; ?>">
	<h2><?php echo __l('Login'); ?></h2>
	<?php
		$formClass = !empty($this->data['User']['is_requested']) ? 'js-ajax-login' : '';
		echo $form->create('User', array('action' => 'login', 'class' => 'mdlogin '.$formClass));
		echo $form->input(Configure::read('user.using_to_login'), array('class' => 'login-input-text'));
		echo $form->input('passwd', array('label' => __l('Password'),'class' => 'login-input-text'));
		if(!empty($this->data['User']['is_requested'])) {
			echo $form->input('is_requested', array('type' => 'hidden'));
		}
	?>
	<?php if(!(!empty($this->params['prefix']) && $this->params['prefix'] == 'admin') and Configure::read('user.is_enable_openid')): ?>
		<span class="or"><?php  echo __l('(OR)'); ?></span>
		<?php echo $form->input('openid', array('id' => 'login_openid_identifier','class' => 'bg-openid-input', 'label' => __l('OpenID'))); ?>
	<?php endif; ?>
	<?php echo $form->input('User.is_remember', array('type' => 'checkbox', 'label' => __l('Remember me on this computer.'))); ?>
	<div class="loginForogtDiv">
		<?php echo $html->link(__l('Forgot your password?') , array('controller' => 'users', 'action' => 'forgot_password', 'admin' => false),array('title' => __l('Forgot your password?'))); ?>
		<?php if(!(!empty($this->params['prefix']) && $this->params['prefix'] == 'admin') && empty($this->data['User']['is_requested'])): ?> |
			<?php  echo $html->link(__l('Signup') , array('controller' => 'users',	'action' => 'register'),array('title' => __l('Signup'))); ?>
		<?php endif; ?>
	</div>
	<?php
		$f = (!empty($_GET['f'])) ? $_GET['f'] : ((!empty($this->data['User']['f'])) ? $this->data['User']['f'] : (($this->params['controller'] != 'users' && ($this->params['action'] != 'login' && $this->params['action'] != 'admin_login')) ? $this->params['url']['url'] : ''));
			if (!empty($f)):
				echo $form->input('f', array('type' => 'hidden', 'value' => $f));
			endif;
	?>
	<div class="loginForogtDiv">
		<a class="pink_button" href="#" onclick="javascript:$('#UserLoginForm').submit()"><span><?php echo __l('Login'); ?></span></a>
	</div> 
	<div class="submit-block clearfix">
		<!--<?php echo $form->submit(__l('Login')); ?>-->
		<?php if(Configure::read('user.is_enable_openid') && (!isset($this->params['requested']))): ?>
			<script type="text/javascript">
				window.idselector_input_id = 'login_openid_identifier';
			</script>
			<script type="text/javascript" id="__openidselector" src="https://www.idselector.com/widget/button/1"></script>
		<?php endif; ?>
		<?php if(!empty($this->data['User']['is_requested']) && $this->data['User']['is_requested']):  ?>
			<div class="cancel-block js-cancel-block">
				<?php echo $html->link(__l('Cancel'), '#', array('title' => __l('Never Mind'),'class' => "cancel-button js-toggle-show {'container':'js-login-message', 'hide_container':'js-login-form'}"));?>
			</div>
		<?php endif; ?>
	</div>
	<?php echo $form->end(); ?>
	<?php if (!(!empty($this->params['prefix']) && $this->params['prefix'] == 'admin') && Configure::read('facebook.is_enabled_facebook_connect') && empty($this->data['User']['is_requested'])): ?>
		<div class="deal-side2 login-side2 deal">
			<div class="deal-inner-block deal-bg clearfix">
				<h3><?php echo __l('Connect'); ?></h3>
				<p class="already-info"><?php echo __l('Already have an account on Facebook?'); ?></p>
				<p><?php echo sprintf(__l('Use it to sign in to %s'),Configure::read('site.name').'!'); ?></p>
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
				<div class="deal-bot-bg"></div>
			</div>
		</div>
	<?php endif; ?>	
</div>

<div style="height : 269px;">&nbsp;</div>
