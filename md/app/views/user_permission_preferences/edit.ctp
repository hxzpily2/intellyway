<?php /* SVN: $Id: edit.ctp 40719 2011-01-10 09:27:33Z josephine_065at09 $ */ ?>
<div class="userPermissionPreferences form js-responses">
	<div class="js-permission-responses">
	<h2><?php echo sprintf(__l('Edit Privacy Settings - %s'), $this->data['User']['username']); ?></h2>
    <?php
		echo $form->create('UserPermissionPreference', array('class' => 'normal js-ajax-form {"container" : "js-permission-responses"}'));
		echo $form->input('User.id', array('type' => 'hidden'));
		echo $form->input('User.username', array('type' => 'hidden'));
	?>
	<?php			
			foreach($userPreferenceCategories as $userPreferenceCategory):
	?>
	<fieldset class="form-block round-5">
			<legend class="round-5"><?php echo $html->cText($userPreferenceCategory['UserPreferenceCategory']['name']); ?></legend>				
				<h3><?php echo $html->cText($userPreferenceCategory['UserPreferenceCategory']['description']); ?></h3>
	<?php
				
				foreach ($this->data['UserPermissionPreference'] as $key => $val):
                    $isSiteSetting = Configure::read($key);
                    if(!$isSiteSetting) :
                        continue;
                    endif;
					$tmp_privacy = $privacyTypes;
                    if('Profile-is_allow_comment_add' == $key) :
                        unset($tmp_privacy[ConstPrivacySetting::EveryOne]);
                    endif;
					if('Profile-is_receive_email_for_new_comment' == $key) :
                        unset($tmp_privacy[ConstPrivacySetting::EveryOne]);
                    endif;
					$field = explode('-', $key);
					if ($field[0] == $userPreferenceCategory['UserPreferenceCategory']['name']):
						if ($field[1] != 'is_show_captcha'):
							echo $form->input($key, array('type' => 'select', 'label' => Inflector::humanize(str_replace('is_','',$field[1])) , 'options' => $tmp_privacy));
						else:
							echo $form->input($key, array('type' => 'select','label' => Inflector::humanize(str_replace('is_','',$field[1])), 'options' => array('1' => __l('Yes'), '0' => 'No')));
						endif;
					endif;
				endforeach;
	?>
    </fieldset>
    <?php
			endforeach;
			?>
	  <div class="submit-block clearfix">
                    <?php
                    	echo $form->submit(__l('Update'));
                    ?>
                    </div>
                <?php
                	echo $form->end();
                ?>
	
	</div>
</div>