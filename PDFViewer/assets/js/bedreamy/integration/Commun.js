
dojo.provide("bedreamy.integration.Commun");

dojo.declare("bedreamy.integration.Commun",[],{

	
    parseInfo : function (urlInfos){
        
        if(urlInfos!=""){
            
            dojo.xhrPost ({
                url: urlInfos,
                handleAs: "text",
                preventCache:true,
                load: dojo.hitch(this,function (response) {
                	var myObject = eval('(' + response + ')');
                	dojo.byId('nbpageSpn').innerHTML = myObject.items[0].pages;
                	if(myObject.items[0].titre!='null')
                		dojo.byId('titleSpn').innerHTML = myObject.items[0].titre;
                	else
                		dojo.byId('titleSpn').innerHTML = "";
                	if(myObject.items[0].auteur!='null')
                		dojo.byId('auteurSpn').innerHTML = myObject.items[0].auteur;
                	else
                		dojo.byId('auteurSpn').innerHTML = "";
                	dijit.byId('infoDiag').show();
                }
                ),
                error: function (data) {
                    console.error('Error: chargement services', data);
                }
            });
        }
		
    },
    
    getPage : function (url,page,resolution,assets){
    		dojo.style("loader", "opacity", 0.7);
	    	var loader = dojo.byId('loader');
	    	loader.style.display = "";
            dojo.xhrPost ({
                url: url+"?request=getpage&page="+page+"&resolution="+resolution,
                handleAs: "text",
                preventCache:true,
                load: dojo.hitch(this,function (response) {
                	dojo.byId('page').innerHTML = response;
                	dojo.byId('numPage').value=page;
                	$("#page").scrollview({
        			    grab:assets+"/js/scroller/images/openhand.cur",
        			    grabbing:assets+"/js/scroller/images/closedhand.cur"
        			});
                	
                	dojo.fadeOut({ node: loader, duration:500,
        				onEnd: function(){
        					loader.style.display = "none";
        				}
        			}).play();
                }
                ),
                error: function (data) {
                    console.error('Error: chargement services', data);
                }
            });        
		
    },
    
    nextPage : function (url,assets){
    	var page = parseInt(dojo.byId('numPage').value);
    	var resolution = parseInt(dojo.byId('zoom').value);
    	if(page+1<=parseInt(dojo.byId('maxPage').value)){
    		this.getPage(url, page+1, resolution,assets);
    	}	        	
    },
    
    previousPage : function (url,assets){   	
    	var page = parseInt(dojo.byId('numPage').value);
    	var resolution = parseInt(dojo.byId('zoom').value);
    	if(page-1>=1){
    		this.getPage(url, page-1, resolution,assets);    		
    	}
    },
    
    changeResolution : function (resolution,url,assets){
    	dojo.byId('zoom').value = resolution;
    	dijit.byId('zoomhtml').setLabel(resolution+"%");    	
    	var page = parseInt(dojo.byId('numPage').value);
    	var resolution = parseInt(dojo.byId('zoom').value);
    	this.getPage(url, page, resolution,assets);
    }   
    
 
});