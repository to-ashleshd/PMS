<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employeepermission extends CI_Controller {

    function __construct() {
        parent::__construct();
        //  $this->dashboard();
        $this->topmenu->no_cache();
        $this->load->model('generalesettings');
        $this->load->model('employeemodel');
        $this->load->model('commonmodel');
        $this->load->model('companymodel');
        $this->load->model('employeepermissionmodel');
        $this->load->model('adminrolesmodel');
        $this->load->model('businessmodel');

        if ($this->session->userdata('pms_employee_id')) {
            if ($this->session->userdata('pms_employee_id') != '1') {
                redirect('clientadmin', 'refresh');
            }
        } else {
            redirect('clientadmin', 'refresh');
        }


        /** @param type $tab
         * @param type $tabid 
         */
    }

    public function index($tab = '', $tabid = '') {

        $this->employee();
    }

    //foremployeelist
    function employee() {

        $status = '1';
        $data = array();
        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
        $employee_list = $this->employeepermissionmodel->getAllEmployee($status);
        
      
        $data['admin_roles'] = $this->adminrolesmodel->getListAll();
       
        $data['employee'] = $employee_list;
        $data['all_office_type'] = $employee_list;
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        $data['company_master'] = $this->companymodel->getCompaniesHavingOfficeType();
        
        $data['business']    = $this->businessmodel->getAllbusinesss();
        $data['business_html'] = '';
        $business_html  = '<div id="all_business">';
        $business_html .= '<label class="checkbox inline">';
        $business_html .= '<input type="checkbox"  onclick="call_to_chk_all_business(this.id)" id="all_business_chk" name="all_business_chk" >';
        $business_html .= 'All';
        $business_html .= '</label>';
         if(!empty($data['business']))
        {
               foreach($data['business'] as $key=>$val)
               {
                    $business_html .= '<label class="checkbox inline">';
                    $business_html .= '<input type="checkbox"  id="'.$val->business_id .'" value="'.$val->business_id.'" name="allbusinessids[]">';
                    $business_html .= $val->business_subject;
                    $business_html .= '</label>';
               }
        }
        $business_html .= '</div>';
        $data['business_html'] = $business_html;
       
        $data['company_list']  = $this->employeepermissionmodel->get_all_active_company();
        $data['company_html'] = '';
        $company_html = '';
        $company_html  = '<div id="all_company">';
        $company_html .= '<label class="checkbox inline">';
        $company_html .= '<input type="checkbox"  onclick="call_to_chk_all_company(this.id)" id="all_company_chk" name="all_company_chk" >';
        $company_html .= 'All';
        $company_html .= '</label>';
        if(!empty($data['company_list']))
        {
               foreach($data['company_list'] as $key=>$val)
               {
                    $company_html .= '<label class="checkbox inline">';
                    $company_html .= '<input type="checkbox"  id="'.$val['company_master_id'].'" value="'.$val['company_master_id'].'" name="allcompanyids[]">';
                    $company_html .= $val['company_name'];
                    $company_html .= '</label>';
               }
        }
        $company_html .= '</div>';
        $data['company_html'] .= $company_html;
        
        $data['offices_html'] = '';
        $office_name_html ='';
        
        
        $data['offices_list'] = $this->employeepermissionmodel->get_all_office_names();
//        echo "<pre>";
//        print_r($data['offices_list']);
//        die();
        if(!empty( $data['offices_list']))
        {
            foreach($data['offices_list'] as $key=>$val)
            {
                $office_name_html .= '<div id="office_type_'.$val['office_type_id'].'">';
                $office_name_html .= '<label >';
                $office_name_html .= $val['offices_type_name'];
                $office_name_html .= '</label>';
                $office_name_html .= '<div id="all_offices_'.$val['office_type_id'].'">';
                $office_name_html .= '<label class="checkbox inline">';
                $office_name_html .= '<input type="checkbox"  onclick="call_to_chk_all_offices(this.id)" id="all_offices_chk_'.$val['office_type_id'].'" name="all_offices_chk_'.$val['office_type_id'].'" >';
                $office_name_html .= 'All';
                $office_name_html .= '</label>';
                
                if(!empty($val['offices_list']))
                {
                   foreach($val['offices_list'] as $key2=>$val2)
                    { 
                       $office_name_html .= '<label class="checkbox inline">';
                       $office_name_html .= '<input type="checkbox"  id="'.$val2['office_addresses_id'].'" value="'.$val2['office_addresses_id'].'" name="allofficesids[]">';
                       $office_name_html .= $val2['office_name'];
                       $office_name_html .= '</label>';
                    }
                }
                else
                {
                       $office_name_html .= '<label class="checkbox inline">';
                       $office_name_html .= 'NO Offices in this office type.';
                       $office_name_html .= '</label>';
                }
              $office_name_html .= '</div>';
              $office_name_html .= '<label>&nbsp;</label>';
              $office_name_html .= '</div>';
                
            }
        }
        else
        {
             $office_name_html .= 'No Offices.';
        }
      // print_r($office_name_html);die();
        $data['offices_html'] = $office_name_html;
      
        $data['emp_per_list']  =  $this->get_employee_permision_detail();
        $data['departments'] = $this->companymodel->getDepartments();
        $data['topmenu'] = $this->topmenu->apraiseemenulist();
        $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
        $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
        $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
        $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);
        $this->load->view('default/clientadmin/cadmin_employee_permission', $data);
    }


    function getselfofficedetails() {
        $response = array();
        $response['office_detail_list'] = array();
        $employee_id = $this->input->post('employee_id', true);
        $employee_detail = $this->employeemodel->getEmployeeDetailsById($employee_id);
        if (!empty($employee_detail)) {
            $office_type_detail = $this->companymodel->get_office_type_by_office_address($employee_detail['office_type_id']);
            $response['office_detail_list'] = array(
                'office_name' => $employee_detail['office_name'],
                'office_type' => $office_type_detail['office_type_name']
            );
        }

        die(json_encode($response['office_detail_list']));
    }

    function getdownlineofficedetails() {
        $response = array();
        $response['office_detail_list'] = array();
        $employee_id = $this->input->post('employee_id', true);
        $office_type_id = $this->input->post('office_type_id', true);
        $employee_detail = $this->employeemodel->getEmployeeDetailsById($employee_id);

        $office_list = array();
        if (!empty($employee_detail)) {
            if ($office_type_id != '') {
                $office_type_detail = $this->companymodel->get_office_type_by_office_address($office_type_id);
            } else {
                $office_type_detail = $this->companymodel->get_office_type_by_office_address($employee_detail['office_type_id']);
            }

            if (!empty($office_type_detail)) {
                $office_sub_types = $this->companymodel->get_sub_office_types($office_type_detail['company_master_id'], $office_type_detail['priority']);
            }


            if (!empty($office_sub_types)) {

                foreach ($office_sub_types as $key => $val) {

                    $offices_detail = $this->companymodel->get_office_adress_by_office_type_ids(array($val['office_type_id']));
                    $office_list[] = array(
                        'office_type_id' => $val['office_type_id'],
                        'office_type_name' => $val['office_type_name'],
                        'offices_list' => $offices_detail
                    );
                }
            }
        }

        $response['office_detail_list'] = $office_list;
//            echo "<pre>";
//            print_r($office_list);
//            echo "</pre>";
//            die();




        die(json_encode($response['office_detail_list']));
    }

    function addemployeepermission() 
    {
        
        $response = '';
        $data = array();
        $data_emp = array();
        
        $is_upper_office = '';
        $upper_office_type = '';
        $result = '';
        $result_emp = '';
        $pms_employee_id = $this->input->post('h_pms_employee_id');
        $access_level_id = $this->input->post('access_level');
        
        if ($this->input->post('is_upper_office')) {
            $is_upper_office = 'Y';
        } else {
            $is_upper_office = 'N';
        }
        //echo $pms_employee_id;die();
        
        if ($_POST) {
            $data = array(
                'role_id'    => $this->input->post('role_id'),
                'pms_employee_id' => $this->input->post('employee_id'),
                'is_allow_upper_office' => $is_upper_office,
                'function_type' => $this->input->post('allow_office'),
                'access_level_id' => $access_level_id,
                'status' => '1'
            );
            if($pms_employee_id!='' || $pms_employee_id!=0)
            {
                $this->employeepermissionmodel->delete_employee_permission_with_mapping($pms_employee_id);
            }
            $employee_permission_id = $this->employeepermissionmodel->add_employee_permission($data);
            if ($this->input->post('allow_office') == 'L') {
                $employee_detail = $this->employeemodel->getEmployeeById($this->input->post('employee_id'));
                $data_emp = array(
                    'employee_permission_id' => $employee_permission_id,
                    'pms_employee_id' => $this->input->post('employee_id'),
                    'function_id' => $employee_detail->office_address_id,
                    'mapping_status' => '1'
                );

                $result_emp = $this->employeepermissionmodel->add_employee_permission_mapping($data_emp);
            } else {
               
                   if($access_level_id==1)
                    {
                       
                         foreach ($_POST['allbusinessids'] as $key => $val)
                            {
                                        $data_emp = array(
                                            'employee_permission_id' => $employee_permission_id,
                                            'pms_employee_id' => $this->input->post('employee_id'),
                                            'function_id' => $val,
                                            'mapping_status' => '1'
                                        );
                                        $result_emp = $this->employeepermissionmodel->add_employee_permission_mapping($data_emp);
                            }  
                    }
                    else if($access_level_id==2)
                    {
                        
                            foreach ($_POST['allcompanyids'] as $key => $val)
                            {
                                $data_emp = array(
                                    'employee_permission_id' => $employee_permission_id,
                                    'pms_employee_id' => $this->input->post('employee_id'),
                                    'function_id'   => $val,
                                    'mapping_status' => '1'
                                );
                                $result_emp = $this->employeepermissionmodel->add_employee_permission_mapping($data_emp);
                            }
                    }
                    else if($access_level_id==3)
                    {
                         foreach ($_POST['allofficesids'] as $key => $val)
                            {
                                        $data_emp = array(
                                            'employee_permission_id' => $employee_permission_id,
                                            'pms_employee_id' => $this->input->post('employee_id'),
                                            'function_id'   => $val,
                                            'mapping_status' => '1'
                                        );
                                       $result_emp = $this->employeepermissionmodel->add_employee_permission_mapping($data_emp);
                            }
                    }
            }
            
            if ($result_emp == 1) {
                $data['success']  = 'Employee Permission Added Successfully';
            } else {
               $data['error']  = 'Please try again';
            }
        } else {
            echo "Please Select Office.";
        }
        redirect('employeepermission','refresh');
        //die();
    }
    
    
    function get_employee_permision_detail()
    {
       $response = array();
       $response['emp_per_detail'] = array();
      
        $employees= $this->employeepermissionmodel->get_employee_permissions();
        
        if(!empty($employees))
        {
                foreach($employees as $key=>$val)
                {
                    $employee_name  = '';
                    $employee_id    = $val['pms_employee_id'];
                    $employee_detail = $this->employeemodel->getEmployeeDetailsById($val['pms_employee_id']);
                    if(!empty($employee_detail))
                    {
                        $employee_id   = $employee_detail['pms_employee_id'];
                        $employee_name = $employee_detail['fname'].' '.$employee_detail['lname'].' [ '.$employee_detail['employee_id'].' ]';
                    }

                    $employee_permission  = $this->employeepermissionmodel->get_employee_permission($val['pms_employee_id']);
                    $response['emp_per_detail'][$key]['employee_id'] = $employee_id;
                    $response['emp_per_detail'][$key]['employee_name'] = $employee_name;
                    if(!empty($employee_permission))
                    {
                       
                        if($employee_permission['function_type']=='L')
                        {
                           $response['emp_per_detail'][$key]['function_type'] = 'Local';
                           $response['emp_per_detail'][$key]['access_level_name']   = 'Self';
                           $response['emp_per_detail'][$key]['details']  ='';
                           $response['emp_per_detail'][$key]['details']  = $this->employeepermissionmodel->get_local_permission_detail($employee_permission['employee_permission_id']);
                        }
                        else
                        {
                            $response['emp_per_detail'][$key]['function_type']      = 'Global';
                            $response['emp_per_detail'][$key]['access_level_name']  = $this->employeepermissionmodel->get_access_level_name($employee_permission['access_level_id']);
                            $response['emp_per_detail'][$key]['details']            = $this->employeepermissionmodel->get_permission_detail($employee_permission['access_level_id'],$employee_permission['employee_permission_id']);
                        }
                        
                    }
               }
               
        }
        else
        {
            //no data found
        }
        return $response['emp_per_detail'];
    }

    
    function ajax_getuser_byrole()
    {
        $response = array();
        $role_id  = $this->input->post('role_id',TRUE);
        $pms_employee_ids = $this->employeepermissionmodel->get_employees_having_permission_added();
        if(empty($pms_employee_ids))
        {
            $pms_employee_ids = array('0');
        }
        $employee_list = $this->employeepermissionmodel->get_user_by_role($role_id,$pms_employee_ids);
        
        $html = '<option value="">--Please Select--</option>';
        if(!empty($employee_list))
        {
            foreach($employee_list as $key=>$val)
            {
                $employee_detail = $this->employeemodel->get_employee_by_id($val['pms_employee_id']);
                $html .= '<option value="'.$employee_detail['pms_employee_id'].'">'.$employee_detail['fname'].' '.$employee_detail['lname'].' [ '.$employee_detail['employee_id'].' ] </option>';
            }
        }
        
        //print_r($html);die();
        $response['html'] = $html;
        die(json_encode($response));
        
    }
    
 
   
   function ajax_get_permission_detail_for_edit()
   {
      
       $response = array();
       $pms_employee_id  = $this->input->post('pms_employee_id');
       $employee_permission_id = '0';
       $admin_role_html = '';
       $employee_html   = '';
       $office_address_list_html = '';
       $access_level_html ='';
       $content_function_list_html = '';
       
       $pms_employee_detail = $this->employeemodel->getEmployeeDetailsById($pms_employee_id);
       $employee_permission_detail = $this->employeepermissionmodel->get_permission_by_employee_id($pms_employee_id);
       if(!empty($employee_permission_detail))
       {
           $employee_permission_id  = $employee_permission_detail['employee_permission_id'];
           //admin role drop down
           $admin_role = $this->adminrolesmodel->get_user_role_by_id($employee_permission_detail['role_id']);
           if(!empty($admin_role))
            {
                   $admin_role_html .= '<option value="'.$admin_role->client_user_role_id.'" "selected="selected" >'.$admin_role->rolename.'</option>';
            } 

            //employee drop down
            $pms_employee_ids = $this->employeepermissionmodel->get_employees_having_permission_added();
            if(empty($pms_employee_ids))
            {
                $pms_employee_ids = array('0');
            }

            $employee_detail = $this->employeemodel->get_employee_by_id($pms_employee_id);
            $employee_html .= '<option value="'.$employee_detail['pms_employee_id'].'" selected="selected"  >'.$employee_detail['fname'].' '.$employee_detail['lname'].' [ '.$employee_detail['employee_id'].' ] </option>';

           
            $is_allow_upper_office = $employee_permission_detail['is_allow_upper_office'];
            $is_local_or_global    = $employee_permission_detail['function_type'];
            
            if($is_allow_upper_office=='N' && $is_local_or_global=='L')
            {
                $office_address_list_html  = '';
                $employee_detail = $this->employeemodel->getEmployeeDetailsById($pms_employee_id);
                if (!empty($employee_detail)) {
                    $office_type_detail = $this->companymodel->get_office_type_by_office_address($employee_detail['office_type_id']);
                    $office_address_list_html .= '<label><b>'.$office_type_detail['office_type_name'].'</b>: &nbsp;'.$employee_detail['office_name'].'</label>';
                }
            }
            else if($is_allow_upper_office=='Y' && $is_local_or_global=='G')
            {
                $access_level_html  = '<span class="span4">Select Access Level</span><select name="access_level" id="access_level"   onchange="call_acces_level_list()"><option value="">--Please Select--</option>';
                $access_levels = $this->employeepermissionmodel->get_access_levels();
                foreach($access_levels as $key=>$val)
                {
                    $selected_access_level = '';
                    if($key==$employee_permission_detail['access_level_id'])
                    {
                        $selected_access_level = 'selected="selected"';
                    }
                    $access_level_html .= '<option value="'.$key.'" '. $selected_access_level.'>'.$val.'</option>';
                }
                $access_level_html .='</select>';
               
                 if($employee_permission_detail['access_level_id']=='1')
                 {
                       $content_function_list_html = $this->employeepermissionmodel->get_business_for_edit($employee_permission_id);
                 }
                else  if($employee_permission_detail['access_level_id']=='2')
                {
                    $content_function_list_html = $this->employeepermissionmodel->get_company_for_edit($employee_permission_id);
                }
                else  if($employee_permission_detail['access_level_id']=='3')
                {
                    $content_function_list_html = $this->employeepermissionmodel->get_offices_for_edit($employee_permission_id);
                }
            }

            $response['pms_employee_id'] = $pms_employee_id;
           $response['role_html']       = $admin_role_html;
           $response['employee_html']   = $employee_html;
           $response['is_upper_office'] = $is_allow_upper_office;
           $response['is_local_or_global'] = $is_local_or_global;
           $response['access_level_id'] = $employee_permission_detail['access_level_id'];
           $response['content_function_list_html'] = '';
           if($is_allow_upper_office=='Y' && $is_local_or_global=='G')
           {
            $response['access_level_html'] = $access_level_html;
            $response['content_function_list_html'] = $content_function_list_html;
           }
           else if($is_allow_upper_office=='N' && $is_local_or_global=='L')
           {
                $response['office_address_list_html'] = $office_address_list_html;
           }
           
           
       }   
       
       //print_r($response);
      die(json_encode($response));
       
   }
   
   
   
   function get_basic_emp_per_template()
   {
        $response = array();
        $status = '1';
        $data = array();
        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
        $employee_list = $this->employeepermissionmodel->getAllEmployee($status);
        $data['admin_roles'] = $this->adminrolesmodel->getListAll();
        $data['employee'] = $employee_list;
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        
        $data['basic'] = $this->load->view('default/clientadmin/cadmin_basic_emp_permission', $data, true);
        $response['html'] = $data['basic'];
        die(json_encode($response));
   }
   
   function ajax_delete_permission()
   {
       $response = array();
       $response['status'] = '0';
       $pms_employee_id = $this->input->post('pms_employee_id');
       $employee_Detail = $this->employeepermissionmodel->get_employee_permission($pms_employee_id);
      
       $this->employeepermissionmodel->delete_employee_permission_with_mapping($pms_employee_id);
       if(empty($employee_Detail))
       {
            $response['status'] = '1';
       }
      
       die(json_encode($response));
   }
   
   
}

