<?php
class PDFAJAXViewer{
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
		     " <script type='text/javascript' src='".ResourceBundle::get('pdfviewer.path.assets')."/js/prototype/prototype.js'></script> ".
		     " <script type='text/javascript' src='".ResourceBundle::get('pdfviewer.path.assets')."/js/prototype/window.js'></script> ".
			 " <script type='text/javascript' src='".ResourceBundle::get('pdfviewer.path.assets')."/js/dojo/dojo/dojo.js' djConfig='parseOnLoad: false'></script> ".
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
}
?>