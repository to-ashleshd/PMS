<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mypdf extends CI_Controller {

    function __construct() {
        parent::__construct();
        //  $this->dashboard();
        $this->topmenu->no_cache();

        $this->topmenu->no_cache();
        $this->load->model('generalesettings');
        $this->load->model('employeemodel');
        $this->load->model('commonmodel');
        $this->load->model('companymodel');
        $this->load->model('apraiseemodel');
        $this->load->model('apraisermodel');
        $this->load->model('taskschedulemodel');
        $this->load->model('reportsmodel');
        if ($this->session->userdata('pms_employee_id')) {
            if (!$this->session->userdata('pms_employee_id')) {
                redirect('clientadmin', 'refresh');
            }
        }
    }

    function index() {
        echo '';
    }

    function makepdf($page_url) {
        echo $page_url;
        //print_r( unserialize($page_url) );
        $this->load->library('mPDF');
        $mpdf = new mPDF();
        $mpdf->WriteHTML('<p>Hello Tudip Technologies</p>');
        $mpdf->Output();
        exit;
    }

    function exceladdkra($year = '') {
        if ($this->session->userdata('pms_employee_id')) {
            //TODO: Fix - Increase memory limit for PDF generate
            ini_set('memory_limit', '64M');

            $data = array();
            $time_period_id = $year;
            $data['time_period_id'] = $time_period_id;
            $data['total_weight'] = '100';
            $data['edit_total_weight'] = '0';
            $data['appraiser_list'] = '';
            $valid_time_period_ids = $this->taskschedulemodel->get_employee_valid_time_period($this->session->userdata('pms_employee_id'));
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
                $pms_employee_id = $this->session->userdata('pms_employee_id');

                $employee_relationship_materix_id = '0';
                $employee_relationship_materix_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id, $time_period_id);

                $submit_status = '';
                $data['appraiser'] = '';
                $apariser_name_info = '';
                $apariser_name_info_not_approve = '';

                if (!empty($employee_relationship_materix_detail)) {
                    foreach ($employee_relationship_materix_detail as $keyer => $valer) {
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
                    $apariser = '<select name="appraiser_employee_id"  id="appraiser_employee_id"  >';
                    $apariser .= '<option value="">--Please Select--</option>';
                    if (!empty($data['appraiser_list'])) {
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
                    $data['pending_status'] = 'Your KRA not Approved Please Modify and resend KRA.';
                }
                if ($track_status >= '0.2' && $track_status < '1') {
                    $data['appraiser_name_info'] = $apariser_name_info;
                    $data['apariser_name_info_not_approve'] = $apariser_name_info_not_approve;
                    $data['pending_status'] = 'KRA has been submitted to Appraiser for Approval.';
                } else if ($track_status == '1') {
                    $data['pending_status'] = 'KRA Approved By Appraiser.';
                }

                $min_kra_detail = $this->taskschedulemodel->get_min_kra($time_period_id);
                $data['min_kra'] = $min_kra_detail['meta_value'];
                $max_kra_detail = $this->taskschedulemodel->get_max_kra($time_period_id);
                $data['max_kra'] = $max_kra_detail['meta_value'];
                $min_weightage_detail = $this->taskschedulemodel->get_min_weightage($time_period_id);
                $data['min_weightage'] = ''; //$min_weightage_detail['meta_value'];
                $max_weightage_detail = $this->taskschedulemodel->get_max_weightage($time_period_id);
                $data['max_weightage'] = ''; //$max_weightage_detail['meta_value'];


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
                        $data['not_approve_comment'] = $this->apraisermodel->get_not_approve_comment($pms_employee_id, $data['edit_kra_detail'][0]['current_apraiser_id'], $time_period_id);
                    } else {
                        $data['edit_kra_detail'] = $this->apraiseemodel->getEmployeeKraById($this->session->userdata('pms_employee_id'), $time_period_id);
                    }

                    $data['used_kra'] = count($data['temp_kra_detail']);

                    if (!empty($data['edit_kra_detail'])) {

                        $data['edit_total_weight'] = '';
                        foreach ($data['edit_kra_detail'] as $key => $val) {
                            $appraiser_detail = $this->employeemodel->get_employee_by_id($val['current_apraiser_id']);


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



                $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
                $data['top_employee_detail'] = $this->employeemodel->getEmployeeDetailsById($pms_employee_id, $time_period_id);
                // $data['top_employee_apraise'] = $this->employeemodel->getEmployeeApraiserAndReviewer($pms_employee_id, $time_period_id);
                $top_employee_apraiser_detail = $this->employeemodel->getEmployeeApraiserAndReviewer($pms_employee_id, $time_period_id);
                $top_detail_apraiser = '';
                $top_detail_reviewer = '';
                if (!empty($top_employee_apraiser_detail)) {
                    foreach ($top_employee_apraiser_detail as $key_topemp => $val_topemp) {
                        if ($top_detail_apraiser == '') {
                            $top_detail_apraiser = '[ <strong>' . $val_topemp['apraiser_name'] . ' </strong><em>' . $val_topemp['apraiser_designation'] . '</em> ]';
                        } else {
                            $top_detail_apraiser .= ', [ <strong>' . $val_topemp['apraiser_name'] . '</strong><em> ' . $val_topemp['apraiser_designation'] . '</em> ]';
                        }
//                            if($top_detail_reviewer=='')
//                            {
                        $top_detail_reviewer = '[ <strong>' . $val_topemp['reviewer_name'] . '</strong><em> ' . $val_topemp['reviewer_designation'] . '</em> ]';
//                            }
//                            else
//                            {
//                                $top_detail_reviewer .= ', [ <strong>'.$val_topemp['reviewer_name'].'</strong><em> '.$val_topemp['reviewer_designation'].'</em> ]';
//                            }
                    }
                }
                $data['top_employee_apraiser_detail'] = array(
                    'appraiser' => $top_detail_apraiser,
                    'reviewer' => $top_detail_reviewer
                );

                $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
                $data['topmenu'] = $this->topmenu->apraiseemenulist();
                $data['header'] = $this->load->view('default/clientadmin/pdf_cadmin_header', $data, true);

                $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
                // $data['common_js'] = $this->load->view('default/clientadmin/cadmin_main_common_js', $data, true);
                $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);

                $filename = 'kra-excel-' . date("Y-m-d_His");
                $headers = '';
                $excel_data = '';
                $excel_data = $this->load->view('default/clientadmin/excel_cadmin_addkra', $data, true);
                header('Content-type: application/octet-stream');
                //header("Content-type: application/x-msdownload");
                header("Content-Disposition: attachment; filename=$filename.xls");
                echo "$headers\n$excel_data";

                //$this->load->library('mPDF');
                //$mpdf = new mPDF('utf-8', 'A4-L');
                //$pdf_data = $this->load->view('default/clientadmin/pdf_cadmin_addkra', $data, true);
                //$mpdf->WriteHTML($pdf_data);
                //$mpdf->Output('kra-' . date("Y-m-d_His") . '.pdf', 'D');
                //$mpdf->Output();
                exit;
            }
        } else {
            redirect('clientadmin', 'refresh');
        }
        /**
          $filename = 'kra_excel';
          $headers = '';
          $excel_data = '';

          $excel_data .= 'Employee Name:' . "\t" . 'Kriti Jaiswal' . "\n";
          $excel_data .= 'Designation:' . "\t" . 'Assistant Manager' . "\n";
          $excel_data .= 'Employee ID:' . "\t" . '12005' . "\n";
          $excel_data .= 'Name & Designation of Appraiser:' . "\t" . '[ Nisha Singh Manager ], [ Ashish Sharma Sr Manager ]' . "\n";
          $excel_data .= 'Name & Designation of Reviewer:' . "\t" . '[ Jetender Singh General Manager ]' . "\n";
          $excel_data .= 'Plant / Location:' . "\t" . 'Vepl Corp' . "\n";
          $excel_data .= 'Employee Department:' . "\t" . 'HR' . "\n";

          header('Content-type: application/octet-stream');
          //header("Content-type: application/x-msdownload");
          header("Content-Disposition: attachment; filename=$filename.xls");
          echo "$headers\n$excel_data";
         *
         */
    }

    function pdfaddkra($year = '') {

        if ($this->session->userdata('pms_employee_id')) {
            //TODO: Fix - Increase memory limit for PDF generate
            ini_set('memory_limit', '64M');

            $data = array();
            $time_period_id = $year;
            $data['time_period_id'] = $time_period_id;
            $data['total_weight'] = '100';
            $data['edit_total_weight'] = '0';
            $data['appraiser_list'] = '';
            $valid_time_period_ids = $this->taskschedulemodel->get_employee_valid_time_period($this->session->userdata('pms_employee_id'));
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
                $pms_employee_id = $this->session->userdata('pms_employee_id');

                $employee_relationship_materix_id = '0';
                $employee_relationship_materix_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id, $time_period_id);

                $submit_status = '';
                $data['appraiser'] = '';
                $apariser_name_info = '';
                $apariser_name_info_not_approve = '';

                if (!empty($employee_relationship_materix_detail)) {
                    foreach ($employee_relationship_materix_detail as $keyer => $valer) {
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
                    $apariser = '<select name="appraiser_employee_id"  id="appraiser_employee_id"  >';
                    $apariser .= '<option value="">--Please Select--</option>';
                    if (!empty($data['appraiser_list'])) {
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
                    $data['pending_status'] = 'Your KRA not Approved Please Modify and resend KRA.';
                }
                if ($track_status >= '0.2' && $track_status < '1') {
                    $data['appraiser_name_info'] = $apariser_name_info;
                    $data['apariser_name_info_not_approve'] = $apariser_name_info_not_approve;
                    $data['pending_status'] = 'KRA has been submitted to Appraiser for Approval.';
                } else if ($track_status == '1') {
                    $data['pending_status'] = 'KRA Approved By Appraiser.';
                }

                $min_kra_detail = $this->taskschedulemodel->get_min_kra($time_period_id);
                $data['min_kra'] = $min_kra_detail['meta_value'];
                $max_kra_detail = $this->taskschedulemodel->get_max_kra($time_period_id);
                $data['max_kra'] = $max_kra_detail['meta_value'];
                $min_weightage_detail = $this->taskschedulemodel->get_min_weightage($time_period_id);
                $data['min_weightage'] = ''; //$min_weightage_detail['meta_value'];
                $max_weightage_detail = $this->taskschedulemodel->get_max_weightage($time_period_id);
                $data['max_weightage'] = ''; //$max_weightage_detail['meta_value'];


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
                        $data['not_approve_comment'] = $this->apraisermodel->get_not_approve_comment($pms_employee_id, $data['edit_kra_detail'][0]['current_apraiser_id'], $time_period_id);
                    } else {
                        $data['edit_kra_detail'] = $this->apraiseemodel->getEmployeeKraById($this->session->userdata('pms_employee_id'), $time_period_id);
                    }

                    $data['used_kra'] = count($data['temp_kra_detail']);

                    if (!empty($data['edit_kra_detail'])) {

                        $data['edit_total_weight'] = '';
                        foreach ($data['edit_kra_detail'] as $key => $val) {
                            $appraiser_detail = $this->employeemodel->get_employee_by_id($val['current_apraiser_id']);


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



                $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
                $data['top_employee_detail'] = $this->employeemodel->getEmployeeDetailsById($pms_employee_id, $time_period_id);
                // $data['top_employee_apraise'] = $this->employeemodel->getEmployeeApraiserAndReviewer($pms_employee_id, $time_period_id);
                $top_employee_apraiser_detail = $this->employeemodel->getEmployeeApraiserAndReviewer($pms_employee_id, $time_period_id);
                $top_detail_apraiser = '';
                $top_detail_reviewer = '';
                if (!empty($top_employee_apraiser_detail)) {
                    foreach ($top_employee_apraiser_detail as $key_topemp => $val_topemp) {
                        if ($top_detail_apraiser == '') {
                            $top_detail_apraiser = '[ <strong>' . $val_topemp['apraiser_name'] . ' </strong><em>' . $val_topemp['apraiser_designation'] . '</em> ]';
                        } else {
                            $top_detail_apraiser .= ', [ <strong>' . $val_topemp['apraiser_name'] . '</strong><em> ' . $val_topemp['apraiser_designation'] . '</em> ]';
                        }
//                            if($top_detail_reviewer=='')
//                            {
                        $top_detail_reviewer = '[ <strong>' . $val_topemp['reviewer_name'] . '</strong><em> ' . $val_topemp['reviewer_designation'] . '</em> ]';
//                            }
//                            else
//                            {
//                                $top_detail_reviewer .= ', [ <strong>'.$val_topemp['reviewer_name'].'</strong><em> '.$val_topemp['reviewer_designation'].'</em> ]';
//                            }
                    }
                }
                $data['top_employee_apraiser_detail'] = array(
                    'appraiser' => $top_detail_apraiser,
                    'reviewer' => $top_detail_reviewer
                );

                $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
                $result_year = $this->taskschedulemodel->getTimeperiodById(1);
                $display_year = '[' . $result_year->time_period_from . ' - ' . $result_year->time_period_to . ']';
                $data['sub_title'] = 'MY KRA ' . $display_year;
                $data['topmenu'] = $this->topmenu->apraiseemenulist();
                $data['header'] = $this->load->view('default/clientadmin/pdf_cadmin_header', $data, true);

                $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
                // $data['common_js'] = $this->load->view('default/clientadmin/cadmin_main_common_js', $data, true);
                $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);




                $this->load->library('mPDF');
                $mpdf = new mPDF('utf-8', 'A4-L');
                $pdf_data = $this->load->view('default/clientadmin/pdf_cadmin_addkra', $data, true);
                $mpdf->WriteHTML($pdf_data);
                $mpdf->Output('kra-' . date("Y-m-d_His") . '.pdf', 'D');
                //$mpdf->Output();
                exit;
            }
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function pdfaddpms($year = '') {
        if ($this->session->userdata('pms_employee_id')) {
            ini_set('memory_limit', '64M');

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



            $reviewer_id_for_score = '0';
            if (!empty($apraisee_kra_detail)) {
                $reviewer_id_for_score = $apraisee_kra_detail[0]['reviewer_employee_id'];
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




            $submit_status = '0';
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['top_employee_detail'] = $this->employeemodel->getEmployeeDetailsById($pms_employee_id, $time_period_id);
            // $data['top_employee_apraiser_detail'] = $this->employeemodel->getEmployeeApraiserAndReviewer($pms_employee_id, $time_period_id);
            $top_employee_apraiser_detail = $this->employeemodel->getEmployeeApraiserAndReviewer($pms_employee_id, $time_period_id);
            $top_detail_apraiser = '';
            $top_detail_reviewer = '';
            if (!empty($top_employee_apraiser_detail)) {
                foreach ($top_employee_apraiser_detail as $key_topemp => $val_topemp) {
                    if ($top_detail_apraiser == '') {
                        $top_detail_apraiser = '[ <strong>' . $val_topemp['apraiser_name'] . ' </strong><em>' . $val_topemp['apraiser_designation'] . '</em> ]';
                    } else {
                        $top_detail_apraiser .= ', [ <strong>' . $val_topemp['apraiser_name'] . '</strong><em> ' . $val_topemp['apraiser_designation'] . '</em> ]';
                    }
//                            if($top_detail_reviewer=='')
//                            {
                    $top_detail_reviewer = '[ <strong>' . $val_topemp['reviewer_name'] . '</strong><em> ' . $val_topemp['reviewer_designation'] . '</em> ]';
//                            }
//                            else
//                            {
//                                $top_detail_reviewer .= ', [ <strong>'.$val_topemp['reviewer_name'].'</strong><em> '.$val_topemp['reviewer_designation'].'</em> ]';
//                            }
                }
            }
            $data['top_employee_apraiser_detail'] = array(
                'appraiser' => $top_detail_apraiser,
                'reviewer' => $top_detail_reviewer
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

            $data['sub_title'] = 'MY PMS ' . $display_year;
            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['all_ratings'] = $this->taskschedulemodel->getAllRatimgs('1');

            $data['header'] = $this->load->view('default/clientadmin/pdf_cadmin_header', $data, true);
            $data['middle_footer'] = $this->load->view('default/clientadmin/pdf_cadmin_middle_footer', $data, true);

            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);

            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);

            $this->load->library('mPDF');
            $mpdf = new mPDF('utf-8', 'A4-L');
            $pdf_data = $this->load->view('default/clientadmin/pdf_cadmin_addpms', $data, true);
            $mpdf->WriteHTML($pdf_data);
            $mpdf->Output('pms-' . date("Y-m-d_His") . '.pdf', 'D');
            //$mpdf->Output();
            exit;



            $this->load->view('default/clientadmin/cadmin_addpms', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function pdfaddidp($year = '') {
        if ($this->session->userdata('pms_employee_id')) {
            ini_set('memory_limit', '64M');
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
            if (!empty($top_employee_apraiser_detail)) {
                foreach ($top_employee_apraiser_detail as $key_topemp => $val_topemp) {
                    if ($top_detail_apraiser == '') {
                        $top_detail_apraiser = '[ <strong>' . $val_topemp['apraiser_name'] . ' </strong><em>' . $val_topemp['apraiser_designation'] . '</em> ]';
                    } else {
                        $top_detail_apraiser .= ', [ <strong>' . $val_topemp['apraiser_name'] . '</strong><em> ' . $val_topemp['apraiser_designation'] . '</em> ]';
                    }
                    //if($top_detail_reviewer=='')
                    // {
                    $top_detail_reviewer = '[ <strong>' . $val_topemp['reviewer_name'] . '</strong><em> ' . $val_topemp['reviewer_designation'] . '</em> ]';
                    //  }
//                            else
//                            {
//                                $top_detail_reviewer .= ', [ <strong>'.$val_topemp['reviewer_name'].'</strong><em> '.$val_topemp['reviewer_designation'].'</em> ]';
//                            }
                }
            }
            $data['top_employee_apraiser_detail'] = array(
                'appraiser' => $top_detail_apraiser,
                'reviewer' => $top_detail_reviewer
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
            $reviewer_id_for_score = '0';
            $submit_status = '0';
            if (!empty($apraisee_relationship_detail)) {
                $reviewer_id_for_score = $apraisee_relationship_detail[0]['reviewer_employee_id'];
                foreach ($apraisee_relationship_detail as $key => $val) {
                    $submit_status = $val['submit_status'];
                }
            }

            if ($time_period_id == 1) {
                $data['last_score'] = $this->apraiseemodel->get_employee_temp_last_rating($this->session->userdata('pms_employee_id'));
            } else {
                $imediate_prev_year = $this->commonmodel->get_immediate_previous_year();
                $immidiate_year = '0';
                if (!empty($imediate_prev_year)) {
                    $immidiate_year = $imediate_prev_year['time_period_id'];
                }
                $data['last_score'] = $this->apraiseemodel->get_employee_last_year_rating($this->session->userdata('pms_employee_id'), $reviewer_id_for_score, $immidiate_year);
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

            $data['middle_footer'] = $this->load->view('default/clientadmin/pdf_cadmin_middle_footer', $data, true);

            $data['sub_title'] = 'MY IDP ' . $display_year;

            $data['header'] = $this->load->view('default/clientadmin/pdf_cadmin_header', $data, true);

            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            // $data['common_js'] = $this->load->view('default/clientadmin/cadmin_main_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);


            //PDF process
            $this->load->library('mPDF');
            $mpdf = new mPDF('utf-8', 'A4-L');

            $pdf_data = $this->load->view('default/clientadmin/pdf_cadmin_idp', $data, true);

            $mpdf->WriteHTML($pdf_data);
            $mpdf->Output('idp-' . date("Y-m-d_His") . '.pdf', 'D');
            //$mpdf->Output();
            exit;
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    public function pdfpmsratingreport($time_period_id = 1) {
        if ($this->session->userdata('clientadmin_id')) {
            ini_set('memory_limit', '128M');

            $this->load->model('companymodel');
            $data = array();

            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
            //$data['whoiam'] = ucfirst( $data['whoiam']);
            //$data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');

            $data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForReport($pms_employee_id, '1', $time_period_id);
            //echo '<pre>';
            //print_r($data['reviewer_employees']);
            //echo '</pre>';
            //$data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);

            $data['sub_title'] = 'PMS Rating Report';
            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/pdf_cadmin_header', $data, true);

            //$data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            //$data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            //$data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);
            //$this->load->view('default/clientadmin/pdf_cadmin_report_pmsrating', $data);

            $this->load->library('mPDF');
            $mpdf = new mPDF('utf-8', 'A4-L');
            $pdf_data = $this->load->view('default/clientadmin/pdf_cadmin_report_pmsrating', $data, true);
            $mpdf->WriteHTML($pdf_data);
            $mpdf->Output('pms-rating-report-' . date("Y-m-d_His") . '.pdf', 'D');

            exit;
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    public function pdfidpstatusreport($time_period_id = 1) {
        if ($this->session->userdata('clientadmin_id')) {
            ini_set('memory_limit', '128M');

            $this->load->model('companymodel');
            $data = array();

            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
            //$data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');

            $data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForIDP($pms_employee_id, '1');


            //$data['topmenu'] = $this->topmenu->apraiseemenulist();
            //$data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
            //$data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            //$data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            //$data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);
            //$this->load->view('default/clientadmin/cadmin_report_idp', $data);
            //For PDF
            $data['sub_title'] = 'IDP Status Report';
            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/pdf_cadmin_header', $data, true);

            //$data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            //$data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            //$data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);
            //$this->load->view('default/clientadmin/pdf_cadmin_report_pmsrating', $data);

            $this->load->library('mPDF');
            $mpdf = new mPDF('utf-8', 'A4-L');
            $pdf_data = $this->load->view('default/clientadmin/pdf_cadmin_report_idp', $data, true);
            $mpdf->WriteHTML($pdf_data);
            $mpdf->Output('pms-idpsatus-report-' . date("Y-m-d_His") . '.pdf', 'D');
            //$mpdf->Output();

            exit;
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    public function excelpmsratingreport($time_period_id = 1) {
        if ($this->session->userdata('clientadmin_id')) {
            ini_set('memory_limit', '64M');

            $this->load->model('companymodel');
            $data = array();

            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
            //$data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');

            $data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForReport($pms_employee_id, '1', $time_period_id);
            //echo '<pre>';

            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/pdf_cadmin_header', $data, true);
            //$this->load->view('default/clientadmin/excel_cadmin_report_pmsrating', $data);
            //exit();
            //Generate Excel File
            $filename = 'pms-rating-report-' . date("Y-m-d_His");
            $headers = '';
            $excel_data = '';
            $excel_data = $this->load->view('default/clientadmin/excel_cadmin_report_pmsrating', $data, true);
            header('Content-type: application/octet-stream');
            //header("Content-type: application/x-msdownload");
            header("Content-Disposition: attachment; filename=$filename.xls");
            echo "$headers\n$excel_data";


            exit;
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    public function pdfpromotionrecommendationreport($time_period_id = 1) {
        if ($this->session->userdata('clientadmin_id')) {
            ini_set('memory_limit', '64M');

            $this->load->model('companymodel');
            $data = array();

            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
            //$data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');

            $data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForPromotionReport($pms_employee_id, '1');

            $data['sub_title'] = 'Promotion Recommendation Report';
            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/pdf_cadmin_header', $data, true);



            //$data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            //$data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            //$data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);
            //$this->load->view('default/clientadmin/pdf_cadmin_report_promotion', $data);

            $this->load->library('mPDF');
            $mpdf = new mPDF('utf-8', 'A4-L');
            $pdf_data = $this->load->view('default/clientadmin/pdf_cadmin_report_promotion', $data, true);
            $mpdf->WriteHTML($pdf_data);
            $mpdf->Output('pms-promotion-report-' . date("Y-m-d_His") . '.pdf', 'D');
            //$mpdf->Output();
            exit;

            //Old Graph Template: $this->load->view('default/clientadmin/cadmin_new_report', $data);
            //$this->load->view('default/clientadmin/cadmin_footer', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    public function pdfkrastatusreport($time_period_id = 1) {
        if ($this->session->userdata('clientadmin_id')) {
            ini_set('memory_limit', '64M');

            $this->load->model('companymodel');
            $this->load->model('taskschedulemodel');
            $data = array();

            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
            //$data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');
            //$data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForKRAReport($pms_employee_id, '1');
            $data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForKRAReport($pms_employee_id, '1', $time_period_id);

            $data['sub_title'] = 'KRA Status Report';
            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/pdf_cadmin_header', $data, true);

            //Add Year
            $display_year = '';
            if ($time_period_id >= 1) {
                $get_display_time = $this->taskschedulemodel->getTimeperiodById($time_period_id);
                $display_year = $get_display_time->time_period_from . ' - ' . $get_display_time->time_period_to;
            }
            $data['display_year'] = $display_year;

            //$data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            //$data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            //$data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);
            //$this->load->view('default/clientadmin/pdf_cadmin_report_promotion', $data);

            $this->load->library('mPDF');
            $mpdf = new mPDF('utf-8', 'A4-L');
            $pdf_data = $this->load->view('default/clientadmin/pdf_cadmin_report_krastatus', $data, true);
            $mpdf->WriteHTML($pdf_data);
            $mpdf->Output('pms-krastatus-report-' . date("Y-m-d_His") . '.pdf', 'D');
            //$mpdf->Output();
            exit;

            //Old Graph Template: $this->load->view('default/clientadmin/cadmin_new_report', $data);
            //$this->load->view('default/clientadmin/cadmin_footer', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    public function excelpromotionrecommendationreport($time_period_id = 1) {
        if ($this->session->userdata('clientadmin_id')) {
            ini_set('memory_limit', '64M');

            $this->load->model('companymodel');
            $data = array();

            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
            //$data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');

            $data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForPromotionReport($pms_employee_id, '1');


            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/pdf_cadmin_header', $data, true);


            //Generate Excel File
            $filename = 'pms-promotion-report-' . date("Y-m-d_His");
            $headers = '';
            $excel_data = '';
            $excel_data = $this->load->view('default/clientadmin/excel_cadmin_report_promotion', $data, true);
            header('Content-type: application/octet-stream');
            //header("Content-type: application/x-msdownload");
            header("Content-Disposition: attachment; filename=$filename.xls");
            echo "$headers\n$excel_data";


            exit;
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    public function excelkrastatusreport($time_period_id = 1) {
        if ($this->session->userdata('clientadmin_id')) {
            ini_set('memory_limit', '64M');

            $this->load->model('companymodel');
            $this->load->model('taskschedulemodel');
            $data = array();

            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
            //$data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');

            $data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForKRAReport($pms_employee_id, '1', $time_period_id);

            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/pdf_cadmin_header', $data, true);

            //Add Year
            $display_year = '';
            if ($time_period_id >= 1) {
                $get_display_time = $this->taskschedulemodel->getTimeperiodById($time_period_id);
                $display_year = $get_display_time->time_period_from . ' - ' . $get_display_time->time_period_to;
            }
            $data['display_year'] = $display_year;


            //Generate Excel File
            $filename = 'pms-krastatus-report-' . date("Y-m-d_His");
            $headers = '';
            $excel_data = '';
            $excel_data = $this->load->view('default/clientadmin/excel_cadmin_report_krastatus', $data, true);
            header('Content-type: application/octet-stream');
            //header("Content-type: application/x-msdownload");
            header("Content-Disposition: attachment; filename=$filename.xls");
            echo "$headers\n$excel_data";


            exit;
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function pdfstatusreport($report_type = 'appraiser') {
        $employee = array();
        if ($this->session->userdata('pms_employee_id')) {
            ini_set('memory_limit', '64M');

            $employee_list = $this->apraisermodel->getEmployeeApriseelist($this->session->userdata('pms_employee_id'), '1');
            if (!empty($employee_list)) {
                $data['is_employee_apraiser'] = 'Y';
            } else {
                $data['is_employee_apraiser'] = 'N';
            }

            $reviewer_employee_list = $this->reviewermodel->getEmployeeApriseelist($this->session->userdata('pms_employee_id'), '1');

            if (!empty($reviewer_employee_list)) {
                $data['is_employee_reviewer'] = 'Y';
            } else {
                $data['is_employee_reviewer'] = 'N';
            }

            if ($data['is_employee_apraiser'] == 'Y' || $data['is_employee_reviewer'] == 'Y') {

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


                $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
                $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
                $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);

                //For Status Report
                $this->load->model('reportsmodel');
                $empid = $pms_employee_id;
                //for Todo - ajay
                $data['mysubmitstatus'] = $this->reportsmodel->getSubmitStatus($empid);
                $data['whoiam'] = $this->reportsmodel->whoiam($empid);
                //Check for not related emp
                $data['nonrelatedemp'] = $this->reportsmodel->getNonrelatedEmp();

                $data['rpt_employees'] = $this->apraisermodel->getEmployeeApriseelist($empid, '1');
                $data['rpt_reviewer_employees'] = $this->reviewermodel->getEmployeeApriseelist($empid, '1');
                $data['graph_summery'] = $this->reportsmodel->getSubmitStatusAll();
                $data['graph_appraiser'] = $this->reportsmodel->getSubmitStatusAll($empid, 'appraiser');
                $data['graph_reviewer'] = $this->reportsmodel->getSubmitStatusAll($empid, 'reviewer');

                //Calling Final TPL
                //$data['todoinfo'] = $this->load->view('default/clientadmin/cadmin_todo_list', $data, true);
                $data['sub_title'] = 'PMS Status Report';
                $data['topmenu'] = $this->topmenu->apraiseemenulist();
                $data['header'] = $this->load->view('default/clientadmin/pdf_cadmin_header', $data, true);

                if ($report_type == 'appraiser') {
                    $this->load->library('mPDF');
                    $mpdf = new mPDF('utf-8', 'A4-L');
                    $pdf_data = $this->load->view('default/clientadmin/pdf_cadmin_status_report_appraiser', $data, true);
                    $mpdf->WriteHTML($pdf_data);
                    $mpdf->Output('pms-status-report-appraiser-' . date("Y-m-d_His") . '.pdf', 'D');
                    //$mpdf->Output();
                } else {
                    $this->load->library('mPDF');
                    $mpdf = new mPDF('utf-8', 'A4-L');
                    $pdf_data = $this->load->view('default/clientadmin/pdf_cadmin_status_report_reviewer', $data, true);
                    $mpdf->WriteHTML($pdf_data);
                    $mpdf->Output('pms-status-report-reviewer-' . date("Y-m-d_His") . '.pdf', 'D');
                }
                exit;

                //$this->load->view('default/clientadmin/pdf_cadmin_status_report', $data);
            } else {
                redirect('accessdenied', 'refresh');
            }
        } else {
            redirect('clientadmin', 'refresh');
        }
        //}
    }

    function excelstatusreport($report_type = 'appraiser') {
        $employee = array();
        $data = array();
        if ($this->session->userdata('pms_employee_id')) {

            ini_set('memory_limit', '64M');

            $employee_list = $this->apraisermodel->getEmployeeApriseelist($this->session->userdata('pms_employee_id'), '1');
            if (!empty($employee_list)) {
                $data['is_employee_apraiser'] = 'Y';
            } else {
                $data['is_employee_apraiser'] = 'N';
            }

            $reviewer_employee_list = $this->reviewermodel->getEmployeeApriseelist($this->session->userdata('pms_employee_id'), '1');

            if (!empty($reviewer_employee_list)) {
                $data['is_employee_reviewer'] = 'Y';
            } else {
                $data['is_employee_reviewer'] = 'N';
            }

            if ($data['is_employee_apraiser'] == 'Y' || $data['is_employee_reviewer'] == 'Y') {


                $status = '1';
                $pms_employee_id = $this->session->userdata('pms_employee_id');
                $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
                $data['myname'] = $this->session->userdata('username');

                $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
                $data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');
                $data['reviewer_employees'] = $this->reviewermodel->getEmployeeApriseelist($pms_employee_id, '1');
                $data['approvel_employees'] = $this->apraisermodel->get_kra_approvel_appraisee_list($pms_employee_id, '1');

                $employee_ids = $this->apraisermodel->getEmplyeeIdsByApraiserID($pms_employee_id, '1');
                //print_r($employee_ids);

                $this->load->model('companymodel');
                $data['employee'] = $data['employees'];
                $data['site_name'] = $this->generalesettings->getSiteName();
                $data['logo'] = $this->generalesettings->getImage();
                $data['company_master'] = $this->companymodel->getCompaniesHavingOfficeType();
                $data['departments'] = $this->companymodel->getDepartments();


                $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
                $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
                $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);

                //For Status Report
                $this->load->model('reportsmodel');
                $empid = $pms_employee_id;
                //for Todo - ajay
                $data['mysubmitstatus'] = $this->reportsmodel->getSubmitStatus($empid);
                //$data['whoiam'] = $this->reportsmodel->whoiam($empid);
                //Check for not related emp
                $data['nonrelatedemp'] = $this->reportsmodel->getNonrelatedEmp();

                $data['rpt_employees'] = $this->apraisermodel->getEmployeeApriseelist($empid, '1');
                $data['rpt_reviewer_employees'] = $this->reviewermodel->getEmployeeApriseelist($empid, '1');
                $data['graph_summery'] = $this->reportsmodel->getSubmitStatusAll();
                $data['graph_appraiser'] = $this->reportsmodel->getSubmitStatusAll($empid, 'appraiser');
                $data['graph_reviewer'] = $this->reportsmodel->getSubmitStatusAll($empid, 'reviewer');

                //Calling Final TPL
                //$data['todoinfo'] = $this->load->view('default/clientadmin/cadmin_todo_list', $data, true);

                $data['topmenu'] = $this->topmenu->apraiseemenulist();
                $data['header'] = $this->load->view('default/clientadmin/pdf_cadmin_header', $data, true);

                if ($report_type == 'appraiser') {
                    //Generate Excel File
                    $filename = 'pms-status-report-appraiser-' . date("Y-m-d_His");
                    $headers = '';
                    $excel_data = '';
                    $excel_data = $this->load->view('default/clientadmin/excel_cadmin_status_report_appraiser', $data, true);
                    header('Content-type: application/octet-stream');
                    //header("Content-type: application/x-msdownload");
                    header("Content-Disposition: attachment; filename=$filename.xls");
                    echo "$headers\n$excel_data";
                } else {

                    $filename = 'pms-status-report-reviewer-' . date("Y-m-d_His");
                    $headers = '';
                    $excel_data = '';
                    $excel_data = $this->load->view('default/clientadmin/excel_cadmin_status_report_reviewer', $data, true);
                    header('Content-type: application/octet-stream');
                    //header("Content-type: application/x-msdownload");
                    header("Content-Disposition: attachment; filename=$filename.xls");
                    echo "$headers\n$excel_data";
                }
                exit;

                //$this->load->view('default/clientadmin/pdf_cadmin_status_report', $data);
            } else {
                redirect('accessdenied', 'refresh');
            }
        } else {
            redirect('clientadmin', 'refresh');
        }
        //}
    }

    public function completereplort($apraisee_employee_id, $reviewer_employee_id,$time_period_id = 1, $output_method ='pdf') {
        //display Complete Report
        $data = array();
        //$time_period_id = '1';
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
            $pms_employee_id = $reviewer_employee_id;
            //echo '<br>Reviewer Id: ' . $pms_employee_id ;
            //die();
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
                ////$reviewer_employee_id = $pms_employee_id;
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
                    $data['last_score'] = $this->apraiseemodel->get_employee_temp_last_rating($reviewer_employee_id); //Change to Reviewer id - Ajay
                } else {
                    $imediate_prev_year = $this->commonmodel->get_immediate_previous_year();
                    $immidiate_year = '0';
                    if (!empty($imediate_prev_year)) {
                        $immidiate_year = $imediate_prev_year['time_period_id'];
                    }
                    $data['last_score'] = $this->apraiseemodel->get_employee_last_year_rating($reviewer_employee_id, $reviewer_id_for_score, $immidiate_year); //Change to Reviewer Id - Ajay
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
                        AND reviewer_employee_id='" . $reviewer_employee_id . "' 
                        AND time_period_id='" . $time_period_id . "' ";

                $query = $this->db->query($sql);
                $reviewer_overall_rating = $query->first_row();
                //$reviewer_date = date($data['s_date_format'], strtotime($reviewer_overall_rating->date_created));
                $reviewer_date = date($data['s_date_format'], strtotime(date("Y-m-d")));

                //Fixed apraiser_date
                $data['apraiser_date'] = $apraiser_date = '';

                //apraiser overall rating score
                $data['apraiser_overall_kra_score'] = $this->reviewermodel->getApraiserTotalKraScore($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
                $data['apraiser_overall_competencies_score'] = $this->reviewermodel->getApraiserTotalCompetenciesScore($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
                $data['apraiser_overall_performance_score'] = (($data['apraiser_overall_kra_score']) + ($data['apraiser_overall_competencies_score']));
                $data['apraiser_overall_performance_score_name'] = $this->reviewermodel->getScoreNameByScore($data['apraiser_overall_performance_score']);
                
                


                if (!empty($apraisee_relationship_detail) && $apraisee_relationship_detail['submit_status'] == '6') {

                    //$data['kra_detail'] = $this->reviewermodel->getApraiserKraPmsDetail($apraisee_employee_id, $apraiser_employee_id);
                    //Added By Ajay
                    $data['kra_detail'] = $this->reviewermodel->getApraiserKraPmsDetailMultiple($apraisee_employee_id, $arr_apraiser_list);

                    $data['employee_name'] = $employee_detail->fname . ' ' . $employee_detail->lname;
                } elseif (!empty($apraisee_relationship_detail) && $apraisee_relationship_detail['submit_status'] > '6') {

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
                        $data['competency_with_idp_detail'] = $this->display_reviewer_competencies($apraisee_employee_id, $reviewer_employee_id, $employee_detail->grade_id);
                        


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
                        } elseif ($data['overall_performance_score'] > 2 && $data['overall_performance_score'] <= 2.79) {
                            $data['reviewer_assessment_score'] = 'NI';
                        } elseif ($data['overall_performance_score'] > 2.80 && $data['overall_performance_score'] <= 3.49) {
                            $data['reviewer_assessment_score'] = 'ME';
                        } elseif ($data['overall_performance_score'] > 3.50 && $data['overall_performance_score'] <= 4.24) {
                            $data['reviewer_assessment_score'] = 'EE';
                        } elseif ($data['overall_performance_score'] > 4.25 && $data['overall_performance_score'] <= 5.00) {
                            $data['reviewer_assessment_score'] = 'FEE';
                        }
                    } elseif ($apraisee_relationship_detail['submit_status'] >= '8') {

                        $data['error'] = 'Please Fill Up Appraiser KRA form First';
                    }
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

            $data['new_competencies_for_refrence'] = $this->display_reviewer_competencies($apraisee_employee_id, $reviewer_employee_id, $employee_detail->grade_id);

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
            //echo '<pre>';
            //print_r($data['competencies_for_refrence']);
            //echo '</pre>';
            
            $data['all_ratings'] = $this->taskschedulemodel->getAllRatimgs('1');
            $data['idp_detail'] = $this->apraiseemodel->getAllIdpsOfApraisee($apraisee_employee_id, $time_period_id);
            $data['ratings_for_refrence'] = $this->apraisermodel->getAllRatings('1');
            $data['apraisee_employee_id'] = $apraisee_employee_id;
            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            
            
            $data['sub_title'] = 'Complete PMS Report';
            //.$data['top_employee_detail']['fname'].' '.$data['top_employee_detail']['lname']; 
            $empname = $data['top_employee_detail']['fname'].'_'.$data['top_employee_detail']['lname']; 
            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/pdf_cadmin_header', $data, true);

            $pdf_data = $this->load->view('default/clientadmin/pdf_cadmin_reviewer_complete', $data,true);
            
            //echo $pdf_data ;
            
            //For PDF
            
            if( $output_method == 'pdf' ) {
            
            $this->load->library('mPDF');
            $mpdf = new mPDF('utf-8', 'A4-L');
            //$pdf_data = $this->load->view('default/clientadmin/pdf_cadmin_reviewer_complete', $data, true);
            $mpdf->WriteHTML($pdf_data);
            $mpdf->Output($empname .'_pms-report-' . date("Y-m-d_His") . '.pdf', 'D');
            }
            else {
                echo $pdf_data ;
            }
            exit;
            
            
            
        } else {
            redirect('clientadmin', 'refresh');
        }


        //Template pdf_cadmin_reviewer_complete
    }

	
	/*** KRA For 2013-14 ***/
function pdfkra201314($employee_id, $year = '') { 
        if ($employee_id) {
		
            //TODO: Fix - Increase memory limit for PDF generate
            ini_set('memory_limit', '64M');

            $data = array();
            $time_period_id = $year;
            $data['time_period_id'] = $time_period_id;
            $data['total_weight'] = '100';
            $data['edit_total_weight'] = '0';
            $data['appraiser_list'] = '';
            $valid_time_period_ids = $this->taskschedulemodel->get_employee_valid_time_period($employee_id);
            if ($year == '') {
                $data['year'] = "Page Not Found.";
                die();
            } else if (!in_array($year, $valid_time_period_ids)) {
                redirect('accessdenied', 'refresh');
            } else {
                $is_relationship_added = $this->apraiseemodel->is_employee_relationship_added($employee_id, $time_period_id);

                if ($is_relationship_added <= 0) {
                    $data['error'] = 'Please Add Employee Relationship First.';
                }

                $data['site_name'] = $this->generalesettings->getSiteName();
                $data['logo'] = $this->generalesettings->getImage();
                $pms_employee_id = $employee_id;

                $employee_relationship_materix_id = '0';
                $employee_relationship_materix_detail = $this->apraiseemodel->getRelationshipDetailOfEmployee($pms_employee_id, $time_period_id);

                $submit_status = '';
                $data['appraiser'] = '';
                $apariser_name_info = '';
                $apariser_name_info_not_approve = '';

                if (!empty($employee_relationship_materix_detail)) {
                    foreach ($employee_relationship_materix_detail as $keyer => $valer) {
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
                    $apariser = '<select name="appraiser_employee_id"  id="appraiser_employee_id"  >';
                    $apariser .= '<option value="">--Please Select--</option>';
                    if (!empty($data['appraiser_list'])) {
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
                    $data['pending_status'] = 'Your KRA not Approved Please Modify and resend KRA.';
                }
                if ($track_status >= '0.2' && $track_status < '1') {
                    $data['appraiser_name_info'] = $apariser_name_info;
                    $data['apariser_name_info_not_approve'] = $apariser_name_info_not_approve;
                    $data['pending_status'] = 'KRA has been submitted to Appraiser for Approval.';
                } else if ($track_status == '1') {
                    $data['pending_status'] = 'KRA Approved By Appraiser.';
                }

                $min_kra_detail = $this->taskschedulemodel->get_min_kra($time_period_id);
                $data['min_kra'] = $min_kra_detail['meta_value'];
                $max_kra_detail = $this->taskschedulemodel->get_max_kra($time_period_id);
                $data['max_kra'] = $max_kra_detail['meta_value'];
                $min_weightage_detail = $this->taskschedulemodel->get_min_weightage($time_period_id);
                $data['min_weightage'] = ''; //$min_weightage_detail['meta_value'];
                $max_weightage_detail = $this->taskschedulemodel->get_max_weightage($time_period_id);
                $data['max_weightage'] = ''; //$max_weightage_detail['meta_value'];


                if ($track_status >= '0.2') {
                    $temp_valkd = array();
                    $data['kra_detail'] = $this->apraiseemodel->getEmployeeKraById($employee_id, $time_period_id);

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

                } else {
                    $data['used_kra'] = '0';
                    $data['max_weight_for_edit'] = 100;
                    $data['temp_kra_detail'] = $this->apraiseemodel->getEmployeeKraById($employee_id, $time_period_id);

                    if ($track_status == '0.1') {
                        //echo "hi";die();
                        $data['edit_kra_detail'] = $this->apraiseemodel->get_kra_by_aproove_status($pms_employee_id, '0', $time_period_id);
                        $data['min_kra'] = count($data['edit_kra_detail']);
                        //$data['max_kra'] = count($data['edit_kra_detail']);
                        $data['not_approve_comment'] = $this->apraisermodel->get_not_approve_comment($pms_employee_id, $data['edit_kra_detail'][0]['current_apraiser_id'], $time_period_id);
                    } else {
                        $data['edit_kra_detail'] = $this->apraiseemodel->getEmployeeKraById($employee_id, $time_period_id);
                    }

                    $data['used_kra'] = count($data['temp_kra_detail']);

                    if (!empty($data['edit_kra_detail'])) {

                        $data['edit_total_weight'] = '';
                        foreach ($data['edit_kra_detail'] as $key => $val) {
                            $appraiser_detail = $this->employeemodel->get_employee_by_id($val['current_apraiser_id']);


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

                $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
                $data['top_employee_detail'] = $this->employeemodel->getEmployeeDetailsById($pms_employee_id, $time_period_id);
                $top_employee_apraiser_detail = $this->employeemodel->getEmployeeApraiserAndReviewer($pms_employee_id, $time_period_id);
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

                $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
                $result_year = $this->taskschedulemodel->getTimeperiodById($year);
                $display_year = '[' . $result_year->time_period_from . ' - ' . $result_year->time_period_to . ']';
                $data['sub_title'] = 'MY KRA ' . $display_year;
                $data['topmenu'] = $this->topmenu->apraiseemenulist();
                $data['header'] = $this->load->view('default/clientadmin/pdf_cadmin_header', $data, true);

                $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
                // $data['common_js'] = $this->load->view('default/clientadmin/cadmin_main_common_js', $data, true);
                $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);




                $this->load->library('mPDF');
                $mpdf = new mPDF('utf-8', 'A4-L');
                $pdf_data = $this->load->view('default/clientadmin/pdf_cadmin_addkra', $data, true);
                $mpdf->WriteHTML($pdf_data);
                $mpdf->Output( 'kra201314-'. trim($data['top_employee_detail']['fname']).'_'.trim($data['top_employee_detail']['lname']) . date("Y-m-d_His") . '.pdf', 'D');
                //$mpdf->Output();
                exit;
            }
        } else {
            redirect('clientadmin', 'refresh');
        }
		
		
		   
    }

	/*** End KRA ***/
	
	
	
	
    /*     * * Supporting Functions ** */

    //TODO: Fixed - Remove Duplicate
public function display_reviewer_competencies($apraisee_employee_id , $reviewer_id, $grade_id = '') {
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


        //$reviewer_id = $this->session->userdata('pms_employee_id');
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
        $output['overall_total'] = $overall_kra_score + $overall_competency_score;

        return $output;
    }

    /*     * * End Supporting Functions ** */
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */