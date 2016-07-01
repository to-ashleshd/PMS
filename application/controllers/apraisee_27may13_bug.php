<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Apraisee extends CI_Controller {

    function __construct() {
        parent::__construct();
         $this->topmenu->no_cache();
        $this->load->model('generalesettings');
        $this->load->model('employeemodel');
        $this->load->model('commonmodel');
        $this->load->model('companymodel');
        $this->load->model('apraiseemodel');
        $this->load->model('apraisermodel');
        $this->load->model('taskschedulemodel');
        if ($this->session->userdata('pms_employee_id')) {
            if ($this->session->userdata('pms_employee_id') == '1') {
                redirect('clientadmin', 'refresh');
            }
        }
    }

    public function index($tab = '', $tabid = '') {

        //$this->employee();
    }

    function addkra($year = '') {

        if ($this->session->userdata('pms_employee_id')) {

            $data = array();
            $time_period_id = $year;
            $track_status = 0;
            $data['time_period_id'] = $time_period_id;
            $data['total_weight'] = '100';
            $data['edit_total_weight'] = '0';
            $data['appraiser_list'] = '';
            $valid_time_period_ids = $this->taskschedulemodel->get_employee_valid_time_period($this->session->userdata('pms_employee_id'));
            $flag = 0;
            $data['is_all_apraser_kra'] = '';
            

            if ($year == '') {
                $data['year'] = "Page Not Found.";
                die();
            } else if (!in_array($year, $valid_time_period_ids)) {
                redirect('accessdenied', 'refresh');
            } else {
                $is_relationship_added = $this->apraiseemodel->is_employee_relationship_added($this->session->userdata('pms_employee_id'), $time_period_id);

                if ($is_relationship_added <= 0) {
                    $data['error'] = 'Please Add Employee Relationship First.';
                }
                
                $data['site_name'] = $this->generalesettings->getSiteName();
                $data['logo'] = $this->generalesettings->getImage();
                $current_year_detail = $this->taskschedulemodel->get_time_period_by_id($time_period_id);
                $data['current_year'] = '';
                if(!empty($current_year_detail))
                {
                    $data['current_year'] = $current_year_detail['time_period_from'].' '.$current_year_detail['time_period_to'];
                }
                $pms_employee_id = $this->session->userdata('pms_employee_id');
                
                $employee_relationship_materix_id = '0';
                $employee_relationship_materix_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id, $time_period_id);
                $reviewer_id_for_score = '0';
                if(!empty($employee_relationship_materix_detail))
                {
                    $reviewer_id_for_score = $employee_relationship_materix_detail[0]['reviewer_employee_id'];
                }
                if($year==1)
                {
                    $data['last_score'] = $this->apraiseemodel->get_employee_temp_last_rating($this->session->userdata('pms_employee_id'));
                }
                else
                {
                    $imediate_prev_year = $this->commonmodel->get_immediate_previous_year();
                    $immidiate_year = '0';
                    if(!empty($imediate_prev_year))
                    {
                        $immidiate_year = $imediate_prev_year['time_period_id'];
                    }
                    $data['last_score'] = $this->apraiseemodel->get_employee_last_year_rating($this->session->userdata('pms_employee_id'),$reviewer_id_for_score,$immidiate_year);
                }
                
                $submit_status = '';
                $data['appraiser'] = '';
                $apariser_name_info = '';
                $apariser_name_info_not_approve = '';
                
                if (!empty($employee_relationship_materix_detail)) {
                    foreach ($employee_relationship_materix_detail as $keyer => $valer) {
                        
                        $apraiser_kra = $this->apraiseemodel->get_kra_by_id($pms_employee_id,$valer['apraiser_employee_id'],$time_period_id);
                           
                            if(empty($apraiser_kra))
                            {
                                $flag=1;
                            }
                        // echo $valer['submit_status'];
                        $appraiser_detail = $this->employeemodel->get_employee_by_id($valer['apraiser_employee_id']);
                        if (!empty($appraiser_detail)) {
                            $data['appraiser_list'][] = array(
                                'apraiser_employee_id' => $appraiser_detail['pms_employee_id'],
                                'appraiser_name_with_designation' => $appraiser_detail['fname'] . ' ' . $appraiser_detail['lname'] . ', ' . $appraiser_detail['designation_name']
                            );
                            if ($valer['submit_status'] == '0.2') {
                                if ($apariser_name_info == '') {
                                    $apariser_name_info = '[' . $appraiser_detail['fname'] . ' ' . $appraiser_detail['lname'] . ', ' . $appraiser_detail['designation_name'] . ']';
                                } else {
                                    $apariser_name_info = $apariser_name_info . ', [' . $appraiser_detail['fname'] . ' ' . $appraiser_detail['lname'] . ', ' . $appraiser_detail['designation_name'] . ']';
                                }
                            } else {
                                if ($valer['submit_status'] == '0.1') {
                                    if ($apariser_name_info_not_approve == '') {
                                        $apariser_name_info_not_approve = '[' . $appraiser_detail['fname'] . ' ' . $appraiser_detail['lname'] . ', ' . $appraiser_detail['designation_name'] . ']';
                                    } else {
                                        $apariser_name_info_not_approve = $apariser_name_info . ', [' . $appraiser_detail['fname'] . ' ' . $appraiser_detail['lname'] . ', ' . $appraiser_detail['designation_name'] . ']';
                                    }
                                }
                            }
                        }
                    }
                    if($flag==1)
                    {
                        $data['is_all_apraser_kra'] = 'N';
                    }
                    else
                    {
                        $data['is_all_apraser_kra'] = 'Y';
                    }
                }

                $no_of_appraiser = '0';

                if (!empty($data['appraiser_list'])) {
                    $no_of_appraiser = count($data['appraiser_list']);
                }


                if ($no_of_appraiser == '1') {
                    $apariser = '<input type="hidden" name="appraiser_employee_id"  id="appraiser_employee_id" value="' . $data['appraiser_list'][0]['apraiser_employee_id'] . '"  />';
                    $apariser .= $data['appraiser_list'][0]['appraiser_name_with_designation'];
                    //$apariser_name_info = $data['appraiser_list'][0]['appraiser_name_with_designation'];
                } else {
                    $apariser = '<select name="appraiser_employee_id"  id="appraiser_employee_id" onchange="check_is_all_appraiser()" >';
                    $apariser .= '<option value="">--Please Select--</option>';
                    if(!empty($data['appraiser_list']))
                    {
                    foreach ($data['appraiser_list'] as $keyal => $valal) {
                        $apariser .= '<option value="' . $valal['apraiser_employee_id'] . '">' . $valal['appraiser_name_with_designation'] . '</option>';
                    }
                    }
                    $apariser .= '</select>';
                }

                $data['appraiser'] = $apariser;

                $track_status = $this->apraiseemodel->get_employee_track_status($pms_employee_id, $time_period_id);

                if ($track_status == '0.1') {
                    $data['apariser_name_info_not_approve'] = $apariser_name_info_not_approve;
                    $data['pending_status'] = 'Your kra Not Approved Please Modify and resend KRA.';
                }
                if ($track_status >= '0.2' && $track_status < '1') {
                    $data['appraiser_name_info'] = $apariser_name_info;
                    $data['apariser_name_info_not_approve'] = $apariser_name_info_not_approve;
                    $data['pending_status'] = '';//KRA has been submitted to Appraiser for Approval.';
                } else if ($track_status == '1') {
                    $data['pending_status'] = 'KRA has been approved by Appraiser.';
                }

                $min_kra_detail = $this->taskschedulemodel->get_min_kra($time_period_id);
                $data['min_kra'] = $min_kra_detail['meta_value'];
                $max_kra_detail = $this->taskschedulemodel->get_max_kra($time_period_id);
                $data['max_kra'] = $max_kra_detail['meta_value'];
                $min_weightage_detail = $this->taskschedulemodel->get_min_weightage($time_period_id);
               
                $data['min_weightage'] = $min_weightage_detail['meta_value'];
                $max_weightage_detail = $this->taskschedulemodel->get_max_weightage($time_period_id);
                $data['max_weightage'] = $max_weightage_detail['meta_value'];
                
                
                if ($track_status >= '0.2') {
                    $temp_valkd = array();
                    $data['kra_detail'] = $this->apraiseemodel->getEmployeeKraById($this->session->userdata('pms_employee_id'), $time_period_id);

                    if (!empty($data['kra_detail'])) {
                        foreach ($data['kra_detail'] as $keykd => $valkd) {
                            $temp_valkd = $valkd;
                            $appraiser_detail = $this->employeemodel->get_employee_by_id($valkd['current_apraiser_id']);
                            $temp_valkd['appraiser_name_designation'] = '';

                            if (!empty($appraiser_detail)) {
                                $temp_valkd['appraiser_name_designation'] = $appraiser_detail['fname'] . ' ' . $appraiser_detail['lname'] . ', ' . $appraiser_detail['designation_name'];
                            }
                            $data['kra_detail'][$keykd] = $temp_valkd;
                        }
                    }
                    // print_r($data['kra_detail']);
                    // die();
                } else {
                    $data['used_kra'] = '0';
                    $data['max_weight_for_edit'] = 100;
                    $data['temp_kra_detail'] = $this->apraiseemodel->getEmployeeKraById($this->session->userdata('pms_employee_id'), $time_period_id);

                    if ($track_status == '0.1') {
                        //echo "hi";die();
                        $data['edit_kra_detail'] = $this->apraiseemodel->get_kra_by_aproove_status($pms_employee_id, '0', $time_period_id);
                        $data['min_kra'] = count($data['edit_kra_detail']);
                        //$data['max_kra'] = count($data['edit_kra_detail']);
                        $data['not_approve_comment'] =  '';//$this->apraisermodel->get_not_approve_comment($pms_employee_id,$data['edit_kra_detail'][0]['current_apraiser_id'],$time_period_id);
                    } else {
                        $data['edit_kra_detail'] = $this->apraiseemodel->getEmployeeKraById($this->session->userdata('pms_employee_id'), $time_period_id);
                    }

                    $data['used_kra'] = count($data['temp_kra_detail']);
//                    echo $data['min_kra'];echo "<br>";
//                    echo $data['max_kra'];echo "<br>";die();

                    if (!empty($data['edit_kra_detail'])) {

                        $data['edit_total_weight'] = '';
                        foreach ($data['edit_kra_detail'] as $key => $val) {
                            $appraiser_detail = $this->employeemodel->get_employee_by_id($val['current_apraiser_id']);

                            // print_r($appraiser_detail['fname']);
                            // echo "<br>";
                            //$response['edit_kra_detail'][$key]['appraiser_name_designation'] = '';
                            $temp_val = $val;
                            $temp_val['appraiser_name_designation'] = '';

                            if (!empty($appraiser_detail)) {
                                $temp_val['appraiser_name_designation'] = $appraiser_detail['fname'] . ' ' . $appraiser_detail['lname'] . ', ' . $appraiser_detail['designation_name'];
                            }

                            $data['edit_kra_detail'][$key] = $temp_val;
                            if ($data['edit_total_weight'] == '') {
                                $data['edit_total_weight'] = $val['weightage_value'];
                            } else {
                                $data['edit_total_weight'] += $val['weightage_value'];
                            }
                            if ($track_status == '0.1') {
                                $data['max_weight_for_edit'] = $data['edit_total_weight'];
                            }
                        }
                    }
                }




                //echo $data['edit_total_weight'];die();




            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['top_employee_detail'] = $this->employeemodel->getEmployeeDetailsById($pms_employee_id, $time_period_id);
            // $data['top_employee_apraise'] = $this->employeemodel->getEmployeeApraiserAndReviewer($pms_employee_id, $time_period_id);
            $top_employee_apraiser_detail = $this->employeemodel->getEmployeeApraiserAndReviewer($pms_employee_id, $time_period_id);
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
//                            if($top_detail_reviewer=='')
//                            {
                                $top_detail_reviewer = '[ <strong>'.$val_topemp['reviewer_name'].'</strong><em> '.$val_topemp['reviewer_designation'].'</em> ]';
//                            }
//                            else
//                            {
//                                $top_detail_reviewer .= ', [ <strong>'.$val_topemp['reviewer_name'].'</strong><em> '.$val_topemp['reviewer_designation'].'</em> ]';
//                            }
                    }
            }
             $data['top_employee_apraiser_detail'] = array(
                 'appraiser'           => $top_detail_apraiser,
                 'reviewer'             => $top_detail_reviewer
             );
             //Added By Ajay
                //Add Track status
                $data['track_status'] = $track_status ;
                
                $data['topmenu'] = $this->topmenu->apraiseemenulist();
                $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data , true);

                $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data , true);
               // $data['common_js'] = $this->load->view('default/clientadmin/cadmin_main_common_js', $data, true);
                $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
                $this->load->view('default/clientadmin/cadmin_addkra', $data);
            }
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function addkradata() {

        $data = array();

        if ($this->session->userdata('pms_employee_id')) {

            $time_period_id = $this->input->post('h_time_period_id', TRUE);
            $appraiser_employee_id = $this->input->post('appraiser_employee_id', TRUE);
            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $employee_relationship_materix_id = '';
            $current_apraiser_id = '';
            $employee_relationship_materix_detail = $this->apraisermodel->getRelationshipStatus($pms_employee_id, $appraiser_employee_id, $time_period_id);



            if (!empty($employee_relationship_materix_detail)) {
                $employee_relationship_materix_id = $employee_relationship_materix_detail['employee_relationship_materix_id'];
                $current_apraiser_id = $employee_relationship_materix_detail['apraiser_employee_id'];
            }

            if (!empty($_POST)) {

                foreach ($_POST['kra'] as $key => $val) {
                    $weightage_id = '0';
                    if ($_POST['weight'][$key] != '') {
                        $weightage_detail = $this->commonmodel->get_weightage_by_value($_POST['weight'][$key], '1');
                        if (empty($weightage_detail)) {

                            $weight_data = array(
                                'weightage_value' => $_POST['weight'][$key],
                                'date_created' => date('Y-m-d'),
                                'weightage_status' => '1'
                            );
                            $weightage_id = $this->commonmodel->add_weightage($weight_data);
                        } else {
                            $weightage_id = $weightage_detail['weightage_id'];
                        }
                    }
                    $data[] = array(
                        'pms_employee_id' => $pms_employee_id,
                        'time_period_id' => $time_period_id,
                        'key_result_area' => $val,
                        'performance_target' => ucfirst($_POST['perf_target'][$key]),
                        'performance_measure' => ucfirst($_POST['perf_measure'][$key]),
                        'weightage_id' => $weightage_id,
                        'initaitive' => ucfirst($_POST['initiative'][$key]),
                        'employee_relationship_materix_id' => $employee_relationship_materix_id,
                        'current_apraiser_id' => $current_apraiser_id,
                        'performance_target' => $_POST['perf_target'][$key],
                        'date_created' => date('Y-m-d'),
                        'ip_address' => $this->input->ip_address(),
                        'apraisee_kra_approve_status' => '0'
                    );
                }
                
                
                
                if (!empty($data)) {
                    foreach ($data as $key => $val) {
                        $result = $this->apraiseemodel->add_kra($val);
                    }
                }

                if ($result) {

                    echo "KRA saved successfully";
                } else {
                    echo "Please try again";
                }
            }
        }
    }

    function getkradetail() {
        $time_period_id = $this->input->post('time_period_id', 'refresh');
        $response = array();
        $pms_employee_id = '0';
        if ($this->session->userdata('pms_employee_id')) {
            $pms_employee_id = $this->session->userdata('pms_employee_id');
        }
        $response['kra_detail'] = $this->apraiseemodel->getEmployeeKraById($pms_employee_id, $time_period_id);
        if (!empty($response['kra_detail'])) {
            $response['edit_total_weight'] = '';
            foreach ($response['kra_detail'] as $key => $val) {
                $temp_val = '';
                $appraiser_detail = $this->employeemodel->get_employee_by_id($val['current_apraiser_id']);
                $temp_val['appraiser_name_designation'] = '';
                $temp_val = $val;
                if (!empty($appraiser_detail)) {
                    $temp_val['appraiser_name_designation'] = $appraiser_detail['fname'] . ' ' . $appraiser_detail['lname'] . ', ' . $appraiser_detail['designation_name'];
                }

                $response['kra_detail'][$key] = $temp_val;

                if ($response['edit_total_weight'] == '') {
                    $response['edit_total_weight'] = $val['weightage_value'];
                } else {
                    $response['edit_total_weight'] += $val['weightage_value'];
                }
            }
        }

        die(json_encode($response));
    }

    function addpms($year = '') {
        if ($this->session->userdata('pms_employee_id')) {

            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data = array();
            $valid_time_period_ids = $this->taskschedulemodel->get_employee_valid_time_period($this->session->userdata('pms_employee_id'));
            if ($year == '') {
                $data['error'] = "Page Not Found. ( Invalid Year ) ";
            }

            if (!in_array($year, $valid_time_period_ids)) {
                redirect('accessdenied', 'refresh');
            }



            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();
            if ($year == '') {
                $time_period_id = '0';
            } else {
                $time_period_id = $year;
            }

            $time_period_detail = $this->taskschedulemodel->getTimeperiodById($time_period_id);
            if (empty($time_period_detail)) {
                $data['error'] = "Page Not Found.";
            }

            $apraisee_kra_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id, $year);
            
            
            
            $reviewer_id_for_score ='0';
            if(!empty($apraisee_kra_detail))
            {
                $reviewer_id_for_score = $apraisee_kra_detail[0]['reviewer_employee_id'];
            }
             if($time_period_id==1)
                {
                    $data['last_score'] = $this->apraiseemodel->get_employee_temp_last_rating($pms_employee_id);
                }
                else
                {
                     $imediate_prev_year = $this->commonmodel->get_immediate_previous_year();
                    $immidiate_year = '0';
                    if(!empty($imediate_prev_year))
                    {
                        $immidiate_year = $imediate_prev_year['time_period_id'];
                    }
                    $data['last_score'] = $this->apraiseemodel->get_employee_last_year_rating($pms_employee_id,$reviewer_id_for_score,$immidiate_year);
                }
            
            
            
            
            $submit_status = '0';
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['top_employee_detail'] = $this->employeemodel->getEmployeeDetailsById($pms_employee_id, $time_period_id);
           // $data['top_employee_apraiser_detail'] = $this->employeemodel->getEmployeeApraiserAndReviewer($pms_employee_id, $time_period_id);
            $top_employee_apraiser_detail = $this->employeemodel->getEmployeeApraiserAndReviewer($pms_employee_id, $time_period_id);
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
//                            if($top_detail_reviewer=='')
//                            {
                                $top_detail_reviewer = '[ <strong>'.$val_topemp['reviewer_name'].'</strong><em> '.$val_topemp['reviewer_designation'].'</em> ]';
//                            }
//                            else
//                            {
//                                $top_detail_reviewer .= ', [ <strong>'.$val_topemp['reviewer_name'].'</strong><em> '.$val_topemp['reviewer_designation'].'</em> ]';
//                            }
                    }
            }
             $data['top_employee_apraiser_detail'] = array(
                 'appraiser'           => $top_detail_apraiser,
                 'reviewer'             => $top_detail_reviewer
             );
            
//             echo "<pre>";
//             print_r($apraisee_kra_detail);
//             echo "</pre>";die();
             
            if (!empty($apraisee_kra_detail)) {
                foreach ($apraisee_kra_detail as $key => $val) {
                    $submit_status = $val['submit_status'];
                }
            }

            $is_relationship_added = $this->apraiseemodel->is_employee_relationship_added($this->session->userdata('pms_employee_id'), $time_period_id);

            if ($is_relationship_added <= 0) {
                $data['error'] = 'Please Add Employee Relationship First.';
            }

            if (empty($time_period_detail)) {
                $data['error'] = "Page Not Found.";
            } elseif ($submit_status < 1) {
                if (isset($data['error'])) {
                    $data['error'] = $data['error'] . "<br /> Either Your KRA are not filled up or not approved by your Appraiser.";
                } else {
                    $data['error'] = "Either Your KRA are not filled up or not approved by your Appraiser.";
                }
            } else {
                if ($submit_status >= 2) {
                    //TODO: Need Fixed - Pass multiple appriiser id 
                    $data['pms_detail'] = $this->apraisermodel->getApraiseeKraPmsDetail($pms_employee_id, $time_period_id);
                } else {
                    $data['kra_detail'] = $this->apraiseemodel->getEmployeeKraById($pms_employee_id, $time_period_id);
                }
            }



            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['all_ratings'] = $this->taskschedulemodel->getAllRatimgs('1');
            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            $this->load->view('default/clientadmin/cadmin_addpms', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function addpmsdata() {
        $data = array();

        if ($this->session->userdata('pms_employee_id')) {

            $rating  = array();
            $comment = array();
            $kra_id  = '';

            if (!empty($_POST)) {

                foreach ($_POST as $key => $val) {

                    $kra_id_detail = explode('_', $key);
                    $kra_id = $kra_id_detail[1];
                    if ($kra_id_detail[0] == 'rating') {
                        $rating[$kra_id] = $val;
                    } else {
                        $comment[$kra_id] = $val;
                    }
                }

                $sub_status = '';
                foreach ($rating as $key => $val) {

                    $kra_id = $key;
                    $kra_detail = $this->apraiseemodel->getApraiseeKraById($kra_id);
                    $comment_desc = '';
                    //$employee_relationship_materix_ids = array();
                    if (array_key_exists($kra_id, $comment)) {
                        $comment_desc = $comment[$kra_id];
                    }

                    //echo '<pre>';
                    //print_r($kra_detail);
                    //echo '</pre>';
                    //die();


                    $employee_relationship_materix_id = $kra_detail['employee_relationship_materix_id'];
                    $employee_relationship_detail = $this->apraiseemodel->getEmployeeRelationshipByID($employee_relationship_materix_id);
                    if ($employee_relationship_detail['submit_status'] == '2') {
                        $sub_status = '2';
                    } else {
                        $data[] = array(
                            'pms_employee_id' => $this->session->userdata('pms_employee_id'),
                            'time_period_id' => $kra_detail['time_period_id'],
                            'apraisee_kra_id' => $kra_id,
                            'rating_id' => $val,
                            'comment' => ucfirst($comment_desc),
                            'employee_relationship_materix_id' => $kra_detail['employee_relationship_materix_id']
                        );
                    }
                }

                //Add Data

                if ($sub_status != '2') {
                    $result = $this->apraiseemodel->addPms($data);

                    //update relationship materix status
                    //TODO: Need Fixed - Replace all relateion ship matrix ids to activate pms for multi apraiser

                    $sql_multiple_relationship = "SELECT  employee_relationship_materix_id 
                        FROM " . $this->db->dbprefix . "employee_relationship_materix
                        WHERE time_period_id = '" . $kra_detail['time_period_id'] . "' 
                        and pms_employee_id = '" . $this->session->userdata('pms_employee_id') . "' ";
                    //echo $sql_multiple_relationship ;
                    $query = $this->db->query($sql_multiple_relationship);
                    foreach ($query->result() as $materix_id) {
                        $this->apraiseemodel->UpdateRelationshipStatus($materix_id->employee_relationship_materix_id, '2');
                    }

                    $this->apraiseemodel->UpdateRelationshipStatus($employee_relationship_materix_id, '2');
                }
                if ($sub_status == '2') {
                    echo "Form already submitted";
                } else {
                    if ($result) {
                        echo "PMS Submitted Successfully";
                    } else {
                        echo "Please try again";
                    }
                }
            }
        }
    }

    function getpmsdetail() {
        $response = array();
        $time_period_id = '1';
        $pms_employee_id = $this->input->post('pms_employee_id', true);
        $response['pms_detail'] = $this->apraisermodel->getApraiseeKraPmsDetail($pms_employee_id, $time_period_id);
        die(json_encode($response));
    }

    function addidp($year = '') {
        if ($this->session->userdata('pms_employee_id')) {
            $time_period_id = '';


            $data = array();
            $valid_time_period_ids = $this->taskschedulemodel->get_employee_valid_time_period($this->session->userdata('pms_employee_id'));
            if ($year == '') {
                $data['error'] = "Page Not Found. ( Invalid Year ) ";
            }

            if (!in_array($year, $valid_time_period_ids)) {
                redirect('accessdenied', 'refresh');
            }

            $pms_employee_id = $this->session->userdata('pms_employee_id');

            $employee_grade_id = '0';
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $time_period_id = $year;
            $data['time_period_id'] = $time_period_id;
            $time_period_detail = $this->taskschedulemodel->getTimeperiodById($time_period_id);

            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['top_employee_detail'] = $this->employeemodel->getEmployeeDetailsById($pms_employee_id, $time_period_id);
            $top_employee_apraiser_detail = $this->employeemodel->getEmployeeApraiserAndReviewer($pms_employee_id, $time_period_id);
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
                            //if($top_detail_reviewer=='')
                           // {
                                $top_detail_reviewer = '[ <strong>'.$val_topemp['reviewer_name'].'</strong><em> '.$val_topemp['reviewer_designation'].'</em> ]';
                          //  }
//                            else
//                            {
//                                $top_detail_reviewer .= ', [ <strong>'.$val_topemp['reviewer_name'].'</strong><em> '.$val_topemp['reviewer_designation'].'</em> ]';
//                            }
                    }
            }
             $data['top_employee_apraiser_detail'] = array(
                 'appraiser'           => $top_detail_apraiser,
                 'reviewer'             => $top_detail_reviewer
             );
           
             
            $employee_detail = $this->employeemodel->getEmployeeById($pms_employee_id);
            if (!empty($employee_detail)) {
                $employee_grade_id = $employee_detail->grade_id;
            }

            $data['competencies_for_refrence'] = $this->commonmodel->getCompetenciesByGrade($employee_grade_id);

            $apraisee_relationship_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id, $year);

            //echo '<pre>';
            //print_r($apraisee_relationship_detail);
            //echo '</pre>';
            $reviewer_id_for_score ='0';
            $submit_status = '0';
            if (!empty($apraisee_relationship_detail)) {
                $reviewer_id_for_score = $apraisee_relationship_detail[0]['reviewer_employee_id'];
                foreach ($apraisee_relationship_detail as $key => $val) {
                    $submit_status = $val['submit_status'];
                }
            }

            if($time_period_id==1)
                {
                    $data['last_score'] = $this->apraiseemodel->get_employee_temp_last_rating($this->session->userdata('pms_employee_id'));
                }
                else
                {
                    $imediate_prev_year = $this->commonmodel->get_immediate_previous_year();
                    $immidiate_year = '0';
                    if(!empty($imediate_prev_year))
                    {
                        $immidiate_year = $imediate_prev_year['time_period_id'];
                    }
                    $data['last_score'] = $this->apraiseemodel->get_employee_last_year_rating($this->session->userdata('pms_employee_id'),$reviewer_id_for_score,$immidiate_year);
                }
            
            
            $is_relationship_added = $this->apraiseemodel->is_employee_relationship_added($this->session->userdata('pms_employee_id'), $time_period_id);

            if ($is_relationship_added <= 0) {
                $data['error'] = 'Please Add Employee Relationship First.';
            }

            //echo$submit_status; die();
            if (empty($time_period_detail)) {
                $data['error'] = "Page Not Found.";
            } elseif ($submit_status < 1) {
                if (isset($data['error'])) {
                    $data['error'] = $data['error'] . "<br />Please Fill Up KRA & PMS First.";
                } else {
                    $data['error'] = "Please Fill Up KRA & PMS First.";
                }
            } elseif ($submit_status < 2) {
                if (isset($data['error'])) {
                    $data['error'] = $data['error'] . "<br />Please Fill Up PMS First.";
                } else {
                    $data['error'] = "Please Fill Up PMS First.";
                }
            } elseif ($submit_status >= 3) {

                $data['idp_detail'] = $this->apraiseemodel->getAllIdpsOfApraisee($pms_employee_id, $time_period_id);
            }

            //By Ajay
            //echo '<pre>';
            //$my_idp = $this->apraiseemodel->getAllIdpsOfApraisee($pms_employee_id, $time_period_id);
            //$data['idp_detail'] = $this->apraiseemodel->getAllIdpsOfApraisee($pms_employee_id, $time_period_id);
            //print_r($my_idp);
            //echo '</pre>';


            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            $this->load->view('default/clientadmin/cadmin_idp', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    public function addidpdata() {

        $data = array();
        $employee_relationship_materix_id = '0';
        $year = '1';
        $result = '';
        if ($this->session->userdata('pms_employee_id')) {

            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $employee_reationship_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id, $year);
            if (!empty($employee_reationship_detail)) {
                $employee_relationship_materix_id = $employee_reationship_detail[0]['employee_relationship_materix_id'];
            }
            if (!empty($_POST['invE_item'])) {
                $i = 1;
                $j = 0;
                foreach ($_POST['invE_item'] as $key => $val) {
                    if (trim($val) != '') {
                        $j++;
                        $data = array(
                            'pms_employee_id' => $pms_employee_id,
                            'time_period_id' => $_POST['time_period_id'],
                            'development_area' => ucfirst($val),
                            'sort_order' => $i,
                            'employee_relationship_materix_id' => $employee_relationship_materix_id,
                            'date_created' => date('Y-m-d'),
                            'ip_address' => $this->input->ip_address()
                        );
                        $result = $this->apraiseemodel->addIdpData($data);
                        $i++;
                    }
                }
                if ($j >= 0) {
                    //update relationship materix status
                    //TODO: Need Fixed - Replace all relation
                    $sql_multiple_relationship = "SELECT  employee_relationship_materix_id 
                        FROM " . $this->db->dbprefix . "employee_relationship_materix
                        WHERE time_period_id = '" . $_POST['time_period_id'] . "' 
                        and pms_employee_id = '" . $this->session->userdata('pms_employee_id') . "' ";
                    //echo $sql_multiple_relationship ;
                    $query = $this->db->query($sql_multiple_relationship);
                    foreach ($query->result() as $materix_id) {
                        $this->apraiseemodel->UpdateRelationshipStatus($materix_id->employee_relationship_materix_id, '3');
                    }



                    $this->apraiseemodel->UpdateRelationshipStatus($employee_relationship_materix_id, '3');
                }

                if ($result) {
                    echo "IDP Submitted Successfully.";
                } else {
                    echo "Please try again";
                }
            }
        }
    }

    function getidpdetail() {
        $response = array();
        $time_period_id = '1';
        $pms_employee_id = $this->input->post('pms_employee_id', true);
        $response['idp_detail'] = $this->apraiseemodel->getAllIdpsOfApraisee($pms_employee_id, $time_period_id);

        die(json_encode($response));
    }

    function autocomplete_weightage() {
        $json = array();

        $weighatge = $this->input->post('weightage', TRUE);
        $weighatge = strtolower($weighatge);
        if ($weighatge != '') {

            $status = '1';
            $results = $this->commonmodel->get_all_weightage(trim($weighatge), trim($status));


            foreach ($results as $result) {
                $json[] = array(
                    'weightage_id' => $result['weightage_id'],
                    'weightage_value' => $result['weightage_value'],
                );
            }
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['weightage_value'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $response['weightage'] = $json;

        die(json_encode($response));
    }

    function updatekra() {
        $response = array();
        $apraisee_kra_id = $this->input->post('apraisee_kra_id', TRUE);
        $response['kra_detail'] = $this->apraiseemodel->get_apraisee_kra_by_Id($apraisee_kra_id);
       
        $time_period_id = '1';
        $employee_relationship_materix_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($response['kra_detail']['pms_employee_id'], $time_period_id);
        
        $track_status = $this->apraiseemodel->get_employee_track_status($response['kra_detail']['pms_employee_id'], $time_period_id);
        
        if (!empty($response['kra_detail'])) {
            $appraiser_detail = $this->employeemodel->get_employee_by_id($response['kra_detail']['current_apraiser_id']);
            $response['kra_detail']['appraiser_name_designation'] = '';

            if (!empty($appraiser_detail)) {
                $response['kra_detail']['appraiser_name_designation'] = $appraiser_detail['fname'] . ' ' . $appraiser_detail['lname'] . ', ' . $appraiser_detail['designation_name'];
            }
            
            
                    $apariser = '<input type="hidden" name="appraiser_employee_id_'.$apraisee_kra_id.'"  id="appraiser_employee_id_'.$apraisee_kra_id.'" value="' . $response['kra_detail']['current_apraiser_id'] . '"  />';
                    $apariser .=  $appraiser_detail['fname'] . ' ' . $appraiser_detail['lname'] . ', ' . $appraiser_detail['designation_name'];
                    $response['appraiser'] = $apariser;
            }
        
        
        die(json_encode($response));
    }

    function updatekradata() {
        $response = array();
        $data = array();
        $apraisee_kra_id = $this->input->post('apraisee_kra_id', TRUE);
        $key_result_area = $this->input->post('key_result_area', TRUE);
        $perf_target = $this->input->post('perf_target', TRUE);
        $perf_measure = $this->input->post('perf_measure', TRUE);
        $weight = $this->input->post('weight', TRUE);
        $initiative = $this->input->post('initiative', TRUE);
        $appraiser_employee_id = $this->input->post('appraiser_employee_id',TRUE);
        $weightage_detail = $this->commonmodel->get_weightage_by_value($weight, '1');
        if (empty($weightage_detail)) {

            $weight_data = array(
                'weightage_value' => $weight,
                'date_created' => date('Y-m-d'),
                'weightage_status' => '1'
            );
            $weightage_id = $this->commonmodel->add_weightage($weight_data);
        } else {
            $weightage_id = $weightage_detail['weightage_id'];
        }
        
        $pms_employee_id ='';
        $time_period_id = '';
        $kra_details = $this->apraiseemodel->get_apraisee_kra_by_Id($apraisee_kra_id);
        if(!empty($kra_details))
        {
            $pms_employee_id = $kra_details['apraisee_kra_id'];
            $time_period_id = $kra_details['time_period_id'];
        }
        $employee_relationship_materix_id ='';
        $employee_relationship_materix_info = $this->apraisermodel->getRelationshipStatus($pms_employee_id, $appraiser_employee_id, $time_period_id);
                        if (!empty($employee_relationship_materix_info)) {
                            $employee_relationship_materix_id = $employee_relationship_materix_info['employee_relationship_materix_id'];
                        }
        $data = array(
            'key_result_area' => $key_result_area,
            'performance_target' => ucfirst($perf_target),
            'performance_measure' => ucfirst($perf_measure),
            'weightage_id' => $weightage_id,
            'initaitive' => ucfirst($initiative),
            'performance_target' => $perf_target,
            'apraisee_kra_approve_status' => '0'
           // 'current_apraiser_id' => $appraiser_employee_id,
           // 'employee_relationship_materix_id'=>$employee_relationship_materix_id
        );

        $result = $this->apraiseemodel->update_apraisee_kra($data, $apraisee_kra_id);
        if ($result) {
            $response['msg'] = "KRA modified To draft Successfully.";
        } else {
            $response['msg'] = "Please Try Again.";
        }
        $response['kra_detail'] = $this->apraiseemodel->get_apraisee_kra_by_Id($apraisee_kra_id);
        if (!empty($response['kra_detail'])) {
            $response['kra_detail']['appraiser_name_designation'] = '';
            $appraiser_detail = $this->employeemodel->get_employee_by_id($response['kra_detail']['current_apraiser_id']);

            if (!empty($appraiser_detail)) {
                $response['kra_detail']['appraiser_name_designation'] = $appraiser_detail['fname'] . ' ' . $appraiser_detail['lname'] . ', ' . $appraiser_detail['designation_name'];
            }
        }
        die(json_encode($response));
    }

    function sendtoapraiser() {
        $response = array();
        $data = array();
        $pms_employee_id = '';
        $time_period_id = '';
        $result = '0';
        $time_period_id = $this->input->post('time_period_id', TRUE);


        if ($this->session->userdata('pms_employee_id')) {
            $pms_employee_id = $this->session->userdata('pms_employee_id');
        }


        $employee_relationship_materix_id = '';
        $employee_relationship_materix_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id, $time_period_id);


        if (!empty($employee_relationship_materix_detail)) {
            foreach ($employee_relationship_materix_detail as $keyer => $valer) {
                $employee_relationship_materix_id[] = $valer['employee_relationship_materix_id'];
            }
        }

        $data['edit_kra_detail'] = $this->apraiseemodel->get_kra_by_aproove_status($pms_employee_id, '0', $time_period_id);

        // print_r($response['kra_detail']);
        $kra_ids = array();
                   
        if (!empty($data['edit_kra_detail'])) {
            
            foreach ($data['edit_kra_detail'] as $key => $val) {
                $kra_ids[] = $val['apraisee_kra_id'];
                $this->apraiseemodel->UpdateRelationshipStatus($val['employee_relationship_materix_id'], '0.2');
            }
            $this->db->where_in('apraisee_kra_id', $kra_ids);
            $this->db->update($this->db->dbprefix . 'apraisee_kra', array('apraisee_kra_approve_status' => '1'));
            //$response['msg'] = 'Your KRA Send to Apraiser For Approvel Successfully.';
            $response['msg'] = 'KRA successfully submited to Appraiser for Approval.';
             
            
           
             }
             
             
              $response['kra_detail'] = $this->apraiseemodel->getEmployeeKraById($pms_employee_id, $time_period_id);
             if (!empty($response['kra_detail'])) {
           
            foreach ($response['kra_detail'] as $key1 => $val1) {
            $temp_val = $val1;
                $appraiser_detail = $this->employeemodel->get_employee_by_id($val1['current_apraiser_id']);
                $temp_val['appraiser_name_designation'] = '';

                if (!empty($appraiser_detail)) {
                    $temp_val['appraiser_name_designation'] = $appraiser_detail['fname'] . ' ' . $appraiser_detail['lname'] . ', ' . $appraiser_detail['designation_name'];
                }
                $response['kra_detail'][$key1] = $temp_val;
            }
            
            
//            if(isset($employee_relationship_materix_id))
//            {
//                if(!empty($employee_relationship_materix_id))
//                {
//                    foreach($employee_relationship_materix_id as $key=>$val)
//                    {
//                        $this->apraiseemodel->UpdateRelationshipStatus($val,'0.2');
//                    }
//                }
//            }
            
            $this->apraiseemodel->update_track_process($pms_employee_id, $time_period_id, '0.2');
        } else {
            // echo "hi";
            $response['msg'] = 'Please Try Again.';
        }
        die(json_encode($response));
    }

    function update_all_weight() {
        $response = array();
        $data = array();
        $weightage_id = '';
        $flag = 0;

        $kras_weight = $this->input->post('kras_weight', TRUE);
        $time_period_id = $this->input->post('time_period_id', TRUE);
        $pms_employee_id = $this->session->userdata('pms_employee_id');
        $max_weight = $this->input->post('max_weight',TRUE);
        $total_weight = 0;
        if (!empty($kras_weight)) {
            foreach ($kras_weight as $key => $val) {
                if($total_weight==0)
                {
                    $total_weight = $val;
                }
                else
                {
                    $total_weight += $val;
                }
                if ($key != 0 && trim($val)!='') {
                    $weightage_detail = $this->commonmodel->get_weightage_by_value($val, '1');
                    if (empty($weightage_detail)) {

                        $weight_data = array(
                            'weightage_value' => $val,
                            'date_created' => date('Y-m-d'),
                            'weightage_status' => '1'
                        );
                        $weightage_id = $this->commonmodel->add_weightage($weight_data);
                    } else {
                        $weightage_id = $weightage_detail['weightage_id'];
                    }

                    $data = array(
                        'weightage_id' => $weightage_id,
                    );

                    $result = $this->apraiseemodel->update_apraisee_kra($data, $key);
                    if (!$result) {
                        $flag = 1;
                    }
                }
            }

            if ($flag == 0) {
                $response['msg'] = "KRA weightage modified successfully.";
            } else {
                $response['msg'] = "Please Try Again.";
            }
        }
       
        //new process to display form
         $employee_relationship_materix_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id, $time_period_id);
        $data = array();       
        $data['appraiser'] = '';
        $data['edit_total_weight'] = $total_weight;
                $apariser_name_info = '';
                if (!empty($employee_relationship_materix_detail)) {
                    foreach ($employee_relationship_materix_detail as $keyer => $valer) {
                        $appraiser_detail = $this->employeemodel->get_employee_by_id($valer['apraiser_employee_id']);
                        if (!empty($appraiser_detail)) {
                            $data['appraiser_list'][] = array(
                                'apraiser_employee_id' => $appraiser_detail['pms_employee_id'],
                                'appraiser_name_with_designation' => $appraiser_detail['fname'] . ' ' . $appraiser_detail['lname'] . ', ' . $appraiser_detail['designation_name']
                            );
                        }
                    }
                }

                $no_of_appraiser = '0';

                if (!empty($data['appraiser_list'])) {
                    $no_of_appraiser = count($data['appraiser_list']);
                }


                if ($no_of_appraiser == '1') {
                    $apariser = '<input type="hidden" name="appraiser_employee_id"  id="appraiser_employee_id" value="' . $data['appraiser_list'][0]['apraiser_employee_id'] . '"  />';
                    $apariser .= $data['appraiser_list'][0]['appraiser_name_with_designation'];
                } else {
                    $apariser = '<select name="appraiser_employee_id"  id="appraiser_employee_id" >';
                    $apariser .= '<option value="">--Please Select--</option>';
                    if(!empty($data['appraiser_list']))
                    {
                    foreach ($data['appraiser_list'] as $keyal => $valal) {
                        $apariser .= '<option value="' . $valal['apraiser_employee_id'] . '">' . $valal['appraiser_name_with_designation'] . '</option>';
                    }
                    }
                    $apariser .= '</select>';
                }

                $data['appraiser'] = $apariser;
                
                $response['add_kra_form'] = '';
                 //echo $total_weight; echo "<br>"; echo $max_weight; 
                if($total_weight < $max_weight)
                {
                     $response['add_kra_form'] = $this->load->view('default/clientadmin/cadmin_addkra_form',$data,TRUE);
                }
               
       
        die(json_encode($response));
    }

    
    function removekra()
    {
        $response = array();
        $apraisee_kra_id = $this->input->post('apraisee_kra_id', TRUE);
        $edit_total_weight = $this->input->post('edit_total_weight', TRUE);
        $new_edit_total_weight = $this->input->post('new_edit_total_weight', TRUE);
    
        $kra_detail = $this->apraiseemodel->getApraiseeKraById($apraisee_kra_id);
        $this->db->where('apraisee_kra_id', $apraisee_kra_id);
        $result = $this->db->delete($this->db->dbprefix.'apraisee_kra'); 
        if($result)
        {
            $response['message'] = 'KRA removed successfully.';
        }
        else
        {
            $response['error_message'] = 'Please Try Again.';
        }
        
        $time_period_id = '1';
        $employee_relationship_materix_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($kra_detail['pms_employee_id'], $time_period_id);
        $data = array();       
        $data['appraiser'] = '';
        $data['edit_total_weight'] = $new_edit_total_weight;
                $apariser_name_info = '';
                if (!empty($employee_relationship_materix_detail)) {
                    foreach ($employee_relationship_materix_detail as $keyer => $valer) {
                        $appraiser_detail = $this->employeemodel->get_employee_by_id($valer['apraiser_employee_id']);
                        if (!empty($appraiser_detail)) {
                            $data['appraiser_list'][] = array(
                                'apraiser_employee_id' => $appraiser_detail['pms_employee_id'],
                                'appraiser_name_with_designation' => $appraiser_detail['fname'] . ' ' . $appraiser_detail['lname'] . ', ' . $appraiser_detail['designation_name']
                            );
                        }
                    }
                }

                $no_of_appraiser = '0';

                if (!empty($data['appraiser_list'])) {
                    $no_of_appraiser = count($data['appraiser_list']);
                }


                if ($no_of_appraiser == '1') {
                    $apariser = '<input type="hidden" name="appraiser_employee_id"  id="appraiser_employee_id" value="' . $data['appraiser_list'][0]['apraiser_employee_id'] . '"  />';
                    $apariser .= $data['appraiser_list'][0]['appraiser_name_with_designation'];
                } else {
                    $apariser = '<select name="appraiser_employee_id"  id="appraiser_employee_id" onchange="check_is_all_appraiser()" >';
                    $apariser .= '<option value="">--Please Select--</option>';
                    if(!empty($data['appraiser_list']))
                    {
                    foreach ($data['appraiser_list'] as $keyal => $valal) {
                        $apariser .= '<option value="' . $valal['apraiser_employee_id'] . '">' . $valal['appraiser_name_with_designation'] . '</option>';
                    }
                    }
                    $apariser .= '</select>';
                }

                $data['appraiser'] = $apariser;
                $response['add_kra_form'] = '';
                if($edit_total_weight==100)
                {
                    $response['add_kra_form'] = $this->load->view('default/clientadmin/cadmin_addkra_form',$data,true);
                }
        
          
        die(json_encode($response));
  
    }
    
    
    function get_Kra_by_appraiser_for_edit()
    {
        $response               = array();
        $time_period_id         = $this->input->post('time_period_id', TRUE);
        $apraisee_employee_id   = $this->input->post('apraisee_employee_id', TRUE);
        $apraiser_employee_id   = $this->session->userdata('pms_employee_id');
        
        $kras = $this->apraisermodel->get_apraiser_kra($apraisee_employee_id,$apraiser_employee_id,$time_period_id);
        
        $edit_total_weight = 0;
        $html = '';
        $html .= '<table class="table invE_table table-bordered" id="kra_id"  >';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th style="text-align:left; width:1%;" >Sr. No. </th>';
        $html .= '<th style="text-align:left;">Key Result Area </th>';
        $html .= '<th style="text-align:left;">Performance Target</th>';
        $html .= '<th style="text-align:left;" >Performance Measure</th>';
        $html .= '<th style="text-align:left; width:20px;">Weightage %</th>';
        $html .= '<th style="text-align:left;">Initiative</th>';
        $html .= '<th style="text-align:left;">Action</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody id="edit_kra_detail">';
        
        foreach($kras as $key=>$val)
        {
            $weightage_info = $this->commonmodel->getWeightageByid($val['weightage_id']);
            if($edit_total_weight==0)
            {
                $edit_total_weight = $weightage_info['weightage_value'];
            }
            else
            {
                $edit_total_weight += $weightage_info['weightage_value'];
            }
            $sr_no = $key+1;
            $html .= '<tr id="editable_'.$val['apraisee_kra_id'].'" >';
            $html .= '<td style="text-align:left; width:1%;" class="cls_sr_no" >'.$sr_no.'</td>';
            $html .= '<td style="text-align:left;">'.$val['key_result_area'].'</td>';
            $html .= '<td style="text-align:left;">'.$val['performance_target'].'</td>';
            $html .= '<td style="text-align:left;">'.$val['performance_measure'].'</td>';
            $html .= '<td style="text-align:center; width:20px;" class="cls_display_edit_weight">'.$val['weightage_value'].'%';
            $html .= '<input class="cls_weight_edit span12" type="hidden"  name="edit_weight_'.$val['apraisee_kra_id'].'" readonly="readonly"   id="edit_weight_'.$val['apraisee_kra_id'].'" value="'.$val['weightage_value'].'"   / >';
	    $html .= '</td>';
            $html .= '<td style="text-align:left;">'.$val['initaitive'].'</td>';
            $html .= '<td style="text-align:center;" class="cls_edit_link">';
            $html .= '<a  href="javascript:void(0)" onclick="update_kra(\''.$val['apraisee_kra_id'].'\',\''.$sr_no.'\')"  ><i class="icsw16-pencil"></i></a>&nbsp;';
            $html .= '</td>';
            $html .= '</tr>';
        }
        $html .= '<tr class="last_row">';
        $html .= '<td colspan="4" style="text-align:right"><b>Total:</b></td>';
        $html .= '<td style="text-align:center; font-weight:bold;"><span id="edit_total_weight">'.$edit_total_weight.'</span> %</td>';
        $html .= '<td colspan="3" style="text-align:center">&nbsp;</td>';
        $html .= '</tr>';
       
        $html .= '</tbody>';
        $html .= '</table>';
        $response['html']  = $html;
        die(json_encode($response));
     }
    
    
     function update_appraiser()
     {
         $response = array();
         $html  = '';
         $time_period_id = $this->input->post('time_period_id',true);
         $pms_employee_id = $this->session->userdata('pms_employee_id');
         $edit_total_weight = 0;
         $kra_detail = $this->apraiseemodel->getEmployeeKraById($pms_employee_id, $time_period_id);
         $employee_relationship_materix_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id, $time_period_id);
        
            $apariser_name_info = '';
            if (!empty($employee_relationship_materix_detail)) {
                foreach ($employee_relationship_materix_detail as $keyer => $valer) {
                    $appraiser_detail = $this->employeemodel->get_employee_by_id($valer['apraiser_employee_id']);
                    if (!empty($appraiser_detail)) {
                        $data['appraiser_list'][] = array(
                            'apraiser_employee_id' => $appraiser_detail['pms_employee_id'],
                            'appraiser_name_with_designation' => $appraiser_detail['fname'] . ' ' . $appraiser_detail['lname'] . ', ' . $appraiser_detail['designation_name']
                        );
                    }
                }
            }

            $no_of_appraiser = '0';

            if (!empty($data['appraiser_list'])) {
                $no_of_appraiser = count($data['appraiser_list']);
            }
                 
            
            
         if(!empty($kra_detail))
         {
             foreach($kra_detail as $key=>$val)
             {
                 
                         
                $apariser = '<select class="cls_edit_appraiser" name="appraiser_employee_id_'.$val['apraisee_kra_id'].'"  id="appraiser_employee_id_'.$val['apraisee_kra_id'].'" >';
                $apariser .= '<option value="">--Please Select--</option>';
                if(!empty($data['appraiser_list']))
                {
                    foreach ($data['appraiser_list'] as $keyal => $valal) {
                        if($val['current_apraiser_id']==$valal['apraiser_employee_id'])
                        {
                            $apariser .= '<option value="' . $valal['apraiser_employee_id'] . '" selected="selected"  >' . $valal['appraiser_name_with_designation'] . '</option>';
                        }
                        else
                        {
                            $apariser .= '<option value="' . $valal['apraiser_employee_id'] . '">' . $valal['appraiser_name_with_designation'] . '</option>';
                        }
                    }
                }
                $apariser .= '</select>';
                          
                    $weightage_info = $this->commonmodel->getWeightageByid($val['weightage_id']);
                    if($edit_total_weight==0)
                    {
                        $edit_total_weight = $weightage_info['weightage_value'];
                    }
                    else
                    {
                        $edit_total_weight += $weightage_info['weightage_value'];
                    }
                    $sr_no = $key+1;
                    $html .= '<tr id="editable_'.$val['apraisee_kra_id'].'" >';
                    $html .= '<td style="text-align:left; width:1%;" class="cls_sr_no" >'.$sr_no.'</td>';
                    $html .= '<td style="text-align:left;">'.$val['key_result_area'].'</td>';
                    $html .= '<td style="text-align:left;">'.$val['performance_target'].'</td>';
                    $html .= '<td style="text-align:left;">'.$val['performance_measure'].'</td>';
                    $html .= '<td style="text-align:center; width:20px;" class="cls_display_edit_weight">'.$val['weightage_value'].'%';
                    $html .= '<input class="cls_weight_edit span12" type="hidden"  name="edit_weight_'.$val['apraisee_kra_id'].'" readonly="readonly"   id="edit_weight_'.$val['apraisee_kra_id'].'" value="'.$val['weightage_value'].'"   / >';
                    $html .= '</td>';
                    $html .= '<td style="text-align:left;">'.$val['initaitive'].'</td>';
                    $html .= '<td style="text-align:left;">'.$apariser.'</td>';
                    $html .= '<td style="text-align:center;" class="cls_edit_link">';
                    $html .= '&nbsp;';
                    $html .= '</td>';
                    $html .= '</tr>';
             }
                    $html .= '<tr class="last_row">';
                    $html .= '<td colspan="4" style="text-align:right"><b>Total:</b></td>';
                    $html .= '<td style="text-align:center; font-weight:bold;"><span id="edit_total_weight">'.$edit_total_weight.'</span> %</td>';
                    $html .= '<td colspan="3" style="text-align:center">&nbsp;</td>';
                    $html .= '</tr>';
                    $html .= '<tr >';
                    $html .= '<td colspan="8" style="text-align:center" class="cls_send_to_apraiser"><input class="btn btn-beoro-3" type="button" name="update_all_appraiser" id="update_all_appraiser" value ="Update" onclick="update_data_edit_all_appraiser()";   /></td>';
                    $html .= '</tr>';
         }
         
         $response['html'] = $html;
         die(json_encode($response));
     }
     
     
     function update_all_appraiser_data()
     {
         $response = array();
         $response['status'] ='';
         $html = '';
         $edit_total_weight =0;
         $time_period_id  = $this->input->post('time_period_id',TRUE);
         $pms_employee_id = $this->session->userdata('pms_employee_id',TRUE);
         $all_appraiser = $this->input->post('all_appraiser',TRUE);
         $all_appraiser_id = $this->input->post('all_appraiser_id',TRUE);
         $employee_relationship_materix_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id, $time_period_id);
         $appraisers = array();
            if (!empty($employee_relationship_materix_detail)) {
                foreach ($employee_relationship_materix_detail as $keyer => $valer) {
                 
                    $appraisers[] = $valer['apraiser_employee_id'];
                }
            }
            
            
         $remaining_appraiser = array_diff($appraisers, $all_appraiser);
         if(!empty($remaining_appraiser))
         {
             $response['status'] = 1;
         }
         else
         {
            if(!empty($all_appraiser_id))
            {
                foreach($all_appraiser_id as $key=>$val)
                {
                       $kra_id_info = explode('appraiser_employee_id_', $val);
                       $apprisee_kra_id = $kra_id_info[1];
                       $employee_relationship_materix_info = $this->apraisermodel->getRelationshipStatus($pms_employee_id, $all_appraiser[$key], $time_period_id);
                        if (!empty($employee_relationship_materix_info)) {
                            $employee_relationship_materix_id = $employee_relationship_materix_info['employee_relationship_materix_id'];
                        }
                       $this->apraiseemodel->update_apraisee_kra(array('current_apraiser_id'=>$all_appraiser[$key],'employee_relationship_materix_id'=>$employee_relationship_materix_id),$apprisee_kra_id);
                }
                 $response['status'] = 2;
                 $kra_detail = $this->apraiseemodel->getEmployeeKraById($pms_employee_id, $time_period_id);
                 foreach($kra_detail as $key=>$val)
                 {
                     $apariser ='';
                     $appraiser_detail = $this->employeemodel->get_employee_by_id($val['current_apraiser_id']);
                      if (!empty($appraiser_detail)) {
                            $apariser = $appraiser_detail['fname'] . ' ' . $appraiser_detail['lname'] . ', ' . $appraiser_detail['designation_name'];
                        }
                        
                        $weightage_info = $this->commonmodel->getWeightageByid($val['weightage_id']);
                        if($edit_total_weight==0)
                        {
                            $edit_total_weight = $weightage_info['weightage_value'];
                        }
                        else
                        {
                            $edit_total_weight += $weightage_info['weightage_value'];
                        }
                        $sr_no = $key+1;
                        $html .= '<tr id="editable_'.$val['apraisee_kra_id'].'" >';
                        $html .= '<td style="text-align:left; width:1%;" class="cls_sr_no" >'.$sr_no.'</td>';
                        $html .= '<td style="text-align:left;">'.$val['key_result_area'].'</td>';
                        $html .= '<td style="text-align:left;">'.$val['performance_target'].'</td>';
                        $html .= '<td style="text-align:left;">'.$val['performance_measure'].'</td>';
                        $html .= '<td style="text-align:center; width:20px;" class="cls_display_edit_weight">'.$val['weightage_value'].'%';
                        $html .= '<input class="cls_weight_edit span12" type="hidden"  name="edit_weight_'.$val['apraisee_kra_id'].'" readonly="readonly"   id="edit_weight_'.$val['apraisee_kra_id'].'" value="'.$val['weightage_value'].'"   / >';
                        $html .= '</td>';
                        $html .= '<td style="text-align:left;">'.$val['initaitive'].'</td>';
                        $html .= '<td style="text-align:left;">'.$apariser.'</td>';
                        $html .= '<td style="text-align:center;" class="cls_edit_link">';
                        $html .= '<a  href="javascript:void(0)" onclick="update_kra(\''.$val['apraisee_kra_id'].'\',\''.$sr_no.'\')"  ><i class="icsw16-pencil"></i></a>&nbsp;';
                        $html .= '<a title="Delete" onclick="remove_kra(\''.$val['apraisee_kra_id'].'\',\''.$sr_no.'\')" href="javascript:void(0)"><i class="icsw16-trashcan"></i></a>';
                        $html .= '</td>';
                        $html .= '</tr>';
                     }
                    $html .= '<tr class="last_row">';
                    $html .= '<td colspan="4" style="text-align:right"><b>Total:</b></td>';
                    $html .= '<td style="text-align:center; font-weight:bold;"><span id="edit_total_weight">'.$edit_total_weight.'</span> %</td>';
                    $html .= '<td colspan="3" style="text-align:center">&nbsp;</td>';
                    $html .= '</tr>';
                    if($edit_total_weight==100)
                    {
                        $html .= '<tr >';
                        $html .= '<td class="cls_send_to_apraiser" style="text-align:center" colspan="8"><input type="button" onclick="send_to_appraiser()" value="Submit To Appraiser for Approval" id="send_to_apraiser" name="send_to_apraiser" class="btn btn-beoro-3 "></td>';
                        $html .= '</tr>';
                    }
                    else
                    {
                        $html .= '<tr >';
                        $html .= '<td class="cls_send_to_apraiser" style="text-align:center" colspan="8">&nbsp;</td>';
                        $html .= '</tr>';
                    }
            }
           
         }
         
         $response['html'] = $html;
         die(json_encode($response));
         
     }
     
     
     function check_each_appraiser_has_kra()
     {
         $response = array();
         $time_period_id = $this->input->post('time_period_id',true);
         $pms_employee_id = $this->session->userdata('pms_employee_id');
         $appraiser_employee_id = $this->input->post('appraiser_employee_id',TRUE);
         $response['is_kra'] = '';
         $flag=0;
         $employee_relationship_materix_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id, $time_period_id);
        
            if (!empty($employee_relationship_materix_detail)) {
              foreach ($employee_relationship_materix_detail as $key => $val) {
                        if($appraiser_employee_id!=$val['apraiser_employee_id'])
                        {
                            $apraiser_kra = $this->apraiseemodel->get_kra_by_id($pms_employee_id,$val['apraiser_employee_id'],$time_period_id);
                            if(empty($apraiser_kra))
                            {
                               $flag=1;
                               break;
                            }
                           
                        }
              }
              if($flag==1)
              {
                 $response['is_kra']  = 'N';
              }
              else
              {
                 $response['is_kra']  = 'Y';
              }
            }
           die(json_encode($response));
           
         
     }
    
     
     function check_each_appraiser_kra()
     {
         $response = array();
         $time_period_id = $this->input->post('time_period_id',TRUE);
         $pms_employee_id = $this->session->userdata('pms_employee_id');
         $flag=0;
         $response['is_kra'] ='';
          
         $employee_relationship_materix_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id, $time_period_id);
       
            if (!empty($employee_relationship_materix_detail)) {
              foreach ($employee_relationship_materix_detail as $key => $val) {
                            $apraiser_kra = $this->apraiseemodel->get_kra_by_id($pms_employee_id,$val['apraiser_employee_id'],$time_period_id);
                           
                            if(empty($apraiser_kra))
                            {
                                $flag=1;
                                break;
                            }
              }
              
              if($flag==1)
                {
                   $response['is_kra']  = 'N'; 
                }
              else
                {
                    $response['is_kra']  = 'Y';
                }
            }
           die(json_encode($response));
           
         
     }
     
     
     function test()
     {
        $data = array();
        if ($this->session->userdata('pms_employee_id'))
        {
                $data['site_name'] = $this->generalesettings->getSiteName();
                $data['logo'] = $this->generalesettings->getImage();
        }
     }
     
}

