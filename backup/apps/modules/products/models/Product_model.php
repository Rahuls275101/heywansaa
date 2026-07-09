<?php



if (!defined('BASEPATH'))

  exit('No direct script access allowed');



class Product_model extends MY_Model {



  public $rating_label = array(

      '1' => array("Worst Product", "Disappointed", "Waste of money"),

      '2' => array("Bad Product", "Dissatisfied"),

      '3' => array("Average Product", "Value for money", "Workable"),

      '4' => array("Nice Product", "Recommended"),

      '5' => array('Excellent', "Great Product", "Best in the market", "Highly recommended")

  );



  public function get_products($limit = '10', $offset = '0', $param = array()) {
    $sort_by = $this->db->escape_str(trim($this->input->get_post('sort_by', TRUE)));
    $category_id = @$param['category_id'];



    $status = @$param['status'];



    $productid = @$param['productid'];



    $orderby = @$param['orderby'];



    $groupby = @$param['groupby'];



    $where = @$param['where'];



    $price = @$param['price'];



    $newarrival = @$param['newarrival'];



    $bestseller = @$param['bestseller'];



    $popular = @$param['popular'];



    $color = @$param['color'];



    $size = @$param['size'];



    $latest_product = @$param['latest_product'];



    $keyword = trim($this->input->get_post('keyword', TRUE));

    $keyword = $this->db->escape_str($keyword);



    $search_keyword = trim($this->input->get_post('keywordSearch', TRUE));

    $search_keyword = $this->db->escape_str($search_keyword);



  

    

    if (!empty($newarrival)) {

      $this->db->where("wlp.newarrival_product = '" . $newarrival . "'");

    }

    //used in sitepanel only//
    if (@$sort_by != '') {
      if($sort_by=='Out Of Stock'){
        $this->db->where("wlp.product_qty = '0'");
      }else if($sort_by=='Low Stock'){
        $this->db->where("wlp.product_qty <= 10");
      }else if($sort_by=='In Stock'){
        $this->db->where("wlp.product_qty > 0");
      }
    }
    //used in sitepanel only//

    if (!empty($bestseller)) {

      $this->db->where("wlp.bestseller_product = '" . $bestseller . "'");

    }

    if (!empty($popular)) {

      $this->db->where("wlp.popular_product = '" . $popular . "'");

    }

    if (!empty($latest_product)) {

      $this->db->where("wlp.latest_product = '" . $latest_product . "'");

    }

    if (!empty($price)) {

      $price = explode('-', $price);

      if ($price[0] <= 0) {

        $this->db->where("wlp.product_price <= '$price[1]'");

      } elseif ($price[1] <= 0) {

        $this->db->where("wlp.product_price >= '$price[0]'");

      } else {

        $this->db->where("wlp.product_price between '$price[0]' AND '$price[1]'");

      }

    }

    if (!empty($color)) {

      if (strstr($color, ',')) {

        $cl = explode(',', $color);

        $clStr = "(";

        foreach ($cl as $c => $cval) {

          $clStr .= 'FIND_IN_SET (' . $cval . ',wlp.color_ids) OR ';

        }

        $clStr = substr($clStr, 0, -3);

        $clStr .= ")";

        $this->db->where($clStr);

      } else {

        $this->db->where("FIND_IN_SET ($color,wlp.color_ids)");

      }

    }

    if (!empty($size)) {

      if (strstr($size, ',')) {

        $cl = explode(',', $size);

        $clStr = '(';

        foreach ($cl as $c => $cval) {

          $clStr .= 'FIND_IN_SET (' . $cval . ',wlp.size_ids) OR ';

        }

        $clStr = substr($clStr, 0, -3);

        $clStr .= ')';

        $this->db->where($clStr);

      } else {

        $this->db->where("FIND_IN_SET ($size,wlp.size_ids)");

      }

    }



    if ($category_id != '') {

      $this->db->where("FIND_IN_SET('" . $category_id . "',wlp.category_links) AND category_id!=''");

    }

    if ($productid != '') {

      $this->db->where("wlp.products_id  ", "$productid");

    }

    if ($status != '') {

      $this->db->where("wlp.status", "$status");

    }

    if ($where != '') {

      $this->db->where($where);

    }

    if ($keyword != '') {

      $this->db->where("(LOWER(wlp.product_name) LIKE '%" . strtolower($keyword) . "%' OR LOWER(wlp.product_code) LIKE '%" . strtolower($keyword) . "%')");

    }

    if ($search_keyword != '') {

      $this->db->where("(LOWER(wlp.product_name) LIKE '%" . strtolower($search_keyword) . "%' OR LOWER(wlp.product_code) LIKE '%" . strtolower($search_keyword) . "%')");

    }



    if ($orderby != '') {

      $this->db->order_by($orderby);

    }

    if ($limit > 0) {

      if (applyFilter('NUMERIC_WT_ZERO', $offset) == -1) {

        $offset = 0;

      }

      $this->db->limit($limit, $offset);

    }



    if ($groupby) {

      $this->db->group_by($groupby);

    } else {

      $this->db->group_by("wlp.products_id");

    }

    $this->db->select('SQL_CALC_FOUND_ROWS wlp.*,wlpm.media,wlpm.media_type,wlpm.is_default', FALSE);

    $this->db->from('wps_products as wlp');

    if ($this->uri->segment(1) != 'sitepanel') {

      $this->db->where('wlp.status !=', '2');

    }
    $this->db->where('wlpm.is_default =', 'Y');

    $this->db->join('wps_products_media AS wlpm', 'wlp.products_id=wlpm.products_id', 'left');

    $q = $this->db->get();

    //echo_sql(); die;

    $result = $q->result_array();

    return $result;

  }



  public function get_product_media($limit = '5', $offset = '0', $param = array()) {

    $default = @$param['default'];

    $productid = @$param['productid'];

    $media_type = @$param['media_type'];



    if (is_array($param) && !empty($param)) {

      $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);

      $this->db->limit($limit, $offset);

      $this->db->from('wps_products_media');

      $this->db->where('products_id', $productid);
      $this->db->order_by("id", "asc");



      if ($default != '') {

        $this->db->where('is_default', $default);

      }

      if ($media_type != '') {

        $this->db->where('media_type', $media_type);

      }



      $q = $this->db->get();

      $result = $q->result_array();

      $result = ($limit == '1') ? $result[0] : $result;

      return $result;

    }

  }



  public function update_viewed($id, $counter = 0) {

    $id = (int) $id;

    if ($id > 0) {

      $posted_data = array(

          'products_viewed' => ($counter + 1)

      );

      $where = "products_id = '" . $id . "'";

      $this->category_model->safe_update('wps_products', $posted_data, $where, FALSE);

    }

  }



  public function get_related_products($condition) {

    $condtion = (!empty($condition)) ? "status !='2'  $condition" : "status !='2'";

    $fetch_config = array(

        'condition' => $condtion,

        'order' => "products_id DESC",

        'limit' => 'NULL',

        'start' => 'NULL',

        'debug' => FALSE,

        'return_type' => "array"

    );

    $result = $this->findAll('wps_products', $fetch_config);

    return $result;

  }



  public function related_products($res, $limit = 'NULL', $start = 'NULL') {

    $condtion = array();

    $condtion['where'] = "wlp.status ='1' AND wlp.products_id IN(SELECT wpr.related_id FROM wps_products_related as wpr WHERE wpr.product_id ='" . $res['products_id'] . "') ";

    $res_data = $this->get_products($limit, $start, $condtion);

    return $res_data;

  }



  public function product_attributes($param = array()) {

    $res_data = array();

    $where = @$param['where'];

    $limit = @$param['limit'];

    $offset = @$param['offset'];

    $query_attr = "SELECT * FROM wps_product_attributes  as wlc WHERE status!='2' AND ";

    if ($where != '') {

      $query_attr .= $where;

    }

    $query_attr = trim($query_attr, "AND");

    if ($limit > 0) {

      $query_attr .= " LIMIT $offset,$limit";

    }

    $q = $this->db->query($query_attr);

    $result = $q->result_array();

    //$res_total =  $this->db->query("Select FOUND_ROWS() as total")->row_array();

    //$this->total_recs = $res_total['total'];

    return $result;

  }



  public function get_product_base_price($param = array()) {

    $where = @$param['where'];

    $this->db->select('*', FALSE);

    $this->db->from('wps_product_attributes');

    if ($where != '') {

      $this->db->where($where);

    }

    $q = $this->db->get();

    // echo_sql();

    $result = $q->row_array();

    return $result;

  }



  public function related_sizes($param = array()) {

    $where = @$param['where'];

    $limit = @$param['limit'];

    $offset = @$param['offset'];



    $query_size = "SELECT SQL_CALC_FOUND_ROWS wls.size_name,wls.size_id,wls.status as size_status FROM wps_sizes as wls WHERE wls.status!='2' AND ";

    if ($where != '') {

      $query_size .= $where;

    }

    $query_size = trim($query_size, "AND");

    if ($limit > 0) {

      $query_size .= " LIMIT $offset,$limit";

    }

    $q = $this->db->query($query_size);

    $result = $q->result_array();

    $res_total = $this->db->query("Select FOUND_ROWS() as total")->row_array();

    $this->total_recs = $res_total['total'];

    return $result;

  }



  public function related_colors($param = array()) {

    $res_data = array();

    $where = @$param['where'];

    $limit = @$param['limit'];

    $offset = @$param['offset'];

    $query_size = "SELECT SQL_CALC_FOUND_ROWS wlc.color_name,wlc.status as color_status,wlc.color_code,wlc.color_id FROM wps_colors as wlc WHERE wlc.status!='2' AND ";

    if ($where != '') {

      $query_size .= $where;

    }

    $query_size = trim($query_size, "AND");

    if ($limit > 0) {

      $query_size .= " LIMIT $offset,$limit";

    }

    $q = $this->db->query($query_size);

    $result = $q->result_array();

    $res_total = $this->db->query("Select FOUND_ROWS() as total")->row_array();

    $this->total_recs = $res_total['total'];

    return $result;

  }



  public function get_size_quantity_old($colorId, $productId) {

    $qty = $this->db->query("SELECT * FROM wps_product_attributes WHERE product_id ='" . $productId . "'")->result_array();

    // print_r($qty); die;

    $size_quantity = array();

    $size = array();

    foreach ($qty as $key => $value) {

      $res_size = $this->db->query("SELECT size_name FROM wps_sizes WHERE status='1' AND size_id ='" . $value['size_id'] . "'")->row_array();

      $size_quantity['sizeName'] = $res_size['size_name'];

      $size_quantity['sizeId'] = $value['size_id'];

      $size_quantity['sizeQuantity'] = $value['quantity'];

      $size_quantity['price'] = $value['product_price'];

      $size_quantity['discountedPrice'] = $value['product_discounted_price'];

      $size[] = $size_quantity;

    }

    return $size;

  }



  public function get_size_quantity($colorId, $productId) {

    $qty = get_db_field_value("wps_products", "size_ids", "WHERE products_id ='" . $productId . "'");

    $sizes = explode(',', $qty);

    $size_quantity = array();

    $size = array();

    foreach ($sizes as $key => $value) {

      $res_size = $this->db->query("SELECT size_name FROM wps_sizes WHERE status='1' AND size_id ='" . $value . "'")->row_array();

      $sizeQty = $this->db->query("SELECT * FROM wps_product_attributes WHERE product_id ='" . $productId . "' AND color_id = '" . $colorId . "' AND size_id = '" . $value . "'")->row_array();

      $size_quantity['sizeName'] = $res_size['size_name'];

      $size_quantity['sizeId'] = $value;

      $size_quantity['sizeQuantity'] = (isset($sizeQty['quantity']) && $sizeQty['quantity'] > 0) ? $sizeQty['quantity'] : 0;

      $size_quantity['price'] = (isset($sizeQty['product_price']) && $sizeQty['product_price'] > 0) ? $sizeQty['product_price'] : 0;

      $size_quantity['discountedPrice'] = (isset($sizeQty['product_discounted_price']) && $sizeQty['product_discounted_price'] > 0) ? $sizeQty['product_discounted_price'] : 0;

      $size[] = $size_quantity;

    }

    return $size;

  }



  public function get_rating_by_product_user($productId, $userId) {

    return $this->db->select('ads_rating as rating')->from('wps_review')->where('product_id', $productId)->where('customer_id', $userId)->where('status', '1')->get()->row_array();

  }



  public function get_reviews_by_product($productId) {

    $reviews = $this->db->select('*')->from('wps_review')->where('product_id', $productId)->where('text !=', '')->where('ads_rating !=', '0')->where('status', '1')->get()->result_array();



    $reviews_with_ratings = $this->db->select('*')->from('wps_review')->where('product_id', $productId)->where('ads_rating !=', '0')->where('status', '1')->get()->result_array();



    $reviews_count = $this->db->select('COUNT(*) as total_reviews')->where('ads_rating !=', '0')->from('wps_review')->where('product_id', $productId)->where('status', '1')->where('text !=', '')->get()->result_array();

    $average_rating = $this->db->select('AVG(ads_rating) as average_review_rating')->from('wps_review')->where('product_id', $productId)->where('status', '1')->get()->result_array();



    $ratings_count = $this->db->select('COUNT(*) as total_ratings')->from('wps_review')->where('product_id', $productId)->where('status', '1')->where('text', '')->get()->result_array();

    // print_r($ratings_count[0]['total_ratings']);

    if (count($reviews_with_ratings) > 0) {

      $rating_detailed_count = array();

      $count_one = 0;

      $count_two = 0;

      $count_three = 0;

      $count_four = 0;

      $count_five = 0;

      $review_array = array();

      foreach ($reviews_with_ratings as $review_rating) {

        switch ($review_rating['ads_rating']) {

          case '1': {

              $count_one++;

              break;

            }

          case '2': {

              $count_two++;

              break;

            }

          case '3': {

              $count_three++;

              break;

            }

          case '4': {

              $count_four++;

              break;

            }

          case '5': {

              $count_five++;

              break;

            }

          default : break;

        }

      }

      if ($reviews > 0) {

        foreach ($reviews as $review) {

          $review_images = get_reviews_media($review['review_id']);

          $review_array[] = array(

              'reviewId' => $review['review_id'],

              'productId' => $review['product_id'],

              'comment' => $review['text'],

              'productRating' => $review['ads_rating'],

              'reviewImages' => $review_images,

              'userName' => $review['author'],

              'ratingLabel' => $review['rating_label']

          );

        }

      }

      $review_detailed_count = array(

          'oneCount' => $count_one,

          'twoCount' => $count_two,

          'threeCount' => $count_three,

          'fourCount' => $count_four,

          'fiveCount' => $count_five,

          'totalReviewsCount' => $reviews_count[0]['total_reviews'],

          'totalRatingsCount' => $ratings_count[0]['total_ratings'],

          'averageReviewsRatingCount' => $average_rating[0]['average_review_rating']

      );

      return $data = array('reviews' => $review_array, 'reviews_count' => $review_detailed_count);

    }

  }



  public function get_review_by_user($userId) {

    $reviews = $this->db->select('*')->from('wps_review')->where('customer_id', $userId)->where('status', '1')->where('text !=', '')->where('ads_rating !=', '0')->get()->result_array();

    if (count($reviews) > 0) {

      $review_array = array();

      foreach ($reviews as $review) {

        $product = get_product_by_id($review['product_id']);

        // print_r($product); die;

        $review_images = get_reviews_media($review['review_id']);

        $user = $this->users_model->get_member_row($review['customer_id']);

        // print_r($review_images); die;

        $review_array[] = array(

            'reviewId' => $review['review_id'],

            'productId' => $review['product_id'],

            'productName' => $review['author'],

            'productImage' => $product['image'],

            'comment' => $review['text'],

            'productRating' => $review['ads_rating'],

            'reviewImages' => $review_images,

            'userName' => $user['first_name'],

            'ratingLabel' => $review['rating_label']

        );

      }

      return $review_array;

    } else {

      return '0';

    }

  }



  public function remove_review_image($reviewImageId) {

    $this->db->set('status', '0');

    $this->db->where('id', $reviewImageId);

    $this->db->update('wps_reviews_media');

  }



  public function getPrice($subcatId) {

    return $review = $this->db->select('max(product_price) as maxPrice, min(product_price) as minPrice')->from('wps_products')->where('category_id', $subcatId)->where('status', '1')->get()->row_array();

  }

  public function send_enquiry($name, $email, $mobile, $size, $comment){
      $data = array(
            'type' => 2,
            'email' => $email,
            'first_name' => $name,
            'mobile_number' => $mobile,
            'message' => $comment,
            'product_size' => $size,
            'custom_image' => '',
            'receive_date' => date('Y-m-d H:i:s'),
      );
      $enquiry_id = $this->safe_insert('wps_enquiry', $data, FALSE);
      if (count($_FILES) > 0) {
        foreach ($_FILES["image"]["tmp_name"] as $key => $tmp_name) {
          $file_name = $_FILES["image"]["name"][$key];
          $file_tmp = $_FILES["image"]["tmp_name"][$key];
          $ext = pathinfo($file_name, PATHINFO_EXTENSION);
          $filename = basename($file_name, $ext);
          $newFileName = $filename . time() . "." . $ext;
          move_uploaded_file($file_tmp = $_FILES["image"]["tmp_name"][$key], "uploaded-files/custom_design/" . $newFileName);
          $uploaded_file[] = $newFileName; 
        }
        $data2 = array(
           'custom_image' => implode(',', $uploaded_file),
        );
        $this->db->where(array('id' => $enquiry_id));
        $this->db->update('wps_enquiry', $data2);
      }
  }



  public function review($productId, $rating, $userId, $comment) {

    $userDets = get_db_single_row("wps_customers", "first_name, last_name, email", "customers_id = '" . $userId . "'");

    $label_for_rating = '';

    foreach ($this->rating_label as $prating => $rating_label) {

      if ($prating == $rating) {

        $label_for_rating = $rating_label[rand(0, count($rating_label) - 1)];

      }

    }

    $review = $this->db->select('*')->from('wps_review')->where('customer_id', $userId)->where('product_id', $productId)->where('status', '1')->get()->row_array();
    $reviewId=$review['review_id'];

    if (count($review) > 0) {

      $data = array(

          'ads_rating' => $rating,

          'text' => $comment,

          'rating_label' => $label_for_rating

      );

      $this->db->where(array('customer_id' => $userId, 'product_id' => $productId));

      $this->db->update('wps_review', $data);

      

    } else {

      $data = array(

          'product_id' => $productId,

          'ads_rating' => $rating,

          'customer_id' => $userId,

          'text' => $comment,

          'author' => $userDets['first_name'] . ' ' . $userDets['last_name'],

          'author_email' => $userDets['email'],

          'entity_type' => 'product',

          'rating_label' => $label_for_rating,

          'review_date' => date('Y-m-d'),

      );

      $reviewId = $this->safe_insert('wps_review', $data, FALSE);

    }

    if (count($_FILES) > 0) {

      foreach ($_FILES["image"]["tmp_name"] as $key => $tmp_name) {

        $file_name = $_FILES["image"]["name"][$key];

        $file_tmp = $_FILES["image"]["tmp_name"][$key];

        $ext = pathinfo($file_name, PATHINFO_EXTENSION);

        $filename = basename($file_name, $ext);

        $newFileName = $filename . time() . "." . $ext;

        move_uploaded_file($file_tmp = $_FILES["image"]["tmp_name"][$key], "uploaded-files/review_images/" . $newFileName);

        $data_media = array(

            'review_id' => $reviewId,

            'media_type' => 'photo',

            'media' => $newFileName

        );

        $this->safe_insert('wps_reviews_media', $data_media, FALSE);

      }

    }

  }



  public function deleteReview($reviewId, $userId) {

    $review = $this->db->select('*')->from('wps_review')->where('review_id', $reviewId)->where('customer_id', $userId)->get()->row_array();

    if (count($review) > 0) {

      $this->db->set('status', '0');

      $this->db->where('review_id', $reviewId);

      $this->db->update('wps_review');

      return true;

    } else {

      return '0';

    }

  }
  
  
  public function get_where($tb,$where)
  { 
      $this->db->select('*');
      $this->db->where($where);
      $r=$this->db->get($tb);
      return $r->result();
  }
  
  public function get_where_array($query)
  { 

     if( $r=$this->db->query($query))
     {
         return $r->result_array();
     }
     else
     {
         return null;
     }
      
  }
  
      public function inserter_master($tb,$data)
      {
          if($this->db->insert($tb,$data))
          {
            return true;
          }
          else
          {
              return false;
          }
      }
  
     public function get_search_count($condition)
      {
           
          $r= $this->db->query("SELECT wps_products.*,wps_products_media.media,wps_products_media.media_type,wps_products_media.is_default FROM `wps_products` left join wps_products_media on wps_products_media.products_id=wps_products.products_id where  $condition ")->result_array();
          return count($r);
      }
      public function get_data_by_keyword($condition)
      {
            // print_r( $offset);die;
          
          $r= $this->db->query("SELECT wps_products.*,wps_products_media.media,wps_products_media.media_type,wps_products_media.is_default FROM `wps_products` left join wps_products_media on wps_products_media.products_id=wps_products.products_id where  $condition")->result_array();
            return $r; 
      }
      
      public function get_best_seller_products()
      {
          
          $d=$this->db->select('best_seller_limit')->where('admin_id','1')->get('wps_admin')->row_array();
          $count_best_seller=(int)$d['best_seller_limit'];
          $query="SELECT count(wps_orders_products.products_id) as count_best_seller, wps_products.*, wps_products_media.media FROM `wps_orders_products` inner join wps_products on wps_products.products_id=wps_orders_products.products_id inner join wps_products_media on wps_products_media.products_id=wps_products.products_id where wps_products.status='1' and wps_products_media.is_default='Y' group by wps_orders_products.products_id order by count_best_seller desc limit $count_best_seller";
          if($r = $this->db->query($query))
          {
              return  $r->result_array();
          }
          else
          {
              return false;
          }
      }
     
     public function get_seasonal_delights_products()
     {
          $query="SELECT 
wps_products.*,
wps_products_media.media 
FROM `wps_products` 
inner join wps_products_media on wps_products_media.products_id=wps_products.products_id 
where wps_products.status='1' 
and seasonal_delights='1'
and wps_products_media.is_default='Y'";
          if($r = $this->db->query($query))
          {
              return  $r->result_array();
          }
          else
          {
              return false;
          } 
     }
}