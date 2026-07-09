<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/* Param list 

 * *** Single Dimension Associative Array i.e array('Size'=>'Large','Color'=>'Black','width'=>'22CM')
 * *** ExcludeKeys array of keys that to be excluded
 */

if (!function_exists('create_hidden_fields')) {

  function create_hidden_fields($arr_values, $excludeKeys = NULL) {
    $hiddenFields = '';
    if (is_array($arr_values) && count($arr_values) > 0) {
      foreach ($arr_values as $fieldKey => $fieldVal) {
        if (is_array($excludeKeys) && in_array($fieldKey, $excludeKeys)) {
          continue;
        }
        $hiddenFields .= "<input type='hidden' name='" . $fieldKey . "' value='" . $fieldVal . "'>\n";
      }
    }
    return $hiddenFields;
  }

}

/**
 * Drop-down Menu
 *
 * @param	string
 * @param	array
 * @param	string
 * @param	string
 * @return	string
 */
if (!function_exists('custom_drop_down')) {

  function custom_drop_down($name = '', $options = array(), $selected = array(), $extra = '', $force_select = TRUE, $default_text = NULL) {
    // If name is really an array then we'll call the function again using the array
    if (is_array($name) && isset($name['name'])) {
      isset($name['options']) OR $name['options'] = array();
      isset($name['selected']) OR $name['selected'] = array();
      isset($name['extra']) OR $name['extra'] = array();

      return custom_drop_down($name['name'], $name['options'], $name['selected'], $name['extra'], $name['force_select'], $name['default_option']);
    }

    if (!is_array($selected)) {
      $selected = array($selected);
    }

    // If no selected state was submitted we will attempt to set it automatically
    if (count($selected) === 0 && isset($_POST[$name])) {
      $selected = array($_POST[$name]);
    }

    if ($extra != '') {
      $extra = ' ' . $extra;
    }

    $multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

    $form = '<select name="' . $name . '"' . $extra . $multiple . ">\n";

    if ($force_select == TRUE) {
      $default_text = (!empty($default_text)) ? $default_text : 'Select';
      $form .= '<option value="">' . (string) $default_text . "</option>\n";
    }

    foreach ($options as $key => $val) {
      $key = (string) $key;

      if (is_array($val)) {
        if (empty($val)) {
          continue;
        }

        $form .= '<optgroup label="' . $key . "\">\n";

        foreach ($val as $optgroup_key => $optgroup_val) {
          $sel = in_array($optgroup_key, $selected) ? ' selected="selected"' : '';
          $form .= '<option value="' . $optgroup_key . '"' . $sel . '>' . (string) $optgroup_val . "</option>\n";
        }

        $form .= "</optgroup>\n";
      } else {
        $form .= '<option value="' . $key . '"' . (in_array($key, $selected) ? ' selected="selected"' : '') . '>' . (string) $val . "</option>\n";
      }
    }

    return $form . "</select>\n";
  }

}


