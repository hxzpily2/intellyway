<?php /* SVN: $Id: buy.ctp 44816 2011-02-19 12:02:30Z aravindan_111act10 $ */ ?>
	<?php if ($this->params['controller'] == 'deals' && $this->params['action'] == 'buy'):?>		
			<?php echo $this->element('deal-faq', array('cache' => array('time' => Configure::read('site.element_cache'))));?>		
	<?php endif;?>
	<br/><br/>
	<h2><?php echo __l('Your Purchase'); ?></h2>
	<br/><br/>	
	<div class="buying-form">
	<?php echo $form->create('Deal', array('action' => 'buy', 'class' => 'normal')); ?>
    	<table class="list" id="mytable">
        	<tr>
            	<th class="dl"><?php echo __l('Description'); ?></th>
                <th><?php echo __l('Quantity'); ?></th>
                <th class="dr"><?php echo __l('Price'); ?></th>
                <th class="dr"><?php echo __l('Total'); ?></th>
            </tr>
            <tr>
            	<td class="dl spec">
					<p class="deal-name"><?php echo $html->link($deal['Deal']['name'], array('controller'=>'deals','action'=>'view',$deal['Deal']['slug']), array('title' => $deal['Deal']['name']));?></p>
				<p class="gift-link"><?php
						 echo $html->link(sprintf(__l('Give this %s as a gift'),Configure::read('site.name')), array('controller'=>'deals','action'=>'buy',$deal['Deal']['id'],'type' => 'gift'), array('class' => 'gift', 'title' => sprintf(__l('Give this %s as a gift'),Configure::read('site.name'))));
                ?></p>
                </td>
				<td><?php
						$min_info = $deal['Deal']['buy_min_quantity_per_user'];
						$max_info = $deal['Deal']['buy_max_quantity_per_user'];
						if(empty($deal['Deal']['buy_max_quantity_per_user']) && empty($deal['Deal']['max_limit'])){
							$max_info = __l('Unlimited');
						}
						elseif(!empty($deal['Deal']['buy_max_quantity_per_user']) && !empty($deal['Deal']['max_limit'])){
							if(!empty($user_quantity)){
								$user_balance = $deal['Deal']['buy_max_quantity_per_user'] - $user_quantity;
							}
							else{
								$user_balance = $deal['Deal']['buy_max_quantity_per_user'];
							}
							$current_balance = $deal['Deal']['max_limit'] - $deal['Deal']['deal_user_count'];
                            if($current_balance  < $user_balance) {
                                $max_info = $current_balance;
                            } else{
								 $max_info = $user_balance;
							}							
						}
						elseif(!empty($deal['Deal']['buy_max_quantity_per_user']) && empty($deal['Deal']['max_limit'])){
							if(!empty($user_quantity)){
								$max_info = $deal['Deal']['buy_max_quantity_per_user'] - $user_quantity;
							}
							else{
								$max_info = $deal['Deal']['buy_max_quantity_per_user'];
							}
						}
						elseif(empty($deal['Deal']['buy_max_quantity_per_user']) && !empty($deal['Deal']['max_limit'])){
							$max_info = $deal['Deal']['max_limit'] - $deal['Deal']['deal_user_count'];
						}
						
						if(!empty($max_info)){
							if($max_info < $min_info){
								$max_info = $min_info;
							}
						}							
						echo $form->input('quantity',array('label' => false, 'class' => 'js-quantity', 'after' => '<span class="infomd">' . sprintf(__l('Minimum Quantity: %s <br /> Maximum Quantity: %s'),$min_info,$max_info). '</span>'));?>
                        <?php echo $form->input('user_available_balance',array('type' => 'hidden', 'value' => $user_available_balance));  ?>
                </td>
				<td class="dr"><?php echo $html->siteCurrencyFormat($html->cCurrency($this->data['Deal']['deal_amount'])); ?></td>
				<td class="dr">
					<?php if(Configure::read('site.currency_symbol_place') == 'left'):?>
						<?php echo Configure::read('site.currency');?><span class="js-deal-total"><?php echo $html->cCurrency($this->data['Deal']['total_deal_amount']); ?></span>
					<?php else:?>
						<span class="js-deal-total"><?php echo $html->cCurrency($this->data['Deal']['total_deal_amount']); ?></span><?php echo Configure::read('site.currency');?>
					<?php endif;?>
				</td>
            </tr>
			<?php if(Configure::read('wallet.is_handle_wallet_as_in_groupon') && $auth->sessionValid()):?>
			<?php if(!empty($user_available_balance) && $user_available_balance != '0.00'):?>
			<tr>
				<td class="dr buy-dr" colspan="3"><?php echo Configure::read('site.name').' '.__l('bucks')?></td>
				<td class="dr buy-dr"><?php echo ' - '.$html->siteCurrencyFormat($html->cCurrency($user_available_balance ? $user_available_balance : 0)); ?></td>
			</tr>
			<?php endif;?>			
			<tr>
				<td class="dr buy-dr" colspan="3"><?php echo __l('My Price:').' '?></td>
				<td class="dr buy-dr">
				<?php $my_price = ($user_available_balance > $this->data['Deal']['total_deal_amount']) ? 0 : ($this->data['Deal']['total_deal_amount'] - $user_available_balance); ?>
				<?php if(Configure::read('site.currency_symbol_place') == 'left'):?>
					<?php echo Configure::read('site.currency');?><span class="js-amount-need-to-pay"><?php echo $html->cCurrency($my_price); ?>
				<?php else:?>
					<span class="js-amount-need-to-pay"><?php echo $html->cCurrency($my_price);?></span> <?php echo Configure::read('site.currency'); ?>
				<?php endif;?>
				</td>
			</tr>
			<?php endif;?>
        </table>
    
		 <?php 
            echo $form->input('deal_id',array('type' => 'hidden')); 
            echo $form->input('user_id',array('type' => 'hidden')); 
            echo $form->input('is_gift',array('type' => 'hidden')); 
            echo $form->input('deal_amount',array('type' => 'hidden')); 
        ?>
        <?php if($this->data['Deal']['is_gift'] || !$auth->sessionValid() || (!empty($user['User']['fb_user_id']) && empty($user['User']['email'])) ||!empty($gateway_options['paymentGateways'])):	 ?>
			<div class="login-left-block">
					<?php if($this->data['Deal']['is_gift']): ?>
						<div class="deal-gift-form">
							<?php
								echo $form->input('gift_from',array('label' => __l('From'))); 
								echo $form->input('gift_to',array('label' => __l('Friend Name'))); 
								echo $form->input('gift_email',array('label' => __l('Friend Email'))); 
								echo $form->input('message',array('type' => 'textarea', 'label' => __l('Message'))); 
							?>
						</div>
					<?php endif; ?>
					<?php if(Configure::read('wallet.is_handle_wallet_as_in_groupon')):?>
                    	<?php 
							$show_class= '';
							if($this->data['Deal']['total_deal_amount'] <= $user_available_balance)
								$show_class = 'hide';
							if($this->data['Deal']['deal_amount'] == 0)
								$show_class = '';	
						?>		
							  
						<div class="js-payment-gateway <?php echo $show_class; ?>">
					<?php else:?>
						<div class="clearfix">
					<?php endif;?>
					<?php if(!$auth->sessionValid() || (!empty($user['User']['fb_user_id']) && empty($user['User']['email']))): ?>
						<div class="deal-gift-form">
							<?php
								if(!$auth->sessionValid()):
									echo $form->input('User.username',array('label' => __l('Username'),'info' => __l('Must start with an alphabet. <br/> Must be minimum of 3 characters and <br/> Maximum of 20 characters <br/> No special characters and spaces allowed')));
									echo $form->input('User.email',array('label' => __l('Email')));
									echo $form->input('User.passwd', array('label' => __l('Password')));
									echo $form->input('User.confirm_password', array('type' => 'password', 'label' => __l('Password Confirmation')));
								elseif(!empty($user['User']['fb_user_id']) && empty($user['User']['email'])):
									echo $form->input('User.email',array('label' => __l('Email')));
								endif;  ?>
						</div>
					  <?php endif; ?>
					  <?php
						if(!isset($is_show_credit_card)):
							$is_show_credit_card = 0;
							if (empty($gateway_options['Paymentprofiles'])):
								$is_show_credit_card = 1;
							endif;
						endif;
					  ?>
                      <?php if($this->data['Deal']['deal_amount'] == 0){
					  			echo $form->input('payment_gateway_id', array('type' => 'hidden'));
					  		}
							else{
					  echo $form->input('payment_gateway_id', array('legend' => __l('Payment Type'), 'type' => 'radio', 'options' => $gateway_options['paymentGateways'], 'class' => 'js-payment-type {"is_show_credit_card":"' . $is_show_credit_card . '"}'));?>
                     
					<div class="user-payment-profile js-show-payment-profile <?php echo (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet]) && (empty($this->data['Deal']['payment_gateway_id']) || $this->data['Deal']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet)) ? '' : 'hide'; ?>">
						<?php 
							if (!empty($gateway_options['Paymentprofiles'])):
								echo $form->input('payment_profile_id', array('legend' => __l('Pay with this card(s)'), 'type' => 'radio', 'options' => $gateway_options['Paymentprofiles']));
								echo $html->link(__l('Add new card'), '#', array('class' => 'js-add-new-card'));
							endif;
						?>
					</div>
					<?php if (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::CreditCard]) || !empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet])): ?>
						<div class="clearfix js-credit-payment <?php echo ($this->data['Deal']['payment_gateway_id'] == ConstPaymentGateways::CreditCard || (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet]) && $is_show_credit_card)) ? '' : 'hide'; ?>">
						  <div class="billing-left">
						  <h3><?php echo __l('Billing Information'); ?></h3>
							<?php
								echo $form->input('Deal.firstName', array('label' => __l('First Name')));
								echo $form->input('Deal.lastName', array('label' => __l('Last Name')));
								echo $form->input('Deal.creditCardType', array('label' => __l('Card Type'), 'type' => 'select', 'options' => $gateway_options['creditCardTypes']));
								echo $form->input('Deal.creditCardNumber', array('AUTOCOMPLETE' => 'OFF', 'label' => __l('Card Number'))); ?>
								<div class="input date">
								<label><?php echo __l('Expiration Date'); ?> </label>
								<?php echo $form->month('Deal.expDateMonth', date('m'), array(), false); 
								echo $form->year('Deal.expDateYear', date('Y'), date('Y')+25, date('Y')+2, array(), false);?>
								</div>
								<?php echo $form->input('Deal.cvv2Number', array('AUTOCOMPLETE' => 'OFF', 'maxlength' =>'4', 'label' => __l('Card Verification Number:')));
							?>
							</div>
						  <div class="billing-right">
							<h3><?php echo __l('Billing Address'); ?></h3>
							<?php
								echo $form->input('Deal.address', array('label' => __l('Address')));
								echo $form->input('Deal.city', array('label' => __l('City')));
								echo $form->input('Deal.state', array('label' => __l('State')));
								echo $form->input('Deal.zip', array('label' => __l('Zip code')));
								echo $form->input('Deal.country', array('label' => __l('Country'), 'type' => 'select', 'options' => $gateway_options['countries'], 'empty' => __l('Please Select')));
								echo $form->input('Deal.is_show_new_card', array('type' => 'hidden', 'id' => 'UserIsShowNewCard'));
							 ?>   
							 </div>
						</div>
					<?php endif; ?>    
					
                 <?php } ?>
                 </div>
                <div class="submit-block clearfix">
					<?php if(Configure::read('wallet.is_handle_wallet_as_in_groupon')):?>
						<?php echo $form->input('is_purchase_via_wallet', array('type' => 'hidden', 'value' => ($this->data['Deal']['total_deal_amount'] <= $user_available_balance) ? 1 : 0));?>
					<?php endif;?>
					<a class="blue_button" href="#" onclick="javascript:$('#DealBuyForm').submit()"><span><?php echo __l('Complete My Order'); ?></span></a>                    
                    <!--<?php echo $form->submit(__l('Complete My Order'),array('title' => __l('Complete My Order'), 'class' => ((!empty($user_available_balance) || $user_available_balance != '0.00')  ? 'js-buy-confirm' : '')));?>-->
                    <!-- <div class="cancel-block"> -->
                        <?php
                            if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'gift'){
                            	 echo $html->link($html->tag('span', __l('Cancel'), array('class' => '')), array('controller' => 'deals', 'action' => 'buy',$deal['Deal']['id'], 'admin' => false),array('escape'=>false,'class'=>'pink_button'));
                                 //echo $html->link(__l('Cancel'), array('controller' => 'deals', 'action' => 'buy',$deal['Deal']['id'], 'admin' => false), array('class' => 'cancel-button'));
                            } else {
                            	echo $html->link($html->tag('span', __l('Cancel'), array('class' => '')), array('controller' => 'deals', 'action' => 'view',$deal['Deal']['slug'], 'admin' => false),array('escape'=>false,'class'=>'grey_button'));
                                //echo $html->link(__l('Cancel'), array('controller' => 'deals', 'action' => 'view',$deal['Deal']['slug'], 'admin' => false), array('class' => 'cancel-button'));
                            }
                        ?>
                    <!-- </div> -->
                </div>
			  </div>
       	<?php else: ?>
            <div class="submit-block clearfix">
                <?php echo $form->submit(__l('Complete My Order'),array('title' => __l('Complete My Order'), 'class' => ($user_available_balance ? 'js-buy-confirm' : '')));?>
                <div class="cancel-block">
                    <?php
                        if(!empty($this->params['named']['type']) && $this->params['named']['type'] == 'gift'){
                             echo $html->link(__l('Cancel'), array('controller' => 'deals', 'action' => 'buy',$deal['Deal']['id'], 'admin' => false), array('class' => 'cancel-button'));
                        }else{
                            echo $html->link(__l('Cancel'), array('controller' => 'deals', 'action' => 'view',$deal['Deal']['slug'], 'admin' => false), array('class' => 'cancel-button'));
                        }
    
                    ?>
                </div>
            </div>
        <?php endif; ?>
		<?php	echo $form->end();?>
    <?php if(!$auth->sessionValid()):?>
		<div class="login-right-block js-right-block">
            <div class="login-message-lineheight js-login-message ">
                <h3><?php echo __l('Already Have An Account?');?></h3>
               
                <div class="clearfix">
                 <p class="login-info-block"><?php echo sprintf(__l('If you have purchased a %s before, you can sign in using your %s.'), Configure::read('site.name'),Configure::read('user.using_to_login')); ?></p>
                <div class="submit-block cancel-block submit-cancel-block">
                    <?php echo $html->link(__l('Login'), '#', array('title' => __l('Sign In'), 'class' => "cancel-button js-toggle-show {'container':'js-login-form', 'hide_container':'js-login-message'}"));?>
                </div>
                </div>
                <div class="facebook-block">
            <?php if(!(!empty($this->params['prefix']) && $this->params['prefix'] == 'admin') and Configure::read('facebook.is_enabled_facebook_connect')):  ?>
                <div class="facebook-left">
                <p class="already-info"><?php echo __l('Already have an account on Facebook?'); ?></p>
                <p><?php echo sprintf(__l('Use it to sign in to %s!'), Configure::read('site.name')); ?></p>
                </div>
                <div class="facebook-right">
					<?php  if (env('HTTPS')) { $fb_prefix_url = 'https://www.facebook.com/images/fbconnect/login-buttons/connect_dark_medium_short.gif';}else{ $fb_prefix_url = 'http://static.ak.fbcdn.net/images/fbconnect/login-buttons/connect_light_medium_short.gif';}?>
					<?php echo $html->link($html->image($fb_prefix_url, array('alt' => __l('[Image: Facebook Connect]'), 'title' => __l('Facebook connect'))), $fb_login_url, array('escape' => false)); ?>
                </div>
			
            <?php endif; ?>
            	</div>
            </div>
            <div class="js-login-form hide">
                <?php
				// Temp Fix Avoid teh Validation Message in login Page due the Validation the Another Form
				unset($this->validationErrors['User']['username']);
				unset($this->validationErrors['User']['passwd']);
				echo $this->element('users-login', array('f' => 'deals/buy/'.$this->data['Deal']['deal_id'], 'cache' => array('time' => Configure::read('site.element_cache'))));?>
            </div>
        </div>
    <?php endif;?>
	</div>
	