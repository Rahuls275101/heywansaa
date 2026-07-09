<?php $this->load->view('top');
// $adminRes = get_site_email(); 
?>
<style>
.alert-success{
    background-color:green;
    color:#fff;
}
.alert-danger{
    background-color:red;
    color:#fff;
}

</style>






 <!-- Start of Main -->
<main class="main login-page">
  <!-- Start of Page Header -->
  <!--<div class="page-header">-->
  <!--  <img src="<?php echo base_url('assets/designer/themes/default/assets/images/friends.jpg')?>" alt="Picture">-->
  <!--  <div class="container">-->
  <!--      <div class="overlay">-->
  <!--      <h1 class="page-title mb-0">Recommond  Friend/Family</h1>-->
  <!--      </div>-->
  <!--  </div>-->
  <!--</div>-->
  
   <nav class="breadcrumb-nav">
      <div class="container">
          <ul class="breadcrumb">
              <h1 class="page-title mb-0">Recommond  Friend/Family</h1>
              <li><a href="<?php echo base_url(); ?>">Home</a></li>
              <li>Recommond  Friend/Family</li>
          </ul>
      </div>
  </nav>
  
  <!-- End of Page Header -->
   <div class="page-content">
      <div class="container">
        <div class="familycont">
            <div class="row">
            <div class="col-md-4">
            <img class="img-responsive" src="<?php echo base_url('assets/designer/themes/default/assets/images/family.png')?>" alt="Picture">
            </div>
            <div class="col-md-8"> 
            <div class="cont"> 
                <h1>Recommond  Friend/Family</h1>
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                    when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                </p>
                 <a class="btn btn-share" href="https://wa.me/?text=Welcome to heywansaa
                                                Ecommerce For explore click on https://kerrys.co.in/demo/2heywansa/" target="_blank">
                <i class="fab fa-whatsapp"></i>Share Now</a>
           </div>
       </div>
       </div>
        </div>
      </div>
  </div> 

 
  
</main>
<!-- End of Main -->



<?php $this->load->view('bottom'); ?>