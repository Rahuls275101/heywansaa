<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Admin_lib {

  // Constructor
  public function __construct() {
    if (!isset($this->CI)) {
      $this->CI = & get_instance();
    }
  }

  public function is_admin_logged_in() {
    if ($this->CI->session->userdata('admin_logged_in') != TRUE) {
      $this->CI->session->set_userdata('error', 'Session Expired!');
      redirect('wps-admin/', 'refresh');
      exit();
    } else {
      $num = $this->CI->db->get_where('wps_admin', array('admin_key' => $this->CI->session->userdata('adm_key')))->num_rows();
      if (!$num) {
        $sess_arr = array(
            'admin_user' => 0,
            'adm_key' => 0,
            'admin_logged_in' => FALSE
        );
        $this->CI->session->unset_userdata($sess_arr);
        $this->session->set_flashdata('error', 'Logout successfully ..');
        redirect('wps-admin', '');
      }
    }
  }

  public function display_set_msg() {
    if ($this->CI->session->flashdata('message')) {
      echo '<div class="warning ac " style="padding: 3px;">';
      echo $this->CI->session->flashdata('message');
      echo "</div>";
    }
  }

}

/* End of file Access_library.php */
/* Location: ./application/libraries/Access_library.php */