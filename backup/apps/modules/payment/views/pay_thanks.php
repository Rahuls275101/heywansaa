<?php
$this->load->view('top');
$ordmaster=$ordmaster[0];

?>
 


<style>
    .address_para{
                    /*line-height: 20px;*/
                    text-transform: uppercase;
                    /*margin: 0 0 1rem;*/
                    /*color: #404040;*/
                }
</style>
















<main class="main order">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb shop-breadcrumb bb-no">
                        <li><a href="<?php echo  base_url().'cart'; ?>">Shopping Cart</a></li>
                        <li><a href="<?php echo  base_url().'checkout'; ?>">Checkout</a></li>
                        <li class="active"><a href="<?php echo  base_url().'order'; ?>">Order Complete</a></li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->
            <!-- Start of PageContent -->
            <div class="page-content mb-10 pb-2">
                <div class="container">
                    <div class="order-success text-center font-weight-bolder text-dark">
                        <i class="fas fa-check"></i>
                        Thank you. Your order has been received.
                        
                        <h3>Payment status: <strong><?php echo $ordmaster['payment_status']; ?></strong></h3>
                    </div>
                    <!-- End of Order Success -->
                    <ul class="order-view list-style-none">
                        <li>
                            <label>Order number</label>
                            <strong><?php echo $ordmaster['invoice_number']; ?></strong>
                        </li>
                        <li>
                            <label>Status</label>
                            <strong><?php 
                            if(strtoupper($ordmaster['payment_status'])=='UNPAID')
                            {
                                echo "<div class='btn btn-danger' style='background-color:#ff7979;color:#000'>".$ordmaster['payment_status']."</div>";
                            }
                            else
                            {
                                echo "<div class='btn btn-success' style='background-color:#005a0f;color:#fff'>".$ordmaster['payment_status']."</div>";
                            }
                            ?></strong>
                        </li>
                        <li>
                            <label>Order Receive Date</label>
                            <strong><?php echo date('d-m-Y h:i A',strtotime($ordmaster['order_received_date'])); ?></strong>
                        </li>
                        <!--<li>-->
                        <!--    <label>Total</label>-->
                        <!--    <strong><?php //echo $ordmaster['total_amount']+$ordmaster['vat_amount']; ?></strong>-->
                        <!--</li>-->
                        <li>
                            <label>Payment method</label>
                           <strong><?php echo strtoupper($ordmaster['payment_method']); ?></strong>
                        </li>
                    </ul>
                    <!-- End of Order View -->
                    <div class="order-details-wrapper mb-5">
                        <h4 class="title text-uppercase ls-25 mb-5">Order Details</h4>
                        <table class="order-table">
                            <thead>
                                <tr>
                                    <th class="text-dark">Product</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php
                                $total_amt=0;
                                foreach($orddetail as $order_list=>$list)
                                {
                                    $single_total_amt=0;
                                    $total_amt=$total_amt+($list['product_price'] * $list['quantity']);
                                ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo base_url().$list['friendly_url'] ?>"><?php echo $list['product_name'] ?></a>&nbsp;<strong>  <?php if($list['size_id']!=''){ echo ' - '.$list['size_id'];} ?> </strong><br>
                                      <?php if($list['color_id']!=''){ ?>  Color : <a href="#"><span style="background-color:<?php echo $list['color_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></a><?php } ?>
                                    </td>
                                    <td>₹ <?php  
                                                $single_total_amt=$single_total_amt+ ($list['product_price'] * $list['quantity']);
                                                
                                                echo $list['product_price'].' X '.$list['quantity']. ' = ₹ '.$single_total_amt;
                                                
                                            ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Subtotal:</th>
                                    <td>₹ <?php echo $total_amt;  ?></td>
                                </tr>
                                <tr>
                                    <th>Shipping:</th>
                                    <td>Flat rate</td>
                                </tr>
                                <tr>
                                    <th>Payment method:</th>
                                    <td><?php echo strtoupper($ordmaster['payment_method']); ?></td>
                                </tr>
                                <tr>
                                    <th>GST (VAT)</th>
                                    <td>₹ <?php echo $ordmaster['vat_amount']; ?></td>
                                </tr>
                                
                               
                                <tr>
                                    <th>Wallet Coin</th>
                                    <td>₹ <?php echo $ordmaster['wallet_coin_use']?:'0'; ?></td>
                                </tr>
                               
                                
                               
                                <tr>
                                    <th>Coupon Code</th>
                                    <td>₹ <?php echo $ordmaster['coupon_discount_amount']?:'0'; ?></td>
                                </tr>
                              
                                
                                <tr class="total">
                                    <th class="border-no">Total:</th>
                                    <td class="border-no">₹ <?php print_r( $ordmaster['total_amount']);  ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- End of Order Details -->
                    <div id="account-addresses">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="ecommerce-address billing-address">
                                    <h4 class="title title-underline ls-25 font-weight-bold">Billing Address</h4>
                                    <address class="mb-4">
                                        <table>
                                            <tr>
                                                <td class="address_para"> Name:             </td><td>                <?php echo ucwords($ordmaster['billing_name']); ?> </td>
                                                 </tr><tr><td class="address_para"> Email-ID:             </td><td>            <?php echo $ordmaster['email']; ?> </td>
                                                 </tr><tr><td class="address_para"> Phone/Mobile:             </td><td>          <?php echo $ordmaster['billing_phone']; ?> </td>
                                                 </tr><tr><td class="address_para"> Billing Address:          </td><td>         <?php echo  ucwords($ordmaster['billing_address']); ?> </td>
                                                 </tr><tr><td class="address_para"> Landmark:             </td><td>              <?php echo  ucwords($ordmaster['billing_landmark']); ?> </td>
                                                 </tr><tr><td class="address_para"> City:             </td><td>              <?php echo  ucwords($ordmaster['billing_city']); ?> </td>
                                                 </tr><tr><td class="address_para"> State:            </td><td>             <?php echo  ucwords($ordmaster['billing_state']); ?> </td>
                                                 </tr><tr><td class="address_para"> Country:              </td><td>          <?php echo  ucwords($ordmaster['billing_country']); ?> </td>
                                                 </tr><tr><td class="address_para">  Area Pincode:            </td><td>            <?php echo $ordmaster['billing_zipcode']; ?></td></tr>
                                            </tr>
                                        </table>
                                    </address>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="ecommerce-address shipping-address">
                                    <h4 class="title title-underline ls-25 font-weight-bold">Shipping Address</h4>
                                    <address class="mb-4">
                                         <table>
                                             
                                                    <tr><td class="address_para"> Name:    </td><td>       <?php echo ucwords($ordmaster['shipping_name']); ?> </td>
                                              </tr> <tr><td class="address_para"> Email-ID: </td><td>      <?php echo $ordmaster['email']; ?> </td>
                                              </tr> <tr><td class="address_para"> Phone/Mobile:  </td><td> <?php echo $ordmaster['shipping_phone']; ?> </td>
                                              </tr> <tr><td class="address_para"> Billing Address:</td><td> <?php echo  ucwords($ordmaster['shipping_address']); ?> </td>
                                              </tr> <tr><td class="address_para"> Landmark:  </td><td>      <?php echo  ucwords($ordmaster['shipping_landmark']); ?> </td>
                                              </tr> <tr><td class="address_para"> City:    </td><td>   <?php echo  ucwords($ordmaster['shipping_city']); ?> </td>
                                              </tr> <tr><td class="address_para"> State:   </td><td>   <?php echo  ucwords($ordmaster['shipping_state']); ?> </td>
                                              </tr> <tr><td class="address_para"> Country:  </td><td>  <?php echo  ucwords($ordmaster['shipping_country']); ?> </td>
                                              </tr> <tr><td class="address_para">  Area Pincode: </td><td>   <?php echo $ordmaster['shipping_zipcode']; ?></td></tr>
                                        </table>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Account Address -->
                    <a href="<?php echo base_url(); ?>" class="btn btn-dark btn-rounded btn-icon-left btn-back mt-6"><i class="w-icon-long-arrow-left"></i>Back To List</a>
                </div>
            </div>
            <!-- End of PageContent -->
        </main>










<?php $this->load->view('bottom'); ?>