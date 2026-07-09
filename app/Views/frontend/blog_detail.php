<main class="main-area fix"> 
  
  <!-- breadcrumb-area -->
  <section class="breadcrumb__area breadcrumb__bg" data-background="<?php echo base_url('assets/frontend/'); ?>/assets/img/bg/breadcrumb_bg.jpg">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="breadcrumb__content">
            <h3 class="title">Blog Details</h3>
            <nav class="breadcrumb"> <span property="itemListElement" typeof="ListItem"> <a href="index.html">Home</a> </span> <span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span> <span property="itemListElement" typeof="ListItem">
                 <a href="<?php echo base_url(''); ?>">Blogs</a> </span> <span class="breadcrumb-separator"><i class="fas fa-angle-right"></i></span> <span property="itemListElement" typeof="ListItem"><?php echo $blogs->blog_name; ?></span> </nav>
          </div>
        </div>
      </div>
    </div>
    <div class="breadcrumb__shape-wrap"> <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/others/breadcrumb_shape01.svg" alt="img" class="alltuchtopdown">
    <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/others/breadcrumb_shape02.svg" alt="img" data-aos="fade-right" data-aos-delay="300">
    <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/others/breadcrumb_shape03.svg" alt="img" data-aos="fade-up" data-aos-delay="400"> 
    <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/others/breadcrumb_shape04.svg" alt="img" data-aos="fade-down-left" data-aos-delay="400"> 
    <img src="<?php echo base_url('assets/frontend/'); ?>/assets/img/others/breadcrumb_shape05.svg" alt="img" data-aos="fade-left" data-aos-delay="400"> </div>
  </section>
  <!-- breadcrumb-area-end --> 
  
  <!-- blog-details-area -->
  <section class="blog-details-area section-py-120">
    <div class="container">
      <div class="row">
        <div class="col-xl-9 col-lg-8">
          <div class="blog__details-wrapper">
            <div class="blog__details-thumb"> <img src="<?php echo base_url('assets/blog/').'/'.$blogs->blog_image; ?>" alt="<?php echo $blogs->blog_name; ?>"> </div>
            <div class="blog__details-content">
              <div class="blog__post-meta">
                <ul class="list-wrap">
                  <li><i class="flaticon-calendar"></i> <?php echo date('Y-m-d', strtotime($blogs->date_time)); ?></li>
                  <li><i class="flaticon-user-1"></i> by <a href="#">Admin</a></li>
                  <!--<li><i class="flaticon-clock"></i> 5 Min Read</li>-->
                  <!--<li><i class="far fa-comment-alt"></i> 05 Comments</li>-->
                </ul>
              </div>
              <h3 class="title"><?php echo $blogs->blog_name; ?></h3>
          <?php echo $blogs->blog_description; ?>
          
          
          <!--<div class="blog__details-bottom">-->
          <!--      <div class="row align-items-center">-->
          <!--        <div class="col-xl-6 col-md-7">-->
          <!--          <div class="tg-post-tag">-->
          <!--            <h5 class="tag-title">Tags :</h5>-->
          <!--            <ul class="list-wrap p-0 mb-0">-->
          <!--              <li><a href="#">Bath Cleaning</a></li>-->
          <!--              <li><a href="#">Cleaning</a></li>-->
          <!--            </ul>-->
          <!--          </div>-->
          <!--        </div>-->
          <!--        <div class="col-xl-6 col-md-5">-->
          <!--          <div class="tg-post-social justify-content-start justify-content-md-end">-->
          <!--            <h5 class="social-title">Share :</h5>-->
          <!--            <ul class="list-wrap p-0 mb-0">-->
          <!--              <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>-->
          <!--              <li><a href="#"><i class="fab fa-twitter"></i></a></li>-->
          <!--              <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>-->
          <!--              <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>-->
          <!--            </ul>-->
          <!--          </div>-->
          <!--        </div>-->
          <!--      </div>-->
          <!--    </div>-->
            </div>
          </div>
         
          <!--<div class="blog-post-comment">-->
          <!--  <div class="comment-wrap">-->
          <!--    <div class="comment-wrap-title">-->
          <!--      <h4 class="title">02 Comments</h4>-->
          <!--    </div>-->
          <!--    <div class="latest-comments">-->
          <!--      <ul class="list-wrap">-->
          <!--        <li>-->
          <!--          <div class="comments-box">-->
          <!--            <div class="comments-avatar"> <img src="assets/img/blog/comment01.png" alt="img"> </div>-->
          <!--            <div class="comments-text">-->
          <!--              <div class="avatar-name">-->
          <!--                <h6 class="name">Jessica Rose</h6>-->
          <!--                <span class="date">20 July, 2024</span> </div>-->
          <!--              <p>Maximus ligula eleifend id nisl quis interdum. Sed malesuada tortor non turpis semper bibendum. Ut ac nisi porta, malesuada risus nonVestibulum ante ipsum primisMaximus ligula eleifend id nisl quis interdum. </p>-->
          <!--              <div class="comment-reply"> <a href="#" class="comment-reply-link">Reply</a> </div>-->
          <!--            </div>-->
          <!--          </div>-->
          <!--        </li>-->
          <!--        <li>-->
          <!--          <div class="comments-box">-->
          <!--            <div class="comments-avatar"> <img src="assets/img/blog/comment02.png" alt="img"> </div>-->
          <!--            <div class="comments-text">-->
          <!--              <div class="avatar-name">-->
          <!--                <h6 class="name">Parker Willy</h6>-->
          <!--                <span class="date">20 July, 2024</span> </div>-->
          <!--              <p>Maximus ligula eleifend id nisl quis interdum. Sed malesuada tortor non turpis semper bibendum. Ut ac nisi porta, malesuada risus nonVestibulum ante ipsum primis</p>-->
          <!--              <div class="comment-reply"> <a href="#" class="comment-reply-link">Reply</a> </div>-->
          <!--            </div>-->
          <!--          </div>-->
          <!--        </li>-->
          <!--      </ul>-->
          <!--    </div>-->
          <!--  </div>-->
          <!--  <div class="comment-respond">-->
          <!--    <h4 class="comment-reply-title">Post a comment</h4>-->
          <!--    <form action="#" class="comment-form">-->
          <!--      <p class="comment-notes"> <span>Your email address will not be published. Required fields are marked *</span> </p>-->
          <!--      <div class="comment-field">-->
          <!--        <textarea placeholder="Comment"></textarea>-->
          <!--      </div>-->
          <!--      <div class="row">-->
          <!--        <div class="col-lg-4">-->
          <!--          <div class="comment-field">-->
          <!--            <input type="text" placeholder="Name">-->
          <!--          </div>-->
          <!--        </div>-->
          <!--        <div class="col-lg-4">-->
          <!--          <div class="comment-field">-->
          <!--            <input type="email" placeholder="Email">-->
          <!--          </div>-->
          <!--        </div>-->
          <!--        <div class="col-lg-4">-->
          <!--          <div class="comment-field">-->
          <!--            <input type="text" placeholder="Website">-->
          <!--          </div>-->
          <!--        </div>-->
          <!--      </div>-->
          <!--      <div class="comment-field checkbox-grp">-->
          <!--        <input type="checkbox" id="checkbox_two">-->
          <!--        <label for="checkbox_two">Save my name, email, and website in this browser for the next time I comment.</label>-->
          <!--      </div>-->
          <!--      <p class="form-submit"></p>-->
          <!--      <button class="btn btn-two arrow-btn">Post Comment <img src="assets/img/icons/right_arrow.svg" alt="img" class="injectable"></button>-->
          <!--    </form>-->
          <!--  </div>-->
          <!--</div>-->
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
  <!-- blog-details-area-end --> 
  
</main>
<!-- main-area-end -->