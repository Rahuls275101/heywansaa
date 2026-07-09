<?php $this->load->view('includes/top');
?>
<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">
  <div class="overlay"></div>
  <div class="search-overlay"></div>
  <?php $this->load->view('includes/left'); ?>
  <!--  BEGIN CONTENT AREA  -->
  <div id="content" class="main-content">
    <div class="layout-px-spacing">
      <div class="row layout-top-spacing layout-spacing">
        <div class="col-lg-12">
          <div class="statbox widget box box-shadow">
            <?php
            echo form_open_multipart("wps-admin/location/city_edit/" . $res->id, 'id="data_form"');
            echo success_message();
            ?> 
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                  <h4><?php echo $headingTitle; ?></h4>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right">
                  <h4>
                    <a href="<?php echo base_url(); ?>wps-admin/location/city/" class="btn btn-danger btn-sm mb-2"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Update</button>                    
                  </h4>
                </div>
              </div>
            </div>


            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">


                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>Country</label>
                  <div class="col-sm-6">
                  <select name="country_id" class="form-control" id="country">
                <?php
                if ($country) {
                  foreach ($country as $cnt) {
                    if ($cnt['id'] == $res->country_id) {
                      $sel = "selected";
                    } else {
                      $sel = "";
                    }
                    ?>
                    <option value="<?php echo $cnt['id']; ?>" <?php echo $sel; ?>><?php echo $cnt['name']; ?></option>
                    <?php
                  }
                }
                ?>
              </select>    <?php echo form_error('country'); ?>
                  </div>
                </div>

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>State</label>
                  <div class="col-sm-6">
                  <select name="state_id" class="form-control" id="state">
                <?php
                if ($states) {
                  foreach ($states as $state) {
                    if ($state['id'] == $res->state_id) {
                      $sel = "selected";
                    } else {
                      $sel = "";
                    }
                    ?>
                    <option value="<?php echo $state['id'] ?>" <?php echo $sel; ?>><?php echo $state['name']; ?></option>
                    <?php
                  }
                }
                ?>
              </select><?php echo form_error('state'); ?>
                  </div>
                </div>

                <div class="form-group row  mb-4">
                  <label class="col-sm-3 col-form-label col-form-label-sm"><span class="red">*</span>City</label>
                  <div class="col-sm-6">
                    <div id="ban_postion">
                    <input type="text" class="form-control" name="city" id="city" value="<?php echo set_value('city', $res->city); ?>"> <?php echo form_error('city'); ?>
                    </div>
                  </div>
                </div>
              
              </div>



              <div class="widget-header">
                <div class="row">
                  <div class="col-xl-6 col-md-6 col-sm-6 col-6">&nbsp;</div>
                  <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right">
                    <h4>
                      <a href="<?php echo base_url(); ?>wps-admin/location/city" class="btn btn-danger btn-sm mb-2"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                      <input type="hidden" class="form-control" name="update" value="update" />
                      <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Update</button>
                    </h4>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-wrapper">
        <div class="footer-section f-section-1">
          <p class="terms-conditions">All Rights Reserved. Powered By <a href="https://www.weblieu.com/" target="_blank">weblieu</a></p>
        </div>
        <div class="footer-section f-section-2">
          <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
        </div>
      </div>
    </div>
    <!--  END CONTENT AREA  -->
  </div>
  <!-- END MAIN CONTAINER -->
  <?php $this->load->view('includes/bottom'); ?>
  <script>
  $(document).ready(function () {
    $("#country").change(function () {
      var country = $("#country").val();
      console.log(country);
      $.ajax({
        url: '<?php echo base_url('wps-admin/location/ajax_state'); ?>',
        type: 'post',
        data: ({'country_id': country}),
        success: function (data) {
            console.log(data);
          $("#state").html(data);
        }
      });
    });
  });
</script>
  <?php die(); ?>