<?php $this->load->view('top');
// $adminRes = get_site_email(); 
?>

<style>
    .alert-success{
        background-color:green;
        color:#fff;
        padding: 4px;
        border-radius: 2px;
    }
    .alert-danger{
        background-color:red;
        color:#fff;
        padding: 4px;
        border-radius: 2px;
    }
</style>

















 <!-- Start of Main -->
<main class="main login-page">
  <!-- Start of Page Header -->
  <!--<div class="page-header">-->
  <!--    <div class="container">-->
  <!--        <h1 class="page-title mb-0">Vendor Signin/Signup</h1>-->
  <!--    </div>-->
  <!--</div>-->
  <!-- End of Page Header -->

  <!-- Start of Breadcrumb -->
  <nav class="breadcrumb-nav">
      <div class="container">
          <ul class="breadcrumb">
              <h1 class="page-title mb-0">Vendor Signin/Signup</h1>
              <li><a href="<?php echo base_url(); ?>">Home</a></li>
              <li>My account</li>
          </ul>
      </div>
  </nav>
  <!-- End of Breadcrumb -->
  <div class="page-content">
      <div class="container">
          <div class="login-popup">
              <?php echo $this->session->flashdata('reset_vendor_password_msg'); echo $this->session->userdata('error'); $this->session->unset_userdata('error'); ?>
              <div class="tab tab-nav-boxed tab-nav-center tab-nav-underline">
                  <ul class="nav nav-tabs text-uppercase" role="tablist">
                      <li class="nav-item">
                          <a href="#sign-in" class="nav-link active">Sign In</a>
                      </li>
                      <li class="nav-item">
                          <a href="#sign-up" class="nav-link">Sign Up</a>
                      </li>
                  </ul>
                  <div class="tab-content">
                      <form method="post"  class="tab-pane active" id="sign-in" action="<?php echo base_url().'wps-admin' ?>">
	                          <div class="form-group">
	                              <label>Username or email address *</label>
	                              <input type="text" class="form-control" name="username" type="email" required="" value="<?php echo set_value('login_mobile'); ?>" autocomplete="off" required>
	                          </div>
	                          <div class="form-group mb-0">
	                              <label>Password *</label>
	                              <input type="password" class="form-control"  name="password" type="password" required="" autocomplete="new-password" required>
	                          </div>
	                          <div class="form-checkbox d-flex align-items-center justify-content-between">
	                              <input type="checkbox" class="custom-checkbox" id="remember1" name="remember1" >
	                              <label for="remember1">Remember me</label>
	                              <a href="<?php echo base_url().'registartion/vendor/forgotpassword' ?>">Forgot your password?</a>
	                          </div>
	                            <input type="hidden" name="action" value="submit">
	                          <!-- <a href="#" class="btn btn-primary">Sign In</a> -->
		                            <button type="submit" class="w-100 btn btn-primary">Sign In</button>
		                     
                            </form>
                            
                            <form class="tab-pane" id="sign-up">
	                          <div class="form-group">
	                              <label>Your email address *</label>
	                              <input type="text" class="form-control" name="email" id="email" value="" required>
	                          </div>
	                          <div class="form-group mb-5">
	                              <label>Password *</label>
	                              <input type="password" class="form-control" name="password" id="password" value="" min="8" required>
	                          </div>
	                           <div class="form-group mb-5">
	                                  <label>First Name *</label>
	                                  <input type="text" class="form-control" name="first_name" id="first_name" value="" required>
	                              </div>
	                              <div class="form-group mb-5">
	                                  <label>Last Name *</label>
	                                  <input type="text" class="form-control" name="last_name" id="last_name" value="" required>
	                              </div>
	                              <div class="form-group mb-5">
	                                  <label>Phone Number *</label>
	                                  <input type="text" class="form-control" name="phone_number" id="phone_number" value=""  required>
	                              </div>
	                              <div class="form-group mb-5">
	                                  <label>Bussiness Name *</label>
	                                  <input type="text" class="form-control" name="shop_name" id="shop_name" value="" required>
	                              </div>
	                              <!--<div class="form-group mb-5">-->
	                              <!--    <label>Shop URL *</label>-->
	                              <!--    <input type="text" class="form-control" name="shop_url" id="shop-url" required>-->
	                              <!--    <small></small>-->
	                              <!--</div>-->
	                              
	                          <div class="checkbox-content login-vendor">
	                             
	                          </div>
	                          <script> var base_url='<?php echo base_url();?>';</script>
	                          <div class="form-checkbox user-checkbox mt-0">
	                             
	                                <label >
	                                    <input type="hidden"class="check-seller"  name="usertype" id="usertype" value="vendor"  required>
	                                   
	                                </label>
	                          </div>
	                           <div class="form-checkbox user-checkbox mt-0 text-center">
	                                <input type="button" id="signUpBtn" class="w-100 btn btn-primary" value="Signup">    
	                                <div class="" id="msg_error_success">
	                                </div>
	                           </div>
	                          <p>Your personal data will be used to support your experience 
	                              throughout this website, to manage access to your account, 
	                              and for other purposes described in our <a href="#" class="text-primary">privacy policy</a>.</p>
                      </form>
                  </div>
                 
              </div>
          </div>
      </div>
  </div>
</main>
<!-- End of Main -->

<?php $this->load->view('bottom'); ?>
<script>
// signUpBtn
$('#signUpBtn').on('click',function()
{
    
    var email           =   $('#email').val();
    var password        =   $('#password').val();
    var first_name      =   $('#first_name').val();
    var last_name       =   $('#last_name').val();
    var shop_name       =   $('#shop_name').val();
    var phone_no        =   $('#phone_number').val();
    var usertype        =   $('input[name="usertype"]').val();
    var msg='';

    if(email=='')
    {
        msg="Email Empty"; 
    }
    else if(password=='')
    {
       msg="empty Password"; 
    }
    else if(password.length<8)
    {
         msg="Password Must be 8 Digit"; 
    }
    
    if(msg=='')
    {
     
       if(usertype=='vendor')
        {
                
                
                if(first_name=='')
                {
                   msg="empty First Name"; 
                   alert(msg);
                   return false;
                }
                else if(last_name=='')
                {
                   msg="empty Last Name"; 
                   alert(msg);
                   return false;
                }
                else if(shop_name=='')
                {
                   msg="empty Shop Name"; 
                   alert(msg);
                   return false;
                }
                else if(phone_no=='')
                {
                   msg="empty Phone No.";
                   alert(msg);
                   return false;
                }
                else if(usertype=='')
                {
                   msg="Empty User No.";
                   alert(msg);
                   return false;
                }
                
            $.ajax({
                url:base_url+'registartion/vendor',
                method:"post",
                data:{email:email,password:password,first_name:first_name,last_name:last_name,shop_name:shop_name,phone_no:phone_no,usertype:usertype,},
                success:function(res)
                {
                    var data=JSON.parse(res);
                    if(data.status=='1')
                    {
                        $('#msg_error_success').html(data.response);
                        
                        setTimeout(function(){
                            
                             window.location.reload();
                        },4000);
                      
                    }
                    else
                    {
                        $('#msg_error_success').html(data.response);
                        return false;
                    }
                  
                }
            })
        }
        else
        {
             $.ajax({
                url:base_url+'users/customersignup',
                method:"post",
                data:{email:email,password:password,usertype:usertype,},
                success:function(res)
                {
                    var data=JSON.parse(res);
                    if(data.status=='1')
                    {
                        $('#msg_error_success').html(data.response);
                        
                        setTimeout(function(){
                            
                             window.location.reload();
                        },4000);
                      
                    }
                    else
                    {
                        $('#msg_error_success').html(data.response);
                        return false;
                    }
                  
                }
            })
        } 
    }
    else
    {
        alert(msg); return false;
    }
     
    
  
   
});
    
</script>

<script>
    // $('#sign-in').on('click',function(){
    //      $.ajax({
    //             url:base_url+'wps-admin',
    //             method:"post",
    //             data:{username:email,password:password},
    //             success:function(res)
    //             {
    //                 var data=JSON.parse(res);
    //                 if(data.status=='1')
    //                 {
    //                     $('#msg_error_success').html(data.response);
                        
    //                     setTimeout(function(){
                            
    //                          window.location.reload();
    //                     },4000);
                      
    //                 }
    //                 else
    //                 {
    //                     $('#msg_error_success').html(data.response);
    //                     return false;
    //                 }
                  
    //             }
    //         })
    // })
</script>
<script src="<?php echo base_url();?>assets/sitepanel/assets/js/lostpwd.js"></script>
