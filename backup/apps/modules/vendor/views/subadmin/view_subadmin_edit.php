<?php $this->load->view('includes/top'); ?>
<!--  BEGIN MAIN CONTAINER  -->
<link rel="stylesheet" type="text/css" href="<?php echo admin_url(); ?>assets/css/semantic.min.css">
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
            echo form_open_multipart("", 'id="data_form"');
            echo success_message();
            ?>
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                  <h4><?php echo $headingTitle; ?></h4>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right">
                  <h4>
                    <a href="<?php echo base_url(); ?>wps-admin/discountcoupon/" class="btn btn-danger btn-sm mb-2"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Save</button>
                  </h4>
                </div>
              </div>
            </div>
            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="name">Name <span class="red">*</span></label>
                  <div class="col-sm-6">
                    <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="<?php echo set_value('name', $edit_result['name']); ?>"><?php echo form_error('name'); ?>
                  </div>
                </div>
                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="admin_username">Login Username <span class="red">*</span></label>
                  <div class="col-md-6">                                                                                                                                                        
                    <input type="text" name="admin_username" id="admin_username" placeholder="Login Username" class="form-control" value="<?php echo set_value('admin_username', $edit_result['admin_username']); ?>"><?php echo form_error('admin_username'); ?>
                  </div>
                </div>
                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="admin_password">Login Password <span class="red">*</span></label>
                  <div class="col-md-6 col-xs-12">                                         
                    <input type="password" name="admin_password" id="admin_password" placeholder="Login Password" class="form-control" value="<?php echo set_value('admin_password', $edit_result['admin_password']); ?>"><?php echo form_error('admin_password'); ?>
                  </div>
                </div>

                

              </div>
              <div class="widget-header">
                <div class="row">
                  <div class="col-xl-6 col-md-6 col-sm-6 col-6">&nbsp;</div>
                  <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right">
                    <h4>
                      <a href="<?php echo base_url(); ?>wps-admin/discountcoupon" class="btn btn-danger btn-sm mb-2"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                      <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Save</button>
                      <input type="hidden" name="action" value="updt_cpn" /> 
                    </h4>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-wrapper">
        
        <div class="footer-section f-section-2">
          <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
        </div>
      </div>
    </div>
    <!--  END CONTENT AREA  -->
  </div>
  <!-- END MAIN CONTAINER -->
  <?php $this->load->view('includes/bottom'); ?>
  <script src="<?php echo admin_url(); ?>assets/js/semantic.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      $('.ui.dropdown').dropdown();
    });
  </script>
  <?php die(); ?>
