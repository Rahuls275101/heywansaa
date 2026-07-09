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
            echo form_open_multipart("wps-vendor/discountcoupon/edit/".$edit_result['cpn_id'],'id="data_form"');
            echo success_message();
            ?>
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                  <h4><?php echo $headingTitle; ?></h4>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right">
                  <h4>
                    <a href="<?php echo base_url(); ?>wps-vendor/discountcoupon/" class="btn btn-danger btn-sm mb-2"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Update</button>
                  </h4>
                </div>
              </div>
            </div>
            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="cpn_name">Coupon Name <span class="red">*</span></label>
                  <div class="col-sm-6">
                    <input type="text" name="cpn_name" id="cpn_name" placeholder="" class="form-control" value="<?php echo set_value('cpn_name',$edit_result['cpn_name']); ?>"><?php echo form_error('cpn_name'); ?>
                  </div>
                </div>
                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="cpn_name">Coupon Type <span class="red">*</span></label>
                  <div class="col-sm-6">
                  <select class="form-control" name="cpn_type">
                  <option value="">-Select Coupan Type-</option>
                                        <option value="0" <?php if($edit_result['cpn_type'] == 0){echo 'selected';}?>>Fixed</option>
                                        <option value="1" <?php if($edit_result['cpn_type'] == 1){echo 'selected';} ?> >Percentage</option>
                                    </select>  <?php echo form_error('cpn_type'); ?>
                  </div>
                </div>
                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="cpn_rate">Coupan Price <span class="red">*</span></label>
                  <div class="col-md-6 col-xs-12">                                         
                    <input type="text" name="cpn_rate" id="cpn_rate" placeholder="" class="form-control" value="<?php echo set_value('cpn_rate',$edit_result['cpn_rate']); ?>"><?php echo form_error('cpn_rate'); ?>
                  </div>
                </div>
                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="cpn_rate">Minimum amount for coupan apply <span class="red">*</span></label>
                  <div class="col-md-6 col-xs-12">                                         
                  <input type="text" name="minimum_amount_for_coupan_apply" class="form-control" value="<?php echo set_value('minimum_amount_for_coupan_apply',$edit_result['minimum_amount_for_coupan_apply']);?>">  <?php echo form_error('minimum_amount_for_coupan_apply'); ?>
                  </div>
                </div>
                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="cpn_code">Coupan Code <span class="red">*</span></label>
                  <div class="col-md-6">                                                                                                                                                        
                    <input type="text" name="cpn_code" id="cpn_code" placeholder="" class="form-control" value="<?php echo set_value('cpn_code',$edit_result['cpn_code']); ?>"><?php echo form_error('cpn_code'); ?>
                  </div>
                </div>
                

                <div class="form-group row  mb-4">
                  <label class="col-md-3 col-xs-12 control-label" for="cpn_for">Date Range <span class="red">*</span></label>
                  <div class="col-md-6 col-xs-12 row">  
                  <div class="col-md-6 col-xs-6">                                         
                        <input type="text" name="start_date" id="dp-1" value="<?php echo set_value('start_date',$edit_result['cpn_start_date']); ?>" class="form-control datepicker" />
                        <?php echo form_error('start_date'); ?>
                        </div>
                        <div class="col-md-6 col-xs-6">  
                        <input type="text" name="end_date" value="<?php echo set_value('end_date',$edit_result['cpn_end_date']); ?>" id="dp-2" class="form-control datepicker" /> 
                        <?php echo form_error('end_date'); ?>       

                        </div>                                             
                  </div>
                </div>

              </div>
              <div class="widget-header">
                <div class="row">
                  <div class="col-xl-6 col-md-6 col-sm-6 col-6">&nbsp;</div>
                  <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right">
                    <h4>
                      <a href="<?php echo base_url(); ?>wps-vendor/discountcoupon" class="btn btn-danger btn-sm mb-2"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                      <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Update</button>
                      <input type="hidden" name="updt_cpn" value="updt_cpn" /> 
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
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script>
  $( function() {
    $( ".datepicker" ).datepicker();
  } );
  </script>
  <?php die(); ?>
