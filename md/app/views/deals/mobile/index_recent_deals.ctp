<?php /* SVN: $Id: index_recent_deals.ctp 4863 2010-05-17 11:51:34Z senthilkumar_017ac09 $ */?>
<div class="js-response">
<h2><?php echo __l('Recent Deals');?> </h2>
<?php echo $this->element('paging_counter'); ?>
    <ol class="list">
    <?php if(!empty($deals)): ?>
      <?php foreach($deals as $deal): ?>
        <li class="clearfix">
        	<div class="deal-l">
            	<p><?php echo $html->cInt($deal['Deal']['deal_user_count']); ?> <span><?php echo __l('Bought'); ?></span></p>
            </div>
        	<div class="deal-r">
              <p><?php echo $html->link($html->truncate($deal['Deal']['name'],80), array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('title'=>$deal['Deal']['name']));?></p>
              <dl class="price-list">
                <dt><?php echo __l('Price'); ?>-</dt>
                <dd><?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['discounted_price'])); ?></dd>
                <dt><?php echo __l('Value'); ?>-</dt>
                <dd><?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['original_price'])); ?></dd>
                <dt><?php echo __l('Save'); ?>-</dt>
                <dd><?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['discount_amount'])); ?></dd>
              </dl>
            </div>
        </li>
      <?php endforeach; ?>
    <?php else: ?>
        <li><p class="notice"><?php echo __l('No Deals available');?></p></li>
    <?php endif; ?>
    </ol>
</div>