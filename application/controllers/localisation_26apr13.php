<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Localisation extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->helper('corefunctions');
        $this->load->model('generalesettings');
    }

    public function index($tab = '') {
        //$this->load->view('welcome_message');
        //Calling Default method as new
        $this->localisation($tab);
    }

    /*
     * ****************************************
     * Localisation Settings 
     * ****************************************
     */

    public function localisation($tab = '', $postinfo = '') {
        $data = array();        
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        
        $data['current_tab'] = ''; //$this->input->post('current_tab');
        if ($tab == '') {
            $data['tab'] = 'tb1_b'; //$tab;
        } else {
            $data['tab'] = $tab;
        }

        $this->load->model('companymodel');
        $this->load->model('countrymodel');
        $this->load->model('commonmodel');
        $this->load->model('clientadminmodel');
        $this->load->model('generalesettings');

        $data['ismulticompany'] = $this->generalesettings->getIsMultiCompany();

        $data['deactivated_country_result'] = $this->countrymodel->getDeactivatedCountries();
        $data['deactivated_state_result'] = $this->countrymodel->getDeactivatedStates();
        $data['deactivated_city_result'] = $this->countrymodel->getDeactivatedCities();
        $data['postinfo'] = $postinfo;

        //print_r($deactivated_country_result);die();
        $country_result = $this->commonmodel->getDropDownSQL();
        $country_master = array();

        foreach ($country_result as $key => $val) {
            $country_master[$val->countrymaster_id] = $val->country_name;
        }
        $company_infos = $this->companymodel->getCompanies();

        $ofice_list = $this->companymodel->getOfficeTypes();

        //get row per page
        $data['row_per_page'] = $this->generalesettings->getRowsPerPage();
        // echo $data['row_per_page'];die();

        $data['office_type_cmp'] = $this->companymodel->getCompaniesHavingOfficeType();
        $data['office_addresses'] = $this->companymodel->getOfficeAddresses();

//        echo "<pre>";
//        print_r($data['office_addresses']);
//        echo "</pre>";die();
        // $office_master = array();
        $data['department_infos'] = $this->companymodel->getDepartments();
        $data['office_type_master'] = $ofice_list;
        $data['company_master'] = $company_infos;
        $data['country_master'] = $country_master;
        $data['button_text'] = 'Submit';
        $data['action'] = 'localisation/savelocalisationdata';
        $data['topmenu'] = $this->topmenu->apraiseemenulist();
        
        //Business 
        
        //business_details
        $this->load->model('businessmodel');
        $data['business_list_data'] = $this->businessmodel->getAllbusinesss();
        //Get Business Lit table
        $data['business_list'] = $this->load->view('default/clientadmin/cadmin_business_list', $data, true);
        $data['business_tab'] = $this->load->view('default/clientadmin/cadmin_business', $data, true);
        

        
        
        $this->load->view('default/clientadmin/cadmin_header', $data);
        $this->load->view('default/clientadmin/cadmin_localisation', $data);
    }

    
    public function savelocalisationdata($datalocalisation = '') {
        //echo "<pre>";
        //print_r($_POST);
        //echo "</pre>";
        //die();
        if (!empty($_POST)) {
            $this->load->model('clientadminmodel');
            $this->load->model('companymodel');
            $this->load->model('addressmastermodel');

            //For Department office
            if ($this->input->post('submit_dept_office')) {
                //If Office to Dept
                if( $this->input->post('select_dept_offic') == '2' ) {
                    //Get Office If
                    $office_id = $this->input->post('select_from') ;
                    
                    //Remove Existing records
                    $this->db->delete($this->db->dbprefix . 'department_to_office', array('office_addresses_id' => $office_id));
                    
                    //Get Dept as array
                    $arrDeptIds = array();
                    foreach( $this->input->post('select_list1') as $row ) {
                        $arrDeptIds[] = $row ;
                        //Insert each row for office
                        $data= array();
                        $data = array('office_addresses_id' => $office_id, 'department_id' => $row );
                        $result = $this->db->insert($this->db->dbprefix . 'department_to_office', $data);
                        
                    }
                    
                  //Display Info
                    //echo '<br>Office ID: ' . $office_id ;
                    //echo '<br>Dept ' ;
                    //print_r($arrDeptIds);
                    
                    //Insert 
                    
                }
                else{
                    //If Dept to office
                    $dept_id = $this->input->post('select_from') ;
                    
                    //Remove Existing records
                    $this->db->delete($this->db->dbprefix . 'department_to_office', array('department_id' => $dept_id));
                    
                    $arrOfficeIds = array();
                    foreach( $this->input->post('select_list1') as $row ) {
                        $arrOfficeIds[] = $row ;
                        //Insert each row for office
                        $data= array();
                        $data = array('office_addresses_id' => $row, 'department_id' => $dept_id );
                        $result = $this->db->insert($this->db->dbprefix . 'department_to_office', $data);
                        
                    }
                    
                }
                
                
                redirect('localisation/localisation/tb1_i', 'refresh');
                
            }
            
            //die();




            if ($this->input->post('officeaddress')) {
                if (($this->input->post('officeaddress') == 'Submit')) {
                    $this->companymodel->addOfficeAddress();
                    $this->session->set_userdata('success', 'Office Adress added Successfully');
                    redirect('localisation/localisation/tb1_g', 'refresh');
                } elseif (($this->input->post('officeaddress') == 'Update')) {
                    $this->companymodel->updateOfficeAddress();
                    $this->session->set_userdata('success', 'Office Adress Updated Successfully');
                    redirect('localisation/localisation/tb1_g', 'refresh');
                }
            }


            if ($this->input->post('updatecompany')) {

                if (($this->input->post('updatecompany') == 'Submit')) {
                    $this->clientadminmodel->addCompany();
                    $this->session->set_userdata('success', 'Company added Successfully');
                    redirect('localisation/localisation/tb1_e', 'refresh');
                    //$this->localisation('tb1_e');
                } elseif (($this->input->post('updatecompany') == 'Update')) {
                    $this->clientadminmodel->updateCompany();
                    $this->session->set_userdata('success', 'Company Updated Successfully');
                    //  $this->localisation('tb1_e');
                    redirect('localisation/localisation/tb1_e', 'refresh');
                }
            }
            if ($this->input->post('updatecountry')) {
                $this->load->model('countrymodel');
                if (($this->input->post('updatecountry') == 'Submit') && ($this->input->post('hcountry_id_country') == '')) {

                    $data_country = array(
                        'country_name' => ucwords(strtolower($this->input->post('country'))),
                        'iso_code_2' => strtoupper($this->input->post('countrycode1')),
                        'iso_code_3' => strtoupper($this->input->post('countrycode2')),
                        'status' => '1'
                    );
                    $country_id = $this->countrymodel->addCountry($data_country);
                    $this->session->set_userdata('success', 'Country added Successfully');
                } else if (($this->input->post('updatecountry') == 'Submit') && ($this->input->post('hcountry_id_country') != '')) {

                    $data_country = array(
                        'country_name' => ucwords(strtolower($this->input->post('country'))),
                        'iso_code_2' => strtoupper($this->input->post('countrycode1')),
                        'iso_code_3' => strtoupper($this->input->post('countrycode2')),
                    );
                    $country_id = $this->input->post('hcountry_id_country');
                    $result = $this->countrymodel->updateCountry($country_id, $data_country);
                    $this->session->set_userdata('success', 'Country updated Successfully');
                }
                redirect('localisation/localisation/tb1_b', 'refresh');
                // $this->localisation('tb1_b');
            }

            //update state

            if ($this->input->post('updatestate')) {


                $this->load->model('countrymodel');
                if (($this->input->post('updatestate') == 'Submit') && ($this->input->post('hcountry_new_state') == '')) {

                    $data_state = array(
                        'state_name' => ucwords(strtolower($this->input->post('state_new_state'))),
                        'countrymaster_id' => $this->input->post('country_new_state'),
                        'status' => '1'
                    );
                    $state_id = $this->countrymodel->addState($data_state);
                    $this->session->set_userdata('success', 'State added Successfully');
                } else if (($this->input->post('updatestate') == 'Submit') && ($this->input->post('hcountry_new_state') != '')) {

                    $data_state = array(
                        'state_name' => ucwords(strtolower($this->input->post('state_new_state'))),
                        'countrymaster_id' => $this->input->post('country_new_state'),
                    );
                    $state_id = $this->input->post('hcountry_new_state');
                    //echo $state_id;
                    $result = $this->countrymodel->updateState($state_id, $data_state);
                    $this->session->set_userdata('success', 'State updated Successfully');
                }

                // $this->localisation('tb1_c');
                redirect('localisation/localisation/tb1_c', 'refresh');
            }

            //update city

            if ($this->input->post('updatecity')) {
                //echo $this->input->post('city_new_city');die();
                $this->load->model('countrymodel');
                if (($this->input->post('updatecity') == 'Submit') && ($this->input->post('hcity_new_city') == '')) {
                    $data_city = array(
                        'countrymaster_id' => ucwords(strtolower($this->input->post('country_new_city'))),
                        'statemaster_id' => $this->input->post('state_new_city'),
                        'city_name' => $this->input->post('city_new_city'),
                        'status' => '1'
                    );
                    $city_id = $this->countrymodel->addCity($data_city);
                    $this->session->set_userdata('success', 'City added Successfully');
                } else if (($this->input->post('updatecity') == 'Submit') && ($this->input->post('hcity_new_city') != '')) {
                    $data_city = array(
                        'countrymaster_id' => ucwords(strtolower($this->input->post('country_new_city'))),
                        'statemaster_id' => $this->input->post('state_new_city'),
                        'city_name' => $this->input->post('city_new_city'),
                    );
                    $city_id = $this->input->post('hcity_new_city');
                    $result = $this->countrymodel->updateCity($city_id, $data_city);
                    $this->session->set_userdata('success', 'City updated Successfully');
                }

                // $this->localisation('tb1_d');
                redirect('localisation/localisation/tb1_d', 'refresh');
            }

            //update office type
            if ($this->input->post('updateofficetype')) {



                if ($this->input->post('office_parent_ot') == '') {
                    $priority = 1;
                } else {
                    $priority = (int) $this->input->post('office_parent_ot') + 1;
                }

                if (($this->input->post('updateofficetype') == 'Submit')) {
                    $is_present = $this->companymodel->getOfficeTypeIsPresent($this->input->post('office_type_company'), $this->input->post('office_parent_ot'), $this->input->post('newofficetype'));

                    if (!empty($is_present)) {
                        $this->session->set_userdata('warning', 'Office type Of Company Already Exist!');
                        $data_op = array(
                            'office_type_name' => ucwords(strtolower($this->input->post('newofficetype'))),
                            'office_type_parent_id' => (int) $this->input->post('office_parent_ot'),
                            'company_master_id' => (int) $this->input->post('office_type_company'),
                            'is_virtual_office' => $this->input->post('vcomp')
                        );
                        $this->localisation('tb1_f', $data_op);
                    } else {
                        $data_op = array();
                        $data_op = array(
                            'office_type_name' => ucwords(strtolower($this->input->post('newofficetype'))),
                            'office_type_parent_id' => (int) $this->input->post('office_parent_ot'),
                            'company_master_id' => (int) $this->input->post('office_type_company'),
                            'is_virtual_office' => $this->input->post('vcomp'),
                            'priority' => $priority,
                            'office_type_status' => '0'
                        );
                        $this->companymodel->addOfficeType($data_op);
                        $this->session->set_userdata('success', 'Office type added Successfully');
                    }
                } elseif (($this->input->post('updateofficetype') == 'Update')) {
                    $is_present = $this->companymodel->getOfficeTypeIsPresent($this->input->post('office_type_company'), $this->input->post('office_parent_ot'), $this->input->post('newofficetype'), $this->input->post('office_type_id'));
                    if (!empty($is_present)) {
                        $this->session->set_userdata('warning', 'Office type Of Company Already Exist!');
                        $data_op = array(
                            'office_type_name' => ucwords(strtolower($this->input->post('newofficetype'))),
                            'office_type_parent_id' => (int) $this->input->post('office_parent_ot'),
                            'company_master_id' => (int) $this->input->post('office_type_company'),
                            'is_virtual_office' => $this->input->post('vcomp')
                        );
                        $this->localisation('tb1_f', $data_op);
                    }
                    $office_type_id = $this->input->post('office_type_id');
                    $data_op = array();
                    $data_op = array(
                        'office_type_name' => $this->input->post('newofficetype'),
                        'office_type_parent_id' => (int) $this->input->post('office_parent_ot'),
                        'company_master_id' => (int) $this->input->post('office_type_company'),
                        'is_virtual_office' => $this->input->post('vcomp'),
                        'priority' => $priority
                    );
                    $this->companymodel->updateOfficeType($office_type_id, $data_op);
                    $this->session->set_userdata('success', 'Office type Updated Successfully');
                }

                //$this->localisation('tb1_f');
                redirect('localisation/localisation/tb1_f', 'refresh');
            }

            if ($this->input->post('updatedepartment')) {
                if (($this->input->post('updatedepartment') == 'Submit')) {
                    $data = array(
                        'department_name' => $this->input->post('newdepartment'),
                        'department_status' => '1'
                    );

                    $this->db->insert($this->db->dbprefix . 'department', $data);
                    $this->session->set_userdata('success', 'Department added Successfully');
                } else if (($this->input->post('updatedepartment') == 'Update')) {
                    $data = array(
                        'department_name' => $this->input->post('newdepartment'),
                    );
                    $condition_array = array('department_id' => $this->input->post('department_id'));
                    $this->db->where($condition_array);
                    $result = $this->db->update($this->db->dbprefix . 'department', $data);
                    $this->session->set_userdata('success', 'Department updated Successfully');
                }
                // $this->localisation('tb1_h');
                redirect('localisation/localisation/tb1_h', 'refresh');
            }
            
            //display common view
            
            
            
        } else {
            //$this->localisation('tb1_b');
            redirect('localisation/localisation/tb1_b', 'refresh');
        }
    }
    
    
    public function old_savelocalisationdata($datalocalisation = '') {
//        echo "<pre>";
//        print_r($_POST);
//        echo "</pre>";die();
        $data = array();
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();        
        
        if (!empty($_POST)) {
            $this->load->model('clientadminmodel');
            $this->load->model('companymodel');
            $this->load->model('addressmastermodel');
            if ($this->input->post('officeaddress')) {
                if (($this->input->post('officeaddress') == 'Submit')) {
                    $this->companymodel->addOfficeAddress();
                    $this->session->set_userdata('success', 'Office Adress added Successfully');
                    redirect('localisation/localisation/tb1_g', 'refresh');
                } elseif (($this->input->post('officeaddress') == 'Update')) {
                    $this->companymodel->updateOfficeAddress();
                    $this->session->set_userdata('success', 'Office Adress Updated Successfully');
                    redirect('localisation/localisation/tb1_g', 'refresh');
                }
            }


            if ($this->input->post('updatecompany')) {

                if (($this->input->post('updatecompany') == 'Submit')) {
                    $this->clientadminmodel->addCompany();
                    $this->session->set_userdata('success', 'Company added Successfully');
                    redirect('localisation/localisation/tb1_e', 'refresh');
                    //$this->localisation('tb1_e');
                } elseif (($this->input->post('updatecompany') == 'Update')) {
                    $this->clientadminmodel->updateCompany();
                    $this->session->set_userdata('success', 'Company Updated Successfully');
                    //  $this->localisation('tb1_e');
                    redirect('localisation/localisation/tb1_e', 'refresh');
                }
            }
            if ($this->input->post('updatecountry')) {
                $this->load->model('countrymodel');
                if (($this->input->post('updatecountry') == 'Submit') && ($this->input->post('hcountry_id_country') == '')) {

                    $data_country = array(
                        'country_name' => ucwords(strtolower($this->input->post('country'))),
                        'iso_code_2' => strtoupper($this->input->post('countrycode1')),
                        'iso_code_3' => strtoupper($this->input->post('countrycode2')),
                        'status' => '1'
                    );
                    $country_id = $this->countrymodel->addCountry($data_country);
                    $this->session->set_userdata('success', 'Country added Successfully');
                } else if (($this->input->post('updatecountry') == 'Submit') && ($this->input->post('hcountry_id_country') != '')) {

                    $data_country = array(
                        'country_name' => ucwords(strtolower($this->input->post('country'))),
                        'iso_code_2' => strtoupper($this->input->post('countrycode1')),
                        'iso_code_3' => strtoupper($this->input->post('countrycode2')),
                    );
                    $country_id = $this->input->post('hcountry_id_country');
                    $result = $this->countrymodel->updateCountry($country_id, $data_country);
                    $this->session->set_userdata('success', 'Country updated Successfully');
                }
                redirect('localisation/localisation/tb1_b', 'refresh');
                // $this->localisation('tb1_b');
            }

            //update state

            if ($this->input->post('updatestate')) {


                $this->load->model('countrymodel');
                if (($this->input->post('updatestate') == 'Submit') && ($this->input->post('hcountry_new_state') == '')) {

                    $data_state = array(
                        'state_name' => ucwords(strtolower($this->input->post('state_new_state'))),
                        'countrymaster_id' => $this->input->post('country_new_state'),
                        'status' => '1'
                    );
                    $state_id = $this->countrymodel->addState($data_state);
                    $this->session->set_userdata('success', 'State added Successfully');
                } else if (($this->input->post('updatestate') == 'Submit') && ($this->input->post('hcountry_new_state') != '')) {

                    $data_state = array(
                        'state_name' => ucwords(strtolower($this->input->post('state_new_state'))),
                        'countrymaster_id' => $this->input->post('country_new_state'),
                    );
                    $state_id = $this->input->post('hcountry_new_state');
                    //echo $state_id;
                    $result = $this->countrymodel->updateState($state_id, $data_state);
                    $this->session->set_userdata('success', 'State updated Successfully');
                }

                // $this->localisation('tb1_c');
                redirect('localisation/localisation/tb1_c', 'refresh');
            }

            //update city

            if ($this->input->post('updatecity')) {
                //echo $this->input->post('city_new_city');die();
                $this->load->model('countrymodel');
                if (($this->input->post('updatecity') == 'Submit') && ($this->input->post('hcity_new_city') == '')) {
                    $data_city = array(
                        'countrymaster_id' => ucwords(strtolower($this->input->post('country_new_city'))),
                        'statemaster_id' => $this->input->post('state_new_city'),
                        'city_name' => $this->input->post('city_new_city'),
                        'status' => '1'
                    );
                    $city_id = $this->countrymodel->addCity($data_city);
                    $this->session->set_userdata('success', 'City added Successfully');
                } else if (($this->input->post('updatecity') == 'Submit') && ($this->input->post('hcity_new_city') != '')) {
                    $data_city = array(
                        'countrymaster_id' => ucwords(strtolower($this->input->post('country_new_city'))),
                        'statemaster_id' => $this->input->post('state_new_city'),
                        'city_name' => $this->input->post('city_new_city'),
                    );
                    $city_id = $this->input->post('hcity_new_city');
                    $result = $this->countrymodel->updateCity($city_id, $data_city);
                    $this->session->set_userdata('success', 'City updated Successfully');
                }

                // $this->localisation('tb1_d');
                redirect('localisation/localisation/tb1_d', 'refresh');
            }

            //update office type
            if ($this->input->post('updateofficetype')) {



                if ($this->input->post('office_parent_ot') == '') {
                    $priority = 1;
                } else {
                    $priority = (int) $this->input->post('office_parent_ot') + 1;
                }

                if (($this->input->post('updateofficetype') == 'Submit')) {
                    $is_present = $this->companymodel->getOfficeTypeIsPresent($this->input->post('office_type_company'), $this->input->post('office_parent_ot'), $this->input->post('newofficetype'));

                    if (!empty($is_present)) {
                        $this->session->set_userdata('warning', 'Office type Of Company Already Exist!');
                        $data_op = array(
                            'office_type_name' => ucwords(strtolower($this->input->post('newofficetype'))),
                            'office_type_parent_id' => (int) $this->input->post('office_parent_ot'),
                            'company_master_id' => (int) $this->input->post('office_type_company'),
                            'is_virtual_office' => $this->input->post('vcomp')
                        );
                        $this->localisation('tb1_f', $data_op);
                    } else {
                        $data_op = array();
                        $data_op = array(
                            'office_type_name' => ucwords(strtolower($this->input->post('newofficetype'))),
                            'office_type_parent_id' => (int) $this->input->post('office_parent_ot'),
                            'company_master_id' => (int) $this->input->post('office_type_company'),
                            'is_virtual_office' => $this->input->post('vcomp'),
                            'priority' => $priority,
                            'office_type_status' => '0'
                        );
                        $this->companymodel->addOfficeType($data_op);
                        $this->session->set_userdata('success', 'Office type added Successfully');
                    }
                } elseif (($this->input->post('updateofficetype') == 'Update')) {
                    $is_present = $this->companymodel->getOfficeTypeIsPresent($this->input->post('office_type_company'), $this->input->post('office_parent_ot'), $this->input->post('newofficetype'), $this->input->post('office_type_id'));
                    if (!empty($is_present)) {
                        $this->session->set_userdata('warning', 'Office type Of Company Already Exist!');
                        $data_op = array(
                            'office_type_name' => ucwords(strtolower($this->input->post('newofficetype'))),
                            'office_type_parent_id' => (int) $this->input->post('office_parent_ot'),
                            'company_master_id' => (int) $this->input->post('office_type_company'),
                            'is_virtual_office' => $this->input->post('vcomp')
                        );
                        $this->localisation('tb1_f', $data_op);
                    }
                    $office_type_id = $this->input->post('office_type_id');
                    $data_op = array();
                    $data_op = array(
                        'office_type_name' => $this->input->post('newofficetype'),
                        'office_type_parent_id' => (int) $this->input->post('office_parent_ot'),
                        'company_master_id' => (int) $this->input->post('office_type_company'),
                        'is_virtual_office' => $this->input->post('vcomp'),
                        'priority' => $priority
                    );
                    $this->companymodel->updateOfficeType($office_type_id, $data_op);
                    $this->session->set_userdata('success', 'Office type Updated Successfully');
                }

                //$this->localisation('tb1_f');
                redirect('localisation/localisation/tb1_f', 'refresh');
            }

            if ($this->input->post('updatedepartment')) {
                if (($this->input->post('updatedepartment') == 'Submit')) {
                    $data = array(
                        'department_name' => $this->input->post('newdepartment'),
                        'department_status' => '1'
                    );

                    $this->db->insert($this->db->dbprefix . 'department', $data);
                    $this->session->set_userdata('success', 'Department added Successfully');
                } else if (($this->input->post('updatedepartment') == 'Update')) {
                    $data = array(
                        'department_name' => $this->input->post('newdepartment'),
                    );
                    $condition_array = array('department_id' => $this->input->post('department_id'));
                    $this->db->where($condition_array);
                    $result = $this->db->update($this->db->dbprefix . 'department', $data);
                    $this->session->set_userdata('success', 'Department updated Successfully');
                }
                // $this->localisation('tb1_h');
                redirect('localisation/localisation/tb1_h', 'refresh');
            }
        } else {
            //$this->localisation('tb1_b');
            redirect('localisation/localisation/tb1_b', 'refresh');
        }
    }

    //update localisation
    public function updatecompanystatus($company_id, $status) {
        $data = array();
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        $this->load->model('companymodel');
        if ($status == 0) {
            $status = 1;
            $condition_array = array('company_master_id' => $company_id);
            $this->db->where($condition_array);
            $data = array('status' => $status);
            $result = $this->db->update($this->db->dbprefix . 'company_master', $data);
            $this->session->set_userdata('success', 'Company Activated Successfully');
        } else if ($status == 1) {
            $is_present_in_user = $this->companymodel->getCompanyIsInUserMaster($company_id);
            if (!empty($is_present_in_user)) {
                $this->session->set_userdata('warning', 'Company is in use, You can not Deactivate Company !');
            } else {
                $status = 0;
                $condition_array = array('company_master_id' => $company_id);
                $this->db->where($condition_array);
                $data = array('status' => $status);
                $result = $this->db->update($this->db->dbprefix . 'company_master', $data);
                $this->session->set_userdata('success', 'Company Dectivated Successfully');
            }
        }
        redirect('localisation/localisation/tb1_e', 'refresh');
    }

    public function updatecompany($comany_master_id = '') {
        $this->load->model('companymodel');
        $this->load->model('countrymodel');
        $this->load->model('commonmodel');
        $this->load->model('clientadminmodel');
        $this->load->model('generalesettings');
        $data = array();
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();        
        
        $data['ismulticompany'] = $this->generalesettings->getIsMultiCompany();
        $data['deactivated_country_result'] = $this->countrymodel->getDeactivatedCountries();
        $data['deactivated_state_result'] = $this->countrymodel->getDeactivatedStates();
        $data['deactivated_city_result'] = $this->countrymodel->getDeactivatedCities();
        $comapny_result = $this->companymodel->getCompany($comany_master_id);
        $data['postinfo'] = '';
        $company_master_info = array();

        if (!empty($comapny_result)) {
            $company_master_info = array(
                'company_master_id' => $comapny_result->company_master_id,
                'company_name' => $comapny_result->company_name,
                'status' => $comapny_result->status,
                'addressmaster_id' => $comapny_result->addressmaster_id,
                'address_1' => $comapny_result->address_1,
                'area' => $comapny_result->area,
                'plot_no' => $comapny_result->plot_no,
                'street' => $comapny_result->street,
                'landmark' => $comapny_result->landmark,
                'countrymaster_id' => $comapny_result->countrymaster_id,
                'statemaster_id' => $comapny_result->statemaster_id,
                'citymaster_id' => $comapny_result->citymaster_id,
                'mobile_no' => $comapny_result->mobile_no,
                'zipcode' => $comapny_result->zipcode,
                'phone_no' => $comapny_result->phone_no,
                'fax_no' => $comapny_result->fax_no,
            );
            $state_result = $this->commonmodel->getDropDownSQL($comapny_result->countrymaster_id);
            foreach ($state_result as $key => $val) {
                $state_master[$val->statemaster_id] = $val->state_name;
            }
            $city_result = $this->commonmodel->getDropDownSQL($comapny_result->countrymaster_id, $comapny_result->statemaster_id);
            foreach ($city_result as $key => $val) {
                $city_master[$val->citymaster_id] = $val->city_name;
            }
        }





        $data['tab'] = 'tb1_e'; //$tab;


        $country_result = $this->commonmodel->getDropDownSQL();
        $country_master = array();

        foreach ($country_result as $key => $val) {
            $country_master[$val->countrymaster_id] = $val->country_name;
        }
        $company_infos = $this->companymodel->getCompanies();

        $ofice_list = $this->companymodel->getOfficeTypes();

        //  $office_master = array();
        //get row per page
        $data['row_per_page'] = $this->generalesettings->getRowsPerPage();
        $data['office_type_cmp'] = $this->companymodel->getCompaniesHavingOfficeType();
        $data['office_addresses'] = $this->companymodel->getOfficeAddresses();

        $data['department_infos'] = $this->companymodel->getDepartments();

        $data['office_type_master'] = $ofice_list;
        // $company_infos = $this->companymodel->getCompanies();
        $data['company_master'] = $company_infos;
        $data['update_company_master'] = $company_master_info;
        $data['country_master'] = $country_master;
        $data['state_master'] = $state_master;
        $data['city_master'] = $city_master;
        $data['button_text'] = 'Update';
        $data['topmenu'] = $this->topmenu->apraiseemenulist();
        $data['action'] = 'localisation/savelocalisationdata';
        $this->load->view('default/clientadmin/cadmin_header',$data);
        $this->load->view('default/clientadmin/cadmin_localisation', $data);
    }

    //get data for uppdation of office type
    public function updateofficetype($office_type_id) {

        $this->load->model('companymodel');
        $this->load->model('countrymodel');
        $this->load->model('commonmodel');
        $this->load->model('clientadminmodel');
        $this->load->model('generalesettings');
        $result_ot = $this->companymodel->getOfficeType($office_type_id);
        $update_office_type = $this->companymodel->getOfficeTypesOfComany($result_ot->company_master_id);

        $data = array();
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        $data['tab'] = 'tb1_f'; //$tab;


        $country_result = $this->commonmodel->getDropDownSQL();
        $country_master = array();

        foreach ($country_result as $key => $val) {
            $country_master[$val->countrymaster_id] = $val->country_name;
        }
        $data['deactivated_country_result'] = $this->countrymodel->getDeactivatedCountries();
        $data['deactivated_state_result'] = $this->countrymodel->getDeactivatedStates();
        $data['deactivated_city_result'] = $this->countrymodel->getDeactivatedCities();
        $data['postinfo'] = '';

        $company_infos = $this->companymodel->getCompanies();

        $ofice_list = $this->companymodel->getOfficeTypes();

        //$office_master = array();
        //get row per page
        $data['row_per_page'] = $this->generalesettings->getRowsPerPage();
        $data['office_type_cmp'] = $this->companymodel->getCompaniesHavingOfficeType();
        $data['office_addresses'] = $this->companymodel->getOfficeAddresses();
        $data['department_infos'] = $this->companymodel->getDepartments();

        $data['office_type_master'] = $ofice_list;
        $data['update_office_type'] = $result_ot;
        $data['update_office'] = $update_office_type;
        $data['company_master'] = $company_infos;
        $data['country_master'] = $country_master;
        $data['button_text'] = 'Update';
        $data['topmenu'] = $this->topmenu->apraiseemenulist();
        $data['action'] = 'localisation/savelocalisationdata';
        $this->load->view('default/clientadmin/cadmin_header',$data);
        $this->load->view('default/clientadmin/cadmin_localisation', $data);
    }

    public function updateofficeaddress($office_addressess_id = '') {
        $this->load->model('companymodel');
        $result_office_updt_add = $this->companymodel->getOfficeAddress($office_addressess_id);

        $this->load->model('countrymodel');
        $this->load->model('commonmodel');
        $this->load->model('clientadminmodel');
        $this->load->model('generalesettings');
        $data = array();
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        $data['tab'] = 'tb1_g';
        $data['deactivated_country_result'] = $this->countrymodel->getDeactivatedCountries();
        $data['deactivated_state_result'] = $this->countrymodel->getDeactivatedStates();
        $data['deactivated_city_result'] = $this->countrymodel->getDeactivatedCities();
        $data['ismulticompany'] = $this->generalesettings->getIsMultiCompany();
        $data['postinfo'] = '';

        $country_result = $this->commonmodel->getDropDownSQL();
        $country_master = array();

        foreach ($country_result as $key => $val) {
            $country_master[$val->countrymaster_id] = $val->country_name;
        }


        $company_infos = $this->companymodel->getCompanies();

        $ofice_list = $this->companymodel->getOfficeTypes();
        $data['office_update_address'] = $result_office_updt_add;
        $state_result = $this->commonmodel->getDropDownSQL($result_office_updt_add->countrymaster_id);
        $state_master = array();

        foreach ($state_result as $key => $val) {
            $state_master[$val->statemaster_id] = $val->state_name;
        }
        $city_result = $this->commonmodel->getDropDownSQL($result_office_updt_add->countrymaster_id, $result_office_updt_add->statemaster_id);
        $city_master = array();

        foreach ($city_result as $key => $val) {
            $city_master[$val->citymaster_id] = $val->city_name;
        }
        // $office_update_address =  $result_office_updt_add;
        // $result_office_type_nm_updat = $this->companymodel->getReortedOfficeNames($office_update_address->company_master_id,$office_update_address->office_type_id,$office_update_address->office_reported_office_id);
        $data['row_per_page'] = $this->generalesettings->getRowsPerPage();

        $data['office_type_cmp'] = $this->companymodel->getCompaniesHavingOfficeType();
        $data['office_addresses'] = $this->companymodel->getOfficeAddresses();

        $data['department_infos'] = $this->companymodel->getDepartments();
        $data['office_type_master'] = $ofice_list;
        $data['company_master'] = $company_infos;
        $data['country_master'] = $country_master;
        $data['state_master'] = $state_master;
        $data['city_master'] = $city_master;
        $data['button_text'] = 'Update';
        $data['action'] = 'localisation/savelocalisationdata';
        $this->load->view('default/clientadmin/cadmin_header');
        $this->load->view('default/clientadmin/cadmin_localisation', $data);
    }

    public function updatedepartmentstatus($department_id = '') {
        $this->load->model('companymodel');
        $result_dt = $this->companymodel->getDepartment($department_id);
        $data = array();
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        if (!empty($result_dt)) {
            $data = array();
            if ($result_dt->department_status == 1) {
                $data = array('department_status' => '2');
            } elseif ($result_dt->department_status == 2) {
                $data = array('department_status' => '1');
            } else {
                $data = array('department_status' => '0');
            }
            $this->companymodel->updateDepartment($department_id, $data);
        }
        $this->session->set_userdata('success', 'Department Status updated Successfully');
        //$this->localisation('tb1_h');
        redirect('localisation/localisation/tb1_h', 'refresh');
    }

    //get data for uppdation of department
    public function updatedepartment($department_id) {
        $data = array();
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        $this->load->model('companymodel');
        $data['updatedept'] = $this->companymodel->getDepartment($department_id);

        $data['tab'] = 'tb1_h'; //$tab;
        $this->load->model('companymodel');
        $this->load->model('commonmodel');
        $this->load->model('clientadminmodel');
        $this->load->model('generalesettings');
        $data['ismulticompany'] = $this->generalesettings->getIsMultiCompany();
        $country_result = $this->commonmodel->getDropDownSQL();
        $country_master = array();

        foreach ($country_result as $key => $val) {
            $country_master[$val->countrymaster_id] = $val->country_name;
        }
        $company_infos = $this->companymodel->getCompanies();

        $ofice_list = $this->companymodel->getOfficeTypes();

        $office_master = array();
        $data['department_infos'] = $this->companymodel->getDepartments();
        $data['office_type_master'] = $ofice_list;
        $data['company_master'] = $company_infos;
        $data['country_master'] = $country_master;
        $data['button_text'] = 'Update';

        $data['action'] = 'localisation/savelocalisationdata';
        $this->load->view('default/clientadmin/cadmin_header');
        $this->load->view('default/clientadmin/cadmin_localisation', $data);
    }

    public function updatecountrystatus($country_id = '', $status = '') {
        if ($status == 0) {
            $this->load->model('countrymodel');
            $this->countrymodel->updateCountry($country_id, $data = array('status' => '1'));
            $this->session->set_userdata('success', 'Country activated Successfully.');
        }
        redirect('localisation', 'refresh');
    }

    public function updatestatestatus($state_id = '', $status = '') {
        if ($status == 0) {
            $this->load->model('countrymodel');
            $this->countrymodel->updateState($state_id, $data = array('status' => '1'));
            $this->session->set_userdata('success', 'State activated Successfully.');
        }
        redirect('localisation/localisation/tb1_c', 'refresh');
    }

    public function updatecitystatus($city_id = '', $status = '') {
        if ($status == 0) {
            $this->load->model('countrymodel');
            $this->countrymodel->updateCity($city_id, $data = array('status' => '1'));
            $this->session->set_userdata('success', 'City activated Successfully.');
        }
        redirect('localisation/localisation/tb1_d', 'refresh');
    }

    public function updateofficetypestatus($office_type_id) {
        $data = array();
        $data['site_name'] = $this->generalesettings->getSiteName();        
        $data['logo'] = $this->generalesettings->getImage();
        
        $this->load->model('companymodel');
        $office_type_info = $this->companymodel->getOfficeType($office_type_id);
        $office_type_status = $office_type_info->office_type_status;

        if ($office_type_status == 0) {
            $result = $this->companymodel->getOfficeAdressByOfficeTypeIds(array($office_type_id));
            if (!empty($result)) {
                $response['status'] = 1; //can not denied
                $this->session->set_userdata('warning', 'Office Type Already in Use You can Not Suspend.');
            } else {
                $response['status'] = 2;
                $data['office_type_status'] = '1';
                $condition_ary = array('office_type_id' => $office_type_id);
                $this->db->where($condition_ary);
                $result = $this->db->update($this->db->dbprefix . 'office_type', $data);
                $this->session->set_userdata('success', 'Office Type Deactivated Successfully.');
            }
        } else {
            $response['status'] = 3;
            $data['office_type_status'] = '0';
            $condition_ary = array('office_type_id' => $office_type_id);
            $this->db->where($condition_ary);
            $result = $this->db->update($this->db->dbprefix . 'office_type', $data);
            $this->session->set_userdata('success', 'Office Type Activated Successfully.');
        }
        redirect('localisation/localisation/tb1_f', 'refresh');
    }

    //update localisation
    public function updateofficeaddressstatus($office_address_id, $status) {
        $data = array();
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        
        $this->load->model('companymodel');
        if ($status == 0) {
            $status = 1;
            $condition_array = array('office_addresses_id' => $office_address_id);
            $this->db->where($condition_array);
            $data = array('office_address_status' => $status);
            $result = $this->db->update($this->db->dbprefix . 'office_addresses', $data);
            $this->session->set_userdata('success', 'Office Address Activated Successfully');
        } else if ($status == 1) {
            $is_present_in_user = $this->companymodel->getOfficeAdressessIsInUserMaster($office_address_id);
            if (!empty($is_present_in_user)) {
                $this->session->set_userdata('warning', 'Office Address is in use, You can not Deactivate Office Address !');
            } else {
                $status = 0;
                $condition_array = array('office_addresses_id' => $office_address_id);
                $this->db->where($condition_array);
                $data = array('office_address_status' => $status);
                $result = $this->db->update($this->db->dbprefix . 'office_addresses', $data);
                $this->session->set_userdata('success', 'Office Address Dectivated Successfully');
            }
        }
        redirect('localisation/localisation/tb1_g', 'refresh');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */