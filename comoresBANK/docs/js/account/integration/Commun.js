
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
    },
    
    updatePassword : function (){
    	var passwordold = dojo.byId('passwordold').value;
    	var passwordnew = dojo.byId('passwordnew').value;
    	var passwordconf = dojo.byId('passwordconf').value;
    	
    	
    	dojo.byId('contentDialog').style.display="none";
    	dojo.byId('preloaderDialog').style.display="";
    	dojo.byId('errorContent').style.display="none";
    	dojo.xhrPost ({
            url: '/account/application/Home.do?reqCode=updatepass'+'&passwordold='+passwordold+'&passwordnew='+passwordnew+'&passwordconf='+passwordconf,
            handleAs: "text",
            preventCache:true,
            	load: dojo.hitch(this,function (response) {
            		dojo.byId('errorContent').innerHTML = response;  
            		dojo.byId('errorContent').style.display="block";
            		dojo.byId('contentDialog').style.display="block";
                	dojo.byId('preloaderDialog').style.display="none";
            	}
            ),
            error: function (data) {
                console.error('Error: chargement services', data);
            }
        });
    },
    
    writeUpdatePWD : function (number){
    	if(dijit.byId('radioOne').checked){
    		if(dojo.byId('passwordold').value.length<6)
    			dojo.byId('passwordold').value=dojo.byId('passwordold').value+String.fromCharCode(number+64);
    	}
    	else if(dijit.byId('radioTwo').checked){
    		if(dojo.byId('passwordnew').value.length<6)
    			dojo.byId('passwordnew').value=dojo.byId('passwordnew').value+String.fromCharCode(number+64);
    	}
    	else if(dijit.byId('radioTree').checked){
    		if(dojo.byId('passwordconf').value.length<6)
    			dojo.byId('passwordconf').value=dojo.byId('passwordconf').value+String.fromCharCode(number+64);
    	}
    	/*if(dojo.byId('password').value.length<6){
    		dojo.byId('j_password').value=dojo.byId('j_password').value+String.fromCharCode(number+64);
    		dojo.byId('password').value=dojo.byId('password').value+String.fromCharCode(number+64);
    	}*/
    },
    
    corrigerPass : function (){
    	if(dijit.byId('radioOne').checked){
    		dojo.byId('passwordold').value="";
    	}
    	else if(dijit.byId('radioTwo').checked){
    		dojo.byId('passwordnew').value="";
    	}
    	else if(dijit.byId('radioTree').checked){
    		dojo.byId('passwordconf').value="";
    	}    	
    },
    
    showDialogPassUpdate : function (){
    	dijit.byId('formDialog').show();
    	dojo.byId('passwordold').value = "";
    	dojo.byId('passwordnew').value = "";
    	dojo.byId('passwordconf').value = "";
    	dojo.byId('contentDialog').style.display="block";
    	dojo.byId('preloaderDialog').style.display="none";
    }
    
    
    
});