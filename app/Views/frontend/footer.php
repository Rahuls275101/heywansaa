<?php 

use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();
   $addressView = $commanmodel->get_single_query('address',array('id' => 1));  
?> 

 
        <footer class="footer font2">
            <div class="container">
                <div class="footer-middle">
                    <div class="row">
                        <div class="col-lg-5">
                            <a href="#"><img src="<?php echo base_url('assets/img/'); ?>/<?php echo $addressView->footer_logo; ?>" alt="Logo" width="111"
                                    height="44" class="m-b-4"></a>

                            <div class="contact-widget mb-2 mb-lg-0">
                                           <?php $about37= $commanmodel->get_single_query('cms_pages',array('cms_id' => 37)); ?>
                                <p><?php echo $about37->cms_page_small_description; ?></p>

                                <div class="row ls-0">
                                    <!-- <div class="col-md-2-5">
                                        <h6 class="text-uppercase text-white mb-0">Questions?</h6>
                                        <h3 class="ls-n-10 text-primary">1-888-123-456</h3>
                                    </div> -->
                                    
                                    
                                   <div class="social-icons">
  <a href="https://www.facebook.com/profile.php?id=heywansaa"  title="facebook" target="_blank"> 
    <i class="fa fa-facebook-square" aria-hidden="true"></i>
  </a>
  <a href="https://twitter.com/heywansa" title="twitter" target="_blank" > 
    <i class="fa fa-twitter-square" aria-hidden="true"></i>
  </a> 
  <a href="https://www.instagram.com/heywansa/" title="instagram" target="_blank" >  
    <i class="fa fa-instagram" aria-hidden="true"></i>
  </a>
  <a href="https://www.youtube.com/channel/heywansa" title="youtube" target="_blank" >
    <i class="fa fa-youtube-square" aria-hidden="true"></i>
  </a>
  <!--<a href="#" title="linkedin">-->
  <!--  <i class="fa fa-linkedin-square" aria-hidden="true"></i>-->
  <!--</a>-->
  <a href="https://ca.pinterest.com/heywansa/" title="pinterest" target="_blank" >
    <i class="fa fa-pinterest" aria-hidden="true"></i>
  </a>
  <!--<a href="#" title="camera">-->
  <!--  <i class="fa fa-camera-retro" aria-hidden="true"></i>-->
  <!--</a>-->
</div>


                                </div>
                            </div>
                        </div><!-- End .col-lg-5 -->

                        <div class="col-lg-2 col-sm-4">
                            <div class="widget">
                                <h4 class="widget-title">
                                    Quick Links</h4>

                                <ul class="links">
                                    <li><a href="<?php echo base_url(''); ?>">Home</a></li>
                                    <li><a href="<?php echo base_url('about-us'); ?>">About Us</a></li>
                                    <li><a href="<?php echo base_url('contact-us'); ?>">Contact Us</a></li>
                                </ul>
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-2 -->

                        <div class="col-lg-3 col-sm-4">
                            <div class="widget">
                                <h4 class="widget-title">My Account</h4>

                                <ul class="links">
                                    <li><a href="<?php echo base_url('cart'); ?>">View Cart</a></li>
                                    <li><a href="<?php echo base_url('login'); ?>">Sign In</a></li>
                                    <li><a href="<?php echo base_url('wishlist'); ?>">Wishlist</a></li>
                                    <li><a href="<?php echo base_url('dashboard'); ?>">My-Account</a></li>
                                </ul>
                            </div><!-- End .widget -->
                           
                        </div><!-- End .col-lg-3 -->

                        <div class="col-lg-2 col-sm-4">
                            <div class="widget">
                                <h4 class="widget-title">Informational Links</h4>

                                <ul class="links">
                                    <li><a href="<?php echo base_url('page/privacy-policy'); ?>">Privacy Policy</a></li>
                                    <li><a href="<?php echo base_url('page/terms-and-conditions'); ?>">Terms & Condition</a></li>
                                    <li><a href="<?php echo base_url('page/return-policy'); ?>">Return & Refund Policy</a></li>
                                </ul>
                            </div><!-- End .widget -->
                             <div class="row"><div class="col-md-12">
                                        <h6 class="text-uppercase text-black mb-0">Payment Methods</h6>
                                        <img src="<?php echo base_url('assets/frontend/'); ?>/assets/images/demoes/demo26/payments.png" alt="payment methods"
                                            class="footer-payments m-b-3" width="295" height="32">
                                    </div>
                                    </div>
                        </div><!-- End .col-lg-2 -->
                    </div><!-- End .row -->
                </div><!-- End .footer-middle -->

                <div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
                    <p class="footer-copyright py-3 pr-4 mb-0">Copyright © 2022 Heywansaa. All Rights Reserved</p>

                   
                </div><!-- End .footer-bottom -->
            </div><!-- End .container -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->

    <div class="loading-overlay">
        <div class="bounce-loader">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>

    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="fa fa-times"></i></span>
            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li><a href="<?php echo base_url(''); ?>">Home</a></li>
                     <li><a href="<?php echo base_url('collection/seasonal-delights'); ?>"> Seasonal Delights</a></li>
                      <li><a href="<?php echo base_url('collection/best-seller'); ?>"> Best sellers</a></li>
                       <li><a href="<?php echo base_url('dashboard#order'); ?>"> Track Your order</a></li>
                        <li><a href="<?php echo base_url('friend-family'); ?>">Recommend to family / Friends</a></li>
                         <li><a href="<?php echo base_url('vender_register'); ?>">Become A Seller</a></li>
                     <li><a href="<?php echo base_url('dashboard#order'); ?>"> Recently Purchased</a></li>
                   
        
                </ul>

                <ul class="mobile-menu mt-2 mb-2">
                    <li class="border-0">
                        <a href="<?php echo base_url('collection/todays-deal'); ?>">
                           Today's Deal
                        </a>
                    </li>
                   
                </ul>

                <ul class="mobile-menu">
                    
                      <li><a href="<?php echo base_url('dashboard'); ?>">My-Account</a></li>
                        <li><a href="<?php echo base_url('contact-us'); ?>">Contact Us</a></li>
                      <li><a href="<?php echo base_url('wishlist'); ?>">Wishlist</a></li>
                      <li><a href="<?php echo base_url('cart'); ?>">View Cart</a></li>
                         
                                  
  
                </ul>
            </nav><!-- End .mobile-nav -->

            <form class="search-wrapper mb-2" action="#">
                <input type="text" class="form-control mb-0" placeholder="Search..." required />
                <button class="btn icon-search text-white bg-transparent p-0" type="submit"></button>
            </form>

            <div class="social-icons">
                <a href="#" class="social-icon social-facebook icon-facebook" target="_blank">
                </a>
                <a href="#" class="social-icon social-twitter icon-twitter" target="_blank">
                </a>
                <a href="#" class="social-icon social-instagram icon-instagram" target="_blank">
                </a>
            </div>
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->

    <div class="sticky-navbar">
        <div class="sticky-info">
            <a href="<?php echo base_url(''); ?>">
                <i class="icon-home"></i>Home
            </a>
        </div>
        <div class="sticky-info">
            <a href="<?php echo base_url('catalog/all'); ?>" class="">
                <i class="icon-bars"></i>Products
            </a>
        </div>
        <div class="sticky-info">
            <a href="<?php echo base_url('wishlist'); ?>" class="">
                <i class="icon-wishlist-2"></i>Wishlist
            </a>
        </div>
        <div class="sticky-info">
            <a href="<?php echo base_url('dashboard'); ?>" class="">
                <i class="icon-user-2"></i>Account
            </a>
        </div>
        <div class="sticky-info">
            <a href="<?php echo base_url('cart'); ?>" class="">
                <i class="icon-shopping-cart position-relative">
                    <span class="cart-count badge-circle">3</span>
                </i>Cart
            </a>
        </div>
    </div>

    <div class="newsletter-popup mfp-hide bg-img" id="newsletter-popup-form"
        style="background: #f1f1f1 no-repeat center/cover url(assets/images/newsletter_popup_bg.jpg)">
        <div class="newsletter-popup-content">
            <img src="assets/images/heywansa.png" alt="Logo" class="logo-newsletter" width="111" height="44">
            <h2>Subscribe to newsletter</h2>

            <p>
                Subscribe to the Porto mailing list to receive updates on new
                arrivals, special offers and our promotions.
            </p>

            <form action="#">
                <div class="input-group">
                    <input type="email" class="form-control" id="newsletter-email" name="newsletter-email"
                        placeholder="Your email address" required />
                    <input type="submit" class="btn btn-primary" value="Submit" />
                </div>
            </form>
            <div class="newsletter-subscribe">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" value="0" id="show-again" />
                    <label for="show-again" class="custom-control-label">
                        Don't show this popup again
                    </label>
                </div>
            </div>
        </div><!-- End .newsletter-popup-content -->

        <button title="Close (Esc)" type="button" class="mfp-close">
            ×
        </button>
    </div><!-- End .newsletter-popup -->

    <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>
    
   
      <script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/plugins.min.js"></script>
    <script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/optional/isotope.pkgd.min.js"></script>
    <script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/jquery.appear.min.js"></script>
    <script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/jquery.plugin.min.js"></script>

   <!-- Main JS File -->
    <script src="<?php echo base_url('assets/frontend/'); ?>/assets/js/main.min.js"></script>


 <script>
    
$(document).ready(function(){
    
    
    function mini_cart() {
         $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url('mini_cart'); ?>",
                data: {
                    action: 'action',
                  
                },
                success: function (data) {
            $(".numbers").text(data.totalCount);
		    $(".totalamoutcart").html(data.totalAmount);
            $('.mini-products-list').html(data.miniCartDetail);
        	$(".mini-products-footer").html(data.miniCartfooter);
                }
            });
    }
    
     function listCartResult() {
   
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('cart-list'); ?>",
        dataType: "json",
        data: {
            type: "listCartResult",
          
        },
        success: function(data) {
            $(".totalSummary").text(data.totalSummary);
            $('.cartSummary').html(data.cartSummary);
            $('.cartSummaryList').html(data.cartSummaryList);
            $('.checkoutSummary').html(data.checkoutSummary);
        }
    });
}


     	$(document).on('click', '.applycoupon', function(e){
  e.preventDefault();
  var coupon_code = $('#coupon_code').val();
   
     $.ajax({
      type: "POST",
       dataType: "json",
      url: "<?php echo base_url('apply_coupon_code'); ?>",
      data: {coupon_code:coupon_code},
      success: function (data) {
     
        showAlert(data.alert_class, data.alert_title, data.alert_message);
        listCartResult()
      }
    });
   
});


	$(document).on('input', '.applypin', function(e) {
    var pin;

    // Get the pin code from the appropriate field
    if ($('#shipping_pinCode').val()) {
        pin = $('#shipping_pinCode').val();
    } else {
        pin = $('#pinCode').val();
    }

    // Validate pin code before proceeding (optional)
    if (pin.length === 6) {  // assuming pin should be 6 digits, adjust as needed
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url('apply_pin_code'); ?>",
            data: { pin: pin },  // sending only the pin code
            success: function(data) {
             
                // Assuming you want to update the cart after applying pin code
                listCartResult();  // This function presumably updates the cart with any changes
            },
            error: function(xhr, status, error) {
                console.log("Error applying pin code:", error);  // Handle any error cases
            }
        });
    } else {
        console.log("Invalid pin code");
    }
});



    
     mini_cart();
     listCartResult()
     
     
     $(document).on('click', '.wishlistadd', function (e) {
    e.preventDefault();

    var product_id =  $(this).attr('data-product_id');

    $.ajax({
        type: "POST",
        url: "<?php echo base_url('wishlistapply'); ?>", // CodeIgniter 4 route
        data: { product_id: product_id },
        dataType: "json", // Expect JSON response from server
        success: function (response) {
            // Show SweetAlert based on the response from the server
            Swal.fire({
                icon: response.alert_class || 'info', // Dynamic icon
                title: response.alert_title || 'Notice', // Dynamic title
                text: response.alert_message || 'Something happened.', // Dynamic message
            });

            // Update wishlist icon dynamically if provided
            if (response.icon_update) {
                $('.pro-dis-hart').html(response.icon_update);
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An unexpected error occurred. Please try again.',
            });
        }
    });
});

    
$(document).on('click', '.delete_cart_value', function () {
    
    var id = $(this).data("reproductid");
  
      
      $.ajax({
      type: "POST",
      url: "<?php echo base_url('remove-cart-product'); ?>",
      data: 'product_token_id=' + id,
      
      success: function (data) {
       mini_cart();
        listCartResult();
      }
    });
    
  });
  
  
  $(document).on('click', '.remove_discount', function () {
    
    var action = 'action';
  
      
      $.ajax({
      type: "POST",
      url: "<?php echo base_url('remove_discount'); ?>",
      data: 'action=' + action,
      
      success: function (data) {
       mini_cart();
        listCartResult();
      }
    });
    
  });
  
  
   $(document).on('change', '.quantity', function () {
     
    var id = $(this).data("reproductid");
    var qty =  $(this).val();
    
     
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('update-cart'); ?>",
        data: {product_token_id: id,qty:qty},
        success: function (data) {
           
        mini_cart();
        listCartResult();
        }
      });
    
  });
   
         $(document).on('click', '.AddToCart', function (e) {
    e.preventDefault();
        var product_id =  $(this).attr('data-product-id');
        var variant =  $(this).attr('data-variant');
        var qty =  $(this).attr('data-qty');
        var variant_yes =  $(this).attr('data-variant-yes'); 
         
        // Check for out-of-stock condition
        if (qty <= 0) {  // If quantity is 0 or less, show out of stock alert
            showAlert('warning', 'Out of stock', 'Product out of stock');
            return; // Stop further execution if out of stock
        }
        
        if($("#qty").val()) {
             var addqty =   $("#qty").val();
        } else {
             var addqty = 1;
        }
        
        

        // Check if the variant is valid
        if ((variant_yes == 'Yes' && variant !== '') || variant_yes == 'No') {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url('add_to_cart'); ?>",
                data: {
                    product_id: product_id,
                    variant: variant,
                    qty: qty,
                    addqty: addqty,
                    variant_yes: variant_yes
                },
                success: function (data) {
                      mini_cart();
                   showAlert(data.alert_class, data.alert_title, data.alert_message);
                }
            });
        } else {
            // Invalid variant - Show error alert
            showAlert('error', 'Invalid variant', 'Please select a valid variant.');
        }
    });
    
    $(document).on('click', '.BuyNow', function (e) {
    e.preventDefault();
    var product_id = $(this).attr('data-product-id');
    var variant = $(this).attr('data-variant');
    var qty = $(this).attr('data-qty');
    var variant_yes = $(this).attr('data-variant-yes');

    if (qty <= 0) {
        showAlert('warning', 'Out of stock', 'Product out of stock');
        return;
    }

    var addqty = $("#qty").val() ? $("#qty").val() : 1;

    if ((variant_yes == 'Yes' && variant !== '') || variant_yes == 'No') {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url('add_to_cart'); ?>",
            data: {
                product_id: product_id,
                variant: variant,
                qty: qty,
                addqty: addqty,
                variant_yes: variant_yes
            },
            success: function (data) {
                if (data.alert_class === 'success') {
                    window.location.href = "<?php echo base_url('checkout'); ?>";
                } else {
                    showAlert(data.alert_class, data.alert_title, data.alert_message);
                }
            }
        });
    } else {
        showAlert('error', 'Invalid variant', 'Please select a valid variant.');
    }
});

});

    </script>
        <script>
       
     function showAlert(alert_class, alert_title, alert_message) {
    Swal.fire({
        icon: alert_class,
        title: alert_title,
        text: alert_message,
        timer: 2000, // Timer in milliseconds (2 seconds)
        showConfirmButton: true // Show the "OK" button
    });
}
    </script>



<script>
  document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById("disclaimerPopup");
    const acceptBtn = document.getElementById("acceptBtn");

    // Check if user already accepted
    if (!localStorage.getItem("disclaimerAccepted")) {
      // Show popup after 5 seconds (once only)
      setTimeout(function () {
        popup.style.display = "flex";
      }, 5000);
    }

    // Hide popup on ACCEPT
    acceptBtn.addEventListener("click", function () {
      localStorage.setItem("disclaimerAccepted", "true"); // store acceptance
      popup.style.display = "none";
    });
  });
</script>


</body>
</html>