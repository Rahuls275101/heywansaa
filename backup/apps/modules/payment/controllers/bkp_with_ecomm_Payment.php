<?php

class Payment extends Public_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper(array('cart/cart', 'file'));
    $this->load->model(array('order/order_model', 'payment/payment_model'));
    $this->load->library(array('Dmailer', 'safe_encrypt'));
    $this->page_section_ct = 'common';
  }

  public function index() {
    $payMode = str_replace('.html', '', $this->input->get_post('pay_method'));
    //print_r($payMode);
    if ($payMode == "Payu") {
      $working_order_id = $this->session->userdata('working_order_id');
      $order_res = $this->order_model->get_order_master($working_order_id);
      //trace($_POST);
      payuForm($order_res);
    }
    elseif ($payMode == "COD") 
    {
      $this->pay_by_check();
    } else {
      $working_order_id = $this->session->userdata('working_order_id');
      $order_res = $this->order_model->get_order_master($working_order_id);
      //trace($_POST);
      payuForm($order_res);
    }
  }


 public function paymentresponce()
 {
 $this->load->library('ccavenue');
$workingKey='2B22A1CD2B40A8555E922593845B938A';		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=$this->ccavenue->decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	//$order_status="";
	$decryptValues=explode('&', $rcvdString);
	 $dataSize=sizeof($decryptValues);
	// echo "<pre>";

	
	// print_r($decryptValues);
	
	//echo $order_status = $decryptValues['order_status'];
	

	

	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==0)	
		$order_id=$information[1];
		
		if($i==1)	
		$tracking_id=$information[1];
		
		if($i==3)	
		$order_status=$information[1];
		
		if($i==9)	
		$currency=$information[1];
		
		if($i==10)	
		$amount=$information[1];
		
	}
 
 
 	 
		
 
	
	if($order_status==="Success")
	{
	//$data['msgdata'] = "<br>Thank you for shopping with us. We will be shipping your order to you soon.";
		
		
	
		
	 $data = array('payment_status' => 'Paid', 'paymentResponse' => $rcvdString);
        //$where = "MD5(order_id) = '$ordId' ";
        $where = "order_id = '$order_id' ";
        $this->payment_model->safe_update('wps_order', $data, $where, FALSE);			
		
/* -------------------------------------------- Ecomm Upload --------------------- */		
		


$id = $order_id;

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
		"CONSIGNEE_LONG":"",
		"CONSIGNEE_LAT":"",
        "what3words":"tall.basically.flattered"
	}
}]'),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;	 
 
  

 
$this->db->set('ecomm_order_status', $response);
$this->db->where('order_id', $order_id);
$this->db->where('vendor_id', $vendor_id);
$this->db->update('wps_orders_products');
 
 
} 
 
 
 } 
	 

  	
		
/* -------------------------------------------- Ecomm Upload --------------------- */			
		
		
		
		
	 $this->load->view('pay_thanks_online',$data);	
		
		
		
	}
	else if($order_status==="Aborted")
	{
		$data['msgdata'] = "<br><strong>Aborted!</strong> Thank you for shopping with us.We will check the status of your order.";
		
		$this->load->view('pay_fail_online',$data);
	
	}
	else if($order_status==="Failure")
	{
		$data['msgdata'] =  "<br>Thank you for shopping with us.However,the transaction has been declined.";
		
		$this->load->view('pay_fail_online',$data);
	}
	else
	{
		$data['msgdata'] =  "<br>Security Error. Illegal access detected";
		
		$this->load->view('pay_fail_online',$data);
	
	}


/*
	echo "<br><br>";

	echo "<table cellspacing=4 cellpadding=4>";
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
	    	echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
	}

	echo "</table><br>";
	echo "</center>"; 
 */
 
 
  
 }


    public function ccavenue_payment($invoiceno=null) {
     

    
      $decrypted_txt   =   $this->encrypt_decrypt('decrypt', $invoiceno) ;
	
	//$decrypted_txt = encrypt_decrypt('decrypt', $_REQUEST['exportid']);
// order create
$result = explode('#', $decrypted_txt);
$invoice_id = rand();
$order_id = $result[1];
$cart_tot = $result[2];
$description = $result[3];
$card_holder_name = $result[4];
$email = $result[5];
$phone = $result[6];
 
 
 
 
 
 	$merchant='2581359';
	$working_key='2B22A1CD2B40A8555E922593845B938A';//Shared by CCAVENUES
	$access_code='AVQS82KF90CE31SQEC';//Shared by CCAVENUES
	
	
 
 $query = $this->db->query('select * from wps_order where order_id="'.$order_id.'" and payment_status="Unpaid"');  
$needpay = $query->num_rows();
 
 
 if($needpay==1)
 {	 
	    
	
			$data = array(
			'tid'=>$invoice_id,
'merchant_id'=>$merchant,
'working_key'=>$working_key,
'access_code'=>$access_code,
'order_id'=>$order_id,
'amount'=>$cart_tot,
'currency'=>'INR',
'redirect_url'=>'https://heywansaa.com/payment/paymentresponce/',
'cancel_url'=>'https://heywansaa.com/payment/paymentresponce/',
'language'=>'EN',
'delivery_name'=>$card_holder_name,
'delivery_tel'=>$phone

		);

//var_dump($data);
//print_r($data);

//die;
}

$this->load->library('ccavenue');
	
 
	  
	foreach ($data as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}
	
	  $encrypted_data=$this->ccavenue->encrypt($merchant_data,$working_key); // Method for encrypting the data.  
	  
  ?>
  
  <form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
</form></center>
<script language='javascript'>document.redirect.submit();</script>

  <?php
		
    }	

 

 public function pay_by_check() {
    $data = array('payment_method' => 'Cash', 'payment_status' => 'Unpaid');
    $ordId = $this->session->userdata('working_order_id');
    $where = "order_id = '" . $ordId . "' ";
    $this->payment_model->safe_update('wps_order', $data, $where, FALSE);
    $condition = "&& order_id='" . $ordId . "'";
    $cupn = $this->order_model->get_orders(0, 1, $condition);
    $cupn = $cupn[0];
    $ordId = md5($ordId);
    $res = get_db_field_value('wps_order', 'order_id', array('MD5(order_id)' => $ordId));
    $ordmaster = $this->order_model->get_order_master($res);
    $orddetail = $this->order_model->get_order_detail($res);
    if (is_array($ordmaster) && !empty($ordmaster)) {
      ob_start();
      $mail_subject = $this->config->item('site_name') . " Order Oerview";
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
          'body_part' => $msg
      );
      //trace($mail_conf); die;
      $this->dmailer->mail_notify($mail_conf);
  if($this->admin_info->website_mode=='Live'){
      $mail_conf2 = array(
          'subject' => $this->config->item('site_name') . " Order overview",
          'to_email' => $this->admin_info->admin_email,
          'from_email' => $from_email,
          'from_name' => $this->config->item('site_name'),
          'body_part' => $msg
      );
      //trace($mail_conf); die;
      $this->dmailer->mail_notify($mail_conf2);
      $mail_conf4 = array(
          'subject' => $this->config->item('site_name') . " Order overview",
          'to_email' => "info@weblieu.com",
          'from_email' => $from_email,
          'from_name' => $this->config->item('site_name'),
          'body_part' => $msg
      );
      $this->dmailer->mail_notify($mail_conf4);
    }else{
      $mail_conf4 = array(
                  'subject' => $this->config->item('site_name') . " Order overview",
                  'to_email' => 'info@weblieu.com', //
                  'from_email' => $from_email,
                  'from_name' => $this->config->item('site_name'),
                  'body_part' => $msg,
              );
              $this->dmailer->mail_notify($mail_conf4);
    }
    }
    redirect('payment/thanks/' . $ordId, '');
  }
  
  public function order_success() {
    $ordId = $this->uri->segment(3);
    $this->session->unset_userdata(array('discount_amount' => 0));
    //update payment status
    $responses = json_encode($_REQUEST);

    if($_REQUEST['status']=='success')
    {
        
        $data = array('payment_method' => 'Payu', 'payment_status' => 'Paid', 'paymentResponse' => $responses);
        //$where = "MD5(order_id) = '$ordId' ";
        $where = "order_id = '$ordId' ";
        $this->payment_model->safe_update('wps_order', $data, $where, FALSE);
        //echo_sql();
        //exit;
        // $res = get_db_field_value('wps_order', 'order_id', array('MD5(order_id)' => $ordId));
        $res = get_db_field_value('wps_order', 'order_id', array('order_id' => $ordId));
        $ordmaster = $this->order_model->get_order_master($res);
        $orddetail = $this->order_model->get_order_detail($res);
        $this->update_stocks($ordId);
        if (is_array($ordmaster) && !empty($ordmaster)) {
          ob_start();
          $mail_subject = $this->config->item('site_name') . " Order Oerview";
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
              'body_part' => $msg
          );
          //trace($mail_conf); die;
          $this->dmailer->mail_notify($mail_conf);
            if($this->admin_info->website_mode=='Live'){
                $mail_conf2 = array(
                    'subject' => $this->config->item('site_name') . " Order overview",
                    'to_email' => $this->admin_info->admin_email,
                    'from_email' => $from_email,
                    'from_name' => $this->config->item('site_name'),
                    'body_part' => $msg
                );
                //trace($mail_conf); die;
                $this->dmailer->mail_notify($mail_conf2);
                $mail_conf4 = array(
                    'subject' => $this->config->item('site_name') . " Order overview",
                    'to_email' => "info@weblieu.com",
                    'from_email' => $from_email,
                    'from_name' => $this->config->item('site_name'),
                    'body_part' => $msg
                );
                $this->dmailer->mail_notify($mail_conf4);
            }else{
              $mail_conf4 = array(
                          'subject' => $this->config->item('site_name') . " Order overview",
                          'to_email' => 'info@weblieu.com', //
                          'from_email' => $from_email,
                          'from_name' => $this->config->item('site_name'),
                          'body_part' => $msg,
                      );
                      $this->dmailer->mail_notify($mail_conf4);
            }
        }
        $this->session->set_flashdata('msg', $this->config->item('payment_success'));
    }
    else
    {
      $data = array('payment_method' => 'Payu', 'payment_status' => 'Unpaid', 'paymentResponse' => $responses);
      $where = "order_id = '$ordId' ";
      $this->payment_model->safe_update('wps_order', $data, $where, FALSE);
      $this->session->set_flashdata('msg', $this->config->item('payment_failed'));
    }
    $this->session->unset_userdata(array('working_order_id' => 0));
    redirect('payment/thanks/'.md5($ordId));
  }

  

  public function order_cancle() {
    $ordId = $this->uri->segment(3);
    $responses = json_encode($_REQUEST);
    $data = array('order_status' => '5', 'paymentResponse' => $responses);
    // $where = "MD5(order_id) = '$ordId' ";
    $where = "order_id = '$ordId' ";
    $this->payment_model->safe_update('wps_order', $data, $where, FALSE);
    $this->session->unset_userdata(array('working_order_id' => 0));
    $this->session->set_flashdata('msg', $this->config->item('payment_failed'));
    redirect('payment/thanks/'.md5($ordId));
  }

//   public function thanks() 
//   {
//     $order_id = str_replace('.html', '', $this->uri->segment(3));
//     $res = get_db_field_value('wps_order', 'order_id', array('md5(order_id)' => $order_id));
//     if ($res > 0) 
//     {
//       $data['title'] = "Invoice Print";
//       $order_res = $this->order_model->get_order_master($res);
      
//       $order_details_res = $this->order_model->get_order_detail($res);
//       $data['orddetail'] = $order_details_res;
//       $data['ordmaster'] = $order_res;
//       $this->load->view('payment/pay_thanks', $data);
//     }
//   }


public function cvf_convert_object_to_array($data) {

    if (is_object($data)) {
        $data = get_object_vars($data);
    }

    if (is_array($data)) {
        return array_map(__FUNCTION__, $data);
    }
    else {
        return $data;
    }
}


 public function thanks() 
  {
    //    pre  WEBLIEU  and post   W8RY9T2TANK
    $order_id = ($this->uri->segment(3));
    
    $order_id=explode('-',$order_id);
    $this->load->model('payment_model');
    $order_id=$order_id[1];
    
  
    if ($order_id!='' && $order_id!=null) 
    {
      $data['title'] = "Invoice Print";
     
     
	 
/*	 
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://clbeta.ecomexpress.in/apiv2/fetch_awb/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('username' => 'HEYWANSAASOLUTION_TEST','password' => '89RFRHNWTa@f&2v9','count' => '1','type' => 'COD'),
));

$response1 = curl_exec($curl);

curl_close($curl);
$response1ar =  json_decode($response1);

//echo "<pre>";	 
  
//$aac = $this->cvf_convert_object_to_array($response1ar);
$abv = get_object_vars($response1ar);	 
$awbno = $abv[awb][0];	



$curl = curl_init();
                               
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://clbeta.ecomexpress.in/apiv2/manifest_awb/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('username' => 'HEYWANSAASOLUTION_TEST','password' => '89RFRHNWTa@f&2v9','json_input' => '[{
	"AWB_NUMBER":"'.$awbno.'",
	"ORDER_NUMBER": "Ord-001",
	"PRODUCT": "COD",
	"CONSIGNEE": "Test Consignee",
	"CONSIGNEE_ADDRESS1": "Test Consignee Address 1",
	"CONSIGNEE_ADDRESS2": "Test Consignee Address 2",
	"CONSIGNEE_ADDRESS3": "Test Consignee Address 3",
	"DESTINATION_CITY": "GURGAON",
	"PINCODE": "111111",
	"STATE": "HR",
	"MOBILE": "9560350578",
	"TELEPHONE": "1111111111",
	"ITEM_DESCRIPTION": "Gents T-shirt",
	"PIECES": 1,
	"COLLECTABLE_VALUE": 1,
	"DECLARED_VALUE": 50001,
	"ACTUAL_WEIGHT": 1,
	"VOLUMETRIC_WEIGHT": 0,
	"LENGTH": 12,
	"BREADTH": 5,
	"HEIGHT": 2,
	"PICKUP_NAME": "Test Pickup Name",
	"PICKUP_ADDRESS_LINE1": "Test Pickup Address1",
	"PICKUP_ADDRESS_LINE2": "Test Pickup Address2",
	"PICKUP_PINCODE": "111111",
	"PICKUP_PHONE": "2222222222",
	"PICKUP_MOBILE": "3333333333",
	"RETURN_NAME": "Test Return Name",
	"RETURN_ADDRESS_LINE1": "Test Return Address1",
	"RETURN_ADDRESS_LINE2": "Test Return Address2",
	"RETURN_PINCODE": "111111",
	"RETURN_PHONE": "2222222222",
	"RETURN_MOBILE": "3333333333",
	"DG_SHIPMENT": "false",
	"ADDITIONAL_INFORMATION": {
		"GST_TAX_CGSTN":"",
		"GST_TAX_IGSTN":"",
		"GST_TAX_SGSTN":"",
		"SELLER_GSTIN":"GISTN988787",
		"INVOICE_DATE":"12-08-2022",
		"INVOICE_NUMBER":"INVOICE_001",
		"GST_TAX_RATE_SGSTN":"",
		"GST_TAX_RATE_IGSTN":"",
		"GST_TAX_RATE_CGSTN":"",
		"GST_HSN":"123456",
		"GST_TAX_BASE":"",
		"GST_ERN":"123456789876",
		"ESUGAM_NUMBER":"", 
		"ITEM_CATEGORY":"Clothes",
		"GST_TAX_NAME":"",
		"ESSENTIALPRODUCT":"Y",
		"PICKUP_TYPE":"WH",
		"OTP_REQUIRED_FOR_DELIVERY":"Y",
		"RETURN_TYPE":"WH",
		"GST_TAX_TOTAL":"",
		"SELLER_TIN":"",
        
		"CONSIGNEE_ADDRESS_TYPE":"HOME",
		"CONSIGNEE_LONG":"1.4434",
		"CONSIGNEE_LAT":"2.987",
        "what3words":"tall.basically.flattered"
	}
}]'),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

 */
	 
      $order_id = (int) filter_var($order_id, FILTER_SANITIZE_NUMBER_INT);
      $where=array('order_id'=>$order_id);
      $data['ordmaster'] = $this->payment_model->get_where('wps_order',$where);
      
     
      
      $data['orddetail'] = $this->payment_model->get_order_product_list('select wps_orders_products.*, wps_order.wallet_coin_use, wps_order.coupon_discount_amount, wps_order.total_amount as total_order_amount, wps_products.friendly_url
	 from wps_orders_products  ',
     'inner join wps_order on wps_order.order_id=wps_orders_products.order_id inner join wps_products on wps_products.products_id=wps_orders_products.products_id
      where wps_orders_products.order_id="'.$order_id.'" group by wps_orders_products.orders_products_id');
    
        //   echo $this->db->last_query();die;
    
      $this->load->view('payment/pay_thanks', $data);
    }
    else
    {
        $data['title'] = "Invoice Print";
        $this->load->view('payment/pay_thanks', $data);
    }
  }

  public function update_stocks($order_id) {
    $order_id = (int) $order_id;
    $condtion = array('field' => "products_id,quantity,color_id,size_id", 'condition' => "order_id ='$order_id'", 'index' => 'products_id');
    $orders_res = $this->order_model->findAll('wps_orders_products', $condtion);
    if (is_array($orders_res) && !empty($orders_res)) {
      foreach ($orders_res as $v) {
          $qty = $v['quantity'];
          $sql = "UPDATE wps_products SET product_qty = product_qty-$qty WHERE products_id = '" . $v['products_id'] . "'";
          $this->db->query($sql);

          if($v['color_id']>0 && $v['size_id']>0){
            $qty = $v['quantity'];
            $sql = "UPDATE wps_product_attributes SET quantity = quantity-$qty WHERE product_id = '" . $v['products_id'] . "' and color_id = '" . $v['color_id'] . "' and size_id = '" . $v['size_id'] . "'";
            $this->db->query($sql);
          }elseif($v['color_id']>0 && $v['size_id']=='0'){
            $qty = $v['quantity'];
            $sql = "UPDATE wps_product_attributes SET quantity = quantity-$qty WHERE product_id = '" . $v['products_id'] . "' and color_id = '" . $v['color_id'] . "' and size_id = '0'";
            $this->db->query($sql);
          }elseif($v['color_id']=='0' && $v['size_id']>0){
            $qty = $v['quantity'];
            $sql = "UPDATE wps_product_attributes SET quantity = quantity-$qty WHERE product_id = '" . $v['products_id'] . "' and color_id = '0' and size_id = '" . $v['size_id'] . "'";
            $this->db->query($sql);
          }
      }
    }
  }

  
  
  public function paybyrazorpay($invoiceno=null)
  {
    
    $decrypted_txt   =   $this->encrypt_decrypt('decrypt', $invoiceno) ;
	
	//$decrypted_txt = encrypt_decrypt('decrypt', $_REQUEST['exportid']);
// order create
$result = explode('#', $decrypted_txt);
 $invoice_id = $result[0];
 $order_id = $result[1];
 $cart_tot = $result[2];
 $description = $result[3];
 $card_holder_name = $result[4];
 $email = $result[5];
 $phone = $result[6];
 
 
 $query = $this->db->query('select * from wps_order where order_id="'.$order_id.'" and payment_status="Unpaid"');  
$needpay = $query->num_rows();
 
 
 if($needpay==1)
 {

$data = array(
'title' => 'Checkout payment',
'callback_url' => base_url().'payment/callback',
'surl' => base_url().'payment/success',
'furl' => base_url().'payment/failed',
'currency_code' => 'INR',
'invoice_id' => $invoice_id,	
'order_id' => $order_id,
'cart_tot' => $cart_tot,
'description' => $description,
'card_holder_name' => $card_holder_name,
'email' => $email,
'phone' => $phone);
	//print_r($data);
	
 $this->load->view('makepayment',$data);
  } else {
  
  redirect(base_url());
  
  } 
   
  }
  
  
  
// initialized cURL Request
    private function curl_handler($payment_id, $amount)  {
        $url            = 'https://api.razorpay.com/v1/payments/'.$payment_id.'/capture';
        $key_id         = "rzp_test_czT75UB3wjBa9l";
        $key_secret     = "qturLd5pMFXCWfotHjrkXzS6";
        $fields_string  = "amount=$amount";
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        return $ch;
    }   
        
    // callback method
    public function callback() {   
        print_r($this->input->post());     
        if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_order_id'))) {
            $razorpay_payment_id = $this->input->post('razorpay_payment_id');
            $merchant_order_id = $this->input->post('merchant_order_id');
            
            $this->session->set_flashdata('razorpay_payment_id', $this->input->post('razorpay_payment_id'));
            $this->session->set_flashdata('merchant_order_id', $this->input->post('merchant_order_id'));
            $currency_code = 'INR';
            $amount = $this->input->post('merchant_total');
            $success = false;
            $error = '';
            try {                
                $ch = $this->curl_handler($razorpay_payment_id, $amount);
                //execute post
                $result = curl_exec($ch);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($result === false) {
                    $success = false;
                    $error = 'Curl error: '.curl_error($ch);
                } else {
                    $response_array = json_decode($result, true);
                        //Check success response
                        if ($http_status === 200 and isset($response_array['error']) === false) {
                            $success = true;
                        } else {
                            $success = false;
                            if (!empty($response_array['error']['code'])) {
                                $error = $response_array['error']['code'].':'.$response_array['error']['description'];
                            } else {
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;
                            }
                        }
                }
                //close curl connection
                curl_close($ch);
            } catch (Exception $e) {
                $success = false;
                $error = 'Request to Razorpay Failed';
            }
            
            if ($success === true) {
                if(!empty($this->session->userdata('ci_subscription_keys'))) {
                    $this->session->unset_userdata('ci_subscription_keys');
                }
                if (!$order_info['order_status_id']) {
                    redirect($this->input->post('merchant_surl_id'));
                } else {
                    redirect($this->input->post('merchant_surl_id'));
                }

            } else {
                redirect($this->input->post('merchant_furl_id'));
            }
        } else {
            echo 'An error occured. Contact site administrator, please!';
        }
    } 
    public function success() {
        $data['title'] = 'Razorpay Success';
        
		
		$responses = $this->session->flashdata('razorpay_payment_id');
		$ordId = $this->session->flashdata('merchant_order_id');
		
	  $data = array('payment_status' => 'Paid', 'paymentResponse' => $responses);
        //$where = "MD5(order_id) = '$ordId' ";
        $where = "order_id = '$ordId' ";
        $this->payment_model->safe_update('wps_order', $data, $where, FALSE);	
		
		
		
/* -------------------------------------------- Ecomm Upload --------------------- */		
		


$id = $ordId;

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
 
 
 /*  
 //Nishant closing for some time   

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
 
 //Nishant closing for some time  
 
 */


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

 
 
/*  
//Nishant closing for some time  
 
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
	"LENGTH": 12,
	"BREADTH": 5,
	"HEIGHT": 2,
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
		"CONSIGNEE_LONG":"1.4434",
		"CONSIGNEE_LAT":"2.987",
        "what3words":"tall.basically.flattered"
	}
}]'),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;	 
 
  //Nishant closing for some time  
  */

 
$this->db->set('ecomm_order_status', $response);
$this->db->where('order_id', $order_id);
$this->db->where('vendor_id', $vendor_id);
$this->db->update('wps_orders_products');
 
 
} 
 
 
 } 
	 

  	
		
/* -------------------------------------------- Ecomm Upload --------------------- */		
		
		
		
		 $this->load->view('pay_thanks_online',$data);
		
		
    }  
    public function failed() {
        $data['title'] = 'Razorpay Failed';  
        
		
		$this->load->view('pay_fail_online',$data);
    }  
  
  
  
  
 
  
    function encrypt_decrypt($action, $string) 
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

}

/* End of file member.php */

/* Location: .application/modules/products/controllers/cart.php */