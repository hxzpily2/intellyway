 <?php
		$cities = $html->getCity();
		$selected_city = $session->read('city_filter_id');
		if(!empty($cities)) :
			echo $form->create('City', array('url' => array('action' => 'change_city'), 'class' => 'language-form'));
			echo $form->input('city_id', array('label' => __l('City'),'empty' => __l('All'), 'class' => 'js-autosubmit', 'options' => $cities,'value' => $selected_city));
			echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url']));
			?>
			<span class="help" title='<?php echo __l('Selecting the city will filter the following items: Admin stat - deals and Total Commission Amount Earned, Deals, Deal Coupons, Subscriptions, Topics, Topic Dicussions.');?>'>
				&nbsp;
			</span>
			<div class="hide">
				<?php echo $form->submit('Submit');  ?>
			</div>
			<?php
			echo $form->end();
		endif;
?>