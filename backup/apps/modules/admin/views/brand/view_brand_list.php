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
            echo form_open_multipart(base_url().'wps-admin/brand/action');
            echo success_message();
            print_r($this->session->flashdata('msg'));
            ?> 
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                  <h4><?php echo $headingTitle; ?></h4>
                </div>
               
              </div>
            </div>


            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">
              </div>



              <div class="widget-header">
                <div class="row">
                      <div class="col-xl-4">
                          <input type="text" name="brand_name" class="form-control" value="<?php echo set_value('brand_name');?>" placeholder="Enter Brand Name..." required>  
                          <?php echo form_error('brand_name'); ?>
                      </div>
                       <div class="col-xl-4">
                          <div class="col-sm-12">
                                  <input type="file" name="image_logo" class="form-control" required>  
                                  <?php echo form_error('brand_name'); ?>
                          </div>
                       </div>
                       <div class="col-xl-4">
                             <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Save</button>
                             <?php  ?>
                       </div>
                       <div class="col-xl-12">
                           <div class="table-responsive">
                               <table class="table table-bordered">
                                   <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Brand Name</th>
                                          <th>Image/Logo</th>
                                          <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $c=1;
                                            foreach($res_array as $res=>$r)
                                            {
                                            ?>
                                        <tr>
                                            
                                            <td><?=$c++?></td>
                                            <td><?=$r['brand_name']?></td>
                                            <td><img src="<?= base_url().'uploaded-files/brand/'.$r['image_logo']?>" height="50px"></td>
                                        
                                            <td><a class="btn btn-danger" href="<?php echo base_url().'wbl-admin/brand/delete/brand/'.$r['id']; ?>" onclick="return confirm('Are you sure want to delete?');"><i class="fa fa-trash"></i></a></td>
                                           
                                        </tr>
                                         <?php } ?>
                                    </tbody>
                               </table>
                           </div>
                       </div>
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