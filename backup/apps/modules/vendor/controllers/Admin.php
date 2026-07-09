<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('admin/admin_model'));
    $this->form_validation->set_error_delimiters("<div style='color:#FC0000; margin-bottom:5px;'>", "</div>");
  }

  public function index() {
    if ($this->session->userdata('admin_logged_in') == TRUE) {
      redirect('wps-admin/dashboard', 'refresh');
    } else {
      if ($this->input->post('action') != "") {
        $postdata = array(
            'admin_username' => $this->input->post('username'),
            'admin_password' => md5($this->input->post('password'))
        );
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->admin_model->check_admin_login($postdata);
          if ($this->session->userdata('adm_key') != "") {
            redirect('wps-admin/dashboard', 'refresh');
          }
        }
      }
      $this->load->view('dashboard/admin_login_view');
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
    $redirecturl='';
    if($this->session->userdata('adm_key')==2)
    {
        $redirecturl=base_url().'login/vendor';
    }
    else
    {
        $redirecturl=base_url().'wps-admin';
    }
    
    $this->session->unset_userdata('admin_user', '');
    $this->session->unset_userdata('adm_key', '');
    $this->session->unset_userdata('admin_type', '');
    $this->session->unset_userdata('admin_id', '');
    $this->session->unset_userdata('is_admin_switch', '');
    $this->session->unset_userdata('admin_logged_in', '');

    $this->session->set_userdata('logout', 'Logged Out Successfully!');
    redirect($redirecturl, 'refresh');
  }

  public function forgotten_password() {

    if ($this->input->post('action') != "") {
      $this->form_validation->set_rules('email', ' Email ID', 'required|valid_email');
      if ($this->form_validation->run() == TRUE) {
        $this->forgot_password_mail($this->input->post('email'));
      }
    }
    $data['heading_title'] = "Forgot Password";
    $this->load->view('dashboard/admin_password_view', $data);
  }

  private function forgot_password_mail($email) {
    $this->load->library('email');
    $res_data = $this->db->get_where('wps_admin', array('admin_email' => $email, 'status' => '1'))->row();

    if (is_object($res_data)) {
      /* Forgot  mail to user */

      $mail_to = $res_data->admin_email;
      $mail_subject = SITENAME . " Forgot Password";
      $from_email = $mail_to;
      $from_name = SITENAME;
      $verify_url = "<a href=" . base_url() . "wps-admin/>Click here </a>";

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

}
