<?php $this->load->view('includes/top');
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
                    <a href="<?php echo base_url(); ?>wps-admin/subcontent/" class="btn btn-danger btn-sm mb-2"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Update</button>                    
                  </h4>
                </div>
              </div>
            </div>


            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">


                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>Category</label>
                  <div class="col-sm-6">
                  <select name="category_id[]" id="categorIds" class="form-control" required multiple size="7">
                <?php echo get_nested_dropdown_menu_sub(0, $res['category_id']); ?>
              </select>
              <?php echo form_error('category_id'); ?>
                  </div>
                </div>

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>Location</label>
                  <div class="col-sm-6">
                  <select name="location_id[]" id="categorIds" class="form-control" multiple size="7">
                <option value="">--Select--</option>                  
                <?php
                foreach($locations as $lk=>$lval){
                  $selArray = explode(',',$res['location_id']);
                  $sel = (in_array($lval['meta_id'], $selArray))?'selected':'';
                  ?><option value="<?php echo $lval['meta_id'];?>" <?php echo $sel; ?>>-<?php echo ucwords($lval['page_url']);?></option><?php
                }
                ?>
              </select>
              <?php echo form_error('location_id'); ?>
                  </div>
                </div>

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>Heading</label>
                  <div class="col-sm-6">
                    <div id="ban_postion">
                    <input type="text" class="form-control" name="page_heading" id="title" value="<?php echo set_value('page_heading',$res['page_heading']); ?>" />
                    <?php echo form_error('page_heading'); ?><b style="color:#660000;">Buy {catname} online in {location}</b>
                    </div>
                  </div>
                </div>

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>Description</label>
                  <div class="col-sm-6">
                  <textarea class="form-control" name="description" id="description"><?php echo set_value('description',$res['description']); ?></textarea><?php echo form_error('description'); ?><?php echo display_ckeditor($ckeditor); ?><b style="color:#660000;">Contrary to {location} belief, Lorem {catname} is not simply random text.</b>
                  </div>
                </div>

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>Short Description</label>
                  <div class="col-sm-6">
                    <div id="ban_postion">
                    <textarea class="form-control" name="short_description" id="short_description"><?php echo set_value('short_description',$res['short_description']); ?></textarea><?php echo form_error('short_description'); ?><b style="color:#660000;">Contrary to {location} belief, Lorem {catname} is not simply random text.</b>
                    </div>
                  </div>
                </div>

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>Title</label>
                  <div class="col-sm-6">
                    <div id="ban_postion">
                      <input type="text" class="form-control" name="meta_title" id="title" value="<?php echo set_value('meta_title',$res['meta_title']); ?>" />
                      <?php echo form_error('meta_title'); ?><b style="color:#660000;">{catname} manufacturer in {location}</b>
                    </div>
                  </div>
                </div>

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>Keywords</label>
                  <div class="col-sm-6">
                    <div id="ban_postion">
                    <textarea class="form-control" name="meta_keyword" rows="5" cols="80" id="keyword" ><?php echo set_value('meta_keyword',$res['meta_keyword']); ?></textarea><?php echo form_error('meta_keyword'); ?><b style="color:#660000;">{catname} manufacturer in {location}</b>
                    </div>
                  </div>
                </div>

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>Description</label>
                  <div class="col-sm-6">
                    <div id="ban_postion">
                    <textarea class="form-control" name="meta_description" rows="5" cols="80" id="description" ><?php echo set_value('meta_description',$res['meta_description']); ?></textarea><?php echo form_error('meta_description'); ?><b style="color:#660000;">{catname} manufacturer in {location}</b>
                    </div>
                  </div>
                </div>
              
              </div>



              <div class="widget-header">
                <div class="row">
                  <div class="col-xl-6 col-md-6 col-sm-6 col-6">&nbsp;</div>
                  <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right">
                    <h4>
                      <a href="<?php echo base_url(); ?>wps-admin/subcontent/" class="btn btn-danger btn-sm mb-2"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                      <input type="hidden" class="form-control" name="update" value="update" />
                      <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Update</button>
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