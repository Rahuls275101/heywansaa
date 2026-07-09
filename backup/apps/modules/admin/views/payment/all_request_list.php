<?php $this->load->view('includes/top'); ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
                <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                  <h4><?php echo $headingTitle; ?></h4>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                    <?php
                    if($this->session->flashdata('msg'))
                    {
                        echo "<div class='alert alert-primary'>".$this->session->flashdata('msg')."</div>";
                    }
                    ?>
                    
                   
                </div>
               
              </div>
            </div>
            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">
                <?php
                if (is_array($res) && !empty($res)) {
                 
                  ?>
                  <table id="style-3" class="table style-3  table-hover">
                    <thead>
                      <tr>
                        <th class="text-center">Requested Payment Details</th>
                        <th class="text-center">Vendor Details</th>
                        <th class="text-center">Action</th>
                  
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $c=1;
                      $ttl_debt=0;
                      foreach ($res as $catKey => $pageVal) {
                        $ttl_debt=$ttl_debt+$pageVal['debit'];
                        ?> 
                        <tr>
                         
                          <td class="text-center">
                              <ul class="list-unstyled">
                                  <li> <?= date('d-m-Y h:i A',strtotime($pageVal['req_date']))?></li>
                                  <li><h4 class="text-primary">Rs. <?= $pageVal['amount'] ?></h4></li>
                                  
                              </ul>
                              
                          </td>
                          <td class="text-center">
                              <ul class="list-unstyled">
                                
                                <li>Name: <?=$pageVal['name']?></li>
                                <li>Email: <?=$pageVal['admin_email']?></li>
                                <li>Phone No.: <?=$pageVal['phone']?></li>
                                <!--<li>Address: <?=$pageVal['address']?>, <?=$pageVal['city']?>, <?=$pageVal['country']?></li>-->
                                <li class="text-primary">Remark By Admin: <?=$pageVal['admin_remark']?></li>
                                <li class="text-info">Remark By Vendor: <?=$pageVal['vendor_remark']?></li>
                                <li>
                                
                                </li>
                              </ul>
                          </td>
                          <td class="text-center">
                              
                                    <?php
                                        if($pageVal['admin_status']==0 && $pageVal['cancel_status']==0)
                                        {
                                            echo "<span class='alert-warning'>Processing</span>";
                                        }
                                        elseif($pageVal['admin_status']==1 && $pageVal['cancel_status']==0)
                                        {
                                            echo "<span class='alert-success'>Confirm</span>";
                                        }
                                        elseif($pageVal['admin_status']==0 && $pageVal['cancel_status']==1)
                                        {
                                            echo "<span class='alert-danger'>Cancel</span>";
                                        }
                                    
                                    ?>
                                    <!--<form action="<?php echo base_url().'wps-admin/payment/change-request-status'; ?>"></form>-->
                                    <?php
                                     echo form_open(base_url() . "wps-admin/payment/change-request-status", 'id="data_form'.$pageVal['id'].'"');
                                    ?>
                                    <input type="hidden" name="req_id" value="<?php echo $pageVal['id']; ?>">
                                    <input type="hidden"name="vid" value="<?php echo $pageVal['vendor_id']; ?>">
                                     Remark from vendor: <textarea name="vendor_remark" class="form-control" value="" placeholder="Remark" readonly><?php echo $pageVal['vendor_remark']; ?></textarea>
                                    <br>Add Remark for Vendor: <textarea name="admin_remark" class="form-control" value="" placeholder="Remark" ><?php echo $pageVal['admin_remark']; ?></textarea>
                                    <select onchange="" name="change_status" id="change_status<?php echo $pageVal['id']; ?>" class="form-control" required>
                                        <option>--Select For Action--</option>
                                        <option value="0">Cancel</option>
                                        <option value="1">Confirm</option>
                                    </select>
                                    
                                       <script>
                                        $('#change_status<?php echo $pageVal['id']; ?>').on('change',function(){
                                            if(this.value==0)
                                            {
                                                 confirm('Are you sure want to Cancel this request?');
                                                $('#data_form<?php echo $pageVal['id']; ?>').submit();
                                            }
                                            if(this.value==1)
                                            {
                                                 confirm('Are you sure want to Confirm this request?');
                                                $('#data_form<?php echo $pageVal['id']; ?>').submit();
                                            }
                                            
                                            
                                           
                                        })
                                    </script>
                                    
                                     <?php echo form_close();?>
                          </td>
                        </tr>
                        <?php
                      }
                      ?>
                    </tbody>
                  </table>
               
                  <?php
                 
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
  c3 = $('#style-3').DataTable({
    "oLanguage": {
      "oPaginate": {"sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'},
      "sInfo": "Showing page _PAGE_ of _PAGES_",
      "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
      "sSearchPlaceholder": "Search...",
      "sLengthMenu": "Results :  _MENU_",
    },
    "stripeClasses": [],
    "lengthMenu": [20, 40, 80, 150, 200],
    "pageLength": 20
  });

  multiCheck(c3);
</script>


