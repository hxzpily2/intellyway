<?php
class Timezone extends AppModel
{
    var $name = 'Timezone';
    var $displayField = 'name';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $hasMany = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'timezone_id',
            'dependent' => true,
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
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'name' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
    }
}
?>