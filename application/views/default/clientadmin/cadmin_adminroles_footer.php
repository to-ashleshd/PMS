<div class="footer_space"></div>
</div> 

<!-- footer --> 
<footer>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span4">
                <div>&copy; <?php echo $site_name; ?> <?php echo date("Y"); ?></div>
            </div>
            <div class="span4">
                <ul class="unstyled">
                    <li><a href="<?php echo site_url("clientadmin/dashboard"); ?>">Home</a></li>
                    <li>&middot;</li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
			<div class="span4">
				<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
            </div>
        </div>
    </div>
</footer>

<!-- Common JS -->
<!-- jQuery framework -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/jquery.min.js"></script>
<!-- bootstrap Framework plugins -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/bootstrap/js/bootstrap.min.js"></script>
<!-- top menu -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/jquery.fademenu.js"></script>
<!-- top mobile menu -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/selectnav.min.js"></script>
<!-- actual width/height of hidden DOM elements -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/jquery.actual.min.js"></script>
<!-- jquery easing animations -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/jquery.easing.1.3.min.js"></script>
<!-- power tooltips -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/powertip/jquery.powertip-1.1.0.min.js"></script>
<!-- date library -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/moment.min.js"></script>
<!-- common functions -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/beoro_common.js"></script>

<!-- switch buttons -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/ibutton/js/jquery.ibutton.beoro.min.js"></script>
<!-- enchanced select box, tag handler -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/select2/select2.min.js"></script>

<script src="<?php echo base_url("assets/clientadmin"); ?>/js/pages/beoro_settings.js"></script>



<!-- Data Table -->
<!-- datatables -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/datatables/js/jquery.dataTables.min.js"></script>
<!-- datatables column reorder -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/datatables/extras/ColReorder/media/js/ColReorder.min.js"></script>
<!-- datatables column toggle visibility -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/datatables/extras/ColVis/media/js/ColVis.min.js"></script>
<!-- datatables bootstrap integration -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/datatables/js/jquery.dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/pages/beoro_datatables.js"></script>

<!-- Forms -->
<!-- jQuery UI -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/jquery-ui/jquery-ui-1.9.2.custom.min.js"></script>
<!-- touch event support for jQuery UI -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/jquery-ui/jquery.ui.touch-punch.min.js"></script>
<!-- progressbar animations -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/form/jquery.progressbar.anim.min.js"></script>
<!-- 2col multiselect -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/multi-select/js/jquery.multi-select.min.js"></script>
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/multi-select/js/jquery.quicksearch.min.js"></script>
<!-- combobox -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/form/fuelux.combobox.min.js"></script>
<!-- file upload widget -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/form/bootstrap-fileupload.min.js"></script>
<!-- masked inputs -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/jquery-inputmask/jquery.inputmask.min.js"></script>
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/jquery-inputmask/jquery.inputmask.extensions.js"></script>
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/jquery-inputmask/jquery.inputmask.date.extensions.js"></script>
<!-- enchanced select box, tag handler -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/select2/select2.min.js"></script>
<!-- password strength metter -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/pwdMeter/jquery.pwdMeter.min.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- timepicker -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<!-- colorpicker -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- metadata -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/ibutton/js/jquery.metadata.min.js"></script>
<!-- switch buttons -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/ibutton/js/jquery.ibutton.beoro.min.js"></script>
<!-- autosize textarea -->
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/form/jquery.autosize.min.js"></script>

<!-- plupload and the jQuery queue widget -->
<script type="text/javascript" src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/plupload/js/plupload.full.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>


<script src="<?php echo base_url("assets/clientadmin"); ?>/js/pages/beoro_form_elements.js"></script>
<script src="<?php echo base_url("assets/clientadmin"); ?>/js/jquery.livequery.js"></script>

<script type="text/javascript">
    var g_hostName = '<?php echo site_url(); ?>';
	$(document).ready(function() {
	
	/*******************************************
	********* Tab A - Administrator Role **********
	*******************************************/	
		if($('#dt_colVis_Reorder_adminrole').length) {
            $('#dt_colVis_Reorder_adminrole').dataTable({
                "sPaginationType": "bootstrap",
                "sDom": "R<'dt-top-row'Clf>r<'dt-wrapper't><'dt-row dt-bottom-row'<'row-fluid'ip>",
                "fnInitComplete": function(oSettings, json) {
                    $('.ColVis_Button').addClass('btn btn-mini btn-inverse').html('Columns');
                }
            });
        }
		
		
		
		
		//Delete Role
		
		$('.deleterole').livequery("click", function(e){
			
			var yesno = confirm('Are you sure to delete this role?');
			if( yesno ) {
				var roleid = $(this).attr('id');
				
				var url = '<?php echo site_url("ajaxadminroles/deleteadminrole"); ?>';
				$.ajax({
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
						roleid:roleid
    		         },
					success: function(response) {
						alert(response.result);
						
						//Refresh list
						refreshadminrolelist();						
					}	
    			});
				
				
			}
			else {
				alert('Cancel');
			}
			
			
		});
		
		
	
		//New Admin Role
		$("#newadminrole").click( function() {
			var newrole = $("#adminrolename").val();
			if( newrole == '' ) {
				$(".alert-error").show();
				$(".warningtext").html('Please enter user role');
				//alert('Please enter user role');
			}
			else {
				//add to database
				//Ajaxadminroles
				var url = '<?php echo site_url("ajaxadminroles/newadminrole"); ?>';
				$.ajax({
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
						newrole: newrole
    		         },
					success: function(response) {
						if( response.result == 'exists' ) {
							//alert('Rolename is already exists');
							$(".alert-error").show();
							$(".warningtext").html('Rolename is already exists');
						}
						else {
							$(".alert-success").show();
							$(".successtext").html('New rolename is added Successfully.');
							//alert('New rolename is added Successfully.') ;
							
							//Clear the rolename
							$("#adminrolename").val('');
							
							//Refresh list
							refreshadminrolelist();
							
						}
						
					}	
    			});
			}
		});
		
		//Update Admin Role
		$("#editadminrole").click( function() {
			
			var updrolename = $("#adminrolename_edit").val();
			var roleid = $("#roleid").val();
			if( updrolename == '' ) {
				$(".alert-error").show();
				$(".warningtext").html('Please enter user role');
				//alert('Please enter user role');
			}
			else {
				//add to database
				//Ajaxadminroles
				var url = '<?php echo site_url("ajaxadminroles/updateadminrole"); ?>';
				$.ajax({
					url: url,
					dataType: 'json',
					type: 'POST',
					data: {
						updrolename: updrolename,
						roleid:roleid
    		         },
					success: function(response) {
						if( response.result == 'exists' ) {
							//alert('Rolename is already exists');
							$(".alert-error").show();
							$(".warningtext").html('Rolename is already exists');
						}
						else {
							$(".alert-success").show();
							$(".successtext").html('Rolename is updated Successfully.');
							//alert('Rolename is updated Successfully.') ;
							
							//Clear the rolename
							$("#adminrolename").val('');
							
							//Refresh list
							refreshadminrolelist();
							
						}
						
					}	
    			});
			}
		});
		
		
		//Refresh Adminrole list
		function refreshadminrolelist()
		{
			//getListAll
			var url = '<?php echo site_url("ajaxadminroles/getlistall"); ?>';
			var id = 1;
				$.ajax({
					url: url,
					type: 'POST',
					data: {
						id: id
    		         },
					 beforeSend: function(){
					 	$("#dt_colVis_Reorder_adminrole").html('Loading...');

					},
					success: function(response) {
						//alert(response);
						$("#dt_colVis_Reorder_adminrole").html(response);
					}	
    			});		
		}
		
		//Refresh Datatables
		function refreshdatatables()
		{
			if($('#dt_colVis_Reorder_adminrole').length) {
            $('#dt_colVis_Reorder_adminrole').dataTable({
                "bRetrieve":"true",
				"sPaginationType": "bootstrap",				
                "sDom": "R<'dt-top-row'Clf>r<'dt-wrapper't><'dt-row dt-bottom-row'<'row-fluid'ip>",
                "fnInitComplete": function(oSettings, json) {
                    $('.ColVis_Button').addClass('btn btn-mini btn-inverse').html('Columns');
                }
            });
        	}
		
		}
		
		//Edit role name
		/**
		function editrolename(roleid)
		{
			//Hide new Block
			$("#frm_newadminrole").hide();
			$("#frm_editadminrole").show();
			
			//Show Edit box
			var rolename = $("rolename_"+roleid).html();
			alert('Edit ' + rolename );			
		}
		**/
		
		//Edit role Name
		$('.editrole').livequery("click", function(e){
			//alert('Edit role');
			//Show Boxes
			$("#frm_newadminrole").hide();
			$("#frm_editadminrole").show();
			//Reset fields
			$("#roleid").val('0');
			$("#adminrolename_edit").val('');
			
						
			var roleid = $(this).attr('id');
			var rolename = $("#rolename_" + roleid).html();
			//alert('Role id ' + roleid + ' rolename ' + rolename);
			$("#roleid").val(roleid);
			$("#adminrolename_edit").val(rolename);
			
		});
		
		//Cancel Button
		$("#canceladminrole").click( function() {
			$("#frm_editadminrole").hide();
			$("#frm_newadminrole").show();		
		});
		
	//Default load
	refreshadminrolelist();
	refreshdatatables();
		
	/*******************************************
	********* Tab B - Set Permissions **********
	*******************************************/
	$("#tab_b").click( function() {
		//alert('Click B');
		//Update Combo
		$("#adminrolelist").empty();
		var url = '<?php echo site_url("ajaxadminroles/getlistoptions"); ?>';
			var id = 1;
				$.ajax({
					url: url,
					type: 'POST',
					data: {
						id: id
    		         },
					 beforeSend: function(){
					 	//$("#dt_colVis_Reorder_adminrole").html('Loading...');

					},
					success: function(response) {
						//alert(response);
						$("#adminrolelist").append(response);
						$("#modulelist").html('');
						
					}	
    			});				
		
	});
	
	//Populate items based on role
	$("#adminrolelist").change(function() {
		
		var selectedrole = $("#adminrolelist").val();
		//alert('Value ' + selectedrole ); 
		//Clear if select none
		if( selectedrole == - 1 ) {
			$("#modulelist").html('');
			return false;
		}
		var url = '<?php echo site_url("ajaxadminroles/getlistmodules"); ?>';
		var id = 1;
		$.ajax({
			url: url,
			type: 'POST',
			data: {
				selectedrole: selectedrole
			 },
			 beforeSend: function(){
				//$("#dt_colVis_Reorder_adminrole").html('Loading...');

			},
			success: function(response) {
				//alert(response);
				$("#modulelist").html(response);
				
			}	
		});
		
	});
	
	//Checked all items
	//checked all 
	function selectallmodules()
	{
		$('#modulelist').find(':checkbox').each(function(){
			$(this).attr('checked', true);
		});
	}
	
	//Submit Form
	$("#updateuserrole").click( function() {
		//alert('Form submit');
		var url = '<?php echo site_url("ajaxadminroles/updateuserrole"); ?>';
		var id = 1;
		var formData = $("#frm_tab_b").serialize();
		var adminrolelist = $("#adminrolelist").val();
		//$('#frm_tab_b').serialize()
		//{ adminrolelist:adminrolelist, moduleinfo:formData }
		//alert('Form data ' + adminrolelist );
		$.ajax({
			url: url,
			type: 'POST',
			data: $('#frm_tab_b').serialize(),
			 beforeSend: function(){
				//$("#dt_colVis_Reorder_adminrole").html('Loading...');
			},
			success: function(response) {
				//alert(response);
				//$("#modulelist").html(response);
				$(".alert-success").show();
				$(".successtext").html('Permissions are updated Successfully.');
				
			}	
		});
	});
	
	/**
	$('#frm_tab_b').live('submit',function(e){
      
      alert($(this).serialize());
	  e.preventDefault();
	});
	**/
	
	
	//Clear Items
	$(".selectall").click( function() {
		//$("#adminrolelist").empty();
		
		//var items = '<option>Item 1</option><option>Item 2</option><option>Item 3</option>';
		//$("#adminrolelist").append(items);
		
		$('#modulelist').find(':checkbox').each(function(){
			$(this).attr('checked', true);
		});
	});
	
	/*******************************************
	********* Tab C - Set Permissions userwise **********
	*******************************************/
	
	$('.select_rows2').click(function () {
			var tableid = $(this).data('tableid');
			$('#'+tableid).find('input[class=row_sel]').attr('checked', this.checked);
	});
	
	$("#tab_c").click( function() {
		//alert('Click C');
		$("#adminrolelist").empty();
		var url = '<?php echo site_url("ajaxadminroles/getlistusersforpermissions"); ?>';
			var id = 1;
			$.ajax({
				url: url,
				type: 'POST',
				data: {
					id: id
				 },
				 beforeSend: function(){
					//$("#dt_colVis_Reorder_adminrole").html('Loading...');

				},
				success: function(response) {
					//alert(response);
					$("#dt_userlist > tbody").html(response);
					//Refresh List
					getmodulecorenamelist_tabc();
				}	
			});				
			
		//Update Adminrole Combo
		$("#adminrolelist2").empty();
		var url = '<?php echo site_url("ajaxadminroles/getlistoptions"); ?>';
		var id = 1;
		var listall = 1 ;
		$.ajax({
			url: url,
			type: 'POST',
			data: {
				id: id,
				listall:listall
			 },
			 beforeSend: function(){
				//$("#dt_colVis_Reorder_adminrole").html('Loading...');

			},
			success: function(response) {
				//alert(response);
				$("#adminrolelist2").append(response);
				
			}	
		});					
	
	});
	
	//Display Module List TAB C
	function getmodulecorenamelist_tabc()
	{
		//Get Module core name list for Tab F
		$("#modulelist_tabc").empty();
		
		var url = '<?php echo site_url("ajaxadminroles/getmodules_tabf"); ?>';
		var id = 1;
		$.ajax({
			url: url,
			type: 'POST',
			data: {id:id},
			 beforeSend: function(){
				//$("#dt_colVis_Reorder_adminrole").html('Loading...');
			},
			success: function(response) {
				//alert(response);
				$("#modulelist_tabc").append(response);
				//Refresh List
				
			}	
		});
		
	}
	
	
	//Apply Admin Role to users
	$("#updatemultipleuserrole").click( function() {
		var url = '<?php echo site_url("ajaxadminroles/updateusertomodules"); ?>';
		var adminrolelist2 = $("#adminrolelist2").val();
		var n = $( "input:checked" ).length;

		if( adminrolelist2 == -1 ) {
			//prompt to select Admin
			alert('Please select admin role');
		}
		else {
		
			var formData = $("#frm_tab_c").serialize();
			//alert('Form Data: ' + formData );
			//alert('Form data ' + adminrolelist );
			$.ajax({
				url: url,
				type: 'POST',
				data: formData ,
				 beforeSend: function(){
					//$("#dt_colVis_Reorder_adminrole").html('Loading...');
				},
				success: function(response) {
					//alert(response);
					//$("#modulelist").html(response);
					$(".alert-success").show();
					$(".successtext").html('Permissions are updated Successfully.');
					//refresh list
						$("#adminrolelist").empty();
						var url = '<?php echo site_url("ajaxadminroles/getlistusersforpermissions"); ?>';
						var id = 1;
						$.ajax({
							url: url,
							type: 'POST',
							data: {
								id: id
							 },
							 beforeSend: function(){
								//$("#dt_colVis_Reorder_adminrole").html('Loading...');
			
							},
							success: function(response) {
								//alert(response);
								$("#dt_userlist > tbody").html(response);
								//Refresh List
							}	
						});	
					
					//End refresh list
					
				}	
			});
		}
		
	});


/*******************************************
********* Tab D - Module to User **********
*******************************************/

	$("#tab_d").click( function() {
		$("#userlist_tabd").empty();
		var url = '<?php echo site_url("ajaxadminroles/getlistusersdropdown"); ?>';
			var id = 1;
			$.ajax({
				url: url,
				type: 'POST',
				data: {
					id: id
				 },
				 beforeSend: function(){
					//$("#dt_colVis_Reorder_adminrole").html('Loading...');
				},
				success: function(response) {
					//alert(response);
					$("#userlist_tabd").append(response);
					//Refresh List
				}	
			});				
		
		//display Module wise
		//update_module_result();
		/**
		var url = '<?php echo site_url("ajaxadminroles/showlistmodulewise"); ?>';
			var id = 1;
			$.ajax({
				url: url,
				type: 'POST',
				data: {
					id: id
				 },
				 beforeSend: function(){
					//$("#dt_colVis_Reorder_adminrole").html('Loading...');
				},
				success: function(response) {
					//alert(response);
					$("#module_result_tabd").html(response);
					//Refresh List
				}	
			});
		**/	
		
			
		
	});	
	
	$("#userlist_tabd").change( function() {
		update_module_result();
	});
	
	function update_module_result()
	{
		//display Module wise
		var url = '<?php echo site_url("ajaxadminroles/showlistmodulewise"); ?>';
		var user_id = $("#userlist_tabd").val();
		
		$.ajax({
			url: url,
			type: 'POST',
			data: {
				data: $('#frm_tab_b').serialize(),
				user_id: user_id
			 },
			 beforeSend: function(){
				//$("#dt_colVis_Reorder_adminrole").html('Loading...');
			},
			success: function(response) {
				//alert(response);
				$("#module_result_tabd").html(response);
				//Refresh List
			}	
		});
		
	
	}
	
	$("#updatemoduletouser").click( function() {
		//alert('update rold');
		//var formData = $("#frm_tab_d").serialize();
		var user_id = $("#userlist_tabd").val();
		
		if( user_id == -1 ) {
			alert('Please select user first.');
			return false;
		}
		
		//alert('User ID: ' + user_id );
		//alert('Form Data: ' + formData);
		var url = '<?php echo site_url("ajaxadminroles/updateuserrolemodulewise"); ?>';
		$.ajax({
			url: url,
			type: 'POST',
			data: $('#frm_tab_d').serialize(),
			 beforeSend: function(){
				//$("#dt_colVis_Reorder_adminrole").html('Loading...');
			},
			success: function(response) {
				//Refresh List
				update_module_result();
				$(".alert-success").show();
				$(".successtext").html('Permissions are updated Successfully.');
				
			}	
		});
	});

/*******************************************
********* Tab E - Users to Module Role **********
*******************************************/
	$("#tab_e").click( function() {
		$("#userlist_tabe").empty();
		var url = '<?php echo site_url("ajaxadminroles/getlistusersdropdown"); ?>';
			var id = 1;
			$.ajax({
				url: url,
				type: 'POST',
				data: {
					id: id
				 },
				 beforeSend: function(){
					//$("#dt_colVis_Reorder_adminrole").html('Loading...');
				},
				success: function(response) {
					//alert(response);
					$("#userlist_tabe").append(response);
					//Refresh List
					module_to_role_display();
				}	
			});				
		
	});	
	
	
	function module_to_role_display()
	{
			var url = '<?php echo site_url("ajaxadminroles/module_to_role_display"); ?>';
			var id = 1;
			$.ajax({
				url: url,
				type: 'POST',
				data: {
					id: id
				 },
				 beforeSend: function(){
					//$("#dt_colVis_Reorder_adminrole").html('Loading...');
				},
				success: function(response) {
					//alert(response);
					$("#module_result_tabe").html(response);
					//Refresh List
				}	
			});
	
	}
	
	
	$("#updateuserstomodule").click(function() {
		//Update Setting
		var formData = $("#frm_tab_e").serialize();
		var selected_user = $("#userlist_tabe").val();
		if( selected_user == -1 ) {
			//prompt to select Admin
			alert('Please select user first');
			return false;
		}
		
		//alert(formData);
		//usermodulerole
		var url = '<?php echo site_url("ajaxadminroles/usermodulerole"); ?>';
			var id = 1;
			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				 beforeSend: function(){
					//$("#dt_colVis_Reorder_adminrole").html('Loading...');
				},
				success: function(response) {
					//alert('Set User to module role');
					//$("#module_result_tabe").html(response);
					//Refresh List
					$(".alert-success").show();
					$(".successtext").html('Permissions are updated Successfully.');
				}	
			});
		
	});


/*******************************************
********* Tab F - Users to Role **********
*******************************************/
	$("#tab_f").click( function() {
		$("#userlist_tabe").empty();
		var url = '<?php echo site_url("ajaxadminroles/usersto_userrole"); ?>';
			var id = 1;
			$.ajax({
				url: url,
				type: 'POST',
				data: {
					id: id
				 },
				 beforeSend: function(){
					//$("#dt_colVis_Reorder_adminrole").html('Loading...');
				},
				success: function(response) {
					//alert(response);
					$("#usersto_userrole_tabf").html(response);
					
					//Get Module List
					getmodulecorenamelist();
					
					//module_to_role_display();
				}	
			});				
		
	});	
	
	function getmodulecorenamelist()
	{
		//Get Module core name list for Tab F
		$("#modulelist_tabf").empty();
		
		var url = '<?php echo site_url("ajaxadminroles/getmodules_tabf"); ?>';
		var id = 1;
		$.ajax({
			url: url,
			type: 'POST',
			data: {id:id},
			 beforeSend: function(){
				//$("#dt_colVis_Reorder_adminrole").html('Loading...');
			},
			success: function(response) {
				//alert(response);
				$("#modulelist_tabf").append(response);
				//Refresh List
				
			}	
		});
		
	}
	
	
	$("#updateuserrole_tabf").click(function() {
		var formData = $("#frm_tab_f").serialize();
		
		//alert(formData);
		//usermodulerole
		var url = '<?php echo site_url("ajaxadminroles/update_usersto_userrole"); ?>';
			var id = 1;
			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				 beforeSend: function(){
					//$("#dt_colVis_Reorder_adminrole").html('Loading...');
				},
				success: function(response) {
					//alert(response);
					//$("#module_result_tabe").html(response);
					//Refresh List
					$(".alert-success").show();
					$(".successtext").html('Permissions are updated Successfully.');
				}	
			});
	
	});
	
	

//End document
	});	
</script>


<script  type="text/javascript">
/** Common Functions **/

	function checkedall(divname)
	{
		$("#" + divname ).find(':checkbox').each(function(){
			$(this).attr('checked', true);
		});
	}
	
	function uncheckedall(divname)
	{
		$("#" + divname ).find(':checkbox').each(function(){
			$(this).attr('checked', false);
		});
	}


function new_emailvalidater(email)
{
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if(email.match(emailExp)){
		return true;
	}
	else{
		return false;
	}
}

function new_isnumeric(number)
{
	var alphaExp = /^[0-9]+$/;
			
	if(number.match(alphaExp))
	{
		return true;
	} else{
		return false;
	}
			
}


function call_chk_my_kra_group(id)
{
		if ($('#'+id).is(":checked"))
		{
			//$('#pms_my_kra input')
			$("#pms_my_kra input:checkbox").attr("checked" ,true);
		
		}
		else
		{
			$("#pms_my_kra input:checkbox").attr("checked" ,false);
		}
}

</script>

<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
<script type="text/javascript" >
function hide_message(id)
	{
		setTimeout(function(){ $("#"+id).html(''); }, 3000);
	}

</script>
</body>
</html>