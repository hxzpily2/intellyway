<?php

/**
 * BaseaAccess
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $page_id
 * @property string $privilege
 * @property integer $user_id
 * @property sfGuardUser $User
 * @property aPage $Page
 * 
 * @method integer     getPageId()    Returns the current record's "page_id" value
 * @method string      getPrivilege() Returns the current record's "privilege" value
 * @method integer     getUserId()    Returns the current record's "user_id" value
 * @method sfGuardUser getUser()      Returns the current record's "User" value
 * @method aPage       getPage()      Returns the current record's "Page" value
 * @method aAccess     setPageId()    Sets the current record's "page_id" value
 * @method aAccess     setPrivilege() Sets the current record's "privilege" value
 * @method aAccess     setUserId()    Sets the current record's "user_id" value
 * @method aAccess     setUser()      Sets the current record's "User" value
 * @method aAccess     setPage()      Sets the current record's "Page" value
 * 
 * @package    car
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseaAccess extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('a_access');
        $this->hasColumn('page_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('privilege', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));


        $this->index('pageindex', array(
             'fields' => 
             array(
              0 => 'page_id',
             ),
             ));
        $this->option('symfony', array(
             'form' => false,
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));

        $this->hasOne('aPage as Page', array(
             'local' => 'page_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));
    }
}