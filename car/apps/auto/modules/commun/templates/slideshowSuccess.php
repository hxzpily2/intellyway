<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
echo count($files);
if(count($files)>0){
?>
    <hr width=100% size="1" color="" align="center">
    <br/>
    <p>
        <table>
            <tr>
                <td width="10"><img src="/car/web/images/fleche_grey.png"/></td>
                <td width="3"></td>
                <td><span style="font-family: TAHOMA;">Visualisez et editez vos photos : </span></td>
            </tr>
        </table>
    </p>
    <br/>
    <ul class="hoverbox">
        <?php
        for($i=0;$i<count($files);$i++){
        ?>
        <li>
            <a class="fancyauto" href="/car/web/uploads/annonces/0514988146.jpg"><img src="/car/web/uploads/annonces/0514988146.jpg" alt="description" /><img src="/car/web/uploads/annonces/0514988146.jpg" alt="description" class="preview" /></a>
            <br/>
            <a href="#" style="cursor: pointer;color:#C61B00" >Supprimer</a>
        </li>
        <?php
        }
        ?>        
    </ul>
<?php
}
?>
<!--<textarea>{'status':'success',details: {name:'',size:}}</textarea>-->

