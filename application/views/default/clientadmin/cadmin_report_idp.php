<?php
/**
* Project Code: PMS
* Version: PMS1
* Object: Template
* Template: Default / clientadmin
* Template Name: cadmin_report_pmsrating.php
* Desc: PMS IDP Report
* Last Update: 08-May-2013
* Author: Team Enrich
** Change Log **
* 14-May-13 Update Add PDF
**/
?>
<?php echo $header; ?>
<?php
//echo '<pre>';
//print_r($reviewer_employees);
//echo '</pre>';
?>
<?php
$segment_1 = $this->uri->segment(1) ;
$segment_2 = $this->uri->segment(2) ;
$segment_3 = $this->uri->segment(3) ;
?>
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12">
      <div id="reviewer_flashmsessage"> </div>
      <?php 
									if(isset($reviewer_employees))
									{
										if(!empty($reviewer_employees))
										{
										?>
      <div class="w-box w-box-orange">
        <div style="float:right; width:100%; margin-right:10px;">
          <div style="width:32px; height:32px; float:right; margin-top:-7px;  margin-left:10px;"><a href="<?php echo site_url("mypdf/pdfidpstatusreport/") . '/'.$segment_3; ?>" target="_blank" ><img src="<?php echo site_url('assets/user/images/default').'/pdficon.jpg'; ?>" height="32" width="32" title="PDF Report"  /></a></div>
          <!-- <div style="width:32px; height:32px; float:right; margin-top:-7px;"><a href="<?php echo site_url("mypdf/excelkrastatusreport/") . '/'.$segment_3; ?>" target="_blank" ><img src="<?php echo site_url('assets/user/images/default').'/excelicon.jpg'; ?>" height="32" width="32" title="Excel Report"  /></i></a></div> -->
        </div>
        <br  />
        <br />
        <div class="w-box-header">
          <h4 style="float:left;height:20px; margin-top:5px;">IDP Report</h4>
          <!--<div style="width:20px; height:20px; margin-left:50px; float:left; margin-top:-7px;"><i class="icsw16-pdf-documents icsw16-white" title="Print PDF"></i></a></div>
								<div style="width:20px; height:20px; float:left; margin-top:-7px;"><i class="icsw16-note-book icsw16-white" title="Excel Report"></i></a></div>-->
        </div>
        <div class="w-box-content">
          <table id="dt_colVis_Reorder" class="table table-striped table-condensed">
            <thead>
              <tr>
                <th style="width:50px;">Sr No</th>
                <th style="width:150px;">Employee Name</th>
                <th style="width:50px;">Emp ID</th>
                <th style="width:100px;">Functions</th>
                <th style="width:70px;">Department</th>
                <th style="width:120px;">Designation</th>
                <th>Details</th>
              </tr>
            </thead>
            <tbody>
              <?php
									$counter = 1 ;
									foreach($reviewer_employees as $key=>$val)
									{
										$name = $val['fname']. ' '.$val['lname'];
										
										//Development Area
										$devinfo = '';
										if( $val['devinfo'] ) {
											$devinfo .= '<ul class="list_a">';
											foreach( $val['devinfo'] as $row ) 
											{
												$devinfo .= '<li>' . $row->development_area . '</li>' ;
											}
											$devinfo .= '</ul>';											
										}
										
										$techinfo = '';
										if( $val['techinfo'] )
										{
											$techinfo .= '<ul class="list_b">';
											foreach( $val['techinfo'] as $row ) 
											{
												$techinfo .= '<li><strong>' . $row->fname .' '. $row->lname . '</strong>: ' . $row->technical_area . '</li>' ;
											}
											$techinfo .= '</ul>';
										
										}
																				
										$behavinfo ='';
										if( $val['behavinfo'] )
										{
											$behavinfo .= '<ul class="list_c">';
											foreach( $val['behavinfo'] as $row ) 
											{
												$behavinfo .= '<li><strong>' . $row->fname .' '. $row->lname . '</strong>: ' . $row->behavioural_area . '</li>' ;
											}
											$behavinfo .= '</ul>';
										
										}
									?>
              <tr>
                <td><?php echo $counter; ?></td>
                <td><?php echo $val['employee_name']; ?></td>
                <td><?php echo $val['employee_id']; ?></td>
                <td><?php echo $val['function_name']; ?></td>
                <td><?php echo $val['department_name']?></td>
                <td><?php echo $val['designation_name']?></td>
                <td><strong>Appraisee Developmental Area:</strong><br />
                  <?php echo $devinfo; ?> <strong>Technical:</strong><br />
                  <?php echo $techinfo; ?> <strong>Behavioral Skill:</strong><br />
                  <?php echo $behavinfo; ?> </td>
                <!-- As Reviewer -->
              </tr>
              <?php
										$counter++;
									}
								?>
            </tbody>
          </table>
        </div>
      </div>
      <?php
							}
									}
									?>
      <!-- confirmation box -->
    </div>
  </div>
</div>
<!-- footer -->
<?php echo $middle_footer; ?> <?php echo $common_js; ?> <?php echo $last_footer; ?>