<?php echo $header; ?>

  <!-- main content -->
  <div class="container-fluid" style="padding-left:1px; padding-right:1px;" >
    <div class="row-fluid"  >
      <div class="span12" > 
      <div class="w-box"   > 
	  <br />
	  
	  <table class="table invE_table table-bordered" style="background-color:#FFFFFF;" >
				<tbody>
					<tr>
						<td valign="top">Employee Name: </td>
						<td valign="top"><strong><?php echo $top_employee_detail['fname'].' '.$top_employee_detail['lname']; ?></strong></td>
						<td valign="top">Plant / Location: </td>
						<td valign="top"><strong><?php echo $top_employee_detail['office_name']; ?></strong></td>
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
					  <td valign="top" >-</td>
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
					  <td valign="top" ><span style="text-align:left;">-</span></td>
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
				
	 <?php
		  //Get Years From and To
		  $this->load->model('taskschedulemodel');
		  $result_year = $this->taskschedulemodel->getTimeperiodById(1);
		  $display_year = '[' . $result_year->time_period_from . ' - ' . $result_year->time_period_to . ']';
	 ?>
	

      <div class="w-box-header">
			<h4>My KRA <?php echo $display_year; ?></h4>
      </div>
      <form action="" method="post" id="add_kra">
	  <?php
	  $height = '';
	  if(count($kra_detail)<8)
	  {
	  	$height = "height:370px;";
	  }
	  ?>
        <div class="w-box-content cnt_b" style="<?php echo $height; ?>"  >  
          <div class="row-fluid">
            <div class="span12">
				  
              <div class="tabbable tabbable-bordered" >
                    <div class="w-box w-box-green" id="invoice_add_edit " >
                    <div class="span12">
				
					<?php
				 
				   if(!isset($error))
				  {
							if(isset($kra_detail))
							{
								if(!empty($kra_detail))
								{
										
								?>
							
								 <table class="table invE_table table-bordered" id="kra_id"  >
									<thead>
										<tr>
											<th style="text-align:left; width:1%;" >Sr. No. </th>
											
											<th style="text-align:left;">Key Result Area </th>
											<th style="text-align:left;">Performance Target</th>
											<th style="text-align:left;" >Performance Measure</th>
											<th style="text-align:left; width:20px;">Weightage %</th>
											<th style="text-align:left;">Initiative</th>
											<th style="text-align:left;">Appraiser Name</th>
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
										<td style="text-align:left;">
										<?php
										
										if($val['apraisee_kra_approve_status'] == 2)
										{
											$display_status = "Approved";
										}
										else if($val['apraisee_kra_approve_status'] == 1)
										{
											$display_status =  "Pending";
										}
										else if($val['apraisee_kra_approve_status'] == 0){
										
											$display_status = "Not Approved";
										}
										?>
										<?=$val['appraiser_name_designation'] . '  (' . $display_status . ')'; ?></td>
									   </tr>
									   
									   
									   
									   
									   
									<?php
									$i++;
									} 
									?>
									<tr class="last_row">
										<td colspan="4" style="text-align:right"><b>Total:</b></td>
										<td style="text-align:center; font-weight:bold;"><span id="total_weight"><?php echo $total_weight; ?></span> %</td>
										<td style="text-align:center" colspan="2">&nbsp;</td>
									</tr>
									
							</tbody>
							</table>
							
									<?php
									
								}
							}
							}
							
							?>
						
					
			
						
                       
    
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


<?php $this->load->view('default/clientadmin/pdf_cadmin_middle_footer'); ?>

<?php //echo $middle_footer; ?>
<?php echo $common_js; ?>
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/form_validation.js"></script>

<?php echo $last_footer; ?>
