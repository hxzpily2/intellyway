<?php
class FriendStatus extends AppModel
{
    var $name = 'FriendStatus';
    var $displayField = 'name';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $hasMany = array(
        'UserFriend' => array(
            'className' => 'UserFriend',
            'foreignKey' => 'friend_status_id',
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