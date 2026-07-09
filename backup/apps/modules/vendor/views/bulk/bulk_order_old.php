<?php $this->load->view('includes/top'); ?>
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
          
        </div>
      </div>
      <div class="row layout-top-spacing layout-spacing">
        <div class="col-lg-12">
          <div class="statbox widget box box-shadow">
            <?php
            // echo success_message();
            // echo error_message();
            
            echo $this->session->flashdata('msg');
            ?>
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-8 col-md-8 col-sm-8 col-8">
                  <h4><?php echo $headingTitle; ?></h4>
                </div>
                
              </div>
            </div>
            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">
                <?php
                // print_r($data);
                if (is_array($data) && !empty($data)) {
          
                  ?>
                 <table id="style-3" class="table style-3  table-hover">
                    <thead>
                      <tr>
                        <th  colspan="3">Customer Details/Profile</th>
                        <th  colspan="5">Product Details</th>
                        <th  colspan="4">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $c=0;
                      foreach ($data as $d ) 
                      {
                        ?> 
                        <tr>
                            <td colspan="3">
                               <div style="min-width:130px"> Date : <?= date('d-m-Y h:i A',strtotime($d->created_at)); ?></div>
                               <div style="min-width:130px"> Name : <?php echo $d->name; ?></div>
                               <div style="min-width:130px"> Phone : <?php echo $d->phone; ?></div>
                               <div style="min-width:130px"> Email : <?php echo $d->email; ?></div>
                               <div style="min-width:130px"> Quantity : <?php echo $d->quantity; ?></div>
                               <div style="min-width:130px"> City : <?php echo $d->city; ?></div>
                               <div style="min-width:130px"> State : <?php echo $d->state; ?></div>
                               <div style="min-width:130px"> Message : <?php echo $d->message; ?></div>
                               <div style="min-width:130px"> Company Name : <?php echo $d->company_name; ?></div>
                               <div style="min-width:130px"> Need By Date : <?php echo $d->need_by_date; ?></div>
                            </td>
                            <td colspan="5">
                              
                               
                               <div style="min-width:130px"> Product Name : <?php echo $d->product_name; ?></div>
                               <div style="min-width:130px"> Product Code : <?php echo $d->product_code; ?></div>
                               <div style="min-width:130px"> Specification : <?php echo $d->specification; ?></div>
                               <div style="min-width:130px"> Available Quantity : <?php echo $d->product_qty; ?></div>
                               <div style="min-width:130px"> Delivery Time : <?php echo $d->delivery_time; ?></div>
                               <div style="min-width:130px"> Packaging Details : <?php echo $d->packaging_details; ?></div>
                               <div style="min-width:130px"> Price  : <?php echo $d->product_price; ?></div>
                       
                            </td>
                            <td colspan="4">
                                
                                  Current Status: <span class="bg-dark"><?php echo $status; ?></span>
                                
                                <?php echo form_open(base_url()."wps-vendor/bulkorder_old/action_update_bulk_status"); ?>
                                    <div class="form-group">
                                        <input type="text" name="remark_admin" class="form-control" placeholder="Enter Remark Here" required>
                                    </div>
                                
                                <select name="status" class="form-control" required>
                                    <option value="">Update Status</option>
                                    <option value="2">Update as Old Bulk Border</option>
                                    <option value="3">Update as Dispached Bulk Border</option>
                                    <option value="4">Update as Cancel Bulk Border</option>
                                </select>
                                
                                <input type="hidden" name="id" value="<?php echo $d->id; ?>">
                                <input type="submit" class="button">
                                </form>
                            </td>
                        </tr>
                        <?php
                      }
                      ?>
                    </tbody>
                  </table>
                
                  <?php

                } else {
                  ?>
                  <div class="alert alert-arrow-right alert-icon-right alert-light-primary mb-4" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
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
<script type="text/javascript">
  c3 = $('#style-3').DataTable({
    "oLanguage": {
      "oPaginate": {"sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'},
      "sInfo": "Showing page _PAGE_ of _PAGES_",
      "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
      "sSearchPlaceholder": "Search...",
      "sLengthMenu": "Results :  _MENU_",
    },
    "stripeClasses": [],
    "lengthMenu": [20, 40, 80, 150, 200],
    "pageLength": 20
  });

  multiCheck(c3);
</script>