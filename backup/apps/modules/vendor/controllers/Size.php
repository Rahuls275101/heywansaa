<?php

class Size extends Admin_Controller

{

	public function __construct()

	{		

		parent::__construct(); 				

		$this->load->model(array('size_model'));			

	}

	 

	public  function index()

	{

		

		

		 $pagesize               =  (int) $this->input->get_post('pagesize');

	     $config['limit']		 =  ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');		 		 				

		 $offset                 =  ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;		

		 $base_url               =  current_url_query_string(array('filter'=>'result'),array('per_page'));				 

		 $parent_id              =   (int) $this->uri->segment(4,0);			

	     

		 $keyword = trim($this->input->get_post('keyword',TRUE));		

		 $keyword = $this->db->escape_str($keyword);

	     $condtion = " ";

		 

		

									

		$condtion_array = array(

		                'field' =>"*",

						 'condition'=>$condtion,

						 'limit'=>$config['limit'],

						  'offset'=>$offset	,

						  'debug'=>FALSE

						 );							 						 	

		$res_array              =  $this->size_model->getsizes($condtion_array);

						

		$config['total_rows']	=  $this->size_model->total_rec_found;	

		

		$data['page_links']     =  dashboard_pagination($base_url,$config['total_rows'],$config['limit'],$offset);

				

		$data['headingTitle']  =  'Size';

						

		$data['res']            =  $res_array; 	

		

		$data['parent_id']      =  $parent_id; 	

		

		

		if( $this->input->post('action')!='')

		{			

			$this->update_status('wps_sizes','size_id');			

		}

		if( $this->input->post('update_order')!='')

		{			

			$this->update_displayOrder('wps_sizes','sort_order','size_id');			

		}

						

		$this->load->view('size/view_size_list',$data);		

		

		

	}	

	

	public function add()

	{

		 $data['headingTitle'] = 'Add Size';

		

		

		

		 $this->form_validation->set_rules('size_name','Title',"trim|required|max_length[32]|unique[wps_sizes.size_name='".$this->db->escape_str($this->input->post('size_name'))."' AND status!='2']");

		

		 

		if($this->form_validation->run()===TRUE)

		{

			    $posted_data = array(

					'size_name'=>$this->input->post('size_name'),

					'size_date_added'=>$this->config->item('config.date.time')

				 );

								

		    $this->size_model->safe_insert('wps_sizes',$posted_data,FALSE);	

								

			$this->session->set_userdata(array('msg_type'=>'success'));			

			$this->session->set_flashdata('success',lang('success'));				

			redirect('wps-admin/size', '');		

					

		}	

		$this->load->view('size/view_size_add',$data);		  

		  

	}

	

	

	public function edit()

	{

		$sizeId = (int) $this->uri->segment(4);

		

		$rowdata=$this->size_model->get_size_by_id($sizeId);

				

		

		

		$data['headingTitle'] = 'Size';

		

		if( !is_array($rowdata) )

		{

			$this->session->set_flashdata('message', lang('idmissing'));	

			redirect('wps-admin/size', ''); 	

			

		}



		$sizeId = $rowdata['size_id'];

		

			$this->form_validation->set_rules('size_name','Title',"trim|required|max_length[32]|unique[wps_sizes.size_name='".$this->db->escape_str($this->input->post('size_name'))."' AND status!='2' AND size_id!='".$sizeId."']");

			 		

			

			if($this->form_validation->run()==TRUE)

			{	

				$posted_data = array(

					'size_name'=>$this->input->post('size_name'),

					'size_date_updated'=>$this->config->item('config.date.time')

				 );

				 

			 	$where = "size_id = '".$sizeId."'"; 				

				$this->size_model->safe_update('wps_sizes',$posted_data,$where,FALSE);	

							

				$this->session->set_userdata(array('msg_type'=>'success'));				

				$this->session->set_flashdata('success',lang('successupdate'));								

				

				redirect('wps-admin/size'.'/'.query_string(), ''); 	

							

			}						

			

		$data['edit_result']=$rowdata;		

		$this->load->view('size/view_size_edit',$data);				

		

	}

	

	

}

// End of controller