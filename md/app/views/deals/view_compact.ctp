<?php if(!empty($deal['Deal']['name'])): ?>
<div class="side1 discussion-side1-block">
 <div class="side1-tl">
    <div class="side1-tr">
      <div class="side1-tm"> </div>
    </div>
 </div>
 <div class="side1-cl">
    <div class="side1-cr">
        <div class="block1-inner">
        <div class="clearfix">
           <div class="topic-share-block round-5 clearfix">
        		<span class="topic-share-deal"><?php echo __l('Share This Deal: '); ?></span>
        		<ul class="share-list">
        			<?php
        				if(Configure::read('site.city_url') == 'prefix'):
        					$bityurl = $deal['Deal']['bitly_short_url_prefix'];
        				else:
        					$bityurl = $deal['Deal']['bitly_short_url_subdomain'];
        				endif;
        			?>
                    <li class="quick"><?php echo $html->link(__l('Quick! Email a friend!'), 'mailto:?body='.__l('Check out the great deal on ').Configure::read('site.name').' - '.Router::url('/', true).'deal/'.$deal['Deal']['slug'].'&amp;subject='.__l('I think you should get ').Configure::read('site.name').__l(': ').$deal['Deal']['discount_percentage'].__l('% off at ').$deal['Deal']['Company']['name'], array('target' => 'blank', 'title' => __l('Send a mail to friend about this deal'), 'class' => 'quick'));?></li>
        			<li class="twitter-share"><a href="http://twitter.com/share?url=<?php echo $bityurl;?>&amp;text=<?php echo urlencode_rfc3986($deal['Deal']['name']);?>&amp;lang=en" data-count="none" class="twitter-share-button"><?php echo __l('Tweet!');?></a></li>
        			<li class="share-list share-list1"><fb:like href="<?php echo Router::url('/', true).'deal/'.$deal['Deal']['slug'];?>" layout="button_count" font="tahoma"></fb:like></li>
        		</ul>
          </div>
      </div>
    <div class="block1 topic-discussion-block clearfix">
         <div class="topic-discussion1">
            <div class="topic-discussion-tag clearfix">
              <p class="topic-price">
              <?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['discounted_price']));?>
              </p>
    			<?php
    				if($html->isAllowed($auth->user('user_type_id')) && $deal['Deal']['deal_status_id'] != ConstDealStatus::Draft && $deal['Deal']['deal_status_id'] != ConstDealStatus::PendingApproval):
    					if($deal['Deal']['deal_status_id'] == ConstDealStatus::Open || $deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped):
    						 echo $html->link(__l('Buy Now'), array('controller'=>'deals','action'=>'buy',$deal['Deal']['id']), array('title' => __l('Buy Now'),'class' =>'button'));
    					else:
    					?>
    						<span class="no-available" title="<?php echo __l('No Longer Available');?>"><?php echo __l('No Longer Available');?></span>
    					<?php
    					endif;
    				endif;
                ?>
		
			<div class="return-deal"><?php echo $html->link('<<< '.__l('Return to The Deal'), array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']), array('title' => __l('Return to The Deal')));?></div>
            </div>
    		  <h2 class="topic-discussion-title">
        		<?php if($deal['Deal']['deal_status_id'] == ConstDealStatus::Open || $deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped):?>
        			<span class ="today-deal">
        				<?php if($this->params['action'] =='index'):?>
        					<?php echo __l("Today's Deal").': ';?>
        				<?php endif; ?>
        			</span>
        		<?php endif; ?>
        		<?php
        			echo $html->link($deal['Deal']['name'], array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('title' =>sprintf(__l('%s'),$deal['Deal']['name'])));
        		?>
    		</h2>
		 </div>
	</div>
	<div id="fb-root"></div>
	<script type="text/javascript">
	  window.fbAsyncInit = function() {
		FB.init({appId: '<?php echo Configure::read('facebook.app_id');?>', status: true, cookie: true,
				 xfbml: true});
	  };
	  (function() {
		var e = document.createElement('script'); e.async = true;
		e.src = document.location.protocol +
		  '//connect.facebook.net/en_US/all.js';
		document.getElementById('fb-root').appendChild(e);
	  }());
	</script>
		</div>
        </div>
       	</div>
        <div class="side1-bl">
            <div class="side1-br">
              <div class="side1-bm"> </div>
            </div>
      </div>
</div>
<?php endif; ?>
