<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('AmjiStatut', 'doctrine');

/**
 * BaseAmjiStatut
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idamji_statut
 * @property string $libelle
 * @property string $image
 * @property Doctrine_Collection $AmjiUser
 * 
 * @method integer             getIdamjiStatut()  Returns the current record's "idamji_statut" value
 * @method string              getLibelle()       Returns the current record's "libelle" value
 * @method string              getImage()         Returns the current record's "image" value
 * @method Doctrine_Collection getAmjiUser()      Returns the current record's "AmjiUser" collection
 * @method AmjiStatut          setIdamjiStatut()  Sets the current record's "idamji_statut" value
 * @method AmjiStatut          setLibelle()       Sets the current record's "libelle" value
 * @method AmjiStatut          setImage()         Sets the current record's "image" value
 * @method AmjiStatut          setAmjiUser()      Sets the current record's "AmjiUser" collection
 * 
 * @package    amji
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseAmjiStatut extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('amji_statut');
        $this->hasColumn('idamji_statut', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('libelle', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '100',
             ));
        $this->hasColumn('image', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '100',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('AmjiUser', array(
             'local' => 'idamji_statut',
             'foreign' => 'idamji_statut'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}