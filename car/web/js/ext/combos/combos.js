/*!
 * Ext JS Library 3.3.1
 * Copyright(c) 2006-2010 Sencha Inc.
 * licensing@sencha.com
 * http://www.sencha.com/license
 */
Ext.onReady(function(){
    Ext.QuickTips.init();

    // simple array store
    var store = new Ext.data.ArrayStore({
        fields: ['abbr', 'state', 'nick'],
        data : Ext.exampledata.states // from states.js
    });    
    

    /*var ds = new Ext.data.Store({
            proxy: new Ext.data.HttpProxy({url: '/car/web/auto.php/json/marquesjson?active=true',method:'GET'}),
            reader: new Ext.data.JsonReader({
                root: 'marques',
                fields: [ {name: 'id'},{name: 'name'}]
            })
    });*/ 

    


    var dsEtat = new Ext.data.JsonStore({
            autoLoad: true,
            url: '/car/web/auto.php/json/etatsjson?active=true',
            root: 'etats',
            fields:['id', 'name']
    });

    var combo = new Ext.form.ComboBox({
        store: dsEtat,
        displayField: "name",
        valueField: "id",
        hiddenName: 'car_auto[idetat]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Selectionner un etat...',
        selectOnFocus:true,
        width:200,
        applyTo: 'idetat'
    });

    var dsType = new Ext.data.JsonStore({
            autoLoad: true,
            url: '/car/web/auto.php/json/typesjson?active=true',
            root: 'types',
            fields:['id', 'name']
    });

    var combo = new Ext.form.ComboBox({
        store: dsType,
        displayField: "name",
        valueField: "id",
        hiddenName: 'car_auto[idtype]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Selectionner un type...',
        selectOnFocus:true,
        width:200,
        applyTo: 'idtype'
    });

    var dsMoteur = new Ext.data.JsonStore({
            autoLoad: true,
            url: '/car/web/auto.php/json/moteursjson?active=true',
            root: 'moteurs',
            fields:['id', 'name']
    });

    var combo = new Ext.form.ComboBox({
        store: dsMoteur,
        displayField: "name",
        valueField: "id",
        hiddenName: 'car_auto[idmoteur]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Selectionner une motorisation...',
        selectOnFocus:true,
        width:230,
        applyTo: 'idmoteur'
    });

    var dsBoite = new Ext.data.JsonStore({
            autoLoad: true,
            url: '/car/web/auto.php/json/boitesjson?active=true',
            root: 'boites',
            fields:['id', 'name']
    });

    var combo = new Ext.form.ComboBox({
        store: dsBoite,
        displayField: "name",
        valueField: "id",
        hiddenName: 'car_auto[idboite]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Selectionner un etat...',
        selectOnFocus:true,
        width:200,
        applyTo: 'idboite'
    });

    var combo = new Ext.form.NumberField({
        store: dsMoteur,
        displayField: "name",
        valueField: "id",
        hiddenName: 'car_auto[kilometrage]',
        typeAhead: true,                
        selectOnFocus:true,
        width:100,
        decimalPrecision : 3,
        applyTo: 'kilometrage'
    });


    var dsAnneeDed = new Ext.data.JsonStore({
            autoLoad: true,
            url: '/car/web/auto.php/json/dedjson?active=true',
            root: 'annees',
            fields:['id', 'name']
    });

    var combo = new Ext.form.ComboBox({
        store: dsAnneeDed,
        displayField: "name",
        valueField: "id",
        hiddenName: 'car_auto[anneeded]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Année...',
        selectOnFocus:true,
        width:80,
        applyTo: 'anneeded'
    });


    var storeMois = new Ext.data.ArrayStore({
        fields: ['id', 'name',],
        data : Ext.exampledata.mois // from states.js
    });

    var combo = new Ext.form.ComboBox({
        store: storeMois,
        displayField: "name",
        valueField: "id",
        hiddenName: 'car_auto[moisded]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Mois...',
        selectOnFocus:true,
        width:100,
        applyTo: 'moisded'
    });

    var combo = new Ext.form.ComboBox({
        store: dsAnneeDed,
        displayField: "name",
        valueField: "id",
        hiddenName: 'car_auto[anneecir]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Année...',
        selectOnFocus:true,
        width:80,
        applyTo: 'anneecir'
    });

    var combo = new Ext.form.ComboBox({
        store: storeMois,
        displayField: "name",
        valueField: "id",
        hiddenName: 'car_auto[moiscir]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Mois...',
        selectOnFocus:true,
        width:100,
        applyTo: 'moiscir'
    });

    var combo = new Ext.form.NumberField({
        store: dsMoteur,
        displayField: "name",
        valueField: "id",
        hiddenName: 'car_auto[prixstart]',
        typeAhead: true,
        selectOnFocus:true,
        width:100,
        decimalPrecision : 3,
        applyTo: 'prixstart'
    });


    var combo = new Ext.ux.form.SpinnerField({
        store: dsMoteur,
        displayField: "name",
        valueField: "id",
        hiddenName: 'car_auto[anneegarantie]',
        typeAhead: true,
        selectOnFocus:true,
        width:100,
        minValue: 0,
        applyTo: 'anneegarantie'
    });

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
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Selectionner un modèle...',
        selectOnFocus:true,
        width:200,
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
        hiddenName: 'car_auto[idmarque]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Selectionner une marque...',
        selectOnFocus:true,
        width:200,
        applyTo: 'idmarque'
    });

    comboMarque.on('select', function(){
        commun.showLoader("loaderModele","divModele");
        commun.showLogoMarque(comboMarque.getValue());
        comboModele.store.removeAll();
        comboModele.setDisabled(true);
        comboModele.setValue('');
        //reload region store and enable region
        var dsModeleNew = new Ext.data.JsonStore({
            autoLoad: true,
            url: '/car/web/auto.php/json/modelejson?id='+comboMarque.getValue(),
            root: 'modeles',
            fields:['id', 'name']
        });
        comboModele.bindStore(dsModeleNew);
        comboModele.setDisabled(false);
        commun.hideLoader("loaderModele","divModele");
    });

    var combo = new Ext.form.NumberField({
        store: dsMoteur,
        displayField: "name",
        valueField: "id",
        hiddenName: 'car_auto[cylindres]',
        typeAhead: true,
        selectOnFocus:true,
        width:100,
        decimalPrecision : 3,
        applyTo: 'cylindres'
    });

    var storeFiscale = new Ext.data.ArrayStore({
        fields: ['id', 'name',],
        data : Ext.exampledata.fiscale // from states.js
    });

    var combo = new Ext.form.ComboBox({
        store: storeFiscale,
        displayField: "name",
        valueField: "id",
        hiddenName: 'car_auto[pfiscale]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Puissance fiscale...',
        selectOnFocus:true,
        width:200,
        applyTo: 'pfiscale'
    });

    var storePortes = new Ext.data.ArrayStore({
        fields: ['id', 'name',],
        data : Ext.exampledata.portes // from states.js
    });

    var combo = new Ext.form.ComboBox({
        store: storePortes,
        displayField: "name",
        valueField: "id",
        hiddenName: 'car_auto[nbportes]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Nombre de portes...',
        selectOnFocus:true,
        width:200,
        applyTo: 'nbportes'
    });

    var dsCouleurs = new Ext.data.JsonStore({
            autoLoad: true,
            url: '/car/web/auto.php/json/colorjson?active=true',
            root: 'couleurs',
            fields:['id', 'name']
    });

    var combo = new Ext.form.ComboBox({
        store: dsCouleurs,
        displayField: "name",
        valueField: "id",
        hiddenName: 'car_auto[idcouleur]',
        typeAhead: true,
        mode: 'local',
        forceSelection: true,
        triggerAction: 'all',
        emptyText:'Couleur...',
        selectOnFocus:true,
        width:200,
        applyTo: 'idcouleur'
    });
    
});