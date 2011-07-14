<?php
class PrivacyType extends AppModel
{
    var $name = 'PrivacyType';
    var $displayField = 'name';
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
    }
}
?>