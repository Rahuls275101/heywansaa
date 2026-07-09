<?php



class Vendorweb extends Public_Controller {



  public function __construct() {

    parent::__construct();

    $this->load->helper(array('date', 'language', 'cookie', 'file','security'));

    $this->load->model(array('users/users_model', 'pages/pages_model', 'members/members_model','vendorweb_model'));

    $this->load->library(array('safe_encrypt', 'Auth', 'Dmailer', 'cart'));

    $rf_session = $this->session->userdata('ref');

    if ($rf_session == '' && $this->input->get('ref') != "") {

      $this->session->set_userdata(array('ref' => $this->input->get('ref')));

    }

  }



  public function index() 
  {
    $this->load->view('vendor_login');
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
  
  
  public function forgotpassword()
  {
      $this->load->view('users_forgot_password');
  }
  
  public function resetpassword()
  {
      $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean');
      if($this->form_validation->run())
      {
          
          $email=$this->input->post('email');
          $checkdata=$this->db->query("select * from wps_admin where admin_email='$email' and admin_key='2' and verification_status='2'")->result_array();
          
          if($checkdata==true)
          {
              $otp=rand(10000,99999);
              $this->session->set_userdata('vendor_reset_password_email',$this->input->post('email'));
              $this->session->set_userdata('vendor_reset_password_otp',$otp);
              $this->vendorweb_model->resetpasswordotpsend($this->input->post('email'),$otp);
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
          $this->session->set_flashdata('reset_vendor_password_msg',"<div class='alert alert-danger'>".validation_errors()."</div>");
           $this->load->view('users_forgot_password');
      }
  }
  
  public function resetnow()
  {
      
      $this->form_validation->set_rules('otp','OTP','trim|required');
      $this->form_validation->set_rules('password','Password','trim|required');
      $this->form_validation->set_rules('password2','Password-2','trim|required|matches[password]');
      if($this->form_validation->run())
      {
          $data=array(
                        'otp'=>$this->input->post('otp'),
                        'admin_password'=>md5($this->input->post('password')),
                        );
                        $where=array(
                            'admin_email'=>$this->session->userdata('vendor_reset_password_email'),
                            'admin_key'=>'2',
                            'admin_type'=>2,
                            'verification_status'=>'2'
                            );
            if($this->vendorweb_model->update_where('wps_admin',$data,$where))
            {
                 $this->session->set_flashdata('reset_vendor_password_msg',"<div class='alert alert-success'>Password Successfully reset</div>");
                 redirect('login/vendor');
            }
            else
            {
                $this->session->set_flashdata('reset_vendor_password_msg',"<div class='alert alert-danger'>Email id not match in vendor list</div>");
                $this->load->view('users_reset_password'); 
            }
      }
      else
      {
           $this->session->set_flashdata('reset_vendor_password_msg',"<div class='alert alert-danger'>".validation_errors()."</div>");
           $this->load->view('users_reset_password');
      }
  }
  
  
  
  
  
  
}











