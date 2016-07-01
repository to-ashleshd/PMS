<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Materialv1 extends CI_Controller {

    function __construct() {
        parent::__construct();
    
    }

    public function index() {
        $this->load->view('materialv1/dashboard');

        //$this->employee();
    }
    public function changepassword() {
        $this->load->view('materialv1/clientadmin/pms-changepass');

    }
         
}

