<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">
<?php
              $lasturi=$this->uri->segment('3');
              $lasturi2=$this->uri->segment('2');
              ?>
  <nav id="sidebar">
    <div class="shadow-bottom"></div>
    <ul class="list-unstyled menu-categories" id="accordionExample">
      
      <li class="menu">
        <a href="<?php echo base_url(); ?>wps-vendor/dashboard" data-active="<?php echo ($lasturi2 == 'dashboard' && $lasturi!='changepassword') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($lasturi2 == 'dashboard' && $lasturi!='changepassword') ? 'true' : 'false'; ?>" class="dropdown-toggle">
          <div class="">
            <i class="fa fa-home"></i>
            <span>Dashboard</span>
          </div>
        </a>
      </li>
      
      
        <li class="menu">
        <a href="<?php echo base_url(); ?>wps-vendor/vendor/documents" data-active="<?php echo ($lasturi == 'documents') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($lasturi == 'documents') ? 'true' : 'false'; ?>" class="dropdown-toggle">
          <div class="">
            <i class="fa fa-list"></i>
            <span>Documents</span>
          </div>
        </a>
      </li>
      
      
      
<?php // if($this->session->userdata()['verification_status']!=2){ ?>
      <!--<li class="menu">-->
      <!--  <a href="<?php echo base_url(); ?>wps-vendor/orders" data-active="<?php echo ($this->router->fetch_class() == 'orders') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'orders') ? 'true' : 'false'; ?>" class="dropdown-toggle">-->
      <!--    <div class="">-->
      <!--      <i class="fa fa-list"></i>-->
      <!--      <span>Order Management</span>-->
      <!--    </div>-->
      <!--  </a>-->
      <!--</li>-->
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
            <a href="<?php echo base_url(); ?>wps-vendor/orders/index/0" data-active="<?php echo ($this->router->fetch_class() == 'wps-vendor/order') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'wps-admin/order/pending') ? 'true' : 'false'; ?>" >All Orders List</a>
          </li>
          <li>
            <a href="<?php echo base_url(); ?>wps-vendor/order/processing/0" data-active="<?php echo ($this->router->fetch_class() == 'wps-vendor/order') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'wps-admin/order/pending') ? 'true' : 'false'; ?>" >Processing Orders List</a>
          </li>
           <li>
            <a href="<?php echo base_url(); ?>wps-vendor/order/pending/0" data-active="<?php echo ($this->router->fetch_class() == 'wps-vendor/order/pending') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'wps-admin/order/pending') ? 'true' : 'false'; ?>" >Pending Orders List</a>
          </li>
           <li>
            <a href="<?php echo base_url(); ?>wps-vendor/order/dispatched/0" data-active="<?php echo ($this->router->fetch_class() == 'order/order') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'order/order') ? 'true' : 'false'; ?>" >Dispatched Orders </a>
          </li>
          <li>
            <a href="<?php echo base_url(); ?>wps-vendor/order/cancel/0" data-active="<?php echo ($this->router->fetch_class() == 'order/order') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'order/order') ? 'true' : 'false'; ?>" >Cancel Orders </a>
          </li>
             <li>
            <a href="<?php echo base_url(); ?>wps-vendor/order/delivered/0" data-active="<?php echo ($this->router->fetch_class() == 'order/delivered') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'order/delivered') ? 'true' : 'false'; ?>" >Delivered Orders </a>
          </li>
          
           
        </ul>
      </li>
      
      
      
    <!--end of order-->
      <li class="menu">
        <a href="<?php echo base_url(); ?>wps-vendor/transaction" data-active="<?php echo ($this->router->fetch_class() == 'transaction') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'transaction') ? 'true' : 'false'; ?>" class="dropdown-toggle">
          <div class="">
            <i class="fa fa-list"></i>
            <span>Transaction</span>
          </div>
        </a>
      </li>
      
       <li class="menu">
        <a href="<?php echo base_url(); ?>wps-vendor/payment/request" data-active="<?php echo ($this->router->fetch_class() == 'payment') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'payment') ? 'true' : 'false'; ?>" class="dropdown-toggle">
          <div class="">
            <i class="fa fa-list"></i>
            <span>Pay-Request</span>
          </div>
        </a>
      </li>
     
    
    
    <!--start bulk-->
      <!-- <li class="menu">-->
      <!--  <a href="#bulk" data-toggle="collapse" aria-expanded="<?php echo ($this->router->fetch_class() == 'bulkorder' || $this->router->fetch_class() == 'bulkorder_old' || $this->router->fetch_class() == 'bulkorder' || $this->router->fetch_class() == 'bulkorder' || $this->router->fetch_class() == 'bulkorder') ? 'true' : 'false'; ?>" class="dropdown-toggle <?php echo ($this->router->fetch_class() == 'bulkorder' || $this->router->fetch_class() == 'bulkorder_old' || $this->router->fetch_class() == 'bulkorder' || $this->router->fetch_class() == 'bulkorder' || $this->router->fetch_class() == 'bulkorder') ? '' : 'collapsed'; ?>">-->
      <!--    <div class="">-->
      <!--      <i class="fa fa-tasks"></i>-->
      <!--      <span>Bulk Order</span>-->
      <!--    </div>-->
      <!--    <div>-->
      <!--    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>-->
      <!--    </div>-->
      <!--  </a>-->
      <!--  <ul class="in submenu list-unstyled collapse <?php echo ($this->router->fetch_class() == 'bulkorder' || $this->router->fetch_class() == 'bulkorder_old' || $this->router->fetch_class() == 'bulkorder_dispatch' || $this->router->fetch_class() == 'color' || $this->router->fetch_class() == 'bulkorder_cancel') ? 'show' : ''; ?>" id="bulk" data-parent="#accordionExample">-->
      <!--    <li>-->
      <!--      <a href="<?php echo base_url(); ?>wps-vendor/bulk/new_bulk_order" data-active="<?php echo ($this->router->fetch_class() == 'bulkorder') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'bulkorder') ? 'true' : 'false'; ?>" >New Bulk Order </a>-->
      <!--    </li>-->
      <!--     <li>-->
      <!--      <a href="<?php echo base_url(); ?>wps-vendor/bulkorder_old" data-active="<?php echo ($this->router->fetch_class() == 'bulkorder_old') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'bulkorder_old') ? 'true' : 'false'; ?>" >Old Bulk Order </a>-->
      <!--    </li>-->
          
      <!--    <li>-->
      <!--      <a href="<?php echo base_url(); ?>wps-vendor/bulkorder_dispatch" data-active="<?php echo ($this->router->fetch_class() == 'bulkorder_dispatch') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'bulkorder_dispatch') ? 'true' : 'false'; ?>" >Dispached Bulk Order </a>-->
      <!--    </li>   -->
      <!--    <li>-->
      <!--      <a href="<?php echo base_url(); ?>wps-vendor/bulkorder_cancel" data-active="<?php echo ($this->router->fetch_class() == 'bulkorder_cancel') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'bulkorder_cancel') ? 'true' : 'false'; ?>" >Cancel Bulk Order </a>-->
      <!--    </li>   -->
      <!--  </ul>-->
      <!--</li>-->
      
      
      
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
      <!--<li>-->
      <!--  <a href="<?php echo base_url(); ?>wps-vendor/category" data-active="<?php echo ($this->router->fetch_class() == 'category') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'category') ? 'true' : 'false'; ?>" >Manage Categories </a>-->
      <!--</li>-->
       <li>
        <a href="<?php echo base_url(); ?>wps-vendor/products" data-active="<?php echo ($this->router->fetch_class() == 'products') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'products') ? 'true' : 'false'; ?>" >Products List </a>
      </li>
       <li>
        <a href="<?php echo base_url(); ?>wps-vendor/products/add" data-active="<?php echo ($this->router->fetch_class() == 'products') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'products') ? 'true' : 'false'; ?>" >Add Product </a>
      </li>
      <!-- <li>
        <a href="<?php echo base_url(); ?>wps-admin/size" data-active="<?php echo ($this->router->fetch_class() == 'size') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'size') ? 'true' : 'false'; ?>" > Manage Size </a>
      </li>
      <li>
        <a href="<?php echo base_url(); ?>wps-admin/color" data-active="<?php echo ($this->router->fetch_class() == 'color') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'color') ? 'true' : 'false'; ?>" > Manage Color </a>
      </li>   -->
      <!--<li>-->
      <!--  <a href="<?php echo base_url(); ?>wps-vendor/discountcoupon" data-active="<?php echo ($this->router->fetch_class() == 'discountcoupon') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'discountcoupon') ? 'true' : 'false'; ?>" >Discount Coupon </a>-->
      <!--</li>          -->
    </ul>
  </li>

      <!--<li class="menu">-->
      <!--  <a href="<?php echo base_url(); ?>wps-vendor/members" data-active="<?php echo ($this->router->fetch_class() == 'members') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'members') ? 'true' : 'false'; ?>" class="dropdown-toggle">-->
      <!--    <div class="">-->
      <!--      <i class="fa fa-list"></i>-->
      <!--      <span>Users</span>-->
      <!--    </div>-->
      <!--  </a>-->
      <!--</li>-->

      

      <!--<li class="menu">-->
      <!--  <a href="<?php echo base_url(); ?>wps-vendor/banners" data-active="<?php echo ($this->router->fetch_class() == 'banners') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'banners') ? 'true' : 'false'; ?>" class="dropdown-toggle">-->
      <!--    <div class="">-->
      <!--      <i class="fa fa-list"></i>-->
      <!--      <span>Banner Management</span>-->
      <!--    </div>-->
      <!--  </a>-->
      <!--</li>-->
      
      

      <!-- Enquiries -->
      <!--<li class="menu">-->
      <!--  <a href="<?php echo base_url(); ?>wps-vendor/enquiry/index/1" data-active="<?php echo ($this->router->fetch_class() == 'enquiry') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($this->router->fetch_class() == 'enquiry') ? 'true' : 'false'; ?>" class="dropdown-toggle">-->
      <!--    <div class="">-->
      <!--      <i class="fa fa-list"></i>-->
      <!--      <span>Contact Us Enquiries</span>-->
      <!--    </div>-->
      <!--  </a>-->
      <!--</li>-->

      <li class="menu">
          
        <a href="#oth" data-toggle="collapse" aria-expanded="<?php echo ($lasturi == 'changepassword') ? 'true' : 'false'; ?>" class="dropdown-toggle <?php echo ($this->router->fetch_class() == 'staticpages' || $this->router->fetch_class() == 'meta' || $lasturi == 'changepassword') ? '' : 'collapsed'; ?>">
          <div class="">
            <i class="fa fa-tasks"></i>
            <span>Others</span>
          </div>
          <div>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
          </div>
        </a>
        <ul class="in submenu list-unstyled collapse <?php echo ($lasturi == 'changepassword' || $lasturi == 'changepassword' || $lasturi == 'changepassword') ? 'show' : ''; ?>" id="oth" data-parent="#accordionExample">
        
          <li>
              
            <a href="<?php echo base_url(); ?>wps-vendor/dashboard/changepassword" data-active="<?php echo ($lasturi == 'changepassword') ? 'true' : 'false'; ?>" aria-expanded="<?php echo ($lasturi == 'changepassword') ? 'true' : 'false'; ?>" > Change Password <?php echo $lasturi; ?></a>
          </li>          
        </ul>
      </li>


<?php // } ?>
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