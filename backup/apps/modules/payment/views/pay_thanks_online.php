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
                        
                        <h3>Payment status: <strong><?php echo $payment_status; ?></strong></h3>
                        
                        <?php
						
						
						//echo "<h4>".$msgdata."</h4>";        
       // echo "<br/>";
       // echo "Transaction ID: ".$this->session->flashdata('razorpay_payment_id');
        //echo "<br/>";
       // echo "Order ID: ".$this->session->flashdata('merchant_order_id');
						
						?>
                        
                        
                    </div>
                   
                     
                    <!-- End of Account Address -->
                    <a href="<?php echo base_url(); ?>" class="btn btn-dark btn-rounded btn-icon-left btn-back mt-6"><i class="w-icon-long-arrow-left"></i>Back To List</a>
                </div>
            </div>
            <!-- End of PageContent -->
        </main>










<?php $this->load->view('bottom'); ?>