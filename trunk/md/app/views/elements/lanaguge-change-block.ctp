 <?php
		$languages = $html->getLanguage();
		if(Configure::read('user.is_allow_user_to_switch_language') && !empty($languages)) :
			echo $form->create('Language', array('url' => array('action' => 'change_language','admin' => false), 'class' => 'language-form'));
			echo $form->input('language_id', array('label' => __l('Language'), 'class' => 'js-autosubmit', 'options' => $languages, 'value' => Configure::read('lang_code')));
			echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url']));
			?>
			<div class="hide">
				<?php echo $form->submit('Submit');  ?>
			</div>
			<?php
			echo $form->end();
		endif;
?>