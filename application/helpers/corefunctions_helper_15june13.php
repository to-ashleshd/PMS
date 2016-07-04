<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if (!function_exists('update_env_setting')) {

    function update_env_setting($setting_name, $setting_value) {
        $data = array();
        $data = array('setting_value' => $setting_value);
        $env_table = $this->db->coreprefix . 'env_setting_install';
        $result = $this->db->update($env_table, $data, array('setting_name' => $setting_name));

        return $result;
    }

}

if (!function_exists('get_datepicker_date')) {

    function get_datepicker_date($phpformat) {
        //d/m/Y
        //d.m.Y
        //d-m-Y
        //m/d/Y
        //Y/m/d
        //Y-m-d

        $output = 'd-m-Y';
        if ($phpformat == 'd/m/Y') {
            $output = 'dd/mm/yy';
        }

        if ($phpformat == 'd.m.Y') {
            $output = 'dd.mm.yy';
        }

        if ($phpformat == 'd-m-Y') {
            $output = 'dd-mm-yy';
        }

        if ($phpformat == 'm/d/Y') {
            $output = 'md/dd/yy';
        }

        if ($phpformat == 'Y/m/d') {
            $output = 'yy/mm/dd';
        }

        if ($phpformat == 'Y-m-d') {
            $output = 'yy-mm-dd';
        }

        return $output;
    }

}

if (!function_exists('get_datepicker_date2')) {

    function get_datepicker_date2($phpformat) {
        //d/m/Y
        //d.m.Y
        //d-m-Y
        //m/d/Y
        //Y/m/d
        //Y-m-d

        $output = 'd-m-Y';
        if ($phpformat == 'd/m/Y') {
            $output = 'dd/mm/yyyy';
        }

        if ($phpformat == 'd.m.Y') {
            $output = 'dd.mm.yyyy';
        }

        if ($phpformat == 'd-m-Y') {
            $output = 'dd-mm-yyyy';
        }

        if ($phpformat == 'm/d/Y') {
            $output = 'md/dd/yyyy';
        }

        if ($phpformat == 'Y/m/d') {
            $output = 'yyyy/mm/dd';
        }

        if ($phpformat == 'Y-m-d') {
            $output = 'yyyy-mm-dd';
        }

        return $output;
    }

}


if (!function_exists('stripQuotes')) {

    function stripQuotes($value) {
        $output = '';
        $strlen = strlen($value);

        $output = substr($value, 1, $strlen - 2);
        return $output;
    }

}


if (!function_exists('get_pms_status')) {

    function get_pms_status($submit_status) {
        $output = '';
        $arrStatus[1] = 'Pending with Appraisee';
        $arrStatus[2] = 'Pending with Appraiser';
        $arrStatus[3] = 'Pending with Reviewer';
        $arrStatus[4] = 'Complete';

        if ($submit_status == 0) {
            //User is registered but did not fillup KRA 
            $output = $arrStatus[1];
        } 
        else if( $submit_status == 0.2) {
            $output = $arrStatus[2];
        }        
        else if ($submit_status == 1) {
            //For Next year kra
            $output = $arrStatus[1];
        } else if ($submit_status == 2) {
            $output = $arrStatus[1];
        } else if ($submit_status == 3) {
            $output = $arrStatus[2];
        } else if ($submit_status == 4) {
            $output = $arrStatus[2];
        } else if ($submit_status == 5) {
            $output = $arrStatus[2];
        } else if ($submit_status == 6) {
            $output = $arrStatus[3];
        } else if ($submit_status == 7) {
            $output = $arrStatus[3];
        } else if ($submit_status == 8) {
            $output = $arrStatus[4];
        }
        
        return $output ;
    }
}

if (!function_exists('get_kra_status')) {

    function get_kra_status($submit_status) {
        $output = '';
        $arrStatus[1] = 'Pending with Appraisee';
        $arrStatus[2] = 'Pending with Appraiser';
        $arrStatus[3] = 'Pending with Reviewer';
        $arrStatus[4] = 'Complete';
        $arrStatus[5] = 'KRA not Filled up.';
        $arrStatus[6] = 'KRA Approved By Appraiser.';
        $arrStatus[7] = 'KRA Approved - Pnding with Appraiser.';

        if ($submit_status == 0) {
            //User is registered but did not fillup KRA 
            $output = $arrStatus[5];
        } 
        else if( $submit_status == 0.2) {
            $output = $arrStatus[2];
        }        
        else if ($submit_status == 1) {
            //For Next year kra
            $output = $arrStatus[6];
        } else if ($submit_status == 2) {
            //$output = $arrStatus[1];
            $output = $arrStatus[6];
        } else if ($submit_status == 3) {
            //$output = $arrStatus[2];
            $output = $arrStatus[6];
        } else if ($submit_status == 4) {
            //$output = $arrStatus[2];
            $output = $arrStatus[6];
        } else if ($submit_status == 5) {
            //$output = $arrStatus[2];
            $output = $arrStatus[6];
        } else if ($submit_status == 6) {
            //$output = $arrStatus[3];
            $output = $arrStatus[6];
        } else if ($submit_status == 7) {
            //$output = $arrStatus[3];
            $output = $arrStatus[6];
        } else if ($submit_status == 8) {
            $output = $arrStatus[4];
        }
        
        return $output ;
    }
    
    if (!function_exists('getScoreNameByScore')) {
    function getScoreNameByScoreForPreview($score) {
        $score_name = '';
        $score = round($score, 2);
        if ($score < 1) {
            $score_name = 'N.A.';
        } elseif ($score < 2) {
            $score_name = 'BE';
        } elseif ($score >= 2 && $score < 2.79) {
            $score_name = 'NI';
        } elseif ($score >= 2.80 && $score < 3.49) {
            $score_name = 'ME';
        } elseif ($score >= 3.50 && $score < 4.24) {
            $score_name = 'EE';
        } elseif ($score >= 4.25 && $score <= 5.00) {
            $score_name = 'FEE';
        }
        return $score_name;
    }
    
    }
    
    
    
    
}


?>