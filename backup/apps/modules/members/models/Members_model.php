<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Members_model extends MY_Model {

  public function get_members($limit = '10', $offset = '0', $param = array()) {
    $status = @$param['status'];
    $customer_id = @$param['customer_id'];
    $keyword = trim($this->input->get_post('keyword', TRUE));
    $keyword = $this->db->escape_str($keyword);
    if ($customer_id != '') {
      $this->db->where("customers_id", "$customer_id");
    }
    if ($status != '') {
      $this->db->where("status", "$status");
    }
    if ($keyword != '') {
      $this->db->where("(user_name LIKE '%" . $keyword . "%' OR CONCAT_WS(' ',first_name,last_name) LIKE '%" . $keyword . "%' OR gender LIKE '%" . $keyword . "%' )");
    }
    $this->db->order_by('customers_id', 'desc');
    if ($limit) {
      $this->db->limit($limit, $offset);
    }
    $this->db->select("SQL_CALC_FOUND_ROWS *,CONCAT_WS(' ',first_name) AS name ", FALSE);
    $this->db->from('wps_customers');
    $this->db->where('status !=', '2');
    $q = $this->db->get();
    //echo_sql();
    $result = $q->result_array();
    $result = ($limit == '1') ? $result[0] : $result;
    return $result;
  }

  public function get_member_row($id, $condtion = '') {
    $id = (int) $id;
    if ($id != '' && is_numeric($id)) {
      $condtion = "status !='2' AND customers_id=$id $condtion ";
      $fetch_config = array(
          'condition' => $condtion,
          'debug' => FALSE,
          'return_type' => "array"
      );
      $result = $this->find('wps_customers', $fetch_config);
      return $result;
    }
  }
  public function add_newsletter_member($email, $name = NULL) {
    $query = $this->db->query("SELECT * FROM wps_newsletters  WHERE subscriber_email='" . $email . "' ");
    if ($query->num_rows() > 0) {
      $row = $query->row_array();
      if ($row['status'] == 1) {
        $error_type = "error";
        $error_msg = $this->config->item('newsletter_already_subscribed');
      } else {
        $where = "subscriber_email = '" . $row['subscriber_email'] . "'";
        $this->safe_update('wps_newsletters', array('status' => '1'), $where, FALSE);
        $error_type = "success";
        $error_msg = $this->config->item('newsletter_subscribed');
      }
    } else {
      $data = array('status' => '1',
          'subscriber_name' => $name,
          'subscriber_email' => $email
      );
      $this->safe_insert('wps_newsletters', $data);
    }
  }
  public function get_member_address_book($customer_id, $offset = '', $limit = '', $address_type = '', $default_status = 'Y') {
    $customer_id = (int) $customer_id;
    $offset = $offset;
    $limit = $limit;
    if ($customer_id != '') {
      $condtion = "customer_id =$customer_id AND default_status='$default_status'  ";
      if ($address_type != '') {
        $condtion .= "AND address_type ='$address_type'";
      }
      $fetch_config = array(
          'condition' => $condtion,
          'debug' => FALSE,
          'return_type' => "array"
      );
      if ($offset != -1) {
        $fetch_config['start'] = $offset;
      }
      if ($limit > 0) {
        $fetch_config['limit'] = $limit;
      }
      //trace($fetch_config);
      $result = $this->findAll('wps_customers_address_book', $fetch_config);
      return $result;
    }
  }

  public function get_wislists($offset = FALSE, $per_page = FALSE, $param = array()) {
    $keyword = trim($this->db->escape_str($this->input->post('keyword')));
    $condition = "wp.status ='1'";
    if ($this->session->userdata('user_id') != '') {
      $condition .= "AND wis.customer_id = " . $this->session->userdata('user_id');
    }
    $opts = array(
        'condition' => $condition,
        'limit' => $per_page,
        'offset' => $offset,
        'debug' => FALSE,
        'fromcond' => 'wps_products AS wp',
        "groupby" => "pm.products_id",
        'selectcond' => 'wp.*, wis.customer_id, wis.id,pm.media',
        'joins' => array(array('tblname' => 'wps_wishlists AS wis', 'jclause' => 'wis.products_Id=wp.products_id'), array('tblname' => 'wps_products_media AS pm', 'jclause' => "wp.products_id=pm.products_id AND pm.is_default = 'Y'")),
    );
    return $this->myCustomJoin($opts);
  }


  public function add_bulk_upload_member($worksheet) {
    //echo "ssss";
    //trace($worksheet);
    //exit;
    for ($i = 2; $i <= count($worksheet); $i++) {
      $title = (!isset($worksheet[$i][1])) ? '' : addslashes(trim($worksheet[$i][1]));
      $name = (!isset($worksheet[$i][2])) ? '' : addslashes(trim($worksheet[$i][2]));
      $mobile = (!isset($worksheet[$i][3])) ? '' : addslashes(trim($worksheet[$i][3]));
      $email = (!isset($worksheet[$i][4])) ? '' : addslashes(trim($worksheet[$i][4]));
      $passwords = (!isset($worksheet[$i][5])) ? '' : addslashes(trim($worksheet[$i][5]));
      $gender = (!isset($worksheet[$i][6])) ? '' : addslashes(trim($worksheet[$i][6]));
      $address = (!isset($worksheet[$i][7])) ? '' : addslashes(trim($worksheet[$i][7]));
      $zipcode = (!isset($worksheet[$i][8])) ? '' : addslashes(trim($worksheet[$i][8]));
      $state = (!isset($worksheet[$i][9])) ? '' : addslashes(trim($worksheet[$i][9]));
      $country = (!isset($worksheet[$i][10])) ? '' : addslashes(trim($worksheet[$i][10]));
      $city = (!isset($worksheet[$i][11])) ? '' : addslashes(trim($worksheet[$i][11]));

      $password = $this->safe_encrypt->encode($passwords);

      $data = array(
          'user_name' => $email,
          'password' => $password,
          'first_name' => $name,
          'mobile_number' => $mobile,
          'gender' => $gender,
          'actkey' => md5($name),
          'status' => '1',
          'is_verified' => '1',
          'login_type' => 'normal',
          'account_created_date' => $this->config->item('config.date.time'),
          'current_login' => $this->config->item('config.date.time'),
          'ip_address' => '',
      );

      $member_id = $this->safe_insert('wps_customers', $data, FALSE);

      //Update Media
      if ($member_id > 0) {
          $address_array = array(
              'customer_id' => $member_id,
              'mtitle' => $title,
              'first_name' => $name,
              'last_name' => '',
              'address' => $address,
              'landmark' => '',
              'mobile' => $mobile,
              'zipcode' => $zipcode,
              'state' => $state,
              'country' => $country,
              'city' => $city,
              'address_type' => 'Bill',
              'default_address' => 'N',
              'default_status' => 'N',
              'reciv_date' => $this->config->item('config.date.time'),
          );
          $insId = $this->safe_insert('wps_customers_address_book', $address_array, FALSE);
           $address_array2 = array(
              'customer_id' => $member_id,
              'mtitle' => $title,
              'first_name' => $name,
              'last_name' => '',
              'address' => $address,
              'landmark' => '',
              'mobile' => $mobile,
              'zipcode' => $zipcode,
              'state' => $state,
              'country' => $country,
              'city' => $city,
              'address_type' => 'Ship',
              'default_address' => 'N',
              'default_status' => 'N',
              'reciv_date' => $this->config->item('config.date.time'),
          );
          $insId2 = $this->safe_insert('wps_customers_address_book', $address_array2, FALSE);
      }

    }
    //exit;
    return true;
  }

  public function add_master($tb,$data)
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
  
  public function get_count_where($tb,$where)
  {
      $this->db->where($where);
      if($r=$this->db->get($tb))
      {
          return count($r->result_array());
      }
      else
      {
          return false;
      }
  }
  
  public function get_where($tb,$where)
  {
      $this->db->where($where);
      if($r=$this->db->get($tb))
      {
          return $r->result_array();
      }
      else
      {
          return false;
      }
  }
  
  
  
    public function update_where($tb,$data,$where)
  {
      $this->db->where($where);
      if($r=$this->db->update($tb,$data))
      {
          return true;
      }
      else
      {
          return false;
      }
  }
  
    public function get_raw_query($query)
    {
        $r=$this->db->query($query);
        return $r->result_array();
    }
  
  
  
  
  
  
}