/*!
 * Ext JS Library 3.3.1
 * Copyright(c) 2006-2010 Sencha Inc.
 * licensing@sencha.com
 * http://www.sencha.com/license
 */
Ext.onReady(function(){
    Ext.QuickTips.init();


    var dsModele = new Ext.data.JsonStore({
            autoLoad: true,
            url: '/car/web/auto.php/json/modelejson?active=true',
            root: 'modeles',
            fields:['id', 'name']
    });

    var comboModele = new Ext.form.ComboBox({
        store : dsModele,
        displayField: "name",
        valueField: "id",
        hiddenName: 'car_auto[idmodele]',
        hiddenId: 'car_auto[idmodele]',
        id:"modeleId",
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'modèle...',
        selectOnFocus:true,
        width:135,
        applyTo: 'idmodele'
    });

    var ds = new Ext.data.JsonStore({
            autoLoad: true,
            url: '/car/web/auto.php/json/marquesjson?active=true',
            root: 'marques',
            fields:['id', 'name']
    });

    var comboMarque = new Ext.form.ComboBox({
        store: ds,
        displayField: "name",
        valueField: "id",
        id:"marqueId",
        hiddenName: 'car_auto[idmarque]',
        hiddenId: 'car_auto[idmarque]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'marque...',
        selectOnFocus:true,
        width:150,
        applyTo: 'idmarque'
    });

    comboMarque.on('select', function(){
        commun.showLoader("loaderModele","divModele");        
        comboModele.store.removeAll();
        comboModele.setDisabled(true);
        comboModele.setValue('');
        //reload region store and enable region
        var dsModeleNew = new Ext.data.JsonStore({
            autoLoad: true,
            listeners: {
		'load': function(){
                    commun.hideLoader("loaderModele","divModele");
                }
            },
            url: '/car/web/auto.php/json/modelejson?id='+comboMarque.getValue(),
            root: 'modeles',
            fields:['id', 'name']
        });
        comboModele.bindStore(dsModeleNew);
        comboModele.setDisabled(false);        
    });

    var dsMoteur = new Ext.data.JsonStore({
            autoLoad: true,
            url: '/car/web/auto.php/json/moteursjson?active=true',
            root: 'moteurs',
            fields:['id', 'name']
    });

    var comboMoteur = new Ext.form.ComboBox({
        store: dsMoteur,
        displayField: "name",
        valueField: "id",
        hiddenName: 'car_auto[idmoteur]',
        hiddenId: 'car_auto[idmoteur]',
        id:"moteurId",
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Motorisation...',
        selectOnFocus:true,
        width:150,
        applyTo: 'idmoteur'
    });

    var dsEtat = new Ext.data.JsonStore({
            autoLoad: true,
            url: '/car/web/auto.php/json/etatsjson?active=true',
            root: 'etats',
            fields:['id', 'name']
    });

    var comboEtat = new Ext.form.ComboBox({
        store: dsEtat,
        displayField: "name",
        valueField: "id",
        id:"etatId",
        hiddenName: 'car_auto[idetat]',
        hiddenId: 'car_auto[idetat]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Etat...',
        selectOnFocus:true,
        width:100,
        applyTo: 'idetat'
    });
    comboEtat.hide();
    
    var dsVilles = new Ext.data.JsonStore({
            autoLoad: true,
            url: '/car/web/auto.php/json/villejson?active=true&pays='+dojo.byId('paysID').value,
            root: 'villes',
            fields:['id', 'name']
    });

    var comboVilles = new Ext.form.ComboBox({
        store: dsVilles,
        displayField: "name",
        valueField: "id",
        id:"villeId",
        hiddenName: 'car_auto[idville]',
        hiddenId: 'car_auto[idville]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Ville...',
        selectOnFocus:true,
        width:135,
        applyTo: 'idville'
    });

    var storeKM = new Ext.data.ArrayStore({
        fields: ['id', 'name'],
        data : Ext.exampledata.km // from dataset.js
    });

    var spinnkmmin = new Ext.form.ComboBox({
        store: storeKM,
        displayField: "name",
        valueField: "id",
        id:"kmminID",
        hiddenName: 'car_auto[kmmin]',
        hiddenId: 'car_auto[kmmin]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Km Min',
        selectOnFocus:true,
        width:70,
        applyTo: 'kmmin'
    });
    spinnkmmin.hide();

    var spinnkmmax = new Ext.form.ComboBox({
        store: storeKM,
        displayField: "name",
        valueField: "id",
        id:"kmmaxID",
        hiddenName: 'car_auto[kmmax]',
        hiddenId: 'car_auto[kmmax]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Km Max',
        selectOnFocus:true,
        width:70,
        applyTo: 'kmmax'
    });
    spinnkmmax.hide();

    var storePriceMin = new Ext.data.ArrayStore({
        fields: ['id', 'name'],
        data : Ext.exampledata.pricemin // from dataset.js
    });

    var spinnprixmin = new Ext.form.ComboBox({
        store: storePriceMin,
        displayField: "name",
        valueField: "id",
        id:"prixminID",
        hiddenName: 'car_auto[prixmin]',
        hiddenId: 'car_auto[prixmin]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Prix min',
        selectOnFocus:true,
        width:120,
        applyTo: 'prixmin'
    });
    spinnprixmin.hide();

    var storePriceMax = new Ext.data.ArrayStore({
        fields: ['id', 'name'],
        data : Ext.exampledata.pricemax // from dataset.js
    });
    
    var spinnprixmax = new Ext.form.ComboBox({
        store: storePriceMax,
        displayField: "name",
        valueField: "id",
        id:"prixmaxID",
        hiddenName: 'car_auto[prixmax]',
        hiddenId: 'car_auto[prixmax]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Prix max',
        selectOnFocus:true,
        width:120,
        applyTo: 'prixmax'
    });
    spinnprixmax.hide();


    var dsAnneeDed = new Ext.data.JsonStore({
            autoLoad: true,
            url: '/car/web/auto.php/json/anneejson?active=true',
            root: 'annees',
            fields:['id', 'name']
    });


    var anneemin = new Ext.form.ComboBox({
        store: dsAnneeDed,
        displayField: "name",
        valueField: "id",
        id:"anneminID",
        hiddenName: 'car_auto[annemin]',
        hiddenId: 'car_auto[annemin]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Année Max',
        selectOnFocus:true,
        width:90,
        applyTo: 'annemin'
    });
    anneemin.hide();


    var anneemax = new Ext.form.ComboBox({
        store: dsAnneeDed,
        displayField: "name",
        valueField: "id",
        id:"annemaxID",
        hiddenName: 'car_auto[annemax]',
        hiddenId: 'car_auto[annemax]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Année Max',
        selectOnFocus:true,
        width:90,
        applyTo: 'annemax'
    });
    anneemax.hide();
    
});