<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CarEtat', 'doctrine');

/**
 * BaseCarEtat
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idetat
 * @property string $title
 * @property string $description
 * @property integer $active
 * @property Doctrine_Collection $CarAuto
 * 
 * @method integer             getIdetat()      Returns the current record's "idetat" value
 * @method string              getTitle()       Returns the current record's "title" value
 * @method string              getDescription() Returns the current record's "description" value
 * @method integer             getActive()      Returns the current record's "active" value
 * @method Doctrine_Collection getCarAuto()     Returns the current record's "CarAuto" collection
 * @method CarEtat             setIdetat()      Sets the current record's "idetat" value
 * @method CarEtat             setTitle()       Sets the current record's "title" value
 * @method CarEtat             setDescription() Sets the current record's "description" value
 * @method CarEtat             setActive()      Sets the current record's "active" value
 * @method CarEtat             setCarAuto()     Sets the current record's "CarAuto" collection
 * 
 * @package    car
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseCarEtat extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('car_etat');
        $this->hasColumn('idetat', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '10',
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
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('active', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '1',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('CarAuto', array(
             'local' => 'idetat',
             'foreign' => 'idetat'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}