<?php
$this->load->view('includes/top');
$curr_sec_val = $this->input->post('section') ? $this->input->post('section') : $res->banner_page;
$curr_position_val = $this->input->post('banner_position') ? $this->input->post('banner_position') : $res->banner_position;
?>
<!--  BEGIN MAIN CONTAINER  -->
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
                    <a href="<?php echo base_url(); ?>wps-admin/bannner/" class="btn btn-danger btn-sm mb-2"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Edit</button>
                  </h4>
                </div>
              </div>
            </div>


            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">


                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>Section</label>
                  <div class="col-sm-6">
                    <select class="form-control" name="section"  onchange="change_ban_postions(this.value);" required>
                      <option value="">Select Section</option>
                      <?php
                      foreach ($this->config->item('bannersections') as $key => $val) {
                        $sel = ($curr_sec_val == $key ) ? "selected" : "";
                        ?> 
                        <option value="<?php echo $key; ?>" <?php echo $sel; ?> ><?php echo $val; ?></option> 
                        <?php
                      }
                      ?>  
                    </select>
                    <?php echo form_error('section'); ?>  
                  </div>
                </div>
                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>Banner Position</label>
                  <div class="col-sm-6">
                    <div id="ban_postion">
                      <?php echo banner_postion_drop_down('banner_position', $curr_position_val, $this->input->post('section'), 'class="form-control required"'); ?>   
                      <?php echo form_error('banner_position'); ?>                     
                    </div>
                  </div>
                </div>

                <!-- <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="english_title">Category <span class="red">*</span></label>
                  <div class="col-sm-6">
                  <select name="category_id[]" multiple="multiple" size="15" class="form-control" required>
                  <?php echo get_nested_dropdown_menu(0, $res->banner_category_id); ?>
                </select>
					<span id="error_url_creator" class="red"></span>
                  </div>
                </div>
                -->

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="bannerImage"><span class="red">*</span>Banner Image</label>
                  <div class="col-sm-3">
                    <div class="custom-file mb-4">
                      <input type="file" class="custom-file-input" id="customFile" name="image1">
                      <label class="custom-file-label" for="customFile">Choose file</label>
                    </div><?php echo form_error('image1'); ?>                
                  </div>
                  <div class="col-md-3 col-xs-12">
                    <?php $product_path = "banner/" . $res->banner_image; ?>                                
                    <a href="#" data-toggle="modal" data-target=".image_pop">
                      <img src="<?php echo base_url() . 'uploaded-files/' . $product_path; ?>" width="150" class="img-responsive img-rounded center-block" alt="">
                    </a>
                  </div>
                </div>
              </div>
              <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="categoryName"><span class="red">*</span>Title</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="banner_title" name="banner_title" value="<?php echo set_value('banner_title', $res->banner_title); ?>" placeholder="Banner Title" required /><?php echo form_error('banner_title'); ?>
                  </div>
                </div>
                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="categoryName"><span class="red">*</span>URL</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="banner_url" name="banner_url" value="<?php echo set_value('banner_url', $res->banner_url); ?>" placeholder="Banner URL" /><?php echo form_error('banner_url'); ?>
                  </div>
                </div>

              <!-- <div class="form-group row  mb-4">
                <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>Start Date</label>
                <div class="col-sm-3">
                  <input type="date" name="start_date" class="form-control" value="<?php echo set_value('banner_title', $res->banner_start_date); ?>" />
                </div>
              </div>

              <div class="form-group row  mb-4">
                <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>End Date</label>
                <div class="col-sm-3">
                  <input type="date" name="end_date" class="form-control" value="<?php echo set_value('banner_title', $res->banner_end_date); ?>" />
                </div>
              </div> -->

              <!--<div class="form-group row  mb-4">
                <label class="col-sm-3 col-form-label col-form-label-sm">Keyword (if Any)</label>
                <div class="col-sm-6">
                  <input type="text" placeholder="Keyword (comma seperated) to banner display in search .." name="keyword" class="form-control" value="" />
                </div>
              </div>-->

              <div class="widget-header">
                <div class="row">
                  <div class="col-xl-6 col-md-6 col-sm-6 col-6">&nbsp;</div>
                  <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right">
                    <h4>
                      <a href="<?php echo base_url(); ?>wps-admin/banners" class="btn btn-danger btn-sm mb-2"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                      <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Edit</button>
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
  <div class="modal fade image_pop" tabindex="-1" role="dialog" aria-labelledby="image_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="image_modal">Image</h4>
        </div>
        <div class="modal-body">
          <img src="<?php echo base_url() . 'uploaded-files/' . $product_path; ?>" class="img-responsive img-rounded center-block" alt="">
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    function change_ban_postions() {
      var section = $('[name="section"]').val();
      if (section != '' && section != 'undefined') {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>wps-admin/banners/ajx_ban_postions",
          data: {banner_section: section}
        }).done(function (data) {
          $('#ban_postion').html(data);
        });
      }
      return false;
    }
  </script>
  <?php die(); ?>