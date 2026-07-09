<?php
class Social_links extends CI_Controller{
    
    public function __construct()
    {
        
		
		parent:: __construct();

         
    }
    
    public function index()
    {
        $data['headingTitle']="Social Links";
       $data['ALLDATA']=$this->db->get('social_links')->result_array();
       	$this->load->view('social/view_social_list',$data);
    }
   
    public function edit()
    {
        $id     =   $this->input->post('id');
        $name   =   $this->input->post('name');
        $link   =   $this->input->post('link');
        $data   =   array('link'=>$link);
        $where  =   array('id'=>$id,'name'=>$name);
        $this->db->where($where);
        if($this->db->update('social_links',$data))
        {
            $this->session->set_flashdata('update_msg','<div class="alert alert-danger">Successfully Updated '.$name.'</div>');
        }
        else
        {
            $this->session->set_flashdata('update_msg','<div class="alert alert-danger">Successfully Updated '.$name.'</div>');
        }
        redirect('wps-admin/social_links');
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

