<?php /* SVN: $Id: $ */ ?>
<h2><?php echo __l('Payment Gateways');?></h2>
<div class="home-page-block">
<div><?php echo $this->element('paging_counter');?></div>
<table class="list">
    <tr>
        <th><?php echo $paginator->sort(__l('display_name'));?></th>
        <th><?php echo $paginator->sort(__l('description'));?></th>
        <th><?php echo $paginator->sort(__l('Test Mode'), 'is_test_mode');?></th>
    </tr>
<?php
if (!empty($paymentGateways)):

$i = 0;
foreach ($paymentGateways as $paymentGateway):
	$class = null;
	$status_class = null;
	if ($i++ % 2 == 0) :
		$class = ' class="altrow"';
	endif;
?>
	<tr<?php echo $class;?>>
		<td>
			<div class="actions-block">
				<div class="actions round-5-left">
					<span><?php echo $html->link(__l('Edit'), array('action' => 'edit', $paymentGateway['PaymentGateway']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span>
				</div>
			</div>
			<?php echo $html->cText($paymentGateway['PaymentGateway']['display_name']);?>
		</td>
		<td><?php echo $html->cText($paymentGateway['PaymentGateway']['description']);?></td>
		<td>
			<?php 
				if($paymentGateway['PaymentGateway']['id'] != ConstPaymentGateways::Wallet):
					echo $html->cBool($paymentGateway['PaymentGateway']['is_test_mode']);
				else:
					echo '-';
				endif;
			?>
		</td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="9" class="notice"><?php echo __l('No Payment Gateways available');?></td>
	</tr>
<?php
endif;
?>
</table>
<?php if (!empty($paymentGateways)): ?>
	<div><?php echo $this->element('paging_links'); ?></div>
<?php endif; ?>
</div>