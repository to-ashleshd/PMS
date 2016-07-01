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
        <h4>Employee Permission</h4>
      </div>
	
	
      <form action="<?php echo base_url('employeepermission/addemployeepermission'); ?>" method="post" name="add_employee" id="validate_field_types" >
	  <input type="hidden" name="h_pms_employee_id" id="h_pms_employee_id" value=""  />
<!--	  <form action="<?php //echo base_url('employeepermission/addemployeepermission'); ?>" method="post" name="add_employee" id="validate_field_types" >-->
        <div class="w-box-content cnt_b" > 
          <div class="row-fluid">
            <div class="span12">
              <div class="tabbable tabbable-bordered">
                <ul class="nav nav-tabs">
                 <!-- <li class="active"><a data-toggle="tab" href="#tb1_a">General</a></li>-->
				 
                </ul>
                <div class="tab-content">
				<div id="flashmessages" >
				<?php
				if(isset($success))
				{
					?>
					<div class="alert alert-success">
                    <a class="close" data-dismiss="alert">&times;</a>
                    <strong>Success!</strong><?=$success?>
                    </div>
					<?php
				}
				elseif(isset($error))
				{
					?>
					<div class="alert alert-error">
					<a class="close" data-dismiss="alert">&times;</a>
					<strong>Error!&nbsp;</strong><?=$error?>
					</div>
					<?php
				}
				?>
				</div>
				
                  <div id="tb1_a" class="tab-pane active">
                    <div class="span12">
						
						
						<div class="w-box-content">
							<div class="w-box w-box-green">
							  <div class="w-box-header">
								<h4>Employee ACL Permission <input type="button" value="New ACL PERMISSION" style="height:22px;" class="btn btn-mini btn-inverse" name="show_new_competencies" id="show_new_competencies" onclick="new_employee_permission()"></h4>
							  </div>
                          <div class="w-box-content">
						  <?php
						 /* echo "<pre>";
						  print_r($emp_per_list);
						  
						  echo "<pre>";die();*/
						  ?>
                            <table id="dt_colVis_Reorder_client_country" class="table table-striped table-condensed">
                              <thead>
                                <tr>
                                  <th style="width:5%;">id</th>
                                  <th style="width:20%;">Employee Name</th>
								  <th style="width:10%;">Access By</th>
								  <th style="width:10%;">Access Level</th>
								  <th style="width:15%;">Details</th>
                                  <th style="width:20%;">Action</th>
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  
							  if(isset($emp_per_list))
							  {
							  	if(!empty($emp_per_list))
								{
									$i=0;
									foreach($emp_per_list as $key=>$val)
									{
									$i++;
									?>
									 <tr id="tr_<?=$val['employee_id']?>">
									  <td><?=$i?></td>
									  <td><?=$val['employee_name']?></td>
									  <td><?=$val['function_type']?></td>
									  <td><?=$val['access_level_name']?></td>
									  <td>
									  	<?php
											if(!empty($val['details']))
											{
												foreach($val['details'] as $key1=>$val1)
												{
													echo $val1; echo "<br>";
												}
											}
										?>
									  </td>
									  <td>
									    <a href="javascript:void(0)" class="btn btn-mini" title="EDIT" onclick="call_edit_single_permission('<?=$val['employee_id']?>')" ><i class="icon-pencil"></i></a>&nbsp;
									  <a href="javascript:void(0)" class="btn btn-mini" title="DELETE" onclick="call_delete_single_permission('<?=$val['employee_id']?>')" ><i class="icsw16-acces-denied-sign"></i></a>
									  </td>
									</tr>
									<?php
									}
								}
							  }
							  ?>
							  
							  
							  </tbody>
							  </table>
							  </div>
							  </div>
							</div>
					
					    
						
<!-----------------------------------------------------------Form start here------------------------------------------------------------------------------->
					<div id="div_emp_acl_permission" >
						 <div class="formSep">
									  <span class="span4 req">Select Role</span>
									  <select name="role_id" id="role_id" onchange="call_employee_list()"  >
										<option value="">---Please Select---</option>
										<?php 
												if(isset($admin_roles))
												{
													if(!empty($admin_roles))
													{
														
														foreach($admin_roles as $key=>$val)
														{
											?>
											<option value="<?php echo $val->client_user_role_id; ?>" ><?php echo $val->rolename; ?></option>
											<?php
														}
													}
												}
											?>
									  </select>
								 </div>
									 <div class="formSep">
									  <span class="span4 req">Select Employee</span>
									  <select name="employee_id" id="employee_id"  >
										<option value="">---Please Select---</option>
											
										</select>
									</div>
									
									<div class="formSep">
									  <label><input type="checkbox" name="is_upper_office" id="is_upper_office" onclick="call_access_level()"  />&nbsp;Would You like to give access of upper Office Type(s)</label>
									</div>
									
									  
									<div class="formSep">
									  <label class="span3"><input type="radio" name="allow_office" id="local_office" value="L" onclick="getdetail()"   />&nbsp;Local</label>
									  <label class="span3"><input type="radio" name="allow_office" id="global_office" value="G" onclick="getdetail()"  />&nbsp;Global</label>
									</div>
									
									<div class="" id="content_office_type">
									
									  </div>
									  <div class="" id="content_access_level">
									
									  </div>
									  <div class="" id="content_access_level_function">
									
									  </div>
									   <div class="" id="content_function_list">
									
									  </div>
									
									<div class="formSep" id="office_address_list">
									
									 
									</div>
									
									
			
									
								  
							  
					
								<div class="formSep">
								<div align="center">
									<input type="submit" name="submit" value="Save" id="submit" class="btn btn-beoro-3" >
									<input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
								</div>
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

<?php echo $middle_footer; ?>
<?php echo $common_js; ?>
<script type="text/javascript" >
hide_message('flashmessages');
</script>
<script type="text/javascript" >



function getdetail()
{
	
	if($('#local_office').attr('checked'))
	{
		//get self Office address employee access
		 //save data
		 	var url = '<?php echo site_url("employeepermission/getselfofficedetails"); ?>';
    		var employee_id = $('#employee_id').val();
			if(employee_id=='')
			{
				alert('Please Select Employee');
				return false;
			}
			else
			{
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						employee_id : employee_id,
    		          },
				success: function(response) {
							//alert(response.length);
							    $('#content_access_level').html('');
								$('#content_access_level_function').html('');
							    $('#content_function_list').html('');
								$("#office_address_list").html('');
								
									var html = '';
									html += '<label><b>'+response.office_type+'</b>: &nbsp;'+response.office_name+'</label>';
                          			
									$("#office_address_list").html(html);
									
								}	
    		});
		}
	}
	else if($('#global_office').attr('checked'))
	{
		var url 			= '<?php echo site_url("employeepermission/getdownlineofficedetails"); ?>';
		var office_type_id	= '';
		var employee_id     = '';
		var html 			= '';
		
		employee_id     = $('#employee_id').val();
		if(employee_id=='')
		{
			alert('Please Select Employee');
			return false;
		}
		else
		{
			if($('#is_upper_office').attr('checked'))
			{
				office_type_id	= $('#all_office_type').val();
				if(office_type_id=='')
				{
					alert('Please Select Office Type');
					return false;
				}
			}
			
			 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						employee_id    : employee_id,
						office_type_id : office_type_id
    		          },
				success: function(response) {

								$("#office_address_list").html('');
								
									for(var i=0; i<response.length; i++)
									{
										html += '<div id="all_office_type_'+i+'">';
										html += '<label><b>'+response[i]['office_type_name']+'</b></label>';
										if(response[i]['offices_list'].length > 0 )
										{
											if(response[i]['offices_list'].length > 1 )
											{
												html += '<label class="checkbox inline">';
												html += '<input type="checkbox" onclick="call_to_chk_all_qstype(this.id)" id="all_'+i+'" name="main_office_type" value="'+response[i]['office_type_id']+'" value="" >';
												html += 'All';
												html += '</label>';
											}
											for(var j=0; j<response[i]['offices_list'].length; j++)
											{
												html += '<label class="checkbox inline">';
												html += '<input type="checkbox"  id="'+response[i]['offices_list'][j]['office_addresses_id']+'" value="'+response[i]['offices_list'][j]['office_addresses_id']+'" name="alloffadd[]">';
												html += response[i]['offices_list'][j]['office_name'];
												html += '</label>';
											}
											html += '<label>&nbsp;</label>';
										}
										else
										{
											html += '<label class="checkbox inline">';
											html += 'NO Offices In This Office Type.';
											html += '</label>';
											html += '<label>&nbsp;</label>';
										}
										html += '</div>';
										
									}
									$("#office_address_list").html(html);
									
								}	
    		});
			
			
			
		}
		
		return false;
	}
}
</script>
<script type="text/javascript">
function call_to_chk_all_qstype(id)
{
	var elem = id.split('_');
	var div_id = "all_office_type_"+elem[1];
	if ($('#'+id).is(":checked"))
	{
		
		$("#"+div_id+" input:checkbox").attr("checked" ,true);
		
	}
	else
	{
		$("#"+div_id+" input:checkbox").attr("checked" ,false);
	}
}
function call_to_chk_all_business(id)
{
	var div_id = "all_business";
	if ($('#'+id).is(":checked"))
	{
		
		$("#"+div_id+" input:checkbox").attr("checked" ,true);
		
	}
	else
	{
		$("#"+div_id+" input:checkbox").attr("checked" ,false);
	}
}
function call_to_chk_all_company(id)
{
	var div_id = "all_company";
	if ($('#'+id).is(":checked"))
	{
		
		$("#"+div_id+" input:checkbox").attr("checked" ,true);
		
	}
	else
	{
		$("#"+div_id+" input:checkbox").attr("checked" ,false);
	}
}
function call_to_chk_all_offices(id)
{
	var elem = id.split('all_offices_chk_');
	var div_id = "all_offices_"+elem[1];
	if ($('#'+id).is(":checked"))
	{
		
		$("#"+div_id+" input:checkbox").attr("checked" ,true);
		
	}
	else
	{
		$("#"+div_id+"  input:checkbox").attr("checked" ,false);
	}
}
</script>
<script type="text/javascript" >
/*$(document).ready(function() {


     $("#validate_field_types").submit(function() {
     var frm = $('#validate_field_types');
	
        $.ajax({
            type: frm.attr('method'),
            url: '<?php //echo base_url('employeepermission/addemployeepermission'); ?>',
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
				$('#flashmessages').html(html);
				$("html, body").animate({ scrollTop: 0 }, "slow");
				hide_message('flashmessages');
				
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
*/
</script>
<script type="text/javascript" >
function call_employee_list()
{
	var role_id = $('#role_id').val();
	var url = '<?php echo site_url("employeepermission/ajax_getuser_byrole"); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						role_id    : role_id,
    		          },
				success: function(response) {
				  $('#employee_id').html('');
				  $('#employee_id').html(response.html);
				}
		});
	
}
</script>
<script type="text/javascript" >
function hide_message(id)
	{
		setTimeout(function(){ $("#"+id).html(''); }, 3000);
	}

</script>
<script type="text/javascript" >
function call_access_level()
{
	
	var html = '';
	if($('#is_upper_office').attr('checked'))
	{
		var employee_id = $('#employee_id').val();
		var role_id = $('#role_id').val();
		if((employee_id==null || employee_id=='') && (role_id=='' || role_id==null))
		{
			$('#is_upper_office').removeAttr('checked','checked');
			alert("Please select Employee and Role");
			return false;
		}
		else if((employee_id==null || employee_id==''))
		{
			$('#is_upper_office').removeAttr('checked','checked');
			alert("Please Select Employee.");
			return false;
		}
		else if((employee_id==null || employee_id==''))
		{
			$('#is_upper_office').removeAttr('checked','checked');
			alert("Please Select Role.");
			return false;
		}
		else
		{
			$("#content_access_level").attr('class','formSep')
			html += '<span class="span4">Select Access Level</span>';
			html += '<select name="access_level" id="access_level"   onchange="call_acces_level_list()">';
			html += '<option value="">--Please Select---</option>';
			html += '<option value="1">Function</option>';
			html += '<option value="2">Company</option>';
			html += '<option value="3">Office Name</option>';
			html += '<option value="4">Entire Group</option>';
			html += '</select>';
			$("#office_address_list").html('');
		    $('#content_access_level_function').html('');
			$('#content_function_list').html('');
			$('#local_office').removeAttr('checked','checked');
			$('#local_office').attr('disabled','disabled');
			$('#global_office').removeAttr('disabled','disabled');
			$('#global_office').attr('checked','checked');
			$('#content_access_level').html(html);
			
		}
	}
	else
	{
		$("#office_address_list").html('');
		$("#content_access_level").html('');
		$("#content_access_level_function").html('');
		$("#content_function_list").html('');
		$('#local_office').removeAttr('disabled','disabled');
		$('#global_office').removeAttr('checked','checked');
		$('#global_office').attr('disabled','disabled');
	    
	}
	
}

function call_acces_level_list()
{
	var access_level = $('#access_level').val();
	
	if(access_level==1)
	{
		call_business_list();
	}
	else if(access_level==2)
	{
		call_company_list();
	}
	else if(access_level==3)
	{
		call_offices_name_list();
	}
	else if(access_level==4)
	{
		$('#content_function_list').html('');
		$("#office_address_list").html('');
		$('#content_access_level_function').html('');
	  return true;
	}
	else
	{
		alert("Please select acess level");
		 return false;
	}
	
	
	
}
function call_business_list()
{
	var html = ''
	$("#content_access_level_function").attr('class','formSep');
	html += '<?php echo $business_html; ?>';
	$('#content_function_list').html('');
	$('#content_access_level_function').html(html);
}


function call_company_list()
{
	var html = ''
	$("#content_access_level_function").attr('class','formSep');
	html += '<?php echo $company_html; ?>';
	$('#content_access_level_function').html(html);
	$('#content_function_list').html('');
}

function call_offices_name_list()
{
	var html = ''
	$("#content_access_level_function").attr('class','formSep');
	html += '<?php echo $offices_html; ?>';
	
	$('#content_function_list').html('');
	$('#content_access_level_function').html(html);
}

$('#reset').click(function(){ $('#content_access_level_function').html('');});
</script>
<script type="text/javascript" >
function call_edit_single_permission(employee_id)
{
	var pms_employee_id = employee_id;
	if(pms_employee_id!='' || pms_employee_id!='')
	{
		var url = '<?php echo site_url("employeepermission/ajax_get_permission_detail_for_edit"); ?>';
		 $.ajax({
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							pms_employee_id    : pms_employee_id,
						  },
					success: function(response) {
					  $('#submit').val('Update');
					  $('#reset').remove();
					  $('#cancel').remove();
					  $('#submit').after('&nbsp;<input type="button" name="cancel" value="Cancel" id="cancel" class="btn btn-beoro-3" onclick="new_employee_permission()">');
					  $('#h_pms_employee_id').val(response.pms_employee_id);
					  $('#role_id').html(response.role_html);
					  $("#role_id").attr('readonly','readonly');
					  $("#employee_id").html(response.employee_html);
					  $("#employee_id").attr('readonly','readonly');
					  if(response.is_upper_office=='Y')
					  {
					  	$('#is_upper_office').attr('checked','checked');
						if(response.is_local_or_global=='G')
						{
							$("#global_office").removeAttr('disabled','disabled');
					 		$("#global_office").attr('checked','checked');
							$("#local_office").removeAttr('checked','checked');
							$("#local_office").attr('disabled','disabled');
							$('#content_access_level').attr('class','formSep');
							$('#content_access_level').html(response.access_level_html);
							$('#content_access_level_function').attr('class','formSep');
							$('#content_access_level_function').html(response.access_level_function_html);
							
							if(response.access_level_id==3)
							{
								$('#office_address_list').attr('class','formSep');
							    $('#office_address_list').html(response.content_function_list_html);
								$('#content_function_list').html('');
							}
							else
							{
								$('#content_function_list').attr('class','formSep');
								$('#office_address_list').html('');;
								$('#content_function_list').html(response.content_function_list_html);
						    }
							
					    }
					  }
					  else if(response.is_upper_office=='N')
					  {
					  	$('#is_upper_office').removeAttr('checked','checked');
						if(response.is_local_or_global=='L')
						{
							$("#local_office").removeAttr('disabled','disabled');
					 		$("#local_office").attr('checked','checked');
							$("#global_office").attr('disabled','disabled');
					 		$("#global_office").removeAttr('checked','checked');
							$('#content_access_level').html('');
							$('#content_access_level_function').html('');
							$('#content_function_list').html('');
							$('#office_address_list').html(response.office_address_list_html);
					    }
						
					  }
					 
					}
			});
	}
	else
	{
		alert("Please Try again");
		return false;
	}
	
	
	
	
	
	
}
</script>
<script type="text/javascript" >
function new_employee_permission()
{
	$('#h_pms_employee_id').val('');
	var url = '<?php echo site_url("employeepermission/get_basic_emp_per_template"); ?>';
		 $.ajax({
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
						  },
					success: function(response) {
					$('#div_emp_acl_permission').html('');
						$('#div_emp_acl_permission').html(response.html);
					}
			});
	return true;
}
function call_delete_single_permission(employee_id)
{
	var t= confirm("Are you sure.\nYou want to delete this permission.");
	if(t==true)
	{
	var pms_employee_id = employee_id;
	if(pms_employee_id!='' || pms_employee_id!='')
	{
		new_employee_permission();
		var html ='';
		var url = '<?php echo site_url("employeepermission/ajax_delete_permission"); ?>';
		 $.ajax({
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							pms_employee_id    : pms_employee_id,
						  },
					success: function(response) {
						if(response.status=='1')
						{
					
							html += '<div class="alert alert-error">';
							html += '<a class="close" data-dismiss="alert">&times;</a>';
							html += '<strong>Error!&nbsp;</strong> Please try again.';
							html += '</div>';
						 }
					
						if(response.status=='0')
						{
					
							html += '<div class="alert alert-success">';
							html += '<a class="close" data-dismiss="alert">&times;</a>';
							html += '<strong>Success!</strong> Employee permission detail deleted successfully.';
							html += '</div>';
							$('#tr_'+pms_employee_id).remove();
							
						}
						
						$('#flashmessages').html('');
						$('#flashmessages').html(html);
						$("html, body").animate({ scrollTop: 0 }, "slow");
						hide_message('flashmessages');
					}
			});
	}
	}
	//return false;
	}
</script>
<?php echo $last_footer; ?>
