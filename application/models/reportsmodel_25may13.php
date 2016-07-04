<?php

//session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reportsmodel extends CI_Model {

    function isMeReviewer($empid) {
        $query = $this->db->query("SELECT count(*) as howmany FROM " . $this->db->dbprefix . "employee_relationship_materix WHERE reviewer_employee_id='" . $empid . "' ");
        $row = $query->first_row();
        return $row->howmany;
    }

    function isMeAppraiser($empid) {
        $query = $this->db->query("SELECT count(*) as howmany FROM " . $this->db->dbprefix . "employee_relationship_materix WHERE apraiser_employee_id='" . $empid . "' ");
        $row = $query->first_row();
        return $row->howmany;
    }

    function isMeAppraisee($empid) {
        $query = $this->db->query("SELECT count(*) as howmany FROM " . $this->db->dbprefix . "employee_relationship_materix WHERE pms_employee_id='" . $empid . "' ");
        $row = $query->first_row();
        return $row->howmany;
    }

    function whoiam($empid) {
        //Get who I am
        // 1) Appraisee
        // 2) Appraiser        
        // 3) Reviewer
        $output = 'nopms';
        //TODO: use numeric status if possible - Ajay

        $isMeReviewer = $this->isMeReviewer($empid);
        $isMeAppraiser = $this->isMeAppraiser($empid);
        $isMeAppraisee = $this->isMeAppraisee($empid);

        if ($isMeReviewer >= 1) {
            $output = 'reviewer';
        } else if ($isMeAppraiser >= 1) {
            $output = 'appraiser';
        } else if ($isMeAppraisee >= 1) {
            $output = 'appraisee';
        }

        return $output;
    }

    //employee_relationship_materix
    function old_getSubmitStatus($empid) {
        $query = $this->db->query("SELECT submit_status FROM " . $this->db->dbprefix . "employee_relationship_materix WHERE pms_employee_id='" . $empid . "' ");
        $row = $query->first_row();
        //echo $this->db->last_query();
        //print_r($row);
        if (!$row) {
            return 0;
        } else {
            return $row->submit_status;
        }
    }

    //update by on 17-5-2013
    function getSubmitStatus($empid, $time_period_id = 1) {
        $query = $this->db->query("SELECT submit_status FROM " . $this->db->dbprefix . "employee_relationship_materix WHERE pms_employee_id='" . $empid . "' AND time_period_id='" . $time_period_id . "' ");
        $row = $query->first_row();
        //echo $this->db->last_query();
        //print_r($row);
        if (!$row) {
            return 0;
        } else {
            return $row->submit_status;
        }
    }

    function getNonrelatedEmp() {
        $totalfound = array();
        $query = $this->db->query("SELECT pms_employee_id from " . $this->db->dbprefix . "employee ");
        foreach ($query->result() as $key => $val) {
            if ($this->whoiam($val->pms_employee_id) == 'nopms') {
                $totalfound[] = $val->pms_employee_id;
            }
        }


        return $totalfound;
    }

    function getSubmitStatusAll($empid = '', $myrole = '', $time_period_id = 1) {
        $sql_where = '';
        if ($empid >= 1 and $myrole == 'reviewer') {
            $sql_where = " AND reviewer_employee_id='" . $empid . "' "; //AND time_period_id='" . $time_period_id . "' " ;
            //TODO: Fixed for avoid duplicate vaules in count for reviewer
            $sql_new = "select rm.employee_relationship_materix_id 
                        FROM " . $this->db->dbprefix . "employee_relationship_materix rm
                        WHERE rm.reviewer_employee_id = 16
                        and time_period_id = 1
                        group by rm.pms_employee_id
                        ";
            $sql_where = " AND employee_relationship_materix_id IN(" . $sql_new . ") ";
        }
        if ($myrole == 'appraiser') {
            $sql_where = " AND apraiser_employee_id='" . $empid . "' "; //AND time_period_id='" . $time_period_id . "' " ;
        }


        $sql = "SELECT submit_status, count(submit_status) as howmany
                FROM " . $this->db->dbprefix . "employee_relationship_materix 
                WHERE 1 AND time_period_id='" . $time_period_id . "' " . $sql_where . "
                Group by submit_status";
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo $this->db->last_query();
        return $result;
    }

    function getEmployeeApriseelistForIDP($pms_employee_id, $status) {
        $time_period_id = '1';

        $whoiam = $this->reportsmodel->whoiam($pms_employee_id);
        //echo 'Who I am ' . $whoiam;

        $this->load->model('commonmodel');
        $this->load->model('employeemodel');
        $this->load->model('apraiseemodel');
        $employee_detail = array();
        $employee_list = array();
        if ($pms_employee_id == '1') {
            $employee_ids = $this->employeemodel->getAllEmployeeIDs($pms_employee_id);
        } else if ($whoiam == 'appraiser') {
            $employee_ids = $this->getEmplyeeIdsByAppraiserID($pms_employee_id, $time_period_id);
        } else if ($whoiam == 'reviewer') {
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
        //echo $this->db->last_query();
        $employee_detail = $query->result_array();
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
                $reviewer_final_score_idp = '0';
                $reviewer_final_score_kra = '0';
                $reviewer_orverall_total = '0';
                $reviewer_assessment_score_name = '0';

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
                $appraiser_score_details = $this->getOverallRatingForApraisee($val['pms_employee_id'], $time_period_id);

                if ($submit_status >= 8) {
                    //echo '<br>EmpID ' . $val['pms_employee_id'] ;
                    $reviewer_idp_score = $this->get_reviewer_competencies($val['pms_employee_id'], $grade_id);
                    ////
                    //$data['new_competencies_for_refrence'] = $this->display_reviewer_competencies($apraisee_employee_id, $employee_detail->grade_id);
                    //KRA Score
                    //Added By Ajay
                    $apraiser_list = $this->reviewermodel->getRelationshipStatusMultiple($val['pms_employee_id'], $reviewer_employee_id, $time_period_id);
                    //print_r($apraiser_list);
                    $arr_apraiser_list = array();
                    foreach ($apraiser_list as $key_a => $val_a) {
                        $arr_apraiser_list[] = $val_a['apraiser_employee_id'];
                    }

                    $reviewer_kra_detail = $this->reviewermodel->getReviewerKraPmsDetailMultiple($val['pms_employee_id'], $arr_apraiser_list, $reviewer_employee_id);
                    $final_kra_score = 0;
                    if (!empty($reviewer_kra_detail)) {
                        foreach ($reviewer_kra_detail as $keyd => $vald) {
                            //if ($final_kra_score == '') {
                            //    $final_kra_score = ($vald['total_score']);
                            //} else {
                            $final_kra_score += ($vald['total_score']);
                            //}
                        }
                    }

                    $final_kra_score = (($final_kra_score * 70 ) / 100 );
                    $reviewer_final_score_kra = number_format($final_kra_score, 2, '.', '');

                    //IDP
                    $reviewer_idp_score = (($reviewer_idp_score * 30 ) / 100 );
                    $reviewer_final_score_idp = number_format($reviewer_idp_score, 2, '.', '');

                    $reviewer_orverall_total = number_format($reviewer_idp_score + $reviewer_final_score_kra, 2, '.', '');
                    $reviewer_assessment_score_name = $this->reviewermodel->getScoreNameByScore($reviewer_orverall_total);
                }


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
                    'overall_kra_score' => $appraiser_score_details,
                    'appraiser_score_details' => $appraiser_score_details,
                    'appraiser_overall_score_name' => $this->getScoreNameByScore($appraiser_score_details['overall_total']),
                    'reviewer_final_score_idp' => $reviewer_final_score_idp,
                    'reviewer_final_score_kra' => $reviewer_final_score_kra,
                    'reviewer_orverall_total' => $reviewer_orverall_total,
                    'reviewer_assessment_score_name' => $reviewer_assessment_score_name,
                    'function_name' => $this->getFunctionForEmployee($val['pms_employee_id']),
                    'devinfo' => $this->getAppraiseeIDP($val['pms_employee_id'], $time_period_id) ,
                    'techinfo' => $this->getAppraiseeTechnicalinfo($val['pms_employee_id'], $time_period_id),
                    'behavinfo' => $this->getAppraiseeBehavioralinfo($val['pms_employee_id'], $time_period_id)            
                );
            }
        }


        return $employee_list;
    }

    function getEmployeeApriseelistForReport($pms_employee_id, $status) {
        $time_period_id = '1';


        $whoiam = $this->reportsmodel->whoiam($pms_employee_id);
        //echo 'Who I am ' . $whoiam;

        $this->load->model('commonmodel');
        $this->load->model('employeemodel');
        $this->load->model('apraiseemodel');
        $employee_detail = array();
        $employee_list = array();
        if ($pms_employee_id == '1') {

            $employee_ids = $this->employeemodel->getAllEmployeeIDs($pms_employee_id);
        } else if ($whoiam == 'appraiser') {
            $employee_ids = $this->getEmplyeeIdsByAppraiserID($pms_employee_id, $time_period_id);
        } else if ($whoiam == 'reviewer') {
            $employee_ids = $this->getEmplyeeIdsByReviewerID($pms_employee_id, $time_period_id);
        }

        //New ACL Updates         
        $office_address_ids = $this->companymodel->get_employee_office_ids_by_acl($this->session->userdata('pms_employee_id'));
        $my_employee_list = $this->employeemodel->get_employee_by_office_address_ids($office_address_ids);        
        $employee_ids = $this->getEmpIdsByEmployee_list($my_employee_list);
        
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
        //echo $this->db->last_query();
        $employee_detail = $query->result_array();
        
        //echo '<pre>';
        //print_r($employee_detail);
        //echo '</pre>';
        //die();
        
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
                $reviewer_final_score_idp = '0';
                $reviewer_final_score_kra = '0';
                $reviewer_orverall_total = '0';
                $reviewer_assessment_score_name = '0';

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
                $appraiser_score_details = $this->getOverallRatingForApraisee($val['pms_employee_id'], $time_period_id);
                
                
                if ($submit_status >= 8) {
                    //echo '<br>EmpID ' . $val['pms_employee_id'] ;
                    $reviewer_idp_score = $this->get_reviewer_competencies($val['pms_employee_id'], $grade_id);
                    ////
                    //$data['new_competencies_for_refrence'] = $this->display_reviewer_competencies($apraisee_employee_id, $employee_detail->grade_id);
                    //KRA Score
                    //Added By Ajay
                    $apraiser_list = $this->reviewermodel->getRelationshipStatusMultiple($val['pms_employee_id'], $reviewer_employee_id, $time_period_id);
                    //print_r($apraiser_list);
                    $arr_apraiser_list = array();
                    foreach ($apraiser_list as $key_a => $val_a) {
                        $arr_apraiser_list[] = $val_a['apraiser_employee_id'];
                    }

                    $reviewer_kra_detail = $this->reviewermodel->getReviewerKraPmsDetailMultiple($val['pms_employee_id'], $arr_apraiser_list, $reviewer_employee_id);
                    $final_kra_score = 0;
                    if (!empty($reviewer_kra_detail)) {
                        foreach ($reviewer_kra_detail as $keyd => $vald) {
                            //if ($final_kra_score == '') {
                            //    $final_kra_score = ($vald['total_score']);
                            //} else {
                            $final_kra_score += ($vald['total_score']);
                            //}
                        }
                    }

                    $final_kra_score = (($final_kra_score * 70 ) / 100 );
                    $reviewer_final_score_kra = number_format($final_kra_score, 2, '.', '');

                    //IDP
                    $reviewer_idp_score = (($reviewer_idp_score * 30 ) / 100 );
                    $reviewer_final_score_idp = number_format($reviewer_idp_score, 2, '.', '');

                    $reviewer_orverall_total = number_format($reviewer_idp_score + $reviewer_final_score_kra, 2, '.', '');
                    $reviewer_assessment_score_name = $this->reviewermodel->getScoreNameByScore($reviewer_orverall_total);
                }


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
                    'overall_kra_score' => $appraiser_score_details,
                    'appraiser_score_details' => $appraiser_score_details,
                    'appraiser_overall_score_name' => $this->getScoreNameByScore($appraiser_score_details['overall_total']),
                    'reviewer_final_score_idp' => $reviewer_final_score_idp,
                    'reviewer_final_score_kra' => $reviewer_final_score_kra,
                    'reviewer_orverall_total' => $reviewer_orverall_total,
                    'reviewer_assessment_score_name' => $reviewer_assessment_score_name,
                    'function_name' => $this->getFunctionForEmployee($val['pms_employee_id']),
                    'appraisee_overall_rating' => $this->reviewermodel->getOverallRatingOfAppraiseeByAppraiser($val['pms_employee_id'], $time_period_id),
                    'reviewer_overall_rating' => $this->reviewermodel->getOverallRatingOfAppraiseeByReviewer($val['pms_employee_id'], $reviewer_employee_id, $time_period_id),
                    'emp_busines_id' => $this->getEmpBusinessId($val['pms_employee_id'])
                );
            }
        }
        
        //echo '<pre>';
        //print_r($employee_list);
        //echo '</pre>';
        //die();


        return $employee_list;
    }

    public function getFunctionForEmployee($pms_employee_id) {
        $function_name = '';
        $this->load->model('employeemodel');
        $emp_business_id = $this->employeemodel->getUserMeta($pms_employee_id, 'business_id');

        if (isset($emp_business_id->meta_value) and $emp_business_id->meta_value >= 1) {
            //Collect Business Name
            $function_name = $this->getBusinessNameById($emp_business_id->meta_value);
        } else {
            //Set Default
            $function_name = 'VEPL Corp.';
        }

        return $function_name;
    }

    public function getBusinessNameById($business_id) {
        $query = $this->db->query("SELECT business_subject FROM " . $this->db->dbprefix . "business WHERE business_id='" . $business_id . "' ");
        $row = $query->first_row();
        //echo $this->db->last_query();
        //print_r($row);
        if (!$row) {
            return '';
        } else {
            return $row->business_subject;
        }
    }

    function getEmployeeApriseelistForPromotionReport($pms_employee_id, $status) {
        $time_period_id = '1';
        // $time_period_detail                 = $this->commonmodel->get_current_year();
//        if(!empty($time_period_detail))
//        {
//            $time_period_id                 = $time_period_detail['time_period_id'];
//        }


        $whoiam = $this->reportsmodel->whoiam($pms_employee_id);
        //echo 'Who I am ' . $whoiam;

        $this->load->model('commonmodel');
        $this->load->model('employeemodel');
        $this->load->model('apraiseemodel');
        $employee_detail = array();
        $employee_list = array();
        if ($pms_employee_id == '1') {

            $employee_ids = $this->employeemodel->getAllEmployeeIDs($pms_employee_id);
        } else if ($whoiam == 'appraiser') {
            $employee_ids = $this->getEmplyeeIdsByAppraiserID($pms_employee_id, $time_period_id);
        } else if ($whoiam == 'reviewer') {
            $employee_ids = $this->getEmplyeeIdsByReviewerID($pms_employee_id, $time_period_id);
        }
        
        //New ACL Updates         
        $office_address_ids = $this->companymodel->get_employee_office_ids_by_acl($this->session->userdata('pms_employee_id'));
        $my_employee_list = $this->employeemodel->get_employee_by_office_address_ids($office_address_ids);        
        $employee_ids = $this->getEmpIdsByEmployee_list($my_employee_list);
        

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
        //echo $this->db->last_query();
        $employee_detail = $query->result_array();
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
                $reviewer_final_score_idp = '0';
                $reviewer_final_score_kra = '0';
                $reviewer_orverall_total = '0';
                $reviewer_assessment_score_name = '0';

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
                $appraiser_score_details = $this->getOverallRatingForApraisee($val['pms_employee_id'], $time_period_id);

                if ($submit_status >= 8) {
                    //echo '<br>EmpID ' . $val['pms_employee_id'] ;
                    $reviewer_idp_score = $this->get_reviewer_competencies($val['pms_employee_id'], $grade_id);
                    ////
                    //$data['new_competencies_for_refrence'] = $this->display_reviewer_competencies($apraisee_employee_id, $employee_detail->grade_id);
                    //KRA Score
                    //Added By Ajay
                    $apraiser_list = $this->reviewermodel->getRelationshipStatusMultiple($val['pms_employee_id'], $reviewer_employee_id, $time_period_id);
                    //print_r($apraiser_list);
                    $arr_apraiser_list = array();
                    foreach ($apraiser_list as $key_a => $val_a) {
                        $arr_apraiser_list[] = $val_a['apraiser_employee_id'];
                    }

                    $reviewer_kra_detail = $this->reviewermodel->getReviewerKraPmsDetailMultiple($val['pms_employee_id'], $arr_apraiser_list, $reviewer_employee_id);
                    $final_kra_score = 0;
                    if (!empty($reviewer_kra_detail)) {
                        foreach ($reviewer_kra_detail as $keyd => $vald) {
                            //if ($final_kra_score == '') {
                            //    $final_kra_score = ($vald['total_score']);
                            //} else {
                            $final_kra_score += ($vald['total_score']);
                            //}
                        }
                    }

                    $final_kra_score = (($final_kra_score * 70 ) / 100 );
                    $reviewer_final_score_kra = number_format($final_kra_score, 2, '.', '');

                    //IDP
                    $reviewer_idp_score = (($reviewer_idp_score * 30 ) / 100 );
                    $reviewer_final_score_idp = number_format($reviewer_idp_score, 2, '.', '');

                    $reviewer_orverall_total = number_format($reviewer_idp_score + $reviewer_final_score_kra, 2, '.', '');
                    $reviewer_assessment_score_name = $this->reviewermodel->getScoreNameByScore($reviewer_orverall_total);
                }

                //Get Promofion details
                $first_apraiser_info = $this->apraisermodel->get_first_appraiser($val['pms_employee_id'], $time_period_id);
                if (isset($first_apraiser_info['apraiser_employee_id']) and $first_apraiser_info['apraiser_employee_id'] >= 1) {
                    $sql_p = "SELECT * FROM " . $this->db->dbprefix . "apraiser_overall_rating 
                        WHERE pms_employee_id = '" . $val['pms_employee_id'] . "' 
                        AND apraiser_employee_id='" . $first_apraiser_info['apraiser_employee_id'] . "' 
                        AND time_period_id='" . $time_period_id . "' ";
                    //echo $sql_p ;
                    $query_p = $this->db->query($sql_p);
                    $resule_p = $query_p->first_row();
                    if (isset($resule_p->promotion_recommendation) and $resule_p->promotion_recommendation != '') {
                        $promotion_recommendation = $resule_p->promotion_recommendation;
                    } else {
                        $promotion_recommendation = ' - ';
                    }
                } else {
                    $promotion_recommendation = ' - ';
                }

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
                    'overall_kra_score' => $appraiser_score_details,
                    'appraiser_score_details' => $appraiser_score_details,
                    'appraiser_overall_score_name' => $this->getScoreNameByScore($appraiser_score_details['overall_total']),
                    'reviewer_final_score_idp' => $reviewer_final_score_idp,
                    'reviewer_final_score_kra' => $reviewer_final_score_kra,
                    'reviewer_orverall_total' => $reviewer_orverall_total,
                    'reviewer_assessment_score_name' => $reviewer_assessment_score_name,
                    'promotion_recomandation_info' => $promotion_recommendation,
                    'function_name' => $this->getFunctionForEmployee($val['pms_employee_id']),
                    'appraisee_overall_rating' => $this->reviewermodel->getOverallRatingOfAppraiseeByAppraiser($val['pms_employee_id'], $time_period_id),
                    'reviewer_overall_rating' => $this->reviewermodel->getOverallRatingOfAppraiseeByReviewer($val['pms_employee_id'], $reviewer_employee_id, $time_period_id)
                );
            }
        }


        return $employee_list;
    }

    //TODO Fix - Duplicate remove    
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

    function getEmplyeeIdsByAppraiserID($reviewer_employee_id, $time_period_id) {
        $employee_id = array();
        $this->db->select('pms_employee_id');
        $this->db->from($this->db->dbprefix . 'employee_relationship_materix');
        $this->db->where('apraiser_employee_id', $reviewer_employee_id);
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

    //TODO Fix - Duplicate Remove
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

    //TODO Fix - Duplicate Remove
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

    //TODO Fix - Remove Duplicate
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

    //TODO: fix remove display part
    public function get_reviewer_competencies($apraisee_employee_id = '', $grade_id = '') {
        //echo '<br>Employee Id ' . $apraisee_employee_id . ' Grade: ' . $grade_id ;
        $output = '';
        $time_period_id = 1;
        //Get all List of competencies

        $comp_for_ref = $this->commonmodel->getCompetenciesByGrade($grade_id);


        //Get Multiple appraiser
        $sql_multiple_relationship = "SELECT  rm.employee_relationship_materix_id, rm.apraiser_employee_id, e.fname, e.lname 
                        FROM " . $this->db->dbprefix . "employee_relationship_materix rm
                        LEFT JOIN " . $this->db->dbprefix . "employee e ON rm.apraiser_employee_id = e.pms_employee_id 
                        WHERE rm.time_period_id = '" . $time_period_id . "' 
                        and rm.pms_employee_id = '" . $apraisee_employee_id . "' ";
        //echo $sql_multiple_relationship ;
        $query_m = $this->db->query($sql_multiple_relationship);
        //echo '<pre>';
        //print_r($query_m->result());
        //echo '</pre>';


        $reviewer_id = $this->session->userdata('pms_employee_id');



        $total_avg = 0;
        $total_rev_score = 0;
        $total_weightage = 0;
        $output .= '<tbody>';
        foreach ($comp_for_ref as $key => $val) {

            $output .= '<tr>';
            $output .= '<td>' . trim($val['competencies_name']) . '</td>';
            $output .= '<td>' . $val['weightage_value'] . '%</td>';

            //Calculate Weightage
            $total_weightage = $total_weightage + $val['weightage_value'];

            //Display cols for multiple apraiser
            $my_average = 0;
            $my_scale = 0;
            foreach ($query_m->result() as $ckey => $cval) {
                $get_scale_info = $this->getCompetenciesDetails($val['competencies_for_refrence_id'], $cval->apraiser_employee_id, $apraisee_employee_id, $time_period_id);


                $myscore = number_format((( $val['weightage_value'] * $get_scale_info->scale ) / 100), 2, '.', '');
                $my_average = $my_average + $myscore;
                //$output .= '<td style="text-align:right">' . $get_scale_info->scale . ' | ' . $myscore . '</td>';
                $my_scale = $my_scale + $get_scale_info->scale;
            }

            //Display Average
            //Calculate Average 
            $my_average = number_format(( $my_average / count($query_m->result())), 2, '.', '');
            $my_scale = number_format(( $my_scale / count($query_m->result())), 2, '.', '');

            //Add to Total
            $total_avg = $total_avg + $my_average;
            //$output .= '<td style="text-align:right">' . $my_average . '</td>';
            //Display Scale
            //$output .= '<td style="text-align:right">' . $my_scale . '</td>';
            //Get Reviewer Details
            $get_scale_info = $this->getReviewerCompetenciesDetails($val['competencies_for_refrence_id'], $reviewer_id, $apraisee_employee_id, $time_period_id);
            if ($get_scale_info) {
                $scale = $get_scale_info->scale;
                $myscore = number_format((( $val['weightage_value'] * $scale ) / 100), 2, '.', '');
                $total_rev_score = $total_rev_score + $myscore;
            } else {
                $myscore = 0;
                $scale = 0;
                $total_rev_score = $total_rev_score + $myscore;
            }
            $my_scale = number_format(( $scale / count($query_m->result())), 2, '.', '');

            $output .= '<td style="text-align:right">' . $scale . '</td>';
            $output .= '<td style="text-align:right">' . $myscore . '</td>';
            $output .= '</tr>';

            //Get Individual Details
        }

        //Display Total
        $output .= '<tr>';
        $output .= '<td style="text-align:right; font-weight:bold;">Total</td>';
        $output .= '<td>' . $total_weightage . '%&nbsp;</td>';
        //Display cols for multiple apraiser
        //$output .= '<td style="text-align:right; font-weight:bold;">' . number_format($total_avg, 2, '.', '') . '</td>';
        $output .= '<td style="text-align:right; font-weight:bold;">&nbsp;</td>';

        $output .= '<td style="text-align:right; font-weight:bold;">' . number_format($total_rev_score, 2, '.', '') . '</td>';
        $output .= '</tr>';
        $output .= '</tbody>';



        $output .= '</table>';
        $this->reviewer_total_score = $total_rev_score;
        //echo 'Total Rev Score ' . $total_rev_score ; 
        //echo $output ;

        return $total_rev_score;
    }

    //TODO Fix
    function getCompetenciesDetails($competency_id, $apraisee_employee_id, $pms_employee_id, $time_period_id) {
        $sql = "SELECT * FROM " . $this->db->dbprefix . "apraiser_competency_with_idp 
            WHERE competencies_for_refrence_id = '" . $competency_id . "' 
            AND apraiser_employee_id='" . $apraisee_employee_id . "' 
            AND pms_employee_id='" . $pms_employee_id . "' 
            AND time_period_id='" . $time_period_id . "' ";
        $query = $this->db->query($sql);
        $result = $query->first_row();

        return $result;
    }

    function getReviewerCompetenciesDetails($competency_id, $reviewer_id, $pms_employee_id, $time_period_id) {
        $sql = "SELECT * FROM " . $this->db->dbprefix . "reviewer_competency_with_idp 
            WHERE competencies_for_refrence_id = '" . $competency_id . "' 
            AND reviewer_employee_id='" . $reviewer_id . "' 
            AND pms_employee_id='" . $pms_employee_id . "' 
            AND time_period_id='" . $time_period_id . "' ";
        $query = $this->db->query($sql);
        $result = $query->first_row();
        //echo $this->db->last_query();

        return $result;
    }
    
    
    function getAppraiseeIDP($pms_appraisee_id, $time_period_id) {
        $sql = "SELECT development_area FROM " . $this->db->dbprefix . "apraisee_idp 
            WHERE pms_employee_id = '" . $pms_appraisee_id . "' 
            AND time_period_id='" . $time_period_id . "' ";
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    
    function getAppraiseeTechnicalinfo($pms_appraisee_id, $time_period_id)
    {
        //Technical Info metioned by Appraiser
        $sql = "SELECT apt.apraiser_employee_id, apt.technical_area, e.fname, e.lname 
                FROM " . $this->db->dbprefix . "apraiser_technical apt
                LEFT JOIN " . $this->db->dbprefix . "employee e ON apt.apraiser_employee_id = e.pms_employee_id 
                WHERE apt.pms_employee_id ='" . $pms_appraisee_id . "' 
                AND apt.time_period_id='" . $time_period_id . "' 
                ORDER BY apt.apraiser_employee_id ";
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    function getAppraiseeBehavioralinfo($pms_appraisee_id, $time_period_id)
    {
        //Behavioralinfo metioned by Appraiser        
        
        $sql = "SELECT abav.apraiser_employee_id, abav.behavioural_area, e.fname, e.lname 
                FROM " . $this->db->dbprefix . "apraiser_behavioural abav
                LEFT JOIN " . $this->db->dbprefix . "employee e ON abav.apraiser_employee_id = e.pms_employee_id 
                WHERE abav.pms_employee_id ='" . $pms_appraisee_id . "' 
                AND abav.time_period_id='" . $time_period_id . "' 
                ORDER BY abav.apraiser_employee_id " ;
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    
    function getActiveBusinessList()
    {
        $sql = "SELECT business_id, business_subject, business_desc, date_created, is_active
                FROM " . $this->db->dbprefix . "business 
                WHERE is_active='1'
                ORDER BY business_subject " ;
        $query = $this->db->query($sql);
        
        return $query->result();        
    }
    
    function getEmpBusinessId($pms_employee_id) {        

        $business_id = '';
        $sql = "SELECT e.pms_employee_id, e.fname, e.lname, e.office_address_id,
                oa.office_addresses_id, oa.company_master_id, oa.office_name, oa.business_id, 
                pb.business_subject, pb.business_desc
                FROM " . $this->db->dbprefix . "employee e
                LEFT JOIN " . $this->db->dbprefix . "office_addresses oa ON oa.office_addresses_id = e.office_address_id 
                LEFT JOIN " . $this->db->dbprefix . "business pb ON oa.business_id = pb.business_id 
                WHERE e.pms_employee_id ='" . $pms_employee_id . "' " ;
        $query = $this->db->query($sql);
        $result = $query->first_row();
        
        if( $result ) {
            $business_id = $result->business_id ;
        }        
        
        return $business_id;
        
    }
    
    function getEmpIdsByEmployee_list($employee_list)
    {
        $employee_id = array();
        if (!empty($employee_list)) {
            foreach ($employee_list as $key => $val) {
                $employee_id[] = $val['pms_employee_id'];
            }
        }

        return $employee_id;
    }
    

}