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
          <div class="statbox widget box box-shadow">
            <?php
            echo success_message();
            ?>
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                  <h4><?php echo $headingTitle; ?></h4>
                </div>
              </div>
            </div>
            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">
                <?php
                echo error_message();
                echo success_message();
                echo $this->session->flashdata('bestsellermsg');
                if (is_array($pagelist) && !empty($pagelist)) {
                //   echo form_open("sitepanel/enquiry/", 'id="data_form"');
                  ?>
                  <table id="style-3" class="table style-3  table-hover">
                    <thead>
                      <tr>
                        <th>Page Name </th>
                        <th>Details</th>        
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sl = 1;
                      foreach ($pagelist as $val) {
                        ?> 
                        <tr>
                          <td><?php echo $val['page_name']; ?></td>    
                          <td>
                            <a href="#" data-toggle="modal" data-target="#banner_<?php echo $val['page_id']; ?>">
                              View Description
                            </a>
                          </td>
                          <td>
                            <?php echo anchor("wps-admin/staticpages/edit/" . $val['page_id'] . query_string(), '<span>Edit</span>', 'class="btn btn-info"'); ?> 
                          </td>
                        </tr>
                      <div class="modal fade" id="banner_<?php echo $val['page_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Description</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                            </div>
                            <div class="modal-body">
                              <?php echo $val['page_description']; ?>
                            </div>
                            <div class="modal-footer">
                              <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Close</button>
                             
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php
                      $sl++;
                    }
                    ?>
                    
                    <tr>
                        <td>Best Seller Limit</td>
                        <td>
                            <?php
                            print_r($_SESSION['best_seller_limit']);
                            ?>
                        </td>
                        <td>
                            <button data-toggle="modal" type="button" data-target="#editbestseller<?php echo $val['page_id']; ?>" class="btn btn-info" > Edit</button>
                             
                        </td>
                    </tr>
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
    
    
    
    
    
    
    
    
    <div class="modal fade" id="editbestseller<?php echo $val['page_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Best Seller Limit</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                                    </div>
                                    <div class="modal-body">
                                      <form action="<?php echo base_url().'wps-admin/update/best-seller/limit'; ?>" method="post">
                                          <div class="form-group">
                                              <label>Best Seller Limit</label>
                                              <input type="number" accept="[0,9]" class="form-control" name="best_seller_limit" value="<?php print_r($_SESSION['best_seller_limit']);?>">
                                          </div>
                                           <div class="form-group text-center">
                                              <input type="submit" class="btn btn-info">
                                          </div>
                                      </form>
                                    </div>
                                    <div class="modal-footer">
                                      <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Close</button>
                                     
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
          "lengthMenu": [10, 20, 50, 100],
          "pageLength": 10
  });
  multiCheck(c3);
</script>