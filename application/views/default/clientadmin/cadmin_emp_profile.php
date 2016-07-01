<?php echo $header; ?>
<style>
.tabbable-bordered .nav-tabs > li.active {
	border-top: 5px solid #368CA9;
    margin-top: 0;
    position: relative;
	border-radius:5px;
}

.checkbox.inline { width:250px; margin-right:0px; }
</style>
<style>
.mystyle{
	margin-top: 4px;
    width: 20%;
}
</style>
<link rel="stylesheet" href="<?php echo base_url("assets/clientadmin/"); ?>/css/pwd_strength_style.css">
<?php
	  $id='';
	  ?>
<!-- main content -->
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12">
      <div class="w-box">
        <div class="w-box-header">
          <h4>Employee Profile</h4>
        </div>
        <form action="" method="post" name="frm_updateprofile" id="frm_updateprofile" >
		<input type="hidden" name="pms_employee_id" id="pms_employee_id" value="<?php echo $empinfo['pms_employee_id']; ?>" />
          <div class="w-box-content cnt_b">
          <div class="row-fluid">
            <div class="span12">
              <div class="tabbable tabbable-bordered">
                <ul class="nav nav-tabs">
                </ul>
                <div class="tab-content">
                  <div id="flashmessages" > </div>
                  <div id="tb1_a" class="tab-pane active">
                    <div class="span6">
				
                      <!--<div class="formSep">
                          <span class="span4">Login Type</span>
                          <select name="login_type" id="login_type" >
							  <option value="" >--Please Select--</option>
							  <option value="email">Email</option>
							  <option value="employeeid">Employee Id</option>
							  <option value="mobileno">Mobile No.</option>
						  </select>
                        </div>-->
                      <div class="formSep"> <span class="span4 req">First Name</span>
                        <input name="fname" id="fname" type="text" value="<?php echo $empinfo['fname']; ?>" >
                      </div>
                      <div class="formSep"> <span class="span4 req">Middle Name</span>
                        <input name="mname" id="mname" type="text" value="<?php echo $empinfo['mname']; ?>"  >
                      </div>
                      <div class="formSep"> <span class="span4 req">Last Name</span>
                        <input name="lname" id="lname" type="text" value="<?php echo $empinfo['lname']; ?>" >
                      </div>
                      <div class="formSep"> <span class="span4">Employee ID</span>
                        <input name="employeeid" id="employeeid" type="text" value="<?php echo $empinfo['employee_id']; ?>" disabled="disabled">
                      </div>
                      <div class="formSep"> <span class="span4 req">Email</span>
                        <input name="email" id="email" type="text" value="<?php echo $empinfo['email']; ?>" >
                      </div>
                      <div class="formSep"> <span class="span4">Gender</span>
                        <select name="gender" id="gender" >
                          <!-- <option value="" >--Please Select--</option> -->
                          <option value="M" <?php echo ( $empinfo['gender'] == 'M' ? ' selected="selected" ' : '' ); ?> >Male</option>
                          <option value="F" <?php echo ( $empinfo['gender'] == 'F' ? ' selected="selected" ' : '' ); ?> >Female</option>
                        </select>
                      </div>
					  
					  <!-- Add Business -->
						<div class="formSep">
                            <label class="span4">Select Business</label>
                            <select  name="business_list_dd" id="business_list_dd" disabled="disabled" >
								<option value="">--Please Select Business--</option>
								<?php foreach( $business_list_data as $key1=>$val1 ) : 
									if($val1->business_id==$empinfo['business_id'])
									{
									?>
									<option value="<?php echo $val1->business_id; ?>" selected="selected"   ><?php echo $val1->business_subject; ?></option>
								<?php 
									}
									else
									{
								?>
									<option value="<?php echo $val1->business_id; ?>"><?php echo $val1->business_subject; ?></option>
								<?php 
								}
								endforeach; ?>
                              
							 </select>
						</div>					  
					  <!-- End Business -->
					  
                      <div class="formSep"> <span class="span4 req">Company</span>
                        <select  name="office_add_company" id="office_add_company" onblur="call_office_types()" disabled="disabled" >
                          <!-- <option value="">--Please select--</option> -->
                          <?php
						   $o_a_cmp_select ='';
						  if(isset($company_master))
						  {
						  	if(!empty($company_master))
							{
								foreach($company_master as $key=>$val)
								{                                         
								?>
                          <option value="<?php echo $val->company_master_id; ?>" <?php echo  $o_a_cmp_select; ?> <?php echo ( $empinfo['company_master_id'] ==  $val->company_master_id ? ' selected="selected" ' : '' ); ?> ><?php echo $val->company_name; ?></option>
                          <?php
                    			}
                                                                
							}
						  }
						  ?>
                        </select>
                      </div>
                      <div class="formSep"> <span class="span4 req">Office</span>
                        <select name="offices_address" id="offices_address" onblur="profile_call_office_department()" disabled="disabled" >                          
						<!-- Display office address -->
						<?php foreach ( $result_office as $row ) : ?>
							<option value="<?php echo $row->office_addresses_id; ?>" <?php echo ( $empinfo['office_address_id'] ==  $row->office_addresses_id ? ' selected="selected" ' : '' ); ?> ><?php echo $row->office_name; ?></option>
						<?php endforeach; ?>
                        </select>						
                      </div>
                    </div>
                    <div class="span6">
                      <div class="formSep"> <span class="span4 req">Designation</span>
                        <select name="designation" id="designation" style="float:left;" disabled="disabled"  >
                          <option value="">--Please Select--</option>
						  
						  
                          <?php 
						  $designation ='';
						  if(isset($designations))
						  {
						  	if(!empty($designations))
							{
								foreach($designations as $key=>$val)
								{
								?>
                          <option value="<?php echo $val->designation_id; ?>" <?php echo ( $empinfo['designation_id'] ==  $val->designation_id ? ' selected="selected" ' : '' ); ?> ><?php echo $val->designation_name; ?></option>
                          <?php
                    			}
                                                                
							}
						  }						  
						  ?>
                        </select>
                        
                        <div id="dispalay_grade" style="width:85px;float:left; margin-left:5px;"><?php echo 'Grade: ' . $grade_deatil->grade_name; ?></div>
						<br />
						<div style="clear:both"></div>
                      </div>
                      <div class="formSep">
                        <label class="span4 req">Department</label>
                        <select name="department" id="department" disabled="disabled">
                          <option value="">--Please Select--</option>
                          <?php
						   $department ='';
						  
						  if(isset($departments))
						  {
						  	if(!empty($departments))
							{
								foreach($departments as $key=>$val)
								{
								?>
                          <option value="<?php echo $val->department_id; ?>" <?php echo ( $empinfo['department_id'] ==  $val->department_id ? ' selected="selected" ' : '' ); ?> ><?php echo $val->department_name; ?></option>
                          <?php
                    			}
                                                                
							}
						  }
						  ?>
                        </select>
                      </div>
                      <div class="formSep"> <span class="span4 req">Date Of Birth</span>
                        <input name="date_of_birth" type="text" value="<?php echo $date_of_birth; ?>" data-date-start-view="0" data-date-format="<?php echo $js_date_format; ?>"  data-date="<?php echo $current_date; ?>" id="dob">
                      </div>
					  <!--
                      <div class="formSep"> <span class="span4 req">Date Of Joining</span>
                        <input type="text" name="date_of_joining" value="<?php echo $date_of_joining; ?>" data-date-start-view="0" data-date-format="<?php echo $js_date_format; ?>"  data-date="<?php echo $current_date; ?>" id="dp1" disabled="disabled">
                      </div>
                      <div class="formSep"> <span class="span4">Last Pramotion Date</span>
                        <input name="pramotiondate" type="text" value="<?php echo $last_pramotion_date; ?>" data-date-start-view="0" data-date-format="<?php echo $js_date_format; ?>" data-date="<?php echo $current_date; ?>" id="dp2" disabled="disabled">
                      </div>
					  -->
                      <div class="formSep"> <span class="span4">Mobile No.</span>
                        <input name="mobile_no" id="mobile_no"  type="text" value="">
                      </div>
                      
                      
                    </div>
                    <div class="formSep">
                      <div align="center">
                        <input type="button" name="updateprofile" value="Update Profile" id="updateprofile" class="btn btn-beoro-3">
                        <input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $middle_footer; ?> <?php echo $common_js; ?>
<!-- datepicker -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url("assets/clientadmin/"); ?>/js/pwd_strength_script.js"></script>
<!-- jQuery validation -->
<script src="<?php echo base_url("assets/clientadmin"); ?>js/lib/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo base_url("assets/clientadmin"); ?>js/pages/beoro_form_validation.js"></script>
<!-- jQuery validation -->
<script src="js/lib/jquery-validation/jquery.validate.min.js"></script>
<script type="text/javascript">

</script>
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
<?php
/**
echo '<pre>';
print_r($empinfo);
echo '</pre>';
**/
?>
<?php echo $last_footer; ?> 