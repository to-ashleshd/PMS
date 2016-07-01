<?php echo $header; ?>
  

  <!-- main content -->
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12"> 
      <div class="w-box"> 
	 
	 
	  
	  
	  <table class="table invE_table table-bordered" style="background-color:#FFFFFF;" >
				<tbody>
					<tr>
						<td valign="top">Employee Name: </td>
						<td valign="top"><strong><?php echo $top_employee_detail['fname'].' '.$top_employee_detail['lname']; ?></strong></td>
						<td valign="top">Employee No:</td>
						<td valign="top"><strong><?php echo $top_employee_detail['employee_id']; ?></strong></td>
						<td valign="top">Employee Department: </td>
						<td valign="top" style="text-align:left;"><strong><?php echo $top_employee_detail['department_name']; ?></strong></td> 
					</tr>
					<tr>
						<td valign="top">Designation: </td>
						<td valign="top"><strong><?php echo $top_employee_detail['designation_name']; ?></strong></td>
						<td valign="top">Plant / Location:  </td>
						<td valign="top" style="text-align:left;"><strong><?php echo $top_employee_detail['office_name']; ?></strong></td> 
						<td colspan="2" >&nbsp;</td>
					</tr>
					<tr>
					
					<td valign="top" >Name &amp; Designation <br />
					    of Appraiser: </td>
						<td valign="top" colspan="2"  >
						<span style="word-wrap: break-word;">
					    <?php 
						if($top_employee_apraiser_detail['appraiser']) {echo $top_employee_apraiser_detail['appraiser']; ?>
					    <?php }  ?>
						</span>				
					    </td>
						
						<td valign="top" >Name &amp; Designation <br />
					    of Reviewer:</td>
						<td valign="top" style="text-align:left;width:125px;" colspan="2" >
							<span style="word-wrap: break-word;">
							<?php if($top_employee_apraiser_detail['reviewer']) { echo $top_employee_apraiser_detail['reviewer']; ?>
							<?php } ?>	
							</span>				
							</td>
					</tr>
				</tbody>
				</table>
	 <?php
		  $this->load->model('taskschedulemodel');
		  $result_year = $this->taskschedulemodel->getTimeperiodById(1);
		  $display_year = '[' . $result_year->time_period_from . ' - ' . $result_year->time_period_to . ']';
	 ?>

      <div class="w-box-header">
			<h4>My KRA <?php echo $display_year; ?></h4>
      </div>
		
      <form action="" method="post" id="add_kra">
	  <input type="hidden" name="h_time_period_id" id="h_time_period_id" value="<?=$time_period_id;?>"  />
	  <input type="hidden" name="employee_relationship_matetix_id" id="employee_relationship_matetix_id" value="<?php if(isset($employee_relationship_matetix_id)) { echo $employee_relationship_matetix_id; }?>"  />
      <input type="hidden" name="apraisee_employee_id" id="apraisee_employee_id" value="<?=$apraisee_employee_id?>"  />
	  
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
										<strong>KRA Not Submitted</strong> 
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
						
			   			
							<?php 
							if(isset($kra_detail))
							{
								if(!empty($kra_detail))
								{
									if($submit_status==0.2)
									{
								?>
								<div class="formSep" id="aprrove_btn" style="float:right; display:;" >
								<input type="button" name="aproove" id="aproove" value="Aproove" class="btn btn-beoro-3" onclick="approve_kra()" />
								<input type="button" name="aproove" id="aproove" value="Not Aproove" class="btn btn-beoro-3"  onclick="donot_approve_kra()" />
								</div>
								<div class="formSep"  style="margin-left:0px;">
                                        <label class="span3"  style="margin-left:-42px;" >Please fill comment if Not Approve: </label>
                                        <textarea class="span6" name="comment" id="comment"  ></textarea>
                                    </div>
								<?php } ?>
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
      </form>
    </div>
  </div>
</div>
</div>


<?php $this->load->view('default/clientadmin/cadmin_middle_footer'); ?>
<?php echo $common_js; ?>

<script type="text/javascript" >
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
									$('#aprrove_btn').hide();
									$('#flashmessages').html('');
									$('#flashmessages').append(html);
									$("html, body").animate({ scrollTop: 0 }, "slow");
								}
								
								}
				});

}

function donot_approve_kra()
{
	var time_period_id	= $('#h_time_period_id').val();
	var employee_relationship_matetix_id	= $('#employee_relationship_matetix_id').val();
	var apraisee_employee_id	= $('#apraisee_employee_id').val();
	
	var comment = $('#comment').val();
	if(comment=='' || comment==null)
	{
		alert("Please Fill Up Comment For Not Approvel");
		return false;
	}
	else
	{
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
										$('#aprrove_btn').hide();
										$('#flashmessages').html('');
										$('#flashmessages').append(html);
										$("html, body").animate({ scrollTop: 0 }, "slow");
									}
									
									}
					});
		}
		else
		{
			return false;	
		}
	}

}


</script>
<?php echo $last_footer; ?>
