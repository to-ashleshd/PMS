<?php
/**
* Project Code: PMS
* Version: PMS1
* Object: Template
* Template: Default / clientadmin
* Template Name: cadmin_apraiser_employee_list.php
* Desc: Display My Team
* Last Update: 08-May-2013
* Author: Team Enrich
** Change Log **
* 
* 9-May-13 Update Top Appraisee Info
**/
?>
<?php echo $header; ?>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
						<!-------------------------------- Start KRA Approvel List   ------------------------------------------------------------------------>			
									
									<div class="w-box w-box-orange">
                            <div class="w-box-header">
                                <h4>KRA Approval Employee list</h4>
                            </div>
                            <div class="w-box-content">
							
							    <table id="dt_colVis_Reorder" class="table table-striped table-condensed">
                                <thead>									
									<tr>
                                        <th style="width:100px;">Employee Id</th>
                                        <th>Employee Name</th>
										<th>Year</th>
                                        <th style="width:50px;">Grade</th>
										<th style="width:150px;">Designation</th>
										<th style="width:70px;">Department</th>
										<th style="width:100px;">Date Of Joining</th>										
                                        <th style="width:250px;">Status</th>
                                    </tr>
                                </thead>
                                 <tbody>
								 <?php
								 
								 
									if(isset($approvel_employees))
									{
										if(!empty($approvel_employees))
										{
										
								 
									foreach($approvel_employees as $key=>$val)
									{
									$name = $val['fname']. ' '.$val['lname'];
									$show_status ='';
									
/** New Status **/
									if( $val['pending_count'] >= 1 ) {
										$show_status = '<a href="'.base_url('apraiser/approvekra').'/'.$val['pms_employee_id'].'/'.$val['time_period_id'].'">' . get_pms_status($val['pending_count']) . '</a>';
									}
									else {
										//$show_status = 'KRA Approved';
										$show_status = '';
									}
									if($val['track_status']==0.2)
									{
										$show_status = '<a href="'.base_url('apraiser/approvekra').'/'.$val['pms_employee_id'].'/'.$val['time_period_id'].'">' . get_pms_status($val['track_status']) . '</a>';
									}
/**
									if($val['submit_status']<2 and $val['track_status']==0.2 )
									{
										$show_status = 'Awaiting for Appraisee Response 1';
										$show_status = '<a href="'.base_url('apraiser/approvekra').'/'.$val['pms_employee_id'].'/'.$val['time_period_id'].'">Pending For KRA Approval ToDO</a>';
									}
									elseif($val['submit_status']>=2 && $val['submit_status']<6)
									{
										if($this->session->userdata('pms_employee_id')=='1' && $this->session->userdata('pms_employee_id')!=$val['apraiser_employee_id']) 
										{
											$show_status = 'Awaiting for Appraiser Response';
										}
										else{
										$show_status = '<a href="'.base_url('apraiser/apraiseeassessment').'/'.$val['pms_employee_id'].'">Responded By Appraisee</a>';
										}
									}
									elseif($val['submit_status']>=6)
									{
										$show_status = '<a href="'.base_url('apraiser/apraiseeassessment').'/'.$val['pms_employee_id'].'">Responded By Appraiser</a>';
									}
**/

/** End Status **/
								
								
									
									?>
								
									 <tr>
											<td><?php echo $val['employee_id']; ?></td>
											
                                            <td><?php echo $val['employee_name']; ?></td>
											<td><?php echo $val['time_period_name']; ?></td>
                                            <td><?php echo $val['grade_name']?></td>
                                            <td><?php echo $val['designation_name']?></td>
                                            <td><?php echo $val['department_name']?></td>
											<td><?php echo $val['date_of_joining']?></td>
											
											 <td id="status_td_<?=$val['pms_employee_id']?>">
                                               <?php echo $show_status; ?>
                                            </td>
									</tr>
									<?php
									}
									}
									else
									{
										?>
										<tr>
										<td colspan="8">&nbsp;</td>
										</tr>
										<tr>
										
										<td style="text-align:center" colspan="8"> NO Data. </td>
										</tr>
										<?php
									}
							}
								?>
								 
								 
								 
                                   	 </tbody>
                                </table>
									</div>
									</div>
									<br />
									<br />
<!-------------------------------- End KRA Approvel List   ------------------------------------------------------------------------>												

						<?php 
						if(isset($employee))
						{
							if(!empty($employee))
							{
						?>
						<div class="w-box w-box-orange">
                            <div class="w-box-header">
                                <h4>Appraiser Employee list</h4>
                            </div>
                            <div class="w-box-content">
							<?php

							?>
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
									foreach($employee as $key=>$val)
									{
									$name = $val['fname']. ' '.$val['lname'];
									$show_status ='';
									
									
									/*if($val['submit_status']=='0.2')
									{
										$show_status = '<a href="'.base_url('apraiser/approvekra').'/'.$val['pms_employee_id'].'/'.$val['time_period_id'].'">Pending For KRA Approval</a>';
									}
									else */
									/*if($val['submit_status']<=0)
									{
										$show_status = 'KRA not Fill Up.';
									}
									else*/
									if($val['submit_status']<2)
									{
										$show_status = get_pms_status($val['submit_status']) ;
									}
									elseif($val['submit_status']>=2 && $val['submit_status']<6)
									{
										if($this->session->userdata('pms_employee_id')=='1' && $this->session->userdata('pms_employee_id')!=$val['apraiser_employee_id']) 
										{
											$show_status = get_pms_status($val['submit_status']);
										}
										else{
											$show_status = '<a href="'.base_url('apraiser/apraiseeassessment').'/'.$val['pms_employee_id'].'">'.get_pms_status($val['submit_status']).'</a>';
										}
									}
									elseif($val['submit_status']>=6)
									{
										$show_status = get_pms_status($val['submit_status']).' &nbsp;<a href="'.base_url('apraiser/apraiseeassessment').'/'.$val['pms_employee_id'].'"> <i class="icon-eye-open"></i></a>';
									}
									if($val['submit_status']!=0.2)
									{
									?>
								
									 <tr>
											<td> <?php echo $val['employee_id']; ?></td>
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
						<?php 
									if(isset($reviewer_employees))
									{
										if(!empty($reviewer_employees))
										{
										?>
								<div class="w-box w-box-orange">
                            <div class="w-box-header">
                                <h4>Reviewer Employee list</h4>
                            </div>
                            <div class="w-box-content">
							
							    <table id="dt_colVis_Reorder" class="table table-striped table-condensed">
                                <thead>
                                     <tr>
                                        <th>Employee Id</th>
                                        <th>Employee Name</th>
                                        <th>Grade</th>
										<th>Designation</th>
										<th>Department</th>
										<th>Date Of Joining</th>
										<th>Manager Rating</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                 <tbody>
                                   
									<?php
									//echo '<pre>';
									//print_r($reviewer_employees);
									//echo '</pre>';									
									
									foreach($reviewer_employees as $key=>$val)
									{
									
									//$kra_score = $val['overall_kra_score_for_appraiser']['overall_kra_score'];
									//$cm_score = $val['overall_kra_score_for_appraiser']['overall_competency_score'];
									
									$kra_score = $val['appraisee_overall_rating']['kra_score'];
									$cm_score = $val['appraisee_overall_rating']['average_competency_score'];
									$overall_rating = $val['appraisee_overall_rating']['overall_rating'];
									$score_rating = $val['appraisee_overall_rating']['score_rating'];
									
									
									$name = $val['fname']. ' '.$val['lname'];
									$show_status ='';
									if($val['submit_status']<=0)
									{
										$show_status = 'KRA not fill up.'; 
										$show_status = get_pms_status($val['submit_status']);
									}
									elseif($val['submit_status']<=2)
									{
										$show_status = get_pms_status($val['submit_status']);
									}
									elseif($val['submit_status']>=2 && $val['submit_status']<6)
									{
									$show_status = get_pms_status($val['submit_status']);
									}
									elseif($val['submit_status']>=6 && $val['submit_status'] < 8)
									{
									$show_status  = get_pms_status($val['submit_status']) . ' '.'<a href="#" onclick="call_agrre_to_apraiser('.$val['pms_employee_id'] .','. $kra_score .','. $cm_score .')">'.'I Agree</a>';
									$show_status .= '   /   <a href="'.base_url('reviewer/apraiseeassessment').'/'.$val['pms_employee_id'].'">'.'Reject</a>';
									}
									elseif($val['submit_status']>=8)
									{
									$show_status = get_pms_status($val['submit_status']).'&nbsp;<a href="'.base_url('reviewer/apraiseeassessment').'/'.$val['pms_employee_id'].'"><i class="icon-eye-open"></i></a>';
									}
									
									//Display Score
									$overall_kra_score_overall_total = '';
									 if( $val['overall_kra_score']['overall_total'] >= 1 ) {
									 	$overall_kra_score_overall_total = $val['overall_kra_score']['overall_total'] ;
									}	
									
									?>
								
									 <tr>
											<td><?php echo $val['employee_id']; ?></td>
                                            <td><?php echo $val['employee_name']; ?></td>
                                            <td><?php echo $val['grade_name']?></td>
                                            <td><?php echo $val['designation_name']?></td>
                                            <td><?php echo $val['department_name']?></td>
											<td><?php echo $val['date_of_joining']?></td>
											<!-- <td><?php // echo $val['overall_rating']?> | <?php // echo  $val['overall_kra_score_name'] . ' | ' . $val['overall_kra_score']['overall_total'] ; ?></td> -->
											<td><?php echo $score_rating  .' | ' . $overall_rating;  ?></td>
											 <td id="status_td_<?=$val['pms_employee_id']?>">
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
<?php echo $middle_footer; ?>
<?php echo $common_js; ?>
<script type="text/javascript" >
hide_message('reviewer_flashmsessage');
function example7() {

            $.msgBox({ type: "prompt",
                title: "Confirm",
				content: "Are you sure to confirm?",
                inputs: [
                { header: "User Name", type: "text", name: "userName" },
                { header: "Password", type: "password", name: "password" },
                { header: "Remember me", type: "checkbox", name: "rememberMe", value: "theValue"}],
                buttons: [
                { value: "Login" }, { value: "Cancel"}],
                success: function (result, values) {
                    var v = result + " has been clicked\n";
                    $(values).each(function (index, input) {
                        v += input.name + " : " + input.value + 
                        (input.checked != null ? (" - checked: " + input.checked) : "") + "\n";
                    });
                    alert(v);
                }
            });
}

function  call_agrre_to_apraiser(pms_employee_id,kra_score,cm_score)
{
	//alert('Call call_agrre_to_apraiser ');
	//alert('KRA Scrore: ' +kra_score + ' CM ' + cm_score );

	/** Call Agree to Appraiser **/
	var reviewer_agree = 'N';
	$.msgBox({ type: "prompt",
                title: "Agree to Appraiser?",
				content: "Are you sure to confirm?",
                inputs: [
                { header: "KRA Score", type: "text", name: "userName", value:kra_score },
                { header: "CM Score", type: "text", name: "password", value:cm_score }
				],
                buttons: [
                { value: "I Agree" }, { value: "Cancel"}],
                success: function (result, values) {
                    var v = result + " has been clicked\n";
					//alert('Result: ' + result);
                    $(values).each(function (index, input) {
                        v += input.name + " : " + input.value + 
                        (input.checked != null ? (" - checked: " + input.checked) : "") + "\n";
						if( input.name == 'iagree' && input.value == 'I AGREE' ) {
						}
                    });
                    //alert(v);
					
					if( result == 'I Agree' ) {
						//alert('In I Agree Button');
						var url = '<?php echo site_url("reviewer/addreviewerassessment"); ?>';
									var html = '';
									$.ajax({
										url: url,
										dataType: 'json',
										type: 'POST',
										data: {
												pms_employee_id : pms_employee_id,
											  },
										success: function(response) {
										if(response.msg)
										{
											html += '<div class="alert alert-success">';
											html += '<a class="close" data-dismiss="alert">&times;</a>';
											html += '<strong>Success!</strong> '+response.msg;
											html += '</div>';
											$('#reviewer_flashmsessage').html(html);
											hide_message('reviewer_flashmsessage');
										}
										$('td#status_td_'+pms_employee_id).html('');
										$('td#status_td_'+pms_employee_id).html('Complete &nbsp;<a href="<?php echo base_url('reviewer/apraiseeassessment'); ?>/'+pms_employee_id+'"><i class="icon-eye-open"></i></a>');
										}	
									});
						
						
						
						/**
						$(values).each(function (index, input) {
							//alert('Input: ' + input.name );
							
							if( input.name == 'iagree' ) {
							
								if( input.value == 'I AGREE' ) {
									reviewer_agree = 'Y' ;
									
									/** Apply for I Agree **
									
									var url = '<?php // echo site_url("reviewer/addreviewerassessment"); ?>';
									var html = '';
									 $.ajax({
												url: url,
												dataType: 'json',
												type: 'POST',
												data: {
														pms_employee_id : pms_employee_id,
													  },
												success: function(response) {
												if(response.msg)
												{
													html += '<div class="alert alert-success">';
													html += '<a class="close" data-dismiss="alert">&times;</a>';
													html += '<strong>Success!</strong> '+response.msg;
													html += '</div>';
													$('#reviewer_flashmsessage').html(html);
												}
												$('td#status_td_'+pms_employee_id).html('');
												$('td#status_td_'+pms_employee_id).html('Responded By Reviewer &nbsp;<a href="<?php echo base_url('reviewer/apraiseeassessment'); ?>/'+pms_employee_id+'"><i class="icon-eye-open"></i></a>');
												}	
											});
									
									
									
									/** End Apply for I Agree **
									
								}
								else {
									alert('Incorrect I Agree.\nI AGREE in BLOCK Letters only.');
								}								
								
							}
														
						});
						**/
												
					}
					else {						
						alert('Cancel Not Agree.');
						return false;
					}
					
                }
								
            });
			
	return false;
	//If reviewer agree continue
	if( reviewer_agree == 'Y' ) {
		//Continue
	}
	else {
		//alert('Cancel Not Agree');
		return false;
	}
	/**
	var url = '<?php // echo site_url("reviewer/addreviewerassessment"); ?>';
	var html = '';
	 $.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						pms_employee_id : pms_employee_id,
    		          },
				success: function(response) {
				if(response.msg)
				{
					html += '<div class="alert alert-success">';
                    html += '<a class="close" data-dismiss="alert">&times;</a>';
                    html += '<strong>Success!</strong> '+response.msg;
                    html += '</div>';
					$('#reviewer_flashmsessage').html(html);
				}
				$('td#status_td_'+pms_employee_id).html('');
				$('td#status_td_'+pms_employee_id).html('Responded By Reviewer &nbsp;<a href="<?php echo base_url('reviewer/apraiseeassessment'); ?>/'+pms_employee_id+'"><i class="icon-eye-open"></i></a>');
				}	
    		});
			**/
}
</script>
<!-- script for message box -->

<script src="<?php echo base_url("assets/clientadmin"); ?>/js/jquery.msgBox.js"></script>
<link href="<?php echo base_url("assets/clientadmin"); ?>/css/msgBoxLight.css" rel="stylesheet" >
<?php echo $last_footer; ?>