<style>
.note-editable, .card-block {
  height:200px !important;
}
</style>

<div class="ec-content-wrapper">
  <div class="content">
    <div class="breadcrumb-wrapper breadcrumb-contacts">
      <div>
        <h1>Vender Update</h1>
        <p class="breadcrumbs"><span><a href="#">Home</a></span>
          <span><i class="mdi mdi-chevron-right"></i></span>Vender Update >
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="ec-cat-list card card-default">

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

          <form method="POST" action="<?php echo base_url('admin/edit-user-process/'.$id); ?>" enctype="multipart/form-data">
            <div class="card-body">
              <div class="row">

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name*</label>
                    <input type="text" required class="form-control" name="name" value="<?php echo $admin->name; ?>">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email*</label>
                    <input type="text" required class="form-control" name="email" value="<?php echo $admin->email; ?>">
                  </div>
                </div>

                <!-- GST (optional) -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="gst_number">GST Number (Optional)</label>
                    <input type="text" class="form-control" name="gst_number" placeholder="Enter GST Number" value="<?php echo $admin->gst_number ?? ''; ?>">
                  </div>
                </div>



                <div class="col-md-3">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Status*</label>
                    <select class="form-control" required name="status">
                      <option value="Active" <?php if($admin->status=='Active') echo "selected"; ?>>Approved</option>
                      <option value="Inactive" <?php if($admin->status=='Inactive') echo "selected"; ?>>Disapproved</option>
                    </select> 
                  </div>
                </div>
                
                
                <div class="col-md-6">
  <div class="form-group">
    <label for="aadhar_file">Upload Aadhaar</label>
    <input type="file" class="form-control" name="aadhar_file" id="aadhar_file" accept="image/*,application/pdf" onchange="previewFile(this, 'aadhar_preview')">
    <?php if(!empty($admin->aadhar_file)): ?>
      <small>Current: <a href="<?= base_url('assets/aadhar/'.$admin->aadhar_file) ?>" target="_blank">View Aadhaar</a></small>
    <?php endif; ?>
    <div id="aadhar_preview" style="margin-top:10px;"></div>
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label for="pan_file">Upload PAN</label>
    <input type="file" class="form-control" name="pan_file" id="pan_file" accept="image/*,application/pdf" onchange="previewFile(this, 'pan_preview')">
    <?php if(!empty($admin->pan_file)): ?>
      <small>Current: <a href="<?= base_url('assets/pan/'.$admin->pan_file) ?>" target="_blank">View PAN</a></small>
    <?php endif; ?>
    <div id="pan_preview" style="margin-top:10px;"></div>
  </div>
</div>



              </div>
            </div>

            <div class="white_card-footer" style="text-align: center;">
              <input type="submit" name="CreateNewProduct" value="Submit" class="btn btn-primary">
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>





<script>
function previewFile(input, previewId) {
  const file = input.files[0];
  const previewDiv = document.getElementById(previewId);
  previewDiv.innerHTML = ''; // Clear old preview

  if (!file) return;

  const fileType = file.type;

  if (fileType.includes("image")) {
    // If it's an image
    const reader = new FileReader();
    reader.onload = function(e) {
      previewDiv.innerHTML = `<img src="${e.target.result}" style="max-width:200px; border:1px solid #ccc; border-radius:8px;">`;
    };
    reader.readAsDataURL(file);
  } else if (fileType === "application/pdf") {
    // If it's a PDF
    const reader = new FileReader();
    reader.onload = function(e) {
      previewDiv.innerHTML = `<embed src="${e.target.result}" type="application/pdf" width="200" height="250" style="border:1px solid #ccc; border-radius:8px;">`;
    };
    reader.readAsDataURL(file);
  } else {
    previewDiv.innerHTML = `<p style="color:red;">Unsupported file type</p>`;
  }
}
</script>

<script>
 function xcategory() {

  var category_id = document.getElementById("menu_category").value;
  if(category_id != '')
  {
		
   $.ajax({
    url:"<?php echo base_url(); ?>admin/categoryajax",
    method:"POST",
    data:{category_id:category_id},
    success:function(data)
    {
     
     $('#category').html(data);
    
    }
   });
  }
  else
  {
   $('#category').html('<option value="">Select Category</option>');
   
  }
 }
</script>

<script>
 function xsubcategory() {

  var category_id = document.getElementById("category").value;
  if(category_id != '')
  {
		
   $.ajax({
    url:"<?php echo base_url(); ?>admin/categoryunitajax",
    method:"POST",
    data:{category_id:category_id},
    success:function(data)
    {
     
     $('#unit').html(data);
    
    }
   });
  }
  else
  {
   $('#unit').html('<option value="">Select Unit</option>');
   
  }
 }
</script>

 <script type='text/javascript'>
   
   function fields() {
   
   count_id = document.getElementById("countfild").value;;
   
     $.ajax({
    url:"<?php echo base_url(); ?>admin/additmeajax",
	
    method:"POST",
    data:{count_id:count_id},
    success:function(data)
    {
     
    $('.xyz').append(data);
  $('.textarea').summernote({
      height:'100px'
    })

     
    }
   });
   
    event.preventDefault();   
    
    var x = 1;
    document.getElementById("countfild").value = Number(count_id) + Number(x);


}


</script>

<script type='text/javascript'>
   
   function fieldsspec() {
  
 count_id = document.getElementById("scount").value;;
   $.ajax({
    url:"<?php echo base_url(); ?>admin/fieldsspecajax",
	
    method:"POST",
    data:{count_id:count_id},
    success:function(data)
    {
     
    $('.specclass').append(data);
  $('.textarea').summernote({
      height:'50px'
    })

     
    }
   });
   
    event.preventDefault();  
 
     
   
 

    var x = 1
    document.getElementById("scount").value = Number(count_id) + Number(x);

}


</script>