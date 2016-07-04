<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$warning ='';
?>
<!-- main content -->
<style>
.tabbable-bordered .nav-tabs > li.active {
	border-top: 5px solid #368CA9;
    margin-top: 0;
    position: relative;
	border-radius:5px;
}

.checkbox.inline { width:350px; margin-right:0px; }
.table-vam th {
	vertical-align:top;
}

#dt_userlist td { vertical-align:top; }

</style>

<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12">
      <div class="w-box w-box-green">
        <div class="w-box-header">
          <h4>Site Settings: Administrator and Roles</h4>
          <i class="icsw16-settings icsw16-white pull-right"></i> </div>
        <div class="w-box-content cnt_a">
          <div class="row-fluid">
            <div class="span12">
              <!--<p class="heading_a">Site Settings: General Settings</p>-->
              <!-- Display Success and Warning -->
			  <div class="alert alert-error" style="display:none;"> <a data-dismiss="alert" class="close">x</a><strong>Warning!</strong> <span class="warningtext"></span></div>
			  <div class="alert alert-success" style="display:none;"><a data-dismiss="alert" class="close">x</a><strong>Success!</strong>  <span class="successtext"></span></div>
			<div id="flashmessages" >
			  <!--
			  <?php if($this->session->userdata('warning')): ?>
			  <?php $warning =$this->session->userdata('warning'); ?>
			  <div class="alert alert-error"> <a data-dismiss="alert" class="close">x</a><strong>Warning!</strong><span class="warningtext"><?php echo $warning; ?></span></div>
			  <?php endif; ?>
			  
			  <?php if($this->session->userdata('success')): ?>
			  <?php $success =$this->session->userdata('success'); ?>
			  <div class="alert alert-success"><a data-dismiss="alert" class="close">x</a><strong>Success!</strong><span class="successtext"><?php echo $success; ?></span></div>
			  <?php endif; ?>
			  <?php $this->session->unset_userdata('warning');?>
			  <?php $this->session->unset_userdata('success');?>
              -->
			  </div>
              <!-- Tab Settings -->
              <div class="row-fluid">
                <!--<div class="span6">-->
                <div class="tabbable tabbable-bordered">
				  
                  <ul class="nav nav-tabs">
                    <li id="tab_a" class="<?php echo (($tab == '' or $tab == 'tb1_a')? 'active' : '') ?> "><a data-toggle="tab" href="#tb1_a">Administrator Role</a></li>
                    <li id="tab_b" class="<?php echo ($tab == 'tb1_b'? 'active' : '') ?>" ><a data-toggle="tab" href="#tb1_b">Assign Permissions</a></li>
                    <li id="tab_c" class="<?php echo ($tab == 'tb1_c'? 'active' : '') ?>"><a data-toggle="tab" href="#tb1_c">Set Permissions To Users</a></li>
					<li id="tab_d" class="<?php echo ($tab == 'tb1_d'? 'active' : '') ?>"><a data-toggle="tab" href="#tb1_d">Set Customise Role To Users</a></li>
					<li id="tab_e" class="<?php echo ($tab == 'tb1_e'? 'active' : '') ?>"><a data-toggle="tab" href="#tb1_e">Set Users To Module Role</a></li>
					<li id="tab_f" class="<?php echo ($tab == 'tb1_f'? 'active' : '') ?>"><a data-toggle="tab" href="#tb1_f">Set Users To Roles</a></li>
                    
                  </ul>
                  <div class="tab-content">
                    <div id="tb1_a" class="tab-pane <?php echo (($tab == '' or $tab == 'tb1_a') ? 'active' : '') ?>">
                     <!-- New Admin Role -->
					 <div id="tb1_h" class="tab-pane active"> <br>
					 	<div id="frm_newadminrole">
                        <p class="heading_a">New Administrator Role</p>
                        <label>Administrator Role Name</label>
                        <input type="text" name="adminrolename" id="adminrolename" placeholder="New Administrator Role Name" class="span4">
                        <br>
                        <button id="newadminrole" class="btn btn-beoro-3">Save</button>
						</div>
						
						<div id="frm_editadminrole" style="display:none;">
                        <p class="heading_a">Edit Administrator Role Name</p>
                        <label>Edit Role Name</label>
                        <input type="hidden" name="roleid" id="roleid" value="">
						<input type="text" name="adminrolename_edit" id="adminrolename_edit" placeholder="New Administrator Role Name" class="span4">
                        <br>
                        <button id="editadminrole" class="btn btn-beoro-3">Update</button>
						<button id="canceladminrole" class="btn btn-beoro-3">Cancel</button>
						</div>
                        <br>
                        <br>
                        <p class="heading_a">Administrator Role List</p>
                        <!-- Admin Role List -->
                        <div class="w-box w-box-orange">
                          <div class="w-box-header">
                            <h4>Administrator role list</h4>
                          </div>
                          <div class="w-box-content">
                            <table id="dt_colVis_Reorder_adminrole" class="table table-striped table-condensed">
                              <thead>
                                <tr>
                                  <th>id</th>
                                  <th>Admin Role</th>
                                  <!-- <th>Status</th> -->
                                  <th>Date Added</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>1</td>
                                  <td >Full Administrator</td>
                                  <!-- <td>Active</td> -->
                                  <td>24/04/2012</td>
                                  <td><div class="btn-group"> <a href="add_client.php?id=1" class="btn btn-mini" title="Edit"><i class="icon-pencil"></i></a> <a href="clientinfo.php" class="btn btn-mini" title="View"><i class="icon-eye-open"></i></a> <a href="#" class="btn btn-mini" title="Suspend/Pause"><i class="icsw16-acces-denied-sign"></i></a> </div></td>
                                </tr>
                                
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <!-- End List -->
                        <br>
                        <br>
						
                      </div>
					 
					 <!-- End New Admin Role --> 
                    </div>
                    
					<!-- Tab B -->
					<?php
						$arrPages = $arrPollPages = array();
					?>
					<div id="tb1_b" class="tab-pane">
						<form id="frm_tab_b" name="frm_tab_b" method="post" >
                        <p class="heading_a">Set Permissions</p>
                        <label>Select Administrator</label>
                        <select id="adminrolelist" name="adminrolelist" class="span4">
                          <option value="-1">-- Select --</option>
                        </select>
                        <div class="formSep">
                          <p class="heading_a">Module: (Based on Module Install)</p>
                          <!-- <p><strong>Available Roles</strong> <a href="javascript:void(0);" class="selectall" >Select All</a></p> -->
                          <div id="modulelist" >
                            <!-- Display Module List -->
                          </div>
                        </div>
						
						</form>
						<button id="updateuserrole" class="btn btn-beoro-3">Update</button>
                      </div>
					<!-- End Tab B -->
					
					<!-- Tab C -->
					<?php
						$arrPages = $arrPollPages = array();
					?>
					<div id="tb1_c" class="tab-pane">
						<form id="frm_tab_c" name="frm_tab_c" method="post" >
                        <!-- <p class="heading_a">Set Permissions (Userwise)</p> -->
						<p class="heading_a">Multiple Users - Roll Assign</p>
							<div class="w-box-header">Registered Users List
                                <div class="btn-group">
                                    <!-- <a href="#" class="btn btn-inverse btn-mini delete_rows_dt" data-tableid="dt_gal" title="Update">Update</a> -->
                                    <!-- <a href="#" class="btn btn-inverse btn-mini" title="View">Another Action</a>-->
                                </div>
                            </div>
						<div class="w-box-content">
								<table class="table table-vam table-striped" id="dt_userlist">
								<thead>
								<tr>
								<th valign="top" class="table_checkbox" style="width:13px"><input type="checkbox" name="select_rows2" class="select_rows2" data-tableid="dt_userlist" /></th>
								<th width="150" valign="top">User Name</th>
								<th width="150" valign="top">User Login</th>
								<th width="150" valign="top">DOB</th>
								<th width="50" valign="top">Status</th>
								<!-- <th valign="top">Access Permissions</th> -->
								</tr>
								</thead>
								<tbody>
									
								</tbody>
						  </table>
								
                          </div>
						
						
                        <label>Select Role</label>
                        <select id="adminrolelist2" name="adminrolelist2" class="span4"></select>
						<label>Select Module</label>
                        <select id="modulelist_tabc" name="modulelist_tabc" class="span4"></select>
						
						</form>
						<button id="updatemultipleuserrole" class="btn btn-beoro-3">Update User Permissions</button>
                      </div>
					<!-- End Tab C -->
					
					<!-- Tab D : Module to User -->
					<div id="tb1_d" class="tab-pane">
						<form id="frm_tab_d" name="frm_tab_d" method="post" >
                        <!-- <p class="heading_a">Set Permissions (Userwise)</p> -->
						<p class="heading_a">Module to User</p>
						
						
                        <label>Select User</label>
                        <select id="userlist_tabd" name="userlist_tabd" class="span4"></select>
						
						<div id="module_result_tabd" style="padding-left:20px;">Module Result</div>
						
						</form>
						<button id="updatemoduletouser" class="btn btn-beoro-3">Update User Permissions</button>
                      </div>
					<!-- End Tab D : Module to User -->
					
					
					<!-- Tab E : Users to Module Role -->
					<div id="tb1_e" class="tab-pane">
						<form id="frm_tab_e" name="frm_tab_e" method="post" >
                        <!-- <p class="heading_a">Set Permissions (Userwise)</p> -->
						<p class="heading_a">Users to Module Role</p>
						
						
                        <label>Select User</label>
                        <select id="userlist_tabe" name="userlist_tabe" class="span4">
                          
                        </select>
						
						<div id="module_result_tabe" style="padding-left:20px;">Module Result</div>
						
						</form>
						<p>If you select all roles as "Dont Apply" and update i.e. "User will lose all permissions from all modules."</p>
						<button id="updateuserstomodule" class="btn btn-beoro-3">Update User Permissions</button>
                      </div>
					<!-- End Tab E : Module to User -->
					
					<!-- Tab F : Users to Module Role -->
					<div id="tb1_f" class="tab-pane">
						<form id="frm_tab_f" name="frm_tab_f" method="post" >
                        <!-- <p class="heading_a">Set Permissions (Userwise)</p> -->
						<p class="heading_a">Module Users to Role</p>
                        
						<label>Select Module</label>
                        <select id="modulelist_tabf" name="modulelist_tabf" class="span4"></select>
						
						<div id="usersto_userrole_tabf" style="padding-left:20px;">Module Result</div>
						
						</form>
						<p>Please select "Skip This" to ignore.</p>
						<button id="updateuserrole_tabf" class="btn btn-beoro-3">Update User Permissions</button>
                      </div>
					<!-- End Tab F : Module to User -->
					
					
					
					
					
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
<script type="text/javascript" >
hide_message('flashmessages');
</script>
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
