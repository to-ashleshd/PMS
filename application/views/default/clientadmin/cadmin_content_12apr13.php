<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!-- main content -->
<!-- <script src="<?php echo base_url("assets/clientadmin"); ?>/js/ckeditor.js"></script> -->

<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12">
      <div class="w-box w-box-green">
        <div class="w-box-header">
          <h4>Site Settings (Product)</h4>
          <i class="icsw16-settings icsw16-white pull-right"></i> </div>
        <div class="w-box-content cnt_a">
          <div class="row-fluid">
            <div class="span12">
              <p class="heading_a">Site Settings: General Settings</p>
              <!-- Display Success and Warning -->
			  <?php if($this->session->userdata('warning')): ?>
			  <?php $warning =$this->session->userdata('warning'); ?>
			  <div class="alert alert-error"> <a data-dismiss="alert" class="close">x</a><strong>Warning!</strong> <?php echo $warning; ?></div>
			  <?php endif; ?>
			  
			  <?php if($this->session->userdata('success')): ?>
			  <?php $success =$this->session->userdata('success'); ?>
			  <div class="alert alert-success"><a data-dismiss="alert" class="close">x</a><strong>Success!</strong> <?php echo $success; ?></div>
			  <?php endif; ?>
			  
              
              <!-- Tab Settings -->
              <div class="row-fluid">
                <!--<div class="span6">-->
                <div class="tabbable tabbable-bordered">
				  
                  <?php $this->session->unset_userdata('warning');?>
				  <?php $this->session->unset_userdata('success');?>
				  
				  
                  <ul class="nav nav-tabs">
                    <li class="<?php echo (($tab == '' or $tab == 'tb1_a')? 'active' : '') ?> "><a data-toggle="tab" href="#tb1_a">General</a></li>
                    <li class="<?php echo ($tab == 'tb1_b'? 'active' : '') ?>" ><a data-toggle="tab" href="#tb1_b">Mail Settings</a></li>
                    <li class="<?php echo ($tab == 'tb1_c'? 'active' : '') ?>"><a data-toggle="tab" href="#tb1_c">Language - Date & Time</a></li>
                    <li class="<?php echo ($tab == 'tb1_e'? 'active' : '') ?>"><a data-toggle="tab" href="#tb1_e">Security and Other Settings</a></li>
                    <li class="<?php echo ($tab == 'tb1_i'? 'active' : '') ?>" ><a data-toggle="tab" href="#tb1_i">Email Templates</a></li>
                  </ul>
                  <div class="tab-content">
                    <div id="tb1_a" class="tab-pane <?php echo (($tab == '' or $tab == 'tb1_a') ? 'active' : '') ?>">
                      <form name="frm_general" method="post" enctype="multipart/form-data"  >
                        <div class="span6">
                          <div class="formSep">
                            <label>Company Logo</label>
                            <!--
						  <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 60px; height: 60px;"><img src="img/dummy_60x60.gif" alt="" ></div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="width: 60px; height: 60px;"></div>
                            <span class="btn btn-small btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                            <input type="file">
                            </span> <a href="#" class="btn btn-small btn-link fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
						-->
                            <!-- Image Upload -->
                            <!--
                          <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;"> <img src="<?php echo base_url("assets/clientadmin"); ?>/img/dummy_150x150.gif" alt=""> </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
                            <div> <span class="btn btn-small btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                              <input type="file" name="companylogo" id="companylogo">
                              </span> <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                          </div>
                          -->
                            <!--                            <label>Company Logo</label>-->
                            <img src="<?php echo base_url("uploads"); ?>/<?php echo $logo; ?>" height="43" width="132" alt="Logo"  /> <br />
                            <input type="file" name="userfile" id="file">
							<br /><br />
							<p><span class="help-block help-last">Valid Logo formats .gif .jpg .png .jpeg - Maximum File size to upload Width: 1024px X Height: 768px<br />
							Logo Size - Width: 132px X Height: 43px</span></p>							
                            <!-- End Image Upload -->
                          </div>
                          <div class="formSep">
                            <label for="s_name">Site Name</label>
                            <input type="text" class="span8" id="gen_site_name" name="gen_site_name" value="<?php echo $gen_site_name; ?>" />
                          </div>
                          <div class="formSep">
                            <label for="s_clientreg">Allow Client Registration</label>
                            <input name="gen_clientreg" type="checkbox" id="gen_clientreg" value="Y" <?php echo ($gen_clientreg == 'Y' ? ' checked="checked" ' : '') ?> />
                          </div>
                          <div class="formSep">
                            <label >Rows per page in List</label>
                            <select name="gen_rows_per_page" class="span4" id="gen_rows_per_page">
                              <option value="10" <?php echo ($gen_rows_per_page == '10' ? ' selected="selected" ' : '') ?> >10</option>
                              <option value="25" <?php echo ($gen_rows_per_page == '25' ? ' selected="selected" ' : '') ?> >25</option>
                              <option value="50" <?php echo ($gen_rows_per_page == '50' ? ' selected="selected" ' : '') ?> >50</option>
                              <option value="100" <?php echo ($gen_rows_per_page == '100' ? ' selected="selected" ' : '') ?> >100</option>
                            </select>
                          </div>
                        </div>
                        <div class="span6">
                          <div class="formSep">
                            <label for="s_offline">Site Offline</label>
                            <input name="gen_is_offline" type="checkbox" id="gen_is_offline" value="Y" <?php echo ($gen_is_offline == 'Y' ? ' checked="checked" ' : '') ?>  />
                          </div>
                          <div class="formSep" id="offilne_message">
                            <label for="s_off_message">Offline Message</label>
                            <textarea name="gen_off_message" id="gen_off_message" cols="30" rows="4" class="span8"><?php echo $gen_off_message; ?></textarea>
                          </div>
                          <div class="formSep">
                            <label for="themeMode">Theme Template</label>
                            <select id="themeMode" name="gen_theme_template" class="span8">
                              <option value="default" <?php echo ($gen_theme_template == 'default' ? ' selected="selected" ' : '') ?>>Default</option>
                              <!-- No More themes available
                            <option value="classic">Classic</option>
                            <option value="portal">Portal</option>
                            <option value="chat">Chat</option>
							-->
                            </select>
                            <span class="help-block help-last">Select the theme.</span> <br>
                            <!-- <button class="btn btn-beoro-3">Update General</button> -->
                            <input  class="btn btn-beoro-3" type="submit" name="submit" value="Update Setting" />
                          </div>
                        </div>
                        <input type="hidden" name="current_tab" value="tb1_a" />
                      </form>
                    </div>
                    <div id="tb1_b" class="tab-pane <?php echo ($tab == 'tb1_b'? 'active' : '') ?>">
                      <form name="frm_mainsetting" method="post" onsubmit="return validate_mailsetting();" >
					  <?php
					  //Set Default settiing 
					  //If setting == mail then reset smtp setting
					  if( $s_mailer == 'mail' ) {
					  	$s_smtp_user = '';
						$s_smtp_password = '';
						$s_smtp_host = '';
						$s_smtp_port = '';
					  }
					  ?>
					  
					  
                        <div class="span6">
                          <p class="heading_a">PHP Mail Settings</p>
                          <div class="formSep">
                            <label for="s_mailer">Mailer</label>
                            <select id="s_mailer" name="s_mailer" class="span6">
                              <option value="mail" <?php echo ($s_mailer == 'mail' ? ' selected="selected" ' : '') ?> >PHP Mail</option>
                              <option value="smtp" <?php echo ($s_mailer == 'smtp' ? ' selected="selected" ' : '') ?> >SMTP</option>
                            </select>
                          </div>
                          <div class="formSep">
                            <label for="s_mail_from">From Email</label>
                            <input type="text" class="span8" id="s_mail_from" name="s_mail_from" value="<?php echo $s_mail_from; ?>" />
                          </div>
                          <div class="formSep">
                            <label for="s_mail_name">From Name</label>
                            <input type="text" class="span8" id="s_mail_name" name="s_mail_name" value="<?php echo $s_mail_name; ?>" />
                          </div>
                          <div class="formSep">
                            <label for="s_mail_name">&nbsp;</label>
                            <input type="hidden" name="current_tab" value="tb1_b" />
                            <input class="btn btn-beoro-3" type="submit" name="submit" value="Update Mail Settings" />
                          </div>
                        </div>
                        <div class="span6" id="smtp_settings">
                          <p class="heading_a">SMTP Settings</p>
                          <div class="formSep">
                            <label for="s_smtp_user">SMTP Username</label>
                            <input type="text" class="span8" id="s_smtp_user" name="s_smtp_user" value="<?php echo $s_smtp_user; ?>" />
                          </div>
                          <div class="formSep">
                            <label for="s_smtp_password">SMTP Password</label>
                            <input type="password" class="span8" id="s_smtp_password" name="s_smtp_password" value="<?php echo $s_smtp_password; ?>" />
                          </div>
                          <div class="formSep">
                            <label for="s_smtp_host">SMTP Host</label>
                            <input type="text" class="span8" id="s_smtp_host" name="s_smtp_host" value="<?php echo $s_smtp_host; ?>" />
                          </div>
                          <div class="formSep">
                            <label for="s_smtp_host">SMTP Port</label>
                            <input type="text" class="span8" id="s_smtp_port" name="s_smtp_port"  value="<?php echo $s_smtp_port; ?>" />
                          </div>
                          <div class="formSep">
                            <label>SMTP SSL Type</label>
                            <label for="u_none" class="radio inline">
                            <input name="u_ssl" type="radio" id="u_none" value="none" <?php echo ($u_ssl == 'smtp' ? ' checked="checked" ' : '') ?> />
                            None</label>
                            <label for="u_ssl" class="radio inline">
                            <input name="u_ssl" type="radio" id="u_ssl" value="ssl" <?php echo ($u_ssl == 'ssl' ? ' checked="checked" ' : '') ?> />
                            SSL</label>
                            <label for="u_tls" class="radio inline">
                            <input name="u_ssl" type="radio" id="u_tls" value="tls" <?php echo ($u_ssl == 'tls' ? ' checked="checked" ' : '') ?> />
                            TLS</label>
                          </div>
                        </div>
                        <br>
                        <br>
                        <!-- <button class="btn btn-beoro-3">Update Mail Settings</button> -->
                      </form>
                    </div>
                    <div id="tb1_c" class="tab-pane <?php echo ($tab == 'tb1_c'? 'active' : '') ?>">
                      <form name="frm_language" method="post" onsubmit="return validate_language();">
                        <div class="span6">
                          <p class="heading_a">Languages</p>
                          <div class="formSep">
                            <label for="s_lang_visitors">Select the languages that are accessible for visitors</label>
                            <input type="text" id="s_lang_visitors" name="s_lang_visitors" class="span8" value="<?php echo $s_lang_visitors; ?>" >
                          </div>
                          <div class="formSep">
                            <label for="s_lang_redirect">Select the languages that people may automatically be redirected to based upon their browser language</label>
                            <input type="text" id="s_lang_redirect" name="s_lang_redirect" class="span8" value="<?php echo $s_lang_redirect; ?>" >
                          </div>
						  <div class="formSep">
                            <label for="s_lang_redirect">&nbsp;</label>
							<span class="help-block help-last">For More Language Support you need to create saparate language file and placed in to core language folder</span>
                          </div>
						  
						  
						  
                          <br>
                          <br>
                          <!-- <button class="btn btn-beoro-3">Update Language Settings</button> -->
                        </div>
                        <div class="span6">
                          <p class="heading_a">Date & Time</p>
                          <div class="formSep" >
                            <label for="time_format" class="span4" >Time Format</label>
                            <select name="s_time_format" id="s_time_format" class="span4">
                              <option <?php echo ($s_time_format == 'H:i' ? '   selected="selected" ' : '') ?> value="H:i">08:25</option>
                              <option <?php echo ($s_time_format == 'H:i:s' ? ' selected="selected" ' : '') ?> value="H:i:s">08:25:16</option>
                              <option <?php echo ($s_time_format == 'g:i a' ? ' selected="selected" ' : '') ?> value="g:i a">08:25 am</option>
                              <option <?php echo ($s_time_format == 'g:i A' ? ' selected="selected" ' : '') ?> value="g:i A">08:25 AM</option>
                              <option <?php echo ($s_time_format == 'G:i' ? '   selected="selected" ' : '') ?> value="G:i">20:25</option>
                              <option <?php echo ($s_time_format == 'G:i:s' ? ' selected="selected" ' : '') ?> value="G:i:s">20:25:16</option>
                            </select>
                            <span class="help-block help-last">This format is used to display dates on the website.</span> </div>
                          <div class="formSep">
                            <label for="date_format" class="span4">Date Format</label>
                            <select name="s_date_format" id="s_date_format" class="span4">
                              <option <?php echo ($s_date_format == 'd/m/Y' ? ' selected="selected" ' : '') ?> value="d/m/Y">DD/MM/YYYY</option>
                              <option <?php echo ($s_date_format == 'd.m.Y' ? ' selected="selected" ' : '') ?> value="d.m.Y">DD.MM.YYYY</option>
                              <option <?php echo ($s_date_format == 'd-m-Y' ? ' selected="selected" ' : '') ?> value="d-m-Y">DD-MM-YYYY</option>
                              <option <?php echo ($s_date_format == 'm/d/Y' ? ' selected="selected" ' : '') ?> value="m/d/Y">MM/DD/YYYY</option>
                              <option <?php echo ($s_date_format == 'Y/m/d' ? ' selected="selected" ' : '') ?> value="Y/m/d">YYYY/MM/DD</option>
                              <option <?php echo ($s_date_format == 'Y-m-d' ? ' selected="selected" ' : '') ?> value="Y-m-d">YYYY-MM-DD</option>
                            </select>
                          </div>
                          <div class="formSep">
                            <label for="date_format" class="span4">Decimal Format</label>
                            <select name="s_decimal_format" id="s_decimal_format" class="span4">
                              <option <?php echo ($s_decimal_format == '0' ? ' selected="selected" ' : '') ?> value="0">1000</option>
                              <option <?php echo ($s_decimal_format == '1' ? ' selected="selected" ' : '') ?> value="1">1000.0</option>
                              <option <?php echo ($s_decimal_format == '2' ? ' selected="selected" ' : '') ?> value="2">1000.00</option>
                              <option <?php echo ($s_decimal_format == '3' ? ' selected="selected" ' : '') ?> value="3">1000.000</option>
                            </select>
                          </div>
                          <div class="formSep">
                            <label class="span4" >Currency Format</label>
                            <select name="s_currency_format" id="s_currency_format" class="span4">
                              <option <?php echo ($s_currency_format == 'INR' ? ' selected="selected" ' : '') ?> value="INR">10,00,000.00</option>
                              <option <?php echo ($s_currency_format == 'USD' ? ' selected="selected" ' : '') ?> value="USD">1,000,000.00</option>
                            </select>
							<span class="help-block help-last">Thousand Separator</span>
                            <br>
                            <label class="radio inline">
                            <input name="s_currency" type="radio" class="s_captcha" id="s_currency_1" value="INR" <?php echo ($s_currency == 'INR' ? ' checked="checked" ' : '') ?> />
                            INR (<?php echo INR; ?>)</label>
                            <label class="radio inline">
                            <input name="s_currency" type="radio" class="s_captcha" id="s_currency_2" value="USD" <?php echo ($s_currency == 'USD' ? ' checked="checked" ' : '') ?> />
                            USD (<?php echo USD; ?>)</label>
                            <label class="radio inline">
                            <input name="s_currency" type="radio" class="s_captcha" id="s_currency_3" value="YEN" <?php echo ($s_currency == 'YEN' ? ' checked="checked" ' : '') ?> />
                            YEN (<?php echo YEN; ?>)</label>
                            <label class="radio inline">
                            <input name="s_currency" type="radio" class="s_captcha" id="s_currency_4" value="EURO" <?php echo ($s_currency == 'EURO' ? ' checked="checked" ' : '') ?> />
                            EURO (<?php echo EURO; ?>)</label>
                          </div>
                          <div class="formSep">
                            <label for="default_country" class="span4">Default Country</label>
                            <?php if( isset($s_select_country) and $s_select_country >= 1 ) : ?>
                            <?php echo $this->commonmodel->countryDropDown($s_select_country); ?>
                            <?php else: ?>
                            <?php echo $this->commonmodel->countryDropDown(); ?>
                            <?php endif; ?>
                            <?php // echo $countryDD; ?>
                            <span class="help-block help-last">Select Default Country</span> </div>
                          <div class="formSep">
                            <label for="time_zone" class="span4">Prefer Time Zone</label>
                            <select name="s_time_zone" id="s_time_zone" class="span6">
                              <option <?php echo ($s_time_zone == '-12' ? ' selected="selected" ' : '') ?> value="-12">[UTC - 12] Baker Island Time</option>
                              <option <?php echo ($s_time_zone == '-11' ? ' selected="selected" ' : '') ?> value="-11">[UTC - 11] Niue Time, Samoa Standard Time</option>
                              <option <?php echo ($s_time_zone == '-10' ? ' selected="selected" ' : '') ?> value="-10">[UTC - 10] Hawaii-Aleutian Standard Time, Cook Island Time</option>
                              <option <?php echo ($s_time_zone == '-9.5' ? ' selected="selected" ' : '') ?> value="-9.5">[UTC - 9:30] Marquesas Islands Time</option>
                              <option <?php echo ($s_time_zone == '-9' ? ' selected="selected" ' : '') ?> value="-9">[UTC - 9] Alaska Standard Time, Gambier Island Time</option>
                              <option <?php echo ($s_time_zone == '-8' ? ' selected="selected" ' : '') ?> value="-8">[UTC - 8] Pacific Standard Time</option>
                              <option <?php echo ($s_time_zone == '-7' ? ' selected="selected" ' : '') ?> value="-7">[UTC - 7] Mountain Standard Time</option>
                              <option <?php echo ($s_time_zone == '-6' ? ' selected="selected" ' : '') ?> value="-6">[UTC - 6] Central Standard Time</option>
                              <option <?php echo ($s_time_zone == '-5' ? ' selected="selected" ' : '') ?> value="-5">[UTC - 5] Eastern Standard Time</option>
                              <option <?php echo ($s_time_zone == '-4.5' ? ' selected="selected" ' : '') ?> value="-4.5">[UTC - 4:30] Venezuelan Standard Time</option>
                              <option <?php echo ($s_time_zone == '-4' ? ' selected="selected" ' : '') ?> value="-4">[UTC - 4] Atlantic Standard Time</option>
                              <option <?php echo ($s_time_zone == '-3.5' ? ' selected="selected" ' : '') ?> value="-3.5">[UTC - 3:30] Newfoundland Standard Time</option>
                              <option <?php echo ($s_time_zone == '-3' ? ' selected="selected" ' : '') ?> value="-3">[UTC - 3] Amazon Standard Time, Central Greenland Time</option>
                              <option <?php echo ($s_time_zone == '-2' ? ' selected="selected" ' : '') ?> value="-2">[UTC - 2] Fernando de Noronha Time, South Georgia &amp; the South Sandwich Islands Time</option>
                              <option <?php echo ($s_time_zone == '-1' ? ' selected="selected" ' : '') ?> value="-1">[UTC - 1] Azores Standard Time, Cape Verde Time, Eastern Greenland Time</option>
                              <option <?php echo ($s_time_zone == '0' ? ' selected="selected" ' : '') ?> value="0">[UTC] Western European Time, Greenwich Mean Time</option>
                              <option <?php echo ($s_time_zone == '1' ? ' selected="selected" ' : '') ?> value="1">[UTC + 1] Central European Time, West African Time</option>
                              <option <?php echo ($s_time_zone == '2' ? ' selected="selected" ' : '') ?> value="2">[UTC + 2] Eastern European Time, Central African Time</option>
                              <option <?php echo ($s_time_zone == '3' ? ' selected="selected" ' : '') ?> value="3">[UTC + 3] Moscow Standard Time, Eastern African Time</option>
                              <option <?php echo ($s_time_zone == '3.5' ? ' selected="selected" ' : '') ?> value="3.5">[UTC + 3:30] Iran Standard Time</option>
                              <option <?php echo ($s_time_zone == '4' ? ' selected="selected" ' : '') ?> value="4">[UTC + 4] Gulf Standard Time, Samara Standard Time</option>
                              <option <?php echo ($s_time_zone == '4.5' ? ' selected="selected" ' : '') ?> value="4.5">[UTC + 4:30] Afghanistan Time</option>
                              <option <?php echo ($s_time_zone == '5' ? ' selected="selected" ' : '') ?> value="5">[UTC + 5] Pakistan Standard Time, Yekaterinburg Standard Time</option>
                              <option <?php echo ($s_time_zone == '5.5' ? ' selected="selected" ' : '') ?> value="5.5" selected>[UTC + 5:30] Indian Standard Time, Sri Lanka Time</option>
                              <option <?php echo ($s_time_zone == '5.75' ? ' selected="selected" ' : '') ?> value="5.75">[UTC + 5:45] Nepal Time</option>
                              <option <?php echo ($s_time_zone == '6' ? ' selected="selected" ' : '') ?> value="6">[UTC + 6] Bangladesh Time, Bhutan Time, Novosibirsk Standard Time</option>
                              <option <?php echo ($s_time_zone == '6.5' ? ' selected="selected" ' : '') ?> value="6.5">[UTC + 6:30] Cocos Islands Time, Myanmar Time</option>
                              <option <?php echo ($s_time_zone == '7' ? ' selected="selected" ' : '') ?> value="7">[UTC + 7] Indochina Time, Krasnoyarsk Standard Time</option>
                              <option <?php echo ($s_time_zone == '8' ? ' selected="selected" ' : '') ?> value="8">[UTC + 8] Chinese Standard Time, Australian Western Standard Time, Irkutsk Standard Time</option>
                              <option <?php echo ($s_time_zone == '8.75' ? ' selected="selected" ' : '') ?> value="8.75">[UTC + 8:45] Southeastern Western Australia Standard Time</option>
                              <option <?php echo ($s_time_zone == '9' ? ' selected="selected" ' : '') ?> value="9">[UTC + 9] Japan Standard Time, Korea Standard Time, Chita Standard Time</option>
                              <option <?php echo ($s_time_zone == '9.5' ? ' selected="selected" ' : '') ?> value="9.5">[UTC + 9:30] Australian Central Standard Time</option>
                              <option <?php echo ($s_time_zone == '10' ? ' selected="selected" ' : '') ?> value="10">[UTC + 10] Australian Eastern Standard Time, Vladivostok Standard Time</option>
                              <option <?php echo ($s_time_zone == '10.5' ? ' selected="selected" ' : '') ?> value="10.5">[UTC + 10:30] Lord Howe Standard Time</option>
                              <option <?php echo ($s_time_zone == '11' ? ' selected="selected" ' : '') ?> value="11">[UTC + 11] Solomon Island Time, Magadan Standard Time</option>
                              <option <?php echo ($s_time_zone == '11.5' ? ' selected="selected" ' : '') ?> value="11.5">[UTC + 11:30] Norfolk Island Time</option>
                              <option <?php echo ($s_time_zone == '12' ? ' selected="selected" ' : '') ?> value="12">[UTC + 12] New Zealand Time, Fiji Time, Kamchatka Standard Time</option>
                              <option <?php echo ($s_time_zone == '12.75' ? ' selected="selected" ' : '') ?> value="12.75">[UTC + 12:45] Chatham Islands Time</option>
                              <option <?php echo ($s_time_zone == '13' ? ' selected="selected" ' : '') ?> value="13">[UTC + 13] Tonga Time, Phoenix Islands Time</option>
                              <option <?php echo ($s_time_zone == '14' ? ' selected="selected" ' : '') ?> value="14">[UTC + 14] Line Island Time</option>
                            </select>
                            <span class="help-block help-last">This format is used to display dates on the website.</span> <br>
                            <br>
                            <!-- <button class="btn btn-beoro-3">Update Time Zone</button> -->
                            <input class="btn btn-beoro-3" type="submit" name="submit" value="Update Language &amp; Time Zone" />
                          </div>
                        </div>
                        <input type="hidden" name="current_tab" value="tb1_c" />
                      </form>
                    </div>
                    <div id="tb1_e" class="tab-pane <?php echo ($tab == 'tb1_e'? 'active' : '') ?>">
                      <!-- Security Start -->
                      <form name="frm_security" method="post" onsubmit="return validate_security();">
                        <div class="span6">
                          <p class="heading_a">Security</p>
                          <div class="formSep">
						  	<label class="checkbox inline" ><input name="oninternet" type="checkbox" id="oninternet" value="Y" <?php echo ($oninternet == 'Y' ? ' checked="checked" ' : ''); ?> />
						  	Work on Internet</label>
							<br /><br />
                            <label>Captcha Type</label>
                            <label class="radio inline">
                            <input name="s_captcha" type="radio" class="s_captcha" id="s_default" value="default" <?php echo ($s_captcha == 'default' ? ' checked="checked" ' : '') ?> />
                            Default</label>
                            <label class="radio inline" id="recaptcha_rb">
                            <input name="s_captcha" type="radio" class="s_captcha" id="s_recaptcha" value="recaptcha" <?php echo ($s_captcha == 'recaptcha' ? ' checked="checked" ' : '') ?> />
                            reCAPTCHA (Requir internet connection)</label>
                            <div id="recaptchainfo" style="display:none;">
                              <label>Domain for reCaptcha</label>
                              <input type="text" name="recaptcha_domainname" id="recaptcha_domainname" value="<?php echo $recaptcha_domainname; ?>" placeholder="Domain for reCaptcha">
                              <label>reCaptcha Public Key</label>
                              <input type="text" name="recaptcha_publickey" id="recaptcha_publickey" value="<?php echo $recaptcha_publickey; ?>" placeholder="reCaptcha Public Key">
                              <label>reCaptcha Private Key</label>
                              <input type="text" name="recaptcha_privatekey" id="recaptcha_privatekey" value="<?php echo $recaptcha_privatekey; ?>" placeholder="reCaptcha Private Key">
                            </div>
                          </div>
                          <div class="formSep">
                            <label>Required Password Strength</label>
                            <div class="sepH_c">
                              <!--<form class="form-inline">-->
                              <!--<label for="ui_slider3_sel" class="sepH_b">Password Strength </label>-->
							  
                              <select name="ui_slider3_sel" id="ui_slider3_sel" class="input-mini span3">
                                <option <?php echo ($ui_slider3_sel == '1' ? ' selected="selected" ' : '') ?> value="1">Very Weak</option>
                                <option <?php echo ($ui_slider3_sel == '2' ? ' selected="selected" ' : '') ?> value="2">Weak</option>
                                <option <?php echo ($ui_slider3_sel == '3' ? ' selected="selected" ' : '') ?> value="3">Medium</option>
                                <option <?php echo ($ui_slider3_sel == '4' ? ' selected="selected" ' : '') ?> value="4">Strong</option>
                                <option <?php echo ($ui_slider3_sel == '5' ? ' selected="selected" ' : '') ?> value="5">Very Strong</option>
                              </select>
                              <!-- </form>-->
                            </div>
                          </div>
                          <!-- Ban Time -->
                          <div class="formSep form-inline" >
                            <label >Failed Admin Login Ban Time (In Minutes)</label>
                            <input name="s_bantime" type="text" class="span2" id="s_bantime" value="<?php echo $s_bantime; ?>" maxlength="3" />
                            <br>
                            <br>
                            <!-- <span class="help-block help-last">after exceeding 3 invalid login attempts.</span> -->
                            <label >after exceeding invalid login attempts.</label>
                            <input name="s_bantime_attempts" type="text" class="span2" id="s_bantime_attempts" value="<?php echo $s_bantime_attempts; ?>" maxlength="1" />
                          </div>
                          <div class="formSep form-inline">
                            <label>Password Change Required after Days</label>
                            <input name="s_password_change_days" type="text" class="span2" id="passwdchange" value="<?php echo $s_password_change_days; ?>" maxlength="2" />
                            <span class="help-block help-last">Leave Empty Or 0 Days to disable this feature</span> <br>
                            <label>Can't use Last 'n' passwords</label>
                            <select name="cant_use_last_passwd" id="cant_use_last_passwd" class="input-mini">
                              <option <?php echo ($cant_use_last_passwd == '0' ? ' selected="selected" ' : '') ?> value="0">0</option>
                              <option <?php echo ($cant_use_last_passwd == '1' ? ' selected="selected" ' : '') ?> value="1">1</option>
                              <option <?php echo ($cant_use_last_passwd == '2' ? ' selected="selected" ' : '') ?> value="2">2</option>
                              <option <?php echo ($cant_use_last_passwd == '3' ? ' selected="selected" ' : '') ?> value="3">3</option>
                              <option <?php echo ($cant_use_last_passwd == '4' ? ' selected="selected" ' : '') ?> value="4">4</option>
                              <option <?php echo ($cant_use_last_passwd == '5' ? ' selected="selected" ' : '') ?> value="5">5</option>
                              <!--
							  <option <?php echo ($cant_use_last_passwd == '6' ? ' selected="selected" ' : '') ?> value="6">6</option>
                              <option <?php echo ($cant_use_last_passwd == '7' ? ' selected="selected" ' : '') ?> value="7">7</option>
                              <option <?php echo ($cant_use_last_passwd == '8' ? ' selected="selected" ' : '') ?> value="8">8</option>
                              <option <?php echo ($cant_use_last_passwd == '9' ? ' selected="selected" ' : '') ?> value="9">9</option>
                              <option <?php echo ($cant_use_last_passwd == '10' ? ' selected="selected" ' : '') ?> value="10">10</option>
							  -->
                            </select>
                            <br>
                            <!--<button class="btn btn-beoro-3">Update Security</button>-->
                          </div>
                          <!-- Ban Time -->
                          <!-- Security End -->
                        </div>
                        <div class="span6">
                          <!-- Other Settings -->
                          <p class="heading_a">Other Settings</p>
                          <div class="formSep">
                            <label>Admin Client Display Format</label>
                            <label class="radio inline">
                            <input name="s_client_display_format" type="radio" id="s_fname" value="fname_lname" <?php echo ($s_client_display_format == 'fname_lname' ? ' checked="checked" ' : '') ?> />
                            Show first name/last name only</label>
                            <label class="radio inline">
                            <input name="s_client_display_format" type="radio" id="s_company" value="company_fname_lname" <?php echo ($s_client_display_format == 'company_fname_lname' ? ' checked="checked" ' : '') ?> />
                            Show company name if set, otherwise first name/last name</label>
                            <label class="radio inline">
                            <input name="s_client_display_format" type="radio" id="s_fname_company" value="fullname_company_name" <?php echo ($s_client_display_format == 'fullname_company_name' ? ' checked="checked" ' : '') ?> />
                            Show full name & company if set</label>
                            <br>
                            <br>
                            <!-- <button class="btn btn-beoro-3">Update Security Settings</button> -->
                            <input class="btn btn-beoro-3" type="submit" name="submit" value="Update Security Settings" />
                          </div>
                          <!-- End Other Setting -->
                        </div>
                        <input type="hidden" name="current_tab" value="tb1_e" />
                      </form>
                    </div>
                    <!-- Automation -->
                    <div id="tb1_g" class="tab-pane">
                      <p class="heading_a">Automotion</p>
                      <div class="formSep">
                        <label>Create Cron Job</label>
                        <input id="cronjob" type="text" class="span8" placeholder="php -q /home/infihost/public_html/crm/admin/cron.php">
                        <label>Create Execution Settings</label>
                        <input id="cronjobsetting" type="text" class="span8" placeholder="min	hour day/month month day/week Execution time">
                      </div>
                      <div class="formSep">
                        <button class="btn btn-beoro-3">Update Cron</button>
                      </div>
                      <div class="formSep">
                        <label>Database / Module Backup</label>
                        <select class="span4">
                          <option>EQAR</option>
                          <option>Email Template</option>
                          <option>Users / Subscribers</option>
                        </select>
                      </div>
                      <div class="formSep">
                        <button class="btn btn-beoro-3">Backup >></button>
                      </div>
                    </div>
                    <!-- End Automation -->
                    <!-- Table i Email Template -->
                    <div id="tb1_i" class="tab-pane <?php echo ($tab == 'tb1_i' ? ' active ' : '') ?>">
                      <form name="frm_emailtemplate" method="post" onsubmit="return validate_emailtemplate();">
                        <div class="heading_a">Email Templates List</div>
                        <!-- Email Template List -->
                        <div class="w-box w-box-orange">
                          <div class="w-box-header">
                            <h4>Email Template List <a href="<?php echo site_url(); ?>/clientadmin/generalsettings/tb1_i/">
                              <input name="newtemplate" type="button" class="btn btn-mini btn-inverse" style="height:22px;" value="New Template" />
                              </a> </h4>
                          </div>
                          <div class="w-box-content">
                            <table id="dt_colVis_emailtemplate" class="table table-striped table-condensed">
                              <thead>
                                <tr>
                                  <th>id</th>
                                  <th>Module</th>
                                  <th>Description</th>
                                  <th>Code</th>
                                  <th>Subject</th>
                                  <th>Body</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach( $email_templates as $row ) : ?>
                                <tr>
                                  <td><?php echo $row->emailtemplate_id; ?></td>
                                  <td>USER</td>
                                  <td><?php echo $row->emailtemplate_desc; ?></td>
                                  <td><?php echo $row->emailtemplate_code; ?></td>
                                  <td><?php echo $row->emailtemplate_subject; ?></td>
                                  <td><?php echo $row->emailtemplate_body; ?></td>
                                  <td><div class="btn-group"><a href="<?php echo site_url('clientadmin/generalsettings/tb1_i/'); ?>/<?php echo $row->emailtemplate_id; ?>" templateid="<?php echo $row->emailtemplate_id; ?>" class="btn btn-mini editemailtemplate" title="Edit"><i class="icon-pencil"></i></a>
                                      <!-- <a href="#" class="btn btn-mini" title="View"><i class="icon-eye-open"></i></a> -->
                                      <a href="<?php echo site_url(); ?>/clientadmin/delete_emailtemplate/<?php echo $row->emailtemplate_id; ?>" onclick="return check_confirm();" class="btn btn-mini" title="Delete"><i class="icsw16-acces-denied-sign"></i></a></div></td>
                                </tr>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <br>
                        <span class="help-block help-last">Standard Email Templates. You can customize your email messages.</span> <br>
                        <br>
                        <!-- End Email Template List -->
                        <?php
					  	//Default Values
						$emailtemplate_id = 0;
						$emailtemplate_code = '';
						$emailtemplate_desc = '';
						$emailtemplate_subject = '';
						$emailtemplate_body = '';
						
					  	if( $tab == 'tb1_i' and $tabid >= 1 ) {
							//Get Template details
							$template_details = $this->emailtemplatemodel->get_template($tabid);
							
							$emailtemplate_id = $template_details->emailtemplate_id;
						$emailtemplate_code = $template_details->emailtemplate_code;
						$emailtemplate_desc = $template_details->emailtemplate_desc;
						$emailtemplate_subject = $template_details->emailtemplate_subject;
						$emailtemplate_body = $template_details->emailtemplate_body;
							
							//echo '<pre>';
							//print_r($template_details);
							//echo '</pre>';
							
						}
					  ?>
                        <div class="heading_a">New Email Template</div>
                        <input type="hidden" name="templateid" value="<?php echo $emailtemplate_id; ?>" />
                        <label>Email Template Code</label>
                        <input style="height:auto;" type="text" name="templatecode" id="templatecode" placeholder="Template code" value="<?php echo $emailtemplate_code; ?>">
                        <span class="help-block help-last">A Unique code like REGSUCCESSFULL, FORGOTPASS, WELCOME etc.</span>
                        <label>Description For Reference.</label>
                        <input style="height:auto;" type="text" name="templatedescription" id="templatedescription"  placeholder="Description For Reference" value="<?php echo $emailtemplate_desc; ?>">
                        <label>Email Subject</label>
                        <input style="height:auto;" type="text" name="templatesubject" id="templatesubject" placeholder="Email Subject" value="<?php echo $emailtemplate_subject; ?>">
                        <label>Email Body</label>
                        <div class="w-box-content cnt_no_pad">
                          <textarea class="ckeditor" name="wysiwg_editor" id="wysiwg_editor2" cols="30" rows="10"><?php echo $emailtemplate_body; ?></textarea>
                        </div>
                        <div class="w-box-content cnt_no_pad"> Ajax Content for Email Template</div>
                        <br>
                        <!-- <button class="btn btn-beoro-3">Update Email Template</button> -->
                        <input class="btn btn-beoro-3" type="submit" name="submit" value="Update Email Template" />
                        <input type="hidden" name="current_tab" value="tb1_i" />
                      </form>
                    </div>
                    <!-- End Tab i For Email Template -->
                    <!-- Tab for Object Type -->
                    <div id="tb1_j" class="tab-pane">
                      <div class="heading_a">Object Type (For AddressMaster)</div>
                      <div class="formSep span6">
                        <label>Object Type</label>
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Object Name</th>
                              <th>Level</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>1</td>
                              <td>Super Admin</td>
                              <td>1</td>
                            </tr>
                            <tr>
                              <td>2</td>
                              <td>Super Admin - Admin Users</td>
                              <td>1.1</td>
                            </tr>
                            <tr>
                              <td>3</td>
                              <td>Client Admin</td>
                              <td>2</td>
                            </tr>
                            <tr>
                              <td>4</td>
                              <td>Client Admin - Admin Users</td>
                              <td>2.1</td>
                            </tr>
                            <tr>
                              <td>5</td>
                              <td>Users / Subscribers / Participants</td>
                              <td>3</td>
                            </tr>
                            <tr>
                              <td>6</td>
                              <td>Company</td>
                              <td>4</td>
                            </tr>
                            <tr>
                              <td>7</td>
                              <td>Office Address</td>
                              <td>5</td>
                            </tr>
                            <tr>
                              <td>8</td>
                              <td>Group</td>
                              <td>6</td>
                            </tr>
                          </tbody>
                        </table>
                        <br>
                        <br>
                        <span class="help-block help-last">A Unique Type like user, group, company etc. For security reason you can't edit or delete.</span> </div>
                    </div>
                    <!-- End Tab for Object Type -->
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
Current Tab: <?php echo $current_tab; ?><br />
Tab: <?php echo $tab; ?>


<!-- Activate Tab 
$("#"+clickid).addClass("tabheader");
				$("#"+clickid).removeClass("tabheader_noborder");
				
-->
<!--
function loadMessages() {
	$.ajax({
		url : g_hostName + "/messages/getnew",
		dataType : "json",
		success : function(data) {
			if (data.length > 0) {
				////$('#messages').html("");
				$('#messages_new').html("");
				for (row in data) {
					var html = getMessageHtml(data[row]);
					////$('#messages').append(html);
					$('#messages_new').append(html);
				}
			}
		}
	});
}
-->
