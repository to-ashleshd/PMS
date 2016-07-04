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
										<th>Employee Id</th>
                                        <th>Employee Name</th>
                                        <th>Grade</th>
									    <th>Designation</th>
										<th>Department</th>
										<th>Date Of Joining</th>
                                        <th>Action</th>
                                    </tr>
									
									
                                </thead>
                                <tbody>
                                   
									<?php 
									if(isset($employee))
									{
										if(!empty($employee))
										{
											
											foreach($employee as $key=>$val)
											{
										
											?>
									 <tr>
									 		<td><?php echo $key+1; ?></td>
											<td><?php echo $val['employee_id']; ?></td>
                                            <td><?php echo $val['employee_name'] ?></td>
                                            <td><?php echo $val['grade_name']?></td>
                                            <td><?php echo $val['designation_name']?></td>
                                            <td><?php echo $val['department_name']?></td>
											<td><?php echo $val['date_of_joining']?></td>
										<!--	<td><?php //echo $val['dummy_relation']?></td>-->
											 <td>
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-mini" title="Edit"><i class="icon-pencil"></i></a>
                                                    <a href="#" class="btn btn-mini" title="View"><i class="icon-eye-open"></i></a>
                                                    <a href="#" class="btn btn-mini" title="Suspend/Pause"><i class="icsw16-acces-denied-sign"></i></a>
													 <a href="#" class="btn btn-mini" title="Delete"><i class="icsw16-trashcan"></i></a>
                                                </div>
                                            </td>
									</tr>
									<?php
											}
										}
									}
									?>
                                         <!--   <tr>
                                            <td>2</td>
                                            <td>Ajay Gokhale</td>
                                        	<td>Enrich Web Technology Pvt. Ltd.</td>
                                            <td>Web Developer</td>
                                            <td>24/12/2012</td>
											<td>Declan Pamphlett</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="<?php echo site_url('clientadmin/updateemployee/2'); ?>" class="btn btn-mini" title="Edit"><i class="icon-pencil"></i></a>
                                                    <a href="#" class="btn btn-mini" title="View"><i class="icon-eye-open"></i></a>
                                                    <a href="#" class="btn btn-mini" title="Suspend/Pause"><i class="icsw16-acces-denied-sign"></i></a>
													<a href="#" class="btn btn-mini" title="Delete"><i class="icsw16-trashcan"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Kishor Desai</td>
                                            <td>Enrich Web Technology Pvt. Ltd.</td>
                                            <td>Designer</td>
                                            <td>9/12/2012</td>
											<td>Erin Church</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="<?php echo site_url('clientadmin/updateemployee/3'); ?>" class="btn btn-mini" title="Edit"><i class="icon-pencil"></i></a>
                                                    <a href="#" class="btn btn-mini" title="View"><i class="icon-eye-open"></i></a>
                                                    <a href="#" class="btn btn-mini" title="Suspend/Pause"><i class="icsw16-acces-denied-sign"></i></a>
													<a href="#" class="btn btn-mini" title="Delete"><i class="icsw16-trashcan"></i></a>
                                                </div>
                                            </td>
                                        </tr>-->
                                        
                                </tbody>
                                </table>
                            </div>
                        </div>
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
<?php echo $middle_footer; ?>
<?php echo $common_js; ?>
<?php echo $last_footer; ?>