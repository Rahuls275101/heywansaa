<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="<?php echo admin_url(); ?>assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="<?php echo admin_url(); ?>bootstrap/js/popper.min.js"></script>
<script src="<?php echo admin_url(); ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo admin_url(); ?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?php echo admin_url(); ?>assets/js/app.js"></script>
<script>
  $(document).ready(function () {
    App.init();
  });
</script>
<script src="<?php echo admin_url(); ?>assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="<?php echo admin_url(); ?>plugins/apex/apexcharts.min.js"></script>
<script src="<?php echo admin_url(); ?>assets/js/dashboard/dash_1.js"></script>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

<script src="<?php echo admin_url(); ?>plugins/table/datatable/datatables.js"></script>

<!-- BEGIN THEME GLOBAL STYLE Sweet ALERT -->
<script src="<?php echo admin_url(); ?>assets/js/scrollspyNav.js"></script>
<script src="<?php echo admin_url(); ?>plugins/sweetalerts/sweetalert2.min.js"></script>
<script src="<?php echo admin_url(); ?>plugins/sweetalerts/custom-sweetalert.js"></script>
<!-- END THEME GLOBAL STYLE -->  