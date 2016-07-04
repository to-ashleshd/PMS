<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Countrymodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    //add country
    function addCountry($data = array())
    {
           $result = $this->db->insert($this->db->dbprefix . 'countrymaster', $data);
           $countrymaster_id = $this->db->insert_id();
           return $countrymaster_id;
    }
    
    
    //update country
    function updateCountry($country_id,$data = array())
    {
        $condition_array = array('countrymaster_id'=>$country_id);
        $this->db->where($condition_array);
        $result = $this->db->update($this->db->dbprefix . 'countrymaster', $data);
        return $result;
    }
    
    function getCountry($country_id)
    {
       $condition_array = array('countrymaster_id' => $country_id,'status'=>'1');
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'countrymaster' );
       $this->db->where($condition_array);
       $this->db->order_by("country_name", "asc");
       $query = $this->db->get();
       $row = $query->first_row();
       return $row;
    }
    
    function getState($state_id)
    {
       $condition_array = array('statemaster_id' => $state_id,'status'=>'1');
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'statemaster' );
       $this->db->where($condition_array);
        $this->db->order_by("state_name", "asc");
       $query = $this->db->get();
       $row = $query->first_row();
       return $row;

    }
  
    
    //add state master
    function addState($data = array())
    {
           $result = $this->db->insert($this->db->dbprefix . 'statemaster', $data);
           $statemaster_id = $this->db->insert_id();
           return $statemaster_id;
    }
 
    //update state
    function updateState($state_id,$data = array())
    {
        $condition_array = array('statemaster_id'=>$state_id);
        $this->db->where($condition_array);
        $result = $this->db->update($this->db->dbprefix . 'statemaster', $data);
        return $result;
    }
   
    
      
    function getCity($city_id)
    {
       $condition_array = array('citymaster_id' => $city_id,'status'=>'1');
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'citymaster' );
       $this->db->where($condition_array);
       $this->db->order_by("city_name", "asc");
       $query = $this->db->get();
       $row = $query->first_row();
       return $row;

    }
    
    
    //add city master
    function addCity($data = array())
    {
           $result = $this->db->insert($this->db->dbprefix . 'citymaster', $data);
           $citymaster_id = $this->db->insert_id();
           return $citymaster_id;
    }
    
    
    
     //update city
    function updateCity($city_id,$data = array())
    {
        $condition_array = array('citymaster_id'=>$city_id);
        $this->db->where($condition_array);
        $result = $this->db->update($this->db->dbprefix . 'citymaster', $data);
        return $result;
    }
    
    
    function getDeactivatedCountries()
    {
       $condition_array = array('status'=>'0');
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'countrymaster' );
       $this->db->where($condition_array);
       $this->db->order_by("country_name", "asc");
       $query = $this->db->get();
       $row = $query->result();
       return $row;
    }
    
     function getDeactivatedStates()
    {
       $condition_array = array('status'=>'0');
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'statemaster' );
       $this->db->where($condition_array);
       $this->db->order_by("state_name", "asc");
       $query = $this->db->get();
       $row = $query->result();
       return $row;
    }
    
    function getDeactivatedCities()
    {
       $condition_array = array('status'=>'0');
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'citymaster' );
       $this->db->where($condition_array);
        $this->db->order_by("city_name", "asc");
       $query = $this->db->get();
       $row = $query->result();
       return $row;
    }
    
   function getAllCityByName($city_name='')
    {
       $condition_array = array('status'=>'1');
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'citymaster');
       $this->db->where($condition_array);
       $this->db->like('LCASE(city_name)',strtolower($city_name), 'after'); 
       $this->db->order_by("city_name", "asc");
       $query = $this->db->get();
       $row = $query->result_array();
       //echo $this->db->last_query();
      // print_r($row);
      // die();
       return $row;

    }
    
    
    
    

}