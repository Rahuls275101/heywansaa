<?php

function validation_message($style = "") {// by default On Page - set 'alert' for pop-up
  $processing_result = validation_errors();
  if ($processing_result != '') {
    ?>
    <div class="validation" >
      <div style="margin-bottom:6px;">
        <strong><span class="red">ERROR!</span><br />
        Please correct the invalid entries in form given below.</strong>
      </div>
      <div class="validation_msg" ><?php echo $processing_result; ?></div>
    </div>
    <?php
  }
}

function error_message($style = "") {
  $ci = &get_instance();
  $msgtype = $ci->session->userdata('error');
  if ($msgtype) {
    ?>
    <div class="alert alert-arrow-right alert-icon-right alert-light-danger mb-4" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
      <svg xmlns="http://www.w3.org/2000/svg" data-dismiss="alert" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
      <strong>Error!</strong><?php echo $msgtype; ?>
    </div> 
    <?php
    $ci->session->unset_userdata('error');
  }
}

function success_message() {
  $ci = &get_instance();
  $msgtype = $ci->session->userdata('success');
  if ($msgtype) {
    ?>
    <div class="alert alert-success mb-4" role="alert"> 
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> 
      <strong>Success!</strong> <?php echo $msgtype; ?>
    </div>
    <?php
    $ci->session->unset_userdata('success');
  }
}


function logout_message() {
  $ci = &get_instance();
  $msgtype = $ci->session->userdata('logout');
  if ($msgtype) {
    ?>
    <div class="alert alert-success mb-4" role="alert"> 
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> 
      <strong>Success!</strong> <?php echo $msgtype; ?>
    </div>
    <?php
    $ci->session->unset_userdata('logout');
  }
}
?>