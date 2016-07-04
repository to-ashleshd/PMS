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
                        <h2 class="lvh-label hidden-xs">Site Settings (Product) > General Setting</h2>
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
                            <div class="row">
                                <div class="col-sm-12">
                                    <div role="tabpanel" class="tab">
                                        
                                        <?php $this->session->unset_userdata('warning');?>
				  <?php $this->session->unset_userdata('success');?>
                                        
                                        <ul class="tab-nav" role="tablist" data-tab-color="red">
                                            <li class="<?php echo (($tab == '' or $tab == 'general')? 'active' : '') ?> "><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a></li>
                                            <li role="presentation" class="<?php echo ($tab == 'mailsetting'? 'active' : '') ?>"><a href="#mailsetting" aria-controls="mailsetting" role="tab" data-toggle="tab">Mail Setting</a></li>
                                            <li role="presentation" class="<?php echo ($tab == 'language'? 'active' : '') ?>"><a href="#language" aria-controls="language" role="tab" data-toggle="tab">Language Date & Time</a></li>
                                             <li role="presentation" class="<?php echo ($tab == 'security'? 'active' : '') ?>"><a href="#security" aria-controls="security" role="tab" data-toggle="tab">Security & Other Setting</a></li>
                                              <li role="presentation" class="<?php echo ($tab == 'emailtemplate'? 'active' : '') ?>"><a href="#emailtemplate" aria-controls="emailtemplate" role="tab" data-toggle="tab">Email Template</a></li>
                                        </ul>
                                      
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active animated fadeInRight in <?php echo (($tab == '' or $tab == 'general') ? 'active' : '') ?>" id="general">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                     <form name="frm_general" method="post" enctype="multipart/form-data"  >
                                                     <label>Company Logo</label>
                                                          <img src="<?php echo base_url("uploads"); ?>/<?php echo $logo; ?>" height="43" width="132" alt="Logo"  /> <br />
                                                        <input type="file" name="userfile" id="file">
                                                                                    <br /><br />
                                                                                    <p><span class="help-block help-last">Valid Logo formats .gif .jpg .png .jpeg - Maximum File size to upload Width: 1024px X Height: 768px<br />
                                                                                    Logo Size - Width: 132px X Height: 43px</span></p>							
                                                        <!-- End Image Upload -->
                                                        <br>
                                                        <div class="form-group fg-float" style="margin-bottom: 40px !important;">
                                                          <label class="col-sm-4 control-label" for="s_name">Site Name</label>
                                                                <div class="col-sm-7">
                                                                    <div class="fg-line">
                                                                        <input id="gen_site_name" type="text" name="gen_site_name" value="<?php echo $gen_site_name; ?>" class="form-control fg-input">
                                                                        <label class="fg-label">Site Name</label>
                                                                    </div>
                                                                </div>
                                                        </div><br>
                                                        
                                                        <div class="checkbox m-b-15">
                                                        <label>
                                                            <input type="checkbox" value="">
                                                            <i class="input-helper"></i>
                                                            Option one is this and that-be sure to include why it's great
                                                        </label>
                                                    </div>
                                                        
                                                        
                                                      <div class="formSep">
                                                        <label for="s_clientreg">Allow Client Registration</label>
                                                        <input name="gen_clientreg" type="checkbox" id="gen_clientreg" value="Y" <?php echo ($gen_clientreg == 'Y' ? ' checked="checked" ' : '') ?> />
                                                      </div>
                                                      <div class="formSep">
                                                        <label >Rows per page in List</label>
                                                        <select name="gen_rows_per_page" class="span4" id="gen_rows_per_page">
                                                          <option value="10" <?php echo ($gen_rows_per_page == '10' ? ' selected="selected" ' : '') ?> >10</option>
                                                          <option value="25" <?php echo ($gen_rows_per_page == '25' ? ' selected="selected" ' : '') ?> >25</option>
                                                          <option value="50" <?php echo ($gen_rows_per_page == '50' ? ' selected="selected" ' : '') ?> >50</option>
                                                          <option value="100" <?php echo ($gen_rows_per_page == '100' ? ' selected="selected" ' : '') ?> >100</option>
                                                        </select>
                                                      </div>
                                                 
                        <div class="span6">
                          <div class="formSep">
                            <label for="s_offline">Site Offline</label>
                            <input name="gen_is_offline" type="checkbox" id="gen_is_offline" value="Y" <?php echo ($gen_is_offline == 'Y' ? ' checked="checked" ' : '') ?>  />
                          </div>
                          <div class="formSep" id="offilne_message">
                            <label for="s_off_message">Offline Message</label>
                            <textarea name="gen_off_message" id="gen_off_message" cols="30" rows="4" class="span8"><?php echo $gen_off_message; ?></textarea>
                          </div>
                          <div class="formSep">
                            <label for="themeMode">Theme Template</label>
                            <select id="themeMode" name="gen_theme_template" class="span8">
                              <option value="default" <?php echo ($gen_theme_template == 'default' ? ' selected="selected" ' : '') ?>>Default</option>
                              </select>
                            <span class="help-block help-last">Select the theme.</span> <br>
                            <input  class="btn btn-beoro-3" type="submit" name="submit" value="Update Setting" />
                          </div>
                        </div>
                        <input type="hidden" name="current_tab" value="tb1_a" />
                      </form> 
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane animated fadeInRight" id="mailsetting">
                                                <p>Morbi mattis ullamcorper velit. Etiam rhoncus. Phasellus leo dolor, tempus non, auctor et, hendrerit quis, nisi. Cras id dui. Curabitur turpis.
                    Etiam ut purus mattis mauris sodales aliquam. Aenean viverra rhoncus pede. Nulla sit amet est. Donec mi odio, faucibus.</p>
                                            </div>
                                            <div role="tabpanel" class="tab-pane animated fadeInRight" id="language">
                                                <p>Etiam rhoncus. Phasellus leo dolor, tempus non, auctor et, hendrerit quis, nisi. Cras id dui. Curabitur turpis.
                    Etiam ut purus mattis mauris sodales aliquam. Aenean viverra rhoncus pede. Nulla sit amet est. Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi. Praesent ac sem eget est egestas volutpat.</p>
                                            </div>
                                             <div role="tabpanel" class="tab-pane animated fadeInRight" id="security">
                                                <p>Etiam rhoncus. Phasellus leo dolor, tempus non, auctor et, hendrerit quis, nisi. Cras id dui. Curabitur turpis.
                    Etiam ut purus mattis mauris sodales aliquam. Aenean viverra rhoncus pede. Nulla sit amet est. Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi. Praesent ac sem eget est egestas volutpat.</p>
                                            </div>
                                            <div role="tabpanel" class="tab-pane animated fadeInRight" id="emailtemplate">
                                                <p>Etiam rhoncus. Phasellus leo dolor, tempus non, auctor et, hendrerit quis, nisi. Cras id dui. Curabitur turpis.
                    Etiam ut purus mattis mauris sodales aliquam. Aenean viverra rhoncus pede. Nulla sit amet est. Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi. Praesent ac sem eget est egestas volutpat.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
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