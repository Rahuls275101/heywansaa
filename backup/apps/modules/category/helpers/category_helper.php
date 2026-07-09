<?php

if (!function_exists('has_child')) {

  function has_child($catid, $condtion = "AND status='1'") {
    $ci = CI();
    $sql = "SELECT category_id FROM wps_categories WHERE parent_id=$catid $condtion ";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    return $num_rows >= 1 ? TRUE : FALSE;
  }

}

if (!function_exists('get_child_categories')) {

  function get_child_categories($parent = '0', $condtion = "AND status='1'", $fields = 'SQL_CALC_FOUND_ROWS*') {
    $parent = (int) $parent;
    $ci = CI();
    $output = array();
    $sql = "SELECT  $fields FROM wps_categories WHERE parent_id=$parent $condtion  ";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      foreach ($query->result_array() as $row) {
        $output[$row['category_id']]['parent'] = $row;
        $output[$row['category_id']]['child'] = array();
        if (has_child($row['category_id'])) {
          $output[$row['category_id']]['child'] = get_child_categories($row['category_id'], $condtion, $fields);
        }
      }
    }
    return $output;
  }

}

if (!function_exists('get_parent_categories')) {

  function get_parent_categories($category_id, $condtion = "AND status='1'", $fields = '*') {
    $category_id = (int) $category_id;
    $ci = CI();
    $output = array();
    $sql = "SELECT $fields FROM wps_categories WHERE category_id=$category_id $condtion  ";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      foreach ($query->result_array() as $row) {
        $parent_id = $row['parent_id'];
        $output[$row['category_id']] = $row;
        while ($parent_id > 0) {
          $sql = "SELECT $fields FROM wps_categories WHERE category_id=$parent_id $condtion  ";
          $query = $ci->db->query($sql);
          $num_rows = $query->num_rows();
          if ($num_rows > 0) {
            foreach ($query->result_array() as $row) {
              $parent_id = $row['parent_id'];
              $output[$row['category_id']] = $row;
            }
          } else {
            $parent_id = 0;
          }
        }
      }
    }
    return $output;
  }

}

if (!function_exists('changeCategoryStatus')) {

  function changeCategoryStatus($parent) {
    $ci = CI();
    $sql = "SELECT * FROM wps_categories WHERE parent_id='" . $parent . "' AND status='1' ";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      foreach ($query->result_array() as $row) {
        if (has_child($row['category_id'])) {
          $ci->db->query("UPDATE wps_categories SET status = '0' WHERE category_id = '" . $row['category_id'] . "'");
          changeCategoryStatus($row['category_id']);
        } else {
          $ci->db->query("UPDATE wps_categories SET status = '0' WHERE category_id = '" . $row['category_id'] . "'");
        }
      }
    }
  }

}

if (!function_exists('get_nested_dropdown_menu')) {

  function get_nested_dropdown_menu($parent, $selectId = "", $pad = "|__") {
    $ci = CI();
   
    $selId = ( $selectId != "" ) ? $selectId : "";
    $var = "";
    $sql = "SELECT * FROM wps_categories WHERE parent_id=$parent AND status='1' ";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      foreach ($query->result_array() as $row) {
        $category_name = ucfirst(strtolower($row['category_name']));
        if (has_child($row['category_id'])) {
          $var .= '<optgroup label="' . $pad . '&nbsp;' . $category_name . '" >' . $category_name . '</optgroup>';
          $var .= get_nested_dropdown_menu($row['category_id'], $selId, '&nbsp;&nbsp;&nbsp;' . $pad);
        } else {
          $sel = (in_array($row['category_id'], explode(',',implode(',', $selectId)))) ? "selected='selected'" : "";
          $var .= '<option value="' . $row['category_id'] . '" ' . $sel . '>' . $pad . $category_name . '  </option>';
        }
      }
    }
    return $var;
  }

}

if (!function_exists('get_nested_dropdown_menu_sub')) {

  function get_nested_dropdown_menu_sub($parent, $selectId = "", $pad = "|__") {
    $ci = CI();
    $selId = ( $selectId != "" ) ? $selectId : "";
    $var = "";
    $sql = "SELECT * FROM wps_categories WHERE parent_id=$parent AND status='1' ";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      foreach ($query->result_array() as $row) {
        $category_name = ucfirst(strtolower($row['category_name']));
        if (has_child($row['category_id'])) {
          $sel = (in_array($row['category_id'], explode(',', $selectId))) ? "selected='selected'" : "";
          $var .= '<option value="' . $row['category_id'] . '" ' . $sel . ' >' . $pad . $category_name . '</option>';
          $var .= get_nested_dropdown_menu_sub($row['category_id'], $selId, '&nbsp;&nbsp;&nbsp;' . $pad);
        } else {
          $sel = (in_array($row['category_id'], explode(',', $selectId))) ? "selected='selected'" : "";
          $var .= '<option value="' . $row['category_id'] . '" ' . $sel . '>' . $pad . $category_name . '  </option>';
        }
      }
    }
    return $var;
  }

}


if (!function_exists('count_category')) {

  function count_category($condtion = '') {
    $ci = CI();
    $condtion = "status ='1' " . $condtion;
    $sql = "SELECT COUNT(category_id)  AS total_subcategories FROM wps_categories WHERE $condtion ";
    $query = $ci->db->query($sql)->row_array();
    return $query['total_subcategories'];
  }

}


if (!function_exists('count_products')) {

  function count_products($condtion = '') {
    $ci = CI();
    $condtion = "status ='1' " . $condtion;
    $sql = "SELECT COUNT(products_id)  AS total_product FROM wps_products WHERE $condtion ";
    $query = $ci->db->query($sql)->row_array();
    return $query['total_product'];
  }

}

if (!function_exists('category_breadcrumbs')) {

  function category_breadcrumbs($catid, $segment = '') {
    $link_cat = array();
    $ci = CI();
    $sql = "SELECT category_name,category_id,parent_id,friendly_url
		FROM wps_categories WHERE category_id='$catid' AND status='1' ";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    $segment = $ci->uri->segment($segment, 0);

    if ($num_rows > 0) {
      foreach ($query->result_array() as $row) {
        if (has_child($row['parent_id'])) {
          $condtion_product = "AND category_id='" . $row['category_id'] . "'";
          $product_count = count_products($condtion_product);
          $catID = (int) $ci->meta_info['entity_id'];
          $catType = $ci->meta_info['entity_type'];
          if ($product_count > 0) {
            $link_url = site_url($row['friendly_url']);
          } else {
            $link_url = site_url($row['friendly_url']);
          }
          if (($segment != '' && ( $row['category_id'] == $segment) || ($catID == $row['category_id']) && $catType != 'products/detail')) {
            $link_cat[] = '<li class="active">' . $row['category_name'] . '</li>';
          } else {
            $link_cat[] = '<li><a href="' . $link_url . '" title="' . $row['category_name'] . '"> ' . $row['category_name'] . ' </a></li>';
          }
          $link_cat[] = category_breadcrumbs($row['parent_id'], $segment);
        } else {

          $link_url = site_url($row['friendly_url']);
          $link_cat[] = '<li><a href="' . $link_url . '" title="' . $row['category_name'] . '"> ' . $row['category_name'] . ' </a></li>';
        }
      }
    } else {
      //check if sub-domain
      $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      $uri_segments = explode('/', $uri_path);
      $st = $uri_segments[1];
      if (strstr($st, '.html')) {
        $st = substr($st, 0, -5);
      }
      $stArray = $ci->db->query("SELECT page_url FROM wps_meta_tags WHERE is_fixed='L' AND page_url='" . $st . "'")->row_array();
      //End Here
      if (is_array($stArray) & !empty($stArray)) {
        $lcname = locationName($st);
        $link_url_sub = base_url() . $st;
       // $link_cat[] = '<li><a href="' . $link_url_sub . '" title="' . $lcname . '"> ' . $lcname . ' Directory </a></li>';
      } else {
        $link_url = base_url() . "directory";
        //$link_cat[] = '<li><a href="' . $link_url . '" title="Category Lists"> Directory </a></li>';
      }
    }
    $link_cat = array_reverse($link_cat);
    $var = implode($link_cat);
    return $var;
  }

}

if (!function_exists('category_breadcrumbs_admin')) {

  function category_breadcrumbs_admin($catid, $segment = '') {
    $link_cat = array();
    $ci = CI();
    $sql = "SELECT category_name,category_id,parent_id,friendly_url
		FROM wps_categories WHERE category_id='$catid' AND status='1' ";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    $segment = $ci->uri->segment($segment, 0);

    if ($num_rows > 0) {
      foreach ($query->result_array() as $row) {
        if (has_child($row['parent_id'])) {
          $condtion_product = "AND category_id='" . $row['category_id'] . "'";
          $product_count = count_products($condtion_product);
          $catID = (int) $ci->meta_info['entity_id'];
          $catType = $ci->meta_info['entity_type'];
          $link_url = base_url() . "wps-admin/category/index/" . $row['category_id'];

          if (($segment != '' && ( $row['category_id'] == $segment) || ($catID == $row['category_id']) && $catType != 'products/detail')) {
            $link_cat[] = '<li class="breadcrumb-item"><strong>' . $row['category_name'] . '</strong></li>';
          } else {
            $link_cat[] = '<li class="breadcrumb-item"><a href="' . $link_url . '" title="' . $row['category_name'] . '"> ' . $row['category_name'] . ' </a></li>';
          }
          $link_cat[] = category_breadcrumbs_admin($row['parent_id'], $segment);
        } else {

          $link_url = "javascript:void(0);";
          $link_cat[] = '<li class="breadcrumb-item"><a href="' . $link_url . '" title="' . $row['category_name'] . '"> ' . $row['category_name'] . ' </a></li>';
        }
      }
    } else {
      $link_url = base_url() . "wps-admin/category";
      $link_cat[] = '<li class="breadcrumb-item"><a href="' . $link_url . '" title="Category Lists"> Category Lists </a></li>';
    }
    $link_cat = array_reverse($link_cat);
    $var = implode($link_cat);
    return $var;
  }

}


if (!function_exists('category_breadcrumbs_left')) {

  function category_breadcrumbs_left($catid, $segment = '', $parent = '') {
    $link_cat = array();
    $ci = CI();
    $sql = "SELECT category_name,category_id,parent_id,friendly_url
		FROM wps_categories WHERE category_id='$catid' AND status='1' ";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    $segment = $ci->uri->segment($segment, 0);
    if ($num_rows > 0) {
      foreach ($query->result_array() as $row) {
        if (has_child($row['parent_id'])) {
          $condtion_product = "AND category_id='" . $row['category_id'] . "'";
          $product_count = count_products($condtion_product);
          if ($product_count > 0) {
            $link_url = base_url() . $row['friendly_url'];
          } else {
            $link_url = base_url() . $row['friendly_url'];
          }
          if ($catid != '' && ($catid == $row['category_id']) && $parent == "") {
            $link_cat[] = '<p class="mt5 ml15"><a class="b" href=' . $link_url . '>- ' . $row['category_name'] . '</a></p>';
          } else {
            $link_cat[] = '<a class="act" href=' . $link_url . '>' . $row['category_name'] . '</a>';
          }
          $link_cat[] = category_breadcrumbs_left($row['parent_id'], $segment, 'no');
        } else {
          $link_url = base_url() . $row['friendly_url'];
          $link_cat[] = '<a class="act" href=' . $link_url . '>' . $row['category_name'] . '</a>';
        }
      }
    }
    $link_cat = array_reverse($link_cat);
    $var = implode($link_cat);
    return $var;
  }

}


if (!function_exists('category_sub')) {

  function category_sub($parent) {
    $ci = CI();
    $record_count = '';
    $p = $ci->db->query("SELECT COUNT(*) AS ccount FROM  wps_categories WHERE parent_id='$parent' && status='1'");
    $rsrow = $p->row();
    if ($rsrow->ccount > 0) {
      $q = "select category_id from wps_categories where parent_id=" . $parent . " && status='1'";
      $rs = mysql_query($q);
      while ($rd = mysql_fetch_object($rs)) {
        $record_count .= category_sub($rd->category_id) . ',';
      }
    }
    $record_count .= $parent;
    return $record_count;
  }

}

if (!function_exists('getTopParentIDArray')) {

  function getTopParentIDArray($catid) {
    $CI = CI();
    $catParentsArray = array();
    $flag = 0;
    $catparent = $catid;
    while ($flag != 1) {
      $selquery = "SELECT category_id,parent_id FROM wps_categories WHERE category_id='" . $catparent . "'";
      $categoryRes = $CI->db->query($selquery)->row_array();

      if ($categoryRes['parent_id'] != 0) {
        $catparent = $categoryRes['parent_id'];
        $catParentsArray[] = $categoryRes['category_id'];
      } else {
        if ($categoryRes['category_id'] != "") {
          $catParentsArray[] = $categoryRes['category_id'];
        }
        $flag = 1;
      }
    }
    return $catParentsArray;
  }

}


if (!function_exists('get_nested_dropdown_menu_dash')) {

  function get_nested_dropdown_menu_dash($parent, $selectId = "", $pad = "") {
    $ci = CI();
    $selId = ( $selectId != "" ) ? $selectId : "";
    $var = "";
    $sql = "SELECT * FROM wps_categories WHERE parent_id=$parent AND status='1' ";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      foreach ($query->result_array() as $row) {
        $category_name = ucfirst(strtolower($row['category_name']));
        if (has_child($row['category_id'])) {
          //$var .= '<div '.$pad.'"><p style="font-size:13px; padding:5px; color:#000;">' . $category_name . '</p>';
          $var .= get_nested_dropdown_menu_dash($row['category_id'], $selId, 'style="margin-left:10px;"');
        } else {
          $sel = (in_array($row['category_id'], explode(',', $selectId))) ? "checked='checked'" : "";

          $var .= '<div class="input-field col s4" style="margin-bottom:20px;"><label style="left:0px!important;" class="containerdash">' . $category_name . '<input required type="checkbox" value="' . $row['category_id'] . '" ' . $sel . '  name="category_id"></label></div>';
        }
      }
    }
    return $var;
  }


  


}


// created by Raaz

if (!function_exists('get_catebory_name_by_cat_id')) {

  function get_catebory_name_by_cat_id($parent) {
    $ci = CI();
    $var = "";
    $sql = "SELECT * FROM wps_categories WHERE category_id=$parent AND status='1' ";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      foreach ($query->result_array() as $row) {
        $var = ucfirst(strtolower($row['category_name']));
        
      }
    }
    return $var;
  }


  


}