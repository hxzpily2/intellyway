
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
    },
    
    keydownPage : function (url,assets,maxPage){
    	try{
    		var resolution = parseInt(dojo.byId('zoom').value);
    		var page = parseInt(dojo.byId('numPage').value);
    		
    		if(!isNaN(parseInt(dojo.byId('numPage').value)))
    			this.getPage(url, page, resolution,assets);
    	}catch(err){
    		
    	}    		
    },   
    
    zoomIn : function (url,assets){
    	var resolution = parseInt(dojo.byId('zoom').value);    	
    	if(resolution<100){
    		resolution+=20;
    		dojo.byId('zoom').value = resolution;
        	dijit.byId('zoomhtml').setLabel(resolution+"%");    	
        	var page = parseInt(dojo.byId('numPage').value);    	
        	this.getPage(url, page, resolution,assets);
    	}	
    	
    },	
 
    zoomOut : function (url,assets){
    	var resolution = parseInt(dojo.byId('zoom').value);
    	if(resolution>20){
    		resolution-=20;
    		dojo.byId('zoom').value = resolution;
        	dijit.byId('zoomhtml').setLabel(resolution+"%");    	
        	var page = parseInt(dojo.byId('numPage').value);    	
        	this.getPage(url, page, resolution,assets);
    	}	
    	
    },
    
    fullScreen : function (url){ 
    	/*dojo.byId("containerBookmark").style.display = "none";
    	dojo.byId("containerPage").style.width="100%";
    	dijit.byId("containerPage").resize();*/
    	window.open(url, '', 'fullscreen=yes, scrollbars=auto');


    },
    
    restoreScreen : function(){
    	if(dojo.byId("mode").value=="fullscreen"){
    		window.close();
    	}    
    }	
});