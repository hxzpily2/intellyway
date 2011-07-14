<?php /* SVN: $Id: do_payment.ctp 44816 2011-02-19 12:02:30Z aravindan_111act10 $ */ ?>
<h2><?php echo __l('Add amount to wallet');?></h2>
    <div class="wallet-amount-block">
        <?php echo __l('Amount: ') ; ?><?php echo $html->siteCurrencyFormat($html->cCurrency($amount)); ?>
    </div>
<?php
	if($action == 'pagseguro'):
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

