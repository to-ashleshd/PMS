<?php echo $header; ?>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
						
						
						<div class="w-box w-box-orange">
                            <div class="w-box-header">
                                <h4>Employee list</h4>
                            </div>
                            <div class="w-box-content">
							    <table id="dt_colVis_Reorder" class="table table-striped table-condensed">
                                <thead>
                                     <tr>
                                        <th>Id</th>
                                        <th>Employee Name</th>
                                        <th>Grade</th>
										<th>Designation</th>
										<th>Department</th>
										<th>Date Of Joining</th>
                                        <th>Status</th>
                                    </tr>
									
									
                                </thead>
                                 <tbody>
                                   
									<?php 
									foreach($employee as $key=>$val)
									{
									$name = $val['fname']. ' '.$val['lname'];
									$show_status ='';
									if($val['submit_status']<6)
									{
										$show_status = 'Awaiting for Response';
									}
									elseif($val['submit_status']>=6)
									{
									$show_status = '<a href="'.base_url('reviewer/apraiseeassessment').'/'.$val['pms_employee_id'].'">Responded By Appraiser</a>';
									}
									elseif($val['submit_status']>=9)
									{
									$show_status = 'Responded By Reviewer &nbsp;<a href="'.base_url('reviewer/apraiseeassessment').'/'.$val['pms_employee_id'].'"><i class="icon-eye-open"></i></a>';
									}
									?>
								
									 <tr>
											<td><?php echo $val['employee_id']; ?></td>
                                            <td><?php echo $val['employee_name']; ?></td>
                                            <td><?php echo $val['grade_name']?></td>
                                            <td><?php echo $val['designation_name']?></td>
                                            <td><?php echo $val['department_name']?></td>
											<td><?php echo $val['date_of_joining']?></td>
											
											 <td>
                                               <?php echo $show_status; ?>
                                            </td>
									</tr>
									<?php
									}
									?>
                                </tbody>
                                </table>
                                
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>
           <!-- footer --> 
<?php echo $middle_footer; ?>
<?php echo $common_js; ?>
<?php echo $last_footer; ?>
