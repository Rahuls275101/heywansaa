<?php
namespace App\Controllers;
use CodeIgniter\Email\Email;
use App\Models\Commanmodel;
require_once(APPPATH . "Libraries/config.php");
require_once(APPPATH . "Libraries/razorpay-php/Razorpay.php");

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
class Dashboard extends BaseController
{

 
    public function index()
    {
        $session = session();
        $commanmodel = new Commanmodel();
         $usersession = $session->get('loggedin');
         $userdata = $commanmodel->get_single_query('user_account',array('account_id'=> $usersession['user_id']));
         
          $order=$commanmodel->all_multiple_query_order_by('order_book',array('order_book_user_id'=> $usersession['user_id'],'order_book_status'=> 'Success'),'order_book_id','DESC');
          
        $data = array(
        'title' => "Home : Event", 
        'keyword' => "Home : Event",
        'description' => "Home : Event",
        'search' => '',
        'userdata' => $userdata,
        'order' => $order,
        'searchcategory' => 'all',
        'pageurl' => base_url(), 
        'pageimage' => base_url('assets/images/logo.png')
		);


       
          return view('frontend/header', $data).view('frontend/dashboard/index').view('frontend/footer');
    }
    
      public function checkout($id)
    {
        
        session()->set('redirect_url', current_url());
        
        $session = session();
        $commanmodel = new Commanmodel();
         $usersession = $session->get('loggedin');
         $userdata = $commanmodel->get_single_query('user_account',array('account_id'=> $usersession['user_id']));
        $data = array(
        'title' => "Checkout : Event", 
        'keyword' => "checkout : Event",
        'description' => "checkout : Event",
        'search' => '',
        'userdata' => $userdata,
        'id' => $id,
        'searchcategory' => 'all',
        'pageurl' => base_url(), 
        'pageimage' => base_url('assets/images/logo.png'),
        'validation' => \Config\Services::validation()
		);


       
          return view('frontend/header', $data).view('frontend/checkout').view('frontend/footer');
    }
    
    
public function proceed_to_payment($id) {
    $session = session();
    $commanmodel = new Commanmodel();

    // Define validation rules
        $rules = [
            'name' => [
                'label'  => 'Name',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please Enter First Name',
                ],
            ],
            'lastname' => [
                'label'  => 'lastname',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please Enter last name',
                   
                ],
            ],
              'email' => [
                'label'  => 'email',
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required' => 'Please Enter email',
                    'valid_email' => 'Please Enter valid email',
                ],
            ],
        
          'phone' => [
                'label'  => 'phone',
                'rules'  => 'required|min_length[10]|max_length[13]',
                'errors' => [
                    'required' => 'Please Enter phone',
                    'min_length'  =>  'Please Enter phone min length 10!',
                    'max_length'  =>  'Please Enter phone max length 13!',
                   
                ],
            ],
         'country' => [
                'label'  => 'country',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please Select country',
                   
                ],
            ],
             'address' => [
                'label'  => 'address',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please Enter address',
                   
                ],
            ],
             'city' => [
                'label'  => 'city',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please Enter city',
                   
                ],
            ],
              'state' => [
                'label'  => 'state',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please Enter state',
                   
                ],
            ],
              'zip' => [
                'label'  => 'zip',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please Enter zip',
                   
                ],
            ],
        
       
        ];

    // Validate form input
    if ($this->validate($rules)) {
        // Get user input
      $usersession = $session->get('loggedin');
        
         $property = $commanmodel->get_single_query('property',array('property_id'=> $id));
        // Add other necessary fields
$orderIdGenerate = $commanmodel->generate_order_id();
        // Prepare data for insertion
        $data = [
            'name' => $this->request->getVar('name'),
            'lastname' => $this->request->getVar('lastname'),
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phone'),
            'country' => $this->request->getVar('country'),
            'address' => $this->request->getVar('address'),
            'city' => $this->request->getVar('city'),
            'state' => $this->request->getVar('state'),
            'zip' => $this->request->getVar('zip'),
            'order_vender_id' => $property->property_create_by,
             'order_pro_id' => $id,
            'order_user_id' => $usersession['user_id'],
            'order_bill_id' =>$orderIdGenerate,
          
              'status' => 'Inactive',
             
            // Add other necessary fields
        ];

        // Insert user data into the database
        
       $inserid=  $commanmodel->insert_query_get_inserid('order',$data);
        
        
        
        
        
        
        if ($inserid) {
           	  $api = new Api('rzp_test_qThjo54DWyFKHa', 'zRAGwRhizipHqH6wDpeSvNCU');

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders


//
$orderData = [
    'receipt'         => $orderIdGenerate,
    'amount'          => $property->property_price * 100, // 2000 rupees in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];	
			   
$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount']/100;  
			     
			     $checkout = 'automatic';

if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
{
    $checkout = $_GET['checkout'];
}

$data = [
    "key"               => 'rzp_test_qThjo54DWyFKHa',
    "amount"            => $amount,
    "name"              => "HABBYAT",
    "description"       => "Tron Legacy",
    "image"             =>  base_url()."assets/frontend/images/logo.png",
    "prefill"           => [
    "name"              => $this->request->getVar('name'),
    "email"             => $this->request->getVar('email'),
    "contact"           => $this->request->getVar('phone'),
    ],
    "notes"             => [
    "address"           => '',
    "merchant_order_id" => $orderIdGenerate,
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];


    $data['display_currency']  = 'INR';
    $data['display_amount']    = $amount;


$json = json_encode($data);
		?>
       
      
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<form name='razorpayform' action="<?php echo base_url()?>/order_response/<?php echo $orderIdGenerate; ?>" method="POST">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
</form>
<script>
// Checkout details as a json
var options = <?php echo $json?>;

/**
 * The entire list of Checkout fields is available at
 * https://docs.razorpay.com/docs/checkout-form#checkout-fields
 */
options.handler = function (response){
    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
    document.getElementById('razorpay_signature').value = response.razorpay_signature;
   // alert(response.razorpay_signature);
    document.razorpayform.submit();
};

// Boolean whether to show image inside a white frame. (default: true)
options.theme.image_padding = false;

options.modal = {
    ondismiss: function() {
        console.log("This code runs when the popup is closed");
    },
    // Boolean indicating whether pressing escape key 
    // should close the checkout form. (default: true)
    escape: true,
    // Boolean indicating whether clicking translucent blank
    // space outside checkout form should close the form. (default: false)
    backdropclose: false
};

var rzp = new Razorpay(options);


    rzp.open();
    e.preventDefault();

</script> 
<?php	     
        } else {
            $session->setFlashdata('registration_failed', 'Registration failed. Please try again.');
            $usersession = $session->get('loggedin');
        
         $userdata = $commanmodel->get_single_query('user_account',array('account_id'=> $usersession['user_id']));
           $data = array(
        'title' => "Checkout : Event", 
        'keyword' => "checkout : Event",
        'description' => "checkout : Event",
        'search' => '',
        'userdata' => $userdata,
        'id' => $id,
        'searchcategory' => 'all',
        'pageurl' => base_url(), 
        'pageimage' => base_url('assets/images/logo.png'),
       'validation' => $this->validator
		);


       
          return view('frontend/header', $data).view('frontend/checkout').view('frontend/footer');
        }
    } else {
        // Validation failed, return to registration form with errors
         $usersession = $session->get('loggedin');
        
         $userdata = $commanmodel->get_single_query('user_account',array('account_id'=> $usersession['user_id']));
        $data = array(
        'title' => "Checkout : Event", 
        'keyword' => "checkout : Event",
        'description' => "checkout : Event",
        'search' => '',
        'userdata' => $userdata,
        'id' => $id,
        'searchcategory' => 'all',
        'pageurl' => base_url(), 
        'pageimage' => base_url('assets/images/logo.png'),
       'validation' => $this->validator
		);


       
          return view('frontend/header', $data).view('frontend/checkout').view('frontend/footer');
        
        
        

    }
}
 public function order_response($orderid=NULL)
      {
           $session = session();
    $commanmodel = new Commanmodel();
      $current_order_id = $orderid; 
      $OrderDetail = $commanmodel->order_detail_get_by_id_validate_order($current_order_id);
      if($OrderDetail)
      {
       
        
        
        		$success = true;

        $error = "Payment Failed";
        
        if (empty($_POST['razorpay_payment_id']) === false)
        {
           $api = new Api('rzp_test_qThjo54DWyFKHa', 'zRAGwRhizipHqH6wDpeSvNCU');
        
            try
            {
                // Please note that the razorpay order ID must
                // come from a trusted source (session here, but
                // could be database or something else)
                $attributes = array(
                    'razorpay_order_id' => $_SESSION['razorpay_order_id'],
                    'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                    'razorpay_signature' => $_POST['razorpay_signature']
                );
        
                $api->utility->verifyPaymentSignature($attributes);
            }
            catch(SignatureVerificationError $e)
            {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }
        
        
        }
                
        
         if ($success === true)
{
                         		
                         	date_default_timezone_set("Asia/Kolkata");
                      
                         		
                                        
                            		    $cofirmrray['order_TXNID'] = $_POST["razorpay_payment_id"];
                            		    $cofirmrray['order_payment_status'] = 'success';
                            		    $cofirmrray['order_TXNDATE'] = date("Y-m-d h:i:s");
                            		    $cofirmrray['order_TXN_signature'] = $_POST['razorpay_signature'];
                            		     $cofirmrray['status'] ='Active';
                            	
                            		    
                            		   
                                       
                                       $update = $commanmodel->update_query('order', $cofirmrray, array('order_bill_id' =>$current_order_id)); 
                                       
                                     
                                       
                                           $order =$commanmodel->get_single_query('order',array('order_bill_id' => $current_order_id));
                                       
                                                         $to = $order->email;
$subject = 'Thank You for Your order .';
$from = 'info@ase-electrical.co.uk';
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
// Compose a simple HTML email message


// Compose the HTML content for the email
$htmldata = "   <p>Dear ".$order->name.",</p>
    <p>Thank you for order</p>
    <p>Thank you again for choosing us!</p>
    <p>Best Regards,</p>
    <p>Team Rent House</p>";


// Path to the email template file
// $template_file = FCPATH . 'assets/frontend/mysendmail.php';


//     $body = file_get_contents($template_file);
    
//     // Replace the placeholders in the template file
//     $body = str_replace("{news}", $htmldata, $body);
    
    
    
// Sending email
mail($to, $subject, $htmldata, $headers);
                                       
                        				
                        					
                        				if($update) {
                        				   
            return redirect()->to('/thank_you');
                        				}
			                         	
	     	
			                         	


	
           
                         		
                         		
                         		
}
else
{
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
             	$this->session->set_flashdata('square', 'Your payment failed');
			 
			                            redirect(base_url().'home');
}
        
       
      }
      else
      {
        return redirect('404');
      }
      }
      
      
      public function thank_you()
    {
         $data = array(
        'title' => "Thank you : Event", 
        'keyword' => "Home : Event",
        'description' => "Home : Event",
        'search' => '',
       
        'searchcategory' => 'all',
        'pageurl' => base_url(), 
        'pageimage' => base_url('assets/images/logo.png')
		);


       
          return view('frontend/header', $data).view('frontend/thank_you').view('frontend/footer');
    }
      
public function update_user()
    {
        $session = session();
        $commanmodel = new Commanmodel();
        $usersession = $session->get('loggedin');
        $data = array( 
        
    
            'user_name' => $this->request->getVar('user_name'),
            'date_of_birth' => $this->request->getVar('date_of_birth'),
            'gender' => $this->request->getVar('gender'),
            'user_phone' => $this->request->getVar('user_phone'),
            'marital_status' => $this->request->getVar('marital_status'),
            'user_email' => $this->request->getVar('user_email'),
            'user_address' => $this->request->getVar('user_address'),
                 );

                
             $where = array(             
             'account_id' =>$usersession['user_id']
                 );
             $updated=$commanmodel->update_query('user_account',$data,$where);
           
                    if($updated) {
                        $response = [
                            "title" => 'Success',
                            "class" => 'success',
                            "message" => 'This Tour User has been updated successfully'
                           
                        ];
                    } else {
                        $response = [
                            "title" => 'Warning',
                            "class" => 'warning',
                            "message" => 'This Tour User has not been updated successfully'
                           
                        ];
                    }

        
                    echo json_encode($response);
    }
    
    
      public function order_details($id)
{
     $session = session();
 
      $commanmodel = new Commanmodel();
   
       $item = $commanmodel->get_single_query('booking_product',array('booking_product_order_id'=> $id));
        $vender = $commanmodel->get_single_query('admin',array('id'=> $item->booking_product_vender));
     
          $order = $commanmodel->get_single_query('order_book',array('order_book_id'=> $item->booking_product_order_book_id));
          
                $data = array(
        'title' => "Thank you : Event", 
        'keyword' => "Home : Event",
        'description' => "Home : Event",
        'search' => '',
        'order'=>$order,
      'item' => $item,
      'vender' => $vender,
     
           'id' => $id,  
        'searchcategory' => 'all',
        'pageurl' => base_url(), 
        'pageimage' => base_url('assets/images/logo.png')
		);


       
          return view('frontend/header', $data).view('frontend/dashboard/order_details').view('frontend/footer');
}
}
