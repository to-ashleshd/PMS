<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Recover extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->topmenu->no_cache();
        $this->load->model('generalesettings');
        $this->load->model('employeemodel');
        $this->load->model('commonmodel');
        $this->load->model('companymodel');
        $this->load->model('apraiseemodel');
        $this->load->model('apraisermodel');
        $this->load->model('taskschedulemodel');
    }

    function sendpasswordlink() {
        $data = array();
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();

        //check if user name is exists or not

        $forgot_email = filter_var($_POST['forgot_email'], FILTER_VALIDATE_EMAIL);

        $sql = "SELECT * from " . $this->db->dbprefix . "employee WHERE email='" . $forgot_email . "' ";
        $result = mysql_query($sql);
        $total_rows = mysql_num_rows($result);

        //echo '<br>Total Rows: ' . $total_rows;
        //print_r($result);


        if ($total_rows >= 1) {
            $emp_info = mysql_fetch_assoc($result);
            $this->load->helper('security');
            $msg = 'Record Found'; //If found
            //Encode User id
            $username = do_hash($emp_info['pms_employee_id'], 'md5');
            $passkey_number = rand(11, 99) . chr(rand(65, 91)) . rand(11, 99) . chr(rand(65, 91));

            $passkey = do_hash($passkey_number, 'md5');
            $key = 'forget_password_key';
            $value = $passkey;
            $this->updateEmpMeta($emp_info['pms_employee_id'], $key, $value);

            $activtion_link = site_url('recover/changepass/' . $username . '/' . $passkey);
            //echo $activtion_link;
            //Send Email
            $this->load->model('emailtemplatemodel');

            $this->load->library('email');

            $this->emailtemplatemodel->get_mail_settings();
            $data['s_mail_from'] = $this->commonmodel->get_env_setting('s_mail_from');
            $data['s_mail_name'] = $this->commonmodel->get_env_setting('s_mail_name');

            $this->email->from($data['s_mail_from'], $data['s_mail_name']);
            $this->email->to($forgot_email);

            //Check email Template
            //Prepare link
            //%tpl_userfname% %tpl_userlname%,%tpl_activationlink%

            $email_data = array(
                'tpl_userfname' => $emp_info['fname'],
                'tpl_userlname' => $emp_info['lname'],
                'tpl_activationlink' => $activtion_link
            );
            $email_info = $this->emailtemplatemodel->get_template_by_code('EMAIL_FORGOT_PASS', $email_data);

            $this->email->subject($email_info['email_subject']);
            $this->email->message($email_info['email_body']);

            $this->email->send();

            //End Send Email



            /**
              $key = $this->input->post('email') . microtime(true);
              $f_key = do_hash($key, 'md5'); // MD5 password generator
              $table_name = $this->db->dbprefix . 'user_master';

              $condition = array(
              'user_id' => $user_info->user_id
              );


              $activtion_link = site_url('users/userforgotpassword/' . $username . '/' . $f_key);
             * */
            //$data['error'] = 'Your password link is send to your email. <br>Please Check';
            //$this->session->set_flashdata('error', 'Your password link is send to your email. <br>Please Check');

            $data['msgtitle'] = 'Recover link is send';
            $data['msgdesc'] = 'Your password recover link is send to your email. <br>Please Check';
            //$this->load->view('default/clientadmin/cadmin_login', $data);

            $this->load->view('default/clientadmin/user_topbar_sw', $data);
            $this->load->view('default/clientadmin/user_forgot_msg_1', $data);
        } else {

            $data['msgtitle'] = 'Email not registered';
            $data['msgdesc'] = 'Given email address is not registered with us.<br>Please Check again.';

            $this->load->view('default/clientadmin/user_topbar_sw', $data);
            $this->load->view('default/clientadmin/user_forgot_msg_1', $data);
        }
    }

    function updatenewpass() {
        $data = array();
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();

        $emp_id = $_POST['emp_id'];

        $sql = "SELECT * from " . $this->db->dbprefix . "employee
                WHERE md5(pms_employee_id) ='" . $emp_id . "' ";
        $result_emp = mysql_query($sql);

        $total_rows = mysql_num_rows($result_emp);
        if ($total_rows >= 1) {
            //Found 
            $this->load->helper('security');

            $emp_info = mysql_fetch_assoc($result_emp);
            //print_r($emp_info);

            $emp_id = $emp_info['pms_employee_id'];

            $newpass = do_hash($_POST['password'], 'md5');
            $data_upd = array('password' => $newpass);
            $this->db->update($this->db->dbprefix . 'employee', $data_upd, array('pms_employee_id' => $emp_id));

            //Reset usermeta
            $passkey = '-updated-' . date('Y-m-d H:i:s') . '-' . time();

            $key = 'forget_password_key';
            $value = $passkey;
            $this->updateEmpMeta($emp_id, $key, $value);

            $data['msgtitle'] = 'Reset successfully';
            $data['msgdesc'] = 'Your pasword has been reset successfully.';

            $this->load->view('default/clientadmin/user_topbar_sw', $data);
            $this->load->view('default/clientadmin/user_forgot_msg_1', $data);
        } else {
            //Invalid key
            $data['msgtitle'] = 'Invalid Key';
            $data['msgdesc'] = 'Given key is invalid or Key is expired';

            $this->load->view('default/clientadmin/user_topbar_sw', $data);
            $this->load->view('default/clientadmin/user_forgot_msg_1', $data);
        }
    }

    function changepass($username, $passkey) {
        //Check for passkey validation
        $data = array();
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();

        $sql = "SELECT * from " . $this->db->dbprefix . "employee
                WHERE md5(pms_employee_id) ='" . $username . "' ";
        $result_emp = mysql_query($sql);

        $total_rows = mysql_num_rows($result_emp);
        if ($total_rows >= 1) {
            //Found user id check for passkey
            //check for valid passkey
            $emp_info = mysql_fetch_assoc($result_emp);
            //print_r($emp_info);

            $emp_id = $emp_info['pms_employee_id'];
            $key = 'forget_password_key';
            $empdata = $this->getEmpMeta($emp_id, $key);

            if ($empdata->meta_value == $passkey) {
                //Valid key 
                //Ask to change password
                $data['msgtitle'] = 'Rest Password';
                $data['msgdesc'] = '<strong>Hi ' . $emp_info['fname'] . ' ' . $emp_info['lname'] . '</strong>,<br> Type new password between 5 to 15 characters.';
                $data['empid'] = $username;

                $this->load->view('default/clientadmin/user_topbar_sw', $data);
                $this->load->view('default/clientadmin/user_forgot_msg_2', $data);
            } else {
                //Invalid key
                $data['msgtitle'] = 'Invalid Key';
                $data['msgdesc'] = 'Given key is invalid or Key is expired';

                $this->load->view('default/clientadmin/user_topbar_sw', $data);
                $this->load->view('default/clientadmin/user_forgot_msg_1', $data);
            }
        } else {
            //No username found
            $data['msgtitle'] = 'Invalid User Key';
            $data['msgdesc'] = 'Given User key is invalid or Key is expired';

            $this->load->view('default/clientadmin/user_topbar_sw', $data);
            $this->load->view('default/clientadmin/user_forgot_msg_1', $data);
        }
    }

    function updateEmpMeta($emp_id, $key, $val) {

        //here for loop of meta key comes
        if ($this->getEmpMeta($emp_id, $key)) {
            //update
            $array = array('meta_value' => $val);
            $this->db->where('pms_employee_id', $emp_id);
            $this->db->where('meta_key', $key);
            $this->db->update($this->db->dbprefix . 'employee_meta', $array);
        } else {
            //insert
            $array = array('pms_employee_id' => $emp_id, 'meta_key' => $key, 'meta_value' => $val);
            $this->db->set($array);
            $this->db->insert($this->db->dbprefix . 'employee_meta');
        }
    }

    function getEmpMeta($emp_id, $key) {

        $this->db->select('*');
        $this->db->from($this->db->dbprefix . 'employee_meta');

        $this->db->where('meta_key', trim($key));
        $this->db->where('pms_employee_id', $emp_id);
        $query = $this->db->get();

        $result = $query->first_row();

        if (empty($result)) {
            return FALSE;
        } else {
            return $result;
        }
    }

}