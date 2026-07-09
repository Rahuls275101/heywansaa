<?php

class Enquiry extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('enquiry_model'));
    $this->load->library(array('Dmailer', 'safe_encrypt'));
    $this->config->set_item('menu_highlight', 'manage enquiry');
  }

  public function index() {
    $type = (int) $this->uri->segment(4);
    $keyword = trim($this->input->post('keyword', TRUE));
    $pagesize = (int) $this->input->get_post('pagesize');
    $config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
    $offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
    $base_url = current_url_query_string(array('filter' => 'result'), array('per_page'));
    $condition = "type = '" . $type . "'";
    $keyword = $this->db->escape_str($keyword);
    if ($keyword != '') {
      $condition .= " AND  ( email like '%$keyword%' OR  company_name like '%$keyword%' OR CONCAT_WS(' ',first_name,last_name) LIKE '%" . $keyword . "%' ) ";
    }

    $res_array = $this->enquiry_model->get_enquiry($offset, $config['limit'], $condition);

    $config['total_rows'] = $this->enquiry_model->total_rec_found;
    //$data['page_links'] = admin_pagination($base_url, $config['total_rows'], $config['limit'], $offset);

    if ($this->input->post('status_action') != '') {
      $this->update_status('wps_enquiry', 'id');
    }
    if ($type == 1) {
      $data['headingTitle'] = 'Manage Enquiry';
    }
    if ($type == 2) {
      $data['headingTitle'] = 'Manage Subscriptions';
    }
    if ($type == 3) {
      $data['headingTitle'] = 'Message From DDA Members';
    }
    if ($type == 4) {
      $data['headingTitle'] = 'Manage Product Enquiry';
    }
    if ($type == 5) {
      $data['headingTitle'] = 'Manage Complaint';
    }


    /* Product set as a */
    if ($this->input->post('action') != '') {
      $this->update_status('wps_enquiry', 'id');
    }
    /* End product set as a */

    $data['inq_type'] = 'General';
    $data['result'] = $res_array;
    //print_r($res_array);exit;
    if ($type == 2) {
      $this->load->view('enquiry/view_subscriber_list', $data);
    } else {
      $this->load->view('enquiry/view_enquiry_list', $data);
    }
  }

  public function sendReply() {
    $to = $this->input->post('to');
    $message = $this->input->post('message');
    $subject = $this->input->post('subject');
    if ($to) {
      //Mail
      $mail_conf = array(
          'subject' => $subject,
          'to_email' => $to,
          'from_email' => 'info@lootmojo.in',
          'from_name' => 'Lootmojo',
          'body_part' => nl2br($message),
      );
      //trace($mail_conf);
      //exit;
      $this->dmailer->mail_notify($mail_conf);
      echo 'Reply Sent Successfully!';
      
    } else {
      echo 'Something went wrong! Please try later.';
    }
  }

}

// End of controller