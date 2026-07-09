<?php

class Products extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('products/product_model', 'color_model', 'size_model','Admin_common_model'));
    $this->load->helper('category/category');
    $this->config->set_item('menu_highlight', 'product management');
  }

  public function index($page = NULL) {
    $this->load->helper(array('products/product'));
    $condtion = array();
    $pagesize = (int) $this->input->get_post('pagesize');
    $config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
    $offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
    $base_url = current_url_query_string(array('filter' => 'result'), array('per_page'));
    $category_id = (int) $this->uri->segment(4, 0);
    $status = $this->input->get_post('status', TRUE);

     if ($this->input->post('update_order') != '') {
      $this->update_displayOrder('wps_products', 'sort_order', 'products_id');
    }
    
    $cat_name = '';
    if ($category_id > 0) {
      $condtion['category_id'] = $category_id;
      $cat_name = 'in ';
      $cat_name .= get_db_field_value('wps_categories', 'category_name', "WHERE category_id='$category_id'");
    }
    if ($status != '') {
      $condtion['status'] = $status;
    }
    $condtion['orderby'] = 'wlp.products_id desc';
    $res_array = $this->product_model->get_products($config['limit'], $offset, $condtion);

    $config['total_rows'] = get_found_rows();
    $data['headingTitle'] = 'Products List';
    $data['res'] = $res_array;
    $data['paging'] = dashboard_pagination($base_url, $config['total_rows'], $config['limit'], $offset);

    if ($this->input->post('action') != '') {
      if ($this->input->post('action') == 'Delete') {
        $prod_id = $this->input->post('arr_ids');
        foreach ($prod_id as $v) {
          $where = array('entity_type' => 'products/detail', 'entity_id' => $v);
          $this->product_model->safe_delete('wps_meta_tags', $where, TRUE);
        }
      }
      $this->session->set_flashdata('success', lang('deleted'));
      $this->update_status('wps_products', 'products_id');
    }
    /* Product set as a */
    if ($this->input->post('set_as') != '') {
      $set_as = $this->input->post('set_as', TRUE);
      $this->set_as('wps_products', 'products_id', array($set_as => '1'));
    }
    if ($this->input->post('unset_as') != '') {
      $unset_as = $this->input->post('unset_as', TRUE);
      $this->set_as('wps_products', 'products_id', array($unset_as => '0'));
    }
    /* End product set as a */

    /* upload Bulk Excel */
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

        $process_add = $this->product_model->add_bulk_upload_product($worksheet);
        //echo "sss";
        if ($process_add === TRUE) {
          $this->session->set_userdata(array('msg_type' => 'success'));
          $this->session->set_flashdata('success', 'Excel file inserted successfully!!!');
          redirect('wps-admin/products', '');
        } else {
          $this->form_validation->_error_array['image'] = 'Uploading Failed. Please Try Again';
        }
      }
    }

    $data['category_result_found'] = "Total " . $config['total_rows'] . " result(s) found " . strtolower($cat_name) . " ";

    //Call of View
    $this->load->view('products/view_product_list', $data);
  }

  public function add() {
    $data['headingTitle'] = 'Add Product';
    $categoryposted = $this->input->post('catid');
    $data['categoryposted'] = $categoryposted;
    $data['ckeditor1'] = set_ck_config(array('textarea_id' => 'description')); //'type' => 'basic'
    $data['ckeditor2'] = set_ck_config(array('textarea_id' => 'specification'));

    $this->form_validation->set_rules('product_name', 'Product Name', "required|unique[wps_products.product_name='" . $this->db->escape_str($this->input->post('product_name')) . "' AND status!='2']");
    $this->form_validation->set_rules('product_code', 'Product Code', "trim|max_length[65]|unique[wps_products.product_code='" . $this->db->escape_str($this->input->post('product_code')) . "' AND status!='2']");
    $this->form_validation->set_rules('product_price', 'Price', 'trim|required|is_valid_amount|numeric|greater_than[0]');
    $this->form_validation->set_rules('discounted_price', 'Discounted Price', 'trim|is_valid_amount|numeric|less_than['.$this->input->post('product_price').']');
    $this->form_validation->set_rules('description', 'Product Description', 'trim');
    $this->form_validation->set_rules('category_id[]', 'Product Category', 'trim|required');
    $this->form_validation->set_rules('color_id[]', 'Color', "trim");
    $this->form_validation->set_rules('size_id[]', 'Size', "trim");
    $this->form_validation->set_rules('product_qty', 'Quantity', "trim|required|numeric");
    $this->form_validation->set_rules('hide_show_price', 'Show or Hide Price', "trim|required|numeric");
    if (empty($_FILES['img1']['name']))
    {
      $this->form_validation->set_rules('img1', 'Product Main Image', 'required|file_allowed_type[image]');
    }
    $this->form_validation->set_rules('img2', 'Product Additional Image', 'file_allowed_type[image]');
    $this->form_validation->set_rules('img3', 'Product Additional Image', 'file_allowed_type[image]');
    $this->form_validation->set_rules('img4', 'Product Additional Image', 'file_allowed_type[image]');
    $this->check_price();

    if ($this->form_validation->run() === TRUE) {

      $pic1 = '';
      if (!empty($_FILES) && $_FILES['img1']['name'] != '') {
        $this->load->library('upload');
        $config1['upload_path'] = UPLOAD_DIR . '/products/';
        $config1['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->upload->initialize($config1);
        $uploaded_data = $this->upload->do_upload('img1');
        if (is_array($uploaded_data) && !empty($uploaded_data)) {
          $pic1 = $uploaded_data['upload_data']['file_name'];
        }
      }

      $pic2 = '';
      if (!empty($_FILES) && $_FILES['img2']['name'] != '') {
        $this->load->library('upload');
        $config1['upload_path'] = UPLOAD_DIR . '/products/';
        $config1['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->upload->initialize($config1);
        $uploaded_data = $this->upload->do_upload('img2');
        if (is_array($uploaded_data) && !empty($uploaded_data)) {
          $pic2 = $uploaded_data['upload_data']['file_name'];
        }
      }

      $pic3 = '';
      if (!empty($_FILES) && $_FILES['img3']['name'] != '') {
        $this->load->library('upload');
        $config1['upload_path'] = UPLOAD_DIR . '/products/';
        $config1['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->upload->initialize($config1);
        $uploaded_data = $this->upload->do_upload('img3');
        if (is_array($uploaded_data) && !empty($uploaded_data)) {
          $pic3 = $uploaded_data['upload_data']['file_name'];
        }
      }

      $pic4 = '';
      if (!empty($_FILES) && $_FILES['img4']['name'] != '') {
        $this->load->library('upload');
        $config1['upload_path'] = UPLOAD_DIR . '/products/';
        $config1['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->upload->initialize($config1);
        $uploaded_data = $this->upload->do_upload('img4');
        if (is_array($uploaded_data) && !empty($uploaded_data)) {
          $pic4 = $uploaded_data['upload_data']['file_name'];
        }
      }
    
      //cat links
      $postCategory = $this->input->post('category_id');
      $category_links = "";
      $catlink = $ctl = "";
      foreach ($postCategory as $ctv) {
        $catlink = get_parent_categories($ctv, "AND status='1'", "category_id,parent_id");
        $ctl = array_keys($catlink);
        $category_links .= implode(",", $ctl) . ',';
      }
      $category_links = substr($category_links, 0, -1);

   //size
      $posted_size_id = $this->input->post('size_id');
      $posted_size_id = !is_array($posted_size_id) ? array() : $posted_size_id;
      $size_ids = implode(",", $posted_size_id);
      //color
      $posted_color_id = $this->input->post('color_id');
      $posted_color_id = !is_array($posted_color_id) ? array() : $posted_color_id;
      $color_ids = implode(",", $posted_color_id);
      $this->cbk_friendly_url = seo_url_title($this->input->post('product_name'));

      $posted_data = array(
          'category_id' => implode(',', $this->input->post('category_id')),
          'category_links' => $category_links,
          'friendly_url' => $this->cbk_friendly_url,
          'product_name' => $this->input->post('product_name', TRUE),
          'product_code' => $this->input->post('product_code', TRUE),
          'product_price' => $this->input->post('product_price', TRUE),
          'product_discounted_price' => $this->input->post('discounted_price', TRUE),
          'product_qty' => $this->input->post('product_qty', TRUE),
          'color_ids' => $color_ids,
          'size_ids' => $size_ids,
          'specification' => $this->input->post('specification', TRUE),
          'short_desc' => $this->input->post('short_desc', TRUE),
          'product_alt' => $this->input->post('product_name'),
          'products_description' => $this->input->post('description'),
          //'youtube_id' => $this->input->post('youtube_id', TRUE),
          'product_added_date' => $this->config->item('config.date.time'),
          'hide_price_status'=>$this->input->post('hide_show_price')
      );
      //trace($posted_data); exit;
      $productId = $this->product_model->safe_insert('wps_products', $posted_data, FALSE);
      if ($productId > 0) {
        $this->cbk_friendly_url = seo_url_title($this->input->post('product_name'));

        //update friendly_url
        $this->db->query("UPDATE wps_products SET friendly_url = '" . $this->cbk_friendly_url . "' WHERE products_id = '" . $productId . "'");

         //add images to table
        $is_default = 'Y';
        if ($pic1) {
          $this->db->query("INSERT INTO wps_products_media SET media = '" . $pic1 . "', products_id = '" . $productId . "', media_date_added = '" . $this->config->item('config.date.time') . "', is_default = '" . $is_default . "'");
          $is_default = 'N';
        }
        if ($pic2) {
          $this->db->query("INSERT INTO wps_products_media SET media = '" . $pic2 . "', products_id = '" . $productId . "', media_date_added = '" . $this->config->item('config.date.time') . "', is_default = '" . $is_default . "'");
          $is_default = 'N';
        }
        if ($pic3) {
          $this->db->query("INSERT INTO wps_products_media SET media = '" . $pic3 . "', products_id = '" . $productId . "', media_date_added = '" . $this->config->item('config.date.time') . "', is_default = '" . $is_default . "'");
          $is_default = 'N';
        }
        if ($pic4) {
          $this->db->query("INSERT INTO wps_products_media SET media = '" . $pic4 . "', products_id = '" . $productId . "', media_date_added = '" . $this->config->item('config.date.time') . "', is_default = '" . $is_default . "'");
          $is_default = 'N';
        }
        //End

        //Create Meta
        $redirect_url = "products/detail";
        if ($this->input->get_post('metaTitle') != '') {
          $title = $this->input->get_post('metaTitle');
          $description = $this->input->get_post('metaDescription');
          $keywords = $this->input->get_post('metaKeyword');
        } else {
          $title = $this->input->post('product_name');
          $description = $this->input->post('product_name');
          $keywords = $this->input->post('product_name');
        }
        $meta_array = array(
            'entity_type' => $redirect_url,
            'entity_id' => $productId,
            'page_url' => $this->cbk_friendly_url,
            'meta_title' => $title,
            'meta_description' => $description,
            'meta_keyword' => $keywords
        );
        create_meta($meta_array);
      }
      $this->session->set_userdata(array('msg_type' => 'success'));
      $this->session->set_flashdata('success', lang('success'));
      redirect('wps-admin/products/index/' . $this->input->post('category_id'), '');
    }

     /* Available Color Records */
    $color_cond_config = array(
        'condition' => " AND status='1' ",
        'order' => 'color_name '
    );
    $colors = $this->color_model->getcolors($color_cond_config);
    $data['colors'] = $colors;
    /* Available Size Records */
    $size_cond_config = array(
        'condition' => " AND status='1' ",
    );
    $sizes = $this->size_model->getsizes($size_cond_config);
    $data['sizes'] = $sizes;
   
    $this->load->view('products/view_product_add', $data);
  }

  public function edit($productId) {
    $data['headingTitle'] = 'Edit Product';
    $productId = (int) $this->uri->segment(4);
    $option = array('productid' => $productId);
    $res = $this->product_model->get_products(1, 0, $option);
    $data['ckeditor1'] = set_ck_config(array('textarea_id' => 'description'));
    $data['ckeditor2'] = set_ck_config(array('textarea_id' => 'specification'));
    //image validation
    $img_allow_size = $this->config->item('allow.file.size');
    $img_allow_dim = $this->config->item('allow.imgage.dimension');

    $this->cbk_friendly_url = seo_url_title($this->input->post('product_name'));

    $media = array();

    if (is_array($res) && !empty($res)) {
      $res = $res[0];
     $media = $this->product_model->get_product_media(4, 0, array('productid' => $res['products_id']));

       $this->form_validation->set_rules('product_name', 'Product Name', "required|unique[wps_products.product_name='" . $this->db->escape_str($this->input->post('product_name')) . "' AND status!='2' AND products_id != '" . $res['products_id'] . "']");
     //$this->form_validation->set_rules('product_name', 'Product Name', "required");
      $this->form_validation->set_rules('product_code', 'Product Code', "trim|max_length[65]|unique[wps_products.product_code='" . $this->db->escape_str($this->input->post('product_code')) . "' AND status!='2' AND products_id != '" . $res['products_id'] . "']");
     
      $this->form_validation->set_rules('product_price', 'Price', 'trim|required|is_valid_amount|numeric|greater_than[0]');
      $this->form_validation->set_rules('discounted_price', 'Discounted Price', 'trim|is_valid_amount|numeric|less_than['.$this->input->post('product_price').']');
      $this->form_validation->set_rules('description', 'Product Description', 'trim');
      $this->form_validation->set_rules('category_id[]', 'Product Category', 'trim|required');
      $this->form_validation->set_rules('color_id[]', 'Color', "trim");
      $this->form_validation->set_rules('size_id[]', 'Size', "trim");
      $this->form_validation->set_rules('product_qty', 'Quantity', "trim|required|numeric");
     // $this->form_validation->set_rules('browsed_image', 'Browsed Image', "trim");
      $this->form_validation->set_rules('img1', 'Product Main Image', 'file_allowed_type[image]');
      $this->form_validation->set_rules('img2', 'Product Additional Image', 'file_allowed_type[image]');
      $this->form_validation->set_rules('img3', 'Product Additional Image', 'file_allowed_type[image]');
      $this->form_validation->set_rules('img4', 'Product Additional Image', 'file_allowed_type[image]');

      if ($this->form_validation->run() == TRUE) {

        $media1 = (isset($media[0]['media'])) ? $media[0]['id'] : '';
        $media2 = (isset($media[1]['media'])) ? $media[1]['id'] : '';
        $media3 = (isset($media[2]['media'])) ? $media[2]['id'] : '';
        $media4 = (isset($media[3]['media'])) ? $media[3]['id'] : '';

        $mediaFile1 = (isset($media[0]['media'])) ? $media[0]['media'] : '';
        $mediaFile2 = (isset($media[1]['media'])) ? $media[1]['media'] : '';
        $mediaFile3 = (isset($media[2]['media'])) ? $media[2]['media'] : '';
        $mediaFile4 = (isset($media[3]['media'])) ? $media[3]['media'] : '';

        $pic1 = $mediaFile1;
      $unlink_image1 = array('source_dir' => "products", 'source_file' => $mediaFile1);
      if (!empty($_FILES) && $_FILES['img1']['name'] != '') {
        $this->load->library('upload');
        $config1['upload_path'] = UPLOAD_DIR . '/products/';
        $config1['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->upload->initialize($config1);
        $uploaded_data = $this->upload->do_upload('img1');
        if (is_array($uploaded_data) && !empty($uploaded_data)) {
          $pic1 = $uploaded_data['upload_data']['file_name'];
          removeImage($unlink_image1);
          if ($mediaFile1) {
            $this->db->query("UPDATE wps_products_media SET media = '" . $pic1 . "' WHERE products_id = '" . $productId . "' AND id = '" . $media1 . "'");
          } else {
            $this->db->query("INSERT INTO wps_products_media SET media = '" . $pic1 . "', products_id = '" . $productId . "'");
          }
        }
      }


      $pic2 = $mediaFile2;
      $unlink_image2 = array('source_dir' => "products", 'source_file' => $mediaFile2);
      if (!empty($_FILES) && $_FILES['img2']['name'] != '') {
        $this->load->library('upload');
        $config1['upload_path'] = UPLOAD_DIR . '/products/';
        $config1['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->upload->initialize($config1);
        $uploaded_data = $this->upload->do_upload('img2');
        if (is_array($uploaded_data) && !empty($uploaded_data)) {
          $pic2 = $uploaded_data['upload_data']['file_name'];
          removeImage($unlink_image2);
          if ($mediaFile2) {
            $this->db->query("UPDATE wps_products_media SET media = '" . $pic2 . "' WHERE products_id = '" . $productId . "' AND id = '" . $media2 . "'");
          } else {
            $this->db->query("INSERT INTO wps_products_media SET media = '" . $pic2 . "', products_id = '" . $productId . "'");
          }
        }
      }

      $pic3 = $mediaFile3;
      $unlink_image3 = array('source_dir' => "products", 'source_file' => $mediaFile3);
      if (!empty($_FILES) && $_FILES['img3']['name'] != '') {
        $this->load->library('upload');
        $config1['upload_path'] = UPLOAD_DIR . '/products/';
        $config1['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->upload->initialize($config1);
        $uploaded_data = $this->upload->do_upload('img3');
        if (is_array($uploaded_data) && !empty($uploaded_data)) {
          $pic3 = $uploaded_data['upload_data']['file_name'];
          removeImage($unlink_image3);
          if ($mediaFile3) {
            $this->db->query("UPDATE wps_products_media SET media = '" . $pic3 . "' WHERE products_id = '" . $productId . "' AND id = '" . $media3 . "'");
          } else {
            $this->db->query("INSERT INTO wps_products_media SET media = '" . $pic3 . "', products_id = '" . $productId . "'");
          }
        }
      }

      $pic4 = $mediaFile4;
      $unlink_image4 = array('source_dir' => "products", 'source_file' => $mediaFile4);
      if (!empty($_FILES) && $_FILES['img4']['name'] != '') {
        $this->load->library('upload');
        $config1['upload_path'] = UPLOAD_DIR . '/products/';
        $config1['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->upload->initialize($config1);
        $uploaded_data = $this->upload->do_upload('img4');
        if (is_array($uploaded_data) && !empty($uploaded_data)) {
          $pic4 = $uploaded_data['upload_data']['file_name'];
          removeImage($unlink_image4);
          if ($mediaFile4) {
            $this->db->query("UPDATE wps_products_media SET media = '" . $pic4 . "' WHERE products_id = '" . $productId . "' AND id = '" . $media4 . "'");
          } else {
            $this->db->query("INSERT INTO wps_products_media SET media = '" . $pic4 . "', products_id = '" . $productId . "'");
          }
        }
      }

      

       

        //cat links
        $postCategory = $this->input->post('category_id');
        $category_links = "";
        $catlink = $ctl = "";
        foreach ($postCategory as $ctv) {
          $catlink = get_parent_categories($ctv, "AND status='1'", "category_id,parent_id");
          $ctl = array_keys($catlink);
          $category_links .= implode(",", $ctl) . ',';
        }
        $category_links = substr($category_links, 0, -1);

         //size
        $posted_size_id = $this->input->post('size_id');
        $posted_size_id = !is_array($posted_size_id) ? array() : $posted_size_id;
        $size_ids = implode(",", $posted_size_id);
        //color
        $posted_color_id = $this->input->post('color_id');
        $posted_color_id = !is_array($posted_color_id) ? array() : $posted_color_id;
        $color_ids = implode(",", $posted_color_id);
      

        $posted_data = array(
            'category_id' => implode(',', $this->input->post('category_id')),
            'category_links' => $category_links,
            'friendly_url' => $this->cbk_friendly_url,
            'product_name' => $this->input->post('product_name', TRUE),
            'product_code' => $this->input->post('product_code', TRUE),
            'product_price' => $this->input->post('product_price', TRUE),
            'product_discounted_price' => $this->input->post('discounted_price', TRUE),
            'product_qty' => $this->input->post('product_qty', TRUE),
            'color_ids' => $color_ids,
            'size_ids' => $size_ids,
            'short_desc' => $this->input->post('short_desc', TRUE),
            'specification' => $this->input->post('specification', TRUE),
            'product_alt' => $this->input->post('product_name'),
            'products_description' => $this->input->post('description'),
            //'youtube_id' => $this->input->post('youtube_id', TRUE),
            'product_updated_date' => $this->config->item('config.date.time')
        );
        //trace($posted_data); exit;
        $where = "products_id = '" . $res['products_id'] . "'";
        $this->product_model->safe_update('wps_products', $posted_data, $where, FALSE);

        if ($this->input->get_post('metaTitle') != '') {
          $title = $this->input->get_post('metaTitle');
          $description = $this->input->get_post('metaDescription');
          $keywords = $this->input->get_post('metaKeyword');
        } else {
          $title = $this->input->post('product_name');
          $description = $this->input->post('product_name');
          $keywords = $this->input->post('product_name');
        }
        $posted_data_meta = array(
            'meta_title' => $title,
            'meta_description' => $description,
            'meta_keyword' => $keywords,
            'page_url' => $this->cbk_friendly_url,
        );
        $this->db->where('entity_id', $res['products_id']);
        $this->db->where('entity_type', 'products/detail');
        $this->db->update('wps_meta_tags', $posted_data_meta);
        //update_meta_page_url('products/detail', $res['products_id'], $this->cbk_friendly_url);

        $this->session->set_userdata(array('msg_type' => 'success'));
        $this->session->set_flashdata('success', lang('successupdate'));
        if ($this->input->post('category_id') > 0) {
          redirect('wps-admin/products/index/' . $this->input->post('category_id'), '');
        } else {
          redirect('wps-admin/products/' . query_string(), '');
        }
      }

      /* Available Color Records */
      $color_cond_config = array(
          'condition' => " AND status='1' ",
          'order' => 'color_name '
      );
      $colors = $this->color_model->getcolors($color_cond_config);
      $data['colors'] = $colors;
      /* Available Size Records */
      $size_cond_config = array(
          'condition' => " AND status='1' ",
          'order' => 'size_name '
      );
      $sizes = $this->size_model->getsizes($size_cond_config);
      $data['sizes'] = $sizes;
      /* Available Size Records */
     
      $metaDets = get_db_single_row("wps_meta_tags", "meta_title, meta_description, meta_keyword", "entity_type = 'products/detail' AND entity_id = '" . $res['products_id'] . "'");
      $data['metaDets'] = $metaDets;
      $data['media_res'] = $media;
      $data['res'] = $res;
      $media_option = array('productid' => $res['products_id']);
      $res_photo_media = $this->product_model->get_product_media(5, 0, $media_option);
      $data['res_photo_media'] = $res_photo_media;
      $this->load->view('products/view_product_edit', $data);
    } else {
      redirect('wps-admin/products', '');
    }
  }


  public function check_price() {
    $disc_price = $this->input->post('product_discounted_price');
    $price = $this->input->post('product_price');
    if ($disc_price != '' && $price != '') {
      $disc_price = floatval($disc_price);
      $price = floatval($price);
      if ($disc_price >= $price && $disc_price > 0 && $price > 0) {
        $this->form_validation->set_message('check_price', 'Discount price must be less than actual price.');
        return FALSE;
      } else {
        return TRUE;
      }
    } else {
      return TRUE;
    }
  }


  public function check_upload_excel() {
    $filearrext = array('xls');
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

 

  public function view_stocks() {
    $productId = (int) $this->uri->segment(4);
    $option = array('productid' => $productId);
    $res = $this->product_model->get_products(1, 0, $option);
    if (is_array($res)) {
      $res = $res[0];
      $post_err = array(
          'quantity' => array(),
          'product_price' => array(),
          'product_discounted_price' => array()
      );
      $post_error = FALSE;
      if ($this->input->post('sub') != '') {
        $product_price = $this->input->post('product_price');
        $product_discounted_price = $this->input->post('product_discounted_price');
        $quantity = $this->input->post('quantity');
        $color_id = $this->input->post('color');
        $size_id = $this->input->post('size');
        $color_traced = TRUE;
        $size_traced = TRUE;
        if (!is_array($color_id)) {
          $color_traced = FALSE;
        }
        if (!is_array($size_id)) {
          $size_traced = FALSE;
        }
        $data_insert = array();
        foreach ($quantity as $key => $val) {
          $loop_verified = TRUE;
          $loop_price = $product_price[$key];
          $loop_discount_price = $product_discounted_price[$key];
          $loop_quantity = $val;
          $loop_color_id = $color_traced === TRUE ? $color_id[$key] : 0;
          $loop_size_id = $size_traced === TRUE ? $size_id[$key] : 0;
          if ($loop_price != '' || $loop_discount_price != '' || $loop_quantity != '') {
            // if ($loop_price == '') {
            //   $post_err['product_price'][$key] = "Price is required";
            //   $loop_verified = FALSE;
            // } elseif (!array_key_exists($key, $post_err['product_price'])) {
            //   if (!preg_match('/^[0-9]*(\.)?[0-9]+$/', $loop_price)) {
            //     $post_err['product_price'][$key] = "Price is invalid";
            //     $loop_verified = FALSE;
            //   }
            //   if ($loop_price >= 10000000) {
            //     $post_err['product_price'][$key] = "Price must be less than 10000000";
            //     $loop_verified = FALSE;
            //   }
            //   if ($loop_price <= 0) {
            //     $post_err['product_price'][$key] = "Price must be greater than 0";
            //     $loop_verified = FALSE;
            //   }
            // }
            if ($loop_discount_price != '') {
              if (!preg_match('/^[0-9]*(\.)?[0-9]+$/', $loop_price)) {
                $post_err['product_discounted_price'][$key] = "Price is invalid";
                $loop_verified = FALSE;
              } elseif (!array_key_exists($key, $post_err['product_price'])) {
                if ($loop_discount_price >= $loop_price) {
                  $post_err['product_discounted_price'][$key] = "Price must be less than actual price";
                  $loop_verified = FALSE;
                }
              }
            }
            if ($loop_quantity == '') {
              $post_err['quantity'][$key] = "Quantity is required";
              $loop_verified = FALSE;
            } elseif (!array_key_exists($key, $post_err['quantity'])) {
              if (!preg_match('/^[0-9]+$/', $loop_quantity)) {
                $post_err['quantity'][$key] = "Quantity is invalid";
                $loop_verified = FALSE;
              }
            }
            if ($loop_verified === TRUE) {
              $data_insert[] = array(
                  'product_id' => $res['products_id'],
                  'color_id' => $loop_color_id,
                  'size_id' => $loop_size_id,
                  'product_price' => $loop_price,
                  'product_discounted_price' => $loop_discount_price == '' ? null : $loop_discount_price,
                  'quantity' => $loop_quantity
              );
            } else {
              $post_error = TRUE;
            }
          }
        }
        if ($post_error === FALSE) {
          $this->db->query("DELETE FROM wps_product_attributes WHERE product_id='" . $res['products_id'] . "'");
          if (!empty($data_insert)) {
            foreach ($data_insert as $val) {
              $this->product_model->safe_insert('wps_product_attributes', $val, FALSE);
            }
          }
          $this->session->set_userdata(array('msg_type' => 'success'));
          $this->session->set_flashdata('success', lang('successupdate'));
          redirect('wps-admin/products/view_stocks/' . $res['products_id'], '');
        }
      }
      $matrix_arr_filled = FALSE;
      $matrix_arr_db = array();
      $attr_cond = array(
          'where' => "product_id='" . $res['products_id'] . "'"
      );
      $res_attr = $this->product_model->product_attributes($attr_cond);
      if (is_array($res_attr) && !empty($res_attr)) {
        foreach ($res_attr as $val) {
          $color_id = $val['color_id'];
          $size_id = $val['size_id'];
          $matrix_arr_db[$color_id][$size_id] = $val;
          $matrix_arr_filled = TRUE;
        }
      }
      $color_ids = $res['color_ids'] != '' ? $res['color_ids'] : "-9999";
      $prod_color_cond = array(
          'where' => "wlc.color_id IN($color_ids)"
      );
      $res_colors = $this->product_model->related_colors($prod_color_cond);
      $size_ids = $res['size_ids'] != '' ? $res['size_ids'] : "-9999";
      $prod_size_cond = array(
          'where' => "wls.size_id IN($size_ids)"
      );
      $res_size = $this->product_model->related_sizes($prod_size_cond);
      $data['res_size'] = $res_size;
      $data['res_colors'] = $res_colors;
      $data['res_attr'] = $res_attr;
      $data['matrix_arr_filled'] = $matrix_arr_filled;
      $data['matrix_arr_db'] = $matrix_arr_db;
      $data['res'] = $res;
      $data['headingTitle'] = "Manage Stocks";
      $data['post_err'] = $post_err;
      $this->load->view('products/view_stock_products', $data);
    }
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
   /*--------------        New code by raaz      --------------*/
    
    public function set_as_arrival_prod($products_id)
    {
        $data=array('newarrival_product'=>'1');
        $where=array('products_id'=>$products_id);
        $tb='wps_products';
        
        if($this->Admin_common_model->update_where($tb,$data,$where))
        {
            $this->session->set_flashdata('msg', "Successfully updated!");
            redirect('wps-admin/products');
        }
        
    }
    
    public function set_as_sale_prod($products_id)
    {
        $data=array('popular_product'=>'1');
        $where=array('products_id'=>$products_id);
        $tb='wps_products';
        if($this->Admin_common_model->update_where($tb,$data,$where))
        {
            $this->session->set_flashdata('msg', "Successfully updated!");
            redirect('wps-admin/products');
        }
    }
    
    public function set_home_bottom_product($products_id)
    {
        $data=array('home_bottom_product'=>'1');
        $where=array('products_id'=>$products_id);
        $tb='wps_products';
        if($this->Admin_common_model->update_where($tb,$data,$where))
        {
            $this->session->set_flashdata('msg', "Successfully updated!");
            redirect('wps-admin/products');
        }
    }
    public function set_as_todaysdeal_prod($products_id)
    {
        $data=array('todays_deal'=>'1');
        $where=array('products_id'=>$products_id);
        $tb='wps_products';
        if($this->Admin_common_model->update_where($tb,$data,$where))
        {
            $this->session->set_flashdata('msg', "Successfully updated!");
            redirect('wps-admin/products');
        }
    }
    public function unset_as_todaysdeal_prod($products_id)
    {
        $data=array('todays_deal'=>'0');
        $where=array('products_id'=>$products_id);
        $tb='wps_products';
        if($this->Admin_common_model->update_where($tb,$data,$where))
        {
            $this->session->set_flashdata('msg', "Successfully updated!");
            redirect('wps-admin/products');
        }
    }
    
    // seasonal delight start set and unset
    
     public function set_seasonal_delight($products_id)
    {
        $data=array('seasonal_delights'=>'1');
        $where=array('products_id'=>$products_id);
        $tb='wps_products';
        if($this->Admin_common_model->update_where($tb,$data,$where))
        {
            $this->session->set_flashdata('msg', "Successfully updated!");
            redirect('wps-admin/products');
        }
    }
    public function unset_seasonal_delight($products_id)
    {
        $data=array('seasonal_delights'=>'0');
        $where=array('products_id'=>$products_id);
        $tb='wps_products';
        if($this->Admin_common_model->update_where($tb,$data,$where))
        {
            $this->session->set_flashdata('msg', "Successfully updated!");
            redirect('wps-admin/products');
        }
    }
    
    
    
    
    // seasonal delight end set unset
    public function unset_home_bottom_product($products_id)
    {
         $data=array('home_bottom_product'=>'1');
        $where=array('products_id'=>$products_id);
        $tb='wps_products';
        if($this->Admin_common_model->update_where($tb,$data,$where))
        {
           $this->session->set_flashdata('msg', "Successfully updated!");
            redirect('wps-admin/products');
        }
        
    }
    public function unset_as_arrival_prod($products_id)
    {
         $data=array('newarrival_product'=>'0');
        $where=array('products_id'=>$products_id);
        $tb='wps_products';
        if($this->Admin_common_model->update_where($tb,$data,$where))
        {
           $this->session->set_flashdata('msg', "Successfully updated!");
            redirect('wps-admin/products');
        }
        
    }
    
    public function unset_as_sale_prod($products_id)
    {
          $data=array('popular_product'=>'0');
        $where=array('products_id'=>$products_id);
        $tb='wps_products';
        if($this->Admin_common_model->update_where($tb,$data,$where))
        {
            
            $this->session->set_flashdata('msg', "Successfully updated!");
            redirect('wps-admin/products');
        }
    }
    
    public function delete_product($pid)
    {
           $query="delete FROM wps_products where products_id='$pid'";
            $product= $this->db->query($query);
            
             $query="delete FROM wps_products_media where products_id='$pid'";
             $media= $this->db->query($query);
            
            $query="delete FROM wps_meta_tags where entity_id='$pid'";
            $tag= $this->db->query($query);
        if($product && $media && $tag)
        {
            $this->session->set_flashdata('msg',"<div class='alert alert-success'>Successfully Deleted!</div>");
             redirect('wps-admin/products');
        }
        else
        {
            $this->session->set_flashdata('msg',"<div class='alert alert-danger'>Not Deleted!</div>");
              redirect('wps-admin/products');
        }
    }
    
  
  
     public function change_status_prod()
    {
        $products_id                               =   $this->input->post('product_id'); 
        $status                                    =   $this->input->post('status'); 
        $remark                                    =   $this->input->post('remark'); 
        
        $admin_margin_percent                      =   $this->input->post('admin_margin_percent');
        $admin_margin_amount                       =   $this->input->post('admin_margin_amount');
        $prev_product_price                        =   $this->input->post('prev_product_price');
        $new_selling_price                         =   $this->input->post('new_selling_price');
     
        $data=array(
            'status'=>$status,
            'approval_remark'=>$remark,
            'approval_date'=>date('Y-m-d H:i:s'),
            'admin_margin_percent'=>$this->input->post('admin_margin_percent'),
            'admin_margin_amount'=>$this->input->post('admin_margin_amount'),
            'prev_product_price'=>$this->input->post('prev_product_price'),
            'product_discounted_price'=>$this->input->post('new_selling_price'),
            
            );
        $where=array('products_id'=>$products_id);
        $tb='wps_products';
        if($this->Admin_common_model->update_where($tb,$data,$where))
        {
            $this->session->set_flashdata('msg', "Successfully updated!");
            redirect('wps-admin/products');
        }
    }
    
    public function hsncode()
    {
        
        $where=array('status'=>'1');
        $data['category_list']= $this->Admin_common_model->get_where('wps_categories',$where);
        
        $query="SELECT hsn_master.*,wps_categories.category_name FROM `hsn_master` inner join wps_categories on wps_categories.category_id=hsn_master.category_id";
        $data['hsn_list']=$this->Admin_common_model->run_raw_query($query);
        
        $data['headingTitle'] = "Manage HSN Code";
        $this->load->view('hsncode/hsncode', $data);
    }
    
    public function addhsncode()
    {
        $this->form_validation->set_rules('category_name','category_name','trim|required');
        $this->form_validation->set_rules('hsncode','hsncode','trim|required');
        $this->form_validation->set_rules('taxrate','taxrate','trim|required');
        if($this->form_validation->run())
        {
            $data=array(
                        'category_id' =>$this->input->post('category_name'),
                        'hsn_code'       =>$this->input->post('hsncode'),
                        'tax_rate'       =>$this->input->post('taxrate'),
                        'updated_at'     =>date('Y-m-d H:i:s'),
                        'created_at'     =>date('Y-m-d H:i:s'),
                            );
            if($this->Admin_common_model->add_master('hsn_master',$data))
            {
                $this->session->set_flashdata('hsnaddsuccess','<div class="alert alert-success">Suucessfully Added</div>');
                redirect('wps-admin/products/hsncode');
            }
            else
            {
                $this->session->set_flashdata('hsnaddsuccess','<div class="alert alert-danger">Not Added</div>');
                redirect('wps-admin/products/hsncode');
            }
        }
        else
        {
            $this->session->set_flashdata('hsnaddsuccess',"<div class='alert alert-danger'>".validation_errors()."</div>");
                redirect('wps-admin/products/hsncode');
        }
    }
    
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  

}

// End of controller