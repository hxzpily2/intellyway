<?php 
session_start();
require_once dirname(__FILE__).'/../../copix.inc.php';
class ApplicationAction
{
	
  public static function executeGeneratepage($request)
  {
    return "<div><img src='".PDFAJAXViewer::generatePage($request['page'],$request['resolution'])."' /></div>";	
  }
	
	
}

$action = new ApplicationAction();
if($_GET['request']=='getpage'){
	echo ApplicationAction::executeGeneratepage($_GET);
}
?>