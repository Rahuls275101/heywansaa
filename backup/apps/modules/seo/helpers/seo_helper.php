<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

  function locationName($loc) {
    $ci = CI();
    $cnt = $ci->db->select('id')->from('wps_countries_list')->where("name = '" . $loc . "'")->get()->num_rows();
    if ($cnt > 0) {
      return get_db_field_value('wps_countries_list', 'name', "WHERE country_temp_name = '" . $loc . "'");
    } else {
      $cnt = $ci->db->select('id')->from('wps_states_list')->where("temp_title = '" . $loc . "'")->get()->num_rows();
      if ($cnt > 0) {
        return get_db_field_value('wps_states_list', 'name', "WHERE temp_title = '" . $loc . "'");
      } else {
        $cnt = $ci->db->select('id')->from('wps_cities_list')->where("temp_title = '" . $loc . "'")->get()->num_rows();
        if ($cnt > 0) {
          return get_db_field_value('wps_cities_list', 'city', "WHERE temp_title = '" . $loc . "'");
        }
      }
    }
  }

if (!function_exists('getMeta')) {

  function getMeta() {
    $ci = CI();
    $ci->load->config('seo/config');
    $uri_page = $ci->uri->uri_string != '' ? $ci->uri->uri_string : "home";
    //Check if it is subdomain

    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/', $uri_path);
    $st = $uri_segments[2];
    if (strstr($st, '.html')) {
      $st = substr($st, 0, -5);
    }
    $locName = locationName($st);
    //Check if in subdomain
    $stArray = $ci->db->query("SELECT meta_id, page_url FROM wps_meta_tags WHERE is_fixed='L' AND page_url='" . $st . "'")->row_array();
    if (is_array($stArray) & !empty($stArray)) {
      $uri_page = $ci->uri->uri_string != '' ? $ci->uri->uri_string : "home";
      $uri_page = str_replace($uri_segments[1], '', $uri_page);
      $uri_page = trim($uri_page, '/');
      $urlSegment = $uri_page;
      $res = $ci->db->query("SELECT * FROM wps_meta_tags WHERE page_url='" . $st . "' ")->row();
      $location = $uri_page;
      if (is_object($res)) {
        //print_r($res);
        $uri_aligs_string_product = str_replace($st, '', $uri_page);
        $uri_aligs_string_product = trim($uri_aligs_string_product, '/');
        //echo $uri_aligs_string_product;
        //get url Id
        $respro = $ci->db->query("SELECT * FROM wps_meta_tags WHERE page_url='" . $uri_aligs_string_product . "' ")->row();
        //trace($respro);
        if (is_object($respro) && !empty($respro)) {
          $resprosub = $ci->db->query("SELECT * FROM wps_subcontent WHERE status = '1' AND FIND_IN_SET($respro->entity_id,category_id)")->row();
          if (is_object($resprosub) && !empty($resprosub)) {
            $catlink = get_parent_categories($respro->entity_id);
            $catArray = array_reverse($catlink);
            //trace($catArray);
            //get cat name
            $catName = "";
            if ($respro->entity_type == 'category/index') {
              $catName = get_db_field_value('wps_categories', 'category_name', "WHERE category_id = '" . $respro->entity_id . "'");
            }
            $locId = get_db_field_value("wps_meta_tags", "meta_id", "WHERE page_url = '" . $st . "'");
            $resprosubloc = $ci->db->query("SELECT * FROM wps_subcontent WHERE status = '1' AND FIND_IN_SET($respro->entity_id,category_id) AND FIND_IN_SET($locId,location_id)")->row();
            //trace($resprosubloc);
            //With location and category
            if (is_object($resprosubloc) && !empty($resprosubloc)) {//With location and category
              $key1 = "";
              $key2 = "";
              $key3 = "";
              return array(
                  "meta_title" => str_replace('{catname}', $catName, str_replace('{location}', $locName, str_replace('{key3}', $key3, str_replace('{key2}', $key2, str_replace('{key1}', $key1, $resprosubloc->meta_title))))),
                  "meta_keyword" => str_replace('{catname}', $catName, str_replace('{location}', $locName, str_replace('{key3}', $key3, str_replace('{key2}', $key2, str_replace('{key1}', $key1, $resprosubloc->meta_keyword))))),
                  "meta_description" => str_replace('{catname}', $catName, str_replace('{location}', $locName, str_replace('{key3}', $key3, str_replace('{key2}', $key2, str_replace('{key1}', $key1, $resprosubloc->meta_description))))),
                  "entity_type" => $respro->entity_type,
                  "entity_id" => $respro->entity_id,
                  "page_url" => $respro->page_url
              );
            } else {//With category only
              $key1 = "";
              $key2 = "";
              $key3 = "";
              return array(
                  "meta_title" => str_replace('{catname}', $catName, str_replace('{location}', $locName, str_replace('{key3}', $key3, str_replace('{key2}', $key2, str_replace('{key1}', $key1, $resprosub->meta_title))))),
                  "meta_keyword" => str_replace('{catname}', $catName, str_replace('{location}', $locName, str_replace('{key3}', $key3, str_replace('{key2}', $key2, str_replace('{key1}', $key1, $resprosub->meta_keyword))))),
                  "meta_description" => str_replace('{catname}', $catName, str_replace('{location}', $locName, str_replace('{key3}', $key3, str_replace('{key2}', $key2, str_replace('{key1}', $key1, $resprosub->meta_description))))),
                  "entity_type" => $respro->entity_type,
                  "entity_id" => $respro->entity_id,
                  "page_url" => $respro->page_url
              );
            }
          } else {
            $resprosubloc = $ci->db->query("SELECT * FROM wps_subloccontent WHERE status = '1' AND FIND_IN_SET($respro->meta_id,location_id)")->row();
            if (is_object($resprosubloc) && !empty($resprosubloc)) {
              return array(
                  "meta_title" => str_replace('{location}', $locName,  $resprosubloc->meta_title),
                  "meta_keyword" => str_replace('{location}', $locName, $resprosubloc->meta_keyword),
                  "meta_description" => str_replace('{location}', $locName, $resprosubloc->meta_description),
                  "entity_type" => $respro->entity_type,
                  "entity_id" => $respro->entity_id,
                  "page_url" => $respro->page_url
              );
            } else {
              $catName = "";
              //print_r($respro); die;
              if ($respro->entity_type == 'category/index') {
                $catName = get_db_field_value('wps_categories', 'category_name', "WHERE category_id = '" . $respro->entity_id . "'");
              }
              return array(
                  "meta_title" => str_replace('{catname}', $catName, str_replace('{location}', $locName, $respro->meta_title)),
                  "meta_keyword" => str_replace('{catname}', $catName, str_replace('{location}', $locName, $respro->meta_keyword)),
                  "meta_description" => str_replace('{catname}', $catName,str_replace('{location}', $locName, $respro->meta_description)),
                  "entity_type" => $respro->entity_type,
                  "entity_id" => $respro->entity_id,
                  "page_url" => $respro->page_url
              );
            }
          }
        } else {
          $resprosubloc = $ci->db->query("SELECT * FROM wps_subloccontent WHERE status = '1' AND FIND_IN_SET($res->meta_id,location_id)")->row();
          if (is_object($resprosubloc) && !empty($resprosubloc)) {
            return array(
                "meta_title" => str_replace('{location}', $locName, $resprosubloc->meta_title),
                "meta_keyword" => str_replace('{location}', $locName, $resprosubloc->meta_keyword),
                "meta_description" => str_replace('{location}', $locName, $resprosubloc->meta_description),
                "entity_type" => $res->entity_type,
                "entity_id" => $res->entity_id,
                "page_url" => $res->page_url
            );
          } else {
            $catName = "";
            if ($res->entity_type == 'category/index') {
              $catName = get_db_field_value('wps_categories', 'category_name', "WHERE category_id = '" . $res->entity_id . "'");
            }
            
            return array(
                "meta_title" => str_replace('{catname}', $catName, str_replace('{location}', $locName, $res->meta_title)),
                "meta_keyword" => str_replace('{catname}', $catName, str_replace('{location}', $locName, $res->meta_keyword)),
                "meta_description" => str_replace('{catname}', $catName,str_replace('{location}', $locName, $res->meta_description)),
                "entity_type" => $res->entity_type,
                "entity_id" => $res->entity_id,
                "page_url" => $res->page_url
            );
          }
        }
      } else {
        $uri_aligs_string = str_replace($st, '', $uri_page);
        $uri_aligs_string = trim($uri_aligs_string, '/');
        //check in database
        $res = $ci->db->query("SELECT * FROM wps_meta_tags WHERE page_url='" . $uri_aligs_string . "' ")->row();
        if (is_object($res)) {
          $catName = "";
          if ($res->entity_type == 'category/index') {
            $catName = get_db_field_value('wps_categories', 'category_name', "WHERE category_id = '" . $res->entity_id . "'");
          }
          return array(
              "meta_title" => str_replace('{catname}', $catName, str_replace('{location}', $locName, $res->meta_title)),
              "meta_keyword" => str_replace('{catname}', $catName, str_replace('{location}', $locName, $res->meta_keyword)),
              "meta_description" => str_replace('{catname}', $catName, str_replace('{location}', $locName, $res->meta_description)),
              "entity_type" => $res->entity_type,
              "entity_id" => $res->entity_id,
              "page_url" => $res->page_url
          );
        } else {
          return $ci->config->item('default_meta');
        }
      }
    }else{
      $uri_page = $ci->uri->uri_string != '' ? $ci->uri->uri_string : "home";

        $res = $ci->db->query("SELECT * FROM wps_meta_tags WHERE page_url='" . $uri_page . "'")->row();
      if ($ci->router->fetch_class() == 'category' || $ci->router->fetch_class() == 'products') {

        if ($ci->router->fetch_class() == 'category') {

          $nm = $nm1 = get_db_field_value("wps_categories", 'category_name', "WHERE category_id = '" . @$res->entity_id . "'");
          //$cat_head = get_db_field_value("wps_categories", 'category_heading', "WHERE category_id = '" . @$res->entity_id . "'");
          //$nm = ($cat_head!='')?$cat_head:$nm1;

          if (@$res->meta_title == '') {
            return array(
                "meta_title" => "$nm",
                "meta_keyword" => "$nm",
                "meta_description" => "$nm",
                "entity_type" => @$res->entity_type,
                "entity_id" => @$res->entity_id,
                "page_url" => @$res->page_url
            );
          } else {
            return array(
                "meta_title" => $res->meta_title,
                "meta_keyword" => $res->meta_keyword,
                "meta_description" => $res->meta_description,
                "entity_type" => $res->entity_type,
                "entity_id" => $res->entity_id,
                "page_url" => $res->page_url
            );
          }
        } else {

          if (isset($res->entity_id) && $res->entity_id > 0) {

            $nm = get_db_field_value("wps_products", 'product_name', "WHERE products_id = '" . $res->entity_id . "'");
            if (@$res->meta_title == '') {
                  return array(
                      "meta_title" => "$nm",
                      "meta_keyword" => "$nm",
                      "meta_description" => "$nm",
                      "entity_type" => @$res->entity_type,
                      "entity_id" => @$res->entity_id,
                      "page_url" => @$res->page_url
                  );
              } else {
                  return array(
                      "meta_title" => $res->meta_title,
                      "meta_keyword" => $res->meta_keyword,
                      "meta_description" => $res->meta_description,
                      "entity_type" => $res->entity_type,
                      "entity_id" => $res->entity_id,
                      "page_url" => $res->page_url
                  );
            }
          } else {

            return $ci->config->item('default_meta');
          }
        }
      } else {

        if (is_object($res) && !empty($res)) {

          return array(
              "meta_title" => $res->meta_title,
              "meta_keyword" => $res->meta_keyword,
              "meta_description" => $res->meta_description,
              "entity_type" => $res->entity_type,
              "entity_id" => $res->entity_id,
              "page_url" => $res->page_url
          );
        } else {

          return $ci->config->item('default_meta');
        }
      }
    }

    
  }

}


/* Check  meta url already exits  */
if (!function_exists('check_meta')) {

  function check_meta($page_url) {
    $num = 0;
    if ($page_url != '') {
      $ci = CI();
      $ci->db->from('wps_meta_tags');
      $ci->db->where(array('page_url' => $page_url));
      $num = $ci->db->count_all_results();
    }
    return $num;
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

/* * ***************** Making the Meta tags  much better  ************** */

if (!function_exists('clean')) {

  function clean($text) {
    $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
    $text = strip_tags($text); //erases any html markup
    $text = preg_replace('/\s\s+/', ' ', $text); //erase possible duplicated white spaces
    $text = str_replace(array('\r\n', '\n', '+'), ',', $text); //replace possible returns 
    return trim($text);
  }

}


if (!function_exists('get_text')) {

  function get_text($text, $length = 220) {
    return limit_chars(clean($text), $length, '', TRUE);
  }

}


if (!function_exists('limit_chars')) {

  function limit_chars($str, $limit = 100, $end_char = NULL, $preserve_words = FALSE) {
    $end_char = ($end_char === NULL) ? 'â€¦' : $end_char;

    $limit = (int) $limit;

    if (trim($str) === '' || strlen($str) <= $limit)
      return $str;

    if ($limit <= 0)
      return $end_char;

    if ($preserve_words === FALSE)
      return rtrim(mb_substr($str, 0, $limit)) . $end_char;

    // Don't preserve words. The limit is considered the top limit.
    // No strings with a length longer than $limit should be returned.
    if (!preg_match('/^.{0,' . $limit . '}\s/us', $str, $matches))
      return $end_char;

    return rtrim($matches[0]) . ((strlen($matches[0]) === strlen($str)) ? '' : $end_char);
  }

}

if (!function_exists('get_keywords')) {

  function get_keywords($text, $max_keys = 20) {
    $ci = CI();
    $ci->load->config('seo/config');
    $min_word_length = $ci->config->item('min_word_length');
    $banned_words = $ci->config->item('banned_words');
    //array to keep word->number of repetitions 
    $wordcount = array_count_values(str_word_count(clean($text), 1));

    foreach ($wordcount as $key => $value) {
      if ((strlen($key) <= $min_word_length) || in_array($key, $banned_words))
        unset($wordcount[$key]);
    }
    //sort keywords from most repetitions to less 
    uasort($wordcount, 'cmp');
    //keep only X keywords
    $wordcount = array_slice($wordcount, 0, $max_keys);
    //return keywords on a string
    return implode(', ', array_keys($wordcount));
  }

}

function imagealtTitle($pretext, $name, $posttext) {
  $ci = CI();
  //Check if it is subdomain
  $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $uri_segments = explode('/', $uri_path);
  $st = $uri_segments[2];
  if (strstr($st, '.html')) {
    $st = substr($st, 0, -5);
  }
  $stArray = $ci->db->query("SELECT meta_id, page_url FROM wps_meta_tags WHERE is_fixed='L' AND page_url='" . $st . "'")->row_array();
  if (is_array($stArray) & !empty($stArray)) {
    echo $pretext . ' ' . $name . ' ' . $posttext . 'in ' . ucwords(locationName($st));
  } else {
    echo $pretext . ' ' . $name . ' ' . $posttext;
  }
}