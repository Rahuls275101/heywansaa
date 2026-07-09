<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('admin/admin_model'));
    $this->form_validation->set_error_delimiters("<div style='color:#FC0000; margin-bottom:5px;'>", "</div>");
  }

  public function index() {
      
      
      
    if ($this->session->userdata('admin_logged_in') == TRUE) 
    {
        if($this->session->userdata('admin_type')==1)
        {
            redirect('wps-admin/dashboard', 'refresh');
        }
        elseif($this->session->userdata('admin_type')==2)
        {
            redirect('wps-vendor/dashboard', 'refresh');  
        }
        else
        {
              redirect('login/vendor');
        }
          
        
    } 
    else 
    {
      if ($this->input->post('action') != "") {
        $postdata = array(
            'admin_username' => $this->input->post('username'),
            'admin_password' => md5($this->input->post('password')),
            // 'verification_status'=> 2
            
        );
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == TRUE) 
        {
          $this->admin_model->check_admin_login($postdata);
          if ($this->session->userdata('adm_key') != "") 
          {
            if($this->session->userdata('admin_type')==1)
            {
                redirect('wps-admin/dashboard', 'refresh');
            }
            elseif($this->session->userdata('admin_type')==2)
            {
                redirect('wps-vendor/dashboard', 'refresh');  
            }
            else
            {
                  redirect('login/vendor');
            }
            
            
            
            
          }
        }
      }
    //   $this->load->view('dashboard/admin_login_view');
    redirect('login/vendor');
    }
  }

  public function logout() {
    //print_r("in logout");exit;
    $sess_arr = array(
        'admin_user' => '',
        'adm_key' => '',
        'admin_type' => '',
        'admin_id' => '',
        'is_admin_switch' => '',
        'admin_logged_in' => ''
    );
    $this->session->unset_userdata('admin_user', '');
    $this->session->unset_userdata('adm_key', '');
    $this->session->unset_userdata('admin_type', '');
    $this->session->unset_userdata('admin_id', '');
    $this->session->unset_userdata('is_admin_switch', '');
    $this->session->unset_userdata('admin_logged_in', '');

    $this->session->set_userdata('logout', 'Logged Out Successfully!');
    redirect('login/vendor', 'refresh');
  }

  public function forgotten_password()
  {

    if ($this->input->post('action') != "") {
      $this->form_validation->set_rules('email', ' Email ID', 'required|valid_email');
      if ($this->form_validation->run() == TRUE) 
      {
        $this->forgot_password_mail($this->input->post('email'));
      }
    }
    $data['heading_title'] = "Forgot Password";
    $this->load->view('dashboard/admin_password_view', $data);
  }
  
  
  
  public function resetpasswordnow()  //by raaz
  {
      $this->form_validation->set_rules('email', ' Username', 'required|trim');
      if ($this->form_validation->run() == TRUE) 
      {
          $email=$this->input->post('email');
          $chk=$this->checkemail_db($email);
          if($chk>0)
          {
              
              $otp=rand(10000,99999);
              $this->session->set_userdata('admin_otp',$otp);
              $html="Your otp is $otp";
              
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
            $this->load->library('email');
             $this->email->from(EMAILEMAIL)
                  ->to(EMAILEMAIL)
                  ->subject("Forget Password Recovery OTP")
                  ->message($html)
                  ->set_mailtype('html')
                  ->send();
                
              
              
              
              
              
              
              
              
              
              
              
              
              $this->session->set_flashdata('forgot_msg','<div class="text-danger">Successfully OTP send on your email.</div>');
              $this->load->view('dashboard/admin_password_reset_now', $data);
          }
          else
          {
             $data['heading_title'] = "Forgot Password";
             $this->session->set_flashdata('forgot_msg','<div class="text-danger">Email Not send to your email id.</div>');
             $this->load->view('dashboard/admin_password_view');
          }
      }
      else
      {
             $data['heading_title'] = "Forgot Password";
             $this->session->set_flashdata('forgot_msg','<div class="text-danger">'.validation_errors().'</div>');
             $this->load->view('dashboard/admin_password_view');
      }
  }
  
  public function checkemail_db($email)
  {
      $this->db->where('admin_username',$email);
      $this->db->where('admin_key','1');
      $this->db->where('admin_type','1');
      $this->db->where('verification_status','2');
      $r=$this->db->get('wps_admin')->result_array();
      return count($r);
      
  }
  
  
  

  private function forgot_password_mail($email) //old one forgot password some change by raaz
  {
    $this->load->library('email');
    $res_data = $this->db->get_where('wps_admin', array('admin_email' => $email, 'status' => '1'))->row();

    if (is_object($res_data)) {
      /* Forgot  mail to user */

      $mail_to = $res_data->admin_email;
      $mail_subject = SITENAME . " Forgot Password";
      $from_email = $mail_to;
      $from_name = SITENAME;
      $verify_url = "<a href=" . base_url() . "login/vendor/>Click here </a>";

      $body = " Dear Admin,<br />
			Your login details are as follows:<br />
			User name :  {username}<br />        
			Password:  {password}<br /> 
			Click here to login {link}<br />  <br />						   
			Thanks and Regards,<br />						   
			{site_name} Team  ";

      $body = str_replace('{username}', $res_data->admin_username, $body);
      $body = str_replace('{password}', $res_data->admin_password, $body);
      $body = str_replace('{site_name}', $this->config->item('site_name'), $body);
      $body = str_replace('{link}', $verify_url, $body);

      $this->email->from($from_email, $from_name);
      $this->email->to($mail_to);
      $this->email->subject($mail_subject);
      $this->email->message($body);
      $this->email->set_mailtype('html');
      $this->email->send();

      /* End Forgot mail to user */
      $this->session->set_userdata('success', 'Recover password email has been sent to register email address!');
      redirect('wps-admin/forgot-password', '');
    } else {
      $this->session->set_userdata('error', 'Invalid Email Address!');
      redirect('wps-admin/forgot-password', '');
    }
  }
  
  public function setnewpassword()
  {
      $this->form_validation->set_rules('email','email','trim|required');
      $this->form_validation->set_rules('otp','OTP','trim|required');
      $this->form_validation->set_rules('password','password','trim|required');
      $this->form_validation->set_rules('password2','password2','trim|required|matches[password]');
      if($this->form_validation->run())
      {
          if($this->input->post('otp')==$this->session->userdata('admin_otp'))
          {
              $data=array('admin_password'=>md5($this->input->post('password')));
              $this->session->flashdata('reset_msg','<div class="alert alert-success">Successfully Change Password</div>');
              $this->db->where('admin_email',$this->input->post('email'));
              $this->db->update('wps_admin',$data);
              redirect(base_url().'login/vendor');
            // echo "1";
          }
          else
          {
              $this->session->flashdata('reset_msg','<div class="alert alert-danger">Something error in chnage password</div>');
            //  redirect(base_url().'wps-admin'); 
            echo "0";
          }
      }
      else
      {
          $this->session->flashdata('reset_msg','<div class="alert alert-danger">'.validation_errors().'</div>');
        //   redirect(base_url().'wps-admin');
        echo "00";
      }
  }
  
  
  
  public function update_best_seller_limit()
  {
      $this->form_validation->set_rules('best_seller_limit','Best Seller Limit','trim|required|max_length[10]');
      if($this->form_validation->run())
      {
          $best_seller_limit= $this->input->post('best_seller_limit');
          $data=array('best_seller_limit'=>$best_seller_limit);
          $where=array('admin_key'=>'1','admin_type'=>'1','admin_id'=>'1');
          $this->db->where($where);
          $this->db->update('wps_admin',$data);
          $this->session->set_userdata('best_seller_limit',$best_seller_limit);
          $this->session->set_flashdata('bestsellermsg','<div class="alert alert-success">Successfully updated!</div>');
          redirect('wps-admin/staticpages');
      }
      else
      {
          $this->session->set_flashdata('bestsellermsg','<div class="alert alert-success">'.validation_errors()."</div>");
          redirect('wps-admin/staticpages');
      }
    
  }

}
