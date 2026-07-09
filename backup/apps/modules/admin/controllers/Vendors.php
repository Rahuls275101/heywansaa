<?php

class Vendors extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('vendor_model');
  }

  public function index($page = NULL) 
  {
    //   $where=array('admin_type'=>'2');// 2 for vendor
        $data['res']=$this->vendor_model->get_vendor_list();
        $data['headingTitle']="Vendor List";
        $this->load->view('vendor/vendor_list',$data);
      
  }
  
  public function unverified_vendors()
  {
     $data['res']=$this->vendor_model->get_un_verify_vendor_list();
        $data['headingTitle']="Un-verified Vendor List";
        $this->load->view('vendor/vendor_list',$data); 
  }
  
  public function make_inactive($id)
  {
      $data=array('verification_status'=>1);
      $where=array('admin_id'=>$id);
     if($this->vendor_model->update_where('wps_admin',$data,$where))
     {
         $this->session->set_flashdata('msg','Successfully Inactive Vendor.');
         redirect('wps-admin/vendors');
     }
     else
     {
         $this->session->set_flashdata('msg','Something Error');
         redirect('wps-admin/vendors');
     }
  }
  
  public function make_active($id)
    {
          $data=array('verification_status'=>2);
          $where=array('admin_id'=>$id);
             if($this->vendor_model->update_where('wps_admin',$data,$where))
             {
                 $this->session->set_flashdata('msg','Successfully Inactive Vendor.');
                 redirect('wps-admin/vendors/unverified');
             }
             else
             {
                 $this->session->set_flashdata('msg','Something Error');
                 redirect('wps-admin/vendors/unverified');
             }
    }
      
  
  
  
  
}