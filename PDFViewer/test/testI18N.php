<html>
<body class="claro">
<?php
require_once dirname(__FILE__).'/../copix/copix.inc.php';


//echo CopixI18N::get('copix:copix.yes','fr');
PDFAJAXViewer::includeDOJO();

;
?>
<div dojoType="dojo.data.ItemFileReadStore" jsId="continentStore"
	url="countries.json"></div>
<div dojoType="dijit.tree.ForestStoreModel" jsId="continentModel"
	store="continentStore" query="{type:'continent'}"
	rootId="continentRoot" rootLabel="Continents" childrenAttrs="children"></div>

	


<div dojoType="dijit.layout.AccordionContainer"
			minSize="20" style="width: 300px;" id="leftAccordion" region="leading" splitter="true">
		<div dojoType="dijit.layout.ContentPane" title="Popups and Alerts">
		
				<div id="main" dojoType="dijit.Tree" id="tree2" model="continentModel"
					showRoot="false" openOnClick="true"
					onLoad="console.log('loaded tree2 (second tree)');">
					<script
					type="dojo/method" event="getIconClass" args="item, opened">
           return (item == this.model.root || continentStore.getValue(item, "type") == "continent") ?
                   (opened ? "customFolderOpenedIcon" : "customFolderClosedIcon") :
                    "noteIcon";
		</script> <script type="dojo/method" event="onClick" args="item">
			console.log("Execute of node " + this.model.getLabel(item)
				+", population=" + continentStore.getValue(item, "population"));
		</script>
				</div>

	</div>	
</div>




</body>
</html>
