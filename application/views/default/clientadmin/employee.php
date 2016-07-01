<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employee extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->topmenu->no_cache();
        $this->load->model('generalesettings');
        $this->load->model('employeemodel');
        $this->load->model('commonmodel');
        $this->load->model('companymodel');
        $this->load->model('employeepermissionmodel');
        $this->load->model('apraiseemodel');
    }

    public function index($tab = '', $tabid = '') {
        $this->employee();
    }

    
    function addemployeedata() {
        $data = array();

        $login_name = '';

        $this->load->helper('security');
        $user_passwd = trim($this->input->post('password'));
        $password = do_hash($user_passwd, 'md5');

        $login_name = $this->input->post('email');
        $user_fname = ucfirst($this->input->post('fname'));
        $user_lname = ucfirst($this->input->post('lname'));
        $user_email = $this->input->post('email');

        $data = array(
            'fname' => ucfirst($this->input->post('fname')),
            'mname' => ucfirst($this->input->post('mname')),
            'lname' => ucfirst($this->input->post('lname')),
            'login_name' => $login_name,
            'login_type' => '',
            'employee_id' => $this->input->post('employeeid'),
            'email' => $this->input->post('email'),
            'password' => $password,
            'gender' => $this->input->post('gender'),
            'date_of_birth' => date('Y-m-d', strtotime($this->input->post('date_of_birth'))),
            'company_master_id' => $this->input->post('office_add_company'),
            'office_address_id' => $this->input->post('offices_address'),
            'department_id' => $this->input->post('department'),
            'designation_id' => $this->input->post('designation'),
            'start_time_period_id' => $this->input->post('time_period_id'),
            'is_verified' => '1',
            'user_status' => '1',
            'mobile_no' => $this->input->post('mobile_no'),
            'date_created' => date('Y-m-d'),
            'date_of_joining' => date('Y-m-d', strtotime($this->input->post('date_of_joining'))),
            'last_updated' => date('Y-m-d'),
            'ip_address' => $this->input->ip_address()
        );
        $result = $this->employeemodel->add_employee($data);
        //add Meta for business
        $new_id = $this->db->insert_id();
        $this->employeemodel->updateUserMeta($new_id, 'business_id', $this->input->post('business_list_dd') ) ;
        
        if ($result) {
            //Send mail to New registered employee
            //TODO: send confirmation mail
            //Send Email
            $this->load->model('emailtemplatemodel');

            $this->load->library('email');

            $this->emailtemplatemodel->get_mail_settings();
            $data['s_mail_from'] = $this->commonmodel->get_env_setting('s_mail_from');
            $data['s_mail_name'] = $this->commonmodel->get_env_setting('s_mail_name');

            $this->email->from($data['s_mail_from'], $data['s_mail_name']);
            $this->email->to($user_email); //
            //Check email Template
            //Prepare link
            //%tpl_userfname% %tpl_userlname%,%tpl_activationlink%

            $email_data = array(
                'tpl_fname' => $user_fname,
                'tpl_lname' => $user_lname,
                'tpl_username' => $login_name,
                'tpl_password' => $user_passwd
            );
            $email_info = $this->emailtemplatemodel->get_template_by_code('PMS_NEW_EMP_REG', $email_data);

            $this->email->subject($email_info['email_subject']);
            $this->email->message($email_info['email_body']);

            
            if (!$this->email->send()) {
                $email_send_status = 'N';
            } else {
                $email_send_status = 'Y';
            }
            


            echo "Employee added successfully. Please Add Employee Relationship. <a href='" . base_url('employee/addrelationship') . "'>Employee Relationship</a>";
        } else {
            echo "Please try again";
        }
    }

    function addemployee() {
        if ($this->session->userdata('pms_employee_id')) {

            $this->load->model('companymodel');
            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $employee_detail = $this->employeemodel->getEmployeeById($this->session->userdata('pms_employee_id'));


            if ($this->session->userdata('pms_employee_id') != '1' && $employee_detail->company_master_id) {
                $data['company_master'][] = $this->companymodel->getCompany($employee_detail->company_master_id);
            } else {
                $data['company_master'] = $this->companymodel->getCompaniesHavingOfficeType();
            }


            $data['departments'] = $this->companymodel->getDepartments();
            $data['designations'] = $this->companymodel->getDesignations();
            $data['time_period_list'] = $this->commonmodel->get_all_time_period();

//        echo "<pre>";
//        print_r($data['time_period_list']);
//        echo "</pre>";
//        die();
            //business_details
            //Added By Ajay
            $this->load->model('businessmodel');
            $data['business_list_data'] = $this->businessmodel->getAllbusinesss();
            $data['business_list'] = $this->businessmodel->get_business_list_by_employee_id($this->session->userdata('pms_employee_id'));
//
           
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['current_date'] = date($data['s_date_format']);
            $data['js_date_format'] = get_datepicker_date2($data['s_date_format']);
            $data['req_pwd_strength'] = $this->commonmodel->get_env_setting('ui_slider3_sel');

            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);

            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            $this->load->view('default/clientadmin/cadmin_addemployee', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    //for employee list
    function employee() {
        $this->load->model('employeepermissionmodel');
        $status = '1';
        $data = array();
        $employee_list = array();
        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
        $employee_list = $this->employeemodel->getAllEmployee($status);
        if ($this->session->userdata('pms_employee_id') == '1') {
            $employee_list = $this->employeemodel->getAllEmployee($status);
        } else {
            $employee_permission_detail = $this->employeepermissionmodel->get_employee_permission($this->session->userdata('pms_employee_id'));
            if (!empty($employee_permission_detail)) {
                $office_address_ids = $this->companymodel->get_employee_office_ids_by_acl($this->session->userdata('pms_employee_id'));

                $employee_list = $this->employeemodel->get_employee_by_office_address_ids($office_address_ids);
            }
        }

        $data['employee'] = $employee_list;
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        $data['company_master'] = $this->companymodel->getCompaniesHavingOfficeType();
        $data['departments'] = $this->companymodel->getDepartments();
        $data['topmenu'] = $this->topmenu->apraiseemenulist();
        $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
        $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
        $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
        $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);
        $this->load->view('default/clientadmin/cadmin_employee_list', $data);
    }

    function addrelationship() {

        $data = array();
        $status = '1';
        $employee_list = array();
        $grade_status = '1';
        $apraiser_name_designation = '';
        $reviewer_name_designation = '';
        $designation_status = '1';
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        $data['employee'] = $this->employeemodel->getAllEmployee($status);
        $data['grades_with_designation'] = $this->companymodel->getGradesWithDesignation($grade_status, $designation_status);
        $data['employee_list'] = '';
        $time_period_id = '';

        $time_period_detail = $this->commonmodel->get_current_year();
        if (!empty($time_period_detail)) {
            $time_period_id = $time_period_detail['time_period_id'];
        }


        if ($this->session->userdata('pms_employee_id') == '1') {
            $employee_list = $this->employeemodel->getAllEmployee($status);
        } else {
            $employee_permission_detail = $this->employeepermissionmodel->get_employee_permission($this->session->userdata('pms_employee_id'));
            if (!empty($employee_permission_detail)) {
                $office_address_ids = $this->companymodel->get_employee_office_ids_by_acl($this->session->userdata('pms_employee_id'));
                $employee_list = $this->employeemodel->get_employee_by_office_address_ids($office_address_ids);
            }
        }


        if (!empty($employee_list)) {

            foreach ($employee_list as $key => $val) {


                $employee_relationship = $this->employeemodel->get_employee_relationship($val['pms_employee_id'], $time_period_id);


                //die();
//              if(!empty($employee_relationship))
//                {
//                    $data['employee_list'][$key]   =  $val;
//                    $appraiser_detail                           = $this->employeemodel->getEmployeeById($employee_relationship['0']['apraiser_employee_id']);
//                  
//                    if(!empty($appraiser_detail))
//                    {
//                        $apraiser_name_designation              = $appraiser_detail->fname.' '.$appraiser_detail->lname.', '.$appraiser_detail->designation_name;
//                    }
//                    
//                    $reviewer_detail                            = $this->employeemodel->getEmployeeById($employee_relationship['0']['reviewer_employee_id']);
//                    if(!empty($reviewer_detail))
//                    {
//                       $reviewer_name_designation               = $reviewer_detail->fname.' '.$reviewer_detail->lname.', '.$reviewer_detail->designation_name; 
//                    }
//                    
//                    $data['employee_list'][$key]['relationship_name_detail']   = array(
//                        'apraiser_name_designation'     => $apraiser_name_designation,
//                        'reviewer_name_designation'     => $reviewer_name_designation
//                    );
//                }
//                else
                if (empty($employee_relationship)) {
                    // echo "aprasier_list";echo "<br>";
                    $data['employee_list'][$key] = $val;
                    $apraiser_list = $this->employeemodel->get_downgrade_employee_list($val['grade_id'], '1');
                    //print_r($apraiser_list);
                    $data['employee_list'][$key]['apraiser_list'] = array();
                    if (!empty($apraiser_list)) {

                        $emp_appraiser = array();

                        foreach ($apraiser_list as $keya => $vala) {

                            $emp_appraiser[] = array(
                                'appraiser_employee_name' => $vala['fname'] . ' ' . $vala['lname'],
                                'appraiser_employee_id' => $vala['pms_employee_id'],
                                'designation_name' => $vala['designation_name']
                            );
                        }
                        $data['employee_list'][$key]['apraiser_list'] = $emp_appraiser;
                    }
                }
                //print_r($data['employee_list']);  echo "<hr>";echo "<br><br>";
                // $reviewer_list = $this->employeemodel->get_downgrade_employee_list($val['grade_id']);
            }//die();
        }




        $data['employee'] = $data['employee_list'];

        $data['topmenu'] = $this->topmenu->apraiseemenulist();
        $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
        $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
        $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
        $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
        $this->load->view('default/clientadmin/cadmin_relationship_materix', $data);
    }

    function relationship() {
        $status = '1';
        $data = array();
        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
        $employee_list = $this->employeemodel->getRelationshipDetails();

//         echo "<pre>";
//         print_r($employee_list);
//         echo "</pre>";
//         die();
        
        $data['employee'] = $employee_list;
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();


        $data['topmenu'] = $this->topmenu->apraiseemenulist();

        $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, TRUE);
        $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, TRUE);
        $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, TRUE);
        $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, TRUE);
        $this->load->view('default/clientadmin/cadmin_relationship_materix_list', $data);
    }

    function getsupergrades() {
        $response = array();
        $response['grade'] = array();
        $employee_grade_id = $this->input->post('employee_grade_id', true);
        $grade_status = '1';
        $designation_status = '1';
        $grade_deatil = $this->companymodel->getSuperiorGradesWithDesignation($employee_grade_id, $grade_status, $designation_status);
        if (!empty($grade_deatil)) {
            foreach ($grade_deatil as $key => $val) {
                $response['grade'][] = array('grade_id' => $val['grade_id'], 'grade_name' => $val['grade_name'], 'designation_id' => $val['designation_id'], 'designation_name' => $val['designation_name']);
            }
        }
        die(json_encode($response['grade']));
    }

    function getreviewerlist() {
        $response = array();
        $response['reviewer_list'] = array();
        $apraiser_employee_id = $this->input->post('apraiser_employee_id', true);
        $pms_employee_id      = $this->input->post('pms_employee_id', true);
        $time_period_detail         = $this->commonmodel->get_current_year();
        if(!empty($time_period_detail))
        {
            $time_period_id             = $time_period_detail['time_period_id'];
        }
        
        $all_appraisers = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id,$time_period_id);
        $selected_apraiser = $this->employeemodel->getEmployeeById($apraiser_employee_id);
        if(!empty($selected_apraiser))
        {
            $grades[] = $selected_apraiser->grade_id;
        }
        $grade_id = '';
        if(!empty($all_appraisers))
        {
            foreach($all_appraisers as $key_ap=>$val_ap)
            {
                if($key_ap!=0)
                {
                    $apraiser_deatil_for_grade = $this->employeemodel->getEmployeeById($val_ap['apraiser_employee_id']);

                    if(!empty($apraiser_deatil_for_grade))
                    {
                        $grades[]  = $apraiser_deatil_for_grade->grade_id;
                    }
                }
            }
        }
        
    
        if(!empty($grades))
        {
             $grade_id = min($grades);
        }
      
        $reviewer_list = array();
        //$apraiser_deatil = $this->employeemodel->getEmployeeById($apraiser_employee_id);
      
        if (!empty($grade_id)) {
            $reviewer_list = $this->employeemodel->get_downgrade_employee_list($grade_id, '1');
            if (!empty($reviewer_list)) {
                foreach ($reviewer_list as $key => $val) {
                    $reviewer_list[$key] = array(
                        'reviewer_employee_id' => $val['pms_employee_id'],
                        'reviewer_employee_name' => $val['fname'] . ' ' . $val['lname'],
                        'designation_id' => $val['designation_id'],
                        'designation_name' => $val['designation_name']
                    );
                }
            }
        }
       
        $response['reviewer_list'] = $reviewer_list;
        die(json_encode($response['reviewer_list']));
    }

    function addemployeerelationshipdata() {
        $response = array();
        $data = array();
        $time_period_id = '';

        $time_period_detail = $this->commonmodel->get_current_year();
        if (!empty($time_period_detail)) {
            $time_period_id = $time_period_detail['time_period_id'];
        }
        $apraiser_employee_id = $this->input->post('apraiser_employee_id', true);
        $reviewer_employee_id = $this->input->post('reviewer_employee_id', true);
        $pms_employee_id = $this->input->post('pms_employee_id', true);

        $data = array(
            'time_period_id' => $time_period_id,
            'pms_employee_id' => $pms_employee_id,
            'apraiser_employee_id' => $apraiser_employee_id,
            'reviewer_employee_id' => $reviewer_employee_id,
            'date_created' => date('Y-m-d'),
            'sort_order' => '1'
        );
        $result = $this->employeemodel->add_employee_relationship($data);

        //now add track process with status 0
        $track_process = array(
            'time_period_id' => $time_period_id,
            'pms_employee_id' => $pms_employee_id,
            'track_status' => '0.0'
        );

        $result1 = $this->employeemodel->add_employee_track($track_process);

        //for temparary use add emp relationship to previous yesr also
        $data_previous_year = array(
            'time_period_id' => '1',
            'pms_employee_id' => $pms_employee_id,
            'apraiser_employee_id' => $apraiser_employee_id,
            'reviewer_employee_id' => $reviewer_employee_id,
            'date_created' => date('Y-m-d'),
            'sort_order' => '1'
        );

        $result_previous_year = $this->employeemodel->add_employee_relationship($data_previous_year);

        //now add track process with status 0
        $track_process_previous_year = array(
            'time_period_id' => '1',
            'pms_employee_id' => $pms_employee_id,
            'track_status' => '0.0'
        );

        $result1_previous_year = $this->employeemodel->add_employee_track($track_process_previous_year);

        $appraiser_name_designation = '';
        $reviewer_name_designation = '';

        $apraiser_detail = $this->employeemodel->getEmployeeById($apraiser_employee_id);
        $reviewer_detail = $this->employeemodel->getEmployeeById($reviewer_employee_id);

        if (!empty($apraiser_detail)) {
            $appraiser_name_designation = $apraiser_detail->fname . ' ' . $apraiser_detail->lname . ', ' . $apraiser_detail->designation_name;
        }

        if (!empty($reviewer_detail)) {
            $reviewer_name_designation = $reviewer_detail->fname . ' ' . $reviewer_detail->lname . ', ' . $apraiser_detail->designation_name;
        }

        $response['detail'] = array(
            'appraiser_name_designation' => $appraiser_name_designation,
            'reviewer_name_designation' => $reviewer_name_designation
        );
        if ($result == 1 && $result1 == 1) {
            $response['msg'] = 'Relationship Added Successfully';
        } else {
            $response['error_msg'] = 'Please Try Again';
        }

        die(json_encode($response));
    }

    function call_employee_edit_row() {
        $response = array();
        $data = array();

        $time_period_id = '';
        $immediate_previouse_year = '';

        $time_period_detail = $this->commonmodel->get_current_year();
        if (!empty($time_period_detail)) {
            $time_period_id = $time_period_detail['time_period_id'];
        }

        $immediate_year_detail = $this->commonmodel->get_immediate_previous_year();
        if (!empty($immediate_year_detail)) {
            $immediate_previouse_year = $immediate_year_detail['time_period_id'];
        }

        $appraiser_id = '';
        $reviewer_id = '';

        $pms_employee_id = $this->input->post('pms_employee_id', true);
        $employee_relatinship_id = $this->input->post('emp_relationship_id', true);

        $employee_detail = $this->employeemodel->getEmployeeById($pms_employee_id);
        $employee_relationship = $this->employeemodel->get_employee_relationship_by_id($employee_relatinship_id);
        $prev_employee_relationship = $this->employeemodel->get_employee_relationship($pms_employee_id, $immediate_previouse_year);

        $employee_relationship_id = '';
        if (!empty($employee_relationship)) {
            $employee_relationship_id = $employee_relationship['employee_relationship_materix_id'];
            $appraiser_id = $employee_relationship['apraiser_employee_id'];
            $reviewer_id = $employee_relationship['reviewer_employee_id'];
        }

        $apraiser_detail = $this->employeemodel->getEmployeeById($appraiser_id);
       

        $apraiser_list = $this->employeemodel->get_downgrade_employee_list($employee_detail->grade_id, '1');
        
     
        
        $all_appraisers = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id,$time_period_id);

        $grade_id = '';
        if(!empty($all_appraisers))
        {
            foreach($all_appraisers as $key_ap=>$val_ap)
            {
             $apraiser_deatil_for_grade = $this->employeemodel->getEmployeeById($val_ap['apraiser_employee_id']);
             if(!empty($apraiser_deatil_for_grade))
             {
                $grades[]  = $apraiser_deatil_for_grade->grade_id;
             }
            }
        }
        
     
        if(!empty($grades))
        {
             $grade_id = min($grades);
        }
        
        $reviewer_list = $this->employeemodel->get_downgrade_employee_list($grade_id, '1');


        $data['apraiser_employee_list'] = array();
        if (!empty($apraiser_list)) {
            $emp_appraiser = array();
            foreach ($apraiser_list as $keya => $vala) {
                $emp_appraiser[] = array(
                    'appraiser_employee_name' => $vala['fname'] . ' ' . $vala['lname'],
                    'appraiser_employee_id' => $vala['pms_employee_id'],
                    'appraiser_designation_name' => $vala['designation_name']
                );
            }
            $data['apraiser_employee_list'] = $emp_appraiser;
        }

        $data['reviewer_employee_list'] = array();
        if (!empty($reviewer_list)) {
            $emp_reviewer = array();
            foreach ($reviewer_list as $keyra => $valra) {
                $emp_reviewer[] = array(
                    'reviewer_employee_name' => $valra['fname'] . ' ' . $valra['lname'],
                    'reviewer_employee_id' => $valra['pms_employee_id'],
                    'reviewer_designation_name' => $valra['designation_name']
                );
            }

            $data['reviewer_employee_list'] = $emp_reviewer;
        }

        $response['apraiser_id'] = $appraiser_id;
        $response['reviewer_id'] = $reviewer_id;
        $response['apraiser_list'] = $data['apraiser_employee_list'];
        $response['reviewer_list'] = $data['reviewer_employee_list'];
        $response['employee_realtionship_id'] = $employee_relationship_id;
        die(json_encode($response));
    }

    function update_relationship_data() {
        $response = array();
        $data = array();

        $time_period_id = '';

        $time_period_detail = $this->commonmodel->get_current_year();
        if (!empty($time_period_detail)) {
            $time_period_id = $time_period_detail['time_period_id'];
        }
        $appraiser_id = '';
        $reviewer_id = '';

        $pms_employee_id = $this->input->post('pms_employee_id', true);
        $employee_relationship_materix_id = $this->input->post('employee_relationship_materix_id', true);
        $apraiser_employee_id = $this->input->post('apraiser_employee_id', true);
        $reviewer_employee_id = $this->input->post('reviewer_employee_id', true);

        $all_relationship = $this->employeemodel->get_relationship_of_employee($pms_employee_id,$time_period_id);

        
         $data = array(
            'apraiser_employee_id' => $apraiser_employee_id,
            'reviewer_employee_id' => $reviewer_employee_id
        );

        $result = $this->employeemodel->editrelationship($data, $employee_relationship_materix_id);
         
        
       if(!empty($all_relationship))
       {
           foreach($all_relationship as $key=>$val)
           {
               if($val['apraiser_employee_id']!=$apraiser_employee_id)
               {
                   $data_other_emp_relationship = array('reviewer_employee_id'=>$reviewer_employee_id);
                    $result_emp_relationship = $this->employeemodel->editrelationship($data_other_emp_relationship, $val['employee_relationship_materix_id']);
               }
           }
       }

       
        
        $appraiser_name_designation = '';
        $reviewer_name_designation = '';

        $apraiser_detail = $this->employeemodel->getEmployeeById($apraiser_employee_id);
        $reviewer_detail = $this->employeemodel->getEmployeeById($reviewer_employee_id);

        if (!empty($apraiser_detail)) {
            $appraiser_name_designation = $apraiser_detail->fname . ' ' . $apraiser_detail->lname . ', ' . $apraiser_detail->designation_name;
        }

        if (!empty($reviewer_detail)) {
            $reviewer_name_designation = $reviewer_detail->fname . ' ' . $reviewer_detail->lname . ', ' . $apraiser_detail->designation_name;
        }

        $response['detail'] = array(
            'appraiser_name_designation' => $appraiser_name_designation,
            'reviewer_name_designation' => $reviewer_name_designation
        );

        if ($result) {
            $response['msg'] = 'Relationship Updated Successfully';
        } else {
            $response['error_msg'] = 'Please Try Again';
        }
        die(json_encode($response));
    }

    /** Added for Profile and password - Ajay * */
    function changepassword() {
        if ($this->session->userdata('clientadmin_id')) {

            $this->load->model('companymodel');
            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();
            $data['company_master'] = $this->companymodel->getCompaniesHavingOfficeType();
            $data['departments'] = $this->companymodel->getDepartments();
            $data['designations'] = $this->companymodel->getDesignations();

            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['current_date'] = date($data['s_date_format']);
            $data['js_date_format'] = get_datepicker_date2($data['s_date_format']);
            $data['req_pwd_strength'] = $this->commonmodel->get_env_setting('ui_slider3_sel');

            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);

            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            //$data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_beoro_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            $this->load->view('default/clientadmin/cadmin_changepass', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function profile() {
        if ($this->session->userdata('clientadmin_id')) {

            $this->load->model('companymodel');
            $this->load->model('employeemodel');
            $empid = $this->session->userdata('clientadmin_id');
            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();
            $data['company_master'] = $this->companymodel->getCompaniesHavingOfficeType();
            $data['departments'] = $this->companymodel->getDepartments();
            $data['designations'] = $this->companymodel->getDesignations();

            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['current_date'] = date($data['s_date_format']);
            $data['js_date_format'] = get_datepicker_date2($data['s_date_format']);
            $data['req_pwd_strength'] = $this->commonmodel->get_env_setting('ui_slider3_sel');

            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);

            //Employee Info
            $empinfo = $this->employeemodel->getEmployeeDetailsById($empid);
            //echo '<pre>';
            //print_r($empinfo);
            //echo '</pre>';
            $data['empinfo'] = $empinfo;
            $data['result_office'] = $this->companymodel->getOfficesBycompanyId($empinfo['company_master_id']);
            $data['grade_deatil'] = $this->companymodel->getGradeByDesignationId($empinfo['designation_id']);
            //$data['result_dept'] = $this->companymodel->getDepartmentByIDs($empinfo['department_id']);
            //date($s_date_format, strtotime($val['meta_value']));

            $data['date_of_birth'] = date($data['s_date_format'], strtotime($empinfo['date_of_birth']));
            $data['date_of_joining'] = date($data['s_date_format'], strtotime($empinfo['date_of_joining']));
            $data['last_pramotion_date'] = date($data['s_date_format'], strtotime($empinfo['last_pramotion_date']));

            //Check for empty date

            if (date("Y-m-d", strtotime($empinfo['date_of_joining'])) == date("Y-m-d", mktime(0, 0, 0, 1, 1, 1970))) {
                $data['date_of_joining'] = '- Empty -';
            }

            if (date("Y-m-d", strtotime($empinfo['last_pramotion_date'])) == date("Y-m-d", mktime(0, 0, 0, 1, 1, 1970))) {
                $data['last_pramotion_date'] = '- Empty -';
            }
            
            //Added By Ajay
            $this->load->model('businessmodel');
            $data['business_list_data'] = $this->businessmodel->getAllbusinesss();
            

            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            //$data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_beoro_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            $this->load->view('default/clientadmin/cadmin_emp_profile', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function profileupdate() {
        $response = array();
        /**
          echo '<pre>';
          print_r($_POST);
          echo '</pre>';
         * 
         */
        /**
          [pms_employee_id] => 1
          [fname] => Swapnil
          [mname] => D.
          [lname] => Mahajan
          [email] => swapnil.m@enrich.in
          [gender] => M
          [date_of_birth] => 26.01.1988
          [mobile_no] =>
         * *///date('Y-m-d', strtotime($this->input->post('date_of_birth'))),
        $update_data = array(
            'fname' => $_POST['fname'],
            'mname' => $_POST['mname'],
            'lname' => $_POST['lname'],
            'email' => $_POST['email'],
            'gender' => $_POST['gender'],
            'date_of_birth' => date('Y-m-d', strtotime($_POST['date_of_birth'])),
            'mobile_no' => $_POST['mobile_no']
        );

        //TODO: Check Duplicate email
        $is_exists = $this->isEmailExists($_POST['email'], $_POST['pms_employee_id']);

        if ($is_exists->howmany >= 1) {
            $response['message'] = 'Someone is already using this email address. Profile unchanged.';
        } else {
            $result = $this->db->update($this->db->dbprefix . 'employee', $update_data, array('pms_employee_id' => $_POST['pms_employee_id']));
            $response['message'] = 'Profile is updated Successfully.';
        }

        die(json_encode($response));
    }

    function ajax_updpassword() {
        $response = array();
        //print_r($_POST);
        $empid = $this->session->userdata('pms_employee_id');
        $isValidCurrentPassword = $this->isValidPassword($empid, $_POST['current_password']);

        if ($isValidCurrentPassword->howmany >= 1) {
            //Update password
            $update_data = array('password' => md5($_POST['password']));
            $this->db->update($this->db->dbprefix . 'employee', $update_data, array('pms_employee_id' => $empid));
            //echo $this->db->last_query();
            $response['message'] = 'Password has successfully changed.';
        } else {
            //valid current passord
            $response['message'] = 'Current Password did not matched';
        }

        die(json_encode($response));
    }

    function isValidPassword($empid, $password) {
        $sql = "SELECT count(*) as howmany FROM " . $this->db->dbprefix . "employee WHERE pms_employee_id='" . $empid . "' AND password='" . md5($password) . "'";
        $query = $this->db->query($sql);
        $row = $query->first_row();
        return $row;
    }

    function isEmailExists($email, $empid) {
        $query = $this->db->query("SELECT count(*) as howmany 
                FROM " . $this->db->dbprefix . "employee 
                WHERE email='" . $email . "' 
                AND pms_employee_id NOT IN(" . $empid . ") ");
        $row = $query->first_row();
        return $row;
    }
    
    
    function lastpromotion()
    {
        $data = array();
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
        $data['current_date'] = date($data['s_date_format']);
        $status = 1 ;
       $employee_list = array();
       // $data['employee'] = $this->employeemodel->getAllEmployee();
        if ($this->session->userdata('pms_employee_id') == '1') {
            $employee_list = $this->employeemodel->getAllEmployee($status);
        } else {
            $employee_permission_detail = $this->employeepermissionmodel->get_employee_permission($this->session->userdata('pms_employee_id'));
            if (!empty($employee_permission_detail)) {
                $office_address_ids = $this->companymodel->get_employee_office_ids_by_acl($this->session->userdata('pms_employee_id'));
                $employee_list = $this->employeemodel->get_employee_by_office_address_ids($office_address_ids);
            }
        }
        
        $data['employee'] = $employee_list;
        
        $data['topmenu'] = $this->topmenu->apraiseemenulist();
        $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
        $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
        $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
        $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
        $this->load->view('default/clientadmin/cadmin_lastpromotion', $data);
    }
    
    function autocomplete_employee()
    {
        $json = array();

        $employee = $this->input->post('employee', TRUE);
        $employee = strtolower($employee);
        if ($employee != '') {

            $status = '1';
            $json = $this->employeemodel->get_employee_by_name(trim($employee));
        }
        $response['employee'] = $json;

        die(json_encode($response));
    }

    
    function get_detail_last_promotion()
    {
        $response = array();
        $data = array();
        $pms_employee_id = $this->input->post('pms_employee_id',TRUE);
        $last_promotions = $this->employeemodel->get_last_promotions($pms_employee_id);
        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
        $data['current_date'] = date($data['s_date_format']);
        $data['designations'] = $this->commonmodel->get_all_designation();
        $data['js_date_format'] = get_datepicker_date2($data['s_date_format']);
        $present_detail  = $this->employeemodel->get_employee_by_id($pms_employee_id);
        $last_promotion_list = array();
        if(!empty($last_promotions))
        {
            foreach($last_promotions as $key=>$val)
            {
                $last_promotion_list[] = array(
                    'employee_last_promotions_id' => '',
                    'last_promotion_date' => date($data['s_date_format'],  strtotime($val['last_promotion_date'])),
                    'designation_id' => $val['designation_id'],
                    'date_added' => date($data['s_date_format'],  strtotime($val['date_added'])),
                    'designation_name' => $val['designation_name'],
                    'grade_id' => $val['grade_id'],
                    'grade_name' => $val['grade_name'],
                    'fname'  => $val['fname'],
                    'lname' => $val['lname'],
                    'employee_id' => $val['employee_id'],
                );
            }
        }
        
        $data['last_promotion_list'] = $last_promotion_list;
        if(!empty($present_detail))
        {
            $grade_name = '';
            $present_grade_detail  = $this->commonmodel->get_grade_by_id($present_detail['grade_id']);
            if(!empty($present_grade_detail))
            {
                $grade_name = $present_grade_detail['grade_name'];
            }
            
            $last_promotin_dt ='';
            if($present_detail['last_pramotion_date']=='0000-00-00')
            {
                $last_promotin_dt = '-';
            }
            else
            {
                $last_promotin_dt = date($data['s_date_format'],  strtotime($present_detail['last_pramotion_date']));
            }
            
            $data['present_detail'] = array(
                'pms_employee_id' => $present_detail['pms_employee_id'],
                'employee_id' => $present_detail['employee_id'],
                'fname'  => $present_detail['fname'],
                'lname' => $present_detail['lname'],
                'email' => $present_detail['email'],
                'gender' => $present_detail['gender'],
                'date_of_birth' => date($data['s_date_format'],  strtotime($present_detail['date_of_birth'])),
                'date_of_joining' => date($data['s_date_format'],  strtotime($present_detail['date_of_joining'])),
                'last_pramotion_date' => $last_promotin_dt,
                'designation_id' => $present_detail['designation_id'],
                'designation_name'=>$present_detail['designation_name'],
                'grade_id' => $present_detail['grade_id'],
                'grade_name' => $grade_name,
            );
        }
     // echo $data['js_date_format'];die();
        if($present_detail['last_pramotion_date']!='0000-00-00')
        {
            $response['start_date_for_validation'] = date('d-m-Y',strtotime($last_promotin_dt));
        }
        else
        {
            $response['start_date_for_validation'] = date('d-m-Y',  strtotime($present_detail['date_of_joining']));
        }
        $response['end_date_for_validation'] = date('d-m-Y');
        $response['display_detail'] =  $this->load->view('default/clientadmin/cadmin_lastpromotion_table', $data, TRUE);
        die(json_encode($response));
    }
    
    
    function add_employee_last_promotion()
    {
        $response = array();
        $data = array();
        $html = '';
        $s_date_format = $this->commonmodel->get_env_setting('s_date_format');
        $js_date_format = get_datepicker_date2($s_date_format);
        $pms_employee_id = $this->input->post('pms_employee_id',TRUE);
        $last_promotion_date = $this->input->post('last_promotion_date',TRUE);
        $designation_id = $this->input->post('designation_id',TRUE);
        $sr_no = $this->input->post('srno',TRUE);
        $sr_no++;
        $data = array(
            'last_promotion_date' =>date('Y-m-d',  strtotime($last_promotion_date)),
            'pms_employee_id' => $pms_employee_id,
            'designation_id' => $designation_id,
            'date_added' => date('Y-m-d'),
            'ip_address' => $this->input->ip_address()
        );
        $last_pramotion_id = $this->employeemodel->add_employee_last_promotion($data);
        if(!empty($last_pramotion_id))
        {
            $response['status'] = '1';
        }
        else
        {
            $response['status'] = '0';
        }
        
        $last_pramotion_detail = $this->employeemodel->get_last_promotion_by_id($last_pramotion_id);
        
        $update_employee = array(
            'last_pramotion_date' => date('Y-m-d',  strtotime($last_promotion_date)),
            'designation_id' => $designation_id
        );
        
        $this->employeemodel->update_employee_data($pms_employee_id,$update_employee);
        
        if(!empty($last_pramotion_detail))
        {
           
           $html .= '<tr id="tr_last_promotion_'.$last_pramotion_detail['employee_last_promotions_id'].'" >';
	   $html .= '<td>'.$sr_no.'</td>';
           $html .= '<td>'.$last_pramotion_detail['employee_id'].'</td>';
           $html .= '<td>'.$last_pramotion_detail['fname'].' '. $last_pramotion_detail['lname'].'</td>';
           $html .= '<td>'.date('Y-m-d',  strtotime($last_pramotion_detail['last_promotion_date'])).'</td>';
           $html .= '<td>'.$last_pramotion_detail['designation_name'].'</td>';
           $html .= '<td>'.$last_pramotion_detail['grade_name'].'</td>';
           $html .= '</tr>';
        }
        $response['html'] = $html;
        $response ['last_promotion_date'] = date('Y-m-d',  strtotime($last_pramotion_detail['last_promotion_date']));
        $response ['designation_name']    = $last_pramotion_detail['designation_name'];
        $response ['grade_name']          = $last_pramotion_detail['grade_name'];
        
//        echo "<pre>";
//        print_r($response);
//        echo "</pre>";die();
        
        
        $response['start_date_for_validation'] = date($s_date_format,  strtotime($last_pramotion_detail['last_promotion_date']));
        $response['end_date_for_validation'] = date('d-m-Y');
        die(json_encode($response));
    }
    
    function test()
    {
        $status = '1';
        $data = array();
        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
        $employee_list = $this->employeemodel->getRelationshipDetails();
//        echo "<pre>";
//        print_r($employee_list);
//        die();
        $data['employee'] = $employee_list;
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        $data['topmenu'] = $this->topmenu->apraiseemenulist();

        $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, TRUE);
        $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, TRUE);
        $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, TRUE);
        $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, TRUE);
        $this->load->view('default/clientadmin/cadmin_relationship_materix_list', $data);
    }
    
    
    
    function call_employee_edit_row_without_reviewer() {
        $response = array();
        $data = array();

        $time_period_id = '';
        $immediate_previouse_year = '';

        $time_period_detail = $this->commonmodel->get_current_year();
        if (!empty($time_period_detail)) {
            $time_period_id = $time_period_detail['time_period_id'];
        }

        $immediate_year_detail = $this->commonmodel->get_immediate_previous_year();
        if (!empty($immediate_year_detail)) {
            $immediate_previouse_year = $immediate_year_detail['time_period_id'];
        }

        $appraiser_id = '';
        $reviewer_id = '';

        $pms_employee_id = $this->input->post('pms_employee_id', true);
        $employee_relatinship_id = $this->input->post('emp_relationship_id', true);

        $employee_detail = $this->employeemodel->getEmployeeById($pms_employee_id);
        $employee_relationship = $this->employeemodel->get_employee_relationship_by_id($employee_relatinship_id);

        $employee_relationship_id = '';
        if (!empty($employee_relationship)) {
            $employee_relationship_id = $employee_relationship['employee_relationship_materix_id'];
            $appraiser_id = $employee_relationship['apraiser_employee_id'];
            $reviewer_id = $employee_relationship['reviewer_employee_id'];
        }

        $apraiser_detail = $this->employeemodel->getEmployeeById($appraiser_id);
       
        $grade_id = '0';
        $all_relationship = $this->employeemodel->get_relationship_of_employee($pms_employee_id,$time_period_id);
        if(!empty($all_relationship))
        {
            $first_reviewer_detail = $this->employeemodel->getEmployeeById($all_relationship[0]['reviewer_employee_id']);
            if(!empty($first_reviewer_detail))
            {
                $grade_id =  $first_reviewer_detail->grade_id;
            }
            
        }
        else
        {
            $grade_id = $employee_detail->grade_id;
        }   
            
       
        $apraiser_list = $this->employeemodel->get_downgrade_employee_list($grade_id, '1');
        
     
        
        $all_appraisers = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id,$time_period_id);

        $grade_id = '';
        if(!empty($all_appraisers))
        {
            foreach($all_appraisers as $key_ap=>$val_ap)
            {
             $apraiser_deatil_for_grade = $this->employeemodel->getEmployeeById($val_ap['apraiser_employee_id']);
             if(!empty($apraiser_deatil_for_grade))
             {
                $grades[]  = $apraiser_deatil_for_grade->grade_id;
             }
            }
        }
        
     
        if(!empty($grades))
        {
             $grade_id = min($grades);
        }
        
        $reviewer_list = $this->employeemodel->get_downgrade_employee_list($grade_id, '1');


        $data['apraiser_employee_list'] = array();
        if (!empty($apraiser_list)) {
            $emp_appraiser = array();
            foreach ($apraiser_list as $keya => $vala) {
                $emp_appraiser[] = array(
                    'appraiser_employee_name' => $vala['fname'] . ' ' . $vala['lname'],
                    'appraiser_employee_id' => $vala['pms_employee_id'],
                    'appraiser_designation_name' => $vala['designation_name']
                );
            }
            $data['apraiser_employee_list'] = $emp_appraiser;
        }

        $data['reviewer_employee_list'] = array();
        if (!empty($reviewer_list)) {
            $emp_reviewer = array();
            foreach ($reviewer_list as $keyra => $valra) {
                $emp_reviewer[] = array(
                    'reviewer_employee_name' => $valra['fname'] . ' ' . $valra['lname'],
                    'reviewer_employee_id' => $valra['pms_employee_id'],
                    'reviewer_designation_name' => $valra['designation_name']
                );
            }

            $data['reviewer_employee_list'] = $emp_reviewer;
        }

        $response['apraiser_id'] = $appraiser_id;
        $response['reviewer_id'] = $reviewer_id;
        $response['apraiser_list'] = $data['apraiser_employee_list'];
        $response['reviewer_list'] = $data['reviewer_employee_list'];
        $response['employee_realtionship_id'] = $employee_relationship_id;
        die(json_encode($response));
    }
    
}

