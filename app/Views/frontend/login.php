   <main class="main log-new-main">
            <div class="container">
            <div class="row">
        <div class="col-md-12">
      <div class="row" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div class="col-md-6" style="width: 100%; max-width: 600px;">
        <div class="wrapper my-5">
            <div class="title-text">
                <div class="title login">Login Form</div>
                <div class="title signup">Signup Form</div>
            </div>
            <div class="form-container">
                <div class="slide-controls">
                    <input type="radio" name="slide" id="login" checked="">
                    <input type="radio" name="slide" id="signup">
                    <label for="login" class="slide login">Login</label>
                    <label for="signup" class="slide signup">Signup</label>
                    <div class="slider-tab"></div>
                </div>
                <div class="form-inner">
                    <form id="user_login" class="login">
                        
                      
                        
                        
                        <div class="field">
                            <input type="text" placeholder="Email Address"  name="login_email" required="">
                              <p id="login_email_error" class="errors"></p>
                        </div>
                        <div class="field">
                            <input type="password" placeholder="Password" name="login_password" required="">
                            <p id="login_password_error" class="errors"></p>
                        </div>
                        <div class="pass-link">
                            <a href="<?php echo base_url('auth/forgotPassword'); ?>">Forgot password?</a>
                        </div>
                        <div class="field ">
                          
                             <input type="hidden" required autocomplete="off" name="user_login" value="Login" />
                             <button class="btn btn-block" type="submit">SIGN IN</button>
                        </div>
                        <div class="signup-link">
                            Not a member? <a href="">Signup now</a>
                        </div>
                    </form>
                    <form id="form_user_register" class="signup">
                        
                         <div class="field">
                            <input type="text" placeholder="Full Name" name="name_register" required="">
                             <p id="user_name_error" class="errors"></p>
                        </div>
                         <div class="field">
                            <input type="text" placeholder="Phone Number" name="phone_register" required="">
                             <p id="phone_register_error" class="errors"></p>
                        </div>
                        
                        <div class="field">
                            <input type="text" placeholder="Email Address" name="email_register" required="">
                             <p id="email_register" class="errors"></p>
                        </div>
                        <div class="field">
                            <input type="password" placeholder="Password" name="password" required="">
                            <p id="password_error" class="errors"></p>
                        </div>
                        <div class="field">
                            <input type="password" placeholder="Confirm password" name="confirm_password" required="">
                             <p id="confirm_password_error" class="errors"></p>
                        </div>
                        <div class="field ">
                           <button class="btn btn-block" type="submit">CREATE ACCOUNT</button>
                            <input type="hidden" required autocomplete="off" name="new_register" value="Newregister" />
                             
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


            </div>
             </div>
              </div>
            <!-- End .container -->

            <div class="mb-4"></div>
            <!-- margin -->
        </main>
        <!-- End .main -->



     <script>
      const loginText = document.querySelector(".title-text .login");
      const loginForm = document.querySelector("form.login");
      const loginBtn = document.querySelector("label.login");
      const signupBtn = document.querySelector("label.signup");
      const signupLink = document.querySelector("form .signup-link a");
      signupBtn.onclick = (()=>{
        loginForm.style.marginLeft = "-50%";
        loginText.style.marginLeft = "-50%";
      });
      loginBtn.onclick = (()=>{
        loginForm.style.marginLeft = "0%";
        loginText.style.marginLeft = "0%";
      });
      signupLink.onclick = (()=>{
        signupBtn.click();
        return false;
      });
    </script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
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

function login_area() {
    var action = 'fetch_data';

    $.ajax({
        url: BaseUrl + 'chack-sing-in',
        method: "POST",
        dataType: "JSON",
        data: { action: action },
        success: function(data) {
            $('#login_area').html(data.output);
          if (data.success) {
                // Redirect to dashboard
                window.location.href = data.url;
            }
            if (document.querySelector('#bookingButton')) {
               
                $('#bookingButton').html(data.bookingbutton);
            }

          
        }
    });
}

    



});



</script>
