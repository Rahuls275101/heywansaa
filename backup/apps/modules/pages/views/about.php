<?php $this->load->view('top'); ?>
<!--<section class="banner_category" style="background-image: url('<?php echo theme_url(); ?>images/listing/listing-banner.jpg');">-->
<!--		<div class="container">-->
			<!-- <h2 class="banner_subtitle">check out over <span>200+</span></h2> -->
<!--			<h1 class="banner_title">About Us</h1>-->
<!--		</div>-->
<!--	</section>-->
	
	
	<!--<div class="page_breadcrumbs">-->
	<!--	<div class="container">-->
	<!--		<ul>-->
    <!--           <li><a href="<?//= site_url(); ?>" title="Home">Home</a></li>-->
    <!--           <li>About Us</li>-->
	<!--		</ul>-->
	<!--	</div>-->
	<!--</div>-->
<main>	
<!-- Start of Breadcrumb -->
   <nav class="breadcrumb-nav">
      <div class="container">
         <ul class="breadcrumb bb-no">
            <h1 class="page-title mb-0">About Us</h1>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li>About Us</li>
         </ul>
      </div>
   </nav>
   <!-- End of Breadcrumb -->
	
	<section class="about_us">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<!--<div class="about_img">-->
					<!--	<img src="<?php //echo get_image('staticpages', $content['image'], '', '', 'R'); ?>" alt="weblieu" title="weblieu">-->
					<!--</div>-->
					<div class="innerpagecontent">
					    	<?php echo $content['page_description']; ?>
					</div>
				
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</section>
</main>
<?php $this->load->view('bottom'); ?>
