<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Taskschedulemodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getTimePeriod()
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'time_period' );
      // $this->db->where('status', $status);
       //$this->db->join($this->db->dbprefix . 'task_schedule', 'task_schedule.time_period_id = time_period.time_period_id','left');
       $query = $this->db->get();
       $row = $query->result_array();
       return $row;
    }
    
    function getTimeperiodById($time_period_id)
    {
        $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'time_period' );
      $this->db->where('time_period_id', $time_period_id);
       $query = $this->db->get();
       $row = $query->first_row();
       return $row;
    }
    
    function getAllRatimgs($status)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'rating' );
       $this->db->where('rating_status', $status);
       $query = $this->db->get();
       $row = $query->result_array();
       return $row;
    }
    
 


     
   
     
     
     
     
     
    
    
  
  
     
     
   
    
    
    
}