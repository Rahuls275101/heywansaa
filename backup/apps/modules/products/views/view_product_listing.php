<?php
$this->load->view("top");
$QryStringArr = array();  // To store all Query Variables so to move to other view;
$QryStringArr = array_unique($QryStringArr);
if (isset($this->meta_info['entity_id']) && $this->meta_info['entity_id'] != '') {
  $QryStringArr['category_id'] = $this->meta_info['entity_id'];
}
if ($catid) {
  $QryStringArr['category_id'] = $catid;
}
if ($this->input->post('category_id')) {
  $QryStringArr['category_id'] = $this->input->post('category_id');
}

if ($this->input->get_post('keywordSearch') != '') {
  $QryStringArr['keywordSearch'] = $this->input->get_post('keywordSearch');
}

if ($this->input->get_post('sort') != '') {
  $QryStringArr['sort'] = $this->input->get_post('sort');
}
if ($this->input->get_post('color') != '') {
  $QryStringArr['color'] = implode(',', $this->input->get_post('color'));
}
if ($this->input->get_post('size') != '') {
  $QryStringArr['size'] = implode(',', $this->input->get_post('size'));
}

if ($this->input->get_post('price') != '') {
  $priceArr = explode('-', $this->input->get_post('price'));
  $minPrice = $priceArr[0];
  $maxPrice = $priceArr[1];
  $QryStringArr['price'] = $this->input->get_post('price');
  $range = 'Range: ₹'.$priceArr[0].' - ₹'.$priceArr[1];
} else {
  $range = 'Range: ₹1 - ₹10';
  $minPrice = 100;
  $maxPrice = 10000;
}

$type = $this->uri->segment(1);
if ($type > 0) {
  if ($type == 1) {
    $QryStringArr['type'] = $type;
  }
  if ($type == 2) {
    $QryStringArr['type'] = $type;
  }
  if ($type == 3) {
    $QryStringArr['type'] = $type;
  }
  if ($type == 4) {
    $QryStringArr['type'] = $type;
  }
}

$cat_res2 = $this->db->query("SELECT * FROM wps_categories WHERE status = '1' and parent_id = '0' order by sort_order asc ")->result_array();

?>


<style>
    .curcor-pointer{
        cursor:pointer;
    }
</style>


  <main class="main">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <?php  if($this->input->get_post('keywordSearch')){ ?>
                    <ul class="breadcrumb bb-no">
                        <h1 class="page-title mb-0">Search</h1>
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li>Search Result ( <?php echo $this->input->get_post('keywordSearch');  ?> ) </li>
                    </ul>
                    <?php } else{ ?>
                    <ul class="breadcrumb bb-no">
                        <h1 class="page-title mb-0">Shop</h1>
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li>Shop</li>
                    </ul>
                      <?php } ?>
                </div>
            </nav>
      
            <div class="page-content">
                <div class="container">
                    <!-- Start of Shop Content -->
                    <div class="shop-content row gutter-lg">
                        
                        <!-- Start of Sidebar, Shop Sidebar -->
                        <aside class="sidebar shop-sidebar sticky-sidebar-wrapper sidebar-fixed <?php if($this->input->get_post('keywordSearch')!=''){echo "d-none";} ?>" >

                            <nav class="toolbox">
                                <div class="">
                                    <a href="#" class="btn btn-primary btn-outline btn-rounded left-sidebar-toggle 
                                        btn-icon-left d-block d-lg-none"><i class="w-icon-category"></i><span>Filters</span></a>
                                    <div class="toolbox-item toolbox-sort select-box text-dark">
                                        <label>Sort By :</label>
                                        <select name="orderby" id="orderby" class="form-control filterDataform">
                                            <?php
                                            if(count($products)>0)
                                            {
                                            ?>
                                            <option value="0" selected="selected">Default sorting</option>
                                            <option value="1">Sort by pric: low to high</option>
                                            <option value="2">Sort by price: high to low</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </nav>
                            
                            <!-- Start of Sidebar Overlay -->
                            <div class="sidebar-overlay"></div>
                            <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
                            <!-- Start of Sidebar Content -->
                            <div class="sidebar-content scrollable" style="padding:0px;">
                                <!-- Start of Sticky Sidebar -->
                                <div class="sticky-sidebar">
                                    <div class="filter-actions">
                                        <label>Filter :</label>
                                        <a href="#" onclick="window.location.reload();" class="btn btn-dark btn-link filter-clean">Clean All</a>
                                    </div>
                                    <!-- Start of Collapsible widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>All Categories</label></h3>
                                        <ul class="widget-body filter-items search-ul">
                                            
                                            <?php
                                            // print_r($category_list);
                                            foreach($category_list as $cl=>$cat)
                                            {
                                            ?>
                                            <li><a href="<?php echo base_url().$cat->friendly_url; ?>"><?php echo $cat->category_name; ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <!-- End of Collapsible Widget -->
                                    <!-- Start of Collapsible Widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>Price</label></h3>
                                        <div class="widget-body">
                                            <ul class="filter-items search-ul">
                                                <li class="pt-2 curcor-pointer" onclick="$('#minPrice').val(0);  $('#maxPrice').val(100);   filterByPrice();"> ₹ 0.00 - ₹ 100.00</li>
                                                <li class="pt-2 curcor-pointer" onclick="$('#minPrice').val(100);$('#maxPrice').val(200);   filterByPrice();"> ₹ 100.00 - ₹ 200.00</li>
                                                <li class="pt-2 curcor-pointer" onclick="$('#minPrice').val(200);$('#maxPrice').val(300);   filterByPrice();"> ₹ 200.00 - ₹ 300.00</li>
                                                <li class="pt-2 curcor-pointer" onclick="$('#minPrice').val(300);$('#maxPrice').val(500);   filterByPrice();"> ₹ 300.00 - ₹ 500.00</li>
                                                <li class="pt-2 curcor-pointer" onclick="$('#minPrice').val(500);$('#maxPrice').val(50000000);  filterByPrice();">₹500.00+</li>
                                            </ul>
                                            <form class="price-range">
                                                <input type="number" id="minPrice" name="min_price" class="min_price text-center filterDataform" min='1' placeholder="₹min">
                                                <span class="delimiter">-</span>
                                                <input type="number" id="maxPrice" name="max_price" class="max_price text-center filterDataform" placeholder="₹max">
                                                <a href="#" class="btn btn-primary btn-rounded" id="price">Go</a>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- End of Collapsible Widget -->
                                     <!-- Start of Collapsible Widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>Brand List</label></h3>
                                        <ul class="widget-body filter-items item-check mt-1">
                                              <?php
                                              $check=array();
                                           $brand_list=   array_unique($brand_list);
                                            //  print_r($brand_list);
                                           foreach($brand_list as $brand)
                                           {
                                             if($brand!='')
                                             {
                                               
                                           ?>
                                           
                                            <li>
                                                <input class="form-check-input filterDataform" type="checkbox" value="<?php echo $brand; ?>" name="brand[]" id="brand" >
                                                <?php echo $brand; ?>
                                            </li>
                                    <?php } } ?>
                                        </ul>
                                    </div>
                                    <!-- End of Collapsible Widget -->
                                    <!-- Start of Collapsible Widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>Size</label></h3>
                                        <ul class="widget-body filter-items item-check mt-1">
                                           <?php
                                           $check=array();
                                           foreach($variant_details as $var)
                                           {
                                               for($i=0;$i<count($var);$i++)
                                           {
                                               $cll=$var[$i]->size_id;
                                               if(in_array($cll,$check))
                                               {
                                                   
                                               }
                                               else
                                               {
                                                   $check[]=$var[$i]->size_id; 
                                           ?>
                                            <li>
                                                <input class="form-check-input pt-2 filterDataform" type="checkbox" value="<?php echo $var[$i]->size_id; ?>" name="size[]" id="size" >
                                                <label class="form-check-label" for="ExtraLarge"> <?php echo  $var[$i]->size_id; ?></label></li>
                                    <?php } }}?>
                                        </ul>
                                    </div>
                                    <!-- End of Collapsible Widget -->
                                    <!-- Start of Collapsible Widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>Color</label></h3>
                                        <ul class="widget-body filter-items item-check mt-1">
                                              <?php
                                              $check=array();
                                              foreach($variant_details as $var)
                                              {
                                           for($i=0;$i<count($var);$i++)
                                           {
                                               $cll=$var[$i]->color_id;
                                               if(in_array($cll,$check))
                                               {
                                                   
                                               }
                                               else
                                               {
                                                   $check[]=$var[$i]->color_id; 
                                               
                                           ?>
                                           
                                            <li>
                                                <input class="form-check-input filterDataform" type="checkbox" value="<?php echo $var[$i]->color_id; ?>" name="color[]" id="color" >
                                                <span style='background-color:<?php echo $var[$i]->color_id; ?>; height:20px;wodth:40px;border:1px solid gray;position:relative'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                            
                                            </li>
                                    <?php }}} ?>
                                        </ul>
                                    </div>
                                    <!-- End of Collapsible Widget -->
                                </div>
                                <!-- End of Sidebar Content -->
                            </div>
                            <!-- End of Sidebar Content -->
                        </aside>
                        <!-- End of Shop Sidebar -->
                        <!-- Start of Shop Main Content -->
                        <div class="main-content">
                            
                            <div class="product-wrapper" id="all_product_list">
                                <div class="row">
                                
                                <?php foreach ($products as $key => $val) 
                                {
							        $productImage = get_db_field_value("wps_products_media", "media", "WHERE products_id = '" . $val['products_id'] . "' and is_default='Y'");
							
							?>
							<div class="col-lg-3 col-md-3 col-xs-6 mb-2">
                                <div class="product-wrap">
                                    <div class="product product-simple text-center">
                                        <figure class="product-media">
                                            <a href="<?=base_url($val['friendly_url']);?>">
                                                <img src="<?php echo get_image('products', $val['media'], 270, 270, 'AR'); ?>" alt="<?php echo imagealtTitle('', ucwords(strtolower($val['product_name'])), ''); ?>" title="<?php echo imagealtTitle('', ucwords(strtolower($val['product_name'])), ''); ?>" width="260" height="291" />
                                            </a>
                                            <!--<div class="product-action-vertical">-->
                                            <!--    <a href="#" class="btn-product-icon btn-wishlist w-icon-heart" title="Add to wishlist"></a>-->
                                            <!--</div>-->
                                        </figure>
                                        <div class="product-details">
                                            <h4 class="product-name"><a href="<?=base_url($val['friendly_url']);?>"> <?php $dd=$val['product_name']; echo substr($dd,0,77);?></a></h4>
                                            <div class="product-pa-wrapper">
                                                <div class="product-price">
                                                    <a  href="<?=base_url($val['friendly_url']);?>" class="new-price"><?=display_price($val['product_discounted_price']);?> </a>
                                                </div>
                                                <!--<div class="product-action">-->
                                                <!--    <a href="<?=base_url($val['friendly_url']);?>" class="btn-cart btn-product btn btn-icon-right btn-link btn-underline">Add-->
                                                <!--        To Cart</a>-->
                                                <!--</div>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <?php } ?>
                            </div>
                            <!--<div class="toolbox toolbox-pagination justify-content-between">-->
                            <!--    <ul class="pagination">-->
                            <!--        <li class="prev disabled">-->
                            <!--            <a href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">-->
                            <!--                <i class="w-icon-long-arrow-left"></i>Prev-->
                            <!--            </a>-->
                            <!--        </li>-->
                            <!--        <li class="page-item active">-->
                            <!--            <a class="page-link" href="#">1</a>-->
                            <!--        </li>-->
                            <!--        <li class="page-item">-->
                            <!--            <a class="page-link" href="#">2</a>-->
                            <!--        </li>-->
                            <!--        <li class="next">-->
                            <!--            <a href="#" aria-label="Next">-->
                            <!--                Next<i class="w-icon-long-arrow-right"></i>-->
                            <!--            </a>-->
                            <!--        </li>-->
                            <!--    </ul>-->
                            <!--</div>-->
                            </div>
                        </div>
                        <!-- End of Shop Main Content -->
                    </div>
                    <!-- End of Shop Content -->
                </div>
            </div>
            <!-- End of Page Content -->
        </main>






<?php $this->load->view("bottom"); ?>


 <script>
     $('.filterDataform').on('change',function()
     {
        var minPrice    = $('#minPrice').val();
        var maxPrice    = $('#maxPrice').val();
        var orderby = $('#orderby').val();
        var limit_per_page  = $('#limit_per_page').val();
       
        var brand       =   $('input[name^="brand"]').serializeArray();
        
        
       var color =  $('input[name^="color"]').serializeArray();
       var size  =  $('input[name^="size"]').serializeArray();
        
       $.ajax({
                url     :BASEURL +"data/filter",
                method  :"POST",
                data    :{
                            minPrice    :   minPrice,
                            maxPrice    :   maxPrice,
                            orderby     :   orderby,
                         limit_per_page :   limit_per_page,
                                color   :   color,
                                size    :   size,
                                brand   :   brand,
                                category:   '<?php echo end($this->uri->segment_array()); ?>',
                         
                        },
                success :function(res)
           {
               console.log(res);
               var data=JSON.parse(res);
               $('#all_product_list').html(data.product_div);
           }
       })




     })
 </script>

 <script>
   function filterByPrice()
     {
      var minPrice    = $('#minPrice').val();
        var maxPrice    = $('#maxPrice').val();
        var orderby = $('#orderby').val();
        var limit_per_page  = $('#limit_per_page').val();
        
        
       var color =  $('input[name^="color"]').serializeArray();
       var size  =  $('input[name^="size"]').serializeArray();
        
       $.ajax({
                url     :BASEURL +"data/filter",
                method  :"POST",
                data    :{
                            minPrice    :   minPrice,
                            maxPrice    :   maxPrice,
                            orderby     :   orderby,
                         limit_per_page :   limit_per_page,
                                color   :   color,
                                size    :   size,
                                category:   '<?php echo end($this->uri->segment_array()); ?>',
                         
                        },
                success :function(res)
           {
               console.log(res);
               var data=JSON.parse(res);
               $('#all_product_list').html(data.product_div);
           }
       })





     }
 </script>




	
