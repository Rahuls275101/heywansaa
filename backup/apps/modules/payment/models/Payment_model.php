<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends MY_Model {
    
    
    
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
    
    public function get_order_product_list($field,$join)
        {
          if($r=$this->db->query($field.$join))
          {
              return $r->result_array();
          }
          else
          {
              return false;
          }
        }
	
	/**
	 * Get account by id
	 *
	 * @access public
	 * @param string $account_id
	 * @return object account object
	 */
	 	
	

	
	
	
}
/* End of file member_model.php */
/* Location: ./application/modules/cart/models/cart_model.php */