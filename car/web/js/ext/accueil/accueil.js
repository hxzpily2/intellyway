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

    
    var spinnkmmin = new Ext.ux.form.SpinnerField({
        store: dsMoteur,
        displayField: "name",
        valueField: "id",
        id:"kmmin",
        hiddenName: 'kmmin',
        hiddenId: 'kmmin',
        typeAhead: true,
        selectOnFocus:true,        
        minValue: 0,
        emptyText:'Km min',
        width:70,
        applyTo: 'kmmin'
    });
    spinnkmmin.hide();
    
    var spinnkmmax = new Ext.ux.form.SpinnerField({
        store: dsMoteur,
        displayField: "name",
        valueField: "id",
        id:"kmmax",
        hiddenName: 'kmmax',
        hiddenId: 'kmmin',
        typeAhead: true,
        selectOnFocus:true,        
        minValue: 0,
        emptyText:'Km max',
        width:70,
        applyTo: 'kmmax'
    });
    spinnkmmax.hide();

    var spinnprixmin = new Ext.ux.form.SpinnerField({
        store: dsMoteur,
        displayField: "name",
        valueField: "id",
        id:"prixmin",
        hiddenName: 'prixmin',
        hiddenId: 'prixmin',
        typeAhead: true,
        selectOnFocus:true,
        minValue: 0,
        emptyText:'Prix min',
        width:70,
        applyTo: 'prixmin'
    });
    spinnprixmin.hide();

    var spinnprixmax = new Ext.ux.form.SpinnerField({
        store: dsMoteur,
        displayField: "name",
        valueField: "id",
        id:"prixmax",
        hiddenName: 'prixmax',
        hiddenId: 'prixmax',
        typeAhead: true,
        selectOnFocus:true,
        minValue: 0,
        emptyText:'Prix max',
        width:70,
        applyTo: 'prixmax'
    });
    spinnprixmax.hide();

    var anneemin = new Ext.ux.form.SpinnerField({
        store: dsMoteur,
        displayField: "name",
        valueField: "id",
        id:"annemin",
        hiddenName: 'annemin',
        hiddenId: 'annemin',
        typeAhead: true,
        selectOnFocus:true,
        minValue: 0,
        emptyText:'Annee modele min',
        width:140,
        applyTo: 'annemin'
    });
    anneemin.hide();
    
    var anneemax = new Ext.ux.form.SpinnerField({
        store: dsMoteur,
        displayField: "name",
        valueField: "id",
        id:"annemax",
        hiddenName: 'annemax',
        hiddenId: 'annemax',
        typeAhead: true,
        selectOnFocus:true,
        minValue: 0,
        emptyText:'Annee modele max',
        width:140,
        applyTo: 'annemax'
    });
    anneemax.hide();
    
});