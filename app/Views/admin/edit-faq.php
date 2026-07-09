


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Faq</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    

    <section class="content">
      <div class="row">
        <div class="col-12">
          <!-- /.card -->
          <div class="card">
               <?php if(session()->getFlashdata('failed')):?>
                    <div class="alert alert-danger alert-dismissable">
                       <?= session()->getFlashdata('failed') ?>
                    </div>
                <?php endif;?>

                <?php if(session()->getFlashdata('created')):?>
                    <div class="alert alert-success alert-dismissable">
                       <?= session()->getFlashdata('created') ?>
                    </div>
                <?php endif;?>
            <!-- /.card-header -->

<form role="form" method="POST" action="<?php echo base_url('admin/edit_faq_process/'.$faqView->faq_id.''); ?>" enctype="multipart/form-data">
                <div class="card-body">
                   <div class="row">
        
                  <div class="col-md-12">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Faq Question?*</label>
                    <input type="text" class="form-control" name="faq_question" required value="<?php echo $faqView->faq_question; ?>">
                     <input type="hidden" required class="form-control" name="type" value="<?php echo $faqView->type; ?>" required>
                  </div>
                  </div>

                  <div class="col-md-12">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Faq Answer*</label>
                    <input type="text" class="form-control" name="faq_answer" required value="<?php echo $faqView->faq_answer; ?>">
                  </div>
                  </div>

                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Status*</label>
                    <select class="form-control" required name="faq_status">
                    <option value="Active" <?php if($faqView->faq_status=='Active') { echo "selected"; } ?>>Active</option>
                    <option value="Inactive" <?php if($faqView->faq_status=='Inactive') { echo "selected"; } ?>>Inactive</option>
                    </select> 
                  </div>
                  </div>

                  <div class="col-md-6" style="margin-top: 31px;">
                  <div class="form-group">
                    <input type="submit" name="EditFaq" value="Submit" class="btn btn-primary">
                  </div>
                  </div>

                  </div>
                </div>
                <!-- /.card-body -->
              </form>


            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

