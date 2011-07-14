<?php

/**
 *
 * @version $Id: cron.php 3 2010-04-07 06:03:46Z siva_063at09 $
 * @copyright 2009
 */
class CronShell extends Shell {
    function main()
    {
        // site settings are set in config
        App::import('Model', 'Setting');
        $setting_model_obj = new Setting();
        $settings = $setting_model_obj->getKeyValuePairs();
        Configure::write($settings);
		App::import('Component', 'Cron');
        $this->Cron = &new CronComponent();
        $option = !empty($this->args[0]) ? $this->args[0] : '';
        $this->log('Cron started without any issue.', LOG_DEBUG);
        switch ($option) {
            case 'update_deal':
                $this->Cron->update_deal();
                break;
            default: ;
        } // switch
    }
}

?>