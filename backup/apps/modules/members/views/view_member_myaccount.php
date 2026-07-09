<?php
$this->load->view("top");
$fieldType = $this->session->userdata('field_type');

$user_id= $this->session->userdata('user_id');

// print_r($this->session->userdata());die;
if(!isset($user_id))
{
  redirect('login');
}

?>




<!-- Start of Main -->
        <main class="main">
            <!-- Start of Page Header -->
            <!--<div class="page-header">-->
            <!--    <div class="container">-->
                    
            <!--    </div>-->
            <!--</div>-->
            <!-- End of Page Header -->
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb">
                        <h1 class="page-title mb-0">My Account</h1>
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li>My account</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->
            <!-- Start of PageContent -->
  <div class="page-content">
      <div class="container">
          <div class="row">
            <div class="col-md-3">
               <?php $this->load->view('members/left'); ?>
            </div>
      
          
          
          
                <div class="col-md-9">
                  <div class="tab-pane mb-4" id="account-orders">
                  <div class="tab-pane active in" id="account-dashboard">
                      <p class="greeting">
                          Hello
                          <span class="text-dark font-weight-bold">
                            <?php echo $this->session->userdata('username'); ?>
                          </span>
                          (not
                          <span class="text-dark font-weight-bold">
                           <?php echo $this->session->userdata('username'); ?></span>?
                          <a href="<?php echo base_url('users/logout'); ?>" class="text-primary">Log out</a>)
                      </p>
                      <div class="row">
                          <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                              <a href="<?php echo base_url('my-orders'); ?>" class="link-to-tab">
                                  <div class="icon-box text-center">
                                      <span class="icon-box-icon icon-orders">
                                          <i class="w-icon-orders"></i>
                                      </span>
                                      <div class="icon-box-content">
                                          <p class="text-uppercase mb-0">Orders</p>
                                      </div>
                                  </div>
                              </a>
                          </div>
                          <!-- <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                              <a href="<?php echo base_url('users/change-address'); ?>" class="link-to-tab">
                                  <div class="icon-box text-center">
                                      <span class="icon-box-icon icon-address">
                                          <i class="w-icon-map-marker"></i>
                                      </span>
                                      <div class="icon-box-content">
                                          <a href="" class="text-uppercase mb-0">Addresses</a>
                                      </div>
                                  </div>
                              </a>
                          </div> -->
                          <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                              <a href="<?php echo base_url('edit-profile'); ?>" class="link-to-tab">
                                  <div class="icon-box text-center">
                                      <span class="icon-box-icon icon-account">
                                          <i class="w-icon-user"></i>
                                      </span>
                                      <div class="icon-box-content">
                                          <p class="text-uppercase mb-0">Account Details</p>
                                      </div>
                                  </div>
                              </a>
                          </div>
                          <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                              <a href="<?php echo base_url('wishlist'); ?>" class="link-to-tab">
                                  <div class="icon-box text-center">
                                      <span class="icon-box-icon icon-wishlist">
                                          <i class="w-icon-heart"></i>
                                      </span>
                                      <div class="icon-box-content">
                                          <p class="text-uppercase mb-0">Wishlist</p>
                                      </div>
                                  </div>
                              </a>
                          </div>
                          <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                              <a href="<?php echo base_url('users/logout'); ?>">
                                  <div class="icon-box text-center">
                                      <span class="icon-box-icon icon-logout">
                                          <i class="w-icon-logout"></i>
                                      </span>
                                      <div class="icon-box-content">
                                          <p class="text-uppercase mb-0">Logout</p>
                                      </div>
                                  </div>
                              </a>
                          </div>
                      </div>
                  </div>
                   

                   
                   
              </div>
          </div>
      </div>
      </div>
  </div>
  <!-- End of PageContent -->
        </main>
        <!-- End of Main -->















<?php $this->load->view("bottom"); ?>