
<?php 

use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();
   $session = session();
  $webdetails =  $commanmodel->get_single_query('address',array('id' => 1));
?> 
<!DOCTYPE html>
<html lang="en">
	
<!-- Mirrored from andit.co/projects/html/andshop/andshop-dashboard/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 25 Dec 2024 09:12:21 GMT -->
<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Andshop - Admin Dashboard HTML Template.">

		<title>Andshop - Admin Dashboard HTML Template.</title>
		
		<!-- GOOGLE FONTS -->
		<link rel="preconnect" href="https://fonts.googleapis.com/">
		<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&amp;family=Poppins:wght@300;400;500;600;700;800;900&amp;family=Roboto:wght@400;500;700;900&amp;display=swap" rel="stylesheet">

		<link href="<?php echo base_url('assets/admin/'); ?>/assets/css/materialdesignicons.min.css" rel="stylesheet" />
		
		<!-- custom css -->
		<link id="style.css" rel="stylesheet" href="<?php echo base_url('assets/admin/'); ?>/assets/css/style.css" />
		
		<!-- FAVICON -->
		<link href="<?php echo base_url('assets/admin/'); ?>/assets/img/favicon.png" rel="shortcut icon" />
	</head>
	
	<body class="sign-inup" id="body">
		<div class="container">
			<div class="row g-0"> 
				<div class="col-lg-10 offset-lg-1">
					<div class="row g-0">
						<div class="col-lg-6">
							<div class="login_area_left_wrapper">
								    <div class="mylogo">
	<img src="<?php echo base_url('assets/img/'); ?>/<?php echo $webdetails->header_logo; ?>" alt="" >								        </div>
								
									<div class="mytext"> <h1>Welcome To  <span>Heywansaa</span></h1>
						<p>Welcome to Heywansaa, the ultimate destination for a vibrant and diverse online shopping experience! As a leading multivendor ecommerce platform, our mission is to connect buyers with sellers from all corners of the world, forging a thriving marketplace where unique products and exceptional services converge.

</p>
<p>At Heywansaa, we understand the modern consumer's yearning for convenience, variety, and quality. That's why we've meticulously curated an extensive collection of products across a multitude of categories, ensuring there's something to cater to every taste and preference.

</p>
	
					
							
							</div>
							</div>
						</div>
					
						
<div class="col-lg-6">
    
							<div class="login_area_right_wrapper"> 
								<div class="login_area_right_heading">
								    <a href="https://heywansaa.com" class="go-button">Go To Website</a>
								
									 <?php if(session()->getFlashdata('registration_success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('registration_success') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('registration_failed')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('registration_failed') ?>
        </div>
    <?php endif; ?>
								</div>
								<div class="login_form_wrapper">
								<form action="<?php echo base_url('vender_register'); ?>" method="post" class="modern-login-form">
  
  <h3 class="login-heading">Create Your Account</h3>
  <p class="login-subheading">Join <span class="brand-name">Heywansaa</span> to start selling</p>

  <!-- Name -->
  <div class="form-group">
    <label>User Name</label>
    <input type="text" class="modern-input" name="name" placeholder="Enter username" value="<?= old('name') ?>">
    <?php if (isset($validation) && $validation->getError('name')): ?>
      <p class="error-text"><?= $validation->getError('name') ?></p>
    <?php endif; ?>
  </div>

  <!-- Email -->
  <div class="form-group">
    <label>Email Address</label>
    <input type="email" class="modern-input" name="email" placeholder="Enter email address" value="<?= old('email') ?>">
    <?php if (isset($validation) && $validation->getError('email')): ?>
      <p class="error-text"><?= $validation->getError('email') ?></p>
    <?php endif; ?>
  </div>

  <!-- Phone -->
  <div class="form-group">
    <label>Phone Number</label>
    <input type="text" class="modern-input" name="phone" placeholder="Enter phone number" value="<?= old('phone') ?>">
    <?php if (isset($validation) && $validation->getError('phone')): ?>
      <p class="error-text"><?= $validation->getError('phone') ?></p>
    <?php endif; ?>
  </div>

  <!-- Password -->
  <div class="form-group">
    <label>Password</label>
    <input type="password" class="modern-input" name="password" placeholder="Enter password" value="<?= old('password') ?>">
    <?php if (isset($validation) && $validation->getError('password')): ?>
      <p class="error-text"><?= $validation->getError('password') ?></p>
    <?php endif; ?>
  </div>

  <!-- Confirm Password -->
  <div class="form-group">
    <label>Confirm Password</label>
    <input type="password" class="modern-input" name="confirm_password" placeholder="Confirm password" value="<?= old('confirm_password') ?>">
    <?php if (isset($validation) && $validation->getError('confirm_password')): ?>
      <p class="error-text"><?= $validation->getError('confirm_password') ?></p>
    <?php endif; ?>
  </div>

  <!-- Terms -->
  <div class="forgot-link mb-3">
    <p style="font-size:13px">By registering you agree to the <strong>Heywansaa</strong> Terms of Service</p>
  </div>

  <!-- Register Button -->
  <button type="submit" class="btn login-btn w-100">Register</button>

  <!-- Divider -->
  <div class="divider">
    <span>Already have an account?</span>
  </div>

  <!-- Login Link -->
  <a href="<?php echo base_url('admin'); ?>" class="btn register-btn w-100">Login</a>
</form>
								</div>
							</div>
						</div>
						
						
						
					</div>
				</div>
			</div>
		</div>
	
		<!-- Javascript -->
		<script src="<?php echo base_url('assets/admin/'); ?>/assets/plugins/jquery/jquery-3.5.1.min.js"></script>
		<script src="<?php echo base_url('assets/admin/'); ?>/assets/js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo base_url('assets/admin/'); ?>/assets/plugins/jquery-zoom/jquery.zoom.min.js"></script>
		<script src="<?php echo base_url('assets/admin/'); ?>/assets/plugins/slick/slick.min.js"></script>
	
		<!-- custom js -->	
		<script src="<?php echo base_url('assets/admin/'); ?>/assets/js/custom.js"></script>
	</body>


<!-- Mirrored from andit.co/projects/html/andshop/andshop-dashboard/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 25 Dec 2024 09:12:21 GMT -->
</html>


