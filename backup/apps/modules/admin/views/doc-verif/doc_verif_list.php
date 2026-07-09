<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('includes/top');
//echo phpinfo();
?>
<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

  <div class="overlay"></div>
  <div class="search-overlay"></div>

  <?php $this->load->view('includes/left'); ?>

  <!--  BEGIN CONTENT AREA  -->
  <div id="content" class="main-content">
    <div class="layout-px-spacing">

      <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
          <div class="widget widget-chart-one">
            <div class="widget-heading">
              <h5 class="">Document List of Vendor</h5>
              
            </div>
            <div class="widget-content">
              <div class="tabs tab-content">
                <div id="content_1" class="tabcontent"> 
                  <div id="revenueMonthly"></div>
                </div>
              </div>
           
      
        
        
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hovered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Document Title</th>
                            <th>View Document</th>
                            <th>Remark</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count=1;
                        foreach($doclist as $dl=>$d)
                        { ?>
                        <tr>
                            <td><?=$count++?></td>   
                            <td><?=ucwords($d['document_title'])?></td>   
                            <td><img  src="<?php echo base_url().'uploaded-files/vendor-doc/'. $d['document_image']; ?>" style="border: 4px solid #5c5c5c;    border-radius: 5px; height:100px"></td>   
                            <td><?=ucwords($d['remark'])?></td>  
                            <td><?php
                                if($d['status']=='0')
                                { ?>
                                    <a class="btn btn-success" href="<?php echo base_url().'wps-admin/docverif/verifydocnow/'.$d['id']; ?>" onclick="return confirm('Are you sure want to Verify');">Verify Now</a>
                                <?php }
                                else
                                { ?>
                                    <a href="#" >Verified</a>
                                <?php }
                            ?></td>  
                        </tr>
                        <?php 
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
       <!--doclist      document_title document_image remark-->
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
