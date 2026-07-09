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
    
    public function get_Master($tb)
    {
        if($r=$this->db->get($tb))
        {
            return $r->result();
        }
        else
        {
            return false;
        }
    }
    public function add_master($tb,$data)
    {
        if($this->db->insert($tb,$data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
     public function delete_where($tb,$where)
    {
        $this->db->where($where);
        if($this->db->delete($tb))
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
    
    
    public function run_raw_query($query)
    {
        $r=$this->db->query($query);
        return $r->result_array();
    }
    
    
    
    
    
    
    
    
    
}


?>