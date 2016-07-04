<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller_constructor'] = array(
                                'class'    => 'Iehook',
                                'function' => 'checkie',
                                'filename' => 'Menuhook.php',
                                'filepath' => 'hooks',
                                'params'   => array('user1', 'level1', 'site1')
                                );

//
//$hook['post_controller_constructor'] = array(
//                                'class'    => 'Menuhook',
//                                'function' => 'rendermenu',
//                                'filename' => 'Menuhook.php',
//                                'filepath' => 'hooks',
//                                'params'   => array('user1', 'level1', 'site1')
//                                );


/**
$hook['post_controller_constructor'] = array(
                                'class'    => 'Menuhook',
                                'function' => 'rendermenu',
                                'filename' => 'Menuhook.php',
                                'filepath' => 'hooks',
                                'params'   => array('user1', 'level1', 'site1')
                                );

$hook['display_override'] = array(
                                'class'    => 'Menuhook',
                                'function' => 'renderdisplay',
                                'filename' => 'Menuhook.php',
                                'filepath' => 'hooks'
                                );
**/

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */