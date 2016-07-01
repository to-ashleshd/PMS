<?php
/**
* Project Code: PMS
* Version: PMS1
* Object: Template
* Template: Default / clientadmin
* Template Name: cadmin_status_report.php
* Desc: Excel Report
* Last Update: 08-May-2013
* Author: Team Enrich
** Change Log **
* 
**/
?>
<?php // echo $header; ?>
<?php
$excel_data = '';
$excel_data .="\n";
$excel_data .= 'Name: ' . "\t" . $this->session->userdata('username') . "\n";
$excel_data .= 'Role: ' . "\t" . $whoiam . "\n";
            
									if(isset($reviewer_employees))
									{
										if(!empty($reviewer_employees))
										{
										
							//Add Headers
							$excel_data .= 'Employee Id' . "\t";
							$excel_data .= 'Employee Name' . "\t";
							$excel_data .= 'Grade' . "\t";
							$excel_data .= 'Designation' . "\t";
							$excel_data .= 'Department' . "\t";
							$excel_data .= 'Date Of Joining' . "\t";
							$excel_data .= 'Status' . "\t";
							$excel_data .= "\n" ;
							
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
									<?php
									//Get Details
									$excel_data .= $val['employee_id'] . "\t";
									$excel_data .= $val['employee_name'] . "\t";
									$excel_data .= $val['grade_name'] . "\t";
									$excel_data .= $val['designation_name'] . "\t";
									$excel_data .= $val['department_name'] . "\t";
									$excel_data .= $val['date_of_joining'] . "\t";
									$excel_data .= get_pms_status( $val['submit_status']) . "\t";
									$excel_data .= "\n" ;									
									?>
									<?php endif; ?>
									<?php
									}
								
							}
									}
?>
<?php echo $excel_data; ?>