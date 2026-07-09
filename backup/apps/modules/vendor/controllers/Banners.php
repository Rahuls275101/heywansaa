<?php

class Banners extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('banner_model'));
    $this->load->helper(array('banner', 'custom_form','category/category'));
  }

  public function index($page = NULL) {
    
    $pagesize = (int) $this->input->get_post('pagesize');
    $config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
    $offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;

    $base_url = current_url_query_string(array('filter' => 'result'), array('per_page'));
    $res_array = $this->banner_model->get_banner($offset, $config['limit']);
    $config['base_url'] = base_url() . 'wps-admin/banners/pages/';
    $config['total_rows'] = $this->banner_model->total_rec_found;
    $data['page_links'] = ''; //admin_pagination($base_url, $config['total_rows'], $config['limit'], $offset);
    $data['headingTitle'] = 'Banner List';
    $data['res'] = $res_array;

    if ($this->input->post('action') != '') {
      $this->update_status('wps_banners', 'banner_id');
    }

    $this->load->view('banner/view_banner_list', $data);
 
  }

  public function add() {
    $data['headingTitle'] = 'Add Banner';
    
    $this->form_validation->set_rules('section', 'Section', "required|max_length[100]");
    $this->form_validation->set_rules('banner_position', 'Banner Position', "required|max_length[200]");
    //$this->form_validation->set_rules('category_id[]', 'Category', "required|max_length[100]");
    $this->form_validation->set_rules('banner_url', 'Banner URL', "required|max_length[500]");
    $this->form_validation->set_rules('banner_title', 'Banner Title', "trim");
    $this->form_validation->set_rules('image1', 'Banner Image', "callback_validateFile[image1,image,false]");
    // $this->form_validation->set_rules('start_date', 'Start Date', "required");
    // $this->form_validation->set_rules('end_date', 'End Date', "required");

    if ($this->form_validation->run() == TRUE) {

      $uploaded_file = "";
      if (!empty($_FILES) && $_FILES['image1']['name'] != '') {
        $this->load->library('upload');
        $config1['upload_path'] = UPLOAD_DIR . '/banner/';
        $config1['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->upload->initialize($config1);
        $uploaded_data = $this->upload->do_upload('image1');
        if (is_array($uploaded_data) && !empty($uploaded_data)) {
          $uploaded_file = $uploaded_data['upload_data']['file_name'];
        }
      }

      $posted_data = array(
        'banner_page' => $this->input->post('section'),
        'banner_position' => $this->input->post('banner_position'),
         // 'banner_category_id' => implode(',', $this->input->post('category_id')),
          'banner_title' => addslashes($this->input->post('banner_title')),
          'banner_image' => $uploaded_file,
          'banner_url' => $this->input->post('banner_url'),
          // 'banner_start_date' => $this->input->post('start_date'),
          // 'banner_end_date' => $this->input->post('end_date'),
          'banner_added_date' => $this->config->item('config.date.time'),
      );
      //trace($posted_data);
      $this->db->insert('wps_banners', $posted_data);
      //echo_sql();
      //die;
      $this->session->set_userdata('success', 'New banner has been added.');
      redirect('wps-admin/banners', '');
    }

    $this->load->view('banner/view_banner_add', $data);
  
  }

  public function edit() {
    
    $Id = (int) $this->uri->segment(4);
    $data['heading_title'] = 'Update Banner';
    $rowdata = $this->banner_model->get_banner_by_id($Id);

    if (is_object($rowdata)) {
      $this->form_validation->set_rules('section', 'Section', "required|max_length[100]");
      $this->form_validation->set_rules('banner_position', 'Banner Position', "required|max_length[200]");
      //$this->form_validation->set_rules('category_id[]', 'Category', "required|max_length[100]");
      $this->form_validation->set_rules('banner_url', 'Banner URL', "required|max_length[500]");
      $this->form_validation->set_rules('banner_title', 'Banner Title', "trim");
      $this->form_validation->set_rules('image1', 'Banner Image', "callback_validateFile[image1,image,false]");
      // $this->form_validation->set_rules('start_date', 'Start Date', "required");
      // $this->form_validation->set_rules('end_date', 'End Date', "required");


      if ($this->form_validation->run() == TRUE) {

        $uploaded_file = $rowdata->banner_image;
        $unlink_image = array('source_dir' => "category", 'source_file' => $rowdata->banner_image);
        if (!empty($_FILES) && $_FILES['image1']['name'] != '') {
          $this->load->library('upload');
          $config1['upload_path'] = UPLOAD_DIR . '/banner/';
          $config1['allowed_types'] = 'gif|jpg|png|jpeg';
          $this->upload->initialize($config1);
          $uploaded_data = $this->upload->do_upload('image1');
          if (is_array($uploaded_data) && !empty($uploaded_data)) {
            $uploaded_file = $uploaded_data['upload_data']['file_name'];
            removeImage($unlink_image);
          }
        }

        $posted_data = array(
          'banner_page' => $this->input->post('section'),
          'banner_position' => $this->input->post('banner_position'),
            //'banner_category_id' => implode(',', $this->input->post('category_id')),
            'banner_title' => addslashes($this->input->post('banner_title')),
            'banner_image' => $uploaded_file,
            'banner_url' => $this->input->post('banner_url'),
            // 'banner_start_date' => $this->input->post('start_date'),
            // 'banner_end_date' => $this->input->post('end_date'),
        );


        $this->db->where('banner_id', $rowdata->banner_id);
        $this->db->update('wps_banners', $posted_data);

        $this->session->set_userdata(array('msg_type' => 'success'));
        $this->session->set_userdata('success', 'Banner details have been updated.');
        redirect('wps-admin/banners/', '');
      }
      $data['res'] = $rowdata;
      $this->load->view('banner/view_banner_edit', $data);
    } else {
      redirect('wps-admin/banners', '');
    }
  }

  public function ajx_ban_postions() {
    $html = '';
    $ban_positions = $this->config->item('bannersz');
    $ban_section_positions = $this->config->item('banner_section_positions');

    $postions_arr_key = array();

    $section = $this->input->get_post('banner_section');

    if (!empty($section)) {

      // Check if Positions array exists For this
      if (array_key_exists($section, $ban_section_positions)) {

        $postions_arr_key = $ban_section_positions[$section];
      }
    }
    $postions_arr = array();  // Creates Postions Array Key Value Pair
    if (count($postions_arr_key) > 0) {
      foreach ($postions_arr_key as $postion_key) {
        if (array_key_exists($postion_key, $ban_positions)) {
          $postions_arr[$postion_key] = $postion_key . " &raquo; Best banner Size " . $ban_positions[$postion_key];
        }
      }
    }
    $html = custom_drop_down('banner_position', $postions_arr, FALSE, 'class="form-control"', TRUE, 'Select Position');
    echo $html;
  }

  function validateFile($flName, $ext) {
    $parameter = explode(',', $ext);
    $fileName = $parameter[0];
    $allowedExt = $parameter[1];
    $isRequired = $parameter[2];
    if ($isRequired == 'false') {
      if (empty($_FILES[$fileName]['name'])) {
        return TRUE;
      } else {
        $file = $_FILES[$fileName];
        $ext_groups = array();
        $ext_groups['image'] = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
        $ext_groups['document'] = array('rtf', 'doc', 'docx', 'pdf', 'txt', 'ppt', 'zip');
        $ext_groups['media'] = array('mp4', 'mpeg4');
        $ext_groups['compressed'] = array('zip', 'gzip', 'tar', 'gz');
        $exts = $ext_groups[$allowedExt];
        //get file ext
        $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (!in_array($file_ext, $exts)) {
          $exts_allowed = implode(" | ", $exts);
          $this->form_validation->set_message('validateFile', "File should be " . $exts_allowed);
          return FALSE;
        } else {
          return TRUE;
        }
      }
    } else {
      if (empty($_FILES[$fileName]['name'])) {
        $this->form_validation->set_message('validateFile', 'Please select file.');
        return false;
      } else {
        $file = $_FILES[$fileName];
        $ext_groups = array();
        $ext_groups['image'] = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
        $ext_groups['document'] = array('rtf', 'doc', 'docx', 'pdf', 'txt', 'ppt', 'zip');
        $ext_groups['media'] = array('mp4', 'mpeg4');
        $ext_groups['compressed'] = array('zip', 'gzip', 'tar', 'gz');
        $exts = $ext_groups[$allowedExt];
        //get file ext
        $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (!in_array($file_ext, $exts)) {
          $exts_allowed = implode(" | ", $exts);
          $this->form_validation->set_message('validateFile', "File should be " . $exts_allowed);
          return FALSE;
        } else {
          return TRUE;
        }
      }
    }
  }

}

// End of controller