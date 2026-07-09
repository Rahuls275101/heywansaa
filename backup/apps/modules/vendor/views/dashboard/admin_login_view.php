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
    <link rel="icon" type="image/x-icon" href="<?php echo admin_url(); ?>assets/img/favicon.jpeg"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?php echo admin_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo admin_url(); ?>assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo admin_url(); ?>assets/css/authentication/form-1.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="<?php echo admin_url(); ?>assets/css/forms/theme-checkbox-radio.css" rel="stylesheet" type="text/css">
    <link href="<?php echo admin_url(); ?>assets/css/forms/switches.css" rel="stylesheet" type="text/css">
    <link href="<?php echo admin_url(); ?>assets/css/elements/alert.css" rel="stylesheet" type="text/css" >
    <style>
        .form-control {
    height: auto;
    border: 1px solid #bfc9d4;
    color: #3b3f5c;
    font-size: 15px;
    padding: 8px 10px;
    letter-spacing: 1px;
    height: calc(1.4em + 1.4rem + 2px);
    padding: 0.75rem 2.25rem;
    border-radius: 6px;
}

svg {
    overflow: hidden;
    vertical-align: middle;
    position: absolute;
    margin-top: 10px;
    padding: 3px;
}
    </style>
  </head>
  <body class="form" style="background-color:black;overflow:hidden">
    <div class="container" style="margin-top:100px">
      <div class="row">
         
            <div class="col-md-4"></div>
            <div class="col-md-4 card">
                 <div class="card-body">
                     <div class="text-center">
                        <img src="<?php echo admin_url(); ?>assets/img/logo.png" style="height:75px;padding:10px">
                     </div>
              <!--<h2 class="text-center"> -->
                <!--<a href="<?php echo site_url(); ?>wps-admin"><span class="brand-name"><?php echo SITENAME; ?></span></a>-->
            <!--</h2>-->
              <?php echo error_message(); ?>
              <?php echo logout_message(); ?>
              <form action="<?php echo site_url(); ?>wps-admin" method="post" class="text-left">
                <div class="form">
                  <div id="username-field" class="field-wrapper input">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <input id="username" name="username" autocomplete="off" required value="<?php echo set_value('username'); ?>" type="text" class="form-control" placeholder="Username">
                    <?php echo form_error('username'); ?>
                  </div>
                    <br>
                  <div id="password-field" class="field-wrapper input mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <input id="password" required autocomplete="off" name="password" type="password" class="form-control" placeholder="Password">
                    <?php echo form_error('password'); ?>
                  </div>
                  <div class="d-sm-flex justify-content-between">
                    <div class="field-wrapper toggle-pass">
                      <p class="d-inline-block">Show Password</p>
                      <label class="switch s-primary"><br>
                        <input type="checkbox" id="toggle-password" class="d-none">
                        <span class="slider round"></span>
                      </label>
                    </div>
                    <div class="field-wrapper">
                      <input type="hidden" name="action" value="submit" />
                      <button type="submit" class="btn btn-warning" value="">Log In</button>
                    </div>
                  </div>
               
                  <div class="field-wrapper">
                    <a href="<?php echo site_url(); ?>wps-admin/forgot-password" class="forgot-pass-link">Forgot Password?</a>
                  </div>
                </div>
              </form>                        
            </div>                    
          </div>
          <div class="col-md-12">
          <div class="field-wrapper text-center">
            <p class="terms-conditions text-white">All Rights Reserved. Powered By <a class="text-info" href="https://www.weblieu.com/" target="_blank">Weblieu</a></p>
          </div>
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