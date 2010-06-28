
<head>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<?php
require_once dirname(__FILE__).'/../copix/copix.inc.php';


//echo CopixI18N::get('copix:copix.yes','fr');
PDFAJAXViewer::includeDOJO();

?>

<style type="text/css">
#header {
	margin: 0px;
}

#topTabs {
	margin: 0px;
}

#leftAccordion {
	width: 25%;
}

#bottomTabs {
	height: 20%;
}

/* pre-loader specific stuff to prevent unsightly flash of unstyled content */
#loader {
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
	-moz-opacity: 0.8;
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


</style>


<script type="text/javascript"> // dojo.requires()

		dojo.require("dijit.Menu");
		dojo.require("dijit.MenuItem");
		dojo.require("dijit.PopupMenuItem");

		dojo.require("dijit.Calendar");
		dojo.require("dijit.ColorPalette");
		dojo.require("dijit.ProgressBar");
		dojo.require("dijit.TitlePane");
		dojo.require("dijit.Tooltip");
		dojo.require("dijit.Tree");

		dojo.require("dijit.MenuBar");
		dojo.require("dijit.MenuBarItem");
		dojo.require("dijit.PopupMenuBarItem");

		// editor:
		dojo.require("dijit.Editor");
		dojo.require("dijit._editor.plugins.FontChoice");
		dojo.require("dijit._editor.plugins.LinkDialog");

		// dnd:
		dojo.require("dojo.dnd.Source");

		// various Form elements
		dojo.require("dijit.form.CheckBox");
		dojo.require("dijit.form.Textarea");
		dojo.require("dijit.form.SimpleTextarea");
		dojo.require("dijit.form.FilteringSelect");
		dojo.require("dijit.form.TextBox");
		dojo.require("dijit.form.DateTextBox");
		dojo.require("dijit.form.TimeTextBox");
		dojo.require("dijit.form.CurrencyTextBox");
		dojo.require("dijit.form.Button");
		dojo.require("dijit.InlineEditBox");
		dojo.require("dijit.form.NumberSpinner");

		dojo.require("dijit.form.VerticalSlider");
		dojo.require("dijit.form.VerticalRuleLabels");
		dojo.require("dijit.form.VerticalRule");
		dojo.require("dijit.form.HorizontalSlider");
		dojo.require("dijit.form.HorizontalRuleLabels");
		dojo.require("dijit.form.HorizontalRule");

		// layouts used in page
		dojo.require("dijit.layout.AccordionContainer");
		dojo.require("dijit.layout.ContentPane");
		dojo.require("dijit.layout.TabContainer");
		dojo.require("dijit.layout.BorderContainer");
		dojo.require("dijit.layout.LinkPane");
		dojo.require("dijit.Dialog");

		dojo.require("dijit.Declaration");		
		dojo.require("dijit.Toolbar");
		dojo.require("dijit.ToolbarSeparator");
		
		// scan page for widgets and instantiate them
		dojo.require("dojo.parser");

		// humm?
		dojo.require("dojo.date.locale");

		// for the Tree
		dojo.require("dojo.data.ItemFileReadStore");

		// for the colorpalette
		function setColor(color){
			var theSpan = dojo.byId("outputSpan");
			dojo.style(theSpan,"color",color);
			theSpan.innerHTML = color;
		}

		// for the calendar
		function myHandler(id,newValue){
			console.debug("onChange for id = " + id + ", value: " + newValue);
		}

		// current setting (if there is one) to override theme default padding on TextBox based widgets
		currentInputPadding = "";

		function setTextBoxPadding(){
			// summary:
			//		Handler for when a MenuItem is clicked to set non-default padding for
			//		TextBox widgets

			// Effectively ignore clicks on the  currently checked MenuItem
			if(!this.get("checked")){
				this.set("checked", true);
			}

			// val will be "theme default", "0px", "1px", ..., "5px"
			var val = this.get("label");
			
			// Set class on body to get requested padding, and remove any previously set class
			if(currentInputPadding){
				dojo.removeClass(dojo.body(), currentInputPadding);
				currentInputPadding = "";
			}
			if(val != "theme default"){
				currentInputPadding = "inputPadding" + val.replace("px", "");
				dojo.addClass(dojo.body(), currentInputPadding);
			}

			// Clear previously checked MenuItem (radio-button effect).
			dojo.forEach(this.getParent().getChildren(), function(mi){
				if(mi != this){
					mi.set("checked", false);
				}
			}, this);
		}

		dojo.addOnLoad(function() {

						
			var start = new Date().getTime();
			dojo.parser.parse(dojo.byId('container'));
			console.info("Total parse time: " + (new Date().getTime() - start) + "ms");

			//dojo.byId('loaderInner').innerHTML += " done.";
			setTimeout(function hideLoader(){
				var loader = dojo.byId('loader');
				dojo.fadeOut({ node: loader, duration:500,
					onEnd: function(){
						loader.style.display = "none";
					}
				}).play();
			}, 250);
			
			logStrayGlobals();

			// Fill in menu/links to get to other themes.		
			// availableThemes[] is just a list of 'official' dijit themes, you can use ?theme=String
			// for 'un-supported' themes, too. (eg: yours)
			var availableThemes = [
				{ theme:"claro", author:"Dojo", baseUri:"../themes/" },
				{ theme:"tundra", author:"Dojo", baseUri:"../themes/" },
				{ theme:"soria", author:"nikolai", baseUri:"../themes/" },
				{ theme:"nihilo", author:"nikolai", baseUri:"../themes/" }
			];

			var tmpString='';
			dojo.forEach(availableThemes,function(theme){
				tmpString += 
					'<a href="?theme='+theme.theme+'">'+theme.theme+'</'+'a> (' +
					'<a href="?theme='+theme.theme+'&dir=rtl">RTL</'+'a> ' +
					'<a href="?theme='+theme.theme+'&a11y=true">high-contrast</'+'a> ' +
					'<a href="?theme='+theme.theme+'&dir=rtl&a11y=true">RTL+high-contrast</'+'a> )' +
					' - by: '+theme.author+' <br>';
				
			});
			
		});

		function logStrayGlobals(){
			// summary:
			//		Print all the global variables that we've created [by mistake] inside of dojo
			var strayGlobals = [];
			for(var i in window){
				//if(!window.__globalList[i]){ strayGlobals.push(i); }
			}
			if(strayGlobals.length){
				console.warn("Stray globals: "+strayGlobals.join(", "));
			}
		}

		function logWidgets(){
			// summary:
			//		Print all the widgets to console
			console.log("Widgets in registry:");
			dijit.registry.forEach(function(w){
				console.log(w);
			});
		}

		function tearDown(){
			// summary:
			//		Destroy all widgets, top down, and then check for any orphaned widgets
			dijit._destroyAll();
			logWidgets();
		}

		dojo.addOnLoad(function(){
			// It's the server's responsibility to localize the date displayed in the (non-edit) version of an InlineEditBox,
			// but since we don't have a server we'll hack it in the client
			

			
		});

		/***
		dojo.addOnLoad(function(){
			// use "before advice" to print log message each time resize is called on a layout widget
			var origResize = dijit.layout._LayoutWidget.prototype.resize;
			dijit.layout._LayoutWidget.prototype.resize = function(mb){
				console.log(this + ": resize({w:"+ mb.w + ", h:" + mb.h + "})");
				origResize.apply(this, arguments);
			};

			// content pane has no children so just use dojo's builtin after advice
			dojo.connect(dijit.layout.ContentPane.prototype, "resize", function(mb){
				console.log(this + ": resize({w:"+ mb.w + ", h:" + mb.h + "})");
			});
		});
		***/
	</script>
</head>
<body class="claro">
<!-- basic preloader: -->
<div id="loader"><!-- <div id="loaderInner" style="direction: ltr;">Loading theme Tester ...</div>  -->
<table width="100%" height="100%">
	<tr>
		<td valign="middle" align="center"><img
			src="<?php echo ResourceBundle::get('pdfviewer.path.assets') ?>/images/preloader.gif" /></td>
	</tr>
</table>
</div>

<!-- data for tree and combobox -->
<div dojoType="dojo.data.ItemFileReadStore" jsId="continentStore"
	url="countries.json"></div>
<div dojoType="dijit.tree.ForestStoreModel" jsId="continentModel"
	store="continentStore" query="{type:'chapter'}"
	rootId="chapterRoot" rootLabel="Chapters" childrenAttrs="children"></div>
<div dojoType="dojo.data.ItemFileReadStore" jsId="stateStore"
	url="states.json"></div>




<div id="main" dojoType="dijit.layout.BorderContainer"
	liveSplitters="false" design="sidebar">





<div dojoType="dijit.layout.AccordionContainer" minSize="20"
	style="width: 300px;" id="leftAccordion" region="leading"
	splitter="true">



<div dojoType="dijit.layout.ContentPane" title="Sommaire"><!-- tree widget -->
<div dojoType="dijit.Tree" id="tree2" model="continentModel"
	showRoot="false" openOnClick="true"
	onLoad="console.log('loaded tree2 (second tree)');">
	<script
			type="dojo/method" event="getIconClass" args="item, opened">
           return (item == this.model.root || continentStore.getValue(item, "type") == "chapter") ?
                   (opened ? "customFolderOpenedIcon" : "customFolderClosedIcon") :
                    "noteIcon";
	</script> 
	<script type="dojo/method" event="onClick" args="item">
			console.log("Execute of node " + this.model.getLabel(item)
				+", population=" + continentStore.getValue(item, "population"));
	</script>
</div>


</div>


</div>
<!-- end AccordionContainer -->


<div dojoType="dijit.layout.AccordionContainer" minSize="20"
	region="center" id="topTabs">



<div style="padding: 0;" dojoType="dijit.layout.ContentPane"
	title="Titre"><span dojoType="dijit.Declaration"
	widgetClass="ToolbarSectionStart" defaults="{ label: 'Label'}"> <span
	dojoType="dijit.ToolbarSeparator"></span><i>${label}:</i> </span>

<div id="toolbar1" dojoType="dijit.Toolbar">	
	<div dojoType="dijit.form.Button" id="toolbar1.cut"
		iconClass="dijitEditorIcon dijitEditorIconRestaure" showLabel="false"></div>
	<div dojoType="dijit.form.Button" id="toolbar1.copy"
		iconClass="dijitEditorIcon dijitEditorIconFull" showLabel="false"></div>
	
	<div dojoType="dijit.form.Button" id="toolbar1.sepa"
		iconClass="dijitEditorIcon dijitEditorIconSepa" showLabel="false" disabled></div>	
	<div dojoType="dijit.form.Button" id="toolbar1.zoomout"
		iconClass="dijitEditorIcon dijitEditorIconZoomOut" showLabel="false"></div>
	<div dojoType="dijit.form.Button" id="toolbar1.zoomin"
		iconClass="dijitEditorIcon dijitEditorIconZoomIn" showLabel="false"></div>
		
	<button dojoType="dijit.form.DropDownButton" >
		<span id="zoomhtml">100%</span>
		<div dojoType="dijit.Menu" id="editMenu2" style="display: none;">
			<div dojoType="dijit.MenuItem"				
				onClick="console.debug('not actually cutting anything, just a test!')">
				100%
			</div>
			<div dojoType="dijit.MenuItem"				 
				onClick="console.debug('not actually copying anything, just a test!')">
				80%
			</div>
			<div dojoType="dijit.MenuItem"				 
				onClick="console.debug('not actually pasting anything, just a test!')">
				60%
			</div>
			<div dojoType="dijit.MenuItem"				 
				onClick="console.debug('not actually pasting anything, just a test!')">
				40%
			</div>
			<div dojoType="dijit.MenuItem"				 
				onClick="console.debug('not actually pasting anything, just a test!')">
				20%
			</div>
		</div>
	</button>
	
	<div dojoType="dijit.form.Button" id="toolbar1.sepa1"
		iconClass="dijitEditorIcon dijitEditorIconSepa" showLabel="false" disabled></div>	
	<div dojoType="dijit.form.Button" id="toolbar1.previous"
		iconClass="dijitEditorIcon dijitEditorIconPreviousPage" showLabel="false"></div>
	<input style="width: 30px;" dojoType=dijit.form.TextBox type="text" id="user" name="user" >
		
	<div dojoType="dijit.form.Button" id="toolbar1.next"
		iconClass="dijitEditorIcon dijitEditorIconNextPage" showLabel="false"></div>
		
	<div dojoType="dijit.form.Button" id="toolbar1.sepa2"
		iconClass="dijitEditorIcon dijitEditorIconSepa" showLabel="false" disabled></div>			
	<div dojoType="dijit.form.Button" id="toolbar1.print"
		iconClass="dijitEditorIcon dijitEditorIconPrintPage" showLabel="false"></div>		
	<div dojoType="dijit.form.Button" id="toolbar1.search"
		iconClass="dijitEditorIcon dijitEditorIconFindMot" showLabel="false"></div>
	<div id="isSignedDiv" enabled="false" dojoType="dijit.form.Button" id="toolbar1.issigned"
		iconClass="dijitEditorIcon dijitEditorIconPdfIsSigned" showLabel="false" disabled></div>
	<span position="below" dojoType="dijit.Tooltip" connectId="isSignedDiv" style="display:none;">
		Ce document est sign�
	</span>		
</div>


	
</div>





</div>


</body>
</html>