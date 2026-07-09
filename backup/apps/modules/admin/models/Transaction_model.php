<?php
class Transaction_model extends CI_Model
{
    
  public function get_master($tb)
  {
      if($r=$this->db->get($tb))
      {
          return $r->result_array();
      }
      else
      {
          return false;
      }
  }
  
  public function get_transaction_data()
  {
      $query="SELECT `transaction`.`vendor_id`, `transaction`.`credit`, `transaction`.`debit`, `transaction`.`remark`, `transaction`.`description`, `transaction`.`invoice_no`, `transaction`.`created_at`, wps_admin.name, wps_admin.admin_email, wps_admin.phone FROM `transaction` inner join wps_admin on wps_admin.admin_id=`transaction`.`vendor_id`";
      if($r=$this->db->query($query))
      {
          return $r->result_array();
      }
      else
      {
          return false;
      }
      
  }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}



?>