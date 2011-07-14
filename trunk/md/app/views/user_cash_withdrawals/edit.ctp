<?php /* SVN: $Id: edit.ctp 44785 2011-02-19 10:54:51Z aravindan_111act10 $ */ ?>
<div class="userCashWithdrawals form">
<?php echo $form->create('UserCashWithdrawal', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo __l('Edit Withdraw Fund Request');?></h2>
	<?php
		if(Configure::read('site.currency_symbol_place') == 'left'):
			$currecncy_place = 'before';
		else:
			$currecncy_place = 'after';
		endif;	
	?>		
	<?php
		echo $form->input('id');
		echo $form->input('user_id',array('label' => __l('User')));
		echo $form->input('withdrawal_status_id',array('label' => __l('Withdrawal Status ')));
		echo $form->input('amount',array('label' => __l('Amount'),$currecncy_place => Configure::read('site.currency')));
		echo $form->input('remark',array('label' => __l('Remark')));
	?>
	</fieldset>
<?php echo $form->end(__l('Update'));?>
</div>
