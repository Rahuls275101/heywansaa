<?php
$this->load->view("top");
$cart = $this->cart->contents();
$discount_amount = $this->session->userdata('discount_amount');
$posted_data = $this->session->userdata('posted_data');
?>


   <!-- Start of Breadcrumb -->
   <nav class="breadcrumb-nav">
      <div class="container">
         <ul class="breadcrumb bb-no">
            <h1 class="page-title mb-0">Order Review</h1>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li>Order Review</li>
         </ul>
      </div>
   </nav>
   <!-- End of Breadcrumb -->


  <!--<div class="page_breadcrumbs">-->
  <!--      <div class="container">-->
  <!--          <ul>-->
  <!--             <li><a href="<?php echo site_url(); ?>" title="Home">Home</a>-->
  <!--            </li>-->
  <!--            <li>Order Review</li>-->
  <!--          </ul>-->
  <!--      </div>-->
  <!--  </div>-->
  
  
  <section class="checkout_page">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-8  col-xs-12">
          <div class="cart_left">
            <h1>Order Review</h1>
            <div class="panel-group checkout-steps" id="accordion">
              <!-- checkout-step-1  -->
              <section class="panel panel-default checkout-step-01">
                <h4 class="checkout_title">
                <a data-toggle="collapse" class="collapsed"><span>1</span>User Logged In <span class="pull-right"><i class="fa fa-check-square"></i></span></a>
                 </h4>
              </section>
              <!-- checkout-step-02  -->
              <section class="panel panel-default checkout-step-02">
                 <h4 class="checkout_title">
                <a data-toggle="collapse" data-toggle="collapse" class="collapsed">
                 <span>2</span>Delivery Address <span class="pull-right"><i class="fa fa-check-square"></i></span></a></h4>
              </section>
              <!-- checkout-step-03  -->
              <div class="panel panel-default checkout-step-03">
                <h4 class="checkout_title">
                <a data-toggle="collapse" data-toggle="collapse" class="collapsed">
                 <span>3</span>Order Summary </a></h4>
                  <div id="collapseThree" class="panel-collapse collapse in">
                <div class="panel-body">
                  <?php
                  echo form_open('cart/make_payment', 'name="cart_frm" id="cart_frm" ');
                  echo error_message();
                  echo validation_message();
                  ?>
                  <div class="summary">
                    <p class="summary_p">Order confirmation email will be sent to <a href="javascript:void()"><?php echo $this->session->userdata('username'); ?></a></p>

                    <table>
                      <thead>
                        <tr>
                         <th>Product</th>
                   <th class="text-left">Unit Price</th> 
                   <th class="text-center">QTY</th> 
                  <th class="text-center">Total</th>
                        </tr>
                      </thead>
                      <tbody>
                         <?php
                  $totalAmount = $discountAmt = $total_shipping = 0;
                  $i = 1;
                  foreach ($cart as $items) {
                    $link = ($this->session->userdata('user_id') > 0) ? 'href="' . site_url() . 'cart/add_to_wishlist/' . $items['pid'] . '"' : 'href="#" data-toggle="modal" data-target="#log-modal"';
                    $pprice = ($items['discount_price'] > 0) ? $items['discount_price'] : $items['product_price'];
                    $totalAmount += ($pprice * $items['qty']);
                    $discountAmt += $pprice * $items['qty'];
                    $url = $this->db->query("SELECT friendly_url FROM wps_products WHERE products_id = '" . $items['pid'] . "'")->row_array();
                    $amount = $pprice * $items['qty'];
                    ?>
                          <tr>
                  <td data-label="PRODUCT">
                    <div class="cart_image">
                      <a href="<?=$url['friendly_url'];?>" title="<?=$items['origname'];?>">
                        <img src="<?php echo get_image('products', $items['img'], '141', '141', 'R', $url['friendly_url']); ?>" class="product-thumbnail" alt="<?=$items['origname'];?>" title="<?=$items['origname'];?>">
                      </a>
                    </div>
                    <div class="cart_info">
                      <a href="<?=$url['friendly_url'];?>" title="<?=$items['origname'];?>"> <?=$items['origname'];?> </a>
                    </div>
                  </td>
                  <td class="text-center" data-label="UNIT PRICE">
                    <div class="price">₹ <?=$pprice;?></div>
                  </td>
                   <td class="text-center" data-label="QTY">
                    <div class="details_qty">
                        <input type="button" value="" class="minus" onclick="return incDnc(2, <?php echo $i; ?>, <?php echo $items['availableqty']; ?>);" />
                      <input type="text" readonly="readonly" name="<?php echo $i; ?>[qty]" id="qty_<?php echo $i; ?>" value="<?php echo $items['qty']; ?>" class="qty qty_value" maxlength="10">
                      <input type="button" value="" class="plus" onclick="return incDnc(1, <?php echo $i; ?>, <?php echo $items['availableqty']; ?>);" />
                      <input type="hidden" name="<?php echo $i; ?>[rowid]" id='cart_rowid_<?php echo $i; ?>' value="<?php echo $items['rowid']; ?>" />
                    </div>
                  </td>
                  <td class="text-center" data-label="TOTAL">
                    <div class="price"><?php echo display_price($pprice * $items['qty']); ?></div>
                  </td>
                  
                  
                </tr>
                          <?php
                        }
                        ?>

                      </tbody>
                    </table>
                    <a class="checkout_btn" href="<?php echo site_url(); ?>cart/make_payment" title="Pay">Pay <?php $deliveryCharge = delivery_charge(0,$totalAmount); $gst = gst($totalAmount);  echo display_price(($totalAmount - $discount_amount)+$deliveryCharge+$gst); ?></a>
                  </div>
                  <?php echo form_close(); ?>
                </div>
              </div>
            
                
              </div>
              <!-- checkout-step-04  -->
              <div class="panel panel-default checkout-step-04">
                <h4 class="checkout_title">
                <a data-toggle="collapse" class="collapsed">
                <span>4</span>Payment Options</a></h4>
                
              </div>
              <!-- checkout-step-04  -->
            </div>
            <!-- /.checkout-steps -->
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4  col-xs-12">
          <div class="left_title">Cart Details</div>
          <div class="cart_right">
            <table class="table table-totals">
              <tbody>
                 <?php
                  $totalAmount = $discountAmt = $total_shipping = 0;
                  $i = 1;
                  foreach ($cart as $items) {
                    $link = ($this->session->userdata('user_id') > 0) ? 'href="' . site_url() . 'cart/add_to_wishlist/' . $items['pid'] . '"' : 'href="#" data-toggle="modal" data-target="#log-modal"';
                    $pprice = ($items['discount_price'] > 0) ? $items['discount_price'] : $items['product_price'];
                    $totalAmount += ($pprice * $items['qty']);
                    $discountAmt += $pprice * $items['qty'];
                    $url = $this->db->query("SELECT friendly_url FROM wps_products WHERE products_id = '" . $items['pid'] . "'")->row_array();
                      $i++;
}
?>
                <tr>
                  <td>Sub Total</td>
                  <td><?= display_price($totalAmount); ?></td>
                </tr>
                <?php if ($discount_amount > 0) { ?>
                <tr>
                  <td>Discount Price</td>
                  <td>- <?= display_price($discount_amount); ?></td>
                </tr>
              <?php } ?>
                <tr>
                  <td>Delivery Charges</td>
                  <td class="free"><?php $deliveryCharge = delivery_charge(0,$totalAmount); 
                  echo ($deliveryCharge>0)?display_price($deliveryCharge):'Free'; ?></td>
                </tr>
                <tr>
                  <td>GST(18%)</td>
                  <td class="free"><?php $gst = gst($totalAmount); 
                  echo display_price($gst); ?></td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td>Amount Payable</td>
                  <td><?= display_price(($totalAmount - $discount_amount)+$deliveryCharge+$gst); ?></td>
                </tr>
              </tfoot>
            </table>
             <!--  <a class="order_btn" href="javascript:void()" title="Place Order">Place Order</a> -->
            <p class="safe_info"><i class="fa fa-shield"></i> Safe and Secure Payments. Authentic Services.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  
<?php $this->load->view("bottom"); ?>
<script src="<?php echo site_url(); ?>assets/developers/js/common.js"></script> 