<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class cart_model extends MY_Model {

  /**
   * Get account by id
   *
   * @access public
   * @param string $account_id
   * @return object account object
   */
  public function is_order_no_exits($ord) {
    $sql = "SELECT * from wps_order where invoice_number = '$ord'";
    $result = $this->db->query($sql);
    $num_rows = $result->num_rows();
    if ($num_rows == 0) {
      return FALSE;
    }else{
      return TRUE;
    }
    // $num = $this->findCount('wps_order', "invoice_number = '$ord' ");
    // return ($num > 0 ) ? TRUE : FALSE;
  }

  public function get_discount($code) {

    if ($code != "") {
      $code = $this->db->escape_str($code);

      $condtion = "status ='1' AND coupon_code = '" . $code . "' AND end_date  > '" . $this->config->item('config.date') . "' ";

      $fetch_config = array(
          'condition' => $condtion,
          'debug' => FALSE,
          'return_type' => "array"
      );

      $res = $this->find('wps_coupons', $fetch_config);
      return $res;
    }
  }

  public function get_shipping_rate($shipId) {
    $id = (int) $shipId;
    if ($id != '' && is_numeric($id)) {
      $condtion = "status ='1' AND shipping_id ='$id'";
      $fetch_config = array(
          'condition' => $condtion,
          'debug' => FALSE,
          'return_type' => "array"
      );

      $result = $this->find('wps_shipping', $fetch_config);
      return $result;
    }
  }

  public function add_wislists($prodId, $memId) {
    if ($prodId > 0 && $memId > 0) {
      $record = $this->is_record_exits('wps_wishlists', array('condition' => "customer_id =$memId AND products_id =$prodId"));
      if (!$record) {
        $data = array(
            'customer_id' => $memId,
            'products_id' => $prodId,
            'wishlists_date_added' => $this->config->item('config.date.time')
        );
        $this->safe_insert('wps_wishlists', $data, FALSE);
        $this->session->set_userdata(array('msg_type' => 'success'));
        $this->session->set_flashdata('success', $this->config->item('wish_list_add'));
      } else {
        $this->session->set_userdata(array('msg_type' => 'warning'));
        $this->session->set_flashdata('warning', $this->config->item('wish_list_product_exists'));
      }
    }
  }

  public function get_vat() {
    return 0;
  }

  public function get_shipping($orderAmt) {

    $sql = "SELECT free_ship_amt, ship_amt FROM wps_shipping_cod WHERE 1";
    $result = $this->db->query($sql)->row_array();
    if ($result['free_ship_amt'] <= $orderAmt) {
      return 0;
    } else {
      return $result['ship_amt'];
    }
  }

  public function get_cod($orderAmt) {

    $sql = "SELECT free_cod_amt, cod_amt FROM wps_shipping_cod WHERE 1";
    $result = $this->db->query($sql)->row_array();
    if ($result['free_cod_amt'] <= $orderAmt) {
      return '0';
    } else {
      return $result['cod_amt'];
    }
  }

  public function add_to_cart($product) {
    $data = array(
        'product_id' => $product['productId'],
        'user_id' => $product['userId'],
        'quantity' => $product['qty'],
        'size_id' => $product['sizeId'],
        'color_id' => $product['colorId'],
        'product_price' => $product['price'],
        'product_discounted_price' => $product['productDiscountedPrice'],
        'custom_size' => $product['customSize'],
        'size_type' => $product['sizeType'],
    );
    $this->safe_insert('wps_cart', $data, FALSE);
  }

  public function remove_from_cart($userId, $cartItemId) {
    $sql = "SELECT * from wps_cart where user_id = $userId AND id = $cartItemId AND status = '1'";
    $result = $this->db->query($sql);
    $num_rows = $result->num_rows();
    if ($num_rows == 0) {
      return '0';
    }
    $sql = "UPDATE wps_cart SET status=3 where id = $cartItemId";
    $this->db->query($sql);
    return true;
  }

  public function update_cart($productId, $userId, $sizeId, $quantity, $colorId, $sizeType, $customSize, $cartItemId) {
    if ($sizeType == 'custom') {
      $sql = "SELECT * from wps_cart where product_id = $productId AND user_id = $userId AND size_type = '$sizeType' AND color_id = $colorId AND status = '1'";
    } else {
      $sql = "SELECT * from wps_cart where product_id = $productId AND user_id = $userId AND size_id = $sizeId AND color_id = $colorId AND status = '1'";
    }
    $sql = "SELECT * from wps_cart where user_id = $userId AND id = $cartItemId AND status = '1'";
    $result = $this->db->query($sql);
    $num_rows = $result->num_rows();
    if ($num_rows == 0) {
      return '0';
    }
//    $cartItem = $result->row_array();
    // print_r($cartItem); die;
//    $itemId = $cartItem['id'];
    $sql = "UPDATE wps_cart set quantity = $quantity, custom_size= '$customSize' where id=$cartItemId";
    $this->db->query($sql);
    return true;
  }

  public function get_cart_items($userId) {
    $sql = "SELECT * from wps_cart where user_id = $userId AND status=1";
    $result = $this->db->query($sql);
    $num_rows = $result->num_rows();
    if ($num_rows == 0) {
      return '0';
    }
    return $result->result_array();
  }

  public function empty_cart($userId) {
    $sql = "UPDATE wps_cart SET status=3 where user_id = $userId";
    $result = $this->db->query($sql);
  }

  public function changeCartItemStatus($ItemId) {
    $sql = "UPDATE wps_cart SET status=2 where id = $ItemId";
    $result = $this->db->query($sql);
  }
  
  public function get_master_where($field,$where,$tb)
  {
      $r=$this->db->select($field)->where($where)->get($tb);
      return $r->result_array();
  }

}

/* End of file member_model.php */
/* Location: ./application/modules/cart/models/cart_model.php */