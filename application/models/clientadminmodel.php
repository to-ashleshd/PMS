<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Clientadminmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function new_clientadmin() {
        
        $data = array(
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
            'f_name' => $this->input->post('fname'),
            'l_name' => $this->input->post('lname'),
            'gender' => $this->input->post('gender')
        );

        $result = $this->db->insert($this->db->dbprefix . 'clientadmin', $data);

        return $result;
    }

  //add company
    function addCompany()
    {
        $data = array(
            'company_name' => $this->input->post('company_name'),
            'status'       => '1'
        );
     
       $this->db->insert($this->db->dbprefix . 'company_master', $data); 
       $company_id = $this->db->insert_id();
       $this->load->model('clientadminmodel');
       $this->load->model('addressmastermodel');
       $this->load->model('countrymodel');
       $countrymaster_id = $this->input->post('country_company');
       
       if(isset($_POST['otherstate']))
       {
          
           $isState = $this->checkOtherState($this->input->post('otherstate'));
           if(!empty($isState))
           {
               $countrymaster_id = $isState->countrymaster_id;
               $statemaster_id = $isState->statemaster_id;
           }
           else
           {
              $data_cntry = array('countrymaster_id' => $countrymaster_id,'state_name'=>$this->input->post('otherstate'),'status'=>'1');
              $statemaster_id = $this->countrymodel->addState($data_cntry);
           }
       }
       else
       {
           $statemaster_id = $this->input->post('state_company');
       }
       if(isset($_POST['othercity']))
       {
           $isCity = $this->checkOtherCity($this->input->post('othercity'));
           if(!empty($isCity))
           {
               $countrymaster_id = $isCity->countrymaster_id;
               $statemaster_id   = $isCity->statemaster_id;
               $citymaster_id  = $isCity->citymaster_id;
           }
           else
           {
              $data_stat = array('countrymaster_id' => $countrymaster_id,'statemaster_id' => $statemaster_id,'city_name'=>$this->input->post('othercity'),'status'=>'1');
              $citymaster_id = $this->countrymodel->addCity($data_stat);
           }
       }
       else
       {
           $countrymaster_id = $this->input->post('country_company');
           $statemaster_id = $this->input->post('state_company');
           $citymaster_id = $this->input->post('city_company');
       }
       $countryinfo = $this->countrymodel->getCountry($countrymaster_id);
       $country_name = $countryinfo->country_name;
       $stateinfo   = $this->countrymodel->getState($statemaster_id);
       $state_name = $stateinfo->state_name;
       $city_info    = $this->countrymodel->getCity($citymaster_id);
       $city_name = $city_info->city_name;
       
       $object_id= $company_id;
       $objecttype_id ='2';
       $data_address = array(
                'object_id'        => $object_id,
                'objecttype_id'    => '2',
                'countrymaster_id' => $countrymaster_id,
                'statemaster_id'   => $statemaster_id,
                'citymaster_id'    => $citymaster_id,
                'country_name'     => $country_name,
                'state_name'       => $state_name,
                'city_name'        => $city_name,
               // 'address_1'        => $this->input->post('address1'),
                'area'             => $this->input->post('area'),
                'street'           => $this->input->post('street'),
                'landmark'         => $this->input->post('landmark'),
                'plot_no'             => $this->input->post('plot_office_no'),
                'zipcode'          => $this->input->post('zipcode'),
                'mobile_no'        => $this->input->post('mobile'),
                'phone_no'         => '',
                'fax_no'           => $this->input->post('fax')
            );
      $addressmaster_id = $this->addressmastermodel->addAddressMaster($data_address);
      $dt = array('addressmaster_id'=>$addressmaster_id);
      
      $condition_ary = array('company_master_id'=>$company_id);
      $this->db->where($condition_ary);
      $result = $this->db->update($this->db->dbprefix . 'company_master',$dt);
      return $result;
    }
    
    function updateCompany()
    {
       $this->load->model('addressmastermodel');
       $this->load->model('countrymodel');
       $company_updt_data = array();
                 $company_updt_data = array(
                     'company_name' => $this->input->post('company_name'),
                 );
        $condition_array = array('company_master_id'=>$this->input->post('company_id'));
        $this->db->where($condition_array);
        $result = $this->db->update($this->db->dbprefix . 'company_master', $company_updt_data);
        
      // $addressmaster_id = $this->input->post('addressmaster_id');
       $countrymaster_id = $this->input->post('country_company');
       if(isset($_POST['otherstate']))
       {
          
           $isState = $this->checkOtherState($this->input->post('otherstate'));
           if(!empty($isState))
           {
               $countrymaster_id = $isState->countrymaster_id;
               $statemaster_id = $isState->statemaster_id;
           }
           else
           {
              $data_cntry = array('countrymaster_id' => $countrymaster_id,'state_name'=>$this->input->post('otherstate'),'status'=>'1');
              $statemaster_id = $this->countrymodel->addState($data_cntry);
           }
       }
       else
       {
           $statemaster_id = $this->input->post('state_company');
       }
       if(isset($_POST['othercity']))
       {
           $isCity = $this->checkOtherCity($this->input->post('othercity'));
           if(!empty($isCity))
           {
               $countrymaster_id = $isCity->countrymaster_id;
               $statemaster_id   = $isCity->statemaster_id;
               $citymaster_id  = $isCity->citymaster_id;
           }
           else
           {
              $data_stat = array('countrymaster_id' => $countrymaster_id,'statemaster_id' => $statemaster_id,'city_name'=>$this->input->post('othercity'),'status'=>'1');
              $citymaster_id = $this->countrymodel->addCity($data_stat);
           }
       }
       else
       {
           $countrymaster_id = $this->input->post('country_company');
           $statemaster_id = $this->input->post('state_company');
           $citymaster_id = $this->input->post('city_company');
       }
       $countryinfo = $this->countrymodel->getCountry($countrymaster_id);
       $country_name = $countryinfo->country_name;
       $stateinfo   = $this->countrymodel->getState($statemaster_id);
       $state_name = $stateinfo->state_name;
       $city_info    = $this->countrymodel->getCity($citymaster_id);
       $city_name = $city_info->city_name;
       $address_updt_data = array(
                'countrymaster_id' => $countrymaster_id,
                'statemaster_id'   => $statemaster_id,
                'citymaster_id'    => $citymaster_id,
                'country_name'     => $country_name,
                'state_name'       => $state_name,
                'city_name'        => $city_name,
                //'address_1'        => $this->input->post('address1'),
                'area'             => $this->input->post('area'),
                'street'           => $this->input->post('street'),
                'landmark'         => $this->input->post('landmark'),
                'plot_no'             => $this->input->post('plot_office_no'),
                'zipcode'          => $this->input->post('zipcode'),
                'mobile_no'        => $this->input->post('mobile'),
                'fax_no'           => $this->input->post('fax')
       );
    
        $condition_array_add = array('addressmaster_id'=>$this->input->post('address_id'));
        $this->db->where($condition_array_add);
        $result = $this->db->update($this->db->dbprefix . 'addressmaster', $address_updt_data);
        return $result;
    }
    


    
    
    public function checkOtherState($state)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'statemaster' );
       $this->db->where('state_name',trim($state));
       $query = $this->db->get();
       $row = $query->first_row();
       
       if(empty($row))
       {
           return '';
       }
       else
       {
           return $row;
       }

    }
    
    public function checkOtherCity($city)
    {
       
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'citymaster' );
       $this->db->where('city_name',trim($city));
       $query = $this->db->get();
       $row = $query->first_row();
      
       if(empty($row))
       {
           return '';
       }
       else
       {
           return $row;
       }

    }
    
    function getClientAdminByUsername($username)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'clientadmin' );
       $this->db->where('username',trim($username));
       $query = $this->db->get();
       $row = $query->first_row();
       //echo  $this->db->last_query();
       return $row;
    }
    
    //get client admin by id
    function getClientAdminById($clientadmin_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'clientadmin' );
       $this->db->where('clientadmin_id',trim($clientadmin_id));
       $query = $this->db->get();
       $row = $query->first_row();
       //echo  $this->db->last_query();
       return $row;
    }
    

}