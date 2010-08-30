
dojo.provide("account.integration.Commun");

dojo.declare("account.integration.Commun",[],{

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
    
    writePWD : function (number){
    	if(dojo.byId('password').value.length<6){
    		dojo.byId('j_password').value=dojo.byId('j_password').value+String.fromCharCode(number+64);
    		dojo.byId('password').value=dojo.byId('password').value+String.fromCharCode(number+64);
    	}
    },
    
    corPWD : function (){
    	dojo.byId('j_password').value= "";
    	dojo.byId('password').value= "";
    }
    
});