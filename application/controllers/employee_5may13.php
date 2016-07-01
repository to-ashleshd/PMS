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
    }

    public function index($tab = '', $tabid = '') {

        $this->employee();
    }

    function addemployeedata() {
        $data = array();

        $login_name = '';

        $this->load->helper('security');
        $password = do_hash(trim($this->input->post('password')), 'md5');

        $login_name = $this->input->post('email');

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
        if ($result) {
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

        if ($this->session->userdata('pms_employee_id') == '1') {
            $employee_list = $this->employeemodel->getAllEmployee($status);
        } else {
            $employee_permission_detail = $this->employeepermissionmodel->get_employee_permission($this->session->userdata('pms_employee_id'));
            if (!empty($employee_permission_detail)) {
                $office_address_ids = $this->employeepermissionmodel->get_employee_permission_offices($employee_permission_detail['employee_permission_id']);
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
                $office_address_ids = $this->employeepermissionmodel->get_employee_permission_offices($employee_permission_detail['employee_permission_id']);
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
        $reviewer_list = array();
        $apraiser_deatil = $this->employeemodel->getEmployeeById($apraiser_employee_id);

        if (!empty($apraiser_deatil)) {
            $reviewer_list = $this->employeemodel->get_downgrade_employee_list($apraiser_deatil->grade_id, '1');
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
        $data_previous_year           = array(
                                        'time_period_id'          => '1',
                                        'pms_employee_id'         => $pms_employee_id,
                                        'apraiser_employee_id'    => $apraiser_employee_id,
                                        'reviewer_employee_id'    => $reviewer_employee_id,
                                        'date_created'            => date('Y-m-d'),
                                        'sort_order'              => '1'
                                        );
        
        $result_previous_year =   $this->employeemodel->add_employee_relationship($data_previous_year);
        
        //now add track process with status 0
        $track_process_previous_year =  array(
            'time_period_id'          => '1',
            'pms_employee_id'         => $pms_employee_id,
            'track_status'            => '0.0'
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
        $reviewer_list = $this->employeemodel->get_downgrade_employee_list($apraiser_detail->grade_id, '1');


        //print_r($apraiser_list);
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

        $data = array(
            'apraiser_employee_id' => $apraiser_employee_id,
            'reviewer_employee_id' => $reviewer_employee_id
        );

        $result = $this->employeemodel->editrelationship($data, $employee_relationship_materix_id);

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

}

