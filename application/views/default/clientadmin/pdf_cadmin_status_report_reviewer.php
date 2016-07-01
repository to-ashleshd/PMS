<?php
/**
* Project Code: PMS
* Version: PMS1
* Object: Template
* Template: Default / clientadmin
* Template Name: cadmin_status_report.php
* Desc: PDF Report
* Last Update: 08-May-2013
* Author: Team Enrich
** Change Log **
* 
**/
?>
<?php echo $header; ?>

            <div class="container-fluid" style="padding-left:1px; padding-right:1px;">
                <div class="row-fluid">
                    <div class="span12">
						<!-------------------------------- Start KRA Approvel List   ------------------------------------------------------------------------>			
									
									
									
<!-------------------------------- End KRA Approvel List   ------------------------------------------------------------------------>												
<!--<div id="chart_title" style="text-align:center"><h3>My Team PMS Status</h3></div>-->
												
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
                                <h4>Me As Reviewer:</h4>
                            </div>
                            <div class="w-box-content">
							
							    <table id="dt_colVis_Reorder_r" class="table table-striped table-condensed">
                                <thead>
                                     <tr>
                                        <th style="width:100px;">Employee Id</th>
                                        <th>Employee Name</th>
                                        <th style="width:50px;">Grade</th>
										<th style="width:150px;">Designation</th>
										<th style="width:70px;">Department</th>
										<th style="width:100px;">Date Of Joining</th>										
                                        <th style="width:250px;">Status</th>
                                    </tr>
									
									
                                </thead>
                                 <tbody>
                                   
									<?php
									//echo '<pre>';
									//print_r($reviewer_employees);
									//echo '</pre>';
									
									
									foreach($reviewer_employees as $key=>$val)
									{
									
									$kra_score = $val['overall_kra_score_for_appraiser']['overall_kra_score'];
									$cm_score = $val['overall_kra_score_for_appraiser']['overall_competency_score'];
									
									
									$name = $val['fname']. ' '.$val['lname'];
									$show_status ='';
									if($val['submit_status']<=0)
									{
										$show_status = 'KRA not Fill Up.';
									}
									elseif($val['submit_status']<=2)
									{
										$show_status = 'Awaiting for Appraisee Response';
									}
									elseif($val['submit_status']>=2 && $val['submit_status']<6)
									{
									$show_status = 'Awaiting for Appraiser Response';
									}
									elseif($val['submit_status']>=6 && $val['submit_status'] < 8)
									{
									//$show_status  = '<a href="#" onclick="call_agrre_to_apraiser('.$val['pms_employee_id'] .','. $kra_score .','. $cm_score .')">Agree to Appraiser</a>';
									//$show_status .= ' / <a href="'.base_url('reviewer/apraiseeassessment').'/'.$val['pms_employee_id'].'">Reject</a>';
									$show_status  = 'Pending with Reviewer';
									//$show_status  = 'Agree to Appraiser';
									//$show_status .= ' / Reject';
									
									}
									elseif($val['submit_status']>=8)
									{
									$show_status = 'Responded By Reviewer &nbsp;<a href="'.base_url('reviewer/apraiseeassessment').'/'.$val['pms_employee_id'].'"><i class="icon-eye-open"></i></a>';
									}
									
									//Display Score
									$overall_kra_score_overall_total = '';
									 if( $val['overall_kra_score']['overall_total'] >= 1 ) {
									 	$overall_kra_score_overall_total = $val['overall_kra_score']['overall_total'] ;
									}	
									
									
									?>
									<?php if ( $val['submit_status'] >= 1 ) : ?>
									 <tr>
											<td><?php echo $val['employee_id']; ?></td>
                                            <td><?php echo $val['employee_name']; ?></td>
                                            <td><?php echo $val['grade_name']?></td>
                                            <td><?php echo $val['designation_name']?></td>
                                            <td><?php echo $val['department_name']?></td>
											<td><?php echo $val['date_of_joining']?></td>
											 <td id="status_td_<?=$val['pms_employee_id']?>">
                                               <?php echo get_pms_status( $val['submit_status']); ?> 
                                            </td>
									</tr>
									<?php endif; ?>
									<?php
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
                       <!-- <div class="hide">
                            <div id="confirm_dialog" class="cbox_content">
                                <div class="sepH_c"><strong>Are you sure you want to Suspend/Block this client(s)?</strong></div>
                                <div>
                                    <a href="#" class="btn btn-small btn-beoro-3 confirm_yes">Yes</a>
                                    <a href="#" class="btn btn-small confirm_no">No</a>
                                </div>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
           <!-- footer --> 
<?php $this->load->view('default/clientadmin/pdf_cadmin_middle_footer'); ?>		   		   
<?php // echo $middle_footer; ?>
<?php // echo $common_js; ?>

<!-- script for message box -->

<?php // echo $last_footer; ?>