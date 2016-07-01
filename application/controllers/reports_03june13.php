<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();
        //  $this->dashboard();
        $this->topmenu->no_cache();
        $this->load->model('generalesettings');
        $this->load->model('employeemodel');
        $this->load->model('commonmodel');
        $this->load->model('companymodel');
        $this->load->model('apraisermodel');
        $this->load->model('reportsmodel');
        $this->load->model('apraiseemodel');
        $this->load->model('taskschedulemodel');
        if (!$this->session->userdata('pms_employee_id')) {
            redirect('clientadmin', 'refresh');
        }
    }

    public function pmsratingreport($time_period_id = 1) {
        if ($this->session->userdata('clientadmin_id')) {

            $this->load->model('companymodel');
            $data = array();

            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
            //$data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');

            $data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForReport($pms_employee_id, '1');
            //echo '<pre>';
            //print_r($data['reviewer_employees']);
            //echo '</pre>';
            //$data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);

            $data['topmenu'] = $this->topmenu->apraiseemenulist();

            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);

            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);


            $this->load->view('default/clientadmin/cadmin_report_pmsrating', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    public function bellcurve($time_period_id = 1) {
        if ($this->session->userdata('clientadmin_id')) {

            $this->load->model('companymodel');
            $this->load->model('reportsmodel');
            $data = array();

            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
            //$data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');

            $data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForReport($pms_employee_id, '1');
            //echo '<pre>';
            //print_r($data['reviewer_employees']);
            //echo '</pre>';
            //$data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);

            $data['business_list'] = $this->reportsmodel->getActiveBusinessList();


            $data['topmenu'] = $this->topmenu->apraiseemenulist();

            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);

            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);


            $this->load->view('default/clientadmin/cadmin_report_bellcurve', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    public function idpreport($time_period_id = 1) {
        if ($this->session->userdata('clientadmin_id')) {

            $this->load->model('companymodel');
            $data = array();

            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
            //$data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');

            $data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForIDP($pms_employee_id, '1');


            $data['topmenu'] = $this->topmenu->apraiseemenulist();

            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);

            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);


            $this->load->view('default/clientadmin/cadmin_report_idp', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    public function promotionrecommendationreport($time_period_id = 1) {
        if ($this->session->userdata('clientadmin_id')) {

            $this->load->model('companymodel');
            $data = array();

            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
            //$data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');

            $data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForPromotionReport($pms_employee_id, '1');
            //echo '<pre>';
            //print_r($data['reviewer_employees']);
            //echo '</pre>';
            //$data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);

            $data['topmenu'] = $this->topmenu->apraiseemenulist();

            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);

            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);


            $this->load->view('default/clientadmin/cadmin_report_promotion', $data);


            //Old Graph Template: $this->load->view('default/clientadmin/cadmin_new_report', $data);
            //$this->load->view('default/clientadmin/cadmin_footer', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    public function krastatusreport($time_period_id = 1) {
        if ($this->session->userdata('clientadmin_id')) {

            $this->load->model('companymodel');
            $data = array();

            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['whoiam'] = $this->reportsmodel->whoiam($pms_employee_id);
            //$data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');

            $data['reviewer_employees'] = $this->reportsmodel->getEmployeeApriseelistForKRAReport($pms_employee_id, '1');
            //echo '<pre>';
            //print_r($data['reviewer_employees']);
            //echo '</pre>';
            //$data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);

            $data['topmenu'] = $this->topmenu->apraiseemenulist();

            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);

            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);


            $this->load->view('default/clientadmin/cadmin_report_krastatus', $data);


            //Old Graph Template: $this->load->view('default/clientadmin/cadmin_new_report', $data);
            //$this->load->view('default/clientadmin/cadmin_footer', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    public function index($tab = '', $tabid = '') {


        if ($this->session->userdata('clientadmin_id')) {

            $this->dashboard();
        } else {
            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['action'] = site_url('clientadmin/clientadminlogin');
            $data['button'] = 'Submit';
            $data['button_text'] = 'Login';
            $data['logo'] = $this->generalesettings->getImage();

            $this->load->view('default/clientadmin/user_topbar_sw', $data);
            $this->load->view('default/clientadmin/user_login_sw', $data);
        }
    }

    public function get_template_info() {
        //echo 'Template info' ;
        $json['tpl_subject'] = 'Email Subject';
        $json['tpl_code'] = 'TPL330';
        $json['tpl_body'] = 'This is template body';

        echo json_encode($json);
    }

    /*
     * ****************************************
     * Environment Settings
     * ****************************************
     */

    //client profile
    public function old_profile() {

        if ($this->session->userdata('clientadmin_id')) {

            $data = array();
            $this->load->model('clientadminmodel');
            $row = $this->clientadminmodel->getClientAdminById(trim($this->session->userdata('clientadmin_id')));
            $data['clientinfo'] = $row;
            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $this->load->view('default/clientadmin/cadmin_header');
            $this->load->view('default/clientadmin/cadmin_profile', $data);
            $this->load->view('default/clientadmin/cadmin_footer', $data);
        }
    }

    function old_dashboard() {
        if ($this->session->userdata('pms_employee_id')) {
            $this->load->model('companymodel');
            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            $this->load->view('default/clientadmin/cadmin_dashboard', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function dashboard() {
        if ($this->session->userdata('pms_employee_id')) {
            $empid = $this->session->userdata('pms_employee_id');
            $this->load->model('companymodel');
            $this->load->model('reportsmodel');
            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $data['topmenu'] = $this->topmenu->apraiseemenulist();

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
            $data['todoinfo'] = $this->load->view('default/clientadmin/cadmin_todo_list', $data, true);


            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            $this->load->view('default/clientadmin/cadmin_dashboard', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function updateemployee($id = '') {
        if ($this->session->userdata('clientadmin_id')) {
            $this->load->model('companymodel');
            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();
            $data['company_master'] = $this->companymodel->getCompaniesHavingOfficeType();
            $data['departments'] = $this->companymodel->getDepartments();
            $this->load->view('default/clientadmin/cadmin_header', $data);
            $this->load->view('default/clientadmin/cadmin_addemployee', $data);
            $this->load->view('default/clientadmin/cadmin_middle_footer', $data);
            $this->load->view('default/clientadmin/cadmin_common_js', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function reports2() {

        if ($this->session->userdata('clientadmin_id')) {
            $this->load->model('companymodel');
            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();
            $this->load->view('default/clientadmin/cadmin_header', $data);
            $this->load->view('default/clientadmin/cadmin_reports', $data);

            //$this->load->view('default/clientadmin/cadmin_footer', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function newreports() {

        if ($this->session->userdata('clientadmin_id')) {
            $this->load->model('companymodel');
            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();


            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');
            $data['reviewer_employees'] = $this->reviewermodel->getEmployeeApriseelist($pms_employee_id, '1');


            //$data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);


            $data['topmenu'] = $this->topmenu->apraiseemenulist();

            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);

            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);
            $this->load->view('default/clientadmin/cadmin_report_1', $data);



            //Old Graph Template: $this->load->view('default/clientadmin/cadmin_new_report', $data);
            //$this->load->view('default/clientadmin/cadmin_footer', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    //for pms start
    function getdesignationgrade() {
        $response = array();
        $designation_id = $this->input->post('designation_id', true);
        $grade_deatil = $this->companymodel->getGradeByDesignationId($designation_id);
        if (!empty($grade_deatil)) {
            $response['grade'] = array('grade_id' => $grade_deatil->grade_id, 'grade_name' => $grade_deatil->grade_name);
        }
        die(json_encode($response));
    }

    /** Supporting functions * */
//TODO: Fixed - Remove Duplicate

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

        return $output;
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

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */