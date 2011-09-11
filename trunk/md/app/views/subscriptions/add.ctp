<?php /* SVN: $Id: add.ctp 44740 2011-02-19 08:13:56Z aravindan_111act10 $ */ ?>
<?php if(preg_match('/subscribe/s',$this->params['url']['url']) && Configure::read('site.enable_three_step_subscription') && !$auth->sessionValid()): ?>
    <div class="form">
    
	<?php echo $form->create('Subscription', array('id' => 'homeSubscriptionFrom', 'class' => 'normal js-grouponpro_sub_form {Currentstep:'.$Currentstep.'}'));?>
		
			<div class="clearfix">
				<div class="js-step_one step-one js-form_step">
					<div class="step-content-info round-10">
					<div class="step-input-block">
					<?php echo $form->input('city_id',array('id' => 'homeCityId', 'label' => __l('Choose your city:'), 'options' => $cities)); ?>				
                    </div>
                    <div class="js-buttons">
                    <div class="clearfix">
                    <div class="submit">
						<?php echo $form->button(__l('Continue'), array('type'=>'button','id' => 'step_one', 'class' => 'js-button js-continue'));?>
                        </div>
                        </div>
                    		<p class="sign-in">
								<?php if(!$auth->sessionValid()): ?>
									<?php echo __l('or').' '.$html->link(__l('Sign in'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Sign in'),'class'=>'login-link'));?>
								<?php elseif($auth->user('user_type_id') == ConstUserTypes::User):?>
									<?php echo $html->link(__l('My Stuff'), array('controller' => 'users', 'action' => 'my_stuff'), array('title' => __l('My Stuff')));?>
								<?php elseif($auth->user('user_type_id') == ConstUserTypes::Company):?>
									<?php echo $html->link(__l('My Deals'), array('controller' => 'deals', 'action' => 'index', 'company' => $company['Company']['slug'] ), array('title' => __l('My Deals')));?>
								<?php elseif($auth->user('user_type_id') == ConstUserTypes::Admin):?>
									<?php echo $html->link(__l('Admin'), array('controller' => 'users' , 'action' => 'stats' , 'admin' => true), array('title' => __l('Admin'))); ?>
								<?php endif;?>
								<div>
									<?php echo $html->link(__l('Skip'), array('controller' => 'subscriptions', 'action' => 'skip'), array('title' => __l('Skip'), 'class'=>'login-link'));?>
								</div>
							</p>
					</div>
				</div>
				</div>
				<div class="js-step_two step-one js-form_step">
				<div class="step-content-info round-10">
				<div class="step-input-block">
					<?php echo $form->input('email',array('id' => 'homeEmail', 'label' => __l('Enter your Email address:'))); ?>				
                    </div>
                         <div class="clearfix">
                     		<?php echo $form->submit(__l('Subscribe'));?>
						</div>
                    		<p class="sign-in">
								<?php if(!$auth->sessionValid()): ?>
									<?php echo __l('or').' '.$html->link(__l('Sign in'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Sign in'),'class'=>'login-link'));?>
								<?php elseif($auth->user('user_type_id') == ConstUserTypes::User):?>
									<?php echo $html->link(__l('My Stuff'), array('controller' => 'users', 'action' => 'my_stuff'), array('title' => __l('My Stuff')));?>
								<?php elseif($auth->user('user_type_id') == ConstUserTypes::Company):?>
									<?php echo $html->link(__l('My Deals'), array('controller' => 'deals', 'action' => 'index', 'company' => $company['Company']['slug'] ), array('title' => __l('My Deals')));?>
								<?php elseif($auth->user('user_type_id') == ConstUserTypes::Admin):?>
									<?php echo $html->link(__l('Admin'), array('controller' => 'users' , 'action' => 'stats' , 'admin' => true), array('title' => __l('Admin'))); ?>
								<?php endif;?>
								<br/>
								<div>
									<?php echo $html->link(__l('Skip'), array('controller' => 'subscriptions', 'action' => 'skip'), array('title' => __l('Skip'), 'class'=>'login-link'));?>
								</div>
							</p>
				</div>
                </div>
			</div>
		<?php echo $form->end(); ?>
    </div>
<?php elseif(preg_match('/subscribe/s',$this->params['url']['url']) ): ?>
<h2><?php echo $city_name ;?> <?php echo __l('Deal of the Day'); ?></h2>
    <div class="form subscriptions-add">
		<?php echo $form->create('Subscription', array('id' => 'homeSubscriptionFrom', 'class' => 'normal'));?>
        	<h2 class="welcome-head"> <?php echo __l('Welcome to').' ';?><span><?php echo Configure::read('site.name'); ?></span></h2>
				<div class="subscriptions-content">
					<?php echo sprintf(__l('Every day, %s e-mails you one exclusive offer to do, see, taste, or experience something amazing in').' '.$city_name.' '.__l('at an unbeatable price.'),Configure::read('site.name')); ?>
				</div>
				
				<div class="subscriptions-content-form round-10 clearfix">
                <div class="signup-content"><?php echo __l('Sign up now for free, and prepare to discover') . ' ' . $city_name . ' ' . __l('at 40% to 90% off! '); ?></div>
                <div class="clearfix">
					<?php echo $form->input('email',array('id' => 'homeEmail', 'label' => __l('Enter your Email address:'))); ?>
                    <?php echo $form->input('city_id',array('id' => 'homeCityId', 'label' => __l('Choose your city:'), 'options' => $cities)); ?>
                        <div class="clearfix">
                	<?php echo $form->submit(__l('Subscribe'));?>
                    </div>
				</div>
				<p class="subcription-info"><?php echo __l('(We\'ll never share your e-mail address) '); ?></p>
				</div>

				<?php echo $form->end(); ?>
					<div class="subscriptions-content subscriptions-offer-info">
                <?php echo __l('Our daily offers are for:'); ?>
                <?php echo __l('Restaurants, Spas, Concerts, Bars, Sporting Events, Classes, Salons,Adventures and so much more... '); ?>
                </div>
    </div>
<?php else: ?>
    <div class="subscriptions form clearfix">
		<?php echo $form->create('Subscription', array('class' => 'subscription round-10 clearfix'));?>
        	<?php 
				if(!empty($city_id)):
					$this->data['Subscription']['city_id'] = $city_id;
				endif;
			?>
            <?php echo $form->input('email',array('label' => __l('Email'), 'class' => 'emailsubscription')); ?>
			<?php 
			if(!empty($this->data['Subscription']['city_id'])):
				echo $form->input('city_id',array('type' => 'hidden', 'value' => $this->data['Subscription']['city_id'])); 
			else:
				echo $form->input('city_id',array('type' => 'hidden')); 
			endif;			
			?>
			
		<div style="padding-top:4px;">
       		<a class="pink_button" href="#" onclick="$('form').submit();"><span><?php echo __l('Subscribe'); ?></span></a>
        </div>	
		<?php echo $form->end(); ?>	
		
		
        <?php /*echo $form->end(__l('Subscribe'));*/ ?>
        
         
    </div>
<?php endif; ?>