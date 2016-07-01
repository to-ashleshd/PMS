<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Apraisee extends CI_Controller {


    function __construct() {
        parent::__construct();
         $this->load->model('generalesettings');
         $this->load->model('employeemodel');
         $this->load->model('commonmodel');
         $this->load->model('companymodel');
         $this->load->model('apraiseemodel');
         $this->load->model('apraisermodel');
         $this->load->model('taskschedulemodel');
    }

    public function index($tab = '', $tabid = '') {
       
        //$this->employee();
       
    }

    
    function addkra($year='')
    {
        if ($this->session->userdata('pms_employee_id')) {
             
            $data = array();
                if($year=='')
                    {
                        $data['year'] =  "Page Not Found. ( Invalid Year ) ";die();
                    }
                else{
                    
                $data['site_name']          = $this->generalesettings->getSiteName();
                $data['logo']               = $this->generalesettings->getImage();
                if($year=='1')
                {
                    $data['kra_detail']     = $this->apraiseemodel->getEmployeeKraById($this->session->userdata('pms_employee_id'),$year);
                }
                
                $pms_employee_id                   = $this->session->userdata('pms_employee_id');
                $time_period_id                    = '1';
                $data['s_date_format']      = $this->commonmodel->get_env_setting('s_date_format');
                $data['top_employee_detail']           = $this->employeemodel->getEmployeeDetailsById($pms_employee_id,$time_period_id);
                $data['top_employee_apraiser_detail']  = $this->employeemodel->getEmployeeApraiserAndReviewer($pms_employee_id,$time_period_id);
                $data['topmenu']            = $this->topmenu->apraiseemenulist();
                $data['header']             = $this->load->view('default/clientadmin/cadmin_header', $data);

                $data['common_js'] =$this->load->view('default/clientadmin/cadmin_common_js', $data);
                $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
                $this->load->view('default/clientadmin/cadmin_addkra', $data);
                }
                
                
                
        }else
          {
              redirect('clientadmin','refresh');
          }
    }
    
    function addpms($year='')
    {
        if($this->session->userdata('pms_employee_id')) {
          
        if($year=='')
        {
            echo "Page Not Found. ( Invalid Year ) ";die();
        }
        else
        {
        $pms_employee_id            = $this->session->userdata('pms_employee_id');
        $data = array();
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
        $time_period_id             = $year;
        $time_period_detail         = $this->taskschedulemodel->getTimeperiodById($time_period_id);
        $apraisee_kra_detail        = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id,$year);
        $submit_status              = '0';
        $data['s_date_format']      = $this->commonmodel->get_env_setting('s_date_format');
        $data['top_employee_detail']    = $this->employeemodel->getEmployeeDetailsById($pms_employee_id,$time_period_id);
        $data['top_employee_apraiser_detail']  = $this->employeemodel->getEmployeeApraiserAndReviewer($pms_employee_id,$time_period_id);
        if(!empty($apraisee_kra_detail))
        {
            foreach($apraisee_kra_detail as $key=>$val)
            {
                $submit_status = $val['submit_status'];
            }
        }
       
            if(empty($time_period_detail))
            {
                $data['error']           = "Page Not Found.";
            }
            elseif($submit_status < 1)
            {
                $data['error']           = "Please Fill Up KRA First.";
            }
            else{
                    if($submit_status >= 2)
                    {
                        $data['pms_detail']      = $this->apraisermodel->getApraiseeKraPmsDetail($pms_employee_id);
                    }
                    else
                    {
                        $data['kra_detail']      = $this->apraiseemodel->getEmployeeKraById($pms_employee_id,$time_period_id);
                    }
                }
               
                
                $data['topmenu']            = $this->topmenu->apraiseemenulist();
                $data['all_ratings']        = $this->taskschedulemodel->getAllRatimgs('1');
                $data['header']             = $this->load->view('default/clientadmin/cadmin_header', $data,true);
                $data['middle_footer']      = $this->load->view('default/clientadmin/cadmin_middle_footer', $data,true);
                $data['common_js']          = $this->load->view('default/clientadmin/cadmin_common_js', $data,true);
                $data['last_footer']        = $this->load->view('default/clientadmin/cadmin_last_footer','',true);
                $this->load->view('default/clientadmin/cadmin_addpms', $data);
                
        }
        
        
        }else
          {
            redirect('clientadmin','refresh');
          }
    }
    
    
    
    function addpmsdata(){
      $data = array();
      
      if($this->session->userdata('pms_employee_id')) {
         
          $rating = array();
          $comment = array();
          $kra_id = '';
          
        if(!empty($_POST))
        {
          
            foreach($_POST as $key=>$val)
            {
               
                $kra_id_detail      = explode('_', $key);
                $kra_id             = $kra_id_detail[1];
                if($kra_id_detail[0]=='rating')
                {
                    $rating[$kra_id]        = $val;
                }
                else
                {
                    $comment[$kra_id]       = $val;
                }
            }
             
            
            foreach($rating as $key=>$val)
            {
                
                $kra_id         = $key;
                $kra_detail     = $this->apraiseemodel->getApraiseeKraById($kra_id);
                $comment_desc   = '';
                //$employee_relationship_materix_ids = array();
                if(array_key_exists($kra_id, $comment))
                {
                    $comment_desc  = $comment[$kra_id];
                }
                
                $employee_relationship_materix_id = $kra_detail['employee_relationship_materix_id'];
                
                $data[]         = array(
                    'pms_employee_id'                   => $this->session->userdata('pms_employee_id'),
                    'time_period_id'                    => $kra_detail['time_period_id'],
                    'apraisee_kra_id'                   => $kra_id,
                    'rating_id'                         => $val,
                    'comment'                           => $comment_desc,
                    'employee_relationship_materix_id'  => $kra_detail['employee_relationship_materix_id']
                );
        
            }
             
            $result = $this->apraiseemodel->addPms($data);
            
            //update relationship materix status
            $this->apraiseemodel->UpdateRelationshipStatus($employee_relationship_materix_id,'2');
            
            if($result){ echo "PMS Submitted Successfully"; }
            else{ echo "Please try again"; }
            
        }
        
       
    }
    }
    
    function getpmsdetail()
    {
        $response = array();
        $pms_employee_id         = $this->input->post('pms_employee_id',true);
        $response['pms_detail']      = $this->apraisermodel->getApraiseeKraPmsDetail($pms_employee_id);
        die(json_encode($response));
    }
    
    
    function addidp($year='')
    {
        if($this->session->userdata('pms_employee_id')) {
        $time_period_id = '';
        if($year=='')
        {
            $data['error']      =  "Page Not Found. ( Invalid Year ) ";
        }
        else
        {
        $data = array();
        $pms_employee_id            = $this->session->userdata('pms_employee_id');
        
        $employee_grade_id          = '0';
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
        
        $time_period_id             = $year;
        $data['time_period_id']     = $time_period_id;
        $time_period_detail         = $this->taskschedulemodel->getTimeperiodById($time_period_id);
        
        $data['s_date_format']      = $this->commonmodel->get_env_setting('s_date_format');
        $data['top_employee_detail']    = $this->employeemodel->getEmployeeDetailsById($pms_employee_id,$time_period_id);
        $data['top_employee_apraiser_detail']  = $this->employeemodel->getEmployeeApraiserAndReviewer($pms_employee_id,$time_period_id);
        
        $employee_detail            = $this->employeemodel->getEmployeeById($pms_employee_id);
        if(!empty($employee_detail))
        {
            $employee_grade_id      = $employee_detail->grade_id;
        }
        
        $data['competencies_for_refrence']    = $this->commonmodel->getCompetenciesByGrade($employee_grade_id);
        
        $apraisee_relationship_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id,$year);
        
        $submit_status              = '0';
        if(!empty($apraisee_relationship_detail))
        {
            foreach($apraisee_relationship_detail as $key=>$val)
            {
                $submit_status = $val['submit_status'];
            }
        }
        //echo$submit_status; die();
            if(empty($time_period_detail))
            {
                $data['error']           = "Page Not Found.";
            }
            elseif($submit_status < 1)
            {
                $data['error']           = "Please Fill Up Kra & PMS First.";
            }
            elseif($submit_status < 2)
            {
                $data['error']           = "Please Fill Up PMS First.";
            }
            elseif($submit_status >= 3){
                
                        $data['idp_detail']      = $this->apraiseemodel->getAllIdpsOfApraisee($pms_employee_id);
                }
                $data['topmenu']            = $this->topmenu->apraiseemenulist();
                $data['header']             = $this->load->view('default/clientadmin/cadmin_header', $data,true);
                $data['middle_footer']      = $this->load->view('default/clientadmin/cadmin_middle_footer', $data,true);
                $data['common_js']          = $this->load->view('default/clientadmin/cadmin_common_js', $data,true);
                $data['last_footer']        = $this->load->view('default/clientadmin/cadmin_last_footer','',true);
                $this->load->view('default/clientadmin/cadmin_idp', $data);
        }
        
        
        }else
          {
            redirect('clientadmin','refresh');
          }
    }
 
    
    public function addidpdata()
    {
       
       $data = array();
       $employee_relationship_materix_id = '0';
       $year = '1';
       if($this->session->userdata('pms_employee_id'))
       {
          
          $pms_employee_id = $this->session->userdata('pms_employee_id');
          $employee_reationship_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id,$year);
          if(!empty($employee_reationship_detail))
          {
            $employee_relationship_materix_id         = $employee_reationship_detail[0]['employee_relationship_materix_id'];
          }
          if(!empty($_POST['invE_item']))
          {
                $i = 1;
                $j=0;
                foreach($_POST['invE_item'] as $key=>$val)
                {
                    if(trim($val)!='')
                    {
                        $j++;
                        $data  = array(
                            'pms_employee_id'                      => $pms_employee_id, 
                            'time_period_id'                       => $_POST['time_period_id'],
                            'development_area'                     => ucfirst($val),
                            'sort_order'                           => $i,
                            'employee_relationship_materix_id'     => $employee_relationship_materix_id,
                            'date_created'                         => date('Y-m-d'),
                            'ip_address'                           => $this->input->ip_address()
                        );
                        $result = $this->apraiseemodel->addIdpData($data);
                        $i++;
                    }
                }
            if($j>=0)
            {
             //update relationship materix status
            $this->apraiseemodel->UpdateRelationshipStatus($employee_relationship_materix_id,'3');
            }
            
            if($result){ echo "IDP Data Submitted Successfully"; }
            else{ echo "Please try again"; }
                
                
          }
        }
      }
    
    
}

