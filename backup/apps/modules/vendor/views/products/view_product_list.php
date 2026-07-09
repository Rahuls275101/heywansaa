<?php
$this->load->view('includes/top');
?>
<!--  BEGIN MAIN CONTAINER  -->
<link rel="stylesheet" type="text/css" href="<?php echo admin_url(); ?>assets/css/forms/switches.css">
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
                echo success_message();
            ?>
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-8 col-md-8 col-sm-8 col-8">
                  <h4><?php echo $headingTitle; ?></h4>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-4 col-4 text-right">
                  <h4><a href="<?php echo base_url(); ?>wps-vendor/products/add" class="btn btn-dark btn-sm mb-2"><i class="fa fa-plus"></i> Add New Product</a></h4>
                </div>
              </div>
            </div>
            <div class="widget-header">

<!--this is new below is old form-->

<?php echo form_open('wps-vendor/search/product/search', 'id="myForm" method="post"'); ?> 
<?php //echo form_open(current_url_query_string(), 'id="myForm" method="get"'); ?> 

  <div class="row">

    <div class="col-xl-6 col-md-6 col-sm-12 col-12 row" style="margin-left:0px">

      <!--<h4>Per Page : </h4> <?php echo display_record_per_page(); ?> -->

    </div>

   
    <div class="col-xl-6 col-md-6 col-sm-12 col-12 text-right row ml0">

    <input type="text" class="form-control" name="keywordSearch" style=" width: 67%;">&nbsp;

    <input type="hidden" name="action" value="Search" />

    <input type="submit" class="btn btn-warning" value="Search" style="height: 44px;margin-left: 20px;">

    </div>

  </div>

  <?php echo form_close(); ?>

</div>
            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">
                <?php
                
               
                
                if (is_array($vendor_wise_product) && !empty($vendor_wise_product)) {
                  echo form_open(base_url() . "wps-vendor/products/", 'id="data_form"');
                  ?>
                  <table id="style-3" class="table style-3  table-hover">
                    <thead>
                      <tr>
                        <th class="checkbox-column text-left"> 
                          <label class="new-control new-checkbox checkbox-outline-info  m-auto">
                            <input type="checkbox" onclick="$('input:checkbox').not(this).prop('checked', this.checked);" class="new-control-input child-chk select-customers-info" id="customer-all-info">
                            <span class="new-control-indicator"></span><span style="visibility:hidden">c</span>
                          </label>
                        </th>
                        <th>Product Name</th>
                        <th>Product Code</th>
                        <th>Price</th>
                        <th>Product Picture</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($vendor_wise_product as $catKey => $pageVal) {
                       
                        ?>
                        <tr>
                          <td class="checkbox-column text-left"> 
                            <label class="new-control new-checkbox checkbox-outline-info  m-auto">
                              <input type="checkbox" type="checkbox" name="arr_ids[]" value="<?php echo $pageVal['products_id']; ?>" class="new-control-input child-chk select-customers-info">
                              <span class="new-control-indicator"></span><span style="visibility:hidden">c</span>
                            </label>                            
                          </td>
                          <td><?php echo $pageVal['product_name']; ?> 
                                             
                        <?php $overall_rating = product_overall_rating($pageVal['products_id'], 'product'); ?>
                        <!-- <p style="font-size:11px;"><?php echo rating_html($overall_rating, 5); ?><br/><?php echo anchor("wps-admin/product_reviews?ref_id=$pageVal[products_id]", 'View Reviews', 'target="_blank"'); ?></p> -->

                      <p><?php if($pageVal['popular_product'] == 1){
                          echo '<br /><br /> Product On Sale : <b>Yes</b><br />';
                        }
                        if($pageVal['newarrival_product'] == 1){
                          echo '<br /><br />New Arrival Product : <b>Yes</b><br />';
                        } ?></p>
                      </td>
                      <td><?php echo $pageVal['product_code']; ?></td>
                      <td>
                          <span style="color: #b00;"><?php echo display_price($pageVal['product_discounted_price']); ?></span>
                      </td>
                      <td align="center" valign="top">
                        <img src="<?php echo get_image('products', $pageVal['media'], 50, 50, 'AR'); ?>" />
                      </td>
                      
                          
                          <td><?php echo ($pageVal['status'] == 1) ? "Active" : "In-active"; ?>
                                <span class="btn-danger btn-sm" data-toggle="modal" data-target="#viewStatus<?php echo $pageVal['products_id']?>"><i class="fa fa-eye"></i></span>
                          </td>
                          <td>
                            <a href="<?php echo base_url(); ?>wps-vendor/products/edit/<?php echo $pageVal['products_id']; ?>" class="btn btn-info btn-sm mb-2">Edit</a>

                           <a href="<?php echo base_url(); ?>wps-vendor/variant/<?php echo $pageVal['products_id']; ?>" class="btn btn-primary btn-sm mb-2">Manage Variant</a>
                            
                         
                            
                          </td>
                        </tr>
                      
                      
                      
                      
                      
                      
                      <div id="viewStatus<?php echo $pageVal['products_id']?>" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header d-block">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Product Verification</h4>
                              </div>
                              <div class="modal-body">
                               <h5><strong>Status:</strong> <?php if($pageVal['status'] == 1) {echo "Active";} else{ echo "In-active";} ?></h5>
                               <h5><strong>Remark:</strong> <?php echo ucwords($pageVal['approval_remark']); ?></h5>
                               <h5><strong>Approval date:</strong> <?php echo date('d-m-Y h:i A',strtotime($pageVal['approval_date'])); ?></h5>
                              </div>
                            </div>
                          </div>
                        </div>
                      
                      
                      
                      
                      
                      
                      
                      <?php
                    }
                    ?>
                      <tr>

<td colspan="7" style="width:50%; text-align: center;">

  <p class="paging"><?php //echo $paging; ?></p>

</td>

</tr>
                    </tbody>
                  </table>
                  <div class="widget-content widget-content-area text-left split-buttons">
                    <input name="status_action" type="submit"  value="Activate" class="btn btn-success mb-2" id="Activate" onClick="return validcheckstatus('arr_ids[]', 'Activate', 'Record', 'data_form');"/>
                    <input name="status_action" type="submit" class="btn btn-warning mb-2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]', 'Deactivate', 'Record', 'data_form');"/>
                    <input name="status_action" type="submit" class="btn btn-danger mb-2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]', 'Delete', 'Record', 'data_form');"/>
                    <!--<select name="set_as" style="width:123px;height: 35px;border-radius: 6px;" onchange="return validcheckstatus('arr_ids[]', 'set_as', 'Record', 'data_form');" >-->
                    <!--    <option value="" selected="selected">Product Set As</option>-->
                    <!--    <option value="popular_product">On Sale</option>-->
                    <!--    <option value="newarrival_product">New Arrival</option>-->
                    <!--</select>-->
                    <!-- <select name="unset_as" style="width:135px;height: 35px;border-radius: 6px;" onchange="return validcheckstatus('arr_ids[]', 'unset_as', 'Record', 'data_form');" >-->
                    <!--    <option value="" selected="selected">Product Unset As</option>-->
                    <!--    <option value="popular_product">On Sale</option>-->
                    <!--    <option value="newarrival_product">New Arrival</option>-->
                    <!--</select>-->
                    <input type="hidden" name="action" id="actionInput" value="" />
                  </div>
                  <?php
                  echo form_close();
                } else {
                  ?>
                  <div class="alert alert-arrow-right alert-icon-right alert-light-primary mb-4" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                    <strong>Warning!</strong> No Record(s) Found!
                  </div>
                  <?php
                }
                ?>
              </div>
            </div>
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
<script type="text/javascript">
 
  // c3 = $('#style-3').DataTable({
  //   "oLanguage": {
  //     "oPaginate": {"sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'},
  //     "sInfo": "Showing page _PAGE_ of _PAGES_",
  //     "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
  //     "sSearchPlaceholder": "Search...",
  //     "sLengthMenu": "Results :  _MENU_",
  //   },
  //   "stripeClasses": [],
  //   "lengthMenu": [20, 40, 80, 150, 200],
  //   "pageLength": 20
  // });

  
$('#pagesize').change(function () {

$('#myForm').submit();

});
  //multiCheck(c3);
</script>
<?php die(); ?>