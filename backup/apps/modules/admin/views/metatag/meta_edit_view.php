<?php
$this->load->view('includes/top');
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
            echo form_open_multipart(current_url_query_string(), 'id="data_form"');
            echo success_message();
            ?>
            <?php echo validation_message();?>
            <?php echo error_message(); ?>  
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                  <h4><?php echo $headingTitle; ?></h4>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right">
                  <h4>
                    <a href="<?php echo base_url(); ?>wps-admin/meta/" class="btn btn-danger btn-sm mb-2"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Edit</button>
                  </h4>
                </div>
              </div>
            </div>


            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">


                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>URL</label>
                  <div class="col-sm-6">
                  <p style="background: beige;padding: 7px;"><strong><?php echo base_url().$res['page_url'];?></strong></p> 
                  </div>
                </div>
                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>Title</label>
                  <div class="col-sm-6">
                    <div id="ban_postion">
                    <textarea class="form-control" name="meta_title" rows="5" cols="80" id="title" ><?php echo set_value('meta_title',$res['meta_title']);?></textarea>                     
                    </div>
                  </div>
                </div>

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="meta_keyword">Keywords <span class="red">*</span></label>
                  <div class="col-sm-6">
                  <textarea class="form-control" name="meta_keyword" rows="5" cols="80" id="keyword" ><?php echo set_value('meta_keyword',$res['meta_keyword']);?></textarea>
                  </div>
                </div>

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="meta_keyword">Description <span class="red">*</span></label>
                  <div class="col-sm-6">
                  <textarea class="form-control" name="meta_description" rows="5" cols="80" id="description" ><?php echo set_value('meta_description',$res['meta_description']);?></textarea>
                  </div>
                </div>
               

              </div>
              

              <div class="widget-header">
                <div class="row">
                  <div class="col-xl-6 col-md-6 col-sm-6 col-6">&nbsp;</div>
                  <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right">
                    <h4>
                      <a href="<?php echo base_url(); ?>wps-admin/meta" class="btn btn-danger btn-sm mb-2"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                      <input type="hidden" name="meta_id" value="<?php echo $res['meta_id'];?>"  />
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
 
  <?php die(); ?>