
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
	                	dojo.byId('content').innerHTML = response;	   
	                	
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
    },
    
    sortOrPaginate : function (url){
    	dojo.byId('content').style.display="none";
    	dojo.byId('preloader').style.display="block";
    	dojo.xhrPost ({
            url: url,
            handleAs: "text",
            preventCache:true,
            	load: dojo.hitch(this,function (response) {
            		dojo.byId('content').innerHTML = response;  
            		dojo.byId('content').style.display="block";
                	dojo.byId('preloader').style.display="none";
            	}
            ),
            error: function (data) {
                console.error('Error: chargement services', data);
            }
        });
    },
    
    searchCompte : function (){
    	var nom = dojo.byId('search_nom').value;
    	var prenom = dojo.byId('search_prenom').value;
    	var numero_compte = dojo.byId('search_numcpt').value;
    	var login = dojo.byId('search_login').value;
    	
    	dojo.byId('content').style.display="none";
    	dojo.byId('preloader').style.display="";
    	dojo.xhrPost ({
            url: '/account/application/Home.do?reqCode=searchcompte'+'&nom='+nom+'&prenom='+prenom+'&num='+numero_compte+'&login='+login,
            handleAs: "text",
            preventCache:true,
            	load: dojo.hitch(this,function (response) {
            		dojo.byId('content').innerHTML = response;  
            		dojo.byId('content').style.display="block";
                	dojo.byId('preloader').style.display="none";
            	}
            ),
            error: function (data) {
                console.error('Error: chargement services', data);
            }
        });
    }
    
    
    
});