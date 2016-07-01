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

            $data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForReport($pms_employee_id, '1',$time_period_id);
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

            $data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForReport($pms_employee_id, '1',$time_period_id);
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
            $data = array();

            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
            //$data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');

            //$data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForKRAReport($pms_employee_id, '1');
            $data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForKRAReport($pms_employee_id, '1',$time_period_id);

            $data['sub_title'] = 'KRA Status Report';
            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/pdf_cadmin_header', $data, true);



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
            $data = array();

            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
            //$data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');

            $data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForKRAReport($pms_employee_id, '1',$time_period_id);


            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/pdf_cadmin_header', $data, true);


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

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */