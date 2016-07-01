<?php
/**
* Project Code: PMS
* Version: PMS1
* Object: Template
* Template: Default / clientadmin
* Template Name: cadmin_addcompetencies.php
* Desc: add /display competencies 
* Last Update: 11-May-2013
* Author: Team Enrich
** Change Log **
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
      <div class="w-box w-box-green">
        <div class="w-box-header">
          <h4>Employee Last Promotion</h4>
          <i class="icsw16-settings icsw16-white pull-right"></i> 
		  </div>
        <div class="w-box-content cnt_a">
          <div class="row-fluid">
            <div class="span12">
              <p class="heading_a">Employee Last Promotion</p>
	  				<div id="flash_message" >
					</div>
					<div id="flashmessages" >
 				 <?php if($this->session->userdata('success')): ?>
				  <?php $success =$this->session->userdata('success'); ?>
				  <div class="alert alert-success"><a data-dismiss="alert" class="close">&times;</a><strong>Success!</strong> <?php echo $success; ?></div>
				  <?php endif; ?>
				  <?php $this->session->unset_userdata('success');?>
				  </div>
    <div class="row-fluid">
     <div class="tab-content">
	 <form action="" method="post" >
	     <div class="formSep">
                  <label class="span3">Employee Name</label>
							<input type="hidden" name="pms_employee_id" id="pms_employee_id" value=""  />
							<select name="employee" id="employee" onblur="get_details()" >
							<option value="" >--Please Select--</option>
							<?php
							if(isset($employee))
							{
								if(!empty($employee))
								{
									foreach($employee as $key=>$val)
									{
										?>
										<option value="<?=$val['pms_employee_id']?>" ><?php echo $val['fname'].' '.$val['lname'].', '.$val['employee_id']; ?></option>
										<?php
									}
								}
							}
							?>
							</select>
		</div>
	  
          <div id="employee_detail" >
		
		  
		  
		  </div>
				
			
     					
	</form>							
						
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
<?php echo $common_js; ?><br />
<!--<script src="<?php //echo base_url("assets/sweetdream/"); ?>/js/jquery.min.js"></script>
<script src="<?php //echo base_url("assets/sweetdream/"); ?>/js/jquery-ui.min.js"></script>-->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/form_validation.js"></script>
<script type="text/javascript" >
hide_message('flashmessages');
hide_message('flash_message');
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

$('input[name=\'employee\']').catcomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: '<?php echo site_url("apraisee/autocomplete_employee"); ?>',
			dataType: 'json',
			type: 'POST',
		    data: {
					employee:  encodeURIComponent(request.term)
    		     },
			success: function(json) {	
				var employee = json['employee']
				response($.map(employee, function(item) {
					return {
						label: item['fname']+' '+item['lname']+' '+item['employee_id'],
						value: item['pms_employee_id'],
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
function reset_value()
{
	$('#dp1').val('');
	$('#designation').val('');
}
function get_details()
{
	
	var employee_id = $('#employee').val();
	
	var url = '<?php echo site_url("employee/get_detail_last_promotion"); ?>';
		$.ajax({
			url: url,
			dataType: 'json',
			type: 'POST',
			data: {
			pms_employee_id:employee_id
			},
			success: function(response) {		
			
				if(response.display_detail)
				{
						$('#employee_detail').html(response.display_detail);
					     if($('#dt_colVis_Reorder_client').length) {
						$('#dt_colVis_Reorder_client').dataTable({
							"sPaginationType": "bootstrap",
							"sDom": "R<'dt-top-row'Clf>r<'dt-wrapper't><'dt-row dt-bottom-row'<'row-fluid'ip>",
							"fnInitComplete": function(oSettings, json) {
								$('.ColVis_Button').addClass('btn btn-mini btn-inverse').html('Columns');
							}
						});
          			  }
      					//alert(response.start_date_for_validation);
						//alert(response.end_date_for_validation);
						 if($('#dp1').length) {
               			 					$('#dp1').datepicker();
											$('#dp1').datepicker('setStartDate', response.start_date_for_validation);
											$('#dp1').datepicker('setEndDate', response.end_date_for_validation);
            						}
					
				}
				
			}	
		});
	
	
	
}

function add_last_promotion()
{
	var flag = 0;
	var msg  = '';
	var pms_employee_id = $('#employee').val();
	var last_promotion_date = $('#dp1').val();
	var designation_id = $('#designation').val();
	var srno = $('#dt_colVis_Reorder_client tbody tr').length;
	
	if(!is_empty('employee')){
		flag =1 ;
		msg += 'Please select employee.\n';
	}
	
	if(!is_empty('dp1')){
		flag =1 ;
		msg += 'Date can not empty.\n';
	}
	if(!is_empty('designation')){
		flag =1 ;
		msg += 'Please select designation.\n';
	}
	
	if(flag==1)
	{
		alert("Please check for following error.\n "+msg);
		return false;
	}
	else
	{
		var html = '';
		var url = '<?php echo site_url("employee/add_employee_last_promotion"); ?>';
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
				pms_employee_id:pms_employee_id,
				last_promotion_date:last_promotion_date,
				designation_id:designation_id,
				srno:srno
				},
				success: function(response) {		
				
					if(response.status==1)
					{
						html += '<div class="alert alert-success">';
						html += '<a class="close" data-dismiss="alert">&times;</a>';
						html += '<strong>Success!</strong> Last promotion added successfully.';
						html += '</div>';
						$('#span_last_prom_dt').html(response.last_promotion_date);
						$('#span_designation_nm').html(response.designation_name);
						$('#span_grade_nm').html(response.grade_name);
						$('#tbody_last_promotion').append(response.html);
						$('.dataTables_empty').closest('tr').remove();
						$('#dp1').val('');
						$('#dp1').datepicker('setStartDate', response.start_date_for_validation);
						$('#dp1').datepicker('setEndDate', response.end_date_for_validation);
						$('#designation').val('');
						
					}
					else
					{
							html += '<div class="alert alert-error">';
							html += '<a class="close" data-dismiss="alert">&times;</a>';
							html += '<strong>Error!&nbsp;</strong> Please try again';
							html += '</div>';
					}
						$('#flash_message').html(html);
						hide_message('flashmessages');
						hide_message('flash_message');
				}	
			});
			return true;
	}
	
}
</script>

<?php echo $last_footer; ?>