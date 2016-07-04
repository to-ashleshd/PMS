<?php
/**
* Project Code: PMS
* Version: PMS1
* Object: Template
* Template: Default / clientadmin
* Template Name: cadmin_report_promotion.php
* Desc: Display Report
* Last Update: 08-May-2013
* Author: Team Enrich
** Change Log **
* 8-May-13 Add PDF

**/
?>
<?php echo $header; ?>
<div style="height:10px; width:100%"></div>
            <div class="container-fluid" style="padding-left:1px; padding-right:1px;">
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
									Role :&nbsp; <?php echo $whoiam; ?>
								</div>
								
                            <div class="w-box-header">
                                <h4 style="float:left;height:20px; margin-top:5px;">Promotion Recommendation Report</h4>
								<!--
								<div style="width:20px; height:20px; margin-left:50px; float:left; margin-top:-7px;"><a href="<?php echo site_url('assets') . '/kra-2013-05-08_144448.pdf'; ?>" target="_blank" ><i class="icsw16-pdf-documents icsw16-white" title="Print PDF"></i></a></div>
		<div style="width:20px; height:20px; float:left; margin-top:-7px;"><a href="<?php echo site_url('assets') . '/excel_report.xls'; ?>" target="_blank" ><i class="icsw16-note-book icsw16-white" title="Excel Report"></i></a></div>
                            </div>
							-->
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
										<th>Appraiser Rating </th>
										<!-- As Reviewer -->
										<th>Reviewer Rating</th>
										<th>Promotion Recommendation</th>

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
                                            <td><?php echo $val['department_name']?></td>
											<td><?php echo $val['designation_name']?></td>
											<!-- As Appriser -->											
											<td><?php echo $val['appraisee_overall_rating']['score_rating']; ?></td>
											<!-- As Reviewer -->
											<td><?php echo $val['reviewer_overall_rating']['score_rating']; ?></td>
											<td><?php echo $val['promotion_recomandation_info']; ?></td>
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