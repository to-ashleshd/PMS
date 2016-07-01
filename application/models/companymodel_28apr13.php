<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Companymodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getCompany($company_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'company_master');
        $this->db->join($this->db->dbprefix . 'addressmaster', 'addressmaster.object_id = company_master.company_master_id', 'left');
        $this->db->where('company_master.company_master_id', $company_id);
        $this->db->where('addressmaster.object_id', $company_id);
        $this->db->where('addressmaster.objecttype_id', '2');
        $query = $this->db->get();
        $row = $query->first_row();
        return $row;
    }

    function getCompanies() {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'company_master');
        $this->db->join($this->db->dbprefix . 'addressmaster', 'addressmaster.addressmaster_id = company_master.addressmaster_id', 'left');
        $this->db->order_by("company_master.company_name", "asc");
        $query = $this->db->get();
        $row = $query->result();
        return $row;
    }

    function getParentOffice($o_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->where('office_type_id', $o_id);
        $query = $this->db->get();
        $row = $query->first_row();
        return $row;
    }

    function getMainParentOffice() {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->where('office_type_parent_id', '0');
        $query = $this->db->get();
        $row = $query->first_row();
        return $row;
    }

    function getParentOffices() {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->where('office_type_parent_id', '0');
        $query = $this->db->get();
        //$row = $query->result();
        return $query->result();
    }

    function getOfficeType($office_type_id = '') {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->where('office_type_id', $office_type_id);
        $query = $this->db->get();
        $row = $query->first_row();
        return $row;
    }

    function getOfficeTypes() {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->join($this->db->dbprefix . 'company_master', 'company_master.company_master_id = office_type.company_master_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    function getCompaniesByParentOffice($parent_office_id = '-1') {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'company_master');
        $this->db->join($this->db->dbprefix . 'office_type', 'office_type.company_master_id = company_master.company_master_id', 'left');
        $this->db->where('office_type.office_type_id =', $parent_office_id);
        $query = $this->db->get();
        $row = $query->result();
        return $row;
    }

    function addOfficeType($data = array()) {
        $this->db->insert($this->db->dbprefix . 'office_type', $data);
        $office_type_id = $this->db->insert_id();
        return $office_type_id;
    }

    function updateOfficeType($office_type_id, $data = array()) {
        $condition_array = array('office_type_id' => $office_type_id);
        $this->db->where($condition_array);
        $result = $this->db->update($this->db->dbprefix . 'office_type', $data);
        return $result;
    }

    function getDepartment($department_id = '') {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'department');
        $this->db->where('department_id', $department_id);
        $query = $this->db->get();
        $row = $query->first_row();
        return $row;
    }

    function getDepartments() {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'department');
        $query = $this->db->get();
        return $query->result();
    }

    function updateDepartment($department_id, $data = array()) {
        $condition_array = array('department_id' => $department_id);
        $this->db->where($condition_array);
        $result = $this->db->update($this->db->dbprefix . 'department', $data);
        return $result;
    }

    //added on 14_2_2013
    function getParentOfficesBycomanyId($company_master_id = '') {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        $condition = array('company_master_id' => $company_master_id, 'office_type_parent_id' => '0');
        $this->db->where($condition);
        $query = $this->db->get();
        //$row = $query->result();
        return $query->result();
    }

    function getPriorityOfCompany($company_id = '') {
        $this->db->select_min('priority');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->where('company_master_id', $company_id);
        $query = $this->db->get();
        $row = $query->first_row();
        return $row->priority;
    }

    function getMaxPriorityOfCompany($company_id = '') {
        $this->db->select_max('priority');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->where('company_master_id', $company_id);
        $query = $this->db->get();
        $row = $query->first_row();
        return $row->priority;
    }

    function isCompanyPresentInOfficeType($company_id = '') {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->where('company_master_id', $company_id);
        $query = $this->db->get();
        $row = $query->first_row();
        return $row;
    }

    function getMaxPriority() {
        $this->db->select_max('priority');
        $this->db->from($this->db->dbprefix . 'office_type');
        $query = $this->db->get();
        $row = $query->first_row();
        return $row->priority;
    }

    //get ho and ro office
    function getOfficeTypeAsPerPriority() {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        // $condition = array('priority'=>'1','priority'=>'2');
        $this->db->where('priority', '1');
        $this->db->or_where('priority', '2');
        $query = $this->db->get();
        //$row = $query->result();
        return $query->result();
    }

    //get ho office
    function getMainffice() {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        $condition = array('priority' => '1');
        $this->db->where($condition);
        $query = $this->db->get();
        //$row = $query->result();
        return $query->result();
    }

    public function getOfficeTypeIsPresent($company_id = '', $office_prent_id = '', $office_type_name = '', $office_type_id = '') {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->where('company_master_id', $company_id);
        $this->db->where('office_type_parent_id', $office_prent_id);
        if ($office_type_id != '') {
            $this->db->where('office_type_id != ', $office_type_id);
        }
        $this->db->like('LCASE(office_type_name)', trim(strtolower($office_type_name)), 'after');
        $query = $this->db->get();
        return $query->result();
    }

    //get all office types of company is eqaual to company id 
    public function getOfficeTypesOfComany($company_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->where('company_master_id', $company_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getOfficeTypesOfComanyNotHo($company_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->where('company_master_id', $company_id);
        $this->db->where_not_in('office_type_parent_id', '0');
        $query = $this->db->get();
        return $query->result();
    }

    function getOfficeNameOfCompanyId($company_id = '', $office_type_name = '') {
        $this->db->select('office_type_name');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->where('company_master_id', $company_id);
        $this->db->like('LCASE(office_type_name)', trim(strtolower($office_type_name)), 'after');
        $query = $this->db->get();
        return $query->result();
    }

    function getIsCompanyIdPresentInOffice($company_id = '') {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->where('company_master_id', $company_id);
        $query = $this->db->get();
        return $query->result();
    }

    function getCompaniesHavingOfficeType() {
        $this->db->select('company_master_id');
        $this->db->distinct('company_master_id');
        $this->db->from($this->db->dbprefix . 'office_type');
        $query = $this->db->get();
        $result = $query->result();
        if (!empty($result)) {
            $cmp_ids = array();
            foreach ($result as $key => $val) {
                $cmp_ids[] = $val->company_master_id;
            }
            if (empty($cmp_ids)) {
                $cmp_ids[] = '0';
            }
            $this->db->select('*');
            $this->db->from($this->db->dbprefix . 'company_master');
            $this->db->where_in('company_master_id', $cmp_ids);
            $query = $this->db->get();
            $result1 = $query->result();
            return $result1;
        } else {
            return '';
        }
    }

    //added on 17-2-2013
    function getOfficeAccordingCompnayAndPriotity($company_id = '', $office_type_id = '') {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->where('company_master_id', $company_id);
        $this->db->where('office_type_id', $office_type_id);
        $query = $this->db->get();
        $row = $query->first_row();
        //echo  $this->db->last_query();
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->where('company_master_id', $company_id);
        $this->db->where('priority < ', (int) $row->priority);
        $query1 = $this->db->get();
        $result1 = $query1->result();

        return $result1;
    }

    function getOfficeAdressByOfficeTypeIds($office_type_ids = array()) {
        if (empty($office_type_ids)) {
            $office_type_ids[] = '0';
        }

        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_addresses');
        $this->db->where_in('office_type_id', $office_type_ids);
        $query1 = $this->db->get();
        $result = $query1->result();
        //   echo  $this->db->last_query();
        return $result;
    }

    function addOfficeAddress() {
        $reported_to_oadd = '';
        $reported_to_2_oadd = '';
        //print_r($_POST);
        //die(); 
        if ($this->input->post('reported_to_oadd')) {
            $reported_to_oadd = $this->input->post('reported_to_oadd');
        }
        if ($this->input->post('reported_to_2_oadd')) {
            $reported_to_2_oadd = $this->input->post('reported_to_2_oadd');
        }
        $data = array(
            'company_master_id' => $this->input->post('office_add_company'),
            'office_name' => ucwords(strtolower($this->input->post('officeaddressname'))),
            'office_code' => strtoupper($this->input->post('officecode')),
            'office_reported_office_type_id' => $reported_to_oadd,
            'office_reported_office_id' => $reported_to_2_oadd,
            'contact_person' => ucwords(strtolower($this->input->post('officperson'))),
            'office_type_id' => $this->input->post('office_type_office_add'),
            'office_address_status' => 1,
            'business_id' => $this->input->post('business_list_dd')
        );

        $this->db->insert($this->db->dbprefix . 'office_addresses', $data);
        $office_address_id = $this->db->insert_id();
        $this->load->model('addressmastermodel');
        $data_address = array(
            'object_id' => $office_address_id,
            'objecttype_id' => '3',
            'countrymaster_id' => $this->input->post('country_office_add'),
            'statemaster_id' => $this->input->post('state_office_add'),
            'citymaster_id' => $this->input->post('city_office_add'),
            'plot_no' => ucwords(strtolower($this->input->post('plot_office_no'))),
            'area' => ucwords(strtolower($this->input->post('area'))),
            'street' => ucwords(strtolower($this->input->post('street'))),
            'landmark' => ucwords(strtolower($this->input->post('landmark'))),
            'zipcode' => $this->input->post('zipcode'),
            'phone_no' => $this->input->post('phone_no'),
            'fax_no' => $this->input->post('fax')
        );
        $addressmaster_id = $this->addressmastermodel->addAddressMaster($data_address);
        $address_entry = array('addressmaster_id' => $addressmaster_id);

        $condition_ary = array('office_addresses_id' => $office_address_id);
        $this->db->where($condition_ary);
        $result = $this->db->update($this->db->dbprefix . 'office_addresses', $address_entry);
    }

    function updateOfficeAddress() {
        $reported_to_oadd = '';
        $reported_to_2_oadd = '';
        if ($this->input->post('reported_to_oadd')) {
            $reported_to_oadd = $this->input->post('reported_to_oadd');
        }
        if ($this->input->post('reported_to_2_oadd')) {
            $reported_to_2_oadd = $this->input->post('reported_to_2_oadd');
        }
        $data = array(
            'company_master_id' => $this->input->post('office_add_company'),
            'office_name' => ucwords(strtolower($this->input->post('officeaddressname'))),
            'office_code' => strtoupper($this->input->post('officecode')),
            'office_reported_office_type_id' => $reported_to_oadd,
            'office_reported_office_id' => $reported_to_2_oadd,
            'contact_person' => ucwords(strtolower($this->input->post('officperson'))),
            'office_type_id' => $this->input->post('office_type_office_add'),
            'business_id' => $this->input->post('business_list_dd')
        );
        $ids = explode('_', $this->input->post('hoffice_address_id'));
        $condition = array('office_addresses_id' => $ids[0]);
        $this->db->where($condition);
        $this->db->update($this->db->dbprefix . 'office_addresses', $data);
        $this->load->model('addressmastermodel');
        $data_address = array(
            'countrymaster_id' => $this->input->post('country_office_add'),
            'statemaster_id' => $this->input->post('state_office_add'),
            'citymaster_id' => $this->input->post('city_office_add'),
            'plot_no' => ucwords(strtolower($this->input->post('plot_office_no'))),
            'area' => ucwords(strtolower($this->input->post('area'))),
            'street' => ucwords(strtolower($this->input->post('street'))),
            'landmark' => ucwords(strtolower($this->input->post('landmark'))),
            'zipcode' => $this->input->post('zipcode'),
            'phone_no' => $this->input->post('phone_no'),
            'fax_no' => $this->input->post('fax')
        );
        $this->addressmastermodel->updateAddressMasterByAddressId($ids[1], $data_address);
    }

    public function getReortedOfficeNames($company_id = '', $office_type_id = '', $reported_office_type_id = '') {
        $condition = array(
            'office_type_id' => $office_type_id,
            'company_master_id' => $company_id,
            'office_reported_office_type_id' => $reported_office_type_id
        );
        //print_r($condition);
        $where = "office_type_id='" . $reported_office_type_id . "'";
        $sql = "SELECT * from " . $this->db->dbprefix . "office_addresses where " . $where;
        $query = $this->db->query($sql);
        $result = $query->result();
        //  print_r($result);die();
        return $result;
    }

    function getOfficeNameWithCity($company_id = '', $office_name = '', $country_id = '', $state_id = '', $city_id = '', $office_address_id = '') {
        $where = '1 ';
        if ($office_address_id != '') {
            $where .= "AND eoa.office_addresses_id!='" . $office_address_id . "'";
        }
        $where .= "AND eoa.company_master_id='" . $company_id . "' AND LCASE(eoa.office_name)='" . trim(strtolower($office_name)) . "'  AND ea.countrymaster_id='" . $country_id . "'  AND ea.statemaster_id='" . $state_id . "' AND ea.citymaster_id='" . $city_id . "'";
        $sql = "SELECT * from " . $this->db->dbprefix . "office_addresses as eoa LEFT JOIN " . $this->db->dbprefix . "addressmaster as ea ON (ea.object_id=eoa.office_addresses_id) where " . $where;
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo  $this->db->last_query();

        return $result;
    }

    function getOfficeCodeWithCity($company_id = '', $office_code = '', $country_id = '', $state_id = '', $city_id = '', $office_address_id = '') {
        $where = '1 ';
        if ($office_address_id != '') {
            $where .= "AND eoa.office_addresses_id!='" . $office_address_id . "'";
        }
        // $where .= "AND eoa.company_master_id='".$company_id."' AND LCASE(eoa.office_code) ='".trim($office_code)."' AND ea.countrymaster_id='".$country_id."'  AND ea.statemaster_id='".$state_id."' AND ea.citymaster_id='".$city_id."' ";
        $where .= "AND eoa.company_master_id='" . $company_id . "' AND LCASE(eoa.office_code) ='" . trim(strtolower($office_code)) . "'";
        $sql = "SELECT * from " . $this->db->dbprefix . "office_addresses as eoa LEFT JOIN " . $this->db->dbprefix . "addressmaster as ea ON (ea.object_id=eoa.office_addresses_id) where " . $where;
        $query = $this->db->query($sql);
        $result = $query->result();
        //echo  $this->db->last_query();

        return $result;
    }

    function getOfficeTypeWithCountryStateCity($company_id = '', $office_type_id = '', $country_id = '', $state_id = '', $city_id = '', $office_address_id = '') {
        $where = '1 ';
        if ($office_address_id != '') {
            $where .= "AND eoa.office_addresses_id!='" . $office_address_id . "'";
        }
        $where .= "AND eoa.company_master_id='" . $company_id . "' AND  eoa.office_type_id='" . (int) $office_type_id . "' AND ea.countrymaster_id='" . $country_id . "'  AND ea.statemaster_id='" . $state_id . "' AND ea.citymaster_id='" . $city_id . "'";
        $sql = "SELECT * from " . $this->db->dbprefix . "office_addresses as eoa LEFT JOIN " . $this->db->dbprefix . "addressmaster as ea ON (ea.object_id=eoa.office_addresses_id) where " . $where;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    function checkOfficeAddressAlreadyExist($company_id = '', $office_name = '', $office_code = '', $office_type_id = '', $country_id = '', $state_id = '', $city_id = '', $office_address_id = '') {
        $where = '1 ';
        if ($office_address_id != '') {
            $where .= "AND eoa.office_addresses_id!='" . $office_address_id . "'";
        }
        $where .= " AND eoa.company_master_id='" . $company_id . "' AND LCASE(eoa.office_name)='" . trim($office_name) . "' AND LCASE(eoa.office_code) ='" . trim($office_code) . "' AND eoa.office_type_id='" . (int) $office_type_id . "' AND ea.countrymaster_id='" . $country_id . "'  AND ea.statemaster_id='" . $state_id . "' AND ea.citymaster_id='" . $city_id . "' ";
        $sql = "SELECT * from " . $this->db->dbprefix . "office_addresses as eoa LEFT JOIN " . $this->db->dbprefix . "addressmaster as ea ON (ea.object_id=eoa.office_addresses_id) where " . $where;
        $query = $this->db->query($sql);
        $result = $query->result();
        // echo  $this->db->last_query();
        return $result;
    }

    function IsPresentOfficeType($office_type_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_addresses');
        $this->db->where('office_type_id', $office_type_id);
        $query1 = $this->db->get();
        $result = $query1->result();
        return $result;
    }

    function getOfficeAddresses() {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_addresses');
        $this->db->where('addressmaster.objecttype_id', '3');
        $this->db->join($this->db->dbprefix . 'addressmaster', 'addressmaster.object_id = office_addresses.office_addresses_id', 'left');
        $query1 = $this->db->get();
        $result = $query1->result();
        return $result;
    }

    function getOfficeAddress($office_addresses_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_addresses');
        $this->db->where('office_addresses.office_addresses_id', $office_addresses_id);
        $this->db->where('addressmaster.objecttype_id', '3');
        $this->db->join($this->db->dbprefix . 'addressmaster', 'addressmaster.object_id = office_addresses.office_addresses_id', 'left');
        $query = $this->db->get();
        $row = $query->first_row();
        //echo  $this->db->last_query();echo "<br>";//die();
        return $row;
    }

    public function getCompanyIsInUserMaster($company_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'employee');
        $this->db->where('company_master_id', $company_id);
        $query = $this->db->get();
        $rows = $query->result();
        return $rows;
    }

    public function getOfficeAdressessIsInUserMaster($office_addressess_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'employee');
        $this->db->where('office_address_id', $office_addressess_id);
        $query = $this->db->get();
        $rows = $query->result();
        return $rows;
    }

    public function getOfficesBycompanyId($company_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_addresses');
        $this->db->where('company_master_id', $company_id);
        $this->db->where('office_address_status', '1');
        $query = $this->db->get();
        $rows = $query->result();
        return $rows;
    }

    public function getcompanyHavingOfficeAdress() {
        $company_ids = array();
        $office_Address = $this->getOfficeAddresses();

        foreach ($office_Address as $key => $val) {
            if ($val->office_address_status == 1) {
                $company_ids[] = $val->company_master_id;
            }
        }

        if (empty($company_ids)) {
            $company_ids = 0;
        }
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'company_master');
        $this->db->where_in('company_master_id', $company_ids);
        // $this->db->where('office_address_status','1');
        $query = $this->db->get();
        $rows = $query->result();

        return $rows;
    }

    //for pms
    function getDepartmentIdsByOficeAddress($office_address_id) {
        $this->db->select('department_id');
        $this->db->from($this->db->dbprefix . 'department_to_office');
        $this->db->where('office_addresses_id', $office_address_id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $rows = $query->result_array();
        return $rows;
    }

    function getDepartmentByIDs($department_ids = array()) {
        if (empty($department_ids)) {
            $department_ids = array('0');
        }
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'department');
        $this->db->where_in('department_id', $department_ids);
        $query = $this->db->get();
        // echo $this->db->last_query();
        $rows = $query->result();
        return $rows;
    }

    function getDesignations() {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'designation');
        $query = $this->db->get();
        return $query->result();
    }

    function getGrades($status) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'grade');
        $this->db->where('status', $status);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getGradeByDesignationId($designation_id) {
        $designation_grade = $this->getDesignationById($designation_id);
        $grade_id = '0';
        if (!empty($designation_grade)) {
            $grade_id = $designation_grade->grade_id;
        }

        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'grade');
        $this->db->where('grade_id', $grade_id);
        $query = $this->db->get();
        $row = $query->first_row();
        return $row;
    }

    function getDesignationById($designation_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'designation');
        $this->db->where('designation_id', $designation_id);
        $query = $this->db->get();
        return $query->first_row();
    }

    function getGradeById($grade_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'grade');
        $this->db->where('grade_id', $grade_id);
        $query = $this->db->get();
        return $query->first_row();
    }

    function getGradesWithDesignation($grade_status, $designation_status) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'grade');
        $this->db->join($this->db->dbprefix . 'designation', 'designation.grade_id = grade.grade_id', 'left');
        $this->db->where('status', $grade_status);
        $this->db->where('designation_status', $designation_status);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getSuperiorGradesWithDesignation($grade_id, $grade_status, $designation_status) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'grade');
        $this->db->join($this->db->dbprefix . 'designation', 'designation.grade_id = grade.grade_id', 'left');
        $this->db->where('grade.grade_id >', $grade_id);
        $this->db->where('status', $grade_status);
        $this->db->where('designation_status', $designation_status);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_office_type_by_office_address($office_type_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->where('office_type_id', $office_type_id);
        $query = $this->db->get();
        return $query->first_row('array');
    }

    function get_sub_office_types($company_master_id, $priority) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->where('company_master_id', $company_master_id);
        $this->db->where('priority >=', $priority);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_Office_Types_Of_Comany($company_master_id) {
        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_type');
        $this->db->where('company_master_id', $company_master_id);
        $query = $this->db->get();
        //echo $this->db->last_query();die();
        return $query->result_array();
    }

    function get_office_adress_by_office_type_ids($office_type_ids = array()) {
        if (empty($office_type_ids)) {
            $office_type_ids[] = '0';
        }

        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'office_addresses');
        $this->db->where_in('office_type_id', $office_type_ids);
        $query1 = $this->db->get();
        $result = $query1->result_array();
        return $result;
    }
    
    
/**** Supported Functions ****/
    
    function getActiveCompanyCount() {
        $query = $this->db->query("SELECT count(*) as howmany FROM " . $this->db->dbprefix . "company_master WHERE status='1' ");
        $row = $query->first_row();
        return $row->howmany;
    }
    
    
    
    

}