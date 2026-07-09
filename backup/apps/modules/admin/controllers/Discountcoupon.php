<?php

class Discountcoupon extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('coupon/coupon_model'));
  }

  public function index() {
    //FOR EXPIRE THE COUPANS
    $this->db->query("UPDATE wps_discount_coupans SET status = '0' where cpn_end_date < CURDATE()");

    $pagesize = (int) $this->input->get_post('pagesize');
    $config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
    $offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
    $base_url = current_url_query_string(array('filter' => 'result'), array('per_page'));
    $parent_id = (int) $this->uri->segment(4, 0);
    $keyword = trim($this->input->get_post('keyword', TRUE));
    $keyword = $this->db->escape_str($keyword);
    $condtion = " ";
    $condtion_array = array(
        'field' => "*",
        'condition' => $condtion,
        'limit' => $config['limit'],
        'offset' => $offset,
        'debug' => FALSE
    );
    $res_array = $this->coupon_model->getcoupans($condtion_array);
    //echo '<pre>';
    //print_r($res_array);
    //die();
    $config['total_rows'] = $this->coupon_model->total_rec_found;
    $data['page_links'] = dashboard_pagination($base_url, $config['total_rows'], $config['limit'], $offset);
    $data['headingTitle'] = 'Discount Coupons';
    $data['res'] = $res_array;
    $data['parent_id'] = $parent_id;

    if ($this->input->post('action') != '') {
      $this->update_status('wps_discount_coupans', 'cpn_id');
    }
//        if( $this->input->post('update_order')!='')
//        {			
//            $this->update_displayOrder('wps_sizes','sort_order','size_id');			
//        }
    $this->load->view('coupons/discount_coupan', $data);
  }

  public function check_coupan_code() {

    $cpn_code = $this->input->post('cpn_code');
    if ($this->coupon_model->is_coupan_exits(array('cpn_code' => $cpn_code))) {
      $this->form_validation->set_message('coupan_check', $this->config->item('exists_coupan_code'));
      return FALSE;
    } else {
      return TRUE;
    }
  }

  public function percentage_coupan() {
    // echo "here in percentage";exit;
    if ($this->input->post('cpn_type') == 1) {
      if ($this->input->post('cpn_rate') >= 100) {
        $this->form_validation->set_message('percentage_coupan', "You can only set maximum of 99 percent discount coupan");
        return FALSE;
      } else {
        return TRUE;
      }
    }
  }

  public function add() {
    $data['headingTitle'] = 'Add Discount Coupon';
    if ($this->input->post('sbmt_cpn') && ($this->input->post('sbmt_cpn') == 'sbmt_cpn' )) {

      $this->form_validation->set_rules('cpn_name', 'Coupan Name', "trim|required|max_length[100]");
      $this->form_validation->set_rules('cpn_code', 'Coupan Code', "trim|required|max_length[10]|min_length[5]|callback_check_coupan_code");
      $this->form_validation->set_rules('cpn_type', 'Coupan Type', "trim|required|max_length[1]|min_length[1]");
      if ($this->input->post('cpn_type') == 0) {
        $this->form_validation->set_rules('cpn_rate', 'Coupan Price', "trim|required|numeric|max_length[5]|min_length[1]|greater_than[0]");
      } else {
        $this->form_validation->set_rules('cpn_rate', 'Coupan Price', "trim|required|numeric|callback_percentage_coupan|greater_than[0]");
      }

      $this->form_validation->set_rules('minimum_amount_for_coupan_apply', 'Minimum amount for coupan apply', "trim|required|numeric|max_length[8]|min_length[1]|greater_than[0]");
      $this->form_validation->set_rules('start_date', 'Start Date', "trim|required");
      $this->form_validation->set_rules('end_date', 'End Date', "trim|required");
      if ($this->form_validation->run() === TRUE) {

        $posted_data = array(
            'cpn_name' => $this->input->post('cpn_name'),
            'cpn_type' => $this->input->post('cpn_type'),
            'cpn_code' => $this->input->post('cpn_code'),
            'cpn_rate' => $this->input->post('cpn_rate'),
            'minimum_amount_for_coupan_apply' => $this->input->post('minimum_amount_for_coupan_apply'),
            'cpn_start_date' => date('Y-m-d', strtotime($this->input->post('start_date'))),
            'cpn_end_date' => date('Y-m-d', strtotime($this->input->post('end_date'))),
            'status' => 1
        );
        $this->coupon_model->safe_insert('wps_discount_coupans', $posted_data, FALSE);
        $this->session->set_userdata(array('msg_type' => 'success'));
        $this->session->set_flashdata('success', lang('success'));

        redirect('wps-admin/discountcoupon');
      }
//            echo '<pre>';
//            print_r($_POST);
//            die();
    }

    $this->load->view('coupons/view_coupan_add', $data);
  }

  public function edit() {
    $cpn_id = (int) $this->uri->segment(4);
    $rowdata = $this->coupon_model->get_coupan_by_id($cpn_id);
    $data['headingTitle'] = 'Coupons';

    if (!is_array($rowdata)) {
      $this->session->set_flashdata('message', lang('idmissing'));
      redirect('wps-admin/discountcoupon', '');
    }
    $cpn_id = $rowdata['cpn_id'];

    if ($this->input->post('updt_cpn') && ($this->input->post('updt_cpn') == 'updt_cpn' )) {

      $this->form_validation->set_rules('cpn_name', 'Coupan Name', "trim|required|max_length[100]");
      $this->form_validation->set_rules('cpn_code', 'Coupan Code', "trim|required|max_length[10]|unique[wps_discount_coupans.cpn_code='" . $this->db->escape_str($this->input->post('cpn_code')) . "' AND status!='2' AND cpn_id!='" . $cpn_id . "']");
      $this->form_validation->set_rules('cpn_type', 'Coupan Type', "trim|required|max_length[1]|min_length[1]");
      if ($this->input->post('cpn_type') == 0) {
        $this->form_validation->set_rules('cpn_rate', 'Coupan Price', "trim|required|numeric|max_length[5]|min_length[1]|greater_than[0]");
      } else {
        $this->form_validation->set_rules('cpn_rate', 'Coupan Price', "trim|required|numeric|callback_percentage_coupan|greater_than[0]");
      }
      $this->form_validation->set_rules('minimum_amount_for_coupan_apply', 'Minimum amount for coupan apply', "trim|required|numeric|max_length[8]|min_length[1]|greater_than[0]");
      $this->form_validation->set_rules('start_date', 'Start Date', "trim|required");
      $this->form_validation->set_rules('end_date', 'End Date', "trim|required");

      if ($this->form_validation->run() === TRUE) {

        $posted_data = array(
            'cpn_name' => $this->input->post('cpn_name'),
            'cpn_type' => $this->input->post('cpn_type'),
            'cpn_code' => $this->input->post('cpn_code'),
            'cpn_rate' => $this->input->post('cpn_rate'),
            'minimum_amount_for_coupan_apply' => $this->input->post('minimum_amount_for_coupan_apply'),
            'cpn_start_date' => date('Y-m-d', strtotime($this->input->post('start_date'))),
            'cpn_end_date' => date('Y-m-d', strtotime($this->input->post('end_date'))),
            'status' => 1
        );
        $where = "cpn_id = '" . $cpn_id . "'";
        $this->coupon_model->safe_update('wps_discount_coupans', $posted_data, $where, FALSE);

        $this->session->set_userdata(array('msg_type' => 'success'));
        $this->session->set_flashdata('success', lang('successupdate'));
        redirect('wps-admin/discountcoupon' . '/' . query_string(), '');
      }
    }

    $data['edit_result'] = $rowdata;
    $this->load->view('coupons/view_coupan_edit', $data);
  }

}

// End of controller