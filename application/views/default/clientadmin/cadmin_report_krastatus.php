<?php
/**
* Project Code: PMS
* Version: PMS1
* Object: Template
* Template: Default / clientadmin
* Template Name: cadmin_report_krastatus.php
* Desc: Display Report
* Last Update: 08-May-2013
* Author: Team Enrich
** Change Log **
* 8-May-13 Add PDF

**/
?>
<?php echo $header; ?>
<?php
$segment_1 = $this->uri->segment(1) ;
$segment_2 = $this->uri->segment(2) ;
$segment_3 = $this->uri->segment(3) ;
?>

            <div class="container-fluid" >
                <div class="row-fluid">
                    <div class="span12">
						
						<div id="reviewer_flashmsessage">
						</div>
						<?php 
									if(isset($reviewer_employees))
									{
										if(!empty($reviewer_employees))
										{
										?>
										
								
								 <div style="float:right; width:100%; margin-right:10px;">
										<div style="width:32px; height:32px; float:right; margin-top:-7px;  margin-left:10px;"><a href="<?php echo site_url("mypdf/pdfkrastatusreport/") . '/'.$segment_3; ?>" target="_blank" ><img src="<?php echo site_url('assets/user/images/default').'/pdficon.jpg'; ?>" height="32" width="32" title="PDF Report"  /></a></div>
										
										<div style="width:32px; height:32px; float:right; margin-top:-7px;"><a href="<?php echo site_url("mypdf/excelkrastatusreport/") . '/'.$segment_3; ?>" target="_blank" ><img src="<?php echo site_url('assets/user/images/default').'/excelicon.jpg'; ?>" height="32" width="32" title="Excel Report"  /></i></a></div>
							
								</div>
								<br  /><br />
								
								<div class="w-box w-box-orange" >
                            <div class="w-box-header">
                                <h4 style="float:left;height:20px; margin-top:5px;">KRA Status Report <?php echo ($display_year != '' ? ': ' . $display_year : '') ; ?></h4>
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
										<th>KRA Status</th>
										<!-- As Appriser -->
										<!--
										<th>Appraiser Rating </th>
										-->
										<!-- As Reviewer -->
										<!--
										<th>Reviewer Rating</th>
										<th>Promotion Recommendation</th>
										-->

                                    </tr>																		
                                </thead>
                                 <tbody>                                   
									<?php
									$counter = 1 ;
									foreach($reviewer_employees as $key=>$val)
									{
										$name = $val['fname']. ' '.$val['lname'];
										$show_status ='';
										//Display Score
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
										
										
									?>
									<tr>
									 		<td><?php echo $counter; ?></td>
											<td><?php echo $val['employee_name']; ?></td>
											<td><?php echo $val['employee_id']; ?></td>
                                            <td><?php echo $val['function_name']; ?></td>
                                            <td><?php echo $val['department_name']; ?></td>
											<td><?php echo $val['designation_name']; ?></td>
											<td><?php echo get_kra_status($val['submit_status']); ?></td>
											<!-- As Appriser -->
											<!--											
											<td><?php echo $val['appraisee_overall_rating']['score_rating']; ?></td>
											-->
											<!-- As Reviewer -->
											<!--
											<td><?php echo $val['reviewer_overall_rating']['score_rating']; ?></td>
											<td><?php echo $val['promotion_recomandation_info']; ?></td>
											-->
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
<?php echo $middle_footer; ?>
<?php echo $common_js; ?>
<?php echo $last_footer; ?>