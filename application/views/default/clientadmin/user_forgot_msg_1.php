<style>
body { background-color:#F1F1F1; }
</style>

<link href="<?php echo base_url("assets/sweetdream/"); ?>/css/mystyle.css" rel="stylesheet">
<?php
$this->load->model('generalesettings');
$logo = $this->generalesettings->getImage();
$mylogo = str_replace('_thumb','',$logo);
?>
<p>&nbsp;</p>

<div id="graybg" style="width:auto; height:500px; margin:auto; background-color:#f1f1f1; " >

<div id="login-wrapper"  style="margin-top: -134.5px; top: 50%; position: absolute; margin-left: -248px; left: 50%; clear:both">
  <div class="main-col" style=" border-left: 1px solid #C2C2C2;float: left;margin-left: 120px;padding: 10px 20px 10px 10px;position: relative;"> <img src="<?php echo base_url("uploads"); ?>/<?php echo $mylogo; ?>" alt="" class="logo_img" style=" margin:-38px 0 0 -125px;position: absolute;top: 50%;width: 100px; height:auto;" />
    
	<div class="panel" id="userlogin" style="min-height:200px;">
      <p class="heading_main"><?php echo $msgtitle; ?></p>
     
	   
      <form id="login-validate" action="" method="post" onsubmit="return loginvalidation()">
        <label for="login_name"><?php echo $msgdesc; ?></label>
      </form>
    </div>
    
    
	
	
  </div>
	<div class="login_links">
		<!-- <a href="javascript:void(0)" id="pass_forgot"><span>Forgot password?</span></a> | <a href="javascript:void(0)" id="pass_login"><span>Account login</span></a> | <a href="javascript:void(0)" id="pass_resend_activation" ><span>Resend Activation Link</span></a> | <a href="<?php echo site_url("users/newregistration/"); ?>" ><span>New Registration</span></a> -->
		<a href="<?php echo site_url('clientadmin'); ?>" id="pass_login"><span>Account login</span></a>
		
	</div>
</div>

</div>

<?php $this->load->view('default/clientadmin/user_footer_common_js_sw'); ?>

<?php $this->load->view('default/clientadmin/user_footer'); ?>


<!-- jQuery framework -->
<script src="<?php echo base_url("assets/clientadmin/"); ?>/js/jquery.min.js"></script>
<!-- validation -->
<script src="<?php echo base_url("assets/clientadmin/"); ?>/js/lib/jquery-validation/jquery.validate.js"></script>


<script type="text/javascript">
        (function(a){a.fn.vAlign=function(){return this.each(function(){var b=a(this).height(),c=a(this).outerHeight(),b=(b+(c-b))/2;a(this).css("margin-top","-"+b+"px");a(this).css("top","50%");a(this).css("position","absolute")})}})(jQuery);(function(a){a.fn.hAlign=function(){return this.each(function(){var b=a(this).width(),c=a(this).outerWidth(),b=(b+(c-b))/2;a(this).css("margin-left","-"+b+"px");a(this).css("left","50%");a(this).css("position","absolute")})}})(jQuery);
        $(document).ready(function() {
            if($('#login-wrapper').length) {
                $("#login-wrapper").vAlign().hAlign()
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



</body></html>