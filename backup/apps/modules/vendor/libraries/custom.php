<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Custom {
  
  // Constructor
  public function __construct() {
    if (!isset($this->CI)) {
      $this->CI = & get_instance();
    }
  }

  public function create_meta($data = array()) {

    if (is_array($data) && !empty($data) && array_key_exists('page_url', $data)) {
      $this->CI->db->insert("wps_meta_tags", $data);
    }
  }

}

// END Form Email mailer  Class
/* End of file Dmailer.php */
/* Location: ./application/libraries/Dmailer.php */