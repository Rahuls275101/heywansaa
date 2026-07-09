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
                <?php echo form_open('wps-admin/dashboard/website_configuration/', 'class="form-horizontal"'); ?> 
                    <div class="form-group row  mb-4">
                      <label class="col-sm-4 col-form-label col-form-label-sm" for="admin_email">Email<span class="red">*</span></label>
                      <div class="col-sm-6">
                        <input type="email" class="form-control" id="admin_email" name="admin_email" value="<?=$admin_info['admin_email'];?>" placeholder="" /><?php echo form_error('admin_email'); ?>
                      </div>
                    </div>
                    <div class="form-group row  mb-4">
                      <label class="col-sm-4 col-form-label col-form-label-sm" for="phone">Mobile <span class="red">*</span></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="phone" name="phone" value="<?=$admin_info['phone'];?>" /><?php echo form_error('phone'); ?>
                      </div>
                    </div>
                    <div class="form-group row  mb-4">
                      <label class="col-sm-4 col-form-label col-form-label-sm" for="address">Address <span class="red">*</span></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="address" name="address" value="<?=$admin_info['address'];?>" /><?php echo form_error('address'); ?>
                      </div>
                    </div>
                    <div class="form-group row  mb-4">
                      <label class="col-sm-4 col-form-label col-form-label-sm" for="facebook">Facebook Link <span class="red">*</span></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="facebook" name="facebook" value="<?=$admin_info['facebook'];?>" /><?php echo form_error('facebook'); ?>
                      </div>
                    </div>
                    <div class="form-group row  mb-4">
                      <label class="col-sm-4 col-form-label col-form-label-sm" for="twitter">Twitter Link <span class="red">*</span></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="twitter" name="twitter" value="<?=$admin_info['twitter'];?>" /><?php echo form_error('twitter'); ?>
                      </div>
                    </div>
                    <div class="form-group row  mb-4">
                      <label class="col-sm-4 col-form-label col-form-label-sm" for="linkedin">Linked In Link <span class="red">*</span></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="linkedin" name="linkedin" value="<?=$admin_info['linkedin'];?>" /><?php echo form_error('linkedin'); ?>
                      </div>
                    </div>
                    <div class="form-group row  mb-4">
                      <label class="col-sm-4 col-form-label col-form-label-sm" for="instagram">Instagram Link <span class="red">*</span></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="instagram" name="instagram" value="<?=$admin_info['instagram'];?>" /><?php echo form_error('instagram'); ?>
                      </div>
                    </div>
                    <div class="form-group row  mb-4">
                      <label class="col-sm-4 col-form-label col-form-label-sm" for="youtube">Youtube Link <span class="red">*</span></label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="youtube" name="youtube" value="<?=$admin_info['youtube'];?>" /><?php echo form_error('youtube'); ?>
                      </div>
                    </div>

                    <div class="form-group row  mb-4">
                      <label class="col-sm-4 col-form-label col-form-label-sm" for="youtube">Website Enquiry Mode <span class="red">*</span></label>
                      <div class="col-sm-6">
                        <select class="form-control" name="mode">
                          <option value="">Select Mode</option>
                          <option value="Testing" <?php if($admin_info['mode']=='Testing'){ echo "selected"; } ?>>Testing</option>
                          <option value="Live" <?php if($admin_info['mode']=='Live'){ echo "selected"; } ?>>Live</option>
                        </select>
                        <?php echo form_error('mode'); ?>
                      </div>
                    </div>

                    <div class="col-lg-12 col-md-12 text-center">
                      <div class="form-group">
                        <input type="submit" value="Update" class="btn btn-info mb-2" />
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