<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('top'); 
?> 

<style>
    .offdeal-label {
    position: absolute;
    bottom: 0;
    z-index: 3;
    background-color: #f84f29;
    color: #fff;
    line-height: 30px;
    font-weight: 500;
    letter-spacing: 0.3px;
    border-radius: 1px;
    width: 100%;
    left: 0;
    font-size: 1.5rem;
}

</style>
<!-- Start of Main -->
        <main class="main">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb bb-no">
                        <h1 class="page-title mb-0">Today Deals</h1>
                        <li><a href="?php echo base_url(); ?>">Home</a></li>
                        <li>Today Deals</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->
            <!-- Start of Page Header -->
            <!--<div class="page-banner">-->
            <!--    <div class="container">-->
            <!--        <h1 class="page-title mb-0">Shop</h1>-->
            <!--    </div>-->
            <!--    <img src="<?php echo base_url(); ?>assets/designer/themes/default/assets/images/banner-bg.jpg" alt="">-->
            <!--</div>-->
            <!-- End of Page Header -->
            <!-- Start of Page Content -->
            <div class="page-content">
                <div class="container">
                    <!-- Start of Shop Content -->
                    <div class="shop-content row gutter-lg mb-10">
                        <!-- Start of Sidebar, Shop Sidebar -->
                        <aside class="sidebar shop-sidebar sticky-sidebar-wrapper sidebar-fixed">
                            <!-- Start of Sidebar Overlay -->
                            <div class="sidebar-overlay"></div>
                            <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
                            <!-- Start of Sidebar Content -->
                            <div class="sidebar-content scrollable">
                                <!-- Start of Sticky Sidebar -->
                                <div class="sticky-sidebar">
                                    <div class="filter-actions">
                                        <label>Filter :</label>
                                        <a href="#" class="btn btn-dark btn-link filter-clean">Clean All</a>
                                    </div>
                                    <!-- Start of Collapsible widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>All Categories</label></h3>
                                        <ul class="widget-body filter-items search-ul">
                                            
                                            <?php
                                            foreach($category_list as $cat_list=>$cat)
                                            {
                                            ?>
                                            <li><a href="<?php echo base_url().'misc/todaydealsycategory/'.$cat['category_id'].'/0'; ?>"><?php echo $cat['category_name']; ?></a></li>
                                      <?php } ?>
                                        </ul>
                                    </div>
                                    <!-- End of Collapsible Widget -->
                                    <!-- Start of Collapsible Widget -->
                                </div>
                                <!-- End of Sidebar Content -->
                            </div>
                            <!-- End of Sidebar Content -->
                        </aside>
                        <!-- End of Shop Sidebar -->
                        <!-- Start of Shop Main Content -->
                        <div class="main-content">
                            <nav class="toolbox">
                                <div class="toolbox-left">
                                    <a href="#" class="btn btn-primary btn-outline btn-rounded left-sidebar-toggle 
                                        btn-icon-left d-block d-lg-none"><i class="w-icon-category"></i><span>Filters</span></a>
                                </div>
                            </nav>
                            <div class="product-wrapper row">
                                <?php
                                if(count($products)>0)
                                {
                                foreach($products as $pd=>$val)
                                {
                                ?>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="product-wrap">
                                        <div class="product product-simple text-center">
                                            <figure class="product-media">
                                                <a href="<?php echo base_url().$val['friendly_url']; ?>">
                                                    <img src="<?php echo get_image('products', $val['media'], 270, 270, 'AR'); ?>" alt="Product" width="260" height="291" />
                                                </a>
                                                <!--<div class="product-action-vertical">-->
                                                <!--    <a href="#" class="btn-product-icon btn-wishlist w-icon-heart" title="Add to wishlist"></a>-->
                                                <!--</div>-->
                                                <span class="offdeal-label">
                                                    <?php
                                                    echo round(100-($val['product_discounted_price']*100)/$val['product_price']);
                                                    
                                                    ?>% 
                                                    
                                                    Off</span>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name"><a href="<?php echo base_url().$val['friendly_url']; ?>"><?php echo $val['product_name']; ?></a></h4>
                                                <div class="product-pa-wrapper">
                                                    <div class="product-price">
                                                        <ins class="new-price"> ₹ <?php echo $val['product_discounted_price']; ?></ins>
                                                        <del> ₹ <?php echo $val['product_price']; ?> </del>
                                                    </div>
                                                    <!--<div class="product-action">-->
                                                    <!--    <a href="#" class="btn-cart btn-product btn btn-icon-right btn-link btn-underline">Add-->
                                                    <!--        To Cart</a>-->
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } } else{ echo ' <div class="col-lg-8 col-md-8 col-sm-8 text-center"><h3>Products not found</h3></div>'; } ?>
                            
                            
                            </div>
                            <div class="toolbox toolbox-pagination justify-content-between">
                                <!-- <p class="showing-info mb-2 mb-sm-0">
                                    Showing<span>1-20 of 60</span>Products
                                </p> -->
                                
                                <?php echo $links; ?>
                               
                            </div>
                        </div>
                        <!-- End of Shop Main Content -->
                    </div>
                    <!-- End of Shop Content -->
                </div>
            </div>
            <!-- End of Page Content -->
        </main>
        <!-- End of Main -->
<?php $this->load->view('bottom'); ?>