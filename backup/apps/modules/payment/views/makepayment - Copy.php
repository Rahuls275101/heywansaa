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
















<main class="main order">
    <div class="page-content mb-10 pb-2">
        <div class="container">
            <div class="order-success text-center font-weight-bolder text-dark">
                <h3>Online make Payment! </h3>
                <h4>Total Amount: ₹<?php echo $cart_tot; ?></h4>
                <button class="btn btn-dark makepaymentraz">Pay Now</button>
            </div>
       </div>
    </div>
</main>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
   
   $(document).on('click','.makepaymentraz',function(){
       
  
            
            
            
                var SITEURL="<?php echo base_url();?>";
                
                var totalAmount =<?php echo $cart_tot; ?>;
                var product_id =  <?php echo $order_id; ?>;
                
             
                
                var email = "info@weblieu.com";
                var phone = "7307031778";
                var options = {
                "key": "rzp_test_QFvkNtWP6ANd8Q",
                // "amount": (totalAmount*100), // 2000 paise = INR 20
                "amount":   totalAmount*100,
                "name": "Heywansa",
                prefill: {
                          email: email,
                          contact: phone,
                         },
                "description": "Payment",
                "image": "https://cdn.razorpay.com/logos/FFATTsJeURNMxx_medium.png",
                "handler": function (response){
                $.ajax({
                   
                url: SITEURL + "payment/razorPaySuccess",
                method: "post",
                data: {
                 razorpay_payment_id: response.razorpay_payment_id ,
                 totalAmount : totalAmount ,
                 product_id : product_id,
                 razorpay_order_id:response.order_id,
                 razorpay_signature:response.signature,
                 razorpay_status:response.status,
                }, 
                success: function (msg) {
                
                // alert();
               // window.location.href = SITEURL+'payment/razorPaySuccess/';
                }
                });
                },
                "theme": {
                "color": "#528FF0"
                }
                };
                
                var rzp1 = new Razorpay(options);
                rzp1.open();
                e.preventDefault();
          
        });
        
</script>






<?php $this->load->view('bottom'); ?>