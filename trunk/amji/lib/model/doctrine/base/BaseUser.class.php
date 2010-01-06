<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('User', 'doctrine');

/**
 * BaseUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $email
 * @property string $nom
 * @property string $prenom
 * @property string $pseudo
 * @property string $adr
 * @property string $tel
 * @property integer $etudiant
 * @property integer $salarie
 * @property string $statut
 * @property string $entreprise
 * @property string $niveauetude
 * @property string $ecole
 * @property integer $iduser
 * @property Doctrine_Collection $Request
 * @property Doctrine_Collection $Response
 * 
 * @method string              getEmail()       Returns the current record's "email" value
 * @method string              getNom()         Returns the current record's "nom" value
 * @method string              getPrenom()      Returns the current record's "prenom" value
 * @method string              getPseudo()      Returns the current record's "pseudo" value
 * @method string              getAdr()         Returns the current record's "adr" value
 * @method string              getTel()         Returns the current record's "tel" value
 * @method integer             getEtudiant()    Returns the current record's "etudiant" value
 * @method integer             getSalarie()     Returns the current record's "salarie" value
 * @method string              getStatut()      Returns the current record's "statut" value
 * @method string              getEntreprise()  Returns the current record's "entreprise" value
 * @method string              getNiveauetude() Returns the current record's "niveauetude" value
 * @method string              getEcole()       Returns the current record's "ecole" value
 * @method integer             getIduser()      Returns the current record's "iduser" value
 * @method Doctrine_Collection getRequest()     Returns the current record's "Request" collection
 * @method Doctrine_Collection getResponse()    Returns the current record's "Response" collection
 * @method User                setEmail()       Sets the current record's "email" value
 * @method User                setNom()         Sets the current record's "nom" value
 * @method User                setPrenom()      Sets the current record's "prenom" value
 * @method User                setPseudo()      Sets the current record's "pseudo" value
 * @method User                setAdr()         Sets the current record's "adr" value
 * @method User                setTel()         Sets the current record's "tel" value
 * @method User                setEtudiant()    Sets the current record's "etudiant" value
 * @method User                setSalarie()     Sets the current record's "salarie" value
 * @method User                setStatut()      Sets the current record's "statut" value
 * @method User                setEntreprise()  Sets the current record's "entreprise" value
 * @method User                setNiveauetude() Sets the current record's "niveauetude" value
 * @method User                setEcole()       Sets the current record's "ecole" value
 * @method User                setIduser()      Sets the current record's "iduser" value
 * @method User                setRequest()     Sets the current record's "Request" collection
 * @method User                setResponse()    Sets the current record's "Response" collection
 * 
 * @package    amji
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseUser extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('user');
        $this->hasColumn('email', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '100',
             ));
        $this->hasColumn('nom', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '45',
             ));
        $this->hasColumn('prenom', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '45',
             ));
        $this->hasColumn('pseudo', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '45',
             ));
        $this->hasColumn('adr', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '45',
             ));
        $this->hasColumn('tel', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '45',
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
        $this->hasColumn('salarie', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '1',
             ));
        $this->hasColumn('statut', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '45',
             ));
        $this->hasColumn('entreprise', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '45',
             ));
        $this->hasColumn('niveauetude', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '45',
             ));
        $this->hasColumn('ecole', 'string', 45, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '45',
             ));
        $this->hasColumn('iduser', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Request', array(
             'local' => 'iduser',
             'foreign' => 'user'));

        $this->hasMany('Response', array(
             'local' => 'iduser',
             'foreign' => 'user'));
    }
}