<link rel="stylesheet" type="text/css" href="/car/web/js/ext/spiner/Spinner.css" />
<link rel="stylesheet" type="text/css" href="/car/web/css/hoverbox.css" />
<script type="text/javascript" src="/car/web/js/ext/spiner/Spinner.js"></script>
<script type="text/javascript" src="/car/web/js/ext/spiner/SpinnerField.js"></script>


<script type='text/javascript' src='/car/web/js/jquery/jquery.scrollTo-min.js'></script>
<script type="text/javascript" src="/car/web/js/ext/combos/states.js"></script>
<script type="text/javascript" src="/car/web/js/ext/combos/combos.js"></script>
<link rel="stylesheet" type="text/css" href="/car/web/js/ext/combos/combos.css" />

<link rel="stylesheet" href="/car/web/js/uploadify/uploadify.css" type="text/css" />
<link rel="stylesheet" href="/car/web/js/uploadify/uploadify.styling.css" type="text/css" />

<script type="text/javascript" src="/car/web/js/uploadify/jquery.uploadify.js"></script>

<!--<script type="text/javascript" src="/car/web/js/jquery/jquery.pikachoose.js"></script>-->
<script type="text/javascript" src="/car/web/js/jquery/jquery.fancybox-1.3.3.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/car/web/js/jquery/jquery.fancybox-1.3.3.css" media="screen" />

<script language="javascript">
    dojo.require("dijit.form.CheckBox");
    dojo.require("dijit.form.RadioButton");
    dojo.require("dojo.io.iframe");
    dojo.require("dijit.ProgressBar");
    
    dojo.addOnLoad(            
	  function(){                    
                    $("#fileUploadstyle").fileUpload({
                            'uploader': '/car/web/js/uploadify/uploader.swf',
                            'cancelImg': '/car/web/js/uploadify/cancel.png',
                            //'script': '/car/web/js/uploadify/upload_annonce.php',
                            'script': '/car/web/auto.php/commun/uploadannonce',
                            'scriptData': { '<?php echo Constantes::SESSION_PREFIX_ANNONCE; ?>': '<?php echo $sf_user->getAttribute(Constantes::SESSION_PREFIX_ANNONCE); ?>' },
                            'folder': '/car/web/uploads/annonces',
                            'buttonImg': '/car/web/images/finder.png',
                            'buttonText': 'Enregistrer',
                            'width': 24,
                            'height': 23,
                            'multi': true,
                            'displayData': 'speed',                            
                            'rollover': true,
                            'removeCompleted': false,
                            'fileExt'        : '*.jpg;*.gif;*.png',
                            'fileDesc'       : 'Image Files (.JPG, .GIF, .PNG)',
                            'removeCompleted': false,
                            'onAllComplete'  : function(event,data) {
                              
                            },
                            'onComplete': function(event, queueID, fileObj, response, data) {                                                                
                                dojo.byId("slideshow").innerHTML = response;
                                $("a.fancyauto").fancybox();
                            }
                    });

                    /*var a = function(self){
                            self.anchor.fancybox();
                    };
                    //$("#pikame").PikaChoose({buildFinished:a});

                    /*
                    $('.acc_container').hide(); //Hide/close all containers
                    $('.acc_trigger:first').addClass('active').next().show(); //Add "active" class to first trigger, then show/open the immediate next container

                    //On Click
                    $('.acc_trigger').click(function(){
                            if( $(this).next().is(':hidden') ) { //If immediate next container is closed...
                                    $('.acc_trigger').removeClass('active').next().slideUp(); //Remove all .acc_trigger classes and slide up the immediate next container
                                    $(this).toggleClass('active').next().slideDown(); //Add .acc_trigger class to clicked trigger and slide down the immediate next container
                            }
                            return false; //Prevent the browser jump to the link anchor
                    });*/

                    dojo.style(dojo.byId('lineDed'), 'opacity', .0);
		    dojo.style(dojo.byId('blockDed'), 'opacity', .0);
                    dojo.style(dojo.byId('lineAnneeDed'), 'opacity', .0);
		    dojo.style(dojo.byId('blockAnneeDed'), 'opacity', .0);

                    dojo.style(dojo.byId('blockAnneeDed'), 'opacity', .0);
                    dojo.style(dojo.byId('blockAnneeDed'), 'opacity', .0);

                    dojo.style(dojo.byId('marqueError'), 'opacity', .0);
                    dojo.style(dojo.byId('modeleError'), 'opacity', .0);
                    dojo.style(dojo.byId('typeError'), 'opacity', .0);
                    dojo.style(dojo.byId('etatError'), 'opacity', .0);
                    dojo.style(dojo.byId('carosserieError'), 'opacity', .0);
                    dojo.style(dojo.byId('moteurError'), 'opacity', .0);
                    dojo.style(dojo.byId('anneecirError'), 'opacity', .0);
                    dojo.style(dojo.byId('boiteError'), 'opacity', .0);
                    dojo.style(dojo.byId('pfError'), 'opacity', .0);
                    dojo.style(dojo.byId('cylError'), 'opacity', .0);
                    dojo.style(dojo.byId('nbporteError'), 'opacity', .0);
                    dojo.style(dojo.byId('couleurError'), 'opacity', .0);
                    dojo.style(dojo.byId('anneededError'), 'opacity', .0);
                    dojo.style(dojo.byId('dedError'), 'opacity', .0);
                    dojo.style(dojo.byId('globalError'), 'opacity', .0);
                    dojo.style(dojo.byId('villeError'), 'opacity', .0);


          });
</script>
<input type="hidden" id="paysID" value="<?php echo $pays->getIdpays(); ?>"/>
<table width="100%">
    <tr>
        <td width="630" valign="top">
                    <div id="autoDiv">
                        <div id="autoForm">
                        <img src="/car/web/images/banner.png" />
                        <br/><br/>                        
                        <span style="font-family: TAHOMA;font-weight: bold;">Voici quelques conseils pour rendre votre annonce de plus en plus attirante vis &aacute; vis des futurs acheteurs :</span>
                        <br/><br/>
                        <table>
                            <tr>
                                <td width="10" valign="top" style="padding-top: 4px;"><img src="/car/web/images/fleche_grey.png"/></td>
                                <td width="3"></td>
                                <td valign="top"><span style="font-family: TAHOMA;">Plus vous attachez de photos &aacute; votre annonce plus vous mettez en valeur votre voiture.</span></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding-top: 4px;"><img src="/car/web/images/fleche_grey.png"/></td>
                                <td></td>
                                <td valign="top"><span style="font-family: TAHOMA;">Ne surchargez pas votre annonce avec des accessoires que votre voiture ne poss&egrave;de pas au risque de perdre votre cr&eacute;dibilit&eacute;.</span></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding-top: 4px;"><img src="/car/web/images/fleche_grey.png"/></td>
                                <td></td>
                                <td valign="top"><span style="font-family: TAHOMA;">Il est pr&eacute;f&eacute;rable que votre message soit clair et d&eacute;crive tous les aspects de votre voiture (l'&eacute;tat du salon, son historique, son conducteur...) </span></td>
                            </tr>
                        </table>
                        <br/>
                        <center><span style="font-family: TAHOMA;font-weight: bold;color: #C61B00;padding-right:20px;">Bonne vente !</span></center>
                        <br/>
                        <span style="font-family: TAHOMA;color: #b7b7b7;">Votre adresse IP : <span style="font-weight: bold;"><?php echo $_SERVER['REMOTE_ADDR']; ?></span></span>
                        <br/><br/>                        
                        <form method="post" id="annonceAuto" action="/car/web/auto.php/annonce/create">
                        <div id="blockInfo">
                            <br/><br/>
                            <table>
                                <tr>
                                    <td><div class="actifstep" style="width: 154px;height: 52px;cursor: pointer"><center>Informations<br/> sur le v&eacute;hicule</center></div></td>
                                    <td width="5"></td>
                                    <td><div class="inactifstep" style="width: 156px;height: 52px;cursor: pointer"><center>Options <br/> du v&eacute;hicule</center></div></td>
                                    <td width="5"></td>
                                    <td><div class="inactifstep" style="width: 156px;height: 52px;cursor: pointer"><center>Photos <br/> du v&eacute;hicule</center></div></td>
                                    <td width="5"></td>
                                    <td><div class="inactifstep" style="width: 156px;height: 52px;cursor: pointer"><center>Services <br/> PauseAuto</center></div></td>
                                </tr>
                            </table>
                            <br/>
                            <div style="background: url(/car/web/images/slider.jpg) no-repeat center center;width: 630px;height: 71px;padding-top: 30px;">
                               <span style="font-family: TAHOMA;color: #6a6a6a;font-size: 12pt;padding-left: 10px;"><span style="font-weight: bold;">Informations </span></span>
                            </div>
                            <img id="imageMarque" style="padding-left: 10px;height: 75px;width: 75px;" src="/car/web/images/noimage.png"/>
                            <br/><br/>
                                <table width="100%">
                                    <tr id="globalError" style="display :none;">
                                        <td colspan="4">
                                            <div style="border-width: 1px;  border-style: dotted; border-color: red; padding-top: 2px;padding-bottom: 2px;padding-right: 2px;padding-left: 2px;">
                                                <span style="font-family: TAHOMA;font-weight: bold;color : RED">Vous n'avez pas compl&egrave;ter la saisie de votre annonce, Merci de v&eacute;rifier les informations ci-dessous</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td align="left" width="200"><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Marque</span><img src="/car/web/images/asterisk.png"/></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div>
                                                <input type="text" id="idmarque" name="idmarque" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="marqueError" style="display: none;">
                                        <td></td>
                                        <td align="left" width="200"></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div style="border-width: 1px;  border-style: dotted; border-color: red; padding-top: 2px;padding-bottom: 2px;padding-right: 2px;padding-left: 2px;">
                                                <span style="font-family: TAHOMA;font-weight: bold;color : RED">Veuillez choisir la marque de votre v&eacute;hicule</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td align="left"><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Mod&egrave;le</span><img src="/car/web/images/asterisk.png"/></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <img src="/car/web/images/loaderS.gif" id="loaderModele" style="display: none;"/>
                                            <div id="divModele">
                                                <input type="text" id="idmodele" name="idmodele" size="20" />
                                            </div>                                            
                                        </td>
                                    </tr>
                                    <tr id="modeleError" style="display: none;">
                                        <td></td>
                                        <td align="left" width="200"></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div style="border-width: 1px;  border-style: dotted; border-color: red; padding-top: 2px;padding-bottom: 2px;padding-right: 2px;padding-left: 2px;">
                                                <span style="font-family: TAHOMA;font-weight: bold;color : RED">Veuillez choisir le mod&egrave;le de votre v&eacute;hicule</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td align="left"><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Ville</span><img src="/car/web/images/asterisk.png"/></td>
                                        <td width="5"></td>
                                        <td align="left">                                            
                                            <div>
                                                <input type="text" id="idville" name="idville" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="villeError" style="display: none;">
                                        <td></td>
                                        <td align="left" width="200"></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div style="border-width: 1px;  border-style: dotted; border-color: red; padding-top: 2px;padding-bottom: 2px;padding-right: 2px;padding-left: 2px;">
                                                <span style="font-family: TAHOMA;font-weight: bold;color : RED">Veuillez mentionner la ville ou on peut croiser votre v&eacute;hicule</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td align="left"><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Type</span><img src="/car/web/images/asterisk.png"/></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div>
                                                <input type="text" id="idtype" name="idtype" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="typeError" style="display: none;">
                                        <td></td>
                                        <td align="left" width="200"></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div style="border-width: 1px;  border-style: dotted; border-color: red; padding-top: 2px;padding-bottom: 2px;padding-right: 2px;padding-left: 2px;">
                                                <span style="font-family: TAHOMA;font-weight: bold;color : RED">Veuillez sp&eacute;cifier le type de votre v&eacute;hicule</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td align="left"><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Etat</span><img src="/car/web/images/asterisk.png"/></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div>
                                                <input type="text" id="idetat" name="idetat" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="etatError" style="display: none;">
                                        <td></td>
                                        <td align="left" width="200"></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div style="border-width: 1px;  border-style: dotted; border-color: red; padding-top: 2px;padding-bottom: 2px;padding-right: 2px;padding-left: 2px;">
                                                <span style="font-family: TAHOMA;font-weight: bold;color : RED">Veuillez sp&eacute;cifier l&rsquo;&eacute;tat de votre v&eacute;hicule</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td align="left"><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Carrosserie</span><img src="/car/web/images/asterisk.png"/></td>
                                        <td width="5"></td>
                                        <td align="left">                                            
                                            <table class="soria">
                                                <?php
                                                $col=0;
                                                foreach ($carosserie as $car){
                                                    $col++;
                                                }
                                                $nbligne=(int)($col/3);
                                                if($col%3!=0){
                                                    $nbligne++;
                                                }                                                
                                                for($i=0;$i<$nbligne;$i++){
                                                    //echo $carosserie[$i]->getIdCarosserie()."<br/>";
                                                    echo "<tr>";
                                                    for($j=0;$j<3;$j++){
                                                        if($i+$j*3<$col){
                                                        ?>
                                                        <td>
                                                            <img src="/car/web/uploads/carosserie/<?php echo $carosserie[$i+$j*3]->getImage(); ?>"/>
                                                            <center><span><?php echo $carosserie[$i+$j*3]->getTitle(); ?></span></center>
                                                            <center><input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[idcarosserie]" onClick="commun.setCarosserie(<?php echo $carosserie[$i+$j*3]->getIdcarosserie(); ?>)" value="<?php echo $carosserie[$i+$j*3]->getIdcarosserie(); ?>"></center>
                                                            <br style="line-height: 10px;"/>
                                                        </td>
                                                        <?php
                                                        }else{
                                                            echo "<td></td>";
                                                        }
                                                        echo "<td width='10'></td>";
                                                    }
                                                    echo "</tr>";
                                                }
                                                ?>                                                
                                            </table>
                                            <input type="hidden" id="carosserieId" value="" />
                                        </td>
                                    </tr>
                                    <tr id="carosserieError" style="display: none;">
                                        <td></td>
                                        <td align="left" width="200"></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div style="border-width: 1px;  border-style: dotted; border-color: red; padding-top: 2px;padding-bottom: 2px;padding-right: 2px;padding-left: 2px;">
                                                <span style="font-family: TAHOMA;font-weight: bold;color : RED">Veuillez choisir la carrosserie de votre v&eacute;hicule</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Moteur</span><img src="/car/web/images/asterisk.png"/></td>
                                        <td width="5"></td>
                                        <td>
                                            <div>
                                                <input type="text" id="idmoteur" name="idmoteur" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="moteurError" style="display: none;">
                                        <td></td>
                                        <td align="left" width="200"></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div style="border-width: 1px;  border-style: dotted; border-color: red; padding-top: 2px;padding-bottom: 2px;padding-right: 2px;padding-left: 2px;">
                                                <span style="font-family: TAHOMA;font-weight: bold;color : RED">Veuillez choisir l&rsquo;&eacute;nergie de votre v&eacute;hicule</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Ann&eacute;e de mise en circulation</span><img src="/car/web/images/asterisk.png"/></td>
                                        <td width="5"></td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <input type="text" id="moiscir" name="moiscir" size="20"/>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <input type="text" id="anneecir" name="anneecir" size="20"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr id="anneecirError" style="display: none;">
                                        <td></td>
                                        <td align="left" width="200"></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div style="border-width: 1px;  border-style: dotted; border-color: red; padding-top: 2px;padding-bottom: 2px;padding-right: 2px;padding-left: 2px;">
                                                <span style="font-family: TAHOMA;font-weight: bold;color : RED">Veuillez mentionner l&rsquo;ann&eacute;e de mise en circulation de votre v&eacute;hicule</span>
                                            </div>
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
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Bo&icirc;te de vitesse</span><img src="/car/web/images/asterisk.png"/></td>
                                        <td width="5"></td>
                                        <td>
                                            <div>
                                                <input type="text" id="idboite" name="idboite" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="boiteError" style="display: none;">
                                        <td></td>
                                        <td align="left" width="200"></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div style="border-width: 1px;  border-style: dotted; border-color: red; padding-top: 2px;padding-bottom: 2px;padding-right: 2px;padding-left: 2px;">
                                                <span style="font-family: TAHOMA;font-weight: bold;color : RED">Veuillez choisir la bo&icirc;te &agrave; vitesse de votre v&eacute;hicule</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Puissance fiscale</span><img src="/car/web/images/asterisk.png"/></td>
                                        <td width="5"></td>
                                        <td>
                                            <div>
                                                <input type="text" id="pfiscale" name="pfiscale" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="pfError" style="display: none;">
                                        <td></td>
                                        <td align="left" width="200"></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div style="border-width: 1px;  border-style: dotted; border-color: red; padding-top: 2px;padding-bottom: 2px;padding-right: 2px;padding-left: 2px;">
                                                <span style="font-family: TAHOMA;font-weight: bold;color : RED">Veuillez sp&eacute;cifier la puissance fiscale de votre v&eacute;hicule</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Cylindres</span><img src="/car/web/images/asterisk.png"/></td>
                                        <td width="5"></td>
                                        <td>
                                            <div>
                                                <input type="text" id="cylindres" name="cylindres" size="20"/> CC
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="cylError" style="display: none;">
                                        <td></td>
                                        <td align="left" width="200"></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div style="border-width: 1px;  border-style: dotted; border-color: red; padding-top: 2px;padding-bottom: 2px;padding-right: 2px;padding-left: 2px;">
                                                <span style="font-family: TAHOMA;font-weight: bold;color : RED">Veuillez sp&eacute;cifier le nombre de cylindre de votre v&eacute;hicule</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Nombre de portes</span><img src="/car/web/images/asterisk.png"/></td>
                                        <td width="5"></td>
                                        <td>
                                            <div>
                                                <input type="text" id="nbportes" name="nbportes" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="nbporteError" style="display: none;">
                                        <td></td>
                                        <td align="left" width="200"></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div style="border-width: 1px;  border-style: dotted; border-color: red; padding-top: 2px;padding-bottom: 2px;padding-right: 2px;padding-left: 2px;">
                                                <span style="font-family: TAHOMA;font-weight: bold;color : RED">Veuillez sp&eacute;cifier le nombre de portes de votre v&eacute;hicule</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Couleur</span><img src="/car/web/images/asterisk.png"/></td>
                                        <td width="5"></td>
                                        <td>
                                            <div>
                                                <input type="text" id="idcouleur" name="idcouleur" size="20"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="couleurError" style="display: none;">
                                        <td></td>
                                        <td align="left" width="200"></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div style="border-width: 1px;  border-style: dotted; border-color: red; padding-top: 2px;padding-bottom: 2px;padding-right: 2px;padding-left: 2px;">
                                                <span style="font-family: TAHOMA;font-weight: bold;color : RED">Veuillez choisir la couleur de votre v&eacute;hicule</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td colspan="3" valign="middle" class="soria">
                                            <span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Ma voiture a &eacute;t&eacute; import&eacute;e de l'&eacute;tranger :</span>
                                            <span>Oui</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[etranger]" id="etrO" value="1" onChange="commun.showDedPanel();">
                                            <span>Non</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[etranger]" id="etrN" value="0" checked="checked">
                                            <input type="hidden" id="etrangerId" value="0" />
                                        </td>
                                    </tr>
                                    <tr id="lineDed" style="display: none;">
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr id="blockDed" style="display: none;">
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td colspan="3" valign="middle" class="soria"  style="padding-bottom: 3px;">
                                            <span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Ma voiture a &eacute;t&eacute; d&eacute;douan&eacute;e<img src="/car/web/images/asterisk.png" style="display: inline"/> :&nbsp;&nbsp;&nbsp;</span>
                                            <span>Oui</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[dedouane]" id="dedO" value="1" onClick="dojo.byId('dedouaneId').value=1">
                                            <span>Non</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[dedouane]" id="dedN" value="0" onClick="dojo.byId('dedouaneId').value=0">
                                            <input type="hidden" id="dedouaneId" value="" />
                                        </td>
                                    </tr>
                                    <tr id="dedError" style="display: none;">
                                        <td></td>
                                        <td align="left" width="200"></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div style="border-width: 1px;  border-style: dotted; border-color: red; padding-top: 2px;padding-bottom: 2px;padding-right: 2px;padding-left: 2px;">
                                                <span style="font-family: TAHOMA;font-weight: bold;color : RED">Veuillez sp&eacute;cifier si votre v&eacute;hicule a &eacute;t&eacute; d&eacute;douan&eacute;</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="lineAnneeDed" style="display: none;">
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr id="blockAnneeDed" style="display: none;">
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td valign="middle" style="padding-bottom: 3px;"><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Ann&eacute;e de d&eacute;douanement</span><img src="/car/web/images/asterisk.png"/></td>
                                        <td width="5"></td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td width="100">
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
                                    <tr id="anneededError" style="display: none;">
                                        <td></td>
                                        <td align="left" width="200"></td>
                                        <td width="5"></td>
                                        <td align="left">
                                            <div style="border-width: 1px;  border-style: dotted; border-color: red; padding-top: 2px;padding-bottom: 2px;padding-right: 2px;padding-left: 2px;">
                                                <span style="font-family: TAHOMA;font-weight: bold;color : RED">Veuillez sp&eacute;cifier l'ann&eacute;e de d&eacute;douannement de votre v&eacute;hicule</span>
                                            </div>
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
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[reprise]" id="repO" value="1" onClick="dojo.byId('repriseId').value=1">
                                            <span>Non</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[reprise]" id="repN" value="0" onClick="dojo.byId('repriseId').value=0" checked>
                                            <input type="hidden" id="repriseId" value="0" />
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
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[garantie]" id="garO" value="1" onClick="dojo.byId('garantieId').value=1">
                                            <span>Non</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[garantie]" id="garN" value="0" checked="checked" onClick="dojo.byId('garantieId').value=0">
                                            <input type="hidden" id="garantieId" value="0" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Nombre de mois de garantie</span></td>
                                        <td width="5">&nbsp;</td>
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
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[garaged]" id="cirO" value="1" onClick="dojo.byId('garagedId').value=1">
                                            <span>Non</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[garaged]" id="cirN" value="0" onClick="dojo.byId('garagedId').value=0">
                                            <input type="hidden" id="garagedId" value="" />
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
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[hand]" id="hanO" value="1" onClick="dojo.byId('handId').value=1">
                                            <span>Non</span>
                                            <input dojoType="dijit.form.RadioButton" type="radio" name="car_auto[hand]" id="hanN" value="0" onClick="dojo.byId('handId').value=0">
                                            <input type="hidden" id="handId" value="" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/car/web/images/fleche3.png"/></td>
                                        <td colspan="3" valign="middle" class="soria">
                                            <span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Votre annonce est-elle urgente ?</span>&nbsp;&nbsp;&nbsp;
                                            <span>Oui</span>
                                            <input dojoType="dijit.form.CheckBox" type="radio" name="car_auto[urgent]" id="urgentId" />
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
                                                <br/>
                                                <p>
                                                    <table>
                                                        <tr>
                                                            <td width="10" valign="top" style="padding-top: 4px;"><img src="/car/web/images/fleche_grey.png"/></td>
                                                            <td width="3"></td>
                                                            <td valign="top"><span style="font-family: TAHOMA;">D&eacute;crivez tous les aspects de votre voiture (l'&eacute;tat du salon, son historique, son conducteur, r&eacute;parations, entretien...)</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="10" valign="top" style="padding-top: 4px;"><img src="/car/web/images/fleche_grey.png"/></td>
                                                            <td width="3"></td>
                                                            <td valign="top"><span style="font-family: TAHOMA;">Essayez d'&ecirc;tre le plus explicite possible</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="10" valign="top" style="padding-top: 4px;"><img src="/car/web/images/fleche_grey.png"/></td>
                                                            <td width="3"></td>
                                                            <td valign="top"><span style="font-family: TAHOMA;">Ne chargez pas trop votre message</span></td>
                                                        </tr>
                                                    </table>
                                                </p>
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
                                        <td></td>
                                        <td id="buttonInfoTerminer" style="display: none;"><div id="carTerminer" onclick="javascript:commun.sendForm('annonceAuto')"><label class="buttonLabel">Terminer</label></div></td>
                                    </tr>
                                </table>
                                <br/><br/>
                                </div>
                                <div id="blockAcc" style="display: none;">
                                    <br/><br/>
                                    <table>
                                        <tr>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;cursor: pointer"><center>Informations<br/> sur le v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="actifstep" style="width: 154px;height: 52px;cursor: pointer"><center>Options <br/> du v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;cursor: pointer"><center>Photos <br/> du v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;cursor: pointer"><center>Services <br/> PauseAuto</center></div></td>
                                        </tr>
                                    </table>
                                    <br/>
                                    <div style="background: url(/car/web/images/slider.jpg) no-repeat center center;width: 630px;height: 71px;padding-top: 30px;">
                                        <span style="font-family: TAHOMA;color: #6a6a6a;font-size: 12pt;padding-left: 10px;"><span style="font-weight: bold;">Acc&eacute;ssoires et options</span></span>
                                    </div>
                                    <br/>
                                    <p>
                                        <table>
                                            <tr>
                                                <td width="10" valign="top" style="padding-top: 4px;"><img src="/car/web/images/fleche_grey.png"/></td>
                                                <td width="3"></td>
                                                <td valign="top"><span style="font-family: TAHOMA;">Cochez les options et équipements dont diposent votre véhicule</span></td>
                                            </tr>
                                        </table>
                                    </p>
                                    <br/><br/>
                                    <table>
                                        <tr>
                                        <?php
                                            foreach ($typesaccessoire as $type){
                                                echo "<td align='left' width='200'><span style='font-family: TAHOMA;font-weight: bold;color: #C61B00;'>".$type->getTitle()."</span></td><td width='10'>&nbsp;</td>";
                                            }
                                        ?>
                                        </tr>
                                        <tr>
                                            <td colspan="<?php echo count($typeaccessoire); ?>"></td>
                                        </tr>
                                        <tr>
                                        <?php
                                            $nbacc = 0;
                                            foreach ($typesaccessoire as $type){
                                                echo "<td align='left' valign='top' width='200' class='gridbg'>";
                                                $accessoires = $type->getAccessoireByType($type->getIdtypeacc());
                                                echo "<table class='soria'>";
                                                echo "<tr><td width='100%'>&nbsp;</td><td>&nbsp;</td>";
                                                foreach ($accessoires as $acc){
                                                    echo "<tr><td width='100%'>";
                                                    echo "<span>".$acc->getTitle()."</span>";
                                                    echo "</td>";
                                                    echo "<td>";
                                                    echo "<input dojoType='dijit.form.CheckBox' type='radio' name='acc_".$acc->getIdacc()."_type".$type->getIdtypeacc()."' id='acc_".$nbacc."' value='".$acc->getIdacc()."'>";
                                                    echo "</td></tr>";
                                                    $nbacc++;
                                                }
                                                echo "<tr><td width='100%'>&nbsp;</td><td>&nbsp;</td>";
                                                echo "</table>";
                                                echo"</td><td width='10'>&nbsp;</td>";
                                            }
                                        ?>
                                        </tr>
                                    </table>
                                    <input type="hidden" name="nbacc" id="nbacc" value="<?php echo $nbacc; ?>"/>
                                    <br/><br/>
                                    <p>
                                        <table>
                                            <tr>
                                                <td width="10" valign="top" style="padding-top: 4px;"><img src="/car/web/images/fleche_grey.png"/></td>
                                                <td width="3"></td>
                                                <td valign="top"><span style="font-family: TAHOMA;">Cliquez sur <b>&laquo;Suivant&raquo;</b> pour attacher les photos de votre véhicule à votre annonce, ou sur le bouton <b>&laquo;Terminer&raquo;</b> pour enregistrer votre annonce </span></td>
                                            </tr>
                                        </table>
                                    </p>
                                    <br/><br/>
                                    <table id="buttonsBlockAcc">
                                        <tr>
                                            <td><div id="carBack1" onclick="javascript:commun.showPhotosBlock()"><label class="buttonLabel">Annuler</label></div></td>
                                            <td></td>
                                            <td><div id="carBack1" onclick="javascript:commun.hideAccBlock()"><label class="buttonLabel">&laquo; Retour</label></div></td>
                                            <td></td>
                                            <td><div id="carSuivant2" onclick="javascript:commun.showPhotosBlock()"><label class="buttonLabel">Suivant &raquo;</label></div></td>
                                            <td></td>
                                            <td><div id="carTerminer" onclick="javascript:commun.sendForm('annonceAuto')"><label class="buttonLabel">Terminer</label></div></td>
                                        </tr>
                                    </table>
                                    <br/><br/>
                                </div>
                                <div id="blockPhotos" style="display: none;">
                                    <br/><br/>
                                    <table>
                                        <tr>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;cursor: pointer"><center>Informations<br/> sur le v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;cursor: pointer"><center>Options <br/> du v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="actifstep" style="width: 154px;height: 52px;cursor: pointer"><center>Photos <br/> du v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;cursor: pointer"><center>Services <br/> PauseAuto</center></div></td>
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
                                                            <td><span style="font-family: TAHOMA;">Cliquez sur l'ic&ocirc;ne de recherche pour charger vos images.</span></td>
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
                                        <br/>
                                        <div id="slideshow">                                       
                                            <!--<div class="pikachoose">
                                                <ul id="pikame">
                                                        <li><a href="/car/web/uploads/annonces/0514988146.jpg"><img src="/car/web/uploads/annonces/0514988146.jpg" alt="" /></a></li>
                                                        <li><a href="/car/web/uploads/annonces/0503976711.jpg"><img src="/car/web/uploads/annonces/0503976711.jpg" alt="" /></a></li>
                                                        <li><a href="/car/web/uploads/annonces/0573146961.jpg"><img src="/car/web/uploads/annonces/0573146961.jpg" alt="" /></a></li>
                                                </ul>
                                                <div>
                                                    <input type="hidden" id="img_1" value="/car/web/uploads/annonces/0514988146.jpg"/>
                                                    <input type="hidden" id="img_2" value="/car/web/uploads/annonces/0503976711.jpg"/>
                                                    <input type="hidden" id="img_3" value="/car/web/uploads/annonces/0573146961.jpg"/>
                                                </div>
                                            </div>-->
                                        </div>
                                    </fieldset>
                                    <br/>
                                    <p>
                                        <table>
                                            <tr>
                                                <td width="10" valign="top" style="padding-top: 4px;"><img src="/car/web/images/fleche_grey.png"/></td>
                                                <td width="3"></td>
                                                <td valign="top"><span style="font-family: TAHOMA;">Vous avez finis de saisir le formulaire vous pouvez cliquer sur le bouton <b>&laquo;Terminer&raquo;</b> pour valider votre annonce ou sur le bouton <b>&laquo;Suivant&raquo;</b> pour découvrir les services <span style="font-weight: bold;color:#C61B00">PauseAuto</span></b></span></td>
                                            </tr>
                                        </table>
                                    </p>
                                    <br/><br/>
                                    <table id="buttonsBlockPhotos">
                                            <tr>
                                                <td><div id="carBack1" onclick="javascript:commun.showMsgBlock()"><label class="buttonLabel">Annuler</label></div></td>
                                                <td></td>
                                                <td><div id="carBack1" onclick="javascript:commun.hidePhotosBlock()"><label class="buttonLabel">&laquo; Retour</label></div></td>
                                                <td></td>
                                                <td><div id="carValider" onclick="javascript:commun.showServicesBlock()"><label class="buttonLabel">Suivant &raquo;</label></div></td>
                                                <td></td>
                                                <td><div id="carTerminer" onclick="javascript:commun.sendForm('annonceAuto')"><label class="buttonLabel">Terminer</label></div></td>
                                            </tr>
                                    </table>
                                </div>
                                <div id="blockServices" style="display: none;">
                                    <br/><br/>
                                    <table>
                                        <tr>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;cursor: pointer"><center>Informations<br/> sur le v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;cursor: pointer"><center>Options <br/> du v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="inactifstep" style="width: 156px;height: 52px;cursor: pointer"><center>Photos <br/> du v&eacute;hicule</center></div></td>
                                            <td width="5"></td>
                                            <td><div class="actifstep" style="width: 154px;height: 52px;cursor: pointer"><center>Services <br/> PauseAuto</center></div></td>
                                        </tr>
                                    </table>
                                    
                                    <div style="background: url(/car/web/images/slider.jpg) no-repeat center center;width: 630px;height: 71px;padding-top: 30px;">
                                        <span style="font-family: TAHOMA;color: #6a6a6a;font-size: 12pt;padding-left: 10px;"><span style="font-weight: bold;">Services PauseAuto </span></span>
                                    </div>                                    
                                    <br/>
                                    <p>
                                        <table>
                                            <tr>
                                                <td width="10" valign="top" style="padding-top: 4px;"><img src="/car/web/images/fleche_grey.png"/></td>
                                                <td width="3"></td>
                                                <td valign="top"><span style="font-family: TAHOMA;">Vous avez finis de saisir le formulaire vous pouvez cliquer sur le bouton <b>&laquo;Terminer&raquo;</b> pour valider votre annonce</span></td>
                                            </tr>
                                        </table>
                                    </p>
                                    <br/>
                                    <table cellpadding="0" cellspacing="0" border="0" height="388">
                                        <tr>
                                            <td width="195" class="pricingL" valign="top">
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" height="100%">
                                                    <tr height="37">
                                                        <td><br style="line-height: 37px;"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" style="padding-left: 25px;padding-top: 10px;">
                                                            <span style="font-weight: bold;font-family: tahoma;font-size: 12Pt;color : #d91515;">Premium Plus</span>
                                                            <br/>
                                                            <span style="font-family: tahoma;font-size: 8pt;">Gratuit</span>
                                                        </td>
                                                    </tr>
                                                    <tr height="151">
                                                        <td valign="top" style="padding-left: 25px;">
                                                            <table cellpadding="0" cellspacing="0" border="0">
                                                                <tr style="height: 30px;">
                                                                    <td width="191">
                                                                        test
                                                                    </td>
                                                                </tr>
                                                                <tr style="height: 30px;">
                                                                    <td width="191">
                                                                        test
                                                                    </td>
                                                                </tr>
                                                                <tr style="height: 30px;">
                                                                    <td width="191">
                                                                        test
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr height="56">
                                                        <td class="soria" align="center"><input dojoType="dijit.form.RadioButton" type="radio" name="serviceP" id="serviceBasic" value="1"></td>
                                                    </tr>
                                                    <tr height="26">
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="217" class="pricingM">
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" height="100%">
                                                    <tr height="75">
                                                        <td style="padding-left: 15px;padding-top: 5px;">
                                                            <span style="font-weight: bold;font-family: tahoma;font-size: 12Pt;color : #d91515;">Professionnel</span>
                                                            <br/>
                                                            <span style="font-family: tahoma;font-size: 8pt;">Gratuit</span>
                                                            
                                                        </td>
                                                    </tr>
                                                    <tr height="20">
                                                        <td style="padding-left: 15px;padding-top: 5px;">
                                                            &nbsp;
                                                        </td>
                                                    </tr>   
                                                    <tr height="151">
                                                        <td valign="top" style="padding-left: 15px;">
                                                            <table cellpadding="0" cellspacing="0" border="0">
                                                                <tr style="height: 30px;">
                                                                    <td width="191">
                                                                        <table width="100%"><tr><td width="14"><img src="/car/web/images/bullet.png"/></td><td style="padding-left: 5px;">Test</td></tr></table><center><img width="70" src="/car/web/images/slider.jpg"/></center>
                                                                    </td>
                                                                </tr>
                                                                <tr style="height: 30px;">
                                                                    <td width="191">
                                                                        test
                                                                    </td>
                                                                </tr>
                                                                <tr style="height: 30px;">
                                                                    <td width="191">
                                                                        test
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr height="98">
                                                        <td class="soria" align="center"><br style="line-height: 98px;"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="soria" align="center"><input dojoType="dijit.form.RadioButton" type="radio" name="serviceP" id="servicePro" value="1"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="196" class="pricingR">
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" height="100%">
                                                    <tr height="37">
                                                        <td><br style="line-height: 37px;"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" style="padding-left: 15px;padding-top: 10px;">
                                                            <span style="font-weight: bold;font-family: tahoma;font-size: 12Pt;color : #d91515;">Basic</span>
                                                            <br/>
                                                            <span style="font-family: tahoma;font-size: 8pt;">Gratuit</span>
                                                        </td>
                                                    </tr>
                                                    <tr height="151">
                                                        <td valign="top" style="padding-left: 15px;">
                                                            <table cellpadding="0" cellspacing="0" border="0">
                                                                <tr style="height: 30px;">
                                                                    <td width="191">
                                                                        test
                                                                    </td>
                                                                </tr>
                                                                <tr style="height: 30px;">
                                                                    <td width="191">
                                                                        test
                                                                    </td>
                                                                </tr>
                                                                <tr style="height: 30px;">
                                                                    <td width="191">
                                                                        test
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr height="56">
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr height="26">
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <br/>
                                    <p>
                                        <table>
                                            <tr>
                                                <td width="10" valign="top" style="padding-top: 4px;"><img src="/car/web/images/fleche_grey.png"/></td>
                                                <td width="3"></td>
                                                <td valign="top"><span style="font-family: TAHOMA;">Vous avez finis de saisir le formulaire vous pouvez cliquer sur le bouton <b>&laquo;Terminer&raquo;</b> pour valider votre annonce</span></td>
                                            </tr>
                                        </table>
                                    </p>
                                    <br/><br/>
                                    <table id="buttonsBlockServices">
                                            <tr>
                                                <td><div id="carBack1" onclick="javascript:commun.showMsgBlock()"><label class="buttonLabel">Annuler</label></div></td>
                                                <td></td>
                                                <td><div id="carBack1" onclick="javascript:commun.hideServicesBlock()"><label class="buttonLabel">&laquo; Retour</label></div></td>
                                                <td></td>
                                                <td><div id="carTerminer" onclick="javascript:commun.sendForm('annonceAuto')"><label class="buttonLabel">Terminer &raquo;</label></div></td>
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
                                <td width="10" valign="top" style="padding-top: 4px;"><img src="/car/web/images/red_fleche.png"/></td>
                                <td width="3"></td>
                                <td valign="top"><span style="font-family: TAHOMA;">Plus vous attachez de photos &aacute; votre annonce plus vous mettez en valeur votre voiture.</span></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding-top: 4px;"><img src="/car/web/images/red_fleche.png"/></td>
                                <td></td>
                                <td valign="top"><span style="font-family: TAHOMA;">Ne surchargez pas votre annonce avec des accessoires que votre voiture ne poss&egrave;de pas au risque de perdre votre cr&eacute;dibilit&eacute;.</span></td>
                            </tr>
                            <tr>
                                <td valign="top" style="padding-top: 4px;"><img src="/car/web/images/red_fleche.png"/></td>
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