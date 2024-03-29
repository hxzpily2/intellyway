<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('AmjiRequestAttachment', 'doctrine');

/**
 * BaseAmjiRequestAttachment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idamji_file
 * @property integer $idamji_request
 * @property AmjiFile $AmjiFile
 * @property AmjiRequest $AmjiRequest
 * 
 * @method integer               getIdamjiFile()     Returns the current record's "idamji_file" value
 * @method integer               getIdamjiRequest()  Returns the current record's "idamji_request" value
 * @method AmjiFile              getAmjiFile()       Returns the current record's "AmjiFile" value
 * @method AmjiRequest           getAmjiRequest()    Returns the current record's "AmjiRequest" value
 * @method AmjiRequestAttachment setIdamjiFile()     Sets the current record's "idamji_file" value
 * @method AmjiRequestAttachment setIdamjiRequest()  Sets the current record's "idamji_request" value
 * @method AmjiRequestAttachment setAmjiFile()       Sets the current record's "AmjiFile" value
 * @method AmjiRequestAttachment setAmjiRequest()    Sets the current record's "AmjiRequest" value
 * 
 * @package    amji
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseAmjiRequestAttachment extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('amji_request_attachment');
        $this->hasColumn('idamji_file', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('idamji_request', 'integer', 4, array(
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

        $this->hasOne('AmjiRequest', array(
             'local' => 'idamji_request',
             'foreign' => 'idamji_request'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}