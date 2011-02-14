var marqueTooltip;
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
        var $target = $('#autoDiv');
        $(document).stop().scrollTo( $target , 800 );
    },    
    showPhotosBlock : function () {
        dojo.style(dojo.byId("blockPhotos"), 'display', '');
        dojo.style(dojo.byId("blockAcc"), 'display', 'none');        
        var $target = $('#autoDiv');
        $(document).stop().scrollTo( $target , 800 );
    },
    hideAccBlock : function () {
        dojo.style(dojo.byId("blockAcc"), 'display', 'none');
        dojo.style(dojo.byId("blockInfo"), 'display', '');        
        var $target = $('#autoDiv');
        $(document).stop().scrollTo( $target , 800 );

    },
    hidePhotosBlock : function () {
        dojo.style(dojo.byId("blockPhotos"), 'display', 'none');
        dojo.style(dojo.byId("blockAcc"), 'display', '');        
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
        var $target = $('#autoDiv');
        $(document).stop().scrollTo( $target , 800 );
    },

    hideServicesBlock : function () {
        dojo.style(dojo.byId("blockPhotos"), 'display', '');
        dojo.style(dojo.byId("blockServices"), 'display', 'none');        
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

            dojo.style(dojo.byId('marqueError'), 'opacity', .0);
            dojo.style(dojo.byId('marqueError'), 'display', 'none');
            dojo.style(dojo.byId('modeleError'), 'opacity', .0);
            dojo.style(dojo.byId('modeleError'), 'display', 'none');
            dojo.style(dojo.byId('typeError'), 'opacity', .0);
            dojo.style(dojo.byId('typeError'), 'display', 'none');
            dojo.style(dojo.byId('etatError'), 'opacity', .0);
            dojo.style(dojo.byId('etatError'), 'display', 'none');
            dojo.style(dojo.byId('carosserieError'), 'opacity', .0);
            dojo.style(dojo.byId('carosserieError'), 'display', 'none');
            dojo.style(dojo.byId('moteurError'), 'opacity', .0);
            dojo.style(dojo.byId('moteurError'), 'display', 'none');
            dojo.style(dojo.byId('anneecirError'), 'opacity', .0);
            dojo.style(dojo.byId('anneecirError'), 'display', 'none');
            dojo.style(dojo.byId('boiteError'), 'opacity', .0);
            dojo.style(dojo.byId('boiteError'), 'display', 'none');
            dojo.style(dojo.byId('pfError'), 'opacity', .0);
            dojo.style(dojo.byId('pfError'), 'display', 'none');
            dojo.style(dojo.byId('cylError'), 'opacity', .0);
            dojo.style(dojo.byId('cylError'), 'display', 'none');
            dojo.style(dojo.byId('nbporteError'), 'opacity', .0);
            dojo.style(dojo.byId('nbporteError'), 'display', 'none');
            dojo.style(dojo.byId('couleurError'), 'opacity', .0);
            dojo.style(dojo.byId('couleurError'), 'display', 'none');
            dojo.style(dojo.byId('anneededError'), 'opacity', .0);
            dojo.style(dojo.byId('anneededError'), 'display', 'none');
            dojo.style(dojo.byId('dedError'), 'opacity', .0);
            dojo.style(dojo.byId('dedError'), 'display', 'none');

            dojo.style(dojo.byId("blockServices"), 'display', 'none');
            dojo.style(dojo.byId("blockPhotos"), 'display', 'none');
            dojo.style(dojo.byId("blockAcc"), 'display', 'none');
            dojo.style(dojo.byId("blockInfo"), 'display', '');
            var $target = $('#blockInfo');
            $(document).stop().scrollTo( $target , 200 );

            var test = false;

            var marque = Ext.getCmp('marqueId').getValue();
            var modele = Ext.getCmp('modeleId').getValue();
            var type = Ext.getCmp('typeId').getValue();
            var etat = Ext.getCmp('etatId').getValue();
            var carrosserie = dojo.byId('carosserieId').value;
            var moteur = Ext.getCmp('moteurId').getValue();
            var anneecir = Ext.getCmp('anneecirId').getValue();
            var boite = Ext.getCmp('boiteId').getValue();
            var pf = Ext.getCmp('pfiscaleId').getValue();
            var cylindres = Ext.getCmp('cylindrestxt').getValue();
            var nbportes = Ext.getCmp('nbportesId').getValue();
            var couleur = Ext.getCmp('couleurId').getValue();
            var anneeded = Ext.getCmp('anneededId').getValue();
            var ded = dojo.byId('dedouaneId').value;
            var etranger = dojo.byId('etrangerId').value;
            var urgent = dojo.byId('urgentId').checked?1:0;
            if(marque==""){
                this.runEffect("marqueError");
                test = true;
            }

            if(modele==""){
                this.runEffect("modeleError");
                test = true;
            }

            if(type==""){
                this.runEffect("typeError");
                test = true;
            }

            if(etat==""){
                this.runEffect("etatError");
                test = true;
            }

            if(carrosserie==""){
                this.runEffect("carosserieError");
                test = true;
            }

            if(moteur==""){
                this.runEffect("moteurError");
                test = true;
            }

            if(anneecir==""){
                this.runEffect("anneecirError");
                test = true;
            }

            if(boite==""){
                this.runEffect("boiteError");
                test = true;
            }

            if(pf==""){
                this.runEffect("pfError");
                test = true;
            }

            if(cylindres==""){
                this.runEffect("cylError");
                test = true;
            }


            if(nbportes==""){
                this.runEffect("nbporteError");
                test = true;
            }

            if(couleur==""){
                this.runEffect("couleurError");
                test = true;
            }
            
            if(etranger=="1"){                
                if(anneeded==""){
                    this.runEffect("anneededError");
                    test = true;
                }
                if(ded==""){
                    this.runEffect("dedError");
                    test = true;
                }
            }
            
            if(test){
                dojo.style(dojo.byId("buttonInfoTerminer"), 'display', '');
            }else{
                this.showLoaderJ();
                dojo.xhrPost({
                  form: dojo.byId(idForm),
                  content: {
                      'idetat':etat,
                      'idtype':type,
                      'idmoteur':moteur,
                      'idboite':boite,
                      'kilometrage':Ext.getCmp('kilometragetxt').getValue(),
                      'anneeded':anneeded,
                      'moisded':Ext.getCmp('moisdedId').getValue(),
                      'anneecir':anneecir,
                      'moiscir':Ext.getCmp('moiscirId').getValue(),
                      'prixstart':Ext.getCmp('prixstarttxt').getValue(),
                      'anneegarantie':Ext.getCmp('anneegarantiespin').getValue(),
                      'idmodele':modele,
                      'idmarque':marque,
                      'cylindres':cylindres,
                      'pfiscale':pf,
                      'nbportes':nbportes,
                      'idcouleur':couleur,

                      'idcarosserie':carrosserie,
                      'etranger':etranger,
                      'dedouane':dojo.byId("dedouaneId").value,
                      'garantie':dojo.byId("garantieId").value,
                      'reprise':dojo.byId("repriseId").value,
                      'hand':dojo.byId("handId").value,
                      'garaged':dojo.byId("garagedId").value,
                      'urgent':  urgent,
                      'nbacc':dojo.byId('nbacc').value,
                      'acc[]' : dojo.query('input[name^="acc_"]:checked').attr('value')
                  },
                  handleAs: "text",
                  load: function(data) {
                      dojo.byId("autoForm").innerHTML = data;
                      $.nyroModalRemove();
                      var $target = $('#autoDiv');
                      $(document).stop().scrollTo( $target , 200 );
                  },
                  error: function(error) {
                      //We'll 404 in the demo, but that's okay.  We don't have a 'postIt' service on the
                      //docs server.
                      //dojo.byId("response").innerHTML = "Form posted.";
                  }
                });
            }
            
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

    delPhotosAnnonce:function(image){
        dojo.xhrPost ({
            url: "/car/web/auto.php/commun/deluploadannonce",
            handleAs: "text",
            content: {'image':image},
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

    showLoaderJ:function(){        

        $.fn.nyroModalManual({
				bgColor: '#FFFFFF',
				content: dojo.byId("loader").innerHTML
			});
    }

});