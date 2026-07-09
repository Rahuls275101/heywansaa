<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 * query_string function.
 *
 * Returns query string with added or removed key/value pairs.
 *
 * @param mixed $add (default: '') can be string or array
 * @param mixed $remove (default: '') can be string or array
 * @param bool $include_current (default: TRUE)
 * @return string
 */
function query_string($add = '', $remove = '', $include_current = TRUE) {

  $_ci = &get_instance();
// set initial query string
  $query_string = array();

  if ($include_current && $_ci->input->get() !== FALSE) {
    $query_string = $_ci->input->get();
    $query_string = array_filter($query_string);
  }

// add to query string
  if ($add != '') {
// convert to array
    if (is_string($add)) {
      $add = array($add);
    }
    $query_string = array_merge($query_string, $add);
  }

// remove from query string
  if ($remove != '') {
// convert to array
    if (is_string($remove)) {
      $remove = array($remove);
    }

// remove from query_string
    foreach ($remove as $rm) {
      //$key = array_search($rm, array_keys($query_string));
      if (is_array($query_string) && array_key_exists($rm, $query_string)) {
        unset($query_string[$rm]);
      }
    }
  }

// return result
  $return = '';
  if (count($query_string) > 0) {
    $return = '?' . http_build_query($query_string);
  }
  return $return;
}

// --------------------------------------------------------------------------

/**
 * uri_query_string function.
 *
 * returns uri_string with query_string on the end.
 *
 * @param mixed $add (default: '')
 * @param mixed $remove (default: '')
 * @param bool $include_current (default: TRUE) Whether to include the
 * current page's query string or start fresh.
 * @return string
 */
function uri_query_string($add = '', $remove = '', $include_current = TRUE) {
  $_ci = & get_instance();
  return $_ci->uri->uri_string() . query_string($add, $remove, $include_current);
}

// --------------------------------------------------------------------------

/**
 * current_url_query_string function.
 *
 * returns uri_string with query_string on the end and current_url at the
 * beginning.
 *
 * @param mixed $add (default: '')
 * @param mixed $remove (default: '')
 * @param bool $include_current (default: TRUE) Whether to include the
 * current page's query string or start fresh.
 * @return string
 */
function current_url_query_string($add = '', $remove = '', $include_current = TRUE) {
  $_ci = & get_instance();
  $_ci->load->helper('url');
  return current_url() . query_string($add, $remove, $include_current);
}

if (!function_exists('seo_url_title')) {

  function seo_url_title($str) {
    $str = preg_replace("~[^a-zA-Z0-9-_/]~", "-", $str);
    $str = preg_replace("~[/]{2,15}~", "/", $str);
    $str = preg_replace("~[-]{2,15}~", "-", $str);
    $str = strtolower($str);
    $str = trim($str, "-");
    return $str;
  }

}

/**
 * Create a Random String
 *
 * Useful for generating passwords or hashes.
 *
 * @access	public
 * @param	string	type of random string.  basic, alpha, alunum, numeric, nozero, unique, md5, encrypt and sha1
 * @param	integer	number of characters
 * @return	string
 */
if (!function_exists('random_string')) {

  function random_string($type = 'alnum', $len = 8) {
    switch ($type) {
      case 'basic' : return mt_rand();
        break;
      case 'alnum' :
      case 'numeric' :
      case 'nozero' :
      case 'alpha' :

        switch ($type) {
          case 'alpha' : $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
          case 'alnum' : $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
          case 'numeric' : $pool = '0123456789';
            break;
          case 'nozero' : $pool = '123456789';
            break;
        }

        $str = '';
        for ($i = 0; $i < $len; $i++) {
          $str .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
        }
        return $str;
        break;
      case 'unique' :
      case 'md5' :

        return md5(uniqid(mt_rand()));
        break;
      case 'encrypt' :
      case 'sha1' :

        $CI = & get_instance();
        $CI->load->helper('security');

        return do_hash(uniqid(mt_rand(), TRUE), 'sha1');
        break;
    }
  }

}

// --------------------------------------------------------------------------

/* End of file query_string_helper.php */
