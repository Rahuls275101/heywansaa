<?php

class Model_variant extends CI_Model{


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

public function get_variant_list_by_product($product_id,$vendor_id)
{
	$where=array('product_id'=>$product_id,'vendor_id'=>$vendor_id);
	$this->db->where($where);
	if($r=$this->db->get('product_variant'))
	{
		return $r->result_array();
	}
	else
	{
		return false;
	}
}



}
