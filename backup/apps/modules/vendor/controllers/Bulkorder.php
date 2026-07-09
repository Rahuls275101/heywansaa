<?php

class Bulkorder extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    // $this->load->model(array('order/order_model', 'products/product_model'));
    // $this->load->helper(array('cart/cart', 'file', 'category/category'));
    $this->load->model('bulkmodel');
    $this->load->library(array('Dmailer'));
  }
  
  
  public function index()
  {
      echo 1;
  }
  
  public function view_bulk_order()
  {
      $query="select wps_bulk_buy.*, wps_products.product_name, wps_products.friendly_url, wps_products.product_code, wps_products.product_qty, wps_products.specification, wps_products.delivery_time, wps_products.packaging_details, wps_products.product_price from wps_bulk_buy inner join wps_products on wps_bulk_buy.product_id=wps_products.products_id where wps_bulk_buy.status=1";
      $r['data']=$this->bulkmodel->get_raw_query($query);
      $r['headingTitle']="View Bulk Order";
      $r['status']="New Orders";
      $this->load->view('bulk/bulk_order',$r);
  }
  
  public function old_bulk_order()
  {
      $query="select wps_bulk_buy.*, wps_products.product_name, wps_products.friendly_url, wps_products.product_code, wps_products.product_qty, wps_products.specification, wps_products.delivery_time, wps_products.packaging_details, wps_products.product_price from wps_bulk_buy inner join wps_products on wps_bulk_buy.product_id=wps_products.products_id where wps_bulk_buy.status=2";
      $r['data']=$this->bulkmodel->get_raw_query($query);
      $r['headingTitle']="Old Bulk Order";
      
      $this->load->view('bulk/bulk_order',$r);
  }
  
  public function action_update_bulk_status()
  {

        $this->form_validation->set_rules('remark_admin','Admin Remark','required|trim');
        $this->form_validation->set_rules('status','Status','required|trim');
        
        if($this->form_validation->run())
        {
            $data=array('status'=>$this->input->post('status'),'admin_remark'=>$this->input->post('remark_admin'));
            $where=array('id'=>$this->input->post('id'));
            $tb="wps_bulk_buy";
            if($this->bulkmodel->update_where($tb,$data,$where))
            {
                    // $this->session->set_userdata(array('msg_type' => 'success'));
                    $this->session->set_flashdata('msg', 'Updated Successfully');
                    redirect('wps-vendor/bulk/new_bulk_order');
            }
            else
            {
                    // $this->session->set_userdata(array('msg_type' => 'error'));
                    $this->session->set_flashdata('msg', 'Something Error!');
                    redirect('wps-vendor/bulk/new_bulk_order');
            }
        }
        else
        {
             $this->session->set_flashdata('msg', validation_errors());
             redirect('wps-vendor/bulk/new_bulk_order');
        }
  }















}



