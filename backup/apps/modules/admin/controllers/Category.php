<?php

class Category extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('category/category_model'));
    $this->load->helper('category/category');
    $this->form_validation->set_error_delimiters("<span class='red'>", "</span>");
    $this->default_view = 'category';
    $this->deletePrvg = TRUE;
  }

  public function index() {
    $pagesize = (int) $this->input->get_post('pagesize');
    $config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
    $offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
    $base_url = current_url_query_string(array('filter' => 'result'), array('per_page'));
    $parent_id = (int) $this->uri->segment(4, 0);

    $keyword = trim($this->input->get_post('keyword', TRUE));
    $keyword = $this->db->escape_str($keyword);
    $condtion = "AND parent_id = '$parent_id'";
    $condtion_array = array(
        'field' => "*,( SELECT COUNT(category_id) FROM wps_categories AS b WHERE b.parent_id=a.category_id ) AS total_subcategories",
        'condition' => $condtion,
        'debug' => FALSE
    );
    $res_array = $this->category_model->getcategory($condtion_array);
    $config['total_rows'] = $this->category_model->total_rec_found;
    //$data['page_links'] = admin_pagination($base_url, $config['total_rows'], $config['limit'], $offset);
    $data['headingTitle'] = ( $parent_id > 0 ) ? 'Manage Subcategory' : 'Manage Category';
    $data['res'] = $res_array;
    $data['parent_id'] = $parent_id;

    if ($this->input->get_post('set_home_category')) {
      $this->db->query("UPDATE wps_categories SET home_cat = '1' WHERE category_id = '" . $this->input->get_post('set_home_category') . "'");
      $this->session->set_userdata(array('msg_type' => 'success'));
      $this->session->set_flashdata('success', 'Select Category has been set as Home Category.');
      redirect($_SERVER['HTTP_REFERER']);
    }
    if ($this->input->get_post('unset_home_category')) {
      $this->db->query("UPDATE wps_categories SET home_cat = '0' WHERE category_id = '" . $this->input->get_post('unset_home_category') . "'");
      $this->session->set_userdata(array('msg_type' => 'success'));
      $this->session->set_flashdata('success', 'Select Category has been removed from Home Category.');
      redirect($_SERVER['HTTP_REFERER']);
    }
    if ($this->input->get_post('set_shop_category')) {
      $this->db->query("UPDATE wps_categories SET home_menu = '1' WHERE category_id = '" . $this->input->get_post('set_shop_category') . "'");
      $this->session->set_userdata(array('msg_type' => 'success'));
      $this->session->set_flashdata('success', 'Select Category has been set as Shop By Categories.');
      redirect($_SERVER['HTTP_REFERER']);
    }
    if ($this->input->get_post('unset_shop_category')) {
      $this->db->query("UPDATE wps_categories SET home_menu = '0' WHERE category_id = '" . $this->input->get_post('unset_shop_category') . "'");
      $this->session->set_userdata(array('msg_type' => 'success'));
      $this->session->set_flashdata('success', 'Select Category has been removed from Shop By Categories.');
      redirect($_SERVER['HTTP_REFERER']);
    }

    if ($this->input->post('action') != '') {
      if ($this->input->post('action') == 'Delete') {
        $prod_id = $this->input->post('arr_ids');
        $this->session->set_userdata('success', 'Category Has been deleted Successfully!');
        foreach ($prod_id as $v) {
          $where = array('entity_type' => 'category/index', 'entity_id' => $v);
          safe_delete('wps_meta_tags', $where, TRUE);
        }
      }
      $this->update_status('wps_categories', 'category_id');
    }
    if ($this->input->post('update_order') != '') {
      $this->update_displayOrder('wps_categories', 'sort_order', 'category_id');
    }

    /* upload Bulk Excel */
    if ($this->input->post('formAction') == 'submit_excel') {
      $filearrext = array('xls', 'xlsx');
      if ($_FILES['excel_file']['name'] == '') {
        $this->session->set_userdata('error', 'Please upload (xls) file only.');
        redirect('wps-admin/category');
      }
      if ($_FILES['excel_file']['name'] != '') {
        $extension = substr(strrchr($_FILES['excel_file']['name'], '.'), 1);
        if (!in_array($extension, $filearrext)) {
          $this->session->set_userdata('error', 'Please upload (xls) file only.');
          redirect('wps-admin/category');
        } else {
          require_once FCPATH . 'apps/third_party/Excel/reader.php';
          $data = new Spreadsheet_Excel_Reader();
          $data->setOutputEncoding('CP1251');
          chmod($_FILES["excel_file"]["tmp_name"], 0777);
          $data->read($_FILES["excel_file"]["tmp_name"]);
          $worksheet = $data->sheets[0]['cells'];
          $process_add = $this->category_model->add_bulk_upload_category($worksheet);
          if ($process_add === TRUE) {
            $this->session->set_userdata('success', 'Excel file inserted successfully!!!');
            redirect('wps-admin/category');
          } else {
            $this->session->set_userdata('error', 'Please upload (xls) file only.');
            redirect('wps-admin/category');
          }
        }
      }
    }


    $this->load->view($this->default_view . '/view_category_list', $data);
  }

  public function add() {
    $data['ckeditor1'] = set_ck_config(array('textarea_id' => 'description'));
    $parent_id = (int) $this->uri->segment(4, 0);
    $category_name = $this->db->escape_str($this->input->post('categoryName'));
    $posted_friendly_url = $this->input->post('friendlyUrl');

    if ($parent_id != '' && $parent_id > 0) {
      $parent_id = applyFilter('NUMERIC_GT_ZERO', $parent_id);
      $data['headingTitle'] = 'Add Subcategory';
      if ($parent_id <= 0) {
        redirect("wps-admin/category");
      }
      $parentdata = $this->category_model->get_category_by_id($parent_id);
      if (!is_array($parentdata)) {
        $this->session->set_userdata('error', 'Invalid Record!');
        redirect('wps-admin/category', '');
      }
      $this->cbk_friendly_url = seo_url_title($posted_friendly_url);
      $data['parentData'] = $parentdata;
    } else {
      $this->cbk_friendly_url = seo_url_title($posted_friendly_url);
      $data['parentData'] = '';
      $data['headingTitle'] = 'Add Category';
    }

    $this->form_validation->set_rules('categoryName', 'Category Name', "trim|required|max_length[100]|unique[wps_categories.category_name ='" . $category_name . "' AND status!='2' AND parent_id='" . $parent_id . "']");
    $this->form_validation->set_rules('friendlyUrl', 'Page URL', "trim|required|unique[wps_meta_tags.page_url ='" . $this->cbk_friendly_url . "'] ");
    $this->form_validation->set_rules('categoryImage', 'Category Image', "callback_validateFile[categoryImage,image,false]");
    $this->form_validation->set_rules('description', 'Description', "max_length[6000]");


    if ($this->form_validation->run() === TRUE) {
      $uploaded_icon = $uploaded_file = "";
      if (!empty($_FILES) && $_FILES['categoryImage']['name'] != '') {
        $this->load->library('upload');
        $config1['upload_path'] = UPLOAD_DIR . '/category/';
        $config1['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->upload->initialize($config1);
        $uploaded_data = $this->upload->do_upload('categoryImage');
        if (is_array($uploaded_data) && !empty($uploaded_data)) {
          $uploaded_file = $uploaded_data['upload_data']['file_name'];
        }
      }

      if (!empty($_FILES) && $_FILES['category_icon']['name'] != '') {
        $this->load->library('upload');
        $config1['upload_path'] = UPLOAD_DIR . '/category/';
        $config1['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->upload->initialize($config1);
        $uploaded_data = $this->upload->do_upload('category_icon');
        if (is_array($uploaded_data) && !empty($uploaded_data)) {
          $uploaded_icon = $uploaded_data['upload_data']['file_name'];
        }
      }
      
      $redirect_url = "category/index";
      $category_alt = $this->input->post('categoryName');
      $category_description = $this->input->post('description');

      $posted_data = array(
          'category_name' => $this->input->post('categoryName'),
          'category_alt' => $category_alt,
          'category_description' => $category_description,
          'parent_id' => $parent_id,
          'friendly_url' => $this->cbk_friendly_url,
          'date_added' => $this->config->item('config.date.time'),
          'category_image' => $uploaded_file,
          'category_icon' => $uploaded_icon,
      );
      $this->db->insert('wps_categories', $posted_data);
      $insertId = $this->db->insert_id();
      if ($insertId > 0) {
        if ($this->input->get_post('metaTitle') != '' && $this->input->get_post('metaDescription') != '') {
          $title = get_text($this->input->get_post('metaTitle'));
          $description = get_text($this->input->get_post('metaDescription'));
          $keywords = get_keywords($this->input->get_post('metaKeyword'));
        } else {
          $title = '';
          $description = '';
          $keywords = '';
        }
        $meta_array = array(
            'entity_type' => $redirect_url,
            'entity_id' => $insertId,
            'page_url' => $this->cbk_friendly_url,
            'meta_title' => $title,
            'meta_description' => $description,
            'meta_keyword' => $keywords
        );
        $this->db->insert('wps_meta_tags', $meta_array);
      }

      $this->session->set_userdata('success', 'Record has been added successfully!');
      $redirect_path = isset($parentdata) && is_array($parentdata) ? 'category/index/' . $parentdata['category_id'] : 'category';
      $this->load->helper('url');
      redirect(base_url() . 'wps-admin/' . $redirect_path, '');
      exit;
    }
    $data['parent_id'] = $parent_id;
    $this->load->view($this->default_view . '/view_category_add', $data);
  }

  public function edit() {
    $data['ckeditor1'] = set_ck_config(array('textarea_id' => 'description'));
    $baseURL = base_url();
    $catId = (int) $this->uri->segment(4);
    $rowdata = $this->category_model->get_category_by_id($catId);
    $data['headingTitle'] = ($rowdata['parent_id'] > 0 ) ? 'Edit Subcategory' : 'Edit Category';

    if (!is_array($rowdata)) {
      $this->session->set_flashdata('message', lang('idmissing'));
      redirect('wps-admin/category', '');
    }

    $posted_friendly_url = $this->input->post('friendlyUrl');
    $this->cbk_friendly_url = seo_url_title($posted_friendly_url);
    $category_name = $this->db->escape_str($this->input->post('categoryName'));
    $categoryId = $rowdata['category_id'];
    //Meta Details - Main
    $metaDets = get_db_single_row("wps_meta_tags", "meta_title, meta_description, meta_keyword", "entity_type = 'category/index' AND entity_id = '" . $categoryId . "'");


    $this->form_validation->set_rules('categoryName', 'Category Name', "trim|required|max_length[100]|unique[wps_categories.category_name ='" . $category_name . "' AND status!='2' AND parent_id='" . $rowdata['parent_id'] . "' AND category_id!='" . $categoryId . "']");
    //$this->form_validation->set_rules('friendlyUrl', 'Page URL', "trim|required|unique[wps_meta_tags.page_url ='" . $this->cbk_friendly_url . "' AND entity_id!='" . $catId . "'] ");
    $this->form_validation->set_rules('categoryImage', 'Category Image', "callback_validateFile[categoryImage,image,false]");
    $this->form_validation->set_rules('description', 'Description', "max_length[6000]");

    if ($this->form_validation->run() == TRUE) {

      $uploaded_file = $rowdata['category_image'];
      $unlink_image = array('source_dir' => "category", 'source_file' => $rowdata['category_image']);
      if ($this->input->post('cat_img_delete') === 'Y') {
        removeImage($unlink_image);
        $uploaded_file = NULL;
      }

      if (!empty($_FILES) && $_FILES['categoryImage']['name'] != '') {
        $this->load->library('upload');
        $config1['upload_path'] = UPLOAD_DIR . '/category/';
        $config1['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->upload->initialize($config1);
        $uploaded_data = $this->upload->do_upload('categoryImage');
        if (is_array($uploaded_data) && !empty($uploaded_data)) {
          $uploaded_file = $uploaded_data['upload_data']['file_name'];
          removeImage($unlink_image);
        }
      }

      $uploaded_icon = $rowdata['category_icon'];
      $unlink_image2 = array('source_dir' => "category", 'source_file' => $rowdata['category_image']);
      if (!empty($_FILES) && $_FILES['category_icon']['name'] != '') {
        $this->load->library('upload');
        $config1['upload_path'] = UPLOAD_DIR . '/category/';
        $config1['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->upload->initialize($config1);
        $uploaded_data = $this->upload->do_upload('category_icon');
        if (is_array($uploaded_data) && !empty($uploaded_data)) {
          $uploaded_icon = $uploaded_data['upload_data']['file_name'];
          removeImage($unlink_image2);
        }
      }

      $category_alt = $this->input->post('categoryName');
      $category_description = $this->input->post('description');
      $category_description = $category_description != '' ? $category_description : null;

      $posted_data = array(
          'category_name' => $this->input->post('categoryName'),
          'friendly_url' => $this->cbk_friendly_url,
          'category_alt' => $category_alt,
          'category_description' => $category_description,
          'category_image' => $uploaded_file,
          'category_icon' => $uploaded_icon,
      );
      //trace($posted_data);

      $this->db->where('category_id', $categoryId);
      $this->db->update('wps_categories', $posted_data);


      //Update Meta
      if ($categoryId > 0) {
        if ($this->input->get_post('metaTitle') != '' && $this->input->get_post('metaDescription') != '') {
          $title = get_text($this->input->get_post('metaTitle'));
          $description = get_text($this->input->get_post('metaDescription'));
          $keywords = $this->input->get_post('metaKeyword');
        } else {
          $title = '';
          $description = '';
          $keywords = '';
        }
        $posted_data_meta = array(
            'meta_title' => $title,
            'meta_description' => $description,
            'meta_keyword' => $keywords,
        );
        $this->db->where('entity_id', $categoryId);
        $this->db->where('entity_type', 'category/index');
        $this->db->update('wps_meta_tags', $posted_data_meta);
      }
      //End here

      $this->session->set_userdata('success', 'Record has been updated successfully!');
      $redirect_path = $rowdata['parent_id'] > 0 ? 'category/index/' . $rowdata['parent_id'] : 'category';
      //header("Location:".$baseURL.'wps-admin/' . $redirect_path);
      redirect(base_url('wps-admin/' . $redirect_path), '');
    }
    $data['parent_id'] = $rowdata['parent_id'];

    $data['metaDets'] = $metaDets;
    $data['catresult'] = $rowdata;
    $this->load->view($this->default_view . '/view_category_edit', $data);
  }

  public function delete() {
    $catId = (int) $this->uri->segment(4, 0);
    $rowdata = $this->category_model->get_category_by_id($catId);

    if (!is_array($rowdata)) {
      $this->session->set_flashdata('message', lang('idmissing'));
      redirect('sitepanel/category', '');
    } else {
      $total_category = count_category("AND parent_id='$catId' ");
      $total_product = count_products("AND category_id='$catId' ");

      if ($total_category > 0 || $total_product > 0) {
        $this->session->set_userdata(array('msg_type' => 'error'));
        $this->session->set_flashdata('error', lang('child_to_delete'));
      } else {
        $where = array('category_id' => $catId);
        $this->category_model->safe_delete('wps_categories', $where, TRUE);
        $this->session->set_userdata(array('msg_type' => 'success'));
        $this->session->set_flashdata('success', lang('deleted'));
      }
      redirect($_SERVER['HTTP_REFERER'], '');
    }
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

  public function updateuserstatus() {
    $userId = $this->input->post('userId');
    $status = $this->input->post('status');
    if ($userId > 0) {
      $this->db->query("UPDATE wps_categories SET status = '" . $status . "' WHERE category_id = '" . $userId . "'");
      if ($status == 0) {
        echo 'Record has been Deactived successfully!';
      } else {
        echo 'Record has been Actived successfully!';
      }
    } else {
      echo 'Something went wrong, please try again later!';
    }
  }

  public function check_upload_excel() {
    $filearrext = array('xls', 'xlsx');
    if ($_FILES['excel_file']['name'] == '') {
      $this->form_validation->set_message('check_upload_excel', 'Please upload excel file.');
      return FALSE;
    }
    if ($_FILES['excel_file']['name'] != '') {
      $extension = substr(strrchr($_FILES['excel_file']['name'], '.'), 1);
      if (!in_array($extension, $filearrext)) {
        $this->form_validation->set_message('check_upload_excel', 'Please upload (xls) file only.');
        return FALSE;
      } else {
        return TRUE;
      }
    }
  }

}

// End of controller
