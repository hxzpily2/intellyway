<?php /* SVN: $Id: index_recent_deals.ctp 44785 2011-02-19 10:54:51Z aravindan_111act10 $ */?>
<div class="js-response">
  <div class="recentread-side1">
    
        <h2><?php echo __l('Recent Deals');?> </h2>
        <?php echo $this->element('paging_counter'); ?>
     	<ol class="recent-list clearfix">
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
                        </ul>-->
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
			</ol>
        	<div class="clearfix">
			<?php
			if (!empty($deals)):
				echo $this->element('paging_links');
			endif;
			?>
		</div>
      
      </div>
      </div>