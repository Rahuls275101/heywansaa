<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Admin Login | <?php echo SITENAME; ?> </title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?php echo admin_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo admin_url(); ?>assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo admin_url(); ?>assets/css/authentication/form-1.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="<?php echo admin_url(); ?>assets/css/forms/theme-checkbox-radio.css" rel="stylesheet" type="text/css">
    <link href="<?php echo admin_url(); ?>assets/css/forms/switches.css" rel="stylesheet" type="text/css">
    <link href="<?php echo admin_url(); ?>assets/css/elements/alert.css" rel="stylesheet" type="text/css" >
  </head>
  <body style="overflow:hidden;background: #efefef;">
  
  
  
  <div class="container">
      <div class="row mt-5">
           <div class="col-md-3"></div>
          <div class="col-md-6  mt-5">
              <div class="card">
                  <div class="card-body">
                      <form action="<?php echo base_url().'wps-admin/resetpasswordnow'; ?>" method="post">
                          <div class="form-group">
                              <h3>Forgot Password</h3>
                              <p><b>Note:</b> We send a OTP on your Email Please verify for reset password.</p>
                              <label>Enter Your Username</label>
                              <input type="text" name="email" class="form-control" placeholder="username">
                          </div>
                          <div class="form-group text-center">
                             <?php echo $this->session->flashdata('admin_otp'); ?>
                              <label>&nbsp;</label>
                              <input type="submit" class="btn btn-success" value="Reset Now"> 
                          </div>
                          <div class="form-group text-right">
                               <a class="text-danger" href="<?php echo base_url().'wps-admin'; ?>">Login Now</a>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
  
  
  
  
  
  
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo admin_url(); ?>assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="<?php echo admin_url(); ?>bootstrap/js/popper.min.js"></script>
    <script src="<?php echo admin_url(); ?>bootstrap/js/bootstrap.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="<?php echo admin_url(); ?>assets/js/authentication/form-1.js"></script>
  </body>
</html>