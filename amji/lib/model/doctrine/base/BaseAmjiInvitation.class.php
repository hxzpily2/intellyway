<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('AmjiInvitation', 'doctrine');

/**
 * BaseAmjiInvitation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idamji_user
 * @property integer $idamji_invite
 * @property string $message
 * 
 * @method integer        getIdamjiUser()    Returns the current record's "idamji_user" value
 * @method integer        getIdamjiInvite()  Returns the current record's "idamji_invite" value
 * @method string         getMessage()       Returns the current record's "message" value
 * @method AmjiInvitation setIdamjiUser()    Sets the current record's "idamji_user" value
 * @method AmjiInvitation setIdamjiInvite()  Sets the current record's "idamji_invite" value
 * @method AmjiInvitation setMessage()       Sets the current record's "message" value
 * 
 * @package    amji
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseAmjiInvitation extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('amji_invitation');
        $this->hasColumn('idamji_user', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('idamji_invite', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('message', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}