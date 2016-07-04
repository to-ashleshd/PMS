<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kra extends CI_Controller {

    function __construct() {
        parent::__construct();
        //  $this->dashboard();
        $this->topmenu->no_cache();
        $this->load->model('generalesettings');
        $this->load->model('employeemodel');
        $this->load->model('commonmodel');
        $this->load->model('companymodel');
    }

    public function index($tab = '', $tabid = '') {

        //$this->employee();
    }

    function addkra($year = '') {
        if ($this->session->userdata('clientadmin_id')) {
            $this->load->model('companymodel');
            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();
            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            $this->load->view('default/clientadmin/cadmin_addkra', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    //foremployeelist
    function employee() {

        $status = '1';
        $data = array();
        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
        $employee_list = $this->employeemodel->getAllEmployee($status);

        $data['employee'] = $employee_list;
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        $data['company_master'] = $this->companymodel->getCompaniesHavingOfficeType();
        $data['departments'] = $this->companymodel->getDepartments();
        $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
        $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
        $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
        $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);
        $this->load->view('default/clientadmin/cadmin_employee_list', $data);
    }

    function addrelationship() {
        $data = array();
        $status = '1';
        $grade_status = '1';
        $designation_status = '1';
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        $data['employee'] = $this->employeemodel->getAllEmployee($status);
        $data['grades_with_designation'] = $this->companymodel->getGradesWithDesignation($grade_status, $designation_status);
        //$data['designation']        = $this->companymodel->getGrades($status);

        $data['header'] = $this->load->view('default/clientadmin/cadmin_header', '', true);
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
        $data['company_master'] = $this->companymodel->getCompaniesHavingOfficeType();
        $data['departments'] = $this->companymodel->getDepartments();
        $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
        $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
        $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
        $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);
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

}

