<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Model_top_ten_link extends MY_Model {

  public function __construct() 
  {
    parent::__construct();
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


}
