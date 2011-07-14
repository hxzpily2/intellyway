<?php
class Subscription extends AppModel
{
    var $name = 'Subscription';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    var $hasAndBelongsToMany = array(
        'DealCategory' => array(
            'className' => 'DealCategory',
            'joinTable' => 'deal_categories_subscriptions',
            'foreignKey' => 'subscription_id',
            'associationForeignKey' => 'deal_category_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'city_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'email' => array(
                'rule2' => array(
                    'rule' => 'email',
                    'allowEmpty' => false,
                    'message' => __l('Please enter valid email address')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                )
            )
        );
        $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete') ,
            ConstMoreAction::UnSubscripe => __l('Unsubscribe') ,
        );
    }
}
?>