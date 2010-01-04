<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Request', 'doctrine');

/**
 * BaseRequest
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idrequest
 * @property string $content
 * @property integer $user
 * @property integer $priorite
 * @property integer $type
 * @property string $title
 * @property Priorite $Priorite
 * @property Type $Type
 * @property User $User
 * @property Doctrine_Collection $Response
 * 
 * @method integer             getIdrequest() Returns the current record's "idrequest" value
 * @method string              getContent()   Returns the current record's "content" value
 * @method integer             getUser()      Returns the current record's "user" value
 * @method integer             getPriorite()  Returns the current record's "priorite" value
 * @method integer             getType()      Returns the current record's "type" value
 * @method string              getTitle()     Returns the current record's "title" value
 * @method Priorite            getPriorite()  Returns the current record's "Priorite" value
 * @method Type                getType()      Returns the current record's "Type" value
 * @method User                getUser()      Returns the current record's "User" value
 * @method Doctrine_Collection getResponse()  Returns the current record's "Response" collection
 * @method Request             setIdrequest() Sets the current record's "idrequest" value
 * @method Request             setContent()   Sets the current record's "content" value
 * @method Request             setUser()      Sets the current record's "user" value
 * @method Request             setPriorite()  Sets the current record's "priorite" value
 * @method Request             setType()      Sets the current record's "type" value
 * @method Request             setTitle()     Sets the current record's "title" value
 * @method Request             setPriorite()  Sets the current record's "Priorite" value
 * @method Request             setType()      Sets the current record's "Type" value
 * @method Request             setUser()      Sets the current record's "User" value
 * @method Request             setResponse()  Sets the current record's "Response" collection
 * 
 * @package    amji
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseRequest extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('request');
        $this->hasColumn('idrequest', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('content', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('user', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('priorite', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('type', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('title', 'string', null, array(
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
        $this->hasOne('Priorite', array(
             'local' => 'priorite',
             'foreign' => 'idpriorite'));

        $this->hasOne('Type', array(
             'local' => 'type',
             'foreign' => 'idtype'));

        $this->hasOne('User', array(
             'local' => 'user',
             'foreign' => 'iduser'));

        $this->hasMany('Response', array(
             'local' => 'idrequest',
             'foreign' => 'request'));
    }
}