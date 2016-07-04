<?php
/**
* Project Code: PMS
* Version: PMS1
* Object: Template
* Template: Default / clientadmin
* Template Name: cadmin_excelimport.php
* Desc: Display preimport 
* Last Update: 06-May-2013
* Author: Team Enrich
**/
?>	  	

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
<?php
	$id='';
?>
<!-- main content -->
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12">
      <!-- Display List -->
	  
	  <!-- File Upload -->
	  <form name="frmreg" id="formImport" method="post" action="<?php echo site_url("import/importexcel"); ?>" enctype="multipart/form-data" >
                  <input type="hidden" name="e_logintype" id="e_logintype" value="<?php echo $e_logintype; ?>" />
				  <input type="hidden" name="session_id" id="session_id" value="<?php echo $new_session_id; ?>"  />
                  <div class="row-fluid" >
                    <div class="span8">
                      <label class="span2" >Select Excelfile:</label>
                      <div class="span6 fileupload fileupload-new" data-provides="fileupload">
                        <div class="input-append">
                          <div class="uneditable-input input-small"> <i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span> </div>
                          <span class="btn btn-file"> <span class="fileupload-new">Select file</span> <span class="fileupload-exists">Change</span>
                          <input type="file" name="employeeimport" id="employeeimport">
                          </span> <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a> 						  
						  </div>
                      </div>
					  <div class="span2" style="float:left;"><input style="float:left;" type="submit" name="submit" id="submit" class="btn btn-beoro-3" value="Submit"></div>
                    </div>
					
                  </div>
                  
                  
				  
				  
                  
                  
                </form>
	  <!-- End File Upload -->
	  
	  
	  
      <div class="w-box w-box-orange" id="employee_list">
        <div class="w-box-header">
          <h4>Employee list</h4>
        </div>
        <div class="w-box-content">
		
          <table id="dt_colVis_Reorder" class="table table-striped table-condensed">
            <thead>
              <tr>
                <th>Id</th>
                <th>Employee Name</th>
                <th>Email</th>
                <th>Gender</th>
				<th>DOB</th>
				<th>Mobile</th>
				<th>Password</th>
				<th>Info</th>
              </tr>
            </thead>
            <tbody>
			<?php foreach( $preimport_data as $key=>$val ) : ?>
			<?php
			//Generate Error
			$output_error = ''; //Set Default tag
			$error_found = 0;
			$cust_error = unserialize($val->errorinfo);	 
			//echo '<pre>';
			//print_r($cust_error);
			//echo '</pre>';
			foreach( $cust_error as $key2=>$val2 ) {
			  //echo '<br>Key ' . $key . ' - Val: ' . $val ;
			  if( $val2 > 0) {
			  //Showing Error
				  //echo '<br>Error For: ' . $key ;
				  $output_error .= '<strong>' . ucwords($key2) . ':</strong>' ;
				  if( $val2 == 1) {
					  $output_error .= ' Empty Field ' ;
					  $error_found++;
				  }
				  if( $val2 == 2 ) {
					  $output_error .= ' Invalid Entry ';
					  $error_found++;
				  }
				  if( $val2 == 3 ) {
					  $output_error .= ' Not found in database ';
					  $error_found++;
				  }
				  if( $val2 == 4 ) {
					  $output_error .= ' Already Exists ';
					  $error_found++;
				  }
				  $output_error .='<br>';
			  }
			}
			if( $error_found == 0 ) {
				$output_error = 'OK';
			}	
			?>
			
              <tr>
                <td><?php echo $val->id; ?></td>
                <td><?php echo $val->fname .' '. $val->mname .' '. $val->lname; ?><br />(Fname Mname Lname)</td>
                <td><?php echo $val->email; ?></td>
                <td><?php echo $val->gender; ?></td>
				<td><?php echo date($s_date_format, strtotime($val->date_of_birth)); ; ?></td>
				<td><?php echo $val->mobile_no; ?></td>
				<td><?php echo $val->user_password; ?></td>
				<td class="error"><?php echo $output_error; ?></td>				
              </tr>
			<?php endforeach; ?>  
            </tbody>
          </table>
       
		
		</div>
		
		
      </div>
	  <?php if( count($preimport_data) >= 1 ) : ?>	  
	  <div align="center"><button id="doimport" class="btn btn-beoro-2">Do Import &raquo;</button></div>
	  <?php endif; ?>
      <!-- End Display List -->
    </div>
  </div>
</div>



<?php //echo $middle_footer; ?>
<?php // echo $common_js; ?>
<!-- More js if required -->
<script type="text/javascript">
var g_hostName = '<?php echo site_url(); ?>';	
$(document).ready(function() {

	$("#doimport").click( function() {
        
		var session_id = $("#session_id").val();
		//alert('do Import ' + session_id );
		$("#employee_list").html('Please wail..');	
		$("#doimport").hide();
            $.ajax({
                url : g_hostName + "/import/dopostimport",
                dataType : "json",
				type: 'POST',
				data: {session_id: session_id},
                success : function(data) {
                    //alert('Data ' + data.postimportemplist) ;
					if( data.mailerror != '' ) {
						alert(data.mailerror + "\n" + "Please Check Import table / log.");
					}
					$("#employee_list").html(data.postimportemplist);
                    
                }
            });                        
		
        });

//End document ready
});
</script>
<?php echo $last_footer; ?> 