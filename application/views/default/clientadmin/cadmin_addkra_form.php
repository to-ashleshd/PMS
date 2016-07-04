<div class="w-box-header" style=" background: none repeat scroll 0 0 #EFF7EC;color:#000000;font-size: 13px;height: 32px;line-height: 32px;padding: 0 10px 1px;border-color: #CCCCCC;border-style: solid;border-width: 1px 1px 1px 1px;">
					<h4>Add KRA</h4>
					</div>
					<div class="w-box-content">
					<div class="span10">
					<div id="div_kra_detail">
									
								<?php
								$i=1;
								?>
								<div class="formSep">
                                        <label class="span3 req">Appraiser: </label>
										<?=$appraiser?>									
                                </div>
							
								<div class="formSep">
                                        <label class="span3 req">Key Result Area: </label>
                                        <textarea class="span8" name="kra[]" id="kra_<?php echo $i; ?>"  ></textarea>
                                    </div>
									<div class="formSep">
                                        <label class="span3 req">Performance Target: </label>
                                        <textarea class="span8" name="perf_target[]" id="perf_target_<?php echo $i; ?>"></textarea>
                                    </div>
									<div class="formSep">
                                        <label class="span3 req">Performance Measure: </label>
                                        <textarea class="span8" name="perf_measure[]" id="perf_measure_<?php echo $i; ?>"  ></textarea>
                                    </div>
									<div class="formSep">
                                        <label class="span3 req">Weight: </label>
                                        <input  name="weight[]" type="text" class="cls_weight span3" title="Remaining Weightage : <?php echo (100-$edit_total_weight); ?>"    id="add_weight_<?php echo $i; ?>"   onblur="calculate_total()" value="" maxlength="2"  />
										<br />
										<label class="span3" style="margin-left:0px;">&nbsp;</label>
										<label class="span8" style="margin-left:0px;"><b>Total: </b><span id="total_weight"><?php echo $edit_total_weight; ?></span> %</label>
                                    </div>
									<div class="formSep">
                                        <label class="span3">Initiative: </label>
                                       <textarea class="span8" name="initiative[]" id="initiative_<?php echo $i; ?>"  ></textarea>
                                    </div>
					
				</div>
				</div>
				
			   
			<div class="formSep" id="kra_buttons" style="display:;">
			<div align="center">
				<input type="submit" name="submit" value="Save As Draft" id="submit" class="btn btn-beoro-3" onclick="calculate_total();">
				<input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
			  </div>
			  </div>