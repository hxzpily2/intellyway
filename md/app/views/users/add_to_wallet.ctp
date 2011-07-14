<?php /* SVN: $Id: add_to_wallet.ctp 44785 2011-02-19 10:54:51Z aravindan_111act10 $ */ ?>
<h2><?php echo __l('Add amount to wallet'); ?></h2>
<?php
	if(Configure::read('site.currency_symbol_place') == 'left'):
		$currecncy_place = 'before';
	else:
		$currecncy_place = 'after';
	endif;	
?>		
<?php 
	echo $form->create('User', array('action' => 'add_to_wallet', 'class' => 'normal'));
	if (!Configure::read('wallet.max_wallet_amount')):
        $max_amount = 'No limit';
    else:
        $max_amount = $html->siteCurrencyFormat($html->cCurrency(Configure::read('wallet.max_wallet_amount')));
    endif;
	echo $form->input('amount',array('label' => __l('Amount'), $currecncy_place  => Configure::read('site.currency') . '<span class="info">' . sprintf(__l('Minimum Amount: %s <br/> Maximum Amount: %s'),$html->siteCurrencyFormat($html->cCurrency(Configure::read('wallet.min_wallet_amount'))), $max_amount) . '</span>')); ?>
	<?php
		$is_show_credit_card = 0;
		if (empty($gateway_options['Paymentprofiles'])):
			$is_show_credit_card = 1;
		endif;
	?>
	<?php echo $form->input('User.payment_gateway_id', array('legend' => false, 'before' => '<span class="payment-type">'.__l('Payment Type').'</span>',  'type' => 'radio', 'options' => $gateway_options['paymentGateways'], 'class' => 'js-payment-type {"is_show_credit_card":"' . $is_show_credit_card . '"}')); ?>
	<div class="user-payment-profile js-show-payment-profile <?php echo (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet])) ? '' : 'hide'; ?>">
		<?php 
			if (!empty($gateway_options['Paymentprofiles'])):
				echo $form->input('payment_profile_id', array('legend' => __l('Pay with this card(s)'), 'type' => 'radio', 'options' => $gateway_options['Paymentprofiles']));
				echo $html->link(__l('Add new card'), '#', array('class' => 'js-add-new-card'));
			endif;
		?>
	</div>
	<?php if (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::CreditCard]) || !empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet])): ?>
		<div class="clearfix js-credit-payment login-left-block credit-payment-block <?php echo ($this->data['User']['payment_gateway_id'] == ConstPaymentGateways::CreditCard || (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet]) && $is_show_credit_card)) ? '' : 'hide' ?>">
		  <div class="billing-left">
		  <h3><?php echo __l('Billing Information'); ?></h3>
			<?php
				echo $form->input('User.firstName', array('label' => __l('First Name')));
				echo $form->input('User.lastName', array('label' => __l('Last Name')));
				echo $form->input('User.creditCardType', array('label' => __l('Card Type'), 'type' => 'select', 'options' => $gateway_options['creditCardTypes']));
				echo $form->input('User.creditCardNumber', array('AUTOCOMPLETE' => 'OFF', 'label' => __l('Card Number'))); ?>
				<div class="input date">
				<label><?php echo __l('Expiration Date'); ?> </label>
				<?php echo $form->month('User.expDateMonth', date('m'), array(), false); 
				echo $form->year('User.expDateYear', date('Y'), date('Y')+25, date('Y')+2, array(), false);?>
				</div>
				<?php echo $form->input('User.cvv2Number', array('AUTOCOMPLETE' => 'OFF', 'maxlength' =>'4', 'label' => __l('Card Verification Number:')));
			?>
			</div>
		  <div class="billing-right">
			<h3><?php echo __l('Billing Address'); ?></h3>
			<?php
				echo $form->input('User.address', array('label' => __l('Address')));
				echo $form->input('User.city', array('label' => __l('City')));
				echo $form->input('User.state', array('label' => __l('State')));
				echo $form->input('User.zip', array('label' => __l('Zip code')));
				echo $form->input('User.country', array('label' => __l('Country'), 'type' => 'select', 'options' => $gateway_options['countries'], 'empty' => __l('Please Select')));
				echo $form->input('User.is_show_new_card', array('type' => 'hidden'));
			 ?>   
			 </div>
		</div>
	<?php endif; ?>  

    <div class="submit-block clearfix">
	<?php echo $form->submit(__l('Add to Wallet')); ?>
	
	</div>
    <?php echo $form->end();
?>