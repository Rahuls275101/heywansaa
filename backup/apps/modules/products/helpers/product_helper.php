<?php
if (!function_exists('get_product_by_id')) {

  function get_product_by_id($productId, $userId = '', $condtion = "AND status='1'") {
    $ci = CI();
    $output = array();
    $sql_review = "SELECT *, text as comment from wps_review where product_id = $productId AND text <> '' AND status = '1'";
    $review_query = $ci->db->query($sql_review);

    $sql = "SELECT  * FROM wps_products WHERE products_id=$productId AND status='1'";
    $row = (array) $ci->db->query($sql)->row();
    if ($row) {
      $reviews = [];

      $status = false;
      foreach ($review_query->result_array() as $review) {
        if ($userId != '') {
          $sql_user_review = "SELECT * from wps_review where customer_id = '$userId' AND product_id = $productId AND status = '1'";
          $user_review_query = $ci->db->query($sql_user_review);
          foreach ($user_review_query->result_array() as $user_review) {
            if ($review['review_id'] == $user_review['review_id']) {
              $status = true;
              break;
            }
          }
        }

        $userId = $review['customer_id'];
        $user_sql = "SELECT * from wps_customers where customers_id = $userId";
        $user = (array) $ci->db->query($user_sql)->row();
        // print_r($user['first_name']); die;
        $image = get_reviews_media($review['review_id']);
        $reviews[] = [
            'reviewId' => $review['review_id'],
            'comment' => $review['comment'],
            'rating' => $review['ads_rating'],
            'userName' => $user['first_name'],
            'reviewImage' => $image,
            'ratingLabel' => $review['rating_label']
        ];
      }
      $rows['productId'] = $row['products_id'];
      $rows['name'] = $row['product_name'];
      $rows['subcatId'] = $row['category_id'];
      $rows['productCode'] = $row['product_code'];
      $rows['returnDays'] = ''; //$row['return_days'];
      $rows['returnPolicy'] = '';
      $rows['originalPrice'] = (int)$row['product_price'];
      $rows['review'] = $reviews;
      $rows['price'] = (int)$row['product_discounted_price'];
      // $rows['color']=$row['color_ids'];
      $rows['description'] = $row['products_description'];
      $rows['image'] = get_products_media($row['products_id']);
      $rows['status'] = $status;
      $color = explode(',', $row['color_ids']);
      $s = array();
      $ss = array();
      for ($i = 0; $i < count($color); $i++) {
        $res = $ci->db->query("SELECT color_name, color_code, color_id FROM wps_colors WHERE status='1' AND color_id ='" . $color[$i] . "'")->row_array();
        $ss['colorName'] = $res['color_name'];
        $ss['colorCode'] = $res['color_code'];
        $ss['colorId'] = $res['color_id'];
        $s[] = $ss;
      }
      $rows['color'] = $s;
      $output = $rows;
    }
    return $output;
  }

}

if (!function_exists('get_products_by_id')) {

  function get_products_by_id($id, $offset, $condtion = "AND status='1'") {
    $ci = CI();
    $output = array();
    $offset = (int) $offset * 10;
    $sql = "SELECT  * FROM wps_products WHERE category_id=$id AND status='1' ORDER BY product_name desc limit $offset, 10";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      foreach ($query->result_array() as $row) {
        $productId = $row['products_id'];
        $sql_review = "SELECT *, text as comment from wps_review where product_id = $productId AND text <> '' AND status = '1'";
        $review_query = $ci->db->query($sql_review);
        $reviews = [];
        foreach ($review_query->result_array() as $review) {
          $userId = $review['customer_id'];
          $user_sql = "SELECT * from wps_customers where customers_id = $userId";
          $user = (array) $ci->db->query($user_sql)->row();
          $name = (is_array($user)) ? $user['first_name'] : "";
          $image = get_reviews_media($review['review_id']);
          $reviews[] = [
              'reviewId' => $review['review_id'],
              'comment' => $review['comment'],
              'rating' => $review['ads_rating'],
              'userName' => $name,
              'reviewImage' => $image,
          ];
        }

        $rows['productId'] = $row['products_id'];
        $rows['name'] = $row['product_name'];
        $rows['subcatId'] = $row['category_id'];
        $rows['colorId'] = explode(',', $row['color_ids'])[0];
        // $rows['returnDays']=$row['return_days'];
        // $rows['returnPolicy']=$row['return_policy'];
        $rows['originalPrice'] = (int)$row['product_price'];
        $rows['price'] = (int)$row['product_discounted_price'];
        $rows['description'] = $row['products_description'];
        // $rows['review']=$reviews;
        $rows['image'] = array_pop(get_products_media($row['products_id']));
        $size = explode(',', $row['size_ids']);
        $s = array();
        $ss = array();
        for ($i = 0; $i < count($size); $i++) {
          $res = $ci->db->query("SELECT size_name FROM wps_sizes WHERE status = '1' AND size_id ='" . $size[$i] . "'")->result_array();
          foreach ($res as $r) {
            $ss['size_name'] = $r['size_name'];
            $qty = $ci->db->query("SELECT * FROM wps_product_attributes WHERE product_id ='" . $row['products_id'] . "' and size_id='" . $size[$i] . "'")->result_array();
            foreach ($qty as $q)
              $ss['size_quantity'] = $q['quantity'];
            $ss['size_id'] = $size[$i];
            $s[] = $ss;
          }
        }
        // $rows['size']=$s;
        $output[] = $rows;
      }
    }
    return $output;
  }

}


if (!function_exists('you_save')) {

  function you_save($price, $discount_price) {

    if ($price != '' && $discount_price != '') {
      $you_save = (($price - $discount_price) / $price) * 100;
      $you_save = formatNumberWithRounding($you_save, 2);
      $you_save = fmtZerosDecimal($you_save);
      return $you_save;
    }
  }

}


if (!function_exists('rating_html')) {

  function rating_html($rating, $max_rating, $img_arr = array()) {
    if (!is_array($img_arr)) {
      $img_arr = array();
    }
    if (!array_key_exists('glow', $img_arr)) {
      $img_arr['glow'] = '<i style="color: gold;" class="fa fa-star"></i>';
    }
    if (!array_key_exists('fade', $img_arr)) {
      $img_arr['fade'] = '<i class="fa fa-star"></i>';
    }
    $rating = ceil($rating);
    $rating = $rating > $max_rating ? $max_rfating : $rating;
    $var = "";
    $nostar = $max_rating - $rating;

    for ($jx = 1; $jx <= $rating; $jx++) {
      $var .= $img_arr['glow'];
    }

    for ($jx = 1; $jx <= $nostar; $jx++) {
      $var .= $img_arr['fade'];
    }

    return $var;
  }

}

if (!function_exists('product_overall_rating')) {

  function product_overall_rating($product_id, $entity_type) {
    $CI = CI();
    $res = $CI->db->query("SELECT AVG(ads_rating) as rating FROM wps_review WHERE entity_id ='" . $product_id . "' AND entity_type='" . $entity_type . "' AND status ='1' ")->row();
    return $res->rating;
  }

}

if (!function_exists('product_stock')) {

  function product_stock($product_id) {
    $CI = CI();
    $res = $CI->db->query("SELECT SUM(quantity) as quantity FROM wps_product_attributes WHERE product_id ='" . $product_id . "'")->row();
    $resp = $CI->db->query("SELECT SUM(product_qty) as proQty FROM wps_products WHERE products_id ='" . $product_id . "'")->row();
    $totalProduct = $res->quantity + $resp->proQty;
    return $totalProduct;
  }

}

if (!function_exists('color_name')) {

  function color_name($color_id) {
    $CI = CI();
    $res = $CI->db->query("SELECT color_name FROM wps_colors WHERE color_id ='" . $color_id . "'")->row();
    return $res->color_name;
  }

}

if (!function_exists('size_name')) {

  function size_name($size_id) {
    $CI = CI();
    $res = $CI->db->query("SELECT size_name FROM wps_sizes WHERE size_id ='" . $size_id . "'")->row();
    return $res->size_name;
  }

}

if (!function_exists('getSizes')) {

  function getSizes() {
    $CI = CI();
    $res = $CI->db->query("SELECT * FROM wps_sizes where status='1'")->result_array();
    return $res;
  }

}

if (!function_exists('getColors')) {

  function getColors() {
    $CI = CI();
    $res = $CI->db->query("SELECT * FROM wps_colors where status='1'")->result_array();
    return $res;
  }

}

if (!function_exists('getCategories')) {

  function getCategories() {
    $CI = CI();
    $res = $CI->db->query("SELECT * FROM wps_categories where status='1'")->result_array();
    return $res;
  }

}

if (!function_exists('get_products_media')) {

  function get_products_media($id, $condtion = "", $fields = 'SQL_CALC_FOUND_ROWS*') {
    $ci = CI();
    $output = array();
    $sql = "SELECT media as image FROM wps_products_media WHERE products_id=$id $condtion";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {

      foreach ($query->result_array() as $row) {
        $url = site_url() . "uploaded-files/product_images/";
        $img = $url . $row['image'];
        $output[] = $img;
      }
    }
    return $output;
  }

}

if (!function_exists('get_reviews_media')) {

  function get_reviews_media($id, $condtion = "", $fields = 'SQL_CALC_FOUND_ROWS*') {
    $ci = CI();
    $output = array();
    $sql = "SELECT media, id FROM wps_reviews_media WHERE status='1' AND review_id=$id $condtion";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {

      foreach ($query->result_array() as $row) {
        $url = site_url() . "uploaded-files/review_images/";
        $img = $url . $row['media'];
        $review_img_id = $row['id'];
        $output[] = ['image' => $img, 'imageId' => $review_img_id];
      }
    }
    // print_r($output); die;
    return $output;
  }

}
if (!function_exists('get_products_media_by_color')) {

  function get_products_media_by_color($id, $colorId, $condtion = "", $fields = 'SQL_CALC_FOUND_ROWS*') {
    $ci = CI();
    $output = array();
    $sql = "SELECT media as image FROM wps_products_media WHERE media_color = $colorId AND status='1' AND products_id=$id $condtion";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {

      foreach ($query->result_array() as $row) {
        $url = site_url() . "uploaded-files/product_images/";
        $img = $url . $row['image'];
        $output[] = $img;
      }
    }
    return $output;
  }

}
if (!function_exists('get_reviews_media_by_color')) {

  function get_reviews_media_by_color($id, $colorId, $condtion = "", $fields = 'SQL_CALC_FOUND_ROWS*') {
    $ci = CI();
    $output = array();
    $sql = "SELECT media, id FROM wps_reviews_media WHERE status='1' AND media_color = $colorId AND review_id=$id $condtion";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {

      foreach ($query->result_array() as $row) {
        $url = site_url() . "uploaded-files/review_images/";
        $img = $url . $row['media'];
        $review_img_id = $row['id'];
        $output[] = ['image' => $img, 'imageId' => $review_img_id];
      }
    }
    // print_r($output); die;
    return $output;
  }

}

if (!function_exists('get_products_by_id')) {

  function get_products_by_id($id, $offset, $condtion = "AND status='1'") {
    $ci = CI();
    $output = array();
    $offset = (int) $offset * 10;
    $sql = "SELECT  * FROM wps_products WHERE category_id=$id AND status='1' ORDER BY product_name desc limit $offset, 10";
    $query = $ci->db->query($sql);
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      foreach ($query->result_array() as $row) {
        $productId = $row['products_id'];
        $sql_review = "SELECT * from wps_review where product_id = $productId AND comment <> '' AND status = '1'";
        $review_query = $ci->db->query($sql_review);
        $reviews = [];
        foreach ($review_query->result_array() as $review) {
          $userId = $review['user_id'];
          $user_sql = "SELECT * from wps_customers where customers_id = $userId";
          $user = (array) $ci->db->query($user_sql)->row();
          $name = (is_array($user)) ? $user['first_name'] : "";
          $image = get_reviews_media($review['review_id']);
          $reviews[] = [
              'reviewId' => $review['review_id'],
              'comment' => $review['comment'],
              'rating' => $review['ads_rating'],
              'userName' => $name,
              'reviewImage' => $image,
          ];
        }

        $rows['productId'] = $row['products_id'];
        $rows['name'] = $row['product_name'];
        $rows['subcatId'] = $row['category_id'];
        $rows['colorId'] = explode(',', $row['color_ids'])[0];
        // $rows['returnDays']=$row['return_days'];
        // $rows['returnPolicy']=$row['return_policy'];
        $rows['originalPrice'] = $row['product_price'];
        $rows['price'] = $row['product_discounted_price'];
        $rows['description'] = $row['products_description'];
        // $rows['review']=$reviews;
        $rows['image'] = array_pop(get_products_media($row['products_id']));
        $size = explode(',', $row['size_ids']);
        $s = array();
        $ss = array();
        for ($i = 0; $i < count($size); $i++) {
          $res = $ci->db->query("SELECT size_name FROM wps_sizes WHERE status = '1' AND size_id ='" . $size[$i] . "'")->result_array();
          foreach ($res as $r) {
            $ss['size_name'] = $r['size_name'];
            $qty = $ci->db->query("SELECT * FROM wps_product_attributes WHERE product_id ='" . $row['products_id'] . "' and size_id='" . $size[$i] . "'")->result_array();
            foreach ($qty as $q)
              $ss['size_quantity'] = $q['quantity'];
            $ss['size_id'] = $size[$i];
            $s[] = $ss;
          }
        }
        // $rows['size']=$s;
        $output[] = $rows;
      }
    }
    return $output;
  }

}
?>