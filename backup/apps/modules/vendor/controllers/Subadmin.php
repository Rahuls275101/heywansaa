<?php

class Subadmin extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('subadmin/subadmin_model'));
    $this->form_validation->set_error_delimiters("<span class='red'>", "</span>");
  }

  public function index() {
    if($this->session->userdata('admin_type')==1){
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
    $res_array = $this->subadmin_model->getsubadmin($condtion_array);

    $config['total_rows'] = $this->subadmin_model->total_rec_found;
    $data['page_links'] = ''; //admin_pagination($base_url, $config['total_rows'], $config['limit'], $offset);
    $data['headingTitle'] = 'Subadmin List';
    $data['res'] = $res_array;
    $data['parent_id'] = $parent_id;

    if ($this->input->post('status_action') != '') {
      $this->update_status('wps_admin', 'admin_id');
    }
    $this->load->view('subadmin/view_subadmin_list', $data);
  }else{ redirect('wps-admin/index', ''); }
  }

  public function updateuserstatus() {
    $userId = $this->input->post('userId');
    $status = $this->input->post('status');
    if ($userId > 0) {
      $this->db->query("UPDATE wps_admin SET status = '" . $status . "' WHERE admin_id = '" . $userId . "'");
      if ($status == 0) {
        echo 'Record has been Deactived successfully!';
      } else {
        echo 'Record has been Actived successfully!';
      }
    } else {
      echo 'Something went wrong, please try again later!';
    }
  }


  public function add() {
    if($this->session->userdata('admin_type')==1){
    $data['headingTitle'] = 'Add Subadmin';
    if ($this->input->post('action') && ($this->input->post('action') == 'sbmt_cpn' )) {

      $this->form_validation->set_rules('name', 'Name', "trim|required|max_length[100]");
      $this->form_validation->set_rules('admin_username', 'Login Username', "trim|required|max_length[30]");
      $this->form_validation->set_rules('admin_password', 'Login Password', "trim|required|max_length[15]|min_length[5]");

      if ($this->form_validation->run() === TRUE) {

        $posted_data = array(
            'name' => $this->input->post('name'),
            'admin_username' => $this->input->post('admin_username'),
            'admin_password' => $this->input->post('admin_password'),
            'admin_type' => '2',
            'status' => '1',
            'post_date' => $this->config->item('config.date.time'),
        );
        $ad_id = $this->subadmin_model->safe_insert('wps_admin', $posted_data, FALSE);
        $this->db->query("UPDATE wps_admin SET admin_key = '" . $ad_id . "' WHERE admin_id = '" . $ad_id . "'");
        $this->session->set_userdata('success', 'subadmin Added Successfully!');

        redirect('wps-admin/subadmin');
      }
    }
    $this->load->view('subadmin/view_subadmin_add', $data);
  }else{ redirect('wps-admin/index', ''); }
  }

  public function edit() {
    if($this->session->userdata('admin_type')==1){
    $admin_id = (int) $this->uri->segment(4);
    $rowdata = $this->subadmin_model->get_subadmin_by_id($admin_id);
    $data['headingTitle'] = 'Edit Subadmin';

    if (!is_array($rowdata)) {
      $this->session->set_flashdata('message', lang('idmissing'));
      redirect('sitepanel/subadmin', '');
    }
    $admin_id = $rowdata['admin_id'];

    if ($this->input->post('action') && ($this->input->post('action') == 'updt_cpn' )) {

      $this->form_validation->set_rules('name', 'subadmin Name', "trim|required|max_length[100]");
      $this->form_validation->set_rules('admin_username', 'subadmin Code', "trim|required|max_length[30]");
      $this->form_validation->set_rules('admin_password', 'subadmin Price', "trim|required|max_length[15]|min_length[5]");

      if ($this->form_validation->run() === TRUE) {

        $posted_data = array(
            'name' => $this->input->post('name'),
            'admin_username' => $this->input->post('admin_username'),
            'admin_password' => $this->input->post('admin_password'),
            'admin_type' => '2',
            'status' => '1',
            'post_date' => $this->config->item('config.date.time'),
        );
        $where = "admin_id = '" . $admin_id . "'";
        $this->subadmin_model->safe_update('wps_admin', $posted_data, $where, FALSE);
        $this->db->query("UPDATE wps_admin SET admin_key = '" . $admin_id . "' WHERE admin_id = '" . $admin_id . "'");

        $this->session->set_userdata('success', 'Subadmin Updated Successfully!');
        redirect('wps-admin/subadmin' . '/' . query_string(), '');
      }
    }

    $data['edit_result'] = $rowdata;
    $this->load->view('subadmin/view_subadmin_edit', $data);
  }else{ redirect('wps-admin/index', ''); }
  }

}

// End of controller