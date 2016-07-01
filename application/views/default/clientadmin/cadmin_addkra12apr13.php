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
						<td><b>Employee Name: </b></td>
						<td><?php echo $top_employee_detail['fname'].' '.$top_employee_detail['lname']; ?></td>
						<td><b>Employee No:</b></td>
						<td><?php echo $top_employee_detail['employee_id']; ?></td>
						<td><b>Employee Deratment: </b></td>
						<td style="text-align:left;"><?php echo $top_employee_detail['department_name']; ?></td> 
						
					</tr>
					<tr>
						<td><b>Designation: </b></td>
						<td><?php echo $top_employee_detail['designation_name']; ?></td>
						<td><b>Date of Joining:</b></td>
						<td><?php echo date($s_date_format,strtotime($top_employee_detail['date_of_joining'])); ?></td>
						<td><b>Plant / Location:  </b></td>
						<td style="text-align:left;"><?php echo $top_employee_detail['office_name']; ?></td> 
						
					</tr>
					<tr>
						
						<td><b>Date Of Last Promotion:  </b></td>
						<td><?php if($top_employee_detail['last_pramotion_date']!='0000-00-00') { 
						 	echo date($s_date_format,strtotime($top_employee_detail['last_pramotion_date'])); 
						 }else{ echo "N.A."; }
						 ?></td>
						<td ><b>Name and Designation of Apraiser: </b></td>
						<td><?php if($top_employee_apraiser_detail['apraiser_name']) {echo $top_employee_apraiser_detail['apraiser_name']; ?><br />
						<?php } echo $top_employee_apraiser_detail['apraiser_designation']; ?>
						</td>
						
						<td ><b>Name and Designation of Reviewer:</b></td>
						<td style="text-align:left;" >
							<?php if($top_employee_apraiser_detail['reviewer_name']) { echo $top_employee_apraiser_detail['reviewer_name']; ?><br />
							<?php } echo $top_employee_apraiser_detail['reviewer_designation']; ?>
						</td>
						
					</tr>
					
				</tbody>
				</table>
	 
      <div class="w-box-header">
        <h4>KRA [2012-2013]</h4>
      </div>
		
      <form action="" method="post" id="validate_extended">
        <div class="w-box-content cnt_b">  
          <div class="row-fluid">
            <div class="span12">
			
				
				
				
				  <div class="alert alert-info">
                                    <a class="close" data-dismiss="alert">&times;</a>
                                    <strong>Section A:KRA ASSESSMENT - &nbsp;</strong> 
									Breifly describe performance/achevements during the assessment periods. Please use a seprate sheet if space is not adequate. It is important for the 
									appraisar to enter his.her comments to substaintiate the ratings. 
									Your weightage% sum must equal to 100.Please Fill up The following Form
		
                  </div>
              <div class="tabbable tabbable-bordered">
                    <div class="w-box w-box-green" id="invoice_add_edit">
                    <div class="span12">
			   			 <table class="table invE_table table-bordered" id="kra_id" >
							<thead>
								<tr>
									<th style="text-align:left; width:1%;" >Sr. No. </th>
									<th style="text-align:left;">Key Result Area </th>
									<th style="text-align:left;">Performance Target</th>
									<th style="text-align:left;" >Performance Measure</th>
									<th style="text-align:left; width:20px;">Weightage %</th>
								</tr>
							</thead>
						<tbody>
							<?php 
							if(isset($kra_detail))
							{
								if(!empty($kra_detail))
								{
									$i=0;
									foreach($kra_detail as $key=>$val)
									{
										$j= $i+1;
										/*if(($j%2)==0)
										{
										$bgcolor = 'background:#ffffff;';
										}
										else
										{
										$bgcolor = 'background:#F6F6F6;';
										}*/
									?>
										<tr style="<?php //echo $bgcolor; ?>">
										<td class="kra_clone_row" style="text-align:center;">
									<?php echo $j; ?>
										</td>
										<td style="text-align:left;"><?php echo $val['key_result_area']; ?></td>
										<td style="text-align:left;"><?php  echo $val['performance_target']; ?></td>
										<td style="text-align:left;"><?php  echo $val['performance_measure']; ?></td>
										<td style="text-align:center;width:20px;"><?php  echo $val['weightage_value'].'%'; ?></td>
									   </tr>
									<?php
									$i++;
									} 
								}
							}
							else
							{
								
								for($i=0;$i<5;$i++)
								{
								$j= $i+1;
								/*if(($j%2)==0)
								{
								$bgcolor ='background:#ffffff;';
								}
								else
								{
								$bgcolor ='background:#F6F6F6;';
								}*/
								if($i==0)
								{
								$clas_r= 'class="kra_row"';
								}
								else
								{
								$clas_r='';
								}
								?>
								<tr <?php echo $clas_r; ?> >
							
								<td class="kra_clone_row" style="text-align:center;">
								<?php if($i==4){ ?>
								<i class="icon-plus inv_clone_btn"></i>
								<?php } ?>
								<?php echo $j; ?></td>
								<td style="text-align:center;"><textarea class="span10" name="kra_<?php echo $i; ?>" id="kra_<?php echo $i; ?>" ></textarea></td>
								<td style="text-align:center;"><textarea class="span10" name="perf_target_<?php echo $i; ?>" id="perf_target_<?php echo $i; ?>" ></textarea></td>
								<td style="text-align:center;"><textarea class="span10" name="perf_measure_<?php echo $i; ?>" id="perf_measure_<?php echo $i; ?>" ></textarea></td>
								<td style="text-align:left;width:20px;">
									<input type="text"  name="weightage_<?php echo $i; ?>" id="weightage_<?php echo $i; ?>"  class="span12" >
								</td>
							</tr>
						<?php
						} 
						?>
					
								<?php
							}
								?>
							 <tr class="last_row">
										<td colspan="4" style="text-align:right"><b>Total:</b></td>
										<td style="text-align:center"><b>100%</b></td>
							</tr>
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

<?php //echo $middle_footer; ?>
<?php echo $common_js; ?>
<?php echo $last_footer; ?>
