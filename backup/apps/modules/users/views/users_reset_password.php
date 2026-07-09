<?php $this->load->view('top');
$adminRes = get_site_email();  ?>

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
  <!--        <h1 class="page-title mb-0">Reset User's Password</h1>-->
  <!--    </div>-->
  <!--</div>-->
  <!-- End of Page Header -->

  <!-- Start of Breadcrumb -->
  <nav class="breadcrumb-nav">
      <div class="container">
          <ul class="breadcrumb">
              <h1 class="page-title mb-0">Reset User's Password</h1>
              <li><a href="<?php echo base_url(); ?>">Home</a></li>
              <li> Reset User's Password</li>
          </ul>
      </div>
  </nav>
  <!-- End of Breadcrumb -->
  <div class="page-content">
      <div class="container">
          <div class="login-popup">
              <div class="tab-content">
                  <form method="post" id="resetvendorpasswordform"  class="tab-pane active"  action="<?php echo base_url().'user/resetnow/password' ?>">
                        <?php echo $this->session->flashdata('reset_user_password_msg'); ?>
                      <div class="form-group">
                          <label>Email address *</label>
                          <input class="form-control" name="email" type="email" placeholder="Enter Email" value="<?php echo $this->session->userdata('user_reset_password_email'); ?>" readonly required>
                      </div>
                      <div class="form-group">
                          <label>OTP *</label>
                          <input class="form-control" name="otp" type="number" placeholder="Enter OTP" required>
                          <span>Enter OTP Which is send on your  Email-ID</span>
                      </div>
                      <div class="form-group">
                          <label>Password *</label>
                          <input class="form-control" name="password" type="password" placeholder="Enter Password" required>
                      </div>
                      <div class="form-group">
                          <label>Re-Enter Password *</label>
                          <input class="form-control" name="password2" type="password" placeholder="Re-Enter Password" required>
                      </div>
                      <div class="form-checkbox d-flex align-items-center justify-content-between">
                            <button type="submit" class="w-100 btn btn-primary">Reset Now </button>
                      </div>
                      <p>
                          <b>Note:</b>
                           We send OTP on your registered Email ID.
                      </p>
                  </form>
              </div>
          </div>
      </div>
  </div>
</main>
<!-- End of Main -->



<?php $this->load->view('bottom'); ?>