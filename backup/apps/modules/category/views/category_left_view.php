<?php
$category_id = (int) @$this->meta_info['entity_id'];
$page_url_sub = @$this->meta_info['page_url'];
$parentId = get_db_field_value('wps_categories', 'parent_id', "WHERE category_id = '" . $category_id . "'");
$parentId2 = get_db_field_value('wps_categories', 'parent_id', "WHERE category_id = '" . $parentId . "'");

//Category Cousin Result
$condtion_cousin = array('field' => "*,( SELECT COUNT(category_id) FROM wps_categories AS b WHERE b.parent_id=a.category_id ) AS total_subcategories", 'condition' => "AND parent_id = '" . $parentId . "' AND category_id != '" . $category_id . "' AND status='1' ", 'debug' => FALSE);
$result_cousin = $this->category_model->getcategory($condtion_cousin);

//Category Parent Result
$condtion_parent = array('field' => "*,( SELECT COUNT(category_id) FROM wps_categories AS b WHERE b.parent_id=a.category_id ) AS total_subcategories", 'condition' => "AND parent_id = '" . $parentId2 . "' AND status='1' ", 'debug' => FALSE);
$result_parent = $this->category_model->getcategory($condtion_parent);

//List of Cities for same category and counter of listing
//$subArray = $this->db->query("SELECT c.city, c.temp_title, COUNT(DISTINCT(u.customers_id)) as total_count FROM wps_products as p LEFT JOIN wps_customers as u ON p.customers_id = u.customers_id LEFT JOIN wps_cities_list as c ON u.city = c.id WHERE p.status = '1' AND u.status='1' AND c.status = '1' AND FIND_IN_SET(" . $category_id . ", p.category_links) GROUP BY c.id")->result_array();


$subArray = $this->db->query("SELECT c.city, c.temp_title, COUNT(DISTINCT(u.customers_id)) as total_count FROM wps_cities_list as c LEFT JOIN wps_customers as u ON c.id = u.city LEFT JOIN wps_products as p ON u.customers_id = p.customers_id WHERE p.status = '1' AND u.status='1' AND c.status = '1' AND FIND_IN_SET(" . $category_id . ", p.category_links) GROUP BY c.id")->result_array();


//business nature
$businessNature = $this->config->item('businessNature');

//get blogs
$blogs = $this->db->query("SELECT * FROM wps_blog WHERE status = '1' ORDER BY RAND() LIMIT 0, 3")->result_array();
?>
<link href="<?php echo theme_url(); ?>css/jquery.mCustomScrollbar.css" rel="stylesheet">
<div class="col-md-3 dir-alp-con-left col-md-pull-9">
  <?php
  if (is_array($subArray) && !empty($subArray)) {
    ?>
    <div class="dir-alp-con-left-1">
      <h4>Search By Location</h4>
    </div>

    <div class="city_filter_list">
      <div id="demo" class="showcase">
        <div id="content-1" class="content mCustomScrollbar">
          <ul class="city_list">
            <li><a href="<?php echo site_url(); ?><?php echo '' . $page_url_sub; ?>">All Cities</a></li>
            <?php
            $subcnt = 1;
            foreach ($subArray as $sub) {
              ?>
              <li><a <?php // class="active";         ?> href="<?php echo site_url(); ?><?php echo $sub['temp_title'] . '/' . $page_url_sub; ?>" title="<?php imagealtTitle('', $title, 'Manufacturers'); ?>"><?php echo $title . ' Manufacturers in ' . $sub['city']; ?> (<?php echo $sub['total_count']; ?>)</a></li>
              <?php
              $subcnt++;
            }
            ?>
          </ul>
        </div>
      </div>
    </div>


    <?php
  }
  ?>
  <div class="clearfix"></div>
  <?php
  if (is_array($listRes) && !empty($listRes)) {
    ?>
    <div class="dir-alp-con-left-1">
      <h4>Filter By Business Nature</h4> 
    </div>
    <div class="filter_list">
      <form action="" method="post">
        <ul>
          <?php
          foreach ($businessNature as $bk => $bn) {
            $chk = (@in_array($bk, $this->input->post('business_nature'))) ? 'checked' : '';
            ?>
            <li>
              <input type="checkbox" id="<?php echo $bn; ?>" <?php echo $chk; ?> value="<?php echo $bk; ?>" name="business_nature[]" onclick="this.form.submit();">
              <label for="<?php echo $bn; ?>">Manufacturer <?php echo $bn; ?></label>
            </li>
            <?php
          }
          ?>
        </ul>
      </form>
    </div>
    <?php
  }
  if (is_array($result_cousin) && !empty($result_cousin)) {
    ?>
    <!--==========Sub Category Filter============-->
    <div class="dir-alp-l3 dir-alp-l-com">
      <h4>Featured Categories</h4>
      <div class="dir-hom-pre dir-alp-left-ner-notb">
        <ul>
          <?php
          foreach ($result_cousin as $ck => $cousin) {
            ?>
            <li><a title="<?php imagealtTitle('', $cousin['category_name'], 'Manufacturers'); ?>" href="<?php echo site_url($cousin['friendly_url']); ?>"><?php echo $cousin['category_name']; ?></a></li>
            <?php
          }
          ?>
        </ul>
      </div>
    </div>
    <!--==========End Sub Category Filter============-->
    <?php
  }
  if (is_array($result_parent) && !empty($result_parent)) {
    ?>
    <!--==========Sub Category Filter============-->
    <div class="dir-alp-l3 dir-alp-l-com">
      <h4>Related Categories</h4>
      <div class="dir-hom-pre dir-alp-left-ner-notb">
        <ul>
          <?php
          foreach ($result_parent as $pk => $parentRes) {
            ?>
            <li><a title="<?php imagealtTitle('', $parentRes['category_name'], 'Manufacturers'); ?>" href="<?php echo site_url($parentRes['friendly_url']); ?>"><?php echo $parentRes['category_name']; ?></a></li>
            <?php
          }
          ?>
        </ul>
      </div>
    </div>
    <!--==========End Sub Category Filter============-->
    <?php
  }
  ?>

  <!--<div class="dir-alp-l3 dir-alp-l-com">
    <h4>Nearby Exporter</h4>
    <div id="demo" class="showcase">
      <div id="content-1" class="content mCustomScrollbar">
        <div class="dir-hom-pre dir-alp-left-ner-notb">
          <ul class="city_01">
            <li><a href="">Fashion Accessories Manufacturer in Delhi</a></li>
            <li><a href="">Fashion Accessories Manufacturer in Bengaluru</a></li>
            <li><a href="">Fashion Accessories Manufacturer in Ludhiana</a></li>
            <li><a href="">Fashion Accessories Manufacturer in Mumbai</a></li>
            <li><a href="">Fashion Accessories Manufacturer in Hyderabad</a></li>
            <li><a href="">Fashion Accessories Manufacturer in Tiruppur</a></li>
            <li><a href="">Fashion Accessories Manufacturer in Noida</a></li>
            <li><a href="">Fashion Accessories Manufacturer in Coimbatore</a></li>
            <li><a href="">Fashion Accessories Manufacturer in Ahmedabad</a></li>
            <li><a href="">Fashion Accessories Manufacturer in Kolkata</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>--

  <!--==========Sub Category Filter============-->
  <?php
  if (is_array($blogs) && !empty($blogs)) {
    ?>
    <div class="dir-alp-l3 dir-alp-l-com">
      <h4>Blog & Article</h4>
      <div class="dir-alp-l-com1 dir-alp-p3 you_may_like">
        <?php
        foreach ($blogs as $blog) {
          ?>
          <div class="right_news">
            <a href="javascript:void()">
              <div class="image">
                <img class="media-object" src="<?php echo get_image('blog', $blog['article_image'], '', '', 'R'); ?>" alt="<?php echo $blog['article_title']; ?>" title="<?php echo $blog['article_title']; ?>">
              </div>
            </a>
            <h5><a href="<?php echo site_url() . $blog['friendly_url']; ?>" title="<?php echo $blog['article_title']; ?>"><?php echo $blog['article_title']; ?></a></h5>
            <p><?php echo char_limiter($blog['short_desc'], 100); ?></p>
          </div>
          <?php
        }
        ?>


        <?php
        foreach ($blogs as $blog) {
          ?>
          <div class="right_news">
            <a href="javascript:void()">
              <div class="image">
                <img class="media-object" src="<?php echo get_image('blog', $blog['article_image'], '', '', 'R'); ?>" alt="<?php echo $blog['article_title']; ?>" title="<?php echo $blog['article_title']; ?>">
              </div>
            </a>
            <h5><a href="<?php echo site_url() . $blog['friendly_url']; ?>" title="<?php echo $blog['article_title']; ?>"><?php echo $blog['article_title']; ?></a></h5>
            <p><?php echo char_limiter($blog['short_desc'], 100); ?></p>
          </div>
          <?php
        }
        ?>



      </div>
    </div>
    <?php
  }
  ?>
  <!--==========End Sub Category Filter============-->
</div>
<script src="<?php echo theme_url(); ?>js/jquery.mCustomScrollbar.concat.min.js"></script>