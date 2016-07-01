<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!-- main content -->

<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12">
      <div class="w-box w-box-green">
        <div class="w-box-header">
          <h4>License and Environment Settings (Product)</h4>
          <i class="icsw16-settings icsw16-white pull-right"></i> </div>
        <div class="w-box-content cnt_a">
          <div class="row-fluid">
            <div class="span12">
              <p class="heading_a">Site Settings: Environment Setting</p>
			  <div id="flashmessages" >
			   <?php if($this->session->userdata('warning')): ?>
			  <?php $warning =$this->session->userdata('warning'); ?>
			  <div class="alert alert-error"> <a data-dismiss="alert" class="close">x</a><strong>Warning!</strong> <?php echo $warning; ?></div>
			  <?php endif; ?>
			  
			  <?php if($this->session->userdata('success')): ?>
			  <?php $success =$this->session->userdata('success'); ?>
			  <div class="alert alert-success"><a data-dismiss="alert" class="close">x</a><strong>Success!</strong> <?php echo $success; ?></div>
			  <?php endif; ?>
			  
			  <?php $this->session->unset_userdata('warning');?>
			 <?php $this->session->unset_userdata('success');?>
              <!-- Tab Settings -->
			  </div>
              <div class="row-fluid">
                <!--<div class="span6">-->
                <div class="tabbable tabbable-bordered">
                  <ul class="nav nav-tabs">
                    <li <?php echo (($tab == '' or $tab == 'tb1_h')? 'active' : '') ?> ><a data-toggle="tab" href="#tb1_h">Environment Setting</a></li>
                    <li ><a data-toggle="tab" href="#tb1_g">License Info</a></li>
                    <li ><a data-toggle="tab" href="#tb1_k">Change License Key</a></li>
                    <li class="<?php echo ($tab == 'tb1_i'? 'active' : '') ?>"><a data-toggle="tab" href="#tb1_i">System Env</a></li>
                    <li ><a data-toggle="tab" href="#tb1_cron">Cron Jobs and Import / Export</a></li>
                    <!-- <li ><a data-toggle="tab" href="#tb1_j">Tracking</a></li> -->
                    <!-- <li ><a data-toggle="tab" href="#tb1_other">Client Display Format</a></li> -->
                    <!-- <li ><a data-toggle="tab" href="#tb1_setting2">Setting II</a></li> -->
                  </ul>
                  <div class="tab-content">
                    <div id="tb1_k" class="tab-pane">
                      <p class="heading_a">License Change</p>
                      <div class="formSep">
                        <label >User Name</label>
                        <input type="text" placeholder="User Name">
                        <label >Password</label>
                        <input type="password" placeholder="Password">
                        <label >New License Key</label>
                        <input type="text" placeholder="New License Key">
                      </div>
                      <div class="formSep">
                        <button class="btn btn-beoro-3">Change License Key</button>
                      </div>
                      <p> <br>
                        <span class="help-block help-last">You can change your license key by entering your admin login details and new key below. Requires full admin access permissions.</span> </p>
                    </div>
                    <div id="tb1_g" class="tab-pane">
                      <p class="heading_a">License Info</p>
                      <!-- License Info Table -->
                      <div class="formSep span8">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td>Registered To</td>
                              <td>Company Name</td>
                            </tr>
                            <tr>
                              <td>License Key</td>
                              <td>EQAR-2b0634ea466e0074b6c6</td>
                            </tr>
                            <tr>
                              <td>License Type</td>
                              <td>EQAR - Service License</td>
                            </tr>
                            <tr>
                              <td>Valid Domain(s)</td>
                              <td>mydomain.in,www.mydomain.in</td>
                            </tr>
                            <tr>
                              <td>Valid IP</td>
                              <td>119.18.60.94</td>
                            </tr>
                            <tr>
                              <td>Valid Directory</td>
                              <td>/home/mydomain/public_html/survey</td>
                            </tr>
                            <tr>
                              <td>Branding Removal</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td>Created</td>
                              <td>2012-06-20</td>
                            </tr>
                            <tr>
                              <td>Expires</td>
                              <td>Never</td>
                            </tr>
                          </tbody>
                        </table>
                        <p> <br>
                          <span class="help-block help-last">If you are planning to move your EQAR System to a new location then you will need to get your license reissued.</span> </p>
                      </div>
                      <!-- End License Info Table -->
                    </div>
                    <!-- Tab 2 -->
                    <div id="tb1_h" class="tab-pane <?php echo (($tab == '' or $tab == 'tb1_h') ? 'active' : '') ?>">
					<form name="frm_sys_env" method="post" onsubmit="return validate_env_settings();">
                      <div class="span6">
                        <p class="heading_a">System Environment</p>
                        <div class="formSep">
                          <label for="s_clientreg">Is Multi Company (As per License)</label> 
                          <input name="e_multicompany" type="checkbox" id="e_multicompany" value="Y" <?php echo ($e_multicompany == 'Y' ? ' checked="checked" ' : '') ?> />
                        </div>
                        <div class="formSep">
                          <label>Username Login Type</label>
						   <?php if( $e_logintype == -1 or $e_logintype == '' ) : ?>
                          <select name="e_logintype" class="span4" id="logintype">
                            <option value="-1">Select</option>
							<option value="Email">Email</option>
                            <option value="Mobile">Mobile</option>
                            <option value="EmpID">EmpID</option>
                            <option value="auto">auto (suggestions)</option>
							<?php if($oninternet == 'Y') : ?>
                            <option value="viaSNS">Login via SNS</option>
							<?php endif; ?>
                          </select>
						  
						  <input type="hidden" name="fromdb" id="fromdb" value="0" />
						  <?php else: ?>
						  <input type="hidden" name="e_logintype" value="<?php echo $e_logintype; ?>" />
						  <input type="hidden" name="fromdb" id="fromdb" value="1" />
						  <?php echo 'Login type: ' . $e_logintype; ?><br /><br />
						  <?php endif; ?>
						  
						  <div id="rb_private" style="width:300px; float:right; display:none; ">
						  <?php if( $e_logintype == -1 or $e_logintype == '' ) : ?>
						  <label class="radio inline"><input <?php echo ($rb_private_domains == 'private' ? ' checked="checked" ' : '') ?> type="radio" name="rb_private_domains" value="private" id="rb_private_option" />Private Domain </label>
						  <label class="radio inline"><input <?php echo ($rb_private_domains == 'all' ? ' checked="checked" ' : '') ?> type="radio" name="rb_private_domains" value="all" id="rb_all_option" />All Domains</label>
						  <?php else: ?>
						  <input type="hidden" name="rb_private_domains" value="<?php echo $rb_private_domains; ?>" />
						  <label class="radio inline"><input <?php echo ($rb_private_domains == 'private' ? ' checked="checked" ' : '') ?> type="radio" name="rb_private_domains" value="private" id="rb_private_option" disabled="disabled" />Private Domain </label>
						  <label class="radio inline"><input <?php echo ($rb_private_domains == 'all' ? ' checked="checked" ' : '') ?> type="radio" name="rb_private_domains" value="all" id="rb_all_option" disabled="disabled" />All Domains</label>
						  <?php endif; ?>
						  </div>
						  <span class="help-block help-last">*Once Updated can't change later</span>
						  <div class="clearfix"></div>
						  <div class="span6" id="empid_info">
						  <label>Minimum username length</label>
						  <select name="min_username_length" id="min_username_length" class="span3" >
                            <option value="3" <?php echo ($min_username_length == '3' ? ' selected="selected" ' : '') ?> >3</option>
							<option value="4" <?php echo ($min_username_length == '4' ? ' selected="selected" ' : '') ?> >4</option>
							<option value="5" <?php echo ($min_username_length == '5' ? ' selected="selected" ' : '') ?> >5</option>
							<option value="6" <?php echo ($min_username_length == '6' ? ' selected="selected" ' : '') ?> >6</option>
							<option value="7" <?php echo ($min_username_length == '7' ? ' selected="selected" ' : '') ?> >7</option>
							<option value="8" <?php echo ($min_username_length == '8' ? ' selected="selected" ' : '') ?> >8</option>
							<option value="9" <?php echo ($min_username_length == '9' ? ' selected="selected" ' : '') ?> >9</option>
							<option value="10" <?php echo ($min_username_length == '10' ? ' selected="selected" ' : '') ?> >10</option>							
                          </select>
						  </div>
						  <div class="span5" id="empid_info2">
						  <label class="radio inline"><input <?php echo ($empid_format == 'allow_special_char' ? ' checked="checked" ' : '') ?> type="radio" name="empid_format" value="allow_special_char" id="allow_special_char" checked="checked" />Allow Alpha numeric</label>
						  <label class="radio inline"><input <?php echo ($empid_format == 'allow_only_numbers' ? ' checked="checked" ' : '') ?> type="radio" name="empid_format" value="allow_only_numbers" id="allow_only_numbers" />Only Numbers</label>
						  <label class="radio inline"><input <?php echo ($empid_format == 'allow_only_char' ? ' checked="checked" ' : '') ?> type="radio" name="empid_format" value="allow_only_char" id="allow_only_char" />Only Characters</label>

						  </div>
						  
                        </div>
                        <div class="formSep" id="private_domain_info">
                          <label for="s_clientreg">Is Private Domain</label>
                          <!--<input name="e_isprivate" type="checkbox" id="e_isprivate" value="Y" <?php echo ($e_isprivate == 'Y' ? ' checked="checked" ' : '') ?>  />-->
                          <textarea <?php echo ($rb_private_domains == 'all' ? ' disabled="disabled" ' : '') ?> name="private_domain_list" id="private_domain_list" placeholder="Private Domain"><?php echo $private_domain_list; ?></textarea>
                        </div>
                        <div class="formSep" id="login_sns">
                          <label >Is user login via sns (Based on Module Install - Require Internet)</label>
						  
                          <!--<input name="e_is_sns" type="checkbox" id="e_is_sns" value="Y" <?php echo ($e_is_sns == 'Y' ? ' checked="checked" ' : '') ?> />-->
                          <br>
                          <label class="checkbox inline">
                          <input name="is_login_fb" type="checkbox" id="is_login_fb" value="Y" <?php echo ($is_login_fb == 'Y' ? ' checked="checked" ' : '') ?> >
                          FB</label>
                          <label class="checkbox inline">
                          <input name="is_login_twitter" type="checkbox" id="is_login_twitter" value="Y" <?php echo ($is_login_twitter == 'Y' ? ' checked="checked" ' : '') ?> >
                          Twitter</label>
                          <label class="checkbox inline">
                          <input name="is_login_linkedin" type="checkbox" id="is_login_linkedin" value="Y" <?php echo ($is_login_linkedin == 'Y' ? ' checked="checked" ' : '') ?> >
                          Linkedin</label>
						  
                        </div>
                      </div>
                      <div class="span6">
                        <div class="formSep" id="isverificationrequired">
                          <label >Is User Verification Required</label>
                          <input name="e_is_userverified_req" type="checkbox" id="e_is_userverified_req" value="Y" <?php echo ($e_is_userverified_req == 'Y' ? ' checked="checked" ' : '') ?> />
                          <br>
                          <label >Valid Verification Method</label>
                          <label class="checkbox inline">
                          <input name="e_verificationby_email" type="checkbox" id="e_verificationby_email" value="Y" <?php echo ($e_verificationby_email == 'Y' ? ' checked="checked" ' : '') ?> />
                          Email</label>
                          <label class="checkbox inline">
                          <input name="e_verificationby_sms" type="checkbox" id="e_verificationby_sms" value="Y" <?php echo ($e_verificationby_sms == 'Y' ? ' checked="checked" ' : '') ?> >
                          SMS</label>
                          <label class="checkbox inline">
                          <input name="e_verificationby_ivr" type="checkbox" id="e_verificationby_ivr" value="Y" <?php echo ($e_verificationby_ivr == 'Y' ? ' checked="checked" ' : '') ?> >
                          IVR / Personal Calling</label>
                          <br>
                          <br>
                          <span class="help-block help-last">*SMS / IVR is based on module Install</span> </div>
                        <div class="formSep" id="smsapi_info">
                          <label >SMS API</label>
                          <input name="e_sms_api" type="text" id="e_sms_api" placeholder="SMS API" value="<?php echo $e_sms_api; ?>" >
                          <label >SMS Username</label>
                          <input name="e_sms_username" type="text" id="e_sms_username" placeholder="SMS Username" value="<?php echo $e_sms_username; ?>" >
                          <label >SMS Password</label>
                          <input name="e_sms_passwd" type="password" id="e_sms_passwd" placeholder="SMS Password" value="<?php echo $e_sms_passwd; ?>" >
                          <br>
                          <br>
                          <!-- <button class="btn btn-beoro-3">Update Environment Setting</button> -->
						  
                        </div>
						<div class="formSep" >
						<input class="btn btn-beoro-3" type="submit" name="submit" value="Update Environment Settings" />
						</div>
                      </div>
					  <input type="hidden" name="current_tab" value="tb1_h" />
					  </form>
                    </div>
					
                    <!-- End Tab 2 -->
                    <!-- Tab 3 -->
                    <div id="tb1_i" class="tab-pane <?php echo ($tab == 'tb1_i'? 'active' : '') ?>">
					<form name="frmdb" method="post" onsubmit="return validate_db();">
                      <p class="heading_a">Env Database Setting</p>
                      <div class="formSep">
                        <label>Database Host</label>
                        <input type="text" id="s_db_host" name="s_db_host" class="span4" placeholder="Host Name" >
                        <label>Database User</label>
                        <input type="text" id="s_db_user" name="s_db_user" class="span4" placeholder="User Name" >
                        <label>Database Password</label>
                        <input type="text" id="s_db_pass" name="s_db_pass" class="span4" placeholder="Database Password" >
                        <label>Database Name</label>
                        <input type="text" id="s_db_name" name="s_db_name" class="span4" placeholder="Database Name" >
                      </div>
                      <div class="formSep">
                        <!-- <button class="btn btn-beoro-3">Save Settings</button> -->
						<input type="hidden" name="current_tab" value="tb1_i" />
						<input class="btn btn-beoro-3" type="submit" name="submit" value="Change Database Settings" /><br />
						(Please take existing database backup before chagne database settings.)
                      </div>
					 </form> 
                    </div>
                    <!-- End Tab 3 -->
                    <!-- Tab 4 -->
                    <div id="tb1_j" class="tab-pane">
                      <div class="heading_a">Tracking</div>
                    </div>
                    <!-- End Tab 4 -->
                    <!-- Tab 5 -->
                    <div id="tb1_cron" class="tab-pane">
                      <div class="span6">
                        <p class="heading_a">Cron Jobs</p>
                        <div class="formSep">
                          <label>Create Cron Job</label>
                          <input id="cronjob" type="text" class="span8" placeholder="php -q /home/infihost/public_html/crm/admin/cron.php">
                          <label>Create Execution Settings</label>
                          <input id="cronjobsetting" type="text" class="span8" placeholder="min	hour day/month month day/week Execution time">
                        </div>
                        <div class="formSep">
                          <button class="btn btn-beoro-3">Update Cron</button>
                        </div>
                      </div>
                      <div class="span6">
					  	<form name="mysqlbackup" method="post" >
                        <div class="heading_a">Database Backup</div>
                        <div class="formSep">
                          <label>Database / Module Backup</label>
                          <select class="span4" name="db_backup">
                            <option>Database</option>
                          </select>
                        </div>
                        <div class="formSep">
                          <!--<button class="btn btn-beoro-3">Backup >></button>-->
						  <input class="btn btn-beoro-3" type="submit" name="submit" value="Backup >>" />
						  <input type="hidden" name="current_tab" value="tb1_cron" />
                        </div>
						</form>
                        
                      </div>
                    </div>
                    <!-- End Tab 5 -->
                    <!-- Tab 7 -->
                    <div id="tb1_setting2" class="tab-pane">
                      <div class="heading_a">Setting II</div>
                      <div class="formSep">
                        <label class="span2">Max Bandwidth (MB)</label>
                        <input class="span2"  type="text" name="maxbindwidth" placeholder="10000">
                      </div>
                      <div class="formSep">
                        <label class="span2">Max Email Quota (@hr)</label>
                        <input class="span2"  type="text" name="maxemail" placeholder="100">
                      </div>
                      <div class="formSep">
                        <label class="span2">Ban IP</label>
                        <textarea rows="5" cols="20" placeholder="saparated by comma"></textarea>
                      </div>
                      <div class="formSep">
                        <label class="span2">Allowed IP</label>
                        <textarea rows="5" cols="20" placeholder="saparated by comma"></textarea>
                      </div>
                    </div>
                    <!-- End Tab 7 -->
                  </div>
                </div>
                <!--</div>-->
              </div>
              <!-- End Tab Settings -->
            </div>
            <!-- Settings -->
            <!-- Panel Right -->
            <!-- End Settings -->
          </div>
        </div>
        <div class="w-box-footer">
          <!--<div class="f-center">
              <button class="btn btn-beoro-3">Save</button>
              <button class="btn btn-link inv-cancel">Cancel</button>
            </div>-->
        </div>
      </div>
    </div>
  </div>
</div>
<br />
<script type="text/javascript">
hide_message('flashmessages');
</script>