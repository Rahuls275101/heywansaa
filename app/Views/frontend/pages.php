<div class="main-content main-content-contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-trail breadcrumbs">
                    <ul class="trail-items breadcrumb">
                        <li class="trail-item trail-begin">
                            <a href="<?php echo base_url(''); ?>">Home</a>
                        </li>
                        <li class="trail-item trail-end active">
                           <?php echo $pages->cms_page_heading; ?>
                        </li>
                    </ul>
                </div>   
            </div>
        </div>
        <div class="row">
         
            <div class="col-md-12">
                <h1 class=""><?php echo $pages->cms_page_heading; ?>
                </h1>
                <h3><?php echo $pages->cms_page_small_description; ?>
                </h3>
              <?php echo $pages->cms_page_description; ?>
            </div>
        </div>
    </div>
   
</div>
