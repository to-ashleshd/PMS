<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Topmenu {

    function __construct() {

        $this->CI = & get_instance();
        $this->CI->load->model('generalesettings');
        $this->CI->load->model('employeemodel');
        $this->CI->load->model('commonmodel');
        $this->CI->load->model('companymodel');
        $this->CI->load->model('taskschedulemodel');
        $this->CI->load->model('apraisermodel');
        $this->CI->load->model('reviewermodel');
    }

    public function index() {

        //$this->apaiseemenulist();
    }

    function apraiseemenulist() {
        $data = array();
        $status = '1';
        $data['dashboard_link'] = site_url('clientadmin/dashboard');
        $data['time_period_list'] = $this->CI->taskschedulemodel->getTimePeriod($status);
        $pms_employee_id = '0';
        $start_time_period_date = '';
        if ($this->CI->session->userdata('pms_employee_id')) {
            $pms_employee_id = $this->CI->session->userdata('pms_employee_id');
        }

        $employee_details = $this->CI->employeemodel->getEmployeeById($pms_employee_id);


        if (!empty($employee_details)) {
            $start_time_period_detail = $this->CI->taskschedulemodel->getTimeperiodById($employee_details->start_time_period_id);
            if (!empty($start_time_period_detail)) {
                $start_time_period_date = $start_time_period_detail->time_period_from;
            }
        }


        $data['time_periods'] = $this->CI->taskschedulemodel->get_downgrade_time_period_list($start_time_period_date);
        //Get all timeperiods
        $data['all_time_periods'] = $this->CI->taskschedulemodel->getTimePeriod();



        $employee_list = $this->CI->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');
        if (!empty($employee_list)) {
            $data['is_employee_apraiser'] = 'Y';
        } else {
            $data['is_employee_apraiser'] = 'N';
        }

        $reviewer_employee_list = $this->CI->reviewermodel->getEmployeeApriseelist($pms_employee_id, '1');

        if (!empty($reviewer_employee_list)) {
            $data['is_employee_reviewer'] = 'Y';
        } else {
            $data['is_employee_reviewer'] = 'N';
        }

        // echo $data['is_employee_reviewer'];die();


        $topmenu = $this->CI->load->view('default/clientadmin/cadmin_topmenu', $data, true);
        return $topmenu;
    }

    /** Supporting functin * */
    public function no_cache() {
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
    }

}

