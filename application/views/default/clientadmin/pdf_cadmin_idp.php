<?php
/**
* Project Code: PMS
* Version: PMS1
* Object: Template
* Template: Default / clientadmin
* Template Name: cadmin_idp.php
* Desc: Add / Display KRA 
* Last Update: 08-May-2013
* Author: Team Enrich
** Change Log **
* 
* 9-May-13 Update Top Appraisee Info
**/
?>
<?php echo $header; ?>
<?php
$segment_1 = $this->uri->segment(1) ;
$segment_2 = $this->uri->segment(2) ;
$segment_3 = $this->uri->segment(3) ;
?>

        <!-- main content -->
		<div class="container-fluid" style="padding-left:1px; padding-right:1px;" >
    <div class="row-fluid"  >
      <div class="span12" > 
      <div class="w-box"   > 
	  <br />
	 	
				<!-- New Table -->
				<table class="table invE_table table-bordered" style="background-color:#FFFFFF;" >
				<tbody>
					<tr>
						<td valign="top">Employee Name: </td>
						<td valign="top"><strong><?php echo $top_employee_detail['fname'].' '.$top_employee_detail['lname']; ?></strong></td>
						  <td valign="top" >Employee ID:</td>
					  <td valign="top" style="text-align:left;"  ><strong><?php echo $top_employee_detail['employee_id']; ?></strong></td>
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
						<td valign="top">Plant / Location: </td>
						<td valign="top"style="text-align:left;"><strong><?php echo $top_employee_detail['office_name']; ?></strong></td>
					
					
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
					  <td valign="top" style="text-align:left;"><span style="text-align:left;"><?=$last_score?></span></td>
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
				  
				<?php if(!isset($error))
				  {
				  ?>
				  <div class="row-fluid"  >
					    <form  action="" method="post" id="idp_form" style="width: 100%;">
						<input type="hidden" name="time_period_id" id="time_period_id" value="<?php echo $time_period_id; ?>"  />
					    <div class="span12">
			   			  <div class="w-box w-box-green" id="invoice_add_edit">
						
         					<table class="table table-bordered" id="tbl_idp">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;">
													<?php if(isset($idp_detail)) : ?>
													Filled by Appraisee													
													<?php else: ?>
													To be filled by Appraisee
													<?php endif; ?>
													</th>
                                                </tr>
												<tr>
											
											
											<th style="text-align:left" id="idp_info">
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
											</th>
											
											</tr>
                                            </thead>
                                            <tbody id="tbody_appraisee_idp">
											
											<?php
											if(isset($idp_detail))
											{
												if(!empty($idp_detail))
												{
												?>
													 <tr >
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
											
												?>
												
                                            </tbody>	
                                        </table>
						 
						</div> 
						 
					    </div> 
						
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

<?php $this->load->view('default/clientadmin/pdf_cadmin_middle_footer'); ?>      
<?php //echo $middle_footer; ?>
<?php echo $common_js; ?>
<?php echo $last_footer; ?>