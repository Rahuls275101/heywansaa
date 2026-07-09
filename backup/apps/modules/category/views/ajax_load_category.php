<?php
foreach ($res as $val) {
  //trace($val);
  $link_url = site_url($val['friendly_url']);
  $catCount = count_category(" AND parent_id = '" . $val['category_id'] . "' ");
  $proCount = count_products(" AND category_id = '" . $val['category_id'] . "' ");
  if ($proCount > 0) {
    $count = $proCount;
    $catRes = array();
  } else {
    $count = $catCount;
    $catRes = $this->db->query("SELECT * FROM wps_categories WHERE parent_id = '" . $val['category_id'] . "' AND status = '1' LIMIT 0, 3")->result_array();
  }
  ?>
  <div class="col-sm-6 col-md-4 listpager">
    <div class="listing01">
      <div class="box-img">
        <div class="images02">
          <img src="<?php echo get_image('category', $val['category_image'], '450', '315', 'R'); ?>" alt="<?php imagealtTitle('', $val['category_name'], 'Manufacturers'); ?>>" title="<?php imagealtTitle('', $val['category_name'], 'Manufacturers'); ?>">
        </div>
        <div class="caption">
          <h2><a title="<?php imagealtTitle('', $val['category_name'], 'Manufacturers'); ?>" href="<?php echo site_url($val['friendly_url']); ?>"><?php echo $val['category_name']; ?> (<?php echo $count; ?>)</a></h2>
          <ul>
            <?php
            foreach ($catRes as $subCat) {
              $catCount = count_category(" AND parent_id = '" . $subCat['category_id'] . "' ");
              $proCount = count_products(" AND category_id = '" . $subCat['category_id'] . "' ");
              if ($proCount > 0) {
                $subcount = $proCount;
              } else {
                $subcount = $catCount;
              }
              ?>
              <li><a href="<?php echo site_url($subCat['friendly_url']); ?>" title="<?php imagealtTitle('', $subCat['category_name'], 'Manufacturers'); ?>"><?php echo $subCat['category_name']; ?> (<?php echo $subcount; ?>)</a></li>
              <?php
            }
            ?>

          </ul>
          <div class="listing-bottom">
            <a href="<?php echo site_url($val['friendly_url']); ?>" class="btn btn-common float-right" title="<?php imagealtTitle('', $val['category_name'], 'Manufacturers'); ?>">View All</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>