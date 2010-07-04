<?php 
require_once dirname(__FILE__).'/../../copix.inc.php';
class ApplicationAction
{
	
  public static function executeGeneratepage($request)
  {
    return "<div><img src='".PDFAJAXViewer::generatePage($request['page'],$request['resolution'])."' /></div>";	
  }
	
	
}

$action = new ApplicationAction();
if(isset($_GET['request']) && $_GET['request']=='getpage'){
	echo ApplicationAction::executeGeneratepage($_GET);
}

else if(isset($_GET['request']) && $_GET['request']=='fullscreen'){
	echo ApplicationAction::executeGeneratepage($_GET);
}
?>