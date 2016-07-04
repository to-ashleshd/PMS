 <div class="w-box-content">
							<div class="w-box w-box-green">
							  <div class="w-box-header">
								<h4>Last Promotion</h4>
							  </div>
                          <div class="w-box-content">
                            <table id="dt_colVis_Reorder_client" class="table table-striped table-condensed">
                              <thead>
                                <tr>
                                  <th style="width:10%;">id</th>
                                  <th style="width:10%;">Employee Id</th>
								  <th style="width:30%;">Employee Name</th>
								  <th style="width:20%;">Date of Last Promotion</th>
                                  <th style="width:20%;">Designation</th>
								  <th style="width:10%;">Grade</th>
                                </tr>
                              </thead>
                              <tbody id="tbody_last_promotion">
							 <?php
							 if(isset($last_promotion_list))
							 {
							 	if(!empty($last_promotion_list))
								{
									$i = 0;
									foreach($last_promotion_list as $key=>$val)
									{
										$i++;
										?>
										<tr id="tr_last_promotion_<?=$val['employee_last_promotions_id']?>" >
										  <td><?=$i?></td>
										  <td><?=$val['employee_id']?></td>
										  <td><?php echo $val['fname'].' '. $val['lname']; ?></td>
										  <td><?=$val['last_promotion_date']?></td>
										  <td><?=$val['designation_name']?></td>
										  <td><?=$val['grade_name']?></td>
									  </tr>
										<?php
									}
								}
							 }
							 ?>
									 
							  </tbody>
							  </table>
							  </div>
							  </div>
							</div>
							<br />
<div >
<span id="present_detail_title"><b>Present Detail: </b></span><br />
<table class="table invE_table table-bordered" style="background-color:#FFFFFF;" >
				<tbody>
					<tr>
						<td valign="top" >Employee ID:</td>
						<td valign="top"  ><strong><?php echo $present_detail['employee_id']; ?></strong></td>
						<td valign="top">Employee Name: </td>
						<td valign="top"><strong><?php echo $present_detail['fname'].' '.$present_detail['lname']; ?></strong></td>
						<td valign="top">Date Of Joining </td>
						<td valign="top"style="text-align:left;"><strong><?php echo $present_detail['date_of_joining']; ?></strong></td>
					</tr>
					<tr>
						<td valign="top" >Date of Last Promotion </td>
					    <td valign="top" style="text-align:left;"><strong><span id="span_last_prom_dt" ><?php echo $present_detail['last_pramotion_date']; ?></span></strong></td>
						
						<td valign="top">Designation: </td>
						<td valign="top"><strong><span id="span_designation_nm" ><?php echo $present_detail['designation_name']; ?></span></strong></td>
					
						<td valign="top">Grade:</td>
						<td valign="top" style="text-align:left;"><strong><span id="span_grade_nm" ><?php echo $present_detail['grade_name']; ?></span></strong></td> 
					</tr>
					
					
				</tbody>
				</table>
</div>
<br />					
<div id="add_last_promotion" >
 <div class="formSep">
                  <label class="span3">Date Of Last Promotion</label>
				  <!-- <input type="text" name="date_last_promotion" value=""  data-date-start-view="0" data-date-format="<?php echo $js_date_format; ?>"  data-date="<?php echo $current_date; ?>" id="dp1" onclick="this.blur();"> -->
				  <input type="text" name="date_last_promotion" value=""  data-date-start-view="0" data-date-format="<?php echo $js_date_format; ?>"  data-date="<?php echo $current_date; ?>" id="dp1" >
			</div>
			
			<div class="formSep">
                  <label class="span3">Select Designation</label>
				 <select name="designation" id="designation" >
				 <option value="">--Please Select--</option>
				 <?php
				 	if(isset($designations))
					{
						if(!empty($designations))
						{
							foreach($designations as $keyd=>$vald)
							{
							?>
							<option value="<?=$vald['designation_id']?>" ><?=$vald['designation_name']?></option>
							<?php							
							}
						}
					}
				 ?>
				 </select>
			</div>		
			<div class="formSep">
			<label class="span3">&nbsp;</label>
			<input type="button" name="submit" id="submit" value="Submit" class="btn btn-beoro-3" onclick="add_last_promotion()" />
			<input type="button" name="cancel" id="cancel" value="Cancel" class="btn btn-beoro-3" onclick="reset_value()" />
			</div>
</div>							
							