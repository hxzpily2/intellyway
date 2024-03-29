<?php /* SVN: $Id: index.ctp 12700 2010-07-09 12:37:14Z siva_063at09 $ */ ?>
<div class="cities-info-block">
	<ol class="cities-list clearfix" start="<?php echo $paginator->counter(array(
		'format' => '%start%'
		));?>">
	<?php
		if (!empty($cities)):
			$i = 0;
			foreach ($cities as $city):
				$class = null;
				if ($i++ % 2 == 0):
					$class = ' class="altrow"';
				endif;
				if($city['City']['slug'] == $city_slug) :
					$select_class = 'active';
				else:
					$select_class = '';
				endif;
			?>
				<li class="<?php echo $select_class;?>">
					<?php
						if (Cache::read('site.city_url', 'long') == 'prefix'):
							echo $html->link($city['City']['name'], array('controller' => 'deals', 'action' => 'index', 'city' => $city['City']['slug']), array('class' => "$select_class", 'title' => $city['City']['name'], 'escape' => false));
						elseif (Cache::read('site.city_url', 'long') == 'subdomain'):
							$subdomain = substr(env('HTTP_HOST'), 0, strpos(env('HTTP_HOST'), '.'));			
							$sitedomain = substr(env('HTTP_HOST'), strpos(env('HTTP_HOST'), '.'));
							$url = env('HTTP_HOST');
							switch($subdomain):
								case 'www':	
									$url = "http://".$city['City']['slug']. $sitedomain;
									break;
								case 'm':
									$url = "http://m.".$city['City']['slug']. $sitedomain;
									break;
								case Configure::read('site.domain');
										$url = "http://".$city['City']['slug'].'.'. env('HTTP_HOST');
									break;
								default:
									$url = "http://".$city['City']['slug']. $sitedomain;
							endswitch;						
						?>
						<a href="<?php echo $url;?>" title="<?php echo $city['City']['name']; ?>" class="$select_class"><?php echo $city['City']['name']; ?></a>
					<?php endif;?>
					<?php if($city['City']['active_deal_count']):?>
							<span class="callout"><?php echo $city['City']['active_deal_count']; ?></span>
					<?php  endif;?>
				</li>
		<?php
		endforeach;
	endif;?>
</ol>
<p class="suggestion-link"><?php echo $html->link(__l('Don\'t see your city?'), array('controller' => 'city_suggestions', 'action' => 'add'), array('title' => __l('Suggest a City'), 'escape' => false)); ?></p>
</div>