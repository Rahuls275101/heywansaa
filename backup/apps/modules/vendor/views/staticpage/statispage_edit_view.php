<?php $this->load->view('includes/top'); ?>
<!--  BEGIN MAIN CONTAINER  -->
<link rel="stylesheet" type="text/css" href="<?php echo admin_url(); ?>assets/css/forms/switches.css">
<link rel="stylesheet" type="text/css" href="<?php echo admin_url(); ?>plugins/editors/markdown/simplemde.min.css">
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
                    
                    <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Save</button>                    
                  </h4>
                </div>
              </div>
            </div>
            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="page_description">Description <span class="red">*</span></label>
                  <div class="col-sm-6">
                    <textarea class="form-control" id="page_description" name="page_description"><?php echo $pageresult['page_description']; ?></textarea><?php echo form_error('page_description'); ?>
                  </div>
                </div>

                <div class="widget-content widget-content-area">
                  <h6 class="">SEO Parameters</h6>
                </div>
                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="meta_title">Meta Title</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="categoryName" name="meta_title" placeholder="Meta Title" value="<?php echo set_value('meta_title', $metaDets['meta_title']); ?>" /><?php echo form_error('meta_title'); ?>
                  </div>
                </div>
                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="meta_escription">Meta Description</label>
                  <div class="col-sm-6">
                    <textarea class="form-control" id="description" name="meta_description"><?php echo set_value('meta_description', $metaDets['meta_description']); ?></textarea><?php echo form_error('meta_description'); ?>
                  </div>
                </div>
                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="meta_keyword">Meta Keyword</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="meta_keyword" name="meta_keyword" placeholder="Meta Keyword" value="<?php echo set_value('meta_keyword', $metaDets['meta_keyword']); ?>" /><?php echo form_error('meta_keyword'); ?>
                  </div>
                </div>

                <div class="widget-header">
                  <div class="row">
                    <div class="col-xl-6 col-md-6 col-sm-6 col-6">&nbsp;</div>
                    <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right">
                      <h4>
                        <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Save</button>
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
    <script src="<?php echo admin_url(); ?>plugins/editors/markdown/simplemde.min.js"></script>
    <script src="<?php echo admin_url(); ?>plugins/editors/markdown/custom-markdown.js"></script>
    <script type="text/javascript">
      // Autosaving
      new SimpleMDE({
        element: document.getElementById("page_description"),
        spellChecker: false,
      });
    </script>
    <?php die(); ?>