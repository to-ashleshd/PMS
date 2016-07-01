<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employee extends CI_Controller {


    function __construct() {
        parent::__construct();
       //  $this->dashboard();
         $this->load->model('generalesettings');
         $this->load->model('employeemodel');
         $this->load->model('commonmodel');
         $this->load->model('companymodel');
         
       /**  if($this->session->userdata('pms_employee_id')) 
         {
             if($this->session->userdata('pms_employee_id')!='1')
             {
                 redirect('clientadmin','refresh');
             }
         }
         else
         {
             redirect('clientadmin','refresh');
         }
        **/
         
       /** @param type $tab
        * @param type $tabid 
        */
    }

    public function index($tab = '', $tabid = '') {
       
        $this->employee();
       
    }
    
   function addemployeedata()
   {
       $data = array();
      
         $login_name ='';

          $this->load->helper('security');
          $password = do_hash(trim($this->input->post('password')), 'md5');
          
          $login_name = $this->input->post('email');
          
            $data = array(
                    'fname'             => ucfirst($this->input->post('fname')),
                    'mname'             => ucfirst($this->input->post('mname')),
                    'lname'             => ucfirst($this->input->post('lname')),
                    'login_name'        => $login_name,
                    'login_type'        => '',
                    'employee_id'       => $this->input->post('employeeid'),
                    'email'             => $this->input->post('email'),
                    'password'          => $password,
                    'gender'            => $this->input->post('gender'),
                    'date_of_birth'     => date('Y-m-d', strtotime($this->input->post('date_of_birth'))),
                    'company_master_id'  => $this->input->post('office_add_company'),
                    'office_address_id' => $this->input->post('offices_address'),
                    'department_id'     => $this->input->post('department'),
                    'designation_id'    => $this->input->post('designation'),
                    'is_verified'       => '1',
                    'user_status'       => '1',
                    'mobile_no'         => $this->input->post('mobile_no'),
                    'date_created'      => date('Y-m-d'),
                    'date_of_joining'   => date('Y-m-d', strtotime($this->input->post('date_of_joining'))),
                    'last_updated'      => date('Y-m-d'),
                    'ip_address'        => $this->input->ip_address()
                );
                $result =$this->employeemodel->add_employee($data);
                if($result){ echo "Employee added successfully"; }
                else{ echo "Please try again"; }
       
   }
    
    function addemployee()
    {
        if ($this->session->userdata('clientadmin_id')) {
            
        $this->load->model('companymodel');
        $data = array();
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
        $data['company_master']     = $this->companymodel->getCompaniesHavingOfficeType();
        $data['departments']        = $this->companymodel->getDepartments();
        $data['designations']        = $this->companymodel->getDesignations();
      
        $data['s_date_format']      = $this->commonmodel->get_env_setting('s_date_format');
        $data['current_date']       = date($data['s_date_format']);
        $data['js_date_format']     = get_datepicker_date2($data['s_date_format']);
        $data['req_pwd_strength'] = $this->commonmodel->get_env_setting('ui_slider3_sel');
       
        $data['topmenu']            = $this->topmenu->apraiseemenulist();
        $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data ,true);
        
        $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data,true);
        $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data,true);
        $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
        $this->load->view('default/clientadmin/cadmin_addemployee', $data);
          }else
          {
               redirect('clientadmin','refresh');
          }
        
    }
   //foremployeelist
   function employee()
    {
        
         $status ='1';
         $data = array();
         $data['s_date_format']      = $this->commonmodel->get_env_setting('s_date_format');
         $employee_list              = $this->employeemodel->getAllEmployee($status);
        
        $data['employee']           = $employee_list;
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
        $data['company_master']     = $this->companymodel->getCompaniesHavingOfficeType();
        $data['departments']        = $this->companymodel->getDepartments();
        $data['topmenu']            = $this->topmenu->apraiseemenulist();
        $data['header']             = $this->load->view('default/clientadmin/cadmin_header', $data,true);
        $data['middle_footer']      = $this->load->view('default/clientadmin/cadmin_middle_footer', $data,true);
        $data['common_js']          = $this->load->view('default/clientadmin/cadmin_common_js', $data,true);
        $data['last_footer']        = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);
        $this->load->view('default/clientadmin/cadmin_employee_list', $data);
       
    }
   
    
    function addrelationship()
    {
        $data = array();
        $status='1';
        $grade_status ='1';
        $designation_status='1';
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
        $data['employee']           = $this->employeemodel->getAllEmployee($status);
        $data['grades_with_designation'] = $this->companymodel->getGradesWithDesignation($grade_status,$designation_status);
        
        $data['topmenu']            = $this->topmenu->apraiseemenulist();
        $data['header']             = $this->load->view('default/clientadmin/cadmin_header', $data ,true);
        $data['middle_footer']      = $this->load->view('default/clientadmin/cadmin_middle_footer', $data,true);
        $data['common_js']          = $this->load->view('default/clientadmin/cadmin_common_js', $data,true);
        $data['last_footer']        = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
        $this->load->view('default/clientadmin/cadmin_relationship_materix', $data);
    }
    
    function relationship()
    {
        $status ='1';
        $data = array();
        $data['s_date_format']      = $this->commonmodel->get_env_setting('s_date_format');
        $employee_list              = $this->employeemodel->getRelationshipDetails();
      
        $data['employee']           = $employee_list;
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
       // $data['company_master']     = $this->companymodel->getCompaniesHavingOfficeType();
       // $data['departments']        = $this->companymodel->getDepartments();
        
        $data['topmenu']            = $this->topmenu->apraiseemenulist();
       
        $data['header']             = $this->load->view('default/clientadmin/cadmin_header', $data,true);
        $data['middle_footer']      = $this->load->view('default/clientadmin/cadmin_middle_footer', $data,true);
        $data['common_js']          = $this->load->view('default/clientadmin/cadmin_common_js', $data,true);
        $data['last_footer']        = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);
        $this->load->view('default/clientadmin/cadmin_relationship_materix_list', $data);
    }
    
    function getsupergrades()
    {
        $response             = array();
        $response['grade']    = array();
        $employee_grade_id    = $this->input->post('employee_grade_id',true);
        $grade_status         = '1';
        $designation_status   = '1';
        $grade_deatil         = $this->companymodel->getSuperiorGradesWithDesignation($employee_grade_id,$grade_status,$designation_status);
        if(!empty($grade_deatil))
        {
            foreach($grade_deatil as $key=>$val)
            {
                $response['grade'][] = array('grade_id'=>$val['grade_id'],'grade_name'=>$val['grade_name'],'designation_id'=>$val['designation_id'],'designation_name'=>$val['designation_name']);
            }
        }
        die(json_encode($response['grade']));
    }
    

}

