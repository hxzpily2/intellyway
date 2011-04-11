<?php

/**
 * CarMarque
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    car
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class CarMarque extends BaseCarMarque
{
	public function __toString(){
		return $this->getTitle();
	}

        public static function getAllMarques(){
            $q = Doctrine_Query::create ()->from ( 'CarMarque c' )->where("c.active = 1")->orderBy("c.title asc");
            return $q->execute ();
        }

        public static function getLogo($id){
            $q = Doctrine_Query::create ()->from ( 'CarMarque c' )->where("c.active = 1")->andWhere("c.idmarque = $id");
            return $q->execute ();
        }
}