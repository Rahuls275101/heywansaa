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
      <!--<div class="row layout-top-spacing layout-spacing">
        <div class="col-lg-12">
          <div class="statbox widget box box-shadow">
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-8 col-md-8 col-sm-8 col-8">
                  <h4>Upload Categories in Bulk</h4>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-4 col-4 text-right">
                  <a class="btn btn-warning btn-sm mb-2" href="<?php echo base_url() ?>assets/sample/sample-category.xls"><i class="fa fa-download"></i> Download Sample File</a>
                </div>
              </div>
            </div>
      <?php
      echo form_open_multipart("", 'id="form"');
      echo error_message();
      ?>
            <div class="form-group row mb-4">
              <div class="col-xl-2 col-md-2 col-sm-6 col-2"></div>
              <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                <div class="custom-file mb-4">
                  <input type="file" class="custom-file-input" id="excel_file" name="excel_file">
                  <label class="custom-file-label" for="excel_file">Choose file</label>
                </div><?php echo form_error('excel_file'); ?>
              </div>
              <div class="col-xl-4 col-md-4 col-sm-4 col-4 text-left">
                <h4>
                  <input type="hidden" name="formAction" value="submit_excel" />
                  <button type="submit" class="btn btn-primary btn-sm mb-2" ><i class="fa fa-upload"></i> Upload</button>
                </h4>
              </div>
            </div>
      <?php echo form_close(); ?>
          </div>
        </div>
      </div>-->
      <div class="row layout-top-spacing layout-spacing">
        <div class="col-lg-12">
          <div class="statbox widget box box-shadow">
            <?php
            echo success_message();
            ?>
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-8 col-md-8 col-sm-8 col-8">
                  <h4><?php echo $headingTitle; ?></h4>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-4 col-4 text-right">
                  <h4><a href="<?php echo base_url(); ?>wps-admin/discountcoupon/add/" class="btn btn-dark btn-sm mb-2"><i class="fa fa-plus"></i> Add New Coupon</a></h4>
                </div>
              </div>
            </div>
            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">
                <?php
                if (is_array($res) && !empty($res)) {
                  echo form_open(base_url() . "wps-admin/discountcoupon/", 'id="data_form"');
                  ?>
                  <table id="style-3" class="table style-3  table-hover">
                    <thead>
                      <tr>
                        <th class="checkbox-column text-left"> 
                          <label class="new-control new-checkbox checkbox-outline-info  m-auto">
                            <input type="checkbox" onclick="$('input:checkbox').not(this).prop('checked', this.checked);" class="new-control-input child-chk select-customers-info" id="customer-all-info">
                            <span class="new-control-indicator"></span><span style="visibility:hidden">c</span>
                          </label>
                        </th>
                        <th>Title/Coupon Name</th>
                        <th>Coupon Code</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>   
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($res as $catKey => $pageVal) {
                        $imgdisplay = FALSE;
                        ?> 
                        <tr>
                          <td class="checkbox-column text-left"> 
                            <label class="new-control new-checkbox checkbox-outline-info  m-auto">
                              <input type="checkbox" type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['cpn_id']; ?>" class="new-control-input child-chk select-customers-info">
                              <span class="new-control-indicator"></span><span style="visibility:hidden">c</span>
                            </label>                            
                          </td>
                          <td>
                              <?php echo $pageVal['cpn_name']; ?>
                          </td>
                          <td>
                              <?php echo $pageVal['cpn_code']; ?>
                          </td>
                          <td>
                              <?php echo date('d-M-Y',strtotime($pageVal['cpn_start_date'])); ?>
                          </td>
                          <td>
                              <?php echo date('d-M-Y',strtotime($pageVal['cpn_end_date'])); ?>
                          </td>
                          <td>
                            <?php
                            if($pageVal['status'] == '1'){
                              echo 'Activated';
                            }else{
                              echo 'Deactivated';
                            }
                            ?>
                          </td>
                          <td>
                            <a href="<?php echo base_url(); ?>wps-admin/discountcoupon/edit/<?php echo $pageVal['cpn_id']; ?>" class="btn btn-success btn-sm mb-2">Edit</a>
                          </td>
                        </tr>
                        <?php
                      }
                      ?>
                    </tbody>
                  </table>
                  <div class="widget-content widget-content-area text-left split-buttons">
                    <!--<input name="status_action" type="submit"  value="Activate" class="btn btn-success mb-2" id="Activate" onClick="return validcheckstatus('arr_ids[]', 'Activate', 'Record', 'data_form');"/>-->
                    <input name="status_action" type="submit" class="btn btn-warning mb-2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]', 'Deactivate', 'Record', 'data_form');"/>
                    <!--<input name="status_action" type="submit" class="btn btn-danger mb-2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]', 'Delete', 'Record', 'data_form');"/>-->
                    <input type="hidden" name="action" id="actionInput" value="" />
                    <!--<input name="update_order" type="submit"  value="Update Order" class="btn btn-dark mb-2" />-->
                  </div>
                  <?php
                  echo form_close();
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