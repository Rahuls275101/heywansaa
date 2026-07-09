 <?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Top_ten_link extends CI_Controller {

  public function __construct() 
  {
    parent::__construct();
    $this->load->model(array('admin/model_top_ten_link'));
    $this->form_validation->set_error_delimiters("<div style='color:#FC0000; margin-bottom:5px;'>", "</div>");
  }

  public function index()
  {
  	  $d['data']=$this->model_top_ten_link->get_master('top_ten_link');
  		$this->load->view('top-ten-link/top-ten-link',$d);
  }
  public function add_new_top_ten()
  {
  	 	$uploaded_file = "";
      	if (!empty($_FILES) && $_FILES['image']['name'] != '') 
      	{
	        $this->load->library('upload');
	        $config1['upload_path'] = UPLOAD_DIR . '/topten/';
	        $config1['allowed_types'] = 'gif|jpg|png|jpeg';
	        $config1['encrypt_name']=true;
	        $this->upload->initialize($config1);
	        $uploaded_data = $this->upload->do_upload('image');
	        if (is_array($uploaded_data) && !empty($uploaded_data)) {
	          $uploaded_file = $uploaded_data['upload_data']['file_name'];
	        }
	      }

	      $data=array(
	      				'title'		=>$this->input->post('title'),
	      				'image'		=>$uploaded_file,
	      				'link'		=>$this->input->post('link'),
	      				'updated_at'=>$this->config->item('config.date.time'),
	      				'created_at'=>$this->config->item('config.date.time'),
	      			);

	     if($this->model_top_ten_link->add_master('top_ten_link',$data))
	     {
			$this->session->set_userdata('msg','Successfully Added');	
			redirect('admin/top_ten_link');
	     }
	     else
	     {
			$this->session->set_userdata('msg','Not Added');	   
			redirect('admin/top_ten_link');  		
	     }
  }

}