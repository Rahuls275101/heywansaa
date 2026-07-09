<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Bulkmodel extends MY_Model {

  public function __construct() {
    parent::__construct();
  }

public function get_master($tb)
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
    if($r=$this->db->insert($tb,$data))
    {
       return true; 
    }
    else
    {
       return false;
    }
}

public function update_where($tb,$data,$where)
{
    $this->db->where($where);
    if($r=$this->db->update($tb,$data))
    {
       return true; 
    }
    else
    {
       return false;
    }
}

public function delete_where()
{
    
}

public function get_raw_query($query)
{
    if($r=$this->db->query($query))
    {
        return $r->result();
    }
    else
    {
        return false;
    }
}


}