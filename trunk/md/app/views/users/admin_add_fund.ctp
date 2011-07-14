<?php /* SVN: $Id: admin_add.ctp 6515 2010-06-02 10:45:44Z sreedevi_140ac10 $ */ ?>
<div class="users form">
	<h2> <?php echo $this->pageTitle;?></h2>
<?php echo $form->create('User', array('action' => 'add_fund', 'class' => 'normal'));?>
	<fieldset>
	<?php
	if(Configure::read('site.currency_symbol_place') == 'left'):
		$currecncy_place = 'before';
	else:
		$currecncy_place = 'after';
	endif;	
?>		
 	<p class="fund-available"><?php echo sprintf(__l('Available balance amount: %s'), $html->siteCurrencyFormat($html->cCurrency($user['User']['available_balance_amount']))); ?></p>
	<?php
        echo $form->input('Transaction.user_id', array('type' => 'hidden'));
		echo $form->input('Transaction.amount', array($currecncy_place => Configure::read('site.currency')));
		echo $form->input('Transaction.description');		
	?>
	</fieldset>
	<div class="submit-block clearfix">
<?php echo $form->end(__l('Add Fund'));?> </div>
</div>