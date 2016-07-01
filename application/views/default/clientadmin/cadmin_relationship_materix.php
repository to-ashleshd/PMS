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
	  
	  	<div class="w-box w-box-orange">
		<div id="flashmessage" style="background-color:#FFFFFF;" >
							 
							</div>
                            <div class="w-box-header">
                                <h4>Employee Relationship list</h4>
                            </div>
                            <div class="w-box-content">
							
                                <table id="dt_colVis_Reorder" class="table table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>Id</th>
										<th>Employee </th>
										<!--<th>Time Period Id</th>-->
                                        <th>Appraiser</th>
                                        <th>Reviewer</th>
                                        <th>Action</th>
                                    </tr>
									
									
                                </thead>
                                <tbody>
                                   
									<?php 
									if(isset($employee))
									{
										if(!empty($employee))
										{
											
											foreach($employee as $key=>$val)
											{
										
											?>
									 <tr id="relationship_tr_<?=$val['pms_employee_id']?>" >
									 		<td><?php echo $key+1; ?></td>
											<td><?php echo $val['employee_name'].', '.$val['designation_name']; ?></td>
											<td id="apraiser_td_<?=$val['pms_employee_id']?>">
											<?php 
											if(isset($val['relationship_name_detail']))
											{
												if(!empty($val['relationship_name_detail']))
												{
													echo $val['relationship_name_detail']['apraiser_name_designation'];
												}
											}
											else
											{
											?>
											
											<select name="apraiser_<?=$val['pms_employee_id']?>" id="apraiser_<?=$val['pms_employee_id']?>" onblur="call_reviewer_list('<?=$val['pms_employee_id']?>')" >
												<option value="">--Please Select--</option>
												<?php
												if(isset($val['apraiser_list']))
												{
													if(!empty($val['apraiser_list']))
													{
														foreach($val['apraiser_list'] as $keyal=>$valal)
														{
															?><option value="<?=$valal['appraiser_employee_id']; ?>"><?=$valal['appraiser_employee_name']; ?>,&nbsp;<?=$valal['designation_name']; ?></option><?php
														}
													}
												}
											   ?>
											</select>
											<?php } ?>
											
											</td>
                                          	<td id="reviewer_td_<?=$val['pms_employee_id']?>" >
											<?php if(isset($val['relationship_name_detail']))
											{
												if(!empty($val['relationship_name_detail']))
												{
													echo $val['relationship_name_detail']['reviewer_name_designation'];
												}
												else
												{
													echo "N.A.";
												}
											}
											else
											{
											
											?>
											<select name="reviewer_<?=$val['pms_employee_id']?>" id="reviewer_<?=$val['pms_employee_id']?>">
												<option value="">--Please Select--</option>
											</select>	
											<?php } ?>									
											</td>
											 <td>
                                                <div class="btn-group" id="btn_group_<?=$val['pms_employee_id']?>">
													<?php if(isset($val['relationship_name_detail']))
													{
															if(!empty($val['relationship_name_detail']))
														{?>
														<a title="Edit" class="btn btn-mini" onclick="call_editable_row('<?=$val['pms_employee_id']?>')"><i class="icon-pencil"></i></a>
														<?php
														}
													}else
													{
												?>
													<input type="button" name="save" value="Save" class="btn  btn-beoro-3" onclick="add_emp_relationship('<?=$val['pms_employee_id']?>')"  />
													<?php } ?>
                                                </div>
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






<script type="text/javascript" >
hide_message('flashmessage');
$(document).ready(function() {

	
			

});
</script>

<script type="text/javascript" >
function call_reviewer_list(employee_id)
{

	var apraiser_employee_id = $('#apraiser_'+employee_id).val();
	
	if(apraiser_employee_id==''){
		alert("please select appraiser");
		return false;
	}
	else if(apraiser_employee_id!=''){
	var url = '<?php echo site_url("employee/getreviewerlist"); ?>';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						apraiser_employee_id : apraiser_employee_id
    		          },
				success: function(response) {
				var i= 0;
				var html ='';
				$('#reviewer_'+employee_id).html('');
				
				if(response!=null)
				{
					if(apraiser_employee_id=='1')
					{
						$('#reviewer_'+employee_id).attr('readonly','readonly');
					}
					else
					{
						html += '<option value="">--Please Select---</option>';
						for(i=0; i<response.length; i++ )
						{
							
							html += '<option value="'+response[i]['reviewer_employee_id']+'">'+response[i]['reviewer_employee_name']+', '+response[i]['designation_name']+'</option>';
							
							
						}
						$('#reviewer_'+employee_id).html(html);
						if($('#reviewer_'+employee_id).attr('readonly'))
						{
							$('#reviewer_'+employee_id).removeAttr('readonly','readonly');
						}
					}
				}
				}
					
				
    		});
		}





}
</script>
<script type="text/javascript" >
function add_emp_relationship(employee_id)
{
	
	var apraiser_employee_id = $('#apraiser_'+employee_id).val();
	var reviewer_employee_id = $('#reviewer_'+employee_id).val();
	
	if(apraiser_employee_id=='' || reviewer_employee_id=='')
	{
		if(apraiser_employee_id=='')
		{
			alert("Please Select Appraiser");
			return false;
		}
		else if(reviewer_employee_id=='')
		{
			alert("Please Select Reviewer");
			return false;
		}
		else if(apraiser_employee_id=='' && reviewer_employee_id=='')
		{
			alert("Please Select Appraiser and Reviewer");
			return false;
		}
	}else
		{
		
			var url = '<?php echo site_url("employee/addemployeerelationshipdata"); ?>';
			 $.ajax({
						url: url,
						dataType: 'json',
						type: 'POST',
						data: {
								pms_employee_id		 : employee_id,
								apraiser_employee_id : apraiser_employee_id,
								reviewer_employee_id : reviewer_employee_id
							  },
						success: function(response) {
						var i= 0;
						var html ='';
						
							$('#flashmessage').html('');

						if(response.msg)
						{
							$('#flashmessage').html('<div class="alert alert-success"><a class="close" data-dismiss="alert">&times;</a><strong>Success!</strong>&nbsp;'+response.msg+'</div>');
						}
						else if(response.error_msg)
						{
							$('#flashmessage').html('<div class="alert alert-error"><a class="close" data-dismiss="alert">&times;</a><strong>Alert!</strong>&nbsp;'+response.error_msg+'</div>');
						}
						hide_message('flashmessage');
						if(response.detail)
						{
							/*$('#apraiser_td_'+employee_id).html('');
							$('#apraiser_td_'+employee_id).html(response.detail['appraiser_name_designation']);
							$('#reviewer_td_'+employee_id).html('');
							$('#reviewer_td_'+employee_id).html(response.detail['reviewer_name_designation']);
							$('#btn_group_'+employee_id).html('');
							$('#btn_group_'+employee_id).html('<a title="Edit" class="btn btn-mini" onclick="call_editable_row('+employee_id+')" ><i class="icon-pencil"></i></a>');
						*/	
							$('#relationship_tr_'+employee_id).remove();
					
						}
					
						}	
					});

		//}
	}
	
	
}
</script>
<script type="text/javascript" >
function call_editable_row(employee_id)
{

var url = '<?php echo site_url("employee/call_employee_edit_row"); ?>';
			 $.ajax({
						url: url,
						dataType: 'json',
						type: 'POST',
						data: {
								pms_employee_id		 : employee_id,
							  },
						success: function(response) {
						var html  = '';
						var html1 ='';
						html += '<input type="hidden" name="employee_relationship_id_'+employee_id+'" id="employee_relationship_id_'+employee_id+'" value="'+response.employee_realtionship_id+'"  />';
						if(response.apraiser_list.length > 0 )
						{
							html += '<select name="apraiser_'+employee_id+'" id="apraiser_'+employee_id+'" onblur="call_reviewer_list('+employee_id+')" >';
							html += '<option value="">--Please Select---</option>';
							for(var i=0; i<response.apraiser_list.length; i++ )
							{
								if(response.apraiser_id!=response.apraiser_list[i]['appraiser_employee_id'])
								{
									html += '<option value="'+response.apraiser_list[i]['appraiser_employee_id']+'">'+response.apraiser_list[i]['appraiser_employee_name']+',&nbsp;'+response.apraiser_list[i]['appraiser_designation_name']+'</option>';
								}
								else
								{
									html += '<option value="'+response.apraiser_list[i]['appraiser_employee_id']+'" selected="selected" >'+response.apraiser_list[i]['appraiser_employee_name']+',&nbsp;'+response.apraiser_list[i]['appraiser_designation_name']+'</option>';
								}
							}
							html += '</select>';
						}
						
						if(response.reviewer_list.length > 0 )
						{
							html1 += '<select name="reviewer_'+employee_id+'" id="reviewer_'+employee_id+'"  >';
							html1 += '<option value="">--Please Select---</option>';
							for(var i=0; i<response.reviewer_list.length; i++ )
							{
								if(response.reviewer_id!=response.reviewer_list[i]['reviewer_employee_id'])
								{
									html1 += '<option value="'+response.reviewer_list[i]['reviewer_employee_id']+'">'+response.reviewer_list[i]['reviewer_employee_name']+',&nbsp;'+response.apraiser_list[i]['reviewer_designation_name']+'</option>';
								}
								else
								{
									html1 += '<option value="'+response.reviewer_list[i]['reviewer_employee_id']+'" selected="selected" >'+response.reviewer_list[i]['reviewer_employee_name']+',&nbsp;'+response.apraiser_list[i]['reviewer_designation_name']+'</option>';
								}
							}
							html1 += '</select>';
						}
						else
						{
							html1 += '<select name="reviewer_'+employee_id+'" id="reviewer_'+employee_id+'" readonly="readonly"  >';
							html1 += '<option value="">--Please Select---</option>';
							html1 += '</select>';
						}
						
							$('#apraiser_td_'+employee_id).html('');
							$('#apraiser_td_'+employee_id).html(html);
							$('#reviewer_td_'+employee_id).html('');
							$('#reviewer_td_'+employee_id).html(html1);
							
							$('#btn_group_'+employee_id).html('');
							$('#btn_group_'+employee_id).html('<input type="button" name="upadte" value="update" class="btn  btn-beoro-3" onclick="update_relationship_data('+employee_id+')"  >');
						}
						
				});




}

</script>
<script type="text/javascript" >
function update_relationship_data(employee_id)
{
	var emp_relationship_id	= $('#employee_relationship_id_'+employee_id).val();
	var apraiser_employee_id = $('#apraiser_'+employee_id).val();
	var reviewer_employee_id = $('#reviewer_'+employee_id).val();
	var url = '<?php echo site_url("employee/update_relationship_data"); ?>';
			 $.ajax({
						url: url,
						dataType: 'json',
						type: 'POST',
						data: {
								pms_employee_id		 : employee_id,
								employee_relationship_materix_id : emp_relationship_id,
								apraiser_employee_id : apraiser_employee_id,
								reviewer_employee_id : reviewer_employee_id
								
							  },
						success: function(response) {
							$('#flashmessage').html('');

						if(response.msg)
						{
							$('#flashmessage').html('<div class="alert alert-success"><a class="close" data-dismiss="alert">&times;</a><strong>Success!</strong>&nbsp;'+response.msg+'</div>');
						}
						else if(response.error_msg)
						{
							$('#flashmessage').html('<div class="alert alert-error"><a class="close" data-dismiss="alert">&times;</a><strong>Alert!</strong>&nbsp;'+response.error_msg+'</div>');
						}
						if(response.detail)
						{
							$('#apraiser_td_'+employee_id).html('');
							$('#apraiser_td_'+employee_id).html(response.detail['appraiser_name_designation']);
							$('#reviewer_td_'+employee_id).html('');
							$('#reviewer_td_'+employee_id).html(response.detail['reviewer_name_designation']);
							$('#btn_group_'+employee_id).html('');
							$('#btn_group_'+employee_id).html('<a title="Edit" class="btn btn-mini" onclick="call_editable_row('+employee_id+')"><i class="icon-pencil"></i></a>');
						}
						}
					});
	
	
}
</script>
<?php echo $last_footer; ?>
