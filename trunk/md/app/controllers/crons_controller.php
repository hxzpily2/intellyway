<?php
class CronsController extends AppController
{
    var $name = 'Crons';
    function update_deal()
    {
        $this->autoRender = false;
        App::import('Component', 'cron');
        $this->Cron = &new CronComponent();
        $this->Cron->update_deal();
    }
}
?>