// JavaScript Document

function call_state()
{
	
	var url = '<?php echo site_url("ajax/getstate"); ?>';
    var country = $('#country').val();
	alert(country);
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						country: country
    		          },
				success: function(response) {
								$("#state").html(response['state']);
								}	
    		});
}//function close

function call_stateforcity()
{
	
	var url = '<?php echo site_url("ajax/getstate"); ?>';
    var country = $('#country_city').val();
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						country: country
    		          },
				success: function(response) {
								$("#state_city").html(response['state']);
								}	
    		});
}//function close

function call_cityforcity()
{
	
	var url = '<?php echo site_url("ajax/getcity"); ?>';
	var country = $('#country_city').val();
    var state = $('#state_city').val();
	
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						country : country,
						state: state
    		          },
				success: function(response) {
								$("#city_city").html(response['city']);
								}	
    		});
}//function close




function call_generalstate(country_id,state_id)
{
	
	var url = '<?php echo site_url("ajax/getstate"); ?>';
    var country = $('#'+country_id).val();
	
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						country: country
    		          },
				success: function(response) {
								$("#"+state_id).html(response['state']);
								}	
    		});
}//function general state close

function call_generalcity(country_id,state_id,city_id)
{
	
	var url = '<?php echo site_url("ajax/getcity"); ?>';
	var country = $('#'+country_id).val();
    var state = $('#'+state_id).val();
	
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						country : country,
						state: state
    		          },
				success: function(response) {
								$("#"+city_id).html(response['city']);
								}	
    		});
}//function close

//start function disabled other state
function calldisabled(state)
{

	if(state=='' || state<=0)
	{
		$("#otherstate").removeAttr('disabled','disabled');
	}
	else
	{
		$("#otherstate").val('');
		$("#otherstate").attr('disabled','disabled');
	}

}
//close disabled function state

<!-- start function disabled -->
function calldisabledothercity(city)
{

	if(city=='' || city<=0)
	{
		$("#othercity").removeAttr('disabled','disabled');
	}
	else
	{
		$("#othercity").val('');
		$("#othercity").attr('disabled','disabled');
	}

}

<!--- end desabled function -->


<!-- Start edit country --->
function call_country()
{

	var country_id = $("#countrymaster_country").val();
	var url = '<?php echo site_url("ajax/getCountryInfo"); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						country : country_id,
    		          },
				success: function(response) {
								$('input[id=\'hcountry_id_country\']').attr('value', response['country_id']);
								$('input[id=\'country\']').attr('value', response['country_name']);
								$('input[id=\'countrycode1\']').attr('value', response['country_isocode1']);
								$('input[id=\'countrycode2\']').attr('value', response['country_isocode2']);
								}	
    		});
}
<!-- End edit country-->

<!-- Start edit state --->
function call_edit_state()
{

	var country_id = $("#country_state").val();
	var state_id   = $("#state_state").val();
	var url = '<?php echo site_url("ajax/getStateInfo"); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						country : country_id,
						state   : state_id
    		          },
				success: function(response) {
							
								$('select[id=\'country_new_state\']').attr('value', response['country_id']);
								$('input[id=\'state_new_state\']').attr('value', response['state_name']);
								$('input[id=\'hcountry_new_state\']').attr('value', response['state_id']);
								}	
    		});
}
<!-- End edit state-->


<!-- Start edit city --->
function call_edit_city()
{

	var country_id = $("#country_city").val();
	var state_id   = $("#state_city").val();
	var city_id    = $("#city_city").val();
	var url = '<?php echo site_url("ajax/getCityInfo"); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						country : country_id,
						state   : state_id,
						city    : city_id
    		          },
				success: function(response) {
								
								$('select[id=\'country_new_city\']').html(response['country']);
								$('select[id=\'state_new_city\']').html(response['state']);
								$('input[id=\'hcity_new_city\']').attr('value', response['city_id']);
								$('input[id=\'city_new_city\']').attr('value', response['city_name']);
								
								}	
    		});
}
<!-- End edit city-->

<!-- start update country status -->
function call_updatecountry_status()
{
	var country_id = $("#countrymaster_country").val();
	
	var url = '<?php echo site_url("ajax/updatecountry"); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						country : country_id,
    		          },
				success: function(response) {
									
									if(response['status']==1)
									{
										//alert(response['message']);
									}
									window.location = '<?php echo site_url("localisation") ?>';
								}	
    		});


}<!-- end country country status --->


<!-- start update country status -->
function call_updatestate_status()
{
	var state_id = $("#state_state").val();
	
	var url = '<?php echo site_url("ajax/updatestate"); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						state : state_id,
    		          },
				success: function(response) {
									
									if(response['status']==1)
									{
										//alert(response['message']);
										
									}
									
									window.location = '<?php echo site_url('localisation/localisation/tb1_c');?>';
								}	
    		});


}<!-- end country country status --->

<!-- start update city status -->
function call_updatecity_status()
{
	var city_id = $("#city_city").val();
	
	var url = '<?php echo site_url("ajax/updatecity"); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						city : city_id,
    		          },
				success: function(response) {
									
									if(response['status']==1)
									{
										//alert(response['message']);
										
									}
									
									window.location = '<?php echo site_url('localisation/localisation/tb1_d');?>';
								}	
    		});


}<!-- end country country status --->






<!-- Start get all companies of selected parent office -->
function call_office_company()
{
	var op_id = $("#office_parent_ot").val();
	
	//alert(op_id);
	var url = '<?php echo site_url("ajax/getcompanyofoffice"); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						office_p_type_id : op_id,
    		          },
				success: function(response) {
								$('select[id=\'office_type_company\']').html(response['office_p_type_cmp']);
								}	
    		});
	

}

<!-- end of call_office_comany -->

<!-- Start get all parent offices types of selected Company -->
function call_parent_company_offices()
{
	var company_id = $("#office_type_company").val();
	
	
	var url = '<?php echo site_url("ajax/getofficeofcomany"); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						company_id : company_id,
    		          },
				success: function(response) {
				//alert(response['cmp']);
								$('select[id=\'office_parent_ot\']').html(response['company_parent_offices']);
								}	
    		});
	

}

<!-- end of call_office_comany -->



<!--- start office adress get parent offices --->
 function call_office_for_address()
{
	var otp_id = $("#office_type_oadd").val();
	
	//alert(op_id);
	var url = '<?php echo site_url("ajax/getcompanyofoffice"); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						office_type_id : otp_id,
    		          },
				success: function(response) {
								$('select[id=\'reported_to_oadd\']').html(response['office_p_type_cmp']);
								}	
    		});
	

}
<!---- end of call_office_for_address -->

function call_country_validation()
{
	var flag=0;
	
	if(!is_char('country','lbl_country_name','YES','Country Name'))
	{
		flag=1;
	}
	if(!is_char('countrycode1','lbl_iso_code1','YES','Country Code'))
	{
		flag=1;
	}
	
	checkcountryexist('country','lbl_country_name');
	var status_cnt = document.getElementById('cntry_status').value;
	checkcountryISOCodeOne('countrycode1','lbl_iso_code1')
	var status_code = document.getElementById('code_status').value;
	if(status_cnt==1)
	{
		flag=1;
	}
	if(status_code==1)
	{
		flag=1;
	}
	
	if(flag==1)
	{
		alert("Please check form carefully for errors");
		return false;
	}
	else
	{
		return true;
	}
	
	
	
}

function check_state_validation()
{
	var flag=0;
	
	if(!is_char('state_new_state','lbl_state_name','YES','State Name'))
	{
		flag=1;
	}
	checkstateexist('state_new_state','lbl_state_name','country_new_state','lbl_state_country');
	var status_code = document.getElementById('hstate_status').value;
	
	if(status_code==1)
	{
		flag=1;
	}
	
	
	if(flag==1)
	{
		alert("Please check form carefully for errors");
		return false;
	}
	else
	{
		return true;
	}

}

function call_city_validation()
{
	var flag=0;
	if(!is_char('city_new_city','lbl_city_new_city','YES','City Name'))
	{
		flag = 1;
	}
	
	checkcityexist('city_new_city','lbl_city_new_city','country_new_city','lbl_country_new_city','state_new_city','lbl_state_new_city')
	var city_status = document.getElementById('hcity_status').value;
	
	if(city_status==1)
	{
		flag=1;
	}
	if(flag==1)
	{
		alert("Please check form carefully for errors");
		return false;
	}
	else
	{
		return true;
	}

}

function checkcountryexist(id,lbl_id)
{
	var hc_id = document.getElementById('hcountry_id_country').value;
	var country_name = document.getElementById(id).value;
	var url = '<?php echo site_url("ajax/checkcountry"); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						country_name : country_name,
						country_id :hc_id
    		          },
				success: function(response) {
								if(response['status']==1)
								{
									document.getElementById(lbl_id).innerHTML ='Country already Exist';
									document.getElementById('cntry_status').value =1;
								}
								else
								{
									document.getElementById('cntry_status').value =0;
								}
								
								}	
    		});
			
	
}

function checkcountryISOCodeOne(id,lbl_id)
{
	var hc_id = document.getElementById('hcountry_id_country').value;
	var country_code = document.getElementById(id).value;
	var url = '<?php echo site_url("ajax/checkcountryISOCodeOne"); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						country_code_one : country_code,
						country_id :hc_id
    		          },
				success: function(response) {
								if(response['status']==1)
								{
									
									document.getElementById(lbl_id).innerHTML ='Country ISo Code 1 already Exist';
									document.getElementById('code_status').value =1;
								}
								else
								{
									document.getElementById('code_status').value =0;
								}
								}	
    		});
			
	
}

<!-- state already exist ---->

function checkstateexist(id,lbl_id,country_id,lbl_country_id)
{
	var country_id = document.getElementById(country_id).value;
	if(country_id=='' || country_id==null)
	{
		document.getElementById(lbl_country_id).innerHTML = 'Please Select Country';
		return false;
	}
	else
	{
	document.getElementById(lbl_country_id).innerHTML = '';
	var hs_id = document.getElementById('hcountry_new_state').value;
	var state_name = document.getElementById(id).value;
	var url = '<?php echo site_url("ajax/checkstate"); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						state_name : state_name,
						country_id : country_id,
						state_id : hs_id
    		          },
				success: function(response) {
								if(response['status']==1)
								{
									document.getElementById(lbl_id).innerHTML ='State already Exist';
									document.getElementById('hstate_status').value =1;
								}
								else
								{
									document.getElementById('hstate_status').value =0;
								}
								
								}	
    		});
	}	
	
}


<!--end stae exist -->

<!-- city already exist ---->

function checkcityexist(id,lbl_id,country_id,lbl_country_id,state_id,lbl_state_id)
{
	var country_id = document.getElementById(country_id).value;
	var state_id  =  document.getElementById(state_id).value;
	if(country_id=='' || country_id==null || state_id=='' || state_id==null)
	{
		if(country_id=='' || country_id==null)
		{
			document.getElementById(lbl_country_id).innerHTML = 'Please Select Country';
		}
		if(state_id=='' || state_id==null)
		{
			document.getElementById(lbl_state_id).innerHTML = 'Please Select State';
		}
		return false;
	}
	else
	{
	document.getElementById(lbl_country_id).innerHTML = '';
	document.getElementById(lbl_state_id).innerHTML = '';
	var hcity_id = document.getElementById('hcity_new_city').value;
	var city_name = document.getElementById(id).value;
	var url = '<?php echo site_url("ajax/checkcity"); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						city_name : city_name,
						country_id : country_id,
						state_id : state_id,
						city_id :hcity_id
    		          },
				success: function(response) {
								if(response['status']==1)
								{
									document.getElementById(lbl_id).innerHTML ='city already Exist';
									document.getElementById('hcity_status').value =1;
								}
								else
								{
									document.getElementById('hcity_status').value =0;
								}
								
								}	
    		});
	}	
	
}
