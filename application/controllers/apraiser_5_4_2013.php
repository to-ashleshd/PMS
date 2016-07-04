<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Apraiser extends CI_Controller {

    function __construct() {
        parent::__construct();
        //  $this->dashboard();
        $this->topmenu->no_cache();
        $this->load->model('generalesettings');
        $this->load->model('employeemodel');
        $this->load->model('commonmodel');
        $this->load->model('companymodel');
        $this->load->model('apraiseemodel');
        $this->load->model('apraisermodel');
        $this->load->model('reviewermodel');
        $this->load->model('taskschedulemodel');
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
            $status = '1';
            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');
            $data['reviewer_employees'] = $this->reviewermodel->getEmployeeApriseelist($pms_employee_id, '1');
            $data['approvel_employees'] = $this->apraisermodel->get_kra_approvel_appraisee_list($pms_employee_id, '1');

            //echo '<pre>';
            //print_r($data['approvel_employees']);
            //echo '</pre>';

            $employee_ids = $this->apraisermodel->getEmplyeeIdsByApraiserID($pms_employee_id, '1');
            //print_r($employee_ids);

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
            $this->load->view('default/clientadmin/cadmin_apraiser_employee_list', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
        //}
    }

    function apraiseeassessment($apraisee_employee_id = '') {
        $data = array();
        $time_period_id = '1';
        $immediate_year_detail = $this->commonmodel->get_immediate_previous_year();
        if (!empty($immediate_year_detail)) {
            $time_period_id = $immediate_year_detail['time_period_id'];
        }
        //echo$time_period_id;die();
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        $data['departments'] = $this->companymodel->getDepartments();
        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
        $data['apraisee_employee_id'] = '';
        $data['employee_name'] = '';
        $data['display_overall_rating'] = 'N';
        if ($apraisee_employee_id == '') {
            redirect('accessdenied', 'refresh');
        }

        if ($this->session->userdata('pms_employee_id')) {
            $pms_employee_id = $this->session->userdata('pms_employee_id');

            //echo '<br>Get common Score: ';
            $data['overall_rating_scores'] = $this->geOverallRatingForApraisee($apraisee_employee_id);
            $data['overall_apraiser_assessment_score'] = $this->reviewermodel->getScoreNameByScore($data['overall_rating_scores']['overall_total']);

            $data['final_score'] = '';
            $data['final_score_cwi'] = '';
            $data['overall_kra_score'] = '';
            $data['overall_competencies_score'] = '';
            $data['overall_performance_score'] = '';
            $data['apraiser_assessment_score'] = '';

            $data['top_employee_detail'] = $this->employeemodel->getEmployeeDetailsById($apraisee_employee_id, $time_period_id);
            //$data['top_employee_apraiser_detail'] = $this->employeemodel->getEmployeeApraiserAndReviewer($apraisee_employee_id, $time_period_id);
            $top_employee_apraiser_detail = $this->employeemodel->getEmployeeApraiserAndReviewer($apraisee_employee_id, $time_period_id);
            $top_detail_apraiser = '';
            $top_detail_reviewer = '';
            if(!empty($top_employee_apraiser_detail))
                {
                        foreach($top_employee_apraiser_detail as $key_topemp=>$val_topemp)
                        {
                                if($top_detail_apraiser=='')
                                {
                                    $top_detail_apraiser = '[ <strong>'.$val_topemp['apraiser_name'].' </strong><em>'.$val_topemp['apraiser_designation'].'</em> ]';
                                }
                                else
                                {
                                    $top_detail_apraiser .= ', [ <strong>'.$val_topemp['apraiser_name'].'</strong><em> '.$val_topemp['apraiser_designation'].'</em> ]';
                                }
                                $top_detail_reviewer = '[ <strong>'.$val_topemp['reviewer_name'].'</strong><em> '.$val_topemp['reviewer_designation'].'</em> ]';
                        }
                }
                $data['top_employee_apraiser_detail'] = array(
                    'appraiser'           => $top_detail_apraiser,
                    'reviewer'             => $top_detail_reviewer
                );
            
            if (empty($data['top_employee_detail'])) {
                redirect('accessdenied', 'refresh');
            }
            if ($apraisee_employee_id != '') {
                $apraiser_employee_id = $pms_employee_id;

                if ($pms_employee_id == '1') {
                   // $apraisee_relationship_details = $this->apraiseemodel->getRelationshipDetailOfEmployee($apraisee_employee_id, $time_period_id);
                    $apraisee_relationship_details = $this->apraiseemodel->getRelationshipStatus($apraisee_employee_id, $pms_employee_id, $time_period_id);
                    $apraisee_relationship_detail = $apraisee_relationship_details;
                    //$apraisee_relationship_details[0];

                    $employee_detail = $this->employeemodel->getEmployeeById($apraisee_employee_id);
                    if ($apraisee_relationship_detail['submit_status'] >= '6') {
                        //$data['submit_status'] = $apraisee_relationship_detail['submit_status'];
                        $apraiser_employee_id = $apraisee_relationship_detail['apraiser_employee_id'];
                        $data['employee_name'] = $employee_detail->fname . ' ' . $employee_detail->lname;
                        $data['apraiser_kra_detail'] = $this->apraisermodel->getApraiserKraPmsDetail($apraisee_employee_id, $apraiser_employee_id);
                        if (!empty($data['apraiser_kra_detail'])) {
                            foreach ($data['apraiser_kra_detail'] as $keyd => $vald) {
                                if ($data['final_score'] == '') {
                                    $data['final_score'] = ($vald['total_score']);
                                } else {
                                    $data['final_score'] += ($vald['total_score']);
                                }
                            }
                        }

                        $data['overall_kra_score'] = number_format((($data['final_score'] * 70 ) / 100), 2, '.', '');
                        $data['competency_with_idp_detail'] = $this->apraisermodel->getEmployeeCompetenciesWithIdp($apraisee_employee_id, $apraiser_employee_id);



                        foreach ($data['competency_with_idp_detail'] as $keycwi => $valcwi) {
                            if ($data['final_score_cwi'] == '') {
                                $data['final_score_cwi'] = ($valcwi['total_score']);
                            } else {
                                $data['final_score_cwi'] += ($valcwi['total_score']);
                            }
                        }
                        $data['technical_detail'] = $this->apraisermodel->getEmployeeTechnicalDetail($apraisee_employee_id, $apraiser_employee_id);
                        $data['behavioural_detail'] = $this->apraisermodel->getEmployeeBehaviouralDetail($apraisee_employee_id, $apraiser_employee_id);
                        $data['overall_kra_score'] = number_format((($data['final_score'] * 70 ) / 100), 2, '.', '');
                        $data['overall_competencies_score'] = number_format((($data['final_score_cwi'] * 30 ) / 100), 2, '.', '');
                        $data['overall_performance_score'] = number_format((($data['overall_kra_score']) + ($data['overall_competencies_score'])), 2, '.', '');
                        $data['apraiser_assessment_score'] = $this->reviewermodel->getScoreNameByScore($data['overall_performance_score']);
                        $data['overall_rating_detail'] = $this->apraisermodel->getOverallRatingDetail($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
                    }
                } else {
                    $apraisee_relationship_detail = $this->apraisermodel->getRelationshipStatus($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
                    //echo '<pre>';
                    //print_r($apraisee_relationship_detail);
                    //print_r($apraiser_employee_id);
                    //echo '</pre>';
                    $employee_detail = $this->employeemodel->getEmployeeById($apraisee_employee_id);
                    
                    $first_apraiser_info = $this->apraisermodel->get_first_appraiser($apraisee_employee_id,$time_period_id);
                    $id_pms_process_complete = $this->apraisermodel->check_is_all_appraiser_fillup_pms($apraisee_employee_id,$first_apraiser_info['apraiser_employee_id'],$time_period_id);
                    $data['is_pms_process_complete'] = $id_pms_process_complete;
                    $data['is_first_appraiser']      = '';
                    $data['is_pms_process_finish']   =  $this->apraisermodel->check_is_appraiser_pms_process_complete($apraisee_employee_id,$time_period_id);
                   // echo $data['is_pms_process_finish'];die();
                    if(!empty($first_apraiser_info))
                            {
                                if(($first_apraiser_info['apraiser_employee_id'] == $this->session->userdata('pms_employee_id')))
                                {
                                    $data['is_first_appraiser']         = 'Y';
                                }
                                if(($first_apraiser_info['apraiser_employee_id'] == $this->session->userdata('pms_employee_id')) && ($id_pms_process_complete=='Y') )
                                {
                                    $data['display_overall_rating']     = 'Y';
                                }
                            }
                    if (!empty($apraisee_relationship_detail) && $apraisee_relationship_detail['submit_status'] == '3') {
                        $data['kra_detail'] = $this->apraisermodel->getApraiseeKraPmsDetail($apraisee_employee_id, $time_period_id);

                        $data['employee_name'] = $employee_detail->fname . ' ' . $employee_detail->lname;
                        //echo 'status 3' ;
                    } elseif (!empty($apraisee_relationship_detail) && $apraisee_relationship_detail['submit_status'] > '3') {
                        //echo 'status 3> ';
                        //Fixed for multiple apriser
                        $data['kra_detail'] = $this->apraisermodel->getApraiseeKraPmsDetail($apraisee_employee_id, $time_period_id);


                        $data['apraiser_kra_detail'] = $this->apraisermodel->getApraiserKraPmsDetail($apraisee_employee_id, $pms_employee_id);
                        //Get Final Score
                        //echo '<pre>';
                        //print_r($data['apraiser_kra_detail']);
                        //echo '</pre>';

                        if (!empty($data['apraiser_kra_detail'])) {
                            foreach ($data['apraiser_kra_detail'] as $keyd => $vald) {
                                if ($data['final_score'] == '') {
                                    $data['final_score'] = ($vald['total_score']);
                                } else {
                                    $data['final_score'] += ($vald['total_score']);
                                }
                            }

                            //Remove kra details
                            $data['kra_detail'] = array();
                        }

                        $data['overall_kra_score'] = number_format((($data['final_score'] * 70 ) / 100), 2, '.', '');
                        $employee_detail = $this->employeemodel->getEmployeeById($apraisee_employee_id);
                        $data['employee_name'] = $employee_detail->fname . ' ' . $employee_detail->lname;


                        //echo 'Status ' . $apraisee_relationship_detail['submit_status'] ;
                        //$compentency = $this->apraisermodel->getEmployeeCompetenciesWithIdp($apraisee_employee_id, $apraiser_employee_id);



                        if ($apraisee_relationship_detail['submit_status'] >= '5' && !empty($data['apraiser_kra_detail'])) {
                            $data['competency_with_idp_detail'] = $this->apraisermodel->getEmployeeCompetenciesWithIdp($apraisee_employee_id, $apraiser_employee_id);

                            foreach ($data['competency_with_idp_detail'] as $keycwi => $valcwi) {
                                if ($data['final_score_cwi'] == '') {
                                    $data['final_score_cwi'] = ($valcwi['total_score']);
                                } else {
                                    $data['final_score_cwi'] += ($valcwi['total_score']);
                                }
                            }
                            $data['technical_detail'] = $this->apraisermodel->getEmployeeTechnicalDetail($apraisee_employee_id, $apraiser_employee_id);
                            $data['behavioural_detail'] = $this->apraisermodel->getEmployeeBehaviouralDetail($apraisee_employee_id, $apraiser_employee_id);
                            $data['overall_kra_score'] = number_format((($data['final_score'] * 70 ) / 100), 2, '.', '');
                            $data['overall_competencies_score'] = number_format((($data['final_score_cwi'] * 30 ) / 100), 2, '.', '');
                            $data['overall_performance_score'] = number_format((($data['overall_kra_score']) + ($data['overall_competencies_score'])), 2, '.', '');
                            // echo $data['overall_performance_score'];die();
                            $data['apraiser_assessment_score'] = $this->reviewermodel->getScoreNameByScore($data['overall_performance_score']);
//                            if ($data['overall_performance_score'] < 2) {
//                                $data['apraiser_assessment_score'] = 'BE';
//                            } elseif ($data['overall_performance_score'] > 2 && $data['overall_performance_score'] < 2.79) {
//                                $data['apraiser_assessment_score'] = 'NI';
//                            } elseif ($data['overall_performance_score'] > 2.80 && $data['overall_performance_score'] < 3.49) {
//                                $data['apraiser_assessment_score'] = 'ME';
//                            } elseif ($data['overall_performance_score'] > 3.50 && $data['overall_performance_score'] < 4.24) {
//                                $data['apraiser_assessment_score'] = 'EE';
//                            } elseif ($data['overall_performance_score'] > 4.25 && $data['overall_performance_score'] < 5.00) {
//                                $data['apraiser_assessment_score'] = 'FEE';
//                            }
                           
                            
                        } elseif ($apraisee_relationship_detail['submit_status'] >= '5') {
                            $data['error'] = 'Please Fill Up Apraiser Kra form First';
                        }

                        if ($apraisee_relationship_detail['submit_status'] >= '6' && !empty($data['competency_with_idp_detail'])) {
                           
                            $data['overall_rating_detail'] = $this->apraisermodel->getOverallRatingDetail($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
                        } elseif ($apraisee_relationship_detail['submit_status'] >= '6') {
                            $data['error'] = 'Please Fill Up Competencies With IDp  First';
                        }
                    } elseif (!empty($apraisee_relationship_detail) && $apraisee_relationship_detail['submit_status'] < '3') {
                        $data['errormsg'] = 'Awaiting for Apraisee Response.';
                    } else {
                        //$data['error']      = 'Page Not Found';
                        redirect('accessdenied', 'refresh');
                    }
                }
            } else {
                //$data['error']      = 'Page not found';
                redirect('accessdenied', 'refresh');
            }

            //die();
            //print_r($employee_detail);


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
            $this->load->view('default/clientadmin/cadmin_apriser', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function addkradata() {
        $data = array();

        //die();
        if ($this->session->userdata('pms_employee_id')) {



            $rating = array();
            $comment = array();
            $pms_id = '';

            if (!empty($_POST)) {

                foreach ($_POST as $key => $val) {

                    $pms_id_detail = explode('_', $key);
                    $pms_id = $pms_id_detail[1];
                    if ($pms_id_detail[0] == 'rating') {
                        $rating[$pms_id] = $val;
                    } else {
                        $comment[$pms_id] = $val;
                    }
                }

                $employee_relationship_materix_id = '';
                foreach ($rating as $key => $val) {

                    $pms_id = $key;
                    $pms_detail = $this->apraiseemodel->getApraiseePmsById($pms_id);
                    $comment_desc = '';
                    $employee_relationship_materix_id = $pms_detail['employee_relationship_materix_id'];
                    //$employee_relationship_materix_ids = array();
                    if (array_key_exists($pms_id, $comment)) {
                        $comment_desc = $comment[$pms_id];
                    }

                    $data[] = array(
                        'apraiser_employee_id' => $this->session->userdata('pms_employee_id'),
                        'apraisee_employee_id' => $pms_detail['pms_employee_id'],
                        'time_period_id' => $pms_detail['time_period_id'],
                        'apraisee_pms_id' => $pms_id,
                        'apraiser_rating_id' => $val,
                        'apraiser_comment' => ucfirst($comment_desc),
                    );
                }

                $result = $this->apraisermodel->addApraiseeKraByApraiser($data);

                //update relationship materix status
                //second parameter 3 is submit status
                //$this->apraiseemodel->UpdateRelationshipStatus($employee_relationship_materix_id, '4');
                //Update Status 
                $sql = "UPDATE " . $this->db->dbprefix . "employee_relationship_materix 
                        SET submit_status = '4' 
                        WHERE pms_employee_id = '" . $_POST['appraisee_employee_id'] . "' 
                        and time_period_id = '" . $pms_detail['time_period_id'] . "'
                        and apraiser_employee_id = '" . $this->session->userdata('pms_employee_id') . "' ";
                //echo $sql ;
                $this->db->query($sql);

                if ($result) {
                    echo "Apraisee Kra Submitted Successfully";
                } else {
                    echo "Please try again";
                }
            }
        }
    }

    function getApraiserKradetail() {

        $response = array();
        $apraisee_employee_id = $this->input->post('apraisee_employee_id', true);
        $apraiser_employee_id = $this->input->post('pms_employee_id', true);

        $response['kra_detail'] = $this->apraisermodel->getApraiserKraPmsDetail($apraisee_employee_id, $apraiser_employee_id);

        $final_score = 0;
        if (!empty($response['kra_detail'])) {
            foreach ($response['kra_detail'] as $key => $val) {
                if ($final_score == 0) {
                    $final_score = ((($val['weightage_name']) * ($val['apraiser_rating_value'])) / 100);
                } else {
                    $final_score += ((($val['weightage_name']) * ($val['apraiser_rating_value'])) / 100);
                }
            }
        }

        $response['final_score'] = number_format($final_score, 2, '.', '');
        die(json_encode($response));
    }

    function addcompetencywithidp() {
        $data = array();

        if ($this->session->userdata('pms_employee_id')) {
            $is_overall_rating = '';
            $time_period_id = '1';
              $is_first_appraiser='';
            $apraiser_employee_id = $this->session->userdata('pms_employee_id');
            $employee_relationship_materix_id = '';
            
            
           
            if (!empty($_POST)) {
                $result = '';
                $result_technical = '';
                $result_behavioural = '';
                $apraisee_employee_id = $this->input->post('appraisee_employee_id', true);
                $employee_relationship_materix_id = '0';
                $employee_relationship_materix_detail = $this->apraiseemodel->getRelationshipByids($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
              
                if (!empty($employee_relationship_materix_detail)) {
                    $employee_relationship_materix_id = $employee_relationship_materix_detail['employee_relationship_materix_id'];
                }


                foreach ($_POST as $key => $val) {

                    if ($key != 'idpE_item' && $key != 'appraisee_employee_id' && $key != 'invE_item') {
                        $com_ref_id_detail = explode('_', $key);
                        if ($com_ref_id_detail[0] == 'rate') {
                            $competencies_for_refrence_id = $com_ref_id_detail[1];
                            $data['competency_with_idp'] = array(
                                'pms_employee_id' => $apraisee_employee_id,
                                'apraiser_employee_id' => $apraiser_employee_id,
                                'time_period_id' => $time_period_id,
                                'competencies_for_refrence_id' => $competencies_for_refrence_id,
                                'scale' => $val
                            );
                            $result = $this->apraisermodel->addCompetencyOFApraisee($data['competency_with_idp']);
                        }
                    }

                    if ($key == 'idpE_item') {
                        foreach ($val as$keyt => $valt) {
                            $valt = trim($valt);
                            $data['competency_technical'] = array(
                                'pms_employee_id' => $apraisee_employee_id,
                                'apraiser_employee_id' => $apraiser_employee_id,
                                'time_period_id' => $time_period_id,
                                'technical_area' => ucfirst($valt),
                                'technical_status' => '1'
                            );

                            $result_technical = $this->apraisermodel->addCompetencyTechnicalOFApraisee($data['competency_technical']);
                        }
                    }

                    if ($key == 'invE_item') {
                        foreach ($val as$keyb => $valb) {
                            $valb = trim($valb);
                            $data['competency_behavioural'] = array(
                                'pms_employee_id' => $apraisee_employee_id,
                                'apraiser_employee_id' => $apraiser_employee_id,
                                'time_period_id' => $time_period_id,
                                'behavioural_area' => ucfirst($valb),
                                'behaviourl_status' => '1'
                            );
                            $result_behavioural = $this->apraisermodel->addCompetencyBehaviouralOFApraisee($data['competency_behavioural']);
                        }
                    }
                }

                 $first_apraiser_info = $this->apraisermodel->get_first_appraiser($apraisee_employee_id,$time_period_id);
                 //$id_pms_process_complete = $this->apraisermodel->check_is_all_appraiser_fillup_pms($apraisee_employee_id,$first_apraiser_info['apraiser_employee_id'],$time_period_id);
                
                 if(!empty($first_apraiser_info))
                            {
                                if(($first_apraiser_info['apraiser_employee_id'] == $this->session->userdata('pms_employee_id')))
                                {
                                    $is_first_appraiser     = 'Y';
                                }
                            }

                if ($result == 1 && $result_technical == 1 && $result_behavioural == 1) {
                    $update_status= '5';
                    
                    if($is_first_appraiser!='Y')
                    {
                        $apraiser_kra_score = $this->reviewermodel->getApraiserTotalKraScore($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
                        $apraiser_competency_score = $this->reviewermodel->getApraiserTotalCompetenciesScore($apraisee_employee_id, $apraiser_employee_id, $time_period_id);


                         $overall_performance_score = (($apraiser_kra_score) + ($apraiser_competency_score));
                         $overall_rating_data = array(
                            'pms_employee_id' => $apraisee_employee_id,
                            'apraiser_employee_id' => $apraiser_employee_id,
                            'time_period_id' => $time_period_id,
                            'apraiser_score' => $overall_performance_score,
                            'comment'        => '',
                            'feedback'       => '',
                            'promotion_recommendation' => '',
                            'date_created'    => date('Y-m-d'),
                            'ip_address'     => $this->input->ip_address()
                        );

                        $result = $this->apraisermodel->addApraiserOverallRating($overall_rating_data);
                        $update_status = '6';
                    }
                    $this->apraiseemodel->UpdateRelationshipStatus($employee_relationship_materix_id, $update_status);
                    
                    echo "Competencies with IDP Submitted Successfully";
                } else {
                    echo "Please try again";
                }
            }
        }//main if close
    }

    function getApraiserCompetenciesDetail() {
        $response = array();
        $response['final_score_cwi'] = '';
        
        //immediate previous year
        $time_period_id = '1';
        $response['display_overall_rating'] = 'N';
        $apraisee_employee_id = $this->input->post('apraisee_employee_id', true);
        $apraiser_employee_id = $this->input->post('pms_employee_id', true);

        $response['competency_with_idp_detail'] = $this->apraisermodel->getEmployeeCompetenciesWithIdp($apraisee_employee_id, $apraiser_employee_id);

        foreach ($response['competency_with_idp_detail'] as $keycwi => $valcwi) {
            if ($response['final_score_cwi'] == '') {
                $response['final_score_cwi'] = ($valcwi['total_score']);
            } else {
                $response['final_score_cwi'] += ($valcwi['total_score']);
            }
        }
        $response['technical_detail'] = $this->apraisermodel->getEmployeeTechnicalDetail($apraisee_employee_id, $apraiser_employee_id);
        $response['behavioural_detail'] = $this->apraisermodel->getEmployeeBehaviouralDetail($apraisee_employee_id, $apraiser_employee_id);


        $response['kra_detail'] = $this->apraisermodel->getApraiserKraPmsDetail($apraisee_employee_id, $apraiser_employee_id);

        $final_score = 0;
        $response['final_score'] = '0';
        if (!empty($response['kra_detail'])) {
            foreach ($response['kra_detail'] as $key => $val) {
                if ($final_score == 0) {
                    $final_score = ((($val['weightage_name']) * ($val['apraiser_rating_value'])) / 100);
                } else {
                    $final_score += ((($val['weightage_name']) * ($val['apraiser_rating_value'])) / 100);
                }
            }
            $response['final_score'] = number_format($final_score, 2, '.', '');
        }

        
        
      //  echo $id_pms_process_complete;die();
         $first_apraiser_info = $this->apraisermodel->get_first_appraiser($apraisee_employee_id,$time_period_id);
         $id_pms_process_complete = $this->apraisermodel->check_is_all_appraiser_fillup_pms($apraisee_employee_id,$first_apraiser_info['apraiser_employee_id'],$time_period_id);
         $response['is_pms_process_complete'] = $id_pms_process_complete;
         $response['is_first_appraiser'] ='';
          $response['is_pms_process_finish']   =  $this->apraisermodel->check_is_appraiser_pms_process_complete($apraisee_employee_id,$time_period_id);
         if(!empty($first_apraiser_info))
                {
                     if(($first_apraiser_info['apraiser_employee_id'] == $this->session->userdata('pms_employee_id')))
                     {
                        $response['is_first_appraiser']     = 'Y';
                     }
                    if(($first_apraiser_info['apraiser_employee_id'] == $this->session->userdata('pms_employee_id')) && ($id_pms_process_complete=='Y') )
                    {
                        $response['display_overall_rating'] = 'Y';
                    }
                }


        $response['overall_kra_score'] = number_format((($response['final_score'] * 70 ) / 100), 2, '.', '');
        $response['overall_competencies_score'] = number_format((($response['final_score_cwi'] * 30 ) / 100), 2, '.', '');

        $response['overall_performance_score'] = number_format((($response['overall_kra_score']) + ($response['overall_competencies_score'])), 2, '.', '');
//        if ($response['overall_performance_score'] < 2) {
//            $response['apraiser_assessment_score'] = 'BE';
//        } elseif ($response['overall_performance_score'] > 2 && $response['overall_performance_score'] < 2.79) {
//            $response['apraiser_assessment_score'] = 'NI';
//        } elseif ($response['overall_performance_score'] > 2.80 && $response['overall_performance_score'] < 3.49) {
//            $response['apraiser_assessment_score'] = 'ME';
//        } elseif ($response['overall_performance_score'] > 3.50 && $response['overall_performance_score'] < 4.24) {
//            $response['apraiser_assessment_score'] = 'EE';
//        } elseif ($response['overall_performance_score'] > 4.25 && $response['overall_performance_score'] < 5.00) {
//            $response['apraiser_assessment_score'] = 'FEE';
//        }
        
        $response['apraiser_assessment_score'] = $this->reviewermodel->getScoreNameByScore($response['overall_performance_score']);

        die(json_encode($response));
    }

    function addoverallratingdata() {
        $data = array();

        if ($this->session->userdata('pms_employee_id')) {
            $time_period_id = '1';
            $apraiser_employee_id = $this->session->userdata('pms_employee_id');

            $employee_relationship_materix_id = '';

            if (!empty($_POST)) {
                $result = '';
                $apraisee_employee_id = $this->input->post('appraisee_employee_id', true);
                $employee_relationship_materix_id = '0';
                $employee_relationship_materix_detail = $this->apraiseemodel->getRelationshipByids($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
                if (!empty($employee_relationship_materix_detail)) {
                    $employee_relationship_materix_id = $employee_relationship_materix_detail['employee_relationship_materix_id'];
                }

                $apraiser_kra_score = $this->reviewermodel->getApraiserTotalKraScore($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
                $apraiser_competency_score = $this->reviewermodel->getApraiserTotalCompetenciesScore($apraisee_employee_id, $apraiser_employee_id, $time_period_id);


                $overall_performance_score = (($apraiser_kra_score) + ($apraiser_competency_score));
                //$overall_performance_score          = $this->input->post('hidden_over_perf_score',true);
                $overall_rating_comment = $this->input->post('overall_rating_comment', true);
                $apraiser_feedback = $this->input->post('apraiser_feedback', true);
                $appraiser_promotion_recommendation = $this->input->post('appraiser_promotion_recommendation', true);

                $overall_rating_comment = trim($overall_rating_comment);
                $apraiser_feedback = trim($apraiser_feedback);
                $appraiser_promotion_recommendation = trim($appraiser_promotion_recommendation);

                $data = array(
                    'pms_employee_id' => $apraisee_employee_id,
                    'apraiser_employee_id' => $apraiser_employee_id,
                    'time_period_id' => $time_period_id,
                    'apraiser_score' => $overall_performance_score,
                    'comment' => ucfirst($overall_rating_comment),
                    'feedback' => ucfirst($apraiser_feedback),
                    'promotion_recommendation' => ucfirst($appraiser_promotion_recommendation),
                    'date_created' => date('Y-m-d'),
                    'ip_address' => $this->input->ip_address()
                );

                $result = $this->apraisermodel->addApraiserOverallRating($data);
                if ($result == 1) {
                    $this->apraiseemodel->UpdateRelationshipStatus($employee_relationship_materix_id, '6');
                    echo "Overall Rating Submitted Successfully.";
                } else {
                    echo "Please try again";
                }
            }
        }
    }

    function getapraiseroverallratingdetail() {
        $response = array();
        $time_period_id = '1';
        $apraisee_employee_id = $this->input->post('apraisee_employee_id', true);
        $apraiser_employee_id = $this->input->post('pms_employee_id', true);
        $response['overall_rating_detail'] = $this->apraisermodel->getOverallRatingDetail($apraisee_employee_id, $apraiser_employee_id, $time_period_id);

        die(json_encode($response));
    }

    function getApraiserKraPmsById($apraiser_kra_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'apraiser_kra');
        $this->db->where('apraiser_kra_id', $apraiser_kra_id);
        $query = $this->db->get();
        $row = $query->first_row('array');
        return $row;
    }

    function approvekra($apraisee_employee_id, $time_period_id) {
        $data = array();
        // $time_period_id                 = $this->input->post('time_period_id');

        $time_period_detail = $this->commonmodel->get_current_year();
        if (!empty($time_period_detail)) {
            $current_time_period_id = $time_period_detail['time_period_id'];
        }

//        if($time_period_id!=$current_time_period_id)
//        {
//             redirect('accessdenied','refresh');
//        }
        // echo "hi";die();
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        $data['departments'] = $this->companymodel->getDepartments();
        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
        $data['apraisee_employee_id'] = '';
        $data['employee_name'] = '';
        //echo $apraisee_employee_id;
        // echo $time_period_id;
        $data['apraisee_employee_id'] = '';
        $data['time_period_id'] = '';
        $data['employee_relationship_matetix_id'] = '';
        // echo $apraisee_employee_id;echo $time_period_id;
        if ($apraisee_employee_id == '' || $time_period_id == '') {
            redirect('accessdenied', 'refresh');
        }
        if ($this->session->userdata('pms_employee_id')) {

            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['top_employee_detail'] = $this->employeemodel->getEmployeeDetailsById($apraisee_employee_id, $time_period_id);
            //$data['top_employee_apraiser_detail'] = $this->employeemodel->getEmployeeApraiserAndReviewer($apraisee_employee_id, $time_period_id);
            $top_employee_apraiser_detail = $this->employeemodel->getEmployeeApraiserAndReviewer($apraisee_employee_id, $time_period_id);
            $top_detail_apraiser = '';
            $top_detail_reviewer = '';
            if(!empty($top_employee_apraiser_detail))
                {
                        foreach($top_employee_apraiser_detail as $key_topemp=>$val_topemp)
                        {
                                if($top_detail_apraiser=='')
                                {
                                    $top_detail_apraiser = '[ <strong>'.$val_topemp['apraiser_name'].' </strong><em>'.$val_topemp['apraiser_designation'].'</em> ]';
                                }
                                else
                                {
                                    $top_detail_apraiser .= ', [ <strong>'.$val_topemp['apraiser_name'].'</strong><em> '.$val_topemp['apraiser_designation'].'</em> ]';
                                }
                                $top_detail_reviewer = '[ <strong>'.$val_topemp['reviewer_name'].'</strong><em> '.$val_topemp['reviewer_designation'].'</em> ]';
                        }
                }
                $data['top_employee_apraiser_detail'] = array(
                    'appraiser'           => $top_detail_apraiser,
                    'reviewer'             => $top_detail_reviewer
                );
 
            if (empty($data['top_employee_detail'])) {
                redirect('accessdenied', 'refresh');
            }
            if (empty($data['top_employee_detail'])) {
                redirect('accessdenied', 'refresh');
            }

            if ($apraisee_employee_id != '') {

                $apraiser_employee_id = $pms_employee_id;
                $data['apraisee_employee_id'] = $apraisee_employee_id;
                $data['time_period_id'] = $time_period_id;


                $apraisee_relationship_detail = $this->apraisermodel->getRelationshipStatus($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
                $employee_detail = $this->employeemodel->getEmployeeById($apraisee_employee_id);

                if (!empty($apraisee_relationship_detail) && $apraisee_relationship_detail['submit_status'] <= '0.2') {
                    $data['kra_detail'] = $this->apraiseemodel->get_kra_by_id($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
                    $data['employee_name'] = $employee_detail->fname . ' ' . $employee_detail->lname;
                    $data['employee_relationship_matetix_id'] = $apraisee_relationship_detail['employee_relationship_materix_id'];
                    $data['submit_status'] = $apraisee_relationship_detail['submit_status'];
                    if (!empty($data['kra_detail'])) {
                        $data['total_weight'] = '';
                        foreach ($data['kra_detail'] as $key => $val) {
                            if ($data['total_weight'] == '') {
                                $data['total_weight'] = $val['weightage_value'];
                            } else {
                                $data['total_weight'] += $val['weightage_value'];
                            }
                        }
                    }
                } else if (!empty($apraisee_relationship_detail) && $apraisee_relationship_detail['submit_status'] > '0.2') {
                    $data['kra_detail'] = $this->apraiseemodel->get_kra_by_id($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
                    $data['employee_name'] = $employee_detail->fname . ' ' . $employee_detail->lname;
                    $data['submit_status'] = $apraisee_relationship_detail['submit_status'];
                    if (!empty($data['kra_detail'])) {
                        $data['total_weight'] = '';
                        foreach ($data['kra_detail'] as $key => $val) {
                            if ($data['total_weight'] == '') {
                                $data['total_weight'] = $val['weightage_value'];
                            } else {
                                $data['total_weight'] += $val['weightage_value'];
                            }
                        }
                    }
                } else {
                    redirect('accessdenied', 'refresh');
                }
            } else {
                redirect('accessdenied', 'refresh');
            }

            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            $this->load->view('default/clientadmin/cadmin_view_kra', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function approvedkra() {
        $response = array();
        $time_period_id = $this->input->post('time_period_id');
        $apraisee_employee_id = $this->input->post('apraisee_employee_id', true);
        $employee_relationship_matetix_id = $this->input->post('employee_relationship_matetix_id', true);
        $apraiser_employee_id = $this->session->userdata('pms_employee_id');

        $employee_relationship_materix_detail = $this->apraisermodel->getRelationshipStatus($apraisee_employee_id, $apraiser_employee_id, $time_period_id);

        $emp_rel_mat_id = '';
        if (!empty($employee_relationship_materix_detail)) {
            $emp_rel_mat_id = $employee_relationship_materix_detail['employee_relationship_materix_id'];
            $apraiser_employee_id = $employee_relationship_materix_detail['apraiser_employee_id'];
        }
        if ($emp_rel_mat_id != $employee_relationship_matetix_id) {
            $response['error'] = 'Please Try Agian.';
        } else {
            $this->apraiseemodel->UpdateRelationshipStatus($employee_relationship_matetix_id, '1');
            $data['kra_detail'] = $this->apraiseemodel->get_kra_by_id($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
            $kra_ids = array();
            if (!empty($data['kra_detail'])) {
                foreach ($data['kra_detail'] as $key => $val) {
                    $kra_ids[] = $val['apraisee_kra_id'];
                }
                $this->db->where_in('apraisee_kra_id', $kra_ids);
                $this->db->update($this->db->dbprefix . 'apraisee_kra', array('apraisee_kra_approve_status' => '2', 'approved_kra_by_apraiser_id' => $apraiser_employee_id));
            }

            $employee_relationship_materix_detail_all = $this->apraiseemodel->getRelationshipDetailOfEmployee($apraisee_employee_id, $time_period_id);
            $flag = 0;

            if (!empty($employee_relationship_materix_detail_all)) {
                foreach ($employee_relationship_materix_detail_all as $keyer => $valer) {
                    if ($valer['submit_status'] != '1') {
                        $flag = 1;
                    }
                }
            }
            if ($flag == 0) {
                $this->apraiseemodel->update_track_process($apraisee_employee_id, $time_period_id, '1');
            }
            $response['success'] = "KRA Approved Successfully. ";
        }
        die(json_encode($response));
    }

    function donotapprovkra() {
        $response = array();
        $time_period_id = $this->input->post('time_period_id');
        $apraisee_employee_id = $this->input->post('apraisee_employee_id',true);
        $employee_relationship_matetix_id = $this->input->post('employee_relationship_matetix_id',true);
        $apraiser_employee_id = $this->session->userdata('pms_employee_id');
        $comment = $this->input->post('comment',true);

        $employee_relationship_materix_detail = $this->apraisermodel->getRelationshipStatus($apraisee_employee_id, $apraiser_employee_id, $time_period_id);

        if (!empty($employee_relationship_materix_detail))
        {
            $emp_rel_mat_id = $employee_relationship_materix_detail['employee_relationship_materix_id'];
            $apraiser_employee_id = $employee_relationship_materix_detail['apraiser_employee_id'];
        }
        if ($emp_rel_mat_id != $employee_relationship_matetix_id) {
            $response['error'] = 'Please Try Agian.';
        } else {
            $this->apraiseemodel->UpdateRelationshipStatus($employee_relationship_matetix_id, '0.1');
            $response['kra_detail'] = $this->apraiseemodel->get_kra_by_id($apraisee_employee_id, $apraiser_employee_id, $time_period_id);

            $kra_ids = array();

            if (!empty($response['kra_detail'])) {
                foreach ($response['kra_detail'] as $key => $val) {
                    $kra_ids[] = $val['apraisee_kra_id'];
                }
                $this->db->where_in('apraisee_kra_id', $kra_ids);
                $this->db->update($this->db->dbprefix . 'apraisee_kra', array('apraisee_kra_approve_status' => '0'));
                $response['success'] = 'KRA Not Approved.';
                $this->apraiseemodel->UpdateRelationshipStatus($employee_relationship_matetix_id, '0.1');
                $this->apraiseemodel->update_track_process($apraisee_employee_id, $time_period_id, '0.1');
            } else {
                $response['error'] = 'Please Try Again.';
            }
        }
        die(json_encode($response));
    }

    /**
     * Calculate overall rating with all apraiser summery
     * @param type $apraisee_id
     * @param type $time_period_id
     * @return type 
     */
    function geOverallRatingForApraisee($apraisee_id, $time_period_id = 1) {
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


        /**
        echo '<pre>';
        print_r($arrKrainfo);
        echo '<hr>';
        print_r($arrCompetency);
        echo '<hr>';
        echo 'no_of_apraisers ' . $no_of_apraisers;
        echo '</pre>';
        **/

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

}

