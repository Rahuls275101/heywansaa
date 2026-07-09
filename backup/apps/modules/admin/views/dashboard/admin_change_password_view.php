<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('includes/top'); ?>
<!--  BEGIN MAIN CONTAINER  -->
<link rel="stylesheet" type="text/css" href="<?php echo admin_url(); ?>assets/css/forms/switches.css">
<div class="main-container" id="container">
  <div class="overlay"></div>
  <div class="search-overlay"></div>
  <?php $this->load->view('includes/left'); ?>
  <!--  BEGIN CONTENT AREA  -->
  <div id="content" class="main-content">
    <div class="layout-px-spacing">
      <div class="row layout-top-spacing layout-spacing">
        <div class="col-lg-12">
          <div class="statbox widget box box-shadow">
            <?php
            echo success_message();
            ?>
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                  <h4>
                    <?php echo $headingTitle; ?><br />
                  </h4>
                </div>
              </div>
            </div>
            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">
                <?php
                echo success_message();
                echo error_message();
                ?>
                <form method="POST" action="">
                    
                    <div class="form-group row  mb-4">
                      <label class="col-sm-4 col-form-label col-form-label-sm" for="admin_margin">Admin Margin(%) <span class="red">*</span></label>
                      <div class="col-sm-6">
                        <input type="number" class="form-control" id="admin_margin" name="admin_margin"  value="<?php echo $admin_info['admin_margin']; ?>" placeholder="Old Password" /><?php echo form_error('admin_margin'); ?>
                      </div>
                    </div>
                    
                    
                    <div class="form-group row  mb-4">
                      <label class="col-sm-4 col-form-label col-form-label-sm" for="old_pass">Old Password <span class="red">*</span></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="old_pass" name="old_pass" value="" placeholder="Old Password" /><?php echo form_error('old_pass'); ?>
                      </div>
                    </div>
                    <div class="form-group row  mb-4">
                      <label class="col-sm-4 col-form-label col-form-label-sm" for="new_pass">New Password <span class="red">*</span></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="new_pass" name="new_pass" value="" /><?php echo form_error('new_pass'); ?>
                      </div>
                    </div>
                    <div class="form-group row  mb-4">
                      <label class="col-sm-4 col-form-label col-form-label-sm" for="confirm_password">Confirm Password <span class="red">*</span></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="confirm_password" name="confirm_password" value="" /><?php echo form_error('confirm_password'); ?>
                      </div>
                    </div>

                    <div class="col-lg-12 col-md-12 text-center">
                      <div class="form-group">
                        <input type="submit" value="Change Password" class="btn btn-info mb-2" />
                      </div> 
                    </div>
                </form>
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