 <main class="main">
        <div class="container">
            <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
                <li class="active">
                    <a href="#">Shopping Cart</a>
                </li>
                <li>
                    <a href="#">Checkout</a>
                </li>
                <li class="disabled">
                    <a href="#">Order Complete</a>
                </li>
            </ul>
        
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-table-container">
                        <table class="table table-cart">
                            <thead>
                                <tr>
                                    <th class="thumbnail-col"></th>
                                    <th class="product-col">Product</th>
                                    <th class="price-col">Price</th>
                                    <th class="qty-col">Quantity</th>
                                   
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="cartSummaryList">
                               
                               
        
                              
                            </tbody>
        
        
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="clearfix">
                                        <div class="float-left">
                                            <div class="cart-discount">
                                                <form action="#">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm" id="coupon_code" placeholder="Coupon Code" required="">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-sm applycoupon" type="submit">Apply
        																	Coupon</button>
                                                        </div>
                                                    </div><!-- End .input-group -->
                                                </form>
                                            </div>
                                        </div><!-- End .float-left -->
        
                                        <div class="float-right">
                                           <button type="button" class="btn btn-shop btn-update-cart" onclick="location.reload();">
    Update Cart
</button>
                                        </div><!-- End .float-right -->
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- End .cart-table-container -->
                </div><!-- End .col-lg-8 -->
        
                <div class="col-lg-4">
                    <div class="cart-summary">
                        <h3>CART TOTALS</h3>
        
                        <table class="table table-totals">
                            <tbody class="cartSummary">
                               
                            </tbody>
        
                        </table>
        
                        <div class="checkout-methods">
                            <a href="<?php echo base_url('checkout'); ?>" class="btn btn-block btn-dark">Proceed to Checkout
                                <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div><!-- End .cart-summary -->
                </div><!-- End .col-lg-4 -->
            </div><!-- End .row -->
        </div>
            <!-- End .container -->

            <div class="mb-4"></div>
            <!-- margin -->
        </main>
        <!-- End .main -->