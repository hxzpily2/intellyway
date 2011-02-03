<?php

/**
 * CarModele
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    car
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class CarModele extends BaseCarModele
{
	public function __toString(){
		return $this->getTitle();
	}

        public static function getAllByMarque($id){
            $q = Doctrine_Query::create ()->from ( 'CarModele m' )->leftJoin('m.CarMarque ma')->where("m.active = 1")->andWhere("ma.idmarque = $id");
            return $q->execute ();
        }
}