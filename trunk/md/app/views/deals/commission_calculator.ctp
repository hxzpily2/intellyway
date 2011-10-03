<?php /* SVN: $Id: commission_calculator.ctp 44785 2011-02-19 10:54:51Z aravindan_111act10 $ */ ?>
<br/>
<h2><?php echo __l('Commission Calculator'); ?></h2>
<br/>
<?php
	if(empty($this->data['Deal']['user_id'])):
		//echo $form->create('Deal', array('action'=> 'commission_calculator', 'class' => 'normal'));
	endif;
?>
<div class="clearfix">
	<?php
		if(Configure::read('site.currency_symbol_place') == 'left'):
			$currecncy_place = 'before';
		else:
			$currecncy_place = 'after';
		endif;	
	?>
	<?php
		echo $form->input('calculator_discounted_price',array('label'=>__l('Discounted price'), $currecncy_place => Configure::read('site.currency')));
		echo $form->input('calculator_bonus_amount', array('label'=> __l('Bonus Amount'), 'value' => '0.00'));
	?>
</div>
<div class="clearfix">
	<?php
		echo $form->input('calculator_commission_percentage', array('label'=>__l('Commission (%)')));
		echo $form->input('calculator_min_limit', array('label'=>__l('No. of buyers')));
	?>
</div>
<?php
	if(empty($this->data['Deal']['user_id'])):
		//echo $form->end(__l('Calculate'));
	endif;
?>
<dl class="result-list clearfix">
	<dt><?php echo __l('Total Purchased Amount: '); ?></dt>
	<dd><span class="js-calculator-purchased"><?php echo $html->siteCurrencyFormat((!empty($this->data['Deal']['calculator_total_purchased_amount'])) ? $this->data['Deal']['calculator_total_purchased_amount'] : 0); ?></span></dd>
	<dt><?php echo __l('Total Commission Amount: '); ?></dt>
	<dd><span class="js-calculator-commission"><?php echo $html->siteCurrencyFormat((!empty($this->data['Deal']['calculator_total_commission_amount'])) ? $this->data['Deal']['calculator_total_commission_amount'] : 0); ?></span></dd>
	<?php if($auth->user('user_type_id') == ConstUserTypes::Admin):?>
		<dt><?php echo __l('Net Profit: '); ?></dt>
		<dd><span class="js-calculator-net-profit"><?php echo $html->siteCurrencyFormat((!empty($this->data['Deal']['calculator_net_profit'])) ? $this->data['Deal']['calculator_net_profit'] : 0); ?></span></dd>
	<?php endif; ?>
</dl>