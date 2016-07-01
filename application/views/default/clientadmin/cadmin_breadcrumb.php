<?php
$segment_class = $this->uri->segment(1) ;
$segment_method = $this->uri->segment(2) ;
$segment_para = $this->uri->segment(3) ;

$arrbreadcrumb = array();

// check for My KRA, My PMS, My IDP
if( $segment_class == 'apraisee' )
{
	if( $segment_method == 'addkra' ) {
		//Get Year Link
		$this->load->model('taskschedulemodel');
		$result_year = $this->taskschedulemodel->getTimeperiodById($segment_para);
		$display_title = 'PA ' . $result_year->time_period_from . ' - ' . $result_year->time_period_to ;
		$arrbreadcrumb[0] = array('title'=>$display_title,'link' => 'javascript:void(0);');
		
		//Get Page Link
		$arrbreadcrumb[1] = array('title'=>'My KRA','link' => site_url( $segment_class .'/'. $segment_method .'/'. $segment_para) );
	}
	
	if( $segment_method == 'addpms' ) {
		//Get Year Link
		$this->load->model('taskschedulemodel');
		$result_year = $this->taskschedulemodel->getTimeperiodById($segment_para);
		$display_title = 'PA ' . $result_year->time_period_from . ' - ' . $result_year->time_period_to ;
		$arrbreadcrumb[0] = array('title'=>$display_title,'link' => 'javascript:void(0);');
		
		//Get Page Link
		$arrbreadcrumb[1] = array('title'=>'My PMS','link' => site_url( $segment_class .'/'. $segment_method .'/'. $segment_para) );
	}
	
	if( $segment_method == 'addidp' ) {
		//Get Year Link
		$this->load->model('taskschedulemodel');
		$result_year = $this->taskschedulemodel->getTimeperiodById($segment_para);
		$display_title = 'PA ' . $result_year->time_period_from . ' - ' . $result_year->time_period_to ;
		$arrbreadcrumb[0] = array('title'=>$display_title,'link' => 'javascript:void(0);');
		
		//Get Page Link
		$arrbreadcrumb[1] = array('title'=>'My IDP','link' => site_url( $segment_class .'/'. $segment_method .'/'. $segment_para) );
	}

}

if( $segment_class == 'apraiser' )
{
	if( $segment_method == '' ) {
		//Get Year Link
		$arrbreadcrumb[0] = array('title'=> 'My Team','link' => site_url($segment_class));
	}
	
	if( $segment_method == 'apraiseeassessment' ) {
		//Get Year Link
		$arrbreadcrumb[0] = array('title'=> 'My Team','link' => site_url($segment_class));
		$arrbreadcrumb[1] = array('title'=> 'Apraisee Assessment','link' => site_url($segment_class .'/'.$segment_method ));
	}
	
	if( $segment_method == 'statusreport' ) {
		//Get Year Link
		$arrbreadcrumb[0] = array('title'=> 'Reports','link' => 'javascript:void(0);' );
		$arrbreadcrumb[1] = array('title'=> 'Status Report','link' => site_url($segment_class .'/'.$segment_method ));
	}
	
}

if( $segment_class == 'employee' )
{
	if( $segment_method == '' ) {
		//Get Year Link
		$arrbreadcrumb[0] = array('title'=> 'Employee List','link' => site_url($segment_class));
	}
	
	if( $segment_method == 'addrelationship' ) {
		//Get Year Link
		$arrbreadcrumb[0] = array('title'=> 'Employee Relationship','link' => site_url($segment_class));
	}
	
	if( $segment_method == 'relationship' ) {
		//Get Year Link
		$arrbreadcrumb[0] = array('title'=> 'Employee Relationship List','link' => site_url($segment_class));
	}

}


if( $segment_class == 'clientadmin' )
{
	
	if( $segment_method == 'addemployee' ) {
		//Get Year Link
		$arrbreadcrumb[0] = array('title'=> 'Add New Employee','link' => site_url($segment_class .'/'.$segment_method));
	}
	
	
}

if( $segment_class == 'import' )
{
	
	if( $segment_method == 'importexcel' ) {
		//Get Year Link
		$arrbreadcrumb[0] = array('title'=> 'Excel Import (Employee List)','link' => site_url($segment_class .'/'.$segment_method));
	}
	
}

if( $segment_class == 'reports' )
{
	
	if( $segment_method == 'bellcurve' ) {
		//Get Year Link
		$arrbreadcrumb[0] = array('title'=> 'Bell Curve Repport','link' => site_url($segment_class .'/'.$segment_method));
	}
	
}




$breadcrumb_list = '';
foreach ( $arrbreadcrumb as $key=>$val ) :
	$breadcrumb_list .= '<li>';
	$breadcrumb_list .= '<a href="' . $val['link'] . '">' . $val['title'] . '</a>';
	$breadcrumb_list .= '</li>';
endforeach;

//<li><!--Heading comes dynamically--><a href="#">Dashboard</a></li>

?>

  <!-- breadcrumbs -->
            <div class="container-fluid" style="padding-top:10px;">
                <ul id="breadcrumbs">
                    <li><a href="<?php echo site_url("clientadmin"); ?>"><i class="icon-home"></i></a></li>
					
					<?php echo $breadcrumb_list ; ?>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
			