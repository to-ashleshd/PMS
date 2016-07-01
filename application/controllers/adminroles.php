<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Adminroles extends CI_Controller {

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
        $this->topmenu->no_cache();
        $this->load->model('generalesettings');
        //$this->load->helper('corefunctions');
    }

    public function index($tab = '', $tabid = '') {
        //$this->load->view('welcome_message');
        //Calling Default method as new
        $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['action'] = site_url('clientadmin/clientadminlogin');
            $data['button'] = 'Submit';
            $data['button_text'] = 'Login';
            $data['logo'] = $this->generalesettings->getImage();
            $data['tab'] = 'tb1_a';
            $data['current_tab'] = 'tb1_a';
        
        
        //echo $data['logo'] ;die();
        $this->session->set_userdata('logo', $data['logo']);

        //Loading View
        $data['topmenu']                = $this->topmenu->apraiseemenulist();
        $this->load->view('default/clientadmin/cadmin_header', $data);
        $this->load->view('default/clientadmin/cadmin_adminroles', $data);
        $this->load->view('default/clientadmin/cadmin_adminroles_footer', $data);
        
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */