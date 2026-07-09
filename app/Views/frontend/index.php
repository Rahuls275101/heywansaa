
<?php 
use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();
  $category = $commanmodel->all_multiple_query_order_by('category',array('parent_id' => 0),'category_id','ASC');
?>
  



  <!--<div id="disclaimerPopup" class="disclaimer-popup">
    <div class="disclaimer-content">
      <h4> Privacy Policy Disclaimer</h4>
      
      <p>  Our legal adviser has developed this Privacy Policy and this is for showing our organization’s 
      commitment to helping our clients understand what kind of information we gather and 
      how we use it.  
      Visit our website: <a href="https://www.heywansaa.com" target="_blank">www.heywansaa.com</a>. </p>
      <div class="disclaimer-buttons">
        <button id="acceptBtn">ACCEPT</button>
      </div>
    </div>
  </div>-->



            
     
        <main class="main">
            <!--<section class="intro-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 mb-2">
                            <div class="banner banner1 d-flex flex-wrap align-items-center bg-gray no-gutters">
                                <div class="col-md-5 appear-animate" data-animation-name="fadeInRightShorter"
                                    data-animation-delay="200">
                                       <?php $about15= $commanmodel->get_single_query('cms_pages',array('cms_id' => 15)); ?>
                                    <h3 class="ls-n-20 text-body text-uppercase m-b-2"><?php echo $about15->cms_page_heading; ?></h3>
                                  <?php echo $about15->cms_page_description; ?>
                                    <a href="<?php echo $about15->cms_page_small_description; ?>" class="btn btn-dark btn-lg m-b-5">View Sale</a>
                                </div>
                                <div class="col-md-7">
                                    <figure>
                                        <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $about15->cms_image	; ?>" alt="banner"
                                            width="700" height="576">
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                                <?php $about16= $commanmodel->get_single_query('cms_pages',array('cms_id' => 16)); ?>
                            <div class="banner banner2 h-100"
                                style="background: #414141 no-repeat center/cover url(<?php echo base_url('assets/images/'); ?>/<?php echo $about16->cms_image	; ?>)">
                                <div
                                    class="banner-layer d-flex flex-column justify-content-center align-items-end text-right">
                                    <h3 class="font-weight-bold ls-n-20 text-primary text-uppercase m-b-2 appear-animate"
                                        data-animation-name="fadeInUpShorter" data-animation-delay="100"><?php echo $about16->cms_page_heading; ?>
                                    </h3>
                                    <?php echo $about16->cms_page_description; ?>
                                    <a href="<?php echo $about16->cms_page_small_description; ?>" class="btn btn-light btn-lg appear-animate"
                                        data-animation-name="fadeInUpShorter" data-animation-delay="600">View Sale</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>-->



            <section class="newsletter-section appear-animate" data-animation-name="fadeInUpShorter"
                data-animation-delay="200">
                <div class="container">
                    <div class="widget-newsletter">
                        <div class="row no-gutters m-0">
                            <div class="col-md-5">
                                <div class="info-box info-box-icon-left justify-content-start align-itmes-center">
                                    <i class="far fa-envelope line-height-1 text-primary"></i>
                                    <div class="info-content">
                                        <h4 class="line-height-1 text-dark">Get Special Offers and Savings</h4>
                                        <p class="font2 text-body">Get all the latest information on Events, Sales and
                                            Offers.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <form class="newsletter-form" id="newsletterForm" >
                                    <input type="email" id="email" class="form-control font2 mb-0"
                                        placeholder="Enter Your E-mail Address..." required>

                                    <button type="submit" class="btn btn-submit text-white">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>




            <section class="popular-section">
                <div class="container">
                    <div class="appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="400">
                        <h2 class="section-title pb-3 m-b-4">Top Rated Product</h2>

                        <div class="row m-b-2">
                            
                            <?php foreach($productfirst as $productfirstrow) { 
                            
                              $pro_variant = $commanmodel->all_multiple_query_order_by('pro_variant',array('variant_pro_id' => $productfirstrow->product_id),'pro_variant_id','ASC');
                    
                     $variant =  ($pro_variant)?$pro_variant[0]->varian:'';

                 $variant_yes =  ($pro_variant)?'Yes':'No';

                            ?>
                            <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                                <div class="product-default inner-quickview inner-icon">
                                    <figure>
                                        <a href="<?php echo base_url('product'); ?>/<?php echo $productfirstrow->slug; ?>">
                                            <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $productfirstrow->product_thumbnail; ?>" width="217"
                                                height="217" alt="<?php echo $productfirstrow->product_name; ?>">
                                        </a>
                                        <div class="label-group">
                                            <div class="product-label label-sale"></div>
                                        </div>
                                        <div class="btn-icon-group">
                                            <a href="#" 
                                                class="btn-icon AddToCart" data-product-id="<?php echo $productfirstrow->product_id; ?>" data-variant ="<?php echo $variant; ?>" data-qty="<?php echo $productfirstrow->quantity; ?>" data-variant-yes="<?php echo $variant_yes; ?>"><i
                                                    class="icon-shopping-cart"></i></a>
                                        </div>
                                        <a href="<?php echo base_url('product'); ?>/<?php echo $productfirstrow->slug; ?>" class="btn-quickview"
                                            title="Quick View">
                                            View</a>
                                    </figure>
                                    <div class="product-details">
                                        <div class="category-wrap">
                                            <div class="category-list">
                                                <a href="#" class="product-category">category</a>
                                            </div>
                                            <a href="#" title="Wishlist" class="btn-icon-wish  wishlistadd" data-product_id="<?php echo $productfirstrow->product_id; ?>"><i
                                                    class="icon-heart"></i></a>
                                        </div>
                                        <h3 class="product-title">
                                            <a href="#"><?php echo $productfirstrow->product_name; ?></a>
                                        </h3>
                                        <div class="ratings-container">
                                            <div class="product-ratings">
                                                <span class="ratings" style="width:<?php echo $commanmodel->product_rating($productfirstrow->product_id)['rating_percentage']; ?>%"></span><!-- End .ratings -->
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div><!-- End .product-ratings -->
                                        </div><!-- End .product-container -->
                                        <div class="price-box">
                                            <span class="old-price"><?php echo $productfirstrow->product_max_price; ?></span>
                                            <span class="product-price"><?php echo $productfirstrow->product_price; ?></span>
                                        </div><!-- End .price-box -->
                                    </div><!-- End .product-details -->
                                </div>
                            </div>
                            <?php } ?>
                            
                            
                           
                           
                        </div>
                    </div>


                 

                    <!-- end -->

                    <div class="tagcloud d-flex flex-wrap justify-content-between bg-gray mb-4 appear-animate"
                        data-animation-name="fadeInUpShorter" data-animation-delay="600">
                        
                           <?php foreach($category as $categoryrow) { ?>
                                            <a href="<?php echo base_url('catalog/'); ?>/<?php echo $categoryrow->url_slug; ?>"><?php echo $categoryrow->category_name; ?></a>
                                            <?php } ?>
                      
                    </div>
                </div>
            </section>



<section class="video-background">
    <video autoplay muted loop>
        <source src="<?php echo base_url('assets/frontend/'); ?>/assets/video/categey-bg-vdo.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="content">
        <a href="<?php echo base_url('catalog/all'); ?>" ><img src="<?php echo base_url('assets/frontend/'); ?>/assets/images/hey-wansaa-banner.png" alt="Porto Logo" class="center-image"></a>
    </div>
</section>

        <!-- <section class="">
  

   
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <img src="assets/images/hey-wansaa-banner.png" alt="Porto Logo" class="center-image">
                    </div>
                </div>
            </div>
        </section> -->

            <div class="products-container bg-gray mt-1">
                <div class="container">
                    <h2 class="section-title pb-3 m-b-4">Recommended For You</h2>
                    <div class="row custom-products no-gutters appear-animate" data-animation-name="fadeInUpShorter"
                        data-animation-delay="200">
                       
                           <?php foreach($productsecond as $productfirstrow) {    
                              $pro_variant = $commanmodel->all_multiple_query_order_by('pro_variant',array('variant_pro_id' => $productfirstrow->product_id),'pro_variant_id','ASC');
                    
                     $variant =  ($pro_variant)?$pro_variant[0]->varian:'';

                 $variant_yes =  ($pro_variant)?'Yes':'No';

                            ?>
                                                     <div class="col-sm-6 col-md-4">
                              <div class="product-default inner-icon inner-quickview">
                                    <figure>
                                        <a href="<?php echo base_url('product'); ?>/<?php echo $productfirstrow->slug; ?>">
                                            <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $productfirstrow->product_thumbnail; ?>" width="217"
                                                height="217" alt="<?php echo $productfirstrow->product_name; ?>">
                                        </a>
                                        <div class="label-group">
                                            <div class="product-label label-sale"></div>
                                        </div>
                                        <div class="btn-icon-group">
                                            <a href="#" 
                                                class="btn-icon AddToCart" data-product-id="<?php echo $productfirstrow->product_id; ?>" data-variant ="<?php echo $variant; ?>" data-qty="<?php echo $productfirstrow->quantity; ?>" data-variant-yes="<?php echo $variant_yes; ?>"><i
                                                    class="icon-shopping-cart"></i></a>
                                        </div>
                                        <a href="<?php echo base_url('product'); ?>/<?php echo $productfirstrow->slug; ?>" class="btn-quickview"
                                            title="Quick View">
                                            View</a>
                                    </figure>
                                    <div class="product-details">
                                        <div class="category-wrap">
                                            <div class="category-list">
                                                <a href="#" class="product-category">category</a>
                                            </div>
                                            <a href="#" title="Wishlist" class="btn-icon-wish  wishlistadd" data-product_id="<?php echo $productfirstrow->product_id; ?>"><i
                                                    class="icon-heart"></i></a>
                                        </div>
                                        <h3 class="product-title">
                                            <a href="#"><?php echo $productfirstrow->product_name; ?></a>
                                        </h3>
                                        <div class="ratings-container">
                                            <div class="product-ratings">
                                                <span class="ratings" style="width:<?php echo $commanmodel->product_rating($productfirstrow->product_id)['rating_percentage']; ?>%"></span><!-- End .ratings -->
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div><!-- End .product-ratings -->
                                        </div><!-- End .product-container -->
                                        <div class="price-box">
                                            <span class="old-price"><?php echo $productfirstrow->product_max_price; ?></span>
                                            <span class="product-price"><?php echo $productfirstrow->product_price; ?></span>
                                        </div><!-- End .price-box -->
                                    </div><!-- End .product-details -->
                                </div>
                            </div>
                          
                            <?php } ?>
                     
                    </div>
                </div>
            </div>


            <section class="sale-banner m-t-3 appear-animate animated fadeIn appear-animation-visible" style="animation-duration: 1000ms;">
                <div class="banner" style="background-color: #ffab8c;">
                      <?php $about17= $commanmodel->get_single_query('cms_pages',array('cms_id' => 17)); ?>
                    <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $about17->cms_image	; ?>" width="1120" height="380" style="background-color: #fca383;" alt="banner">
                    <div class="banner-layer banner-layer-middle banner-layer-left">
                 
                                  
                    
                        <h5 class="font-weight-normal m-b-3 font3 text-left"> <?php echo $about17->cms_page_heading; ?></h5>
                        <h4 class="mb-0 text-left text-uppercase text-white-diff"><?php echo $about17->cms_page_small_description; ?></h4>
                       
                    </div>
                </div>
            </section>

            <section class="top-sellers-section appear-animate" data-animation-name="fadeIn" data-animation-delay="200">
                <div class="container">
                    
                    
                    <?php $about19= $commanmodel->get_single_query('cms_pages',array('cms_id' => 19)); ?>
                    
                    <div class="banner banner3 d-flex flex-wrap align-items-center"
                        style="background: #dc7a1f no-repeat center/cover url(<?php echo base_url('assets/images/'); ?>/<?php echo $about19->cms_image	; ?>)">
                        <div class="col-lg-9 mb-2 mb-lg-0">
                            <h2 class="d-inline-block ls-n-20 text-white text-uppercase mb-0"><span class="sale-off"><?php echo $about19->cms_page_heading; ?></span> 
                           <?php echo $about19->cms_page_description; ?></h2>
                         
                        </div>
                        <div class="col-lg-3 text-lg-right">
                            <a href="<?php echo $about19->cms_page_small_description; ?>" class="btn btn-light btn-lg">View Sale</a>
                        </div>
                    </div>

                    <h2 class="section-title pb-3 m-b-4">Featured Products</h2>

                    <div class="row">
                        
                                  
                            <?php foreach($productthird as $productfirstrow) {  
                            $pro_variant = $commanmodel->all_multiple_query_order_by('pro_variant',array('variant_pro_id' => $productfirstrow->product_id),'pro_variant_id','ASC');
                    
                     $variant =  ($pro_variant)?$pro_variant[0]->varian:'';

                 $variant_yes =  ($pro_variant)?'Yes':'No';

                            ?>
                           <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                                <div class="product-default inner-quickview inner-icon">
                                    <figure>
                                        <a href="<?php echo base_url('product'); ?>/<?php echo $productfirstrow->slug; ?>">
                                            <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $productfirstrow->product_thumbnail; ?>" width="217"
                                                height="217" alt="<?php echo $productfirstrow->product_name; ?>">
                                        </a>
                                        <div class="label-group">
                                            <div class="product-label label-sale"></div>
                                        </div>
                                        <div class="btn-icon-group">
                                            <a href="#" 
                                                class="btn-icon AddToCart" data-product-id="<?php echo $productfirstrow->product_id; ?>" data-variant ="<?php echo $variant; ?>" data-qty="<?php echo $productfirstrow->quantity; ?>" data-variant-yes="<?php echo $variant_yes; ?>"><i
                                                    class="icon-shopping-cart"></i></a>
                                        </div>
                                        <a href="<?php echo base_url('product'); ?>/<?php echo $productfirstrow->slug; ?>" class="btn-quickview"
                                            title="Quick View">
                                            View</a>
                                    </figure>
                                    <div class="product-details">
                                        <div class="category-wrap">
                                            <div class="category-list">
                                                <a href="#" class="product-category">category</a>
                                            </div>
                                            <a href="#" title="Wishlist" class="btn-icon-wish  wishlistadd" data-product_id="<?php echo $productfirstrow->product_id; ?>"><i
                                                    class="icon-heart"></i></a>
                                        </div>
                                        <h3 class="product-title">
                                            <a href="#"><?php echo $productfirstrow->product_name; ?></a>
                                        </h3>
                                        <div class="ratings-container">
                                            <div class="product-ratings">
                                                <span class="ratings" style="width:<?php echo $commanmodel->product_rating($productfirstrow->product_id)['rating_percentage']; ?>%"></span><!-- End .ratings -->
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div><!-- End .product-ratings -->
                                        </div><!-- End .product-container -->
                                        <div class="price-box">
                                            <span class="old-price"><?php echo $productfirstrow->product_max_price; ?></span>
                                            <span class="product-price"><?php echo $productfirstrow->product_price; ?></span>
                                        </div><!-- End .price-box -->
                                    </div><!-- End .product-details -->
                                </div>
                            </div>
                           
                            <?php } ?>
                       
                    </div>
                </div>
            </section>

            <section class="info-boxes-container appear-animate" data-animation-name="fadeIn"
                data-animation-delay="200">
                <div class="container">
                    <div class="row">
                        <div class="info-boxes-slider owl-carousel owl-theme" data-owl-options="{
                            'responsive': {
                                '576': {
                                    'items': 2
                                },
                                '992': {
                                    'items': 3
                                }
                            }
                        }">
                            <div class="info-box info-box-icon-left">
                                <i class="icon-shipping text-primary"></i>
                                <div class="info-box-content">
                                    <h4 class="line-height-1">Free Shipping on Orders Over ₹ 99</h4>
                                    <!-- <p class="font2 line-height-1 text-body ">For more than 100,000 parts!</p> -->
                                </div>
                            </div>

                            <div class="info-box info-box-icon-left">
                                <i class="icon-money text-primary"></i>
                                <div class="info-box-content">
                                    <h4 class="line-height-1">Up to 40% OFF on Selected Items</h4>
                                    <!-- <p class="font2 line-height-1 text-body ">Available for all Categories!</p> -->
                                </div>
                            </div>

                            <div class="info-box info-box-icon-left">
                                <i class="icon-secure-payment text-primary"></i>
                                <div class="info-box-content">
                                    <h4 class="line-height-1">100% Secure Payments</h4>
                                    <!-- <p class="font2 line-height-1 text-body ">We ensure secure payment!</p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="brands-section">
                <div class="container">
                    <h2 class="section-title pb-3 mb-4">Brands We Trust</h2>

                    <div class="brands-slider owl-carousel owl-theme mb-4 appear-animate" data-owl-options="{
                        'margin': 0
                    }" data-animation-name="fadeIn" data-animation-delay="400">
                        <a href="#"><img src="<?php echo base_url('assets/frontend/'); ?>/assets/images/brands/small/brand1.png" alt="brand" width="140"
                                height="60"></a>
                        <a href="#"><img src="<?php echo base_url('assets/frontend/'); ?>/assets/images/brands/small/brand2.png" alt="brand" width="140"
                                height="60"></a>
                        <a href="#"><img src="<?php echo base_url('assets/frontend/'); ?>/assets/images/brands/small/brand3.png" alt="brand" width="140"
                                height="60"></a>
                        <a href="#"><img src="<?php echo base_url('assets/frontend/'); ?>/assets/images/brands/small/brand4.png" alt="brand" width="140"
                                height="60"></a>
                        <a href="#"><img src="<?php echo base_url('assets/frontend/'); ?>/assets/images/brands/small/brand5.png" alt="brand" width="140"
                                height="60"></a>
                        <a href="#"><img src="<?php echo base_url('assets/frontend/'); ?>/assets/images/brands/small/brand6.png" alt="brand" width="140"
                                height="60"></a>
                    </div>
                </div>
            </section>


 
           <!-- <section class="sale-banner m-t-3 appear-animate animated fadeIn appear-animation-visible" style="animation-duration: 1000ms;">
                <div class="banner" style="background-color: #ffab8c;">
                    <?php $about18= $commanmodel->get_single_query('cms_pages',array('cms_id' => 18)); ?>
                    <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $about18->cms_image	; ?>" width="1120" height="380" style="background-color: #fca383;" alt="banner">
                    <div class="banner-layer banner-layer-middle banner-layer-left">
                 
                                  
                    
                        <h5 class="font-weight-normal m-b-3 font3 text-left"> <?php echo $about18->cms_page_heading; ?></h5>
                        <h4 class="mb-0 text-left text-uppercase text-white-diff"><?php echo $about18->cms_page_small_description; ?></h4>
                       
                    </div>
                </div>
            </section>
        </main>  -->
        
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



<!-- jQuery AJAX code for form submission -->
<script>
    // Trigger when the newsletter subscription form is submitted
    $("#newsletterForm").submit(function(event){
        event.preventDefault();  // Prevent form from submitting the traditional way

        // Get the email value
        var email = $("#email").val();

        $.ajax({
            url: "<?php echo base_url('newsletter/signup'); ?>",  // URL for your signup method
            method: "POST",
            data: { email: email },
            dataType: "json",  // Expecting JSON response
            success: function(response){
                // Handle the response with SweetAlert
                if(response.success){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.success
                    });
                } else if(response.failed) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        html: response.failed  // Show HTML content from the failed response
                    });
                }
            },
            error: function(xhr, status, error){
                // Handle AJAX errors with SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Something went wrong!',
                    text: 'Please try again later.'
                });
            }
        });
    });
</script>
