<?php /* SVN: $Id: $ */ ?>
<div class="paypalDocaptureLogs index">
<h2><?php echo __l('Paypal Docapture Log');?></h2>
<?php echo $this->element('paging_counter');?>
<div class="overflow-block clearfix">
<table class="list">
    <tr>
        <th><?php echo $paginator->sort(__l('Date'),'created');?></th>         
        
        <th><?php echo $paginator->sort('authorizationid');?></th>
        <th><?php echo $paginator->sort('currencycode');?></th>
        <th><?php echo $paginator->sort('dodirectpayment_correlationid');?></th>
        <th><?php echo $paginator->sort('dodirectpayment_ack');?></th>
        <th><?php echo $paginator->sort('dodirectpayment_build');?></th>
        <th><?php echo $paginator->sort('dodirectpayment_amt');?></th>
        <th><?php echo $paginator->sort('dodirectpayment_avscode');?></th>
        <th><?php echo $paginator->sort('dodirectpayment_cvv2match');?></th>        
        <th><?php echo $paginator->sort('docapture_ack');?></th>
       
        <th><?php echo $paginator->sort('docapture_amt');?></th>
        <th><?php echo $paginator->sort('docapture_feeamt');?></th>
        <th><?php echo $paginator->sort('docapture_taxamt');?></th>
        <th><?php echo $paginator->sort('docapture_paymentstatus');?></th>
        <th><?php echo $paginator->sort('docapture_pendingreason');?></th>        
    </tr>
<?php
if (!empty($paypalDocaptureLogs)):

$i = 0;
foreach ($paypalDocaptureLogs as $paypalDocaptureLog):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td><div class="actions-block">
				<div class="actions round-5-left">
					<span><?php echo $html->link(__l('View'), array('controller' => 'paypal_docapture_logs', 'action' => 'view', $paypalDocaptureLog['PaypalDocaptureLog']['id']), array('class' => 'view', 'title' => __l('View')));?></span>
				</div>
			</div>
			<?php echo $html->cDateTime($paypalDocaptureLog['PaypalDocaptureLog']['created']);?></td>		
		<td><?php echo $html->cText($paypalDocaptureLog['PaypalDocaptureLog']['authorizationid']);?></td>
		<td><?php echo $html->cText($paypalDocaptureLog['PaypalDocaptureLog']['currencycode']);?></td>
		<td><?php echo $html->cText($paypalDocaptureLog['PaypalDocaptureLog']['dodirectpayment_correlationid']);?></td>
		<td><?php echo $html->cText($paypalDocaptureLog['PaypalDocaptureLog']['dodirectpayment_ack']);?></td>
		<td><?php echo $html->cText($paypalDocaptureLog['PaypalDocaptureLog']['dodirectpayment_build']);?></td>
		<td><?php echo $html->cFloat($paypalDocaptureLog['PaypalDocaptureLog']['dodirectpayment_amt']);?></td>
		<td><?php echo $html->cText($paypalDocaptureLog['PaypalDocaptureLog']['dodirectpayment_avscode']);?></td>
		<td><?php echo $html->cText($paypalDocaptureLog['PaypalDocaptureLog']['dodirectpayment_cvv2match']);?></td>

		<td><?php echo $html->cText($paypalDocaptureLog['PaypalDocaptureLog']['docapture_ack']);?></td>		
		<td><?php echo $html->cFloat($paypalDocaptureLog['PaypalDocaptureLog']['docapture_amt']);?></td>
		<td><?php echo $html->cFloat($paypalDocaptureLog['PaypalDocaptureLog']['docapture_feeamt']);?></td>
		<td><?php echo $html->cFloat($paypalDocaptureLog['PaypalDocaptureLog']['docapture_taxamt']);?></td>
		<td><?php echo $html->cText($paypalDocaptureLog['PaypalDocaptureLog']['docapture_paymentstatus']);?></td>
		<td><?php echo $html->cText($paypalDocaptureLog['PaypalDocaptureLog']['docapture_pendingreason']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="41" class="notice"><?php echo __l('No Paypal Docapture Logs available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($paypalDocaptureLogs)) {
    echo $this->element('paging_links');
}
?>
</div>
