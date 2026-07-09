<?php
$this->load->view("top");
?>









<!-- Start of Main -->
        <main class="main wishlist-page">
            
   <!-- Start of Breadcrumb -->
   <nav class="breadcrumb-nav">
      <div class="container">
         <ul class="breadcrumb bb-no">
              <h1 class="page-title mb-0">My Wishlist</h1>
              <li><a href="<?=site_url();?>" title="Home">Home</a></li>
              <li><a href="<?=base_url('my-account');?>" title="My Account">My Account</a></li>
              <li>My Wishlist</li>
         </ul>
      </div>
   </nav>
   
            <div class="page-content">
                <div class="container">
                    <!-- <h3 class="wishlist-title">My wishlist</h3> -->
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-3"> 
                            <?php $this->load->view('members/left'); ?>
                        </div>
                        <div class="col-lg-9">
  <table id="table-breakpoint" class="shop-table wishlist-table">
      <thead>
          <tr>
              <th class="product-name"><span>Product</span></th>
              <th></th>
              <th class="product-price"><span>Price</span></th>
              <th class="product-stock-status"><span>Stock Status</span></th>
              <th class="wishlist-action">Actions</th>
          </tr>
      </thead>
      <tbody>
        <?php
      if (is_array($wishlist) && !empty($wishlist)) { 
        foreach($wishlist as $wish=>$w)
        {
        ?>
          <tr>
              <td class="product-thumbnail">
                  <div class="p-relative">
                    <a href="<?php echo site_url(); ?>members/remove_wishlist/<?php echo $w['id']; ?>" type="submit" class="btn btn-close"><i class="fas fa-times"></i></a>
                      <a href="<?php echo base_url().$w['friendly_url']; ?>">
                          <figure>
                              <img src="<?php echo base_url().'uploaded-files/products/'.$w['media']; ?>" alt="product" width="300" height="338">
                          </figure>
                      </a>
                      
                  </div>
              </td>
              <td class="product-name">
                  <a href="<?php echo base_url().$w['friendly_url']; ?>">
                      <?php echo $w['product_name']; ?>
                  </a>
              </td>
              <td class="product-price">
                  <ins class="new-price">₹<?php echo $w['product_discounted_price']; ?></ins>
              </td>
              <td class="product-stock-status">
                  <span class="wishlist-in-stock">
                      <?php 
                      if( $w['product_qty']>0)
                      {
                        echo "In Stock";
                      }
                      else
                      {
                          echo "Out of Stock";
                      }
                      ?>
                      
                      
                      </span>
              </td>
              <td class="wishlist-action">
                  <div class="d-lg-flex">
                      <a href="<?php echo $w['friendly_url']; ?>" class="btn btn-quickview btn-outline btn-default btn-rounded btn-sm mb-2 mb-lg-0">View Product</a>
                      <!-- <a href="#" class="btn btn-dark btn-rounded btn-sm ml-lg-2 btn-cart">Add to
                          cart</a> -->
                  </div>
              </td>
          </tr>
         <?php }}else{echo "No data found";} ?> 
      </tbody>
  </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of PageContent -->
        </main>
        <!-- End of Main -->





<?php $this->load->view("bottom"); ?>