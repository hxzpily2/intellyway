<?php /* SVN: $Id: authorize_net.ctp 8007 2010-06-12 12:09:11Z shankari_062at09 $ */ ?>
<div class="UserPaymentProfile  form clearfix">
	<h2 class="legend"><?php echo __l('Add New Credit Card'); ?></h2>
	<br/>
	<?php echo $form->create('UserPaymentProfile', array('action' => 'add', 'class' => 'normal user-payment-form js-ajax-form')); ?>
	<div class="clearfix">
	<div class="billing-left">
	<h3><?php echo __l('Billing Information'); ?></h3>
	<?php		
		echo $form->input('UserPaymentProfile.user_id', array('type' => 'hidden','value' => $user_id));
		echo $form->input('UserPaymentProfile.firstName', array('label' => __l('First name')));
		echo $form->input('UserPaymentProfile.lastName', array('label' => __l('Last name')));
		echo $form->input('UserPaymentProfile.creditCardType', array('label' => __l('Card Type'), 'type' => 'select', 'options' => $credit_card_types));
		echo $form->input('UserPaymentProfile.creditCardNumber', array('AUTOCOMPLETE' => 'OFF', 'label' => __l('Card Number')));
	?>
	<div class="input date">
		<label><?php echo __l('Expiration Date'); ?> </label>
		<?php 
			echo $form->month('UserPaymentProfile.expDateMonth', date('m'), array(), true);
			echo $form->year('UserPaymentProfile.expDateYear', date('Y'), date('Y')+25, date('Y')+2, array(), true);
		?>
	</div>
	<?php echo $form->input('UserPaymentProfile.cvv2Number', array('AUTOCOMPLETE' => 'OFF', 'maxlength' =>'4', 'label' => __l('Card Verification Number')));
	?>
	</div>
	<div class="billing-right">
    <h3><?php echo __l('Billing Address'); ?></h3>
	<?php
		
		echo $form->input('UserPaymentProfile.address', array('label' => __l('Address')));
		echo $form->input('UserPaymentProfile.city', array('label' => __l('City')));
		echo $form->input('UserPaymentProfile.state', array('label' => __l('State'), 'type' => 'select', 'options' => $states, 'empty' => __l('-- Please Select --')));
		echo $form->input('UserPaymentProfile.zip', array('label' => __l('ZIP')));
		echo $form->input('UserPaymentProfile.country', array('label' => __l('Country'), 'type' => 'select', 'options' => $countries, 'empty' => __l('-- Please Select --')));
	?>
	</div>
	</div>
	<div class="submit-block clearfix">
		<a class="blue_button" href="#" onclick="javascript:$('#UserPaymentProfileAddForm').submit()"><span><?php echo __l('Add'); ?></span></a>
		<!--<?php echo $form->submit(__l('Add')); ?>-->
	</div>
	<?php echo $form->end();?>
</div>
<div style="height : 10px;">&nbsp;</div>