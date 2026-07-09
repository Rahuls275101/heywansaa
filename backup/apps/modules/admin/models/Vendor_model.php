
<?php
class Vendor_model extends CI_Model
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
      $query="SELECT `transaction`.`vendor_id`, `transaction`.`credit`, `transaction`.`debit`, `transaction`.`remark`, `transaction`.`description`, `transaction`.`invoice_no`, `transaction`.`created_at`, wps_admin.name, wps_admin.admin_email, wps_admin.phone FROM `transaction` left join wps_admin on wps_admin.admin_id=`transaction`.`vendor_id`";
      if($r=$this->db->query($query))
      {
          return $r->result_array();
      }
      else
      {
          return false;
      }
      
  }
  
  public function get_where($tb,$where)
  {
      $this->db->where($where);
      if($r=$this->db->get($tb))
      {
          return $r->result_array();
      }
      else
      {
          return false;
      }
  }
    
  public function get_vendor_list()
  {
      $query="SELECT ifnull((sum(`transaction`.debit)),0)as debitamt, 
ifnull((sum(`transaction`.credit)),0)as credit_amt,  wps_admin.admin_id, wps_admin.admin_type, wps_admin.name, wps_admin.admin_email, wps_admin.phone, wps_admin.status as admin_status, wps_admin.address, wps_admin.city, wps_admin.country, wps_admin.tax,wps_admin.document_verify_status,
wps_admin.verification_status FROM wps_admin left join transaction on `transaction`.vendor_id=wps_admin.admin_id  WHERE 
 admin_type='2' and verification_status=2 and wps_admin.status='1' group by admin_id";
      if($r=$this->db->query($query))
      {
          return $r->result_array();
      }
      else
      {
          return false;
      }
  }
  
    public function get_un_verify_vendor_list()
  {
      $query="SELECT ifnull((sum(`transaction`.debit)),0)as debitamt, 
ifnull((sum(`transaction`.credit)),0)as credit_amt,  wps_admin.admin_id, wps_admin.admin_type, wps_admin.name, wps_admin.admin_email, wps_admin.phone, wps_admin.status as admin_status, wps_admin.address, wps_admin.city, wps_admin.country, wps_admin.tax,wps_admin.document_verify_status,
wps_admin.verification_status FROM wps_admin left join transaction on `transaction`.vendor_id=wps_admin.admin_id  WHERE 
 admin_type='2' and verification_status<>2 and wps_admin.status='1' group by admin_id order by created_at ";
      if($r=$this->db->query($query))
      {
          return $r->result_array();
      }
      else
      {
          return false;
      }
  }
    
    
    public function update_where($tb,$data,$where)
    {
        $this->db->where($where);
        if($this->db->update($tb,$data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}



?>