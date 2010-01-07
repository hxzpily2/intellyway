<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('AmjiUser', 'doctrine');

/**
 * BaseAmjiUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idamji_user
 * @property string $pseudo
 * @property string $email
 * @property string $nom
 * @property string $prenom
 * @property string $adr
 * @property string $tel
 * @property integer $etudiant
 * @property string $ecole
 * @property string $niveau
 * @property integer $salarie
 * @property string $statut
 * @property string $societe
 * @property integer $idamji_statut
 * @property AmjiStatut $AmjiStatut
 * @property Doctrine_Collection $AmjiRequest
 * @property Doctrine_Collection $AmjiResponse
 * 
 * @method integer             getIdamjiUser()    Returns the current record's "idamji_user" value
 * @method string              getPseudo()        Returns the current record's "pseudo" value
 * @method string              getEmail()         Returns the current record's "email" value
 * @method string              getNom()           Returns the current record's "nom" value
 * @method string              getPrenom()        Returns the current record's "prenom" value
 * @method string              getAdr()           Returns the current record's "adr" value
 * @method string              getTel()           Returns the current record's "tel" value
 * @method integer             getEtudiant()      Returns the current record's "etudiant" value
 * @method string              getEcole()         Returns the current record's "ecole" value
 * @method string              getNiveau()        Returns the current record's "niveau" value
 * @method integer             getSalarie()       Returns the current record's "salarie" value
 * @method string              getStatut()        Returns the current record's "statut" value
 * @method string              getSociete()       Returns the current record's "societe" value
 * @method integer             getIdamjiStatut()  Returns the current record's "idamji_statut" value
 * @method AmjiStatut          getAmjiStatut()    Returns the current record's "AmjiStatut" value
 * @method Doctrine_Collection getAmjiRequest()   Returns the current record's "AmjiRequest" collection
 * @method Doctrine_Collection getAmjiResponse()  Returns the current record's "AmjiResponse" collection
 * @method AmjiUser            setIdamjiUser()    Sets the current record's "idamji_user" value
 * @method AmjiUser            setPseudo()        Sets the current record's "pseudo" value
 * @method AmjiUser            setEmail()         Sets the current record's "email" value
 * @method AmjiUser            setNom()           Sets the current record's "nom" value
 * @method AmjiUser            setPrenom()        Sets the current record's "prenom" value
 * @method AmjiUser            setAdr()           Sets the current record's "adr" value
 * @method AmjiUser            setTel()           Sets the current record's "tel" value
 * @method AmjiUser            setEtudiant()      Sets the current record's "etudiant" value
 * @method AmjiUser            setEcole()         Sets the current record's "ecole" value
 * @method AmjiUser            setNiveau()        Sets the current record's "niveau" value
 * @method AmjiUser            setSalarie()       Sets the current record's "salarie" value
 * @method AmjiUser            setStatut()        Sets the current record's "statut" value
 * @method AmjiUser            setSociete()       Sets the current record's "societe" value
 * @method AmjiUser            setIdamjiStatut()  Sets the current record's "idamji_statut" value
 * @method AmjiUser            setAmjiStatut()    Sets the current record's "AmjiStatut" value
 * @method AmjiUser            setAmjiRequest()   Sets the current record's "AmjiRequest" collection
 * @method AmjiUser            setAmjiResponse()  Sets the current record's "AmjiResponse" collection
 * 
 * @package    amji
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseAmjiUser extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('amji_user');
        $this->hasColumn('idamji_user', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('pseudo', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '100',
             ));
        $this->hasColumn('email', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '100',
             ));
        $this->hasColumn('nom', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '100',
             ));
        $this->hasColumn('prenom', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '100',
             ));
        $this->hasColumn('adr', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '100',
             ));
        $this->hasColumn('tel', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '100',
             ));
        $this->hasColumn('etudiant', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '1',
             ));
        $this->hasColumn('ecole', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '100',
             ));
        $this->hasColumn('niveau', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '100',
             ));
        $this->hasColumn('salarie', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '1',
             ));
        $this->hasColumn('statut', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '100',
             ));
        $this->hasColumn('societe', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '100',
             ));
        $this->hasColumn('idamji_statut', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '4',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('AmjiStatut', array(
             'local' => 'idamji_statut',
             'foreign' => 'idamji_statut'));

        $this->hasMany('AmjiRequest', array(
             'local' => 'idamji_user',
             'foreign' => 'iduser'));

        $this->hasMany('AmjiResponse', array(
             'local' => 'idamji_user',
             'foreign' => 'iduser'));
    }
}