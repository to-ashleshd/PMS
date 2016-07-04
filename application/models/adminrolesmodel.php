<?php

//session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Adminrolesmodel extends CI_Model {

    function newadminrole($rolename) {
      

        //check for rolename is already exists or not
        $is_exists = $this->isRoleExists($rolename);
          $this->db->set_dbprefix('ecore_');
        //print_r($is_exists);
        if ($is_exists >= 1) {
            $result = 'exists';
        } else {
            $data = array(
                'rolename' => $rolename,
                'date_added' => date('Y-m-d H:i:s')
            );
          
            $result = $this->db->insert($this->db->dbprefix . 'client_user_role', $data);
        }
        
        //Reset prefix
        $this->db->set_dbprefix('pms_');
        
        return $result;
    }

    function updateadminrole($roleid, $rolename) {
       

        //check for rolename is already exists or not
        $is_exists = $this->isRoleExists($rolename);
        //print_r($is_exists);
        if ($is_exists >= 1) {
            $result = 'exists';
        } else {
            $data = array(
                'rolename' => $rolename,
                'date_added' => date('Y-m-d H:i:s')
            );
             $this->db->set_dbprefix('ecore_');
            $result = $this->db->update(ECOREPREFIX . 'client_user_role', $data,array('client_user_role_id' => $roleid) );            
            $this->db->set_dbprefix('pms_');
            
        }
        
        //Reset prefix
        
        
        return $result;
    }

    function isRoleExists($role) {
        $this->db->set_dbprefix('ecore_');

        $this->db->select('*');
        $this->db->from(ECOREPREFIX . 'client_user_role');
        $this->db->where(trim('LCASE(' . ECOREPREFIX . 'client_user_role.rolename)'), trim(strtolower($role)));
        $query = $this->db->get();
        //echo  $this->db->last_query();die();
        $row = $query->first_row();
        
        //Reset prefix
        $this->db->set_dbprefix('pms_');
        
        if ($query->num_rows() >= 1) {
            return $row->client_user_role_id;
        } else {
            return 0;
        }
        
        
    }

    function getListAll() {
        $this->db->set_dbprefix('ecore_');
        $sql = "SELECT * FROM " . ECOREPREFIX. "client_user_role ORDER By client_user_role_id ASC ";
        $query = $this->db->query($sql);
        
         //Reset prefix
        $this->db->set_dbprefix('pms_');
        
        return $query->result();
       
    }
    
     function get_user_role_by_id($role_id) {
        $this->db->set_dbprefix('ecore_');
        $sql = "SELECT * FROM " . ECOREPREFIX. "client_user_role where client_user_role_id ='".$role_id."'";
        $query = $this->db->query($sql);
        
         //Reset prefix
        $this->db->set_dbprefix('pms_');
        
        return $query->first_row();
       
    }
    
    function getListOptions()
    {
        $this->db->set_dbprefix('ecore_');
        $sql = "SELECT * FROM " . ECOREPREFIX . "client_user_role ORDER By rolename ASC ";
        $query = $this->db->query($sql);
        
        //Reset prefix
        $this->db->set_dbprefix('pms_');
        
        return $query->result();  
        
    }
    
    function getListModules()
    {
        $this->db->set_dbprefix('ecore_');
        $sql = "select * from " . ECOREPREFIX . "allowed_module_settings ORDER BY module_role_name ASC " ;
        $query = $this->db->query($sql);
        
         //Reset prefix
        $this->db->set_dbprefix('pms_');
        return $query->result();
       
    }
    
    function addRoleToModule()
    {
        
    }

}