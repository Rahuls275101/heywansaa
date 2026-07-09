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

                	<?php echo form_open('wps-vander/variant/create/vendor/action'); ?>
                  <input type="hidden" name="cow_b" value="<?php echo $this->uri->segment(3); ?>">
                 <div class="row">
                    <div class="form-group col-md-2">
                      <label>Select Size</label>
                      <select name="size" class="form-control" required>
                        <option value="">--Select Size--</option>
                        <?php
                        foreach($size as $sz=>$siz)
                        {
                          ?>
                          <option value="<?php echo $siz['size_name']; ?>"><?php echo $siz['size_name']; ?></option>
                        <?php } ?>
                       </select>
                    </div>
                    <div class="form-group col-md-2">
                      <label>Select Color</label>
                      <select name="color" class="form-control" required>
                        <option value="">--Select Color--</option>
                        <?php
                        foreach($color as $sz=>$siz)
                        {
                          ?>
                          <option value="<?php echo $siz['color_code']; ?>" style="background-color: <?php echo $siz['color_code'];  ?>"><?php echo $siz['color_name']; ?></option>
                        <?php } ?>
                       </select>
                    </div>
                    <div class="form-group col-md-2">
                      <label>Price</label>
                      <input type="number" name="price" class="form-control" placeholder="Enter Price of variant">
                    </div>
                    <div class="form-group col-md-2">
                      <label>Quantity</label>
                      <input type="number" name="qty" class="form-control" placeholder="Enter Quantity">
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
                        <th>Color</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $count=1;
                      foreach ($data as $catKey => $pageVal) {
                        $addres = $this->db->query("select * from wps_customers_address_book where customer_id = '" . $pageVal['customers_id'] . "' ")->result_array();
                        ?>
                        <tr>
                          <td>
                            <?php echo $count ?>
                          </td>
                          <td>
                            <?php echo $pageVal['color_id'] ?>
                            <span style="background-color: <?php echo $pageVal['color_id'] ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                          </td>
                          <td>
                            <?php echo $pageVal['size_id'] ?>
                          </td>
                          <td>
                            ₹ <?php echo $pageVal['discounted_price'] ?>
                          </td> 
                          <td>
                             <a class="btn btn-info" href="<?php echo base_url().'wps-vendor/manage/image/variant-wise/'.$pageVal['id']; ?>">Image By Variant</a>
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