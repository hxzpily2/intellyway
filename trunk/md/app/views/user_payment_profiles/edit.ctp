<?php /* SVN: $Id: authorize_net.ctp 8007 2010-06-12 12:09:11Z shankari_062at09 $ */ ?>
<div class="UserPaymentProfile  form">
	<h2><?php echo __l('Edit Credit Card'); ?></h2>
	<?php echo $form->create('UserPaymentProfile', array('action' => 'edit', 'class' => 'normal user-payment-form js-ajax-form')); ?>
	<div class=" clearfix">
	<div class="billing-left">
	<h3><?php echo __l('Billing Information'); ?></h3>
	<?php		
		echo $form->input('UserPaymentProfile.id', array('type' => 'hidden'));
		echo $form->input('UserPaymentProfile.firstName', array('label' => __l('First name')));
		echo $form->input('UserPaymentProfile.lastName', array('label' => __l('Last name')));
		echo $form->input('UserPaymentProfile.creditCardType', array('label' => __l('Card Type'), 'type' => 'select', 'options' => $credit_card_types, 'info' =>__l('For security reason, we are not saved the credit card details. You have to specify again.') ));
		echo $form->input('UserPaymentProfile.creditCardNumber', array('AUTOCOMPLETE' => 'OFF', 'type' => 'hidden', 'label' => __l('Card Number'), 'info' =>__l('For security reason, we are not saved the credit card details. You have to specify again.')));
	?>
	<div class="input date">
		<label><?php echo __l('Expiration Date'); ?> </label>
		<?php 
			echo $form->month('UserPaymentProfile.expDateMonth', 0, array(), true);
			echo $form->year('UserPaymentProfile.expDateYear', date('Y'), date('Y')+25, '', array('info' =>__l('For security reason, we are not saved the credit card details. You have to specify again.')), true);
		?>
		<span class="info"><?php echo __l('For security reason, we are not saved the credit card details. You have to specify again.');?></span>
	</div>
	<?php echo $form->input('UserPaymentProfile.cvv2Number', array('AUTOCOMPLETE' => 'OFF', 'type' => 'hidden', 'maxlength' =>'4', 'label' => __l('Card Verification Number'), 'info' =>__l('For security reason, we are not saved the credit card details. You have to specify again.'))); ?> 
	</div>
	<div class="billing-right">
    <h3><?php echo __l('Billing Address'); ?></h3>
	<?php
		echo $form->input('UserPaymentProfile.address', array('label' => __l('Billing address')));
		echo $form->input('UserPaymentProfile.city', array('label' => __l('City')));
		echo $form->input('UserPaymentProfile.state', array('label' => __l('State'), 'type' => 'select', 'options' => $states, 'empty' => __l('-- Please Select --')));
		echo $form->input('UserPaymentProfile.zip', array('label' => __l('ZIP')));
		echo $form->input('UserPaymentProfile.country', array('label' => __l('Country'), 'type' => 'select', 'options' => $countries, 'empty' => __l('Select Country')));		
	?>
	</div>
	</div>
	<div class="submit-block clearfix">
		<?php echo $form->submit(__l('Update')); ?>
		<div class="cancel-block">
    	   <?php echo $html->link(__l('Cancel'), array('action'=>'index'), array('title' => __l('Cancel'),'class' => 'cancel-button js-inline-edit'));?>
    	</div>
	</div>
	<?php echo $form->end();?>
</div>