<?php 

use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();
   $addressView = $commanmodel->get_single_query('address',array('id' => 1)); 
    $request = service('request');
     $session = session();
     
       $category = $commanmodel->all_multiple_query_order_by('category',array('parent_id' => 0),'category_id','ASC');
?>


<html lang="en">



<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
 
 <meta charset="utf-8">
<meta property="og:url" content="<?php echo $pageurl; ?>" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo $title; ?>" />
<meta property="og:description" content="<?php echo $description; ?>" />
<meta property="og:image" content="<?php echo $pageimage;?>" />
<meta name="twitter:card" content="summary_large_image">
<title><?php echo $title; ?></title>
<meta name="description" content="<?php echo $description; ?>"/>
<meta name="keywords" content="<?php echo $keyword; ?>" />
<meta name="copyright" content=""/>
<meta name="author" content=" " />
<meta name="email" content="info@Panickers Travel - mindbels.in" />
<meta name="Distribution" content="Global" />
<meta name="page-topic" content=" " />
<meta name="page-type" content="Rich Internet Media" />
<meta name="Rating" content="General" />
<meta name="Robots" content="INDEX,FOLLOW" />
<meta name="Revisit-after" content="7 Days" />
<link rel="canonical" href="https://www.starwebmaker.com/" />
<meta name="site" content=" " />
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">





   <script>
        WebFontConfig = {
            google: { rel: 'text/html', families: [ 'Open+Sans:300,400,600,700,800', 'Poppins:200,300,400,500,600,700,800', 'Oswald:300,600,700' ] }
        };
        ( function ( d ) {
            var wf = d.createElement( 'script' ), s = d.scripts[ 0 ];
            wf.src = 'assets/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore( wf, s );
        } )( document );
    </script>


    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>/assets/css/bootstrap.min.css">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>/assets/css/demo26.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/frontend/'); ?>/assets/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/frontend/'); ?>/assets/vendor/simple-line-icons/css/simple-line-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="page-wrapper">
        <header class="header">
            <!--<div class="header-top font2">-->
            <!--    <div class="container d-block">-->
            <!--        <div class="row">-->
            <!--            <div class="col-lg-5 order-lg-last">-->
            <!--                <div class="info-box info-box-icon-left justify-content-lg-end p-0">-->
            <!--                    <i class="icon-shipping"></i>-->

            <!--                    <div class="info-box-content">-->
            <!--                        <h4 class="font-weight-bold line-height-1 ls-10 text-dark text-uppercase">Free-->
            <!--                            next day-->
            <!--                            delivery*</h4>-->
                               
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div-->
            <!--                class="col-lg-7 d-flex flex-wrap justify-content-center justify-content-lg-start align-items-center text-center">-->
                           
            <!--                <div class="m-b-2">-->
            <!--                    <h5 class="line-height-1 ls-n-20 text-dark mb-0">Online Purchases Only</h5>-->
            <!--                    <p class="ls-n-20 text-left">* Minimal Purchase Price</p>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="header-middle sticky-header" data-sticky-options="{'mobile': true}">
                <div class="container">
                    <div class="header-left">
                        <button class="mobile-menu-toggler pl-0" type="button">
                            <i class="fas fa-bars"></i>
                        </button>
                        <a href="<?php echo base_url(''); ?>" class="logo">
                            <img src="<?php echo base_url('assets/img/'); ?>/<?php echo $addressView->header_logo; ?>" alt="Porto Logo" width="111" height="44">
                        </a>
                        <div
                            class="header-search header-search-inline header-search-category w-lg-max text-right d-none d-sm-block">
                            <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>
                            <!--<form action="<?php echo base_url('search'); ?>" method="get">-->
                                
                            <!--    <div class="header-search-wrapper">-->
                            <!--        <input type="search" class="form-control font-italic" name="search" id="search" value="<?php echo $search; ?>"-->
                            <!--            placeholder="I'm searching for..." required>-->
                            <!--        <button class="btn icon-magnifier" title="search" type="submit"></button>-->
                            <!--    </div>-->
                            <!--</form>-->
                            <form action="<?php echo base_url('search'); ?>" method="get" class="custom-search-form">
  <div class="custom-search-group">
    
    <!-- Category Dropdown -->
    <select class="custom-category-select" id="catsearch" name="category">
        

      <option selected disabled value="">Select Categories</option>
            <?php foreach($category as $categoryrow) { ?>
                                              <option value="<?php echo $categoryrow->category_id; ?>" <?php if(!empty($catsearch) and $catsearch==$categoryrow->category_id) { ?>selected <?php } ?>><?php echo $categoryrow->category_name; ?></option>
                                            <?php } ?>

    </select>

    <!-- Search Input -->
    <input type="search" class="custom-search-input" name="search" id="search" placeholder="Search in..." value="<?php echo $search; ?>">

    <!-- Submit Button -->
    <button type="submit" class="custom-search-btn">
      <i class="fa fa-search"></i>
    </button>

  </div>
</form>
                            
                        </div><!-- End .header-search -->
                    </div>

                 <div class="header-right">
                   
                        <div class="header-user">
                          
                            <div class="header-dropdown mr-auto mr-sm-3 mr-md-0 mx-2">
                                 <i class="icon-user-2"></i>
                                <div class="header-menu">
                                    <ul>
                                        <?php  if ($session->has('loggedin')) {
                                             $usersession = $session->get('loggedin'); ?>
                                          <li><a href="<?php echo base_url('dashboard'); ?>">Hi  <?php echo $usersession['user_name']; ?></a></li>
                                        <?php } else { ?>
                                          <li><a href="<?php echo base_url('login'); ?>">Login</a></li>
                                        <?php } ?>
                                      
                                        
                                    </ul>
                                </div>
                                <!-- End .header-menu -->
                            </div>
                           
                        </div>
                        <!-- </a> -->

                        <a href="<?php echo base_url('wishlist'); ?>" class="header-icon">
                          
                                   
                                    
                                     <?php  if ($session->has('loggedin')) { 
                                         $usersession = $session->get('loggedin'); 
                                         $userId = $usersession['user_id'];
                                     $wishlist = $commanmodel->all_multiple_query_order_by('wishlist',array('wishlist_user_id' =>$userId),'wishlist_id','ASC'); 
                                     if(count($wishlist) > 0) {
                                     ?>
                                     
                                      <i class=" fa fa-heart" style="color:#f44018"></i>
                                      
                                     <?php } else { ?>
                                         <i class="icon-wishlist-2"></i>
                                    <?php  }
                                     
                                     
                                     } else { ?>
                                           <i class="icon-wishlist-2"></i>
                                    <?php } ?>
                           
                        </a>

                        <div class="dropdown cart-dropdown">
                            <a href="#" title="Cart" class="dropdown-toggle cart-toggle" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <i class="minicart-icon"></i>
                                <span class="cart-count badge-circle numbers">0</span>
                            </a>

                            <div class="cart-overlay"></div>

                            <div class="dropdown-menu mobile-cart">
                                <a href="#" title="Close (Esc)" class="btn-close">×</a>

                                <div class="dropdownmenu-wrapper custom-scrollbar">
                                    <div class="dropdown-cart-header">Shopping Cart</div>
                                    <!-- End .dropdown-cart-header -->

                                    <div class="dropdown-cart-products mini-products-list">
                                    
                                     
                                    </div><!-- End .cart-product -->

                                    <div class="dropdown-cart-total">
                                        <span>SUBTOTAL:</span>

                                        <span class="cart-total-price float-right totalamoutcart">₹ 0.00</span>
                                    </div><!-- End .dropdown-cart-total -->

                                    <div class="dropdown-cart-action mini-products-footer">
                                        
                                    </div><!-- End .dropdown-cart-total -->
                                </div><!-- End .dropdownmenu-wrapper -->
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .dropdown -->
                    </div>
                </div>
            </div>
            <div class="header-bottom sticky-header d-none d-lg-flex mb-2" data-sticky-options="{'mobile': false}">
                <div class="container">
                    <div class="header-menu">
                        <ul class="nav-categories">
                            <li><a href="<?php echo base_url('catalog/all'); ?>"><i class="fas fa-bars"></i>All<br>Categories</a>
                            </li>
                            <li><a href="<?php echo base_url('collection/seasonal-delights'); ?>">
                                <!-- <i class="icon-category-sound-video size-big"></i> -->
                                <img src="<?php echo base_url('assets/frontend/'); ?>/assets/images/tree.png">
                                Seasonal Delights</a></li>
                            <li><a href="<?php echo base_url('collection/best-seller'); ?>">
                                <!-- <i class="icon-category-lanterns-lighting"></i> -->
                                <img src="<?php echo base_url('assets/frontend/'); ?>/assets/images/icon.png">
                                Best sellers</a></li> 
                            <li><a href="<?php echo base_url('dashboard#order'); ?>">
                                <!-- <i class="icon-category-internal-accessories"></i> -->
                                <img src="<?php echo base_url('assets/frontend/'); ?>/assets/images/track.png">
                                Track Your order</a></li>
                            <li><a href="<?php echo base_url('friend-family'); ?>">
                                <!-- <i class="icon-category-external-accessories size-big"></i> -->
                                <img src="<?php echo base_url('assets/frontend/'); ?>/assets/images/seller.png">
                                Recommend to family / Friends</a></li>
                            <li><a href="<?php echo base_url('vender_register'); ?>">
                                <!-- <i class="icon-category-motorcycles size-big"></i> -->
                                <img src="<?php echo base_url('assets/frontend/'); ?>/assets/images/share.png">
                                Become A Seller</a></li>
                            <!--<li><a href="#">
                                


                            <!--Rewards Point</a></li>-->
                            <li><a href="<?php echo base_url('dashboard#order'); ?>">
                                <!-- <i class="icon-category-steering"></i> -->
                                <img src="<?php echo base_url('assets/frontend/'); ?>/assets/images/purchased.png">
                                Recently Purchased</a></li>
                            <li><a href="<?php echo base_url('collection/todays-deal'); ?>">
                                <!-- <i class="icon-category-mechanics"></i> -->
                                <img src="<?php echo base_url('assets/frontend/'); ?>/assets/images/deals.png">
                                Today's Deal</a></li>
                            <li><a href="<?php echo base_url('bulk-order'); ?>">
                                <img src="<?php echo base_url('assets/frontend/'); ?>/assets/images/bulk-order.png">
                                <!-- <i class="icon-category-hot-deals"></i> -->
                                Bulk 
                                    <br>Order</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header><!-- End .header -->