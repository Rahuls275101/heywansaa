<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Banner_model extends MY_Model {

  public function __construct() {
    parent::__construct();
  }

  public function get_banner($offset = FALSE, $per_page = FALSE) {
    $keyword = $this->db->escape_str(trim($this->input->get_post('keyword', TRUE)));
    $condtion = ($keyword != '') ? "status !='2' AND ( banner_position LIKE '%" . $keyword . "%') " : "status !='2'";
    $fetch_config = array(
        'condition' => $condtion,
        'order' => "banner_id DESC",
        'limit' => $per_page,
        'start' => $offset,
        'debug' => FALSE,
        'return_type' => "array"
    );
    $result = $this->findAll('wps_banners', $fetch_config);
    return $result;
  }

  public function get_banner_by_id($id) {
    $id = applyFilter('NUMERIC_GT_ZERO', $id);
    if ($id > 0) {
      $condtion = "status !='2' AND banner_id=$id";
      $fetch_config = array(
          'condition' => $condtion,
          'debug' => FALSE,
          'return_type' => "object"
      );
      $result = $this->find('wps_banners', $fetch_config);
      return $result;
    }
  }
}

// model end here