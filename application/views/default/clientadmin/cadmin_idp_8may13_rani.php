<?php echo $header; ?>
<style>
.tabbable-bordered .nav-tabs > li.active {
	border-top: 5px solid #368CA9;
    margin-top: 0;
    position: relative;
	border-radius:5px;
}

.checkbox.inline { width:250px; margin-right:0px; }

.icon-plus {
    background-position: -408px -96px;
	 margin-left: 10px;
    margin-top: -4px;
}

.icon-minus {
    background-position: -433px -96px;
    margin-left: 10px;
    margin-top: -4px;
}
</style>
 
<?php $tab = 'tb1_a'; ?>
            
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
                                <h4>My IDP [2012-2013]</h4>
                            </div>
                            <div class="w-box-content cnt_b">
                                <div class="row-fluid">
                                    <div class="span12">
												
          <div class="row-fluid">
            <div class="span12">	
			
			<?php if(!isset($error))
				  {
				  ?>
				  <div class="alert alert-info">
                                    <a class="close" data-dismiss="alert" >&times;</a>
                                    <strong>SECTION B: Individual Development Plan - (IDP).&nbsp;</strong> 
									This section is to be filled with joint discussion with Apprasier/s.
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
				  <div class="row-fluid"  >
					    <form  action="" method="post" id="idp_form" style="margin-left: -23px;width: 100%;">
						<input type="hidden" name="time_period_id" id="time_period_id" value="<?php echo $time_period_id; ?>"  />
					    <div class="span12">
			   			  <div class="w-box w-box-green" id="invoice_add_edit">
						
         					<table class="table  invE_table table-bordered" id="tbl_idp">
                                            <thead>
                                                <tr>
                                                    <th colspan="2" style="text-align:center;">
													<?php if(isset($idp_detail)) : ?>
													Filled by Appraisee													
													<?php else: ?>
													To be filled by Appraisee
													<?php endif; ?>
													</th>
                                                    
                                                 
                                                </tr>
												<tr>
											
											
											<td colspan="2" style="text-align:left" id="idp_info">
											<b>Developmental areas : &nbsp;</b>
											<?php
											if(isset($idp_detail))
											{
												if(!empty($idp_detail))
												{
												?>	
												Areas you feel you need to develop in this year to enhance your performance are as follows:
												<?php
												}
											}
											else
											{
											?>
											what are the areas you feel you need to develop in this year to enhance your performance ? <br />
											kindly list them below.
											<?php
											}
											?>
											</td>
											
											</tr>
                                            </thead>
                                            <tbody id="tbody_appraisee_idp">
											
											<?php
											if(isset($idp_detail))
											{
												if(!empty($idp_detail))
												{
												?>
													 <tr colspan="2">
													 <td style="text-align:left; border-right:none; border-top:none;border-bottom:none;">
												<?php
												$i =1;											
													foreach($idp_detail as $key=>$val)
													{
														?>
														 &nbsp; <?php echo '<b>'.$i.'.&nbsp;</b> '.$val['development_area']; ?> <br />
														<?php
													$i++;
													}
													?>
													</td>
													</tr>
													<?php
												}
											}
											else
											{
											?>
												<tr  class="last_row">
                                                    
                                                </tr>
												
                                                <tr colspan="2" class="inv_add_idp_row"   >
                                                  
                                                    <td class="td_add_idp" style="text-align:left; border-right:none; border-top:none;border-bottom:none;">
													<!--<span class="inv_clone_row_no_add_idp">1</span>&nbsp;-->
													<input type="text" class="span5 input_add_idp" name="invE_item[]" />&nbsp;&nbsp;
													<span class="inv_clone_row_add_idp"><i class="icon-plus inv_clone_btn" ></i></span>
													</td>
                                                
                                                </tr>
                                               
												<?php
												}
												?>
							
												
												
											
												 
											
                                              
									
						
												
                                            </tbody>	
                                        </table>
						 
						</div> 
						 
					    </div> 
						<?php
							if(!isset($idp_detail))
							{	
							?>							
						<div class="formSep" id="idp_buttons">  
            			<div align="center">
                         <input type="submit" name="submit" value="Submit" id="submit" class="btn btn-beoro-3">
                        <input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
                    	  </div>
						  </div>
					  <?php } ?>
					  </form>
					  
					  </div>
					  
				<?php
				}
				?>
						</div>
				
						
	
						
              
        </div>
        </div>
    	
    
												
												
												
												
												
                                                </div>
									
								
                                       
                                  
                                </div>
                            
                            </div>
                        </div>
                   
                    </div>
                </div>
      


<?php echo $middle_footer; ?>
<?php echo $common_js; ?>
<script type="text/javascript" >
$(document).ready(function() {



     $("form").submit(function() {

     var frm = $('#idp_form');
	
        $.ajax({
            type: frm.attr('method'),
            url: '<?php echo base_url('apraisee/addidpdata'); ?>',
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
					
					$('#idp_info').html('<b>Developmental areas : &nbsp;</b>Areas you feel you need to develop in this year to enhance your performance are as follows:');
				}
				$('#flashmessages').after(html);
				$("html, body").animate({ scrollTop: 0 }, "slow");
				var url = '<?php echo site_url("apraisee/getidpdetail"); ?>';
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
								if(response.idp_detail.length > 0 )
								{
									
									for(var i=0; i<response.idp_detail.length; i++)
									{
										var j= parseInt(i) + 1;
										
										html += '<tr colspan="2">';
										html += '<td style="text-align:left; border-right:none; border-top:none;border-bottom:none;">';
										html += '<b>'+j+'. '+'</b>'+response.idp_detail[i]['development_area']+'<br />';
										html += '</td>';
										html += '</tr>';
									}
									if(html!='')
									{
										//$('#tbl_idp tr').each(function() {
										// 	$(this).find(".td_add_idp").remove();
										//});
										
									$("tbody#tbody_appraisee_idp").html('');
									$("tbody#tbody_appraisee_idp").html(html);
									$('#idp_buttons').hide();
									}
								}
							
							}
				});

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
	 //return false;
});


</script>
<?php echo $last_footer; ?>
