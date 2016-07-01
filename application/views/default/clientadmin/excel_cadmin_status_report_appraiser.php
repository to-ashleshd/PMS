<?php
$excel_data = '';
$excel_data .= "\n";
$excel_data .= 'Name: ' . "\t" . $myname . "\n";
$excel_data .= 'Role: ' . "\t" . $whoiam . "\n\n";
$excel_data .= 'My Team PMS Status' . "\t" . "\n";


						if(isset($employee))
						{
							if(!empty($employee))
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

							
									foreach($employee as $key=>$val)
									{
									$name = $val['fname']. ' '.$val['lname'];
									$show_status ='';
									
									
									/*if($val['submit_status']=='0.2')
									{
										$show_status = '<a href="'.base_url('apraiser/approvekra').'/'.$val['pms_employee_id'].'/'.$val['time_period_id'].'">Pending For KRA Approval</a>';
									}
									else */
									if($val['submit_status']<=0)
									{
										$show_status = 'KRA not Fill Up.';
									}
									else if($val['submit_status']<2)
									{
										$show_status = 'Awaiting for Appraisee Response';
									}
									elseif($val['submit_status']>=2 && $val['submit_status']<6)
									{
										if($this->session->userdata('pms_employee_id')=='1' && $this->session->userdata('pms_employee_id')!=$val['apraiser_employee_id']) 
										{
											$show_status = 'Awaiting for Appraiser Response';
										}
										else{
											$show_status = '<a href="'.base_url('apraiser/apraiseeassessment').'/'.$val['pms_employee_id'].'">PMS / IDP filled by Appraisee</a>';
										}
									}
									elseif($val['submit_status']>=6)
									{
										$show_status = 'PMS / IDP Report &nbsp;<a href="'.base_url('apraiser/apraiseeassessment').'/'.$val['pms_employee_id'].'"> <i class="icon-eye-open"></i></a>';
									}
									if($val['submit_status']!=0.2)
									{
									?>
									<?php if ( $val['submit_status'] > 1 ) : ?>
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
						}
						?>
<?php echo $excel_data; ?>