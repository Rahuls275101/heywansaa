<?php
class Transaction extends Admin_Controller{
    
    public function    __construct()
    {
     parent::__construct();
     $this->load->model('Transaction_model');
    }
    public function index()
    {
       $vendor_id=$this->get_vendor_id();
       $where=array('vendor_id'=>$vendor_id);
       $r['headingTitle']="Transaction";
       $r['res']=$this->Transaction_model->get_where('transaction',$where);
       $this->load->view('transaction/transaction',$r);
    }
    
    public function get_vendor_id()
    {
        return $this->session->userdata()['admin_id'];
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

?>