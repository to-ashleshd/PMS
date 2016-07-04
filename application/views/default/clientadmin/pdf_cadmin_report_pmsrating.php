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
<div style="height:10px; width:100%"></div>
            <div class="container-fluid"  style="padding-left:1px; padding-right:1px;">
                <div class="row-fluid">
                    <div class="span12">
						
						<div id="reviewer_flashmsessage">
						</div>
						<?php 
									if(isset($reviewer_employees))
									{
										if(!empty($reviewer_employees))
										{
											$height = '';
											if(count($reviewer_employees)<21)
											{
												$height = 'height:595px;';
											}
										?>
								<div class="w-box w-box-orange" style="<?php echo $height; ?>">
								<div id="name_details" >
									Name :&nbsp; <?php echo $this->session->userdata('username'); ?> <br />
									Role :&nbsp; <?php echo ucfirst($whoiam); ?>
								</div>
                            <div class="w-box-header">
                                <h4 style="float:left;height:20px; margin-top:5px;">PMS Rating Report</h4>
                            </div>
                            <div class="w-box-content">
								
							    <table id="dt_colVis_Reorder" class="table table-striped table-condensed">
                                <thead>
                                     <tr>
									 	<th>Sr No</th>
										<th>Employee Name</th>
                                        <th>Emp ID</th>
                                        <th>Functions</th>
                                        <th>Department</th>
										<th>Designation</th>
										<!-- As Appriser -->
										<?php if($whoiam =='appraiser' or $whoiam =='reviewer' ): ?>
										<th>Appraiser<br />KRA Score</th>
										<th>Appraiser<br />Competency Score</th>
										<th>Appraiser<br />Total Score</th>
										<th>Appraiser<br />Rating</th>
										<?php endif; ?>										
										<!-- As Reviewer -->
										<?php if($whoiam =='reviewer' ): ?>
										<th>Reviewer<br />KRA Score</th>
										<th>Reviewer<br />Competency Score</th>
										<th>Reviewer<br />Total Score</th>
										<th>Reviewer<br />Rating</th>
										<?php endif; ?>
                                    </tr>																		
                                </thead>
                                 <tbody >          
								 	               
									<?php
									$counter = 1 ;
									foreach($reviewer_employees as $key=>$val)
									{
										$name = $val['fname']. ' '.$val['lname'];
										$show_status ='';
										//Display Score
										/**
										$overall_kra_score_overall_total = '';
										 if( $val['overall_kra_score']['overall_total'] >= 1 ) {
											$overall_kra_score_overall_total = $val['overall_kra_score']['overall_total'] ;
										}	
										if( $val['submit_status'] < 1 ) {
											$show_status = '';
										}
										else {
											$show_status = 'View Report&nbsp;<a href="'.base_url('reviewer/viewreport').'/'.$val['pms_employee_id'].'"><i class="icon-eye-open"></i></a>';
										}
										//echo '<pre>';
										//print_r($val);
										//echo '</pre>';
										
										$appraiser_kra_score = $val['appraiser_score_details']['overall_kra_score'] ;
										$appraiser_cm_score = $val['appraiser_score_details']['overall_competency_score'] ;
										$appraiser_overall_score = $val['appraiser_score_details']['overall_total'] ;
										
										//Make Roundup 
										$appraiser_kra_score = number_format($appraiser_kra_score, 2, '.', '');
										$appraiser_cm_score = number_format($appraiser_cm_score, 2, '.', '');
										$appraiser_overall_score = number_format($appraiser_overall_score, 2, '.', '');
										
										$reviewer_final_score_idp = number_format($val['reviewer_final_score_idp'], 2, '.', '');
										$reviewer_final_score_kra = number_format($val['reviewer_final_score_kra'], 2, '.', '');
										$reviewer_orverall_total = number_format($val['reviewer_orverall_total'], 2, '.', '');
										**/
										//Make Roundup 
										$appraiser_kra_score = number_format( $val['appraisee_overall_rating']['kra_score'] , 2, '.', '');
										$appraiser_cm_score = number_format($val['appraisee_overall_rating']['average_competency_score'], 2, '.', '');
										$appraiser_overall_score = number_format($val['appraisee_overall_rating']['overall_rating'], 2, '.', '');
										$appraiser_score_rating = $val['appraisee_overall_rating']['score_rating'];
										
										$reviewer_final_score_kra = number_format( $val['reviewer_overall_rating']['kra_score'] , 2, '.', '');
										$reviewer_final_score_idp = number_format($val['reviewer_overall_rating']['average_competency_score'], 2, '.', '');
										$reviewer_orverall_total = number_format($val['reviewer_overall_rating']['overall_rating'], 2, '.', '');
										$reviewer_score_rating = $val['reviewer_overall_rating']['score_rating'];
										
										
										
									?>
									<tr>          
									 		<td><?php echo $counter; ?></td>
											<td><?php echo $val['employee_name']; ?></td>
											<td><?php echo $val['employee_id']; ?></td>
                                            <td><?php echo $val['function_name']; ?></td>
                                            <td><?php echo $val['department_name']?></td>
											<td><?php echo $val['designation_name']?></td>
											<!-- As Appriser -->
											<?php if($whoiam =='appraiser' or $whoiam =='reviewer' ): ?>
											<td><?php echo $appraiser_kra_score; ?></td>
											<td><?php echo $appraiser_cm_score; ?></td>
											<td><?php echo $appraiser_overall_score; ?></td>
											<td><?php echo $appraiser_score_rating ; ?></td>
											<?php endif; ?>
										<!-- As Reviewer -->
											<?php if($whoiam =='reviewer' ): ?>
										<td><?php echo $reviewer_final_score_kra; ?></td>
										<td><?php echo $reviewer_final_score_idp; ?></td>
										<td><?php echo $reviewer_orverall_total; ?></td>
										<td><?php echo $reviewer_score_rating; ?></td>
											<?php endif; ?>	
                                            
											
									</tr>
	
	

									<?php
										$counter++;
									}
								?>
                                </tbody>
                                </table>
                                
                            </div>
                        </div>
						<?php
							}
									}
									?>
									
                        <!-- confirmation box -->
                       
                    </div>
                </div>
            </div>
           <!-- footer --> 
<?php $this->load->view('default/clientadmin/pdf_cadmin_middle_footer'); ?>		   
<?php // echo $middle_footer; ?>
<?php // echo $common_js; ?>
<?php // echo $last_footer; ?>