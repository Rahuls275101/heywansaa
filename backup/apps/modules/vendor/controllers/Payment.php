<?php
class Payment extends Admin_Controller{
    
    function __construct() 
    {
        parent::__construct();
        $this->load->model('Payment_model');
    }
    
    public function index()
    {
        // $this->load->model('Payment_model');
        $data['headingTitle']="Payment Request";
        $vid=$this->get_vendor_id();
        $data['res']=$this->Payment_model->get_my_money_control($vid);
        
        $where=array('vendor_id'=>$vid);
        
        
        $data['req']=$this->Payment_model->get_where('payment_request',$where);
        
         $this->load->view('payment/payment_request',$data);
    }
    
    public function new_request_action()
    {
        $this->form_validation->set_rules('amount','amount','required|trim');
        $this->form_validation->set_rules('agent_remark','agent_remark','required|trim');
        if($this->form_validation->run())
        {
                   $vid=$this->get_vendor_id();
            $data=array(
                        'vendor_id'=>$vid,
                        'amount'=>$this->input->post('amount'),
                        'vendor_remark'=>$this->input->post('agent_remark'),
                        'req_date'=>date('Y-m-d h:i:s'),
                        );
            if($this->Payment_model->add_master('payment_request',$data))
            {
                $this->session->set_flashdata('msg','Successfully Requested');
                redirect('wps-vendor/payment/request');
            }
            else
            {
                $this->session->set_flashdata('msg','Error in Requesting');
                redirect('wps-vendor/payment/request');
            }
        }
        else
        {
                $this->session->set_flashdata('msg',validation_errors());
                redirect('wps-vendor/payment/request'); 
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function get_vendor_id()
    {
        return $this->session->userdata()['admin_id'];
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}


?>