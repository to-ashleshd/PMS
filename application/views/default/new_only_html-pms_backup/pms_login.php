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
    <div class="lc-block toggled" id="l-login">
        <div class="col-md-12">
            <div class="m-b-15">
                <img title="Smart Campus" alt="Smart Campus" style="width: 30%" src="<?php echo base_url(); ?>uploads/cmp-20130225-2482.png">
                <h4 class="text-center">Login in to your account </h4>
            </div>
        </div>
        <div class="input-group m-b-5">
            <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
            <div class="fg-line">
                <input type="text" class="form-control" placeholder="Username">
            </div>
        </div>

        <div class="input-group m-b-5">
            <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
            <div class="fg-line">
                <input type="password" class="form-control" placeholder="Password">
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="checkbox">
            <label>
                <input type="checkbox" value="">
                <i class="input-helper"></i>
                Keep me signed in
            </label>
        </div>
        <button class="btn bgm-green waves-effect m-t-25" style="width: 150px;"> LOGIN</button><br>
        <ul class="login-navigation m-t-10">
            <li data-block="#l-forget-password">
                <span style="color: red;">Forgot Password?</span>
            </li>
        </ul>
    </div>

    <!-- Forgot Password -->
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
                <input type="text" class="form-control" placeholder="Email Address">
            </div>
        </div>

        <ul class="login-navigation">
            <li data-block="#l-login" class="bgm-green">Request New Password</li>
        </ul>
    </div>
    <!-- Javascript Libraries -->
    <script src="<?php echo base_url(); ?>assets/material/vendors/bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/material/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/material/vendors/bower_components/Waves/dist/waves.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/material/js/functions.js" type="text/javascript"></script>

</body>
</html>