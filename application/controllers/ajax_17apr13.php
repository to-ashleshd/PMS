<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 */
class Ajax extends CI_Controller {

//konstruktor klasy
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('users');
    }

    public function getstate() {
        $country = $this->input->post('country', true);
        // $country =99;
        $output = '';
        $output = "<option value=''>--Please Select--</option>";
        if ($country == 99) {

            $this->load->model('commonmodel');
            $state_result = $this->commonmodel->getDropDownSQL($country);
            foreach ($state_result as $key => $val) {
                $output .= "<option value='" . $val->statemaster_id . "' >" . $val->state_name . "</option>";
            }
        } else {
            // $statemaster = array();
        }
        // $response['country_id'] = $country;
        $response['state'] = $output;
        die(json_encode($response));
    }

    public function getcity() {
        $country = $this->input->post('country', true);
        $state = $this->input->post('state', true);
        //$country =99;
        // $state= 1493;
        $output = '';
        $output = "<option value=''>--Please Select--</option>";
        if ($country == 99 && $state == 1493) {


            $this->load->model('commonmodel');
            $state_result = $this->commonmodel->getDropDownSQL($country, $state);
            foreach ($state_result as $key => $val) {
                $output .= "<option value='" . $val->citymaster_id . "' >" . $val->city_name . "</option>";
            }
        } else {
            // $statemaster = array();
        }

        $response['city'] = $output;
        die(json_encode($response));
    }

    public function getCountryInfo() {
        $response = array();
        $country_id = $this->input->post('country', true);
        $this->load->model('countrymodel');
        $result = $this->countrymodel->getCountry($country_id);
        if (!empty($result)) {
            $response['country_id'] = $result->countrymaster_id;
            $response['country_name'] = $result->country_name;
            $response['country_isocode1'] = $result->iso_code_2;
            $response['country_isocode2'] = $result->iso_code_3;
        }
        die(json_encode($response));
    }

    public function getStateInfo() {
        $response = array();
        $country_id = $this->input->post('country', true);
        $state_id = $this->input->post('state', true);
        $this->load->model('countrymodel');
        $result = $this->countrymodel->getState($state_id);
        if (!empty($result)) {
            $response['country_id'] = $country_id;
            $response['state_id'] = $result->statemaster_id;
            $response['state_name'] = $result->state_name;
        }
        die(json_encode($response));
    }

    //get city info
    public function getCityInfo() {
        $response = array();
        $city = array();
        $country_id = $this->input->post('country', true);
        $state_id = $this->input->post('state', true);
        $city_id = $this->input->post('city', true);
        $this->load->model('countrymodel');
        $this->load->model('commonmodel');
        $result = $this->countrymodel->getCity($city_id);
        if (!empty($result)) {
            $response['country_id'] = $result->countrymaster_id;
            $response['state_id'] = $result->statemaster_id;
            $response['city_id'] = $result->citymaster_id;
            $response['city_name'] = $result->city_name;
        }
        $result_countrys = $this->commonmodel->getDropDownSQL();
        $cntry = '';
        $stat = '';
        if (!empty($result_countrys)) {
            foreach ($result_countrys as $result_country) {
                if ($country_id == $result_country->countrymaster_id) {
                    $cntry .= "<option value='" . $result_country->countrymaster_id . "' selected='selected' >" . $result_country->country_name . "</option>";
                } else {
                    $cntry .= "<option value='" . $result_country->countrymaster_id . "' >" . $result_country->country_name . "</option>";
                }
            }
        }
        $result_states = $this->commonmodel->getDropDownSQL($country_id);

        if (!empty($result_states)) {
            foreach ($result_states as $result_state) {
                if ($state_id == $result_state->statemaster_id) {
                    $stat .= "<option value='" . $result_state->statemaster_id . "' selected='selected' >" . $result_state->state_name . "</option>";
                } else {
                    $stat .= "<option value='" . $result_state->statemaster_id . "' >" . $result_state->state_name . "</option>";
                }
            }
        }

        $response['country'] = $cntry;
        $response['state'] = $stat;
        die(json_encode($response));
    }

    public function updatecountry() {
        $response = array();
        $country_id = $this->input->post('country', true);
        $this->load->model('countrymodel');
        $is_used = $this->getAddressmasterByCountrystatecityid($country_id, 'country');
        $country_name = $this->countrymodel->getCountry($country_id);
        if (empty($is_used)) {

            $data = array('status' => '0');
            $result = $this->countrymodel->updateCountry($country_id, $data);
            $response['status'] = '1';
            $response['message'] = $country_name->country_name . 'Country Block Successfully';
            $this->session->set_userdata('success', $country_name->country_name . ' Country Block Successfully');
        } else {
            $response['status'] = '1';
            $response['message'] = $country_name->country_name . ' Country is in use so Can Not Block!';
            $this->session->set_userdata('warning', $country_name->country_name . ' Country is in use so Can Not Block!');
        }
        die(json_encode($response));
    }

    function getAddressmasterByCountrystatecityid($id, $type) {

        if ($type == 'country') {
            $condition_array = array('countrymaster_id' => $id);
        } elseif ($type == 'state') {
            $condition_array = array('statemaster_id' => $id);
        } elseif ($type == 'city') {
            $condition_array = array('citymaster_id' => $id);
        }

        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'addressmaster');
        $this->db->where($condition_array);
        $query = $this->db->get();
        $row = $query->first_row();
        return $row;
    }

    public function updatestate() {
        $response = array();
        $state_id = $this->input->post('state', true);
        $this->load->model('countrymodel');
        $is_used = $this->getAddressmasterByCountrystatecityid($state_id, 'state');
        $state_name = $this->countrymodel->getState($state_id);
        if (empty($is_used)) {
            $data = array('status' => '0');
            $result = $this->countrymodel->updateState($state_id, $data);
            $response['status'] = '1';
            $response['message'] = $state_name->state_name . ' State Block Successfully';
            $this->session->set_userdata('success', $state_name->state_name . ' State Block Successfully');
        } else {
            $response['status'] = '1';
            $response['message'] = $state_name->state_name . '  State is in use so Can Not Block!';
            $this->session->set_userdata('warning', $state_name->state_name . '  State is in use so Can Not Block!');
        }
        die(json_encode($response));
    }

    public function updatecity() {
        $response = array();
        $city_id = $this->input->post('city', true);
        $this->load->model('countrymodel');
        $is_used = $this->getAddressmasterByCountrystatecityid($city_id, 'city');

        $city_name = $this->countrymodel->getCity($city_id);
        if (empty($is_used)) {
            $data = array('status' => '0');
            $result = $this->countrymodel->updateCity($city_id, $data);
            $response['status'] = '1';
            $response['message'] = $city_name->city_name . ' City Block Successfully';
            $this->session->set_userdata('success', $city_name->city_name . ' City Block Successfully');
        } else {
            $response['status'] = '1';
            $response['message'] = $city_name->city_name . '  State is in use so Can Not Block!';
            $this->session->set_userdata('warning', $city_name->city_name . '  State is in use so Can Not Block!');
        }
        die(json_encode($response));
    }

    public function getcompanyofoffice() {
        $response = array();
        $cmp = '';
        $office_parent_id = $this->input->post('office_p_type_id', true);
        $this->load->model('companymodel');
        if ($office_parent_id != '') {
            $result = $this->companymodel->getCompaniesByParentOffice($office_parent_id);
        } else {
            $result = $this->companymodel->getCompanies();
        }
        //$cmp .= "<option value='' >--Please Select--</option>";
        if (!empty($result)) {
            foreach ($result as $resulte) {
                $cmp .= "<option value='" . $resulte->company_master_id . "' >" . $resulte->company_name . "</option>";
            }
        }

        $response['office_p_type_cmp'] = $cmp;
        die(json_encode($response));
    }

    public function getofficeaddressoffice() {
        $response = array();
        $cmp = '';
        $office_type_id = $this->input->post('office_type_id', true);
        $this->load->model('companymodel');
        $result_cmp = $this->companymodel->getOfficeType($office_type_id);
        if ($result_cmp->$office_type_parent_id == 0) {
            
        }

        $result = $this->companymodel->getOfficeType($office_type_id);

        //$cmp .= "<option value='' >--Please Select--</option>";
        if (!empty($result)) {
            foreach ($result as $resulte) {
                $cmp .= "<option value='" . $resulte->company_master_id . "' >" . $resulte->company_name . "</option>";
            }
        }

        $response['office_p_type_cmp'] = $cmp;
        die(json_encode($response));
    }

    public function getofficeofcomany() {
        $response = array();
        $cmp = '';
        $company_id = $this->input->post('company_id', true);
        $this->load->model('companymodel');
        $result = $this->companymodel->getOfficeTypesOfComany($company_id);
        //print_r($result);
        if (!empty($result)) {
            foreach ($result as $resulte) {
                $cmp .= "<option value='" . $resulte->office_type_id . "' >" . $resulte->office_type_name . "</option>";
            }
        }
        $response['company_parent_offices'] = $cmp;
        // $response['cmp'] = $company_id;
        die(json_encode($response));
    }

    //added on 15-2-2013
    public function getCountryByName($country_name, $country_id = '') {
        if ($country_id != '') {
            $sql = "Select * from " . $this->db->dbprefix . "countrymaster WHERE countrymaster_id !='" . $country_id . "' AND  LCASE(country_name)='" . strtolower($country_name) . "' limit 1";
        } else {
            $sql = "Select * from " . $this->db->dbprefix . "countrymaster WHERE  LCASE(country_name)='" . strtolower($country_name) . "' limit 1";
        }
        $result = mysql_query($sql);
        $row = '';
        if (!empty($result)) {
            $row = mysql_fetch_assoc($result);
        }
        return $row;
    }

    public function checkcountry() {
        $response = array();
        $country_name = $this->input->post('country_name', true);
        $country_id = $this->input->post('country_id', true);
        if ($country_id != '') {
            $result = $this->getCountryByName($country_name, $country_id);
        } else {
            $result = $this->getCountryByName($country_name);
        }
        if (empty($result)) {
            $response['status'] = 0;
        } else {
            $response['status'] = 1;
        }

        die(json_encode($response));
    }

    public function getCountryByIsocodeone($country_code_one, $country_id = '') {
        if ($country_id != '') {
            $sql = "Select * from " . $this->db->dbprefix . "countrymaster WHERE countrymaster_id !='" . $country_id . "' AND LCASE(iso_code_2)='" . strtolower($country_code_one) . "' limit 1";
        } else {
            $sql = "Select * from " . $this->db->dbprefix . "countrymaster WHERE LCASE(iso_code_2)='" . strtolower($country_code_one) . "' limit 1";
        }

        $result = mysql_query($sql);
        $row = '';
        if (!empty($result)) {
            $row = mysql_fetch_assoc($result);
        }

        return $row;
    }

    public function checkcountryISOCodeOne() {
        $response = array();
        $country_code_one = $this->input->post('country_code_one', true);
        $country_id = $this->input->post('country_id', true);

        if ($country_id != '') {
            $result = $this->getCountryByIsocodeone($country_code_one, $country_id);
        } else {
            $result = $this->getCountryByIsocodeone($country_code_one);
        }

        if (empty($result)) {
            $response['status'] = 0;
        } else {
            $response['status'] = 1;
        }

        die(json_encode($response));
    }

    //for state
    public function getStateByName($state_name, $country_id, $state_id = '') {
        if ($state_id != '') {
            $sql = "Select * from " . $this->db->dbprefix . "statemaster WHERE statemaster_id !='" . $state_id . "' AND countrymaster_id ='" . $country_id . "' AND  LCASE(state_name)='" . strtolower($state_name) . "' limit 1";
        } else {
            $sql = "Select * from " . $this->db->dbprefix . "statemaster WHERE  countrymaster_id ='" . $country_id . "' AND  LCASE(state_name)='" . strtolower($state_name) . "' limit 1";
        }
        $result = mysql_query($sql);
        $row = '';
        if (!empty($result)) {
            $row = mysql_fetch_assoc($result);
        }
        return $row;
    }

    public function checkstate() {
        $response = array();
        $state_name = $this->input->post('state_name', true);
        $country_id = $this->input->post('country_id', true);
        $state_id = $this->input->post('state_id', true);

        if ($state_id != '') {
            $result = $this->getStateByName($state_name, $country_id, $state_id);
        } else {
            $result = $this->getStateByName($state_name, $country_id);
        }
        if (empty($result)) {
            $response['status'] = 0;
        } else {
            $response['status'] = 1;
        }

        die(json_encode($response));
    }

    //for state
    public function getCityByName($city_name, $country_id, $state_id, $city_id = '') {
        if ($city_id != '') {
            $sql = "Select * from " . $this->db->dbprefix . "citymaster WHERE citymaster_id !='" . $city_id . "' AND countrymaster_id ='" . $country_id . "' AND statemaster_id ='" . $state_id . "' AND  LCASE(city_name)='" . strtolower($city_name) . "' limit 1";
        } else {
            $sql = "Select * from " . $this->db->dbprefix . "citymaster WHERE countrymaster_id ='" . $country_id . "' AND statemaster_id ='" . $state_id . "' AND  LCASE(city_name)='" . strtolower($city_name) . "' limit 1";
        }

        $result = mysql_query($sql);
        $row = '';
        if (!empty($result)) {
            $row = mysql_fetch_assoc($result);
        }
        return $row;
    }

    public function checkcity() {
        $response = array();
        $city_name = $this->input->post('city_name', true);
        $country_id = $this->input->post('country_id', true);
        $state_id = $this->input->post('state_id', true);
        $city_id = $this->input->post('city_id', true);

        if ($city_id != '') {
            $result = $this->getCityByName($city_name, $country_id, $state_id, $city_id);
        } else {
            $result = $this->getCityByName($city_name, $country_id, $state_id);
        }
        if (empty($result)) {
            $response['status'] = 0;
        } else {
            $response['status'] = 1;
        }
        //  $response['city_name'] = $city_name;
        die(json_encode($response));
    }

    //check office type name exist 
    function checkofficetypeexist() {
        $response = array();
        $company_id = $this->input->post('company_id', true);
        $parent_office_id = $this->input->post('parent_office_id', true);
        $office_name = $this->input->post('office_name', true);
        $office_type_id = $this->input->post('office_type_id', true);
        $this->load->model('companymodel');
        if ($office_type_id == '') {
            $result = $this->companymodel->getOfficeTypeIsPresent($company_id, $parent_office_id, $office_name);
            $result_office_name = $this->companymodel->getOfficeNameOfCompanyId($company_id, $office_name);
        } else {
            $result = $this->companymodel->getOfficeTypeIsPresent($company_id, $parent_office_id, $office_name, $office_type_id);
            $result_office_name = $this->companymodel->getOfficeNameOfCompanyId($company_id, $office_name, $office_type_id);
        }
        if (!empty($result)) {
            //return false
            $response['status'] = '0';
        } else if (!empty($result_office_name)) {
            $response['status'] = '3';
        } elseif (empty($result) && empty($result_office_name)) {
            $response['status'] = '1';
        }
        die(json_encode($response));
    }

    function checkiscomapnypresent() {
        $response = array();
        $company_id = $this->input->post('company_id', true);
        $this->load->model('companymodel');
        $result = $this->companymodel->getIsCompanyIdPresentInOffice($company_id);
        if (!empty($result)) {
            //return false
            $response['status'] = '0';
        }
    }

    function getofficeacoordingcomapnyandpriority() {
        $response = array();
        $output = '<option value="">--Please Select--</option>';
        $output1 = '<option value="">--Please Select--</option>';
        $company_id = $this->input->post('company_id', true);
        $office_type_id = $this->input->post('office_type_id', true);
        //$office_address_id     =  $this->input->post('office_address_id',true);
        $this->load->model('companymodel');
        $result = $this->companymodel->getOfficeAccordingCompnayAndPriotity($company_id, $office_type_id);

        // echo  $this->db->last_query();
        if (!empty($result)) {
            //return false
            foreach ($result as $key => $val) {
                $output .= "<option value='" . $val->office_type_id . "'>" . $val->office_type_name . "</option>";
                $office_types_ids[] = $val->office_type_id;
            }

            $response['reported_to_offices'] = $output;
            $result1 = $this->companymodel->getOfficeAdressByOfficeTypeIds($office_types_ids);

            if (!empty($result1)) {
                foreach ($result1 as $key1 => $val1) {
                    $output1 .= "<option value='" . $val1->office_addresses_id . "'>" . $val1->office_name . "</option>";
                }
            }
            $response['reported_to_offices_name'] = $output1;
            $response['status'] = '1';
        } else {
            //means head office selected
            $response['status'] = '0';
        }

        die(json_encode($response));
    }

    function getofficename() {
        $response = array();
        $output = '<option value="">--Please Select--</option>';
        $company_id = $this->input->post('company_id', true);
        $office_type_id = $this->input->post('office_type_id', true);
        $reported_office_type_id = $this->input->post('reported_office_type_id', true);
        $response['company_id'] = $company_id;
        $response['office_type_id'] = $office_type_id;
        $response['r_o_t_id'] = $reported_office_type_id;
        $this->load->model('companymodel');

        $result = $this->companymodel->getReortedOfficeNames($company_id, $office_type_id, $reported_office_type_id);

        if (!empty($result)) {
            foreach ($result as $key => $val) {
                $output .= "<option value='" . $val->office_addresses_id . "'>" . $val->office_name . "</option>";
            }
            $response['status'] = 1;
        } else {
            $response['status'] = 0;
        }
        $response['office_name'] = $output;
        die(json_encode($response));
    }

    function checkofficeaddress() {
        $response = array();
        $company_id = $this->input->post('company_id', true);
        $office_name = $this->input->post('office_name', true);
        $office_code = $this->input->post('office_code', true);
        $office_type_id = $this->input->post('office_type_id', true);
        $country_id = $this->input->post('country_id', true);
        $state_id = $this->input->post('state_id', true);
        $city_id = $this->input->post('city_id', true);
        $office_address_id = $this->input->post('office_address_id', true);


//         $company_id                     =  '5';
//        $office_name                    =  'enrich corporate office';
//        $office_code                    =  'eho';
//        $office_type_id                 =  '9';
//        $country_id                     =  '99';
//        $state_id                       =  '1493';
//        $city_id                        =  '6';
//        $office_address_id              =  '';//$this->input->post('office_address_id',true);

        $check_validation = 0;
        $this->load->model('companymodel');
        $get_office_type_detail = $this->companymodel->getOfficeType($office_type_id);
        $office_type_priority = $get_office_type_detail->priority;
        // echo $office_type_priority;
        if ($office_type_priority == 1) {
            $result_address = $this->companymodel->IsPresentOfficeType($office_type_id);
            if (!empty($result_address)) {
                $check_validation = 1;
            }
        }

        //office name 
        if ($office_address_id != '') {
            $result = $this->companymodel->getOfficeNameWithCity($company_id, $office_name, $country_id, $state_id, $city_id, $office_address_id);
        } else {
            $result = $this->companymodel->getOfficeNameWithCity($company_id, $office_name, $country_id, $state_id, $city_id);
        }
        if (!empty($result)) {
            $response['status'] = 1; //office name already exist
        } else {
            $response['status'] = 0;
        }

        //office code
        if ($office_address_id != '') {
            $result_code = $this->companymodel->getOfficeCodeWithCity($company_id, $office_code, $country_id, $state_id, $city_id, $office_address_id);
        } else {
            $result_code = $this->companymodel->getOfficeCodeWithCity($company_id, $office_code, $country_id, $state_id, $city_id);
        }
        if (!empty($result_code)) {
            $response['office_code_status'] = 1; //office code already exist
        } else {
            $response['office_code_status'] = 0;
        }

        //same office type and country state city address can not added
        if ($check_validation != 1) {
            if ($office_address_id != '') {
                $result_isofficetype = $this->companymodel->getOfficeTypeWithCountryStateCity($company_id, $office_type_id, $country_id, $state_id, $city_id, $office_address_id);
            } else {
                $result_isofficetype = $this->companymodel->getOfficeTypeWithCountryStateCity($company_id, $office_type_id, $country_id, $state_id, $city_id);
            }
            if (!empty($result_isofficetype)) {
                $response['office_status'] = 1;
            } else {
                $response['office_status'] = 0;
            }
        } else {
            $response['office_status'] = 1;
        }
        if ($office_address_id != '') {

            $result_isexist = $this->companymodel->checkOfficeAddressAlreadyExist($company_id, $office_name, $office_code, $office_type_id, $country_id, $state_id, $city_id, $office_address_id);
        } else {
            $result_isexist = $this->companymodel->checkOfficeAddressAlreadyExist($company_id, $office_name, $office_code, $office_type_id, $country_id, $state_id, $city_id);
        }
        if (!empty($result_isexist)) {
            $response['office_address_status'] = 1; //office code already exist
        } else {
            $response['office_address_status'] = 0;
        }


        die(json_encode($response));
    }

    function checkofficetypecandenied() {
        $response = array();
        $data = array();
        $response['status'] = '';
        $office_type_id = $this->input->post('office_type_id', true);
        $office_type_status = $this->input->post('status', true);
        $this->load->model('companymodel');
        if ($office_type_status == 0) {
            $result = $this->companymodel->getOfficeAdressByOfficeTypeIds(array($office_type_id));
            if (!empty($result)) {
                $response['status'] = 1; //can not denied
            } else {
                $response['status'] = 2;
                $data['office_type_status'] = '1';
                $condition_ary = array('office_type_id' => $office_type_id);
                $this->db->where($condition_ary);
                $result = $this->db->update($this->db->dbprefix . 'office_type', $data);
                //$this->session->set_userdata('success','Office Type Deactivated Successfully.');
            }
        } else {
            $response['status'] = 3;
            $data['office_type_status'] = '0';
            $condition_ary = array('office_type_id' => $office_type_id);
            $this->db->where($condition_ary);
            $result = $this->db->update($this->db->dbprefix . 'office_type', $data);
            //  $this->session->set_userdata('success','Office Type Activated Successfully.');
        }
        die(json_encode($response));
    }

    //get department and office list
    public function getdepartmentandofficelist() {

        $response = array();
        $response['status'] = '';
        $output = '';
        $output1 = '';
        $this->load->model('companymodel');
        $departments = $this->companymodel->getDepartments();
        $office_address = $this->companymodel->getOfficeAddresses();
        foreach ($departments as $key => $val) {
            $output .= '<option value="' . $val->department_id . '">' . $val->department_name . '</option>';
        }
        //$output1 .= '<label for="s_name" class="req">Select features to add for a group</label><select name="dept_office_list[]" id="custom-headers" multiple="multiple">';
        //$output1 .= '<select name="dept_office_list[]" id="custom-headers" multiple="multiple">';
        foreach ($office_address as $key => $val) {
            $output1 .= "<option value='" . $val->office_addresses_id . "'>" . $val->office_name . "</option>";
        }
        //$output1 .= '</select>';
        $response['department'] = $output;
        $response['office_addresses'] = $output1;


        die(json_encode($response));
    }

    function callofficeadressesbycompany() {
        $this->load->model('companymodel');
        $response = array();
        $response['status'] = '';
        $output = '';
        $company_id = $this->input->post('company_id', true);
        $office_address = $this->companymodel->getOfficesBycompanyId($company_id);
        foreach ($office_address as $key => $val) {
            $output .= "<option value='" . $val->office_addresses_id . "'>" . $val->office_name . "</option>";
        }
        $response['office_addresses'] = $output;
        die(json_encode($response));
    }

    function checkemailusernameexist() {

        $this->load->model('usersmodel');
        $response = array();
        $response['status'] = '';
        $output = '';
        $email_username = $this->input->post('email_username', true);
        $usernames = $this->usersmodel->getUserByEmail($email_username);
        //$response['email_usernm'] =  $email_username;
        if (!empty($usernames)) {
            $response['username'] = 1;
        } else {
            $response['username'] = 0;
        }
        die(json_encode($response));
    }

    function getCompanyOfUsers() {
        $response = array();
        $company_name = $this->input->post('company', true);
        $this->load->model('usersmodel');
        $result = $this->usersmodel->getUserCompany($company_name);
        $company_nm = array();
        if (!empty($result)) {
            foreach ($result as $key => $val) {
                $company_nm[] = $val['meta_value'];
            }
        }
        $response['company_name'] = $company_nm;
        // $response['test_val']     = 'aaaa';
        die(json_encode($response));
    }

    function getAllCompanyOfUsers() {
        $response = array();
        $this->load->model('usersmodel');
        $result = $this->usersmodel->getUserAllCompany();
        $company_nm = array();
        if (!empty($result)) {
            foreach ($result as $key => $val) {
                $company_nm[] = $val['meta_value'];
            }
        }
        $response['company_name'] = $company_nm;
        $response['test_val'] = 'aaaa';
        die(json_encode($response));
    }

    function call_delete_work() {
        $response = array();
        $user_entity_master_id = $this->input->post('user_entity_master_id', true);
        $this->db->where('user_entity_master_id', $user_entity_master_id);
        $this->db->delete($this->db->dbprefix . 'user_meta');
        $this->db->where('user_entity_master_id', $user_entity_master_id);
        $this->db->delete($this->db->dbprefix . 'user_entity_master');
        // $this->session->set_userdata('success', 'Work removed Successfully');
        die(json_encode($response));
    }

    function call_delete_edu() {
        $response = array();
        $user_entity_master_id = $this->input->post('user_entity_master_id', true);
        $this->db->where('user_entity_master_id', $user_entity_master_id);
        $this->db->delete($this->db->dbprefix . 'user_meta');
        $this->db->where('user_entity_master_id', $user_entity_master_id);
        $this->db->delete($this->db->dbprefix . 'user_entity_master');
        // $this->session->set_userdata('success', 'Work removed Successfully');
        die(json_encode($response));
    }

    function call_update_work() {
        $response = array();
        $this->load->model('commonmodel');
        $user_entity_master_id = $this->input->post('user_entity_master_id');
        $s_date_format = $this->commonmodel->get_env_setting('s_date_format');
        if ($user_entity_master_id != '' || $user_entity_master_id != 0) {
            $this->db->where('user_entity_master_id', $user_entity_master_id);
            $this->db->delete($this->db->dbprefix . 'user_meta');
            $company = $this->input->post('company');
            $position = $this->input->post('position');
            $from_date = $this->input->post('from_dt');
            $to_date = $this->input->post('to_dt');
            $desc = $this->input->post('desc');
            $city = $this->input->post('city');
            $tillnow = $this->input->post('showe');
            $f_dt = '';
            if ($from_date != '') {
                $f_dt = date('Y-m-d', strtotime($from_date));
            }
            if ($tillnow == 'Y') {
                $t_dt = 'Present';
            } elseif ($tillnow == 'N' && $to_date != '') {
                $t_dt = date('Y-m-d', strtotime($to_date));
            } else {
                $t_dt = '';
            }
            $meta_key = array('companyname' => ucwords(strtolower($company)), 'city' => ucfirst($city), 'position' => ucwords(strtolower($position)), 'from' => $f_dt, 'to' => $t_dt, 'desc' => $desc);
            $response['m_key'] = $meta_key;
            foreach ($meta_key as $key => $val) {
                $user_data = array();
                $user_data = array(
                    'user_entity_master_id' => $user_entity_master_id,
                    'user_id' => $this->session->userdata('user_id'),
                    'meta_key' => $key,
                    'meta_value' => $val
                );

                $this->db->insert($this->db->dbprefix . 'user_meta', $user_data);
            }
            $this->load->model('usersmodel');
            $user_work_info = $this->usersmodel->getUserWorkMeta($user_entity_master_id, $this->session->userdata('user_id'));
            $w_info = array();
            foreach ($user_work_info as $key => $val) {
                if ($val['meta_key'] == 'from' && trim($val['meta_value'] != '')) {
                    $w_info[$val['meta_key']] = date($s_date_format, strtotime($val['meta_value']));
                } else if ($val['meta_key'] == 'to') {

                    if (trim($val['meta_value']) != '' && trim($val['meta_value']) !== 'Present') {
                        $w_info[$val['meta_key']] = date($s_date_format, strtotime($val['meta_value']));
                    } else {
                        $w_info[$val['meta_key']] = trim($val['meta_value']);
                    }
                } else {
                    $w_info[$val['meta_key']] = $val['meta_value'];
                }
            }
            $response['winfo'] = $w_info;
        }
        die(json_encode($response));
    }

    function call_update_edu() {
        $response = array();
        $this->load->model('commonmodel');
        $user_entity_master_id = $this->input->post('user_entity_master_id');
        $s_date_format = $this->commonmodel->get_env_setting('s_date_format');
        if ($user_entity_master_id != '' || $user_entity_master_id != 0) {
            $this->db->where('user_entity_master_id', $user_entity_master_id);
            $this->db->delete($this->db->dbprefix . 'user_meta');
            $education = $this->input->post('education');
            $degree = $this->input->post('degree');
            $from_date = $this->input->post('from_dt');
            $to_date = $this->input->post('to_dt');
            $desc = $this->input->post('desc');
            $city = $this->input->post('city');
            if ($from_date != '') {
                $f_dt = date('Y-m-d', strtotime($from_date));
            }
            if ($to_date != '') {
                $t_dt = date('Y-m-d', strtotime($to_date));
            }

            $meta_key = array('education' => ucwords(strtolower($education)), 'city' => $city, 'degree' => ucwords(strtolower($degree)), 'from' => $f_dt, 'to' => $t_dt, 'desc' => $desc);
            $response['m_key'] = $meta_key;
            foreach ($meta_key as $key => $val) {
                $user_data = array();
                $user_data = array(
                    'user_entity_master_id' => $user_entity_master_id,
                    'user_id' => $this->session->userdata('user_id'),
                    'meta_key' => $key,
                    'meta_value' => $val
                );

                $this->db->insert($this->db->dbprefix . 'user_meta', $user_data);
            }
            $this->load->model('usersmodel');
            $user_edu_info = $this->usersmodel->getUserWorkMeta($user_entity_master_id, $this->session->userdata('user_id'));
            $e_info = array();
            foreach ($user_edu_info as $key => $val) {
                if ($val['meta_key'] == 'from' && trim($val['meta_value'] != '')) {
                    $e_info[$val['meta_key']] = date($s_date_format, strtotime($val['meta_value']));
                } else if ($val['meta_key'] == 'to' && trim($val['meta_value']) != '') {
                    $e_info[$val['meta_key']] = date($s_date_format, strtotime($val['meta_value']));
                } else {
                    $e_info[$val['meta_key']] = $val['meta_value'];
                }
            }
            $response['einfo'] = $e_info;
        }
        die(json_encode($response));
    }

    function getEducationOfUsers() {
        $response = array();

        $education = $this->input->post('education', true);

        $this->load->model('usersmodel');
        $result = $this->usersmodel->getUserEducation($education);
        $education_nm = array();
        if (!empty($result)) {
            foreach ($result as $key => $val) {
                $education_nm[] = $val['meta_value'];
            }
        }
        $response['education_name'] = $education_nm;
        die(json_encode($response));
    }

    public function call_get_city_autocomplete() {
        $response = array();
        $city_master = array();
        $this->load->model('countrymodel');
        $city_name = $this->input->post('city_name', true);
        $result = $this->countrymodel->getAllCityByName($city_name);

        foreach ($result as $key => $val) {
            $city_master[] = $val['city_name'];
        }
        $response['all_city_list'] = $city_master;
        die(json_encode($response));
        //print_r($city_master);
    }

    function calldeptadressesbyoffice() {
        $this->load->model('companymodel');
        $response = array();
        $response['status'] = '';
        $output = '';
        $office_id = $this->input->post('office_id', true);

        $sql = "SELECT 
				dept.department_id, dept.department_name, dept.department_status
				FROM " . $this->db->dbprefix . "department dept, " . $this->db->dbprefix . "department_to_office deptoff
				WHERE dept.department_id = deptoff.department_id
				AND deptoff.office_addresses_id = '" . $office_id . "' ";
        $query = $this->db->query($sql);

        $dpet_list = $query->result();

        foreach ($dpet_list as $key => $val) {
            $output .= "<option value='" . $val->department_id . "'>" . $val->department_name . "</option>";
        }
        $response['dpet_list'] = $output;
        die(json_encode($response));
    }

    public function blockUser() {
        $this->load->model('usersmodel');
        $response = array();
        $user_id = $this->input->post('user_id', true);
        $user_data = array('user_status' => '0');
        $table_name = $this->db->dbprefix . 'user_master';

        $this->usersmodel->updateByarray($user_id, $user_data, $table_name);

        $response['userid'] = $user_id;
        $response['result'] = 'success';

        die(json_encode($response));
    }

    public function unblockUser() {
        $this->load->model('usersmodel');
        $response = array();
        $user_id = $this->input->post('user_id', true);
        $user_data = array('user_status' => '1');
        $table_name = $this->db->dbprefix . 'user_master';

        $this->usersmodel->updateByarray($user_id, $user_data, $table_name);

        $response['userid'] = $user_id;
        $response['result'] = 'success';

        die(json_encode($response));
    }

    function checkDuplicateEmail() {

        $this->load->model('usersmodel');
        $response = array();
        $response['status'] = '';
        $output = '';
        $email = $this->input->post('email', true);
        $usernames = $this->usersmodel->isEmailExists($email);
        //$response['email_usernm'] =  $email_username;
        if (!empty($usernames)) {
            $response['email'] = 1;
        } else {
            $response['email'] = 0;
        }
        die(json_encode($response));
    }

    function getDepartmentIdsByOffice() {
        $this->load->model('companymodel');

        $office_addresses_id = $this->input->post('office_addresses_id');
        //Get Departments bind to office
        $this->db->select('department_to_office.department_id');
        $this->db->from($this->db->dbprefix . 'department_to_office');
        $this->db->where('department_to_office.office_addresses_id', $office_addresses_id);
        $this->db->join($this->db->dbprefix . 'department', 'department.department_id = department_to_office.department_id', 'left');
        $query = $this->db->get();
        $rows = $query->result();
        //$last_query = $this->db->last_query();
        //$row = $query->first_row();
        $outputIds = array();
        $output = '';
        $output_all = '';
        foreach ($rows as $key => $val) {
            //$output .= "<option value='" . $val->department_id . "'>" . $val->department_name . "</option>";
            $outputIds[] = $val->department_id;
        }
        //$output = implode(",",$outputIds );
        $response = array();

        //List All Dept
        $departments = $this->companymodel->getDepartments();

        //print_r($office_address) ;
        foreach ($departments as $key => $val) {
            //if(!in_array($val->department_id , $outputIds) ){
            $output_all .= '<option value="' . $val->department_id . '">' . $val->department_name . '</option>';
            //}
        }

        //$response['dept'] = $row ;
        //$response['query'] = $last_query ;
        $response['select_list'] = $outputIds;
        $response['nonselect_list'] = $output_all;

        die(json_encode($response));
        //return $row ;
    }

    function getOfficeIdsByDept() {
        $this->load->model('companymodel');

        $dept_id = $this->input->post('dept_id');
        //Get Departments bind to office
        $this->db->select('department_to_office.office_addresses_id');
        $this->db->from($this->db->dbprefix . 'department_to_office');
        $this->db->where('department_to_office.department_id', $dept_id);
        $this->db->join($this->db->dbprefix . 'office_addresses', 'office_addresses.office_addresses_id = department_to_office.office_addresses_id', 'left');
        $query = $this->db->get();
        $rows = $query->result();
        //$last_query = $this->db->last_query();
        //$row = $query->first_row();
        $outputIds = array();
        $output = '';
        $output_all = '';
        foreach ($rows as $key => $val) {
            //$output .= "<option value='" . $val->department_id . "'>" . $val->department_name . "</option>";
            $outputIds[] = $val->office_addresses_id;
        }
        //$output = implode(",",$outputIds );
        $response = array();

        //List all Offices
        $office_address = $this->companymodel->getOfficeAddresses();
        //$output1 .= '<select name="dept_office_list[]" id="custom-headers" multiple="multiple">';
        foreach ($office_address as $key => $val) {
            $output_all .= "<option value='" . $val->office_addresses_id . "'>" . $val->office_name . "</option>";
        }

        //$response['dept'] = $row ;
        //$response['query'] = $last_query ;
        $response['select_list'] = $outputIds;
        $response['nonselect_list'] = $output_all;

        die(json_encode($response));
        //return $row ;
    }

    function checkforlastnpassword() {
        $response = array();
        $response['warning'] = '';
        $this->load->model('usersmodel');
        $this->load->model('commonmodel');
        $user_id = $this->session->userdata('user_id');
        $this->load->helper('security');
        $cant_use_last_passwd = $this->commonmodel->get_env_setting('cant_use_last_passwd');
        $newpassword = do_hash($this->input->post('new_password'), 'md5');
        //Check for not exist in previous list
        $pwdlist = $this->usersmodel->getPasswdList($user_id, $cant_use_last_passwd);
        $is_pwd_matched = false;
        foreach ($pwdlist as $row) {
            if ($row->passwd == $newpassword) {
                $is_pwd_matched = true;
            }
        }
        if ($is_pwd_matched == true) {
            $response['warning'] = 'Donot use previously used passwords. [' . $cant_use_last_passwd . ' times]  ';
        }

        die(json_encode($response));
    }

    function checkforcurrentpassword() {
        $response = array();
        $response['warning'] = '';

        $user_id = $this->session->userdata('user_id');

        $this->load->model('usersmodel');
        $this->load->helper('security');
        $current_password_info = $this->usersmodel->getUserPart1($user_id);
        $current_password = $current_password_info->password;
        $newpassword = do_hash($this->input->post('password'), 'md5');
        $is_pwd_matched = false;

        if ($current_password != $newpassword) {
            $is_pwd_matched = true;
        }
        if ($is_pwd_matched == true) {
            $response['warning'] = 'Please enter correct password.';
        }

        die(json_encode($response));
    }

}

?>