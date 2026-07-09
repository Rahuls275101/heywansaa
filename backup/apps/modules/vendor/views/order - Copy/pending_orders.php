<?php
$this->load->view('includes/top');
$orderStatus = $this->config->item('orderStatus');

?>
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
                if (is_array($res) && !empty($res)) {
                  echo form_open("", 'id="data_form"');
                  ?>
                  <table id="" class="table  table-hover">
                    <thead>
                      <tr>
                        <th class="checkbox-column text-left">
                          #
                        </th>
                        <th>Invoice Number</th>
                        <th>Amount</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>                        
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

                      foreach ($res as $pageVal) {
                          if($pageVal['order_status']=='0')
                          {
                        ?> 
                        <tr>
                          <td class="checkbox-column text-left">
                            <?php //echo $pageVal['order_id']; ?>
                            <label class="new-control new-checkbox checkbox-outline-info  m-auto">
                              <input type="checkbox" type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['order_id'];  ?>" class="new-control-input child-chk select-customers-info">
                              <span class="new-control-indicator"></span><span style="visibility:hidden">c</span>
                            </label>
                          </td>
                          <td class="left"><strong><?php echo $pageVal['invoice_number']; ?></strong><br />
                            <?php echo $pageVal['order_received_date'];  ?><br />
                            <?php echo $pageVal['first_name']; ?> <?php echo $pageVal['last_name']; ?> <br />
                            <?php echo $pageVal['billing_phone']; ?><br />
                            <?php echo $pageVal['email']; ?> <br />    
                            <strong><a href="<?php echo site_url(); ?>wps-vendor/orders/vieworder/<?php echo $pageVal['order_id']; ?>" target="_blank" class="view_btn"><i class="fa fa-eye"></i> View Order</a></strong>
                          </td>
                          <td><?php echo display_price($pageVal['product_price']+$pageVal['vat_amount']); ?></td>
                          <td align="left">
                            <?php
                            if ($pageVal['payment_status'] == 'Paid') {
                              ?>
                              <span class="badge outline-badge-success">Paid</span>
                              <?php
                            } else {
                              ?>
                              <span class="badge outline-badge-danger">Unpaid</span>
                              <?php
                            }
                            ?>

                            <br />
                            <?php
                            if ($pageVal['payment_status'] == 'Unpaid') {
                              ?>
                              <strong><a onclick="return confirm('Are you sure you want to make this order paid');" href="<?php echo base_url(); ?>wps-admin/orders/make_paid/<?php echo $pageVal['order_id']; ?>" >Mark as Paid</a></strong>
                              <?php
                            }
                            ?>
                            <br /><br />
                            <strong>Payment Method : </strong><?php echo $pageVal['payment_method']; ?>
                          </td>
                          <td class="left">
                            <?php
                            foreach ($status_array as $key => $status) {
                              if ($key == $pageVal['order_status']) {
                                echo $status['status_title'];
                                ?> <br /><br />
                                <strong><?php echo $status['date_title'] ?>: </strong><?php echo getDateFormat($pageVal[$status['status_date']], 2); ?><br /><br />
                                <?php
                              }
                            }
                            ?>
                          </td>
                        </tr>
                        <?php
                        $sl++;
                      }
                      }
                      ?>
                    </tbody>
                  </table>
                  <?php
               //   if ($this->router->fetch_method() == 'index' ) {
            if ($this->router->fetch_method() == 'index' || true) {
                ?>
                <table class="list" width="100%">
                  <tr><td align="right"><?php echo $links; ?></td></tr>
                  <tr>
                    <td align="left" style="padding:2px">
                      <input name="unset_as" type="submit" class="btn btn-warning mb-2" value="Unpaid" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]', 'Set Unpaid', 'Record', 'u_status_arr[]', 'data_form');"/>
                      <!-- <input name="Delete" type="submit" class="btn btn-danger mb-2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]', 'delete', 'Record', 'data_form');"/> -->
                      <select style="width:160px;height: 35px;border-radius: 6px;" name="ord_status"   onchange="return validcheckstatus('arr_ids[]', 'ord_status', 'Record', 'data_form');">
                        <option value="" >Update Order Status</option>                      
                        <option value="1" >Order Confirmed</option>
                        <option value="2">Dispatched</option>
                        <option value="3">In Transit </option>
                        <option value="4">Out for Delivery</option>
                        <option value="5">Canceled</option>
                        <option value="6">Returned </option>
                        <option value="7">Request for Return</option>
                        <option value="8">Delivered</option>
                      </select>
                    </td>
                  </tr>
                </table>
                <?php
              } ?>
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
