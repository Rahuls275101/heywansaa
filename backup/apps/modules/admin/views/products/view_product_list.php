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
            echo $this->session->flashdata('msg');
            ?>
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-8 col-md-8 col-sm-8 col-8">
                  <h4><?php echo $headingTitle; ?></h4>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-4 col-4 text-right">
                  <h4><a href="<?php echo base_url(); ?>wps-admin/products/add" class="btn btn-dark btn-sm mb-2"><i class="fa fa-plus"></i> Add New Product</a></h4>
                </div>
              </div>
            </div>
            <div class="widget-header">

<?php echo form_open(current_url_query_string(), 'id="myForm" method="get"'); ?>

  <div class="row">

    <div class="col-xl-6 col-md-6 col-sm-12 col-12 row" style="margin-left:0px">

      <h4>Per Page : </h4> <?php echo display_record_per_page(); ?> 

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
                if (is_array($res) && !empty($res)) {
                 
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
                        <th>Product Price</th>
                        <th>Product Picture</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($res as $catKey => $pageVal) {
                       
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
                          echo '<br /><br /> Feature Products : <b>Yes</b><br />';
                        }
                        if($pageVal['newarrival_product'] == 1){
                          echo '<br /><br />Recommended : <b>Yes</b><br />';
                        } ?></p>
                      </td>
                      <td><?php echo $pageVal['product_code']; ?></td>
                      <td>
                          <span style="color: #b00;"><?php echo display_price($pageVal['product_discounted_price']); ?></span>
                      </td>
                      <td align="center" valign="top">
                        <img src="<?php echo get_image('products', $pageVal['media'], 50, 50, 'AR'); ?>" />
                      </td>
                      
                          
                          <td><?php echo ($pageVal['status'] == 1) ? "Active" : "In-active"; ?><br>
                           <button  class="btn btn-danger" type="button"  data-toggle="modal" data-target="#changeStatus<?php echo $pageVal['products_id'];?>">
                                    <?php if($pageVal['status']=='0'){echo "Approve Now";}else{ echo "Disable"; } ?>
                            </button>   
                          </td>
                          <td>
                            <a href="<?php echo base_url(); ?>wps-admin/products/edit/<?php echo $pageVal['products_id']; ?>" class="btn btn-warning btn-sm mb-2">Edit</a> <br />


                            <?php if($pageVal['color_ids']!='' || $pageVal['size_ids']!=''){ ?>
                                <p><?php echo anchor_popup('wps-admin/products/view_stocks/' . $pageVal['products_id'], "<span>Manage Stocks</span>"); ?></p>
                            <?php } ?>
                            
                            
                            
                            
                            
                            
    <!--<a href="<?php echo base_url().'wps-admin/product/changestatus/item/'.$pageVal['products_id'].'/'.$pageVal['status'];?>"            onclick="return confirm('Are you sure want to Approve this product');"  class="btn btn-danger">    <?php if($pageVal['status']=='0'){echo "Approve Now";}else{ echo "Disable"; } ?></a>-->
    <a href="<?php echo base_url().'wps-admin/products/set/arrival/'.$pageVal['products_id'];?>"           onclick="return confirm('Are you sure want to Set as Recommended');"            class="btn btn-success">       Set as Recommended  </a>
    <a href="<?php echo base_url().'wps-admin/products/set/sale/'.$pageVal['products_id']; ?>"             onclick="return confirm('Are you sure want to  Set as Feature');"               class="btn btn-success">       Set as Feature      </a>
    <a href="<?php echo base_url().'wps-admin/products/set/todaysdeal/'.$pageVal['products_id'];?>"           onclick="return confirm('Are you sure want to Set as Recommended');"            class="btn btn-success">       Set as Today's deal  </a>
    <a href="<?php echo base_url().'wps-admin/products/set/seasonal-delights/'.$pageVal['products_id'];?>"           onclick="return confirm('Are you sure want to Set as Recommended');"            class="btn btn-success">       Set as Seasonal Delights  </a>
    
    <a href="<?php echo base_url().'wps-admin/products/unset/arrival/'.$pageVal['products_id'];?>"         onclick="return confirm('Are you sure want to Unset as Recommended');"          class="btn btn-primary">          Unset as Recommended</a>
    <a href="<?php echo base_url().'wps-admin/products/unset/sale/'.$pageVal['products_id'];?>"            onclick="return confirm('Are you sure want to  Unset as Feature');"             class="btn btn-primary">          Unset as Feature    </a>
    <a href="<?php echo base_url().'wps-admin/products/unset/todaysdeal/'.$pageVal['products_id'];?>"         onclick="return confirm('Are you sure want to Unset as Today');"          class="btn btn-primary">       Unset as Today's deal</a>
    <a href="<?php echo base_url().'wps-admin/products/unset/seasonal-delights/'.$pageVal['products_id'];?>"           onclick="return confirm('Are you sure want to Unset as Seasonal Delights');"            class="btn btn-primary">Unset as Seasonal Delights  </a>
    
    <a href="<?php echo base_url().'wps-admin/product/delete/item/'.$pageVal['products_id'];?>"            onclick="return confirm('Are you sure want to Delete');"                        class="btn btn-danger">     Delete              </a>
    
                            
                       
                       
                       
                     
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
                            
                            
                            
                            
                          </td>
                        </tr>
                       
                       
                        <div id="changeStatus<?php echo $pageVal['products_id'];?>" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                              <div class="modal-header d-block">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Product Verification</h4>
                              </div>
                              <div class="modal-body">
                                <form class="" action="<?php echo base_url().'wps-admin/product/changestatus/item'; ?>" method="post">
                                    <div class="form-group">
                                        <label><input type="radio" name="verif" id="astatus" value="1"  <?php if($pageVal['status'] == 1){ echo "checked";}?> onclick="$('#status').val($(this).val());">  Accept  </label><br>
                                        <label><input type="radio" name="verif" id="rstatus" value="0"  <?php if($pageVal['status'] == 0){ echo "checked";}?> onclick="$('#status').val($(this).val());">  Reject  </label>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <h6>Selling Price</h6>₹ 
                                            <?php 
                                                    // product_discounted_price         product_price
                                                    echo $pageVal['product_discounted_price']; 
                                                ?>
                                        </div>
                                        <div class="col-md-3">
                                            <h6>MRP</h6> ₹ 
                                            <?php 
                                                echo $pageVal['product_price']; 
                                            ?>
                                          </div> 
                                          <div class="col-md-3">
                                              <h6>Admin Margin</h6>₹ 
                                              <?php 
                                              error_reporting(E_ALL);
                                              ini_set('display_errors', '1');
                                                $admin_data=$this->db->query("SELECT * FROM wps_admin WHERE admin_id=1")->row_array();
                                                $admin_margin=$admin_data['admin_margin'];
                                                $margin_amount=round(($pageVal['product_discounted_price']*$admin_margin)/100); 
                                                ?>
                                                <input type="text" name="admin_margin_amount" value="<?php echo $margin_amount; ?>" id="margin_amount<?php echo $pageVal['products_id']; ?>"> 
                                            </div>
                                            <div class="col-md-3">
                                                <h6>New Selling Price (<?php echo $admin_margin; ?>%)</h6>₹ 
                                                <?php 
                                                     $new_selling_price= round($pageVal['product_discounted_price']+($pageVal['product_discounted_price']*$admin_margin)/100); 
                                                ?>
                                                 <input type="text" value="<?php echo $new_selling_price; ?>" id="new_selling_price<?php echo $pageVal['products_id']; ?>" name="new_selling_price">
                                          </div> 
                                    </div>
                                    <div class="form-group">
                                        <label>Remark</label>
                                        <textarea name="remark" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group text-center">
                                        <input type="hidden" name="status" checked value="1" id="status">
                                        <input type="hidden" name="product_id" value="<?php echo $pageVal['products_id']; ?>">
                                        <input type="hidden" name="admin_margin_percent" value="<?php echo $admin_margin;  ?>">
                                        <input type="hidden" name="prev_product_price" value="<?php echo $pageVal['product_discounted_price']?>">
                                        <!--<input type="hidden" name="admin_margin_amount" value="<?php echo round(($pageVal['product_discounted_price']*$admin_margin)/100);  ?>">-->
                                       <?php
                                        //   if($new_selling_price < $pageVal['product_price'])
                                        //   {
                                        //     //   echo "<style> .msgbtnsubmit{color:red;display:none} </style>";
                                        //       echo '<input type="submit" value="submit" class="btn btn-info submit">';
                                        //   }
                                        //   else
                                        //   {
                                        //       echo "<style>  .msgbtnsubmit{color:red;display:block} </style>";
                                        //       echo ' <div class="msgbtnsubmit">Please Decrease the Admin Margin</div>';
                                        //   }
                                       ?>
                                        
                                    <input type="submit" value="submit" class="btn btn-info submit<?php echo $pageVal['products_id']; ?> <?php if($new_selling_price > $pageVal['product_price']){echo 'd-none';} ?>">
                                            <div class="msgbtnsubmit<?php echo $pageVal['products_id']; ?>" style="display:<?php if($new_selling_price > $pageVal['product_price']){echo 'block';}else{echo 'none';} ?>">Please Decrease the Admin Margin</div>
                                        
                                       
                                       
          <script src="<?php echo base_url(); ?>assets/sitepanel/assets/js/libs/jquery-3.1.1.min.js"></script>
          <script>
              $('#margin_amount<?php echo $pageVal['products_id']; ?>').on('keyup',function(){
                    var sumamt=0
                    var disc_price      =   ('<?php  echo $pageVal['product_discounted_price'] ?>');
                    var margin_amount   =   $(this).val();
                    disc_price          =   disc_price.replace( /^\D+/g, '');
                    margin_amount       =   margin_amount.replace( /^\D+/g, '');
                    sumamt   =  Number(disc_price) + Number(margin_amount);
                    
                    $('#new_selling_price<?php echo $pageVal['products_id']; ?>').val(sumamt);
                    
                    var product_mrp=<?php echo $pageVal['product_price'] ?>;
                    
                    if(  product_mrp < $('#new_selling_price<?php echo $pageVal['products_id']; ?>').val() )
                    {
                        // console.log("product_mrp<sumamt Please Decrease the Admin Margin");
                         $('.submit<?php echo $pageVal['products_id']; ?>').hide();
                         $('.msgbtnsubmit<?php echo $pageVal['products_id']; ?>').show();
                         console.log("product_mrp km hai new selling price se");
                    }
                    else
                    {
                        
                         $('.submit<?php echo $pageVal['products_id']; ?>').removeClass('d-none');
                         $('.submit<?php echo $pageVal['products_id']; ?>').show();
                         $('.msgbtnsubmit<?php echo $pageVal['products_id']; ?>').hide();
                         console.log("product_mrp jyafa hai new selling price se condition is : mrp="+product_mrp+"\n new selling price="+$('#new_selling_price<?php echo $pageVal['products_id']; ?>').val());
                    }
              })
          </script>
          <script>
              
          </script>
                                        
                                        
                                        
                                    </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        
                        
                        
                        
                        
                      <?php
                    }
                    ?>
                      <tr>

<td colspan="7" style="width:50%; text-align: center;">

  <p class="paging"><?php echo $paging;  echo form_open(base_url() . "wps-admin/products/", 'id="data_form"'); ?></p>

</td>

</tr>
                    </tbody>
                  </table>
                  <div class="widget-content widget-content-area text-left split-buttons">
                    <input name="status_action" type="submit"  value="Activate" class="btn btn-success mb-2" id="Activate" onClick="return validcheckstatus('arr_ids[]', 'Activate', 'Record', 'data_form');"/>
                    <input name="status_action" type="submit" class="btn btn-warning mb-2" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]', 'Deactivate', 'Record', 'data_form');"/>
                    <!--<input name="status_action" type="submit" class="btn btn-danger mb-2" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]', 'Delete', 'Record', 'data_form');"/>-->
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