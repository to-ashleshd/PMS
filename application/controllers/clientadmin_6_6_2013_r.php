<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Clientadmin extends CI_Controller {

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
        $this->load->model('employeemodel');
        $this->load->model('commonmodel');
        $this->load->model('companymodel');
        $this->load->model('apraisermodel');
        $this->load->model('announcementmodel');
    }

    public function index($tab = '', $tabid = '') {


        if ($this->session->userdata('clientadmin_id')) {

            $this->dashboard();
        } else {
            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['action'] = site_url('clientadmin/clientadminlogin');
            $data['button'] = 'Submit';
            $data['button_text'] = 'Login';
            $data['logo'] = $this->generalesettings->getImage();

            $this->load->view('default/clientadmin/user_topbar_sw', $data);
            $this->load->view('default/clientadmin/user_login_sw', $data);
        }
    }

    function clientadminlogin() {

        $data['site_name'] = $this->generalesettings->getSiteName();
        if ($this->input->post('submit') == 'login') {

            $data = $_POST;
            $row = $this->employeemodel->getEmployeeByEmail(trim($data['login_name']));

            $this->load->helper('security');
            $password = do_hash(trim($data['login_password']), 'md5');
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();
            if (!empty($row) && (trim($data['login_name']) == trim($row->login_name)) AND ($password == trim($row->password))) {
                $sessiondata = array(
                    'clientadmin_id' => $row->pms_employee_id,
                    'pms_employee_id' => $row->pms_employee_id,
                    'username' => $row->fname . ' ' . $row->lname,
                    'login_name' => $row->login_name,
                    'email' => $row->email,
                    'usertype' => 'C',
                    'site_name' => $data['site_name'],
                    'logo' => $data['logo'],
                    'login_type' => $row->login_type,
                    'logged_in' => TRUE
                );

                $this->session->set_userdata($sessiondata);

                redirect(site_url('clientadmin/dashboard', 'refresh'));
            } else {
                $data['error'] = 'Please enter Correct Username and Password';
                $this->session->set_flashdata('error', 'Please enter Correct Username and Password');
                $data['action'] = site_url('clientadmin/clientadminlogin');
                $data['button'] = 'Submit';
                $data['button_text'] = 'Login';
                //$this->load->view('default/clientadmin/cadmin_login', $data);

                $this->load->view('default/clientadmin/user_topbar_sw', $data);
                $this->load->view('default/clientadmin/user_login_sw', $data);
            }
        }
    }

    public function logout() {
        $this->load->driver('cache');

        $this->session->unset_userdata('clientadmin_id');
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('usertype');
        $this->session->unset_userdata();
        $this->session->sess_destroy();

        //Clear Cache
        $this->cache->clean();
        $this->db->cache_delete_all();
        $this->topmenu->no_cache();

        redirect(site_url('clientadmin', 'refresh'));
    }

    public function generalsettings($tab = '', $tabid = '') {
        $this->load->model('commonmodel');
        $this->load->model('emailtemplatemodel');


        //Email Template
        if ($this->input->post('current_tab') == 'tb1_i') {
            if ($this->input->post('templateid') >= 1) {
                $result_update = $this->emailtemplatemodel->update_template();
                ////echo '<br>Update Settings ';
            } else {
                $result_update = $this->emailtemplatemodel->new_template();
                ////echo '<br>New Settings ';
            }

            //reset settings
            if ($result_update == 1) {
                $this->session->set_userdata('success', 'Email Templae Settings are updated successfully.');
            } else {
                $this->session->set_userdata('warning', 'Required Fields are missing or blank or No Change.');
            }
            $tab = 'tb1_i';
            $tabid = 0;
        }


        //Security Setting
        if ($this->input->post('current_tab') == 'tb1_e') {
            $this->commonmodel->update_env_setting('oninternet', ($this->input->post('oninternet') == 'Y' ? 'Y' : 'N'));
            $this->commonmodel->update_env_setting('s_captcha', $this->input->post('s_captcha'));
            $this->commonmodel->update_env_setting('recaptcha_domainname', $this->input->post('recaptcha_domainname'));
            $this->commonmodel->update_env_setting('recaptcha_publickey', $this->input->post('recaptcha_publickey'));
            $this->commonmodel->update_env_setting('recaptcha_privatekey', $this->input->post('recaptcha_privatekey'));
            $this->commonmodel->update_env_setting('ui_slider3_sel', $this->input->post('ui_slider3_sel'));
            $this->commonmodel->update_env_setting('s_bantime', $this->input->post('s_bantime'));
            $this->commonmodel->update_env_setting('s_bantime_attempts', $this->input->post('s_bantime_attempts'));
            $this->commonmodel->update_env_setting('s_password_change_days', $this->input->post('s_password_change_days'));
            $this->commonmodel->update_env_setting('cant_use_last_passwd', $this->input->post('cant_use_last_passwd'));
            $this->commonmodel->update_env_setting('s_client_display_format', $this->input->post('s_client_display_format'));
            $tab = 'tb1_e';
        }

        ////Language Date and Time
        if ($this->input->post('current_tab') == 'tb1_c') {
            $this->commonmodel->update_env_setting('s_lang_visitors', $this->input->post('s_lang_visitors'));
            $this->commonmodel->update_env_setting('s_lang_redirect', $this->input->post('s_lang_redirect'));
            $this->commonmodel->update_env_setting('s_time_format', $this->input->post('s_time_format'));
            $this->commonmodel->update_env_setting('s_date_format', $this->input->post('s_date_format'));
            $this->commonmodel->update_env_setting('s_decimal_format', $this->input->post('s_decimal_format'));
            $this->commonmodel->update_env_setting('s_currency_format', $this->input->post('s_currency_format'));
            $this->commonmodel->update_env_setting('s_currency', $this->input->post('s_currency'));
            $this->commonmodel->update_env_setting('s_select_country', $this->input->post('select_country'));
            $this->commonmodel->update_env_setting('s_time_zone', $this->input->post('s_time_zone'));
            $tab = 'tb1_c';
        }

        ////Mail Setting
        if ($this->input->post('current_tab') == 'tb1_b') {
            //Update Mail Setting
            $this->commonmodel->update_env_setting('s_mailer', $this->input->post('s_mailer'));
            $this->commonmodel->update_env_setting('s_mail_from', $this->input->post('s_mail_from'));
            $this->commonmodel->update_env_setting('s_mail_name', $this->input->post('s_mail_name'));
            $this->commonmodel->update_env_setting('s_smtp_user', $this->input->post('s_smtp_user'));
            $this->commonmodel->update_env_setting('s_smtp_password', $this->input->post('s_smtp_password'));
            $this->commonmodel->update_env_setting('s_smtp_host', $this->input->post('s_smtp_host'));
            $this->commonmodel->update_env_setting('s_smtp_port', $this->input->post('s_smtp_port'));
            $this->commonmodel->update_env_setting('u_ssl', $this->input->post('u_ssl'));

            //Send Verification Mail

            $this->load->library('email');
            //$config['mailtype'] = 'html';
            //$this->email->initialize($config);
            //Get Config setting
            $this->emailtemplatemodel->get_mail_settings();

            $this->email->from($this->input->post('s_mail_from'), $this->input->post('s_mail_name'));
            $this->email->to($this->input->post('s_mail_from'));

            //Fixit - Get info form emailtemplate class
            //Check email Template
            $email_data = array('var_cadminusername' => $this->input->post('s_mail_from'));
            $email_info = $this->emailtemplatemodel->get_template_by_code('EMAIL_SETTING_VERIFICATION', $email_data);

            $this->email->subject($email_info['email_subject']);
            $this->email->message($email_info['email_body']);

            $this->email->send();
            //echo $this->email->print_debugger();
            //End Send Verification mail

            $this->session->set_userdata('success', 'Verification mail is send to ' . $this->input->post('s_mail_from') . '. Mail Settings are updated successfully');
            $tab = 'tb1_b';
        }

        ////Update General Tab
        if ($this->input->post('current_tab') == 'tb1_a') {

            $userphoto_name = '';
            $userphoto_name_thumbnail = '';

            //upload product image
            $userphoto_name = 'cmp-' . date('Ymd') . '-' . rand(1000, 9999) . '.png';
            $config['file_name'] = $userphoto_name;
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '10000';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';
            $config['overwrite'] = TRUE;


            $this->load->library('./upload', $config);

            if (!$this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());
                //echo '<br>Error in uploading file.<br>';
                $userphoto_name = '';
            }

            //Thumbnail
            $config['image_library'] = 'gd2';
            $config['source_image'] = './uploads/' . $userphoto_name;
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = '160';
            $config['height'] = '43';
            $this->load->library('image_lib', $config);

            $this->image_lib->resize();
            $userphoto_name_thumbnail = basename($this->image_lib->full_dst_path);


            if ($_FILES['userfile']['error'] == 0) {
                if (!isset($error)) {
                    //Update General Setting
                    $this->commonmodel->update_env_setting('gen_company_logo', $userphoto_name_thumbnail);
                } else {
                    $this->session->set_userdata('warning', $error['error']);
                }
            }

            //Update General Setting
            $this->commonmodel->update_env_setting('gen_site_name', $this->input->post('gen_site_name'));
            $this->commonmodel->update_env_setting('gen_clientreg', ($this->input->post('gen_clientreg') == 'Y' ? 'Y' : 'N'));
            $this->commonmodel->update_env_setting('gen_rows_per_page', $this->input->post('gen_rows_per_page'));
            $this->commonmodel->update_env_setting('gen_is_offline', ( $this->input->post('gen_is_offline') == 'Y' ? 'Y' : 'N'));
            $this->commonmodel->update_env_setting('gen_off_message', $this->input->post('gen_off_message'));
            $this->commonmodel->update_env_setting('gen_theme_template', $this->input->post('gen_theme_template'));
            $this->session->set_userdata('success', 'General Settings are updated successfully');
            $tab = 'tb1_a';
        }

        $data = array();
        $data['current_tab'] = $this->input->post('current_tab');
        $data['tab'] = $tab;
        $data['tabid'] = $tabid;

        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();

        //Email templates
        $data['email_templates'] = $this->emailtemplatemodel->all_templates();

        //General Rows per page
        $data['gen_rows_per_page'] = $this->commonmodel->get_env_setting('gen_rows_per_page');


        //Security Setting
        $data['oninternet'] = $this->commonmodel->get_env_setting('oninternet');
        $data['s_captcha'] = $this->commonmodel->get_env_setting('s_captcha');
        $data['recaptcha_domainname'] = $this->commonmodel->get_env_setting('recaptcha_domainname');
        $data['recaptcha_publickey'] = $this->commonmodel->get_env_setting('recaptcha_publickey');
        $data['recaptcha_privatekey'] = $this->commonmodel->get_env_setting('recaptcha_privatekey');
        $data['ui_slider3_sel'] = $this->commonmodel->get_env_setting('ui_slider3_sel');
        $data['s_bantime'] = $this->commonmodel->get_env_setting('s_bantime');
        $data['s_bantime_attempts'] = $this->commonmodel->get_env_setting('s_bantime_attempts');
        $data['s_password_change_days'] = $this->commonmodel->get_env_setting('s_password_change_days');
        $data['cant_use_last_passwd'] = $this->commonmodel->get_env_setting('cant_use_last_passwd');
        $data['s_client_display_format'] = $this->commonmodel->get_env_setting('s_client_display_format');


        //Language Date and Time
        $data['s_lang_visitors'] = $this->commonmodel->get_env_setting('s_lang_visitors');
        $data['s_lang_redirect'] = $this->commonmodel->get_env_setting('s_lang_redirect');
        $data['s_time_format'] = $this->commonmodel->get_env_setting('s_time_format');
        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
        $data['s_decimal_format'] = $this->commonmodel->get_env_setting('s_decimal_format');
        $data['s_currency_format'] = $this->commonmodel->get_env_setting('s_currency_format');
        $data['s_currency'] = $this->commonmodel->get_env_setting('s_currency');
        $data['s_select_country'] = $this->commonmodel->get_env_setting('s_select_country');
        $data['s_time_zone'] = $this->commonmodel->get_env_setting('s_time_zone');

        //Mail Setting
        $data['s_mailer'] = $this->commonmodel->get_env_setting('s_mailer');
        $data['s_mail_from'] = $this->commonmodel->get_env_setting('s_mail_from');
        $data['s_mail_name'] = $this->commonmodel->get_env_setting('s_mail_name');
        $data['s_smtp_user'] = $this->commonmodel->get_env_setting('s_smtp_user');
        $data['s_smtp_password'] = $this->commonmodel->get_env_setting('s_smtp_password');
        $data['s_smtp_host'] = $this->commonmodel->get_env_setting('s_smtp_host');
        $data['s_smtp_port'] = $this->commonmodel->get_env_setting('s_smtp_port');
        $data['u_ssl'] = $this->commonmodel->get_env_setting('u_ssl');

        //General
        $data['gen_site_name'] = $this->commonmodel->get_env_setting('gen_site_name');
        $data['gen_clientreg'] = $this->commonmodel->get_env_setting('gen_clientreg');
        $data['gen_rows_per_page'] = $this->commonmodel->get_env_setting('gen_rows_per_page');
        $data['gen_is_offline'] = $this->commonmodel->get_env_setting('gen_is_offline');
        $data['gen_off_message'] = $this->commonmodel->get_env_setting('gen_off_message');
        $data['gen_theme_template'] = $this->commonmodel->get_env_setting('gen_theme_template');

        //$data['countryDD'] = $this->commonmodel->countryDropDown();
        $data['stateDD'] = $this->commonmodel->stateDropDown(99);
        $data['cityDD'] = $this->commonmodel->cityDropdown(99, 1493);

        $data['logo'] = $this->generalesettings->getImage();
        //echo $data['logo'] ;die();
        $this->session->set_userdata('logo', $data['logo']);

        //Loading View
        $data['topmenu'] = $this->topmenu->apraiseemenulist();
        $this->load->view('default/clientadmin/cadmin_header', $data);
        $this->load->view('default/clientadmin/cadmin_content', $data);
        $this->load->view('default/clientadmin/cadmin_footer', $data);
    }

    public function generalsettings_post() {
        $this->load->model('clientadminmodel');
        $result = $this->clientadminmodel->new_clientadmin();
        echo '<br>New id ' . $result;

        //print_r($_POST);
    }

    public function get_template_info() {
        //echo 'Template info' ;
        $json['tpl_subject'] = 'Email Subject';
        $json['tpl_code'] = 'TPL330';
        $json['tpl_body'] = 'This is template body';

        echo json_encode($json);
    }

    public function delete_emailtemplate($template_id) {

        $this->load->model('emailtemplatemodel');
        $this->emailtemplatemodel->delete_template($template_id);

        //Reload page
        //$this->generalsettings('tb1_i') ;
        redirect('clientadmin/generalsettings/tb1_i', 'refresh');
    }

    /*
     * ****************************************
     * Environment Settings
     * ****************************************
     */

    public function environmentsettings($tab = '', $tabid = '') {
        $this->load->model('commonmodel');
        $this->load->database();
        $tab = '';
        /**
          $db['default']['hostname'] = 'localhost';
          $db['default']['username'] = 'root';
          $db['default']['password'] = '';
          $db['default']['database'] = 'enrichcore';
          $db['default']['dbdriver'] = 'mysql';
         * */
//        echo '<pre>';
//        print_r($_POST);
//        echo '</pre>';die();
        //echo 'Host Name: ' . $this->db->hostname;
        //exec('mysqldump --user=' . $this->db->username . ' --password=' . $this->db->password . ' --host=' . $this->db->hostname . ' ' . $this->db->database . ' > backupdb.sql');
        // echo '</pre>';
        // die();
        //Update info if any
        if ($this->input->post('current_tab') == 'tb1_h') {

            $this->commonmodel->update_env_setting('empid_format', $this->input->post('empid_format'));
            $this->commonmodel->update_env_setting('rb_private_domains', $this->input->post('rb_private_domains'));
            $this->commonmodel->update_env_setting('private_domain_list', $this->input->post('private_domain_list'));
            $this->commonmodel->update_env_setting('min_username_length', $this->input->post('min_username_length'));

            $this->commonmodel->update_env_setting('e_logintype', $this->input->post('e_logintype'));
            $this->commonmodel->update_env_setting('e_multicompany', ($this->input->post('e_multicompany') == 'Y' ? 'Y' : 'N'));
            $this->commonmodel->update_env_setting('e_isprivate', ($this->input->post('e_isprivate') == 'Y' ? 'Y' : 'N'));
            $this->commonmodel->update_env_setting('e_is_sns', ($this->input->post('e_is_sns') == 'Y' ? 'Y' : 'N'));
            $this->commonmodel->update_env_setting('is_login_fb', ($this->input->post('is_login_fb') == 'Y' ? 'Y' : 'N'));
            $this->commonmodel->update_env_setting('is_login_twitter', ($this->input->post('is_login_twitter') == 'Y' ? 'Y' : 'N'));
            $this->commonmodel->update_env_setting('is_login_linkedin', ($this->input->post('is_login_linkedin') == 'Y' ? 'Y' : 'N'));

            $this->commonmodel->update_env_setting('e_is_userverified_req', ($this->input->post('e_is_userverified_req') == 'Y' ? 'Y' : 'N'));
            $this->commonmodel->update_env_setting('e_verificationby_email', ($this->input->post('e_verificationby_email') == 'Y' ? 'Y' : 'N'));
            $this->commonmodel->update_env_setting('e_verificationby_sms', ($this->input->post('e_verificationby_sms') == 'Y' ? 'Y' : 'N'));
            $this->commonmodel->update_env_setting('e_verificationby_ivr', ($this->input->post('e_verificationby_ivr') == 'Y' ? 'Y' : 'N'));

            $this->commonmodel->update_env_setting('e_sms_api', $this->input->post('e_sms_api'));
            $this->commonmodel->update_env_setting('e_sms_username', $this->input->post('e_sms_username'));
            $this->commonmodel->update_env_setting('e_sms_passwd', $this->input->post('e_sms_passwd'));

            $tab = 'tb1_h';
        }

        if ($this->input->post('current_tab') == 'tb1_cron') {
            $tables = '*';

            if ($tables == '*') {
                $tables = array();
                $result = mysql_query('SHOW TABLES');
                while ($row = mysql_fetch_row($result)) {
                    $tables[] = $row[0];
                }
            } else {
                $tables = is_array($tables) ? $tables : explode(',', $tables);
            }
            $return = '';
            foreach ($tables as $table) {
                $result = mysql_query('SELECT * FROM ' . $table);
                $num_fields = mysql_num_fields($result);

                $return.= 'DROP TABLE IF EXISTS ' . $table . ';';
                $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE ' . $table));
                $r = str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $row2[1]);

                $return.= "\n\n" . $r . ";\n\n";

                for ($i = 0; $i < $num_fields; $i++) {
                    while ($row = mysql_fetch_row($result)) {
                        $return.= 'INSERT INTO ' . $table . ' VALUES(';
                        for ($j = 0; $j < $num_fields; $j++) {
                            $row[$j] = addslashes($row[$j]);
                            $row[$j] = str_replace("\n", "\\n", $row[$j]);
                            if (isset($row[$j])) {
                                $return.= '"' . $row[$j] . '"';
                            } else {
                                $return.= '""';
                            }
                            if ($j < ($num_fields - 1)) {
                                $return.= ',';
                            }
                        }
                        $return.= ");\n";
                    }
                }
                $return.="\n\n\n";
            }
            $file_name = 'db-backup-' . date('d-m-Y') . '-' . time() . '-' . (md5(implode(',', $tables))) . '.sql';

            //save file
            $handle = fopen('assets/dbbackup/db-backup-' . date('d-m-Y') . '-' . time() . '-' . (md5(implode(',', $tables))) . '.sql', 'w+');
            fwrite($handle, $return);
            fclose($handle);
            $this->load->helper('download');
            $data = file_get_contents("assets/dbbackup/" . $file_name); // Read the file's contents
            $name = $file_name;

            force_download($name, $data);
            $tab = 'tb1_cron';
        }


        $data = array();
        $data['current_tab'] = $this->input->post('current_tab');
        $data['tab'] = $tab;
        $data['tabid'] = $tabid;

        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();


        //General Rows per page
        $data['gen_rows_per_page'] = $this->commonmodel->get_env_setting('gen_rows_per_page');


        //Security Setting
        $data['oninternet'] = $this->commonmodel->get_env_setting('oninternet');
        $data['s_captcha'] = $this->commonmodel->get_env_setting('s_captcha');
        $data['recaptcha_domainname'] = $this->commonmodel->get_env_setting('recaptcha_domainname');
        $data['recaptcha_publickey'] = $this->commonmodel->get_env_setting('recaptcha_publickey');
        $data['recaptcha_privatekey'] = $this->commonmodel->get_env_setting('recaptcha_privatekey');
        $data['ui_slider3_sel'] = $this->commonmodel->get_env_setting('ui_slider3_sel');
        $data['s_bantime'] = $this->commonmodel->get_env_setting('s_bantime');
        $data['s_bantime_attempts'] = $this->commonmodel->get_env_setting('s_bantime_attempts');
        $data['s_password_change_days'] = $this->commonmodel->get_env_setting('s_password_change_days');
        $data['cant_use_last_passwd'] = $this->commonmodel->get_env_setting('cant_use_last_passwd');
        $data['s_client_display_format'] = $this->commonmodel->get_env_setting('s_client_display_format');
        $data['s_mailer'] = $this->commonmodel->get_env_setting('s_mailer');

        //Environment Setting
        $data['empid_format'] = $this->commonmodel->get_env_setting('empid_format');
        $data['rb_private_domains'] = $this->commonmodel->get_env_setting('rb_private_domains');
        $data['private_domain_list'] = $this->commonmodel->get_env_setting('private_domain_list');
        $data['min_username_length'] = $this->commonmodel->get_env_setting('min_username_length');

        $data['e_logintype'] = $this->commonmodel->get_env_setting('e_logintype');
        $data['e_multicompany'] = $this->commonmodel->get_env_setting('e_multicompany');
        $data['e_isprivate'] = $this->commonmodel->get_env_setting('e_isprivate');
        $data['e_is_sns'] = $this->commonmodel->get_env_setting('e_is_sns');
        $data['is_login_fb'] = $this->commonmodel->get_env_setting('is_login_fb');
        $data['is_login_twitter'] = $this->commonmodel->get_env_setting('is_login_twitter');
        $data['is_login_linkedin'] = $this->commonmodel->get_env_setting('is_login_linkedin');

        $data['e_is_userverified_req'] = $this->commonmodel->get_env_setting('e_is_userverified_req');
        $data['e_verificationby_email'] = $this->commonmodel->get_env_setting('e_verificationby_email');
        $data['e_verificationby_sms'] = $this->commonmodel->get_env_setting('e_verificationby_sms');
        $data['e_verificationby_ivr'] = $this->commonmodel->get_env_setting('e_verificationby_ivr');

        $data['e_sms_api'] = $this->commonmodel->get_env_setting('e_sms_api');
        $data['e_sms_username'] = $this->commonmodel->get_env_setting('e_sms_username');
        $data['e_sms_passwd'] = $this->commonmodel->get_env_setting('e_sms_passwd');
        $data['topmenu'] = $this->topmenu->apraiseemenulist();
        $data['topmenu'] = $this->topmenu->apraiseemenulist();
        $this->load->view('default/clientadmin/cadmin_header', $data);
        $this->load->view('default/clientadmin/cadmin_env_content', $data);
        $this->load->view('default/clientadmin/cadmin_env_footer', $data);
    }

    /*
     * ****************************************
     * Localisation Settings
     * ****************************************
     */

    /** start old localisation noy in use
      //update localisation
      public function updatecompanystatus($company_id, $status) {
      $condition_array = array('company_master_id' => $company_id);
      $this->db->where($condition_array);
      if ($status == 1) {
      $status = 2;
      } elseif ($status == 2) {
      $status = 1;
      }
      $data = array('status' => $status);
      $result = $this->db->update($this->db->dbprefix . 'company_master', $data);
      $this->session->set_userdata('success', 'Company Status updated Successfully');
      $this->localisation('tb1_e');
      }

      public function updatecompany($comany_master_id = '') {
      $this->load->model('companymodel');
      $this->load->model('commonmodel');
      $this->load->model('clientadminmodel');
      $comapny_result = $this->companymodel->getCompany($comany_master_id);
      $company_master_info = array();
      if (!empty($comapny_result)) {
      $company_master_info = array(
      'company_master_id' => $comapny_result->company_master_id,
      'company_name' => $comapny_result->company_name,
      'status' => $comapny_result->status,
      'addressmaster_id' => $comapny_result->addressmaster_id,
      'address_1' => $comapny_result->address_1,
      'address_2' => $comapny_result->address_2,
      'countrymaster_id' => $comapny_result->countrymaster_id,
      'statemaster_id' => $comapny_result->statemaster_id,
      'citymaster_id' => $comapny_result->citymaster_id,
      'mobile_no' => $comapny_result->mobile_no,
      'zipcode' => $comapny_result->zipcode,
      'phone_no' => $comapny_result->phone_no,
      'fax_no' => $comapny_result->fax_no,
      );
      $state_result = $this->commonmodel->getDropDownSQL($comapny_result->countrymaster_id);
      foreach ($state_result as $key => $val) {
      $state_master[$val->statemaster_id] = $val->state_name;
      }
      $city_result = $this->commonmodel->getDropDownSQL($comapny_result->countrymaster_id, $comapny_result->statemaster_id);
      foreach ($city_result as $key => $val) {
      $city_master[$val->citymaster_id] = $val->city_name;
      }
      }



      $data = array();

      $data['tab'] = 'tb1_e'; //$tab;

      $this->load->model('companymodel');
      $this->load->model('commonmodel');
      $this->load->model('clientadminmodel');
      $country_result = $this->commonmodel->getDropDownSQL();
      $country_master = array();

      foreach ($country_result as $key => $val) {
      $country_master[$val->countrymaster_id] = $val->country_name;
      }
      $company_infos = $this->companymodel->getCompanies();

      $ofice_list = $this->companymodel->getOfficeTypes();

      $office_master = array();

      $data['office_type_master'] = $ofice_list;
      $company_infos = $this->companymodel->getCompanies();
      $data['company_master'] = $company_infos;
      $data['update_company_master'] = $company_master_info;
      $data['country_master'] = $country_master;
      $data['state_master'] = $state_master;
      $data['city_master'] = $city_master;
      $data['button_text'] = 'Update';
      $data['topmenu']            = $this->topmenu->apraiseemenulist();
      $data['action'] = 'clientadmin/savelocalisationdata';
      $this->load->view('default/clientadmin/cadmin_header');
      $this->load->view('default/clientadmin/cadmin_localisation', $data);
      }

      //get data for uppdation of office type
      public function updateofficetype($office_type_id) {

      $this->load->model('companymodel');
      $result_ot = $this->companymodel->getOfficeType($office_type_id);

      $data = array();
      $data['tab'] = 'tb1_f'; //$tab;
      $this->load->model('companymodel');
      $this->load->model('commonmodel');
      $this->load->model('clientadminmodel');
      $country_result = $this->commonmodel->getDropDownSQL();
      $country_master = array();

      foreach ($country_result as $key => $val) {
      $country_master[$val->countrymaster_id] = $val->country_name;
      }
      $company_infos = $this->companymodel->getCompanies();

      $ofice_list = $this->companymodel->getOfficeTypes();

      $office_master = array();

      $data['office_type_master'] = $ofice_list;
      $data['update_office_type'] = $result_ot;
      $data['company_master'] = $company_infos;
      $data['country_master'] = $country_master;
      $data['button_text'] = 'Update';
      $data['action'] = 'clientadmin/savelocalisationdata';
      $data['topmenu']            = $this->topmenu->apraiseemenulist();
      $this->load->view('default/clientadmin/cadmin_header');
      $this->load->view('default/clientadmin/cadmin_localisation', $data);
      }

      public function updatedepartmentstatus($department_id = '') {
      $this->load->model('companymodel');
      $result_dt = $this->companymodel->getDepartment($department_id);
      if (!empty($result_dt)) {
      $data = array();
      if ($result_dt->department_status == 1) {
      $data = array('department_status' => '2');
      } elseif ($result_dt->department_status == 2) {
      $data = array('department_status' => '1');
      } else {
      $data = array('department_status' => '0');
      }
      $this->companymodel->updateDepartment($department_id, $data);
      }
      $this->session->set_userdata('success', 'Department Status updated Successfully');
      $this->localisation('tb1_h');
      }

      //get data for uppdation of department
      public function updatedepartment($department_id) {
      $data = array();
      $this->load->model('companymodel');
      $data['updatedept'] = $this->companymodel->getDepartment($department_id);


      $data['tab'] = 'tb1_h'; //$tab;
      $this->load->model('companymodel');
      $this->load->model('commonmodel');
      $this->load->model('clientadminmodel');
      $country_result = $this->commonmodel->getDropDownSQL();
      $country_master = array();

      foreach ($country_result as $key => $val) {
      $country_master[$val->countrymaster_id] = $val->country_name;
      }
      $company_infos = $this->companymodel->getCompanies();

      $ofice_list = $this->companymodel->getOfficeTypes();

      $office_master = array();
      $data['department_infos'] = $this->companymodel->getDepartments();
      $data['office_type_master'] = $ofice_list;
      $data['company_master'] = $company_infos;
      $data['country_master'] = $country_master;
      $data['button_text'] = 'Update';

      $data['action'] = 'clientadmin/savelocalisationdata';
      $data['topmenu']            = $this->topmenu->apraiseemenulist();
      $this->load->view('default/clientadmin/cadmin_header');
      $this->load->view('default/clientadmin/cadmin_localisation', $data);
      }

     * */
    //client profile
    public function old_profile() {

        if ($this->session->userdata('clientadmin_id')) {

            $data = array();
            $this->load->model('clientadminmodel');
            $row = $this->clientadminmodel->getClientAdminById(trim($this->session->userdata('clientadmin_id')));
            $data['clientinfo'] = $row;
            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $this->load->view('default/clientadmin/cadmin_header');
            $this->load->view('default/clientadmin/cadmin_profile', $data);
            $this->load->view('default/clientadmin/cadmin_footer', $data);
        }
    }

    function old_dashboard() {
        if ($this->session->userdata('pms_employee_id')) {
            $this->load->model('companymodel');
            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            $this->load->view('default/clientadmin/cadmin_dashboard', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function dashboard() {
        if ($this->session->userdata('pms_employee_id')) {
           
            $empid = $this->session->userdata('pms_employee_id');
            $this->load->model('companymodel');
            $this->load->model('reportsmodel');
             $this->load->model('taskschedulemodel');
            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();

            $data['topmenu'] = $this->topmenu->apraiseemenulist();
                
            $current_year_id  ='';
            $immidiate_previous_year_id ='';
            $current_year_detail = $this->commonmodel->get_current_year();
            if(!empty($current_year_detail))
            {
                $current_year_id  = $current_year_detail['time_period_id'];
            }
            $immidiate_previous_year_detail = $this->commonmodel->get_immediate_previous_year();
            if(!empty($immidiate_previous_year_detail))
            {
                $immidiate_previous_year_id = $immidiate_previous_year_detail['time_period_id'];
            }
            
            $current_year_detail = $this->taskschedulemodel->get_time_period_by_id($current_year_id);
            $immediate_previous_year_detail = $this->taskschedulemodel->get_time_period_by_id($immidiate_previous_year_id);
            
           
            $data['display_current_year'] = '';
           
            if(!empty($current_year_detail))
            {
                $data['display_current_year'] = $current_year_detail['time_period_from'].'-'.date('y',strtotime('01-01-'.$current_year_detail['time_period_to']));
            }
            
            
            $data['display_immidiate_pre_year'] = '';
            if(!empty($immediate_previous_year_detail))
            {
                $data['display_immidiate_pre_year'] = $immediate_previous_year_detail['time_period_from'].'-'.date('y',strtotime($immediate_previous_year_detail['time_period_to']));
            }
            
           
            $data['current_mysubmitstatus'] = $this->reportsmodel->getSubmitStatus($empid,$current_year_id);
            $data['mysubmitstatus'] = $this->reportsmodel->getSubmitStatus($empid,$immidiate_previous_year_id);
            
          
            $data['whoiam'] = $this->reportsmodel->whoiam($empid);
            //Check for not related emp
            $data['nonrelatedemp'] = $this->reportsmodel->getNonrelatedEmp();

            $data['rpt_employees'] = $this->apraisermodel->getEmployeeApriseelist($empid, '1');
            $data['rpt_reviewer_employees'] = $this->reviewermodel->getEmployeeApriseelist($empid, '1');
            $data['graph_summery'] = $this->reportsmodel->getSubmitStatusAll();
            $data['graph_appraiser'] = $this->reportsmodel->getSubmitStatusAll($empid, 'appraiser');
            $data['graph_reviewer'] = $this->reportsmodel->getSubmitStatusAll($empid, 'reviewer');

            //Calling Final TPL
            $data['todoinfo'] = $this->load->view('default/clientadmin/cadmin_todo_list', $data, true);
            
            //Calling Announcement
            $data['announcements'] = $this->announcementmodel->getAllActiveAnnouncements();


            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            $this->load->view('default/clientadmin/cadmin_dashboard', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function updateemployee($id = '') {
        if ($this->session->userdata('clientadmin_id')) {
            $this->load->model('companymodel');
            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();
            $data['company_master'] = $this->companymodel->getCompaniesHavingOfficeType();
            $data['departments'] = $this->companymodel->getDepartments();
            $this->load->view('default/clientadmin/cadmin_header', $data);
            $this->load->view('default/clientadmin/cadmin_addemployee', $data);
            $this->load->view('default/clientadmin/cadmin_middle_footer', $data);
            $this->load->view('default/clientadmin/cadmin_common_js', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function old_reports() {

        if ($this->session->userdata('clientadmin_id')) {
            $this->load->model('companymodel');
            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();
            $this->load->view('default/clientadmin/cadmin_header', $data);
            $this->load->view('default/clientadmin/cadmin_reports', $data);

            //$this->load->view('default/clientadmin/cadmin_footer', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    function newreports() {

        if ($this->session->userdata('clientadmin_id')) {
            $this->load->model('companymodel');
            $data = array();
            $data['site_name'] = $this->generalesettings->getSiteName();
            $data['logo'] = $this->generalesettings->getImage();


            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
            $data['employees'] = $this->apraisermodel->getEmployeeApriseelist($pms_employee_id, '1');
            $data['reviewer_employees'] = $this->reviewermodel->getEmployeeApriseelist($pms_employee_id, '1');


            //$data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);


            $data['topmenu'] = $this->topmenu->apraiseemenulist();

            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);

            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', $data, true);
            $this->load->view('default/clientadmin/cadmin_report_1', $data);



            //Old Graph Template: $this->load->view('default/clientadmin/cadmin_new_report', $data);
            //$this->load->view('default/clientadmin/cadmin_footer', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    //for pms start
    function getdesignationgrade() {
        $response = array();
        $designation_id = $this->input->post('designation_id', true);
        $grade_deatil = $this->companymodel->getGradeByDesignationId($designation_id);
        if (!empty($grade_deatil)) {
            $response['grade'] = array('grade_id' => $grade_deatil->grade_id, 'grade_name' => $grade_deatil->grade_name);
        }
        die(json_encode($response));
    }

    function old_viewreport($apraisee_employee_id = '') {
        $data = array();
        $time_period_id = '1';
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        $data['departments'] = $this->companymodel->getDepartments();
        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
        $data['apraisee_employee_id'] = '';
        $data['employee_name'] = '';

        if ($apraisee_employee_id == '') {
            redirect('accessdenied', 'refresh');
        }

        if ($this->session->userdata('pms_employee_id')) {
            $pms_employee_id = $this->session->userdata('pms_employee_id');
            $data['final_score'] = '';
            $data['final_score_cwi'] = '';
            $data['overall_kra_score'] = '';
            $data['overall_competencies_score'] = '';
            $data['overall_performance_score'] = '';
            $data['reviewer_assessment_score'] = '';
            $data['apraiser_assessment_score'] = '';


            $data['apraiser_overall_performance_score_name'] = '';
            $data['apraiser_overall_performance_score'] = '';
            $data['apraiser_overall_competencies_score'] = '';
            $data['apraiser_overall_kra_score'] = '';
            $data['reviewer_date'] = date($data['s_date_format']);

            if ($apraisee_employee_id != '') {
                $reviewer_employee_id = $pms_employee_id;
                $apraisee_relationship_detail = $this->reviewermodel->getRelationshipStatus($apraisee_employee_id, $reviewer_employee_id, $time_period_id);
                $employee_detail = $this->employeemodel->getEmployeeById($apraisee_employee_id);
                $apraiser_employee_id = '0';
                $data['top_employee_detail'] = $this->employeemodel->getEmployeeDetailsById($apraisee_employee_id, $time_period_id);
                // $data['top_employee_apraiser_detail'] = $this->employeemodel->getEmployeeApraiserAndReviewer($apraisee_employee_id, $time_period_id);
                $top_employee_apraiser_detail = $this->employeemodel->getEmployeeApraiserAndReviewer($apraisee_employee_id, $time_period_id);
                $top_detail_apraiser = '';
                $top_detail_reviewer = '';
                if (!empty($top_employee_apraiser_detail)) {
                    foreach ($top_employee_apraiser_detail as $key_topemp => $val_topemp) {
                        if ($top_detail_apraiser == '') {
                            $top_detail_apraiser = '[ <strong>' . $val_topemp['apraiser_name'] . ' </strong><em>' . $val_topemp['apraiser_designation'] . '</em> ]';
                        } else {
                            $top_detail_apraiser .= ', [ <strong>' . $val_topemp['apraiser_name'] . '</strong><em> ' . $val_topemp['apraiser_designation'] . '</em> ]';
                        }
                        $top_detail_reviewer = '[ <strong>' . $val_topemp['reviewer_name'] . '</strong><em> ' . $val_topemp['reviewer_designation'] . '</em> ]';
                    }
                }
                $data['top_employee_apraiser_detail'] = array(
                    'appraiser' => $top_detail_apraiser,
                    'reviewer' => $top_detail_reviewer
                );

                if (empty($data['top_employee_detail'])) {
                    redirect('accessdenied', 'refresh');
                }


                if (empty($data['top_employee_detail'])) {
                    redirect('accessdenied', 'refresh');
                }

                if (!empty($apraisee_relationship_detail)) {
                    $apraiser_employee_id = $apraisee_relationship_detail['apraiser_employee_id'];
                    //echo '<pre>';
                    //Added By Ajay
                    $apraiser_list = $this->reviewermodel->getRelationshipStatusMultiple($apraisee_employee_id, $reviewer_employee_id, $time_period_id);
                    //print_r($apraiser_list);
                    $arr_apraiser_list = array();
                    foreach ($apraiser_list as $key_a => $val_a) {
                        $arr_apraiser_list[] = $val_a['apraiser_employee_id'];
                    }
                    //print_r($arr_apraiser_list);
                    //echo '</pre>';
                }

                //Get overall score
                //TODO Fixed: display overall score
                $overall_kra_score = $this->getOverallRatingForApraisee($apraisee_employee_id, $time_period_id);
                $data['overall_kra_score_for_appraiser'] = $overall_kra_score;
                $data['overall_kra_score_rating_name'] = $this->reviewermodel->getScoreNameByScore($data['overall_kra_score_for_appraiser']['overall_total']);


                $apraiser_overall_rating = $this->apraisermodel->getApraiserOverAllRatingById($apraisee_employee_id, $apraiser_employee_id, $time_period_id);

                //Modified by Ajay
                //Get Reviewer date
                $sql = "SELECT * FROM " . $this->db->dbprefix . "reviewer_overall_rating WHERE 
                        pms_employee_id='" . $apraisee_employee_id . "' 
                        AND reviewer_employee_id='" . $this->session->userdata('pms_employee_id') . "' 
                        AND time_period_id='" . $time_period_id . "' ";

                $query = $this->db->query($sql);
                $reviewer_overall_rating = $query->first_row();
                //$reviewer_date = date($data['s_date_format'], strtotime($reviewer_overall_rating->date_created));
                $reviewer_date = date($data['s_date_format'], strtotime(date("Y-m-d")));

                //Fixed apraiser_date
                $data['apraiser_date'] = $apraiser_date = '';

                /**
                  if (!empty($apraiser_overall_rating)) {
                  $data['apraiser_assessment_score'] = $this->reviewermodel->getScoreNameByScore($apraiser_overall_rating['apraiser_score']);
                  $data['apraiser_date'] = date($data['s_date_format'], strtotime($apraiser_overall_rating['date_created']));
                  }
                 * */
                //apraiser overall rating score
                $data['apraiser_overall_kra_score'] = $this->reviewermodel->getApraiserTotalKraScore($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
                $data['apraiser_overall_competencies_score'] = $this->reviewermodel->getApraiserTotalCompetenciesScore($apraisee_employee_id, $apraiser_employee_id, $time_period_id);
                $data['apraiser_overall_performance_score'] = (($data['apraiser_overall_kra_score']) + ($data['apraiser_overall_competencies_score']));
                $data['apraiser_overall_performance_score_name'] = $this->reviewermodel->getScoreNameByScore($data['apraiser_overall_performance_score']);

                //  echo  $data['apraiser_overall_kra_score'];echo "<br>";
                //  echo $data['apraiser_overall_competencies_score'] ;echo "<br>";die();
                //   echo  $data['apraiser_overall_performance_score'];die();

                if (!empty($apraisee_relationship_detail) && $apraisee_relationship_detail['submit_status'] == '6') {

                    //$data['kra_detail'] = $this->reviewermodel->getApraiserKraPmsDetail($apraisee_employee_id, $apraiser_employee_id);
                    //Added By Ajay
                    $data['kra_detail'] = $this->reviewermodel->getApraiserKraPmsDetailMultiple($apraisee_employee_id, $arr_apraiser_list);

                    $data['employee_name'] = $employee_detail->fname . ' ' . $employee_detail->lname;
                } elseif (!empty($apraisee_relationship_detail) && $apraisee_relationship_detail['submit_status'] > '6') {
                    //echo $apraisee_employee_id.' '.$apraiser_employee_id.' '.$reviewer_employee_id;
                    //$data['reviewer_kra_detail'] = $this->reviewermodel->getReviewerKraPmsDetail($apraisee_employee_id, $apraiser_employee_id, $reviewer_employee_id);
                    $data['reviewer_kra_detail'] = $this->reviewermodel->getReviewerKraPmsDetailMultiple($apraisee_employee_id, $arr_apraiser_list, $reviewer_employee_id);

                    if (!empty($data['reviewer_kra_detail'])) {
                        foreach ($data['reviewer_kra_detail'] as $keyd => $vald) {
                            if ($data['final_score'] == '') {
                                $data['final_score'] = ($vald['total_score']);
                            } else {
                                $data['final_score'] += ($vald['total_score']);
                            }
                        }
                    }

                    //$data['reviewer_kra_detail'] = '';

                    $employee_detail = $this->employeemodel->getEmployeeById($apraisee_employee_id);
                    $data['employee_name'] = $employee_detail->fname . ' ' . $employee_detail->lname;

                    if ($apraisee_relationship_detail['submit_status'] >= '8' && !empty($data['reviewer_kra_detail'])) {
                        $overall_rating_of_reviewer = $this->reviewermodel->getReviewerOverAllRatingById($apraisee_employee_id, $apraiser_employee_id, $reviewer_employee_id, $time_period_id);


                        if (!empty($overall_rating_of_reviewer)) {
                            $data['reviewer_date'] = date($data['s_date_format'], strtotime($overall_rating_of_reviewer['date_created']));
                        }

                        $data['competency_with_idp_detail'] = $this->apraisermodel->getEmployeeCompetenciesWithIdp($apraisee_employee_id, $apraiser_employee_id);
                        //echo '<pre>';
                        //print_r($data['competency_with_idp_detail'] );
                        //echo '</pre>';

                        foreach ($data['competency_with_idp_detail'] as $keycwi => $valcwi) {
                            if ($data['final_score_cwi'] == '') {
                                $data['final_score_cwi'] = ($valcwi['total_score']);
                            } else {
                                $data['final_score_cwi'] += ($valcwi['total_score']);
                            }
                        }
                        //$data['technical_detail'] = $this->apraisermodel->getEmployeeTechnicalDetail($apraisee_employee_id, $apraiser_employee_id);
                        //Modified By Ajay
                        $data['technical_detail'] = $this->apraisermodel->getEmployeeTechnicalDetailMultiple($apraisee_employee_id, $arr_apraiser_list);


                        //$data['behavioural_detail'] = $this->apraisermodel->getEmployeeBehaviouralDetail($apraisee_employee_id, $apraiser_employee_id);
                        $data['behavioural_detail'] = $this->apraisermodel->getEmployeeBehaviouralDetailMultiple($apraisee_employee_id, $arr_apraiser_list);



                        $data['overall_kra_score'] = round((($data['final_score'] * 70 ) / 100), 2);
                        $data['overall_competencies_score'] = round((($data['final_score_cwi'] * 30 ) / 100), 2);
                        $data['overall_performance_score'] = round((($data['overall_kra_score']) + ($data['overall_competencies_score'])), 2);
                        if ($data['overall_performance_score'] < 2) {
                            $data['reviewer_assessment_score'] = 'BE';
                        } elseif ($data['overall_performance_score'] > 2 && $data['overall_performance_score'] < 2.79) {
                            $data['reviewer_assessment_score'] = 'NI';
                        } elseif ($data['overall_performance_score'] > 2.80 && $data['overall_performance_score'] < 3.49) {
                            $data['reviewer_assessment_score'] = 'ME';
                        } elseif ($data['overall_performance_score'] > 3.50 && $data['overall_performance_score'] < 4.24) {
                            $data['reviewer_assessment_score'] = 'EE';
                        } elseif ($data['overall_performance_score'] > 4.25 && $data['overall_performance_score'] < 5.00) {
                            $data['reviewer_assessment_score'] = 'FEE';
                        }
                    } elseif ($apraisee_relationship_detail['submit_status'] >= '8') {

                        $data['error'] = 'Please Fill Up Appraiser KRA form First';
                    }

//                    if($apraisee_relationship_detail['submit_status'] >= '9' && !empty($data['competency_with_idp_detail']))
//                    {
//                        $data['overall_rating_detail'] = $this->apraisermodel->getOverallRatingDetail($apraisee_employee_id,$apraiser_employee_id,$time_period_id);
//                    }
//                    elseif($apraisee_relationship_detail['submit_status'] >= '9')
//                    {
//                        $data['error']  ='Please Fill Up Competencies With IDp  First';
//                    }
                } elseif (!empty($apraisee_relationship_detail) && $apraisee_relationship_detail['submit_status'] < '6') {
                    $data['errormsg'] = 'Awaiting for Apraisee Response.';
                } else {
                    //$data['error']      = 'Page Not Found';
                    redirect('accessdenied', 'refresh');
                }
            } else {
                // $data['error']      = 'Page not found';
                redirect('accessdenied', 'refresh');
            }

            //die();
            //added By Ajay
            $data['new_competencies_for_refrence'] = $this->display_reviewer_competencies($apraisee_employee_id, $employee_detail->grade_id);
            $data['reviewer_idp_score'] = $this->reviewer_total_score;
            //Add Final Score
            $final_score = (($data['final_score'] * 70 ) / 100 );
            $data['final_score_kra'] = number_format($final_score, 2, '.', '');

            //IDP
            $reviewer_idp_score = (($data['reviewer_idp_score'] * 30 ) / 100 );
            $data['final_score_idp'] = number_format($reviewer_idp_score, 2, '.', '');

            $data['final_total'] = number_format($reviewer_idp_score + $data['final_score_kra'], 2, '.', '');
            $data['reviewer_assessment_score'] = $this->reviewermodel->getScoreNameByScore($data['final_total']);


            $data['competencies_for_refrence'] = $this->commonmodel->getCompetenciesByGrade($employee_detail->grade_id);
            $data['all_ratings'] = $this->taskschedulemodel->getAllRatimgs('1');
            $data['idp_detail'] = $this->apraiseemodel->getAllIdpsOfApraisee($apraisee_employee_id, $time_period_id);
            $data['ratings_for_refrence'] = $this->apraisermodel->getAllRatings('1');
            $data['apraisee_employee_id'] = $apraisee_employee_id;
            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            $this->load->view('default/clientadmin/cadmin_report_reviewer', $data);
        } else {
            redirect('clientadmin', 'refresh');
        }
    }

    /** Supporting functions * */
//TODO: Fixed - Remove Duplicate

    public function display_reviewer_competencies($apraisee_employee_id = '', $grade_id = '') {
        //echo '<br>Employee Id ' . $apraisee_employee_id . ' Grade: ' . $grade_id ;
        $output = '';
        $time_period_id = 1;
        //Get all List of competencies

        $comp_for_ref = $this->commonmodel->getCompetenciesByGrade($grade_id);


        //Get Multiple appraiser
        $sql_multiple_relationship = "SELECT  rm.employee_relationship_materix_id, rm.apraiser_employee_id, e.fname, e.lname 
                        FROM " . $this->db->dbprefix . "employee_relationship_materix rm
                        LEFT JOIN " . $this->db->dbprefix . "employee e ON rm.apraiser_employee_id = e.pms_employee_id 
                        WHERE rm.time_period_id = '" . $time_period_id . "' 
                        and rm.pms_employee_id = '" . $apraisee_employee_id . "' ";
        //echo $sql_multiple_relationship ;
        $query_m = $this->db->query($sql_multiple_relationship);
        //echo '<pre>';
        //print_r($query_m->result());
        //echo '</pre>';


        $reviewer_id = $this->session->userdata('pms_employee_id');
        $output = '';
        $output .= '<table class="table table-bordered">';

        $output .= '<thead>';
        $output .= '<tr>';
        $output .= '<th>Competencies</th>';
        $output .= '<th>Weightage</th>';
        //Display cols for multiple apraiser
        /**
          foreach ($query_m->result() as $ckey => $cval) {
          $output .= '<th> ' . $cval->fname . ' ' . $cval->lname . '</th>';
          }
         * 
         */
        $output .= '<th>Scale</th>';

        $output .= '<th>Reviewer Score</th>';
        $output .= '</tr>';
        $output .= '</thead>';



        $total_avg = 0;
        $total_rev_score = 0;
        $total_weightage = 0;
        $output .= '<tbody>';
        foreach ($comp_for_ref as $key => $val) {

            $output .= '<tr>';
            $output .= '<td>' . trim($val['competencies_name']) . '</td>';
            $output .= '<td>' . $val['weightage_value'] . '%</td>';

            //Calculate Weightage
            $total_weightage = $total_weightage + $val['weightage_value'];

            //Display cols for multiple apraiser
            $my_average = 0;
            $my_scale = 0;
            foreach ($query_m->result() as $ckey => $cval) {
                $get_scale_info = $this->getCompetenciesDetails($val['competencies_for_refrence_id'], $cval->apraiser_employee_id, $apraisee_employee_id, $time_period_id);
                $myscore = number_format((( $val['weightage_value'] * $get_scale_info->scale ) / 100), 2, '.', '');
                $my_average = $my_average + $myscore;
                //$output .= '<td style="text-align:right">' . $get_scale_info->scale . ' | ' . $myscore . '</td>';
                $my_scale = $my_scale + $get_scale_info->scale;
            }

            //Display Average
            //Calculate Average 
            $my_average = number_format(( $my_average / count($query_m->result())), 2, '.', '');
            $my_scale = number_format(( $my_scale / count($query_m->result())), 2, '.', '');

            //Add to Total
            $total_avg = $total_avg + $my_average;
            //$output .= '<td style="text-align:right">' . $my_average . '</td>';
            //Display Scale
            //$output .= '<td style="text-align:right">' . $my_scale . '</td>';
            //Get Reviewer Details
            $get_scale_info = $this->getReviewerCompetenciesDetails($val['competencies_for_refrence_id'], $reviewer_id, $apraisee_employee_id, $time_period_id);
            if ($get_scale_info) {
                $scale = $get_scale_info->scale;
                $myscore = number_format((( $val['weightage_value'] * $scale ) / 100), 2, '.', '');
                $total_rev_score = $total_rev_score + $myscore;
            } else {
                $myscore = 0;
                $scale = 0;
                $total_rev_score = $total_rev_score + $myscore;
            }
            $my_scale = number_format(( $scale / count($query_m->result())), 2, '.', '');

            $output .= '<td style="text-align:right">' . $scale . '</td>';
            $output .= '<td style="text-align:right">' . $myscore . '</td>';
            $output .= '</tr>';

            //Get Individual Details
        }

        //Display Total
        $output .= '<tr>';
        $output .= '<td style="text-align:right; font-weight:bold;">Total</td>';
        $output .= '<td>' . $total_weightage . '%&nbsp;</td>';
        //Display cols for multiple apraiser
        /**
          foreach ($query_m->result() as $ckey => $cval) {
          $output .= '<td>&nbsp;</td>';
          }
         * 
         */
        //$output .= '<td style="text-align:right; font-weight:bold;">' . number_format($total_avg, 2, '.', '') . '</td>';
        $output .= '<td style="text-align:right; font-weight:bold;">&nbsp;</td>';

        $output .= '<td style="text-align:right; font-weight:bold;">' . number_format($total_rev_score, 2, '.', '') . '</td>';
        $output .= '</tr>';
        $output .= '</tbody>';



        $output .= '</table>';
        $this->reviewer_total_score = $total_rev_score;

        return $output;
    }

    function getCompetenciesDetails($competency_id, $apraisee_employee_id, $pms_employee_id, $time_period_id) {
        $sql = "SELECT * FROM " . $this->db->dbprefix . "apraiser_competency_with_idp 
            WHERE competencies_for_refrence_id = '" . $competency_id . "' 
            AND apraiser_employee_id='" . $apraisee_employee_id . "' 
            AND pms_employee_id='" . $pms_employee_id . "' 
            AND time_period_id='" . $time_period_id . "' ";
        $query = $this->db->query($sql);
        $result = $query->first_row();

        return $result;
    }

    function getReviewerCompetenciesDetails($competency_id, $reviewer_id, $pms_employee_id, $time_period_id) {
        $sql = "SELECT * FROM " . $this->db->dbprefix . "reviewer_competency_with_idp 
            WHERE competencies_for_refrence_id = '" . $competency_id . "' 
            AND reviewer_employee_id='" . $reviewer_id . "' 
            AND pms_employee_id='" . $pms_employee_id . "' 
            AND time_period_id='" . $time_period_id . "' ";
        $query = $this->db->query($sql);
        $result = $query->first_row();
        //echo $this->db->last_query();

        return $result;
    }

//TODO: Fixed - Remove Duplicate
    function getOverallRatingForApraisee($apraisee_id, $time_period_id = 1) {
        $data = array();
        $output = array();

        $sql = "SELECT group_concat(apraiser_employee_id) as apraisers  
                FROM " . $this->db->dbprefix . "employee_relationship_materix 
                WHERE pms_employee_id = '" . $apraisee_id . "' 
                AND time_period_id = '" . $time_period_id . "' ";
        //echo $sql;
        $query = $this->db->query($sql);
        $result = $query->first_row();

        $arrApraisers = explode(',', $result->apraisers);

        //Setup vars
        $kra_scroe = '';
        $competency_score = '';


        //Loop Throuth all Apraisers
        $arrKrainfo = array();
        $arrCompetency = array();
        $no_of_apraisers = count($arrApraisers);

        foreach ($arrApraisers as $row_apraiser_employee_id) {
            $data['apraiser_kra_detail'] = $this->apraisermodel->getApraiserKraPmsDetail($apraisee_id, $row_apraiser_employee_id);
            if (!empty($data['apraiser_kra_detail'])) {
                //echo '<br> apraiser_employee_id: ' . $row_apraiser_employee_id;
                $kra_individual_scroe = 0;
                foreach ($data['apraiser_kra_detail'] as $keyd => $vald) {
                    $kra_scroe += ($vald['total_score']);

                    //Add KRA Individual Score
                    $kra_individual_scroe = $kra_individual_scroe + ($vald['total_score']);
                }
                $arrKrainfo[$row_apraiser_employee_id]['total'] = $kra_individual_scroe;
                $arrKrainfo[$row_apraiser_employee_id]['with_70'] = number_format((($kra_individual_scroe * 70) / 100), 2);
            }

            //COMPETENCIES 
            $data['competency_with_idp_detail'] = $this->apraisermodel->getEmployeeCompetenciesWithIdp($apraisee_id, $row_apraiser_employee_id);
            if (!empty($data['competency_with_idp_detail'])) {
                $competency_individual_score = 0;

                foreach ($data['competency_with_idp_detail'] as $keycwi => $valcwi) {
                    $competency_score = $competency_score + ($valcwi['total_score']);
                    $competency_individual_score = $competency_individual_score + ($valcwi['total_score']);
                }
                $arrCompetency[$row_apraiser_employee_id]['total'] = $competency_individual_score;
                $arrCompetency[$row_apraiser_employee_id]['with_30'] = number_format((($competency_individual_score * 30) / 100), 2);
            }
        }

        //echo '<br>Only KRA ' . $kra_scroe;
        //KRA Score did not divided by $no_of_apraisers 
        //Competency divided by by $no_of_apraisers 

        $overall_kra_score = number_format((( $kra_scroe * 70 ) / 100), 2, '.', '');
        $overall_competency_score = number_format((( ($competency_score / $no_of_apraisers) * 30 ) / 100), 2, '.', '');


        //echo '<br>Overall KRA Score ' . $overall_kra_score;

        $output['overall_kra_score'] = $overall_kra_score;
        $output['overall_competency_score'] = $overall_competency_score;
        $output['overall_total'] = $overall_kra_score + $overall_competency_score;

        return $output;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */