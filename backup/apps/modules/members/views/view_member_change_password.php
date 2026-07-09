<?php $this->load->view("top"); ?>

 <!-- <div class="page_breadcrumbs">-->
	<!--	<div class="container">-->
	<!--		<ul>-->
 <!--     <li><a href="<?=site_url();?>" title="Home">Home</a>-->
 <!--               </li>-->
 <!--               <li><a href="<?=base_url('my-account');?>" title="My Account">My Account</a>-->
 <!--               </li>-->
 <!--               <li>Change Password</li>-->
	<!--		</ul>-->
	<!--	</div>-->
	<!--</div>-->
	
   <!-- Start of Breadcrumb -->
   <nav class="breadcrumb-nav">
      <div class="container">
         <ul class="breadcrumb bb-no">
            <h1 class="page-title mb-0">Change Password</h1>
                 <li><a href="<?=site_url();?>" title="Home">Home</a></li>
                <li><a href="<?=base_url('my-account');?>" title="My Account">My Account</a></li>
                <li>Change Password</li>
         </ul>
      </div>
   </nav>
   <!-- End of Breadcrumb -->	
	
	
  
  <!----My Accounts---->
  <section class="my_account_page">
    <div class="container">
      <div class="">
        <div class="col-md-9 col-md-push-3">
        <div class="right_side">
          <h1>Change Password</h1>
          <div class="wps_right">
            <div class="row">
            <?php echo form_open();
            echo '<div class="col-lg-11 col-md-push-1">';
          validation_message();
          error_message();
          success_message();
          echo '</div>';
          ?>
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Type Current Password*</label>
                  <input type="text" class="form-control" name="old_password" placeholder="Enter Your Current Password*" required> 
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Type New Password*</label>
                  <input type="text" class="form-control" name="new_password" placeholder="Choose a New Password *" required> 
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Retype New Password*</label>
                  <input type="text" class="form-control" name="confirm_password" placeholder="Confirm Your New Password *" required> 
                </div>
              </div>
             
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <button tabindex="9" class="checkout_btn" type="submit" name="submit">Change Password</button>
                </div>
              </div>
           <?php echo form_close(); ?>
          </div>
        </div>
        </div>
        </div>

      </div>
      <div class="col-md-3 col-md-pull-9">
        <?php $this->load->view('members/left'); ?>
      </div>
    </div>
    </div>
  </section>
  
<?php $this->load->view("bottom"); ?>