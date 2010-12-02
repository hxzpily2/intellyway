<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta name="gmapkey" content="" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />

	<title></title>

	<link rel="stylesheet" href="/car/web/js/jqtransform/jqtransformplugin/jqtransform.css" type="text/css" media="all" />
	
	
	
	<script type="text/javascript" src="/car/web/js/jqtransform/jqtransformplugin/jquery.jqtransform.js" ></script>
	<script language="javascript">
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
		         $("#userform").validationEngine({scroll:true});		   
		      });

				    
		
	</script>
	
</head>
<body>


<form action="post.php" method="POST" id="userform" class="formular">	
	<table>
		<tr>
			<td><label>Vous &ecirc;tes ?</label></td>
			<td></td>
			<td>
				<div class="rowElem">										
					<select id="profil" name="profil" >
						<option value="">&nbsp;</option>
						<option value="<?php echo Constantes::PROFIL_USER;?>">Un particulier</option>
						<option value="<?php echo Constantes::PROFIL_USER;?>">Un concessionnaire</option>
						<option value="<?php echo Constantes::PROFIL_USER;?>">Un professionnel</option>						
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
			<td><label>Nom:</label></td>
			<td></td>
			<td><div class="rowElem"><input id="nom" name="nom" class="validate[required]" type="text" /></div></td>
		</tr>		
		<tr>
			<td><label>Prenom:</label></td>
			<td></td>
			<td><div class="rowElem"><input id="prenom" name="prenom" class="validate[required]" type="inputtext" /></div></td>
		</tr>
		<tr>
			<td><label>Login:</label></td>
			<td></td>
			<td><div class="rowElem"><input id="login" name="login" class="validate[required,custom[noSpecialCaracters],ajax[ajaxUser]]" type="inputtext" /></div></td>
		</tr>
		<tr>
			<td><label>Password:</label></td>
			<td></td>
			<td><div class="rowElem"><input id="password" name="password" class="validate[required,custom[noSpecialCaracters]]" type="password" /></div></td>
		</tr>
		<tr>
			<td><label>Confirmer password:</label></td>
			<td></td>
			<td><div class="rowElem"><input id="confpassword" name="confpassword" class="validate[required,custom[noSpecialCaracters]]" type="password" /></div></td>
		</tr>
		<tr>
			<td><label>E-mail:</label></td>
			<td></td>
			<td><div class="rowElem"><input id="email" name="email" class="validate[required,custom[email],ajax[ajaxUser]]" style="width: 200px;" type="inputtext" /></div></td>
		</tr>
		<tr>
			<td><label>Tel:</label></td>
			<td></td>
			<td><div class="rowElem"><input id="tel" name="tel" class="validate[required,custom[telephone]]" type="inputtext" /></div></td>
		</tr>
	</table>
	<table width="500">
		<tr>
			<td valign="middle">
				<div class="rowElem"><input type="checkbox" ></div>		
			</td>					
			<td valign="middle">
				<label>J'ai lu et j'accepte  <b>les conditions g&eacute;n&eacute;rales d'utilisation de</b></label>	
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
	
	
	<input class="submit" type="submit" value="Valider"/>
	
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
	
				
				
	
</body>
</html>