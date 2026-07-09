<?php

class Category extends Public_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper(array('category/category', 'products/product'));
    $this->load->model(array('category/category_model', 'products/product_model', 'admin/color_model', 'admin/size_model'));
  }

  public function index() {
    //trace($this->meta_info);
    $category_id = (int) $this->meta_info['entity_id'];
    
    $have_sub_cat = get_db_field_value('wps_categories', 'parent_id', "WHERE parent_id = '$category_id' ");
    if ($category_id > 0) {
      if ($have_sub_cat > 0) {
        $this->category_listing($category_id);
      } else {
        $this->products_listing($category_id);
      }
    } else {
      $this->products_listing($category_id);
    }
  }

  public function products_listing($category_id) {
    $this->page_section_ct = 'product';
    $condtion = array();
    $cat_res = '';
    $record_per_page = (int) $this->input->post('per_page');
    $category_id = (int) $category_id;
    $page_segment = find_paging_segment();
    $config['per_page'] = ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
    $offset = (int) $this->uri->segment($page_segment, 0);
    $base_url = ( $category_id != '' ) ? "category/products_listing/$category_id/pg/" : "category/products_listing/pg/";
    
    $page_title = "Products List";

    //Sorting
    $sort = $this->input->get_post('sort');
    if ($sort > 0) {
      if ($sort == 5) {//Popular Products
        $condtion['orderby'] = 'wlp.products_viewed DESC';
      }
      if ($sort == 2) {//New Arrival
        $condtion['orderby'] = 'wlp.products_id DESC';
      }
      if ($sort == 4) {//Price Low to High
        $condtion['orderby'] = '(CASE WHEN wlp.product_discounted_price > 0 THEN wlp.product_discounted_price ELSE wlp.product_price END) ASC';
        //$condtion['orderby'] = 'wlp.product_price ASC';
      }
      if ($sort == 3) {//Price High to Low
        $condtion['orderby'] = '(CASE WHEN wlp.product_discounted_price > 0 THEN wlp.product_discounted_price ELSE wlp.product_price END) DESC';
        //$condtion['orderby'] = 'wlp.product_price DESC';
      }
    } else {
      $condtion['orderby'] = 'wlp.product_code asc';
    }

    
    $condtion['status'] = '1';
    $color = $this->input->post('color');
    $size = $this->input->post('size');
    $price = $this->input->post('price');
    $category_ids = $this->input->post('category_id');

    if (!empty($color)) {
      $colors = implode(',', $color);
      $condtion['color'] = $colors;
    }
    if (!empty($size)) {
      $sizes = implode(',', $size);
      $condtion['size'] = $sizes;
    }
    if (!empty($price)) {
      $condtion['price'] = $price;
    }
    if ($category_ids>0) {
      $condtion['category_ids'] = $category_ids;
    }
    


    $srtQry = "AND parent_id = '1'";
    $data['catid'] = "";
    $category_description = "";
    if ($category_id > 0) {
      $condtion['category_id'] = $category_id;
      $cat_res = get_db_single_row('wps_categories', '*', " category_id='$category_id'");
      // $page_title = (isset($cat_res['category_heading']) && $cat_res['category_heading']!='')?$cat_res['category_heading']:$cat_res['category_name'];
      $page_title = $cat_res['category_name'];
      $category_description = $cat_res['category_description'];
      $srtQry = "AND parent_id = '" . $cat_res['parent_id'] . "'";
      $data['catid'] = $category_id;

      //Check if it is subdomain
      $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      $uri_segments = explode('/', $uri_path);
      $st = $uri_segments[2];
      if (strstr($st, '.html')) {
        $st = substr($st, 0, -5);
      }
      $stArray = $this->db->query("SELECT page_url FROM wps_meta_tags WHERE is_fixed='L' AND page_url='" . $st . "'")->row_array();
      if (is_array($stArray) & !empty($stArray)) {
        $resprosub = $this->db->query("SELECT * FROM wps_subcontent WHERE status = '1' AND FIND_IN_SET($category_id,category_id)")->row();
        if (is_object($resprosub) && !empty($resprosub)) {

          //With location and category
          $locId = get_db_field_value("wps_meta_tags", "meta_id", "WHERE page_url = '" . $st . "'");
          $resprosubloc = $this->db->query("SELECT * FROM wps_subcontent WHERE status = '1' AND FIND_IN_SET($category_id,category_id) AND FIND_IN_SET($locId,location_id)")->row();
          if (is_object($resprosubloc) && !empty($resprosubloc)) {//With location and category
            $key1 = $resprosubloc->meta_key1;
            $key2 = $resprosubloc->meta_key2;
            $key3 = $resprosubloc->meta_key3;
            $cat_res['category_description'] = str_replace('{catname}', $page_title, str_replace('{location}', ucwords(locationName($st)), str_replace('{key3}', $key3, str_replace('{key2}', $key2, str_replace('{key1}', $key1, $resprosubloc->description)))));
            if ($resprosubloc->page_heading != '') {
              $page_title = str_replace('{catname}', $page_title, str_replace('{location}', ucwords(locationName($st)), str_replace('{key3}', $key3, str_replace('{key2}', $key2, str_replace('{key1}', $key1, $resprosubloc->page_heading)))));
            } else {
              $page_title .= ' In ' . ucwords(locationName($st));
            }
          } else {//With category only
            $key1 = $resprosub->meta_key1;
            $key2 = $resprosub->meta_key2;
            $key3 = $resprosub->meta_key3;
            $cat_res['category_description'] = str_replace('{catname}', $page_title, str_replace('{location}', ucwords($st), str_replace('{key3}', $key3, str_replace('{key2}', $key2, str_replace('{key1}', $key1, $resprosub->description)))));
            if ($resprosub->page_heading != '') {
              $page_title = str_replace('{catname}', $page_title, str_replace('{location}', ucwords(locationName($st)), str_replace('{key3}', $key3, str_replace('{key2}', $key2, str_replace('{key1}', $key1, $resprosub->page_heading)))));
            } else {
              $page_title .= ' In ' . ucwords(locationName($st));
            }
          }
        }
      }
    }


    $res_array = $this->product_model->get_products($config['per_page'], $offset, $condtion);
    $res_array2 = $this->product_model->get_products('5000', $offset, $condtion);
    //echo_sql();
    $data['total_rows'] = $data['total_list_rows'] = $config['total_rows'] = get_found_rows();
    //$data['page_links'] = front_pagination("$base_url", $config['total_rows'], $config['per_page'], $page_segment);
    $data['heading_title'] = $page_title;
    $data['category_description'] = $category_description;
    $data['products'] = $res_array;
    $data['products2'] = $res_array2;
    $data['cat_res'] = $cat_res;
    /* Available Color Records */
    $color_cond_config = array(
      'condition' => " AND status='1' ",
      'order' => 'color_name '
    );
    $colors = $this->color_model->getcolors($color_cond_config);
    $data['colors'] = $colors;
    /* Available Size Records */
    $size_cond_config = array(
        'condition' => " AND status='1' ",
        'order' => 'size_name '
    );
    $sizes = $this->size_model->getsizes($size_cond_config);
    $data['sizes'] = $sizes;
    
    
    
    
        $where=array('parent_id'=>'0');
        $data['category_list']=$this->product_model-> get_where('wps_categories',$where);
            
         $variant_details=array(); 
         $brand_list=array();
        foreach($res_array as $pd=>$p)
        {
            $where=array('product_id'=>$p['products_id']);
            $variant_details[]=$this->product_model-> get_where('product_variant',$where);
            $brand_list[]=$p['brand'];
           
        }
           $data['variant_details']=$variant_details;
           
           $data['brand_list']=$brand_list;
       
    

    $this->load->view('products/view_product_listing', $data);
  }

  public function category_listing() {

    $data['unq_section'] = isset($parentdata) && is_object($parentdata) ? "Subcategory" : "Category";
    $data['title'] = "Category";
    $data['heading_title'] = 'Our Range';
    $page_title = 'Category';

    //For paging
    $record_per_page = (int) $this->input->post('per_page');
    if (array_key_exists('entity_id', $this->meta_info) && $this->meta_info['entity_id'] > 0) {
      $parent_segment = (int) $this->meta_info['entity_id'];
    } else {
      $parent_segment = (int) $this->uri->segment(3);
    }
    $page_segment = find_paging_segment();
    $config['per_page'] = ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
    $offset = (int) $this->uri->segment($page_segment, 0);
    $parent_id = ( $parent_segment > 0 ) ? $parent_segment : '0';
    $base_url = ( $parent_segment > 0 ) ? "category/category_listing/$parent_id/pg/" : "category/category_listing/pg/";

    //Cat List    
    $condtion_array = array('field' => "*,( SELECT COUNT(category_id) FROM wps_categories AS b WHERE b.parent_id=a.category_id ) AS total_subcategories", 'condition' => "AND parent_id = '$parent_id' AND status='1' ", 'limit' => $config['per_page'], 'offset' => $offset, 'debug' => FALSE);
    $res_array = $this->category_model->getcategory($condtion_array);
    $data['total_rows'] = $config['total_rows'] = $this->category_model->total_rec_found;
    //$data['page_links'] = front_pagination("$base_url", $config['total_rows'], $config['per_page'], $page_segment);
    $data['res'] = $res_array;

    //Products
    $proRes = $this->product_model->get_products(5, 0, array("categoryIds" => $parent_id));
    $data['proRes'] = $proRes;

    //Parent Data
    $parentdata = $this->category_model->get_category_by_id($parent_id);
    $page_title = @$parentdata['category_name'];
     //Check if it is subdomain
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/', $uri_path);
    $st = $uri_segments[2];
    if (strstr($st, '.html')) {
      $st = substr($st, 0, -5);
    }
    $stArray = $this->db->query("SELECT page_url FROM wps_meta_tags WHERE is_fixed='L' AND page_url='" . $st . "'")->row_array();
    if (is_array($stArray) & !empty($stArray)) {
      $resprosub = $this->db->query("SELECT * FROM wps_subcontent WHERE status = '1' AND FIND_IN_SET($parent_id,category_id)")->row();
      if (is_object($resprosub) && !empty($resprosub)) {

        //With location and category
        $locId = get_db_field_value("wps_meta_tags", "meta_id", "WHERE page_url = '" . $st . "'");
        $resprosubloc = $this->db->query("SELECT * FROM wps_subcontent WHERE status = '1' AND FIND_IN_SET($parent_id,category_id) AND FIND_IN_SET($locId,location_id)")->row();
        if (is_object($resprosubloc) && !empty($resprosubloc)) {//With location and category
          $key1 = $resprosubloc->meta_key1;
          $key2 = $resprosubloc->meta_key2;
          $key3 = $resprosubloc->meta_key3;
          $parentdata['category_description'] = str_replace('{catname}', $page_title, str_replace('{location}', ucwords(locationName($st)), str_replace('{key3}', $key3, str_replace('{key2}', $key2, str_replace('{key1}', $key1, $resprosubloc->description)))));
          if ($resprosubloc->page_heading != '') {
            $page_title = str_replace('{catname}', $page_title, str_replace('{location}', ucwords(locationName($st)), str_replace('{key3}', $key3, str_replace('{key2}', $key2, str_replace('{key1}', $key1, $resprosubloc->page_heading)))));
          } else {
            $page_title .= ' In ' . ucwords(locationName($st));
          }
        } else {//With category only
          $key1 = $resprosub->meta_key1;
          $key2 = $resprosub->meta_key2;
          $key3 = $resprosub->meta_key3;
          $parentdata['category_description'] = str_replace('{catname}', $page_title, str_replace('{location}', ucwords($st), str_replace('{key3}', $key3, str_replace('{key2}', $key2, str_replace('{key1}', $key1, $resprosub->description)))));
          if ($resprosub->page_heading != '') {
            $page_title = str_replace('{catname}', $page_title, str_replace('{location}', ucwords(locationName($st)), str_replace('{key3}', $key3, str_replace('{key2}', $key2, str_replace('{key1}', $key1, $resprosub->page_heading)))));
          } else {
            $page_title .= ' In ' . ucwords(locationName($st));
          }
        }
      }
    }
    $data['parentres'] = isset($parentdata) && is_array($parentdata) ? $parentdata : "";


    if ($parent_id > 0) {
      $data['catid'] = $parent_id;
      $conArray = array('field' => "*,( SELECT COUNT(category_id) FROM wps_categories AS b WHERE b.parent_id=a.category_id ) AS total_subcategories", 'condition' => "AND parent_id = '$parent_id' AND status='1' ", //'limit'=>10,//'offset'=>$offset,'debug' => FALSE
      );
      $data['heading_title'] = $parentdata['category_name'];
      $resArray = $this->category_model->getcategory($conArray);
      $data['totalRecord'] = $this->category_model->total_rec_found;
      $data['resleft'] = $resArray;
      $data['page_title'] = $page_title;
      $this->load->view('category/view_category', $data);
    } else {
      $data['page_title'] = 'Category List';
      $this->load->view('category/view_category', $data);
    }
  }

  public function ajax_load_category_view() {
    $data['title'] = 'Ajax Load Category';
    //For Paging
    $config['per_page'] = $this->config->item('per_page');
    $offset = $this->input->get_post('stOffSet');
    if (array_key_exists('entity_id', $this->meta_info) && $this->meta_info['entity_id'] > 0) {
      $parent_segment = (int) $this->meta_info['entity_id'];
    } else {
      $parent_segment = (int) $this->input->get_post('category_id');
    }
    $page_segment = find_paging_segment();
    $parent_id = ( $parent_segment > 0 ) ? $parent_segment : '0';

    //cat result
    $condtion_array = array('field' => "*,( SELECT COUNT(category_id) FROM wps_categories AS b WHERE b.parent_id=a.category_id ) AS total_subcategories", 'condition' => "AND parent_id = '$parent_id' AND status='1' ", 'limit' => $config['per_page'], 'offset' => $offset, 'debug' => FALSE);
    $res_array = $this->category_model->getcategory($condtion_array);
    $config['total_rows'] = $this->category_model->total_rec_found;
    $data['res'] = $res_array;
    $this->load->view('category/ajax_load_category', $data);
  }

}

/* End of file member.php */
/* Location: .application/modules/products/controllers/products.php */