<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
if (!function_exists('get_banner')) {

  function get_banner($cond = array(), $limit) {
    $ci = &get_instance();
    $position = @$cond['position'];
    if ($position != '') {
      $ci->db->where('banner_position', $position);
    }
    $ci->db->where('banner_end_date >= ', date('Y-m-d'));

    $ci->db->where('status', '1');
    $ci->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
    $ci->db->order_by('banner_id', 'random');
    $ci->db->limit($limit, '0');
    $ci->db->from('wps_banners');
    $result = $ci->db->get();
    //echo_sql();
    if ($result->num_rows() > 0) {
      return $result->result_array();
    }
  }

}

function banner_display($cond, $w = 50, $h = 50, $class = '', $prefix = "", $suffix = "", $limit = "") {
  $flag = FALSE;
  $banner = get_banner($cond, $limit);
  if (is_array($banner) && !empty($banner)) {

    $i = 0;
    $banner_path = base_url() . 'uploaded-files/banner/';
    foreach ($banner as $key_ban => $val_ban) {
      //echo get_image('advertise',$val_ban['banner_image'],240,90,'width','R');
      echo $prefix;
      if ($val_ban['banner_image'] != "" && file_exists(UPLOAD_DIR . "/banner/" . $val_ban['banner_image'])) {
        if ($val_ban['type'] > 0) {
          if ($val_ban['type'] == '1') {
            $type = 'latest';
          } elseif ($val_ban['type'] == '2') {
            $type = 'best-seller';
          } elseif ($val_ban['type'] == '3') {
            $type = 'popular';
          } elseif ($val_ban['type'] == '4') {
            $type = 'new-arrival';
          }
          ?>
          <a href="<?php echo site_url() . $type; ?>" target="_blank">
            <?php
          }
          ?>
          <img src="<?php echo $banner_path . $val_ban['banner_image']; ?>" width="<?php echo $w; ?>" height="<?php echo $h; ?>" class="<?php echo $class; ?>" />
          <?php
          if ($val_ban['type'] > 0) {
            ?>
          </a>
          <?php
        }
      }
      echo $suffix;
      $i++;
    }
  } else {
    $flag = TRUE;
  }
  return $flag;
}

if (!function_exists('get_banner_positions_array')) {

  function get_banner_positions_array($banner_section = NULL) {
    $ci = &get_instance();

    $postions_arr = array();

    $position_key_arr = array();

    $conf_ban_postions = $ci->config->item('bannersz');  // List Of All Positions


    $ban_section_positions = $ci->config->item('banner_section_positions');  // List of section key and postions array key mapped

    if (!empty($banner_section)) {

      if (array_key_exists($banner_section, $ban_section_positions)) {
        $position_key_arr = $ban_section_positions[$banner_section];

        if (count($position_key_arr) > 0) {
          foreach ($position_key_arr as $postion_key) {
            if (array_key_exists($postion_key, $conf_ban_postions)) {
              $postions_arr[$postion_key] = $postion_key . " &raquo; Best banner Size " . $conf_ban_postions[$postion_key];
            }
          }
        }
      }
    } else {

      $postions_arr = $conf_ban_postions;

      if (count($postions_arr) > 0) {
        foreach ($postions_arr as $postion_key => $position_val) {

          $postions_arr[$postion_key] = $postion_key . " &raquo; Best banner Size " . $position_val;
        }
      }
    }

    return $postions_arr;
  }

}
if (!function_exists('banner_postion_drop_down')) {

  function banner_postion_drop_down($name = '', $default_sel = '', $ban_section = NULL, $extra = '') {
    //echo $extra;
    $html = '';
    $banner_postions = array();
    $ci = &get_instance();

    if (!empty($ban_section)) {

      $banner_postions = get_banner_positions_array($ban_section);
    } else {
      $banner_postions = get_banner_positions_array();
    }

    $html = custom_drop_down($name, $banner_postions, $default_sel, $extra, TRUE, 'Select Position');
    echo $html;
  }

}
?>