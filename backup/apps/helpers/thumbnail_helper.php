<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');
/**
 * SSL Helpers
 *
 * @author		dkmaurya 
 * @version		1.0
 * @license		MIT License Copyright (c) 2010
 */
// ------------------------------------------------------------------------

if (!function_exists('Image_thumb')) {
  /* 	

    R - Image Resizing
    C - Image Cropping
    X - Image Rotation
    W - Image Watermarking

    $config['master_dim']  options = auto, width, height

    echo $this->image_lib->display_errors();

    $this->image_lib->display_errors('<p>', '</p>');

    echo get_image('album_images',$row->photo1,200,150,'R');
    R, AR

   */

  function Image_thumb($thumb = array(), $perform = 'R') {

    $ci = &get_instance();
    $ci->load->library('image_lib');

    $config['image_library'] = 'gd2';
    $config['create_thumb'] = TRUE;
    $config['thumb_marker'] = FALSE;
    $config['source_image'] = $thumb['source_path'] . $thumb['org_image'];
    $config['width'] = $thumb['width'];
    $config['height'] = $thumb['height'];

    if (array_key_exists('destination_path', $thumb)) {
      $thum_img_name = $thumb['org_image'];
      $config['new_image'] = $thumb['destination_path'] . "/" . $thum_img_name;
    } else {
      $thum_img_name = "thumb_" . $thumb['width'] . "_" . $thumb['height'] . "_" . $thumb['org_image'];
      $thumb['destination_path'] = IMG_CACH_DIR;
      $config['new_image'] = IMG_CACH_DIR . "/" . $thum_img_name;
    }

    if (!file_exists($thumb['destination_path'] . "/" . $thum_img_name)) {
      if ($perform == 'C') {
        list($original_width, $original_height, $file_type, $attr) = @getimagesize($config['source_image']);
        $ratio = $original_width / $original_height;
        $thumbRatio = $thumb['width'] / $thumb['height'];
        if ($ratio < $thumbRatio) {
          $srcHeight = round($original_height * $ratio / $thumbRatio);
          $config['y_axis'] = round(($original_height - $srcHeight) / 2);
        } else {
          $srcWidth = round($original_width * $thumbRatio / $ratio);
          $config['x_axis'] = round(($original_width - $srcWidth) / 2);
        }

        $config['maintain_ratio'] = FALSE;
        $ci->image_lib->initialize($config);
        $ci->image_lib->crop();
        $ci->image_lib->clear();
      }

      if ($perform == 'AR') {
        $config['ar_width'] = $thumb['width'];
        $config['ar_height'] = $thumb['height'];
        $config['maintain_ratio'] = FALSE;
        $config['master_dim'] = "height";
        if ($thumb['width'] > $thumb['height']) {
          $config['master_dim'] = "width";
        }
        $ci->image_lib->initialize($config);
        $ci->image_lib->resize();
        $ci->image_lib->clear();
      }

      if ($perform == 'R') {
        list($original_width, $original_height, $file_type, $attr) = @getimagesize($config['source_image']);
        $config['width'] = ( $thumb['width'] >= $original_width ) ? $original_width : $thumb['width'];
        $config['height'] = ( $thumb['height'] >= $original_height ) ? $original_height : $thumb['height'];
        $config['maintain_ratio'] = TRUE;
        $ci->image_lib->initialize($config);
        $ci->image_lib->resize();
        $ci->image_lib->clear();
      }
    }
  }

}



if (!function_exists('get_image')) {

  function get_image($dir = "", $image = "", $w = 50, $h = 50, $option = 'R') {
    $ci = &get_instance();
    $the_img = theme_url() . "images/noimage.jpg";
    if ($dir != '') {
      $thumbc = array();
      $thumbc['width'] = $w;
      $thumbc['height'] = $h;
      $thumbc['source_path'] = UPLOAD_DIR . '/' . $dir . '/';
      $file_path = UPLOAD_DIR . '/' . $dir . "/$image";
      if ($image != "" && file_exists($file_path)) {
        $thumbc['org_image'] = $image;
        Image_thumb($thumbc, $option);
        $cache_file = "thumb_" . $thumbc['width'] . "_" . $thumbc['height'] . "_" . $image;
        $imgbCachePath = UPLOAD_DIR . "/thumb-cache/" . $cache_file;
        if (($image != '') && ( file_exists($imgbCachePath) )) {
          $the_img = thumb_cache_url() . $cache_file;
        }
      } else {
        $thumbc = array();
        $thumbc['width'] = $w;
        $thumbc['height'] = $h;
        $thumbc['source_path'] = FCROOT . "assets/designer/themes/default/images/";
        $thumbc['org_image'] = "noimage.jpg";
        Image_thumb($thumbc, $option);
        $cache_file = "thumb_" . $thumbc['width'] . "_" . $thumbc['height'] . "_" . $thumbc['org_image'];
        $imgbCachePath = UPLOAD_DIR . "/thumb-cache/" . $cache_file;
        if (file_exists($imgbCachePath)) {
          $the_img = thumb_cache_url() . $cache_file;
        }
      }
    }
    return $the_img;
  }

} 

if (!function_exists('seo_url_title')) {



  function seo_url_title($str) {

    $str = preg_replace("~[^a-zA-Z0-9-_/]~", "-", $str);

    $str = preg_replace("~[/]{2,15}~", "/", $str);

    $str = preg_replace("~[-]{2,15}~", "-", $str);

    $str = strtolower($str);

    $str = str_replace('/', ' ', $str);

    $str = trim($str, "-");

    return $str;

  }



}

if (!function_exists('Image_thumb_with_name')) {
  function Image_thumb_with_name($thumb = array(), $perform = 'R') {

    $ci = &get_instance();
    $ci->load->library('image_lib');

    $config['image_library'] = 'gd2';
    $config['create_thumb'] = TRUE;
    $config['thumb_marker'] = FALSE;
    $config['source_image'] = $thumb['source_path'] . $thumb['org_image'];
    $config['width'] = $thumb['width'];
    $config['height'] = $thumb['height'];

    if (array_key_exists('destination_path', $thumb)) {
      $thum_img_name = $thumb['org_image'];
      $config['new_image'] = $thumb['destination_path'] . "/" . $thum_img_name;
    } else {
      $thum_img_name = $thumb['imageName'].$thumb['width'].$thumb['org_image'];
      $thumb['destination_path'] = IMG_CACH_DIR;
      $config['new_image'] = IMG_CACH_DIR . "/" . $thum_img_name;
    }

    if (!file_exists($thumb['destination_path'] . "/" . $thum_img_name)) {
      if ($perform == 'C') {

        list($original_width, $original_height, $file_type, $attr) = @getimagesize($config['source_image']);

        /*  
          use if you want to crop image from centre

          $crop_x = ($original_width / 2) - ($thumb['width'] / 2);
          $crop_y = ($original_height / 2) - ($thumb['height'] / 2);
          $config['x_axis'] = $thumb['width'];
          $config['y_axis'] = $thumb['height'];

         */

        $ratio = $original_width / $original_height;
        $thumbRatio = $thumb['width'] / $thumb['height'];

        if ($ratio < $thumbRatio) {
          $srcHeight = round($original_height * $ratio / $thumbRatio);
          $config['y_axis'] = round(($original_height - $srcHeight) / 2);
        } else {

          $srcWidth = round($original_width * $thumbRatio / $ratio);
          $config['x_axis'] = round(($original_width - $srcWidth) / 2);
        }

        $config['maintain_ratio'] = FALSE;
        $ci->image_lib->initialize($config);
        $ci->image_lib->crop();
        $ci->image_lib->clear();
      }

      if ($perform == 'AR') {
        $config['ar_width'] = $thumb['width'];
        $config['ar_height'] = $thumb['height'];
        $config['maintain_ratio'] = FALSE;
        $config['master_dim'] = "height";

        if ($thumb['width'] > $thumb['height']) {
          $config['master_dim'] = "width";
        }
        $ci->image_lib->initialize($config);
        $ci->image_lib->adaptive_resize();
        $ci->image_lib->clear();
      }

      if ($perform == 'R') {

        list($original_width, $original_height, $file_type, $attr) = @getimagesize($config['source_image']);
        $config['width'] = ( $thumb['width'] >= $original_width ) ? $original_width : $thumb['width'];
        $config['height'] = ( $thumb['height'] >= $original_height ) ? $original_height : $thumb['height'];
        $config['maintain_ratio'] = TRUE;
        $ci->image_lib->initialize($config);
        $ci->image_lib->resize();
        $ci->image_lib->clear();
      }
    }
  }

}



if (!function_exists('get_image_with_name')) {

  function get_image_with_name($imageName="", $dir = "", $image = "", $w = 50, $h = 50, $option = 'R') {

    $ci = &get_instance();
    $ci->load->helper(array('thumbnail'));
    $the_img = theme_url() . "images/noimage.jpg";

    if ($dir != '') {
      $thumbc = array();
      $thumbc['imageName'] = seo_url_title($imageName);
      $thumbc['width'] = $w;
      $thumbc['height'] = $h;
      $thumbc['source_path'] = UPLOAD_DIR . '/' . $dir . '/';
      $file_path = UPLOAD_DIR . '/' . $dir . "/$image";

      if ($image != "" && file_exists($file_path)) {
        $thumbc['org_image'] = $image;
        Image_thumb_with_name($thumbc, $option);
        $cache_file = $thumbc['imageName'].$thumbc['width'].$image;
        $imgbCachePath = UPLOAD_DIR . "/thumb-cache/" . $cache_file;

        if (($image != '') && ( file_exists($imgbCachePath) )) {
          $the_img = thumb_cache_url() . $cache_file;
        }
      } else {

        $thumbc = array();
        $thumbc['imageName'] = seo_url_title($imageName);
        $thumbc['width'] = $w;
        $thumbc['height'] = $h;
        $thumbc['source_path'] = FCROOT . "assets/designer/themes/default/images/";
        $thumbc['org_image'] = "noimage.jpg";
        Image_thumb_with_name($thumbc, $option);
        $cache_file = $thumbc['imageName'].$thumbc['width'].$thumbc['org_image'];
        $imgbCachePath = UPLOAD_DIR . "/thumb-cache/" . $cache_file;

        if (file_exists($imgbCachePath)) {
          $the_img = thumb_cache_url() . $cache_file;
        }
      }
    }

    return $the_img;
  }
}

/* End of file thumbnail_helper.php */
/* Location: ./application/helpers/thumbnail_helper.php */