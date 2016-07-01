<?php

//session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Businessmodel extends CI_Model {

    function getAllbusinesss($business_id ='')
    {
        $sql_where = '';
        if( $business_id >= 1 ) {
            $sql_where = " AND business_id ='" . $business_id . "' " ;
        }
        $query = $this->db->query("SELECT * from " . $this->db->dbprefix . "business WHERE 1 "  . $sql_where . "  ORDER BY business_subject ASC " );
        $result = $query->result();
        
        return $result ;
    }
    
    function dosuspend($business_id)
    {
        $update = array('is_active' => '0');
        $query = $this->db->update($this->db->dbprefix . "business",$update,array('business_id'=>$business_id));
        
        return $query;
    }
    
    function doactive($business_id)
    {
        $update = array('is_active' => '1');
        $query = $this->db->update($this->db->dbprefix . "business",$update,array('business_id'=>$business_id));
        
        return $query;
    }
    
    
    function dodelete($business_id)
    {
        $query = $this->db->delete($this->db->dbprefix . "business", array('business_id'=>$business_id)); 
        
        return $query;
    }
    
    function doupdate($business_id,$business_name)
    {
        $update = array('business_subject' => $business_name);
        $query = $this->db->update($this->db->dbprefix . "business",$update,array('business_id'=>$business_id));
        
        return $query;
    }
    
    function isBusinessIdExists($business_id) {
        $query = $this->db->query("SELECT count(*) as howmany FROM " . $this->db->dbprefix . "business_to_company WHERE business_id='" . $business_id . "' ");
        $row = $query->first_row();
        return $row->howmany;
    }
    
    function get_business_by_id($business_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'business' );
       $this->db->where('business_id',$business_id);
       $query1 = $this->db->get();
       $result = $query1->first_row('array');
       return $result;
    }
    
    function get_business_list_by_employee_id($pms_employee_id)
    {
        $this->load->model('employeepermissionmodel');
        $this->load->model('employeemodel');
        $this->load->model('companymodel');
        $employee_permission_detail = $this->employeepermissionmodel->get_employee_permission($pms_employee_id);
        $business_list = array();
        if(!empty($employee_permission_detail))
        {
            $employee_permission_id = '0';
            if($employee_permission_detail['is_allow_upper_office']=='N' && $employee_permission_detail['function_type']=='L')
            {
                $business_id = '0';
                $business_id_detail = $this->get_user_business_id($pms_employee_id);
                if(!empty($business_id_detail))
                {
                    $business_id = $business_id_detail['meta_value'];
                }
                if(!empty($business_id))
                {
                    $business_detail = $this->get_business_by_id($business_id);
                    if(!empty($business_detail))
                    {
                        $business_list[] = array('business_id'=>$business_detail['business_id'],'business_subject'=>$business_detail['business_subject']);
                    }
                }
            }
         else if($employee_permission_detail['is_allow_upper_office']=='Y' && $employee_permission_detail['function_type']=='G')
            {
                $employee_permission_id = $employee_permission_detail['employee_permission_id'];
                if($employee_permission_detail['access_level_id']=='1')
                {
                   $businesses =  $this->employeepermissionmodel->get_selected_business_id($employee_permission_id);
                   if(!empty($businesses))
                   {
                       foreach($businesses as $key_busi=>$val_busi)
                       {
                           $business_list[] = array('business_id'=>$key_busi,'business_subject'=>$val_busi);
                       }
                   }
                }
               if($employee_permission_detail['access_level_id']=='2')
                {
                   $company_ids = $this->employeepermissionmodel->get_function_ids($employee_permission_id);
                   
                   //print_r($company_ids);
                   if(!empty($company_ids))
                   {
                       $business_ids_by_comp = $this->get_businesses_by_company_ids($company_ids);
                       if(!empty($business_ids_by_comp))
                       {
                           foreach($business_ids_by_comp as $key_bidcomp=>$valbidcomp)
                           {
                               $business_detail = $this->get_business_by_id($valbidcomp);
                               if(!empty($business_detail))
                                {
                                    $business_list[] = array('business_id'=>$business_detail['business_id'],'business_subject'=>$business_detail['business_subject']);
                                }
                           }
                       }
                   }
                   
                }
               if($employee_permission_detail['access_level_id']=='3')
                {
                    $office_ids = $this->employeepermissionmodel->get_function_ids($employee_permission_id);
                  
                    if(!empty($office_ids))
                    {
                       $business_ids = $this->get_businesses_by_offices_ids($office_ids);
                        if(!empty($business_ids))
                       {
                           foreach($business_ids as $key_bid=>$valbid)
                           {
                               $business_detail = $this->get_business_by_id($valbid);
                               if(!empty($business_detail))
                                {
                                   $business_list[] = array('business_id'=>$business_detail['business_id'],'business_subject'=>$business_detail['business_subject']);
                                }
                           }
                       }
                            
                    }
                   
                }
                if($employee_permission_detail['access_level_id']=='4')
                {
                   $all_business  =  $this->getAllbusinesss();
                   if(!empty($all_business))
                   {
                       foreach($all_business as $key_bid=>$val_busi)
                           {
                                   $business_list[] = array('business_id'=>$val_busi->business_id,'business_subject'=>$val_busi->business_subject);
                           }
                   }
                }
            }
        }
        return $business_list;
    }
    
    function get_user_business_id($pms_employee_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix.'employee_meta');
       $this->db->where('pms_employee_id',trim($pms_employee_id));
       $this->db->where('meta_key','business_id');
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;
    }
    
    function get_businesses_by_company_ids($company_ids = array())
    {
       $business_ids = array();
       $this->db->select('business_id');
       $this->db->distinct('business_id');
       $this->db->from($this->db->dbprefix.'business_to_company');
       $this->db->where_in('company_master_id',$company_ids);
       $query = $this->db->get();
       $row = $query->result_array();
       //return $row;
       if(!empty($row))
       {
           foreach($row as $key=>$val)
           {
                $business_ids[] = $val['business_id'];
           }
       }
        
       return $business_ids;
    }
    
    
    function get_businesses_by_offices_ids($offices_ids = array())
    {
       $business_ids = array();
       $this->db->select('business_id');
       $this->db->distinct('business_id');
       $this->db->from($this->db->dbprefix.'office_addresses');
       $this->db->where_in('office_addresses_id',$offices_ids);
       $query = $this->db->get();
       $row = $query->result_array('array');
       
       if(!empty($row))
       {
           foreach($row as $key=>$val)
           {
                $business_ids[] = $val['business_id'];
           }
       }
       return $business_ids;
    }
    
    
    
  
}