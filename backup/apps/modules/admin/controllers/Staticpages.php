<?php

class Staticpages extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('pages/pages_model'));
  }

  public function index() {
    if($this->session->userdata('admin_type')==1){
    $pagesize = (int) $this->input->get_post('pagesize');
    $config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
    $offset = ($this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
    $base_url = current_url_query_string(array('filter' => 'result'), array('per_page'));
    //print_r($offset);exit;				
    $res_array = $this->pages_model->get_all_cms_page($offset, $config['limit']);
    //$config['total_rows']    =  get_found_rows();
    $config['total_rows'] = $this->pages_model->total_rec_found;
    //$data['page_links'] = admin_pagination($base_url, $config['total_rows'], $config['limit'], $offset);
    $data['headingTitle'] = 'Manage Static Pages';
    $data['pagelist'] = $res_array;
    $this->load->view('staticpage/staticpage_list_index_view', $data);
  }else{ redirect('wps-admin/index', ''); }
  }

  public function edit() {
    if($this->session->userdata('admin_type')==1){
    $page_id = (int) $this->uri->segment(4);
    $res = $this->pages_model->get_cms_page(array('page_id' => $page_id));
    if (is_array($res)) {
      $this->form_validation->set_rules('page_description', 'Description', 'required');

      //Meta Details - Main
      $metaDets = get_db_single_row("wps_meta_tags", "meta_title, meta_description, meta_keyword", "page_url = '" . $res['friendly_url'] . "'");

      if ($this->form_validation->run() == TRUE) {

        $posted_data = array(
            'page_description' => $this->input->post('page_description', TRUE),
            'page_updated_date' => $this->config->item('config.date.time')
        );
        $where = "page_id = '" . $res['page_id'] . "'";
        $this->pages_model->safe_update('wps_cms_pages', $posted_data, $where, FALSE);

        //Update Meta
        if ($this->input->get_post('meta_title') != '' && $this->input->get_post('meta_description') != '') {
          $title = get_text($this->input->get_post('meta_title'));
          $description = get_text($this->input->get_post('meta_description'));
          $keywords = $this->input->get_post('meta_keyword');
        } else {
          $title = $metaDets['meta_title'];
          $description = $metaDets['meta_description'];
          $keywords = $metaDets['meta_keyword'];
        }
        $posted_data_meta = array(
            'meta_title' => $title,
            'meta_description' => $description,
            'meta_keyword' => $keywords,
        );
        $where_meta = "page_url = '" . $res['friendly_url'] . "'";
        $this->pages_model->safe_update('wps_meta_tags', $posted_data_meta, $where_meta, FALSE);

        $this->session->set_userdata('success', 'Content has been updated!');
        redirect('wps-admin/staticpages/' . query_string(), '');
      }
      $data['headingTitle'] = 'Edit Static Pages';
      $data['page_title'] = 'Edit Information';
      $data['pageresult'] = $res;
      $data['metaDets'] = $metaDets;
      $this->load->view('staticpage/statispage_edit_view', $data);
    } else {
      redirect('wps-admin/staticpages', '');
    }
  }else{ redirect('wps-admin/index', ''); }
  }

  public function pagedatadisplay() {
    $id = (int) $this->uri->segment(4);
    $res = $this->pages_model->getStaticpage_by_id($id);

    $data['heading_title'] = 'Static Pages';
    $data['page_title'] = 'View Page Information';
    $data['pageresult'] = $res;
    $this->load->view('staticpage/statispage_detail_view', $data);
  }

}

// End of controller