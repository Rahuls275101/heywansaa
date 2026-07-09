<?php
class Admin_common_model extends CI_Model
{
    
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
    
    
    
    
    
    
    
    
    
    
    
    
    
}


?>