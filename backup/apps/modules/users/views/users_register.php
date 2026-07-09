<?php $this->load->view('top');
$adminRes = get_site_email();  ?>
<!--<div class="page_breadcrumbs">-->
<!--		<div class="container">-->
<!--			<ul>-->
<!--			    <h1 class="page-title mb-0">All Category</h1>-->
<!--                <li><a href="<?=site_url();?>" title="Home">Home</a></li>-->
<!--                <li>Register</li>-->
<!--			</ul>-->
<!--		</div>-->
<!--	</div>-->
	
   <!-- Start of Breadcrumb -->
   <nav class="breadcrumb-nav">
      <div class="container">
         <ul class="breadcrumb bb-no">
            <h1 class="page-title mb-0">Register</h1>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li>Register</li>
         </ul>
      </div>
   </nav>
   <!-- End of Breadcrumb -->	
	
	
	<section class="login_page">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-lg-push-3">
					<div class="panel-lite">
						<div class="thumbur">
                           <i class="fa fa-user"></i>
						</div>
						<h4>Signup Now</h4>
						<?php echo form_open('', 'name="login_frm" id="regisFrm" class="register-form"'); ?>
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<div class="form-group">
										<input class="form-control" name="first_name" type="text" required="required" value="<?php echo set_value('first_name'); ?>">
										<label class="form-label">User Name*</label>
                                        <?php echo form_error('first_name'); ?>
									</div>
								</div>
								<div class="col-lg-6 col-md-6">
									<div class="form-group">
										<input class="form-control" type="email" name="email_address" required="required" value="<?php echo set_value('email_address'); ?>" autocomplete="off">
										<label class="form-label">Email ID*</label>
                                        <?php echo form_error('email_address'); ?>
									</div>
								</div>
								<div class="col-lg-6 col-md-6">
									<div class="form-group">
										<input class="form-control" type="tel" name="mobile_number" maxlength="10" minlength="10" onKeyPress="return isNumberKey(event)" required="required" value="<?php echo set_value('mobile_number'); ?>">
										<label class="form-label">Phone Number*</label>
                                        <?php echo form_error('mobile_number'); ?>
									</div>
								</div>
								<!-- <div class="col-lg-6 col-md-6">
									<div class="form-group">
										<div class="radio register">
											<label class="radio_button" for="male">
												<input id="male" type="radio" name="text" value="male" checked="">Male</label>
											<label class="radio_button" for="female">
												<input id="female" type="radio" name="text" value="female">Female</label>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-6">
									<div class="form-group">
										<input class="form-control" type="text" name="date" required="required">
										<label class="form-label">Date of Birth*</label>
									</div>
								</div> -->
								<div class="col-lg-6 col-md-6">
									<div class="form-group">
										<input class="form-control" type="password" name="password" required="required" autocomplete="off">
										<label class="form-label">Password*</label>
                                        <?php echo form_error('password'); ?>
									</div>
								</div>
								<div class="col-lg-6 col-md-6">
									<div class="form-group">
										<input class="form-control" name="c_password" type="password" required="required" autocomplete="new-password">
										<label class="form-label">Confirm Password*</label>
                                        <?php echo form_error('c_password'); ?>
									</div>
								</div>
								<div class="col-lg-12 col-md-12">
									<div class="form-group">
										<label>
											<input type="checkbox" name="checkbox" checked="" required>I agree to the <a href="privacy-policy.php">Terms and Conditions</a>
										</label> <a class="pull-right" href="javascript:void(0);" onclick="window.location.href=site_url+'login'" >Already have an account</a>
									</div>
								</div>
                                <input type="hidden" name="action" value="register" />
								<button class="floating-btn"><i class="icon-arrow"></i>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php $this->load->view('bottom'); ?>
