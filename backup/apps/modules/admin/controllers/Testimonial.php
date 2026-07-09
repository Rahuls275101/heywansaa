<?php

class Testimonial extends Admin_Controller 
{

      public function __construct() 
      {
        parent::__construct();
        $this->load->model('Admin_common_model');
        // $this->session->keep_flashdata('msg');
      }

      public function index($page = NULL) 
      {
          $r['res']=$this->Admin_common_model->get_master('wps_testimonial');
          $r['headingTitle']="Testimonial";
          $this->load->view('testimonial/list_testimonial',$r);
      }
      
      public function add_new_testimonial()
      {
          $r['headingTitle']="Add-Testimonial";
          $this->load->view('testimonial/add_testimonial',$r);
      }
      
      public function add_new_testimonial_action()
      {
          
          
          $this->form_validation->set_rules('name','Name','required|trim');
          $this->form_validation->set_rules('title','Title','required|trim');
          $this->form_validation->set_rules('desc','Description','required|trim');
          if($this->form_validation->run())
          {
                $uploaded_file='';
                $config['upload_path']          = UPLOAD_DIR.'/testimonial/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 100000;
                $config['encrypt_name']         = true;

                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('image'))
                {
                    $this->session->set_flashdata('msg', $this->upload->display_errors());
                    redirect('wps-admin/add/testimonial');
                }
                else
                {
                    $uploaded_data = array('upload_data' => $this->upload->data());
                    $uploaded_file = $uploaded_data['upload_data']['file_name'];
                }
                $data=array(
                            'poster_name'  =>$this->input->post('name'),
                            'testimonial_title' =>$this->input->post('title'),
                            'testimonial_image' =>$uploaded_file,
                            'testimonial_description' =>$this->input->post('desc'),
                            );
              if($this->Admin_common_model->add_master('wps_testimonial',$data)) 
              {
                    $this->session->set_flashdata('msg',"Successfully Added");
                    redirect('wps-admin/add/testimonial');
              }
              else
              {
                  $this->session->set_flashdata('msg',"Something error!");
                    redirect('wps-admin/add/testimonial');
              }
          }
          else
          {
              $this->session->set_flashdata('msg',validation_errors());
              redirect('wps-admin/add/testimonial');
          }
      }
  
    public function delete_testimonial($id)
    {
        $where=array('testimonial_id'=>$id);
        $tb='wps_testimonial';
        
        if($this->Admin_common_model->delete_where($tb,$where)) 
              {
                    $this->session->set_flashdata('msg',"Successfully Added");
                    redirect('wps-admin/testimonial');
              }
              else
              {
                  $this->session->set_flashdata('msg',"Something error!");
                    redirect('wps-admin/testimonial');
              }
    }
  
  
}