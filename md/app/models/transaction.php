<?php
class Transaction extends AppModel
{
    var $name = 'Transaction';
    var $actsAs = array(
        'Polymorphic' => array(
            'classField' => 'class',
            'foreignKey' => 'foreign_id',
        )
    );
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
        'TransactionType' => array(
            'className' => 'TransactionType',
            'foreignKey' => 'transaction_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'PaymentGateway' => array(
            'className' => 'PaymentGateway',
            'foreignKey' => 'payment_gateway_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'SecondUser' => array(
            'className' => 'SecondUser',
            'foreignKey' => 'foreign_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'GiftUser' => array(
            'className' => 'GiftUser',
            'foreignKey' => 'foreign_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'DealUser' => array(
            'className' => 'DealUser',
            'foreignKey' => 'foreign_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'Deal' => array(
            'className' => 'Deal',
            'foreignKey' => 'foreign_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
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
            'amount' => array(
                'rule2' => array(
                    'rule' => array(
                        'comparison',
                        '>',
                        -1
                    ) ,
                    'allowEmpty' => false,
					'message' => __l('Should be greater than or equal to 0')
                ) ,
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
            )
        );
    }
    function log($data)
    {
        if (!empty($data)) {
            $this->create();
            $this->save($data);
            return $this->getLastInsertId();
        }
        return false;
    }
}
?>