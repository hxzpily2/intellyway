<?php /* SVN: $Id: add.ctp 44820 2011-02-19 12:15:36Z aravindan_111act10 $ */ ?>
<div class="giftUsers form">
	<h2><?php echo __l('Customize Your Gift Card');?></h2>
        <?php echo $form->create('GiftUser', array('class' => 'normal'));?>
		<div class="clearfix">
			<div class="gift-card clearfix">
			<div class="gift-side1">
            <h3 class="gift-title"><span id="js-gift-from"><?php echo $this->data['GiftUser']['from']; ?></span></h3>
            <p> <?php echo __l('has given you'); ?></p>
            <p class="card-amount">
				<?php if(Configure::read('site.currency_symbol_place') == 'left'):?>
					<?php echo Configure::read('site.currency');?><span id="js-gift-amount"><?php echo $html->cCurrency($this->data['GiftUser']['amount']); ?>
				<?php else:?>
					<span id="js-gift-amount"><?php echo $html->cCurrency($this->data['GiftUser']['amount']);?></span> <?php echo Configure::read('site.currency'); ?>
				<?php endif;?>				
				</span></p>
            <p><?php echo sprintf(__l('credit to %s '), Router::url('/', true)); ?></p>
            <div class="remeber-block">
            <p><?php echo __l('Redemption Code:'); ?>
            </p>
            <p class="code-info">
            xxxxxx-xxxxxx
            </p>
            </div>
			</div>
			<div class="gift-side2">
            <dl class="card-info clearfix">
            <dt><?php echo __l('to'); ?></dt>
            <dd id="js-gift-to"><?php echo $this->data['GiftUser']['friend_name']; ?></dd>
            </dl>
            <p id="js-gift-message" class="card-message">
            <?php echo $this->data['GiftUser']['message']; ?>
            </p>
			</div>
			</div>
        	<div class="gift-form">
			<?php
				if(Configure::read('site.currency_symbol_place') == 'left'):
					$currecncy_place = 'before';
				else:
					$currecncy_place = 'after';
				endif;	
			?>		
        	<?php
				echo $form->input('user_available_balance',array('type' => 'hidden', 'value' => $user_available_balance));
                echo $form->input('user_id', array('type' => 'hidden'));
				echo $form->input('from', array('label' => __l('From'),'type'=>'text', 'info' => __l('Name you want the recipient to see'), 'class' => '{"update" : "js-gift-from", "default_value" : "Gift Buyer"}'));
				if(!empty($user['User']['fb_user_id']) && empty($user['User']['email'])):
					echo $form->input('User.email', array('label' => __l('Email')));
				endif; 	
        		echo $form->input('friend_name', array('label' => __l('Friend Name'), 'class' => '{"update" : "js-gift-to", "default_value" : "Gift Receiver"}'));
        		echo $form->input('friend_mail', array('label' => __l('Delivery to Email')));
        		echo $form->input('message', array('label' => __l('Personal Message (Optional)'), 'class' => '{"update" : "js-gift-message", "default_value" : "Your Message"}'));
				echo $form->input('amount', array('label' => __l('Gift Card Amount'), $currecncy_place =>Configure::read('site.currency'), 'class' => '{"update" : "js-gift-amount", "default_value" : "0"}'));
        	?>
        	</div>
        	</div>
			<div class="wallet-block">
			<p><?php if(Configure::read('wallet.is_handle_wallet_as_in_groupon')):?>
				<?php echo Configure::read('site.name').' '.__l('bucks')?>
				<?php echo ' - '.$html->siteCurrencyFormat($html->cCurrency($user_available_balance ? $user_available_balance : 0)); ?>
		</p>
		<p>
			<?php echo __l('My Price')?>
				<?php $my_price = ($user_available_balance > $this->data['GiftUser']['amount']) ? 0 : ($this->data['GiftUser']['amount'] - $user_available_balance); ?>
				<?php if(Configure::read('site.currency_symbol_place') == 'left'):?>
					<?php echo Configure::read('site.currency');?><span class="js-amount-need-to-pay"><?php echo $html->cCurrency($my_price); ?>
				<?php else:?>
					<span class="js-amount-need-to-pay"><?php echo $html->cCurrency($my_price);?></span> <?php echo Configure::read('site.currency'); ?>
				<?php endif;?>
			</tr>
			<?php endif;?>
			</p>
			</div>
		
			<?php
				$is_show_credit_card = 0;
				if (empty($gateway_options['Paymentprofiles'])):
					$is_show_credit_card = 1;
				endif;
			  ?>
			<div class="clearfix">
				<div class="js-payment-gateway">
				  <?php echo $form->input('payment_gateway_id', array('legend' => __l('Payment Type'), 'type' => 'radio', 'options' => $gateway_options['paymentGateways'], 'class' => 'js-payment-type {"is_show_credit_card":"' . $is_show_credit_card . '"}'));?>
					<div class="user-payment-profile js-show-payment-profile <?php echo (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet])) ? '' : 'hide'; ?>">
						<?php 
							if (!empty($gateway_options['Paymentprofiles'])):
								echo $form->input('payment_profile_id', array('legend' => __l('Pay with this card(s)'), 'type' => 'radio', 'options' => $gateway_options['Paymentprofiles']));
								echo $html->link(__l('Add new card'), '#', array('class' => 'js-add-new-card'));
							endif;
						?>
					</div>
					<?php if(!empty($gateway_options['paymentGateways'][ConstPaymentGateways::CreditCard]) || !empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet])): ?>
					<div class="clearfix js-credit-payment <?php echo (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::CreditCard]) && !empty($this->data['GiftUser']['payment_gateway_id']) && $this->data['GiftUser']['payment_gateway_id'] == ConstPaymentGateways::CreditCard || (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet]) && $is_show_credit_card)) ? '' : 'hide'; ?>">
					  <div class="billing-left">
					  <h3><?php echo __l('Billing Information'); ?></h3>
						<?php
							echo $form->input('GiftUser.firstName', array('label' => __l('First Name')));
							echo $form->input('GiftUser.lastName', array('label' => __l('Last Name')));
							echo $form->input('GiftUser.creditCardType', array('label' => __l('Card Type'), 'type' => 'select', 'options' => $gateway_options['creditCardTypes']));
							echo $form->input('GiftUser.creditCardNumber', array('AUTOCOMPLETE' => 'OFF', 'label' => __l('Card Number'))); ?>
							<div class="input date">
							<label><?php echo __l('Expiration Date'); ?> </label>
							<?php echo $form->month('GiftUser.expDateMonth', date('m'), array(), false); 
							echo $form->year('GiftUser.expDateYear', date('Y'), date('Y')+25, date('Y')+2, array(), false);?>
							</div>
							<?php echo $form->input('GiftUser.cvv2Number', array('AUTOCOMPLETE' => 'OFF', 'maxlength' =>'4', 'label' => __l('Card Verification Number:')));
						?>
						</div>
					  <div class="billing-right">
						<h3><?php echo __l('Billing Address'); ?></h3>
						<?php
							echo $form->input('GiftUser.address', array('label' => __l('Address')));
							echo $form->input('GiftUser.city', array('label' => __l('City')));
							echo $form->input('GiftUser.state', array('label' => __l('State')));
							echo $form->input('GiftUser.zip', array('label' => __l('Zip code')));
							echo $form->input('GiftUser.country', array('label' => __l('Country'), 'type' => 'select', 'options' => $gateway_options['countries'], 'empty' => __l('Please Select')));
							echo $form->input('GiftUser.is_show_new_card', array('type' => 'hidden', 'id' => 'UserIsShowNewCard'));
						 ?>   
						 </div>
					</div>
				<?php endif; ?>
				</div>
				<?php if(Configure::read('wallet.is_handle_wallet_as_in_groupon')):?>
					<?php echo $form->input('is_purchase_via_wallet', array('type' => 'hidden', 'value' => ($this->data['Deal']['total_deal_amount'] <= $user_available_balance) ? 1 : 0));?>
				<?php endif;?>
                <?php echo $form->input('group_wallet', array('type' => 'hidden', 'value' => Configure::read('wallet.is_handle_wallet_as_in_groupon')));?>
                 <div class="submit-block clearfix">
                    <?php
                    	echo $form->submit(__l('Complete Purchase'));
                    ?>
                </div>
                <?php
                	echo $form->end();
                ?>
			</div>
       
</div>