<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 * The global CI helpers 
 */
/* For Vimeo */
use Vimeo\Vimeo;
use Vimeo\Exceptions\VimeoUploadException;

/* End Vimeo */

if (!function_exists('CI')) {

  function CI() {
    if (!function_exists('get_instance'))
      return FALSE;
    $CI = &get_instance();
    return $CI;
  }

}

function delivery_charge($total_shipping,$total_amount)
{
    if($total_amount > 2000){
        $delivery_amount = '0';
    }else{
        $delivery_amount = $total_shipping;
    }
    return $delivery_amount;
   
}

function gst($total_amount)
{
    $gst = $total_amount * (18/100);
    return round($gst); 
}

if (!function_exists('getDateFormat')) {

  function getDateFormat($date, $format, $seperator1 = ",") {
    switch ($format) {
      case 1: // (Ymd)->(dmY) 06 Dec, 2010 
        $arr_date = explode($seperator1, $date);
        $arr_date = strtotime($arr_date[0]);
        $ret_date = date("d M" . $seperator1 . " Y", $arr_date);
        break;

      case 2: // (Ymd)->(dmY) 06 December, 2010
        $arr_date = explode($seperator1, $date);
        $arr_date = strtotime($arr_date[0]);
        $ret_date = date("d F" . $seperator1 . " Y", $arr_date);
        break;

      case 3: // (Ymd)->(dmY) Mon Dec 06, 2010 
        $arr_date = explode($seperator1, $date);
        $arr_date = strtotime($arr_date[0]);
        $ret_date = date("D M d" . $seperator1 . " Y", $arr_date);
        break;

      case 4: // (Ymd)->(dmY) Monday December 06, 2010 
        $arr_date = explode($seperator1, $date);
        $arr_date = strtotime($arr_date[0]);
        $ret_date = date("l F d" . $seperator1 . " Y", $arr_date);
        break;

      case 5: // (Ymd)->(dmY) Monday December 06, 2010, 03:04:00 
        $arr_time1 = explode(" ", $date);
        $arr_date = strtotime($date);
        $ret_date = date("l F d" . $seperator1 . " Y" . $seperator1 . " h:i:s", $arr_date);
        break;

      case 6: // (Ymd)->(dmY) Monday December 06, 2010, 15:03:PM 
        $arr_time1 = explode(" ", $date);
        $arr_date = strtotime($date);
        $ret_date = date("l F d" . $seperator1 . " Y" . $seperator1 . "h:i:A", $arr_date);
        break;

      case 7: // (Ymd)->(dmY) Monday December 06, 2010, 15:03:PM 
        $arr_time1 = explode(" ", $date);
        $arr_date = strtotime($date);
        $ret_date = date("d M" . $seperator1 . " Y" . $seperator1 . " H:i:A", $arr_date);
        break;

      case 8: // (Ymd)->(dmY) Monday December 06, 2010, 03:04:00 
        $arr_time1 = explode(" ", $date);
        $arr_date = strtotime($date);
        $ret_date = date("d M" . $seperator1 . " Y" . $seperator1 . " h:i", $arr_date);
        break;
      case 9: // (Ymd)->(dmY) Monday December 06, 2010 
        $arr_date = explode($seperator1, $date);
        $arr_date = strtotime($arr_date[0]);
        $ret_date = date("M d" . $seperator1 . " Y", $arr_date);
        break;
      case 10: // (Ymd)->(dmY) Monday December 06, 2010 
        $arr_date = explode($seperator1, $date);
        $arr_date = strtotime($arr_date[0]);
        $ret_date = date("M d" . $seperator1 . " Y [l]", $arr_date);
        break;
      case 11: // (Ymd)->(dmY) Monday December 06, 2010 
        $arr_date = explode($seperator1, $date);
        $arr_date = strtotime($arr_date[0]);
        $ret_date = date("d-M-Y", $arr_date);
        break;
    }
    return $ret_date;
  }

}

function getArrayValueBykey($arr1, $arr2) {
  $res = array();
  if (is_array($arr1) && is_array($arr2)) {
    foreach ($arr1 as $key => $val) {
      if ($val != "") {
        $res[] = $arr2[$val];
      }
    }
  }
  return $res;
}

if (!function_exists('getAge')) {

  function getAge($dob) {
    $age = 31536000;  //days secon 86400X365
    $birth = strtotime($dob); // Start as time
    $current = strtotime(date('Y')); // End as time
    if ($current > $birth) {
      $finalAge = round(($current - $birth) / $age) + 1;
    }
    return $finalAge;
  }

}



if (!function_exists('check_spam_words')) {

  function check_spam_words($spam_word_arr, $in_string) {
    $is_spam_found = false;
    if (is_array($spam_word_arr) && $in_string != "") {
      foreach ($spam_word_arr as $val) {
        if (preg_match("/\b$val\b/i", $in_string)) {
          $is_spam_found = true;
          break;
        }
      }
    }
    return $is_spam_found;
  }

}

if (!function_exists('file_ext')) {

  function file_ext($file) {
    $file_ext = strtolower(strrchr($file, '.'));
    $file_ext = substr($file_ext, 1);
    return $file_ext;
  }

}


if (!function_exists('applyFilter')) {

  function applyFilter($type, $val) {
    switch ($type) {
      case 'NUMERIC_GT_ZERO':
        $val = preg_replace("~^0*~", "", trim($val));
        return preg_match("~^[1-9][0-9]*$~i", $val) ? $val : 0;
        break;
      case 'NUMERIC_WT_ZERO':
        return preg_match("~^[0-9]*$~i", trim($val)) ? $val : -1;
        break;
    }
  }

}

if (!function_exists('removeImage')) {

  function removeImage($cfgs) {
    if ($cfgs['source_dir'] != '' && $cfgs['source_file'] != '') {
      $pathImage = UPLOAD_DIR . "/" . $cfgs['source_dir'] . "/" . $cfgs['source_file'];
      if (file_exists($pathImage)) {
        unlink($pathImage);
      }
    }
  }

}


if (!function_exists('trace')) {

  function trace() {
    list($callee) = debug_backtrace();
    $arguments = func_get_args();
    $total_arguments = count($arguments);
    echo '<fieldset style="background: #fefefe !important; border:3px red solid; padding:5px; font-family:Courier New,Courier, monospace;font-size:12px">';
    echo '<legend style="background:lightgrey; padding:6px;">' . $callee['file'] . ' @ line: ' . $callee['line'] . '</legend><pre>';
    $i = 0;
    foreach ($arguments as $argument) {
      echo '<br/><strong>Debug #' . ( ++$i) . ' of ' . $total_arguments . '</strong>: ';
      if ((is_array($argument) || is_object($argument))) {
        print_r($argument);
      } else {
        var_dump($argument);
      }
    }
    echo '</pre>' . PHP_EOL;
    echo '</fieldset>' . PHP_EOL;
  }

}

if (!function_exists('find_paging_segment')) {

  function find_paging_segment($debug = FALSE) {
    $ci = CI();
    $segment_array = $ci->uri->segments;
    if ($debug) {
      trace($ci->uri->segments);
    }
    $key = array_search('pg', $segment_array);
    return $key + 1;
  }

}


if (!function_exists('make_missing_folder')) {

  function make_missing_folder($dir_to_create = "") {
    if (empty($dir_to_create))
      return;
    $dir_path = UPLOAD_DIR;
    $subdirs = explode("/", $dir_to_create);
    foreach ($subdirs as $dir) {
      if ($dir != "") {
        $dir_path = $dir_path . "/" . $dir;
        if (!file_exists($dir_path)) {
//echo $dir_path;
          mkdir($dir_path, 0755);
        } else {
          chmod($dir_path, 0755);
        }
      }
    }
  }

}

if (!function_exists('char_limiter')) {

  function char_limiter($str, $len, $suffix = '...') {
    $str = strip_tags($str);
    if (strlen($str) > $len) {
      $str = substr($str, 0, $len) . $suffix;
    }
    return $str;
  }

}

function CountrySelectBox($varg = array()) {
  $CI = CI();
  $var = "";
  /*   * ********************************************************
    default_text 		=>Default Option Text
    name 		=> 			Dropdn name
    id 		=> 			Dropdn id (default to name)
    format      		=>	all extra attributes for the dpdn(style,class,event...)
    opt_val_fld     =>      DpDn option value field to be fetched from database
    opt_txt_fld     =>      DpDn option text field to be fetched from database

   * ********************************************************* */
  $varg['default_text'] = !array_key_exists('default_text', $varg) ? "Select Country" : $varg['default_text'];
  $varg['id'] = !array_key_exists('id', $varg) ? $varg['name'] : $varg['id'];
  $opt_val_fld = !array_key_exists('opt_val_fld', $varg) ? "name" : $varg['opt_val_fld'];
  $opt_txt_fld = !array_key_exists('opt_txt_fld', $varg) ? "name" : $varg['opt_txt_fld'];
  $var .= '<select name="' . $varg['name'] . '" id="' . $varg['id'] . '" ' . $varg['format'] . '>';
  if ($varg['default_text'] != "") {
    $var .= '<option value="" selected="selected">' . $varg['default_text'] . '</option>';
  }
  $contry_res = $CI->db->query("SELECT * FROM wps_countries_list WHERE 1")->result_array();
  foreach ($contry_res as $key => $val) {
    if (is_array($varg['current_selected_val'])) {
      $select_element = in_array($val[$opt_val_fld], $varg['current_selected_val']) ? "selected" : "";
    } else {
      $select_element = ( $varg['current_selected_val'] == $val[$opt_val_fld] ) ? "selected" : "";
    }
    $var .= '<option value="' . $val[$opt_val_fld] . '" ' . $select_element . '>' . ucfirst($val[$opt_txt_fld]) . '</option>';
  }
  $var .= '</select>';
  return $var;
}

if (!function_exists('city_options')) {

  function city_options($data_type = "", $selected_val = "") {
    $CI = CI();
    $qryStr = "";
    if ($data_type == "collection")
      $qryStr = "AND is_data_collection = '1'";
    if ($data_type == "operational")
      $qryStr = "AND is_data_available = '1'";
    $city_res = $CI->db->query("SELECT * FROM wps_city WHERE 1 " . $qryStr)->result_array();
//echo_sql();
    $var = "";
    foreach ($city_res as $key => $val) {
      $sel = ($val['id'] == $selected_val) ? 'selected' : '';
      $var .= '<option value="' . $val['id'] . '" ' . $sel . '>' . ucfirst($val['title']) . '</option>';
    }
//echo $var; die;
    return $var;
  }

}

if (!function_exists('get_content')) {

  function get_content($tbl = "wps_auto_respond_mails", $pageId) {
    $CI = CI();
    if ($pageId > 0) {
      $res = $CI->db->get_where($tbl, array('id' => $pageId))->row();
      if (is_object($res)) {
        return $res;
      }
    }
  }

}

if (!function_exists('get_site_email')) {

  function get_site_email() {
    $CI = CI();
    $CI->db->select('*');
    $CI->db->from('wps_admin');
    $CI->db->where('admin_id', '1');
    $query = $CI->db->get();
    if ($query->num_rows() > 0)
      return $query->row();
  }

}

function timeDiff($firstTime, $lastTime) {
  $time = $lastTime;
// convert to unix timestamps
  $firstTime = strtotime($firstTime);
  $lastTime = strtotime($lastTime);
  $rt = "";
// perform subtraction to get the difference (in seconds) between times
  $timeDiff = $firstTime - $lastTime;
// return the difference
  if ($timeDiff > 60) {
    if ($timeDiff > 60 && $timeDiff < 1440) {
      $timeDiff = $timeDiff / 60;
      $rt = ceil($timeDiff) . ' minutes ago';
    } elseif ($timeDiff > 1440 && $timeDiff < 86400) {
      $timeDiff = $timeDiff / (60 * 60);
      $rt = 'about ' . ceil($timeDiff) . ' hours ago';
    } elseif ($timeDiff > 86400 && $timeDiff < 172800) {
      $timeDiff = $timeDiff / (60 * 60 * 2);
      $tm = explode(' ', $time);
      $rt = "yesterday"; // at " . $tm[1];
    } else {
      $timeDiff = $timeDiff / (24 * 60 * 60);
      $rt = ceil($timeDiff) . " days ago";
    }
  } else {
    $rt = $timeDiff . " seconds ago";
  }
  return $rt;
}

//encryption
function encrypt($plainText, $key) {
  $secretKey = hextobin(md5($key));
  $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
  $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
  $blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
  $plainPad = pkcs5_pad($plainText, $blockSize);
  if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1) {
    $encryptedText = mcrypt_generic($openMode, $plainPad);
    mcrypt_generic_deinit($openMode);
  }
  return bin2hex($encryptedText);
}

function decrypt($encryptedText, $key) {
  $secretKey = hextobin(md5($key));
  $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
  $encryptedText = hextobin($encryptedText);
  $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
  mcrypt_generic_init($openMode, $secretKey, $initVector);
  $decryptedText = mdecrypt_generic($openMode, $encryptedText);
  $decryptedText = rtrim($decryptedText, "\0");
  mcrypt_generic_deinit($openMode);
  return $decryptedText;
}

//*********** Padding Function *********************
function pkcs5_pad($plainText, $blockSize) {
  $pad = $blockSize - (strlen($plainText) % $blockSize);
  return $plainText . str_repeat(chr($pad), $pad);
}

//********** Hexadecimal to Binary function for php 4.0 version ********
function hextobin($hexString) {
  $length = strlen($hexString);
  $binString = "";
  $count = 0;
  while ($count < $length) {
    $subString = substr($hexString, $count, 2);
    $packedString = pack("H*", $subString);
    if ($count == 0) {
      $binString = $packedString;
    } else {
      $binString .= $packedString;
    }

    $count += 2;
  }
  return $binString;
}

function clear_cache() {
  $path = UPLOAD_DIR . '/thumb-cache';
  $dir_handle = @opendir($path) or die("Unable to open folder");
  while (false !== ($file = readdir($dir_handle))) {
    if ($file != '.' && $file != '..') {
      unlink($path . '/' . $file);
    }
  }
  closedir($dir_handle);
}

function clear_vimeo_cache() {
  $path = UPLOAD_DIR . '/ddaupload';
  $dir_handle = @opendir($path) or die("Unable to open folder");
  while (false !== ($file = readdir($dir_handle))) {
    if ($file != '.' && $file != '..') {
      unlink($path . '/' . $file);
    }
  }
  closedir($dir_handle);
}

function addMultiplePhotos($filesName, $destinationFolder) {
  $ci = CI();
  $fileName = $result = array();
//trace($_FILES[$filesName]);
  $cpt = count($_FILES[$filesName]['name']);
  if ($cpt <= 10) {
    $number_of_files = sizeof($_FILES[$filesName]['tmp_name']);
    $files = $_FILES[$filesName];
    $errors = array();

    for ($i = 0; $i < $number_of_files; $i++) {
      if ($_FILES[$filesName]['error'][$i] != 0)
        $errors[$i][] = 'Couldn\'t upload file ' . $_FILES[$filesName]['name'][$i];
    }
    if (sizeof($errors) == 0) {
      $ci->load->library('upload');
      for ($i = 0; $i < $number_of_files; $i++) {
        $_FILES['uploadedimage']['name'] = time() . $i . $files['name'][$i];
        $_FILES['uploadedimage']['type'] = $files['type'][$i];
        $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'][$i];
        $_FILES['uploadedimage']['error'] = $files['error'][$i];
        $_FILES['uploadedimage']['size'] = $files['size'][$i];
        $uploaded_data = $ci->upload->my_upload('uploadedimage', $destinationFolder);
        if (is_array($uploaded_data) && !empty($uploaded_data)) {
          $fileName[] = $uploaded_data['upload_data']['file_name'];
        }
      }
      $fname = implode(",", $fileName);
      $result['files'] = $fname;
      $result['success'] = 'true';
    } else {
      $result['error'] = $errors;
      $result['success'] = 'false';
    }
  }
  return $result;
}

//Send SMS
function sendSms($mobilenos, $message) {
  $payload ="";
//echo $payload;
}

//Verify SMS
function verifySms($mobile, $otp) {
  $ci = CI();
  $cnt = count_record("wps_otp", "mobile_number = '" . $mobile . "' AND otp = '" . $otp . "' AND status = '0'");
  if ($cnt > 0) {
    $ci->db->query("UPDATE wps_otp SET status = '1' WHERE mobile_number = '" . $mobile . "' AND otp = '" . $otp . "'");
    echo '1';
  } else {
    echo 0;
  }
}

function create_time_range($start, $end, $interval = '30 mins', $format = '12') {
  $startTime = strtotime($start);
  $endTime = strtotime($end);
  $returnTimeFormat = ($format == '12') ? 'g:i:s ' : 'G:i:s';

  $current = time();
  $addTime = strtotime('+' . $interval, $current);
  $diff = $addTime - $current;

  $times = array();
  while ($startTime < $endTime) {
    $times[] = date($returnTimeFormat, $startTime);
    $startTime += $diff;
  }
  $times[] = date($returnTimeFormat, $startTime);
  return $times;
}

function compressImage($source, $destination, $quality) {
  $info = getimagesize($source);
  if ($info['mime'] == 'image/jpeg')
    $image = imagecreatefromjpeg($source);
  elseif ($info['mime'] == 'image/gif')
    $image = imagecreatefromgif($source);
  elseif ($info['mime'] == 'image/png')
    $image = imagecreatefrompng($source);

  imagejpeg($image, $destination, $quality);
  return $destination;
}

if (!function_exists('create_meta')) {

  function create_meta($data = array()) {
    $ci = CI();
    if (is_array($data) && !empty($data) && array_key_exists('page_url', $data)) {
      $ci->db->insert("wps_meta_tags", $data);
    }
  }

}

if (!function_exists('update_meta_page_url')) {

  function update_meta_page_url($type, $entity_id, $page_url) {
    $ci = CI();
    if ($entity_id != '' && $type != '' && $page_url != '') {
      $where = "entity_type ='" . $type . "' AND entity_id = $entity_id  ";
      $cnt = count_record('wps_meta_tags', "entity_type ='" . $type . "' AND entity_id = $entity_id  ");
      if ($cnt > 0) {
        $qstr = $ci->db->update_string(wps_meta_tags, array('page_url' => $page_url), $where);
        $ci->db->query($qstr);
      } else {
        $ci->db->query("INSERT INTO wps_meta_tags SET entity_type ='" . $type . "', entity_id = '" . $entity_id . "', page_url = '" . $page_url . "'");
      }
    }
  }

}

function uploadVimeoVideo($file_name, $class_name, $description) {
  $ci = CI();
  require 'vendor/autoload.php';
  $config = json_decode(file_get_contents(site_url() . 'vendor/vimeo_config.json'), true);


  //Uploading Video  
  $uploaded = array();
  $result = array();

  try {
    //Authenticate User
    $client = new Vimeo($config['client_id'], $config['client_secret'], $config['access_token']);
    $clientResponse = $client->request('/tutorial', array(), 'GET');
    //trace($clientResponse);

    $uri = $client->upload($file_name, array('name' => $class_name, 'description' => $description));
    $video_data = $client->request($uri);
    //trace($video_data);
    if ($video_data['status'] == 200) {
      $video_vimeo = $video_data['body']['link'];
    }
    $ci->session->set_userdata('api_video_uri', $uri);
    $uploaded = array('file' => $file_name, 'api_video_uri' => $uri, 'success' => 'true');
    //Return Result Set
    return $uploaded;
  } catch (VimeoUploadException $e) {
    $result["success"] = 'false';
    $result["message"] = $e->getMessage();
    //Return Error if not uploaded
    return $result;
  }
}

function uploadVimeoVideoPull($file_name, $class_name, $description) {
  $ci = CI();
  require 'vendor/autoload.php';
  $config = json_decode(file_get_contents(site_url() . 'vendor/vimeo_config.json'), true);

  //Authenticate User
  $client = new Vimeo($config['client_id'], $config['client_secret'], $config['access_token']);
  $clientResponse = $client->request('/tutorial', array(), 'GET');
  //trace($clientResponse);
  
  //Uploading Video  
  $uploaded = array();
  $result = array();
  $params = array();
  $params = array_merge(array('approach' => 'pull', 'link' => $file_name), $params);
  $params = array_merge(array('upload' => array('approach' => 'pull', 'link' => $file_name)), $params);
  $response = $client->request('/me/videos', $params, 'POST');

  return $response;
}

function deleteVimeoVideo($url) {
  $ci = CI();
  $finalUrl = $url;
  require 'vendor/autoload.php';
  $config = json_decode(file_get_contents(site_url() . 'vendor/vimeo_config.json'), true);
  //Authenticate User
  $client = new Vimeo($config['client_id'], $config['client_secret'], $config['access_token']);
  $client->request($finalUrl, array(), 'DELETE');
}

function getVimeoVimeoThumb($vimeo) {
  //forming API url
  $url = "http://vimeo.com/api/v2/video/" . $vimeo . ".json";
  //curl request
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $curlData = curl_exec($curl);
  curl_close($curl);

  //decoding json structure into array
  return @current(json_decode($curlData, true));
}


function gettransCodeStatus($url) {
  $ci = CI();
  $finalUrl = $url;
  require 'vendor/autoload.php';
  $config = json_decode(file_get_contents(site_url() . 'vendor/vimeo_config.json'), true);
  //Authenticate User
  $client = new Vimeo($config['client_id'], $config['client_secret'], $config['access_token']);
  $response = $client->request($url . '?fields=transcode.status');
  return $response;
}

function setVimeoVideoPrivacy($url) {
  $ci = CI();
  $finalUrl = $url;
  require 'vendor/autoload.php';
  $config = json_decode(file_get_contents(site_url() . 'vendor/vimeo_config.json'), true);
  $client = new Vimeo($config['client_id'], $config['client_secret'], $config['access_token']);
  $client->request($finalUrl . '/privacy/domains/lootmojo.in', array(), 'PUT');
  $client->request($finalUrl, array('privacy' => array('embed' => 'whitelist')), 'PATCH');
}

function mySessionId() {
//Create UniqueID
  $ci = CI();
  $uniqueId = $ci->input->ip_address();
  return md5($uniqueId);
}


//Vimeso Authenticated URL
function vimeoUrl(){
  require 'vendor/autoload.php';
  $config = json_decode(file_get_contents(site_url() . 'vendor/vimeo_config.json'), true);
  //Authenticate User
  $client = new Vimeo($config['client_id'], $config['client_secret'], $config['access_token']);
  trace($client);
}
