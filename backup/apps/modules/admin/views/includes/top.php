<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>      
      <?php
      echo SITENAME;
      if($headingTitle){
        echo ' : '.$headingTitle;
      }
      ?>
    </title>
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/designer/themes/default/assets/images/logo.png"/>
    <link href="<?php echo admin_url(); ?>assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo admin_url(); ?>assets/js/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?php echo admin_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo admin_url(); ?>assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="<?php echo admin_url(); ?>plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="<?php echo admin_url(); ?>assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <!-- for tables and layout -->
    <link rel="stylesheet" type="text/css" href="<?php echo admin_url(); ?>plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="<?php echo admin_url(); ?>assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="<?php echo admin_url(); ?>plugins/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo admin_url(); ?>plugins/table/datatable/custom_dt_custom.css">

    <!-- Sweet Alerts --->
    <script src="<?php echo admin_url(); ?>plugins/sweetalerts/promise-polyfill.js"></script>
    <link href="<?php echo admin_url(); ?>plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo admin_url(); ?>plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo admin_url(); ?>assets/css/components/custom-sweetalert.css" rel="stylesheet" type="text/css" />
    
    <link href="<?php echo admin_url(); ?>assets/css/elements/alert.css" rel="stylesheet" type="text/css">    
    <link href="<?php echo admin_url(); ?>fontawesome/css/all.css" rel="stylesheet">
    
    <script type="text/javascript">
      var base_url = '<?php echo base_url(); ?>';
      var admin_url = '<?php echo base_url(); ?>wps-admin';
    </script>
  </head>
  <body>
    <!-- BEGIN LOADER -->
    <div id="load_screen"> 
      <div class="loader"> 
        <div class="loader-content">
          <div class="spinner-grow align-self-center"></div>
        </div>
      </div>
    </div>
    <!--  END LOADER -->
    <?php
    $this->load->view('includes/header');
    ?>