<?php
App::import('Model', 'Attachment');
class SiteLogo extends Attachment
{
    var $name = 'SiteLogo';
    var $useTable = 'attachments';
    var $actsAs = array(
        'Inheritable' => array(
            'inheritanceField' => 'class',
            'fieldAlias' => 'SiteLogo'
        )
    );
}
?>