<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Location_model extends MY_Model {

  public $wps_name;

  public function __construct() {
    parent::__construct();
    $this->wps_name = "wps_countries_list";
  }

  public function get_record($opts = array()) {
    $status = $this->db->escape_str($this->input->get_post('status', TRUE));

    if (!array_key_exists('condition', $opts) || $opts['condition'] == '') {
      $opts['condition'] = "status !='2' ";
    } else {
      $opts['condition'] = "status !='2' " . $opts['condition'];
    }
    if ($status != '') {
      $opts['condition'] .= " AND status='$status' ";
    }

    $opts['order'] = "name ASC ";
    $opts['condition'] .= " ";
    $fetch_config = array('condition' => $opts['condition'],
        'order' => $opts['order'],
        'return_type' => "array"
    );
    if (array_key_exists('debug', $opts)) {
      $fetch_config['debug'] = $opts['debug'];
    }
    if (array_key_exists('field', $opts) && $opts['field'] != '') {
      $fetch_config['field'] = $opts['field'];
    }
    if (array_key_exists('limit', $opts) && applyFilter('NUMERIC_GT_ZERO', $opts['limit']) > 0) {
      $fetch_config['limit'] = $opts['limit'];
    }
    if (array_key_exists('offset', $opts) && applyFilter('NUMERIC_WT_ZERO', $opts['offset']) != -1) {
      $fetch_config['start'] = $opts['offset'];
    }
    $result = $this->findAll($this->wps_name, $fetch_config);
    return $result;
  }

  public function get_record_by_id($id) {
    $id = applyFilter('NUMERIC_GT_ZERO', $id);

    if ($id > 0) {
      $condtion = "status !='2' AND id=$id";
      $fetch_config = array(
          'condition' => $condtion,
          'debug' => FALSE,
          'return_type' => "object"
      );
      $result = $this->find($this->wps_name, $fetch_config);
      return $result;
    }
  }

  public function get_single_row($tblname, $id) {
    $id = applyFilter('NUMERIC_GT_ZERO', $id);

    if ($id > 0) {
      $condtion = "status !='2' AND id=$id";
      $fetch_config = array(
          'condition' => $condtion,
          'debug' => FALSE,
          'return_type' => "object"
      );
      $result = $this->find($tblname, $fetch_config);
      return $result;
    }
  }

  //states
  public function get_states($opts = array()) {
    $status = $this->db->escape_str($this->input->get_post('status', TRUE));
    if (!array_key_exists('condition', $opts) || $opts['condition'] == '') {
      $opts['condition'] = "status !='2' ";
    } else {
      $opts['condition'] = "status !='2' " . $opts['condition'];
    }
    if ($status != '') {
      $opts['condition'] .= " AND status='$status' ";
    }
    $opts['order'] = "name ASC ";
    $opts['condition'] .= " ";
    $fetch_config = array('condition' => $opts['condition'],
        'order' => $opts['order'],
        'return_type' => "array"
    );
    if (array_key_exists('debug', $opts)) {
      $fetch_config['debug'] = $opts['debug'];
    }
    if (array_key_exists('field', $opts) && $opts['field'] != '') {
      $fetch_config['field'] = $opts['field'];
    }
    if (array_key_exists('limit', $opts) && applyFilter('NUMERIC_GT_ZERO', $opts['limit']) > 0) {
      $fetch_config['limit'] = $opts['limit'];
    }
    if (array_key_exists('offset', $opts) && applyFilter('NUMERIC_WT_ZERO', $opts['offset']) != -1) {
      $fetch_config['start'] = $opts['offset'];
    }
    $result = $this->findAll("wps_states_list", $fetch_config);
    return $result;
  }

  //states
  public function get_district($opts = array()) {
    $status = $this->db->escape_str($this->input->get_post('status', TRUE));

    if (!array_key_exists('condition', $opts) || $opts['condition'] == '') {
      $opts['condition'] = "status !='2' ";
    } else {
      $opts['condition'] = "status !='2' " . $opts['condition'];
    }

    if ($status != '') {
      $opts['condition'] .= " AND status='$status' ";
    }


    $opts['order'] = "title ASC ";

    $opts['condition'] .= " ";

    $fetch_config = array('condition' => $opts['condition'],
        'order' => $opts['order'],
        'return_type' => "array");

    if (array_key_exists('debug', $opts)) {
      $fetch_config['debug'] = $opts['debug'];
    }


    if (array_key_exists('field', $opts) && $opts['field'] != '') {
      $fetch_config['field'] = $opts['field'];
    }

    if (array_key_exists('limit', $opts) && applyFilter('NUMERIC_GT_ZERO', $opts['limit']) > 0) {

      $fetch_config['limit'] = $opts['limit'];
    }
    if (array_key_exists('offset', $opts) && applyFilter('NUMERIC_WT_ZERO', $opts['offset']) != -1) {
      $fetch_config['start'] = $opts['offset'];
    }

    $result = $this->findAll("wps_district", $fetch_config);
    return $result;
  }

  public function get_city($opts = array()) {
    $status = $this->db->escape_str($this->input->get_post('status', TRUE));

    if (!array_key_exists('condition', $opts) || $opts['condition'] == '') {
      $opts['condition'] = "status !='2' ";
    } else {
      $opts['condition'] = "status !='2' " . $opts['condition'];
    }

    if ($status != '') {
      $opts['condition'] .= " AND status='$status' ";
    }


    $opts['order'] = "city ASC ";

    $opts['condition'] .= " ";

    $fetch_config = array('condition' => $opts['condition'],
        'order' => $opts['order'],
        'return_type' => "array");

    if (array_key_exists('debug', $opts)) {
      $fetch_config['debug'] = $opts['debug'];
    }


    if (array_key_exists('field', $opts) && $opts['field'] != '') {
      $fetch_config['field'] = $opts['field'];
    }

    if (array_key_exists('limit', $opts) && applyFilter('NUMERIC_GT_ZERO', $opts['limit']) > 0) {

      $fetch_config['limit'] = $opts['limit'];
    }
    if (array_key_exists('offset', $opts) && applyFilter('NUMERIC_WT_ZERO', $opts['offset']) != -1) {
      $fetch_config['start'] = $opts['offset'];
    }
    $result = $this->findAll("wps_cities_list", $fetch_config);
    return $result;
  }


}

// model end here