<?php
class Transaction_model extends CI_Model
{
    
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