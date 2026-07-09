<?php $this->load->view('top'); ?>

<main>
   <!-- Start of Breadcrumb -->
   <nav class="breadcrumb-nav">
      <div class="container">
         <ul class="breadcrumb bb-no">
            <h1 class="page-title mb-0"><?php echo $content['page_name']; ?></h1>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li>Privacy Policy</li>
         </ul>
      </div>
   </nav>
   <!-- End of Breadcrumb -->

    <section class="privacy_policy">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<p class="mb-70"> <?php echo $content['page_description']; ?></p>
				</div>
			</div>
		</div>
	</section>
   
 </main>  
            
<?php $this->load->view('bottom'); ?>