<?php

class Subcontent extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('subcontent_model'));
    $this->load->helper('category/category');
  }

  //Country 
  public function index() {
    $pagesize = (int) $this->input->get_post('pagesize');
    $config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
    $offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
    $base_url = current_url_query_string(array('filter' => 'result'), array('per_page'));

    $keyword = trim($this->input->get_post('keyword', TRUE));
    $keyword = $this->db->escape_str($keyword);
    $condtion = " ";
    if ($keyword != '') {
      $condtion = "AND (description like '%" . $keyword . "%' OR shortdescription like '%" . $keyword . "%')";
    }

    $condtion_array = array();
    $res_array = $this->subcontent_model->get_record();
    $config['total_rows'] = $this->subcontent_model->total_rec_found;

    $data['headingTitle'] = "Manage Sub Domain Content";
    $data['res'] = $res_array;

    if ($this->input->post('status_action') != '') {
      $this->update_status('wps_subcontent', 'subcontentId');
    }

    $this->load->view('subcontent/subcontent_list_view', $data);
  }

  public function add() {

    $data['headingTitle'] = "Add Sub Domain Content";
    $data['ckeditor'] = set_ck_config(array('textarea_id' => 'description'));
    if ($this->input->post('submit')) {

      $this->form_validation->set_rules('category_id[]', "Categories", "required");
      $this->form_validation->set_rules('page_heading', "Page Heading", "trim|max_length[220]");
      $this->form_validation->set_rules('description', "Description", "trim|required");
      $this->form_validation->set_rules('short_description', "Short Description", "trim|required");
      $this->form_validation->set_rules('meta_title', "Meta Title", "trim|required|max_length[220]");
      $this->form_validation->set_rules('meta_keyword', "Meta Keyword", "trim|required|max_length[460]");
      $this->form_validation->set_rules('meta_description', "Meta Description", "trim|required|max_length[250]");

      if ($this->form_validation->run() == TRUE) {

        //Category Links
        $postCategory = array();
        if ($this->input->post('category_id')) {
          $postCategory = $this->input->post('category_id');
        }
        
        //Location
        $postLocation = array();
        if ($this->input->post('location_id')) {
          $postLocation = $this->input->post('location_id');
        }
        
        //Insert in meta table
        $posted_data = array(
            'description' => $this->input->post('description'),
            'short_description' => $this->input->post('short_description'),
            'page_heading' => $this->input->post('page_heading'),
            'meta_keyword' => $this->input->post('meta_keyword'),
            'meta_description' => $this->input->post('meta_description'),
            'meta_title' => $this->input->post('meta_title'),
            'category_id' => implode(",", $postCategory),
            'location_id' => implode(",", $postLocation),
        );
        //trace($posted_data);
        //die;
        $this->subcontent_model->safe_insert('wps_subcontent', $posted_data, FALSE);

        $this->session->set_flashdata('success', lang('success'));
        redirect("wps-admin/subcontent/");
      }
    }
    $data['locations'] = $this->db->query("SELECT meta_id,page_url FROM wps_meta_tags WHERE is_fixed='L' ORDER BY page_url")->result_array();
    $this->load->view("subcontent/add_subcontent", $data);
  }

  public function edit() {
    $id = $this->uri->segment(4, 0);
    
    $data['ckeditor'] = set_ck_config(array('textarea_id' => 'description'));
    $data['headingTitle'] = "Edit Subdomain Meta & Content";
    $res = $this->db->query("SELECT * FROM wps_subcontent WHERE subcontentId='".$id."'")->row_array();
    $data['res'] = $res;

    if ($this->input->post('update')) {

      $this->form_validation->set_rules('category_id[]', "Categories", "required");
      
      $this->form_validation->set_rules('page_heading', "Page Heading", "trim|max_length[220]");
      $this->form_validation->set_rules('description', "Description", "trim|required");
      $this->form_validation->set_rules('short_description', "Short Description", "trim|required");
      $this->form_validation->set_rules('meta_title', "Meta Title", "trim|required|max_length[220]");
      $this->form_validation->set_rules('meta_keyword', "Meta Keyword", "trim|required|max_length[460]");
      $this->form_validation->set_rules('meta_description', "Meta Description", "trim|required|max_length[250]");

      if ($this->form_validation->run() == TRUE) {
        //Category
        $postCategory = array();
        if ($this->input->post('category_id')) {
          $postCategory = $this->input->post('category_id');
        }
        
        //Location
        $postLocation = array();
        if ($this->input->post('location_id')) {
          $postLocation = $this->input->post('location_id');
        }
        
        //Insert in meta table
        $posted_data = array(
            'description' => $this->input->post('description'),
            'short_description' => $this->input->post('short_description'),
            'page_heading' => $this->input->post('page_heading'),
            'meta_keyword' => $this->input->post('meta_keyword'),
            'meta_description' => $this->input->post('meta_description'),
            'meta_title' => $this->input->post('meta_title'),
            'category_id' => implode(",", $postCategory),
            'location_id' => implode(",", $postLocation),
        );
        //trace($posted_data);
        //die;
        $where_meta = "subcontentId=" . $id . " ";
        $this->subcontent_model->safe_update('wps_subcontent', $posted_data, $where_meta, FALSE);
        $this->session->set_flashdata('success', lang('successupdate'));
        redirect("wps-admin/subcontent/");
      }
    }
    $data['locations'] = $this->db->query("SELECT meta_id,page_url FROM wps_meta_tags WHERE is_fixed='L' ORDER BY page_url")->result_array();
    $this->load->view("subcontent/edit_subcontent", $data);
  }
}
// End of controller