<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array( 'products/product_model','category/category_model'));
  }

  public function index() {
     //home category
     $home_cat = array('field' => "*", 'condition' => "AND status='1' AND home_menu = '1'",'limit'=>"3", 'debug' => FALSE);
     $category_result = $this->category_model->getcategory($home_cat);
     $data['home_cat'] = $category_result;

     $home_cat1 = array('field' => "*", 'condition' => "AND status='1' AND home_cat = '1'",'limit'=>"10", 'debug' => FALSE);
     $category_result = $this->category_model->getcategory($home_cat1);
     $data['home_cat1'] = $category_result;

    $data['allbanners'] = $this->db->query("SELECT * FROM wps_banners WHERE  status = '1'")->result_array();

    
    //featured_product = populer product
    $data['featured_product'] = $this->get_popular_product();
    
    //New Arrival products  = Recommended For You
    $data['new_products_arrival'] = $this->get_new_product();
    
    $condtion['status'] = '1';
    $data['product'] = $this->product_model->get_products('20', '0', $condtion);
    
    $content = "";
    $homeHeading='';
    //Check if it is subdomain
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/', $uri_path);
    $st = $uri_segments[2];
    if (strstr($st, '.html')) {
      $st = substr($st, 0, -5);
    }

    $stArray = $this->db->query("SELECT meta_id, page_url FROM wps_meta_tags WHERE is_fixed='L' AND page_url='" . $st . "'")->row_array();
    if (is_array($stArray) & !empty($stArray)) {
      $locId = $stArray['meta_id'];
      $resprosub = $this->db->query("SELECT * FROM wps_subloccontent WHERE status = '1' AND FIND_IN_SET($locId,location_id)")->row();
      if (is_object($resprosub) && !empty($resprosub)) {
        $key1 = $resprosub->meta_key1;
        $key2 = $resprosub->meta_key2;
        $key3 = $resprosub->meta_key3;
        $content = str_replace('{location}', ucwords(locationName($st)), str_replace('{key3}', $key3, str_replace('{key2}', $key2, str_replace('{key1}', $key1, $resprosub->description))));  
        $homeHeading = 'Welcome to KK International - '.ucwords(locationName($st));     
      }
    }
    else
    {
      $content = get_db_field_value('wps_cms_pages', 'page_description', "WHERE page_id = '10'");
      $homeHeading = get_db_field_value('wps_cms_pages', 'page_name', "WHERE page_id = '10'"); 
    }
    $data['subheading1']= get_db_field_value('wps_cms_pages', 'page_name', "WHERE page_id = '10'");
    $data['subheading2']= get_db_field_value('wps_cms_pages', 'page_name', "WHERE page_id = '10'");
    $data['subheading3']= get_db_field_value('wps_cms_pages', 'page_name', "WHERE page_id = '10'");
    $data['subheading4']= get_db_field_value('wps_cms_pages', 'page_name', "WHERE page_id = '10'");
    $data['homeHeading'] = $homeHeading;
    $data['home'] = $content;

     //banners
    $data['banner'] = $this->db->query("SELECT * FROM wps_banners WHERE status = '1' AND banner_position = 'Index Slider' order by banner_id asc")->result_array();
        
         $this->db->where(array('parent_id'=>'0','status'=>'1'));
         $this->db->order_by('category_id','asc');
         $data['category']=$this->db->get('wps_categories')->result_array();
    
    $this->load->view('view_home', $data);
  }

  public function get_popular_product() {
    $condtion['status'] = '1';
    $condtion['where'] = "popular_product = '1'";
    $condtion['orderby'] = 'products_id DESC';
    $product_list = $this->product_model->get_products('8', '0', $condtion);
    return $product_list;
  }
  
  public function get_new_product() {
    $condtion['status'] = '1';
    $condtion['where'] = "newarrival_product = '1'";
    //$condtion['orderby'] = 'products_id ASC';
    $product_list = $this->product_model->get_products('8', '0', $condtion);
    return $product_list;
  }


}
