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
          <h4>Change Password</h4>
        </div>
        <form action="" method="post" name="add_employee" id="validate_field_types" >
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
                      
                      <div class="formSep"> <span class="span4">Current Password</span>
                        <input name="current_password"  type="text" id="current_password" value="" maxlength="30">
                      </div>
                      <div class="formSep">
                        <label class="span4 req">Password:</label>
                        <input style="float:left;"  name="password2" type="password" class="validate[required]" id="password2" onblur="checkpasswordstrength('result', 'lbl_password');" maxlength="30" placeholder="Password"  >
                        <div id="register" style="float:left; width:90px; height:25px; margin-left:5px;"><span id="result"></span></div>
						<div style="clear:both"></div>
						    </div>
                      <div class="formSep">
                        <label class="span4">Confirm Passoword</label>
                        <input name="confirmpassword" type="password"  class="validate[required,equals[password2]]" id="confirmpassword" maxlength="30" placeholder="Confirm Password"  >
                      </div>
					  
					  <div class="formSep">
					  <label class="span4">&nbsp;</label>
                        <input type="button" name="Button" value="Change Password" id="upd_passwd" class="btn btn-beoro-3">
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
hide_message('flashmessages');
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
		//document.getElementById(lbl_id).innerHTML = 'Please Choose Password strength at least "' + pwd_strength_names[req_pwd_strength-1] + '" ' ;		
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
			

	//Check for submit
	$("#upd_passwd").click( function() {
		
		var password = $("#password2").val();
		var confirmpassword = $("#confirmpassword").val();
		var current_password = $("#current_password").val();
		var pass_strength = checkpasswordstrength('result', 'lbl_password');
		var msg = '';
		
		if( current_password.length <= 0 ) {
			msg += "Please Enter current password.\n" ;
		}
		
		if( password.length <= 4 ) {
			msg += "Please Enter new password with atleast 5 characters.\n" ;
		}	
		
		if( password != confirmpassword ) {
			msg += "New password and confirm password did not matched.\n";
		}
		
		
		if( pass_strength == false ) {
			msg += "Please enter valid strength password.\n";
		}
		
		
		if( msg != '' ) {
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
			data: {password:password, current_password:current_password},
			success: function(response) {
				var msg = '<div class="alert alert-error">';
                msg += '<a class="close" data-dismiss="alert">&times;</a>';
                msg += '<strong>!&nbsp;</strong>'+response.message;
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
<?php echo $last_footer; ?> 