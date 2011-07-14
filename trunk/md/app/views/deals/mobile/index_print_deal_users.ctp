<script>
	window.print();
</script>
    <h2><?php echo $html->cText($deal_list['deal_name']);?> </h2>
    <p><?php echo __l('Total Quantity Sold').': '.$html->cInt($deal_list['deal_user_count']);?> </p>
    <table border="1">
        <tr>
            <th><?php echo __l('Username'); ?></th>
            <th><?php echo __l('Quantity'); ?></th>
            <th><?php echo __l('Amount'); ?></th>
            <th><?php echo __l('Coupon Code'); ?></th>
            <th><?php echo __l('Expires On'); ?></th>
        </tr>
    <?php if(!empty($deals)): ?>
    
    <?php foreach($deals as $deal): ?>
        <tr>
            <td><?php echo $html->cText($deal['Deal']['username']);?></td>
            <td><?php echo $html->cInt($deal['Deal']['quantity']); ?></td>
            <td><?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['discount_amount'])); ?></td>
            <td><?php echo '#'.$html->cText($deal['Deal']['coupon_code']); ?></td>
            <td><?php echo $html->cDateTime($deal['Deal']['coupon_expiry_date']); ?></td>
        </tr>
    <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="11"><?php echo __l('No coupons available');?></td></tr>
    <?php endif; ?>
    </table>
