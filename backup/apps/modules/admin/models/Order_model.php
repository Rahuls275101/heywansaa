<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Order_model extends MY_Model {

  public function is_order_no_exits($ord) {
    $num = $this->findCount('wps_order', "invoice_number = '$ord' ");
    return ($num > 0 ) ? TRUE : FALSE;
  }

  public function get_orders($offset = '0', $per_page = '10', $condition = '') {

    $keyword = $this->db->escape_str(trim($this->input->get_post('keyword', TRUE)));
    $from_date = $this->db->escape_str(trim($this->input->get_post('from_date', TRUE)));
    $to_date = $this->db->escape_str(trim($this->input->get_post('to_date', TRUE)));
    $order_status = $this->input->get_post('order_status', TRUE);
     $sort_by = $this->db->escape_str(trim($this->input->get_post('sort_by', TRUE)));

   
    $condition = "order_status !='9' $condition ";

    if ($from_date != '' || $to_date != '') {

      $condition_date = array();
      $condition .= " AND (";
      if ($from_date != '') {
        $condition_date[] = "DATE(order_received_date)>='$from_date'";
      }if ($to_date != '') {
        $condition_date[] = "DATE(order_received_date)<='$to_date'";
      }

      $condition .= implode(" AND ", $condition_date) . " )";
    }
    if ($order_status != '') {
      $condition .= " AND order_status = '" . $order_status . "'";
    }
  
    if ($keyword != '') {
      $condition .= " AND ( invoice_number LIKE '%" . $keyword . "%' OR  CONCAT_WS(' ',first_name,last_name) LIKE '%" . $keyword . "%' OR email LIKE '%" . $keyword . "%'  OR  payment_status LIKE '" . $keyword . "%' OR  total_amount LIKE '" . $keyword . "%' OR  payment_method LIKE '" . $keyword . "%' OR  tracking_code LIKE '" . $keyword . "%' ) ";
    }
    if ($sort_by != '') {
      $condition .= " AND (payment_status LIKE '" . $sort_by . "%' OR  payment_method LIKE '" . $sort_by . "%') ";
    }

    $fetch_config = array(
        'condition' => $condition,
        'order' => 'order_id DESC',
        'limit' => $per_page,
        'start' => $offset,
        'debug' => FALSE,
        'return_type' => "array"
    );
    $result = $this->findAll('wps_order', $fetch_config);
    return $result;
  }

  public function get_order_master($ordId) {
    $id = (int) $ordId;
    if ($id != '' && is_numeric($id)) {
      $condtion = "order_id =$id";
      $fetch_config = array(
          'condition' => $condtion,
          'debug' => FALSE,
          'return_type' => "array"
      );

      $result = $this->find('wps_order', $fetch_config);
      return $result;
    }
  }

  public function get_order_detail($ordno) {
    $condtion = "order_id ='$ordno' ";
    $fetch_config = array(
        'condition' => $condtion,
        'order' => 'NULL',
        'limit' => 'NULL',
        'start' => 'NULL',
        'debug' => FALSE,
        'return_type' => "array"
    );

    $result = $this->findAll('wps_orders_products', $fetch_config);
    return $result;
  }

  public function get_ordered_product($orderId, $orderProductId) {
    $id = (int) $orderId;
    $orderProductId = (int) $orderProductId;
    if ($id != '' && $orderProductId != '' && is_numeric($id) && is_numeric($orderProductId)) {
      $condtion = "order_id = '".$id."' AND products_id = '".$orderProductId."'";
      $fetch_config = array(
          'condition' => $condtion,
          'debug' => FALSE,
          'return_type' => "array"
      );

      $result = $this->find('wps_orders_products', $fetch_config);
      return $result;
    }
  }

  public function changeOrderStatus($orderStatus, $orderProductId, $comment = '') {
    //$orderStatus = (int) $orderStatus;
    $orderProductId = (int) $orderProductId;
    if ($orderStatus != '' && is_numeric($orderStatus) && $orderProductId != '' && is_numeric($orderProductId)) {
      if ($orderStatus == '7') {
        $this->db->set('status', $orderStatus);  //Set the column name and which value to set..
        $this->db->set('request_for_return_date', date("Y-m-d H:i:s"));  //Set the column name and which value to set..
        $this->db->set('reason_for_return', $comment);  //Set the column name and which value to set..
        $this->db->where('orders_products_id', $orderProductId); //set column_name and value in which row need to update
        $this->db->update('wps_orders_products');
        return true;
      } else if ($orderStatus == '5') {
        $this->db->set('order_status', $orderStatus);  //Set the column name and which value to set..
        $this->db->set('order_cancelled_date', date("Y-m-d H:i:s"));  //Set the column name and which value to set..
        // $this->db->set('reason_for_return', $comment);  //Set the column name and which value to set..
        $this->db->where('order_id', $orderProductId); //set column_name and value in which row need to update
        $this->db->update('wps_order');
        return true;
      }
    } else {
      return false;
    }
  }

  public function setShippingBillingAddress($orderId, $shippingAddress, $billingAddress) {
    $condtion = "order_id =$orderId";
    $fetch_config = array(
        'condition' => $condtion,
        'debug' => FALSE,
        'return_type' => "array"
    );
    $order = $this->find('wps_orders_products', $fetch_config);
    if (count($order) == 0) {
      return '0';
    } else {

      $this->db->set('shipping_address', $shippingAddress);
      $this->db->set('billing_address', $billingAddress);
      $this->db->where('order_id', $orderId);
      $this->db->update('wps_order');
    }
  }

  public function addOrderProduct($product) {
    $this->safe_insert('wps_orders_products', $product, FALSE);
  }
  
  public function run_raw_query($query)
  {
      if($r=$this->db->query($query))
      {
         return $r->result_array(); 
      }
      else
      {
          return null;
      }
  }

}
