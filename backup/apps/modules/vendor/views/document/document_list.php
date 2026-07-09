<?php $this->load->view('includes/top'); ?>
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
                  <h4><?php echo "Upload Document"; ?></h4>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right">
                    
                  <a href="#" data-toggle="modal" data-target="#myModal" class="text-info">Click Here</a>
                      <?php
                    //   print_r($res);
                      
                   if($this->session->flashdata('msg'))
                   {
                       echo "<span class='alert alert-info'>".$this->session->flashdata('msg')."</span>";
                   }
                   ?>
                    <div id="myModal" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header d-block">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Upload Document</h4>
                              </div>
                              <div class="modal-body">
                              <?php echo form_open_multipart(base_url().'wps-vendor/document/add' ,'class="row"'); ?>
                                   <div class="col-4 form-group">
                                       <label>Title</label>
                                   </div>
                                   <div class="col-8 form-group">
                                       <input type="text" name="title" class="form-control" placeholder="Title here">
                                   </div>
                                   <div class="col-4 form-group">
                                       <label>Document</label>
                                   </div>
                                   <div class="col-8 form-group">
                                       <input type="file" name="document" class="" placeholder="">
                                   </div>
                                   <div class="col-4 form-group">
                                       <label>Remark</label>
                                   </div>
                                   <div class="col-8 form-group">
                                       <input type="text" name="remark" class="form-control" placeholder="Remark">
                                   </div>
                                   <div class="col-4 form-group">
                                      
                                   </div>
                                   <div class="col-8 form-group">
                                       <input type="submit" class="btn btn-success">
                                   </div>
                               <?php echo form_close(); ?>
                              </div>
                              <!--<div class="modal-footer">-->
                              <!--  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                              <!--</div>-->
                            </div>
                          </div>
                        </div>
              
              
                
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
                        <th class="text-center">#</th>
                         <th>Title</th>
                        <th>Description</th>
                        <th>Image/Doc</th>
                        <th class="">Remark</th>
                        <th class="">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $c=1;
                      $ttl_debt=0;
                      foreach ($res as $catKey => $pageVal) {
                        
                        ?> 
                        <tr>
                          <td class="checkbox-column text-left"><?=$c++?></td>
                          <td><?= date('d-m-Y h:i A',strtotime($pageVal['created_at']))?></td>
                          <td><?=$pageVal['document_title']?></td>
                          <td><img src="<?= base_url().'uploaded-files/vendor-doc/'.$pageVal['document_image']?>" height="30"></td>
                          <td><?=$pageVal['remark']?></td>
                          <td>
                              <a href="<?php echo base_url().'wps-vendor/delete/document/'.$pageVal['id']; ?>" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure want to delete?');">X</a>
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
