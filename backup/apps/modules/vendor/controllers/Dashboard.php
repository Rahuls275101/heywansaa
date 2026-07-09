<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('admin/admin_model'));
    $this->form_validation->set_error_delimiters("<div style='color:#FC0000; margin-bottom:5px;'>", "</div>");
  }

  public function index() {
    $data = array('headingTitle'=>"");
    $admin_id= $this->session->userdata('admin_id');
    $startDate = date("Y-m-d",strtotime("-11 months"));
    $data['startDate'] = $startDate;
    
    $data['ddaSeller'] = $this->db->query("SELECT * FROM wps_orders_membership WHERE userType != '1' ORDER BY order_id DESC LIMIT 5")->result_array();
   
    $data['ddaBuyer'] = $this->db->query("SELECT * FROM wps_orders_membership WHERE userType = '1' ORDER BY order_id DESC LIMIT 5")->result_array();
    
    $data['orders'] = $this->db->query("SELECT * FROM wps_order WHERE 1 ORDER BY order_id DESC LIMIT 5")->result_array();
    
    $data['enq'] = $this->db->query("SELECT * FROM wps_enquiry WHERE type = '3' ORDER BY id DESC LIMIT 5")->result_array();
    
    $data['order_pending']     =  $this->db->query("SELECT count(wps_orders_products.vendor_id) as count FROM wps_orders_products inner join `wps_order` on wps_order.order_id=wps_orders_products.order_id where wps_order.order_status='0' and wps_orders_products.vendor_id='$admin_id' ")->result_array()[0];   
    $data['order_processing']  =  $this->db->query("SELECT count(wps_orders_products.vendor_id) as count FROM wps_orders_products inner join `wps_order` on wps_order.order_id=wps_orders_products.order_id where wps_order.order_status='1' and wps_orders_products.vendor_id='$admin_id'  ")->result_array()[0];       
    $data['order_complete']    =  $this->db->query("SELECT count(wps_orders_products.vendor_id) as count FROM wps_orders_products inner join `wps_order` on wps_order.order_id=wps_orders_products.order_id where wps_order.order_status='8' and wps_orders_products.vendor_id='$admin_id' ")->result_array()[0];   
    $data['total_product']     =  $this->db->query("SELECT count(*) as count FROM `wps_products` where vendor_id='$admin_id' ")->result_array()[0];   
    $data['total_earning']     =  $this->db->query("SELECT sum(wps_orders_products.product_price+wps_orders_products.gst) as total_amount FROM wps_orders_products inner join `wps_order` on wps_order.order_id=wps_orders_products.order_id where wps_order.order_status='8' and wps_orders_products.vendor_id='$admin_id' ")->result_array()[0];   
    $data['total_sold_item']   =  $this->db->query("SELECT count(wps_orders_products.vendor_id) as count FROM wps_orders_products inner join `wps_order` on wps_order.order_id=wps_orders_products.order_id where wps_order.order_status='8' and  wps_orders_products.vendor_id='$admin_id'  ")->result_array()[0];       
    

    
    
    
    
    // print_r($data);
    // die;
    $this->load->view('dashboard/admin_dashboard_view', $data);
  }
  
  public function changepassword() {

    $this->form_validation->set_rules('old_pass', 'Old Password', 'required|max_length[80]');
    $this->form_validation->set_rules('new_pass', 'New Password', 'required|valid_password|max_length[80]');
    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_pass]|max_length[80]');
    
    if ($this->form_validation->run() == TRUE) {
    $user_id=$this->session->userdata('admin_id');
      $this->admin_model->update_info($this->input->post('old_pass'), $user_id);
      redirect('wps-vendor/dashboard/changepassword', '');
    }

    $data['headingTitle'] = 'Change Password';
    $data['admin_info'] = $this->admin_model->get_admin_info(1);
    $this->load->view('dashboard/admin_change_password_view', $data);
  }

  public function website_configuration() {

    $this->form_validation->set_rules('admin_email', 'Email ID', 'required|valid_email');
    $this->form_validation->set_rules('phone', 'Phone Number', 'required|max_length[15]');
    $this->form_validation->set_rules('address', 'Address', 'required');
    if ($this->form_validation->run() == TRUE) {
      
      $this->admin_model->update_config('1');
      $this->session->set_userdata(array('msg_type' => 'success'));
      $this->session->set_flashdata('success', 'Updated successfully!');
      redirect('wps-vendor/dashboard/website_configuration', '');
    }

    $data['headingTitle'] = 'Website Configuration';
    $data['admin_info'] = $this->admin_model->get_admin_info(1);
    $this->load->view('dashboard/website_configuration', $data);
  }
  
  public function unlink_files() {
    $file = $this->input->get('f');
    $file_root = FCROOT . "$file";
    @unlink($file_root);
  }

  public function count_record($table, $condition = "") {
    if ($table != "" && $condition != "") {
      $this->db->from($table);
      $this->db->where($condition);
      $num = $this->db->count_all_results();
    } else {
      $num = $this->db->count_all($table);
    }
    return $num;
  }

  public function remove_thumb_cache() {
    $path = IMG_CACH_DIR;
    $this->load->helper("file");
    delete_files($path);
  }

  public function php_info() {
    phpinfo();
  }

  public function make_folder($name = '') {
    if ($name != '') {
      make_missing_folder($name);
    }
  }

  public function get_ini() {
    trace(ini_get_all());
  }

  public function clear_cache() {
    $path = UPLOAD_DIR . '/thumb-cache';
    $dir_handle = @opendir($path) or die("Unable to open folder");
    while (false !== ($file = readdir($dir_handle))) {
      if ($file != '.' && $file != '..') {
        // echo $file.'<br>';
        unlink($path . '/' . $file);
      }
    }
    closedir($dir_handle);
    redirect('wps-vendor/dashbord/');
    echo 'Not Redirect Properly';
  }
  
  public function updateMeta(){
    $res = $this->db->query("SELECT page_id, page_name from wps_cms_pages WHERE status = '1'")->result_array();
    foreach($res as $val){
      echo $val['page_id'].' - '.$val['page_name'].'<br />';
      $qry = "UPDATE wps_meta_tags SET meta_title = '".$val['page_name']." - Lootmojo' WHERE entity_type = 'pages/index' AND entity_id = '".$val['page_id']."'";
      echo $qry.'<br />';
      $this->db->query($qry);
      echo '<br />';
    }
  }

}
