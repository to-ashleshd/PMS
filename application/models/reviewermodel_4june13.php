<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reviewermodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getEmployeeApriseelist($pms_employee_id, $status) {
        $time_period_id = '1';
        // $time_period_detail                 = $this->commonmodel->get_current_year();
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

            $employee_ids = $this->getEmplyeeIdsByReviewerID($pms_employee_id, $time_period_id);
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
        //echo $this->db->last_query();
        if (!empty($employee_detail)) {

            foreach ($employee_detail as $key => $val) {
                $designation_name = '';
                $grade_id = '';
                $grade_name = '';
                $department_name = '';
                $submit_status = '';
                $overall_rating = 'N.A.';
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
                $relationship_status_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($val['pms_employee_id'], $time_period_id);

                $reviewer_employee_id = '';
                if ($relationship_status_detail) {
                    $submit_status = $relationship_status_detail[0]['submit_status'];
                    $reviewer_employee_id = $relationship_status_detail[0]['reviewer_employee_id'];
                    if ($submit_status >= '6') {
                        $overall_rating_by_apraiser = $this->getOverallRatingDetail($val['pms_employee_id'], $relationship_status_detail[0]['apraiser_employee_id'], $time_period_id);
                        if (!empty($overall_rating_by_apraiser)) {
                            $overall_rating_name = $this->getScoreNameByScore($overall_rating_by_apraiser[0]['apraiser_score']);
                            $overall_rating = number_format($overall_rating_by_apraiser[0]['apraiser_score'], '2', '.', '') . ' / ' . $overall_rating_name;
                        }
                    }
                }



                $apraiser_overall_rating = '';
                $overall_kra_score_for_list = $this->getOverallRatingForApraisee($val['pms_employee_id'], $time_period_id);
                $overall_kra_score_for_appraiser = $this->getOverallRatingForApraisee($val['pms_employee_id'], $time_period_id);
                //echo '<pre>';
                //print_r($overall_kra_score_for_list);
                //echo '</pre>';

                $employee_list[] = array(
                    'pms_employee_id' => $val['pms_employee_id'],
                    'employee_id' => $val['employee_id'],
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
                    'overall_rating' => $overall_rating,
                    'reviewer_employee_id' => $reviewer_employee_id,
                    'overall_kra_score' => $overall_kra_score_for_list,
                    'overall_kra_score_name' => $this->getScoreNameByScore($overall_kra_score_for_list['overall_total']),
                    'overall_kra_score_for_appraiser' => $overall_kra_score_for_appraiser,
                    'appraisee_overall_rating' => $this->getOverallRatingOfAppraiseeByAppraiser($val['pms_employee_id'], $time_period_id)
                );
            }
        }

        return $employee_list;
    }

    function getEmplyeeIdsByReviewerID($reviewer_employee_id, $time_period_id) {
        $employee_id = array();
        $this->db->select('pms_employee_id');
        $this->db->from($this->db->dbprefix . 'employee_relationship_materix');
        $this->db->where('reviewer_employee_id', $reviewer_employee_id);
        $this->db->where('time_period_id', $time_period_id);
        $query = $this->db->get();
        $row = $query->result_array();

        if (!empty($row)) {
            foreach ($row as $key => $val) {
                $employee_id[] = $val['pms_employee_id'];
            }
        }

        return $employee_id;
    }

    function getRelationshipStatus($pms_employee_id, $review_employee_id, $time_period_id) {

        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'employee_relationship_materix');
        $this->db->where('pms_employee_id', $pms_employee_id);
        $this->db->where('time_period_id', $time_period_id);
        $this->db->where('reviewer_employee_id', $review_employee_id);
        $query = $this->db->get();
        $row = $query->first_row('array');
        return $row;
    }

    function addApraiseeKraByReviewer($data = array()) {

        $result = $this->db->insert($this->db->dbprefix . 'reviewer_kra', $data);
        return $result;
    }

    function getApraiserKraPmsDetail($apraisee_employee_id, $apraiser_employee_id) {
        $this->load->model('commonmodel');
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'apraiser_kra');
        $this->db->where('apraiser_kra.apraisee_employee_id', $apraisee_employee_id);
        $this->db->where('apraiser_kra.apraiser_employee_id', $apraiser_employee_id);
        //$this->db->where_in('apraiser_kra.apraiser_employee_id', array('15', '17'));
        $this->db->join($this->db->dbprefix . 'apraisee_pms', 'apraisee_pms.apraisee_pms_id = apraiser_kra.apraisee_pms_id', 'left');
        $this->db->join($this->db->dbprefix . 'apraisee_kra', 'apraisee_pms.apraisee_kra_id = apraisee_kra.apraisee_kra_id', 'left');
        $query = $this->db->get();
        $row = $query->result_array();
        //echo '<br>Review Query: ' . $this->db->last_query();
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
            }
        }

        return $details;
    }

    function getReviewerKraPmsDetail($apraisee_employee_id, $apraiser_employee_id, $reviewer_employee_id) {
        $time_period_id = '1';
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'reviewer_kra');
        $this->db->where('reviewer_kra.reviewer_employee_id', $reviewer_employee_id);
        $this->db->where('reviewer_kra.apraiser_employee_id', $apraiser_employee_id);
        $this->db->where('reviewer_kra.apraisee_employee_id', $apraisee_employee_id);
        $this->db->where('reviewer_kra.time_period_id', $time_period_id);

        $this->db->join($this->db->dbprefix . 'apraiser_kra', 'apraiser_kra.apraiser_kra_id = reviewer_kra.apraiser_kra_id', 'left');
        $this->db->join($this->db->dbprefix . 'apraisee_pms', 'apraisee_pms.apraisee_pms_id = apraiser_kra.apraisee_pms_id', 'left');
        $this->db->join($this->db->dbprefix . 'apraisee_kra', 'apraisee_pms.apraisee_kra_id = apraisee_kra.apraisee_kra_id', 'left');

        $query = $this->db->get();
        $row = $query->result_array();

        //echo '<br>Reviewer SQL: ' . $this->db->last_query();

        $details = array();
        if (!empty($row)) {
            $details = $row;
            foreach ($details as $key => $val) {

                $weightage_detail = $this->commonmodel->getWeightageByid($val['weightage_id']);
                $self_rating_detail = $this->commonmodel->getRatingByid($val['rating_id']);
                $apraiser_rating_detail = $this->commonmodel->getRatingByid($val['apraiser_rating_id']);
                $reviewer_rating_detail = $this->commonmodel->getRatingByid($val['reviewer_rating_id']);

                $total_score = ( (($weightage_detail['weightage_value']) * ($reviewer_rating_detail['rating_value'])) / 100 );
                $details[$key]['weightage_name'] = $weightage_detail['weightage_value'];
                $details[$key]['self_rating_name'] = $self_rating_detail['rating_name'];
                $details[$key]['self_rating_value'] = $self_rating_detail['rating_value'];
                $details[$key]['apraiser_rating_name'] = $apraiser_rating_detail['rating_name'];
                $details[$key]['apraiser_rating_value'] = $apraiser_rating_detail['rating_value'];
                $details[$key]['reviewer_rating_name'] = $reviewer_rating_detail['rating_name'];
                $details[$key]['reviewer_rating_value'] = $reviewer_rating_detail['rating_value'];
                $details[$key]['total_score'] = number_format($total_score, 2, '.', '');
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
        $result = $this->db->insert($this->db->dbprefix . 'reviewer_competency_with_idp', $data);
        return $result;
    }

    public function addCompetencyTechnicalOFApraisee($data = array()) {
        $result = $this->db->insert($this->db->dbprefix . 'reviewer_technical', $data);
        return $result;
    }

    public function addCompetencyBehaviouralOFApraisee($data = array()) {
        $result = $this->db->insert($this->db->dbprefix . 'reviewer_behavioural', $data);
        return $result;
    }

    public function getEmployeeCompetenciesWithIdp($pms_employee_id, $reviewer_employee_id, $time_period_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'reviewer_competency_with_idp');
        $this->db->where('pms_employee_id', $pms_employee_id);
        $this->db->where('reviewer_employee_id', $reviewer_employee_id);
        $this->db->where('reviewer_competency_with_idp.time_period_id', $time_period_id);
        $this->db->join($this->db->dbprefix . 'competencies_for_refrence', 'competencies_for_refrence.competencies_for_refrence_id = reviewer_competency_with_idp.competencies_for_refrence_id', 'left');
        $this->db->join($this->db->dbprefix . 'weightage', 'weightage.weightage_id = competencies_for_refrence.weightage_id', 'left');
        $query = $this->db->get();
        $row = $query->result_array();
        $details = array();
        if (!empty($row)) {
            $details = $row;
            foreach ($details as $key => $val) {
                $details[$key]['total_score'] = ((($val['weightage_value']) * ($val['scale'])) / 100);
            }
        }
        return $details;
    }

    public function getEmployeeTechnicalDetail($pms_employee_id, $reviewer_employee_id, $time_period_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'reviewer_technical');
        $this->db->where('pms_employee_id', $pms_employee_id);
        $this->db->where('reviewer_employee_id', $reviewer_employee_id);
        $this->db->where('time_period_id', $time_period_id);
        $query = $this->db->get();
        $row = $query->result_array();
        return $row;
    }

    public function getEmployeeBehaviouralDetail($pms_employee_id, $reviewer_employee_id, $time_period_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'reviewer_behavioural');
        $this->db->where('pms_employee_id', $pms_employee_id);
        $this->db->where('reviewer_employee_id', $reviewer_employee_id);
        $this->db->where('time_period_id', $time_period_id);
        $query = $this->db->get();
        $row = $query->result_array();
        return $row;
    }

    public function addReviewerOverallRating($data = array()) {
        $result = $this->db->insert($this->db->dbprefix . 'reviewer_overall_rating', $data);
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
        // echo $this->db->last_query();
        return $row;
    }

    function getScoreNameByScore($score) {
        $score_name = '';
        $score = round($score, 2);
        if ($score < 1) {
            $score_name = 'Not Rated Yet';
        } elseif ($score < 2) {
            $score_name = 'BE';
        } elseif ($score >= 2 && $score < 2.79) {
            $score_name = 'NI';
        } elseif ($score >= 2.80 && $score < 3.49) {
            $score_name = 'ME';
        } elseif ($score >= 3.50 && $score < 4.24) {
            $score_name = 'EE';
        } elseif ($score >= 4.25 && $score <= 5.00) {
            $score_name = 'FEE';
        }
        return $score_name;
    }

    function getApraiserTotalKraScore($apraisee_employee_id, $apraiser_employee_id, $time_period_id) {
        $response = array();
        $response['kra_detail'] = $this->apraisermodel->getApraiserKraPmsDetail($apraisee_employee_id, $apraiser_employee_id);

        $final_score = 0;
        $response['final_score'] = '';
        if (!empty($response['kra_detail'])) {
            foreach ($response['kra_detail'] as $key => $val) {
                if ($final_score == 0) {
                    $final_score = ((($val['weightage_name']) * ($val['apraiser_rating_value'])) / 100);
                } else {
                    $final_score += ((($val['weightage_name']) * ($val['apraiser_rating_value'])) / 100);
                }
            }
            $response['final_score'] = number_format($final_score, 2, '.', '');
            $response['final_score'] = number_format((($response['final_score'] * 70) / 100), 2, '.', '');
        }


        return $response['final_score'];
    }

    function getApraiserTotalCompetenciesScore($apraisee_employee_id, $apraiser_employee_id, $time_period_id) {
        $response = array();
        $response['competency_with_idp_detail'] = $this->apraisermodel->getEmployeeCompetenciesWithIdp($apraisee_employee_id, $apraiser_employee_id);
        $response['final_score_cwi'] = '';
        $response['final_score'] = '';
        if (!empty($response['competency_with_idp_detail'])) {
            foreach ($response['competency_with_idp_detail'] as $keycwi => $valcwi) {
                if ($response['final_score_cwi'] == '') {
                    $response['final_score_cwi'] = ($valcwi['total_score']);
                } else {
                    $response['final_score_cwi'] += ($valcwi['total_score']);
                }
            }
            $response['final_score'] = number_format($response['final_score_cwi'], 2, '.', '');
            $response['final_score'] = number_format((($response['final_score'] * 30) / 100), 2, '.', '');
        }
        return $response['final_score'];
    }

    function getReviewerOverAllRatingById($pms_employee_id, $apraiser_employee_id, $reviewer_employee_id, $time_period_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'reviewer_overall_rating');
        $this->db->where('pms_employee_id', $pms_employee_id);
        $this->db->where('apraiser_employee_id', $apraiser_employee_id);
        $this->db->where('reviewer_employee_id', $reviewer_employee_id);
        $this->db->where('time_period_id', $time_period_id);
        $query = $this->db->get();
        $row = $query->first_row('array');
        return $row;
    }

    function getApraiserKraPmsDetailMultiple($apraisee_employee_id, $arr_apraiser_employee_id) {
        $this->load->model('commonmodel');
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'apraiser_kra');
        $this->db->where('apraiser_kra.apraisee_employee_id', $apraisee_employee_id);
        //$this->db->where('apraiser_kra.apraiser_employee_id',$apraiser_employee_id);
        $this->db->where_in('apraiser_kra.apraiser_employee_id', $arr_apraiser_employee_id);
        $this->db->join($this->db->dbprefix . 'apraisee_pms', 'apraisee_pms.apraisee_pms_id = apraiser_kra.apraisee_pms_id', 'left');
        $this->db->join($this->db->dbprefix . 'apraisee_kra', 'apraisee_pms.apraisee_kra_id = apraisee_kra.apraisee_kra_id', 'left');
        $query = $this->db->get();
        $row = $query->result_array();
        //echo '<br>Review Multiple Query: ' . $this->db->last_query();
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
            }
        }

        return $details;
    }

    function getRelationshipStatusMultiple($pms_employee_id, $review_employee_id, $time_period_id) {

        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'employee_relationship_materix');
        $this->db->where('pms_employee_id', $pms_employee_id);
        $this->db->where('time_period_id', $time_period_id);
        $this->db->where('reviewer_employee_id', $review_employee_id);
        $query = $this->db->get();
        $row = $query->result('array');
        return $row;
    }

    function getReviewerKraPmsDetailMultiple($apraisee_employee_id, $arr_apraiser_employee_id, $reviewer_employee_id) {
        $time_period_id = '1';
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'reviewer_kra');
        $this->db->where('reviewer_kra.reviewer_employee_id', $reviewer_employee_id);
        //$this->db->where('reviewer_kra.apraiser_employee_id', $apraiser_employee_id);
        $this->db->where_in('reviewer_kra.apraiser_employee_id', $arr_apraiser_employee_id);
        $this->db->where('reviewer_kra.apraisee_employee_id', $apraisee_employee_id);
        $this->db->where('reviewer_kra.time_period_id', $time_period_id);

        $this->db->join($this->db->dbprefix . 'apraiser_kra', 'apraiser_kra.apraiser_kra_id = reviewer_kra.apraiser_kra_id', 'left');
        $this->db->join($this->db->dbprefix . 'apraisee_pms', 'apraisee_pms.apraisee_pms_id = apraiser_kra.apraisee_pms_id', 'left');
        $this->db->join($this->db->dbprefix . 'apraisee_kra', 'apraisee_pms.apraisee_kra_id = apraisee_kra.apraisee_kra_id', 'left');

        $query = $this->db->get();
        $row = $query->result_array();

        //echo '<br>Reviewer SQL: ' . $this->db->last_query();

        $details = array();
        if (!empty($row)) {
            $details = $row;
            foreach ($details as $key => $val) {

                $weightage_detail = $this->commonmodel->getWeightageByid($val['weightage_id']);
                $self_rating_detail = $this->commonmodel->getRatingByid($val['rating_id']);
                $apraiser_rating_detail = $this->commonmodel->getRatingByid($val['apraiser_rating_id']);
                $reviewer_rating_detail = $this->commonmodel->getRatingByid($val['reviewer_rating_id']);

                $total_score = ( (($weightage_detail['weightage_value']) * ($reviewer_rating_detail['rating_value'])) / 100 );
                $details[$key]['weightage_name'] = $weightage_detail['weightage_value'];
                $details[$key]['self_rating_name'] = $self_rating_detail['rating_name'];
                $details[$key]['self_rating_value'] = $self_rating_detail['rating_value'];
                $details[$key]['apraiser_rating_name'] = $apraiser_rating_detail['rating_name'];
                $details[$key]['apraiser_rating_value'] = $apraiser_rating_detail['rating_value'];
                $details[$key]['reviewer_rating_name'] = $reviewer_rating_detail['rating_name'];
                $details[$key]['reviewer_rating_value'] = $reviewer_rating_detail['rating_value'];
                $details[$key]['total_score'] = number_format($total_score, 2, '.', '');
            }
        }

        return $details;
    }

    function getOverallRatingForApraisee($apraisee_id, $time_period_id = 1) {
        $data = array();
        $output = array();

        $sql = "SELECT group_concat(apraiser_employee_id) as apraisers  
                FROM " . $this->db->dbprefix . "employee_relationship_materix 
                WHERE pms_employee_id = '" . $apraisee_id . "' 
                AND time_period_id = '" . $time_period_id . "' ";
        //echo $sql;
        $query = $this->db->query($sql);
        $result = $query->first_row();

        $arrApraisers = explode(',', $result->apraisers);

        //Setup vars
        $kra_scroe = '';
        $competency_score = '';


        //Loop Throuth all Apraisers
        $arrKrainfo = array();
        $arrCompetency = array();
        $no_of_apraisers = count($arrApraisers);

        foreach ($arrApraisers as $row_apraiser_employee_id) {
            $data['apraiser_kra_detail'] = $this->apraisermodel->getApraiserKraPmsDetail($apraisee_id, $row_apraiser_employee_id);
            if (!empty($data['apraiser_kra_detail'])) {
                //echo '<br> apraiser_employee_id: ' . $row_apraiser_employee_id;
                $kra_individual_scroe = 0;
                foreach ($data['apraiser_kra_detail'] as $keyd => $vald) {
                    $kra_scroe += ($vald['total_score']);

                    //Add KRA Individual Score
                    $kra_individual_scroe = $kra_individual_scroe + ($vald['total_score']);
                }
                $arrKrainfo[$row_apraiser_employee_id]['total'] = $kra_individual_scroe;
                $arrKrainfo[$row_apraiser_employee_id]['with_70'] = number_format((($kra_individual_scroe * 70) / 100), 2);
            }

            //COMPETENCIES 
            $data['competency_with_idp_detail'] = $this->apraisermodel->getEmployeeCompetenciesWithIdp($apraisee_id, $row_apraiser_employee_id);
            if (!empty($data['competency_with_idp_detail'])) {
                $competency_individual_score = 0;

                foreach ($data['competency_with_idp_detail'] as $keycwi => $valcwi) {
                    $competency_score = $competency_score + ($valcwi['total_score']);
                    $competency_individual_score = $competency_individual_score + ($valcwi['total_score']);
                }
                $arrCompetency[$row_apraiser_employee_id]['total'] = $competency_individual_score;
                $arrCompetency[$row_apraiser_employee_id]['with_30'] = number_format((($competency_individual_score * 30) / 100), 2);
            }
        }

        //echo '<br>Only KRA ' . $kra_scroe;
        //KRA Score did not divided by $no_of_apraisers 
        //Competency divided by by $no_of_apraisers 

        $overall_kra_score = number_format((( $kra_scroe * 70 ) / 100), 2, '.', '');
        $overall_competency_score = number_format((( ($competency_score / $no_of_apraisers) * 30 ) / 100), 2, '.', '');


        //echo '<br>Overall KRA Score ' . $overall_kra_score;

        $output['overall_kra_score'] = $overall_kra_score;
        $output['overall_competency_score'] = $overall_competency_score;
        $output['overall_total'] = $overall_kra_score + $overall_competency_score;

        return $output;
    }

    public function copyOverallRatingIAgree($apraisee_employee_id, $reviewer_employee_id, $time_period_id) {
        //Collect all appraisee info

        $appraisee_rating = $this->getOverallRatingOfAppraiseeByAppraiser($apraisee_employee_id, $time_period_id);

        //print_r($appraisee_rating);
        //Copy to Reviewer Overall Rating
        //foreach($appraisee_rating as $key=>$row) {
        $revdata = array();
        //print_r($row);
        //die();
        $revdata['pms_employee_id'] = $apraisee_employee_id;
        $revdata['reviewer_employee_id'] = $reviewer_employee_id;
        $revdata['time_period_id'] = $time_period_id;
        $revdata['reviewer_score'] = $appraisee_rating['overall_rating'];
        $revdata['competency_score'] = $appraisee_rating['competency_score'];
        $revdata['kra_score'] = $appraisee_rating['kra_score'];
        $revdata['date_created'] = date("Y-m-d H:i:s");
        $revdata['ip_address'] = $this->input->ip_address();

        $this->db->insert($this->db->dbprefix . "reviewer_overall_rating", $revdata);

        //}
    }

    public function getOverallRatingOfAppraiseeByAppraiser($apraisee_employee_id, $time_period_id) {
        //Collect all appraisee info
        $output = array();

        $sql = "SELECT * FROM " . $this->db->dbprefix . "apraiser_overall_rating orating 
                WHERE orating.pms_employee_id = '" . $apraisee_employee_id . "' 
                AND orating.time_period_id = '" . $time_period_id . "' ";
        //echo $sql ;
        $query_m = $this->db->query($sql);
        //echo '<pre>';
        //print_r($query_m);
        //echo '</pre>';
        //Bug 4
        //Bugfix for Check count Relationship appraisee and overall rating 
        $result_relationship = $this->apraiseemodel->getRelationshipDetailOfEmployee($apraisee_employee_id, $time_period_id);
        $result_relationship_count = count($result_relationship);



        $apraiser_score = 0;
        $kra_score = 0;
        $competency_score = 0;
        $total_appraisers = 0;
        foreach ($query_m->result() as $row) {
            //print_r($row);
            $apraiser_score = $apraiser_score + $row->apraiser_score;
            $kra_score = $kra_score + $row->kra_score;
            $competency_score = number_format($competency_score, 2, '.', '') + number_format($row->competency_score, 2, '.', '');
            $total_appraisers++;
        }

        /**
          if ($apraisee_employee_id == '83') {
          echo '<br>Total Rows: ' . $query_m->num_rows . ' Id: ' . $apraisee_employee_id;
          $result = $this->apraiseemodel->getRelationshipDetailOfEmployee($apraisee_employee_id, $time_period_id);
          echo '<pre>';
          print_r($result);
          echo '<br>Count: ' . count($result);
          echo '</pre>';
          }
         * 
         */
        //Bug fix 4
        if ($result_relationship_count == $total_appraisers) {
            //If Relationship matirx count and result are same
            //Calculate Average Competency
            if ($total_appraisers == 0) {
                //i.e. No KRA filled up or Appraiser did not give any rating. Set to Zero '0;

                $output['average_competency_score'] = 0;
                $output['apraiser_score'] = 0;
                $output['kra_score'] = 0;
                $output['competency_score'] = 0;
                $output['overall_rating'] = 0;
                $output['total_appraisers'] = 0;
                $output['score_rating'] = $this->getScoreNameByScore($output['overall_rating']);
            } else {
                $average_competency_score = number_format(($competency_score / $total_appraisers), 2, '.', '');
                $output['average_competency_score'] = $average_competency_score;
                $output['apraiser_score'] = $apraiser_score;
                $output['kra_score'] = number_format($kra_score, 2, '.', '');
                $output['competency_score'] = number_format($competency_score, 2, '.', '');
                $output['overall_rating'] = number_format($kra_score + $average_competency_score, 2, '.', '');
                $output['total_appraisers'] = $total_appraisers;
                $output['score_rating'] = $this->getScoreNameByScore($output['overall_rating']);
            }
        } else {
            //All appraisers did not complete his process

            $output['average_competency_score'] = 0;
            $output['apraiser_score'] = 0;
            $output['kra_score'] = 0;
            $output['competency_score'] = 0;
            $output['overall_rating'] = 0;
            $output['total_appraisers'] = 0;
            $output['score_rating'] = $this->getScoreNameByScore($output['overall_rating']) ;
        }


        //die();

        return $output;
    }

    public function getOverallRatingOfAppraiseeByReviewer($apraisee_employee_id, $reviewer_employee_id, $time_period_id) {
        //Collect all appraisee info
        $output = array();

        $sql = "SELECT * FROM " . $this->db->dbprefix . "reviewer_overall_rating orating 
                WHERE orating.pms_employee_id = '" . $apraisee_employee_id . "' 
                AND orating.reviewer_employee_id ='" . $reviewer_employee_id . "' 
                AND orating.time_period_id = '" . $time_period_id . "' ";
        //echo $sql ;
        $query_m = $this->db->query($sql);



        $reviewer_score = 0;
        $kra_score = 0;
        $competency_score = 0;
        $total_appraisers = 0;
        foreach ($query_m->result() as $row) {
            //print_r($row);
            $reviewer_score = $reviewer_score + $row->reviewer_score;
            $kra_score = $kra_score + $row->kra_score;
            $competency_score = number_format($competency_score, 2, '.', '') + number_format($row->competency_score, 2, '.', '');
            $total_appraisers++;
        }
        //Calculate Average Competency
        if ($total_appraisers == 0) {
            //i.e. No KRA filled up or Appraiser did not give any rating. Set to Zero '0;

            $output['average_competency_score'] = 0;
            $output['reviewer_score'] = 0;
            $output['kra_score'] = 0;
            $output['competency_score'] = 0;
            $output['overall_rating'] = 0;
            $output['total_appraisers'] = 0;
            $output['score_rating'] = $this->getScoreNameByScore($output['overall_rating']);
        } else {
            $average_competency_score = number_format(($competency_score / $total_appraisers), 2, '.', '');
            $output['average_competency_score'] = $average_competency_score;
            $output['reviewer_score'] = $reviewer_score;
            $output['kra_score'] = number_format($kra_score, 2, '.', '');
            $output['competency_score'] = number_format($competency_score, 2, '.', '');
            $output['overall_rating'] = number_format($kra_score + $average_competency_score, 2, '.', '');
            $output['total_appraisers'] = $total_appraisers;
            $output['score_rating'] = $this->getScoreNameByScore($output['overall_rating']);
        }

        return $output;
    }

}