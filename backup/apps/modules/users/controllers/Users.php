<?php



class Users extends Public_Controller {



  public function __construct() {

    parent::__construct();

    $this->load->helper(array('date', 'language', 'cookie', 'file','security'));

    $this->load->model(array('users/users_model', 'pages/pages_model', 'members/members_model'));

    $this->load->library(array('safe_encrypt', 'Auth', 'Dmailer', 'cart'));

    $rf_session = $this->session->userdata('ref');

    if ($rf_session == '' && $this->input->get('ref') != "") {

      $this->session->set_userdata(array('ref' => $this->input->get('ref')));

    }

  }



  public function index() {

    if ($this->auth->is_user_logged_in()) {

      redirect('members/', '');

    }

    $data['heading_title'] = "Login";

    $data['unq_section'] = "Login";

    $this->load->view('users_login', $data);

  }

  public function login() {




    if (!$this->auth->is_user_logged_in()) {

      $this->form_validation->set_rules('login_mobile', 'Username', 'trim|required');

      $this->form_validation->set_rules('login_password', 'Password', 'trim|required');

      if ($this->form_validation->run() == TRUE) {

        $username = $this->input->post('login_mobile');

        $password = md5($this->input->post('login_password'));

        $rember = ($this->input->post('remember') != "") ? TRUE : FALSE;

        if ($this->input->post('remember') == "Y") {

          set_cookie('userName', $this->input->post('login_email'), time() + 60 * 60 * 24 * 30);

          set_cookie('pwd', md5($this->input->post('login_password')), time() + 60 * 60 * 24 * 30);

        } else {

          delete_cookie('userName');

          delete_cookie('pwd');

        }

        

          $this->auth->verify_user($username, $password);

          if ($this->auth->is_user_logged_in()) {

            /* Saving Login Ip Address */

            $ip_array = array(

                'member_id' => $this->session->userdata('user_id'),

                'ip_address' => $_SERVER['REMOTE_ADDR'],

            );

            $insId = $this->users_model->safe_insert('wps_ip_details', $ip_array, FALSE);

            /* End Here */

            $ref = $this->input->post('ref');

            if ($ref != "") {

              redirect($ref, '');

            } else {
                redirect('my-account', '');
            }

          } else {

            $this->session->set_userdata(array('msg_type' => 'error'));

            $this->session->set_flashdata('error', ' Invalid username or password.');

            redirect('login', '');

          }

       

      }

      $condition = array('friendly_url' => 'login', 'status' => '1');

      $content = $this->pages_model->get_cms_page($condition);

      $data['page_content'] = $content;

      $data['heading_title'] = "Login";

      $this->load->view('users_login', $data);

    } else {

      redirect('my-account', 'refresh');

    }

  }

  public function logout() {

    $data2 = array(

        'shipping_id' => 0,

        'coupon_id' => 0,

        'discount_amount' => 0

    );

    $this->session->unset_userdata($data2);

    $this->session->unset_userdata(array("ref" => '0'));

    //$this->cart->destroy();

    $this->auth->logout();



    $this->session->set_userdata(array('msg_type' => 'success'));

    $this->session->set_flashdata('success', 'Logout Successfully.');

    redirect('login', '');

    //redirect($_SERVER['HTTP_REFERER'], '');

  }



  public function register() {
    if (!$this->auth->is_user_logged_in()) {
      if ($this->input->get_post('action') == 'register') {
        //$this->form_validation->set_rules('mtitle', 'Title', 'trim|required|max_length[32]');
         //$this->form_validation->set_rules('city', 'City', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha|max_length[32]');
        //$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|alpha|max_length[32]');
        //$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('email_address', 'Email ID', 'trim|required|valid_email|max_length[80]|callback_email_check');
        $this->form_validation->set_rules('mobile_number', 'Mobile No', 'trim|required|numeric|min_length[10]|max_length[15]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[20]|valid_password');
        $this->form_validation->set_rules('c_password', 'Confirm passsword', 'required|matches[password]');
        if ($this->form_validation->run() == TRUE) {
          $registerId = $this->users_model->create_user();
          $first_name = $this->input->post('first_name', TRUE);
          $last_name = '';
          $username = $this->input->post('email_address', TRUE);
          $password = $this->input->post('password', TRUE);
          if ($registerId != '') {
            /* Send  mail to user */
            $content = get_content('wps_auto_respond_mails', '1');
            $subject = str_replace('{site_name}', SITENAME, $content->email_subject);
            $body = $content->email_content;
            $verify_url = "<a href=" . base_url() . "users/verify/" . $registerId . ">Verify Your Email Address </a>";
            $name = $first_name;
            $body = str_replace('{mem_name}', $name, $body);
            $body = str_replace('{username}', $username, $body);
            $body = str_replace('{password}', $password, $body);
            $body = str_replace('{admin_email}', $this->admin_info->admin_email, $body);
            $body = str_replace('{site_name}', SITENAME, $body);
            $body = str_replace('{url}', base_url(), $body);
            $body = str_replace('{link}', $verify_url, $body);
            $mail_conf = array(
                'subject' => $subject,
                'to_email' => $this->input->post('email_address'),
                'from_email' => $this->admin_info->admin_email,
                'from_name' => SITENAME,
                'body_part' => $body
            );
            //trace($mail_conf);
            //exit;
            $this->dmailer->mail_notify($mail_conf);
            //$this->mailer->sending_mail($mail_conf);
            /* End send  mail to user */
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
            $body = str_replace('{site_name}', SITENAME, $body);
            $body = str_replace('{url}', base_url(), $body);
            if($this->admin_info->website_mode=='Live'){
                $mail_conf = array(
                    'subject' => $subject,
                    'to_email' => $this->admin_info->admin_email, //
                    'from_email' => $this->input->post('email_address'),
                    'from_name' => SITENAME,
                    'body_part' => $body
                );
                $this->dmailer->mail_notify($mail_conf);
                $mail_conf2 = array(
                    'subject' => $subject,
                    'to_email' => "info@weblieu.com", //
                    'from_email' => $this->input->post('email_address'),
                    'from_name' => SITENAME,
                    'body_part' => $body
                );
                $this->dmailer->mail_notify($mail_conf2);
              }else{
                 $mail_conf4 = array(
                  'subject' => $subject,
                  'to_email' => 'info@weblieu.com', //
                  'from_email' => $this->input->post('email_address'),
                  'from_name' => SITENAME,
                  'reply_to' => $this->input->post('email_address'),
                  'body_part' => $body,
                );
                $this->dmailer->mail_notify($mail_conf4);
              }
          }
          $this->auth->verify_user($username, $password);
          $message = $this->config->item('register_thanks');
          $message = str_replace('<site_name>', SITENAME, $message);
          // $this->session->set_userdata(array('msg_type'=>'success'));
          $this->session->set_flashdata('success', $message);
          //$cart_items='';
          // if ($this->cart->contents() != "" && count($this->cart->contents()) > 0) {
          //   redirect('cart', '');
          // } else {
            redirect('my-account', '');
          //}
        }
      }
      $data['heading_title'] = "Register";
      $data['unq_section'] = "Register";
      $this->load->view('users_register', $data);
    } else {
      redirect('my-account', 'refresh');
    }
  }



// public function forgotten_password() {
//       $email = $this->input->post('email', TRUE);
//       $this->form_validation->set_rules('email', ' Email ID', 'required|valid_email');
//       if ($this->form_validation->run() == TRUE) {
//         $condtion = array('field' => "customers_id,first_name,user_name", 'condition' => "user_name ='" . $email . "' AND status ='1' ");
//         $res = $this->users_model->find('wps_customers', $condtion);
//         if (is_array($res) && !empty($res)) {
//           $first_name = $res['first_name'];
//           $userId = $this->safe_encrypt->encode($res['customers_id']);
//           $content = get_content('wps_auto_respond_mails', '2');
//           $subject = $content->email_subject;
//           $body = $content->email_content;
//           $verify_url = "<a href=" . base_url() . "users/reset_password/" . $userId . ">Reset Password</a>";
//           $name = $first_name;
//           $body = str_replace('{mem_name}', $name, $body);
//           $body = str_replace('{admin_email}', $this->admin_info->admin_email, $body);
//           $body = str_replace('{site_name}', SITENAME, $body);
//           $body = str_replace('{url}', base_url(), $body);
//           $body = str_replace('{link}', $verify_url, $body);
//           $mail_conf = array(
//               'subject' => $subject,
//               'to_email' => $res['user_name'],
//               'from_email' => $this->admin_info->admin_email,
//               'from_name' => SITENAME,
//               'body_part' => $body
//           );
//           //trace($mail_conf);
//           //die;
//           $this->dmailer->mail_notify($mail_conf);
//           //Mail End
//           $res = '<div class="alert alert-success"><strong>Success!</strong>'.$this->config->item('forgot_password_success').'</div>';
//         } else {
//            $res = '<div class="alert alert-danger">
//                       <strong>'.$this->config->item('email_not_exist').'
//                   </div>';
          
//         }
//       }else{
//          $res = '<div class="alert alert-danger">
//                       <strong>'.validation_errors().'
//                   </div>';
//       }
//        echo $res;
//     exit;
//   }

public function forgotten_password() {


    $email = $this->input->post('email', TRUE);

    $this->form_validation->set_rules('email', ' Email ID', 'required|valid_email');

    if ($this->form_validation->run() == TRUE) {

      $condtion = array('field' => "customers_id,first_name,user_name", 'condition' => "user_name ='" . $email . "' AND status ='1' ");

      $res = $this->users_model->find('wps_customers', $condtion);

      if (is_array($res) && !empty($res)) {

        $first_name = $res['first_name'];

        $userId = md5($res['customers_id']);



        $content = get_content('wps_auto_respond_mails', '2');

        $subject = $content->email_subject;

        $body = $content->email_content;



        $verify_url = "<a href=" . base_url() . "users/reset_password/" . $userId . ">Reset Password</a>";

        $name = $first_name;

        $body = str_replace('{mem_name}', $name, $body);

        $body = str_replace('{admin_email}', $this->admin_info->admin_email, $body);

        $body = str_replace('{site_name}', SITENAME, $body);

        $body = str_replace('{url}', base_url(), $body);

        $body = str_replace('{link}', $verify_url, $body);



        $mail_conf = array(

            'subject' => $subject,

            'to_email' => $res['user_name'],

            'from_email' => $this->admin_info->admin_email,

            'from_name' => SITENAME,

            'body_part' => $body

        );

       // trace($mail_conf);

        //die;

        $this->dmailer->mail_notify($mail_conf);

        //Mail End



        $this->session->set_userdata(array('msg_type' => 'success'));

        $this->session->set_flashdata('success', ' Please check your email account to reset your password!');

        redirect('forgot-password', '');

      } else {

        $this->session->set_userdata(array('msg_type' => 'error'));

        $this->session->set_flashdata('error', ' Email id does not exist.');

        redirect('forgot-password', '');

      }

    }

  

  $data['heading_title'] = "Forgot Password";

  $this->load->view('users_forgot_password', $data);

}



  public function reset_password() {

    $userId = $this->uri->segment(3);

    $mres = get_db_single_row("wps_customers", "*", "md5(customers_id) = '" . $userId . "'");

    $data['mres'] = $mres;

    if (is_array($mres) && !empty($mres)) {

      $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|valid_password');

      $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');



      if ($this->form_validation->run() == TRUE) {

        $password = $this->input->post('new_password');

        $data = array('password' => $password);

        $where = " md5(customers_id) = '" . $userId . "'";

        $this->members_model->safe_update('wps_customers', $data, $where, FALSE);

        $this->session->set_userdata(array('msg_type' => 'success'));

        $this->session->set_flashdata('success', 'Your Password has been updated, please login now!');

        redirect('login', '');

      }

      /* End  member change password  */

      $data['heading_title'] = "Reset Password";

      $this->load->view('users_reset_password', $data);

    } else {

      

    }

  }



  public function email_check() {
    $email = $this->input->post('email_address');
    if ($this->users_model->is_email_exits(array('user_name' => $email))) {
      $this->form_validation->set_message('email_check', "Email Address / Usename Already Exists!");
      return FALSE;
    } else {
      return TRUE;
    }
  }



  public function verify()
  {

    $id = $this->uri->segment(3);

    $mres = $this->db->query("SELECT user_name, password FROM wps_customers WHERE MD5(customers_id) = '" . $id . "'")->row_array();

    $this->db->query("UPDATE wps_customers SET is_verified = '1', status = '1' WHERE MD5(customers_id) = '" . $id . "'");

    $password = $this->safe_encrypt->decode($mres['password']);

    $username = $mres['user_name'];

    $this->auth->verify_user($username, $password);

    redirect(base_url() . "my-account");

  }
  
  
  public function vendorsignup()
  {
       if($this->input->post('usertype')=='vendor')
       {
           $this->load->helper('security');
              $this->form_validation->set_rules('email','email','trim|required|valid_email|max_length[100]|xss_clean');
              $this->form_validation->set_rules('password','password','trim|required|max_length[100]|xss_clean');
              $this->form_validation->set_rules('first_name','first_name','trim|required|max_length[50]|xss_clean');
              $this->form_validation->set_rules('last_name','last_name','trim|required|max_length[50]|xss_clean');
              $this->form_validation->set_rules('shop_name','shop_name','trim|required|max_length[500]|xss_clean');
              $this->form_validation->set_rules('phone_no','phone_no','trim|required|min_length[10]|max_length[10]|numeric|xss_clean');
              $this->form_validation->set_rules('usertype','usertype','trim|required|max_length[30]|xss_clean');
              if($this->form_validation->run())
              {
                 $data=array(
                            'admin_email'=>$this->input->post('email'),
                            'admin_password'=>md5($this->input->post('password')),
                            'first_name'=>$this->input->post('first_name'),
                            'last_name'=>$this->input->post('last_name'),
                            'name'=>$this->input->post('first_name').' '.$this->input->post('last_name'),
                            'business_name'=>$this->input->post('shop_name'),
                            'phone'=>$this->input->post('phone_no'),
                            'admin_type'=>'2',
                            'admin_key'=>'2',
                            'admin_username'=>$this->input->post('email'),
                            'post_date'=>date('Y-m-d')
                            );
                    if($this->users_model->byVendorAddUserRegSegment($data,$where=array()))
                    {
                        echo json_encode($data=array('response'=>"<div class='alert alert-success mt-2'>Successfully Vendor Request send to admin kindly wait for Admin Approval</div>",'status'=>"1"));
                        die;
                    }
                    else
                    {
                       echo json_encode($data=array('response'=>"<div class='alert alert-danger mt-2'>Something Error Kindly Check your data</div>",'status'=>"0"));
                        die;
                    }
              }
              else
              {
                  echo json_encode($data=array('response'=>"<div class='alert alert-danger mt-2'>".validation_errors()."</div>",'status'=>"0"));
                  die;
              }
       }
       else
       {
                 echo json_encode($data=array('response'=>"<div class='alert alert-danger mt-2'>Oop's Wrong Ways Entry Not Allowed Sorry :)</div>",'status'=>"0"));
                  die;
       }
      
  }

  public function customersignup()
  {
  		
      if($this->input->post('usertype')=='customer')
       {
           $this->load->helper('security');
              $this->form_validation->set_rules('email','email','trim|required|valid_email|max_length[100]|xss_clean|is_unique[wps_customers.user_name]');
              $this->form_validation->set_rules('password','password','trim|required|max_length[100]|xss_clean');
              $this->form_validation->set_rules('usertype','usertype','trim|required|max_length[30]|xss_clean');
              
              $this->form_validation->set_rules('first_name','First Name','trim|required|xss_clean');
              $this->form_validation->set_rules('last_name','Last Name','trim|required|xss_clean');
              $this->form_validation->set_rules('phone_no','Phone No','trim|required|max_length[10]|xss_clean|is_unique[wps_customers.mobile_number]');
              if($this->form_validation->run())
              {
                 $data=array(
                            'user_name'=>$this->input->post('email'),
                            'first_name'=>$this->input->post('first_name'),
                            'last_name'=>$this->input->post('last_name'),
                            'mobile_number'=>$this->input->post('phone_no'),
                            'password'=>md5($this->input->post('password')),
                            'email'=>$this->input->post('email'),
                            'status'=>'1',
                            'is_verified'=>'1',
                            'login_type'=>'normal',
                            'account_created_date'=>$this->config->item('config.date.time'),
                            'ip_address'=>$this->input->ip_address(),
                            );
							
					 $email =$this->input->post('email');
					 
				 	
                    if($last_user_inserted_id=$this->users_model->byCustomerAddUserRegSegment($data,$where=array()))
                    {
					 
                        $this->users_model->create_address_customer($last_user_inserted_id);
						
						
						
						
			$html="Thank you for your registration.";
			
            $this->load->library('email'); 
            $mail_config['smtp_host'] = 'smtp.gmail.com';
            $mail_config['smtp_port'] = '587';
            $mail_config['smtp_user'] = EMAILEMAIL;
            $mail_config['_smtp_auth'] = TRUE;
            $mail_config['smtp_pass'] = EMAILPASSWORD;
            $mail_config['smtp_crypto'] = 'tls';
            $mail_config['protocol'] = 'smtp';
            $mail_config['mailtype'] = 'html';
            $mail_config['send_multipart'] = FALSE;
            $mail_config['charset'] = 'utf-8';
            $mail_config['wordwrap'] = TRUE;
            $this->email->initialize($mail_config);
            $this->email->set_newline("\r\n");
           
             $this->email->from(EMAILEMAIL)
                  ->to($email)
                  ->subject("Welcome to HeyWansa")
                  ->message($html)
                  ->set_mailtype('html')
                  ->send();
                 
						 
						
						
                        echo json_encode($data=array('response'=>"<div class='alert alert-success mt-2'>Successfully created your account</div>",'status'=>"1"));
                        die;
                    }
                    else
                    {
					 
                       echo json_encode($data=array('response'=>"<div class='alert alert-danger mt-2'>Something Error Kindly Check your Email And Password</div>",'status'=>"0"));
                        die;
                    }
              }
              else
              {
                  echo json_encode($data=array('response'=>"<div class='alert alert-danger mt-2'>".validation_errors()."</div>",'status'=>"0"));
                  die;
              }
       }
       else
       {
                 echo json_encode($data=array('response'=>"<div class='alert alert-danger mt-2'>Oop's Wrong Ways ! Not Allowed, Sorry</div>",'status'=>"0"));
                  die;
       }
       
  }
  
  public function forgetpassword()
  {
      $this->load->view('users_forgot_password');
  }
  
  public function resetpassword()
  {
      
  
       $this->form_validation->set_rules('email','Email-ID','trim|required|valid_email|xss_clean');
       if($this->form_validation->run())
       {
              $email=$this->input->post('email');
              $checkdata=$this->db->query("select * from wps_customers where email='$email' and status='1' and is_verified='1'")->result_array();
              
              if($checkdata==true)
              {
                  $otp=rand(10000,99999);
                  $this->session->set_userdata('user_reset_password_email',$this->input->post('email'));
                  $this->session->set_userdata('user_reset_password_otp',$otp);
                  $this->users_model->resetpasswordotpsend($this->input->post('email'),$otp);
                  $this->session->set_flashdata('reset_vendor_password_msg',"<div class='alert alert-success'>OTP Successfully send to your registered email-id </div>");
                  $this->load->view('users_reset_password');
                  
              }
              else
              {
                 $this->session->set_flashdata('reset_vendor_password_msg',"<div class='alert alert-danger'>Email id not match in vendor list</div>");
                 $this->load->view('users_forgot_password'); 
              }
       }
       else
       {
           echo validation_errors();
       }
    }

    public function resetnowpassword()
    {
          $this->form_validation->set_rules('otp','OTP','trim|required');
          $this->form_validation->set_rules('password','Password','trim|required');
          $this->form_validation->set_rules('password2','Password-2','trim|required|matches[password]');
          if($this->form_validation->run())
          {
              $data=array(
                            'otp'=>$this->input->post('otp'),
                            'password'=>md5($this->input->post('password')),
                            );
                            $where=array(
                                'email'=>$this->session->userdata('user_reset_password_email'),
                                'status'=>'1',
                                'is_verified'=>'1'
                                );
                                
                if($this->users_model->update_where('wps_customers',$data,$where))
                {
                     $this->session->set_flashdata('reset_user_password_msg',"<div class='alert alert-success'>Password Successfully reset</div>");
                     redirect('login');
                }
                else
                {
                    $this->session->set_flashdata('reset_user_password_msg',"<div class='alert alert-danger'>Email id not match in vendor list</div>");
                    $this->load->view('users_reset_password'); 
                }
          }
          else
          {
               $this->session->set_flashdata('reset_user_password_msg',"<div class='alert alert-danger'>".validation_errors()."</div>");
               $this->load->view('users_reset_password');
          }
    }
    
    
    public function share_friend_family()
    {
       $this->load->view('recome_share_page');
    }


}



/* End of file users.php */

/* Location: ./application/modules/users/controller/users.php */