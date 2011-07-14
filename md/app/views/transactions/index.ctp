<?php /* SVN: $Id: index.ctp 40719 2011-01-10 09:27:33Z josephine_065at09 $ */ ?>
<?php if(empty($this->params['named']['stat']) && !isset($this->data['Transaction']['tab_check'])): ?>
<h2><?php echo __l('Transactions'); ?></h2>
    <div class="js-tabs">
        <ul class="clearfix">
            <li><?php echo $html->link(__l('Today'), array('controller' => 'transactions', 'action' => 'index', 'stat' => 'day'), array('title' => 'Day Transactions')); ?></li>
            <li><?php echo $html->link(__l('This Week'), array('controller' => 'transactions', 'action' => 'index', 'stat' => 'week'), array('title' => 'This Week Transactions')); ?></li>
            <li><?php echo $html->link(__l('This Month'), array('controller' => 'transactions', 'action' => 'index', 'stat' => 'month'), array('title' => 'This Month Transactions')); ?></li>
            <li><?php echo $html->link(__l('All'), array('controller' => 'transactions', 'action' => 'index', 'stat' => 'all'), array('title' => 'All Transactions')); ?></li>
        </ul>
    </div>
<?php else: ?>
    <div class="transactions index js-response js-responses">
    <?php
        echo $form->create('Transaction', array('action' => 'index' ,'class' => 'normal js-ajax-form'));
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
        echo $form->input('tab_check', array('type' => 'hidden','value' => 'tab_check')); ?>
       	  <div class="submit-block clearfix">
            <?php
            	echo $form->submit(__l('Filter'));
            ?>
            </div>
            <?php
            	echo $form->end();
            ?>
    <?php echo $this->element('paging_counter');?>
    <table class="list">
        <tr>
            <th><div class="js-pagination"><?php echo $paginator->sort(__l('Date'), 'created');?></div></th>
            <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Description'),'transaction_type_id');?></div></th>
            <th class="dr"><div class="js-pagination"><?php echo $paginator->sort(__l('Credit'), 'amount').' ('.Configure::read('site.currency').')';?></div></th>
            <th class="dr"><div class="js-pagination"><?php echo $paginator->sort(__l('Debit'), 'amount').' ('.Configure::read('site.currency').')';?></div></th>
        </tr>
    <?php
		if (!empty($transactions)):
			$i = 0;
			$j = 1;
			foreach ($transactions as $transaction):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
	?>
        <tr<?php echo $class;?>>
            <td><?php echo $html->cDateTime($transaction['Transaction']['created']);?></td>
            <td class="dl">
				<?php if(!empty($transaction['Transaction']['description'])):?>
					<?php echo $html->cText($transaction['Transaction']['description']); ?>					
				<?php else:?>
					<?php echo $html->transactionDescription($transaction);?>
				<?php endif;?>
            </td>
            <td class="dr">
                <?php
                    if($transaction['TransactionType']['is_credit']):
                        echo $html->cCurrency($transaction['Transaction']['amount']);
                    else:
                        echo '--';
                    endif;
                 ?>
            </td>
            <td class="dr">
                <?php
                    if($transaction['TransactionType']['is_credit']):
                        echo '--';
                    else:
                        echo $html->cCurrency($transaction['Transaction']['amount']);
                    endif;
                 ?>
            </td>
        </tr>
    <?php
        $j++;
        endforeach;
    ?>
    <?php
    else:
    ?>
        <tr>
            <td colspan="11" class="notice"><?php echo __l('No Transactions available');?></td>
        </tr>
    <?php
    endif;
    ?>
    </table>
    <table class="list">
        <tr>
            <td colspan="4" class="dr"><?php echo __l('Credit');?></td>
            <td class="dr"><?php echo Configure::read('site.currency') . $html->cCurrency($total_credit_amount);?></td>
        </tr>
        <tr>
            <td colspan="4" class="dr"><?php echo __l('Debit');?></td>
            <td class="dr"><?php echo Configure::read('site.currency') . $html->cCurrency($total_debit_amount);?></td>
        </tr>
		<?php if ((Configure::read('company.is_user_can_withdraw_amount') && $auth->user('user_type_id') == ConstUserTypes::Company) || (Configure::read('user.is_user_can_with_draw_amount') && $auth->user('user_type_id') == ConstUserTypes::User)): ?>
        <tr>
            <td colspan="4" class="dr"><?php echo __l('Withdraw Request');?></td>
            <td class="dr"><?php echo Configure::read('site.currency') . $html->cCurrency($blocked_amount);?></td>
        </tr>
		<?php endif;?>
        <tr class="total-block">
            <td colspan="4" class="dr">
			<?php if ((Configure::read('company.is_user_can_withdraw_amount') && $auth->user('user_type_id') == ConstUserTypes::Company) || (Configure::read('user.is_user_can_with_draw_amount') && $auth->user('user_type_id') == ConstUserTypes::User)): ?>
				<?php echo __l('Transaction Summary (Cr - Db - Withdraw Request)');?>
			<?php else:?>
				<?php echo __l('Transaction Summary (Cr - Db)');?>			
			<?php endif;?>
			</td>
            <td class="dr"><?php echo Configure::read('site.currency') . $html->cCurrency($total_credit_amount - ($total_debit_amount + $blocked_amount));?></td>
        </tr>
        <tr class="total-block">
            <td colspan="4" class="dr"><?php echo __l('Account Balance');?></td>
            <td class="dr"><?php echo Configure::read('site.currency') . $html->cCurrency($user_available_balance);?></td>
        </tr>
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
    </div>
<?php endif; ?>