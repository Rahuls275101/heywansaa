<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('Utils_model'));
    $this->admin_lib->is_admin_logged_in();
  }

  public function update_status($table, $auto_field = 'id') {
    $action = $this->input->post('action', TRUE);
    $arr_ids = $this->input->post('arr_ids', TRUE);

    $controller = $this->router->fetch_class();
    $method = $this->router->fetch_method();

    if (is_array($arr_ids)) {
      $str_ids = implode(',', $arr_ids);
      if ($action == 'Activate') {
        foreach ($arr_ids as $k => $v) {
          if ($controller == 'news') {
              $data = array(
                  'status' => '1',
                  'activation_date' => date('Y-m-d H:i:s'),
              );
          }else{
            $data = array(
                'status' => '1',
            );
          }
          $where = "$auto_field ='$v'";
          $this->Utils_model->safe_update($table, $data, $where, FALSE);
          $this->session->set_userdata('success', 'Selected Record(s) have been Activated!');
        }
      }
      if ($action == 'Deactivate') {
        foreach ($arr_ids as $k => $v) {
          $data = array(
              'status' => '0'
          );
          $where = "$auto_field ='$v'";
          $this->Utils_model->safe_update($table, $data, $where, FALSE);
          $this->session->set_userdata('success', 'Selected Record(s) have been Deactivated!');
        }
      }
      
      

      if ($action == 'Delete') {
        foreach ($arr_ids as $k => $v) {


          if ($controller == 'banners') {
            $imageName = get_db_field_value($table, "banner_image", "WHERE " . $auto_field . " = '" . $v . "'");
            $unlink_image = array('source_dir' => "banner", 'source_file' => $imageName);
            removeImage($unlink_image);
          }
          if ($controller == 'category') {
            $imageName = get_db_field_value($table, "category_image", "WHERE " . $auto_field . " = '" . $v . "'");
            $unlink_image = array('source_dir' => "category", 'source_file' => $imageName);
            removeImage($unlink_image);

            $imageName1 = get_db_field_value($table, "bg_image", "WHERE " . $auto_field . " = '" . $v . "'");
            $unlink_image1 = array('source_dir' => "category", 'source_file' => $imageName1);
            removeImage($unlink_image1);

            $imageName2 = get_db_field_value($table, "category_icon", "WHERE " . $auto_field . " = '" . $v . "'");
            $unlink_image2 = array('source_dir' => "category", 'source_file' => $imageName2);
            removeImage($unlink_image2);

		  }
          if ($controller == 'products') {
            $resPm = $this->db->query("SELECT id, media FROM wps_products_media WHERE products_id = '" . $v . "'")->result_array();
            foreach ($resPm as $pmRes) {
              $imageName = $pmRes['media'];
              $unlink_image = array('source_dir' => "product_images", 'source_file' => $imageName);
              $unlink_image1 = array('source_dir' => "product_images/thumb", 'source_file' => $imageName);
              //trace($unlink_image);
              removeImage($unlink_image);
              removeImage($unlink_image1);
              $this->db->query("DELETE FROM wps_products_media WHERE id = '" . $pmRes['id'] . "'");
            }
          }
          if ($controller == 'blog') {
            $imageName = get_db_field_value($table, "article_image", "WHERE " . $auto_field . " = '" . $v . "'");
            $unlink_image = array('source_dir' => "blog", 'source_file' => $imageName);
            removeImage($unlink_image);
          }
          //Remove Cache
          $path = IMG_CACH_DIR;
          $this->load->helper("file");
          delete_files($path);
          //Done
          //End Here

          if ($controller == 'news') {
            $data = array('status' => '2');
            $where = "$auto_field ='$v'";
            safe_update($table, $data, $where, FALSE);
          }else{
            $where = array(
                $auto_field => $v
            );
            safe_delete($table, $where, TRUE);
          }
          
          
          $this->session->set_userdata(array(
              'msg_type' => 'success'
          ));
			    $this->session->set_userdata('success', 'Record(s) have been Deleted Successfully!');
        }
      }


      if ($action == 'Block') {
        $data = array(
            'is_blocked' => '1'
        );
        $where = "$auto_field IN ($str_ids)";
        $this->Utils_model->safe_update($table, $data, $where, FALSE);
        $this->session->set_userdata(array(
            'msg_type' => 'success'
        ));
        $this->session->set_flashdata('success', 'Members have been set as blocked!');
      }
      if ($action == 'Unblock') {
        $data = array(
            'is_blocked' => '0'
        );
        $where = "$auto_field IN ($str_ids)";
        $this->Utils_model->safe_update($table, $data, $where, FALSE);
        $this->session->set_userdata(array(
            'msg_type' => 'success'
        ));
        $this->session->set_flashdata('success', 'Members have been set as unblocked!');
      }

      if ($action == 'Tempdelete') {
        $data = array(
            'status' => '2'
        );
        $where = "$auto_field IN ($str_ids)";
        $this->Utils_model->safe_update($table, $data, $where, FALSE);
        $this->session->set_userdata(array(
            'msg_type' => 'success'
        ));
        $this->session->set_flashdata('success', lang('deleted'));
      }
    }
    redirect($_SERVER['HTTP_REFERER'], '');
  }

  public function set_as($table, $auto_field = 'id', $data = array()) {
    $arr_ids = $this->input->post('arr_ids', TRUE);
    if (is_array($arr_ids)) {
      $str_ids = implode(',', $arr_ids);
      if (is_array($data) && !empty($data)) {
        $data = $data;
        $where = "$auto_field IN ($str_ids)";
        $this->Utils_model->safe_update($table, $data, $where, FALSE);
        $current_controller = $this->router->fetch_class();
        if ($current_controller == "orders" && $this->input->post("ord_status") != "" && ($this->input->post("ord_status") != "Pending" && $this->input->post("ord_status") != "Closed")) {

          $this->load->library("dmailer");
          $mail_subject = $this->config->item('site_name') . " Order overview";
          $from_email = $this->admin_info->admin_email;
          $from_name = $this->config->item('site_name');
          foreach ($arr_ids as $key => $val) {
            $order = get_db_single_row("wps_order", '*', " order_id = " . $val);
            $courier_details = "";

            if ($this->input->post("ord_status") == '8') { //delivered
              $data = array(
                  'payment_status' => 'Paid',
                  'order_delivery_date' => $this->config->item('config.date.time')
              );
              $where = "order_id = '" . $val . "'";
              
              
            // transaction start  
            $vendor_id=$this->session->userdata()['admin_id'];
            $total_amount=$order['total_amount']+$order['vat_amount']-$order['coupon_discount_amount'];
            $trans_data=array(
                'debit'=>$total_amount,
                'vendor_id'=>$vendor_id,
                'remark'=>'Delivery Done',
                'description'=>'none',
                'status'=>1,
                'order_id'=>$val,
                'invoice_no'=>$order['invoice_number'],
                'created_at'=>date('Y-m-d H:i:s'),
                );  
              
              $this->db->insert('transaction',$trans_data);
              
              
              
              
              
        //   print_r($data); die;
        //   $this->utils_model->safe_update('wps_order', $data, $where, FALSE);
        $qstr = $this->db->update_string('wps_order', $data, $where);
          $this->db->query($qstr);
          if ($debug) {
            echo $this->db->last_query();
          }
           
              $mail_to = $order["email"];
              $from_email = $this->admin_info->admin_email;
              $content = '<table width="1024" border="0" cellpadding="0" cellspacing="0" style="padding:10px;">
                <tr>
                <td style="">
                Dear ' . $order['first_name'] . ',<br /><br />
                  Your order no ' . $order['invoice_number'] . ', is delivered at your address. We are waiting for your next order. Give us chance to serve you.
                  <br /><br />
                 Thank you for trust.<br />
                  Best Regards<br />
                  Team
                  </td>
                  </tr>
              </table>';

              $mail_conf = array(
                  'subject' => $this->config->item('site_name') . " Order Delivered " . $order['invoice_number'],
                  'to_email' => $mail_to,
                  'from_email' => $from_email,
                  'from_name' => $this->config->item('site_name'),
                  'body_part' => $content
              );
              // trace($mail_conf);
              // exit;
              $this->dmailer->mail_notify($mail_conf);
            }

            if ($this->input->post("ord_status") == '5') { //cancelled
              // update stock
              $orders = $this->db->query("SELECT color_id,size_id, products_id, quantity FROM wps_orders_products WHERE " . $where)->result_array();
              foreach ($orders as $ord) {
                $qty = $ord['quantity'];
                //$this->db->query("UPDATE wps_product_attributes SET quantity=quantity+$qty WHERE color_id = '" . $ord['color_id'] . "' AND size_id = '" . $ord['size_id'] . "' AND product_id = '" . $ord['products_id'] . "'");
              }
              // End here
            }

            if ($this->input->post("ord_status") == '2') { //dispatched
              $new_time = date("Y-m-d H:i:s", strtotime('+24 hours'));
              $dt = explode(' ', $new_time);
              $mail_to = $order["email"];
              $from_email = $this->admin_info->admin_email;
              $content = '<table width="1024" border="0" cellpadding="0" cellspacing="0" style="padding:10px;">
                <tr>
                <td style="">
                Dear ' . $order['first_name'] . ',<br /><br />
                  Your order no ' . $order['invoice_number'] . ', is dispatched for delivery, your billed amount is ' . display_price($order['total_amount']) . '. Estimated delivery time is ' . getDateFormat($dt[0], 3) . ', by ' . $dt[1] . '.
                  <br /><br />
                  Keep using www.weblieu.com<br />
                  Thank you for trust.<br />
                  Best Regards<br />
                  Team - Lootmojo
                  </td>
                  </tr>
              </table>';

              $mail_conf = array(
                  'subject' => $this->config->item('site_name') . " Order Dispatched " . $order['invoice_number'],
                  'to_email' => $mail_to,
                  'from_email' => $from_email,
                  'from_name' => $this->config->item('site_name'),
                  'body_part' => $content
              );
              // trace($mail_conf);
              // exit;
              $this->dmailer->mail_notify($mail_conf);
            }
          }
        }
        $this->session->set_userdata(array(
            'msg_type' => 'success'
        ));
        $this->session->set_flashdata('success', "Record has been Set/Unset successfully.");
      }
      redirect($_SERVER['HTTP_REFERER'], '');
    }
  }

  public function update_displayOrder($tblname, $fldname, $fld_id) {
    $posted_order_data = $this->input->post('ord');
    while (list ($key, $val) = each($posted_order_data)) {
      if ($val != '') {
        $val = (int) $val;
        $data = array(
            $fldname => $val
        );
        $where = "$fld_id=$key";
        $this->Utils_model->safe_update($tblname, $data, $where, TRUE);
      }
    }
    $this->session->set_userdata(array(
        'msg_type' => 'success'
    ));
    $this->session->set_flashdata('success', lang('order_updated'));
    redirect($_SERVER['HTTP_REFERER'], '');
  }

}
