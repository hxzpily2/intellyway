<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>
<link rel="shortcut icon" href="/favicon.ico" />
<link href="/car/web/css/front.css" media="screen, projection"
	rel="stylesheet" type="text/css"><script
	src="/car/web/js/jquery/jquery.min.js" type="text/javascript"></script>

<!-- RATING --> 
<script src='/car/web/js/jquery/jquery.MetaData.js'	type="text/javascript" language="javascript"></script>
<script	src='/car/web/js/jquery/jquery.rating.js' type="text/javascript" language="javascript"></script>
<link href='/car/web/css/jquery.rating.css' type="text/css" rel="stylesheet" />
<!-- FIN RATING -->

<!-- FORM VALIDATION -->
<link rel="stylesheet" href="/car/web/css/validationEngine.jquery.css"	type="text/css" media="screen" charset="utf-8" />
<script src="/car/web/js/jquery/jquery.validationEngine-fr.js"	type="text/javascript"></script>
<script	src="/car/web/js/jquery/jquery.validationEngine.js"	type="text/javascript"></script>

<script	src="/car/web/js/jquery/jquery-ui-1.8.6.custom.min.js"	type="text/javascript"></script>
<!-- FIN FORM VALIDATIOn -->

<script	src="/car/web/js/jquery/jQuery.fullBg.js"	type="text/javascript"></script>

<!-- DOJO -->
<style type='text/css'>
@import '/car/web/js/dojo/dijit/themes/claro/claro.css';

@import '/car/web/js/dojo/resources/dojo.css';

html,body {
	height: 100%;
	width: 100%;
	padding: 0;
	border: 0;
}

</style>

<script type='text/javascript'	src='/car/web/js/dojo/dojo/dojo.js'	djConfig='parseOnLoad: false'></script>


<script type='text/javascript'>  
dojo.require('dijit.dijit');
dojo.require('dojo.parser');
dojo.require("dojo.fx");
dojo.require("dojox.validate.web");
dojo.require("dojox.validate._base");
//dojo.require('dijit.Tree');
//dojo.require('dojo.data.ItemFileReadStore');
//dojo.require('dijit.tree.ForestStoreModel');
//dojo.require('dijit.layout.AccordionContainer');
//dojo.require('dijit.layout.ContentPane');
//dojo.require('dijit.layout.BorderContainer');
//dojo.require('dijit.Menu');
//dojo.require('dijit.Tooltip');
//dojo.require('dijit.Tree');
//dojo.require('dijit.form.TextBox');
dojo.require('dijit.form.Button');
//dojo.require('dijit.form.NumberSpinner');
//dojo.require('dijit.form.ValidationTextBox');
//dojo.require('dijit.layout.AccordionContainer');
//dojo.require('dijit.layout.ContentPane');
//dojo.require('dijit.layout.BorderContainer');
//dojo.require('dijit.Dialog');
//dojo.require('dijit.Declaration');
//dojo.require('dijit.Toolbar');
//dojo.require('dijit.ToolbarSeparator');
dojo.require('dojo.parser');
dojo.require('dojo.date.locale');
dojo.require('dojo.data.ItemFileReadStore');
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
<img src="/car/web/images/bg/red-christmas-lights.jpg" alt="" id="background" />
<div>  
	
	
	
	<script type="text/javascript">
	        $(document).ready(function() {
	
	            $(".signin").click(function() {
	                $("fieldset#signin_menu").toggle();
					$(".signin").toggleClass("menu-open");
	            });
				
				$("fieldset#signin_menu").mouseup(function() {
					return false;
				});
				$(document).mouseup(function(e) {
					if($(e.target).parent("a.signin").length==0) {
						$(".signin").removeClass("menu-open");
						$("fieldset#signin_menu").hide();
					}
				});	
	
				(function($) {
				  $("#background").fullBg();
				})(jQuery);		
				
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
		<div style="width: 100%;height:120px;background-color: white;">
			<div id="topnav" class="topnav">
			   Have an account? 
			   <a href="#" class="signin"><span>Sign in</span></a>
			</div>
		</div>
		<fieldset id="signin_menu">
		<form method="post" id="signin" action="">
			<label for="username">Username or email</label>
			<input id="username" name="username" value="" title="username" tabindex="4" type="text">
		
		<p>
			<label for="password">Password</label>
			<input id="password" name="password" value="" title="password" tabindex="5" type="password">
		</p>
		<p class="remember">
			<input id="signin_submit" value="Sign in" tabindex="6" type="submit">
			<input id="remember" name="remember_me" value="1" tabindex="7" type="checkbox">
			<label for="remember">Remember me</label>
		</p>
		<p class="forgot">
			<a href="#" id="resend_password_link">Forgot your password?</a>
		</p>
		<!-- <p class="forgot-username">
		          <A id=forgot_username_link title="If you remember your password, try logging in with your email" href="#">Forgot your username?</A>        </p> --></form>
		</fieldset>
		<div style="clear: both;"></div>
		<div id="main">
			<?php echo $sf_content ?>
		</div>
	</div>
	<!-- FIN CONTENT -->	
</div>
<div id="footerOutside">
	<div id="footer">
		<ul class="nav">
			<li><a href="#">contact</a></li>
			<li><a href="#">forum</a>|</li>
			<li><a href="#">blog</a>|</li>
			<li><a href="#">chat</a>|</li>
			<li><a href="#">support</a>|</li>
			<li><a href="#">home</a>|</li>
		</ul>
	<a href="http://validator.w3.org/check?uri=referer" target="_blank" class="xhtml" title="xhtml">XHTML</a>
	<a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank" class="css" title="css">CSS</a><br class="spacer" />
	<p class="copyright">�yellow web. All rights reserved.</p>
	<p class="design">Designed By: <a href="http://www.templateworld.com" target="_blank" title="template world">Template World</a></p>
	</div>
</div>	
<div id='loader' style="display: none;"><!-- <div id='loaderInner' style='direction: ltr;'>Loading theme Tester ...</div>  -->
	<table width='100%' height='100%'>
		<tr>
			<td valign='middle' align='center'><img
				src='/car/web/images/preloader.gif' /></td>
		</tr>
	</table>
</div>
</body>
</html>
