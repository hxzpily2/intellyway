
dojo.provide("car.integration.Commun");



dojo.declare("car.integration.Commun",[],{

	

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
                	
                dojo.fadeOut({
                    node: loader,
                    duration:500,
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
    },
    
    createUser : function(){
        if(dojo.byId('profil').value=='PROFIL_USER'){
            dojo.style(dojo.byId('errorNom'), 'opacity', .0);
            dojo.style(dojo.byId('errorNom'), 'display', 'none');
            dojo.style(dojo.byId('errorPrenom'), 'opacity', .0);
            dojo.style(dojo.byId('errorPrenom'), 'display', 'none');
            dojo.style(dojo.byId('errorLogin'), 'opacity', .0);
            dojo.style(dojo.byId('errorLogin'), 'display', 'none');
            dojo.style(dojo.byId('errorPassword'), 'opacity', .0);
            dojo.style(dojo.byId('errorPassword'), 'display', 'none');
            dojo.style(dojo.byId('errorConfpassword'), 'opacity', .0);
            dojo.style(dojo.byId('errorConfpassword'), 'display', 'none');
            dojo.style(dojo.byId('errorEmail'), 'opacity', .0);
            dojo.style(dojo.byId('errorEmail'), 'display', 'none');
            dojo.style(dojo.byId('errorTel'), 'opacity', .0);
            dojo.style(dojo.byId('errorTel'), 'display', 'none');
            dojo.style(dojo.byId('errorCondition'), 'opacity', .0);
            dojo.style(dojo.byId('errorCondition'), 'display', 'none');
	    	
            var nom = dojo.byId('nom').value;
            var prenom = dojo.byId('prenom').value;
            var login = dojo.byId('login').value;
            var password = dojo.byId('passwordd').value;
            var confpassword = dojo.byId('confpassword').value;
            var email = dojo.byId('email').value;
            var tel = dojo.byId('tel').value;
            var errors = false;
            if(nom==''){
                errors = true;
                this.runEffect("errorNom");
            }
            if(prenom==''){
                errors = true;
                this.runEffect("errorPrenom");
            }
            if(login==''){
                errors = true;
                this.runEffect("errorLogin");
            }
            if(password==''){
                errors = true;
                this.runEffect("errorPassword");
            }
            if(password!='' && password!=confpassword){
                errors = true;
                this.runEffect("errorConfpassword");
            }
            if(email=='' || !dojox.validate.isEmailAddress(email)){
                errors = true;
                this.runEffect("errorEmail");
            }
            if(tel=='' || !dojox.validate.isNumberFormat(tel,{
                format : "0#########"
            })){
                errors = true;
                this.runEffect("errorTel");
            }
            if(dojo.byId('condition').checked==false){
                errors = true;
                this.runEffect("errorCondition");
            }
	    	
            if(errors == false){
                dojo.style(dojo.byId('errorNom'), 'opacity', .0);
                dojo.style(dojo.byId('errorNom'), 'display', 'none');
                dojo.style(dojo.byId('errorPrenom'), 'opacity', .0);
                dojo.style(dojo.byId('errorPrenom'), 'display', 'none');
                dojo.style(dojo.byId('errorLogin'), 'opacity', .0);
                dojo.style(dojo.byId('errorLogin'), 'display', 'none');
                dojo.style(dojo.byId('errorPassword'), 'opacity', .0);
                dojo.style(dojo.byId('errorPassword'), 'display', 'none');
                dojo.style(dojo.byId('errorConfpassword'), 'opacity', .0);
                dojo.style(dojo.byId('errorConfpassword'), 'display', 'none');
                dojo.style(dojo.byId('errorEmail'), 'opacity', .0);
                dojo.style(dojo.byId('errorEmail'), 'display', 'none');
                dojo.style(dojo.byId('errorTel'), 'opacity', .0);
                dojo.style(dojo.byId('errorTel'), 'display', 'none');
                dojo.style(dojo.byId('errorCondition'), 'opacity', .0);
                dojo.style(dojo.byId('errorCondition'), 'display', 'none');
	  		  	
                dojo.style(dojo.byId('loader'), 'display', '');
                dojo.xhrPost ({
                    url: "/car/web/auto.php/userform/save?profil=PROFIL_USER&nom="+nom+"&prenom="+prenom+"&login="+login+"&password="+password+"&email="+email+"&tel="+tel,
                    handleAs: "text",
                    preventCache:true,
                    load: dojo.hitch(this,function (response) {
                        dojo.style(dojo.byId('loader'), 'display', 'none');
                    }
                    ),
                    error: function (data) {
                        console.error('Error: chargement services', data);
                    }
                });
            }
        }
    },
    
    runEffect : function (node) {   
        dojo.style(dojo.byId(node), 'display', '');
        var fadeOut = dojo.fadeOut({
            node: dojo.byId(node),
            duration: 1000
        });
        var fadeIn = dojo.fadeIn({
            node: dojo.byId(node),
            duration: 800
        });
        var currentAnimation;
        currentAnimation = dojo.fx.chain([fadeIn]);
        currentAnimation.play();
    	
    },

    callback : function() {
        setTimeout(function() {
            $( "#effect:visible" ).removeAttr( "style" ).fadeOut();
        }, 1000 );
    },

    showAccBlock : function () {
        dojo.style(dojo.byId("blockAcc"), 'display', '');
        dojo.style(dojo.byId("blockInfo"), 'display', 'none');
        dojo.style(dojo.byId("buttonsBlockInfo"), 'display', 'none');
        var $target = $('#autoDiv');
        $(document).stop().scrollTo( $target , 800 );
    },    
    showPhotosBlock : function () {
        dojo.style(dojo.byId("blockPhotos"), 'display', '');
        dojo.style(dojo.byId("blockAcc"), 'display', 'none');
        dojo.style(dojo.byId("buttonsBlockAcc"), 'display', 'none');
        var $target = $('#autoDiv');
        $(document).stop().scrollTo( $target , 800 );
    },
    hideAccBlock : function () {
        dojo.style(dojo.byId("blockAcc"), 'display', 'none');
        dojo.style(dojo.byId("blockInfo"), 'display', '');
        dojo.style(dojo.byId("buttonsBlockInfo"), 'display', '');
        var $target = $('#autoDiv');
        $(document).stop().scrollTo( $target , 800 );

    },
    hidePhotosBlock : function () {
        dojo.style(dojo.byId("blockPhotos"), 'display', 'none');
        dojo.style(dojo.byId("blockAcc"), 'display', '');
        dojo.style(dojo.byId("buttonsBlockAcc"), 'display', '');
        var $target = $('#autoDiv');
        $(document).stop().scrollTo( $target , 800 );
    },
    loadJsonAnnonceForm : function () {
        var ds = new Ext.data.Store({
            proxy: new Ext.data.HttpProxy({
                url: '/car/web/auto.php/json/marquesjson?active=true',
                method:'GET'
            }),
            reader: new Ext.data.JsonReader({
                root: 'marques',
                fields: [ {
                    name: 'id'
                },{
                    name: 'name'
                }]
            })
        });

        var combo = new Ext.form.ComboBox({
            store: ds,
            displayField: "name",
            valueField: "id",
            hiddenName: 'active_id',
            typeAhead: true,
            mode: 'local',
            forceSelection: true,
            triggerAction: 'all',
            emptyText:'Selectionner une marque...',
            selectOnFocus:true,
            width:200,
            applyTo: 'car_auto[idmarque]'
        });
    },
    showServicesBlock : function () {
        dojo.style(dojo.byId("blockServices"), 'display', '');
        dojo.style(dojo.byId("blockPhotos"), 'display', 'none');
        dojo.style(dojo.byId("buttonsBlockPhotos"), 'display', 'none');
        var $target = $('#autoDiv');
        $(document).stop().scrollTo( $target , 800 );
    },

    hideServicesBlock : function () {
        dojo.style(dojo.byId("blockPhotos"), 'display', '');
        dojo.style(dojo.byId("blockServices"), 'display', 'none');
        dojo.style(dojo.byId("buttonsBlockPhotos"), 'display', '');        
        var $target = $('#autoDiv');
        $(document).stop().scrollTo( $target , 800 );
    },

    delImageAuto:function(){
        alert('ok');
    },

    showLoader:function(id,div){
        dojo.style(dojo.byId(id), 'display', '');
        dojo.style(dojo.byId(div), 'display', 'none');
    },

    hideLoader:function(id,div){
        dojo.style(dojo.byId(id), 'display', 'none');
        dojo.style(dojo.byId(div), 'display', '');
    },

    showLogoMarque:function(id){
        dojo.xhrPost ({
            url: "/car/web/auto.php/json/logomarque?id="+id,
            handleAs: "text",
            preventCache:true,
                load: dojo.hitch(this,function (response) {
                    dojo.byId("imageMarque").src = response;
                }
            ),
            error: function (data) {
                console.error('Error: chargement services', data);
            }
        });
    },

    sendForm:function(idForm){           
            dojo.xhrPost({
              form: dojo.byId(idForm),              
              content: {
                  'idetat':dojo.byId("car_auto[idetat]").value,
                  'idtype':dojo.byId("car_auto[idtype]").value,
                  'idmoteur':dojo.byId("car_auto[idmoteur]").value,
                  'idboite':dojo.byId("car_auto[idboite]").value,
                  'kilometrage':Ext.getCmp('kilometragetxt').getValue(),
                  'anneeded':dojo.byId("car_auto[anneeded]").value,
                  'moisded':dojo.byId("car_auto[moisded]").value,
                  'anneecir':dojo.byId("car_auto[anneecir]").value,
                  'moiscir':dojo.byId("car_auto[moiscir]").value,
                  'prixstart':Ext.getCmp('prixstarttxt').getValue(),
                  'anneegarantie':Ext.getCmp('anneegarantiespin').getValue(),
                  'idmodele':dojo.byId("car_auto[idmodele]").value,
                  'idmarque':dojo.byId("car_auto[idmarque]").value,
                  'cylindres':Ext.getCmp('cylindrestxt').getValue(),
                  'pfiscale':dojo.byId("car_auto[pfiscale]").value,
                  'nbportes':dojo.byId("car_auto[nbportes]").value,
                  'idcouleur':dojo.byId("car_auto[idcouleur]").value,
                  
                  'idcarosserie':dojo.byId("carosserieId").value,
                  'etranger':dojo.byId("etrangerId").value,
                  'dedouane':dojo.byId("dedouaneId").value,
                  'garantie':dojo.byId("garantieId").value,
                  'reprise':dojo.byId("repriseId").value,
                  'hand':dojo.byId("handId").value,
                  'garaged':dojo.byId("garagedId").value,

                  'nbacc':dojo.byId('nbacc').value,
                  'acc[]' : dojo.query('input[name^="acc_"]:checked').attr('value')
              },
              handleAs: "text",
              load: function(data) {
                  //dojo.byId("response").innerHTML = "Form posted.";
              },
              error: function(error) {
                  //We'll 404 in the demo, but that's okay.  We don't have a 'postIt' service on the
                  //docs server.
                  //dojo.byId("response").innerHTML = "Form posted.";
              }
            });
    },

    showDedPanel:function(){
        if(dojo.byId('etrO').checked){
            dojo.style(dojo.byId('lineDed'), 'display', '');
            dojo.style(dojo.byId('blockDed'), 'display', '');
            dojo.style(dojo.byId('lineAnneeDed'), 'display', '');
            dojo.style(dojo.byId('blockAnneeDed'), 'display', '');
            this.runEffect('blockDed');
            this.runEffect('lineDed');
            this.runEffect('lineAnneeDed');
            this.runEffect('blockAnneeDed');
            
            dojo.byId('etrangerId').value=1;
        }else{
            dojo.style(dojo.byId('lineDed'), 'display', 'none');
            dojo.style(dojo.byId('blockDed'), 'display', 'none');
            dojo.style(dojo.byId('lineAnneeDed'), 'display', 'none');
            dojo.style(dojo.byId('blockAnneeDed'), 'display', 'none');

            dojo.style(dojo.byId('lineDed'), 'opacity', .0);
            dojo.style(dojo.byId('blockDed'), 'opacity', .0);
            dojo.style(dojo.byId('lineAnneeDed'), 'opacity', .0);
            dojo.style(dojo.byId('blockAnneeDed'), 'opacity', .0);

            dojo.byId('etrangerId').value=0;
        }
            
    },

    showGarPanel:function(){
        if(dojo.byId('garO').checked){
            dojo.style(dojo.byId('lineGarantie'), 'display', 'inline-block');
            dojo.style(dojo.byId('blockGarantie'), 'display', 'inline-block');
            
            this.runEffect('blockGarantie');
            this.runEffect('lineGarantie');
            
        }else{
            dojo.style(dojo.byId('lineGarantie'), 'display', 'none');
            dojo.style(dojo.byId('blockGarantie'), 'display', 'none');
            
            dojo.style(dojo.byId('lineGarantie'), 'opacity', .0);
            dojo.style(dojo.byId('blockGarantie'), 'opacity', .0);
        }

    },

    setCarosserie:function(value){
        dojo.byId('carosserieId').value=value;
    },

    getSlideShow:function(){
        dojo.xhrPost ({
            url: "/car/web/auto.php/commun/slideshow",
            handleAs: "text",
            preventCache:true,
                load: dojo.hitch(this,function (response) {                    
                    dojo.byId("slideshow").innerHTML = response;
                    $("a.fancyauto").fancybox();
                }
            ),
            error: function (data) {
                console.error('Error: chargement services', data);
            }
        });
    },

    delPhotosAnnonce:function(){
        dojo.xhrPost ({
            url: "/car/web/auto.php/commun/slideshow",
            handleAs: "text",
            preventCache:true,
                load: dojo.hitch(this,function (response) {
                    dojo.byId("slideshow").innerHTML = response;
                    $("a.fancyauto").fancybox();
                }
            ),
            error: function (data) {
                console.error('Error: chargement services', data);
            }
        });
    }

});