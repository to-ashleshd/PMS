<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reviewer extends CI_Controller {

    var $reviewer_total_score;

    function __construct() {
        parent::__construct();
        $this->topmenu->no_cache();
        //  $this->dashboard();
        $this->load->model('generalesettings');
        $this->load->model('employeemodel');
        $this->load->model('commonmodel');
        $this->load->model('companymodel');
        $this->load->model('apraiseemodel');
        $this->load->model('apraisermodel');
        $this->load->model('reviewermodel');
        $this->load->model('taskschedulemodel');
        if (!$this->session->userdata('pms_employee_id')) {
            redirect('clientadmin', 'refresh');
        }
        $reviewer_total_score = 0;
    }

    public function index($tab = '', $tabid = '') {
        if ($this->session->userdata('pms_employee_id')) {
            $this->employee();
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function employee() {
        $employee = array();
        if ($this->session->userdata('pms_employee_id')) {
            $data = array();
            $time_period_id = '1';
            $status = '1';
            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['employees'] = $this->reviewermodel->getEmployeeApriseelist($pms_employee_id, '1');

            $this->load->model('companymodel');
            $data['employee'] = $data['employees'];
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();
            $data['company_master'] = $this->companymodel->getCompaniesHavingOfficeType();
            $data['departments'] = $this->companymodel->getDepartments();

            $data['topmenu'] = $this->topmenu->apraiseemenulist();

            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);

            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);
            $this->load->view('default/clientadmin/cadmin_reviewer_employee_list', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
        //}
    }

    function apraiseeassessment($apraisee_employee_id = '') {
        $data = array();
        $time_period_id = '1';
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        $data['departments'] = $this->companymodel->getDepartments();
        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
        $data['apraisee_employee_id'] = '';
        $data['employee_name'] = '';

        if ($apraisee_employee_id == '') {
            redirect('accessdenied', 'refresh');
        }

        if ($this->session->userdata('pms_employee_id')) {
            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['final_score'] = 0;
            $data['final_score_cwi'] = '';
            $data['overall_kra_score'] = '';
            $data['overall_competencies_score'] = '';
            $data['overall_performance_score'] = '';
            $data['reviewer_assessment_score'] = '';
            $data['apraiser_assessment_score'] = '';


            $data['apraiser_overall_performance_score_name'] = '';
            $data['apraiser_overall_performance_score'] = '';
            $data['apraiser_overall_competencies_score'] = '';
            $data['apraiser_overall_kra_score'] = '';
            $reviewer_id_for_score = '';
            $data['reviewer_date'] = date($data['s_date_format']);

            if ($apraisee_employee_id != '') {
                $reviewer_employee_id = $pms_employee_id;
                $apraisee_relationship_detail = $this->reviewermodel->getRelationshipStatus($apraisee_employee_id, $reviewer_employee_id, $time_period_id);
                $employee_detail = $this->employeemodel->getEmployeeById($apraisee_employee_id);
                $apraiser_employee_id = '0';
                $data['top_employee_detail'] = $this->employeemodel->getEmployeeDetailsById($apraisee_employee_id, $time_period_id);
                // $data['top_employee_apraiser_detail'] = $this->employeemodel->getEmployeeApraiserAndReviewer($apraisee_employee_id, $time_period_id);
                $top_employee_apraiser_detail = $this->employeemodel->getEmployeeApraiserAndReviewer($apraisee_employee_id, $time_period_id);
                $top_detail_apraiser = '';
                $top_detail_reviewer = '';
                if (!empty($top_employee_apraiser_detail)) {
                    foreach ($top_employee_apraiser_detail as $key_topemp => $val_topemp) {
                        if ($top_detail_apraiser == '') {
                            $top_detail_apraiser = '[ <strong>' . $val_topemp['apraiser_name'] . ' </strong><em>' . $val_topemp['apraiser_designation'] . '</em> ]';
                        } else {
                            $top_detail_apraiser .= ', [ <strong>' . $val_topemp['apraiser_name'] . '</strong><em> ' . $val_topemp['apraiser_designation'] . '</em> ]';
                        }
                        $top_detail_reviewer = '[ <strong>' . $val_topemp['reviewer_name'] . '</strong><em> ' . $val_topemp['reviewer_designation'] . '</em> ]';
                    }
                }
                $data['top_employee_apraiser_detail'] = array(
                    'appraiser' => $top_detail_apraiser,
                    'reviewer' => $top_detail_reviewer
                );

                if (empty($data['top_employee_detail'])) {
                    redirect('accessdenied', 'refresh');
                }


                if (empty($data['top_employee_detail'])) {
                    redirect('accessdenied', 'refresh');
                }


                if (!empty($apraisee_relationship_detail)) {
                    $reviewer_id_for_score = $apraisee_relationship_detail['reviewer_employee_id'];
                    $apraiser_employee_id = $apraisee_relationship_detail['apraiser_employee_id'];
                    //echo '<pre>';
                    //Added By Ajay
                    $apraiser_list = $this->reviewermodel->getRelationshipStatusMultiple($apraisee_employee_id, $reviewer_employee_id, $time_period_id);
                    //print_r($apraiser_list);
                    $arr_apraiser_list = array();
                    foreach ($apraiser_list as $key_a => $val_a) {
                        $arr_apraiser_list[] = $val_a['apraiser_employee_id'];
                    }
                    //print_r($arr_apraiser_list);
                    //echo '</pre>';
                }

                if ($time_period_id == 1) {
                    $data['last_score'] = $this->apraiseemodel->get_employee_temp_last_rating($pms_employee_id);
                } else {
                    $imediate_prev_year = $this->commonmodel->get_immediate_previous_year();
                    $immidiate_year = '0';
                    if (!empty($imediate_prev_year)) {
                        $immidiate_year = $imediate_prev_year['time_period_id'];
                    }
                    $data['last_score'] = $this->apraiseemodel->get_employee_last_year_rating($pms_employee_id, $reviewer_id_for_score, $immidiate_year);
                }


                //Get overall score
                //TODO Fixed: display overall score
                $overall_kra_score = $this->getOverallRatingForApraisee($apraisee_employee_id, $time_period_id);
                $data['overall_kra_score_for_appraiser'] = $overall_kra_score;
                $data['overall_kra_score_rating_name'] = $this->reviewermodel->getScoreNameByScore($data['overall_kra_score_for_appraiser']['overall_total']);


                $apraiser_overall_rating = $this->apraisermodel->getApraiserOverAllRatingById($apraisee_employee_id, $apraiser_employee_id, $time_period_id);

                //Modified by Ajay
                //Get Reviewer date
                $sql = "SELECT * FROM " . $this->db->dbprefix . "reviewer_overall_rating WHERE 
                        pms_employee_id='" . $apraisee_employee_id . "' 
                        AND reviewer_employee_id='" . $this->session->userdata('pms_employee_id') . "' 
                        AND time_period_id='" . $time_period_id . "' ";

                $query = $this->db->query($sql);
                $reviewer_overall_rating = $query->first_row();
                //$reviewer_date = date($data['s_date_format'], strtotime($reviewer_overall_rating->date_created));
                $reviewer_date = date($data['s_date_format'], strtotime(date("Y-m-d")));

                //Fixed apraiser_date
                $data['apraiser_date'] = $apraiser_date = '';

                /**
                  if (!empty($apraiser_overall_rating)) {
                  $data['apraiser_assessment_score'] = $this->reviewermodel->getScoreNameByScore($apraiser_overall_rating['apraiser_score']);
                  $data['apraiser_date'] = date($data['s_date_format'], strtotime($apraiser_overall_rating['date_created']));
                  }
                 * */
                //apraiser overall rating score
                $data['apraiser_overall_kra_score'] = $this->reviewermodel->getApraiserTotalKraScore($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
                $data['apraiser_overall_competencies_score'] = $this->reviewermodel->getApraiserTotalCompetenciesScore($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
                $data['apraiser_overall_performance_score'] = (($data['apraiser_overall_kra_score']) + ($data['apraiser_overall_competencies_score']));
                $data['apraiser_overall_performance_score_name'] = $this->reviewermodel->getScoreNameByScore($data['apraiser_overall_performance_score']);

                //  echo  $data['apraiser_overall_kra_score'];echo "<br>";
                //  echo $data['apraiser_overall_competencies_score'] ;echo "<br>";die();
                //   echo  $data['apraiser_overall_performance_score'];die();

                if (!empty($apraisee_relationship_detail) && $apraisee_relationship_detail['submit_status'] == '6') {

                    //$data['kra_detail'] = $this->reviewermodel->getApraiserKraPmsDetail($apraisee_employee_id, $apraiser_employee_id);
                    //Added By Ajay
                    $data['kra_detail'] = $this->reviewermodel->getApraiserKraPmsDetailMultiple($apraisee_employee_id, $arr_apraiser_list);

                    $data['employee_name'] = $employee_detail->fname . ' ' . $employee_detail->lname;
                } elseif (!empty($apraisee_relationship_detail) && $apraisee_relationship_detail['submit_status'] > '6') {
                    //echo $apraisee_employee_id.' '.$apraiser_employee_id.' '.$reviewer_employee_id;
                    //$data['reviewer_kra_detail'] = $this->reviewermodel->getReviewerKraPmsDetail($apraisee_employee_id, $apraiser_employee_id, $reviewer_employee_id);
                    $data['reviewer_kra_detail'] = $this->reviewermodel->getReviewerKraPmsDetailMultiple($apraisee_employee_id, $arr_apraiser_list, $reviewer_employee_id);

                    if (!empty($data['reviewer_kra_detail'])) {
                        foreach ($data['reviewer_kra_detail'] as $keyd => $vald) {
                            if ($data['final_score'] == '') {
                                $data['final_score'] = ($vald['total_score']);
                            } else {
                                $data['final_score'] += ($vald['total_score']);
                            }
                        }
                    }

                    //$data['reviewer_kra_detail'] = '';

                    $employee_detail = $this->employeemodel->getEmployeeById($apraisee_employee_id);
                    $data['employee_name'] = $employee_detail->fname . ' ' . $employee_detail->lname;

                    if ($apraisee_relationship_detail['submit_status'] >= '8' && !empty($data['reviewer_kra_detail'])) {
                        $overall_rating_of_reviewer = $this->reviewermodel->getReviewerOverAllRatingById($apraisee_employee_id, $apraiser_employee_id, $reviewer_employee_id, $time_period_id);


                        if (!empty($overall_rating_of_reviewer)) {
                            $data['reviewer_date'] = date($data['s_date_format'], strtotime($overall_rating_of_reviewer['date_created']));
                        }

                        //$data['competency_with_idp_detail'] = $this->apraisermodel->getEmployeeCompetenciesWithIdp($apraisee_employee_id, $apraiser_employee_id);                        
                        //TODO: Fixed Replace new array with grouping of rating of all appraisers
                        $data['competency_with_idp_detail'] = $this->display_reviewer_competencies($apraisee_employee_id, $employee_detail->grade_id);


                        foreach ($data['competency_with_idp_detail'] as $keycwi => $valcwi) {
                            if ($data['final_score_cwi'] == '') {
                                $data['final_score_cwi'] = ($valcwi['total_score']);
                            } else {
                                $data['final_score_cwi'] += ($valcwi['total_score']);
                            }
                        }
                        //$data['technical_detail'] = $this->apraisermodel->getEmployeeTechnicalDetail($apraisee_employee_id, $apraiser_employee_id);
                        //Modified By Ajay
                        $data['technical_detail'] = $this->apraisermodel->getEmployeeTechnicalDetailMultiple($apraisee_employee_id, $arr_apraiser_list);


                        //$data['behavioural_detail'] = $this->apraisermodel->getEmployeeBehaviouralDetail($apraisee_employee_id, $apraiser_employee_id);
                        $data['behavioural_detail'] = $this->apraisermodel->getEmployeeBehaviouralDetailMultiple($apraisee_employee_id, $arr_apraiser_list);



                        $data['overall_kra_score'] = round((($data['final_score'] * 70 ) / 100), 2);
                        $data['overall_competencies_score'] = round((($data['final_score_cwi'] * 30 ) / 100), 2);
                        $data['overall_performance_score'] = round((($data['overall_kra_score']) + ($data['overall_competencies_score'])), 2);
                        if ($data['overall_performance_score'] < 2) {
                            $data['reviewer_assessment_score'] = 'BE';
                        } elseif ($data['overall_performance_score'] > 2 && $data['overall_performance_score'] < 2.79) {
                            $data['reviewer_assessment_score'] = 'NI';
                        } elseif ($data['overall_performance_score'] > 2.80 && $data['overall_performance_score'] < 3.49) {
                            $data['reviewer_assessment_score'] = 'ME';
                        } elseif ($data['overall_performance_score'] > 3.50 && $data['overall_performance_score'] < 4.24) {
                            $data['reviewer_assessment_score'] = 'EE';
                        } elseif ($data['overall_performance_score'] > 4.25 && $data['overall_performance_score'] < 5.00) {
                            $data['reviewer_assessment_score'] = 'FEE';
                        }
                    } elseif ($apraisee_relationship_detail['submit_status'] >= '8') {

                        $data['error'] = 'Please Fill Up Appraiser KRA form First';
                    }

//                    if($apraisee_relationship_detail['submit_status'] >= '9' && !empty($data['competency_with_idp_detail']))
//                    {
//                        $data['overall_rating_detail'] = $this->apraisermodel->getOverallRatingDetail($apraisee_employee_id,$apraiser_employee_id,$time_period_id);
//                    }
//                    elseif($apraisee_relationship_detail['submit_status'] >= '9')
//                    {
//                        $data['error']  ='Please Fill Up Competencies With IDp  First';
//                    }
                } elseif (!empty($apraisee_relationship_detail) && $apraisee_relationship_detail['submit_status'] < '6') {
                    $data['errormsg'] = 'Awaiting for Apraisee Response.';
                } else {
                    //$data['error']      = 'Page Not Found';
                    redirect('accessdenied', 'refresh');
                }
            } else {
                // $data['error']      = 'Page not found';
                redirect('accessdenied', 'refresh');
            }

            //die();
            //added By Ajay
            //
            $data['new_competencies_for_refrence'] = $this->display_reviewer_competencies($apraisee_employee_id, $employee_detail->grade_id);

            //Modified By Ajay
            $data['view_technical_detail'] = $this->apraisermodel->getEmployeeTechnicalDetailMultiple($apraisee_employee_id, $arr_apraiser_list);

            //$data['behavioural_detail'] = $this->apraisermodel->getEmployeeBehaviouralDetail($apraisee_employee_id, $apraiser_employee_id);
            $data['view_behavioural_detail'] = $this->apraisermodel->getEmployeeBehaviouralDetailMultiple($apraisee_employee_id, $arr_apraiser_list);


            $data['reviewer_idp_score'] = $this->reviewer_total_score;
            //Add Final Score
            $final_score = (($data['final_score'] * 70 ) / 100 );
            $data['final_score_kra'] = number_format($final_score, 2, '.', '');

            //IDP
            $reviewer_idp_score = (($data['reviewer_idp_score'] * 30 ) / 100 );
            $data['final_score_idp'] = number_format($reviewer_idp_score, 2, '.', '');

            $data['final_total'] = number_format($reviewer_idp_score + $data['final_score_kra'], 2, '.', '');
            $data['reviewer_assessment_score'] = $this->reviewermodel->getScoreNameByScore($data['final_total']);


            $data['appraisee_overall_rating'] = $this->reviewermodel->getOverallRatingOfAppraiseeByAppraiser($apraisee_employee_id, $time_period_id);
            $data['reviewer_overall_rating'] = $this->reviewermodel->getOverallRatingOfAppraiseeByReviewer($apraisee_employee_id, $reviewer_employee_id, $time_period_id);

            $data['competencies_for_refrence'] = $this->commonmodel->getCompetenciesByGrade($employee_detail->grade_id);
            $data['all_ratings'] = $this->taskschedulemodel->getAllRatimgs('1');
            $data['idp_detail'] = $this->apraiseemodel->getAllIdpsOfApraisee($apraisee_employee_id, $time_period_id);
            $data['ratings_for_refrence'] = $this->apraisermodel->getAllRatings('1');
            $data['apraisee_employee_id'] = $apraisee_employee_id;
            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            $this->load->view('default/clientadmin/cadmin_reviewer', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    //TODO: Fix - Need to Remove - Not in use - move to reports controller

    function viewreport($apraisee_employee_id = '') {
        $data = array();
        $time_period_id = '1';
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        $data['departments'] = $this->companymodel->getDepartments();
        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
        $data['apraisee_employee_id'] = '';
        $data['employee_name'] = '';

        if ($apraisee_employee_id == '') {
            redirect('accessdenied', 'refresh');
        }

        if ($this->session->userdata('pms_employee_id')) {
            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['final_score'] = '';
            $data['final_score_cwi'] = 0;
            $data['overall_kra_score'] = '';
            $data['overall_competencies_score'] = '';
            $data['overall_performance_score'] = '';
            $data['reviewer_assessment_score'] = '';
            $data['apraiser_assessment_score'] = '';


            $data['apraiser_overall_performance_score_name'] = '';
            $data['apraiser_overall_performance_score'] = '';
            $data['apraiser_overall_competencies_score'] = '';
            $data['apraiser_overall_kra_score'] = '';
            $data['reviewer_date'] = date($data['s_date_format']);

            if ($apraisee_employee_id != '') {
                $reviewer_employee_id = $pms_employee_id;
                $apraisee_relationship_detail = $this->reviewermodel->getRelationshipStatus($apraisee_employee_id, $reviewer_employee_id, $time_period_id);
                $employee_detail = $this->employeemodel->getEmployeeById($apraisee_employee_id);
                $apraiser_employee_id = '0';
                $data['top_employee_detail'] = $this->employeemodel->getEmployeeDetailsById($apraisee_employee_id, $time_period_id);
                // $data['top_employee_apraiser_detail'] = $this->employeemodel->getEmployeeApraiserAndReviewer($apraisee_employee_id, $time_period_id);
                $top_employee_apraiser_detail = $this->employeemodel->getEmployeeApraiserAndReviewer($apraisee_employee_id, $time_period_id);
                $top_detail_apraiser = '';
                $top_detail_reviewer = '';
                if (!empty($top_employee_apraiser_detail)) {
                    foreach ($top_employee_apraiser_detail as $key_topemp => $val_topemp) {
                        if ($top_detail_apraiser == '') {
                            $top_detail_apraiser = '[ <strong>' . $val_topemp['apraiser_name'] . ' </strong><em>' . $val_topemp['apraiser_designation'] . '</em> ]';
                        } else {
                            $top_detail_apraiser .= ', [ <strong>' . $val_topemp['apraiser_name'] . '</strong><em> ' . $val_topemp['apraiser_designation'] . '</em> ]';
                        }
                        $top_detail_reviewer = '[ <strong>' . $val_topemp['reviewer_name'] . '</strong><em> ' . $val_topemp['reviewer_designation'] . '</em> ]';
                    }
                }
                $data['top_employee_apraiser_detail'] = array(
                    'appraiser' => $top_detail_apraiser,
                    'reviewer' => $top_detail_reviewer
                );

                if (empty($data['top_employee_detail'])) {
                    redirect('accessdenied', 'refresh');
                }


                if (empty($data['top_employee_detail'])) {
                    redirect('accessdenied', 'refresh');
                }

                if (!empty($apraisee_relationship_detail)) {
                    $apraiser_employee_id = $apraisee_relationship_detail['apraiser_employee_id'];
                    //echo '<pre>';
                    //Added By Ajay
                    $apraiser_list = $this->reviewermodel->getRelationshipStatusMultiple($apraisee_employee_id, $reviewer_employee_id, $time_period_id);
                    //print_r($apraiser_list);
                    $arr_apraiser_list = array();
                    foreach ($apraiser_list as $key_a => $val_a) {
                        $arr_apraiser_list[] = $val_a['apraiser_employee_id'];
                    }
                    //print_r($arr_apraiser_list);
                    //echo '</pre>';
                }

                //Get overall score
                //TODO Fixed: display overall score
                $overall_kra_score = $this->getOverallRatingForApraisee($apraisee_employee_id, $time_period_id);
                $data['overall_kra_score_for_appraiser'] = $overall_kra_score;
                $data['overall_kra_score_rating_name'] = $this->reviewermodel->getScoreNameByScore($data['overall_kra_score_for_appraiser']['overall_total']);


                $apraiser_overall_rating = $this->apraisermodel->getApraiserOverAllRatingById($apraisee_employee_id, $apraiser_employee_id, $time_period_id);

                //Modified by Ajay
                //Get Reviewer date
                $sql = "SELECT * FROM " . $this->db->dbprefix . "reviewer_overall_rating WHERE 
                        pms_employee_id='" . $apraisee_employee_id . "' 
                        AND reviewer_employee_id='" . $this->session->userdata('pms_employee_id') . "' 
                        AND time_period_id='" . $time_period_id . "' ";

                $query = $this->db->query($sql);
                $reviewer_overall_rating = $query->first_row();
                //$reviewer_date = date($data['s_date_format'], strtotime($reviewer_overall_rating->date_created));
                $reviewer_date = date($data['s_date_format'], strtotime(date("Y-m-d")));

                //Fixed apraiser_date
                $data['apraiser_date'] = $apraiser_date = '';

                /**
                  if (!empty($apraiser_overall_rating)) {
                  $data['apraiser_assessment_score'] = $this->reviewermodel->getScoreNameByScore($apraiser_overall_rating['apraiser_score']);
                  $data['apraiser_date'] = date($data['s_date_format'], strtotime($apraiser_overall_rating['date_created']));
                  }
                 * */
                //apraiser overall rating score
                $data['apraiser_overall_kra_score'] = $this->reviewermodel->getApraiserTotalKraScore($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
                $data['apraiser_overall_competencies_score'] = $this->reviewermodel->getApraiserTotalCompetenciesScore($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
                $data['apraiser_overall_performance_score'] = (($data['apraiser_overall_kra_score']) + ($data['apraiser_overall_competencies_score']));
                $data['apraiser_overall_performance_score_name'] = $this->reviewermodel->getScoreNameByScore($data['apraiser_overall_performance_score']);

                //  echo  $data['apraiser_overall_kra_score'];echo "<br>";
                //  echo $data['apraiser_overall_competencies_score'] ;echo "<br>";die();
                //   echo  $data['apraiser_overall_performance_score'];die();

                if (!empty($apraisee_relationship_detail) && $apraisee_relationship_detail['submit_status'] == '6') {

                    //$data['kra_detail'] = $this->reviewermodel->getApraiserKraPmsDetail($apraisee_employee_id, $apraiser_employee_id);
                    //Added By Ajay
                    $data['kra_detail'] = $this->reviewermodel->getApraiserKraPmsDetailMultiple($apraisee_employee_id, $arr_apraiser_list);

                    $data['employee_name'] = $employee_detail->fname . ' ' . $employee_detail->lname;
                } elseif (!empty($apraisee_relationship_detail) && $apraisee_relationship_detail['submit_status'] > '6') {
                    //echo $apraisee_employee_id.' '.$apraiser_employee_id.' '.$reviewer_employee_id;
                    //$data['reviewer_kra_detail'] = $this->reviewermodel->getReviewerKraPmsDetail($apraisee_employee_id, $apraiser_employee_id, $reviewer_employee_id);
                    $data['reviewer_kra_detail'] = $this->reviewermodel->getReviewerKraPmsDetailMultiple($apraisee_employee_id, $arr_apraiser_list, $reviewer_employee_id);

                    if (!empty($data['reviewer_kra_detail'])) {
                        foreach ($data['reviewer_kra_detail'] as $keyd => $vald) {
                            if ($data['final_score'] == '') {
                                $data['final_score'] = ($vald['total_score']);
                            } else {
                                $data['final_score'] += ($vald['total_score']);
                            }
                        }
                    }

                    //$data['reviewer_kra_detail'] = '';

                    $employee_detail = $this->employeemodel->getEmployeeById($apraisee_employee_id);
                    $data['employee_name'] = $employee_detail->fname . ' ' . $employee_detail->lname;

                    if ($apraisee_relationship_detail['submit_status'] >= '8' && !empty($data['reviewer_kra_detail'])) {
                        $overall_rating_of_reviewer = $this->reviewermodel->getReviewerOverAllRatingById($apraisee_employee_id, $apraiser_employee_id, $reviewer_employee_id, $time_period_id);


                        if (!empty($overall_rating_of_reviewer)) {
                            $data['reviewer_date'] = date($data['s_date_format'], strtotime($overall_rating_of_reviewer['date_created']));
                        }

                        $data['competency_with_idp_detail'] = $this->apraisermodel->getEmployeeCompetenciesWithIdp($apraisee_employee_id, $apraiser_employee_id);
                        //echo '<pre>';
                        //print_r($data['competency_with_idp_detail'] );
                        //echo '</pre>';

                        foreach ($data['competency_with_idp_detail'] as $keycwi => $valcwi) {
                            if ($data['final_score_cwi'] == '') {
                                $data['final_score_cwi'] = ($valcwi['total_score']);
                            } else {
                                $data['final_score_cwi'] += ($valcwi['total_score']);
                            }
                        }
                        //$data['technical_detail'] = $this->apraisermodel->getEmployeeTechnicalDetail($apraisee_employee_id, $apraiser_employee_id);
                        //Modified By Ajay
                        $data['technical_detail'] = $this->apraisermodel->getEmployeeTechnicalDetailMultiple($apraisee_employee_id, $arr_apraiser_list);


                        //$data['behavioural_detail'] = $this->apraisermodel->getEmployeeBehaviouralDetail($apraisee_employee_id, $apraiser_employee_id);
                        $data['behavioural_detail'] = $this->apraisermodel->getEmployeeBehaviouralDetailMultiple($apraisee_employee_id, $arr_apraiser_list);



                        $data['overall_kra_score'] = round((($data['final_score'] * 70 ) / 100), 2);
                        $data['overall_competencies_score'] = round((($data['final_score_cwi'] * 30 ) / 100), 2);
                        $data['overall_performance_score'] = round((($data['overall_kra_score']) + ($data['overall_competencies_score'])), 2);
                        if ($data['overall_performance_score'] < 2) {
                            $data['reviewer_assessment_score'] = 'BE';
                        } elseif ($data['overall_performance_score'] > 2 && $data['overall_performance_score'] < 2.79) {
                            $data['reviewer_assessment_score'] = 'NI';
                        } elseif ($data['overall_performance_score'] > 2.80 && $data['overall_performance_score'] < 3.49) {
                            $data['reviewer_assessment_score'] = 'ME';
                        } elseif ($data['overall_performance_score'] > 3.50 && $data['overall_performance_score'] < 4.24) {
                            $data['reviewer_assessment_score'] = 'EE';
                        } elseif ($data['overall_performance_score'] > 4.25 && $data['overall_performance_score'] < 5.00) {
                            $data['reviewer_assessment_score'] = 'FEE';
                        }
                    } elseif ($apraisee_relationship_detail['submit_status'] >= '8') {

                        $data['error'] = 'Please Fill Up Appraiser KRA form First';
                    }

//                    if($apraisee_relationship_detail['submit_status'] >= '9' && !empty($data['competency_with_idp_detail']))
//                    {
//                        $data['overall_rating_detail'] = $this->apraisermodel->getOverallRatingDetail($apraisee_employee_id,$apraiser_employee_id,$time_period_id);
//                    }
//                    elseif($apraisee_relationship_detail['submit_status'] >= '9')
//                    {
//                        $data['error']  ='Please Fill Up Competencies With IDp  First';
//                    }
                } elseif (!empty($apraisee_relationship_detail) && $apraisee_relationship_detail['submit_status'] < '6') {
                    $data['errormsg'] = 'Awaiting for Apraisee Response.';
                } else {
                    //$data['error']      = 'Page Not Found';
                    redirect('accessdenied', 'refresh');
                }
            } else {
                // $data['error']      = 'Page not found';
                redirect('accessdenied', 'refresh');
            }

            //die();
            //added By Ajay
            $data['new_competencies_for_refrence'] = $this->display_reviewer_competencies($apraisee_employee_id, $employee_detail->grade_id);
            $data['reviewer_idp_score'] = $this->reviewer_total_score;
            //Add Final Score
            $final_score = (($data['final_score'] * 70 ) / 100 );
            $data['final_score_kra'] = number_format($final_score, 2, '.', '');

            //IDP
            $reviewer_idp_score = (($data['reviewer_idp_score'] * 30 ) / 100 );
            $data['final_score_idp'] = number_format($reviewer_idp_score, 2, '.', '');

            $data['final_total'] = number_format($reviewer_idp_score + $data['final_score_kra'], 2, '.', '');
            $data['reviewer_assessment_score'] = $this->reviewermodel->getScoreNameByScore($data['final_total']);


            $data['competencies_for_refrence'] = $this->commonmodel->getCompetenciesByGrade($employee_detail->grade_id);
            $data['all_ratings'] = $this->taskschedulemodel->getAllRatimgs('1');
            $data['idp_detail'] = $this->apraiseemodel->getAllIdpsOfApraisee($apraisee_employee_id, $time_period_id);
            $data['ratings_for_refrence'] = $this->apraisermodel->getAllRatings('1');
            $data['apraisee_employee_id'] = $apraisee_employee_id;
            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            $this->load->view('default/clientadmin/cadmin_report_reviewer', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function addkradata() {
        $data = array();
        //echo '<pre>';
        //print_r($_POST);
        //echo '</pre>';
        //die();

        if ($this->session->userdata('pms_employee_id')) {

            $rating = array();
            $comment = array();
            $time_period_id = '1';
            $apraiser_kra_id = '';

            if (!empty($_POST)) {
                $apraisee_employee_id = $this->input->post('apraisee_employee_id', true);
                // echo "empid=".$apraisee_employee_id;
                foreach ($_POST as $key => $val) {

                    $kra_id_detail = explode('_', $key);
                    $apraiser_kra_id = $kra_id_detail[1];
                    if ($kra_id_detail[0] == 'rating') {
                        $rating[$apraiser_kra_id] = $val;
                    } else {
                        $comment[$apraiser_kra_id] = $val;
                    }
                }

                $employee_relationship_materix_id = '';
                $submit_status = '';
                $employee_relationship_materix_detail = $this->reviewermodel->getRelationshipDetailOfEmployee($apraisee_employee_id, $time_period_id);
                if (!empty($employee_relationship_materix_detail)) {
                    $employee_relationship_materix_id = $employee_relationship_materix_detail['employee_relationship_materix_id'];
                    $submit_status = $employee_relationship_materix_detail['submit_status'];
                }

                //echo '<pre>';
                //print_r($rating);
                //echo '</pre>';
                //die();

                foreach ($rating as $key => $val) {

                    $apraiser_kra_id = $key;
                    $apraiser_kra_detail = $this->apraisermodel->getApraiserKraPmsById($apraiser_kra_id);
                    $comment_desc = '';

                    if (array_key_exists($apraiser_kra_id, $comment)) {
                        $comment_desc = $comment[$apraiser_kra_id];
                    }

                    $data = array(
                        'reviewer_employee_id' => $this->session->userdata('pms_employee_id'),
                        'apraiser_employee_id' => $apraiser_kra_detail['apraiser_employee_id'],
                        'apraisee_employee_id' => $apraiser_kra_detail['apraisee_employee_id'],
                        'time_period_id' => $apraiser_kra_detail['time_period_id'],
                        'apraiser_kra_id' => $apraiser_kra_id,
                        'reviewer_rating_id' => $val,
                        'reviewer_comment' => ucfirst($comment_desc),
                        'reviewer_date_created' => date('Y-m-d'),
                        'reviewer_ip_address' => $this->input->ip_address()
                    );
                    $result = $this->reviewermodel->addApraiseeKraByReviewer($data);
                }


                // echo $employee_relationship_materix_id;//die();
                //update relationship materix status
                //second parameter 3 is submit status
                if ($submit_status != '' && $submit_status <= '7') {
                    $this->apraiseemodel->UpdateRelationshipStatus($employee_relationship_materix_id, '7');
                }

                //TODO Fix Update multiple relationship - Ajay
                $sql_multiple_relationship = "SELECT  rm.employee_relationship_materix_id, rm.apraiser_employee_id, e.fname, e.lname 
                        FROM " . $this->db->dbprefix . "employee_relationship_materix rm
                        LEFT JOIN " . $this->db->dbprefix . "employee e ON rm.apraiser_employee_id = e.pms_employee_id 
                        WHERE rm.time_period_id = '" . $time_period_id . "' 
                        and rm.pms_employee_id = '" . $apraisee_employee_id . "' ";
                //echo $sql_multiple_relationship;
                $query_m = $this->db->query($sql_multiple_relationship);

                //Collect Apraiser ids
                $arrApraisers = array();
                $arrRelationIds = array();
                foreach ($query_m->result() as $key_r => $val_r) {
                    $arrApraisers[] = $val_r->apraiser_employee_id;
                    $arrRelationIds[] = $val_r->employee_relationship_materix_id;
                }

                //TODO: fixed for update status for all relateionship matrix
                foreach ($arrRelationIds as $row_rm) {
                    $this->apraiseemodel->UpdateRelationshipStatus($row_rm, '8');
                }

                if ($result) {
                    echo "Apraisee KRA Submitted Successfully By Reviewer";
                } else {
                    echo "Please try again";
                }
            }
        }
    }

    function getreviewerkradetail() {

        $response = array();
        $time_period_id = '1';
        $apraisee_employee_id = $this->input->post('apraisee_employee_id', true);
        $apraiser_employee_id = '0';
        $reviewer_employee_id = $this->input->post('pms_employee_id', true);

        //echo   $apraisee_employee_id.' '.$reviewer_employee_id;
        $employee_relationship_materix_detail = $this->reviewermodel->getRelationshipDetailOfEmployee($apraisee_employee_id, $time_period_id);
        // echo "<pre>";


        if (!empty($employee_relationship_materix_detail)) {
            $apraiser_employee_id = $employee_relationship_materix_detail['apraiser_employee_id'];
        }


        $response['kra_detail'] = $this->reviewermodel->getReviewerKraPmsDetail($apraisee_employee_id, $apraiser_employee_id, $reviewer_employee_id);
        //  print_r($response['kra_detail']);die();
        $final_score = 0;
        if (!empty($response['kra_detail'])) {
            foreach ($response['kra_detail'] as $key => $val) {
                if ($final_score == 0) {
                    $final_score = (($val['total_score']));
                } else {
                    $final_score += (($val['total_score']));
                }
            }
        }
        // echo "</pre>";die();
        $response['final_score'] = number_format($final_score, 2, '.', '');
        //$response['final_score_of_overall_rating'] = (($final_score * 70)/100);
        // $response['final_score_of_overall_rating']  = number_format($response['final_score__of_overall_rating'],'2','.','');
        die(json_encode($response));
    }

    function addcompetencywithidp() {
        $data = array();

        if ($this->session->userdata('pms_employee_id')) {
            $time_period_id = '1';
            $apraiser_employee_id = '0';
            $reviewer_employee_id = $this->session->userdata('pms_employee_id');
            $employee_relationship_materix_id = '';

            if (!empty($_POST)) {
                $result = '';
                $result_technical = '';
                $result_behavioural = '';
                $result_overall_rating = '';
                $apraisee_employee_id = $this->input->post('apraisee_employee_id', true);
                $employee_relationship_materix_id = '0';
                $employee_relationship_materix_detail = $this->reviewermodel->getRelationshipDetailOfEmployee($apraisee_employee_id, $time_period_id);
                if (!empty($employee_relationship_materix_detail)) {
                    $employee_relationship_materix_id = $employee_relationship_materix_detail['employee_relationship_materix_id'];
                    $apraiser_employee_id = $employee_relationship_materix_detail['apraiser_employee_id'];
                }
                foreach ($_POST as $key => $val) {

                    if ($key != 'idpE_item' && $key != 'appraisee_employee_id' && $key != 'invE_item') {
                        $com_ref_id_detail = explode('_', $key);
                        if ($com_ref_id_detail[0] == 'rate') {
                            $competencies_for_refrence_id = $com_ref_id_detail[1];
                            $data['competency_with_idp'] = array(
                                'pms_employee_id' => $apraisee_employee_id,
                                'apraiser_employee_id' => $apraiser_employee_id,
                                'reviewer_employee_id' => $reviewer_employee_id,
                                'time_period_id' => $time_period_id,
                                'competencies_for_refrence_id' => $competencies_for_refrence_id,
                                'scale' => $val
                            );
                            $result = $this->reviewermodel->addCompetencyOFApraisee($data['competency_with_idp']);
                        }
                    }

                    if ($key == 'idpE_item') {
                        foreach ($val as$keyt => $valt) {
                            $data['competency_technical'] = array(
                                'pms_employee_id' => $apraisee_employee_id,
                                'apraiser_employee_id' => $apraiser_employee_id,
                                'reviewer_employee_id' => $reviewer_employee_id,
                                'time_period_id' => $time_period_id,
                                'reviewer_technical_area' => ucfirst($valt),
                                'reviewer_technical_status' => '1'
                            );
                            $result_technical = $this->reviewermodel->addCompetencyTechnicalOFApraisee($data['competency_technical']);
                        }
                    }

                    if ($key == 'invE_item') {
                        foreach ($val as$keyb => $valb) {
                            $data['competency_behavioural'] = array(
                                'pms_employee_id' => $apraisee_employee_id,
                                'apraiser_employee_id' => $apraiser_employee_id,
                                'reviewer_employee_id' => $reviewer_employee_id,
                                'time_period_id' => $time_period_id,
                                'reviewer_behavioural_area' => ucfirst($valb),
                                'reviewer_behaviourl_status' => '1'
                            );
                            $result_behavioural = $this->reviewermodel->addCompetencyBehaviouralOFApraisee($data['competency_behavioural']);
                        }
                    }
                    //for overall rating start
                    $response['competency_with_idp_detail'] = $this->reviewermodel->getEmployeeCompetenciesWithIdp($apraisee_employee_id, $reviewer_employee_id, $time_period_id);
                    $response['final_score_cwi'] = '';
                    if (!empty($response['competency_with_idp_detail'])) {
                        foreach ($response['competency_with_idp_detail'] as $keycwi => $valcwi) {
                            if ($response['final_score_cwi'] == '') {
                                $response['final_score_cwi'] = ($valcwi['total_score']);
                            } else {
                                $response['final_score_cwi'] += ($valcwi['total_score']);
                            }
                        }
                    }

                    //overall rating end
                }

                $kra_detail = $this->reviewermodel->getReviewerKraPmsDetail($apraisee_employee_id, $apraiser_employee_id, $reviewer_employee_id);
                //  print_r($response['kra_detail']);die();
                $final_kra_score = 0;
                if (!empty($kra_detail)) {
                    foreach ($kra_detail as $key => $val) {
                        if ($final_kra_score == 0) {
                            $final_kra_score = (($val['total_score']));
                        } else {
                            $final_kra_score += (($val['total_score']));
                        }
                    }
                }

                $reviewer_kra_score = number_format((($final_kra_score * 70) / 100), 2, '.', '');
                $reviewer_cwi_score = number_format((($response['final_score_cwi'] * 30) / 100), 2, '.', '');
                $reviewer_total_score = number_format((($reviewer_kra_score) + ($reviewer_cwi_score)), 2, '.', '');
                $data['overall_rating'] = array(
                    'pms_employee_id' => $apraisee_employee_id,
                    'apraiser_employee_id' => $apraiser_employee_id,
                    'reviewer_employee_id' => $reviewer_employee_id,
                    'time_period_id' => $time_period_id,
                    'reviewer_score' => $reviewer_total_score,
                    'competency_score' => $reviewer_cwi_score,
                    'kra_score' => $reviewer_kra_score,
                    'date_created' => date('Y-m-d'),
                    'ip_address' => $this->input->ip_address()
                );

                $result_overall_rating = $this->reviewermodel->addReviewerOverallRating($data['overall_rating']);


                //TODO Fix Update multiple relationship - Ajay
                $sql_multiple_relationship = "SELECT  rm.employee_relationship_materix_id, rm.apraiser_employee_id, e.fname, e.lname 
                        FROM " . $this->db->dbprefix . "employee_relationship_materix rm
                        LEFT JOIN " . $this->db->dbprefix . "employee e ON rm.apraiser_employee_id = e.pms_employee_id 
                        WHERE rm.time_period_id = '" . $time_period_id . "' 
                        and rm.pms_employee_id = '" . $apraisee_employee_id . "' ";
                //echo $sql_multiple_relationship ;
                $query_m = $this->db->query($sql_multiple_relationship);

                //Collect Apraiser ids
                $arrApraisers = array();
                $arrRelationIds = array();
                foreach ($query_m->result() as $key_r => $val_r) {
                    $arrApraisers[] = $val_r->apraiser_employee_id;
                    $arrRelationIds[] = $val_r->employee_relationship_materix_id;
                }

                //TODO: fixed for update status for all relateionship matrix
                foreach ($arrRelationIds as $row_rm) {
                    $this->apraiseemodel->UpdateRelationshipStatus($row_rm, '8');
                }


                //if ($result == 1 && $result_technical == 1 && $result_behavioural == 1 && $result_overall_rating == 1) {
                //No need to check technical and behavioural - Reviewer did not modify this
                if ($result == 1 && $result_overall_rating == 1) {
                    $this->apraiseemodel->UpdateRelationshipStatus($employee_relationship_materix_id, '8');
                    echo "Competencies with IDP Submitted Successfully By Appraiser";
                } else {
                    echo "Please try again";
                }
            }
        }//main if close
    }

    function getApraiserCompetenciesDetail() {
        $response = array();
        $response['final_score_cwi'] = '';
        $time_period_id = '1';
        $apraisee_employee_id = $this->input->post('apraisee_employee_id', true);
        $apraiser_employee_id = '0';
        $reviewer_employee_id = $this->input->post('pms_employee_id', true);


        $employee_relationship_materix_detail = $this->reviewermodel->getRelationshipDetailOfEmployee($apraisee_employee_id, $time_period_id);

        if (!empty($employee_relationship_materix_detail)) {
            $apraiser_employee_id = $employee_relationship_materix_detail['apraiser_employee_id'];
        }


        $response['kra_detail'] = $this->reviewermodel->getReviewerKraPmsDetail($apraisee_employee_id, $apraiser_employee_id, $reviewer_employee_id);
        // print_r($response['kra_detail']);die();
        $final_score = 0;
        if (!empty($response['kra_detail'])) {
            foreach ($response['kra_detail'] as $key => $val) {
                if ($final_score == 0) {
                    $final_score = (($val['total_score']));
                } else {
                    $final_score += (($val['total_score']));
                }
            }
        }
        // echo "</pre>";die();
        $response['final_score'] = number_format($final_score, 2, '.', '');

        $response['competency_with_idp_detail'] = $this->reviewermodel->getEmployeeCompetenciesWithIdp($apraisee_employee_id, $reviewer_employee_id, $time_period_id);

        foreach ($response['competency_with_idp_detail'] as $keycwi => $valcwi) {
            if ($response['final_score_cwi'] == '') {
                $response['final_score_cwi'] = ($valcwi['total_score']);
            } else {
                $response['final_score_cwi'] += ($valcwi['total_score']);
            }
        }
        $response['technical_detail'] = $this->reviewermodel->getEmployeeTechnicalDetail($apraisee_employee_id, $reviewer_employee_id, $time_period_id);
        $response['behavioural_detail'] = $this->reviewermodel->getEmployeeBehaviouralDetail($apraisee_employee_id, $reviewer_employee_id, $time_period_id);
        //$apraiser_overall_kra_score             = $this->reviewermodel->getApraiserTotalKraScore($apraisee_employee_id,$apraiser_employee_id,$time_period_id);
        $response['overall_kra_score'] = round((( $response['final_score'] * 70 ) / 100), 2);
        $response['overall_competencies_score'] = round((($response['final_score_cwi'] * 30 ) / 100), 2);
        $response['overall_performance_score'] = round((($response['overall_kra_score']) + ($response['overall_competencies_score'])), 2);
        if ($response['overall_performance_score'] < 2) {
            $response['apraiser_assessment_score'] = 'BE';
        } elseif ($response['overall_performance_score'] > 2 && $response['overall_performance_score'] < 2.79) {
            $response['apraiser_assessment_score'] = 'NI';
        } elseif ($response['overall_performance_score'] > 2.80 && $response['overall_performance_score'] < 3.49) {
            $response['apraiser_assessment_score'] = 'ME';
        } elseif ($response['overall_performance_score'] > 3.50 && $response['overall_performance_score'] < 4.24) {
            $response['apraiser_assessment_score'] = 'EE';
        } elseif ($response['overall_performance_score'] > 4.25 && $response['overall_performance_score'] < 5.00) {
            $response['apraiser_assessment_score'] = 'FEE';
        }


        die(json_encode($response));
    }

    function addreviewerassessmentiagree() {
        $response = array();
        $data = array();
        $data['final_score'] = '';
        $data['final_score_cwi'] = '';        
        $time_period_id = '0';
        $imediate_prev_year = $this->commonmodel->get_immediate_previous_year();                    
        if (!empty($imediate_prev_year)) {
            $time_period_id = $imediate_prev_year['time_period_id'];
        }
        $apraisee_employee_id = $this->input->post('pms_employee_id', true);
        $reviewer_employee_id = $this->session->userdata('pms_employee_id');
        $apraiser_employee_id = '';
        $submit_status = '';
        $employee_relationship_materix_id = '';
        $apraisee_relationship_detail = $this->reviewermodel->getRelationshipStatus($apraisee_employee_id, $reviewer_employee_id, $time_period_id);


        if (!empty($apraisee_relationship_detail)) {
            $apraiser_employee_id = $apraisee_relationship_detail['apraiser_employee_id'];
            $submit_status = $apraisee_relationship_detail['submit_status'];
            $employee_relationship_materix_id = $apraisee_relationship_detail['employee_relationship_materix_id'];
            $data['apraiser_kra_detail'] = $this->apraisermodel->getApraiserKraPmsDetail($apraisee_employee_id, $apraiser_employee_id);

            //Add Kra Details
            //$result = $this->db->insert($this->db->dbprefix . 'reviewer_kra', $data);

            $sql_multiple_relationship = "SELECT  rm.employee_relationship_materix_id, rm.apraiser_employee_id, e.fname, e.lname 
                        FROM " . $this->db->dbprefix . "employee_relationship_materix rm
                        LEFT JOIN " . $this->db->dbprefix . "employee e ON rm.apraiser_employee_id = e.pms_employee_id 
                        WHERE rm.time_period_id = '" . $time_period_id . "' 
                        and rm.pms_employee_id = '" . $apraisee_employee_id . "' ";
            //echo $sql_multiple_relationship ;
            $query_m = $this->db->query($sql_multiple_relationship);

            //Collect Apraiser ids
            $arrApraisers = array();
            $arrRelationIds = array();
            foreach ($query_m->result() as $key_r => $val_r) {
                $arrApraisers[] = $val_r->apraiser_employee_id;
                $arrRelationIds[] = $val_r->employee_relationship_materix_id;
            }

            //Get Existing Apraisee KRA
            $sql = "SELECT * FROM " . $this->db->dbprefix . "apraiser_kra 
                    WHERE apraisee_employee_id='" . $apraisee_employee_id . "' 
                    AND time_period_id='" . $time_period_id . "' 
                    AND apraiser_employee_id IN('" . implode("','", $arrApraisers) . "') ";
            $query_m = $this->db->query($sql);
            //echo $sql ;
            //print_r($query_m->result());
            //die();

            $data['kra_detail'] = $query_m->result();
            //die();


            foreach ($data['kra_detail'] as $keyd => $vald) {
                $reviewer_kra_data = array(
                    'reviewer_employee_id' => $reviewer_employee_id,
                    'apraiser_employee_id' => $vald->apraiser_employee_id,
                    'apraisee_employee_id' => $vald->apraisee_employee_id,
                    'time_period_id' => $vald->time_period_id,
                    'apraiser_kra_id' => $vald->apraiser_kra_id,
                    'reviewer_rating_id' => $vald->apraiser_rating_id,
                    'reviewer_comment' => ucfirst(trim($vald->apraiser_comment)),
                    'reviewer_date_created' => date('Y-m-d'),
                    'reviewer_ip_address' => $this->input->ip_address()
                );
                $result = $this->reviewermodel->addApraiseeKraByReviewer($reviewer_kra_data);
            }

            /**
              if (!empty($data['apraiser_kra_detail'])) {
              foreach ($data['apraiser_kra_detail'] as $keyd => $vald) {
              $reviewer_kra_data = array(
              'reviewer_employee_id' => $reviewer_employee_id,
              'apraiser_employee_id' => $apraiser_employee_id,
              'apraisee_employee_id' => $apraisee_employee_id,
              'time_period_id' => $vald['time_period_id'],
              'apraiser_kra_id' => $vald['apraiser_kra_id'],
              'reviewer_rating_id' => $vald['apraiser_rating_id'],
              'reviewer_comment' => ucfirst($vald['apraiser_comment']),
              'reviewer_date_created' => date('Y-m-d'),
              'reviewer_ip_address' => $this->input->ip_address()
              );
              $result = $this->reviewermodel->addApraiseeKraByReviewer($reviewer_kra_data);
              }

              if ($submit_status != '' && $submit_status <= '7') {
              $this->apraiseemodel->UpdateRelationshipStatus($employee_relationship_materix_id, '7');
              }
              }

             * */
            $data['competency_with_idp_detail'] = $this->apraisermodel->getEmployeeCompetenciesWithIdp($apraisee_employee_id, $apraiser_employee_id);

            /**
              if ($data['competency_with_idp_detail']) {
              foreach ($data['competency_with_idp_detail'] as $keycwi => $valcwi) {
              $data['competency_with_idp'] = array(
              'pms_employee_id' => $apraisee_employee_id,
              'apraiser_employee_id' => $apraiser_employee_id,
              'reviewer_employee_id' => $reviewer_employee_id,
              'time_period_id' => $valcwi['time_period_id'],
              'competencies_for_refrence_id' => $valcwi['competencies_for_refrence_id'],
              'scale' => $valcwi['scale']
              );
              $result1 = $this->reviewermodel->addCompetencyOFApraisee($data['competency_with_idp']);
              }
              }
             * */
            //// Add new Method ///
            $employee_detail = $this->employeemodel->getEmployeeById($apraisee_employee_id);
            $comp_for_ref = $this->commonmodel->getCompetenciesByGrade($employee_detail->grade_id);
            //echo '<pre>';
            //print_r($comp_for_ref);
            //echo '</pre>';
            //Get Multiple appraiser
            $sql_multiple_relationship = "SELECT  rm.employee_relationship_materix_id, rm.apraiser_employee_id, e.fname, e.lname 
                        FROM " . $this->db->dbprefix . "employee_relationship_materix rm
                        LEFT JOIN " . $this->db->dbprefix . "employee e ON rm.apraiser_employee_id = e.pms_employee_id 
                        WHERE rm.time_period_id = '" . $time_period_id . "' 
                        and rm.pms_employee_id = '" . $apraisee_employee_id . "' ";
            //echo $sql_multiple_relationship ;
            $query_m = $this->db->query($sql_multiple_relationship);


            $reviewer_id = $this->session->userdata('pms_employee_id');

            $total_avg = 0;
            $total_rev_score = 0;

            foreach ($comp_for_ref as $key => $val) {


                //Display cols for multiple apraiser
                $my_average = 0;
                $my_scale = 0;
                foreach ($query_m->result() as $ckey => $cval) {
                    $get_scale_info = $this->getCompetenciesDetails($val['competencies_for_refrence_id'], $cval->apraiser_employee_id, $apraisee_employee_id, $time_period_id);
                    $myscore = number_format((( $val['weightage_value'] * $get_scale_info->scale ) / 100), 2, '.', '');
                    $my_average = $my_average + $myscore;
                    //$output .= '<td style="text-align:right">' . $get_scale_info->scale . ' | ' . $myscore . '</td>';
                    /**
                      echo '<br>Apraisee ID ' . $apraisee_employee_id ;
                      echo '<br>Referece id: ' . $val['competencies_for_refrence_id'] ;
                      echo '<br>Apriser ID: ' . $cval->apraiser_employee_id ;
                      echo '<br>' . $get_scale_info->scale . ' | ' . $myscore ;
                      echo '<hr>';
                     * */
                    $my_scale = $my_scale + $get_scale_info->scale;
                }

                //Display Average
                //Calculate Average 
                $my_average = number_format(( $my_average / count($query_m->result())), 2, '.', '');
                $my_scale = number_format(($my_scale / count($query_m->result())), 2, '.', '');

                //Get Individual Details
                ///Insert New Data
                $data['competency_with_idp'] = array(
                    'pms_employee_id' => $apraisee_employee_id,
                    'apraiser_employee_id' => $apraiser_employee_id,
                    'reviewer_employee_id' => $reviewer_employee_id,
                    'time_period_id' => $time_period_id,
                    'competencies_for_refrence_id' => $val['competencies_for_refrence_id'],
                    'scale' => $my_scale
                );
                $result1 = $this->reviewermodel->addCompetencyOFApraisee($data['competency_with_idp']);
            }

            //// End New Method ///


            $data['technical_detail'] = $this->apraisermodel->getEmployeeTechnicalDetail($apraisee_employee_id, $apraiser_employee_id);
            if (!empty($data['technical_detail'])) {
                foreach ($data['technical_detail'] as $keytec => $valtech) {
                    $data['competency_technical'] = array(
                        'pms_employee_id' => $apraisee_employee_id,
                        'apraiser_employee_id' => $apraiser_employee_id,
                        'reviewer_employee_id' => $reviewer_employee_id,
                        'time_period_id' => $valtech['time_period_id'],
                        'reviewer_technical_area' => ucfirst($valtech['technical_area']),
                        'reviewer_technical_status' => '1'
                    );
                    $result_technical = $this->reviewermodel->addCompetencyTechnicalOFApraisee($data['competency_technical']);
                }
            }

            $data['behavioural_detail'] = $this->apraisermodel->getEmployeeBehaviouralDetail($apraisee_employee_id, $apraiser_employee_id);
            if (!empty($data['behavioural_detail'])) {
                foreach ($data['behavioural_detail'] as $keybeh => $valbeh) {
                    $data['competency_behavioural'] = array(
                        'pms_employee_id' => $apraisee_employee_id,
                        'apraiser_employee_id' => $apraiser_employee_id,
                        'reviewer_employee_id' => $reviewer_employee_id,
                        'time_period_id' => $valbeh['time_period_id'],
                        'reviewer_behavioural_area' => ucfirst($valbeh['behavioural_area']),
                        'reviewer_behaviourl_status' => '1'
                    );
                    $result_behavioural = $this->reviewermodel->addCompetencyBehaviouralOFApraisee($data['competency_behavioural']);
                }
            }
            $data['overall_kra_score'] = number_format((($data['final_score'] * 70 ) / 100), 2, '.', '');
            $data['overall_competencies_score'] = number_format((($data['final_score_cwi'] * 30 ) / 100), 2, '.', '');
            $data['overall_performance_score'] = number_format((($data['overall_kra_score']) + ($data['overall_competencies_score'])), 2, '.', '');
            $data['apraiser_assessment_score'] = $this->reviewermodel->getScoreNameByScore($data['overall_performance_score']);
            $data['overall_rating_detail'] = $this->apraisermodel->getOverallRatingDetail($apraisee_employee_id, $apraiser_employee_id, $time_period_id);

            //print_r($data['overall_rating_detail']);

            if (!empty($data['overall_rating_detail'])) {
                $data['overall_rating'] = array(
                    'pms_employee_id' => $apraisee_employee_id,
                    'apraiser_employee_id' => $apraiser_employee_id,
                    'reviewer_employee_id' => $reviewer_employee_id,
                    'time_period_id' => $data['overall_rating_detail'][0]['time_period_id'],
                    'reviewer_score' => $data['overall_rating_detail'][0]['apraiser_score'],
                    'date_created' => date('Y-m-d'),
                    'ip_address' => $this->input->ip_address()
                );
            }
            //Modified By Ajay
            //If overall rating not found then did not apply overall rating
            if (!empty($data['overall_rating_detail'])) {
                //// Bug 8 $result_overall_rating = $this->reviewermodel->addReviewerOverallRating($data['overall_rating']);
            } else {
                //Pass parameter as success
                $result_overall_rating = 1;
            }

            if ($result1 == 1 && $result_technical == 1 && $result_behavioural == 1 && $result_overall_rating == 1) {
                $this->apraiseemodel->UpdateRelationshipStatus($employee_relationship_materix_id, '8');
            }

            //TODO: fixed for update status for all relateionship matrix
            foreach ($arrRelationIds as $row_rm) {
                $this->apraiseemodel->UpdateRelationshipStatus($row_rm, '8');
            }

            //TODO: Fixed Add overall rating for reviewer if Reviewer agree
            $reviewer_total_score = 0;
            $data['overall_rating'] = array(
                'pms_employee_id' => $apraisee_employee_id,
                'apraiser_employee_id' => $apraiser_employee_id,
                'reviewer_employee_id' => $reviewer_employee_id,
                'time_period_id' => $time_period_id,
                'reviewer_score' => $reviewer_total_score,
                'date_created' => date('Y-m-d'),
                'ip_address' => $this->input->ip_address()
            );

            //Bug 8
            //// Bug 8 $result_overall_rating = $this->reviewermodel->addReviewerOverallRating($data['overall_rating']);
            //TODO: Fix - for I agree copy all appraisers rating as  reviewer rating
            $this->reviewermodel->copyOverallRatingIAgree($apraisee_employee_id, $reviewer_employee_id, $time_period_id);

            $response['msg'] = 'Appraisee Assessment Submitted Successfully';
        }
        die(json_encode($response));
    }

    function addreviewerassessment() {

        $response = array();
        $data = array();
        $data['final_score'] = '';
        $data['final_score_cwi'] = '';
        $time_period_id = '0';
        $imediate_prev_year = $this->commonmodel->get_immediate_previous_year();                    
        if (!empty($imediate_prev_year)) {
            $time_period_id = $imediate_prev_year['time_period_id'];
        }
                    
        $apraisee_employee_id = $this->input->post('pms_employee_id', true);
        $reviewer_employee_id = $this->session->userdata('pms_employee_id');
        $apraiser_employee_id = '';
        $submit_status = '';
        $employee_relationship_materix_id = '';
        $apraisee_relationship_detail = $this->reviewermodel->getRelationshipStatus($apraisee_employee_id, $reviewer_employee_id, $time_period_id);


        if (!empty($apraisee_relationship_detail)) {
            $apraiser_employee_id = $apraisee_relationship_detail['apraiser_employee_id'];
            $submit_status = $apraisee_relationship_detail['submit_status'];
            $employee_relationship_materix_id = $apraisee_relationship_detail['employee_relationship_materix_id'];
            $data['apraiser_kra_detail'] = $this->apraisermodel->getApraiserKraPmsDetail($apraisee_employee_id, $apraiser_employee_id);

            //Add Kra Details
            //$result = $this->db->insert($this->db->dbprefix . 'reviewer_kra', $data);

            $sql_multiple_relationship = "SELECT  rm.employee_relationship_materix_id, rm.apraiser_employee_id, e.fname, e.lname 
                        FROM " . $this->db->dbprefix . "employee_relationship_materix rm
                        LEFT JOIN " . $this->db->dbprefix . "employee e ON rm.apraiser_employee_id = e.pms_employee_id 
                        WHERE rm.time_period_id = '" . $time_period_id . "' 
                        and rm.pms_employee_id = '" . $apraisee_employee_id . "' ";
            //echo $sql_multiple_relationship ;
            $query_m = $this->db->query($sql_multiple_relationship);

            //Collect Apraiser ids
            $arrApraisers = array();
            $arrRelationIds = array();
            foreach ($query_m->result() as $key_r => $val_r) {
                $arrApraisers[] = $val_r->apraiser_employee_id;
                $arrRelationIds[] = $val_r->employee_relationship_materix_id;
            }

            //Get Existing Apraisee KRA
            $sql = "SELECT * FROM " . $this->db->dbprefix . "apraiser_kra 
                    WHERE apraisee_employee_id='" . $apraisee_employee_id . "' 
                    AND time_period_id='" . $time_period_id . "' 
                    AND apraiser_employee_id IN('" . implode("','", $arrApraisers) . "') ";
            $query_m = $this->db->query($sql);
            //echo $sql ;
            //print_r($query_m->result());
            //die();

            $data['kra_detail'] = $query_m->result();
            //die();


            foreach ($data['kra_detail'] as $keyd => $vald) {
                $reviewer_kra_data = array(
                    'reviewer_employee_id' => $reviewer_employee_id,
                    'apraiser_employee_id' => $vald->apraiser_employee_id,
                    'apraisee_employee_id' => $vald->apraisee_employee_id,
                    'time_period_id' => $vald->time_period_id,
                    'apraiser_kra_id' => $vald->apraiser_kra_id,
                    'reviewer_rating_id' => $vald->apraiser_rating_id,
                    'reviewer_comment' => ucfirst(trim($vald->apraiser_comment)),
                    'reviewer_date_created' => date('Y-m-d'),
                    'reviewer_ip_address' => $this->input->ip_address()
                );
                $result = $this->reviewermodel->addApraiseeKraByReviewer($reviewer_kra_data);
            }

            /**
              if (!empty($data['apraiser_kra_detail'])) {
              foreach ($data['apraiser_kra_detail'] as $keyd => $vald) {
              $reviewer_kra_data = array(
              'reviewer_employee_id' => $reviewer_employee_id,
              'apraiser_employee_id' => $apraiser_employee_id,
              'apraisee_employee_id' => $apraisee_employee_id,
              'time_period_id' => $vald['time_period_id'],
              'apraiser_kra_id' => $vald['apraiser_kra_id'],
              'reviewer_rating_id' => $vald['apraiser_rating_id'],
              'reviewer_comment' => ucfirst($vald['apraiser_comment']),
              'reviewer_date_created' => date('Y-m-d'),
              'reviewer_ip_address' => $this->input->ip_address()
              );
              $result = $this->reviewermodel->addApraiseeKraByReviewer($reviewer_kra_data);
              }

              if ($submit_status != '' && $submit_status <= '7') {
              $this->apraiseemodel->UpdateRelationshipStatus($employee_relationship_materix_id, '7');
              }
              }

             * */
            $data['competency_with_idp_detail'] = $this->apraisermodel->getEmployeeCompetenciesWithIdp($apraisee_employee_id, $apraiser_employee_id);

            /**
              if ($data['competency_with_idp_detail']) {
              foreach ($data['competency_with_idp_detail'] as $keycwi => $valcwi) {
              $data['competency_with_idp'] = array(
              'pms_employee_id' => $apraisee_employee_id,
              'apraiser_employee_id' => $apraiser_employee_id,
              'reviewer_employee_id' => $reviewer_employee_id,
              'time_period_id' => $valcwi['time_period_id'],
              'competencies_for_refrence_id' => $valcwi['competencies_for_refrence_id'],
              'scale' => $valcwi['scale']
              );
              $result1 = $this->reviewermodel->addCompetencyOFApraisee($data['competency_with_idp']);
              }
              }
             * */
            //// Add new Method ///
            $employee_detail = $this->employeemodel->getEmployeeById($apraisee_employee_id);
            $comp_for_ref = $this->commonmodel->getCompetenciesByGrade($employee_detail->grade_id);
            //echo '<pre>';
            //print_r($comp_for_ref);
            //echo '</pre>';
            //Get Multiple appraiser
            $sql_multiple_relationship = "SELECT  rm.employee_relationship_materix_id, rm.apraiser_employee_id, e.fname, e.lname 
                        FROM " . $this->db->dbprefix . "employee_relationship_materix rm
                        LEFT JOIN " . $this->db->dbprefix . "employee e ON rm.apraiser_employee_id = e.pms_employee_id 
                        WHERE rm.time_period_id = '" . $time_period_id . "' 
                        and rm.pms_employee_id = '" . $apraisee_employee_id . "' ";
            //echo $sql_multiple_relationship ;
            $query_m = $this->db->query($sql_multiple_relationship);


            $reviewer_id = $this->session->userdata('pms_employee_id');

            $total_avg = 0;
            $total_rev_score = 0;

            foreach ($comp_for_ref as $key => $val) {


                //Display cols for multiple apraiser
                $my_average = 0;
                $my_scale = 0;
                foreach ($query_m->result() as $ckey => $cval) {
                    $get_scale_info = $this->getCompetenciesDetails($val['competencies_for_refrence_id'], $cval->apraiser_employee_id, $apraisee_employee_id, $time_period_id);
                    $myscore = number_format((( $val['weightage_value'] * $get_scale_info->scale ) / 100), 2, '.', '');
                    $my_average = $my_average + $myscore;
                    //$output .= '<td style="text-align:right">' . $get_scale_info->scale . ' | ' . $myscore . '</td>';
                    /**
                      echo '<br>Apraisee ID ' . $apraisee_employee_id ;
                      echo '<br>Referece id: ' . $val['competencies_for_refrence_id'] ;
                      echo '<br>Apriser ID: ' . $cval->apraiser_employee_id ;
                      echo '<br>' . $get_scale_info->scale . ' | ' . $myscore ;
                      echo '<hr>';
                     * */
                    $my_scale = $my_scale + $get_scale_info->scale;
                }

                //Display Average
                //Calculate Average 
                $my_average = number_format(( $my_average / count($query_m->result())), 2, '.', '');
                $my_scale = number_format(($my_scale / count($query_m->result())), 2, '.', '');

                //Get Individual Details
                ///Insert New Data
                $data['competency_with_idp'] = array(
                    'pms_employee_id' => $apraisee_employee_id,
                    'apraiser_employee_id' => $apraiser_employee_id,
                    'reviewer_employee_id' => $reviewer_employee_id,
                    'time_period_id' => $time_period_id,
                    'competencies_for_refrence_id' => $val['competencies_for_refrence_id'],
                    'scale' => $my_scale
                );
                $result1 = $this->reviewermodel->addCompetencyOFApraisee($data['competency_with_idp']);
            }

            //// End New Method ///


            $data['technical_detail'] = $this->apraisermodel->getEmployeeTechnicalDetail($apraisee_employee_id, $apraiser_employee_id);
            if (!empty($data['technical_detail'])) {
                foreach ($data['technical_detail'] as $keytec => $valtech) {
                    $data['competency_technical'] = array(
                        'pms_employee_id' => $apraisee_employee_id,
                        'apraiser_employee_id' => $apraiser_employee_id,
                        'reviewer_employee_id' => $reviewer_employee_id,
                        'time_period_id' => $valtech['time_period_id'],
                        'reviewer_technical_area' => ucfirst($valtech['technical_area']),
                        'reviewer_technical_status' => '1'
                    );
                    $result_technical = $this->reviewermodel->addCompetencyTechnicalOFApraisee($data['competency_technical']);
                }
            }

            $data['behavioural_detail'] = $this->apraisermodel->getEmployeeBehaviouralDetail($apraisee_employee_id, $apraiser_employee_id);
            if (!empty($data['behavioural_detail'])) {
                foreach ($data['behavioural_detail'] as $keybeh => $valbeh) {
                    $data['competency_behavioural'] = array(
                        'pms_employee_id' => $apraisee_employee_id,
                        'apraiser_employee_id' => $apraiser_employee_id,
                        'reviewer_employee_id' => $reviewer_employee_id,
                        'time_period_id' => $valbeh['time_period_id'],
                        'reviewer_behavioural_area' => ucfirst($valbeh['behavioural_area']),
                        'reviewer_behaviourl_status' => '1'
                    );
                    $result_behavioural = $this->reviewermodel->addCompetencyBehaviouralOFApraisee($data['competency_behavioural']);
                }
            }
            $data['overall_kra_score'] = number_format((($data['final_score'] * 70 ) / 100), 2, '.', '');
            $data['overall_competencies_score'] = number_format((($data['final_score_cwi'] * 30 ) / 100), 2, '.', '');
            $data['overall_performance_score'] = number_format((($data['overall_kra_score']) + ($data['overall_competencies_score'])), 2, '.', '');
            $data['apraiser_assessment_score'] = $this->reviewermodel->getScoreNameByScore($data['overall_performance_score']);
            $data['overall_rating_detail'] = $this->apraisermodel->getOverallRatingDetail($apraisee_employee_id, $apraiser_employee_id, $time_period_id);

            //print_r($data['overall_rating_detail']);

            if (!empty($data['overall_rating_detail'])) {
                $data['overall_rating'] = array(
                    'pms_employee_id' => $apraisee_employee_id,
                    'apraiser_employee_id' => $apraiser_employee_id,
                    'reviewer_employee_id' => $reviewer_employee_id,
                    'time_period_id' => $data['overall_rating_detail'][0]['time_period_id'],
                    'reviewer_score' => $data['overall_rating_detail'][0]['apraiser_score'],
                    'date_created' => date('Y-m-d'),
                    'ip_address' => $this->input->ip_address()
                );
            }
            //Modified By Ajay
            //If overall rating not found then did not apply overall rating
            if (!empty($data['overall_rating_detail'])) {
                $result_overall_rating = $this->reviewermodel->addReviewerOverallRating($data['overall_rating']);
            } else {
                //Pass parameter as success
                $result_overall_rating = 1;
            }

            if ($result1 == 1 && $result_technical == 1 && $result_behavioural == 1 && $result_overall_rating == 1) {
                $this->apraiseemodel->UpdateRelationshipStatus($employee_relationship_materix_id, '8');
            }

            //TODO: fixed for update status for all relateionship matrix
            foreach ($arrRelationIds as $row_rm) {
                $this->apraiseemodel->UpdateRelationshipStatus($row_rm, '8');
            }

            //TODO: Fixed Add overall rating for reviewer if Reviewer agree
            $reviewer_total_score = 0;
            $data['overall_rating'] = array(
                'pms_employee_id' => $apraisee_employee_id,
                'apraiser_employee_id' => $apraiser_employee_id,
                'reviewer_employee_id' => $reviewer_employee_id,
                'time_period_id' => $time_period_id,
                'reviewer_score' => $reviewer_total_score,
                'date_created' => date('Y-m-d'),
                'ip_address' => $this->input->ip_address()
            );

            //Bug 8

            $result_overall_rating = $this->reviewermodel->addReviewerOverallRating($data['overall_rating']);

            //TODO: Fix - for I agree copy all appraisers rating as  reviewer rating
            $this->reviewermodel->copyOverallRatingIAgree($apraisee_employee_id, $reviewer_employee_id, $time_period_id);

            $response['msg'] = 'Appraisee Assessment Submitted Successfully';
        }
        die(json_encode($response));
    }

    /** Supporting functions * */
    public function display_reviewer_competencies($apraisee_employee_id = '', $grade_id = '') {
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
        //print_r($comp_for_ref);
        //echo '</pre>';


        $reviewer_id = $this->session->userdata('pms_employee_id');
        $output = '';
        $output .= '<table class="table table-bordered">';

        $output .= '<thead>';
        $output .= '<tr>';
        $output .= '<th>Competencies</th>';
        $output .= '<th>Weightage</th>';
        //Display cols for multiple apraiser
        /**
          foreach ($query_m->result() as $ckey => $cval) {
          $output .= '<th> ' . $cval->fname . ' ' . $cval->lname . '</th>';
          }
         * 
         */
        $output .= '<th>Scale</th>';

        $output .= '<th>Reviewer Score</th>';
        $output .= '</tr>';
        $output .= '</thead>';



        $total_avg = 0;
        $total_rev_score = 0;
        $total_weightage = 0;
        $output .= '<tbody>';
        $new_score = array();
        foreach ($comp_for_ref as $key => $val) {
            $new_score[$key] = $val;

            //echo '<pre>';
            //print_r($val);
            //echo '</pre>';
            //TODO Fixed - AJAY

            $output .= '<tr>';
            $output .= '<td>' . trim($val['competencies_name']) . '</td>';
            $output .= '<td>' . $val['weightage_value'] . '%</td>';

            //Calculate Weightage
            $total_weightage = $total_weightage + $val['weightage_value'];

            //Add total weightage
            $comp_for_ref['weightage_value'] = $total_weightage;

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

            //Added to Array
            $new_score[$key]['my_total_scale'] = $my_scale;
            $new_score[$key]['my_total_average'] = $my_average;


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
            //Added to Array
            $new_score[$key]['scale'] = $scale;
            $new_score[$key]['total_score'] = $myscore;
        }

        //echo '<pre>';
        //print_r($new_score);
        //echo '</pre>';
        //Display Total
        $output .= '<tr>';
        $output .= '<td style="text-align:right; font-weight:bold;">Total</td>';
        $output .= '<td>' . $total_weightage . '%&nbsp;</td>';
        //Display cols for multiple apraiser
        /**
          foreach ($query_m->result() as $ckey => $cval) {
          $output .= '<td>&nbsp;</td>';
          }
         * 
         */
        //$output .= '<td style="text-align:right; font-weight:bold;">' . number_format($total_avg, 2, '.', '') . '</td>';
        $output .= '<td style="text-align:right; font-weight:bold;">&nbsp;</td>';

        $output .= '<td style="text-align:right; font-weight:bold;">' . number_format($total_rev_score, 2, '.', '') . '</td>';
        $output .= '</tr>';
        $output .= '</tbody>';



        $output .= '</table>';
        $this->reviewer_total_score = $total_rev_score;

        //return $output;
        //change output to array
        return $new_score;
    }

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

    public function old_display_reviewer_competencies($apraisee_employee_id = '', $grade_id = '') {
        //echo '<br>Employee Id ' . $apraisee_employee_id . ' Grade: ' . $grade_id ;
        $output = '';
        $time_period_id = 1;
        //Get all List of competencies
        /**
          $sql = "SELECT * FROM " . $this->db->dbprefix . "competencies_for_refrence cr
          LEFT JOIN " . $this->db->dbprefix . "weightage w ON w.weightage_id = cr.weightage_id
          ";
          $query = $this->db->query($sql);
         * */
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

        /**
         * (
          [competencies_for_refrence_id] => 1
          [competencies_name] => Technical & domain Knowledge
          [competencies_decription] =>  	Positive time management, Project management, Core tools of TS16949 &
          [weightage_id] => 1
          [date_created] => 2013-04-08 00:00:00
          [competencies_status] => 1
          [weightage_value] => 10
          [weightage_status] => 1
          )
         * 
         *  
         */
        $reviewer_id = $this->session->userdata('pms_employee_id');
        $output = '';
        $output .= '<table class="table table-bordered">';

        $output .= '<thead>';
        $output .= '<tr>';
        $output .= '<th>Competencies</th>';
        $output .= '<th>Weightage</th>';
        //Display cols for multiple apraiser
        foreach ($query_m->result() as $ckey => $cval) {
            $output .= '<th> ' . $cval->fname . ' ' . $cval->lname . '</th>';
        }
        $output .= '<th>Average</th>';

        $output .= '<th>Reviewer</th>';
        $output .= '</tr>';
        $output .= '</thead>';



        $total_avg = 0;
        $total_rev_score = 0;
        $output .= '<tbody>';
        foreach ($comp_for_ref as $key => $val) {

            $output .= '<tr>';
            $output .= '<td>' . trim($val['competencies_name']) . '</td>';
            $output .= '<td>' . $val['weightage_value'] . '</td>';
            //Display cols for multiple apraiser
            $my_average = 0;
            foreach ($query_m->result() as $ckey => $cval) {
                $get_scale_info = $this->getCompetenciesDetails($val['competencies_for_refrence_id'], $cval->apraiser_employee_id, $apraisee_employee_id, $time_period_id);
                $myscore = number_format((( $val['weightage_value'] * $get_scale_info->scale ) / 100), 2, '.', '');
                $my_average = $my_average + $myscore;
                $output .= '<td style="text-align:right">' . $get_scale_info->scale . ' | ' . $myscore . '</td>';
            }

            //Display Average
            //Calculate Average 
            $my_average = number_format(( $my_average / count($query_m->result())), 2, '.', '');

            //Add to Total
            $total_avg = $total_avg + $my_average;
            $output .= '<td style="text-align:right">' . $my_average . '</td>';

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

            $output .= '<td style="text-align:right">' . $scale . ' | ' . $myscore . '</td>';
            $output .= '</tr>';

            //Get Individual Details
        }

        //Display Total
        $output .= '<tr>';
        $output .= '<td>Total</td>';
        $output .= '<td>&nbsp;</td>';
        //Display cols for multiple apraiser
        foreach ($query_m->result() as $ckey => $cval) {
            $output .= '<td>&nbsp;</td>';
        }
        $output .= '<td style="text-align:right; font-weight:bold;">' . number_format($total_avg, 2, '.', '') . '</td>';

        $output .= '<td style="text-align:right; font-weight:bold;">' . number_format($total_rev_score, 2, '.', '') . '</td>';
        $output .= '</tr>';
        $output .= '</tbody>';



        $output .= '</table>';

        return $output;
    }

    //TODO: Fixed - Remove Duplicate
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
        $output['overall_total'] = number_format($overall_kra_score + $overall_competency_score, 2, '.', '');

        return $output;
    }

}