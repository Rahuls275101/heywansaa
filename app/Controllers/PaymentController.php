<?php

namespace App\Controllers;
use App\Models\Commanmodel;
use App\Models\Travelmodel;
class PaymentController extends BaseController
{
    
    
    
    public function index()
{
    $session = session();
    $commanmodel = new Commanmodel();
    helper(['form', 'url']);
    $validation =  \Config\Services::validation();
    
    $rules = [
        'name' => [
            'label'  => 'First Name',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Please enter First Name',
            ],
        ],
        'phone' => [
            'label'  => 'Phone Number',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Please enter phone number',
            ],
        ],
        'email' => [
            'label'  => 'Email',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Please enter email',
            ],
        ],
        'city' => [
            'label'  => 'City',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Please enter city',
            ],
        ],
        'state' => [
            'label'  => 'State',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Please enter state',
            ],
        ],
        'address' => [
            'label'  => 'Address',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Please enter address',
            ],
        ],
    ];
    
    if ($this->validate($rules)) {
        if ($session->has('loggedin')) {
            $usersession = $session->get('loggedin'); 
            $loginId = $usersession['user_id'];
        } else {
            $loginId = 0;
        }

     
        $bookingInformetion = $commanmodel->calculateCartSummary();
       
        
        // Capture shipping details if provided, else use the billing details or leave them blank
        $shippingName = $this->request->getVar('shipping_name') ?: $this->request->getVar('name');
        $shippingEmail = $this->request->getVar('shipping_email') ?: $this->request->getVar('email');
        $shippingPhone = $this->request->getVar('shipping_phone') ?: $this->request->getVar('phone');
        $shippingAddress = $this->request->getVar('shipping_address') ?: $this->request->getVar('address');
        $shippingCity = $this->request->getVar('shipping_city') ?: $this->request->getVar('city');
        $shippingState = $this->request->getVar('shipping_state') ?: $this->request->getVar('state');
        $shippingPin = $this->request->getVar('shipping_pin') ?: $this->request->getVar('pin_code');
         $shippingCountry = $this->request->getVar('shipping_country') ?: $this->request->getVar('country');

            
             if ($this->request->getVar('saved_address')=='Yes') {
                 
                   $address_data = array(
            'address_user_id' => $loginId,
            'address_book_user_name' => $this->request->getVar('name'),
            'address_book_email' => $this->request->getVar('email'),
            'address_book_phone' => $this->request->getVar('phone'),
            'address_book_address' => $this->request->getVar('address'),
            'address_book_city' => $this->request->getVar('city'),
            'address_book_state' => $this->request->getVar('state'),
            'address_book_pin_no' => $this->request->getVar('pin_code'),
              'order_country' => $this->request->getVar('country'),
            'address_shipping_user_name' => $shippingName,
            'address_shipping_email' => $shippingEmail,
            'address_shipping_phone' => $shippingPhone,
            'address_shipping_address' => $shippingAddress,
            'address_shipping_city' => $shippingCity,
            'address_shipping_state' => $shippingState,
            'address_shipping_pin_no' => $shippingPin,
            'order_shipping_country' =>$shippingCountry,
            );
            $AddressApplied = $commanmodel->insert_query('manage_address',$address_data);
            
            
        }


        // Preparing booking data
        $bookingData = [
           
            'order_book_user_id' => $loginId,
            'order_book_user_name' => $this->request->getVar('name'),
            'order_book_email' => $this->request->getVar('email'),
            'order_book_phone' => $this->request->getVar('phone'),
            'order_book_address' => $this->request->getVar('address'),
            'order_book_city' => $this->request->getVar('city'),
            'order_book_state' => $this->request->getVar('state'),
            'order_book_pin_no' => $this->request->getVar('pin_code'),
            'order_shipping_user_name' => $shippingName,
            'order_shipping_email' => $shippingEmail,
            'order_shipping_phone' => $shippingPhone,
            'order_shipping_address' => $shippingAddress,
            'order_shipping_city' => $shippingCity,
            'order_shipping_state' => $shippingState,
            'order_shipping_pin_no' => $shippingPin,
            'coupon_code' => $bookingInformetion['coupon'] ? $bookingInformetion['coupon']['coupon_code'] : '',
            'coupon_type' =>  $bookingInformetion['coupon'] ? $bookingInformetion['coupon']['coupon_type'] : '',
            'coupon_value' =>  $bookingInformetion['coupon'] ? $bookingInformetion['coupon']['coupon_value'] : '',
            'order_book_subtotal' => $bookingInformetion['subTotal'],
            'order_book_exclusive_gst' => $bookingInformetion['exclusiveGST'],
            'order_book_shipping' => $bookingInformetion['shipping'],
            'order_book_total' => $bookingInformetion['totalWithGST'],
            'order_book_status' => 'Pending',
            'order_book_pay_type' => $this->request->getVar('payment_method'),
            'order_book_date' =>  date("Y-m-d H:i:s"),
        ];

        // Insert the booking data into the database
        $Inserted = $commanmodel->insert_query_get_inserid('order_book', $bookingData);
        
            foreach($bookingInformetion['products'] as $item) {
                   $bookingNumber = $this->generateBookingNumber();
                     $product_data = array(
                'booking_product_vender' => $item['vender'],
                'booking_product_order_book_id' => $Inserted,
                'booking_product_order_id' => $bookingNumber,
                'booking_product_product_id' => $item['product_id'],
                'booking_product_product_name' =>  $item['product_name'],
                 'booking_product_varian' => $item['varian'],
                'booking_product_price' => $item['price'],
                'booking_product_shipping' => $item['shipping'],
                  'discount_per_product' => $item['discount_per_product'],
                'booking_product_quantity' => $item['quantity'],
                'booking_product_tax' =>  $item['tax'],
                'booking_product_tax_rate' =>  $item['tax_rate'],
                'booking_product_sub_total' =>  $item['sub_total'],
                'booking_product_image' =>  $item['image'],
                 'booking_product_status' => 'pending',
               
                );
                
                $commanmodel->insert_query('booking_product', $product_data);
            }
            
            
         
             return  $this->payment_confirmation($Inserted,$this->request->getVar('payment_method'),$bookingData);
           
        
    }
}

    private function payment_confirmation($Inserted, $paymentMethod, $bookingData)
{
    $commanmodel = new Commanmodel();

    if ($paymentMethod == 'COD') {
      
        $verification = $commanmodel->order_verification($Inserted);
        
        return redirect()->to('/order-invoice/'.$Inserted)->with('msg', $verification);
    } else {
         $this->ccavenues($Inserted, $paymentMethod, $bookingData);
    }

    // Add logic for other payment methods
   // return redirect()->to('/payment/gateway')->with('order_id', $bookingNumber);
}

    
  

private function ccavenues($Inserted, $paymentMethod, $bookingData)
{
    // NOTE: keys ko ideally config/.env se lo, hardcode mat karo
    $working_key = '2B22A1CD2B40A8555E922593845B938A';
    $access_code = 'AVQS82KF90CE31SQEC';
    $merchant_id = '2581359';

    $paydta = [];

    // CCAvenue fields
    $paydta['tid']           = ''; // optional; gateway usually generates
    $paydta['merchant_id']   = $merchant_id;
    $paydta['order_id']      = (string)$Inserted;
    $paydta['amount']        = number_format((float)$bookingData['order_book_total'], 2, '.', '');
    $paydta['currency']      = 'INR';
    $paydta['redirect_url']  = base_url('ccavenues-response/' . $Inserted);
    $paydta['cancel_url']    = base_url('ccavenues-response/' . $Inserted);
    $paydta['language']      = 'EN';

    // Billing
    $paydta['billing_name']     = $bookingData['order_book_user_name'] ?? '';
    $paydta['billing_address']  = $bookingData['order_book_address'] ?? '';
    $paydta['billing_city']     = $bookingData['order_book_city'] ?? '';
    $paydta['billing_state']    = $bookingData['order_book_state'] ?? '';
    $paydta['billing_zip']      = $bookingData['order_book_pin_no'] ?? '';
    $paydta['billing_country']  = 'India';
    $paydta['billing_tel']      = $bookingData['order_book_phone'] ?? '';
    $paydta['billing_email']    = $bookingData['order_book_email'] ?? '';

    // Optional
    $paydta['promo_code']          = '';
    $paydta['customer_identifier'] = '';

    // Build merchant_data string
    $merchant_data = '';
    foreach ($paydta as $key => $value) {
        // IMPORTANT: value me & ya special chars ho sakte hain, isliye encode
        $merchant_data .= $key . '=' . urlencode((string)$value) . '&';
    }

    $encrypted_data = $this->ccEncrypt($merchant_data, $working_key);

    // TEST endpoint (LIVE ke liye https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction)
    $actionUrl = "https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction";

    echo '<form method="post" name="redirect" action="' . htmlspecialchars($actionUrl, ENT_QUOTES, 'UTF-8') . '">';
    echo '<input type="hidden" name="encRequest" value="' . htmlspecialchars($encrypted_data, ENT_QUOTES, 'UTF-8') . '">';
    echo '<input type="hidden" name="access_code" value="' . htmlspecialchars($access_code, ENT_QUOTES, 'UTF-8') . '">';
    echo '</form>';
    echo "<script>document.redirect.submit();</script>";
}

// ---------- Helpers (class ke andar) ----------
private function ccEncrypt($plainText, $key)
{
    $key = $this->hexToBin(md5($key));
    $iv  = pack("C*", 0x00,0x01,0x02,0x03,0x04,0x05,0x06,0x07,0x08,0x09,0x0a,0x0b,0x0c,0x0d,0x0e,0x0f);

    $cipherText = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return bin2hex($cipherText);
}

private function ccDecrypt($encryptedText, $key)
{
    $key = $this->hexToBin(md5($key));
    $iv  = pack("C*", 0x00,0x01,0x02,0x03,0x04,0x05,0x06,0x07,0x08,0x09,0x0a,0x0b,0x0c,0x0d,0x0e,0x0f);

    $encryptedText = $this->hexToBin($encryptedText);
    return openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
}

private function hexToBin($hexString)
{
    return pack("H*", $hexString);
}




public function ccavenues_response($orderid = null)
{
    
     $commanmodel = new Commanmodel();
    if (empty($orderid)) {
        return redirect()->to(base_url('404'));
    }

    $current_order_id = $orderid;
    $OrderDetail = $commanmodel->order_detail_get_by_id_validate($current_order_id);

    if (!$OrderDetail) {
        return redirect()->to(base_url('404'));
    }

    // 1) encResp exists?
    $encResponse = $this->request->getPost('encResp');
    if (empty($encResponse)) {
        // CCAvenue ne response nahi bheja / direct hit hua
        session()->setFlashdata('square', 'Payment response not received.');
        return redirect()->to(base_url('home'));
    }

    // 2) Decrypt
    $workingKey = '2B22A1CD2B40A8555E922593845B938A';
    $rcvdString = $this->ccDecrypt($encResponse, $workingKey);

    if (empty($rcvdString)) {
        session()->setFlashdata('square', 'Unable to decrypt payment response.');
        return redirect()->to(base_url('home'));
    }

    // 3) Parse response safely by KEY, not index
    $resp = $this->parseCcResponse($rcvdString);

    $order_status = $resp['order_status'] ?? '';
    $order_TXNID  = $resp['tracking_id'] ?? ($resp['bank_ref_no'] ?? '');

    // Optional extra verification (recommended)
    $resp_order_id = $resp['order_id'] ?? null;
    if ($resp_order_id && (string)$resp_order_id !== (string)$orderid) {
        session()->setFlashdata('square', 'Order ID mismatch in payment response.');
        return redirect()->to(base_url('home'));
    }

    // 4) Handle status
    if (strcasecmp($order_status, 'Success') === 0) {

        date_default_timezone_set("Asia/Kolkata");

        $cofirmrray = [
            'order_TXNID'          => $order_TXNID,
            'order_payment_status' => 'success',
            'order_TXNDATE'        => date("Y-m-d H:i:s"),
        ];

        // (Optional) aapka verification call
        $commanmodel->order_verification($orderid);

        $update = $commanmodel->update_query(
            'order_book',
            $cofirmrray,
            ['order_book_id' => $orderid]
        );

        if ($update) {
            // Send email
            $name  = $OrderDetail->name ?? 'Customer';
            $email = $OrderDetail->email ?? '';

            if (!empty($email)) {
                $htmldata = "
                    <p>Dear {$name},</p>
                    <p>Thank you for placing your order with <strong>Hey Wansaa</strong>.</p>
                    <p>We are pleased to inform you that your payment has been received successfully.</p>
                    <p><strong>Transaction ID:</strong> {$order_TXNID}</p>
                    <p><strong>Order ID:</strong> {$orderid}</p>
                    <p>Your order is now being processed. You will receive further updates shortly.</p>
                    <p>Best Regards,<br>Team Hey Wansaa</p>
                ";

                $emailService = \Config\Services::email();
                $emailService->setFrom('no-reply@heywansaa.com', 'Hey Wansaa');
                $emailService->setTo($email);
                $emailService->setSubject('Payment Successful – Order Confirmation');
                $emailService->setMessage($htmldata);
                $emailService->setMailType('html');
                $emailService->send();
            }

            return redirect()->to(base_url('thank-you'));
        }

        session()->setFlashdata('square', 'Payment success, but order update failed.');
        return redirect()->to(base_url('home'));

    } else {
        // Failure / Aborted / Invalid
        $failureMsg = $resp['failure_message'] ?? $resp['status_message'] ?? 'Your payment failed or was cancelled.';
        session()->setFlashdata('square', $failureMsg);
        return redirect()->to(base_url('home'));
    }
}




/** Parse "key=value&key2=value2" into array */
private function parseCcResponse($rcvdString)
{
    $out = [];
    $pairs = explode('&', $rcvdString);

    foreach ($pairs as $pair) {
        if (strpos($pair, '=') === false) continue;

        [$k, $v] = explode('=', $pair, 2);
        $k = trim($k);
        $v = urldecode(trim($v));

        if ($k !== '') $out[$k] = $v;
    }

    return $out;
}


    public function order_invoice($Inserted)
    {
          $commanmodel = new Commanmodel();
         $session = session();
 $msg = $session->getFlashdata('msg');
    $order = $commanmodel->get_single_query('order_book',array('order_book_id'=> $Inserted));
       
       $data = array(
            'title' => "contact us : Rent House", 
            'keyword' => "Home : Rent House",
            'description' => "Home : Rent House",
            'search' => '',
          'order' => '',
          'msg' => $msg,
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            'pageimage' => base_url('assets/frontend/assets/img/logo.png')
            );
        return view('frontend/header',$data).view('frontend/invoice').view('frontend/footer');
    }
    
  

    public function generateBookingNumber() {
        $prefix = 'ORDER'; // You can customize the prefix
        $timestamp = time(); // Get the current timestamp
        $randomPart = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6); // Generate a random alphanumeric string
    
        $bookingNumber = $prefix . $timestamp . $randomPart;
        return $bookingNumber;
    }

}
