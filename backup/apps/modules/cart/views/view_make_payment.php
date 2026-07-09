<?php
$this->load->view("top");
$discountAmt = $discount_amount = $this->session->userdata('discount_amount');
$cart = $this->cart->contents();
$payableAmount = $totalAmount = $origAmount = $discountAmt = $total_shipping = 0;
$i = 1;
foreach ($cart as $items) {
  //trace($items);
  $shipping = 0;
  $url = $this->db->query("SELECT friendly_url FROM wps_products WHERE products_id = '" . $items['pid'] . "'")->row_array();
  $totalAmount += ($items['price'] * $items['qty']);
  $price = $items['price'];
}
//echo $totalAmount." ".$discount_amount;

$deliveryCharge = delivery_charge(0,$totalAmount);
$gst = gst($totalAmount);  
$payableAmount = ($totalAmount - $discount_amount)+$deliveryCharge+$gst;
?>

<!--<div class="page_breadcrumbs">-->
<!--        <div class="container">-->
<!--            <ul>-->
<!--              <li><a href="<?= site_url(); ?>" title="Home">Home</a></li>-->
<!--              <li>Payment Options</li>-->
<!--            </ul>-->
<!--        </div>-->
<!--    </div>-->
    
    <!-- Start of Breadcrumb -->
   <nav class="breadcrumb-nav">
      <div class="container">
         <ul class="breadcrumb bb-no">
            <h1 class="page-title mb-0">Payment Options</h1>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li>Payment Options</li>
         </ul>
      </div>
   </nav>
   <!-- End of Breadcrumb -->   
    
    
<section class="checkout_page">
  <div class="container">
    <div class="row">
      <div class="col-lg-9 col-md-9 col-sm-8  col-xs-12">
        <div class="cart_left">
          <h1>Payment Options</h1>
          <div class="panel-group checkout-steps" id="accordion">

            <!-- checkout-step-1  -->
            <section class="panel panel-default checkout-step-01">
              <h4 class="checkout_title">
                <a data-toggle="collapse"><span>1</span>Login or Signup <span class="pull-right"><i class="fa fa-check-square"></i></span></a>
              </h4>
            </section>

            <!-- checkout-step-02  -->
            <section class="panel panel-default checkout-step-02">
              <h4 class="checkout_title"><a data-toggle="collapse" href="javascript:void(0);"><span>2</span>Delivery Address <span class="pull-right"><i class="fa fa-check-square"></i></span></a></h4>
            </section>

            <!-- checkout-step-03  -->
            <div class="panel panel-default checkout-step-03">
              <h4 class="checkout_title">
                <a class="collapse" href="<?php echo site_url(); ?>cart/view_order_review"><span>3</span>Order Summary <button class="change" style="color: #fff;border: 1px solid #fff;">View Order</button></a>
              </h4>
            </div>

            <!-- checkout-step-04  -->
            <div class="panel panel-default checkout-step-04">
              <h4 class="checkout_title">
                <a data-toggle="collapse" class="collapsed" href="javascript:void(0);">
                  <span>4</span>Payment Options</a></h4>
              <div id="collapseFour" class="panel-collapse collapse in">
                <div class="panel-body">
                  <div class="payment_option">
                    <?php
                    echo form_open('', 'name="payment" id="payment_form" action="post"');
                    ?>
                    
                    
                    
                    <!-- <label class="radio">-->
                    <!--  Credit / Debit / ATM Card-->
                    <!--  <input name="pay" type="radio" value="paytm" class="payone" checked> -->
                    <!--  <span class="checkround"></span>-->
                    <!--</label> -->
                    <!-- <div class="payonediv" hidden="hidden">-->
                    <!--  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>-->
                    <!--  <img src="<?php echo theme_url(); ?>images/ccavenue.png"> -->
                    <!--  <img src="<?php echo theme_url(); ?>images/ccavenue.png"> -->
                    <!--  <img src="<?php echo theme_url(); ?>images/ccavenue.png">-->
                    <!--</div> -->
                    <!-- <label class="radio">PhonePe / BHIM UPI-->
                    <!--  <input name="pay" type="radio" value="paytm" class="paytwo"/>-->
                    <!--  <span class="checkround"></span>-->
                    <!--</label>-->
                    <!--<label class="radio">Net Banking-->
                    <!--  <input type="radio" name="pay" value="paytm" class="paythree">-->
                    <!--  <span class="checkround"></span>-->
                    <!--</label>-->
                    <!-- <label class="radio">Paypal-->
                    <!--  <input type="radio" name="pay" value="Paypal" class="payfour">-->
                    <!--  <span class="checkround"></span>-->
                    <!--</label> -->
                    <!-- <label class="radio">Payu-->
                    <!--  <input type="radio" name="pay" value="Payu" class="payfour" required >-->
                    <!--  <span class="checkround"></span>-->
                    <!--</label>  -->
                   
                   
                   
                   
                    <label class="radio">Cash on Delivery
                      <input type="radio" name="pay" value="COD" class="payfive" required checked>
                      <span class="checkround"></span>
                    </label>
                    <input type="hidden" name="amount" value="<?php echo $payableAmount; ?>" />
                    <input type="hidden" name="firstname" value="<?php echo $posted_data['name']; ?>" />
                    <input type="hidden" name="email" value="<?php if ($this->session->userdata('user_id') > 0) { echo $this->session->userdata['username']; } else { echo $this->session->userdata['username']; } ?>" />
                    <input type="hidden" name="phone" value="<?php echo $posted_data['mobile']; ?>" />
                    <button class="confrmorder" type="submit" name="confrmorder">Pay <?php echo display_price($payableAmount); ?></button>
                    <?php echo form_close(); ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- checkout-step-04  -->

          </div>
          <!-- /.checkout-steps -->
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-4  col-xs-12">
        <div class="left_title">Cart Details</div>
        <div class="cart_right">
          <table id="table-breakpoint" class="table table-totals">
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
                  <td class="free"><?php 
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
          <p class="safe_info"><i class="fa fa-shield"></i> Safe and Secure Payments. 100% Authentic Products.</p>
        </div>
      </div>

    </div>
  </div>    
</section>
<script type="text/javascript">
  $(document).ready(function () {
    /*$(".payfour").click(function () {
      $(".payonediv").hide();
      $(".paytwodiv").hide();
      $(".paythreediv").hide();
      $(".payfourdiv").show();
    });
    $('.payButton').click(function (e) {
      e.preventDefault();
      if ($("#checkTerms").is(':checked')) {
        $('#payment_form').submit();
      } else {
        alert('Please Check to agree Curwish Terms & Conditions.');
      }
    });*/
  });  
</script>
<?php $this->load->view("bottom"); ?>