<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Commanmodel;

class Ajaxlist extends Model
{
    protected $table = 'product';
    protected $column_order = array(null); // set column field database for datatable orderable
    protected $column_search = array('product_name'); // set column field database for datatable searchable
    protected $order = array('product_id' => 'DESC'); // default order

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        // OR $this->db = db_connect();
    }

    private function _get_datatables_query($id, $search, $collection, $minprice, $maxprice,$shortby,$catsearch)
    {
        $builder = $this->db->table($this->table);
 $builder->where('product_status', 'Active');
        if (!empty($id)) {
            $builder->where('product_category', $id);
        }
        
         if (!empty($catsearch)) {
            $builder->where('product_category', $catsearch);
        }

        if (!empty($collection)) {
            $builder->like('product_collections', $collection);
        }

        if (!empty($minprice) && !empty($maxprice)) {
            $builder->where('product_price >=', $minprice);
            $builder->where('product_price <=', $maxprice);
        }

        if (!empty($search)) {
            $builder->groupStart(); // Open bracket for complex query
            foreach ($this->column_search as $i => $item) {
                if ($i === 0) {
                    $builder->like($item, $search, 'both');
                } else {
                    $builder->orLike($item, $search, 'both');
                }
            }
            $builder->groupEnd(); // Close bracket
        }

        
     if ($shortby == 'newness') {
    $order = $this->order;
    $builder->orderBy(key($order), 'ASC');
} elseif ($shortby == 'pricelow') {
    $order = $this->order;
    $builder->orderBy('product_price', 'ASC');
}  elseif ($shortby == 'pricehigh') {
    $order = $this->order;
    $builder->orderBy('product_price', 'DESC');
} else {
    $order = $this->order;
    if (!empty($order)) {
        $builder->orderBy(key($order), $order[key($order)]);
    }
}

        
        
       

        return $builder;
    }

    public function count_all_frontend($id, $search, $collection, $minprice, $maxprice,$shortby,$catsearch)
    {
        $query = $this->_get_datatables_query($id, $search, $collection, $minprice, $maxprice,$shortby,$catsearch);
        $query = $query->get();
        return $query->getNumRows();
    }

    public function fetch_data($limit, $start, $id, $search, $collection, $minprice, $maxprice,$shortby,$catsearch)
    {
        $commanmodel = new Commanmodel();
        $query = $this->_get_datatables_query($id, $search, $collection, $minprice, $maxprice,$shortby,$catsearch);

        if ($limit != -1) {
            $query->limit($limit, $start);
        }
        $query = $query->get();

        $output = '';
        if ($query->getNumRows() > 0) {
            foreach ($query->getResult() as $resultsrow) {
               $pro_variant = $commanmodel->all_multiple_query_order_by('pro_variant',array('variant_pro_id' => $resultsrow->product_id),'pro_variant_id','ASC');
                    
                     $variant =  ($pro_variant)?$pro_variant[0]->varian:'';

                 $variant_yes =  ($pro_variant)?'Yes':'No';


                $output .= ' <div class="col-6 col-md-4 col-lg-3 col-xl-3">
                            <div class="product-default inner-quickview inner-icon">
                                <figure>
                                    <a href="' . base_url('/product/') . '/' . $resultsrow->slug . '">
                                        <img src="' . base_url('/assets/images') . '/' . $resultsrow->product_thumbnail . '" width="217" height="217" alt="' . $resultsrow->product_name . '">
                                    </a>
                                    <div class="btn-icon-group">
                                            <a href="javascript:void(0);"
                                                class="btn-icon  AddToCart" data-product-id="'. $resultsrow->product_id.'" data-variant ="'.$variant.'" data-qty="'.$resultsrow->quantity.'" data-variant-yes="'.$variant_yes.'">
                                                   <i class="icon-shopping-cart"></i></a>
                                        </div>
                                    <a href="' . base_url('/product/') . '/' . $resultsrow->slug . '" class="btn-quickview" title="View">Quick
                                        View</a>
                                </figure>
                                <div class="product-details">
                                    <div class="category-wrap">
                                        <div class="category-list">
                                            <a href="#" class="product-category">category</a>
                                        </div>
                                        <a href="javascript:void(0);" title="Wishlist" class="btn-icon-wish wishlistadd" data-product_id="'. $resultsrow->product_id.'"><i class="icon-heart"></i></a>
                                    </div>
                                    <h3 class="product-title">
                                        <a href="' . base_url('/product/') . '/' . $resultsrow->slug . '">' . $resultsrow->product_name . '</a>
                                    </h3>
                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:'.$commanmodel->product_rating($resultsrow->product_id)['rating_percentage'].'%"></span><!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div><!-- End .product-ratings -->
                                    </div><!-- End .product-container -->
                                    <div class="price-box">
                                       <span class="old-price">'.$resultsrow->product_max_price.'</span>
                                            <span class="product-price">'.$resultsrow->product_price.'</span>
                                    </div><!-- End .price-box -->
                                </div><!-- End .product-details -->
                            </div>
                        </div>';
            }
        } else {
            $output = '<div class="col-md-12 col-xl-12 mb-3 mb-md-4 pb-1" style="text-align: center;"> <h3>No result found!</h3></div>';
        }

        return $output;
    }
}
