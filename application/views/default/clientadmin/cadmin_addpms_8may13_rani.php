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
 
  <?php
	  $id='';
	  ?>
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
						<td valign="top">Employee ID:</td>
						<td valign="top"><strong><?php echo $top_employee_detail['employee_id']; ?></strong></td>
						<td valign="top">Employee Department: </td>
						<td valign="top" style="text-align:left;"><strong><?php echo $top_employee_detail['department_name']; ?></strong></td> 
					</tr>
					<tr>
						<td valign="top">Designation: </td>
						<td valign="top"><strong><?php echo $top_employee_detail['designation_name']; ?></strong></td>
						<!--<td valign="top">Date of Joining:</td>-->
						<!--<td valign="top"><strong><?php //if($top_employee_detail['date_of_joining']!='0000-00-00') { echo date($s_date_format,strtotime($top_employee_detail['date_of_joining'])); } ?></strong></td>-->
						<td valign="top">Plant / Location:  </td>
						<td valign="top" style="text-align:left;"><strong><?php echo $top_employee_detail['office_name']; ?></strong></td> 
						<td colspan="2" >&nbsp;</td>
					</tr>
					<tr>
						
						<!--<td valign="top">Date Of Last Promotion:  </td>
						<td valign="top"><strong>
					    <?php //if($top_employee_detail['last_pramotion_date']!='0000-00-00') { 
						 	//echo date($s_date_format,strtotime($top_employee_detail['last_pramotion_date'])); 
						// }else{ echo "N.A."; }
						 ?>
						</strong></td>-->
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
      <div class="w-box-header">
        <h4>Add PMS [2012-2013] </h4>
      </div>
	
      <form action="" method="post"  id="add_pms">
        <div class="w-box-content cnt_b">  
          <div class="row-fluid">
            <div class="span12">
 
				<?php if(!isset($error))
				  {
				  ?>
				  <div class="alert alert-info">
                                    <a class="close" data-dismiss="alert">&times;</a>
                                    <strong>Section A: KRA ASSESSMENT - &nbsp;</strong> <br />
									Breifly describe performance/achevements during the assessment periods. It is important for the 
									appraise to enter his/her comments to substaintiate the ratings. 
									
		
                  </div>
				 <?php }  ?>
				  <div id="flashmessages" >
				  <?php if(isset($error))
				  {
				  ?>
				    <div class="alert alert-error">
						<b>Alert ! </b><?php echo $error; ?>
					</div>
					<?php
					}
					?>
				</div>
				<?php if(!isset($error))
				  {
				  ?>
              <div class="tabbable tabbable-bordered">
                    <div class="w-box w-box-green" id="invoice_add_edit">
               
                    <div class="span12">
			   			 <table class="table invE_table table-bordered">
						<thead>
							<tr>
								<th style="text-align:center; width:1%">Sr. No. </th>
								<th style="text-align:center;width:230px">Key Result Area </th>
								<th style="text-align:center;width:140px;">Performance Target</th>
								<th style="text-align:center;width:80px;">Performance Measure</th>
								<th style="text-align:center;width:10px;">Weightage %</th>
								<th style="text-align:center; width:5px;">Rating</th>
								<th style="text-align:center; width:190px;">Comments</th>
							</tr>
						</thead>
						<tbody id="pms_detail">
						
							<?php
							
							if(isset($kra_detail))
							{
								if(!empty($kra_detail))
								{
									$i=1;
									foreach($kra_detail  as $key=>$val)
									{
										
										/*if(($i%2)==0)
										{
										$bgcolor ='background:#ffffff;';
										}
										else
										{
										$bgcolor ='background:#F6F6F6;';
										}*/
										?>
										<tr class="inv_row" style="<?php //echo $bgcolor; ?>">
										<td style="text-align:center;" ><?php echo $i; ?></td>
										<td style="text-align:left; width:160px;"><?php echo  $val['key_result_area']; ?></td>
										<td style="text-align:left;width:160px;"><?php echo $val['performance_target']; ?></td>
										<td style="text-align:left;width:100px;"><?php echo  $val['performance_measure']; ?></td>
										<td style="text-align:center;width:10px;"><?php echo $val['weightage_value'].'%'; ?></td>
										<td style="text-align:left;">
										<select  name="rating_<?php echo  $val['apraisee_kra_id']; ?>" id="rating_<?php echo  $val['apraisee_kra_id']; ?>" class="cls_rating span12" >
										<option  value="">Select</option>
										<?php
										if(isset($all_ratings))
										{
										if(!empty($all_ratings))
										{
											$r=1;
											foreach($all_ratings as $key1=>$val1)
											{
											?>
												<option value="<?php echo $val1['rating_id']; ?>" ><?php echo $r.'. ' .$val1['rating_name']; ?></option>
											<?php
											$r++;									
											}
										?>
										</select>
										<?php 
										}
										}
										?>
									</td>
									<td style="text-align:center;"><textarea  class="span11" name="comments_<?php echo  $val['apraisee_kra_id']; ?>" id="comments_<?php echo  $val['apraisee_kra_id']; ?>"></textarea></td>
									</tr>
								<?php 
								$i++;
									}
								}
							}
							?>
						
						
							<?php
							if(isset($pms_detail))
							{
								if(!empty($pms_detail))
								{
									$pid=1;
									foreach($pms_detail as $key=>$val)
									{
																			/*if(($pid%2)==0)
										{
										$bgcolor ='background:#ffffff;';
										}
										else
										{
										$bgcolor ='background:#F6F6F6;';
										}*/
										?>
										<tr class="inv_row" style="<?php // echo $bgcolor; ?>">
										<td style="text-align:center;"><?php echo $pid; ?></td>
										<td style="text-align:left; width:200px;"><?php echo  $val['key_result_area']; ?></td>
										<td style="text-align:left;width:200px;"><?php echo $val['performance_target']; ?></td>
										<td style="text-align:left;width:200px;"><?php echo  $val['performance_measure']; ?></td>
										<td style="text-align:center;width:10px;"><?php echo $val['weightage_name']; ?> % </td>
										<td style="text-align:center; width:5px;">
										
										<?php 
										
										echo $val['rating_value']; ?>
										</td>
										<td style="text-align:left; width:100px;">
										<?php echo $val['comment']; ?>
										</td>
										</tr>
										<?php
											$pid++;								
									}
								}
							}
							?>
					
						<tr>
						<td colspan="4" style="text-align:right;"><b>Total:</b></td>
						<td  style="text-align:center; font-weight:bold;">100%</td>
						<td colspan="2"></td>
						</tr>
						</tbody>	
                                        </table>
                        
                  
					<?php if(!isset($pms_detail))
							{
							?>
						<div class="formSep" id="pms_buttons" style="display:;">
            			<div align="center">
                      
                        <input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
						 <input type="submit" name="submit" value="Next" id="submit" class="btn btn-beoro-3">
                      </div>
					  </div>
					  <?php } ?>
					  
					     <div class="row-fluid" ></div>
					   
					   <div class="row-fluid">
					   
					    <div class="span12">
			   			 
                  <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="3" style="text-align:center;">Rating </th>
                                                        </tr>
														<tr>
                                                            <th  style="text-align:center;">Rating</th>
															<th  style="text-align:center; width:20%;">Definition</th>
															<th  style="text-align:center;">Explanation</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td  style="text-align:center;">5</td>
															<td  style="text-align:justify;">FEE - Far Exceeds Expectations</td>
															<td  style="text-align:justify;">Significantly exceeds expectations on all major goals and standards and is able to achieve stretched goals witd minimum supervision.</td>
                                                        </tr>
														<tr>
                                                            <td  style="text-align:center;">4</td>
															<td  style="text-align:justify;">EE - Exceeds Expectations </td>
															<td  style="text-align:justify;">Consistently meets all major goals and standards, may exceed expectations in a few areas. Needs some guidance and supervision.</td>
                                                        </tr>
														<tr>
                                                            <td  style="text-align:center;">3</td>
															<td  style="text-align:justify;">ME - Meets Expectations</td>
															<td  style="text-align:justify;">Meets most major goals and standards. May be somewhat below expectations on some goals. Meets normal expectations of the job with reasonable degree of guidance.</td>
                                                        </tr>
														<tr>
                                                            <td  style="text-align:center;">2</td>
															<td  style="text-align:justify;">NI - Needs Improvement</td>
															<td  style="text-align:justify;">Meets some goals and standards with close supervision. Is below expectations with respect to other goals but does not significantly underachieve. That is contribution is stronger in some areas of the job than others and there is scope for performance improvement. </td>
                                                        </tr>
														<tr>
                                                            <td  style="text-align:center;">1</td>
															<td  style="text-align:justify;">BE -  Below Expectations </td>
															<td  style="text-align:justify;">Few goals were met and performance on tde job in many areas is well below minimum standards, in-spite of close supervision.</td>
                                                        </tr>
                                                    </tbody>
                         </table>
					    </div>
						</div>
					  
					   </div>
					  </div>
          </div>
		  <?php } ?>
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

$(document).ready(function() {

     $("form").submit(function() {
	 var flag=0;
	 $('#pms_detail tr').each(function() {
	 	var rate = $(this).find(".cls_rating").val();
		//alert(rate);
	 	//if(rate=='' || rate==undefined || isNaN(rate))
		//Modified By Ajay
		if(rate=='' )
		{
			flag=1;
		}
	  });
	  if(flag==1)
	  {
	  	alert("Please Select Rate For Each KRA");
		return false;
	  }
	  else
	  {
	 var t = confirm("Are You sure you would like to submit PMS.");
	 var time_period_id ='1';
	if(t==true)
	 {
     var frm = $('#add_pms');
		
        $.ajax({
            type: frm.attr('method'),
            url: '<?php echo base_url('apraisee/addpmsdata'); ?>',
            data: frm.serialize(),
            success: function (data) {
				
				var html ='';
				$('#reset').click();
				if(data=='Form already submitted')
				{
					alert("Form already submitted");
					return false;
				}
				if(data=='Please try again'){
						html += '<div class="alert alert-error">';
						html += '<a class="close" data-dismiss="alert">&times;</a>';
						html += '<strong>Error!&nbsp;</strong>'+data;
						html += '</div>';
					
				}
				else
				{
					//$('#pms_buttons').hide();
					html += '<div class="alert alert-success">';
                    html += '<a class="close" data-dismiss="alert">&times;</a>';
                    html += '<strong>Success!</strong> '+data;
                    html += '</div>';
					
				}
				$('#flashmessages').after(html);
				
				//$("html, body").animate({ scrollTop: 0 }, "slow");
				               // alert('ok'); 
				
               
			  
					//display pms
		var url = '<?php echo site_url("apraisee/getpmsdetail"); ?>';
		var html = '';
		var time_period_id ='1';
 		 $.ajax({
		 			
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							pms_employee_id : <?php echo $this->session->userdata('pms_employee_id') ?>,
						  },
							success: function(response) {
								if(response.pms_detail.length > 0 )
								{
									
									for(var i=0; i<response.pms_detail.length; i++)
									{
										var j= parseInt(i) + 1;
										var bgcolor ='';
										
										html += '<tr class="inv_row" >';
										html += '<td style="text-align:center;">'+j+'</td>';
										html += '<td style="text-align:left; width:160px;">'+response.pms_detail[i]['key_result_area']+'</td>';
										html += '<td style="text-align:left;width:160px;">'+response.pms_detail[i]['performance_target']+'</td>';
										html += '<td style="text-align:left;width:100px;">'+response.pms_detail[i]['performance_measure']+'</td>';
										html += '<td style="text-align:center;width:10px;">'+response.pms_detail[i]['weightage_name']+'% </td>';
										html += '<td style="text-align:left;">'+response.pms_detail[i]['rating_value']+'</td>';
										html += '<td style="text-align:center;">'+response.pms_detail[i]['comment']+'</td>';
										html += '</tr>';
									}
									if(html!='')
									{
									$("tbody#pms_detail").html(html);
									$('#pms_buttons').hide();
									}
								}
							
							}
				});
			  window.location = '<?php echo base_url(); ?>'+'apraisee/addidp/'+time_period_id+'';
			  
            },
            error: function(jqXHR, textStatus, errorThrown){
            // log the error to the console
            console.log(
                "The following error occured: "+
                textStatus, errorThrown
            );
            }
 
        });
		
		
		//display pms
	/*	var url = '<?php //echo site_url("apraisee/getpmsdetail"); ?>';
		var html = '';*/
		
 		 /*$.ajax({
		 			
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							pms_employee_id : <?php //echo $this->session->userdata('pms_employee_id') ?>,
						  },
							success: function(response) {
								if(response.pms_detail.length > 0 )
								{
									
									for(var i=1; i<response.pms_detail.length; i++)
									{
										var j= parseInt(i) + 1;
										var bgcolor ='';
										if((parseInt(j) % 2)==0)
										{
										bgcolor ='background:#ffffff;';
										}
										else
										{
										bgcolor ='background:#F6F6F6;';
										}
										html += '<tr class="inv_row" style="'+bgcolor+'">';
										html += '<td style="text-align:center;">'+j+'</td>';
										html += '<td style="text-align:left; width:160px;">'+response.pms_detail[i]['key_result_area']+'</td>';
										html += '<td style="text-align:left;width:160px;">'+response.pms_detail[i]['performance_target']+'</td>';
										html += '<td style="text-align:left;width:100px;">'+response.pms_detail[i]['performance_measure']+'</td>';
										html += '<td style="text-align:center;width:10px;">'+response.pms_detail[i]['weightage_name']+'% </td>';
										html += '<td style="text-align:left;">'+response.pms_detail[i]['rating_name']+'</td>';
										html += '<td style="text-align:center;">'+response.pms_detail[i]['comment']+'</td>';
										html += '</tr>';
									}
									if(html!='')
									{
									$("tbody#pms_detail").html(html);
									$('#pms_buttons').hide();
									}
								}
							
							}
				});*/
 		
	}
	}
        return false;
    });
	//}
});
</script>



<?php echo $last_footer; ?>


<?php //$this->load->view('default/clientadmin/cadmin_last_footer'); ?>
