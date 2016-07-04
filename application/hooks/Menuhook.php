<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Iehook {
    
    public function checkie()
    {
        //echo $_SERVER['HTTP_USER_AGENT'];
        $arrSplict = explode(';', $_SERVER['HTTP_USER_AGENT']);
        //print_r($arrSplict);
        $is_ie = false;
        foreach($arrSplict as $row) {
            //print_r($row);
            $pos = strpos($row, '.NET');
            if( $pos !== false) {
                //echo '<br>Using IE';
                $is_ie = true ;
            }

        }
        
        if( $is_ie == true) {
            //echo '<h2>This program did not work on IE.</h2>Please use FireFox or Google Chrome.';
            include_once('ie_error.php');
            die();
        }
        
    }
}

/**
 * Description of Menuhook
 *
 * @author Ajay.g
 */
class Menuhook {
    //put your code here
    public function rendermenu($vars)
    {
        @session_start();
        echo 'This is rendermenu ' ;
        print_r($vars);
        print_r($_REQUEST);
        print_r($_SESSION);
        echo '<hr>';
        
    }
    
    public function renderdisplay($vars)
    {
        @session_start();
        echo '<hr>';
        print_r($vars);
        print_r($_REQUEST);
        print_r($_SESSION);
        $CI =& get_instance();
        $CI =& get_instance();
        $data['version'] = 'V5.2' ;
        $data['eng_about'] = 'Eng About From Hook';
        $CI->output->set_output('This is output');
        $CI->output->_display();
        $CI->output->get_output();
    }
    
    
}

?>
