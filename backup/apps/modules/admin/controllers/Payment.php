<?php
class Payment extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Payment_model');
    }
    public function index()
    {
        $r['headingTitle']='Payment Request List';
        $query="SELECT payment_request.*, wps_admin.name, wps_admin.admin_email, wps_admin.phone, wps_admin.city, wps_admin.address FROM `payment_request` inner join wps_admin on wps_admin.admin_id=payment_request.vendor_id group by payment_request.id";
        $r['res']=$this->Payment_model->_run_raw_query($query);
        $this->load->view('payment/all_request_list',$r);
    }
    public function change_request_status()
    {
         $req_id        =   $this->input->post('req_id');
         $vid           =   $this->input->post('vid');
         $req_val       =   $this->input->post('change_status'); //if 0 then cancel status will be 1 if 1 then admin confirm
         $admin_remark  =   $this->input->post('admin_remark');
         
         
       
         
         
                $where=array('id'=>$req_id);
                if($req_val==0)
                {
                    $data=array('cancel_status'=>'1','admin_status'=>'0','admin_remark'=>$admin_remark);
                     if($this->Payment_model->update_where('payment_request',$data,$where))
                    {
                        $this->session->set_flashdata('msg','Successfully  updated.');
                        redirect('wps-admin/payment');
                    }
                    else
                    {
                        $this->session->set_flashdata('msg','Something Error');
                        redirect('wps-admin/payment');
                    }
                }
                else if($req_val==1)
                {
                         $where=array('id'=>$req_id);
                         $query="SELECT payment_request.* FROM `payment_request` where id='$req_id'";
                         $payment_request_data  =   $this->Payment_model->_run_raw_query($query);
                        if($payment_request_data[0]['vendor_id']!= $vid  )
                        {
                            $this->session->set_flashdata('msg','Something Error!!');
                            redirect('wps-admin/payment');
                        }
                         $query="SELECT sum(debit) as debit,sum(credit) as credit FROM `transaction` WHERE vendor_id='$vid'";
                         $transaction_data      =   $this->Payment_model->_run_raw_query($query);
                         
                         $debit      =    $transaction_data[0]['debit'];
                         $credit     =    $transaction_data[0]['credit'];
                         $req_amount =    $payment_request_data[0]['amount'];
                         
                        $data=array('admin_status'=>'1','cancel_status'=>'0','admin_remark'=>$admin_remark);
                        if(($debit-$credit)>$req_amount)
                        {
                            $trans_data=array('credit'=>$req_amount,'debit'=>'0','vendor_id'=>$vid,'remark'=>'Payment Done');
                            if($this->Payment_model->update_where('payment_request',$data,$where) && $this->Payment_model->add_master('transaction',$trans_data))
                            {
                                $this->session->set_flashdata('msg','Successfully  updated.');
                                redirect('wps-admin/payment');
                            }
                            else
                            {
                                $this->session->set_flashdata('msg','Something Error');
                                redirect('wps-admin/payment');
                            }
                        }
                        else
                        {
                             $this->session->set_flashdata('msg','Amount more than balance kindly cancel this');
                            redirect('wps-admin/payment');
                        }
                
                
         }
         else
         {
             $this->session->set_flashdata('msg','Something error in your Action');
                    redirect('wps-admin/payment');
         }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

?>