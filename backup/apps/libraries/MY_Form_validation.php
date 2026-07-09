<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers get a jumpstart their development of CodeIgniter applications
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2012, Bonfire Dev Team
 * @license   http://guides.cibonfire.com/license.html
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * Form Validation
 *
 * This class extends the CodeIgniter core Form_validation library to add
 * extra functionality used in Bonfire.
 *
 * @package    Bonfire
 * @subpackage Libraries
 * @category   Libraries
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/core/form_validation.html
 *
 */
class MY_Form_validation extends CI_Form_validation {

  /**
   * Stores the CodeIgniter core object.
   *
   * @access public
   *
   * @var object
   */
  public $CI;

  //--------------------------------------------------------------------

  /**
   * Constructor
   *
   * @return void
   */
  public function __construct($config = array()) {
    // Merged super-global $_FILES to $_POST to allow for better file validation inside of Form_validation library
    $_POST = (isset($_FILES) && is_array($_FILES) && count($_FILES) > 0) ? array_merge($_POST, $_FILES) : $_POST;

    parent::__construct($config);
  }

//end __construct()
  //--------------------------------------------------------------------

  /**
   * Returns Form Validation Errors in a HTML Un-ordered list format.
   *
   * @access public
   *
   * @return string Returns Form Validation Errors in a HTML Un-ordered list format.
   */
  public function validation_errors_list() {
    if (is_array($this->CI->form_validation->_error_array)) {
      $errors = (array) $this->CI->form_validation->_error_array;
      $error = '<ul>' . PHP_EOL;

      foreach ($errors as $error) {
        $error .= "	<li>{$error}</li>" . PHP_EOL;
      }

      $error .= '</ul>' . PHP_EOL;
      return $error;
    }

    return FALSE;
  }

//end validation_errors_list()
  //--------------------------------------------------------------------

  /**
   * Performs the actual form validation
   *
   * @access public
   *
   * @param string $module Name of the module
   * @param string $group  Name of the group array containing the rules
   *
   * @return bool Success or Failure
   */
  public function run($module = '', $group = '') {
    (is_object($module)) AND $this->CI = & $module;
    return parent::run($group);
  }

//end run()
  //--------------------------------------------------------------------

  /**
   * Checks that a value is unique in the database
   *
   * i.e. '…|required|unique[users.name.id.4]|trim…'
   *
   * @abstract Rule to force value to be unique in table
   * @usage "unique[tablename.fieldname.(primaryKey-used-for-updates).(uniqueID-used-for-updates)]"
   * @access public
   *
   * @param mixed $value  The value to be checked
   * @param mixed $params The table and field to check against, if a second field is passed in this is used as "AND NOT EQUAL"
   * unique[roles.role_name]  | edit unique[roles.role_name,roles.role_id]   

    unique[users.email] | unique[users.email,users.id]

   * @return bool

   */
  public function unique($str, $field) { //unique used in for add record
    list($table, $wherecond) = explode('.', $field, 2);
    $extcond = ($wherecond != '') ? $wherecond : "";
    //$str =  $this->CI->db->escape_str($str);
    $this->CI->form_validation->set_message('unique', 'The <b> %s </b> already exists.');
    $query = $this->CI->db->query("SELECT COUNT(*) AS dupe FROM $table WHERE $extcond "
    );
    $row = $query->row();
    //echo $this->CI->db->last_query();
    return ($row->dupe > 0) ? FALSE : TRUE;
  }

//end unique()
  // --------------------------------------------------------------------

  /**
   * Check that a string only contains Alpha-numeric characters with
   * periods, underscores, spaces and dashes
   *
   * @abstract Alpha-numeric with periods, underscores, spaces and dashes
   * @access public
   *
   * @param string $str The string value to check
   *
   * @return	bool
   */
  public function alpha_extra($str) {
    $this->CI->form_validation->set_message('alpha_extra', 'The %s field may only contain alpha-numeric characters, spaces, periods, underscores, and dashes.');
    return (!preg_match("/^([\.\s-a-z0-9_-])+$/i", $str)) ? FALSE : TRUE;
  }

//end alpha_extra()
  // --------------------------------------------------------------------

  /**
   * Check that the string matches a specific regex pattern
   *
   * @access public
   *
   * @param string $str     The string to check
   * @param string $pattern The pattern used to check the string
   *
   * @return bool
   */
  public function matches_pattern($str, $pattern) {
    if (preg_match('/^' . $pattern . '$/', $str)) {
      return TRUE;
    }

    $this->CI->form_validation->set_message('matches_pattern', 'The %s field does not match the required pattern.');

    return FALSE;
  }

//end matches_pattern()
  // --------------------------------------------------------------------

  /**
   * Check if the field has an error associated with it.
   *
   * @access public
   *
   * @param string $field The name of the field
   *
   * @return bool
   */
  public function has_error($field = null) {
    if (empty($field)) {
      return FALSE;
    }

    return !empty($this->_field_data[$field]['error']) ? TRUE : FALSE;
  }

//end has_error()
  //--------------------------------------------------------------------

  /**
   * Check the entered password against the password strength settings.
   *
   * @access public
   *
   * @param string $str The password string to check
   *
   * @return bool
   */
  public function valid_password($str) {
    // get the password strength settings from the database ex : 1a3!567A
    $min_length = $this->CI->config->item('auth.password_min_length');
    $use_nums = $this->CI->config->item('auth.password_force_numbers');
    $use_syms = $this->CI->config->item('auth.password_force_symbols');
    $use_mixed = $this->CI->config->item('auth.password_force_mixed_case');

    // Check length
    if (strlen($str) < $min_length) {
      $this->CI->form_validation->set_message('valid_password', '%s should  be at least ' . $min_length . ' character in length.');
      return FALSE;
    }

    // Check numbers
    if ($use_nums) {
      if (0 === preg_match('/[0-9]/', $str)) {
        $this->CI->form_validation->set_message('valid_password', '%s must contain at least 1 number.');
        return FALSE;
      }
    }

    // Check Symbols
    if ($use_syms) {
      if (0 === preg_match('/[!@#$%^&*()._]/', $str)) {
        $this->CI->form_validation->set_message('valid_password', '%s must contain at least 1 punctuation mark.');
        return FALSE;
      }
    }

    // Mixed Case?
    if ($use_mixed) {
      if (0 === preg_match('/[A-Z]/', $str)) {
        $this->CI->form_validation->set_message('valid_password', '%s must contain at least 1 uppercase characters.');
        return FALSE;
      }

      if (0 === preg_match('/[a-z]/', $str)) {
        $this->CI->form_validation->set_message('valid_password', '%s must contain at least 1 lowercase characters.');
        return FALSE;
      }
    }

    return TRUE;
  }

//end valid_password()

  public function file_required($file) {

    $filesz = $file['size'];

    if ($filesz === 0) {
      $this->CI->form_validation->set_message('file_required', 'Uploading a file for %s is required');
      return FALSE;
    } else {
      return TRUE;
    }
  }

  /*
    $this->form_validation->set_rules('photo','photo','file_required|file_allowed_type[image]');

   */

  public function validate_image($image = NULL) {
    print_r($image);
    $file_name = $image['name'];

    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'GIF', 'PNG');
    $ext = strtolower(end(explode('.', $file_name)));

    $allowed_file_types = array('image/jpeg', 'image/jpg', 'image/gif', 'image/png');
    $file_type = $image['type'];

    if (!in_array($ext, $allowed_ext) && !in_array($file_type, $allowed_file_types)) {
      $this->_CI->form_validation->set_message('validate_image', 'This file type is not allowed');
      return false;
    }

    if ($image['size'] > 2097152) {
      $this->_CI->form_validation->set_message('validate_image', 'File size Exeeds');
      return false;
    } else {
      return true;
    }
  }

  public function file_allowed_type($file, $type) {
    $ext_groups = array();
    $ext_groups['image'] = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
    $ext_groups['document'] = array('rtf', 'doc', 'docx', 'pdf', 'txt', 'ppt', 'zip');
    $ext_groups['media'] = array('mp4', 'mpeg4');
    $ext_groups['compressed'] = array('zip', 'gzip', 'tar', 'gz');
    $exts = $ext_groups[$type];
    //get file ext
    $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    if (!in_array($file_ext, $exts)) {
      $exts_allowed = implode(" | ", $exts);
      $this->form_validation->set_message('file_allowed_type', "File should be " . $exts_allowed);
      return FALSE;
    } else {
      return TRUE;
    }
  }

  public function file_size_max($file, $max_size) {
    //$filesz = $_FILES[$file]['size'];	

    $filesz = $file['size'];
    $file_sz_in_kb = ceil($filesz / 1024);

    if ($file_sz_in_kb > $max_size) {
      $this->CI->form_validation->set_message('file_size_max', "File is too big. (max allowed is $max_size KB)");
      return FALSE;
    }
    return TRUE;
  }

  public function check_dimension($file_name, $dimen) {
    if (function_exists('getimagesize')) {
      //$file_name_tmp = $_FILES[$file_name]['tmp_name'];

      $file_name_tmp = $file_name['tmp_name'];
      $dim = explode('x', $dimen, 2);
      $d = @getimagesize($file_name_tmp);
      if ($d[0] > $dim[0] && $d[1] > $dim[1]) {

        $this->CI->form_validation->set_message('check_dimension', "File dimension is not correct. (min allowed dimension is $dimen )");
        return FALSE;
      } else {
        return TRUE;
      }
    }
  }

  //--------------------------------------------------------------------

  /**
   * Checks that the entered string is one of the values entered as the second parameter.
   * Please separate the allowed file types with a comma.
   *
   * @access public
   *
   * @param string $str      String field name to validate
   * @param string $options String allowed values
   *
   * @return bool If files are in the allowed type array then TRUE else FALSE
   */
  public function one_of($str, $options = NULL) {
    if (!$options) {
      log_message('debug', 'form_validation method one_of was called without any possible values.');
      return FALSE;
    }

    log_message('debug', 'form_validation one_of options:' . $options);

    $possible_values = explode(',', $options);

    if (!in_array($str, $possible_values)) {
      $this->CI->form_validation->set_message('one_of', '%s must contain one of the available selections.');
      return FALSE;
    }

    return TRUE;
  }

//end one_of()

  public function valid_url($str) {
    if (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $str))
      return true;

    else {
      return false;
    }
  }

  public function exclude_text($str, $str2) {
    if (trim(strtolower($str)) != trim(strtolower($str2)))
      return true;

    else {
      return false;
    }
  }

  /*

    $this->form_validation->set_rules('comments','Comments','trim|required|valid_text[Comments]');

   */

  public function valid_text($str, $str1) {

    if ($str == $str1) {
      $this->CI->form_validation->set_message('valid_text', 'The %s field must contain some other value(instead of the given text).');
      return FALSE;
    } else {
      return TRUE;
    }
  }

  /* 	
    $this->form_validation->set_rules('verification_code','Word Verification','trim|required|valid_captcha_code');


   */

  public function valid_captcha_code($verification_code) {

    $this->CI->load->library('securimage_library');

    if ($this->CI->securimage_library->check($verification_code) === TRUE) {
      return TRUE;
    } else {
      $this->CI->form_validation->set_message('valid_captcha_code', '%s mismatch,please enter a valid verification code.');
      return FALSE;
    }
  }

  public function amount_range($amount, $range) {
    list($range1, $range2) = explode(",", $range, 2);
    if (!preg_match('/(\$[0-9]{"",$range1}+(\.[0-9]{$range2})?)/', $amount)) {
      $this->CI->form_validation->set_message('amount_range', '%s,please enter a valid Amount.');
      return FALSE;
    }
    return TRUE;
  }

  public function required_stripped($str) {
    $str = trim(strip_tags($str));
    if ($str == '')
      return false;
    else
      return true;
  }

  public function is_valid_amount($str) {
    if (!preg_match('/^[0-9]*(\.)?[0-9]+$/', $str)) {
      return FALSE;
    }
    return TRUE;
  }

  public function decimal($str) {
    return (bool) preg_match('/^[\+]?[0-9]+\.[0-9]+$/', $str);
  }

  public function alpha($str) {

    return (!preg_match("/^([a-zA-Z ])+$/", $str)) ? FALSE : TRUE;
  }

  public function notnumeric($str) {

    return ( preg_match("/^([a-zA-Z ])+$/", $str)) ? TRUE : FALSE;
  }

  public function valid_past_date($datetime) {
    if ($datetime == "0000-00-00" or $datetime == "0000-00-00 00:00:00")
      return FALSE;

    $timestamp = strtotime($datetime);

    $time_diff = time() - $timestamp;

    if ($time_diff <= 0) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  public function valid_future_date($datetime) {

    if ($datetime == "0000-00-00" or $datetime == "0000-00-00 00:00:00")
      return FALSE;

    $timestamp = strtotime($datetime);

    $time_diff = time() - $timestamp;

    if ($time_diff >= 0) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  public function valid_age($datetime, $age = 20) {

    if ($datetime == "0000-00-00" or $datetime == "0000-00-00 00:00:00")
      return FALSE;

    $timestamp = strtotime($datetime);

    $time_diff = time() - $timestamp;

    $time_diff = round($time_diff / (60 * 60 * 24 * 365), 2);

    if ($time_diff > $age or $time_diff < 5) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

}

//end class
//--------------------------------------------------------------------
// Helper Functions for Form Validation LIbrary
//--------------------------------------------------------------------

/**
 * Check if the form has an error
 *
 * @access public
 *
 * @param string $field Name of the field
 *
 * @return bool
 */
function form_has_error($field = null) {

  if (FALSE === ($OBJ = & _get_validation_object())) {
    return FALSE;
  }

  $return = $OBJ->has_error($field);

  return $return;
}

//end form_has_error()

//--------------------------------------------------------------------


/* Author :  http://net.tutsplus.com/tutorials/php/6-codeigniter-hacks-for-the-masters/ */
/* End of file : ./libraries/MY_Form_validation.php */