<?php
if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Accessdenied extends CI_Controller {

//konstruktor klasy
    public function __construct() {
        parent::__construct();
        $this->topmenu->no_cache();
    }

    public function index() {
        $data = array();
        $this->load->model('commonmodel');
        $data['site_offline_msg'] = 'ACL Error:<br>You are not authorized to access this page.<br>Please contact your system administrator.';

        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['s_lang_visitors'] = $this->commonmodel->get_env_setting('s_lang_visitors');

         $data['topmenu']            = $this->topmenu->apraiseemenulist();
        
        $data['header']             =  $this->load->view('default/clientadmin/cadmin_header', $data,true);
        
        $data['middle_footer']      = $this->load->view('default/clientadmin/cadmin_middle_footer', $data,true);
        $data['common_js']          = $this->load->view('default/clientadmin/cadmin_common_js', $data,true);
        $data['last_footer']        = $this->load->view('default/clientadmin/cadmin_last_footer', $data,true);
        $this->load->view('default/clientadmin/user_offline_body', $data);

    }

}