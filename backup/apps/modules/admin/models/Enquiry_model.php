<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Enquiry_model extends MY_Model {

  public function __construct() {
    parent::__construct();
  }

  public function get_enquiry($offset, $per_page, $condition = '') {
    $status_flag = FALSE;

    $fetch_config = array(
        'condition' => $condition,
        'order' => "id DESC",
        //'limit'=>$per_page,
        'start' => $offset,
        'debug' => FALSE,
        'return_type' => "array"
    );
    $result = $this->findAll('wps_enquiry', $fetch_config);
    return $result;
  }

  public function get_customers_enquiry($offset, $per_page, $condition = '') {
    $status_flag = FALSE;

    if ($condition != '') {
      $this->db->where($condition);
    }
    $this->db->select('SQL_CALC_FOUND_ROWS e.*,venq.*', FALSE);
    $this->db->from('wps_enquiry as e');
    $this->db->join('wps_vendor_enquiry AS venq', 'e.id=venq.id', 'left');

    $q = $this->db->get();
    //echo_sql(); 
    //die;
    $result = $q->result_array();
    return $result;
  }

  public function update_reply_status($rid) {

    $id = (int) $rid;

    if ($id != '' && is_numeric($id)) {

      $data = array('reply_status' => 'Y');

      $where = "id = '" . $id . "'";

      $this->safe_update('wps_enquiry', $data, $where, FALSE);
    }
  }

  public function get_company_enquiry($offset, $per_page, $condition = '') {
    $status_flag = FALSE;

    $fetch_config = array(
        'condition' => $condition,
        'order' => "id DESC",
        'limit'=>$per_page,
        'start' => $offset,
        'debug' => FALSE,
        'return_type' => "array"
    );
    $result = $this->findAll('wps_company_enquiry', $fetch_config);
    return $result;
  }

}

// model end here