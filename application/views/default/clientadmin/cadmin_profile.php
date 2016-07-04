  <!-- main content -->
 <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4>Client profile</h4>
                            </div>
                            <div class="w-box-content cnt_a user_profile">
                                <div class="row-fluid">
								
                                  
									<?php if(isset($update_profile))
										{ ?>
											  <form>
											  <div class="span2">
                                   		 
                                        <label>Avatar</label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new thumbnail" style=""><img src="img/dummy_150x150.gif" alt="" ></div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="width: 150px; height: 150px;"></div>
                                            <span class="btn btn-small btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file"></span>
                                            <a href="#" class="btn btn-small btn-link fileupload-exists" data-dismiss="fileupload">Remove</a>
                                      
										</div>
										</div>
										<div class="span5">
										<p class="formSep"><small class="span3">Username:</small> <input type="text" name="user-name" ></p>
                                        <p class="formSep"><small class="span3">First Name:</small> <input type="text" name="firstname"></p>
										<p class="formSep"><small class="span3">Last Name:</small> <input type="text" name="lastname"></p>
										<!--<p class="formSep"><small class="span3">Password:</small> *********</p>-->
                                        <p class="formSep"><small class="span3">Gender:</small>
										<input  type="radio" name="gender" value="M"> Male &nbsp;&nbsp;
										<input class="radio" type="radio" name="gender" value="F"> Female 
										</p>
                                        <p class="formSep"><small class="span3">Birthday:</small><input  data-date-format="dd/mm/yyyy" id="dp1" type="text" value=""></p>
                                        <p class="formSep"><small class="span3">Email:</small>  <input name="email" type="text" value=""></p>
										  <p class="formSep"><small class="span12">Languages:</small>
										<select id="public-methods" multiple="multiple" name="languages">
                                            <option value="fr">France</option>
                                            <option value="eng">English</option>
                                            <option value="hin">Hindi</option>
                                            <option value="mar">Marathi</option>
                                        </select>
										</p>
                                        
										
										
                                    </div>
									<div class="span5">
										<p class="formSep"><small class="span4">Contact number:</small>  <input  type="text" name="mobile_no" id="mobile_no" value=""></p>
                                      
										<p class="formSep"><small class="span4">Address 1:</small><input  type="text" name="address_1" id="address1" value=""></p>
										<p class="formSep"><small class="span4">Address 2:</small><input  type="text" name="address_2" id="address2" value=""></p>
                                        <p class="formSep"><small class="span4">country:</small> <?php global $arrCountries ;
										$output = '<select id="country" name="country" class="span4">';
											foreach($arrCountries as $country) :
												$arrCountry = explode('|',$country);
												$output .= '<option value="' . $arrCountry[0] . '">' . $arrCountry[1] . '</option>';
											endforeach;
											$output .= '</select>';
											echo $output;
										 ?> </p>
										<p class="formSep"><small class="span4">State:</small> 
										<?php
										$output1 = '<select id="state" name="state" class="span4">';
										foreach($arrUsStateList as $state) :
											$arrState = explode('|',$state);
											$output1 .= '<option value="' . $arrState[0] . '">' . $arrState[1] . '</option>';
										endforeach;
										$output1 .= '</select>';
										echo $output1;
										?>
										<input class="span4" type="text" name="otherstate" id="otherstate" placeholder="Other State">
										</p>
										<p class="formSep"><small class="span4">City:</small> 
										<?php
										$output2 = '<select id="city" name="city" class="span4">';
										foreach($arrUsCities as $city) :
											$arrCity = explode('|',$city);
											$output2 .= '<option value="' . $arrCity[0] . '">' . $arrCity[1] . '</option>';
										endforeach;
										$output2 .= '</select>';
										echo $output2;
										?>
										 <input class="span4" type="text" name="othercity" id="othercity" placeholder="Other City">
										</p>
										<p class="formSep"><small class="span4">Pstcode:</small> <input  type="text" name="postcode" id="postcode" value=""></p>
										<p class="formSep"><small class="span4">Fax:</small> <input  type="text" name="fax" id="fax" value=""></p>
										<p class="formSep"><small class="span4">Website:</small><input  type="text" name="website" id="website" value=""> </p>
									</div>
									<div class="formSep">
						  <div align="center">
							<input type="submit" name="submit" value="Save" class="btn btn-beoro-3">
							
							<input type="button" class="btn btn-beoro-3"  name="cancel" value="Cancel" onClick="window.location='client_profile.php'">
							
								
							</div>
							</div>
										</form>
									<?php 	}else{
									?>
									  <div class="span2">
										<span class="span12"><a href="client_profile.php?id=1">Edit Profile</a><br></span>
                                        <div class="img-holder">
                                            <img class="img-avatar" alt="" src="<?php echo base_url('assets/clientadmin'); ?>/img/avatars/avatar_4.png">
                                        </div>
                                    </div>
                                    <div class="span5">
                                        <!--<p class="formSep"><small class="muted span4">Verified:</small> <span class="label label-success">Yes</span></p>-->
                                       <!-- <p class="formSep"><small class="muted span4">Active Plan:</small> Plan One</p>-->
										<p class="formSep"><small class="muted span4">Username:</small><?php if(isset($clientinfo)) { echo $clientinfo->username; } ?></p>
                                        <p class="formSep"><small class="muted span4">Name:</small> <?php if(isset($clientinfo)) { echo $clientinfo->f_name.' '.$clientinfo->l_name; } ?></p>
                                        <p class="formSep"><small class="muted span4">Gender:</small><?php if(isset($clientinfo)) { echo ($clientinfo->gender) == 'M' ? 'Male' : 'Female' ; } ?></p>
                                        <p class="formSep"><small class="muted span4">Birthday:</small><?php if(isset($clientinfo)) { echo ($clientinfo->date_of_birth) == '0000-00-00' ? '' : '' ; } ?></p>
                                        <p class="formSep"><small class="muted span4">Email:</small> <?php if(isset($clientinfo)) { echo $clientinfo->email; } ?></p>
										<!--<p class="formSep"><small class="muted span4">Login type:</small> Via Facebook</p>-->
                                        
										
										
                                    </div>
									<div class="span5">
										<p class="formSep"><small class="muted span4">Contact number:</small> 9922531531</p>
                                        <p class="formSep"><small class="muted span4">Languages:</small> English, French</p>
										<p class="formSep"><small class="muted span4">Address 1:</small>STPI Aurangabad</p>
                                        <p class="formSep"><small class="muted span4">country:</small> India </p>
										<p class="formSep"><small class="muted span4">State:</small> Maharashtra </p>
										<p class="formSep"><small class="muted span4">City:</small> Aurangabad </p>
										<p class="formSep"><small class="muted span4">Pstcode:</small> 431003 </p>
										<p class="formSep"><small class="muted span4">Fax:</small> 4551456 </p>
										<!--<p class="formSep"><small class="muted span4">Website:</small>http://www.enrich.in </p>-->
									</div>
									<?php }?>
                                </div>
                            </div>
                        </div>
                    </div>

</div>
            </div>


</div>



        
