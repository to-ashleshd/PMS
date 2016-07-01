<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Competencies extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->topmenu->no_cache();
        
        $this->load->model('companymodel');
        $this->load->model('generalesettings');
        $this->load->model('competenciesmodel');
        $this->load->model('commonmodel');
    }

    public function index() {
       
        if($this->session->userdata('pms_employee_id'))
        {
           $this->competencies();
        }
        else
        {
            redirect('clientadmin','refresh');
        }
      
    }

    /*
     * ****************************************
     * Basic Settings competencies,rating.. etc
     * ****************************************
     */

    function competencies()
    {
        $data = array();
        $data['site_name'] = $this->generalesettings->getSiteName();
        $data['logo'] = $this->generalesettings->getImage();
        
        $data['grades'] = $this->commonmodel->get_all_grades();
        
        $competencies_for_refrence = $this->competenciesmodel->get_all_cometencies();
        
        if(!empty($competencies_for_refrence))
        {
            foreach($competencies_for_refrence as $key=>$val)
            {
                $grades ='';
                $comp_grades_detail = $this->competenciesmodel->get_grade_by_competencies_id($val['competencies_for_refrence_id']);
                if(!empty($comp_grades_detail))
                {
                    foreach($comp_grades_detail as $keyc=>$valc)
                    {
                        if($grades=='')
                        {
                            $grades = $valc['grade_name'];
                        }
                        else
                        {
                            $grades = $grades.', '.$valc['grade_name'];
                        }
                    }
                }
                $status ="N.A.";
                if($val['competencies_status']==1)
                {
                    $status = 'Enabled';
                }
                else
                {
                    $status = 'Disabled';
                }
                $data['competencies_for_refrence'][] = array(
                    'competencies_for_refrence_id' => $val['competencies_for_refrence_id'],
                    'competencies_name'=>$val['competencies_name'],
                    'competencies_decription'=>$val['competencies_decription'],
                    'weightage_id' => $val['weightage_id'],
                    'weightage_value'=> $val['weightage_value'],
                    'status' => $status,
                    'grades' => $grades
                );
            }
        }
        
         
            $data['topmenu'] = $this->topmenu->apraiseemenulist();
            $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
            $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
            $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
            $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
            $this->load->view('default/clientadmin/cadmin_addcompetencies', $data);
    }
    
     function add_competencies()
     {
       
         if($this->session->userdata('pms_employee_id'))
         {
             if($_POST)
             {
                 $weightage_detail = $this->commonmodel->get_weightage_by_value($this->input->post('weightage'), '1');
                        if (empty($weightage_detail)) {

                            $weight_data = array(
                                'weightage_value' => $this->input->post('weightage'),
                                'date_created' => date('Y-m-d'),
                                'weightage_status' => '1'
                            );
                            $weightage_id = $this->commonmodel->add_weightage($weight_data);
                        } else {
                            $weightage_id = $weightage_detail['weightage_id'];
                        }
                        
                 $data_competencies = array(
                        'competencies_name' => trim(ucfirst($this->input->post('comp_name'))),
                        'competencies_decription' => trim(ucfirst($this->input->post('comp_desc'))),
                        'weightage_id' => $weightage_id,
                        'date_created' => date('Y-m-d'),
                        'competencies_status' => $this->input->post('status')
                     );
                 
                 $competencies_id = $this->competenciesmodel->add_competencies($data_competencies);
                
                 foreach($this->input->post('grade') as $key=>$val)
                 {
                    $data_comp_grade = array(
                        'competencies_for_refrence_id' => $competencies_id,
                        'grade_id'=> $val,
                        'status' =>'1'
                    );

                       
                   $competencies_grade = $this->competenciesmodel->add_competencies_to_grade($data_comp_grade);
                 }
                  $data = array();
                $data['site_name'] = $this->generalesettings->getSiteName();
                $data['logo'] = $this->generalesettings->getImage();

                $data['grades'] = $this->commonmodel->get_all_grades();

                  $competencies_for_refrence = $this->competenciesmodel->get_all_cometencies();
        
        if(!empty($competencies_for_refrence))
        {
            foreach($competencies_for_refrence as $key=>$val)
            {
                $grades ='';
                $comp_grades_detail = $this->competenciesmodel->get_grade_by_competencies_id($val['competencies_for_refrence_id']);
                if(!empty($comp_grades_detail))
                {
                    foreach($comp_grades_detail as $keyc=>$valc)
                    {
                        if($grades=='')
                        {
                            $grades = $valc['grade_name'];
                        }
                        else
                        {
                            $grades = $grades.', '.$valc['grade_name'];
                        }
                    }
                }
                $status ="N.A.";
                if($val['competencies_status']==1)
                {
                    $status = 'Enabled';
                }
                else
                {
                    $status = 'Disabled';
                }
                $data['competencies_for_refrence'][] = array(
                    'competencies_for_refrence_id' => $val['competencies_for_refrence_id'],
                    'competencies_name'=> trim(ucfirst($val['competencies_name'])),
                    'competencies_decription'=> trim(ucfirst($val['competencies_decription'])),
                    'weightage_id' => $val['weightage_id'],
                    'weightage_value'=> $val['weightage_value'],
                    'status' => $status,
                    'grades' => $grades
                );
            }
        }
                    $data['topmenu'] = $this->topmenu->apraiseemenulist();
                    $data['header'] = $this->load->view('default/clientadmin/cadmin_header', $data, true);
                    $data['middle_footer'] = $this->load->view('default/clientadmin/cadmin_middle_footer', $data, true);
                    $data['common_js'] = $this->load->view('default/clientadmin/cadmin_common_js', $data, true);
                    $data['last_footer'] = $this->load->view('default/clientadmin/cadmin_last_footer', '', true);
                    $this->load->view('default/clientadmin/cadmin_addcompetencies', $data);
               
             }
             else
                {
                 redirect('accessdenied','refresh');
                }
         }
         else
         {
             redirect('accessdenied','refresh');
         }
     }
    
     
     function update_competencies()
     {
         $response =array();
         $comp_ref_id = $this->input->post('comp_ref_id',TRUE);
         $response['competencies_detail'] = $this->competenciesmodel->get_competencies_by_id($comp_ref_id);
         $response['action'] = site_url('competencies/update_competencies_data');
         die(json_encode($response));
//         echo "<pre>";
//         print_r($competencies_detail);
//         echo "</pre>";
//         die();
     }
    
     function update_competencies_data()
     {
         
        // die();
         if($this->session->userdata('pms_employee_id'))
         {
             if($_POST)
             {
                 $competencies_id = $this->input->post('h_competencies_id',TRUE);
                 $weightage_detail = $this->commonmodel->get_weightage_by_value($this->input->post('weightage'), '1');
                        if (empty($weightage_detail)) {

                            $weight_data = array(
                                'weightage_value' => $this->input->post('weightage'),
                                'date_created' => date('Y-m-d'),
                                'weightage_status' => '1'
                            );
                            $weightage_id = $this->commonmodel->add_weightage($weight_data);
                        } else {
                            $weightage_id = $weightage_detail['weightage_id'];
                        }
                        
                 $data_competencies = array(
                        'competencies_name' => $this->input->post('comp_name'),
                        'competencies_decription' => $this->input->post('comp_desc'),
                        'weightage_id' => $weightage_id,
                        'competencies_status' => $this->input->post('status')
                     );
                
                 $this->competenciesmodel->update_competencies($competencies_id,$data_competencies);
              
                 foreach($this->input->post('grade') as $key=>$val)
                 {
                    $data_comp_grade = array(
                        'competencies_for_refrence_id' => $competencies_id,
                        'grade_id'=> $val,
                        'status' =>'1'
                    );

                   $this->competenciesmodel->remove_grade_by_competencies_and_grade_id($competencies_id,$val);
                   $competencies_grade = $this->competenciesmodel->add_competencies_to_grade($data_comp_grade);
                 }
                  $data = array();
                $data['site_name'] = $this->generalesettings->getSiteName();
                $data['logo'] = $this->generalesettings->getImage();

                $data['grades'] = $this->commonmodel->get_all_grades();

                  $competencies_for_refrence = $this->competenciesmodel->get_all_cometencies();
        
        if(!empty($competencies_for_refrence))
        {
            foreach($competencies_for_refrence as $key=>$val)
            {
                $grades ='';
                $comp_grades_detail = $this->competenciesmodel->get_grade_by_competencies_id($val['competencies_for_refrence_id']);
                if(!empty($comp_grades_detail))
                {
                    foreach($comp_grades_detail as $keyc=>$valc)
                    {
                        if($grades=='')
                        {
                            $grades = $valc['grade_name'];
                        }
                        else
                        {
                            $grades = $grades.', '.$valc['grade_name'];
                        }
                    }
                }
                $status ="N.A.";
                if($val['competencies_status']==1)
                {
                    $status = 'Enabled';
                }
                else
                {
                    $status = 'Disabled';
                }
                $data['competencies_for_refrence'][] = array(
                    'competencies_for_refrence_id' => $val['competencies_for_refrence_id'],
                    'competencies_name'=>$val['competencies_name'],
                    'competencies_decription'=>$val['competencies_decription'],
                    'weightage_id' => $val['weightage_id'],
                    'weightage_value'=> $val['weightage_value'],
                    'status' => $status,
                    'grades' => $grades
                );
            }
        }
                    $this->session->set_userdata('success', 'Competencies for refrence modified successfully!');
                   
                  redirect('competencies/competencies','refresh');
               
             }
             else
                {
                 redirect('accessdenied','refresh');
                }
         }
         else
         {
             redirect('accessdenied','refresh');
         }
         
         
         
         
     }
    
     
     function delete_competencies()
     {
         $response = array();
         $response['status'] ='';
         $comp_ref_id = $this->input->post('comp_ref_id',TRUE);
         $is_comp_used = $this->competenciesmodel->check_is_competencoes_for_refrence_used($comp_ref_id);
         if($is_comp_used=='N')
         {
             //delete
             $data = array('competencies_status'=>'2');
             $this->competenciesmodel->update_competencies($comp_ref_id,$data);
             $response['status'] = '1';
             //$this->session->set_userdata('success', 'Competencies deleteted successfully!');
             //redirect('competencies/competencies','refresh');
         }
         else
         {
             $response['status'] = '2';
         }
         die(json_encode($response));
     }
     
     
}  
  
 
