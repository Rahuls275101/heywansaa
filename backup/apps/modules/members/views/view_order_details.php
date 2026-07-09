<?php
$this->load->view("top");
$countRows = count_record("wps_orders_products", "order_id = '" . $order_res['order_id'] . "' ");
$orderDets = $this->order_model->get_order_detail($order_res['order_id']);
$orderDetail = $this->db->query("select * from wps_order where order_id=".$order_res['order_id']."")->row_array();
//trace($orderDetail);
?>
<!--<div class="page_breadcrumbs">-->
<!--		<div class="container">-->
<!--			<ul>-->
<!--            <li><a href="<?=site_url();?>" title="Home">Home</a></li>-->
<!--            <li><a href="<?=base_url('my-account');?>" title="My Account">My Account</a></li>-->
<!--            <li><a href="<?=base_url('my-orders');?>" title="My Orders">My Orders</a></li>-->
<!--            <li>Order Details</li>-->
<!--			</ul>-->
<!--		</div>-->
<!--	</div>-->
	
   <!-- Start of Breadcrumb -->
   <nav class="breadcrumb-nav">
      <div class="container">
         <ul class="breadcrumb bb-no">
            <h1 class="page-title mb-0">Order Details</h1>
            <li><a href="<?=site_url();?>" title="Home">Home</a></li>
            <li><a href="<?=base_url('my-account');?>" title="My Account">My Account</a></li>
            <li><a href="<?=base_url('my-orders');?>" title="My Orders">My Orders</a></li>
            <li>Order Details</li>
         </ul>
      </div>
   </nav>
   <!-- End of Breadcrumb -->
   
  
  <section class="track_page">
    <div class="container">
      <div class="">
        <div class="col-md-12">
          <div class="wps_right track_info" style="background: white;">
            <div class="row">
              <div class="col-lg-7 col-md-7">
                <div class="delivery_address_track">
                  <h1>Delivery Address</h1>
                  <h2><?php echo $orderDetail['first_name']; ?></h2>
                  <p><?php echo $orderDetail['shipping_address']; ?>, <?php echo $orderDetail['shipping_city']; ?> - <?php echo $orderDetail['shipping_zipcode']; ?><br/>
                  <?php echo $orderDetail['shipping_state']; ?> - <?php echo $orderDetail['shipping_country']; ?><br/>
                   Landmark: <?php echo $orderDetail['shipping_landmark']; ?>
                    <br>
                    <strong>Phone</strong>: <?php echo $orderDetail['shipping_phone']; ?></p>
                </div>
              </div>
              <div class="col-lg-5 col-md-5">
                <div class="more_track">
                  <h2>Order Detail</h2>
                  <p>Order ID: <?php echo $orderDetail['invoice_number']; ?> <a class="request_invoice" href="javascript:void(0);">Placed on <?php echo getDateFormat($order_res['order_received_date'], 6); ?></a>
                  </p>
                 
                </div>
              </div>
            </div>
          </div>
          <div class=" process">
            <?php if (is_array($orderDets) && !empty($orderDets)) { ?>
            <div class="row">
              <div class="col-lg-5 col-md-5">
                <div class="process_left">
                   <?php 
            foreach ($orderDets as $o => $pageVal) {
              $furl = get_db_field_value("wps_products", "friendly_url", "WHERE products_id = '" . $pageVal['products_id'] . "'");
              $img = get_db_field_value("wps_products_media", "media", "WHERE products_id = '" . $pageVal['products_id'] . "'");
              $productName = get_db_field_value("wps_products", "product_name", "WHERE products_id = '" . $pageVal['products_id'] . "'");
              ?>
                  <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                      <a href="javascript:void()">
                        <img src="<?php echo get_image('products', $img, '120', '120', 'R'); ?>" alt="<?php echo $productName; ?>" title="<?php echo $productName; ?>">
                      </a>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                      <div class="order_info">
                        <a href="javascript:void()" title="<?php echo $productName; ?>"><?php echo $productName; ?></a>
                        <p></p>
                        <strong><?php echo display_price($pageVal['product_price']*$pageVal['quantity']); ?> </strong>
                      </div>
                    </div>
                  </div>
                <?php } ?>
                </div>
              </div>
              <div class="col-lg-4 col-md-4">
                <div class="deliver_process">
                   <span class="delHead"> Your Order Status: 
              <?php if($orderDetail['order_status']=='0'){
                echo 'Order Placed';
              }elseif($orderDetail['order_status']=='1'){
                 echo '<strong>Order Confirmed on dated '. getDateFormat($orderDetail['order_confirmed_date'], 6).'</strong>';
              }elseif($orderDetail['order_status']=='2'){
                echo '<strong>Order Dispatched on dated '. getDateFormat($orderDetail['order_dispatched_date'], 6).'</strong>';
              }elseif($orderDetail['order_status']=='3'){
                 echo '<strong>In Transit on dated '. getDateFormat($orderDetail['order_in_transit_date'], 6).'</strong>';
              }elseif($orderDetail['order_status']=='4'){
                 echo '<strong>Out for delivery on dated '. getDateFormat($orderDetail['order_out_for_delivery_date'], 6).'</strong>';
              }elseif($orderDetail['order_status']=='5'){
                echo '<strong>Cancelled on dated '. getDateFormat($orderDetail['order_cancelled_date'], 6).'</strong>';
              }elseif($orderDetail['order_status']=='6'){
                 echo '<strong>Returned on dated '. getDateFormat($orderDetail['order_returned_date'], 6).'</strong>';
              }elseif($orderDetail['order_status']=='7'){
                 echo '<strong>Request for Return on dated '. getDateFormat($orderDetail['order_request_for_return_date'], 6).'</strong>';
              }elseif($orderDetail['order_status']=='8'){
                echo '<strong>Delivered on dated '. getDateFormat($orderDetail['order_delivery_date'], 6).'</strong>';
              } ?>
                
              </span>
                  <!-- <ul class="progressbar">
                    <li class="active">Ordered
                      <div class="process_dec">
                        <p><span>Wed, 20 May 08:00 pm</span>
                          <br>Payment approved</p>
                        <p><span>Wed, 20 May 10:08 pm</span>
                          <br>Seller has processed your order.</p>
                      </div>
                    </li>
                    <li class="active">Packed
                      <div class="process_dec">
                        <p><span>Your item has been picked up by courier partner.</span>
                        </p>
                        <p><span>Wed, 20 May 11:07 pm</span> Item has been dispatched from the seller warehouse</p>
                      </div>
                    </li>
                    <li class="active">Shipped
                      <div class="process_dec">
                        <p><span>Thu, 21 May 01:13 pm</span>
                          <br>Your item is out for delivery Ecom Express - 0987654321</p>
                      </div>
                    </li>
                    <li class="active">Delivered
                      <div class="process_dec">
                        <p><span>Fri, 22 May 04:15 pm</span>
                          <br>Your item has been delivered</p>
                      </div>
                    </li>
                  </ul> -->
                </div>
              </div>
              <!-- <div class="col-lg-3 col-md-3">
                <div class="deliver_righ_info">
                  <h4>Delivered on Fri, May 22' 2020</h4>
                  <a class="review_product" href="review.html" title="Rate &amp; Review Product"><i class="fa fa-star"></i> Rate &amp; Review</a>  <a href="customer-support.php" title="Need Help"><i class="fa fa-question"></i> Need Help</a>
                </div>
              </div> -->
            </div>
          <?php } ?>
          </div>
          <div class="track_footer">Shipping Amount <?=display_price($orderDetail['shipping_amount']);?><br/>
          GST <?=display_price($orderDetail['vat_amount']);?><br/>
          Total <?=display_price($orderDetail['total_amount']+$orderDetail['vat_amount']);?></div>
        </div>
      </div>
    </div>
  </section>
 

<?php $this->load->view("bottom"); ?>