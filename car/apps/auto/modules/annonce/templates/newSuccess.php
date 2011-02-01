<link rel="stylesheet" type="text/css" href="/car/web/js/ext/spiner/Spinner.css" />
<script type="text/javascript" src="/car/web/js/ext/spiner/Spinner.js"></script>
<script type="text/javascript" src="/car/web/js/ext/spiner/SpinnerField.js"></script>


<script type='text/javascript' src='/car/web/js/jquery/jquery.scrollTo-min.js'></script>
<script type="text/javascript" src="/car/web/js/ext/combos/states.js"></script>
<script type="text/javascript" src="/car/web/js/ext/combos/combos.js"></script>
<link rel="stylesheet" type="text/css" href="/car/web/js/ext/combos/combos.css" />

<link rel="stylesheet" href="/car/web/js/uploadify/uploadify.css" type="text/css" />
<link rel="stylesheet" href="/car/web/js/uploadify/uploadify.styling.css" type="text/css" />

<script type="text/javascript" src="/car/web/js/uploadify/jquery.uploadify.js"></script>

<script type="text/javascript" src="/car/web/js/jquery/jquery.pikachoose.js"></script>
<script type="text/javascript" src="/car/web/js/jquery/jquery.fancybox-1.3.3.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/car/web/js/jquery/jquery.fancybox-1.3.3.css" media="screen" />

<script language="javascript">
    dojo.require("dijit.form.CheckBox");
    dojo.require("dijit.form.RadioButton");
    
    dojo.addOnLoad(            
	  function(){
                    $("#fileUploadstyle").fileUpload({
                            'uploader': '/car/web/js/uploadify/uploader.swf',
                            'cancelImg': '/car/web/js/uploadify/cancel.png',
                            'script': '/car/web/js/uploadify/upload_annonce.php',
                            'folder': '/car/web/uploads/annonces',                                                        
                            'buttonImg': '/car/web/images/finder.png',
                            'buttonText': 'Enregistrer',
                            'width': 123,
                            'height': 38,
                            'multi': true,
                            'displayData': 'speed',                            
                            'rollover': true,
                            'removeCompleted': false,
                            'fileExt'        : '*.jpg;*.gif;*.png',
                            'fileDesc'       : 'Image Files (.JPG, .GIF, .PNG)',
                            'removeCompleted': false,
                            'onAllComplete'  : function(event,data) {
                              alert('ok');
                            }
                    });

                    var a = function(self){
                            self.anchor.fancybox();
                    };
                    $("#pikame").PikaChoose({buildFinished:a});

                    

          });
</script>
<table width="100%">
    <tr>
        <td width="630" valign="top">
                    <div id="autoDiv">
                        <img src="/car/web/images/banner.png" />
                        <br/><br/>
                        <span style="font-family: TAHOMA;font-weight: bold;">Voici quelques conseils pour rendre votre annonce de plus en plus attirante vis &aacute; vis des futurs acheteurs :</span>
                        <br/><br/>
                        <table>
                            <tr>
                                <td width="10" valign="top" style="padding-top: 5px;"><img src="/car/web/images/fleche_grey.png"/></td>
                                <td width="3"></td>
                                <td valign="top"><span style="font-family: TAHOMA;">Plus vous attachez de photos &aacute; votre annonce plus vous mettez en valeur votre voiture.</span></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding-top: 5px;"><img src="/car/web/images/fleche_grey.png"/></td>
                                <td></td>
                                <td valign="top"><span style="font-family: TAHOMA;">Ne surchargez pas votre annonce avec des accessoires que votre voiture ne poss&egrave;de pas au risque de perdre votre cr&eacute;dibilit&eacute;.</span></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding-top: 5px;"><img src="/car/web/images/fleche_grey.png"/></td>
                                <td></td>
                                <td valign="top"><span style="font-family: TAHOMA;">Il est pr&eacute;f&eacute;rable que votre message soit clair et d&eacute;crive tous les aspects de votre voiture (l'&eacute;tat du salon, son historique, son conducteur...) </span></td>
                            </tr>
                        </table>
                        <br/>
                        <center><span style="font-family: TAHOMA;font-weight: bold;color: #C61B00;padding-right:20px;">Bonne vente !</span></center>
                        <br/>
                        <span style="font-family: TAHOMA;color: #b7b7b7;">Votre adresse IP : <span style="font-weight: bold;"><?php echo $_SERVER['REMOTE_ADDR']; ?></span></span>
                        <br/><br/>
                        <div id="autoForm">
                        <form>
                        <div id="blockInfo">
                            <br/><br/>
                            <table>
                                <tr>
                                    <td><div class="actifstep" style="width: 154px;height: 52px;"><center>Informations<br/> sur le v&eacute;hicule</center></div></td>
                                    <td width="5"></td>
                                    <td><div class="inactifstep" style="width: 156px;height: 52px;"><center>Options <br/> du v&eacute;hicule</center></div></td>
                                    <td width="5"></td>
                                    <td><div class="inactifstep" style="width: 156px;height: 52px;"><center>Photos <br/> du v&eacute;hicule</center></div></td>
                                    <td width="5"></td>
                                    <td><div class="inactifstep" style="width: 156px;height: 52px;"><center>Services <br/> PauseAuto</center></div></td>
                                </tr>
                            </table>
                            <br/>
                            <div style="background: url(/car/web/images/slider.jpg) no-repeat center center;width: 630px;height: 71px;padding-top: 30px;">
                               <span style="font-family: TAHOMA;color: #6a6a6a;font-size: 12pt;padding-left: 10px;"><span style="font-weight: bold;">Informations </span></span>
                            </div>
                            <img style="padding-left: 10px;height: 75px;width: 75px;" src="/car/web/images/noimage.png"/>
                            <br/><br/>
                                <table width="100%">
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td align="left" width="200"><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Marque</span></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div>
                                                <input type="text" id="idmarque" name="idmarque" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td align="left"><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Mod&egrave;le</span></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div>
                                                <input type="text" id="idmodele" name="idmodele" size="20"/>
                                            </div>                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td align="left"><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Type</span></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div>
                                                <input type="text" id="idtype" name="idtype" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td align="left"><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Etat</span></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div>
                                                <input type="text" id="idetat" name="idetat" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td align="left"><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Carrosserie</span></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div>
                                                <input type="text" id="idcarosserie" name="idcarosserie" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Moteur</span></td>
                                        <td width="5"></td>
                                        <td>
                                            <div>
                                                <input type="text" id="idmoteur" name="idmoteur" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Ann&eacute;e de mise en circulation</span></td>
                                        <td width="5"></td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <input type="text" id="moiscir" name="moisded" size="20"/>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <input type="text" id="anneecir" name="anneeded" size="20"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Kilom&eacute;trage</span></td>
                                        <td width="5"></td>
                                        <td>
                                            <div>
                                                <input type="text" id="kilometrage" name="kilometrage" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Bo&icirc;te de vitesse</span></td>
                                        <td width="5"></td>
                                        <td>
                                            <div>
                                                <input type="text" id="idboite" name="idboite" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Puissance fiscale</span></td>
                                        <td width="5"></td>
                                        <td>
                                            <div>
                                                <input type="text" id="pfiscale" name="pfiscale" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Cylindres</span></td>
                                        <td width="5"></td>
                                        <td>
                                            <div>
                                                <input type="text" id="cylindres" name="cylindres" size="20"/> CC
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Nombre de portes</span></td>
                                        <td width="5"></td>
                                        <td>
                                            <div>
                                                <input type="text" id="nbportes" name="nbportes" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Couleur</span></td>
                                        <td width="5"></td>
                                        <td><?php echo $form['idcarosserie']->render(); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td colspan="3" valign="middle" class="soria">
                                            <span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Ma voiture a &eacute;t&eacute; import&eacute;e de l'ext&eacute;rieur :</span>
                                            <span>Oui</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[etranger]" id="etrO" value="1">
                                            <span>Non</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[etranger]" id="etrN" value="0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td colspan="3" valign="middle" class="soria">
                                            <span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Ma voiture a &eacute;t&eacute; d&eacute;douan&eacute;e :&nbsp;&nbsp;&nbsp;</span>
                                            <span>Oui</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[dedouane]" id="dedO" value="1">
                                            <span>Non</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[dedouane]" id="dedN" value="0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Ann&eacute;e de d&eacute;douanement</span></td>
                                        <td width="5"></td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <input type="text" id="moisded" name="moisded" size="20"/>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <input type="text" id="anneeded" name="anneeded" size="20"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td colspan="3" valign="middle" class="soria">
                                            <span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Acceptez vous une &eacute;ventuelle reprise sur votre voiture :&nbsp;&nbsp;&nbsp;</span>
                                            <span>Oui</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[etranger]" id="repO" value="1">
                                            <span>Non</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[etranger]" id="repN" value="0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td colspan="3" valign="middle" class="soria">
                                            <span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Proposez vous une garantie sur votre voiture :&nbsp;&nbsp;&nbsp;</span>
                                            <span>Oui</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[etranger]" id="garO" value="1">
                                            <span>Non</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[etranger]" id="garN" value="0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Nombre de mois de garantie</span></td>
                                        <td width="5"></td>
                                        <td>
                                            <div>
                                                <input id="anneegarantie" name="anneegarantie" type="text" size="20" value="0"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td colspan="3" valign="middle" class="soria">
                                            <span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Votre voiture est actuellement en circulation :&nbsp;&nbsp;&nbsp;</span>
                                            <span>Oui</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[etranger]" id="cirO" value="1">
                                            <span>Non</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[etranger]" id="cirN" value="0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td colspan="3" valign="middle" class="soria">
                                            <span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Votre voiture est r&eacute;am&eacute;nag&eacute;e pour les handicap&eacute;s :&nbsp;&nbsp;&nbsp;</span>
                                            <span>Oui</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[etranger]" id="hanO" value="1">
                                            <span>Non</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[etranger]" id="hanN" value="0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;font-weight: bold;">Prix de vente</span></td>
                                        <td width="5"></td>
                                        <td>
                                            <div>
                                                <input type="text" id="prixstart" name="prixstart" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="left" colspan="4">
                                            <div>
                                                D&eacute;crivez tous les aspects de votre voiture (l'&eacute;tat du salon, son historique, son conducteur, r&eacute;parations, entretien...)
                                                <br/>
                                                Essayez d'&ecirc;tre le plus explicite possible
                                                <br/>
                                                Ne chargez pas trop votre message
                                                <br/><br/>
                                                <?php echo $form['description']->render(); ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <br/><br/>
                                <table id="buttonsBlockInfo">
                                    <tr>
                                        <td><div id="carAnnuler1" onclick="javascript:commun.annulerAnnonce()"><label class="buttonLabel">Annuler</label></div></td>
                                        <td></td>
                                        <td><div id="carSuivant1" onclick="javascript:commun.showAccBlock()"><label class="buttonLabel">Suivant &raquo;</label></div></td>
                                    </tr>
                                </table>
                                <br/><br/>
                                </div>
                                <div id="blockAcc" style="display: none;">
                                    <br/><br/>
                                    <table>
                                        <tr>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;"><center>Informations<br/> sur le v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="actifstep" style="width: 154px;height: 52px;"><center>Options <br/> du v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;"><center>Photos <br/> du v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;"><center>Services <br/> PauseAuto</center></div></td>
                                        </tr>
                                    </table>
                                    <br/>
                                    <div style="background: url(/car/web/images/slider.jpg) no-repeat center center;width: 630px;height: 71px;padding-top: 30px;">
                                        <span style="font-family: TAHOMA;color: #6a6a6a;font-size: 12pt;padding-left: 10px;"><span style="font-weight: bold;">Acc&eacute;ssoires et options</span></span>
                                    </div>
                                    <div class="soria">
                                        <div id="psdgraphics-com-table">
                                                <div id="psdg-header">
                                                    <span class="psdg-bold">Acc&eacute;ssoires & Options</span><br />
                                                </div>

                                                <div id="psdg-top">
                                                    <div class="psdg-top-cell" style="width:129px; text-align:left; padding-left: 24px;">Summary</div>
                                                </div>


                                                <div id="psdg-middle">
                                                    <div class="psdg-left"><span style="padding-left : 20px;">Daily Unique</span></div>
                                                    <div class="psdg-right"><input dojoType="dijit.form.CheckBox" type="radio" name="car_auto[dedouane]" id="chek1" value="0"></div>

                                                    <div class="psdg-left"><span style="padding-left : 20px;">Unique Visitors</span></div>
                                                    <div class="psdg-right">300 000</div>

                                                    <div class="psdg-left"><span style="padding-left : 20px;">Browser</span> </div>
                                                    <div class="psdg-right">Firefox</div>

                                                    <div class="psdg-left"><span style="padding-left : 20px;">Operating System</span></div>
                                                    <div class="psdg-right">Windows 7</div>

                                                    <div class="psdg-left"><span style="padding-left : 20px;">Screen Resolution</span></div>
                                                    <div class="psdg-right">1280x1024</div>

                                                    <div class="psdg-left"><span style="padding-left : 20px;">Domain/Country</span></div>
                                                    <div class="psdg-right">.com</div>

                                                    <div class="psdg-left"><span style="padding-left : 20px;">Continent</span></div>
                                                    <div class="psdg-right">Europe</div>
                                                </div>

                                                <div id="psdg-footer">
                                                    &nbsp;
                                                </div>

                                                <div id="psdg-top">
                                                        <div class="psdg-top-cell" style="width:129px; text-align:left; padding-left: 24px;">Summary</div>
                                                </div>

                                                <div id="psdg-middle">
                                                    <div class="psdg-left"><span style="padding-left : 20px;">Daily Unique</span></div>
                                                    <div class="psdg-right">10 000</div>

                                                    <div class="psdg-left"><span style="padding-left : 20px;">Unique Visitors</span></div>
                                                    <div class="psdg-right">300 000</div>

                                                    <div class="psdg-left"><span style="padding-left : 20px;">Browser</span> </div>
                                                    <div class="psdg-right">Firefox</div>

                                                    <div class="psdg-left"><span style="padding-left : 20px;">Operating System</span></div>
                                                    <div class="psdg-right">Windows 7</div>

                                                    <div class="psdg-left"><span style="padding-left : 20px;">Screen Resolution</span></div>
                                                    <div class="psdg-right">1280x1024</div>

                                                    <div class="psdg-left"><span style="padding-left : 20px;">Domain/Country</span></div>
                                                    <div class="psdg-right">.com</div>

                                                    <div class="psdg-left"><span style="padding-left : 20px;">Continent</span></div>
                                                    <div class="psdg-right">Europe</div>
                                                </div>

                                                <div id="psdg-footer">
                                                    &nbsp;
                                                </div>

                                        </div>
                                    </div>
                                    <br/><br/>
                                    <table id="buttonsBlockAcc">
                                        <tr>
                                            <td><div id="carBack1" onclick="javascript:commun.showPhotosBlock()"><label class="buttonLabel">Annuler</label></div></td>
                                            <td></td>
                                            <td><div id="carBack1" onclick="javascript:commun.hideAccBlock()"><label class="buttonLabel">Retour</label></div></td>
                                            <td></td>
                                            <td><div id="carSuivant2" onclick="javascript:commun.showPhotosBlock()"><label class="buttonLabel">Suivant &raquo;</label></div></td>
                                        </tr>
                                    </table>
                                    <br/><br/>
                                </div>
                                <div id="blockPhotos" style="display: none;">
                                    <br/><br/>
                                    <table>
                                        <tr>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;"><center>Informations<br/> sur le v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;"><center>Options <br/> du v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="actifstep" style="width: 154px;height: 52px;"><center>Photos <br/> du v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;"><center>Services <br/> PauseAuto</center></div></td>
                                        </tr>
                                    </table>
                                    <br/>
                                    <div style="background: url(/car/web/images/slider.jpg) no-repeat center center;width: 630px;height: 71px;padding-top: 30px;">
                                        <span style="font-family: TAHOMA;color: #6a6a6a;font-size: 12pt;padding-left: 10px;"><span style="font-weight: bold;">Photos </span></span>
                                    </div>
                                    <fieldset style="border: 1px solid #CDCDCD; padding: 8px; padding-bottom:0px; margin: 8px 0;width: 630px;">
                                                <legend><strong><b>Uploadez les photos prises de votre voiture</b></strong></legend>

                                                <p>
                                                    <table>
                                                        <tr>
                                                            <td width="10"><img src="/car/web/images/fleche_grey.png"/></td>
                                                            <td width="3"></td>
                                                            <td><span style="font-family: TAHOMA;">Cliquez sur le bouton <b>&laquo;Enregistrer&raquo;</b> pour charger vos images.</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="/car/web/images/fleche_grey.png"/></td>
                                                            <td></td>
                                                            <td><span style="font-family: TAHOMA;">Vous pouve ins&eacute;rer au maximum 12 photos.</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="/car/web/images/fleche_grey.png"/></td>
                                                            <td></td>
                                                            <td><span style="font-family: TAHOMA;">Plus vous mettez de photos plus votre annonce sera consul&eacute;e. </span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="/car/web/images/fleche_grey.png"/></td>
                                                            <td></td>
                                                            <td><span style="font-family: TAHOMA;">Utilisez idéalement les dimensions <b>600px / 450px</b> pour vos photos.</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="/car/web/images/fleche_grey.png"/></td>
                                                            <td></td>
                                                            <td><span style="font-family: TAHOMA;">La taille de vos photos ne doit pas dépasser <b>2Mo</b>.</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="/car/web/images/fleche_grey.png"/></td>
                                                            <td></td>
                                                            <td><span style="font-family: TAHOMA;">Vous pouvez attacher plusieurs photos &aacute; la fois.</span></td>
                                                        </tr>
                                                    </table>
                                                </p>
                                                <br/>
                                                <div id="fileUploadstyle">You have a problem with your javascript</div>
                                                <a href="javascript:$('#fileUploadstyle').fileUploadStart()">Uploader</a> |  <a href="javascript:$('#fileUploadstyle').fileUploadClearQueue()">Vider la liste</a>
                                        <p></p>
                                        <br/><br/>
                                        <hr width=100% size="1" color="" align="center">
                                        <br/>
                                            <p>
                                                <table>
                                                    <tr>
                                                        <td width="10"><img src="/car/web/images/fleche_grey.png"/></td>
                                                        <td width="3"></td>
                                                        <td><span style="font-family: TAHOMA;">Visualisez vos photos, vous pouvez s&eacute;l&eacute;tionner celle qui ne vous intersse pas et la supprimer : </span></td>
                                                    </tr>
                                                </table>
                                            </p>
                                        <br/>
                                        <div class="pikachoose">
                                            <ul id="pikame">
                                                    <li><a href="/car/web/uploads/annonces/0514988146.jpg"><img src="/car/web/uploads/annonces/0514988146.jpg" alt="" /></a></li>
                                                    <li><a href="/car/web/uploads/annonces/0503976711.jpg"><img src="/car/web/uploads/annonces/0503976711.jpg" alt="" /></a></li>
                                                    <li><a href="/car/web/uploads/annonces/0573146961.jpg"><img src="/car/web/uploads/annonces/0573146961.jpg" alt="" /></a></li>
                                            </ul>
                                        </div>
                                    </fieldset>
                                    <br/>
                                    <p>
                                        <table>
                                            <tr>
                                                <td width="10"><img src="/car/web/images/fleche_grey.png"/></td>
                                                <td width="3"></td>
                                                <td><span style="font-family: TAHOMA;">Vous avez finis de saisir le formulaire vous pouvez cliquer sur le bouton <b>&laquo;Terminer&raquo;</b> pour valider votre annonce</span></td>
                                            </tr>
                                        </table>
                                    </p>
                                    <br/><br/>
                                    <table id="buttonsBlockPhotos">
                                            <tr>
                                                <td><div id="carBack1" onclick="javascript:commun.showMsgBlock()"><label class="buttonLabel">Annuler</label></div></td>
                                                <td></td>
                                                <td><div id="carBack1" onclick="javascript:commun.hidePhotosBlock()"><label class="buttonLabel">Retour</label></div></td>
                                                <td></td>
                                                <td><div id="carValider" onclick="javascript:commun.showServicesBlock()"><label class="buttonLabel">Suivant &raquo;</label></div></td>
                                            </tr>
                                    </table>
                                </div>
                                <div id="blockServices" style="display: none;">
                                    <br/><br/>
                                    <table>
                                        <tr>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;"><center>Informations<br/> sur le v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;"><center>Options <br/> du v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;"><center>Photos <br/> du v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="actifstep" style="width: 154px;height: 52px;"><center>Services <br/> PauseAuto</center></div></td>
                                        </tr>
                                    </table>
                                    
                                    <table id="buttonsBlockServices">
                                            <tr>
                                                <td><div id="carBack1" onclick="javascript:commun.showMsgBlock()"><label class="buttonLabel">Annuler</label></div></td>
                                                <td></td>
                                                <td><div id="carBack1" onclick="javascript:commun.hideServicesBlock()"><label class="buttonLabel">Retour</label></div></td>
                                                <td></td>
                                                <td><div id="carValider" onclick="javascript:commun.showPhotosBlock()"><label class="buttonLabel">Terminer &raquo;</label></div></td>
                                            </tr>
                                    </table>
                                </div>
                        </form>
                        </div>
                        <br/><br/><br/>
                        <?php


                        ?>
                    </div>
            </td>
            <td valign="top" style="padding-left: 10px;" width="300">
                <br/>
                <div id="right_tab1">
                    <br/>
                        <table width="100%">
                            <tr>
                                <td width="49"><img src="/car/web/images/lien_utile.png" width="49"/></td>
                                <td width="20" valign="middle" align="center"></td>
                                <td width="100%" valign="middle"><span style="font-weight: bold;color: #C61B00;font-size: 10pt;">Liens utiles</span></td>
                            </tr>                            
                            <!--<tr>
                                <td style="background-image: url(/car/web/images/limH.png);background-repeat: repeat-x;background-position: center;">&nbsp;</td>
                            </tr>!-->
                        </table>
                        <br/>
                        <table>
                            <tr>
                                <td width="10" valign="top" style="padding-top: 5px;"><img src="/car/web/images/red_fleche.png"/></td>
                                <td width="3"></td>
                                <td valign="top"><span style="font-family: TAHOMA;">Plus vous attachez de photos &aacute; votre annonce plus vous mettez en valeur votre voiture.</span></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding-top: 5px;"><img src="/car/web/images/red_fleche.png"/></td>
                                <td></td>
                                <td valign="top"><span style="font-family: TAHOMA;">Ne surchargez pas votre annonce avec des accessoires que votre voiture ne poss&egrave;de pas au risque de perdre votre cr&eacute;dibilit&eacute;.</span></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding-top: 5px;"><img src="/car/web/images/red_fleche.png"/></td>
                                <td></td>
                                <td valign="top"><span style="font-family: TAHOMA;">Il est pr&eacute;f&eacute;rable que votre message soit clair et d&eacute;crive tous les aspects de votre voiture (l'&eacute;tat du salon, son historique, son conducteur...) </span></td>
                            </tr>
                        </table>                
                </div>
                <br/><br/>
                <table width="100%">
                    <tr>
                        <td width="32"><img src="/car/web/images/adversiting.png" width="32"/></td>
                        <td width="20" valign="middle" align="center"><img src="/car/web/images/limV.png"/></td>
                        <td valign="middle"><span style="font-weight: bold;color: #C61B00;font-size: 10pt;">Publicit&eacute;</span></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center"><img src="/car/web/images/shadowH.png"/></td>
                    </tr>
                </table>
                <center>
                    <object height="180" width="300" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
                        <param value="always" name="allowScriptAccess">
                        <param value="http://medias.autoplus.fr/swf/top-renault/300x180-jean-hubert.swf?clickTag=http%3A%2F%2Fpetites-annonces.autoplus.fr%2Ftoprenault" name="movie">
                        <param value="high" name="quality">
                        <embed height="180" align="middle" width="300" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" allowfullscreen="false" allowscriptaccess="sameDomain" quality="high" src="http://medias.autoplus.fr/swf/top-renault/300x180-jean-hubert.swf?clickTag=http%3A%2F%2Fpetites-annonces.autoplus.fr%2Ftoprenault">
                    </object>
                </center>
                <br/><br/>
                <center>
                    <iframe scrolling="no" frameborder="0" style="border: medium none ; width: 300px; height: 550px;" allowtransparency="true" src="http://www.facebook.com/connect/connect.php?%20id=20533054080&amp;connections=10&amp;stream=1"></iframe>
                </center>
            </td>
    </tr>
</table>