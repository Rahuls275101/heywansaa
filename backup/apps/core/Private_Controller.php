<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Private_Controller extends MY_Controller {

  public $userId;
  public $userphoto;
  public $friend_count;
  public $country_res = array();
  public $my_friends = array();

  public function __construct() {
    ob_start();
    parent::__construct();
  $this->load->library(array('Auth'));
    $this->auth->is_auth_user();
    $this->userId = (int) $this->session->userdata('user_id');
    $this->load->model(array('members/members_model'));
    $mres = $this->members_model->get_member_row($this->userId);
    $this->fname = $mres ['first_name'];
    $this->lname = $mres ['last_name'];
    $this->last_login = $mres ['last_login_date'];
  }

  public function update_status($table, $auto_field = 'id') {
    $action = $this->input->post('status_action', TRUE);
    $arr_ids = $this->input->post('arr_ids', TRUE);
    $category_count = $this->input->post('category_count', TRUE);
    $product_count = $this->input->post('product_count', TRUE);
    $gallery_count = $this->input->post('gallery_count', TRUE);
    $controller = $this->router->fetch_class();
    $method = $this->router->fetch_method();

    if (is_array($arr_ids)) {
      $str_ids = implode(',', $arr_ids);
      if ($action == 'Activate') {
        foreach ($arr_ids as $k => $v) {
          $data = array('status' => '1');
          $where = "$auto_field ='$v'";
          $this->members_model->safe_update($table, $data, $where, FALSE);
          $this->session->set_userdata(array('msg_type' => 'success'));
          $this->session->set_flashdata('success', lang('activate'));
        }
      }
      if ($action == 'Deactivate') {
        foreach ($arr_ids as $k => $v) {
          $countChild = 0;
          if ($controller == 'category') {
            $countChild = count_record('wps_products', "FIND_IN_SET (" . $v . ",category_links) AND status !='2'");
          }
          if ($countChild > 0) {
            $this->session->set_userdata(array('msg_type' => 'error'));
            $this->session->set_flashdata('error', lang('child_to_deactivate'));
          } else {
            $data = array('status' => '0');
            $where = "$auto_field ='$v'";
            $this->members_model->safe_update($table, $data, $where, FALSE);
            $this->session->set_userdata(array('msg_type' => 'success'));
            $this->session->set_flashdata('success', lang('deactivate'));
          }
        }
      }

      if ($action == 'Delete') {
        foreach ($arr_ids as $k => $v) {
          $countChild = 0;
          if ($controller == 'category') {
            $countChild = count_record('wps_products', "FIND_IN_SET (" . $v . ",category_links) AND status !='2'");
          }
          if ($countChild > 0) {
            $this->session->set_userdata(array('msg_type' => 'error'));
            $this->session->set_flashdata('error', lang('child_to_delete'));
          } else {
            $data = array('status' => '2');
            $where = array($auto_field => $v);
            $this->members_model->safe_update($table, $data, $where, FALSE);
            //$this->members_model->safe_delete($table, $where, TRUE);
            $this->session->set_userdata(array('msg_type' => 'success'));
            $this->session->set_flashdata('success', lang('deleted'));
          }
        }
      }
    }
    redirect($_SERVER['HTTP_REFERER'], '');
  }

}
