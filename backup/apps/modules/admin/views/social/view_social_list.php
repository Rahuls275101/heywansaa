<?php $this->load->view('includes/top');
?>
<!--  BEGIN MAIN CONTAINER  -->
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
            // echo form_open_multipart(base_url().'wps-admin/brand/action');
            echo success_message();
            print_r($this->session->flashdata('msg'));
            ?> 
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                  <h4><?php echo $headingTitle; ?></h4>
                </div>
               
              </div>
            </div>


            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">
              </div>



              <div class="widget-header">
                <div class="row">
                       <div class="col-xl-12">
                           <div class="table-responsive">
                                <table class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th width="6%">Sr.No.</th>
                                      <th width="20%">Title</th>
                                      <th width="44%">Content</th>
                                      <?php if($edit_data == 'Y'): ?>
                                      <th width="10%">--</th>
                                      <?php endif; ?>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php if($ALLDATA <> ""): $i=1; foreach($ALLDATA as $ALLDATAINFO): ?>
                                      <tr class="<?php if($i%2 == 0): echo 'odd'; else: echo 'even'; endif; ?> gradeX">
                                        <td><?=$i++?></td>
                                       
                                        <td><?=stripslashes($ALLDATAINFO['name'])?></td>
                                         <td><?=stripslashes($ALLDATAINFO['link'])?></td>
                                        <td>
                                              <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModalsocialupdate<?=stripslashes($ALLDATAINFO['id'])?>"><i class="fa fa-edit"></i></button>
                                                  <!-- Modal -->
                                                  <div class="modal fade" id="myModalsocialupdate<?=stripslashes($ALLDATAINFO['id'])?>" role="dialog">
                                                    <div class="modal-dialog">
                                                    
                                                      <!-- Modal content-->
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                          <h4 class="modal-title">Update <?=stripslashes($ALLDATAINFO['name'])?></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                          <form action="<?php  echo base_url().'wps-admin/social_links/edit'; ?>" method="post">
                                                              <div class="form-group">
                                                                  <label>Link</label>
                                                                  <input type="text" name="link" class="form-control" value="<?=stripslashes($ALLDATAINFO['link'])?>">
                                                                  <input type="hidden" name="id" class="form-control" value="<?=stripslashes($ALLDATAINFO['id'])?>">
                                                                  <input type="hidden" name="name" class="form-control" value="<?=stripslashes($ALLDATAINFO['name'])?>">
                                                              </div>
                                                              <div class="form-group">
                                                                  <input type="submit"  class="btn btn-success" >
                                                              </div>
                                                          </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                        </td>
                                      </tr>
                                    <?php endforeach; else: ?>
                                      <tr>
                                        <td colspan="5" style="text-align:center;">No Data Available In Table</td>
                                      </tr>
                                    <?php endif; ?>
                                  </tbody>
                                </table>
                        </div>
                       </div>
                  </div>
                 
                </div>
              </div>
              <?php echo form_close(); ?>
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
  
  <?php die(); ?>
       