<?php
/**
* Project Code: PMS
* Version: PMS1
* Object: Template
* Template: Default / clientadmin
* Template Name: cadmin_apriser.php
* Desc: Display apraisee Details
* Last Update: 08-May-2013
* Author: Team Enrich
** Change Log **
* 
* 9-May-13 Update Top Appraisee Info
**/
?>
<?php @session_start(); ?>
<?php echo $header; ?>
<?php
$segment_1 = $this->uri->segment(1) ;
$segment_2 = $this->uri->segment(2) ;
$segment_3 = $this->uri->segment(3) ;
?>
<style>
.tabbable-bordered .nav-tabs > li.active {
	border-top: 5px solid #368CA9;
    margin-top: 0;
    position: relative;
	border-radius:5px;
}

.checkbox.inline { width:250px; margin-right:0px; }

.icon-plus {
    background-position: -408px -96px;
	 margin-left: 10px;
    margin-top: -4px;
}

.icon-minus {
    background-position: -433px -96px;
    margin-left: 10px; 
    margin-top: -4px;
}
</style>
 
<?php $tab = 'tb1_a'; ?>
            
        <!-- main content -->
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="w-box">
				<!-- New Table -->

				<table class="table invE_table table-bordered" style="background-color:#FFFFFF;" >
				<tbody>
					<tr>
						<td valign="top">Employee Name: </td>
						<td valign="top"><strong><?php echo $top_employee_detail['fname'].' '.$top_employee_detail['lname']; ?></strong></td>
						<td valign="top">Plant / Location: </td>
						<td valign="top"style="text-align:left;"><strong><?php echo $top_employee_detail['office_name']; ?></strong></td>
					</tr>
					<tr>
						<td valign="top">Designation: </td>
						<td valign="top"><strong><?php echo $top_employee_detail['designation_name']; ?></strong></td>
						<td valign="top">Employee Department:</td>
						<td valign="top" style="text-align:left;"><strong><?php echo $top_employee_detail['department_name']; ?></strong></td> 
					</tr>
					<tr>
					  <td valign="top" >Employee ID:</td>
					  <td valign="top"  ><strong><?php echo $top_employee_detail['employee_id']; ?></strong></td>
					  <td valign="top"  >Date of Last Promotion </td>
					   <?php
					  $display_last_prom_dt ='-';
					  if($top_employee_detail['last_pramotion_date']!='0000-00-00')
					  {
					  	$display_last_prom_dt =  date($s_date_format,strtotime($top_employee_detail['last_pramotion_date']));
					  }
					  
					  
					  ?>
					  <td valign="top" style="text-align:left;"><?php echo $display_last_prom_dt; ?></td>
				  </tr>
					<tr>
						<td valign="top" >Name &amp; Designation of Appraiser:</td>
						<td valign="top"  >
						<span style="word-wrap: break-word;">
					    <?php 
						if($top_employee_apraiser_detail['appraiser']) {echo $top_employee_apraiser_detail['appraiser']; ?>
					    <?php }  ?>
						</span>					    </td>
						
						<td valign="top"  ><span style="text-align:left;width:125px;">Last PMS Rating </span></td>
					  <td valign="top" style="text-align:left;"><span style="text-align:left;"><?php echo $last_score; ?></span></td>
					</tr>
					<tr>
					  <td valign="top" >Name &amp; Designation of Reviewer:</td>
					  <td valign="top"  ><span style="word-wrap: break-word;">
					    <?php if($top_employee_apraiser_detail['reviewer']) { echo $top_employee_apraiser_detail['reviewer']; ?>
                        <?php } ?>
					  </span></td>
					  <td valign="top"  >&nbsp;</td>
					  <td valign="top" >&nbsp;</td>
				  </tr>
				</tbody>
				</table>
				<!-- End New Table -->
				
				
                            <div class="w-box-header">
                                <h4>Appraisee &nbsp;[Emp. Name: <?php echo $employee_name; ?> ]</h4>
                            </div>
                            <div class="w-box-content cnt_b">
                                <div class="row-fluid">
                                    <div class="span12">

										
									
									
                                        <div class="tabbable tabbable-bordered">
                                            <ul class="nav nav-tabs">
                                                <li id="taba" class="<?php echo ($tab == 'tb1_a'? 'active' : '') ?>"><a data-toggle="tab" href="#tb1_a">KRA</a></li>
                                                <li id="tabb" class="<?php echo ($tab == 'tb1_b'? 'active' : '') ?>"><a data-toggle="tab" href="#tb1_b">Competencies with IDP</a></li>
                                                <li id="tabc"  class="<?php echo ($tab == 'tb1_c'? 'active' : '') ?>"><a data-toggle="tab" href="#tb1_c">Overall Rating</a></li>
                                            </ul>
                                            <div class="tab-content">
											<!-- tab a --->
                                            <div id="tb1_a" class="tab-pane <?php echo ($tab == 'tb1_a'? 'active' : '') ?>">
                                                
          <div class="row-fluid">
            <div class="span12">
			<?php
				  if(!isset($errormsg))
				  {
				   if(!isset($error))
				  {
				  ?>
				  <div class="alert alert-info">
                                    <a class="close" data-dismiss="alert">&times;</a>
                                    <strong>Section A: KRA ASSESSMENT  - &nbsp;</strong> <br />
									Breifly describe performance/achevements during the assessment periods. It is important for the appraisar to enter his/her comments to substaintiate the ratings.
                  </div>
				  <?php } } ?>
				  <div id="flashmessages" >
				  <?php
				  if(isset($errormsg))
				  {
				  ?>
				  <div class="alert alert-error"><b>Alert! &nbsp;</b>
				  <?php echo $errormsg; ?>
				  </div>
				  <?php
				  }
				  ?>
				</div>
				
              <div class="tabbable tabbable-bordered">
                    <div class="w-box w-box-green" id="invoice_add_edit">
					<?php
				  if(!isset($errormsg))
				  {
				   if(!isset($error))
				  {
				  ?>
                 <form action="" method="post" id="apraiser_kra" style="margin-left:-23px; width:100%;" >
				 <input type="hidden" name="appraisee_employee_id" id="appraisee_employee_id" value="<?php echo $apraisee_employee_id; ?>"  />
                    <div class="span12">
					
			   			 <table class="table invE_table table-bordered" id="tbl_apraiser_kra">
						<thead>
							<tr>
							  <th rowspan="2" valign="top" style="border-top:none; text-align: center;">Sr. No. </th>
							  <th rowspan="2" valign="top" style="border-top:none; text-align: center;">Key Result Area </th>
							  <th rowspan="2" valign="top" style="border-top:none; text-align: center;">Performance Target</th>
							  <th rowspan="2" valign="top" style="border-top:none; text-align: center;">Performance Measure</th>
							  <th rowspan="2" valign="top" style="border-top:none; text-align: center;">Weightage %</th>
							  <th height="26" colspan="2" valign="top" style="border-top:none; text-align: center; width:20%">Self</th>
							  <th colspan="2" valign="top" style="border-top:0px; text-align: center;">Manager</th>
							  <th colspan="2" valign="top" style="border-top:0px; text-align:center; width:5%;">Final Ratings</th>
							  </tr>
							<tr>
								<th valign="top" style="border-top:; text-align: center; width:1%;">Rating</th>
								<th valign="top" style="text-align:center;border-top:; text-align: center;">Comments</th>
								<th valign="top" style="border-top:; text-align: left;">Rating</th>
								<th valign="top" style="text-align:center;border-top:; text-align: center;">Comments</th>
								<th valign="top" style="border-top:; text-align: center;font-size:12px;">
								<span data-placement="left" data-title="Final Rating" data-content="(Weightage * Manager Rating) / 100" class="btn btn-mini pop-over" data-original-title="">&Sigma;</span>
								</th>
							</tr>
						</thead>
						<tbody id="kra_detail">
						<?php
						$appraiser_weightage = 0 ;
						if(isset($kra_detail))
						{
							if(!empty($kra_detail))
							{
								$i=0;
								foreach($kra_detail as $key=>$val)
								{
									$j= $i+1;
									if(($j%2)==0)
									{
										$bgcolor ='background:#ffffff;';
									}
									else
									{
										$bgcolor ='background:#F6F6F6;';
									}
						?>
							
							<tr class="inv_row" style="<?php echo $bgcolor; ?>">
								<td><?php echo $j; ?></td>
								<td ><?php echo $val['key_result_area']; ?></td>
								<td><?php echo $val['performance_target']; ?></td>
								<td><?php echo $val['performance_measure']; ?></td>
								<td  style="text-align:center;"><?php echo $val['weightage_name']; ?> %</td>
								<td style="text-align:center;"><?php echo $val['rating_value']; ?></td>
								<td><?php echo $val['comment']; ?></td>
								<td style="text-align:center;">
								<!-- On Blur - change to onchange onblur=" -->
								<input class="cls_weightage_kra" type="hidden" name="weightage_kra_<?php echo $val['apraisee_pms_id']; ?>" id="weightage_kra_<?php echo $val['apraisee_pms_id']; ?>" value="<?php echo $val['weightage_name']; ?>"  />
									<select  class="cls_kra_rating span12" name="rating_<?php echo $val['apraisee_pms_id']; ?>" id="rating_kra_<?php echo $val['apraisee_pms_id']; ?>" onchange="calculate_total_score_per_row_for_kra('<?php echo $val['apraisee_pms_id']; ?>')"  >
									<option  value="">Select</option>
									<?php
									$r=1;
									foreach($all_ratings as $key1=>$val1)
									{
									?>
										<option value="<?php echo $val1['rating_value']; ?>"><?php echo $r.'. '.$val1['rating_name']; ?></option>
									<?php 
									$r++;
									} 
									
									?>
									</select>								</td>
								<td><textarea  name="comments_<?php echo $val['apraisee_pms_id']; ?>" id="comments_kra<?php echo $val['apraisee_pms_id']; ?>"></textarea></td>
								<td width="5%" style="text-align:center"> <span id="total_kra_score_<?php echo $val['apraisee_pms_id']; ?>"> </span></td>
							</tr>
						<?php
						$i++;
						$appraiser_weightage = $appraiser_weightage + $val['weightage_name'] ;
						} 
						}
						}
						?>
						
						<?php
						if(isset($apraiser_kra_detail))
						{
							if(!empty($apraiser_kra_detail))
							{
								$i=0;
								$j=0;
								foreach($apraiser_kra_detail as $key=>$val)
								{
									$j= $j+1;
									if(($j%2)==0)
									{
										$bgcolor ='background:#ffffff;';
									}
									else
									{
										$bgcolor ='background:#F6F6F6;';
									}
									?>
									<tr class="inv_row" style="<?php echo $bgcolor; ?>">
										<td><?php echo $j; ?></td>
										<td ><?php echo $val['key_result_area']; ?></td>
										<td><?php echo $val['performance_target']; ?></td>
										<td><?php echo $val['performance_measure']; ?></td>
										<td  style="text-align:center;"><?php echo $val['weightage_name']; ?> %</td>
										<td style="text-align:center;"><?php echo $val['self_rating_value']; ?></td>
										<td><?php echo $val['comment']; ?></td>
										<td style="text-align:center;"><?php echo $val['apraiser_rating_value']; ?></td>
										<td><?php echo $val['apraiser_comment']; ?></td>
										<td width="5%" style="text-align:center;"><?php echo number_format($val['total_score'], 2, '.', ''); ?></td>
									</tr>
									<?php
									$appraiser_weightage = $appraiser_weightage + $val['weightage_name'] ;
								}
							}
						}
						?>
						</tbody>
						<tfoot>
						<tr>
						<td colspan="4" style="text-align:right;font-weight:bold;">Weightage Total</td>
						<td style="text-align:center; font-weight:bold;"><?php echo $appraiser_weightage; ?>%</td>
						<td colspan="4" style="text-align:right;font-weight:bold;"><b>Final Rating Total</b></td>
						<td style="font-weight:bold; text-align:center;"><span id="final_kra_score" ><?php if(!empty($final_score)) { echo number_format($final_score, 2, '.', ''); } ?></span></td>
						</tr>
						</tfoot>	
						</table>
                        
                  
						<?php if(isset($kra_detail) and count($kra_detail) >= 1) : ?>
							<div class="formSep" id="kra_buttons" style="display:;">
							<div align="center">							
							<input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
							<input type="submit" name="submit" value="Next" id="submit" class="btn btn-beoro-3">
						  	</div>
						  </div>
						  <?php endif; ?>
					   </div>  </form>
					    
					   <div class="row-fluid" ></div>
					   
					   <div class="row-fluid" >
					   
					    <div class="span12">
			   			 
                  <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="3" style="text-align:center;">Rating On KRA</th>
                                                        </tr>
														<tr>
                                                            <th  style="text-align:center;">Rating</th>
															<th  style="text-align:center; width:20%;">Definition</th>
															<th  style="text-align:center;">Explanation</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
													<?php
													
									$r=1;
									foreach($ratings_for_refrence as $keyrt=>$valrt)
									{
									?>
										 <tr>
												<td  style="text-align:center;"><?php echo $valrt['rating_value']; ?></td>
												<td  style="text-align:justify;"><?php echo $valrt['rating_name'].' '.$valrt['rating_defination']; ?></td>
												<td  style="text-align:justify;">
												<?php echo $valrt['rating_description']; ?>
												</td>
                                         </tr>
									<?php 
									$r++;
									} 
													?>
                                                       
													
                                                    </tbody>
                         </table>
						 
					    </div>
						</div>
					   
					     <?php }
						 else
						 {
						 	?> <div class="row-fluid" ><br /><br /><center><font size="+3" >NO Data.</font></center></div><?php
						 }
						 
						  }
						   ?>
					  </div>
          </div>
        </div>
        </div>
    	
    
                                                </div>
											<!--- tab a closed ---->
											
											<!--- tab b start--->
                                                <div id="tb1_b" class="tab-pane <?php echo ($tab == 'tb1_b'? 'active' : '') ?>">
												<form action="" method="post" id="competency_idp_form">
												<input type="hidden" name="appraisee_employee_id" id="appraisee_employee_id" value="<?php echo $apraisee_employee_id; ?>"  />
           
		  <div class="row-fluid" >
		
            <div class="span12">
			<?php
				  if(!isset($errormsg))
				  {
				   if(!isset($error))
				  {
				  if(isset($apraiser_kra_detail))
						{
						?>
				  <div class="alert alert-info">
                                    <a class="close" data-dismiss="alert">&times;</a>
                                    <strong>SECTION B: COMPETENCIES ASSESSMENT & IDP - &nbsp;</strong> 
									 Kindly rate the appraisee on each of the competencies stated    
		
                  </div>
				  <?php }}} ?>
				  <div id="flashmessages_competency">
				  <?php
				  if(isset($errormsg))
				  {
				  ?>
				  <div class="alert alert-error"><b>Alert! &nbsp;</b>
				  <?php echo $errormsg; ?>				  </div>
				  <?php
				  }
				  ?>
				   <?php if(!isset($apraiser_kra_detail))
						{
						?>
						<div class="alert alert-error"><b>Alert! &nbsp;</b>Please Fill Up KRA First.</div>
						<?php } ?>
				  </div>
				  
				 
              <div class="tabbable tabbable-bordered">
			    <?php if(!isset($apraiser_kra_detail))
						{
							$style_css = 'display:none;';
						}else{ 
							$style_css = 'display:block;';
						}
						?>
                    <div class="w-box w-box-green" id="content_tab_b" style="<?php echo $style_css; ?>">
					
				
               <?php
				  if(!isset($errormsg))
				  {
				   if(!isset($error))
				  {
				  ?>
                    <div class="span12">
					<table class="table invE_table table-bordered" >
					<!--<tr>
					<td colspan="7" align="left" style="text-align:left;">Employee Name : <?php //echo $employee_name; ?></td>
					
					</tr>-->
					<!--<tr>
					<td colspan="7" align="left" style="text-align:left;">&nbsp;</td>
					
					</tr>-->
					<thead>
					<tr>
					<td colspan="7" align="left" style="text-align:left; background-color:#EFF7EC; font-weight:bold;">Filled By Appraisee</td>
					
					</tr>
					
					<tr>
				
					<td colspan="7" align="left" style="text-align:left;">
					<b>Development areas :</b>what are the areas you feel you need to develop in this year to enhance your performance
					</td>
					</tr>
					</thead>
					<tbody >
					<tr>
					<td colspan="7" align="left" style="text-align:left;">
						<?php
											if(isset($idp_detail))
											{
												if(!empty($idp_detail))
												{
												$i =1;											
													foreach($idp_detail as $key=>$val)
													{
														?>
														 &nbsp; <?php echo '<b>'.$i.'</b> '.$val['development_area']; ?> <br />
														<?php
													$i++;
													}
												}
											}
						?>
					</td>
					</tr>
					</tbody>
					</table>
					<br />
					
					<table class="table invE_table table-bordered" >
					<tbody>
					<tr>
					<td colspan="7" align="left" style="text-align:left; background-color:#EFF7EC;font-weight:bold;">To be Filled By Appraiser</td>
					
					</tr>
					<tr>
					<td colspan="7" align="left" style="text-align:left;">
						Kindly rate the appraisee on the below mentioned competencies <br />
						(Performance Rating Scale is 1 to 5 where 1 is least & 5 is highest)
					</td>
					</tr>
					<tr>
					<td colspan="8">
					<table class="table  table-bordered" id="tbl_competencies" >
					<thead>
					<tr>
						<th><b>Competencies</b></th>
						<th><b>Weightage %</b></th>
						<th><b>Rating</b></th>
						<th><b>Total Score</b></th>
					</tr>
					</thead>
					<tbody id="cwidp_info">
					<?php
						$total_weightage_value = 0;
						
						if(isset($competency_with_idp_detail) )
						{
							if(!empty($competency_with_idp_detail))
							{
								foreach($competency_with_idp_detail as $keycwi=>$valcwi)
								{
									?>
									<tr>
									<td><?php echo $valcwi['competencies_name']; ?> </td>
									<td><?php echo $valcwi['weightage_value'].'%'; ?></td>
									<td><?php echo $valcwi['scale']; ?></td>
									<td><?php echo number_format($valcwi['total_score'], 2, '.', ''); ?></td>
									</tr>
									<?php	
									$total_weightage_value = $total_weightage_value + $valcwi['weightage_value'] ;
								}
							}
						
						}
						elseif(isset($competencies_for_refrence))
						{
							if(!empty($competencies_for_refrence))
							{
								foreach($competencies_for_refrence as $keyc=>$valc)
								{
									?>
									<tr>
									<td><?php echo $valc['competencies_name']; ?></td>
									<td><?php echo $valc['weightage_value'].'%'; ?></td>
									<td>
									<!-- change onblur with onchange -->
										<input  type="hidden" name="weightage_<?php echo $valc['competencies_for_refrence_id']; ?>" id="weightage_<?php echo $valc['competencies_for_refrence_id']; ?>" value="<?php echo $valc['weightage_id']; ?>"  />
										<input class="cls_weightage" type="hidden" name="weightage_val<?php echo $valc['competencies_for_refrence_id']; ?>" id="weightage_val<?php echo $valc['competencies_for_refrence_id']; ?>" value="<?php echo $valc['weightage_value']; ?>"  />
										<select class="cls_rate span12" name="rate_<?php echo $valc['competencies_for_refrence_id']; ?>" id="rate_<?php echo $valc['competencies_for_refrence_id']; ?>" onchange="calculate_total_score_per_row(<?php echo $valc['competencies_for_refrence_id']; ?>)" >
											<option value="">Please Select</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</td>
									<td><span class="cls_total_score" id="total_score_<?php echo $valc['competencies_for_refrence_id']; ?>" ></span></td>
									</tr>
									<?php
									$total_weightage_value = $total_weightage_value + $valc['weightage_value'];
								}
								?>
								<?php
							}
						}
					?>
					<tr>
									<td style="text-align:right;"><b>Total</b></td>
									<td><?php echo $total_weightage_value; ?> %</td>
									<td>&nbsp;</td>
									<td><span id="final_score"><?php if(!empty($final_score_cwi)) { echo number_format($final_score_cwi, 2, '.', ''); } ?></span></td>
				   </tr>
				   </tbody>
					</table>
					</td>
					</tr>
					<tr>
					<td colspan="8" style="text-align:left;" valign="middle">Training is required for competencies where employee is rated less than and equal to 3.</td>
					</tr>
					</tbody>
					</table>
					<br />
					<table class="table invE_table table-bordered" >
					<tbody>
					<tr>
					<td colspan="7" align="left" style="text-align:left; background-color:#EFF7EC; font-weight:bold;">To be filled by Appraiser in discussion with Appraisee</td>
					</tr>
					<tr>
					<td colspan="7" align="left" style="text-align:left;">Kindly list down the skill gaps/competencies where an Appraisee needs to improve upon:</td>
					</tr>
					<tr>
					<td colspan="3" >
					<table class="table invE_table table-bordered" >
					<thead>
						<tr id="tr_technical">
								<td colspan="7"  style="text-align:center;"><b>Technical</b></td>
							</tr>
					</thead>
					<tbody id="appraiser_technical">
						<?php
						if(isset($technical_detail) )
						{
							if(!empty($technical_detail))
							{
								foreach($technical_detail as $keytd =>$valtd)
								{
									$ta =1;
									?>
									 <tr >
										<td colspan="7" style="text-align:left; border-right:none; border-top:none;border-bottom:none;">
										<?php echo $ta.') '.$valtd['technical_area']; ?>
										</td>
                                      </tr>
									<?php	
									$ta++;
								}
							}
						
						}else{						
							?>					  <tr class="idp_row" id="ta">
                                                    <td colspan="7" style="text-align:left; border-right:none; border-top:none;border-bottom:none;">
													<span class="idp_clone_row_no">1</span>&nbsp;
													<input type="text" class="span10" name="idpE_item[]" />&nbsp;&nbsp;
													<span class="idp_clone_row"><i class="icon-plus idp_clone_btn" ></i></span>
													</td>
                                                </tr>
									
												
												
												
												<tr colspan="7" class="idp_last_row">
												</tr>
                                              
						<?php } ?>			
													
												</tbody>
												</table>
												</td>
												<td colspan="4" >
												<table class="table invE_table table-bordered" >
												<thead>
												 <tr id="tr_behavioural">
                                                  <td colspan="7" style="text-align:center;"><b>Behavioural</b></td>
                                                </tr>
												</thead>
												<tbody id="appraiser_behavioural">
												
												<?php
						if(isset($behavioural_detail) )
						{
							if(!empty($behavioural_detail))
							{
								foreach($behavioural_detail as $keytd => $valtd)
								{
									$ba=1;
									?>
									 <tr>
										<td colspan="7" style="text-align:left; border-right:none; border-top:none;border-bottom:none;">
										<?php echo $ba.') '.$valtd['behavioural_area']; ?>
										</td>
                                                </tr>
									<?php	
									$ba++;
								}
							}
						
						}else{						
							?>			
												
												  <tr class="idpa_row" id="ia">
                                                    <td colspan="7" style="text-align:left; border-right:none; border-top:none;border-bottom:none;">
													<span class="idpa_clone_row_no">1</span>&nbsp;
													<input type="text" class="span10" name="invE_item[]" />&nbsp;&nbsp;
													<span class="idpa_clone_row"><i class="icon-plus idpa_clone_btn " ></i></span>
													</td>
                                                </tr>
							
												<tr colspan="7" class="idpa_last_row">
												</tr>
					<?php } ?>
					</tbody>
					</table>
					</td>
					</tr>
			
					</tbody>
					</table>
			   			 
                       <?php if(!isset($competency_with_idp_detail)) 
					   {
					   ?>
		
						<div class="formSep" id="cwi_buttons">
            			<div align="center">                        
                        <input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
						<input type="submit" name="submit" value="Next" id="submit" class="btn btn-beoro-3">
                      </div>
					  </div>
					  <?php
					  }
					  ?>
					  
					  					   <div class="row-fluid" ></div>
					  
					   </div>
					 
					  <?php }
						 else
						 {
						 	?> <div class="row-fluid" ><br /><br /><center><font size="+3" >NO Data.</font></center></div><?php
						 }
						 
						  }
						   ?>
					 
					 
					  </div>
          </div>
        </div>
        </div>
    	
      </form>
                                                </div>
										  <!-- tab b closed ---->
										  
										  <!-- tab c start ------->
                                                <div id="tb1_c" class="tab-pane <?php echo ($tab == 'tb1_c'? 'active' : '') ?>">
<form action="" method="post" id="form_overall_rating" onsubmit="return validation_overall_rating()">
<input type="hidden" name="appraisee_employee_id" id="appraisee_employee_id" value="<?php echo $apraisee_employee_id; ?>"  />
          <div class="row-fluid">
            <div class="span12">
			<?php
			
				  if(!isset($errormsg))
				  {
				   if(!isset($error))
				  {
				  if(isset($competency_with_idp_detail) && isset($apraiser_kra_detail))
				  {
				  //echo $is_pms_process_complete;
				 // echo "<br>";
				  	if($is_first_appraiser=='Y' && $is_pms_process_complete=='Y')
						{
				  ?>
				  <div class="alert alert-info">
                                    <a class="close" data-dismiss="alert">&times;</a>
                                    <strong>Section C: Overall Rating - &nbsp;</strong> Performance on Key Result Areas has a weightage of 70% in the overall rating and competencies 30%. Refer to the materix below.
		
                  </div>
				  <?php
					}
				  }
				  }
				  }
				  ?>
				  <div id="flashmessageoverallrating">
				  <?php
				  if($is_pms_process_complete!='Y' && $is_first_appraiser!='Y')
						{
						?>
							<div class="alert alert-info">
							<a class="close" data-dismiss="alert">&times;</a>
							<strong>Please wait for overall Rating , pms process not Completed. </strong>
							</div>
							<?php
						}
				  ?>
				  <?php
					if(isset($is_first_appraiser))
					{
						if($is_first_appraiser=='Y' && $is_pms_process_complete!='Y')
						{
							?>
							<div class="alert alert-info">
							<a class="close" data-dismiss="alert">&times;</a>
							<strong>Please wait for other Appraiser to submit his/her Rating. </strong>
							</div>
							<?php
						}
						else if($is_first_appraiser!='Y' &&  $is_pms_process_finish!='Y')
						{
							?>
							<div class="alert alert-info">
							<a class="close" data-dismiss="alert">&times;</a>
							<strong>Please Wait. Other Appraiser not completed the PMS process. </strong>
							</div>
							<?php
						}
					}
					
					?>
				  
				   <?php
				  if(isset($errormsg))
				  {
				  ?>
				  <div class="alert alert-error"><b>Alert! &nbsp;</b>
				  <?php echo $errormsg; ?>
				  </div>
				  <?php
				  }
				  ?>
				  <?php 
				  
				  if(!isset($competency_with_idp_detail) && !isset($apraiser_kra_detail))
				  {
				  	?>  <div class="alert alert-error"><b>Alert! &nbsp;</b>Please Fill Up KRA and Competencies with IDP Form First</div><?php
				  }
				  elseif(!isset($apraiser_kra_detail))
				  {
				  		?>  <div class="alert alert-error"><b>Alert! &nbsp;</b>Please Fill Up KRA Form First</div><?php
				  }
				  elseif(!isset($competency_with_idp_detail))
				  {
				  	?>  <div class="alert alert-error"><b>Alert! &nbsp;</b>Please Fill Up Competencies with IDP Form First</div><?php
				  }
				  ?>
				  </div>
				  
              <div class="tabbable tabbable-bordered">
			  <?php
			  if(isset($competency_with_idp_detail) && isset($apraiser_kra_detail))
				  {
				  	$style_cwi = 'display:block;';
				  }
				  else
				  {
				  	$style_cwi = 'display:none;';
				  }
			  ?>
                    <div class="w-box w-box-green" id="content_tab_c" style="<?php echo $style_cwi; ?>">
				
					 <?php
					 //echo $is_pms_process_finish;
				  if(!isset($errormsg))
				  {
				   if(!isset($error))
				   {
				   		$disply_div = '';
						//echo $is_first_appraiser;echo "<br>";
						//echo $is_pms_process_complete;
						if($is_first_appraiser!='Y' &&  $is_pms_process_finish!='Y')
						{
							$disply_div = 'none';
						}
						else if($is_first_appraiser=='Y' && $is_pms_process_complete!='Y')
							{
								$disply_div = 'none';
							}
						
				  ?> 
				  
				  <div id="div_top_overall_data" style="display:<?=$disply_div?>;">
               <div class="row-fluid" >
			   	
                    <div class="span5">
			   			 
                  <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center;">Title</th>
                                                            <th style="text-align: center;">Weightage</th>
                                                            <th style="text-align: center;">Weighted Score </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td >Overall KRA Score</td>
                                                            <td style="text-align: center;">70%</td>
                                                            <!-- <td style="text-align: center; font-size:12px;"><span id="overall_kra_score"><?php // if(!empty($overall_kra_score)) { echo number_format($overall_kra_score, 2, '.', ''); } ?></span> <span data-placement="top" data-title="Weighted Score" data-content="((Total Final Rating Of KRA) *(70)) / 100" class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span><br />Overall KRA: <?php // echo $overall_rating_scores['overall_kra_score']; ?></td> -->
															<td style="text-align: center; font-size:12px;"><span id="overall_kra_score" style="font-weight:bold;"><?php if(!empty($overall_rating_scores['overall_kra_score'])) { echo number_format($overall_rating_scores['overall_kra_score'], 2, '.', ''); } ?></span> <span data-placement="top" data-title="Weighted Score" data-content="((Total Final Rating Of KRA) * (70)) / 100" class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Overall competencies Score</td>
                                                            <td style="text-align: center;">30%</td>
                                                            <!-- <td style="text-align: center; font-size:12px;"><span id="overall_competencies_score"><?php // if(!empty($overall_competencies_score)) { echo number_format($overall_competencies_score, 2, '.', ''); } ?></span> <span data-placement="bottom" data-title="Weighted Score" data-content="((Total Final Rating Of Competencies) *(30)) / 100" class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span><br />Overall Comp: <?php // echo $overall_rating_scores['overall_competency_score']; ?></td> -->
															<td style="text-align: center; font-size:12px;"><span id="overall_competencies_score" style="font-weight:bold;"><?php if(!empty($overall_rating_scores['overall_competency_score'])) { echo number_format($overall_rating_scores['overall_competency_score'], 2, '.', ''); } ?></span> <span data-placement="bottom" data-title="Weighted Score" data-content="((Total Final Rating Of Competencies) *(30)) / 100" class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">Overall Performance Score</td>
                                                            <!-- <td style="text-align: center; font-size:12px;"><span id="overall_performance_score"><?php // if(!empty($overall_performance_score)) { echo number_format($overall_performance_score, 2, '.', ''); }?><br />Overall Total: <?php // echo $overall_rating_scores['overall_total']; ?></span> -->
															<td style="text-align: center; font-size:12px;"><span id="overall_performance_score" style="font-weight:bold;"><?php if(!empty($overall_rating_scores['overall_total'])) { echo number_format($overall_rating_scores['overall_total'], 2, '.', ''); }?></span>
															
															<input type="hidden" name="hidden_over_perf_score"  id="hidden_over_perf_score" value="<?php echo $overall_rating_scores['overall_total']; ?>"  />
															</td>
                                                        </tr>
                                                      
                                                    </tbody>
                         </table>
						 <br />
						   <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" style="text-align:center;">Overall Assessment Score</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Appraiser</td>
                                                           <!-- <td>Reviewer</td>-->
														   <td>Reviewer</td>
                                                        </tr>
                                                        <tr>
                                                            <!-- <td ><span id="apraiser_assessment_score"><?php // echo $apraiser_assessment_score .' '. $overall_apraiser_assessment_score; ?></span></td> -->
															<td ><span id="apraiser_assessment_score"><?php echo $overall_apraiser_assessment_score; ?></span></td>
                                                            <!--<td>FEE</td>-->
															<td><?=$reviewer_overall_score_name;?></td>
                                                        </tr>
                                                    </tbody>
                         </table>
						 </div>
						 <div class="span4">
						 		 
                  <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center;">Score Range</th>
                                                            <th style="text-align: center;">Ratings</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>4.25 to 5.00</td>
                                                            <td>FEE: Far Exceeds Expectations</td>
                                                        </tr>
                                                          <tr>
                                                            <td>3.50 to 4.24</td>
                                                            <td>EE:  Exceeds Expectations</td>
                                                        </tr>
														  <tr>
                                                            <td>2.80 to 3.49</td>
                                                            <td>ME: Meets Expectations</td>
                                                        </tr>
														  <tr>
                                                            <td>2.00 to 2.79</td>
                                                            <td>NI: Needs Improvement</td>
                                                        </tr>
														  <tr>
                                                            <td>Below 2.00</td>
                                                            <td>BE: Below Expectations</td>
                                                        </tr>
                                                      
                                                    </tbody>
                         </table>
						 
		
					
					   </div>
					</div>
					</div>
				
					<div id="div_oveall_data" style="display:;" >
					
					<?php
				
					if(isset($display_overall_rating))
					{
						if($display_overall_rating=='Y')
						{
							
						?>
						
					<br />
					<?php if($overall_apraiser_assessment_score=='BE' or $overall_apraiser_assessment_score=='FEE')
							{
							?>
						<div class="row-fluid" >
					   
					    <div class="span12">
			   			 
                  <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:justify;">Where the Appraisee has been rated FEE or BE kindly your comments to justify the rating with specific examples to substantiate the rating (Max 50 words) </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
													<tr id="tr_comment">
													<?php 
													
														if(isset($overall_rating_detail))
														{
															if(!empty($overall_rating_detail))
															{
																foreach($overall_rating_detail as $keyor=>$valor)
																{
													?>
                                                       	 
                                                            <td><?php if(trim($valor['comment'])=='')
															{
															echo "N.A.";
															}
															else
															{
																echo $valor['comment']; 
														    }
															?></td>
													   
													<?php
																}
															}
														}
														else 
														{
															
													?>
                                                            <td>
															<textarea class="span12" name="overall_rating_comment" id="overall_rating_comment" ></textarea>
															</td>
                                                      
													<?php
													}
													
													?>
													  </tr>
                                                    </tbody>
                         </table>
					    </div>
						</div>
						<?php } ?>
							<div class="row-fluid" >
						<div class="span12">
			   			 
                  <table class="table table-bordered" >
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:justify;">Feedback given by Appraiser</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr id="tr_feedback">
														<?php 
														if(isset($overall_rating_detail))
														{
															if(!empty($overall_rating_detail))
															{
																foreach($overall_rating_detail as $keyor=>$valor)
																{
													?>
                                                       	 
                                                            <td><?php if(trim($valor['feedback'])==''){
																echo "N.A.";
															}
															else
															{
																echo $valor['feedback'];
														    }
															 ?></td>
													   
													<?php
																}
															}
														}
														else
														{
													?>
                                                            <td><textarea class="span12" name="apraiser_feedback" id="appraiser_feedback" ></textarea></td>
                                                        <?php } ?>
														
														</tr>
														 <!--<tr>
                                                            <td><textarea class="span12" name="feedback_appraiser_2" id="feedback_appraiser_2" > </textarea></td>
                                                        </tr>-->
                                                    </tbody>
                         </table>
					    </div>
						
						</div>
						
						
						<div class="row-fluid" >
						<div class="span12">
			   			 
                  <table class="table table-bordered" >
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:justify;"><b>Promotion Recommendation : </b>What additional reponsibilities are proposed to an individual after promotion.</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
													<tr id="tr_promotion">
													<?php 
														if(isset($overall_rating_detail))
														{
															if(!empty($overall_rating_detail))
															{
																foreach($overall_rating_detail as $keyor=>$valor)
																{
													?>
                                                        <td><?php if(trim($valor['promotion_recommendation'])=='')
														{
															echo "N.A.";
														}
														else
														{
															 echo $valor['promotion_recommendation']; 
														}
														?></td>
													<?php
																}
															}
														}
														else
														{
													?>
														<td>
														<textarea class="span12" name="appraiser_promotion_recommendation" id="appraiser_promotion_recommendation" ></textarea>
														</td>
														<?php
														} 
														?>
													</tr>

                                                    </tbody>
                         </table>
					    </div>
						
						</div>
						
						<div class="row-fluid" >
						<div class="span1"></div>
						<div class="span2">
			   			 
                  <table class="table table-bordered" >
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:justify;">Appraiser Signature</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
														<tr>
                                                            <td><b>Date: </b>
															<?php 
														if(isset($overall_rating_detail))
														{
															if(!empty($overall_rating_detail))
															{
																foreach($overall_rating_detail as $keyor=>$valor)
																{
																
																echo date($s_date_format,strtotime($valor['date_created']));
																}
															}
														}else{
													?>
															<?php echo date($s_date_format); 
															}
															?>
															</td>
                                                        </tr>

                                                    </tbody>
                         </table>
					    </div>
						<div class="span6">
						&nbsp;
						</div>
						<div class="span2">
			   			 
                  <table class="table table-bordered" >
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:justify;">Reviewer Signature</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
														<tr>
                                                            <td><b>Date: </b><?php //echo date($s_date_format); ?></td>
                                                        </tr>

                                                    </tbody>
                         </table>
					    </div>
						<div class="span1"></div>
						</div>
						<?php 
							if(!isset($overall_rating_detail))
							{
								
								?>
						 <div class="formSep" id="overall_rating_buttons">
            			<div align="center">
                        <input type="submit" name="submit" value="Submit" id="submit" class="btn btn-beoro-3" >
                        <input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
                      </div>
					  </div>
					  <?php } ?>
					  <?php
						}
						}
						?>
					  <?php }
						 else
						 {
						 	?> <div class="row-fluid" ><br /><br /><center><font size="+3" >NO Data.</font></center></div><?php
						 }
						 
						  }
						   ?>
						
						
			</div>
          </div>
       
		
		</div>
        </div>
    	</div>
      </form>                                                </div>
										<!--- tab c closed ---->
										
										
									
								

								  
								  
                                            </div>
                                        </div>
                                    </div>
                                  
                                </div>
                            
                            </div>
                        </div>
                   
                    </div>
                </div>
            </div> 

<?php echo $middle_footer; ?>
<?php echo $common_js; ?>
<script type="text/javascript" >
hide_message('flashmessages');
hide_message('flashmessages_competency');
hide_message('flashmessageoverallrating');
$(document).ready(function() {

     $("#apraiser_kra").submit(function() {
     var frm = $('#apraiser_kra');
	 /* Apply Validateion to check **/
	 var flag=0;
	 $('#apraiser_kra tr').each(function() {
	 	var rate = $(this).find(".cls_kra_rating").val();
		//alert(rate);
	 	//if(rate=='' || rate==undefined || isNaN(rate))
		//Modified By Ajay
		if(rate=='' )
		{
			flag=1;
		}
	  });
	  
	  if(flag==1)
	  {
	  	alert("Please Select Rating For Each KRA");
		return false;
	  }
	 
	 /** End Validateion  **/
	 
	 
	 
	 
	 var t = confirm("Are you sure, you would like to submit KRA Assessment?");
	 
	if(t==true)
	 {
	 	calculate_total();
        $.ajax({
            type: frm.attr('method'),
            url: '<?php echo base_url('apraiser/addkradata'); ?>',
            data: frm.serialize(),
            success: function (data) {
				
				 var html ='';
				$('#reset').click();
				
				if(data=='Please try again'){
				html += '<div class="alert alert-error">';
                html += '<a class="close" data-dismiss="alert">&times;</a>';
                html += '<strong>Error!&nbsp;</strong>'+data;
                html += '</div>';
				}
				else
				{
					html += '<div class="alert alert-success">';
                    html += '<a class="close" data-dismiss="alert">&times;</a>';
                    html += '<strong>Success!</strong> '+data;
                    html += '</div>';
				}
				$('#flashmessages').after(html);
				$('#flashmessages_competency').html('');
				$('#flashmessageoverallrating').html('');
				$('#flashmessageoverallrating').html('<div class="alert alert-error"><strong>Alert!</strong>Please Fill Up Competencies With IDP First. </div>');
				hide_message('flashmessages');
				$("html, body").animate({ scrollTop: 0 }, "slow");
			
				               // alert('ok'); 
				//display pms
		var url = '<?php echo site_url("apraiser/getApraiserKradetail"); ?>';
		
		var html = '';
 		 $.ajax({
		 			
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							pms_employee_id 	 : <?php echo $this->session->userdata('pms_employee_id') ?>,
							apraisee_employee_id : $('#appraisee_employee_id').val()
						  },
							success: function(response) {
								var overall_kra_score	= ( (parseFloat(response.final_score) * 70 ) /100);
								if(response.kra_detail.length > 0 )
								{
									for(var i=0; i<response.kra_detail.length; i++)
									{
										var j= parseInt(i) + 1;
										var total_score = 0;
										var bgcolor ='';
										if((parseInt(j) % 2)==0)
										{
										bgcolor ='background:#ffffff;';
										}
										else
										{
										bgcolor ='background:#F6F6F6;';
										}
										total_score = ( (parseFloat(response.kra_detail[i]['weightage_name']) * parseFloat(response.kra_detail[i]['apraiser_rating_value']) ) / 100 )
										
										html += '<tr class="inv_row" style="'+bgcolor+'">';
										html += '<td style="text-align:center;">'+j+'</td>';
										html += '<td style="text-align:left; width:160px;">'+response.kra_detail[i]['key_result_area']+'</td>';
										html += '<td style="text-align:left;width:160px;">'+response.kra_detail[i]['performance_target']+'</td>';
										html += '<td style="text-align:left;width:100px;">'+response.kra_detail[i]['performance_measure']+'</td>';
										html += '<td style="text-align:center;width:10px;">'+response.kra_detail[i]['weightage_name']+'% </td>';
										html += '<td style="text-align:left;">'+response.kra_detail[i]['self_rating_value']+'</td>';
										html += '<td style="text-align:center;">'+response.kra_detail[i]['comment']+'</td>';
										html += '<td style="text-align:left;">'+response.kra_detail[i]['apraiser_rating_value']+'</td>';
										html += '<td style="text-align:center;">'+response.kra_detail[i]['apraiser_comment']+'</td>';
										html += '<td style="text-align:center;">'+parseFloat(total_score).toFixed(2)+'</td>';
										
										html += '</tr>';
									}
									
									$('#overall_kra_score').html(overall_kra_score);
									
									if(html!='')
									{
									$("tbody#kra_detail").html(html);
									$('#final_kra_score').html(response.final_score);
									$('#kra_buttons').hide();
									$('#content_tab_b').show();
									$('#taba').removeClass('active');
									$('#tabb').addClass('active');
									$('#tb1_a').removeClass('active');
									$('#tb1_b').addClass('active');
									}
								}
							
							}
				});
               // $('#result').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown){
            // log the error to the console
            console.log(
                "The following error occured: "+
                textStatus, errorThrown
            );
            }
 
        });
		
		
 	 }
        return false;
    });
	
	//for competencies with idp
	  $("#competency_idp_form").submit(function() {
     var frm = $('#competency_idp_form');
	
	 var msg = '';
	 /* Apply Validateion to check **/
	 var flag=0;
	 $('#competency_idp_form tr').each(function() {
	 	var rate = $(this).find(".cls_rate").val();
		//alert(rate);
	 	//if(rate=='' || rate==undefined || isNaN(rate))
		//Modified By Ajay
		if(rate=='' )
		{
			flag=1;
		}
	  });
	  
	  /** collect in common
	  if(flag==1)
	  {
	  	alert("Please Select Rating For Each Competencies");
		return false;
	  }
	  **/
	 
	 /** End Validateion  **/
	 
	 /** Validateion for Technical idpE_item[] **/
	 //idpE_item[]
	 
		/** Empty for Training **/
		var is_empty_technical = 0;
		$('input[name="idpE_item[]"]').each(function(){
			//alert($(this).val());
			if( $(this).val() != '' ) {
				is_empty_technical = is_empty_technical +1 ;
			}
		});
		
		/** Collect in common
		if( is_empty_technical == 0 ) {
			alert('Please submit at least one Technical Info');
			return false ; 
		}
		**/

	 /** End Validateion for Technical **/
	 
	 
	 /** Validateion for Behavioural invE_item[] **/
	 //idpE_item[]
	 
		/** Empty for Training **/
		var is_empty_behav = 0;
		$('input[name="invE_item[]"]').each(function(){
			//alert($(this).val());
			if( $(this).val() != '' ) {
				is_empty_behav = is_empty_behav +1 ;
			}
		});
		
		/**
		if( is_empty_behav == 0 ) {
			alert('Please submit at least one Behavioural Info');
			return false ; 
		}
		**/

	 /** End Validateion for Technical **/
	 //Collerc all error info
	 
	if(flag==1)
	{
		msg += "Please Select Rating For Each Competencies.\n";
	}
	
	if( is_empty_technical == 0 ) {
		msg +='Please submit at least one Technical Info.\n';
	}
	
	if( is_empty_behav == 0 ) {
		msg += 'Please submit at least one Behavioural Info.\n';
	}
	
	if( msg != '' ) {
		alert(msg);
		return false;
	}
	  	 
	  var t = confirm("Are you Sure, You would like to submit your ratings.");
	 
	if(t==true)
	 {
	 
        $.ajax({
            type: frm.attr('method'),
            url: '<?php echo base_url('apraiser/addcompetencywithidp'); ?>',
            data: frm.serialize(),
            success: function (data) {
				
				 var html ='';
				$('#reset').click();
				
				if(data=='Please try again'){
				html += '<div class="alert alert-error">';
                html += '<a class="close" data-dismiss="alert">&times;</a>';
                html += '<strong>Error!&nbsp;</strong>'+data;
                html += '</div>';
				}
				else
				{
					html += '<div class="alert alert-success">';
                    html += '<a class="close" data-dismiss="alert">&times;</a>';
                    html += '<strong>Success!</strong> '+data;
                    html += '</div>';
				}
				$('#flashmessages_competency').after(html);
				$('#flashmessageoverallrating').html('');
				$('#content_tab_c').show();
				$("html, body").animate({ scrollTop: 0 }, "slow");
				hide_message('flashmessages_competency');
				               // alert('ok'); 
				//display comepetencies with idp
		
		var url = '<?php echo site_url("apraiser/getApraiserCompetenciesDetail"); ?>';
		
		var html = '';
		var html1 = '';
		var html2 = '';
 		 $.ajax({
		 			
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							pms_employee_id 	 : <?php echo $this->session->userdata('pms_employee_id') ?>,
							apraisee_employee_id : $('#appraisee_employee_id').val()
						  },
							success: function(response) {
							//alert(response.display_overall_rating);
								if(response.display_overall_rating!='Y')
								{
									$('#div_oveall_data').hide();
									if(response.is_first_appraiser!='Y' && response.is_pms_process_complete!='Y')
									{
										var html3= '';
										html3 += '<div class="alert alert-info">';
										html3 += '<a class="close" data-dismiss="alert">&times;</a>';
										html3 += '<strong>Please wait for overall Rating , pms process not Completed.</strong>';
										html3 += '</div>';
										$('#flashmessageoverallrating').html(html3);
										hide_message('flashmessageoverallrating');
									}
									
								}
								if(response.is_pms_process_finish=='Y' && response.is_first_appraiser=='Y' &&  response.is_pms_process_complete=='Y')
									{
										var html4 = '';
										html4 += '<div class="alert alert-info">';
                                    	html4 += '<a class="close" data-dismiss="alert">&times;</a>';
                                    	html4 += '<strong>Section C:Overall Rating - &nbsp;</strong> ';
										html4 += 'This section will be filled by Appraiser and Reviewer. NOT to be shared with Appraisee Performance on Key Result Areas has a weightage of 70% in the overall rating and competencies 30%. Refer to the materix below.';
										html4 += '</div>';
										$('#flashmessageoverallrating').after(html4);
										hide_message('flashmessageoverallrating');
										//$('#div_top_overall_data').show();
									}
									
								if(response.is_first_appraiser=='Y' && response.is_pms_process_complete!='Y')
									{
										var html5= '';
										html5 += '<div class="alert alert-info">';
										html5 += '<a class="close" data-dismiss="alert">&times;</a>';
										html5 += '<strong>Please wait for other Appraiser to submit his/her Rating. </strong>';
										html5 += '</div>';
										$('#flashmessageoverallrating').append(html5);
										$('#div_top_overall_data').hide();
										hide_message('flashmessageoverallrating');
									}
								else if(response.is_first_appraiser!='Y' && response.is_pms_process_finish!='Y')
								{
									var htm = '';
									htm += '<div class="alert alert-info">';
									htm += '<a class="close" data-dismiss="alert">&times;</a>';
									htm += '<strong>Please Wait. Other Appraiser not completed the PMS process. </strong>';
									htm += '</div>';
									$('#flashmessageoverallrating').append(htm);
									hide_message('flashmessageoverallrating');
								}
								
								if(response.is_first_appraiser!='Y' &&  response.is_pms_process_finish!='Y')
								{
									$('#div_top_overall_data').hide();
								}
								else if(response.is_first_appraiser=='Y' && response.is_pms_process_complete!='Y')
								{
									$('#div_top_overall_data').hide();
								}
								else
								{
									$('#div_top_overall_data').show();
								}
							
								if(response.competency_with_idp_detail.length > 0 )
								{
									var display_weightage = 0;
									//alert(response.competency_with_idp_detail[0]);
									for(var i=0; i<response.competency_with_idp_detail.length; i++)
									{
										var j= parseInt(i) + 1;
										var total_score = 0;
										var bgcolor ='';
										if((parseInt(j) % 2)==0)
										{
										bgcolor ='background:#ffffff;';
										}
										else
										{
										bgcolor ='background:#F6F6F6;';
										}
										
										if(parseInt(display_weightage)==0)
										{
											display_weightage = parseInt(response.competency_with_idp_detail[i]['weightage_value']);
										}
										else
										{
											display_weightage = parseInt(display_weightage) + parseInt(response.competency_with_idp_detail[i]['weightage_value']);
										}
										html += '<tr>';
										html += '<td>'+response.competency_with_idp_detail[i]['competencies_name']+'</td>';
										html += '<td>'+response.competency_with_idp_detail[i]['weightage_value']+'%</td>';
										html += '<td>'+response.competency_with_idp_detail[i]['scale']+'</td>';
										html += '<td>'+response.competency_with_idp_detail[i]['total_score']+'</td>';
										html += '</tr>';
										
									}
									html += '<tr>';
									html += '<td style="text-align:right;"><b>Total</b></td>';
									html += '<td>'+display_weightage+'%</td>';
									html += '<td>&nbsp;</td>';
									html += '<td><span id="final_score">'+response.final_score_cwi+'</span></td>';
				   					html += '</tr>';
									
									
								}
								if(response.technical_detail.length > 0 )
								{
								for(var h=0; h<response.technical_detail.length; h++)
									{
										tech_sr_no = parseInt(h)+1;
										html1 += '<tr >';
										html1 += '<td colspan="7" style="text-align:left; border-right:none; border-top:none;border-bottom:none;">';
										html1 += tech_sr_no+') '+response.technical_detail[h]['technical_area'];
										html1 += '</td>';
                                      	html1 += '</tr>';
									}
									if(html1!='')
									{
										/*$("tr#tr_technical").after(html1);
										$('#ta').remove();*/
									}
								}
								
								if(response.behavioural_detail.length > 0 )
								{
								for(var ba=0; ba<response.behavioural_detail.length;ba++)
									{
										ba_sr_no = parseInt(ba)+1;
										html2 += '<tr >';
										html2 += '<td colspan="7" style="text-align:left; border-right:none; border-top:none;border-bottom:none;">';
										html2 += ba_sr_no+') '+response.behavioural_detail[ba]['behavioural_area'];
										html2 += '</td>';
                                      	html2 += '</tr>';
									}
									
								}
								
								if(html!='')
									{
										$('#overall_kra_score').html(response.overall_kra_score);
										$('#overall_competencies_score').html(response.overall_competencies_score);
										$('#overall_performance_score').html(response.overall_performance_score);
										$('#apraiser_assessment_score').html(response.apraiser_assessment_score);
										
										$("tbody#appraiser_behavioural").html('');
										$("tbody#appraiser_behavioural").html(html2);
										//$('#ia').remove();
										$("tbody#appraiser_technical").html('');
										$("tbody#appraiser_technical").html(html1);
										//$('#ta').remove();
										$("tbody#cwidp_info").html(html);
										$('#cwi_buttons').hide();
										$('#tabb').removeClass('active');
										$('#tabc').addClass('active');
										$('#tb1_b').removeClass('active');
										$('#tb1_c').addClass('active');
										
										//Refresh Current page to get latest update result - Ajay
										gotorating();
									}
								
								
							
							}
				});
               // $('#result').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown){
            // log the error to the console
            console.log(
                "The following error occured: "+
                textStatus, errorThrown
            );
            }
 
        });
		
		
 
 	 }
        return false;
    });
	
	
	
	//for overall rating
	//for competencies with idp
	$("#form_overall_rating").submit(function() {
     var frm = $('#form_overall_rating');
	
	 var t = confirm("Are You sure You want to Submit this Overall Rating Form");
	 
	if(t==true)
	 {
        $.ajax({
            type: frm.attr('method'),
            url: '<?php echo base_url('apraiser/addoverallratingdata'); ?>',
            data: frm.serialize(),
            success: function (data) {
				
				 var html ='';
				$('#reset').click();
				
				if(data=='Please try again'){
				html += '<div class="alert alert-error">';
                html += '<a class="close" data-dismiss="alert">&times;</a>';
                html += '<strong>Error!&nbsp;</strong>'+data;
                html += '</div>';
				}
				else
				{
					html += '<div class="alert alert-success">';
                    html += '<a class="close" data-dismiss="alert">&times;</a>';
                    html += '<strong>Success!</strong> '+data;
                    html += '</div>';
				}
				$('#flashmessageoverallrating').after(html);
				$("html, body").animate({ scrollTop: 0 }, "slow");
				hide_message('flashmessageoverallrating');

				//display overall  Rating
				var url = '<?php echo site_url("apraiser/getapraiseroverallratingdetail"); ?>';
		
		var html  = 'N.A.';
		var html1 = 'N.A.';
		var html2 = 'N.A.';
 		 $.ajax({
		 			
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							pms_employee_id 	 : <?php echo $this->session->userdata('pms_employee_id') ?>,
							apraisee_employee_id : $('#appraisee_employee_id').val()
						  },
							success: function(response) {
								if(response.overall_rating_detail.length > 0 )
								{
									for(var ovr=0; ovr<response.overall_rating_detail.length; ovr++)
									{
										html  += '<td style="text-align:left; width:160px;">'+response.overall_rating_detail[ovr]['comment']+'</td>';
										html1 += '<td style="text-align:left;width:160px;">'+response.overall_rating_detail[ovr]['feedback']+'</td>';
										html2 += '<td style="text-align:left;width:100px;">'+response.overall_rating_detail[ovr]['promotion_recommendation']+'</td>';
									}
								
									if(html!='')
									{
										$('tr#tr_comment').html(html);
										$('tr#tr_feedback').html(html1);
										$('tr#tr_promotion').html(html2);
										$('#overall_rating_buttons').hide();
									}
								}
							
							}
				});
				
				
				
				

            },
            error: function(jqXHR, textStatus, errorThrown){
            // log the error to the console
            console.log(
                "The following error occured: "+
                textStatus, errorThrown
            );
            }
 
        });
		
		
 
 	 }
        return false;
    });
	
	
	
});
</script>
<script type="text/javascript" >
function calculate_total_score_per_row(id)
{
	var rate 		= $('#rate_'+id).val();
	var weightage   = $('#weightage_val'+id).val();
	if(rate=='' || rate==null)
	{
		rate = 0;
	}
	var total_score = (parseFloat(weightage) * parseFloat(rate) )/100;
	$('#total_score_'+id).html(parseFloat(total_score).toFixed(2));
	calculate_total();
	
}

function calculate_total()
{
var  final_score = '';
	$('#tbl_competencies tr').each(function() {
					var weightage = $(this).find(".cls_weightage").val();
					var rate = $(this).find(".cls_rate").val();
					
					if(weightage!=undefined && rate!=undefined){
						if(isNaN(weightage) || weightage<0 || isNaN(rate) || rate<0)
						{ var total = 0;}else{
						var total = (parseFloat(weightage) * parseFloat(rate)) / 100;
						
						if(final_score=='')
						{
							 if(!isNaN(total) && total!=undefined)
							 {
								final_score = total;
							 }
						}
						else{
							if(!isNaN(total) && total!=undefined)
							 {
								 final_score = parseFloat(final_score) + parseFloat(total);
							 }
						
						}}
					}
				});
				
				//alert(final_score);
				$('#final_score').html(parseFloat(final_score).toFixed(2));
}


</script>
<script type="text/javascript" >
function calculate_total_score_per_row_for_kra(id)
{
	var rate_kra 		= $('#rating_kra_'+id).val();
	var weightage_kra   = $('#weightage_kra_'+id).val();
	if(rate_kra=='' || rate_kra==null)
	{
		rate_kra = 0;
	}
	var total_kra_score = (parseInt(weightage_kra) * parseInt(rate_kra) )/100;
	$('#total_kra_score_'+id).html(parseFloat(total_kra_score).toFixed(2));
	calculate_total_for_kra();
	
}

function calculate_total_for_kra()
{
var  final_kra_score = '0';
	$('#apraiser_kra tr').each(function() {
					var weightage = $(this).find(".cls_weightage_kra").val();
					var rate = $(this).find(".cls_kra_rating").val();
					
					if(weightage!=undefined && rate!=undefined){
						if(isNaN(weightage) || weightage<0 || isNaN(rate) || rate<0)
						{ var total = 0.0;
						}else{
						
						var total = (parseFloat(weightage) * parseFloat(rate)) / 100;
						
						if(final_kra_score=='0')
						{
							
							 if(!isNaN(total) && total!=undefined)
							 {
								final_kra_score = parseFloat(total);
							 }
						}
						else{
						
							if(!isNaN(total) && total!=undefined)
							 {
								 final_kra_score = (parseFloat(final_kra_score) + parseFloat(total));
							 }
						
						}
						
						}
					}
				});
				
				//alert(final_score);
				$('#final_kra_score').html(parseFloat(final_kra_score).toFixed(2));
}


function validation_overall_rating()
{
 var ass_scor_nm = $('#apraiser_assessment_score').html();
	
	 if((ass_scor_nm=='FEE') || (ass_scor_nm=='BE'))
	 {
	 	if($('#overall_rating_comment').val()=='')
		{
			alert('Please Add Comment. Appraiser Assessment score = '+ ass_scor_nm);
			return false;
		}
	 }
	 else
	 {
	 	return true;
	 }
	
}

function gotorating()
{
	//alert('goto Rating');
	//Refresh for activate rating
	window.location = '<?php echo site_url('apraiser/apraiseeassessment/') . '/' . $segment_3 . '/gotorating' ; ?>';

}

</script>
<!-- To Make rating active -->
<?php if( $default_tab == 'gotorating' ): ?>
<script type="text/javascript">
		$('#cwi_buttons').hide();
		$('#taba').removeClass('active');
		$('#tb1_a').removeClass('active');
		$('#tb1_b').removeClass('active');		
		$('#tabb').removeClass('active');
		$('#tabc').addClass('active');
		$('#tb1_c').addClass('active');	
</script>
<?php endif; ?>
<?php echo $last_footer; ?>