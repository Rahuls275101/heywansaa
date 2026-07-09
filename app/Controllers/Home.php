<?php

namespace App\Controllers;
use App\Models\Commanmodel;
use App\Models\Blogmodel;
use App\Models\Ajaxlist;
use App\Libraries\Cart;
use CodeIgniter\Email\Email;
use CodeIgniter\I18n\Time;
use Config\Services;

class Home extends BaseController
{
    public function index()
    { 
    /*   $cart = new \App\Libraries\Cart();
        
       $datcart = $cart->contents();
       
       print_r($datcart);
       */
        $commanmodel = new Commanmodel();
        $newblog = $commanmodel->all_multiple_query_order_by_limit('blogs',array('blog_status' => 'Active'),'blog_id','ASC',4); 
         $productfirst = $commanmodel->all_multiple_query_order_by_limit_with_like('product',array('product_status' => 'Active'),array('product_collections' => '1'),'product_id','DESC',10); 
         
        
         $productsecond = $commanmodel->all_multiple_query_order_by_limit_with_like('product',array('product_status' => 'Active'),array('product_collections' => '2'),'product_id','DESC',10); 
         $productthird = $commanmodel->all_multiple_query_order_by_limit_with_like('product',array('product_status' => 'Active'),array('product_collections' => '3'),'product_id','DESC',10); 
         
         
        
         $data = array(
         
            'search' => '',
           'productfirst' => $productfirst,
           'productsecond' => $productsecond,
             'productthird' => $productthird,
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
        
            );
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 1));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_title);
            
            
             $data['bannerView'] = $commanmodel->get_multiple_query_order_by('home_banner','banner_id','DESC'); 
         return view('frontend/header',$data).view('frontend/index').view('frontend/footer');
    }
    
    
    
      public function about_us()
    {
        
         $commanmodel = new Commanmodel();
         $data = array(
           
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
           
            );
            
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 2));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_title);
         return view('frontend/header',$data).view('frontend/about_us').view('frontend/footer');
    }
    
       public function blog()
    { $commanmodel = new Commanmodel();
        $newblog = $commanmodel->all_multiple_query_order_by_limit('blogs',array('blog_status' => 'Active'),'blog_id','ASC',4); 
         $data = array(
          
            'search' => '',
          'newblog' => $newblog,
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
           
            );
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 4));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_title);
         return view('frontend/header',$data).view('frontend/blog').view('frontend/footer');
    }
    
      public function blog_detail($slug)
    {
        $commanmodel = new Commanmodel();
        $blogs = $commanmodel->get_single_query('blogs',array('url_slug'=> $slug));
     $newblog = $commanmodel->all_multiple_query_order_by_limit('blogs',array('blog_status' => 'Active'),'blog_id','ASC',4); 
         $data = array(
             'blogs' => $blogs, 
            'newblog' => $newblog,
            'title' => $blogs->meta_title." : Rent House", 
            'keyword' =>  $blogs->meta_keyword,
            'description' =>  $blogs->meta_description,
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            'pageimage' => base_url('assets/frontend/assets/img/logo.png')
            );
         return view('frontend/header',$data).view('frontend/blog_detail').view('frontend/footer');
    } 
    
       public function contact_us()
    {
         $commanmodel = new Commanmodel();
         $data = array(
           
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
           
            );
            
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 3));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_title);
               
         return view('frontend/header',$data).view('frontend/contact_us').view('frontend/footer');
    }
    
      public function catalog($slug)
    {
        $commanmodel = new Commanmodel();
        
        
        
        $category = $commanmodel->get_single_query('category',array('url_slug'=> $slug));
        
        
        if($category) {
            $id = $category->category_id; 
        } else {
            $id = '';
        }
        
           $session = session();
        $commanmodel = new Commanmodel();
         $data = array(
          
            'search' => '',
             'catsearch' => '',
             'collection' => '',
           'id' => $id,
            'url' => $slug,
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            
            );
            
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 5));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_title);
             
         return view('frontend/header',$data).view('frontend/catalog',$data).view('frontend/footer');
    }
    
        public function search()
    {
        $commanmodel = new Commanmodel();
        
      
        
           $session = session();
        $commanmodel = new Commanmodel();
         $data = array(
           
            'search' => $this->request->getVar('search'),
   'catsearch' => $this->request->getVar('category'),
           'id' => '',
            'url' => 'search',
             'collection' => '',
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
           
            );
            
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 6));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_title);
            
             
         return view('frontend/header',$data).view('frontend/catalog',$data).view('frontend/footer');
    }
    
      public function collection($slug)
    {
        $commanmodel = new Commanmodel();
        
       $collections = $commanmodel->get_single_query('collections',array('url_slug'=> $slug));
        
           $session = session();
        $commanmodel = new Commanmodel();
         $data = array(
           
            'search' => '',
            'catsearch' => '',
           'id' => '',
           'collection' => $collections->collections_id,
            'url' => 'search',
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
          
            );
            
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 5));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_title);
             
         return view('frontend/header',$data).view('frontend/catalog',$data).view('frontend/footer');
    }
     public function ajax_list($page)
{
    

    $id=  $this->request->getVar('id');
 $url=  $this->request->getVar('list');
$search=  $this->request->getVar('search');
$catsearch=  $this->request->getVar('catsearch');

$collection=  $this->request->getVar('collection');
$minprice=  $this->request->getVar('minprice');
$maxprice=  $this->request->getVar('maxprice');
$shortby=  $this->request->getVar('shortby');
   
$Travellmodel = new Ajaxlist($id);

 $pager = service('pager');

$perPage = 12;
$total = $Travellmodel->count_all_frontend($id,$search,$collection,$minprice,$maxprice,$shortby,$catsearch);
$segment = $this->request->uri->getSegment(2);

// Set the base URL and segment for pagination links.
$pager->setPath(base_url($url), $segment);

// Generate pagination links using the makeLinks() method.
$pager_links = $pager->makeLinks($page, $perPage, $total, 'foundation_full');

$start = ($page - 1) * $perPage;

$output = [
    'item_total' => 'Showing '.$total.' total results',
    'pagination_link' => $pager_links,
    'product_list' => $Travellmodel->fetch_data($perPage, $start,$id,$search,$collection,$minprice,$maxprice,$shortby,$catsearch)
];

echo json_encode($output);


}
     public function product_details($slug)
    {
        $commanmodel = new Commanmodel();
        $product = $commanmodel->get_single_query('product',array('slug'=> $slug));
        
         $data = array(
             'product' => $product, 
             
            'title' => $product->product_meta_title, 
            'keyword' =>  $product->product_meta_keyword,
            'description' =>  $product->product_meta_description,
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            'pageimage' => base_url('assets/frontend/assets/img/logo.png')
            );
         return view('frontend/header',$data).view('frontend/product_details').view('frontend/footer');
    } 
    
    
     public function register()
    {
        $commanmodel = new Commanmodel();
       
        
         $data = array(
             
             
           
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            
            );
            
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 7));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_title);
         return view('frontend/header',$data).view('frontend/register').view('frontend/footer');
    }
    
       public function login()
    {
        $commanmodel = new Commanmodel();
       
        
         $data = array(
         
             
          
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            
            );
            
               $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 8));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_title);
               
         return view('frontend/header',$data).view('frontend/login').view('frontend/footer');
    }
    
     public function register_process()
{
    $session = session();
    $commanmodel = new Commanmodel();
    helper(['form', 'url']);
    $validation = \Config\Services::validation();

    if ($this->request->getVar('new_register') == "Newregister") {

        $rules = [
            'name_register' => [
                'label' => 'First Name',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please enter First Name',
                ],
            ],
            'phone_register' => [
                'label' => 'Phone Number',
                'rules' => 'required|min_length[10]|max_length[10]|is_unique[user_account.user_phone]',
                'errors' => [
                    'required' => 'Please enter phone number',
                    'min_length' => 'Phone number must be 10 digits!',
                    'max_length' => 'Phone number must be 10 digits!',
                    'is_unique' => 'This phone number already exists!',
                ],
            ],
            'email_register' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_unique[user_account.user_email]',
                'errors' => [
                    'required' => 'Please enter email',
                    'valid_email' => 'Please enter a valid email address',
                    'is_unique' => 'This email address already exists!',
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[8]|max_length[16]|matches[confirm_password]',
                'errors' => [
                    'required' => 'Please enter password',
                    'min_length' => 'Password must be at least 8 characters!',
                    'max_length' => 'Password must not exceed 16 characters!',
                    'matches' => 'Password and confirm password do not match!',
                ],
            ],
            'confirm_password' => [
                'label' => 'Confirm Password',
                'rules' => 'required|min_length[8]|max_length[16]',
                'errors' => [
                    'required' => 'Please enter confirm password',
                    'min_length' => 'Confirm password must be at least 8 characters!',
                    'max_length' => 'Confirm password must not exceed 16 characters!',
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $password = $this->request->getVar('password');
            $email = $this->request->getVar('email_register');
            $name = $this->request->getVar('name_register');

            $registrationData = [
                'user_name' => $name,
                'user_phone' => $this->request->getVar('phone_register'),
                'user_email' => $email,
                'user_type' => 1,
                'user_password' => password_hash($password, PASSWORD_DEFAULT),
            ];

            $Inserted = $commanmodel->insert_query_get_inserid('user_account', $registrationData);

            if ($Inserted) {
                $session->set('loggedin', [
                    'user_id' => $Inserted,
                    'user_name' => $name,
                    'user_phone' => $this->request->getVar('phone_register'),
                    'user_email' => $email,
                    'user_type' => 1,
                ]);

                // Send Email (simple mail function, or use CI4 Email service for better)
                $to = $email;
                $subject = 'Thank You for Registering';
                $from = 'info@ase-electrical.co.uk';

                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: ' . $from . "\r\n" .
                    'Reply-To: ' . $from . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                $htmldata = "
                    <p>Dear $name,</p>
                    <p>Thank you for registering with us.</p>
                    <p>We are excited to have you onboard!</p>
                    <p>Best Regards,<br>Team Hey wansaa</p>
                ";

                mail($to, $subject, $htmldata, $headers);
                


                $array = [
                    'success' => true,
                    'title' => 'Success',
                    'class' => 'success',
                    'message' => 'Your registration has been successfully completed.'
                ];
            } else {
                $array = [
                    'success' => false,
                    'title' => 'Error',
                    'class' => 'danger',
                    'message' => 'Oops! Something went wrong, please try again.'
                ];
            }
        } else {
            // Validation failed
            $array = [
                'error_user' => true,
                'name_register_error' => $validation->getError('name_register'),
                'phone_register_error' => $validation->getError('phone_register'),
                'email_register_error' => $validation->getError('email_register'),
                'password_error' => $validation->getError('password'),
                'confirm_password_error' => $validation->getError('confirm_password'),
            ];
        }
    } else {
        $array = ['failed' => '<div class="alert alert-danger">Please fill all mandatory fields (*)</div>'];
    }

    echo json_encode($array);
}


    public function login_process()
    {
       
       $session = session();
        $commanmodel = new Commanmodel();
         helper(['form', 'url']);
        $validation =  \Config\Services::validation();
       
       
       
       
       
        if($this->request->getVar('user_login')=="Login")
         {  
                  $rules = [
            
            'login_email' => [
                'label'  => 'Email',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please enter email',
                    'is_unique'  =>  'This email address is already exists!' 
                ],
            ],
      
            'login_password' => [
                'label'  => 'Password',
                'rules'  => 'required|min_length[8]|max_length[16]',
                'errors' => [
                    'required' => 'Please enter password',
                     'min_length'  =>  'Password min length 8!',
                    'max_length'  =>  'Password max length 16!',
                    
                ],
            ],
           
           
        ];
             
            
        
       
                if ($this->validate($rules))
                {
                 
           
                 $email =  $this->request->getVar('login_email');
                 $password = $this->request->getVar('login_password');
             
                  $checknumber =$commanmodel->get_single_query('user_account',array('user_email'=> $email));
                 
                 if($checknumber) {
                     
                     $pass = $checknumber->user_password;
                     
                      $authenticatePassword = password_verify($password, $pass);
                if($authenticatePassword){ 
                    
                    
                     $loginData = array(
                    'user_id' => $checknumber->account_id,
                    'user_name' => $checknumber->user_name,
                    'user_phone' => $checknumber->user_phone,
                    'user_email' => $checknumber->user_email,
                    'user_type' => $checknumber->user_type,
                   
                    );
              
                 
              $session->set('loggedin', $loginData);
               
                    $array = [
                        
                        'success'   => true,
                        "title" => 'Success',
                        "class" => 'success',
                        "message" => 'Welcome back! Your now logged in. Enjoy your experience!'
                        
                        ];
                
                      
                     
                } else {

                    $array = [
                       
                        'success'   => true,
                        "title" => 'Warning',
                        "class" => 'warning',
                        "message" => 'the username and password do not match'
                        
                        ];
                   
                }
                     
                     
                 } else { 
                      
                      $array = [
                       
                        'success'   => true,
                        "title" => 'Warning',
                        "class" => 'warning',
                        "message" => 'the username and password do not match'
                        
                        ];
            
                 }
                 
                 
              
                   
                  
                } 
				else
            {
                
                
                
            $array = array(
            'error_user'   => true,
            'login_email_error' => $validation->getError('login_email'),
            'login_password_error' => $validation->getError('login_password'),
           
		
			
            
            );
            }
         }  
         else
         {

            $array = [
                       
                'success'   => true,
                "title" => 'Warning',
                "class" => 'warning',
                "message" => 'Please fill all mandatory fields'
                
                ];
            
         }
         echo json_encode($array); 
    }
    
      public function chack_sing_in()
    {
         $session = session();
        if ($session->has('loggedin')) {
            
               
                    
                     $redirectUrl = session()->get('redirect_url');
        
        if ($redirectUrl) {
            $url = $redirectUrl;
        } else {
           $url = base_url('dashboard');
        }
            
               $array = array(
            
         
             'success' => true,
              'url' => $url,
            );
        } else {
                $array = array(
            
         
             'success' => false,
            );
        }
        echo json_encode($array); 
    }
    
        public function logout()
    {
        $session = session();
         $session->remove('loggedin');
          $session->setFlashdata('login_failed', 'Logout successful. You have been successfully logged out. Thank you for using our services. Have a great day!');
             return redirect()->to('/'); 
    }
        public function blog_list($page)
{
    

    
 

   
    $Blogmodel = new Blogmodel();
    
     $pager = service('pager');
    
    $perPage = 10;
    $total = $Blogmodel->count_all_frontend();
    $segment = $this->request->uri->getSegment(2);
    
    // Set the base URL and segment for pagination links.
    $pager->setPath(base_url('blog'), $segment);
   
    // Generate pagination links using the makeLinks() method.
    $pager_links = $pager->makeLinks($page, $perPage, $total, 'foundation_full');

    $start = ($page - 1) * $perPage;
    
    $output = [
        'item_total' =>$total.' tours found',
        'pagination_link' => $pager_links,
        'product_list' => $Blogmodel->fetch_data($perPage, $start)
    ];
    
    echo json_encode($output);


}

public function cart()
    {
         $commanmodel = new Commanmodel();
         $data = array(
           
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
           
            );
            
            
               $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 9));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_title);
            
         return view('frontend/header',$data).view('frontend/cart').view('frontend/footer');
    }
    
    public function checkout()
    {
         $commanmodel = new Commanmodel();
         $data = array(
            'title' => "contact us : Rent House", 
            'keyword' => "Home : Rent House",
            'description' => "Home : Rent House",
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            'pageimage' => base_url('assets/frontend/assets/img/logo.png')
            );
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 10));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_title);
         return view('frontend/header',$data).view('frontend/checkout').view('frontend/footer');
    }
    
    
     public function wishlist()
    {   $session = session();
          $commanmodel = new Commanmodel();
           $usersession = $session->get('loggedin');
                        $userId = $usersession['user_id'];
              
        $wishlist = $commanmodel->all_multiple_query_order_by('wishlist',array('wishlist_user_id' =>$userId),'wishlist_id','ASC'); 
         $data = array(
        
            'search' => '',
             'wishlist' => $wishlist,
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            
            );
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 11));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_title);
            
         return view('frontend/header',$data).view('frontend/wishlist').view('frontend/footer');
    }
    
    
function enquirysend(){
       $session = session();
  
         $commanmodel = new Commanmodel();
         $request = service('request');
     

 
    $data = array( 
    'enquiry_name' => $this->request->getVar('name'),
    'enquiry_phone' => $this->request->getVar('phone'),
     'enquiry_email' => $this->request->getVar('email'),
      'enquiry_pro_id' => $this->request->getVar('pro_id'),
        'enquiry_vender' => $this->request->getVar('vender'),
    'enquiry_message' => $this->request->getVar('message')

    
    
  
        );
    $Inserted=$commanmodel->insert_query('enquiry',$data);
        $response = [
"title" => 'Enquiry Sent',
"class" => 'success',
"message" => 'Your enquiry has been Sent successfully'

];
    
    echo json_encode($response);
  
   }
   
   
   public function pages($sulg)
    {
         $commanmodel = new Commanmodel();
         $pages =$commanmodel->get_single_query('cms_pages',array('cms_slug'=> $sulg));
         $data = array(
            'title' => $pages->cms_page_name, 
            'keyword' => "",
            'description' => "",
            'search' => '',
          'pages' => $pages,
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            'pageimage' => base_url('assets/frontend/assets/img/logo.png')
            );
         return view('frontend/header',$data).view('frontend/pages').view('frontend/footer');
    }
    
 

 public function forgotPassword()
    { $data = array(
            'title' => "contact us : Rent House", 
            'keyword' => "Home : Rent House",
            'description' => "Home : Rent House",
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            'pageimage' => base_url('assets/frontend/assets/img/logo.png')
            );
      
         return view('frontend/header',$data).view('frontend/forgot_password').view('frontend/footer');
    }

    public function sendResetLink()
    {
        
         $commanmodel = new Commanmodel();
        // Form se email address lene ka process
        $email = $this->request->getPost('email');
        
        // Validate email address
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Invalid email address!');
        }
        
       
     
$user = $commanmodel->get_single_query('user_account',array('user_email'=> $email));
        if ($user) {
            // Token generate karein
            $token = bin2hex(random_bytes(50));
            
            // User record mein token aur expiry time save karein
            $expiryTime = new Time('now');
            $expiryTime = $expiryTime->addHours(1); // Token 1 ghante ke liye valid hoga
            
       
$updated=$commanmodel->update_query('user_account',[
                'reset_token' => $token,
                'reset_token_expiry' => $expiryTime->toDateTimeString()
            ],array('account_id'=>$user->account_id));
            // Reset link create karein
            $resetLink = site_url('auth/resetPassword/' . $token);

            // Email send karein
            $emailService = \Config\Services::email();
               $emailService->setFrom('no-reply@ase-electrical.co.uk', 'Heywansaa');
   
            $emailService->setTo($email);
            $emailService->setSubject('Password Reset Link');
            $emailService->setMessage('Click on this link to reset your password: ' . $resetLink);
            $emailService->send();

            return redirect()->back()->with('message', 'Password reset link sent to your email.');
        } else {
            return redirect()->back()->with('error', 'No user found with that email.');
        }
    }

    public function resetPassword($token)
    {
          $commanmodel = new Commanmodel();
        $data = array(
            'title' => "contact us : Rent House", 
            'keyword' => "Home : Rent House",
            'description' => "Home : Rent House",
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
            'pageimage' => base_url('assets/frontend/assets/img/logo.png')
            );
        // Token ko validate karein
   

        
        $user = $commanmodel->get_single_query('user_account',array('reset_token'=> $token));

        if ($user && new Time('now') < new Time($user->reset_token_expiry)) {
      
             return view('frontend/header',$data).view('frontend/reset_password', ['token' => $token]).view('frontend/footer');
        } else {
            return redirect()->to('/login')->with('error', 'Invalid or expired token.');
        }
    }

    public function updatePassword()
    {
          $commanmodel = new Commanmodel();
        $token = $this->request->getPost('token');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Passwords do not match.');
        }

        $user = $commanmodel->get_single_query('user_account',array('reset_token'=> $token));

        if ($user && new Time('now') < new Time($user->reset_token_expiry)) {
            // Password update karein
        
            $updated=$commanmodel->update_query('user_account',[
                'user_password' => password_hash($newPassword, PASSWORD_BCRYPT),
                'reset_token' => null,
                'reset_token_expiry' => null
            ],array('account_id'=>$user->account_id));

            return redirect()->to('/login')->with('message', 'Password successfully updated.');
        } else {
            return redirect()->to('/login')->with('error', 'Invalid or expired token.');
        }
    }
    
    
     public function bulk_order()
    {
        
         $commanmodel = new Commanmodel();
         $data = array(
           
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
           
            );
            
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 2));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_title);
         return view('frontend/header',$data).view('frontend/bulk_order').view('frontend/footer');
    }
    
     public function friend_family()
    {
        
         $commanmodel = new Commanmodel();
         $data = array(
           
            'search' => '',
          
            'searchcategory' => 'all',
            'pageurl' => base_url(), 
           
            );
            
            
             $meta = $commanmodel->get_single_query('meta',array('meta_id'=> 2));
            $data['title'] = $meta->meta_title;
             $data['keyword'] = $meta->meta_keyword;
              $data['description'] = $meta->meta_description;
               $data['pageimage'] = base_url('assets/meta/'.$meta->meta_title);
         return view('frontend/header',$data).view('frontend/friend_family').view('frontend/footer');
    }
   
   
}
