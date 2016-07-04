<?php
//fix issue
$this->load->model('commonmodel');
$this->load->model('generalesettings');
$site_name = $this->generalesettings->getSiteName();
$s_lang_visitors = $this->commonmodel->get_env_setting('s_lang_visitors');
?>
<div class="elgg-page-footer" style="margin-top:10px; padding-top:10px; border-top:1px solid #EBEBEB;">
  <div class="elgg-inner" style="width:95%; margin:auto;">
    <div class="mts clearfloat float-alt" style="width:500px; float:left;">&copy; <?php echo $site_name; ?> <a href="#" >Terms of Service</a> <a href="#" >Privacy Policy</a></div>
	<div class="mts clearfloat float-alt" style="width:200px; float:right;">
	<?php
		if( !isset( $s_lang_visitors ) ){
			$s_lang_visitors = 'English' ;
		}
		$arrLang = explode(',',$s_lang_visitors);
	?>
	  <select name="select">
	  	<?php foreach( $arrLang as $row ) : ?>
	    <option value="<?php echo $row; ?>"><?php echo $row; ?></option>
		<?php endforeach; ?>
      </select>
    </div>
  </div>
</div>

<script>
<!-- Footer for autorun program like notifications code -->
$(document).ready(function(){	
	//alert('Loading wall..');
//Get Notification
	function getinboxnotificaiton()
	{
		
		var url = '<?php echo site_url("ajaxmessages/getinboxnotification"); ?>';
		var id = 1;
		$.ajax({
			url: url,
			dataType: 'json',
			type: 'POST',
			data: {id:id},
			 beforeSend: function(){
				//$("#dt_colVis_Reorder_adminrole").html('Loading...');
			},
			success: function(response) {				
				//Update Send Items List
				//alert(response.output);
				$("#topbar_message_notifications").html(response.output);
				
			}	
		});
	
	}
	
	//Get Activity Alert Notification
	function getactivitynotificaiton()
	{
		
		var url = '<?php echo site_url("ajaxmessages/getalertnotification"); ?>';
		var id = 1;
		$.ajax({
			url: url,
			dataType: 'json',
			type: 'POST',
			data: {id:id},
			 beforeSend: function(){
				//$("#dt_colVis_Reorder_adminrole").html('Loading...');
			},
			success: function(response) {				
				//Update Send Items List
				//alert(response.output);
				$("#topbar_activity_notifications").html(response.output);
				
			}	
		});
	
	}
	
	
	

	
});
</script>	