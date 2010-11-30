<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <link href="/car/web/css/front.css" media="screen, projection" rel="stylesheet" type="text/css">
    <script src="/car/web/js/jquery/jquery.js" type="text/javascript"></script>
    
    <!-- RATING -->	
	<script src='/car/web/js/jquery/jquery.MetaData.js' type="text/javascript" language="javascript"></script>
    <script src='/car/web/js/jquery/jquery.rating.js' type="text/javascript" language="javascript"></script>
    <link href='/car/web/css/jquery.rating.css' type="text/css" rel="stylesheet"/>
    <!-- FIN RATING -->
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <div id="topnav" class="topnav">
      Have an account? <a href="#" class="signin"><span>Sign in</span></a>
    </div>
    <fieldset id="signin_menu">    
      <form method="post" id="signin" action="">
          <label for="username">Username or email</label>
          <input id="username" name="username" value="" title="username" tabindex="4" type="text">
        </p>
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
          <a href="#" id="resend_password_link">Forgot your password?</a>        </p>
        <!-- <p class="forgot-username">
          <A id=forgot_username_link title="If you remember your password, try logging in with your email" href="#">Forgot your username?</A>        </p> -->
      </form>
    </fieldset>    
    <div style="clear: both;"></div>    
  </div>

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
			
        });
  </script>
  <script src="/car/web/js/jquery/jquery.tipsy.js" type="text/javascript"></script>  
  <script type='text/javascript'>
    $(function() {
	  $('#forgot_username_link').tipsy({gravity: 'w'});   
    });
  </script> 
    
    <?php echo $sf_content ?>
  </body>
</html>
