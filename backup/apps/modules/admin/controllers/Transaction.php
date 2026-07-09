<?php

class Transaction extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Transaction_model');
  }

  public function index($page = NULL) 
  {
        $data['res']=$this->Transaction_model->get_transaction_data();
        $data['headingTitle']="Transaction";
        $this->load->view('transaction/transaction',$data);
      
  }
  
  
  
  
  
}