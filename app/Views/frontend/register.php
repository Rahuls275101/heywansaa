
        <div class="ltn__utilize-overlay"></div>

    <!-- BREADCRUMB AREA START -->
    <div class="ltn__breadcrumb-area text-left bg-overlay-white-30 bg-image "  data-bs-bg="img/bg/14.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ltn__breadcrumb-inner">
                        <h1 class="page-title">Account</h1>
                        <div class="ltn__breadcrumb-list">
                            <ul>
                                <li><a href="index.html"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                                <li>Register</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB AREA END -->

    <!-- LOGIN AREA START (Register) -->
    <div class="ltn__login-area pb-110">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area text-center">
                        <h1 class="section-title">Register <br>Your Account</h1>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. <br>
                             Sit aliquid,  Non distinctio vel iste.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="account-login-inner">
                        <form id="form_user_register" class="ltn__form-box contact-form-box">
                            <input type="text" name="firstname" placeholder="First Name">
                            <input type="text" name="lastname" placeholder="Last Name">
                            <input type="text" name="email" placeholder="Email*">
                            <input type="password" name="password" placeholder="Password*">
                            <input type="password" name="confirmpassword" placeholder="Confirm Password*">
                            <label class="checkbox-inline">
                                <input type="checkbox" value="">
                                I consent to Herboil processing my personal data in order to send personalized marketing material in accordance with the consent form and the privacy policy.
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" value="">
                                By clicking "create account", I consent to the privacy policy.
                            </label>
                            <div class="btn-wrapper">
                                <button class="theme-btn-1 btn reverse-color btn-block" type="submit">CREATE ACCOUNT</button>
                            </div>
                        </form>
                        <div class="by-agree text-center">
                            <p>By creating an account, you agree to our:</p>
                            <p><a href="#">TERMS OF CONDITIONS  &nbsp; &nbsp; | &nbsp; &nbsp;  PRIVACY POLICY</a></p>
                            <div class="go-to-btn mt-50">
                                <a href="login.html">ALREADY HAVE AN ACCOUNT ?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- LOGIN AREA END -->
    
    
    
    
    <script>
      var BaseUrl = '<?php echo base_url(''); ?>/';	

      $(document).ready(function(){
        login_area();

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
   



 $('#form_user_register').on('submit', function(event){



  
	 
   event.preventDefault();
   
   $.ajax({
    url: BaseUrl+'register_process',
    method:"POST",
    data:$(this).serialize(),
    dataType:"json",
    beforeSend:function(){
     
     $('#register_submit').attr('disabled', 'disabled');
    },
    
    success:function(data)
    {
      
     
     if(data.error_user)
     {
           $('#register_submit').attr('disabled', false); 
         
      if(data.name_register_error != '')
      {
       $('#user_name_error').html(data.name_register_error);
      }
      else
      {
       $('#user_name_error').html('');
      }
      if(data.phone_register_error != '')
      {
       $('#phone_register_error').html(data.phone_register_error);
      }
      else
      {
       $('#phone_register_error').html('');
      }
      if(data.email_register != '')
      {
       $('#email_register').html(data.email_register);
      }
      else
      {
       $('#email_register').html('');
      }
      if(data.password_error != '')
      {
       $('#password_error').html(data.password_error);
      }
      else
      {
       $('#password_error').html('');
      }
     
      if(data.type_registe_error != '')
      {
       $('#confirm_password_error').html(data.confirm_password_error);
      }
      else
      {
       $('#confirm_password_error').html('');
      }
      //$('#register_form').attr('disabled', false);
     }
     if(data.failed)
     {
          $('#register_submit').attr('disabled', false); 
          
      $('#success_message').html(data.failed);
     }
     if(data.success)
     {
      showAlert(data.class,data.title,data.message);	
      $('#myModal').modal('hide');
          $('#register_submit').attr('disabled', false); 
          login_area();
       $('.errors').html('');
       $('#form_user_register')[0].reset();
       
        
     }
    
    }
   })
  });

  function login_area()
    {
      
        var action = 'fetch_data';
       
        $.ajax({
          url:  BaseUrl+'chack-sing-in',
            method:"POST",
            dataType:"JSON",
            data:{action:action},
            success:function(data)
            {
                $('#login_area').html(data.output);

                if (document.querySelector('#bookingButton')) {
                    $('#bookingButton').html(data.bookingbutton);
                } else {
               
                }
                
            }
        })
    }
    



});



</script>