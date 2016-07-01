<?php
/**
* Project Code: PMS
* Version: PMS1
* Object: Template
* Template: Default / clientadmin
* Template Name: cadmin_addkra.php
* Desc: Add / Display KRA 
* Last Update: 08-May-2013
* Author: Team Enrich
** Change Log **
* 8-May-13 Add PDF
* 9-May-13 Update Top Appraisee Info
**/
?>
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
  </style>
  <style>
   .ui-autocomplete {
 background-color:#ffffff;
}
 .ui-autocompleteoverlay {
background-color:#3A73CC;
}
.ui-autocomplete li:hover{
background-color:#3A73CC;
display:inline-block;
}
.ui-menu .ui-menu-item ui-state-focus,
.ui-menu .ui-menu-item ui-state-active {
background-color:#3A73CC;
};

.ui-helper-hidden {
	display: none;
}
.ui-helper-hidden-accessible {
	border: 0;
	clip: rect(0 0 0 0);
	height: 1px;
	margin: -1px;
	overflow: hidden;
	padding: 0;
	position: absolute;
	width: 1px;
}
.ui-helper-clearfix:after {
	clear: both;
}

.ui-state-hover,
.ui-widget-content .ui-state-hover,
.ui-widget-header .ui-state-hover,
.ui-state-focus,
.ui-widget-content .ui-state-focus,
.ui-widget-header .ui-state-focus {
	/*border: 1px solid #fbcb09;*/
	background: #3A73CC  50% 50% repeat-x;
	font-weight: bold;
	color: #ffffff;
}







/* Misc visuals
----------------------------------*/

/* Corner radius */
.ui-corner-all,
.ui-corner-top,
.ui-corner-left,
.ui-corner-tl {
	border-top-left-radius: 4px;
}
.ui-corner-all,
.ui-corner-top,
.ui-corner-right,
.ui-corner-tr {
	border-top-right-radius: 4px;
}
.ui-corner-all,
.ui-corner-bottom,
.ui-corner-left,
.ui-corner-bl {
	border-bottom-left-radius: 4px;
}
.ui-corner-all,
.ui-corner-bottom,
.ui-corner-right,
.ui-corner-br {
	border-bottom-right-radius: 4px;
}

</style>
<?php
	$id='';
?>
  <!-- main content -->
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12"> 
      <div class="w-box"> 
	  
	  <input type="hidden" name="max_kra" id="max_kra" value="<?=$max_kra?>"  />
	  <input type="hidden" name="min_kra" id="min_kra" value="<?=$min_kra?>"  />
	  <input type="hidden" name="min_weightage" id="min_weightage" value="<?=$min_weightage?>"  />
	  <input type="hidden" name="max_weightage" id="max_weightage" value="<?=$max_weightage?>"  />
	  <input type="hidden" name="txt_used_kra" id="txt_used_kra" value="<?php if(isset($used_kra)){ echo $used_kra;  } ?>"  />
	  <input type="hidden" name="txt_edit_total_weight" id="txt_edit_total_weight" value="<?php if(isset($edit_total_weight)) { echo $edit_total_weight; }?>"  />
	  <input type="hidden" name="txt_edit_max_weight" id="txt_edit_max_weight" value="<?php if(isset($max_weight_for_edit)) { echo $max_weight_for_edit; }?>"  />
	  <input type="hidden" name="is_all_appraiser_have_kra" id="is_all_appraiser_have_kra" value="<?=$is_all_apraser_kra?>"   />
	
		<!-- New table -->
		<table class="table invE_table table-bordered" style="background-color:#FFFFFF;" >
				<tbody>
					<tr>
						<td valign="top">Employee Name: </td>
						<td valign="top"><strong><?php echo $top_employee_detail['fname'].' '.$top_employee_detail['lname']; ?></strong></td>
						 <td valign="top" >Employee ID:</td>
					  <td valign="top" style="text-align:left;"  ><strong><?php echo $top_employee_detail['employee_id']; ?></strong></td>
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
						<td valign="top">Plant / Location: </td>
						<td valign="top" style="text-align:left;"><strong><?php echo $top_employee_detail['office_name']; ?></strong></td>
					
					 
					  <td valign="top"  >Date of Last Promotion</td>
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
					  <td valign="top" style="text-align:left;"><span style="text-align:left;"><?=$last_score?></span></td>
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
		
		
	 <?php
		  //Get Years From and To
		  $this->load->model('taskschedulemodel');
		  $result_year = $this->taskschedulemodel->getTimeperiodById($time_period_id);
		  $display_year = '[' . $result_year->time_period_from . ' - ' . $result_year->time_period_to . ']';
	 ?>
	 <?php if( $track_status >= 1.0 ) : ?>

	 <div style="float:right; width:100%; margin-right:10px;">
			<div style="width:32px; height:32px; float:right; margin-top:-7px;  margin-left:10px;"><a href="<?php echo site_url("mypdf/pdfaddkra/") . '/'.$segment_3; ?>" target="_blank" ><img src="<?php echo site_url('assets/user/images/default').'/pdficon.jpg'; ?>" height="32" width="32" title="PDF Report"  /></a></div>
			
			<div style="width:32px; height:32px; float:right; margin-top:-7px;"><a href="<?php echo site_url('mypdf/exceladdkra') . '/'.$segment_3; ?>" target="_blank" ><img src="<?php echo site_url('assets/user/images/default').'/excelicon.jpg'; ?>" height="32" width="32" title="Excel Report"  /></i></a></div>

	</div>
	<br  /><br />
			<?php endif; ?>
      <div class="w-box-header">
			<h4>My KRA <?php echo $display_year; ?></h4>
			
      </div>
		
      <form action="" method="post" id="add_kra">
	  <input type="hidden" name="h_time_period_id" id="h_time_period_id" value="<?=$time_period_id;?>"  />
	 
        <div class="w-box-content cnt_b" >  
          <div class="row-fluid">
            <div class="span12">
			
				 
				

				   <div id="flashmessages" >
				  <?php if(isset($pending_status))
									{
										
									?>
									<div class="alert alert-info">
                                    <a class="close" data-dismiss="alert">&times;</a>
									<strong><?php echo $pending_status;
									if(isset($appraiser_name_info))
									{
										if(!empty($appraiser_name_info))
										{
											echo " KRA Awaiting Approval From: "."&nbsp; ".$appraiser_name_info."";
										}
									}
									if(isset($apariser_name_info_not_approve))
									{
										if(!empty($apariser_name_info_not_approve))
										{
											echo " Not Approved By: "."&nbsp; ".$apariser_name_info_not_approve;
										}
									}
									?></strong>
									</div>
									<?php
									}
									?>
				   </div>
				  
				  
				  <?php
				  if(isset($error))
				  {
				  ?>
				  <div class="alert alert-error"><b>Alert! &nbsp;</b>
				  <?php echo $error; ?>
				  </div>
				  <?php
				  }
				  ?>
				  
              <div class="tabbable tabbable-bordered" >
                    <div class="w-box w-box-green" id="invoice_add_edit " >
                    <div class="span12">
					<div id="content_edit_kra" >
					<?php
					if(isset($not_approve_comment))
					{
						?><b>KRA not Approve Comment :&nbsp;</b><?php //echo $not_approve_comment['not_approve_comment'];
					}
					?>
					<!-- <br /><br /> -->
					<?php
				 
				   if(!isset($error))
				  {
				  	if(isset($edit_kra_detail))
					{
						if(!empty($edit_kra_detail))
						{
				
				  ?>
				  <div id="div_edit_all_weight">
				   <input type="button" value="Edit Weightages" id="edit_weight_all" name="edit_weight_all" class="btn btn-beoro-3" onclick="call_edit_all_weight()"   />
				   &nbsp;<input type="button" value="Edit Appraiser" id="edit_appraiser" name="edit_appraiser" class="btn btn-beoro-3" onclick="call_edit_all_appraiser()"   />
				  <?php
				  if(($used_kra >= $min_kra) && ($edit_total_weight==$max_weight_for_edit))
						{
						?>
				<!-- <input type="button" value="Edit Weightages" id="edit_weight_all" name="edit_weight_all" class="btn btn-beoro-3" onclick="call_edit_all_weight()"   />
				 -->
			
				 <?php } ?>
				 	 <br /> <br />
				 </div>
				  <table class="table invE_table table-bordered" id="edit_kra_id" >
							<thead>
								<tr>
									<th style="text-align:left; width:1%;">Sr. No. </th>
								
									<th style="text-align:left;">Key Result Area </th>
									<th style="text-align:left;">Performance Target</th>
									<th style="text-align:left;" >Performance Measure</th>
									<th style="text-align:left; width:20px;">Weightage %</th>
									<th style="text-align:left;">Initiative</th>
									<th style="text-align:left;">Appraiser Name</th>
									<th style="text-align:left;">Action</th>
								</tr>
							</thead>
							<tbody id="edit_kra_detail">
							
				  	<?php
				
						foreach($edit_kra_detail as $keyekr=>$valekr)
						{
							
					?>
						<tr id="editable_<?=$valekr['apraisee_kra_id']?>">
							<td style="text-align:left; width:1%;" class="cls_sr_no" ><?=$keyekr+1?></td>
							
							<td style="text-align:left;"><?=$valekr['key_result_area']?></td>
							<td style="text-align:left;"><?=$valekr['performance_target']?></td>
							<td style="text-align:left;"><?=$valekr['performance_measure']?></td>
							<td style="text-align:center; width:20px;" class="cls_display_edit_weight"><?=$valekr['weightage_value']?> %
							<input class="cls_weight_edit span12" type="hidden"  name="edit_weight_<?=$valekr['apraisee_kra_id']?>" readonly="readonly"   id="edit_weight_<?=$valekr['apraisee_kra_id']?>" value="<?=$valekr['weightage_value']?>"   / >
							
							</td>
							<td style="text-align:left;"><?=$valekr['initaitive']?></td>
							<td style="text-align:left;"><?=$valekr['appraiser_name_designation']?></td>
							<td style="text-align:center;" class="cls_edit_link">
							<a  href="javascript:void(0)" onclick="update_kra('<?=$valekr['apraisee_kra_id']?>','<?=$keyekr+1?>')" title="Edit"  ><i class="icsw16-pencil"></i></a>&nbsp;
							<a  href="javascript:void(0)" onclick="remove_kra('<?=$valekr['apraisee_kra_id']?>','<?=$keyekr+1?>')" title="Delete" ><i class="icsw16-trashcan"></i></a>
							</td>
						</tr>
					<?php
						}
						?>
						<tr class="last_row">
								<td colspan="4" style="text-align:right"><b>Total:</b></td>
								<td style="text-align:center; font-weight:bold;"><span id="edit_total_weight"><?php echo $edit_total_weight; ?></span> %</td>
								<td colspan="3" style="text-align:center">&nbsp;</td>
					    </tr>
						
						<?php 
						//echo $used_kra.'='.$min_kra;
						
						if(($used_kra >= $min_kra) && ($edit_total_weight==$max_weight_for_edit))
						{
						?>
						<tr>
								<td colspan="8" style="text-align:center" class="cls_send_to_apraiser"><input  type="button" class="btn btn-beoro-3 " name="send_to_apraiser" id="send_to_apraiser" value="Submit To Appraiser for Approval" onclick="send_to_appraiser()"  /></td>
					    </tr>
						<?php 
						}else
						{
						?>
						<tr>
									<td colspan="8" style="text-align:center" class="cls_send_to_apraiser">&nbsp;</td>
			    			  </tr>	
					<?php
					}
						}
					}
					?>
				  </tbody>
				</table>
				</div>

			   			
							<?php 
							if(isset($kra_detail))
							{
								if(!empty($kra_detail))
								{
									
								?>
							
								 <table class="table invE_table table-bordered" id="kra_id"  >
									<thead>
										<tr>
											<th style="text-align:left; width:1%;" >Sr. No.</th>											
											<th style="text-align:left;">Key Result Area </th>
											<th style="text-align:left;">Performance Target</th>
											<th style="text-align:left;" >Performance Measure</th>
											<th style="text-align:left; width:20px;">Weightage %</th>
											<th style="text-align:left;">Initiative</th>
											<th style="text-align:left;">Appraiser Name</th>
										</tr>
									</thead>
								<tbody id="kra_detail">
								<?php							
									$i=0;
									foreach($kra_detail as $key=>$val)
									{
										$j= $i+1;
										
									?>
										<tr>
										<td  style="text-align:center;">
									<?php echo $j; ?>
										</td>
										
										<td style="text-align:left;"><?php echo $val['key_result_area']; ?></td>
										<td style="text-align:left;"><?php echo $val['performance_target']; ?></td>
										<td style="text-align:left;"><?php echo $val['performance_measure']; ?></td>
										<td style="text-align:center;width:20px;"><?php  echo $val['weightage_value'].'%'; ?></td>
										<td style="text-align:left;"><?php echo $val['initaitive']; ?></td>
										<td style="text-align:left;">
										<?php
										
										if($val['apraisee_kra_approve_status'] == 2)
										{
											$display_status = "Approved";
										}
										else if($val['apraisee_kra_approve_status'] == 1)
										{
											$display_status =  "Pending";
										}
										else if($val['apraisee_kra_approve_status'] == 0){
										
											$display_status = "Not Approved";
										}
										?>
										<?=$val['appraiser_name_designation'] . '  (' . $display_status . ')'; ?></td>
									   </tr>
									<?php
									$i++;
									} 
									?>
									<tr class="last_row">
										<td colspan="4" style="text-align:right"><b>Total:</b></td>
										<td style="text-align:center; font-weight:bold;"><span id="total_weight"><?php echo $total_weight; ?></span> %</td>
										<td style="text-align:center" colspan="2">&nbsp;</td>
									</tr>
									
							</tbody>
							</table>
							
									<?php
									
								}
							}
							else
							{
							?>
							<div id="main_content_add_kra" >
							<?php
								if($used_kra < $max_kra && (($edit_total_weight < $max_weight_for_edit))) 
								{
								?>
								<br /><br />
			<!--	<div id="main_content_add_kra" >-->
					<div class="w-box-header" style=" background: none repeat scroll 0 0 #EFF7EC;color:#000000;font-size: 13px;height: 32px;line-height: 32px;padding: 0 10px 1px;border-color: #CCCCCC;border-style: solid;border-width: 1px 1px 1px 1px;">
					<h4>Add KRA</h4>
					</div>
					<div class="w-box-content">
					<div class="span10">
					<div id="div_kra_detail">
									
								<?php
								
								$i=1;
								?>
								<div class="formSep">
                                        <label class="span3 req">Appraiser: </label>
										<?=$appraiser?>									
                                </div>
							
								<div class="formSep">
                                        <label class="span3 req">Key Result Area: </label>
                                        <textarea class="span8" name="kra[]" id="kra_<?php echo $i; ?>"  ></textarea>
                              </div>
									<div class="formSep">
                                        <label class="span3 req">Performance Target: </label>
                                        <textarea class="span8" name="perf_target[]" id="perf_target_<?php echo $i; ?>"></textarea>
                                    </div>
									<div class="formSep">
                                        <label class="span3 req">Performance Measure: </label>
                                        <textarea class="span8" name="perf_measure[]" id="perf_measure_<?php echo $i; ?>"  ></textarea>
                                    </div>
									<div class="formSep">
									  <label class="span3 req">Weight: </label>
                                        <input class="cls_weight span3"  title="Remaining Weightage : <?php echo ($max_weight_for_edit-$edit_total_weight); ?>" type="text"  name="weight[]"    id="add_weight_<?php echo $i; ?>"   onblur="calculate_total()" value=""  maxlength="2"  />
										<br />
										<label class="span3" style="margin-left:0px;">&nbsp;</label>
										<label class="span8" style="margin-left:0px;"><b>Total: </b><span id="total_weight"><?php echo $edit_total_weight; ?></span> %</label>
                                  
								    </div>
									<div class="formSep">
                                        <label class="span3">Initiative: </label>
                                       <textarea class="span8" name="initiative[]" id="initiative_<?php echo $i; ?>"  ></textarea>
                                    </div>
									
								
				
							
								<?php
								
								}
							}
								?>
							 
						</div>
						</div>
						
                        <?php if(!isset($kra_detail))
							{
								if($used_kra< $max_kra && (($edit_total_weight < $max_weight_for_edit))) 
								{
							?>
						<div class="formSep" id="kra_buttons" style="display:;">
            			<div align="center">
                        <input type="submit" name="submit" value="Save As Draft" id="submit" class="btn btn-beoro-3" onclick="calculate_total();">
                        <input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
                      </div>
					  </div>
					  <?php }} ?>
                  
		<?php } ?>
						</div>
						</div>
				      </div>
				  </div>
          </div>
        </div>
        </div>
    	</div>
      </form>
    </div>
  </div>
</div>
</div>


<?php $this->load->view('default/clientadmin/cadmin_middle_footer'); ?>

<?php //echo $middle_footer; ?>
<?php echo $common_js; ?>
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/form_validation.js"></script>
<!-- <script src="<?php //echo base_url("assets/sweetdream/"); ?>/js/jquery.min.js"></script>
    <script src="<?php //echo base_url("assets/sweetdream/"); ?>/js/jquery-ui.min.js"></script>-->
<script type="text/javascript" >

/*$.widget('custom.catcomplete', $.ui.autocomplete, {
	_renderMenu: function(ul, items) {
		var self = this, currentCategory = '';
		
		$.each(items, function(index, item) {
			if (item['category'] != currentCategory) {
				//ul.append('<li class="ui-autocomplete-category">' + item['category'] + '</li>');
				
				currentCategory = item['category'];
			}
			self._renderItem(ul, item);
		});
	}
});          

$('input[name=\'weight[]\']').catcomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: '<?php //echo site_url("apraisee/autocomplete_weightage"); ?>',
			dataType: 'json',
			type: 'POST',
		    data: {
					weightage:  encodeURIComponent(request.term)
    		     },
			success: function(json) {	
				var weight = json['weightage']
				response($.map(weight, function(item) {
					return {
						label: item['weightage_value'],
						value: item['weighatge_id'],
					}
				}));
			}
		});
	}, 
	select: function(event, ui) { 
		$(this).attr('value', ui.item['label']);
		return false; 
	},
	focus: function(event, ui) {
      	return false;
   	}
});
 */


</script>

<script type="text/javascript" >
function check_is_all_appraiser()
{

	
	var weightage = $('#total_weight').html();
	var time_period_id	= $('#h_time_period_id').val();
	var appraiser_employee_id = $('#appraiser_employee_id').val();
	//alert(weightage);
	
	if((parseInt(weightage)==parseInt(100)) && appraiser_employee_id!='')
	{
		
		var url = '<?php echo site_url("apraisee/check_each_appraiser_has_kra"); ?>';
		var html = '';
 		 $.ajax({
		 			
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							time_period_id :time_period_id,
							appraiser_employee_id :appraiser_employee_id
						  },
							success: function(response) {
								if(response.is_kra=='Y')
								{
									$('#is_all_appraiser_have_kra').val('Y');
								}
								else if(response.is_kra=='N')
								{
									$('#is_all_appraiser_have_kra').val('N');
								}
								else
								{
									$('#is_all_appraiser_have_kra').val('');
								}
							}
				});
		
	}
	

}
</script>

<script type="text/javascript" >
$(document).ready(function() {

	

	var t = '';
    $("#add_kra").submit(function() {
	
	 var used_kra = $('#txt_used_kra').val();
	 var max_kra = $('#max_kra').val();
	 //alert(max_kra);alert(used_kra);
	 var min_kra = $('#min_kra').val();
	 var time_period_id	= $('#h_time_period_id').val();
	 var edit_total_weight = $('#txt_edit_total_weight').val();
	 var txt_edit_max_weight = $('#txt_edit_max_weight').val();
	 var weight	= $('#add_weight_1').val();
	 var flag1 = 0;
	 var new_total_kra = (parseInt(used_kra)+1);
	 var flag2 = 0;
	 
	 var min_weightage = $('#min_weightage').val();
	 var max_weighatge = $('#max_weightage').val();
	 var is_all_appraiser_have_kra = '';
	 
	 if(weight=='' || weight==undefined)
	 {
		 weight=0;
	 }
	 var new_weight = parseInt(edit_total_weight) + parseInt(weight);
	
	
	 if(parseInt(new_weight)==parseInt(100))
	 {
	 	is_all_appraiser_have_kra = $('#is_all_appraiser_have_kra').val();
	 }
	 
	 //alert('Max KRA: ' + max_kra );
	 
	 if(parseInt(used_kra)>=parseInt(max_kra))
	 {
	 	alert("Only "+max_kra+" KRA allowed");
		return false;
	 }
	 else if(parseInt(edit_total_weight)>=100)
	 {
	 	alert("Total Weight Already 100");
		return false;
	 }
	 else if(parseInt(new_weight)>parseInt(txt_edit_max_weight))
	 {
	 	alert("Total Weight can not greater than "+parseInt(txt_edit_max_weight)+" .");
		return false;
	 }
	 else if(parseInt(used_kra)== parseInt(max_kra - 1) && parseInt(new_weight) < parseInt(txt_edit_max_weight))
	 {
	 	alert("Total Weight can not less than "+parseInt(txt_edit_max_weight)+" .");
		return false;
	 }
	 else if(parseInt(new_total_kra)<parseInt(min_kra))
	 {
		if(parseInt(txt_edit_max_weight)==100)
		{
			if(parseInt(new_weight)==100)
			{	
				flag2 = 1;
			}
		}
	 }
	 
	 if(flag2==1)
		{
			alert("Weightage can not 100. Minimun "+min_kra+" KRA required.");
			t=false;
			return false;
		}
	 else
	 {

	 	var msg = '';
		var msg1 ='';
		if(!is_empty('appraiser_employee_id'))
		{
			flag1=1;
			msg += 'Please Select Appraiser.\n';
		}
		
		if(!is_empty('kra_1')){ 
			flag1=1;
			msg1 += 'KRA cannot be empty.\n';
		}
		
		if(!is_empty('perf_target_1')){
			flag1=1;
			if(msg1=='')
			{
				msg1 += 'Performance Target cannot be empty.\n';
			}
			else
			{
				msg1 += 'Performance Target cannot be empty.\n';
			}
		}
		
		if(!is_empty('perf_measure_1')){
			flag1=1;
			if(msg1=='')
			{
				msg1 += 'Performance Measure cannot be empty.\n';
			}
			else
			{
				msg1 += 'Performance Measure cannot be empty.\n';
			}
		}
		
		if(!is_empty('add_weight_1')){
			flag1=1;
			if(msg1=='')
			{
				msg1 += 'Weightage shoule be numberic (1,2,3 etc.) and cannot be empty.\n';
			}
			else
			{
				msg1 += 'Weightage shoule be numberic (1,2,3 etc.) and cannot be empty.\n';
			}
		}
		
		if(flag1==0)
		{
			if(!isnumeric('add_weight_1'))
			{
				flag1 =2;
				if(msg1=='')
				{
					msg += 'Weightage ' + weight + ' shoule be numberic (1,2,3 etc.) and cannot be empty.\n';
				}
				else
				{
					msg += 'Weightage ' + weight + ' shoule be numberic (1,2,3 etc.) and cannot be empty.\n';
				}
			}
		}
		
		if(flag1==1)
		{
			//Fields  Marked with Red Color are Compulsary
			if(msg1!='')
			{
				alert(msg+"Please Check\n"+msg1+"");
			}
			else
			{
				alert(msg);
			}
			t=false;
			return false;
		}
		else if(flag1==2)
		{
			alert("Weightage '" + weight + "' shoule be numberic (1,2,3 etc.)");
			t=false;
			return false;
		}
		else if((parseInt(weight)<parseInt(min_weightage)) || (parseInt(weight)>parseInt(max_weighatge)))
		{
			alert("Weightage should be less than "+parseInt(min_weightage)+" and greater than "+parseInt(max_weighatge));
			t=false;
			return false;
		}
		else if(is_all_appraiser_have_kra=='N')
		 {
			alert("All Appraiser having atleast one KRA");
			t=false;
			return false;
		 }
		else
		{
			t=true;
			//t=false;
		}
		
	}
	 
	
	if(t==true)
	 {
	  /*if(calculate_total())
		 {
		 	//alert("hi");
		 }
		 else
		 {
		 	alert("Please check weight! Total weightage must be 100");
			return false;
		 }*/
     var frm = $('#add_kra');
		
        $.ajax({
            type: frm.attr('method'),
            url: '<?php echo base_url('apraisee/addkradata'); ?>',
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
				$('#flashmessages').html('');
				$('#flashmessages').append(html);
				$("html, body").animate({ scrollTop: 0 }, "slow");
				hide_message('flashmessages');
				
				//display pms
		var url = '<?php echo site_url("apraisee/getkradetail"); ?>';
		var html = '';
 		 $.ajax({
		 			
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							time_period_id :time_period_id
						  },
							success: function(response) {
								if(response.kra_detail.length > 0 )
								{
									$('#edit_kra_detail').html('');
									//$('#used_kras').html('');
									$('#txt_used_kra').val(parseInt(used_kra)+1);
									//$('#used_kras').html(parseInt(used_kra)+1);
									//$('#remaing_kras').html(parseInt(max_kra)-(parseInt(used_kra)+1));
									$('#txt_edit_total_weight').val(response.edit_total_weight);
									$('#edit_total_weight').html(response.edit_total_weight);
									//$('#total_weight').html('0');
									
										
									
									if (!($('tbody#edit_kra_detail').length > 0))
									{
										html += '<div id="div_edit_all_weight"></div>';
										html += '<table class="table invE_table table-bordered" id="edit_kra_id" >';
										html += '<thead>';
										html += '<tr>';
										html += '<th style="text-align:left; width:1%;"  >Sr. No. </th>';
										
										html += '<th style="text-align:left;">Key Result Area </th>';
										html += '<th style="text-align:left;">Performance Target</th>';
										html += '<th style="text-align:left;" >Performance Measure</th>';
										html += '<th style="text-align:left;width:20px;">Weightage %</th>';
										html += '<th style="text-align:left;">Initiative</th>';
										html += '<th style="text-align:left;">Appraiser Name</th>';
										html += '<th style="text-align:left;">Action</th>';
										html += '</tr>';
										html += '</thead>';
										html += '<tbody id="edit_kra_detail">';
										
									} 
									
									for(var i=0; i<response.kra_detail.length; i++)
									{
										var j= parseInt(i) + 1;
										
										html += '<tr id="editable_'+response.kra_detail[i]['apraisee_kra_id']+'">';
										html += '<td style="text-align:center;width:1%;" class="cls_sr_no">'+j+'</td>';
										
										html += '<td style="text-align:left;">'+response.kra_detail[i]['key_result_area']+'</td>';
										html += '<td style="text-align:left;">'+response.kra_detail[i]['performance_target']+'</td>';
										html += '<td style="text-align:left;">'+response.kra_detail[i]['performance_measure']+'</td>';
										html += '<td style="text-align:center;" class="cls_display_edit_weight">'+response.kra_detail[i]['weightage_value']+'%';
										html += '<input class="cls_weight_edit span12" type="hidden"  name="edit_weight_'+response.kra_detail[i]['apraisee_kra_id']+'"    id="edit_weight_'+response.kra_detail[i]['apraisee_kra_id']+'" readonly="readonly" value="'+response.kra_detail[i]['weightage_value']+'"   / ></td>';
										html += '<td style="text-align:left;">'+response.kra_detail[i]['initaitive']+'</td>';
										html += '<td style="text-align:left;">'+response.kra_detail[i]['appraiser_name_designation']+'</td>';
										html += '<td style="text-align:center;" class="cls_edit_link">';
										html += '<a href="javascript:void(0)" onclick="update_kra(\''+response.kra_detail[i]['apraisee_kra_id']+'\',\''+j+'\')" title="Edit" ><i class="icsw16-pencil"></i></a>&nbsp;';
										html += '<a href="javascript:void(0)" onclick="remove_kra(\''+response.kra_detail[i]['apraisee_kra_id']+'\',\''+j+'\')" title="Delete" ><i class="icsw16-trashcan"></i></a></td>';
										
										html += '</tr>';
									}
									
									html += '<tr class="last_row">';
									html += '<td colspan="4" style="text-align:right"><b>Total:</b></td>';
									html += '<td style="text-align:center; font-weight:bold;"><span id="edit_total_weight">'+response.edit_total_weight+'</span> %</td>';
									html += '<td colspan="3" style="text-align:center">&nbsp;</td>';
					    			html += '</tr>';
									html += '<tr>';
									html += '<td colspan="8" style="text-align:center" class="cls_send_to_apraiser"></td>';
									html += '</tr>';
									
									if (!($('tbody#edit_kra_detail').length > 0))
									{
										html += '</tbody>';
										html += '</table>';
										$('#content_edit_kra').html(html);
										var html2 = '';
										html2 +='<input type="button" value="Edit Weightages" id="edit_weight_all" name="edit_weight_all" class="btn btn-beoro-3" onclick="call_edit_all_weight()"   />';
										html2 +='&nbsp;<input type="button" value="Edit Appraiser" id="edit_appraiser" name="edit_appraiser" class="btn btn-beoro-3" onclick="call_edit_all_appraiser()"   /><br><br>';
										$('#div_edit_all_weight').html(html2);
										
									}
									else if(html!='')
									{
										$("tbody#edit_kra_detail").html(html);
									}
									
									var remaining_weight = parseInt(100)-parseInt(response.edit_total_weight);
									$('#add_weight_1').attr('title','Remaining Weightage : '+remaining_weight);
									
									if(parseInt(response.kra_detail.length)>=parseInt(min_kra) && (parseInt(response.edit_total_weight)>=parseInt(100)) )
									{
										$('.cls_send_to_apraiser').html('<input type="button" class="btn btn-beoro-3 " name="send_to_apraiser" id="send_to_apraiser" value="Submit To Appraiser for Approval" onclick="send_to_appraiser()" />');
										$('#main_content_add_kra').html('');
									}
									
									/*if(parseInt(response.kra_detail.length)>=parseInt(min_kra) && (parseInt(response.edit_total_weight)>=parseInt(100)) )
									{
										var html2 = '';
										html2 +=' <input type="button" value="Edit Weightages" id="edit_weight_all" name="edit_weight_all" class="btn btn-beoro-3" onclick="call_edit_all_weight()"   /><br><br>';
										$('#div_edit_all_weight').html(html2);
									}*/
									
									//$("tbody#kra_detail").html(html);
									//alert('KRA Length: ' + response.kra_detail.length);
									//Bug 7 
									if(response.kra_detail.length>=  max_kra )
									{
										$('#div_kra_detail').html('');
										$('#kra_buttons').hide();
									}
									//alert(parseInt(100)-parseInt(response.edit_total_weight));
									//$('#add_weight_1').attr('title','Remaining Weightage :'+parseInt(100)-parseInt(response.edit_total_weight));
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
		
		
	
	
 		
	}else
	{
		
	}
	
        return false;
    });
	//}
});
</script>
<script type="text/javascript">
function calculate_total()
{

var  total_weight = '';
var edit_total_weight = $('#txt_edit_total_weight').val();
if(edit_total_weight=='' || edit_total_weight==undefined)
{
	edit_total_weight = 0;
}
var flag = 0 ;
	//$('#kra_id tr').each(function() {
					var weightage =  $('#add_weight_1').val();
					//alert(weightage);
					
					if(weightage!=undefined){
						if(isNaN(weightage) || weightage<0)
						{ 
							var total = 0;
						}
						else{
						var total = (parseFloat(weightage));
						//alert(total);
						if(total_weight=='')
						{
							 if(!isNaN(total) && total!=undefined)
							 {
								total_weight = total;
							 }
						}
						else{
							if(!isNaN(total) && total!=undefined)
							 {
								 total_weight = parseFloat(total_weight) + parseFloat(total);
							 }
						
						}}
					}
				//});
				
			
				$('#total_weight').html('');
				//alert(edit_total_weight);alert(total_weight);
				var net_weight = parseInt(edit_total_weight)+ parseInt(total_weight);
				//alert(net_weight);
				if(isNaN(net_weight) || net_weight==undefined)
				{
					net_weight = 0;
				}
				
				if(parseFloat(net_weight)>100)
				{
					alert("Weight can not grater than 100");
					return  false;
				}
				else
				{
					$('#total_weight').html(net_weight);
					check_is_all_appraiser();
					return true;
				}
				
				
				//$('#final_score').html(parseFloat(final_score).toFixed(2));
}

function calculate_edit_total()
{
	var  total_weight = '';
	var max_weight		= $('#txt_edit_max_weight').val();
	var edit_total_weight = $('#txt_edit_total_weight').val();
	var new_weight = 0;
	if(edit_total_weight=='' || edit_total_weight==undefined)
	{
		edit_total_weight = 0;
	}

var flag = 0 ;
	$('#edit_kra_id tr').each(function() {
					var weightage = $(this).find(".cls_weight_edit").val();
					if(weightage!=undefined)
					{
						
						if(isNaN(weightage) || weightage<0)
						{ 
							var total = 0;
						}
						else
						{
							/*	var id = $(this).attr('id');
								var weight_old = $('#weight_old'+id).val();*/
								//new_weight = parseInt(edit_total_weight) - parseInt(weight_old);
								var total = (parseFloat(weightage));
							
								if(total_weight=='')
								{
									 if(!isNaN(total) && total!=undefined)
									 {
										total_weight = total;
									 }
								}
								else
								{
										if(!isNaN(total) && total!=undefined)
										 {
											 total_weight = parseFloat(total_weight) + parseFloat(total);
										 }
							
							   }
						}
					}
				});
				
				
				//alert()
				//$('#edit_total_weight').html('');
				var net_weight = parseInt(total_weight);
			
				if(isNaN(net_weight) || net_weight==undefined)
				{
					net_weight = 0;
				}
				
				if(parseFloat(net_weight) > parseInt(max_weight))
				{
			
					alert("Weight can not grater than"+max_weight);
					return  false;
				}
				else
				{
				
					$('#edit_total_weight').html(net_weight);
					return true;
				}
				
				//$('#final_score').html(parseFloat(final_score).toFixed(2));
}
</script>
<script type="text/javascript" >
function remove_kra(kra_id,sr_no)
{
	var weight = $('#edit_weight_'+kra_id).val();
	var used_kra = $('#txt_used_kra').val();
	var new_used_kra = parseInt(used_kra)-parseInt(1);
	
	var edit_total_weight = $('#txt_edit_total_weight').val();
	var new_edit_total_weight = parseInt(edit_total_weight)-parseInt(weight);

	if(isNaN(new_edit_total_weight))
	{
		new_edit_total_weight = 0;
	}
	
	
	
	var html = '';
	
	
	var t = confirm("Are You Sure You want to Remove KRA.");
	if(t==true)
	{
		var url = '<?php echo site_url("apraisee/removekra"); ?>';
		var html = '';
 		 $.ajax({
		 			
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							apraisee_kra_id : kra_id,
							edit_total_weight:edit_total_weight,
							new_edit_total_weight : new_edit_total_weight
						  },
							success: function(response) {
								if(response.message)
								{
										html += '<div class="alert alert-success">';
										html += '<a class="close" data-dismiss="alert">&times;</a>';
										html += '<strong>Success!&nbsp;</strong>'+response.message;
										html += '</div>';
										//alert(edit_total_weight);
										//alert(response.add_kra_form);
										if(parseInt(edit_total_weight)==parseInt(100))
										{
											$('#main_content_add_kra').html(response.add_kra_form);
											//alert("hi");
										}
										else
										{
											$('#total_weight').html(new_edit_total_weight);
										}
										//$('#div_edit_all_weight').html('');
										$('td.cls_send_to_apraiser').html('');
										$('#txt_used_kra').val(new_used_kra);
										$('#txt_edit_total_weight').val(new_edit_total_weight);
										$('#edit_total_weight').html(new_edit_total_weight);
										$('tr#editable_'+kra_id).remove();
								}
								else if(response.error_message)
								{
									html += '<div class="alert alert-error">';
									html += '<a class="close" data-dismiss="alert">&times;</a>';
									html += '<strong>Success!</strong> '+data;
									html += '</div>';
								}
								$('#flashmessages').html('');
								$('#flashmessages').append(html);
								hide_message('flashmessages');
							}
			});		
	}
	else
	{
		return false;
	}
}
function update_kra(kra_id,sr_no)
{
	$('#edit_weight_all').attr('disabled','disabled');
	$('#edit_weight_all').css('color','#FFFFFF');
	$('tr#editable_'+kra_id).html('');
	
	var edit_total_weight = $('#txt_edit_total_weight').val();
	var url = '<?php echo site_url("apraisee/updatekra"); ?>';
		var html = '';
 		 $.ajax({
		 			
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							apraisee_kra_id : kra_id
						  },
							success: function(response) {
								if(response.kra_detail)
								{
									html += '<td  style="text-align:center;" class="cls_sr_no" >';
									html +=  sr_no;//+'<input type="hidden" name="edit_kra_id_'+response.kra_detail['apraisee_kra_id']+'" id="edit_kra_id_'+response.kra_detail['apraisee_kra_id']+'" value="'+response.kra_detail['apraisee_kra_id']+'"  />';
									html += '</td>';
									
									html += '<td style="text-align:left;"><textarea class="span10" name="edit_kra_'+response.kra_detail['apraisee_kra_id']+'" id="edit_kra_'+response.kra_detail['apraisee_kra_id']+'" >'+response.kra_detail['key_result_area']+'</textarea></td>';
									html += '<td style="text-align:left;"><textarea class="span10" name="edit_perf_target_'+response.kra_detail['apraisee_kra_id']+'" id="edit_perf_target_'+response.kra_detail['apraisee_kra_id']+'" >'+response.kra_detail['performance_target']+'</textarea></td>';
									html += '<td style="text-align:left;"><textarea class="span10" name="edit_perf_measure_'+response.kra_detail['apraisee_kra_id']+'" id="edit_perf_measure_'+response.kra_detail['apraisee_kra_id']+'" >'+response.kra_detail['performance_measure']+'</textarea></td>';
									html += '<td style="text-align:center;width:20px;" class="cls_display_edit_weight" >';
									html += '<input class="span12" type="hidden"  name="weight_old'+response.kra_detail['apraisee_kra_id']+'"    id="weight_old'+response.kra_detail['apraisee_kra_id']+'" value="'+response.kra_detail['weightage_value']+'"   >';
									html += '<input class="cls_weight_edit span12" type="text"  name="edit_weight_'+response.kra_detail['apraisee_kra_id']+'"    id="edit_weight_'+response.kra_detail['apraisee_kra_id']+'" value="'+response.kra_detail['weightage_value']+'" readonly="readonly"  ><br /><br />';
									html += '</td>';
									html += '<td style="text-align:left;"  ><textarea class="span10" name="edit_initiative_'+response.kra_detail['apraisee_kra_id']+'" id="edit_initiative_'+response.kra_detail['apraisee_kra_id']+'" >'+response.kra_detail['initaitive']+'</textarea></td>';
									//html += '<td style="text-align:left;">'+response.kra_detail['appraiser_name_designation'];
									html += '<td style="text-align:left;">';
									html += response.appraiser;
									html +='</td>';
									html += '<td style="text-align:center;" class="cls_edit_link" ><input type="button" name="upadte" id="update" value="Update" class="btn btn-beoro-3" onclick="updatekradata('+kra_id+','+sr_no+')"  /></td>';
									$('tr#editable_'+kra_id).html(html);
									if(parseInt(edit_total_weight)==parseInt(100))
									{
										$('.cls_send_to_apraiser').html('');
									}
								}
								
								
								}
				});

}


function updatekradata(kra_id,sr_no)
{
	
	$('#edit_weight_all').removeAttr('disabled','disabled');
	$('#edit_weight_all').css('color','#FFFFFF');
	var msg ='Please check for following error. \n';
	var flag =0;
	if(calculate_edit_total())
	 {
	 	var edit_total_weight = $('#txt_edit_total_weight').val();
	 	var key_result_area	= $('#edit_kra_'+kra_id).val();
		var perf_target		= $('#edit_perf_target_'+kra_id).val();
		var perf_measure	= $('#edit_perf_measure_'+kra_id).val();
		var weight			= $('#edit_weight_'+kra_id).val();
		var initiative		= $('#edit_initiative_'+kra_id).val();
		var appraiser_employee_id = $('#appraiser_employee_id_'+kra_id).val();
		
		if(!is_empty('edit_kra_'+kra_id)){
			flag=1;
			msg += 'KRA cannot be empty.\n';
			}
		if(!is_empty('edit_perf_target_'+kra_id)){
				flag=1;
				msg += 'Performance Target cannot be empty.\n';
		}
		if(!is_empty('edit_perf_measure_'+kra_id)){
				flag=1;
				msg += 'Performance Measure cannot be empty.\n';
			}
		if(!is_empty('appraiser_employee_id_'+kra_id)){
			flag=1;
			msg += 'Please Select Appraiser.\n';
		}
		//alert(flag);return false;
		if(flag==1)
		{
			alert(msg);
			return false;
		}
		else
		{
				var html = '';
				$('tr#editable_'+kra_id).html('');
				var net_weight = $('#edit_total_weight').html();
				$('#txt_edit_total_weight').val(net_weight);
				var edit_total_weight = $('#txt_edit_total_weight').val();
				var html1 = '';
					var url = '<?php echo site_url("apraisee/updatekradata"); ?>';
					var html = '';
					 $.ajax({
								
								url: url,
								dataType: 'json',
								type: 'POST',
								data: {
										apraisee_kra_id : kra_id,
										key_result_area : key_result_area,
										perf_target		: perf_target,
										perf_measure	: perf_measure,
										weight			: weight,
										initiative		: initiative,
										appraiser_employee_id :appraiser_employee_id
									  },
										success: function(response) {
												if(response.msg=='Please Try Again.'){ 
																html1 += '<div class="alert alert-error">';
																html1 += '<a class="close" data-dismiss="alert">&times;</a>';
																html1 += '<strong>Error!&nbsp;</strong>'+response.msg;
																html1 += '</div>';
															
														}
														else
														{
															html1 += '<div class="alert alert-success">';
															html1 += '<a class="close" data-dismiss="alert">&times;</a>';
															html1 += '<strong>Success!</strong> '+response.msg;
															html1 += '</div>';
														}
														$('#flashmessages').html('');
														$('#flashmessages').append(html1);
														$("html, body").animate({ scrollTop: 0 }, "slow");
														hide_message('flashmessages');
										
										
											if(response.kra_detail)
											{
												html += '<td  style="text-align:left;weight:1%;" class="cls_sr_no" >';
												html +=  sr_no;
												html += '</td>';
												
												html += '<td style="text-align:left;">'+response.kra_detail['key_result_area']+'</td>';
												html += '<td style="text-align:left;">'+response.kra_detail['performance_target']+'</td>';
												html += '<td style="text-align:left;">'+response.kra_detail['performance_measure']+'</td>';
												html += '<td style="text-align:center;" class="cls_display_edit_weight"  >';
												html += response.kra_detail['weightage_value']+' %';
												html += '<input class="cls_weight_edit span12" type="hidden"  name="edit_weight_'+response.kra_detail['apraisee_kra_id']+'" readonly="readonly"  id="edit_weight_'+response.kra_detail['apraisee_kra_id']+'" value="'+response.kra_detail['weightage_value']+'"   onblur="calculate_edit_total()" ><br /><br />';
												html += '</td>';
												html += '<td style="text-align:left;">'+response.kra_detail['initaitive']+'</td>';
												html += '<td style="text-align:left;">'+response.kra_detail['appraiser_name_designation']+'</td>';
												html += '<td style="text-align:center;" class="cls_edit_link" >';
												html += '<a href="javascript:void(0)" onclick="update_kra(\''+response.kra_detail['apraisee_kra_id']+'\',\''+sr_no+'\')" title="Edit"><i class="icsw16-pencil"></i></a>';
												html += '<a href="javascript:void(0)" onclick="remove_kra(\''+response.kra_detail['apraisee_kra_id']+'\',\''+sr_no+'\')" title="Delete"><i class="icsw16-trashcan"></i></a></td>';
												$('tr#editable_'+kra_id).html(html);
											}
											if(parseInt(edit_total_weight)==parseInt(100))
											{
												$('.cls_send_to_apraiser').html('<input type="button" onclick="send_to_appraiser()" value="Submit To Appraiser for Approval" id="send_to_apraiser" name="send_to_apraiser" class="btn btn-beoro-3 ">');
											}
											}
							});
			}	
				
	 }
	 else
	 {
		//alert("Please check weight! Total weightage must be 100");
		return false;
	 }
	
	
	
	

}

</script>
<script type="text/javascript" >
function send_to_appraiser()
{
	
 	 var used_kra = $('#txt_used_kra').val();
	 var max_kra = $('#max_kra').val();
	 var min_kra = $('#min_kra').val();
	 var time_period_id	= $('#h_time_period_id').val();
	 var edit_total_weight = $('#txt_edit_total_weight').val();
	 var max_weight		= $('#txt_edit_max_weight').val();

	var is_all_appraiser = $('#is_all_appraiser_have_kra').val();
	// alert(max_weight);

	 if(parseInt(used_kra)<parseInt(min_kra))
	 {
	 	alert("Minimum "+min_kra+" KRA Required To Submit ");
		return false;
	 }
	 /*else if(parseInt(used_kra)>parseInt(max_kra))
	 {
	 	alert("Maximum "+max_kra+" KRA can be submited ");
		return false;
	 }*/
	 else if(parseInt(edit_total_weight) < parseInt(max_weight))
	 {
	 	alert("Total weight must be "+max_weight);
		return false;
	 }
	 else if(is_all_appraiser=='N')
	 {
	 	alert("All Appraiser having atleast one KRA");
		return false;
	 }
	 else
	 {
	 	
	 	var t = confirm("Are You Sure?\nYou want to submit KRA to Appraiser. Once submitted it cannot be changed.");
		
		if(t==true)
		{
		$('#div_edit_all_weight').html('');
		var url = '<?php echo site_url("apraisee/sendtoapraiser"); ?>';
		var html = '';
 		 $.ajax({
		 			
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							time_period_id	: time_period_id
						  },
							success: function(response) {
								if(response.msg)
								{
									html += '<div class="alert alert-success">';
									html += '<a class="close" data-dismiss="alert">&times;</a>';
									html += '<strong>Success!</strong> '+response.msg;
									html += '</div>';
								}
								else
								{
									html += '<div class="alert alert-error">';
									html += '<a class="close" data-dismiss="alert">&times;</a>';
									html += '<strong>Error!&nbsp;</strong>'+response.msg;
									html += '</div>';
							    }
									
									$('#flashmessages').html('');
									$('#flashmessages').append(html);
									$("html, body").animate({ scrollTop: 0 }, "slow");
									hide_message('flashmessages');
									var html1= '';
									
									if(response.kra_detail.length > 0 )
									{
										$('#edit_kra_id').html('');
										
										$('#kra_buttons').hide('');
									var total_wet = 0;
									html1 += '<table class="table invE_table table-bordered" id="kra_id" >';
									html1 += '<thead>';
									html1 += '<tr>';
									html1 += '<th style="text-align:left; width:1%;" >Sr. No. </th>';
									html1 += '<th style="text-align:left;">Key Result Area </th>';
									html1 += '<th style="text-align:left;">Performance Target</th>';
									html1 += '<th style="text-align:left;" >Performance Measure</th>';
									html1 += '<th style="text-align:left; width:20px;">Weightage %</th>';
									html1 += '<th style="text-align:left;">Initiative</th>';
									html1 += '<th style="text-align:left;">Appraiser Name</th>';
									html1 += '</tr>';
									html1 += '</thead>';
									html1 += '<tbody id="kra_detail">';
									
									for(var i=0; i<response.kra_detail.length; i++)
									{
										var j= parseInt(i) + 1;
										html1 += '<tr >'
										html1 += '<td style="text-align:left;">'+j+'</td>';
										html1 += '<td style="text-align:left;">'+response.kra_detail[i]['key_result_area']+'</td>';
										html1 += '<td style="text-align:left;">'+response.kra_detail[i]['performance_target']+'</td>';
										html1 += '<td style="text-align:left;">'+response.kra_detail[i]['performance_measure']+'</td>';
										html1 += '<td style="text-align:center;width:20px;">';
										html1 += response.kra_detail[i]['weightage_value'];
										html1 += '</td>';
										html1 += '<td style="text-align:left;">'+response.kra_detail[i]['initaitive']+'</td>';
										html1 += '<td style="text-align:left;">'+response.kra_detail[i]['appraiser_name_designation']+' (';
										//alert(response.kra_detail[i]['apraisee_kra_approve_status']);
										if(parseInt(response.kra_detail[i]['apraisee_kra_approve_status'])==parseInt(1))
										{
										 	html1 += 'Pending';
										}
										else if(parseInt(response.kra_detail[i]['apraisee_kra_approve_status'])==parseInt(2))
										{
										  	html1 += 'Approved';
										}
										else if(parseInt(response.kra_detail[i]['apraisee_kra_approve_status'])==parseInt(0))
										{
										  	html1 += 'Not Approved';
										}
										html1 += ' ) </td>';
										html1 += '</tr>';
										if(total_wet==0)
										{
											total_wet = response.kra_detail[i]['weightage_value'];
										}
										else
										{
											total_wet = parseInt(total_wet) + parseInt(response.kra_detail[i]['weightage_value']);
										}
									}
									html1 += '<tr class="last_row">';
									html1 += '<td colspan="4" style="text-align:right"><b>Total:</b></td>';
									html1 += '<td style="text-align:center; font-weight:bold;"><span id="total_weight">'+total_wet+' %</span></td>';
									html1 += '<td style="text-align:center" colspan="2" >&nbsp;</td>';
							    	html1 += '</tr>';
									html1 += '</tbody>';
									html1 += '</html>';
									$('#content_edit_kra').html('');
									$('#content_edit_kra').after(html1);
									//$('#note_for_kra').html('');
								}
							}
				});
				
		}
		else
		{
			return false;
		}
		
		
	 }


}
</script>
<!---------- Start KRA EDIT Only Weight ------------------------------------------------->
<script type="text/javascript">
function call_edit_all_weight()
{
	$('#edit_appraiser').attr('disabled','disabled');
	$('#edit_appraiser').css('color','#FFFFFF');
	$('#edit_kra_detail tr').each(function() {
				var weight = $(this).find(".cls_weight_edit").val();
				var weight_id = $(this).find(".cls_weight_edit").attr('id');
				if(weight_id!='' && weight_id!=undefined && weight!='' && weight!=undefined)
				{
						var kra_id = weight_id.split('weight_');
						var html = '<input class="cls_edit_all_weight" type="text"  name="txt_upadte_all_weight_'+kra_id[1]+'" id="txt_upadte_all_weight_'+kra_id[1]+'" value="'+weight+'" onchange="calculate_update_all_weight()" />';
						$(this).find(".cls_display_edit_weight").html(html);
						$(this).find(".cls_edit_link").html('');
						
				}
				$(this).find(".cls_send_to_apraiser").html('');
				$(this).find(".cls_send_to_apraiser").html('<input type="button" class="btn btn-beoro-3" name="upadte_all_weight" id="upadte_all_weight" value="Update" onclick="call_add_all_weight()" />');
				//$(this).find(".last_row").after("<tr><td colspan='8' style='text-align:center;' >dhgfdhgj</td></tr>");
	});

}

function call_edit_all_appraiser()
{
	$('#edit_weight_all').attr('disabled','disabled');
	$('#edit_weight_all').css('color','#FFFFFF');
	var time_period_id	= $('#h_time_period_id').val();
	var url = '<?php echo site_url("apraisee/update_appraiser"); ?>';
	var html = '';
	 $.ajax({
				
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
						time_period_id : time_period_id
					  },
						success: function(response) {
							//alert(response.html);
							$('#edit_kra_detail').html(response.html);
						}
		});
}

function update_data_edit_all_appraiser()
{
	
	var time_period_id	= $('#h_time_period_id').val();
	var all_appraiser = [];
	var all_appraiser_id = [];
	var flag=0;
	$('#edit_kra_detail tr').each(function() {
					var appraiser = $(this).find(".cls_edit_appraiser").val();
					var appraiser_id = $(this).find(".cls_edit_appraiser").attr('id');
					if(appraiser!=undefined)
					{
						if(appraiser=='')
						{
							flag=1;
						}
							all_appraiser.push(appraiser);
							all_appraiser_id.push(appraiser_id);
				    }
		});
		if(flag==1)
		{
			alert("Please select Appraiser");
			return false;
		}
		else
		{
			var url = '<?php echo site_url("apraisee/update_all_appraiser_data"); ?>';
			var html = '';
			 $.ajax({
						
						url: url,
						dataType: 'json',
						type: 'POST',
						data: {
								time_period_id : time_period_id,
								all_appraiser :all_appraiser,
								all_appraiser_id : all_appraiser_id
							  },
								success: function(response) {
									//alert(response.html);
									if(response.status==1)
									{
										alert("Each Appraiser must have Minimum 1 (one) KRA.");
										return false;
									}
									else
									{	
										$('#edit_weight_all').removeAttr('disabled','disabled');
										html += '<div class="alert alert-success">';
										html += '<a class="close" data-dismiss="alert">&times;</a>';
										html += '<strong>Success!</strong> Appraisers modified successfully. ';
										html += '</div>';
										$('#flashmessages').html(html);
										$('#edit_kra_detail').html(response.html);
										hide_message('flashmessages');
									}
									
								}
				});
			return false;
		}
	
}
function calculate_update_all_weight()
{
	var  total_weight = '';
	var max_weight		= $('#txt_edit_max_weight').val();
	var edit_total_weight = $('#txt_edit_total_weight').val();
	var new_weight = 0;
	if(edit_total_weight=='' || edit_total_weight==undefined)
	{
		edit_total_weight = 0;
	}

	var flag = 0 ;
	
	$('#edit_kra_detail tr').each(function() {
					var weightage = $(this).find(".cls_edit_all_weight").val();
					
					if(weightage!=undefined)
					{
						//alert(weightage);
						
						if(isNaN(weightage) || weightage<0)
						{ 
							var total = 0;
						}
						else
						{
								var total = (parseFloat(weightage));
								if(total_weight=='')
								{
									 if(!isNaN(total) && total!=undefined)
									 {
										total_weight = total;
									 }
								}
								else
								{
										if(!isNaN(total) && total!=undefined)
										 {
											 total_weight = parseFloat(total_weight) + parseFloat(total);
										 }
							
							   }
						}
						
					}
				});
				var net_weight = parseInt(total_weight);
			
				if(isNaN(net_weight) || net_weight==undefined)
				{
					net_weight = 0;
				}
				
				if(parseFloat(net_weight) > parseInt(max_weight))
				{
			
					alert("Weight can not grater than"+max_weight);
					return  false;
				}
				/*else if(parseFloat(net_weight) < parseInt(max_weight))
				{
			
					alert("Weight can not less than"+max_weight);
					return  false;
				}*/
				else
				{
					$('#edit_total_weight').html(net_weight);
					return true;
				}

}

function call_add_all_weight()
{
	if(calculate_update_all_weight())
	{
		var flag  = 0;
		var flag1 = 0;
		var flag2 = 0;
		 var min_weightage = $('#min_weightage').val();
		 var max_weighatge = $('#max_weightage').val();
		$('#edit_kra_detail tr').each(function() {
					var weightage = $(this).find(".cls_edit_all_weight").val();
					weightage_id = $(this).find(".cls_edit_all_weight").attr('id');
					
							if(weightage=='')
							{
								flag =1;
							}
						
						if(flag==0 && weightage_id!=undefined)
						{
							if(!isnumeric(weightage_id))
							{
								flag1 = 1;
							}
						}
						if((parseInt(weightage)<parseInt(min_weightage)) || (parseInt(weightage)>parseInt(max_weighatge)))
						{
								flag2 = 1;
						}
					});
					//alert(flag);alert(flag1);
					if(flag==1 || flag1==1)
					{
						alert("Weightage shoule be numberic (1,2,3 etc.) and cannot be empty.\n");
						return false;
					}
					else if(flag2==1)
					{
						alert("Weightage should not be less than "+parseInt(min_weightage)+" and greater than "+parseInt(max_weighatge));
						return false;
					}
					else
					{
						
								var max_weight		= $('#txt_edit_max_weight').val();
								var total_weight 	= $('#edit_total_weight').html();
								var used_kra        = $('#txt_used_kra').val();
								var min_kra 		= $('#min_kra').val();
								var edit_total_weight = $('#txt_edit_total_weight').val();
								var temp_total_weight = 0;
							
								/*if(total_weight!=max_weight)
								{
									alert("Weight can nit less than"+max_weight);
									return false;
								}
								else
								{*/
								var flag =0 ;
								var add_kra_content = $('#main_content_add_kra').html();
								
								
									var all_weight = [];
									
									$('#edit_kra_detail tr').each(function() {
												var weight = $(this).find(".cls_edit_all_weight").val();
												var weight_id = $(this).find(".cls_edit_all_weight").attr('id');
												if(weight_id!='' && weight_id!=undefined && weight!='' && weight!=undefined)
												{
														var kra_id = weight_id.split('txt_upadte_all_weight_');
														all_weight[kra_id[1]] = weight;
														if(parseInt(temp_total_weight)==0)
														{
															temp_total_weight = parseInt(weight);
														}
														else
														{
															temp_total_weight = parseInt(temp_total_weight)+parseInt(weight);
														}
												}
												//alert(total_weight);
												
										
									});
									
									if(isNaN(temp_total_weight))
												{
													temp_total_weight = 0;
												}
										$('#txt_edit_total_weight').val(parseInt(temp_total_weight));
										$('#total_weight').html(parseInt(temp_total_weight));
									 if(parseInt(temp_total_weight)==parseInt(max_weight))
									 {
										if(parseInt(used_kra)<parseInt(min_kra))
										{
											flag=1;
											alert("Minimum KRA should be "+min_kra+" For Total: "+max_weight);
											return false;
										}
									 }
									 
									if(parseInt(flag)==0)
									{
										if(parseInt(temp_total_weight)==parseInt(max_weight))
										 {
											$('#main_content_add_kra').html('');
										 }
										 var time_period_id =  $('#h_time_period_id').val();
									var url = '<?php echo site_url("apraisee/update_all_weight"); ?>';
									var html = '';
									var html1= '';
									 $.ajax({
												
												url: url,
												dataType: 'json',
												type: 'POST',
												data: {
														kras_weight : all_weight,
														max_weight : max_weight,
														time_period_id : time_period_id
													  },
														success: function(response) {
															if(response.msg=='Please Try Again.'){ 
																			html1 += '<div class="alert alert-error">';
																			html1 += '<a class="close" data-dismiss="alert">&times;</a>';
																			html1 += '<strong>Error!&nbsp;</strong>'+response.msg;
																			html1 += '</div>';
																	}
																	else
																	{
																		$('#edit_appraiser').removeAttr('disabled','disabled');
																		html1 += '<div class="alert alert-success">';
																		html1 += '<a class="close" data-dismiss="alert">&times;</a>';
																		html1 += '<strong>Success!</strong> '+response.msg;
																		html1 += '</div>';
																		
																						if(parseInt(edit_total_weight)==parseInt(max_weight))
																						{
																							if(parseInt(temp_total_weight)<parseInt(max_weight))
																							{
																							//if now cjange total weight is less than max weught than
																							//display add kra form
																							$('#main_content_add_kra').html('');
																							$('#main_content_add_kra').html('<br><br>');
																							$('#main_content_add_kra').append(response.add_kra_form);
																							}
																						}
																		$('#edit_kra_detail tr').each(function() {
																		
																						var weight_new = $(this).find(".cls_edit_all_weight").val();
																						var weight_id_new = $(this).find(".cls_edit_all_weight").attr('id');
																						var sr_no = $(this).find(".cls_sr_no").html();
																						if(weight_id_new!='' && weight_id_new!=undefined && weight_new!='' && weight_new!=undefined)
																						{
																								var kra_id = weight_id_new.split('txt_upadte_all_weight_');
																								var html = weight_new+' %';
																								html += '<input class="cls_weight_edit span12" type="hidden"  name="edit_weight_'+kra_id[1]+'" readonly="readonly"   id="edit_weight_'+kra_id[1]+'" value="'+weight_new+'"   / >';
																								$(this).find(".cls_display_edit_weight").html(html);
																								$(this).find(".cls_edit_link").html('<a  href="javascript:void(0)" onclick="update_kra(\''+kra_id[1]+'\',\''+parseInt(sr_no)+'\')" title="Edit" ><i class="icsw16-pencil"></i></a><a  href="javascript:void(0)" onclick="remove_kra(\''+kra_id[1]+'\',\''+parseInt(sr_no)+'\')" title="Delete" ><i class="icsw16-trashcan"></i></a>');
																						}
																						
																			});
																			
																			$(".cls_send_to_apraiser").html('');
																			var new_total_weight 	= $('#edit_total_weight').html();
																			var remaining_weight = parseInt(100)-parseInt(new_total_weight);
																			
																			$('#add_weight_1').attr('title','Remaining Weightage : '+remaining_weight);
																			if(parseInt(new_total_weight)==parseInt(max_weight))
																			{
																				$(".cls_send_to_apraiser").html('<input  type="button" class="btn btn-beoro-3 " name="send_to_apraiser" id="send_to_apraiser" value="Submit To Appraiser for Approval" onclick="send_to_appraiser()"  />');
																			}
																	}
																	$('#flashmessages').html('');
																	$('#flashmessages').append(html1);
																	$("html, body").animate({ scrollTop: 0 }, "slow");
																	hide_message('flashmessages');
														}
											});
								}
				}
		}
		else
		{
			return false;
		}
	//alert(all_weight);
}
hide_message('flashmessages');
</script>
<!---------- End KRA EDIT Only Weight ------------------------------------------------->
<?php echo $last_footer; ?>