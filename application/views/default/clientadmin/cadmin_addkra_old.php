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
						<td valign="top" colspan="2"><strong>
					    <?php if($top_employee_apraiser_detail['apraiser_name']) {echo $top_employee_apraiser_detail['apraiser_name']; ?>
					    <br /></strong><em>
					    <?php } echo $top_employee_apraiser_detail['apraiser_designation']; ?>	</em>					
					    </td>
						
						<td valign="top" >Name &amp; Designation <br />
					    of Reviewer:</td>
						<td valign="top" style="text-align:left;" colspan="2" >
							<strong>
							<?php if($top_employee_apraiser_detail['reviewer_name']) { echo $top_employee_apraiser_detail['reviewer_name']; ?>
							<br /></strong><em>
							<?php } echo $top_employee_apraiser_detail['reviewer_designation']; ?>						
							</em></td>
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
	 
        <div class="w-box-content cnt_b">  
          <div class="row-fluid">
            <div class="span12">
			
				
				
				<?php if(!isset($error))
				  {
				  ?>
				  <div class="alert alert-info">
                                    <a class="close" data-dismiss="alert">&times;</a>
                                    <strong>Section A:KRA ASSESSMENT - &nbsp;</strong> 
									Breifly describe performance/achivements during the assessment periods. Please use a seprate sheet if space is not adequate. It is important for the 
									appraisar to enter his.her comments to substaintiate the ratings. 
									Your weightage% sum must equal to 100.Please Fill up The following Form
		
                  </div>
				  <?php
				  }
				  ?>
				   <div id="flashmessages" >
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
              <div class="tabbable tabbable-bordered">
                    <div class="w-box w-box-green" id="invoice_add_edit">
                    <div class="span12">
					<?php
				 
				   if(!isset($error))
				  {
				  ?>
			   			 <table class="table invE_table table-bordered" id="kra_id" >
							<thead>
								<tr>
									<th style="text-align:left; width:1%;" >Sr. No. </th>
									<th style="text-align:left;">Key Result Area </th>
									<th style="text-align:left;">Performance Target</th>
									<th style="text-align:left;" >Performance Measure</th>
									<th style="text-align:left; width:20px;">Weightage %</th>
									<th style="text-align:left;">Initiative</th>
								</tr>
							</thead>
						<tbody id="kra_detail">
							<?php 
							if(isset($kra_detail))
							{
								if(!empty($kra_detail))
								{
									$i=0;
									foreach($kra_detail as $key=>$val)
									{
										$j= $i+1;
										
									?>
										<tr style="<?php //echo $bgcolor; ?>">
										<td  style="text-align:center;">
									<?php echo $j; ?>
										</td>
										<td style="text-align:left;"><?php echo $val['key_result_area']; ?></td>
										<td style="text-align:left;"><?php  echo $val['performance_target']; ?></td>
										<td style="text-align:left;"><?php  echo $val['performance_measure']; ?></td>
										<td style="text-align:center;width:20px;"><?php  echo $val['weightage_value'].'%'; ?></td>
										<td style="text-align:left;"><?php  echo $val['initaitive']; ?></td>
									   </tr>
									<?php
									$i++;
									} 
								}
							}
							else
							{
								
								for($i=0;$i<5;$i++)
								{
								$j= $i+1;
								
								if($i==0)
								{
								$clas_r= 'class="kra_row"';
								}
								else
								{
								$clas_r='';
								}
								?>
								<tr <?php echo $clas_r; ?> >
							
								<td class="kra_clone_row" style="text-align:center;">
								<?php if($i==4){ ?>
								<i class="icon-plus inv_clone_btn"></i>
								<?php } ?>
								<?php echo $j; ?></td>
								<td style="text-align:center;"><textarea class="span10" name="kra[]" id="kra_<?php echo $i; ?>" ></textarea></td>
								<td style="text-align:center;"><textarea class="span10" name="perf_target[]" id="perf_target_<?php echo $i; ?>" ></textarea></td>
								<td style="text-align:center;"><textarea class="span10" name="perf_measure[]" id="perf_measure_<?php echo $i; ?>" ></textarea></td>
								<td style="text-align:left;width:20px;">
								<input class="cls_weight" type="text"  name="weight[]"    id="weight_<?php echo $i; ?>"  class="span12" onblur="calculate_total()" ><br /><br />
									<!--<input type="text"  name="weightage_id[]" id="weightage_id[]" value=""  />-->
									
								</td>
								<td style="text-align:center;"><textarea class="span10" name="initiative[]" id="initiative_<?php echo $i; ?>" ></textarea></td>
							</tr>
						<?php
						} 
						?>
					
								<?php
							}
								?>
							 <tr class="last_row">
										<td colspan="4" style="text-align:right"><b>Total:</b></td>
										<td style="text-align:center; font-weight:bold;"><span id="total_weight"><?php echo $total_weight; ?> %</span></td>
										<td style="text-align:center">&nbsp;</td>
							</tr>
						</tbody>	
                        </table>
                        <?php if(!isset($kra_detail))
							{
							?>
						<div class="formSep" id="kra_buttons" style="display:;">
            			<div align="center">
                        <input type="submit" name="submit" value="Submit" id="submit" class="btn btn-beoro-3" onclick="calculate_total();">
                        <input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
                      </div>
					  </div>
					  <?php } ?>
                  
		<?php } ?>
						
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
});*/
 


</script>
<script type="text/javascript" >
$(document).ready(function() {

     $("#add_kra").submit(function() {
	 var t = confirm("Are You sure You want to Submit KRA Form");
	
	if(t==true)
	 {
	  if(calculate_total())
		 {
		 	alert("hi");
		 }
		 else
		 {
		 	alert("Please check weight! Total weightage must be 100");
			return false;
		 }
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
				$('#flashmessages').after(html);
				$("html, body").animate({ scrollTop: 0 }, "slow");
				
				//display pms
		var url = '<?php echo site_url("apraisee/getkradetail"); ?>';
		var html = '';
 		 $.ajax({
		 			
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
							
						  },
							success: function(response) {
								if(response.kra_detail.length > 0 )
								{
									
									for(var i=0; i<response.kra_detail.length; i++)
									{
										var j= parseInt(i) + 1;
										
										
									
										html += '<tr class="inv_row" >';
										html += '<td style="text-align:center;">'+j+'</td>';
										html += '<td style="text-align:left; width:160px;">'+response.kra_detail[i]['key_result_area']+'</td>';
										html += '<td style="text-align:left;width:160px;">'+response.kra_detail[i]['performance_target']+'</td>';
										html += '<td style="text-align:left;width:100px;">'+response.kra_detail[i]['performance_measure']+'</td>';
										html += '<td style="text-align:center;width:10px;">'+response.kra_detail[i]['weightage_value']+'% </td>';
										html += '<td style="text-align:left;">'+response.kra_detail[i]['initaitive']+'</td>';
										html += '</tr>';
									}
									if(html!='')
									{
									$("tbody#kra_detail").html(html);
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
var flag = 0 ;
	$('#kra_id tr').each(function() {
					var weightage = $(this).find(".cls_weight").val();
					
					
					if(weightage!=undefined){
						if(isNaN(weightage) || weightage<0)
						{ 
							var total = 0;
						}
						else{
						var total = (parseFloat(weightage));
						
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
				});
				
				$('#total_weight').html('');
				$('#total_weight').html(total_weight+' %');
				if(parseFloat(total_weight)!=100)
				{
					return  false;
				}
				else
				{
					//alert("false");
					return true;
				}
				
				//$('#final_score').html(parseFloat(final_score).toFixed(2));
}

</script>
<?php echo $last_footer; ?>
