<?php
require_once dirname ( __FILE__ ) . '/../copix.inc.php';

class PDFAJAXViewer {
	
	const FILENOTFOUND = "FILENOTFOUND";
	const BOOKMARKFILE = "bookmark.json";
	const INFORMATIONFILE = "info";
	
	const SESSION_DOCUMENT = "SESSION_DOCUMENT";
	const SESSION_PAGE = "SESSION_PAGE";
	const SESSION_RESOLUTION = "SESSION_RESOLUTION";
	const SESSION_PARAMS = "SESSION_PARAMS";
	
	const BUTTON_FULLSCREEN = "BUTTON_FULLSCREEN";
	const BUTTON_RESTORESCREEN = "BUTTON_RESTORESCREEN";
	const BUTTON_ZOOM = "BUTTON_ZOOMOUT";
	const BUTTON_NAVIGATION = "BUTTON_NAVIGATION";
	const BUTTON_SEARCH = "BUTTON_SEARCH";
	const BUTTON_ISSINGNED = "BUTTON_ISSINGNED";
	const BUTTON_PRINT = "BUTTON_PRINT";
	const BUTTON_INFO = "BUTTON_INFO";
	const TREE_BOOKMARK = "TREE_BOOKMARK";
	
	static $DOCUMENT = "";
	static $INFOURL = "";
	static $BOOKMARKURL = "";
	static $INFOBASEURLJSON = "";
	static $INFOBASEURLXML = "";
	static $NBPAGES = "";
	static $ISSIGNED = "";
	static $CURRENTPAGE = "";
	static $DEFAULT_RESOL = "100";
	static $UNIQUENAME = "";
	
	public static function showViewer($file) {
		PDFAJAXViewer::getBookmarkJSON ( $file );
		PDFAJAXViewer::includeDOJO ();
		echo PDFAJAXViewer::getContent ();
		//echo CopixI18N::get('copix:copix.yes','fr');	
	

	}
	
	public static function getContent() {
		$params = $_SESSION [PDFAJAXViewer::SESSION_PARAMS];
		
		$data = "<body class='claro'>" . "<div id='loader'><!-- <div id='loaderInner' style='direction: ltr;'>Loading theme Tester ...</div>  -->
			<table width='100%' height='100%'>
				<tr>
					<td valign='middle' align='center'><img
						src='" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "/images/preloader.gif' /></td>
				</tr>
			</table>
			</div>" . "<div dojoType='dojo.data.ItemFileReadStore' jsId='continentStore'
			 url='" . PDFAJAXViewer::$BOOKMARKURL . "'></div>
			<div dojoType='dijit.tree.ForestStoreModel' jsId='continentModel'
			store='continentStore' query='{type:\"chapter\"}'
			rootId='chapterRoot' rootLabel='Chapters' childrenAttrs='children'></div>
			<div dojoType='dojo.data.ItemFileReadStore' jsId='stateStore'
			url='states.json'></div>" . 

		"<div id='main' dojoType='dijit.layout.BorderContainer'
			gutters='true'>";
		
		$data .= "<input type='hidden' id='mode' value='".(isset($_GET['mode'])?$_GET['mode']:"")."'/>";
		////header ici
		////footer ici
		if ($params [PDFAJAXViewer::TREE_BOOKMARK] == TRUE) {
			$data .= "<div id='containerBookmark' dojoType='dijit.layout.AccordionContainer' minSize='20'
			style='width: 300px;' id='leftAccordion' region='leading'
			splitter='true'>" . "<div dojoType='dijit.layout.ContentPane' title='Sommaire'>";
			
			// treeview
			$data .= "<div dojoType='dijit.Tree' id='tree2' model='continentModel'
					showRoot='false' openOnClick='true'>
				<script
						type='dojo/method' event='getIconClass' args='item, opened'>
			            return (item == this.model.root || continentStore.getValue(item, 'type') == 'chapter') ?
			                   (opened ? 'customFolderOpenedIcon' : 'customFolderClosedIcon') :
			                    'noteIcon';
				</script> 
			<script type='dojo/method' event='onClick' args='item'>
					commun.getPage('" . ResourceBundle::get ( 'pdfviewer.relatif.path.base' ) . "/copix/bedreamy/action/action.class.php',parseInt(continentStore.getValue(item, 'page'))+1,parseInt(dojo.byId('zoom').value),'" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "');
					
			</script>
			</div></div></div>";
		}
		///PDFViewer
		$data .= "
			<div id='containerPage' dojoType='dijit.layout.AccordionContainer' minSize='20'
			region='center' id='topTabs' >
			<div id='pageContent' style='padding: 0;overflow: hidden;' dojoType='dijit.layout.ContentPane'
			title='Titre'>
			<span dojoType='dijit.Declaration'
			widgetClass='ToolbarSectionStart' defaults=\"{ label: 'Label'}\"> <span
			dojoType='dijit.ToolbarSeparator'></span><i>\${label}:</i> </span>";
		
		////Toolbar
		$data .= "<div id='toolbar1' dojoType='dijit.Toolbar'>";
		// button restore screen			
		if ($params [PDFAJAXViewer::BUTTON_RESTORESCREEN] == TRUE) {
			$data .= "<div onclick=\"commun.restoreScreen()\" dojoType='dijit.form.Button' id='toolbar1.cut'
					iconClass='dijitEditorIcon dijitEditorIconRestaure' showLabel='false'></div>";
		}
		// button fullscreen
		if ($params [PDFAJAXViewer::BUTTON_FULLSCREEN] == TRUE) {
			$data .= "<div onclick=\"commun.fullScreen('" .PDFAJAXViewer::curPageURL()."?mode=fullscreen')\" dojoType='dijit.form.Button' id='toolbar1.copy'
					iconClass='dijitEditorIcon dijitEditorIconFull' showLabel='false'></div>";
		}
		if ($params [PDFAJAXViewer::BUTTON_FULLSCREEN] == TRUE || $params [PDFAJAXViewer::BUTTON_RESTORESCREEN] == TRUE) {
			$data .= "<div dojoType='dijit.form.Button' id='toolbar1.sepa'
					iconClass='dijitEditorIcon dijitEditorIconSepa' showLabel='false' disabled></div>";
		}
		if ($params [PDFAJAXViewer::BUTTON_ZOOM] == TRUE) {
			$data .= "<div onclick=\"javascript:commun.zoomOut('" . ResourceBundle::get ( 'pdfviewer.relatif.path.base' ) . "/copix/bedreamy/action/action.class.php','" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "')\" dojoType='dijit.form.Button' id='toolbar1.zoomout'
					iconClass='dijitEditorIcon dijitEditorIconZoomOut' showLabel='false'></div>";
			
			$data .= "<div onclick=\"javascript:commun.zoomIn('" . ResourceBundle::get ( 'pdfviewer.relatif.path.base' ) . "/copix/bedreamy/action/action.class.php','" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "')\" dojoType='dijit.form.Button' id='toolbar1.zoomin'
					iconClass='dijitEditorIcon dijitEditorIconZoomIn' showLabel='false'></div>";
			
			$data .= "<input type='hidden' id='zoom' value='100'/>";
			
			$data .= "<button id='zoomhtml' dojoType='dijit.form.DropDownButton' label='100%'>	
				<div dojoType='dijit.Menu' id='editMenu2' style='display: none;'>
					<div dojoType='dijit.MenuItem'				
						onClick=\"javascript:commun.changeResolution(100,'" . ResourceBundle::get ( 'pdfviewer.relatif.path.base' ) . "/copix/bedreamy/action/action.class.php','" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "')\">
						100%
					</div>
					<div dojoType='dijit.MenuItem'				 
						onClick=\"javascript:commun.changeResolution(80,'" . ResourceBundle::get ( 'pdfviewer.relatif.path.base' ) . "/copix/bedreamy/action/action.class.php','" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "')\">
						80%
					</div>
					<div dojoType='dijit.MenuItem'				 
						onClick=\"javascript:commun.changeResolution(60,'" . ResourceBundle::get ( 'pdfviewer.relatif.path.base' ) . "/copix/bedreamy/action/action.class.php','" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "')\">
						60%
					</div>
					<div dojoType='dijit.MenuItem'				 
						onClick=\"javascript:commun.changeResolution(40,'" . ResourceBundle::get ( 'pdfviewer.relatif.path.base' ) . "/copix/bedreamy/action/action.class.php','" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "')\">
						40%
					</div>
					<div dojoType='dijit.MenuItem'				 
						onClick=\"javascript:commun.changeResolution(20,'" . ResourceBundle::get ( 'pdfviewer.relatif.path.base' ) . "/copix/bedreamy/action/action.class.php','" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "')\">
						20%
					</div>
				</div>
			</button>";
			
			$data .= "<div dojoType='dijit.form.Button' id='toolbar1.sepa1'
				iconClass='dijitEditorIcon dijitEditorIconSepa' showLabel='false' disabled></div>";
		}
		
		if ($params [PDFAJAXViewer::BUTTON_NAVIGATION] == TRUE) {
			$data .= "<div onclick=\"javascript:commun.previousPage('" . ResourceBundle::get ( 'pdfviewer.relatif.path.base' ) . "/copix/bedreamy/action/action.class.php','" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "')\" dojoType='dijit.form.Button' id='toolbar1.previous'
				iconClass='dijitEditorIcon dijitEditorIconPreviousPage' showLabel='false'></div>";
			$data .= "<input style='width: 30px;' value='1' regExp='\d' dojoType=dijit.form.NumberTextBox type='text' id='numPage' name='numPage' >
			<input type='hidden' id='maxPage' value='" . PDFAJAXViewer::$NBPAGES . "'/>";
			
			$data .= "<input dojoType=dijit.form.TextBox style='width: 30px;' value='/" . PDFAJAXViewer::$NBPAGES . "' type='text' disabled>";
			
			$data .= "<div onclick=\"javascript:commun.nextPage('" . ResourceBundle::get ( 'pdfviewer.relatif.path.base' ) . "/copix/bedreamy/action/action.class.php','" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "')\" dojoType='dijit.form.Button' id='toolbar1.next'
				iconClass='dijitEditorIcon dijitEditorIconNextPage' showLabel='false'></div>";
			
			$data .= "<div dojoType='dijit.form.Button' id='toolbar1.sepa2'
				iconClass='dijitEditorIcon dijitEditorIconSepa' showLabel='false' disabled></div>";
		}
		if ($params [PDFAJAXViewer::BUTTON_PRINT] == TRUE) {
			$data .= "<div dojoType='dijit.form.Button' id='toolbar1.print'
				iconClass='dijitEditorIcon dijitEditorIconPrintPage' showLabel='false'></div>";
		}
		if ($params [PDFAJAXViewer::BUTTON_SEARCH] == TRUE) {
			$data .= "<div dojoType='dijit.form.Button' id='toolbar1.search'
				iconClass='dijitEditorIcon dijitEditorIconFindMot' showLabel='false'></div>";
		}
		if ($params [PDFAJAXViewer::BUTTON_ISSINGNED] == TRUE && PDFAJAXViewer::isSigned () == "true") {
			$data .= "<div id='isSignedDiv' enabled='false' dojoType='dijit.form.Button' id='toolbar1.issigned'
				iconClass='dijitEditorIcon dijitEditorIconPdfIsSigned' showLabel='false' disabled></div>";
			$data .= "<span position='below' dojoType='dijit.Tooltip' connectId='isSignedDiv' style='display:none;'>
					Ce document est signé
					</span>";
		}
		if ($params [PDFAJAXViewer::BUTTON_INFO] == TRUE) {
			$data .= "<div enabled='false' dojoType='dijit.form.Button' id='toolbar1.info'
				iconClass='dijitEditorIcon dijitEditorIconInfoDoc' showLabel='false' onclick=\"javascript:commun.parseInfo('" . PDFAJAXViewer::$INFOURL . "')\" ></div>";
		}
		
		$data .= "</div>";
		
		///images viweer
		$data .= "<center>
		<table style='overflow: scroll;'>
		<tr>
		<td valign='middle' align='center'>
		<div id='page' style='overflow: scroll;'>
		 <div>
			<img src='" . PDFAJAXViewer::generatePage ( 1, PDFAJAXViewer::$DEFAULT_RESOL ) . "'/>
		 </div>		
		</div>
		
		</td>
		</tr>
		</table>
		</center>";
		
		$data .= "</div></div>";
		
		///dialog info
		$data .= "<div id='infoDiag' dojoType='dijit.Dialog'
		title='Informations' style='display:none;width: 400px;'>
		<div class='dijitDialogPaneContentArea'>
				<table>
					<tr>
						<td><label for='pages'>Nombres de pages: </label></td>
						<td><span id='nbpageSpn' name='pages'></span></td>
					</tr>
					<tr>
						<td><label for='titre'>Titre</label></td>
						<td><span id='titleSpn' name='titre'></span></td>
					</tr>
					<tr>
						<td><label for='auteur'>Auteur</label></td>
						<td><span id='auteurSpn' name='auteur'></span></td>
					</tr>				
				</table>
			</div>		
		</div>";
		
		$data .= "</body></html>";
		
		return $data;
	}
	
	public static function includeDOJO() {
		echo " <head> " . " <!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01//EN' 'http://www.w3.org/TR/html4/strict.dtd'> <html> " . " <style type='text/css'> " . " @import '" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "/js/dojo/dijit/themes/claro/claro.css'; " . " @import '" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "/js/dojo/resources/dojo.css'; " . " html, body { height: 100%; width: 100%; padding: 0; border: 0; } " . " #main { height: 100%; width: 100%; border: 0; } " . " </style> " . " <link href='" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "/js/prototype/theme/default.css' rel='stylesheet' type='text/css'/> " . " <script type='text/javascript' src='" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "/js/dojo/dojo/dojo.js' djConfig='parseOnLoad: false'></script> " . " <script src='" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "/js/scroller/jquery-1.3.1.min.js' type='text/javascript'></script>" . " <script src='" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "/js/scroller/jquery.scrollview.js' type='text/javascript'></script>" . " <link rel='stylesheet' type='text/css' href='" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "/js/scroller/style.css'/>" . " <script type='text/javascript'> " . " dojo.require('dijit.dijit'); " . " dojo.require('dojo.parser'); " . " dojo.require('dijit.Tree'); " . " dojo.require('dojo.data.ItemFileReadStore'); " . " dojo.require('dijit.tree.ForestStoreModel'); " . " dojo.require('dijit.layout.AccordionContainer');" . " dojo.require('dijit.layout.ContentPane'); " . " dojo.require('dijit.layout.BorderContainer'); " . " dojo.require('dijit.Menu'); " . " dojo.require('dijit.Tooltip'); " . " dojo.require('dijit.Tree'); " . " dojo.require('dijit.form.TextBox'); " . " dojo.require('dijit.form.Button'); " . " dojo.require('dijit.form.NumberSpinner'); " . " dojo.require('dijit.form.ValidationTextBox'); " . " dojo.require('dijit.layout.AccordionContainer'); " . " dojo.require('dijit.layout.ContentPane'); " . " dojo.require('dijit.layout.BorderContainer'); " . " dojo.require('dijit.Dialog'); " . " dojo.require('dijit.Declaration'); " . " dojo.require('dijit.Toolbar'); " . " dojo.require('dijit.ToolbarSeparator'); " . " dojo.require('dojo.parser'); " . " dojo.require('dojo.date.locale'); " . " dojo.require('dojo.data.ItemFileReadStore'); " . " dojo.registerModulePath('bedreamy', '../../bedreamy'); " . " dojo.require('bedreamy.integration.Commun'); " . " var commun = new bedreamy.integration.Commun(); " . " </script> " . " <style type='text/css'> " . " #header { margin: 0px;	} " . " #topTabs { margin: 0px; } " . " #leftAccordion { width: 25%; } " . " #bottomTabs { height: 20%; } " . " #loader {
				padding: 0;
				margin: 0;
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background: #ededed;
				z-index: 999;
				vertical-align: middle;
				-moz-opacity: 1.0;
				opacity: 1.0;
				filter: alpha(opacity = 100;
			 }
			
			 #loaderInner {
				padding: 5px;
				position: relative;
				left: 0;
				top: 0;
				width: 175px;
				background: #3c3;
				color: #fff;
			 }
			
			 hr.spacer {
				border: 0;
				background-color: #ededed;
				width: 80%;
				height: 1px;
			 }		
			 </style> " . " <script type='text/javascript'>" . 

		" dojo.addOnLoad(function() {" . 

		" $('#page').scrollview({" . "grab:'" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "/js/scroller/images/openhand.cur'," . "grabbing:'" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "/js/scroller/images/closedhand.cur'" . " });" . 

		" dojo.parser.parse(dojo.byId('container'));" . 

		" setTimeout(function hideLoader(){
				var loader = dojo.byId('loader');
				dojo.fadeOut({ node: loader, duration:500,
					onEnd: function(){
						loader.style.display = 'none';
					}
				}).play();
			 }, 250);
			
			

			 dojo.connect(dijit.byId('numPage'), 'onKeyPress', function(event){
	            if(event.keyCode==13){
		            commun.keydownPage('" . ResourceBundle::get ( 'pdfviewer.relatif.path.base' ) . "/copix/bedreamy/action/action.class.php','" . ResourceBundle::get ( 'pdfviewer.path.assets' ) . "'," . PDFAJAXViewer::getNbPages () . ");
	            }
	         });
				
			 dojo.byId('pageContent').style.overflow =  'hidden';
		  });		
		</script> " . "</head> ";
	}
	
	public static function getBookmarkJSON($pdfURL) {
		$_SESSION [PDFAJAXViewer::SESSION_DOCUMENT] = $pdfURL;
		$classpath = ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/pdfhandler.jar;";
		$classpath .= ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/commons-logging.jar;";
		$classpath .= ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/commons-logging-1.0.4.jar;";
		$classpath .= ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/fontbox-1.1.0.jar;";
		$classpath .= ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/jempbox-1.1.0.jar;";
		$classpath .= ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/json_simple-1.1.jar;";
		$classpath .= ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/log4j-1.2.15.jar;";
		$classpath .= ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/lucene-core-3.0.2.jar;";
		$classpath .= ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/pdfbox-1.1.0.jar";
		
		if (file_exists ( $pdfURL )) {
			$cacheDirectory = ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/cache/" . PDFAJAXViewer::getForlderName ( $pdfURL );
			$jsonFile = $cacheDirectory . "/" . PDFAJAXViewer::BOOKMARKFILE;
			$jsonInfoFile = $cacheDirectory . "/" . PDFAJAXViewer::INFORMATIONFILE;
			PDFAJAXViewer::$INFOURL = ResourceBundle::get ( 'pdfviewer.relatif.path.base' ) . "/cache/" . PDFAJAXViewer::getForlderName ( $pdfURL ) . "/" . PDFAJAXViewer::INFORMATIONFILE . ".json";
			PDFAJAXViewer::$BOOKMARKURL = ResourceBundle::get ( 'pdfviewer.relatif.path.base' ) . "/cache/" . PDFAJAXViewer::getForlderName ( $pdfURL ) . "/" . PDFAJAXViewer::BOOKMARKFILE;
			PDFAJAXViewer::$INFOBASEURLJSON = ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/cache/" . PDFAJAXViewer::getForlderName ( $pdfURL ) . "/" . PDFAJAXViewer::INFORMATIONFILE . ".json";
			PDFAJAXViewer::$INFOBASEURLXML = ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/cache/" . PDFAJAXViewer::getForlderName ( $pdfURL ) . "/" . PDFAJAXViewer::INFORMATIONFILE . ".xml";
			if (file_exists ( $cacheDirectory )) {
				if (! file_exists ( $jsonFile ) || ! file_exists ( $jsonInfoFile )) {
					exec ( "java -classpath $classpath com.bedreamy.base.PDFGetBookmarks \"$pdfURL\" -destination $jsonFile -destinationInfo $jsonInfoFile" );
				}
			} else {
				mkdir ( $cacheDirectory, 0777 );
				exec ( "java -classpath $classpath com.bedreamy.base.PDFGetBookmarks \"$pdfURL\" -destination $jsonFile -destinationInfo $jsonInfoFile" );
			}
			PDFAJAXViewer::getNbPages ();
		} else {
			throw new Exception ( FILENOTFOUND );
		}
	
	}
	
	public static function generatePage($page, $resolution) {
		$_SESSION [PDFAJAXViewer::SESSION_PAGE] = $page;
		$_SESSION [PDFAJAXViewer::SESSION_RESOLUTION] = $resolution;
		
		$classpath = ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/pdfhandler.jar;";
		$classpath .= ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/commons-logging.jar;";
		$classpath .= ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/commons-logging-1.0.4.jar;";
		$classpath .= ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/fontbox-1.1.0.jar;";
		$classpath .= ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/jempbox-1.1.0.jar;";
		$classpath .= ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/json_simple-1.1.jar;";
		$classpath .= ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/log4j-1.2.15.jar;";
		$classpath .= ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/lucene-core-3.0.2.jar;";
		$classpath .= ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/bin/jar/pdfbox-1.1.0.jar";
		
		$pagerel = ResourceBundle::get ( 'pdfviewer.relatif.path.base' ) . "/cache/" . PDFAJAXViewer::getForlderName ( $_SESSION [PDFAJAXViewer::SESSION_DOCUMENT] ) . "/" . PDFAJAXViewer::getForlderName ( $_SESSION [PDFAJAXViewer::SESSION_DOCUMENT] ) . $resolution;
		$pageabs = ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/cache/" . PDFAJAXViewer::getForlderName ( $_SESSION [PDFAJAXViewer::SESSION_DOCUMENT] ) . "/" . PDFAJAXViewer::getForlderName ( $_SESSION [PDFAJAXViewer::SESSION_DOCUMENT] ) . $resolution;
		PDFAJAXViewer::$CURRENTPAGE = $pagerel;
		$cacheDirectory = ResourceBundle::get ( 'pdfviewer.absolute.path.base' ) . "/cache/" . PDFAJAXViewer::getForlderName ( $_SESSION [PDFAJAXViewer::SESSION_DOCUMENT] );
		if (! file_exists ( $cacheDirectory )) {
			mkdir ( $cacheDirectory, 0777 );
		}
		if (! file_exists ( $pageabs . $page . ".png" )) {
			exec ( "java -classpath $classpath com.bedreamy.base.PDFToImage \"" . $_SESSION [PDFAJAXViewer::SESSION_DOCUMENT] . "\" -imageType png  -startPage $page -endPage $page -resolution $resolution -outputPrefix $pageabs" );
		}
		return $pagerel . $page . ".png";
	}
	
	public static function getPDFNameFromURL($pdfURL) {
		return basename ( $pdfURL );
	}
	
	public static function getForlderName($pdfURL) {
		return sha1 ( $pdfURL );
	}
	
	public static function execIsEnabled() {
		$disabled = explode ( ', ', ini_get ( 'disable_functions' ) );
		return ! in_array ( 'exec', $disabled );
	}
	
	public static function getNbPages() {
		
		$xml = simplexml_load_file ( PDFAJAXViewer::$INFOBASEURLXML );
		foreach ( $xml as $nom => $elem ) {
			if ($nom = "page") {
				PDFAJAXViewer::$NBPAGES = $elem;
				return $elem;
			}
		}
	}
	
	public static function isSigned() {
		$xml = simplexml_load_file ( PDFAJAXViewer::$INFOBASEURLXML );
		foreach ( $xml as $nom => $elem ) {
			if ($nom == "issigned") {
				PDFAJAXViewer::$ISSIGNED = $elem;
				return $elem;
			}
		}
		return "";
	}
	
	static $params = array ();
	public static function buttonToActivate($paramsIN) {
		PDFAJAXViewer::$params = $paramsIN;
		$_SESSION [PDFAJAXViewer::SESSION_PARAMS] = $paramsIN;
	}
	
	public static function curPageURL() {
		$pageURL = 'http';
		if (isset ( $_SERVER ["HTTPS"] ) && $_SERVER ["HTTPS"] == "on") {
			$pageURL .= "s";
		}
		$pageURL .= "://";
		if ($_SERVER ["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER ["SERVER_NAME"] . ":" . $_SERVER ["SERVER_PORT"] . $_SERVER ["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER ["SERVER_NAME"] . $_SERVER ["REQUEST_URI"];
		}
		return $pageURL;
	}
}
?>