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
           
            echo $this->session->flashdata('hsnaddsuccess');
            ?> 
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                  <h4><?php echo $headingTitle; ?></h4>
                </div>
              </div>
            </div>

        <?php  echo form_open_multipart(base_url()."wps-admin/products/addhsncode"); ?>
            <div class="widget-content widget-content-area">
              <div class="row">
               
                <div class="form-group row col-md-12">
                    <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>TAX Rate</label>
                  <div class="col-md-9">
                  <select name="category_name" class="form-control">
                      <option>--Select Category--</option>
                      <?php
                      array_multisort( array_column($category_list, "category_id"), SORT_ASC, $category_list );

                      foreach($category_list as $ct=>$catname)
                      { ?>
                          <option value="<?php echo $catname['category_id']; ?>"><?php echo ucwords($catname['category_name']); ?></option>
                      <?php }
                      ?>
                  </select>  
                  <?php echo form_error('size_name'); ?>
                  </div>
                </div>
                <div class="form-group row col-md-12">
                  <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>HSN Code</label>
                  <div class="col-sm-9">
                  <input type="text" name="hsncode" class="form-control" value="<?php echo set_value('hsncode');?>" placeholder="HSN Code">  
                  <?php echo form_error('hsncode'); ?>
                  </div>
                </div>
                <div class="form-group row col-md-12">
                  <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>TAX Rate</label>
                  <div class="col-sm-9">
                  <input type="text" name="taxrate" class="form-control" value="<?php echo set_value('taxrate');?>" placeholder="Tax in %">  
                  <?php echo form_error('taxrate'); ?>
                  </div>
                </div>
                 <div class="form-group row col-md-12 text-right">
                     <label class="col-sm-10 col-form-label col-form-label-sm"></label>
                      <div class="col-md-2 text-right">
                           <input type="hidden" class="form-control" name="sub" value="submit" />
                          <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Save</button>
                      </div>        
                 </div>
                 
                 
                
              </div>


<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-hovered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>HSN Code</th>
                        <th>TAX Rate</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($hsn_list as $hsn=>$hsn_list)
                    {
                    ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><?= $hsn_list['category_name']?></td>
                        <td><?= $hsn_list['hsn_code']?></td>
                        <td><?= $hsn_list['tax_rate']?></td>
                        <td>
                            <a class="btn btn-success" href="<?php echo base_url(); ?>"><i class="fa fa-edit"></i></a>
                            <a class="btn btn-danger" href="<?php echo base_url(); ?>"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>  
              
            </div>
             <!--hsn_list-->
                 <?php echo form_close(); ?>
              
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