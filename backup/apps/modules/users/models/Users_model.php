<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Users_model extends MY_Model {


  public function create_user() {
    $password = $this->input->post('password', TRUE);
    $dob = date('d-m-y', strtotime($this->input->post('dob', TRUE)));
    $register_array = array(
        'user_name' => $this->input->post('email_address', TRUE),
        'password' => $password,
        'first_name' => $this->input->post('first_name', TRUE),
        'last_name' => $this->input->post('last_name', TRUE),
        'gender' => 'M',
        //'dob' => $dob,
        'mobile_number' => $this->input->post('mobile_number', TRUE),
        'actkey' => md5($this->input->post('login_username', TRUE)),
        'account_created_date' => $this->config->item('config.date.time'),
        'current_login' => $this->config->item('config.date.time'),
        'status' => '1',
        'is_verified' => '1',
        'ip_address' => $this->input->ip_address()
    );
    $insId = $this->safe_insert('wps_customers', $register_array, FALSE);
    if ($insId > 0) {
      $add_array = array(
          'customer_id' => $insId,
          //'mtitle' => $this->input->post('mtitle'),
          'first_name' => $this->input->post('first_name'),
          'mobile' => $this->input->post('mobile_number'),
          //'city' => $this->input->post('city'),
          'reciv_date' => $this->config->item('config.date.time'),
          'address_type' => 'Ship',
          'default_status' => 'N'
      );
       $add_array2 = array(
          'customer_id' => $insId,
          //'mtitle' => $this->input->post('mtitle'),
          'first_name' => $this->input->post('first_name'),
          'mobile' => $this->input->post('mobile_number'),
          //'city' => $this->input->post('city'),
          'reciv_date' => $this->config->item('config.date.time'),
          'address_type' => 'Bill',
          'default_status' => 'Y'
      );
      // $this->safe_insert('wps_customers_address_book', $add_array, FALSE);
      // $this->safe_insert('wps_customers_address_book', $add_array2, FALSE);
    }
    return $insId;
  }

  public function create_mobile_user($mobile, $email, $password) {
    $register_array = array(
        'user_name' => ($mobile) ? $mobile : $email,
        'password' => $this->safe_encrypt->encode($password),
        'first_name' => $this->input->post('firstname', TRUE),
        'last_name' => $this->input->post('lastname', TRUE),
        'user_email' => $email,
        'mobile_number' => $mobile,
        'user_location' => '',
        'actkey' => md5($this->input->post('mobile', TRUE)),
        'account_created_date' => $this->config->item('config.date.time'),
        'current_login' => $this->config->item('config.date.time'),
        'status' => '1',
        'is_verified' => ($mobile) ? '1' : '0',
        'ip_address' => $this->input->ip_address()
    );
    $insId = $this->safe_insert('wps_customers', $register_array, FALSE);
    return $insId;
  }

  public function is_email_exits($data) {
    $this->db->select('customers_id');
    $this->db->from('wps_customers');
    $this->db->where($data);
    $this->db->where('status !=', '2');

    $query = $this->db->get();
    if ($query->num_rows() == 1) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function logout() {
    $data = array(
        'user_id' => 0,
        'email' => 0,
        'name' => 0,
        'user_photo' => 0,
        'logged_in' => FALSE
    );
    $this->session->sess_destroy();
    $this->session->unset_userdata($data);
  }

  public function get_all_devices($userId) {
    return $this->db->query("select * from wps_login_token where `user_id`=$userId and `status` = 1")->result_array();
  }

  public function logout_from_single_device($uuid, $userId) {
    return $this->db->query("UPDATE wps_login_token SET status = 0 where `uuid`='$uuid' AND `user_id`=$userId");
  }

  public function logout_from_all_devices($userId) {
    return $this->db->query("UPDATE wps_login_token SET status = 0 where `user_id`=$userId");
  }

  public function login($data) {

    $email = escape_str($data['email']);

    $pass = $this->ci->safe_encrypt->encode(escape_str($data['password']));

    return $this->db->query("select * from wps_customers where `user_name`=? and `password`=?", array($email, $pass))->row();
  }

  function saveOtp($mobile, $otp) {
    $mobile_otp = (array) $this->db->query("select * from wps_otp where `mobile_number`='$mobile' AND `status`='0'")->row();
    // print_r($mobile_otp);die;
    if (count($mobile_otp) > 0) {
      $otpId = $mobile_otp['otpId'];
      $this->db->query("UPDATE wps_otp SET `mobile_number`='$mobile',`otp`='$otp',`status`='0' WHERE `otpId`=$otpId");
    } else {
      $this->db->query("insert into wps_otp (`mobile_number`,`otp`,`status`) values(?,?,'0')", array($mobile, $otp));
    }
    return TRUE;
  }

  function detail($user_id, $f = '*') {
    return $this->db->select($f)->from('wps_customers')->where(['customers_id' => $user_id, 'status !=' => '2'])->get()->row();
  }

  function getAddressById($addressId) {
    $addressId = (int) $addressId;
    if ($addressId != '' && is_numeric($addressId)) {
      $condtion = "id = $addressId";
      $fetch_config = array(
          'condition' => $condtion,
          'debug' => FALSE,
          'return_type' => "array"
      );
      $result = $this->find('addresses', $fetch_config);
      return $result;
    }
  }

  public function logoutUser($userId, $uuid) {
    $this->db->query("update wps_login_token SET status = 0 where uuid = $uuid");
    $this->db->query("update wps_customers SET login_status = 0 where customers_id = $userId");
  }

  public function get_member_row($id, $condtion = '') {
    $id = (int) $id;
    if ($id != '' && is_numeric($id)) {
      $condtion = "status !='2' AND customers_id=$id $condtion ";
      $fetch_config = array(
          'condition' => $condtion,
          'debug' => FALSE,
          'return_type' => "array"
      );
      $result = $this->find('wps_customers', $fetch_config);
      return $result;
    }
  }
  
  public function byVendorAddUserRegSegment($data,$where)
  {
      if($this->db->insert('wps_admin',$data))
      {
          return $this->db->insert_id();
      }
      else
      {
          return false;
      }
  }
  
  public function byCustomerAddUserRegSegment($data,$where)
  {
      if($this->db->insert('wps_customers',$data))
      {
          return $this->db->insert_id();
      }
      else
      {
          return false;
      }
  }
  
  public function create_address_customer($last_user_inserted_id)
  {
      $Bill_data=array('customer_id'=>$last_user_inserted_id,'address_type'=>'Bill');
      $Ship_data=array('customer_id'=>$last_user_inserted_id,'address_type'=>'Ship');
      $this->db->insert('wps_customers_address_book',$Bill_data);
      $this->db->insert('wps_customers_address_book',$Ship_data);
      return true;
  }
  
  
  public function resetpasswordotpsend($email,$otp)
  {
            $html="$otp is Your OTP for Reset Your User Account Password";
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
            $this->load->library('email');
             $this->email->from(EMAILEMAIL)
                  ->to($email)
                  ->subject("OTP for reset password fro heywansa")
                  ->message($html)
                  ->set_mailtype('html')
                  ->send();
                  return true;
  }
  
  
  
  public function update_where($tb,$data,$where)
  {
      $this->db->where($where);
      if($this->db->update($tb,$data))
      {
          return true;
      }
      else
      {
          return false;
      }
  }
  
  
  
  
  
  
  
  
  
  
  
  
  

}

/* End of file users_model.php */
/* Location: ./application/modules/users/models/users_model.php */