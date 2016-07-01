<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Announcement extends CI_Controller {

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
        //  $this->dashboard();
        $this->topmenu->no_cache();
        $this->load->model('generalesettings');
        $this->load->model('announcementmodel');
    }

    public function index($tab = '', $tabid = '') {
        $this->Announcement();
    }

    function Announcement() {
        if ($this->session->userdata('pms_employee_id')) {
            $empid = $this->session->userdata('pms_employee_id');


            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $data['topmenu'] = $this->topmenu->apraiseemenulist();

            $data['announcement_list'] = $this->announcementmodel->getAllAnnouncements();

            $data['announcement_details'] = $this->load->view('default/clientadmin/cadmin_announcement_list', $data, true);

            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_beoro_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            $this->load->view('default/clientadmin/cadmin_announcement', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function ajax_addannouncement() {
        //print_r($_POST);
        extract($_POST);
        $response = array();
        $response['status'] = 'N';
        $response['msg'] = 'Error in process. Please try later.';

        if ($announcement_id <= 0) {
            //New Entry
            $datainsert = array(
                'announcement_subject' => $announcement_subject,
                'announcement_desc' => $announcement_desc,
                'date_created' => date("Y-m-d H:i:s")
            );
            $this->db->insert($this->db->dbprefix . "announcement", $datainsert);
            $response['msg'] = 'Record is added successfully.';
            $response['status'] = 'Y';
        } else {
            //Update Entry
            $updatedb = array('announcement_desc' => $announcement_desc, 'announcement_subject' => $announcement_subject);
            $this->db->update($this->db->dbprefix . "announcement", $updatedb, array('announcement_id' => $announcement_id));
            $response['msg'] = 'Record is updated successfully.';
            $response['status'] = 'Y';
        }

        die(json_encode($response));
    }

    function ajax_getannouncementlist() {
        $response = array();
        $response['announcement_list'] = $this->announcementmodel->getAllAnnouncements();

        $response['announcement_details'] = $this->load->view('default/clientadmin/cadmin_announcement_list', $response, true);

        die(json_encode($response));
    }

    function ajax_suspend() {
        $response = array();
        $announcement_id = $_POST['announcement_id'];
        $result = $this->announcementmodel->dosuspend($announcement_id);

        $response['result'] = $result;
        $response['status'] = 'Y';
        $response['msg'] = 'Record is suspended.';

        die(json_encode($response));
    }

    function ajax_active() {
        $response = array();
        $announcement_id = $_POST['announcement_id'];
        $result = $this->announcementmodel->doactive($announcement_id);

        $response['result'] = $result;
        $response['status'] = 'Y';
        $response['msg'] = 'Record is Activated.';

        die(json_encode($response));
    }

    function ajax_getinfo() {
        $response = array();
        $announcement_id = $_POST['announcement_id'];
        $result = $this->announcementmodel->getAllAnnouncements($announcement_id);
        //print_r($result);

        $response['announcement_subject'] = $result[0]->announcement_subject;
        $response['announcement_desc'] = $result[0]->announcement_desc;


        die(json_encode($response));
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */