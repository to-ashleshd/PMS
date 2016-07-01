<?php
//header('Location: login.php');
?><!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <link rel="icon" type="image/ico" href="favicon.ico">
    <title><?php echo $site_name;?></title>
	 <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/css/login.css">
	 
	  <style type="text/css">
   /*     .web_dialog_overlay
        {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            background: #000000;
            opacity: .15;
            filter: alpha(opacity=15);
            -moz-opacity: .15;
            z-index: 101;
            display: none;
        }*/

        .web_dialog
        {
          /*  display: none;*/
            
           
            height: auto;
            top: 33%;
            left: 33%;
                  
          
            z-index: 102;
            font-family: Verdana;
            font-size: 10pt;
			
			
			 position:absolute;
			 border:1px solid #ddd;
			 width:439px;
			 margin:0 auto;
			 background:#fff;
			 padding:10px;
			 -webkit-border-radius: 8px;
			 -moz-border-radius: 8px;
			 -ms-border-radius: 8px;
			 border-radius: 8px
			 
			
        }
        .web_dialog_title
        {
            border-bottom: solid 2px #336699;
            background-color: #336699;
            padding: 4px;
            color: White;
            font-weight:bold;
        }
        .web_dialog_title a
        {
            color: White;
            text-decoration: none;
        }
        .align_right
        {
            text-align: right;
        }
		/*.main-col {float:left;padding:10px 20px 10px 10px;position:relative;margin-right:10px;border-right:1px solid #ddd}*/
		.main-colj {padding:10px 20px 10px 10px;position:relative;margin-right:10px;border-right:0px solid #ddd}
    .logo_img {width:170px;position:absolute;top:38%;margin: -59px 10px 10px 286px;} 
	.logo_img1 {width:170px;position:absolute;top:40%;margin: -18px 10px 10px 286px;} 
	.logo_content {width:170px;position:absolute;top:40%;margin: 40px 10px 10px 286px;} 
    </style>

	 <!-- bootstrap framework css -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/bootstrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/bootstrap/css/bootstrap-responsive.min.css">
        <!-- iconSweet2 icon pack (16x16) -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/img/icsw2_16/icsw2_16.css">
        <!-- splashy icon pack -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/img/splashy/splashy.css">
        <!-- flag icons -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/img/flags/flags.css">
        <!-- power tooltips -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/powertip/jquery.powertip.css">
        <!-- google web fonts -->
            <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Abel">
            <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300">

    <!-- aditional stylesheets -->


        <!-- main stylesheet -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/css/beoro.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet'>
    <!-- jQuery framework -->
        <script src="<?php echo base_url("assets/clientadmin"); ?>/js/jquery.min.js"></script>
    <!-- validation -->
        <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/jquery-validation/jquery.validate.js"></script>
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
            $('#pass_login').click(function() {
                $('.panel:visible').slideUp('200',function() {
                    $('.panel').not($(this)).slideDown('200');
                });
                $(this).children('span').toggle();
            });
        });
    </script>


</head>
<body>
<div  align="" style=" background-color:#E5E5E5; margin-left:20px; margin-right:20px;  height:95%; width:97%;">
<br><div style="margin-left:20px;"><p align="left" style="margin-left:30px;"><font size="+5"></font></p>
</div>
	
<!---->

<br>

<!--<img src="images/login-facebook.png" alt="" height="22" width="154">
<img src="images/linkedin_button.png" alt="" height="22" width="154">-->
<?php $mylogo = str_replace('_thumb','',$logo); ?>
	<div id="dialog" class="web_dialog">
	 <!-- <div align="right"> <img src="<?php echo base_url("uploads"); ?>/<?php echo $mylogo; ?>" alt="Logo" width="100"  /></div> -->
	<div class="main-col" style="margin-top:-10px;">
            <div class="panel" >
                <p class="heading_main">Account Login</p>
				              <?php if(isset($error)): ?>
			  
			  <div class="alert alert-error"> <strong>Error!</strong> <?php echo $error; ?></div>
			  <?php endif; ?>
			   
                <form id="login-validate" action="<?php echo $action; ?>" method="post">
                    <label for="login_name">Login</label>
                    <input type="text" id="login_name" name="login_name" value="" />
                    <label for="login_password">Password</label>
                    <input type="password" id="login_password" name="login_password" value="" />
                    <label for="login_remember" class="checkbox"><input type="checkbox" id="login_remember" name="login_remember" /> Remember me</label>
                  
				    <div class="submit_sect">
                        <button type="submit" class="btn btn-beoro-3" name="submit" value="login">Login</button>
                    </div>
                </form>
            </div>
			<div class="panel" style="display:none">
                <p class="heading_main">Can't sign in?</p>
                <form id="forgot-validate" method="post">
                    <label for="forgot_email">Your email adress</label>
                    <input type="text" id="forgot_email" name="forgot_email" />
					
					<label for="forgot_email">
						Enter captch :</label> <input type="text" name="captcha" id="captcha">
					Here captch image comes dynamically
                    <div class="submit_sect">
                        <button type="submit" class="btn btn-beoro-3">Request New Password</button>
                    </div>
                </form>
            </div>
	</div>
	
	<div align="right"> 
	<img src="<?php echo base_url("uploads"); ?>/<?php echo $mylogo; ?>" alt="Logo" width="100" style="float: left;margin-left:19px; margin-top: 17%;"  />
	</div>
        
	</div>
	
	


</div>
   
        
    </div>

	
	
	
	
	
</body>
</html>
<script type="text/javascript">

function call_login()
{
	ShowDialog(false);
	e.preventDefault();
}
	  
function call_joinnow()
{

	ShowDialogj(false);
	e.preventDefault();
}
function ShowDialogj(modal)
        {
 $("#dialogj").fadeIn(300);
 }
        $(document).ready(function ()
        {
            $("#btnClose").click(function (e)
            {
                HideDialog();
                e.preventDefault();
            });
			 

            $("#btnSubmit").click(function (e)
            {
               // var brand = $("#brands input:radio:checked").val();
				$("#form1").submit();
               // $("#output").html("<b>Your favorite mobile brand: </b>" + brand);
               // HideDialog();
               // e.preventDefault();
            });
        });

        function ShowDialog(modal)
        {
            //$("#overlay").show();
            $("#dialog").fadeIn(300);

            if (modal)
            {
               // $("#overlay").unbind("click");
            }
            else
            {
               // $("#overlay").click(function (e)
                //{
                  //  HideDialog();
               // });
            }
        }

        function HideDialog()
        {
            //$("#overlay").hide();
            $("#dialog").fadeOut(300);
        } 
        function HideDialogj()
        {
            //$("#overlay").hide();
            $("#dialogj").fadeOut(300);
        } 
    </script>
</script>