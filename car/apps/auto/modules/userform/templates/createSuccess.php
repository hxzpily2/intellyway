<link rel="stylesheet" href="/car/web/js/jqtransform/jqtransformplugin/jqtransform.css" type="text/css" media="all" />



<script type="text/javascript" src="/car/web/js/jqtransform/jqtransformplugin/jquery.jqtransform.js" ></script>
<script language="javascript">

	
	dojo.addOnLoad(
	  function(){		  
		  dojo.style(dojo.byId('errorNom'), 'opacity', .0);
		  dojo.style(dojo.byId('errorPrenom'), 'opacity', .0);
		  dojo.style(dojo.byId('errorLogin'), 'opacity', .0);
		  dojo.style(dojo.byId('errorPassword'), 'opacity', .0);
		  dojo.style(dojo.byId('errorConfpassword'), 'opacity', .0);
		  dojo.style(dojo.byId('errorEmail'), 'opacity', .0);        
		  dojo.style(dojo.byId('errorTel'), 'opacity', .0);
		  dojo.style(dojo.byId('errorCondition'), 'opacity', .0);
		  dojo.style(dojo.byId('errorCondition'), 'display', 'none');
		  /*dojo.connect(dojo.byId('myButton'), "onclick", function(e){
			  doAnimation(1);
		  });*/
	  }
	);
				
	
	function doAnimation(index) {
	    switch(index) {
	      case 1:
	        currentAnimation = fadeOut;
	        break;
	      case 2: 
	        currentAnimation = fadeIn;
	        break;
	      case 3:
	        //Chain two animations to run in sequence.
	        //Note the array passed as an argument.
	        currentAnimation = dojo.fx.chain([fadeOut, fadeIn]);
	        break;
	    }
	    //Play the animation. Without this call, it will not run.
	    currentAnimation.play();
	  }
			
	$(function(){
		$("form#userform").jqTransform({imgPath:'/car/web/js/jqtransform/jqtransformplugin/img/'});
	});
	
	$(function(){
		 $('.hover-star').rating({
		  focus: function(value, link){
		    // 'this' is the hidden form element holding the current value
		    // 'value' is the value selected
		    // 'element' points to the link element that received the click.
		    var tip = $('#hover-test');
		    tip[0].data = tip[0].data || tip.html();
		    tip.html(link.title || 'value: '+value);
		  },
		  blur: function(value, link){
		    var tip = $('#hover-test');
		    $('#hover-test').html(tip[0].data || '');
		  }
		 });
		});

	   
	      $(document).ready(function() {
	         /*$("#userform").validationEngine({
		         scroll:true,
		         ajaxSubmit: true,
				 ajaxSubmitFile: "ajaxSubmit.php",
				 ajaxSubmitMessage: "Thank you, we received your inscription!",
				 success :  function() {alert('ok')},
				 failure : function() {}
			         
		     });*/		   
	      });

	      function runEffect() {
		      	
				// get effect type from 
				var selectedEffect = 'blind';

				// most effect types need no options passed by default
				var options = {};
				// some effects have required parameters
				if ( selectedEffect === "scale" ) {
					options = { percent: 100 };
				} else if ( selectedEffect === "size" ) {
					options = { to: { width: 280, height: 185 } };
				}

				// run the effect
				$( "#effect" ).show( selectedEffect, options, 500, callback );
			};

			function callback() {
				setTimeout(function() {
					$( "#effect:visible" ).removeAttr( "style" ).fadeOut();
				}, 1000 );
			};
					

			    
	
</script>
	




<form action="post.php" method="POST" id="userform" class="formular">	
	<table>
		<tr>
			<td><label>Vous &ecirc;tes ?</label></td>
			<td></td>
			<td>
				<div class="rowElem">										
					<select id="profil" name="profil" >						
						<option value="<?php echo Constantes::PROFIL_USER;?>">Un particulier</option>
						<option value="<?php echo Constantes::PROFIL_CONC;?>">Un concessionnaire</option>
						<option value="<?php echo Constantes::PROFIL_PROF;?>">Un professionnel</option>						
					</select>
				</div>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></div></td>
		</tr>
		<tr>
			<td><label><?php echo __('Nom') ?> :</label></td>
			<td></td>
			<td>
				<div class="rowElem"><input id="nom" name="nom" class="validate[required]" type="text" /></div>																				
			</td>
		</tr>
		<tr id="errorNom" style="display: none;">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>			
				<div><span style="color: red;font-family: TAHOMA;">Le nom est obligatoire</span></div>																
			</td>
		</tr>						
		<tr>
			<td><label>Prenom:</label></td>
			<td></td>
			<td>
				<div class="rowElem"><input id="prenom" name="prenom" class="validate[required]" type="inputtext" /></div>				
			</td>
		</tr>
		<tr id="errorPrenom" style="display: none;">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>			
				<div><span style="color: red;font-family: TAHOMA;">Le prenom est obligatoire</span></div>																
			</td>
		</tr>
		<tr>
			<td><label>Login:</label></td>
			<td></td>
			<td>
				<div class="rowElem"><input id="login" name="login" class="validate[required,custom[noSpecialCaracters],ajax[ajaxUser]]" type="inputtext" /></div>				
			</td>
		</tr>
		<tr id="errorLogin" style="display: none;">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>			
				<div><span style="color: red;font-family: TAHOMA;">Le login est obligatoire</span></div>																
			</td>
		</tr>
		<tr>
			<td><label>Password:</label></td>
			<td></td>
			<td>
				<div class="rowElem"><input id="passwordd" name="passwordd" class="validate[required,custom[noSpecialCaracters]]" type="password" /></div>								
			</td>
		</tr>
		<tr id="errorPassword" style="display: none;">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>			
				<div><span style="color: red;font-family: TAHOMA;">Le password est obligatoire</span></div>																
			</td>
		</tr>
		<tr>
			<td><label>Confirmer password:</label></td>
			<td></td>
			<td>
				<div class="rowElem"><input id="confpassword" name="confpassword" class="validate[required,custom[noSpecialCaracters]]" type="password" /></div>								
			</td>
		</tr>
		<tr id="errorConfpassword" style="display: none;">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>			
				<div><span style="color: red;font-family: TAHOMA;">Le password est invalide</span></div>																
			</td>
		</tr>
		<tr>
			<td><label>E-mail:</label></td>
			<td></td>
			<td>
				<div class="rowElem"><input id="email" name="email" class="validate[required,custom[email],ajax[ajaxUser]]" style="width: 200px;" type="inputtext" /></div>				
			</td>
		</tr>
		<tr id="errorEmail" style="display: none;">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>			
				<div><span style="color: red;font-family: TAHOMA;">L'adresse mail est invalide</span></div>																
			</td>
		</tr>
		<tr>
			<td><label>Tel:</label></td>
			<td></td>
			<td>
				<div class="rowElem"><input id="tel" name="tel" class="validate[required,custom[telephone]]" type="inputtext" /></div>				
			</td>
		</tr>
		<tr id="errorTel" style="display: none;">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>			
				<div><span style="color: red;font-family: TAHOMA;">Le num&eacute;ro de t&eacute;l&eacute;phone est invalide</span></div>																
			</td>
		</tr>
	</table>
	<table width="500">
		<tr>
			<td valign="middle">
				<div class="rowElem"><input id="condition" type="checkbox" ></div>		
			</td>					
			<td valign="middle">
				<label>J'ai lu et j'accepte  <b>les conditions g&eacute;n&eacute;rales d'utilisation de</b></label>	
			</td>
		</tr>
		<tr id="errorCondition" style="display: none;">
			<td valign="middle">
				&nbsp;		
			</td>
			<td > 
				<span style="color: red;font-family: TAHOMA;">Vous n'avez pas acc&eacute;pter les termes d'utilisations</span>	
			</td>
		</tr>
		<tr>
			<td valign="middle">
				<div class="rowElem"><input type="checkbox" ></div>			
			</td>						
			<td valign="middle">
				<label>J'accepte de recevoir des annonces qui pourraient m'interesser</label>	
			</td>
		</tr>
		<tr>
			<td valign="middle">
				<div class="rowElem"><input type="checkbox" name="chbox" id="chbox"></div>
			</td>			
			<td valign="middle">
				<label>Je m'abonne &agrave; votre newsletter </label>
			</td>
		</tr>
	</table>	
	
	
	<!-- <div class="rowElem"><label>Checkbox: </label><input type="checkbox" name="chbox" id=""></div>
	<div class="rowElem"><label>Radio :</label> 
		<input type="radio" id="" name="question" value="oui" checked ><label>oui</label>
		<input type="radio" id="" name="question" value="non" ><label>non</label></div>
	<div class="rowElem"><label>Textarea :</label> <textarea cols="40" rows="12" name="mytext"></textarea></div>

	<div class="rowElem">
		<label>Select :</label>
		<select name="select">
			<option value="">1&nbsp;</option>
			<option value="opt1">2&nbsp;</option>
		</select>
	</div>
	<div class="rowElem">
		<label>Select Redimentionn&eacute; :</label>
		<select name="select2" >
			<option value="opt1">Big Option test line with more wordssss</option>
			<option value="opt2">Option 2</option>
			<option value="opt3">Option 3</option>
			<option value="opt4">Option 4</option>
			<option value="opt5">Option 5</option>
			<option value="opt6">Option 6</option>
			<option value="opt7">Option 7</option>
			<option value="opt8">Option 8</option>
		</select>
	</div>
	
	<div class="rowElem"><label>Submit button:</label><input type="submit" value="Envoyer" /></div>
	<div class="rowElem"><label>Reset button:</label><input type="reset" value="Annuler" /></div>
	<div class="rowElem"><label>Input button:</label><input type="button" value="bouton" /></div> -->
			
</form>

<a class="medium blue awesome" onclick="javascript:commun.createUser()">Valider &raquo;</a>
<!-- <input id="myButton" type="button" value="Valider" onclick="commun.createUser()" />  -->

<div id="effect" style="display: none;">
	test
</div>	
	<!-- <div id="effect" class="ui-widget-content ui-corner-all">
		<h3 class="ui-widget-header ui-corner-all">Show</h3>
		<p>
			Etiam libero neque, luctus a, eleifend nec, semper at, lorem. Sed pede. Nulla lorem metus, adipiscing ut, luctus sed, hendrerit vitae, mi.
		</p>
	</div>  -->




	<!-- <div class="Clear">    
    <input class="star {split:2}" type="radio" name="test-4-rating-3" value="0.5"/>
    <input class="star {split:2}" type="radio" name="test-4-rating-3" value="1.0"/>
    <input class="star {split:2}" type="radio" name="test-4-rating-3" value="1.5"/>
    <input class="star {split:2}" type="radio" name="test-4-rating-3" value="2.0"/>
    <input class="star {split:2}" type="radio" name="test-4-rating-3" value="2.5"/>
    <input class="star {split:2}" type="radio" name="test-4-rating-3" value="3.0"/>
    <input class="star {split:2}" type="radio" name="test-4-rating-3" value="3.5" checked="checked"/>
    <input class="star {split:2}" type="radio" name="test-4-rating-3" value="4.0"/>
    <input class="star {split:2}" type="radio" name="test-4-rating-3" value="4.5"/>
    <input class="star {split:2}" type="radio" name="test-4-rating-3" value="5.0"/>
   </div> -->
	
				
				
	

