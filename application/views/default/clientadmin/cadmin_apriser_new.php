<style>
.tabbable-bordered .nav-tabs > li.active {
	border-top: 5px solid #368CA9;
    margin-top: 0;
    position: relative;
	border-radius:5px;
}

.checkbox.inline { width:250px; margin-right:0px; }
</style>
 

            
        <!-- main content -->
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4>Appraiser</h4>
                            </div>
                            <div class="w-box-content cnt_b">
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="tabbable tabbable-bordered">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#tb1_a">KRA</a></li>
                                                <li><a data-toggle="tab" href="#tb1_b">Competencies</a></li>
                                                <li><a data-toggle="tab" href="#tb1_c">Overall rating</a></li>
												<li><a data-toggle="tab" href="#tb1_d">IDP</a></li>
                                                <li><a data-toggle="tab" href="#tb1_e">Pramotion</a></li>
                                            </ul>
                                            <div class="tab-content">
											<!-- tab a --->
                                            <div id="tb1_a" class="tab-pane active">
                                                  <form action="" method="post" id="validate_extended">
          <div class="row-fluid">
            <div class="span12">
				  <div class="alert alert-info">
                                    <a class="close" data-dismiss="alert">&times;</a>
                                    <strong>Section A:KRA ASSESSMENT - &nbsp;</strong> 
									Breifly describe performance/achevements during the assessment periods. Please use a seprate sheet if space is not adequate. It is important for the 
									appraisar to enter his.her comments to substaintiate the ratings. 
									Your weightage% sum must equal to 100.Please Fill up The following Form
                  </div>
              <div class="tabbable tabbable-bordered">
                    <div class="w-box w-box-green" id="invoice_add_edit">
               
                    <div class="span12">
					
			   			 <table class="table invE_table">
						<thead>
							<tr>
								<th>Sr. No. </th>
								<th>Key Result Area </th>
								<th>Performance Target</th>
								<th>Performance Measure</th>
								<th>Weightage %</th>
								<th>Rating</th>
								<th style="text-align:center">Comments</th>
								<th>Rating</th>
								<th style="text-align:center">Comments</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$kra = array('Procurement Savings(BOM)','Inventory Turn Ratio (RM+BOP)','Creditors Payment Period','Outsourcing','Alternate Sourcing (Contributes to procurement saving)','Succession Plan','Behavioral training for supervisors');
						$perf_target = array('Polymeer Division 1.13% on Procurement','25% improvement (ITR 40)','57 Days','4 Projects','90 lacs (0.13% on Procurement)','End of Year 11-12','4 Man days/person/year');
						$perf_measure = array('Saving Report','SAP Report','Finance MIS','Suppliers Agreement','Saving Report','HR Report','HR MIS');
						$weight = array('20%','15%','20%','15%','10%','10%','10%');
						for($i=0;$i<=6;$i++)
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
								<td ><?php echo $kra[$i]; ?></td>
								<td><?php echo $perf_target[$i]; ?></td>
								<td><?php echo $perf_measure[$i]; ?></td>
								<td><?php echo $weight[$i]; ?></td>
								<td><?php echo "20"; ?></td>
								<td><?php echo "56"; ?></td>
								<td>
									<select  name="rating_<?php echo $i; ?>" id="rating_<?php echo $i; ?>" class="span12" style="width:120%" >
									<option  value="">None</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									</select>
								</td>
								<td><textarea  class="span10" name="comments_<?php echo $i; ?>" id="comments_<?php echo $i; ?>"></textarea></td>
							</tr>
						<?php
						} 
						?>
						</tbody>	
                                        </table>
                        
                  
		
						<div class="formSep">
            			<div align="center">
                        <input type="submit" name="submit" value="Submit" id="submit" class="btn btn-beoro-3">
                        <input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
                      </div>
					  </div>
					   </div>
					  </div>
          </div>
        </div>
        </div>
    	
      </form>
                                                </div>
											<!--- tab a closed ---->
											
											<!--- tab b start--->
                                                <div id="tb1_b" class="tab-pane">
												<form action="" method="post" id="validate_extended">
          <div class="row-fluid">
            <div class="span12">
				  <div class="alert alert-info">
                                    <a class="close" data-dismiss="alert">&times;</a>
                                    <strong>Section B:COMPETENCIES ASSESSMENT - &nbsp;</strong> 
									Breifly describe 'Behaviour' demonstrated on each of the competencies states during the assessment period.Please use the seprate sheet if space is not adequate. It is important for the appraiser
									to enter his/her comments to substantiate the ratings by mentining specific instances.
									Your weightage% sum must equal to 100.Please Fill up The following Form
		
                  </div>
              <div class="tabbable tabbable-bordered">
                    <div class="w-box w-box-green" id="invoice_add_edit">
               
                    <div class="span12">
			   			 <table class="table invE_table">
						<thead>
							<tr>
								<th>Sr. No. </th>
								
								<th>Competency</th>
								<th>Weightage%</th>
								<th>Behavioural Indicators</th>
								
								
								<th>Rating</th>
								<th>Comments</th>
								<th style="text-align:center">Ratings</th>
								
							</tr>
						</thead>
						<tbody>
						<?php 
						$kra = array('Procurement Savings(BOM)','Inventory Turn Ratio (RM+BOP)','Creditors Payment Period','Outsourcing','Alternate Sourcing (Contributes to procurement saving)','Succession Plan','Behavioral training for supervisors');
						$perf_target = array('Polymeer Division 1.13% on Procurement','25% improvement (ITR 40)','57 Days','4 Projects','90 lacs (0.13% on Procurement)','End of Year 11-12','4 Man days/person/year');
						$perf_measure = array('Saving Report','SAP Report','Finance MIS','Suppliers Agreement','Saving Report','HR Report','HR MIS');
						$weight = array('20%','15%','20%','15%','10%','10%','10%');
						for($i=0;$i<=7;$i++)
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
								<td><textarea name="competency_<?php echo $i; ?>" id="competency_<?php echo $i; ?>" ></textarea></td>
								<td ><input type="text" class="span10" name="weightage_<?php echo $i; ?>" id="weightage_<?php echo $i; ?>" /></td>
								<td><textarea name="bhvindi_<?php echo $i; ?>" id="bhvindi_<?php echo $i; ?>" ></textarea></td>
								<td><select  name="rating_<?php echo $i; ?>" id="rating_<?php echo $i; ?>" class="span12" style="width:120%" >
									<option  value="">None</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									</select>
								</td>
								<td><textarea  class="span10" name="comments_<?php echo $i; ?>" id="comments_<?php echo $i; ?>"></textarea></td>
								<td></td>
							</tr>
						<?php
						} 
						?>
						
						</tbody>	
						  <tr class="last_row">
                                                    <td colspan="4">&nbsp;</td>
													<td>Total</td>
						 </tr>
                           </table>
                        
                  
		
						<div class="formSep">
            			<div align="center">
                        <input type="submit" name="submit" value="Submit" id="submit" class="btn btn-beoro-3">
                        <input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
                      </div>
					  </div>
					   </div>
					  </div>
          </div>
        </div>
        </div>
    	
      </form>
                                                </div>
										  <!-- tab b closed ---->
										  
										  <!-- tab c start ------->
                                                <div id="tb1_c" class="tab-pane">
<form action="" method="post" id="validate_extended">
          <div class="row-fluid">
            <div class="span12">
				  <div class="alert alert-info">
                                    <a class="close" data-dismiss="alert">&times;</a>
                                    <strong>Section C:Overall Rating - &nbsp;</strong> 
									This section will be filled by Appraiser and Reviewer. NOT to be shared with Appraisee
									Performance on Key Result Areas has a weightage of 70% in the overall rating and competencies 30%. Refer to the materix below.
		
                  </div>
              <div class="tabbable tabbable-bordered">
                    <div class="w-box w-box-green" >
               
                    <div class="span5">
			   			 
                  <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Title</th>
                                                            <th>Weightage</th>
                                                            <th>Weighted Score</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Overall KRA Score</td>
                                                            <td>70%</td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Overall competencies Score</td>
                                                            <td>30%</td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">Overall Performance Score</td>
                                                            <td></td>
                                                        </tr>
                                                      
                                                    </tbody>
                         </table>
						 </div>
						 <div class="span4">
						 		 
                  <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Score Range</th>
                                                            <th>Ratings</th>
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
        </div>
        </div>
    	
      </form>                                                </div>
										<!--- tab c closed ---->
												<div id="tb1_d" class="tab-pane">
                                                    <p>Section 3</p>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi elit dui, porta ac scelerisque placerat, rhoncus vitae sem. Nulla eget libero enim, facilisis accumsan eros.</p>
                                                </div>
												<div id="tb1_e" class="tab-pane">
                                                    <p>Section 3</p>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi elit dui, porta ac scelerisque placerat, rhoncus vitae sem. Nulla eget libero enim, facilisis accumsan eros.</p>
                                                </div>
												
												
                                            </div>
                                        </div>
                                    </div>
                                  
                                </div>
                            
                            </div>
                        </div>
                   
                    </div>
                </div>
            </div>



<?php $this->load->view('default/clientadmin/cadmin_last_footer'); ?>
