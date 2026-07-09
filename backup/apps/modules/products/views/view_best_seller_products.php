<?php
$this->load->view("top");
$QryStringArr = array();  // To store all Query Variables so to move to other view;
$QryStringArr = array_unique($QryStringArr);
if (isset($this->meta_info['entity_id']) && $this->meta_info['entity_id'] != '') {
  $QryStringArr['category_id'] = $this->meta_info['entity_id'];
}
// if ($catid) {
//   $QryStringArr['category_id'] = $catid;
// }
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
    .page-header {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  height: 15rem;
  background-color: #eee;
  text-align: center;
  text-transform: capitalize;
  margin-bottom: 20px;
  background: linear-gradient(-45deg, rgb(245 245 245 / 58%), rgb(245 245 245 / 65%)) fixed, url(<?php echo base_url(); ?>assets/designer/themes/default/assets/images/banner-bg.jpg) fixed;
  background-size: cover;

}
</style>


  <main class="main">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb bb-no">
                        <h1 class="page-title mb-0"><?php echo $title; ?></h1>
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li>Shop</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->
            <!-- Start of Page Header -->
            <!--<div class="page-banner">-->
            <!--    <img src="<?php echo base_url(); ?>assets/designer/themes/default/assets/images/banner-bg.jpg" alt="">-->
            <!--    <div class="page-header">-->
            <!--    <div class="container">-->
            <!--        <h1 class="page-title mb-0"><?php echo $title; ?></h1>-->
            <!--    </div>-->
            <!--</div>-->
            <!--</div>-->
            <!-- End of Page Header -->
            <!-- Start of Page Content -->
            <div class="page-content">
                <div class="container">
                    <!-- Start of Shop Content -->
                    <div class="shop-content row gutter-lg mb-10">
                        <!-- Start of Sidebar, Shop Sidebar -->
            
                        <div class="main-content">
                            
                            	<div class="product-wrapper row" id="all_product_list">
                                
                                <?php foreach ($products as $key => $val) 
                                {
							        $productImage = get_db_field_value("wps_products_media", "media", "WHERE products_id = '" . $val['products_id'] . "' and is_default='Y'");
							
							?>
						
    							<div class="col-lg-2 col-md-3 col-sm-6">
                                    <div class="product-wrap">
                                        <div class="product product-simple text-center">
                                            <figure class="product-media">
                                                <a href="<?=base_url($val['friendly_url']);?>">
                                                    <img src="<?php echo get_image('products', $val['media'], 270, 270, 'AR'); ?>" alt="<?php echo imagealtTitle('', ucwords(strtolower($val['product_name'])), ''); ?>" title="<?php echo imagealtTitle('', ucwords(strtolower($val['product_name'])), ''); ?>" width="260" height="291" />
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name"><a href="<?=base_url($val['friendly_url']);?>"> <?php $dd=$val['product_name']; echo substr($dd,0,77);?></a></h4>
                                                <div class="product-pa-wrapper">
                                                    <div class="product-price">
                                                        <a href="<?=base_url($val['friendly_url']);?>" class="new-price"><?=display_price($val['product_discounted_price']);?> </a>
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
                                category:   '<?php echo $this->uri->segment(2); ?>',
                         
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
                                category:   '<?php echo $this->uri->segment(2); ?>',
                         
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




	
