<?php
/**
* Project Code: PMS
* Version: PMS1
* Object: Template
* Template: Default / clientadmin
* Template Name: cadmin_excelimport_success_list.php
* Desc: Display success import data list
* Last Update: 06-May-2013
* Author: Team Enrich
**/
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
<!--
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12">
-->	
      <!-- Display List -->
	  
	  
	  
	  
      <div class="w-box w-box-orange">
        <div class="w-box-header">
          <h4>Employee list: Success Import</h4>
        </div>
        <div class="w-box-content">
		
          <table id="dt_colVis_Reorder" class="table table-striped table-condensed">
            <thead>
              <tr>
                <th>Id</th>
                <th>Employee Name</th>
                <th>Designation</th>
                <th>EmpID Email</th>
                <th>Gender</th>
                <th>Company Name ID</th>
				<th>Office Name ID</th>
				<th>Department Name ID</th>
				<th>DOB DOJ Last Promotion</th>
				<th>Mobile</th>
				<th>Password</th>
				<th>Info</th>
              </tr>
            </thead>
            <tbody>
			<?php foreach( $postimportemplist as $key=>$val ) : ?>
			<?php
			//Generate Error
			$output_error = ''; //Set Default tag
			$error_found = 0;
			$cust_error = unserialize($val->errorinfo);	 
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
                <td><?php echo $val->designation_name .'<br>(' . $val->designation_id .')' ; ?></td>
                <td><?php echo $val->employee_id; ?><br /><?php echo $val->email; ?></td>
                <td><?php echo $val->gender; ?></td>
                <td><?php echo $val->company_name .'<br>(' . $val->company_master_id .')' ; ?></td>
				<td><?php echo $val->office_name .'<br>(' . $val->office_address_id .')' ; ?></td>
				<td><?php echo $val->department_name . '<br>('. $val->designation_id .')' ; ?></td>
				<td><?php echo date($s_date_format, strtotime($val->date_of_birth)); ; ?>
					<br />
					<?php echo date($s_date_format, strtotime($val->date_of_joining)); ; ?>
					<br />
					<?php echo date($s_date_format, strtotime($val->last_pramotion_date)); ; ?>
				</td>
				<td><?php echo $val->mobile_no; ?></td>
				<td><?php echo $val->user_password; ?></td>
				<td class="error"><?php echo $output_error; ?></td>				
              </tr>
			<?php endforeach; ?>  
            </tbody>
          </table>
       
		
		</div>
		
		
      </div>
	  
      <!-- End Display List -->
<!--	  
    </div>
  </div>
</div>
-->