<?php
$this->load->view('top');
$adminRes = get_site_email();
?>

<!--<section class="banner_category" style="background-image: url('<?php echo theme_url(); ?>images/contact.jpg');">-->
<!--		<div class="container">-->
			<!-- <h2 class="banner_subtitle">check out over <span>200+</span></h2> -->
			<!--<h1 class="banner_title">Contact Us</h1>-->
<!--		</div>-->
<!--	</section>-->
<main>	
   <!-- Start of Breadcrumb -->
   <nav class="breadcrumb-nav">
      <div class="container">
         <ul class="breadcrumb bb-no">
            <h1 class="page-title mb-0">Contact Us</h1>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li>Contact Us</li>
         </ul>
      </div>
   </nav>
   <!-- End of Breadcrumb -->






	<div class="contact_area contact-uspage mt-5 mb-5">
		<div class="container">
			<div class="row">
			    
				<div class="col-lg-7">
					<div class="contact-message">
						<h2 class="contact-title">Drop Your Query</h2>
						<?php if($this->session->flashdata('success')) echo '
          <div class="alert alert-success success" style="padding: 8px 8px 8px 0px;">'.$this->session->flashdata('success').'</div>
          <br/>'; ?>
          <?php if($this->session->flashdata('error')) echo '
          <div class="alert alert-warning error" style="padding: 8px 8px 8px 0px;">'.$this->session->flashdata('error').'</div>
          <br/>'; ?>
                    <form action="" id="contact-form" name="contactform" method="post" class="contact-form">
               
                    
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6 mb-3">
									<div class="form-group">
									    <label class="form-label">Name *</label>
										<input class="form-control" name="first_name"  pattern="[a-z A-Z]+" value="<?php echo set_value('first_name'); ?>" type="text" required="">
										
										<?php echo form_error( 'first_name'); ?>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 mb-3">
									<div class="form-group">
									    <label class="form-label">Phone *</label>
										<input class="form-control" name="phone" type="text"  required="" value="<?php echo set_value('phone'); ?>" maxlength="10" minlength="10" onKeyPress="return isNumberKey(event)">
										
										<?php echo form_error( 'phone'); ?>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 mb-3">
									<div class="form-group">
									    <label class="form-label">Email *</label>
										<input class="form-control" name="email" type="email" required="" value="<?php echo set_value('email'); ?>">
										
										<?php echo form_error( 'email'); ?>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 mb-3">
									<div class="form-group">
									    <label class="form-label">Location *</label>
										<input name="location" class="form-control" type="text" required value="<?php echo set_value('location'); ?>" onKeyPress="return isAlphaNumeric(event)" size="500" ondrop="return false;" onpaste="return false;" onkeyup="isURL(this);">
										
										<?php echo form_error( 'location'); ?>
									</div>
								</div>
								<div class="col-lg-12 col-md-12">
									<div class="form-group">
									    <label class="form-label">Message *</label>
										<textarea name="message" class="form-control textarea1" onKeyPress="return isAlphaNumeric(event)" size="500" ondrop="return false;" onpaste="return false;" onkeyup="isURL(this);" required=""><?php echo set_value('message'); ?></textarea>
										
										<?php echo form_error( 'message'); ?>
									</div>
									
					
                  
									<div class="contact-btn">
									    <br>
										<button class="contact_btn btn btn-success" type="submit">Submit</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-4">
					<div class="contact-info-three">
						<div class="single-info">
							<h2 class="contact-title">Reach To Us</h2>
							
							<ul class="contactpage-list">
							    <li><i class="fas fa-map-marker-alt"></i> B 806, 8TH FLOOR, TOWER B INDOSAM NOIDA SECTOR 75 NA NOIDA Gautam Buddha Nagar Uttar Pradesh 201301</li>
							    
							    
							</ul>
						</div>
						
						<div class="single-info mt-4">
                        <h4>Follow us</h4>
       <!--                 <div class="wrapper-box">-->
       <!--                     <ul class="social-wrap">-->
							<!--<li class="fb"><a href="<?//= ($adminRes->facebook!='')?$adminRes->facebook:'javascript:void(0);';?>" title="Facebook" <?//= ($adminRes->facebook!='')?'target="_blank"':'';?>></a></li>-->
							<!--<li class="tw"><a href="<?//= ($adminRes->twitter!='')?$adminRes->twitter:'javascript:void(0);';?>" title="Twitter" <?//= ($adminRes->twitter!='')?'target="_blank"':'';?>></a></li>-->
							<!--<li class="instagram"><a href="<?//= ($adminRes->instagram!='')?$adminRes->instagram:'javascript:void(0);';?>" title="Instagram" <?//= ($adminRes->instagram!='')?'target="_blank"':'';?>></a></li>-->
							<!--<li class="linkedin"><a href="<?//= ($adminRes->linkedin!='')?$adminRes->linkedin:'javascript:void(0);';?>" title="Linked In" <?= ($adminRes->linkedin!='')?'target="_blank"':'';?>></a></li>-->
							<!--<li class="youtube"><a href="<?//= ($adminRes->youtube!='')?$adminRes->youtube:'javascript:void(0);';?>" title="Youtube" <?//= ($adminRes->youtube!='')?'target="_blank"':'';?>></a></li>-->
       <!--                     </ul>-->
       <!--                 </div>-->
                        
                        <div class="social-icons social-icons-colored">
                                        <a href="<?= ($adminRes->facebook!='')?$adminRes->facebook:'javascript:void(0);';?>" class="social-icon social-facebook w-icon-facebook"></a>
                                        <a href="<?= ($adminRes->twitter!='')?$adminRes->twitter:'javascript:void(0);';?>" class="social-icon social-twitter w-icon-twitter"></a>
                                        <a href="<?= ($adminRes->instagram!='')?$adminRes->instagram:'javascript:void(0);';?>" class="social-icon social-instagram w-icon-instagram"></a>
                                        <!--<a href="https://www.youtube.com/channel/heywansa" class="social-icon social-youtube w-icon-youtube"></a>-->
                                        <!--<a href="https://www.pinterest.ca/heywansa/" class="social-icon social-pinterest w-icon-pinterest"></a>-->
                                    </div>
                    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	 
	</main>
<?php $this->load->view('bottom'); ?>
  