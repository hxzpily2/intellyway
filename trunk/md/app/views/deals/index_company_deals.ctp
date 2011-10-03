<?php /* SVN: $Id: index_company_deals.ctp 40953 2011-01-11 13:57:21Z ramkumar_136act10 $ */?>
<?php if(empty($this->params['isAjax'])): ?>
<h2><?php echo $headings; ?> </h2>
<br/><br/>
	<div class="js-tabs">
        <ul class="clearfix">
                <li><?php echo $html->link(sprintf('Open (%s)',$dealStatusesCount[ConstDealStatus::Open]), array('controller' => 'deals', 'action' => 'index', 'filter_id' => ConstDealStatus::Open, 'company' => $company_slug), array('title' => __l('Open')));?></li>
                <?php $all = $dealStatusesCount[ConstDealStatus::Open]; ?>
        		<?php foreach($dealStatuses as $id => $dealStatus): ?>
                	<?php if($id != ConstDealStatus::Open): ?>
                        <li><?php echo $html->link($dealStatus.' ('.$dealStatusesCount[$id].')', array('controller' => 'deals', 'action' => 'index', 'filter_id' => $id, 'company' => $company_slug), array('title' => $dealStatus));?></li>
                        <?php $all += $dealStatusesCount[$id]; ?>
                     <?php endif; ?>
                <?php endforeach; ?>
                <li><?php echo $html->link(sprintf('All (%s)',$all),array('controller'=> 'deals', 'action'=>'index', 'type' => 'all', 'company' => $company_slug),array('title' => __l('All'))); ?></li>
            </ul>
    </div>
<?php else: ?>
     <?php if(!empty($this->params['named']['filter_id']) && (!empty($dealStatusesCount[$this->params['named']['filter_id']]))){
        $id = $this->params['named']['filter_id'];
     }else if(!empty($this->params['named']['type']) && ($this->params['named']['type'] == 'all')){
        $id = $this->params['named']['type'];
     }
     ?>
	<div class="js-response js-responses js-search-responses">
	 <div class="info-details">
		<?php echo __l("Commission and Purchased amount is calculated only when the deal is closed. You can see the calculated amount in 'Paid to Company' tab."); ?>
	</div>
     <?php echo $form->create('Deal', array('url' => array('controller' => 'deals', 'action' => 'index','filter_id' => (!empty($this->params['named']['filter_id'])) ? $this->params['named']['filter_id'] : '', 'company' => $company_slug) ,'class' => 'normal js-ajax-form {"container" : "js-search-responses"}'));?>
	   <?php echo $form->input('q', array('label' => __l('Keyword'))); ?>
	   <?php echo $form->hidden('filter_id', array('value' => (!empty($this->params['named']['filter_id'])) ? $this->params['named']['filter_id'] : '')); ?>
	   <?php echo $form->hidden('type', array('value' => (!empty($this->params['named']['type'])) ? $this->params['named']['type'] :'')); ?>
	   <?php echo $form->hidden('company_slug', array('value' => $company_slug)); ?>
	   <div class="submit-block clearfix">
	   	<a class="blue_button" href="#" onclick="javascript:$('#DealAddForm').submit()"><span><?php echo __l('Search'); ?></span></a>
		<?php		
		echo $form->end();
		//echo $form->end(__l('Search')); ?>
		</div>
    <?php echo $this->element('paging_counter'); ?>
    <table class="list company-list" id="mytable">
        <tr>
	   <?php if(!empty($this->params['named']['filter_id']) && ( $this->params['named']['filter_id'] == ConstDealStatus::Upcoming || $this->params['named']['filter_id'] == ConstDealStatus::PendingApproval || $this->params['named']['filter_id'] == ConstDealStatus::Rejected || $this->params['named']['filter_id'] == ConstDealStatus::Canceled || $this->params['named']['filter_id'] == ConstDealStatus::Draft)){?>
            <th class="dl deal-name"><div class="js-pagination"><?php echo $paginator->sort(__l('Deal Name'),'Deal.name') ; ?></div></th>

            <th class="dr"><div class="js-pagination"><?php echo $paginator->sort(__l('Original Price'), 'Deal.original_price').' ('.Configure::read('site.currency').')'; ?></div></th>
            <th class="dr"><div class="js-pagination"><?php echo $paginator->sort(__l('Discounted Price'), 'Deal.discounted_price').' ('.Configure::read('site.currency').')'; ?></div></th>
    <?php }else{ ?>
            <th rowspan="2" class="deal-name"><div class="js-pagination"><?php echo $paginator->sort(__l('Deal Name'),'name') ; ?></div></th>
			<?php if(!empty($this->params['named']['type']) && ($this->params['named']['type'] == 'all')):?>
				<th rowspan="2"  class="dl deal-name"><div class="js-pagination"><?php echo $paginator->sort(__l('Status'),'DealStatus.name') ; ?></div></th>
			<?php endif;?>
            <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Original Price'),'Deal.original_price').' ('.Configure::read('site.currency').')'; ?></div></th>
            <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Discounted Price'),'Deal.discounted_price').' ('.Configure::read('site.currency').')'; ?></div></th>
             <!-- colspan="2" -->
            <th><?php echo __l('Quantity'); ?></th>
            <th colspan="2"><?php echo __l('Amount').' ('.Configure::read('site.currency').')';?></th>
            <?php if((!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] != ConstDealStatus::Expired)) || !empty($this->params['named']['type']) ){?>
                <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Commission'),'Deal.commission_percentage').' (%)'; ?></div></th>
                <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Bonus Amount'),'Deal.bonus_amount').' ('.Configure::read('site.currency').')'; ?></div></th>
                <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Commission Amount'),'total_commission_amount').' ('.Configure::read('site.currency').')'; ?></div></th>
            <?php } ?>
             <?php if(!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] == ConstDealStatus::Open  || $this->params['named']['filter_id'] == ConstDealStatus::Closed || $this->params['named']['filter_id'] == ConstDealStatus::PaidToCompany || $this->params['named']['filter_id'] == ConstDealStatus::Tipped)){?>
                  <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Quantity Sold'),'Deal.deal_user_count'); ?></div></th>
             <?php } ?>
        </tr>
        <tr>
            <th><?php echo __l('Target'); ?></th>
            <!-- <th><?php echo __l('Achieved'); ?></th> -->
            <th><?php echo __l('Target'); ?></th>
            <th><?php echo __l('Achieved'); ?></th>
        </tr>
    <?php } ?>
    <?php if(!empty($deals)): ?>
     <?php $i = 0; ?>
      <?php foreach($deals as $deal): ?>
      <?php 
      	$tdclass = ' class="specalt"';
      	$tdclasslib = ' specalt';
		if ($i++ % 2 == 0) {			
			$tdclass = ' class="spec"';
			$tdclasslib = ' spec';
		}
      ?>
	   <?php if(!empty($this->params['named']['filter_id']) && ( $this->params['named']['filter_id'] == ConstDealStatus::Upcoming || $this->params['named']['filter_id'] == ConstDealStatus::PendingApproval || $this->params['named']['filter_id'] == ConstDealStatus::Rejected || $this->params['named']['filter_id'] == ConstDealStatus::Canceled || $this->params['named']['filter_id'] == ConstDealStatus::Draft)){?>
        <tr <?php echo $tdclass;?>>

            <td class="dl deal-name<?php echo $tdclasslib;?>">
                <?php if(!empty($this->params['named']['filter_id']) && $this->params['named']['filter_id'] == ConstDealStatus::Draft):?>
                    <div class="actions-block">
                        <div class="actions<?php echo $tdclasslib;?> round-5-left">
                            <span><?php echo $html->link(__l('Edit'), array('controller' => 'deals', 'action'=>'edit', $deal['Deal']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span>
                            <span><?php echo $html->link(__l('Delete'), array('controller' => 'deals', 'action'=>'delete', $deal['Deal']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
                            <span><?php echo $html->link(__l('Save and send to admin approval'), array('controller' => 'deals', 'action'=>'update_status', $deal['Deal']['id']), array('class' => 'add js-delete', 'title' => __l('Save and send to admin approval')));?></span>
                        </div>
                    </div>
				<?php elseif(!empty($this->params['named']['filter_id']) && ( $this->params['named']['filter_id'] == ConstDealStatus::Upcoming || $this->params['named']['filter_id'] == ConstDealStatus::PendingApproval)):?>
                    <div class="actions-block">
                        <div class="actions<?php echo $tdclasslib;?> round-5-left">
							<span><?php echo $html->link(__l('Clone Deal'),array('controller'=>'deals', 'action'=>'add', 'clone_deal_id'=>$deal['Deal']['id']), array('class' => 'add', 'title' => __l('Clone Deal')));?></span>
                        </div>
                    </div>
                <?php endif; ?>
                <?php echo $html->showImage('Deal', $deal['Attachment'][0], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($deal['Deal']['name'], false)), 'title' => $html->cText($deal['Deal']['name'], false)));?>
                <?php echo $html->link($deal['Deal']['name'], array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('title'=>$deal['Deal']['name']));?>
				<?php if(!empty($deal['Deal']['coupon_start_date'])):
					if(date('Y-m-d H:i:s') < $deal['Deal']['coupon_start_date']):
					?>
						<span class="pending-coupons" title="<?php echo __l('Coupon code can be used from'.' '.$html->cDateTime($deal['Deal']['coupon_start_date'], false));?>"></span>
					<?php endif;?>
				<?php endif;?>
            </td>
            <td class="dr"><?php echo $html->cCurrency($deal['Deal']['original_price']); ?></td>
            <td class="dr"><?php echo $html->cCurrency($deal['Deal']['discounted_price']); ?></td>
        </tr>
        <?php } else {?>
        <tr <?php echo $tdclass;?>>
            <td class="dl deal-name<?php echo $tdclasslib;?>">
                <div class="actions-block">
                    <div class="actions<?php echo $tdclasslib;?> round-5-left cities-action-block">
					<?php if(in_array($deal['Deal']['deal_status_id'], array(ConstDealStatus::Tipped,ConstDealStatus::Closed,ConstDealStatus::PaidToCompany))):?>
						    <span><?php echo $html->link(__l('Coupons CSV'), array('controller' => 'deals', 'action' => 'coupons_export', 'deal_id' =>  $deal['Deal']['id'], 'city' => $city_slug, 'filter_id' => $id, 'ext' => 'csv'), array('class' => 'export', 'title' => __l('Coupons CSV')));?></span>
                            <span> <?php echo $html->link(__l('Print of Coupons'),array('controller' => 'deals', 'action' => 'deals_print', 'filter_id' => $this->params['named']['filter_id'],'page_type' => 'print', 'deal_id' => $deal['Deal']['id'], 'company' => $company_slug),array('title' => __l('Print of Coupons'), 'target' => '_blank', 'class'=>'print-icon'));?></span>
						<?php endif; ?>
						<?php if(in_array($deal['Deal']['deal_status_id'], array(ConstDealStatus::Open, ConstDealStatus::Tipped,ConstDealStatus::Closed,ConstDealStatus::PaidToCompany))):?>
							<span>
							<?php echo $html->link(__l('Quantity Sold').'('.$html->cInt($deal['Deal']['deal_user_count'], false).')',array('controller'=>'deal_users', 'action'=>'index', 'deal_id'=>$deal['Deal']['id']),array('class' => 'js-thickbox'));?>							
							</span>
						<?php endif; ?>
						<span><?php echo $html->link(__l('Clone Deal'),array('controller'=>'deals', 'action'=>'add', 'clone_deal_id'=>$deal['Deal']['id']), array('class' => 'add', 'title' => __l('Clone Deal')));?></span>
                    </div>
                </div>
                <?php echo $html->showImage('Deal', $deal['Attachment'][0], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($deal['Deal']['name'], false)), 'title' => $html->cText($deal['Deal']['name'], false)));?>
                <?php echo $html->link($deal['Deal']['name'], array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('title'=>$deal['Deal']['name']));?>
				<?php if(!empty($deal['Deal']['coupon_start_date'])):
					if(date('Y-m-d H:i:s') < $deal['Deal']['coupon_start_date']):
					?>
						<span class="pending-coupons" title="<?php echo __l('Coupon code can be used from'.' '.$html->cDateTime($deal['Deal']['coupon_start_date'], false));?>"></span>
					<?php endif;?>
				<?php endif;?>
            </td>
			<?php if(!empty($this->params['named']['type']) && ($this->params['named']['type'] == 'all')):?>
				<td class="dl"><?php echo $html->cText($deal['DealStatus']['name'], false) ; ?></td>
			<?php endif;?>
            <td class="dr"><?php echo $html->cCurrency($deal['Deal']['original_price']); ?></td>
            <td class="dr"><?php echo $html->cCurrency($deal['Deal']['discounted_price']); ?></td>
            <td><?php echo $html->cInt($deal['Deal']['min_limit']); ?></td>
            <!-- <td><?php echo $html->cInt($deal['Deal']['deal_user_count']); ?></td> -->
            <td class="dr"><?php echo $html->cCurrency($deal['Deal']['discounted_price'] * $deal['Deal']['min_limit']); ?></td>
            <td class="dr"><?php echo $html->cCurrency($deal['Deal']['discounted_price'] * $deal['Deal']['deal_user_count']); ?></td>
            <?php if((!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] != ConstDealStatus::Expired)) || !empty($this->params['named']['type']) ){?>
                <td><?php echo $html->cFloat($deal['Deal']['commission_percentage']); ?></td>
                <td class="dr"><?php echo $html->cCurrency($deal['Deal']['bonus_amount']); ?></td>
                <td class="dr"><?php echo $html->cCurrency($deal['Deal']['total_commission_amount']); ?></td>
             <?php } ?>
             <?php if(!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] == ConstDealStatus::Open || $this->params['named']['filter_id'] == ConstDealStatus::Closed || $this->params['named']['filter_id'] == ConstDealStatus::PaidToCompany || $this->params['named']['filter_id'] == ConstDealStatus::Tipped)){?>
                 <td><?php echo $html->link($html->cInt($deal['Deal']['deal_user_count'], false),array('controller'=>'deal_users', 'action'=>'index', 'deal_id'=>$deal['Deal']['id'], 'deal_user_view' =>'coupon'),array('class' => 'js-thickbox'));?></td>
            <?php } ?>
        </tr>
       <?php } ?>
      <?php endforeach; ?>
    <?php else: ?>
        <tr><td class="notice" colspan="11"><?php echo __l('No deals available');?></td></tr>
    <?php endif; ?>
    </table>
	<?php
    if (!empty($deals)) {
        ?>
            <div class="js-pagination">
                <?php echo $this->element('paging_links'); ?>
            </div>
        <?php
    }
    ?>
    </div>
<?php endif; ?>