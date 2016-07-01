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
         $this->load->model('generalesettings');
         $this->load->model('employeemodel');
         $this->load->model('commonmodel');
         $this->load->model('companymodel');
    }

    public function index($tab = '', $tabid = '') {
       
        //$this->load->view('welcome_message');
        //Calling Default method as new
        //  $this->load->model('generalesettings');
         if ($this->session->userdata('clientadmin_id')) {
             
                $this->dashboard();
                //$this->generalsettings($tab = '', $tabid = '');
            } else {
                $data = array();
                 $data['site_name'] = $this->generalesettings->getSiteName();
                $data['action'] = site_url('clientadmin/clientadminlogin');
                $data['button'] = 'Submit';
                $data['button_text'] = 'Login';
                $data['logo'] = $this->generalesettings->getImage();
                $this->load->view('default/clientadmin/cadmin_login', $data);
                
            }
        
    }
    
   
    
    function clientadminlogin()
    {

         
         $data['site_name'] = $this->generalesettings->getSiteName();
         if ($this->input->post('submit') == 'login')
         {
         
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
                        'username'         => $row->fname.' '.$row->lname,
                        'login_name' => $row->login_name,
                        'email' => $row->email,
                        'usertype' => 'C',
                        'site_name' => $data['site_name'],
                        'logo' => $data['logo'],
                        'logged_in' => TRUE
                    );

                    $this->session->set_userdata($sessiondata);
                  
                    redirect(site_url('clientadmin/dashboard', 'refresh'));
          
                }
                else
                {
                    $data['error'] = 'Please enter Correct Username and Password';
                    $this->session->set_flashdata('error', 'Please enter Correct Username and Password');
                    $data['action'] = site_url('clientadmin/clientadminlogin');
                    $data['button'] = 'Submit';
                    $data['button_text'] = 'Login';
                    $this->load->view('default/clientadmin/cadmin_login', $data);
                }
          
          
          }
        
    }
      public function logout() {
        $this->session->unset_userdata('clientadmin_id');
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('usertype');
        $this->session->unset_userdata();
        $this->session->sess_destroy();
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
        $data['topmenu']            = $this->topmenu->apraiseemenulist();
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
        **/
       
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
       
       if ($this->input->post('current_tab') == 'tb1_cron')
       {
        $tables = '*';
        
        if($tables == '*')
        {
            $tables = array();
            $result = mysql_query('SHOW TABLES');
            while($row = mysql_fetch_row($result))
            {
            $tables[] = $row[0];
            }
        }
        else
        {
            $tables = is_array($tables) ? $tables : explode(',',$tables);
           
        }
        $return ='';
        foreach($tables as $table)
        {
            $result = mysql_query('SELECT * FROM '.$table);
            $num_fields = mysql_num_fields($result);

            $return.= 'DROP TABLE IF EXISTS '.$table.';';
            $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
            $r = str_replace("CREATE TABLE","CREATE TABLE IF NOT EXISTS",$row2[1]);

            $return.= "\n\n".$r.";\n\n";

            for ($i = 0; $i < $num_fields; $i++) 
            {
            while($row = mysql_fetch_row($result))
            {
                $return.= 'INSERT INTO '.$table.' VALUES(';
                for($j=0; $j<$num_fields; $j++) 
                {
                $row[$j] = addslashes($row[$j]);
                $row[$j] = str_replace("\n","\\n",$row[$j]);
                if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                if ($j<($num_fields-1)) { $return.= ','; }
                }
                $return.= ");\n";
            }
            }
            $return.="\n\n\n";
        }
        $file_name = 'db-backup-'.date('d-m-Y').'-'.time().'-'.(md5(implode(',',$tables))).'.sql';
       
        //save file
        $handle =  fopen('assets/dbbackup/db-backup-'.date('d-m-Y').'-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
        fwrite($handle,$return);
        fclose($handle);
        $this->load->helper('download');
        $data = file_get_contents("assets/dbbackup/".$file_name); // Read the file's contents
        $name = $file_name;

        force_download($name, $data); 
        $tab = 'tb1_cron';
       }


        $data = array();
        $data['current_tab'] = $this->input->post('current_tab');
        $data['tab'] = $tab;
        $data['tabid'] = $tabid;

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
        $data['topmenu']            = $this->topmenu->apraiseemenulist();
        $data['topmenu']                = $this->topmenu->apraiseemenulist();
        $this->load->view('default/clientadmin/cadmin_header',$data);
        $this->load->view('default/clientadmin/cadmin_env_content', $data);
        $this->load->view('default/clientadmin/cadmin_env_footer', $data);
    }

    /*
     * ****************************************
     * Localisation Settings
     * ****************************************
     */

    public function localisation($tab = '') {
        $data = array();
        $data['current_tab'] = ''; //$this->input->post('current_tab');
        if ($tab == '') {
            $data['tab'] = 'tb1_b'; //$tab;
        } else {
            $data['tab'] = $tab;
        }

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

        // $office_master = array();
        $data['department_infos'] = $this->companymodel->getDepartments();
        $data['office_type_master'] = $ofice_list;
        $data['company_master'] = $company_infos;
        $data['country_master'] = $country_master;
        $data['button_text'] = 'Submit';
        $data['action'] = 'clientadmin/savelocalisationdata';
        $data['topmenu']   = $this->topmenu->apraiseemenulist();
        $this->load->view('default/clientadmin/cadmin_header',$data);
        $this->load->view('default/clientadmin/cadmin_localisation', $data);
    }

    public function savelocalisationdata($datalocalisation = '') {
//        echo "<pre>";
//        print_r($_POST);
//        echo "</pre>";die();
        if (!empty($_POST)) {
            $this->load->model('clientadminmodel');
            $this->load->model('companymodel');
            $this->load->model('addressmastermodel');
            if ($this->input->post('updatecompany')) {

                if (($this->input->post('updatecompany') == 'Submit')) {
                    $this->clientadminmodel->addCompany();
                    $this->session->set_userdata('success', 'Company added Successfully');
                    $this->localisation('tb1_e');
                } elseif (($this->input->post('updatecompany') == 'Update')) {
                    $this->clientadminmodel->updateCompany();
                    $this->session->set_userdata('success', 'Company Updated Successfully');
                    $this->localisation('tb1_e');
                }
            }
            if ($this->input->post('updatecountry')) {
                $this->load->model('countrymodel');
                if (($this->input->post('updatecountry') == 'Submit') && ($this->input->post('hcountry_id_country') == '')) {
                    $data_country = array(
                        'country_name' => $this->input->post('country'),
                        'iso_code_2' => $this->input->post('countrycode1'),
                        'iso_code_3' => $this->input->post('countrycode2'),
                        'status' => '1'
                    );
                    $country_id = $this->countrymodel->addCountry($data_country);
                    $this->session->set_userdata('success', 'Country added Successfully');
                } else if (($this->input->post('updatecountry') == 'Submit') && ($this->input->post('hcountry_id_country') != '')) {

                    $data_country = array(
                        'country_name' => $this->input->post('country'),
                        'iso_code_2' => $this->input->post('countrycode1'),
                        'iso_code_3' => $this->input->post('countrycode2'),
                    );
                    $country_id = $this->input->post('hcountry_id_country');
                    $result = $this->countrymodel->updateCountry($country_id, $data_country);
                    $this->session->set_userdata('success', 'Country updated Successfully');
                }
                $this->localisation('tb1_b');
            }

            //update state

            if ($this->input->post('updatestate')) {

                $this->load->model('countrymodel');
                if (($this->input->post('updatestate') == 'Submit') && ($this->input->post('hcountry_new_state') == '')) {

                    $data_state = array(
                        'state_name' => $this->input->post('state_new_state'),
                        'countrymaster_id' => $this->input->post('country_new_state'),
                        'status' => '1'
                    );
                    $state_id = $this->countrymodel->addState($data_state);
                    $this->session->set_userdata('success', 'State added Successfully');
                } else if (($this->input->post('updatestate') == 'Submit') && ($this->input->post('hcountry_new_state') != '')) {

                    $data_state = array(
                        'state_name' => $this->input->post('state_new_state'),
                        'countrymaster_id' => $this->input->post('country_new_state'),
                    );
                    $state_id = $this->input->post('hcountry_new_state');
                    $result = $this->countrymodel->updateState($state_id, $data_state);
                    $this->session->set_userdata('success', 'State updated Successfully');
                }

                $this->localisation('tb1_c');
            }

            //update city

            if ($this->input->post('updatecity')) {
                //echo $this->input->post('city_new_city');die();
                $this->load->model('countrymodel');
                if (($this->input->post('updatecity') == 'Submit') && ($this->input->post('hcity_new_city') == '')) {
                    $data_city = array(
                        'countrymaster_id' => $this->input->post('country_new_city'),
                        'statemaster_id' => $this->input->post('state_new_city'),
                        'city_name' => $this->input->post('city_new_city'),
                        'status' => '1'
                    );
                    $city_id = $this->countrymodel->addCity($data_city);
                    $this->session->set_userdata('success', 'City added Successfully');
                } else if (($this->input->post('updatecity') == 'Submit') && ($this->input->post('hcity_new_city') != '')) {
                    $data_city = array(
                        'countrymaster_id' => $this->input->post('country_new_city'),
                        'statemaster_id' => $this->input->post('state_new_city'),
                        'city_name' => $this->input->post('city_new_city'),
                    );
                    $city_id = $this->input->post('hcity_new_city');
                    $result = $this->countrymodel->updateCity($city_id, $data_city);
                    $this->session->set_userdata('success', 'City updated Successfully');
                }

                $this->localisation('tb1_d');
            }

            //update office type
            if ($this->input->post('updateofficetype')) {
                if (($this->input->post('updateofficetype') == 'Submit')) {
                    $data_op = array();
                    $data_op = array(
                        'office_type_name' => $this->input->post('newofficetype'),
                        'office_type_parent_id' => (int) $this->input->post('office_parent_ot'),
                        'company_master_id' => (int) $this->input->post('office_type_company')
                    );
                    $this->companymodel->addOfficeType($data_op);
                    $this->session->set_userdata('success', 'Office type added Successfully');
                } elseif (($this->input->post('updateofficetype') == 'Update')) {
                    $office_type_id = $this->input->post('office_type_id');
                    $data_op = array();
                    $data_op = array(
                        'office_type_name' => $this->input->post('newofficetype'),
                        'office_type_parent_id' => (int) $this->input->post('office_parent_ot'),
                        'company_master_id' => (int) $this->input->post('office_type_company')
                    );
                    $this->companymodel->updateOfficeType($office_type_id, $data_op);
                    $this->session->set_userdata('success', 'Office type Updated Successfully');
                }

                $this->localisation('tb1_f');
            }

            if ($this->input->post('updatedepartment')) {
                if (($this->input->post('updatedepartment') == 'Submit')) {
                    $data = array(
                        'department_name' => $this->input->post('newdepartment'),
                        'department_status' => '1'
                    );

                    $this->db->insert($this->db->dbprefix . 'department', $data);
                    $this->session->set_userdata('success', 'Department added Successfully');
                } else if (($this->input->post('updatedepartment') == 'Update')) {
                    $data = array(
                        'department_name' => $this->input->post('newdepartment'),
                    );
                    $condition_array = array('department_id' => $this->input->post('department_id'));
                    $this->db->where($condition_array);
                    $result = $this->db->update($this->db->dbprefix . 'department', $data);
                    $this->session->set_userdata('success', 'Department updated Successfully');
                }
                $this->localisation('tb1_h');
            }
        } else {
            $this->localisation('tb1_b');
        }
    }

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
    
    
    
    //client profile
    public  function profile()
    {
     
         if ($this->session->userdata('clientadmin_id')) {
            
             $data = array();
              $this->load->model('clientadminmodel');
              $row = $this->clientadminmodel->getClientAdminById(trim($this->session->userdata('clientadmin_id')));
              $data['clientinfo'] = $row;
              $data['topmenu']            = $this->topmenu->apraiseemenulist();
                $this->load->view('default/clientadmin/cadmin_header');
                $this->load->view('default/clientadmin/cadmin_profile', $data);
                $this->load->view('default/clientadmin/cadmin_footer', $data);
         }
    }
    
    // start for PMS
//    function dashboard()
//    {
//        $data = array();
//        $data['site_name'] = $this->generalesettings->getSiteName();
//        $data['logo'] = $this->generalesettings->getImage();
//        $this->load->view('default/clientadmin/cadmin_header', $data);
//        $this->load->view('default/clientadmin/cadmin_dashboard', $data);
//        //$this->load->view('default/clientadmin/cadmin_footer', $data);
//    }
    
     function dashboard()
    {
        if ($this->session->userdata('pms_employee_id')) {
        $this->load->model('companymodel');
        $data = array();
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
        if($this->session->userdata('pms_employee_id')=='1')
        {
        redirect('apraisee/addkra/1',true);
        }
        else
        {
                $data['topmenu']            = $this->topmenu->apraiseemenulist();
                $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data,true);
                $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data,true);
                $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data,true);
                $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
                $this->load->view('default/clientadmin/cadmin_dashboard', $data);
        
        }
        
         }else
          {
              redirect('clientadmin','refresh');
          }
    }
   
    
    
    function addemployee()
    {
        if ($this->session->userdata('clientadmin_id')) {
            
        $this->load->model('companymodel');
        $data = array();
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
        $data['company_master']     = $this->companymodel->getCompaniesHavingOfficeType();
        $data['departments']        = $this->companymodel->getDepartments();
        $data['designations']        = $this->companymodel->getDesignations();
      
        $data['s_date_format']      = $this->commonmodel->get_env_setting('s_date_format');
        $data['current_date']       = date($data['s_date_format']);
        $data['js_date_format']     = get_datepicker_date2($data['s_date_format']);
        $data['req_pwd_strength'] = $this->commonmodel->get_env_setting('ui_slider3_sel');
       
        $data['topmenu']            = $this->topmenu->apraiseemenulist();
        $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data ,true);
        
        $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data,true);
        $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data,true);
        $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
        $this->load->view('default/clientadmin/cadmin_addemployee', $data);
          }else
          {
               redirect('clientadmin','refresh');
          }
        
    }
    
    
     function updateemployee($id='')
    {
          if ($this->session->userdata('clientadmin_id')) {
        $this->load->model('companymodel');
        $data = array();
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
        $data['company_master']     = $this->companymodel->getCompaniesHavingOfficeType();
        $data['departments']         = $this->companymodel->getDepartments();
        $this->load->view('default/clientadmin/cadmin_header', $data);
        $this->load->view('default/clientadmin/cadmin_addemployee', $data);
        $this->load->view('default/clientadmin/cadmin_middle_footer', $data);
        $this->load->view('default/clientadmin/cadmin_common_js', $data);
         }else
          {
               redirect('clientadmin','refresh');
          }
    }
    
        
    
   
    
    function addkra($year = '')
    {
        if ($this->session->userdata('clientadmin_id')) {
        $this->load->model('companymodel');
        $data = array();
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
        $data['header']             = $this->load->view('default/clientadmin/cadmin_header', $data);
         $data['common_js'] =$this->load->view('default/clientadmin/cadmin_common_js', $data);
         $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
         $this->load->view('default/clientadmin/cadmin_addkra', $data);
         }else
          {
              redirect('clientadmin','refresh');
          }
    }
    
    
    
        function addpms()
    {
        if($this->session->userdata('clientadmin_id')) {
        $this->load->model('companymodel');
        $data = array();
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
        $this->load->view('default/clientadmin/cadmin_header', $data);
        $this->load->view('default/clientadmin/cadmin_addpms', $data);
        $this->load->view('default/clientadmin/cadmin_middle_footer', $data);
        $this->load->view('default/clientadmin/cadmin_common_js', $data);
        }else
          {
            redirect('clientadmin','refresh');
          }
    }
    function addidp(){
         if($this->session->userdata('clientadmin_id')) {
        $this->load->model('companymodel');
        $data = array();
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
        $this->load->view('default/clientadmin/cadmin_header', $data);
        $this->load->view('default/clientadmin/cadmin_idp_2012', $data);
        $this->load->view('default/clientadmin/cadmin_middle_footer', $data);
        $this->load->view('default/clientadmin/cadmin_common_js', $data);
        }else
          {
            redirect('clientadmin','refresh');
          }
        
    }
     function addkra2013()
    {
        if ($this->session->userdata('clientadmin_id')) {
        $this->load->model('companymodel');
        $data = array();
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
        $this->load->view('default/clientadmin/cadmin_header', $data);
        $this->load->view('default/clientadmin/cadmin_addkra_2013', $data);
        $this->load->view('default/clientadmin/cadmin_middle_footer', $data);
        $this->load->view('default/clientadmin/cadmin_common_js', $data);
         }else
          {
              redirect('clientadmin','refresh');
          }
    }
 function addidp2013(){
         if($this->session->userdata('clientadmin_id')) {
        $this->load->model('companymodel');
        $data = array();
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
        $this->load->view('default/clientadmin/cadmin_header', $data);
        $this->load->view('default/clientadmin/cadmin_idp_2013', $data);
        $this->load->view('default/clientadmin/cadmin_middle_footer', $data);
        $this->load->view('default/clientadmin/cadmin_common_js', $data);
        }else
          {
            redirect('clientadmin','refresh');
          }
        
    }
    
  
    
    
  
    
    
    
    
    
     function reviewer()
    {
         
        if($this->session->userdata('clientadmin_id')) {
        $this->load->model('companymodel');
        $data = array();
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
        $data['departments']         = $this->companymodel->getDepartments();
        $this->load->view('default/clientadmin/cadmin_header', $data);
       
        $this->load->view('default/clientadmin/cadmin_reviewer', $data);
        $this->load->view('default/clientadmin/cadmin_common_js', $data);
        }else
          {
            redirect('clientadmin','refresh');
          }
    }
    
     function revieweremployeelist()
    {
        $employee= array();
         $data = array();
         if ($this->session->userdata('clientadmin_id')) {
         $sql = "select * from pms_employee ";
         $result = mysql_query($sql);
         
         while($row = mysql_fetch_assoc($result))
         {
             $employee[$row['employee_id']] =$row;
            
         }
        
        $this->load->model('companymodel');
         $data['employee']  = $employee;
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
        $data['company_master']     = $this->companymodel->getCompaniesHavingOfficeType();
        $data['departments']         = $this->companymodel->getDepartments();
        $this->load->view('default/clientadmin/cadmin_header', $data);
        $this->load->view('default/clientadmin/cadmin_reviewer_employee_list', $data);
        $this->load->view('default/clientadmin/cadmin_middle_footer', $data);
        $this->load->view('default/clientadmin/cadmin_common_js', $data);
        $this->load->view('default/clientadmin/cadmin_last_footer', $data);
         }else
          {
               redirect('clientadmin','refresh');
          }
    }
    function reports()
    {
         
        if($this->session->userdata('clientadmin_id')) {
        $this->load->model('companymodel');
        $data = array();
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
        $this->load->view('default/clientadmin/cadmin_header', $data);
        $this->load->view('default/clientadmin/cadmin_reports', $data);

        //$this->load->view('default/clientadmin/cadmin_footer', $data);
        }else
          {
            redirect('clientadmin','refresh');
          }
    }
    
    function newreports()
    {
         
        if($this->session->userdata('clientadmin_id')) {
        $this->load->model('companymodel');
        $data = array();
        $data['site_name']          = $this->generalesettings->getSiteName();
        $data['logo']               = $this->generalesettings->getImage();
        
        $data['topmenu']            = $this->topmenu->apraiseemenulist();
        $this->load->view('default/clientadmin/cadmin_header', $data);
       
        $this->load->view('default/clientadmin/cadmin_new_report', $data);
        //$this->load->view('default/clientadmin/cadmin_footer', $data);
        }else
          {
            redirect('clientadmin','refresh');
          }
    }
    
    
    
    function test()
    {
       // $this->load->view('default/clientadmin/dashboard');
    }
    
    
    //for pms start
    function getdesignationgrade()
    {
        $response = array();
        $designation_id    =  $this->input->post('designation_id',true);
        $grade_deatil      = $this->companymodel->getGradeByDesignationId($designation_id);
        if(!empty($grade_deatil))
        {
            $response['grade'] = array('grade_id'=>$grade_deatil->grade_id,'grade_name'=>$grade_deatil->grade_name);
        }
        die(json_encode($response));
    }
    
    
    
    
    
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */