<?php 
//session_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generalesettings extends CI_Model {

  public function getAllSettings()
  {
       $this->db->select('*');
       $this->db->from($this->db->dbprefix . 'env_setting_install' );
       $query = $this->db->get();
       $row = $query->first_row();
       return $row->setting_value;
  }
  
  public function getImage()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 'gen_company_logo'));
       $row = $query->first_row();
       if(empty($row))
       {
           return '';
       }
       else
       {
        return $row->setting_value;
       }
       
  }
  
  public function getSiteName()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 'gen_site_name'));
       $row = $query->first_row();
       if(empty($row))
       {
           return 'Enrich';
       }
       else
       {
        return $row->setting_value;
       }
       
  }
  
  public function getAllowClientRegistration()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 'gen_clientreg'));
       $row = $query->first_row();
       if(empty($row))
       {
           return 'Y';
       }
       else
       {
        return $row->setting_value;
       }
     
  }
  
  public function getSiteOffline()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 'gen_is_offline'));
       $row = $query->first_row();
       if(empty($row))
       {
           return 'N';
       }
       else
       {
        return $row->setting_value;
       }
       
  }
  
  public function getSiteOfflineMessage()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 'gen_off_message'));
       $row = $query->first_row();
       if(empty($row))
       {
           return 'Site offline. Under maintanance';
       }
       else
       {
        return $row->setting_value;
       }
       
  }
    
  public function getRowsPerPage()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 'gen_rows_per_page'));
       $row = $query->first_row();
       if(!$row)
       {
           return '10';
       }
       else
       {
        return $row->setting_value;
       }
      
  }
  
  public function getThemeTemplate()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 'gen_rows_per_page'));
       $row = $query->first_row();
       if($row)
       {
           return 'default';
       }
       else
       {
        return $row->setting_value;
       }
  }
  
  public function getMailer()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_mailer'));
       $row = $query->first_row();
       return $row->setting_value;
  }
  
  public function getFromEmail()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_mail_from'));
       $row = $query->first_row();
       return $row->setting_value;
  }
  
  public function getFromName()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_mail_name'));
       $row = $query->first_row();
       return $row->setting_value;
  }
  
  public function getSmtpUsername()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_smtp_user'));
       $row = $query->first_row();
       return $row->setting_value;
  }
  
  
  public function getSmtpPassword()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_smtp_password'));
       $row = $query->first_row();
       return $row->setting_value;
  }
  public function getSmtpHost()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_smtp_host'));
       $row = $query->first_row();
       return $row->setting_value;
  } 
  
  public function getSmtpPort()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_smtp_port'));
       $row = $query->first_row();
       return $row->setting_value;
  } 
  
  public function getSmtpSslType()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 'u_ssl'));
       $row = $query->first_row();
       return $row->setting_value;
  }
  
  
  public function getLanguageForVisitors()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_lang_visitors'));
       $row = $query->first_row();
       return $row->setting_value;
  }
  
  
  public function getLanguageForRedirect()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_lang_redirect'));
       $row = $query->first_row();
       return $row->setting_value;
  }
  
  public function getTimeFormat()
  {
      $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_time_format'));
       $row = $query->first_row();
       return $row->setting_value;
  }
  
  public function getDateFormat()
  {
      $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_date_format'));
       $row = $query->first_row();
       return $row->setting_value;
  }
  
  public function getDecimalFormat()
  {
      $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_decimal_format'));
       $row = $query->first_row();
       return $row->setting_value;
  }
  
  public function getCurrencyFormat()
  {
      $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_currency_format'));
       $row = $query->first_row();
       return $row->setting_value;
  }
  
  public function getCurrency()
  {
      $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_currency'));
       $row = $query->first_row();
       return $row->setting_value;
  }
  
   public function getDefaultCountry()
  {
      $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_select_country'));
      $row = $query->first_row();
      return $row->setting_value;
  }
  
   public function getPreferTimeZone()
  {
      $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_time_zone'));
      $row = $query->first_row();
      return $row->setting_value;
  }
  
  public function getCaptchaType()
  {
      $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_captcha'));
      $row = $query->first_row();
      return $row->setting_value;
  }
  
  public function getRecaptchaDomainname()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 'recaptcha_domainname'));
      $row = $query->first_row();
      return $row->setting_value;
  }
  
   public function getReCaptchaPublicKey()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 'recaptcha_publickey'));
      $row = $query->first_row();
      return $row->setting_value;
  }
  
   public function getReCaptchaPrivateKey()
  {
       $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 'recaptcha_privatekey'));
      $row = $query->first_row();
      return $row->setting_value;
  }
  
  public function getRequiredPasswordStrength()
  {
      $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 'ui_slider3_sel'));
      $row = $query->first_row();
      return $row->setting_value;
  }
 
  public function getLoginbanTime()
  {
      $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_bantime'));
      $row = $query->first_row();
      return $row->setting_value;
  }
  
  public function getInvalidLoginAttempts()
  {
      $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_bantime_attempts'));
      $row = $query->first_row();
      return $row->setting_value;
  }
  
  public function getChangePasswordAfterDays()
  {
      $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_password_change_days'));
      $row = $query->first_row();
      return $row->setting_value;
  }
  
  public function getCantUseLastNPasswords()
  {
      $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 'cant_use_last_passwd'));
      $row = $query->first_row();
      return $row->setting_value;
  }
  
  public function getAdminClientDisplayFormat()
  {
      $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 's_client_display_format'));
      $row = $query->first_row();
      if(!empty($row))
      {
      return $row->setting_value; 
      }
      else
      {
          return 'fname_lname';
      }
  }
  
  public function getEmailTemplate()
  {
      $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' => 'emailtemplate_code'));
      $row = $query->first_row();
      return $row->setting_value; 
  }
  
  public function getIsMultiCompany()
  {
      $query = $this->db->get_where($this->db->dbprefix . 'env_setting_install' , array('setting_name' =>'e_multicompany'));
      $row = $query->first_row();
      if(!empty($row))
      {
      return $row->setting_value;
      }
      else
      {
          return '';
      }
  }
  
  
  
  
  
}

