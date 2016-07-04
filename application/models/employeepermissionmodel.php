<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Employeepermissionmodel extends CI_Model {

    function __construct() {
        parent::__construct();
        
    }

    
    function getAllEmployee()
    {
       $employee_list = array();
       $status ='1';
       $this->load->model('commonmodel');
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee' );
       $this->db->where('user_status',trim($status));
      // $this->db->where('login_type','admin');
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
                $company_name       = '';
                $office_name        = '';
                $office_type        = '';
                $office_title       = '';
                $sub_office_list    = array();
            
                $designation_detail = $this->companymodel->getDesignationById($val['designation_id']);
                $grade_detail       = $this->companymodel->getGradeByDesignationId($val['designation_id']);
                $department_detail  = $this->companymodel->getDepartment($val['department_id']);
                
                $company_detail         = $this->companymodel->getCompany($val['company_master_id']);
                $office_address_detail  = $this->companymodel->getOfficeAddress($val['office_address_id']);
                //echo "<pre>";
                //echo $val['office_address_id'];echo "<br>";
                 //print_r($office_address_detail);//echo "<hr>";
                //die();
               
               
                if(!empty($office_address_detail))
                {
                    $office_name            = $office_address_detail->office_name;
                    $office_type_detail     = $this->companymodel->get_office_type_by_office_address($office_address_detail->office_type_id);
                   // print_r($office_type_detail);
                    $sub_office_list = array();
                    if(!empty($office_type_detail))
                    {
                        $sub_office_list        = $this->companymodel->get_sub_office_types($office_type_detail['company_master_id'],$office_type_detail['priority']);
                    }
                    //print_r($sub_office_list);
                    //echo "<hr>";
                }
                
               
                
                if(!empty($office_type_detail))
                {
                    $office_type        = $office_type_detail['office_type_name'];
                }
                
                $office_title       = $office_name.', '.$office_type;
                
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
                    'office_title'        =>  $office_title,
                    'sub_office_list'     =>  $sub_office_list,
                    'date_of_joining'     =>  date( $data['s_date_format'],  strtotime($val['date_of_joining']))
                );
            } //die();
        }
//        echo "<pre>";
//        print_r($employee_list);
//        echo "<pre>";
//        die();
       //return $row;
        return $employee_list;
    }
    

    
    function add_employee_permission($data= array())
    {
       $this->db->set_dbprefix('ecore_');
       $this->db->insert(ECOREPREFIX.'employee_permission', $data);
       $this->db->set_dbprefix('pms_');
       $id = $this->db->insert_id();
       return $id;
    }
    
    
    function add_employee_permission_mapping($data= array())
    {
         $this->db->set_dbprefix('ecore_');
         $result = $this->db->insert(ECOREPREFIX.'employee_permission_mapping', $data);
         $this->db->set_dbprefix('pms_');
         return $result;
    }
    
    
    function get_employee_permission($pms_employee_id)
    {
       $this->db->set_dbprefix('ecore_');
       $this->db->select('*');
       $this->db->from($this->db->dbprefix.'employee_permission');
       $this->db->where('employee_permission.pms_employee_id',trim($pms_employee_id));
       $query = $this->db->get();
       $row = $query->first_row('array');
       $this->db->set_dbprefix('pms_');
       return $row;
    }
    
    function get_employee_permissions()
    {
       $this->db->set_dbprefix('ecore_');
       $this->db->select('*');
       $this->db->from($this->db->dbprefix.'employee_permission');
       $this->db->order_by("pms_employee_id", "asc"); 
       $query = $this->db->get();
       $row = $query->result_array();
       $this->db->set_dbprefix('pms_');
       return $row;
    }
    
    
   /** not in use function get_employee_permission_offices($employee_permission_id)
    {
       $office_address_ids  = array();
       $this->db->set_dbprefix('ecore_');
       $this->db->select('office_address_id');
       $this->db->from($this->db->dbprefix.'employee_permission_mapping');
       $this->db->where('employee_permission_mapping.employee_permission_id',trim($employee_permission_id));
       $query = $this->db->get();
       $row = $query->result_array();
       //echo $this->db->last_query();die();
       if(!empty($row))
       {
           foreach($row as $key=>$val)
           {
               $office_address_ids[]  =   $val['office_address_id'];
           }
       }
       $this->db->set_dbprefix('pms_');
       
       return $office_address_ids;
    }
    **/
    
    function get_user_by_role($role_id = '',$pms_employee_id = array('0'))
    {
        $this->db->select('pms_employee_id');
        $this->db->distinct('pms_employee_id');
        $this->db->from($this->db->dbprefix.'v_userrole');
        $this->db->where('v_userrole.role_id',trim($role_id));
        $this->db->where_not_in('v_userrole.pms_employee_id',$pms_employee_id);
        $query = $this->db->get();
        $row = $query->result_array();
        return $row;    
    }
    
    
    function get_employees_having_permission_added()
    {
       $pms_employee_ids  = array();
       
       $this->db->set_dbprefix('ecore_');
       $this->db->distinct('pms_employee_id');
       $this->db->from($this->db->dbprefix.'employee_permission');
       $query = $this->db->get();
       $row = $query->result_array();
       if(!empty($row))
       {
           foreach($row as $key=>$val)
           {
               $pms_employee_ids[] =  $val['pms_employee_id'];
           }
       }
        $this->db->set_dbprefix('pms_');
       return $pms_employee_ids;
    }
    
    
  /** not in use  function get_company_by_business($business_id = '0')
    {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix.'business_to_company');
        $this->db->where('business_to_company.business_id',trim($business_id));
        $this->db->join($this->db->dbprefix .'company_master', 'company_master.company_master_id = business_to_company.company_master_id','left');
        $query = $this->db->get();
        $row = $query->result_array();
        return $row;    
    }
    
    
    function get_offices_by_company($company_master_id = '')
    {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix.'office_addresses');
        $this->db->where('office_addresses.company_master_id',trim($company_master_id));
        $query = $this->db->get();
        $row = $query->result_array();
        return $row; 
    }
    
    **/
    function get_all_active_company()
    {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix.'company_master');
        $this->db->where('company_master.status','1');
        $query = $this->db->get();
        $row = $query->result_array();
        return $row; 
    }
    
    
    function get_access_level_name($access_level_id  ='')
    {
        $access_name = '';
        if($access_level_id=='1')
        {
            $access_name = 'Function';
        }
        elseif($access_level_id=='2')
        {
            $access_name = 'Company';
        }
        elseif($access_level_id=='3')
        {
            $access_name = 'Office Type';
        }
        elseif($access_level_id=='4')
        {
            $access_name = 'Entire Group';
        }
        return $access_name;
    }
    
    function get_permission_detail($access_level_id,$employee_permission_id)
    {
     
        
        $details = array();
        if($access_level_id=='1')
        {
            $details = $this->get_selected_business_id($employee_permission_id);
        }
        else if($access_level_id=='2')
        {
            $details  = $this->get_selected_company_id($employee_permission_id);
        }
        else if($access_level_id=='3')
        {
            $details  = $this->get_selected_offices_id($employee_permission_id);
        }
        else if($access_level_id=='4'){
            $details = array('Entire group');
        }
       
        return $details;
    }
    
   /** 
    function get_access_level_function_name($access_level_id,$access_level_function_id)
    {
      
        $this->load->model('businessmodel');
        $this->load->model('companymodel');
        $access_function_name = '';
        if($access_level_id==1)
        {
            $business_detail = $this->businessmodel->get_business_by_id($access_level_function_id);
            if(!empty($business_detail))
            {
                $access_function_name = $business_detail['business_subject'];
            }
        }
        else if($access_level_id==2)
        {
            $company_detail = $this->companymodel->get_company_basic_detail($access_level_function_id);
            if(!empty($company_detail))
            {
                $access_function_name = $company_detail['company_name'];
            }
        }
        else if($access_level_id==3)
        {
         
            $office_type_detail = $this->companymodel->get_office_type_by_id($access_level_function_id);
            if(!empty($office_type_detail))
            {
                $access_function_name = $office_type_detail['office_type_name'];
            }
        }
        else if($access_level_id==4)
        {
             $access_function_name = 'Entire Group';
        }
        return $access_function_name;
    }
    **/
 
    /** function get_all_permission_mapping_by_id($employee_permission_id)
    {
        $this->load->model('companymodel');
        $company_ids  = $this->get_distinct_company_from_emp_perm_map($employee_permission_id);
       
       // $this->db->set_dbprefix('ecore_');
       
        $details   = array();
        if(!empty($company_ids))
        {
            foreach($company_ids as $key=>$val)
            {
                $company_name = '';
                $company_detail = $this->companymodel->get_company_basic_detail($val);
                if(!empty($company_detail))
                {
                    $company_name = $company_detail['company_name'];
                }
                $sql = 'SELECT * FROM '.ECOREPREFIX.'employee_permission_mapping'.'
                    LEFT JOIN '.$this->db->dbprefix .'company_master ON ('.$this->db->dbprefix .'company_master.company_master_id = '.ECOREPREFIX.'employee_permission_mapping.company_master_id )  
                    WHERE '. ECOREPREFIX.'employee_permission_mapping.employee_permission_id ="'.$employee_permission_id.'"
                    AND  '.ECOREPREFIX.'employee_permission_mapping.company_master_id ="'.$val.'"  ';
                
          
                $query = $this->db->query($sql);
                $row = $query->result_array();
                
                if(!empty($row))
                {
                    $details[$company_name] = array();
                    foreach($row as $key_r=>$val_r)
                    {
                        $office_address_detail  =  $this->companymodel->getOfficeAddress($val_r['office_address_id']);
                        $office_name = '';
                        if(!empty($office_address_detail))
                        {
                            $office_name = $office_address_detail->office_name;
                        }
                         $details[$val_r['company_name']][] = $office_name;
                    }
                }
                
            }
        }
       
        return $details;
       
    }
     **/
    
   /** function get_distinct_company_from_emp_perm_map($employee_permission_id)
    {
       $company_master_ids = array();
       $this->db->set_dbprefix('ecore_');
       $this->db->select('company_master_id');
       $this->db->distinct('company_master_id');
       $this->db->from($this->db->dbprefix.'employee_permission_mapping');
       $this->db->where('employee_permission_mapping.employee_permission_id',$employee_permission_id);
       $query = $this->db->get();
       $row = $query->result_array();
       if(!empty($row))
       {
           foreach($row as $key=>$val)
           {
               $company_master_ids[] =  $val['company_master_id'];
           }
       }
        $this->db->set_dbprefix('pms_');
        return $company_master_ids;
    }
    **/
    
   /** function get_distinct_office_type_from_emp_perm_map($employee_permission_id)
    {
       $office_type_ids = array();
       $this->db->set_dbprefix('ecore_');
       $this->db->select('office_type_id');
       $this->db->distinct('office_type_id');
       $this->db->from($this->db->dbprefix.'employee_permission_mapping');
       $this->db->where('employee_permission_mapping.employee_permission_id',$employee_permission_id);
       $query = $this->db->get();
       $row = $query->result_array();
       if(!empty($row))
       {
           foreach($row as $key=>$val)
           {
               $office_type_ids[] =  $val['office_type_id'];
           }
       }
      
        $this->db->set_dbprefix('pms_');
        return $office_type_ids;
    }
    **/ 
    
    
 /**   function get_details_emp_per_map_for_office_type($employee_permission_id)
    {
        $this->load->model('companymodel');
        $office_type_ids  = $this->get_distinct_office_type_from_emp_perm_map($employee_permission_id);
        //$this->db->set_dbprefix('ecore_');
       
        $details   = array();
        if(!empty($office_type_ids))
        {
            foreach($office_type_ids as $key=>$val)
            {
                $office_type_name = '';
                $office_type_detail = $this->companymodel->get_office_type_by_id($val);
                if(!empty($office_type_detail))
                {
                    $office_type_name = $office_type_detail['office_type_name'];
                }
                $sql = "SELECT * FROM ".ECOREPREFIX."employee_permission_mapping 
                        LEFT JOIN ".$this->db->dbprefix ."office_addresses ON  (".$this->db->dbprefix ."office_addresses.office_addresses_id=".ECOREPREFIX."employee_permission_mapping.office_address_id) 
                        WHERE ".ECOREPREFIX."employee_permission_mapping.employee_permission_id ='".$employee_permission_id."'
                        AND ".ECOREPREFIX."employee_permission_mapping.office_type_id ='".$val."'";
              
                $query = $this->db->query($sql);
                $row = $query->result_array();
              
                if(!empty($row))
                {
                    $details[$office_type_name] = array();
                    foreach($row as $key_r=>$val_r)
                    {
                         $details[$office_type_name][] = $val_r['office_name'];
                    }
                }
                
            }
        }
         $this->db->set_dbprefix('pms_');
         
         return $details;
    } **/
    
    function get_local_permission_detail($employee_permission_id)
    {
         $details = array();
         $details = $this->get_selected_offices_id($employee_permission_id);
         return $details;
    }
    
    function get_permission_by_employee_id($pms_employee_id)
    {
        $sql = "SELECT * FROM ".ECOREPREFIX."employee_permission WHERE pms_employee_id='".$pms_employee_id."'";
        $query = $this->db->query($sql);
        $row = $query->first_row('array');
        return $row;
    }
    
    /** function get_employee_permission_mapping_detail($employee_permission_id)
    {
       $sql = "SELECT * FROM ".ECOREPREFIX."employee_permission_mapping 
                        LEFT JOIN ".$this->db->dbprefix ."office_addresses ON  (".$this->db->dbprefix ."office_addresses.office_addresses_id=".ECOREPREFIX."employee_permission_mapping.office_address_id) 
                        WHERE ".ECOREPREFIX."employee_permission_mapping.employee_permission_id ='".$employee_permission_id."'";
        $query = $this->db->query($sql);
        $row = $query->result_array('array');
        return $row;
    }
    **/
    
    function get_access_levels()
    {
        $access_level = array('1'=>'Function','2'=>'Comapny','3'=>'Office Type','4'=>'Entire Group');
        return $access_level;
    }
    
    function get_business_for_edit($employee_permission_id)
    {
       $business_ids = $this->employeepermissionmodel->get_selected_business_id($employee_permission_id);
       
        $data['business']    = $this->businessmodel->getAllbusinesss();
        $all_chk ='';
        if(sizeof($business_ids)==  sizeof($data['business']))
        {
            $all_chk = 'checked="checked"';
        }
        $business_html  = '<div id="all_business">';
        $business_html .= '<label class="checkbox inline">';
        $business_html .= '<input type="checkbox" '.$all_chk.' onclick="call_to_chk_all_business(this.id)" id="all_business_chk" name="all_business_chk" >';
        $business_html .= 'All';
        $business_html .= '</label>';
        if(!empty($data['business']))
        {
            foreach($data['business'] as $key=>$val)
            {
                $chk = '';
                if(array_key_exists($val->business_id, $business_ids))
                {
                    $chk = 'checked="checked"';
                }
                    $business_html .= '<label class="checkbox inline">';
                    $business_html .= '<input type="checkbox" '.$chk.'  id="'.$val->business_id .'" value="'.$val->business_id.'" name="allbusinessids[]">';
                    $business_html .= $val->business_subject;
                    $business_html .= '</label>';
            }
        }
        $business_html .= '</div>';
        
        
        return $business_html;
        
    }
    
     function get_company_for_edit($employee_permission_id)
     {
        $company_ids = $this->employeepermissionmodel->get_selected_company_id($employee_permission_id);
        $data['company_list']  = $this->employeepermissionmodel->get_all_active_company();
        $data['company_html'] = '';
        $all_chk ='';
        if(sizeof($company_ids)==sizeof($data['company_list']))
        {
            $all_chk ='checked="checked"';
        }
        $company_html = '';
        $company_html  = '<div id="all_company">';
        $company_html .= '<label class="checkbox inline">';
        $company_html .= '<input type="checkbox" '.$all_chk.' onclick="call_to_chk_all_company(this.id)" id="all_company_chk" name="all_company_chk" >';
        $company_html .= 'All';
        $company_html .= '</label>';
        if(!empty($data['company_list']))
        {
                
               foreach($data['company_list'] as $key=>$val)
               {
                    $chk = '';
                    if(array_key_exists($val['company_master_id'],$company_ids))
                    {
                        $chk = 'checked="checked"';
                    }
                    $company_html .= '<label class="checkbox inline">';
                    $company_html .= '<input type="checkbox" '.$chk.' id="'.$val['company_master_id'].'" value="'.$val['company_master_id'].'" name="allcompanyids[]">';
                    $company_html .= $val['company_name'];
                    $company_html .= '</label>';
               }
        }
        $company_html .= '</div>';
       
        return $company_html;
     }
     
     function get_offices_for_edit($employee_permission_id)
     {
        $office_ids = $this->employeepermissionmodel->get_selected_offices_id($employee_permission_id);
        $data['offices_html'] = '';
        $office_name_html ='';
        
        $data['offices_list'] = $this->employeepermissionmodel->get_all_office_names();
        if(!empty( $data['offices_list']))
        {
            foreach($data['offices_list'] as $key=>$val)
            {
                $office_name_html .= '<div id="office_type_'.$val['office_type_id'].'">';
                $office_name_html .= '<label >';
                $office_name_html .= $val['offices_type_name'];
                $office_name_html .= '</label>';
                $office_name_html .= '<div id="all_offices_'.$val['office_type_id'].'">';
                $office_name_html .= '<label class="checkbox inline">';
                $office_name_html .= '<input type="checkbox"  onclick="call_to_chk_all_offices(this.id)" id="all_offices_chk_'.$val['office_type_id'].'" name="all_offices_chk_'.$val['office_type_id'].'" >';
                $office_name_html .= 'All';
                $office_name_html .= '</label>';
                
                if(!empty($val['offices_list']))
                {
                   foreach($val['offices_list'] as $key2=>$val2)
                    { 
                       $chk = '';
                       if(array_key_exists($val2['office_addresses_id'],$office_ids))
                       {
                           $chk = 'checked="checked"';
                       }
                       $office_name_html .= '<label class="checkbox inline">';
                       $office_name_html .= '<input type="checkbox" '.$chk.' id="'.$val2['office_addresses_id'].'" value="'.$val2['office_addresses_id'].'" name="allofficesids[]">';
                       $office_name_html .= $val2['office_name'];
                       $office_name_html .= '</label>';
                    }
                }
                else
                {
                       $office_name_html .= '<label class="checkbox inline">';
                       $office_name_html .= 'NO Offices in this office type.';
                       $office_name_html .= '</label>';
                }
              $office_name_html .= '</div>';
              $office_name_html .= '<label>&nbsp;</label>';
              $office_name_html .= '</div>';
                
            }
        }
        else
        {
             $office_name_html .= 'No Offices.';
        }
        return $office_name_html;
     }
     
     
     
     function delete_employee_permission_with_mapping($pms_employee_id)
     {
        $this->db->set_dbprefix('ecore_');
        $this->db->where('pms_employee_id', $pms_employee_id);
        $this->db->delete('employee_permission'); 
        
        $this->db->where('pms_employee_id', $pms_employee_id);
        $this->db->delete('employee_permission_mapping'); 
        $this->db->set_dbprefix('ecore_');
     }
     
     //after employee acl form changes
     function get_all_office_names()
     {
       $offices = array();
       $this->db->select('office_type_id');
       $this->db->distinct('office_type_id');
       $this->db->from($this->db->dbprefix . 'office_addresses' );
       $this->db->where('office_address_status','1');
       $query1 = $this->db->get();
       $result = $query1->result_array();
       if(!empty($result))
       {
           foreach($result as $key=>$val)
           {
               $office_type_detail = $this->get_office_type_with_company($val['office_type_id']);
               $office_comp = '';
               $office_type_nm = '';
               if(!empty($office_type_detail))
               {
                   $office_comp = $office_type_detail['company_name'];
                   $office_type_nm = $office_type_detail['office_type_name'];
               }
               $office_temp_list = $this->get_offices_by_office_type_id($val['office_type_id']);
               
               $offices[] = array(
                 'office_type_id'    => $val['office_type_id'],
                 'offices_type_name' => '<b>'.$office_type_nm.'</b> [ '.$office_comp.' ] ',
                 'offices_list'      => $this->get_offices_by_office_type_id($val['office_type_id'])
               );
           }
       }
     
       
       
       return $offices;
     }
     
     function get_offices_by_office_type_id($office_type_id,$status='1')
     {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'office_addresses' );
       $this->db->where('office_address_status',$status);
       $this->db->where('office_addresses.office_type_id',$office_type_id);
       $this->db->join($this->db->dbprefix . 'office_type', 'office_type.office_type_id = office_addresses.office_type_id','left');
       $this->db->join($this->db->dbprefix . 'company_master', 'company_master.company_master_id = office_addresses.company_master_id','left');
       $query1 = $this->db->get();
       $result = $query1->result_array();
       return $result;
     }
     
     
     function get_office_type_with_company($office_type_id)
     {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'office_type' );
       $this->db->where('office_type.office_type_id',$office_type_id);
       $this->db->join($this->db->dbprefix . 'company_master', 'company_master.company_master_id = office_type.company_master_id','left');
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;
     }
     
    /** function get_offices_by_business($business_id,$status='1')
     {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'office_addresses' );
       $this->db->where('office_address_status',$status);
       $this->db->where('office_addresses.business_id',$business_id);
       $this->db->join($this->db->dbprefix . 'office_type', 'office_type.office_type_id = office_addresses.office_type_id','left');
       $this->db->join($this->db->dbprefix . 'company_master', 'company_master.company_master_id = office_addresses.company_master_id','left');
       $query = $this->db->get();
       $result = $query->result_array();
       return $result;
     }
     **/
    
     
     function get_selected_business_id($employee_permission_id)
     {
        $this->load->model('businessmodel');
        $business_ids = $this->get_function_ids($employee_permission_id);
        $busines_names = array();
        if(!empty($business_ids))
        {
            foreach($business_ids as $key=>$val)
            {
                $business_detail = $this->businessmodel->get_business_by_id($val);
                if(!empty($business_detail))
                {
                    $busines_names[$val] = $business_detail['business_subject'];
                }
            }
        }
        return $busines_names;
     }
     
     function get_selected_company_id($employee_permission_id)
     {
        $this->load->model('companymodel');
        $company_ids = $this->get_function_ids($employee_permission_id);
        $company_names = array();
        if(!empty($company_ids))
        {
            foreach($company_ids as $key=>$val)
            {
                $company_detail = $this->companymodel->get_company_basic_detail($val);
                if(!empty($company_detail))
                {
                    $company_names[$val] = $company_detail['company_name'];
                }
            }
        }
        return $company_names;
     }

    function get_selected_offices_id($employee_permission_id)
     {
        $this->load->model('companymodel');
        $office_ids = $this->get_function_ids($employee_permission_id);
        $office_names = array();
        if(!empty($office_ids))
        {
            foreach($office_ids as $key=>$val)
            {
                $office_detail = $this->companymodel->get_office_address_by_id($val);
                if(!empty($office_detail))
                {
                    $office_names[$val] = $office_detail['office_name'];
                }
            }
        }
        return $office_names;
     }
     
     
     function get_function_ids($employee_permission_id)
     {
        $function_ids = array();
        $sql = 'SELECT DISTINCT(function_id) FROM '.ECOREPREFIX.'employee_permission_mapping WHERE employee_permission_id="'.$employee_permission_id.'"';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if(!empty($result))
        {
            foreach($result as $key=>$val)
            {
                $function_ids[] = $val['function_id'];
            }
        }
        return $function_ids;
     }
     
}