<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Apraiseemodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    function getEmployeeKraById($pms_employee_id,$time_period_id)
    {
     
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'apraisee_kra' );
       $this->db->where('pms_employee_id',$pms_employee_id);
       $this->db->where('time_period_id',$time_period_id);
       $this->db->join($this->db->dbprefix . 'weightage', 'weightage.weightage_id = apraisee_kra.weightage_id','left');
       $query = $this->db->get();
       $row = $query->result_array();
       return $row;
      

    }
    
    function getApraiseeKraById($apraisee_kra_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'apraisee_kra' );
       $this->db->where('apraisee_kra_id',$apraisee_kra_id);
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;
    }
    
    
    function add_kra($data = array())
    {
        if(!empty($data))
        {
            $result = $this->db->insert($this->db->dbprefix . 'apraisee_kra', $data);
            return $result;
        }
    }
    
   
    function addPms($data = array()) {
        //dbprefix
        if(!empty($data))
        {
           foreach($data as $key=>$val)
           {
            $result = $this->db->insert($this->db->dbprefix . 'apraisee_pms', $val);
           }
        }
        return $result;
    }
    
   
    
    function UpdateRelationshipStatus($employee_relationship_materix_id,$status)
    {
       $this->db->where('employee_relationship_materix_id',$employee_relationship_materix_id );
       $this->db->update($this->db->dbprefix .'employee_relationship_materix',array('submit_status'=>$status));
    }
    
    function getApraiseePmsById($apraisee_pms_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'apraisee_pms' );
       $this->db->where('apraisee_pms_id',$apraisee_pms_id);
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;

    }
    
    function getRelationshipByids($pms_employee_id,$apraiser_employee_id,$time_period_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee_relationship_materix' );
       $this->db->where('pms_employee_id',$pms_employee_id);
       $this->db->where('apraiser_employee_id',$apraiser_employee_id);
       $this->db->where('time_period_id',$time_period_id);
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;
   
    }
    
    
    function getRelationshipDetailOfEmployee($pms_employee_id,$time_period_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee_relationship_materix' );
       $this->db->where('pms_employee_id',$pms_employee_id);
       $this->db->where('time_period_id',$time_period_id);
       $query = $this->db->get();
       $row = $query->result_array();
       //echo $this->db->last_query();
       return $row;
   
    }
     
     
    public function getAllIdpsOfApraisee($pms_employee_id,$time_period_id)
    {
       //$time_period_id = '1';
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'apraisee_idp' );
       $this->db->where('pms_employee_id',$pms_employee_id);
       $this->db->where('time_period_id',$time_period_id);
       $this->db->order_by('sort_order','ASC');
       $query = $this->db->get();
       $row = $query->result_array();

       return $row;
    }
     
   
   
     public function addIdpData($data = array())
     {
         $result = $this->db->insert($this->db->dbprefix . 'apraisee_idp', $data);
         return $result;
     }
   
     function getEmployeeRelationshipByID($employee_relationship_materix_id)
     {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee_relationship_materix' );
       $this->db->where('employee_relationship_materix_id',$employee_relationship_materix_id);
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;
     }
    
     function is_employee_relationship_added($pms_employee_id,$time_period_id)
     {
       $count_row = $this->db->query("SELECT COUNT(*) as count FROM pms_employee_relationship_materix WHERE pms_employee_id='".$pms_employee_id."' AND time_period_id='".$time_period_id."' ")->first_row()->count;
      /// echo $this->db->last_query();die();
       return $count_row;
         
         
         
     }
     
    function get_apraisee_kra_by_Id($apraisee_kra_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'apraisee_kra' );
       $this->db->where('apraisee_kra_id',$apraisee_kra_id);
       $this->db->join($this->db->dbprefix . 'weightage', 'weightage.weightage_id = apraisee_kra.weightage_id','left');
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;
    }
    
    function update_apraisee_kra($data=array(),$apraisee_kra_id)
    {
       $this->db->where('apraisee_kra_id',$apraisee_kra_id );
       $result = $this->db->update($this->db->dbprefix .'apraisee_kra',$data);
       return $result;
    }
    
    function get_employee_track_status($pms_employee_id,$time_period_id)
    {
       $this->db->select('track_status');
       $this->db->from($this->db->dbprefix . 'employee_track_process' );
       $this->db->where('pms_employee_id',$pms_employee_id);
       $this->db->where('time_period_id',$time_period_id);
       $query = $this->db->get();
       $row = $query->first_row('array');
       //echo $this->db->last_query();
       if(!empty($row))
       {
        return $row['track_status'];
       }
       return '0';
    }
    
    function update_track_process($pms_employee_id,$time_period_id,$status)
    {
       $this->db->where('pms_employee_id',$pms_employee_id);
       $this->db->where('time_period_id',$time_period_id);
       $this->db->update($this->db->dbprefix .'employee_track_process',array('track_status'=>$status));
       //echo $this->db->last_query();
      // die();
    }
    
    function get_kra_by_id($pms_employee_id,$apraiser_employee_id,$time_period_id)
    {
     
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'apraisee_kra' );
       $this->db->where('pms_employee_id',$pms_employee_id);
       $this->db->where('current_apraiser_id',$apraiser_employee_id);
       $this->db->where('time_period_id',$time_period_id);
       $this->db->join($this->db->dbprefix . 'weightage', 'weightage.weightage_id = apraisee_kra.weightage_id','left');
       $query = $this->db->get();
       $row = $query->result_array();
       return $row;
    }
    
    function get_kra_by_aproove_status($pms_employee_id,$approved_status,$time_period_id)
    {
     
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'apraisee_kra' );
       $this->db->where('pms_employee_id',$pms_employee_id);
       $this->db->where('apraisee_kra_approve_status',$approved_status);
       $this->db->where('time_period_id',$time_period_id);
       $this->db->join($this->db->dbprefix . 'weightage', 'weightage.weightage_id = apraisee_kra.weightage_id','left');
       $query = $this->db->get();
       $row = $query->result_array();
      // echo $this->db->last_query();
       return $row;
    }
    
    function get_employee_temp_last_rating($pms_employee_id)
    {
       $score ='N.A.';
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee_previous_rating' );
       $this->db->where('pms_employee_id',$pms_employee_id);
       $this->db->where('time_period_id','1');
       $query = $this->db->get();
       $row = $query->first_row('array');
       if(!empty($row))
       {
            $score = $row['previous_score'];
       }
       return $score;
    }
    
    function get_employee_last_year_rating($pms_employee_id,$reviewer_employee_id,$time_period_id)
    {
       $score ='N.A.';
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'reviewer_overall_rating' );
       $this->db->where('pms_employee_id',$pms_employee_id);
       $this->db->where('reviewer_employee_id',$reviewer_employee_id);
       $this->db->where('time_period_id',$time_period_id);
       $query = $this->db->get();
       $row = $query->first_row('array');
       if(!empty($row))
       {
          $score = $this->reviewermodel->getScoreNameByScore($row['reviewer_score']);
       }
       return $score;
    }
    
     function getRelationshipByExcludingApraiserid($pms_employee_id,$apraiser_employee_id,$time_period_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee_relationship_materix' );
       $this->db->where('pms_employee_id',$pms_employee_id);
       $this->db->where('apraiser_employee_id !=',$apraiser_employee_id);
       $this->db->where('time_period_id',$time_period_id);
       $query = $this->db->get();
       $row = $query->result_array();
       //echo $this->db->last_query();die();
       return $row;
   
    }
 
    function getRelationshipStatus($pms_employee_id, $apraiser_employee_id, $time_period_id) {

        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'employee_relationship_materix');
        $this->db->where('pms_employee_id', $pms_employee_id);
        $this->db->where('time_period_id', $time_period_id);
        $this->db->where('apraiser_employee_id', $apraiser_employee_id);
        $query = $this->db->get();
        $row = $query->first_row('array');
        //echo $this->db->last_query();
        return $row;
    }
    
}