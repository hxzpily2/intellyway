<?php /* SVN: $Id: admin_index.ctp 24627 2010-09-17 05:34:53Z sakthivel_135at10 $ */ ?>
	<?php 
		if(!empty($this->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<?php 
$debit_total_amt = $credit_total_amt = $gateway_total_fee = 0;
$credit = $debit = 1;
if(!empty($this->params['named']['type']) && ($this->params['named']['type'] == ConstTransactionTypes :: AddedToWallet) && !empty($this->params['named']['stat'])) {
    $debit = 0;
}
if(!empty($this->params['named']['type']) && ($this->params['named']['type'] == ConstTransactionTypes::ReferralAmountPaid || $this->params['named']['type'] == ConstTransactionTypes::AcceptCashWithdrawRequest || $this->params['named']['type'] == ConstTransactionTypes::PaidDealAmountToCompany) && !empty($this->params['named']['stat'])) {
    $credit = 0;
}
?>
<div class="transactions index js-responses">
	<?php if(empty($this->params['named']['page'])): ?>
		<h2><?php echo $pageTitle . ((!empty($selected_user_info)) ? $selected_user_info : ''); ?></h2>
		<?php echo $form->create('Transaction' , array('action' => 'admin_index', 'type' => 'post', 'class' => 'normal search-form clearfix js-ajax-form')); ?>
		<?php echo $form->autocomplete('User.username', array('label' => __l('User'), 'acFieldKey' => 'Transaction.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));
		if(!empty($this->data['Transaction']['user_id'])) {
			echo $form->input('user_hidden_id',array('type' => 'hidden', 'value' => $this->data['Transaction']['user_id']));
		}
		?>
			<div class="clearfix date-time-block">
				<div class="input date-time clearfix">
					<div class="js-datetime">
						<?php echo $form->input('from_date', array('label' => __l('From'), 'type' => 'date', 'minYear' => date('Y')-10, 'maxYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'))); ?>
					</div>
				</div>
				<div class="input date-time end-date-time-block clearfix">
					<div class="js-datetime">
						<?php echo $form->input('to_date', array('label' => __l('To '),  'type' => 'date', 'minYear' => date('Y')-10, 'maxYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'))); ?>
					</div>
				</div>
			</div>  
			<?php
			echo $form->submit(__l('Filter'));
			 ?>
		<?php echo $form->end(); ?>
	<?php endif;?>
	<div class="js-response">
	<div class="add-block">
	<?php if(!empty($transactions)) { ?>
	<?php echo $html->link(__l('CSV'), array('controller' => 'transactions', 'action' => 'index', 'city' => $city_slug, 'hash' => $export_hash, 'ext' => 'csv', 'admin' => true), array('class' => 'export', 'title' => __l('CSV'), 'escape' => false)); ?>
	<?php } ?>
	</div>
	<?php echo $this->element('paging_counter');?>
    <table class="list">
        <tr>
            <th><div class="js-pagination"><?php echo $paginator->sort(__l('Date'), 'Transaction.created');?></div></th>
            <?php if(empty($this->params['named']['user_id'])):	 ?>
                <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('User'), 'User.username');?></div></th>
            <?php endif; ?>
            <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Description'),'TransactionType.name');?></div></th>
            <?php if(!empty($credit)){ ?>
                <th class="dr"><div class="js-pagination"><?php echo $paginator->sort(__l('Credit'), 'Transaction.amount').' ('.Configure::read('site.currency').')';?></div></th>
            <?php } ?>
            <?php if(!empty($debit)){?>
                <th class="dr"><div class="js-pagination"><?php echo $paginator->sort(__l('Debit'), 'Transaction.amount').' ('.Configure::read('site.currency').')';?></div></th>
            <?php } ?>
            <th class="dr"><div class="js-pagination"><?php echo $paginator->sort(__l('Gateway Fees'), 'Transaction.gateway_fees').' ('.Configure::read('site.currency').')';?></div></th>
        </tr>
    <?php
    if (!empty($transactions)):
    $i = 0;
    foreach ($transactions as $transaction):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
    ?>
        <tr<?php echo $class;?>>
                <td><?php echo $html->cDateTime($transaction['Transaction']['created']);?></td>
				<?php if(empty($this->params['named']['user_id'])):	?>
                    <td class="dl">
						<?php echo $html->getUserAvatarLink($transaction['User'], 'micro_thumb', false); ?>
						<?php echo $html->getUserLink($transaction['User']); ?>
					</td>
	            <?php endif; ?>
                <td class="dl">
					<?php if(!empty($transaction['Transaction']['description'])):?>
						<?php echo $html->cText($transaction['Transaction']['description']); ?>					
					<?php else:?>
						<?php echo $html->transactionDescription($transaction);?>
					<?php endif;?>
                </td>
                <?php if(!empty($credit)) {?>
                    <td class="dr">
                        <?php
                            if($transaction['TransactionType']['is_credit']):
                                echo $html->cCurrency($transaction['Transaction']['amount']);
								$credit_total_amt = $credit_total_amt + $transaction['Transaction']['amount']; 

                            else:
                                echo '--';
                            endif;
                         ?>
                    </td>
                <?php } ?>
                <?php if(!empty($debit)) {?>
                    <td class="dr">
                        <?php
                            if($transaction['TransactionType']['is_credit']):
                                echo '--';
                            else:
                                echo $html->cCurrency($transaction['Transaction']['amount']);
							    $debit_total_amt = $debit_total_amt + $transaction['Transaction']['amount'];
                            endif;
                         ?>
                    </td>
                <?php } ?>
                <td class="dr">
					<?php echo $html->cFloat($transaction['Transaction']['gateway_fees']);
						 $gateway_total_fee = $gateway_total_fee + $transaction['Transaction']['gateway_fees']; ?>
			    </td>
            </tr>
    <?php
        endforeach; ?>

		<tr class="total-block">
            <td colspan="<?php echo (!empty($this->params['named']['user_id'])) ? 2 : 3;?>" class="dr"><?php echo __l('Total');?></td>
             <?php if(!empty($credit)) {?>
            <td class="dr"><?php echo Configure::read('site.currency') . $html->cCurrency($credit_total_amt);?></td>
			 <?php } if(!empty($debit)) {?>
			<td class="dr"><?php echo Configure::read('site.currency') . $html->cCurrency($debit_total_amt);?></td> 
			<?php } ?>
			<td class="dr"><?php echo Configure::read('site.currency') . $html->cCurrency($gateway_total_fee);?></td>
        </tr>
   <?php else:
    ?>
        <tr>
            <td colspan="11" class="notice"><?php echo __l('No Transactions available');?></td>
        </tr>
    <?php
    endif;
    ?>
    </table> 
    <?php
    if (!empty($transactions)) {
        ?>
            <div class="js-pagination">
                <?php echo $this->element('paging_links'); ?>
            </div>
        <?php
    }
    ?>
	<?php if(empty($this->params['named']['stat'])):?>
      <table class="list">
		<tr>
				<th colspan='5' class="dr"> <?php echo __l('Filter Summary');?></th> 
		</tr>
        <tr>
            <td colspan="4" class="dr"><?php echo __l('Credit');?></td>
            <td class="dr"><?php echo Configure::read('site.currency') . $html->cCurrency($total_credit_amount);?></td>
        </tr>
        <tr>
            <td colspan="4" class="dr"><?php echo __l('Debit');?></td>
            <td class="dr"><?php echo Configure::read('site.currency') . $html->cCurrency($total_debit_amount);?></td>
        </tr>
        <tr class="total-block">
            <td colspan="4" class="dr"><?php echo __l('Transaction Summary (Credit - Debit)');?></td>
            <td class="dr"><?php echo Configure::read('site.currency') . $html->cCurrency($total_credit_amount - $total_debit_amount);?></td>
        </tr>
    </table>
	<?php endif;?>

	   <?php if(!empty($this->params['named']['user_id'])): ?>
		   <table class="list">
		   <tr>
				<th colspan='5' class="dr"> <?php echo __l('User Summary') .$selected_user_info;?></th> 
		   </tr>
			<tr>
				<td colspan="4" class="dr"><?php echo __l('Credit');?></td>
				<td class="dr"><?php echo Configure::read('site.currency') . $html->cCurrency($credit_total_amt);?></td>
			</tr>
			<tr>
				<td colspan="4" class="dr"><?php echo __l('Debit');?></td>
				<td class="dr"><?php echo Configure::read('site.currency') . $html->cCurrency($debit_total_amt);?></td>
			</tr>
			<tr>
				<td colspan="4" class="dr"><?php echo __l('Withdraw Request');?></td>
				<td class="dr"><?php echo Configure::read('site.currency') . $html->cCurrency($user['User']['blocked_amount']);?></td>
			</tr>
			<tr class="total-block">
				<td colspan="4" class="dr"><?php echo __l('Transaction Summary (Cr - Db - Withdraw Request)');?></td>
				<td class="dr"><?php echo Configure::read('site.currency') . $html->cCurrency($credit_total_amt - ($debit_total_amt + $user['User']['blocked_amount']));?></td>
			</tr>
			<tr class="total-block">
				<td colspan="4" class="dr"><?php echo $selected_user_info.'  '.__l('Account Balance');?></td>
				<td class="dr"><?php echo Configure::read('site.currency') . $html->cCurrency($user['User']['available_balance_amount']);?></td>
			</tr>
		</table>
	 <?php endif; ?>
</div>
</div>
