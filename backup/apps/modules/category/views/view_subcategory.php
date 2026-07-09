<?php
$this->load->view("top_application");
$messurement = $this->config->item('unit_measurement');
$QryStringArr = array();  // To store all Query Variables so to move to other view;
$QryStringArr = array_unique($QryStringArr);
if (isset($this->meta_info['entity_id']) && $this->meta_info['entity_id'] != '') {
  $QryStringArr['category_id'] = $this->meta_info['entity_id'];
}
if ($city != '') {
  $QryStringArr['city'] = $city;
}
if ($this->input->post('category_id')) {
  $QryStringArr['category_id'] = $this->input->post('category_id');
}
if ($this->input->get_post('keyword') != '') {
  $QryStringArr['keyword'] = $this->input->get_post('keyword');
}
if ($this->input->get_post('keyword_search') != '') {
  $QryStringArr['keyword_search'] = $this->input->get_post('keyword_search');
}
if ($this->input->get_post('sort') != '') {
  $QryStringArr['sort'] = $this->input->get_post('sort');
}
//trace($QryStringArr);
if (is_array($category_banner) && !empty($category_banner)) {
  ?>
  <!-- Banner Start -->
  <section class="inner_banner dir-pa-sp-top">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <?php
        $bncnt = 1;
        foreach ($category_banner as $banner) {
          ?>
          <div class="item <?php echo ($bncnt == 1) ? 'active' : ''; ?>" <?php echo ($banner['banner_url'] != "") ? 'onclick="window.location.href=/"' . $banner['banner_url'] . '"/"' : ''; ?>> <img src="<?php echo get_image('banner', $banner['banner_image'], '1350', '225', 'R'); ?>" alt="<?php echo $title; ?> Banner <?php echo $bncnt; ?>"> </div>
          <?php
          $bncnt++;
        }
        ?>
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev"> <i class="fa fa-angle-left list-slider-nav" aria-hidden="true"></i> </a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next"> <i class="fa fa-angle-right list-slider-nav list-slider-nav-rp" aria-hidden="true"></i> </a>
    </div>
  </section>
  <!-- Banner End -->
  <?php
}
?>

<section class="dir-alp <?php echo (is_array($category_banner) && empty($category_banner)) ? 'dir-pa-sp-top' : ''; ?>">
  <div class="container">
    <div class="row">
      <div class="pg-list-1-left1">
        <h1><?php echo $heading_title; ?></h1>
        <div class="dir-alp-tit">
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>">Home</a> </li>
            <?php echo category_breadcrumbs($categoryId); ?>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div id="second_bar">
    <div class="container">
      <div class="row">
        <ul class="second_bar_menu">
          <li>
            <a class="active" href="javascript:void(0);">
              <span><?php echo $title; ?>
                <?php
                if (is_array($catList) && !empty($catList)) {
                  ?>
                  <i class="fa fa-angle-down"></i>
                  <?php
                }
                ?>
              </span>
            </a>
            <?php
            if (is_array($catList) && !empty($catList)) {
              ?>
              <div class="sub_menu01">
                <div class="container">
                  <div class="full_menu02">
                    <ul class="row">
                      <?php
                      foreach ($catList as $val) {
                        ?>
                        <li><a href="<?php echo site_url($val['friendly_url']); ?>" title="<?php imagealtTitle('', $val['category_name'], 'Manufacturers'); ?>"><?php echo $val['category_name']; ?></a></li>
                        <?php
                      }
                      ?>
                    </ul>
                  </div>
                </div>
              </div>
              <?php
            }
            ?>
          </li>

          <?php
          if (is_array($result_cousin) && !empty($result_cousin)) {
            foreach ($result_cousin as $sVal) {
              $condtion_child = array('field' => "*,( SELECT COUNT(category_id) FROM wps_categories AS b WHERE b.parent_id=a.category_id ) AS total_subcategories", 'condition' => "AND parent_id = '" . $sVal['category_id'] . "' AND status='1' ", 'debug' => FALSE);
              $result_child = $this->category_model->getcategory($condtion_child);
              ?>
              <li>
                <a href="<?php echo site_url($sVal['friendly_url']); ?>" title="<?php imagealtTitle('', $sVal['category_name'], 'Manufacturers'); ?>">
                  <span><?php echo $sVal['category_name']; ?>
                    <?php
                    if (is_array($result_child) && !empty($result_child)) {
                      ?>
                      <i class="fa fa-angle-down"></i>
                      <?php
                    }
                    ?>
                  </span>
                </a>
                <?php
                if (is_array($result_child) && !empty($result_child)) {
                  ?>
                  <div class="sub_menu01">
                    <div class="container">
                      <div class="full_menu02">
                        <ul class="row">
                          <?php
                          foreach ($result_child as $cVal) {
                            ?>
                            <li><a href="<?php echo site_url($cVal['friendly_url']); ?>" title="<?php imagealtTitle('', $cVal['category_name'], 'Manufacturers'); ?>"><?php echo $cVal['category_name']; ?></a></li>
                            <?php
                          }
                          ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <?php
                }
                ?>
              </li>
              <?php
            }
          }
          ?>
          <li>
            <a href="javascript:void(0);"><span>More <i class="fa fa-angle-down"></i></span></a>
            <?php
            if (is_array($result_cousin_1) && !empty($result_cousin_1)) {
              ?>
              <div class="sub_menu01">
                <div class="container">
                  <div class="full_menu02">
                    <ul class="row">
                      <?php
                      foreach ($result_cousin_1 as $cVal1) {
                        //trace($val);
                        ?>
                        <li><a href="<?php echo site_url($cVal1['friendly_url']); ?>" title="<?php imagealtTitle('', $cVal1['category_name'], 'Manufacturers'); ?>"><?php echo $cVal1['category_name']; ?></a></li>
                        <?php
                      }
                      ?>
                    </ul>
                  </div>
                </div>
              </div>
              <?php
            }
            ?>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="second_mobile hidden-lg hidden-md">
      <h3>Categories</h3>
      <button type="button" id="tab-top-menu" onclick="return OnMobileMenuClick()"><i class="fa fa-bars" aria-hidden="true"></i></button>
      <div id="m_navigation">
        <ul>
          <li><a class="active" href="javascript:void(0);"><?php echo $title; ?></a>
            <button type="button" onclick="return OnMobileSubMenuClick($(this));"><img src="<?php echo theme_url(); ?>images/drop-icon.png" title="<?php echo $title; ?>" alt="<?php echo $title; ?>"></button>
            <?php
            if (is_array($catList) && !empty($catList)) {
              ?>
              <ul>
                <?php
                foreach ($catList as $val) {
                  ?>
                  <li><a href="<?php echo site_url($val['friendly_url']); ?>" title="<?php imagealtTitle('', $val['category_name'], 'Manufacturers'); ?>"><?php echo $val['category_name']; ?></a></li>
                  <?php
                }
                ?>
              </ul>
              <?php
            }
            ?>
          </li>

          <?php
          if (is_array($result_cousin) && !empty($result_cousin)) {
            foreach ($result_cousin as $sVal) {
              $condtion_child = array('field' => "*,( SELECT COUNT(category_id) FROM wps_categories AS b WHERE b.parent_id=a.category_id ) AS total_subcategories", 'condition' => "AND parent_id = '" . $sVal['category_id'] . "' AND status='1' ", 'debug' => FALSE);
              $result_child = $this->category_model->getcategory($condtion_child);
              ?>
              <li><a href="<?php echo site_url($sVal['friendly_url']); ?>" title="<?php imagealtTitle('', $sVal['category_name'], 'Manufacturers'); ?>"><?php echo $sVal['category_name']; ?></a>
                <button type="button" onclick="return OnMobileSubMenuClick($(this));"><img src="<?php echo theme_url(); ?>images/drop-icon.png" title="<?php echo $sVal['category_name']; ?>" alt="<?php echo $sVal['category_name']; ?>"></button>
                <?php
                if (is_array($result_child) && !empty($result_child)) {
                  ?>
                  <ul>
                    <?php
                    foreach ($result_child as $cVal) {
                      ?>
                      <li><a href="<?php echo site_url($cVal['friendly_url']); ?>" title="<?php imagealtTitle('', $cVal['category_name'], 'Manufacturers'); ?>"><?php echo $cVal['category_name']; ?></a></li> <?php
                    }
                    ?>
                  </ul>
                  <?php
                }
                ?>
              </li>
              <?php
            }
          }
          ?>
          <li><a href="javascript:void(0);">More</a>
            <button type="button" onclick="return OnMobileSubMenuClick($(this));"><img src="<?php echo theme_url(); ?>images/drop-icon.png" title="More" alt="More"></button>
            <?php
            if (is_array($result_cousin_1) && !empty($result_cousin_1)) {
              ?>
              <ul>
                <?php
                foreach ($result_cousin_1 as $cVal1) {
                  ?>
                  <li><a href="<?php echo site_url($cVal1['friendly_url']); ?>" title="<?php imagealtTitle('', $cVal1['category_name'], 'Manufacturers'); ?>"><?php echo $cVal1['category_name']; ?></a></li> <?php
                }
                ?>
              </ul>
              <?php
            }
            ?>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="dir-alp-con">
        <div class="col-md-9 dir-alp-con-right list-grid-rig-pad left_right_pad col-md-push-3">
          <!-- Start View Listing -->
          <div class="clearfix"></div>
          <div id="prodListingContainer">
            <?php
            if (is_array($listRes) && !empty($listRes)) {
              foreach ($listRes as $listKey => $listVal) {
                //trace($listVal);
                $userDets = get_db_single_row("wps_customers", "customers_id, website, company_name, state, city, locality, address, landmark, locality, is_manufacturer", "customers_id = '" . $listVal['customers_id'] . "'");
                $aboutCompany = get_db_field_value("wps_customers_factsheet", "about_company", "WHERE id = '" . $listVal['customers_id'] . "'");
                $companywebsiteUrl = get_db_field_value("wps_company_website_urls", "website_url", "WHERE customers_id = '" . $listVal['customers_id'] . "' ORDER BY id DESC LIMIT 0,1");
                $city = "";
                $state = "";
                $locality = "";
                if (is_array($userDets) && !empty($userDets)) {
                  $city = get_db_field_value("wps_cities_list", "city", "WHERE id = '" . $userDets['city'] . "'");
                  $state = get_db_field_value("wps_states_list", "name", "WHERE id = '" . $userDets['state'] . "'");
                  $locality = $userDets['locality'];
                }

                //more products
                $condtion = array();
                $condtion['status'] = '1';
                $condtion['customers_id'] = $userDets['customers_id'];
                $condtion['category_id'] = $categoryId;
                $condtion['groupby'] = 'wlp.products_id';
                $condtion['leave_product_id'] = $listVal['products_id'];
                $productList = $this->product_model->get_products(4, 0, $condtion);
                $otherProductCount = get_found_rows();

                $location = $location1 = "";
                if ($state || $city) {
                  $location .= '<i class="fa fa-map-marker"></i> ';
                }
                if ($state)
                  $location .= $state;
                $location1 .= $state;
                if ($city) {
                  if ($state)
                    $location .= ', ';
                  $location1 .= ', ';
                  $location .= $city;
                  $location1 .= $city;
                }
                ?>
                <!--LISTINGS-->
                <div class="home-list-pop list-spac listpager">
                  <!--LISTINGS IMAGE-->
                  <?php
                  if ($listVal['youtube_id'] != '') {
                    
                  }
                  ?>
                  <div class="col-md-3 list-ser-img">
                    <a href="javascript:void(0);" title="<?php echo $listVal['product_name']; ?>" data-productID="<?php echo $listVal['products_id']; ?>" data-companyID="<?php echo $listVal['customers_id']; ?>" data-productName="<?php echo $listVal['product_name'] . ' <br> ' . $userDets['company_name'] . ' ' . $location1; ?>" data-companyName="<?php echo $userDets['company_name']; ?>" data-productImage="<?php echo get_image('product_images', $listVal['media'], '400', '600', 'R'); ?>" data-unit="<?php echo $messurement[$listVal['unit_measurement']]; ?>" class="getQuote" data-dismiss="modal" data-toggle="modal" data-target="#list-quo">
                      <div class="cat_image01">
                        <img src="<?php echo get_image('product_images', $listVal['media'], '400', '350', 'R'); ?>" alt="" />
                      </div>
                    </a>
                  </div>
                  <!--LISTINGS: CONTENT-->
                  <div class="col-md-6 home-list-pop-desc inn-list-pop-desc">
                    <div class="verified_badge">
                      <?php
                      if ($userDets['is_manufacturer'] == '1') {
                        ?>
                        <img src="<?php echo theme_url(); ?>images/verified.png">
                        <div class="info_02">
                          <p>These are the Manufacturers those have successfully completed their Verification Process as per the Guidelines of the Portal.</p>
                        </div>
                        <?php
                      } else {
                        ?>
                        <div class="info_02">
                          <p>These are the Manufacturers those Verification Process is still Pending as per the Guidelines of the Portal.</p>
                        </div>
                        <img src="<?php echo theme_url(); ?>images/icon/unverified.png">
                        <?php
                      }
                      ?>
                    </div>
                    <h3><a href="<?php echo site_url() . $listVal['friendly_url']; ?>" target="_blank" title="<?php echo $listVal['product_name']; ?>"><?php echo $listVal['product_name']; ?></a></h3>
                    <?php
                    if ($listVal['product_price'] > 0) {
                      ?>                      
                      <div class="price01">
                        <strong>
                          <?php echo display_price($listVal['product_price']); ?></strong>/<?php echo $messurement[$listVal['unit_measurement']]; ?><strong><br />
                          <strong>Min. Order</strong> : <?php echo $listVal['moq']; ?> <?php echo $messurement[$listVal['unit_measurement']]; ?></strong> 
                        <a href="javascript:void(0);" title="<?php echo $listVal['product_name']; ?>" data-productID="<?php echo $listVal['products_id']; ?>" data-companyID="<?php echo $listVal['customers_id']; ?>" data-productName="<?php echo $listVal['product_name'] . ' <br> ' . $userDets['company_name'] . ' ' . $location1; ?>" data-companyName="<?php echo $userDets['company_name']; ?>" data-productImage="<?php echo get_image('product_images', $listVal['media'], '400', '600', 'R'); ?>" data-unit="<?php echo $messurement[$listVal['unit_measurement']]; ?>" class="getQuote ml20" data-dismiss="modal" data-toggle="modal" data-target="#list-quo">Get latest Price</a>
                      </div>
                      <?php
                    }
                    ?>
                    <div class="clearfix"></div>
                    <p><?php echo $aboutCompany; ?></p>
                    <div class="list-details">
                      <?php
                      if ($listVal['attribute_name']) {
                        $atrribute = explode(',', $listVal['attribute_name']);
                        $atrributeVal = explode(',', $listVal['attribute_value']);
                        ?>
                        <div class="feature_list">
                          <ul>
                            <?php
                            $it = 1;
                            foreach ($atrribute as $ak => $av) {
                              ?>
                              <li><span class="left_span"><?php echo $av; ?></span>:<span class="right_span"><?php echo @$atrributeVal[$ak]; ?></span>
                              </li>
                              <?php
                              $it++;
                              if ($it == 7)
                                break;
                            }
                            ?>
                          </ul>
                        </div>
                        <?php
                      }
                      ?>
                    </div>
                    <?php
                    /*
                      <div class="list-enqu-btn">
                      <ul>
                      <li><a href="#!" data-productID="<?php echo $listVal['products_id']; ?>" data-companyID="<?php echo $listVal['customers_id']; ?>" data-productName="<?php echo $listVal['product_name'] . ' <br> ' . $userDets['company_name'] . ' ' . $location1; ?>" data-productImage="<?php echo get_image('product_images', $listVal['media'], '400', '600', 'R'); ?>" class="getQuote" data-dismiss="modal" data-toggle="modal" data-target="#list-quo">View Details</a> </li>
                      <li><a href="#!" data-productID="<?php echo $listVal['products_id']; ?>" data-companyID="<?php echo $listVal['customers_id']; ?>" data-productName="<?php echo $listVal['product_name'] . ' <br> ' . $userDets['company_name'] . ' ' . $location1; ?>" data-productImage="<?php echo get_image('product_images', $listVal['media'], '400', '600', 'R'); ?>" class="getQuote" data-dismiss="modal" data-toggle="modal" data-target="#list-quo"> Get a Quote</a></li>
                      </ul>
                      </div>
                     *
                     */
                    ?>
                    <a class="view_more_btn" href="<?php echo site_url() . $listVal['friendly_url']; ?>" target="_blank" title="<?php echo $listVal['product_name']; ?>">View More Details <i class="fa fa-angle-double-right"></i></a>

                  </div>
                  <div class="col-md-3 home-list-pop-desc inn-list-pop-desc borderCompLeft right_sub">
                    <a href="<?php echo ($companywebsiteUrl) ? site_url().$companywebsiteUrl : $userDets['website']; ?>" title="View More About <?php echo $userDets['company_name']; ?>" target="_blank">
                      <h4><?php echo $userDets['company_name']; ?></h4>
                    </a>
                    <div class="location"><?php echo $city; ?>, <?php echo $state; ?>
                      <div class="location_city">
                        <?php echo $userDets['address'] . ', ' . $userDets['locality'] . ', Near ' . $userDets['landmark']; ?>, <?php echo $city; ?>, <?php echo $state; ?>
                      </div>
                    </div>
                    <?php
                    if ($userDets['is_manufacturer'] == '1') {
                      ?>
                      <ul class="verified">
                          <!--<li><a href="javascript:void()"><i class="fa fa-gratipay"></i> Trust Verified</a></li>-->
                        <li><i class="fa fa-check-circle"></i> Verified Manufacturer</li>
                        <!--<li><a href="javascript:void()"><i class="fa fa-youtube-play"></i> Company Video</a></li>-->
                      </ul>
                      <?php
                    }
                    ?>
                    <div class="">
                      <?php
                      if ($listVal['youtube_id'] != '' && $listVal['youtube_id'] != '0') {
                        ?>
                        <a href="javascript:void(0);" data-youtubeId="<?php echo $listVal['youtube_id']; ?>" data-companyFacName="<?php echo $userDets['company_name']; ?>" title="Factory Video" class="youtube_btn" data-dismiss="modal" data-toggle="modal" data-target="#facVideo"><i class="fa fa-youtube-play"></i> Factory Video</a>
                        <?php
                      }
                      ?>

                      <a href="javascript:void(0);" data-companyID="<?php echo $listVal['customers_id']; ?>" class="view_contact_number <?php echo ($this->session->userdata('user_id') <= 0) ? 'getContactNo' : 'viewContactNo'; ?>" <?php echo ($this->session->userdata('user_id') <= 0) ? 'data-dismiss="modal" data-toggle="modal" data-target="#regis-ter"' : ''; ?>>View Contact Number</a>

                      <a href="javascript:void(0);" data-productID="<?php echo $listVal['products_id']; ?>" data-companyID="<?php echo $listVal['customers_id']; ?>" data-productName="<?php echo $listVal['product_name'] . ' <br> ' . $userDets['company_name'] . ' ' . $location1; ?>" data-companyName="<?php echo $userDets['company_name']; ?>" data-productImage="<?php echo get_image('product_images', $listVal['media'], '400', '600', 'R'); ?>" data-unit="<?php echo $messurement[$listVal['unit_measurement']]; ?>" class="get_quotes_btn getQuote" data-dismiss="modal" data-toggle="modal" data-target="#list-quo"> Get a Quote</a>
                    </div>
                  </div>
                  <?php
                  if ($otherProductCount > 0) {
                    ?>
                    <div class="col-md-12 home-list-pop-desc inn-list-pop-desc borderExtProTop">
                      <div class="more_products01"><?php echo $otherProductCount; ?> more products from this supplier</div>
                      <div class="clearfix"></div>
                      <div class="row">
                        <?php
                        foreach ($productList as $proVal) {
                          if ($proVal['media']) {
                            ?>

                            <div class="col-md-4">
                              <div class="list-customize more_item">
                                <div class="img-customize">
                                  <a href="<?php echo site_url() . $proVal['friendly_url']; ?>" title="<?php echo $proVal['product_name']; ?>" target="_blank">
                                    <img src="<?php echo get_image('product_images', $proVal['media'], '120', '120', 'R'); ?>" alt="" height="100" width="100" /> </a>
                                </div>
                                <div class="list-enqu-btn width_auto">
                                  <h6><a href="<?php echo site_url() . $proVal['friendly_url']; ?>" title="<?php echo $proVal['product_name']; ?>" target="_blank"><?php echo $proVal['product_name']; ?></a></h6>
                                  <!--  <p>Rs: 999/Piece</p>-->
                                  <ul>
                                    <li><a href="javascript:void(0);" data-productID="<?php echo $proVal['products_id']; ?>" data-companyID="<?php echo $proVal['customers_id']; ?>" data-productName="<?php echo $proVal['product_name'] . ' <br> ' . $userDets['company_name'] . ' ' . $location1; ?>" data-companyName="<?php echo $userDets['company_name']; ?>" data-productImage="<?php echo get_image('product_images', $proVal['media'], '400', '600', 'R'); ?>" data-unit="<?php echo $messurement[$proVal['unit_measurement']]; ?>" class="getQuote" data-dismiss="modal" data-toggle="modal" data-target="#list-quo"> Get a Quote</a> </li>
                                  </ul>
                                </div>

                              </div>
                            </div>

                            <?php
                          }
                        }
                        ?>
                      </div>
                    </div>
                    <?php
                  }
                  ?>
                </div>
                <!--LISTINGS END-->
                <?php
              }
            } else {
              ?>
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="gmcat-cont-banner">
                  <h3 class="gmcatcb-hd">Are you a Manufacturer, Supplier, or Exporter of <span><?php echo str_replace('Manufacturers', '', $heading_title); ?>?</span></h3>
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                      <h4 class="gmcatcb-hd2">“Work Smarter, Not Harder”
                        <span>List Your Business with GetManufacturers to Take your Business ahead by Powering Your Digital Dreams.</span>
                      </h4>
                      <h5 class="gmcatcb-hd3">
                        <?php
                        if ($this->session->userdata('user_id') > 0) {
                          ?>
                          <a class="blinking" href="<?php echo site_url(); ?>members/add-product">Register Your Business for Free to Reach your Ideal Audience.</a>
                          <?php
                        } else {
                          ?>
                          <a class="blinking" href="#" data-dismiss="modal" data-toggle="modal" data-target="#regis-ter">Register Your Business for Free to Reach your Ideal Audience.</a>
                          <?php
                        }
                        ?>
                      </h5>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                      <div class="wlyb-cont">
                        <h2 class="wlyb-hd">Why List Your Business with Getmanufacturers?</h2>
                        <ul class="wlyb-cont-listing">
                          <li>Free Website</li>
                          <li>Promotion in 50+ Cities</li>
                          <li>Genuine Enquiries</li>
                          <li>Global Exposure</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <?php
              if (is_array($result_cousin_1) && !empty($result_cousin_1)) {
                ?>
                <div class="list-spac">
                  <div class="com-title">
                    <div class="head_title2">New Businesses in this month</div>
                    <!--<p>Explore some of the best.</p>-->
                  </div>
                  <div class="row span-none">
                    <?php
                    foreach ($result_cousin_1 as $cVal1) {
                      //trace($cVal1);
                      ?>
                      <div class="col-md-4">
                        <a href="<?php echo site_url($cVal1['friendly_url']); ?>">
                          <div class="list-mig-like-com com-mar-bot-30 back_list">
                            <div class="list-mig-lc-img">
                              <img src="<?php echo get_image('category', $cVal1['category_image'], '295', '295', 'R'); ?>" title="<?php imagealtTitle('', $cVal1['category_name'], 'Manufacturers'); ?>" alt="<?php imagealtTitle('', $cVal1['category_name'], 'Manufacturers'); ?>" />
                            </div>
                            <div class="list-mig-lc-con">
                              <h5><?php echo $cVal1['category_name']; ?></h5>
                            </div>
                          </div>
                        </a>
                      </div>
                      <?php
                    }
                    ?>
                  </div>
                </div>
                <?php
              }
            }
            ?>
          </div>
          <!--LISTINGS END-->
        </div>
        <?php $this->load->view("category/category_left_view", array("title" => $title)); ?>
      </div>
    </div>
  </div>
  <div class="container">
    <?php
    if (is_array($category_result) && !empty($category_result) && $category_result['category_description']) {
      ?>
      <div class="col-lg-12">
        <div class="full_content">
          <?php echo $category_result['category_description']; ?>
        </div>
      </div>
      <?php
    }
    ?>
  </div>
</section>
<!--MOBILE APP-->
<script type="text/javascript">
  $("#prodListingContainer").on("click", ".getQuote", function () {
    var productID = $(this).attr('data-ProductID');
    var companyID = $(this).attr('data-companyID');
    var companyName = $(this).attr('data-companyName');
    var productName = $(this).attr('data-ProductName');
    var productImage = $(this).attr('data-ProductImage');
    $('#productQuoteImage').attr('src', productImage);
    $('#productQuoteImage').css({
      "border": "3px solid #CCC"
    });
    $('#companyProDetails').html('');
    var title = productName.substr(0,productName.indexOf("<br>"));  
    $('#companyProDetails').html('<h5>'+title+'</h5>'+productName.replace(title+"<br>",""));
    $('#companyProName').html(companyName);
    $('#productQuoteID').val(productID);
    $('#productCompID').val(companyID);
    $('.unitSize').html('/' + $(this).attr('data-unit'));
  });


  $(".getContactNo").click(function () {
    $('.pop-btn-rgstr').val('View Contact No.');
    $('.viewCompContact').val($(this).attr('data-companyID'));
  });

  var page = 1;
  var triggeredPaging = 0;
  $(window).scroll(function () {
    $('#loadingdiv').hide();
    var scrollTop = $(window).scrollTop();
    var scrollBottom = (scrollTop + $(window).height());
    var containerTop = $('#prodListingContainer').offset().top;
    var containerHeight = $('#prodListingContainer').height();
    var containerBottom = Math.floor(containerTop + containerHeight);
    var scrollBuffer = 0;
    if ((containerBottom - scrollBuffer) <= scrollBottom) {
      page = $('.listpager').length;
      var queryString = '?stOffSet=' + page;
<?php
if (count($QryStringArr)) {
  foreach ($QryStringArr as $qrykey => $qryval) {
    ?>
          queryString += "&<?php echo $qrykey; ?>=<?php echo $qryval; ?>";
    <?php
  }
}
?>
      var actual_count = <?php echo $total_list_rows; ?>;
      if (!triggeredPaging && page < actual_count) {
        triggeredPaging = 1;
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>products/ajax_load_product_view" + queryString,
          error: function (res) {
            //alert('Error');
            triggeredPaging = 0;
            $('#loadingdiv').hide();
            //console.log(arguments);
          },
          beforeSend: function (jqXHR, settings) {
            $('#loadingdiv').show();

          },
          success: function (res) {
            $('#loadingdiv').hide();
            $("#prodListingContainer").append(res);
            triggeredPaging = 0;
            //console.log(res);
            $('.listpager').fadeTo(1000, 0.5, function () {
              $(this).fadeTo(1000, 1.0);
            });
          }
        });
      }
    }
  });

  $('.view_btn').click(function () {
    var text = $(this).html();
    //alert(text);
    if (text == '+ View More') {
      $(this).html('- View Less');
      $(this).parent().children('.full_item').children('.vm').removeClass('hidden');
    } else {
      $(this).html('+ View More');
      $(this).parent().children('.full_item').children('.vm').addClass('hidden');
    }
  });

</script>
<?php $this->load->view("bottom_application"); ?>
<script>
  window.onscroll = function () {
    myFunction()
  };
  var navbar = document.getElementById("second_bar");
  var sticky = navbar.offsetTop;

  function myFunction() {
    if (window.pageYOffset >= sticky) {
      navbar.classList.add("sticky")
    } else {
      navbar.classList.remove("sticky");
    }
  }

  function OnMobileMenuClick() {
    if ($("#m_navigation").is(":visible")) {
      $("#m_navigation").hide();
    } else {
      $("#m_navigation ul li ul").each(function () {
        $(this).hide();
      });
      $("#m_navigation").show();
    }
    return false;

  }

  function OnMobileSubMenuClick(objThis) {
    if (objThis.next("ul").is(":visible")) {
      objThis.next("ul").hide();
    } else {
      $("#m_navigation ul li ul li ul").each(function () {
        $(this).hide();
      });
      objThis.next("ul").show();
    }

    return false;
  }

</script>
