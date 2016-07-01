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
//print_r($reviewer_employees); 
//echo '</pre>';
//die();
$counter = 1 ;

$arrBusinessNames = array();
$arrBusinessIds = array();

foreach( $reviewer_employees as $brow )
{
	$arrBusinessNames[] =  $brow['function_name']  ;
	$arrBusinessIds[] =$brow['emp_busines_id'];

}

//echo '<pre>';
/**
foreach( $business_list as $brow ) {
	$arrBusiness[$counter]['business_name'] = $brow->business_subject ;
	$arrBusiness[$counter]['business_id'] = $brow->business_id ;
	$counter++;
}

echo '<pre>';
**/
//print_r($arrBusinessNames);
$arrUniqueBusiness = array_unique($arrBusinessNames);
$arrUniqyeBusinessIds = array_unique($arrBusinessIds);

/**
print_r($arrUniqueBusiness);
print_r($arrUniqyeBusinessIds);
**/
//Collect Business Names
foreach( $arrUniqyeBusinessIds as $row )
{
	$business_name = $this->reportsmodel->getBusinessNameById($row);
	$arrBusiness[$counter]['business_name'] = $business_name ;
	$arrBusiness[$counter]['business_id'] = $row ;
	$counter++;
}

//print_r($arrBusiness);
//echo '</pre>';
//die();
$business_id = 1 ;
?>
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
					<!-- <div id="chart_div_<?php echo $key; ?>" style="width: 550px; height: 400px; margin:auto; float:left; margin-left:10px; margin-bottom:10px;"></div> -->
					<div id="outerchart<?php echo $key; ?>" style="width:550px; height:450px; border:1px solid #CCCCCC; float:left; margin-left:10px; margin-bottom:10px;">
					<!-- <div id="title_1"><?php echo $val['business_name']; ?>Chart Title</div> -->
					<div id="chart<?php echo $key; ?>" style="margin-top:20px; margin-left:20px; width:400px; height:400px;"></div>
					</div>
					<?php endforeach; ?>
					
					
					<div style="clear:both;"></div>
					
					
                        <!-- confirmation box -->
                       
                    </div>
                </div>
            </div>
           <!-- footer --> 
<?php echo $middle_footer; ?>
<?php echo $common_js; ?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/graphs"); ?>/jquery.jqplot.min.css" />
<style>
.jqplot-point-label { font-size:12px; }
</style>
<script type="text/javascript" src="<?php echo base_url("assets/graphs"); ?>/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/graphs"); ?>/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/graphs"); ?>/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/graphs"); ?>/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/graphs"); ?>/plugins/jqplot.pointLabels.min.js"></script>

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
	$function_total = 0 ;
	
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
						$function_total ++;
					}
					
					if( $val['reviewer_overall_rating']['score_rating'] == 'EE' ) {
						$count_EE ++ ;
						$function_total ++;
					}
					
					if( $val['reviewer_overall_rating']['score_rating'] == 'ME' ) {
						$count_ME ++ ;
						$function_total ++;
					}
					
					if( $val['reviewer_overall_rating']['score_rating'] == 'NI' ) {
						$count_NI ++ ;
						$function_total ++;
					}
					
					if( $val['reviewer_overall_rating']['score_rating'] == 'BE' ) {
						$count_BE ++ ;
						$function_total ++;
					}
				
					//print_r($val['reviewer_overall_rating']['score_rating'] => ME);
				}	
			
			}//End Foreach
		}
	}	
	//End Collect Data
	
	//Calculate Percentage
	//$function_total = '';
	$FEE_per = 0;
	$EE_per = 0;
	$ME_per = 0;
	$NI_per = 0;
	$BE_per = 0;
	
	if( $function_total >= 1 ) {
		$FEE_per = round( ( 100 * $count_FEE ) / $function_total , 2);
		$EE_per = round( ( 100 * $count_EE ) / $function_total , 2);
		$ME_per = round( ( 100 * $count_ME ) / $function_total , 2);
		$NI_per = round( ( 100 * $count_NI ) / $function_total , 2);
		$BE_per = round( ( 100 * $count_BE ) / $function_total , 2);
	}
	
	//Draw Graph
?>
<script class="code" type="text/javascript">
$(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        //var s1 = [[[2,5], [6,5], [7,5], [10,5], [7,5]]];
        var ticks = ['FEE<br><?php echo $count_FEE; ?>', 'EE<br><?php echo $count_EE; ?>', 'ME<br><?php echo $count_ME; ?>', 'NI<br><?php echo $count_NI; ?>', 'BE<br><?php echo $count_BE; ?>'];
        var s3 = [ [1,<?php echo $count_FEE; ?>,'<?php echo $FEE_per; ?>%'], [2,<?php echo $count_EE; ?>,'<?php echo $EE_per; ?>%'], [3,<?php echo $count_ME; ?>,'<?php echo $ME_per; ?>%'], [4,<?php echo $count_NI; ?>,'<?php echo $NI_per; ?>%'], [5,<?php echo $count_BE; ?>,'<?php echo $BE_per; ?>%'] ] ;
		
        plot1 = $.jqplot('chart<?php echo $graph_key; ?>', [s3], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
			title: 'Function: <?php echo $business_name; ?> - Total No. of Emp.: <?php echo $function_total; ?>',
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
			axesDefaults: {
				tickOptions: {
				  fontSize: '12pt',
	        	}
    		},
            highlighter: { show: false }
        });
    
        $('#chart<?php echo $graph_key; ?>').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
    });
</script>

<?php
	//End Draw Graph
	
	
//End foreach	
}

?>
<?php echo $last_footer; ?>