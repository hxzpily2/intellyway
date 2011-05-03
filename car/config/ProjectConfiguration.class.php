<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/autoload/sfCoreAutoload.class.php';

sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
    $this->enablePlugins('sfDoctrineGuardPlugin');
    $this->enablePlugins('sfFormExtraPlugin');
    $this->enablePlugins('isicsWidgetFormTinyMCEPlugin');
    $this->enablePlugins('sfJqueryReloadedPlugin');
    $this->enablePlugins('sfDoctrineActAsTaggablePlugin');
    $this->enablePlugins('sfWebBrowserPlugin');
    $this->enablePlugins('sfFeed2Plugin');
    $this->enablePlugins('sfSyncContentPlugin');
    $this->enablePlugins('apostrophePlugin');
    $this->enablePlugins('apostropheBlogPlugin');
    $this->enablePlugins('sfTaskExtraPlugin');

    set_include_path(sfConfig::get('sf_lib_dir') .'/vendor' . PATH_SEPARATOR . get_include_path());

  }
  
  static public function registerZend()
  {
    if (self::$zendLoaded)
    {
      return;
    }
 
    set_include_path(sfConfig::get('sf_lib_dir').'/vendor'.PATH_SEPARATOR.get_include_path());
    require_once sfConfig::get('sf_lib_dir').'/vendor/Zend/Loader/Autoloader.php';
    Zend_Loader_Autoloader::getInstance();
    self::$zendLoaded = true;
  }
}
