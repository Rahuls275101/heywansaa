<script type="text/javascript">
site_url ='<?php echo base_url(); ?>';
BASEURL ='<?php echo base_url(); ?>';    
</script>
<!--class="home"-->
<body>
    <div class="page-wrapper">
        <!-- Start of Header -->
        <header class="header">
            <!-- End of Header Top -->
            <div class="header-middle sticky-content fix-top sticky-header has-dropdown">
                <div class="container">
                    <div class="header-left mr-md-4">
                        <a href="<?php echo base_url(); ?>" class="mobile-menu-toggle  w-icon-hamburger" aria-label="menu-toggle"></a>
                        <a href="<?php echo base_url(); ?>" class="logo ml-lg-0">
                            <img src="<?php echo DESIGN_URL; ?>assets/images/logo.png" alt="logo" />
                        </a>
                        <div class="mobile-search">
                            <form id="searchForm"  action="<?php echo base_url(); ?>products/search_keyword" method="post" class="input-wrapper">
                                <input type="text" class="form-control"  name="keywordSearch"  id="search"  autocomplete="off"
                                    placeholder="Search" required />
                                <button class="btn btn-search" type="submit">
                                    <i class="w-icon-search"></i>
                                </button>
                            </form>
                        </div>
                        <form id="searchForm" action="<?php echo base_url(); ?>products/search_keyword" method="post" 
                            class="header-search hs-expanded hs-round d-none d-md-flex input-wrapper">
                            
                            <?php
                            $this->db->where(array('parent_id'=>'0','status'=>'1'));
                              $this->db->order_by('category_id','asc');
                            $ccc_aaa_ttt=$this->db->get('wps_categories')->result_array();
                            // print_r($ccc_aaa_ttt);
                            ?>
                            <div class="select-box">
                                <select id="category_header_list" name="category" onchange="var url = this.value; if (url) {    window.location = '<?php echo base_url() ?>'+url;  }">
                                    <option value="">Select Categories</option>
                                    <?php
                                    foreach($ccc_aaa_ttt as $catego=>$ct)
                                    {
                                    ?>
                                     <option value="<?php echo strtolower($ct['friendly_url']); ?>" 
                                     
                                     <?php
                                     if(strtolower($ct['category_name'])==$this->uri->segment(1))
                                     {
                                         echo "selected";
                                     }
                                     ?>
                                     ><?php echo ucwords($ct['category_name']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <input type="text" class="form-control" name="keywordSearch"  id="search" placeholder="Search in..."
                                required />
                            <button class="btn btn-search" type="submit"><i class="w-icon-search"></i>
                            </button>
                        </form> 
                    </div>
                    <div class="header-right ml-4">
                        <?php
                        $user_id= $this->session->userdata('user_id');

                            
                            if(!isset($user_id))
                            {
                             

                            ?>
                        <!-- login or my Account -->
                        <a class="wishlist label-down link d-xs-show" href="<?php echo base_url('login') ?>">
                            <i class="far fa-user"></i>
                            <span class="wishlist-label d-lg-show">Login</span>
                        </a>

                        <a class="wishlist label-down link d-xs-show" href="<?php echo base_url('wishlist') ?>">
                            <i class="w-icon-heart"></i>
                            <span class="wishlist-label d-lg-show">Wishlists</span>
                        </a>

                         <?php 
                            } 
                         else
                            { 
                                ?>

                        <a class="wishlist label-down link d-xs-show" href="<?php echo base_url('my-account') ?>">
                            <i class="far fa-user"></i>
                            <span class="wishlist-label d-lg-show">Account</span>
                        </a>

                        <a class="wishlist label-down link d-xs-show" href="<?php echo base_url('wishlist') ?>">
                            <i class="w-icon-heart"></i>
                            <span class="wishlist-label d-lg-show">Wishlist</span>
                        </a>


                         <?php } ?>
                         <!-- login or my Account -->











                        <div class="dropdown cart-dropdown mr-0 mr-lg-2">
                            <a href="<?=base_url('cart');?>" class="cart-toggle label-down link">
                                <i class="w-icon-cart">
                                    <span class="cart-count"><?php echo count($this->cart->contents()); ?></span>
                                </i>
                                <span class="cart-label">Cart</span>
                            </a>
                            <!-- End of Dropdown Box -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom ">
                <div class="container-fluid">
                    <div class="inner-wrap">
                        <div class="header-right">
                            <nav class="main-nav">
                                <ul class="menu active-underline">
                                    <li class="active">
                                        <div class="menu-icon">
                                            <a href="<?php echo base_url(); ?>"> <img src="<?php echo DESIGN_URL; ?>assets/images/menu/home.png" alt="">
                                        </div>
                                        Home</a>
                                    </li>
                                    <li>
                                        <div class="menu-icon">
                                            <a href="<?php echo base_url().'seasonal-delights'; ?>"> <img src="<?php echo DESIGN_URL; ?>assets/images/menu/tree.png" alt="">
                                        </div>
                                        Seasonal Delights </a>
                                    </li>
                                    <li>
                                        <div class="menu-icon">
                                            <a href="<?php echo base_url().'best-seller'; ?>"> <img src="<?php echo DESIGN_URL; ?>assets/images/menu/icon.png" alt="">
                                        </div>
                                        Best sellers </a>
                                    </li>
                                    <li>
                                        <div class="menu-icon">
                                            <a href="<?php if($this->session->userdata('user_id')){ echo base_url().'my-orders'; } else { echo base_url().'login';} ?>"> <img src="<?php echo DESIGN_URL; ?>assets/images/menu/track.png" alt="">
                                        </div>
                                        Track Your order </a>
                                    </li>
                                    <li>
                                        <div class="menu-icon">
                                            <a href="<?php echo base_url().'share/friend-family'; ?>"> <img src="<?php echo DESIGN_URL; ?>assets/images/menu/share.png" alt="">
                                        </div>
                                        Recommend to family / Friends </a>
                                    </li>
                                    <li>
                                        <div class="menu-icon">
                                            <a href="<?php echo base_url().'login/vendor'; ?>"> <img src="<?php echo DESIGN_URL; ?>assets/images/menu/seller.png" alt="">
                                        </div>
                                        Become A Seller </a>
                                    </li>
                                    <li>
                                        <div class="menu-icon">
                                            <a href="<?php if($this->session->userdata('user_id')){ echo base_url().'rewardspoint'; } else { echo base_url().'login';} ?>"> <img src="<?php echo DESIGN_URL; ?>assets/images/menu/reward.png" alt="">
                                        </div>
                                        Rewards Point </a>
                                    </li>
                                    <li>
                                        <div class="menu-icon">
                                            <a href="<?php if($this->session->userdata('user_id')){ echo base_url().'my-orders'; } else { echo base_url().'login';} ?>"> <img src="<?php echo DESIGN_URL; ?>assets/images/menu/purchased.png" alt="">
                                        </div>
                                        Recently Purchased </a>
                                    </li>
                                    <li>
                                        <div class="menu-icon">
                                            <a href="<?php echo base_url(); ?>todaydeals"> <img src="<?php echo DESIGN_URL; ?>assets/images/menu/deals.png" alt="">
                                        </div>
                                        Today's Deal </a>
                                    </li>
                                    <li>
                                        <div class="menu-icon">
                                            <a href="<?php echo base_url(); ?>bulkorder"> <img src="<?php echo DESIGN_URL; ?>assets/images/menu/bulk-order.png" alt="">
                                        </div>
                                        Bulk Order </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>