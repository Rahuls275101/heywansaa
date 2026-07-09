<?php
$this->load->view("top");
$QryStringArr = array();  // To store all Query Variables so to move to other view;
$QryStringArr = array_unique($QryStringArr);
if (isset($this->meta_info['entity_id']) && $this->meta_info['entity_id'] != '') {
  $QryStringArr['category_id'] = $this->meta_info['entity_id'];
}
if ($this->input->get_post('keyword') != '') {
  $QryStringArr['keyword'] = $this->input->get_post('keyword');
}
if ($this->input->get_post('sort') != '') {
  $QryStringArr['sort'] = $this->input->get_post('sort');
}
?>

       <!-- Start of Main -->
        <main class="main">
  
            <!-- Start of Page Header -->
            <!--<div class="page-banner">-->
            <!--    <div class="container">-->
            <!--        <h1 class="page-title mb-0">Shop</h1>-->
            <!--    </div>-->
            <!--    <img src="<?php echo base_url(); ?>assets/designer/themes/default/assets/images/banner-bg.jpg" alt="">-->
            <!--</div>-->
            <!-- End of Page Header -->
            
            
         <!-- Start of Breadcrumb -->
       <nav class="breadcrumb-nav">
          <div class="container">
             <ul class="breadcrumb bb-no">
                <h1 class="page-title mb-0">View Category</h1>
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li>View Category</li>
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
                        <!--<aside class="sidebar shop-sidebar sticky-sidebar-wrapper sidebar-fixed">-->
                            <!-- Start of Sidebar Overlay -->
                        <!--    <div class="sidebar-overlay"></div>-->
                        <!--    <a class="sidebar-close" href="#"><i class="close-icon"></i></a>-->
                            <!-- Start of Sidebar Content -->
                        <!--    <div class="sidebar-content scrollable">-->
                                <!-- Start of Sticky Sidebar -->
                        <!--        <div class="sticky-sidebar">-->

                                    <!-- Start of Collapsible widget -->
                        <!--            <div class="widget widget-collapsible">-->
                        <!--                <h3 class="widget-title"><label>All Categories</label></h3>-->
                        <!--                <ul class="widget-body filter-items search-ul">-->
                        <!--                    <li><a href="#">Accessories</a></li>-->
                        <!--                    <li><a href="#">Babies</a></li>-->
                        <!--                    <li><a href="#">Beauty</a></li>-->
                        <!--                    <li><a href="#">Decoration</a></li>-->
                        <!--                    <li><a href="#">Electronics</a></li>-->
                        <!--                    <li><a href="#">Fashion</a></li>-->
                        <!--                    <li><a href="#">Food</a></li>-->
                        <!--                    <li><a href="#">Furniture</a></li>-->
                        <!--                    <li><a href="#">Kitchen</a></li>-->
                        <!--                    <li><a href="#">Medical</a></li>-->
                        <!--                    <li><a href="#">Sports</a></li>-->
                        <!--                    <li><a href="#">Watches</a></li>-->
                        <!--                </ul>-->
                        <!--            </div>-->
                                    <!-- End of Collapsible Widget -->
                        <!--        </div>-->
                                <!-- End of Sidebar Content -->
                        <!--    </div>-->
                            <!-- End of Sidebar Content -->
                        <!--</aside>-->
                        <!-- End of Shop Sidebar -->
                        <!-- Start of Shop Main Content -->
                        <div class="main-content">
                            <nav class="toolbox">
                                <div class="toolbox-left">
                                    <a href="#" class="btn btn-primary btn-outline btn-rounded left-sidebar-toggle 
                                        btn-icon-left d-block d-lg-none"><i class="w-icon-category"></i><span>Filters</span></a>
                                </div>
                            </nav>
                            <div class="row">
                                
                                <?php foreach ($res as $val) 
                                {
                                    $link_url = site_url($val['friendly_url']);
                                    ?>
                                
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="subcategorybox">
                                         <div class="subcategorybox-inner">
                                             <img src="<?php echo get_image('category', $val['category_image'], '298', '298', 'R'); ?>" alt="<?php echo imagealtTitle('', $val['category_name'], ''); ?>" title="<?php echo imagealtTitle('', $val['category_name'], ''); ?>">
                                             <div class="subcategorylink">
                                                 <a href="<?php echo base_url().$val['friendly_url']; ?>"><?php echo ucwords($val['category_name']); ?></a>
                                             </div>
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
        <!-- End of Main -->
      
  
<?php $this->load->view("bottom"); ?>
