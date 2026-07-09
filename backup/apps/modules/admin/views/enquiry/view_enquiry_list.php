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
                if (is_array($result) && !empty($result)) {
                  echo form_open("wps-admin/enquiry/", 'id="data_form"');
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
                        <th>User Info</th>                    
                        <th>Comments</th>
                        <th>Reply</th>
                        <th>Received Date</th>
                        <th>Status</th>
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
                        <td class="checkbox-column text-left"> 
                            <label class="new-control new-checkbox checkbox-outline-info  m-auto">
                              <input type="checkbox" type="checkbox" name="arr_ids[]" value="<?php echo $res['id']; ?>" class="new-control-input child-chk select-customers-info">
                              <span class="new-control-indicator"></span><span style="visibility:hidden">c</span>
                            </label>                            
                          </td>
                          <td>
                            <?php
                            echo '<b>Name :</b> ' . $res['first_name'] . ' ' . $res['last_name'];
                            ?> 
                            <br>
                            <?php
                            if ($res['mobile_number'] != "" && $res['mobile_number'] != '0') {
                              $address_details[] = "<b>Mobile No. : </b>" . $res['mobile_number'];
                            }
                            if (!empty($address_details)) {
                              echo implode("<br>", $address_details) . "<br />";
                            }
                            echo '<b>Email ID :</b> ' . $res['email'] . '<br />';
                            ?>                            
                          </td>
                          <td>
                            <?php echo html_entity_decode($res['message']); ?>
                          </td>
                          <td>
                            <a href="#" data-toggle="modal" data-target="#reply" onclick="$('.enqName').html('<?php echo $res['first_name'] . ' ' . $res['last_name']; ?>'); $('#to').val('<?php echo $res['email']; ?>');">Reply</a>
                          </td>
                          <td>
                            <?php echo getDateFormat($res['receive_date'], 2); ?>
                          </td>
                          <td><?php echo ($res['status'] == 1) ? "Active" : "In-active"; ?></td>
                        </tr>
                        <?php
                        $sl++;
                      }
                      ?>
                    </tbody>
                  </table>
                  <div class="widget-content widget-content-area text-left split-buttons">
                    <input name="status_action" type="submit"  value="Activate" class="btn btn-success mb-2" id="Activate" onClick="return validcheckstatus('arr_ids[]', 'Activate', 'Record', 'data_form');"/>
                    <input name="status_action" type="submit" class="btn btn-warning mb-2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]', 'Deactivate', 'Record', 'data_form');"/>
                    <input name="status_action" type="submit" class="btn btn-danger mb-2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]', 'Delete', 'Record', 'data_form');"/>
                    <input type="hidden" name="action" id="actionInput" value="" />
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
<div class="modal fade" id="reply" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" name="reply" id="replyForm" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Reply to <span class="enqName"></span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="text" name="to" id="to" readonly placeholder="To" value="" class="form-control" />
          </div>
          <div class="form-group">          
            <input type="text" autocomplete="off" required name="subject" id="subject" placeholder="Subject" value="" class="form-control" />
          </div>
          <div class="form-group">
            <textarea name="reply" autocomplete="off" required id="messageReply" placeholder="Type your reply here.." class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Send Reply</button>
          <button class="btn btn-warning" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- END MAIN CONTAINER -->
<?php $this->load->view('includes/bottom'); ?>
<script type="text/javascript">
  
  //send reply to users
  $('#replyForm').submit(function (e) {
    e.preventDefault();
    var sub = $('#subject').val();
    var msg = $('#messageReply').val();
    var to = $('#to').val();
    if (sub != '' && msg != '') {
      $.post('<?php echo site_url(); ?>wps-admin/enquiry/sendReply', {subject: sub, message: msg, to: to}, function (data) {
        alert(data);
        $('#replyForm')[0].reset();
        $('#reply').modal('hide');
      })
    }
  });
  
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
