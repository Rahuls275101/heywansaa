<?php

class Variant extends Admin_Controller{


 public function __construct() 
 {
    parent::__construct();
    $this->load->model(array('products/product_model', 'color_model', 'size_model','model_variant'));
    $this->load->helper('category/category');
    // $this->config->set_item('menu_highlight', 'product management');
    	$this->session->set_flashdata('msg','');
  } 




  
  public function index($productId)
  {

  	$d['size']=$this->model_variant->get_master('wps_sizes');
  	$d['color']=$this->model_variant->get_master('wps_colors');
  	$d['headingTitle']="Variant Manager";

  	$option = array('productid' => $productId);
    $d['product_details'] = $this->product_model->get_products(1, 0, $option);
    $vendor_id= $this->session->userdata('admin_id'); 
    $d['data']=$this->model_variant->get_variant_list_by_product($productId,$vendor_id);

  	 $this->load->view('variant/view_variant_list',$d);
  }

  public function create_variant_by_product_id()
  {
    //   print_r($this->input->post());die;
    
      
  	$this->form_validation->set_rules('cow_b','Product','trim|required');
  	$this->form_validation->set_rules('size','Size','trim|required');
  	$this->form_validation->set_rules('color','Color','trim|required');
  	$this->form_validation->set_rules('price','Price','trim|required');
  	$this->form_validation->set_rules('qty','Quantity','trim|required');

  	if($this->form_validation->run())
  	{
      $admin_id= $this->session->userdata('admin_id');  
  		$var_data=array(
					'product_id'	=>	$this->input->post('cow_b'),
					'size_id'			=>	$this->input->post('size'),
					'color_id'			=>	$this->input->post('color'),
					'discounted_price'			=>	$this->input->post('price'),
                    'product_price'      =>  $this->input->post('price'),
                    'vendor_id'     => $admin_id,
                    'quantity'      =>  $this->input->post('qty'),
					);
  		 
  		  $product_id= $this->input->post('cow_b');
  	
  		  
  		  $where = array('products_id' => $product_id,'vendor_id'=>$admin_id);
      	  $check_of_product_by_admin=$this->model_variant->get_where('wps_products',$where);
    		if($check_of_product_by_admin)
    		{
    			if($this->model_variant->add_master('product_variant',$var_data))
    			{
    				$this->session->set_flashdata('msg','<div class="alert alert-success">Added Successfully</div>');
    				redirect("wps-vendor/variant/".$product_id);
    			}
    			else
    			{
    				$this->session->set_flashdata('msg','<div class="alert alert-success">Not Added!! </div>');
    				redirect("wps-vendor/variant/".$product_id);
    			}
    		}
    		else
    		{
    			$this->session->set_flashdata('msg','<div class="alert alert-danger">'.$this->db->error().'</div>');
    				redirect("wps-vendor/variant/".$product_id);
    		}	
  	}
  	else
  	{
  	   
  		$this->session->set_flashdata('msg','<div class="alert alert-danger">'.validation_errors().'</div>');
    	redirect("wps-vendor/variant/".$product_id);
  	}
  }







    











        // 
        //        ************************      Image By Variant     *****************
        //















  public function manage_image_by_variant($variant_id)
  {
    //   variant-image folder name      
      $where=array('variant_id'=>$variant_id);
      $d['data']=$this->model_variant->get_where('image_by_variant',$where);
  	  $this->load->view('variant/view_variant_image_list',$d);
  }

    
    public function image_upload_by_variant_action()
    {
        // Array ( [cow_b] => 14 [image] => Array ( [name] => 51A1bZtQV0L._UX679_.jpg [type] => image/jpeg [tmp_name] => /tmp/phpk4L3rb [error] => 0 [size] => 27134 ) )
        
        $this->form_validation->set_rules('cow_b','Image','required');
        // $this->form_validation->set_rules('image','Name','required|trim');
        if($this->form_validation->run())
        {
            $var_id =$this->input->post('cow_b');
            // $name   =$this->input->post('cow_b');
            
            if(isset($var_id))
            {
                // echo "1";die;
                $config['upload_path']          = UPLOAD_DIR.'/variant-image/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 100000;
                $config['encrypt_name']         = true;
                
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('image'))
                {
                    $this->session->set_flashdata('msg','Not  Added!');
                    redirect('wps-vendor/manage/image/variant-wise/'.$var_id);
                }
                else
                {
                    $uploaded_data = array('upload_data' => $this->upload->data());
                    $uploaded_file = $uploaded_data['upload_data']['file_name'];
                    
                    $data=array('image'=>$uploaded_file,'variant_id'=>$var_id,'created_at'=>date('Y-m-d H:i:s'));
                    if($this->model_variant->add_master('image_by_variant',$data))
                    {
                        $this->session->set_flashdata('msg','Successfully image Added');
                        redirect('wps-vendor/manage/image/variant-wise/'.$var_id);
                    }
                    else
                    {
                        $this->session->set_flashdata('msg','Not  Added!');
                        redirect('wps-vendor/manage/image/variant-wise/'.$var_id);
                    }
                }
                
            }
            else
            {
                $this->session->set_flashdata('msg','Not  Added!!');
                redirect('wps-vendor/manage/image/variant-wise/'.$var_id);
            }
        }
        else
        {
            $this->session->set_flashdata('msg',validation_errors());
            redirect('wps-vendor/manage/image/variant-wise/'.$var_id);
        }
    }

    public function get_gallery_detail_page_by_color_code()
    {
        print_r($this->input->post('color'));die;
    }


























}

























?>