<?php
   $this->load->view("top");
   
   ?>
   
<main class="main">
    
   <!-- Start of Breadcrumb -->
   <nav class="breadcrumb-nav">
      <div class="container">
         <ul class="breadcrumb bb-no">
            <h1 class="page-title mb-0">All Category</h1>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li>All Category</li>
         </ul>
      </div>
   </nav>
   <!-- End of Breadcrumb -->
   
   <!-- Start of Page Content -->
   <div class="page-content">
      <div class="container">
         <!-- Start of Shop Content -->
         <div class="shop-content row gutter-lg mb-10">
            <!-- Start of Sidebar, Shop Sidebar -->
            <!-- End of Shop Sidebar -->
            <!-- Start of Shop Main Content -->
            <div class="main-content">
               <div class="product-wrapper row">
                   
                   
                   <?php
                   foreach($category_list as $cate_list=>$cat_list)
                   {
                   ?>
                   
                   
                  <div class="col-md-3 col-sm-6">
                     <div class="product-allcat">
                        <div class="cat-media">
                           <a href="<?php echo base_url().$cat_list['friendly_url'] ?>">
                           <img src="<?php echo base_url().'uploaded-files/category/'.$cat_list['category_image']; ?>" alt="">
                           </a>
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