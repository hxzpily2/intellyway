<?php
	if(!empty($city_name)):
		echo $this->requestAction(array('controller' => 'cities', 'action' => 'index'), array('named' => array('admin' => false, 'city' => $city_name), 'return'));
	else:
		echo $this->requestAction(array('controller' => 'cities', 'action' => 'index'), array('named' => array('admin' => false), 'return'));
	endif;
?>