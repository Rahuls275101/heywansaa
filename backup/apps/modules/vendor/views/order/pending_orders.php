<?php
$this->load->view('includes/top');
$orderStatus = $this->config->item('orderStatus');
 $vendor_id=$this->session->userdata('admin_id');
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
                        
                        <th>Invoice Number</th>
                        <th>Vendor</th>
                         <th>AWB.No.</th>
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
                           
                          <td class="left"><strong><?php echo $pageVal['invoice_number']; ?></strong><br />
                            <?php echo $pageVal['order_received_date'];  ?><br />
                            <?php echo $pageVal['first_name']; ?> <?php echo $pageVal['last_name']; ?> <br />
                            <?php echo $pageVal['billing_phone']; ?><br />
                            <?php echo $pageVal['email']; ?> <br />    
                            <strong><a href="<?php echo site_url(); ?>wps-vendor/orders/vieworder/<?php echo $pageVal['order_id']; ?>" target="_blank" class="view_btn"><i class="fa fa-eye"></i> View Order</a></strong>
                          </td>
                          
                          
                          
                   <td> 

<?php   //echo $pageVal['order_id'];

    $ordDetails = $this->db->query("SELECT vadmin.`name` AS vendor_name,vadmin.admin_id as vendor_id,sub_order_id FROM wps_orders_products AS ordp
LEFT JOIN wps_admin AS vadmin ON ordp.vendor_id=vadmin.admin_id
WHERE order_id = '" . $pageVal['order_id'] . "' and vendor_id = '" .$vendor_id. "' GROUP BY vadmin.admin_id")->result_array();

    //$data['ordmaster'] = $ordmaster;
   // $data['ordDetails'] = $ordDetails;
   $i=0;
 
 foreach($ordDetails as $ordv)
 {
// print_r($ordv['vendor_id']);
 ?>
 
<div class="badge outline-badge-warning"> 
<strong style="color:#E9857A"> <?php echo $i+1; ?>.</strong><a target="_blank" href="<?php echo site_url(); ?>wps-admin/orders/vieworderbyvendor/<?php echo $pageVal['order_id']; ?>/<?php echo $ordv['vendor_id']; ?>">

<?php echo ucfirst($ordDetails[$i]['vendor_name']); ?><br />
<span style="color:#FF0000"><?php echo $ordDetails[$i]['sub_order_id']; ?></span>

</a>
</div>

<br /><br />

 <?php $i++; } ?>
</td>


<td>


<?php   //echo $pageVal['order_id'];

    $ordDetails = $this->db->query("SELECT vadmin.`name` AS vendor_name,vadmin.admin_id as vendor_id,sub_order_id,ecomm_awb_number FROM wps_orders_products AS ordp
LEFT JOIN wps_admin AS vadmin ON ordp.vendor_id=vadmin.admin_id
WHERE order_id = '" . $pageVal['order_id'] . "' and vendor_id = '" .$vendor_id. "' GROUP BY vadmin.admin_id")->result_array();

    //$data['ordmaster'] = $ordmaster;
   // $data['ordDetails'] = $ordDetails;
   $i=0;
 
 foreach($ordDetails as $ordv)
 {
// print_r($ordv['vendor_id']);
if($ordDetails[$i]['ecomm_awb_number']!="")
{
 ?>

<a target="_blank" class="badge outline-badge-success" href="https://ecomexpress.in/tracking/?awb_field=<?php echo $ordDetails[$i]['ecomm_awb_number']; ?>">
<?php echo $ordDetails[$i]['ecomm_awb_number']; ?>
</a>
<!-- <a class="badge outline-badge-success" target="_blank" href="<?php // echo site_url(); ?>wps-admin/orders/viewuploadedorder/<?php //echo $ordDetails[$i]['ecomm_awb_number']; ?>">
<?php //echo $ordDetails[$i]['ecomm_awb_number']; ?>
</a> -->

<br /><br />

 <?php } $i++; } ?>

</td>       
                          
                          
                          
                          
                          <td><?php echo display_price($pageVal['total_amount']); ?></td>
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
