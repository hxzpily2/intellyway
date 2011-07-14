<?php /* SVN: $Id: index_company_deals.ctp 6574 2010-06-02 12:53:05Z senthilkumar_017ac09 $ */?>
<?php if(empty($this->params['isAjax'])): ?>
<h2><?php echo $headings; ?> </h2>
	<div class="js-tabs">
        <ul class="clearfix">
                <li><?php echo $html->link(sprintf(__l('Open (%s)'),$dealStatusesCount[ConstDealStatus::Open]), array('controller' => 'deals', 'action' => 'index', 'filter_id' => ConstDealStatus::Open, 'company' => $company_slug), array('title' => __l('Open')));?></li>
                <?php $all = $dealStatusesCount[ConstDealStatus::Open]; ?>
        		<?php foreach($dealStatuses as $id => $dealStatus): ?>
                	<?php if($id != ConstDealStatus::Open): ?>
                        <li><?php echo $html->link(sprintf(__l("%s"),$dealStatus.' ('.$dealStatusesCount[$id].')'), array('controller' => 'deals', 'action' => 'index', 'filter_id' => $id, 'company' => $company_slug), array('title' => $dealStatus));?></li>
                        <?php $all += $dealStatusesCount[$id]; ?>
                     <?php endif; ?>
                <?php endforeach; ?>
                <li><?php echo $html->link(sprintf(__l('All (%s)'),$all),array('controller'=> 'deals', 'action'=>'index', 'type' => 'all', 'company' => $company_slug),array('title' => __l('All'))); ?></li>
            </ul>
    </div>
<?php else: ?>
     <?php if(!empty($this->params['named']['filter_id']) && (!empty($dealStatusesCount[$this->params['named']['filter_id']]))){
        $id = $this->params['named']['filter_id'];
     }else if(!empty($this->params['named']['type']) && ($this->params['named']['type'] == 'all')){
        $id = $this->params['named']['type'];
     }
     ?>
    <div class="js-response">
    <?php echo $this->element('paging_counter'); ?>
    <table class="list company-list">
        <tr>
	   <?php if(!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] == ConstDealStatus::Upcoming) || ($this->params['named']['filter_id'] == ConstDealStatus::PendingApproval) || ($this->params['named']['filter_id'] == ConstDealStatus::Rejected) || ($this->params['named']['filter_id'] == ConstDealStatus::Canceled) || ($this->params['named']['filter_id'] == ConstDealStatus::Draft)){?>
            <th class="dl deal-name"><div class="js-pagination"><?php echo $paginator->sort(__l('Deal Name'),'Deal.name') ; ?></div></th>
            <th class="dr"><div class="js-pagination"><?php echo $paginator->sort(__l('Original Price'), 'Deal.original_price').' ('.Configure::read('site.currency').')'; ?></div></th>
            <th class="dr"><div class="js-pagination"><?php echo $paginator->sort(__l('Discounted Price'), 'Deal.discounted_price').' ('.Configure::read('site.currency').')'; ?></div></th>
    <?php }else{ ?>
            <th rowspan="2" class="deal-name"><div class="js-pagination"><?php echo $paginator->sort('Deal Name','name') ; ?></div></th>
            <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort('original_price').' ('.Configure::read('site.currency').')'; ?></div></th>
            <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort('discounted_price').' ('.Configure::read('site.currency').')'; ?></div></th>
            <th colspan="2"><?php echo __l('Quantity'); ?></th>
            <th colspan="2"><?php echo __l('Amount').' ('.Configure::read('site.currency').')';?></th>
            <?php if((!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] != ConstDealStatus::Expired)) || !empty($this->params['named']['type']) ){?>
                <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort('Commission','commission_percentage').' (%)'; ?></div></th>
                <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort('bonus_amount').' ('.Configure::read('site.currency').')'; ?></div></th>
                <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort('Commission Amount','total_commission_amount').' ('.Configure::read('site.currency').')'; ?></div></th>
            <?php } ?>
             <?php if(!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] == ConstDealStatus::Open) || ($this->params['named']['filter_id'] == ConstDealStatus::Closed) || ($this->params['named']['filter_id'] == ConstDealStatus::PaidToCompany) || ($this->params['named']['filter_id'] == ConstDealStatus::Tipped)){?>
                  <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Quantity Sold'),'Deal.deal_user_count'); ?></div></th>
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

            <td class="dl deal-name">
                <?php if(!empty($this->params['named']['filter_id']) && $this->params['named']['filter_id'] == ConstDealStatus::Draft):?>
                    <div class="actions-block">
                        <div class="actions round-5-left">
                            <span><?php echo $html->link(__l('Edit'), array('controller' => 'deals', 'action'=>'edit', $deal['Deal']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span>
                            <span><?php echo $html->link(__l('Delete'), array('controller' => 'deals', 'action'=>'delete', $deal['Deal']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
                            <span><?php echo $html->link(__l('Save'), array('controller' => 'deals', 'action'=>'update_status', $deal['Deal']['id']), array('class' => 'add', 'title' => __l('Save and Send for admin Approval')));?></span>
                        </div>
                    </div>
                <?php endif; ?>
                <?php echo $html->showImage('Deal', $deal['Attachment'], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($deal['Deal']['name'], false)), 'title' => $html->cText($deal['Deal']['name'], false)));?>
                <?php echo $html->link($deal['Deal']['name'], array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('title'=>$deal['Deal']['name']));?>
            </td>
            <td class="dr"><?php echo $html->cCurrency($deal['Deal']['original_price']); ?></td>
            <td class="dr"><?php echo $html->cCurrency($deal['Deal']['discounted_price']); ?></td>
        </tr>
        <?php } else {?>
        <tr>
            <td class="dl deal-name">
                <div class="actions-block">
                    <div class="actions round-5-left">
						<?php if(!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] == ConstDealStatus::Tipped) || ($this->params['named']['filter_id'] == ConstDealStatus::Closed) || ($this->params['named']['filter_id'] == ConstDealStatus::PaidToCompany)):?>
                            <span><?php echo $html->link(__l('CSV of Coupons'), array('controller' => 'deals', 'action' => 'coupons_export', 'deal_id' =>  $deal['Deal']['id'], 'filter_id' => $id, 'ext' => 'csv'), array('class' => 'export', 'title' => __l('CSV of Coupons')));?></span>
                            <span> <?php echo $html->link(__l('Print of Coupons'),array('controller' => 'deals', 'action' => 'deals_print', 'filter_id' => $this->params['named']['filter_id'],'page_type' => 'print', 'deal_id' => $deal['Deal']['id'], 'company' => $company_slug),array('title' => __l('Print of Coupons'), 'target' => '_blank', 'class'=>'print-icon'));?></span>
						<?php endif; ?>
						<span><?php echo $html->link(__l('Clone Deal'),array('controller'=>'deals', 'action'=>'add', 'clone_deal_id'=>$deal['Deal']['id']), array('class' => 'add', 'title' => __l('Clone Deal')));?></span>
                    </div>
                </div>
                <?php echo $html->showImage('Deal', $deal['Attachment'], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($deal['Deal']['name'], false)), 'title' => $html->cText($deal['Deal']['name'], false)));?>
                <?php echo $html->link($deal['Deal']['name'], array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('title'=>$deal['Deal']['name']));?>
            </td>
            <td class="dr"><?php echo $html->cCurrency($deal['Deal']['original_price']); ?></td>
            <td class="dr"><?php echo $html->cCurrency($deal['Deal']['discounted_price']); ?></td>
            <td><?php echo $html->cInt($deal['Deal']['min_limit']); ?></td>
            <td><?php echo $html->cInt($deal['Deal']['deal_user_count']); ?></td>
            <td class="dr"><?php echo $html->cCurrency($deal['Deal']['discounted_price'] * $deal['Deal']['min_limit']); ?></td>
            <td class="dr"><?php echo $html->cCurrency($deal['Deal']['discounted_price'] * $deal['Deal']['deal_user_count']); ?></td>
            <?php if((!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] != ConstDealStatus::Expired)) || !empty($this->params['named']['type']) ){?>
                <td><?php echo $html->cFloat($deal['Deal']['commission_percentage']); ?></td>
                <td class="dr"><?php echo $html->cCurrency($deal['Deal']['bonus_amount']); ?></td>
                <td class="dr"><?php echo $html->cCurrency($deal['Deal']['total_commission_amount']); ?></td>
             <?php } ?>
             <?php if(!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] == ConstDealStatus::Open) || ($this->params['named']['filter_id'] == ConstDealStatus::Closed) || ($this->params['named']['filter_id'] == ConstDealStatus::PaidToCompany) || ($this->params['named']['filter_id'] == ConstDealStatus::Tipped)){?>
                 <td><?php echo $html->link($html->cInt($deal['Deal']['deal_user_count'], false),array('controller'=>'deal_users', 'action'=>'index', 'deal_id'=>$deal['Deal']['id']),array('class' => 'js-thickbox'));?></td>
            <?php } ?>
        </tr>
       <?php } ?>
      <?php endforeach; ?>
    <?php else: ?>
        <tr><td class="notice" colspan="11"><?php echo __l('No Deals available');?></td></tr>
    <?php endif; ?>
    </table>
    </div>
<?php endif; ?>