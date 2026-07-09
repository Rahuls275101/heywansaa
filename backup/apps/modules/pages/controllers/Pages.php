<?php

class Pages extends Public_Controller {

  public function __construct() {

    parent::__construct();
    $this->load->helper(array('file'));
    $this->load->library(array('Dmailer', 'safe_encrypt'));
    $this->load->model(array('pages/pages_model'));
    $this->form_validation->set_error_delimiters("<div class='required red'>", "</div>");
    $this->page_section_ct = 'static';
  }

  public function index() {
    $friendly_url = $this->uri->uri_string;
    $condition = array('friendly_url' => $friendly_url, 'status' => '1');
    $content = $this->pages_model->get_cms_page($condition);
    $data['content'] = $content;
    $this->load->view('pages/cms_page_view', $data);
  }

  public function aboutus() {
    $friendly_url = $this->uri->uri_string;
    $condition = array('friendly_url' => $friendly_url, 'status' => '1');
    $content = $this->pages_model->get_cms_page($condition);
    $data['content'] = $content;
    $data['banner'] = $this->db->query("SELECT * FROM wps_banners WHERE banner_page='about' and status='1' and CURDATE() between banner_start_date and banner_end_date")->row_array();
    $data['latestnews1'] = $this->db->query("SELECT * FROM wps_news WHERE status='1' order by news_id desc limit 1")->row_array();
    $data['latestnews2'] = $this->db->query("SELECT * FROM wps_news WHERE status='1' order by news_id desc limit 3 offset 1")->result_array();
    $this->load->view('pages/about', $data);
  }

  

  public function contactus() {
    $adminRes = get_site_email();
    $data['adminRes'] = $adminRes;
    //trace($_SERVER['HTTP_REFERER']);

    $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha');
    $this->form_validation->set_rules('location', 'Location', 'trim|required');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|numeric|min_length[10]|max_length[10]');
    $this->form_validation->set_rules('message', 'Comment', 'trim|required');
     


    if ($this->form_validation->run() == TRUE) {
      $posted_data = array(
                              'type' => '1',
                              'first_name' => $this->input->post('first_name'),
                              'location' => $this->input->post('location'),
                              'email' => $this->input->post('email'),
                              'mobile_number' => $this->input->post('phone'),
                              'message' => $this->input->post('message'),
                              'receive_date' => $this->config->item('config.date.time')
                          );
      $this->pages_model->safe_insert('wps_enquiry', $posted_data, FALSE);
      $msg = "YOUR MESSAGE HAS BEEN SENT SUCCESSFULLY. WE WILL ENDEAVOUR TO REPLY WITHIN 24HRS. THANK YOU";
      $this->session->set_userdata(array('msg_type' => 'success'));
      $this->session->set_flashdata('success', $msg);
      redirect(base_url('contact-us'));
    }
    else
    {
     

    $friendly_url = $this->uri->uri_string;
    $condition = array('friendly_url' => $friendly_url, 'status' => '14');
    $content = $this->pages_model->get_cms_page($condition);
    $data['content'] = $content;
    $data['title'] = "Contact Us";
    $this->load->view('contactus', $data);
  }
}
  public function marketarea() {
    $data = array();

    $data['country'] = $this->db->query("SELECT id, name, country_temp_name, status FROM wps_countries_list WHERE status ='1'")->result_array();

    $data['state'] = $this->db->query("SELECT id, name, country_id, temp_title, status FROM wps_states_list WHERE status ='1'")->result_array();

    $this->load->view('marketarea', $data);
  }
  
  public function blogs()
  {
     
   
    $data['content'] = 'Blog';
    $data['title'] = "Blog List";
    $this->load->view('blog', $data);
  }
  
  

  
}

/* End of file pages.php */