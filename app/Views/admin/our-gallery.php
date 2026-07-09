


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Available Gallery</h1>
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
            <div class="card-body">
    <form class="form-inline" method="POST" action="<?php echo base_url('admin/our_gallery_process'); ?>" enctype="multipart/form-data">
 <div class="col-12">
        <div class="row">
              <div class="col-4">
                    <div class="col-md-3">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Type*</label>
                    <select class="form-control" required name="type">
                    <option value="clients">clients </option>
                 
                    </select> 
                  </div>
                  </div>
            </div>
             <div class="col-4">
                    <div class="form-group">
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" required="" name="client_logo">
                      
                      </div>
                    </div>
                  </div>
            </div>
             <div class="col-4">
                  <div class="form-group mx-sm-3 mb-2">
    <input type="submit" name="upload_logo" value="Upload" class="btn btn-success">
    </div>
            </div>
            
        </div>

</div>

                

   
    </form>                            


            </div>
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
                    <th>Type</th>
                  <th>Gallery</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody> 
                <?php
                $clientSeId = 1;
                foreach ($clientView as $clientView) {
                ?>
                <tr>
                <th><?php echo $clientSeId; ?></th>
                  <th><?php echo $clientView->type; ?></th>
                <th><img src="<?php echo base_url('assets/client/'.$clientView->client_image.''); ?>" style="width: 200px; height:100px;"></th>
                <th><a href="<?php echo base_url('admin/delete_gallery/'.$clientView->client_id.''); ?>" class="btn btn-block btn-danger btn-sm">Delete</a></th>
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

