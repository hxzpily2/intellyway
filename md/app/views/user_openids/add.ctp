<div class="userOpenids form main-content-block round-5 js-corner">
<h2><?php echo __l('Add New OpenID'); ?></h2>
<?php echo $form->create('UserOpenid', array('class' => 'normal'));?>
	<fieldset>
	<?php 
		if($auth->user('user_type_id') == ConstUserTypes::Admin):
			echo $form->input('user_id');
		endif;
	?>		
	<?php
		echo $form->input('openid', array('id' => "openid_identifier", 'class' => 'bg-openid-input', 'label' => __l('OpenID')));
	?>
	<?php 
		if($auth->user('user_type_id') == ConstUserTypes::Admin):
			echo $form->input('verify',array('type' => 'checkbox'));
		endif;
	?>		
	</fieldset>
<?php echo $form->end(__l('Add'));?>
</div>
<script type="text/javascript" id="__openidselector" src="https://www.idselector.com/widget/button/1"></script>