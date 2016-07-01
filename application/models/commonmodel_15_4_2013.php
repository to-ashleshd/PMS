<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Commonmodel extends CI_Model {

    //public $db = "";

    function __construct() {
        parent::__construct();
    }

    /*
     * **********************************************
     * *** Core Functions ***
     * **********************************************
     */

    /**
     * Crate Dropdown List based on table
     * @param string $table_name
     * @param string $value_field
     * @param string $display_field
     * @param number $default_id (Optional)
     * @param string $default_name (Optional. If Not given then use table name as name)
     * @return Dropdown list
     */
    function getDropDownSQL($country_id = '', $state_id = '') {
        $table_country = $this->db->dbprefix . 'countrymaster';
        $table_state = $this->db->dbprefix . 'statemaster';
        $table_city = $this->db->dbprefix . 'citymaster';

        if ($country_id == '' and $state_id == '') {
            //Get List for Country
           $this->db->select('*');
           $this->db->from($table_country);
           $this->db->where(array('status'=>'1'));
            $this->db->order_by("country_name", "asc");
            $query = $this->db->get();
            
        }

        if ($country_id >= 1 and $state_id == '') {
            //Get List for States
              $this->db->select('*');
           $this->db->from($table_state);
           $this->db->where(array('countrymaster_id' => $country_id,'status'=>'1'));
            $this->db->order_by("state_name", "asc");
            $query = $this->db->get();
        }

        if ($country_id >= 1 and $state_id >= 1) {
            //Get List for Cities
                $this->db->select('*');
           $this->db->from($table_city);
           $this->db->where(array('statemaster_id' => $state_id,'status'=>'1'));
            $this->db->order_by("city_name", "asc");
            $query = $this->db->get_where();
        }
        
        //$result = $query->result();
       if(isset($query))
        {
        $result = $query->result();
        }
        else
        {
            $result ='';
        }
//        echo "<pre>";
// print_r($result);
// echo $this->db->last_query();
// echo "</pre>";
        return $result;
    }

    function getSQLDropDown($query_result, $value_field, $display_field, $default_id = '', $default_name = '', $extra_css = '') {

        $output = '';
        $output .= '<select name="select_' . $default_name . '" id="select_' . $default_name . '" ' . $extra_css . ' >';
        foreach ($query_result as $key => $val) {
            $is_selected = '';            
            if ($val->$value_field == $default_id) {
                $is_selected = " selected='selected' ";
            }

            $output .= '<option value="' . $val->$value_field . '" ' . $is_selected . ' >' . $val->$display_field . '</option>';
        }
        $output .= '</select>';

        return $output;
    }

    function getDropDown($table_name, $value_field, $display_field, $default_id = '', $default_name = '') {
        if ($default_name == '') {
            $default_name = $table_name;
        }

        $query = $this->db->get($table_name);
        $result = $query->result();
        $output = '';
        $output .= '<select name="select_' . $default_name . '" id="select_' . $default_name . '" >';
        foreach ($result as $key => $val) {
            $is_selected = '';
            if ($val->$value_field == $default_id) {
                $is_selected = " selected='selected' ";
            }

            $output .= '<option value="' . $val->$value_field . '" ' . $is_selected . ' >' . $val->$display_field . '</option>';
        }
        $output .= '</select>';

        return $output;
    }

    /** Function for update settings * */
    function update_env_setting($setting_name, $setting_value) {
        $data = array();
        $env_table = $this->db->dbprefix . 'env_setting_install';

        //check for if value is exists in table or not
       // $isexists = $this->get_env_setting($setting_name);
        $isexists = $this->is_env_setting_key_exists($setting_name);
        if ($isexists == false) {
            //No value found. Add new record
            $data = array('setting_value' => $setting_value, 'setting_name' => $setting_name);
            $result = $this->db->insert($env_table, $data);
        } else {
            //Value found. Update record
            $data = array('setting_value' => $setting_value);            
            $result = $this->db->update($env_table, $data, array('id' => $isexists));
        }

        /**
        if ($isexists == false) {
            //No value found. Add new record
            $data = array('setting_value' => $setting_value, 'setting_name' => $setting_name);
            $result = $this->db->insert($env_table, $data);
        } else {
            //Value found. Update record
            $data = array('setting_value' => $setting_value);            
            $result = $this->db->update($env_table, $data, array('setting_name' => $setting_name));
        }
         * 
         */

        return $result;
    }

    function get_env_setting($setting_name) {
        $output = false;
        //$data = array();
        //$data = array('setting_value' => $setting_value);
        $env_table = $this->db->dbprefix . 'env_setting_install';
        $query = $this->db->get_where($env_table, array('setting_name' => $setting_name));
        $row = $query->first_row();
        $total_rows = $query->num_rows();
        if ($total_rows >= 1) {
            $output = $row->setting_value;
        }
        /**
          echo '<pre>';
          print_r($row);
          echo '<br>total: ' . $total_rows;
          echo '</pre>';
         **/
        return $output;
    }
    
    function is_env_setting_key_exists($keyname)
    {
        $output = false ;
        //check key in `ecore_env_setting_install`
        //If Found then return primary key else false
        $env_table = $this->db->dbprefix . 'env_setting_install';
        $query = $this->db->get_where($env_table, array('setting_name' => $keyname));
        $total_rows = $query->num_rows();
        if( $total_rows >= 1) {
            $result = $query->first_row();
            $output = $result->id ; 
        }
        
        return $output;        
    }
    
    
    

    /*
     * **********************************************
     * Calling Functions
     * **********************************************
     */

    function countryDropDown($default_id = '') {
      
        $value_field = 'countrymaster_id';
        $display_field = 'country_name';
        $query_result = $this->getDropDownSQL();
        $default_name = 'country';
        $extra_css = '';
        $result = $this->getSQLDropDown($query_result, $value_field, $display_field, $default_id, $default_name, $extra_css);

        return $result;
    }

    function stateDropDown($country_id, $default_id = '') {

        $value_field = 'statemaster_id';
        $display_field = 'state_name';
        $query_result = $this->getDropDownSQL($country_id);
        $default_id = '';
        $default_name = 'state';
        $extra_css = '';

        $result = $this->getSQLDropDown($query_result, $value_field, $display_field, $default_id, $default_name, $extra_css);

        return $result;
    }

    function cityDropDown($country_id, $state_id, $default_id = '') {

        $value_field = 'citymaster_id';
        $display_field = 'city_name';
        $query_result = $this->getDropDownSQL($country_id, $state_id);
        $default_id = '';
        $default_name = 'city';
        $extra_css = '';

        $result = $this->getSQLDropDown($query_result, $value_field, $display_field, $default_id, $default_name, $extra_css);

        return $result;
    }
    
    function getWeightageByid($weightage_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'weightage' );
       $this->db->where('weightage_id',$weightage_id);
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;
    }
    
    function getRatingByid($rating_id)
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'rating' );
       $this->db->where('rating_id',$rating_id);
       $query = $this->db->get();
       $row = $query->first_row('array');
       return $row;
    }
    
  
    
    
    function getCompetencyIDSAccordingEmployeeGrade($grade_id)
    {
       $competencies_id = array('0');
       $this->db->select('competencies_for_refrence_id');
       $this->db->distinct('competencies_for_refrence_id');
       $this->db->from($this->db->dbprefix . 'competencies_to_grade' );
       $this->db->where('grade_id',$grade_id);
       $query = $this->db->get();
       $row = $query->result_array();
       if(!empty($row))
       {
           foreach($row as $key=>$val)
           {
               $competencies_id[]   = $val['competencies_for_refrence_id'];
           }
       }
       return $competencies_id;
    }
    
    
    
    function getCompetencies($competencies_id = array())
    {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'competencies_for_refrence' );
       $this->db->where_in('competencies_for_refrence_id',$competencies_id);
       $this->db->join($this->db->dbprefix . 'weightage', 'weightage.weightage_id = competencies_for_refrence.weightage_id','left');
       $query = $this->db->get();
       $row = $query->result_array();
       return $row;
    }
    
    
    function getCompetenciesByGrade($grade_id)
    {
        $competencies_id        = $this->getCompetencyIDSAccordingEmployeeGrade($grade_id);
        $competencies_detail    = $this->getCompetencies($competencies_id);
        
        return $competencies_detail;
    }

    
   
    
}