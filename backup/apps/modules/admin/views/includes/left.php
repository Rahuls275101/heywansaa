<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">
<?php
 $last_url = end($this->uri->segments);
          ?>
  <nav id="sidebar">
    <div class="shadow-bottom"></div>
    <ul class="list-unstyled menu-categories" id="accordionExample">
      
      <li class="menu">
        <a href="<?php echo base_url(); ?>wps-admin" data-active="<?php echo ($this->router->fetch_class() == 'dashboard') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'dashboard') ? 'true' : 'false'; ?>" class="dropdown-toggle">
          <div class="">
            <i class="fa fa-home"></i>
            <span>Dashboard</span>
          </div>
        </a>
      </li>

      <!--<li class="menu">-->
      <!--  <a href="<?php echo base_url(); ?>wps-admin/top/ten-link" data-active="<?php echo ( $last_url == 'ten-link') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'orders') ? 'true' : 'false'; ?>" class="dropdown-toggle">-->
      <!--    <div class="">-->
      <!--      <i class="fa fa-list"></i>-->
      <!--      <span>Top-10 Link </span>-->
      <!--    </div>-->
      <!--  </a>-->
      <!--</li>-->
      
        <li class="menu">
        <a href="<?php echo base_url(); ?>wps-admin/transaction" data-active="<?php echo ($this->router->fetch_class() == 'transaction') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'transaction') ? 'true' : 'false'; ?>" class="dropdown-toggle">
          <div class="">
            <i class="fa fa-list"></i>
            <span>Transaction</span>
          </div>
        </a>
      </li>
      
      <!-- <li class="menu">-->
      <!--  <a href="<?php echo base_url(); ?>wps-admin/vendors" data-active="<?php echo ($this->router->fetch_class() == 'vendors') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'vendors') ? 'true' : 'false'; ?>" class="dropdown-toggle">-->
      <!--    <div class="">-->
      <!--      <i class="fa fa-list"></i>-->
      <!--      <span>Vendors</span>-->
      <!--    </div>-->
      <!--  </a>-->
      <!--</li>-->
      
      <li class="menu">
        <a href="<?php echo base_url(); ?>wps-admin/payment" data-active="<?php echo ($this->router->fetch_class() == 'payment') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'payment') ? 'true' : 'false'; ?>" class="dropdown-toggle">
          <div class="">
            <i class="fa fa-list"></i>
            <span>Payment Request</span>
          </div>
        </a>
      </li>
        <!--start order-->
       <li class="menu">
        <a href="#orders" data-toggle="collapse" aria-expanded="<?php echo ($this->router->fetch_class() == 'orders' || $this->router->fetch_class() == 'orders' || $this->router->fetch_class() == 'order' || $this->router->fetch_class() == 'orders' || $this->router->fetch_class() == 'order') ? 'true' : 'false'; ?>" class="dropdown-toggle <?php echo ($this->router->fetch_class() == 'orders' || $this->router->fetch_class() == 'orders' || $this->router->fetch_class() == 'orders' || $this->router->fetch_class() == 'orders' || $this->router->fetch_class() == 'orders') ? '' : 'collapsed'; ?>">
          <div class="">
            <i class="fa fa-tasks"></i>
            <span>Orders</span>
          </div>
          <div>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
          </div>
        </a>
        <ul class="in submenu list-unstyled collapse <?php echo ($this->router->fetch_class() == 'orders' || $this->router->fetch_class() == 'orders' || $this->router->fetch_class() == 'orders' || $this->router->fetch_class() == 'orders' || $this->router->fetch_class() == 'orders') ? 'show' : ''; ?>" id="orders" data-parent="#orders">
          <li>
            <a href="<?php echo base_url(); ?>wps-admin/orders" data-active="<?php echo ($this->router->fetch_class() == 'wps-admin/order/pending') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'wps-admin/order/pending') ? 'true' : 'false'; ?>" >All Orders List</a>
          </li>
           <li>
            <a href="<?php echo base_url(); ?>wps-admin/order/pending" data-active="<?php echo ($this->router->fetch_class() == 'wps-admin/order/pending') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'wps-admin/order/pending') ? 'true' : 'false'; ?>" >Pending Orders List</a>
          </li>
           <li>
            <a href="<?php echo base_url(); ?>wps-admin/order/dispatched" data-active="<?php echo ($this->router->fetch_class() == 'order/order') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'order/order') ? 'true' : 'false'; ?>" >Dispatched Orders </a>
          </li>
          <li>
            <a href="<?php echo base_url(); ?>wps-admin/order/cancel" data-active="<?php echo ($this->router->fetch_class() == 'order/order') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'order/order') ? 'true' : 'false'; ?>" >Cancel Orders </a>
          </li>
             <li>
            <a href="<?php echo base_url(); ?>wps-admin/order/delivered" data-active="<?php echo ($this->router->fetch_class() == 'order/delivered') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'order/delivered') ? 'true' : 'false'; ?>" >Delivered Orders </a>
          </li>
          
           
        </ul>
      </li>
      
      
      
    <!--end of order-->
    <!--start vendors-->
       <li class="menu">
        <a href="#vendors" data-toggle="collapse" aria-expanded="<?php echo ($this->router->fetch_class() == 'vendors' || $this->router->fetch_class() == 'vendors' || $this->router->fetch_class() == 'vendors' || $this->router->fetch_class() == 'vendors' || $this->router->fetch_class() == 'bulkorder') ? 'true' : 'false'; ?>" class="dropdown-toggle <?php echo ($this->router->fetch_class() == 'vendors' || $this->router->fetch_class() == 'vendors' || $this->router->fetch_class() == 'vendors' || $this->router->fetch_class() == 'vendors' || $this->router->fetch_class() == 'vendors') ? '' : 'collapsed'; ?>">
          <div class="">
            <i class="fa fa-tasks"></i>
            <span>Vendor</span>
          </div>
          <div>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
          </div>
        </a>
        <ul class="in submenu list-unstyled collapse <?php echo ($this->router->fetch_class() == 'vendors' || $this->router->fetch_class() == 'vendors' || $this->router->fetch_class() == 'vendors' || $this->router->fetch_class() == 'vendors' || $this->router->fetch_class() == 'vendors') ? 'show' : ''; ?>" id="vendors" data-parent="#accordionExample">
          <li>
            <a href="<?php echo base_url(); ?>wps-admin/vendors" data-active="<?php echo ($this->router->fetch_class() == 'bulkorder') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'bulkorder') ? 'true' : 'false'; ?>" >Vendor List</a>
          </li>
           <li>
            <a href="<?php echo base_url(); ?>wps-admin/vendors/unverified" data-active="<?php echo ($this->router->fetch_class() == 'vendors/unverified') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'vendors/unverified') ? 'true' : 'false'; ?>" >Un-verified Vendor </a>
          </li>
          
          
          
          
           
        </ul>
      </li>
      
      
      
    <!--end of vendor-->
    
    
    <!--start bulk-->
       <li class="menu">
        <a href="#bulk" data-toggle="collapse" aria-expanded="<?php echo ($this->router->fetch_class() == 'bulkorder' || $this->router->fetch_class() == 'bulkorder_old' || $this->router->fetch_class() == 'bulkorder' || $this->router->fetch_class() == 'bulkorder' || $this->router->fetch_class() == 'bulkorder') ? 'true' : 'false'; ?>" class="dropdown-toggle <?php echo ($this->router->fetch_class() == 'bulkorder' || $this->router->fetch_class() == 'bulkorder_old' || $this->router->fetch_class() == 'bulkorder' || $this->router->fetch_class() == 'bulkorder' || $this->router->fetch_class() == 'bulkorder') ? '' : 'collapsed'; ?>">
          <div class="">
            <i class="fa fa-tasks"></i>
            <span>Bulk Order</span>
          </div>
          <div>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
          </div>
        </a>
        <ul class="in submenu list-unstyled collapse <?php echo ($this->router->fetch_class() == 'bulkorder' || $this->router->fetch_class() == 'bulkorder_old' || $this->router->fetch_class() == 'bulkorder_dispatch' || $this->router->fetch_class() == 'color' || $this->router->fetch_class() == 'bulkorder_cancel') ? 'show' : ''; ?>" id="bulk" data-parent="#accordionExample">
          <li>
            <a href="<?php echo base_url(); ?>wps-admin/bulk/new_bulk_order" data-active="<?php echo ($this->router->fetch_class() == 'bulkorder') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'bulkorder') ? 'true' : 'false'; ?>" >New Bulk Order </a>
          </li>
           <li>
            <a href="<?php echo base_url(); ?>wps-admin/bulkorder_old" data-active="<?php echo ($this->router->fetch_class() == 'bulkorder_old') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'bulkorder_old') ? 'true' : 'false'; ?>" >Old Bulk Order </a>
          </li>
          
          <!--<li>-->
          <!--  <a href="<?php echo base_url(); ?>wps-admin/bulkorder_dispatch" data-active="<?php echo ($this->router->fetch_class() == 'bulkorder_dispatch') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'bulkorder_dispatch') ? 'true' : 'false'; ?>" >Dispached Bulk Order </a>-->
          <!--</li>   -->
          <!--<li>-->
          <!--  <a href="<?php echo base_url(); ?>wps-admin/bulkorder_cancel" data-active="<?php echo ($this->router->fetch_class() == 'bulkorder_cancel') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'bulkorder_cancel') ? 'true' : 'false'; ?>" >Cancel Bulk Order </a>-->
          <!--</li>   -->
        </ul>
      </li>
      
      
      
    <!--end of bulk-->
    
    
      <!-- category -->
     
  <li class="menu">
    <a href="#categ" data-toggle="collapse" aria-expanded="<?php echo ($this->router->fetch_class() == 'category' || $this->router->fetch_class() == 'products' || $this->router->fetch_class() == 'size' || $this->router->fetch_class() == 'color' || $this->router->fetch_class() == 'discountcoupon') ? 'true' : 'false'; ?>" class="dropdown-toggle <?php echo ($this->router->fetch_class() == 'category' || $this->router->fetch_class() == 'products' || $this->router->fetch_class() == 'size' || $this->router->fetch_class() == 'color' || $this->router->fetch_class() == 'discountcoupon') ? '' : 'collapsed'; ?>">
      <div class="">
        <i class="fa fa-tasks"></i>
        <span>Product Management</span>
      </div>
      <div>
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
      </div>
    </a>
    <ul class="in submenu list-unstyled collapse <?php echo ($this->router->fetch_class() == 'category' || $this->router->fetch_class() == 'products' || $this->router->fetch_class() == 'size' || $this->router->fetch_class() == 'color' || $this->router->fetch_class() == 'discountcoupon') ? 'show' : ''; ?>" id="categ" data-parent="#accordionExample">
      <li>
        <a href="<?php echo base_url(); ?>wps-admin/category" data-active="<?php echo ($this->router->fetch_class() == 'category') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'category') ? 'true' : 'false'; ?>" >Manage Categories </a>
      </li>
      <?php if(1==1){ ?>
       <li>
        <a href="<?php echo base_url(); ?>wps-admin/products" data-active="<?php echo ($this->router->fetch_class() == 'products') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'products') ? 'true' : 'false'; ?>" >Manage Products </a>
      </li>
      
      <?php } ?>
      <li>
        <a href="<?php echo base_url(); ?>wps-admin/size" data-active="<?php echo ($this->router->fetch_class() == 'size') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'size') ? 'true' : 'false'; ?>" > Manage Size </a>
      </li>
      <li>
        <a href="<?php echo base_url(); ?>wps-admin/color" data-active="<?php echo ($this->router->fetch_class() == 'color') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'color') ? 'true' : 'false'; ?>" > Manage Color </a>
      </li>  
      <li>
        <a href="<?php echo base_url(); ?>wps-admin/brand" data-active="<?php echo ($this->router->fetch_class() == 'brand') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'brand') ? 'true' : 'false'; ?>" >Brand List </a>
      </li>  
      <li>
        <a href="<?php echo base_url(); ?>wps-admin/discountcoupon" data-active="<?php echo ($this->router->fetch_class() == 'discountcoupon') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'discountcoupon') ? 'true' : 'false'; ?>" >Discount Coupon </a>
      </li>  
    </ul>
  </li>
  <li class="menu">
    <a href="<?php echo base_url(); ?>wps-admin/members" data-active="<?php echo ($this->router->fetch_class() == 'members') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'members') ? 'true' : 'false'; ?>" class="dropdown-toggle">
      <div class="">
        <i class="fa fa-list"></i>
        <span>Users</span>
      </div>
    </a>
  </li>
  <li class="menu">
    <a href="<?php echo base_url(); ?>wps-admin/social_links" data-active="<?php echo ($this->router->fetch_class() == 'social_links') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'social_links') ? 'true' : 'false'; ?>" class="dropdown-toggle">
      <div class="">
        <i class="fa fa-list"></i>
        <span>Social Links</span>
      </div>
    </a>
  </li>

      

      <li class="menu">
        <a href="<?php echo base_url(); ?>wps-admin/banners" data-active="<?php echo ($this->router->fetch_class() == 'banners') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'banners') ? 'true' : 'false'; ?>" class="dropdown-toggle">
          <div class="">
            <i class="fa fa-list"></i>
            <span>Banner Management</span>
          </div>
        </a>
      </li>
      
      

      <!-- Enquiries -->
      <li class="menu">
        <a href="<?php echo base_url(); ?>wps-admin/enquiry/index/1" data-active="<?php echo ($this->router->fetch_class() == 'enquiry') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'enquiry') ? 'true' : 'false'; ?>" class="dropdown-toggle">
          <div class="">
            <i class="fa fa-list"></i>
            <span>Contact Us Enquiries</span>
          </div>
        </a>
      </li>
    
    <!--testimonial-->

      <!--  <li class="menu">-->
      <!--      <a href="<?php echo base_url(); ?>wps-admin/testimonial" data-active="<?php echo ($this->router->fetch_class() == 'testimonial') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'testimonial') ? 'true' : 'false'; ?>" class="dropdown-toggle">-->
      <!--        <div class="">-->
      <!--          <i class="fa fa-list"></i>-->
      <!--          <span>Testimonial</span>-->
      <!--        </div>-->
      <!--  </a>-->
      <!--</li>-->
      
      <!--testimonial end-->
      
      
      
      <li class="menu">
        <a href="#oth" data-toggle="collapse" aria-expanded="<?php echo ($this->router->fetch_class() == 'staticpages' || $this->router->fetch_class() == 'meta' || $this->router->fetch_class() == 'dashboard') ? 'true' : 'false'; ?>" class="dropdown-toggle <?php echo ($this->router->fetch_class() == 'staticpages' || $this->router->fetch_class() == 'meta' || $this->router->fetch_class() == 'dashboard') ? '' : 'collapsed'; ?>">
          <div class="">
            <i class="fa fa-tasks"></i>
            <span>Others</span>
          </div>
          <div>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
          </div>
        </a>
        <ul class="in submenu list-unstyled collapse <?php echo ($this->router->fetch_class() == 'staticpages' || $this->router->fetch_class() == 'meta' || $this->router->fetch_class() == 'dashboard') ? 'show' : ''; ?>" id="oth" data-parent="#accordionExample">
          <li>
            <a href="<?php echo base_url(); ?>wps-admin/staticpages"> Static Pages </a>
          </li>
           <li>
            <a href="<?php echo base_url(); ?>wps-admin/meta"> Meta Tags </a>
          </li>
          <li>
            <a href="<?php echo base_url(); ?>wps-admin/dashboard/website_configuration"> Website Configuration </a>
          </li>
          <li>
            <a href="<?php echo base_url(); ?>wps-admin/dashboard/changepassword"> Change Password </a>
          </li>          
        </ul>
      </li>



      <!-- Reports -->
      <!--<li class="menu">
        <a href="<?php echo base_url(); ?>wps-admin/settings" aria-expanded="false" class="dropdown-toggle">
          <div class="">
            <i class="fa fa-cogs"></i>
            <span>Settings</span>
          </div>
        </a>
      </li>-->


    </ul>
    <!-- <div class="shadow-bottom"></div> -->
  </nav>
</div>

<!--  END SIDEBAR  -->