<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Category_model extends MY_Model {

  public function __construct() {
    parent::__construct();
  }

  public function getcategory($opts = array()) {
    $keyword = trim($this->input->get_post('keyword', TRUE));
    $keyword = $this->db->escape_str($keyword);
    $search = @$opts['keyword'];
    $status = $this->db->escape_str($this->input->get_post('status', TRUE));

    if (!array_key_exists('condition', $opts) || $opts['condition'] == '') {
      $opts['condition'] = "status !='2' ";
    } else {
      $opts['condition'] = "status !='2' " . $opts['condition'];
    }

    if ($keyword != '') {
      $opts['condition'] .= " AND category_name like '%" . $keyword . "%'";
    }
    if ($search != '') {
      $opts['condition'] .= " AND category_name like '%" . $search . "%'";
    }

    if ($status != '') {
      $opts['condition'] .= " AND status='$status' ";
    }


    $opts['order'] = "sort_order ASC";

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

//    trace($fetch_config);exit;//
    $result = $this->findAll('wps_categories as a', $fetch_config);
//      trace($result);die;
    return $result;
  }

  public function get_category_by_id($id) {
    $id = applyFilter('NUMERIC_GT_ZERO', $id);

    if ($id > 0) {
      $condtion = "status !='2' AND category_id=$id";
      $fetch_config = array(
          'condition' => $condtion,
          'debug' => FALSE,
          'return_type' => "array"
      );
      $result = $this->find('wps_categories', $fetch_config);
      return $result;
    }
  }

  public function add_bulk_upload_category($worksheet) {
    for ($i = 2; $i <= count($worksheet); $i++) {
      $parentId = (!isset($worksheet[$i][1])) ? '' : addslashes(trim($worksheet[$i][1]));      
      $categoryName = (!isset($worksheet[$i][2])) ? '' : addslashes(trim($worksheet[$i][2]));
      $seo_url = seo_url_title($categoryName);
      
      $posted_data = array(
          'category_name' => $categoryName,
          'category_alt' => $categoryName,
          'category_description' => '',
          'parent_id' => $parentId,
          'friendly_url' => $seo_url,
          'date_added' => $this->config->item('config.date.time'),
          'category_image' => '',
      );
      $this->db->insert('wps_categories', $posted_data);
      $categoryId = $this->db->insert_id();
      $redirect_url = "category/index";
      $meta_array = array(
          'entity_type' => $redirect_url,
          'entity_id' => $categoryId,
          'page_url' => $seo_url,
          'meta_title' => $categoryId,
          'meta_description' => $categoryId,
          'meta_keyword' => $categoryId
      );
      create_meta($meta_array);
    }
    return true;
  }

}

// model end here