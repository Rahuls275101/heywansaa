<?php

class Misc_model extends CI_Model {


    public function gettodaydelscount()
    {
        $query="select wps_products.*,wps_products_media.media from wps_products inner join wps_products_media on wps_products_media.products_id=wps_products.products_id where wps_products.todays_deal='1' and status ='1' group by wps_products.products_id";
        $r=$this->db->query($query)->result_array();
        return count($r);
    }
    
    public function gettodaydels_rows($perpage=null,$limit=null)
    {
        $query="select wps_products.*,wps_products_media.media from wps_products inner join wps_products_media on wps_products_media.products_id=wps_products.products_id where wps_products.todays_deal='1' and status ='1' group by wps_products.products_id limit $limit,$perpage";
        $r=$this->db->query($query)->result_array();
        return $r;
    }
       public function gettodaydelscountby_category($cat_id)
    {
        $query="select wps_products.*,wps_products_media.media from wps_products inner join wps_products_media on wps_products_media.products_id=wps_products.products_id where wps_products.todays_deal='1' and status ='1' and wps_products.products_id='$cat_id' group by wps_products.products_id";
        $r=$this->db->query($query)->result_array();
        return count($r);
    }
    
    public function gettodaydels_rows_by_category($perpage=null,$limit=null,$cat_id)
    {
        $query="select wps_products.*,wps_products_media.media from wps_products inner join wps_products_media on wps_products_media.products_id=wps_products.products_id where wps_products.todays_deal='1' and status ='1' and wps_products.category_id=$cat_id group by wps_products.products_id limit $limit,$perpage";
        $r=$this->db->query($query)->result_array();
        return $r;
    }
    
    public function get_category_list()
    {
         $query="SELECT * FROM wps_categories where status='1'";
        $r=$this->db->query($query)->result_array();
        return $r;
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



}



