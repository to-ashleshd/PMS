<div class="w-box w-box-orange">
  <div class="w-box-header">
    <h4>Business  List
      <input id="shownewform" name="newtemplate" type="button" class="btn btn-mini btn-inverse" style="height:22px;" value="New Business" />
    </h4>
  </div>
  <div class="w-box-content" id="business_list">
    <!-- New List -->
    <?php echo $business_list; ?>
	
	
    <!-- End New List -->
  </div>
  <div id="new_business" class="span6">
    <form name="frm_announcement" method="post" id="frm_announcement" >
      <input type="hidden" name="business_id" id="business_id" value="0" />
      <div class="formSep"> <span class="span4 req">Business Name:</span>
        <input name="business_subject" type="text" id="business_subject" value="" maxlength="200">
      </div>
	  <!--
      <div class="formSep"> <span class="span4 req">Announcement Details</span>
        <textarea name="business_desc" rows="5" id="business_desc"></textarea>
      </div>
	  -->
      <div class="formSep"> <span class="span4">&nbsp;</span>
        <input type="button" name="submit" value="Save" id="submit_ans" class="btn btn-beoro-3">
        <input type="reset" name="reset" value="Cancel" id="reset_ans" class="btn btn-beoro-3" >
      </div>
    </form>
  </div>
</div>
