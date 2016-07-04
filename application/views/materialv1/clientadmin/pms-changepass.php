<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Admin</title>

    <!-- Common CSS -->
    <?php $this->load->view('materialv1/common/common_css'); ?>
</head>

<body>

    <!-- Common Header -->
    <?php $this->load->view('materialv1/common/common_header'); ?>

    <section id="main">

        <!-- Left Sidebar -->
        <?php $this->load->view('materialv1/common/common_left_sidebar'); ?>

        <aside id="chat" class="sidebar c-overflow">

            <div class="chat-search">
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Search People">
                </div>
            </div>

            <div class="listview">
                <a class="lv-item" href="">
                    <div class="media">
                        <div class="pull-left p-relative">
                            <img class="lv-img-sm" src="<?php echo base_url('assets/material/img'); ?>/profile-pics/2.jpg" alt="">
                            <i class="chat-status-busy"></i>
                        </div>
                        <div class="media-body">
                            <div class="lv-title">Jonathan Morris</div>
                            <small class="lv-small">Available</small>
                        </div>
                    </div>
                </a>

                <a class="lv-item" href="">
                    <div class="media">
                        <div class="pull-left">
                            <img class="lv-img-sm" src="<?php echo base_url('assets/material/img'); ?>/profile-pics/1.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <div class="lv-title">David Belle</div>
                            <small class="lv-small">Last seen 3 hours ago</small>
                        </div>
                    </div>
                </a>

                <a class="lv-item" href="">
                    <div class="media">
                        <div class="pull-left p-relative">
                            <img class="lv-img-sm" src="<?php echo base_url('assets/material/img'); ?>/profile-pics/3.jpg" alt="">
                            <i class="chat-status-online"></i>
                        </div>
                        <div class="media-body">
                            <div class="lv-title">Fredric Mitchell Jr.</div>
                            <small class="lv-small">Availble</small>
                        </div>
                    </div>
                </a>

                <a class="lv-item" href="">
                    <div class="media">
                        <div class="pull-left p-relative">
                            <img class="lv-img-sm" src="<?php echo base_url('assets/material/img'); ?>/profile-pics/4.jpg" alt="">
                            <i class="chat-status-online"></i>
                        </div>
                        <div class="media-body">
                            <div class="lv-title">Glenn Jecobs</div>
                            <small class="lv-small">Availble</small>
                        </div>
                    </div>
                </a>

                <a class="lv-item" href="">
                    <div class="media">
                        <div class="pull-left">
                            <img class="lv-img-sm" src="<?php echo base_url('assets/material/img'); ?>/profile-pics/5.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <div class="lv-title">Bill Phillips</div>
                            <small class="lv-small">Last seen 3 days ago</small>
                        </div>
                    </div>
                </a>

                <a class="lv-item" href="">
                    <div class="media">
                        <div class="pull-left">
                            <img class="lv-img-sm" src="<?php echo base_url('assets/material/img'); ?>/profile-pics/6.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <div class="lv-title">Wendy Mitchell</div>
                            <small class="lv-small">Last seen 2 minutes ago</small>
                        </div>
                    </div>
                </a>
                <a class="lv-item" href="">
                    <div class="media">
                        <div class="pull-left p-relative">
                            <img class="lv-img-sm" src="<?php echo base_url('assets/material/img'); ?>/profile-pics/7.jpg" alt="">
                            <i class="chat-status-busy"></i>
                        </div>
                        <div class="media-body">
                            <div class="lv-title">Teena Bell Ann</div>
                            <small class="lv-small">Busy</small>
                        </div>
                    </div>
                </a>
            </div>
        </aside>

        <section id="content">
            <div class="container">
                <div class="card">                        
                    <div class="lv-header-alt clearfix">
                        <h2 class="lvh-label hidden-xs">Change Password</h2>
                        <div class="lvh-search">
                            <input type="text" placeholder="Start typing..." class="lvhs-input">
                            <i class="lvh-search-close">&times;</i>
                        </div>
                        <ul class="lv-actions actions">
                            <li>
                                <a href="" class="lvh-search-trigger">
                                    <i class="zmdi zmdi-search"></i>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="zmdi zmdi-time"></i>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="" data-toggle="dropdown" aria-expanded="true">
                                    <i class="zmdi zmdi-sort"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="">Last Modified</a>
                                    </li>
                                    <li>
                                        <a href="">Last Edited</a>
                                    </li>
                                    <li>
                                        <a href="">Name</a>
                                    </li>
                                    <li>
                                        <a href="">Date</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="">
                                    <i class="zmdi zmdi-info"></i>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="" data-toggle="dropdown" aria-expanded="true">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="">Refresh</a>
                                    </li>
                                    <li>
                                        <a href="">Listview Settings</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <!--Main container part start -->
                    <div class="card-body card-padding">
                        <div class="row" style="padding: 30px">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                        <div class="form-group fg-float" style="margin-bottom: 40px !important;">
                                            <label class="col-sm-4 control-label" for="Current-Password">Current Password</label>
                                            <div class="col-sm-7">
                                                <div class="fg-line">
                                                    <input name="current_password"  type="text" id="current_password" value="" maxlength="30" class="form-control fg-input">
                                                    <label class="fg-label">Current Password</label>
                                                </div>
                                            </div>
                                        </div><br>
                                        <div class="form-group fg-float" style="margin-bottom: 40px !important;">
                                            <label class="col-sm-4 control-label" for="Password">Password</label>
                                            <div class="col-sm-7">
                                                <div class="fg-line">
                                                    <input class="form-control fg-input" name="password2" type="password" class="validate[required]" id="password2" onblur="checkpasswordstrength('result', 'lbl_password');" maxlength="30" placeholder="Password">
                                                    <label class="fg-label">Password</label>
                                                </div>
                                            </div>
                                        </div><br>
                                        <div class="form-group fg-float" style="margin-bottom: 40px !important;">
                                            <label class="col-sm-4 control-label" for="confirmpassword">Confirm Passoword</label>
                                            <div class="col-sm-7">
                                                <div class="fg-line">
                                                    <input class="form-control fg-input" name="confirmpassword" type="password"  class="validate[required,equals[password2]]" id="confirmpassword" maxlength="30" placeholder="Confirm Password">
                                                    <label class="fg-label">Current Password</label>
                                                </div>
                                            </div>
                                        </div>
                                <br>
                                <div class="text-center m-l-20">
                                <button class="btn bgm-cyan waves-effect m-l-20" type="button" name="Button" value="Change Password" id="upd_passwd">Change Password</button>
                                 <button class="btn bgm-cyan waves-effect" type="reset" name="reset" value="Reset" id="reset">Reset</button>
                              </div>
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                       
                    </div>

 <!--Main container part End -->

                </div><!--/card-->
            </div>
        </section>
    </section>

    <!-- Common Footer -->
    <?php $this->load->view('materialv1/common/common_footer'); ?>


    <!-- Page Loader -->
    <div class="page-loader">
        <div class="preloader pls-blue">
            <svg class="pl-circular" viewBox="25 25 50 50">
            <circle class="plc-path" cx="50" cy="50" r="20" />
            </svg>

            <p>Please wait...</p>
        </div>
    </div>

    <!-- Javascript Libraries -->
    <?php $this->load->view('materialv1/common/common_js'); ?>
    <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url("assets/clientadmin/"); ?>/js/pwd_strength_script.js"></script>
    <!-- jQuery validation -->
    <script src="<?php echo base_url("assets/clientadmin"); ?>js/lib/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?php echo base_url("assets/clientadmin"); ?>js/pages/beoro_form_validation.js"></script>
    <!-- jQuery validation -->
    <script src="js/lib/jquery-validation/jquery.validate.min.js"></script>

    <script type="text/javascript">
        hide_message('flashmessages');
        function call_to_chk_all_services()
        {
            if ($('#allt').is(":checked"))
            {
                $("#tb1_a input:checkbox").attr("checked", true)
            }
            else
            {
                $("#tb1_a input:checkbox").attr("checked", false)
            }
        }
    </script>
    <!--- start get office types of company --->
    <script type="text/javascript" >
        function call_office_types()
        {

            var company_id = $("#office_add_company").val();

            if (company_id == '')
            {
                alert("please select Company");
                return false;
            }
            else
            {
                var url = '<?php echo site_url("ajax/getofficeaddresslistbycomany"); ?>';
                $.ajax({
                    url: url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        company_id: company_id,
                    },
                    success: function (response) {
                        if (response['offices'] != '')
                        {
                            $('#offices_address').html('<option value="">--Please Select--</option>');
                            $('#offices_address').append(response['offices']);
                        }
                    }
                });

            }


        }
        function call_office_department()
        {

            var office_address_id = $("#offices_address").val();

            if (office_address_id == '')
            {
                alert("please select Office");
                return false;
            }
            else
            {
                var url = '<?php echo site_url("ajax/getDepartmentlistbyOfficeAddress"); ?>';
                $.ajax({
                    url: url,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        office_address_id: office_address_id,
                    },
                    success: function (response) {
                        if (response['department'] != '')
                        {
                            $('#department').html('<option value="">--Please Select--</option>');
                            $('#department').append(response['department']);
                        }


                    }
                });

            }



        }
    </script>
    <script type="text/javascript">
        //for pwd meter
        function checkpasswordstrength(id, lbl_id)
        {

            var pwd_strength_names = new Array("Very Weak", "Weak", "Medium", "Strong", "Very Strong");
            var req_pwd_strength = '<?php echo $req_pwd_strength ?>';
            var pwd_strenght = $("#" + id).html();
            var mypwdstrength = getPwdStrength(pwd_strenght);

            //document.getElementById(lbl_id).innerHTML = "";
            //alert( 'Strength caption: ' + pwd_strenght +  ' My Strength: ' + mypwdstrength + '  req strength: ' + req_pwd_strength );
            if (mypwdstrength < req_pwd_strength)
            {
                alert('Please Choose Password strength at least ' + pwd_strength_names[req_pwd_strength - 1]);
                //document.getElementById(lbl_id).innerHTML = 'Please Choose Password strength at least "' + pwd_strength_names[req_pwd_strength-1] + '" ' ;		
                return false;
            }
            else {
                return true;
            }

        }

        function getPwdStrength(strTitle)
        {
            var strength = 0;
            var myPwd = new Array("Very Weak", "Weak", "Medium", "Strong", "Very Strong");
            for (i = 0; i < myPwd.length; i++)
            {
                if (myPwd[i] == strTitle) {
                    //alert('Strength is ' + i );
                    strength = i + 1;
                }
            }

            return strength;
        }
    </script>
    <script type="text/javascript" >

        $(document).ready(function () {

            //for date


            //Check for submit
            $("#upd_passwd").click(function () {

                var password = $("#password2").val();
                var confirmpassword = $("#confirmpassword").val();
                var current_password = $("#current_password").val();
                var pass_strength = checkpasswordstrength('result', 'lbl_password');
                var msg = '';

                if (current_password.length <= 0) {
                    msg += "Please Enter current password.\n";
                }

                if (password.length <= 4) {
                    msg += "Please Enter new password with atleast 5 characters.\n";
                }

                if (password != confirmpassword) {
                    msg += "New password and confirm password did not matched.\n";
                }


                if (pass_strength == false) {
                    msg += "Please enter valid strength password.\n";
                }


                if (msg != '') {
                    alert(msg);
                    return false;
                }

                //If all is ok then go for update password
                //var password = $("#password2").val();
                //var confirmpassword = $("#confirmpassword").val();
                //var current_password = $("#current_password").val();

                var url = '<?php echo site_url("employee/ajax_updpassword"); ?>';
                $.ajax({
                    url: url,
                    dataType: 'json',
                    type: 'POST',
                    data: {password: password, current_password: current_password},
                    success: function (response) {
                        var msg = '<div class="alert alert-error">';
                        msg += '<a class="close" data-dismiss="alert">&times;</a>';
                        msg += '<strong>!&nbsp;</strong>' + response.message;
                        msg += '</div>	';


                        $("#flashmessages").html(msg);
                        hide_message('flashmessages');
                    }
                });

                /**
                 <div class="alert alert-error">';
                 html += '<a class="close" data-dismiss="alert">&times;</a>';
                 html += '<strong>Error!&nbsp;</strong>'+data;
                 html += '</div>
                 **/


            });


        });
    </script>
</body>
</html>