
<main class="main-area fix"> 
  
  <!-- breadcrumb-area -->
  <section class="breadcrumb__area breadcrumb__bg" data-background="<?php echo base_url('assets/frontend/'); ?>/assets/img/bg/breadcrumb_bg.jpg">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="breadcrumb__content">
            <h3 class="title">Latest Blogs</h3>
            <nav class="breadcrumb"> <span property="itemListElement" typeof="ListItem"> <a href="<?php echo base_url(''); ?>">Home</a> </span> <span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span> <span property="itemListElement" typeof="ListItem">Blogs</span> </nav>
          </div>
        </div>
      </div>
    </div>
    <div class="breadcrumb__shape-wrap"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/others/breadcrumb_shape01.svg" alt="img" class="alltuchtopdown"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/others/breadcrumb_shape02.svg" alt="img" data-aos="fade-right" data-aos-delay="300"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/others/breadcrumb_shape03.svg" alt="img" data-aos="fade-up" data-aos-delay="400"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/others/breadcrumb_shape04.svg" alt="img" data-aos="fade-down-left" data-aos-delay="400"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/others/breadcrumb_shape05.svg" alt="img" data-aos="fade-left" data-aos-delay="400"> </div>
  </section>
  <!-- breadcrumb-area-end --> 
  
  <!-- blog-area -->
  <section class="blog-area section-py-120">
    <div class="container">
      <div class="row">
        <div class="col-xl-9 col-lg-8">
          <div class="row gutter-20 ajax_list">
           
          
           
          
     
          </div>
          <nav class="pagination__wrap mt-25 " id="pagination_link">
            <ul class="list-wrap">
              <li class="active"><a href="#">1</a></li>
              <li><a href="blog.html">2</a></li>
              <li><a href="blog.html">3</a></li>
              <li><a href="blog.html">4</a></li>
            </ul>
          </nav>
        </div>
        <div class="col-xl-3 col-lg-4">
          <aside class="blog-sidebar">
  
            <div class="blog-widget">
              <h4 class="widget-title">Latest Post</h4>
              <?php foreach($newblog as $newblogrow) { ?>
              <div class="rc-post-item">
                <div class="rc-post-thumb"> <a href="<?php echo base_url('blog-detail/').'/'.$newblogrow->url_slug; ?>"> <img src="<?php echo base_url('assets/blog/').'/'.$newblogrow->blog_image; ?>" alt="img"> </a> </div>
                <div class="rc-post-content"> <span class="date"><i class="flaticon-calendar"></i> <?php echo date('Y-m-d', strtotime($newblogrow->date_time)); ?></span>
                  <h4 class="title"><a href="<?php echo base_url('blog-detail/').'/'.$newblogrow->url_slug; ?>"><?php echo $newblogrow->blog_name; ?></a></h4>
                </div>
              </div>
              
              <?php } ?>
              
            
              
            </div>
         
          </aside>
        </div>
      </div>
    </div>
  </section>
  <!-- blog-area-end --> 
  
</main>
<script>
    $(document).ready(function(){
   
        ajax_list(1);
    function ajax_list(page)
    {
        
      
        var action = 'fetch_data';
 
    var id = $('#id').val();
      
        $.ajax({
            url:"<?php echo base_url(); ?>/blog_list/"+page,
            method:"POST",
            dataType:"JSON",
            data:{action:action,id:id},
            beforeSend: function(){
               
          
            },
            success:function(data)
            {
                $('#item_total').html(data.item_total);
        
                 $('.ajax_list').html(data.product_list);
                $('#pagination_link').html(data.pagination_link);
        
            }
        })
    }
    
 $('#categorys').on('change', function() {
    ajax_list(1);
});
   

    $(document).on('click', '.pagination li a', function(event){
        event.preventDefault();
         var page = $(this).attr('href').split('=').pop();
         ajax_list(page);
    }); 
    
    })
</script>