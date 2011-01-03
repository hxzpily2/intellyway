<?php

/**
 * CarAuto form.
 *
 * @package    car
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CarAutoForm extends BaseCarAutoForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'idauto'         => new sfWidgetFormInputHidden(),
      'idpays'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarPays'), 'add_empty' => true)),
      'idville'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarVille'), 'add_empty' => true)),
      'idmodele'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarModele'), 'add_empty' => true)),
      'idmoteur'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarMoteur'), 'add_empty' => true)),
      'idtype'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarType'), 'add_empty' => true)),
      'idetat'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarEtat'), 'add_empty' => true)),
      'idcouleur'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarCouleur'), 'add_empty' => true)),
      'idcarosserie'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarCarosserie'), 'add_empty' => true)),
      'idboite'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CarBoite'), 'add_empty' => true)),
      'anneecir'       => new sfWidgetFormInputText(),
      'moiscir'        => new sfWidgetFormInputText(),
      'anneeded'       => new sfWidgetFormInputText(),
      'moisded'        => new sfWidgetFormInputText(),
      'description'    => new isicsWidgetFormTinyMCE(array('tiny_options' => array(
      										'theme' => 'advanced',
      										'mode'=>'textareas',
      										'theme_advanced_buttons1'=>'save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect',
  											'theme_advanced_buttons2'=>'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
  											'theme_advanced_buttons3'=>'tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen',
  											'theme_advanced_buttons4'=>'insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage',
  											'theme_advanced_toolbar_location'=>'top',
  											'theme_advanced_toolbar_align'=>'left',
  											'theme_advanced_statusbar_location'=> 'bottom',
    										'theme_advanced_resizing'=> 'true',
  											'skin'=> 'o2k7',
  											'skin_variant'=> 'silver'
  																				  	
  							))),  	
      'nbportes'       => new sfWidgetFormInputText(),
      'pfiscale'       => new sfWidgetFormInputText(),
      'kilometrage'    => new sfWidgetFormInputText(),
      'cylindres'      => new sfWidgetFormInputText(),
      'prixstart'      => new sfWidgetFormInputText(),
      'reprise'        => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),
      'garantie'       => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),
      'anneegarantie'  => new sfWidgetFormInputText(),  	
      'active'         => new sfWidgetFormInputCheckbox(array('value_attribute_value' => true)),      
    ));

    $this->setValidators(array(
      'idauto'         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'idauto', 'required' => false)),
      'idpays'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarPays'), 'required' => false)),
      'idville'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarVille'), 'required' => false)),        
      'idmarque'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarMarque'), 'required' => false)),
      'idmodele'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarModele'), 'required' => false)),
      'idmoteur'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarMoteur'), 'required' => false)),
      'idtype'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarType'), 'required' => false)),
      'idetat'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarEtat'), 'required' => false)),
      'idcouleur'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarCouleur'), 'required' => false)),
      'idcarosserie'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarCarosserie'), 'required' => false)),
      'idboite'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CarBoite'), 'required' => false)),
      'anneecir'       => new sfValidatorInteger(array('required' => false)),
      'moiscir'        => new sfValidatorInteger(array('required' => false)),
      'anneeded'       => new sfValidatorInteger(array('required' => false)),
      'moisded'        => new sfValidatorInteger(array('required' => false)),
      'description'    => new sfValidatorString(),
      'nbportes'       => new sfValidatorInteger(array('required' => false)),
      'pfiscale'       => new sfValidatorInteger(array('required' => false)),
      'kilometrage'    => new sfValidatorInteger(array('required' => false)),
      'cylindres'      => new sfValidatorInteger(array('required' => false)),
      'prixstart'      => new sfValidatorInteger(array('required' => false)),
      'reprise'        => new sfValidatorBoolean(),	
      'garantie'       => new sfValidatorBoolean(),	
      'anneegarantie'  => new sfValidatorInteger(),    
      'active'         => new sfValidatorBoolean(),	      
    ));

    $this->widgetSchema->setNameFormat('car_auto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
