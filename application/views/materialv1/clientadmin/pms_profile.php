<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Admin</title>

    <!-- Common CSS -->
      <link href="<?php echo base_url(); ?>assets/material/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
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
                        <h2 class="lvh-label hidden-xs">Employee Profile</h2>
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
                             <form action="" method="post" name="frm_updateprofile" id="frm_updateprofile" >
                                <input type="hidden" name="pms_employee_id" id="pms_employee_id" value="<?php echo $empinfo['pms_employee_id']; ?>" />
                                  <div id="flashmessages" > </div>
                                <div class="col-sm-6">
                                    <div class="form-group fg-float" style="margin-bottom: 40px !important;">
                                        <label class="col-sm-4 control-label" for="firstName">First Name</label>
                                        <div class="col-sm-7">
                                            <div class="fg-line">
                                                <input name="fname" id="fname" type="text" value="<?php echo $empinfo['fname']; ?>" class="form-control fg-input">
                                                <label class="fg-label">First Name</label>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="form-group fg-float" style="margin-bottom: 40px !important;">
                                        <label class="col-sm-4 control-label" for="middlename">Middle Name</label>
                                        <div class="col-sm-7">
                                            <div class="fg-line">
                                                <input class="form-control fg-input" name="mname" id="mname" type="text" value="<?php echo $empinfo['mname']; ?>">
                                                <label class="fg-label">Password</label>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="form-group fg-float" style="margin-bottom: 40px !important;">
                                        <label class="col-sm-4 control-label" for="lastname">Last Name</label>
                                        <div class="col-sm-7">
                                            <div class="fg-line">
                                                <input class="form-control fg-input" name="lname" id="lname" type="text" value="<?php echo $empinfo['lname']; ?>">
                                                <label class="fg-label">Last Name</label>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="form-group fg-float" style="margin-bottom: 40px !important;">
                                        <label class="col-sm-4 control-label" for="employeeis">Employee ID</label>
                                        <div class="col-sm-7">
                                            <div class="fg-line">
                                                <input class="form-control fg-input" name="employeeid" id="employeeid" type="text" value="<?php echo $empinfo['employee_id']; ?>" disabled="disabled">
                                                <label class="fg-label">Employee ID</label>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="form-group fg-float" style="margin-bottom: 40px !important;">
                                        <label class="col-sm-4 control-label" for="email">Email</label>
                                        <div class="col-sm-7">
                                            <div class="fg-line">
                                                <input class="form-control fg-input" name="email" id="email" type="text" value="<?php echo $empinfo['email']; ?>">
                                                <label class="fg-label">Email</label>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="form-group fg-float" style="margin-bottom: 40px !important;">
                                        <label class="col-sm-4 control-label" for="gender">Gender</label>
                                        <div class="col-sm-7">
                                            <div class="fg-line">
                                                <select class="selectpicker" name="gender" id="gender" >
                                                    <option value="" >--Please Select--</option> 
                                                    <option value="M" <?php echo ( $empinfo['gender'] == 'M' ? ' selected="selected" ' : '' ); ?> >Male</option>
                                                    <option value="F" <?php echo ( $empinfo['gender'] == 'F' ? ' selected="selected" ' : '' ); ?> >Female</option>
                                                </select>
                                              </div>
                                        </div>
                                    </div><br>
                                    <div class="form-group fg-float" style="margin-bottom: 40px !important;">
                                        <label class="col-sm-4 control-label" for="selectbusiness">Select Business</label>
                                        <div class="col-sm-7">
                                            <div class="fg-line">
                                                <select class="selectpicker" name="business_list_dd" id="business_list_dd" disabled="">
                                                    <option value="">--Please Select Business--</option>
                                                    <?php
                                                    foreach ($business_list_data as $key1 => $val1) :
                                                        if ($val1->business_id == $empinfo['business_id']) {
                                                            ?>
                                                            <option value="<?php echo $val1->business_id; ?>" selected="selected"   ><?php echo $val1->business_subject; ?></option>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <option value="<?php echo $val1->business_id; ?>"><?php echo $val1->business_subject; ?></option>
                                                            <?php
                                                        }
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div><br>
                                   
                                </div>
                                <div class="col-sm-6">
                                     <div class="form-group fg-float" style="margin-bottom: 40px !important;">
                                        <label class="col-sm-4 control-label" for="company">Company</label>
                                        <div class="col-sm-7">
                                            <div class="fg-line">
                                                <select class="selectpicker" name="office_add_company" id="office_add_company" onblur="call_office_types()" disabled="disabled" >
                                                    <option value="">--Please select--</option> 
                                                    <?php
                                                    $o_a_cmp_select = '';
                                                    if (isset($company_master)) {
                                                        if (!empty($company_master)) {
                                                            foreach ($company_master as $key => $val) {
                                                                ?>
                                                                <option value="<?php echo $val->company_master_id; ?>" <?php echo $o_a_cmp_select; ?> <?php echo ( $empinfo['company_master_id'] == $val->company_master_id ? ' selected="selected" ' : '' ); ?> ><?php echo $val->company_name; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                             </div>
                                        </div>
                                    </div><br>
                                    <div class="form-group fg-float" style="margin-bottom: 40px !important;">
                                        <label class="col-sm-4 control-label" for="office">Office</label>
                                        <div class="col-sm-7">
                                            <div class="fg-line">
                                                <select class="selectpicker" name="offices_address" id="offices_address" onblur="profile_call_office_department()" disabled="disabled">
                                                    <option value="">--Please Select--</option>
                                                    <?php foreach ($result_office as $row) : ?>
                                                        <option value="<?php echo $row->office_addresses_id; ?>" <?php echo ( $empinfo['office_address_id'] == $row->office_addresses_id ? ' selected="selected" ' : '' ); ?> ><?php echo $row->office_name; ?></option>
                                                     <?php endforeach; ?>
                                                </select>
                                            </div>

                                        </div>
                                    </div> <br>
                                    <div class="form-group fg-float" style="margin-bottom: 40px !important;">
                                        <label class="col-sm-4 control-label" for="designation">Designation</label>
                                        <div class="col-sm-6">
                                            <div class="fg-line">
                                                <select class="selectpicker" name="designation" id="designation" style="float:left;" disabled="disabled">
                                                    <option value="">--Please Select--</option>
                                                    <?php
                                                       $designation = '';
                                                       if (isset($designations)) {
                                                           if (!empty($designations)) {
                                                               foreach ($designations as $key => $val) {
                                                                   ?>
                                                                       <option value="<?php echo $val->designation_id; ?>" <?php echo ( $empinfo['designation_id'] == $val->designation_id ? ' selected="selected" ' : '' ); ?> ><?php echo $val->designation_name; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                     ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                        <div id="dispalay_grade" style="width:85px;float:left; margin-left:5px;"><?php echo 'Grade: ' . $grade_deatil->grade_name; ?></div>  
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group fg-float" style="margin-bottom: 40px !important;">
                                        <label class="col-sm-4 control-label" for="department">Department</label>
                                        <div class="col-sm-7">
                                            <div class="fg-line">
                                                <select class="selectpicker" name="department" id="department" disabled="disabled">
                                                    <option value="">--Please Select--</option>
                                                        <?php
                                                        $department = '';

                                                        if (isset($departments)) {
                                                            if (!empty($departments)) {
                                                                foreach ($departments as $key => $val) {
                                                                    ?>
                                                                    <option value="<?php echo $val->department_id; ?>" <?php echo ( $empinfo['department_id'] == $val->department_id ? ' selected="selected" ' : '' ); ?> ><?php echo $val->department_name; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="form-group fg-float" style="margin-bottom: 40px !important;">
                                        <label class="col-sm-4 control-label" for="dob">Date Of Birth</label>
                                        <div class="col-sm-7">
                                            <div class="dtp-container dropdown fg-line">
                                                    <input type='text' class="form-control date-picker" data-toggle="dropdown" name="date_of_birth">
                                                </div>
                                                <!--  <div class="fg-line">
                                                <input class="form-control fg-input" name="date_of_birth" type="text" value="<?php echo $date_of_birth; ?>" data-date-start-view="0" data-date-format="<?php echo $js_date_format; ?>"  data-date="<?php echo $current_date; ?>" id="dob">
                                            </div>-->
                                        </div>
                                    </div><br>
                                    <div class="form-group fg-float" style="margin-bottom: 40px !important;">
                                        <label class="col-sm-4 control-label" for="mobile">Mobile No.</label>
                                        <div class="col-sm-7">
                                            <div class="fg-line">
                                                <input class="form-control fg-input" name="mobile_no" id="mobile_no"  type="text" value="">
                                                <label class="fg-label">Mobil Number</label>
                                           </select>
                                            </div>
                                        </div>
                                    </div><br>
                                       <div class="text-right m-r-20 m-t-5">
                                            <button class="btn bgm-cyan waves-effect m-l-20" type="button" name="updateprofile" value="Update Profile" id="updateprofile">Update Profile</button>
                                            <button class="btn bgm-cyan waves-effect" type="reset" name="reset" value="Reset" id="reset">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form> 
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
<!--<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>-->
<script src="<?php echo base_url("assets/clientadmin/"); ?>/js/pwd_strength_script.js"></script>
<!-- jQuery validation -->
<script src="<?php echo base_url("assets/clientadmin"); ?>js/lib/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo base_url("assets/clientadmin"); ?>js/pages/beoro_form_validation.js"></script>
<script src="<?php echo base_url(); ?>assets/material/vendors/bower_components/moment/min/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/material/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

<!-- jQuery validation -->
<script src="js/lib/jquery-validation/jquery.validate.min.js"></script>
    
<script type="text/javascript">
function call_to_chk_all_services()
{
	if ($('#allt').is(":checked"))
	{
		$("#tb1_a input:checkbox").attr("checked" ,true)
	}
	else
	{
		$("#tb1_a input:checkbox").attr("checked" ,false)
	}
}
</script>
<!--- start get office types of company --->
<script type="text/javascript" >
function call_office_types()
{
	
	var company_id = $("#office_add_company").val();
	
	if(company_id=='')
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
						company_id : company_id,
    		          },
				success: function(response) {
				if(response['offices']!='')
				{
					$('#offices_address').html('<option value="">--Please Select--</option>');
					$('#offices_address').append(response['offices']);
				}
				}	
    		});
	
	}
	
	
}
function profile_call_office_department()
{
	var selected_department = '<?php echo $empinfo['department_id']; ?>';
	var office_address_id = $("#offices_address").val();
	
	if(office_address_id=='')
	{
		alert("please select Office");
		return false;
	}
	else
	{
	var url = '<?php echo site_url("ajax/getDepartmentlistbyOfficeAddress/" . $empinfo['department_id'] ); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						office_address_id : office_address_id,
    		          },
				success: function(response) {
				if(response['department']!='')
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
function checkpasswordstrength(id,lbl_id)
{
	
	var pwd_strength_names=new Array("Very Weak","Weak","Medium", "Strong", "Very Strong");
	var req_pwd_strength = '<?php echo $req_pwd_strength ?>';
	var pwd_strenght = $("#"+id).html();
	var mypwdstrength = getPwdStrength(pwd_strenght);
	
	//document.getElementById(lbl_id).innerHTML = "";
	//alert( 'Strength caption: ' + pwd_strenght +  ' My Strength: ' + mypwdstrength + '  req strength: ' + req_pwd_strength );
	if( mypwdstrength < req_pwd_strength )
	{
			alert('Please Choose Password strength at least ' + pwd_strength_names[req_pwd_strength-1] );
		document.getElementById(lbl_id).innerHTML = 'Please Choose Password strength at least "' + pwd_strength_names[req_pwd_strength-1] + '" ' ;		
		return false;		
	}
	else{
		return true;
	}
	
}

function getPwdStrength(strTitle)
{
	var strength = 0;
	var myPwd=new Array("Very Weak","Weak","Medium", "Strong", "Very Strong");
	for( i=0; i< myPwd.length ; i++ )
	{
		if( myPwd[i] == strTitle ) {
			//alert('Strength is ' + i );
			strength = i + 1 ;
		} 	
	}
	
	return strength ;
}
</script>
<script type="text/javascript" >
hide_message('flashmessages');
$(document).ready(function() {

	//for date
	 if($('#dob').length) { $('#dob').datepicker(); }
	 if($('#dp1').length) { $('#dp1').datepicker(); }
	 if($('#dp2').length) { $('#dp2').datepicker(); }
			

     $("form").submit(function() {
     var frm = $('#validate_field_types');
	
        $.ajax({
            type: frm.attr('method'),
            url: '<?php echo base_url('employee/addemployeedata'); ?>',
            data: frm.serialize(),
            success: function (data) {
				
				 var html ='';
				$('#reset').click();
				
				if(data=='Please try again'){
				html += '<div class="alert alert-error">';
                html += '<a class="close" data-dismiss="alert">&times;</a>';
                html += '<strong>Error!&nbsp;</strong>'+data;
                html += '</div>';
				}
				else
				{
					html += '<div class="alert alert-success">';
                    html += '<a class="close" data-dismiss="alert">&times;</a>';
                    html += '<strong>Success!</strong> '+data;
                    html += '</div>';
				}
				$('#flashmessages').html('');
				//$('#register').css('background-color','#FFFFFF');
				$('#register').html('<span id="result"></span>');
				$('#flashmessages').after(html);
				$("html, body").animate({ scrollTop: 0 }, "slow");
				hide_message('flashmessages');
				               // alert('ok'); 
				
               // $('#result').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown){
            // log the error to the console
            console.log(
                "The following error occured: "+
                textStatus, errorThrown
            );
            }
 
        });
 
        return false;
    });
	
	
//Update profile
	$("#updateprofile").click( function() {
		
		$("#flashmessages").html('');
		var frm = $('#frm_updateprofile');
		$.ajax({
            type: frm.attr('method'),
            url: '<?php echo base_url('employee/profileupdate'); ?>',
            data: frm.serialize(),
			dataType: 'json',
            success: function (response) {
				
				var msg = '<div class="alert alert-error">';
                msg += '<a class="close" data-dismiss="alert">&times;</a>';
                msg += '<strong>!&nbsp;</strong>'+response.message;
                msg += '</div>	';
				$("#flashmessages").html(msg);
			},
            error: function(jqXHR, textStatus, errorThrown){
            // log the error to the console
            console.log(
                "The following error occured: "+
                textStatus, errorThrown
            );
            }
 
        });
		
		
		
		
	});	
	
	
});
</script>
<script type="text/javascript" >
$('#designation').live('change', function() {
	var designation_id = $('#designation').val();
	if(designation_id!=''){

	var url = '<?php echo site_url("clientadmin/getdesignationgrade"); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						designation_id : designation_id,
    		          },
				success: function(response) {
				if(response['grade']!=null)
				{
					//$('#department').html('<option value="">--Please Select--</option>');
					//$('#department').append(response['department']);
					//alert(response['grade']['grade_name']);
					$('#dispalay_grade').html('<span>Grade: &nbsp;'+response['grade']['grade_name']+'</span> ');
				}
				
			
				}	
    		});
		}






});
//Default call 

</script>
</body>
</html>