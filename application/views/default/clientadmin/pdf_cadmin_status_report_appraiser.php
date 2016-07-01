<?php
/**
* Project Code: PMS
* Version: PMS1
* Object: Template
* Template: Default / clientadmin
* Template Name: cadmin_status_report.php
* Desc: Display Status Report 
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
<!--<div id="chart_title" style="text-align:center"><h3>My Team PMS Status</h3></div>
-->						<?php 
						if(isset($employee))
						{
							if(!empty($employee))
							{
							$height = '';
											if(count($employee)<21)
											{
												$height = 'height:595px;';
											}
											
						?>
						<div class="w-box w-box-orange" style="<?php echo $height; ?>" >
						<div id="name_details" >
									Name :&nbsp; <?php echo $this->session->userdata('username'); ?> <br />
									Role :&nbsp; <?php echo $whoiam; ?>
								</div>
								
                            <div class="w-box-header">
                                <h4>Me As Appraiser: </h4>
                            </div>
                            <div class="w-box-content">
							<?php

							?>
							    <table id="dt_colVis_Reorder" class="table table-striped table-condensed">
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
								
									 <tr>
											<td> <?php echo $val['employee_id']; ?></td>
                                            <td><?php echo $val['employee_name']; ?></td>
                                            <td><?php echo $val['grade_name']?></td>
                                            <td><?php echo $val['designation_name']?></td>
                                            <td><?php echo $val['department_name']?></td>
											<td><?php echo $val['date_of_joining']?></td>											
											 <td><?php echo get_pms_status( $val['submit_status']); ?></td>
									</tr>
									<?php endif; ?>
									<?php
									}
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
						<br /><br />
						<div id="reviewer_flashmsessage">
						</div>
						
									
                        
                    </div>
                </div>
            </div>
           <!-- footer --> 
<?php $this->load->view('default/clientadmin/pdf_cadmin_middle_footer'); ?>		   		   
<?php // echo $middle_footer; ?>
<?php // echo $common_js; ?>

<!-- script for message box -->

<?php // echo $last_footer; ?>