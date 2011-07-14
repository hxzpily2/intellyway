<?php /* SVN: $Id: view.ctp 7480 2010-06-09 06:19:22Z senthilkumar_017ac09 $ */ ?>
    <h2><?php echo $html->link($deal['Deal']['name'], array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('title' =>sprintf(__l('%s'),$deal['Deal']['name'])));?></h2>
    <div class="clearfix">
      <div class="side1">
        <p class="refer"><?php echo $html->link(sprintf(__l('Refer Friends, Get').' %s',$html->siteCurrencyFormat($html->cCurrency(Configure::read('user.referral_amount')))), array('controller' => 'pages', 'action' => 'refer_a_friend'), array('title' => sprintf(__l('Refer Friends and Get %s%s'),$html->siteCurrencyFormat($html->cCurrency(Configure::read('user.referral_amount'))))));?></p>
        <?php if($this->params['action'] !='index'):?>
					<div class="gallery-block">
						<div id='js-mobile-gallery'>
								<?php foreach($deal['Attachment'] as $attachment){?>
									<a><?php echo $html->showImage('Deal', $attachment, array('dimension' => 'small_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($deal['Deal']['name'], false)), 'title' => $html->cText($deal['Deal']['name'], false)));?></a>
								<?php } ?>
						</div>
					</div>
				<?php else:?>
					<div>
						<div>
							<ul>
								<li><?php echo $html->showImage('Deal', $deal['Attachment'][0], array('dimension' => 'small_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($deal['Deal']['name'], false)), 'title' => $html->cText($deal['Deal']['name'], false)));?></li>
							</ul>
						</div>
					</div>
				<?php endif;?>
        <div class="clearfix">
          <div class="side1-l">
            <h3><?php echo __l('The Fine Print');?></h3>
			<p><?php echo __l('Expires '); ?></p>
            <p><?php echo $html->cDateTime($deal['Deal']['coupon_expiry_date']).$html->cHtml($deal['Deal']['coupon_condition']);?></p>
            <p><?php echo $html->link(__l('Read the Deal FAQ'), array('controller' => 'pages', 'action' => 'view','faq', 'admin' => false), array('target'=>'_blank', 'title' => __l('Read the deal FAQ')));?> <?php echo __l(' for the basics.'); ?></p>
          </div>
          <div class="side1-r">
            <h3><?php echo __l('Highlights');?></h3>
            <?php echo $html->cHtml($deal['Deal']['coupon_highlights']);?>
          </div>
        </div>
      </div>
      <div class="side2">
        <p class="cash"><?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['discounted_price'], false));?></p>
		<?php
            if($html->isAllowed($auth->user('user_type_id')) && $deal['Deal']['deal_status_id'] != ConstDealStatus::Draft && $deal['Deal']['deal_status_id'] != ConstDealStatus::PendingApproval):
                if($deal['Deal']['deal_status_id'] == ConstDealStatus::Open || $deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped):
                     echo $html->link(__l('Buy'), array('controller'=>'deals','action'=>'buy',$deal['Deal']['id']), array('title' => __l('Buy'),'class' =>'buy-but round-5'));
                else:
                ?>
                    <span class="no-available buy-but round-5" title="<?php echo __l('No Longer Available');?>"><?php echo __l('No Longer Available');?></span>
                <?php
                endif;
            endif;
        ?>
        <div class="clearfix deal-block">
              <dl class="deal-list">
                 <dt><?php echo __l('Value');?></dt>
                 <dd><?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['original_price']));?></dd>
              </dl>
              <dl class="deal-list">
                <dt><?php echo __l('Discount');?></dt>
                <dd><?php echo $html->cInt($deal['Deal']['discount_percentage']) . "%"; ?></dd>
              </dl>
              <dl class="deal-list">
                <dt><?php echo __l('You Save');?></dt>
                <dd><?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['savings'])); ?></dd>
              </dl>
         </div>
        <div class="l-area">
			<?php if($deal['Deal']['deal_status_id'] == ConstDealStatus::Open || $deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped): ?>
                <dl class="progress-list round-5">
                    <dt><?php echo __l('Time Left To Buy');?></dt>
                    <dd>
                        <div class="js-deal-end-countdown">&nbsp;</div>
                        <span class="js-time hide"><?php
			    echo $end_time = intval(strtotime($deal['Deal']['end_date'].' GMT') - time());
                        ?></span>
                    </dd>
                 </dl>
           <?php
                $per = (strtotime($deal['Deal']['end_date']) - strtotime($deal['Deal']['start_date']))  / 10;
                $next =  round((strtotime(date('Y-m-d H:i:s')) - strtotime($deal['Deal']['start_date'])) / $per);
                if($next <= 0){
                    $next = 1;
                }
                if($next >= 10){
                    $next = 10;
                }
            ?>
            <?php elseif($deal['Deal']['deal_status_id'] == ConstDealStatus::Closed || $deal['Deal']['deal_status_id'] == ConstDealStatus::Canceled || $deal['Deal']['deal_status_id'] == ConstDealStatus::Expired): ?>
                <dl class="progress-list">
                    <dt><?php echo __l('This deal ended at:');?></dt>
                    <dd><?php echo $html->cDateTime($deal['Deal']['end_date'])?></dd>
                 </dl>
            <?php endif; ?>
        </div>
       <!-- <dl class="">
          <dt>Time Left To Buy</dt>
          <dd>
            <div class="js-deal-end-countdown hasCountdown"><span class="countdown_row countdown_show4"><span class="countdown_section"><span class="countdown_amount">24</span>h </span><span class="countdown_section"><span class="countdown_amount">35</span>m </span><span class="countdown_section"><span class="countdown_amount">22</span>s </span></span></div> </dd>
        </dl>-->
      </div>
    </div>
    <h3><?php echo __l('Description');?></h3>
    <div>
		<?php echo $html->cHtml($deal['Deal']['description']);?>
    </div>
    <h3><?php echo __l('Reviews');?></h3>
    <div class="big-text"><?php echo $html->cHtml($deal['Deal']['review']);?></div>