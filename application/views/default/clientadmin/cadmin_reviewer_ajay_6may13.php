<?php echo $header; ?>
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
				<table class="table invE_table table-bordered" style="background-color:#FFFFFF;" >
				<tbody>
					<tr>
						<td valign="top">Employee Name: </td>
						<td valign="top"><strong><?php echo $top_employee_detail['fname'].' '.$top_employee_detail['lname']; ?></strong></td>
						<td valign="top">Employee No:</td>
						<td valign="top"><strong><?php echo $top_employee_detail['employee_id']; ?></strong></td>
						<td valign="top">Employee Department: </td>
						<td valign="top" style="text-align:left;"><strong><?php echo $top_employee_detail['department_name']; ?></strong></td> 
					</tr>
					<tr>
						<td valign="top">Designation: </td>
						<td valign="top"><strong><?php echo $top_employee_detail['designation_name']; ?></strong></td>
						<!--<td valign="top">Date of Joining:</td>-->
						<!--<td valign="top"><strong><?php //if($top_employee_detail['date_of_joining']!='0000-00-00') { echo date($s_date_format,strtotime($top_employee_detail['date_of_joining'])); } ?></strong></td>-->
						<td valign="top">Plant / Location:  </td>
						<td valign="top" style="text-align:left;"><strong><?php echo $top_employee_detail['office_name']; ?></strong></td> 
						<td colspan="2" >&nbsp;</td>
					</tr>
					<tr>
						
						<!--<td valign="top">Date Of Last Promotion:  </td>
						<td valign="top"><strong>
					    <?php //if($top_employee_detail['last_pramotion_date']!='0000-00-00') { 
						 	//echo date($s_date_format,strtotime($top_employee_detail['last_pramotion_date'])); 
						// }else{ echo "N.A."; }
						 ?>
						</strong></td>-->
							<td valign="top" >Name &amp; Designation <br />
					    of Appraiser: </td>
						<td valign="top" colspan="2"  >
						<span style="word-wrap: break-word;">
					    <?php 
						if($top_employee_apraiser_detail['appraiser']) {echo $top_employee_apraiser_detail['appraiser']; ?>
					    <?php }  ?>
						</span>				
					    </td>
						
						<td valign="top" >Name &amp; Designation <br />
					    of Reviewer:</td>
						<td valign="top" style="text-align:left;width:125px;" colspan="2" >
							<span style="word-wrap: break-word;">
							<?php if($top_employee_apraiser_detail['reviewer']) { echo $top_employee_apraiser_detail['reviewer']; ?>
							<?php } ?>	
							</span>				
							</td>
					</tr>
				</tbody>
				</table>
                            <div class="w-box-header">
                                <h4>Appraisee &nbsp;[Emp. Name: <?php echo $employee_name; ?> ]</h4>
                            </div>
                            <div class="w-box-content cnt_b">
                                <div class="row-fluid">
                                    <div class="span12">

								   <div class="tabbable tabbable-bordered">
                                            <ul class="nav nav-tabs">
                                                <li id="taba" class="<?php echo ($tab == 'tb1_a'? 'active' : '') ?>"><a data-toggle="tab" href="#tb1_a">KRA</a></li>
                                                <li id="tabb"  class="<?php echo ($tab == 'tb1_b'? 'active' : '') ?>"><a data-toggle="tab" href="#tb1_b">Competencies with IDP</a></li>
                                                <li id="tabc" class="<?php echo ($tab == 'tb1_c'? 'active' : '') ?>"><a data-toggle="tab" href="#tb1_c">Overall rating</a></li>
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
                                    <strong>Section A:KRA ASSESSMENT - &nbsp;</strong> 
									Breifly describe performance/achevements during the assessment periods. It is important for the 
									appraisar to enter his.her comments to substaintiate the ratings. 
									Your weightage% sum must equal to 100.Please Fill up The following Form
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
                 <form action="" method="post" id="reviewer_kra" style="margin-left:-23px; width:100%;" >
				 <input type="hidden" name="apraisee_employee_id" id="apraisee_employee_id" value="<?php echo $apraisee_employee_id; ?>"  />
                    <div class="span12">
					
			   			 <table class="table invE_table table-bordered" id="tbl_reviewer_kra">
						<thead>
							<tr>
							  <th rowspan="2" valign="top" style="border-top:none; text-align: center;">Sr. No. </th>
							  <th rowspan="2" valign="top" style="border-top:none; text-align: center;">Key Result Area </th>
							  <th rowspan="2" valign="top" style="border-top:none; text-align: center;">Performance Target</th>
							  <th rowspan="2" valign="top" style="border-top:none; text-align: center;">Performance Measure</th>
							  <th rowspan="2" valign="top" style="border-top:none; text-align: center;">Weightage %</th>
							  <th height="26" colspan="2" valign="top" style="border-top:none; text-align: center; width:20%">Self</th>
							  <th height="26" colspan="2" valign="top" style="border-top:; text-align: center;">Manager</th>
							  <th colspan="2" valign="top" style="border-top:; text-align: center;">Reviewer</th>
							  <th colspan="2" valign="top" style="border-top:; text-align:center; width:5%;">Final Ratings</th>
							  </tr>
							<tr>
								<th valign="top" style="border-top:; text-align: center; width:1%;">Rating</th>
								<th valign="top" style="text-align:center;border-top:; text-align: center;">Comments</th>
								<th valign="top" style="border-top:; text-align: left;">Rating</th>
								<th valign="top" style="text-align:center;border-top:; text-align: center;">Comments</th>
								<th valign="top" style="border-top:; text-align: left;">Rating</th>
								<th valign="top" style="text-align:center;border-top:; text-align: center;">Comments</th>
								<th valign="top" style="border-top:; text-align: center;font-size:12px;">
								<span data-placement="left" data-title="Final Rating" data-content="(Weightage * reviewer Rating) / 100" class="btn btn-mini pop-over" data-original-title="">&Sigma;</span>
								</th>
							</tr>
						</thead>
						<tbody id="kra_detail">
						<?php 
						if(isset($kra_detail))
						{
							if(!empty($kra_detail))
							{
								$i=1;
								foreach($kra_detail as $key=>$val)
								{
									
						?>
							
							<tr class="inv_row">
								<td><?php echo $i; ?></td>
								<td ><?php echo $val['key_result_area']; ?></td>
								<td><?php echo $val['performance_target']; ?></td>
								<td><?php echo $val['performance_measure']; ?></td>
								<td  style="text-align:center;"><?php echo $val['weightage_name']; ?> %</td>
								<td style="text-align:center;"><?php echo $val['self_rating_value']; ?></td>
								<td><?php echo $val['comment']; ?></td>
							    <td style="text-align:center;"><?php echo $val['apraiser_rating_value']; ?></td>
							    <td><?php echo $val['apraiser_comment']; ?></td>
								<td style="text-align:center;">
								<!-- modify onblur to on chagne -->
								<input class="cls_weightage_kra" type="hidden" name="weightage_kra_<?php echo $val['apraiser_kra_id']; ?>" id="weightage_kra_<?php echo $val['apraiser_kra_id']; ?>" value="<?php echo $val['weightage_name']; ?>"  />
									<select style="width:75px; font-size:12px;"  class="cls_kra_rating" name="rating_<?php echo $val['apraiser_kra_id']; ?>" id="rating_kra_<?php echo $val['apraiser_kra_id']; ?>" onchange="calculate_total_score_per_row_for_kra('<?php echo $val['apraiser_kra_id']; ?>')"  >
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
								<td><textarea  name="comments_<?php echo $val['apraiser_kra_id']; ?>" id="comments_kra<?php echo $val['apraiser_kra_id']; ?>"></textarea></td>
								<td width="5%" style="text-align:center"> <span id="total_kra_score_<?php echo $val['apraiser_kra_id']; ?>"> </span></td>
							</tr>
						<?php
						$i++;
						} 
						}
						}
						?>
						
						<?php
						if(isset($reviewer_kra_detail))
						{
							if(!empty($reviewer_kra_detail))
							{
								$i=0;
								$j = 0;
								foreach($reviewer_kra_detail as $key=>$val)
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
										<td style="text-align:center;"><?php echo $val['reviewer_rating_value']; ?></td>
										<td><?php echo $val['reviewer_comment']; ?></td>
										<td width="5%" style="text-align:center;"><?php echo $val['total_score']; ?></td>
									</tr>
									<?php
								}
							}
						}
						?>
						</tbody>
						<tfoot>
						<tr>
						<td colspan="4" style="text-align:right;font-weight:bold;">Weightage Total</td>
						<td style="text-align:center; font-weight:bold;">100%</td>
						<td colspan="6" style="text-align:right;font-weight:bold;"><b>Final Rating Total</b></td>
						<td style="font-weight:bold; text-align:center;"><span id="final_kra_score" ><?php echo $final_score; ?></span></td>
						</tr>
						</tfoot>	
						</table>
                        
                  
						<?php 
						if(isset($kra_detail))
						{
							?>
							<div class="formSep" id="kra_buttons" style="display:;">
							<div align="center">
							<input type="submit" name="submit" value="Next" id="submit" class="btn btn-beoro-3">
							<input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
						  </div>
						  </div>
						  <?php 
					   }
					  ?>
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
												<input type="hidden" name="apraisee_employee_id" id="apraisee_employee_id" value="<?php echo $apraisee_employee_id; ?>"  />
          <div class="row-fluid">
            <div class="span12">
			<?php
				  if(!isset($errormsg))
				  {
				   if(!isset($error))
				  {
				    if(isset($reviewer_kra_detail))
						{
				  ?>
				  <div class="alert alert-info">
                                    <a class="close" data-dismiss="alert">&times;</a>
                                    <strong>SECTION B: COMPETENCIES ASSESSMENT & IDP - &nbsp;</strong> 
									 Kindly rate the appraisee on each of the competencies stated    
		
                  </div>
				  <?php } }} ?>
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
				   <?php if(!isset($reviewer_kra_detail))
						{
						?>
						<div class="alert alert-error"><b>Alert! &nbsp;</b>Please Fill Up KRA First.</div>
						<?php } ?>
				  </div>
              <div class="tabbable tabbable-bordered">
			   <?php if(!isset($reviewer_kra_detail))
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
					<thead>
					<tr>
					<td colspan="7" align="left" style="text-align:left; background-color:#EFF7EC;font-weight:bold;">To be Filled By apraisee</td>
					
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
					<td colspan="7" align="left" style="text-align:left; background-color:#EFF7EC; font-weight:bold;">To be Filled By apraiser</td>
					
					</tr>
					<tr>
					<td colspan="7" align="left" style="text-align:left;">
						Kindly rate the appraisee on the below mentioned competencies <br />
						(Performance Rating Scale is 1 to 5 where 1 is least & 5 is highest)
					</td>
					</tr>
					<tr>
					<td colspan="6">
					
					<?php if( isset( $new_competencies_for_refrence )) : ?>
						<!-- New Table -->
						<?php  echo $new_competencies_for_refrence; ?>
						<!-- End New Table -->
						
					<?php else: ?>					
					
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
						
						if(isset($competency_with_idp_detail) )
						{
							if(!empty($competency_with_idp_detail))
							{
								foreach($competency_with_idp_detail as $keycwi=>$valcwi)
								{

									?>
									<tr>
									<td><?php echo $valcwi['competencies_name']; ?></td>
									<td><?php echo $valcwi['weightage_value'].'%'; ?></td>
									<td><?php echo $valcwi['scale']; ?></td>
									<td><?php echo $valcwi['total_score']; ?></td>
									</tr>
									<?php	
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
									<!-- Change to onchagne "" onblur= -->
										<input  type="hidden" name="weightage_<?php echo $valc['competencies_for_refrence_id']; ?>" id="weightage_<?php echo $valc['competencies_for_refrence_id']; ?>" value="<?php echo $valc['weightage_id']; ?>"  />
										<input class="cls_weightage" type="hidden" name="weightage_val<?php echo $valc['competencies_for_refrence_id']; ?>" id="weightage_val<?php echo $valc['competencies_for_refrence_id']; ?>" value="<?php echo $valc['weightage_value']; ?>"  />
										<select class="cls_rate span12" name="rate_<?php echo $valc['competencies_for_refrence_id']; ?>" id="rate_<?php echo $valc['competencies_for_refrence_id']; ?>"  onchange="calculate_total_score_per_row(<?php echo $valc['competencies_for_refrence_id']; ?>)" >
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
								}
								?>
								<?php
							}
						}
					?>
					<tr>
									<td style="text-align:right;"><b>Total</b></td>
									<td >100%</td>
									<td>&nbsp;</td>
									<td><span id="final_score"><?php echo $final_score_cwi ?></span></td>
				   </tr>
				   </tbody>
					</table>
					
					<?php endif; ?>
					
					
					
					
					
					
					</td>
					</tr>
					<tr>
					<td colspan="1" style="text-align:left;" valign="middle">Training is required for competencies where employee is rated less than and equal to 3.</td>
					</tr>
					</tbody>
					</table>
					
					<br />
					
					
					<table class="table invE_table table-bordered" >
					<tbody>
					
					<tr>
					<td colspan="7" align="left" style="text-align:left; background-color:#EFF7EC; font-weight:bold;">To be filled by Appraiser in discussion with appraisee</td>
					</tr>
					
					<tr>
					<td colspan="7" align="left" style="text-align:left;">Kindly list down the skill gaps/competencies where an appraisee needs to improve upon:</td>
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
								$ta =1;
								foreach($technical_detail as $keytd =>$valtd)
								{
									
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
								$ba=1;
								foreach($behavioural_detail as $keytd => $valtd)
								{									
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
                        <input type="submit" name="Submit" value="Next" id="Submit" class="btn btn-beoro-3">
                        <input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
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
                                    <strong>Section C:Overall Rating - &nbsp;</strong> 
									This section will be filled by Appraiser and Reviewer. NOT to be shared with Appraisee
									Performance on Key Result Areas has a weightage of 70% in the overall rating and competencies 30%. Refer to the materix below.
		
                  </div>
				  <?php
				 
				  }
				  }
				  ?>
				  <div id="flashmessageoverallrating">
				   <?php
				  if(isset($errormsg))
				  {
				  ?>
				  <div class="alert alert-error"><b>Alert! &nbsp;</b>
				  <?php echo $errormsg; ?>				  </div>
				  <?php
				  }
				  ?>
				   
				  </div>
				  
              <div class="tabbable tabbable-bordered">

                    <div class="w-box w-box-green"  >
					 <?php
				  if(!isset($errormsg))
				  {
				   if(!isset($error))
				  {
				  ?>
               <div class="row-fluid">
                    <div class="span5">
			   			  <table class="table table-bordered">
                                                    <thead>
													<tr>
													<th colspan="3" style="text-align:center">
													Appraiser
													</th>
													</tr>
                                                        <tr>
                                                            <th style="text-align: center;">Title</th>
                                                            <th style="text-align: center;">Weightage</th>
                                                            <th style="text-align: center;">Weighted Score </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="font-weight:bold;">Overall KRA Score</td>
                                                            <td style="text-align: center;">70%</td>
                                                            <td style="text-align: center; font-size:12px;"><span><?php echo $overall_kra_score_for_appraiser['overall_kra_score']; ?> <?php // echo number_format($apraiser_overall_kra_score,'2','.',''); ?></span> <span data-placement="top" data-title="Weighted Score" data-content="((Total Final Rating Of KRA) *(70)) / 100" class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-weight:bold;">Overall competencies Score</td>
                                                            <td style="text-align: center;">30%</td>
                                                            <td style="text-align: center; font-size:12px;"><span><?php echo $overall_kra_score_for_appraiser['overall_competency_score']; ?> <?php // echo number_format($apraiser_overall_competencies_score,'2','.',''); ?></span> <span data-placement="bottom" data-title="Weighted Score" data-content="((Total Final Rating Of Competencies) *(30)) / 100" class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="font-weight:bold;">Overall Performance Score</td>
                                                            <td style="text-align: center; font-size:12px;"><span ><?php echo $overall_kra_score_for_appraiser['overall_total']; ?> <?php // echo number_format($apraiser_overall_performance_score,'2','.',''); ?> <span data-placement="bottom" data-title="Weighted Score" data-content="( Overall KRA Score + Overall Competencies Score ) by Appraiser(s) " class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span></span>
															</td>
                                                        </tr>
                                                      
                                                    </tbody>
                         </table>
						 <br />
                  <table class="table table-bordered">
                                                    <thead>
													<tr>
													<th colspan="3" style="text-align:center">
													Reviewer
													</th>
													</tr>
                                                        <tr>
                                                            <th style="text-align: center;">Title</th>
                                                            <th style="text-align: center;">Weightage</th>
                                                            <th style="text-align: center;">Weighted Score </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
													<?php
													//Kra
													/**
													$final_score = (($final_score * 70 ) / 100 ) ; 
													$final_score_kra = number_format($final_score, 2, '.', '');													
													
													//IDP
													$reviewer_idp_score = (($reviewer_idp_score * 30 ) / 100 ) ;
													$final_score_idp = number_format($reviewer_idp_score, 2, '.', '');
													
													$final_total = number_format($reviewer_idp_score + $final_score_kra , 2, '.', '');
													**/
													?>
													
													
                                                        <tr>
                                                            <td style="font-weight:bold;">Overall KRA Score</td>
                                                            <td style="text-align: center;">70%</td>
                                                            <!-- <td style="text-align: center; font-size:12px;"><span id="overall_kra_score"><?php // if(!empty($overall_kra_score)) { echo number_format($overall_kra_score,'2','.',''); }  ?> <?php // echo 'Final: ' . $final_score_kra; ?></span> <span data-placement="top" data-title="Weighted Score" data-content="((Total Final Rating Of KRA) *(70)) / 100" class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span></td> -->
															<td style="text-align: center; font-size:12px;"><span id="overall_kra_score"><?php echo $final_score_kra; ?></span> <span data-placement="top" data-title="Weighted Score" data-content="((Total Final Rating Of KRA) *(70)) / 100" class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span></td>                                                         </tr>
                                                        <tr>
                                                            <td style="font-weight:bold;">Overall competencies Score</td>
                                                            <td style="text-align: center;">30%</td>
                                                            <!-- <td style="text-align: center; font-size:12px;"><span id="overall_competencies_score"><?php // if(!empty($overall_competencies_score)){ echo number_format($overall_competencies_score,'2','.',''); } ?> <?php // echo 'Final: ' . $final_score_idp; ?></span> <span data-placement="bottom" data-title="Weighted Score" data-content="((Total Final Rating Of Competencies) *(30)) / 100" class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span></td> -->
															<td style="text-align: center; font-size:12px;"><span id="overall_competencies_score"> <?php echo $final_score_idp; ?></span> <span data-placement="bottom" data-title="Weighted Score" data-content="((Total Final Rating Of Competencies) *(30)) / 100" class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="font-weight:bold;">Overall Performance Score</td>
                                                            <!-- <td style="text-align: center; font-size:12px;"><span id="overall_performance_score"><?php //  if(!empty($overall_performance_score)) { echo  number_format($overall_performance_score,'2','.',''); } ?> <?php // echo 'Final: ' . $final_total; ?> </span> -->
															<td style="text-align: center; font-size:12px;"><span id="overall_performance_score"><?php echo $final_total; ?> <span data-placement="bottom" data-title="Weighted Score" data-content="( Overall KRA Score + Overall Competencies Score ) by Reviewer" class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span></span>
															</td>
                                                        </tr>
                                                      
                                                    </tbody>
                         </table>
						 <br />
						   <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" style="text-align:center;">Overall Aeesesment Score</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Appraiser</td>
                                                           <!-- <td>Reviewer</td>-->
														   <td>Reviewer</td>
                                                        </tr>
                                                        <tr>
                                                            <td ><?php echo $overall_kra_score_rating_name ; //. ' '. $apraiser_overall_performance_score_name; ?></td>
                                                            <!--<td>FEE</td>-->
															<td><span id="apraiser_assessment_score"><?php echo $reviewer_assessment_score; ?></span></td></td>
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
						
						<div class="row-fluid" >
						<div class="span1"></div>
						<div class="span2">
			   			 
                  <table class="table table-bordered" >
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:justify;">Apraiser Signature</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
														<tr>
                                                            <td><b>Date: </b> <?php echo $apraiser_date; ?></td>
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
                                                            <td><b>Date: </b><?php echo $reviewer_date; ?> </td>
                                                        </tr>

                                                    </tbody>
                         </table>
					    </div>
						<div class="span1"></div>
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

$(document).ready(function() {

     $("#reviewer_kra").submit(function() {
     var frm = $('#reviewer_kra');
	 var t = confirm("Are You sure You want to Submit this KRA Form (For Reviewer)");
	 
	if(t==true)
	 {
	 	calculate_total();
        $.ajax({
            type: frm.attr('method'),
            url: '<?php echo base_url('reviewer/addkradata'); ?>',
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
				$('#flashmessageoverallrating').after('<div class="alert alert-error"><strong>Alert!</strong>Please Fill Up Competencies With IDP First. </div>');
				
				$("html, body").animate({ scrollTop: 2 }, "slow");
				               // alert('ok'); 
				//display pms
		var url = '<?php echo site_url("reviewer/getreviewerkradetail"); ?>';
		
		var html = '';
 		 $.ajax({
		 			
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							pms_employee_id 	 : <?php echo $this->session->userdata('pms_employee_id') ?>,
							apraisee_employee_id : $('#apraisee_employee_id').val()
						  },
							success: function(response) {
							var overall_kra_score	= ( (parseFloat(response.final_score) * 70 ) /100);
								if(response.kra_detail.length > 0 )
								{
									for(var i=0; i<response.kra_detail.length; i++)
									{
										var j= parseInt(i) + 1;
										
										html += '<tr class="inv_row" ">';
										html += '<td style="text-align:center;">'+j+'</td>';
										html += '<td style="text-align:left; width:160px;">'+response.kra_detail[i]['key_result_area']+'</td>';
										html += '<td style="text-align:left;width:160px;">'+response.kra_detail[i]['performance_target']+'</td>';
										html += '<td style="text-align:left;width:100px;">'+response.kra_detail[i]['performance_measure']+'</td>';
										html += '<td style="text-align:center;width:10px;">'+response.kra_detail[i]['weightage_name']+'% </td>';
										html += '<td style="text-align:left;">'+response.kra_detail[i]['self_rating_value']+'</td>';
										html += '<td style="text-align:center;">'+response.kra_detail[i]['comment']+'</td>';
										html += '<td style="text-align:left;">'+response.kra_detail[i]['apraiser_rating_value']+'</td>';
										html += '<td style="text-align:center;">'+response.kra_detail[i]['apraiser_comment']+'</td>';
										html += '<td style="text-align:left;">'+response.kra_detail[i]['reviewer_rating_value']+'</td>';
										html += '<td style="text-align:center;">'+response.kra_detail[i]['reviewer_comment']+'</td>';
										html += '<td style="text-align:center;">'+response.kra_detail[i]['total_score']+'</td>';
										
										html += '</tr>';
									}
									$('#overall_kra_score').html(overall_kra_score);
									if(html!='')
									{
									$("tbody#kra_detail").html(html);
									$('#final_kra_score').html(response.final_score);
									$('#overall_kra_score').html(parseFloat(overall_kra_score).toFixed(2));
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
	 var t = confirm("Are You sure You want to Submit this Competencies With IDP Form");
	 
	if(t==true)
	 {
        $.ajax({
            type: frm.attr('method'),
            url: '<?php echo base_url('reviewer/addcompetencywithidp'); ?>',
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
				//$('#content_tab_c').show();
				$("html, body").animate({ scrollTop: 0 }, "slow");
				               // alert('ok'); 
				//display comepetencies with idp
		var url = '<?php echo site_url("reviewer/getApraiserCompetenciesDetail"); ?>';
		
		var html = '';
		var html1 = '';
		var html2 = '';
 		 $.ajax({
		 			
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							pms_employee_id 	 : <?php echo $this->session->userdata('pms_employee_id') ?>,
							apraisee_employee_id : $('#apraisee_employee_id').val()
						  },
							success: function(response) {
								if(response.competency_with_idp_detail.length > 0 )
								{
									//alert(response.competency_with_idp_detail[0]);
									for(var i=0; i<response.competency_with_idp_detail.length; i++)
									{
										var j= parseInt(i) + 1;
										var total_score = 0;
										
										html += '<tr>';
										html += '<td>'+response.competency_with_idp_detail[i]['competencies_name']+'</td>';
										html += '<td>'+response.competency_with_idp_detail[i]['weightage_value']+'</td>';
										html += '<td>'+response.competency_with_idp_detail[i]['scale']+'</td>';
										html += '<td>'+response.competency_with_idp_detail[i]['total_score']+'</td>';
										html += '</tr>';
										
									}
									html += '<tr>';
									html += '<td style="text-align:right;"><b>Total</b></td>';
									html += '<td>100%</td>';
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
										html1 += tech_sr_no+') '+response.technical_detail[h]['reviewer_technical_area'];
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
										html2 += ba_sr_no+') '+response.behavioural_detail[ba]['reviewer_behavioural_area'];
										html2 += '</td>';
                                      	html2 += '</tr>';
									}
									
								}
								
								if(html!='')
									{
										$('#overall_kra_score').html(parseFloat(response.overall_kra_score).toFixed(2));
										$('#overall_competencies_score').html(parseFloat(response.overall_competencies_score).toFixed(2));
										$('#overall_performance_score').html(parseFloat(response.overall_performance_score).toFixed(2));
										$('#apraiser_assessment_score').html(response.apraiser_assessment_score);
										//$('#overall_competencies_score').html()
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
	var total_score = ((parseFloat(weightage) * parseFloat(rate)) / 100);
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
	$('#reviewer_kra tr').each(function() {
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


</script>

<?php echo $last_footer; ?>

<?php
//echo '<pre>';
//print_r($overall_kra_score_for_appraiser);
//echo '</pre>';
?>