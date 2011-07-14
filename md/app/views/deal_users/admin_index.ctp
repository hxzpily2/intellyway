<?php /* SVN: $Id: admin_index.ctp 40719 2011-01-10 09:27:33Z josephine_065at09 $ */ ?>
	<?php 
		if(!empty($this->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>

<?php if(empty($this->params['isAjax']) && empty($this->params['named']['deal_id'])): ?>
	<div class="js-tabs">
           <ul class="clearfix">
                <li><?php echo $html->link(sprintf(__l('Available (%s)'), $available), array('controller' => 'deal_users', 'action' => 'index', 'filter_id' => 'available'), array('title' => __l('Available')));?></li>
                <li><?php echo $html->link(sprintf(__l('Used (%s)'), $used), array('controller' => 'deal_users', 'action' => 'index', 'filter_id' => 'used'), array('title' => __l('Used'))); ?></li>
                <li><?php echo $html->link(sprintf(__l('Expired (%s)'), $expired), array('controller' => 'deal_users', 'action' => 'index', 'filter_id' => 'expired'), array('title' => __l('Expired'))); ?></li>
                <li><?php echo $html->link(sprintf(__l('Pending (%s)'),$open),array('controller' => 'deal_users', 'action' => 'index', 'filter_id' => 'open'), array('title' => __l('Pending'))); ?></li>
                <li><?php echo $html->link(sprintf(__l('Canceled (%s)'),$canceled),array('controller' => 'deal_users', 'action' => 'index', 'filter_id' => 'canceled'), array('title' => __l('Canceled'))); ?></li>
                <li><?php echo $html->link(sprintf(__l('Gifted Coupons (%s)'),$gifted_deals),array('controller' => 'deal_users', 'action' => 'index', 'filter_id' => 'gifted_deals'), array('title' => __l('Gifted Coupons'))); ?></li>
                <li><?php echo $html->link(sprintf(__l('Refunded Coupons (%s)'),$refunded),array('controller' => 'deal_users', 'action' => 'index', 'filter_id' => 'refunded'), array('title' => __l('Refunded Coupons'))); ?></li>
               <li><?php  echo $html->link(sprintf(__l('All (%s)'), $all),array('controller' => 'deal_users', 'action' => 'index', 'filter_id' => 'all'), array('title' => __l('All'))); ?></li>
               
            </ul>
     </div>
<?php else: ?>
    	<div class="dealUsers index js-response js-responses">
		 <div class="info-details">
			<?php echo __l("Commission and Purchased amount is calculated only when the deal is closed. You can see the calculated amount in 'Paid to Company' tab."); ?>
		</div>
        <h2><?php echo __l('Deal Coupons');?></h2>
        <?php echo $form->create('DealUser', array('type' => 'post', 'class' => 'normal search-form clearfix js-ajax-form {"container" : "js-responses"}', 'action'=>'index')); ?>
            <div>
                    <?php echo $form->autocomplete('deal_name', array('label' => __l('Deal'), 'acFieldKey' => 'Deal.id', 'acFields' => array('Deal.name'), 'acSearchFieldNames' => array('Deal.name'), 'maxlength' => '255'));?>
					<?php if (!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] == 'available' || $this->params['named']['filter_id'] == 'used')): ?>
						<?php echo $form->input('coupon_code', array('label' => __l('Coupon code')));?>
					<?php endif;?>
                    <?php if(!empty($this->data['DealUser']['filter_id'])): ?>
						<?php echo $form->input('filter_id', array('type' => 'hidden'));?>
                    <?php elseif(!empty($this->data['DealUser']['deal_id'])): ?>
						<?php echo $form->input('deal_id', array('type' => 'hidden'));?>
                    <?php endif; ?>
                    <?php echo $form->submit(__l('Search'),array('name' => 'data[DealUser][search]'));?>
        </div>
        <?php echo $form->end(); ?>
		<?php echo $form->create('DealUser' , array('class' => 'normal js-ajax-form','action' => 'update'));?>
        <?php echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url'].$param_string)); ?>
        <?php echo $this->element('paging_counter');?>
        <div class="overflow-block">
        <table class="list">
            <tr>
				<?php if(!empty($this->params['named']['filter_id'])  && ($this->params['named']['filter_id'] != 'expired')): ?>
					<th rowspan="2"><?php echo __l('Select'); ?></th>
				<?php endif;?>
                <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Purchased Date'),'DealUser.created');?></div></th>
				<?php if(!empty($this->params['named']['filter_id'])  && ($this->params['named']['filter_id'] == 'canceled')): ?>
	                <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Canceled Date'),'DealUser.modified');?></div></th>
				<?php endif;?>
                <th rowspan="2" class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('User'),'User.username');?></div></th>
                <th rowspan="2" class="dl deal-name"><div class="js-pagination"><?php echo $paginator->sort(__l('Deal'), 'Deal.name');?></div></th>
				<?php if ((!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] == 'available' || $this->params['named']['filter_id'] == 'used')) || (empty($this->params['named']['filter_id']) && !empty($is_show_coupon_code))): ?>
					<th class="dl" colspan="2"><div class="js-pagination"><?php echo __l('Coupon Code');?></div></th>
				<?php endif;?>
                <th rowspan="2" class="dr"><div class="js-pagination"><?php echo $paginator->sort(__l('Price'), 'DealUser.discount_amount').' ('.Configure::read('site.currency').')';?></div></th>
				<?php if(!empty($this->params['named']['filter_id']) && $this->params['named']['filter_id'] == 'gifted_deals'): ?>
                    <th rowspan="2" class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Gift Email'), 'DealUser.gift_email');?></div></th>
                    <th rowspan="2" class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Message'), 'DealUser.message');?></div></th>
                <?php endif; ?>				
                <th rowspan="2" class="dc"><div class="js-pagination"><?php echo $paginator->sort(__l('Quantity'), 'DealUser.quantity');?></div></th>               
            </tr>
			<tr>
				<?php if ((!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] == 'available' || $this->params['named']['filter_id'] == 'used')) || (empty($this->params['named']['filter_id']) && !empty($is_show_coupon_code))): ?>
					<th><div class="js-pagination"><?php echo __l('Top Code');?></div></th>
					<th><div class="js-pagination"><?php echo __l('Bottom Code');?></div></th>
				<?php endif;?>
			</tr>
	<?php
        if (!empty($dealUsers)):
        
        $i = 0;
        foreach ($dealUsers as $dealUser):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
			if($dealUser['DealUser']['deal_user_coupon_count'] == $dealUser['DealUser']['quantity']):
                $status_class = 'js-checkbox-active';
            else:
                $status_class = 'js-checkbox-inactive';
            endif;
        ?>
            <tr<?php echo $class;?>>
			<?php if(!empty($this->params['named']['filter_id'])  && ($this->params['named']['filter_id'] != 'expired')): ?>
                <td>
                    <div class="actions-block">
                        <div class="actions round-5-left">
                            <span><?php echo $html->link(__l('Delete'), array('action' => 'delete', $dealUser['DealUser']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
                            <?php if(!$dealUser['DealUser']['is_repaid'] && !$dealUser['DealUser']['is_canceled']): ?>
                                <span><?php echo $html->link(__l('Print'),array('controller' => 'deal_users', 'action' => 'view',$dealUser['DealUser']['id'],'type' => 'print', 'filter_id' => $this->params['named']['filter_id'], 'admin' => false),array('title' => __l('Print'), 'class'=>'print-icon','target' => '_blank'));?></span>
                                <span><?php echo $html->link(__l('View Coupon'),array('controller' => 'deal_users', 'action' => 'view',$dealUser['DealUser']['id'], 'filter_id' => $this->params['named']['filter_id'],'admin' => false),array('title' => __l('View Coupon'), 'class'=>'view-icon js-thickbox','target' => '_blank'));?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php echo $form->input('DealUser.'.$dealUser['DealUser']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$dealUser['DealUser']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?>
				</td>
				<?php endif;?>
                <td><?php echo $html->cDateTime($dealUser['DealUser']['created']);?></td>
				<?php if(!empty($this->params['named']['filter_id'])  && ($this->params['named']['filter_id'] == 'canceled')): ?>
					<td><?php echo $html->cDateTime($dealUser['DealUser']['modified']);?></td>
				<?php endif; ?>
                <td class="dl">
                <?php echo $html->getUserAvatarLink($dealUser['User'], 'micro_thumb',false);?>
                <?php echo $html->getUserLink($dealUser['User']);?></td>
                <td class="dl deal-name"><?php echo $html->showImage('Deal', $dealUser['Deal']['Attachment'][0], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($dealUser['Deal']['name'], false)), 'title' => $html->cText($dealUser['Deal']['name'], false)));?><span><?php echo $html->link($html->cText($dealUser['Deal']['name']), array('controller' => 'deals', 'action' => 'view', $dealUser['Deal']['slug'], 'admin' => false), array('title'=>$html->cText($dealUser['Deal']['name'],false),'escape' => false));?></span></td>
				<?php if ((!empty($this->params['named']['filter_id']) && ($this->params['named']['filter_id'] == 'available' || $this->params['named']['filter_id'] == 'used')) || (empty($this->params['named']['filter_id']) && !empty($is_show_coupon_code))): ?>
                <td class="dl">
					<ul>
					<?php foreach($dealUser['DealUserCoupon'] as $dealUserCoupon){?>
						<?php if((!empty($coupon_find_id) && in_array($dealUserCoupon['id'],$coupon_find_id)) || (empty($coupon_find_id) && $this->params['named']['filter_id'] == 'available' && $dealUserCoupon['is_used'] == '0') || (empty($coupon_find_id) && $this->params['named']['filter_id'] == 'used' && $dealUserCoupon['is_used'] == '1') || (empty($coupon_find_id) && $this->params['named']['filter_id'] != 'used' && $this->params['named']['filter_id'] != 'available' )){?>
							<?php 
								if(!empty($dealUserCoupon['is_used'])):
									$image = 'icon-used.png';
								else:
									$image = 'icon-not-used.png';
								endif;
							?>
							<li>
								<?php echo $html->cText($dealUserCoupon['coupon_code']).' ';?>
								<?php if(!empty($this->params['named']['filter_id'])  && ($this->params['named']['filter_id'] != 'used') && ($this->params['named']['filter_id'] != 'available')): ?>
									<?php echo $html->image($image);?>
								<?php endif;?>
							</li>
						<?php }?>
					<?php } ?>
					</ul>
				</td>
                <td class="dl">
					<ul>
					<?php foreach($dealUser['DealUserCoupon'] as $dealUserCoupon){?>
						<?php if((!empty($coupon_find_id) && in_array($dealUserCoupon['id'],$coupon_find_id)) || (empty($coupon_find_id) && $this->params['named']['filter_id'] == 'available' && $dealUserCoupon['is_used'] == '0') || (empty($coupon_find_id) && $this->params['named']['filter_id'] == 'used' && $dealUserCoupon['is_used'] == '1') || (empty($coupon_find_id) && $this->params['named']['filter_id'] != 'used' && $this->params['named']['filter_id'] != 'available' )){?>
							<li>
								<?php echo $html->cText($dealUserCoupon['unique_coupon_code']).' ';?>
							</li>
						<?php }?>
					<?php } ?>
					</ul>
				</td>
				<?php endif;?>
				<td class="dr"><?php echo $html->cFloat($dealUser['DealUser']['discount_amount']);?></td>
				<?php if(!empty($this->params['named']['filter_id']) && $this->params['named']['filter_id'] == 'gifted_deals'): ?>
                    <td><?php echo $html->cText($dealUser['DealUser']['gift_email']);?></td>
                    <td class="dl"><?php echo $html->cText($dealUser['DealUser']['message']);?></td>
                <?php endif; ?>			
				<td class="dc"><?php echo $html->cInt($dealUser['DealUser']['quantity']);?></td>                
            </tr>
        <?php
            endforeach;
        else:
        ?>
            <tr>
                <td colspan="14" class="notice"><?php echo __l('No coupons available');?></td>
            </tr>
        <?php
        endif;
        ?>
        </table>
        </div>
		<?php if (!empty($dealUsers)):?>
			<?php if(!empty($this->params['named']['filter_id'])  && ($this->params['named']['filter_id'] != 'expired')): ?>
            <div class="admin-select-block">
            <div>
                <?php echo __l('Select:'); ?>
                <?php echo $html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
                <?php echo $html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
                <?php if($this->params['named']['filter_id'] == 'all' || (!empty($this->params['named']['deal_id']))) { ?>
                    <?php echo $html->link(__l('Use Now'), '#', array('class' => 'js-admin-select-approved', 'title' => __l('Use Now'))); ?>
                    <?php echo $html->link(__l('Not Used'), '#', array('class' => 'js-admin-select-pending', 'title' => __l('Not Used'))); ?>
                <?php } ?>
            </div>
            <div class="admin-checkbox-button"><?php echo $form->input('more_action_id', array('options' => $moreActions, 'type'=>'select','class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
            </div>
			<?php endif; ?>
            <div class="js-pagination">
            <?php echo $this->element('paging_links'); ?>
            </div>    
        <?php  endif;  ?>
        <div class="hide">
            <?php echo $form->end('Submit'); ?>
        </div>
        </div>
<?php endif; ?>