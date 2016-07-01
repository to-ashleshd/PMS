<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Competenciesmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

   function add_competencies($data = array())
   {
       $result = $this->db->insert($this->db->dbprefix . 'competencies_for_refrence', $data);
       return $this->db->insert_id();
   }
   
   
   function add_competencies_to_grade($data = array())
   {
       $result = $this->db->insert($this->db->dbprefix . 'competencies_to_grade', $data);
       return $result;
   }
   
   function update_competencies($competencies_for_refrence_id,$data = array())
   {
      $this->db->where('competencies_for_refrence_id',$competencies_for_refrence_id);
      $this->db->update($this->db->dbprefix .'competencies_for_refrence',$data);
   }
   
   function remove_grade_by_competencies_and_grade_id($competencies_id,$grade_id)
   {
       $this->db->where('competencies_for_refrence_id', $competencies_id);
       $this->db->where('grade_id', $grade_id);
       $this->db->delete('competencies_to_grade'); 
   }
   
   function get_all_cometencies()
   {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'competencies_for_refrence' );
       $this->db->where('competencies_status','1');
        $this->db->join($this->db->dbprefix . 'weightage', 'weightage.weightage_id = competencies_for_refrence.weightage_id', 'left');
       $query = $this->db->get();
       $row = $query->result_array();
       return $row;
   }
   
   function get_grade_by_competencies_id($competencies_id)
   {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'competencies_to_grade' );
        $this->db->where('competencies_for_refrence_id',$competencies_id);
        $this->db->where('grade.status','1');
         $this->db->join($this->db->dbprefix . 'grade', 'grade.grade_id = competencies_to_grade.grade_id', 'left');
        $query = $this->db->get();
        $row = $query->result_array();
        return $row; 
   }
   
   function get_competencies_by_id($competencies_id)
   {
       $response = array();
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'competencies_for_refrence' );
       $this->db->where('competencies_status','1');
       $this->db->where('competencies_for_refrence_id',$competencies_id);
       $this->db->join($this->db->dbprefix . 'weightage', 'weightage.weightage_id = competencies_for_refrence.weightage_id', 'left');
       $query = $this->db->get();
       $row = $query->first_row('array');
       $grades = $this->get_grade_by_competencies_id($competencies_id);
       $comp_grade = '';
       $grades_arry = array();
       if(!empty($grades))
       {
           foreach($grades as $key=>$val)
           {
               $grades_arry[] =  $val['grade_id'];
               if($comp_grade=='')
               {
                $comp_grade = $val['grade_name'];
               }
               else                 
               {
                   $comp_grade = $comp_grade.', '.$val['grade_name'];
               }
           }
       }
       if(!empty($row))
       {
           $response = $row;
           $response['grades_name'] = $comp_grade;
           $response['grades'] = $grades_arry;
       }
       
       return $response;
   }
   
   
   function check_is_competencoes_for_refrence_used($comp_ref_id)
   {
       $is_comp_used = '';
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'apraiser_competency_with_idp' );
       $this->db->where('competencies_for_refrence_id',$comp_ref_id);
       $query = $this->db->get();
       $row = $query->result_array();
       if(!empty($row))
       {
           $is_comp_used = 'Y' ;
       }
       else
       {
           $is_comp_used = 'N';
       }
       return $is_comp_used;
   }
   
   
  
   
}