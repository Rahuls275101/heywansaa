<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

if (!function_exists('CI')) {

  function CI() {
    if (!function_exists('get_instance'))
      return FALSE;
    $CI = & get_instance();
    return $CI;
  }

}


if (!function_exists('admin_pagination')) {

  function admin_pagination($base_uri, $total_rows, $record_per, $uri_segment, $refresh = FALSE) {
    $ci = CI();
    $config['per_page'] = $record_per;
    $config['num_links'] = 8;
    $config['next_link'] = 'Next';
    $config['prev_link'] = 'Prev';
    $config['total_rows'] = $total_rows;
    $config['uri_segment'] = $uri_segment;
    $ci->load->library('pagination');
    $config['cur_tag_open'] = '&nbsp;<strong>';
    $config['cur_tag_close'] = '</strong>';
    $config['page_query_string'] = TRUE;
    $config['base_url'] = $base_uri;
    $ci->pagination->initialize($config);
    $data = $ci->pagination->create_links();

    return $data;
  }

}