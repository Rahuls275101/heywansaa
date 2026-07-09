


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Available News / Video</h1>
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
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>




        <div class="col-12">
          <!-- /.card -->
          <div class="card">
            <a href="<?php echo base_url('admin/create_blog'); ?>" class="btn btn-primary" style="width: 20%;">Add new News / Video</a>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="blog_list" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#S.No</th>
                  <th>Blog heading</th>
                  <th>Image</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody> 
                <?php
                $clientSeId = 1;
                foreach ($blogView as $blogView) {
                ?>
                <tr>
                <th><?php echo $clientSeId; ?></th>
                <th><?php echo $blogView->blog_name; ?></th>
                <th><img src="<?php echo base_url('assets/blog/'.$blogView->blog_image.''); ?>" style="width: 100px;height: 100px;"></th>
                <th><a href="javascript:void(0);" class="btn btn-block btn-<?php echo $blogView->blog_status_color; ?> btn-sm"><?php echo $blogView->blog_status; ?></a></th>
                <th>
                  <a href="<?php echo base_url('admin/edit_our_blog/'.$blogView->blog_id.''); ?>" class="btn btn-block btn-primary btn-sm">Edit</a>
                <br>
                  <a href="<?php echo base_url('admin/delete_our_blog/'.$blogView->blog_id.''); ?>" class="btn btn-block btn-danger btn-sm">Delete</a></th>
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

