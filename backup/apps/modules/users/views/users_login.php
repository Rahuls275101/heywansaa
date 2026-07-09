<?php $this->load->view('top');
// $adminRes = get_site_email(); 
?>
<style>
    .alert-success{
        background-color:green;
        color:#fff;
    }
    .alert-danger{
        background-color:red;
        color:#fff;
    }
</style>















 <!-- Start of Main -->
<main class="main login-page">
  <!-- Start of Page Header -->
  <!--<div class="page-header">-->
  <!--    <div class="container">-->
  <!--        <h1 class="page-title mb-0">My Account</h1>-->
  <!--    </div>-->
  <!--</div>-->
  <!-- End of Page Header -->

  <!-- Start of Breadcrumb -->
  <nav class="breadcrumb-nav">
      <div class="container">
          <ul class="breadcrumb">
              <h1 class="page-title mb-0">My Account</h1>
              <li><a href="<?php echo base_url(); ?>">Home</a></li>
              <li>My account</li>
          </ul>
      </div>
  </nav>
  <!-- End of Breadcrumb -->
  <div class="page-content">
      <div class="container">
          <div class="login-popup">
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
                      <form method="post"  class="tab-pane active" id="sign-in">
                          <?php echo $this->session->flashdata('reset_user_password_msg');
                          
                          echo "<div class='alert alert-danger'>".$this->session->flashdata('error')."</div>"; ?>
	                          <div class="form-group">
	                              <label>Username or email address *</label>
	                              <input type="text" class="form-control" name="login_mobile" type="email" required="" value="<?php echo set_value('login_mobile'); ?>" autocomplete="off" required>
	                          </div>
	                          <div class="form-group mb-0">
	                              <label>Password *</label>
	                              <input type="password" class="form-control"  name="login_password" type="password" required="" autocomplete="new-password" required>
	                          </div>
	                          <div class="form-checkbox d-flex align-items-center justify-content-between">
	                              <input type="checkbox" class="custom-checkbox" id="remember1" name="remember1" >
	                              <label for="remember1">Remember me</label>
	                              <a href="<?php echo base_url().'forgetpassword'?>">Forget your password?</a>
	                          </div>
	                    
	                          <!-- <a href="#" class="btn btn-primary">Sign In</a> -->
		                            <button type="submit" class="w-100 btn btn-primary">Sign In</button>
		                      
                      </form>
                            <form class="tab-pane" id="sign-up">
	                          <div class="form-group">
	                              <?php echo form_error('email'); ?>
	                              <label>Your email address *</label>
	                              <input type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email'); ?>" required>
	                              
	                          </div>
	                          <div class="form-group mb-5">
	                              <?php echo form_error('password'); ?>
	                              <label>Create Password *</label>
	                              <input type="password" class="form-control" name="password" id="password" min="8" value="<?php echo set_value('password'); ?>" required>
	                              
	                          </div>
	                          <div class="checkbox-content">
	                              <div class="form-group mb-5">
	                                  <?php echo form_error('first_name'); ?>
	                                  <label>First Name *</label>
	                                  <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo set_value('first_name'); ?>" required>
	                                  
	                              </div>
	                              <div class="form-group mb-5">
	                                  <?php echo form_error('last_name'); ?>
	                                  <label>Last Name *</label>
	                                  <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo set_value('last_name'); ?>" required>
	                                  
	                              </div>
	                              <div class="form-group mb-5">
	                                  <?php echo form_error('phone_number'); ?>
	                                  <label>Phone Number *</label>
	                                  <input type="text" class="form-control" name="phone_number" id="phone_number" value="<?php echo set_value('phone_number'); ?>"  required>
	                                  
	                              </div>
	                          </div>
	                          <script> var base_url='<?php echo base_url();?>';</script>
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
  
    var phone_no        =   $('#phone_number').val();
    var usertype        =   'customer';
    var msg='';

    if(email=='')
    {
        msg="Email Empty"; 
    }
    else if(password=='')
    {
       msg="empty Password"; 
    }
    
    if(msg=='')
    {
     
       
             $.ajax({
                url:base_url+'users/customersignup',
                method:"post",
                data:{email:email,password:password,usertype:usertype,first_name:first_name,last_name:last_name,phone_no:phone_no,},
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
        alert(msg); return false;
    }
     
    
  
   
});
    
</script>



