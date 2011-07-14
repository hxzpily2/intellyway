<?php
class UserPreferenceCategory extends AppModel
{
    var $name = 'UserPreferenceCategory';
    var $displayField = 'name';
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
    }
}
?>