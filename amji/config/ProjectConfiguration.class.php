<?php

require_once 'C:\\wamp\\www\\symfony\\pear\\symfony/autoload/sfCoreAutoload.class.php';
//require_once '..\lib\symfony\autoload\sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');    
    $this->enablePlugins('sfDoctrineGuardPlugin');
  }
}
