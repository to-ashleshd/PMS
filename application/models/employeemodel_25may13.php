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
       $this->db->order_by("employee.fname", "ASC");
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
    
    
    function get_employees_having_permission($time_period_id)
    {
       $pms_employee_ids = array();
       $this->db->select('pms_employee_id');
       $this->db->distinct('pms_employee_id');
       $this->db->from($this->db->dbprefix . 'employee_relationship_materix' );
       $this->db->where('time_period_id', $time_period_id);
       $this->db->order_by('pms_employee_id','ASC');
       $query = $this->db->get();
       $row = $query->result_array();
       if(!empty($row))
       {
           foreach($row as $key=>$val)
           {
              $pms_employee_ids[] =  $val['pms_employee_id'];
           }
           
       }
       return $pms_employee_ids;
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
        $apraiser_designatoion  = 'N.A.';
        $reviewer_employee_name = 'N.A.';
        $reviewer_designatoion  = 'N.A.';
        
        $time_period_id             = '';
        //        echo "<pre>";
//        print_r($all_relationship);
//        echo "</pre>";
//        die();
        $time_period_detail         = $this->commonmodel->get_current_year();
        if(!empty($time_period_detail))
        {
            $time_period_id             = $time_period_detail['time_period_id'];
        }
       // $all_relationship = $this->getAllRelationship($time_period_id);
        $pms_employee_ids  = $this->get_employees_having_permission($time_period_id);
        
       
        
        if(!empty($pms_employee_ids))
        { 
            //echo "<pre>";
            foreach($pms_employee_ids as $key=>$val)
            {
                $all_relationship = array();
                $all_relationship = $this->get_relationship_of_employee($val,$time_period_id);
              
                $emp_details  = $this->getEmployeeById($val);
                $employee_name = '';
                $employee_designation_name = '';
                  
                $employee_name  = $emp_details->fname.' '.$emp_details->lname;
                $employee_designation_name = $emp_details->designation_name;
                
                
                 $relationship_details[$val] = array(
                        'sr_no'                             => $key+1,
                        'pms_employee_id'                   => $val,
                        'employee_name'                     => $employee_name,
                        'employee_designatoion'             => $employee_designation_name);
                $apraiser_list = array();
                $reviewer_list = array();
                
               // print_r($all_relationship);
                if(!empty($all_relationship))
                {
                foreach($all_relationship as $key1=>$val1)
                {
                    $apraiser_employee_name = '';
                    $apraiser_designatoion = '';
                    $reviewer_employee_name = '';
                    $reviewer_designatoion = '';
                    
                    if($val!='1')
                    {

                    $apraiser_emp_details = $this->getEmployeeById($val1['apraiser_employee_id']);
                    $reviewer_emp_details = $this->getEmployeeById($val1['reviewer_employee_id']);
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
                    $update_function = '';
                if($key1=='0')
                {
                    $update_function = 'call_editable_row(\''.$val1['employee_relationship_materix_id'].'\',\''.$val.'\')';
                }
                else
                {
                     $update_function = 'call_editable_row_without_reviewer(\''.$val1['employee_relationship_materix_id'].'\',\''.$val.'\')';
                }
                
                 $apraiser_list[$val1['employee_relationship_materix_id']]  = array(
                          'apraiser_id'             => $val1['apraiser_employee_id'],
                          'apraiser_name'           => $apraiser_employee_name,
                          'apraiser_disignation'    => $apraiser_designatoion,
                          'update_function'         => $update_function
                     );
                       
                 $reviewer_list[$val1['employee_relationship_materix_id']]  = array(
                            'reviewer_id'               => $val1['reviewer_employee_id'],
                            'reviewer_name'             => $reviewer_employee_name,
                            'reviewer_designatoion'     => $reviewer_designatoion
                    );
                
                 }
             }
                }
             $relationship_details[$val]['apraiser_list'] = $apraiser_list;
             $relationship_details[$val]['reviewer_list'] = $reviewer_list;
             
            
            } //print_r($relationship_details);
           
        }
       //die();
//        echo "<pre>";
//        print_r($relationship_details);
//        echo "</pre>";die();
        
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
        //Change condition < to <= to get Appraiser and Reviewer for same grade 21-May-13 - Ajay
       
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee' );
       if($status!='')
       {
            $this->db->where('user_status',trim($status));
       }
       $this->db->join($this->db->dbprefix . 'designation', 'designation.designation_id = employee.designation_id','left');
       $this->db->where('designation.grade_id <=',$grade_id);
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
    
    
    //Added By Ajay
    function updateUserMeta($user_id, $key, $val) {

        //here for loop of meta key comes
        if ($this->getUserMeta($user_id, $key)) {
            //update
            $array = array('meta_value' => $val);
            $this->db->where('pms_employee_id', $user_id);
            $this->db->where('meta_key', $key);
            $this->db->update($this->db->dbprefix . 'employee_meta', $array);
        } else {
            //insert
            $array = array('pms_employee_id' => $user_id, 'meta_key' => $key, 'meta_value' => $val);
            $this->db->set($array);
            $this->db->insert($this->db->dbprefix . 'employee_meta');
        }
    }

    function getUserMeta($user_id, $key) {

        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'employee_meta');

        $this->db->where('meta_key', trim($key));
        $this->db->where('pms_employee_id', $user_id);
        $query = $this->db->get();

        $result = $query->first_row();
        if (empty($result)) {
            return FALSE;
        } else {
            return $result;
        }
    }
    
    
    function  get_employee_by_name($employee_name)
    {
       $sql = "SELECT pms_employee_id,fname,mname,lname,email,gender,company_master_id,office_address_id,department_id,pms_employee.designation_id,designation_name FROM ".$this->db->dbprefix . "employee";
        $sql .= " LEFT JOIN ".$this->db->dbprefix . "designation on (".$this->db->dbprefix ."designation.designation_id = ".$this->db->dbprefix ."employee.designation_id)";
        $sql .= "WHERE 1 ";
        $user_name = trim($employee_name);
        if($user_name!='')
        {
            $sql .= "AND (LCASE(CONCAT(fname, ' ', lname)) LIKE '" .$this->db->escape_like_str(strtolower($user_name))."%' OR LCASE(CONCAT(lname, ' ', fname)) LIKE '" .$this->db->escape_like_str(strtolower($user_name))."%' )";
        }
        
        $query = $this->db->query($sql);
        $row = $query->result_array();
       
       return $row;
    }
    
    
    function get_last_promotions($pms_employee_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee_last_promotions' );
       $this->db->order_by('employee_last_promotions_id','ASC');
       $this->db->where('employee_last_promotions.pms_employee_id', $pms_employee_id);
       $this->db->join($this->db->dbprefix . 'employee', 'employee.pms_employee_id = pms_employee_last_promotions.pms_employee_id','left');
       $this->db->join($this->db->dbprefix . 'designation', 'designation.designation_id = pms_employee_last_promotions.designation_id','left');
       $this->db->join($this->db->dbprefix . 'grade', 'grade.grade_id = pms_designation.grade_id','left');
       $query = $this->db->get();
       $row = $query->result_array();
//       echo "<pre>";
//       print_r($row);
//       echo "</pre>";die();
       return $row;
       
    }
    
    
    function add_employee_last_promotion($data = array())
    {
        $result = $this->db->insert($this->db->dbprefix . 'employee_last_promotions', $data);
        return $this->db->insert_id();
    }
    
    
    function get_last_promotion_by_id($last_promotion_id)
    {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'employee_last_promotions');
        $this->db->where('employee_last_promotions_id',$last_promotion_id);
        $this->db->join($this->db->dbprefix . 'employee', 'employee.pms_employee_id = employee_last_promotions.pms_employee_id','left');
        $this->db->join($this->db->dbprefix . 'designation', 'designation.designation_id = employee_last_promotions.designation_id','left');
        $this->db->join($this->db->dbprefix . 'grade', 'grade.grade_id = designation.grade_id','left');
        $query = $this->db->get();
        $result = $query->first_row('array');
        return $result;
    }
    
    function update_employee_data($pms_employee_id,$data= array())
    {
      $this->db->where('pms_employee_id',$pms_employee_id);
      $this->db->update($this->db->dbprefix .'employee',$data);
    }
    
    function get_relationship_of_employee($pms_employee_id,$time_period_id)
    {
         $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee_relationship_materix' );
       $this->db->where('time_period_id', $time_period_id);
       $this->db->where('pms_employee_id', $pms_employee_id);
       $this->db->order_by('pms_employee_id','ASC');
       $query = $this->db->get();
       $row = $query->result_array();
       return $row;
    }
    
    
    
}