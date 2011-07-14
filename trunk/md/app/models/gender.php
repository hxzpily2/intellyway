<?php
class Gender extends AppModel
{
    var $name = 'Gender';
    var $displayField = 'name';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $hasMany = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'gender_id',
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
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
    }
}
?>