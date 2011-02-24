<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title>PauseAuto</title>
<head>
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>
<?php
$sf_user->setAttribute(Constantes::LASTMODULENAME,$sf_context->getModuleName());
$sf_user->setAttribute(Constantes::LASTACTIONNAME,$sf_context->getActionName());
$user = $sf_user->getAttribute ( 'user_id',NULL, 'sfGuardSecurityUser' );

$remember = sfContext::getInstance()->getRequest()->getCookie(Constantes::COOKIE_REMEMBER_CHECKED);

$isLogged = TRUE;
$isRemember = "";
if($user!="")
    $isLogged = FALSE;
if($remember!="")
    $isRemember = "checked";
?>  
<link rel="icon" type="image/png" href="/car/web/images/faveicon.png" />
<!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="/car/web/images/faveicon.ico" /><![endif]-->

<link rel="stylesheet" type="text/css" href="/car/web/js/ext/resources/css/ext-all.css" />
<link rel="stylesheet" type="text/css" href="/car/web/js/ext/resources/css/xtheme-gray.css" />

<!-- GC -->
    <!-- LIBS -->
    <script type="text/javascript" src="/car/web/js/ext/adapter/ext/ext-base.js"></script>
    <!-- ENDLIBS -->

<script type="text/javascript" src="/car/web/js/ext/ext-all.js"></script>



<link href="/car/web/css/dropdown/dropdown.css" media="all" rel="stylesheet" type="text/css" />
<link href="/car/web/css/dropdown/themes/default/default.ultimate.css" media="all" rel="stylesheet" type="text/css" />


<link href="/car/web/css/dropdown.css" media="screen, projection" rel="stylesheet" type="text/css">
<link href="/car/web/css/front.css" media="screen, projection" rel="stylesheet" type="text/css">
<!--[if IE]><link href="/car/web/css/frontie.css" media="screen, projection" rel="stylesheet" type="text/css"><![endif]-->
<script src="/car/web/js/jquery/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/car/web/js/jquery/jquery.corner.js"></script>

<script type="text/javascript" src="/car/web/js/jquery/jquery.nyroModal-1.5.5.pack.js"></script>
<link href='/car/web/js/jquery/nyroModal.css' type="text/css" rel="stylesheet" />

<!-- RATING --> 
<script src='/car/web/js/jquery/jquery.MetaData.js'	type="text/javascript" language="javascript"></script>
<script	src='/car/web/js/jquery/jquery.rating.js' type="text/javascript" language="javascript"></script>
<link href='/car/web/css/jquery.rating.css' type="text/css" rel="stylesheet" />
<!-- FIN RATING -->


<script type="text/javascript" src="/car/web/js/jquery/jquery.hoverIntent.minified.js"></script>




<script type="text/javascript" src="/car/web/js/car/menu.js"></script>
<script type="text/javascript" src="/car/web/js/car/shadedborder.js"></script>
<!-- DOJO -->
<style type='text/css'>
@import '/car/web/js/dojo/dijit/themes/soria/soria.css';

@import '/car/web/js/dojo/resources/dojo.css';

html,body {
	height: 100%;
	width: 100%;
	padding: 0;
	border: 0;
}

</style>
<!--[if lt IE 7]><style>
/* style for IE 6 + IE5.5 + IE5.0 */ 
.gainlayout { height: 0; }
</style><![endif]-->

<!--[if IE 7]><style>
.gainlayout { zoom: 1;}
/* or whatever we might need tomorrow */ 
</style><![endif]-->

<script type='text/javascript'	src='/car/web/js/dojo/dojo/dojo.js'	djConfig='parseOnLoad: true'></script>


<script type='text/javascript'>  
dojo.require('dijit.dijit');
dojo.require('dojo.parser');
dojo.require("dojo.fx");
dojo.require("dojox.validate.web");
dojo.require("dojox.validate._base");

dojo.require('dojo.parser');
dojo.require('dojo.date.locale');

dojo.registerModulePath('car', '../../car');
dojo.require('car.integration.Commun');
var commun = new car.integration.Commun();

dojo.addOnLoad(
  function(){	  
	  /*dojo.connect(dojo.byId('background'), "onmouseover", function(e){
		  dojo.style(dojo.byId('background'), 'opacity', .5);
		  dojo.style(dojo.byId('background'), 'zIndex', 999);
	  });

	  dojo.connect(dojo.byId('background'), "onmouseout", function(e){
		  dojo.style(dojo.byId('background'), 'opacity', 1.0);
		  dojo.style(dojo.byId('background'), 'zIndex', 999);
	  });*/
  }
);
	
</script>
<!-- FIN DOJO --> 
<?php include_stylesheets() ?>
<?php include_javascripts() ?>

</head>
<body>
<!-- <img src="/car/web/images/bg/red-christmas-lights.jpg" alt="" id="background" />  -->
<div>  
	
	
	
	<script type="text/javascript">
	        $(document).ready(function() {
	
	            $(".mySignin").click(function() {
	                $("fieldset#mySignin_menu").toggle();
					$(".mySignin").toggleClass("hover");
	            });
				
				$("fieldset#mySignin_menu").mouseup(function() {
					return false;
				});
				$(".mySignin").mouseover(function(e) {						
						$(".mySignin").toggleClass("hover");											
				});	
				$(document).mouseup(function(e) {
					$("fieldset#mySignin_menu").hide();
				});		
				/*(function($) {
				  $("#background").fullBg();
				})(jQuery);*/
				

				$(".sub").corner();		     
										
				
	        });
	  </script>
	  
		
	<script src="/car/web/js/jquery/jquery.tipsy.js" type="text/javascript"></script>
	<script type='text/javascript'>
	    $(function() {
		  $('#forgot_username_link').tipsy({gravity: 'w'});   
	    });
	  </script>
	
	
	<!-- CONTENT -->
	<div id="maincontent">            
		<div style="width: 100%;z-index: -5">                        
			<div id="topnav" class="topnav" style="background-color: white;">   <?php 
                           if($isLogged){
                           ?>
                           <div class="mySigninLabel">                               
                               <table style="display: inline">
                                   <tr>
                                       <td><img src="/car/web/images/icontexto-inside-facebook.png"/></td>
                                       <td width="10"></td>
                                       <td><img src="/car/web/images/icontexto-inside-twitter.png"/></td>
                                       <td width="100"></td>
                                       <td><a href="/car/web/auto.php/userform/create">Vous avez un compte?</a></td>
                                       <td width="10"></td>
                                       <td><div class="mySignin">Login</div></td>
                                   </tr>
                               </table>
                           </div>			   
                           <?php
                           }else{
                           ?>
                           <div class="mySigninLink">
                               <table>
                                   <tr>
                                       <td><img src="/car/web/images/icontexto-inside-facebook.png"/></td>
                                       <td width="10"></td>
                                       <td><img src="/car/web/images/icontexto-inside-twitter.png"/></td>
                                       <td width="100"></td>                                       
                                       <td style="padding-right: 7px;padding-top: 3px"><a style="text-decoration: underline;" href="/car/web/auto.php/accueil/logout">Mes demandes d&rsquo;&eacute;valuation <b>(3)</b></a></td>
                                       <td style="padding-right: 7px;padding-top: 3px"><a style="text-decoration: underline;" href="/car/web/auto.php/accueil/logout">Mes annonces <b>(5)</b></a></td>
                                       <td style="padding-right: 2px;padding-top: 3px"><a style="text-decoration: underline;" href="/car/web/auto.php/accueil/logout">Mon profil</a></td>                                       
                                       <td><img src="/car/web/images/user-profile.png"/></td>
                                       <td style="padding-left: 7px;padding-right: 2px;padding-top: 3px"><a style="text-decoration: underline;" href="/car/web/auto.php/accueil/logout">Se d&eacute;connecter</a></td>
                                       <td style="padding-top: 4px;"><img src="/car/web/images/xfce-system-exit.png"/></td>
                                   </tr>
                               </table>
                           </div>
                           <?php
                           }
                           ?>
			</div>
			<div id="topMenu">			
			</div>
			<div id="topMenuBg">
				<div id="logo"></div>
			</div>			
			<div id="navigation">
			    <ul id="topnav">
			    	<li>
                                    <div class="item">
                                            <div class="leftItem"><a href="#" title=""></a></div>
                                            <div class="bgItem"><a href="#" title="">Accueil</a></div>
                                            <div class="rightItem"><a href="#" title=""></a></div>
                                    </div>
			        </li>
                                <li>
                                    <div class="item">
                                        <div class="leftItem"><a href="#" title=""></a></div>
                                            <div class="bgItem"><a href="#" title="">Essais</a></div>
                                            <div class="rightItem"><a href="#" title=""></a></div>
                                    </div>
			        </li>
                                <li>
                                    <div class="item">
                                            <div class="leftItem"><a href="#" title=""></a></div>
                                            <div class="bgItem"><a href="#" title="">A l&rsquo;actu</a></div>
                                            <div class="rightItem"><a href="#" title=""></a></div>
                                    </div>
			        </li>
                                <li>
                                    <div class="item">
                                            <div class="leftItem"><a href="#" title=""></a></div>
                                            <div class="bgItem"><a href="#" title="">Argus</a></div>
                                            <div class="rightItem"><a href="#" title=""></a></div>
                                    </div>
			        </li>
                                <li>
                                    <div class="item">
                                            <div class="leftItem"><a href="#" title=""></a></div>
                                            <div class="bgItem"><a href="#" title="">Annonces</a></div>
                                            <div class="rightItem"><a href="#" title=""></a></div>
                                    </div>
                                    <div class="sub">
			            	<ul>
                                            <li><a href="#">D&eacute;poser</a></li>
                                            <li><a href="#">Consulter</a></li>
                                            <li><a href="#">Modifier</a></li>
			                </ul>
			            </div>
			        </li>
                                <li>
                                    <div class="item">
                                            <div class="leftItem"><a href="#" title=""></a></div>
                                            <div class="bgItem"><a href="#" title="">Voitures neuves</a></div>
                                            <div class="rightItem"><a href="#" title=""></a></div>
                                    </div>
			        </li>
                                <li>
                                    <div class="item">
                                            <div class="leftItem"><a href="#" title=""></a></div>
                                            <div class="bgItem"><a href="#" title="">Conseils</a></div>
                                            <div class="rightItem"><a href="#" title=""></a></div>
                                    </div>
			        </li>
                                <li>
                                    <div class="item">
                                            <div class="leftItem"><a href="#" title=""></a></div>
                                            <div class="bgItem"><a href="#" title="">Services</a></div>
                                            <div class="rightItem"><a href="#" title=""></a></div>
                                    </div>
			        </li>
                                <li>
                                    <div class="item">
                                            <div class="leftItem"><a href="#" title=""></a></div>
                                            <div class="bgItem"><a href="#" title="">Assurance</a></div>
                                            <div class="rightItem"><a href="#" title=""></a></div>
                                    </div>
			        </li>
			        <li>
                                    <div class="item">
                                            <div class="leftItem"><a href="#" title=""></a></div>
                                            <div class="bgItem"><a href="#" title="">Products</a></div>
                                            <div class="rightItem"><a href="#" title=""></a></div>
                                    </div>
			            <!--<div class="sub">
			            	<ul>			                	
			                	<li><a href="#">&raquo; Navigation Link</a></li>
			                    <li><a href="#">Navigation Link</a></li>
			                    <li><a href="#">Navigation Link</a></li>
			                    <li><a href="#">Navigation Link</a></li>
			                    <li><a href="#">Navigation Link</a></li>			
			                    <li><a href="#">Navigation Link</a></li>
			                    <li><a href="#">Navigation Link</a></li>
			                </ul>			                			                
			            </div>-->
			        </li>
			        <li>			        	
                                    <div class="item">
                                            <div class="leftItem"><a href="#" title=""></a></div>
                                            <div class="bgItem"><a href="#" title="">Sales</a></div>
                                            <div class="rightItem"><a href="#" title=""></a></div>
                                    </div>
			            <!--<div class="sub">
			            	<div class="row">
			                    <ul style="width: 225px;">			
			                        <li><h2><a href="#">Deal of the Week</a></h2></li>
			                        <li><a href="#">Navigation Link - 2 Column</a></li>
			                        <li><a href="#">Navigation Link - 2 Column</a></li>
			                        <li><a href="#">Navigation Link - 2 Column</a></li>
			                        <li><a href="#">Navigation Link - 2 Column</a></li>
			                    </ul>
			
			                    <ul style="width: 225px;">
			                        <li><h2><a href="#">Clearance Items</a></h2></li>
			                        <li><a href="#">Navigation Link - 2 Column</a></li>
			                        <li><a href="#">Navigation Link - 2 Column</a></li>
			                        <li><a href="#">Navigation Link - 2 Column</a></li>
			                        <li><a href="#">Navigation Link - 2 Column</a></li>
			
			                    </ul>
			                </div>
			                <div class="row">
			                    <ul>
			                        <li><h2><a href="#">Deal of the Week</a></h2></li>
			                        <li><a href="#">Navigation Link</a></li>
			                        <li><a href="#">Navigation Link</a></li>
			
			                        <li><a href="#">Navigation Link</a></li>
			                        <li><a href="#">Navigation Link</a></li>
			                    </ul>
			                    <ul>
			                        <li><h2><a href="#">Clearance Items</a></h2></li>
			                        <li><a href="#">Navigation Link</a></li>
			                        <li><a href="#">Navigation Link</a></li>
			
			                        <li><a href="#">Navigation Link</a></li>
			                        <li><a href="#">Navigation Link</a></li>
			                    </ul>
			                    <ul>
			                        <li><h2><a href="#">Open Box Items</a></h2></li>
			                        <li><a href="#">Navigation Link</a></li>
			                        <li><a href="#">Navigation Link</a></li>
			
			                        <li><a href="#">Navigation Link</a></li>
			                        <li><a href="#">Navigation Link</a></li>
			                    </ul>
			                </div>
			            </div>-->
			        </li>
			        <li>			        	
						<div class="item">
							<div class="curLeftItem"><a href="#" title=""></a></div>
							<div class="curBgItem"><a class="currentItem" href="#" title="">Community</a></div>
							<div class="curRightItem"><a href="#" title=""></a></div>
						</div>
			        </li>
			        <li>			        	
			        	<div class="item">
							<div class="leftItem"><a href="#" title=""></a></div>
							<div class="bgItem"><a href="#" title="">Store Locator</a></div>
							<div class="rightItem"><a href="#" title=""></a></div>
						</div>
			        </li>
			    </ul>
			</div>			
		</div>
		<fieldset id="mySignin_menu">					
			<table width="274" height="226" cellpadding="0" cellspacing="0">
				<tr>
					<td style="background-image:url(/car/web/images/bglogin.png);padding-left: 20px;">
						<form method="post" id="signin" action="/car/web/auto.php/accueil/login">
							<table cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td valign="middle"><img src="/car/web/images/beat.png"/></td>
									<td width="5"></td>
									<td valign="middle"><label for="username">Username or email</label></td>
									<td width="5"></td>
									<td valign="middle"><div style="height: 2px;background-color: #CACACA;width: 80px;">&nbsp;</div></td>
								</tr>
								<tr>
									<td valign="middle" colspan="5"><input id="login" name="login" value="" title="username" tabindex="4" type="text"></td>
								</tr>
								<tr>
									<td valign="middle"><img src="/car/web/images/beat.png"/></td>
									<td width="5"></td>
									<td valign="middle"><label for="password">Password</label></td>
									<td width="5"></td>
									<td valign="middle"><div style="height: 2px;background-color: #CACACA;width: 80px;">&nbsp;</div></td>
								</tr>
								<tr>
									<td valign="middle" colspan="5"><input id="password" name="password" value="" title="password" tabindex="5" type="password"></td>									
								</tr>
							</table>					
							<p class="remember">							
								<input id="mySignin_submit" value="" tabindex="6" type="submit">
								<input id="remember" name="remember_me" value="1" tabindex="7" type="checkbox" <?php echo $isRemember; ?> >
                                                                    <label for="remember">S&rsquo;en souvenir</label>
							</p>
							<p class="forgot">
                                                            <a href="#" id="resend_password_link">Vous avez oubli&eacute; votre mot de passe?</a>
							</p>			
						</form>
					</td>
				</tr>
			</table>
		</fieldset>
		<div style="clear: both;"></div>		
			<!-- <table id="tableMain" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td align="right" width="50%">
						<img src="/car/web/images/bg_right.png" width="12" height="100%"/>
					</td>
					<td valign="top" style="background-color: white;">
														
					</td>
					<td align="left" width="50%">
						<img src="/car/web/images/bg_left.png" width="12" height="100%"/>
					</td>
				</tr>				
			</table> -->                        
			<div id="main">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                        <td width="20" height="20" style="background-image: url(/car/web/images/layout_tl.png)">&nbsp;</td>
                                        <td style="background-image: url(/car/web/images/layout_t.png)">&nbsp;</td>
                                        <td width="20" style="background-image: url(/car/web/images/layout_tr.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="100%" width="20" style="background-image: url(/car/web/images/layout_l.png)">&nbsp;</td>
                                        <td style="background-color: #FFFFFF" align="left">
                                            <?php echo $sf_content ?>
                                        </td>
                                        <td width="20" style="background-image: url(/car/web/images/layout_r.png)">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="20" width="20" style="background-image: url(/car/web/images/layout_bl.png)">&nbsp;</td>
                                        <td style="background-image: url(/car/web/images/layout_b.png)">&nbsp;</td>
                                        <td width="20" style="background-image: url(/car/web/images/layout_br.png)">&nbsp;</td>
                                    </tr>
                                </table>				
			</div>
                        <br/>
		<div id="footerOutsideTop">
		</div>
		<div id="footerOutside">
			<div id="footer">
                            <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">                                
                                <tr>
                                    <td>
                                        &nbsp;
                                    </td>
                                    <td width="1"><img src="/car/web/images/footer_sep.png"/></td>
                                    <td width="300" valign="top">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr height="40">
                                                <td colspan="3"></td>
                                            </tr>
                                            <tr>
                                                <td width="10" valign="top">
                                                    &nbsp;
                                                </td>
                                                <td width="82" valign="top">
                                                    <img src="/car/web/images/sendToFriend.png"/>
                                                </td>
                                                <td width="10" valign="top">
                                                    &nbsp;
                                                </td>
                                                <td>
                                                    <table cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td valign="top"><img src="/car/web/images/sendToFriendLbl.png"/><br style="line-height: 3px;"/><br style="line-height: 3px;"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top">
                                                                <table>
                                                                    <tr>
                                                                        <td valign="middle"><input type="text" id="pass" value="" style="width: 120px; height: 18px;" class="header_textbox"/></td>
                                                                        <td valign="middle"><img src="/car/web/images/tellOK.png"/></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
				<!-- <ul class="nav">
					<li><a href="#">contact</a></li>
					<li><a href="#">forum</a>|</li>
					<li><a href="#">blog</a>|</li>
					<li><a href="#">chat</a>|</li>
					<li><a href="#">support</a>|</li>
					<li><a href="#">home</a>|</li>
				</ul>
				<a href="http://validator.w3.org/check?uri=referer" target="_blank" class="xhtml" title="xhtml">XHTML</a>
				<a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank" class="css" title="css">CSS</a><br class="spacer" />
				<p class="copyright">&copy;pauseauto . All rights reserved.</p>
				<p class="design">Designed By: <a href="http://www.templateworld.com" target="_blank" title="template world">Template World</a></p>
			 -->
			</div>
		</div>	
	</div>
	<!-- FIN CONTENT -->	
</div>

<div id='loader' style="display: none;z-index: 99999"><!-- <div id='loaderInner' style='direction: ltr;'>Loading theme Tester ...</div>  -->
	<table width='100%' height='100%'>
		<tr>
			<td valign='middle' align='center'><img
				src='/car/web/images/preloader.gif' /></td>
		</tr>
	</table>
</div>

</body>
</html>
