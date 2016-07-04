<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Topmenu  {


    function __construct() {
        
         $this->CI =& get_instance();
         $this->CI->load->model('generalesettings');
         $this->CI->load->model('employeemodel');
         $this->CI->load->model('commonmodel');
         $this->CI->load->model('companymodel');
         $this->CI->load->model('taskschedulemodel');
         $this->CI->load->model('apraisermodel');
    }

    public function index() {
       
      //$this->apaiseemenulist();
       
    }
    
    function apraiseemenulist()
    {
       $data  = array();
       $status = '1';
       $data['dashboard_link']       =  site_url('clientadmin/dashboard');
       $data['time_period_list']     =  $this->CI->taskschedulemodel->getTimePeriod($status);
       $pms_employee_id              =  '0';
       if($this->CI->session->userdata('pms_employee_id'))
         {
               $pms_employee_id = $this->CI->session->userdata('pms_employee_id');
         }
         $employee_list = $this->CI->apraisermodel->getEmployeeApriseelist($pms_employee_id,'1');
         if(!empty($employee_list))
         {
             $data['is_employee_apraiser'] = 'Y';
         }
         else
         {
             $data['is_employee_apraiser'] = 'N';
         }
       $topmenu = $this->CI->load->view('default/clientadmin/cadmin_topmenu',$data,true) ;
       return $topmenu;
    }
    
    




}

