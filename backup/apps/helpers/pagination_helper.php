<?php
defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * The Pagination helper cuts out some of the bumf of normal pagination
 * @author		Philip Sturgeon
 * @filename	pagination_helper.php
 * @title		Pagination Helper
 * @version	1.0
 * */
function front_pagination($base_uri, $total_rows, $record_per = NULL, $uri_segment) {
  $ci = CI();
  $ci->load->library('Front_pagination');
  /* Initialize pagination */
  $config['per_page'] = $record_per === NULL ? $ci->config->item('per_page') : $record_per;
  $config['num_links'] = 8;
  $config['next_link'] = 'Next';
  $config['prev_link'] = 'Prev';

  $config['cur_tag_open'] = '<a href="#" class="active">';
  $config['cur_tag_close'] = '</a>';
  $config['next_tag_open'] = '';
  $config['next_tag_close'] = '';
  $config['prev_tag_open'] = '';
  $config['prev_tag_close'] = '';
  $config['num_tag_open'] = '';
  $config['num_tag_close'] = '';

  $config['base_url'] = base_url() . $base_uri;

  $config['total_rows'] = $total_rows;
  $config['uri_segment'] = $uri_segment;
  $config['page_query_string'] = FALSE;
  $config['additional_param'] = 'serialize_form()';
  $config['div'] = '#my_data';
  $ci->front_pagination->initialize($config);
  $data = $ci->front_pagination->create_links();
  return $data;
}

if (!function_exists('dashboard_pagination')) {

  function dashboard_pagination($base_uri, $total_rows, $record_per, $uri_segment, $refresh = FALSE) {
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


if (!function_exists('more_paging')) {

  function more_paging($base_uri, $total_rows, $record_per = NULL, $next = 0, $options = array()) {

    $text = array_key_exists('text', $options) ? $options['text'] : 'View More';
    $start_tag = array_key_exists('start_tag', $options) ? $options['start_tag'] : '';
    $end_tag = array_key_exists('end_tag', $options) ? $options['end_tag'] : '';
    $more_container = array_key_exists('more_container', $options) ? $options['more_container'] : 'more_data';
    $form_id = array_key_exists('form_id', $options) ? $options['form_id'] : '0';

    if ($record_per != NULL) {

      $base_uri = base_url() . $base_uri;

      if ($total_rows > $record_per && $next < $total_rows) {
        $more_link = '<a href="javascript:void(0)" class="anchr" id="more_loader_link' . $more_container . '" onclick="load_more(\'' . $base_uri . '\',\'' . $more_container . '\',\'' . $form_id . '\');">';
        $more_link.=$start_tag;
        $more_link.=$text;
        $more_link.=$end_tag;
        $more_link.='</a>';

        return $more_link;
      }
      if ($total_rows > $record_per && $next >= $total_rows) {
        $more_link = $start_tag;
        $more_link.='<div style="margin-top:8px; text-align:center;">no more record(s) found</div>';
        $more_link.=$end_tag;

        return $more_link;
      }
    }
  }

}


if (!function_exists('pagination_refresh')) {

  function pagination_refresh($base_uri, $total_rows, $record_per, $uri_segment) {
    $ci = CI();
    $config['full_tag_open'] = '<ul id="pagin">';
    $config['full_tag_close'] = '</ul>';
    $config['per_page'] = $record_per;
    $config['num_links'] = 8;
    $config['next_link'] = 'Next';
    $config['prev_link'] = 'Prev';
    $config['total_rows'] = $total_rows;
    $config['uri_segment'] = $uri_segment;
    $ci->load->library('pagination');
    $config['cur_tag_open'] = '<a href="#" class="act">';
    $config['cur_tag_close'] = '</a>';
    $config['next_tag_open'] = '';
    $config['next_tag_close'] = '';
    $config['prev_tag_open'] = '';
    $config['prev_tag_close'] = '';
    $config['last_tag_open'] = '';
    $config['last_tag_close'] = '';

    $config['num_tag_open'] = '';
    $config['num_tag_close'] = '';
    $config['page_query_string'] = TRUE;
    $config['base_url'] = $base_uri;
    $ci->pagination->initialize($config);
    $data = $ci->pagination->create_links();

    return $data;
  }

}

function front_record_per_page($per_page_id, $name = 'per_page') {
  $ci = CI();
  $post_per_page = $ci->input->get_post($name);
  ?>
  <select  name="<?php echo $name; ?>" id="<?php echo $per_page_id; ?>"  class="w120p fs11 txtbox" >
    <?php
    foreach ($ci->config->item('frontPageOpt') as $val) {
      ?>
      <option value="<?php echo $val; ?>" <?php echo $post_per_page == $val ? "selected" : ""; ?>>
        <?php echo $val; ?> Records</option>
      <?php
    }
    ?>
  </select>

  <?php
}

function display_record_per_page() {
  $ci = CI();
  $post_per_page = $ci->input->get_post('pagesize');
  ?>
  <select name="pagesize" id="pagesize" class="form-control" style="width:25%;">
    <?php
    foreach ($ci->config->item('adminPageOpt') as $val) {
      ?>
      <option value="<?php echo $val; ?>" <?php echo $post_per_page == $val ? "selected" : ""; ?>><?php echo $val; ?></option>
      <?php
    }
    ?>
  </select>
  <?php
}

?>