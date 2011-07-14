<?php /* SVN: $Id: admin_index.ctp 44425 2011-02-16 10:11:59Z usha_111at09 $ */ ?>
	<?php 
		if(!empty($this->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<?php if(empty($this->params['isAjax']) && empty($this->params['named']['stat'])): ?>
	<div class="js-tabs">
		<?php 
			if(!empty($this->params['named']['company'])):
				$url= array(
					'controller' => 'deals',
					'action' => 'index',
					'company' => $this->params['named']['company'],
				);
			elseif(!empty($this->params['named']['city_slug'])):
				$url= array(
					'controller' => 'deals',
					'action' => 'index',
					'city_slug' => $this->params['named']['city_slug'],
				);
			else:
				$url= array(
					'controller' => 'deals',
					'action' => 'index',
				);			
			endif;
		?>
        <ul class="clearfix">
			<li>
				<?php $url['filter_id'] = ConstDealStatus::Open;?>
				<?php echo $html->link(sprintf(__l('Open (%s)'),$dealStatusesCount[ConstDealStatus::Open]), $url, array('title' => __l('Open')));?>
				
			</li>
			<?php $all = $dealStatusesCount[ConstDealStatus::Open]; ?>
			<?php foreach($dealStatuses as $id => $dealStatus): ?>
			<?php if($id != ConstDealStatus::Open): ?>
				<li>
					<?php $url['filter_id'] = $id;?>
					<?php echo $html->link(sprintf("%s",$dealStatus.' ('.$dealStatusesCount[$id].')'), $url, array('title' => $dealStatus));?>
				</li>
				<?php $all += $dealStatusesCount[$id]; ?>
			 <?php endif; ?>
			<?php endforeach; ?>
			<?php $url['type'] ='all';?>
			<?php unset($url['filter_id']);?>
			<li><?php echo $html->link(sprintf(__l('All (%s)'),$all),$url,array('title' => __l('All'))); ?></li>
		</ul>
    </div>
<?php else: ?>
	 <?php if(empty($this->data)): ?>
		 <?php if(!empty($this->params['named']['filter_id']) && (!empty($dealStatusesCount[$this->params['named']['filter_id']]))){
            $id = $this->params['named']['filter_id'];
         }else if(!empty($this->params['named']['type']) && ($this->params['named']['type'] == 'all')){
            $id = $this->params['named']['type'];
         }
         ?>    
        <div class="js-response js-responses">
		 <div class="info-details">
			<?php echo __l("Commission and Purchased amount is calculated only when the deal is closed. You can see the calculated amount in 'Paid to Company' tab."); ?>
		</div>
            <h2><?php echo $pageTitle; ?>
			<?php 
			if(!empty($this->params['named']['company'])) {
				echo  ' - ' . ucfirst($this->params['named']['company']);
			} elseif(!empty($this->params['named']['city_slug'])) {
				echo  ' - ' . ucfirst($this->params['named']['city_slug']);
			} else {
				echo '';
			}
			?>
            </h2>
              <?php echo $form->create('Deal' , array('type' => 'post', 'class' => 'normal search-form clearfix js-ajax-form {"container" : "js-search-responses"}','action' => 'index','url' => $this->params['named'])); ?>
                   <?php echo $form->input('q', array('label' => __l('Keyword'))); ?>
					<?php echo $form->input('filter_id', array('type' => 'hidden', 'value' => $this->params['named']['filter_id'])); ?>
                    <?php
                    echo $form->submit(__l('Search'));
                    echo $form->end();
            ?>
            <div class="clearfix add-block1">
                <?php echo $html->link(__l('Add'), array('controller' => 'deals', 'action' => 'add'), array('class' => 'add','title' => __l('Add'))); ?>
                <?php echo $html->link(__l('Manual Deal Status Update'), array('controller' => 'deals', 'action' => 'update_status'), array('class' => 'update-status', 'title' => __l('You can use this to update deals various status.This will be used in the scenario where cron is not working')));?>
            </div>
    <?php endif; ?>   
    		<div class="js-search-responses">   
				  <?php echo $form->create('Deal' , array('class' => 'normal','action' => 'update')); ?>
                  <?php echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url'])); ?>
                   <?php echo $this->element('paging_counter');?>
                   <div class="overflow-block">
                  <table class="list">
                    <tr>
                      <?php	if(!empty($moreActions)): ?>
                          <th rowspan="2"><?php echo __l('Select'); ?></th>
                      <?php endif; ?>
					  <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Added On'), 'Deal.created'); ?></div></th>
                      <th class="dl" rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Deal'),'Deal.name'); ?></div></th>
                      <th class="dl deal-name" rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('User'),'User.username'); ?></div></th>
                      <th class="dl" rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Company'),'Company.name'); ?></div></th>
                      <th class="dl" rowspan="2"><div class="js-pagination"><?php echo __l('City'); ?></div></th>
                      <th class="dl" rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Side Deal'),'Deal.is_side_deal'); ?></div></th>
                        <?php if(!empty($this->params['named']['type']) && ($this->params['named']['type'] == 'all')) { ?>
                            <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Status'), 'DealStatus.name'); ?></div></th>
                       <?php } ?>
                      <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Start Date'), 'Deal.start_date'); ?></div></th>
                      <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('End Date'), 'Deal.end_date'); ?></div></th>
                      <th colspan="4"><?php echo __l('Price').' ('.Configure::read('site.currency').')'; ?></th>
                      <th colspan="2"><?php echo __l('User Limit'); ?></th>
                      <th rowspan="2"><div class="js-pagination"><?php echo $paginator->sort(__l('Quantity Sold'),'Deal.deal_user_count'); ?></div></th>
                      <th class="dr" rowspan="2"><div class="js-pagination">
					  <?php echo $paginator->sort(sprintf(__l('Total Purchased Amount (%s)'),Configure::read('site.currency')),'Deal.total_purchased_amount'); ?></div></th>
                      <th colspan="3"><?php echo __l('Commission').' ('.Configure::read('site.currency').')'; ?></th>
                      <th class="dl" rowspan="2"><?php echo __l('Private Note'); ?></th>
                    </tr>
                    <tr>
                      <th class="dr"><div class="js-pagination"><?php echo $paginator->sort(__l('Original Price'), 'Deal.original_price'); ?></div></th>
                      <th class="dr"><div class="js-pagination"><?php echo $paginator->sort(__l('Discounted Price'),'Deal.discounted_price');?></div></th>
                      <th><div class="js-pagination"><?php echo $paginator->sort(__l('Discount Percentage'), 'Deal.discount_percentage').' (%)';?></div></th>
                      <th class="dr"><div class="js-pagination"><?php echo $paginator->sort(__l('Discount Amount'), 'Deal.discount_amount').' ('.Configure::read('site.currency').')';?></div></th>
                      <th><div class="js-pagination"><?php echo $paginator->sort(__l('Minimum'),'Deal.min_limit'); ?></div></th>
                      <th><div class="js-pagination"><?php echo $paginator->sort(__l('Maximum'),'Deal.max_limit'); ?></div></th>
                      <th class="dr"><div class="js-pagination"><?php echo $paginator->sort(__l('Bonus Amount'),'Deal.bonus_amount'); ?></div></th>
                      <th><div class="js-pagination"><?php echo $paginator->sort(__l('Commission Percentage'),'Deal.commission_percentage'); ?></div></th>
                      <th class="dr"><div class="js-pagination"><?php echo $paginator->sort(__l('Total Commission Amount'), 'Deal.total_commission_amount'); ?></div></th>
                    </tr>
                    <?php
                    
                        if (!empty($deals)):
                            $i = 0;
                            foreach ($deals as $deal):
                            $status_class = '';
                                 $class = null;
                                if ($i++ % 2 == 0):
                                    $class = ' class="altrow"';
                                endif;
                                if($deal['Deal']['deal_status_id'] == ConstDealStatus::Open):
                                    $status_class = ' js-checkbox-active';
                                endif;
                                if($deal['Deal']['deal_status_id'] == ConstDealStatus::PendingApproval):
                                    $status_class = ' js-checkbox-inactive';
                                endif;
                                ?>
                    <tr<?php echo $class;?>>
					  <?php	if(!empty($moreActions)): ?>
                          <td>
                            <div class="actions-block">
                                <div class="actions round-5-left">
                                  <?php if(!empty($this->params['named']['filter_id']) && (($this->params['named']['filter_id'] == ConstDealStatus::Tipped) || ($this->params['named']['filter_id'] == ConstDealStatus::Closed) || ($this->params['named']['filter_id'] == ConstDealStatus::PaidToCompany))):?>
                                       <?php echo $html->link(__l('Coupons CSV'), array('controller' => 'deals', 'action' => 'coupons_export',  'admin' => false,'deal_id:'.$deal['Deal']['id'],'ext' => 'csv'), array('class' => 'export', 'title' => __l('Coupons CSV')));?>
                                        <span> <?php echo $html->link(__l('Print'),array('controller' => 'deals', 'action' => 'deals_print', 'filter_id' => $this->params['named']['filter_id'],'page_type' => 'print', 'deal_id' => $deal['Deal']['id']),array('title' => __l('Print'), 'class'=>'print-icon'));?></span>
                                   <?php endif; ?>
                                  <?php if(!empty($deal['Deal']['deal_status_id']) && $deal['Deal']['deal_status_id'] != ConstDealStatus::PendingApproval && $deal['Deal']['deal_status_id'] != ConstDealStatus::Rejected && $deal['Deal']['deal_status_id'] != ConstDealStatus::Draft && $deal['Deal']['deal_status_id'] != ConstDealStatus::Upcoming) {?>
                                  <?php echo $html->link(sprintf(__l('Quantity Sold  (%s)'),$html->cInt($deal['Deal']['deal_user_count'], false)),array('controller'=>'deal_users', 'action'=>'index', 'deal_id'=>$deal['Deal']['id']), array('class' => 'edit js-edit coupon-sold', 'title' => __l('Quantity Sold')));?>
									<?php } ?>
                                  <?php echo $html->link(__l('Edit'), array('controller' => 'deals', 'action'=>'edit', $deal['Deal']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?>
                                  <?php echo $html->link(__l('Delete'), array('action'=>'delete', $deal['Deal']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?>
								  <?php echo $html->link(__l('Clone Deal'),array('controller'=>'deals', 'action'=>'add', 'clone_deal_id'=>$deal['Deal']['id']), array('class' => 'add', 'title' => __l('Clone Deal')));?>
								  <?php if(!empty($deal['Deal']['deal_status_id']) && $deal['Deal']['deal_status_id'] != ConstDealStatus::PendingApproval && $deal['Deal']['deal_status_id'] != ConstDealStatus::Rejected && $deal['Deal']['deal_status_id'] != ConstDealStatus::Draft): 
								   echo $html->link(__l('View Discussions'),array('controller'=>'topics', 'action'=>'index', 'deal_id'=>$deal['Deal']['id']), array('title' => __l('View Discussions'),'class' =>'view-icon')); 
								   endif; ?>
                                </div>
                            </div>
                              <?php echo $form->input('Deal.'.$deal['Deal']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$deal['Deal']['id'], 'label' => false, 'class' => 'js-checkbox-list '. $status_class. '' )); ?>
                       </td>
                      <?php endif; ?> 
                      <td>
                          <?php	if(empty($moreActions)): ?>
                              <div class="actions-block">
                                    <div class="actions round-5-left">
                                      <?php if(!empty($this->params['named']['filter_id']) && (($this->params['named']['filter_id'] == ConstDealStatus::Tipped) || ($this->params['named']['filter_id'] == ConstDealStatus::Closed) || ($this->params['named']['filter_id'] == ConstDealStatus::PaidToCompany))):?>
                                            <span><?php echo $html->link(__l('CSV'), array('controller' => 'deals', 'action' => 'coupons_export', 'admin' => false,'deal_id:'.$deal['Deal']['id'],'ext' => 'csv'), array('class' => 'export', 'title' => __l('CSV')));?></span>
                                            <span> <?php echo $html->link(__l('Print'),array('controller' => 'deals', 'action' => 'deals_print', 'filter_id' => $this->params['named']['filter_id'],'page_type' => 'print', 'deal_id' => $deal['Deal']['id']),array('title' => __l('Print'), 'target' => '_blank', 'class'=>'print-icon'));?></span>
                                       <?php endif; ?>
                                      <?php if(!empty($deal['Deal']['deal_status_id']) && $deal['Deal']['deal_status_id'] != ConstDealStatus::PendingApproval && $deal['Deal']['deal_status_id'] != ConstDealStatus::Rejected && $deal['Deal']['deal_status_id'] != ConstDealStatus::Draft && $deal['Deal']['deal_status_id'] != ConstDealStatus::Upcoming) {?>
                                       <?php echo $html->link(sprintf(__l('Quantity Sold  (%s)'),$html->cInt($deal['Deal']['deal_user_count'], false)),array('controller'=>'deal_users', 'action'=>'index', 'deal_id'=>$deal['Deal']['id']), array('class' => 'edit js-edit coupon-sold', 'title' => __l('Quantity Sold')));?>
                                        <?php } ?>
                                      <?php echo $html->link(__l('Edit'), array('controller' => 'deals', 'action'=>'edit', $deal['Deal']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?>
                                      <?php echo $html->link(__l('Delete'), array('action'=>'delete', $deal['Deal']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?>
									  <?php echo $html->link(__l('Clone Deal'),array('controller'=>'deals', 'action'=>'add', 'clone_deal_id'=>$deal['Deal']['id']), array('class' => 'add', 'title' => __l('Clone Deal')));?>
									  <?php if(!empty($deal['Deal']['deal_status_id']) && $deal['Deal']['deal_status_id'] != ConstDealStatus::PendingApproval && $deal['Deal']['deal_status_id'] != ConstDealStatus::Rejected && $deal['Deal']['deal_status_id'] != ConstDealStatus::Draft): 
									  echo $html->link(__l('View Discussions'),array('controller'=>'topics', 'action'=>'index', 'deal_id'=>$deal['Deal']['id']), array('title' => __l('View Discussions'),'class' =>'view-icon'));
									  endif; ?>
                                    </div>
                                </div>
                          <?php endif; ?>
                        <?php echo $html->cDateTimeHighlight($deal['Deal']['created']);?>
                     </td>                           
                      <td class="dl deal-name">
							  <?php echo $html->showImage('Deal', $deal['Attachment'][0], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($deal['Deal']['name'], false)), 'title' => $html->cText($deal['Deal']['name'], false)));?>                      
							<?php if (Cache::read('site.city_url', 'long') == 'prefix') { ?>
									<span><?php echo $html->link($html->cText($deal['Deal']['name']), array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug'], 'city' => $deal['City']['slug'], 'admin' => false), array('title'=>$html->cText($deal['Deal']['name'],false),'escape' => false));?></span>
                               <?php } elseif (Cache::read('site.city_url', 'long') == 'subdomain') {
                                    $subdomain = substr(env('HTTP_HOST'), 0, strpos(env('HTTP_HOST'), '.'));
                                    $sitedomain = substr(env('HTTP_HOST'), strpos(env('HTTP_HOST'), '.'));
                                    if (strlen($subdomain) > 0) {
                            ?>
                                        <a href="http://<?php echo $deal['City']['slug'] . $sitedomain.'deal/'.$deal['Deal']['slug']; ?>" title="<?php echo $deal['Deal']['name']; ?>"><?php echo $deal['Deal']['name']; ?></a>
                            <?php 
                                    } else {
                                        echo $html->link($html->cText($deal['Deal']['name']), array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug'], 'admin' => false), array('title'=>$html->cText($deal['Deal']['name'],false),'escape' => false));
                                    }
                                }
                            ?>
                      </td>
                      <td class="dl">
                      <?php echo $html->getUserAvatarLink($deal['User'], 'micro_thumb',false);?>
                      <?php echo $html->getUserLink($deal['User']);?></td>
                      <td class="dl">
						<?php echo $html->link($deal['Company']['name'], array('controller' => 'deals', 'action'=>'index', 'company' => $deal['Company']['slug']),array('title' => sprintf(__l('%s'),$deal['Company']['name'])));?>
					  </td>
                      <td class="dl">
					<?//php echo $html->link($deal['City']['name'], array('controller' => 'deals', 'action'=>'index', 'city_slug' => $deal['City']['slug']),array('title' => sprintf(__l('%s'),$deal['City']['name'])));?>
					<?php
						$cities_list =array();
						foreach($deal['City'] as $city_sub):								
							$cities_list[] =  $html->link($city_sub['name'], array('controller' => 'deals', 'action'=>'index', 'city_slug' => $city_sub['slug']),array('title' => sprintf(__l('%s'),$city_sub['name'])));
						endforeach;
						echo implode(', ', $cities_list);
					?>
					  </td>
                      <td class="dl"><?php echo $html->cBool($deal['Deal']['is_side_deal']);?></td>
					<?php if(!empty($this->params['named']['type']) && ($this->params['named']['type'] == 'all')) { ?>
                        <td><?php echo $html->cText($deal['DealStatus']['name']);?></td>
                      <?php } ?>
                      <td><?php echo $html->cDateTime($deal['Deal']['start_date']);?></td>
                      <td><?php echo (!is_null($deal['Deal']['end_date']))? $html->cDateTime($deal['Deal']['end_date']): ' - ';?></td>
                      <td class="dr"><?php echo $html->cCurrency($deal['Deal']['original_price']);?></td>
                      <td class="dr"><?php echo $html->cCurrency($deal['Deal']['discounted_price']);?></td>
                      <td><?php echo $html->cFloat($deal['Deal']['discount_percentage']);?></td>
                      <td class="dr"><?php echo $html->cCurrency($deal['Deal']['discount_amount']);?></td>
                      <td><?php echo $html->cInt($deal['Deal']['min_limit']);?></td>
                      <td><?php echo $deal['Deal']['max_limit'] ? $html->cInt($deal['Deal']['max_limit']) : __l('No Limit');?></td>
                      <td><?php echo $html->link($html->cInt($deal['Deal']['deal_user_count'], false),array('controller'=>'deal_users', 'action'=>'index', 'deal_id'=>$deal['Deal']['id']));?></td>
                      <td class="dr"><?php echo $html->cCurrency($deal['Deal']['total_purchased_amount']);?></td>
                      <td class="dr"><?php echo $html->cCurrency($deal['Deal']['bonus_amount']);?></td>
                      <td><?php echo $html->cFloat($deal['Deal']['commission_percentage']);?></td>
                      <td class="dr"><?php echo $html->cCurrency($deal['Deal']['total_commission_amount']);?></td>
                      <td><div class="js-truncate"><?php echo $html->cText($deal['Deal']['private_note']); ?></div></td>
                    </tr>
                    <?php
                            endforeach;
                        else:
                            ?>
                    <tr>
                      <td colspan="12" class="notice"><?php echo __l('No Deals available');?></td>
                    </tr>
                    <?php
                        endif;
                        ?>
                  </table>
                  </div>
                  <?php if (!empty($deals)):?>
                      <div class="admin-select-block">
                      <?php
                      if(!empty($this->params['named']['filter_id'])) { ?>
                        <div>
                        	<?php if(!empty($moreActions)): ?>
								<?php echo __l('Select:'); ?>
                                <?php echo $html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
                                <?php echo $html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
                            <?php endif; ?>
                        </div>
                       <?php } ?>
                        <div class="admin-checkbox-button"><?php 
                            if(!empty($moreActions)):
                                echo $form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --')));
                            endif;
                             ?></div>
                        <div class="hide"> <?php echo $form->submit(__l('Submit'));  ?> </div>
                      </div>
                      <div class="js-pagination"> <?php echo $this->element('paging_links'); ?> </div>
                  <?php endif; ?>
                  <?php echo $form->end(); ?>
             </div>
    </div>
<?php endif; ?>
