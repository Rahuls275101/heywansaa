

<?php
use App\Models\Commanmodel;

$commanmodel = new Commanmodel();
?>


 
 
		<main class="main about">
			<div class="page-header page-header-bg text-left" style="background: linear-gradient(rgba(149, 211, 255, 0.6), rgba(149, 211, 255, 0.6)), 
				50% / cover #95d3ff url(assets/images/page-header-bg.jpg);
	background-attachment: fixed;
	">
				<div class="container">
					<h1><span>ABOUT US</span>
						OUR COMPANY</h1>
				</div><!-- End .container -->
			</div><!-- End .page-header -->

			<nav aria-label="breadcrumb" class="breadcrumb-nav">
				<div class="container">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo base_url(''); ?>"><i class="icon-home"></i></a></li>
						<li class="breadcrumb-item active" aria-current="page">About Us</li>
					</ol>
				</div><!-- End .container -->
			</nav>

			<div class="about-section">
				<div class="container">
				     <?php $about= $commanmodel->get_single_query('cms_pages',array('cms_id' => 1)); ?>
					<h2 class="subtitle"><?php echo $about->cms_page_heading; ?></h2>
				<?php echo $about->cms_page_description; ?>
				</div><!-- End .container -->
			</div><!-- End .about-section -->

			<div class="features-section " style="    background: #f4f4f4;">
				<div class="container">
					<h2 class="subtitle">WHY CHOOSE US</h2>
					<div class="row">
						<div class="col-lg-6">
							<div class="feature-box bg-white">
								<i class="icon-shipped"></i>

								<div class="feature-box-content p-0">
								     <?php $about5= $commanmodel->get_single_query('cms_pages',array('cms_id' => 5)); ?>
									<h3><?php echo $about5->cms_page_heading; ?></h3>
									<p><?php echo $about5->cms_page_small_description; ?></p>
								</div><!-- End .feature-box-content -->
							</div><!-- End .feature-box -->
						</div><!-- End .col-lg-4 -->

						<div class="col-lg-6">
							<div class="feature-box bg-white">
								<i class="icon-us-dollar"></i>

								<div class="feature-box-content p-0">
								    <?php $about6= $commanmodel->get_single_query('cms_pages',array('cms_id' => 6)); ?>
									<h3><?php echo $about6->cms_page_heading; ?></h3>
									<p><?php echo $about6->cms_page_small_description; ?></p>
								</div><!-- End .feature-box-content -->
							</div><!-- End .feature-box -->
						</div><!-- End .col-lg-4 -->

					
					</div><!-- End .row -->
				</div><!-- End .container -->
			</div><!-- End .features-section -->


		</main><!-- End .main -->
 
 
 
 
 
 
 
 
 