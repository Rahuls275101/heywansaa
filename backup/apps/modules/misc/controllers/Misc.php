<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Misc extends Public_Controller {

  public function __construct() {
    parent::__construct();
        $this->load->model(array('category/category_model', 'products/product_model', 'admin/color_model', 'admin/size_model','Misc_model'));
        $this->load->helper(array('products/product', 'category/category'));
        $this->load->library(array('Dmailer', 'safe_encrypt'));
  }

  public function bulkorder() 
  {
      $this->load->view('bulkorder');
  }
  
  public function todaydeals($offset=0) 
  {
    
       $this->load->library("pagination");
       $page_title = "Todays Deals";
       $data['total_rows'] = $data['total_list_rows'] = $config['total_rows'] = get_found_rows();
       $data['heading_title'] = $page_title;
    //   $data['products'] = $res_array;
       $config = array();
       $config["base_url"] = base_url()."misc/todaydeals";
       $config["total_rows"] = $this->Misc_model->gettodaydelscount();
       $config["per_page"] = 12;
       $config["uri_segment"] = 3;
       
       
       
       
       
       
       
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
             
            $config['first_link'] = 'First Page';
            $config['first_tag_open'] = '<li class="page-item">';
            $config['first_tag_close'] = '</li>';
             
            $config['last_link'] = 'Last';
            $config['last_tag_open'] = '<li class="page-item">';
            $config['last_tag_close'] = '</li>';
             
            $config['next_link'] = 'Next Page';
            $config['next_tag_open'] = ' <li class="next">';
            $config['next_tag_close'] = '</li>';
            $config['prev_link'] = '<i class="w-icon-long-arrow-left"></i>Prev';
            $config['prev_tag_open'] = '<li class="prev disabled">';
            $config['prev_tag_close'] = '</li>';
            
            $config['cur_tag_open'] = '<li class="page-item active">';
            $config['cur_tag_close'] = '</li>';
 
            $config['num_tag_open'] = '<li class="page-item">';
            $config['num_tag_close'] = '</li>';

       
       
       $this->pagination->initialize($config);
       $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
       $data['products'] = $this->Misc_model->gettodaydels_rows($config['per_page'], $offset);
       $data["links"] = $this->pagination->create_links();
       $data['category_list']=$this->Misc_model->get_category_list();
       $this->load->view('todaysdeal',$data);
  }
  
  
  
  
 public function todaydealsycategory($cat_id=null,$offset=0) 
  {
    
       $this->load->library("pagination");
       $page_title = "Todays Deals";
       $data['total_rows'] = $data['total_list_rows'] = $config['total_rows'] = get_found_rows();
       $data['heading_title'] = $page_title;
    //   $data['products'] = $res_array;
       $config = array();
       $config["base_url"] = base_url()."misc/todaydealsycategory/$cat_id";
       $config["total_rows"] = $this->Misc_model->gettodaydelscountby_category($cat_id);
       $config["per_page"] = 12;
       $config["uri_segment"] = 4;
       
       
       
       
       
       
       
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
             
            $config['first_link'] = 'First Page';
            $config['first_tag_open'] = '<li class="page-item">';
            $config['first_tag_close'] = '</li>';
             
            $config['last_link'] = 'Last';
            $config['last_tag_open'] = '<li class="page-item">';
            $config['last_tag_close'] = '</li>';
             
            $config['next_link'] = 'Next Page';
            $config['next_tag_open'] = ' <li class="next">';
            $config['next_tag_close'] = '</li>';
            $config['prev_link'] = '<i class="w-icon-long-arrow-left"></i>Prev';
            $config['prev_tag_open'] = '<li class="prev disabled">';
            $config['prev_tag_close'] = '</li>';
            
            $config['cur_tag_open'] = '<li class="page-item active">';
            $config['cur_tag_close'] = '</li>';
 
            $config['num_tag_open'] = '<li class="page-item">';
            $config['num_tag_close'] = '</li>';

       
       
       $this->pagination->initialize($config);
       $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
       $data['products'] = $this->Misc_model->gettodaydels_rows_by_category($config['per_page'], $offset,$cat_id);
        //  print_r($this->db->last_query());die;
       $data["links"] = $this->pagination->create_links();
       $data['category_list']=$this->Misc_model->get_category_list();
       
     
       
       $this->load->view('todaysdeal',$data);
  }
  
  
  
  public function addbulkorder()
  {
      $this->form_validation->set_rules('name','Name','trim|required');
      $this->form_validation->set_rules('mobile','Name','trim|required');
      $this->form_validation->set_rules('email','Name','trim|required');
      $this->form_validation->set_rules('productname','Name','trim|required');
      $this->form_validation->set_rules('location','Name','trim|required');
      if($this->form_validation->run())
      {
       
          $data=array(
                        'product_name'=>$this->input->post('productname'),
                        'name'=>$this->input->post('name'),
                        'email'=>$this->input->post('email'),
                        'phone'=>$this->input->post('mobile'),
                        'city'=>$this->input->post('location'),
                        'user_id'=>$this->session->userdata('user_id'),
                     );
                     
                     if($this->Misc_model->add_master('wps_bulk_buy',$data))
                     {
                         $this->session->set_flashdata('bulkmsg','<div class="alert alert-success">Successfully Sent your request they`ll contact you sortly!</div>');
                         redirect(base_url().'bulkorder');
                     }
                     else
                     {
                         $this->session->set_flashdata('bulkmsg','<div class="alert alert-danger">Something wrong in  your request!</div>');
                         redirect(base_url().'bulkorder');   
                     }
      }
      else
      {
          $this->session->set_flashdata('bulkmsg','<div class="alert alert-danger">'.validation_errors().'</div>');
          redirect(base_url().'bulkorder');
      }
      
      
      
      
  }
  
  
  
  
  
  
  
}