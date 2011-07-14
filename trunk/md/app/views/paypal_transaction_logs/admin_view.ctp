<?php /* SVN: $Id: $ */ ?>
<div class="paypalTransactionLogs view">
<h2><?php echo __l('Paypal Transaction Log');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['id']) ? $html->cInt($paypalTransactionLog['PaypalTransactionLog']['id']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Date Added');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cDateTime($paypalTransactionLog['PaypalTransactionLog']['created']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('User');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['User']['username']) ? $html->link($html->cText($paypalTransactionLog['User']['username']), array('controller' => 'users', 'action' => 'view', $paypalTransactionLog['User']['username'], 'admin' => false), array('escape' => false)) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Ip');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['ip']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['ip']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Currency Type');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['currency_type']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['currency_type']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Txn Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['txn_id']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['txn_id']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Payer Email');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['payer_email']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['payer_email']) : '-' ;?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Payment Date');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['payment_date']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['payment_date']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Email');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['email']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['email']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('To Digicurrency');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['to_digicurrency']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['to_digicurrency']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('To Account No');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['to_account_no']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['to_account_no']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('To Account Name');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['to_account_name']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['to_account_name']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Fees Paid By');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['fees_paid_by']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['fees_paid_by']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Mc Gross');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['mc_gross']) ? $html->cFloat($paypalTransactionLog['PaypalTransactionLog']['mc_gross']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Mc Fee');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['mc_fee']) ? $html->cFloat($paypalTransactionLog['PaypalTransactionLog']['mc_fee']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Mc Currency');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['mc_currency']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['mc_currency']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Payment Status');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['payment_status']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['payment_status']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Pending Reason');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['pending_reason']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['pending_reason']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Receiver Email');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['receiver_email']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['receiver_email']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Paypal Response');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['paypal_response']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['paypal_response']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Error No');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['error_no']) ? $html->cInt($paypalTransactionLog['PaypalTransactionLog']['error_no']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Error Message');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['error_message']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['error_message']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Memo');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['memo']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['memo']) : '-';?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Paypal Post Vars');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo !empty($paypalTransactionLog['PaypalTransactionLog']['paypal_post_vars']) ? $html->cText($paypalTransactionLog['PaypalTransactionLog']['paypal_post_vars']) : '-';?></dd>
	</dl>
</div>

