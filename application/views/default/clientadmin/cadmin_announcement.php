<?php echo $header; ?>
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12">
      <div class="w-box w-box-green">
        <div class="w-box-header">
          <h4>Announcement (PMS)</h4>
          <i class="icsw16-settings icsw16-white pull-right"></i> </div>
        <div class="w-box-content cnt_a">
          <div class="row-fluid">
            <div class="span12">
              <!--<p class="heading_a">Announcements</p>-->
              <!-- Display Success and Warning -->
			  
			  <div id="flashmessages" >
              <?php if($this->session->userdata('warning')): ?>
              <?php $warning =$this->session->userdata('warning'); ?>
              <div class="alert alert-error"> <a data-dismiss="alert" class="close">&times;</a><strong>Warning!</strong> <?php echo $warning; ?></div>
              <?php endif; ?>
              <?php if($this->session->userdata('success')): ?>
              <?php $success =$this->session->userdata('success'); ?>
              <div class="alert alert-success"><a data-dismiss="alert" class="close">&times;</a><strong>Success!</strong> <?php echo $success; ?></div>
              <?php endif; ?>
			  </div>
			  <div id="msg"></div>
			  
              <!-- Tab Settings -->
              <div class="row-fluid">
                <!--<div class="span6">-->
                <div class="tabbable tabbable-bordered">
                  <?php $this->session->unset_userdata('warning');?>
                  <?php $this->session->unset_userdata('success');?>
                  <div class="tab-content">
                    <div id="tb1_a" class="tab-pane active">
                      <!-- Template -->
                      <div class="w-box w-box-orange">
                      <div class="w-box-header">
                        <h4>Announcement  List <input id="shownewform" name="newtemplate" type="button" class="btn btn-mini btn-inverse" style="height:22px;" value="New Announcement" /></h4>
                      </div>
                      <div class="w-box-content" id="announcement_list">
					  
						
						<!-- New List -->
						<?php echo $announcement_details; ?>
						<!-- End New List -->
						
                      </div> 
                      <div id="new_announcement" class="span6"> 
                      
                      <form name="frm_announcement" method="post" id="frm_announcement" >
                        <input type="hidden" name="announcement_id" id="announcement_id" value="0" />
                        <div class="formSep"> <span class="span4 req">Title</span>
                          <input name="announcement_subject" type="text" id="announcement_subject" value="" maxlength="200">
                        </div>
                        <div class="formSep"> <span class="span4 req">Announcement Details</span>
                          <textarea name="announcement_desc" rows="5" id="announcement_desc"></textarea>
                        </div>
                        <div class="formSep"> <span class="span4">&nbsp;</span>
                          <input type="button" name="submit" value="Save" id="submit_ans" class="btn btn-beoro-3">
                          <input type="reset" name="reset" value="Cancel" id="reset_ans" class="btn btn-beoro-3" >
                        </div>
                        
                      </form>
                      <!-- End Template -->
                    </div>
                  </div>
                </div>
                <!--</div>-->
              </div>
              <!-- End Tab Settings -->
            </div>
            <!-- Settings -->
            <!-- Panel Right -->
            <!-- End Settings -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $middle_footer; ?> <?php echo $common_js; ?>
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/jquery.livequery.js"></script>
<script type="text/javascript" >
hide_message('flashmessages');
hide_message('msg');
$(document).ready(function() {

	//New Announcement
	$("#submit_ans").click( function() {
		//alert('New Announcement');
		var url = '<?php echo site_url("announcement/ajax_addannouncement"); ?>';
		var frm = $('#frm_announcement');
		$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: frm.serialize(),
				success: function(response) {
					$("#msg").html('');
					//alert('Response: ' + response.msg );
					if( response.status == 'Y' ) {
						var msg = '<div class="alert alert-success"><a data-dismiss="alert" class="close">&times;</a><strong>Success!</strong> ' + response.msg +'</div>';
					}
					else {
						var msg = '<div class="alert alert-error"><a data-dismiss="alert" class="close">&times;</a><strong>Warning!</strong> ' + response.msg +'</div>';
					}
					
					//refresh List
					refreshlist();
					
					//Display Message
					$("#msg").html(msg);
					hide_message('msg');
					//Clear Form
					hideform();
					//clearnewannouncementform();
					
					
				}	
    		});
		
	//End Function	
	});
	
	
	//Edit Announcement
	$('.editannouncement').livequery("click", function(e){
		var announcement_id = $(this).attr('id').replace('edit_','');
		var url = '<?php echo site_url("announcement/ajax_getinfo"); ?>';
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {announcement_id:announcement_id},
				success: function(response) {	
				
					//Display values in text box
					showform();
					//alert('subject: ' + response.announcement_subject + ' announcement_desc:' + response.announcement_desc );
					
					$("#announcement_id").val(announcement_id);
					$("#announcement_subject").val(response.announcement_subject);
					$("#announcement_desc").val(response.announcement_desc);
					
					//$("#business_subject").val(response.result);
					//$("#business_id").val(business_id);
					//refreshlist();
					//var msg = getmessage(response.status,response.msg);
					
					//Display Message
					//$("#msg").html(msg);
					//hideform();
				}	
	    });
	
	});
	
	
	//Suspend
	$('.suspendannouncement').livequery("click", function(e){
		var announcement_id = $(this).attr('id').replace('suspend_','');
		if( confirm('Are you sure to suspend this record?') == false ) {
			return false;
		} 
		else {
			//Process for suspend			
			var url = '<?php echo site_url("announcement/ajax_suspend"); ?>';
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {announcement_id:announcement_id},
				success: function(response) {					
					refreshlist();
					var msg = getmessage(response.status,response.msg);
					
					//Display Message
					$("#msg").html(msg);
					hide_message('msg');
					//$("#announcement_list").html(response.announcement_details);
				}	
	    	});
		}
	
	});
	
	//Make Active 
	$('.activeannouncement').livequery("click", function(e){
		var announcement_id = $(this).attr('id').replace('active_','');
		if( confirm('Are you sure to Active this record?') == false ) {
			return false;
		} 
		else {
			//Process for suspend			
			var url = '<?php echo site_url("announcement/ajax_active"); ?>';
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {announcement_id:announcement_id},
				success: function(response) {					
					refreshlist();
					var msg = getmessage(response.status,response.msg);
					
					//Display Message
					$("#msg").html(msg);
					hide_message('msg');
					//$("#announcement_list").html(response.announcement_details);
				}	
	    	});
		}
	
	});
	
	
	//Refresh List
	function refreshlist()
	{
		var url = '<?php echo site_url("announcement/ajax_getannouncementlist"); ?>';
		var frm = $('#frm_announcement');
		var id = 1;
		$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {id:id},
				success: function(response) {
					//alert('Response: ' + response.announcement_details );
					$("#announcement_list").html(response.announcement_details);
					
					//Refresh List with datatable
						if($('#dt_colVis_emailtemplate').length) {
							$('#dt_colVis_emailtemplate').dataTable({
								"sPaginationType": "bootstrap",
								"sDom": "R<'dt-top-row'Clf>r<'dt-wrapper't><'dt-row dt-bottom-row'<'row-fluid'ip>",
								"fnInitComplete": function(oSettings, json) {
									$('.ColVis_Button').addClass('btn btn-mini btn-inverse').html('Columns');
								}
							});
						}	
					
				}	
    	});
			
	}
	
	
	//Show New Form
	$("#shownewform").click(function() {
		showform();
	});
	
	
	//Hide form / Cancel Click
	$("#reset_ans").click(function() {
		hideform();
	});
	
	
	//ClearnewBox
	function clearnewannouncementform()
	{
		$("#announcement_subject").val('');
		$("#announcement_desc").val('');
	}
	
	function hideform()
	{
		clearnewannouncementform();
		$("#new_announcement").hide();
	}
	
	function showform()
	{
		clearnewannouncementform();
		$("#new_announcement").show();
	}
	
	
	function getmessage(status,message)
	{
		if( status == 'Y' ) {
			var msg = '<div class="alert alert-success"><a data-dismiss="alert" class="close">&times;</a><strong>Success!</strong> ' + message +'</div>';
		}
		else {
			var msg = '<div class="alert alert-error"><a data-dismiss="alert" class="close">&times;</a><strong>Warning!</strong> ' + message +'</div>';
		}
		
		return msg ;
	}
	
	
});
</script>
<?php echo $last_footer; ?>