<?php
/**
* Project Code: PMS
* Version: PMS1
* Object: Template
* Template: Default / clientadmin
* Template Name: cadmin_reviewer.php
* Desc: Display KRA, IDP with Competencies, Orerall Rating for Reviewer
* Last Update: 06-May-2013
* Author: Team Enrich
** Change Log **
* 11-May-13 - Update Employee Info table
**/
?>
<?php echo $header; ?>

<!-- main content -->
<div class="container-fluid" style="padding-left:1px; padding-right:1px;" >
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
              <!--<td valign="top">Date of Joining:</td>--> 
              <!--<td valign="top"><strong><?php //if($top_employee_detail['date_of_joining']!='0000-00-00') { echo date($s_date_format,strtotime($top_employee_detail['date_of_joining'])); } ?></strong></td>-->
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
              <td valign="top"  ><span style="word-wrap: break-word;">
                <?php 
						if($top_employee_apraiser_detail['appraiser']) {echo $top_employee_apraiser_detail['appraiser']; ?>
                <?php }  ?>
                </span></td>
              <td valign="top"  ><span style="text-align:left;width:125px;">Last PMS Rating </span></td>
              <td valign="top" style="text-align:left;"><span style="text-align:left;"><?php echo $last_score; ?> </span></td>
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
        <div class="w-box-content">
         
           
                <!-- Start Tab Content -->
                  <!-- tab a --->
                  
                    <div class="row-fluid">
                      <div class="span12">
                        
                        
                        <div class="tabbable tabbable-bordered">
                          <div class="w-box w-box-green" id="invoice_add_edit">
                            <?php
				  if(!isset($errormsg))
				  {
				   if(!isset($error))
				  {
				  ?>
                              <div class="span12">
                                <table class="table table-bordered" id="tbl_reviewer_kra">
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
                                      <th valign="top" style="border-top:; text-align: center;font-size:12px;"> <span data-placement="left" data-title="Final Rating" data-content="(Weightage * reviewer Rating) / 100" class="btn btn-mini pop-over" data-original-title="">&Sigma;</span> </th>
                                    </tr>
                                  </thead>
                                  <tbody id="kra_detail">                                    
                                    <?php
									$kra_weightage_total = 0;
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
									$kra_weightage_total += $val['weightage_name'];
								}
							}
						}
						?>
                                  </tbody>
                                  <tfoot>
                                    <tr>
                                      <td colspan="4" style="text-align:right;font-weight:bold;">Weightage Total: </td>
                                      <td style="text-align:center; font-weight:bold;"><?php echo $kra_weightage_total; ?>%</td>
                                      <td colspan="6" style="text-align:right;font-weight:bold;"><b>Final Rating Total</b></td>
                                      <td style="font-weight:bold; text-align:center;"><span id="final_kra_score" ><?php echo number_format($final_score, 2, '.', ''); ?></span></td>
                                    </tr>
                                  </tfoot>
                                </table>
                                
                              </div>
                            
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
                                      <td  style="text-align:justify;"><?php echo $valrt['rating_description']; ?></td>
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
						 	?>
                            <div class="row-fluid" ><br />
                              <br />
                              <center>
                                <font size="+3" >NO Data.</font>
                              </center>
                            </div>
                            <?php
						 }
						 
						  }
						   ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  
                  <!--- tab a closed ----> 
              
              
              <div style="height:20px; float:left;">&nbsp;</div>
              <div class="tabbable tabbable-bordered">
                <ul class="nav nav-tabs">
                  <li id="tabb" class="active"><a data-toggle="tab" href="#tb1_b">Competencies with IDP</a></li>
                </ul>
                <div class="tab-content"> 
                  <!--- tab b start--->
                  <div id="tb1_b" class="tab-pane active">
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
                          <div class="alert alert-info"> <a class="close" data-dismiss="alert">&times;</a> <strong>SECTION B: COMPETENCIES ASSESSMENT & IDP - &nbsp;</strong> Kindly rate the appraisee on each of the competencies stated </div>
                          <?php } }} ?>
                          <div id="flashmessages_competency">
                            <?php
				  if(isset($errormsg))
				  {
				  ?>
                            <div class="alert alert-error"><b>Alert! &nbsp;</b> <?php echo $errormsg; ?> </div>
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
                                      <td colspan="7" align="left" style="text-align:left;"><b>Development areas :</b>what are the areas you feel you need to develop in this year to enhance your performance </td>
                                    </tr>
                                  </thead>
                                  <tbody >
                                    <tr>
                                      <td colspan="7" align="left" style="text-align:left;"><?php
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
						?></td>
                                    </tr>
                                  </tbody>
                                </table>
                                <br />
                                <table class="table invE_table table-bordered" >
                                  <tbody>
                                    <tr>
                                      <td colspan="7" align="left" style="text-align:left; background-color:#EFF7EC; font-weight:bold;">To be Filled By Appraiser</td>
                                    </tr>
                                    <tr>
                                      <td colspan="7" align="left" style="text-align:left;"> Kindly rate the appraisee on the below mentioned competencies <br />
                                        (Performance Rating Scale is 1 to 5 where 1 is least & 5 is highest) </td>
                                    </tr>
                                    <tr>
                                      <td colspan="6"><?php // if( isset( $new_competencies_for_refrence )) : ?>
                                        
                                        <!-- New Table -->
                                        
                                        <?php //  echo $new_competencies_for_refrence; ?>
                                        
                                        <!-- End New Table -->
                                        
                                        <?php // else: ?>
                                        <table class="table  table-bordered" id="tbl_competencies" >
                                          <thead>
                                            <tr>
                                              <th><b>Competencies</b></th>
                                              <th><b>Weightage %</b></th>
                                              <th><b>Rating</b></th>
                                              <th><b>Reviewer Score</b></th>
                                            </tr>
                                          </thead>
                                          <tbody id="cwidp_info">
                                            <?php
						$weightage_value_total = 0;
					?>
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
									$weightage_value_total += $valcwi['weightage_value'];
								}
							}
						
						}
						elseif(isset($competencies_for_refrence))
						{
							if(!empty($competencies_for_refrence))
							{
								
								
							}
						}
					?>
                                            <tr>
                                              <td style="text-align:right;"><b>Total</b></td>
                                              <td ><?php echo $weightage_value_total; ?> %</td>
                                              <td>&nbsp;</td>
                                              <td><span id="final_score"><?php echo number_format( ($final_score_cwi == '' ? 0 : $final_score_cwi) , 2, '.', ''); ?></span></td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <?php // endif; ?></td>
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
                                      <td colspan="3" ><table class="table invE_table table-bordered" >
                                          <thead>
                                            <tr id="tr_technical">
                                              <td colspan="7"  style="text-align:center;"><b>Technical</b></td>
                                            </tr>
                                          </thead>
                                          <tbody id="appraiser_technical">
                                            <?php if( isset( $view_technical_detail ) ) : ?>
                                            <?php foreach( $view_technical_detail as $key_tech=>$val_tech ) : ?>
                                            <?php if( $val_tech['technical_area'] != '' ) : ?>
                                            <tr>
                                              <td colspan="7" style="text-align:left; border-right:none; border-top:none;border-bottom:none;"><?php echo $val_tech['technical_area']; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                          </tbody>
                                        </table></td>
                                      <td colspan="4" ><table class="table invE_table table-bordered" >
                                          <thead>
                                            <tr id="tr_behavioural">
                                              <td colspan="7" style="text-align:center;"><b>Behavioural</b></td>
                                            </tr>
                                          </thead>
                                          <tbody id="appraiser_behavioural">
                                            <?php if( isset( $view_behavioural_detail ) ) : ?>
                                            <?php foreach( $view_behavioural_detail as $key_bev=>$val_bev ) : ?>
                                            <?php if( $val_bev['behavioural_area'] != '' ) : ?>
                                            <tr>
                                              <td colspan="7" style="text-align:left; border-right:none; border-top:none;border-bottom:none;"><?php echo $val_bev['behavioural_area']; ?></td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                          </tbody>
                                        </table></td>
                                    </tr>
                                  </tbody>
                                </table>
                                <?php if(!isset($competency_with_idp_detail)) 
					   {
					   ?>
                                <div class="formSep" id="cwi_buttons">
                                  <div align="center">
                                    <input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
                                    <input type="submit" name="Submit" value="Next >>" id="Submit" class="btn btn-beoro-3">
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
						 	?>
                              <div class="row-fluid" ><br />
                                <br />
                                <center>
                                  <font size="+3" >NO Data.</font>
                                </center>
                              </div>
                              <?php
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
                </div>
              </div>
              
              <div class="tabbable tabbable-bordered">
                <ul class="nav nav-tabs">
                  <li id="tabc" class="active"><a data-toggle="tab" href="#tb1_c">Overall rating</a></li>
                </ul>
                <div class="tab-content"> 
                  <!-- tab c start ------->
                  <div id="tb1_c" class="tab-pane active">
                    <div class="row-fluid">
                      <div class="span12">
                        <?php
				  if(!isset($errormsg))
				  {
				   if(!isset($error))
				  {
				 
				  ?>
                        <div class="alert alert-info"> <a class="close" data-dismiss="alert">&times;</a> <strong>Section C:Overall Rating - &nbsp;</strong> This section will be filled by Appraiser and Reviewer. NOT to be shared with Appraisee
                          Performance on Key Result Areas has a weightage of 70% in the overall rating and competencies 30%. Refer to the materix below. </div>
                        <?php
				 
				  }
				  }
				  ?>
                        <div id="flashmessageoverallrating">
                          <?php
				  if(isset($errormsg))
				  {
				  ?>
                          <div class="alert alert-error"><b>Alert! &nbsp;</b> <?php echo $errormsg; ?> </div>
                          <?php
				  }
				  ?>
                        </div>
                        <!-- TODO: Check for reviewer_kra_detail -->
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
                                      <th colspan="3" style="text-align:center"> Appraiser </th>
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
                                      <td style="text-align: center; font-size:12px;"><span style="font-weight:bold;"><?php echo $appraisee_overall_rating['kra_score']; ?></span> <span data-placement="top" data-title="Weighted Score" data-content="((Total Final Rating Of KRA) *(70)) / 100" class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span></td>
                                    </tr>
                                    <tr>
                                      <td style="font-weight:bold;">Overall competencies Score</td>
                                      <td style="text-align: center;">30%</td>
                                      <td style="text-align: center; font-size:12px;"><span style="font-weight:bold;">
                                        <?php // echo $appraisee_overall_rating['competency_score']; ?>
                                        <?php echo $overall_competencies_score; ?></span> <span data-placement="bottom" data-title="Weighted Score" data-content="((Total Final Rating Of Competencies) *(30)) / 100" class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" style="font-weight:bold;">Overall Performance Score</td>
                                      <td style="text-align: center; font-size:12px;"><span style="font-weight:bold;" >
                                        <?php // echo $appraisee_overall_rating['overall_rating']; ?>
                                        <?php echo $overall_performance_score; ?> </span> <span data-placement="bottom" data-title="Weighted Score" data-content="( Overall KRA Score + Overall Competencies Score ) by Appraiser(s) " class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span></td>
                                    </tr>
                                  </tbody>
                                </table>
                                <br />
                                <table class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th colspan="3" style="text-align:center"> Reviewer </th>
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
                                      <td style="text-align: center; font-size:12px;"><span id="overall_kra_score" style="font-weight:bold;"><?php echo $reviewer_overall_rating['kra_score']; ?></span> <span data-placement="top" data-title="Weighted Score" data-content="((Total Final Rating Of KRA) *(70)) / 100" class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span></td>
                                    </tr>
                                    <tr>
                                      <td style="font-weight:bold;">Overall competencies Score</td>
                                      <td style="text-align: center;">30%</td>
                                      <td style="text-align: center; font-size:12px;"><span id="overall_competencies_score" style="font-weight:bold;"><?php echo $reviewer_overall_rating['competency_score']; ?></span> <span data-placement="bottom" data-title="Weighted Score" data-content="((Total Final Rating Of Competencies) *(30)) / 100" class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" style="font-weight:bold;">Overall Performance Score</td>
                                      <td style="text-align: center; font-size:12px;"><span id="overall_performance_score" style="font-weight:bold;"><?php echo $reviewer_overall_rating['overall_rating']; ?></span> <span data-placement="bottom" data-title="Weighted Score" data-content="( Overall KRA Score + Overall Competencies Score ) by Reviewer" class="btn btn-mini pop-over" style="font-size:10px;" data-original-title="">&Sigma;</span></td>
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
                                      <td ><?php echo $appraisee_overall_rating['score_rating']; ?></td>
                                      <!--<td>FEE</td>-->
                                      <td><span id="apraiser_assessment_score"><?php echo $reviewer_overall_rating['score_rating']; ?></span></td>
                                        </td>
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
                            <div class="row-fluid span12" >
                            <div class="span12">
                            <table width="100%" border="0">
                                  <tr>
                                    <td valign="top"><table class="table table-bordered" >
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
                                          <td><b>Date: </b> <?php echo $apraiser_date; ?></td>
                                        </tr>
                                      </tbody>
                                    </table></td>
                                    <td valign="top">&nbsp;</td>
                                    <td align="right" valign="top"><table class="table table-bordered" >
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
                                          <td><b>Date: </b><?php echo $reviewer_date; ?></td>
                                        </tr>
                                      </tbody>
                                    </table></td>
                                  </tr>
                                </table>
                            </div>
                            
                            
                              <div class="span1"></div>
                              <div class="span2">
                                
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                              </div>
                              <div class="span5"> &nbsp; </div>
                              <div class="span2"></div>
                              <div class="span1"></div>
                            </div>
                            <?php }
						 else
						 {
						 	?>
                            <div class="row-fluid" ><br />
                              <br />
                              <center>
                                <font size="+3" >NO Data.</font>
                              </center>
                            </div>
                            <?php
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
                
                <!-- End Tab Border --> 
              </div>
              
           
         
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('default/clientadmin/pdf_cadmin_middle_footer'); ?>
<?php // echo $middle_footer; ?>
<?php // echo $common_js; ?> 
<?php echo $last_footer; ?>