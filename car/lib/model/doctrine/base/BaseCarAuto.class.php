<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CarAuto', 'doctrine');

/**
 * BaseCarAuto
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idauto
 * @property integer $idmarque
 * @property integer $idmodele
 * @property integer $idmoteur
 * @property integer $idtype
 * @property integer $idetat
 * @property integer $idcouleur
 * @property integer $idcarosserie
 * @property integer $idboite
 * @property integer $anneecir
 * @property integer $moiscir
 * @property integer $anneeded
 * @property integer $moisded
 * @property string $description
 * @property integer $notevisiteur
 * @property integer $nbnotevisiteur
 * @property integer $noteadmin
 * @property integer $nbnoteadmin
 * @property integer $nbportes
 * @property integer $pfiscale
 * @property integer $kilometrage
 * @property integer $cylindres
 * @property integer $notedesign
 * @property integer $nbnotedesign
 * @property integer $noteperf
 * @property integer $nbnoteperf
 * @property integer $noteconf
 * @property integer $nbnoteconf
 * @property integer $notecond
 * @property integer $nbnotecond
 * @property integer $prixstart
 * @property integer $reprise
 * @property integer $active
 * @property CarMarque $CarMarque
 * @property CarModele $CarModele
 * @property CarType $CarType
 * @property CarMoteur $CarMoteur
 * @property CarEtat $CarEtat
 * @property CarCouleur $CarCouleur
 * @property Doctrine_Collection $CarCarosserie
 * @property Doctrine_Collection $CarBoite
 * @property Doctrine_Collection $CarAccessoires
 * @property Doctrine_Collection $CarImages
 * @property Doctrine_Collection $CarEncher
 * @property Doctrine_Collection $CarCreneau
 * @property Doctrine_Collection $CarCreneauProposition
 * @property Doctrine_Collection $CarCommentaire
 * @property Doctrine_Collection $CarAutoPrestations
 * @property Doctrine_Collection $CarPromotion
 * @property Doctrine_Collection $CarEvaluation
 * 
 * @method integer             getIdauto()                Returns the current record's "idauto" value
 * @method integer             getIdmarque()              Returns the current record's "idmarque" value
 * @method integer             getIdmodele()              Returns the current record's "idmodele" value
 * @method integer             getIdmoteur()              Returns the current record's "idmoteur" value
 * @method integer             getIdtype()                Returns the current record's "idtype" value
 * @method integer             getIdetat()                Returns the current record's "idetat" value
 * @method integer             getIdcouleur()             Returns the current record's "idcouleur" value
 * @method integer             getIdcarosserie()          Returns the current record's "idcarosserie" value
 * @method integer             getIdboite()               Returns the current record's "idboite" value
 * @method integer             getAnneecir()              Returns the current record's "anneecir" value
 * @method integer             getMoiscir()               Returns the current record's "moiscir" value
 * @method integer             getAnneeded()              Returns the current record's "anneeded" value
 * @method integer             getMoisded()               Returns the current record's "moisded" value
 * @method string              getDescription()           Returns the current record's "description" value
 * @method integer             getNotevisiteur()          Returns the current record's "notevisiteur" value
 * @method integer             getNbnotevisiteur()        Returns the current record's "nbnotevisiteur" value
 * @method integer             getNoteadmin()             Returns the current record's "noteadmin" value
 * @method integer             getNbnoteadmin()           Returns the current record's "nbnoteadmin" value
 * @method integer             getNbportes()              Returns the current record's "nbportes" value
 * @method integer             getPfiscale()              Returns the current record's "pfiscale" value
 * @method integer             getKilometrage()           Returns the current record's "kilometrage" value
 * @method integer             getCylindres()             Returns the current record's "cylindres" value
 * @method integer             getNotedesign()            Returns the current record's "notedesign" value
 * @method integer             getNbnotedesign()          Returns the current record's "nbnotedesign" value
 * @method integer             getNoteperf()              Returns the current record's "noteperf" value
 * @method integer             getNbnoteperf()            Returns the current record's "nbnoteperf" value
 * @method integer             getNoteconf()              Returns the current record's "noteconf" value
 * @method integer             getNbnoteconf()            Returns the current record's "nbnoteconf" value
 * @method integer             getNotecond()              Returns the current record's "notecond" value
 * @method integer             getNbnotecond()            Returns the current record's "nbnotecond" value
 * @method integer             getPrixstart()             Returns the current record's "prixstart" value
 * @method integer             getReprise()               Returns the current record's "reprise" value
 * @method integer             getActive()                Returns the current record's "active" value
 * @method CarMarque           getCarMarque()             Returns the current record's "CarMarque" value
 * @method CarModele           getCarModele()             Returns the current record's "CarModele" value
 * @method CarType             getCarType()               Returns the current record's "CarType" value
 * @method CarMoteur           getCarMoteur()             Returns the current record's "CarMoteur" value
 * @method CarEtat             getCarEtat()               Returns the current record's "CarEtat" value
 * @method CarCouleur          getCarCouleur()            Returns the current record's "CarCouleur" value
 * @method Doctrine_Collection getCarCarosserie()         Returns the current record's "CarCarosserie" collection
 * @method Doctrine_Collection getCarBoite()              Returns the current record's "CarBoite" collection
 * @method Doctrine_Collection getCarAccessoires()        Returns the current record's "CarAccessoires" collection
 * @method Doctrine_Collection getCarImages()             Returns the current record's "CarImages" collection
 * @method Doctrine_Collection getCarEncher()             Returns the current record's "CarEncher" collection
 * @method Doctrine_Collection getCarCreneau()            Returns the current record's "CarCreneau" collection
 * @method Doctrine_Collection getCarCreneauProposition() Returns the current record's "CarCreneauProposition" collection
 * @method Doctrine_Collection getCarCommentaire()        Returns the current record's "CarCommentaire" collection
 * @method Doctrine_Collection getCarAutoPrestations()    Returns the current record's "CarAutoPrestations" collection
 * @method Doctrine_Collection getCarPromotion()          Returns the current record's "CarPromotion" collection
 * @method Doctrine_Collection getCarEvaluation()         Returns the current record's "CarEvaluation" collection
 * @method CarAuto             setIdauto()                Sets the current record's "idauto" value
 * @method CarAuto             setIdmarque()              Sets the current record's "idmarque" value
 * @method CarAuto             setIdmodele()              Sets the current record's "idmodele" value
 * @method CarAuto             setIdmoteur()              Sets the current record's "idmoteur" value
 * @method CarAuto             setIdtype()                Sets the current record's "idtype" value
 * @method CarAuto             setIdetat()                Sets the current record's "idetat" value
 * @method CarAuto             setIdcouleur()             Sets the current record's "idcouleur" value
 * @method CarAuto             setIdcarosserie()          Sets the current record's "idcarosserie" value
 * @method CarAuto             setIdboite()               Sets the current record's "idboite" value
 * @method CarAuto             setAnneecir()              Sets the current record's "anneecir" value
 * @method CarAuto             setMoiscir()               Sets the current record's "moiscir" value
 * @method CarAuto             setAnneeded()              Sets the current record's "anneeded" value
 * @method CarAuto             setMoisded()               Sets the current record's "moisded" value
 * @method CarAuto             setDescription()           Sets the current record's "description" value
 * @method CarAuto             setNotevisiteur()          Sets the current record's "notevisiteur" value
 * @method CarAuto             setNbnotevisiteur()        Sets the current record's "nbnotevisiteur" value
 * @method CarAuto             setNoteadmin()             Sets the current record's "noteadmin" value
 * @method CarAuto             setNbnoteadmin()           Sets the current record's "nbnoteadmin" value
 * @method CarAuto             setNbportes()              Sets the current record's "nbportes" value
 * @method CarAuto             setPfiscale()              Sets the current record's "pfiscale" value
 * @method CarAuto             setKilometrage()           Sets the current record's "kilometrage" value
 * @method CarAuto             setCylindres()             Sets the current record's "cylindres" value
 * @method CarAuto             setNotedesign()            Sets the current record's "notedesign" value
 * @method CarAuto             setNbnotedesign()          Sets the current record's "nbnotedesign" value
 * @method CarAuto             setNoteperf()              Sets the current record's "noteperf" value
 * @method CarAuto             setNbnoteperf()            Sets the current record's "nbnoteperf" value
 * @method CarAuto             setNoteconf()              Sets the current record's "noteconf" value
 * @method CarAuto             setNbnoteconf()            Sets the current record's "nbnoteconf" value
 * @method CarAuto             setNotecond()              Sets the current record's "notecond" value
 * @method CarAuto             setNbnotecond()            Sets the current record's "nbnotecond" value
 * @method CarAuto             setPrixstart()             Sets the current record's "prixstart" value
 * @method CarAuto             setReprise()               Sets the current record's "reprise" value
 * @method CarAuto             setActive()                Sets the current record's "active" value
 * @method CarAuto             setCarMarque()             Sets the current record's "CarMarque" value
 * @method CarAuto             setCarModele()             Sets the current record's "CarModele" value
 * @method CarAuto             setCarType()               Sets the current record's "CarType" value
 * @method CarAuto             setCarMoteur()             Sets the current record's "CarMoteur" value
 * @method CarAuto             setCarEtat()               Sets the current record's "CarEtat" value
 * @method CarAuto             setCarCouleur()            Sets the current record's "CarCouleur" value
 * @method CarAuto             setCarCarosserie()         Sets the current record's "CarCarosserie" collection
 * @method CarAuto             setCarBoite()              Sets the current record's "CarBoite" collection
 * @method CarAuto             setCarAccessoires()        Sets the current record's "CarAccessoires" collection
 * @method CarAuto             setCarImages()             Sets the current record's "CarImages" collection
 * @method CarAuto             setCarEncher()             Sets the current record's "CarEncher" collection
 * @method CarAuto             setCarCreneau()            Sets the current record's "CarCreneau" collection
 * @method CarAuto             setCarCreneauProposition() Sets the current record's "CarCreneauProposition" collection
 * @method CarAuto             setCarCommentaire()        Sets the current record's "CarCommentaire" collection
 * @method CarAuto             setCarAutoPrestations()    Sets the current record's "CarAutoPrestations" collection
 * @method CarAuto             setCarPromotion()          Sets the current record's "CarPromotion" collection
 * @method CarAuto             setCarEvaluation()         Sets the current record's "CarEvaluation" collection
 * 
 * @package    car
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseCarAuto extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('car_auto');
        $this->hasColumn('idauto', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '10',
             ));
        $this->hasColumn('idmarque', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '10',
             ));
        $this->hasColumn('idmodele', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '10',
             ));
        $this->hasColumn('idmoteur', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '10',
             ));
        $this->hasColumn('idtype', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '10',
             ));
        $this->hasColumn('idetat', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '10',
             ));
        $this->hasColumn('idcouleur', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '10',
             ));
        $this->hasColumn('idcarosserie', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '10',
             ));
        $this->hasColumn('idboite', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '10',
             ));
        $this->hasColumn('anneecir', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '10',
             ));
        $this->hasColumn('moiscir', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('anneeded', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '10',
             ));
        $this->hasColumn('moisded', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
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
        $this->hasColumn('notevisiteur', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('nbnotevisiteur', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('noteadmin', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('nbnoteadmin', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('nbportes', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('pfiscale', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('kilometrage', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('cylindres', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('notedesign', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('nbnotedesign', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('noteperf', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('nbnoteperf', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('noteconf', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('nbnoteconf', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('notecond', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('nbnotecond', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('prixstart', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             'length' => '10',
             ));
        $this->hasColumn('reprise', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '1',
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
        $this->hasOne('CarMarque', array(
             'local' => 'idmarque',
             'foreign' => 'idmarque'));

        $this->hasOne('CarModele', array(
             'local' => 'idmodele',
             'foreign' => 'idmodele'));

        $this->hasOne('CarType', array(
             'local' => 'idtype',
             'foreign' => 'idtype'));

        $this->hasOne('CarMoteur', array(
             'local' => 'idmoteur',
             'foreign' => 'idmoteur'));

        $this->hasOne('CarEtat', array(
             'local' => 'idetat',
             'foreign' => 'idetat'));

        $this->hasOne('CarCouleur', array(
             'local' => 'idcouleur',
             'foreign' => 'idcouleur'));

        $this->hasMany('CarCarosserie', array(
             'local' => 'idcarosserie',
             'foreign' => 'idcarosserie'));

        $this->hasMany('CarBoite', array(
             'local' => 'idboite',
             'foreign' => 'idboite'));

        $this->hasMany('CarAccessoires', array(
             'local' => 'idauto',
             'foreign' => 'idauto'));

        $this->hasMany('CarImages', array(
             'local' => 'idauto',
             'foreign' => 'idauto'));

        $this->hasMany('CarEncher', array(
             'local' => 'idauto',
             'foreign' => 'idauto'));

        $this->hasMany('CarCreneau', array(
             'local' => 'idauto',
             'foreign' => 'idauto'));

        $this->hasMany('CarCreneauProposition', array(
             'local' => 'idauto',
             'foreign' => 'idauto'));

        $this->hasMany('CarCommentaire', array(
             'local' => 'idauto',
             'foreign' => 'idauto'));

        $this->hasMany('CarAutoPrestations', array(
             'local' => 'idauto',
             'foreign' => 'idauto'));

        $this->hasMany('CarPromotion', array(
             'local' => 'idauto',
             'foreign' => 'idauto'));

        $this->hasMany('CarEvaluation', array(
             'local' => 'idauto',
             'foreign' => 'idauto'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}