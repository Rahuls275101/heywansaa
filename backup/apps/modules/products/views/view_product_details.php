<?php
$this->load->view('top');
$mediaRes = $media_res;
$overall_rating_product = product_overall_rating($res['products_id'], 'product'); 
//print_r($res);
$cat_res = get_db_single_row('wps_categories', '*', " category_id='$res[category_id]'");
$sz = explode(',', $res['size_ids']);
if($res['color_ids']!='' && $res['color_ids']>0){
$cl = explode(',', $res['color_ids']);
}else{
  $cl = '';
 //print_r($cat_res['category_type']);
}

$cart_array = $this->cart->contents();
$insert_flag = 0;
if (is_array($cart_array) && !empty($cart_array)) {
  foreach ($this->cart->contents() as $item) {
    if (array_key_exists('pid', $item)) {
      if ($item['pid'] == $res['products_id']) {
        $insert_flag = 1;
      }
    }
  }
}


// print_r($related);die;


?>

<script src="<?php echo base_url().'assets/developer/js/jquery.js'; ?>"></script>
<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->


<script>
     const base_url='<?php  echo base_url(); ?>';
</script>		



<style>
    .ratesetmsg{
        padding:5px;
        color:#fff;
        background-color:goldenrod;
    }
</style>






 <?php
                    $products_id=$res['products_id'];
                    $review_data    =   $this->db->query("select * from rating_review where product_id='$products_id'")->result_array();
                    $avegare_rating=0;
                    $total_score=0;
                    
                    foreach($review_data as $rvd=>$drv)
                    {
                        $total_score=$total_score+$drv['rating_star'];
                    }
                    $count_of_review=count($review_data);
                    if($count_of_review>0)
                    {
                        $avegare_rating=$total_score/$count_of_review;
                    }
					
					
	
if($avegare_rating >=5){
$percntg = 100;
} else if($avegare_rating < 5 && $avegare_rating >=4){

$percntg = 80;

} else if($avegare_rating < 4 && $avegare_rating >=3){

$percntg = 60;

} else if($avegare_rating < 3 && $avegare_rating >=2){

$percntg = 40;

} else if($avegare_rating < 2 && $avegare_rating >=1){

$percntg = 20;
} else {

$percntg = 0;
}
					

 ?>







 <!-- Start of Main -->
        <main class="main mb-10 pb-1">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                <ul class="breadcrumb bb-no">
                    <h1 class="page-title mb-0">Products Detail</h1>
                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li>Products Detail</li>
                </ul>
                </div>
                <span id="alertmsg"></span>
                <!--<ul class="product-nav list-style-none">-->
                <!--    <li class="product-nav-prev">-->
                <!--        <a href="#">-->
                <!--            <i class="w-icon-angle-left"></i>-->
                <!--        </a>-->
                <!--        <span class="product-nav-popup">-->
                <!--            <img src="<?php echo DESIGN_URL; ?>assets/images/products/product-nav-prev.jpg" alt="Product" width="110" height="110" />-->
                <!--            <span class="product-name">Soft Sound Maker</span>-->
                <!--        </span>-->
                <!--    </li>-->
                <!--    <li class="product-nav-next">-->
                <!--        <a href="#">-->
                <!--            <i class="w-icon-angle-right"></i>-->
                <!--        </a>-->
                <!--        <span class="product-nav-popup">-->
                <!--            <img src="<?php echo DESIGN_URL; ?>assets/images/products/product-nav-next.jpg" alt="Product" width="110" height="110" />-->
                <!--            <span class="product-name">Fabulous Sound Speaker</span>-->
                <!--        </span>-->
                <!--    </li>-->
                <!--</ul>-->
            </nav>
            <!-- End of Breadcrumb -->
            <!-- Start of Page Content -->
<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="main-content">
                <div class="product product-single row">
                    <div class="col-md-4 mb-6">
                        <div class="product-gallery product-gallery-sticky">
                            <div class="swiper-container product-single-swiper swiper-theme nav-inner" data-swiper-options="{
                                'navigation': {
                                    'nextEl': '.swiper-button-next',
                                    'prevEl': '.swiper-button-prev'
                                }
                            }">
                                <div class="swiper-wrapper row cols-1 gutter-no" id="bigimageslider">

                                	<?php
                                    // big image
                                	foreach($mediaRes as $medi=>$media)
                                	{ 
                                	?>

                                    <div class="swiper-slide">
                                        <figure class="product-image">
                                            <img src="<?php echo base_url().'uploaded-files/products/'.$media['media']; ?>" data-zoom-image="<?php echo base_url().'uploaded-files/thumb-cache/'.$media['media']; ?>" alt="Electronics Black Wrist Watch" width="800" height="900">
                                        </figure>
                                    </div>
                                    

                                <?php } ?>


                                </div>
                                <button class="swiper-button-next"></button>
                                <button class="swiper-button-prev"></button>
                                <a href="<?php echo site_url('cart/add_to_wishlist/' . $res['products_id']); ?>" class="wishlist-btn"><i class="w-icon-heart"></i></a>
                            </div>
                            <div class="product-thumbs-wrap swiper-container" data-swiper-options="{
                                'navigation': {
                                    'nextEl': '.swiper-button-next',
                                    'prevEl': '.swiper-button-prev'
                                }
                            }">
                                <div class="product-thumbs swiper-wrapper row cols-4 gutter-sm" id="smallthumbnail" style="height: 100px;width: 100px;">
                                   <?php

                                	foreach($mediaRes as $medi=>$media)
                                	{ 
                                	?> 
                                    <div class="product-thumb swiper-slide">
                                        <img src="<?php echo base_url().'uploaded-files/products/'.$media['media']; ?>" alt="Product Thumb" width="800" height="900">
                                    </div>
                                     <?php } ?>
                                   
                                </div>
                                <button class="swiper-button-next"></button>
                                <button class="swiper-button-prev"></button>
                            </div>
                            <!-- Add to cart site_url('cart/add_to_cart'), 'id="cart_form"' -->
                           
                            <div class="left-fix mt-4" id="cartSection">
                                <?php echo form_open('','id="cart_form"'); ?>
                                <input type="hidden" name="products_id" id="product_id" value="<?php echo $res['products_id']; ?>">                              
                                <button type="button" id="addtocartButton"  class="btn btn-dark btn-cart-sticky">
                                    <i class="w-icon-cart"></i>
                                    <span>Add to Cart</span>
                                </button>
                                <button class="btn btn-dark btn-cart-sticky" id="buynowfromcartButton" type="button">
                                    <i class="fa fa-shopping-basket"></i>
                                    <span>Buy Now</span>
                                </button>
                                <?php echo form_close(); ?>
                            </div>
                           
                        </div>
                    </div>
                    <div class="col-md-8 mb-4 mb-md-6">
                        <div class="product-details" data-sticky-options="{'minWidth': 767}">
                            <h1 class="product-title"><?=$res['product_name']?></h1>
                            <hr class="product-divider">
                            <div class="product-price">
                                <ins class="new-price" id="topPrice">
                                    Rs. <?=$res['product_discounted_price']?>      
									<?php if($res['product_discounted_price']!=0) { 
									echo "<strike>".$res['product_price']."</strike>"; 
									} else {
									
									echo $res['product_price'];
									} 
									?>  
                                </ins>
                            </div>
                            <div class="ratings-container">
                                <div class="ratings-full">
                                    <span class="ratings" style="width: <?php echo $percntg; ?>%;"></span>
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <a href="#product-tab-reviews" class="rating-reviews scroll-to">(<?php echo $count_of_review; ?> Reviews)</a>
                            </div>
                            <div class="product-short-desc">
                                <?php //echo $res['short_desc']?>
                            </div>
                            <hr class="product-divider">
              <?php   
              // color start
              if($colors){ 
                ?>              
                            <div class="product-form product-variation-form product-color-swatch">
                               <!-- <label>Color:</label>-->
            <div class="d-flex align-items-center product-variations" id="color_var">

              


                <!-- size and colorBy ID -->

 <input  class="color" type="hidden" name="color_var_name_for_size" id="color_var_name_for_size" value="none">
 <input   class="size"type="hidden" name="size_var_name_for_color" id="size_var_name_for_color">





                <?php
                foreach($colors as $color)
                {
                    $code_for_id=str_replace("#","",$color->color_id);
					
					if($code_for_id!="none")
					{
                ?>
                <a href="#"  data-id="<?php echo $color->color_id; ?>" class="color" id="colorCode<?php echo $code_for_id; ?>"  style="background-color: <?php echo $color->color_id; ?>; border:#E9E9E9 solid 1px;"></a>&nbsp;&nbsp;        


            <script type="text/javascript">
                $('#colorCode<?php echo $code_for_id; ?>').on('click',function(){
                $('#color_var_name_for_size').val('<?php echo $color->color_id; ?>'); //SET VALUE
                    
                    var size_code       =   $('#size_var_name_for_color').val();
                    var color_code      =   $('#color_var_name_for_size').val();
                   
                   
                    var var_id= '<?php echo $color->id; ?>';

                     
                  
                    //  var prod_id= $(this).getAttribute("data-values"); 
                   
                      changeGallery(color_code,var_id);
                      get_variant();  //cal get variant
                   
                });
            </script>

           



            <?php }} ?>
            </div>














                            </div>

            <?php   
              // color end
              }
                ?>

                 <?php   
              // size start
              if($variant){ 
                ?>    
                            <div class="product-form product-variation-form product-size-swatch">
                                <!-- <label class="mb-1">Size:</label>-->
                                <div class="flex-wrap d-flex align-items-center product-variations" id="size_var">

                            <?php
                                foreach($sizes as $color)
                                {
                            ?>
                            <a href="#"  data-index="<?php echo $color->size_id; ?>" class="size" ><?php echo $color->size_id; ?></a>
                                    <?php 
                                }
                                ?>
                                    <script>
                                        $(".size").click(function(){
                                            var size=$(this).data("index");
                                            $('#size_var_name_for_color').val(size);

                                            get_variant();  //cal get variant


                                        })
                                        </script>











                                </div>
                                <a href="" onclick="window.location.reload()" class="product-variation-clean">Clean All</a>
                            </div>





                     <?php } ?>       







                            <!-- <div class="product-variation-price">
                                <span></span>
                            </div> -->
                            <div class="fix-bottom desktop-fix-bottom" >
                                <div class="product-form">
                                    <!--<div class="product-qty-form">-->
                                    <!--    <div class="input-group">-->
                                    <!--        <input class="quantity form-control" type="number" min="1" max="100">-->
                                    <!--        <button class="quantity-plus w-icon-plus"></button>-->
                                    <!--        <button class="quantity-minus w-icon-minus"></button>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <!--<button class="btn btn-primary btn-cart mr-2">-->
                                    <!--    <i class="w-icon-cart"></i>-->
                                    <!--    <span>Add to Cart</span>-->
                                    <!--</button>-->
                                    <!--<button class="btn btn-primary btn-cart mr-2">-->
                                    <!--    <i class="fa fa-shopping-basket"></i>-->
                                    <!--    <span>Buy Now</span>-->
                                    <!--</button>-->
                                    <!-- <button class="btn btn-primary btn-cart">
                                        <i class="w-icon-heart"></i>
                                        <span>Add to Wishlist</span>
                                    </button> -->
                                </div>
                            </div>
                            <!--<div class="social-links-wrapper">-->
                            <!--    <div class="social-links">-->
                            <!--        <div class="social-icons social-no-color border-thin">-->
                            <!--            <a href="#" class="social-icon social-facebook w-icon-facebook"></a>-->
                            <!--            <a href="#" class="social-icon social-twitter w-icon-twitter"></a>-->
                            <!--            <a href="#" class="social-icon social-pinterest fab fa-pinterest-p"></a>-->
                            <!--            <a href="#" class="social-icon social-whatsapp fab fa-whatsapp"></a>-->
                            <!--            <a href="#" class="social-icon social-youtube fab fa-linkedin-in"></a>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <div class="product-bm-wrapper mt-3">
                                <div class="product-meta">
                                    <div class="product-categories">
                                        Category:
                                        <span class="product-category"><a href="#"><?php echo get_catebory_name_by_cat_id($res['category_id']); ?></a></span>
                                    </div>
                                    <div class="product-sku">
                                        SKU: <span><?=$res['product_code']?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Area -->
                        <div class="tab tab-nav-boxed tab-nav-underline product-tabs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a href="#product-tab-description" class="nav-link active">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#product-tab-specification" class="nav-link">Specification</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="#product-tab-vendor" class="nav-link">Vendor Info</a>
                                </li> -->
                                <li class="nav-item">
                                    <a href="#product-tab-reviews" class="nav-link">Reviews</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="product-tab-description">
                                    <div class="row mb-4">
                                        <div class="col-md-12 mb-5">
                                           <?=$res['products_description']?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="product-tab-specification">
                                    <?php echo $res['specification']; ?>
                                </div>
                                
                                
                                
                   
                                
                                <div class="tab-pane" id="product-tab-reviews">
                                    <div class="row mb-4">
                                        <div class="col-xl-4 col-lg-5 mb-4">
                                            <div class="ratings-wrapper">
                                                 
                                               
                                                <div class="ratings-list">
                                                    <?php
                                                        $this->db->where('product_id',$res['products_id']);
                                                        $this->db->where('rating_star','5');
                                                        $review_data    =   $this->db->get('rating_review')->result_array();
                                                    ?>
                                                    
                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: 100%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-sm ">
                                                            <span></span>
                                                        </div>
                                                        <div class="progress-value">
                                                            <mark><?php   print_r(count($review_data)); ?> Reviews</mark>
                                                        </div>
                                                    </div>
                                                    
                                                     <?php
                                                        $this->db->where('product_id',$res['products_id']);
                                                        $this->db->where('rating_star','4');
                                                        $review_data    =   $this->db->get('rating_review')->result_array();
                                                    ?>
                                                    
                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: 80%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-sm ">
                                                            <span></span>
                                                        </div>
                                                        <div class="progress-value">
                                                            <mark><?php   print_r(count($review_data)); ?> Reviews</mark>
                                                        </div>
                                                    </div>
                                                    
                                                    <?php
                                                        $this->db->where('product_id',$res['products_id']);
                                                        $this->db->where('rating_star','3');
                                                        $review_data    =   $this->db->get('rating_review')->result_array();
                                                    ?>
                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: 60%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-sm ">
                                                            <span></span>
                                                        </div>
                                                        <div class="progress-value">
                                                            <mark><?php   print_r(count($review_data)); ?> Reviews</mark>
                                                        </div>
                                                    </div>
                                                    
                                                    <?php
                                                        $this->db->where('product_id',$res['products_id']);
                                                        $this->db->where('rating_star','2');
                                                        $review_data    =   $this->db->get('rating_review')->result_array();
                                                    ?>
                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: 40%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-sm ">
                                                            <span></span>
                                                        </div>
                                                        <div class="progress-value">
                                                            <mark><?php   print_r(count($review_data)); ?> Reviews</mark>
                                                        </div>
                                                    </div>
                                                    
                                                    <?php
                                                        $this->db->where('product_id',$res['products_id']);
                                                        $this->db->where('rating_star','1');
                                                        $review_data    =   $this->db->get('rating_review')->result_array();
                                                    ?>
                                                    <div class="ratings-container">
                                                        <div class="ratings-full">
                                                            <span class="ratings" style="width: 20%;"></span>
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-sm ">
                                                            <span></span>
                                                        </div>
                                                        <div class="progress-value">
                                                            <mark><?php   print_r(count($review_data)); ?> Reviews</mark>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                        <div class="col-xl-8 col-lg-7">
                                            <div class="review-form-wrapper">
                                                <h4 class="tab-pane-title font-weight-bold mb-1">Submit Your
                                                    Review</h4>
                                                <p class="mb-3">Your email address will not be published. Required
                                                    fields are marked *</p>
                                                <form action="<?php echo base_url().'members/reviewrate'; ?>" method="POST" class="review-form">
                                                    <div class="rating-form">
                                                        <label for="rating">Your Rating Of This Product :</label>
                                                        
                                                        <span class="rating-stars">
                                                            <a class="star-1" href="#">1</a>
                                                            <a class="star-2" href="#">2</a>
                                                            <a class="star-3" href="#">3</a>
                                                            <a class="star-4" href="#">4</a>
                                                            <a class="star-5" href="#">5</a>
                                                        </span>
                                                        <select name="rating" id="rating" required="" style="display: none;">
                                                            <option value="">Rate…</option>
                                                            <option value="5">Perfect</option>
                                                            <option value="4">Good</option>
                                                            <option value="3">Average</option>
                                                            <option value="2">Not that bad</option>
                                                            <option value="1">Very poor</option>
                                                        </select>
                                                    </div>
                                                    <div id="ratesetmsg"></div>
                                                    <textarea cols="30" rows="6" name="review" placeholder="Write Your Review Here..." class="form-control" id="review"></textarea>
                                                    <div class="row gutter-md">
                                                        <div class="col-md-6">
                                                            <input type="text" name="username" class="form-control" placeholder="Your Name" id="author">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="email" class="form-control" placeholder="Your Email" id="email_1">
                                                        </div>
                                                    </div>
                                                    <button type="button" id="btn-review-submit" class="btn btn-dark">Submit Reviews</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab tab-nav-boxed tab-nav-outline tab-nav-center">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="show-all">
                                                <ul class="comments list-style-none">
                                                   
                                                   <?php 
                                                    //  $this->load->database();
                                                    //  $this->load->model('member/members_model');
                                                    // $where  =   array('product_id'=> $res['products_id']);
                                                    
                                                    $this->db->where('product_id',$res['products_id']);
                                                    $review_data    =   $this->db->get('rating_review')->result_array();
                                                    // print_r($review_data);
                                                    foreach($review_data as $rv=>$rvd)
                                                    {
                                                   ?>
                                                   
                                                    <li class="comment">
                                                        <div class="comment-body">
                                                            <div class="comment-content">
                                                                <h4 class="comment-author">
                                                                    <a href="#"><?php echo $rvd['username']; ?></a><br>
                                                                    <span class="comment-date"><?php echo date('F d, Y',strtotime($rvd['created_at'])); ?></span>
                                                                </h4>
                                                                <div class="ratings-container comment-rating">
                                                                    <div class="ratings-full">
                                                                        <span class="ratings" style="width: <?php echo round($rvd['rating_star']*100/5); ?>%;"></span>
                                                                        <span class="tooltiptext tooltip-top"></span>
                                                                    </div>
                                                                </div>
                                                                <p><?php echo $rvd['review_text']; ?></p>
                                                                    
                                                            </div>
                                                            
                                                        </div>
                                                    </li>
                                                    <?php } ?>
                                                    
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <section class="related-product-section">
                    <div class="title-link-wrapper mb-4 text-center">
                        <h4 class="title">Related Products</h4>
                        <!-- <a href="#" class="btn btn-dark btn-link btn-slide-right btn-icon-right">More
                            Products<i class="w-icon-long-arrow-right"></i></a> -->
                    </div>
                    <div class="swiper product-related-swiper">
                        <div class="swiper-wrapper">
                            
                        	<?php
                        	foreach($related as $relat=>$rel)
                        	{
                        	     $name=$rel['product_name'];
                                if (strlen($name) > 20)
                                {
                                    $name = substr($name, 0, 20) . '...'; 
                                }
                        	?>

                            <div class="swiper-slide">
                                <div class="product-wrap">
                                    <div class="product text-center">
                                        <figure class="product-media">
                                            <a href="<?php echo $rel['friendly_url']; ?>">
                                                <img src="<?php echo base_url().'uploaded-files/products/'.$rel['media']; ?>" alt="Product" width="300" height="338">
                                            </a>


                                            <!--<div class="product-action-vertical">-->
                                            <!--    <a href="<?php echo $rel['friendly_url']; ?>" class="btn-product-icon btn-cart w-icon-cart" title="Add to cart"></a>-->
                                            <!--    <a href="<?php echo $rel['friendly_url']; ?>" class="btn-product-icon btn-wishlist w-icon-heart" title="Add to wishlist"></a>-->
                                            <!--</div>-->


                                        </figure>
                                        <div class="product-details">
                                            <h4 class="product-name"><a href="<?php echo $rel['friendly_url']; ?>"><?php echo $name; ?></a></h4>
                                            <div class="product-price">
                                                <span class="price">₹  <?php echo $rel['product_discounted_price']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        <?php } ?>

                        </div>
                        <!-- <div class="swiper-pagination"></div> -->
                        <div class="product-swiper-nav swiper-button-next"></div>
                        <div class="product-swiper-nav swiper-button-prev"></div>
                    </div>
                </section>
 
 
 
                        
                           
                           
                           
                           
                <section class="related-product-section">
                    <div class="title-link-wrapper mb-4 text-center">
                        <h4 class="title">Recently Viewed</h4> 
                    </div>
                    <div class="swiper product-related-swiper">
                        <div class="swiper-wrapper">
                           
                           
                          
                            <?php
                                    $recent_data=array();
                                    $recent_data=$this->session->userdata('recent_data');
                                      if(is_array($recent_data))
                                      {
                                         for($i=0;$i<count($recent_data);$i++)
                                         {
                                           
                                            $name=$recent_data[$i]['product_name'];
                                            if (strlen($name) > 20)
                                            {
                                                $name = substr($name, 0, 20) . '...'; 
                                            }
                                            
                                            if(isset($recent_data[$i]['product_discounted_price']))
                                            {
                                    ?>
   
                           
                            <div class="swiper-slide">
                                <div class="product-wrap">
                                    <div class="product text-center">
                                        <figure class="product-media">
                                            <a href="<?php echo base_url().$recent_data[$i]['friendly_url']; ?>">
                                                <img src="<?php echo base_url().'uploaded-files/products/'.$recent_data[$i]['media']; ?>" alt="Product" width="300" height="338">
                                            </a>
                                        </figure>
                                        <div class="product-details">
                                            <h4 class="product-name"><a href="<?php echo base_url().$recent_data[$i]['friendly_url']; ?>"><?php echo ucwords($name); ?></a></h4>
                                            <div class="product-price">
                                                <span class="price">₹  <?php echo $recent_data[$i]['product_discounted_price']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        <?php }} } ?>    
                            
                            
                            
                        </div>
                        <!-- <div class="swiper-pagination"></div> -->
                        <div class="product-swiper-nav swiper-button-next"></div>
                        <div class="product-swiper-nav swiper-button-prev"></div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
            <!-- End of Page Content -->
        </main>
        <!-- End of Main -->














<!-- SCRIPT FOR GET VARIANT AFTER CLICK  -->
<script type="text/javascript">
function get_variant()
{
    var color=$('#color_var_name_for_size').val();
    var size=$('#size_var_name_for_color').val();

    if(color=='' && size=='')
    {
        console.log("Color and Size both are empty!!!")
        return false;
    }
    else if(color=='' && size!='')
    {
        // only image come if created
        console.log('Also select the size');
        return false;
    }
    else if(color!='' && size!='')
    {
  

        var site_url='<?php  echo base_url()."products/get_variant_by_size_color_productid"; ?>';
        $.ajax({
            type:"post",
            url:site_url,
            data:({color:color,size:size,product_id:'<?php echo $res['products_id']; ?>'}),
            success:function(res)
            {
                res= JSON.parse(res);
                if((res.variant).length > 0)
                {
                     $('#cartSection').removeClass(" d-none");
                    // console.log(res.variant[0]['discounted_price']);
                   var  final_total = Number(res.variant[0]['discounted_price']).toFixed(2); 
                    $('#topPrice').text(' Rs. '+final_total);
                }
                else
                {
                    $('#cartSection').addClass(" d-none");
                    $('#topPrice').text(' This Variant Not Available ');
                    return false;
                }
                
            }
        })
    }
    else
    {
        return false;
    }
}
</script>
<script type="text/javascript">
        $('#addtocartButton').on('click',function(){
             var product_id  =   $('#product_id').val();
             var color_id    =   $('#color_var_name_for_size').val();
             var size_id     =   $('#size_var_name_for_color').val();
             var cart_url    =  '<?php echo base_url("cart/add_to_cart");?>';

            if(product_id!='' && color_id!='' && size_id!='' && cart_url!='')
            {
                $.ajax({
                    type:"POST",
                    url:cart_url,
                    data:({ product_id:product_id, color_id:color_id, size_id:size_id,}),
                    success:function(res)
                    {
                        var result    =   JSON.parse(res);
                         console.log(result);
                        if(result.data=='added')
                        {
                            // var cartcount=parseInt($('.cart-count').text());
                            // $('.cart-count').text(cartcount+1)
                            
                            $.ajax({
                                url:'<?php echo base_url().'cart/countheadcount'; ?>',
                                method:'post',
                                success:function(res)
                                {
                                    $('.cart-count').text(res)
                                }
                            })
                            
                            
                            
                        }
                        //   alert(result.msg);
                       
                    }
                })
            }
            else
            {
                alert("Please Select Varriant");
            }

           })
        
</script>


<!--buy now-->
<script type="text/javascript">
        $('#buynowfromcartButton').on('click',function(){
             var product_id  =   $('#product_id').val();
             var color_id    =   $('#color_var_name_for_size').val();
             var size_id     =   $('#size_var_name_for_color').val();
             var cart_url    =  '<?php echo base_url("cart/add_to_cart");?>';

            if(product_id!='' && color_id!='' && size_id!='' && cart_url!='')
            {
                $.ajax({
                    type:"POST",
                    url:cart_url,
                    data:({ product_id:product_id, color_id:color_id, size_id:size_id,}),
                    success:function(res)
                    {
                        var result    =   JSON.parse(res);
                         console.log(result);
                        if(result.data=='added')
                        {
                            // var cartcount=parseInt($('.cart-count').text());
                            // $('.cart-count').text(cartcount+1)
                            
                            $.ajax({
                                url:'<?php echo base_url().'cart/countheadcount'; ?>',
                                method:'post',
                                success:function(res)
                                {
                                    $('.cart-count').text(res);
                                    window.location.href='<?php echo base_url().'cart/checkout'; ?>';
                                }
                            })
                            
                         
                        //   alert(result.msg);
                       
                    }
                    else if(result.data=='already-exist')
                    {
                           $("#alertmsg").html("<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Indicates a successful or positive action.</div>");
                            
                        }
                    }
                })
            }
            else
            {
                alert("Please Select Varriant");
            }

           })
        
</script>
 <!--change gallery from color data-->
            
<script>
function changeGallery(colorcode,var_id)
{
    $.ajax({
        url:base_url+'variant/color/code/image/gallery',
        method:"post",
        data:{color:colorcode,var_id:var_id},
        success:function(res){
          
            var data=JSON.parse(res);
              console.log(data);
            if(data.status=='datafound')
            {
              $('#bigimageslider').html(data.big_image);
              $('#smallthumbnail').html(data.small_img);
              $(window).trigger('resize');

            }
            else
            {
                // alert("Color Not Available");
                // window.location.reload();
            }
            
            
            

            
        }
    })  
}
                    
               
</script>

<!-- END SCRIPT FOR GET VARIANT AFTER CLICK  -->



<script>
    $('#btn-review-submit').on('click',function(){
        var rating      =   $('select[name="rating"]').val();
        var review      =   $('textarea[name="review"]').val();
        var username    =   $('input[name="username"]').val();
        var email       =   $('input[name="email"]').val();
        var prod_slug   =   '<?php echo $this->uri->segment('1') ?>';
        var product_id  =   $('#product_id').val();
        if( !isValidEmailAddress( email ) ) 
        {
             $('#ratesetmsg').html("<div class='ratesetmsg'>Wrong email Address</div>");
             return false;
        }

        
        $.ajax({
            url:site_url +'reviewrate',
            method:"POST",
            data:{rating:rating,review:review,username:username,email:email,prod_slug:prod_slug,product_id:product_id},
            success:function(res){
                
                var data=JSON.parse(res);
                $('#ratesetmsg').html(data.rating_msg);
                if(data.errorcode==200)
                {
                    
                    $('select[name="rating"]').val('');
                    $('textarea[name="review"]').val('');
                    $('input[name="username"]').val('');
                    $('input[name="email"]').val('');
                    
                    $('.rating-stars').removeClass('active');
                    $('.star-1').removeClass('active');
                    $('.star-2').removeClass('active');
                    $('.star-3').removeClass('active');
                    $('.star-4').removeClass('active');
                    $('.star-5').removeClass('active');
                    
                    
                }
            }
        })
    })
    
    function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
};
</script>    
    
    
    <?php
$this->load->view('bottom');

?>