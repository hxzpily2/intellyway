<?php /* SVN: $Id: index_print_deals.ctp 150 2010-04-07 13:25:55Z senthilkumar_017ac09 $ */?>
<script>
     window.print();
</script>
    <h2><?php echo $headings .' - '.((!empty($this->params['named']['filter_id'])) ? $dealStatuses[$this->params['named']['filter_id']] : (!empty($this->params['named']['type']) ? ucfirst($this->params['named']['type']) : '' )).__l(' Deals');?> </h2>
    <table border="1">
        <tr>
	   <?php if(!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] == ConstDealStatus::Upcoming) || ($this->params['named']['filter_id'] == ConstDealStatus::PendingApproval) || ($this->params['named']['filter_id'] == ConstDealStatus::Rejected) || ($this->params['named']['filter_id'] == ConstDealStatus::Canceled) || ($this->params['named']['filter_id'] == ConstDealStatus::Draft)){?>
            <th><?php echo __l('Deal Name'); ?></th>
            <th><?php echo __l('Original Price').' ('.Configure::read('site.currency').')'; ?></th>
            <th><?php echo __l('Discounted Price').' ('.Configure::read('site.currency').')'; ?></th>
    <?php }else{ ?>
            <th rowspan="2"><?php echo __l('Deal Name') ; ?></th>
            <th rowspan="2"><?php echo __l('Original Price').' ('.Configure::read('site.currency').')'; ?></th>
            <th rowspan="2"><?php echo __l('Discounted Price').' ('.Configure::read('site.currency').')'; ?></th>
            <th colspan="2"><?php echo __l('User'); ?></th>
            <th colspan="2"><?php echo __l('Amount').' ('.Configure::read('site.currency').')';?></th>
            <?php if((!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] != ConstDealStatus::Expired)) || !empty($this->params['named']['type']) ){?>
                <th rowspan="2"><?php echo __l('Commission').' (%)'; ?></th>
                <th rowspan="2"><?php echo __l('bonus_amount').' ('.Configure::read('site.currency').')'; ?></th>
                <th rowspan="2"><?php echo __l('Commission Amount').' ('.Configure::read('site.currency').')'; ?></th>
            <?php } ?>
             <?php if(!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] == ConstDealStatus::Open) || ($this->params['named']['filter_id'] == ConstDealStatus::Closed) || ($this->params['named']['filter_id'] == ConstDealStatus::PaidToCompany) || ($this->params['named']['filter_id'] == ConstDealStatus::Tipped)){?>
                  <th rowspan="2"><?php echo __l('Quantity Sold'); ?></th>
             <?php } ?>
        </tr>
        <tr>
            <th><?php echo __l('Target'); ?></th>
            <th><?php echo __l('Achieved'); ?></th>
            <th><?php echo __l('Target'); ?></th>
            <th><?php echo __l('Achieved'); ?></th>
        </tr>
    <?php } ?>
    <?php if(!empty($deals)): ?>
      <?php foreach($deals as $deal): ?>
    <?php if(!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] == ConstDealStatus::Upcoming) || ($this->params['named']['filter_id'] == ConstDealStatus::PendingApproval) || ($this->params['named']['filter_id'] == ConstDealStatus::Rejected) || ($this->params['named']['filter_id'] == ConstDealStatus::Canceled) || ($this->params['named']['filter_id'] == ConstDealStatus::Draft)){?>
        <tr>
            <td><?php echo $html->link($deal['Deal']['name'], array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('title'=>$deal['Deal']['name']));?></td>
            <td><?php echo $html->cCurrency($deal['Deal']['original_price']); ?></td>
            <td><?php echo $html->cCurrency($deal['Deal']['discounted_price']); ?></td>
        </tr>
        <?php } else {?>
        <tr>
            <td><?php echo $html->link($deal['Deal']['name'], array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('title'=>$deal['Deal']['name']));?></td>
            <td><?php echo $html->cCurrency($deal['Deal']['original_price']); ?></td>
            <td><?php echo $html->cCurrency($deal['Deal']['discounted_price']); ?></td>
            <td><?php echo $html->cInt($deal['Deal']['min_limit']); ?></td>
            <td><?php echo $html->cInt($deal['Deal']['deal_user_count']); ?></td>
            <td><?php echo $html->cCurrency($deal['Deal']['discounted_price'] * $deal['Deal']['min_limit']); ?></td>
            <td><?php echo $html->cCurrency($deal['Deal']['discounted_price'] * $deal['Deal']['deal_user_count']); ?></td>
            <?php if((!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] != ConstDealStatus::Expired)) || !empty($this->params['named']['type']) ){?>
                <td><?php echo $html->cFloat($deal['Deal']['commission_percentage']); ?></td>
                <td><?php echo $html->cCurrency($deal['Deal']['bonus_amount']); ?></td>
                <td><?php echo $html->cCurrency($deal['Deal']['total_commission_amount']); ?></td>
             <?php } ?>
             <?php if(!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] == ConstDealStatus::Open) || ($this->params['named']['filter_id'] == ConstDealStatus::Closed) || ($this->params['named']['filter_id'] == ConstDealStatus::PaidToCompany) || ($this->params['named']['filter_id'] == ConstDealStatus::Tipped)){?>
                 <td><?php echo $html->link($html->cInt($deal['Deal']['deal_user_count'], false),array('controller'=>'deal_users', 'action'=>'index', 'deal_id'=>$deal['Deal']['id']),array('class' => 'js-thickbox'));?></td>
            <?php } ?>
        </tr>
       <?php } ?>
      <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="11"><?php echo __l('No Deals available');?></td></tr>
    <?php endif; ?>
    </table>
