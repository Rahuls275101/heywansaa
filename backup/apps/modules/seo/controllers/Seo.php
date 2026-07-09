<?php

Class Seo extends CI_Controller {

  public function __construct() {

    parent::__construct();
    $this->load->helper(array('xml', 'seo/seo'));
  }

  public function sitemap() {
    $this->db->select('page_url');
    $res = $this->db->get_where('wps_meta_tags', array())->result_array();
    $xml_data = array();
    if (is_array($res) && !empty($res)) {
      foreach ($res as $key => $val) {
        array_push($xml_data, $val['page_url']);
      }
    }
    $data['result'] = $xml_data;
    header("Content-Type: text/xml;charset=iso-8859-1");
    $this->load->view("seo/sitemap", $data);
  }

  public function create_seo_url() {
    $msg_arr = array();
    $rec_id = (int) $this->input->post('rec_id');
    $pg_title = $this->input->post('title', TRUE);
    $pg_title = str_replace(base_url(), "", $pg_title);
    $pre_title = $this->input->post('pre_title', TRUE);
    $pre_title = str_replace(base_url(), "", $pre_title);
    $pg_title = seo_url_title($pg_title);

    if ($pre_title != '') {

      $friendly_url = $pre_title . $pg_title;
    } else {
      $friendly_url = $pg_title;
    }
    $this->db->select('meta_id');
    $this->db->from('wps_meta_tags');
    $this->db->where('page_url', $friendly_url);
    if ($rec_id > 0) {
      $this->db->where('entity_id !=', $rec_id);
    }
    $meta_qry = $this->db->get();

    if ($meta_qry->num_rows() > 0) {
      $msg_arr['error'] = 1;
      $msg_arr['msg'] = 'URL already exists';
    } else {
      $msg_arr['error'] = 0;
      $msg_arr['msg'] = 'URL passed';
    }
    $msg_arr['friendly_name'] = $pg_title;
    echo json_encode($msg_arr);
  }

}
