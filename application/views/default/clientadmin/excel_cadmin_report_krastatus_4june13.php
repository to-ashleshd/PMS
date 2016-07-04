<?php
/**
* Project Code: PMS
* Version: PMS1
* Object: Template
* Template: Default / clientadmin
* Template Name: excel_cadmin_report_promotion.php
* Desc: Export report to excel
* Last Update: 08-May-2013
* Author: Team Enrich
** Change Log **
* 8-May-13 Add PDF

**/
?>
<?php // echo $header; ?>
<?php
$excel_data = '';
$excel_data .= 'Name: ' . "\t" . $this->session->userdata('username') . "\n";
$excel_data .= 'Role: ' . "\t" . $whoiam . "\n";
									if(isset($reviewer_employees))
									{
										if(!empty($reviewer_employees))
										{
										
							//add Headers
							$excel_data .= 'Sr No' . "\t";
							$excel_data .= 'Employee Name' . "\t";
							$excel_data .= 'Emp ID' . "\t";
							$excel_data .= 'Functions' . "\t";
							$excel_data .= 'Department' . "\t";
							$excel_data .= 'Designation' . "\t";
							$excel_data .= 'Status' . "\t";
							/**
							$excel_data .= 'Appraiser Rating' . "\t";
							$excel_data .= 'Reviewer Rating' . "\t";
							$excel_data .= 'Promotion Recommendation' . "\t";
							**/
							$excel_data .= "\n" ;
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
										
										
									
									//Get Details
									$excel_data .= $counter . "\t";
									$excel_data .= $val['employee_name'] . "\t";
									$excel_data .= $val['employee_id'] . "\t";
									$excel_data .= $val['function_name'] . "\t";
									$excel_data .= $val['department_name'] . "\t";
									$excel_data .= $val['designation_name'] . "\t";
									$excel_data .= get_kra_status($val['submit_status']) . "\t";
									/**
									$excel_data .= $val['appraiser_overall_score_name'] . "\t";
									$excel_data .= $val['reviewer_assessment_score_name'] . "\t";
									$excel_data .= $val['promotion_recomandation_info'] . "\t";
									**/
									$excel_data .= "\n" ;
									
										$counter++;
									}
								
							}
									}
									?>
<?php // $this->load->view('default/clientadmin/pdf_cadmin_middle_footer'); ?>		   		   
<?php // echo $middle_footer; ?>
<?php // echo $common_js; ?>
<?php // echo $last_footer; ?>
<?php echo $excel_data; ?>