<?php 
require_once dirname(__FILE__).'/../copix/bedreamy/PDFAJAXViewer.class.php';

$params = array(
			PDFAJAXViewer::BUTTON_FULLSCREEN => TRUE,
			PDFAJAXViewer::BUTTON_RESTORESCREEN => TRUE,
			PDFAJAXViewer::BUTTON_ZOOM => TRUE,			
			PDFAJAXViewer::BUTTON_NAVIGATION => TRUE,
			PDFAJAXViewer::BUTTON_SEARCH => TRUE,
			PDFAJAXViewer::BUTTON_ISSINGNED => TRUE,
			PDFAJAXViewer::BUTTON_PRINT => TRUE,
			PDFAJAXViewer::TREE_BOOKMARK => TRUE,
			PDFAJAXViewer::BUTTON_INFO => TRUE				
			);
			
PDFAJAXViewer::buttonToActivate($params);			
PDFAJAXViewer::showViewer("C:/test.pdf");


?>

	


