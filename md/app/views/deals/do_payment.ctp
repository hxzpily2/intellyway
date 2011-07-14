<?php /* SVN: $Id: do_payment.ctp 44785 2011-02-19 10:54:51Z aravindan_111act10 $ */ ?>
<h2><?php echo sprintf(__l('Buy %s Deal'),$deal['Deal']['name']);?></h2>
    <div class="wallet-amount-block">
		<?php echo __l('Amount: '); ?><?php echo $html->siteCurrencyFormat($html->cCurrency($amount)); ?>
    </div>
      <div class="submit-block clearfix">
<?php if($action == 'pagseguro'):
		$pagSeguro->form($gateway_options);
		$pagSeguro->data(); ?>
         <div class="submit-block clearfix">
		<?php
		$pagSeguro->submit($gateway_options);
		?>
		</div>
		<?php
	else:
		$gateway->$action($gateway_options);
	endif;
?>
</div>
