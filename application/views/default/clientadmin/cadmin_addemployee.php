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
        <h4>Add Employee</h4>
      </div>
	
      <form action="" method="post" name="add_employee" id="validate_field_types" >
        <input type="hidden" name="pms_employee_id" id="pms_employee_id" value="<?php if(isset($pms_employee_id)){ echo $pms_employee_id; } ?>"  />
		<div class="w-box-content cnt_b"> 
          <div class="row-fluid">
            <div class="span12">
              <div class="tabbable tabbable-bordered">
                <ul class="nav nav-tabs">
				 
                </ul>
                <div class="tab-content">
				<div id="flashmessages" >
				</div>
				
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
			   			 <div class="formSep">
                          
						  <span class="span4 req">First Name</span>
                          <input name="fname" id="fname" type="text" value="<?php if(isset($employee_detail)){ echo $employee_detail['fname']; } ?>">
                        </div>
						
						  <div class="formSep">
                          <span class="span4 req">Middle Name</span>
                          <input name="mname" id="mname" type="text" value="<?php if(isset($employee_detail)){ echo $employee_detail['mname']; } ?>">
                        </div>
						
                        <div class="formSep">
                          <span class="span4 req">Last Name</span>
                          <input name="lname" id="lname" type="text" value="<?php if(isset($employee_detail)){ echo $employee_detail['lname']; } ?>">
                        </div>
                        <div class="formSep">
                          <span class="span4">Employee ID</span>
                          <input name="employeeid" id="employeeid" type="text" value="<?php if(isset($employee_detail)){ echo $employee_detail['employee_id']; } ?>">
                        </div>
                      
                        <div class="formSep">
                          <span class="span4 req">Email</span>
                          <input name="email" id="email" type="text" value="<?php if(isset($employee_detail)){ echo $employee_detail['email']; } ?>">
                        </div>
						 <div class="formSep">
                          <span class="span4">Gender</span>
						 
                          <select name="gender" id="gender" >
							  <option value="" >--Please Select--</option>
							   <?php 
						  if(isset($employee_detail)){ 
						  	 
							if($employee_detail['gender']=='M')
							{ 
								 ?> <option value="M" selected="selected">Male</option><?php
							}
							else if($employee_detail['gender']=='F'){
							 	?><option value="F" selected="selected" >Female</option><?php
							  }
						  
						   } else { ?>
						   <option value="M">Male</option>
   					       <option value="F">Female</option>
						   <?php
						   }
						   ?>
						  </select>
                        </div>
						
						<!-- Business Tab -->
						<div class="formSep">
                            <label class="span4">Select Business</label>
							
                            <select  name="business_list_dd" id="business_list_dd" >
								<option value="">--Please Select Business--</option>
								<?php
							if(isset($employee_detail))
							{
								 foreach( $business_list as $key1=>$val1 ) : 
								 	if($employee_detail['business_id']==$val1['business_id']): ?>
									<option value="<?php echo $val1['business_id']; ?>" selected="selected" ><?php echo $val1['business_subject']; ?></option>
									<?php 
									else :
									?><option value="<?php echo $val1['business_id']; ?>"><?php echo $val1['business_subject']; ?></option>
									<?php
								endif;
								endforeach; 
							}
							else
							{
							?>
							<?php foreach( $business_list as $key1=>$val1 ) : ?>
									<option value="<?php echo $val1['business_id']; ?>"><?php echo $val1['business_subject']; ?></option>
								<?php endforeach; ?>
							<?php
							}
							?>
                              
							 </select>
						</div>			
						<!-- End Business tab -->			
						
						
						
						<div class="formSep">
                          <span class="span4 req">Company</span>
							<!-- onblur changed to onchange -->
                       		  <select  name="office_add_company" id="office_add_company" onchange="call_office_types()">
                           <option value="">--Please select--</option>
						   <?php
							if(isset($employee_detail))
							{
								 foreach($company_list as $key1=>$val1 ) : 
								 	if($employee_detail['company_master_id']==$val1['company_master_id']): ?>
									<option value="<?php echo $val1['company_master_id']; ?>" selected="selected" ><?php echo $val1['company_name']; ?></option>
									<?php 
									else :
									?><option value="<?php echo $val1['company_master_id']; ?>"><?php echo $val1['company_name']; ?></option>
									<?php
								endif;
								endforeach; 
							}
							?>
                          </select>
                        </div>
					
						<div class="formSep">
                          <span class="span4 req">Office</span>
						  <!-- onblur changed to onchange -->
                      	<select name="offices_address" id="offices_address" onchange="call_office_department()" >
						<option value="" >--Please Select--</option>
						 <?php
							if(isset($employee_detail))
							{
								 foreach($offices_list as $key1=>$val1 ) : 
								 	if($employee_detail['office_addresses_id']==$val1['office_address_id']): ?>
									<option value="<?php echo $val1['office_address_id']; ?>" selected="selected" ><?php echo $val1['office_name']; ?></option>
									<?php 
									else :
									?><option value="<?php echo $val1['office_address_id']; ?>"><?php echo $val1['office_name']; ?></option>
									<?php
								endif;
								endforeach; 
							}
							?>
						</select>
                        </div>
						
							</div>
                    
						<div class="span6">
                        
					
						<div class="formSep">
                          <span class="span4 req">Designation</span>
                         <select name="designation" id="designation"  >
						 <option value="">--Please Select--</option>
						
						  <?php 
						  $designation ='';
						   if(isset($designations))
						  {
						  	if(!empty($designations))
							{
										
								if(isset($employee_detail))
									{
										foreach($designations as $key=>$val)
										{
										if($employee_detail['designation_id']==$val->designation_id)
										{
										?>
										<option value="<?php echo $val->designation_id; ?>" selected="selected"><?php echo $val->designation_name; ?></option>
										<?php
										}
										else
										{
										?>	<option value="<?php echo $val->designation_id; ?>" ><?php echo $val->designation_name; ?></option><?php
										}
										}
									}
									else
									{
								
								foreach($designations as $key=>$val)
								{
								?>
								<option value="<?php echo $val->designation_id; ?>" <?php echo  $designation; ?> ><?php echo $val->designation_name; ?></option>
								<?php
                    			}
                               }                           
							}
						  }
						  
						  ?>
						   </select>
						   <!--
						   <br />						   
						    <span class="span4"></span> 
							
						  <!-- <div id="dispalay_grade"></div> -->
                        </div>
					
						 
						<div class="formSep">
						 <label class="span4 req">Department</label>
						 <select name="department" id="department">
						 <option value="">--Please Select--</option>
						<?php
							if(isset($employee_detail))
							{
								 foreach($department_list as $key1=>$val1 ) : 
								 	if($employee_detail['department_id']==$val1['department_id']): ?>
									<option value="<?php echo $val1['department_id']; ?>" selected="selected" ><?php echo $val1['department_name']; ?></option>
									<?php 
									else :
									?><option value="<?php echo $val1['department_id']; ?>"><?php echo $val1['department_name']; ?></option>
									<?php
								endif;
								endforeach; 
							}
							?>
						 </select>
                        </div>
						 
						 
						  <div class="formSep">
                          <span class="span4 req">Date Of Birth</span>
						  <?php
						  $date_of_birth = $current_date;
							if(isset($employee_detail))
							{
								$date_of_birth = date($s_date_format,strtotime($employee_detail['date_of_birth']));
							}
							?>
                        <input name="date_of_birth" type="text" value="<?php echo $date_of_birth; ?>" data-date-start-view="0" data-date-format="<?php echo $js_date_format; ?>"  data-date="<?php echo $current_date; ?>" id="dob">
                        </div>
						 
						 
						<div class="formSep">
                          <span class="span4 req">Date Of Joining</span>
						   <?php
						  $date_of_joinning = $current_date;
							if(isset($employee_detail))
							{
								$date_of_joinning = date($s_date_format,strtotime($employee_detail['date_of_joining']));
							}
							?>
                        <input type="text" value="<?php echo $date_of_joinning; ?>" data-date-start-view="0" data-date-format="<?php echo $js_date_format; ?>"  data-date="<?php echo $current_date; ?>" id="dp1" name="date_of_joining">
                        </div>
						
						<!-- <div class="formSep">
                          <span class="span4">Last Pramotion Date</span>
                          <input name="pramotiondate" id="dp2" data-date-start-view="0" data-date-format="<?php //echo $js_date_format; ?>" data-date="<?php echo $current_date; ?>" type="text" value="">
                        </div>-->
							 <div class="formSep">
							  <span class="span4">Select Year to Add KRA</span>
							 <select name="time_period_id" id="time_poeriod_id" >
							 	<option value="">--Please Select--</option>
								
								<?php
									if(isset($time_period_list))
									{
										if(!empty($time_period_list))
										{
											if(isset($employee_detail))
											{
												foreach($time_period_list as $key=>$val)
												{
													if($employee_detail['start_time_period_id']==$val['time_period_id'])
													{
												?><option value="<?=$val['time_period_id'];?>" selected="selected"><?php echo $val['time_period_from'].'-'.$val['time_period_to']; ?></option><?php
													}
													else
													{
													?><option value="<?=$val['time_period_id'];?>" ><?php echo $val['time_period_from'].'-'.$val['time_period_to']; ?></option><?php
													
													}
												}
											}
											else
											{
												foreach($time_period_list as $key=>$val)
												{
												?><option value="<?=$val['time_period_id'];?>"><?php echo $val['time_period_from'].'-'.$val['time_period_to']; ?></option><?php
												}
											}
										}
									}
								?>
							 </select>
							 </div>
							 
							 
						 <div class="formSep">
                          <span class="span4">Mobile No.</span>
                          <input name="mobile_no" id="mobile_no"  type="text" value="<?php
						  if(isset($employee_detail))
						  {
						    echo $employee_detail['mobile_no'];
						  }
						  ?>">
                        </div>
						
						<?php
						  if(!isset($employee_detail))
						  {
						  ?>
						
						 <div class="formSep">
							<label class="span4 req">Password:</label>
							
							  <input style="float:left;" type="password" name="password" placeholder="Password" id="password2" onblur="checkpasswordstrength('result', 'lbl_password');" class="validate[required]"  >
							  <div id="register" style="float:left; width:90px; height:25px; margin-left:5px;"><span id="result"></span></div>
							  <!--<div id="register" style="margin-left:135px;"><span id="result"></span></div>-->
							  <div style="clear:both"></div>
							
						  </div>
						  
						   <div class="formSep">
						   <label class="span4">Confirm Passoword</label>
						   <input type="password" name="confirmpassword" placeholder="Confirm Password" id="confirmpassword"  class="validate[required,equals[password2]]"  >
						  
						 </div>
						
                      </div>
                  <?php } ?>
			
						
					   </div>
					  </div>
					  
					  <div class="formSep">
            			<div align="center">
						<?php
						$button_name ='Save';
						  if(isset($employee_detail))
						  {
						  	$button_name = 'Update';
						  }
						  ?>
						
                        <input type="submit" name="submit" value="<?php echo $button_name; ?>" id="submit" class="btn btn-beoro-3">
                        <?php
						if(isset($employee_detail))
						  {
						  ?>
						  <a class="btn btn btn-small" href="<?php echo base_url('employee'); ?>" title="cancel" name="cancel">Cancel</a>
						 
						  <?php
						  }
						  else
						  {
						  ?>
						<input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
						<?php } ?>
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
<?php echo $middle_footer; ?>
<?php echo $common_js; ?>
<!-- datepicker -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url("assets/clientadmin/"); ?>/js/pwd_strength_script.js"></script>
   <!-- jQuery validation -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>js/lib/jquery-validation/jquery.validate.min.js"></script>
			 <script src="<?php echo base_url("assets/clientadmin"); ?>js/pages/beoro_form_validation.js"></script>
<!-- jQuery validation -->
<script src="js/lib/jquery-validation/jquery.validate.min.js"></script>
<script type="text/javascript">
hide_message('flashmessages');
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

/** For Business **/
//Added By Ajay
//TODO: fix Need to make common
function hidemsg(divid)
	{
		//alert('Hide ' + divid);
		setTimeout(function(){ $(".alert-success").fadeOut(2000); }, 3000);
	}


$("#business_list_dd").change(function() {
	
	
	var business_id = $("#business_list_dd").val();
	var pms_employee_id = '<?php echo $this->session->userdata('pms_employee_id'); ?>';
	//alert(business_id );
	
	if(business_id=='')
	{
		alert("Please select Business");
		$('select[id=\'office_add_company\']').html('<option value="">--Please select--</option>');
		$('select[id=\'office_type_office_add\']').html('<option value="">--Please select--</option>');
		
		return false;
	}
	else
	{
	var url = '<?php echo site_url("ajax/getcompanylistbybusiness_and_acl"); ?>';
		 $.ajax({
			url: url,
			dataType: 'json',
			type: 'POST',
			data: {
					business_id : business_id,
					pms_employee_id:pms_employee_id
				  },
			success: function(response) {
				//alert(response.company_list);
				
				if( response.company_list == '' ) {
					$('select[id=\'office_add_company\']').html('<option value="">-- No associated company --</option>');
				}
				else {
					$('select[id=\'office_add_company\']').html('<option value="">--Please select--</option>');
					$('select[id=\'office_add_company\']').append(response['company_list']);
				}	
				//On change reset office selection
				$('select[id=\'offices_address\']').html('<option value="">--Please select--</option>');
				
			
			}	
		});
	
	}	
	
});






function call_office_types()
{
	
	var company_id = $("#office_add_company").val();
	var pms_employee_id = '<?php echo $this->session->userdata('pms_employee_id'); ?>';
	
	if(company_id=='')
	{
		alert("please select Company");
		return false;
	}
	else
	{
	var url = '<?php echo site_url("ajax/getofficeaddresslistbycomany_with_acl"); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						company_id : company_id,
						pms_employee_id:pms_employee_id
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
function call_office_department()
{

	var office_address_id = $("#offices_address").val();
	
	if(office_address_id=='')
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

$(document).ready(function() {

	//for date
	 if($('#dob').length) {
                $('#dob').datepicker()
            }
			

     $("form").submit(function() {
     var frm = $('#validate_field_types');
	 //check primary validation
	 var msg = '';
	 var fname = $("#fname").val();
	 var lname = $("#lname").val();
	 var email = $("#email").val();
	 var gender = $("#gender").val();
	 var date_of_birth = $("#dob").val();
	 var date_of_joining = $("#dp1").val();
	 var time_poeriod_id = $("#time_poeriod_id").val();
	 var pms_employee_id = $('#pms_employee_id').val();
	 var company = $('#office_add_company').val();
	 var office = $('#offices_address').val();
	 var designation = $('#designation').val();
	 var department = $('#department').val();
	 
	 
	 
	 if(pms_employee_id!='')
	 {
	 	var password = $("#password2").val();
	 	var confirmpassword = $("#confirmpassword").val();
     }
	 var business_list_dd = $("#business_list_dd").val();
	 	 
	 if( fname == '' ) {
	 	msg += 'Please select first name.\n' ;
	 }
	 
	 if( lname == '' ) {
	 	msg += 'Please select last name.\n' ;
	 }
	 
	 if( email == '' ) {
	 	msg += 'Please select Email.\n' ;
	 }
	 
	 if( gender == '' ) {
	 	msg += 'Please select Gender.\n' ;
	 }
	 
	 if(business_list_dd == '' ) {
	 	msg += 'Please select Business.\n' ;
	 }
	 
	 if( date_of_birth == '' ) {
	 	msg += 'Please select Date of Birth.\n' ;
	 }
	 
	 if( date_of_joining == '' ) {
	 	msg += 'Please select Date of Joining.\n' ;
	 }
	 
	 if( time_poeriod_id == '' ) {
	 	msg += 'Please select Time Period.\n' ;
	 }
	 
	 if(company==''){
	 	msg += 'Please select Company.\n' ;
	 }
	 
	 if(office==''){
	 	msg += 'Please select Office.\n' ;
	 }
	 
	  if(designation==''){
	 	msg += 'Please select Designation.\n' ;
	 }
	 
	  if(department==''){
	 	msg += 'Please select department.\n' ;
	 }
	 
	 if(pms_employee_id!='')
	 {
		 if( password == '' ) {
			msg += 'Please enter password at least 5 characters.\n' ;
		 }
		 
		 if( password != confirmpassword ) {
			msg += 'Please retype confirm password.\n' ;
		 }
      }
	 
	 if( msg != '' ) {
	 	alert(msg);
		return false;
	 }
	
        $.ajax({
            type: frm.attr('method'),
            url: '<?php echo $action; ?>',
            data: frm.serialize(),
            success: function (data) {
				
				 var html ='';
				$('#reset').click();
				if(pms_employee_id!='')
	 			{
					window.location = '<?php echo site_url('employee'); ?>';
				}
				else
				{
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
						$('#flashmessages').show();
						
						//$('#register').css('background-color','#FFFFFF');
						$('#register').html('<span id="result"></span>');
						$('#register').removeClass();
						//$('#register').addClass();
						$('#flashmessages').after(html);
						$("html, body").animate({ scrollTop: 0 }, "slow");
						hide_message('flashmessages');
						//Clear msg
				        hidemsg('flashmessages');
			   }			
						
						
						
				
				
				               
							   
							   
				
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
});
</script>
<script type="text/javascript" >
/**
$('#designation').live('blur', function() {
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
					//comment By Ajay - No need to display grade
					////$('#dispalay_grade').html('<span>Grade: &nbsp;'+response['grade']['grade_name']+'</span> ');
				}
				
			
				}	
    		});
		}

});
**/
</script>

<?php echo $last_footer; ?>
