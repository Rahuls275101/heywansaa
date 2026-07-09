<?php

class Order_vendor_model extends CI_Model{


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

public function get_count_order_by_vendor($vid)
{
   $this->db->select('wps_orders_products.*,wps_order.*');
    $this->db->from('wps_orders_products');
    $this->db->join('wps_order', 'wps_orders_products.order_id=wps_order.order_id');
	$this->db->group_by('wps_orders_products.order_id'); 
    $this->db->where('wps_orders_products.vendor_id',$vid);
    $this->db->order_by("wps_orders_products.order_id", "desc");

 
    $r=$this->db->get()->result_array();
    return count($r);
}
public function get_order_by_vendor($perpage,$limit,$vid)
{

    $this->db->select('wps_orders_products.*,wps_order.*');
    $this->db->from('wps_orders_products');
    $this->db->join('wps_order', 'wps_orders_products.order_id=wps_order.order_id');
	$this->db->group_by('wps_orders_products.order_id'); 
    $this->db->where('wps_orders_products.vendor_id',$vid);
    $this->db->order_by("wps_orders_products.order_id", "desc");

    $this->db->limit($perpage,$limit);
    $r=$this->db->get()->result_array();
    return $r;
}


// Pending Order  add this -> sum(wps_orders_products.product_price)as ttl_vendorProd_amt ,count(wps_orders_products.orders_products_id)count_prod_qty,
public function get_count_pending_order_by_vendor($vid)
{
      $this->db->select('wps_orders_products.*,wps_order.*');
    $this->db->from('wps_orders_products');
    $this->db->join('wps_order', 'wps_orders_products.order_id=wps_order.order_id');
    $this->db->where('wps_order.order_status','0');
    $this->db->where('wps_orders_products.vendor_id',$vid);
    $this->db->order_by("wps_orders_products.order_id", "desc");
    $this->db->group_by('wps_orders_products.order_id');
    $r=$this->db->get()->result_array();
    return count($r);
}
public function get_pending_order_by_vendor($perpage, $limit,  $vid)
{
    $this->db->select('wps_orders_products.*,wps_order.*');
    $this->db->from('wps_orders_products');
    $this->db->join('wps_order', 'wps_orders_products.order_id=wps_order.order_id');
    $this->db->where('wps_order.order_status','0');
    $this->db->where('wps_orders_products.vendor_id',$vid);
    $this->db->order_by("wps_orders_products.order_id", "desc");
    $this->db->group_by('wps_orders_products.order_id');

    $this->db->limit($perpage,$limit);
    $r=$this->db->get()->result_array();
    return $r;
}

// end of pending order
// dispatch Order
public function get_count_dispatch_order_by_vendor($vid)
{
     $this->db->select('wps_orders_products.*,wps_order.*');
    $this->db->from('wps_orders_products');
    $this->db->join('wps_order', 'wps_orders_products.order_id=wps_order.order_id');
    $this->db->where('wps_order.order_status','2');
    $this->db->where('wps_orders_products.vendor_id',$vid);
    $this->db->order_by("wps_orders_products.order_id", "desc");
    $this->db->group_by('wps_orders_products.order_id');
    $r=$this->db->get()->result_array();
    return count($r);
}
public function get_dispatch_order_by_vendor($perpage, $limit,  $vid)
{
    $this->db->select('wps_orders_products.*,wps_order.*');
    $this->db->from('wps_orders_products');
    $this->db->join('wps_order', 'wps_orders_products.order_id=wps_order.order_id');
    $this->db->where('wps_order.order_status','2');
    $this->db->where('wps_orders_products.vendor_id',$vid);
    $this->db->order_by("wps_orders_products.order_id", "desc");
    $this->db->group_by('wps_orders_products.order_id');

    $this->db->limit($perpage,$limit);
    $r=$this->db->get()->result_array();
    return $r;
}

// end of dispatch order

// Cancel Order
public function get_count_cancel_order_by_vendor($vid)
{
     $this->db->select('wps_orders_products.*,wps_order.*');
    $this->db->from('wps_orders_products');
    $this->db->join('wps_order', 'wps_orders_products.order_id=wps_order.order_id');
    $this->db->where('wps_order.order_status','5');
    $this->db->where('wps_orders_products.vendor_id',$vid);
    $this->db->order_by("wps_orders_products.order_id", "desc");
    $this->db->group_by('wps_orders_products.order_id');
    $r=$this->db->get()->result_array();
    return count($r);
}
public function get_cancel_order_by_vendor($perpage, $limit,  $vid)
{
    $this->db->select('wps_orders_products.*,wps_order.*');
    $this->db->from('wps_orders_products');
    $this->db->join('wps_order', 'wps_orders_products.order_id=wps_order.order_id');
    $this->db->where('wps_order.order_status','5');
    $this->db->where('wps_orders_products.vendor_id',$vid);
    $this->db->order_by("wps_orders_products.order_id", "desc");
    $this->db->group_by('wps_orders_products.order_id');

    $this->db->limit($perpage,$limit);
    $r=$this->db->get()->result_array();
    return $r;
}

// end of Cancel order

// delivered Order
public function get_count_delivered_order_by_vendor($vid)
{
     $this->db->select('wps_orders_products.*,wps_order.*');
    $this->db->from('wps_orders_products');
    $this->db->join('wps_order', 'wps_orders_products.order_id=wps_order.order_id');
    $this->db->where('wps_order.order_status','8');
    $this->db->where('wps_orders_products.vendor_id',$vid);
    $this->db->order_by("wps_orders_products.order_id", "desc");
    $this->db->group_by('wps_orders_products.order_id');
    $r=$this->db->get()->result_array();
    return count($r);
}
public function get_delivered_order_by_vendor($perpage, $limit,  $vid)
{
    $this->db->select('wps_orders_products.*,wps_order.*');
    $this->db->from('wps_orders_products');
    $this->db->join('wps_order', 'wps_orders_products.order_id=wps_order.order_id');
    $this->db->where('wps_order.order_status','8');
    $this->db->where('wps_orders_products.vendor_id',$vid);
    $this->db->order_by("wps_orders_products.order_id", "desc");
    $this->db->group_by('wps_orders_products.order_id');

    $this->db->limit($perpage,$limit);
    $r=$this->db->get()->result_array();
    return $r;
}

// end of delivered order


// processing Order
public function get_count_processing_order_by_vendor($vid)
{
     $this->db->select('wps_orders_products.*,wps_order.*');
    $this->db->from('wps_orders_products');
    $this->db->join('wps_order', 'wps_orders_products.order_id=wps_order.order_id');
    $this->db->where('wps_order.order_status','1');
    $this->db->where('wps_orders_products.vendor_id',$vid);
    $this->db->order_by("wps_orders_products.order_id", "desc");
    $this->db->group_by('wps_orders_products.order_id');
    $r=$this->db->get()->result_array();
    return count($r);
}
public function get_processing_order_by_vendor($perpage, $limit,  $vid)
{
    $this->db->select('wps_orders_products.*,wps_order.*');
    $this->db->from('wps_orders_products');
    $this->db->join('wps_order', 'wps_orders_products.order_id=wps_order.order_id');
    $this->db->where('wps_order.order_status','1');
    $this->db->where('wps_orders_products.vendor_id',$vid);
    $this->db->order_by("wps_orders_products.order_id", "desc");
    $this->db->group_by('wps_orders_products.order_id');

    $this->db->limit($perpage,$limit);
    $r=$this->db->get()->result_array();
    return $r;
}

// end of processing order



// filter by date Order
public function get_count_filter_by_date_order_by_vendor($vid)
{
     $this->db->select('wps_orders_products.*,wps_order.*');
    $this->db->from('wps_orders_products');
    $this->db->join('wps_order', 'wps_orders_products.order_id=wps_order.order_id');
    $this->db->where('wps_order.order_status','1');
    $this->db->where('wps_orders_products.vendor_id',$vid);
    $this->db->order_by("wps_orders_products.order_id", "desc");
    $this->db->group_by('wps_orders_products.order_id');
    $r=$this->db->get()->result_array();
    return count($r);
}
public function get_filter_by_date_order_by_vendor($perpage, $limit,  $vid)
{
    $this->db->select('wps_orders_products.*,wps_order.*');
    $this->db->from('wps_orders_products');
    $this->db->join('wps_order', 'wps_orders_products.order_id=wps_order.order_id');
    $this->db->where('wps_order.order_status','1');
    $this->db->where('wps_orders_products.vendor_id',$vid);
    $this->db->order_by("wps_orders_products.order_id", "desc");
    $this->db->group_by('wps_orders_products.order_id');

    $this->db->limit($perpage,$limit);
    $r=$this->db->get()->result_array();
    return $r;
}

// end of filter by date order

}
