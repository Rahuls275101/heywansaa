

<?php
use App\Models\Commanmodel;

$commanmodel = new Commanmodel();
  $country = $commanmodel->all_multiple_query_order_by('countries',array(),'id','ASC'); 
?>

<style>
    .error-message {
    margin-top: 5px;
    font-size: 12px;
    color: red;
}

input.error {
    border-color: red;
}

</style>
<main class="main main-test">
    <div class="container checkout-container">
        <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
            <li>
                <a href="<?php echo base_url('cart'); ?>">Shopping Cart</a>
            </li>
            <li class="active">
                <a href="<?php echo base_url('checkout'); ?>">Checkout</a>
            </li>
            <li class="disabled">
                <a href="#">Order Complete</a>
            </li>
        </ul>

       <!-- <div class="login-form-container">
            <h4>Returning customer?
                <button data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="btn btn-link btn-toggle">Login</button>
            </h4> 

            <div id="collapseOne" class="collapse">
                <div class="login-section feature-box">
                    <div class="feature-box-content">
                        <form id="user_login" >
                            <p>
                                If you have shopped with us before, please enter your details below. If you are a new
                                customer, please proceed to the Billing &amp; Shipping section.
                            </p>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mb-0 pb-1">Username or email <span class="required">*</span></label>
                                        <input type="email" class="form-control" name="login_email" required="">
                                         <p id="login_email_error" class="errors"></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mb-0 pb-1">Password <span class="required">*</span></label>
                                        <input type="password" class="form-control" name="login_password" required="">
                                        <p id="login_password_error" class="errors"></p>
                                    </div>
                                </div>
                            </div>
 <input type="hidden" required autocomplete="off" name="user_login" value="Login" />
                            <button type="submit" id="login_submit" class="btn">LOGIN</button>

                            <div class="form-footer mb-1">
                                <div class="custom-control custom-checkbox mb-0 mt-0">
                                    <input type="checkbox" class="custom-control-input" id="lost-password">
                                    <label class="custom-control-label mb-0" for="lost-password">Remember
                                                me</label>
                                </div>

                                <a href="forgot-password.html" class="forget-password">Lost your password?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>-->

        <div class="checkout-discount">
             <h4>Have a coupon?
                <button data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne" class="btn btn-link btn-toggle">ENTER YOUR CODE</button>
            </h4> 

            <div id="collapseTwo" class="collapse">
                <div class="feature-box">
                    <div class="feature-box-content">
                        <p>If you have a coupon code, please apply it below.</p>

                        <form action="#">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm w-auto" id="coupon_code" placeholder="Coupon code" required="">
                                <div class="input-group-append">
                                    <button class="btn btn-sm mt-0 applycoupon" type="submit">
                                                Apply Coupon
                                            </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
  <form action="<?php echo base_url('order-now'); ?>" id="checkout-form" method="POST">
        <div class="row">
            <div class="col-lg-7">
                <ul class="checkout-steps">
                    <li>
                        <h2 class="step-title">Billing details</h2>

                      
                            
                              <div class="row">
                                   <div class="col-md-6">
                                        <div class="form-group">
                                <label>Name <abbr class="required" title="required">*</abbr></label>
                                <input type="text" name="name" class="form-control">
                                  <div class="error-message" id="name-error"></div>
                            </div>
                                    </div>  
                                    
                                     <div class="col-md-6">
                                        <div class="form-group">
                                <label>Email <abbr class="required" title="required">*</abbr></label>
                                <input type="email" name="email" class="form-control">
                                  <div class="error-message" id="email-error"></div>
                            </div>
                                    </div>
                                    
                                </div>
                                  
                                  
                                
                                <div class="row">
                                   <div class="col-md-6">
                                        <div class="form-group">
                                <label>Phone <abbr class="required" title="required">*</abbr></label>
                                <input type="text" name="phone" class="form-control">
                                  <div class="error-message" id="phone-error"></div>
                            </div>
                                    </div>  
                                    
                                     <div class="col-md-6">
                                        <div class="form-group">
                                <label>Pin Code <abbr class="required" title="required">*</abbr></label>
                                <input type="text" name="pin_code" id="pinCode" class="form-control applypin">
                                  <div class="error-message" id="pin_code-error"></div>
                            </div>
                                    </div>
                                    
                                </div>
                                  
                            
                             <div class="form-group mb-1 pb-2">
                                <label>Street address
                                            <abbr class="required" title="required">*</abbr></label>
                                <input type="text" class="form-control" name="address" placeholder="House number and street name" required="">
                                  <div class="error-message" id="address-error"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>City
                                                    <abbr class="required" title="required">*</abbr>
                                                </label>
                                        <input type="text" class="form-control" name="city" required="">
                                          <div class="error-message" id="city-error"></div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>State
                                                    <abbr class="required" title="required">*</abbr></label>
                                        <input type="text" name="state" class="form-control" required="">
                                          <div class="error-message" id="state-error"></div>
                                    </div>
                                </div>
                                
                                    <div class="col-md-4">
                    <label class="spacing">Country*</label>
                    <select name="country" class="form-control" >
                      <option value="">Country</option>
                    <?php
                    foreach ($country as $stateListView) {
                    ?>
                    <option value="<?php echo $stateListView->name; ?>"><?php echo $stateListView->name; ?></option>
                    <?php
                    }
                    ?>
                    </select>  
                   
                  </div>
                            </div>

                         

                           

                            

                          <div class="form-group">
                                <div class="custom-control custom-checkbox mt-0">
                                    <input type="checkbox" class="custom-control-input"  name="saved_address" value="Yes" id="save_address">
                                    <label class="custom-control-label" data-toggle="collapse" data-target="#collapseFive" aria-controls="collapseFive" for="save_address">
                                                Do you want to save your address?</label>


                                </div>
                            </div>
                            
                            
                             <div id="collapseFive" class="collapse">
                                 
                                 <div class="feature-box">
                    <div class="feature-box-content">
                                 
                                 <div class="form-group form-group-custom-control">
        <div class="custom-control custom-radio d-flex">
            <input type="radio" class="custom-control-input" id="address_type1" name="address_type" value="1" checked>
            <label class="custom-control-label" for="address_type1"> Home Address</label>
        </div>
    </div> 
    
     <div class="form-group form-group-custom-control">
        <div class="custom-control custom-radio d-flex">
            <input type="radio" class="custom-control-input" id="address_type2" name="address_type" value="2" >
            <label class="custom-control-label" for="address_type2"> Office Address</label>
        </div>
    </div>  
    
     <div class="form-group form-group-custom-control">
        <div class="custom-control custom-radio d-flex">
            <input type="radio" class="custom-control-input" id="address_type3" name="address_type" value="3" >
            <label class="custom-control-label" for="address_type3"> Other Address</label>
        </div>
    </div>  
                                 
             </div>
             </div>
                                 </div>
                            
                            

                            <div class="form-group">
                                <div class="custom-control custom-checkbox mt-0">
                                    <input type="checkbox" class="custom-control-input" id="different-shipping">
                                    <label class="custom-control-label" data-toggle="collapse" data-target="#collapseFour" aria-controls="collapseFour" for="different-shipping">Ship to a
                                                different
                                                address?</label>


                                </div>
                            </div>

                            <div id="collapseFour" class="collapse">
                                <div class="shipping-info">
                                    
                              
                            
                             <div class="row">
                                   <div class="col-md-6">
                                        <div class="form-group">
                                <label>Name <abbr class="required" title="required">*</abbr></label>
                                <input type="text" name="shipping_name" class="form-control">
                                  <div class="error-message" id="shipping_name-error"></div>
                            </div>
                                    </div>  
                                    
                                     <div class="col-md-6">
                                        <div class="form-group">
                                <label>Email <abbr class="required" title="required">*</abbr></label>
                                <input type="email" name="shipping_email" class="form-control">
                                  <div class="error-message" id="shipping_email-error"></div>
                            </div>
                                    </div>
                                    
                                </div>
                                  
                                  
                                
                                <div class="row">
                                   <div class="col-md-6">
                                        <div class="form-group">
                                <label>Phone <abbr class="required" title="required">*</abbr></label>
                                <input type="text" name="shipping_phone" class="form-control">
                                  <div class="error-message" id="shipping_phone-error"></div>
                            </div>
                                    </div>  
                                    
                                     <div class="col-md-6">
                                        <div class="form-group">
                                <label>Pin Code <abbr class="required" title="required">*</abbr></label>
                                <input type="text" name="shipping_pin_code" id="shipping_pinCode" class="form-control applypin">
                                  <div class="error-message" id="shipping_pin_code-error"></div>
                            </div>
                                    </div>
                                    
                                </div>
                                  
                            
                          

                         

                            <div class="form-group mb-1 pb-2">
                                <label>Street address
                                            <abbr class="required" title="required">*</abbr></label>
                                <input type="text" class="form-control" name="shipping_address" placeholder="House number and street name" >
                                  <div class="error-message" id="shipping_-error"></div>
                            </div>
                            
                              
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City
                                                    <abbr class="required" title="required">*</abbr>
                                                </label>
                                        <input type="text" name="shipping_city" class="form-control" >
                                          <div class="error-message" id="shipping_city-error"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>State
                                                    <abbr class="required" title="required">*</abbr></label>
                                        <input type="text" name="shipping_state" class="form-control" >
                                          <div class="error-message" id="shipping_state-error"></div>
                                    </div>
                                </div>
                                
                                          <div class="col-md-4">
                    <label class="spacing">Country*</label>
                    <select name="shipping_country" class="form-control" >
                      <option value="">Country</option>
                    <?php
                    foreach ($country as $stateListView) {
                    ?>
                    <option value="<?php echo $stateListView->name; ?>"><?php echo $stateListView->name; ?></option>
                    <?php
                    }
                    ?>
                    </select>  
                    <div class="error-message" id="shipping_country-error"></div>
                  </div>
                            </div>


                            

                                </div>
                            </div>

                       
                    </li>
                </ul>
            </div>
            <!-- End .col-lg-8 -->

            <div class="col-lg-5">
                <div class="order-summary">
                    <h3>YOUR ORDER</h3>

                    <table class="table table-mini-cart">
                        
                        <tbody class="cartSummary">
                           

                          
                        </tbody>
                      
                      <tfoot>
                          <tr class="order-shipping">
                                       <td class="text-left" colspan="2">
    <h4 class="m-b-sm">Payment Method</h4>

    <div class="form-group form-group-custom-control">
        <div class="custom-control custom-radio d-flex">
            <input type="radio" class="custom-control-input" id="cod" name="payment_method" value="COD" checked>
            <label class="custom-control-label" for="cod">COD</label>
        </div>
    </div>

    <div class="form-group form-group-custom-control mb-0">
        <div class="custom-control custom-radio d-flex mb-0">
            <input type="radio" class="custom-control-input" id="online" name="payment_method" value="Online">
            <label class="custom-control-label" for="online">Online</label>
        </div>
    </div>
</td>

 
                          
                     
                     
                                    </tr>
                       </tfoot>
                      
                    </table>

                    <div class="payment-methods">
                        
                    </div>

                    <button type="submit" class="btn btn-dark btn-place-order" form="checkout-form">
                                Place order
                            </button>
                </div>
                <!-- End .cart-summary -->
            </div>
            <!-- End .col-lg-4 -->
        </div>
        
         </form>
        <!-- End .row -->
    </div>
    <!-- End .container -->
</main>
        <!-- End .main -->
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>     
        
        <script>
        
           var BaseUrl = '<?php echo base_url(''); ?>/';	

      $(document).ready(function(){
    

      $('#user_login').on('submit', function(event){
	 
   event.preventDefault();
   
   $.ajax({
    url: BaseUrl+'login_process',
    method:"POST",
    data:$(this).serialize(),
    dataType:"json",
    beforeSend:function(){
     
     $('#login_submit').attr('disabled', 'disabled');
    },
    
    success:function(data)
    {
      
     
     if(data.error_user)
     {
           $('#login_submit').attr('disabled', false); 
         
      if(data.phone_login_error != '')
      {
       $('#login_emailerror').html(data.login_email_error);
      }
      else
      {
       $('#login_email_error').html('');
      }
      if(data.pin_error != '')
      {
       $('#login_password_error').html(data.login_password_error);
      }
      else
      {
       $('#login_password_error').html('');
      }
     
     
      
      //$('#register_form').attr('disabled', false);
     }
     if(data.failed)
     {
          $('#login_submit').attr('disabled', false); 
      $('#success_message_login').html(data.failed);
     }
     if(data.success)
     {
          $('#login_submit').attr('disabled', false); 
          showAlert(data.class,data.title,data.message);	
          $('#myModal').modal('hide');
            login_area();
            
               $('.errors').html('');
       $('#form_user_register')[0].reset();
             setTimeout(function(){ 
   
            $('#myModal').modal('hide');
     
      }, 3000);
          
      
        
     }
    
    }
   })
  });	
   
});
        
        
        
        
        
         document.getElementById("checkout-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission to handle validation

    // Clear previous error messages and reset input styles
    const errorMessages = document.querySelectorAll(".error-message");
    errorMessages.forEach(message => message.textContent = '');
    const inputs = document.querySelectorAll("input");
    inputs.forEach(input => input.classList.remove("error"));

    let isValid = true;

    // Helper function to show errors
    function showError(input, message) {
        const errorElement = document.getElementById(`${input.name}-error`);
        errorElement.textContent = message;
        input.classList.add("error");
        isValid = false;
    }

    // Billing address validation
    const billingName = document.querySelector('input[name="name"]');
    const billingEmail = document.querySelector('input[name="email"]');
    const billingPhone = document.querySelector('input[name="phone"]');
    const billingPinCode = document.querySelector('input[name="pin_code"]');
    const billingCity = document.querySelector('input[name="city"]');
    const billingState = document.querySelector('input[name="state"]');
    const billingAddress = document.querySelector('input[name="address"]');
    const billingCountrys = document.querySelector('input[name="country"]');

    if (!billingName.value) showError(billingName, "Name is required.");
    if (!billingEmail.value) {
        showError(billingEmail, "Email is required.");
    } else if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/.test(billingEmail.value)) {
        showError(billingEmail, "Please enter a valid email address.");
    }
    if (!billingPhone.value) showError(billingPhone, "Phone number is required.");
    if (!billingPinCode.value) showError(billingPinCode, "Pin code is required.");
    if (!billingCity.value) showError(billingCity, "City is required.");
    if (!billingState.value) showError(billingState, "State is required.");
    if (!billingAddress.value) showError(billingAddress, "Address is required.");

    // Phone number validation for billing
    if (!/^[\+]?[0-9]{10,15}$/.test(billingPhone.value)) {
        showError(billingPhone, "Please enter a valid phone number.");
    }

    // Shipping address validation (only if "Ship to a different address" is checked)
    const isShippingDifferent = document.querySelector('#different-shipping').checked;
    if (isShippingDifferent) {
        const shippingName = document.querySelector('input[name="shipping_name"]');
        const shippingEmail = document.querySelector('input[name="shipping_email"]');
        const shippingPhone = document.querySelector('input[name="shipping_phone"]');
        const shippingPinCode = document.querySelector('input[name="shipping_pin_code"]');
        const shippingCity = document.querySelector('input[name="shipping_city"]');
        const shippingState = document.querySelector('input[name="shipping_state"]');
        const shippingAddress = document.querySelector('input[name="shipping_address"]');
        const shippingCountrys = document.querySelector('input[name="shipping_country"]');

        if (!shippingName.value) showError(shippingName, "Shipping name is required.");
        if (!shippingEmail.value) {
            showError(shippingEmail, "Shipping email is required.");
        } else if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/.test(shippingEmail.value)) {
            showError(shippingEmail, "Please enter a valid shipping email address.");
        }
        if (!shippingPhone.value) showError(shippingPhone, "Shipping phone number is required.");
        if (!shippingPinCode.value) showError(shippingPinCode, "Shipping pin code is required.");
        if (!shippingCity.value) showError(shippingCity, "Shipping city is required.");
        if (!shippingState.value) showError(shippingState, "Shipping state is required.");
        if (!shippingAddress.value) showError(shippingAddress, "Shipping address is required.");
         if (!shippingCountrys.value) showError(shippingCountrys, "Shipping address is required.");

        // Phone number validation for shipping
        if (!/^[\+]?[0-9]{10,15}$/.test(shippingPhone.value)) {
            showError(shippingPhone, "Please enter a valid phone number for the shipping address.");
        }
    }

    // If the form is valid, submit it
    if (isValid) {
        this.submit();
    }
});

        </script>
