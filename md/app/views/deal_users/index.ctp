<?php /* SVN: $Id: index.ctp 39927 2011-01-03 13:31:59Z aravindan_111act10 $ */ ?>
<?php if(empty($this->params['named']['type']) && empty($this->params['named']['deal_id']) && empty($this->data)): ?>
<?php if(!empty($pageTitle)): ?>
        <h2><?php echo $pageTitle;?></h2>
<?php endif; ?>
	<div style="height: 10px;">&nbsp;</div>
    <div class="js-tabs">
        <ul class="clearfix">
            <li><?php echo $html->link(sprintf(__l('Available (%s)'),$available),array('controller' => 'deal_users', 'action' => 'index', 'deal_id' => $deal_id, 'type' => 'available'), array('title' => 'Available-'.$deal_id)); ?></li>
            <li><?php echo $html->link(sprintf(__l('Used (%s)'),$used),array('controller' => 'deal_users', 'action' => 'index', 'deal_id' => $deal_id, 'type' => 'used'), array('title' => 'Used-'.$deal_id)); ?></li>
            <li><?php echo $html->link(sprintf(__l('Expired (%s)'),$expired),array('controller' => 'deal_users', 'action' => 'index', 'deal_id' => $deal_id, 'type' => 'expired'), array('title' => 'Expired-'.$deal_id)); ?></li>
            <li><?php echo $html->link(sprintf(__l('Pending (%s)'),$open),array('controller' => 'deal_users', 'action' => 'index', 'deal_id' => $deal_id, 'type' => 'open'), array('title' => 'Pending-'.$deal_id)); ?></li>
            <li><?php echo $html->link(sprintf(__l('Canceled (%s)'),$canceled),array('controller' => 'deal_users', 'action' => 'index', 'deal_id' => $deal_id, 'type' => 'canceled'), array('title' => 'Canceled-'.$deal_id)); ?></li>
            <li><?php echo $html->link(sprintf(__l('Refund (%s)'),$refund),array('controller' => 'deal_users', 'action' => 'index', 'deal_id' => $deal_id, 'type' => 'refund'), array('title' => 'Refund-'.$deal_id)); ?></li>
            <?php if(!empty($deal_id)) {?>
                <li><?php echo $html->link(sprintf(__l('Gifted Coupons (%s)'),$gifted_deals),array('controller' => 'deal_users', 'action' => 'index', 'deal_id' => $deal_id, 'type' => 'gifted_deals'), array('title' => 'Gifted Coupons-'.$deal_id)); ?></li>
            <?php }else{ ?>
                <li><?php echo $html->link(sprintf(__l('Gifted Coupons (%s)'),$gifted_deals),array('controller' => 'deal_users', 'action' => 'index', 'user_id' => $auth->user('id'), 'type' => 'gifted_deals'), array('title' => 'Gifted Coupons-'.$deal_id)); ?></li>			
                <li><?php echo $html->link(sprintf(__l('Received Gift Coupons (%s)'),$recieved_gift), array('controller' => 'deal_users', 'action' => 'index', 'user_id' => $auth->user('id'), 'type' => 'recieved_gift_deals'), array('title' => 'Received Gift Coupons-'.$deal_id)); ?></li>			
			<?php }?>
            <li><?php echo $html->link(sprintf(__l('All (%s)'),$all_deals),array('controller'=> 'deal_users','deal_id'=>$deal_id, 'action'=>'index','type' => 'all'),array('title' => 'All-'.$deal_id)); ?></li>
            <li><?php echo $html->image('sousmenu.png',array('style'=>'display:inline;')); ?></li>
        </ul>
    </div>
<?php else: ?>
	<div class="dealUsers index js-response js-responses">
		<?php if(($auth->user('user_type_id') == ConstUserTypes::Company) && (!empty($this->params['named']['deal_id']) && (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'available' || $this->params['named']['type'] == 'used') ||  (!empty($show_coupon_code) && $this->params['named']['deal_user_view'] == 'coupon'))){ ?>
			<?php echo $form->create('DealUser', array('type' => 'post', 'class' => 'normal search-form clearfix js-ajax-form', 'action'=>'index')); ?>
				<div>
					<?php 
						echo $form->input('coupon_code', array('label' => __l('Coupon code')));
						echo $form->input('deal_id', array('type' => 'hidden', 'value' => $this->params['named']['deal_id']));
						echo $form->input('deal_user_view', array('type' => 'hidden', 'value' => $this->params['named']['deal_user_view']));
						if(!empty($this->data['DealUser']['type'])):
							echo $form->input('type', array('type' => 'hidden'));
						endif;
						echo $form->submit(__l('Search'));
					?>
				</div>
			<?php echo $form->end(); ?>
		<?php } ?>
		<?php
			echo $form->create('DealUser' , array('class' => 'normal js-ajax-form','action' => 'update'));
			echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url']));
			if (!empty($this->params['named']['deal_id'])):
				echo $form->input('deal_id', array('type' => 'hidden', 'value' => $this->params['named']['deal_id']));
			elseif (!empty($this->params['named']['type'])):
				echo $form->input('type', array('type' => 'hidden', 'value' => $this->params['named']['type']));
			endif;
		?>
        <?php echo $this->element('paging_counter');?>
		<?php if(empty($this->params['named']['type']) && empty($this->params['named']['deal_id'])): ?>
			<p><?php echo __l('Total Quantity Sold').': '.$html->cInt($deal_user_count);?> </p>
			<p><?php echo __l('Expires On').': '.$html->cDateTime($dealUser['Deal']['coupon_expiry_date']);?> </p>
		<?php endif; ?>
		<table class="list" id="mytable">			
			<tr>
				<?php
                if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'open' && ($auth->user('user_type_id') == ConstUserTypes::User || ($auth->user('user_type_id') == ConstUserTypes::Company && empty($this->params['named']['deal_id'])))) { ?>
                    <th scope="col" rowspan="2"><?php echo __l('Action'); ?></th>
                    <?php
                }
                if ((!empty($this->params['named']['type']) && $this->params['named']['type'] != 'gifted_deals') && $this->params['named']['type'] == 'available') { ?>
				  <th scope="col" rowspan="2" class="actions"><?php echo __l('Select');?></th>
				<?php } ?>
                <?php if (!empty($this->params['named']['type']) && ($this->params['named']['type'] == 'available' || $this->params['named']['type'] == 'used') || (!empty($show_coupon_code) && $this->params['named']['deal_user_view'] == 'coupon')) { ?>
					<th scope="col" rowspan="2" class="actions"><?php echo __l('Action');?></th>
				<?php } ?>
				<th scope="col" rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Purchased Date'), 'created');?></div></th>
				<?php if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'canceled') { ?>
					<th scope="col" rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Canceled Date'), 'modified');?></div></th>
				<?php } ?>
				<?php if(!empty($this->params['named']['type']) && $this->params['named']['type'] == 'recieved_gift_deals'): ?>
					<th scope="col" rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Gift From'),'gift_from');?></div></th>
				<?php endif;?>
                <?php if(!empty($this->params['named']['type']) && $this->params['named']['type'] == 'gifted_deals'): ?>
					<th scope="col" rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Gift To'),'gift_to');?></div></th>
				<?php endif;?>
                <?php if(($auth->user('user_type_id') == ConstUserTypes::Company) && !empty($this->params['named']['deal_id'])): ?>
					<th scope="col" rowspan="2" class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Username'), 'User.username');?></div></th>
                <?php endif; ?>
                <?php if(!empty($deal_id) || !empty($this->params['named']['deal_id'])): ?>
					<th scope="col" rowspan="2" class="dr"><div class="js-pagination"><?php echo $paginator->sort(__l('Amount'), 'discount_amount') . ' ('.Configure::read('site.currency').')';?></div></th>
				<?php else: ?>
					<th scope="col" rowspan="2" class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Deal'), 'deal_id');?></div></th>
				<?php endif; ?>
				<?php if (!empty($this->params['named']['type']) && ($this->params['named']['type'] == 'available' || $this->params['named']['type'] == 'used') ||  (!empty($show_coupon_code) && $this->params['named']['deal_user_view'] == 'coupon')): ?>
					<?php if(($auth->user('user_type_id') == ConstUserTypes::Company) ||  ($auth->user('user_type_id') == ConstUserTypes::Admin)):?>
						<th scope="col" class="dc" colspan='3'><div class="js-pagination"><?php echo __l('Coupon code');?></div></th>
					<?php elseif(($auth->user('user_type_id') == ConstUserTypes::User)):?>
						<th scope="col" class="dc" colspan='3'><div class="js-pagination"><?php echo __l('Coupon code');?></div></th>
					<?php else:?>
						<th scope="col" class="dc" rowspan="2" ><div class="js-pagination"><?php echo __l('Coupon code');?></div></th>
					<?php endif;?>
				<?php endif;?>
				<th scope="col" rowspan="2"><?php echo __l('Quantity');?></th>
            </tr>
			<tr>
			<?php if(($auth->user('user_type_id') == ConstUserTypes::Company) ||  ($auth->user('user_type_id') == ConstUserTypes::Admin) ||  ($auth->user('user_type_id') == ConstUserTypes::User)):?>
				<?php if (!empty($this->params['named']['type']) && ($this->params['named']['type'] == 'available' || $this->params['named']['type'] == 'used') ||  (!empty($show_coupon_code) && $this->params['named']['deal_user_view'] == 'coupon')): ?>
					<th><div class="js-pagination"><?php echo __l('Top Code');?></div></th>
					<th><div class="js-pagination"><?php echo __l('Bottom Code');?></div></th>
					<th class='dl'><div class="js-pagination"><?php echo __l('Action');?></div></th>
				<?php endif;?>
			<?php endif;?>
			</tr>				
			<?php
				if (!empty($dealUsers)):
					$i = 0;
					foreach ($dealUsers as $dealUser):
						$class = null;
						$tdclass = ' class="specalt"';
						if ($i++ % 2 == 0) {
							$class = ' class="altrow"';
							$tdclass = ' class="spec"';
						}
						if($dealUser['DealUser']['deal_user_coupon_count'] != 0):
							$status_class = 'js-checkbox-active';
						else:
							$status_class = 'js-checkbox-inactive';
						endif;
			?>
			<tr<?php echo $tdclass;?>>
                <?php
                if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'open' && ($auth->user('user_type_id') == ConstUserTypes::User || ($auth->user('user_type_id') == ConstUserTypes::Company && empty($this->params['named']['deal_id'])))) { ?>
                    <td<?php echo $tdclass;$tdclass='';?>>
                        <?php
							if (!empty($dealUser['DealUser']['is_gift']) && $dealUser['DealUser']['user_id'] != $auth->user('id')):
								echo __l('N/A');
                            elseif(!empty($dealUser['DealUser']['is_canceled'])) :
                                echo __l('Canceled');
                            else :
                                echo $html->link(__l('Cancel'), array('controller' => 'deal_users', 'action' => 'cancel_deal', $dealUser['DealUser']['id']), array('title' => __l('Cancel'), 'class' => 'js-deal-cancel deal-cancel'));
                            endif;
                            ?>
                    </td>
                    <?php
                }
                ?>
				<?php if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'available') { ?>
					<td<?php echo $tdclass;$tdclass='';?>>
						<?php echo $form->input('DealUser.'.$dealUser['DealUser']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$dealUser['DealUser']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?>
					</td>
				<?php } ?>
				<?php if (!empty($this->params['named']['type']) && ($this->params['named']['type'] == 'available' || $this->params['named']['type'] == 'used') || (!empty($show_coupon_code) && $this->params['named']['deal_user_view'] == 'coupon')) { ?>
					<td<?php echo $tdclass;$tdclass='';?>>
						<?php
							echo $html->link(__l('View Coupon'),array('controller' => 'deal_users', 'action' => 'view', 'filter_id' => $this->params['named']['type'], $dealUser['DealUser']['id'],'admin' => false),array('title' => __l('View Coupon'), 'class'=>'js-thickbox','target' => '_blank', 'class'=>'view-icon js-thickbox'));
							echo $html->link(__l('Print'),array('controller' => 'deal_users', 'action' => 'view', 'filter_id' => $this->params['named']['type'], $dealUser['DealUser']['id'],'type' => 'print'),array('target'=>'_blank', 'title' => __l('Print'), 'class'=>'print-icon'));
						?>
					</td>
                <?php } ?>
				<td<?php echo $tdclass;$tdclass='';?>><?php echo $html->cDateTime($dealUser['DealUser']['created']);?></td>
				<?php if(!empty($this->params['named']['type']) && $this->params['named']['type'] == 'canceled'): ?>
					<td<?php echo $tdclass;$tdclass='';?>><?php echo $html->cDateTime($dealUser['DealUser']['modified']);?></td>
				<?php endif;?>
				<?php if(!empty($this->params['named']['type']) && ($this->params['named']['type'] == 'recieved_gift_deals')): ?>
					<td<?php echo $tdclass;$tdclass='';?>><?php echo $html->cText($dealUser['DealUser']['gift_from']);?></td>
				<?php endif;?>
				 <?php if(!empty($this->params['named']['type']) && ($this->params['named']['type'] == 'gifted_deals')): ?>
					<td<?php echo $tdclass;$tdclass='';?>><?php echo $html->cText($dealUser['DealUser']['gift_to']);?></td>
				<?php endif;?>
                <?php if(($auth->user('user_type_id') == ConstUserTypes::Company) && !empty($this->params['named']['deal_id'])): ?>
                    <td class="dl"><?php echo $html->cText($dealUser['User']['username']);?></td>
                <?php endif; ?>
                <?php if(!empty($deal_id) || !empty($this->params['named']['deal_id'])): ?>
                    <td class="dr"><?php echo $html->cCurrency($dealUser['DealUser']['discount_amount']);?></td>
                <?php else: ?>
                    <td class="deal-user-gift">
						<?php echo $html->link($html->showImage('Deal', $dealUser['Deal']['Attachment'][0], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($dealUser['Deal']['name'], false)), 'title' => $html->cText($dealUser['Deal']['name'], false))),array('controller' => 'deals', 'action' => 'view', $dealUser['Deal']['slug']), array('title' => $dealUser['Deal']['name'], 'escape' => false)); ?>
						<?php echo $html->link($html->cText($dealUser['Deal']['name']), array('controller' => 'deals', 'action' => 'view', $dealUser['Deal']['slug']), array('escape' => false, 'title' => $dealUser['Deal']['name']));?>
						<?php 
							if(!empty($dealUser['Deal']['coupon_start_date'])):
								if(date('Y-m-d H:i:s') < $dealUser['Deal']['coupon_start_date']):
								?>
									<span class="pending-coupons" title="<?php echo __l('Coupon code can be used from'.' '.$html->cDateTime($dealUser['Deal']['coupon_start_date'], false));?>"></span>
								<?php endif;?>
						<?php endif;?>
					</td>
				<?php endif; ?>
				<?php if (!empty($this->params['named']['type']) && ($this->params['named']['type'] == 'available' || $this->params['named']['type'] == 'used') ||  (!empty($show_coupon_code) && $this->params['named']['deal_user_view'] == 'coupon') ):?>
					<td<?php echo $tdclass;$tdclass='';?>>
						<?php if (empty($dealUser['DealUser']['is_gift']) || (!empty($dealUser['DealUser']['is_gift']) && $dealUser['DealUser']['gift_email'] == $auth->user('email')) || !empty($this->params['named']['deal_id'])):?>
							<ul class="coupon-code">
								<?php foreach ($dealUser['DealUserCoupon'] as $dealUserCoupon) { ?>
									<?php if ((!empty($coupon_find_id) && in_array($dealUserCoupon['id'], $coupon_find_id)) || ($this->params['named']['type'] == 'available' && empty($dealUserCoupon['is_used'])) || ($this->params['named']['type'] == 'used' && !empty($dealUserCoupon['is_used'])) || (!empty($show_coupon_code) && $this->params['named']['deal_user_view'] == 'coupon')) { ?>
										<li class="clearfix">
											<span class="coupon-code"><?php echo $dealUserCoupon['coupon_code']; ?></span>
										</li>
										<?php } ?>
									<?php }?>
								</ul>
							<?php else: ?>
								<?php echo '-';?>
							<?php endif;?>
						</td>
						<?php if(($auth->user('user_type_id') == ConstUserTypes::Company) ||  ($auth->user('user_type_id') == ConstUserTypes::Admin) ||  ($auth->user('user_type_id') == ConstUserTypes::User)):?>
						<td<?php echo $tdclass;$tdclass='';?>>
						<?php if (empty($dealUser['DealUser']['is_gift']) || (!empty($dealUser['DealUser']['is_gift']) && $dealUser['DealUser']['gift_email'] == $auth->user('email')) || !empty($this->params['named']['deal_id'])):?>
							<ul class="coupon-code">
								<?php foreach ($dealUser['DealUserCoupon'] as $dealUserCoupon) { ?>
									<?php if ((!empty($coupon_find_id) && in_array($dealUserCoupon['id'], $coupon_find_id)) || ($this->params['named']['type'] == 'available' && empty($dealUserCoupon['is_used'])) || ($this->params['named']['type'] == 'used' && !empty($dealUserCoupon['is_used'])) ||  (!empty($show_coupon_code) && $this->params['named']['deal_user_view'] == 'coupon')) { ?>
										<li class="clearfix">
											<span class="coupon-code"><?php echo $dealUserCoupon['unique_coupon_code']; ?></span>
										</li>
										<?php } ?>
									<?php }?>
								</ul>
							<?php else: ?>
								<?php echo '-';?>
							<?php endif;?>
						</td>
						<td class='dl'>
						<?php if (empty($dealUser['DealUser']['is_gift']) || (!empty($dealUser['DealUser']['is_gift']) && $dealUser['DealUser']['gift_email'] == $auth->user('email')) || !empty($this->params['named']['deal_id'])):?>
							<ul class="coupon-code">
								<?php foreach ($dealUser['DealUserCoupon'] as $dealUserCoupon) { ?>
									<?php if ((!empty($coupon_find_id) && in_array($dealUserCoupon['id'], $coupon_find_id)) || ($this->params['named']['type'] == 'available' && empty($dealUserCoupon['is_used'])) || ($this->params['named']['type'] == 'used' && !empty($dealUserCoupon['is_used'])) ||  (!empty($show_coupon_code) && $this->params['named']['deal_user_view'] == 'coupon')) { ?>
										<li class="clearfix">
											<?php
												if($dealUserCoupon['is_used'] == 1) {
													$class = 'used';
													$statusMessage = 'Change status to not used';
												} else {
													$class = 'not-used';
													$statusMessage = 'Change status to used';
												}
												if($dealUser['Deal']['company_id'] == $user['Company']['id']) {
													$confirmation_message =  "{'divClass':'js-company-confirmation'}";
												} else {
													$confirmation_message = "{'divClass':'js-user-confirmation'}";
												}
											?>
											<?php if(empty($this->params['named']['deal_id'])) { ?>
												<?php echo $html->link(__l('Print'),array('controller' => 'deal_users', 'action' => 'view',$dealUser['DealUser']['id'],'coupon_id' => $dealUserCoupon['id'],'type' => 'print'),array('target'=>'_blank', 'title' => __l('Print'), 'class'=>'print-icon'));?>
												<?php echo $html->link(__l('View Coupon'),array('controller' => 'deal_users', 'action' => 'view',$dealUser['DealUser']['id'],'coupon_id' => $dealUserCoupon['id'],'admin' => false),array('title' => __l('View Coupon'), 'class'=>'js-thickbox','target' => '_blank', 'class'=>'view-icon js-thickbox'));?>
											<?php } ?>
											<?php
												$user = $html->getCompany($auth->user('id'));
												if ((!empty($this->params['named']['type']) && $this->params['named']['type']=='available') || !empty($this->params['named']['deal_id'])) {
													if (!empty($dealUserCoupon['is_used']) && $dealUser['Deal']['company_id'] == $user['Company']['id']) {
												?>
														<span class="<?php echo 'status-'.$dealUserCoupon['is_used']?>">
														<?php
                                                            if(!empty($dealUserCoupon['is_used'])){
                                                                $use_now = __l('Used');
                                                                echo $use_now;
                                                                echo $html->link(__l('Undo'), array('controller' => 'deal_user_coupons', 'action' => 'update_status', $dealUser['DealUser']['id'], 'coupon_id' => $dealUserCoupon['id'],'is_used'), array('class' => $class.' js-update-status','title' => $statusMessage));
                                                            }else{
																if(!empty($dealUser['Deal']['coupon_start_date'])):
																	if(date('Y-m-d H:i:s') >= $dealUser['Deal']['coupon_start_date']):
																		$use_now = __l('Use Now');
																		echo $html->link($use_now, array('controller' => 'deal_user_coupons', 'action' => 'update_status', $dealUser['DealUser']['id'], 'coupon_id' => $dealUserCoupon['id'],'is_used'), array('class' => $class.' js-update-status','title' => $statusMessage));
																	endif;
																endif;
                                                            }
															
														?>
														</span>
													<?php } ?>
													<?php if ($class == 'not-used')  { ?>
														<span class="<?php echo 'status-'.$dealUserCoupon['is_used']?>">
														<?php
                                                            if(!empty($dealUserCoupon['is_used'])){
                                                                $use_now = __l('Used');
                                                                echo $use_now;
															    echo $html->link(__l('Undo'), array('controller' => 'deal_user_coupons', 'action' => 'update_status', $dealUser['DealUser']['id'], 'coupon_id' => $dealUserCoupon['id'], 'is_used'), array('class' => $class.' '.$confirmation_message.' js-update-status', 'title' => $statusMessage));
															}else {
																 if(!empty($dealUser['Deal']['coupon_start_date'])):
																	if(date('Y-m-d H:i:s') >= $dealUser['Deal']['coupon_start_date']):
																		$use_now = __l('Use Now');
																		echo $html->link($use_now, array('controller' => 'deal_user_coupons', 'action' => 'update_status', $dealUser['DealUser']['id'], 'coupon_id' => $dealUserCoupon['id'], 'is_used'), array('class' => $class.' '.$confirmation_message.' js-update-status', 'title' => $statusMessage));
																	endif;
																endif;
                                                            }
														?>
														</span>
													<?php } ?>
												<?php } ?>
											</li>
										<?php } ?>
									<?php }?>
								</ul>
							<?php else: ?>
								<?php echo '-';?>
							<?php endif;?>
						</td>
						<?php endif;?>
						<?php endif; ?>
					<td<?php echo $tdclass;$tdclass='';?>>
						<?php if(!empty($this->params['named']['type']) && $this->params['named']['type']=='available'):?>
							<?php echo $dealUser['DealUser']['quantity'] - $dealUser['DealUser']['deal_user_coupon_count'];?>
						<?php elseif(!empty($this->params['named']['type']) && $this->params['named']['type']=='used'):?>
							<?php echo $dealUser['DealUser']['deal_user_coupon_count'];?>
						<?php else:?>
							<?php echo $dealUser['DealUser']['quantity'];?>
						<?php endif;?>
					</td>
				</tr>
			<?php
			endforeach;
		else:
	?>
			<tr>
				<td colspan="14" class="notice"><?php echo sprintf(__l('No coupons available'));?></td>
			</tr>
	<?php
		endif;
	?>
	</table>
        <?php if (!empty($dealUsers) && !empty($this->params['named']['type']) && $this->params['named']['type'] == 'available'):?>
            <?php if(!empty($dealUser['Deal']['deal_status_id']) && ($dealUser['Deal']['deal_status_id'] != ConstDealStatus::PendingApproval || $dealUser['Deal']['deal_status_id'] != ConstDealStatus::Expired) && ((!empty($this->params['named']['type']) && ($this->params['named']['type']!='gifted_deals')))){?>
				<div class="admin-select-block">
					<div>
						<?php echo __l('Select:'); ?>
						<?php echo $html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
						<?php echo $html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
					</div>
				<div class="admin-checkbox-button"><?php echo $form->input('more_action_id', array('options' => $moreActions, 'type' => 'select', 'class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
				</div>
            <?php } ?>    
            <div class="hide">
                <?php echo $form->submit('Submit'); ?>
            </div>
		<?php endif;?>
		<?php if (!empty($dealUsers)):?>
			<div class="js-pagination">
				<?php echo $this->element('paging_links'); ?>
			</div>    
		<?php endif;?>
        <?php echo $form->end();?>
    </div>
<?php endif; ?>