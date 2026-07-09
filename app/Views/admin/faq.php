


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Faq</h1>
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

<form role="form" method="POST" action="<?php echo base_url('admin/faq_process'); ?>" enctype="multipart/form-data">
                <div class="card-body">
                   <div class="row">

    <div class="col-md-9">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Question *</label>
                    <input type="text" required class="form-control" name="faq_question" required>
                    
                    <input type="hidden" required class="form-control" name="type" value="<?php echo $id; ?>" required>
                  </div>
                  </div>

        
                   <div class="col-md-3">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Status*</label>
                    <select class="form-control" required name="faq_status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    </select> 
                  </div>
                  </div>
              

                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Answer*</label>
                    <input type="text" class="form-control" name="faq_answer" required>
                  </div>
                  </div>

                 

                  <div class="col-md-6" style="margin-top: 31px;">
                  <div class="form-group">
                    <input type="submit" name="CreateFaq" value="Submit" class="btn btn-primary">
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




        <div class="col-12">
          <!-- /.card -->
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#S.No</th>
                  <th>Question</th>
              
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody> 
                <?php
                $clientSeId = 1;
                foreach ($faqView as $faqView) {
                ?>
                <tr>
                <th><?php echo $clientSeId; ?></th>
                <th><?php echo $faqView->faq_question; ?><br><?php echo $faqView->faq_answer; ?></th>
               
                <th><a href="javascript:void(0);" class="btn btn-block btn-<?php echo $faqView->faq_status_color; ?> btn-sm"><?php echo $faqView->faq_status; ?></a></th>
                <th>
                  <a href="<?php echo base_url('admin/edit_faq/'.$faqView->faq_id.''); ?>" class="btn btn-block btn-primary btn-sm">Edit</a>

                <br>
                  <a href="<?php echo base_url('admin/delete_faq/'.$faqView->faq_id.'/'.$id); ?>" class="btn btn-block btn-danger btn-sm">Delete</a></th>
                </tr> 
                <?php
                $clientSeId++;
                }
                ?>             
                </tbody>
              </table>
            </div>
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

