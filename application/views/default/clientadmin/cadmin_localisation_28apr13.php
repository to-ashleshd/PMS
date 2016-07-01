<!-- main content -->
<?php
//Common message for did not find any active company
//active_company_count
$err_active_not_found = 'Please select / create at least one active company.';
?>
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12">
      <div class="w-box w-box-green">
        <div class="w-box-header">
          <h4>Localisation (Product)</h4>
          <i class="icsw16-settings icsw16-white pull-right"></i> </div>
        <div class="w-box-content cnt_a">
          <div class="row-fluid">
            <div class="span12">
              <p class="heading_a">Localisation</p>
              <?php if($this->session->userdata('warning')): ?>
              <?php $warning =$this->session->userdata('warning'); ?>
              <div class="alert alert-error"> <a data-dismiss="alert" class="close">&times;</a><strong>Warning!</strong> <?php echo $warning; ?></div>
              <?php endif; ?>
              <?php $this->session->unset_userdata('warning');?>
              <?php if($this->session->userdata('success')): ?>
              <?php $success =$this->session->userdata('success'); ?>
              <div class="alert alert-success"><a data-dismiss="alert" class="close">&times;</a><strong>Success!</strong> <?php echo $success; ?></div>
              <?php endif; ?>
              <?php $this->session->unset_userdata('success');?>
			   <div id="msg"></div>
              <!-- Tab Settings -->
              <div class="row-fluid">
                <div class="tabbable tabbable-bordered">
                  <ul class="nav nav-tabs">
				    
                    <li class="<?php echo ($tab == 'tb1_b'? 'active' : '') ?>"><a data-toggle="tab" href="#tb1_b">Country Master</a></li>
                    <li class="<?php echo ($tab == 'tb1_c'? 'active' : '') ?>" ><a data-toggle="tab" href="#tb1_c">State Master</a></li>
                    <li class="<?php echo ($tab == 'tb1_d'? 'active' : '') ?>" ><a data-toggle="tab" href="#tb1_d">City Master</a></li>
                    <li id="tab_business" class="<?php echo ($tab == 'tb1_business'? 'active' : '') ?>" ><a data-toggle="tab" href="#tb1_business">Business</a></li>
					<li class="<?php echo ($tab == 'tb1_e'? 'active' : '') ?>" ><a data-toggle="tab" href="#tb1_e">Company Master</a></li>
                    <li class="<?php echo ($tab == 'tb1_f'? 'active' : '') ?>" ><a data-toggle="tab" href="#tb1_f">Office Type</a></li>
                    <li id="officeaddress" class="<?php echo ($tab == 'tb1_g'? 'active' : '') ?>" ><a data-toggle="tab" href="#tb1_g">Office Address</a></li>
                    <li class="<?php echo ($tab == 'tb1_h'? 'active' : '') ?>" ><a data-toggle="tab" href="#tb1_h">Department</a></li>
                    <li id="tab_departmentoffice" class="<?php echo ($tab == 'tb1_i'? 'active' : '') ?>" ><a data-toggle="tab" href="#tb1_i">Department And Offices</a></li>
					<li id="tab_businesscompany" class="<?php echo ($tab == 'tb1_businesscompany'? 'active' : '') ?>" ><a data-toggle="tab" href="#tb1_businesscompany">Business Company</a></li>
                  
				  
				  
				  </ul>
                  <div class="tab-content">
				  
				  <!-- Tab Business -->
				  <div id="tb1_business" class="tab-pane <?php echo ($tab == 'tb1_business'? 'active' : '') ?>">
				  	<p class="heading_a">Business Info</p>
					 <?php echo $business_tab; ?>
				  </div>				  
				  <!-- End Tab Business -->
				  
				  
				  
                    <!-- Tab 1 -->					
                    <div id="tb1_a" class="tab-pane " >
                      <p class="heading_a">ClientAdmin List with Address: Level 2</p>
                      <p class="heading_a">ClientAdminUsers (Created By ClientAdmin) List with Address: Level 2.1</p>
                      <p class="heading_a">Users List: Level 3</p>
                      <div class="formSep">
                        <button class="btn btn-beoro-3">Update</button>
                      </div>
                    </div>
                    <!-- End Tab 1 -->
                    <!-- Tab 2 -->

                    <div id="tb1_b" class="tab-pane <?php echo ($tab == 'tb1_b'? 'active' : '') ?>"  >
                      <form action="<?php echo site_url($action); ?>" method="post" onsubmit="return call_country_validation()">
                        <p class="heading_a">Country Master</p>
                        <div class="w-box w-box-orange">
                          <div class="w-box-header">
                            <h4>Deactivated Country List</h4>
                          </div>
                          <div class="w-box-content">
                            <table id="dt_colVis_Reorder_client_country" class="table table-striped table-condensed">
                              <thead>
                                <tr>
                                  <th>id</th>
                                  <th>Country Name</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
					  if(!empty($deactivated_country_result))
					  {
							 foreach($deactivated_country_result as $key=>$val)
							 {
							 	
							  ?>
                                <tr>
                                  <td><?php echo  $val->countrymaster_id; ?></td>
                                  <td><?php echo  $val->country_name; ?></td>
                                  <?php if($val->status==1)
										  {
											$title='Suspend/Pause';
											$status_name ='Active';
										  }
										  elseif($val->status==0)
										  {
										  	$title='Activate';
											$status_name ='Suspended';
										  }
										  else
										  {
										  	$title='Not available';
											$status_name='Not available';
										  }
								   ?>
                                  <td><?php echo  $status_name; ?></td>
                                  <td><div class="btn-group"> <a href="<?php echo site_url('localisation/updatecountrystatus/'.$val->countrymaster_id.'/'.$val->status); ?>" class="btn btn-mini" title="<?php echo $title; ?>"><i class="icsw16-acces-denied-sign"></i></a> </div></td>
                                </tr>
                                <?php
								 } }
                                                                 else
                                                                 {
								 ?>
                                <tr>
                                  <td colspan="4" align="center"><center>
                                      No Result!
                                    </center></td>
                                </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="formSep">
                          <label >Select Country</label>
                          <div class="formSep">
                            <label class="span3" >
                            <select id="countrymaster_country" name="countrymaster_country" class="span12" >
                              <option value="">--Please Select--</option>
                              <?php
						   foreach($country_master as $key=>$val)
						   {
						   ?>
                              <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                              <?php
						   }
						   ?>
                            </select>
                            </label>
                            <label class="span3" style="margin-left:10px;">
                            <div class="btn-group" ><a href="#" class="btn btn-mini" > <i class="icon-pencil" id="countrymaster_edit" title="Edit"  onclick="call_country()"></i></a> &nbsp; &nbsp; <a href="#" class="btn btn-mini" > <i class="icsw16-acces-denied-sign" title="Block" onclick="call_updatecountry_status()" ></i></a> </div>
                            <!-- <input type="text" name="country_edit" id="country_edit" placeholder="New Country name">-->
                            </label>
                          </div>
                          <br>
                          <br>
                          <input type="hidden" name="hcountry_id_country" id="hcountry_id_country" value=""  />
                          <input type="hidden" name="country_status" id="cntry_status" value=""  />
                          <input type="hidden" name="code_status" id="code_status" value=""  />
                          <label class="heading_a" >New Country Name</label>
                          <div class="formSep">
                            <label class="span3">Country Name<span class="required">*</span></label>
                            <label class="span3">
                            <input  type="text" name="country" id="country" value="" placeholder="New Country name" onblur="" onchange="is_char('country','lbl_country_name','YES','Country Name'),checkcountryexist('country','lbl_country_name')" >
                            </label>
                            <label class="span4  error" id="lbl_country_name"></label>
                          </div>
                          <div class="formSep">
                            <label class="span3">ISO Code1<span class="required">*</span></label>
                            <label class="span3">
                            <input type="text" name="countrycode1" id="countrycode1"  value="" placeholder="Country CODE" onchange="is_charwithoutspace('countrycode1','lbl_iso_code1','YES','Country Code'),checkcountryISOCodeOne('countrycode1','lbl_iso_code1')" >
                            </label>
                            <label class="span4 error" id="lbl_iso_code1"></label>
                          </div>
                          <div class="formSep">
                            <label class="span3">ISO Code2</label >
                            <label class="span3">
                            <input type="text" name="countrycode2" id="countrycode2" value=""  placeholder="Country CODE" onchange="is_charwithoutspace('countrycode2','lbl_iso_code2','NO','Country Code 2')" >
                            </label>
                            <label class="span4 error" id="lbl_iso_code2"></label>
                          </div>
                          <div class="formSep"> <br>
                            <br>
                            <button class="btn btn-beoro-3" name="updatecountry" value="<?php echo $button_text; ?>"><?php echo $button_text; ?></button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- End Tab 2 -->
                    <!-- Tab 3 -->
                    <div id="tb1_c" class="tab-pane <?php echo ($tab == 'tb1_c'? 'active' : '') ?> ">
                      <form action="<?php echo site_url($action); ?>" method="post" onsubmit="return check_state_validation()" >
                        <p class="heading_a">State Master</p>
                        <div class="w-box w-box-orange">
                          <div class="w-box-header">
                            <h4>Deactivated State List</h4>
                          </div>
                          <div class="w-box-content">
                            <table id="dt_colVis_Reorder_client_state" class="table table-striped table-condensed">
                              <thead>
                                <tr>
                                  <th>Id</th>
                                  <th>State Name</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                                          if(!empty($deactivated_state_result))
                                                          {
							 foreach($deactivated_state_result as $key=>$val)
							 {
							 	
							  ?>
                                <tr>
                                  <td><?php echo  $val->statemaster_id; ?></td>
                                  <td><?php echo  $val->state_name; ?></td>
                                  <?php if($val->status==1)
										  {
											$title='Suspend/Pause';
											$status_name ='Active';
										  }
										  elseif($val->status==0)
										  {
										  	$title='Activate';
											$status_name ='Suspended';
										  }
										  else
										  {
										  	$title='Not available';
											$status_name='Not available';
										  }
								   ?>
                                  <td><?php echo  $status_name; ?></td>
                                  <td><div class="btn-group"> <a href="<?php echo site_url('localisation/updatestatestatus/'.$val->statemaster_id.'/'.$val->status); ?>" class="btn btn-mini" title="<?php echo $title; ?>"><i class="icsw16-acces-denied-sign"></i></a> </div></td>
                                </tr>
                                <?php
								 } }
                                                                 else
                                                                 {
								 ?>
                                <tr>
                                  <td colspan="4" align="center"><center>
                                      No Result!
                                    </center></td>
                                </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="formSep">
                          <label class="span2" >Select Country</label>
                          <label class="span3" >
                          <select id="country_state" name="country_state"  onchange="call_generalstate('country_state','state_state')" >
                            <option value="">--Please Select--</option>
                            <?php
						   foreach($country_master as $key=>$val)
						   {
						   ?>
                            <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                            <?php
						   }
						   ?>
                          </select>
                          </label>
                        </div>
                        <div class="formSep">
                          <label class="span2" >Select State</label>
                          <label class="span3" >
                          <select id="state_state" name="state_state"  >
                          </select>
                          </label>
                          <label class="span3" style="margin-left:10px;">
                          <div class="btn-group" ><a href="#" class="btn btn-mini" > <i class="icon-pencil" title="Edit" onclick="call_edit_state()" ></i></a>&nbsp;&nbsp; <a href="#" class="btn btn-mini" > <i class="icsw16-acces-denied-sign" onclick="call_updatestate_status()" title="Block"></i> </a></div>
                          </label>
                        </div>
                        <br>
                        <br>
                        <label class="heading_a " >New State Name</label>
                        <input type="hidden" name="hcountry_new_state" id="hcountry_new_state" value=""  />
                        <input type="hidden" name="hstate_status" id="hstate_status" value=""  />
                        <div class="formSep">
                          <label class="span2" >Select Country<span class="required">*</span></label>
                          <label class="span3" >
                          <select id="country_new_state" name="country_new_state" onblur="madeselection('country_new_state','lbl_state_country','country')" >
                            <option value="">--Please Select--</option>
                            <?php
						   foreach($country_master as $key=>$val)
						   {
						   ?>
                            <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                            <?php
						   }
						   ?>
                          </select>
                          </label>
                          <label class="span3 error" id="lbl_state_country"> </label>
                        </div>
                        <div class="formSep">
                          <label class="span2">New State Name<span class="required">*</span></label>
                          <label class="span3">
                          <input type="text" id="state_new_state" name="state_new_state" value="" placeholder="New State name" onblur="is_char('state_new_state','lbl_state_name','YES','State Name'),checkstateexist('state_new_state','lbl_state_name','country_new_state','lbl_state_country')">
                          </label>
                          <label class="span3 error" id="lbl_state_name"></label>
                        </div>
                        <br>
                        <br>
                        <div class="formSep">
                          <button class="btn btn-beoro-3" name="updatestate" value="<?php echo $button_text; ?>"><?php echo $button_text; ?></button>
                        </div>
                      </form>
                    </div>
                    <!-- End Tab 3 -->
                    <!-- Tab 4 -->
                    <div id="tb1_d" class="tab-pane <?php echo ($tab == 'tb1_d'? 'active' : '') ?>">
                      <form action="<?php echo site_url($action);  ?>" method="post" onsubmit="return call_city_validation()">
                        <p class="heading_a">City Master</p>
                        <div class="w-box w-box-orange">
                          <div class="w-box-header">
                            <h4>Deactivated City List</h4>
                          </div>
                          <div class="w-box-content">
                            <table id="dt_colVis_Reorder_client_city" class="table table-striped table-condensed">
                              <thead>
                                <tr>
                                  <th>Id</th>
                                  <th>City Name</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
							  if(!empty($deactivated_city_result))
							  {
							 foreach($deactivated_city_result as $key=>$val)
							 {
							 	
							  ?>
                                <tr>
                                  <td><?php echo  $val->citymaster_id; ?></td>
                                  <td><?php echo  $val->city_name; ?></td>
                                  <?php if($val->status==1)
										  {
											$title='Suspend/Pause';
											$status_name ='Active';
										  }
										  elseif($val->status==0)
										  {
										  	$title='Activate';
											$status_name ='Suspended';
										  }
										  else
										  {
										  	$title='Not available';
											$status_name='Not available';
										  }
								   ?>
                                  <td><?php echo  $status_name; ?></td>
                                  <td><div class="btn-group"> <a href="<?php echo site_url('localisation/updatecitystatus/'.$val->citymaster_id.'/'.$val->status); ?>" class="btn btn-mini" title="<?php echo $title; ?>"><i class="icsw16-acces-denied-sign"></i></a> </div></td>
                                </tr>
                                <?php
								 } }
                                                                 else
                                                                 {
								 ?>
                                <tr>
                                  <td colspan="4" align="center"><center>
                                      No Result!
                                    </center></td>
                                </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="formSep">
                          <label class="span2" >Select Country</label>
                          <label class="span3" >
                          <select id="country_city" name="country_city" onchange="call_stateforcity()" >
                            <option value="">--Please Select--</option>
                            <?php
						   foreach($country_master as $key=>$val)
						   {
						   ?>
                            <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                            <?php
						   }
						   ?>
                          </select>
                          </label>
                        </div>
                        <div class="formSep">
                          <label class="span2" > Select State</label>
                          <label class="span3" >
                          <select id="state_city" name="state_city"  onchange="call_cityforcity()">
                          </select>
                          </label>
                        </div>
                        <div class="formSep">
                          <label class="span2" > Select City</label>
                          <label class="span3" >
                          <select id="city_city" name="city" >
                          </select>
                          </label>
                          <label class="span3" style="margin-left:10px;">
                          <div class="btn-group" ><a href="#" class="btn btn-mini" > <i class="icon-pencil" title="Edit" onclick="call_edit_city()"></i></a>&nbsp;&nbsp; <a href="#" class="btn btn-mini" > <i class="icsw16-acces-denied-sign" title="Block" onclick="call_updatecity_status()" ></i> </a></div>
                          </label>
                          <br>
                          <br>
                        </div>
                        <input type="hidden" name="hcity_new_city" id="hcity_new_city" value="" />
                        <input type="hidden" name="hcity_status" id="hcity_status" value="" />
                        <label class="heading_a">New City Name</label>
                        <div class="formSep">
                          <label class="span2" >Select Country<span class="required">*</span></label>
                          <label class="span3" >
                          <select id="country_new_city" name="country_new_city"   onchange="call_generalstate('country_new_city','state_new_city')" onblur="madeselection('country_new_city','lbl_country_new_city','Country')">
                            <option value="">--Please Select--</option>
                            <?php
						   foreach($country_master as $key=>$val)
						   {
						   ?>
                            <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                            <?php
						   }
						   ?>
                          </select>
                          </label>
                          <label class="span4 error" id="lbl_country_new_city" ></label>
                        </div>
                        <div class="formSep">
                          <label class="span2" >Select State<span class="required">*</span></label>
                          <label class="span3" >
                          <select id="state_new_city" name="state_new_city" onblur="madeselection('state_new_city','lbl_state_new_city','State')" >
                          </select>
                          </label>
                          <label class="span4 error" id="lbl_state_new_city" ></label>
                        </div>
                        <div class="formSep">
                          <label class="span2" >New City Name<span class="required">*</span></label>
                          <label class="span3" >
                          <input type="text" name="city_new_city" id="city_new_city" placeholder="New city name" onblur="is_char('city_new_city','lbl_city_new_city','YES','City Name'),checkcityexist('city_new_city','lbl_city_new_city','country_new_city','lbl_country_new_city','state_new_city','lbl_state_new_city')">
                          </label>
                          <label class="span4 error" id="lbl_city_new_city" ></label>
                        </div>
                        <div class="formSep"> <br>
                          <br>
                          <button class="btn btn-beoro-3" name="updatecity" value="<?php echo $button_text; ?>"><?php echo $button_text; ?></button>
                        </div>
                      </form>
                    </div>
                    <!-- End Tab 4 -->
                    <!-- Tab 5 -->
                    <div id="tb1_e" class="tab-pane <?php echo ($tab == 'tb1_e'? 'active' : '') ?>">
                      <p class="heading_a">List of Company</p>
                      <?php 
						
						?>
                      <!-- Start Company List -->
                      <div class="w-box w-box-orange">
                        <div class="w-box-header">
                          <h4>Company List</h4>
                        </div>
                        <div class="w-box-content">
                          <?php
						/*  echo "<pre>";
						  print_r($update_company_master);
						  echo "</pre>";*/
						  ?>
                          <table id="dt_colVis_Reorder_client" class="table table-striped table-condensed">
                            <thead>
                              <tr>
                                <th>Id</th>
                                <th>Company Name</th>
                                <th>Address</th>
                                <th>State, City</th>
                                <th>Zip</th>
                                <th>Country</th>
                                <th>Status</th>
                                <th>Action</th>
                                <!--  <th>Status</th>-->
                              </tr>
                            </thead>
                            <tbody>
                              <?php
							 foreach($company_master as $key=>$val)
							 {
                                 $this->load->model('countrymodel');
							 	$show_country_name = $this->countrymodel->getCountry($val->countrymaster_id);
                                 $show_state_name = $this->countrymodel->getState($val->statemaster_id);
                                 $show_city_name = $this->countrymodel->getCity($val->citymaster_id);
								
								 
								     if($val->status==1)
										  {
											$show_cmp_title='Suspend/Pause';
											$cmp_status_name ='Active';
										  }
										  elseif($val->status==0)
										  {
										  	$show_cmp_title='Activate';
											$cmp_status_name ='Suspended';
										  }
										  else
										  {
										  	$show_cmp_title='Not available';
											$cmp_status_name='Not available';
										  }
								   
							  ?>
                              <tr>
                                <td><?php echo  $val->company_master_id; ?></td>
                                <td><?php echo  $val->company_name; ?></td>
                                <td><?php if(!empty($val->area)) { echo  $val->area.', ';} echo $val->street ; ?></td>
                                <td><?php echo $show_state_name->state_name.', '.$show_city_name->city_name; ?></td>
                                <td><?php echo $val->zipcode; ?></td>
                                <td><?php echo $show_country_name->country_name; ?></td>
                                <td><?php echo $cmp_status_name; ?></td>
                                <!--  <td><?php //echo  $status_name; ?></td>-->
                                <td><div class="btn-group"> <a href="<?php echo   site_url('localisation/updatecompany/'.$val->company_master_id); ?>" class="btn btn-mini" title="Edit"><i class="icon-pencil"></i></a>
                                    <!--<a href="#" class="btn btn-mini" title="View"><i class="icon-eye-open"></i></a> -->
                                    <a href="<?php echo site_url('localisation/updatecompanystatus/'.$val->company_master_id.'/'.$val->status); ?>" class="btn btn-mini" title="<?php echo $show_cmp_title; ?>"> <i class="icsw16-acces-denied-sign"></i> </a> </div></td>
                              </tr>
                              <?php
								 }
								 ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <!-- End Company List -->
                      <br>
                      <br>
                      <?php 
							if(isset($ismulticompany))
								{
									if($ismulticompany=='Y' || (($ismulticompany=='N')  && (count($company_master)<1)) || (!empty($update_company_master) ) )
									{
						?>
                      <p class="heading_a">Company Master</p>
                      <form action="<?php echo site_url($action); ?>" method="post" name="companymaster" id="validate_field_types">
                        <input type="hidden" class="span3" name="company_id" id="company_id" value="<?php if(isset($update_company_master['company_master_id'])) { echo $update_company_master['company_master_id']; }?>">
                        <input type="hidden" class="span3" name="address_id" id="address_id" value="<?php if(isset($update_company_master['addressmaster_id'])) { echo $update_company_master['addressmaster_id']; }?>">
                        <div class="formSep">
                          <div class="span6">
                            <div class="formSep">
                              <label class="span4">Company name<span class="required">*</span></label>
                              
                              <input type="text"  name="company_name" id="company" placeholder="Company Name" value="<?php if(isset($update_company_master['company_name'])) { echo $update_company_master['company_name']; }?>" >
                              
                              </label>
                            </div>
                            <!--<div class="formSep">
<label class="req span4">Address 1</label>
<input type="text" name="address1" id="address1" placeholder="Address 1" value="<?php //if(isset($update_company_master['address_1'])) { echo $update_company_master['address_1']; }?>">
</div>-->
                            <div class="formSep">
                              <label class="req span4">Plot no./Office No.</label>
                              <input type="text" name="plot_office_no" id="plot_office_no" placeholder="Plot no./Office No." value="<?php if(isset($update_company_master['plot_no'])) { echo $update_company_master['plot_no']; }?>">
                            </div>
                            <div class="formSep">
                              <label class="span4">Area/Local/Sector</label>
                              <input type="text" name="area" id="area" placeholder="Area/Local/Sector" value="<?php if(isset($update_company_master['area'])) { echo $update_company_master['area']; }?>">
                            </div>
                            <div class="formSep">
                              <label class="span4">Street/Road/Lane</label>
                              <input type="text" name="street" id="street" placeholder="Street/Road/Lane" value="<?php if(isset($update_company_master['street'])) { echo $update_company_master['street']; }?>">
                            </div>
                            <div class="formSep">
                              <label class="span4">Landmark</label>
                              <input type="text" name="landmark" id="landmark" placeholder="Landmark" value="<?php if(isset($update_company_master['landmark'])) { echo $update_company_master['landmark']; }?>">
                            </div>
                          </div>
                          <div class="span6">
                            <div class="formSep">
                              <label class="span4">Select Country</label>
                              <?php $cntry_id =''; if(isset($update_company_master['countrymaster_id'])) { $cntry_id = $update_company_master['countrymaster_id']; } else { $cntry_id =''; } 
$ste_id =''; if(isset($update_company_master['statemaster_id'])) { $ste_id = $update_company_master['statemaster_id']; } else { $ste_id =''; } 
$cty_id =''; if(isset($update_company_master['citymaster_id'])) { $cty_id = $update_company_master['citymaster_id']; } else { $cty_id =''; } 

?>
                              <select id="country_company" name="country_company" class="span6"  onchange="call_generalstate('country_company','state_company')">
                                <option value="">--Please Select--</option>
                                <?php
						  
						   foreach($country_master as $key=>$val)
						   {
						   ?>
                                <option value="<?php echo $key; ?>" <?php echo ($cntry_id == $key? 'selected="selected"' : '') ?> ><?php echo $val; ?></option>
                                <?php						 
						   }
						   ?>
                              </select>
                            </div>
                            <div class="formSep">
                              <label class="span4">Select State</label>
                              <!--<select id="state_company" name="state_company" class="span5" onblur="calldisabled(this.value)" onchange="call_generalcity('country_company','state_company','city_company')">-->
                              <select id="state_company" name="state_company" class="span5"  onchange="call_generalcity('country_company','state_company','city_company')">
                                <option value="">--Please Select--</option>
                                <?php
						  if(isset($state_master))
						  {
						   foreach($state_master as $key=>$val)
						   {
						   ?>
                                <option value="<?php echo $key; ?>" <?php echo ($ste_id == $key? 'selected="selected"' : '') ?> ><?php echo $val; ?></option>
                                <?php						 
						   }
						  }
						   ?>
                              </select>
                              <!--<input class="span3" type="text" name="otherstate" id="otherstate" placeholder="Other State"  <?php echo ($ste_id != ''? 'disabled="disabled"' : '') ?>>-->
                            </div>
                            <div class="formSep">
                              <label class="span4">Select City</label>
                              <!--<select id="city_company" name="city_company" class="span5" onblur="calldisabledothercity(this.value)">-->
                              <select id="city_company" name="city_company" class="span5" >
                                <option value="">--Please Select--</option>
                                <?php
						  if(isset($city_master))
						  {
						   foreach($city_master as $key=>$val)
						   {
						   ?>
                                <option value="<?php echo $key; ?>" <?php echo ($cty_id == $key? 'selected="selected"' : '') ?> ><?php echo $val; ?></option>
                                <?php						 
						   }
						  }
						   ?>
                              </select>
                              <!--<input class="span3" type="text" name="othercity" id="othercity" placeholder="Other City" <?php echo ($cty_id != ''? 'disabled="disabled"' : '') ?> >-->
                            </div>
                            <div class="formSep">
                              <label class="span4">Pin/Zip code</label>
                              <input type="text" name="zipcode" id="zipcode" placeholder="zipcode" value="<?php if(isset($update_company_master['zipcode'])) { echo $update_company_master['zipcode']; }?>">
                            </div>
                            <div class="formSep">
                              <label class="span4">Phone No.</label>
                              <input type="text" name="mobile" id="mobile" placeholder="Phone No." value="<?php if(isset($update_company_master['mobile_no'])) { echo $update_company_master['mobile_no']; }?>">
                            </div>
                            <div class="formSep">
                              <label class="span4">Fax</label>
                              <input type="text" name="fax" id="fax" placeholder="Fax No." value="<?php if(isset($update_company_master['fax_no'])) { echo $update_company_master['fax_no']; }?>">
                            </div>
                            <div class="formSep"> </div>
                            <button name="updatecompany" value="<?php echo $button_text?>" class="btn btn-beoro-3"><?php echo $button_text?></button>
                          </div>
                        </div>
                      </form>
                      <?php 
						  	}
			 } ?>
                    </div>
                    <!-- End Tab 5 -->
                    <!-- Tab 6 -->
                    <div id="tb1_f" class="tab-pane <?php echo ($tab == 'tb1_f'? 'active' : '') ?>">
                      <p class="heading_a">Office Type List</p>
                      <!-- Office type list -->
                      <div class="w-box w-box-orange">
                        <div class="w-box-header">
                          <h4>Office Type List</h4>
                        </div>
                        <div class="w-box-content">
                          <table id="dt_colVis_officetype" class="table table-striped table-condensed">
                            <thead>
                              <tr>
                                <th>Id</th>
                                <th>Company</th>
                                <th>Office Type</th>
                                <th>Parent Office Type</th>
                                <th>Is Virtual Comapny</th>
                                <th>Status</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
							  $this->load->model('companymodel');
							  if(isset($office_type_master))
								  {
									if(!empty($office_type_master))
									{
										foreach($office_type_master as $key=>$val)
										{
										$parent_office= '';
										if($val->office_type_parent_id!=0)
											{
											$result= $this->companymodel->getParentOffice($val->office_type_parent_id);
											$parent_office =  $result->office_type_name;
										}
										else
										{
											$parent_office = "N.A.";//$val->office_type_name;
										}
										?>
                              <?php if($val->office_type_status==0)
												{
												$office_type_status_show = 'Active';
												$office_type_status_title = 'Dectivate';
												}
												elseif($val->office_type_status==1)
												{
												$office_type_status_show = 'Deactive';
												$office_type_status_title = 'Activate';
												}
										?>
                              <tr>
                                <td><?php echo $val->office_type_id; ?></td>
                                <td><?php echo $val->company_name; ?></td>
                                <td><?php echo $val->office_type_name; ?></td>
                                <td><?php echo $parent_office; ?></td>
                                <td><?php echo ($val->is_virtual_office == 'Y') ? 'YES' : 'NO'; ?></td>
                                <td><?php echo $office_type_status_show; ?></td>
                                <td><div class="btn-group">
                                  <a href="<?Php echo site_url('localisation/updateofficetype/'.$val->office_type_id); ?>" class="btn btn-mini" title="Edit"><i class="icon-pencil"></i></a>
                                  <!--  <a  class="btn btn-mini" onclick="call_deactivate_office_type('<?php //echo $val->
                                  office_type_id; ?>','
                                  <?php //echo $val->office_type_status; ?>
                                  ')" title=""><i class="icsw16-acces-denied-sign"></i></a>--> <a href="<?Php echo site_url('localisation/updateofficetypestatus/'.$val->office_type_id); ?>" class="btn btn-mini" title="<?Php echo $office_type_status_title; ?>"><i class="icsw16-acces-denied-sign"></i></a> 
                              </tr>
                              <?php
										}
									}
								}
								?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <br>
                      <br>
                      <!-- End Office type list -->
                      
                      <p class="heading_a">Office Type</p>
					  <?php if( $active_company_count >= 1 ): ?>
                      <form action="<?php echo site_url($action); ?>" method="post" name="officetypemaster" onsubmit="return call_office_type_validation()">
                        <input type="hidden" name="office_type_id" id="hoffice_type_id" value="<?php if(isset($update_office_type)) { echo $update_office_type->office_type_id; } ?>" />
                        <input type="hidden" name="hoffice_nm_status" id="hoffice_nm_status" value=""   />
                        <div class="formSep">
                          <label class="span2">Select Company<span class="required">*</span></label>
                          <label class="span3">
						  
						  <!-- Remove onblur and apply it on on change onblur="call_parent_company_offices()" -->
						  
                          <select  name="office_type_company" id="office_type_company" onchange="call_parent_company_offices()">
                            <option value="">--Please select--</option>
                            <?php
						  if(isset($company_master))
						  {
						  	if(!empty($company_master))
							{
								
								foreach($company_master as $key=>$val)
								{
                                                                    if($postinfo)
                                                                    {
                                                                        if($postinfo['company_master_id'])
                                                                        {
                                                                       ?>
                            <option value="<?php echo $val->company_master_id; ?>" <?php  if( $val->company_master_id==$postinfo['company_master_id']){echo  "selected='selected'"; } ?> ><?php echo $val->company_name; ?></option>
                            <?php }
                                                                    }
                                                                    else
                                                                    {
								?>
                            <option value="<?php echo $val->company_master_id; ?>" <?php  if(isset($update_office_type) && $val->company_master_id==$update_office_type->company_master_id){echo  "selected='selected'"; } ?> ><?php echo $val->company_name; ?></option>
                            <?php
                                                                        }
                                                                
                                                                }
                                                                
							}
						  }
						  ?>
                          </select>
                          </label>
                          <label class="span5 error"></label>
                        </div>
                        <input type="hidden" name="hiscomany" id="hiscomany" value="<?php if(isset($update_office_type) &&($update_office_type->office_type_parent_id=='0')) { echo '0'; } ?>"  />
                        <div class="formSep">
                          <label class="span2">Parent Office Type<span class="required">*</span></label>
                          <label class="span3">
						  <!-- Remove onblur - onblur="madeselection('office_parent_ot','lbl_office_parent_ot','Office Type')" -->
                          <select name="office_parent_ot" id="office_parent_ot"  <?php if(isset($update_office_type) &&($update_office_type->office_type_parent_id=='0')) { ?> disabled="disabled" <?php } ?> >
                            <?php
							if(isset($update_office))
							{
								if(!empty($update_office))
								{
									foreach($update_office as $key=>$val)
									{
										 if(isset($update_office_type) &&($update_office_type->office_type_parent_id==$val->office_type_id) ){
										 ?>
                            <option value="<?php echo $val->office_type_id; ?>" selected="selected"><?php echo $val->office_type_name; ?></option>
                            <?php 
										 }
										 else {
										 ?>
                            <option value="<?php echo $val->office_type_id; ?>" ><?php echo $val->office_type_name; ?></option>
                            <?php
										 }
									}
								}
							}
							else
							{
							?>
                            <option value="">--Please select--</option>
                            <?php 
							}
							?>
                          </select>
                          </label>
                          <label class="span5 error" id="lbl_office_parent_ot"></label>
                        </div>
                        <div class="formSep">
                          <label class="span2">Is virtual Company <span class="required">*</span></label>
                          <?php
						$vc ='N';
						if(isset($postinfo))
						{
							if(!empty($postinfo))
							{
							if($postinfo['is_virtual_office'])
							{
								$vc = $postinfo['is_virtual_office'];
							}
							}
						}
						else
						{
							 if(isset($update_office_type)){ 
									$vc =  $update_office_type->is_virtual_office;
							 }
						}
						?>
                          <label class="span3">
                          <input class="radio" type="radio" name="vcomp" value="Y" <?php if($vc=='Y') { ?>checked="checked" <?php } ?> />
                          &nbsp;Yes&nbsp;&nbsp;
                          <input class="radio" type="radio" name="vcomp"  value="N" <?php if($vc=='N') { ?>checked="checked" <?php } ?>/>
                          &nbsp;No&nbsp;&nbsp; </label>
                          <label class="span5 error"> </label>
                        </div>
                        <div class="formSep">
                          <label class="span2">New Office Type<span class="required">*</span></label>
                          <?php 
                                                $off_nm_val ='';
												
                                                if(isset($postinfo))
                                                {
													if(!empty($postinfo))
														{
                                                    if($postinfo['office_type_name'])
                                                    {

                                                        $off_nm_val = $postinfo['office_type_name'];
                                                    }
													}
                                                }else
                                                {
                                                    if(isset($update_office_type)){ $off_nm_val =  $update_office_type->office_type_name; }
                                                }
                                                                   ?>
                          <label class="span3">
                          <input type="text" name="newofficetype" id="newofficetype" placeholder="New Office type" value="<?php echo $off_nm_val; ?>" onblur="is_char('newofficetype','lbl_newofficetype','YES','New Office type'),check_office_name('office_type_company','office_parent_ot','newofficetype')" >
                          </label>
                          <label class="span5 error" id="lbl_newofficetype"> </label>
                          <br>
                          <br>
                          <!-- <button class="btn btn-beoro-3">Update</button>-->
                          <button name="updateofficetype" value="<?php echo $button_text?>" class="btn btn-beoro-3"><?php echo $button_text?></button>
                        </div>
                      </form>
					  <?php else: ?>
					  	<p class="heading_a"><?php echo $err_active_not_found; ?></p>
					  <?php endif; ?>
                    </div>
                    <!-- End Tab 6 -->
                    <!-- Tab 7 -->
                    <div id="tb1_g" class="tab-pane <?php echo ($tab == 'tb1_g'? 'active' : '') ?>">
                      <!-- Office Address List -->
                      <p class="heading_a">Office Address List</p>
                      <div class="w-box w-box-orange">
                        <div class="w-box-header">
                          <h4>Office Address List</h4>
                        </div>
                        <div class="w-box-content">
                          <table id="dt_colVis_officeaddress" class="table table-striped table-condensed">
                            <thead>
                              <tr>
                                <th>Id</th>
                                <th>Office Name</th>
                                <th>Office Abbrevation</th>
                                <th>Office Type</th>
                                <th>Office Type (Reported)</th>
                                <th>Office Name (Reported)</th>
                                <th>Contact Person</th>
                                <th>Office Address</th>
                                <th>Status</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
							  $this->load->model('companymodel');
							  $this->load->model('countrymodel');
							  	if($office_addresses)
								{
									if(!empty($office_addresses))
									{
										foreach($office_addresses as $key=>$val)
										{
											
											
											$office_type_name = $this->companymodel->getOfficeType($val->office_type_id);
											if( isset($office_type_name->office_type_name) ) {											
												$office_type_name_show = $office_type_name->office_type_name;
											}
											else {
												$office_type_name_show = '';
											}
											
											if($val->office_reported_office_type_id!=0)
											{
												$result_office_type_nm = $this->companymodel->getOfficeType($val->office_reported_office_type_id);
												$r_office_type_name =$result_office_type_nm->office_type_name;
											}
											else
											{
												$r_office_type_name ='N.A.';
											}
											$result_office_type_name ='';
											if($val->office_reported_office_id!=0)
											{
												$result_office_type_name = $this->companymodel->getOfficeAddress($val->office_reported_office_id);
												$r_of_nm = $result_office_type_name->office_name;
											}
											else
											{
												$r_of_nm = 'N.A.';
											}
										$country_info = $this->countrymodel->getCountry($val->countrymaster_id);
										$state_info = $this->countrymodel->getState($val->statemaster_id);
										$city_info = $this->countrymodel->getCity($val->citymaster_id);
										$country_name = '';
										$state_name = '';
										$city_name = '';
										if($country_info)
										{
											$country_name = $country_info->country_name;
										}
										if($state_info)
										{
											$state_name = $state_info->state_name;
										}
										if($city_info)
										{
													$city_name = $city_info->city_name;
										}
									
									$address = array();
									if(!empty($val->area))
									{
										$address[] = $val->area;
									}
									if(!empty($val->plot_no))
									{
										$address[] = $val->plot_no;
									}
									if(!empty($val->street))
									{
										$address[] =  $val->street;
									}
									if(!empty($val->landmark))
									{
										$address[] =  $val->landmark;
									}
									if(!empty($country_name))
									{
										$address[] = $country_name;
									}
									if(!empty($state_name))
									{
										$address[] =  $state_name;
									}
									if(!empty($city_name))
									{
										$address[] =  $city_name;
									}
									$address_show =  implode(",", $address);
									 if($val->office_address_status==1)
										  {
											$show_off_add_title='Suspend/Pause';
											$off_add_status_name ='Active';
										  }
										  elseif($val->office_address_status==0)
										  {
										  	$show_off_add_title='Activate';
											$off_add_status_name ='Suspended';
										  }
										  else
										  {
										  	$show_off_add_title='Not available';
											$off_add_status_name='Not available';
										  }
									
							  ?>
                              <tr>
                                <td><?php echo $val->office_addresses_id; ?></td>
                                <td><?php echo $val->office_name; ?> </td>
                                <td><?php echo $val->office_code; ?> </td>
                                <td><?php echo $office_type_name_show ?> </td>
                                <td><?php echo $r_office_type_name; ?> </td>
                                <td><?php echo $r_of_nm; ?> </td>
                                <td><?php echo $val->contact_person; ?> </td>
                                <td><?php echo $address_show;?></td>
                                <td><?php echo $off_add_status_name; ?></td>
                                <td><div class="btn-group"> <a href="<?Php echo site_url('localisation/updateofficeaddress/'.$val->office_addresses_id); ?>" class="btn btn-mini" title="Edit"><i class="icon-pencil"></i></a>
                                    <!-- <a href="#" class="btn btn-mini" title="View"><i class="icon-eye-open"></i></a> -->
                                    <a href="<?Php echo site_url('localisation/updateofficeaddressstatus/'.$val->office_addresses_id.'/'.$val->office_address_status); ?>" class="btn btn-mini" title="<?php echo $show_off_add_title; ?>"><i class="icsw16-acces-denied-sign"></i></a> </div></td>
                              </tr>
                              <?php
										
										}
									}
								}
								?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <br>
                      <br>
                      <!-- End Office Address List -->
                      <div class="heading_a">Office Address</div>
					  
					  
					  <?php if( $active_company_count >= 1 ): ?>
                      <form action="<?php echo site_url($action); ?>" method="post" name="offiveadressmaster" onsubmit="return call_office_address_validation()">
                        <div class="span6">
                          <input type="hidden" name="hoffice_address_id" id="hoffice_address_id" value="<?php	 if(isset($office_update_address)) {  echo $office_update_address->office_addresses_id.'_'.$office_update_address->addressmaster_id;  }	?>"  />
                          <input type="hidden" name="hoffice_add_error_status" id="hoffice_add_error_status"  />
                          <div class="formSep">
                            <label class="span4">Select Business</label>
                            <select  name="business_list_dd" id="business_list_dd" >
								<option value="">--Please Select Business--</option>
								<?php foreach( $business_list_data as $key1=>$val1 ) : ?>
									<?php
										$is_selected = '';
										if( $val1->business_id == $office_update_address->business_id ) {
											$is_selected = " selected='selected' ";
										}
									?>
									<option value="<?php echo $val1->business_id; ?>" <?php echo $is_selected; ?> ><?php echo $val1->business_subject; ?></option>
								<?php endforeach; ?>
                              
							 </select>
						</div>	  
						  
						  <div class="formSep">
                            <label class="span4">Select Company</label>
							<!-- Remove onblur effice and apply it on change onblur="call_office_types()" -->
                            <select  name="office_add_company" id="office_add_company" onchange="call_office_types();" >
                              <option value="">--Please select--</option>
                              <?php
						   $o_a_cmp_select ='';
						   /** Remove default load functionality and callit on Business Change **/
						  if(isset($office_type_cmp))
						  {
						  	if(!empty($office_type_cmp))
							{
								
								foreach($office_type_cmp as $key=>$val)
								{
                                           if($office_update_address) { 
						   							if($val->company_master_id==$office_update_address->company_master_id)
													{
														$o_a_cmp_select = "selected='selected'";
													}
						  					 }
						                       
								?>
                              <option value="<?php echo $val->company_master_id; ?>" <?php echo  $o_a_cmp_select; ?> ><?php echo $val->company_name; ?></option>
                              <?php
                    			}
                                                                
							}
						  }

						  ?>
                            </select>
                          </div>
                          <div class="formSep">
                            <label class="span4">Office Name</label>
                            <input type="text" name="officeaddressname" id="officeaddressname" placeholder="Office Name VPPL -VI" value="<?php	 if(isset($office_update_address)) {  echo $office_update_address->office_name;  }	?>">
                          </div>
                          <div class="formSep">
                            <label class="span4">Office Name Abbrevation</label>
                            <input type="text" name="officecode" id="officecode" placeholder="Office Code VPPL -VI" value="<?php if(isset($office_update_address)) {  echo $office_update_address->office_code;  }	?>">
                          </div>
                          <div class="formSep">
						  	<!-- Remove onblur effect and called it on change onblur="call_reported_office()" -->
                            <label class="span4">Office Type</label>
                            <select  name="office_type_office_add" id="office_type_office_add" onchange="call_reported_office()">
							<option value="">--Please select--</option>
                              <?php
							  //Remove default load functionality and call it on company change.
							/**  
						  if(isset($office_type_master))
						  {
						  	if(!empty($office_type_master))
							{
								foreach($office_type_master as $key=>$val)
								{
									$o_a_ot_select = "";
									 if($office_update_address) { 
						   							if($val->office_type_id==$office_update_address->office_type_id)
													{
														$o_a_ot_select = "selected='selected'";
													}
						  					 }
									?>
                              <option value="<?php echo $val->office_type_id; ?>" <?php  echo $o_a_ot_select; ?> >
                              <?php  echo $val->office_type_name; ?>
                              </option>
                              <?php
									
								}
							}
						  }
						  
						  **/
						  
						  ?>
                            </select>
                          </div>
                          <?php if(isset($office_update_address)) { 
						if($office_update_address->office_reported_office_type_id!=0)
						{
							$office_tp_list = $this->companymodel->getOfficeAccordingCompnayAndPriotity($office_update_address->company_master_id,$office_update_address->office_type_id);
						}						 
						 } 
						?>
                          <div class="formSep">
                            <label class="span4">Reported To Office Type</label>
                            <select  name="reported_to_oadd" id="reported_to_oadd" <?php if(isset($office_update_address)) {if($office_update_address->office_reported_office_type_id==0){ ?> disabled="disabled" <?php } } ?> onblur="call_reported_office_names()">
                              <option value="">--Please Select--</option>
                              <?php 
								
								if(isset($office_tp_list))
								{
									
									foreach($office_tp_list as $key=>$val)
									{
										?>
                              <option value="<?php echo $val->office_type_id; ?>" <?php if($val->office_type_id==$office_update_address->office_reported_office_type_id)  { ?> selected="selected" <?php } ?>  ><?php echo $val->office_type_name; ?></option>
                              <?php
									}
								}
								?>
                            </select>
                          </div>
                          <?php if(isset($office_update_address)) { 
										
											if($office_update_address->office_reported_office_id!=0)
											{
											$result_office_type_nm_updat = $this->companymodel->getReortedOfficeNames($office_update_address->company_master_id,$office_update_address->office_type_id,$office_update_address->office_reported_office_type_id);
											}						 
						 } 
						 
						?>
                          <div class="formSep">
                            <label class="span4">Reported To Office</label>
                            <?php 
							
												?>
                            <select  name="reported_to_2_oadd" id="reported_to_2_oadd"  <?php if(isset($office_update_address)) {if($office_update_address->office_reported_office_id==0){ ?> disabled="disabled" <?php } } ?> >
                              <option value="" >--Please Select--</option>
                              <?php
										if($result_office_type_nm_updat)
										{
											foreach($result_office_type_nm_updat as $key=>$val)
											{
												$o_t_updt_nm='';
												if($office_update_address->office_reported_office_id==$val->office_addresses_id)
												{
													$o_t_updt_nm = "selected='selected'";
												}
												?>
                              <option value="<?php echo $val->office_addresses_id; ?>" <?php echo $o_t_updt_nm; ?> ><?php echo $val->office_name; ?></option>
                              <?php
											}
										}
								?>
                            </select>
                          </div>
                          <div class="formSep">
                            <label class="span4">Office Contact Person (IF Any)</label>
                            <input type="text" name="officperson" placeholder="Office Contact Person" value="<?php if(isset($office_update_address)) { echo $office_update_address->contact_person;  } ?>">
                          </div>
                          <div class="formSep">
                            <label class="span4">Select Country</label>
                            <?php $cntry_id =''; 
if(isset($office_update_address)) { $cntry_id = $office_update_address->countrymaster_id;  } 
$ste_id =''; if(isset($office_update_address)) { $ste_id = $office_update_address->statemaster_id;  } 
$cty_id =''; if(isset($office_update_address)) { $cty_id = $office_update_address->citymaster_id;  } 
//print_r($state_master);
?>
                            <select id="country_office_add" name="country_office_add" class="span6"  onchange="call_generalstate('country_office_add','state_office_add')">
                              <option value="">--Please Select--</option>
                              <?php
						  
						   foreach($country_master as $key=>$val)
						   {
						   ?>
                              <option value="<?php echo $key; ?>" <?php echo ($cntry_id == $key? 'selected="selected"' : '') ?> ><?php echo $val; ?></option>
                              <?php						 
						   }
						   ?>
                            </select>
                          </div>
                          <div class="formSep">
                            <label class="span4">Select State</label>
                            <select id="state_office_add" name="state_office_add" class="span5"  onchange="call_generalcity('country_office_add','state_office_add','city_office_add')">
                              <option value="">--Please Select--</option>
                              <?php
						  if(isset($state_master))
						  {
						   foreach($state_master as $key=>$val)
						   {
						   ?>
                              <option value="<?php echo $key; ?>" <?php echo ($ste_id == $key? 'selected="selected"' : '') ?> ><?php echo $val; ?></option>
                              <?php						 
						   }
						  }
						   ?>
                            </select>
                            <!--<input class="span3" type="text" name="otherstate_office_add" id="otherstate_office_add" placeholder="Other State"  <?php echo ($ste_id != ''? 'disabled="disabled"' : '') ?>>
-->
                          </div>
                        </div>
                        <div class="span6">
                          <div class="formSep">
                            <label class="span4">Select City</label>
                            <select id="city_office_add" name="city_office_add" class="span5" onchange="check_company_validation()" >
                              <option value="">--Please Select--</option>
                              <?php
						  if(isset($city_master))
						  {
						   foreach($city_master as $key=>$val)
						   {
						   ?>
                              <option value="<?php echo $key; ?>" <?php echo ($cty_id == $key? 'selected="selected"' : '') ?> ><?php echo $val; ?></option>
                              <?php						 
						   }
						  }
						   ?>
                            </select>
                            <!--<input class="span3" type="text" name="othercity_office_add" id="othercity_office_add" placeholder="Other City" <?php echo ($cty_id != ''? 'disabled="disabled"' : '') ?> >
-->
                          </div>
                          <div class="formSep">
                            <label class="req span4">Plot no./Office No.</label>
                            <input type="text" name="plot_office_no" id="plot_office_no" placeholder="Plot no./Office No." value="<?php if(isset($office_update_address)) { echo $office_update_address->plot_no; }?>">
                          </div>
                          <div class="formSep">
                            <label class="span4">Area/Local/Sector</label>
                            <input type="text" name="area" id="area" placeholder="Area/Local/Sector" value="<?php if(isset($office_update_address)) { echo $office_update_address->area; }?>">
                          </div>
                          <div class="formSep">
                            <label class="span4">Street/Road/Lane</label>
                            <input type="text" name="street" id="street" placeholder="Street/Road/Lane" value="<?php if(isset($office_update_address)) { echo $office_update_address->street; }?>">
                          </div>
                          <div class="formSep">
                            <label class="span4">Landmark</label>
                            <input type="text" name="landmark" id="landmark" placeholder="Landmark" value="<?php if(isset($office_update_address)) { echo $office_update_address->landmark; }?>">
                          </div>
                          <div class="formSep">
                            <label class="span4">Zipcode</label>
                            <input type="text" name="zipcode" id="zipcode" placeholder="zipcode" value="<?php if(isset($office_update_address)) { echo $office_update_address->zipcode; }?>">
                          </div>
                          <div class="formSep">
                            <label class="span4">Mobile</label>
                            <input type="text" name="phone_no" id="phone_no" placeholder="Phone No" value="<?php if(isset($office_update_address)) { echo $office_update_address->phone_no; }?>">
                          </div>
                          <div class="formSep">
                            <label class="span4">Fax</label>
                            <input type="text" name="fax" id="fax" placeholder="Fax No." value="<?php if(isset($office_update_address)) { echo $office_update_address->fax_no; }?>">
                          </div>
                          <?php //$this->load->view('default/clientadmin/common_addressmaster'); ?>
                        </div>
                        <div class="formSep">
                          <?php //$this->load->view('default/clientadmin/common_addressmaster');
							//include("common_addressmaster.php"); 
						?>
                          <button class="btn btn-beoro-3" value="<?php echo $button_text;?>" name="officeaddress"><?php echo $button_text;?></button>
                        </div>
                      </form>
					  <?php else: ?>
					  	<p class="heading_a"><?php echo $err_active_not_found; ?></p>
					  <?php endif; ?>
                    </div>
                    <!-- End Tab 7 -->
                    <!-- Tab 8 -->
                    <div id="tb1_h" class="tab-pane <?php echo ($tab == 'tb1_h'? 'active' : '') ?>">
                      <p class="heading_a">Department</p>
                      <!-- Office type list -->
                      <div class="w-box w-box-orange">
                        <div class="w-box-header">
                          <h4>Department List</h4>
                        </div>
                        <div class="w-box-content">
                          <table id="dt_colVis_officetype" class="table table-striped table-condensed">
                            <thead>
                              <tr>
                                <th>id</th>
                                <th>Department </th>
                                <th>Status</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
									  if(isset($department_infos) && !empty($department_infos) )
									  {
										foreach($department_infos as $key=>$val)
										{
											if($val->department_status==1)
											{
												$dept_status = 'Activate';
												$dept_tile = 'Suspend/Pause';
											}
											elseif($val->department_status==2)
											{
												$dept_status = 'Suspend/Pause';
												$dept_tile = 'Activate';
											}
											else
											{
												$dept_status = 'Not Available';
												$dept_tile = 'Not Available';
											}
					
								?>
                              <tr>
                                <td><?php echo $val->department_id; ?></td>
                                <td><?php echo $val->department_name; ?></td>
                                <td><?php echo $dept_status; ?></td>
                                <td><div class="btn-group"> <a href="<?php echo site_url('localisation/updatedepartment/'.$val->department_id); ?>" class="btn btn-mini" title="Edit"><i class="icon-pencil"></i></a>
                                    <!--  <a href="#" class="btn btn-mini" title="View"><i class="icon-eye-open"></i></a>-->
                                    <a href="<?php echo site_url('localisation/updatedepartmentstatus/'.$val->department_id); ?>" class="btn btn-mini" title="<?php echo $dept_tile; ?>"><i class="icsw16-acces-denied-sign"></i></a> </div></td>
                              </tr>
                              <?php
										}
									  }
								?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <br>
                      <br>
                      <!-- End Office type list -->
                      <?php
					
					  ?>
                      <p class="heading_a">New Department</p>
                      <form action="<?php echo site_url($action); ?>" method="post" name="departmentmaster" >
                        <input type="hidden" name="department_id"  value="<?php if(isset($updatedept)){ echo $updatedept->department_id;  } ?>" >
                        <div class="formSep">
                          <label>New Department</label>
                          <input type="text" name="newdepartment" placeholder="New Department" value="<?php if(isset($updatedept)){ echo $updatedept->department_name;  } ?>" >
                          <br>
                          <br>
                          <button name="updatedepartment" value="<?php echo $button_text?>" class="btn btn-beoro-3"><?php echo $button_text?></button>
                        </div>
                      </form>
                    </div>
                    <!-- End Tab 8 -->
                    <!---- tab 9 -->
                    <div id="tb1_i" class="tab-pane <?php echo ($tab == 'tb1_i'? 'active' : '') ?>">
                      <p class="heading_a">Department and Offices</p>
					  <?php if( $active_company_count >= 1 ): ?>
					  <div >
                      <form action="<?php echo site_url($action); ?>" method="post" name="department_office_master" onsubmit="return validate_dept();" >
                        <div class="span6">
						<div class="formSep">
                          <label class="span4" >Select Department/ Offices</label>
                          
                          <select class="span6" name="select_dept_offic" id="select_dept_offic" onchange="call_office_dept_listing()">
                            <option value="-1" selected="selected">--Please Select--</option>
                            <option value="1">Department</option>
                            <option value="2">Offices</option>
                          </select>
                          </label>
                        </div>
						</div>
						
						<div class="span5">
                        <div class="formSep" >
                          <label class="span3">Select From</label>
                          <label class="span3">
                          <select name="select_from" id="select_from"  >
                          </select>
                          </label>
                          
                        </div>
						</div>
						
						<div class="span10">
						<div class="formSep" id="test3">
                            <select name="select_list1[]" id="select_list1" multiple="multiple" >
                            </select>
                          </div>
						</div>
						
						<div class="formSep">
						<!--
                        <i class="icon-pencil" onclick="call_dept_offic()" ></i>
						-->
                        <input class="btn btn-beoro-3" type="submit" name="submit_dept_office" id="submit" value="Submit"  />
						</div>
                      </form>
					  </div>
					  
					  <?php else: ?>
					  	<p class="heading_a"><?php echo $err_active_not_found; ?></p>
					  <?php endif; ?>
					  
					  
                    </div>
                    <!--end of tab 9 -->
					
					<!-- Business and Company -->
					<div id="tb1_businesscompany" class="tab-pane <?php echo ($tab == 'tb1_i'? 'active' : '') ?>">
                      <p class="heading_a">Business &laquo; &raquo; Company</p>
					  <?php if( $active_company_count >= 1 ): ?>
					<div >
                      <form action="<?php echo site_url($action); ?>" method="post" id="business_company" name="business_company" onsubmit="return validate_dept();" >
                        <div class="span6">
						<div class="formSep">
                          <label class="span4" >Select Business / Company</label>
                          
                          <select class="span6" name="select_business_company" id="select_business_company" onchange="call_getbusinesscompanylist()">
                            <option value="-1" selected="selected">--Please Select--</option>
                            <option value="1">Business</option>
                            <option value="2">Company</option>
                          </select>
                          </label>
                        </div>
						</div>
						
						<div class="span5">
                        <div class="formSep" >
                          <label class="span3">Select From</label>
                          <label class="span3">
                          <select name="select_from_business_company" id="select_from_business_company"  >
                          </select>
                          </label>
                          
                        </div>
						</div>
						
						<div class="span10">
						<div class="formSep" id="test3">
                            <select name="select_list_business_company[]" id="select_list_business_company" multiple="multiple" >
                            </select>
                          </div>
						</div>
						
						<div class="formSep">
						<!--
                        <i class="icon-pencil" onclick="call_dept_offic()" ></i>
						-->
                        <input class="btn btn-beoro-3" type="button"  name="submit_business_company" id="submit_business_company" value="Submit"  />
						</div>
                      </form>
					  </div>
					  <?php else: ?>
					  	<p class="heading_a"><?php echo $err_active_not_found; ?></p>
					  <?php endif; ?>
					  </div>
					
					<!-- End Business and Company -->
					
					
					
                  </div>
                </div>
              </div>
            </div>
            <!-- End Tab Settings -->
          </div>
          <!-- Settings -->
          <!-- Panel Right -->
          <!-- End Settings -->
        </div>
      </div>
    </div>
  </div>
</div>
<!-- </div> -->
<?php
  $this->load->view('default/clientadmin/localisation_footer');
?>
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/jquery.livequery.js"></script>

<!-- Business Functions -->
<script type="text/javascript" >
$(document).ready(function() {

	//New Announcement
	$("#submit_ans").click( function() {
		//alert('New Announcement');
		var url = '<?php echo site_url("business/ajax_addbusiness"); ?>';
		var frm = $('#frm_announcement');
		var business_name = $("#business_subject").val();
		if( business_name == '' ) {
			alert('Please enter business name.');
			return false;
		}
		$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: frm.serialize(),
				success: function(response) {
					$("#msg").html('');
					//alert('Response: ' + response.msg );
					
					//refresh List
					refreshlist();
					
					show_top_message(response.status,response.msg);
					
					//Clear Form
					hideform();
					
					//Clear Msg 
					//hidemsg();
					
				}	
    		});
		
	//End Function	
	});
	
	
	//Edit Announcement
	$('.editbusiness').livequery("click", function(e){
		var business_id = $(this).attr('id').replace('edit_','');
		var url = '<?php echo site_url("business/ajax_getinfo"); ?>';
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {business_id:business_id},
				success: function(response) {	
				
					//Display values in text box
					showform();
					$("#business_subject").val(response.result);
					$("#business_id").val(business_id);
					//refreshlist();
					//var msg = getmessage(response.status,response.msg);
					
					//Display Message
					//$("#msg").html(msg);
					//hideform();
				}	
	    });
	
	});
	
	
	//Suspend
	$('.suspendbusiness').livequery("click", function(e){
		var business_id = $(this).attr('id').replace('suspend_','');
		if( confirm('Are you sure to suspend this record?') == false ) {
			return false;
		} 
		else {
			//Process for suspend			
			var url = '<?php echo site_url("business/ajax_suspend"); ?>';
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {business_id:business_id},
				success: function(response) {					
					refreshlist();
					
					//new msg - Ajay
					show_top_message(response.status,response.msg);
					
					//Display Message
					//$("#msg").html(msg);
					hideform();
				}	
	    	});
		}
	
	});
	
	//Make Active 	
	$('.activebusiness').livequery("click", function(e){
		var business_id = $(this).attr('id').replace('active_','');
		if( confirm('Are you sure to Active this record?') == false ) {
			return false;
		} 
		else {
			//Process for suspend			
			var url = '<?php echo site_url("business/ajax_active"); ?>';
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {business_id:business_id},
				success: function(response) {					
					refreshlist();
					
					//new msg - Ajay
					show_top_message(response.status,response.msg);
					//var msg = getmessage(response.status,response.msg);
					
					//Display Message
					//$("#msg").html(msg);
					hideform();
				}	
	    	});
		}
	
	});
	
	
	//Delete
	$('.deletebusiness').livequery("click", function(e){
		var business_id = $(this).attr('id').replace('delete_','');
		if( confirm('Are you sure to Delete this record?') == false ) {
			return false;
		} 
		else {
			//Process for suspend			
			var url = '<?php echo site_url("business/ajax_delete"); ?>';
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {business_id:business_id},
				success: function(response) {					
					refreshlist();
					//var msg = getmessage(response.status,response.msg);
					//new msg - Ajay
					show_top_message(response.status,response.msg);
					//Display Message
					//$("#msg").html(msg);
					hideform();
				}	
	    	});
		}
	
	});
	
	
	//Refresh List
	function refreshlist()
	{
		var url = '<?php echo site_url("business/ajax_getbusinesslist"); ?>';
		var frm = $('#frm_announcement');
		var id = 1;
		$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {id:id},
				success: function(response) {
					//alert('Response: ' + response.business_details );
					$("#business_list").html(response.business_details);
					
					//Refresh List with datatable
						if($('#dt_colVis_emailtemplate').length) {
							$('#dt_colVis_emailtemplate').dataTable({
								"sPaginationType": "bootstrap",
								"sDom": "R<'dt-top-row'Clf>r<'dt-wrapper't><'dt-row dt-bottom-row'<'row-fluid'ip>",
								"fnInitComplete": function(oSettings, json) {
									$('.ColVis_Button').addClass('btn btn-mini btn-inverse').html('Columns');
								}
							});
						}	
					
				}	
    	});
			
	}
	
	
	//Show New Form
	$("#shownewform").click(function() {
		$("#business_subject").val();
		showform();
	});
	
	
	//Hide form / Cancel Click
	$("#reset_ans").click(function() {
		hideform();
	});
	
	
	//ClearnewBox
	function clearnewannouncementform()
	{
		$("#business_subject").val('');
		$("#business_desc").val('');
		$("#business_id").val('');
	}
	
	function hideform()
	{
		clearnewannouncementform();
		$("#new_business").hide();
	}
	
	function showform()
	{
		clearnewannouncementform();
		$("#new_business").show();
	}
	
	//Refresh on active
/** Default Tab Load functions **/	
	//tab_business
	$("#tab_business").livequery("click", function(e) {		
		refreshlist();
	});
	
	$("#tab_businesscompany").livequery("click", function(e) {
		//Set default dropdown to 0 -- select ---
		$("#select_business_company").val("");
		$('select[id=\'select_from_business_company\']').html('<option value="">- Select Business / Company -</option>');
	});
	
	$("#tab_departmentoffice").livequery("click", function(e) {
		$("#select_dept_offic").val("-1");
		//select_from
		$('select[id=\'select_from_business_company\']').html('<option value="">- Select Business / Company -</option>');
	});
	
	//Office Address
	$("#officeaddress").livequery("click", function(e) {
		//Reset company stats
		//alert('Office Address');
	});
	
	
	
//Livequery Functions
$('.suspendbusiness22').livequery("click", function(e){
	alert('Live Query Suspend');
});	
	
	/** Hide message div **/
	function hidemsg()
	{
		if( $(".alert-success").length ) {
			setTimeout(function(){ $(".alert-success").fadeOut(2000); }, 3000);
		}
		//alert-error
	
		setTimeout(function(){ $("#msg").fadeOut(2000); }, 3000);
	}

	
	function show_top_message(status,message)
	{
		var msg = getmessage(status,message);
		//show div
		$("#msg").show();
		
		//Show Msg
		$("#msg").html(msg);
		
		//Call hide function
		hidemsg();
		
	}
	
	
	function getmessage(status,message)
	{
		if( status == 'Y' ) {
			var msg = '<div class="alert alert-success"><a data-dismiss="alert" class="close">&times;</a><strong>Success!</strong> ' + message +'</div>';
		}
		else {
			var msg = '<div class="alert alert-error"><a data-dismiss="alert" class="close">&times;</a><strong>Warning!</strong> ' + message +'</div>';
		}
		
		return msg ;
	}
	
	//Office Department 
	//$("#select_business_company")
	/** On Select Change **/	
	$("#select_from_business_company").change(function() {
		var select_business_company = $("#select_business_company").val();
		var select_from = $(this).val();
		//alert('you selected ' + select_from + ' for business ' + select_business_company);
		////alert('dept office ' + select_dept_offic + ' Seleft from ' + select_from ) ;
		$('select[id=\'select_list_business_company\']').html('');
		
		if( select_business_company == '2' )
		{
			//Get Business Address for select company
			//Office to dept
			 var url = '<?php echo site_url("business/getBusinessIdsByCompany"); ?>';
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
					company_id: select_from	
				},
				success: function (response) {
					//alert(response['nonselect_list']);
					//alert(response['select_list']);
					var select_items = response['select_list'] ;
					
					//alert('Elem ' + elem );
					//alert(response['office_addresses']);
					//$('select[id=\'select_list1\']').empty()
					$('select[id=\'select_list_business_company\']').html('');		
					
					
					$('select[id=\'select_list_business_company\']').append(response['nonselect_list']);
					$('#select_list_business_company').multiSelect('refresh'); //Ajay
					
					////$('#select_list1').multiSelect(); //Ajay
					//$('#select_list1').multiSelect('refresh'); //Ajay
					
					$.each(select_items, function(i, item) {
						//alert('Show ' + item );
						$('#select_list_business_company').multiSelect('select', item );	
					});
					
					//$('#select_list1').multiSelect('select', '2' );
				}
			});		
		
		}
		else{
			//Departmant to office
			
			var url = '<?php echo site_url("business/getCompanyIdsByBusiness"); ?>';
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
					business_id: select_from	
				},
				success: function (response) {
					//alert(response['nonselect_list']);
					//alert(response['select_list']);
					var select_items = response['select_list'] ;
					
					//alert('Elem ' + elem );
					//alert(response['office_addresses']);
					//$('select[id=\'select_list1\']').empty()
					$('select[id=\'select_list_business_company\']').html('');		
					
					
					$('select[id=\'select_list_business_company\']').append(response['nonselect_list']);
					$('#select_list_business_company').multiSelect('refresh'); //Ajay
					
					////$('#select_list1').multiSelect(); //Ajay
					//$('#select_list1').multiSelect('refresh'); //Ajay
					
					$.each(select_items, function(i, item) {
						//alert('Show ' + item );
						$('#select_list_business_company').multiSelect('select', item );	
					});
					
					//$('#select_list1').multiSelect('select', '2' );
				}
			});		
			
		}
		
	});	
	
	
	$("#submit_business_company").click(function() {
		//alert('Submit Business company');
		var url = '<?php echo site_url("business/savebusinesscompany"); ?>';
		var frm = $('#business_company');
		
		//check for empty dropdown
		var select_business_company = $("#select_business_company").val() ;
		var select_from_business_company = $("#select_from_business_company").val() ;
		var msg = '';
		if( select_business_company == -1 ) {
			msg += 'Please select Primary type Business or Company.\n';
		}
		if( select_from_business_company == -1 ) {
			msg += 'Please select Whome to map. Business or Company.\n';
		}
		
		if( msg != '' ) {
			alert(msg);
			return false;
		}
		
		$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: frm.serialize(),
				success: function(response) {
				
				$("#msg").html('');
					//alert('Response: ' + response.msg );
					if( response.status == 'Y' ) {
						var msg = '<div class="alert alert-success"><a data-dismiss="alert" class="close">&times;</a><strong>Success!</strong> ' + response.msg +'</div>';
					}
					else {
						var msg = '<div class="alert alert-error"><a data-dismiss="alert" class="close">&times;</a><strong>Warning!</strong> ' + response.msg +'</div>';
					}
				
				$("#msg").html(msg);
					
				}	
    		});
		
	});

	//Default call for any hide message
	hidemsg();
	
	
});
</script>

<script type="text/javascript">
	function call_getbusinesscompanylist() {
		var elem = document.getElementById('select_business_company').value;
		
		if( elem == '-1' ) {
			$('select[id=\'select_from_business_company\']').html('<option value="">- Select Business / Company -</option>');			
			$('select[id=\'select_list_business_company\']').html('');
			$('#select_list_business_company').multiSelect(); //Ajay
			$('#select_list_business_company').multiSelect('refresh'); //Ajay
		}		
		
		if (elem == '' || elem == null) {
			alert("please select mapping from to Company or");
			return false;
		} else {
			 ////$('#select_list1').multiSelect(); //Ajay
			var url = '<?php echo site_url("business/getbusinesscompanylist"); ?>';
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'POST',
				data: {
					selected_elem: elem
	
				},
				success: function (response) {
					//alert('Elem ' + elem );
					//alert(response['office_addresses']);
					if (elem == 1) {
						 $('select[id=\'select_from_business_company\']').html('');
						//alert(response['office_addresses']);
						$('select[id=\'select_from_business_company\']').html('');
						$('select[id=\'select_from_business_company\']').html('<option value="-1">--Please Select--</option>');
						 
						$('select[id=\'select_from_business_company\']').append(response['output']);
						//$('#test').html(response['office_addresses']);
						///$('#select_list1').multiSelect('refresh');
						$('select[id=\'select_list_business_company\']').html('');					 
						//$('select[id=\'select_list1\']').append(response['office_addresses']);
						
						$('#select_list_business_company').multiSelect(); //Ajay
						$('#select_list_business_company').multiSelect('refresh'); //Ajay
	
					} else if (elem == 2) {
						$('select[id=\'select_from_business_company\']').html('');
						
						$('select[id=\'select_from_business_company\']').html('<option value="-1">--Please Select--</option>');
						
						$('select[id=\'select_from_business_company\']').append(response['output']);
						//$('select[id=\'dept_office_list\']').html(response['department']);
						//$('#test').html('');
						//$('#test').html(response['department']);
						////$('#select_list1').multiSelect('refresh');
						$('select[id=\'select_list_business_company\']').html('');					 
						////$('select[id=\'select_list1\']').append(response['department']);
						
						$('#select_list_business_company').multiSelect(); //Ajay
						$('#select_list_business_company').multiSelect('refresh'); //Ajay
					}
	
				}
			});
		}
	
		//$('#select_list1').bind(function() { multiSelect() }); //Ajay
		////$('#select_list1').multiSelect(); //Ajay
		////$('#select_list1').multiSelect('refresh'); //Ajay
	}	
	
	
	
</script>