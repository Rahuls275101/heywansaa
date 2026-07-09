<?php

class Bulkorder_old extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    // $this->load->model(array('order/order_model', 'products/product_model'));
    // $this->load->helper(array('cart/cart', 'file', 'category/category'));
    $this->load->model('bulkmodel');
    $this->load->library(array('Dmailer'));
  }
  
 public function index()
  {
      $query="select * from wps_bulk_buy  where wps_bulk_buy.status=2";
      $r['data']=$this->bulkmodel->get_raw_query($query);
      $r['headingTitle']="Old Bulk Order";
      $r['status']="Old Orders";
      $this->load->view('bulk/bulk_order_old',$r);
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
                    redirect('wps-admin/bulkorder_old');
            }
            else
            {
                    // $this->session->set_userdata(array('msg_type' => 'error'));
                    $this->session->set_flashdata('msg', 'Something Error!');
                    redirect('wps-admin/bulkorder_old');
            }
        }
        else
        {
             $this->session->set_flashdata('msg', $this->validation_errors());
                    redirect('wps-admin/bulkorder_old');
        }
  }





  
}