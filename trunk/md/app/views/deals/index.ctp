<?php /* SVN: $Id: index.ctp 32319 2010-11-04 10:17:50Z aravindan_111act10 $ */ ?>
<?php
	if(Configure::read('site.enable_three_step_subscription') && !empty($deals) &&  (isset($_COOKIE['CakeCookie']['is_subscribed']) || $auth->sessionValid())):
		$count = 1;
		foreach($deals as $deal):
			echo $this->element('../deals/view', array('deal' => $deal, 'count' => $count, 'get_current_city' => $get_current_city, 'cache' => array('time' => Configure::read('site.element_cache'))));
			$count++;
		endforeach;
	elseif(!Configure::read('site.enable_three_step_subscription') && !empty($deals)):  // When three step sub is disabled
		$count = 1;
		foreach($deals as $deal):
			echo $this->element('../deals/view', array('deal' => $deal, 'count' => $count, 'get_current_city' => $get_current_city, 'cache' => array('time' => Configure::read('site.element_cache'))));
			$count++;
		endforeach;
	else:
		echo $this->element('subscriptions-add', array('cache' => array('time' => Configure::read('site.element_cache'))));
	endif;
?>
