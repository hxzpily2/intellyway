<script language="javascript">
    dojo.addOnLoad(
	  function(){
                
          });
</script>

<div id="autoDiv">
    <br/><br/>
    <span style="font-family: TAHOMA;font-weight: bold;color: #C61B00;">Voici quelques conseils pour rendre votre annonce de plus en plus attirante vis à vis des futurs acheteurs :</span>
    <br/><br/>
    <table>
        <tr>
            <td width="10"><img src="/car/web/images/fleche_grey.png"/></td>
            <td width="3"></td>
            <td><span style="font-family: TAHOMA;color: #848484;">Plus vous attachez de photos &aacute; votre annonce plus vous mettez en valeur votre voiture.</span></td>
        </tr>
        <tr>
            <td><img src="/car/web/images/fleche_grey.png"/></td>
            <td></td>
            <td><span style="font-family: TAHOMA;color: #848484;">Ne surchargez pas votre annonce avec des accessoires que votre voiture ne possède pas au risque de perdre votre cr&eacute;dibilit&eacute;.</span></td>
        </tr>
        <tr>
            <td><img src="/car/web/images/fleche_grey.png"/></td>
            <td></td>
            <td><span style="font-family: TAHOMA;">Il est pr&eacute;f&eacute;rable que votre message soit clair et décrive tous les aspects de votre voiture (l'état du salon, son historique, son conducteur...) </span></td>
        </tr>
    </table>
    <br/>
    <center><span style="font-family: TAHOMA;font-weight: bold;color: #C61B00;padding-right:20px;">Bonne vente !</span></center>
    <br/>
    <span style="font-family: TAHOMA;color: #b7b7b7;">Votre adresse IP : <span style="font-weight: bold;"><?php echo $_SERVER['REMOTE_ADDR']; ?></span></span>
    <br/><br/>
    <img style="padding-left: 10px;" src=""/>
    <br/><br/>
    <form id="autoForm">
        <table width="800">
            <tr>
                <td><img src="/car/web/images/fleche3.png"/></td>
                <td align="left" width="200"><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Marque</span></td>
                <td width="5"></td>
                <td align="left">
                    <div>
                        <input type="text" id="car_auto[idmarque]" name="car_auto[idmarque]" size="20"/>
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
                    <select id="car_auto[idmodele]" name="car_auto[idmodele]" >
                            <option value="<?php echo Constantes::PROFIL_USER;?>">&nbsp;</option>
                            <option value="<?php echo Constantes::PROFIL_USER;?>">Un particulier</option>
                            <option value="<?php echo Constantes::PROFIL_CONC;?>">Un concessionnaire</option>
                            <option value="<?php echo Constantes::PROFIL_PROF;?>">Un professionnel</option>
                            <option value="<?php echo Constantes::PROFIL_LOC;?>">Une agence de location</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
            </tr>
            <tr>
                <td><img src="/car/web/images/fleche3.png"/></td>
                <td align="left"><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Etat</span></td>
                <td width="5"></td>
                <td align="left"><?php echo $form['idetat']->render(); ?></td>
            </tr>
            <tr>
                <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
            </tr>
            <tr>
                <td><img src="/car/web/images/fleche3.png"/></td>
                <td align="left"><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Carrosserie</span></td>
                <td width="5"></td>
                <td align="left">
                    <select id="car_auto[idetat]" name="car_auto[idetat]" >
                            <option value="<?php echo Constantes::PROFIL_USER;?>">&nbsp;</option>
                            <option value="<?php echo Constantes::PROFIL_USER;?>">Un particulier</option>
                            <option value="<?php echo Constantes::PROFIL_CONC;?>">Un concessionnaire</option>
                            <option value="<?php echo Constantes::PROFIL_PROF;?>">Un professionnel</option>
                            <option value="<?php echo Constantes::PROFIL_LOC;?>">Une agence de location</option>
                    </select>
                </td>
            </tr>            
            <tr>
                <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
            </tr>
            <tr>
                <td><img src="/car/web/images/fleche3.png"/></td>
                <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Moteur</span></td>
                <td width="5"></td>
                <td><?php echo $form['idcarosserie']->render(); ?></td>
            </tr>
            <tr>
                <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
            </tr>
            <tr>
                <td><img src="/car/web/images/fleche3.png"/></td>
                <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Ann&eacute;e de mise en circulation</span></td>
                <td width="5"></td>
                <td><?php echo $form['idcarosserie']->render(); ?></td>
            </tr>
            <tr>
                <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
            </tr>
            <tr>
                <td><img src="/car/web/images/fleche3.png"/></td>
                <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Kilom&eacute;trage</span></td>
                <td width="5"></td>
                <td><?php echo $form['idcarosserie']->render(); ?></td>
            </tr>
            <tr>
                <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
            </tr>
            <tr>
                <td><img src="/car/web/images/fleche3.png"/></td>
                <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Bo&icirc;te de vitesse</span></td>
                <td width="5"></td>
                <td><?php echo $form['idcarosserie']->render(); ?></td>
            </tr>
            <tr>
                <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
            </tr>
            <tr>
                <td><img src="/car/web/images/fleche3.png"/></td>
                <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Puissance fiscale</span></td>
                <td width="5"></td>
                <td><?php echo $form['idcarosserie']->render(); ?></td>
            </tr>
            <tr>
                <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
            </tr>
            <tr>
                <td><img src="/car/web/images/fleche3.png"/></td>
                <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Cylindres</span></td>
                <td width="5"></td>
                <td><?php echo $form['idcarosserie']->render(); ?></td>
            </tr>
            <tr>
                <td colspan="4" style="height: 10px;background-image: url(/car/web/images/pixeldot.png)">&nbsp;</td>
            </tr>
            <tr>
                <td><img src="/car/web/images/fleche3.png"/></td>
                <td><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Nombre de portes</span></td>
                <td width="5"></td>
                <td><?php echo $form['idcarosserie']->render(); ?></td>
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
                <td colspan="3"><span style="font-family: TAHOMA;font-weight: normal;color: #C61B00;">Ma voiture a été importée de l'ext&eacute;rieur :</span></td>
            </tr>
        </table>
    </form>
    <br/><br/><br/>
    <?php


    ?>
</div>