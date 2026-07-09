<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('top');

?>
<style>
   
        .alert.alert-danger 
        {
            background-color: #ff0000;
            color: #fff;
            padding: 5px;
            border-radius: 4px;
        }
    
    
  .alert.alert-success {
    background-color: #1f9528;
    color: #fff;
    padding: 5px;
    border-radius: 4px;
} 
    
</style>
<main class="main">
            <!-- Start of Page Header -->
            <!--<div class="page-header">-->
            <!--    <div class="container">-->
            <!--        <h1 class="page-title mb-0">Bulk Orders</h1>-->
            <!--    </div>-->
            <!--</div>-->
            <!-- End of Page Header -->
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb">
                        <h1 class="page-title mb-0">Bulk Orders</h1>
                        <li><a href="demo1.html">Home</a></li>
                        <li>Bulk Orders</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->
            <!-- Start of PageContent -->
            <div class="page-content pb-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="bulk-orderimage mb-3">
                                        <img src="<?php echo base_url(); ?>assets/designer/themes/default/assets/images/bulkorder.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="bulk-orderform">
                                        <?php
                                        if($this->session->flashdata('bulkmsg'))
                                        {
                                            echo $this->session->flashdata('bulkmsg');
                                            $this->session->set_flashdata('bulkmsg','');
                                        }
                                        ?>
                                        <form action="<?php echo base_url().'misc/addbulkorder'; ?>" method="post">
                                            <div class="bulkformfieldbx">
                                                <input type="text" name="name" placeholder="Name" class="form-control mb-3">
                                            </div>
                                            <div class="bulkformfieldbx">
                                                <input type="tel" name="mobile" placeholder="Phone No." class="form-control mb-3">
                                            </div>
                                            <div class="bulkformfieldbx">
                                                <input type="email" name="email" placeholder="Email Id" class="form-control mb-3">
                                            </div>
                                            <div class="bulkformfieldbx">
                                                <input type="text" name="productname" placeholder="Product Name" class="form-control mb-3">
                                            </div>
                                            <div class="bulkformfieldbx">
                                                <input type="text" name="location" placeholder="Location" class="form-control mb-3">
                                            </div>
                                            <button class="bulkformbtn">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of PageContent -->
        </main>
<?php $this->load->view('bottom'); ?>