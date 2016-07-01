<?php

//session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Announcementmodel extends CI_Model {

    function getAllAnnouncements($announcement_id ='')
    {
        $sql_where = '';
        if( $announcement_id >= 1 ) {
            $sql_where = " AND announcement_id ='" . $announcement_id . "' " ;
        }
        $query = $this->db->query("SELECT * from " . $this->db->dbprefix . "announcement WHERE 1 "  . $sql_where . "  ORDER BY announcement_id DESC " );
        $result = $query->result();
        
        return $result ;
    }
    
    function getAllActiveAnnouncements($announcement_id ='')
    {
        $sql_where = '';
        if( $announcement_id >= 1 ) {
            $sql_where = " AND announcement_id ='" . $announcement_id . "' " ;
        }
        $query = $this->db->query("SELECT * from " . $this->db->dbprefix . "announcement WHERE 1 AND is_active = 1 "  . $sql_where . "  ORDER BY announcement_id DESC " );
        $result = $query->result();
        
        return $result ;
    }
    
    function dosuspend($announcement_id)
    {
        $update = array('is_active' => '0');
        $query = $this->db->update($this->db->dbprefix . "announcement",$update,array('announcement_id'=>$announcement_id));
        
        return $query;
    }
    
    function doactive($announcement_id)
    {
        $update = array('is_active' => '1');
        $query = $this->db->update($this->db->dbprefix . "announcement",$update,array('announcement_id'=>$announcement_id));
        
        return $query;
    }
    
   
    
   

}