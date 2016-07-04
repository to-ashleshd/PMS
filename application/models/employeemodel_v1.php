<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Employeemodel extends CI_Model {

    function __construct() {
        parent::__construct();
        
    }

    function add_employee($data = array()) {
        //dbprefix
        $result = $this->db->insert($this->db->dbprefix . 'employee', $data);
        return $result;
    }


    function add_employee_relationship($data = array()) {
        //dbprefix
        $result = $this->db->insert($this->db->dbprefix . 'employee_relationship_materix', $data);
        return $result;
    }


    
  
    //start employeemodel
     function getEmployeeByEmail($login_name)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee' );
       $this->db->where('login_name',trim($login_name));
       $query = $this->db->get();
       $row = $query->first_row();
       return $row;
    }
    
    function getEmployeeById($employee_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix.'employee');
       $this->db->where('pms_employee_id',trim($employee_id));
       $this->db->join($this->db->dbprefix .'designation', 'designation.designation_id = employee.designation_id','left');
       $query = $this->db->get();
       $row = $query->first_row();
       //echo $this->db->last_query();die();
       return $row;
    }
    
    
    function getAllEmployee()
    {
       $employee_list = array();
       $status ='1';
       $this->load->model('commonmodel');
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee' );
       $this->db->where('user_status',trim($status));
       $this->db->where('pms_employee_id !=','1');
       $this->db->join($this->db->dbprefix . 'designation', 'designation.designation_id = employee.designation_id','left');
       $this->db->order_by("designation.sort_order", "ASC");
       $query = $this->db->get();
       $employee_detail = $query->result_array();
       $data['s_date_format']      = $this->commonmodel->get_env_setting('s_date_format');
        if(!empty($employee_detail))
        {
            foreach($employee_detail as $key=>$val)
            {
                $designation_name   = '';
                $grade_id           = '';
                $grade_name         = '';
                $department_name    = '';
                $designation_detail = $this->companymodel->getDesignationById($val['designation_id']);
                $grade_detail       = $this->companymodel->getGradeByDesignationId($val['designation_id']);
                $department_detail  = $this->companymodel->getDepartment($val['department_id']);
                
                if(!empty($department_detail))
                {
                    $department_name    = $department_detail->department_name;
                }
                
                if(!empty($designation_detail))
                {
                    $designation_name   = $designation_detail->designation_name;
                }
                
                if(!empty($grade_detail))
                {
                    $grade_id           = $grade_detail->grade_id;
                    $grade_name         = $grade_detail->grade_name;
                }
                
                $employee_list[] = array(
                    'pms_employee_id'     =>  $val['pms_employee_id'] ,
                    'employee_id'         =>  $val['employee_id'] ,
                    'employee_name'       =>  $val['fname'].' '.$val['lname'] ,
                    'fname'               =>  $val['fname'] ,
                    'mname'               =>  $val['mname'] ,
                    'lname'               =>  $val['lname'] ,
                    'designation_id'      =>  $val['designation_id'] ,
                    'department_id'       =>  $val['department_id'] ,
                    'grade_id'            =>  $grade_id,
                    'designation_id'      =>  $val['designation_id'] ,
                    'designation_name'    =>  $designation_name ,
                    'department_name'     =>  $department_name ,
                    'grade_name'          =>  $grade_name ,
                    'date_of_joining'     =>  date( $data['s_date_format'],  strtotime($val['date_of_joining']))
                );
            }
        }
       //return $row;
        return $employee_list;
    }
    
    
    function getAllRelationship($time_period_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee_relationship_materix' );
       $this->db->where('time_period_id', $time_period_id);
       $this->db->order_by('pms_employee_id','ASC');
       $query = $this->db->get();
       $row = $query->result_array();
       return $row;
    }
    
    
    function getAllRelationshipbyemployeegroup($time_period_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee_relationship_materix' );
       $this->db->where('time_period_id', $time_period_id);
       $query = $this->db->get();
       $row = $query->result_array();
       return $row;
    }
    
    function get_all_relationship($time_period_id)
    {
//        if($this->session->userdata('pms_employee_id')=='1')
//        {
//            $employee_details = $this->getEmployeeById($this->session->userdata('pms_employee_id'));
//            if($employee_details[''])
//            
//        }
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee_relationship_materix' );
       $this->db->where('time_period_id', $time_period_id);
       $query = $this->db->get();
       $row = $query->result_array();
       return $row;
    }
    
    function getRelationshipDetails()
    {
        $relationship_details = array();
        $apraiser_employee_name = 'N.A.';
        $apraiser_designatoion  = '';
        $reviewer_employee_name = 'N.A.';
        $reviewer_designatoion  = '';
        
        $time_period_id             = '';
        
        $time_period_detail         = $this->commonmodel->get_current_year();
        if(!empty($time_period_detail))
        {
            $time_period_id             = $time_period_detail['time_period_id'];
        }
        
        $all_relationship = $this->getAllRelationship($time_period_id);
//        echo "<pre>";
//        print_r($all_relationship);
//        echo "</pre>";
//        die();
        if(!empty($all_relationship))
        {
            $is_pms_employee_found = '';
            $isfound = '0';
            foreach($all_relationship as $key=>$val)
            {
                if($val['pms_employee_id']!='1')
                {
                  if($is_pms_employee_found==$val['pms_employee_id'])
                  {
                      $isfound = '1';
                  }
                  else
                  {
                      $is_pms_employee_found = $val['pms_employee_id'];
                      $isfound = '0';
                  }
                $emp_details  = $this->getEmployeeById($val['pms_employee_id']);
                $apraiser_emp_details = $this->getEmployeeById($val['apraiser_employee_id']);
                $reviewer_emp_details = $this->getEmployeeById($val['reviewer_employee_id']);
                if(!empty($apraiser_emp_details))
                {
                    $apraiser_employee_name  = $apraiser_emp_details->fname.' '.$apraiser_emp_details->lname;
                    $apraiser_designatoion   = $apraiser_emp_details->designation_name;
                }
                if(!empty($reviewer_emp_details))
                {
                    $reviewer_employee_name = $reviewer_emp_details->fname.' '.$reviewer_emp_details->lname;
                    $reviewer_designatoion  = $reviewer_emp_details->designation_name;
                }
                
                $employee_name = '';
                $employee_designation_name = '';
                if($isfound=='1')
                {
                    $employee_name = '';
                    $employee_designation_name = '';
                }
                else
                {
                        $employee_name  = $emp_details->fname.' '.$emp_details->lname;
                        $employee_designation_name = $emp_details->designation_name;
                }
                $relationship_details[] = array(
                    'employee_relationship_materix_id'   => $val['employee_relationship_materix_id'],
                    'pms_employee_id'                   => $val['pms_employee_id'],
                    'employee_name'                     => $employee_name,
                    'employee_designatoion'             => $employee_designation_name,
                    'apraiser_employee_id'              => $val['apraiser_employee_id'],
                    'apraiser_employee_name'            => $apraiser_employee_name,
                    'apraiser_designatoion'             => $apraiser_designatoion,
                    'reviewer_employee_id'              => $val['reviewer_employee_id'],
                    'reviewer_employee_name'            => $reviewer_employee_name,
                    'reviewer_designatoion'             => $reviewer_designatoion
                );
                }
            }
        }
       
        
        return $relationship_details;
        
    }
    
    function getAllEmployeeIDs()
    {
       $status = '1';
       $this->db->select('pms_employee_id');
       $this->db->from($this->db->dbprefix . 'employee' );
       $this->db->where('user_status',trim($status));
       $query = $this->db->get();
       $row = $query->result_array();
       $employee_ids = array();
       if(!empty($row))
       {
           foreach($row as $key=>$val)
           {
             $employee_ids[] = $val['pms_employee_id'];
           }
       }
       return $employee_ids;
       
       
    }
      
    
    function getEmployeeDetailsById($employee_id,$time_period_id='')
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix.'employee');
       $this->db->where('pms_employee_id',trim($employee_id));
       $this->db->join($this->db->dbprefix .'designation', 'designation.designation_id = employee.designation_id','left');
       $this->db->join($this->db->dbprefix .'department', 'department.department_id = employee.department_id','left');
       $this->db->join($this->db->dbprefix .'office_addresses', 'office_addresses.office_addresses_id = employee.office_address_id','left');
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;
    }
    
    
    function getEmployeeApraiserAndReviewer($pms_employee_id,$time_period_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix.'employee_relationship_materix');
       $this->db->where('pms_employee_id',trim($pms_employee_id));
       $this->db->where('time_period_id',trim($time_period_id));
       $query = $this->db->get();
       $row = $query->result_array('array');
       $apraiser_name          = '';
       $apraiser_designation   = 'N.A.';
       $reviewer_name          = '';
       $reviewer_designation   = 'N.A.';
       
       if(!empty($row))
       {
           foreach($row as $key=>$val)
           {
           $apraiser_detail =   $this->getEmployeeById($val['apraiser_employee_id']);
           if(!empty($apraiser_detail))
           {
               $apraiser_name        = $apraiser_detail->fname.' '.$apraiser_detail->lname; 
               $apraiser_designation = $apraiser_detail->designation_name;
           
                $reviewer_detail     =   $this->getEmployeeById($val['reviewer_employee_id']);
                if(!empty($reviewer_detail))
                {
                    $reviewer_name           =  $reviewer_detail->fname.' '.$reviewer_detail->lname;  
                    $reviewer_designation    =  $reviewer_detail->designation_name;
                }
           
            }
                $data[] = array(
                    'apraiser_name'        =>  $apraiser_name,
                    'apraiser_designation' =>  $apraiser_designation,
                    'reviewer_name'        =>  $reviewer_name,
                    'reviewer_designation' => $reviewer_designation
                );
            
           }
//           echo "<pre>";
//           print_r($data);
//           echo "</pre>";
//           die();
           return $data;
    }
    }  
    
    
    function get_employee_by_office_address_ids($office_address_id = array())
    {
       $this->load->model('commonmodel');
       $data                        = array();
       $employee_ids                = array();
       $employee_list               = array();
       $status                      = '1';
       $data['s_date_format']      = $this->commonmodel->get_env_setting('s_date_format');
       
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee' );
       $this->db->where('employee.user_status',trim($status));
       $this->db->where('pms_employee_id !=','1');
       $this->db->where_in('employee.office_address_id',$office_address_id);
       $this->db->join($this->db->dbprefix . 'designation', 'designation.designation_id = employee.designation_id','left');
       $this->db->order_by("designation.sort_order", "ASC");
       $query = $this->db->get();
       $employee_detail = $query->result_array();
        
       if(!empty($employee_detail))
        {
            foreach($employee_detail as $key=>$val)
            {
                $designation_name   = '';
                $grade_id           = '';
                $grade_name         = '';
                $department_name    = '';
                $designation_detail = $this->companymodel->getDesignationById($val['designation_id']);
                $grade_detail       = $this->companymodel->getGradeByDesignationId($val['designation_id']);
                $department_detail  = $this->companymodel->getDepartment($val['department_id']);
                
                if(!empty($department_detail))
                {
                    $department_name    = $department_detail->department_name;
                }
                
                if(!empty($designation_detail))
                {
                    $designation_name   = $designation_detail->designation_name;
                }
                
                if(!empty($grade_detail))
                {
                    $grade_id           = $grade_detail->grade_id;
                    $grade_name         = $grade_detail->grade_name;
                }
                
                $employee_list[] = array(
                    'pms_employee_id'     =>  $val['pms_employee_id'] ,
                    'employee_id'         =>  $val['employee_id'] ,
                    'employee_name'       =>  $val['fname'].' '.$val['lname'] ,
                    'fname'               =>  $val['fname'] ,
                    'mname'               =>  $val['mname'] ,
                    'lname'               =>  $val['lname'] ,
                    'designation_id'      =>  $val['designation_id'] ,
                    'department_id'       =>  $val['department_id'] ,
                    'grade_id'            =>  $grade_id,
                    'designation_id'      =>  $val['designation_id'] ,
                    'designation_name'    =>  $designation_name ,
                    'department_name'     =>  $department_name ,
                    'grade_name'          =>  $grade_name ,
                    'date_of_joining'     =>  date( $data['s_date_format'],  strtotime($val['date_of_joining']))
                );
            }
        }
       //return $row;
        return $employee_list;
    }
    
    
    function get_all_employee_permission()
    {
        $employee_ids = array('1,2,3');
    }
    
    function get_all_employee_for_relationship()
    {
        $relationship_details = array();
        $apraiser_employee_name = 'N.A.';
        $apraiser_designatoion  = '';
        $reviewer_employee_name = 'N.A.';
        $reviewer_designatoion  = '';
        
        $all_employees_id = $this->getAllEmployeeIDs();

        if(!empty($all_employees_id))
        {
            foreach($all_employees_id as $key=>$val)
            {
                if($val['pms_employee_id']!='1')
                {
                $emp_details  = $this->getEmployeeById($val['pms_employee_id']);
                $apraiser_emp_details = $this->getEmployeeById($val['apraiser_employee_id']);
                $reviewer_emp_details = $this->getEmployeeById($val['reviewer_employee_id']);
               
                $relationship_details[] = array(
                    'pms_employee_id'                   => $val['pms_employee_id'],
                    'employee_name'                     => $emp_details->fname.' '.$emp_details->lname,
                    'employee_designatoion'             => $emp_details->designation_name,
                    'apraiser_employee_id'              => $val['apraiser_employee_id'],
                    'apraiser_employee_name'            => $apraiser_employee_name,
                    'apraiser_designatoion'             => $apraiser_designatoion,
                    'reviewer_employee_id'              => $val['reviewer_employee_id'],
                    'reviewer_employee_name'            => $reviewer_employee_name,
                    'reviewer_designatoion'             => $reviewer_designatoion
                );
                }
            }
        }
       
        
        return $relationship_details;
        
    }
    
    
    function get_downgrade_employee_list($grade_id,$status='')
    {
       
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee' );
       if($status!='')
       {
            $this->db->where('user_status',trim($status));
       }
       $this->db->join($this->db->dbprefix . 'designation', 'designation.designation_id = employee.designation_id','left');
       $this->db->where('designation.grade_id <',$grade_id);
       $this->db->order_by("designation.sort_order", "ASC");
       $query = $this->db->get();
       
       $employee_detail = $query->result_array();
       return $employee_detail;
       //echo $this->db->last_query();
    }
    
    function get_employee_relationship($pms_employee_id,$time_period_id = '')
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix.'employee_relationship_materix');
       $this->db->where('pms_employee_id',trim($pms_employee_id));
       $this->db->where('time_period_id',trim($time_period_id));
       $query = $this->db->get();
       $row = $query->result_array();
       return $row;
    }
    
    
    function editrelationship($data= array(),$employee_relationship_materix_id)
    {
       $this->db->where('employee_relationship_materix_id',$employee_relationship_materix_id );
       $result = $this->db->update($this->db->dbprefix .'employee_relationship_materix',$data);
       return $result;
    }
    
    
    function get_employee_relationship_by_id($employee_relationship_materix_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee_relationship_materix' );
       $this->db->where('employee_relationship_materix_id', $employee_relationship_materix_id);
       //$this->db->order_by('pms_employee_id','ASC');
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;
    }
    
    
    function get_employee_by_id($employee_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix.'employee');
       $this->db->where('pms_employee_id',trim($employee_id));
       $this->db->join($this->db->dbprefix .'designation', 'designation.designation_id = employee.designation_id','left');
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;
    }
    
    
    function add_employee_track($data = array())
    {
         $result = $this->db->insert($this->db->dbprefix . 'employee_track_process', $data);
        return $result;
    }
    
}