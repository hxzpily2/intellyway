<?php
class UserPaymentProfile extends AppModel
{
    var $name = 'UserPaymentProfile';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'firstName' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'lastName' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'creditCardNumber' => array(
                'rule2' => array(
                    'rule' => 'numeric',
                    'message' => __l('Should be numeric') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'expiration_month' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'expiration_year' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'cvv2Number' => array(
                'rule2' => array(
                    'rule' => 'numeric',
                    'message' => __l('Should be numeric') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'zip' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'address' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'city' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'state' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'country' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
        );
        $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete')
        );
    }
	function _checkExpiryMonthAndYear($month = null , $year = null){
		$error = 0;
		if($year <= date('Y')){
			if($month <= date('m')){
				$error = 1;
			}
		}
		return $error;
	}
}
?>