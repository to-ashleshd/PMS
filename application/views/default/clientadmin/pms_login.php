<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Varroc Group PMS Online</title>

    <!-- Vendor CSS -->
    <link href="<?php echo base_url(); ?>assets/material/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/material/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet" type="text/css"/>
    <!-- CSS -->
    <link href="<?php echo base_url(); ?>assets/material/css/app.min.1.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/material/css/app.min.2.css" rel="stylesheet" type="text/css"/>
</head>

<body class="login-content">
    <!-- Login -->
    <div id="login-wrapper"  style="float:left; margin-left:50px;">
    <div class="lc-block toggled" id="l-login">
        <div class="col-md-12">
            <div class="m-b-15">
                <img title="Smart Campus" alt="Smart Campus" style="width: 30%" src="<?php echo base_url(); ?>uploads/cmp-20130225-2482.png">
                <h4 class="text-center">Login in to your account </h4>
            </div>
        </div>


       <form id="login-validate" action="<?php echo $action; ?>" method="post" onsubmit="return loginvalidation()">
         <div class="input-group m-b-5">
            <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
            <div class="fg-line">
                <input type="text" class="form-control" name="login_name" id="login_name" placeholder="Username">
            </div>
        </div>
          <div class="input-group m-b-5">
            <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
            <div class="fg-line">
                <input type="password" class="form-control" name="login_password" id="login_password" placeholder="Password">
            </div>
        </div>
           <div class="checkbox m-t-15">
            <label>
                <input type="checkbox" value="">
                <i class="input-helper"></i>
                Keep me signed in
            </label>
        </div>
          <div class="submit_sect">
            <button type="submit" class="btn btn-info waves-effect m-t-25" name="submit" value="login" >Login</button>
          </div>
        </form>

<!--       <ul class="login-navigation m-t-10">
            <li data-block="#l-forget-password">
                <span style="color: red;">Forgot Password?</span>
            </li>
        </ul>-->
<div class="login_links">
<a href="javascript:void(0)" id="pass_forgot"><span>Forgot password?</span></a>
    </div>
    </div>

    <!-- Forgot Password -->
<!--     <div class="panel" style="display:none" id="forgetpwd" >
    <form id="forgot-validate" >
        <div class="lc-block" id="l-forget-password">
        <div class="col-md-12">
            <div class="m-b-30">
                <img title="Smart Campus" alt="Smart Campus" style="width: 30%" src="<?php echo base_url(); ?>uploads/cmp-20130225-2482.png">
                <h4 class="text-center">Login in to your account </h4>
            </div>
        </div>   
        <p class="text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eu risus. Curabitur commodo lorem fringilla enim feugiat commodo sed ac lacus.</p>
        <div class="input-group m-b-20">
            <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
            <div class="fg-line">
                <input type="text" class="form-control" id="forgot_email" name="forgot_email" placeholder="Email Address">
            </div>
        </div>
        <div class="submit_sect">
            <button type="submit" class="btn btn-info waves-effect m-t-25" name="submit" value="Submit">Request New Password</button>
          </div>
      
     </div>
          </form>
     </div>-->

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
    

    <!-- Javascript Libraries -->
    <script src="<?php echo base_url(); ?>assets/material/vendors/bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/material/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/material/vendors/bower_components/Waves/dist/waves.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/material/js/functions.js" type="text/javascript"></script>
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
</body>
</html>