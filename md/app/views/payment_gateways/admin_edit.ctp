<?php /* SVN: $Id: $ */ ?>
<div class="paymentGateways form">
	<h2><?php echo __l('Edit Payment Gateway');?></h2>
	<?php echo $form->create('PaymentGateway', array('class' => 'normal')); ?>
		<fieldset>
		<?php
			echo $form->input('id');
			echo $form->input('display_name');
			echo $form->input('description');
			echo $form->input('is_active', array('label' => __l('Active?')));
			echo $form->input('is_test_mode', array('label' => __l('Test Mode?')));
			foreach($paymentGatewaySettings as $paymentGatewaySetting) {
				$options['type'] = $paymentGatewaySetting['PaymentGatewaySetting']['type'];
				if($paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'is_enable_for_buy_a_deal'):
					$options['label'] = __l('Enable for Deal Purchase');
				elseif($paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'is_enable_for_gift_card'):
					$options['label'] = __l('Enable for Gift Card');
				elseif($paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'is_enable_for_add_to_wallet'):
					$options['label'] = __l('Enable add to wallet');
				elseif($paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'is_enable_wallet'):
					$options['label'] = __l('Enable Wallet');
					if($paymentGatewaySetting['PaymentGatewaySetting']['payment_gateway_id'] != ConstPaymentGateways::Wallet):
						$options['disabled'] = true;
					endif;
				endif;
				$options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['test_mode_value'];
				$options['div'] = array('id' => "setting-{$paymentGatewaySetting['PaymentGatewaySetting']['key']}");
				if($options['type'] == 'checkbox' && !empty($options['value'])):
					$options['checked'] = 'checked';
				else:
					$options['checked'] = '';
				endif;
				if($options['type'] == 'select'):
					$selectOptions = explode(',', $paymentGatewaySetting['PaymentGatewaySetting']['options']);
					$paymentGatewaySetting['PaymentGatewaySetting']['options'] = array();
					if(!empty($selectOptions)):
						foreach($selectOptions as $key => $value):
							if(!empty($value)):
								$paymentGatewaySetting['PaymentGatewaySetting']['options'][trim($value)] = trim($value);
							endif;
						endforeach;
					endif;
					$options['options'] = $paymentGatewaySetting['PaymentGatewaySetting']['options'];
				endif;
				if (!empty($paymentGatewaySetting['PaymentGatewaySetting']['description']) && empty($options['after'])):
					$options['help'] = "{$paymentGatewaySetting['PaymentGatewaySetting']['description']}";
				else:
					$options['help'] = '';
				endif;
				if(($paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'is_enable_for_buy_a_deal' || $paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'is_enable_for_gift_card' || ($paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'is_enable_for_add_to_wallet' && $paymentGatewaySetting['PaymentGatewaySetting']['payment_gateway_id'] != ConstPaymentGateways::Wallet) || $paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'is_enable_wallet')):
					echo $form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.test_mode_value", $options);
				endif;
			}
			if($paymentGatewaySettings && $this->data['PaymentGateway']['id'] != ConstPaymentGateways::Wallet) {
		?>
				<div class="clearfix">
					<div class="test-mode-left">
						<label for="PaymentGatewaySetting1TestModeValue"><?php echo __l('Test Mode'); ?></label>
					</div>
					<div class="test-mode-right">
						<label for="PaymentGatewaySetting1LiveModeValue"><?php echo __l('Live Mode'); ?></label>
					</div>
				</div>
				<?php
					$j = $i = $z = 0;
					$options = '';
					foreach($paymentGatewaySettings as $paymentGatewaySetting) {
						$options['type'] = $paymentGatewaySetting['PaymentGatewaySetting']['type'];
						$options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['test_mode_value'];
						$options['div'] = array('id' => "setting-{$paymentGatewaySetting['PaymentGatewaySetting']['key']}");
						if($options['type'] == 'checkbox' && $options['value']):
							$options['checked'] = 'checked';
						endif;
						if($options['type'] == 'select'):
							$selectOptions = explode(',', $paymentGatewaySetting['PaymentGatewaySetting']['options']);
							$paymentGatewaySetting['PaymentGatewaySetting']['options'] = array();
							if(!empty($selectOptions)):
								foreach($selectOptions as $key => $value):
									if(!empty($value)):
										$paymentGatewaySetting['PaymentGatewaySetting']['options'][trim($value)] = trim($value);
									endif;
								endforeach;
							endif;
							$options['options'] = $paymentGatewaySetting['PaymentGatewaySetting']['options'];
						endif;
						$options['label'] = false;
						if (!empty($paymentGatewaySetting['PaymentGatewaySetting']['description']) && empty($options['after'])):
							$options['help'] = "{$paymentGatewaySetting['PaymentGatewaySetting']['description']}";
						else:
							$options['help'] = '';
						endif;
					?>
					<?php if($paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'payee_account' || $paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'receiver_emails'): ?>
						<?php if($z == 0):?>
							<fieldset class="form-block round-5">
								<legend class="round-5">
									<?php echo __l('Payee Details'); ?>
								</legend>  
						<?php endif; ?>
								<div class="clearfix test-mode-content">
									<span class="label-content"><?php echo Inflector::humanize($paymentGatewaySetting['PaymentGatewaySetting']['key']); ?></span>
									<div class="test-mode-left">
										<?php echo $form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.test_mode_value", $options); ?>
									</div>
									<div class="test-mode-right">
										<?php
											$options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['live_mode_value'];
											echo $form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.live_mode_value", $options);
										?>
									</div>
								</div>
						<?php if($z == 1): ?>
							</fieldset>
						<?php endif;?>
						<?php $z++;?>
					<?php elseif($paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'masspay_API_UserName' || $paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'masspay_API_Password' || $paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'masspay_API_Signature'):?>
						<?php if($j == 0):?>
							<fieldset class="form-block round-5">
								<legend class="round-5"><?php echo __l('Mass Payment Details'); ?></legend>  
								<div class="info-details">
									<p><?php echo __l('Masspay used to send money to user.');?></p>
									<p><?php echo __l('Create masspay API from paypal profile. Refer').' ';?><a href='https://www.paypal.com/in/cgi-bin/webscr'>https://www.paypal.com/in/cgi-bin/webscr</a></p>
								</div>
						<?php endif;?>
								<div class="clearfix test-mode-content">
									<span class="label-content"><?php echo Inflector::humanize($paymentGatewaySetting['PaymentGatewaySetting']['key']); ?></span>
									<div class="test-mode-left">
										<?php echo $form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.test_mode_value", $options); ?>
									</div>
									<div class="test-mode-right">
										<?php
											$options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['live_mode_value'];
											echo $form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.live_mode_value", $options);
										?>
									</div>
								</div>
						<?php if($j == 2):?>
							</fieldset>
						<?php endif;?>
						<?php $j++;?>
					<?php elseif($paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'directpay_API_UserName' || $paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'directpay_API_Password' || $paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'directpay_API_Signature'):?>
						<?php if($i == 0):?>
							<fieldset class="form-block round-5">
								<legend class="round-5"><?php echo __l('Direct Payment Details'); ?></legend>  
								<div class=" info-details">
									<p><?php echo __l('Direct pay allowed user to pay directly from credit card using capture authorization and void concept.');?></p>
									<p><?php echo __l('Refer').' ';?><a href='https://www.paypal.com/cgi-bin/webscr?cmd=_wp-pro-overview-outside'>https://www.paypal.com/cgi-bin/webscr?cmd=_wp-pro-overview-outside</a></p>
									<p><?php echo __l('It will let the user to pay only at the deal tipped state.');?></p>
								</div>
						<?php endif;?>
								<div class="clearfix test-mode-content">
									<span class="label-content"><?php echo Inflector::humanize($paymentGatewaySetting['PaymentGatewaySetting']['key']); ?></span>
									<div class="test-mode-left">
										<?php echo $form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.test_mode_value", $options); ?>
									</div>
									<div class="test-mode-right">
										<?php
											$options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['live_mode_value'];
											echo $form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.live_mode_value", $options);
										?>
									</div>
								</div>
						<?php if($i == 3):?>
							</fieldset>
						<?php endif;?>
						<?php $i++;?>
					<?php elseif($paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'authorize_net_api_key' || $paymentGatewaySetting['PaymentGatewaySetting']['key'] == 'authorize_net_trans_key'): ?>
						<div class="clearfix test-mode-content">
							<span class="label-content"><?php echo Inflector::humanize($paymentGatewaySetting['PaymentGatewaySetting']['key']); ?></span>
							<div class="test-mode-left">
								<?php echo $form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.test_mode_value", $options); ?>
							</div>
							<div class="test-mode-right">
								<?php
									$options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['live_mode_value'];
									echo $form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.live_mode_value", $options);
								?>
							</div>
						</div>
					<?php endif;?>
					<?php
				}
			}
		?>
	</fieldset>
	<div class="submit-block">
		<?php echo $form->submit(__l('Update')); ?>
		<div class="cancel-block">
			<?php echo $html->link(__l('Cancel'), array('controller' => 'payment_gateways', 'action' => 'index', 'admin' => true), array('class' => 'cancel-button'));?>
		</div>
	</div>
	<?php echo $form->end(); ?>
</div>