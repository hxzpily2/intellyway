<?php
class PaypalDocaptureLog extends AppModel
{
    var $name = 'PaypalDocaptureLog';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $belongsTo = array(
        'DealUser' => array(
            'className' => 'DealUser',
            'foreignKey' => 'deal_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => ''
        )
    );
}
?>