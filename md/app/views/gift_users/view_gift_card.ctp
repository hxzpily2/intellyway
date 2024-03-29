<?php /* SVN: $Id: add.ctp 756 2010-04-13 06:38:30Z preethi_083at09 $ */ ?>
<div class="giftUser">
	<?php if(empty($this->params['isAjax'])):?>
		<h2><?php echo __l('Gift Card');?></h2>	
	<?php endif; ?>
		<div class="clearfix <?php echo ($this->params['isAjax'])?'gift-card':'giftcard-bg';?>">
			<div class="gift-card clearfix">
            <div class="clearfix">
            	<div class="gift-side1">
                    <h3 class="gift-title"><span id="js-gift-from"><?php echo !empty($giftUser['GiftUser']['from']) ? $giftUser['GiftUser']['from'] : $giftUser['User']['username']; ?></span></h3>
                    <p> <?php echo __l('has given you'); ?></p>
                    <p class="card-amount"><span id="js-gift-amount"><?php echo $html->siteCurrencyFormat($html->cCurrency($giftUser['GiftUser']['amount'])); ?></span></p>
                    <p class="sitename-info"><?php echo sprintf(__l('credit to %s '),  Router::url('/', true)); ?></p>
                  
                </div>		
                <div class="gift-side2">
                    <dl class="card-info clearfix">
                    <dt><?php echo __l('to'); ?></dt>
                    <dd id="js-gift-to"><?php echo $giftUser['GiftUser']['friend_name']; ?></dd>
                    </dl>
                    <p id="js-gift-message" class="card-message">
					<?php echo $giftUser['GiftUser']['message']; ?>
                </p>
                </div>
                </div>
                  <div class="remeber-block">
                        <p class="redemption-code-left"><?php echo __l('Redemption Code:'); ?></p>
                        <p class="code-info redemption-code-right">
                            <?php echo $giftUser['GiftUser']['coupon_code']; ?>
                        </p>
                    </div>
			</div>
            <?php if(!$auth->user('id')): ?>
				<div class="gift-login login-right-block">
                     <?php echo $html->link(__l('Login'), '#', array('title' => __l('Login to Site'), 'class' => "register-link js-toggle-show {'container':'js-gift-card-login', 'hide_container': 'js-gift-card-register'}"));?>
					 <?php echo $html->link(__l('Register'), '#', array('title' => __l('Register to Site'), 'class' => "register-link js-toggle-show {'container':'js-gift-card-register', 'hide_container':'js-gift-card-login'}"));?>
                    	<div class="js-gift-card-login hide">
    						<?php echo $this->element('users-login', array('f' => 'gift_users/redeem/'.$giftUser['GiftUser']['coupon_code'], 'cache' => array('time' => Configure::read('site.element_cache'))));?>
                        </div>
                	<div class="js-gift-card-register hide">
						<?php echo $this->element('users-register', array('f' => 'gift_users/redeem/'.$giftUser['GiftUser']['coupon_code'], 'cache' => array('time' => Configure::read('site.element_cache'))));?>
                    </div>
                 </div>
				 <?php if(Configure::read('facebook.is_enabled_facebook_connect')):  ?>	
					<div class="deal-side2 login-side2 deal">
						<div class="deal-inner-block deal-bg clearfix">
						  <h3><?php echo __l('Connect'); ?></h3>
						  <p class="already-info"><?php echo __l('Already have an account on Facebook?'); ?></p>
						  <p><?php  sprintf(__l('Use it to sign in to %s'),Configure::read('site.name').'!'); ?></p>
						  <p>
							<?php  if (env('HTTPS')) { $fb_prefix_url = 'https://www.facebook.com/images/fbconnect/login-buttons/connect_dark_medium_short.gif';}else{ $fb_prefix_url = 'http://static.ak.fbcdn.net/images/fbconnect/login-buttons/connect_light_medium_short.gif';}?>
							<?php echo $html->link($html->image($fb_prefix_url, array('alt' => __l('[Image: Facebook Connect]'), 'title' => __l('Facebook connect'))), $fb_login_url, array('escape' => false)); ?>
						  </p>
						  <div class="deal-bot-bg"> </div>
						</div>
					  </div>
				 <?php endif; ?>
            <?php elseif(!$giftUser['GiftUser']['is_redeemed'] && $auth->user('user_type_id') != ConstUserTypes::Admin && $giftUser['GiftUser']['friend_mail'] == $auth->user('email')): ?>
				<div class="reedeem-block">
					 <?php echo $html->link(__l('Redeem'), array('controller'=> 'gift_users', 'action'=>'redeem', $giftUser['GiftUser']['coupon_code']), array('title'=>__l('Redeem'),'escape' => false));?>
				 </div>
            <?php endif; ?>
			</div>
		</div>
