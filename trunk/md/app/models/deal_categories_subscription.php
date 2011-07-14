<?php
class DealCategoriesSubscription extends AppModel
{
    var $name = 'DealCategoriesSubscription';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $belongsTo = array(
        'DealCategory' => array(
            'className' => 'DealCategory',
            'foreignKey' => 'deal_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'Subscription' => array(
            'className' => 'Subscription',
            'foreignKey' => 'subscription_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
    }
}
?>