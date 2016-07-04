<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Eventscalendar extends MX_Controller {

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
    public function index() {
        //$this->load->view('welcome_message');
        echo "<br>This is Event Calendar";

        //$vars['calendar'] = $this->calendar->generate('', '', $data);
        //$this->load->view('calendar', $vars);
        $prefs = array(
            'show_next_prev' => TRUE,
            'next_prev_url' => 'http://example.com/index.php/calendar/show/',
            'day_type' => 'long'
        );
        $this->load->library('calendar');
        $data = array(
            3 => 'http://example.com/news/article/2006/03/',
            7 => 'http://example.com/news/article/2006/07/',
            13 => 'http://example.com/news/article/2006/13/',
            26 => 'http://example.com/news/article/2006/26/'
        );
        $vars['calendar'] = $this->calendar->generate('', '', $data);
        //$this->calendar->generate(date("Y"),date("n"),$data);
        $this->load->view('eventscalendarview', $vars);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */