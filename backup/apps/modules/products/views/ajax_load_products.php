<?php
$ix = 1;
foreach ($listRes as $listKey => $val) {
  $productImage = get_db_field_value("wps_products_media", "media", "WHERE products_id = '" . $val['products_id'] . "' ORDER BY id asc LIMIT 0, 1");
  $productImage2 = get_db_field_value("wps_products_media", "media", "WHERE products_id = '" . $val['products_id'] . "' ORDER BY id asc LIMIT 1, 1");
  ?>
       <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 listpager">
          <div class="item wow fadeInDown animated" data-wow-delay=".3s">
            <div class="item-product item-product1 pd0">
              <div class="product-rate">
                <div class="product-rating" style="width:60%"></div>
              </div>
              <div class="product-thumb">
                <div class="details-img-custom">
                        <div class="single-product-image">
                        <div class="blur-img">
                       <img src="<?php echo get_image('products', $productImage, '310', '310', 'R'); ?>" alt="<?php imagealtTitle('Buy', ucwords(strtolower($val['product_name'])), ''); ?>" title="<?php imagealtTitle('Buy', ucwords(strtolower($val['product_name'])), ''); ?>" />
                        </div>
                        <div class="main-img">
                         <a href="<?php echo base_url($val['friendly_url']); ?>" class="product-thumb-link" title="<?php imagealtTitle('Buy', ucwords(strtolower($val['product_name'])), ''); ?>">
                  <img src="<?php echo get_image('products', $productImage, '310', '310', 'R'); ?>" alt="<?php imagealtTitle('Buy', ucwords(strtolower($val['product_name'])), ''); ?>" title="<?php imagealtTitle('Buy', ucwords(strtolower($val['product_name'])), ''); ?>" />
                </a>
                        </div>
                        </div>                        
                        </div>               
                <div class="product-extra-link style1"> <a href="<?php echo base_url($val['friendly_url']); ?>" class="addcart-link" title="View Details">View Details</a>
                </div>
              </div>
              <?php if(isset($cat_res['category_id']) && $cat_res['category_id']!==''){ $parent_cat = $this->db->query("SELECT parent_id FROM wps_categories WHERE category_id='" . $cat_res['category_id'] . "'")->row_array(); if($parent_cat['parent_id']=='1'){ ?>
              <!-- <div class="pdp-label bottom-left">Personalizable</div> -->
            <?php } } ?>
            <?php if($val['product_discounted_price']>0){ $percent = (($val['product_price'] - $val['product_discounted_price'])*100)/$val['product_price']; ?>
            <div class="pdp-label bottom-left"><?php echo round($percent); ?>% Off</div> 
          <?php }elseif($val['newarrival_product']=='1'){ ?>
             <div class="pdp-label bottom-left">Sale</div>
          <?php } ?>
              <h3 class="title14 product-title"><a href="<?php echo base_url($val['friendly_url']); ?>" title="Traditional Bone Choker"><?php echo $val['product_name']; ?></a></h3>
              <div class="product-price rale-font">
                <div class="color title18 font-bold">
                   <?php if($val['product_discounted_price']>0){ ?>
                    <span class="final-price"><?php echo display_price($val['product_discounted_price']); ?></span>
                  <span class="discounted-p"><?php echo display_price($val['product_price']); ?></span> 
                <?php }elseif($val['product_price']!='' && $val['product_price']>0){ ?>
                  <span class="final-price"><?php echo display_price($val['product_price']); ?></span>
                <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        
  <?php
}
?>