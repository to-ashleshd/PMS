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
<?php
$segment_1 = $this->uri->segment(1) ;
$segment_2 = $this->uri->segment(2) ;
$segment_3 = $this->uri->segment(3) ;
?>
            <div class="container-fluid" >
                <div class="row-fluid">
                    <div class="span12">
						<!-------------------------------- Start KRA Approvel List   ------------------------------------------------------------------------>			
									
									
									
<!-------------------------------- End KRA Approvel List   ------------------------------------------------------------------------>												
<!--<div id="chart_title" style="text-align:center"><h3>My Team PMS Status</h3></div>-->
						<?php 
						if(isset($employee))
						{
							if(!empty($employee))
							{
							if(count($employee)>1)
											{
						?>
						<div style="float:right; width:100%; margin-right:10px;">
										<div style="width:32px; height:32px; float:right; margin-top:-7px;  margin-left:10px;"><a href="<?php echo site_url("mypdf/pdfstatusreport/appraiser") . '/'.$segment_3; ?>" target="_blank" ><img src="<?php echo site_url('assets/user/images/default').'/pdficon.jpg'; ?>" height="32" width="32" title="PDF Report"  /></a></div>
										
										<div style="width:32px; height:32px; float:right; margin-top:-7px;"><a href="<?php echo site_url("mypdf/excelstatusreport/appraiser") . '/'.$segment_3; ?>" target="_blank" ><img src="<?php echo site_url('assets/user/images/default').'/excelicon.jpg'; ?>" height="32" width="32" title="Excel Report"  /></i></a></div>
							
								</div>
								<br  /><br />
								
						<div class="w-box w-box-orange">
                            <div class="w-box-header">
                                <h4 style="float:left;height:20px; margin-top:5px;">Me As Appraiser: </h4>
								
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
									
									
								
									if($val['submit_status']<=0)
									{
										$show_status = 'KRA not fill up.';
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
											 <td><?php echo get_pms_status($val['submit_status']); ?></td>
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
										 if(count($reviewer_employees)>1)
											{
										?>
											 <div style="float:right; width:100%; margin-right:10px;">
										<div style="width:32px; height:32px; float:right; margin-top:-7px;  margin-left:10px;"><a href="<?php echo site_url("mypdf/pdfstatusreport/reviewer") . '/'.$segment_3; ?>" target="_blank" ><img src="<?php echo site_url('assets/user/images/default').'/pdficon.jpg'; ?>" height="32" width="32" title="PDF Report"  /></a></div>
										
										<div style="width:32px; height:32px; float:right; margin-top:-7px;"><a href="<?php echo site_url("mypdf/excelstatusreport/reviewer") . '/'.$segment_3; ?>" target="_blank" ><img src="<?php echo site_url('assets/user/images/default').'/excelicon.jpg'; ?>" height="32" width="32" title="Excel Report"  /></i></a></div>
							
								</div>
								<br  /><br />
								<div class="w-box w-box-orange">
                            <div class="w-box-header">
                                <h4 style="float:left;height:20px; margin-top:5px;">Me As Reviewer:</h4>
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
										$show_status = 'KRA not fill up.';
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
                                               <?php echo get_pms_status($val['submit_status']); ?> <!--| <?php // echo $val['submit_status']; ?> -->
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

	/** Call Agree to Appraiser **/
	var reviewer_agree = 'N';
	$.msgBox({ type: "prompt",
                title: "Agree to Appraiser?",
				content: "Are you sure to confirm?",
                inputs: [
                { header: "KRA Score", type: "text", name: "userName", value:"4.1" },
                { header: "CM Score", type: "text", name: "password", value:"0.4" },
                { header: "Type I AGREE<br>(In Block Letters)", type: "text", name: "iagree", value: ""}],
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
						//alert('In I Agree');
						$(values).each(function (index, input) {
							//alert('Input: ' + input.name );
							
							if( input.name == 'iagree' ) {
							
								if( input.value == 'I AGREE' ) {
									reviewer_agree = 'Y' ;
								}
								else {
									alert('Incorrect I Agree.\nI AGREE in BLOCK Letters only.');
								}
							}
							
							
						});
					}
					else {						
						alert('Cancel Not Agree.');
						return false;
					}
					
                }
            });

	
	//If reviewer agree continue
	if( reviewer_agree == 'Y' ) {
		//Continue
	}
	else {
		//alert('Cancel Not Agree');
		return false;
	}
	

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
				}
				$('td#status_td_'+pms_employee_id).html('');
				$('td#status_td_'+pms_employee_id).html('Responded By Reviewer &nbsp;<a href="<?php echo base_url('reviewer/apraiseeassessment'); ?>/'+pms_employee_id+'"><i class="icon-eye-open"></i></a>');
				}	
    		});
}
</script>
<!-- script for message box -->

<script src="<?php echo base_url("assets/clientadmin"); ?>/js/jquery.msgBox.js"></script>
<link href="<?php echo base_url("assets/clientadmin"); ?>/css/msgBoxLight.css" rel="stylesheet" >
<?php echo $last_footer; ?>
<script type="text/javascript">