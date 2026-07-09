<?php

class Members extends Private_Controller {

  private $mId;

  public function __construct() {
    parent::__construct();
    $this->load->model(array('members/members_model', 'order/order_model', 'products/product_model'));
    $this->load->helper(array('cart/cart', 'products/product'));
    $this->load->library(array('safe_encrypt', 'Dmailer', 'cart'));
    $this->form_validation->set_error_delimiters("<div class='required red'>", "</div>");
  }

  public function index() {
    redirect('members/myaccount', '');
  }

  public function myaccount() {
    $config['per_page'] = $this->config->item('per_page');
    $offset = $this->uri->segment(3, 0);
    $mres = $this->members_model->get_member_row($this->session->userdata('user_id'));
    $data['mres'] = $mres;

    //My Recent Orders
    $condtion = "AND customers_id = '" . $this->userId . "'  and (payment_status='Paid' Or payment_method='Cash' Or payment_method='COD')";
    $res_array = $this->order_model->get_orders('0', '3', $condtion);
    $data['orders'] = $res_array;


    $data['title'] = "My Account";
    $this->load->view('view_member_myaccount', $data);
  }

  public function order_details() {
    $id = (int) $this->uri->segment(3);
    $order_res = $this->order_model->get_order_master($id);
    $order_details_res = $this->order_model->get_order_detail($id);

    $data['order_res'] = $order_res;
    $data['order_details'] = $order_details_res;

    $this->load->view('members/view_order_details', $data);
  }

  public function remove_wishlist() {
    $wish_id = (int) $this->uri->segment(3);

    if ($wish_id > 0) {
      $record = count_record('wps_wishlists', "id ='" . $wish_id . "'");
      if ($record > 0) {
        $this->db->query("DELETE FROM wps_wishlists WHERE id = '" . $wish_id . "'");
        $this->session->set_userdata(array('msg_type' => 'success'));
        $this->session->set_flashdata('success', "Product removed from wishlist.");
      } else {
        $this->session->set_userdata(array('msg_type' => 'warning'));
        $this->session->set_flashdata('warning', "Something went wrong, please try again!");
      }
    } else {
      $this->session->set_userdata(array('msg_type' => 'warning'));
      $this->session->set_flashdata('warning', "Wishlist product not found!");
    }
    redirect($_SERVER['HTTP_REFERER']);
  }

  public function cancel_order() {
    $orderid = (int) $this->uri->segment(3);
    if ($orderid > 0) {
      $this->db->query("UPDATE wps_order SET order_status = 'Canceled' WHERE order_id = '" . $orderid . "'");

      //update stock
      $where = "order_id = '" . $orderid . "' ";
      $orders = $this->db->query("SELECT store, products_id, quantity FROM wps_orders_products WHERE " . $where)->result_array();
      foreach ($orders as $ord) {
        $qty = $ord['quantity'];
        $this->db->query("UPDATE wps_product_attributes SET quantity=quantity+$qty WHERE store_id = '" . $ord['store'] . "' AND product_id = '" . $ord['products_id'] . "'");
      }
      //End here

      $this->session->set_userdata(array('msg_type' => 'success'));
      $this->session->set_flashdata('success', "Your Order has been canceled successfully!");
    } else {
      $this->session->set_userdata(array('msg_type' => 'error'));
      $this->session->set_flashdata('error', "Incorrect Order ID, Please try again!");
    }
    redirect($_SERVER['HTTP_REFERER']);
  }

  public function edit_account() {
    $data['unq_section'] = "Myaccount";
    $data['title'] = "Edit Account";
    $data['titleArray'] = $this->config->item('titleArray');
    $mres = $this->members_model->get_member_row($this->session->userdata('user_id'));
    //trace($mres);

    if (is_array($mres) && !empty($mres)) {
    $data['ship_addr']=  $mres_address = $this->db->query("select * from wps_customers_address_book where  customer_id='" . $mres['customers_id'] . "' AND address_type = 'Ship' order by address_id desc limit 0, 1")->row_array();
// trace($this->db->last_query());die;
    $data['bill_addr']=  $mres_address_bil = $this->db->query("select * from wps_customers_address_book where  customer_id='" . $mres['customers_id'] . "' AND address_type = 'Bill' order by address_id desc limit 0, 1")->row_array();

      
      if (is_array($mres_address) && !empty($mres_address)) {
        $mres1 = array(
            'mtitle' => '',
            'name' => $mres_address['first_name'],
            'mobile' => $mres_address['mobile'],
            'address' => $mres_address['address'],
            'landmark' => $mres_address['landmark'],
            'zipcode' => $mres_address['zipcode'],
            'country' => $mres_address['country'],
            'city' => $mres_address['city'],
            'state' => $mres_address['state'],
            'address_id' => $mres_address['address_id'],
            'bmtitle' => '',
            'bil_name' => $mres_address_bil['first_name'],
            'bil_mobile' => $mres_address_bil['mobile'],
            'bil_address' => $mres_address_bil['address'],
            'bil_landmark' => $mres_address_bil['landmark'],
            'bil_zipcode' => $mres_address_bil['zipcode'],
            'bil_country' => $mres_address_bil['country'],
            'bil_city' => $mres_address_bil['city'],
            'bil_state' => $mres_address_bil['state'],
            'bil_address_id' => $mres_address_bil['address_id'],
        );
      } else {
        $mres1 = array(
            'mtitle' => '',
            'name' => '',
            'mobile' => '',
            'address' => '',
            'landmark' => '',
            'zipcode' => '',
            'country' => '',
            'city' => '',
            'state' => '',
            'address_id' => '',
            'bmtitle' => '',
            'bil_name' => '',
            'bil_mobile' => '',
            'bil_address' => '',
            'bil_landmark' => '',
            'bil_zipcode' => '',
            'bil_country' => '',
            'bil_city' => '',
            'bil_state' => '',
            'bil_address_id' => @$mres_address_bil['address_id'],
            'last_shopping_comment' => ''
        );
      }
      $data['mres1'] = $mres1;

      //Shipping validation
      //$this->form_validation->set_rules('mtitle', 'Shipping Name Title', 'trim|required');
      $this->form_validation->set_rules('ship_name', 'Shipping Name', 'trim|required|alpha|max_length[160]');
      $this->form_validation->set_rules('ship_mobile', 'Ship Mobile No.', 'trim|required|max_length[20]|min_length[10]');
      $this->form_validation->set_rules('ship_address', 'Shipping Address', 'trim|required|max_length[200]');
      $this->form_validation->set_rules('ship_lmark', 'Shipping Landmark', 'trim|max_length[160]');
      $this->form_validation->set_rules('ship_city', 'Shipping City', 'trim|required|max_length[40]');
      $this->form_validation->set_rules('ship_pin', 'Pin Code', 'trim|required|max_length[20]');
      $this->form_validation->set_rules('ship_state', 'Shipping State', 'trim|required|max_length[40]');
      $this->form_validation->set_rules('ship_country', 'Shipping Country', 'trim|required|max_length[80]');

      //Billing validation
      //$this->form_validation->set_rules('bmtitle', 'Billing Name Title', 'trim|required');
      $this->form_validation->set_rules('bil_name', 'Billing Name', 'trim|required|alpha|max_length[160]');
      $this->form_validation->set_rules('bil_mobile', 'Billing Mobile No.', 'trim|required|max_length[20]|min_length[10]');
      $this->form_validation->set_rules('bil_address', 'Billing Address', 'trim|required|max_length[200]');
      $this->form_validation->set_rules('bil_lmark', 'Billing Landmark', 'trim|max_length[160]');
      $this->form_validation->set_rules('bil_city', 'Billing City', 'trim|required|max_length[40]');
      $this->form_validation->set_rules('bil_pin', 'Billing Pin Code', 'trim|required|max_length[20]');
      $this->form_validation->set_rules('bil_state', 'Billing State', 'trim|required|max_length[40]');
      $this->form_validation->set_rules('bil_country', 'Billing Country', 'trim|required|max_length[80]');

      if ($this->form_validation->run() == TRUE) {

        $posted_user_data_ship = array(
            'mtitle' => '',
            'first_name' => $this->input->post('ship_name'),
            'mobile' => $this->input->post('ship_mobile'),
            'address' => $this->input->post('ship_address'),
            'landmark' => $this->input->post('ship_lmark'),
            'zipcode' => $this->input->post('ship_pin'),
            'country' => $this->input->post('ship_country'),
            'city' => $this->input->post('ship_city'),
            'state' => $this->input->post('ship_state'),
        );
        //trace($posted_user_data_ship);
        //exit;
        $where_ship = "address_id = '" . $mres1['address_id'] . "'";
        $this->members_model->safe_update('wps_customers_address_book', $posted_user_data_ship, $where_ship, FALSE);

        $posted_user_data = array(
            'mtitle' => '',
            'first_name' => $this->input->post('bil_name'),
            'mobile' => $this->input->post('bil_mobile'),
            'address' => $this->input->post('bil_address'),
            'landmark' => $this->input->post('bil_lmark'),
            'zipcode' => $this->input->post('bil_pin'),
            'country' => $this->input->post('bil_country'),
            'city' => $this->input->post('bil_city'),
            'state' => $this->input->post('bil_state'),
        );

        $where = "address_id = '" . $mres1['bil_address_id'] . "'";
        $this->members_model->safe_update('wps_customers_address_book', $posted_user_data, $where, FALSE);


        $this->session->set_userdata(array('msg_type' => 'success'));
        $this->session->set_flashdata('success', 'Account has been updated successfully!!!');
        redirect('members/edit_account', 'refresh');
      }
    } else {
      redirect('members', '');
    }


    $data['mres'] = $mres;
    $this->load->view('view_member_edit_account', $data);
  }

  public function change_password() {
    $mres = $this->members_model->get_member_row($this->session->userdata('user_id'));
    $data['mres'] = $mres;
    $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
    $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|valid_password');
    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');

    if ($this->form_validation->run() == TRUE) {
      $password_old = $this->input->post('old_password', TRUE);
      $mres = $this->members_model->get_member_row($this->userId, " AND password='$password_old' ");
      if (is_array($mres) && !empty($mres)) {
        $password = $this->input->post('new_password', TRUE);
        $data = array('password' => $password);
        $where = "customers_id=" . $this->session->userdata('user_id') . " ";
        $this->members_model->safe_update('wps_customers', $data, $where, FALSE);
        $this->session->set_userdata(array('msg_type' => 'success'));
        $this->session->set_flashdata('success', ' Password has been changed successfully.');
      } else {
        $this->session->set_userdata(array('msg_type' => 'error'));
        $this->session->set_flashdata('error', ' Old Password is not valid.');
      }
      redirect('members/change_password', '');
    }
    /* End  member change password  */
    $data['unq_section'] = "Myaccount";
    $data['heading_title'] = "Account Settings";
    $this->load->view('members/view_member_change_password', $data);
  }

  public function mywishlist() {
    $data['mres'] = $this->members_model->get_member_row($this->session->userdata('user_id'));
    $data['wishlist'] = $this->members_model->get_wislists(NULL, NULL, array());
    //echo_sql();
    $data['total_records'] = get_found_rows();
    $this->load->view('members/view_member_wishlist', $data);
  }

  public function remove_wislist() {
    $wishlists_id = $ordId = $this->uri->segment(3);
    if ($wishlists_id != '') {

      $where = array('id' => $wishlists_id, 'customer_id' => $this->userId);
      $this->members_model->safe_delete('wps_wishlists', $where, FALSE);

      $this->session->set_userdata(array('msg_type' => 'success'));
      $this->session->set_flashdata('success', $this->config->item('wish_list_delete'));
      redirect('members/mywishlist', '');
    }
  }  

  public function orders_history() {
    $data['unq_section'] = "Myaccount";
    $mres = $this->members_model->get_member_row($this->session->userdata('user_id'));
    $data['mres'] = $mres;

    //get orders
    $record_per_page = (int) $this->input->post('per_page');
    $config['per_page'] = 50; //$this->config->item('per_page');
    $page_segment = find_paging_segment();
    $offset = (int) $this->uri->segment($page_segment, 0);
    //conditions
    //$condtion = "AND customers_id = '$this->userId'  and (payment_status='Paid' Or payment_method='Cash' Or payment_method='COD') ";
	$condtion = "AND customers_id = '$this->userId'";
    if ($this->input->post('order_id') != '') {
      $condtion .= "AND invoice_number = '" . $this->input->post('order_id') . "' ";
    }
    if ($this->input->post('start_date') != '') {
      $condtion .= "AND order_received_date >= '" . $this->input->post('start_date') . "' ";
    }
    if ($this->input->post('end_date') != '') {
      $condtion .= "AND order_received_date <= '" . $this->input->post('end_date') . "' ";
    }
    if ((int) $this->uri->segment(3, 0) == TRUE) {
      $condtion .= "AND order_id = '" . $this->uri->segment(3) . "' ";
    }

    $base_url = "members/orders_history/index/pg/";
    $res_array = $this->order_model->get_orders($offset, $config['per_page'], $condtion);
    $config['total_rows'] = $data['total_list_rows'] = $this->order_model->total_rec_found;
    $data['orders'] = $res_array;
    
    // print_r($res_array);die;
    
    $this->load->view('view_member_orders', $data);
  }

  public function ajax_load_orders() {
    //get orders
    $config['per_page'] = $this->config->item('per_page');
    $offset = $this->input->get_post('stOffSet');
    $condtion = "AND customers_id = '$this->userId' ";
    if ($this->input->post('order_id') != '') {
      $condtion .= "AND invoice_number = '" . $this->input->post('order_id') . "' ";
    }
    if ($this->input->post('start_date') != '') {
      $condtion .= "AND order_received_date >= '" . $this->input->post('start_date') . "' ";
    }
    if ($this->input->post('end_date') != '') {
      $condtion .= "AND order_received_date <= '" . $this->input->post('end_date') . "' ";
    }
    if ((int) $this->uri->segment(3, 0) == TRUE) {
      $condtion .= "AND order_id = '" . $this->uri->segment(3) . "' ";
    }
    $res_array = $this->order_model->get_orders($offset, $config['per_page'], $condtion);
    $config['total_rows'] = $data['total_list_rows'] = $this->order_model->total_rec_found;
    $data['orders'] = $res_array;
    $this->load->view('view_member_orders_ajax', $data);
  }

  public function manage_addresses() {
    $customer_id = $this->session->userdata('user_id');

    $record_per_page = (int) $this->input->post('per_page');
    $parent_segment = (int) $this->uri->segment(3);
    $page_segment = find_paging_segment();

    $config['per_page'] = ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
    $offset = (int) $this->uri->segment($page_segment, 0);

    $parent_id = ( $parent_segment > 0 ) ? $parent_segment : '0';
    $base_url = ( $parent_segment > 0 ) ? "members/manage_addresses/$parent_id/pg/" : "members/manage_addresses/pg/";


    $address_res = $this->members_model->get_member_address_book($customer_id, $offset, $config['per_page']);
    $config['total_rows'] = $this->members_model->total_rec_found;
    $data['page_links'] = front_pagination("$base_url", $config['total_rows'], $config['per_page'], $page_segment);

    $data['address_res'] = $address_res;
    $data['heading'] = "Manage Addresses";
    $this->load->view('view_member_addresses', $data);
  }

  public function manage_addresses_add() {

    $this->form_validation->set_rules('name', 'Name', 'trim|required|alpha|max_length[80]');
    $this->form_validation->set_rules('mobile', 'Mobile No.', 'trim|required|max_length[20]');
    $this->form_validation->set_rules('phone', 'Phone No.', 'trim|max_length[20]');
    $this->form_validation->set_rules('zipcode', 'Pin Code', 'trim|required|max_length[20]');
    $this->form_validation->set_rules('address', 'Address', 'trim|required|max_length[200]');
    $this->form_validation->set_rules('landmark', 'Landmark', 'trim|required|max_length[200]');
    $this->form_validation->set_rules('city', 'City', 'trim|required|max_length[40]');
    $this->form_validation->set_rules('state', 'State', 'trim|required|max_length[40]');
    $this->form_validation->set_rules('country', 'Country', 'trim|required|max_length[80]');

    if ($this->form_validation->run() == TRUE) {
      $data = array(
          'customer_id' => $this->session->userdata('user_id'),
          'name' => $this->input->post('name'),
          'mobile' => $this->input->post('mobile'),
          'phone' => $this->input->post('phone'),
          'zipcode' => $this->input->post('zipcode'),
          'address' => $this->input->post('address'),
          'landmark' => $this->input->post('landmark'),
          'city' => $this->input->post('city'),
          'state' => $this->input->post('state'),
          'country' => $this->input->post('country'),
          'default_status' => 'Y'
      );
      //trace($data);
      //exit;
      $this->members_model->safe_insert('wps_customers_address_book', $data, FALSE);
      $this->session->set_userdata(array('msg_type' => 'success'));
      $this->session->set_flashdata('success', 'New Address has been added successfully!!!');
      redirect('members/manage_addresses_add', '');
    }

    /* End  member change password  */

    $data['unq_section'] = "Myaccount";
    $data['heading_title'] = "Account Settings";
    $this->load->view('members/view_address_add', $data);
  }

  public function manage_addresses_edit() {

    //$addressid     = (int) $this->uri->segment(3);
    //$res=$this->db->query("select * from wps_customers_address_book where address_id='".$addressid."'")->row_array();

    $this->form_validation->set_rules('add_name', 'Name', 'trim|required|alpha|max_length[80]');
    $this->form_validation->set_rules('add_mobile', 'Mobile No.', 'trim|required|max_length[20]');

    $this->form_validation->set_rules('add_zipcode', 'Pin Code', 'trim|required|max_length[20]');
    $this->form_validation->set_rules('add_address', 'Address', 'trim|required|max_length[200]');
    $this->form_validation->set_rules('add_landmark', 'Landmark', 'trim|required|max_length[200]');
    $this->form_validation->set_rules('add_city', 'City', 'trim|required|max_length[40]');
    $this->form_validation->set_rules('add_state', 'State', 'trim|required|max_length[40]');
    $this->form_validation->set_rules('add_country', 'Country', 'trim|required|max_length[80]');

    if ($this->form_validation->run() == TRUE) {
      $data = array(
          'name' => $this->input->post('add_name'),
          'mobile' => $this->input->post('add_mobile'),
          'phone' => $this->input->post('add_mobile'),
          'zipcode' => $this->input->post('add_zipcode'),
          'address' => $this->input->post('add_address'),
          'landmark' => $this->input->post('add_landmark'),
          'city' => $this->input->post('add_city'),
          'state' => $this->input->post('add_state'),
          'country' => $this->input->post('add_country'),
      );
      //trace($data);
      //exit;
      $where = array('customer_id' => $this->session->userdata('user_id'));
      $this->members_model->safe_update('wps_customers_address_book', $data, $where, FALSE);
      $this->session->set_userdata(array('msg_type' => 'success'));
      echo 2;
      //$this->session->set_flashdata('success', 'New Address has been updated successfully!!!');
      //redirect('members/manage_addresses_edit/' . $addressid, '');
    } else {
      echo validation_errors();
      die;
    }

    /* End  member change password  */
    /* $data['res'] = $res;
      //trace($res);
      $data['unq_section'] = "Myaccount";
      $data['heading_title'] = "Account Settings";
      $this->load->view('members/view_address_edit',$data); */
  }

  public function delete_address() {
    $addressid = (int) $this->uri->segment(3);
    $this->db->query("delete from wps_customers_address_book where address_id = '" . $addressid . "'");
    $this->session->set_userdata(array('msg_type' => 'success'));
    $this->session->set_flashdata('success', 'Address has been Deleted successfully!!!');
    redirect($_SERVER['HTTP_REFERER']);
  }

  public function post_review() {
    //trace($this->input->post()); 
    $productId = (int) $this->uri->segment(3);
    $data['proRes'] = get_db_single_row("wps_products", "*", "products_id = '" . $productId . "'");

    $this->form_validation->set_error_delimiters("<div class='required'>", "</div>");
    $data['mres'] = $this->members_model->get_member_row($this->session->userdata('user_id'));


    $this->form_validation->set_rules('star', 'Rating', 'trim|required|max_length[1]');
    $this->form_validation->set_rules('review', 'Review', 'trim|required|max_length[450]');
    if ($this->form_validation->run() === TRUE) {
      $mem_id = $this->session->userdata('user_id');
      $posted_data = array(
          'product_id' => $this->input->post('products_id'),
          'entity_type' => 'product',
          'customer_id' => $this->session->userdata('user_id'),
          'ads_rating' => $this->input->post('star'),
          'author' => $this->session->userdata('fullname'),
          'author_email' => $this->session->userdata('username'),
          'text' => $this->input->post('review'),
          'status' => '0',
          'review_date' => $this->config->item('config.date.time')
      );
      $this->product_model->safe_insert('wps_review', $posted_data, FALSE);
      $this->session->set_userdata(array('msg_type' => 'success'));
      $this->session->set_flashdata('success', 'Thank you. Your review has been submitted successfully');
      redirect('members/post_review/' . $data['proRes']['products_id'], '');
    }
    $this->load->view('view_member_post_review', $data);
  }

  public function reviews() {
    $data['mres'] = $this->members_model->get_member_row($this->session->userdata('user_id'));

    $data['reviews'] = $this->db->query("SELECT * FROM  wps_review WHERE customer_id='" . $this->session->userdata('user_id') . "'")->result_array();

    $this->load->view('view_member_my_reviews', $data);
  }

  public function feedback() {
    $data['mres'] = $this->members_model->get_member_row($this->session->userdata('user_id'));
    $testimonials = $this->db->query("SELECT * FROM  wps_testimonial WHERE user_id='" . $this->session->userdata('user_id') . "'")->row_array();
   
    $this->form_validation->set_rules('feedback', 'Feedback', 'trim|required');
   
    if ($this->form_validation->run() == TRUE) {
        if(count($testimonials)>0){
            $data = array('testimonial_description' => $this->input->post('feedback'), );
            $where = "user_id=" . $this->session->userdata('user_id') . " ";
            $this->members_model->safe_update('wps_testimonial', $data, $where, FALSE);
            $this->session->set_userdata(array('msg_type' => 'success'));
            $this->session->set_flashdata('success', 'Feedback Updated successfully.');
        }else{
            $data = array('testimonial_description' => $this->input->post('feedback'), 'user_id' => $this->session->userdata('user_id'));
            $this->members_model->safe_insert('wps_testimonial', $data);
            $this->session->set_userdata(array('msg_type' => 'success'));
            $this->session->set_flashdata('success', 'Feedback Added successfully.');
        }
       
        redirect('members/feedback', '');
    }
   
    $data['feedback'] = $testimonials;
    $this->load->view('view_member_my_feedback', $data);
  }
  
  public function notify() {
    //  $this->load->model(array('order/order_model'));
    $wishId = (int) $this->uri->segment(3);
    $data['wishId'] = $wishId;

    $param = array('condition' => "&& wishlists_id='" . $wishId . "'");

    $res = $this->members_model->get_wislists(0, 1, $param);

    $this->form_validation->set_rules('message', 'Message', 'trim|xss_clean|max_length[250]');
    if ($this->form_validation->run() == TRUE) {
      $data = array(
          'message' => $this->input->post('message', FALSE),
          'notify' => '1'
      );

      $where = array(
          'wishlists_id' => $wishId
      );

      $this->members_model->safe_update('wps_wishlists', $data, $where, TRUE);
      //		$this->session->set_userdata('msg_type',$res['error_type']);
      $this->session->set_flashdata('success', 'Your Notification has been set sucessfully.');
      redirect('members/notify/' . $wishId, '');
    }

    $data['wish'] = $res[0];
    $this->load->view('view_product_notify', $data);
  }
  
  public function track_order() {
    $data['unq_section'] = "Track Order";

    $this->form_validation->set_rules('order_id', 'Order No', 'trim|required');

    if ($this->form_validation->run() == TRUE) {
      redirect('members/orders_history/' . $this->input->post('order_id'));
    }
    $this->load->view('view_track_order', $data);
  }
  
  public function reviewrate()
  {
  
      
    //   Array ( [rating] => 4 [review] => thrytyn5 [username] => ynvtyvnbyu [email] => nvtny )
    
    $this->form_validation->set_rules('rating','rating','required|trim');
    $this->form_validation->set_rules('review','review','required|trim');
    $this->form_validation->set_rules('username','username','required|trim');
    $this->form_validation->set_rules('email','email','required|trim|valid_email');
    if($this->form_validation->run())
    {
        $data=array(
                    'rating_star'        =>$this->input->post('rating'),
                    'review_text'        =>$this->input->post('review'),
                    'username'           =>$this->input->post('username'),
                    'email'              =>$this->input->post('email'),  
                    'user_id'            =>$this->session->userdata('user_id'),
                    'created_at'         =>date('Y-m-d H:i:s'),
                    'prod_slug'          =>$this->input->post('prod_slug'),  
                    'product_id'         =>$this->input->post('product_id'),
                    );
        
        $where=array('user_id'=>$this->session->userdata('user_id'),'prod_slug'=>$this->input->post('prod_slug'));    
        
        if($r=$this->members_model->get_count_where('rating_review',$where))
        {
            if(is_array($r) && count($r)>0)
            {
                $data=array(
                        'rating_msg'=>"<div class='ratesetmsg'>Allready Rated to this product</div>",
                        'errorcode'=>202,
                        'status'    =>true
                );
            }
        }
                    
                    
                    
        if($this->members_model->add_master('rating_review',$data))
        {
            $data=array(
                        'rating_msg'=>"<div class='ratesetmsg'>Successfully Rated this product</div>",
                        'errorcode'=>200,
                        'status'    =>true
                );
        }
        else
        {
            $data=array(
                        'rating_msg'=>"<div class='ratesetmsg'>You can't rate this product</div>",
                        'errorcode'=>400,
                        'status'    =>  false,
                );
        }
    }
    else
    {
            $data=array(
                        'rating_msg'=>"<div class='ratesetmsg'>".validation_errors()."</div>",
                        'errorcode'=>600,
                        'status'    =>  false,
                );
    }
    echo json_encode($data);
  }
  
  public function rewardspoint()
  {
    $user_id=$_SESSION['user_id'];
    $query="
    SELECT wps_products.cancelation_expiry_days,
    wps_order.invoice_number,
    wps_products.approval_date,
    wps_orders_products.vendor_id,
    wps_orders_products.product_price,
    wps_orders_products.request_for_return_date,
    wps_orders_products.product_name, 
    wps_orders_products.product_image_name, 
    wps_orders_products.size_id, 
    wps_orders_products.color_id, 
    user_wallet_trans.id as wallet_id,
    user_wallet_trans.user_id, 
    user_wallet_trans.id as wallet_id,
    user_wallet_trans.debit_amount, 
    user_wallet_trans.credit_amount,
    user_wallet_trans.cr_dr,
    user_wallet_trans.earn_coin,
    user_wallet_trans.created_at, 
    user_wallet_trans.updated_at
    FROM `user_wallet_trans` 
    inner join wps_products on wps_products.products_id=user_wallet_trans.product_id 
    inner join wps_order on wps_order.order_id=user_wallet_trans.order_id 
    inner join wps_orders_products on wps_orders_products.orders_products_id=user_wallet_trans.order_product_id 
    WHERE user_wallet_trans.user_id='$user_id' order by wallet_id desc";
    $data['order_reward_data']=$this->members_model->get_raw_query($query);
    $this->load->view('rewards_point',$data);
  }
  
  
  public function getorderdetailslistbyorderid()
  {
 

      $orderid  =   $this->input->post('orderid');
      $userid   =   $this->input->post('userid');
      
     $orderdetails=$this->db->query("select wps_orders_products.product_name,wps_orders_products.request_for_return_date,wps_orders_products.orders_products_id,wps_orders_products.order_id,wps_orders_products.product_image,wps_orders_products.product_image_name,wps_orders_products.product_price,wps_order.order_status,wps_order.order_delivery_date, wps_orders_products.quantity, wps_products.vendor_id ,wps_products.cancelation_expiry_days, wps_order.customers_id,wps_order.payment_status,wps_orders_products.ecomm_awb_number,wps_orders_products.ecomm_order_status,wps_orders_products.sub_order_id from wps_orders_products inner join wps_products on wps_products.products_id=wps_orders_products.products_id inner join wps_order on wps_order.order_id=wps_orders_products.order_id where wps_orders_products.order_id='$orderid' and wps_order.customers_id='$userid'  group by wps_orders_products.orders_products_id")->result_array();
     $html='';
    // order_status  order_delivery_date    $canel_url=base_url().'my-orders/ordercancel/';
   
         $ii=0;
         foreach($orderdetails as $odd=>$od) 
         {
            $html.='<tr>';
            $html.='<td class="text-center"><img class="img-responsive" height="100px" src="'. get_image('products', $od['product_image_name'], 270, 270, 'AR').'">'.'</td>';
            $html.='<td class="text-center">'.$od['product_name'].'</td>';
			$html.='<td class="text-center">'.$od['sub_order_id'].'</td>';
			$html.='<td class="text-center"><a target="_blank" class="badge outline-badge-success" href="https://ecomexpress.in/tracking/?awb_field='.$od['ecomm_awb_number'].'">'.$od['ecomm_awb_number'].'</a></td>';
            $html.='<td class="text-center"> ₹ '.$od['product_price'].'</td>';
            $html.='<td class="text-center">'.$od['quantity'].'</td>';
            $html.='<td class="text-center">₹ '.$od['product_price']*$od['quantity'].'</td>';
            
            $html.='<td class="text-center">';
            
            
            
            $expdays=$od['cancelation_expiry_days'];
            $mx_return_date=date('Y-m-d H:i:s',strtotime('+'.$expdays.' days',strtotime($od['order_received_date'])));
            $today=date('Y-m-d H:i:s');
            
            // if($today > date('Y-m-d H:i:s',strtotime($mx_return_date)) && $od['order_status']=='8' && $od['request_for_return_date']=='0000-00-00 00:00:00')
            if($today > date('Y-m-d H:i:s',strtotime($mx_return_date)) && $od['order_status']=='8' && $od['request_for_return_date']=='0000-00-00 00:00:00')
            {
                $html.='<button id="calncelorder'.$od['orders_products_id'].'" 
                class="btn btn-outline btn-default btn-block btn-sm btn-rounded" data-orderId="'. $o['order_id'].'
                data-userid="'.$this->session->userdata('user_id').'data-prodid="'.$od['products_id'].'">Return Product</button>';
            }
            elseif($od['order_status']<=4)  //for not reach the delivery
            {
                 $html.='<button id="calncelorder'.$od['orders_products_id'].'" 
                class="btn btn-outline btn-default btn-block btn-sm btn-rounded" data-orderId="'. $o['order_id'].'
                data-userid="'.$this->session->userdata('user_id').'data-prodid="'.$od['products_id'].'">Return Product</button>';
            }
            elseif( $od['request_for_return_date']!='0000-00-00 00:00:00')
            {
                $html.= '<buton class="btn btn-outline btn-default btn-block btn-sm btn-rounded" >Cancelled</button>';
            }
            else
            {
                
            }
            $html.='</td>';
            
            $html.='</tr>'."<script>
                        $('#calncelorder".$od['orders_products_id']."').on('click',function(){
                           
                            var orderid= $(this).data('orderid');
                            var userid= $(this).data('userid');
                        
                            $.ajax({
                              url:site_url+'my-orders/ordercancel',
                              method:'post',
                              data:{orderid:orderid,userid:userid},
                              success(html)
                              {
                                    $('#orderdetailstable').html(html);
                                    $('#myModal').hide();
                                    $('#productcancelation').show();
                                    $('#prod_id').val(".$od['orders_products_id'].")
                              }
                            })
                        })
                    </script>"; 
         }  
    echo $html;
  }
  
  public function ordercancel()
  {
      echo 1;
  }
  
  public function cancelsingleproduct()
  {
      $user_id= $this->session->userdata('user_id');
      if($user_id=='')
      {
          redirect(base_url().'login');
      }
      
          $this->form_validation->set_rules('products_id','products_id','trim|required');
          $this->form_validation->set_rules('reason','reason','trim|required');
          $this->form_validation->set_rules('remark','remark','trim|required');
      if( $this->form_validation->run())
      {
        $data=array(
                    'reason_for_return' =>$this->input->post('reason'),
                    'return_remark'=>$this->input->post('remark'),
                    'request_for_return_date'=>date('Y-m-d H:i:s'),
                    );   
        $where=array( 'orders_products_id'=>$this->input->post('products_id'),);
        if($this->members_model->update_where('wps_orders_products',$data,$where))
        {
            $data=array('status'=>true,'msg'=>'Cancel your product successfully','data'=>'success');
        }
        else
        {
            $data=array('status'=>false,'msg'=>'Not Cancelled','data'=>'error');
        }
      }
      else
      {
           $data=array('status'=>false,'msg'=>validation_errors(),'data'=>'error');
      }
        
     echo json_encode($data);   
        
  }
  
  
  
  
  
    // calcel by user which user   
  
  public function markmyproductcancel($order_id)
  {
    //   $user_id= $this->session->userdata('user_id');
    //   $order_data=$this->db->select('*')
    //   ->where('order_id',$order_id)
    //   ->where('customers_id',$user_id)
    //   ->get('wps_order')
    //   ->row_array();
       
       
    //   print_r($order_data);die;
       
       
    //   if($order_data)
    //   {
    //       $return_expiry_date=$order_data[''];
    //   }
    //   else
    //   {
    //       echo 0;
    //   }
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  

}

/* End of file member.php */
/* Location: .application/modules/member/member.php */