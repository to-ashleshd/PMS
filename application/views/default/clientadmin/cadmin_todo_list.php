<!--
Appraisee
Appraiser
-->
<div class="span4">
  <div class="w-box w-box-green hideable">
    <div class="w-box-header">
      <h4>Todo list (<?php echo $whoiam; ?>)</h4>
      <div class="pull-right"> <span class="label"><span class="jQ-todoAll-count"></span> tasks</span> </div>
    </div>
    <div class="w-box-content todo-list">
      
	  
	  <?php if( $this->session->userdata('login_type') == 'admin' ) : ?>
	  	<?php 
			$logintype = $this->session->userdata('login_type'); 
			$count_nonrelatedemp = count(	$nonrelatedemp );
		?>
		<h4>As Topadmin (<span class="todo-nb"></span>)</h4>
		<ul class="connectedSortable">
		<?php if( $count_nonrelatedemp >= 1 ) : ?>			
			<li class="high-pr"><input type="checkbox" class="todo-check" disabled="disabled" /><?php echo $count_nonrelatedemp; ?> Registered users did not have any Relationship.</li>
		<?php else: ?>
			<li class="low-pr completed"><input type="checkbox" class="todo-check" disabled="disabled" />You have <?php echo $count_nonrelatedemp; ?> Nonreplationship users.</li>
		<?php endif; ?>
		</ul>
	  <?php endif; ?>
	  
	  
	  <?php if( $whoiam == 'nopms' ): ?>
		  <h4>New User (<span class="todo-nb"></span>)</h4>
		  <ul class="connectedSortable">
			<?php echo getMytodoStatus($mysubmitstatus,$display_immidiate_pre_year); ?>
		  </ul>
	  <?php endif; ?> 
	  
	  <?php if( $whoiam == 'appraisee' ): ?>
		<h4>My Todo (<span class="todo-nb"></span>)</h4>
		<ul class="connectedSortable">
			<?php echo getMytodoStatus($mysubmitstatus,$display_immidiate_pre_year); ?>
			<?php echo getMytodoStatus($current_mysubmitstatus,$display_current_year); ?>
		</ul>
	  <?php endif; ?> 
	  
	  <!-- For appraiser --><!-- getMytodoStatus -->
	 <?php if( $whoiam == 'appraiser' ): ?>
	  <h4>My Todo (<span class="todo-nb"></span>)</h4>
	  <ul class="connectedSortable">
	  	  <?php echo getMytodoStatus($mysubmitstatus,$display_immidiate_pre_year); ?>
		  <?php echo getMytodoStatus($current_mysubmitstatus,$display_current_year); ?>
      </ul>
	  
	  <h4>As Appraiser (<span class="todo-nb"></span>)</h4>
	  <?php
	  	$pending_count = 0;
	  	foreach( $graph_appraiser as $key=>$val ) {
			if( $val->submit_status >= 4 and $val->submit_status < 6 ) {
				$pending_count++;
			}
			if( $val->submit_status == 0.2 ) {
				$pending_count++;
			}
			if( $val->submit_status == 3 ) {
				$pending_count++;
			}
			
		}
	  ?>
	  <ul class="connectedSortable">
	  	<?php if( $pending_count >= 1 ) : ?>
			<li class="high-pr"><input type="checkbox" class="todo-check" disabled="disabled" />You have <?php echo $pending_count; ?> Pending Activity.</li>
		<?php else: ?>
			<li class="low-pr completed"><input type="checkbox" class="todo-check" disabled="disabled" checked="checked" />No Pending Activities.</li>
		<?php endif; ?>
	  
      </ul>	 
	  
	  <?php endif; ?> 	  
	  <!-- End for appraiser -->
	  
	  
	  <?php if( $whoiam == 'reviewer' ): ?>
	  <h4>My Todo (<span class="todo-nb"></span>)</h4>	  
	  	<ul class="connectedSortable">
			<?php echo getMytodoStatus($mysubmitstatus,$display_immidiate_pre_year); ?>
			<?php echo getMytodoStatus($current_mysubmitstatus,$display_current_year); ?>
		</ul>
	  
	  <h4>As Appraiser (<span class="todo-nb"></span>)</h4>
	  <?php
	  	$pending_count = 0;
		
	  	foreach( $graph_appraiser as $key=>$val ) {
			if( $val->submit_status >= 4 and $val->submit_status <= 6 ) {
				$pending_count++;
			}
			
			if( $val->submit_status == 0.2 ) {
				$pending_count++;
			}
		}
	  ?>
	  <ul class="connectedSortable">
	  	<?php if( $pending_count >= 1 ) : ?>
			<li class="high-pr"><input type="checkbox" class="todo-check" disabled="disabled" />You have <?php echo $pending_count; ?> Pending Activity.</li>
		<?php else: ?>
			<li class="low-pr completed"><input type="checkbox" class="todo-check" disabled="disabled" checked="checked" />No Pending Activities.</li>
		<?php endif; ?>
	  
      </ul>	 
	  
	  <h4>As Reviewer (<span class="todo-nb"></span>)</h4>
	  <?php
	  	$pending_count = 0;
		
	  	foreach( $graph_reviewer as $key=>$val ) {
			if( $val->submit_status > 6 and $val->submit_status <= 7 ) {
				$pending_count++;
			}
		}
	  ?>
	  <ul class="connectedSortable">
        <?php if( $pending_count >= 1 ) : ?>
			<li class="high-pr"><input type="checkbox" class="todo-check" disabled="disabled" />You have <?php echo $pending_count; ?> Pending Activity.</li>
		<?php else: ?>
			<li class="low-pr completed"><input type="checkbox" class="todo-check" disabled="disabled" checked="checked" />No Pending Activities.</li>
		<?php endif; ?>
      </ul>	  
	  <?php endif; ?>
	  
	  <!--
      <ul class="connectedSortable">
        <li class="high-pr"><input type="checkbox" class="todo-check" />Buy groceries</li>
        <li class="low-pr completed"><input type="checkbox" checked class="todo-check" />Do laundry</li>
        <li class="low-pr"><input type="checkbox" class="todo-check" />Meeting with Macy</li>
        <li class="high-pr"><input type="checkbox" class="todo-check" />Pick up kids</li>
      </ul>
	  <!--
      <h4>Work (<span class="todo-nb"></span>)</h4>
      <ul class="connectedSortable">
        <li class="medium-pr">
          <input type="checkbox" class="todo-check" />
          Send press releases</li>
        <li class="low-pr">
          <input type="checkbox" class="todo-check" />
          Buy books</li>
        <li class="high-pr completed">
          <input type="checkbox" checked class="todo-check" />
          Update main site</li>
      </ul>
	  -->
	  <!-- Display Report -->
	  <?php 
	  //Count for appraiser
	  //Get Values for KRA PMS IDP
	  $arrKRA = array();
	  $arrPMS = array();
	  $arrIDP = array();
	  $arrS1 = array();
	  
	  foreach( $rpt_employees as $key=>$val ) {
	  	//print_r($val);
		
		if( $val['submit_status'] == 0 ) {
			$arrKRA[] = $val['pms_employee_id'] ;
		}
			  
		if( $val['submit_status'] == 1 ) {
			$arrPMS[] = $val['pms_employee_id'] ;
		}
		
		if( $val['submit_status'] == 2 ) {
			$arrIDP[] = $val['pms_employee_id'] ;
		}
		
		if( $val['submit_status'] == 3 ) {
			$arrS1[] = $val['pms_employee_id'] ;
		}
		
	  
	  
	  }
	  
	  
	  /**
	  	echo '<pre>';
		//print_r($rpt_employees);
		echo '<br>KRA Pending: ' . count($arrKRA);
		echo '<br>IDP Pending: ' . count($arrIDP);
		echo '<br>PMS Pending: ' . count($arrPMS);
		echo '<br>*All Done: ' . count($arrS1);
		
		
		print_r($arrPMS);
		print_r($arrIDP);
		print_r($arrS1);
		
		
		echo '<hr>';
		//print_r($rpt_reviewer_employees);
		echo '</pre>';
	**/	
	  ?>
	  
	  <!-- End Display Report -->
	  
	  
	  
    </div>
  </div>
</div>

<?php

/***** Supporting Functions *****/
	function getMytodoStatus($mysubmitstatus,$display_immidiate_pre_year)
	{
		$output = '';
		
		if( $mysubmitstatus == 0 ) :
			$output .= '<li class="high-pr"><input type="checkbox" class="todo-check" disabled="disabled" />KRA for Year '.$display_immidiate_pre_year.' is pending.</li>';
			//$output .= '<li class="high-pr"><input type="checkbox" class="todo-check" disabled="disabled" />PMS for current year is pending.</li>';
			//$output .= '<li class="high-pr"><input type="checkbox" class="todo-check" disabled="disabled" />IDP for current year is pending.</li>';
	  endif;
		
		
		if( $mysubmitstatus == 1 ) :
			$output .= '<li class="low-pr completed"><input type="checkbox" class="todo-check" disabled="disabled" checked="checked" />KRA for Year'.$display_immidiate_pre_year.' is completed.</li>';
			$output .= '<li class="high-pr"><input type="checkbox" class="todo-check" disabled="disabled" />PMS for Year '.$display_immidiate_pre_year.' is pending.</li>';
			$output .= '<li class="high-pr"><input type="checkbox" class="todo-check" disabled="disabled" />IDP for  Year  '.$display_immidiate_pre_year.' is pending.</li>';
		endif;
		
		
		if( $mysubmitstatus == 2 ) :
			$output .= '<li class="low-pr completed"><input type="checkbox" class="todo-check" disabled="disabled" checked="checked" />KRA for  Year '.$display_immidiate_pre_year.' is completed.</li>';
			$output .= '<li class="low-pr completed"><input type="checkbox" class="todo-check" disabled="disabled" checked="checked" />PMS for  Year '.$display_immidiate_pre_year.' is completed.</li>';
			$output .= '<li class="high-pr"><input type="checkbox" class="todo-check" disabled="disabled" />IDP for  Year '.$display_immidiate_pre_year.' is pending.</li>';
		endif; 
		
		
		if( $mysubmitstatus >= 3 ) :
        	$output .= '<li class="low-pr completed"><input type="checkbox" class="todo-check" disabled="disabled" checked="checked" />KRA for  Year '.$display_immidiate_pre_year.' is completed.</li>';
			$output .= '<li class="low-pr completed"><input type="checkbox" class="todo-check" disabled="disabled" checked="checked" />PMS for  Year '.$display_immidiate_pre_year.' is completed.</li>';
			$output .= '<li class="low-pr completed"><input type="checkbox" class="todo-check" disabled="disabled" checked="checked" />IDP for  Year '.$display_immidiate_pre_year.' is completed.</li>';
		endif;
		
		return $output ;		
		
	}

?>