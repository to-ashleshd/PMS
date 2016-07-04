<?php
/**
* Project Code: PMS
* Version: PMS1
* Object: Template
* Template: Default / clientadmin
* Template Name: cadmin_report_pmsrating.php
* Desc: PMS Bell Curve Report
* Last Update: 08-May-2013
* Author: Team Enrich
** Change Log **
* 14-May-13 Update Add PDF
**/
?>
<?php echo $header; ?>
<?php
$arrBusiness = array();
//echo '<pre>';
//print_r($business_list); 
//echo '</pre>';
//echo '<pre>';
$counter = 1 ;
foreach( $business_list as $brow ) {
	$arrBusiness[$counter]['business_name'] = $brow->business_subject ;
	$arrBusiness[$counter]['business_id'] = $brow->business_id ;
	$counter++;
}
//print_r($arrBusiness);
//echo '</pre>';

$business_id = 1 ;
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
</script>

<?php
//Display Loop for each business
foreach($arrBusiness as $key=>$val) {
	//echo '<br>Key ' . $key ;
	$graph_key = $key ;
	$business_name = $val['business_name'] ;
	$business_id = $val['business_id'] ;
	//echo '<br>Search for Business: ' . $business_id ;
	//Get Data for each business
	/**** Loop 1 ***/
	//collect data
	$count_FEE = 0;
	$count_EE = 0;
	$count_ME = 0;
	$count_NI = 0;
	$count_BE = 0;
	$arrScore = array();
	
	if(isset($reviewer_employees))
	{
		if(!empty($reviewer_employees)) 
		{
			foreach($reviewer_employees as $key=>$val)
			{
				//Filter for Business id
				//echo '<pre>';
				//print_r($val);
				//echo '</pre>';
				if( $val['emp_busines_id'] == $business_id )
				{
			
					//$arrScore[] = $val['reviewer_overall_rating']['score_rating'] ;
					if( $val['reviewer_overall_rating']['score_rating'] == 'FEE' ) {
						$count_FEE ++ ;
					}
					
					if( $val['reviewer_overall_rating']['score_rating'] == 'EE' ) {
						$count_EE ++ ;
					}
					
					if( $val['reviewer_overall_rating']['score_rating'] == 'ME' ) {
						$count_ME ++ ;
					}
					
					if( $val['reviewer_overall_rating']['score_rating'] == 'NI' ) {
						$count_NI ++ ;
					}
					
					if( $val['reviewer_overall_rating']['score_rating'] == 'BE' ) {
						$count_BE ++ ;
					}
				
					//print_r($val['reviewer_overall_rating']['score_rating'] => ME);
				}	
			
			}//End Foreach
		}
	}	
	//End Collect Data
	
	//Draw Graph
?>
<script type="text/javascript">
/** Bell Curve **/
	  function drawBellCurve_<?php echo $graph_key; ?>() {
        var data = google.visualization.arrayToDataTable([
          ['Scale', 'Employes'],
          ['FEE',  <?php echo $count_FEE; ?>],
          ['EE',  <?php echo $count_EE; ?>],
          ['ME',  <?php echo $count_ME; ?>],
          ['NI',  <?php echo $count_NI; ?>],
		  ['BE',  <?php echo $count_BE; ?>]
        ]);

        var options = {
          title: 'Bell Curve Report: <?php echo $business_name; ?>',
          hAxis: {title: 'Ratings', titleTextStyle: {color: 'red'}}
        };
        
		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_<?php echo $graph_key; ?>'));
        chart.draw(data, options);
      }
</script>	
<?php	
	//End Draw Graph
	
	
//End foreach	
}

?>
<script type="text/javascript">
//Display all Graphoes
	  function drawVisualization() {
	  	
		//bell Curve
		<?php foreach($arrBusiness as $key=>$val) : ?>
		drawBellCurve_<?php echo $key; ?>();
		<?php endforeach; ?>
		
	  }	  
	  
	   google.setOnLoadCallback(drawVisualization);
</script>
<?php
$segment_1 = $this->uri->segment(1) ;
$segment_2 = $this->uri->segment(2) ;
$segment_3 = $this->uri->segment(3) ;
?>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
					<div style="clear:both;"></div>
					<?php foreach($arrBusiness as $key=>$val) : ?>
					<div id="chart_div_<?php echo $key; ?>" style="width: 550px; height: 400px; margin:auto; float:left; margin-left:10px; margin-bottom:10px;"></div>
					<?php endforeach; ?>
					<div style="clear:both;"></div>
					
                        <!-- confirmation box -->
                       
                    </div>
                </div>
            </div>
           <!-- footer --> 
<?php echo $middle_footer; ?>
<?php echo $common_js; ?>
<?php echo $last_footer; ?>