<?php

class Location extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model(array('location_model'));
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
      $condtion = "AND name like '%" . $keyword . "%'";
    }
    $condtion_array = array(
    );
    $res_array = $this->location_model->get_record();
    $config['total_rows'] = $this->location_model->total_rec_found;
    //$data['page_links'] = admin_pagination($base_url, $config['total_rows'], $config['limit'], $offset);
    $data['headingTitle'] = "Manage Location";
    $data['res'] = $res_array;


    if ($this->input->post('action') != '') {
      $this->update_status('wps_countries_list', 'id');
    }

    $this->load->view('location/list_view', $data);
  }

  public function add_country() {
    $data['headingTitle'] = "Add Location";
    if ($this->input->post('submit')) {
      $country_name = $this->db->escape_str($this->input->post('country'));
      $this->form_validation->set_rules('country', "Country Name", "trim|required|unique[wps_countries_list.name ='" . $country_name . "' AND status!='2']");
      if ($this->form_validation->run() == TRUE) {
        $url_title = str_replace("-", "", url_title($this->input->post('country')));
        $posted_data = array(
            'name' => $this->input->post('country'),
            'country_temp_name' => $url_title,
        );
        $this->location_model->safe_insert('wps_countries_list', $posted_data, FALSE);
        $this->session->set_flashdata('success', lang('success'));
        redirect("wps-admin/location/");
      }
    }
    $this->load->view("location/add_country", $data);
  }

  public function edit_country() {
    $country_id = $this->uri->segment(4, 0);
    $data['res'] = $this->db->query("SELECT * FROM wps_countries_list WHERE id=$country_id")->row();
    $data['country'] = $this->db->query("SELECT * FROM wps_countries_list ORDER BY name ASC")->result_array();

    $data['headingTitle'] = "Edit Location";
    //print_r($data['res']);exit; 
    if ($this->input->post('update')) {
        $country_name = $this->db->escape_str($this->input->post('country'));
      $this->form_validation->set_rules('country', "Country Name", "trim|required|unique[wps_countries_list.name ='" . $country_name . "' AND status!='2' AND id!='" . $country_id . "']");
      if ($this->form_validation->run() == TRUE) {
        $url_title = str_replace("-", "", url_title($this->input->post('country')));
        $posted_data = array(
            'name' => $this->input->post('country'),
            'country_temp_name' => $url_title,
        );
        $where = "id=" . $country_id;
        $this->location_model->safe_update('wps_countries_list', $posted_data, $where, FALSE);
        $this->session->set_flashdata('success', lang('successupdate'));
        redirect("wps-admin/location/");
      }
    }
    $this->load->view("location/edit_country", $data);
  }

  //State
  public function state() {
    $pagesize = (int) $this->input->get_post('pagesize');
    $config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
    $offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
    $base_url = current_url_query_string(array('filter' => 'result'), array('per_page'));
    $keyword = $this->db->escape_str(trim($this->input->get_post('keyword', TRUE)));
    $country_id = $this->db->escape_str(trim($this->input->get_post('country_id', TRUE)));
    $condtion = " ";
    if ($keyword != '') {
      $condtion .= "AND title like '%" . $keyword . "%'";
    }
    if ($country_id > 0) {
      $condtion .= "AND country_id ='" . $country_id . "'";
    }
    $condtion_array = array(
    );
    $res_array = $this->location_model->get_states($condtion_array);
    $config['total_rows'] = $this->location_model->total_rec_found;
    //$data['page_links'] = admin_pagination($base_url, $config['total_rows'], $config['limit'], $offset);
    $data['headingTitle'] = "Manage States";
    $data['res'] = $res_array;
    if ($this->input->post('action') != '') {
      $this->update_status('wps_states_list', 'id');
    }
    $this->load->view('location/state_list_view', $data);
  }

  public function state_add() {

    $country = $this->db->query("SELECT * FROM wps_countries_list WHERE status='1' ORDER BY name ASC")->result_array();
    $data['country'] = $country;
    $data['headingTitle'] = "Add State";
    $state_name = $this->db->escape_str($this->input->post('state'));
      $this->form_validation->set_rules('country_id', 'Country', "trim|required");
      $this->form_validation->set_rules('state', 'State', "trim|required|unique[wps_states_list.name ='" . $state_name . "' AND status!='2']");
      if ($this->form_validation->run() == TRUE) {
        $url_title = seo_url_title($this->input->post('state'));
        $posted_data = array(
            'name' => $this->input->post('state'),
            'temp_title' => $url_title,
            'country_id' => $this->input->post('country_id'),
        );
        $insertId = $this->location_model->safe_insert('wps_states_list', $posted_data, FALSE);
        if ($insertId > 0) {
          $posted_data_meta = array(
              'is_fixed' => 'L',
              'entity_type' => 'home/index',
              'entity_id' => $insertId,
              'page_url' => $url_title,
              'meta_title' => $this->input->post('state'),
              'meta_description' => $this->input->post('state'),
              'meta_keyword' => $this->input->post('state'),);
          $this->location_model->safe_insert('wps_meta_tags', $posted_data_meta, FALSE);
        }

        $this->session->set_flashdata('success', lang('success'));
        redirect(base_url("wps-admin/location/state"));
      }
    
    $this->load->view('location/state_add', $data);
  }

  public function state_edit() {
    $id = (int) $this->uri->segment(4, 0);
    $row_data = '';
    $data['id'] = $id;
    $country = $this->db->query("SELECT * FROM wps_countries_list WHERE status='1' ORDER BY name ASC")->result_array();
    $data['country'] = $country;
    $row_data = $this->location_model->get_single_row("wps_states_list", $id);
    $data['row_data'] = $row_data;
    $page_url = $row_data->temp_title;

    //print_r($data['row_data']);exit;
    $data['headingTitle'] = 'Edit State';
    if ($this->input->post('update')) {
        $state_name = $this->db->escape_str($this->input->post('state'));
      $this->form_validation->set_rules('country_id', 'Country Name', "trim|required");
      $this->form_validation->set_rules('state', 'State', "trim|required|unique[wps_states_list.name ='" . $state_name . "' AND status!='2' AND id!='" . $id . "']");

      if ($this->form_validation->run() == TRUE) {
        $url_title = seo_url_title($this->input->post('state'));
        $posted_data = array(
            'name' => $this->input->post('state'),
            'temp_title' => $url_title,
            'country_id' => $this->input->post('country_id'),
        );
        $where = "id=" . $row_data->id;
        $this->location_model->safe_update('wps_states_list', $posted_data, $where, FALSE);

        //Update meta table
        // $posted_data_meta = array(
        //     'page_url' => $url_title,
        //     'meta_title' => $this->input->post('state'),
        //     'meta_description' => $this->input->post('state'),
        //     'meta_keyword' => $this->input->post('state'),);
        // $where_meta = "entity_type = 'home/index' AND entity_id = " . $row_data->id . " AND page_url = '" . $page_url . "'";
        //$this->location_model->safe_update('wps_meta_tags', $posted_data_meta, $where_meta, FALSE);
        $posted_data_meta = array(
          'is_fixed' => 'L',
          'entity_type' => 'home/index',
          'entity_id' => $row_data->id,
          'page_url' => $url_title,
          'meta_title' => $this->input->post('state'),
          'meta_description' => $this->input->post('state'),
          'meta_keyword' => $this->input->post('state'),);
        $this->location_model->safe_insert('wps_meta_tags', $posted_data_meta, FALSE);

        $this->session->set_flashdata('success', lang('successupdate'));
        redirect(base_url('wps-admin/location/state'));
      }
    }
    $this->load->view('location/state_edit_view', $data);
  }

  //City
  public function city() {
    $pagesize = (int) $this->input->get_post('pagesize');
    $config['limit'] = ( $pagesize > 0 ) ? $pagesize : $this->config->item('pagesize');
    $offset = ( $this->input->get_post('per_page') > 0 ) ? $this->input->get_post('per_page') : 0;
    $base_url = current_url_query_string(array('filter' => 'result'), array('per_page'));


    $keyword = $this->db->escape_str(trim($this->input->get_post('keyword', TRUE)));
    $country_id = $this->db->escape_str(trim($this->input->get_post('country_id', TRUE)));
    $state_id = $this->db->escape_str(trim($this->input->get_post('state_id', TRUE)));
    //$district_id = $this->db->escape_str(trim($this->input->get_post('district_id', TRUE)));


    $condtion = " ";
    if ($keyword != '') {
      $condtion .= "AND title like '%" . $keyword . "%'";
    }
    if ($state_id > 0) {
      $condtion .= "AND state_id ='" . $state_id . "'";
    }
    if ($country_id > 0) {
      $condtion .= "AND country_id ='" . $country_id . "'";
    }

    $condtion_array = array();
    $res_array = $this->location_model->get_city($condtion_array);
    $config['total_rows'] = $this->location_model->total_rec_found;
    $data['headingTitle'] = "Manage City";
    $data['res'] = $res_array;

    if ($this->input->post('action') != '') {
      $this->update_status('wps_cities_list', 'id');
    }
    if ($this->input->post('set_as') != '') {
      $set_as = $this->input->post('set_as', TRUE);
      $this->set_as('wps_cities_list', 'id', array($set_as => '1'));
    }
    if ($this->input->post('unset_as') != '') {
      $unset_as = $this->input->post('unset_as', TRUE);
      $this->set_as('wps_cities_list', 'id', array($unset_as => '0'));
    }
    $this->load->view('location/city_list_view', $data);
  }

  public function city_add() {

    $data['headingTitle'] = "Add City";
    $data['country'] = $this->db->query("SELECT * FROM wps_countries_list WHERE status='1' ORDER BY name ASC")->result_array();
    if ($this->input->post('submit')) {
        $city_name = $this->db->escape_str($this->input->post('city'));
      $this->form_validation->set_rules('country_id', "Country Name", 'trim|required');
      $this->form_validation->set_rules('state_id', "State Name", "trim|required");
      $this->form_validation->set_rules('city', "City Name", "trim|required|unique[wps_cities_list.city ='" . $city_name . "' AND status!='2']");
      $this->form_validation->set_rules('image1', 'City Image', "file_allowed_type[image]");
      if ($this->form_validation->run() == TRUE) {

        $uploaded_file = "";
        if (!empty($_FILES) && $_FILES['image1']['name'] != '') {
          $config['max_size'] = '2048';
          $this->load->library('upload');
          $uploaded_data = $this->upload->my_upload('image1', 'location', $this->input->post('city') . rand());
          if (is_array($uploaded_data) && !empty($uploaded_data)) {
            $uploaded_file = $uploaded_data['upload_data']['file_name'];
          }
        }

        $url_title = seo_url_title($this->input->post('city'));
        $posted_data = array(
            'city' => $this->input->post('city'),
            'temp_title' => $url_title,
            'country_id' => $this->input->post('country_id'),
            'state_id' => $this->input->post('state_id'),
            'image_name' => $uploaded_file,
        );
        $insertId = $this->location_model->safe_insert('wps_cities_list', $posted_data, FALSE);
        if ($insertId > 0) {
          $posted_data_meta = array(
              'is_fixed' => 'L',
              'entity_type' => 'home/index',
              'entity_id' => $insertId,
              'page_url' => $url_title,
              'meta_title' => $this->input->post('city'),
              'meta_description' => $this->input->post('city'),
              'meta_keyword' => $this->input->post('city'),);
          $this->location_model->safe_insert('wps_meta_tags', $posted_data_meta, FALSE);
        }
        $this->session->set_flashdata('success', lang('success'));
        redirect(base_url('wps-admin/location/city'));
      }
    }

    $this->load->view("location/city_add", $data);
  }

  public function city_edit() {
    $city_id = $this->uri->segment(4, 0);
    $res = $this->db->query("SELECT * FROM wps_cities_list WHERE id=$city_id")->row();
    $data['res'] = $res;
    $page_url = $res->temp_title;

    //Data
    $data['headingTitle'] = "Edit City";
    $data['country'] = $this->db->query("SELECT * FROM wps_countries_list WHERE status='1' ORDER BY name ASC")->result_array();
    $state = $this->db->query("SELECT * FROM wps_states_list WHERE country_id='$res->country_id' AND status='1' ORDER BY name ASC")->result_array();
    $data['states'] = $state;

    if ($this->input->post('update')) {
        $city_name = $this->db->escape_str($this->input->post('city'));
      $this->form_validation->set_rules('country_id', "Country Name", "trim|required");
      $this->form_validation->set_rules('state_id', "State Name", "trim|required");
      $this->form_validation->set_rules('city', "City Name", "trim|required|unique[wps_cities_list.city ='" . $city_name . "' AND status!='2' AND id!='" . $city_id . "']");
      if ($this->form_validation->run() == TRUE) {

        $url_title = seo_url_title($this->input->post('city'));
        $posted_data = array(
            'city' => $this->input->post('city'),
            'temp_title' => $url_title,
            'state_id' => $this->input->post('state_id'),
            'country_id' => $this->input->post('country_id'),
            'image_name' => $uploaded_file,
        );
        //trace($posted_data); die;
        $where = "id=" . $city_id;
        $this->location_model->safe_update('wps_cities_list', $posted_data, $where, FALSE);

        //Update meta table
        $posted_data_meta = array(
            'page_url' => $url_title,
            'meta_title' => $this->input->post('city'),
            'meta_description' => $this->input->post('city'),
            'meta_keyword' => $this->input->post('city'),
        );
        $where_meta = "entity_type = 'home/index' AND entity_id = " . $res->id . " AND page_url = '" . $page_url . "'";
        $this->location_model->safe_update('wps_meta_tags', $posted_data_meta, $where_meta, FALSE);
        //End
        $this->session->set_flashdata('success', lang('successupdate'));
        redirect(base_url('wps-admin/location/city'));
      }
    }
    $this->load->view("location/city_edit", $data);
  }

  //ajax state calling

  public function ajax_state() {
    $country_id = $this->input->post('country_id');
    $states = $this->db->query("SELECT * FROM wps_states_list WHERE country_id=$country_id AND status='1' order by name asc")->result_array();
    foreach ($states as $state) {
      echo "<option value=" . $state['id'] . ">" . $state['name'] . "</option>";
    }
  }

}

// End of controller