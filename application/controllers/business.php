<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business extends CI_Controller {

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
        $this->load->model('generalesettings');
        $this->load->model('businessmodel');
    }

    public function index($tab = '', $tabid = '') {
        
    }

    function business() {
        if ($this->session->userdata('pms_employee_id')) {
            $empid = $this->session->userdata('pms_employee_id');


            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $data['topmenu'] = $this->topmenu->apraiseemenulist();

            $data['business_list'] = $this->businessmodel->getAllbusinesss();

            $data['business_details'] = $this->load->view('default/clientadmin/cadmin_business_list', $data, true);

            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_beoro_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            $this->load->view('default/clientadmin/cadmin_business', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function ajax_addbusiness() {
        //print_r($_POST);
        extract($_POST);
        $response = array();
        $response['status'] = 'N';
        $response['msg'] = 'Error in process. Please try later.';
        $business_desc = '';

        if ($business_id <= 0) {
            //New Entry
            $datainsert = array(
                'business_subject' => $business_subject,
                'business_desc' => $business_desc,
                'date_created' => date("Y-m-d H:i:s")
            );
            $this->db->insert($this->db->dbprefix . "business", $datainsert);
            $response['msg'] = 'Record is added successfully.';
            $response['status'] = 'Y';
        } else {
            //Update Entry
            $this->businessmodel->doupdate($business_id, $business_subject);
            $response['msg'] = 'Record is Updated Successfully.';
            $response['status'] = 'Y';
        }

        die(json_encode($response));
    }

    function ajax_getbusinesslist() {
        $response = array();
        $response['business_list_data'] = $this->businessmodel->getAllbusinesss();

        $response['business_details'] = $this->load->view('default/clientadmin/cadmin_business_list', $response, true);

        die(json_encode($response));
    }

    function ajax_suspend() {
        $response = array();
        $business_id = $_POST['business_id'];

        $isExists = $this->businessmodel->isBusinessIdExists($business_id);
        if ($isExists >= 1) {
            $response['result'] = 0;
            $response['status'] = 'N';
            $response['msg'] = 'Business is associated with company. Unable to suspended.';
        } else {
            $result = $this->businessmodel->dosuspend($business_id);

            $response['result'] = $result;
            $response['status'] = 'Y';
            $response['msg'] = 'Record is suspended.';
        }

        die(json_encode($response));
    }

    function ajax_active() {
        $response = array();
        $business_id = $_POST['business_id'];
        $result = $this->businessmodel->doactive($business_id);

        $response['result'] = $result;
        $response['status'] = 'Y';
        $response['msg'] = 'Record is Activated.';

        die(json_encode($response));
    }

    function ajax_delete() {
        $response = array();
        $business_id = $_POST['business_id'];
        $result = $this->businessmodel->dodelete($business_id);

        $response['result'] = $result;
        $response['status'] = 'Y';
        $response['msg'] = 'Record is Deleted Successfully.';

        die(json_encode($response));
    }

    function ajax_getinfo() {
        $response = array();
        $business_id = $_POST['business_id'];
        $result = $this->businessmodel->getAllbusinesss($business_id);
        //print_r($result);

        $response['result'] = $result[0]->business_subject;


        die(json_encode($response));
    }

    function getbusinesscompanylist() {
        $response = array();
        $selected_elem = $_POST['selected_elem'];
        //1 = Business
        //2 = Company

        $output = '';

        if ($selected_elem == 1) {
            $sql = "SELECT * FROM " . $this->db->dbprefix . "business WHERE is_active = 1 ORDER BY business_subject ";
            $query = $this->db->query($sql);

            foreach ($query->result() as $key => $val) {
                $output .= '<option value="' . $val->business_id . '">' . $val->business_subject . '</option>';
            }
        }

        if ($selected_elem == 2) {
            $sql = "SELECT * FROM " . $this->db->dbprefix . "company_master WHERE status = 1 ORDER BY company_name ";
            $query = $this->db->query($sql);

            foreach ($query->result() as $key => $val) {
                $output .= '<option value="' . $val->company_master_id . '">' . $val->company_name . '</option>';
            }
        }

        $response['selected_elem'] = $selected_elem;
        $response['output'] = $output;

        die(json_encode($response));
    }

    //function 
    function getBusinessIdsByCompany() {

        //Company id
        $company_id = $this->input->post('company_id');

        //$sql = "SELECT * FROM " . $this->db->dbprefix . "business_to_company WHERE company_master_id us = 1 ORDER BY company_name " ;
        $sql = "SELECT btoc.id, btoc.business_id, btoc.company_master_id, b.business_subject
                FROM  " . $this->db->dbprefix . "business_to_company btoc, " . $this->db->dbprefix . "business b
                WHERE btoc.business_id = b.business_id 
                AND btoc.company_master_id= '" . $company_id . "' ";


        $query = $this->db->query($sql);

        //$row = $query->first_row();
        $outputIds = array();
        $output = '';
        $output_all = '';
        foreach ($query->result() as $key => $val) {
            //$output .= "<option value='" . $val->department_id . "'>" . $val->department_name . "</option>";
            $outputIds[] = $val->business_id;
        }
        //$output = implode(",",$outputIds );
        $response = array();

        //List All Business
        $sql = "SELECT * FROM " . $this->db->dbprefix . "business ORDER By business_subject ";
        $query = $this->db->query($sql);

        //print_r($office_address) ;
        foreach ($query->result() as $key => $val) {
            //if(!in_array($val->department_id , $outputIds) ){
            $output_all .= '<option value="' . $val->business_id . '">' . $val->business_subject . '</option>';
            //}
        }

        //$response['dept'] = $row ;
        //$response['query'] = $last_query ;
        $response['select_list'] = $outputIds;
        $response['nonselect_list'] = $output_all;

        die(json_encode($response));
        //return $row ;
    }

    function getCompanyIdsByBusiness() {

        //Company id
        $business_id = $this->input->post('business_id');

        //$sql = "SELECT * FROM " . $this->db->dbprefix . "business_to_company WHERE company_master_id us = 1 ORDER BY company_name " ;
        $sql = "SELECT btoc.id, btoc.business_id, btoc.company_master_id, b.business_subject
                FROM  " . $this->db->dbprefix . "business_to_company btoc, " . $this->db->dbprefix . "business b
                WHERE btoc.business_id = b.business_id 
                AND btoc.business_id= '" . $business_id . "' ";


        $query = $this->db->query($sql);

        //$row = $query->first_row();
        $outputIds = array();
        $output = '';
        $output_all = '';
        foreach ($query->result() as $key => $val) {
            $outputIds[] = $val->company_master_id;
        }
        //$output = implode(",",$outputIds );
        $response = array();

        //List All Companies
        $sql = "SELECT * FROM " . $this->db->dbprefix . "company_master ORDER By company_name ";
        $query = $this->db->query($sql);

        //print_r($office_address) ;
        foreach ($query->result() as $key => $val) {
            //if(!in_array($val->department_id , $outputIds) ){
            $output_all .= '<option value="' . $val->company_master_id . '">' . $val->company_name . '</option>';
            //}
        }

        $response['select_list'] = $outputIds;
        $response['nonselect_list'] = $output_all;

        die(json_encode($response));
        //return $row ;
    }

    public function savebusinesscompany() {
        //echo '<pre>';
        //print_r($_POST);
        //echo '</pre>';
        //extract($POST);
        $response = array();

        $select_list_business_company = $_POST['select_list_business_company'];
        $select_from_business_company = $_POST['select_from_business_company'];
        $select_business_company = $_POST['select_business_company'];


        if ($select_business_company == 1) {
            //Update for Business
            //Remove business for id - select_from_business_company
            $this->db->delete($this->db->dbprefix . 'business_to_company', array('business_id' => $select_from_business_company));

            //Add Revords
            //select_list_business_company
            foreach ($select_list_business_company as $key => $val) {
                //Insert each row for office
                //print_r($val);
                $data = array('business_id' => $select_from_business_company, 'company_master_id' => $val);
                $result = $this->db->insert($this->db->dbprefix . 'business_to_company', $data);
            }
        }

        if ($select_business_company == 2) {
            //Update for Business
            //Remove business for id - select_from_business_company
            $this->db->delete($this->db->dbprefix . 'business_to_company', array('company_master_id' => $select_from_business_company));

            //Add Revords
            //select_list_business_company
            foreach ($select_list_business_company as $key => $val) {
                //Insert each row for office
                //print_r($val);
                $data = array('company_master_id' => $select_from_business_company, 'business_id' => $val);
                $result = $this->db->insert($this->db->dbprefix . 'business_to_company', $data);
            }
        }


        $response['status'] = 'Y';
        $response['msg'] = 'Business - Company mapping updated.';
        die(json_encode($response));
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */