<?php
class Payment_model extends CI_Model
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
    
    public function _run_raw_query($query)
    {
         if($r=$this->db->query($query))
        {
            return $r->result_array();
        }
        else
        {
            return false;
        }
    }
    public function add_master($tb,$trans_data)
    {
        if($this->db->insert($tb,$trans_data))
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