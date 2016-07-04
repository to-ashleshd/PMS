<?php echo $header; ?>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
						
								<div class="w-box w-box-orange">
                            <div class="w-box-header">
                                <h4>Employee Relationship list</h4>
                            </div>
                            <div class="w-box-content">
							
                                <table id="dt_colVis_Reorder" class="table table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>Id</th>
										<th>Employee </th>
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
									 <tr id="relationship_tr_<?=$val['pms_employee_id']?>">
									 		<td ><?php echo $val['sr_no']?></td>
											<td ><?php if($val['employee_name']) {echo $val['employee_name'] .', '.$val['employee_designatoion']; } ?></td>
											<td >
											<?php
											if(!empty($val['apraiser_list']))
											{
												foreach($val['apraiser_list'] as $key1=>$val1)
												{
											?>
														<div id="apraiser_td_<?=$key1?>" >
														<?php echo $val1['apraiser_name'].', '.$val1['apraiser_disignation']; ?>
														</div><br />
											<?php
												}
											}
											?>
											</td>
                                          	<td >
											<?php
											if(!empty($val['reviewer_list']))
											{
												foreach($val['reviewer_list'] as $key2=>$val2)
												{
											?>
														<div class="cls_reviewer_<?=$val['pms_employee_id']?>" id="reviewer_td_<?=$key2?>" >
														<?php echo $val2['reviewer_name'].', '.$val2['reviewer_designatoion']; ?>
														</div><br />
											<?php
												}
											}
											?>
											</td>
											
											
											
											 <td>
											 <?php
											if(!empty($val['apraiser_list']))
											{
												foreach($val['apraiser_list'] as $key3=>$val3)
												{
											?>
												<div class="btn-group" id="btn_group_<?php echo $key3; ?>">
                                                  <a title="Edit" class="btn btn-mini" onclick="<?php echo $val3['update_function']; ?>"><i class="icon-pencil"></i></a>
                                                </div>
												<br /><br />
											<?php
												}
											}
											?>
                                                
                                            </td>
									</tr>
									<?php
											}
										}
									}
									?>
                                        
                                        
                                </tbody>
                                </table>
								<br /><br />

                            </div>
                        </div>
		
						
						
                        <!-- confirmation box -->
                       <!-- <div class="hide">
                            <div id="confirm_dialog" class="cbox_content">
                                <div class="sepH_c"><strong>Are you sure you want to Suspend/Block this client(s)?</strong></div>
                                <div>
                                    <a href="#" class="btn btn-small btn-beoro-3 confirm_yes">Yes</a>
                                    <a href="#" class="btn btn-small confirm_no">No</a>
                                </div>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
           <!-- footer --> 
<?php echo $middle_footer; ?>
<?php echo $common_js; ?>
<script type="text/javascript" >
hide_message('flashmessage');
function call_editable_row(emp_relationship_id,employee_id)
{

var url = '<?php echo site_url("employee/call_employee_edit_row"); ?>';
			 $.ajax({
						url: url,
						dataType: 'json',
						type: 'POST',
						data: {
								pms_employee_id		 : employee_id,
								emp_relationship_id  : emp_relationship_id,
							  },
						success: function(response) {
						var html  = '';
						var html1 ='';
						html += '<input type="hidden" name="employee_relationship_id_'+emp_relationship_id+'" id="employee_relationship_id_'+emp_relationship_id+'" value="'+response.employee_realtionship_id+'"  />';
						if(response.apraiser_list.length > 0 )
						{
							html += '<select name="apraiser_'+emp_relationship_id+'" id="apraiser_'+emp_relationship_id+'" onblur="call_reviewer_list(\''+emp_relationship_id+'\',\''+employee_id+'\')" >';
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
							html1 += '<select name="reviewer_'+emp_relationship_id+'" id="reviewer_'+emp_relationship_id+'"  >';
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
							html1 += '<select name="reviewer_'+emp_relationship_id+'" id="reviewer_'+emp_relationship_id+'" readonly="readonly"  >';
							html1 += '<option value="">--Please Select---</option>';
							html1 += '</select>';
						}
						
							$('#apraiser_td_'+emp_relationship_id).html('');
							$('#apraiser_td_'+emp_relationship_id).html(html);
							$('#reviewer_td_'+emp_relationship_id).html('');
							$('#reviewer_td_'+emp_relationship_id).html(html1);
							
							$('#btn_group_'+emp_relationship_id).html('');
							$('#btn_group_'+emp_relationship_id).html('<input type="button" name="upadte" value="update" class="btn  btn-beoro-3" onclick="update_relationship_data(\''+emp_relationship_id+'\',\''+employee_id+'\')"  >');
						}
						
				});




}

function call_editable_row_without_reviewer(emp_relationship_id,employee_id)
{
var url = '<?php echo site_url("employee/call_employee_edit_row_without_reviewer"); ?>';
			 $.ajax({
						url: url,
						dataType: 'json',
						type: 'POST',
						data: {
								pms_employee_id		 : employee_id,
								emp_relationship_id  : emp_relationship_id,
							  },
						success: function(response) {
						var html  = '';
						var html1 ='';
						html += '<input type="hidden" name="employee_relationship_id_'+emp_relationship_id+'" id="employee_relationship_id_'+emp_relationship_id+'" value="'+response.employee_realtionship_id+'"  />';
						if(response.apraiser_list.length > 0 )
						{
							html += '<select name="apraiser_'+emp_relationship_id+'" id="apraiser_'+emp_relationship_id+'"  >';
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
							html1 += '<input type="hidden"  name="reviewer_'+emp_relationship_id+'" id="reviewer_'+emp_relationship_id+'" value="'+response.reviewer_id+'"  >'+response.reviewer_list[0]['reviewer_employee_name']+',&nbsp;'+response.apraiser_list[0]['reviewer_designation_name'];
						}
					
						
							$('#apraiser_td_'+emp_relationship_id).html('');
							$('#apraiser_td_'+emp_relationship_id).html(html);
							$('#reviewer_td_'+emp_relationship_id).html('');
							$('#reviewer_td_'+emp_relationship_id).html(html1);
							
							$('#btn_group_'+emp_relationship_id).html('');
							$('#btn_group_'+emp_relationship_id).html('<input type="button" name="upadte" value="update" class="btn  btn-beoro-3" onclick="update_relationship_data_without_reviewer(\''+emp_relationship_id+'\',\''+employee_id+'\')"  >');
						}
						
				});




}



</script>
<script type="text/javascript" >
function update_relationship_data(emp_relationship_id,employee_id)
{
	var emp_relationship_id	= $('#employee_relationship_id_'+emp_relationship_id).val();
	var apraiser_employee_id = $('#apraiser_'+emp_relationship_id).val();
	var reviewer_employee_id = $('#reviewer_'+emp_relationship_id).val();
	if(apraiser_employee_id=='' || apraiser_employee_id==null || apraiser_employee_id==undefined)
	{
		alert("Please select Appraiser");
		return false;
	}
	else if(reviewer_employee_id=='')
	{
		alert("Please select Reviewer");
		return false;
	}
	else if(apraiser_employee_id=='' || reviewer_employee_id=='')
	{
		alert("Please select Appraiser and Reviewer");
		return false;
	}
	else
	{
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
						hide_message('flashmessage');
						if(response.detail)
						{
							$('#apraiser_td_'+emp_relationship_id).html('');
							$('#apraiser_td_'+emp_relationship_id).html(response.detail['appraiser_name_designation']);
							$('#reviewer_td_'+emp_relationship_id).html('');
							$('#reviewer_td_'+emp_relationship_id).html(response.detail['reviewer_name_designation']);
						   $('.cls_reviewer_'+employee_id).html(response.detail['reviewer_name_designation']);
							$('#btn_group_'+emp_relationship_id).html('');
							$('#btn_group_'+emp_relationship_id).html('<a title="Edit" class="btn btn-mini" onclick="call_editable_row(\''+emp_relationship_id+'\',\''+employee_id+'\')"><i class="icon-pencil"></i></a>');
						}
						}
					});
	
	}
	
}

function update_relationship_data_without_reviewer(emp_relationship_id,employee_id)
{
	var emp_relationship_id	= $('#employee_relationship_id_'+emp_relationship_id).val();
	var apraiser_employee_id = $('#apraiser_'+emp_relationship_id).val();
	var reviewer_employee_id = $('#reviewer_'+emp_relationship_id).val();
	
	if(apraiser_employee_id=='' || apraiser_employee_id==null || apraiser_employee_id==undefined)
	{
		alert("Please select Appraiser");
		return false;
	}
	else
	{
	
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
						hide_message('flashmessage');
						if(response.detail)
						{
							$('#apraiser_td_'+emp_relationship_id).html('');
							$('#apraiser_td_'+emp_relationship_id).html(response.detail['appraiser_name_designation']);
							$('#reviewer_td_'+emp_relationship_id).html('');
							$('#reviewer_td_'+emp_relationship_id).html(response.detail['reviewer_name_designation']);
							$('#btn_group_'+emp_relationship_id).html('');
							$('#btn_group_'+emp_relationship_id).html('<a title="Edit" class="btn btn-mini" onclick="call_editable_row_without_reviewer(\''+emp_relationship_id+'\',\''+employee_id+'\')"><i class="icon-pencil"></i></a>');
						}
						}
					});
	}
	
}


</script>
<script type="text/javascript" >
function call_reviewer_list(emp_relationship_id,pms_employee_id)
{

	var apraiser_employee_id = $('#apraiser_'+emp_relationship_id).val();
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
						apraiser_employee_id : apraiser_employee_id,
						pms_employee_id      : pms_employee_id
    		          },
				success: function(response) {
				var i= 0;
				var html ='';
				$('#reviewer_'+emp_relationship_id).html('');
				
				if(response!=null)
				{
					if(apraiser_employee_id=='1')
					{
						$('#reviewer_'+emp_relationship_id).attr('readonly','readonly');
					}
					else
					{
						html += '<option value="">--Please Select---</option>';
						for(i=0; i<response.length; i++ )
						{
							
							html += '<option value="'+response[i]['reviewer_employee_id']+'">'+response[i]['reviewer_employee_name']+', '+response[i]['designation_name']+'</option>';
							
							
						}
						$('#reviewer_'+emp_relationship_id).html(html);
						if($('#reviewer_'+emp_relationship_id).attr('readonly'))
						{
							$('#reviewer_'+emp_relationship_id).removeAttr('readonly','readonly');
						}
					}
				}
				}
					
				
    		});
		}





}
</script>


<?php echo $last_footer; ?>