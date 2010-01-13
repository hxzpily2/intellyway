<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('AmjiResponseAttachment', 'doctrine');

/**
 * BaseAmjiResponseAttachment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idamji_response
 * @property integer $idamji_file
 * @property AmjiFile $AmjiFile
 * @property AmjiResponse $AmjiResponse
 * 
 * @method integer                getIdamjiResponse()  Returns the current record's "idamji_response" value
 * @method integer                getIdamjiFile()      Returns the current record's "idamji_file" value
 * @method AmjiFile               getAmjiFile()        Returns the current record's "AmjiFile" value
 * @method AmjiResponse           getAmjiResponse()    Returns the current record's "AmjiResponse" value
 * @method AmjiResponseAttachment setIdamjiResponse()  Sets the current record's "idamji_response" value
 * @method AmjiResponseAttachment setIdamjiFile()      Sets the current record's "idamji_file" value
 * @method AmjiResponseAttachment setAmjiFile()        Sets the current record's "AmjiFile" value
 * @method AmjiResponseAttachment setAmjiResponse()    Sets the current record's "AmjiResponse" value
 * 
 * @package    amji
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseAmjiResponseAttachment extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('amji_response_attachment');
        $this->hasColumn('idamji_response', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('idamji_file', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('AmjiFile', array(
             'local' => 'idamji_file',
             'foreign' => 'idamji_file'));

        $this->hasOne('AmjiResponse', array(
             'local' => 'idamji_response',
             'foreign' => 'idamji_response'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}