<?php

class Orders extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('order/order_model', 'products/product_model','vendor_model','Order_vendor_model'));
    $this->load->helper(array('cart/cart', 'file', 'category/category'));
    $this->load->library(array('Dmailer'));
    $this->load->library("pagination");
    
    if($this->session->userdata('admin_type')!=2)
    {
        $this->session->unset_userdata('vendor_id');
        $this->session->unset_userdata('admin_id');
        redirect(base_url().'admin');
    }
  }

  public function index($page = 0) 
  {
      /* Order oprations  */
    if ($this->input->post('unset_as') != '') {
      $this->set_as('wps_order', 'order_id', array('payment_status' => 'Unpaid'));
    }
    // if ($this->input->post('ord_status') != '') {
    //  $posted_order_status = $this->input->post('ord_status');
    //  $this->set_as('wps_order', 'order_id', array('order_status' => $posted_order_status));
    //  } 

    if ($this->input->post('ord_status') != '') 
    {
      $posted_order_status = $this->input->post('ord_status');
      switch ($posted_order_status) {
        case '8': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '8', 'order_delivery_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '7': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '6', 'order_returned_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '1': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '1', 'order_confirmed_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '2': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '2', 'order_dispatched_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '3': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '3', 'order_in_transit_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '4': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '4', 'order_out_for_delivery_date' => date("Y-m-d H:i:s")));
            break;
          }

        case '5': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '5', 'order_cancelled_date' => date("Y-m-d H:i:s")));
            break;
          } default: break;
      }
    }
      $status_array = [
        '1' => ['status_title' => 'Confirmed', 'status_date' => 'order_confirmed_date', 'date_title' => 'Order Confirmed On'],
        '0' => ['status_title' => 'Placed', 'status_date' => 'order_received_date', 'date_title' => 'Order Received On'],
        '2' => ['status_title' => 'Dispatched', 'status_date' => 'order_dispatched_date', 'date_title' => 'Order Dispatched On'],
        '3' => ['status_title' => 'In Transit', 'status_date' => 'order_in_transit_date', 'date_title' => 'In Transit Date'],
        '4' => ['status_title' => 'Out for delivery', 'status_date' => 'order_out_for_delivery_date', 'date_title' => 'Order Out For Delivery On'],
        '5' => ['status_title' => 'Cancelled', 'status_date' => 'order_cancelled_date', 'date_title' => 'Order Cancelled On'],
        '6' => ['status_title' => 'Returned', 'status_date' => 'order_returned_date', 'date_title' => 'Order Returned On'],
        '7' => ['status_title' => 'Requested For Return', 'status_date' => 'order_request_for_return_date', 'date_title' => 'Order Requested For Return On'],
        '8' => ['status_title' => 'Delivered', 'status_date' => 'order_delivery_date', 'date_title' => 'Order Delivered On'],
    ];

    $data['status_array'] = $status_array;
 if ($this->input->post('Delete') != '') {
      $posted_order_status = $this->input->post('ord_status');
      $this->set_as('wps_order', 'order_id', array('order_status' => '9'));
      //$this->set_as('wps_order', 'order_id', array('order_status' => 'Deleted'));
    }
   
       $vendor_id=$this->session->userdata('admin_id');
       
         
       
       $config = array();
       $config["base_url"] = base_url() . "wps-vendor/orders/index/0";
       $config["total_rows"] = $this->Order_vendor_model->get_count_order_by_vendor($vendor_id);
       $config["per_page"] = 30;
       $config["uri_segment"] = 5;
       
       
       
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        // $config['next_tag_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']  = '</span></li>';
           
       
       
       $this->pagination->initialize($config);
       $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
       $data["results"] = $this->Order_vendor_model->get_order_by_vendor($config["per_page"], $page,  $vendor_id);
        // print_r($this->db->last_query() );die;
       $data["links"] = $this->pagination->create_links();
     $data['headingTitle'] = 'All Order Lists';
    //   print_r($data["results"] );die;
    $this->load->view('order/view_order_list', $data);
  }

  public function vieworder() {
      
     $vendor_id=$this->session->userdata('admin_id');
      
    $id = (int) $this->uri->segment(4);
    $ordmaster = $this->db->query("SELECT * FROM wps_order WHERE order_id = '" . $id . "'")->row_array();
    $ordDetails = $this->db->query("SELECT * FROM wps_orders_products WHERE order_id = '" . $id . "' and vendor_id='$vendor_id'")->result_array();

    $data['ordmaster'] = $ordmaster;
    $data['ordDetails'] = $ordDetails;

    $data['headingTitle'] = 'Order Details - Order# ' . $ordmaster['invoice_number'];
    $this->load->view('order/view_order_details', $data);
  }

  public function make_paid($order_id) {

    $order_id = (int) $order_id;
    $where = "order_id = '" . $order_id . "'";
    $this->order_model->safe_update('wps_order', array('payment_status' => 'Paid'), $where, FALSE);
    $this->update_stocks($order_id);

    $ordmaster = $this->vendor_model->get_order_master($order_id);
    $orddetail = $this->vendor_model->get_order_detail($order_id);

    /* Start  send mail */

    ob_start();
    $mail_subject = $this->config->item('site_name') . " Order overview";
    $from_email = $this->admin_info->admin_email;
    $from_name = $this->config->item('site_name');
    $mail_to = $ordmaster['email'];

    $body = invoice_content_print($ordmaster, $orddetail);
    $msg = ob_get_contents();

    $mail_conf = array(
        'subject' => $this->config->item('site_name') . " Order overview",
        'to_email' => $mail_to,
        'from_email' => $from_email,
        'from_name' => $this->config->item('site_name'),
        'body_part' => $msg);				
    //$this->dmailer->mail_notify($mail_conf);
    /* End  send mail */

    $this->session->set_userdata(array('msg_type' => 'success'));
    $this->session->set_flashdata('success', $this->config->item('payment_success'));
    redirect('wps-vendor/orders', '');
  }
   //   get vendor id from session by raaz
    public function get_vendor_id()
    {
        return $this->session->userdata()['admin_id'];
    }
    
  public function pending_orders($page=0)
  {    
       /* Order oprations  */
    if ($this->input->post('unset_as') != '') {
      $this->set_as('wps_order', 'order_id', array('payment_status' => 'Unpaid'));
    }
    // if ($this->input->post('ord_status') != '') {
    //  $posted_order_status = $this->input->post('ord_status');
    //  $this->set_as('wps_order', 'order_id', array('order_status' => $posted_order_status));
    //  } 

    if ($this->input->post('ord_status') != '') 
    {
      $posted_order_status = $this->input->post('ord_status');
      switch ($posted_order_status) {
        case '8': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '8', 'order_delivery_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '7': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '6', 'order_returned_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '1': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '1', 'order_confirmed_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '2': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '2', 'order_dispatched_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '3': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '3', 'order_in_transit_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '4': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '4', 'order_out_for_delivery_date' => date("Y-m-d H:i:s")));
            break;
          }

        case '5': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '5', 'order_cancelled_date' => date("Y-m-d H:i:s")));
            break;
          } default: break;
      }
    }
      $status_array = [
        '1' => ['status_title' => 'Confirmed', 'status_date' => 'order_confirmed_date', 'date_title' => 'Order Confirmed On'],
        '0' => ['status_title' => 'Placed', 'status_date' => 'order_received_date', 'date_title' => 'Order Received On'],
        '2' => ['status_title' => 'Dispatched', 'status_date' => 'order_dispatched_date', 'date_title' => 'Order Dispatched On'],
        '3' => ['status_title' => 'In Transit', 'status_date' => 'order_in_transit_date', 'date_title' => 'In Transit Date'],
        '4' => ['status_title' => 'Out for delivery', 'status_date' => 'order_out_for_delivery_date', 'date_title' => 'Order Out For Delivery On'],
        '5' => ['status_title' => 'Cancelled', 'status_date' => 'order_cancelled_date', 'date_title' => 'Order Cancelled On'],
        '6' => ['status_title' => 'Returned', 'status_date' => 'order_returned_date', 'date_title' => 'Order Returned On'],
        '7' => ['status_title' => 'Requested For Return', 'status_date' => 'order_request_for_return_date', 'date_title' => 'Order Requested For Return On'],
        '8' => ['status_title' => 'Delivered', 'status_date' => 'order_delivery_date', 'date_title' => 'Order Delivered On'],
    ];

    $data['status_array'] = $status_array;
 if ($this->input->post('Delete') != '') {
      $posted_order_status = $this->input->post('ord_status');
      $this->set_as('wps_order', 'order_id', array('order_status' => '9'));
      //$this->set_as('wps_order', 'order_id', array('order_status' => 'Deleted'));
    }
   
       $vendor_id=$this->session->userdata('admin_id');
       
         
       
       $config = array();
       $config["base_url"] = base_url() . "wps-vendor/order/pending/0";
       $config["total_rows"] = $this->Order_vendor_model->get_count_pending_order_by_vendor($vendor_id);
       $config["per_page"] = 11;
       $config["uri_segment"] = 5;
       
       
       
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        // $config['next_tag_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']  = '</span></li>';
           
       
       
       $this->pagination->initialize($config);
       $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
       $data["res"] = $this->Order_vendor_model->get_pending_order_by_vendor($config["per_page"], $page,  $vendor_id);
        // print_r($this->db->last_query() );die;
       $data["links"] = $this->pagination->create_links();
        $data['headingTitle'] = 'Pending Order Lists';
       $this->load->view('order/pending_orders',$data);
  }
  public function dispatched_orders($page=0)
  {
          /* Order oprations  */
    if ($this->input->post('unset_as') != '') {
      $this->set_as('wps_order', 'order_id', array('payment_status' => 'Unpaid'));
    }
    // if ($this->input->post('ord_status') != '') {
    //  $posted_order_status = $this->input->post('ord_status');
    //  $this->set_as('wps_order', 'order_id', array('order_status' => $posted_order_status));
    //  } 

    if ($this->input->post('ord_status') != '') 
    {
      $posted_order_status = $this->input->post('ord_status');
      switch ($posted_order_status) {
        case '8': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '8', 'order_delivery_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '7': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '6', 'order_returned_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '1': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '1', 'order_confirmed_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '2': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '2', 'order_dispatched_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '3': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '3', 'order_in_transit_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '4': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '4', 'order_out_for_delivery_date' => date("Y-m-d H:i:s")));
            break;
          }

        case '5': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '5', 'order_cancelled_date' => date("Y-m-d H:i:s")));
            break;
          } default: break;
      }
    }
      $status_array = [
        '1' => ['status_title' => 'Confirmed', 'status_date' => 'order_confirmed_date', 'date_title' => 'Order Confirmed On'],
        '0' => ['status_title' => 'Placed', 'status_date' => 'order_received_date', 'date_title' => 'Order Received On'],
        '2' => ['status_title' => 'Dispatched', 'status_date' => 'order_dispatched_date', 'date_title' => 'Order Dispatched On'],
        '3' => ['status_title' => 'In Transit', 'status_date' => 'order_in_transit_date', 'date_title' => 'In Transit Date'],
        '4' => ['status_title' => 'Out for delivery', 'status_date' => 'order_out_for_delivery_date', 'date_title' => 'Order Out For Delivery On'],
        '5' => ['status_title' => 'Cancelled', 'status_date' => 'order_cancelled_date', 'date_title' => 'Order Cancelled On'],
        '6' => ['status_title' => 'Returned', 'status_date' => 'order_returned_date', 'date_title' => 'Order Returned On'],
        '7' => ['status_title' => 'Requested For Return', 'status_date' => 'order_request_for_return_date', 'date_title' => 'Order Requested For Return On'],
        '8' => ['status_title' => 'Delivered', 'status_date' => 'order_delivery_date', 'date_title' => 'Order Delivered On'],
    ];

    $data['status_array'] = $status_array;
 if ($this->input->post('Delete') != '') {
      $posted_order_status = $this->input->post('ord_status');
      $this->set_as('wps_order', 'order_id', array('order_status' => '9'));
      //$this->set_as('wps_order', 'order_id', array('order_status' => 'Deleted'));
    }
   
       $vendor_id=$this->session->userdata('admin_id');
       
         
       
       $config = array();
       $config["base_url"] = base_url() . "wps-vendor/order/dispatched/0";
       $config["total_rows"] = $this->Order_vendor_model->get_count_dispatch_order_by_vendor($vendor_id);
       $config["per_page"] = 1;
       $config["uri_segment"] = 5;
       
       
       
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        // $config['next_tag_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']  = '</span></li>';
           
       
       
       $this->pagination->initialize($config);
       $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
       $data["res"] = $this->Order_vendor_model->get_dispatch_order_by_vendor($config["per_page"], $page,  $vendor_id);
        // print_r($this->db->last_query() );die;
       $data["links"] = $this->pagination->create_links();
        $data['headingTitle'] = 'Dispatched Order Lists';
        $this->load->view('order/dispatched_orders',$data);
  }
  public function cancel_orders($page=0)
  {
          /* Order oprations  */
    if ($this->input->post('unset_as') != '') {
      $this->set_as('wps_order', 'order_id', array('payment_status' => 'Unpaid'));
    }
    // if ($this->input->post('ord_status') != '') {
    //  $posted_order_status = $this->input->post('ord_status');
    //  $this->set_as('wps_order', 'order_id', array('order_status' => $posted_order_status));
    //  } 

    if ($this->input->post('ord_status') != '') 
    {
      $posted_order_status = $this->input->post('ord_status');
      switch ($posted_order_status) {
        case '8': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '8', 'order_delivery_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '7': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '6', 'order_returned_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '1': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '1', 'order_confirmed_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '2': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '2', 'order_dispatched_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '3': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '3', 'order_in_transit_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '4': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '4', 'order_out_for_delivery_date' => date("Y-m-d H:i:s")));
            break;
          }

        case '5': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '5', 'order_cancelled_date' => date("Y-m-d H:i:s")));
            break;
          } default: break;
      }
    }
      $status_array = [
        '1' => ['status_title' => 'Confirmed', 'status_date' => 'order_confirmed_date', 'date_title' => 'Order Confirmed On'],
        '0' => ['status_title' => 'Placed', 'status_date' => 'order_received_date', 'date_title' => 'Order Received On'],
        '2' => ['status_title' => 'Dispatched', 'status_date' => 'order_dispatched_date', 'date_title' => 'Order Dispatched On'],
        '3' => ['status_title' => 'In Transit', 'status_date' => 'order_in_transit_date', 'date_title' => 'In Transit Date'],
        '4' => ['status_title' => 'Out for delivery', 'status_date' => 'order_out_for_delivery_date', 'date_title' => 'Order Out For Delivery On'],
        '5' => ['status_title' => 'Cancelled', 'status_date' => 'order_cancelled_date', 'date_title' => 'Order Cancelled On'],
        '6' => ['status_title' => 'Returned', 'status_date' => 'order_returned_date', 'date_title' => 'Order Returned On'],
        '7' => ['status_title' => 'Requested For Return', 'status_date' => 'order_request_for_return_date', 'date_title' => 'Order Requested For Return On'],
        '8' => ['status_title' => 'Delivered', 'status_date' => 'order_delivery_date', 'date_title' => 'Order Delivered On'],
    ];

    $data['status_array'] = $status_array;
 if ($this->input->post('Delete') != '') {
      $posted_order_status = $this->input->post('ord_status');
      $this->set_as('wps_order', 'order_id', array('order_status' => '9'));
      //$this->set_as('wps_order', 'order_id', array('order_status' => 'Deleted'));
    }
   
       $vendor_id=$this->session->userdata('admin_id');
       
         
       
       $config = array();
       $config["base_url"] = base_url() . "wps-vendor/order/cancel/0";
       $config["total_rows"] = $this->Order_vendor_model->get_count_cancel_order_by_vendor($vendor_id);
       $config["per_page"] = 2;
       $config["uri_segment"] = 5;
       
       
       
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        // $config['next_tag_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']  = '</span></li>';
           
       
       
       $this->pagination->initialize($config);
       $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
       $data["res"] = $this->Order_vendor_model->get_cancel_order_by_vendor($config["per_page"], $page,  $vendor_id);
        // print_r($this->db->last_query() );die;
       $data["links"] = $this->pagination->create_links();
        $data['headingTitle'] = 'Cancel Order Lists';
        $this->load->view('order/cancel_orders',$data);
  }
  
   public function delivered_orders($page=0)
  {
          /* Order oprations  */
    if ($this->input->post('unset_as') != '') {
      $this->set_as('wps_order', 'order_id', array('payment_status' => 'Unpaid'));
    }
    // if ($this->input->post('ord_status') != '') {
    //  $posted_order_status = $this->input->post('ord_status');
    //  $this->set_as('wps_order', 'order_id', array('order_status' => $posted_order_status));
    //  } 

    if ($this->input->post('ord_status') != '') 
    {
      $posted_order_status = $this->input->post('ord_status');
      switch ($posted_order_status) {
        case '8': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '8', 'order_delivery_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '7': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '6', 'order_returned_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '1': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '1', 'order_confirmed_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '2': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '2', 'order_dispatched_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '3': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '3', 'order_in_transit_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '4': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '4', 'order_out_for_delivery_date' => date("Y-m-d H:i:s")));
            break;
          }

        case '5': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '5', 'order_cancelled_date' => date("Y-m-d H:i:s")));
            break;
          } default: break;
      }
    }
      $status_array = [
        '1' => ['status_title' => 'Confirmed', 'status_date' => 'order_confirmed_date', 'date_title' => 'Order Confirmed On'],
        '0' => ['status_title' => 'Placed', 'status_date' => 'order_received_date', 'date_title' => 'Order Received On'],
        '2' => ['status_title' => 'Dispatched', 'status_date' => 'order_dispatched_date', 'date_title' => 'Order Dispatched On'],
        '3' => ['status_title' => 'In Transit', 'status_date' => 'order_in_transit_date', 'date_title' => 'In Transit Date'],
        '4' => ['status_title' => 'Out for delivery', 'status_date' => 'order_out_for_delivery_date', 'date_title' => 'Order Out For Delivery On'],
        '5' => ['status_title' => 'Cancelled', 'status_date' => 'order_cancelled_date', 'date_title' => 'Order Cancelled On'],
        '6' => ['status_title' => 'Returned', 'status_date' => 'order_returned_date', 'date_title' => 'Order Returned On'],
        '7' => ['status_title' => 'Requested For Return', 'status_date' => 'order_request_for_return_date', 'date_title' => 'Order Requested For Return On'],
        '8' => ['status_title' => 'Delivered', 'status_date' => 'order_delivery_date', 'date_title' => 'Order Delivered On'],
    ];

    $data['status_array'] = $status_array;
 if ($this->input->post('Delete') != '') {
      $posted_order_status = $this->input->post('ord_status');
      $this->set_as('wps_order', 'order_id', array('order_status' => '9'));
      //$this->set_as('wps_order', 'order_id', array('order_status' => 'Deleted'));
    }
   
       $vendor_id=$this->session->userdata('admin_id');
       
         
       
       $config = array();
       $config["base_url"] = base_url() . "wps-vendor/order/delivered/0";
       $config["total_rows"] = $this->Order_vendor_model->get_count_delivered_order_by_vendor($vendor_id);
       $config["per_page"] = 30;
       $config["uri_segment"] = 5;
       
       
       
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        // $config['next_tag_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']  = '</span></li>';
           
       
       
       $this->pagination->initialize($config);
       $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
       $data["res"] = $this->Order_vendor_model->get_delivered_order_by_vendor($config["per_page"], $page,  $vendor_id);
        // print_r($this->db->last_query() );die;
       $data["links"] = $this->pagination->create_links();
        $data['headingTitle'] = 'Delivered Order Lists';
        $this->load->view('order/delivered_orders',$data);
  }


 public function processing_orders($page=0)
  {
      
   
          /* Order oprations  */
    if ($this->input->post('unset_as') != '') {
      $this->set_as('wps_order', 'order_id', array('payment_status' => 'Unpaid'));
    }
    // if ($this->input->post('ord_status') != '') {
    //  $posted_order_status = $this->input->post('ord_status');
    //  $this->set_as('wps_order', 'order_id', array('order_status' => $posted_order_status));
    //  } 

    if ($this->input->post('ord_status') != '') 
    {
      $posted_order_status = $this->input->post('ord_status');
      switch ($posted_order_status) {
        case '8': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '8', 'order_delivery_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '7': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '6', 'order_returned_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '1': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '1', 'order_confirmed_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '2': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '2', 'order_dispatched_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '3': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '3', 'order_in_transit_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '4': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '4', 'order_out_for_delivery_date' => date("Y-m-d H:i:s")));
            break;
          }

        case '5': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '5', 'order_cancelled_date' => date("Y-m-d H:i:s")));
            break;
          } default: break;
      }
    }
      $status_array = [
        '1' => ['status_title' => 'Confirmed', 'status_date' => 'order_confirmed_date', 'date_title' => 'Order Confirmed On'],
        '0' => ['status_title' => 'Placed', 'status_date' => 'order_received_date', 'date_title' => 'Order Received On'],
        '2' => ['status_title' => 'Dispatched', 'status_date' => 'order_dispatched_date', 'date_title' => 'Order Dispatched On'],
        '3' => ['status_title' => 'In Transit', 'status_date' => 'order_in_transit_date', 'date_title' => 'In Transit Date'],
        '4' => ['status_title' => 'Out for delivery', 'status_date' => 'order_out_for_delivery_date', 'date_title' => 'Order Out For Delivery On'],
        '5' => ['status_title' => 'Cancelled', 'status_date' => 'order_cancelled_date', 'date_title' => 'Order Cancelled On'],
        '6' => ['status_title' => 'Returned', 'status_date' => 'order_returned_date', 'date_title' => 'Order Returned On'],
        '7' => ['status_title' => 'Requested For Return', 'status_date' => 'order_request_for_return_date', 'date_title' => 'Order Requested For Return On'],
        '8' => ['status_title' => 'Delivered', 'status_date' => 'order_delivery_date', 'date_title' => 'Order Delivered On'],
    ];

    $data['status_array'] = $status_array;
 if ($this->input->post('Delete') != '') {
      $posted_order_status = $this->input->post('ord_status');
      $this->set_as('wps_order', 'order_id', array('order_status' => '9'));
      //$this->set_as('wps_order', 'order_id', array('order_status' => 'Deleted'));
    }
   
       $vendor_id=$this->session->userdata('admin_id');
       
         
       
       $config = array();
       $config["base_url"] = base_url() . "wps-vendor/order/processing/0";
       $config["total_rows"] = $this->Order_vendor_model->get_count_processing_order_by_vendor($vendor_id);
       $config["per_page"] = 1;
       $config["uri_segment"] = 5;
       
       
       
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        // $config['next_tag_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']  = '</span></li>';
           
       
       
       $this->pagination->initialize($config);
       $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
       $data["res"] = $this->Order_vendor_model->get_processing_order_by_vendor($config["per_page"], $page,  $vendor_id);
        // print_r($this->db->last_query() );die;
       $data["links"] = $this->pagination->create_links();
       $data['headingTitle'] = 'Processing Orders Lists';
       $this->load->view('order/processing_orders',$data);
  }
    //end of processing orders   
  
  public function filterorderhistorybydate()
  {
        if ($this->input->post('unset_as') != '') {
      $this->set_as('wps_order', 'order_id', array('payment_status' => 'Unpaid'));
    }
    // if ($this->input->post('ord_status') != '') {
    //  $posted_order_status = $this->input->post('ord_status');
    //  $this->set_as('wps_order', 'order_id', array('order_status' => $posted_order_status));
    //  } 

    if ($this->input->post('ord_status') != '') 
    {
      $posted_order_status = $this->input->post('ord_status');
      switch ($posted_order_status) {
        case '8': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '8', 'order_delivery_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '7': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '6', 'order_returned_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '1': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '1', 'order_confirmed_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '2': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '2', 'order_dispatched_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '3': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '3', 'order_in_transit_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '4': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '4', 'order_out_for_delivery_date' => date("Y-m-d H:i:s")));
            break;
          }

        case '5': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '5', 'order_cancelled_date' => date("Y-m-d H:i:s")));
            break;
          } default: break;
      }
    }
      $status_array = [
        '1' => ['status_title' => 'Confirmed', 'status_date' => 'order_confirmed_date', 'date_title' => 'Order Confirmed On'],
        '0' => ['status_title' => 'Placed', 'status_date' => 'order_received_date', 'date_title' => 'Order Received On'],
        '2' => ['status_title' => 'Dispatched', 'status_date' => 'order_dispatched_date', 'date_title' => 'Order Dispatched On'],
        '3' => ['status_title' => 'In Transit', 'status_date' => 'order_in_transit_date', 'date_title' => 'In Transit Date'],
        '4' => ['status_title' => 'Out for delivery', 'status_date' => 'order_out_for_delivery_date', 'date_title' => 'Order Out For Delivery On'],
        '5' => ['status_title' => 'Cancelled', 'status_date' => 'order_cancelled_date', 'date_title' => 'Order Cancelled On'],
        '6' => ['status_title' => 'Returned', 'status_date' => 'order_returned_date', 'date_title' => 'Order Returned On'],
        '7' => ['status_title' => 'Requested For Return', 'status_date' => 'order_request_for_return_date', 'date_title' => 'Order Requested For Return On'],
        '8' => ['status_title' => 'Delivered', 'status_date' => 'order_delivery_date', 'date_title' => 'Order Delivered On'],
    ];

    $data['status_array'] = $status_array;
 if ($this->input->post('Delete') != '') {
      $posted_order_status = $this->input->post('ord_status');
      $this->set_as('wps_order', 'order_id', array('order_status' => '9'));
      //$this->set_as('wps_order', 'order_id', array('order_status' => 'Deleted'));
    }
   
       $vendor_id=$this->session->userdata('admin_id');
       
         
       
       $config = array();
       $config["base_url"] = base_url() . "wps-vendor/orders/filterorderhistorybydate/$1/$2/0";
       $config["total_rows"] = $this->Order_vendor_model->get_count_filter_by_date_order_by_vendor($vendor_id,$from_date,$to_date);
       $config["per_page"] = 30;
       $config["uri_segment"] = 6;
       
       
       
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        // $config['next_tag_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']  = '</span></li>';
           
       
       
       $this->pagination->initialize($config);
       $page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
       $data["results"] = $this->Order_vendor_model->get_filter_by_date_order_by_vendor($config["per_page"], $page,  $vendor_id,$from_date,$to_date);
        // print_r($this->db->last_query() );die;
       $data["links"] = $this->pagination->create_links();
     $data['headingTitle'] = 'All Order Lists';
    //   print_r($data["results"] );die;
    $this->load->view('order/view_order_list', $data);
     
  }



}

// End of controller