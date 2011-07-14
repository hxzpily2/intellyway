<?php /* SVN: $Id: admin_deduct_amount.ctp 3 2010-04-07 06:03:46Z siva_063at09 $ */ ?>
<div class="transactions form js-response js-responses">
<?php echo $form->create('Company', array('action' => 'deductamount', 'admin' => true, 	'class' => 'normal js-ajax-form'));?>
	<fieldset>
 		<h2><?php echo __l('Deduct Amount');?></h2>
	<?php
		foreach($companies as  $company)
		{
			?>
			<h3><?php echo $html->cText($company['Company']['name']); ?></h3>
			<?php echo __l('Available Balance: ').$html->siteCurrencyFormat($html->cCurrency($company['User']['available_balance_amount']));?>
            <?php if($company['User']['available_balance_amount'] > 0): ?>
				<?php
					if(Configure::read('site.currency_symbol_place') == 'left'):
						$currecncy_place = 'before';
					else:
						$currecncy_place = 'after';
					endif;	
				?>
				<div class="required "><?php echo $form->input('Company.'.$company['Company']['id'].'.amount', array($currecncy_place => Configure::read('site.currency'), 'label' => __l('Amount')));?>
				</div>
                <?php echo $form->input('Company.'.$company['Company']['id'].'.user_id', array('type' => 'hidden', 'value' => $company['Company']['user_id']));?>
                <?php echo $form->input('Company.'.$company['Company']['id'].'.description', array('type' => 'textarea', 'label' => __l('Description')));?>
             <?php endif; ?>
            <?php
		}
	?>
	</fieldset> 
		<div class="submit-block clearfix">
<?php 
	if(empty($company['User']['available_balance_amount']) || $company['User']['available_balance_amount'] == '0.00'):
		echo $form->submit(__l('Update'),array('disabled' => true));
	else:
		echo $form->submit(__l('Update'));
	endif;
?>
<div class="cancel-block">
	<?php echo $html->link(__l('Cancel'), array('controller' => 'companies', 'action' => 'index'), array('class' => 'js-deduct-disable', 'title' => __l('Cancel'), 'escape' => false));?>
</div>
</div>
<?php echo $form->end();?>
</div>
