<?php

class Products extends Public_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('category/category_model', 'products/product_model', 'admin/color_model', 'admin/size_model'));
    $this->load->helper(array('products/product', 'category/category'));
     $this->load->library(array('Dmailer', 'safe_encrypt'));
  }

  public function index() {
    //Product Price Sort Query
    //SELECT product_price, (case when (product_discounted_price > 0) THEN product_discounted_price ELSE product_price END) as price from wps_products order by price
    $this->page_section_ct = 'product';
    $condtion = array();
    $cat_res = '';
    $record_per_page = (int) $this->input->post('per_page');
    $category_id = (int) $this->uri->segment(3);
    $page_segment = find_paging_segment();
    $config['per_page'] = ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
    $offset = (int) $this->uri->segment($page_segment, 0);
    $base_url = ( $category_id != '' ) ? "products/index/$category_id/pg/" : "products/index/pg/";
    $condtion['status'] = '1';

    if ($this->input->post('keywordSearch')) {
      $page_title = "Search Result - (" . strtoupper($this->input->post('keywordSearch')) . ")";
    } else {
      $page_title = "Products List";
    }

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

    //Filter
    $type = $this->uri->segment(1);
    if ($type != "") {
      if ($type == 'latest') {
        $condtion['latest_product'] = '1';
        $page_title = "Latest Products";
      }
      if ($type == 'best-seller') {
        $condtion['bestseller'] = '1';
        $page_title = "Best Seller Products";
      }
      if ($type == 'popular') {
        $condtion['popular'] = '1';
        $page_title = "Popular Products";
      }
      if ($type == 'new-arrival') {
        $condtion['newarrival'] = '1';
        $page_title = "New Arrival Products";
      }
    }
    
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

    if ($category_id > 0) {
      $condtion['category_id'] = $category_id;
      $cat_res = get_db_single_row('wps_categories', '*', " category_id='$category_id'");
      $page_title = $cat_res['category_name'];
    }
    $data['catid'] = '';
    $res_array = $this->product_model->get_products($config['per_page'], $offset, $condtion);

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
    /* Available Size Records */
    
   
    $data['total_rows'] = $data['total_list_rows'] = $config['total_rows'] = get_found_rows();
    $data['heading_title'] = $page_title;
    $data['products'] = $res_array;
    $data['cat_res'] = $cat_res;

     
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

  
  

   public function newarrival() 
   {
        $this->page_section_ct = 'product';
        $condtion = array();
        $cat_res = '';
        $record_per_page = (int) $this->input->post('per_page');
        $category_id = (int) $this->uri->segment(3);
        $page_segment = find_paging_segment();
        $config['per_page'] = ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
        $offset = (int) $this->uri->segment($page_segment, 0);
        $base_url = ( $category_id != '' ) ? "products/index/$category_id/pg/" : "products/index/pg/";
        $condtion['status'] = '1';
        $condtion['newarrival'] = '1';

        if ($this->input->post('keywordSearch')) {
          $page_title = "Search Result - (" . strtoupper($this->input->post('keywordSearch')) . ")";
        } else {
          $page_title = "New Arrival Products";
        }

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
        

        //Filter
        $type = $this->uri->segment(1);
        if ($type != "") {
          if ($type == 'latest') {
            $condtion['latest_product'] = '1';
            $page_title = "Latest Products";
          }
          if ($type == 'best-seller') {
            $condtion['bestseller'] = '1';
            $page_title = "Best Seller Products";
          }
          if ($type == 'popular') {
            $condtion['popular'] = '1';
            $page_title = "Popular Products";
          }
          if ($type == 'new-arrival') {
            $condtion['newarrival'] = '1';
            $page_title = "New Arrival Products";
          }
        }
        
        $color = $this->input->post('color');
        $size = $this->input->post('size');
        $price = $this->input->post('price');

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

        if ($category_id > 0) {
          $condtion['category_id'] = $category_id;
          $cat_res = get_db_single_row('wps_categories', '*', " category_id='$category_id'");
          $page_title = $cat_res['category_name'];
        }
        $data['catid'] = '';
        $res_array = $this->product_model->get_products($config['per_page'], $offset, $condtion);
        $res_array2 = $this->product_model->get_products('5000', $offset, $condtion);
        $data['total_rows'] = $data['total_list_rows'] = $config['total_rows'] = get_found_rows();
        $data['heading_title'] = $page_title;
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
        /* Available Size Records */

        $this->load->view('products/view_product_listing', $data);
  }

   

  public function sale() {
   
    $this->page_section_ct = 'product';
    $condtion = array();
    $cat_res = '';
    $record_per_page = (int) $this->input->post('per_page');
    $category_id = (int) $this->uri->segment(3);
    $page_segment = find_paging_segment();
    $config['per_page'] = ( $record_per_page > 0 ) ? $record_per_page : $this->config->item('per_page');
    $offset = (int) $this->uri->segment($page_segment, 0);
    $base_url = ( $category_id != '' ) ? "products/index/$category_id/pg/" : "products/index/pg/";
    $condtion['status'] = '1';
    $condtion['popular'] = '1';

    if ($this->input->post('keywordSearch')) {
      $page_title = "Search Result - (" . strtoupper($this->input->post('keywordSearch')) . ")";
    } else {
      $page_title = "Products On Sale";
    }

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
    

    //Filter
    $type = $this->uri->segment(1);
    if ($type != "") {
      if ($type == 'latest') {
        $condtion['latest_product'] = '1';
        $page_title = "Latest Products";
      }
      if ($type == 'best-seller') {
        $condtion['bestseller'] = '1';
        $page_title = "Best Seller Products";
      }
      if ($type == 'popular') {
        $condtion['popular'] = '1';
        $page_title = "Popular Products";
      }
      if ($type == 'new-arrival') {
        $condtion['newarrival'] = '1';
        $page_title = "New Arrival Products";
      }
    }
    
    $color = $this->input->post('color');
    $size = $this->input->post('size');
    $price = $this->input->post('price');

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
    

    if ($category_id > 0) {
      $condtion['category_id'] = $category_id;
      $cat_res = get_db_single_row('wps_categories', '*', " category_id='$category_id'");
      $page_title = $cat_res['category_name'];
    }
    $data['catid'] = '';
    $res_array = $this->product_model->get_products($config['per_page'], $offset, $condtion);
    $data['total_rows'] = $data['total_list_rows'] = $config['total_rows'] = get_found_rows();
    $data['heading_title'] = $page_title;
    $data['products'] = $res_array;
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
    /* Available Size Records */
   

    $this->load->view('products/view_product_listing', $data);
  }

  public function ajax_load_product_view() {

    $data['title'] = 'Ajax Load Products';
    $config['per_page'] = $this->config->item('per_page');
    $offset = $this->input->get_post('stOffSet');

    if ($this->input->get_post('category_id')) {
      $parent_segment = (int) $this->input->get_post('category_id');
    } else {
      $parent_segment = (int) $this->input->get_post('category_id');
    }
    $page_segment = find_paging_segment();
    $parent_id = ( $parent_segment > 0 ) ? $parent_segment : '0';

    $condtion['status'] = '1';
    $page_title = "Products List";
    if ($parent_id > 0) {
      $condtion['category_id'] = $parent_id;
      $cat_res = get_db_single_row('wps_categories', '*', " category_id='$parent_id'");
      $page_title = $cat_res['category_name'];
      $data['catid'] = $parent_id;
    }

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
    

    $type = $this->input->get_post('type');
    if ($type != "") {
      if ($type == 'latest') {
        $condtion['latest_product'] = '1';
      }
      if ($type == 'best-seller') {
        $condtion['bestseller'] = '1';
      }
      if ($type == 'popular') {
        $condtion['popular'] = '1';
      }
      if ($type == 'new-arrival') {
        $condtion['newarrival'] = '1';
      }
    }

    if ($this->input->get_post('keywordSearch') != '') {
      $condtion['keywordSearch'] = $this->input->get_post('keywordSearch');
    }

    $color = $this->input->post('color');
    $size = $this->input->post('size');
    $price = $this->input->post('price');

    if (!empty($color)) {
      //$colors = implode(',', $color);
      $condtion['color'] = $color;
    }
    if (!empty($size)) {
      //$sizes = implode(',', $size);
      $condtion['size'] = $size;
    }
    if (!empty($price)) {
      $condtion['price'] = $price;
    }
    

    $res_array = $this->product_model->get_products($config['per_page'], $offset, $condtion);
    $data['listRes'] = $res_array;
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
    /* Available Size Records */
    
    $this->load->view('products/ajax_load_products', $data);
  }

  public function detail() 
  {
      
      
    
    $this->page_section_ct = 'product';
    $data['unq_section'] = "Product";
    $productId = (int) $this->meta_info['entity_id'];
    
   
    
    $where = "wlp.products_id = '" . $productId . "' and wlp.status='1'";
    $option = array(
        'fields' => "SQL_CALC_FOUND_ROWS wlp.*,wlc.first_name,wlc.user_name,wlc.mobile_number,wlcat.category_id",
        'where' => $where
    );
    $res = $this->product_model->get_products('1', '', $option);
    if (is_array($res) && !empty($res)) {
      $res = $res[0];
      // Recent View
      $id = $res['products_id'];
      $ee = $this->session->userdata('recent_view');
      if (is_array($ee)) {
        if (!@in_array($id, $ee)) {
          @array_push($ee, $id);
          $this->session->set_userdata('recent_view', $ee);
        }
      } else {
        $this->session->set_userdata('recent_view', array($id));
      }
      // End Here

      // $this->load->model('comments/comments_model');
      // $data['error_validate'] = TRUE;

      $data['title'] = "Product";
      $data['res'] = $res;
       $this->set_recent_view($res);
      $this->product_model->update_viewed($res['products_id'], $res['products_viewed']);
      $media_res = $this->product_model->get_product_media(6, 0, array('productid' => $res['products_id']));
      $data['media_res'] = $media_res;
      $related_products = $this->get_product_related_list($res['category_id'], $productId);
      $data['related'] = $related_products;
      //End

      $data['REMARKSS'] = $this->config->item('REMARKS'); 
      
      $where=array('products_id'=>$res['products_id']);
      $data['hide_price_status']=$this->product_model->get_where('wps_products',$where);
      
      
      $where=array('product_id'=>$res['products_id']);
      $data['variant']=$this->product_model->get_where('product_variant',$where);



      $data['colors']=$this->db->query("select id,color_id from product_variant where product_id='".$res['products_id']."' group by color_id")->result();

      $data['sizes']=$this->db->query("select distinct(size_id) from product_variant where product_id='".$res['products_id']."' group by color_id")->result();




//  echo    $this->input->cookie('demo',true);
//         die;



    $data['meta_data']=$this->db->query("SELECT * FROM `wps_meta_tags` where entity_type='products/detail' and entity_id='$productId'  limit 1")->result_array();





      $this->load->view('products/view_product_details', $data);
    } else {
      redirect('products', '');
    }
  }
    
    
    
    // set_recent_view($productId) by raaz
    public function set_recent_view($res)
    {
        // $res['products_id'];
        //  $this->session->unset_userdata('recent_data');
        
       if($this->session->userdata('recent_data'))
       {
           $array=$this->session->userdata('recent_data');
          $is_exist=0;
           foreach($array as $ar=>$arr)
           {
               if(isset($arr['products_id']))
               {
                    if($res['products_id']==$arr['products_id'])
                    {
                        $is_exist=1;
                    //   echo "id existed"; die;
                    }
               }
           }
           if($is_exist==0)
           {
               $array[]=$res;
               $this->session->set_userdata('recent_data',$array);
           }
       }
       else
       {
           $this->session->set_userdata('recent_data',$res);
       }
       return true;
    }

  public function enquireNow() {
    
    $this->form_validation->set_rules('name', 'Name', 'trim|required|alpha');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('phone', 'Mobile Number', 'trim|required|max_length[15]|min_length[10]');
    $this->form_validation->set_rules('message', 'Message', 'trim|xss_clean|required|max_length[500]|alpha_numeric_spaces');
    $this->form_validation->set_rules('captcha', 'Captcha', 'trim|required');
    $this->form_validation->set_rules('product_id', 'Product Id', 'trim|required');

    if ($this->form_validation->run() == TRUE) {
        $posted_data = array(
            'type' => '4',
            'first_name' => $this->input->post('name'),
            'products_id' => $this->input->post('product_id'),
            'post_url' => $_SERVER['HTTP_REFERER'],
            'last_name' => '',
            'email' => $this->input->post('email'),
            'mobile_number' => $this->input->post('phone'),
            'message' => $this->input->post('message'),
            'receive_date' => $this->config->item('config.date.time'),
        );
        $result = $this->product_model->safe_insert('wps_enquiry', $posted_data, false);

        $subject = "weblieu.com - Enquiry From www.weblieu.com";
         $body='<html><head></head><body>
              <table border="0" width="100%">
              <tbody>
              <tr>
              <td colspan="2">
              <strong>Dear Admin</strong></td>
              </tr>
              <tr>
              <td colspan="2">
              Enquiry&nbsp; has been submitted with following info :</td>
              </tr>
              <tr>
              <td colspan="2">
              &nbsp;</td>
              </tr>
              <tr>
              <td width="26%">
              <strong>Name : </strong></td>
              <td>
              <span style="margin-top:15px">'.$this->input->post('name').'</span></td>
              </tr>
              <tr>
              <td width="26%">
              <strong>Email : </strong></td>
              <td>
              <span style="margin-top:15px"><a href="mailto:'.$this->input->post('email').'" target="_blank">'.$this->input->post('email').'</a></span></td>
              </tr>
              <tr>
              <td width="26%">
              <strong>Mobile : </strong></td>
              <td>
              <span style="margin-top:15px">'.$this->input->post('phone').'</span></td>
              </tr>
              <tr>
              <td width="26%">
              <strong>Message : </strong></td>
              <td>
              <span style="margin-top:15px">'.$this->input->post('message').'</span></td>
              </tr>
               <tr>
              <td width="26%">
              <strong>URL : </strong></td>
              <td>
              <span style="margin-top:15px">'.$_SERVER['HTTP_REFERER'].'</span></td>
              </tr>
              <tr>
              <td colspan="2">
              &nbsp;</td>
              </tr>
              </tbody>
              </table><br/>
              <span style="margin-top:15px">
               Thank you.<br>
               '.$this->config->item('site_name').' Customer Service<br>
               Email: <a href="mailto:'.$this->admin_info->admin_email.'" target="_blank">'.$this->admin_info->admin_email.'</a><div class="yj6qo"></div><div class="adL"> 
              </div></span></body</html>';
            if($this->admin_info->website_mode=='Live'){
                  $mail_conf = array(
                      'subject' => $subject,
                      'to_email' => $this->admin_info->admin_email, //
                      'from_email' => $this->input->post('email'),
                      'from_name' => $this->input->post('name'),
                      'reply_to' => $this->input->post('email'),
                      'body_part' => $body,
                  );
                  $this->dmailer->mail_notify($mail_conf);
                  
                  $mail_conf2 = array(
                      'subject' => "weblieu.com - Enquiry From www.weblieu.com",
                      'to_email' => 'info@weblieu.com', //
                      'from_email' => $this->input->post('email'),
                      'from_name' => $this->input->post('name'),
                      'reply_to' => $this->input->post('email'),
                      'body_part' => $body,
                  );
                  $this->dmailer->mail_notify($mail_conf2);

                  
            }else{
               $mail_conf4 = array(
                  'subject' => "weblieu.com - Enquiry From www.weblieu.com",
                  'to_email' => 'info@weblieu.com', //
                  'from_email' => $this->input->post('email'),
                  'from_name' => $this->input->post('name'),
                  'reply_to' => $this->input->post('email'),
                  'body_part' => $body,
              );
              $this->dmailer->mail_notify($mail_conf4);
            }
       $res = 'success';
    } else {
      $res = '<div class="alert alert-danger">
                      <strong>'.validation_errors().'
                  </div>';
    }

    echo $res;
    exit;
  }

   

  public function get_product_related_list($catId = "", $productId) {
    $condtion['status'] = '1';
    $condtion['where'] = "wlp.category_id = '" . $catId . "'";
    $condtion['orderby'] = 'products_id DESC';
    $product_list = $this->product_model->get_products('10', '0', $condtion);
    return $product_list;
  }

  public function get_product_price() {
    $sid = (int) $this->input->post('sid');
    $cid = (int) $this->input->post('cid');
    $pid = (int) $this->input->post('pid');

    //if ($cid > 0 && $sid > 0) {
      $res = $this->db->select('quantity,quantity,product_price,product_discounted_price')->get_where('wps_product_attributes', array('color_id' => $cid, 'size_id' => $sid, 'product_id' => $pid))->row();
      //echo_sql();
      if (is_object($res)) {
        echo $res->quantity . '-' . $res->product_price . '-' . $res->product_discounted_price;
      }
    //}
  }


  public function post_review() {
    $this->form_validation->set_error_delimiters("<div class='required'>", "</div>");
    $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[70]');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[80]|valid_email');
    $this->form_validation->set_rules('rating', 'Rating', 'trim|required|max_length[1]');
    $this->form_validation->set_rules('reviews', 'Review', 'trim|required|max_length[450]');
    if ($this->form_validation->run() === TRUE) {
      $mem_id = $this->session->userdata('user_id');
      $posted_data = array(
          'entity_id' => $this->input->get_post('products_id'),
          'entity_type' => 'product',
          'customer_id' => $mem_id,
          'ads_rating' => $this->input->post('rating'),
          'author' => $this->input->post('name'),
          'author_email' => $this->input->post('email'),
          'text' => $this->input->post('reviews'),
          'status' => '1',
          'review_date' => $this->config->item('config.date.time')
      );
      $this->product_model->safe_insert('wps_review', $posted_data, FALSE);

      $data['success'] = true;
      $data['message'] = 'Thank you. Your review has been submitted successfully';
      echo json_encode($data);
    } else {
      $data['success'] = false;
      $data['error'] = validation_errors();
      echo json_encode($data);
    }
  }

  public function check_product_exits_into_cart($pres) {
    $cart_array = $this->cart->contents();
    $insert_flag = 0;
    if (is_array($cart_array) && !empty($cart_array)) {
      foreach ($this->cart->contents() as $item) {
        if (array_key_exists('pid', $item)) {
          if ($item['pid'] == $pres['products_id']) {
            $insert_flag = 1;
          }
        }
      }
    }
    return $insert_flag;
  }
  
  
  
  
  
  public function add_bulk_enquiry()
  {

      
      $this->form_validation->set_rules('name','name','required|trim');
      $this->form_validation->set_rules('email','email','required|trim|valid_email');
      $this->form_validation->set_rules('phone','phone','required|trim');
      $this->form_validation->set_rules('qty_bulk','qty_bulk','required|trim');
      $this->form_validation->set_rules('comp_name','comp_name','required|trim');
      $this->form_validation->set_rules('city','city','required|trim');
      $this->form_validation->set_rules('state','state','required|trim');
      $this->form_validation->set_rules('message','message','required|trim');
      $this->form_validation->set_rules('need_by_date','need_by_date','required|trim');
      $this->form_validation->set_rules('sku_id','sku_id','required|trim');
      $this->form_validation->set_rules('product_id','product_id','required|trim');

      if($this->form_validation->run())
      {
          $data=array(
                    'name'=>$this->input->post('name'),
                    'email'=>$this->input->post('email'),
                    'phone'=>$this->input->post('phone'),
                    'quantity'=>$this->input->post('qty_bulk'),
                    'company_name'=>$this->input->post('comp_name'),
                    'city'=>$this->input->post('city'),
                    'state'=>$this->input->post('state'),
                    'message'=>$this->input->post('message'),
                    'need_by_date'=>$this->input->post('need_by_date'),
                    'sku_id'=>$this->input->post('sku_id'),
                    'product_id'=>$this->input->post('product_id'),
                    'user_id'=>$this->session->userdata('user_id') ?: null,
                    );

            if($this->product_model->inserter_master('wps_bulk_buy',$data))
            {
                $msg=array('Request Successfully Sent!');
                echo json_encode($msg);
            }
            else
            {
                $msg=array('Something Error');
                echo json_encode($msg);
            }
      }
      else
      {
          $msg=array(validation_errors());
                echo json_encode($msg);
      }







  }
  
  
  
    public function get_gallery_detail_page_by_color_code()
    {
       $variant_id=$this->input->post('var_id');
       $color_code=$this->input->post('color');
       
       $this->db->where('variant_id',$variant_id);
       $img_data=$this->db->get('image_by_variant')->result_array();
       
       $big_img='';
       $thumnail='';
       
       if(count($img_data)>0)
       {
                // start bigimage
                foreach($img_data as $image=>$img)
                {
                    $img_url=base_url().'uploaded-files/variant-image/'.$img['image']; 
                   $big_img.='
                   <div class="swiper-slide">
                                <figure class="product-image">
                                    <img src="'.$img_url.'" data-zoom-image="'.$img_url.'" alt="" width="800" height="900">
                                </figure>
                             </div>';
                }
                
                
                // start thumbnail
                foreach($img_data as $image=>$img)
                {
                    $img_url=base_url().'uploaded-files/variant-image/'.$img['image']; 
                    $thumnail.='<div class="product-thumb swiper-slide newthumbclass" >';
                    $thumnail.="<img src='$img_url'></div>";
                }
            $data=array('big_image'=>$big_img,'small_img'=>$thumnail,'status'=>"datafound");
            echo json_encode($data);
       }
       else
       {
           $data=array('big_image'=>$big_img,'small_img'=>$thumnail,'status'=>"not found");
            echo json_encode($data);
       }
    }

  public function search_keyword($offset=0)
    {
        
         $data['heading_title'] = "Search Result - (" . strtoupper($this->input->post('keywordSearch')) . ")";
        
        
        if($this->input->post('keywordSearch') && !$this->input->post('brand_name'))
        {
              $this->session->set_userdata('keywordSearch',$this->input->post('keywordSearch'));
              $this->session->set_userdata('brand_name',$this->input->post('cat_id'));
            //   $input_key = $this->input->post('keywordSearch'); 
            //   $brand_name=$this->input->post('cat_id');
        }
         elseif($this->input->post('keywordSearch') && $this->input->post('brand_name'))
         {
              $this->session->set_userdata('brand_name',$this->input->post('brand_name'));
              $this->session->set_userdata('keywordSearch',$this->input->post('keywordSearch'));
            //   $input_key = $this->input->post('keywordSearch');
            //   $brand_name=$this->input->post('cat_id');
         }
         else
         {
              $input_key=$this->session->userdata('keywordSearch');
              $brand_name=$this->session->userdata('brand_name');
         }
         
            //   $input_key   =   $this->input->post('keywordSearch');
            //   $brand_name  =   $this->input->post('brand_name');
                $input_key=$this->session->userdata('keywordSearch');
              $brand_name=$this->session->userdata('brand_name');
        
          $page_title = "Search Result - (" . strtoupper($input_key) . ")";
          
        //   condition start
          $condition=" wps_products.product_name like'%$input_key%' and wps_products.status !='2' and wps_products_media.is_default='Y' and status='1'";
         
          if(is_array($brand_name))
          {
            $condition.="and ( ";
              foreach($brand_name as $bn)
              {
                 $condition.=" wps_products.brand_name='$bn' or ";
              }
              $condition=substr($condition,0,-3);
        
              $condition.=")";
          }
         
          
        // coindition end  
          
          
          
          
          
          
      
        $this->load->library('pagination');
        $base_url=base_url()."products/search_keyword";
        $config['base_url'] = $base_url;
        $config['total_rows'] = $this->product_model->get_search_count($condition);
  
        
        // $config['per_page'] = 12;
        $offset = (int) $this->uri->segment(3);
        
        // $config['full_tag_open'] = "<ul class='pagination'>";
        // $config['full_tag_close'] = '</ul>';
        // $config['num_tag_open'] = '<li>';
        // $config['num_tag_close'] = '</li>';
        // $config['cur_tag_open'] = '<li class="active"><a href="#">';
        // $config['cur_tag_close'] = '</a></li>';
        // $config['prev_tag_open'] = '<li>';
        // $config['prev_tag_close'] = '</li>';
        // $config['first_tag_open'] = '<li>';
        // $config['first_tag_close'] = '</li>';
        // $config['last_tag_open'] = '<li>';
        // $config['last_tag_close'] = '</li>';
        
        $res_array = $this->product_model->get_data_by_keyword($condition);
    
      
    
    
        $data['total_rows'] = $config['total_rows'];
        $data['heading_title'] = $page_title;
        $data['products'] = $res_array;
        $data['cat_res'] = $cat_res;
        $data['input_key'] = $input_key;
        $data["links"] = $this->pagination->create_links();
        // $data['brand_name']=$this->product_model->get_all_brand_name();
        
        $data['checked_box']=$brand_name;
        //   $data['brand_name']=$this->product_model->get_all_brand_by_keyword_search($input_key);
        $this->pagination->initialize($config);
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
  
    public function filter_listing($offset=null)
	{
         
    
        $minPrice   =   $this->input->post('minPrice');
        $maxPrice   =   $this->input->post('maxPrice');
        $color      =   $this->input->post('color');
        $size       =   $this->input->post('size');	  
        $brand      =   $this->input->post('brand');	  
        
        $orderby        =   $this->input->post('orderby');
        $limit_per_page =   $this->input->post('limit_per_page');
        $category       =   trim($this->input->post('category'));
       
        $cat_data= $this->db->select('*')->where('category_name',$category)->limit(1)->get('wps_categories')->row_array();
        $category_id=$cat_data['category_id'];
        
        // SELECT * FROM table WHERE FIND_IN_SET('option', status);

        
        
        
        $condition='';
        $order_by='';
        
        if(!empty($minPrice) && !empty($maxPrice))
        {
          $condition.= " and wps_products.product_discounted_price >= '$minPrice' AND product_discounted_price<='$maxPrice'";
        }
         if(!empty($category_id))
        {
            $condition.= " and category_links='$category_id' ";
        }
         if(!empty($color) && is_array($color))
        {
            $condition.='and (';
            for($i=0;$i<count($color);$i++)
            {
                $condition.= "  product_variant.color_id ='".trim($color[$i]['value'])."' or";
            }
            $condition=substr($condition,0,-3);
            $condition.=')';
        }
        
        
         if(!empty($size) && is_array($size))
        {
            $condition.='and (';
            for($i=0;$i<count($size);$i++)
            {
                $condition.= "  product_variant.size_id ='".trim($size[$i]['value'])."' or";
            }
            $condition=substr($condition,0,-3);
            $condition.=') ';
        }
        
        if(!empty($brand))
        {
            $condition.='and (';
            for($i=0;$i<count($brand);$i++)
            {
                $condition.= "  wps_products.brand ='".trim($brand[$i]['value'])."' or";
            }
            $condition=substr($condition,0,-3);
            $condition.=') '; 
        }
        
       
       
      
         
            
            if($orderby==0)
            {
                $order_by= ' order by wps_products.product_discounted_price asc';
            }
            elseif($orderby==1)
            {
                 $order_by= ' order by wps_products.product_discounted_price asc';
            }
            elseif($orderby==2)
            {
                 $order_by= ' order by wps_products.product_discounted_price desc';
            }
            


     
        $finder_id=$cat_details['data'][0]['prod_cate_id'];
        $data['category_type']=$cat_details['type'];
        $data['category_list_filter']=array();


        $where=" where status='1' ";

      
        $groupby =' group by wps_products.products_id ';
        
        
        
        
              
        $select=" select
                 wps_products.* ,
                 wps_products_media.media ";
                    
        $join=" FROM `wps_products`
                left join wps_products_media on wps_products_media.products_id=wps_products.products_id
                left join product_variant on product_variant.product_id=wps_products.products_id ";
  
        
        
        
        
        
        
        
        
        $query= $select.$join.$where.$condition.$groupby.$order_by;
 
    
      
        $data['product_res']=$this->product_model->get_where_array($query);
        
        $html_div='';
        
        
         $html_div.= '<div class="row">';
        foreach($data['product_res'] as $prod=>$prodv)
        {
               
                    $str=$prodv['product_name'];
                    if (strlen($str) > 20)
                    {
                        $str = substr($str, 0, 20) . '...'; 
                        $str= ucwords($str); 
                    }
                    else
                    {
                        $str= ucwords($str); 
                    }
                                                                    
                       $img= get_image('products', $prodv['media'], 270, 270, 'AR');
        
            $html_div.= '
                            <div class="col-lg-3 col-md-3 col-xs-6 mb-2">
                                <div class="product-wrap">
                                    <div class="product product-simple text-center">
                                        <figure class="product-media">
                                    <a href="'.base_url($prodv['friendly_url']).'">
                                        <img src="'.$img.'" alt="'.ucwords(strtolower($prodv['product_name'])).'" 
                                        title="'.ucwords(strtolower($prodv['product_name'])).'" width="260" height="291" />
                                    </a>
                                    <!--<div class="product-action-vertical">-->
                                    <!--    <a href="#" class="btn-product-icon btn-wishlist w-icon-heart" title="Add to wishlist"></a>-->
                                    <!--</div>-->
                                </figure>
                                <div class="product-details">
                                    <h4 class="product-name"><a href="'.base_url($prodv['friendly_url']).'"> '.$str.'</a></h4>
                                    <div class="product-pa-wrapper">
                                        <div class="product-price">
                                            <a href="'.base_url($prodv['friendly_url']).'"  class="new-price">₹ '.$prodv['product_discounted_price'].' </a>
                                        </div>
                                        <!--<div class="product-action">-->
                                        <!--    <a href="'.base_url($prodv['friendly_url']).'" class="btn-cart btn-product btn btn-icon-right btn-link btn-underline">Add-->
                                        <!--        To Cart</a>-->
                                        <!--</div>-->
                                    </div>
                                </div>
                            </div>
                        </div></div>';
                                            
                      
                    
                    
                    
                    
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    
        
        
        
        
        }  
       
       
      
        echo json_encode(array('product_div'=>$html_div,'query'=>$query));
	}
	
    
  
  // ajax for variant
  public function get_variant_by_size_color_productid()
  {
    $color  = $this->input->post('color');
    $size = $this->input->post('size');
    $product_id = $this->input->post('product_id');

    $where=array('color_id'=>$color,'size_id'=>$size,'product_id'=>$product_id);
    $d['variant']=$this->product_model-> get_where('product_variant',$where);

    echo json_encode($d);   
   
  }


  public function best_seller_products()
  {
        $data['title'] = 'Best Seller';
        $condtion['status'] = '1';
        $data['products'] = $this->product_model->get_best_seller_products();
        // print_r($data['products']);die;
        $this->load->view('products/view_best_seller_products', $data);
  }

  public function seasonal_delights()
  {
        $data['title'] = 'Seasonal Delights';
        $condtion['status'] = '1';
        $data['products'] = $this->product_model->get_seasonal_delights_products();
        // print_r($data['products']);die;
        $this->load->view('products/view_best_seller_products', $data);
  }
  
  public function view_all_category()
  {
        // $data['title'] = 'Seasonal Delights';
        $condtion['status'] = '1';
        $data['products'] = $this->product_model->get_seasonal_delights_products();
        $data['category_list'] = $this->product_model->get_where_array("select * from wps_categories where 1");
        $this->load->view('products/view_all_category', $data);
  }
}
?>