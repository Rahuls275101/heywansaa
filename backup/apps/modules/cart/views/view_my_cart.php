<?php
$this->load->view('top');
$discount_amount = $this->session->userdata('discount_amount');

$cart = $this->cart->contents();
$totalAmounts = 0;
foreach ($cart as $items) {
  $pprice = ($items['discount_price'] > 0) ? $items['discount_price'] : $items['product_price'];
  $totalAmounts += ($pprice * $items['qty']);
}
$i=1;
?>


<?php //print_r($cart=$this->cart->contents()) ?>


 <?php if(isset($cart) && !empty($cart))
        {
            ?>

<!-- Start of Main -->
<main class="main cart">
    <!-- Start of Breadcrumb -->
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb shop-breadcrumb bb-no">
                <li class="active"><a href="<?php echo  base_url().'cart'; ?>">Shopping Cart</a></li>
                <li><a href="<?php echo  base_url().'checkout'; ?>">Checkout</a></li>
                <li><a href="<?php echo  base_url().'my-orders'; ?>">Order Complete</a></li>
            </ul>
        </div>
    </nav>
    <!-- End of Breadcrumb -->
    <!-- Start of PageContent -->
    <div class="page-content">
        <div class="container">
            <div class="row mb-10">
                <div class="col-lg-12">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-8 mb-6">
                             
       <?php
            echo form_open('cart/', 'name="cart_frm" id="cart_frm" ');
            ?>
    <table id="table-breakpoint" class="shop-table cart-table">
        <thead>
            <tr>
                <th class="product-name"><span>Product</span></th>
                <th></th>
                <th class="product-price"><span>Price</span></th>
                <th class="product-quantity"><span>Quantity</span></th>
                <th class="product-subtotal"><span>Subtotal</span></th>
            </tr>
        </thead>
        <tbody>
        <?php
        // print_r($cart);
            foreach($cart as $carter=>$c)
            {
                $p_id=$c['pid'];
                $product_details=$this->db->query("SELECT * FROM wps_products WHERE products_id = '" . $p_id . "'")->row_array();
                // <?php echo site_url(); cart/remove_item/<?php echo $items['rowid']; 
                ?>
            <tr>
                <td class="product-thumbnail">
                    <div class="p-relative">
                        <a href="<?php echo  base_url($product_details['friendly_url']);?>">
                            <figure>
                                <img src="<?php echo  base_url('uploaded-files/products/').$c['img']; ?>" alt="product" width="300" height="338">
                            </figure>
                        </a>
                        <a href="<?php echo base_url().'cart/remove_item/'.$c['rowid']; ?>" class="btn btn-close"><i class="fas fa-times"></i></a>
                    </div>
                </td>
                <td class="product-name">
                    <a href="<?php echo  base_url($product_details['friendly_url']);?>">
                       <?php 
                       echo  $product_details['product_name'];

                       ?>
                    </a>
                </td>
                <td class="product-price"><span class="amount">₹ <?php 
                       echo  $c['discount_price'];

                       ?></span></td>
                <td class="product-quantity">

    <div class="input-group">
        <input class="form-control" type="text"  max="10" name="<?php echo $i; ?>[qty]" id="qty_<?php echo $i; ?>" value="<?php echo $c['qty']; ?>" class="qty qty_value" readonly>
        
        <button class="quantity-plus w-icon-plus" onclick="return incDnc(1, <?php echo $i; ?>, <?php echo $c['availableqty']; ?>);"></button>
        
        <button class="quantity-minus w-icon-minus" onclick="return incDnc(2, <?php echo $i; ?>, <?php echo $c['availableqty']; ?>);" ></button>

    <!--      <input type="hidden" name="<?php echo $i; ?>[rowid]" min="1" max="10"  id='cart_rowid_<?php echo $i; ?>' value="<?php echo $c['rowid']; ?>" /> -->
          <input type="hidden" name="<?php echo $i; ?>[rowid]" id='cart_rowid_<?php echo $i; ?>' value="<?php echo $c['rowid']; ?>" /> 
    </div>



                </td>
                <td class="product-subtotal">
                    <span class="amount">₹ <?php echo $c['qty']*$c['discount_price']; ?></span>
                </td>
            </tr>
            <?php 
            $i++; 
            } 
            ?>
        </tbody>
    </table>
    <?php 
    echo form_close();
    
    ?>
                            <div class="cart-action mb-6">
                                <a href="<?php echo base_url(); ?>" class="btn btn-dark btn-rounded btn-icon-left btn-shopping mr-auto"><i class="w-icon-long-arrow-left"></i>Continue Shopping</a>
                                
                                <!--<button type="submit" class="btn btn-rounded btn-update disabled" name="update_cart" value="Update Cart">Update Cart</button>-->
                            </div>
                            <form class="coupon">
                                <h5 class="title coupon-title font-weight-bold text-uppercase">Coupon Discount</h5>
                                <!--<input type="text" class="form-control mb-4"  placeholder="Enter coupon code here..." required />-->
                                <!--<button class="btn btn-dark btn-outline btn-rounded">Apply Coupon</button>-->
                                
                                
                                <input class="form-control  mb-4" placeholder="Enter coupon code" name="couponCode" id="couponCode" type="text" required="">
                                <button class="btn btn-dark btn-outline btn-rounded" type="button" name="applyCoupon" id="applyCoupon">Apply</button>
                                
                                
                            </form>
                        </div>
                        <div class="col-lg-4 sticky-sidebar-wrapper">
                            <div class="sticky-sidebar">
                                <div class="cart-summary mb-0">
                                    <h3 class="cart-title text-uppercase">Cart Totals</h3>
                                    <!-- <div class="cart-subtotal d-flex align-items-center justify-content-between">
                                        <label class="ls-25">Subtotal</label>
                                        <span>₹100.00</span>
                                    </div> -->
                                    <hr class="divider">
                                    <div class="order-summary">
    <table id="table-breakpoint" class="order-table">
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

                        <?php
                        $discount_by_coupon_amount_is=$this->session->userdata('discount_amount');
                        $coupon_id=$this->session->userdata('coupon_id');
                        
                        ?>


            <tr class="cart-subtotal bb-no">
                <td>
                    <b>Subtotal</b>
                </td>
                <td>
                    <b>₹ <?php echo $total_amt?></b>
                </td>
            </tr>
            <?php
            if(isset($coupon_id))
            {
            ?>
            <tr>
                <td> Coupon Discount</td>
                <td><?php echo '- '.round($discount_by_coupon_amount_is); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>                                        
                            </div>
                                    <hr class="divider mb-2">
                                    <div class="order-total d-flex justify-content-between align-items-center">
                                        <label>Total</label>
                                        <span class="ls-50">₹ <?php echo round($total_amt-$discount_by_coupon_amount_is); ?></span>
                                    </div>
                                    <a href="<?php echo base_url().'cart/checkout'; ?>" class="btn btn-block btn-dark btn-icon-right btn-rounded  btn-checkout">
                                        Proceed to checkout<i class="w-icon-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of PageContent -->
</main>
        <!-- End of Main -->
<input type="hidden" value="<?php echo $total_amt ?>" id="amt" name="amt">



<?php

} 
    else
    {
?>
    <div class="page-content">
        <div class="container">
            <div class="row mb-10">
            <h3 style="text-align:center">Cart is Empty!!!</h3>
<p style="text-align:center">

<img src="<?php echo base_url(); ?>/assets/sitepanel/assets/img/emptycard.png" width="300" height="300" />
</p>
</div>
</div>
</div>
<?php
    }

?>







































        <?php $this->load->view('bottom'); ?>

        <script src="<?php echo site_url(); ?>assets/developer/js/common.js"></script> 
        <script type="text/javascript">
    $('#applyCoupon').click(function () {
      if ($('#couponCode').val() == '') {
        alert('please enter valid coupon code');
      } else {
        $.post(site_url + 'cart/applycoupon', {couponcode: $('#couponCode').val(),amt: $('#amt').val()}, function (data) {
          alert(data);
          window.location.reload();
        });
      }
    });
    $('#removeCoupon').click(function () {
      $.post(site_url + 'cart/removecoupon', {}, function (data) {
        alert(data);
        window.location.reload();
      });
    });
</script>
