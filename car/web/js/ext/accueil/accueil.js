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
        id:"marqueId",
        hiddenName: 'car_auto[idmarque]',
        hiddenId: 'car_auto[idmarque]',
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
    
});