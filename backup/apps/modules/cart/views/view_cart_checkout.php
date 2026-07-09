<?php
    $this->load->view("top");
    $values_posted_back = (is_array($this->input->post())) ? TRUE : FALSE;
    $is_same = $values_posted_back === TRUE ? $this->input->post('is_same') : '';
    $discount_amount = $this->session->userdata('discount_amount');
    $cart = $this->cart->contents();



    $uyser_id=  $this->session->userdata('user_id');

        if($uyser_id)
        {
    $ship_addr=$this->db->query("select * from wps_customers_address_book where customer_id='$uyser_id' and address_type='Ship' ")->result_array();
    $ship_addr=$ship_addr[0];
        
    $bill_addr=$this->db->query("select * from wps_customers_address_book where customer_id='$uyser_id' and address_type='Bill' ")->result_array();
    $bill_addr=$bill_addr[0];
    }
        // print_r($bill_addr);die;
?>

        <main class="main checkout">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb shop-breadcrumb bb-no">
                        <!--<h1 class="page-title mb-0">Order Complete</h1>-->
                        <li><a href="<?php echo  base_url().'cart'; ?>">Shopping Cart</a></li>
                        <li class="active"><a href="<?php echo  base_url().'checkout'; ?>">Checkout</a></li>
                        <li><a href="<?php echo  base_url().'my-orders'; ?>">Order Complete</a></li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->


            <!-- Start of PageContent -->
            <div class="page-content">
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-11">
                    
                     <?php
                    echo form_open('cart/delivery_info', 'id="deliveryForm"','class="login-content"');
                    echo error_message();
                    echo validation_message();
                    ?>
                        <p>If you have shopped with us before, please enter your details below. 
                            If you are a new customer, please proceed to the Billing section.</p>
                            
                            <?php $posted_data = $this->session->userdata('posted_data'); print_r($posted_data); ?>
                      
                        <div class="row">
                            <!--<div class="col-lg-8 pr-lg-4 mb-4 <?php  if(!$this->session->userdata('user_id')){ echo "d-none"; } ?>">-->
                             <div class="col-lg-8 pr-lg-4 mb-4 <?php // if(!$this->session->userdata('user_id')){ echo "d-none"; } ?>">
                                <h3 class="title billing-title text-uppercase ls-10 pt-1 pb-3 mb-0">
                                    Billing Details
                                </h3>
                                
                                <div class="row gutter-sm">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Name *</label>
                                            <input type="text" class="form-control form-control-md" name="first_name" value="<?php if(isset($bill_addr)){echo $bill_addr['first_name'];} ?>"
                                                required>
                                        </div>
                                    </div>
                                    <!--<div class="col-lg-6 col-xs-6">-->
                                    <!--    <div class="form-group">-->
                                    <!--        <label>Last name *</label>-->
                                    <!--        <input type="text" class="form-control form-control-md" name="last_name" value="<?php if(isset($bill_addr)){ echo $bill_addr['last_name'];}?>"-->
                                    <!--            required>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                </div>
                                <!-- <div class="form-group">
                                    <label>Company name (optional)</label>
                                    <input type="text" class="form-control form-control-md" name="company-name">
                                </div> -->
                                <div class="form-group">
                                    <label>Country*</label>
                                    <div class="select-box">
                                        <select name="country" class="form-control form-control-md">
                                          
                                            <option  selected="selected">India</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Address *</label>
                                    <input type="text" placeholder="House number and street name"
                                        class="form-control form-control-md mb-2" name="address" value="<?php if(isset($bill_addr)){ echo $bill_addr['address'];}?>"required>
                                    <input type="text" placeholder="Landmark"
                                        class="form-control form-control-md" name="landmark" value="<?php if(isset($bill_addr)){ echo $bill_addr['landmark'];}?>"required>
                                </div>
                                <div class="row gutter-sm">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>City *</label>
                                            <input type="text" class="form-control form-control-md" name="city" value="<?php if(isset($bill_addr)){ echo $bill_addr['city'];}?>"required>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label>Pincode *</label>
                                            <input type="text" class="form-control form-control-md" name="zip" required>
                                        </div> -->
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>State *</label>
                                            <div class="select-box">
                                                <select name="state" class="form-control form-control-md">
                                                    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                    <option value="Assam">Assam</option>
                                                    <option value="Bihar">Bihar</option>
                                                    <option value="Chandigarh">Chandigarh</option>
                                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                                    <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                                                    <option value="Daman and Diu">Daman and Diu</option>
                                                    <option value="Delhi">Delhi</option>
                                                    <option value="Goa">Goa</option>
                                                    <option value="Gujarat">Gujarat</option>
                                                    <option value="Haryana">Haryana</option>
                                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                    <option value="Jharkhand">Jharkhand</option>
                                                    <option value="Karnataka">Karnataka</option>
                                                    <option value="Kerala">Kerala</option>
                                                    <option value="Lakshadweep">Lakshadweep</option>
                                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                    <option value="Maharashtra">Maharashtra</option>
                                                    <option value="Manipur">Manipur</option>
                                                    <option value="Meghalaya">Meghalaya</option>
                                                    <option value="Mizoram">Mizoram</option>
                                                    <option value="Nagaland">Nagaland</option>
                                                    <option value="Orissa">Orissa</option>
                                                    <option value="Pondicherry">Pondicherry</option>
                                                    <option value="Punjab">Punjab</option>
                                                    <option value="Rajasthan">Rajasthan</option>
                                                    <option value="Sikkim">Sikkim</option>
                                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                                    <option value="Tripura">Tripura</option>
                                                    <option value="Uttaranchal">Uttaranchal</option>
                                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                    <option value="West Bengal">West Bengal</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Pincode *</label>
                                            <input type="text" class="form-control form-control-md" name="zipcode"value="<?php if(isset($bill_addr)){ echo $bill_addr['zipcode'];}?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Phone *</label>
                                            <input type="text" class="form-control form-control-md" name="mobile" maxlength="10" value="<?php if(isset($bill_addr)){ echo $bill_addr['mobile'];}?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-7">
                                            <label>Email address *</label>
                                            <input type="email" class="form-control form-control-md" name="email"value="<?php if(isset($bill_addr)){ echo $bill_addr['email'];}?>" required>
                                        </div>
                                    </div>
                                </div>
                               
                              
                               <input type="checkbox" class="" onclick="Check_Bill_Ship(this.form);"  id="check_add" name="check_add" value="1" >
                                 <span class="text-warning" style="font-size:18px; color:#f84f29;font-weight: 600;">Shipping Same as Billing</span>
                               <!--<div class="form-group checkbox-toggle pb-2" onclick="">-->
                                    
                                        <!--<input id="check_add" name="check_add" value="1" onclick="Check_Bill_Ship(this.form);" type="checkbox" class="isCheck" style="height: 12px;">-->
                                    <!--<label for="shipping-toggle">Ship to a different address?</label>-->
                                <!--</div>-->
                                <div class="checkbox-content">
                                    <div class="row gutter-sm">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Name *</label>
                                                <input type="text" required class="form-control form-control-md" value="<?php if(isset($ship_addr)){ echo $ship_addr['first_name'];}?>" name="ship_first_name">
                                            </div>
                                        </div>
                                        <!--<div class="col-lg-6 col-xs-6">-->
                                        <!--    <div class="form-group">-->
                                        <!--        <label>Last name *</label>-->
                                        <!--        <input type="text" required class="form-control form-control-md" value="<?php  if(isset($ship_addr)){  echo $ship_addr['last_name'];}?>" name="ship_last_name"-->
                                        <!--            >-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Country*</label>
                                        <div class="select-box">
                                            <select name="ship_country" required class="form-control form-control-md">
                                                <option  selected="selected">India</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Street address *</label>
                                        <input type="text" placeholder="House number and street name"
                                            class="form-control form-control-md mb-2" name="ship_address"  required value="<?php  if(isset($ship_addr)){  echo $ship_addr['address'];}?>">
                                        <input type="text" placeholder="Apartment, suite, unit, etc. (optional)"
                                            class="form-control form-control-md" name="ship_landmark" required value="<?php  if(isset($ship_addr)){  echo $ship_addr['landmark'];}?>" >
                                    </div>
                                    <div class="row gutter-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>City *</label>
                                                <input type="text" class="form-control form-control-md" name="ship_city" required value="<?php  if(isset($ship_addr)){ echo $ship_addr['city'];}?>" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>State *</label>
                                                <div class="select-box">
                                                    <select name="ship_state" class="form-control form-control-md">
                                                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                                        <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                        <option value="Assam">Assam</option>
                                                        <option value="Bihar">Bihar</option>
                                                        <option value="Chandigarh">Chandigarh</option>
                                                        <option value="Chhattisgarh">Chhattisgarh</option>
                                                        <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                                                        <option value="Daman and Diu">Daman and Diu</option>
                                                        <option value="Delhi">Delhi</option>
                                                        <option value="Goa">Goa</option>
                                                        <option value="Gujarat">Gujarat</option>
                                                        <option value="Haryana">Haryana</option>
                                                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                        <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                        <option value="Jharkhand">Jharkhand</option>
                                                        <option value="Karnataka">Karnataka</option>
                                                        <option value="Kerala">Kerala</option>
                                                        <option value="Lakshadweep">Lakshadweep</option>
                                                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                        <option value="Maharashtra">Maharashtra</option>
                                                        <option value="Manipur">Manipur</option>
                                                        <option value="Meghalaya">Meghalaya</option>
                                                        <option value="Mizoram">Mizoram</option>
                                                        <option value="Nagaland">Nagaland</option>
                                                        <option value="Orissa">Orissa</option>
                                                        <option value="Pondicherry">Pondicherry</option>
                                                        <option value="Punjab">Punjab</option>
                                                        <option value="Rajasthan">Rajasthan</option>
                                                        <option value="Sikkim">Sikkim</option>
                                                        <option value="Tamil Nadu">Tamil Nadu</option>
                                                        <option value="Tripura">Tripura</option>
                                                        <option value="Uttaranchal">Uttaranchal</option>
                                                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                        <option value="West Bengal">West Bengal</option>
                                                            
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            
                                            <div class="form-group">
                                                <label>Pincode *</label>
                                                <input type="text" class="form-control form-control-md" name="ship_zipcode" required value="<?php if(isset($ship_addr)){  echo $ship_addr['zipcode'];}?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="payment_method" id="payment_method" value="cod">
                                <!-- <div class="form-group mt-3">
                                    <label for="order-notes">Order notes (optional)</label>
                                    <textarea class="form-control mb-0" id="order-notes" name="order-notes" cols="30"
                                        rows="4"
                                        placeholder="Notes about your order, e.g special notes for delivery"></textarea>
                                </div> -->
                            </div>
                            <div class="col-lg-4 mb-4 sticky-sidebar-wrapper" style="margin: 0 AUTO;">
                                <div class="order-summary-wrapper sticky-sidebar">
                                    <h3 class="title text-uppercase ls-10">Your Order</h3>
                <?php
                  $totalAmount = $discountAmt = $total_shipping = 0;
                  $i = 1;
                  foreach ($cart as $items) 
                  {
                    $link = ($this->session->userdata('user_id') > 0) ? 'href="' . site_url() . 'cart/add_to_wishlist/' . $items['pid'] . '"' : 'href="#" data-toggle="modal" data-target="#log-modal"';
                    $pprice = ($items['discount_price'] > 0) ? $items['discount_price'] : $items['product_price'];
                    $totalAmount += ($pprice * $items['qty']);
                    $discountAmt += $pprice * $items['qty'];
                    $url = $this->db->query("SELECT friendly_url FROM wps_products WHERE products_id = '" . $items['pid'] . "'")->row_array();
                      $i++;
                    }
                 ?>
                                    <div class="order-summary">
                                        <table class="order-table">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">
                                                        <b>Product</b>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                
                                                   <?php 
            $total_amt=0;
             foreach($cart as $carter=>$c)
            { ?>
            <tr class="bb-no">
                <td class="product-name">
                    <?php echo  substr($c['origname'],0,20); 
                        if(strlen($c['origname'])>20)
                        {
                            echo "...";
                        }
                        ?> 
                        <i class="fas fa-times"></i> <span class="product-quantity"><?php echo $c['qty'] ?> </span></td>
                <td class="product-total"><?php  $total_amt=$total_amt+$c['discount_price']*$c['qty']; echo $c['discount_price']*$c['qty']; ?> </td>
            </tr>
              

            <?php } ?>
            
                        <tr class="cart-subtotal bb-no">
                <td>
                    <b>Subtotal</b>
                </td>
                <td>
                    <b>₹ <?php echo round($total_amt)?></b>
                </td>
            </tr>
                                                
                                               <?php
$discount_by_coupon_amount_is=$this->session->userdata('discount_amount');
$coupon_id=$this->session->userdata('coupon_id');

?>





<!--coin integration-->
<?php
$where=array('user_id'=>$this->session->userdata('user_id'));
$wallet_data= $this->cart_model->get_master_where('*',$where,'user_wallet_trans');

$cr_coin=0;
$dr_coin=0;
$ttl_remain_coin=0;
foreach($wallet_data as $wd=>$wdp)
{
    if($wdp['cr_dr']=='cr')
    {
        $cr_coin=$cr_coin+$wdp['earn_coin'];
    }
    else if($wdp['cr_dr']=='dr')
    {
         $dr_coin=$dr_coin+$wdp['earn_coin'];
    }
}
$ttl_remain_coin=$cr_coin-$dr_coin;
$ttl_remain_coin;

if($ttl_remain_coin  > 50)
{
    
?>
            <tr class="cart-subtotal bb-no">
                <td>
                    <b>Use Wallet Coins</b>
                </td>
                <td>
                    <b><i class="fas fa-coins"></i> 
                    <?php
                      if($total_amt>$ttl_remain_coin)
                      {
                          $this->session->set_userdata('remain_coin',$ttl_remain_coin);
                          echo $ttl_remain_coin;
                      }
                      else if($total_amt<$ttl_remain_coin)
                      {
                          $this->session->set_userdata('remain_coin',$total_amt);
                          echo $total_amt;
                      }
                        
                    ?></b>
                </td>
            </tr>
            
 <?php } ?>           
            
            
            
            
            
            
            
            
          
            
            <?php
            if(isset($coupon_id))
            {
            ?>
            <tr>
                <td> Coupon Discount</td>
                <td> <?php echo '- '.round($discount_by_coupon_amount_is); ?></td>
            </tr>
            <?php } ?>
                                            </tbody>
                                            <tfoot>
                                               
                                                <tr class="order-total">
                                                    <th>
                                                        <b>Total</b>
                                                    </th>
                                                    <td>
                                                        <b>₹ <?php
                                                        // echo round($total_amt-($discount_by_coupon_amount_is+$ttl_remain_coin)); 
                                                        if($ttl_remain_coin>50)
                                                        {
                                                            if($total_amt>$ttl_remain_coin)
                                                              {
                                                                  echo round($total_amt-($discount_by_coupon_amount_is+$ttl_remain_coin));
                                                              }
                                                              else if($total_amt<$ttl_remain_coin)
                                                              {
                                                                  echo $total_amt=0;
                                                              }
                                                        }
                                                        else
                                                        {
                                                             echo  round($total_amt - $discount_by_coupon_amount_is)?:0;
                                                        }
                                                        ?></b>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                        <div class="payment-methods" id="payment_methods">
                                            <h4 class="title font-weight-bold ls-25 pb-0 mb-2">Payment Methods</h4>
                                            <div class="accordion payment-accordion">
                                                <div class="card mb-2">
                                                    <div class="card-header">
                                                        
                                                        <!--<a href="#cash-on-delivery" class="collapse" onclick="$('#payment_method').val('online');">Online Payment</a>-->
                                                       <label> <input type="radio" name="paymode" onclick="$('#payment_method').val(this.value);" value="online"> Online</label>
                                                    </div>
                                                    <!--<div id="cash-on-delivery" class="card-body expanded collapsed">-->
                                                    <!--    <p class="mb-0">-->
                                                    <!--        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quam odit error vero rem accusantium deleniti nihil totam enim ex magnam!-->
                                                    <!--    </p>-->
                                                    <!--</div>-->
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <label><input type="radio" name="paymode" onclick="$('#payment_method').val(this.value);" value="cod" checked="checked"> Cash on Delivery</label>
                                                    </div>
                                                    <!--<div id="payment" class="card-body collapsed">-->
                                                    <!--    <p class="mb-0">-->
                                                    <!--        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quam odit error vero rem accusantium deleniti nihil totam enim ex magnam!-->
                                                    <!--    </p>-->
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group place-order pt-6">
                                           
                                           <?php 
                                           if($this->session->userdata('user_id'))
                                           {
                                           ?>
                                            <button type="submit" class="btn btn-dark btn-block btn-rounded">Place Order</button>
                                             <?php } else
                                                   {
                                             ?>
                                             <a href="<?php echo base_url(); ?>login" class="btn btn-dark btn-block btn-rounded" >Login First then Try Again</a>
                                             <p class="text-center"><br>OR</p>
                                             <button type="submit" class="btn btn-dark btn-block btn-rounded">Guest Checkout</button>
                                             
                                             <?php } ?> 
                                     
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            <!-- End of PageContent -->
        </main>
        <!-- End of Main -->
  
<?php $this->load->view("bottom"); ?>
<script type="text/javascript">
 $('.checkbox-content').show(); 
  function Check_Bill_Ship(chk)
  {
      
      
       if (chk.check_add.checked == 1) 
       {
            // $('.checkbox-content').show(); 
            
            $('input[name="ship_first_name"]').val( $('input[name="first_name"]').val());
            $('input[name="ship_last_name"]').val( $('input[name="last_name"]').val());
            $('input[name="ship_address"]').val( $('input[name="address"]').val());
            $('input[name="ship_landmark"]').val( $('input[name="landmark"]').val());
            $('input[name="ship_mobile"]').val( $('input[name="mobile"]').val());
            $('input[name="ship_zipcode"]').val( $('input[name="zipcode"]').val());
            $('input[name="ship_city"]').val( $('input[name="city"]').val());
            $('input[name="ship_state"]').val( $('input[name="state"]').val());
            $('input[name="ship_country"]').val( $('input[name="country"]').val());
            
            
          
       }
       else
       {
        //  $('.checkbox-content').hide();  
            $('input[name="ship_first_name"]').val();
            $('input[name="ship_last_name"]').val();
            $('input[name="ship_address"]').val();
            $('input[name="ship_landmark"]').val();
            $('input[name="ship_mobile"]').val();
            $('input[name="ship_zipcode"]').val();
            $('input[name="ship_city"]').val();
            $('input[name="ship_state"]').val();
            $('input[name="ship_country"]').val();
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
 
