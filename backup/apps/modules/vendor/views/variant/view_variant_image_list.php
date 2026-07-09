<?php
$this->load->view('includes/top');
?>
<style type="text/css">
  .span_round{
    height: 10px;
    width: 15px;
  }
</style>
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
            echo $this->session->flashdata('msg');
            ?>
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-8 col-md-8 col-sm-8 col-8">
                  <h4><?php echo $headingTitle; ?></h4>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-4 col-4 text-right">
                 
                </div>
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">

                	<?php echo form_open_multipart('wps-vander/variant/create/image/action'); ?>
                 <input type="hidden" name="cow_b" value="<?php echo $this->uri->segment(5); ?>">
                 <div class="row">
                    <div class="form-group col-md-3">
                      <label>Product-Image</label>
                      <input type="file" name="image" accept="image/*" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                      <label>&nbsp;</label>
                        
                      <input type="Submit" value="Create Now"  class="form-control btn btn-success" >
                    </div>
                 </div>

                 <?php echo form_close(); ?>



                </div>
              </div>
            </div>
            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">
                <?php
                if (is_array($data) && !empty($data)) {
                  echo form_open(base_url() . "wps-admin/members/", 'id="data_form"');
                  ?>
                  <table id="style-3" class="table style-3  table-hover">
                    <thead>
                      <tr>
                        
                        <th>#</th>
                        <th>image</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $count=1;
                      foreach ($data as $catKey => $pageVal) 
                      {
                      ?>
                        <tr>
                          <td>
                            <?php echo $count ?>
                          </td>
                          <td>
                            <img src="<?php echo base_url().'uploaded-files/variant-image/'.$pageVal['image']; ?>" height="100px">
                          </td> 
                          <td>
                             <a class="btn btn-info" href="<?php echo base_url().'wps-vendor/manage/image/variant-wise/delete'.$pageVal['id']; ?>"><i class="fa fa-trash"></i></a>
                          </td>
                            
                        </tr>
                      
                      <?php
                      $count++;
                    }
                    ?>
                    </tbody>
                  </table>
                  
                  <?php
                  echo form_close();
                } else {
                  ?>
                  <div class="alert alert-arrow-right alert-icon-right alert-light-primary mb-4" role="alert">
                    <strong>Warning!</strong> No Record(s) Found!
                  </div>
                  <?php
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   
  </div>
  <!--  END CONTENT AREA  -->
</div>
<!-- END MAIN CONTAINER -->
<?php $this->load->view('includes/bottom'); ?>

<?php die(); ?>