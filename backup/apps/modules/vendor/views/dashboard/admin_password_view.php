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
  <body class="form">
    <div class="form-container">
      <div class="form-form">
        <div class="form-form-wrap">
          <div class="form-container">
            <div class="form-content">
              <h1 class="">Password Recovery</h1>
              <p class="signup-link">Enter your email and instructions will sent to you!</p>
              <?php echo error_message(); ?>
              <?php echo success_message(); ?>
              <form action="" method="post" class="text-left">
                <div class="form">
                  <div id="email-field" class="field-wrapper input">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                    <input id="email" name="email" type="email" required autocomplete="off" value="" placeholder="Email"> <?php echo form_error('username'); ?>
                  </div>
                  <div class="d-sm-flex justify-content-between">
                    <div class="field-wrapper">
                      <input type="hidden" name="action" value="submit" />
                      <button type="submit" class="btn btn-primary" value="">Reset Password</button>
                      <a href="<?php echo site_url(); ?>wps-admin">Login Here</a>
                    </div>                                    
                  </div>
                </div>
              </form>                        
            </div>                    
          </div>
          <div class="field-wrapper text-center">
          <p class="terms-conditions">All Rights Reserved. Powered By <a href="https://www.weblieu.com/" target="_blank">weblieu</a></p>
          </div>
        </div>
      </div>
      <div class="form-image">
        <div class="l-image">
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