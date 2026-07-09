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
      <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
          <div class="widget-content widget-content-area br-6">
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
            <div class="table-responsive mb-4 mt-4">
              <?php
              if (is_array($result) && !empty($result)) {
                echo form_open("sitepanel/enquiry/", 'id="data_form"');
                ?>
                <table id="html5-extension" class="table style-3  table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>City</th>
                      <th>Country</th>
                      <th>Received Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $atts = array(
                        'width' => '700',
                        'height' => '550',
                        'scrollbars' => 'yes',
                        'status' => 'yes',
                        'resizable' => 'yes',
                        'screenx' => '350',
                        'screeny' => '100'
                    );
                    $sl = 1;
                    foreach ($result as $res) {
                      $address_details = array();
                      ?> 
                      <tr>
                        <td style="text-align: center;" valign="top"><?php echo $sl; ?></td>
                        <td>
                          <?php
                          echo $res['first_name'] . ' ' . $res['last_name'];
                          ?>
                        </td>
                        <td><?php echo $res['email']; ?> </td>
                        <td>
                          <?php
                          if ($res['city'] != "" && $res['city'] != '0') {
                            echo $res['city'];
                          }
                          ?>
                        </td>
                        <td>
                          <?php
                          if ($res['country'] != "" && $res['country'] != '0') {
                            echo get_db_field_value("wps_countries_list", "name", "WHERE id = '" . $res['country'] . "'");
                          }
                          ?>
                        </td>
                        <td>
                          <?php echo getDateFormat($res['receive_date'], 2); ?>
                        </td>
                      </tr>
                      <?php
                      $sl++;
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
<script src="<?php echo admin_url(); ?>plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
<script src="<?php echo admin_url(); ?>plugins/table/datatable/button-ext/jszip.min.js"></script>    
<script src="<?php echo admin_url(); ?>plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
<script src="<?php echo admin_url(); ?>plugins/table/datatable/button-ext/buttons.print.min.js"></script>
<script>
  $('#html5-extension').DataTable({
    dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
    buttons: {
      buttons: [
        //{extend: 'copy', className: 'btn'},
        //{extend: 'csv', className: 'btn'},
        {extend: 'excel', className: 'btn'},
        {extend: 'print', className: 'btn'}
      ]
    },
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
</script>
