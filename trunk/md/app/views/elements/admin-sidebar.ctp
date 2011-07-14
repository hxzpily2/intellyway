<h5 class="hidden-info"><?php echo __l('Admin side links'); ?></h5>
<ul class="admin-links">
	<?php $class = ($this->params['controller'] == 'users' && $this->params['action'] == 'admin_stats') ? ' class="active"' : null; ?>
	<li <?php echo $class;?>><?php echo $html->link(__l('Site Stats'), array('controller' => 'users', 'action' => 'stats'),array('title' => __l('Site Stats'))); ?></li>
	<li class="no-bor">
		<h4><?php echo __l('Users'); ?></h4>
		<ul class="admin-sub-links">
			<?php $class = ($this->params['controller'] == 'user_profiles' ||  ($this->params['controller'] == 'users'  && ($this->params['action'] == 'admin_index' || $this->params['action'] == 'change_password' || $this->params['action'] == 'admin_add' )) ) ? ' class="active"' : null; ?>            
			<li <?php echo $class;?>><?php echo $html->link(__l('Users'), array('controller' => 'users', 'action' => 'index'),array('title' => __l('Users'))); ?></li>
			<?php $class = ( $this->params['controller'] == 'user_profiles') ? ' class="active"' : null; ?>
            <?php $class = ($this->params['controller'] == 'user_logins') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('User Logins'), array('controller' => 'user_logins', 'action' => 'index'),array('title' => __l('User Logins'))); ?></li>
			<?php $class = ($this->params['controller'] == 'user_comments') ? ' class="active"' : '';?>
			<li <?php echo $class; ?>><?php echo $html->link(__l('User Comments'), array('controller' => 'user_comments', 'action' => 'index'), array('title' => __l('User comments'), 'escape' => false)); ?></li>
		</ul>
	</li>
	<?php $class = ($this->params['controller'] == 'companies' || $this->params['controller'] == 'company_addresses') ? ' class="active"' : null; ?>
	<li <?php echo $class;?>><?php echo $html->link(__l('Companies'), array('controller' => 'companies', 'action' => 'index'),array('title' => __l('Companies'))); ?></li>
    <?php
    if($html->isWalletEnabled('is_enable_for_add_to_wallet')){
	   if((Configure::read('company.is_user_can_withdraw_amount')) || (Configure::read('user.is_user_can_with_draw_amount'))){?>
    <?php $class = ($this->params['controller'] == 'user_cash_withdrawals') ? ' class="active"' : null; ?>
	<li <?php echo $class;?>><?php echo $html->link(__l('Withdraw Fund Requests'), array('controller' => 'user_cash_withdrawals', 'action' => 'index'),array('title' => __l('Withdraw Fund Request'))); ?></li>
    <?php } } ?>
	<?php $class = ($this->params['controller'] == 'transactions') ? ' class="active"' : null; ?>
	<li <?php echo $class;?>><?php echo $html->link(__l('Transactions'), array('controller' => 'transactions', 'action' => 'index'),array('title' => __l('Transactions'))); ?></li>	
	<?php $class = ($this->params['controller'] == 'deals' && ($this->params['action'] == 'admin_index' || $this->params['action'] == 'admin_edit')) ? ' class="active"' : null; ?>
	<li class="no-bor">
   <h4><?php echo __l('Deals'); ?></h4>
    	<ul class="admin-sub-links">
    	<li <?php echo $class;?>>
    	 <?php echo $html->link(__l('Deals'), array('controller' => 'deals', 'action' => 'index'),array('title' => __l('Deals'))); ?>
        </li>
            <?php $class = ($this->params['controller'] == 'deals' && $this->params['action'] == 'add') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Add Deal'), array('controller' => 'deals', 'action' => 'add'), array('title' => __l('Add Deal'))); ?></li>
		    <?php $class = ($this->params['controller'] == 'deal_users') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Deal Coupons'), array('controller' => 'deal_users', 'action' => 'index'), array('title' => __l('Deal Coupons'))); ?></li>
        </ul>
    </li>
    <?php $class = ($this->params['controller'] == 'gift_users') ? ' class="active"' : null; ?>
	<li <?php echo $class;?>><?php echo $html->link(__l('Gift Cards'), array('controller' => 'gift_users', 'action' => 'index'),array('title' => __l('Gift Cards'))); ?></li>
	<li class="no-bor">
		<h4><?php echo __l('Subscriptions'); ?></h4>
		<ul class="admin-sub-links">
		<?php $class = ($this->params['controller'] == 'subscriptions') ? ' class="active"' : null; ?>
		<li <?php echo $class;?>><?php echo $html->link(__l('Subscriptions'), array('controller' => 'subscriptions', 'action' => 'index'),array('title' => __l('Subscriptions'))); ?></li>
		</ul>
	</li>
    <li class="no-bor">
		<h4><?php echo __l('Suggestions'); ?></h4>
		<ul class="admin-sub-links">
			<?php $class = ($this->params['controller'] == 'city_suggestions') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Cities'), array('controller' => 'city_suggestions', 'action' => 'index'), array('title' => __l('City Suggestions'))); ?></li>
			<?php $class = ($this->params['controller'] == 'business_suggestions') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Business'), array('controller' => 'business_suggestions', 'action' => 'index'), array('title' => __l('Business Suggestions'))); ?></li>
		</ul>
	</li>
    <li class="no-bor">
		<h4><?php echo __l('Topics'); ?></h4>
		<ul class="admin-sub-links">
			<?php $class = ($this->params['controller'] == 'topics') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Topics'), array('controller' => 'topics', 'action' => 'index'),array('title' => __l('Topics'))); ?></li>
			<?php $class = ($this->params['controller'] == 'topic_discussions') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Topic Discussions'), array('controller' => 'topic_discussions', 'action' => 'index'),array('title' => __l('Topic Discussions'))); ?></li>
		</ul>
	</li>
	<li class="no-bor">
		<h4><?php echo __l('Payment'); ?></h4>
		<ul class="admin-sub-links">
			<?php $class = ($this->params['controller'] == 'payment_gateways') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Payment Gateways'), array('controller' => 'payment_gateways', 'action' => 'index'), array('title' => __l('Payment Gateways')));?></li>
			<?php $class = ($this->params['controller'] == 'paypal_transaction_logs' && $this->params['named']['type'] == 'normal') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Payment Transaction Log'), array('controller' => 'paypal_transaction_logs', 'action' => 'index', 'type' => 'normal'),array('title' => __l('Payment Transaction Log'))); ?></li>
			<?php $class = ($this->params['controller'] == 'paypal_transaction_logs' && $this->params['named']['type'] == 'mass') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Mass Payment Transaction Log'), array('controller' => 'paypal_transaction_logs', 'action' => 'index', 'type' => 'mass'),array('title' => __l('Mass Payment Transaction Log'))); ?></li>
			<?php $class = ($this->params['controller'] == 'paypal_docapture_logs') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Paypal Docapture Log'), array('controller' => 'paypal_docapture_logs', 'action' => 'index'),array('title' => __l('Paypal Docapture Log'))); ?></li>
			<?php $class = ($this->params['controller'] == 'authorizenet_docapture_logs') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Authorizenet Docapture Log'), array('controller' => 'authorizenet_docapture_logs', 'action' => 'index'),array('title' => __l('Authorizenet Docapture Log'))); ?></li>
		</ul>
	</li>
	<li class="no-bor">
		<h4><?php echo __l('Masters'); ?></h4>
		<ul class="admin-sub-links">
			<?php $class = ($this->params['controller'] == 'settings') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'index'),array('title' => __l('Settings'))); ?></li>
			<?php $class = ($this->params['controller'] == 'email_templates') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Email Templates'), array('controller' => 'email_templates', 'action' => 'index'),array('title' => __l('Email Templates'))); ?></li>
			<?php $class = ($this->params['controller'] == 'pages') ? ' class="active"' : null; ?>
            <li <?php echo $class;?>><?php echo $html->link(__l(' Manage Static Pages'), array('controller' => 'pages', 'action' => 'index', 'plugin' => NULL),array('title' => __l('Manage Static Pages')));?></li>
			<?php $class = ($this->params['controller'] == 'transaction_types') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Transaction Types'), array('controller' => 'transaction_types', 'action' => 'index'),array('title' => __l('Transaction Types'))); ?></li>
			<?php $class = ($this->params['controller'] == 'translations') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Translations'), array('controller' => 'translations', 'action' => 'index'),array('title' => __l('Translations'))); ?></li>
			<?php $class = ($this->params['controller'] == 'languages') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Languages'), array('controller' => 'languages', 'action' => 'index'),array('title' => __l('Languages'))); ?></li>
			<?php $class = ($this->params['controller'] == 'banned_ips') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Banned IPs'), array('controller' => 'banned_ips', 'action' => 'index'),array('title' => __l('Banned IPs'))); ?></li>
			<?php $class = ($this->params['controller'] == 'cities') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Cities'), array('controller' => 'cities', 'action' => 'index'),array('title' => __l('Cities'))); ?></li>
			<?php $class = ($this->params['controller'] == 'states') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('States'), array('controller' => 'states', 'action' => 'index'),array('title' => __l('States'))); ?></li>
			<?php $class = ($this->params['controller'] == 'countries') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('Countries'), array('controller' => 'countries', 'action' => 'index'),array('title' => __l('Countries'))); ?></li>
			<?php $class = ($this->params['controller'] == 'user_educations') ? ' class="active"' : null; ?>
    		<li <?php echo $class;?>><?php echo $html->link(__l('Education'), array('controller' => 'user_educations', 'action' => 'index'), array('title' => __l('Education'))); ?></li>
            <?php $class = ($this->params['controller'] == 'user_employments') ? ' class="active"' : null; ?>
    		<li <?php echo $class;?>><?php echo $html->link(__l('Employment'), array('controller' => 'user_employments', 'action' => 'index'), array('title' => __l('Employment'))); ?></li>
    		<?php $class = ($this->params['controller'] == 'user_income_ranges') ? ' class="active"' : null; ?>
    		<li <?php echo $class;?>><?php echo $html->link(__l('Income Range'), array('controller' => 'user_income_ranges', 'action' => 'index'), array('title' => __l('Income Range'))); ?></li>
    		<?php $class = ($this->params['controller'] == 'user_relationships') ? ' class="active"' : null; ?>
    		<li <?php echo $class;?>><?php echo $html->link(__l('Relationship'), array('controller' => 'user_relationships', 'action' => 'index'), array('title' => __l('Relationship'))); ?></li>
    		<?php $class = ($this->params['controller'] == 'mail_chimp_lists') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $html->link(__l('MailChimp Mailing List'), array('controller' => 'mail_chimp_lists', 'action' => 'index'), array('title' => __l('MailChimp Mailing List'))); ?></li>
		</ul>
	</li>
</ul>