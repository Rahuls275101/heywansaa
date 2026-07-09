<?php

class Meta extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('meta_model'));
    $this->load->helper(array('custom_form'));
  }

  public  function index($page = NULL){
         $res_array = $this->db->query("SELECT * FROM wps_meta_tags ORDER BY meta_id DESC")->result_array();
         $data['headingTitle'] = 'Manage Meta Tags';
         $data['res']      = $res_array;
         $this->load->view('metatag/meta_list_view',$data);        
     }

  

    public function edit(){
        $data['headingTitle'] = 'Edit Meta Tag';			
         $Id        = (int) $this->uri->segment(4);	
         
         $condtion  = "meta_id ='$Id' ";	
         $res       =   $this->meta_model->get_meta(0,1,$condtion);	
         $res       = $res[0];
        
        if( is_array($res) && !empty($res)){ 
          if(!empty($_POST)){
             $_POST['page_url'] = str_replace(base_url(),"",$this->input->post('page_url'));
          }
         $this->form_validation->set_rules('meta_title','Title','trim|required|max_length[220]');
         $this->form_validation->set_rules('meta_keyword','Keyword','trim|required|max_length[500]');
         $this->form_validation->set_rules('meta_description','Description','trim|required|max_length[500]');
                 if($this->form_validation->run()==TRUE){
                     $page_url = $this->input->post('page_url');
                     $posted_data = array(
                     'meta_title' =>$this->input->post('meta_title',TRUE),
                     'meta_keyword' =>$this->input->post('meta_keyword',TRUE),
                     'meta_description' =>$this->input->post('meta_description',TRUE)
                     );
                     $where = "meta_id = '".$res['meta_id']."'"; 						
                     $this->meta_model->safe_update('wps_meta_tags',$posted_data,$where,FALSE);	
                     $this->session->set_userdata('msg_type',"success" ); 
                     $this->session->set_flashdata('success','Meta tag has been updated successfully!' ); 
                     redirect('wps-admin/meta/'.query_string(), ''); 	
                 }
                 $data['res']=$res;
                 $this->load->view('metatag/meta_edit_view',$data);
        }else{
           redirect('wps-admin/meta', ''); 	 
        }
    }

    

    

}

// End of controller