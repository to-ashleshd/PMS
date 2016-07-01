<div class="formSep"><label class="span3">Select Country</label>
<?php $cntry_id =''; if(isset($update_company_master['countrymaster_id'])) { $cntry_id = $update_company_master['countrymaster_id']; } else { $cntry_id =''; } 
$ste_id =''; if(isset($update_company_master['statemaster_id'])) { $ste_id = $update_company_master['statemaster_id']; } else { $ste_id =''; } 
$cty_id =''; if(isset($update_company_master['citymaster_id'])) { $cty_id = $update_company_master['citymaster_id']; } else { $cty_id =''; } 

?>
<select id="country_company" name="country_company" class="span3"  onchange="call_generalstate('country_company','state_company')">

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
<div class="formSep"><label class="span3">Select State</label>
<select id="state_company" name="state_company" class="span3" onblur="calldisabled(this.value)" onchange="call_generalcity('country_company','state_company','city_company')">
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

<input class="span3" type="text" name="otherstate" id="otherstate" placeholder="Other State"  <?php echo ($ste_id != ''? 'disabled="disabled"' : '') ?>>
</div>



<div class="formSep"><label class="span3">Select City</label>
<select id="city_company" name="city_company" class="span3" onblur="calldisabledothercity(this.value)">

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

<input class="span3" type="text" name="othercity" id="othercity" placeholder="Other City" <?php echo ($cty_id != ''? 'disabled="disabled"' : '') ?> ></div>

<div class="formSep">
<label class="req span3">Address 1</label>
<input type="text" name="address1" id="address1" placeholder="Address 1" value="<?php if(isset($update_company_master['address_1'])) { echo $update_company_master['address_1']; }?>">
</div>
<div class="formSep">
<label class="req span3">Plot no./Office No.</label>
<input type="text" name="plot_office_no" id="plot_office_no" placeholder="Plot no./Office No." value="<?php if(isset($update_company_master['plot_office_no'])) { echo $update_company_master['plot_office_no']; }?>">
</div>
<div class="formSep">
<label class="span3">Area/Local/Sector</label>
<input type="text" name="area" id="area" placeholder="Area/Local/Sector" value="<?php if(isset($update_company_master['area'])) { echo $update_company_master['area']; }?>">
</div>
<div class="formSep">
<label class="span3">Street/Road/Lane</label>
<input type="text" name="street" id="street" placeholder="Street/Road/Lane" value="<?php if(isset($update_company_master['street'])) { echo $update_company_master['street']; }?>">
</div>
<div class="formSep">
<label class="span3">Landmark</label>
<input type="text" name="landmak" id="landmark" placeholder="Landmark" value="<?php if(isset($update_company_master['landmak"'])) { echo $update_company_master['landmak"']; }?>">
</div>
<div class="formSep">
<label class="span3">Zipcode</label>
<input type="text" name="zipcode" id="zipcode" placeholder="zipcode" value="<?php if(isset($update_company_master['zipcode'])) { echo $update_company_master['zipcode']; }?>">
</div>
<div class="formSep">
<label class="span3">Mobile</label>
<input type="text" name="mobile" id="mobile" placeholder="Mobile" value="<?php if(isset($update_company_master['mobile_no'])) { echo $update_company_master['mobile_no']; }?>">
</div>
<div class="formSep">
<label class="span3">Fax</label>
<input type="text" name="fax" id="fax" placeholder="Fax No." value="<?php if(isset($update_company_master['fax_no'])) { echo $update_company_master['fax_no']; }?>">
</div>
<br>
<br>