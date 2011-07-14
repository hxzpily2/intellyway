<?php 
	if(!empty($this->params['isAjax'])):
		echo $this->element('flash_message');
	endif;
?>
<div class="js-responses">
<?php if(!empty($settings_category['SettingCategory']['description'])):?>
	<div class=" info-details"><?php echo $settings_category['SettingCategory']['description'];?> </div>
<?php endif;?>
<?php
	if(!empty($settings)):
		echo $form->create('Setting', array('action' => 'edit', 'class' => 'normal js-ajax-form'));
			echo $form->input('setting_category_id', array('label' => __l('Setting Category'),'type' => 'hidden'));
		// hack to delete the thumb folder in img directory
        if($settings[0]['SettingCategory']['name'] == 'Images'):
        	echo $form->input('delete_thumb_images', array('type' => 'hidden', 'value' => '1'));
        endif;
		if($settings[0]['SettingCategory']['name'] == 'Twitter'):
			 echo $html->link(__l('Update Twitter Credentials'), array('controller' => 'users', 'action' => 'login',  'type'=> 'twitter', 'admin'=>false), array('class' => 'twitter-link', 'title' => __l('Here you can update Twitter credentials like Access key and Accss Token. Click this link and Follow the steps. Please make sure that you have updated the Consumer Key and  Consumer secret before you click this link.')));
		endif;
		if($settings[0]['SettingCategory']['name'] == 'Facebook'):
			 echo $html->link(__l('Update Facebook Credentials'), $fb_login_url, array('class' => 'facebook-link', 'title' => __l('Here you can update Facebook credentials . Click this link and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.')));
		endif;
		$inputDisplay = 0;
    	foreach ($settings as $setting):
            $field_name = explode('.', $setting['Setting']['name']);
            if(isset($field_name[2]) && ($field_name[2] == 'is_not_allow_resize_beyond_original_size' || $field_name[2] == 'is_handle_aspect')){
                continue;
            }
            $options['type'] = $setting['Setting']['type'];
            $options['value'] = $setting['Setting']['value'];
            $options['div'] = array('id' => "setting-{$setting['Setting']['name']}");
            if($options['type'] == 'checkbox' && $options['value']):
                $options['checked'] = 'checked';
            endif;
            if($options['type'] == 'select'):
                $selectOptions = explode(',', $setting['Setting']['options']);
                $setting['Setting']['options'] = array();
                if(!empty($selectOptions)):
                    foreach($selectOptions as $key => $value):
                        if(!empty($value)):
                            $setting['Setting']['options'][trim($value)] = trim($value);
                        endif;
                    endforeach;
                endif;
                $options['options'] = $setting['Setting']['options'];
            endif;
            if($setting['Setting']['name'] == 'site.language'):
                $options['options'] = $html->getLanguage();				
            endif;
			if($setting['Setting']['name'] == 'site.timezone_offset'):
                $options['options'] = $timezoneOptions;				
            endif;
			 if($setting['Setting']['name'] == 'site.city'):
                $options['options'] = $cityOptions;
            endif;
			$options['label'] = $setting['Setting']['label'];
			if ($setting['SettingCategory']['name'] == 'Images' && $inputDisplay == 0):
				$options['class'] = 'image-settings';
				echo '<div class="outer-image-settings clearfix">';
			elseif($setting['SettingCategory']['name'] == 'Images'):
				$options['class'] = 'image-settings image-settings-height';
			endif;
            //barcode
            if($setting['Setting']['name'] == 'barcode.symbology'):
                $options['options'] = $barcodeSymbologies;
            endif;
            if ($setting['Setting']['name'] == 'user.referral_deal_buy_time' || $setting['Setting']['name'] == 'user.referral_cookie_expire_time'):
				$options['after'] = __l('hrs') . '<span class="info">' . $setting['Setting']['description'] . '</span>';
			endif;
			if (!empty($setting['Setting']['description']) && empty($options['after'])):
				$options['help'] = "{$setting['Setting']['description']}";
			endif;
			if($setting['Setting']['name'] == 'Site.logo'):
                 $options['after'] = '<div class="settings-site-logo">'.$html->showImage('SiteLogo', $attachment['SiteLogo'], array('full_url' => true,'dimension' => 'site_logo_thumb', 'alt' => sprintf(__l('[Image: %s]'), "SiteLogo"), 'title' =>  __l('SiteLogo'), 'type' => 'png', 'class' => 'siteLogo')).'</div>';
            endif;
            //default account
			echo $form->input("Setting.{$setting['Setting']['id']}.name", $options);
			if($setting['SettingCategory']['name'] == 'Images' && !$inputDisplay++):
                echo '<div class="input image-separator">X</div>';
			endif;
			if($setting['SettingCategory']['name'] == 'Images' && $inputDisplay == 2):
				echo '</div>';
			endif;
   
			$inputDisplay = ($inputDisplay == 2) ? 0 : $inputDisplay;
            unset($options);
		endforeach;
		if(!empty($beyondOriginals)){
            echo $form->input('not_allow_beyond_original', array('label' => __l('Not Allow Beyond Original'),'type' => 'select', 'multiple' => 'multiple', 'options' => $beyondOriginals));
        }
        if(!empty($aspects)){
            echo $form->input('allow_handle_aspect', array('label' => __l('Allow Handle Aspect'),'type' => 'select', 'multiple' => 'multiple', 'options' => $aspects));
        } ?>
    <div class="submit-block clearfix">
    <?php	echo $form->end('Update'); ?>
    </div>
    <?php
	else:
?>
		<div class="notice"><?php echo __l('No settings available'); ?></div>
<?php
	endif;
?>
</div>