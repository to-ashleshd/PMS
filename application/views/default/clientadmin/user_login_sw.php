<style>
body { background-color:#F1F1F1; }
#left_info {
    /** background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #DDDDDD;
    border-radius: 8px 8px 8px 8px;
	**/
    margin: 0 auto;
    padding: 10px;
    position: relative;
    width: 300px;
}


.heading_main2 {
    font-family: "Open Sans Condensed",sans-serif;
    font-size: 22px;
    margin-bottom: 20px;
}
.more_about {
    font-family: "Open Sans Condensed",sans-serif;
    font-size: 12px;
	text-align:justify;
	margin-top:5px;
}

</style>
<link href="<?php echo base_url("assets/sweetdream/"); ?>/css/mystyle.css" rel="stylesheet">
<?php
$this->load->model('generalesettings');
$logo = $this->generalesettings->getImage();
$mylogo = str_replace('_thumb','',$logo);
?>
<p>&nbsp;</p>
<div id="graybg" style="width:auto; height:500px; margin:auto; background-color:#f1f1f1;"  >
<div id="login-inner" style="width:980px; min-height:500px; margin:auto;">


  <!-- Left Banner -->
  <div id="rotatingbanner" style="width:375px; height:300px; background-color:#F1F1F1; float:left; margin-top:80px;">
    <object classid"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="375" height="290" style="background-color:#f1f1f1;"  >
      <param name="movie" value="<?php echo base_url("assets"); ?>/20.swf">
      <param name="quality" value="high">
      <param name="wmode" value="transparent">
      <embed wmode="transparent" src="<?php echo base_url("assets"); ?>/20.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="375" height="300" style="background-color:#f1f1f1;"></embed>
    </object>
  </div>
  <!-- End Left -->
  
  <!-- Login -->
  <div id="login-wrapper"  style="float:left; margin-left:50px;">
    <div class="main-col" style=" border-left: 1px solid #C2C2C2;float: left;margin-left: 120px;padding: 10px 20px 10px 10px;position: relative;"> <img src="<?php echo base_url("uploads"); ?>/<?php echo $mylogo; ?>" alt="" class="logo_img" style=" margin:-38px 0 0 -125px;position: absolute;top: 50%;width: 100px; height:auto;" />
      <div class="panel" id="userlogin">
        <p class="heading_main">Account Login</p>
        <?php if(isset($error)){  ?>
        <div class="error"> <strong>Error !</strong> <?php echo $error; ?> </div>
        <?php } ?>
        <form id="login-validate" action="<?php echo $action; ?>" method="post" onsubmit="return loginvalidation()">
          <label for="login_name">Login</label>
          <input type="text" name="login_name" id="login_name" placeholder="Email Id">
          <label for="login_password">Password</label>
          <input type="password" name="login_password" id="login_password" placeholder="Password">
          <input type="checkbox" >
          <!--  <label for="login_remember" class="checkbox" style="margin-top:-6px;position:relative;color:#333;">-->
          <!--	<input type="checkbox" id="login_remember" name="login_remember" /> Remember me-->
          <div class="submit_sect">
            <button type="submit" class="btn btn-beoro-3" name="submit" value="login" >Login</button>
          </div>
        </form>
      </div>
      <div class="panel" style="display:none" id="forgetpwd" >
        <p class="heading_main">Can't sign in?</p>
        <form id="forgot-validate" action="<?php echo site_url('recover/sendpasswordlink'); ?>" method="post">
          <label for="forgot_email">Your email adress</label>
          <input type="text" id="forgot_email" name="forgot_email" />
          <div class="submit_sect">
            <button type="submit" class="btn btn-beoro-3" name="submit" value="Submit">Request New Password</button>
          </div>
        </form>
      </div>
    </div>
    <div class="login_links">
      <!-- <a href="javascript:void(0)" id="pass_forgot"><span>Forgot password?</span></a> | <a href="javascript:void(0)" id="pass_login"><span>Account login</span></a> | <a href="javascript:void(0)" id="pass_resend_activation" ><span>Resend Activation Link</span></a> | <a href="<?php echo site_url("users/newregistration/"); ?>" ><span>New Registration</span></a> -->
      <a href="javascript:void(0)" id="pass_forgot"><span>Forgot password?</span></a> | <a href="javascript:void(0)" id="pass_login"><span>Account login</span></a> </div>
  </div>
  <!-- End Login -->
  
</div>  
</div>
<?php $this->load->view('default/clientadmin/user_footer_common_js_sw'); ?>
<?php $this->load->view('default/clientadmin/user_footer'); ?>
<!-- jQuery framework -->
<script src="<?php echo base_url("assets/clientadmin/"); ?>/js/jquery.min.js"></script>
<!-- validation -->
<script src="<?php echo base_url("assets/clientadmin/"); ?>/js/lib/jquery-validation/jquery.validate.js"></script>
<script type="text/javascript">
(function(a){a.fn.vAlign=function(){return this.each(function(){var b=a(this).height(),c=a(this).outerHeight(),b=(b+(c-b))/2;a(this).css("margin-top","-"+b+"px");a(this).css("top","50%");a(this).css("position","absolute")})}})(jQuery);(function(a){a.fn.hAlign=function(){return this.each(function(){var b=a(this).width(),c=a(this).outerWidth(),b=(b+(c-b))/2;a(this).css("margin-left","-"+b+"px");a(this).css("left","64%");a(this).css("position","absolute")})}})(jQuery);
/**
        (function(a){a.fn.vAlign=function(){return this.each(function(){var b=a(this).height(),c=a(this).outerHeight(),b=(b+(c-b))/2;a(this).css("margin-top","-"+b+"px");a(this).css("top","50%");a(this).css("position","absolute")})}})(jQuery);(function(a){a.fn.hAlign=function(){return this.each(function(){var b=a(this).width(),c=a(this).outerWidth(),b=(b+(c-b))/2;a(this).css("margin-left","-"+b+"px");a(this).css("left","64%");a(this).css("position","absolute")})}})(jQuery);
(function (a) {
    a.fn.vAlign2 = function () {
        return this.each(function () {
            var b = a(this).height(),
                c = a(this).outerHeight(),
                b = (b + (c - b)) / 2;
            a(this).css("margin-top", "-" + b + "px");
            a(this).css("top", "35%");
            a(this).css("position", "absolute")
        })
    }
})(jQuery);

(function (a) {
    a.fn.hAlign2 = function () {
        return this.each(function () {
            var b = a(this).width(),
                c = a(this).outerWidth(),
                b = (b + (c - b)) / 2;
            a(this).css("margin-left", "-" + b + "px");
            a(this).css("left", "20%");
            a(this).css("position", "absolute")
        })
    }
})(jQuery);
**/		
        $(document).ready(function() {
            if($('#login-wrapper').length) {
                $("#login-wrapper").vAlign().hAlign()
            };
			
			if($('#left_info').length) {
                $("#left_info").vAlign2().hAlign2()
            };
			
			
            if($('#login-validate').length) {
                $('#login-validate').validate({
                    onkeyup: false,
                    errorClass: 'error',
                    rules: {
                        login_name: { required: true },
                        login_password: { required: true }
                    }
                })
            }
            if($('#forgot-validate').length) {
                $('#forgot-validate').validate({
                    onkeyup: false,
                    errorClass: 'error',
                    rules: {
                        forgot_email: { required: true, email: true }
                    }
                })
            }
			
			if($('#resend-validate').length) {
                $('#resend-validate').validate({
                    onkeyup: false,
                    errorClass: 'error',
                    rules: {
                        email: { required: true, email: true }
                    }
                })
            }
			
			  if($('#formactivationID').length) {
                $('#formactivationID').validate({
                    onkeyup: false,
                    errorClass: 'error',
                    rules: {
                        email_username: { required: true},
						activation_code : { required: true}
                    }
                })
            }
			
			
			//for Login
			$('#pass_login').click(function() {
			 //	$('#forgetpwd').slideDown('200');
			 	$('.panel').not($(this)).slideUp('200');
				$('#userlogin').slideDown('200');
            });
			
			//for Forgot Pass
			$('#pass_forgot').click(function() {
			 //	$('#forgetpwd').slideDown('200');
			 	$('.panel').not($(this)).slideUp('200');
				$('#forgetpwd').slideDown('200');
            });
			
			//for Activate Account
			$('#pass_activate_login').click(function() {
			 //	$('#forgetpwd').slideDown('200');
			 	$('.panel').not($(this)).slideUp('200');
				$('#user_activation').slideDown('200');
            });
			
			
			$('#pass_resend_activation').click(function() {
			 //	$('#forgetpwd').slideDown('200');
			 	$('.panel').not($(this)).slideUp('200');
				$('#resend_activation').slideDown('200');
            });
			//jQuery("#formactivationID").validationEngine();
			
        });
    </script>
<script type="text/javascript">
function loginvalidation()
{
	var flag=0;
	var email = document.getElementById('login_name').value;
	var password = document.getElementById('login_password').value;
	if(email.length<=0 && password.length<=0)
	{
		alert("Please enter correct username and password");
		return false;
	}
	else
	{
		return true;
	}
}
</script>
</body></html>