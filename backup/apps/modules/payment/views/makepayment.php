<?php
$this->load->view('top');
//$ordmaster=$ordmaster[0];

?>
 


<style>
    .address_para{
                    /*line-height: 20px;*/
                    text-transform: uppercase;
                    /*margin: 0 0 1rem;*/
                    /*color: #404040;*/
                }
</style>

<?php
//$description        = "Product Description";
$txnid              = $order_id;     
$key_id             = "rzp_test_czT75UB3wjBa9l";
$currency_code      = $currency_code;            
$total              = ($cart_tot* 100); // 100 = 1 indian rupees
$amount             = 1;
$merchant_order_id  = $order_id;
//$card_holder_name   = 'Junaid Shaikh';
//$email              = 'coexistech@gmail.com';
//$phone              = '9000000001';
//$name               = "RazorPay";
//$callback_url       = base_url().'payment/callback_razorpay';
?>

    <form name="razorpay-form" id="razorpay-form" action="<?php echo $callback_url; ?>" method="POST">
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
        <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo $merchant_order_id; ?>"/>
        <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>"/>
        <input type="hidden" name="merchant_product_info_id" id="merchant_product_info_id" value="<?php echo $description; ?>"/>
        <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>"/>
        <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl; ?>"/>
        <input type="hidden" name="card_holder_name_id" id="card_holder_name_id" value="<?php echo $card_holder_name; ?>"/>
        <input type="hidden" name="merchant_total" id="merchant_total" value="<?php echo $total; ?>"/>
        <input type="hidden" name="merchant_amount" id="merchant_amount" value="<?php echo $amount; ?>"/>
    </form>

<main class="main order">
    <div class="page-content mb-10 pb-2">
        <div class="container">
            <div class="order-success text-center font-weight-bolder text-dark">
                <h3>Online make Payment! </h3>
                <h4>Total Amount: ₹<?php echo $cart_tot; ?></h4>
                 <input  id="pay-btn" type="submit" onclick="razorpaySubmit(this);" value="Pay Now" class="btn btn-primary" />
            </div>
       </div>
    </div>
</main>
   

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            key:            "<?php echo $key_id; ?>",
            amount:         "<?php echo $total; ?>",
            name:           "<?php echo $name; ?>",
            description:    "Order # <?php echo $merchant_order_id; ?>",
            netbanking:     true,
            currency:       "<?php echo $currency_code; ?>", // INR
            prefill: {
                name:       "<?php echo $card_holder_name; ?>",
                email:      "<?php echo $email; ?>",
                contact:    "<?php echo $phone; ?>"
            },
            notes: {
                soolegal_order_id: "<?php echo $merchant_order_id; ?>",
            },
            handler: function (transaction) {
                document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
                document.getElementById('razorpay-form').submit();
            },
            "modal": {
                "ondismiss": function(){
                    location.reload()
                }
            }
        };

        var razorpay_pay_btn, instance;
        function razorpaySubmit(el) {
            if(typeof Razorpay == 'undefined') {
                setTimeout(razorpaySubmit, 200);
                if(!razorpay_pay_btn && el) {
                    razorpay_pay_btn    = el;
                    el.disabled         = true;
                    el.value            = 'Please wait...';  
                }
            } else {
                if(!instance) {
                    instance = new Razorpay(options);
                    if(razorpay_pay_btn) {
                    razorpay_pay_btn.disabled   = false;
                    razorpay_pay_btn.value      = "Pay Now";
                    }
                }
                instance.open();
            }
        }  
    </script>
    
    

<?php $this->load->view('bottom'); ?>    