<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mylanguage extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		//$this->load->view('welcome_message');
            echo "<br>This is My Language" ;
            
            $this->lang->load('english', 'english');
            $data['eng_about'] = $this->lang->line('about');
            
            $this->lang->load('marathi', 'marathi');
            $data['marathi_about'] = $this->lang->line('about');
            
            $this->load->view('mylanguageview',$data) ;
            
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */