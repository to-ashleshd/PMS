<?php echo $header; ?>
<!-- Collect Info for chart -->
<!-- 
//Correct Spelling
Appraisee
Appraiser
-->
<?php 
	//Count for appraiser
	//Get Values for KRA PMS IDP
	
	//For All Data	
	$appraise = 0;
	$appraiser = 0;
	$reviewer = 0 ;
	$complete = 0;
	$unknown = 0;
	
	foreach( $graph_summery as $key=>$val ) {
	//print_r($val);
		if( $val->submit_status <= 1 ) {
			//For Next year kra
		}else if( $val->submit_status <= 3 ) {
			$appraise = $appraise + $val->howmany ;
		}
		else if($val->submit_status <= 6 ) {
			$appraiser = $appraiser + $val->howmany ;
		}
		else if($val->submit_status <= 7 ) {
			$reviewer = $reviewer + $val->howmany ;
		}
		else if( $val->submit_status == 8 ) {
			$complete = $complete + $val->howmany ;
		}
		else {
			$unknown = $unknown + $val->howmany ;
		}
	
	}


//For reviewer
	$r_appraise = 0;
	$r_appraiser = 0;
	$r_reviewer = 0 ;
	$r_complete = 0;
	$r_unknown = 0;
	
	foreach( $graph_reviewer as $key=>$val ) {
	//print_r($val);
		/**
		if( $val->submit_status == 0 ) {
			//For Next year kra
			//User is registered but did not fillup PMS or IDP
			//$r_appraise = $r_appraise + $val->howmany ;
		} else if( $val->submit_status <= 1 ) {
			//For Next year kra
		}else if( $val->submit_status <= 3 ) {
			//$r_appraise = $r_appraise + $val->howmany ;
		}
		else if($val->submit_status <= 6 ) {
			$r_appraiser = $r_appraiser + $val->howmany ;
		}
		else if($val->submit_status <= 7 ) {
			$r_reviewer = $r_reviewer + $val->howmany ;
		}
		else if( $val->submit_status == 8 ) {
			$r_complete = $r_complete + $val->howmany ;
		}
		else {
			$r_unknown = $r_unknown + $val->howmany ;
		}
		**/
		
		if( $val->submit_status == 0 ) {
			//For Next year kra
			//User is registered but did not fillup PMS or IDP
			//$r_appraise = $r_appraise + $val->howmany ;
		} else if( $val->submit_status == 1 ) {
			//For Next year kra
			$r_appraise = $r_appraise + $val->howmany ;
		} else if( $val->submit_status == 2 ) {
			$r_appraiser = $r_appraiser + $val->howmany ;
		} else if( $val->submit_status == 3 ) {
			$r_appraiser = $r_appraiser + $val->howmany ;
		} else if( $val->submit_status == 4 ) {
			$r_appraiser = $r_appraiser + $val->howmany ;
		} else if( $val->submit_status == 5 ) {
			$r_appraiser = $r_appraiser + $val->howmany ;
		} else if( $val->submit_status == 6 ) {
			$r_reviewer = $r_reviewer + $val->howmany ;
		} else if( $val->submit_status == 7 ) {
			$r_reviewer = $r_reviewer + $val->howmany ;
		} else if( $val->submit_status == 8 ) {
			$r_complete = $r_complete + $val->howmany ;
		}
		else {
			$r_unknown = $r_unknown + $val->howmany ;
		}
	
	}


//For Appraiser
	$a_appraise = 0;
	$a_appraiser = 0;
	$a_reviewer = 0 ;
	$a_complete = 0;
	$a_unknown = 0;
	
	/**
	foreach( $graph_appraiser as $key=>$val ) {
	//print_r($val);
		if( $val->submit_status == 0 ) {
			//For Next year kra
			//User is registered but did not fillup PMS or IDP
			$a_appraise = $a_appraise + $val->howmany ;
		}
		else if( $val->submit_status <= 1 ) {
			//For Next year kra
		}else if( $val->submit_status <= 3 ) {
			$a_appraise = $a_appraise + $val->howmany ;
		}
		else if($val->submit_status <= 6 ) {
			$a_appraiser = $a_appraiser + $val->howmany ;
		}
		else if($val->submit_status <= 7 ) {
			$a_reviewer = $a_reviewer + $val->howmany ;
		}
		else if( $val->submit_status == 8 ) {
			$a_complete = $a_complete + $val->howmany ;
		}
		else {
			$a_unknown = $a_unknown + $val->howmany ;
		}
	
	}
	**/
	//or $val->submit_status == 0.2 - Pending with Appraiser for KRA approval
	foreach( $graph_appraiser as $key=>$val ) {
	//print_r($val);
		if( $val->submit_status == 0 ) {
			//For Next year kra
			//User is registered but did not fillup PMS or IDP
			//$r_appraise = $r_appraise + $val->howmany ;
		} else if( $val->submit_status == 1 ) {
			//For Next year kra
			$a_appraise = $a_appraise + $val->howmany ;
		} else if( $val->submit_status == 2  ) {
			$a_appraiser = $a_appraiser + $val->howmany ;
		} else if( $val->submit_status == 3 ) {
			$a_appraiser = $a_appraiser + $val->howmany ;
		} else if( $val->submit_status == 4 ) {
			$a_appraiser = $a_appraiser + $val->howmany ;
		} else if( $val->submit_status == 5 ) {
			$a_appraiser = $a_appraiser + $val->howmany ;
		} else if( $val->submit_status == 6 ) {
			$a_reviewer = $a_reviewer + $val->howmany ;
		} else if( $val->submit_status == 7 ) {
			$a_reviewer = $a_reviewer + $val->howmany ;
		} else if( $val->submit_status == 8 ) {
			$a_complete = $a_complete + $val->howmany ;
		}
		else {
			$a_unknown = $a_unknown + $val->howmany ;
		}
	
	}
	
	
	
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	var whoiam = '<?php echo $whoiam; ?>'

      google.load("visualization", "1", {packages:["corechart"]});
      //google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['PMS Status', 'Count'],
          ['Appraisee',     <?php echo $appraise; ?>],
          ['Appraiser',      <?php echo $appraiser; ?>],
          ['Reviewer',  <?php echo $reviewer; ?>],
          ['Complete', <?php echo $complete; ?>],
		  
        ]);

        var options = {
          title: 'Global Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
	  
	  
	  function drawReviewer() {
        var data = google.visualization.arrayToDataTable([
          ['PMS Status', 'Count'],
          ['Pending with Appraisee',     <?php echo $r_appraise; ?>],
          ['Pending with Appraiser',      <?php echo $r_appraiser; ?>],
          ['Pending with Reviewer',  <?php echo $r_reviewer; ?>],
          ['Complete', <?php echo $r_complete; ?>],
		  
        ]);

        var options = {
          title: 'I am a Reviewer'
        };

        var chart_r = new google.visualization.PieChart(document.getElementById('chart_div_rev'));
		
        chart_r.draw(data, options);
		google.visualization.events.addListener(chart_r, 'select', selectHandler);
      }
	  
	  function drawAppraiser() {
        var data_a = google.visualization.arrayToDataTable([
          ['PMS Status', 'Count'],
          ['Pending with Appraisee', <?php echo $a_appraise; ?>],
          ['Pending with Appraiser', <?php echo $a_appraiser; ?>],
          ['Pending with Reviewer', <?php echo $a_reviewer; ?>],
          ['Complete', <?php echo $a_complete; ?>],
		  
        ]);

        var options = {
          title: 'I am a Appraiser'
        };

        var chart_a = new google.visualization.PieChart(document.getElementById('chart_div_a'));
		 google.visualization.events.addListener(chart_a, 'select', selectHandler);
        chart_a.draw(data_a, options);
      }
	  
	  
	  //Display all Graphoes
	  function drawVisualization() {
	  	//drawChart();
		
		if(whoiam == 'appraiser' || whoiam == 'reviewer' ) {
			drawAppraiser();
		}
		if(whoiam == 'reviewer') {
			drawReviewer();
		}
		
	  }
	  
	  function selectHandler_a() {
	  	alert( ' Click on appraiser');
			/**
          var selectedItem = data_a.getSelection()[0];
		  alert(selectedItem);
          if (selectedItem) {
            var topping = data_a.getValue(selectedItem.row, 0);
            alert('The user selected ' + topping );
          }
		  **/
        }
		
		
		 function selectHandler_r() {
	  	alert( ' Click on reviewer');
		var selectedItem = chart_r.getSelection()[0];
		  alert(selectedItem);
          if (selectedItem) {
            var topping = data_a.getValue(selectedItem.row, 0);
            alert('The user selected ' + topping );
          }
        }
	  
	  
	  function selectHandler() {
	  	//redirect to status report
		//alert( 'Redirect to Report');
		
		//Redirect to status report
		window.location = '<?php echo site_url('apraiser/statusreport'); ?>';
		
      }
	  
	  
	  
	  google.setOnLoadCallback(drawVisualization);
	 
	 
	 

    </script>
<!-- End Collect Info for chart -->

 <!-- main content -->
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span8">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4>Dashboard</h4>
                                <i class="icsw16-graph icsw16-white pull-right"></i>
                            </div>
							
							
                            <div class="w-box-content cnt_a">
							<!-- Dashboard Data -->
							<!-- New Tab -->
							<div class="row-fluid">
							<div class="span12">
                                        <div class="tabbable tabbable-bordered">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#tb1_a1">Announcements</a></li>
                                                <!-- <li><a data-toggle="tab" href="#tb1_b1">Events</a></li> -->
                                            </ul>
                                            <div class="tab-content">
                                                <div id="tb1_a1" class="tab-pane active">
													<?php foreach($announcements as $row_a ) : ?>
														<p class="text-info" style="font-size:16px;"><?php echo $row_a->announcement_subject; ?></p>
														<p><?php echo $row_a->announcement_desc; ?></p>
													<?php endforeach; ?>
												
                                                    <!--
													<p>Announcement 1</p>
                                                    <p>This is about announcement info. This is about announcement info.This is about announcement info.</p>
													-->
                                                </div>
												<!--
                                                <div id="tb1_b1" class="tab-pane">
                                                    <p>Events  2</p>
                                                    <p>This is about announcement info. This is about announcement info.This is about announcement info.</p>
                                                </div>
												-->                                                
                                            </div>
                                        </div>
                                    </div>
							</div>
							<!-- End New Tab -->
							
							
							
							<!--
							<div id="chart_div" style="width: 650px; height: 400px;"></div>
							-->
							<?php if( $whoiam == 'appraiser' or $whoiam == 'reviewer' ): ?>
							<div id="chart_title" style="text-align:center"><h3>My Team PMS Status</h3></div>
							<?php endif; ?>
							
							<div style="clear:both"></div>
							<?php if( $whoiam == 'reviewer' ): ?>
							<div id="chart_div_rev" style="width: 380px; height: 300px; float:left;"></div>
							<?php endif; ?>
							 <?php if( $whoiam == 'appraiser' or $whoiam == 'reviewer' ): ?>
							<div id="chart_div_a" style="width: 380px; height: 300px; float:left;"></div>
							<?php endif; ?>
							<div style="clear:both"></div>
							
                            </div>
                        </div>
                    </div>
					<!-- Todo List -->
					<?php echo $todoinfo; ?>
					<!-- End Todo List -->	
					
              </div>
            </div>
            <div class="footer_space"></div>
        </div> 


         <?php echo $middle_footer; ?>
   

<?php echo $common_js; ?>
    <!-- Dashboard JS -->
        <!-- jQuery UI -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/jquery-ui/jquery-ui-1.9.2.custom.min.js"></script>
        <!-- touch event support for jQuery UI -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/jquery-ui/jquery.ui.touch-punch.min.js"></script>
        <!-- colorbox -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/colorbox/jquery.colorbox.min.js"></script>
        <!-- fullcalendar -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/fullcalendar/fullcalendar.min.js"></script>
        <!-- flot charts -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.resize.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.pie.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.orderBars.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.tooltip.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.time.js"></script>
        <!-- responsive carousel -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/carousel/plugin.min.js"></script>
        <!-- responsive image grid -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/wookmark/jquery.imagesloaded.min.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/wookmark/jquery.wookmark.min.js"></script>

            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/pages/beoro_dashboard.js"></script>
<?php echo $last_footer; ?>	 