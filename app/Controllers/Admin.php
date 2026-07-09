<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPExcel_IOFactory;
use App\Models\Commanmodel;
use App\Models\Answarmodel;
use App\Models\Usermodel;
use App\Models\Franchisemodel;
use App\Models\Questionsmodel;

require_once(APPPATH . "Libraries/config.php");
require_once(APPPATH . "Libraries/razorpay-php/Razorpay.php");

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;


class Admin extends BaseController
{

 
    public function index()
    {
        $session = session();
        
           
        
        
        $commanmodel = new Commanmodel();
        return view('admin/login');
    }

    public function admin_login() {
       
        $session = session();
        $commanmodel = new Commanmodel();
        $rules = [
           
            'email'         => 'required|valid_email',
            'password'      => 'required|min_length[5]|max_length[16]',
            
        ];

        if($this->validate($rules)){

            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');
           // password_hash($password, PASSWORD_DEFAULT);
            $admindetails =$commanmodel->login_valid($email);
            
            if($admindetails){
                
                if($admindetails->status == 'Active') {
                $pass = $admindetails->password;
                $authenticatePassword = password_verify($password, $pass);
                if($authenticatePassword){
                    
                     
                    $ses_data = [
                        'id' => $admindetails->id,
                         'employee_id' => $admindetails->employee_id,
                         'name' => $admindetails->name,
                        'email' => $admindetails->email,
                         'image' => $admindetails->admin_image,
                        'name' => $admindetails->name,
                        'position' => $admindetails->position, 
                        'admin_type' => $admindetails->admin_type,
                        
                        'isLoggedIn' => TRUE
                    ];
                    $session->set($ses_data);
                    return redirect()->to('admin/dashboard');
                
                }else{
                    $session->setFlashdata('login_failed', 'Password is incorrect.');
                    return redirect()->to('/admin');
                }
                
                } else {
                   $session->setFlashdata('login_failed', 'Your account is not yet approved. Please contact the administrator.');

               
                return redirect()->to('/admin');
                }
            } else{
          

                $session->setFlashdata('login_failed', 'Invalid Email-Id and Password');
               
                return redirect()->to('/admin');
            }

           
        }else{
          

            $session->setFlashdata('login_failed', 'Invalid Email-Id and Password');
           
            return redirect()->to('/admin');
        }
       
      
       
    }


  public function vender_register()
    {
        $session = session();
        $commanmodel = new Commanmodel();
         $data = array(
            'title' => "Vender Register : Rent House", 
            'keyword' => "Home : Rent House",
            'description' => "Home : Rent House",
            'search' => '',
           
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            'pageimage' => base_url('assets/frontend/assets/img/logo.png'),
            'validation' => \Config\Services::validation()
            );
        return view('admin/register',$data);
    }



public function vender_register_proccess() {
    $session = session();
    $commanmodel = new Commanmodel();

    // Define validation rules
    $rules = [
        'email' => 'required|valid_email|is_unique[admin.email]',
        'phone' => 'required|min_length[10]|max_length[13]',
        'password' => 'required|min_length[6]|max_length[16]',
        'confirm_password' => 'required|matches[password]',
        'name' => 'required',
        // Add other necessary validation rules
    ];

    // Validate form input
    if ($this->validate($rules)) {
        // Get user input
        $email = $this->request->getVar('email');
        $password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
        $name = $this->request->getVar('name');
        $phone = $this->request->getVar('phone');
        // Add other necessary fields
$orderIdGenerate = $commanmodel->generate_order_id();
        // Prepare data for insertion
        $data = [
            'email' => $email,
            'password' => $password,
            'name' => $name,
            'phone' => $phone,
             'orderid' => $orderIdGenerate,
              'status' => 'Inactive',
               'status_color' => 'danger',
               'admin_type' => 'Admin',
            // Add other necessary fields
        ];

        // Insert user data into the database
        
       $inserid=  $commanmodel->insert_query_get_inserid('admin',$data);
        
         $to = $email;
                $subject = 'Thank You for Registering';
                $from = 'no-reply@heywansaa.com';

                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: ' . $from . "\r\n" .
                  
                    'X-Mailer: PHP/' . phpversion();

 $htmldata = "
<p>Dear $name,</p>

<p>Thank you for registering with Hey Wansaa.</p>

<p>Your vendor account request has been received and is currently under review.</p>

<p>To complete the verification process, we kindly request you to share the following documents:</p>

<p>
• Aadhaar Card<br>
• PAN Card<br>
• GST Number / GST Registration Certificate (if applicable)
</p>

<p>Please share the above details at your earliest convenience so that we can proceed with the verification of your account.</p>

<p>You will receive another email once your account has been verified and approved by our team.</p>

<p>We appreciate your cooperation.</p>

<p>Best Regards,<br>Team Hey Wansaa</p>
";


                mail($to, $subject, $htmldata, $headers);
        
        

        
        if ($inserid) {
            $session->setFlashdata('registration_success', 'Your account has been created successfully. Please wait for approval.');
            return redirect()->to('/vender_register');
            
        } else {
            $session->setFlashdata('registration_failed', 'Registration failed. Please try again.');
            return redirect()->to('/vender_register');
        }
    } else {
        // Validation failed, return to registration form with errors
        $data = [
            'title' => "Vender Register : Rent House",
            'keyword' => "Home : Rent House",
            'description' => "Home : Rent House",
            'search' => '',
            'searchcategory' => 'all',
            'pageurl' => base_url(),
            'pageimage' => base_url('assets/frontend/assets/img/logo.png'),
            'validation' => $this->validator
        ];

        return view('admin/register',$data);
    }
}


 public function vender_response($orderid=NULL)
      {
           $session = session();
    $commanmodel = new Commanmodel();
      $current_order_id = $orderid; 
      $OrderDetail = $commanmodel->order_detail_get_by_id_validate($current_order_id);
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
                            		      $cofirmrray['status_color'] = 'success';
                            		    
                            		    
                                       
                                       $update = $commanmodel->update_query('admin', $cofirmrray, array('orderid' =>$_SESSION['razorpay_order_id'])); 
                                       
                                           $order =$commanmodel->get_single_query('admin',array('orderid' => $current_order_id));
                                       
                                                         $to = $order->email;
$subject = 'Thank You for Your Vender Register .';
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
    <p>Thank you for Vender Registeration</p>
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
                        				    $session->setFlashdata('success', 'Registration successful. You can now log in.');
            return redirect()->to('/vender_register');
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
    public function dashboard()
    {
         $session = session();
       $commanmodel = new Commanmodel();
       $table_header = [
                
            ['data' => 'id'],
             ['data' => 'img'],
              ['data' => 'item'],
              ['data' => 'category'],
               ['data' => 'price'],
                ['data' => 'seller'],
                 ['data' => 'payment_type'],
                ['data' => 'shipping_address'],
                 ['data' => 'stauts'],
                  ['data' => 'action'],
          
      
           
        
        ];
        
        $data['table_column'] = json_encode($table_header);
        
         $data['vender'] = $commanmodel->get_single_query_count('admin',array()) - 1;
         $data['user'] = $commanmodel->get_single_query_count('user_account',array());
         $data['product'] = $commanmodel->get_single_query_count('product',array());
          $data['order'] = $commanmodel->get_single_query_count('order_book',array('order_book_status'=>'Success'));
         
     
        return view('admin/head').view('admin/sidebar').view('admin/index',$data).view('admin/footer');
       
    }
    
    
    
    
      public function logout() {
        $session = session();
        $session->destroy();
        
        $session->setFlashdata('login_failed', 'Successfully logged out!');
        return redirect()->to('/admin'); // Adjust the redirect URL as per your application's routes
    }


 public function setting()
    { 
        
        $session = session();
       $commanmodel = new Commanmodel();
        $data['addressView'] = $commanmodel->get_single_query('address',array('id' => 1));  
        
       return view('admin/head').view('admin/sidebar').view('admin/setting',$data).view('admin/footer');
       
    }

public function address_manage_process()
{
    $session = session();
    $commanmodel = new Commanmodel();

    // Check if page is being updated
    if ($this->request->getVar('pageUpdated')) {
        
        // Validate header logo only if a new file is uploaded
        if ($this->request->getFile('header_logo')->isValid()) {
            $validatedheaderlogo = $this->validate([
                'header_logo' => [
                    'label' => 'Image File',
                    'rules' => 'uploaded[header_logo]'
                        . '|is_image[header_logo]'
                        . '|mime_in[header_logo,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                ],
            ]);
            
            if ($validatedheaderlogo) {
                $fileheader = $this->request->getFile('header_logo');
                $header_logo = $fileheader->getRandomName();
                $fileheader->move('assets/img', $header_logo);
            } else {
                $header_logo = $this->request->getVar('edit_header_logo'); // Use existing header logo if no new file
            }
        } else {
            $header_logo = $this->request->getVar('edit_header_logo'); // Use existing header logo if no file uploaded
        }

        // Validate footer logo only if a new file is uploaded
        if ($this->request->getFile('footer_logo')->isValid()) {
            $validatedfooterlogo = $this->validate([
                'footer_logo' => [
                    'label' => 'Image File',
                    'rules' => 'uploaded[footer_logo]'
                        . '|is_image[footer_logo]'
                        . '|mime_in[footer_logo,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                ],
            ]);
            
            if ($validatedfooterlogo) {
                $filefooter = $this->request->getFile('footer_logo');
                $footer_logo = $filefooter->getRandomName();
                $filefooter->move('assets/img', $footer_logo);
            } else {
                $footer_logo = $this->request->getVar('edit_footer_logo'); // Use existing footer logo if no new file
            }
        } else {
            $footer_logo = $this->request->getVar('edit_footer_logo'); // Use existing footer logo if no file uploaded
        }

        // Prepare the data for insertion
        $post_data = [
            'header_logo' => $header_logo,
            'footer_logo' => $footer_logo,
            'web_name' => $this->request->getVar('web_name'),
            'email' => $this->request->getVar('email'),
            'phone_one' => $this->request->getVar('phone_one'),
            'phone_two' => $this->request->getVar('phone_two'),
         
            'address' => $this->request->getVar('address'),
            'address_tow' => $this->request->getVar('address_tow'),
            'copyright' => $this->request->getVar('copyright'),
            'facebook' => $this->request->getVar('facebook'),
            'twitter' => $this->request->getVar('twitter'),
            'linkedin' => $this->request->getVar('linkedin'),
            'instagram' => $this->request->getVar('instagram'),
        ];

        // Attempt to update the data in the database
        $inserted = $commanmodel->update_query('address', $post_data, ['id' => 1]);

        // Handle success or failure
        if ($inserted) {
            $session->setFlashdata('created', 'This Website Settings has been updated.');
            return redirect()->to(base_url('admin/setting'));
        } else {
            $session->setFlashdata('failed', 'Sorry, this address has not been updated. Please try again.');
            $data['addressView'] = $commanmodel->get_single_query('address', ['id' => 1]);
            return view('admin/head') . view('admin/sidebar') . view('admin/setting', $data) . view('admin/footer');
        }

    } else {
        // Handle if 'pageUpdated' is not set
        $session->setFlashdata('failed', 'Submit process is not working!');
        $data['addressView'] = $commanmodel->get_single_query('address', ['id' => 1]);
        return view('admin/head') . view('admin/sidebar') . view('admin/setting', $data) . view('admin/footer');
    }
}





public function password_manage_process()
{
    $session = session();
    $commanmodel = new Commanmodel();

    if ($this->request->getVar('pageUpdated')) {
        
        // Profile image upload handling
        $profile_images = $this->request->getVar('edit_profile_images');
        if ($this->request->getFile('profile_images')->isValid()) {
            $validated = $this->validate([
                'profile_images' => [
                    'label' => 'Image File',
                    'rules' => 'uploaded[profile_images]'
                        . '|is_image[profile_images]'
                        . '|mime_in[profile_images,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                ],
            ]);
            
            if ($validated) {
                $file = $this->request->getFile('profile_images');
                $profile_images = $file->getRandomName();
                $file->move('assets/img', $profile_images);
            }
        }

        // Prepare the data for update
        $post_data = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('login_email'),
            'admin_address' => $this->request->getVar('admin_address'),
            'admin_image' => $profile_images,
            // Warehouse Details
            'warehouse_primary_name' => $this->request->getVar('warehouse_primary_name'),
            'warehouse_name' => $this->request->getVar('warehouse_name'),
            'warehouse_address' => $this->request->getVar('warehouse_address'),
            'warehouse_address_2' => $this->request->getVar('warehouse_address_2'),
            'warehouse_city' => $this->request->getVar('warehouse_city'),
            'warehouse_state' => $this->request->getVar('warehouse_state'),
            'warehouse_pincode' => $this->request->getVar('warehouse_pincode'),
            'warehouse_phone' => $this->request->getVar('warehouse_phone'),
        ];

        // Update password if provided
        $password = $this->request->getVar('password');
        if (!empty($password)) {
            $post_data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Attempt to update the data in the database
        $inserted = $commanmodel->update_query('admin', $post_data, ['id' => $session->id]);

        // Handle success or failure
        if ($inserted) {
            $session->setFlashdata('created', 'Profile has been updated successfully.');
            return redirect()->to(base_url('admin/setting'));
        } else {
            $session->setFlashdata('failed', 'Sorry, profile has not been updated. Please try again.');
            return redirect()->to(base_url('admin/setting'));
        }

    } else {
        $session->setFlashdata('failed', 'Submit process is not working!');
        return redirect()->to(base_url('admin/setting'));
    }
}

     public function home_banner()
    {    $session = session();
        $commanmodel = new Commanmodel();
        $data['bannerView'] = $commanmodel->get_multiple_query_order_by('home_banner','banner_id','DESC');    

        
        return view('admin/head').view('admin/sidebar').view('admin/banner',$data).view('admin/footer');
     
    }
    
    
    
    
    
    
     public function home_banner_process()
    {
        $session = session();
        $commanmodel = new Commanmodel();
        $data['bannerView'] = $commanmodel->get_multiple_query_order_by('home_banner','banner_id','DESC');
        if($this->request->getVar('upload_banner'))
        {
            if($_FILES['home_banner']['name']!=""){
          
                
                $file = $this->request->getFile('home_banner');

        // Generate a new secure name
        $home_banner = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/images', $home_banner);
            }
            else{
            $session->setFlashdata('failed', 'Please choose banner image!');    
          
            
            return view('admin/head').view('admin/sidebar').view('admin/banner',$data).view('admin/footer');
            }
			 
        $post_data = array(
        'banner_image' => $home_banner,
		'banner_first_title' => $this->request->getVar('first_title'),
			'banner_first_second' => $this->request->getVar('banner_first_second'),
	'banner_date' => $this->request->getVar('date'),
        'redirect_url' => $this->request->getVar('redirect_url')
	
        );
        $inserted = $commanmodel->insert_query('home_banner',$post_data); 
                   if($inserted)
                   {
                    $session->setFlashdata('created', 'This Home Banner has been uploaded successfully.');
                     return redirect()->to('/admin/home_banner');
                   }
                   else
                   {
            $session->setFlashdata('failed', 'Sorry, This Home Banner has not been uploaded.');      
   
        return view('admin/head').view('admin/sidebar').view('admin/banner',$data).view('admin/footer');
                   }


            }
        else
        {
        $session->setFlashdata('failed', 'Submit process is not working!');      
      return view('admin/head').view('admin/sidebar').view('admin/banner',$data).view('admin/footer');
        }  

       
    }


    public function edit_home_banner($banner_id)
    {
        $session = session();
        $commanmodel = new Commanmodel();
        $data['bannerView'] = $commanmodel->get_single_query('home_banner',array('banner_id' => $banner_id));    
    
        return view('admin/head').view('admin/sidebar').view('admin/edit-home-banner',$data).view('admin/footer');
       
    }

    public function edit_home_banner_process($banner_id)
    {
        $session = session();
        $commanmodel = new Commanmodel();
        $data['bannerView'] = $commanmodel->get_single_query('home_banner',array('banner_id' => $banner_id)); 
        if($this->request->getVar('EditBanner'))
        {
            if($_FILES['banner_image']['name']!=""){
                
                $file = $this->request->getFile('banner_image');

        // Generate a new secure name
        $home_banner = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/images', $home_banner);
            }
            else{
              $home_banner = $this->request->getVar('banner_image_old');
            }
        if($this->request->getVar('banner_status')=='Active')
        {
          $banner_status_color = 'success';
        }
        if($this->request->getVar('banner_status')=='Inactive')
        {
          $banner_status_color = 'danger';
        }
        $post_data = array(
     'banner_image' => $home_banner,
		'banner_first_title' => $this->request->getVar('first_title'),
		'banner_first_second' => $this->request->getVar('banner_first_second'),
	'banner_date' => $this->request->getVar('date'),
        'redirect_url' => $this->request->getVar('redirect_url'),
        'banner_status' => $this->request->getVar('banner_status'),
        'banner_status_color' => $banner_status_color 
        );
        $updated = $commanmodel->update_query('home_banner',$post_data,array('banner_id' => $banner_id)); 
        if($updated)
        {
        $session->setFlashdata('created', 'This banner has been updated.');
         return redirect()->to('/admin/home_banner');
        }
        else
        {
        $session->setFlashdata('failed', 'Sorry, This banner has not been uploaded.');     
      return view('admin/head').view('admin/sidebar').view('admin/edit-home-banner',$data).view('admin/footer');
        }
            }
        else
        {
        $session->setFlashdata('failed', 'Submit process is not working!');  
        
     return view('admin/head').view('admin/sidebar').view('admin/edit-home-banner',$data).view('admin/footer');
        }  
       
    }




    public function delete_home_banner($banner_id)
    {
        $session = session();
        $commanmodel = new Commanmodel();
     $deleteClient = $commanmodel->delete_query('home_banner',array('banner_id' =>$banner_id));
     if($deleteClient)
     {
      $session->setFlashdata('created', 'This Home Banner is delete.');
       return redirect()->to('/admin/home_banner');
     }
     else
     {
      $session->setFlashdata('failed', 'This Home Banner is not delete!');
       return redirect()->to('/admin/home_banner'); 
     }
    
    }





public function cms_pages()
    {
       
             $commanmodel = new Commanmodel();
        $data['cmsView'] = $commanmodel->get_multiple_query_order_by('cms_pages','cms_id','ASC');    
       
        
          return view('admin/head').view('admin/sidebar').view('admin/cms-pages',$data).view('admin/footer');
       
    }


    public function edit_cms($cms_id)
    {
          $commanmodel = new Commanmodel();
        $data['cmsView'] = $commanmodel->get_single_query('cms_pages',array('cms_id' => $cms_id));    
        
        return view('admin/head').view('admin/sidebar').view('admin/edit-cms',$data).view('admin/footer');
       
    }




 public function edit_cms_process($cms_id)
    {
        
             $session = session();
        $commanmodel = new Commanmodel();
         if($this->request->getVar('pageUpdated'))
        {
              if($_FILES['product_image']['name']!=""){
         
                
                       $file = $this->request->getFile('product_image');

        // Generate a new secure name
        $image = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/images', $image);
            }
            else{
                  $image=$this->request->getVar('product_image_old');
            }
            
            
    $post_data = array(
        'cms_image' =>  $image,
    'cms_page_heading' =>$this->request->getVar('cms_page_heading'),
    'cms_page_small_description' =>$this->request->getVar('cms_page_small_description'),
    'cms_page_description' =>$this->request->getVar('cms_page_description')
    );
                   $inserted = $commanmodel->update_query('cms_pages',$post_data,array('cms_id' => $cms_id)); 
                   if($inserted)
                   {
                     $session->setFlashdata('created', 'This Page contant has been updated.');
           
                    return redirect()->to('admin/cms_pages');
                   }
                   else
                   {
             $session->setFlashdata('failed', 'Sorry, This blog has not been updated. Please try again?');    
        $data['cmsView'] = $commanmodel->get_single_query('cms_pages',array('cms_id' => $cms_id));    
      return view('admin/head').view('admin/sidebar').view('admin/edit-cms',$data).view('admin/footer');
                   }


                
        }
        else
        {
             $session->setFlashdata('failed', 'Submit process is not working!');    
        $data['cmsView'] = $commanmodel->get_single_query('cms_pages',array('cms_id' => $cms_id));    
       return view('admin/head').view('admin/sidebar').view('admin/edit-cms',$data).view('admin/footer');
        }



       
    }
    
private function getnamecategory($id) {
    $commanmodel = new Commanmodel();
    $name = '';
    $currentCategory = $commanmodel->get_single_query('category', ['category_id' => $id]);
    if ($currentCategory) {
        // Recursively fetch the parent category first
        $name .= $this->getnamecategory($currentCategory->parent_id);
        
        // Then append the current category name
        $name .= $currentCategory->category_name . ' >';
    }
    return $name;
}
    
    
 public function category($id=0)
    {$commanmodel = new Commanmodel();
        $session = session();
       if(session()->get('admin_type')=='Supar Admin') {
           
             $data['table_name'] = $this->getnamecategory($id);
             
             
             
              $data['id'] = $id;
                $currentCategory = $commanmodel->get_single_query('category', ['category_id' => $id]);
                
                if($currentCategory) {
                      $data['back'] = $currentCategory->parent_id;
                } else {
                      $data['back'] = '';
                }
    
            $table_header = [
                
            ['data' => 'id'],
            ['data' => 'images'],
            ['data' => 'category'],
            ['data' => 'status'],
            ['data' => 'action'],
        
        ];
        
        $data['table_column'] = json_encode($table_header);
       
       return view('admin/head').view('admin/sidebar').view('admin/category',$data).view('admin/footer');
       } else {
            
            return redirect()->back()->withInput();
       }
       
    }
    
    
        public function category_list()
{
$session = session();
$commanmodel = new Commanmodel();


// Define your DataTables parameters
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchname = $_POST['searchname']; // Change this to your search input
$id = $_POST['id']; 

// Define filters based on your requirements
$filters = [];

// Add search filter if a search term is provided
// if (!empty($searchname)) {
// $filters[] = [
//     'column' => 'product_title',
//     'value' => $searchname,
//     'type' => 'like',
// ];
// }


$filters[] = [
    'column' => 'parent_id',
    'value' => $id,
    'type' => 'where',
];



// if (session()->get('admin_type')=='Admin') { 
//     $filters[] = [
//     'column' => 'product_create_by',
//     'value' => session()->get('id'),
//     'type' => 'where',
// ];
// }

// Define ordering parameters
$order = null; // Set this based on your DataTables ordering requirements
if (!empty($_POST['order'])) {
$orderColumn = $_POST['order'][0]['column'];
$orderDirection = $_POST['order'][0]['dir'];
// Define the column name you want to order by based on $orderColumn
$order = [
    'column' => 'category_id', // Change this to your desired default order column
    'order' => 'DESC', // Change this to your desired default order direction
];
}

// Retrieve data using the getDataFromTable function
$result = $commanmodel->getDataFromTable('category', $filters, $order, $length, $start);

// Process the retrieved data
$alldata = $result['filteredRecords'];
$data = [];
$no = $start + 1;
$sn = 1;
foreach ($alldata as $alldata_view) {

$name = '<a  href="'.base_url('admin/category/'.$alldata_view->category_id).'">'.$alldata_view->category_name.'</a>';

$images = '<img class="cat-thumb" src="'.base_url().'/assets/category/'.$alldata_view->category_image.'" >'; 



$action = '<div class="btn-group">
															<button type="button"
																class="btn btn-outline-success">Info</button>
															<button type="button"
																class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
																data-bs-toggle="dropdown" aria-haspopup="true"
																aria-expanded="false" data-display="static">
																<span class="sr-only">Info</span>
															</button>
															<div class="dropdown-menu">
																<a class="dropdown-item editRecordCategory" href="javascript:void(0);" data-menu_order="'.$alldata_view->menu_order.'" data-parent_id="'.$alldata_view->parent_id.'" data-category_id="'.$alldata_view->category_id.'" data-category_name="'.$alldata_view->category_name.'" data-category_status="'.$alldata_view->category_status.'" data-category_image="'.$alldata_view->category_image.'" data-category_title="'.$alldata_view->metaTitle.'" data-category_keyword="'.$alldata_view->metaKeyword.'" data-category_description="'.$alldata_view->metaDescription.'">Edit</a>
																<a class="dropdown-item" href="#">Delete</a>
															</div>
														</div>';


        $status = '<span class="badge badge-success">'.$alldata_view->category_status.'</span>';
      
      

$data[] = [
    "id" => $alldata_view->category_id,
    "images" => $images,
    "category" => $name,
    
    "status" => $status,
    "action" => $action 
];

$no++;

$sn++;
}

// Prepare the DataTables response
$response = [
"draw" => intval($draw),
"recordsTotal" => $result['filteredRecordCount'] ,
"recordsFiltered" => $result['totalRecords'],
"data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);

            


}
    
    
    
        function category_save(){
           $session = session();
      
             $commanmodel = new Commanmodel();
         $status = $this->request->getVar('category_status');
         if($status=='Active')
         {
           $status_color = 'success';
         }  
         if($status=='Inactive')
         {
           $status_color = 'danger';
         }
         
        
         
         
               $validated = $this->validate([
            'category_image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[category_image]'
                    . '|is_image[category_image]'
                    . '|mime_in[category_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                  
            ],
        ]);
 
       
  
        if ($validated) {
             $file = $this->request->getFile('category_image');

        // Generate a new secure name
        $category_image = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/category', $category_image);
        } else {
             $category_image = '';
        }
         
         
      
         

        $title = strip_tags($this->request->getVar('category_name'));
        $titleURL = strtolower(url_title($title));
        
   

        $data = array( 
        'parent_id' => $parentId = $this->request->getVar('parent_id') ? $this->request->getVar('parent_id') : 0, 
       
        'category_name' => $this->request->getVar('category_name'), 
         'menu_order' => $this->request->getVar('category_order'),
        'category_status' => $this->request->getVar('category_status'), 
        'category_status_color' => $status_color,
        'category_image' => $category_image,
        'url_slug' => $titleURL,
        'metaTitle' => $this->request->getVar('category_title'),
        'metaKeyword' => $this->request->getVar('category_keyword'),
        'metaDescription' => $this->request->getVar('category_description')
            );
        $Inserted=$commanmodel->insert_query('category',$data);
        echo json_encode($Inserted);
     
    }
        function category_update(){
             $session = session();
       
             helper(['form', 'url']);
               $commanmodel = new Commanmodel();
         $status = $this->request->getVar('edit_category_status');
         if($status=='Active')
         {
           $status_color = 'success';
         }  
         if($status=='Inactive')
         {
           $status_color = 'danger';
         } 
         
         
              $validated = $this->validate([
            'edit_category_image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[edit_category_image]'
                    . '|is_image[edit_category_image]'
                    . '|mime_in[edit_category_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[edit_category_image,100]'
                    . '|max_dims[edit_category_image,1024,768]',
            ],
        ]);
 
       
  
        if ($validated) {
             $file = $this->request->getFile('edit_category_image');

        // Generate a new secure name
        $category_image = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/category', $category_image);
        } else {
             $category_image = $this->request->getVar('edit_category_image_old');
        }

        $title = strip_tags($this->request->getVar('edit_category_name'));
        $titleURL = strtolower(url_title($title));
        if($commanmodel->get_url_slug_update('category',$titleURL,array('category_id'=> $this->request->getVar('edit_category_id')))){
        $titleURL = $titleURL.'-'.time(); 
        }
        $data = array(  
              'parent_id' => $parentId = $this->request->getVar('parent_id') ? $this->request->getVar('parent_id') : 0, 
        'category_name' => $this->request->getVar('edit_category_name'), 
        'menu_order' => $this->request->getVar('edit_category_order'), 
        'category_status' => $this->request->getVar('edit_category_status'), 
        'category_status_color' => $status_color,
        'category_image' => $category_image,
        'url_slug' => $titleURL,
        'metaTitle' => $this->request->getVar('edit_category_title'),
        'metaKeyword' => $this->request->getVar('edit_category_keyword'),
        'metaDescription' => $this->request->getVar('edit_category_description') 
        );
        $where = array(             
        'category_id' => $this->request->getVar('edit_category_id')
            );
        $updated=$commanmodel->update_query('category',$data,$where);
        echo json_encode($updated);
     
    }
    
 
  
   public function bulk_product_upload()
    {
        $commanmodel = new Commanmodel();
        $session = session();
         $data['table_name'] = '';
         
         return view('admin/head').view('admin/sidebar').view('admin/bulk_product_upload',$data).view('admin/footer');
    }
    
    
    
   public function uploadCSV()
{
    $commanmodel = new Commanmodel();
    $session = session();

    helper(['form', 'url']);

    // Define the file validation rules
    $validation = \Config\Services::validation();
    $validation->setRules([
        'file' => 'uploaded[file]|max_size[file,10240]|ext_in[file,csv]',
    ]);

    // Check if file passes validation
    if (!$this->validate($validation->getRules())) {
        return redirect()->to('/bulk-upload')->with('errors', $validation->getErrors());
    }

    // Get the uploaded file
    $file = $this->request->getFile('file');

    // Process the CSV file
    if ($file->isValid() && !$file->hasMoved()) {
   
$csvData = array_slice(array_map('str_getcsv', file($file->getTempName())), 1);

 $insertid = 0;
        // Loop through the CSV data and insert into the database
        foreach ($csvData as $row) {
           
            
            $price = '';
             $qty = '';
              $img = '';

            if (!empty($row[1])) { // Assuming row[1] is product name, adjust accordingly
                // Prepare product data
                $postData = [
                    'product_name' => $row[1],  
                    'product_category' => $row[5],
                    'product_brand' => $row[7],
                    'product_collections' => $row[12],
                    'slug' => $row[0],
                    'product_thumbnail' => $row[13],
                    'product_max_price' => $row[8],
                    'product_price' => $row[21],
                    'inclusive_gst' => $row[9],
                    'gst' => $row[11],
                    'sku' => $row[10],
                    'product_overview' => $row[2],
                    'product_description' => $row[3],
                    'additional_information' => $row[4],
                    'product_meta_title' => $row[24],
                    'product_meta_keyword' => $row[25],
                    'product_meta_description' => $row[26],
                    'product_status' => $row[14], 
                    'product_status_color' => ($row[14] == 'Active') ? 'success' : 'danger',
                    'product_create_by' => $row[6],
                    'product_date' => date('Y-m-d')
                ];

                // Insert product data into the 'product' table
                $insertid = $commanmodel->insert_query_get_inserid('product', $postData);

                // Insert group data into the 'pro_group' table
               if(!empty($row[15])) { $group_data1 = ['pro_group_pro_id' => $insertid, 'pro_group_name' => $row[15]];
                $groupinserted1 = $commanmodel->insert_query_get_inserid('pro_group', $group_data1); }

                if(!empty($row[17])) { $group_data2 = ['pro_group_pro_id' => $insertid, 'pro_group_name' => $row[17]];
                $groupinserted2 = $commanmodel->insert_query_get_inserid('pro_group', $group_data2); }

               if(!empty($row[19])) {  $group_data3 = ['pro_group_pro_id' => $insertid, 'pro_group_name' => $row[19]];
                $groupinserted3 = $commanmodel->insert_query_get_inserid('pro_group', $group_data3); }

              
            }
            
            
              // Insert item data into the 'pro_item' table for each group
               if(!empty($row[16])) {  $item_data1 = ['pro_item_group_id' => $groupinserted1, 'pro_item_name' => $row[16]];
                $commanmodel->insert_query_get_inserid('pro_item', $item_data1);  }

              if(!empty($row[18])) {  $item_data2 = ['pro_item_group_id' => $groupinserted2, 'pro_item_name' => $row[18]];
                $commanmodel->insert_query_get_inserid('pro_item', $item_data2); }

               if(!empty($row[20])) {  $item_data3 = ['pro_item_group_id' => $groupinserted3, 'pro_item_name' => $row[20]];
                $commanmodel->insert_query_get_inserid('pro_item', $item_data3);  }

              // Check if row[16], row[18], or row[20] are empty, and create the variant string accordingly
            $varian = trim($row[16] . (empty($row[18]) ? '' : '-' . $row[18]) . (empty($row[20]) ? '' : '-' . $row[20]));

            $price = $row[21];
             $qty = $row[22];
              $img = $row[23];
                // Insert variant data into the 'pro_variant' table
                $variant_data = [
                    'variant_pro_id' => $insertid,
                    'varian' => $varian, 
                    'pro_variant_price' => $price, 
                    'pro_variant_available' => $qty, 
                    'pro_variant_image' => $img,
                ];
                $commanmodel->insert_query_get_inserid('pro_variant', $variant_data);  
        }

        return redirect()->to('/admin/bulk_product_upload')->with('success', 'CSV file successfully uploaded!');
    } else {
        return redirect()->to('/admin/bulk_product_upload')->with('error', 'There was an issue with the file upload.');
    }
}

    
  
 public function files()
    {$commanmodel = new Commanmodel();
        $session = session();
       if(session()->get('admin_type')=='Supar Admin') {
           
             $data['table_name'] = '';
             
             
    
    
           $table_header = [
    [
        "data" => "checkbox", // This will be the checkbox column for selecting rows
        "orderable" => false,  // Disable sorting for the checkbox column
        "searchable" => false, // Disable searching for the checkbox column
       
    ],
    ['data' => 'id'],
    ['data' => 'images'],
    ['data' => 'files_images'],
    ['data' => 'date_added'],
    ['data' => 'size'],
    ['data' => 'references']
];


        $data['table_column'] = json_encode($table_header);
       
       return view('admin/head').view('admin/sidebar').view('admin/files',$data).view('admin/footer');
       } else {
            
            return redirect()->back()->withInput();
       }
       
    }
public function files_list()
{
    // Request parameter (asc or desc)
    $order = $_POST['order']; 
    $draw = $_POST['draw'];
    $start = $_POST['start']; // Start index
    $length = $_POST['length']; // Number of records per page
    
    $folderPath = 'assets/images'; // Folder path
    $files = scandir($folderPath); // Get all files in the folder

    // Filter out '.' and '..'
    $fileList = array_diff($files, array('.', '..'));

    // Sort files by last modified date using filemtime
    usort($fileList, function($file1, $file2) use ($folderPath, $order) {
        $file1Date = filemtime($folderPath . DIRECTORY_SEPARATOR . $file1);
        $file2Date = filemtime($folderPath . DIRECTORY_SEPARATOR . $file2);

        // Sort based on order (ascending or descending)
        if ($order === 'asc') {
            return $file1Date - $file2Date; // Ascending order
        } else {
            return $file2Date - $file1Date; // Descending order
        }
    });

    // Paginate the files (slice array based on start and length)
    $paginatedFiles = array_slice($fileList, $start, $length);

    // Initialize the data array for response
    $data = [];
    $sn = $start + 1; // Serial number starting from 'start'

    // Loop through the paginated files and add their details
    foreach ($paginatedFiles as $file) {
        $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;
        
        // Generate image HTML for displaying image preview
        $images = '<img class="cat-thumb" src="' . base_url($filePath) . '" >'; 
        
        $copy = '<button class="btn btn-border btn-sm copy-btn" data-link="'.$file.'"><i class="mdi mdi-content-copy"></i> </button>';
        
        // Add file details to data array
       $data[] = [
    'checkbox' => '<input type="checkbox" class="selectRow" value="' . htmlspecialchars($filePath) . '">', // Ensure file path is safe
    'id' => $sn, // Serial number or file ID (You can replace with actual ID if needed)
    'images' => '<img src="' . base_url($filePath) . '" class="cat-thumb">'.' '.$copy, // Image HTML with base_url() for correct URL
    'files_images' => pathinfo($file, PATHINFO_FILENAME), // Full file path (if you need it in the response)
    'date_added' => date('Y-m-d H:i:s', filemtime($filePath)), // File modification date
    'size' => filesize($filePath), // File size
    'references' => '' // Placeholder for references, you can populate this if needed
];
        $sn++; // Increment serial number
    }

    // Prepare response
    $response = [
        'draw' => intval($draw),
        'recordsTotal' => count($fileList), // Total number of records (before pagination)
        'recordsFiltered' => count($fileList), // Total number of filtered records (same as total in this case)
        'data' => $data // File data
    ];

    // Return response in JSON format
    echo json_encode($response);
}

public function upload_image() {
    $validated = $this->validate([
        'file' => [
            'label' => 'Image File',
            'rules' => 'uploaded[file]'
                . '|is_image[file]'
                . '|mime_in[file,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
        ],
    ]);

    if ($validated) {
        $file = $this->request->getFile('file');

        // Get the original name of the file
        $reviews_image = $file->getName();

        // Replace spaces with underscores
        $brand_image = str_replace(' ', '_', $brand_image);

        // Define the target directory
        $targetDirectory = 'assets/images/';

        // Check if a file with the same name exists
        if (file_exists($targetDirectory . $brand_image)) {
            // Generate a unique name by appending a timestamp
            $fileInfo = pathinfo($brand_image);
            $brand_image = $fileInfo['filename'] . '_' . time() . '.' . $fileInfo['extension'];
        }

        // Move the file to the directory with the unique or updated name
        $file->move($targetDirectory, $brand_image);
        echo $brand_image; // Output the uploaded file name
    } else {
        $brand_image = '';
    }
}



   

public function delete_files() {
    // Get the selected file paths from the POST request
    $filePaths = $this->request->getVar('ids');
    
    if (empty($filePaths)) {
        // If no files are selected, return an error message
        return $this->response->setJSON(['status' => 'error', 'message' => 'No files selected']);
    }

    // Folder path where the files are stored
     $folderPath = FCPATH . 'assets/images/'; // Use WRITEPATH to ensure safe folder location

    $deletedFiles = 0;

    // Loop through each file path and attempt to delete the file
    foreach ($filePaths as $filePath) {
        // Sanitize and ensure the file name is safe (avoid directory traversal)
        $fileName = basename($filePath);

        // Ensure the file exists before trying to delete it
        $fullPath = $folderPath . $fileName;

        if (file_exists($fullPath)) {
             if (unlink($fullPath)) {
                $deletedFiles++; // Increment if the file is successfully deleted
            }
           
        }
    }

    // Send back a response
    if ($deletedFiles > 0) {
        echo json_encode(['status' => 'success', 'message' => "$deletedFiles files deleted successfully"]);
    } else {
        echo json_encode(['status' => 'error', 'message' => $fullPath]);
    }
}



    
     public function brand()
    {$commanmodel = new Commanmodel();
        $session = session();
       if(session()->get('admin_type')=='Supar Admin') {
           
             $data['table_name'] = '';
             
             
         
    
            $table_header = [
                
            ['data' => 'id'],
            ['data' => 'images'],
            ['data' => 'brand'],
           
            ['data' => 'action'],
        
        ];
        
        $data['table_column'] = json_encode($table_header);
       
       return view('admin/head').view('admin/sidebar').view('admin/brand',$data).view('admin/footer');
       } else {
            
            return redirect()->back()->withInput();
       }
       
    } 
        public function brand_list()
{
$session = session();
$commanmodel = new Commanmodel();


// Define your DataTables parameters
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchname = $_POST['searchname']; // Change this to your search input


// Define filters based on your requirements
$filters = [];

// Add search filter if a search term is provided
// if (!empty($searchname)) {
// $filters[] = [
//     'column' => 'product_title',
//     'value' => $searchname,
//     'type' => 'like',
// ];
// }






// if (session()->get('admin_type')=='Admin') { 
//     $filters[] = [
//     'column' => 'product_create_by',
//     'value' => session()->get('id'),
//     'type' => 'where',
// ];
// }

// Define ordering parameters
$order = null; // Set this based on your DataTables ordering requirements
if (!empty($_POST['order'])) {
$orderColumn = $_POST['order'][0]['column'];
$orderDirection = $_POST['order'][0]['dir'];
// Define the column name you want to order by based on $orderColumn
$order = [
    'column' => 'brand_id', // Change this to your desired default order column
    'order' => 'DESC', // Change this to your desired default order direction
];
}

// Retrieve data using the getDataFromTable function
$result = $commanmodel->getDataFromTable('brand', $filters, $order, $length, $start);

// Process the retrieved data
$alldata = $result['filteredRecords'];
$data = [];
$no = $start + 1;
$sn = 1;
foreach ($alldata as $alldata_view) {

$name = '<a  href="'.base_url('admin/brand/'.$alldata_view->brand_id).'">'.$alldata_view->brand_name.'</a>';

$images = '<img class="cat-thumb" src="'.base_url().'/assets/brand/'.$alldata_view->brand_image.'" >'; 



$action = '<div class="btn-group">
															<button type="button"
																class="btn btn-outline-'.$alldata_view->brand_status_color.'">'.$alldata_view->brand_status.'</button>
															<button type="button"
																class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
																data-bs-toggle="dropdown" aria-haspopup="true"
																aria-expanded="false" data-display="static">
																<span class="sr-only">Info</span>
															</button>
															<div class="dropdown-menu">
																<a class="dropdown-item editRecordbrand" href="javascript:void(0);"  data-brand_id="'.$alldata_view->brand_id.'" data-brand_name="'.$alldata_view->brand_name.'" data-brand_status="'.$alldata_view->brand_status.'" >Edit</a>
																<a class="dropdown-item" href="#">Delete</a>
															</div>
														</div>';


      

$data[] = [
    "id" => $sn,
    "images" => $images,
    "brand" => $name,
    
   
    "action" => $action 
];

$no++;

$sn++;
}

// Prepare the DataTables response
$response = [
"draw" => intval($draw),
"recordsTotal" => $result['filteredRecordCount'] ,
"recordsFiltered" => $result['totalRecords'],
"data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);

            


}
    
    
    
        function brand_save(){
           $session = session();
      
             $commanmodel = new Commanmodel();
         $status = $this->request->getVar('brand_status');
         if($status=='Active')
         {
           $status_color = 'success';
         }  
         if($status=='Inactive')
         {
           $status_color = 'danger';
         }
         
        
         
         
               $validated = $this->validate([
            'brand_image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[brand_image]'
                    . '|is_image[brand_image]'
                    . '|mime_in[brand_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    
            ],
        ]);
 
       
  
        if ($validated) {
             $file = $this->request->getFile('brand_image');

        // Generate a new secure name
        $brand_image = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/brand', $brand_image);
        } else {
             $brand_image = '';
        }
         
         
      
         

        $title = strip_tags($this->request->getVar('brand_name'));
        $titleURL = strtolower(url_title($title));
        
   

        $data = array( 
        
        'brand_name' => $this->request->getVar('brand_name'), 
         
        'brand_status' => $this->request->getVar('brand_status'), 
        'brand_status_color' => $status_color,
        'brand_image' => $brand_image,
        'url_slug' => $titleURL,
       
            );
        $Inserted=$commanmodel->insert_query('brand',$data);
        echo json_encode($Inserted);
     
    }
        function brand_update(){
             $session = session();
       
             helper(['form', 'url']);
               $commanmodel = new Commanmodel();
         $status = $this->request->getVar('edit_brand_status');
         if($status=='Active')
         {
           $status_color = 'success';
         }  
         if($status=='Inactive')
         {
           $status_color = 'danger';
         } 
         
         
              $validated = $this->validate([
            'edit_brand_image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[edit_brand_image]'
                    . '|is_image[edit_brand_image]'
                    . '|mime_in[edit_brand_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                   
            ],
        ]);
 
       
  
        if ($validated) {
             $file = $this->request->getFile('edit_brand_image');

        // Generate a new secure name
        $brand_image = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/brand', $brand_image);
        } else {
             $brand_image = $this->request->getVar('edit_brand_image_old');
        }

        $title = strip_tags($this->request->getVar('edit_brand_name'));
        $titleURL = strtolower(url_title($title));
        if($commanmodel->get_url_slug_update('brand',$titleURL,array('brand_id'=> $this->request->getVar('edit_brand_id')))){
        $titleURL = $titleURL.'-'.time(); 
        }
        $data = array(  
             
        'brand_name' => $this->request->getVar('edit_brand_name'), 
      
        'brand_status' => $this->request->getVar('edit_brand_status'), 
        'brand_status_color' => $status_color,
        'brand_image' => $brand_image,
        'url_slug' => $titleURL,
       
        );
        $where = array(             
        'brand_id' => $this->request->getVar('edit_brand_id')
            );
        $updated=$commanmodel->update_query('brand',$data,$where);
        echo json_encode($updated);
     
    }
    
    
    
    
      public function collections()
    {$commanmodel = new Commanmodel();
        $session = session();
       if(session()->get('admin_type')=='Supar Admin') {
           
             $data['table_name'] = '';
             
             
         
    
            $table_header = [
                
            ['data' => 'id'],
        
            ['data' => 'collections'],
           
            ['data' => 'action'],
        
        ];
        
        $data['table_column'] = json_encode($table_header);
       
       return view('admin/head').view('admin/sidebar').view('admin/collections',$data).view('admin/footer');
       } else {
            
            return redirect()->back()->withInput();
       }
       
    } 
        public function collections_list()
{
$session = session();
$commanmodel = new Commanmodel();


// Define your DataTables parameters
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchname = $_POST['searchname']; // Change this to your search input


// Define filters based on your requirements
$filters = [];

// Add search filter if a search term is provided
// if (!empty($searchname)) {
// $filters[] = [
//     'column' => 'product_title',
//     'value' => $searchname,
//     'type' => 'like',
// ];
// }






// if (session()->get('admin_type')=='Admin') { 
//     $filters[] = [
//     'column' => 'product_create_by',
//     'value' => session()->get('id'),
//     'type' => 'where',
// ];
// }

// Define ordering parameters
$order = null; // Set this based on your DataTables ordering requirements
if (!empty($_POST['order'])) {
$orderColumn = $_POST['order'][0]['column'];
$orderDirection = $_POST['order'][0]['dir'];
// Define the column name you want to order by based on $orderColumn
$order = [
    'column' => 'collections_id', // Change this to your desired default order column
    'order' => 'DESC', // Change this to your desired default order direction
];
}

// Retrieve data using the getDataFromTable function
$result = $commanmodel->getDataFromTable('collections', $filters, $order, $length, $start);

// Process the retrieved data
$alldata = $result['filteredRecords'];
$data = [];
$no = $start + 1;
$sn = 1;
foreach ($alldata as $alldata_view) {

$name = '<a  href="'.base_url('admin/collections/'.$alldata_view->collections_id).'">'.$alldata_view->collections_name.'</a>';

//$images = '<img class="cat-thumb" src="'.base_url().'/assets/collections/'.$alldata_view->collections_image.'" >'; 



$action = '<div class="btn-group">
															<button type="button"
																class="btn btn-outline-'.$alldata_view->collections_status_color.'">'.$alldata_view->collections_status.'</button>
															<button type="button"
																class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
																data-bs-toggle="dropdown" aria-haspopup="true"
																aria-expanded="false" data-display="static">
																<span class="sr-only">Info</span>
															</button>
															<div class="dropdown-menu">
																<a class="dropdown-item editRecordcollections" href="javascript:void(0);"  data-collections_id="'.$alldata_view->collections_id.'" data-collections_name="'.$alldata_view->collections_name.'" data-collections_status="'.$alldata_view->collections_status.'" >Edit</a>
																<a class="dropdown-item" href="#">Delete</a>
															</div>
														</div>';


      

$data[] = [
    "id" => $sn,
   
    "collections" => $name,
    
   
    "action" => $action 
];

$no++;

$sn++;
}

// Prepare the DataTables response
$response = [
"draw" => intval($draw),
"recordsTotal" => $result['filteredRecordCount'] ,
"recordsFiltered" => $result['totalRecords'],
"data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);

            


}
    
    
    
        function collections_save(){
           $session = session();
      
             $commanmodel = new Commanmodel();
         $status = $this->request->getVar('collections_status');
         if($status=='Active')
         {
           $status_color = 'success';
         }  
         if($status=='Inactive')
         {
           $status_color = 'danger';
         }
         
        
        
      
         

        $title = strip_tags($this->request->getVar('collections_name'));
        $titleURL = strtolower(url_title($title));
        
   

        $data = array( 
        
        'collections_name' => $this->request->getVar('collections_name'), 
         
        'collections_status' => $this->request->getVar('collections_status'), 
        'collections_status_color' => $status_color,
      
        'url_slug' => $titleURL,
       
            );
        $Inserted=$commanmodel->insert_query('collections',$data);
        echo json_encode($Inserted);
     
    }
        function collections_update(){
             $session = session();
       
             helper(['form', 'url']);
               $commanmodel = new Commanmodel();
         $status = $this->request->getVar('edit_collections_status');
         if($status=='Active')
         {
           $status_color = 'success';
         }  
         if($status=='Inactive')
         {
           $status_color = 'danger';
         } 
         
         
             

        $title = strip_tags($this->request->getVar('edit_collections_name'));
        $titleURL = strtolower(url_title($title));
        if($commanmodel->get_url_slug_update('collections',$titleURL,array('collections_id'=> $this->request->getVar('edit_collections_id')))){
        $titleURL = $titleURL.'-'.time(); 
        }
        $data = array(  
             
        'collections_name' => $this->request->getVar('edit_collections_name'), 
      
        'collections_status' => $this->request->getVar('edit_collections_status'), 
        'collections_status_color' => $status_color,
        
        'url_slug' => $titleURL,
       
        );
        $where = array(             
        'collections_id' => $this->request->getVar('edit_collections_id')
            );
        $updated=$commanmodel->update_query('collections',$data,$where);
        echo json_encode($updated);
     
    }
    
    
    public function meta()
    {$commanmodel = new Commanmodel();
        $session = session();
       if(session()->get('admin_type')=='Supar Admin') {
           
             $data['table_name'] = '';
             
             
         
    
            $table_header = [
                
            ['data' => 'id'],
             ['data' => 'page'],
            ['data' => 'images'],
            ['data' => 'meta'],
           
            ['data' => 'action'],
        
        ];
        
        $data['table_column'] = json_encode($table_header);
       
       return view('admin/head').view('admin/sidebar').view('admin/meta',$data).view('admin/footer');
       } else {
            
            return redirect()->back()->withInput();
       }
       
    }
    
    
        public function meta_list()
{
$session = session();
$commanmodel = new Commanmodel();


// Define your DataTables parameters
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchname = $_POST['searchname']; // Change this to your search input


// Define filters based on your requirements
$filters = [];

// Add search filter if a search term is provided
// if (!empty($searchname)) {
// $filters[] = [
//     'column' => 'product_title',
//     'value' => $searchname,
//     'type' => 'like',
// ];
// }






// if (session()->get('admin_type')=='Admin') { 
//     $filters[] = [
//     'column' => 'product_create_by',
//     'value' => session()->get('id'),
//     'type' => 'where',
// ];
// }

// Define ordering parameters
$order = null; // Set this based on your DataTables ordering requirements
if (!empty($_POST['order'])) {
$orderColumn = $_POST['order'][0]['column'];
$orderDirection = $_POST['order'][0]['dir'];
// Define the column name you want to order by based on $orderColumn
$order = [
    'column' => 'meta_id', // Change this to your desired default order column
    'order' => 'DESC', // Change this to your desired default order direction
];
}

// Retrieve data using the getDataFromTable function
$result = $commanmodel->getDataFromTable('meta', $filters, $order, $length, $start);

// Process the retrieved data
$alldata = $result['filteredRecords'];
$data = [];
$no = $start + 1;
$sn = 1;
foreach ($alldata as $alldata_view) {

$name = $alldata_view->meta_title;

$images = '<img class="cat-thumb" src="'.base_url().'/assets/meta/'.$alldata_view->meta_image.'" >'; 



$action = '<div class="btn-group">
			<button type="button"
				class="btn btn-outline-success"></button>
			<button type="button"
				class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
				data-bs-toggle="dropdown" aria-haspopup="true"
				aria-expanded="false" data-display="static">
				<span class="sr-only">Info</span>
			</button>
			<div class="dropdown-menu">
				<a class="dropdown-item editRecordmeta" href="javascript:void(0);"  data-meta_id="'.$alldata_view->meta_id.'" data-meta_title="'.$alldata_view->meta_title.'"   data-meta_keyword="'.$alldata_view->meta_keyword.'" data-meta_description="'.$alldata_view->meta_description.'" data-meta_image="'.$alldata_view->meta_image.'" >Edit</a>
				
			</div>
		</div>';


      

$data[] = [
    "id" => $sn,
     "page" => $alldata_view->meta_page,
    "images" => $images,
    "meta" => $name,
    
   
    "action" => $action 
];

$no++;

$sn++;
}

// Prepare the DataTables response
$response = [
"draw" => intval($draw),
"recordsTotal" => $result['filteredRecordCount'] ,
"recordsFiltered" => $result['totalRecords'],
"data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);

            


}
    
    
    
        function meta_save(){
           $session = session();
      
             $commanmodel = new Commanmodel();
         $status = $this->request->getVar('meta_status');
         if($status=='Active')
         {
           $status_color = 'success';
         }  
         if($status=='Inactive')
         {
           $status_color = 'danger';
         }
         
        
         
         
               $validated = $this->validate([
            'meta_image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[meta_image]'
                    . '|is_image[meta_image]'
                    . '|mime_in[meta_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    
            ],
        ]);
 
       
  
        if ($validated) {
             $file = $this->request->getFile('meta_image');

        // Generate a new secure name
        $meta_image = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/meta', $meta_image);
        } else {
             $meta_image = '';
        }
         
         
      
         

        $title = strip_tags($this->request->getVar('meta_name'));
        $titleURL = strtolower(url_title($title));
        
   

        $data = array( 
        
        'meta_name' => $this->request->getVar('meta_name'), 
         
        'meta_status' => $this->request->getVar('meta_status'), 
        'meta_status_color' => $status_color,
        'meta_image' => $meta_image,
        'url_slug' => $titleURL,
       
            );
        $Inserted=$commanmodel->insert_query('meta',$data);
        echo json_encode($Inserted);
     
    }
        function meta_update(){
             $session = session();
       
             helper(['form', 'url']);
               $commanmodel = new Commanmodel();
        
         
         
              $validated = $this->validate([
            'edit_meta_image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[edit_meta_image]'
                    . '|is_image[edit_meta_image]'
                    . '|mime_in[edit_meta_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                   
            ],
        ]);
 
       
  
        if ($validated) {
             $file = $this->request->getFile('edit_meta_image');

        // Generate a new secure name
        $meta_image = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/meta', $meta_image);
        } else {
             $meta_image = $this->request->getVar('edit_meta_image_old');
        }

        
        $data = array(  
             
       
        'meta_title' => $this->request->getVar('meta_title'), 
        'meta_keyword' => $this->request->getVar('meta_keyword'), 
        'meta_description' => $this->request->getVar('meta_description'), 
        

        'meta_image' => $meta_image,
    
       
        );
        $where = array(             
        'meta_id' => $this->request->getVar('edit_meta_id')
            );
        $updated=$commanmodel->update_query('meta',$data,$where);
        echo json_encode($updated);
     
    }
    
    
     public function coupon()
    {$commanmodel = new Commanmodel();
        $session = session();
       if(session()->get('admin_type')=='Supar Admin') {
           
             $data['table_name'] = '';
             
             
         
    
            $table_header = [
                
            ['data' => 'coupon'],
            ['data' => 'discount'],
            ['data' => 'startdate'],
            ['data' => 'enddate'],
         
            ['data' => 'action'],
        
        ];
        
        $data['table_column'] = json_encode($table_header);
       
       return view('admin/head').view('admin/sidebar').view('admin/coupon',$data).view('admin/footer');
       } else {
            
            return redirect()->back()->withInput();
       }
       
    }
    
    
        public function coupon_list()
{
$session = session();
$commanmodel = new Commanmodel();


// Define your DataTables parameters
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchname = $_POST['searchname']; // Change this to your search input


// Define filters based on your requirements
$filters = [];

// Add search filter if a search term is provided
// if (!empty($searchname)) {
// $filters[] = [
//     'column' => 'product_title',
//     'value' => $searchname,
//     'type' => 'like',
// ];
// }






// if (session()->get('admin_type')=='Admin') { 
//     $filters[] = [
//     'column' => 'product_create_by',
//     'value' => session()->get('id'),
//     'type' => 'where',
// ];
// }

// Define ordering parameters
$order = null; // Set this based on your DataTables ordering requirements
if (!empty($_POST['order'])) {
$orderColumn = $_POST['order'][0]['column'];
$orderDirection = $_POST['order'][0]['dir'];
// Define the column name you want to order by based on $orderColumn
$order = [
    'column' => 'coupon_id', // Change this to your desired default order column
    'order' => 'DESC', // Change this to your desired default order direction
];
}

// Retrieve data using the getDataFromTable function
$result = $commanmodel->getDataFromTable('coupon', $filters, $order, $length, $start);

// Process the retrieved data
$alldata = $result['filteredRecords'];
$data = [];
$no = $start + 1;
$sn = 1;
foreach ($alldata as $alldata_view) {

$name = $alldata_view->coupon_title;

$images = '<img class="cat-thumb" src="'.base_url().'/assets/coupon/'.$alldata_view->coupon_primary_image.'" >'; 



$action = '<div class="btn-group">
															<button type="button"
																class="btn btn-outline-'.$alldata_view->coupon_status_color.'">'.$alldata_view->coupon_status.'</button>
															<button type="button"
																class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
																data-bs-toggle="dropdown" aria-haspopup="true"
																aria-expanded="false" data-display="static">
																<span class="sr-only">Info</span>
															</button>
															<div class="dropdown-menu">
																<a class="dropdown-item editRecordcoupon" href="javascript:void(0);"  data-coupon_id="'.$alldata_view->coupon_id.'" data-coupon_code="'.$alldata_view->coupon_code.'" data-coupon_status="'.$alldata_view->coupon_status.'" data-coupon_primary_image="'.$alldata_view->coupon_primary_image.'" >Edit</a>
																<a class="dropdown-item" href="#">Delete</a>
															</div>
														</div>';



$data[] = [
    "coupon" => $name = $alldata_view->coupon_title,
    "discount" =>  $alldata_view->coupon_value,
    "startdate" => $alldata_view->coupon_start_date	,
    "enddate" => $alldata_view->coupon_end_date,
   
   
    "action" => $action 
];

$no++;

$sn++;
}

// Prepare the DataTables response
$response = [
"draw" => intval($draw),
"recordsTotal" => $result['filteredRecordCount'] ,
"recordsFiltered" => $result['totalRecords'],
"data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);

            


}
    
    
    
        function coupon_save() {
    $session = session();
    $commanmodel = new Commanmodel();

    // Get the coupon status and assign the color accordingly
    $status = $this->request->getVar('coupon_status');
    if ($status == 'Active') {
        $status_color = 'success';
    }  
    if ($status == 'Inactive') {
        $status_color = 'danger';
    }

    // Validate the uploaded image file
    $validated = $this->validate([
        'coupon_primary_image' => [
            'label' => 'Image File',
            'rules' => 'uploaded[coupon_primary_image]'
                . '|is_image[coupon_primary_image]'
                . '|mime_in[coupon_primary_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
        ],
    ]);

    // If the file is validated, upload it
    if ($validated) {
        $file = $this->request->getFile('coupon_primary_image');

        // Generate a random name for the uploaded file
        $primary_image = $file->getRandomName();

        // Move the file to the desired directory
        $file->move('assets/coupon', $primary_image);
    } else {
        // If no file is uploaded, set the image to an empty string
        $primary_image = '';
    }

    // Prepare the data for inserting into the database
    $data = [
        'coupon_title' => $this->request->getVar('coupon_title'),
        'coupon_code' => $this->request->getVar('coupon_code'),
        'coupon_start_date' => $this->request->getVar('coupon_start_date'),
        'coupon_end_date' => $this->request->getVar('coupon_end_date'),
        'coupon_type' => $this->request->getVar('coupon_type'),
        'coupon_value' => $this->request->getVar('coupon_value'),
        'coupon_primary_image' => $primary_image,
        'coupon_status' => $status,
        'coupon_status_color' => $status_color,
        'coupon_quick_overview' => $this->request->getVar('coupon_quick_overview'),
        'saved_date' => date('Y-m-d')
    ];

 

    // Insert the coupon into the database and return the result
    $inserted = $commanmodel->insert_query('coupon', $data);

    // Return the insertion result as a JSON response
    echo json_encode($inserted);
}

        function coupon_update(){
    $session = session();
    helper(['form', 'url']);
    $commanmodel = new Commanmodel();

    // Get coupon status and set the status color
    $status = $this->request->getVar('edit_couponStatus');
    if($status == 'Active') {
        $status_color = 'success';
    }  
    if($status == 'Inactive') {
        $status_color = 'danger';
    }

    // Validate the uploaded image file
    $validated = $this->validate([
        'edit_coupon_primary_image' => [
            'label' => 'Image File',
            'rules' => 'uploaded[edit_coupon_primary_image]'
                . '|is_image[edit_coupon_primary_image]'
                . '|mime_in[edit_coupon_primary_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
        ],
    ]);

    // If a new image is validated, upload it
    if ($validated) {
        $file = $this->request->getFile('edit_coupon_primary_image');

        // Generate a random name for the image
        $primary_image = $file->getRandomName();

        // Move the file to the desired directory
        $file->move('assets/coupon', $primary_image);
    } else {
        // If no new image is provided, use the existing one
        $primary_image = $this->request->getVar('edit_couponimages');
    }

 
    // Prepare the data for updating the coupon
    $data = [
        'coupon_code' => $this->request->getVar('edit_couponCode'),
        'coupon_primary_image' => $primary_image,
        'coupon_status' => $status,
        'coupon_status_color' => $status_color,
    ];

    // Define the where condition for updating the coupon
    $where = [
        'coupon_id' => $this->request->getVar('edit_couponID')
    ];

    // Perform the update query
    $updated = $commanmodel->update_query('coupon', $data, $where);

    // Return the result of the update as a JSON response
    echo json_encode($updated);
}


    public function user()
    {
        $session = session();
       if(session()->get('admin_type')=='Supar Admin' or session()->get('user')=='Yes') {
           
           
            $data['table_name'] = 'product';
    
            $table_header = [
                
            ['data' => 'id'],
            ['data' => 'name'],
            ['data' => 'email'],
           
            ['data' => 'action'],
        
        ];
        
        $data['table_column'] = json_encode($table_header);
     
        return view('admin/head').view('admin/sidebar').view('admin/user',$data).view('admin/footer');
       } else {
            $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page?');
            return redirect()->back()->withInput();
       }
    }
   
    public function em_userlist()
    {

       $session = session();
$commanmodel = new Commanmodel();


// Define your DataTables parameters
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchname = $_POST['searchname']; // Change this to your search input
$id = $_POST['id']; 
$status = $_POST['status']; 
// Define filters based on your requirements
$filters = [];



// Define ordering parameters
$order = null; // Set this based on your DataTables ordering requirements



if (!empty($searchname)) {
$filters[] = [
    'column' => 'name',
    'value' => $searchname,
    'type' => 'like',
];
}

if (!empty($status)) {
$filters[] = [
    'column' => 'status',
    'value' => $status,
    'type' => 'like',
];
}

if (!empty($_POST['order'])) {
$orderColumn = $_POST['order'][0]['column'];
$orderDirection = $_POST['order'][0]['dir'];
// Define the column name you want to order by based on $orderColumn
$order = [
    'column' => 'id', // Change this to your desired default order column
    'order' => 'DESC', // Change this to your desired default order direction
];
}

// Retrieve data using the getDataFromTable function
$result = $commanmodel->getDataFromTable('admin', $filters, $order, $length, $start);

// Process the retrieved data
$alldata = $result['filteredRecords'];
$data = [];
$no = $start + 1;
$sn = 1;
foreach ($alldata as $alluser_view) {
        


            $name = 'Name : '.$alluser_view->name.'<br>Phone : '.$alluser_view->phone.'<br>Date : '.$alluser_view->date_time;
            $email = $alluser_view->email;
         
        
           
             $no++;
            
   $status_text = ($alluser_view->status == 'Active') ? 'Approved' : 'Disapproved';

$action = '<div class="btn-group">
    <button type="button" class="btn btn-outline-'.$alluser_view->status_color.'">'.$status_text.'</button>
    <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
        <span class="sr-only">Info</span>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="'.base_url('admin/product/'.$alluser_view->id).'">Product</a>
        <a class="dropdown-item" href="'.base_url('admin/edit-user/'.$alluser_view->id).'">Edit</a>
        <a class="dropdown-item" href="'.base_url('admin/order?vender_id='.$alluser_view->id).'">Order</a>
        <a class="dropdown-item" href="'.base_url('admin/transactions/'.$alluser_view->id).'">Transactions</a>
        <a class="dropdown-item" href="'.base_url('admin/user-delete/'.$alluser_view->id).'" onclick="return confirm(\'Are you sure you want to delete?\')">Delete</a>
    </div>
</div>';

             
       $data[] = [
    "id" => $sn,
    "name" => $name,
    "email" => $email,
    
  
    "action" => $action
];

$no++;

$sn++;
}

// Prepare the DataTables response
$response = [
"draw" => intval($draw),
"recordsTotal" => $result['filteredRecordCount'] ,
"recordsFiltered" => $result['totalRecords'],
"data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);
    }
       public function user_delete($id)
    {
         $session = session();
       if(session()->get('admin_type')=='Supar Admin' or session()->get('admin_type')=='Admin') {
          $commanmodel = new Commanmodel();

        $Approvedcount = $commanmodel->get_query_count('product',array('product_create_by' =>$id));
       
         
    if($Approvedcount) {
        
         $session->setFlashdata('failed', 'Cannot delete. User is associated with category ?');
    } else {
        
        $commanmodel->delete_query('admin',array('id' =>$id));
         $session->setFlashdata('created', 'This User has been Delete successfully!');
    }

       
        return redirect()->to('/admin/user');
    } else {
            $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page?');
            return redirect()->to('/admin/dashboard');
       }
    }



    public function create_user()
    {
       $session = session();
       if(session()->get('admin_type')=='Supar Admin' or session()->get('user')=='Yes') {
        helper(['form', 'url']);
         $commanmodel = new Commanmodel();
         
         $employee =$commanmodel->all_multiple_query_order_by('employee',array('employee_status'=> 'Active'),'employee_name','ASC');
        $company = $commanmodel->all_multiple_query_order_by('company',array('status'=> 'Active'),'name','ASC');
        $department=$commanmodel->all_multiple_query_order_by('position',array('position_status'=> 'Active'),'position_id','ASC');
           $data = [
            'employee' => $employee,
            'department' => $department,
            'company' => $company
            
        ];
            return view('admin/head').view('admin/sidebar').view('admin/create_user',$data).view('admin/footer');
    
       } else {
            $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page?');
            return redirect()->back()->withInput();
       }
      
       
    }

    public function create_user_process()
    {
       $session = session();
       if(session()->get('admin_type')=='Supar Admin' or session()->get('user')=='Yes') {
        $commanmodel = new Commanmodel();
        
        $employee =$commanmodel->all_multiple_query_order_by('employee',array('employee_status'=> 'Active'),'employee_name','ASC');
        $company = $commanmodel->all_multiple_query_order_by('company',array('status'=> 'Active'),'name','ASC');
        
        
           $data = [
            'employee' => $employee,
            'company' => $company
            
        ];
        $session = session();
        helper(['form', 'url']);
        $validation =  \Config\Services::validation();
        $rules = [
            'user' => [
                'label'  => 'Name',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please Select user',
                ],
            ],
            'company' => [
                'label'  => 'company',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please select company',
                    'is_unique'  =>  'This email address is already exists!' 
                ],
            ],
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required|min_length[6]|max_length[20]',
                'errors' => [
                    'required'  =>  'Please enter password!',
                    'min_length'  =>  'Password min length 6!',
                    'max_length'  =>  'Password max length 20!'
                ],
            ],
            'confirm_password' => [
                'label'  => 'Confirm Password',
                'rules'  => 'required|min_length[6]|max_length[20]|matches[password]',
                'errors' => [
                    'required'  =>  'Please enter password!',
                    'min_length'  =>  'Password min length 6!',
                    'max_length'  =>  'Password max length 20!',
                    'matches' => 'Confirm password should be match password!'
                ],
            ],
        ];

        if($this->validate($rules))
        {
                  $employees = $commanmodel->get_single_query('employee',array('employee_id '=> $this->request->getVar('user')));
            
            
            $postData = array(
                'position' => $this->request->getVar('role'),  
                'employee_id' => $this->request->getVar('user'),
                'company_id' => $this->request->getVar('company'),
                
                'name' => $employees->employee_name,
                'email' => $employees->employee_email,
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'password_show' => $this->request->getVar('password'),
                'status' => $this->request->getVar('status'), 
                'date_time' => date('Y-m-d')
                );
             $insertid = $commanmodel->insert_query_get_inserid('admin',$postData);
       


            $data = $this->request->getVar('data'); // Assuming you're using a framework for request handling
            
            $postRole = array(
                'role_user_id' => $insertid,
                'company' => isset($data['company']) ? 'Yes' : 'No',
                'customer_compliant' => isset($data['customer_compliant']) ? 'Yes' : 'No',
                'vendor_creation' => isset($data['vendor_creation']) ? 'Yes' : 'No',
                'user' => isset($data['user']) ? 'Yes' : 'No',
                'department' => isset($data['department']) ? 'Yes' : 'No',
                'employee' => isset($data['employee']) ? 'Yes' : 'No',
                'attendance' => isset($data['attendance']) ? 'Yes' : 'No',
                'category' => isset($data['category']) ? 'Yes' : 'No',
                'tender' => isset($data['tender']) ? 'Yes' : 'No',
                'tender_approval' => isset($data['tender_approval']) ? 'Yes' : 'No',
                'tender_participated' => isset($data['tender_participated']) ? 'Yes' : 'No',
                'tender_result' => isset($data['tender_result']) ? 'Yes' : 'No',
                'order_status' => isset($data['order_status']) ? 'Yes' : 'No',
                'order' => isset($data['order']) ? 'Yes' : 'No',
                'dispatch_status' => isset($data['dispatch_status']) ? 'Yes' : 'No',
                'customer' => isset($data['customer']) ? 'Yes' : 'No',
                'purchase_order' => isset($data['purchase_order']) ? 'Yes' : 'No',
                'quotation' => isset($data['quotation']) ? 'Yes' : 'No',
            );

                 $insert = $commanmodel->insert_query('role',$postRole);
              

                
                if($insert) {
                    $session->setFlashdata('created', 'This User has been saved successfully!');
                    return redirect()->to('/admin/user');
                } else {
                    $session->setFlashdata('failed', 'Sorry, This User has not been saved. Please try again?');
                    return redirect()->to('/admin/user');
                }

        } else {

            $data["validation"] = $validation->getErrors();

            return view('admin/head').view('admin/sidebar').view('admin/create_user',$data).view('admin/footer');
        }
       } else {
            $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page?');
             return redirect()->back()->withInput();
       }
    }


 public function edit_user($id)
{
    $session = session();

    // Check user authorization
    if (session()->get('admin_type') == 'Supar Admin' || session()->get('user') == 'Yes') {
        $commanmodel = new Commanmodel();
        $validation = \Config\Services::validation();

        // Fetch user data
        $admin = $commanmodel->get_single_query('admin', ['id' => $id]);
       

        // Data to be passed to the view
        $data = [
            'admin' => $admin,
            'id' => $id,
            
            'validation' => $validation, // Add validation object to data
        ];

        helper(['form', 'url']);

        // Load views and pass data
        return view('admin/head') . view('admin/sidebar') . view('admin/edit_user', $data) . view('admin/footer');
    } else {
        // User is not authorized
        $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page.');
        return redirect()->to('/admin/dashboard');
    }
}
   public function edit_user_process($id)
{
    $session = session();

    // Check user authorization
    if(session()->get('admin_type') == 'Supar Admin' || session()->get('user') == 'Yes') {

        $commanmodel = new Commanmodel();
        helper(['form', 'url']);

        $admin = $commanmodel->get_single_query('admin', ['id ' => $id]);

        $data = [
            'admin' => $admin,
            'id' => $id,
        ];

        // Validation rules
        $rules = [
            'name' => [
                'label'  => 'Name',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please Enter Name',
                ],
            ],
            'email' => [
                'label'  => 'Email',
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required' => 'Please Enter Email',
                    'valid_email' => 'Please enter a valid Email',
                ],
            ],
            // GST is optional, no validation
        ];

        if($this->validate($rules)) {

            // Determine status color
            $status = $this->request->getVar('status');
            $status_color = ($status == 'Active') ? 'success' : 'danger';

            // Prepare data for update
            $postData = [
                'name'   => $this->request->getVar('name'),
                'email'  => $this->request->getVar('email'),
                'status' => $status,
                'status_color' => $status_color,
                'gst_number' => $this->request->getVar('gst_number'), // optional
            ];

            // Handle Aadhaar upload
            $aadhar_file = $this->request->getFile('aadhar_file');
            if($aadhar_file && $aadhar_file->isValid() && !$aadhar_file->hasMoved()) {
                $newName = 'aadhar_' . $id . '_' . time() . '.' . $aadhar_file->getClientExtension();
                $aadhar_file->move('assets/aadhar/', $newName);
                $postData['aadhar_file'] = $newName;
            }

            // Handle PAN upload
            $pan_file = $this->request->getFile('pan_file');
            if($pan_file && $pan_file->isValid() && !$pan_file->hasMoved()) {
                $newName = 'pan_' . $id . '_' . time() . '.' . $pan_file->getClientExtension();
                $pan_file->move( 'assets/pan/', $newName);
                $postData['pan_file'] = $newName;
            }

            $where_data = ['id' => $id];

            // Update record
            $update = $commanmodel->update_query('admin', $postData, $where_data);

            if($update) {
                $session->setFlashdata('created', 'This Vender has been saved successfully!');
                return redirect()->to('/admin/user');
            } else {
                $session->setFlashdata('failed', 'Sorry, This Vender has not been saved. Please try again.');
                return redirect()->to('/admin/user');
            }

        } else {
            $data["validation"] = $this->validator;
            return view('admin/head')
                 .view('admin/sidebar')
                 .view('admin/edit_user', $data)
                 .view('admin/footer');
        }

    } else {
        $session->setFlashdata('failed', 'Sorry, You are not authorized to access this page.');
        return redirect()->back()->withInput();
    }
}



    

   public function product_best_deal_action()
  {
       $commanmodel = new Commanmodel();
  $product_id =$this->request->getVar('product_id');
  $best_deal_product = $this->request->getVar('best_deal_product');  
  $fild = $this->request->getVar('fild');
  
  $commanmodel->update_query('answered',array('winner'=> 'No'),array());
  
  $data=$commanmodel->update_query('answered',array($fild=> $best_deal_product),array('answered_id'=> $product_id));
    echo json_encode($data);

  }
  
  
  
  public function product($id=null)
{
     $session = session();
 
      $commanmodel = new Commanmodel();

$data['id'] = $id;
        $data['table_name'] = 'product';
    
            $table_header = [
                
            ['data' => 'id'],
            ['data' => 'images'],
            ['data' => 'product'],
            ['data' => 'category'],
            ['data' => 'action'],
        
        ];
        
        $data['table_column'] = json_encode($table_header);
    
 
   return view('admin/head').view('admin/sidebar').view('admin/product', $data).view('admin/footer');

}
  
     public function productlist()
{
$session = session();
$commanmodel = new Commanmodel();


// Define your DataTables parameters
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchname = $_POST['searchname']; // Change this to your search input
$id = $_POST['id']; 
$status = $_POST['status']; 
// Define filters based on your requirements
$filters = [];

// Add search filter if a search term is provided
if (!empty($searchname)) {
$filters[] = [
    'column' => 'product_name',
    'value' => $searchname,
    'type' => 'like',
];
}


if (!empty($status)) {
$filters[] = [
    'column' => 'product_status',
    'value' => $status,
    'type' => 'like',
];
}


if (!empty($id)) {
$filters[] = [
    'column' => 'product_create_by',
    'value' => $id,
    'type' => 'where',
];
}


if (session()->get('admin_type')=='Admin') { 
    $filters[] = [
    'column' => 'product_create_by',
    'value' => session()->get('id'),
    'type' => 'where',
];
}

// Define ordering parameters
$order = null; // Set this based on your DataTables ordering requirements
if (!empty($_POST['order'])) {
$orderColumn = $_POST['order'][0]['column'];
$orderDirection = $_POST['order'][0]['dir'];
// Define the column name you want to order by based on $orderColumn
$order = [
    'column' => 'product_id', // Change this to your desired default order column
    'order' => 'DESC', // Change this to your desired default order direction
];
}

// Retrieve data using the getDataFromTable function
$result = $commanmodel->getDataFromTable('product', $filters, $order, $length, $start);

// Process the retrieved data
$alldata = $result['filteredRecords'];
$data = [];
$no = $start + 1;
$sn = 1;
foreach ($alldata as $alldata_view) {


$name= $alldata_view->product_name;

$images = '<img class="cat-thumb" src="'.base_url().'/assets/images/'.$alldata_view->product_thumbnail.'" >'; 
    $category = '';
    if (!empty($alldata_view->product_category)) {
        try {
            // Optional: set a timeout if getnamecategory uses HTTP requests (depends on your function)
            $categoryName = $commanmodel->getnamecategory($alldata_view->product_category);
            $category = !empty($categoryName) ? $categoryName : '';
        } catch (\Throwable $e) {
            // Skip this category if it takes too long or errors
            $category = 'N/A';
        }
    }
          
             

$action = '<a href="'.base_url().'/admin/edit_product/'.$alldata_view->product_id .'"  class="btn btn-primary btn-sm " >Edit </a>';

$action .= '<a href="#"  class="btn btn-'.$alldata_view->product_status_color.' btn-sm " >'.$alldata_view->product_status.' </a>';
//$action .= '<br><a href="'.base_url().'/admin/faq/'.$alldata_view->product_id .'"  class="btn btn-primary btn-sm " >FAQ </a>';

        $status = '';
      
      

$data[] = [
    "id" => $sn,
    "images" => $images,
    "product" => $name,
    
    "category" => $category,
    "action" => $action 
];

$no++;

$sn++;
}

// Prepare the DataTables response
$response = [
"draw" => intval($draw),
"recordsTotal" => $result['filteredRecordCount'] ,
"recordsFiltered" => $result['totalRecords'],
"data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);

            


}
  public function create_product()
    {
        $session = session();
       $commanmodel = new Commanmodel();
          $main = $commanmodel->all_multiple_query_order_by('attribute_main',array(),'attribute_main_id','ASC');
         $brand = $commanmodel->all_multiple_query_order_by('brand',array(),'brand_name','ASC');
          $collections = $commanmodel->all_multiple_query_order_by('collections',array(),'collections_name','ASC');
        
        
        $category = $commanmodel->all_multiple_query_order_by('category',array('category_status'=> 'Active'),'category_id','ASC');
          $attributes = $commanmodel->all_multiple_query_order_by('attributes',array('attributes_status'=> 'Active'),'attributes_id','ASC');
         $data = [
       'main' => $main,
        'collections' => $collections,
        'brand' => $brand,
            'category' => $category,
             'attributes' => $attributes
        ];
        return view('admin/head').view('admin/sidebar').view('admin/create_product',$data).view('admin/footer');
       
    }
  
  
   public function create_product_process()
{
    $session = session();
    helper(['form', 'url']);

    $commanmodel = new Commanmodel();

    // Page data (dropdowns etc.)
    $main        = $commanmodel->all_multiple_query_order_by('attribute_main', [], 'attribute_main_id', 'ASC');
    $collections = $commanmodel->all_multiple_query_order_by('collections', [], 'collections_name', 'ASC');
    $brand       = $commanmodel->all_multiple_query_order_by('brand', [], 'brand_name', 'ASC');
    $category    = $commanmodel->all_multiple_query_order_by('category', ['category_status' => 'Active'], 'category_id', 'ASC');
    $attributes  = $commanmodel->all_multiple_query_order_by('attributes', ['attributes_status' => 'Active'], 'attributes_id', 'ASC');

    $data = [
        'main'        => $main,
        'collections' => $collections,
        'brand'       => $brand,
        'category'    => $category,
        'attributes'  => $attributes,
    ];

    $validation = \Config\Services::validation();

    // Basic validation rules
    $rules = [
        'name' => [
            'label'  => 'Title',
            'rules'  => 'required|trim',
            'errors' => ['required' => 'Please enter title'],
        ],
        'parent_id' => [
            'label'  => 'category',
            'rules'  => 'required',
            'errors' => ['required' => 'Please select category'],
        ],
        'overview' => [
            'label'  => 'overview',
            'rules'  => 'required|trim',
            'errors' => ['required' => 'Please enter overview'],
        ],
        // Primary image optional (agar required chahiye to: required rules add kar do)
        'primary_image' => [
            'label' => 'Primary Image',
            'rules' => 'if_exist|is_image[primary_image]',
        ],
    ];

    if (!$this->validate($rules)) {
        $data["validation"] = $validation->getErrors();
        return view('admin/head')
            . view('admin/sidebar')
            . view('admin/create_product', $data)
            . view('admin/footer');
    }

    // Status + color
    $status = (string) $this->request->getPost('status');
    $status_color = 'danger';
    if ($status === 'Active') {
        $status_color = 'success';
    } elseif ($status === 'Inactive') {
        $status_color = 'danger';
    }

    // Upload primary image (optional)
    $primary_image = '';
    $primaryFile = $this->request->getFile('primary_image');
    if ($primaryFile && $primaryFile->isValid() && !$primaryFile->hasMoved()) {
        $primary_image = $this->getUniqueFileName($primaryFile->getName());
        $primaryFile->move('assets/images', $primary_image);
    }

    // Slug generate
    $title = strip_tags((string) $this->request->getPost('name'));
    $titleURL = strtolower(url_title($title));
    if ($commanmodel->get_url_slug('product', $titleURL)) {
        $titleURL = $titleURL . '-' . time();
    }

    // Collections (multi)
    $collectionsInput = $this->request->getPost('collections');
    $collectionsStr = '';
    if (is_array($collectionsInput) && !empty($collectionsInput)) {
        $collectionsStr = implode(', ', $collectionsInput);
    }

    // Prepare product data
    $postData = [
        'product_name'            => $this->request->getPost('name'),
        'product_category'        => $this->request->getPost('parent_id'),
        'product_brand'           => $this->request->getPost('product_brand'),
        'product_collections'     => $collectionsStr,
        'slug'                    => $titleURL,
        'product_thumbnail'       => $primary_image,
        'product_max_price'       => $this->request->getPost('max_price'),
        'product_price'           => $this->request->getPost('price'),
        'inclusive_gst'           => $this->request->getPost('inclusive_gst'),
        'gst'                     => $this->request->getPost('gst'),
        'sku'                     => $this->request->getPost('sku'),
        'quantity'                => $this->request->getPost('quantity'),
        'product_overview'        => $this->request->getPost('overview'),
        'product_description'     => $this->request->getPost('description'),
        'additional_information'  => $this->request->getPost('additional_information'),
        'product_meta_title'      => $this->request->getPost('meta_title'),
        'product_meta_keyword'    => $this->request->getPost('meta_keyword'),
        'product_meta_description'=> $this->request->getPost('meta_description'),
        'product_status'          => $status,
        'product_status_color'    => $status_color,
        'product_create_by'       => session()->get('id') ? session()->get('id') : 0,
        'product_date'            => date('Y-m-d'),
    ];

    // DB transaction (safe)
    $db = \Config\Database::connect();
    $db->transStart();

    // Insert product
    $insertid = $commanmodel->insert_query_get_inserid('product', $postData);

    // If product insert failed
    if (!$insertid) {
        $db->transRollback();
        $session->setFlashdata('failed', 'Sorry, This Product has not been saved. Please try again?');
        return redirect()->to('/admin/product');
    }

    /**
     * Multiple Product Images: <input type="file" name="productimage[]" multiple>
     */
    $productImages = $this->request->getFileMultiple('productimage');
    if (!empty($productImages) && is_array($productImages)) {
        foreach ($productImages as $img) {
            if ($img && $img->isValid() && !$img->hasMoved()) {
                $newName = $this->getUniqueFileName($img->getName());
                $img->move('assets/images', $newName);

                $imageArray = [
                    'product_image_product_id' => $insertid,
                    'product_image_url'        => $newName,
                ];
                $commanmodel->insert_query('product_image', $imageArray);
            }
        }
    }

    /**
     * Variants
     * variant[], variant_price[], variant_available[]
     * variant_images[] (multiple files aligned by index)
     */
    $variants          = $this->request->getPost('variant');
    $variantPrices     = $this->request->getPost('variant_price');
    $variantAvailables = $this->request->getPost('variant_available');
    $variantImages     = $this->request->getFileMultiple('variant_images'); // aligned by index

    if (is_array($variants) && count($variants) > 0) {
        for ($v = 0; $v < count($variants); $v++) {

            $variant_image = '';
            if (!empty($variantImages) && isset($variantImages[$v]) && $variantImages[$v]->isValid() && !$variantImages[$v]->hasMoved()) {
                $variant_image = $this->getUniqueFileName($variantImages[$v]->getName());
                $variantImages[$v]->move('assets/images', $variant_image);
            }

            $variant_data = [
                'variant_pro_id'          => $insertid,
                'varian'                  => $variants[$v] ?? '',
                'pro_variant_price'       => $variantPrices[$v] ?? '',
                'pro_variant_available'   => $variantAvailables[$v] ?? '',
                'pro_variant_image'       => $variant_image,
            ];

            // avoid inserting fully empty rows
            if (trim((string)($variant_data['varian'])) !== '') {
                $commanmodel->insert_query_get_inserid('pro_variant', $variant_data);
            }
        }
    }

    /**
     * Groups + Items
     * groupcount, group_1, item_1[], group_2, item_2[] ...
     */
    $groupcount = (int) $this->request->getPost('groupcount');
    $groupcount = $groupcount + 1; // same as your logic

    for ($i = 1; $i < $groupcount; $i++) {
        $groupName = (string) $this->request->getPost('group_' . $i);
        $groupName = trim($groupName);

        if ($groupName === '') {
            continue;
        }

        $group_data = [
            'pro_group_pro_id' => $insertid,
            'pro_group_name'   => $groupName,
        ];

        $groupinserted = $commanmodel->insert_query_get_inserid('pro_group', $group_data);

        if (!$groupinserted) {
            continue;
        }

        $items = $this->request->getPost('item_' . $i);
        if (is_array($items) && !empty($items)) {
            foreach ($items as $itemName) {
                $itemName = trim((string) $itemName);
                if ($itemName === '') {
                    continue;
                }

                $item_data = [
                    'pro_item_group_id' => $groupinserted,
                    'pro_item_name'     => $itemName,
                ];
                $commanmodel->insert_query_get_inserid('pro_item', $item_data);
            }
        }
    }

    $db->transComplete();

    if ($db->transStatus() === false) {
        $session->setFlashdata('failed', 'Sorry, Something went wrong while saving. Please try again.');
        return redirect()->to('/admin/product');
    }

    $session->setFlashdata('created', 'This Product has been saved successfully!');
    return redirect()->to('/admin/product');
}

  
    public function edit_product($id)
    {
        $session = session();
       $commanmodel = new Commanmodel();

$brand = $commanmodel->all_multiple_query_order_by('brand',array(),'brand_name','ASC');
          $collections = $commanmodel->all_multiple_query_order_by('collections',array(),'collections_name','ASC');
      $product = $commanmodel->get_single_query('product',array('product_id'=> $id));
        $product_image = $commanmodel->all_multiple_query_order_by('product_image',array('product_image_product_id'=> $id),'product_image_id','ASC');
  $main = $commanmodel->all_multiple_query_order_by('attribute_main',array(),'attribute_main_id','ASC');
        $category = $commanmodel->all_multiple_query_order_by('category',array('category_status'=> 'Active'),'category_id','ASC');
          $attributes = $commanmodel->all_multiple_query_order_by('attributes',array('attributes_status'=> 'Active'),'attributes_id','ASC');
          $pro_group = $commanmodel->all_multiple_query_order_by('pro_group',array('pro_group_pro_id' => $product->product_id),'pro_group_id','ASC');  
	
    $pro_variant = $commanmodel->all_multiple_query_order_by('pro_variant',array('variant_pro_id' => $product->product_id),'pro_variant_id','ASC'); 
         $data = [
              'id' => $id,
       'main' => $main,
       'collections' => $collections,
        'brand' => $brand,
       'product' => $product,
        'product_image' => $product_image,
            'category' => $category,
             'pro_group' => $pro_group,
            'pro_variant' => $pro_variant,
             'attributes' => $attributes
        ];
        return view('admin/head').view('admin/sidebar').view('admin/edit_product',$data).view('admin/footer');
       
    }
    
public function update_product_process($id)
{
    $session = session();
    helper(['form', 'url']);

    $commanmodel = new Commanmodel();
    $request     = service('request');

    // Fetch existing data
    $brand        = $commanmodel->all_multiple_query_order_by('brand', [], 'brand_name', 'ASC');
    $collections  = $commanmodel->all_multiple_query_order_by('collections', [], 'collections_name', 'ASC');
    $product      = $commanmodel->get_single_query('product', ['product_id' => $id]);

    if (!$product) {
        $session->setFlashdata('failed', 'Product not found!');
        return redirect()->to('/admin/product');
    }

    $product_image = $commanmodel->all_multiple_query_order_by(
        'product_image',
        ['product_image_product_id' => $id],
        'product_image_id',
        'ASC'
    );

    $main       = $commanmodel->all_multiple_query_order_by('attribute_main', [], 'attribute_main_id', 'ASC');
    $category   = $commanmodel->all_multiple_query_order_by('category', ['category_status' => 'Active'], 'category_id', 'ASC');
    $attributes = $commanmodel->all_multiple_query_order_by('attributes', ['attributes_status' => 'Active'], 'attributes_id', 'ASC');

    $pro_group = $commanmodel->all_multiple_query_order_by(
        'pro_group',
        ['pro_group_pro_id' => $id],
        'pro_group_id',
        'ASC'
    );

    $pro_variant = $commanmodel->all_multiple_query_order_by(
        'pro_variant',
        ['variant_pro_id' => $id],
        'pro_variant_id',
        'ASC'
    );

    $data = [
        'id'            => $id,
        'main'          => $main,
        'collections'   => $collections,
        'brand'         => $brand,
        'product'       => $product,
        'product_image' => $product_image,
        'category'      => $category,
        'pro_group'     => $pro_group,
        'pro_variant'   => $pro_variant,
        'attributes'    => $attributes
    ];

    // Validation
    $validation = \Config\Services::validation();
    $rules = [
        'name' => [
            'label'  => 'Title',
            'rules'  => 'required|trim',
            'errors' => ['required' => 'Please enter title'],
        ],
        'parent_id' => [
            'label'  => 'category',
            'rules'  => 'required',
            'errors' => ['required' => 'Please select category'],
        ],
        'overview' => [
            'label'  => 'overview',
            'rules'  => 'required|trim',
            'errors' => ['required' => 'Please enter overview'],
        ],
        // Update me defaultimage optional
        'defaultimage' => [
            'label' => 'Image File',
            'rules' => 'if_exist|is_image[defaultimage]',
        ],
    ];

    if (!$this->validate($rules)) {
        $data["validation"] = $validation->getErrors();
        return view('admin/head')
            . view('admin/sidebar')
            . view('admin/create_user', $data)
            . view('admin/footer');
    }

    // Status color
    $status = (string) $this->request->getPost('status');
    $status_color = ($status === 'Active') ? 'success' : 'danger';

    // Primary image update
    $primary_image = (string) $this->request->getPost('primary_image_old');

    $defaultFile = $this->request->getFile('defaultimage');
    if ($defaultFile && $defaultFile->isValid() && !$defaultFile->hasMoved()) {
        $primary_image = $this->getUniqueFileName($defaultFile->getName());
        $defaultFile->move('assets/images', $primary_image);
    }

    // Build attributes array for combination generation (from updated groups/items)
    $attributeMap = [];

    // DB Transaction
    $db = \Config\Database::connect();
    $db->transStart();

    /**
     * 1) Existing product images replace/delete
     * UI logic:
     * - fileimage_{image_id} = yes => replace from file input productimage_{image_id}
     * - else delete that row
     */
    if (!empty($product_image)) {
        foreach ($product_image as $imgRow) {

            $flag = $this->request->getPost('fileimage_' . $imgRow->product_image_id);

            if ($flag === 'yes') {
                $productImageInput = 'productimage_' . $imgRow->product_image_id;
                $uploadedFile = $request->getFile($productImageInput);

                if ($uploadedFile && $uploadedFile->isValid() && !$uploadedFile->hasMoved()) {
                    $newName = $this->getUniqueFileName($uploadedFile->getName());
                    $uploadedFile->move('assets/images', $newName);

                    $commanmodel->update_query(
                        'product_image',
                        ['product_image_url' => $newName],
                        ['product_image_id' => $imgRow->product_image_id]
                    );
                }
            } else {
                // delete
                $commanmodel->delete_query('product_image', ['product_image_id' => $imgRow->product_image_id]);
            }
        }
    }

    /**
     * 2) Group edit / delete existing groups & items
     */
    if (!empty($pro_group)) {
        foreach ($pro_group as $groupRow) {

            $groupEdit = $this->request->getPost('group_edit_' . $groupRow->pro_group_id);

            if ($groupEdit) {
                // update group name
                $commanmodel->update_query(
                    'pro_group',
                    ['pro_group_name' => $groupEdit],
                    ['pro_group_id' => $groupRow->pro_group_id]
                );

                // replace items if item_edit_{group_id} is array
                $itemsEdit = $this->request->getPost('item_edit_' . $groupRow->pro_group_id);

                if (is_array($itemsEdit)) {
                    // delete old items, then insert new
                    $commanmodel->delete_query('pro_item', ['pro_item_group_id' => $groupRow->pro_group_id]);

                    foreach ($itemsEdit as $itemName) {
                        $itemName = trim((string) $itemName);
                        if ($itemName === '') continue;

                        $commanmodel->insert_query_get_inserid('pro_item', [
                            'pro_item_group_id' => $groupRow->pro_group_id,
                            'pro_item_name'     => $itemName,
                        ]);
                    }

                    // for combination
                    $attributeMap[$groupEdit] = $itemsEdit;
                }

                // insert new items for existing group
                $itemsNewEdit = $this->request->getPost('item_new_edit_' . $groupRow->pro_group_id);
                if (is_array($itemsNewEdit) && !empty($itemsNewEdit)) {
                    foreach ($itemsNewEdit as $itemName) {
                        $itemName = trim((string) $itemName);
                        if ($itemName === '') continue;

                        $commanmodel->insert_query_get_inserid('pro_item', [
                            'pro_item_group_id' => $groupRow->pro_group_id,
                            'pro_item_name'     => $itemName,
                        ]);

                        $attributeMap[$groupEdit][] = $itemName;
                    }
                }

            } else {
                // delete full group (and its items) if group_edit missing
                $commanmodel->delete_query('pro_item', ['pro_item_group_id' => $groupRow->pro_group_id]);
                $commanmodel->delete_query('pro_group', ['pro_group_id' => $groupRow->pro_group_id]);
            }
        }
    }

    /**
     * helper: Generate variant combinations based on attributeMap
     */
    $generateCombinations = function(array $attributes): array {
        $combinations = [];

        foreach ($attributes as $values) {
            $flatValues = [];

            if (is_array($values)) {
                foreach ($values as $v) {
                    if (is_array($v)) {
                        $flatValues = array_merge($flatValues, $v);
                    } else {
                        $flatValues[] = $v;
                    }
                }
            }

            $flatValues = array_values(array_filter(array_map('trim', $flatValues)));

            if (empty($flatValues)) continue;

            if (empty($combinations)) {
                $combinations = $flatValues;
            } else {
                $new = [];
                foreach ($combinations as $c) {
                    foreach ($flatValues as $v) {
                        $new[] = $c . '-' . $v;
                    }
                }
                $combinations = $new;
            }
        }

        return $combinations;
    };

    $generatedVariantNames = $generateCombinations($attributeMap);

    /**
     * 3) Update product main table
     */
    $title = strip_tags((string) $this->request->getPost('name'));
    $titleURL = strtolower(url_title($title));

    $collectionsInput = $this->request->getPost('collections');
    $collectionsStr = (is_array($collectionsInput) && !empty($collectionsInput))
        ? implode(', ', $collectionsInput)
        : '';

    $postData = [
        'product_name'             => $this->request->getPost('name'),
        'product_category'         => $this->request->getPost('parent_id'),
        'product_brand'            => $this->request->getPost('product_brand'),
        'product_collections'      => $collectionsStr,
        'slug'                     => $titleURL,
        'product_thumbnail'        => $primary_image,
        'inclusive_gst'            => $this->request->getPost('inclusive_gst'),
        'gst'                      => $this->request->getPost('gst'),
        'product_max_price'        => $this->request->getPost('max_price'),
        'product_price'            => $this->request->getPost('price'),
        'sku'                      => $this->request->getPost('sku'),
        'quantity'                 => $this->request->getPost('quantity'),
        'product_overview'         => $this->request->getPost('overview'),
        'product_description'      => $this->request->getPost('description'),
        'additional_information'   => $this->request->getPost('additional_information'),
        'product_meta_title'       => $this->request->getPost('meta_title'),
        'product_meta_keyword'     => $this->request->getPost('meta_keyword'),
        'product_meta_description' => $this->request->getPost('meta_description'),
        'product_status'           => $status,
        'product_status_color'     => $status_color,
        'product_date'             => date('Y-m-d'),
    ];

    $updated = $commanmodel->update_query('product', $postData, ['product_id' => $id]);

    /**
     * 4) Add new product images (productimage[])
     */
    $newProductImages = $this->request->getFileMultiple('productimage');
    if (!empty($newProductImages) && is_array($newProductImages)) {
        foreach ($newProductImages as $img) {
            if ($img && $img->isValid() && !$img->hasMoved()) {
                $newName = $this->getUniqueFileName($img->getName());
                $img->move('assets/images', $newName);

                $commanmodel->insert_query('product_image', [
                    'product_image_product_id' => $id,
                    'product_image_url'        => $newName
                ]);
            }
        }
    }

    /**
     * 5) Variants update
     *
     * If variant[] comes -> delete all old & reinsert (simplest & safest)
     * Else -> update existing variants via variant_{id}, variant_price_{id}, variant_available_{id}
     */
    $variantPosted = $this->request->getPost('variant');
    $variantPrices = $this->request->getPost('variant_price');
    $variantAvail  = $this->request->getPost('variant_available');
    $variantImages = $this->request->getFileMultiple('variant_images');
    $variantOldImg = $this->request->getPost('variant_edit_images'); // array

    if (is_array($variantPosted) && count($variantPosted) > 0) {

        // delete all old variants
        $commanmodel->delete_query('pro_variant', ['variant_pro_id' => $id]);

        for ($v = 0; $v < count($variantPosted); $v++) {

            // image old/new
            $variant_image = '';
            if (!empty($variantImages) && isset($variantImages[$v]) && $variantImages[$v]->isValid() && !$variantImages[$v]->hasMoved()) {
                $variant_image = $this->getUniqueFileName($variantImages[$v]->getName());
                $variantImages[$v]->move('assets/images', $variant_image);
            } else {
                if (is_array($variantOldImg) && isset($variantOldImg[$v])) {
                    $variant_image = $variantOldImg[$v];
                }
            }

            $commanmodel->insert_query_get_inserid('pro_variant', [
                'variant_pro_id'        => $id,
                'varian'                => $variantPosted[$v] ?? '',
                'pro_variant_price'     => $variantPrices[$v] ?? '',
                'pro_variant_available' => $variantAvail[$v] ?? '',
                'pro_variant_image'     => $variant_image,
            ]);
        }

    } else {
        // Update existing based on generated variants (if created)
        if (!empty($pro_variant)) {
            foreach ($pro_variant as $vr) {

                // If new generated variants exist, keep only those
                if (!empty($generatedVariantNames) && !in_array($vr->varian, $generatedVariantNames, true)) {
                    $commanmodel->delete_query('pro_variant', ['pro_variant_id' => $vr->pro_variant_id]);
                    continue;
                }

                $variant_edit_data = [
                    'varian'                => $this->request->getPost('variant_' . $vr->pro_variant_id),
                    'pro_variant_price'     => $this->request->getPost('variant_price_' . $vr->pro_variant_id),
                    'pro_variant_available' => $this->request->getPost('variant_available_' . $vr->pro_variant_id),
                ];

                $commanmodel->update_query('pro_variant', $variant_edit_data, ['pro_variant_id' => $vr->pro_variant_id]);
            }
        }
    }

    /**
     * 6) Add new groups/items (same as create)
     */
    $groupcount = (int) $this->request->getPost('groupcount');
    $groupcount = $groupcount + 1;

    for ($i = 1; $i < $groupcount; $i++) {

        $newGroupName = trim((string) $this->request->getPost('group_' . $i));
        if ($newGroupName === '') continue;

        $groupinserted = $commanmodel->insert_query_get_inserid('pro_group', [
            'pro_group_pro_id' => $id,
            'pro_group_name'   => $newGroupName,
        ]);

        $items = $this->request->getPost('item_' . $i);
        if ($groupinserted && is_array($items) && !empty($items)) {
            foreach ($items as $itemName) {
                $itemName = trim((string) $itemName);
                if ($itemName === '') continue;

                $commanmodel->insert_query_get_inserid('pro_item', [
                    'pro_item_group_id' => $groupinserted,
                    'pro_item_name'     => $itemName,
                ]);
            }
        }
    }

    $db->transComplete();

    if ($db->transStatus() === false) {
        $session->setFlashdata('failed', 'Sorry, Something went wrong while saving. Please try again.');
        return redirect()->to('/admin/product');
    }

    if ($updated) {
        $session->setFlashdata('created', 'This Product has been saved successfully!');
    } else {
        $session->setFlashdata('failed', 'Sorry, This Product has not been saved. Please try again?');
    }

    return redirect()->to('/admin/product');
}

  private function getUniqueFileName($fileName)
{
    $filePath = 'assets/images/' . $fileName;
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $baseName = pathinfo($fileName, PATHINFO_FILENAME);
    $counter = 1;

    // If file with the same name exists, append a counter to the file name
    while (file_exists($filePath)) {
        $filePath = 'assets/images/' . $baseName . '-' . $counter . '.' . $ext;
        $counter++;
    }

    return basename($filePath);  // Return the unique file name
}
  public function our_blogs(){
         $commanmodel = new Commanmodel();
        $data['blogView'] = $commanmodel->get_multiple_query_order_by('blogs','blog_id','DESC');    
    
        
        return view('admin/head').view('admin/sidebar').view('admin/our-blogs', $data).view('admin/footer');
       
    }


    public function create_blog()
    {
          
         $session = session();
         return view('admin/head').view('admin/sidebar').view('admin/create-blog').view('admin/footer');
       
    }

 public function create_blog_process()
    {
        
        $commanmodel = new Commanmodel();
        $session = session();
        helper(['form', 'url']);
        $validation =  \Config\Services::validation();
        
        
        if($this->request->getVar('CreateNewBlog'))
        {
      
        
                $rules = [
            'blog_name' => [
                'label'  => 'Blog name',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please blog name',
                ],
            ],
            'blog_status' => [
                'label'  => 'Blog small description',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please select status',
                    
                ],
            ],
            
           'blog_small_description' => [
                'label'  => 'Blog status',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please enter small descriptio',
                    
                ],
            ],
        ];
        
                if($this->validate($rules) == FALSE)
                {    
      
            $data["validation"] = $validation->getErrors();
             return view('admin/head').view('admin/sidebar').view('admin/create-blog', $data).view('admin/footer');
                }
                else
                {


    $status = $this->request->getVar('blog_status');
    if($status=='Active')
    {
      $status_color = 'success';
    }
    if($status=='Inactive')
    {
      $status_color = 'danger';
    }
            if($_FILES['blog_image']['name']!=""){
                
                
                $file = $this->request->getFile('blog_image');

        // Generate a new secure name
        $blog_image = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/blog', $blog_image);
                
          
            }
            else{
           $blog_image = '';
            }












        $title = strip_tags($this->request->getVar('url_slug'));
        $titleURL = strtolower(url_title($title));
   


    $post_data = array(
    'blog_name' => $this->request->getVar('blog_name'),
    'url_slug' => $titleURL,
    
    'blog_status' => $this->request->getVar('blog_status'),

    'blog_status_color' => $status_color,
    'blog_image' => $blog_image,

    'blog_small_description' => $this->request->getVar('blog_small_description'),
    'blog_description' => $this->request->getVar('blog_description'),
    'meta_title' => $this->request->getVar('meta_title'),
    'meta_keyword' => $this->request->getVar('meta_keyword'),
    'meta_description' => $this->request->getVar('meta_description')
    );
                   $inserted = $commanmodel->insert_query('blogs',$post_data); 
                   if($inserted)
                   {
                 
                    $session->setFlashdata('created', 'This blog has been created!');
                
                    return redirect()->to('/admin/blog');
                    
                   }
                   else
                   {
         
            
             $session->setFlashdata('failed', 'Sorry, This course has not been created. Please try again?');  
        return view('admin/head').view('admin/sidebar').view('admin/create-blog', $data).view('admin/footer');
                   }


                }
        }
        else
        {
   
             $session->setFlashdata('failed', 'Submit process is not working!'); 
        return view('admin/head').view('admin/sidebar').view('admin/create-blog', $data).view('admin/footer');
        }



       
    }
    
    public function delete_our_blog($blog_id)
    {
         $session = session();
         $commanmodel = new Commanmodel();
     $deleteBlog = $commanmodel->delete_query('blogs',array('blog_id' =>$blog_id));
     if($deleteBlog)
     {
     
      $session->setFlashdata('created', 'This blog is delete.');
       return redirect()->to('/admin/blog');
     }
     else
     {
          $session->setFlashdata('failed', 'This is not delete!');

       return redirect()->to('/admin/blog');
     }
    
    }


    public function edit_our_blog($blog_id)
    {
      $commanmodel = new Commanmodel();
        $data['blogView'] = $commanmodel->get_single_query('blogs',array('blog_id' => $blog_id));    
 
        
         return view('admin/head').view('admin/sidebar').view('admin/edit-blog', $data).view('admin/footer');
       
    }


 public function edit_blog_process($blog_id)
    {
       $commanmodel = new Commanmodel();
       $session = session();
  helper(['form', 'url']);
        $validation =  \Config\Services::validation();
        if($this->request->getVar('CreateEditBlog'))
        {
         $rules = [
            'blog_name' => [
                'label'  => 'Blog name',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please blog name',
                ],
            ],
            'blog_status' => [
                'label'  => 'Blog small description',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please select status',
                    
                ],
            ],
            
           'blog_small_description' => [
                'label'  => 'Blog status',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please enter small descriptio',
                    
                ],
            ],
        ];
        
                if($this->validate($rules) == FALSE)
                {   
                    $data["validation"] = $validation->getErrors();
        $data['blogView'] = $commanmodel->get_single_query('blogs',array('blog_id' => $blog_id));    
        
        return view('admin/head').view('admin/sidebar').view('admin/edit-blog', $data).view('admin/footer');
                }
                else
                {


    $status = $this->request->getVar('blog_status');
    if($status=='Active')
    {
      $status_color = 'success';
    }
    if($status=='Inactive')
    {
      $status_color = 'danger';
    }
            if($_FILES['blog_image']['name']!=""){
                    $file = $this->request->getFile('blog_image');

        // Generate a new secure name
        $blog_image = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/blog', $blog_image);
            }
            else{
                  $blog_image= $this->request->getVar('blog_image_old');
            }


 $title = strip_tags($this->request->getVar('url_slug'));
        $titleURL = strtolower(url_title($title));
 
    $post_data = array(
    'blog_name' => $this->request->getVar('blog_name'),
    'blog_status' => $this->request->getVar('blog_status'), 
  'url_slug' => $titleURL,
  
    'blog_status_color' => $status_color,
    'blog_image' => $blog_image,
  
    'blog_small_description' => $this->request->getVar('blog_small_description'),
    'blog_description' => $this->request->getVar('blog_description'),
    'meta_title' => $this->request->getVar('meta_title'),
    'meta_keyword' => $this->request->getVar('meta_keyword'),
    'meta_description' => $this->request->getVar('meta_description') 
    );
                   $inserted = $commanmodel->update_query('blogs',$post_data,array('blog_id' => $blog_id)); 
                   if($inserted)
                   {
                    $session->setFlashdata('created', 'This blog has been updated.');
               
                    
                     return redirect()->to('/admin/blog');
                   }
                   else
                   {
            $session->setFlashdata('failed', 'Sorry, This blog has not been updated. Please try again?');    
        $data['blogView'] = $commanmodel->get_single_query('blogs',array('blog_id' => $blog_id));    
    
     return view('admin/head').view('admin/sidebar').view('admin/edit-blog', $data).view('admin/footer');
                   }


                }
        }
        else
        {
            $session->setFlashdata('failed', 'Submit process is not working!');    
        $data['blogView'] = $commanmodel->get_single_query('blogs',array('blog_id' => $blog_id));    
       
        return view('admin/head').view('admin/sidebar').view('admin/edit-blog', $data).view('admin/footer');
        }



      
    }
         public function team()
    {
        $session = session();
        $commanmodel = new Commanmodel();
      $category = $commanmodel->all_multiple_query_order_by('category',array('parent_id'=> '0','subparent_id'=> '0'),'menu_order','ASC');
         $team= $commanmodel->all_multiple_query_order_by('team',array(),'team_id','ASC');
        
          $data = array(
       'team' => $team,
        'category' => $category,
      
		);

        
        
         return view('admin/head',$data).view('admin/sidebar').view('admin/team').view('admin/footer');
    }
       public function team_save()
    {
        $session = session();
        $commanmodel = new Commanmodel();
      $category = $commanmodel->all_multiple_query_order_by('category',array('parent_id'=> '0','subparent_id'=> '0'),'menu_order','ASC');
        
        
              $status = $this->request->getVar('status');
         if($status=='Active')
         {
           $status_color = 'success';
         }  
         if($status=='Inactive')
         {
           $status_color = 'danger';
         }
         
           $file = $this->request->getFile('logo');

        // Generate a new secure name
        $logo = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/team', $logo);
        
          $postData = array(
                
                'team_name' => $this->request->getVar('name'),
                'team_logo' => $logo,
               'overview' => $this->request->getVar('overview'),
                'designation' => $this->request->getVar('designation'),
                'team_status' => $status, 
                'team_status_color' => $status_color
                );
             $insertid = $commanmodel->insert_query_get_inserid('team',$postData);
        
        
            $session->setFlashdata('created', 'This team has been Updated successfully!');
                
        return redirect()->to('/admin/team');
    }
    
         public function team_edit($id)
    {
        $session = session();
        $commanmodel = new Commanmodel();
      $category = $commanmodel->all_multiple_query_order_by('category',array('parent_id'=> '0','subparent_id'=> '0'),'menu_order','ASC');
         $team= $commanmodel->get_single_query('team',array('team_id' =>$id));
        
          $data = array(
              'id' => $id,
       'team' => $team,
        'category' => $category,
      
		);

        
        
         return view('admin/head',$data).view('admin/sidebar').view('admin/team_edit').view('admin/footer');
    }
    
          public function team_update($id)
    {
        $session = session();
        $commanmodel = new Commanmodel();
      $category = $commanmodel->all_multiple_query_order_by('category',array('parent_id'=> '0','subparent_id'=> '0'),'menu_order','ASC');
        
        
              $status = $this->request->getVar('status');
         if($status=='Active')
         {
           $status_color = 'success';
         }  
         if($status=='Inactive')
         {
           $status_color = 'danger';
         }
         
         
         
         
         
                $validated = $this->validate([
            'logo' => [
                'label' => 'Image File',
                'rules' => 'uploaded[logo]'
                    . '|is_image[logo]'
                    . '|mime_in[logo,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[logo,100]'
                    . '|max_dims[logo,1024,768]',
            ],
        ]);
 
       
  
        if ($validated) {
          $file = $this->request->getFile('logo');

        // Generate a new secure name
        $logo = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/team', $logo);
        } else {
             $logo = $this->request->getVar('logo_old');
        }
         
         
         
         
         
     
        
          $postData = array(
                    
                'team_name' => $this->request->getVar('name'),
                'team_logo' => $logo,
               'overview' => $this->request->getVar('overview'),
                'designation' => $this->request->getVar('designation'),
                'team_status' => $status, 
                'team_status_color' => $status_color
                );
      
          $where_data = array(
                    'team_id' => $id
                    );
             $insertid = $commanmodel->update_query('team',$postData,$where_data);
        
            $session->setFlashdata('created', 'This team has been Updated successfully!');
                
        return redirect()->to('/admin/team');
    }
    
     public function faq($id)
    {
         $session = session();
        $commanmodel = new Commanmodel();
       
        $data['id'] = $id;
    $data['faqView'] =  $commanmodel->all_multiple_query_order_by('faq',array('type'=> $id),'faq_id','ASC');
        
         return view('admin/head',$data).view('admin/sidebar').view('admin/faq',$data).view('admin/footer');
       
    }


    public function faq_process()
    {
         $session = session();
         $commanmodel = new Commanmodel();
        $data['faqView'] = $commanmodel->get_multiple_query_order_by('faq','faq_id','DESC');
        
        if($this->request->getVar('CreateFaq'))
        {
         $status = $this->request->getVar('faq_status'); 
         if($status=='Active')
         {
           $status_color = 'success';
         }
         if($status=='Inactive')
         {
           $status_color = 'danger';
         }

        $post_data = array(
             'type' => $this->request->getVar('type'),
        'faq_question' => $this->request->getVar('faq_question'),
        'faq_answer' => $this->request->getVar('faq_answer'),
        'faq_status' => $this->request->getVar('faq_status'),
        'faq_status_color' => $status_color
        );
        $inserted = $commanmodel->insert_query('faq',$post_data); 
                   if($inserted)
                   {
                   $session->setFlashdata('created', 'This Faq has been saved.');
                    return redirect()->to(base_url('admin/faq/'.$this->request->getVar('type')));
                    
                   }
                   else
                   {
   $session->setFlashdata('failed', 'Sorry, This faq has not been saved.');  
     return view('admin/head',$data).view('admin/sidebar').view('admin/faq',$data).view('admin/footer');
                   }


            }
        else
        {
       $session->setFlashdata('failed', 'Submit process is not working!');   
        return view('admin/head',$data).view('admin/sidebar').view('admin/faq',$data).view('admin/footer');
        }  

       
    }



    public function delete_faq($faq_id,$id)
    {
         $session = session();
         $commanmodel = new Commanmodel();
     $deleteClient = $commanmodel->delete_query('faq',array('faq_id' =>$faq_id));
     if($deleteClient)
     { 
     $session->setFlashdata('created', 'This Faq is delete.');
      return redirect()->to(base_url('admin/faq/'.$id));
     }
     else
     {
     $session->setFlashdata('failed', 'This faq is not delete!');
      return redirect()->to(base_url('admin/faq/'.$id)); 
     }
    
    }


    public function edit_faq($faq_id)
    {
          $commanmodel = new Commanmodel();
        $data['faqView'] = $commanmodel->get_single_query('faq',array('faq_id' => $faq_id));   
        
       
       return view('admin/head',$data).view('admin/sidebar').view('admin/edit-faq',$data).view('admin/footer');
       
    }

    public function edit_faq_process($faq_id)
    {
         $session = session();
          $commanmodel = new Commanmodel();
$data['faqView'] = $commanmodel->get_single_query('faq',array('faq_id' => $faq_id)); 
        if($this->request->getVar('EditFaq'))
        {
         $status = $this->request->getVar('faq_status'); 
         if($status=='Active')
         {
           $status_color = 'success';
         }
         if($status=='Inactive')
         {
           $status_color = 'danger';
         }
        $post_data = array(
              'type' => $this->request->getVar('type'),
        'faq_question' => $this->request->getVar('faq_question'),
        'faq_answer' => $this->request->getVar('faq_answer'),
        'faq_status' => $this->request->getVar('faq_status'),
        'faq_status_color' => $status_color
        );
        $inserted = $commanmodel->update_query('faq',$post_data,array('faq_id' => $faq_id)); 
                   if($inserted)
                   {
                   $session->setFlashdata('created', 'This Faq has been Updated.');
                    return redirect()->to(base_url('admin/faq/'.$this->request->getVar('type')));
                   }
                   else
                   {
           $session->setFlashdata('failed', 'Sorry, This faq has not been updated.');   
   return view('admin/head',$data).view('admin/sidebar').view('admin/edit-faq',$data).view('admin/footer');
                   }


            }
        else
        {
       $session->setFlashdata('failed', 'Submit process is not working!');   
       return view('admin/head',$data).view('admin/sidebar').view('admin/edit-faq',$data).view('admin/footer');
        }  

       
    }
     public function our_gallery()
    {
         $session = session();
         $commanmodel = new Commanmodel();
        $data['clientView'] = $commanmodel->get_multiple_query_order_by('clients','client_id','DESC');    
   
       
       return view('admin/head',$data).view('admin/sidebar').view('admin/our-gallery').view('admin/footer');
    }

    public function our_gallery_process()
    {
        
 $session = session();
         $commanmodel = new Commanmodel();
        if($this->request->getVar('upload_logo'))
        {

            if($_FILES['client_logo']['name']!=""){
            
                         
                $file = $this->request->getFile('client_logo');

        // Generate a new secure name
        $client_logo = $file->getRandomName();

        // Move the file to the directory
        $file->move('assets/client', $client_logo);
            }
            else{
            $session->setFlashdata('failed', 'Please choose Image');
            $data['clientView'] = $commanmodel->get_multiple_query_order_by('clients','client_id','DESC');    
           return view('admin/head',$data).view('admin/sidebar').view('admin/our-gallery').view('admin/footer');
            }

        $post_data = array(
             'type' => $this->request->getVar('type'),
        'client_image' => $client_logo
        );
        $inserted = $commanmodel->insert_query('clients',$post_data); 
                   if($inserted)
                   {
                    $session->setFlashdata('created', 'This gallery  has been uploaded.');
                
                    
                     return redirect()->to('/admin/our_gallery');
                   }
                   else
                   {
            $session->setFlashdata('failed', 'Sorry, This gallery  has not been uploaded.');
        $data['clientView'] = $commanmodel->get_multiple_query_order_by('clients','client_id','DESC');    

         return view('admin/head',$data).view('admin/sidebar').view('admin/our-gallery').view('admin/footer');
                   }


            }
        else
        {
            $session->setFlashdata('failed', 'Submit process is not working!');
        $data['clientView'] = $commanmodel->get_multiple_query_order_by('clients','client_id','DESC');    
 return view('admin/head',$data).view('admin/sidebar').view('admin/our-gallery').view('admin/footer');
        }  

       
    }



    public function delete_gallery($client_id)
    {
        $session = session();
         $commanmodel = new Commanmodel();
     $deleteClient = $commanmodel->delete_query('clients',array('client_id' =>$client_id));
     if($deleteClient)
     {
      $session->setFlashdata('created', 'This gallery is delete.');
      return redirect()->to('/admin/our_gallery');
     }
     else
     {
      $session->setFlashdata('failed', 'This is not delete!');
       return redirect()->to('/admin/our_gallery');
     }
    
    }
    
     public function attributes()
{
     $session = session();
 
      $commanmodel = new Commanmodel();


        $data['table_name'] = 'attributes';
    
            $table_header = [
                
            ['data' => 'id'],
          ['data' => 'main_attributes'],
            ['data' => 'attributes'],
      
            ['data' => 'action'],
        
        ];
        
        $data['table_column'] = json_encode($table_header);
    
 
   return view('admin/head').view('admin/sidebar').view('admin/attributes', $data).view('admin/footer');

}
  
     public function attributes_list()
{
$session = session();
$commanmodel = new Commanmodel();


// Define your DataTables parameters
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchname = $_POST['searchname']; // Change this to your search input

// Define filters based on your requirements
$filters = [];

// Add search filter if a search term is provided
if (!empty($searchname)) {
$filters[] = [
    'column' => 'attributes_name',
    'value' => $searchname,
    'type' => 'like',
];
}

// Define ordering parameters
$order = null; // Set this based on your DataTables ordering requirements
if (!empty($_POST['order'])) {
$orderColumn = $_POST['order'][0]['column'];
$orderDirection = $_POST['order'][0]['dir'];
// Define the column name you want to order by based on $orderColumn
$order = [
    'column' => 'attributes_id', // Change this to your desired default order column
    'order' => 'DESC', // Change this to your desired default order direction
];
}

// Retrieve data using the getDataFromTable function
$result = $commanmodel->getDataFromTable('attributes', $filters, $order, $length, $start);

// Process the retrieved data
$alldata = $result['filteredRecords'];
$data = [];
$no = $start + 1;
$sn = 1;
foreach ($alldata as $alldata_view) {


$attributes = $commanmodel->get_single_query('attribute_main',array('attribute_main_id'=> $alldata_view->main_id));
$name = $alldata_view->attributes_name;

$action = '<a href="'.base_url().'/admin/edit_attributes/'.$alldata_view->attributes_id .'"  class="btn btn-primary btn-sm " >Edit </a>';


        $status = '';
      
      

$data[] = [
    "id" => $sn,
  'main_attributes' => $attributes->attribute_main_name, 
    "attributes" => $name,
    
 
    "action" => $action 
];

$no++;

$sn++;
}

// Prepare the DataTables response
$response = [
"draw" => intval($draw),
"recordsTotal" => $result['filteredRecordCount'] ,
"recordsFiltered" => $result['totalRecords'],
"data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);

            


}
  public function create_attributes()
    {
        $session = session();
       $commanmodel = new Commanmodel();
        $main = $commanmodel->all_multiple_query_order_by('attribute_main',array(),'attribute_main_id','ASC');
         $data = [
      
         'main'=>$main
        ];
        return view('admin/head').view('admin/sidebar').view('admin/create_attributes',$data).view('admin/footer');
       
    }
  
  
    public function create_attributes_process()
    {
       $session = session();
      
        $commanmodel = new Commanmodel();
        
         $category = $commanmodel->all_multiple_query_order_by('category',array('category_status'=> 'Active'),'category_id','ASC');
         $data = [
      
            'category' => $category
        ];
        
        
        $session = session();
        helper(['form', 'url']);
        $validation =  \Config\Services::validation();
        $rules = [
            'attributes_name' => [
                'label'  => 'Title',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please enter title',
                ],
            ],
           
         
        ];

        if($this->validate($rules))
        {
                  
            
            $status = $this->request->getVar('status');
         if($status=='Active')
         {
           $status_color = 'success';
         }  
         if($status=='Inactive')
         {
           $status_color = 'danger';
         } 
         
         
     
                if($this->request->getVar('main_attributes_id') =='add') { 
                
                 $postDatamain = array(
                   
               
              'attribute_main_name' => $this->request->getVar('main_attributes_name'),
         
                );
                
                  $insertid_main = $commanmodel->insert_query_get_inserid('attribute_main',$postDatamain);
                } else {
                    $insertid_main = $this->request->getVar('main_attributes_id');
                }
     
       
            $postData = array(
                    'main_id' => $insertid_main,  
               
              'attributes_name' => $this->request->getVar('attributes_name'),
               'attributes_symbol' => ($insertid_main ==1)? $this->request->getVar('attributes_color') : '',
            
                     
                
                
                'attributes_status' => $this->request->getVar('status'), 
                'attributes_status_color' => $status_color,
                
                );
                
                  $insertid = $commanmodel->insert_query_get_inserid('attributes',$postData);
                
            
           
             
         


                
                if($insertid) {
                    $session->setFlashdata('created', 'This attributes has been saved successfully!');
                    return redirect()->to('/admin/attributes');
                } else {
                    $session->setFlashdata('failed', 'Sorry, This attributes has not been saved. Please try again?');
                    return redirect()->to('/admin/attributes');
                }

        } else {

            $data["validation"] = $validation->getErrors();

            return view('admin/head').view('admin/sidebar').view('admin/create_attributes',$data).view('admin/footer');
        }
      
    }
  
    public function edit_attributes($id)
    {
        $session = session();
       $commanmodel = new Commanmodel();
       
        $main = $commanmodel->all_multiple_query_order_by('attribute_main',array(),'attribute_main_id','ASC');
     
       
       $attributes = $commanmodel->get_single_query('attributes',array('attributes_id'=> $id));
       $attributes_main = $commanmodel->get_single_query('attribute_main',array('attribute_main_id'=> $attributes->main_id));
       
         $data = [
              'main'=>$main,
      'attributes' => $attributes,
      'attributes_main' => $attributes_main,
           'id' => $id,  
        ];
        return view('admin/head').view('admin/sidebar').view('admin/edit_attributes',$data).view('admin/footer');
       
    }
    
    public function update_attributes_process($id)
    {
       $session = session();
      
        $commanmodel = new Commanmodel();
        
     $main = $commanmodel->all_multiple_query_order_by('attribute_main',array(),'attribute_main_id','ASC');
     
       
       $attributes = $commanmodel->get_single_query('attributes',array('attributes_id'=> $id));
       $attributes_main = $commanmodel->get_single_query('attribute_main',array('attribute_main_id'=> $attributes->main_id));
       
         $data = [
              'main'=>$main,
      'attributes' => $attributes,
      'attributes_main' => $attributes_main,
           'id' => $id,  
        ];
        
        $session = session();
        helper(['form', 'url']);
        $validation =  \Config\Services::validation();
        $rules = [
            'attributes_name' => [
                'label'  => 'Title',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please enter title',
                ],
            ],
          
         
        ];

        if($this->validate($rules))
        {
                  
            
            $status = $this->request->getVar('status');
         if($status=='Active')
         {
           $status_color = 'success';
         }  
         if($status=='Inactive')
         {
           $status_color = 'danger';
         } 
         
         
          
          
          $postData_main = array(
               'attribute_main_name' => $this->request->getVar('main_attributes_name'),
               
                );
                
                $commanmodel->update_query('attribute_main',$postData_main,array('attribute_main_id' => $this->request->getVar('main_attributes_id')));

      
            $postData = array(
               'main_id' => $this->request->getVar('main_attributes_id'),  
               
              'attributes_name' => $this->request->getVar('attributes_name'),
               'attributes_symbol' => ($insertid_main ==1)? $this->request->getVar('attributes_color') : '',
            
                     
                
                
                'attributes_status' => $this->request->getVar('status'), 
                'attributes_status_color' => $status_color,
               
                );
             $insertid =  $commanmodel->update_query('attributes',$postData,array('attributes_id' => $id)); 
             
         

              

                
                if($insertid) {
                    $session->setFlashdata('created', 'This Course has been saved successfully!');
                    return redirect()->to('/admin/attributes');
                } else {
                    $session->setFlashdata('failed', 'Sorry, This Course has not been saved. Please try again?');
                    return redirect()->to('/admin/attributes');
                }

        } else {

            $data["validation"] = $validation->getErrors();

            return view('admin/head').view('admin/sidebar').view('admin/create_attributes',$data).view('admin/footer');
        }
      
    }
    
    
    
      public function enquiry()
{
     $session = session();
 
      $commanmodel = new Commanmodel();


        $data['table_name'] = 'attributes';
    
            $table_header = [
                
            ['data' => 'id'],
          
            ['data' => 'info'],
            ['data' => 'pro'],
            ['data' => 'message'],
      
           
        
        ];
        
        $data['table_column'] = json_encode($table_header);
    
 
   return view('admin/head').view('admin/sidebar').view('admin/enquiry', $data).view('admin/footer');

}
  
     public function enquirylist()
{
$session = session();
$commanmodel = new Commanmodel();


// Define your DataTables parameters
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchname = $_POST['searchname']; // Change this to your search input

// Define filters based on your requirements
$filters = [];



if (session()->get('admin_type')=='Admin') { 
    $filters[] = [
    'column' => 'enquiry_vender',
    'value' => session()->get('id'),
    'type' => 'where',
];
}

// Add search filter if a search term is provided
if (!empty($searchname)) {
$filters[] = [
    'column' => 'enquiry_name',
    'value' => $searchname,
    'type' => 'like',
];
}

// Define ordering parameters
$order = null; // Set this based on your DataTables ordering requirements
if (!empty($_POST['order'])) {
$orderColumn = $_POST['order'][0]['column'];
$orderDirection = $_POST['order'][0]['dir'];
// Define the column name you want to order by based on $orderColumn
$order = [
    'column' => 'enquiry_id', // Change this to your desired default order column
    'order' => 'DESC', // Change this to your desired default order direction
];
}

// Retrieve data using the getDataFromTable function
$result = $commanmodel->getDataFromTable('enquiry', $filters, $order, $length, $start);

// Process the retrieved data
$alldata = $result['filteredRecords'];
$data = [];
$no = $start + 1;
$sn = 1;
foreach ($alldata as $alldata_view) {



$info = 'Name : '.$alldata_view->enquiry_name.'<br>Email : '.$alldata_view->enquiry_email.'<br>Phone : '.$alldata_view->enquiry_phone;



      
      $product = $commanmodel->get_single_query('product',array('product_id'=> $alldata_view->enquiry_pro_id));

$data[] = [
    "id" => $sn,
  
    "info" => $info,
     "pro" => $product->product_name,
     "message" => $alldata_view->enquiry_message,
   
 
  
];

$no++;

$sn++;
}

// Prepare the DataTables response
$response = [
"draw" => intval($draw),
"recordsTotal" => $result['filteredRecordCount'] ,
"recordsFiltered" => $result['totalRecords'],
"data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);

            


}

  public function order()
{
     $session = session();
 
      $commanmodel = new Commanmodel();


        $data['table_name'] = 'attributes';
    
        
            $table_header = [
                
            ['data' => 'id'],
             ['data' => 'img'],
              ['data' => 'item'],
              ['data' => 'category'],
               ['data' => 'price'],
                ['data' => 'seller'],
                 ['data' => 'payment_type'],
                ['data' => 'shipping_address'],
                 ['data' => 'stauts'],
                  ['data' => 'action'],
          
      
           ];
        
        
           $data['referal_code'] = $_GET['referal_code'] ?? '';
       $data['vender_id'] = $_GET['vender_id'] ?? '';
        
        $data['table_column'] = json_encode($table_header);
    
 
   return view('admin/head').view('admin/sidebar').view('admin/order', $data).view('admin/footer');

}


  public function invoice_pdf($id)
{
     $session = session();
 
      $commanmodel = new Commanmodel();
   
       $item = $commanmodel->get_single_query('booking_product',array('booking_product_order_id'=> $id));
        $vender = $commanmodel->get_single_query('admin',array('id'=> $item->booking_product_vender));
     
          $order = $commanmodel->get_single_query('order_book',array('order_book_id'=> $item->booking_product_order_book_id));
       
    
       
         $data = [
              'order'=>$order,
      'item' => $item,
      'vender' => $vender,
     
           'id' => $id,  
        ];
 return view('admin/invoice_pdf', $data);
}

  public function order_details($id)
{
     $session = session();
 
      $commanmodel = new Commanmodel();
   
       $item = $commanmodel->get_single_query('booking_product',array('booking_product_order_id'=> $id));
        $vender = $commanmodel->get_single_query('admin',array('id'=> $item->booking_product_vender));
     
          $order = $commanmodel->get_single_query('order_book',array('order_book_id'=> $item->booking_product_order_book_id));
       
    
       
         $data = [
              'order'=>$order,
      'item' => $item,
      'vender' => $vender,
     
           'id' => $id,  
        ];
 return view('admin/head').view('admin/sidebar').view('admin/order_details', $data).view('admin/footer');
}
  
      public function orderlist()
{
$session = session();
$commanmodel = new Commanmodel();


// Define your DataTables parameters
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchname = $_POST['searchname']; // Change this to your search input

// Define filters based on your requirements
$filters = [];
$arrayfilte = [];
if($session->admin_type == 'Franchise' || $session->admin_type == 'Promoter') {
$filtersrefer = [$session->referral_code];

$mypromoters =  $commanmodel->all_multiple_query_order_by('admin',['refer_by' => $session->referral_code],'id','ASC');


$filtersrefer = array_merge($filtersrefer, array_map(function($p) {
    return $p->referral_code;
}, $mypromoters));
} else {
    $filtersrefer = [];
}



if (session()->get('admin_type')=='Admin' || $_POST['vender_id']) { 
    $filters[] = [
    'column' => 'booking_product_vender',
    'value' => session()->get('id'),
    'type' => 'where',
];
}

// Add search filter if a search term is provided
if (!empty($searchname)) {
$filters[] = [
    'column' => 'booking_product_product_name',
    'value' => $searchname,
    'type' => 'like',
];
}



$arrayfilte[] = [
    'column' => 'booking_product_status',
    'value' => ['success','delivered','cancelled'],
    'type' => 'where',
];




// Define ordering parameters
$order = null; // Set this based on your DataTables ordering requirements
if (!empty($_POST['order'])) {
$orderColumn = $_POST['order'][0]['column'];
$orderDirection = $_POST['order'][0]['dir'];
// Define the column name you want to order by based on $orderColumn
$order = [
    'column' => 'booking_product_id', // Change this to your desired default order column
    'order' => 'DESC', // Change this to your desired default order direction
];
}

// Retrieve data using the getDataFromTable function
$result = $commanmodel->getDataFromTableorder('booking_product', $filters, $order, $length, $start,$filtersrefer,$arrayfilte);

// Process the retrieved data
$alldata = $result['filteredRecords'];
$data = [];
$no = $start + 1;
$sn = 1;
foreach ($alldata as $alldata_view) {


$vender = $commanmodel->get_single_query('admin',array('id'=> $alldata_view->booking_product_vender));


$category = '';
 $order = $commanmodel->get_single_query('order_book',array('order_book_id'=> $alldata_view->booking_product_order_book_id));
  $product = $commanmodel->get_single_query('product',array('product_id'=> $alldata_view->booking_product_product_id));
   $seller = $commanmodel->get_single_query('admin',array('id'=> $alldata_view->booking_product_vender));
  
  if($product) {
      $category = '';
    if (!empty($alldata_view->product_category)) {
        try {
            // Optional: set a timeout if getnamecategory uses HTTP requests (depends on your function)
            $categoryName = $commanmodel->getnamecategory($product->product_category->product_category);
            $category = !empty($categoryName) ? $categoryName : '';
        } catch (\Throwable $e) {
            // Skip this category if it takes too long or errors
            $category = 'N/A';
        }
    }
  }
  
$user = $commanmodel->get_single_query('user_account',array('account_id'=> $order->order_book_user_id));
$images = '<img class="product-img tbl-img" src="'.$alldata_view->booking_product_image.'" >'; 

if($user) {
  $order_type = 'Verifide Order';  
} else {
   $order_type = 'Guest Order';  
}



$action = '<div class="btn-group mb-1">
															<button type="button" class="btn btn-outline-success">'.$order_type.'</button>
															<button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
																<span class="sr-only">Info</span>
															</button>

															<div class="dropdown-menu" style="">
																<a class="dropdown-item" href="'.base_url().'/admin/order_details/'.$alldata_view->booking_product_order_id .'">Order detail</a>
																	<a class="dropdown-item" href="'.base_url().'/admin/invoice_pdf/'.$alldata_view->booking_product_order_id .'">invoice pdf</a>
																	
																		<a class="dropdown-item" href="'.base_url().'/track-xpressbees-shipment/'.$alldata_view->booking_product_order_id .'">Track</a>
																<a class="dropdown-item" href="#">Order Cancel</a>
															</div>
														</div>';

$data[] = [
    "id" => $alldata_view->booking_product_order_id ?? '',
   "img" => $images ?? '',
    "item" => $alldata_view->booking_product_product_name ?? '',
    "category" => $category ?? '',
    "price" =>  $alldata_view->booking_product_price ?? '',

    "seller" => $seller->name ?? '',
    "payment_type" => $order->order_book_pay_type ?? '',
    "shipping_address" => $order->order_shipping_address ?? '',
    "stauts" => '<span class="badge badge-success">'.$alldata_view->booking_product_status.'</span>',
    "action" => $action,
   
   
 
  
];

$no++;

$sn++;
}

// Prepare the DataTables response
$response = [
"draw" => intval($draw),
"recordsTotal" => $result['filteredRecordCount'] ,
"recordsFiltered" => $result['totalRecords'],
"data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);

            


}


      public function customer()
{
     $session = session();
 
      $commanmodel = new Commanmodel();


        $data['table_name'] = 'attributes';
    
            $table_header = [
                
            ['data' => 'id'],
          
            ['data' => 'name'],
             ['data' => 'email'],
              ['data' => 'phone'],
          
             ['data' => 'action'],
           
        
        ];
        
        $data['table_column'] = json_encode($table_header);
    
 
   return view('admin/head').view('admin/sidebar').view('admin/customer', $data).view('admin/footer');

}
  
     public function customerlist()
{
$session = session();
$commanmodel = new Commanmodel();


// Define your DataTables parameters
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchname = $_POST['searchname']; // Change this to your search input
$status = $_POST['status'];

// Define filters based on your requirements
$filters = [];




// Add search filter if a search term is provided
if (!empty($searchname)) {
$filters[] = [
    'column' => 'user_name',
    'value' => $searchname,
    'type' => 'like',
];
}

if (!empty($status)) {
$filters[] = [
    'column' => 'user_status',
    'value' => $status,
    'type' => 'like',
];
}


// Define ordering parameters
$order = null; // Set this based on your DataTables ordering requirements
if (!empty($_POST['order'])) {
$orderColumn = $_POST['order'][0]['column'];
$orderDirection = $_POST['order'][0]['dir'];
// Define the column name you want to order by based on $orderColumn
$order = [
    'column' => 'account_id', // Change this to your desired default order column
    'order' => 'DESC', // Change this to your desired default order direction
];
}

// Retrieve data using the getDataFromTable function
$result = $commanmodel->getDataFromTable('user_account', $filters, $order, $length, $start);

// Process the retrieved data
$alldata = $result['filteredRecords'];
$data = [];
$no = $start + 1;
$sn = 1;
foreach ($alldata as $alldata_view) {





$action = '<div class="btn-group">
															<button type="button"
																class="btn btn-outline-'.$alldata_view->user_status_color.'">'.$alldata_view->user_status.'</button>
														
														
														</div>';
      
   

$data[] = [
    "id" => $sn,
  
    "name" => $alldata_view->user_name,
    "email" => $alldata_view->user_email,
    "phone" => $alldata_view->user_phone,
  "action" => $action,
   
 
  
];

$no++;

$sn++;
}

// Prepare the DataTables response
$response = [
"draw" => intval($draw),
"recordsTotal" => $result['filteredRecordCount'] ,
"recordsFiltered" => $result['totalRecords'],
"data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);

            


}




 public function reviews()
    {$commanmodel = new Commanmodel();
        $session = session();
       if(session()->get('admin_type')=='Supar Admin') {
           
             $data['table_name'] = '';
             
             
         
    
            $table_header = [
                
            ['data' => 'id'],
            ['data' => 'info'],
            ['data' => 'product'],
            ['data' => 'rating'],
            ['data' => 'messages'],
           
            ['data' => 'action'],
        
        ];
        
        $data['table_column'] = json_encode($table_header);
       
       return view('admin/head').view('admin/sidebar').view('admin/reviews',$data).view('admin/footer');
       } else {
            
            return redirect()->back()->withInput();
       }
       
    } 
        public function reviews_list()
{
$session = session();
$commanmodel = new Commanmodel();


// Define your DataTables parameters
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchname = $_POST['searchname']; // Change this to your search input


// Define filters based on your requirements
$filters = [];



// Define ordering parameters
$order = null; // Set this based on your DataTables ordering requirements
if (!empty($_POST['order'])) {
$orderColumn = $_POST['order'][0]['column'];
$orderDirection = $_POST['order'][0]['dir'];
// Define the column name you want to order by based on $orderColumn
$order = [
    'column' => 'reviews_id', // Change this to your desired default order column
    'order' => 'DESC', // Change this to your desired default order direction
];
}

// Retrieve data using the getDataFromTable function
$result = $commanmodel->getDataFromTable('reviews', $filters, $order, $length, $start);

// Process the retrieved data
$alldata = $result['filteredRecords'];
$data = [];
$no = $start + 1;
$sn = 1;
foreach ($alldata as $alldata_view) {

$products = $commanmodel->get_single_query('product',array('product_id'=> $alldata_view->product_id));

if($products) {
   $product = $products->product_name; 
} else {
    $product = '';
}





$action = '<div class="btn-group">
															<button type="button"
																class="btn btn-outline-'.$alldata_view->reviews_status_color.'">'.$alldata_view->reviews_status.'</button>
															<button type="button"
																class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
																data-bs-toggle="dropdown" aria-haspopup="true"
																aria-expanded="false" data-display="static">
																<span class="sr-only">Info</span>
															</button>
															<div class="dropdown-menu">';
															
													if($alldata_view->reviews_status =='Active') {		
										$action .= '<a class="dropdown-item editRecordreviews" href="javascript:void(0);"  data-reviews_id="'.$alldata_view->reviews_id.'" data-status="Inactive" >Inactive</a>';
													} else {
													    $action .= '<a class="dropdown-item editRecordreviews" href="javascript:void(0);"  data-reviews_id="'.$alldata_view->reviews_id.'" data-status="Active"  >Active</a>';
													}
															
														$action .= '	</div>
														</div>';


     

$data[] = [
    "id" => $sn,
    "info" => 'Name : '.$alldata_view->user_name.'<br>Email : '.$alldata_view->user_email.'<br>Date : '.$alldata_view->review_date,
    "product" => $product,
    "rating" => $alldata_view->rating,
    "messages" => $alldata_view->message,
   
    "action" => $action 
];

$no++;

$sn++;
}

// Prepare the DataTables response
$response = [
"draw" => intval($draw),
"recordsTotal" => $result['filteredRecordCount'] ,
"recordsFiltered" => $result['totalRecords'],
"data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);

            


}
    
   function reviews_update(){
             $session = session();
       
             helper(['form', 'url']);
               $commanmodel = new Commanmodel();
         $status = $this->request->getVar('status');
         if($status=='Active')
         {
           $status_color = 'success';
         }  
         if($status=='Inactive')
         {
           $status_color = 'danger';
         } 
         
       
        $data = array(  
    
      
        'reviews_status' => $this->request->getVar('status'), 
        'reviews_status_color' => $status_color,
    
       
        );
        $where = array(             
        'reviews_id' => $this->request->getVar('reviews_id')
            );
        $updated=$commanmodel->update_query('reviews',$data,$where);
        echo json_encode($updated);
     
    }  
    
    
  public function transactions($id=null)
    { 
        $commanmodel = new Commanmodel();
        $session = session();
       if(session()->get('admin_type')=='Supar Admin') {
           
             $data['table_name'] = '';
             
               $data['id'] = $id;
    
    
            $table_header = [
                
            ['data' => 'id'],
            ['data' => 'customer_name'],
            ['data' => 'seller_name'],
            ['data' => 'date'],
          
            ['data' => 'amount'],
           
            ['data' => 'method'],
        
        ];
        
        $data['table_column'] = json_encode($table_header);
       
       return view('admin/head').view('admin/sidebar').view('admin/transactions',$data).view('admin/footer');
       } else {
            
            return redirect()->back()->withInput();
       }
       
    } 
        public function transactions_list()
{
$session = session();
$commanmodel = new Commanmodel();


// Define your DataTables parameters
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchname = $_POST['searchname']; // Change this to your search input

$id = $_POST['id'];

// Define filters based on your requirements
$filters = [];

$order = null; // Set this based on your DataTables ordering requirements
if (!empty($id)) {
    
    $filters[] = [
    'column' => 'booking_product_vender',
    'value' => $id,
    'type' => 'like',
];
   
} 



// Define ordering parameters
$order = null; // Set this based on your DataTables ordering requirements
if (!empty($_POST['order'])) {
$orderColumn = $_POST['order'][0]['column'];
$orderDirection = $_POST['order'][0]['dir'];
// Define the column name you want to order by based on $orderColumn
$order = [
    'column' => 'booking_product_id', // Change this to your desired default order column
    'order' => 'DESC', // Change this to your desired default order direction
];
}

// Retrieve data using the getDataFromTable function
$result = $commanmodel->getDataFromTable('booking_product', $filters, $order, $length, $start);

// Process the retrieved data
$alldata = $result['filteredRecords'];
$data = [];
$no = $start + 1;
$sn = 1;
$costAmount = 0;
$totalAmount = 0;

foreach ($alldata as $alldata_view) {


$order = $commanmodel->get_single_query('order_book',array('order_book_id'=> $alldata_view->booking_product_order_book_id));

if($order) {

$admin = $commanmodel->get_single_query('admin',array('id'=> $alldata_view->booking_product_vender));

$product = $commanmodel->get_single_query('product',array('product_id'=> $alldata_view->booking_product_product_id));




$totalAmount +=  $alldata_view->booking_product_sub_total;

$data[] = [
    "id" => $sn,
    "customer_name" =>$order->order_book_user_name,
    "seller_name" => $admin->name,
    "date" => $order->order_book_date,
    
 
     "amount" => $alldata_view->booking_product_sub_total,
    "method" => $order->order_book_pay_type,
   
];

$no++;

$sn++;
 
}
}

$data[] = [
    "id" => '',
    "customer_name" =>'',
    "seller_name" =>'',
    "date" => 'Total',
     
 
     "amount" => $totalAmount,
    "method" => '',
   
];

// Prepare the DataTables response
$response = [
"draw" => intval($draw),
"recordsTotal" => $result['filteredRecordCount'] ,
"recordsFiltered" => $result['totalRecords'],
"data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);

            


}

   public function shipcharge()
    {$commanmodel = new Commanmodel();
        $session = session();
       if(session()->get('admin_type')=='Supar Admin') {
           
             $data['table_name'] = '';
             
             
         
    
            $table_header = [
                
            ['data' => 'id'],
        
            ['data' => 'shipcharge'],
            ['data' => 'pin'],
           
            ['data' => 'action'],
        
        ];
        
        $data['table_column'] = json_encode($table_header);
       
       return view('admin/head').view('admin/sidebar').view('admin/shipcharge',$data).view('admin/footer');
       } else {
            
            return redirect()->back()->withInput();
       }
       
    } 
        public function shipcharge_list()
{
$session = session();
$commanmodel = new Commanmodel();


// Define your DataTables parameters
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchname = $_POST['searchname']; // Change this to your search input


// Define filters based on your requirements
$filters = [];

// Add search filter if a search term is provided
// if (!empty($searchname)) {
// $filters[] = [
//     'column' => 'product_title',
//     'value' => $searchname,
//     'type' => 'like',
// ];
// }






// if (session()->get('admin_type')=='Admin') { 
//     $filters[] = [
//     'column' => 'product_create_by',
//     'value' => session()->get('id'),
//     'type' => 'where',
// ];
// }

// Define ordering parameters
$order = null; // Set this based on your DataTables ordering requirements
if (!empty($_POST['order'])) {
$orderColumn = $_POST['order'][0]['column'];
$orderDirection = $_POST['order'][0]['dir'];
// Define the column name you want to order by based on $orderColumn
$order = [
    'column' => 'shipcharge_id', // Change this to your desired default order column
    'order' => 'DESC', // Change this to your desired default order direction
];
}

// Retrieve data using the getDataFromTable function
$result = $commanmodel->getDataFromTable('shipcharge', $filters, $order, $length, $start);

// Process the retrieved data
$alldata = $result['filteredRecords'];
$data = [];
$no = $start + 1;
$sn = 1;
foreach ($alldata as $alldata_view) {




$action = '<div class="btn-group">
															<button type="button"
																class="btn btn-outline-'.$alldata_view->shipcharge_status_color.'">'.$alldata_view->shipcharge_status.'</button>
															<button type="button"
																class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
																data-bs-toggle="dropdown" aria-haspopup="true"
																aria-expanded="false" data-display="static">
																<span class="sr-only">Info</span>
															</button>
															<div class="dropdown-menu">
																<a class="dropdown-item editRecordshipcharge" href="javascript:void(0);"  data-shipcharge_id="'.$alldata_view->shipcharge_id.'" data-shipcharge="'.$alldata_view->shipcharge.'" data-shipcharge_pin="'.$alldata_view->shipcharge_pin.'" data-shipcharge_status="'.$alldata_view->shipcharge_status.'" >Edit</a>
																<a class="dropdown-item" href="#">Delete</a>
															</div>
														</div>';


      

$data[] = [
    "id" => $sn,
   
    "shipcharge" => $alldata_view->shipcharge,
    "pin" => $alldata_view->shipcharge_pin,
   
    "action" => $action 
];

$no++;

$sn++;
}

// Prepare the DataTables response
$response = [
"draw" => intval($draw),
"recordsTotal" => $result['filteredRecordCount'] ,
"recordsFiltered" => $result['totalRecords'],
"data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);

            


}
    
    
    
        function shipcharge_save(){
           $session = session();
      
             $commanmodel = new Commanmodel();
         $status = $this->request->getVar('shipcharge_status');
         if($status=='Active')
         {
           $status_color = 'success';
         }  
         if($status=='Inactive')
         {
           $status_color = 'danger';
         }
         
        
        
      
    
        $data = array( 
        
        'shipcharge' => $this->request->getVar('shipcharge'), 
         'shipcharge_pin' => $this->request->getVar('shipcharge_pin'), 
         
        'shipcharge_status' => $this->request->getVar('shipcharge_status'), 
        'shipcharge_status_color' => $status_color,
      
       
            );
        $Inserted=$commanmodel->insert_query('shipcharge',$data);
        echo json_encode($Inserted);
     
    }
        function shipcharge_update(){
             $session = session();
       
             helper(['form', 'url']);
               $commanmodel = new Commanmodel();
         $status = $this->request->getVar('edit_shipcharge_status');
         if($status=='Active')
         {
           $status_color = 'success';
         }  
         if($status=='Inactive')
         {
           $status_color = 'danger';
         } 
         
         
             


        $data = array(  
             
        'shipcharge' => $this->request->getVar('edit_shipcharge'), 
       'shipcharge_pin' => $this->request->getVar('edit_shipcharge_pin'), 
        'shipcharge_status' => $this->request->getVar('edit_shipcharge_status'), 
        'shipcharge_status_color' => $status_color,
     
       
        );
        $where = array(             
        'shipcharge_id' => $this->request->getVar('edit_shipcharge_id')
            );
        $updated=$commanmodel->update_query('shipcharge',$data,$where);
        echo json_encode($updated);
     
    }
    




public function create_shiprocket($item_id) 
{
    $session = session();
    $commanmodel = new Commanmodel();

    /*
    |--------------------------------------------------------------------------
    | PRODUCT DETAILS
    |--------------------------------------------------------------------------
    */

    $itemdetails = $commanmodel->get_single_query(
        'booking_product',
        [
            'booking_product_id' => $item_id
        ]
    );
    
       if (!$itemdetails) {

        $session->setFlashdata('failed', 'Order not found');

        return redirect()->back();
    }
    
     $vender = $commanmodel->get_single_query(
        'admin',
        [
            'id' => $itemdetails->booking_product_vender
        ]
    );
    
    
    if (
    empty($vender) ||
    empty($vender->warehouse_primary_name) ||
    empty($vender->warehouse_name) ||
    empty($vender->warehouse_address) ||
    empty($vender->warehouse_city) ||
    empty($vender->warehouse_state) ||
    empty($vender->warehouse_pincode) ||
    empty($vender->warehouse_phone)
) {

    $session->setFlashdata(
        'failed',
        'Vendor warehouse details are incomplete. Please update warehouse details first.'
    );

    return redirect()->to(
        base_url(
            'admin/order_details/' .
            $itemdetails->booking_product_order_id
        )
    );
}

 

    /*
    |--------------------------------------------------------------------------
    | ORDER DETAILS
    |--------------------------------------------------------------------------
    */

    $order_book = $commanmodel->get_single_query(
        'order_book',
        [
            'order_book_id' => $itemdetails->booking_product_order_book_id
        ]
    );

    if (!$order_book) {

        $session->setFlashdata('failed', 'Customer details not found');

        return redirect()->back();
    }

    /*
    |--------------------------------------------------------------------------
    | ALL ORDER PRODUCTS
    |--------------------------------------------------------------------------
    */

    $orderdetails = $commanmodel->all_multiple_query_order_by(
        'booking_product',
        [
            'booking_product_order_book_id' => $itemdetails->booking_product_order_book_id
        ],
        'booking_product_id',
        'ASC'
    );

    if (!$orderdetails) {

        $session->setFlashdata('failed', 'Products not found');

        return redirect()->back();
    }

    /*
    |--------------------------------------------------------------------------
    | XPRESSBEES LOGIN
    |--------------------------------------------------------------------------
    */

    $login_url = "https://shipment.xpressbees.com/api/users/login";

    $login_payload = [
        "email"    => "wansaapls@gmail.com",
        "password" => "9650997687"
    ];

    $login_ch = curl_init();

    curl_setopt_array($login_ch, [

        CURLOPT_URL => $login_url,

        CURLOPT_POST => true,

        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_POSTFIELDS => json_encode($login_payload),

        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json'
        ]
    ]);

    $login_response = curl_exec($login_ch);

    if (curl_errno($login_ch)) {

        $session->setFlashdata(
            'failed',
            curl_error($login_ch)
        );

        curl_close($login_ch);

        return redirect()->back();
    }

    curl_close($login_ch);

    $login_result = json_decode($login_response, true);

    if (
        !isset($login_result['status']) ||
        $login_result['status'] != true
    ) {

        $session->setFlashdata(
            'failed',
            $login_result['message'] ?? 'Xpressbees Login Failed'
        );

        return redirect()->back();
    }

    $token = $login_result['data'];

    /*
    |--------------------------------------------------------------------------
    | PREPARE ITEMS
    |--------------------------------------------------------------------------
    */

    $order_items = [];
    $sub_total = 0;

    foreach ($orderdetails as $row) {

        $product = $commanmodel->get_single_query(
            'product',
            [
                'product_id' => $row->booking_product_product_id
            ]
        );

        if (!$product) {
            continue;
        }

        $order_items[] = [

            "name"  => $product->product_name,

            "qty"   => (string)$row->booking_product_quantity,

            "price" => (string)$row->booking_product_price,

            "sku"   => !empty($product->sku)
                ? $product->sku
                : "SKU" . $product->product_id
        ];

        $sub_total += (
            $row->booking_product_price *
            $row->booking_product_quantity
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PAYMENT TYPE
    |--------------------------------------------------------------------------
    */

    $payment_type = (
        strtoupper($order_book->order_book_pay_type) == 'COD'
    ) ? 'cod' : 'prepaid';
    
    
    $phone = preg_replace('/\D/', '', $order_book->order_shipping_phone);

if (substr($phone, 0, 2) == '91' && strlen($phone) > 10) {
    $phone = substr($phone, 2);
}

if (substr($phone, 0, 1) == '0' && strlen($phone) > 10) {
    $phone = ltrim($phone, '0');
}

$phone = substr($phone, -10);

    /*
    |--------------------------------------------------------------------------
    | SHIPMENT DATA
    |--------------------------------------------------------------------------
    */

    $shipment_data = [

        "order_number" => $itemdetails->booking_product_order_id,

        "unique_order_number" => "yes",

        "shipping_charges" => 0,

        "discount" => 0,

        "cod_charges" => 0,

        "payment_type" => $payment_type,

        "order_amount" => $sub_total,

        "package_weight" => (float)$this->request->getPost('weight'),

        "package_length" => (float)$this->request->getPost('length'),

        "package_breadth" => (float)$this->request->getPost('width'),

        "package_height" => (float)$this->request->getPost('height'),

        "request_auto_pickup" => "yes",

        "consignee" => [

            "name" => $order_book->order_shipping_user_name,

            "address" => $order_book->order_shipping_address,

            "address_2" => "",

            "city" => $order_book->order_shipping_city,

            "state" => $order_book->order_shipping_state,

            "pincode" => (string)$order_book->order_shipping_pin_no,

            "phone" => $phone
        ],

        "pickup" => [

            /*
            --------------------------------------------------------------
            XPRESSBEES PANEL WAREHOUSE DETAILS
            --------------------------------------------------------------
            */

            "warehouse_name" => $vender->warehouse_primary_name,

            "name" => $vender->warehouse_name,

            "address" => $vender->warehouse_address,

            "address_2" => $vender->warehouse_address_2,

            "city" => $vender->warehouse_city,

            "state" => $vender->warehouse_state,

            "pincode" => $vender->warehouse_pincode,

            "phone" => $vender->warehouse_phone,
        ],

        "order_items" => $order_items,

        "courier_id" => "",

        "collectable_amount" => (
            $payment_type == 'cod'
        ) ? $sub_total : 0
    ];

    /*
    |--------------------------------------------------------------------------
    | CREATE SHIPMENT
    |--------------------------------------------------------------------------
    */

    $shipment_url = "https://shipment.xpressbees.com/api/shipments2";

    $ch = curl_init();

    curl_setopt_array($ch, [

        CURLOPT_URL => $shipment_url,

        CURLOPT_POST => true,

        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_POSTFIELDS => json_encode($shipment_data),

        CURLOPT_HTTPHEADER => [

            'Content-Type: application/json',

            'Authorization: Bearer ' . $token
        ]
    ]);

    $result = curl_exec($ch);

    if (curl_errno($ch)) {

        $session->setFlashdata(
            'failed',
            curl_error($ch)
        );

        curl_close($ch);

        return redirect()->back();
    }

    curl_close($ch);

    $response = json_decode($result, true);
    


    /*
    |--------------------------------------------------------------------------
    | SUCCESS
    |--------------------------------------------------------------------------
    */

    if (
        isset($response['status']) &&
        $response['status'] == true
    ) {

        $awb = $response['data']['awb_number'] ?? '';

        $update_data = [

            'ship_order_id' => $itemdetails->booking_product_order_id,

            'ship_shipment_id' => $awb,

            'channel_order_id' => $awb,

            'ship_status' => $response['data']['status'] ?? 'Created',

            'ship_status_code' => 1
        ];

        $commanmodel->update_query(
            'booking_product',
            $update_data,
            [
                'booking_product_id' => $item_id
            ]
        );

        $session->setFlashdata(
            'created',
            'Xpressbees Shipment Created Successfully'
        );
    }
    else {

        $session->setFlashdata(
            'failed',
            $response['message'] ?? 'Shipment Create Failed'
        );
    }

    return redirect()->to(
        base_url(
            'admin/order_details/' .
            $itemdetails->booking_product_order_id
        )
    );
}


public function track_xpressbees_shipment($booking_product_id)
{
    $session = session();
    $commanmodel = new Commanmodel();

    /*
    |--------------------------------------------------------------------------
    | GET SHIPMENT DETAILS
    |--------------------------------------------------------------------------
    */

    $shipment = $commanmodel->get_single_query(
        'booking_product',
        [
            'booking_product_order_id' => $booking_product_id
        ]
    );

    if (
        !$shipment ||
        empty($shipment->ship_shipment_id)
    ) {

        $session->setFlashdata(
            'failed',
            'AWB Number not found.'
        );

        return redirect()->back();
    }

    /*
    |--------------------------------------------------------------------------
    | XPRESSBEES LOGIN
    |--------------------------------------------------------------------------
    */

    $login_url = "https://shipment.xpressbees.com/api/users/login";

    $login_payload = [
        "email"    => "wansaapls@gmail.com",
        "password" => "9650997687"
    ];

    $login_ch = curl_init();

    curl_setopt_array($login_ch, [

        CURLOPT_URL => $login_url,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => json_encode($login_payload),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json'
        ]
    ]);

    $login_response = curl_exec($login_ch);

    if (curl_errno($login_ch)) {

        $session->setFlashdata(
            'failed',
            curl_error($login_ch)
        );

        curl_close($login_ch);

        return redirect()->back();
    }

    curl_close($login_ch);

    $login_result = json_decode($login_response, true);

    if (
        !isset($login_result['status']) ||
        $login_result['status'] != true
    ) {

        $session->setFlashdata(
            'failed',
            $login_result['message'] ?? 'Login Failed'
        );

        return redirect()->back();
    }

    $token = $login_result['data'];

    /*
    |--------------------------------------------------------------------------
    | TRACK SHIPMENT
    |--------------------------------------------------------------------------
    */

    $awb = trim($shipment->ship_shipment_id);

    $track_url = "https://shipment.xpressbees.com/api/shipments2/track/" . $awb;

    $ch = curl_init();

    curl_setopt_array($ch, [

        CURLOPT_URL => $track_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [

            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]
    ]);

    $result = curl_exec($ch);

    if (curl_errno($ch)) {

        $session->setFlashdata(
            'failed',
            curl_error($ch)
        );

        curl_close($ch);

        return redirect()->back();
    }

    curl_close($ch);

    $response = json_decode($result, true);

    /*
    |--------------------------------------------------------------------------
    | TRACKING SUCCESS
    |--------------------------------------------------------------------------
    */

    if (
        isset($response['status']) &&
        $response['status'] == true
    ) {

        $status = $response['data']['status'] ?? '';

        $history = json_encode(
            $response['data']['history'] ?? []
        );

        /*
        |--------------------------------------------------------------------------
        | UPDATE DATABASE
        |--------------------------------------------------------------------------
        */

        $commanmodel->update_query(
            'booking_product',
            [
                'ship_status' => $status,
                'ship_track_response' => $history
            ],
            [
                'booking_product_order_id' => $booking_product_id
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | SHOW TRACKING PAGE
        |--------------------------------------------------------------------------
        */

        $data['tracking'] = $response['data'];

        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Shipment Tracking</title>

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

            <style>

                body{
                    background:#f5f5f5;
                }

                .timeline{
                    border-left:3px solid #0d6efd;
                    padding-left:20px;
                    margin-left:10px;
                }

                .timeline-item{
                    margin-bottom:20px;
                    position:relative;
                }

                .timeline-item:before{
                    content:"";
                    width:14px;
                    height:14px;
                    background:#0d6efd;
                    border-radius:50%;
                    position:absolute;
                    left:-28px;
                    top:5px;
                }

            </style>

        </head>

        <body>

        <div class="container mt-4">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Shipment Tracking</h4>
                </div>

                <div class="card-body">

                    <table class="table table-bordered">

                        <tr>
                            <th width="200">AWB Number</th>
                            <td>'.$response['data']['awb_number'].'</td>
                        </tr>

                        <tr>
                            <th>Order Number</th>
                            <td>'.$response['data']['order_number'].'</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-success">'
                                    .ucfirst($response['data']['status']).
                                '</span>
                            </td>
                        </tr>

                        <tr>
                            <th>Created</th>
                            <td>'.$response['data']['created'].'</td>
                        </tr>

                    </table>

                    <h5 class="mt-4 mb-3">
                        Tracking History
                    </h5>

                    <div class="timeline">';
                    
                        foreach($response['data']['history'] as $row){

                            echo '

                            <div class="timeline-item">

                                <h6>'.$row['message'].'</h6>

                                <small class="text-muted">
                                    '.$row['event_time'].'
                                </small>

                                <br>

                                <span class="badge bg-secondary">
                                    '.$row['status_code'].'
                                </span>

                                <p class="mt-2">
                                    '.$row['location'].'
                                </p>

                            </div>

                            ';
                        }

                    echo '

                    </div>

                </div>

            </div>

        </div>

        </body>
        </html>';

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | FAILED
    |--------------------------------------------------------------------------
    */

    $session->setFlashdata(
        'failed',
        $response['message'] ?? 'Tracking Failed'
    );

    return redirect()->back();
}
  
public function create_shiprocket2($item_id)
{
     $commanmodel = new Commanmodel();
    // Fetch order and user details
    $itemdetails =$commanmodel->get_single_query('booking_product', array('booking_product_order_id' => $item_id));
    if (!$itemdetails) {
        
        redirect('admin/order_details/' . $item_id);
        return;
    }


    $order_book =$commanmodel->get_single_query('order_book', array('order_book_id' => $itemdetails->user_id));
  

   

    // Get the Shiprocket API token
    $token =$commanmodel->shiprockt_api_token();
    if (!$token) {
        $this->session->set_flashdata('failed', 'Failed to retrieve Shiprocket API token');
        redirect('admin/order_details/' . $item_id);
        return;
    }

    // Build the array of products
    $shipProduct = [];
    $sub_total = 0;

    foreach ($orderdetails as $productdetailsrow) {
        $productdetails =$commanmodel->get_single_query('product', array('product_id' => $productdetailsrow->product_id));

        if ($productdetails) {
            $shipProduct[] = [
                "name" => $productdetails->product_name,
                "sku" => $productdetails->product_code,
                "units" => $productdetailsrow->qty,
                "selling_price" => $productdetailsrow->price,
                "discount" => 0,
                "tax" => 0
            ];

            $sub_total += $productdetailsrow->price;
        }
    }

    // Define the payment mode
    $payment_mode = ($itemdetails->payment_type == 'COD') ? 'COD' : 'Prepaid';

    // Shiprocket API URL
   $url = "https://apiv2.shiprocket.in/v1/external/orders/create/adhoc?token=$token";


    // Prepare the data payload
    $data = [
        "order_id" => $item_id,
        "order_date" => $order_book->order_book_date,
        "pickup_location" => 'Primary',
        "billing_customer_name" => $order_book->order_book_user_name,
        "billing_last_name" => '',
        "billing_address" => $order_book->order_book_address,
        "billing_city" => $order_book->order_book_city,
        "billing_pincode" => $order_book->order_book_pin_no,
        "billing_state" => $order_book->order_book_state,
        "billing_country" => 'India',
        "billing_email" => $order_book->order_book_email,
        "billing_phone" => $order_book->order_book_phone,
        "shipping_is_billing" => true,
        "shipping_customer_name" => $order_book->order_shipping_user_name,
        "shipping_last_name" => '',
        "shipping_address" => $order_book->order_shipping_address,
        "shipping_city" => $order_book->order_shipping_city,
        "shipping_pincode" => $order_book->order_shipping_pin_no,
        "shipping_country" => 'India',
        "shipping_state" => $order_book->order_shipping_state,
        "shipping_email" => $order_book->order_shipping_email,
        "shipping_phone" => $order_book->order_shipping_phone,
        "order_items" => $shipProduct,
        "payment_method" => $payment_mode,
        "sub_total" => $sub_total,
       
        'length' =>$this->input->post('length'),
        'breadth' =>$this->input->post('width'),
        'height' =>$this->input->post('height'),
        'weight' =>$this->input->post('weight'),
    ];

    // Debugging output: print the data being sent to the API
    

    // Send the request to Shiprocket API
   	$postdata = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    
        
    $result = curl_exec($ch);

    // Check for cURL errors
    if ($result === false) {
        $error = curl_error($ch);
        curl_close($ch);
        echo "cURL Error: $error";  // Display any cURL error
        return;
    }

    curl_close($ch);

    // Decode the API response
    $response = json_decode($result, TRUE);

    // Debugging output: print the response received from the API
  

    // Handle the response
    if (isset($response['status']) && $response['status_code'] == 1) {
        $post_data = [
            'ship_order_id' => $response['order_id'],
            'ship_shipment_id' => $response['shipment_id'],
            'channel_order_id' => $response['channel_order_id'],
            'ship_status' => $response['status'],
            'ship_status_code' => $response['status_code']
        ];
        $update_by = ['booking_product_order_id' => $item_id];
       $commanmodel->update_query('booking_product', $post_data, $update_by);
  $session->setFlashdata('created', 'Shipment id has been generated');

    } else {
        $this->session->set_flashdata('failed', $response['message'] ?? 'Unknown error');
       
         $session->setFlashdata('failed', $response['message'] ?? 'Unknown error');
    }

    // Redirect to the relevant page
    redirect('admin/order_details/' . $item_id);
}


}