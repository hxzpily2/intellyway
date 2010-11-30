<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CarCommentaire', 'doctrine');

/**
 * BaseCarCommentaire
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idcommentaire
 * @property integer $idauto
 * @property integer $idgroup
 * @property integer $iduser
 * @property integer $active
 * @property CarAuto $CarAuto
 * 
 * @method integer        getIdcommentaire() Returns the current record's "idcommentaire" value
 * @method integer        getIdauto()        Returns the current record's "idauto" value
 * @method integer        getIdgroup()       Returns the current record's "idgroup" value
 * @method integer        getIduser()        Returns the current record's "iduser" value
 * @method integer        getActive()        Returns the current record's "active" value
 * @method CarAuto        getCarAuto()       Returns the current record's "CarAuto" value
 * @method CarCommentaire setIdcommentaire() Sets the current record's "idcommentaire" value
 * @method CarCommentaire setIdauto()        Sets the current record's "idauto" value
 * @method CarCommentaire setIdgroup()       Sets the current record's "idgroup" value
 * @method CarCommentaire setIduser()        Sets the current record's "iduser" value
 * @method CarCommentaire setActive()        Sets the current record's "active" value
 * @method CarCommentaire setCarAuto()       Sets the current record's "CarAuto" value
 * 
 * @package    car
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseCarCommentaire extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('car_commentaire');
        $this->hasColumn('idcommentaire', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('idauto', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('idgroup', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('iduser', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '4',
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
        $this->hasOne('CarAuto', array(
             'local' => 'idauto',
             'foreign' => 'idauto',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}