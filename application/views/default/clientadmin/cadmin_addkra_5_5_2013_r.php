<?php echo $header; ?>
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

/*! jQuery UI - v1.10.1 - 2013-02-26
* http://jqueryui.com
* Includes: jquery.ui.core.css, jquery.ui.autocomplete.css, jquery.ui.menu.css
* To view and modify this theme, visit http://jqueryui.com/themeroller/?ffDefault=Trebuchet%20MS%2CTahoma%2CVerdana%2CArial%2Csans-serif&fwDefault=bold&fsDefault=1.1em&cornerRadius=4px&bgColorHeader=f6a828&bgTextureHeader=gloss_wave&bgImgOpacityHeader=35&borderColorHeader=e78f08&fcHeader=ffffff&iconColorHeader=ffffff&bgColorContent=eeeeee&bgTextureContent=highlight_soft&bgImgOpacityContent=100&borderColorContent=dddddd&fcContent=333333&iconColorContent=222222&bgColorDefault=f6f6f6&bgTextureDefault=glass&bgImgOpacityDefault=100&borderColorDefault=cccccc&fcDefault=1c94c4&iconColorDefault=ef8c08&bgColorHover=fdf5ce&bgTextureHover=glass&bgImgOpacityHover=100&borderColorHover=fbcb09&fcHover=c77405&iconColorHover=ef8c08&bgColorActive=ffffff&bgTextureActive=glass&bgImgOpacityActive=65&borderColorActive=fbd850&fcActive=eb8f00&iconColorActive=ef8c08&bgColorHighlight=ffe45c&bgTextureHighlight=highlight_soft&bgImgOpacityHighlight=75&borderColorHighlight=fed22f&fcHighlight=363636&iconColorHighlight=228ef1&bgColorError=b81900&bgTextureError=diagonals_thick&bgImgOpacityError=18&borderColorError=cd0a0a&fcError=ffffff&iconColorError=ffd27a&bgColorOverlay=666666&bgTextureOverlay=diagonals_thick&bgImgOpacityOverlay=20&opacityOverlay=50&bgColorShadow=000000&bgTextureShadow=flat&bgImgOpacityShadow=10&opacityShadow=20&thicknessShadow=5px&offsetTopShadow=-5px&offsetLeftShadow=-5px&cornerRadiusShadow=5px
* Copyright (c) 2013 jQuery Foundation and other contributors Licensed MIT */

/* Layout helpers
----------------------------------*/
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
	  <input type="hidden" name="txt_used_kra" id="txt_used_kra" value="<?php if(isset($used_kra)){ echo $used_kra;  } ?>"  />
	  <input type="hidden" name="txt_edit_total_weight" id="txt_edit_total_weight" value="<?php if(isset($edit_total_weight)) { echo $edit_total_weight; }?>"  />
	  <input type="hidden" name="txt_edit_max_weight" id="txt_edit_max_weight" value="<?php if(isset($max_weight_for_edit)) { echo $max_weight_for_edit; }?>"  />
	  
	  
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
	 <?php
		  //Get Years From and To
		  $this->load->model('taskschedulemodel');
		  $result_year = $this->taskschedulemodel->getTimeperiodById(1);
		  $display_year = '[' . $result_year->time_period_from . ' - ' . $result_year->time_period_to . ']';
	 ?>

      <div class="w-box-header">
			<h4>My KRA <?php echo $display_year; ?></h4>
      </div>
		
      <form action="" method="post" id="add_kra">
	  <input type="hidden" name="h_time_period_id" id="h_time_period_id" value="<?=$time_period_id;?>"  />
	 
        <div class="w-box-content cnt_b" >  
          <div class="row-fluid">
            <div class="span12">
			
				
				
				<?php // if(!isset($error))
				  //{
				  ?>
				<!--  <div class="alert alert-info">
                                    <a class="close" data-dismiss="alert">&times;</a>
                                    <strong>Section A: KRA ASSESSMENT - &nbsp;</strong> 
									Briefly describe performance/achievements during the assessment periods. It is important for the 
									appraiser to enter his/her comments to substantiate the ratings. 
									Your weightage% sum must equal to 100. Please Fill up The following Form and Add KRA
		
                  </div>-->
				  <?php
				 // }
				  ?>
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
											echo " Response Awaiting From: "."&nbsp;".$appraiser_name_info;
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
				 
				   if(!isset($error))
				  {
				  	if(isset($edit_kra_detail))
					{
						if(!empty($edit_kra_detail))
						{
				
				  ?>
				  <div id="div_edit_all_weight">
				  <?php
				  if(($used_kra >= $min_kra) && ($edit_total_weight==$max_weight_for_edit))
						{
						?>
				 <input type="button" value="Edit Weightages" id="edit_weight_all" name="edit_weight_all" class="btn btn-beoro-3" onclick="call_edit_all_weight()"   />
				 
				 <br /> <br />
				 <?php } ?>
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
							<a  href="javascript:void(0)" onclick="update_kra('<?=$valekr['apraisee_kra_id']?>','<?=$keyekr+1?>')"  ><i class="icsw16-pencil"></i></a>&nbsp;
							<a  href="javascript:void(0)" onclick="remove_kra('<?=$valekr['apraisee_kra_id']?>','<?=$keyekr+1?>')"  ><i class="icsw16-trashcan"></i></a>
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
								<td colspan="8" style="text-align:center" class="cls_send_to_apraiser"><input  type="button" class="btn btn-beoro-3 " name="send_to_apraiser" id="send_to_apraiser" value="Send To Appraiser" onclick="send_to_appraiser()"  /></td>
					    </tr>
						<?php 
						}
						?>
						
					<?php
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
											<th style="text-align:left; width:1%;" >Sr. No. </th>
											
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
										<td style="text-align:left;"><?php  echo $val['performance_target']; ?></td>
										<td style="text-align:left;"><?php  echo $val['performance_measure']; ?></td>
										<td style="text-align:center;width:20px;"><?php  echo $val['weightage_value'].'%'; ?></td>
										<td style="text-align:left;"><?php  echo $val['initaitive']; ?></td>
										<td style="text-align:left;"><?=$val['appraiser_name_designation'] . '  (' . ( $val['apraisee_kra_approve_status'] == 1 ? 'Not Approve' : 'Approved' ) . ')'; ?></td>
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
							
								if($used_kra < $max_kra && (($edit_total_weight < $max_weight_for_edit))) 
								{
								?>
								<br /><br />
				<div id="main_content_add_kra" >
					<div class="w-box-header" style=" background: none repeat scroll 0 0 #EFF7EC;color:#000000;font-size: 13px;height: 32px;line-height: 32px;padding: 0 10px 1px;border-color: #CCCCCC;border-style: solid;border-width: 1px 1px 1px 1px;">
					<h4>Add Kra</h4>
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
                                        <label class="span3 req">Performance Traget: </label>
                                        <textarea class="span8" name="perf_target[]" id="perf_target_<?php echo $i; ?>"></textarea>
                                    </div>
									<div class="formSep">
                                        <label class="span3 req">Performance Measure: </label>
                                        <textarea class="span8" name="perf_measure[]" id="perf_measure_<?php echo $i; ?>"  ></textarea>
                                    </div>
									<div class="formSep">
                                        <label class="span3 req">Weight: </label>
                                        <input class="cls_weight span3" type="text"  name="weight[]"    id="add_weight_<?php echo $i; ?>"   onblur="calculate_total()" value=""  />
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
								if($used_kra< $max_kra && (($edit_total_weight<100))) 
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
$(document).ready(function() {

	var t = '';
    $("#add_kra").submit(function() {
	
	 var used_kra = $('#txt_used_kra').val();
	 var max_kra = $('#max_kra').val();
	 //alert(max_kra);alert(used_kra);
	 var min_kra = $('#min_kra').val();
	 var time_period_id	= $('#h_time_period_id').val();
	 var edit_total_weight = $('#txt_edit_total_weight').val();
	 var weight	= $('#add_weight_1').val();
	 
	 var new_total_kra = (parseInt(used_kra)+1);
	 
	 if(weight=='' || weight==undefined)
	 {
		 weight=0;
	 }
	 var new_weight = parseInt(edit_total_weight) + parseInt(weight);
	
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
	 else if(parseInt(new_weight)>100)
	 {
	 	alert("Total Weight can not greater than 100.");
		return false;
	 }
	 else if(parseInt(used_kra)==6 && parseInt(new_weight) < 100)
	 {
	 	alert("Total Weight can not less than 100.");
		return false;
	 }
	 else
	{
		t=true;
		  //t = confirm("Are You sure You want to Submit KRA Form");
	}
	 /*else if((new_total_kra<parseInt(min_kra)) && parseInt(new_weight)>=100)
	 {
	 	alert("You have to add Minimum "+min_kra+"");
	 }*/
	
	
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
										html += '<th style="text-align:left; width:20px;">Weightage %</th>';
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
										html += '<td style="text-align:left;width:20px;">'+response.kra_detail[i]['initaitive']+'</td>';
										html += '<td style="text-align:left;">'+response.kra_detail[i]['appraiser_name_designation']+'</td>';
										html += '<td style="text-align:center;" class="cls_edit_link">';
										html += '<a href="javascript:void(0)" onclick="update_kra(\''+response.kra_detail[i]['apraisee_kra_id']+'\',\''+j+'\')" ><i class="icsw16-pencil"></i></a>&nbsp;';
										html += '<a href="javascript:void(0)" onclick="remove_kra(\''+response.kra_detail[i]['apraisee_kra_id']+'\',\''+j+'\')"  ><i class="icsw16-trashcan"></i></a></td>';
										
										html += '</tr>';
									}
									
									html += '<tr class="last_row">';
									html += '<td colspan="4" style="text-align:right"><b>Total:</b></td>';
									html += '<td style="text-align:center; font-weight:bold;"><span id="edit_total_weight">'+response.edit_total_weight+'</span> %</td>';
									html += '<td colspan="3" style="text-align:center">&nbsp;</td>';
					    			html += '</tr>';
									
									if(parseInt(response.kra_detail.length)>=parseInt(min_kra) && (parseInt(response.edit_total_weight)>=parseInt(100)) )
									{
										html += '<tr>';
										html += '<td colspan="8" style="text-align:center" class="cls_send_to_apraiser"><input type="button" class="btn btn-beoro-3 " name="send_to_apraiser" id="send_to_apraiser" value="Send To Appraiser" onclick="send_to_appraiser()" /></td>';
					    				html += '</tr>';
										//$('#div_kra_detail').html('');
										$('#main_content_add_kra').html('');
									}
									if (!($('tbody#edit_kra_detail').length > 0))
									{
										html += '</tbody>';
										html += '</table>';
										$('#content_edit_kra').html(html);
									}
									else if(html!='')
									{
										$("tbody#edit_kra_detail").html(html);
									}
									
									if(parseInt(response.kra_detail.length)>=parseInt(min_kra) && (parseInt(response.edit_total_weight)>=parseInt(100)) )
									{
										var html2 = '';
										html2 +=' <input type="button" value="Edit Weightages" id="edit_weight_all" name="edit_weight_all" class="btn btn-beoro-3" onclick="call_edit_all_weight()"   /><br><br>';
										$('#div_edit_all_weight').html(html2);
									}
									
									//$("tbody#kra_detail").html(html);
									if(response.kra_detail.length>=7)
									{
										$('#div_kra_detail').html('');
										$('#kra_buttons').hide();
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
										html += '<strong>Error!&nbsp;</strong>'+response.message;
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
										$('#div_edit_all_weight').html('');
										$('td.cls_send_to_apraiser').remove();
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
									html += '<td style="text-align:left;">'+response.kra_detail['appraiser_name_designation']+'</td>';
									html += '<td style="text-align:center;" class="cls_edit_link" ><input type="button" name="upadte" id="update" value="Update" class="btn btn-beoro-3" onclick="updatekradata('+kra_id+','+sr_no+')"  /></td>';
									$('tr#editable_'+kra_id).html(html);
								}
								
								
								}
				});

}


function updatekradata(kra_id,sr_no)
{
	
	$('#edit_weight_all').removeAttr('disabled','disabled');
	$('#edit_weight_all').css('color','#FFFFFF');
	if(calculate_edit_total())
	 {
	 
	 	var key_result_area	= $('#edit_kra_'+kra_id).val();
	var perf_target		= $('#edit_perf_target_'+kra_id).val();
	var perf_measure	= $('#edit_perf_measure_'+kra_id).val();
	var weight			= $('#edit_weight_'+kra_id).val();
	var initiative		= $('#edit_initiative_'+kra_id).val();
	
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
							initiative		: initiative
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
									html += '<a href="javascript:void(0)" onclick="update_kra(\''+response.kra_detail['apraisee_kra_id']+'\',\''+sr_no+'\')" ><i class="icsw16-pencil"></i></a>';
									html += '<a href="javascript:void(0)" onclick="remove_kra(\''+response.kra_detail['apraisee_kra_id']+'\',\''+sr_no+'\')" ><i class="icsw16-trashcan"></i></a></td>';
									$('tr#editable_'+kra_id).html(html);
								}
								
								}
				});
				
				
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
	 else
	 {
	 	var t = confirm("Are You Sure You want to Submit KRA To Appraiser. Once submitted Can Not Change");
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
										if(parseInt(response.kra_detail[i]['apraisee_kra_approve_status'])==parseInt(1))
										{
										 	html1 += 'Not Approve';
										}
										else
										{
										  	html1 += 'Approved';
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
	});

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
		var max_weight		= $('#txt_edit_max_weight').val();
		var total_weight 	= $('#edit_total_weight').html();
		if(total_weight!=max_weight)
		{
			alert("Weight can nit less than"+max_weight);
			return false;
		}
		else
		{
			var all_weight = [];
			$('#edit_kra_detail tr').each(function() {
						var weight = $(this).find(".cls_edit_all_weight").val();
						var weight_id = $(this).find(".cls_edit_all_weight").attr('id');
						
						if(weight_id!='' && weight_id!=undefined && weight!='' && weight!=undefined)
						{
								var kra_id = weight_id.split('txt_upadte_all_weight_');
								all_weight[kra_id[1]] = weight;
						}
					
			});
			var url = '<?php echo site_url("apraisee/update_all_weight"); ?>';
			var html = '';
			var html1= '';
			 $.ajax({
						
						url: url,
						dataType: 'json',
						type: 'POST',
						data: {
								kras_weight : all_weight
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
																		$(this).find(".cls_edit_link").html('<a  href="javascript:void(0)" onclick="update_kra(\''+kra_id[1]+'\',\''+parseInt(sr_no)+'\')"  ><i class="icsw16-pencil"></i></a><a  href="javascript:void(0)" onclick="remove_kra(\''+kra_id[1]+'\',\''+parseInt(sr_no)+'\')"  ><i class="icsw16-trashcan"></i></a>');
																		
																}
																$(this).find(".cls_send_to_apraiser").html('');
																$(this).find(".cls_send_to_apraiser").html('<input  type="button" class="btn btn-beoro-3 " name="send_to_apraiser" id="send_to_apraiser" value="Send To Appraiser" onclick="send_to_appraiser()"  />');
													});
											}
											$('#flashmessages').html('');
											$('#flashmessages').append(html1);
											$("html, body").animate({ scrollTop: 0 }, "slow");
								
								
								
								}
					});
		}
	}
	else
	{
		return false;
	}
	//alert(all_weight);
}
</script>
<!---------- End KRA EDIT Only Weight ------------------------------------------------->
<?php echo $last_footer; ?>