<?php

class Document extends Admin_Controller {

  public function __construct() 
  {
    parent::__construct();
    $this->load->model(array('Document_model'));
  }

  public function index() 
  {
      $where=array('vendor_id'=>$this->session->userdata()['admin_id']);
      $r['res']=$this->Document_model->get_where('vendor_document',$where);
      $r['headingTitle']="Document List";
      $this->load->view('document/document_list',$r);
  }
  
  public function new_add()
  { 
      
                $config['upload_path']          = './uploaded-files/vendor-doc';
                $config['allowed_types']        = 'gif|jpg|png|pdf|doc|docx|xlsx|jpeg';
                $config['max_size']             = 60000;
                $config['encrypt_name']         = true;
                $doc_name='';
                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('document'))
                {
                        $this->session->set_flashdata('msg',$this->upload->display_errors());
                        redirect('wps-vendor/vendor/documents');
                }
                else
                {
                    $doc_name= $this->upload->data()['file_name'];
                }
      $data=array(
                    'document_title'=>$this->input->post('title'),
                    'document_image'=>$doc_name,
                    'vendor_id'=>$this->session->userdata()['admin_id'],
                    'remark'=>$this->input->post('remark'),
                    'created_at'=>date('Y-m-d h:i:s'),
                    'updated_at'=>date('Y-m-d h:i:s'),
                );
        if($this->Document_model->add_master('vendor_document',$data))
        {
           $this->session->set_flashdata('msg','Successfully added!');
            redirect('wps-vendor/vendor/documents'); 
        }
        else
        {
            $this->session->set_flashdata('msg',"Something Error!!");
            redirect('wps-vendor/vendor/documents');
        }
  }
    
    // vendor/document/delete_document/$1
    public function  delete_document($vid)
    {
       $where=array('id'=>$vid); 
       if($this->Document_model->delete_where('vendor_document',$where))
       {
           $this->session->set_flashdata('msg','Successfully Deleted!');
            redirect('wps-vendor/vendor/documents'); 
       }
       else
       {
            $this->session->set_flashdata('msg',"Something Error!!");
            redirect('wps-vendor/vendor/documents');
       }
    }
  
  
  
}



    