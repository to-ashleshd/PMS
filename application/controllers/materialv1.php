<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Materialv1 extends CI_Controller {

    function __construct() {
        parent::__construct();
    
    }

    public function index() {
        $this->load->view('materialv1/dashboard');

        //$this->employee();
    }
    public function changepassword() {
        $this->load->view('materialv1/clientadmin/pms-changepass');

    }
    public function profile() {
        $this->load->view('materialv1/clientadmin/pms_profile');

    }
    public function generalsetting() {
        $this->load->view('materialv1/clientadmin/general_setting');

    }
	 public function addemployee() {
     $data = array();
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
        $this->load->view('materialv1/addemployee', $data);
    }
         
}

