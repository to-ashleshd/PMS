						 <div class="formSep">
									  <span class="span4 req">Select Role</span>
									  <select name="role_id" id="role_id" onchange="call_employee_list()"  >
										<option value="">---Please Select---</option>
										<?php 
												if(isset($admin_roles))
												{
													if(!empty($admin_roles))
													{
														
														foreach($admin_roles as $key=>$val)
														{
											?>
											<option value="<?php echo $val->client_user_role_id; ?>" ><?php echo $val->rolename; ?></option>
											<?php
														}
													}
												}
											?>
									  </select>
								 </div>
									 <div class="formSep">
									  <span class="span4 req">Select Employee</span>
									  <select name="employee_id" id="employee_id"  >
										<option value="">---Please Select---</option>
											
										</select>
									</div>
									
									<div class="formSep">
									  <label><input type="checkbox" name="is_upper_office" id="is_upper_office" onclick="call_access_level()"  />&nbsp;Would You like to give access of upper Office Type(s)</label>
									</div>
									
									  
									<div class="formSep">
									  <label class="span3"><input type="radio" name="allow_office" id="local_office" value="L" onclick="getdetail()"   />&nbsp;Local</label>
									  <label class="span3"><input type="radio" name="allow_office" id="global_office" value="G" onclick="getdetail()"  />&nbsp;Global</label>
									</div>
									
									<div class="" id="content_office_type">
									
									  </div>
									  <div class="" id="content_access_level">
									
									  </div>
									  <div class="" id="content_access_level_function">
									
									  </div>
									   <div class="" id="content_function_list">
									
									  </div>
									
									<div class="formSep" id="office_address_list">
									
									 
									</div>
									
									
			
									
								  
							  
					
								<div class="formSep">
								<div align="center">
									<input type="submit" name="submit" value="Save" id="submit" class="btn btn-beoro-3" >
									<input type="reset" name="reset" value="Reset" id="reset" class="btn btn-beoro-3">
									
								</div>
								</div>
