
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
      <div class="w-box"> 
      <div class="w-box-header">
        <h4>Add KRA [2013-2014]</h4>
      </div>

      <form action="" method="post" id="validate_extended">
        <div class="w-box-content cnt_b">  
          <div class="row-fluid">
            <div class="span12">
				  <div class="alert alert-info">
                                    <a class="close" data-dismiss="alert">&times;</a>
                                    <strong>Section A:KRA ASSESSMENT - &nbsp;</strong> 
									Breifly describe performance/achevements during the assessment periods. Please use a seprate sheet if space is not adequate. It is important for the 
									appraisar to enter his.her comments to substaintiate the ratings. 
									Your weightage% sum must equal to 100.Please Fill up The following Form
		
                  </div>
              <div class="tabbable tabbable-bordered">
                    <div class="w-box w-box-green" id="invoice_add_edit">
                    <div class="span12">
			   			 <table class="table invE_table table-bordered" id="kra_id" >
						<thead>
							<tr>
								<th style="text-align:center; width:1%;" >Sr. No. </th>
								<th style="text-align:center;">Key Result Area </th>
								<th style="text-align:center;">Performance Target</th>
								<th style="text-align:center;" >Performance Measure</th>
								<th style="text-align:center; width:20px;">Weightage %</th>
							</tr>
						</thead>
						<tbody>
						
						<?php 
						for($i=0;$i<4;$i++)
						{
						$j= $i+1;
						if(($j%2)==0)
						{
						$bgcolor ='background:#ffffff;';
						}
						else
						{
						$bgcolor ='background:#F6F6F6;';
						}
						if($i==0)
						{
						$clas_r= 'class="kra_row"';
						}
						else
						{
						$clas_r='';
						}
						?>
								<tr <?php echo $clas_r; ?> >
							
								<td class="kra_clone_row" style="text-align:center;">
								<?php if($i==3){ ?>
								<i class="icon-plus inv_clone_btn"></i>
								<?php } ?>
								<?php echo $j; ?></td>
								<td style="text-align:center;"><textarea class="span10" name="kra_<?php echo $i; ?>" id="kra_<?php echo $i; ?>" ></textarea></td>
								<td style="text-align:center;"><textarea class="span10" name="perf_target_<?php echo $i; ?>" id="perf_target_<?php echo $i; ?>" ></textarea></td>
								<td style="text-align:center;"><textarea class="span10" name="perf_measure_<?php echo $i; ?>" id="perf_measure_<?php echo $i; ?>" ></textarea></td>
								<!--<td style="text-align:center"><input type="text" class="span10" name="weightage_<?php echo $i; ?>" id="weightage_<?php echo $i; ?>" /></td>-->
								<td style="text-align:left;width:20px;">
								<select name="weightage_<?php echo $i; ?>" id="weightage_<?php echo $i; ?>"  class="span12" >
								<option value="">Select</option>
								<?php for ($per=12;$per<=25;$per++){
								?>
								<option value="<?php echo $per; ?>"><?php echo $per; ?>%</option>
								<?php } ?>
								</select>
								</td>
							</tr>
						<?php
						} 
						?>
						 <tr class="last_row">
                                                    <td colspan="4" style="text-align:right">Total:</td>
													<td style="text-align:left">100%</td>
						</tbody>	
                                        </table>
                        
                  
		
						<div class="formSep">
            			<div align="center">
                        <input type="submit" name="submit" value="Submit" id="submit" class="btn btn-beoro-3">
                        <input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
                      </div>
					  </div>
					   </div>
					  </div>
          </div>
        </div>
        </div>
    	</div>
      </form>
    </div>
  </div>
</div>
</div>




<?php $this->load->view('default/clientadmin/cadmin_last_footer'); ?>
