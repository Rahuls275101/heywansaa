<?php
class Brand extends Admin_Controller
{
	public function __construct()
	{		
		parent::__construct(); 				
		$this->load->model(array('brand_model'));			
	}
	public  function index()
	{
	     $data['headingTitle'] = 'Brand List';
		$res_array =  $this->brand_model->get_master('product_brands');
	    $data['res_array']=$res_array;
		$this->load->view('brand/view_brand_list',$data);
	}	

// 	delete_brand

	public function add_brand()
	{
	
		$this->form_validation->set_rules('brand_name','Brand Name',"trim|required");
		if($this->form_validation->run()===TRUE)
		{
		    $image_name='';
		    
		        $config['upload_path'] = './uploaded-files/brand';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['encrypt_name'] =   true;
    		    $this->load->library('upload', $config);
               
               if($this->upload->do_upload('image_logo')==true)
               {
                $image_name =$this->upload->data()['file_name'];
               }
		
		  
		    
		    
		    $posted_data = array(
			'image_logo'=>$image_name,
			'brand_name'=>$this->input->post('brand_name'),
			 );
			 
		    if($this->brand_model->add_master('product_brands',$posted_data))
		    {
		        $this->session->set_flashdata('msg','Successfully Logo Added!');			
			    redirect('wps-admin/brand', '');
		    }
		    else
		    {
		        echo $this->db->last_query();die;
		        $this->session->set_flashdata('msg',$this->db->last_query());			
		    	redirect('wps-admin/brand', '');
		    }
					
		}
		else
		{
		    $this->session->set_flashdata('msg',validation_errors());			
			redirect('wps-admin/brand', '');
		}
 

	}

	
	
	public function delete_brand($id)
	{
        $where=array('id'=>$id);
        if($this->brand_model->delete_where('product_brands',$where))
	    {
	        $this->session->set_flashdata('msg','Successfully Logo Deleted!');			
		    redirect('wps-admin/brand', '');
	    }
	    else
	    {
	        echo $this->db->last_query();die;
	        $this->session->set_flashdata('msg',$this->db->last_query());			
	    	redirect('wps-admin/brand', '');
	    }
	}

	


	

	

}

// End of controller