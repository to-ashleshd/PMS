<?php
/**
* Project Code: PMS
* Version: PMS1
* Object: Template
* Template: Default / clientadmin
* Template Name: cadmin_view_kra.php
* Desc: Add / Display KRA 
* Last Update: 08-May-2013
* Author: Team Enrich
** Change Log **
* 
* 9-May-13 Update Top Appraisee Info
**/
?>
<?php echo $header; ?>
  <!-- main content -->
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12"> 
      <div class="w-box"> 
	  
	<!-- New Table  -->
	<table class="table invE_table table-bordered" style="background-color:#FFFFFF;" >
				<tbody>
					<tr>
						<td valign="top">Employee Name: </td>
						<td valign="top"><strong><?php echo $top_employee_detail['fname'].' '.$top_employee_detail['lname']; ?></strong></td>
						<td valign="top">Plant / Location: </td>
						<td valign="top"style="text-align:left;"><strong><?php echo $top_employee_detail['office_name']; ?></strong></td>
					</tr>
					<tr>
						<td valign="top">Designation: </td>
						<td valign="top"><strong><?php echo $top_employee_detail['designation_name']; ?></strong></td>
						<!--<td valign="top">Date of Joining:</td>-->
						<!--<td valign="top"><strong><?php //if($top_employee_detail['date_of_joining']!='0000-00-00') { echo date($s_date_format,strtotime($top_employee_detail['date_of_joining'])); } ?></strong></td>-->
						<td valign="top">Employee Department:</td>
						<td valign="top" style="text-align:left;"><strong><?php echo $top_employee_detail['department_name']; ?></strong></td> 
					</tr>
					<tr>
					  <td valign="top" >Employee ID:</td>
					  <td valign="top"  ><strong><?php echo $top_employee_detail['employee_id']; ?></strong></td>
					  <td valign="top"  >Date of Last Promotion </td>
					   <?php
					  $display_last_prom_dt ='-';
					  if($top_employee_detail['last_pramotion_date']!='0000-00-00')
					  {
					  	$display_last_prom_dt =  date($s_date_format,strtotime($top_employee_detail['last_pramotion_date']));
					  }
					  
					  
					  ?>
					  <td valign="top" style="text-align:left;"><?php echo $display_last_prom_dt; ?></td>
				  </tr>
					<tr>
						
						
						<td valign="top" >Name &amp; Designation of Appraiser:</td>
						<td valign="top"  >
						<span style="word-wrap: break-word;">
					    <?php 
						if($top_employee_apraiser_detail['appraiser']) {echo $top_employee_apraiser_detail['appraiser']; ?>
					    <?php }  ?>
						</span>					    </td>
						
						<td valign="top"  ><span style="text-align:left;width:125px;">Last PMS Rating </span></td>
					  <td valign="top" style="text-align:left;"><span style="text-align:left;">-</span></td>
					</tr>
					<tr>
					  <td valign="top" >Name &amp; Designation of Reviewer:</td>
					  <td valign="top"  ><span style="word-wrap: break-word;">
					    <?php if($top_employee_apraiser_detail['reviewer']) { echo $top_employee_apraiser_detail['reviewer']; ?>
                        <?php } ?>
					  </span></td>
					  <td valign="top"  >&nbsp;</td>
					  <td valign="top" >&nbsp;</td>
				  </tr>
				</tbody>
				</table>
	<!-- End New Table -->			
				
				
	 <?php
		  $this->load->model('taskschedulemodel');
		  $result_year = $this->taskschedulemodel->getTimeperiodById($time_period_id);
		  $display_year = '[' . $result_year->time_period_from . ' - ' . $result_year->time_period_to . ']';
	 ?>

      <div class="w-box-header">
			<h4>KRA <?php echo $display_year; ?></h4>
      </div>
		
      <form action="" method="post" id="add_kra">
	  <input type="hidden" name="h_time_period_id" id="h_time_period_id" value="<?=$time_period_id;?>"  />
	  <input type="hidden" name="employee_relationship_matetix_id" id="employee_relationship_matetix_id" value="<?php if(isset($employee_relationship_matetix_id)) { echo $employee_relationship_matetix_id; }?>"  />
      <input type="hidden" name="apraisee_employee_id" id="apraisee_employee_id" value="<?=$apraisee_employee_id?>"  />
	   <input type="hidden" name="apraiser_employee_id" id="apraiser_employee_id" value="<?=$apraiser_employee_id?>"  />
	  
	    <div class="w-box-content cnt_b" >  
          <div class="row-fluid">
            <div class="span12">
			
				
				
			
				   <div id="flashmessages" >
				   <?php
						if(isset($submit_status))
						{
							if($submit_status<=0.1)
							{
								 ?>
								   <div class="alert alert-info">
										<a class="close" data-dismiss="alert">&times;</a>
										<strong>KRA not Submitted</strong> 
								  </div>
								 <?php
							}
							if($submit_status==0.2)
							{
								 ?>
								   <div class="alert alert-info">
										<a class="close" data-dismiss="alert">&times;</a>
										<strong>Please Process KRA </strong> 
								  </div>
								 <?php
							}
							else if($submit_status>0.2)
							{
								?>
								   <div class="alert alert-info">
										<a class="close" data-dismiss="alert">&times;</a>
										<strong>KRA Approved</strong> 
								  </div>
								 <?php
							}
							
						}
						?>
				   </div>
				
				  
              <div class="tabbable tabbable-bordered" >
                    <div class="w-box w-box-green" id="invoice_add_edit " >
                    <div class="span12">
					<div id="content_edit_kra" >
					</div>
						
			   		<div id="kra_detail_content">
							<?php 
							if(isset($kra_detail))
							{
								if(!empty($kra_detail))
								{
									if($submit_status==0.2)
									{
										?>
										<div class="formSep" id="aprrove_btn" style="float:right; display:;" >
										<input type="button" name="aproove" id="aproove" value="Approve" class="btn btn-beoro-3" onclick="approve_kra()" />
										<input type="button" name="not_agrree_edit" id="not_agrree_edit" value="Disapprove" class="btn btn-beoro-3"  onclick="edit_kras()" />
									
										</div>
										<?php } ?>
											<!-- <br /><br /><br /> -->
											<div style="clear:both"></div>
								<div id="div_table_kras" >
								 <table class="table invE_table table-bordered" id="kra_id"  >
									<thead>
										<tr>
											<th style="text-align:left; width:1%;" >Sr. No. </th>
											<th style="text-align:left;">Key Result Area </th>
											<th style="text-align:left;">Performance Target</th>
											<th style="text-align:left;" >Performance Measure</th>
											<th style="text-align:left; width:20px;">Weightage %</th>
											<th style="text-align:left;">Initiative</th>
										</tr>
									</thead>
								<tbody id="kra_detail">
								<?php							
									$i=0;
									foreach($kra_detail as $key=>$val)
									{
										$j= $i+1;
										
									?>
										<tr>
										<td  style="text-align:center;">
										<?php echo $j; ?>
										</td>
										<td style="text-align:left;"><?php echo $val['key_result_area']; ?></td>
										<td style="text-align:left;"><?php  echo $val['performance_target']; ?></td>
										<td style="text-align:left;"><?php  echo $val['performance_measure']; ?></td>
										<td style="text-align:center;width:20px;"><?php  echo $val['weightage_value'].'%'; ?></td>
										<td style="text-align:left;"><?php  echo $val['initaitive']; ?></td>
									   </tr>
										<?php
										$i++;
										} 
										?>
									<tr class="last_row">
										<td colspan="4" style="text-align:right"><b>Total:</b></td>
										<td style="text-align:center; font-weight:bold;"><span id="total_weight"><?php echo $total_weight; ?></span> %</td>
										<td style="text-align:center">&nbsp;</td>
									</tr>
							</tbody>
							</table>
							</div>
									<?php
									
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
        </div>
    	</div>
      </form>
    </div>
  </div>
</div>
</div>


<?php $this->load->view('default/clientadmin/cadmin_middle_footer'); ?>
<?php echo $common_js; ?>

<script type="text/javascript" >
hide_message('flashmessages');
function approve_kra()
{
	var time_period_id	= $('#h_time_period_id').val();
	var employee_relationship_matetix_id	= $('#employee_relationship_matetix_id').val();
	var apraisee_employee_id	= $('#apraisee_employee_id').val();
	
	
	var url = '<?php echo site_url("apraiser/approvedkra"); ?>';
		var html = '';
 		 $.ajax({
		 			
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							time_period_id	: time_period_id,
							employee_relationship_matetix_id : employee_relationship_matetix_id,
							apraisee_employee_id : apraisee_employee_id
						  },
							success: function(response) {
								if(response.error)
								{
									html += '<div class="alert alert-error">';
									html += '<a class="close" data-dismiss="alert">&times;</a>';
									html += '<strong>Error!&nbsp;</strong>'+response.error;
									html += '</div>';
								}
								else if(response.success)
								{
									html += '<div class="alert alert-success">';
									html += '<a class="close" data-dismiss="alert">&times;</a>';
									html += '<strong>Success!</strong> '+response.success;
									html += '</div>';
									$('#div_table_kras').html('');
									$('#div_table_kras').html(response.html);
									$('#aprrove_btn').hide();
									$('#flashmessages').html('');
									$('#flashmessages').append(html);
									$("html, body").animate({ scrollTop: 0 }, "slow");
									hide_message('flashmessages');
								}
								
								}
				});

}

function donot_approve_kra()
{
	var time_period_id	= $('#h_time_period_id').val();
	var employee_relationship_matetix_id	= $('#employee_relationship_matetix_id').val();
	var apraisee_employee_id	= $('#apraisee_employee_id').val();
	

		var t = confirm("Are You Sure You to not approve kra");
		if(t==true)
		{
		var url = '<?php echo site_url("apraiser/donotapprovkra"); ?>';
			var html = '';
			 $.ajax({
						
						url: url,
						dataType: 'json',
						type: 'POST',
						data: {
								time_period_id	: time_period_id,
								employee_relationship_matetix_id : employee_relationship_matetix_id,
								apraisee_employee_id : apraisee_employee_id,
								comment:comment
							  },
								success: function(response) {
									if(response.error)
									{
										html += '<div class="alert alert-error">';
										html += '<a class="close" data-dismiss="alert">&times;</a>';
										html += '<strong>Error!&nbsp;</strong>'+response.error;
										html += '</div>';
									}
									else if(response.success)
									{
										html += '<div class="alert alert-success">';
										html += '<a class="close" data-dismiss="alert">&times;</a>';
										html += '<strong>Success!</strong> '+response.success;
										html += '</div>';
										$('#write_comment').html('');
										$('#aprrove_btn').hide();
										$('#flashmessages').html('');
										$('#flashmessages').append(html);
										$("html, body").animate({ scrollTop: 0 }, "slow");
										hide_message('flashmessages');
									}
									
									}
					});
		}
		else
		{
			return false;	
		}
	

}
</script>
<script type="text/javascript" >
//new functionality to edit kra

function edit_kras()
{
	$('#not_agrree_edit').attr('disabled','disabled');
	$('#not_agrree_edit').css('color','#FFFFFF');
	var time_period_id = $('#h_time_period_id').val();
	var apraisee_employee_id = $('#apraisee_employee_id').val();
	
	var url = '<?php echo site_url("apraisee/get_Kra_by_appraiser_for_edit"); ?>';
	var html = '';
 		 $.ajax({
		 			
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							apraisee_employee_id : apraisee_employee_id,
							time_period_id :time_period_id
						  },
							success: function(response) {
								if(response.html)
								{
									$('#div_table_kras').html('');
									$('#div_table_kras').html(response.html);
								}
							}
				});
}


function update_kra(kra_id,sr_no)
{

	$('tr#editable_'+kra_id).html('');
	
	var url = '<?php echo site_url("apraisee/updatekra"); ?>';
		var html = '';
 		 $.ajax({
		 			
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							apraisee_kra_id : kra_id
						  },
							success: function(response) {
								if(response.kra_detail)
								{
									html += '<td  style="text-align:center;" class="cls_sr_no" >';
									html +=  sr_no;
									html += '</td>';
									
									html += '<td style="text-align:left;"><textarea class="span10" name="edit_kra_'+response.kra_detail['apraisee_kra_id']+'" id="edit_kra_'+response.kra_detail['apraisee_kra_id']+'" >'+response.kra_detail['key_result_area']+'</textarea></td>';
									html += '<td style="text-align:left;"><textarea class="span10" name="edit_perf_target_'+response.kra_detail['apraisee_kra_id']+'" id="edit_perf_target_'+response.kra_detail['apraisee_kra_id']+'" >'+response.kra_detail['performance_target']+'</textarea></td>';
									html += '<td style="text-align:left;"><textarea class="span10" name="edit_perf_measure_'+response.kra_detail['apraisee_kra_id']+'" id="edit_perf_measure_'+response.kra_detail['apraisee_kra_id']+'" >'+response.kra_detail['performance_measure']+'</textarea></td>';
									html += '<td style="text-align:center;width:20px;" class="cls_display_edit_weight" >';
									html += '<input class="span12" type="hidden"  name="weight_old'+response.kra_detail['apraisee_kra_id']+'"    id="weight_old'+response.kra_detail['apraisee_kra_id']+'" value="'+response.kra_detail['weightage_value']+'"   >';
									html += '<input class="cls_weight_edit span12" type="text"  name="edit_weight_'+response.kra_detail['apraisee_kra_id']+'"    id="edit_weight_'+response.kra_detail['apraisee_kra_id']+'" value="'+response.kra_detail['weightage_value']+'" readonly="readonly"  ><br /><br />';
									html += '</td>';
									html += '<td style="text-align:left;"  ><textarea class="span10" name="edit_initiative_'+response.kra_detail['apraisee_kra_id']+'" id="edit_initiative_'+response.kra_detail['apraisee_kra_id']+'" >'+response.kra_detail['initaitive']+'</textarea></td>';
									
									html += '<td style="text-align:center;" class="cls_edit_link" ><input type="button" name="upadte" id="update" value="Update" class="btn btn-beoro-3" onclick="updatekradata('+kra_id+','+sr_no+')"  /></td>';
									$('tr#editable_'+kra_id).html(html);
								}
								
								
								}
				});

}
function updatekradata(kra_id,sr_no)
{
	var key_result_area	= $('#edit_kra_'+kra_id).val();
	var perf_target		= $('#edit_perf_target_'+kra_id).val();
	var perf_measure	= $('#edit_perf_measure_'+kra_id).val();
	var weight			= $('#edit_weight_'+kra_id).val();
	var initiative		= $('#edit_initiative_'+kra_id).val();
	var appraiser_employee_id = $('#apraiser_employee_id').val();
	
	var html = '';
	$('tr#editable_'+kra_id).html('');
	var net_weight = $('#edit_total_weight').html();
	$('#txt_edit_total_weight').val(net_weight);
	var edit_total_weight = $('#txt_edit_total_weight').val();
	var html1 = '';
		var url = '<?php echo site_url("apraisee/updatekradata"); ?>';
		var html = '';
 		 $.ajax({
		 			
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							apraisee_kra_id : kra_id,
							key_result_area : key_result_area,
							perf_target		: perf_target,
							perf_measure	: perf_measure,
							weight			: weight,
							initiative		: initiative,
							appraiser_employee_id :appraiser_employee_id
						  },
							success: function(response) {
									if(response.msg=='Please Try Again.'){ 
													html1 += '<div class="alert alert-error">';
													html1 += '<a class="close" data-dismiss="alert">&times;</a>';
													html1 += '<strong>Error!&nbsp;</strong>'+response.msg;
													html1 += '</div>';
												
											}
											else
											{
												html1 += '<div class="alert alert-success">';
												html1 += '<a class="close" data-dismiss="alert">&times;</a>';
												html1 += '<strong>Success!</strong> Appraiser KRA Modified Successfully.';
												html1 += '</div>';
											}
											$('#flashmessages').html('');
											$('#flashmessages').append(html1);
											$("html, body").animate({ scrollTop: 0 }, "slow");
											hide_message('flashmessages');
							
							
								if(response.kra_detail)
								{
									html += '<td  style="text-align:left;weight:1%;" class="cls_sr_no" >';
									html +=  sr_no;
									html += '</td>';
									
									html += '<td style="text-align:left;">'+response.kra_detail['key_result_area']+'</td>';
									html += '<td style="text-align:left;">'+response.kra_detail['performance_target']+'</td>';
									html += '<td style="text-align:left;">'+response.kra_detail['performance_measure']+'</td>';
									html += '<td style="text-align:center;" class="cls_display_edit_weight"  >';
									html += response.kra_detail['weightage_value']+' %';
									html += '<input class="cls_weight_edit span12" type="hidden"  name="edit_weight_'+response.kra_detail['apraisee_kra_id']+'" readonly="readonly"  id="edit_weight_'+response.kra_detail['apraisee_kra_id']+'" value="'+response.kra_detail['weightage_value']+'"   onblur="calculate_edit_total()" ><br /><br />';
									html += '</td>';
									html += '<td style="text-align:left;">'+response.kra_detail['initaitive']+'</td>';
									//html += '<td style="text-align:left;">'+response.kra_detail['appraiser_name_designation']+'</td>';
									html += '<td style="text-align:center;" class="cls_edit_link" >';
									html += '<a href="javascript:void(0)" onclick="update_kra(\''+response.kra_detail['apraisee_kra_id']+'\',\''+sr_no+'\')" ><i class="icsw16-pencil"></i></a>';
									//html += '<a href="javascript:void(0)" onclick="remove_kra(\''+response.kra_detail['apraisee_kra_id']+'\',\''+sr_no+'\')" ><i class="icsw16-trashcan"></i></a>';
									html += '</td>';
									$('tr#editable_'+kra_id).html(html);
								}
								
								}
				});
				
				

	
	
	
	

}


</script>

<?php echo $last_footer; ?>
