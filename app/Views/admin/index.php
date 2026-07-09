<?php
  $session = session();
$userCount = 1;
$productCount = 1;
?>
 <!-- CONTENT WRAPPER -->
			<div class="ec-content-wrapper">
				<div class="content">
					<!-- Top Statistics -->
					<?php if($session->admin_type == 'Supar Admin') { ?>
					<div class="row">
						<div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-1">
								<div class="card-body">
									<h2 class="mb-1"><?php echo $vender; ?></h2>
									<p>Vendors</p>
									<span class="mdi mdi-account-arrow-left"></span>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-2">
								<div class="card-body">
									<h2 class="mb-1"><?php echo $user; ?></h2>
									<p>Customer</p>
									<span class="mdi mdi-account-clock"></span>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-3">
								<div class="card-body">
									<h2 class="mb-1"><?php echo $order; ?></h2>
									<p>Order</p>
									<span class="mdi mdi-package-variant"></span>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-4">
								<div class="card-body">
									<h2 class="mb-1"><?php echo $product; ?></h2>
									<p>Product</p>
									<span class="mdi mdi-currency-usd"></span>
								</div>
							</div>
						</div>
					</div>
 <?php } ?>
			

					<div class="row">
						<div class="col-12 p-b-15">
							<!-- Recent Order Table -->
							<div class="card card-table-border-none card-default recent-orders" id="recent-orders">
								<div class="card-header justify-content-between">
									<h2>Recent Orders</h2>
									<div class="date-range-report">
										<span></span>
									</div>
								</div>
								<div class="card-body pt-0 pb-5">
								
									
									 <table id="ajax_table" class="table card-table table-responsive table-responsive-large">
                <thead>
                <tr>
                  <th>#Order Id</th>
                <th>Image</th>
                  <th>Item Name</th>
             
                  <th>Category</th>
                  <th>Price</th>
                  <th>Seller</th>
                  <th>Payment Type</th>
                  <th>Shipping Address</th>
      
                  <th>Status</th>
                  <th>Action</th>
                  
                </tr>
                </thead>
                <tbody>               
                </tbody>
              </table>
								</div>
							</div>
						</div>
					</div>

				</div> <!-- End Content -->
			</div> <!-- End Content Wrapper -->
			
			
<script>
    $(document).ready(function() {
    var table = $('#ajax_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url('admin/orderlist'); ?>",
            "type": "POST",
            "data": function(data) {
                // Add custom parameters to the AJAX request data
                var fromDate =  '';
                data.searchname = fromDate;
                 data.vender_id = '';
            }
        },
        "columns": <?= $table_column ?>,
        "pagingType": "simple_numbers_no_ellipses",
        "oLanguage": {
            "oPaginate": {
                "sFirst": "First",
                "sPrevious": "Previous",
                "sNext": "Next"
            }
        },
        "language": {
            "processing": '<div class="custom-spinner"></div> ' 
        },
        "initComplete": function () {
            // Apply your custom CSS styles to the table
            $('#ajax_table').addClass('custom-datatable');
        },
        "bJQueryUI": false // Disable default DataTables CSS
    });

    $('#searchname').on('keyup', function() {
        table.column(0).search(this.value).draw();
    });
    

    $('#search').on('click', function() {
       
      table.column(0).search(this.value).draw();
    });

    

	


    
});
</script>
 
