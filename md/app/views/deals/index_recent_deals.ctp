<?php /* SVN: $Id: index_recent_deals.ctp 44785 2011-02-19 10:54:51Z aravindan_111act10 $ */?>

  
    
        <h2><?php echo __l('Recent Deals');?> </h2>
        <br/><br/>
        <!--<?php echo $this->element('paging_counter'); ?>-->     	
     	<ul id="recent_deal_ul">
     	<?php if(!empty($deals)): ?>
		  <?php foreach($deals as $deal): ?>
		 <li>
		  		<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr height="20">
						<td id="md_deal_price_top_left" width="17">&nbsp;</td>
						<td id="md_deal_price_top" >&nbsp;</td>
						<td id="md_deal_price_top_right" width="18">&nbsp;</td>
					</tr>
					<tr height="100">
						<td id="md_deal_price_left" width="17">&nbsp;</td>
						<td id="md_deal_price_texture" >							
							<div class="recdeal1-img">	
								<div class="recentoldprice">
									<span>
										<?php $old_price = $deal['Deal']['discounted_price'] + $deal['Deal']['savings']; ?>
      									<?php echo $html->siteCurrencyFormat($html->cCurrency($old_price));?>
      								</span>
								</div>
								<div class="recentnewprice">
									<span class="label"><?php echo __l('Economies'); ?></span><br/>
									<span class="price"><?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['savings']));?></span>
								</div>
								<div class="recentviewit">							
									<?php echo $html->link($html->tag('span', __l('View it'), array('class' => '')), array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('escape'=>false,'class'=>'blue_button')); ?>
								</div>
								<div class="recentbought">
									<span style="color: #ffe7eb;text-shadow: black 0.1em 0.1em 0.2em;text-decoration: none;">
										<?php echo $html->cInt($deal['Deal']['deal_user_count']);?>
										<?php echo __l('Bought');?>
									</span>
								</div>
								<div class="recent-deal-example">
									<div class="recent-deal-example1">
										<span class="sidebar_h4"><?php echo $html->link($deal['Deal']['name'], array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('title' =>sprintf(__l('%s'),$deal['Deal']['name'])));?></span>
									</div>									
								</div>					
								<?php  echo $html->link($html->showImage('Deal', $deal['Attachment'][0], array('dimension' => 'small_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($deal['Deal']['name'], false)), 'title' => $html->cText($deal['Deal']['name'], false),'class'=>'recentdeal')),array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('title'=>$deal['Deal']['name'],'escape' =>false));?>
							</div>												
						</td>
						<td id="md_deal_price_right" width="18">&nbsp;</td>
					</tr>
					<tr height="20">
						<td id="md_deal_price_bottom_left" width="17">&nbsp;</td>
						<td id="md_deal_price_bottom">&nbsp;</td>
						<td id="md_deal_price_bottom_right" width="18">&nbsp;</td>
					</tr>
				</table>
		  </li>		  
		  <?php endforeach;?>
		  <?php if(count($deals)%2!=0):?>
		  <li style="visibility: hidden;">
		  		<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr height="20">
						<td id="md_deal_price_top_left" width="17">&nbsp;</td>
						<td id="md_deal_price_top" >&nbsp;</td>
						<td id="md_deal_price_top_right" width="18">&nbsp;</td>
					</tr>
					<tr height="100">
						<td id="md_deal_price_left" width="17">&nbsp;</td>
						<td id="md_deal_price_texture" >							
							<div id="divdisp">&nbsp;</div>												
						</td>
						<td id="md_deal_price_right" width="18">&nbsp;</td>
					</tr>
					<tr height="20">
						<td id="md_deal_price_bottom_left" width="17">&nbsp;</td>
						<td id="md_deal_price_bottom">&nbsp;</td>
						<td id="md_deal_price_bottom_right" width="18">&nbsp;</td>
					</tr>
				</table>
		  </li>
		  <?php endif; ?>
		<?php endif;?>		
		</ul>  
		
		
		<!-- <ol class="recent-list clearfix">
		<?php if(!empty($deals)): ?>
		  <?php foreach($deals as $deal): ?>
            <li>              	
              <div class="deals-content clearfix">
                <div class="side1-tl">
                  <div class="side1-tr">
                    <div class="side1-tm"> </div>
                  </div>
                </div>
                <div class="side1-cl">
                  <div class="side1-cr">
                    <div class="block1-inner clearfix">
                      <div class="deal-img">
                         <?php  echo $html->link($html->showImage('Deal', $deal['Attachment'][0], array('dimension' => 'small_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($deal['Deal']['name'], false)), 'title' => $html->cText($deal['Deal']['name'], false))),array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('title'=>$deal['Deal']['name'],'escape' =>false));?>
                       </div>
                      <div class="deal-info">
                        <p class="deals-time"> <?php echo $html->cDate($deal['Deal']['end_date']); ?></p>
                        <h3><?php echo $html->link($html->truncate($deal['Deal']['name'],80), array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('title'=>$deal['Deal']['name']));?></h3>
                        <!--<ul class="info-list clearfix">
                          <li><a href="#" title="Groupdeal.com">Groupdeal.com</a></li>
                          <li><a href="#" title="Deal from Group Deal">Deal from Group Deal</a></li>
                        </ul>
                        <div class="recent-deal-description">
                        <?php echo $html->truncate($deal['Deal']['description'],230);?>
                        </div>
                      </div>
                      <div class="bought-content">
                        <div class="sold clearfix">
                           <p class="bought-count">
        					   <?php echo $html->cInt($deal['Deal']['deal_user_count']); ?>
                            </p>
                        </div>
                        <div class="bought-details">
                         	<dl class="price-count clearfix">
				            	<dt><?php echo __l('Price'); ?></dt>
                                <dd><?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['discounted_price'])); ?></dd>
					       </dl>
                          <div class="clearfix">
                            <dl class="price-sount-list">
                              	<dt><?php echo __l('Value'); ?></dt>
				            	<dd><?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['original_price'])); ?></dd>
                            </dl>
                            <dl class="price-sount-list">
                             	<dt><?php echo __l('Discount');?></dt>
    					        <dd><?php echo $html->cInt($deal['Deal']['discount_percentage']) . "%"; ?></dd>
                            </dl>
                            <dl class="price-sount-list">
                                 <dt><?php echo __l('Savings'); ?></dt>
    					         <dd><?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['discount_amount'])); ?></dd>
                            </dl>
                         </div>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
                <div class="side1-bl">
                  <div class="side1-br">
                    <div class="side1-bm"> </div>
                  </div>
                </div>
                
              </div>
          	</li>
			  <?php endforeach; ?>
			<?php else: ?>
				<li>
                   <div class="side1-tl">
                      <div class="side1-tr">
                        <div class="side1-tm"> </div>
                      </div>
                    </div>
                    <div class="side1-cl">
                    <div class="side1-cr">
                    <div class="block1-inner clearfix">
                    <p class="notice"><?php echo __l('No Deals available');?></p>
                     </div>
                    </div>
                  </div>
                    <div class="side1-bl">
                      <div class="side1-br">
                        <div class="side1-bm"> </div>
                      </div>
                    </div>
                </li>
			<?php endif; ?>
			</ol> -->
			        	     	
      
      
      <br/><br/>
      <div class="paging" style="display: block;"><span style="visibility: hidden;">&nbsp;</span></div>
      <div>      	
		<?php
		if (!empty($deals)):
			echo $this->element('paging_links');
		endif;
		?>
	</div>