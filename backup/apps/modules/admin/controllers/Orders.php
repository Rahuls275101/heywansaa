<?php

class Orders extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('order_model', 'products/product_model'));
    $this->load->helper(array('cart/cart', 'file', 'category/category'));
    $this->load->library(array('Dmailer'));
  }

  public function index($page = NULL) {
    $pagesize = (int) $this->input->get_post('pagesize');
    $config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
    $offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
    $base_url = current_url_query_string(array('filter' => 'result'), array('per_page'));
    $res_array = $this->order_model->get_orders($offset, $config['limit']);
    $config['total_rows'] = $this->order_model->total_rec_found;
    $data['page_links'] = dashboard_pagination($base_url, $config['total_rows'], $config['limit'], $offset);

    /* Order oprations  */
    if ($this->input->post('unset_as') != '') {
      $this->set_as('wps_order', 'order_id', array('payment_status' => 'Unpaid'));
    }
    // if ($this->input->post('ord_status') != '') {
    //  $posted_order_status = $this->input->post('ord_status');
    //  $this->set_as('wps_order', 'order_id', array('order_status' => $posted_order_status));
    //  } 

    if ($this->input->post('ord_status') != '') {
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
    /* End order oprations */
    $data['headingTitle'] = 'Order Lists';
    $data['res'] = $res_array;
    $this->load->view('order/view_order_list', $data);
  }

  public function vieworder() {
    $id = (int) $this->uri->segment(4);
    $ordmaster = $this->db->query("SELECT * FROM wps_order WHERE order_id = '" . $id . "'")->row_array();
    $ordDetails = $this->db->query("SELECT * FROM wps_orders_products WHERE order_id = '" . $id . "'")->result_array();

    $data['ordmaster'] = $ordmaster;
    $data['ordDetails'] = $ordDetails;

    $data['headingTitle'] = 'Order Details - Order# ' . $ordmaster['invoice_number'];
    $this->load->view('order/view_order_details', $data);
  }
  
 
  
  
    public function vieworderbyvendor() {
     $id = (int) $this->uri->segment(4);
	 $vndid = (int) $this->uri->segment(5);
    $ordmaster = $this->db->query("SELECT * FROM wps_order WHERE order_id = '" . $id . "'")->row_array();
    $ordDetails = $this->db->query("SELECT * FROM wps_orders_products WHERE order_id = '" . $id . "' and vendor_id='".$vndid."'")->result_array();

 
    $data['ordmaster'] = $ordmaster;
    $data['ordDetails'] = $ordDetails;

    $data['headingTitle'] = 'Order Details - Order# ' . $ordmaster['invoice_number'];
    $this->load->view('order/view_order_details_by_vendors', $data);
  }
  


public function convert_object_to_array($data) {
	if(is_object($data)) {
		// Get the properties of the given object
		$data = get_object_vars($data);
	}
	if(is_array($data)) {
		//Return array converted to object
		return array_map(__FUNCTION__, $data);
	}
	else {
		// Return array
		return $data;
	}
}


public function shipcancel() {

$awbid = (int) $this->uri->segment(4);

 

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.ecomexpress.in/apiv2/cancel_awb/?=',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('username' => 'HEYWANSAASOLUTIONANDSERVICESLLP_811931','password' => 'hrLZwRATaT12MNk','awbs' => $awbid),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
 
 

}



public function viewuploadedorder() {

$awbid = (int) $this->uri->segment(4);
 


 

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://plapi.ecomexpress.in/track_me/api/mawbd/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('username' => 'HEYWANSAASOLUTIONANDSERVICESLLP_811931','password' => 'hrLZwRATaT12MNk','awb' => $awbid),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;

 
 

$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xml);
$array = json_decode($json,TRUE);

 echo "<pre>";
 print_r($array);




foreach($array as $arraydata)
{



	foreach($arraydata as $arraydata2)
	{
	
	print_r($arraydata2);
	
	}


}



}


public function vieworderandupload() {

$id = (int) $this->uri->segment(4);

$ordmaster = $this->db->query("SELECT * FROM wps_order WHERE order_id = '" . $id . "'")->row_array();
	
$ordDetails = $this->db->query("SELECT vadmin.`name` AS vendor_name,vadmin.admin_id as vendor_id,order_id,sub_order_id,vendor_id,ecomm_awb_number FROM wps_orders_products AS ordp
LEFT JOIN wps_admin AS vadmin ON ordp.vendor_id=vadmin.admin_id
WHERE order_id = '" .$id. "' GROUP BY vadmin.admin_id")->result_array();

 
 
 
 
$order_id = $ordmaster['order_id'];
$customers_id = $ordmaster['customers_id'];
$invoice_number = $ordmaster['invoice_number'];
$first_name = $ordmaster['first_name'];
$last_name = $ordmaster['last_name'];
$email = $ordmaster['email'];

$billing_title = $ordmaster['billing_title'];
$billing_name = $ordmaster['billing_name'];
$billing_address = $ordmaster['billing_address'];
$billing_landmark = $ordmaster['billing_landmark'];
$billing_phone = $ordmaster['billing_phone'];
$billing_zipcode = $ordmaster['billing_zipcode'];
$billing_country = $ordmaster['billing_country'];
$billing_state = $ordmaster['billing_state'];
$billing_city = $ordmaster['billing_city'];

$shipping_title = $ordmaster['shipping_title'];
$shipping_name = $ordmaster['shipping_name'];
$shipping_address = $ordmaster['shipping_address'];
$shipping_landmark = $ordmaster['shipping_landmark'];
$shipping_phone = $ordmaster['shipping_phone'];
$shipping_zipcode = $ordmaster['shipping_zipcode'];
$shipping_country = $ordmaster['shipping_country'];
$shipping_state = $ordmaster['shipping_state'];
$shipping_city = $ordmaster['shipping_city'];
$last_shopping_comment = $ordmaster['last_shopping_comment'];
$shipping_method = $ordmaster['shipping_method'];

$total_amount = $ordmaster['total_amount'];
$vat_gst_amount = $ordmaster['vat_amount'];
$wallet_coin_use = $ordmaster['wallet_coin_use'];
$currency_code = $ordmaster['currency_code'];
$order_received_date = $ordmaster['order_received_date'];
$payment_status = $ordmaster['payment_status'];

$payment_method = $ordmaster['payment_method'];
if($payment_method=="cod")
{
$paymethod="COD";
$collect_val = 1;
} else {
$paymethod="PPD";
$collect_val = 0;
} 
 
 
 
 
 
 
    //$data['ordmaster'] = $ordmaster;
   // $data['ordDetails'] = $ordDetails;
   $i=0;
 
 
 
//vendor in loop
foreach($ordDetails as $ordv)
{

//print_r($ordv);

 $sub_order_id = $ordv['sub_order_id'];
 $ecomm_awb_number = $ordv['ecomm_awb_number'];
 $order_id = $ordv['order_id'];
 $vendor_id = $ordv['vendor_id'];
// Ecomm way bill code here
 
if($ecomm_awb_number=="")
{ 
 
 
  
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.ecomexpress.in/apiv2/fetch_awb/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('username' => 'HEYWANSAASOLUTIONANDSERVICESLLP_811931','password' => 'hrLZwRATaT12MNk','count' => '1','type' => $paymethod),
));

$response1_awb = curl_exec($curl);
curl_close($curl);
 
$abb = get_object_vars(json_decode($response1_awb));
$awbno_single = $abb['awb'][0];
 
 
 
$this->db->set('ecomm_awb_number', $awbno_single);
$this->db->where('order_id', $order_id);
$this->db->where('sub_order_id', $sub_order_id);
$this->db->where('vendor_id', $vendor_id);
$this->db->update('wps_orders_products');
 
 

 

$adminDetails = $this->db->query("SELECT * FROM wps_admin WHERE admin_id='".$vendor_id."'")->result_array(); 
$ordDetails_products = $this->db->query("SELECT * FROM wps_orders_products WHERE order_id = '" . $id . "' and vendor_id='".$vendor_id."'")->result_array();
 //print_r($ordDetails1);
 //product in look
 $prodprice=0;
 //$prod_name = array();

$ni =0; 
$prod_count = count($ordDetails_products);
foreach($ordDetails_products as $ordDetails_products_show)
{
 
//array_push($prod_name,$ordDetails_products_show['product_name']);

$prod_name .=$ordDetails_products_show['product_name'];
$prod_name .="+";

 $prodprice = $prodprice+$ordDetails_products_show['product_price'];
 
} 
 
//echo $prodprice;
//echo $prod_name;
 
// die;
 
$admin_id = $adminDetails[0]['admin_id'];
$admin_username = $adminDetails[0]['admin_username'];
$admin_email = $adminDetails[0]['admin_email'];
$first_name_admin = $adminDetails[0]['first_name'];
$last_name_admin = $adminDetails[0]['last_name'];
$name_admin = $adminDetails[0]['name'];
$address_admin = $adminDetails[0]['address'];
$city_admin = $adminDetails[0]['city'];
$country_admin = $adminDetails[0]['country'];
$pincode_admin = $adminDetails[0]['pin_code'];
$phone_admin = $adminDetails[0]['phone'];
$fax_admin = $adminDetails[0]['fax'];
$contact_person_admin = $adminDetails[0]['contact_person'];
$contact_phone_admin = $adminDetails[0]['contact_phone'];
$contact_email_admin = $adminDetails[0]['contact_email'];

$address_delivery = $city_admin.",".$country_admin;

 
 
 
 
$curl = curl_init();                         
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.ecomexpress.in/apiv2/manifest_awb/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('username' => 'HEYWANSAASOLUTIONANDSERVICESLLP_811931','password' => 'hrLZwRATaT12MNk','json_input' => '[{
	"AWB_NUMBER": "'.$awbno_single.'",
	"ORDER_NUMBER": "'.$order_id.'",
	"PRODUCT": "'.$paymethod.'",
	"CONSIGNEE": "'.$shipping_name.'",
	"CONSIGNEE_ADDRESS1": "'.$shipping_address.'",
	"CONSIGNEE_ADDRESS2": "'.$shipping_city.','.$shipping_state.'",
	"CONSIGNEE_ADDRESS3": "'.$shipping_landmark.'",
	"DESTINATION_CITY": "'.$shipping_city.'",
	"PINCODE": "'.$shipping_zipcode.'",
	"STATE": "'.$shipping_state.'",
	"MOBILE": "'.$shipping_phone.'",
	"TELEPHONE": "'.$shipping_phone.'",
	"ITEM_DESCRIPTION": "'.$prod_name.'",
	"PIECES": '.$prod_count.',
	"COLLECTABLE_VALUE": '.$collect_val.',
	"DECLARED_VALUE": '.$prodprice.',
	"ACTUAL_WEIGHT": 1,
	"VOLUMETRIC_WEIGHT": 0,
	"LENGTH": 1,
	"BREADTH": 1,
	"HEIGHT": 1,
	"PICKUP_NAME": "'.$name_admin.'",
	"PICKUP_ADDRESS_LINE1": "'.$address_admin.'",
	"PICKUP_ADDRESS_LINE2": "'.$address_delivery.'",
	"PICKUP_PINCODE": "'.$pincode_admin.'",
	"PICKUP_PHONE": "'.$phone_admin.'",
	"PICKUP_MOBILE": "'.$phone_admin.'",
	"RETURN_NAME": "'.$name_admin.'",
	"RETURN_ADDRESS_LINE1": "'.$address_admin.'",
	"RETURN_ADDRESS_LINE2": "'.$address_delivery.'",
	"RETURN_PINCODE": "'.$pincode_admin.'",
	"RETURN_PHONE": "'.$phone_admin.'",
	"RETURN_MOBILE": "'.$phone_admin.'",
	"DG_SHIPMENT": "false",
	"ADDITIONAL_INFORMATION": {
		"GST_TAX_CGSTN":"",
		"GST_TAX_IGSTN":"",
		"GST_TAX_SGSTN":"",
		"SELLER_GSTIN":"",
		"INVOICE_DATE":"",
		"INVOICE_NUMBER":"'.$invoice_number.'",
		"GST_TAX_RATE_SGSTN":"",
		"GST_TAX_RATE_IGSTN":"",
		"GST_TAX_RATE_CGSTN":"",
		"GST_HSN":"123456",
		"GST_TAX_BASE":"",
		"GST_ERN":"123456789876",
		"ESUGAM_NUMBER":"", 
		"ITEM_CATEGORY":"",
		"GST_TAX_NAME":"",
		"ESSENTIALPRODUCT":"Y",
		"PICKUP_TYPE":"WH",
		"OTP_REQUIRED_FOR_DELIVERY":"Y",
		"RETURN_TYPE":"WH",
		"GST_TAX_TOTAL":"",
		"SELLER_TIN":"",
        
		"CONSIGNEE_ADDRESS_TYPE":"HOME",
		"CONSIGNEE_LONG":"0",
		"CONSIGNEE_LAT":"0",
        "what3words":"tall.basically.flattered"
	}
}]'),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;	 
 
 
$this->db->set('ecomm_order_status', $response);
$this->db->where('order_id', $order_id);
$this->db->where('vendor_id', $vendor_id);
$this->db->update('wps_orders_products');
 
 
} 
 echo "<br><br><br>";
 
 } 
	 

 
    
 

 
  }  
 

  public function make_paid($order_id) {

    $order_id = (int) $order_id;
    $where = "order_id = '" . $order_id . "'";
    $this->order_model->safe_update('wps_order', array('payment_status' => 'Paid'), $where, FALSE);
    $this->update_stocks($order_id);

    $ordmaster = $this->order_model->get_order_master($order_id);
    $orddetail = $this->order_model->get_order_detail($order_id);

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
    redirect('wps-admin/orders', '');
  }
  
  public function pending_orders()
  {    
    $pagesize = (int) $this->input->get_post('pagesize');
    $config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
    $offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
    $base_url = current_url_query_string(array('filter' => 'result'), array('per_page'));
    $res_array = $this->order_model->get_orders($offset, $config['limit']);
    $config['total_rows'] = $this->order_model->total_rec_found;
    $data['page_links'] = dashboard_pagination($base_url, $config['total_rows'], $config['limit'], $offset);

    /* Order oprations  */
    if ($this->input->post('unset_as') != '') {
      $this->set_as('wps_order', 'order_id', array('payment_status' => 'Unpaid'));
    }
    // if ($this->input->post('ord_status') != '') {
    //  $posted_order_status = $this->input->post('ord_status');
    //  $this->set_as('wps_order', 'order_id', array('order_status' => $posted_order_status));
    //  } 

    if ($this->input->post('ord_status') != '') {
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
    /* End order oprations */
    $data['headingTitle'] = 'Pending Order Lists';
    $data['res'] = $res_array;
       $this->load->view('order/pending_orders',$data);
  }
  public function dispatched_orders()
  {
       $pagesize = (int) $this->input->get_post('pagesize');
    $config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
    $offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
    $base_url = current_url_query_string(array('filter' => 'result'), array('per_page'));
    $res_array = $this->order_model->get_orders($offset, $config['limit']);
    $config['total_rows'] = $this->order_model->total_rec_found;
    $data['page_links'] = dashboard_pagination($base_url, $config['total_rows'], $config['limit'], $offset);

    /* Order oprations  */
    if ($this->input->post('unset_as') != '') {
      $this->set_as('wps_order', 'order_id', array('payment_status' => 'Unpaid'));
    }
    // if ($this->input->post('ord_status') != '') {
    //  $posted_order_status = $this->input->post('ord_status');
    //  $this->set_as('wps_order', 'order_id', array('order_status' => $posted_order_status));
    //  } 

    if ($this->input->post('ord_status') != '') {
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
    /* End order oprations */
    $data['headingTitle'] = 'Dispatched Order Lists';
    $data['res'] = $res_array;
        $this->load->view('order/dispatched_orders',$data);
  }
  public function cancel_orders()
  {
       $pagesize = (int) $this->input->get_post('pagesize');
    $config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
    $offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
    $base_url = current_url_query_string(array('filter' => 'result'), array('per_page'));
    $res_array = $this->order_model->get_orders($offset, $config['limit'],'AND order_status =6');
    $config['total_rows'] = $this->order_model->total_rec_found;
    $data['page_links'] = dashboard_pagination($base_url, $config['total_rows'], $config['limit'], $offset);

    /* Order oprations  */
    if ($this->input->post('unset_as') != '') {
      $this->set_as('wps_order', 'order_id', array('payment_status' => 'Unpaid'));
    }
    // if ($this->input->post('ord_status') != '') {
    //  $posted_order_status = $this->input->post('ord_status');
    //  $this->set_as('wps_order', 'order_id', array('order_status' => $posted_order_status));
    //  } 

    if ($this->input->post('ord_status') != '') {
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
    /* End order oprations */
    $data['headingTitle'] = 'Cancelled Order Lists';
    $data['res'] = $res_array;
        $this->load->view('order/cancel_orders',$data);
  }
  
   public function delivered_orders()
  { 
       $pagesize = (int) $this->input->get_post('pagesize');
    $config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
    $offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
    $base_url = current_url_query_string(array('filter' => 'result'), array('per_page'));
    $res_array = $this->order_model->get_orders($offset, $config['limit']);
    $config['total_rows'] = $this->order_model->total_rec_found;
    $data['page_links'] = dashboard_pagination($base_url, $config['total_rows'], $config['limit'], $offset);

    /* Order oprations  */
    if ($this->input->post('unset_as') != '') {
      $this->set_as('wps_order', 'order_id', array('payment_status' => 'Unpaid'));
    }
    // if ($this->input->post('ord_status') != '') {
    //  $posted_order_status = $this->input->post('ord_status');
    //  $this->set_as('wps_order', 'order_id', array('order_status' => $posted_order_status));
    //  } 

    if ($this->input->post('ord_status') != '') {
      $posted_order_status = $this->input->post('ord_status');
      switch ($posted_order_status) {
        
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
          } 
		  
		  case '8': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '8', 'order_delivery_date' => date("Y-m-d H:i:s")));
            break;
          }
        case '7': {
            $this->set_as('wps_order', 'order_id', array('order_status' => '6', 'order_returned_date' => date("Y-m-d H:i:s")));
            break;
          }
		  default: break;
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
    /* End order oprations */
    $data['headingTitle'] = 'Delivered Order Lists';
    $data['res'] = $res_array;
        $this->load->view('order/delivered_orders',$data);
  }




}

// End of controller