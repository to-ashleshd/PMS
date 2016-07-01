<?php
/**
 * Project Code: PMS
 * Version: PMS1
 * Object: Controller
 * Template: 
 * Template Name: 
 * Desc: Import Excel File for Employee
 * Last Update: 07-May-2013
 * Author: Team Enrich
 * */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Import extends CI_Controller {

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

    function importexcel() {
        error_reporting(E_ALL ^ E_NOTICE);
        $data = array();
        $preImport = array();
        $new_session_id = md5(time());
        /**
          echo '<pre>';
          print_r($_POST);
          print_r($_FILES);
          echo '</pre>';
         * */
        if ($_FILES['employeeimport']['name'] != '') {

            //
            $new_session_id = $_POST['session_id'];


            //upload product image
            $importfile_name = 'emp-' . date('Ymd') . '-' . rand(1000, 9999) . '.xls';
            $config['file_name'] = $importfile_name;
            $config['upload_path'] = './uploads/';
            //$config['allowed_types'] = 'xls';
            $config['allowed_types'] = '*';
            $config['max_size'] = '10000';
            $config['max_width'] = '1024';
            $config['max_height'] = '1000';
            $config['overwrite'] = TRUE;

            $field_name = "employeeimport";
            $this->load->library('upload', $config);
            //$this->upload->do_upload($field_name);

            if (!$this->upload->do_upload($field_name)) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                $importfile_name = '';
            }

            $uploaddir = FCPATH;
            //$uploadfile = $uploaddir . basename($_FILES['participantimport']['name']);
            //$uploadfile = $uploaddir . 'list_of_emp.xls';
            $uploadfile = $uploaddir . '/uploads/' . $importfile_name;

            //Open Excel file
            $pathToFile = $uploadfile;

            //Define parameters
            $params = array('file' => $pathToFile, 'store_extended_info' => true, 'outputEncoding' => '');
            $this->load->library('spreadsheet_excel_reader');

            $this->spreadsheet_excel_reader->read($pathToFile);
            $rows = $this->spreadsheet_excel_reader->sheets[0]['cells'];
            $row_count = count($this->spreadsheet_excel_reader->sheets[0]['cells']);

            $counter = 1;
            $output = array();

            for ($i = 2; $i <= $row_count; $i++) {
                //$row_fields = explode(';', $row);
                $errors = array();
                //echo '<pre>';
                $output[] = $this->checkImportRow($rows[$i], $new_session_id);

                //print_r($rows[$i]);
                //1. First Name	                
                //2. Middle Name	
                //3. Last Name	
                //4. Designation	
                //5. Employee ID	
                //6. Email	
                //7. Gender	
                //8. Company ID	
                //9. Office	
                //10. Department	
                //11. Date of Birth	
                //12. Date of Joining	
                //13. Last Promotion Date	
                //14. Mobile No.	
                //15. Password
                //16. Business

                /** Insert temp record * */
                $counter++;
            }
        }


        //echo '<pre>';
        //print_r($output);
        //echo '</pre>';
        ////$new_session_id = 'ee4266c2a28bbfdbd43f128e8139ea16';

        $data['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
        $data['preimport_data'] = $this->getCurrentSessionData($new_session_id);
        $data['new_session_id'] = $new_session_id;
        $data['topmenu'] = $this->topmenu->apraiseemenulist();
        $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data);

        $data['common_js'] = $this->load->view('default/clientadmin/cadmin_excelimport_common_beoro_js', $data);
        $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
        $this->load->view('default/clientadmin/cadmin_excelimport', $data);
    }

    function dopostimport() {
        //print_r($_POST);
        $response = array();
        $response['post'] = $_POST['session_id'];
        $response['mailerror'] = '';
        //Get List for 0 errors
        $session_id = $_POST['session_id'];
        $import_list = $this->getPostImportData($session_id);
        //echo '<br>Session Id: ' . $session_id ;
        //print_r($import_list);
        foreach ($import_list as $key => $val) {
            $cust_error = array();
            //print_r($val);
            $is_error_found = 0;
            //Check for duplicate empid
            $isexists_empid = $this->isEmpidExists($val->employee_id);
            if ($isexists_empid->howmany >= 1) {
                $cust_error['empid'] = 4;
                $is_error_found++;
            }

            //Check for duplicate empid
            $isexists_email = $this->isEmailExists($val->email);
            if ($isexists_email->howmany >= 1) {
                $cust_error['email'] = 4;
                $is_error_found++;
            }

            //If Error Found then 
            if ($is_error_found >= 1) {
                //add error 
                $errdata = array('post_error_found' => $is_error_found,
                    'post_errorinfo' => serialize($cust_error),
                    'post_success_status' => 'N'
                );
                $this->db->update($this->db->dbprefix . 'employee_temp', $errdata, array('id' => $val->id));
            } else {
                //Insert into emp table
                $user_email = $val->email;
                $user_password = $val->user_password;
                $user_fname = $val->fname;
                $user_lname = $val->lname;
                $insertdata = array(
                    'fname' => $val->fname,
                    'mname' => $val->mname,
                    'lname' => $val->lname,
                    'login_name' => $val->email,
                    'employee_id' => $val->employee_id,
                    'email' => $val->email,
                    'password' => $val->password,
                    'gender' => $val->gender,
                    'date_of_birth' => $val->date_of_birth,
                    'date_of_joining' => $val->date_of_joining,
                    'last_pramotion_date' => $val->last_pramotion_date,
                    'company_master_id' => $val->company_master_id,
                    'office_address_id' => $val->office_address_id,
                    'department_id' => $val->department_id,
                    'designation_id' => $val->designation_id,
                    'is_verified' => '1',
                    'user_status' => '1',
                    'mobile_no' => $val->mobile_no
                );

                $result = $this->db->insert($this->db->dbprefix . 'employee', $insertdata);

                //Update Business id
                //add Meta for business
                $new_id = $this->db->insert_id();
                $this->employeemodel->updateUserMeta($new_id, 'business_id', $val->business_id);

                //TODO: send confirmation mail
                //Send Email
                $this->load->model('emailtemplatemodel');

                $this->load->library('email');

                $this->emailtemplatemodel->get_mail_settings();
                $data['s_mail_from'] = $this->commonmodel->get_env_setting('s_mail_from');
                $data['s_mail_name'] = $this->commonmodel->get_env_setting('s_mail_name');

                $this->email->from($data['s_mail_from'], $data['s_mail_name']);
                $this->email->to($user_email);

                //Check email Template
                //Prepare link
                //%tpl_userfname% %tpl_userlname%,%tpl_activationlink%

                $email_data = array(
                    'tpl_fname' => $user_fname,
                    'tpl_lname' => $user_lname,
                    'tpl_username' => $user_email,
                    'tpl_password' => $user_password
                );
                $email_info = $this->emailtemplatemodel->get_template_by_code('PMS_NEW_EMP_REG', $email_data);

                $this->email->subject($email_info['email_subject']);
                $this->email->message($email_info['email_body']);

                if (!@$this->email->send()) {
                    $email_send_status = 'N';
                    $response['mailerror'] = 'Error while sending verification mails.' ;
                } else {
                    $email_send_status = 'Y';
                }

                //End Send Email
                //
                //
                //TODO: Display Error and Success list
                //Update status
                $errdata = array(
                    'post_error_found' => $is_error_found,
                    'post_success_status' => 'Y',
                    'post_email_status' => $email_send_status);
                $this->db->update($this->db->dbprefix . 'employee_temp', $errdata, array('id' => $val->id));
            }
        }

        //Create Success List
        //$session_id = 'ba668ab5be9dfb934d26893c8099cec3';

        $dataview['postimportemplist'] = $this->getPostImportEmpData($session_id);
        $dataview['s_date_format'] = $this->commonmodel->get_env_setting('s_date_format');
        //$postimportemplist = $this->getPostImportEmpData($session_id);
        //print_r($dataview['postimportemplist']);

        $response['postimportemplist'] = $this->load->view('default/clientadmin/cadmin_excelimport_success_list', $dataview, true);



        die(json_encode($response));
    }

    function checkImportRow($row, $new_session_id) {
        //print_r($row);
        $this->load->helper('string');

        $output = array();
        $cust_error = array();
        //Default errors
        $cust_error['fname'] = 0;
        $cust_error['lname'] = 0;
        $cust_error['designation'] = 0;
        $cust_error['empid'] = 0;
        $cust_error['login'] = 0;
        $cust_error['email'] = 0;
        $cust_error['gender'] = 0;
        $cust_error['companyname'] = 0;
        $cust_error['officename'] = 0;
        $cust_error['departmentname'] = 0;
        $cust_error['dob'] = 0;
        $cust_error['doj'] = 0;
        $cust_error['promodate'] = 0;
        $cust_error['mobile'] = 0;
        $cust_error['password'] = 0;
        $cust_error['business'] = 0;

        //Error Status
        //0 = ok
        //1 = empty
        //2 = Invalid Format
        //3 = Not found in database
        //4 = Already Exists
        //
        
        //1. First Name	
        $fname = $row['1'];
        if ($row['1'] == '') {
            $cust_error['fname'] = 1;
        }


        //2. Middle Name	
        //Not required
        $mname = $row['2'];
        if ($row['2'] == '') {
            
        }

        //3. Last Name	
        $lname = $row['3'];
        if ($row['3'] == '') {
            $cust_error['lname'] = 1;
        }

        //4. Designation	
        $designation_name = $row['4'];
        if ($row['4'] == '') {
            $cust_error['designation'] = 1;
            $designation_name = '';
        } else {
            $designation_id = $this->getDesignationIDByName($row['4']);
            if ($designation_id <= 0) {
                $cust_error['designation'] = 2;
            }
        }

        //5. Employee ID
        $empid = $row['5'];
        if ($row['5'] == '') {
            $cust_error['empid'] = 1;
        }
        $isexists = $this->isEmpidExists($empid);
        if ($isexists->howmany >= 1) {
            $cust_error['empid'] = 4;
        }

        //6. Email	
        $email = $this->getValidateEmail($row['6']);
        if ($row['6'] == '') {
            $cust_error['email'] = 1;
        }
        $isexists = $this->isEmailExists($email);
        if ($isexists->howmany >= 1) {
            $cust_error['email'] = 4;
        }


        //6.1 Login Name
        $login_name = $email;
        if ($login_name == '') {
            $cust_error['login'] = 1;
        }
        $isexists = $this->isLoginNameExists($email);
        if ($isexists->howmany >= 1) {
            $cust_error['login'] = 4;
        }

        //7. Gender	
        $gender = $this->getGender($row['7']);
        if ($row['7'] == '') {
            $cust_error['gender'] = 1;
        }
        if ($gender == '-') {
            $cust_error['gender'] = 2;
        }

        //8. Company ID	/ Name
        $companyname = $row['8'];
        $company_id = $this->getCompanyIdByName($row['8']);
        if ($row['8'] == '') {
            $cust_error['companyname'] = 1;
        }
        if ($company_id <= 0) {
            $cust_error['companyname'] = 2;
        }


        //9. Office
        $officename = $row['9'];
        $office_id = $this->getOfficeIdByName($row['9']);
        if ($row['9'] == '') {
            $cust_error['officename'] = 1;
        }
        if ($office_id <= 0) {
            $cust_error['officename'] = 2;
        }

        //10. Department
        $departmentname = $row['10'];
        $department_id = $this->getDepartmentIdByName($row['10']);
        if ($row['10'] == '') {
            $cust_error['departmentname'] = 1;
        }
        if ($department_id <= 0) {
            $cust_error['departmentname'] = 2;
        }

        //11. Date of Birth	
        $dob = date("Y-m-d", strtotime($row['11']));
        if ($row['11'] == '') {
            $cust_error['dob'] = 1;
        }
        if ($dob >= date("Y-m-d")) {
            $cust_error['dob'] = 2;
        }

        //12. Date of Joining	
        $doj = date("Y-m-d", strtotime($row['12']));

        if ($row['12'] == '') {
            $cust_error['doj'] = 1;
        }
        if ($doj >= date("Y-m-d")) {
            $cust_error['doj'] = 2;
        }

        //13. Last Promotion Date
        //Not Required if exists then check for date format
        if ($row['13'] != '') {
            // Check for valid date format
            // Check for greater then doj

            $last_promo_date = date("Y-m-d", strtotime($row['13']));
            if ($last_promo_date <= $doj) {
                $cust_error['promodate'] = 2;
            }
        } else {
            $last_promo_date = '';
        }

        //14. Mobile No.	
        //Not Required if exists then check for invalid characters
        $mobile = $row['14'];
        if ($row['14'] != '') {
            // Check for invalid characters
            if ($mobile >= 1000000000 and $mobile <= 9999999999) {
                //Valid range
            } else {
                $cust_error['mobile'] = 2;
            }
        }


        //15. Password
        //Not Required if exists then encrypt it 
        $user_password = $row['15'];
        if ($row['15'] != '') {
            // encrypt it
            $newpassword = md5($row['15']);
        } else {
            //Set Default Password
            if ($user_password == '') {
                //$user_password = 'Password@1234';
                $user_password = random_string('alnum', 8);
            }
            $newpassword = md5($user_password);
        }

        //16. Business
        //if( $row['16']  )

        /**
          $companyname = $row['8'];
          $company_id = $this->getCompanyIdByName($row['8']);
          if ($row['8'] == '') {
          $cust_error['companyname'] = 1;
          }
          if ($company_id <= 0) {
          $cust_error['companyname'] = 2;
          }
         * 
         */
        $businessname = $row['16'];
        $business_id = $this->getBusinessIdByName($businessname);
        if ($row['16'] == '') {
            $cust_error['business'] = 1;
        }
        if ($company_id <= 0) {
            $cust_error['business'] = 3;
        }


        //echo $sql;
        //print_r($cust_error);
        $error_found = 0;
        foreach ($cust_error as $key2 => $val2) {
            //echo '<br>Key ' . $key . ' - Val: ' . $val ;
            if ($val2 > 0) {
                //Showing Error
                //echo '<br>Error For: ' . $key ;
                //$output_error .= '<strong>' . ucwords($key2) . ':</strong>';
                if ($val2 == 1) {
                    //$output_error .= ' Empty Field ';
                    $error_found++;
                }
                if ($val2 == 2) {
                    //$output_error .= ' Invalid Entry ';
                    $error_found++;
                }
                if ($val2 == 4) {
                    //$output_error .= ' Invalid Entry ';
                    $error_found++;
                }
                //$output_error .='<br>';
            }
        }


        $insertdata = array(
            'fname' => $fname,
            'session_id' => $new_session_id,
            'mname' => $mname,
            'lname' => $lname,
            'login_name' => $email,
            'employee_id' => $empid,
            'email' => $email,
            'password' => $newpassword,
            'user_password' => $user_password,
            'gender' => $gender,
            'date_of_birth' => $dob,
            'date_of_joining' => $doj,
            'last_pramotion_date' => $last_promo_date,
            'company_master_id' => $company_id,
            'company_name' => $companyname,
            'businessname' => $businessname,
            'business_id' => $business_id,
            'office_address_id' => $office_id,
            'office_name' => $officename,
            'department_id' => $department_id,
            'department_name' => $departmentname,
            'designation_id' => $designation_id,
            'designation_name' => $designation_name,
            'is_verified' => '1',
            'user_status' => '',
            'mobile_no' => $mobile,
            'errorinfo' => serialize($cust_error),
            'error_found' => $error_found
        );

        $result = $this->db->insert($this->db->dbprefix . 'employee_temp', $insertdata);

        //echo '<br>New Id is ' . $new_id . session_id() ;

        $row['16'] = $new_session_id;
        $row['17'] = $cust_error;
        $row['18'] = $error_found;



        return $row;

        //1. First Name	
        //2. Last Name	
        //3. Middle Name	
        //4. Designation	
        //5. Employee ID	
        //6. Email	
        //7. Gender	
        //8. Company ID	
        //9. Office	
        //10. Department	
        //11. Date of Birth	
        //12. Date of Joining	
        //13. Last Promotion Date	
        //14. Mobile No.	
        //15. Password
    }

    /*     * ************ Supporting Functions ************** */

    function getDesignationIDByName($designation) {
        $query = $this->db->get_where($this->db->dbprefix . 'designation', array('designation_name' => $designation));
        $row = $query->first_row();

        return $row->designation_id;
    }

    function getCompanyIdByName($companyname) {
        $query = $this->db->get_where($this->db->dbprefix . 'company_master', array('company_name' => $companyname));
        $row = $query->first_row();
        return $row->company_master_id;
    }

    function getBusinessIdByName($businessname) {
        $query = $this->db->get_where($this->db->dbprefix . 'business', array('business_subject' => $businessname));
        $row = $query->first_row();
        return $row->business_id;
    }

    function getOfficeIdByName($officename) {
        $query = $this->db->get_where($this->db->dbprefix . 'office_addresses', array('office_name' => $officename));
        $row = $query->first_row();
        return $row->office_addresses_id;
    }

    function getDepartmentIdByName($departmentname) {
        $query = $this->db->get_where($this->db->dbprefix . 'department', array('department_name' => $departmentname));
        $row = $query->first_row();
        return $row->department_id;
    }

    function getValidateEmail($email) {
        //check for given email is valid or not
        $result = filter_var($email, FILTER_VALIDATE_EMAIL);
        return $result;
    }

    function isValidDate($date_to_check) {
        //check for given email is valid or not
        //$result = filter_var($email, FILTER_va VALIDATE_EMAIL);
        return $result;
    }

    function getCurrentSessionData($session_id) {
        $query = $this->db->get_where($this->db->dbprefix . 'employee_temp', array('session_id' => $session_id));
        $result = $query->result();

        return $result;
    }

    function getPostImportEmpData($session_id, $successflag = 'Y') {
        $query = $this->db->get_where($this->db->dbprefix . 'employee_temp', array('session_id' => $session_id, 'post_success_status' => $successflag));
        $result = $query->result();

        return $result;
    }

    function getPostImportData($session_id) {
        $query = $this->db->get_where($this->db->dbprefix . 'employee_temp', array('session_id' => $session_id, 'error_found' => 0));
        $result = $query->result();

        return $result;
    }

    function isEmpidExists($empid) {
        $query = $this->db->query("SELECT count(*) as howmany FROM " . $this->db->dbprefix . "employee WHERE employee_id='" . $empid . "' ");
        $row = $query->first_row();
        return $row;
    }

    function isEmailExists($email) {
        $query = $this->db->query("SELECT count(*) as howmany FROM " . $this->db->dbprefix . "employee WHERE email='" . $email . "' ");
        $row = $query->first_row();
        return $row;
    }

    function isLoginNameExists($email) {
        $query = $this->db->query("SELECT count(*) as howmany FROM " . $this->db->dbprefix . "employee WHERE login_name='" . $email . "' ");
        $row = $query->first_row();
        return $row;
    }

    function getGender($gender) {
        $output = '-';
        $gender = strtolower(trim($gender));
        $arrList = array('m', 'f', 'male', 'female');
        if (in_array($gender, $arrList)) {
            //echo '<br>Valid Gender: ' . $gender;
            $output = strtoupper($gender);
        }

        return $output{0};
    }

    function ajax_doimport() {
        
    }

}

//End of Class