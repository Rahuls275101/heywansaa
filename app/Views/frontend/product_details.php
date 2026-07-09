<?php 

use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();
 
 $product_image = $commanmodel->all_multiple_query_order_by('product_image',array('product_image_product_id'=> $product->product_id),'product_image_id','ASC');
$related = $commanmodel->all_multiple_query_order_by_limit('product',array('product_status' => 'Active','product_category' => $product->product_category,'product_id !=' => $product->product_id),'product_id','DESC',10);      
 $pro_group = $commanmodel->all_multiple_query_order_by('pro_group',array('pro_group_pro_id' => $product->product_id),'pro_group_id','ASC');
 
 
 $pro_variant = $commanmodel->all_multiple_query_order_by('pro_variant',array('variant_pro_id' => $product->product_id),'pro_variant_id','ASC');
 
        
        
     $pricearray =  array();
      $imagesarray =  array();
      $availablearray =  array();
     
     foreach($pro_variant as $variant) {
     $pricearray[$variant->varian] = $variant->pro_variant_price;
      $imagesarray[$variant->varian] = $variant->pro_variant_image;
       $availablearray[$variant->varian] = $variant->pro_variant_available;
     }
     
     $pricearrayJson = json_encode($pricearray);
      $imagesarrayJson = json_encode($imagesarray);
       $availablearrayJson = json_encode($availablearray);
  
                  
?>

 <main class="main">
            <div class="container">
                <nav aria-label="breadcrumb" class="breadcrumb-nav">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">Products</a></li>
                    </ol>
                </nav>

                <div class="product-single-container product-single-default">
                    <div class="cart-message d-none">
                        <strong class="single-cart-notice"><?php echo $product->product_name; ?></strong>
                        <span>has been added to your cart.</span>
                    </div>

                    <div class="row">
                        <div class="col-lg-5 col-md-6 product-single-gallery">
                            <div class="product-slider-container">
                                <div class="label-group">
                                   <!-- <div class="product-label label-hot">HOT</div>

                                    <div class="product-label label-sale">
                                        -16%
                                    </div>-->
                                </div>

                                <div class="product-single-carousel owl-carousel owl-theme show-nav-hover">
                                    <div class="product-item">
                                        <img class="product-single-image imagevariant"
                                        src="<?php echo base_url('assets/images/'); ?>/<?php echo $product->product_thumbnail; ?>"
                                            data-zoom-image="<?php echo base_url('assets/images/'); ?>/<?php echo $product->product_thumbnail; ?>" width="468"
                                            height="400" alt="product" />
                                    </div>
                                    <?php foreach($product_image as $imagerow){ ?>
                                    <div class="product-item">
                                        <img class="product-single-image"
                                            src="<?php echo base_url('assets/images/'); ?>/<?php echo $imagerow->product_image_url; ?>"
                                            data-zoom-image="<?php echo base_url('assets/images/'); ?>/<?php echo $imagerow->product_image_url; ?>" width="468"
                                            height="400" alt="product" />
                                    </div>
                                    <?php } ?>
                                   
                                   
                                </div>
                                <!-- End .product-single-carousel -->
                                <span class="prod-full-screen">
                                    <i class="icon-plus"></i>
                                </span>
                            </div>

                            <div class="prod-thumbnail owl-dots">
                                <div class="owl-dot">
                                    <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $product->product_thumbnail; ?>" width="110" height="110"
                                        alt="product-thumbnail" />
                                </div>
                                
                                  <?php foreach($product_image as $imagerow){ ?>
                                  
                                     <div class="owl-dot">
                                    <img src="<?php echo base_url('assets/images/'); ?>/<?php echo $imagerow->product_image_url; ?>" width="110" height="110"
                                        alt="product-thumbnail" />
                                </div>
                                    <?php } ?>
                               
                               
                            </div>
                        </div><!-- End .product-single-gallery -->

                        <div class="col-lg-7 col-md-6 product-single-details">
                            <h1 class="product-title"><?php echo $product->product_name; ?></h1>


                            <div class="ratings-container">
                                <div class="product-ratings">
                                    
                                    <span class="ratings" style="width:<?php echo $commanmodel->product_rating($product->product_id)['rating_percentage']; ?>%"></span><!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top"></span>
                                </div><!-- End .product-ratings -->

                                <a href="#" class="rating-link">( <?php echo $commanmodel->product_rating($product->product_id)['review_count']; ?> Reviews )</a>
                            </div><!-- End .ratings-container -->

                            <hr class="short-divider">

                            <div class="price-box">
                                <span class="old-price">₹<?php echo $product->product_max_price; ?></span>
                                <span class="new-price variantPrice">₹<?php echo $product->product_price; ?></span>
                            </div><!-- End .price-box -->

                            <div class="product-desc">
                                <p>
                                  <?php echo $product->product_overview; ?>
                                </p>
                            </div><!-- End .product-desc -->
                            
                         

 <?php if($pro_group) { ?> 
 
       <div class="product-filters-container">
            <?php    foreach($pro_group as $pro_grouprow) { ?>
                                <div class="product-single-filter"><label class="font2"><?php echo $pro_grouprow->pro_group_name; ?>:</label>
                                    <ul class="config-size-list config-color-list config-filter-list">
                                            <?php
                        $pro_item = $commanmodel->all_multiple_query_order_by('pro_item',array('pro_item_group_id' => $pro_grouprow->pro_group_id),'pro_item_id','ASC'); 
                       $pr = 1;
                        foreach($pro_item as $pro_itemrow) { ?>
                                        <li class="<?php echo ($pr == 1)? 'active':''; ?> selectedVariant " data-arraykey="<?php echo $pro_grouprow->pro_group_name; ?>"  data-name="<?php echo $commanmodel->get_variant_name($pro_itemrow->pro_item_name); ?>" >
                                             <?php echo $commanmodel->get_variant_tab($pro_itemrow->pro_item_name); ?>
                                        </li>
                                        <?php $pr++; } ?>
                                     
                                    </ul>
                                </div>
                                <?php   } ?>

                                <div class="product-single-filter">
                                    <label></label>
                                    <a class="font1 text-uppercase clear-btn" href="#">Clear</a>
                                </div>
                                <!---->
                            </div>
 
 <?php } ?>

                            <div class="product-action">
                                <div class="product-single-qty">
                                    <input class="horizontal-quantity form-control" id="qty" type="text">
                                </div><!-- End .product-single-qty -->

                                <a href="javascript:void(0);" class="btn btn-dark mr-2 AddToCart" id="addcartvalues" data-product-id="<?php echo $product->product_id; ?>" data-variant ="" data-qty="<?php echo $product->quantity; ?>" data-variant-yes="<?php echo ($pro_variant)?'Yes':'No'; ?>"  title="Add to Cart">Add to
                                    Cart</a>
                                    <a href="#" class="btn btn-dark mr-2 BuyNow"  title="Add to Cart" id="buyNowvalues"  data-product-id="<?php echo $product->product_id; ?>" data-variant ="" data-qty="<?php echo $product->quantity; ?>" data-variant-yes="<?php echo ($pro_variant)?'Yes':'No'; ?>">Buy Now</a>

                                <a href="#" class="btn btn-dark mr-2 wishlistadd"  data-product_id="<?php echo $product->product_id; ?>">Add Wishlist</a>
                            </div><!-- End .product-action -->

                            <hr class="divider mb-0 mt-0">
  <div class="product-single-tabs pt-0 pb-0">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="product-tab-desc" data-toggle="tab"
                                href="#product-desc-content" role="tab" aria-controls="product-desc-content"
                                aria-selected="true">Description</a>
                        </li>

                       
                        <li class="nav-item">
                            <a class="nav-link" id="product-tab-tags" data-toggle="tab" href="#product-tags-content"
                                role="tab" aria-controls="product-tags-content" aria-selected="false">Additional
                                Information</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="product-tab-reviews" data-toggle="tab"
                                href="#product-reviews-content" role="tab" aria-controls="product-reviews-content"
                                aria-selected="false">Reviews (1)</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel"
                            aria-labelledby="product-tab-desc">
                            <div class="product-desc-content">
                             <?php echo $product->product_description; ?>
                            </div><!-- End .product-desc-content -->
                        </div><!-- End .tab-pane -->


                        <div class="tab-pane fade" id="product-tags-content" role="tabpanel"
                            aria-labelledby="product-tab-tags">
                            
                            <?php echo $product->additional_information; ?>
                        </div><!-- End .tab-pane -->

                        <div class="tab-pane fade" id="product-reviews-content" role="tabpanel"
                            aria-labelledby="product-tab-reviews">
                            <div class="product-reviews-content">
                                
                              

                                <div class="add-product-review">
                                    <h3 class="review-title">Add a review</h3>

                                    <form id="reviewForm" class="comment-form m-0">
                                        <div class="rating-form">
                                            <label for="rating">Your rating <span class="required">*</span></label>
                                            <span class="rating-stars selected">
                                                <a class="star-1" href="#">1</a>
                                                <a class="star-2" href="#">2</a>
                                                <a class="star-3" href="#">3</a>
                                                <a class="star-4" href="#">4</a>
                                                <a class="star-5 active" href="#">5</a>
                                            </span>

                                            <select name="rating" id="rating" required="" style="display: none;">
                                              
                                                <option value="5" selected>Perfect</option>
                                                <option value="4">Good</option>
                                                <option value="3">Average</option>
                                                <option value="2">Not that bad</option>
                                                <option value="1" >Very poor</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Your review <span class="required">*</span></label>
                                            <textarea cols="3" rows="3" name="review_message" class="form-control form-control-sm"></textarea>
                                        </div><!-- End .form-group -->


                                        <div class="row">
                                            <div class="col-md-6 col-xl-6">
                                                <div class="form-group">
                                                    <label>Name <span class="required">*</span></label>
                                                    <input type="text" name="review_user_name" class="form-control form-control-sm" required>
                                                     <input type="hidden" name="review_product_id" value="<?php echo $product->product_id; ?>" required>
                                                </div><!-- End .form-group -->
                                            </div>

                                            <div class="col-md-6 col-xl-6">
                                                <div class="form-group">
                                                    <label>Email <span class="required">*</span></label>
                                                    <input type="text" name="review_user_email" class="form-control form-control-sm" required>
                                                </div><!-- End .form-group -->
                                            </div>

                                            <div class="col-md-12">
                                                <div class=" custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="save-name" />
                                                    <label class="custom-control-label mb-0" for="save-name">Save my
                                                        name, email, and website in this browser for the next time I
                                                        comment.</label>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="submit" class="btn btn-primary" value="Submit">
                                    </form>
                                </div><!-- End .add-product-review -->
                                
                                 <div class="divider"></div>
                                  <div class="comment-list">
                                  
                                  <?php echo $commanmodel->product_rating($product->product_id)['reviews_list']; ?>
                                      
                                      
                                      
                                    
                                </div>

                               
                                
                                
                                
                            </div><!-- End .product-reviews-content -->
                        </div><!-- End .tab-pane -->
                    </div><!-- End .tab-content -->
                </div><!-- End .product-single-tabs -->
                          
                        </div><!-- End .product-single-details -->
                    </div><!-- End .row -->
                </div><!-- End .product-single-container -->

              
  <h2 class="section-title pb-3 m-b-4">Related Products</h2>
                <div class="row">
         
                    
                     <?php foreach($related as $productfirstrow) {   $pro_variant = $commanmodel->all_multiple_query_order_by('pro_variant',array('variant_pro_id' => $productfirstrow->product_id),'pro_variant_id','ASC');
                    
                     $variant =  ($pro_variant)?$pro_variant[0]->varian:'';

                 $variant_yes =  ($pro_variant)?'Yes':'No';

                            ?>
                            <div class="col-5 col-md-4 col-lg-3 col-xl-2">
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
            </div><!-- End .container -->
        </main><!-- End .main -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>    
    
    
    
    <script>
    // Handle form submission with AJAX
    $('#reviewForm').on('submit', function(event) {
        event.preventDefault(); // Prevent form from submitting the traditional way
        
        // Prepare the data to send via AJAX
        var formData = $(this).serialize();  // Serialize the form data

        // Perform AJAX request
        $.ajax({
            url: '<?php echo base_url("review-submit"); ?>', // Change the URL based on your actual route
            type: 'POST',
            data: formData,
            dataType: 'json',  // Expect a JSON response
            success: function(response) {
                // If the response is successful, show SweetAlert with the appropriate message
                if (response.alert_class === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: response.alert_title,
                        text: response.alert_message,
                    }).then(function() {
                        // Optionally, redirect or reload the page after the alert
                       	$("#reviewForm")[0].reset();
                    });
                }
                // Handle validation or error alerts
                else if (response.alert_class === 'warning' || response.alert_class === 'danger') {
                    
                    let errorMessages = '';
                    // Loop through the validation errors and create a message string
                    for (let field in response.validation_errors) {
                        errorMessages += `<strong>${field}:</strong> ${response.validation_errors[field]}<br>`;
                    }
                    Swal.fire({
                        icon: response.alert_class,  // This will be 'warning' or 'error' class based on the response
                        title: response.alert_title,
                        html: errorMessages
                    });
                }
            },
            error: function(xhr, status, error) {
                // Handle error in case of AJAX failure
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Please try again later.',
                });
            }
        });
    });
</script>
    
    
        <script>
        
        
        pricearray = '<?php echo $pricearrayJson; ?>';
         imagesarray = '<?php echo $imagesarrayJson; ?>';
          availablearray = '<?php echo $availablearrayJson; ?>';
        
        
        var priceObject = JSON.parse(pricearray);
         var imagesaObject = JSON.parse(imagesarray);
          var availableObject = JSON.parse(availablearray);
        
function generateSelectedCombinations() {
    // Step 1: Get all active `li` elements with `selectedVariant` class
    const activeItems = document.querySelectorAll('li.active.selectedVariant');

    // Step 2: Group selected values by `data-arraykey`
    const groupedData = {};
    activeItems.forEach(item => {
        const key = item.getAttribute('data-arraykey'); // Get array key
        const value = item.getAttribute('data-name');   // Get value
        if (!groupedData[key]) {
            groupedData[key] = []; // Initialize if not exists
        }
        groupedData[key].push(value); // Add value to the array
    });

    // Function to generate all combinations of an array
    function getCombinations(arr) {
        const result = [];
        const f = (prefix, rest) => {
            for (let i = 0; i < rest.length; i++) {
                const newCombination = [...prefix, rest[i]];
                result.push(newCombination); // Add combination to result
                f(newCombination, rest.slice(i + 1));
            }
        };
        f([], arr);
        return result; // Return all combinations
    }

    // Function to handle/pass each combination
    function passCombination(combination) {
        valuesfinal = combination.join('-');
        
        if(availableObject[valuesfinal]) {
             $('#addcartvalues').attr('data-qty', availableObject[valuesfinal]);  
             $('#buyNowvalues').attr('data-qty', availableObject[valuesfinal]);  
             
         }
        
         $('#buyNowvalues').attr('data-variant', valuesfinal);  
        $('#addcartvalues').attr('data-variant', valuesfinal);  
        
        if(priceObject[valuesfinal]) {
            $('.variantPrice').html('₹'+priceObject[valuesfinal]);
    
        }
        
        
        
         if(imagesaObject[valuesfinal]) {
          
            var imagePath = '<?php echo base_url('assets/images/').'/';?>' + imagesaObject[valuesfinal];

            // Set the src, srcset, and data-zoom-image attributes for the image
        $('.imagevariant').attr('src', imagePath);          // Set the src attribute for the image
$('.imagevariant').attr('srcset', imagePath);        // Set the srcset attribute for responsive images
$('.imagevariant').attr('data-zoom-image', imagePath);
        }
        
         
    }

    // Step 3: Generate combinations

    // (a) Same `data-arraykey` combinations
    Object.keys(groupedData).forEach(key => {
        const combinations = getCombinations(groupedData[key]);
        combinations.forEach(combination => passCombination(combination));
    });

    // (b) Cross `data-arraykey` combinations
    const keys = Object.keys(groupedData);
    const values = Object.values(groupedData);

    function cartesian(arr) {
        const f = (prefix, remaining) => {
            if (remaining.length === 0) {
                passCombination(prefix); // Directly pass the combination
                return;
            }
            const [first, ...rest] = remaining;
            first.forEach(value => f([...prefix, value], rest));
        };
        f([], arr);
    }

    cartesian(values);
}

// Initial call to generate selected combinations
generateSelectedCombinations();

// Add event listeners to toggle `active` class and regenerate combinations
document.querySelectorAll('li.selectedVariant').forEach(item => {
    item.addEventListener('click', function () {
        const arrayKey = this.getAttribute('data-arraykey');

        // Remove `active` class from all `li` with the same `data-arraykey`
        document.querySelectorAll(`li.selectedVariant[data-arraykey="${arrayKey}"]`).forEach(sibling => {
            sibling.classList.remove('active');
        });

        // Add `active` class to the clicked element
        this.classList.add('active');

        // Regenerate combinations
        generateSelectedCombinations();
    });
});

     
        
        
            $('#enquirysend').submit('click',function(){
    
    var formData = new FormData($(this)[0]);
    $(":submit").attr("disabled", true);
		$.ajax({
			type : "POST",
			url  : "<?php echo base_url('enquirysend'); ?>",
      processData: false,
      contentType: false,
			dataType : "JSON",
			data : formData,
			success: function(data){
			    	$("#enquirysend")[0].reset();
		
				 $(":submit").attr("disabled", false);
		
			 showAlert(data.class,data.title,data.message);	
			}
		});
		return false;
	}); 
        </script>
