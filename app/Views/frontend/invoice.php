<main class="main">
			<div class="category-banner-container bg-gray">
				<div class="category-banner banner text-uppercase"
				
					<div class="container position-relative">
					
						<h1 class="page-title text-center text-white">Order Confirmation</h1>
					</div>
				</div>
			</div>

			<div class="container">
				<section class="message-section mt-6">
				<?php if(!empty($msg)) { ?>
					<div class="alert alert-rounded alert-<?php echo $msg['message']; ?>">
						<i class="fa fa-check" style="color: #9ad36a;"></i>
						<span><?php echo $msg['message']; ?></span>
					</div>
				<?php }?>
		
				</section>
				
			</div><!-- End .container -->

			
		</main><!-- End .main -->