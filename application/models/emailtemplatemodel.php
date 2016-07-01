<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Emailtemplatemodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function new_template() {
    
        if ($this->input->post('templatecode') == '' or $this->input->post('templatesubject') == '' or $this->input->post('wysiwg_editor') == '') {
            $result = 'error';
        } else {

            $data = array(
                'emailtemplate_code' => $this->input->post('templatecode'),
                'emailtemplate_subject' => $this->input->post('templatesubject'),
                'emailtemplate_body' => $this->input->post('wysiwg_editor'),
                'emailtemplate_desc' => $this->input->post('templatedescription')
            );

            $result = $this->db->insert($this->db->dbprefix . 'emailtemplate', $data);
        }


        return $result;
    }

    function update_template() {
        if ($this->input->post('templatecode') == '' or $this->input->post('templatesubject') == '' or $this->input->post('wysiwg_editor') == '') {
            $result = 'error';
        } else {

            $data = array(
                'emailtemplate_code' => $this->input->post('templatecode'),
                'emailtemplate_subject' => $this->input->post('templatesubject'),
                'emailtemplate_body' => $this->input->post('wysiwg_editor'),
                'emailtemplate_desc' => $this->input->post('templatedescription')
            );
            
            $result = $this->db->update($this->db->dbprefix . 'emailtemplate', $data, array('emailtemplate_id' => $this->input->post('templateid')));
        }

        return $result;
    }

    function all_templates() {
        $query = $this->db->get($this->db->dbprefix . 'emailtemplate');
        $result = $query->result();

        return $result;
    }

    function get_template($template_id) {
        $query = $this->db->get_where($this->db->dbprefix . 'emailtemplate', array('emailtemplate_id' => $template_id));


        //$query = $query->result();
        $row = $query->first_row();
        return $row;
    }

    function get_template_by_code($template_code, $data = array()) {
        $output = array();
        $query = $this->db->get_where($this->db->dbprefix . 'emailtemplate', array('emailtemplate_code' => $template_code));

        //$query = $query->result();
        $row = $query->first_row();
        
        $email_subject = $row->emailtemplate_subject ;
        $email_body  = $row->emailtemplate_body ;
        //Checek for data is available or not
        if( count($data) >= 1 )
        {
            foreach( $data as $key=>$val )
            {
                $email_body = str_replace("%" . $key . "%", $val , $email_body);
            }
        }
        
        $output['email_subject'] = $email_subject ;
        $output['email_body'] = $email_body ;
        return $output;
    }

    function delete_template($template_id) {
        $query = $this->db->delete($this->db->dbprefix . 'emailtemplate', array('emailtemplate_id' => $template_id));

        return $query;
    }
    
    function get_mail_settings()
    {
        $this->load->model('commonmodel');
        $is_smtp = $this->commonmodel->get_env_setting('s_mailer');
        
        $s_smtp_user = $this->commonmodel->get_env_setting('s_smtp_user');
        $s_smtp_password = $this->commonmodel->get_env_setting('s_smtp_password');
        $s_smtp_host = $this->commonmodel->get_env_setting('s_smtp_host');
        $s_smtp_port = $this->commonmodel->get_env_setting('s_smtp_port');
        $config['mailtype'] = 'html';
        
        if( $is_smtp == 'smtp' ) {
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = $s_smtp_host;
            $config['smtp_user'] = $s_smtp_user;
            $config['smtp_pass'] = $s_smtp_password;
            $config['smtp_port'] = $s_smtp_port;
           
        }
        //s_smtp_user
        //s_smtp_password
        //s_smtp_host
        //s_smtp_port
        
        $this->email->initialize($config);

    }
    

}