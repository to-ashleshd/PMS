<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajaxadminroles extends CI_Controller {

//konstruktor klasy
    public function __construct() {
        parent::__construct();
        $this->topmenu->no_cache();
    }

    public function index() {
        $this->load->view('users');
    }

    public function newadminrole() {
        $response = array();
        $this->load->model('adminrolesmodel');
        $result = $this->adminrolesmodel->newadminrole($this->input->post('newrole'));
        //print_r($_POST);
        $response['post'] = $_POST;
        $response['result'] = $result;
        die(json_encode($response));
    }

    public function updateadminrole() {
        $response = array();
        $this->db->set_dbprefix('ecore_');
        $this->load->model('adminrolesmodel');
        $roleid = $this->input->post('roleid');
        $updatedrolename = $this->input->post('updrolename');
        $result = $this->adminrolesmodel->updateadminrole($roleid, $updatedrolename);
        //print_r($_POST);
        $response['post'] = $_POST;
        $response['result'] = $result;
        $this->db->set_dbprefix('pms_');
        die(json_encode($response));
    }

    public function deleteadminrole() {
        $response = array();
        $msg = '';
        $this->load->model('adminrolesmodel');
        $roleid = $this->input->post('roleid');
        $this->db->set_dbprefix('ecore_');

        //Check if role is exists or not
        $sql = "SELECT count(*) as howmany 
                FROM " . ECOREPREFIX . "module_to_role 
                WHERE role_id ='" . $roleid . "' ";
        $query = $this->db->query($sql);
        $result = $query->result();
        $row = $query->first_row();
        //print_r($row);
        if ($row->howmany >= 1) {
            $msg = 'Role is already in used. Unable to delete.';
            //Role found can't delte
        } else {
            //Role is deleted successfully
            $msg = 'Role is Deleted successfully.';
            $this->db->delete(ECOREPREFIX . "client_user_role", array('client_user_role_id' => $roleid));
        }

        $response['result'] = $msg;
        //print_r($row);
        //Reset prefix
        $this->db->set_dbprefix('pms_');
        die(json_encode($response));
    }

    function getlistall() {
        $this->load->model('adminrolesmodel');
        $this->load->model('commonmodel');
        $output = '';
        $result = $this->adminrolesmodel->getListAll();
        //Generate list
        //Table Head
        $output .= '<table id="dt_colVis_Reorder_adminrole" class="table table-striped table-condensed">';
        $output .= '<thead>';
        $output .= '<tr>';
        $output .= '<th>id</th>';
        $output .= '<th>Admin Role</th>';
        $output .= '<th>Date Added</th>';
        $output .= '<th>Action</th>';
        $output .= '</tr>';
        $output .= '</thead>';
        $output .= '<tbody>';

        foreach ($result as $key => $val) {
            $s_date_format = $this->commonmodel->get_env_setting('s_date_format');

            $output .= '<tr>';
            $output .= '<td>' . $val->client_user_role_id . '</td>';
            $output .= '<td id="rolename_' . $val->client_user_role_id . '"  >' . $val->rolename . '</td>';
            $output .= '<td>' . date($s_date_format, strtotime($val->date_added)) . '</td>';
            if ($val->client_user_role_id == 1) {
                $output .= '<td>Sysadmin</td>'; //<a href="#" class="btn btn-mini" title="Suspend/Pause"><i class="icsw16-acces-denied-sign"></i></a>
            } else {
                $output .= '<td><div class="btn-group">';
                $output .= '<a href="javascript:void(0);" class="btn btn-mini editrole" id="' . $val->client_user_role_id . '" title="Edit"><i class="icon-pencil"></i></a>';
                $output .= '<a href="javascript:void(0);" class="btn btn-mini deleterole" id="' . $val->client_user_role_id . '" title="Delete"><i class="icsw16-acces-denied-sign"></i></a>';
                $output .= '</div></td>'; //<a href="#" class="btn btn-mini" title="Suspend/Pause"><i class="icsw16-acces-denied-sign"></i></a>
            }
            $output .= '</tr>';
        }
        $output .= '</tbody>';
        $output .= '</table>';

        echo $output;
    }

    function getlistusersforpermissions() {
        $this->load->model('adminrolesmodel');
        $this->load->model('commonmodel');
        $output = '';

        $sql = "SELECT * FROM " . $this->db->dbprefix . "employee ORDER BY fname";
        $query = $this->db->query($sql);
        $result = $query->result();

        //Generate list
        //Table Head

        foreach ($result as $key => $val) {
            $s_date_format = $this->commonmodel->get_env_setting('s_date_format');
            $output .= '<tr>';
            if ($val->login_type == 'admin') {
                $output .= '<td valign="top"> - </td>';
            } else {
                $output .= '<td valign="top"><input type="checkbox" name="user_id_' . $val->pms_employee_id . '" class="row_sel" value="' . $val->pms_employee_id . '" /></td>';
            }
            //$output .= '<td><input type="checkbox" name="user_id_' . $val->user_id . '" class="row_sel" value="' . $val->user_id . '" /></td>';
            $output .= '<td valign="top">' . $val->fname . ' ' . $val->lname . '</td>';
            $output .= '<td valign="top">' . $val->login_name . '</td>';
            $output .= '<td valign="top">' . date($s_date_format, strtotime($val->date_of_birth)) . '</td>';
            if ($val->login_type == 'admin') {
                $output .= '<td valign="top">Sysadmin</td>';
            } else {
                $output .= '<td valign="top">' . ( $val->user_status == 1 ? 'Active' : 'InActive') . '</td>';
            }
            //$output .= '<td valign="top">' . $this->getUserPermissionList($val->user_id) . '</td>';
            $output .= '</tr>';
        }

        echo $output;
    }

    function getUserPermissionList($user_id) {
        $this->db->set_dbprefix('ecore_');
        $sql = "SELECT group_concat(ms.module_role_name) as allowedurl
                FROM " . ECOREPREFIX . "user_acl uacl
                LEFT JOIN " . ECOREPREFIX . "allowed_module_settings ms ON uacl.modulename = ms.id
                WHERE pms_employee_id = '" . $user_id . "' ";
        $query = $this->db->query($sql);
        $result = $query->result();
        $row = $query->first_row();
        $arrList = explode(',', $row->allowedurl);
        $arrAllowList = join(', ', $arrList);

        //print_r($row);
        //Reset prefix
        $this->db->set_dbprefix('pms_');
        return $arrAllowList;
    }

    function getlistoptions() {
        $this->load->model('adminrolesmodel');
        $output = '';
        $result = $this->adminrolesmodel->getListOptions();
        $listall = $this->input->post('listall');
        //Generate list
        //Table Head
        $output .= '<option value="-1">-- Please Select --</option>';
        foreach ($result as $key => $val) {
            //$s_date_format = $this->commonmodel->get_env_setting('s_date_format');
            //Skip for Sysadmin
            if (isset($listall) and $listall == 1) {
                $output .= '<option value="' . $val->client_user_role_id . '">' . $val->rolename . '</option>';
            } else {
                if ($val->client_user_role_id > 1) {
                    $output .= '<option value="' . $val->client_user_role_id . '">' . $val->rolename . '</option>';
                }
            }
        }
        //echo print_r($_POST);

        echo $output;
    }

    function getSelectedModulesByRole($role_id) {
        $this->db->set_dbprefix('ecore_');
        $sql = "SELECT * FROM " . ECOREPREFIX . "module_to_role WHERE role_id='" . $role_id . "' ";
        $query = $this->db->query($sql);
        //Reset prefix
        $this->db->set_dbprefix('pms_');
        return $query->result();
    }

    function getlistmodules() {
        $this->load->model('adminrolesmodel');
        $output = '';
        $result = $this->adminrolesmodel->getListModules();
        //Generate list
        $selectedrole = $this->input->post('selectedrole');

        $preselectedModules = $this->getSelectedModulesByRole($selectedrole);
        $arrIds = array();
        foreach ($preselectedModules as $key => $val) {
            $arrIds[] = $val->module_id;
        }

        //Change Display
        $module_group = $this->getModuleCoreNames();
        $this->db->set_dbprefix('ecore_');

        /**
          foreach ($result as $key => $val) {
          //$s_date_format = $this->commonmodel->get_env_setting('s_date_format');
          $is_checked = '';
          if (in_array($val->id, $arrIds)) {
          $is_checked = ' checked="checked" ';
          }
          $output .= '<label class="checkbox inline">';
          $output .= '<input type="checkbox" name="module_id_' . $val->id . '" id="module_id_' . $val->id . '" value="Y" ' . $is_checked . ' >';
          $output .= $val->module_role_name . '</label>';
          }
         * */
        $output .= '<a href="javascript:void(0);" onclick="javascript:checkedall(\'modulelist\');" >Select All</a>  -  ';
        $output .= '<a href="javascript:void(0);" onclick="javascript:uncheckedall(\'modulelist\');" >Clear All</a><br>';

        foreach ($module_group as $module_key => $module_val) {
            //$module_core_name = $module_val->module_core_name ;

            $module_core_name = $module_val;
            $output .= '<b>Module: ' . $module_val . '<b/><br>';
            //print_r($module_val);
            //Get List for 
            $sql = "SELECT * FROM " . ECOREPREFIX . "allowed_module_settings 
                    WHERE module_core_name ='" . $module_core_name . "' 
                    ORDER BY module_core_name";
            $query_2 = $this->db->query($sql);
            $result_2 = $query_2->result();
            foreach ($result_2 as $key_2 => $val_2) {

                $is_checked = '';
                if (in_array($val_2->id, $arrIds)) {
                    $is_checked = ' checked="checked" ';
                }


                $output .= '<label class="checkbox inline">';
                $output .= '<input type="checkbox" name="module_id_' . $val_2->id . '" id="module_id_' . $val_2->id . '" value="Y" ' . $is_checked . ' >';
                $output .= $val_2->module_role_name . '</label>';
            }
            //Module saparator
            $output .= '<hr>';
        }
        //Reset prefix
        $this->db->set_dbprefix('pms_');

        echo $output;
    }

    function updateuserrole() {
        //Remove all data related to role
        //$adminrolelist = $this->input->post('adminrolelist');
        //Delete all records related to role
        ////$this->db->delete($this->db->dbprefix . "module_to_role", array('role_id' => $adminrolelist));
        //print_r($_REQUEST);
        //print_r(unserialize($_REQUEST));
        //Get - adminrolelist
        //Reset prefix
        $this->db->set_dbprefix('ecore_');
        foreach ($_REQUEST as $key => $val) {
            $isfound = strpos($key, 'adminrolelist');
            if ($isfound !== false) {
                //echo 'adminroleid ' . $_REQUEST[$key] ;
                $adminrole_id = $_REQUEST[$key];
                //Remove 
                $this->db->delete(ECOREPREFIX . "module_to_role", array('role_id' => $adminrole_id));
            }
        }

        foreach ($_REQUEST as $key => $val) {

            $isfound = strpos($key, 'module_id_');
            if ($isfound !== false) {
                //echo '<br>Not found ' . $isfound ;
                $module_id = str_replace('module_id_', '', $key);

                $data = array(
                    'role_id' => $adminrole_id,
                    'module_id' => $module_id,
                );

                $this->db->insert(ECOREPREFIX . "module_to_role", $data);
                //echo $module_id ;
            }
        }
        //Reset prefix
        $this->db->set_dbprefix('pms_');
    }

    function updateusertomodules() {
        //Get Role Name and ID
        $arrIds = array();
        $arrApplyModules = array();
        $this->db->set_dbprefix('ecore_');

        $module_key_name = $_POST['modulelist_tabc'];
        foreach ($_REQUEST as $key => $val) {
            $isfound = strpos($key, 'adminrolelist2');
            if ($isfound !== false) {
                //echo 'adminroleid ' . $_REQUEST[$key] ;
                $adminrole_id = $_REQUEST[$key];
                //echo '<br>Admin role Id ' . $adminrole_id;
                //// New Procedure ////                

                $sql = "SELECT mtor.*, ams.module_unique_code, ams.module_core_name 
                            FROM " . ECOREPREFIX . "module_to_role mtor
                            LEFT JOIN " . ECOREPREFIX . "allowed_module_settings ams ON mtor.module_id = ams.id
                            WHERE role_id = '" . $adminrole_id . "'
                            AND module_core_name = '" . $module_key_name . "' ";
                //echo $sql ;
                $query = $this->db->query($sql);
                $result_filter_role = $query->result();
                //Get filter module id
                //echo '<pre>';
                //print_r($result_filter_role);
                //echo '</pre>';

                foreach ($result_filter_role as $rowkey => $rowval) {
                    //$arrApplyModules[] = $rowval->module_id;
                    $arrIds[] = $rowval->module_id;
                }
                //print_r($arrApplyModules);
                //// End New Procedure ////
                //Get List of all moduls assign to role
                /** Old Method    
                  $preselectedModules = $this->getSelectedModulesByRole($adminrole_id);
                  $arrIds = array();
                  foreach ($preselectedModules as $key => $val) {
                  $arrIds[] = $val->module_id;
                  }
                  print_r($arrIds);
                 * */
            }
        }
        //Get module id for that role name
        //Update all module id to user for all selected users
        //Reset prefix
    
        foreach ($_REQUEST as $key => $val) {

            $isfound = strpos($key, 'user_id_');
            if ($isfound !== false) {
                //echo '<br>Not found ' . $isfound ;
                $user_id = str_replace('user_id_', '', $key);

                //Remove all Existing modules Permissions
                $this->db->delete($this->db->dbprefix . "user_acl", array('user_id' => $user_id));

                //Loop through all available modules
                foreach ($arrIds as $module_id) {
                    //echo '<br>Add to db Module ' . $module_id . ' - ' . $user_id ;

                    $data = array(
                        'modulename' => $module_id,
                        'user_id' => $user_id,
                    );
                    //Add User with module
                    $this->db->insert($this->db->dbprefix . "user_acl", $data);
                }
                //End Loop
            }
        }
            $this->db->set_dbprefix('pms_');
    }

    /** Common for Tab D * */
    function getlistusersdropdown() {
        $this->load->model('adminrolesmodel');
        $this->load->model('commonmodel');
        $output = '';

        $sql = "SELECT * FROM " . $this->db->dbprefix . "employee ORDER BY fname";
        $query = $this->db->query($sql);
        $result = $query->result();

        //Generate list
        $output .= '<option value="-1">-- Please Select --</option>';
        foreach ($result as $key => $val) {

            //Skip Admin as id = 1
            if ($val->pms_employee_id > 1) {
                $output .= '<option value="' . $val->pms_employee_id . '">' . $val->fname . ' ' . $val->lname . '</option>';
            }
        }

        echo $output;
    }

    function getModuleCoreNames() {
        $this->db->set_dbprefix('ecore_');
        $sql = "SELECT module_core_name from " . ECOREPREFIX . "allowed_module_settings group by module_core_name";
        $query = $this->db->query($sql);
        $result = $query->result();
        $output = array();
        foreach ($result as $key => $val) {
            $output[] = $val->module_core_name;
        }
        //Reset prefix
        $this->db->set_dbprefix('pms_');

        return $output;
    }

    function showlistmodulewise() {
        $this->db->set_dbprefix('ecore_');
        $module_group = $this->getModuleCoreNames();
        //print_r($module_group);
        $output = '';
        $user_id = $this->input->post('user_id');

        if ($user_id >= 1) {
            $sql = "SELECT * FROM " . ECOREPREFIX . "user_acl WHERE user_id='" . $user_id . "' ";
            $query = $this->db->query($sql);
            $result_preselect = $query->result();
            $arrIds = array();
            //echo '<pre>';
            foreach ($result_preselect as $key1 => $val1) {
                $arrIds[] = $val1->modulename;
            }
            //print_r($arrIds);
            //echo '</pre>';
            //echo '<pre>';
            //print_r($result_preselect);
            //echo '</pre>';
            $output .= '<a href="javascript:void(0);" onclick="javascript:checkedall(\'module_result_tabd\');" >Select All</a>  -  ';
            $output .= '<a href="javascript:void(0);" onclick="javascript:uncheckedall(\'module_result_tabd\');" >Clear All</a><br>';

            foreach ($module_group as $module_key => $module_val) {
                //$module_core_name = $module_val->module_core_name ;

                $module_core_name = $module_val;
                $module_name = trim($module_val);
                if (strtolower($module_name) == strtolower('PMS - MY KRA')) {
                    $output .= '<div id="pms_my_kra"><b>Module: ' . $module_val . '<b/><br>';
                } else {
                    $output .= '<b>Module: ' . $module_val . '<b/><br>';
                }
                //print_r($module_val);
                //Get List for 
                $sql = "SELECT * FROM " . ECOREPREFIX . "allowed_module_settings 
                    WHERE module_core_name ='" . $module_core_name . "' 
                    ORDER BY module_core_name";
                $query_2 = $this->db->query($sql);
                $result_2 = $query_2->result();
                foreach ($result_2 as $key_2 => $val_2) {

                    $is_checked = '';
                    if (in_array($val_2->id, $arrIds)) {
                        $is_checked = ' checked="checked" ';
                    }


                    $output .= '<label class="checkbox inline">';

                    if (strtolower($module_name) == strtolower('PMS - MY KRA')) {
                        $output .= '<input type="checkbox" name="module_id_' . $val_2->id . '" id="module_id_' . $val_2->id . '" value="Y" ' . $is_checked . ' onclick="call_chk_my_kra_group(this.id)" >';
                    } else {
                        $output .= '<input type="checkbox" name="module_id_' . $val_2->id . '" id="module_id_' . $val_2->id . '" value="Y" ' . $is_checked . ' >';
                    }
                    $output .= $val_2->module_role_name . '</label>';
                }
                //Module saparator
                if (strtolower($module_name) == strtolower('PMS - MY KRA')) {
                    $output .= '</div>';
                }
                $output .= '<hr>';
            }
        }
        //Reset prefix
        $this->db->set_dbprefix('pms_');

        echo $output;
    }

    function updateuserrolemodulewise() {
        //Get User id
        $this->db->set_dbprefix('ecore_');
        foreach ($_POST as $key => $val) {
            $isfound = strpos($key, 'userlist_tabd');
            if ($isfound !== false) {
                $user_id = $_REQUEST[$key];
                //Delete Existing Permissions
                $this->db->delete(ECOREPREFIX . "user_acl", array('user_id' => $user_id));
            }
        }

        //Update User Role 
        foreach ($_POST as $key => $val) {
            $isfound = strpos($key, 'module_id_');
            if ($isfound !== false) {
                $module_id = str_replace('module_id_', '', $key);

                $data = array(
                    'user_id' => $user_id,
                    'modulename' => $module_id,
                );

                $this->db->insert(ECOREPREFIX . "user_acl", $data);
                //echo $module_id ;
            }
        }

        //Reset prefix
        $this->db->set_dbprefix('pms_');
    }

    /** Common for Tab e * */
    function module_to_role_display() {
        $this->db->set_dbprefix('ecore_');
        $output = '';
        $dd_roles = '';
        //Prepare Dropdown for admin role
        $sql = "SELECT * FROM " . ECOREPREFIX . "client_user_role ORDER BY rolename";
        $query = $this->db->query($sql);
        $result_preselect = $query->result();

        $dd_roles .= '<select id="modulegroup_tabe" name="modulegroup_tabe" class="span4">';
        foreach ($result_preselect as $key => $val) {
            $dd_roles .= '<option value="' . $val->client_user_role_id . '">' . $val->rolename . '</option>';
        }
        $dd_roles .= '</select>';

        //module_to_role_display
        $module_group = $this->getModuleCoreNames();
        //Prepare Dropdown for Common Modules
        //$output .= '<select id="modulegroup_tabe" name="modulegroup_tabe" class="span4">';
        foreach ($module_group as $row) {
            $output .= '<div class="formSep">';
            $output .= '<label class="span4" >Module: ' . $row . '</label>';
            //$output .= 'Module: ' . $row . '<br>';
            //$output .= $dd_roles;
            //Prepare dropdown for roles
            $output .= '<select  name="role_' . $row . '" class="span4">';
            $output .= '<option value="skip">-- Dont Apply --</option>';
            foreach ($result_preselect as $key => $val) {
                $output .= '<option value="' . $val->client_user_role_id . '">' . $val->rolename . '</option>';
            }
            $output .= '</select>';


            $output .= '</div>';
        }

        //Reset prefix
        $this->db->set_dbprefix('pms_');

        echo $output;
    }

    function usermodulerole() {
        //echo '<pre>';
        //print_r($_POST);
        //echo '</pre>';
        $this->db->set_dbprefix('ecore_');
        $arrApplyModules = array();
        //getSelectedModulesByRole
        foreach ($_POST as $key => $val) {
            $isfound = strpos($key, 'role_');

            if ($isfound !== false) {
                $role_id = $_POST[$key];

                //Delete Existing Permissions
                //$this->db->delete($this->db->dbprefix . "user_acl", array('user_id' => $user_id));
                //If Not Skip then get role names
                if ($role_id != 'skip') {
                    //echo '<br>Key: ' . $key;
                    $keyname = str_replace('role_', '', $key);
                    $keyname = str_replace('_', ' ', $keyname);
                    //echo '<br>Keyname: ' . $keyname;
                    //echo '<br>Apply Module: ' . $role_id;
                    //Get Role list 
                    //$role_list = $this->getSelectedModulesByRole($role_id);

                    $sql = "SELECT mtor.*, ams.module_unique_code, ams.module_core_name 
                            FROM " . ECOREPREFIX . "module_to_role mtor
                            LEFT JOIN " . ECOREPREFIX . "allowed_module_settings ams ON mtor.module_id = ams.id
                            WHERE role_id = '" . $role_id . "'
                            AND module_core_name = '" . $keyname . "' ";
                    //echo $sql ;
                    $query = $this->db->query($sql);
                    $result_filter_role = $query->result();
                    //Get filter module id
                    //echo '<pre>';
                    //print_r($result_filter_role);
                    //echo '</pre>';

                    foreach ($result_filter_role as $rowkey => $rowval) {
                        $arrApplyModules[] = $rowval->module_id;
                    }
                }
            }
        }


        //Remove Existing Role for user
        $user_id = $this->input->post('userlist_tabe');
        //Remove all Existing modules Permissions
        $this->db->delete(ECOREPREFIX . "user_acl", array('user_id' => $user_id));
        //Display Apply role
        $arrApplyModules = array_unique($arrApplyModules);
        //print_r($arrApplyModules);

        foreach ($arrApplyModules as $row_module) {
            //echo '<br>Rowmodule ' . $row_module ;
            $data = array(
                'modulename' => $row_module,
                'user_id' => $user_id,
            );
            //Add User with module
            $this->db->insert($this->db->dbprefix . "user_acl", $data);
        }
    }

    /** Common for Tab F * */
    function usersto_userrole() {
        //Get User List - Except Sysadmin
        $output = '';
        $sql = "SELECT * FROM " . $this->db->dbprefix . "employee  WHERE pms_employee_id != 1 ORDER BY fname";
        $query = $this->db->query($sql);
        $result_users = $query->result();

        $userrole_dd = '';

        $this->db->set_dbprefix('ecore_');

        foreach ($result_users as $key => $val) {
            $output .= '<div class="formSep">';
            $output .= '<label class="span4" >User: ' . $val->fname . ' ' . $val->lname . ' (' . $val->login_name . ')</label>';

            $sql = "SELECT * FROM " . ECOREPREFIX . "client_user_role ORDER BY rolename";
            $query = $this->db->query($sql);
            $result_userrole = $query->result();

            $output .= '<select  name="role_user_id_' . $val->pms_employee_id . '" class="span4">';
            $output .= '<option value="skip">-- Skip This --</option>';
            foreach ($result_userrole as $keyrole => $valrole) {
                $output .= '<option value="' . $valrole->client_user_role_id . '">' . $valrole->rolename . '</option>';
            }
            $output .= '</select>';

            $output .= '</div>';
        }

        echo $output;
        //Reset prefix
        $this->db->set_dbprefix('pms_');
    }

    function getmodules_tabf() {
        $output = '';
        $module_group = $this->getModuleCoreNames();
        //$output .= '<select  name="role_user_id_' . $val->user_id . '" class="span4">';
        foreach ($module_group as $row) {
            $output .= '<option value="' . $row . '">' . $row . '</option>';
        }
        //$output .= '</select>';
        echo $output;
    }

    function update_usersto_userrole() {
        //echo '<pre>';
        //print_r($_POST);
        //echo '</pre>';

        $arrApplyModules = array();

        $module_key_name = $this->input->post('modulelist_tabf');
        //echo '<br>Module Group Name: ' . $module_key_name ;
        //getSelectedModulesByRole
        $this->db->set_dbprefix('ecore_');
        foreach ($_POST as $key => $val) {
            $isfound = strpos($key, 'role_user_id_');
            if ($isfound !== false) {
                $role_id = $_POST[$key];

                //If Role is not skip then apply
                if ($role_id != 'skip') {
                    $user_id = str_replace('role_user_id_', '', $key);
                    $role_id = $_POST[$key];
                    //echo '<br>User Id: ' . $user_id;
                    //echo '<br>Apply Role ' . $_POST[$key];
                    //Remove Existing Permissions
                    $this->db->set_dbprefix('ecore_');
                    $this->db->delete(ECOREPREFIX . "user_acl", array('user_id' => $user_id));


                    $preselectedModules = $this->getSelectedModulesByRole($role_id);
                    $arrIds = array();
                    foreach ($preselectedModules as $keymod => $valmod) {
                        $arrIds[] = $valmod->module_id;
                    }



                    $sql = "SELECT mtor.*, ams.module_unique_code, ams.module_core_name 
                            FROM " . ECOREPREFIX . "module_to_role mtor
                            LEFT JOIN " . ECOREPREFIX . "allowed_module_settings ams ON mtor.module_id = ams.id
                            WHERE role_id = '" . $role_id . "'
                            AND module_core_name = '" . $module_key_name . "' ";
                    //echo $sql ;
                    $query = $this->db->query($sql);
                    $result_filter_role = $query->result();
                    //Get filter module id
                    //echo '<pre>';
                    //print_r($result_filter_role);
                    //echo '</pre>';

                    foreach ($result_filter_role as $rowkey => $rowval) {
                        $arrApplyModules[] = $rowval->module_id;
                    }
                    //print_r($arrApplyModules); 
                    //Check / Make for Unique id
                    $arrIds = array_unique($arrApplyModules);

                    foreach ($arrIds as $row_module) {
                        //echo '<br>Rowmodule ' . $row_module ;
                        $this->db->set_dbprefix('ecore_');
                        $data = array(
                            'modulename' => $row_module,
                            'user_id' => $user_id,
                        );
                        //Add User with module

                        $this->db->insert(ECOREPREFIX . "user_acl", $data);
                    }

                    //print_r($arrIds);
                }
            }
        }
        //Reset prefix
        $this->db->set_dbprefix('pms_');
    }

    //End class
}