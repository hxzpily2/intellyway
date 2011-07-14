<?php /* SVN: $Id: $ */ ?>
<div class="paymentGatewaySettings form">
<h2><?php echo __l('Add Payment Gateway Settings');?></h2>
<div id="breadcrumb">
   <?php $html->addCrumb('Payment Gateways', array('controller' => 'payment_gateways','action' => 'index')); ?>
  <?php $html->addCrumb(__l('Add Payment Gateway Setting')); ?>
  <?php echo $html->getCrumbs(' &raquo; '); ?>
</div>
<?php echo $form->create('PaymentGatewaySetting', array('class' => 'normal'));?>
	<fieldset>
	<?php
		echo $form->input('payment_gateway_id');
		echo $form->input('key');
		echo $form->input('type', array('type' => 'select', 'options' => array('text' => 'text', 'textarea' => 'textarea', 'checkbox' => 'checkbox', 'radio' => 'radio', 'password' => 'password')));
		echo $form->input('value');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->end(__l('Add'));?>
</div>