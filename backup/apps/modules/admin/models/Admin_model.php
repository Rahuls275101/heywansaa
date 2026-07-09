<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Admin_model extends CI_Model {

  public function __construct() {
    parent::__construct();
  }

  public function check_admin_login($data) 
  {
    $query = $this->db->get_where('wps_admin', $data, 1);
     $row = $query->row_array();
    if ($query->num_rows() > 0 && $row['verification_status']=='2') 
    {
     
      $sess_arr = array(
          'admin_user' => $row['admin_username'],
          'adm_key' => $row['admin_key'],
          'admin_type' => $row['admin_type'],
          'admin_id' => $row['admin_id'],
          'verification_status'=>$row['verification_status'],
          'admin_logged_in' => TRUE,
          'best_seller_limit'=>$row['best_seller_limit'],
      );
      $this->session->set_userdata($sess_arr);
      redirect('admin');
    }
    else if($row['verification_status']=='0' && $query->num_rows() > 0 )
    {
        $this->session->set_userdata('error', '<div class="alert alert-danger">You are not activated</div>');
        redirect('admin');
    }
    else 
    {
      $this->session->set_userdata('error', '<div class="alert alert-danger">Invalid username/password</div>');
      redirect('admin');
    }
  }

  public function get_admin_info($id) {
    $id = (int) $id;
    if ($id != '' && is_numeric($id)) {
      $condtion = "admin_id = '" . $id . "'";
      $result = $this->db->query("SELECT * FROM wps_admin WHERE " . $condtion)->row_array();
      return $result;
    }
  }

  public function update_info($old_pass, $id,$admin_margin) 
  {
    // SET FROM NEW ADMIN MARGIN FROM DASHBOARD CHANGE PASSWORD BY RAZ
    $num_row = count_record("wps_admin", "admin_id = '" . $id . "' AND admin_password = '" . $old_pass . "'");

    if ($num_row > 0) {
      $this->db->query("UPDATE wps_admin SET admin_password = '" . $this->input->post('new_pass') . "' , admin_margin='".$admin_margin."' WHERE admin_id  = '" . $id . "'");
      //Email
      
      $this->load->library('email');
      $res_data = $this->db->get_where('wps_admin', array('admin_id' => $id))->row();

      if (is_object($res_data)) {
        /* Forgot  mail to user */
        $mail_to = $res_data->admin_email;
        $mail_subject = $this->config->item('site_name') . " Password Changed";
        $from_email = $mail_to;
        $from_name = $this->config->item('site_name');
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
        $body = str_replace('{site_name}', SITENAME, $body);
        $body = str_replace('{url}', base_url(), $body);
        $body = str_replace('{link}', $verify_url, $body);

        $this->email->from($from_email, $from_name);
        $this->email->to($mail_to);
        $this->email->subject($mail_subject);
        $this->email->message($body);
        $this->email->set_mailtype('html');
        $this->email->send();
        /* End Forgot mail to user */
      }
      $this->session->set_userdata('success', 'Password has been Updated.');
    } 
    else {
      $this->session->set_userdata('error', 'Incorrect Password!');
    }
  }

  public function update_config($id) {
    $num_row = count_record("wps_admin", "admin_id = '" . $id . "'");
    if ($num_row > 0) {
      $data = array(
          'admin_email' => $this->input->post('admin_email'),
          'phone' => $this->input->post('phone'),
          'address' => $this->input->post('address'),
          'facebook' => $this->input->post('facebook'),
          'twitter' => $this->input->post('twitter'),
          'instagram' => $this->input->post('instagram'),
          'linkedin' => $this->input->post('linkedin'),
          'mode' => $this->input->post('mode'),
          'youtube' => $this->input->post('youtube'),
      );

      $this->db->where('admin_id', $id);
      $this->db->update('wps_admin', $data);

      $this->session->set_userdata('msg_type', "success");
      $this->session->set_flashdata('success', lang('successupdate'));
    } else {
      $this->session->set_userdata(array('msg_type' => 'error'));
      $this->session->set_flashdata('error', "Something went wrong, please try again!");
    }
  }

}

/* End of file admin_panel.php */
/* Location: ./system/apps/models/admin_panel.php */