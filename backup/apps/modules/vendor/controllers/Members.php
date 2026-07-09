<?php

class Members extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('members/members_model'));
    $this->load->library(array('safe_encrypt'));
  }

  public function index() {
    $condtion = array();

    $pagesize = (int) $this->input->get_post('pagesize');

    $config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');

    $offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;

    $base_url = current_url_query_string(array('filter' => 'result'), array('per_page'));

    $status = $this->input->get_post('status', TRUE);

    if ($status != '') {
      $condtion['status'] = $status;
    }

    $res_array = $this->members_model->get_members($config['limit'], $offset, $condtion);
    //echo_sql();
    $total_record = get_found_rows();
    $data['page_links'] = dashboard_pagination($base_url, $total_record, $config['limit'], $offset);
    $data['headingTitle'] = 'Manage Users';
    $data['pagelist'] = $res_array;
    $data['total_rec'] = $total_record;

    if ($this->input->post('action') != '') {
      $this->update_status('wps_customers', 'customers_id');
    }
    if ($this->input->post('set_as') != '') {
      $set_as = $this->input->post('set_as', TRUE);
      $this->set_as('wps_customers', 'customers_id', array($set_as => '1'));
    }
    if ($this->input->post('unset_as') != '') {
      $unset_as = $this->input->post('unset_as', TRUE);
      $this->set_as('wps_customers', 'customers_id', array($unset_as => '0'));
    }

    /* upload Excel */
    if ($this->input->post('action') == 'submit_excel') {
      $this->form_validation->set_rules('excel_file', 'Upload Excel File', 'required|callback_check_upload_excel');
      if ($this->form_validation->run() == TRUE) {
        require_once FCPATH . 'apps/third_party/Excel/reader.php';
        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('CP1251');

        //$data->setUTFEncoder('');
        chmod($_FILES["excel_file"]["tmp_name"], 0777);
        $data->read($_FILES["excel_file"]["tmp_name"]);
        $worksheet = $data->sheets[0]['cells'];

        $process_add = $this->members_model->add_bulk_upload_member($worksheet);
        //echo "sss";
        if ($process_add === TRUE) {
          $this->session->set_userdata(array('msg_type' => 'success'));
          $this->session->set_flashdata('success', 'Excel file inserted successfully!!!');
          redirect('wps-admin/members', '');
        } else {
          $this->session->set_userdata(array('msg_type' => 'warning'));
          $this->session->set_flashdata('warning', $process_add);
          redirect('wps-admin/members', '');
        }
      }
    }

    $this->load->view('member/member_list_view', $data);
  }

 

}

// End of controller