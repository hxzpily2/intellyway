<?php /* SVN: $Id: add.ctp 44785 2011-02-19 10:54:51Z aravindan_111act10 $ */ ?>
<div class="userCashWithdrawals form js-ajax-form-container js-responses">
	<div class="page-info">
    	<?php echo __l('The requested amount will be deducted from your wallet and the amount will be blocked until it get approved or rejected by the administrator. Once its approved, the requested amount will be sent to your paypal account. In case of failure, the amount will be refunded to your wallet.'); ?>
    </div>
    <?php echo $form->create('UserCashWithdrawal', array('action' => 'add','class' => "normal js-ajax-add-form {container:'js-ajax-form-container',responsecontainer:'js-responses'}"));?>
	<fieldset>
	<?php
		if(Configure::read('site.currency_symbol_place') == 'left'):
			$currecncy_place = 'before';
		else:
			$currecncy_place = 'after';
		endif;	
	?>	
	<?php
		if($auth->user('user_type_id') == ConstUserTypes::User){
			$min = Configure::read('user.minimum_withdraw_amount');
			$max = Configure::read('user.maximum_withdraw_amount');	
		}else if($auth->user('user_type_id') == ConstUserTypes::Company){
			$min = Configure::read('company.minimum_withdraw_amount');
			$max = Configure::read('company.maximum_withdraw_amount');
		}
		echo $form->input('amount',array($currecncy_place => Configure::read('site.currency') . '<span class="info">' . sprintf(__l('Minimum withdraw amount: %s <br/> Maximum withdraw amount: %s'),$html->siteCurrencyFormat($html->cCurrency($min)),$html->siteCurrencyFormat($html->cCurrency($max)) . '</span>')));
		echo $form->input('user_id',array('type' => 'hidden'));
		echo $form->input('user_type_id',array('type' => 'hidden','value'=>$auth->user('user_type_id')));
	?>
	</fieldset>
        <div class="submit-block clearfix">
        <?php
        	echo $form->submit(__l('Withdraw and Confirm'));
        ?>
        </div>
        <?php
        	echo $form->end();
        ?>
</div>
