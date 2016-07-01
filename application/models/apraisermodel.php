<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Apraisermodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getEmployeeApriseelist($pms_employee_id, $status) {
        
        $time_period_id = '1';
        //       $time_period_detail                 = $this->commonmodel->get_current_year();
//        if(!empty($time_period_detail))
//        {
//            $time_period_id                 = $time_period_detail['time_period_id'];
//        }
        
        $this->load->model('commonmodel');
        $this->load->model('employeemodel');
        $this->load->model('apraiseemodel');
        $employee_detail = array();
        $employee_list = array();
        if ($pms_employee_id == '1') {
            $relationship_ids = $this->getAllEmplyeeIdsByApraiserID($time_period_id);//$this->employeemodel->getAllEmployeeIDs($pms_employee_id);
            //$relationship_ids = $ids['relationship_ids'];
        } else {
            $relationship_ids = $this->getRealationshipidsByApraiserID($pms_employee_id, $time_period_id);
        }


      
       
        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
       
          
        if (!empty($relationship_ids)) {

            foreach ($relationship_ids as $keyr => $valr) {
               // print_r($valr);
               
                $is_found_employee = '';
                
                $this->db->select('*');
                $this->db->from($this->db->dbprefix . 'employee');
                $this->db->where('user_status', trim($status));
                $this->db->where_in('pms_employee_id', $valr['pms_employee_id']);
                $this->db->join($this->db->dbprefix . 'designation', 'designation.designation_id = employee.designation_id', 'left');
                $this->db->order_by("designation.sort_order", "ASC");
                $query = $this->db->get();
                $employee_detail = $query->first_row('array');
                $val = $employee_detail;
               
                
                
                $designation_name = '';
                $grade_id = '';
                $grade_name = '';
                $department_name = '';
                $submit_status = '';
                $apraiser_employee_id = '';
                //  $time_period_id      = '0';


                $designation_detail = $this->companymodel->getDesignationById($val['designation_id']);
                $grade_detail = $this->companymodel->getGradeByDesignationId($val['designation_id']);
                $department_detail = $this->companymodel->getDepartment($val['department_id']);

               
                if (!empty($department_detail)) {
                    $department_name = $department_detail->department_name;
                }

                if (!empty($designation_detail)) {
                    $designation_name = $designation_detail->designation_name;
                }

                if (!empty($grade_detail)) {
                    $grade_id = $grade_detail->grade_id;
                    $grade_name = $grade_detail->grade_name;
                }
                
               
                    
                 $relationship_status_detail = $this->get_relationship_by_id($valr['employee_relationship_materix_id']);//$this->apraiseemodel->getRelationshipDetailOfEmployee($val['pms_employee_id'], $time_period_id);
              
                 if ($relationship_status_detail) {
                        // $submit_status = $relationship_status_detail[0]['submit_status'];
                        //  $apraiser_employee_id = $relationship_status_detail[0]['apraiser_employee_id'];
                            $submit_status = $relationship_status_detail['submit_status'];
                            $apraiser_employee_id = $relationship_status_detail['apraiser_employee_id'];
                            //$time_period_id     = $relationship_status_detail[0]['time_period_id'];
                        }
              // echo $this->db->last_query();
              //  print_r($relationship_status_detail);
               
                        

                //Get Submit Status
                $sql = "select * from " . $this->db->dbprefix . "employee_relationship_materix 
                        where pms_employee_id = '" . $val['pms_employee_id'] . "' 
                        and time_period_id = '" . $time_period_id . "'  
                        and apraiser_employee_id = '" . $apraiser_employee_id . "' ";
                $query = $this->db->query($sql);
                $result1 = $query->result();
               // echo "<pre>";
              
               // print_r($result1);
               // die();
                $employee_list[] = array(
                    'pms_employee_id' => $val['pms_employee_id'],
                    'employee_id' => $val['employee_id'],
                    'time_period_id' => $time_period_id,
                    'employee_name' => $val['fname'] . ' ' . $val['lname'],
                    'fname' => $val['fname'],
                    'mname' => $val['mname'],
                    'lname' => $val['lname'],
                    'designation_id' => $val['designation_id'],
                    'department_id' => $val['department_id'],
                    'grade_id' => $grade_id,
                    'designation_id' => $val['designation_id'],
                    'designation_name' => $designation_name,
                    'department_name' => $department_name,
                    'grade_name' => $grade_name,
                    'date_of_joining' => date($data['s_date_format'], strtotime($val['date_of_joining'])),
                    'submit_status' => $submit_status,
                    'apraiser_employee_id' => $apraiser_employee_id,
                    'submit_status2' => $result1[0]->submit_status
                );
                 //print_r($val['fname'].' '.$val['lname']);
               
            }
        }

        return $employee_list;
    }

    function getEmplyeeIdsByApraiserID($apraiser_employee_id, $time_period_id) {
        $employee_id = array();
        $this->db->select('pms_employee_id');
        $this->db->from($this->db->dbprefix . 'employee_relationship_materix');
        $this->db->where('apraiser_employee_id', $apraiser_employee_id);
        $this->db->where('time_period_id', $time_period_id);
        $query = $this->db->get();
        $row = $query->result_array();
        //echo $this->db->last_query();die();
        if (!empty($row)) {
            foreach ($row as $key => $val) {
                $employee_id[] = $val['pms_employee_id'];
            }
        }

        return $employee_id;
    }
    
    
    function getRealationshipidsByApraiserID($apraiser_employee_id, $time_period_id) {
        $employee_id = array();
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'employee_relationship_materix');
        $this->db->where('apraiser_employee_id', $apraiser_employee_id);
        $this->db->where('time_period_id', $time_period_id);
        $query = $this->db->get();
        $row = $query->result_array();
        //echo $this->db->last_query();die();
//        if (!empty($row)) {
//            foreach ($row as $key => $val) {
//                $employee_id[] = $val['pms_employee_id'];
//            }
//        }

        return $row;
    }
    
    function getAllEmplyeeIdsByApraiserID($time_period_id) {
        $employee_id = array();
        $relationship_id = array();
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'employee_relationship_materix');
        $this->db->where('time_period_id', $time_period_id);
        $query = $this->db->get();
        $row = $query->result_array();
        //echo $this->db->last_query();die();
       
        if (!empty($row)) {
            foreach ($row as $key => $val) {
                $employee_id[] = $val['pms_employee_id'];
                $relationship_id[$val['pms_employee_id']] = $val['employee_relationship_materix_id'];
            }
        }
        
        $ids = array(
            'employee_ids' =>$employee_id,
            'relationship_ids'=>$relationship_id
            );
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

    function getApraiseeKraPmsDetail($apraisee_employee_id, $time_period_id) {
        //echo '<br>Apraisee Employee Id ' . $apraisee_employee_id ;
        //echo '<br>Session Id: ' . $this->session->userdata('pms_employee_id') ;
        $this->load->model('commonmodel');
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'apraisee_pms');
        $this->db->where('apraisee_pms.pms_employee_id', $apraisee_employee_id);
        $this->db->where('apraisee_pms.time_period_id', $time_period_id);
        //Filter for currnte apraiser id
        //TODO Fixed for Logged user and appraiser
        if( $apraisee_employee_id != $this->session->userdata('pms_employee_id') ) {
            $this->db->where('apraisee_kra.approved_kra_by_apraiser_id', $this->session->userdata('pms_employee_id'));
        }
        //TODO: Need Fixed - Pass multiple appriiser id 
        $this->db->join($this->db->dbprefix . 'apraisee_kra', 'apraisee_pms.apraisee_kra_id = apraisee_kra.apraisee_kra_id', 'left');
        $query = $this->db->get();
        $row = $query->result_array();
        $kra_detail = array();
        //echo $this->db->last_query();


        $details = array();
        if (!empty($row)) {
            $details = $row;

            foreach ($details as $key => $val) {
                $weightage_detail = $this->commonmodel->getWeightageByid($val['weightage_id']);
                $rating_detail = $this->commonmodel->getRatingByid($val['rating_id']);
                $details[$key]['weightage_name'] = $weightage_detail['weightage_value'];
                $details[$key]['weightage_value'] = $weightage_detail['weightage_value'];
                $details[$key]['rating_id'] = $rating_detail['rating_id'];
                $details[$key]['rating_name'] = $rating_detail['rating_name'];
                $details[$key]['rating_value'] = $rating_detail['rating_value'];
            }
        }


        return $details;
    }

    function addApraiseeKraByApraiser($data = array()) {
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                $result = $this->db->insert($this->db->dbprefix . 'apraiser_kra', $val);
            }
        }
        return $result;
    }

    function getApraiserKraPmsDetail($apraisee_employee_id, $apraiser_employee_id) {
        $time_period_id = '1';

        $this->load->model('commonmodel');
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'apraiser_kra');
        $this->db->where('apraiser_kra.apraisee_employee_id', $apraisee_employee_id);
        $this->db->where('apraiser_kra.apraiser_employee_id', $apraiser_employee_id);
        $this->db->where('apraiser_kra.time_period_id', $time_period_id);
        $this->db->join($this->db->dbprefix . 'apraisee_pms', 'apraisee_pms.apraisee_pms_id = apraiser_kra.apraisee_pms_id', 'left');
        $this->db->join($this->db->dbprefix . 'apraisee_kra', 'apraisee_pms.apraisee_kra_id = apraisee_kra.apraisee_kra_id', 'left');
        $query = $this->db->get();
        $row = $query->result_array();
        //echo $this->db->last_query();
        // $kra_detail = array();

        $details = array();
        if (!empty($row)) {
            $details = $row;
            foreach ($details as $key => $val) {

                $weightage_detail = $this->commonmodel->getWeightageByid($val['weightage_id']);
                $self_rating_detail = $this->commonmodel->getRatingByid($val['rating_id']);
                $apraiser_rating_detail = $this->commonmodel->getRatingByid($val['apraiser_rating_id']);

                $total_score = ( (($weightage_detail['weightage_value']) * ($apraiser_rating_detail['rating_value'])) / 100 );
                $details[$key]['weightage_name'] = $weightage_detail['weightage_value'];
                $details[$key]['self_rating_name'] = $self_rating_detail['rating_name'];
                $details[$key]['self_rating_value'] = $self_rating_detail['rating_value'];
                $details[$key]['apraiser_rating_name'] = $apraiser_rating_detail['rating_name'];
                $details[$key]['apraiser_rating_value'] = $apraiser_rating_detail['rating_value'];
                $details[$key]['total_score'] = number_format($total_score, 2, '.', '');
                ;
            }
        }

        return $details;
    }

    function getAllRatings($status) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'rating');
        $this->db->where('rating_status', $status);
        $this->db->order_by('rating_value', 'desc');
        $query = $this->db->get();
        $row = $query->result_array();
        return $row;
    }

    public function addCompetencyOFApraisee($data = array()) {
        $result = $this->db->insert($this->db->dbprefix . 'apraiser_competency_with_idp', $data);
        return $result;
    }

    public function addCompetencyTechnicalOFApraisee($data = array()) {
        $result = $this->db->insert($this->db->dbprefix . 'apraiser_technical', $data);
        return $result;
    }

    public function addCompetencyBehaviouralOFApraisee($data = array()) {
        $result = $this->db->insert($this->db->dbprefix . 'apraiser_behavioural', $data);
        return $result;
    }

    public function getEmployeeCompetenciesWithIdp($pms_employee_id, $apraiser_employee_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'apraiser_competency_with_idp');
        $this->db->where('pms_employee_id', $pms_employee_id);
        $this->db->where('apraiser_employee_id', $apraiser_employee_id);
        $this->db->join($this->db->dbprefix . 'competencies_for_refrence', 'competencies_for_refrence.competencies_for_refrence_id = apraiser_competency_with_idp.competencies_for_refrence_id', 'left');
        $this->db->join($this->db->dbprefix . 'weightage', 'weightage.weightage_id = competencies_for_refrence.weightage_id', 'left');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $row = $query->result_array();
        $details = array();
        if (!empty($row)) {
            $details = $row;
            foreach ($details as $key => $val) {
                $details[$key]['total_score'] = ((($val['weightage_value']) * ($val['scale'])) / 100);
                $details[$key]['mytotal'] = $this->getCompetencyScore($val['competencies_for_refrence_id'],$val['scale'] );
            }
        }
        return $details;
    }

    public function getEmployeeTechnicalDetail($pms_employee_id, $apraiser_employee_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'apraiser_technical');
        $this->db->where('pms_employee_id', $pms_employee_id);
        $this->db->where('apraiser_employee_id', $apraiser_employee_id);
        $query = $this->db->get();
        $row = $query->result_array();
        
        return $row;
    }

    public function getEmployeeBehaviouralDetail($pms_employee_id, $apraiser_employee_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'apraiser_behavioural');
        $this->db->where('pms_employee_id', $pms_employee_id);
        $this->db->where('apraiser_employee_id', $apraiser_employee_id);
        $query = $this->db->get();
        $row = $query->result_array();
        return $row;
    }

    public function addApraiserOverallRating($data = array()) {
        $result = $this->db->insert($this->db->dbprefix . 'apraiser_overall_rating', $data);
        return $result;
    }

    public function getOverallRatingDetail($pms_employee_id, $apraiser_employee_id, $time_period_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'apraiser_overall_rating');
        $this->db->where('pms_employee_id', $pms_employee_id);
        $this->db->where('apraiser_employee_id', $apraiser_employee_id);
        $this->db->where('time_period_id', $time_period_id);
        $query = $this->db->get();
        $row = $query->result_array();
        return $row;
    }

    function getRelationshipDetailOfEmployee($pms_employee_id, $time_period_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'employee_relationship_materix');
        $this->db->where('pms_employee_id', $pms_employee_id);
        $this->db->where('time_period_id', $time_period_id);
        $query = $this->db->get();
        $row = $query->first_row('array');
        return $row;
    }

    function getApraiserKraPmsById($apraiser_kra_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'apraiser_kra');
        $this->db->where('apraiser_kra_id', $apraiser_kra_id);
        $query = $this->db->get();
        $row = $query->first_row('array');
        return $row;
    }

    function getApraiserOverAllRatingById($pms_employee_id, $apraiser_employee_id, $time_period_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'apraiser_overall_rating');
        $this->db->where('pms_employee_id', $pms_employee_id);
        $this->db->where('apraiser_employee_id', $apraiser_employee_id);
        $this->db->where('time_period_id', $time_period_id);
        $query = $this->db->get();
        $row = $query->first_row('array');
        return $row;
    }

    function get_kra_approvel_appraisee_list($pms_employee_id, $status) {

        $time_period_id = '1';
//        $time_period_detail                 = $this->commonmodel->get_current_year();
//        if(!empty($time_period_detail))
//        {
//            $time_period_id                 = $time_period_detail['time_period_id'];
//        }
        $this->load->model('commonmodel');
        $this->load->model('employeemodel');
        $this->load->model('apraiseemodel');
        $employee_detail = array();
        $employee_list = array();
        if ($pms_employee_id == '1') {
            $employee_ids = $this->employeemodel->getAllEmployeeIDs($pms_employee_id);
        } else {
           $employee_ids = $this->getEmplyeeIdsByApraiserID($pms_employee_id, $time_period_id);
        }

        if (empty($employee_ids)) {
            $employee_ids = array('0');
        }

        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'employee');
        $this->db->where('user_status', trim($status));
        $this->db->where_in('pms_employee_id', $employee_ids);
        $this->db->join($this->db->dbprefix . 'designation', 'designation.designation_id = employee.designation_id', 'left');
        $this->db->order_by("designation.sort_order", "ASC");
        $query = $this->db->get();
        $employee_detail = $query->result_array();


        if (!empty($employee_detail)) {

            foreach ($employee_detail as $key => $val) {
                $designation_name = '';
                $grade_id = '';
                $grade_name = '';
                $department_name = '';
                $submit_status = '';
                $apraiser_employee_id = '';
                //  $time_period_id      = '0';


                $designation_detail = $this->companymodel->getDesignationById($val['designation_id']);
                $grade_detail = $this->companymodel->getGradeByDesignationId($val['designation_id']);
                $department_detail = $this->companymodel->getDepartment($val['department_id']);

                if (!empty($department_detail)) {
                    $department_name = $department_detail->department_name;
                }

                if (!empty($designation_detail)) {
                    $designation_name = $designation_detail->designation_name;
                }

                if (!empty($grade_detail)) {
                    $grade_id = $grade_detail->grade_id;
                    $grade_name = $grade_detail->grade_name;
                }

                // $relationship_status_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($val['pms_employee_id'],$time_period_id);
                $track_status = '0';
                $track_status = $this->apraiseemodel->get_employee_track_status($val['pms_employee_id'], $time_period_id);

                $apraiser_employee_id = $this->session->userdata('pms_employee_id');

                //Get Submit Status
                $sql = "select * from " . $this->db->dbprefix . "employee_relationship_materix 
                        where pms_employee_id = '" . $val['pms_employee_id'] . "' 
                        and time_period_id = '" . $time_period_id . "'  
                        and apraiser_employee_id = '" . $apraiser_employee_id . "' ";
                $query = $this->db->query($sql);
                $result1 = $query->result();

                //Get Count
                $sql = "SELECT count(*) as howmany from " . $this->db->dbprefix . "apraisee_kra 
                        WHERE pms_employee_id = '" . $val['pms_employee_id'] . "' 
                        and time_period_id = '" . $time_period_id . "'  
                        and current_apraiser_id = '" . $apraiser_employee_id . "' 
                        and apraisee_kra_approve_status = 1";
                //echo $sql;
                $query = $this->db->query($sql);
                $result2 = $query->result();
                $submit_status_of_rel=0.0;
                if(!empty($result1))
                {
                    $submit_status_of_rel = $result1[0]->submit_status;
                }
                
                if (($track_status == 0.2 || $track_status == 0.1) && ($submit_status_of_rel==0.2)) {

                    $employee_list[] = array(
                        'pms_employee_id' => $val['pms_employee_id'],
                        'employee_id' => $val['employee_id'],
                        'time_period_id' => $time_period_id,
                        'employee_name' => $val['fname'] . ' ' . $val['lname'],
                        'fname' => $val['fname'],
                        'mname' => $val['mname'],
                        'lname' => $val['lname'],
                        'designation_id' => $val['designation_id'],
                        'department_id' => $val['department_id'],
                        'grade_id' => $grade_id,
                        'designation_id' => $val['designation_id'],
                        'designation_name' => $designation_name,
                        'department_name' => $department_name,
                        'grade_name' => $grade_name,
                        'date_of_joining' => date($data['s_date_format'], strtotime($val['date_of_joining'])),
                        'track_status' => $track_status,
                        'apraiser_employee_id' => $apraiser_employee_id,
                        'submit_status' => $result1[0]->submit_status,
                        'pending_count' => $result2[0]->howmany
                    );
                }
            }
        }



        return $employee_list;
    }

    function get_kra_approvel_appraisee_list_for_both_year($pms_employee_id, $status) {
         
        $time_period_id = array('1','2');

        $this->load->model('commonmodel');
        $this->load->model('employeemodel');
        $this->load->model('apraiseemodel');
        $employee_detail = array();
        $employee_list = array();
        if ($pms_employee_id == '1') {
            $employee_ids = $this->employeemodel->getAllEmployeeIDs($pms_employee_id);
        } else {
          $employee_reltopnship_ids = $this->get_employee_for_curt_and_imediate_prev_year($pms_employee_id, $time_period_id);
        }

     

        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');

        if (!empty($employee_reltopnship_ids)) {

            foreach ($employee_reltopnship_ids as $key => $val) {
                $employee_detail = $this->employeemodel->get_employee_by_id($val['pms_employee_id']);
                
                $designation_name = '';
                $grade_id = '';
                $grade_name = '';
                $department_name = '';
                $submit_status = '';
                $apraiser_employee_id = '';
                //  $time_period_id      = '0';


                $designation_detail = $this->companymodel->getDesignationById($employee_detail['designation_id']);
                $grade_detail = $this->companymodel->getGradeByDesignationId($employee_detail['designation_id']);
                $department_detail = $this->companymodel->getDepartment($employee_detail['department_id']);

                if (!empty($department_detail)) {
                    $department_name = $department_detail->department_name;
                }

                if (!empty($designation_detail)) {
                    $designation_name = $designation_detail->designation_name;
                }

                if (!empty($grade_detail)) {
                    $grade_id = $grade_detail->grade_id;
                    $grade_name = $grade_detail->grade_name;
                }

                // $relationship_status_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($val['pms_employee_id'],$time_period_id);
                $track_status = '0';
                $track_status = $this->apraiseemodel->get_employee_track_status($employee_detail['pms_employee_id'], $val['time_period_id']);

                $apraiser_employee_id = $this->session->userdata('pms_employee_id');

                //Get Submit Status
                $sql = "select * from " . $this->db->dbprefix . "employee_relationship_materix 
                        where pms_employee_id = '" . $employee_detail['pms_employee_id'] . "' 
                        and time_period_id = '" . $val['time_period_id'] . "'  
                        and apraiser_employee_id = '" . $apraiser_employee_id . "' ";
                $query = $this->db->query($sql);
                $result1 = $query->result();

                //Get Count
                $sql = "SELECT count(*) as howmany from " . $this->db->dbprefix . "apraisee_kra 
                        WHERE pms_employee_id = '" . $employee_detail['pms_employee_id'] . "' 
                        and time_period_id = '" . $val['time_period_id'] . "'  
                        and current_apraiser_id = '" . $apraiser_employee_id . "' 
                        and apraisee_kra_approve_status = 1";
                //echo $sql;
                $query = $this->db->query($sql);
                $result2 = $query->result();
                $submit_status_of_rel=0.0;
                if(!empty($result1))
                {
                    $submit_status_of_rel = $result1[0]->submit_status;
                }
                
                $time_period_info = $this->taskschedulemodel->get_time_period_by_id($val['time_period_id']);
                $time_period_name ='';
                if(!empty($time_period_info))
                {
                   $time_period_name =  $time_period_info['time_period_from'].'-'.$time_period_info['time_period_to'];
                }
                if (($track_status == 0.2 || $track_status == 0.1) && ($submit_status_of_rel==0.2)) {

                    $employee_list[] = array(
                        'pms_employee_id' => $employee_detail['pms_employee_id'],
                        'employee_id' => $employee_detail['employee_id'],
                        'time_period_id' => $val['time_period_id'],
                        'employee_name' => $employee_detail['fname'] . ' ' . $employee_detail['lname'],
                        'fname' => $employee_detail['fname'],
                        'mname' => $employee_detail['mname'],
                        'lname' => $employee_detail['lname'],
                        'time_period_name' =>$time_period_name,
                        'designation_id' => $employee_detail['designation_id'],
                        'department_id' => $employee_detail['department_id'],
                        'grade_id' => $grade_id,
                        'designation_id' => $employee_detail['designation_id'],
                        'designation_name' => $designation_name,
                        'department_name' => $department_name,
                        'grade_name' => $grade_name,
                        'date_of_joining' => date($data['s_date_format'], strtotime($employee_detail['date_of_joining'])),
                        'track_status' => $track_status,
                        'apraiser_employee_id' => $apraiser_employee_id,
                        'submit_status' => $result1[0]->submit_status,
                        'pending_count' => $result2[0]->howmany
                    );
                }
            }
        }
        
//        echo "<pre>";
//        print_r($employee_list);
//        echo "</pre>";
//        die();


        return $employee_list;
         
     }
    
    function get_relationship_by_id($employee_relationship_materix_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'employee_relationship_materix');
        $this->db->where('employee_relationship_materix_id', $employee_relationship_materix_id);
        //$this->db->where('time_period_id',$time_period_id);
        $query = $this->db->get();
        $row = $query->first_row('array');
        return $row;
    }

    
    public function getEmployeeTechnicalDetailMultiple($pms_employee_id, $arr_apraiser_employee_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'apraiser_technical');
        $this->db->where('pms_employee_id', $pms_employee_id);
        $this->db->where_in('apraiser_employee_id', $arr_apraiser_employee_id);
        $query = $this->db->get();
        $row = $query->result_array();
        
        return $row;
    }
    
    public function getEmployeeBehaviouralDetailMultiple($pms_employee_id, $arr_apraiser_employee_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'apraiser_behavioural');
        $this->db->where('pms_employee_id', $pms_employee_id);
        $this->db->where_in('apraiser_employee_id', $arr_apraiser_employee_id);
        $query = $this->db->get();
        $row = $query->result_array();
        return $row;
    }    
    
    
    function getCompetencyScore($competency_id,$scale=1)
    {
        // select * from pms_competencies_for_refrence
        // LEFT JOIN pms_weightage
        /**
         *select * from pms_weightage
select * from pms_apraiser_competency_with_idp
select * from pms_competencies_for_refrence
LEFT JOIN pms_weightage
select * from pms_weightage

((pms_weightage.weightage_value * pms_apraiser_competency_with_idp.scale ) / 100 )
         * 
         *  
         */
        
        $sql = "SELECT * FROM " . $this->db->dbprefix . "competencies_for_refrence cr
            LEFT JOIN " . $this->db->dbprefix . "weightage w ON w.weightage_id = cr.weightage_id 
            WHERE cr.competencies_for_refrence_id = '" . $competency_id . "' " ;
        $query = $this->db->query($sql);
        $result = $query->first_row();
        //echo '<pre>';
        //print_r($result);
        //echo '</pre>';
        
        $output = (( $result->weightage_value * $scale ) / 100 );
        
        return $output;  ;
    }
    
    
    function get_first_appraiser($appraisee_employee_id,$time_period_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee_relationship_materix' );
       $this->db->where('pms_employee_id',$appraisee_employee_id);
       $this->db->where('time_period_id',$time_period_id);
       $this->db->order_by("employee_relationship_materix_id", "asc");
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;
    }
    
    
    function check_is_all_appraiser_fillup_pms($appraisee_employee_id,$first_appraiser_employee_id,$time_period_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee_relationship_materix' );
       $this->db->where('pms_employee_id',$appraisee_employee_id);
       $this->db->where('time_period_id',$time_period_id);
       $this->db->where('submit_status <','6');
       $this->db->where('apraiser_employee_id !=',$first_appraiser_employee_id);
       $this->db->order_by("employee_relationship_materix_id", "asc");
       $query = $this->db->get();
       $row = $query->result_array();
      
       if(!empty($row))
       {
           return 'N';
       }
       else
       {
           return 'Y';
       }
       return $row;
       
    }
    
    
    function check_is_appraiser_pms_process_complete($appraisee_employee_id,$time_period_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'employee_relationship_materix' );
       $this->db->where('pms_employee_id',$appraisee_employee_id);
       $this->db->where('time_period_id',$time_period_id);
       $this->db->where('submit_status <','6');
       //$this->db->where('apraiser_employee_id !=',$first_appraiser_employee_id);
       $this->db->order_by("employee_relationship_materix_id", "asc");
       $query = $this->db->get();
       $row = $query->result_array();
      
       if(!empty($row))
       {
           return 'N';
       }
       else
       {
           return 'Y';
       }
       return $row;
       
    }
    
    
    function add_not_Approve_Comment($data = array())
    {
        $result = $this->db->insert($this->db->dbprefix . 'apraiser_not_approve_comment', $data);
        return $result;
    }
    
    
    function get_not_approve_comment($apraisee_employee_id,$apraiser_employee_id,$time_period_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'apraiser_not_approve_comment' );
       $this->db->where('apraisee_employee_id',$apraisee_employee_id);
       $this->db->where('apraiser_employee_id',$apraiser_employee_id);
       $this->db->where('time_period_id',$time_period_id);
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;
    }
    
    function get_apraiser_kra($apraisee_employee_id,$apraiser_employee_id,$time_period_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'apraisee_kra' );
       $this->db->where('pms_employee_id',$apraisee_employee_id);
       $this->db->where('current_apraiser_id',$apraiser_employee_id);
       $this->db->where('time_period_id',$time_period_id);
       $this->db->order_by("apraisee_kra_id", "asc");
       $query = $this->db->get();
       $row = $query->result_array();
       $kras = array();
       if(!empty($row))
       {
           foreach($row as $key=>$val)
           {
               $appraiser_detail = $this->employeemodel->get_employee_by_id($val['current_apraiser_id']);
               $weightage_info = $this->commonmodel->getWeightageByid($val['weightage_id']);
                if (!empty($appraiser_detail)) 
                {
                   $appraiser_name_with_designation = $appraiser_detail['fname'] . ' ' . $appraiser_detail['lname'] . ', ' . $appraiser_detail['designation_name'];
                   $val['appraiser_name_designation'] = $appraiser_name_with_designation;
                   $val['weightage_value'] = $weightage_info['weightage_value'];
                }
                $kras[] = $val;
           }
           
       }
       return $kras;
    }
    
    //for approvel list employee of both year
     function get_employee_for_curt_and_imediate_prev_year($apraiser_employee_id, $time_period_id = array()) {
        $employee_id = array();
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'employee_relationship_materix');
        $this->db->where('apraiser_employee_id', $apraiser_employee_id);
        $this->db->where_in('time_period_id', $time_period_id);
        $query = $this->db->get();
        $row = $query->result_array();
        return $row;
    }
   
   
    
}