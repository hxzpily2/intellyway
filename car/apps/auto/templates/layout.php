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
<!--[if lte IE 6]>
<script type="text/javascript" src="/car/web/js/supersleight/supersleight-min.js"></script>
<![endif]-->

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
<!--[if (gte IE 5)&(lte IE 7)]>
<link href="/car/web/css/dropdown/dropdownie.css" media="all" rel="stylesheet" type="text/css" />
<![endif]-->
<link href="/car/web/css/template.css" media="screen, projection" rel="stylesheet" type="text/css"/>
<link href="/car/web/css/front.css" media="screen, projection" rel="stylesheet" type="text/css"/>
<link href="/car/web/css/slide.css" media="screen, projection" rel="stylesheet" type="text/css"/>
<!--[if IE]><link href="/car/web/css/frontie.css" media="screen, projection" rel="stylesheet" type="text/css"><![endif]-->
<script src="/car/web/js/jquery/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/car/web/js/jquery/effects.js"></script>

<script type="text/javascript" src="/car/web/js/jquery/jquery.nyroModal-1.5.5.pack.js"></script>
<link href='/car/web/js/jquery/nyroModal.css' type="text/css" rel="stylesheet" />

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
        /*supersleight.init();*/

        
  }
);
	
</script>
<!-- FIN DOJO --> 
<?php include_stylesheets() ?>
<?php include_javascripts() ?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22831107-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
<!-- <img src="/car/web/images/bg/red-christmas-lights.jpg" alt="" id="background" />  -->
<div id="supersize">
   <img src="/car/web/images/287.jpg" />
</div>
<?php
if($isLogged){
?>
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
			<div class="left">
				<h1>Welcome to Web-Kreation</h1>
				<h2>Sliding login panel Demo with jQuery</h2>
				<p class="grey">You can put anything you want in this sliding panel: videos, audio, images, forms... The only limit is your imagination!</p>

				<h2>Download</h2>
				<p class="grey">To download this script go back to <a href="http://web-kreation.com/index.php/tutorials/nice-clean-sliding-login-panel-built-with-jquery" title="Download">article &raquo;</a></p>
			</div>
			<div class="left">
				<form method="post" id="signin" action="/car/web/auto.php/accueil/login">
					<h1 class="padlock">Member Login</h1>
					<label class="grey" for="login">Username:</label>

					<input class="field" type="text" name="login" id="login" value="" size="23" />
					<label class="grey" for="password">Password:</label>
					<input class="field" type="password" name="password" id="password" size="23" />
	            	<label><input name="remember_me" id="remember" type="checkbox" checked="checked" value="forever" /> &nbsp;Remember me</label>
        			<div class="clear"></div>
					<input type="submit" name="submit" value="Login" class="bt_login" />
					<a class="lost-pwd" href="#">Lost your password?</a>

				</form>
			</div>
			<div class="left right">
				<form action="#" method="post">
					<h1>Not a member yet? Sign Up!</h1>
					<label class="grey" for="signup">Username:</label>
					<input class="field" type="text" name="signup" id="signup" value="" size="23" />
					<label class="grey" for="email">Email:</label>

					<input class="field" type="text" name="email" id="email" size="23" />
					<label>A password will be e-mailed to you.</label>
					<input type="submit" name="submit" value="Register" class="bt_register" />
				</form>
			</div>
		</div>
	</div> <!-- /login -->

    <!-- The tab on top -->
	<div class="tab">

		<ul class="login">
	    	<li class="left">&nbsp;</li>
	        <li>
                    Bienvenue!
                </li>
			<li class="sep">|</li>
			<li id="toggle">
                            <a id="open" class="open" href="#">Log In | S&rsquo;enregistrer</a>
				<a id="close" style="display: none;" class="close" href="#">Close Panel</a>
			</li>

	    	<li class="right">&nbsp;</li>
		</ul>
	</div>

</div>
<?php
}
?>
<div>  
	
	
	
	<script type="text/javascript">
	        $(document).ready(function() {                    

                    dojo.query( '.bgItem' ).connect( 'mouseover', commun.rollOverMenu);

                    dojo.query( document ).connect( 'onmousemove', commun.rollOutMenu);                   

	
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


                    // Expand Panel
                $("#open").click(function(){
                        $("div#panel").slideDown("slow");
                });

                // Collapse Panel
                $("#close").click(function(){
                        $("div#panel").slideUp("slow");
                });

                // Switch buttons from "Log In | Register" to "Close Panel" on click
                $("#toggle a").click(function () {
                        $("#toggle a").toggle();
                });
                    
				
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
			<div id="topnav" class="topnav" style="background-color: white;">                              			   
                           <?php
                           if(!$isLogged){
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
                                <div id="contactUS">
                                    <table cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td></td>
                                            <td><img width="40" src="/car/web/images/contact.png"/></td>
                                        </tr>
                                    </table>
                                </div>
			</div>			
			<div id="navigation">
			    <ul id="topnav">
			    	<li>                                   
                                    <span class="leftItem" href="#" title="">&nbsp;</span>
                                    <a class="bgItem" href="#" title="">Accueil</a>
                                    <span class="rightItem" href="#" title="">&nbsp;</span>                                    
			        </li>
                                <li>
                                    <span class="leftItem" href="#" title="">&nbsp;</span>
                                    <a class="bgItem" href="#" title="">Essais</a>
                                    <span class="rightItem" href="#" title="">&nbsp;</span>                                    
			        </li>
                                <li>
                                    <span class="leftItem" href="#" title="">&nbsp;</span>
                                    <a class="bgItem" href="#" title="">A l&rsquo;actu</a>
                                    <span class="rightItem" href="#" title="">&nbsp;</span>
			        </li>
                                <li>
                                    <span class="leftItem" href="#" title="">&nbsp;</span>
                                    <a class="bgItem" href="#" title="">Argus</a>
                                    <span class="rightItem" href="#" title="">&nbsp;</span>
			        </li>
                                <li>
                                    <span class="leftItem" href="#" title="">&nbsp;</span>
                                    <a class="bgItem" href="#" title="">Annonces</a>
                                    <span class="rightItem" href="#" title="">&nbsp;</span>
                                    <ul class="subnav">
                                        <li><a href="#">D&eacute;poser</a></li>
                                        <li><a href="#">Consulter</a></li>
                                        <li><a href="#">Modifier</a></li>
                                    </ul>
			        </li>
                                <li>
                                    <span class="leftItem" href="#" title="">&nbsp;</span>
                                    <a class="bgItem" href="#" title="">Voitures neuves</a>
                                    <span class="rightItem" href="#" title="">&nbsp;</span>
			        </li>
                                <li>
                                    <span class="leftItem" href="#" title="">&nbsp;</span>
                                    <a class="bgItem" href="#" title="">Conseils</a>
                                    <span class="rightItem" href="#" title="">&nbsp;</span>
			        </li>
                                <li>
                                    <span class="leftItem" href="#" title="">&nbsp;</span>
                                    <a class="bgItem" href="#" title="">Services</a>
                                    <span class="rightItem" href="#" title="">&nbsp;</span>
			        </li>
                                <li>
                                    <span class="leftItem" href="#" title="">&nbsp;</span>
                                    <a class="bgItem" href="#" title="">Assurance</a>
                                    <span class="rightItem" href="#" title="">&nbsp;</span>
			        </li>
			        <li>
                                    <span class="leftItem" href="#" title="">&nbsp;</span>
                                    <a class="bgItem" href="#" title="">Products</a>
                                    <span class="rightItem" href="#" title="">&nbsp;</span>    
			        </li>
			        <li>
                                    <span class="leftItem" href="#" title="">&nbsp;</span>
                                    <a class="bgItem" href="#" title="">Sales</a>
                                    <span class="rightItem" href="#" title="">&nbsp;</span>    			            
			        </li>
			        <li>
                                    <span class="curLeftItem" href="#" title="">&nbsp;</span>
                                    <a class="curBgItem" href="#" title="">Community</a>
                                    <span class="curRightItem" href="#" title="">&nbsp;</span>
			        </li>
			        <li>
                                    <span class="leftItem" href="#" title="">&nbsp;</span>
                                    <a class="bgItem" href="#" title="">Store Locator</a>
                                    <span class="rightItem" href="#" title="">&nbsp;</span>
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
									<td valign="middle" colspan="5"><input id="login" name="login" value="" title="username" tabindex="4" type="text"/></td>
								</tr>
								<tr>
									<td valign="middle"><img src="/car/web/images/beat.png"/></td>
									<td width="5"></td>
									<td valign="middle"><label for="password">Password</label></td>
									<td width="5"></td>
									<td valign="middle"><div style="height: 2px;background-color: #CACACA;width: 80px;">&nbsp;</div></td>
								</tr>
								<tr>
									<td valign="middle" colspan="5"><input id="password" name="password" value="" title="password" tabindex="5" type="password"/></td>
								</tr>
							</table>					
							<p class="remember">							
								<input id="mySignin_submit" value="" tabindex="6" type="submit"/>
								<input id="remember" name="remember_me" value="1" tabindex="7" type="checkbox" <?php echo $isRemember; ?> />
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
