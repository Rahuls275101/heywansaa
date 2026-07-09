<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Meta_model extends MY_Model{

   public function __construct(){
     parent::__construct();
   }
   
	public function get_meta($offset=0,$per_page=10,$condtion='NULL'){
        $per_page="";
		$fetch_config = array(
							  'condition'=>$condtion,
							  'order'=>"meta_id DESC",
							  //'limit'=>$per_page,
							  'start'=>$offset,							 
							  'debug'=>FALSE,
							  'return_type'=>"array"							  
							  );
		$result = $this->findAll('wps_meta_tags',$fetch_config);
		return $result;	
	}
	
}
// model end here