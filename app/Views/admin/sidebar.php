<?php 

use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();
   $session = session();
  $webdetails =  $commanmodel->get_single_query('address',array('id' => 1));
?> 

 <body class="ec-header-fixed ec-sidebar-fixed ec-sidebar-light ec-header-light" id="body">

	<!--  WRAPPER  -->
	<div class="wrapper">
		
		<!-- LEFT MAIN SIDEBAR -->
		<div class="ec-left-sidebar ec-bg-sidebar">
			<div id="sidebar" class="sidebar ec-sidebar-footer">

				<div class="ec-brand">
					<a href="<?php echo base_url('admin/dashboard'); ?>">
						<img class="ec-brand-icon" src="<?php echo base_url('assets/img/'); ?>/<?php echo $webdetails->header_logo; ?>" alt="" />
						<span class="ec-brand-name text-truncate"><?php echo $webdetails->web_name; ?></span>
					</a>
				</div>

				<!-- begin sidebar scrollbar -->
				<div class="ec-navigation" data-simplebar>
					<!-- sidebar menu -->
					<ul class="nav sidebar-inner" id="sidebar-menu">
						<!-- Dashboard -->
						<li class="active">
							<a class="sidenav-item-link" href="<?php echo base_url('admin/dashboard'); ?>">
								<i class="mdi mdi-view-dashboard-outline"></i>
								<span class="nav-text">Dashboard</span>
							</a>
							<hr>
						</li>

						<li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
								<!-- <i class="mdi mdi-palette-advanced"></i> -->
								<i class="mdi mdi-package-variant-closed"></i>
								<span class="nav-text">Products</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="products" data-parent="#sidebar-menu">
									<li class="">
										<a class="sidenav-item-link" href="<?php echo base_url('admin/create_product'); ?>">
											<span class="nav-text">Add Product</span>
										</a>
									</li>
									<li class="">
										<a class="sidenav-item-link" href="<?php echo base_url('admin/product'); ?>">
											<span class="nav-text">List Product</span>
										</a>
									</li>
									
									<li class="">
										<a class="sidenav-item-link" href="<?php echo base_url('admin/files'); ?>">
											<span class="nav-text">Files</span>
										</a>
									</li>
									<li class="">
										<a class="sidenav-item-link" href="<?php echo base_url('admin/shipcharge'); ?>">
											<span class="nav-text">Ship Charges</span>
										</a>
									</li>
								<li class="">
										<a class="sidenav-item-link" href="<?php echo base_url('admin/bulk_product_upload'); ?>">
											<span class="nav-text">Bulk Product Upload </span>
										</a>
									</li>
								
								</ul>
							</div>
						</li>
						
						
							<?php if($session->admin_type == 'Supar Admin') { ?>
							
							
						<!-- Vendors -->
						<li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
								<i class="mdi mdi-briefcase-outline"></i>
								<span class="nav-text">Vendors</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="vendors" data-parent="#sidebar-menu">
								

									<li class="">
										<a class="sidenav-item-link" href="<?php echo base_url('admin/vender'); ?>">
											<span class="nav-text">Vendor List</span>
										</a>
									</li>
								
								</ul>
							</div>
						</li>

						<!-- Users -->
						<li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
								<i class="mdi mdi-account-multiple-outline"></i>
								<span class="nav-text">Customers</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="users" data-parent="#sidebar-menu">
									

									<li class="">
										<a class="sidenav-item-link" href="<?php echo base_url('admin/customer'); ?>">
											<span class="nav-text">User List</span>
										</a>
									</li>
								
								</ul>
							</div>
							<hr>
						</li>

								<!-- Category -->
						<li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
								<i class="mdi mdi-shape"></i>
								<span class="nav-text">Categories</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="categorys" data-parent="#sidebar-menu">
									<li class="">
										<a class="sidenav-item-link" href="<?php echo base_url('admin/category'); ?>">
											<span class="nav-text">All Category</span>
										</a>
									</li>
								
								</ul>
							</div>
						</li>
						
						<!-- Reviews -->
						<li>
							<a class="sidenav-item-link" href="<?php echo base_url('admin/reviews'); ?>">
								<i class="mdi mdi-star-circle-outline"></i>
								<span class="nav-text">Reviews</span>
							</a>
						</li>

						<!-- Brands -->
					
						<li>
							<a class="sidenav-item-link" href="<?php echo base_url('admin/brand'); ?>">
								<i class="mdi mdi-tag-outline"></i>
								<span class="nav-text">Brands</span>
							</a>
							<hr>
						</li>
						
							<li>
							<a class="sidenav-item-link" href="<?php echo base_url('admin/collections'); ?>">
								<i class="mdi mdi-tag-outline"></i>
								<span class="nav-text">Collections</span>
							</a>
							<hr>
						</li>
						
						
						<li>
							<a class="sidenav-item-link" href="<?php echo base_url('admin/attributes'); ?>">
								<i class="mdi mdi-tag-text-outline"></i>
								<span class="nav-text">Attributes</span>
							</a>
							<hr>
						</li>
						
						<li>
							<a class="sidenav-item-link" href="<?php echo base_url('admin/coupon'); ?>">
								<i class="mdi mdi-tag-faces"></i>
								<span class="nav-text">Coupon</span>
							</a>
							<hr>
						</li>
						
						<li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
								<i class="mdi mdi-web"></i>
								<span class="nav-text">Website</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="website" data-parent="#sidebar-menu">
								

									<li class="">
										<a class="sidenav-item-link" href="<?php echo base_url('admin/home_banner'); ?>">
											<span class="nav-text">Banner List</span>
										</a>
									</li>
									
										<li class="">
										<a class="sidenav-item-link" href="<?php echo base_url('admin/cms_pages'); ?>">
											<span class="nav-text">CMS Pages List</span>
										</a>
									</li>
									
									<li class="">
										<a class="sidenav-item-link" href="<?php echo base_url('admin/meta'); ?>">
											<span class="nav-text">Meta List</span>
										</a>
									</li>
								
								</ul>
							</div>
						</li>
						<?php } ?>

						<!-- Products -->
					
 
						<!-- Orders -->
						<li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
								<i class="mdi mdi-cart-outline"></i>
								<span class="nav-text">Orders</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="orders" data-parent="#sidebar-menu">
									<li class="">
										<a class="sidenav-item-link" href="<?php echo base_url('admin/order'); ?>">
											<span class="nav-text">Order list</span>
										</a>
									</li>
								
									
								</ul>
							</div>
						</li>

				

						
						<!-- Transactions -->
						<li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
								<i class="mdi mdi-finance"></i>
								<span class="nav-text">Transactions</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="authentication" data-parent="#sidebar-menu">
									<li class="">
										<a href="<?php echo base_url('admin/transactions'); ?>">
											<span class="nav-text">All transactions</span>
										</a>
									</li>
									
								</ul>
							</div>
						</li>
						<!-- Setting -->
						
						
						<li>
							<a class="sidenav-item-link" href="<?php echo base_url('admin/setting'); ?>">
								<i class="mdi mdi-cogs"></i>
								<span class="nav-text">Setting</span>
							</a>
						</li>
			

					
					</ul>
				</div>
			</div>
		</div>

		<!--  PAGE WRAPPER -->
		<div class="ec-page-wrapper">

			<!-- Header -->
			<header class="ec-main-header" id="header">
				<nav class="navbar navbar-static-top navbar-expand-lg">
					<!-- Sidebar toggle button -->
					<button id="sidebar-toggler">
						<img src="<?php echo base_url('assets/admin/'); ?>/assets/img/icons/clops.png" alt="">
					</button>
					<!-- search form -->
					<div class="search-form d-lg-inline-block">
						<div class="input-group">
							<input type="text" name="query" id="search-input" class="form-control"
								placeholder="search.." autofocus autocomplete="off" />
							<button type="button" name="search" id="search-btn" class="btn btn-flat">
								<i class="mdi mdi-magnify"></i>
							</button>
						</div>
						<div id="search-results-container">
							<ul id="search-results"></ul>
						</div>
					</div>

					<!-- navbar right -->
					<div class="navbar-right">
						<ul class="nav navbar-nav">
							<!-- User Account -->
							<li class="dropdown user-menu">
								<button class="dropdown-toggle nav-link ec-drop" data-bs-toggle="dropdown"
									aria-expanded="false">
								    <?php if(!empty($session->image)) { ?>
								    <img src="<?php echo base_url('assets/vender/').'/'.$session->image; ?>" class="user-image" alt="<?php echo $session->name; ?>" />
								    <?php } else { ?>
								        	<img src="<?php echo base_url('assets/admin/'); ?>/assets/img/user/user-1.png" class="user-image" alt="User Image" />
								  <?php   } ?>
								
								</button>
								<ul class="dropdown-menu dropdown-menu-right ec-dropdown-menu">
									<!-- User image -->
									<li class="dropdown-header">
										<div class="d-inline-block">
											<h5><?php echo $session->name; ?></h5>
											<p class="pt-2"><?php echo $session->email; ?></p>
										</div>
									</li>
									<li>
										<a href="<?php echo base_url('admin/setting'); ?>">
											<i class="mdi mdi-account"></i> My Profile
										</a>
									</li>
									<li class="dropdown-footer">
										<a href="<?php echo base_url('admin/logout'); ?>"> <i class="mdi mdi-logout"></i> Log Out </a>
									</li>
								</ul>
							</li>
							<li class="dropdown notifications-menu custom-dropdown">
								<button class="dropdown-toggle notify-toggler custom-dropdown-toggler">
									<i class="mdi mdi-bell-ring-outline"></i>
								</button>

								<div class="card card-default dropdown-notify dropdown-menu-right mb-0">
									<div class="card-header card-header-border-bottom px-3">
										<h2>Notifications</h2>
									</div>

									<div class="card-body px-0 py-0">
										<div class="tab-content" id="myNotifications">
											<ul class="list-unstyled" data-simplebar style="height: 360px">
												<li>
													<a href="javscript:void(0)"
														class="media media-message media-notification">
														<div class="position-relative mr-3">
															<img class="rounded-circle" src="assets/img/user/u2.jpg"
																alt="Image">
															<span class="status away"></span>
														</div>
														<div class="media-body d-flex justify-content-between">
															<div class="message-contents">
																<h4 class="title">Nitin</h4>
																<p class="last-msg">Lorem ipsum dolor sit, amet
																	consectetur adipisicing elit. Nam itaque
																	doloremque odio, eligendi delectus vitae.</p>

																<span
																	class="font-size-12 font-weight-medium text-secondary">
																	<i class="mdi mdi-clock-outline"></i> 30 min
																	ago...
																</span>
															</div>
														</div>
													</a>
												</li>

												<li>
													<a href="javscript:void(0)"
														class="media media-message media-notification media-active">
														<div class="position-relative mr-3">
															<img class="rounded-circle" src="assets/img/user/u1.jpg"
																alt="Image">
															<span class="status active"></span>
														</div>
														<div class="media-body d-flex justify-content-between">
															<div class="message-contents">
																<h4 class="title">Lovina</h4>
																<p class="last-msg">Donec mattis augue a nisl
																	consequat, nec imperdiet ex rutrum. Fusce et
																	vehicula enim. Sed in enim eu odio vehic.</p>

																<span
																	class="font-size-12 font-weight-medium text-white">
																	<i class="mdi mdi-clock-outline"></i> Just
																	now...
																</span>
															</div>
														</div>
													</a>
												</li>

												<li>
													<a href="javscript:void(0)"
														class="media media-message media-notification">
														<div class="position-relative mr-3">
															<img class="rounded-circle" src="assets/img/user/u5.jpg"
																alt="Image">
															<span class="status away"></span>
														</div>
														<div class="media-body d-flex justify-content-between">
															<div class="message-contents">
																<h4 class="title">Crinali</h4>
																<p class="last-msg">Lorem ipsum dolor sit, amet
																	consectetur adipisicing elit. Nam itaque
																	doloremque odio, eligendi delectus vitae.</p>

																<span
																	class="font-size-12 font-weight-medium text-secondary">
																	<i class="mdi mdi-clock-outline"></i> 1 hrs
																	ago...
																</span>
															</div>
														</div>
													</a>
												</li>
												<li>
													<a href="javscript:void(0)"
														class="media media-message media-notification">
														<div class="position-relative mr-3">
															<img class="rounded-circle" src="assets/img/user/u4.jpg"
																alt="Image">
															<span class="status away"></span>
														</div>
														<div class="media-body d-flex justify-content-between">
															<div class="message-contents">
																<h4 class="title">Crinali</h4>
																<p class="last-msg">Lorem ipsum dolor sit, amet
																	consectetur adipisicing elit. Nam itaque
																	doloremque odio, eligendi delectus vitae.</p>

																<span
																	class="font-size-12 font-weight-medium text-secondary">
																	<i class="mdi mdi-clock-outline"></i> 1 hrs
																	ago...
																</span>
															</div>
														</div>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</div>

								<ul class="dropdown-menu dropdown-menu-right d-none">
									<li class="dropdown-header">You have 5 notifications</li>
									<li>
										<a href="#">
											<i class="mdi mdi-account-plus"></i> New user registered
											<span class=" font-size-12 d-inline-block float-right"><i
													class="mdi mdi-clock-outline"></i> 10 AM</span>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="mdi mdi-account-remove"></i> User deleted
											<span class=" font-size-12 d-inline-block float-right"><i
													class="mdi mdi-clock-outline"></i> 07 AM</span>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="mdi mdi-chart-areaspline"></i> Sales report is ready
											<span class=" font-size-12 d-inline-block float-right"><i
													class="mdi mdi-clock-outline"></i> 12 PM</span>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="mdi mdi-account-supervisor"></i> New client
											<span class=" font-size-12 d-inline-block float-right"><i
													class="mdi mdi-clock-outline"></i> 10 AM</span>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="mdi mdi-server-network-off"></i> Server overloaded
											<span class=" font-size-12 d-inline-block float-right"><i
													class="mdi mdi-clock-outline"></i> 05 AM</span>
										</a>
									</li>
									<li class="dropdown-footer">
										<a class="text-center" href="#"> View All </a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</nav>
			</header>
			
			
		