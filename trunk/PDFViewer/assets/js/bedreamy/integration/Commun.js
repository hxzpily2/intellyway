
dojo.provide("bedreamy.integration.Commun");

dojo.declare("bedreamy.integration.Commun",[],{

	
    addProfil : function  ()
    {
        
		
        if(test==true){
            dojo.xhrPost ({
                url: "/gojoob-app/web/frontend_dev.php/cvform/addprofil?nom="+nom+"&prenom="+prenom+"&email="+email+"&adresse="+adresse+"&ville="+ville+"&pays="+pays+"&tel="+tel+"&zip="+zip,
                handleAs: "text",
                preventCache:true,
                load: dojo.hitch(this,function (response) {
                    dojo.byId('profilForm').style.display = 'none';
                    dojo.byId('spanNom').innerHTML = dojo.byId('nom').value+' '+dojo.byId('prenom').value;
                    dojo.byId('spanMail').innerHTML = dojo.byId('mail').value;
                    dojo.byId('spanPays').innerHTML = dojo.byId('pays').options[dojo.byId('pays').selectedIndex].text;
                    window.location.reload(true);
                }
                ),
                error: function (data) {
                    console.error('Error: chargement services', data);
                }
            });
        }
    },
	
    inscription : function (){
        
        if(test!=false && dojo.byId('agreeCondition').checked == true){
            dojo.byId('agreeSpan').className = 'accept';
            dojo.byId('loaderInsc').style.display = 'block';
            dojo.byId("form_inscription").style.display = 'none';
            dojo.xhrPost ({
                url: "/gojoob-app/web/frontend_dev.php/candidat/inscription?nom="+nom+"&prenom="+prenom+"&email="+email+"&adresse="+adresse+"&ville="+ville+"&pays="+pays+"&tel="+tel+"&zip="+zip+"&pass="+password+"&defaultimage="+defaultimage+"&datenais="+datenais+"&cvcandidat="+cvcandidat,
                handleAs: "text",
                preventCache:true,
                load: dojo.hitch(this,function (response) {
                    dojo.byId("succes").innerHTML = response;
                    dojo.byId('form_inscription').style.display = 'none';
                    dojo.byId('loaderInsc').style.display = 'none';
                    dojo.byId("succes").style.display = 'block';
                }
                ),
                error: function (data) {
                    console.error('Error: chargement services', data);
                }
            });
        }
		
    },
    
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
		
    }
 
});