<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('includes/top');
//echo phpinfo();
?>
<style>
    .blink_me {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
</style>

<link href="<?php echo base_url(); ?>assets/sitepanel/assets/css/icofont.min.css" rel="stylesheet" type="text/css">
<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

  <div class="overlay"></div>
  <div class="search-overlay"></div>

  <?php $this->load->view('includes/left'); ?>

  <!--  BEGIN CONTENT AREA  -->
  <div id="content" class="main-content">
    <div class="layout-px-spacing">

      <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
          <div class="widget widget-chart-one">
              <?php
              $vendor_id=$this->session->userdata('admin_id');
              $r=$this->db->query("SELECT * FROM `vendor_document` where vendor_id='$vendor_id' and status=0")->result_array();
               if(count($r)>0)
               {
              
              ?>
              <span class="text-danger">Kindly Verify your account by 
                  <a href="#" data-toggle="modal" data-target="#myModal" class="text-info">Click Here <?php echo count($r); ?>
                    <img class="blink_me" src="<?php echo admin_url(); ?>assets/img/57aa27293d94f.webp" height="30px">
                  </a>
              </span>
            <?php } ?>  
              
              
        <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>-->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header d-block">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload Document</h4>
              </div>
              <div class="modal-body">
              <?php echo form_open(base_url().'wps-vendor/document/add' ,'class="row"'); ?>
                   <div class="col-4 form-group">
                       <label>Title</label>
                   </div>
                   <div class="col-8 form-group">
                       <input type="text" name="title" class="form-control" placeholder="Title here">
                   </div>
                   <div class="col-4 form-group">
                       <label>Document</label>
                   </div>
                   <div class="col-8 form-group">
                       <input type="file" name="title" class="" placeholder="">
                   </div>
                   <div class="col-4 form-group">
                       <label>Remark</label>
                   </div>
                   <div class="col-8 form-group">
                       <input type="text" name="title" class="form-control" placeholder="Remark">
                   </div>
                   <div class="col-4 form-group">
                      
                   </div>
                   <div class="col-8 form-group">
                       <input type="submit" class="btn btn-success">
                   </div>
               <?php echo form_close(); ?>
              </div>
              <!--<div class="modal-footer">-->
              <!--  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
              <!--</div>-->
            </div>
          </div>
        </div>
              
              
              
              
              
              
              <?php //} ?>
              
              
              <?php //if($this->session->userdata()['verification_status']!=2){ ?>
            <div class="widget-heading">
              <h5 class="">Dashboard</h5>
              <ul class="tabs tab-pills">
                <li><a href="javascript:void(0);" id="tb_1" class="tabmenu">All Time</a></li>
              </ul>
            </div>
            <div class="widget-content">
              <div class="tabs tab-content">
                <div id="content_1" class="tabcontent"> 
                 
                
          
       
       
       
       
       
       
       
       
       
       
       
       
       
   
       
       
       
       
       
                            <div class="row row-cards-one">
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg1">
                                        <div class="left">
                                            <h5 class="title">Orders Pending! </h5>
                                            <span class="number"><?php echo $order_pending['count']; ?></span>
                                            <a href="<?php echo base_url().'wps-vendor/order/pending/0'; ?>" class="link">View All</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
                                                <i class="icofont-rupee"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg2">
                                        <div class="left">
                                            <h5 class="title">Orders Processing!</h5>
                                            <span class="number"><?php echo $order_processing['count']; ?></span>
                                            <a href="<?php echo base_url().'wps-vendor/order/processing/0'; ?>" class="link">View All</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
                                                <i class="icofont-truck-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg3">
                                        <div class="left">
                                            <h5 class="title">Orders Completed!</h5>
                                            <span class="number"><?php echo $order_complete['count']; ?></span>
                                            <a href="<?php echo base_url().'wps-vendor/order/delivered/0'; ?>" class="link">View All</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
                                                <i class="icofont-check-circled"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg4">
                                        <div class="left">
                                            <h5 class="title">Total Products!</h5>
                                            <span class="number"><?php echo $total_product['count']; ?></span>
                                            <a href="<?php echo base_url().'wps-vendor/products'; ?>" class="link">View All</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
                                                <i class="icofont-cart-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>  


                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg5">
                                        <div class="left">
                                            <h5 class="title">Total Item Sold!</h5>
                                            <span class="number"><?php echo $total_sold_item['count']; ?></span>
                                            <a href="<?php echo base_url().'wps-vendor/order/delivered/0'; ?>" class="link">View All</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
                                                <i class="icofont-shopify"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg6">
                                        <div class="left">
                                            <h5 class="title">Total Earnings!</h5>
                                            <span class="number"><?php echo $total_earning['total_amount']; ?>₹</span>
                                              <a href="<?php echo base_url().'wps-vendor/order/delivered/0'; ?>" class="link">View All</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
                                               <i class="icofont-rupee-true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                           
                            
                        </div>
                    </div>    
                </div>
            </div>
          </div>
       
       
       
       
       
       
       
       
       
       
     
        
      

    </div>
    <div class="footer-wrapper">
      <div class="footer-section f-section-1">
          <p class="terms-conditions">All Rights Reserved. Powered By <a href="https://www.weblieu.com/" target="_blank">weblieu</a></p>
      </div>
      <div class="footer-section f-section-2">
        <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
      </div>
    </div>
  </div>
  <!--  END CONTENT AREA  -->
</div>
<!-- END MAIN CONTAINER -->
<?php $this->load->view('includes/bottom'); ?>
 