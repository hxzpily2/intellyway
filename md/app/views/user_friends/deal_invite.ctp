<div class="invite_friends">
<h2><?php echo __l('Invite your friends for the deal').' - '.$deal['Deal']['name'];?></h2>
<?php if($deal['Deal']['deal_status_id'] == ConstDealStatus::Open || $deal['Deal']['user_id'] == $auth->user('id')):?>
<div class="info-details">
	<p><?php echo __l('Deal will be tipped when it reaches the required number of buyers.');?></p>
	<p><?php echo __l('Invite more users to buy this deal, So that you can increase your chance to win this deal.');?></p>
</div>
<?php endif;?>
	<div class="js-tabs">
		<ul class="clearfix">			
			<li><?php echo $html->link(__l('Import Friends'), array(
				'controller' => 'user_friends',
				'action' => 'import',
				'type' => 'deal',
				'deal' => $deal_slug
			)); ?></li>
			<li><?php echo $html->link(__l('Share Via Social Media'), '#js-share-via-facebook'); ?></li>
			<li><?php echo $html->link(__l('Invite to Your Friends'), array(
				'controller' => 'user_friends',
				'action' => 'myfriends',
				'type' => 'deal',
				'deal' => $deal_slug
			)); ?></li>
		</ul>
	<div id="js-share-via-facebook">
		<div class="clearfix">
			<ul class="share-list">
                <?php 
					if(Configure::read('site.city_url') == 'prefix'):
						$bityurl =$deal['Deal']['bitly_short_url_prefix'];
					else:
						$bityurl =$deal['Deal']['bitly_short_url_subdomain'];
					endif;
				?>
              
					<li><a href="http://twitter.com/share?url=<?php echo $bityurl;?>&amp;text=<?php echo $deal['Deal']['name'];?>&amp;lang=en" data-count="none" class="twitter-share-button" target="blank"><?php echo __l('Tweet!');?></a></li>
					<li><?php echo $html->link(__l('Quick! Email a friend!'), 'mailto:?body='.__l('Check out the great deal on ').Configure::read('site.name').'-'.Router::url('/', true).'deal/'.$deal_slug.'&amp;subject='.__l('I think you should get ').Configure::read('site.name').__l(': ').$deal['Deal']['discount_percentage'].__l('% off at ').$deal['Company']['name'], array('target' => 'blank', 'title' => __l('Send a mail to friend about this deal'), 'class' => 'quick'));?></li>
					<li class="share-list"><fb:like href="<?php echo Router::url('/', true).'deal/'.$deal_slug;?>" layout="button_count" font="tahoma"></fb:like></li>
            </ul>
		</div>
	</div>

	</div>
	<div class="skip-block">
		<?php echo $html->link(__l('Skip'),array('controller' => 'deals', 'action' => 'view', $deal_slug), array('class' => 'face', 'title' => __l('Skip')));?></li>
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
