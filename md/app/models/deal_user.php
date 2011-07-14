<?php
class DealUser extends AppModel
{
    var $name = 'DealUser';
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
        'Deal' => array(
            'className' => 'Deal',
            'foreignKey' => 'deal_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
    );
    var $hasMany = array(
        'Transaction' => array(
            'className' => 'Transaction',
            'foreignKey' => 'foreign_id',
            'dependent' => true,
            'conditions' => array(
                'Transaction.class' => 'DealUser'
            ) ,
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'DealUserCoupon' => array(
            'className' => 'DealUserCoupon',
            'foreignKey' => 'deal_user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    var $hasOne = array(
        'PaypalDocaptureLog' => array(
            'className' => 'PaypalDocaptureLog',
            'foreignKey' => 'deal_user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'PaypalTransactionLog' => array(
            'className' => 'PaypalTransactionLog',
            'foreignKey' => 'deal_user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'AuthorizenetDocaptureLog' => array(
            'className' => 'AuthorizenetDocaptureLog',
            'foreignKey' => 'deal_user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'user_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'deal_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'quantity' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
        $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete')
        );
    }
}
?>