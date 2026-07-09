<?php $this->load->view('includes/top');
$pcatID = ($this->uri->segment(4) > 0) ? $this->uri->segment(4) : "0";
$pcatID = (int) $pcatID;
$selcatID = ($this->input->post('category_id') != '') ? $this->input->post('category_id') : $pcatID;
$selcatID = (int) $selcatID;

$media1 = (isset($media_res[0]['media'])) ? $media_res[0]['media'] : '';
$media2 = (isset($media_res[1]['media'])) ? $media_res[1]['media'] : '';
$media3 = (isset($media_res[2]['media'])) ? $media_res[2]['media'] : '';
$media4 = (isset($media_res[3]['media'])) ? $media_res[3]['media'] : '';
 ?>
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
            echo form_open_multipart(current_url_query_string(), 'id="data_form"');
            echo success_message(); validation_message(); error_message();
            ?>
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                  <h4><?php echo $headingTitle; ?></h4>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right">
                  <h4>
                    <a href="<?php echo base_url(); ?>wps-admin/products/index/" class="btn btn-danger btn-sm mb-2"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Save</button>
                    <!-- <button type="submit" class="btn btn-info btn-sm mb-2"><i class="fa fa-plus-square"></i> Save & New</button>
                    <button type="submit" class="btn btn-secondary btn-sm mb-2"><i class="fa fa-plus-square"></i> Save & Close</button> -->
                  </h4>
                </div>
              </div>
            </div>
            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">

              <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="category_id">Category <span class="red">*</span></label>
                  <div class="col-sm-6">
                  <select name="category_id[]" class="form-control" required>
                      
                 <?php foreach($category_list as $cat)
                        {
                            if($res['category_id']==$cat['category_id'])
                            {
                                ?>
                               <option value="<?php echo $cat['category_id']; ?>" selected><?php echo $cat['category_name']; ?></option>
                                <?php
                            }
                            else
                            {
                        ?>
                        
                        <option value="<?php echo $cat['category_id']; ?>"><?php echo $cat['category_name']; ?></option> 
                        
                        
                  <?php } } ?>
                </select>
                <?php echo form_error('category_id[]'); ?>
					
                  </div>
                </div>

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="product_name">Product Name<span class="red">*</span></label>
                  <div class="col-sm-6">
                    <input type="text" class="url_creator form-control" id="product_name" name="product_name" value="<?php echo set_value('product_name',$res['product_name']); ?>" placeholder="Product Name" required /><?php echo form_error('product_name'); ?>
					<span id="error_url_creator" class="red"></span>
                  </div>
                </div>
                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="friendlyUrl">Friendly Url <span class="red">*</span></label>
                  <div class="col-sm-6">
                    <input type="text" class="seo_friendly_url form-control" id="friendlyUrl" name="friendly_url" value="<?php echo set_value('friendlyUrl',$res['friendly_url']); ?>" readonly required /><?php echo form_error('friendlyUrl'); ?>
					<span id="error_friendly_url" class="red"></span>
                  </div>
                </div>
                <div class="form-group row  mb-4">
              <label class="col-md-3 col-xs-12 control-label">Product Images</label>
              <div class="col-md-2">
              <div class="">
                  <img src="<?php echo get_image('products', $media1, '125', '125', 'R'); ?>" id="pic1" class="profile_picture" width="125" height="125"  /><div class="clearfix"></div>
                  <a href="javascript:void(0);" onclick="$('#img1').trigger('click');"  class="profile_picture">Add Product Image</a>
                </div>
                <input id="img1" name="img1" type="file" onchange="document.getElementById('pic1').src = window.URL.createObjectURL(this.files[0])" class="validate" style="display: none;" />
              </div>
              <div class="col-md-2">
                <div class="">
                  <img src="<?php echo get_image('products', $media2, '125', '125', 'R'); ?>" id="pic2" class="profile_picture" width="125" height="125" /><div class="clearfix"></div>
                  <a href="javascript:void(0);" onclick="$('#img2').trigger('click');" class="profile_picture">Add Product Image</a>
                </div>
                <input id="img2" name="img2" type="file" onchange="document.getElementById('pic2').src = window.URL.createObjectURL(this.files[0])" class="validate" style="display: none;" />
              </div>
              <div class="col-md-2">
                <div class="">
                  <img src="<?php echo get_image('products', $media3, '125', '125', 'R'); ?>" id="pic3" class="profile_picture" width="125" height="125" /><div class="clearfix"></div>
                  <a href="javascript:void(0);" onclick="$('#img3').trigger('click');" class="profile_picture">Add Product Image</a>
                </div>
                <input id="img3" name="img3" type="file" onchange="document.getElementById('pic3').src = window.URL.createObjectURL(this.files[0])" class="validate" style="display: none;" />
              </div>
              <div class="col-md-2">
                <div class="">
                  <img src="<?php echo get_image('products', $media4, '125', '125', 'R'); ?>" id="pic4" class="profile_picture" width="125" height="125" /><div class="clearfix"></div>
                  <a href="javascript:void(0);" onclick="$('#img4').trigger('click');" class="profile_picture">Add Product Image</a>
                </div>
                <input id="img4" name="img4" type="file" onchange="document.getElementById('pic4').src = window.URL.createObjectURL(this.files[0])" class="validate" style="display: none;" />
              </div>
            </div>

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="product_price">Product Price <span class="red">*</span></label>
                  <div class="col-sm-6 row">
                    <div class="col-sm-6">
                    <input id="product_price" name="product_price" value="<?php echo set_value('product_price', $res['product_price']); ?>" type="text" required class="form-control"><?php echo form_error('product_price'); ?>
                    <label for="product_code"><span class="required">*</span>Product Price</label>
                    </div>
                    <div class="col-sm-6">
                    <input id="unit_value" name="discounted_price" value="<?php echo set_value('discounted_price', $res['product_discounted_price']); ?>" type="text" required class="form-control"><?php echo form_error('discounted_price'); ?>
                    <label for="product_code"><span class="required">*</span>Discounted Price</label> 
                    </div>
                  </div>
                </div>

               

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="product_code">Product Additional Information <span class="red">*</span></label>
                  <div class="col-sm-6 row">
                        <div class="col-sm-6">
                        <input id="product_code" name="product_code" value="<?php echo set_value('product_code', $res['product_code']); ?>" type="text" class="form-control"><?php echo form_error('product_code'); ?>
                        <label for="product_code"><span class="required">*</span>Product Code</label>
                        </div>
                        <div class="col-sm-6">
                        <input id="product_qty" name="product_qty" value="<?php echo set_value('product_qty', $res['product_qty']); ?>" type="text" class="form-control"><?php echo form_error('product_qty'); ?>
                        <label for="product_qty"><span class="required">*</span>Product Qty</label>
                        </div>
                        
                        <div class="col-sm-4">
                        <input id="hsn_code" name="hsn_code" value="<?php echo set_value('hsn_code',$res['hsn_code']); ?>" type="text"  placeholder="HSN Code" class="form-control" required><?php echo form_error('hsn_code'); ?>
                        <label for="hsn_code"><span class="required">*</span>HSN Code</label>
                        </div>
                        <div class="col-sm-4">
                            <input id="tax_rate" name="tax_rate" value="<?php echo set_value('tax_rate',$res['tax_rate']); ?>" type="number"  placeholder="TAX RATE" class="form-control" required><?php echo form_error('tax_rate'); ?>
                            <label for="tax_rate"><span class="required">*</span>Tax Rate (%)</label>
                        </div>
                        <div class="col-sm-4">
                        <input id="cancelation_expiry_days" name="cancelation_expiry_days" value="<?php echo set_value('cancelation_expiry_days',$res['cancelation_expiry_days']); ?>" type="number"  placeholder="Cancecaltion Expiry Days" class="form-control" required><?php echo form_error('cancelation_expiry_days'); ?>
                        <label for="cancelation_expiry_days"><span class="required">*</span>Cancecaltion Expiry Days</label>
                        </div>
                        
                  </div>
                </div>

                <!-- <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="youtube_id">Youtube Video Id <span class="red">*</span></label>
                  <div class="col-sm-6">
                  <input id="product_code" name="youtube_id" value="<?php echo set_value('youtube_id', $res['youtube_id']); ?>" type="text" class="form-control"><?php echo form_error('youtube_id'); ?>
                  </div>
                </div> -->

                <!-- <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="youtube_id">Color </label>
                  <div class="col-sm-6">
                      <div class="" style="max-height: 150px; overflow-y: scroll; border: 1px solid #e1e1e1; padding: 5px;">
                          <div class="col-md-12">
                          <?php
                            $posted_color_arr = explode(',', $res['color_ids']);
                            if (is_array($colors) && !empty($colors)) {
                              foreach ($colors as $val) {
                                ?>
                                <div class="col-md-4 col-lg-4 col-sm-4 col-xs-6">
                                  <input type="checkbox" name="color_id[]" value="<?php echo $val['color_id']; ?>" <?php echo (in_array($val['color_id'], $posted_color_arr)) ? ' checked' : ''; ?>  /> <?php echo $val['color_name']; ?>
                                </div>
                                <?php
                              }
                            }
                            ?>
                          </div>
                    </div>
                    <?php echo form_error('color_id[]'); ?>
                  </div>
                </div> -->

                <!-- <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="size">Size </label>
                  <div class="col-sm-6">
                      <div class="" style="max-height: 150px; overflow-y: scroll; border: 1px solid #e1e1e1; padding: 5px;">
                          <div class="col-md-12">
                          <?php
                            $posted_size_arr = explode(',', $res['size_ids']);
                            if (is_array($sizes) && !empty($sizes)) {
                              foreach ($sizes as $val) {
                                ?>
                                <div class="col-md-4 col-lg-4 col-sm-4 col-xs-6">
                                  <input type="checkbox" name="size_id[]" value="<?php echo $val['size_id']; ?>" <?php echo (in_array($val['size_id'], $posted_size_arr)) ? ' checked' : ''; ?>  /> <?php echo $val['size_name']; ?>
                                </div>
                                <?php
                              }
                            }
                            ?>
                          </div>
                    </div>
                    <?php echo form_error('size_id[]'); ?>
                  </div>
                </div> -->

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="short_desc">Short Description </label>
                  <div class="col-sm-6">
                  <textarea name="short_desc" rows="5" cols="50" id="short_desc" ><?php echo set_value('short_desc', $res['short_desc']); ?></textarea> <?php echo form_error('short_desc'); ?>
                  </div>
                </div>

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="description">Description <span class="red">*</span></label>
                  <div class="col-sm-6">
                  <textarea name="description" rows="5" cols="50" id="description" ><?php echo set_value('description', $res['products_description']); ?></textarea> <?php echo display_ckeditor($ckeditor1); ?><?php echo form_error('description'); ?>
                  </div>
                </div>

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm" for="specification">Specification </label>
                  <div class="col-sm-6">
                  <textarea name="specification" rows="5" cols="50" id="specification" ><?php echo set_value('specification', $res['specification']); ?></textarea> <?php echo display_ckeditor($ckeditor2); ?><?php echo form_error('specification'); ?>
                  </div>
                </div>


              <div class="">
              <h6 class="" style="background-color: #e9e8e8; padding: 12px 10px 10px 20px;margin-bottom: 20px;">SEO Parameters</h6>
              </div>
              <div class="form-group row  mb-4">
                <label class="col-sm-3 col-form-label col-form-label-sm" for="metaTitle">Meta Title</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="metaTitle" name="metaTitle" value="<?php echo set_value('metaTitle',$metaDets['meta_title']); ?>" placeholder="Meta Title" /><?php echo form_error('title'); ?>
                </div>
              </div>
              <div class="form-group row  mb-4">
                <label class="col-sm-3 col-form-label col-form-label-sm" for="metaDescription">Meta Description</label>
                <div class="col-sm-6">
                  <textarea class="form-control" id="description" name="metaDescription"><?php echo set_value('metaDescription',$metaDets['meta_description']); ?></textarea><?php echo form_error('metaDescription'); ?>
                </div>
              </div>
              <div class="form-group row  mb-4">
                <label class="col-sm-3 col-form-label col-form-label-sm" for="metaKeyword">Meta Keyword</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="metaKeyword" name="metaKeyword" placeholder="Meta Keyword" value="<?php echo set_value('metaKeyword',$metaDets['meta_keyword']); ?>" /><?php echo form_error('metaKeyword'); ?>
                </div>
              </div>

              <div class="widget-header">
                <div class="row">
                  <div class="col-xl-6 col-md-6 col-sm-6 col-6">&nbsp;</div>
                  <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right">
                    <h4>
                      <a href="<?php echo base_url(); ?>wps-admin/products" class="btn btn-danger btn-sm mb-2"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                      <input type="hidden" name="products_id" id="pg_recid" value="<?php echo $res['products_id'];?>">
                      <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Save</button>
                      <!-- <button type="submit" class="btn btn-info btn-sm mb-2"><i class="fa fa-plus-square"></i> Save & New</button>
                      <button type="submit" class="btn btn-secondary btn-sm mb-2"><i class="fa fa-plus-square"></i> Save & Close</button> -->
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
