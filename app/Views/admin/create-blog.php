 <style>
.note-editable,card-block
{
  height:200px !important;
}
<?php 
use App\Models\Commanmodel;

 $commanmodel = new Commanmodel();
 ?>
 </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Create new News / Video</h1>
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
                <form role="form" method="POST" action="<?php echo base_url('admin/create_blog_process'); ?>" enctype="multipart/form-data">
                <div class="card-body">
                   <div class="row">

                  <div class="col-md-12">
                  <div class="form-group">
                    <label for="exampleInputEmail1"> Title*</label>
                    <input type="text" required class="form-control" name="blog_name" required>
                  </div>
                  </div>


                  <div class="col-md-3">
                  <div class="form-group">
                    <label for="exampleInputFile">Image*</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" required name="blog_image">
                      </div>
                    </div>
                  </div>
                  </div>
         
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Status*</label>
                    <select class="form-control" required name="blog_status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    </select> 
                  </div>
                  </div>


                  
                   
                
                  <div class="col-md-12">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Small Description*</label>
                    <input type="text" class="form-control" name="blog_small_description" required>
                  </div>
                  </div>

                  <div class="col-md-12">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Long Description</label>
                    <div class="mb-3">
                    <textarea class="textarea" id="ckeditor" placeholder="Enter the course description..." style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="blog_description"></textarea>
                    </div>
                  </div>
                  </div>


                  <div class="col-md-12">
                  <h4>Meta tag</h4>
                  </div> 

                  <div class="col-md-12">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Meta Title</label>
                  <input type="text" class="form-control" name="meta_title"> 
                  </div>
                  </div>

                  <div class="col-md-12">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Meta Keyword</label>
                  <input type="text" class="form-control" name="meta_keyword" required> 
                  </div>
                  </div>

                  <div class="col-md-12">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Meta Description</label>
                  <input type="text" class="form-control" name="meta_description" required> 
                  </div>
                  </div>


                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer" style="text-align: center;">
                  <input type="submit" name="CreateNewBlog" value="Submit" class="btn btn-primary">
                </div>
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




