<?php
class PDFAJAXViewer{
	
	const FILENOTFOUND = "FILENOTFOUND";
	const BOOKMARKFILE = "bookmark.json";
	const INFORMATIONFILE = "info";
	
	static $DOCUMENT = "";
	static $INFOURL = "";
	static $BOOKMARKURL = "";
	static $INFOBASEURLJSON = "";
	static $INFOBASEURLXML = "";
	static $NBPAGES = "";
	static $CURRENTPAGE = "";
	static $DEFAULT_RESOL = "100";
	static $UNIQUENAME = "";
	
	public static function showViewer(){
		return "test";
	}
	
	public static function includeDOJO(){
		echo " <style type='text/css'> ".
    		 " @import '".ResourceBundle::get('pdfviewer.path.assets')."/js/dojo/dijit/themes/claro/claro.css'; ".
		     " @import '".ResourceBundle::get('pdfviewer.path.assets')."/js/dojo/resources/dojo.css'; ".
			 " html, body { height: 100%; width: 100%; padding: 0; border: 0; } ".
			 " #main { height: 100%; width: 100%; border: 0; } ".			 
			 " </style> ".
			 " <link href='".ResourceBundle::get('pdfviewer.path.assets')."/js/prototype/theme/default.css' rel='stylesheet' type='text/css'/> ".		     
			 " <script type='text/javascript' src='".ResourceBundle::get('pdfviewer.path.assets')."/js/dojo/dojo/dojo.js' djConfig='parseOnLoad: false'></script> ".
			 " <script src='".ResourceBundle::get('pdfviewer.path.assets')."/js/scroller/jquery-1.3.1.min.js' type='text/javascript'></script>".
			 " <script src='".ResourceBundle::get('pdfviewer.path.assets')."/js/scroller/jquery.scrollview.js' type='text/javascript'></script>".
			 " <link rel='stylesheet' type='text/css' href='".ResourceBundle::get('pdfviewer.path.assets')."/js/scroller/style.css'/>".
			 " <script type='text/javascript'> ".
   			 " dojo.require('dijit.dijit'); ".   
   			 " dojo.require('dojo.parser'); ".  
			 " dojo.require('dijit.Tree'); ".
			 " dojo.require('dojo.data.ItemFileReadStore'); ".
		     " dojo.require('dijit.tree.ForestStoreModel'); ".
		     " dojo.require('dijit.layout.AccordionContainer');".
			 " dojo.require('dijit.layout.ContentPane'); ".
		     " dojo.require('dijit.layout.BorderContainer'); ".		
   			 " dojo.registerModulePath('bedreamy', '../../bedreamy'); ".
   			 " dojo.require('bedreamy.integration.Commun'); ".		     
   			 " var commun = new bedreamy.integration.Commun(); ".   
			 " </script> ";
	}
	
	public static function getBookmarkJSON($pdfURL){		
		$_SESSION['DOCUMENT'] = $pdfURL;		
		$classpath  = ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/pdfhandler.jar;";
		$classpath .= ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/commons-logging.jar;";
		$classpath .= ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/commons-logging-1.0.4.jar;";
		$classpath .= ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/fontbox-1.1.0.jar;";
		$classpath .= ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/jempbox-1.1.0.jar;";
		$classpath .= ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/json_simple-1.1.jar;";
		$classpath .= ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/log4j-1.2.15.jar;";
		$classpath .= ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/lucene-core-3.0.2.jar;";
		$classpath .= ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/pdfbox-1.1.0.jar";
		
		if(file_exists($pdfURL)){			
			$cacheDirectory = ResourceBundle::get('pdfviewer.absolute.path.base')."/cache/".PDFAJAXViewer::getForlderName($pdfURL);			
			$jsonFile = $cacheDirectory."/".PDFAJAXViewer::BOOKMARKFILE;
			$jsonInfoFile = $cacheDirectory."/".PDFAJAXViewer::INFORMATIONFILE;
			PDFAJAXViewer::$INFOURL = ResourceBundle::get('pdfviewer.relatif.path.base')."/cache/".PDFAJAXViewer::getForlderName($pdfURL)."/".PDFAJAXViewer::INFORMATIONFILE.".json";
			PDFAJAXViewer::$BOOKMARKURL = ResourceBundle::get('pdfviewer.relatif.path.base')."/cache/".PDFAJAXViewer::getForlderName($pdfURL)."/".PDFAJAXViewer::BOOKMARKFILE;
			PDFAJAXViewer::$INFOBASEURLJSON = ResourceBundle::get('pdfviewer.absolute.path.base')."/cache/".PDFAJAXViewer::getForlderName($pdfURL)."/".PDFAJAXViewer::INFORMATIONFILE.".json"; 
			PDFAJAXViewer::$INFOBASEURLXML = ResourceBundle::get('pdfviewer.absolute.path.base')."/cache/".PDFAJAXViewer::getForlderName($pdfURL)."/".PDFAJAXViewer::INFORMATIONFILE.".xml";
			if(file_exists($cacheDirectory)){
				if(!file_exists($jsonFile) || !file_exists($jsonInfoFile)){
					exec("java -classpath $classpath com.bedreamy.base.PDFGetBookmarks $pdfURL -destination $jsonFile -destinationInfo $jsonInfoFile");
				}				
			}else{								
				mkdir($cacheDirectory,0777);
				exec("java -classpath $classpath com.bedreamy.base.PDFGetBookmarks $pdfURL -destination $jsonFile -destinationInfo $jsonInfoFile");				 	
			}
			PDFAJAXViewer::getNbPages();					
		}else{
			throw new Exception(FILENOTFOUND);
		}
						 
	}
	
	public static function generatePage($page,$resolution){
		
		$classpath  = ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/pdfhandler.jar;";
		$classpath .= ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/commons-logging.jar;";
		$classpath .= ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/commons-logging-1.0.4.jar;";
		$classpath .= ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/fontbox-1.1.0.jar;";
		$classpath .= ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/jempbox-1.1.0.jar;";
		$classpath .= ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/json_simple-1.1.jar;";
		$classpath .= ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/log4j-1.2.15.jar;";
		$classpath .= ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/lucene-core-3.0.2.jar;";
		$classpath .= ResourceBundle::get('pdfviewer.absolute.path.base')."/bin/jar/pdfbox-1.1.0.jar";
		
		$pagerel = ResourceBundle::get('pdfviewer.relatif.path.base')."/cache/".PDFAJAXViewer::getForlderName($_SESSION['DOCUMENT'])."/".PDFAJAXViewer::getForlderName($_SESSION['DOCUMENT']).$resolution;
		$pageabs = ResourceBundle::get('pdfviewer.absolute.path.base')."/cache/".PDFAJAXViewer::getForlderName($_SESSION['DOCUMENT'])."/".PDFAJAXViewer::getForlderName($_SESSION['DOCUMENT']).$resolution;
		PDFAJAXViewer::$CURRENTPAGE = $pagerel;
		$cacheDirectory = ResourceBundle::get('pdfviewer.absolute.path.base')."/cache/".PDFAJAXViewer::getForlderName($_SESSION['DOCUMENT']);
		if(!file_exists($cacheDirectory)){
			mkdir($cacheDirectory,0777);
		}
		if(!file_exists($pageabs.$page.".png")){			
			exec("java -classpath $classpath com.bedreamy.base.PDFToImage ".$_SESSION['DOCUMENT']." -imageType png  -startPage $page -endPage $page -resolution $resolution -outputPrefix $pageabs");
		}		
		return $pagerel.$page.".png";
	}
	
	public static function getPDFNameFromURL($pdfURL){
		return basename($pdfURL);
	}
	
	public static function getForlderName($pdfURL){
		return sha1($pdfURL);
	}
	
	public static function execIsEnabled(){
		$disabled = explode(', ', ini_get('disable_functions'));
  		return !in_array('exec', $disabled);
	}
	
	public static function getNbPages(){
		
		$xml = simplexml_load_file(PDFAJAXViewer::$INFOBASEURLXML);
		foreach($xml as $nom=>$elem) {
			if($nom="page"){
				PDFAJAXViewer::$NBPAGES = $elem;
				break;
			}
		}		
	}
}
?>