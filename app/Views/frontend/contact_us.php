<?php 

use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();
   $addressView = $commanmodel->get_single_query('address',array('id' => 1)); 
?>

		<main class="main">
			<div class="page-header page-header-bg text-left" style="background: linear-gradient(rgba(149, 211, 255, 0.6), rgba(149, 211, 255, 0.6)), 
				50% / cover #95d3ff url(assets/images/contactus.jpg);
	background-attachment: fixed;
	">
				<div class="container">
					<h1>
						Contact Us</h1>
				</div><!-- End .container -->
			</div><!-- End .page-header -->

	

			<div class="container contact-us-container">
				

				<div class="row">
					<div class="col-lg-6">
						<h2 class="mt-2 mb-2">Send Us a Message</h2>

						<form class="mb-0" action="#" style="padding: 10px;
						background: #efebeb;">
							<div class="form-group">
								<label class="mb-1" for="contact-name">Your Name
									<span class="required">*</span></label>
								<input type="text" class="form-control" id="contact-name" name="contact-name"
									required />
							</div>

							<div class="form-group">
								<label class="mb-1" for="contact-email">Your E-mail
									<span class="required">*</span></label>
								<input type="email" class="form-control" id="contact-email" name="contact-email"
									required />
							</div>

							<div class="form-group">
								<label class="mb-1" for="contact-message">Your Message
									<span class="required">*</span></label>
								<textarea cols="30" rows="1" id="contact-message" class="form-control"
									name="contact-message" required></textarea>
							</div>

							<div class="form-footer mb-0">
								<button type="submit" class="btn btn-dark font-weight-normal">
									Send Message
								</button>
							</div>
						</form>
					</div>

					<div class="col-lg-6">
						<div class="row mt-5">
							<div class="col-sm-12 col-lg-12">
							    <div class="myboxkds">
								<div class="feature-box text-center">
									<i class="sicon-location-pin"></i>
									<div class="feature-box-content">
										<h3>Address</h3>
										<!--<h5><?php echo $addressView->address; ?></h5>-->
										<h5>Noida Sector 75</h5>
									</div>

								</div>
								
									<div class="feature-box text-center">
									    <a href="https://wa.me/+919650997687" target="_blank">
									     <i class="fab fa-whatsapp"></i> 
									<div class="feature-box-content">
										<h3>Chat on WhatsApp</h3>
									
										<h5></h5>
									</div>
									</a>

								</div>
								
									<div class="feature-box text-center">
<i class="fas fa-clock"></i>
									<div class="feature-box-content">
										<h3>Support</h3>
 Mon – Fri, 9 AM to 5 PM
									</div>

								</div>
								
</div></div>
							</div>
							
							
							<div class="col-md-12">																	<div><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4981.953540793273!2d77.381958!3d28.576023!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cef63da3a3cc7%3A0x36104e84b0d9a985!2sSector%2075%2C%20Noida%2C%20Uttar%20Pradesh!5e1!3m2!1sen!2sin!4v1751612622067!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
</div>
							
							
						</div>
						
					</div>
				</div>
			</div>

			<div class="mb-8"></div>
		</main>