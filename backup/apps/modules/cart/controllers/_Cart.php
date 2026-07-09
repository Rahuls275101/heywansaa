<?php

class Cart extends Public_Controller {

  public function __construct() {

    parent::__construct();
    $this->load->helper(array('cart', 'products/product'));
    $this->load->model(array('products/product_model', 'members/members_model', 'cart_model', 'order/order_model', 'pages/pages_model'));
    $this->load->library(array('safe_encrypt', 'Auth', 'Dmailer'));
    $this->form_validation->set_error_delimiters("<div class='required fs12'>", "</div>");
  }

  public function index() {
  //echo "<pre>";
  //print_r($this->cart->contents());
  
    // trace($this->cart->total_items()); die;
    $order_cart_id = $this->session->userdata('working_order_id');
    if ($order_cart_id != '') {
      $this->session->unset_userdata('working_order_id');
    }
    if ($this->input->post('EmptyCart') != "") {
      $this->empty_cart();
      $this->session->set_userdata(array('msg_type' => 'success'));
      $this->session->set_flashdata('success', $this->config->item('cart_empty'));
      redirect('cart');
    }
    //cart Items
    //trace($this->cart->contents());
    $tax_cent = $this->cart_model->get_vat();
    $data['tax_cent'] = $tax_cent;
    $data['title'] = "Shopping Cart";
    $this->load->view('view_my_cart', $data);
  }

 
 

  public function checkout() {
    //trace($this->cart->total_items()); die;
    if (!$this->cart->total_items() > 0) {
      redirect('home');
    }
    if (!$this->auth->is_user_logged_in()) 
    {
      $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[80]');

      if ($this->form_validation->run() == TRUE) {
        $username = $this->input->post('email');
        if ($this->input->post('checkout_type') == 'User') {
          $this->form_validation->set_rules('password', 'Password', 'trim|required');
          if ($this->form_validation->run() == TRUE) {
          $password = md5($this->input->post('password'));

          $this->auth->verify_user($username, $password);
          if ($this->auth->is_user_logged_in()) {
            redirect('cart/delivery_info', '');
          } else {
            $this->session->set_userdata(array('msg_type' => 'error'));
            $this->session->set_flashdata('error', $this->config->item('login_failed'));
            $data['title'] = "Checkout Info";
            $this->load->view('view_cart_checkout', $data);
          }
        }else{
          $data['title'] = "Checkout Info";
          $this->load->view('view_cart_checkout', $data);
        }
        } elseif ($this->input->post('checkout_type') == 'Register') {
          $this->form_validation->set_rules('name', 'Name', 'trim|required|alpha|max_length[32]');
          $this->form_validation->set_rules('mobile_number', 'Mobile No', 'trim|required|numeric|max_length[10]');
          $this->form_validation->set_rules('password_register', 'Password', 'trim|required|max_length[20]|valid_password');
          if ($this->form_validation->run() == TRUE) {

            $registerId = $this->create_user();
            $name = $this->input->post('name', TRUE);
            $username = $this->input->post('email', TRUE);
            $password = $this->input->post('password_register', TRUE);
            if ($registerId != '') {
              /* Send  mail to user */
              $content = get_content('wps_auto_respond_mails', '1');
              $subject = str_replace('{site_name}', $this->config->item('site_name'), $content->email_subject);
              $body = $content->email_content;
              $verify_url = "<a href=" . base_url() . "users/verify/" . $registerId . ">Verify Your Email Address </a>";
              $name = " User ";
              $body = str_replace('{mem_name}', $name, $body);
              $body = str_replace('{username}', $username, $body);
              $body = str_replace('{password}', $password, $body);
              $body = str_replace('{admin_email}', $this->admin_info->admin_email, $body);
              $body = str_replace('{site_name}', $this->config->item('site_name'), $body);
              $body = str_replace('{url}', base_url(), $body);
              $body = str_replace('{link}', $verify_url, $body);

              $mail_conf = array(
                  'subject' => $subject,
                  'to_email' => $this->input->post('email'),
                  'from_email' => $this->admin_info->admin_email,
                  'from_name' => $this->config->item('site_name'),
                  'body_part' => $body
              );
              //trace($mail_conf);
              //exit;
              $this->dmailer->mail_notify($mail_conf);
              /* Send  mail to admin */
              $subject = 'New member is registered';
              $body = '
              <table border="0" style="width:100%">
              <tbody>
                <tr>
                  <td colspan="2"><strong>Hi Admin,</strong></td>
                </tr> 
                <tr>
                  <td colspan="2">You have new member registered on {site_name} with the following details:</td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td><strong>Email ID:</strong></td>
                  <td>{username}</td>
                </tr>
                <tr>
                  <td><strong>Password:</strong></td>
                  <td>{password}</td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2">Thank you.<br />
                    {site_name} Customer Service<br />
                    Email: {admin_email}
                  </td>
                </tr>
                <tr>
                  <td colspan="2" style="text-align:center">&copy; ' . date('Y') . ' {site_name}. All rights reserved.</td>
                </tr>
              </tbody>
            </table>';
              $body = str_replace('{username}', $username, $body);
              $body = str_replace('{password}', $password, $body);
              $body = str_replace('{admin_email}', $this->admin_info->admin_email, $body);
              $body = str_replace('{site_name}', $this->config->item('site_name'), $body);
              $body = str_replace('{url}', base_url(), $body);
              if($this->admin_info->website_mode=='Live'){
                $mail_conf = array(
                    'subject' => $subject,
                    'to_email' => $this->admin_info->admin_email,
                    'from_email' => $this->input->post('email_address'),
                    'from_name' => $this->config->item('site_name'),
                    'body_part' => $body
                );
                //trace($mail_conf);
                $this->dmailer->mail_notify($mail_conf);
              }else{
                 $mail_conf = array(
                    'subject' => $subject,
                    'to_email' => 'info@weblieu.com',
                    'from_email' => $this->input->post('email_address'),
                    'from_name' => $this->config->item('site_name'),
                    'body_part' => $body
                );
                //trace($mail_conf);
                $this->dmailer->mail_notify($mail_conf);

              }
              /* End send  mail to admin */
            }
            $this->auth->verify_user($username, $password);
            if ($this->auth->is_user_logged_in()) {
              redirect('cart/delivery_info', '');
            } else {
              $this->session->set_userdata(array('msg_type' => 'error'));
              $this->session->set_flashdata('error', $this->config->item('login_failed'));
              redirect('cart/checkout', '');
            }
          } else {
            $data['title'] = "Checkout Info";
            $this->load->view('view_cart_checkout', $data);
          }
        } else {
          $this->session->set_userdata('username', $username);
          redirect('cart/delivery_info', '');
        }
      } else {
        $data['title'] = "Checkout Info";
        $this->load->view('view_cart_checkout', $data);
      }
    } else {
         //   redirect('cart/delivery_info', '');
         $data['title'] = "Checkout Info";
        $this->load->view('view_cart_checkout', $data);
    }
  }

  public function create_user() {
    $password = $this->safe_encrypt->encode($this->input->post('password_register', TRUE));
    $name = ($this->input->post('name', TRUE) != '') ? $this->input->post('name', TRUE) : $this->input->post('bil_name', TRUE);
    $mobile = ($this->input->post('mobile_number', TRUE) != '') ? $this->input->post('mobile_number', TRUE) : $this->input->post('bil_mobile', TRUE);
    $register_array = array(
        'user_name' => $this->input->post('email', TRUE),
        'password' => $password,
        'first_name' => $name,
        'mobile_number' => $mobile,
        'actkey' => md5($this->input->post('email', TRUE)),
        'account_created_date' => $this->config->item('config.date.time'),
        'current_login' => $this->config->item('config.date.time'),
        'status' => '1',
        'is_verified' => '1',
        'ip_address' => $this->input->ip_address()
    );
    $insId = $this->cart_model->safe_insert('wps_customers', $register_array, FALSE);
    if ($insId > 0) {
      $add_array = array(
          'customer_id' => $insId,
          'reciv_date' => $this->config->item('config.date.time'),
          'address_type' => 'Bill',
          'default_status' => 'Y'
      );
      $this->cart_model->safe_insert('wps_customers_address_book', $add_array, FALSE);
    }
    return $insId;
  }

  public function view_order_review() {
    if (!$this->cart->total_items() > 0) {
      redirect('home');
    }
    $data['title'] = 'Receiver Details';
    //Delivery Message Details validation
    //$this->form_validation->set_rules('delivery_datetime', 'Date', 'trim|required');
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('cart/view_order_review', $data);
    } else {
      redirect('cart/view_make_payment');
    }
  }

  public function delivery_info() 
  {
    if (!$this->cart->total_items() > 0 ) 
    {
      redirect('home');
    }
    $data['title'] = 'Delivery Information';
    $is_same_bill_ship = $this->input->post('is_same', TRUE);
    $mres = $this->members_model->get_member_row($this->session->userdata('user_id'));
    if (is_array($mres) && !empty($mres)) 
    {
      $email = $mres['user_name'];
    }
    else 
    {
      $email = $this->session->userdata['username'];
    }




// Array ( [first_name] => Rajkumar [last_name] => UYadav [country] => default [address] => Logix Technova, Ground Floor-031,Tower B, Sector 132, 
// Noida 201304 [landmark] => new ashok nagar [city] => noda [state] => default [zipcode] => 201301 [mobile] => 720364298 [email] => raaz@gmail.com 
// [check_add] => 1 [ship_first_name] => Rajkumar [ship_last_name] => UYadav [ship_country] => default [ship_address] => Logix Technova, Ground Floor-031,Tower B,
// Sector 132, Noida 201304 [ship_landmark] => new ashok nagar [ship_city] => noda [ship_state] => default [ship_zipcode] => 201301 )




    //Billing validation
    $this->load->library('form_validation');
    $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
    // $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|alpha|max_length[160]');
    $this->form_validation->set_rules('country', 'Country', 'trim|required|max_length[50]|alpha');
    $this->form_validation->set_rules('address', 'Address', 'trim|required|max_length[400]');
    $this->form_validation->set_rules('landmark', 'Landmark', 'trim|max_length[160]');
    $this->form_validation->set_rules('city', 'City', 'trim|required|max_length[140]');
    $this->form_validation->set_rules('state', 'State', 'trim|required');
    $this->form_validation->set_rules('zipcode', 'ZipCode', 'trim|required|numeric');
    $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|max_length[20]|numeric');
    $this->form_validation->set_rules('email', 'Email', 'trim|required');

    //Shipping validation
    $this->form_validation->set_rules('ship_first_name', 'Shipping First Name', 'trim|required');
    // $this->form_validation->set_rules('ship_last_name', 'Shipping Last Name', 'trim|required|alpha|max_length[160]');
    $this->form_validation->set_rules('ship_country', 'Shipping Country', 'trim|required|max_length[50]|alpha');
    $this->form_validation->set_rules('ship_address', 'Shipping Address', 'trim|required|max_length[400]');
    $this->form_validation->set_rules('ship_landmark', 'Shipping Landmark', 'trim|max_length[160]');
    $this->form_validation->set_rules('ship_city', 'Shipping City', 'trim|required|max_length[40]');
    $this->form_validation->set_rules('ship_state', 'Shipping State', 'trim|required');
    $this->form_validation->set_rules('ship_zipcode', 'Shipping ZipCode', 'trim|required');

    if($this->form_validation->run() === TRUE)
    {
        $this->db->where(array( 'customer_id' => $mres['customers_id']));
        $this->db->delete('wps_customers_address_book');
        $user_id='';
            if($this->session->userdata('guest_id')==null && $this->session->userdata('user_id')==null )
            {
                 $user_id= 'Guest-Checkout-'.rand();
                 $this->session->set_userdata('guest_id',$user_id);
            }
           else
            {
                 $user_id=0;
            }
                  if($mres['customers_id'])
                  {
                     $addressData = array(
					 		  'customer_type' => $this->session->userdata('user_id')?0:1,
                              'customer_id' => $mres['customers_id'],
                              'first_name' => $this->input->post('first_name'),
                              'last_name' => $this->input->post('last_name'),
                              'country' => $this->input->post('country'),
                              'address' => $this->input->post('address'),
                              'landmark' => $this->input->post('landmark'),
                              'city' => $this->input->post('city'),
                              'state' => $this->input->post('state'),
                              'zipcode' => $this->input->post('zipcode'),
                              'mobile' => $this->input->post('mobile'),
                              'email'=>$this->input->post('email'),
                              'address_type' => 'Bill'
                          );
                          $addressIDs = $this->cart_model->safe_insert('wps_customers_address_book', $addressData);
                          
                          
                        //   add shipping
                           $addressData = array(
						   	  'customer_type' => $this->session->userdata('user_id')?0:1,
                              'customer_id' => $mres['customers_id'],
                              'first_name'  => $this->input->post('ship_first_name'),
                              'last_name'   => $this->input->post('ship_last_name'),
                              'country'     => $this->input->post('ship_country'),
                              'address'     => $this->input->post('ship_address'),
                              'landmark'    => $this->input->post('ship_landmark'),
                              'city'        => $this->input->post('ship_city'),
                              'state'       => $this->input->post('ship_state'),
							  'zipcode'     => $this->input->post('ship_zipcode'),
							  'mobile' => $this->input->post('ship_mobile'),
                      		  'email'=>$this->input->post('ship_email'),                              
                              'address_type' => 'Ship'
                          );
                          $addressIDs = $this->cart_model->safe_insert('wps_customers_address_book', $addressData);
                          
                        
                  }
                  else
                  {
                      
                    $addressData = array(
                      'customer_type' => $this->session->userdata('user_id')?0:1,
                      'first_name' => $this->input->post('first_name'),
                      'last_name' => $this->input->post('last_name'),
                      'country' => $this->input->post('country'),
                      'address' => $this->input->post('address'),
                      'landmark' => $this->input->post('landmark'),
                      'city' => $this->input->post('city'),
                      'state' => $this->input->post('state'),
                      'zipcode' => $this->input->post('zipcode'),
                      'mobile' => $this->input->post('mobile'),
                      'email'=>$this->input->post('email'),
                      'address_type' => 'Bill'
                        );
                        $addressIDs = $this->cart_model->safe_insert('wps_customers_address_book', $addressData);
              
              
                     $addressData = array(
                      'customer_type' => $this->session->userdata('user_id')?0:1,
                      'first_name' => $this->input->post('ship_first_name'),
                      'last_name' => $this->input->post('ship_last_name'),
                      'country' => $this->input->post('ship_country'),
                      'address' => $this->input->post('ship_address'),
                      'landmark' => $this->input->post('ship_landmark'),
                      'city' => $this->input->post('ship_city'),
                      'state' => $this->input->post('ship_state'),
                      'zipcode' => $this->input->post('ship_zipcode'),
                      'mobile' => $this->input->post('ship_mobile'),
                      'email'=>$this->input->post('ship_email'),
                      'address_type' => 'Ship'
                        );
                    $addressIDs = $this->cart_model->safe_insert('wps_customers_address_book', $addressData);
                  }
                  
                  
                //  make order start 
                  
                  
                //   get wallet amount
                    
                    
                  $wallet_coin_use=0;
                  if($this->session->userdata('remain_coin')!==null)
                  {
                      $wallet_coin_use=$this->session->userdata('remain_coin');
                  }
              
                   
                // end of get wallet amount
                  
                  $invoice_number= "INV_" . get_auto_increment('wps_order');
				  $odr_number= get_auto_increment('wps_order');
                  //$ship_method = 'none';
                 
                  $userId = $this->session->userdata('user_id')?$this->session->userdata('user_id'):0;
                  $invoice_number = "INV" . get_auto_increment('wps_order');
                  $coupon_id = $this->session->userdata('coupon_id');
                  $discount_amount = round($this->session->userdata('discount_amount'));
                  $currency_code = $this->session->userdata('currency_code');
                  $currency_value = $this->session->userdata('currency_value');
                  $customers_id = ( $userId != '') ? $userId : 0;
                  $cart_total = $this->cart->total();  
                  $ship_method = 'none';
                  
                
                  $deliveryCharge = delivery_charge(0,$cart_total);
                  $gst = gst($cart_total);
                  $ship_amount = $deliveryCharge; //$costumer_data['shipping_amount'];
            
                  $cart_total = round(($ship_amount + $cart_total) - ($discount_amount+$wallet_coin_use));
          
                    // `order_id`, `customers_id`, `invoice_number`, `customer_type`, `vendor_id`, `first_name`, `last_name`, `phone`, `mobile`, `email`, `billing_title`, `billing_name`, `billing_address`, `billing_landmark`, `billing_phone`, `billing_fax`, `billing_zipcode`, `billing_country`, `billing_state`, `billing_city`, `shipping_title`, `shipping_name`, `shipping_address`, `shipping_landmark`, `shipping_phone`, `shipping_fax`, `shipping_zipcode`, `shipping_country`, `shipping_state`, `shipping_city`, `last_shopping_comment`, `shipping_method`, `discount_coupon_id`, `coupon_discount_amount`, `shipping_amount`, `total_amount`, `previous_cart_total`, `vat_amount`, `vat_applied_cent`, `cod_amount`, `idcard_no`, `pickup_point`, `currency_code`, `currency_value`, `order_status`, `order_received_date`, `expected_delivery_date`, `order_delivery_date`, `order_status_time`, `total_discounted_price`, `order_confirmed_date`, `order_dispatched_date`, `order_in_transit_date`, `order_out_for_delivery_date`, `order_cancelled_date`, `order_returned_date`, `order_request_for_return_date`, `reason_for_return`, `payment_method`, `courier_company_id`, `courier_partner`, `tracking_code`, `tracking_text`, `payment_status`, `paymentResponse`, `added_by               
                    // echo $cart_total;die;
                  
                  
               $data_order = array(
                  'customer_type' =>     $this->session->userdata('user_id')?0:1,
                  'customers_id'   =>    $this->session->userdata('user_id') ?$this->session->userdata('user_id') :0,
                  'invoice_number' =>    $invoice_number ,
                  'first_name' =>        $this->input->post('first_name'),
                  'last_name' =>         $this->input->post('last_name'),
                  'email' =>             $this->input->post('email'),
                  'billing_name' =>      $this->input->post('first_name').' '.$this->input->post('last_name'),
                  'billing_phone' =>     $this->input->post('mobile'),
                  'billing_address' =>   $this->input->post('address'),
                  'billing_landmark' =>  $this->input->post('landmark'),
                  'billing_zipcode' =>   $this->input->post('zipcode'),
                  'billing_country' =>   $this->input->post('country'),
                  'billing_city' =>      $this->input->post('city'),
                  'billing_state' =>     $this->input->post('state'),
                  'shipping_name' =>     $this->input->post('ship_first_name').' '.$this->input->post('ship_last_name'),
                  'shipping_phone' =>    $this->input->post('mobile'),
                  'shipping_address' =>  $this->input->post('ship_address'),
                  'shipping_landmark'=>  $this->input->post('ship_landmark'),
                  'shipping_zipcode' =>  $this->input->post('ship_zipcode'),
                  'shipping_country' =>  $this->input->post('ship_country'),
                  'shipping_state' =>    $this->input->post('ship_state'),
                  'shipping_city' =>     $this->input->post('ship_city'),
                //   'last_shopping_comment' => $costumer_data['last_shopping_comment'],
                  'shipping_method' => $ship_method,
                  'discount_coupon_id' => $coupon_id,
                  'coupon_discount_amount' => $discount_amount,
                  'shipping_amount' => $ship_amount,
                //'cod_amount' => $costumer_data['cod_amount'],
                  'total_amount' => $cart_total,
                  'vat_amount' => $gst,
                  'vat_applied_cent' => '',
                  'currency_code' => $currency_code,
                  'currency_value' => $currency_value,
                  'order_status' => '0',
                  'order_received_date' => $this->config->item('config.date.time'),
                  'payment_method' => $this->input->post('payment_method'),
                  'payment_status' => 'Unpaid',
                  'wallet_coin_use' => $wallet_coin_use,
                  );  
                  
                //   order product wise
                
                
                
                
                  $mmm=[];
                  $full_name=  $this->input->post('first_name').' '.$this->input->post('last_name');
                  $full_name_shipping=$this->input->post('ship_first_name').' '.$this->input->post('ship_last_name');
                
                
                
                
                
                
                  if (!$this->cart_model->is_order_no_exits($invoice_number))
                      {
                        $orderId = $this->cart_model->safe_insert('wps_order', $data_order, FALSE);
                        
                      
                        
                        
                        $this->session->set_userdata(array('working_order_id' => $orderId));
                        foreach ($this->cart->contents() as $items) 
                        {
                            $thumbc['width'] = 195;
                            $thumbc['height'] = 150;
                            $thumb_name = "thumb_" . $thumbc['width'] . "_" . $thumbc['height'] . "_" . $items['img'];
                            $image_file = IMG_CACH_DIR . "/" . $thumb_name;
                            $default_no_img = FCROOT . "assets/designer/themes/default/images/noimage.jpg";
                            $file_data = ( file_exists($image_file) ) ? file_get_contents($image_file) : file_get_contents($default_no_img);
                            
                            //$vendor_id=$this->getvendoridByprodId($items['pid']);
                            
							$sub_order_id = $orderId.'-'.$items['vendor_id'];
							
                            $data = array(
                                'order_id' => $orderId,
								'sub_order_id' => $sub_order_id,
                                'vendor_id'=>$items['vendor_id'],
                                'products_id' => $items['pid'],
                                'product_name' => $items['origname'],
                                'product_code' => $items['code'],
                                'product_image' => $file_data,
                                'product_image_name' => $items['img'],
                                'product_price' => $items['price'],
                                'quantity' => $items['qty'],
                                'color_id' => @$items['options']['Color'],
                                'size_id' => @$items['options']['Size'],
                                'gst' =>  $gst = gst($items['price']),
                                'product_size' => '',
                                'discount_id' => 0,
                                'special_offer_id' => 0,
                                'shipping_charges' => '0',
                            );
                            $order_product_id   =  $this->cart_model->safe_insert('wps_orders_products', $data, FALSE);
                            
                            // coin wallet
                        //  SELECT `id`, `user_id`, `order_product_id`, `debit_amount`, `credit_amount`, `earn coin`, `cr_dr`, `status`, `created_at`, `updated_at`    
                            $coin_data=array(
                                                'user_id'=>$this->session->userdata('user_id') ?$this->session->userdata('user_id') :0,
                                                'order_id'=>$orderId,
                                                'order_product_id'=>$order_product_id,
                                                'product_id'=>$items['pid'],
                                                'debit_amount'=>0,
                                                'credit_amount'=>round($items['price']*$items['qty']),
                                                'earn_coin'=>round((($items['price']*$items['qty'])*3)/100),
                                                'cr_dr'=>'cr',
                                                'status'=>'1',
                                                'created_at'=>date('Y-m-d H:i:s'),
                                                'updated_at'=>date('Y-m-d H:i:s'),
                                            );
                             $this->cart_model->safe_insert('user_wallet_trans', $coin_data, FALSE);
                             
                            //  end of add row into wallet
                            
                            // start deduct from walet
                             if($wallet_coin_use>0)
                             {
                                $coin_data=array(
                                                'user_id'=>$this->session->userdata('user_id') ?$this->session->userdata('user_id') :0,
                                                'order_id'=>$orderId,
                                                'order_product_id'=>$order_product_id,
                                                'product_id'=>$items['pid'],
                                                'debit_amount'=>0,
                                                'credit_amount'=>0,
                                                'earn_coin'=>$wallet_coin_use,
                                                'cr_dr'=>'dr',
                                                'status'=>'1',
                                                'created_at'=>date('Y-m-d H:i:s'),
                                                'updated_at'=>date('Y-m-d H:i:s'),
                                            );
                                $this->cart_model->safe_insert('user_wallet_trans', $coin_data, FALSE);
                             }
                            // end of coin wallet
                            
                            
                             
                            
                            
                            // Ship Rocket
                            
                            
                          
                            
                            
                            $mmm[]=array('name'=>$items['origname'],'sku'=> $items['code'],'units'=> $items['qty'],
                                        'selling_price'=>$items['price'],'discount'=>"",'tax'=>'','hsn'=>1234); 
                            
                            
                              
                           
                        }
                        
                        
                        
                        
                        
                        
                        //$this->sent_user_order_success_email($this->input->post('email'),$orderId);
                        $user_id = $this->session->userdata('user_id');
                        $this->cart->destroy();
                        $data = array('shipping_id' => 0, 'coupon_id' => 0, 'discount_amount' => 0, 'posted_data' => 0, 'is_same_bill_ship' => 0);
                        $this->session->unset_userdata($data);
                        $this->session->unset_userdata('coupon_id');
                        $this->session->unset_userdata('discount_amount');
                        $this->session->unset_userdata('posted_data');
                        $this->session->unset_userdata('is_same_bill_ship');
                        $this->session->unset_userdata('remain_coin');
                         
                         
                         
                         
                         
                         
                 

 
/*
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://clbeta.ecomexpress.in/services/expp/manifest/v2/expplus/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('username' => 'HEYWANSAASOLUTIONANDSERVICESLLP_811931','password' => 'hrLZwRATaT12MNk','json_input' => '[{
	"AWB_NUMBER": "1119143590534",
	"ORDER_NUMBER": "ORD-90362418",
	"PRODUCT": "COD",
	"CONSIGNEE": "Test shipment do not ship",
	"CONSIGNEE_ADDRESS1": "Test shipment",
	"CONSIGNEE_ADDRESS2": "Test shipment",
	"CONSIGNEE_ADDRESS3": "Test shipment",
	"DESTINATION_CITY": "Bijapur",
	"STATE": "Chhattisgarh",
	"PINCODE": "122012",
	"TELEPHONE": "9560350578",
	"MOBILE": "9560350578",
	"RETURN_NAME": "Test shipment",
	"RETURN_MOBILE": "9560350578",
	"RETURN_PINCODE": "110037",
	"RETURN_ADDRESS_LINE1": "Test shipment",
	"RETURN_ADDRESS_LINE2": "Test shipment",
	"RETURN_PHONE": "9560350578",
	"PICKUP_NAME": "Test shipment",
	"PICKUP_PINCODE": "110037",
	"PICKUP_MOBILE": "9560350578",
	"PICKUP_PHONE": "9560350578",
	"PICKUP_ADDRESS_LINE1": "Test shipment",
	"PICKUP_ADDRESS_LINE2": "Test shipment",
	"COLLECTABLE_VALUE": "1",
	"DECLARED_VALUE": "1",
	"ITEM_DESCRIPTION": "Test shipment",
	"DG_SHIPMENT": "false",
	"PIECES": 1,
	"HEIGHT": "1",
	"BREADTH": "1",
	"LENGTH": "1",
	"VOLUMETRIC_WEIGHT": 0,
	"ACTUAL_WEIGHT": 0.5,
	"ADDITIONAL_INFORMATION": [{}],
	"GST_TAX_RATE_SGSTN": 0,
	"GST_TAX_IGSTN": 179.82,
	"DISCOUNT": 0,
	"GST_TAX_RATE_IGSTN": 18,
	"GST_TAX_BASE": 1,
	"GST_TAX_SGSTN": 0,
	"INVOICE_DATE": "2022-08-18",
	"SELLER_GSTIN": "36XXX1230X1X6",
	"GST_TAX_RATE_CGSTN": 0,
	"GST_HSN": "33049990",
	"GST_TAX_NAME": "CHHATTISGARHGST",
	"INVOICE_NUMBER": "12-903624",
	"GST_TAX_TOTAL": 1,
	"GST_TAX_CGSTN": 0,
	"GST_ERN": "123456789012",
	"ITEM_CATEGORY": "SKINCARE",
	"ESSENTIAL_PRODUCT": "N",
	"CONSIGNEE_LAT": "22.22",
	"CONSIGNEE_LONG": "44.56"
}]'),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
                        
    die;  */                
                      /*   
                         
                          $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/create/adhoc",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>'
                {
                  "order_id": "'.$invoice_number.'",
                  "order_date": "'.date("Y-m-d h:i:sa").'",
                  "pickup_location": "Heywansa",
                  "billing_customer_name": "'.$full_name.'",
                  "billing_last_name": "'.$this->input->post('last_name').'",
                  "billing_address": "'. $this->input->post('address').'",
                  "billing_address_2": "'.$this->input->post('landmark').'",
                  "billing_city": "'. $this->input->post('city').'",
                  "billing_pincode": "'.$this->input->post('zipcode').'",
                  "billing_state": "'.$this->input->post('state').'",
                  "billing_country": "'.$this->input->post('country').'",
                  "billing_email": "'.$this->input->post('email').'",
                  "billing_phone": "'.$this->input->post('mobile').'",
                  "shipping_is_billing": true,
                  "shipping_customer_name": "'.$full_name_shipping.'",
                  "shipping_last_name": " ",
                  "shipping_address": "'. $this->input->post('ship_address').'",
                  "shipping_address_2": "'.$this->input->post('ship_landmark').'",
                  "shipping_city": "'. $this->input->post('ship_city').'",
                  "shipping_pincode": "'.$this->input->post('ship_zipcode').'",
                  "shipping_country": "'.$this->input->post('ship_country').'",
                  "shipping_state": "'.$this->input->post('ship_state').'",
                  "shipping_email": "'.$this->input->post('email').'",
                  "shipping_phone": "'.$this->input->post('mobile').'",
                  "order_items": '.json_encode($mmm).',
                  "payment_method": "'.$ship_method.'",
                  "shipping_charges": 0,
                  "giftwrap_charges": 0,
                  "transaction_charges": 0,
                  "total_discount": 0,
                  "sub_total": '.$cart_total.',
                  "length": 1,
                  "breadth": 1,
                  "height": 1,
                  "weight": "5"
                }',
                CURLOPT_HTTPHEADER => array(
                  "Content-Type: application/json",
                   "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEzOTIwOTYsImlzcyI6Imh0dHBzOi8vYXBpdjIuc2hpcHJvY2tldC5pbi92MS9leHRlcm5hbC9hdXRoL2xvZ2luIiwiaWF0IjoxNjYzMDU1Njc1LCJleHAiOjE2NjM5MTk2NzUsIm5iZiI6MTY2MzA1NTY3NSwianRpIjoicDZlWEFxWmVjWVhsZEh0NSJ9.hUPhoB7au2fgSVkBvkgo4S32oWlqBCB1mtXdSehJDgc"
                ),
              ));
                */
                
        // uncomment below 2 line for run curl api for shiprocket 
            //   $SR_login_Response = curl_exec($curl);
            //   curl_close($curl);
              
              
              
                //   $SR_login_Response_out = json_decode($SR_login_Response);               
                         
                //   echo "<pre>";
                //     print_r($SR_login_Response_out); 
                    
                    
                //     print_r($mmm);
                //     die;    
                         
                         
                         
                         
                         
                         
                         
                         
                        if($this->input->post('payment_method')=='online') 
                        {
                            $characters = '0123456789/abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                            $charactersLength = strlen($characters);
                            $randomString = '';
                            for ($i = 0; $i < 400; $i++)
                            {
                                $randomString .= $characters[rand(0, $charactersLength - 1)];
                            }
							
						 
				  
							$description = "Products Order";
							$card_holder_name = $this->input->post('first_name')." ".$this->input->post('last_name');
							$email = $this->input->post('email');
							$phone = $this->input->post('mobile');
							
                             //redirect(base_url().'payment/paybyrazorpay/'.$randomString.'/'.$this->encrypt_decrypt("encrypt", $invoice_number).'/'.$randomString);
							 redirect(base_url().'payment/paybyrazorpay/'.$this->encrypt_decrypt("encrypt", $invoice_number.'#'.$odr_number.'#'.$cart_total.'#'.$description.'#'.$card_holder_name.'#'.$email.'#'.$phone));
						 	 
						 	 
                        }
                        else
                        {
						
                             redirect(base_url().'payment/thanks/'."INV".'-'.$invoice_number.'-'.'W8RY9T2TANK');
                        }
                         
                          
                         
                      }
                      else
                      {
                          echo "1";
                      }
                  
            
      }
      else
      {
          // echo "00";
          $errors = $this->form_validation->error_array();
          print_r($errors);
      }
                
    
      
      
  }
public function encrypt_decrypt($action, $string) 
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = '5d5fs5d1sd1f21sd21';
        $secret_iv = '2dsf8sdfs25e2sdf21s';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
    
        if( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' )
        {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
  public function make_payment() 
  {
    if (!$this->cart->total_items() > 0) {
      redirect('home');
    }
    $posted_data = $this->session->userdata('posted_data');
    $data['posted_data'] = $posted_data;
    $data['mtitle'] = $this->config->item('titleArray');
    if (is_array($posted_data) && !empty($posted_data) && $this->cart->total_items() > 0 && $this->input->get_post('pay') != '') {
      $posted_data['cod_amount'] = 0.00;
      $costumer_data['shipping_amount'] = 0.00;
      
      
      // if ($this->input->get_post('pay') == 'COD') {
      //   $posted_data['cod_amount'] = '0.00';
      // }
      // if ($posted_data['country'] != 'India') {
      //   $posted_data['shipping_amount'] = '0.00';
      // }
      
      
      $posted_data['payment_mode'] = $this->input->get_post('pay');

      $this->add_customer_order($posted_data, $this->session->userdata('is_same_bill_ship'));

      $this->session->unset_userdata('posted_data');
      $this->session->unset_userdata('email');
      $this->session->unset_userdata('is_same_bill_ship');


      $orderID = $this->session->userdata('working_order_id');

      //Mailer to Admin for Order Initiated
      $ordmaster = $this->order_model->get_order_master($orderID);
      $orddetail = $this->order_model->get_order_detail($orderID);
      $bodyAdmin = invoice_content_print($ordmaster, $orddetail, $type='admin');
      $mailContentHtmlAdminC = ob_get_contents();
      $mail_conf_admin_c = array(
          'subject' => 'Order #' . $ordmaster['invoice_number'] . ' Initiated - Weblieu',
          'to_email' => 'info@weblieu.com', //
          'from_email' => $ordmaster['email'],
          'from_name' => $this->config->item('site_name'),
          'body_part' => $mailContentHtmlAdminC
      );
      //trace($mail_conf_admin_c); die;
      //$this->dmailer->mail_notify($mail_conf_admin_c);
      ob_clean();
      //Mailer End Here


      $payMode = $this->input->get_post('pay');
      if ($payMode == "Payu") {
        $working_order_id = $this->session->userdata('working_order_id');
        $order_res = $this->order_model->get_order_master($working_order_id);
        $this->load->view('view_payu_form');
        //payuForm($order_res);
      } else {
        redirect('payment?pay_method=' . $this->input->get_post('pay'));
      }
    }

    $this->load->view('view_make_payment', $data);
  }

  private function add_customer_order($costumer_data = array(), $is_same_bill_ship) {
    if ($this->cart->total_items() > 0) 
    {
      $userId = $this->session->userdata('user_id');
      $invoice_number = "INV" . get_auto_increment('wps_order');
      $coupon_id = $this->session->userdata('coupon_id');
      $discount_amount = $this->session->userdata('discount_amount');
      $currency_code = $this->session->userdata('currency_code');
      $currency_value = $this->session->userdata('currency_value');
      $customers_id = ( $userId != '') ? $userId : 0;
      
      
      print_r($customers_id);die;
      
      
      $cart_total = $this->cart->total();

      $ship_method = 'none';
      
      $deliveryCharge = delivery_charge(0,$cart_total);
      $gst = gst($cart_total);
      $ship_amount = $deliveryCharge; //$costumer_data['shipping_amount'];

      $cart_total = ($ship_amount + $cart_total) - $discount_amount;

      $data_order = array(
          'customers_id' => $customers_id,
          'invoice_number' => $invoice_number,
          'first_name' => $costumer_data['name'],
          'last_name' => '',
          'email' => $this->session->userdata('username'),
          'billing_title' => $costumer_data['bmtitle'],
          'billing_name' => $costumer_data['bil_name'],
          'billing_phone' => $costumer_data['bil_mobile'],
          'billing_address' => $costumer_data['bil_address'],
          'billing_landmark' => $costumer_data['bil_landmark'],
          'billing_zipcode' => $costumer_data['bil_zipcode'],
          'billing_country' => $costumer_data['bil_country'],
          'billing_city' => $costumer_data['bil_city'],
          'billing_state' => $costumer_data['bil_state'],
          'shipping_title' => $costumer_data['mtitle'],
          'shipping_name' => $costumer_data['name'],
          'shipping_phone' => $costumer_data['mobile'],
          'shipping_address' => $costumer_data['address'],
          'shipping_landmark' => $costumer_data['landmark'],
          'shipping_zipcode' => $costumer_data['zipcode'],
          'shipping_country' => $costumer_data['country'],
          'shipping_state' => $costumer_data['state'],
          'shipping_city' => $costumer_data['city'],
          'last_shopping_comment' => $costumer_data['last_shopping_comment'],
          'shipping_method' => $ship_method,
          'discount_coupon_id' => $coupon_id,
          'coupon_discount_amount' => $discount_amount,
          'shipping_amount' => $ship_amount,
          'cod_amount' => $costumer_data['cod_amount'],
          'total_amount' => $cart_total,
          'vat_amount' => $gst,
          'vat_applied_cent' => '',
          'currency_code' => $currency_code,
          'currency_value' => $currency_value,
          'order_status' => '0',
          'order_received_date' => $this->config->item('config.date.time'),
          'payment_method' => $costumer_data['payment_mode'],
          'payment_status' => 'Unpaid'
      );
      if (!$this->cart_model->is_order_no_exits($invoice_number))
      {
        $orderId = $this->cart_model->safe_insert('wps_order', $data_order, FALSE);
        $this->session->set_userdata(array('working_order_id' => $orderId));
        foreach ($this->cart->contents() as $items) {
            $thumbc['width'] = 195;
            $thumbc['height'] = 150;
            $thumb_name = "thumb_" . $thumbc['width'] . "_" . $thumbc['height'] . "_" . $items['img'];
            $image_file = IMG_CACH_DIR . "/" . $thumb_name;
            $default_no_img = FCROOT . "assets/designer/themes/default/images/noimage.jpg";
            $file_data = ( file_exists($image_file) ) ? file_get_contents($image_file) : file_get_contents($default_no_img);
            $data = array(
                'order_id' => $orderId,
                'products_id' => $items['pid'],
                'product_name' => $items['origname'],
                'product_code' => $items['code'],
                'product_image' => $file_data,
                'product_image_name' => $items['img'],
                'product_price' => $items['price'],
                'quantity' => $items['qty'],
                'color_id' => @$items['options']['Color'],
                'size_id' => @$items['options']['Size'],
                'gst' => '0',
                'product_size' => '',
                'discount_id' => 0,
                'special_offer_id' => 0,
                'shipping_charges' => '0',
            );
            $this->cart_model->safe_insert('wps_orders_products', $data, FALSE);
        }
        $user_id = $this->session->userdata('user_id');
        $this->cart->destroy();
        $data = array('shipping_id' => 0, 'coupon_id' => 0, 'discount_amount' => 0, 'posted_data' => 0, 'is_same_bill_ship' => 0);
        $this->session->unset_userdata($data);
        $this->session->unset_userdata('coupon_id');
        $this->session->unset_userdata('discount_amount');
        $this->session->unset_userdata('posted_data');
        $this->session->unset_userdata('is_same_bill_ship');
      }
      
    }
   
  }

  public function add_to_cart() {
    $this->add_cart();
  }

  private function add_cart() {
    $productId =  $this->input->post('product_id');
    $color = $this->input->post('color_id');
    $size = $this->input->post('size_id');
    $qty = ($this->input->post('qty') > 0) ? $this->input->post('qty') : 1;
    
    $option = array('productid' => $productId);
    $pres = $this->product_model->get_products(1, 0, $option);
    $pres = $pres[0];
    $res_base_price = array();
    $prod_option = array('Size' => $size, 'Color' => $color);
    $bulkDiscountedPrice = $pres['product_discounted_price'];
    $product_price = $pres['product_price'];
    $media = $pres['media'];
   
    $res_base_price['bulkDiscountedPrice'] = $bulkDiscountedPrice;
    $res_base_price['product_price'] = $product_price;
    if(isset($color) && isset($size))
    {
      $res = $this->db->select('quantity,product_price,discounted_price')->get_where('product_variant', array('color_id' => $color, 'size_id' => $size, 'product_id' => $productId))->row();
      if (is_object($res)) {
        $res_base_price['bulkDiscountedPrice'] = $res->discounted_price;
        $res_base_price['product_price'] = $res->product_price;
        $res_base_price['quantity'] = $res->quantity;
      }
    }
    
    
    
    elseif(isset($color) && empty($size)){
      $res = $this->db->select('quantity,product_price,discounted_price')->get_where('product_variant', array('color_id' => $color,'product_id' => $productId))->row();
      if (is_object($res)) {
        $res_base_price['bulkDiscountedPrice'] = $res->discounted_price;
        $res_base_price['product_price'] = $res->product_price;
        $res_base_price['quantity'] = $res->quantity;
      }
    }
    elseif(empty($color) && isset($size)){
      $res = $this->db->select('quantity,product_price,discounted_price')->get_where('product_variant', array('size_id' => $size,'product_id' => $productId))->row();
      if (is_object($res)) {
        $res_base_price['bulkDiscountedPrice'] = $res->discounted_price;
        $res_base_price['product_price'] = $res->product_price;
        $res_base_price['quantity'] = $res->quantity;
      }
    }
    
    
    
    
    else{
       $res_base_price['quantity'] = $pres['product_qty'];
    }
    $cart_price = ($res_base_price['bulkDiscountedPrice'] > 0) ? $res_base_price['bulkDiscountedPrice'] : $res_base_price['product_price'];

    if ((is_array($pres) && !empty($pres)) && (is_array($res_base_price) && !empty($res_base_price))) {
      $cart_price = ((int) $res_base_price['bulkDiscountedPrice'] > 0) ? $res_base_price['bulkDiscountedPrice'] : $res_base_price['product_price'];
      $is_exits_inot_cart = $this->check_product_exits_into_cart($pres);
     
      if ($is_exits_inot_cart == 1) 
      {
        // $this->session->set_userdata(array('msg_type' => 'success'));
        // $this->session->set_flashdata('success', 'Product already exists to cart.');
        // redirect($_SERVER['HTTP_REFERER'], 'refresh');
        
        
             $responce=array('status'=>false,'data'=>'already-exist','msg'=>"'Product already exists to cart.");
             echo json_encode($responce); 
             die;
        
      } 
      else 
      {
        $availableqty = $res_base_price['quantity'];
        $cart_data = array(
            'id' => random_string('numeric', 6),
            'qty' => $qty,
            'availableqty' => $availableqty,
            'price' => $cart_price,
            'product_price' => $res_base_price['product_price'],
            'discount_price' => $res_base_price['bulkDiscountedPrice'],
            'name' => url_title($pres['product_name']),
            'origname' => $pres['product_name'],
            'pid' => $pres['products_id'],
			'vendor_id' => $pres['vendor_id'],
            'img' => $media,
            'code' => $pres['product_code'],
            'options' => $prod_option
        );
        
        
        
        //re calculate coupon
        if ($this->session->userdata('coupon_id') != '' && $this->session->userdata('discount_amount') > 0) 
        {
          $this->reApplycoupon($this->session->userdata('coupon_id'));
        }
        
       if($this->cart->insert($cart_data))
        {
             $responce=array('status'=>true,'data'=>'added','msg'=>"Product has been added to cart.");
             echo json_encode($responce); 
             die;
        }
        else
        {
             $responce=array('status'=>false,'data'=>'','msg'=>"Not Added into Cart");
             echo json_encode($responce); 
             die;
        }
        
        
        
        // $this->session->set_userdata(array('msg_type' => 'success'));
        // $this->session->set_flashdata('success', 'Product has been added to cart.');
        // redirect('cart', 'refresh');
        // redirect($_SERVER['HTTP_REFERER'], 'refresh');
      }
    }
    else 
    {
      redirect("home");
    }
  }

 

  public function check_product_exits_into_cart($pres) {
    $cart_array = $this->cart->contents();
    $insert_flag = 0;
    if (is_array($cart_array) && !empty($cart_array)) {
      foreach ($this->cart->contents() as $item) {
        if (array_key_exists('pid', $item)) {
          if ($item['pid'] == $pres['products_id']) {
            $insert_flag = 1;
          }
        }
      }
    }
    return $insert_flag;
  }

  public function empty_cart() {
    $this->cart->destroy();
    $data2 = array(
        'shipping_id' => 0,
        'coupon_id' => 0,
        'discount_amount' => 0
    );
    $this->session->unset_userdata($data2);
    redirect('cart');
  }

  public function remove_item() {
    $data = array(
        'rowid' => $this->uri->segment(3),
        'qty' => 0
    );
    $this->cart->update($data);
    if ($this->cart->total_items() == 0) {
      //$this->session->unset_userdata(array('coupon_id' => 0, 'discount_amount' => 0));
      $this->session->unset_userdata('coupon_id');
      $this->session->unset_userdata('discount_amount');
    } else {
      //re calculate coupon
      if ($this->session->userdata('coupon_id') != '' && $this->session->userdata('discount_amount') > 0) {
        $this->reApplycoupon($this->session->userdata('coupon_id'));
      }
    }
    $this->session->set_userdata(array('msg_type' => 'success'));
    $this->session->set_flashdata('success', $this->config->item('cart_delete_item'));
    redirect($_SERVER['HTTP_REFERER'], 'refresh');
  }

  public function update_cart_qty() {

    $cart = $this->cart->contents();
    for ($i = 1; $i <= count($cart); $i++) {
      $item = $this->input->post($i);
      $cart_id = $item['rowid'];
      if ($item['qty'] <= 0) 
      {
        $res = array('error_type' => 'error', 'error_msg' => "Can not update less then 0");
      } 
      elseif (1000 >= $item['qty']) 
      {
        $data = array(
            'rowid' => $item['rowid'],
            'qty' => $item['qty'],
        );
        
        $this->cart->update($data);
        $res = array('error_type' => 'pass', 'error_msg' => $this->config->item('cart_quantity_update'));
      }
      else 
      {
        $res = array('error_type' => 'error', 'error_msg' => "Can not update more then available quantity");
      }
    }
    //re calculate coupon
    if ($this->session->userdata('coupon_id') != '' && $this->session->userdata('discount_amount') > 0) {
      $this->reApplycoupon($this->session->userdata('coupon_id'));
    }
    echo json_encode($res);
  }

  public function count_cart_item() {
    return $this->cart->total_items();
  }

  public function cart_total_amount() {
    $total = $this->cart->total();
    return $total;
  }

  public function display_cart_image($orders_products_id) {
    $binary_data = get_db_field_value('wps_orders_products', 'product_image', array('orders_products_id' => $orders_products_id));
    header("Content-Type: image/jpeg");
    echo $binary_data;
  }

  public function applycoupon() {
          $coupon_code = $this->input->get_post('couponcode');
          $amt = $this->input->get_post('amt');
          //AND minimum_amount_for_coupan_apply <= '" . $amt . "'
          $cdets = get_db_single_row('wps_discount_coupans', "cpn_id, cpn_type, cpn_code, cpn_rate, cpn_start_date, cpn_end_date", "cpn_start_date <= '" . date('Y-m-d') . "' AND cpn_end_date >= '" . date('Y-m-d') . "' AND cpn_code = '" . $coupon_code . "' AND minimum_amount_for_coupan_apply <= '" . $amt . "'");
        //   print_r($this->db->last_query());die;
          if (is_array($cdets) && !empty($cdets)) 
          {
            if ($cdets['cpn_type'] == '0') 
            {
              $discount = "";
              $discount = $cdets['cpn_rate'];
              $this->session->set_userdata('discount_amount', $discount);
              $this->session->set_userdata('coupon_id', $cdets['cpn_id']);
            } 
            else 
            {
              //check content of cart 
              $discountAmt = 0;
              foreach ($this->cart->contents() as $items) {
                $pprice = ($items['discount_price'] > 0) ? $items['discount_price'] : $items['product_price'];
                $discount = (($pprice * $items['qty']) * $cdets['cpn_rate'] / 100);
                $discountAmt += $discount;
              }
              //echo $discountAmt;
              $this->session->set_userdata('coupon_id',  $cdets['cpn_id']);
              $this->session->set_userdata('discount_amount', $discountAmt);
              //print_r($this->session->userdata('discount_amount'));
            }
            echo "Coupon Applied Successfully!";
          }
          else 
          {
            echo "Invalid or Expired Coupon!";
          }
    
 
  }

  public function reApplycoupon($couponid) {
    $COUPONCODE = get_db_single_row('wps_discount_coupans', "cpn_code", "cpn_id = '" . $couponid . "'");
    $totalAmount = '';
    $cart = $this->cart->contents();
    foreach ($cart as $items) {
      $pprice = ($items['discount_price'] > 0) ? $items['discount_price'] : $items['product_price'];
      $totalAmount += ($pprice * $items['qty']);
    }

    $cdets = get_db_single_row('wps_discount_coupans', "cpn_id, cpn_type, cpn_code, cpn_rate, cpn_start_date, cpn_end_date", "cpn_start_date <= '" . date('Y-m-d') . "' AND cpn_end_date >= '" . date('Y-m-d') . "' AND cpn_code = '" . $COUPONCODE['cpn_code'] . "' AND minimum_amount_for_coupan_apply <= '" . $amt . "'");
    //echo_sql();
    if (is_array($cdets) && !empty($cdets)) {
      if ($cdets['cpn_type'] == '0') {
        $discount = "";
        $discount = $cdets['cpn_rate'];
        $this->session->set_userdata('discount_amount', $discount);
        $this->session->set_userdata('coupon_id', $cdets['cpn_id']);
      } else {
        //check content of cart
        $discountAmt = 0;
        foreach ($this->cart->contents() as $items) {
          $pprice = ($items['discount_price'] > 0) ? $items['discount_price'] : $items['product_price'];
          $discount = (($pprice * $items['qty']) * $cdets['cpn_rate'] / 100);
          $discountAmt += $discount;
        }
        $this->session->set_userdata('coupon_id', $cdets['cpn_id']);
        $this->session->set_userdata('discount_amount', round($discountAmt));
      }
      //echo "Coupon Applied Successfully!";
    } else {
      $this->session->unset_userdata('coupon_id');
      $this->session->unset_userdata('discount_amount');
    }
  }

  public function removecoupon() {
    $couponData = array(
        'coupon_id' => 0,
        'discount_amount' => 0
    );
    $this->session->unset_userdata('coupon_id');
    $this->session->unset_userdata('discount_amount');
    echo 'Coupon Removed Successfully!';
  }

  public function add_to_wishlist() {
    $product_id = (int) $this->uri->segment(3);

    //trace($category_id);
    if ($this->session->userdata('user_id') > 0) {
      $this->cart_model->add_wislists($product_id, $this->session->userdata('user_id'));
      redirect('members/mywishlist');
    } else {
      redirect('login');
    }
  }

  public function print_invoice() {
    $this->load->model(array('order/order_model'));
    $ordId = $this->uri->segment(3, $this->session->userdata('working_order_id'));
    $order_res = $this->order_model->get_order_master($ordId);
    $order_details_res = $this->order_model->get_order_detail($order_res['order_id']);
    $data['orddetail'] = $order_details_res;
    $data['ordmaster'] = $order_res;
    $data['ordId'] = $ordId;
    $this->load->view('view_invoice_print', $data);
  }
  
  public function getvendoridByprodId($prod_id=121)
  {
      $prod_details=$this->db->query("SELECT * from wps_products where products_id=$prod_id")->result_array();
      $prod_details=$prod_details[0];
      return $prod_details['vendor_id'];
  }
  
  public function sent_user_order_success_email($useremail='info@weblieu.com',$order_id=44)
  {
    $email          =   EMAILEMAIL;
    $password       =   EMAILPASSWORD;
    $from_email     =   $email;
    $to_email       =   $useremail;
    $html='';
    $orderData              =   $this->db->query("SELECT * FROM `wps_order` where order_id='$order_id'")->result_array()[0];
    $order_details_product  =   $this->db->query("SELECT * FROM `wps_orders_products` where order_id='$order_id'")->result_array();
    
    $html.='<html><head><title></title></head><body>';
    $html.='<h1>Your Order Placed Successfully!</h1>';
    // $html.='<p>Your order successfull placed for the vendor Please wait for vendor confirmation</p>';
    $html.='<p>Order Details are below: </p>';
    
    $html.='<table style="width:100%;border:1px solid black;border-collapse: collapse;">';
    $html.='<thead>';
   
    $html.='<tr style="width:100%;border:1px solid black;border-collapse: collapse;">';
    $html.='<th style="width:50%;border:1px solid black;border-collapse: collapse; text-align:left">Product</th>
            <th style="width:10%;border:1px solid black;border-collapse: collapse; text-align:center">Quantity</th>
            <th style="width:20%;border:1px solid black;border-collapse: collapse;">GST Amount</th>
            <th style="width:20%;border:1px solid black;border-collapse: collapse;">Total Amount</th>';
    $html.='</tr>';
    
    
    $html.='</thead>';
    $html.='<tbody>';
    $total_amount=0;
    $total_gst=0;
        foreach($order_details_product as $order_details=>$odd)
        {
            $total_amount+=($odd['product_price']*$odd['quantity']);
            $total_gst=$total_gst+=($odd['gst']*$odd['quantity']);
            
            $html.='<tr style="width:100%;border:1px solid black;border-collapse: collapse; padding:6px">';
            $html.='<td style="width:50%;border:1px solid black;border-collapse: collapse; padding:6px">
                    <img src="'.base_url().'uploaded-files/products/'.$odd['product_image_name'].'" height="50px"><h4 style="position: ;">'.$odd['product_name'].'</h4></td>
                    <td style="width:10%;border:1px solid black;border-collapse: collapse; padding:6px">'.$odd['quantity'].'</td>';
            $html.='<td style="width:20%;border:1px solid black;border-collapse: collapse; padding:6px;text-align:center">₹ '.$odd['gst']*$odd['quantity'].'</td>';
            $html.='<td  style="width:20%;border:1px solid black;border-collapse: collapse; padding:6px;font-weight:900;text-align:center">  ₹ '.($odd['product_price']*$odd['quantity']).'</td>';
            $html.='</tr>';
        }
        
        $html.='<tr style="width:100%;border:1px solid black;border-collapse: collapse; padding:6px">';
        $html.='<td style="width:60%;border:1px solid black;border-collapse: collapse; padding:6px;font-weight:900;">Sub Total </td>
                <td style="width:20%;border:1px solid black;border-collapse: collapse; padding:6px ;font-weight:900;text-align:center">₹ '.$total_gst.' </td>
                <td style="width:20%;border:1px solid black;border-collapse: collapse; padding:6px ;font-weight:900;text-align:center"> ₹ '.$total_amount.' </td>
                ';
        $html.='';
        $html.='</tr>';
        
        
        $html.='<tr style="width:100%;border:1px solid black;border-collapse: collapse; padding:6px;font-weight:900;">';
        $html.='<td style="width:80%;border:1px solid black;border-collapse: collapse; padding:6px;font-weight:900;" colspan="2">Total Payble Amount </td>';
        $html.='<td  style="width:20%;border:1px solid black;border-collapse: collapse; padding:6px;font-weight:900;text-align:center">  ₹ '.($total_gst+$total_amount).'</td>';
        $html.='</tr>';
        
        
        

        
        
    $html.='</tbody>';
    $html.='</table>';
    $html.='';
    $html.='';
    $html.='</body></html>';

    $mail_config['smtp_host'] = 'smtp.gmail.com';
    $mail_config['smtp_port'] = '587';
    $mail_config['smtp_user'] = $email;
    $mail_config['_smtp_auth'] = TRUE;
    $mail_config['smtp_pass'] = $password;
    $mail_config['smtp_crypto'] = 'tls';
    $mail_config['protocol'] = 'smtp';
    $mail_config['mailtype'] = 'html';
    $mail_config['send_multipart'] = FALSE;
    $mail_config['charset'] = 'utf-8';
    $mail_config['wordwrap'] = TRUE;
    $this->email->initialize($mail_config);

    $this->email->set_newline("\r\n");

    $this->load->library('email');
    $this->email->from($from_email)
          ->to($to_email)
          ->subject("Order Placed! ")
          ->message($html)
          ->set_mailtype('html')
          ->send();
          return true;
  }
  
  
  
   public function sent_user_order_cancel_email($useremail='info@weblieu.com',$order_id=44)
  {
    $email          =   EMAILEMAIL;
    $password       =   EMAILPASSWORD;
    $from_email     =   $email;
    $to_email       =   $useremail;
    $html='';
    $orderData              =   $this->db->query('SELECT * FROM `wps_order` where order_id=36')->result_array()[0];
    $order_details_product  =   $this->db->query('SELECT * FROM `wps_orders_products` where order_id=36')->result_array();
    
    $html.='<html><head><title></title></head><body>';
    $html.='<h1>Your Order is Cancelled!</h1>';
    // $html.='<p>Your order successfull Cancelled for the vendor Please wait for vendor confirmation</p>';
    $html.='<p>Order Details are below: </p>';
    
    $html.='<table style="width:100%;border:1px solid black;border-collapse: collapse;">';
    $html.='<thead>';
   
    $html.='<tr style="width:70%;border:1px solid black;border-collapse: collapse;">';
    $html.='<th style="width:30%;border:1px solid black;border-collapse: collapse; text-align:left">Product</th><th style="width:100%;border:1px solid black;border-collapse: collapse;">Price</th>';
    $html.='</tr>';

    $html.='</thead>';
    $html.='<tbody>';
    
        foreach($order_details_product as $order_details=>$odd)
        {
            $html.='<tr style="width:100%;border:1px solid black;border-collapse: collapse; padding:6px">';
            $html.='<td style="width:70%;border:1px solid black;border-collapse: collapse; padding:6px">
            <img src="'.base_url().'uploaded-files/products/'.$odd['product_image_name'].'" height="50px"><h4 style="position: absolute;">'.$odd['product_name'].'</h4></td>';
            $html.='<td  style="width:30%;border:1px solid black;border-collapse: collapse; padding:6px;font-weight:900">  ₹ '.($odd['product_price']+$odd['gst']).'</td>';
            $html.='</tr>';
        } 
    $html.='</tbody>';
    $html.='</table>';
    $html.='';
    $html.='';
    $html.='</body></html>';
    //   echo $html;die;
   
   
   
   
   
   
   
    
    $mail_config['smtp_host'] = 'smtp.gmail.com';
    $mail_config['smtp_port'] = '587';
    $mail_config['smtp_user'] = $email;
    $mail_config['_smtp_auth'] = TRUE;
    $mail_config['smtp_pass'] = $password;
    $mail_config['smtp_crypto'] = 'tls';
    $mail_config['protocol'] = 'smtp';
    $mail_config['mailtype'] = 'html';
    $mail_config['send_multipart'] = FALSE;
    $mail_config['charset'] = 'utf-8';
    $mail_config['wordwrap'] = TRUE;
    $this->email->initialize($mail_config);

    $this->email->set_newline("\r\n");

    $this->load->library('email');
    echo     $this->email->from($from_email)
          ->to($to_email)
          ->subject("Order Placed! ")
          ->message($html)
          ->set_mailtype('html')
          ->send();
        //   return true;
  }
  
  
  public function countheadcount()
    {
      echo count($this->cart->contents());
    }

 

}

/* End of file member.php */
/* Location: .application/modules/products/controllers/cart.php */