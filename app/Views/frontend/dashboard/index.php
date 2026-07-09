 <?php 
use App\Models\Commanmodel;
 $commanmodel = new Commanmodel();
  $session = session();
  $usersession = $session->get('loggedin');
?>
  

		<main class="main">
			<div class="page-header">
				<div class="container d-flex flex-column align-items-center">
					<nav aria-label="breadcrumb" class="breadcrumb-nav">
						<div class="container">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo base_url(''); ?>">Home</a></li>
							
								<li class="breadcrumb-item active" aria-current="page">
									My Account   
								</li>
							</ol>
						</div>
					</nav>

					<h1>My Account </h1>
				</div>
			</div>

			<div class="container Account -container custom-Account -container">
				<div class="row">
					<div class="sidebar widget widget-dashboard mb-lg-0 mb-3 col-lg-3 order-0">
						<h2 class="text-uppercase">My Account </h2>
						<ul class="nav nav-tabs list flex-column mb-0" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="dashboard-tab" data-toggle="tab" href="#dashboard"
									role="tab" aria-controls="dashboard" aria-selected="true">Dashboard</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" id="order-tab" data-toggle="tab" href="#order" role="tab"
									aria-controls="order" aria-selected="true">Orders</a>
							</li>
<li class="nav-item">
								<a class="nav-link" href="<?php echo base_url('wishlist'); ?>">Wishlist</a>
							</li>
						
<!--
							<li class="nav-item">
								<a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab"
									aria-controls="address" aria-selected="false">Addresses</a>
							</li>-->

							<li class="nav-item">
								<a class="nav-link" id="edit-tab" data-toggle="tab" href="#edit" role="tab"
									aria-controls="edit" aria-selected="false">Account 
									details</a>
							</li>
						
							
							<li class="nav-item">
								<a class="nav-link" href="<?php echo base_url('logout'); ?>">Logout</a>
							</li>
						</ul>
					</div>
					<div class="col-lg-9 order-lg-last order-1 tab-content">
						<div class="tab-pane fade show active" id="dashboard" role="tabpanel">
							<div class="dashboard-content">
								<p>
									Hello <strong class="text-dark"> <?php echo $userdata->user_name;?></strong> 
								</p>

						
								<div class="mb-4"></div>

								<div class="row row-lg">
									<div class="col-6 col-md-4">
										<div class="feature-box text-center pb-4">
											<a href="#order" class="link-to-tab"><i
													class="sicon-social-dropbox"></i>
													<div class="feature-box-content">
												<h3>ORDERS</h3>
											</div></a>
											
										</div>
									</div>


									<!--<div class="col-6 col-md-4">
										<div class="feature-box text-center pb-4">
											<a href="#address" class="link-to-tab"><i
													class="sicon-location-pin"></i></a>
											<div class="feature-box-content">
												<h3>ADDRESSES</h3>
											</div>
										</div>
									</div>-->

									<div class="col-6 col-md-4">
										<div class="feature-box text-center pb-4">
											<a href="#edit" class="link-to-tab"><i class="icon-user-2"></i>
												<div class="feature-box-content p-0">
												<h3>Account  DETAILS</h3>
											</div></a>
										
										</div>
									</div>

									<div class="col-6 col-md-4">
										<div class="feature-box text-center pb-4">
											<a href="<?php echo base_url('wishlist'); ?>"><i class="sicon-heart"></i>
												<div class="feature-box-content">
												<h3>WISHLIST</h3>
											</div></a>
										
										</div>
									</div>

									<div class="col-6 col-md-4">
										<div class="feature-box text-center pb-4">
											<a href="<?php echo base_url('logout'); ?>"><i class="sicon-logout"></i>
												<div class="feature-box-content">
												<h3>LOGOUT</h3>
											</div></a>
										
										</div>
									</div>
								</div><!-- End .row -->
							</div>
						</div><!-- End .tab-pane -->

						<div class="tab-pane fade" id="order" role="tabpanel">
							<div class="order-content">
								<h3 class="Account -sub-title d-none d-md-block"><i
										class="sicon-social-dropbox align-middle mr-3"></i>Orders</h3>
								<div class="order-table-container text-center">
								
									
									
									   	<table class="table table-order text-left">
                                                        <thead>
                                                          <tr>
                                                            <th scope="col">Product</th>
                                                            <th scope="col">Name</th>
                                                          
                                                            <th scope="col">Booking Date</th>
                                                         <th scope="col">Action</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php  foreach($order as $orderrow) { 
                                                             $product = $commanmodel->get_single_query('booking_product',array('booking_product_order_book_id'=> $orderrow->order_book_id));
                                                              if($product) {
                                                            ?>
                                                          <tr>
                                                            <td class="ltn__my-properties-img">
                                                                <a href=""><img src="<?php echo $product->booking_product_image; ?>" style="width: 65px;" alt="#"></a>
                                                            </td>
                                                            <td>
                                                                <div class="ltn__my-properties-info">
                                                                    <h6 class="mb-10"><a href="<?php echo base_url().'/product-details/'; ?>"><?php echo $product->booking_product_product_name; ?></a></h6>
                                                                  <p></p>
                                                             
                                                                </div>
                                                            </td>
                                                            <td><?php echo $orderrow->order_book_date; ?></td>
                                                             <td><a href="<?php echo base_url('order-view'); ?>/<?php echo $product->booking_product_order_id; ?>" >view</a>
                                                             
                                                             <a class="btn btn-flat btn-success" href="<?php echo base_url().'/track-xpressbees-shipment/'.$product->booking_product_order_id ; ?>">Track</i></a> </td>
                                                           
                                                          </tr>
                                                    <?php } } ?>
                                                   
                                                        </tbody>
                                                      </table>
									<hr class="mt-0 mb-3 pb-2" />

									<a href="<?php echo base_url(''); ?>" class="btn btn-dark">Go Shop</a>
								</div>
							</div>
						</div><!-- End .tab-pane -->

						<div class="tab-pane fade" id="download" role="tabpanel">
							<div class="download-content">
								<h3 class="Account -sub-title d-none d-md-block"><i
										class="sicon-cloud-download align-middle mr-3"></i>Downloads</h3>
								<div class="download-table-container">
									<p>No downloads available yet.</p> <a href="category.html"
										class="btn btn-primary text-transform-none mb-2">GO SHOP</a>
								</div>
							</div>
						</div><!-- End .tab-pane -->

						<div class="tab-pane fade" id="address" role="tabpanel">
							<h3 class="Account -sub-title d-none d-md-block mb-1"><i
									class="sicon-location-pin align-middle mr-3"></i>Addresses</h3>
							<div class="addresses-content">
								<p class="mb-4">
									The following addresses will be used on the checkout page by
									default.
								</p>

								<div class="row">
									<div class="address col-md-6">
										<div class="heading d-flex">
											<h4 class="text-dark mb-0">Billing address</h4>
										</div>

										<div class="address-box">
											You have not set up this type of address yet.
										</div>

										<a href="#billing" class="btn btn-default address-action link-to-tab">Add
											Address</a>
									</div>

									<div class="address col-md-6 mt-5 mt-md-0">
										<div class="heading d-flex">
											<h4 class="text-dark mb-0">
												Shipping address
											</h4>
										</div>

										<div class="address-box">
											You have not set up this type of address yet.
										</div>

										<a href="#shipping" class="btn btn-default address-action link-to-tab">Add
											Address</a>
									</div>
								</div>
							</div>
						</div><!-- End .tab-pane -->

						<div class="tab-pane fade" id="edit" role="tabpanel">
							<h3 class="Account -sub-title d-none d-md-block mt-0 pt-1 ml-1"><i
									class="icon-user-2 align-middle mr-3 pr-1"></i>Account  Details</h3>
							<div class="Account -content">
							 <form id="updateUser">
                
                <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <label>Name</label>
                    <input placeholder="Name" type="text" class="form-control" name="user_name" value="<?php echo $userdata->user_name;?>" required="required">
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                       <div class="input-item input-item-name">
                    <label>DOB</label>
                    <input placeholder="DD-MM-YYYY" type="date" class="form-control" name="date_of_birth" value="<?php echo $userdata->date_of_birth;?>" >
                     </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="input-item">
                    <label>Gender</label>
                    <select name="gender" class="form-control">
                      <option value="">Select</option>
                      <option value="Male" <?php if($userdata->gender =='Male'){ echo "selected"; } ?> >Male</option>
                      <option value="Female" <?php if($userdata->gender =='Female'){ echo "selected"; } ?>>Female</option>
                      <option value="Other" <?php if($userdata->gender =='Other'){ echo "selected"; } ?>>Other</option>
                    </select>
                    </div>
                  </div>
                  <div class="col-lg-6col-md-6 col-sm-6">
                    <label>Mobile Number</label>
                    <input placeholder="Mobile Number" name="user_phone" class="form-control" type="text" value="<?php echo $userdata->user_phone;?>" required="required">
                  </div>
                  <div class="col-lg-12 col-md-4 col-sm-6">
                      <div class="input-item">
                    <label>Marital Status</label>
                    
                    <select name="marital_status" class="form-control">
                      <option value="">Select</option>
                      <option value="Married"<?php if($userdata->marital_status =='Married'){ echo "selected"; } ?> >Married</option>
                      <option value="Unmaried" <?php if($userdata->marital_status =='Unmaried'){ echo "selected"; } ?>>Unmaried</option>
                    </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <label>Email ID</label>
                    <input placeholder="Official" name="user_email" class="form-control" type="text" value="<?php echo $userdata->user_email;?>" required="required">
                  </div>
                
                </div>
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <label>Residential Address </label>
                    <input placeholder="Address Line 1" class="form-control" name="user_address" type="text" value="<?php echo $userdata->user_address;?>" required="required">
                  </div>
                 
                </div>
             
                <div class="row" style="margin-top:10px">
                  <div class="col-md-12">
                   
                    <input value="Submit" type="submit">
                  </div>
                </div>
              </form>
							</div> 
						</div><!-- End .tab-pane -->

					

						<div class="tab-pane fade" id="shipping" role="tabpanel">
							<div class="address Account -content mt-0 pt-2">
								<h4 class="title mb-3">Shipping Address</h4>

								<form class="mb-2" action="#">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>First name <span class="required">*</span></label>
												<input type="text" class="form-control" required />
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label>Last name <span class="required">*</span></label>
												<input type="text" class="form-control" required />
											</div>
										</div>
									</div>

									<div class="form-group">
										<label>Company </label>
										<input type="text" class="form-control">
									</div>

									<div class="select-custom">
										<label>Country / Region <span class="required">*</span></label>
										<select name="orderby" class="form-control">
											<option value="" selected="selected">British Indian Ocean Territory
											</option>
											<option value="1">Brunei</option>
											<option value="2">Bulgaria</option>
											<option value="3">Burkina Faso</option>
											<option value="4">Burundi</option>
											<option value="5">Cameroon</option>
										</select>
									</div>

									<div class="form-group">
										<label>Street address <span class="required">*</span></label>
										<input type="text" class="form-control"
											placeholder="House number and street name" required />
										<input type="text" class="form-control"
											placeholder="Apartment, suite, unit, etc. (optional)" required />
									</div>

									<div class="form-group">
										<label>Town / City <span class="required">*</span></label>
										<input type="text" class="form-control" required />
									</div>

									<div class="form-group">
										<label>State / Country <span class="required">*</span></label>
										<input type="text" class="form-control" required />
									</div>

									<div class="form-group">
										<label>Postcode / ZIP <span class="required">*</span></label>
										<input type="text" class="form-control" required />
									</div>

									<div class="form-footer mb-0">
										<div class="form-footer-right">
											<button type="submit" class="btn btn-dark py-4">
												Save Address
											</button>
										</div>
									</div>
								</form>
							</div>
						</div><!-- End .tab-pane -->
					</div><!-- End .tab-content -->
				</div><!-- End .row -->
			</div><!-- End .container -->

			<div class="mb-5"></div><!-- margin -->
		</main><!-- End .main -->
  
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      
      <script>
document.addEventListener("DOMContentLoaded", function () {
    // Get the hash from URL (e.g., #order)
    var hash = window.location.hash;

    if (hash) {
        var targetTab = document.querySelector('a[href="' + hash + '"]');

        if (targetTab) {
            // Trigger click if it's a Bootstrap tab
            targetTab.click();
        } else {
            // Optional: activate content manually if not using Bootstrap
            var tabContent = document.querySelector(hash);
            if (tabContent) {
                document.querySelectorAll('.tab-pane').forEach(function(pane) {
                    pane.classList.remove('active', 'show');
                });
                tabContent.classList.add('active', 'show');
            }
        }
    }
});
</script>

 <script>
        $(document).ready(function() {
          $('#updateUser').submit('click',function(){
    
    var formData = new FormData($(this)[0]);
    $(":submit").attr("disabled", true);
		$.ajax({
			type : "POST",
			url  : "<?php echo base_url('update-user'); ?>",
      processData: false,
      contentType: false,
			dataType : "JSON",
			data : formData,
			success: function(data){
			    	
		
				 $(":submit").attr("disabled", false);
			
			  showAlert(data.class,data.title,data.message);
	
			 
		
				
			}
		});
		return false;
	}); 

        });

</script>