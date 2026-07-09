<?php
$this->load->view("top");
$values_posted_back = (is_array($this->input->post())) ? TRUE : FALSE;
$is_same = $values_posted_back === TRUE ? $this->input->post('is_same') : '';
$titleArray = $this->config->item('titleArray');
$discount_amount = $this->session->userdata('discount_amount'); 
$cart = $this->cart->contents(); 
$posted_data = $this->session->userdata('posted_data');
//trace($this->session->userdata('posted_data'));
?>


  <!--<div class="page_breadcrumbs">-->
  <!--      <div class="container">-->
  <!--          <ul>-->
  <!--            <li><a href="<?= site_url(); ?>" title="Home">Home</a></li>-->
  <!--            <li>Confirm Address</li>-->
  <!--          </ul>-->
  <!--      </div>-->
  <!--  </div>-->
    
    
     <!-- Start of Breadcrumb -->
   <nav class="breadcrumb-nav">
      <div class="container">
         <ul class="breadcrumb bb-no">
            <h1 class="page-title mb-0">Confirm Address</h1>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li>Confirm Address</li>
         </ul>
      </div>
   </nav>
   <!-- End of Breadcrumb -->  
    
  <section class="checkout_page">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-8  col-xs-12">
          <div class="cart_left">
            <h1>Confirm Address</h1>
            <div class="panel-group checkout-steps" id="accordion">
              <!-- checkout-step-1  -->
              <section class="panel panel-default checkout-step-01">
                <h4 class="checkout_title">
                <a data-toggle="collapse" class="collapsed"><span>1</span>User Logged In <span class="pull-right"><i class="fa fa-check-square"></i></span></a>
                 </h4>
              </section>
              <!-- checkout-step-02  -->
              <section class="panel panel-default checkout-step-02">
                <h4 class="checkout_title"><a data-toggle="collapse" class="collapsed"><span>2</span>Enter Address </a></h4>
                <div id="collapseTwo" class="panel-collapse collapse in">
                <div class="panel-body">
                  <div class="edit_address">
                    <?php
                    echo form_open('cart/delivery_info', 'id="deliveryForm"');
                    echo error_message();
                    echo validation_message();
                    ?>
                   <h5>Shipping Address</h5>
                        <div class="row">
                          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                              <label class="info_title">Select Title <span>*</span>
                              </label>
                          <select name="mtitle" class="form-control" onchange="ChangeBill(this.form);" required>
                            <option value="">Select Title</option>
                            <?php
                            foreach ($titleArray as $tk => $tval) {
                              if($posted_data['mtitle']!=''){
                                 $sel = ($posted_data['mtitle'] == $tk) ? 'selected' : '';
                              }else{
                                $sel = ($mres['mtitle'] == $tk) ? 'selected' : '';
                              }
                              ?>
                              <option value="<?php echo $tk; ?>" <?php echo $sel; ?>><?php echo $tval; ?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                              <label class="info_title">Full Name <span>*</span>
                              </label>
                          <input type="text" name="ship_name" placeholder="Full Name*"  value="<?=($posted_data['name']!='')?$posted_data['name']:$mres['name']; ?>" class="form-control" required onchange="ChangeBill(this.form);" />
                        </div>
                      </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                              <label class="info_title">Mobile Number <span>*</span>
                              </label>
                          <input type="tel" minlength="10" maxlength="20" name="ship_mobile" placeholder="Mobile Number*" value="<?=($posted_data['mobile']!='')?$posted_data['mobile']:$mres['mobile']; ?>" class="form-control" required  onkeypress="return isNumberKey(event)" onchange="ChangeBill(this.form);" />
                        </div>
                      </div>
                       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label class="info_title">Your Address <span>*</span>
                              </label>
                          <textarea name="ship_address" cols="1"  placeholder="Address Details*" rows="3"  class="form-control unicase-form-control" required onchange="ChangeBill(this.form);"><?=($posted_data['address']!='')?$posted_data['address']:$mres['address']; ?></textarea>
                        </div>
                      </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <label class="info_title">Landmark <span>*</span>
                              </label>
                          <input type="text" name="ship_lmark" value="<?=($posted_data['landmark']!='')?$posted_data['landmark']:$mres['landmark']; ?>" placeholder="Landmark" class="form-control" onchange="ChangeBill(this.form);" />
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                        <label class="info_title">City <span>*</span>
                              </label>
                          <input type="text" name="ship_city" value="<?php echo $mres['city']; ?>" placeholder="City*" class="form-control" onchange="ChangeBill(this.form);" required/>
                        </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                        <label class="info_title">Pincode <span>*</span>
                              </label>
                          <input type="text" name="ship_pin" value="<?php echo $mres['zipcode']; ?>" placeholder="Pincode*" onchange="ChangeBill(this.form);" class="form-control" required onkeypress="return isNumberKey(event)" />
                        </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                        <label class="info_title">State <span>*</span>
                              </label>
                          <input type="text" name="ship_state" placeholder="State*" value="<?php echo $mres['state']; ?>" onchange="ChangeBill(this.form);" class="form-control" required />
                        </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                        <label class="info_title">Country <span>*</span>
                              </label>
                          <?php echo CountrySelectBox(array("name" => "ship_country", 'current_selected_val' => $mres['country'], "format" => 'class="form-control unicase-form-control text-input" required onchange="ChangeBill(this.form);"')); ?>
                        </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                          <textarea name="last_shopping_comment" cols="1" placeholder="Comments" rows="3" class="form-control unicase-form-control"><?php echo $mres['last_shopping_comment']; ?></textarea>
                        </div>
                      </div>
                      </div>
                      <div class="row">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <h5>Billing Address </h5>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><span class="pull-right"> <input id="check_add" name="check_add" value="1" onclick="Check_Bill_Ship(this.form);" type="checkbox" class="isCheck" checked="checked" style="height: 12px;">
                          <label for="check_add">Same as Shipping address</label> </span>
                          </div>
                        </div>
                      <div class="row billingAd">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                              <label class="info_title">Select Title <span>*</span>
                              </label>
                          <select name="bmtitle" class="form-control" required>
                            <option value="">Select Title</option>
                            <?php
                            foreach ($titleArray as $tk => $tval) {
                              if($posted_data['bmtitle']!=''){
                                 $sel1 = ($posted_data['bmtitle'] == $tk) ? 'selected' : '';
                              }else{
                                $sel1 = ($mres['bmtitle'] == $tk) ? 'selected' : '';
                              }
                              ?>
                              <option value="<?php echo $tk; ?>" <?php echo $sel1; ?>><?php echo $tval; ?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                              <label class="info_title">Full Name <span>*</span>
                              </label>
                          <input type="text" name="bil_name" placeholder="Full Name*"  value="<?=($posted_data['bil_name']!='')?$posted_data['bil_name']:$mres['bil_name']; ?>" class="form-control" required />
                        </div>
                      </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                              <label class="info_title">Mobile Number <span>*</span>
                              </label>
                          <input type="tel" minlength="10" maxlength="20" name="bil_mobile" value="<?=($posted_data['bil_mobile']!='')?$posted_data['bil_mobile']:$mres['bil_mobile']; ?>" placeholder="Mobile Number*" class="form-control" required  onkeypress="return isNumberKey(event)" />
                        </div>
                      </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label class="info_title">Your Address <span>*</span>
                              </label>
                          <textarea name="bil_address" cols="1" placeholder="Address Details*" rows="3" class="form-control unicase-form-control" required><?=($posted_data['bil_address']!='')?$posted_data['bil_address']:$mres['bil_address']; ?></textarea>
                        </div>
                      </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <label class="info_title">Landmark <span>*</span>
                              </label>
                          <input type="text" name="bil_lmark" value="<?=($posted_data['bil_landmark']!='')?$posted_data['bil_landmark']:$mres['bil_landmark']; ?>" placeholder="Landmark" class="form-control"/>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                        <label class="info_title">City <span>*</span>
                              </label>
                          <input type="text" name="bil_city" value="<?php echo $mres['bil_city']; ?>" placeholder="City*" class="form-control" required />
                        </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                        <label class="info_title">Pincode <span>*</span>
                              </label>
                          <input type="text" name="bil_pin" value="<?php echo $mres['bil_zipcode']; ?>" placeholder="Pincode*" class="form-control" onkeypress="return isNumberKey(event)" required />
                        </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                        <label class="info_title">State <span>*</span>
                              </label>
                          <input type="text" name="bil_state" value="<?php echo $mres['bil_state']; ?>" placeholder="State*" class="form-control" required />
                        </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="info_title">Country <span>*</span>
                              </label>
                              <select name="bil_country" class="form-control unicase-form-control text-input">
                                  <option>India</option>
                              </select>
                          <?php //echo CountrySelectBox(array("name" => "bil_country", 'current_selected_val' => $mres['bil_country'], "format" => 'class="form-control unicase-form-control text-input" required')); ?>
                        </div>
                       </div>
                      </div>

                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                          
                          <button class="checkout_btn pull-right" type="submit" name="submit">Checkout</button>
                        </div>
                      </div>
                    <?php echo form_close(); ?>
                  </div>
                </div>
              </div>
              </section>
              <!-- checkout-step-03  -->
              <div class="panel panel-default checkout-step-03">
                <h4 class="checkout_title">
                <a data-toggle="collapse" data-toggle="collapse" class="collapsed">
                 <span>3</span>Order Summary <!-- <button class="change">View Order Summary</button> --></a></h4>
                
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
             <?php  
                  $deliveryCharge = delivery_charge(0,$totalAmount);  ?>
                <tr>
                  <td>Delivery Charges</td>
                  <td class="free"><?php  echo ($deliveryCharge>0)?display_price($deliveryCharge):'Free'; ?></td>
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
                  <td><?= display_price(($totalAmount-$discount_amount)+$deliveryCharge+$gst); ?></td>
                </tr>
              </tfoot>
            
            </table>
              <!-- <a class="order_btn" href="javascript:void()" title="Place Order">Place Order</a> -->
            <p class="safe_info"><i class="fa fa-shield"></i> Safe and Secure Payments. 100% Authentic Services.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  
<?php $this->load->view("bottom"); ?>
<script type="text/javascript">
  function Check_Bill_Ship(chk) {
     console.log(chk.check_add.checked);
    if (chk.check_add.checked == 1) {
     
      chk.bmtitle.value = chk.mtitle.value;
      chk.bil_name.value = chk.ship_name.value;
      chk.bil_mobile.value = chk.ship_mobile.value;
      chk.bil_address.value = chk.ship_address.value;
      chk.bil_lmark.value = chk.ship_lmark.value;
      chk.bil_city.value = chk.ship_city.value;
      chk.bil_pin.value = chk.ship_pin.value;
      chk.bil_state.value = chk.ship_state.value;
      chk.bil_city.value = chk.ship_city.options[chk.ship_city.selectedIndex].value;
    }
    if (chk.check_add.checked == 0) {
      chk.bmtitle.value = '';
      chk.bil_name.value = '';
      chk.bil_mobile.value = '';
      chk.bil_address.value = '';
      chk.bil_lmark.value = '';
      chk.bil_city.value = '';
     chk.bil_pin.value = '';
      chk.bil_state.value = '';
      chk.bil_city.value = chk.ship_city.options[0].value;
    }
  }
</script>

<script type="text/javascript">
  $(".billingAd").hide();
  $(".isCheck").click(function () {
    if ($(this).is(":checked")) {
      $(".billingAd").hide();
    } else {
      $(".billingAd").show();
    }
  });


  function ChangeBill(chk) {
     chk.bmtitle.value = chk.mtitle.value;
    chk.bil_name.value = chk.ship_name.value;
    chk.bil_mobile.value = chk.ship_mobile.value;
    chk.bil_address.value = chk.ship_address.value;
    chk.bil_lmark.value = chk.ship_lmark.value;
    chk.bil_city.value = chk.ship_city.value;
    chk.bil_pin.value = chk.ship_pin.value;
    chk.bil_state.value = chk.ship_state.value;
    chk.bil_country.value = chk.ship_country.options[chk.ship_country.selectedIndex].value;
  }
</script>
 
