<?php

/**
 * CarPays
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    car
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class CarPays extends BaseCarPays
{
	public function __toString(){
		return $this->getTitle();
	}

        public static function getDefaultPays($code){
            $q = Doctrine_Query::create ()->from ( 'CarPays c' )->where("c.code = '$code'");
            $array = $q->execute ();
            if(count($array)>0)
                return $array[0];
            else
                return NULL;
        }
}