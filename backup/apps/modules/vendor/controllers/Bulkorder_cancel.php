<?php
class Bulkorder_cancel extends Admin_Controller
{
    
  public function __construct() {
    parent::__construct();
    $this->load->model('bulkmodel');
    $this->load->library(array('Dmailer'));
  }
  
 public function index()
  {
      $query="select wps_bulk_buy.*, wps_products.product_name, wps_products.friendly_url, wps_products.product_code, wps_products.product_qty, wps_products.specification, wps_products.delivery_time, wps_products.packaging_details, wps_products.product_price from wps_bulk_buy inner join wps_products on wps_bulk_buy.product_id=wps_products.products_id where wps_bulk_buy.status=4";
      $r['data']=$this->bulkmodel->get_raw_query($query);
      $r['headingTitle']="Canceled Bulk Order";
       $r['status']="Canceled";
      $this->load->view('bulk/bulk_order_cancel',$r);
    
  }
  
  public function action_update_bulk_status()
  {
    //   print_r($this->input->post());
        $this->form_validation->set_rules('remark_admin','Admin Remark','required|trim');
        $this->form_validation->set_rules('status','Admin Remark','required|trim');
        
        if($this->form_validation->run())
        {
            $data=array('status'=>$this->input->post('status'),'admin_remark'=>$this->input->post('remark_admin'));
            $where=array('id'=>$this->input->post('id'));
            $tb="wps_bulk_buy";
            if($this->bulkmodel->update_where($tb,$data,$where))
            {
                    // $this->session->set_userdata(array('msg_type' => 'success'));
                    $this->session->set_flashdata('msg', 'Updated Successfully');
                    redirect('wps-vendor/bulkorder_dispatch');
            }
            else
            {
                    // $this->session->set_userdata(array('msg_type' => 'error'));
                    $this->session->set_flashdata('msg', 'Something Error!');
                    redirect('wps-vendor/bulkorder_dispatch');
            }
        }
        else
        {
             $this->session->set_flashdata('msg', $this->validation_errors());
                    redirect('wps-vendor/bulkorder_dispatch');
        }
  }





  
}






