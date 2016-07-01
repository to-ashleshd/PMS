<?php
$excel_data = '';
$excel_data .= 'Name: ' . "\t" . $this->session->userdata('username') . "\n";
$excel_data .= 'Role: ' . "\t" . $whoiam . "\n";

	if($top_employee_apraiser_detail['appraiser']) {
		$top_employee_apraiser_detail['appraiser'] ;
	}
	else {
		$top_employee_apraiser_detail['appraiser'] = '';
	}
	
	if($top_employee_apraiser_detail['reviewer']) { 
		$top_employee_apraiser_detail['reviewer']; 
	}
	else {
		$top_employee_apraiser_detail['reviewer'] = ''; 
	}
	
	
	
	  	$excel_data .= 'Employee Name:' . "\t" . $top_employee_detail['fname'].' '.$top_employee_detail['lname'] . "\n";
        $excel_data .= 'Designation:' ."\t". $top_employee_detail['designation_name'] ."\n" ;
        $excel_data .= 'Employee ID:' ."\t". $top_employee_detail['employee_id'] ."\n" ;
        $excel_data .= 'Name & Designation of Appraiser:' ."\t". strip_tags($top_employee_apraiser_detail['appraiser']) ."\n" ;
        $excel_data .= 'Name & Designation of Reviewer:' ."\t". strip_tags($top_employee_apraiser_detail['reviewer'])  ."\n" ;
        $excel_data .= 'Plant / Location:' ."\t". $top_employee_detail['office_name'] ."\n" ;
        $excel_data .= 'Employee Department:' ."\t". $top_employee_detail['department_name'] ."\n" ;
		$excel_data .= 'Date of Last Promotion:' ."\t". '-' ."\n" ;
		$excel_data .= 'Last PMS Rating :' ."\t". '-' ."\n" ;
	  
		  //Get Years From and To
		  $this->load->model('taskschedulemodel');
		  $result_year = $this->taskschedulemodel->getTimeperiodById(1);
		  $display_year = '[' . $result_year->time_period_from . ' - ' . $result_year->time_period_to . ']';
//echo '<pre>';
//print_r($kra_detail);				 
//echo '</pre>';
if(!isset($error)){
		if(isset($kra_detail))
		{
			if(!empty($kra_detail))
			{
				//Headers 
				$excel_data .= 'Sr. No.' ."\t" ;
				$excel_data .= 'Key Result Area' ."\t" ;
				$excel_data .= 'Performance Target' ."\t" ;
				$excel_data .= 'Performance Measure' ."\t" ;
				$excel_data .= 'Weightage %' ."\t" ;
				$excel_data .= 'Initiative' ."\t" ;
				$excel_data .= 'Appraiser Name' ."\t" ;
				$excel_data .= "\n" ;
			
				$i=0;
				foreach($kra_detail as $key=>$val)
				{
					$j= $i+1;
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
					
					// $val['appraiser_name_designation'] . '  (' . $display_status . ')'; 
					//Excel Rows
					$excel_data .= $j ."\t" ;
				$excel_data .= $val['key_result_area'] ."\t" ;
				$excel_data .= $val['performance_target'] ."\t" ;
				$excel_data .= $val['performance_measure'] ."\t" ;
				$excel_data .= $val['weightage_value'] ."\t" ;
				$excel_data .= $val['initaitive'] ."\t" ;
				$excel_data .= $val['appraiser_name_designation'] . '  (' . $display_status . ')' ."\t" ;
				$excel_data .= "\n" ;
					
				$i++;
				} 
				
			}
		}
		else
		{
		}
	
}
echo $excel_data ;
?>
