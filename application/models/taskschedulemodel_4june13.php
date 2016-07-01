<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Taskschedulemodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getTimePeriod()
    {
       $is_active = 1;
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'time_period' );
       $this->db->where('is_active', $is_active);
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
    
    
    function get_downgrade_time_period_list($start_time_period_date)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'time_period' );
       $this->db->where('time_period_from >=', $start_time_period_date);
       $query = $this->db->get();
       $row = $query->result_array();
       return $row;
    }
    
    
    function get_employee_valid_time_period($pms_employee_id)
     {
        $time_period_ids = array();
        $this->load->model('taskschedulemodel');
         $start_time_period_date = '';
         $employee_detail = $this->employeemodel->getEmployeeById($pms_employee_id);
         if(!empty($employee_detail))
         {
                $start_time_period_detail  = $this->taskschedulemodel->getTimeperiodById($employee_detail->start_time_period_id);
                if(!empty($start_time_period_detail))
                {
                    $start_time_period_date    = $start_time_period_detail->time_period_from;
                }
                $this->db->select('time_period_id');
                $this->db->from($this->db->dbprefix . 'time_period' );
                $this->db->where('time_period_from >=', $start_time_period_date);
                $query = $this->db->get();
                $row = $query->result_array();
                if(!empty($row))
                {
                    foreach($row as $key=>$val)
                    {
                        $time_period_ids[] = $val['time_period_id'];
                    }
                }
                return $time_period_ids;
         }
     }
     
     
     function get_min_kra($time_period_id,$status='1')
     {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'time_period_setting' );
       $this->db->where('meta_key','min_kra' );
       $this->db->where('time_period_id',$time_period_id);
       $this->db->where('status',$status);       
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;
     }
     
     
      function get_max_kra($time_period_id,$status='1')
     {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'time_period_setting' );
       $this->db->where('meta_key','max_kra' );
       $this->db->where('time_period_id',$time_period_id);
       $this->db->where('status',$status);       
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;
     }
    
     
      
     function get_min_weightage($time_period_id,$status='1')
     {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'time_period_setting' );
       $this->db->where('meta_key','min_weightage' );
       $this->db->where('time_period_id',$time_period_id);
       //$this->db->where('status',$status);       
       $query = $this->db->get();
       $row = $query->first_row('array');
       //echo $this->db->last_query();die();
       return $row;
     }
     
     function get_max_weightage($time_period_id,$status='1')
     {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'time_period_setting' );
       $this->db->where('meta_key','max_weightage' );
       $this->db->where('time_period_id',$time_period_id);
       //$this->db->where('status',$status);       
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;
     }
     
    
     function get_time_period_by_id($time_period_id)
    {
        $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'time_period' );
      $this->db->where('time_period_id', $time_period_id);
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;
    }
}