<?php
	$html->css('reset', null, null, false);
	$html->css('jquery.uploader', null, null, false);
	$html->css('jquery.autocomplete', null, null, false);
	$html->css('jquery-ui-1.7.1.custom', null, null, false);
	$html->css('ui.timepickr', null, null, false);
	$html->css('colorbox', null, null, false);
	$html->css('style', null, null, false);
	$html->css('menu', null, null, false);
	$html->css('footer_md', null, null, false);
	$html->css('jquery.slider', null, null, false);
	$html->css('notification', null, null, false);	
	
	if (isset($javascript)):
		$javascript->codeBlock('var cfg = ' . $javascript->object($js_vars_for_layout) , array('inline' => false));
		$javascript->link('libs/jquery', false);
		$javascript->link('libs/jquery.form', false);
		$javascript->link('libs/jquery.blockUI', false);
		$javascript->link('libs/jquery.livequery', false);
		$javascript->link('libs/jquery.uploader', false);	
		$javascript->link('libs/AC_RunActiveContent', false);
		$javascript->link('libs/jquery.fuploader', false);
		$javascript->link('libs/jquery.metadata', false);
		$javascript->link('libs/jquery.autocomplete', false);
		$javascript->link('libs/jquery-ui-1.7.2.custom.min', false);
		$javascript->link('libs/jquery.countdown', false);
		$javascript->link('libs/jquery.timepickr', false);
		$javascript->link('libs/jquery.overlabel', false);
		$javascript->link('libs/jquery.colorbox', false);
		$javascript->link('libs/date.format', false);
		$javascript->link('libs/jquery.truncate-2.3', false);
		$javascript->link('libs/jquery.address-1.2.1', false);
		$javascript->link('libs/jquery.flash', false);
		$javascript->link('libs/jquery.showcase', false);
		$javascript->link('libs/jquery.slider.min', false);		
		$javascript->link('libs/notification', false);
		
		if (env('HTTPS')) {
			$javascript->link('https://platform.twitter.com/widgets.js', false);
			$javascript->link('https://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAsSJZ6ocpX8ewN2-oHW4UNhSHN7qAWu2FCiF5riM5dxUJ7impHxT5obfvMHgOFfLs8TtdSkGUM2MO4w', false);
			$javascript->link('https://www.google.com/recaptcha/api/js/recaptcha.js', false);
		} else {
			$javascript->link('http://platform.twitter.com/widgets.js', false);
			$javascript->link('http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAsSJZ6ocpX8ewN2-oHW4UNhSHN7qAWu2FCiF5riM5dxUJ7impHxT5obfvMHgOFfLs8TtdSkGUM2MO4w', false);
			$javascript->link('http://www.google.com/recaptcha/api/js/recaptcha.js', false);
		}		
		
    	$javascript->link('common', false);
    endif;
?>