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

<?php
	$id='';
?>
  <!-- main content -->
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12">
      <div class="w-box w-box-green">
        <div class="w-box-header">
          <h4>Competencies</h4>
          <i class="icsw16-settings icsw16-white pull-right"></i> 
		  </div>
        <div class="w-box-content cnt_a">
          <div class="row-fluid">
            <div class="span12">
              <p class="heading_a">Competencies</p>
	  			<div id="flashmessages" >
 				 <?php if($this->session->userdata('success')): ?>
				  <?php $success =$this->session->userdata('success'); ?>
				  <div class="alert alert-success"><a data-dismiss="alert" class="close">&times;</a><strong>Success!</strong> <?php echo $success; ?></div>
				  <?php endif; ?>
				  <?php $this->session->unset_userdata('success');?>
				  </div>
    <div class="row-fluid">
     <div class="tab-content">
	  
	  
                         
                          <div class="w-box-content">
							<div class="w-box w-box-green">
							  <div class="w-box-header">
								<h4>Competencies <input type="button" value="New Competencies" style="height:22px;" class="btn btn-mini btn-inverse" name="show_new_competencies" id="show_new_competencies"></h4>
							  </div>
                          <div class="w-box-content">
                            <table id="dt_colVis_Reorder_client_country" class="table table-striped table-condensed">
                              <thead>
                                <tr>
                                  <th>id</th>
                                  <th style="width:25%;">Competencies Name</th>
								  <th style="width:40%;">Competencies Description</th>
								  <th style="width:3%;">Weightage</th>
                                  <th style="width:3%;">Status</th>
								  <th style="width:10%;">Grade(s)</th>
                                  <th style="width:14%;">Action</th>
                                </tr>
                              </thead>
                              <tbody>
							  <?php
							  if(isset($competencies_for_refrence))
							  {
							  	if(!empty($competencies_for_refrence))
								{
									$i=0;
									foreach($competencies_for_refrence as $key=>$val)
									{
									$i++;
									?>
									 <tr id="tr_<?=$val['competencies_for_refrence_id']?>">
									  <td><?=$i?></td>
									  <td><?=$val['competencies_name']?></td>
									  <td><?=$val['competencies_decription']?></td>
									  <td><?=$val['weightage_value']?>%</td>
									  <td><?=$val['status']?></td>
									  <td><?=$val['grades']?></td>
									  <td>
									  <a href="javascript:void(0)" class="btn btn-mini" > <i class="icon-pencil" title="Edit" onclick="call_edit_competencies('<?=$val['competencies_for_refrence_id']?>')"></i></a>
									  <a href="javascript:void(0)" class="btn btn-mini" > <i class="icsw16-acces-denied-sign" title="Delete" onclick="delete_competencies('<?=$val['competencies_for_refrence_id']?>')" ></i> </a></td>
									<?php
									}
								}
							  }
							  ?>
							  
							  </tr>
							  </tbody>
							  </table>
							  </div>
							  </div>
							</div>
							<br />
							<br />
							
     					
							<form action="<?php echo site_url('competencies/add_competencies'); ?>" method="post" id="frm" onsubmit="return competencies_validation()" >
							 <input type="hidden" name="h_competencies_id" id="h_competencies_id" value=""  />
							 <div class="formSep">
                            	<label class="span3">Competencies Name </label>
								<textarea name="comp_name" id="comp_name" class="span8" ></textarea>
							 </div>
							 <div class="formSep">
                            	<label class="span3">Competencies Description</label>
								<textarea name="comp_desc" id="comp_desc" class="span8" ></textarea>
							 </div>
							 <div class="formSep">
                            	<label class="span3">Weightage </label>
									<input type="text" name="weightage" id="weightage" value=""  />		
							 </div>
							 <div class="formSep">
                            	<label class="span3">Status</label>
								<select name="status" id="status" >
								<option value="" >--Please Select--</option>
								<option value="1" >Enabled</option>
								<option value="0" >Disabled</option>
								</select>
							 </div>
							  <div class="formSep">
                            	<label class="span3">Please Select Grades</label>
								<label class="span8">
								<label class="span8">
								<input type="checkbox" name="all_grade" id="all_grade" onclick="call_to_chk_all_grade()" />&nbsp;ALL<br />
								</label>
								<div id="grades" class="formSep" >
								<?php
								foreach($grades as $key=>$val)
								{
								
								?>
								 <label class="checkbox inline">
									<input type="checkbox" name="grade[]" id="grade_<?=$val['grade_id']?>" value="<?=$val['grade_id']?>" />&nbsp;<?=$val['grade_name']?>
								 </label>
								<?php
								}
								?>
								</div>
								</label>
							 </div>
							 
							   <div class="formSep" id="buttons">
								<input class="btn btn-beoro-3" type="submit" name="submit" id="submit" value="Submit"  />&nbsp;
								<input class="btn btn-beoro-3" type="reset" name="reset" id="reset" value="Reset"  />
								
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
<?php echo $common_js; ?>

<script src="<?php echo base_url("assets/clientadmin"); ?>/js/form_validation.js"></script>
<script type="text/javascript" ><br />
hide_message('flashmessages');
function call_to_chk_all_grade()
{
	if ($('#all_grade').is(":checked"))
	{
		$("#grades input:checkbox").attr("checked" ,true)
	}
	else
	{
		$("#grades input:checkbox").attr("checked" ,false)
	}
}
</script>
<script type="text/javascript" >
function  call_edit_competencies(comp_ref_id)
{
	var url = '<?php echo site_url("competencies/update_competencies"); ?>';
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {comp_ref_id:comp_ref_id},
				success: function(response) {					
					if(response.competencies_detail)
					{
						$('#h_competencies_id').val(response.competencies_detail.competencies_for_refrence_id);
						$('#comp_name').val(response.competencies_detail.competencies_name);
						$('#comp_desc').val(response.competencies_detail.competencies_decription);
						$('#weightage').val(response.competencies_detail.weightage_value);
						$('#status').val(response.competencies_detail.competencies_status);
						
						for(var i=0; i<response.competencies_detail.grades.length; i++)
						{
							g_id = response.competencies_detail.grades[i];
							$('#grade_'+g_id).attr('checked','checked');
							$('#submit').val('Update');
							$('#frm').attr('action',response.action);
						}
					}
				}	
	    	});


}

$('#show_new_competencies').click(function () {
$('#h_competencies_id').val('');
$('#comp_name').val('');
$('#comp_desc').val('');
$('#weightage').val('');
$('#status').val('');
$('#all_grade').attr("checked" ,false);
$('#submit').val('Submit');
$('#frm').attr('action','<?php echo site_url('competencies/add_competencies'); ?>');
$("#grades input:checkbox").attr("checked" ,false);

});


function delete_competencies(comp_ref_id)
{
	var t = confirm("Are You sure You want to delete this Competencies");
	if(t==true)
	{
		var url = '<?php echo site_url("competencies/delete_competencies"); ?>';
				$.ajax({
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {comp_ref_id:comp_ref_id},
					success: function(response) {					
						if(response.status==1)
						{
							$('#tr_'+comp_ref_id).remove();
							/*$('#reset').click();
							$('#submit').val('Submit');
							$('#frm').attr('action','<?php //echo site_url('competencies/add_competencies'); ?>');*/
							$('#show_new_competencies').click();
							alert('Competencies for refrence deleted successfully!');
							return true;
						}
						else if(response.status==0)
						{
							alert('Competency is in use so You can not delete this Competency!');
							return true;
						}
					}	
				});
		 return false;
	}
	else
	{
		return false;
	}
}
</script>
<script type="text/javascript" >
function competencies_validation()
{
var flag =0;var flag1=0;
var msg ='';var msg1='';
var comp_name = $('#comp_name').val('');
var comp_desc = $('#comp_desc').val('');
var weightage = $('#weightage').val('');
var status	= $('#status').val('');
var allVals = [];
$('#grades :checked').each(function() {
 allVals.push($(this).val());
	 
	  
     });
	 
		if(!is_empty('comp_name'))
				{
					flag=1;
					msg += 'Competencies Name can not empty.\n';
				}	 
	 
	 	if(!is_empty('comp_desc'))
				{
					flag=1;
					msg += 'Competencies Description can not empty.\n';
				}	 
		if(!is_empty('weightage'))
				{
					flag=1;
					msg += 'Weightage can not empty.\n';
				}	 
	if(!is_empty('status'))
				{
					flag=1;
					msg += 'Status can not empty.\n';
				}	 
	 if(allVals=='' || allVals==null)
	 {
	 	flag=1;
		msg += 'Please select atleast one Grade.\n';
	 }
	 
	 if(flag==0)
	 {
	 	if(!isnumeric('weightage'))
			{
				flag1 =1;
				msg1 = "Weightage shoule be numberic (1,2,3 etc.) and cannot be empty.\n";
			}
	 }
	 else
	 {
	 	alert('Please Check for \n'+msg);
		return false;
	 }
	 
	 
	 if(flag1==1)
	 {
	 	alert(msg1);
		return false;
	 }
	 else if(flag==1)
	 {
	 	alert('Please Check for \n'+msg);
		return false;
	 }
	 else
	 {
	 	return true;
	 }
}
</script>


<?php echo $last_footer; ?>