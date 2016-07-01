<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Addressmastermodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    //add address master
    function addAddressMaster($data = array())
    {
          $this->db->insert($this->db->dbprefix . 'addressmaster', $data);
           $addressmaster_id = $this->db->insert_id();
          
           return $addressmaster_id;
    }
    
    function updateAddressMaster($object_id,$objecttype_id,$data = array())
    {
        $condition_array = array('object_id'=>$object_id,'objecttype_id'=>$objecttype_id);
        $this->db->where($condition_array);
        $result = $this->db->update($this->db->dbprefix . 'addressmaster', $data);
        return $result;
    }
    
    
     function updateAddressMasterByAddressId($addressmaster_id,$data = array())
    {
        $condition_array = array('addressmaster_id'=>$addressmaster_id);
        $this->db->where($condition_array);
        $result = $this->db->update($this->db->dbprefix . 'addressmaster', $data);
        return $result;
    }
    
    
    function getAddress($object_id ='',$objecttype_id='')
    {
       $condition_array = array('object_id'=>$object_id,'objecttypr_id'=>$objecttype_id);
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'addressmaster' );
       $this->db->where($condition_array);
       $query = $this->db->get();
       $row = $query->first_row();
       return $row;
    }
    
    function getAddressIdByUserId($user_id)
    {
        $addressmaster_table = $this->db->dbprefix . 'addressmaster';
        $query = $this->db->get_where($addressmaster_table, array('object_id' => $user_id, 'objecttype_id'=> '1'));
       
       $row = $query->first_row();
       return $row;
    }
    
    
    public function  checkOtherCountry($country)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'countrymaster' );
       $this->db->where('country_name',trim($country));
       $query = $this->db->get();
       $row = $query->first_row();
       if(empty($row))
       {
           return false;
       }
       else
       {
           return true;
       }

    }

}