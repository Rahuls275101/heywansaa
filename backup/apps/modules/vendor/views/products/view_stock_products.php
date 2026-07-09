<?php $this->load->view('includes/top');
//trace($post_err);
//trace($matrix_arr_db);
 ?>
<!--  BEGIN MAIN CONTAINER  -->
<link rel="stylesheet" type="text/css" href="<?php echo admin_url(); ?>assets/css/forms/switches.css">
<link rel="stylesheet" type="text/css" href="<?php echo admin_url(); ?>plugins/editors/markdown/simplemde.min.css">
<div class="main-container" id="container">
  <div class="overlay"></div>
  <div class="search-overlay"></div>
  <?php $this->load->view('includes/left'); ?>
  <!--  BEGIN CONTENT AREA  -->
  <div id="content" class="main-content">
    <div class="layout-px-spacing">
      <div class="row layout-top-spacing layout-spacing">
        <div class="col-lg-12">
          <div class="statbox widget box box-shadow">
            
            <?php echo form_open("wps-admin/products/view_stocks/" . $this->uri->segment(4), 'id="myform"');  
            echo success_message(); validation_message(); error_message();
            ?>
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                  <h4><?php echo $headingTitle; ?></h4>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right">
                  <h4>
                    <a href="<?php echo base_url(); ?>wps-admin/news/index/" class="btn btn-danger btn-sm mb-2"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Save</button>
                    <!-- <button type="submit" class="btn btn-info btn-sm mb-2"><i class="fa fa-plus-square"></i> Save & New</button>
                    <button type="submit" class="btn btn-secondary btn-sm mb-2"><i class="fa fa-plus-square"></i> Save & Close</button> -->
                  </h4>
                </div>
              </div>
            </div>
            <div class="widget-content widget-content-area">
              <div class="table-responsive mb-4">

             
          <table class="table datatable" id="my_data">
            <?php
            if ((is_array($res_colors) && !empty($res_colors)) || (is_array($res_size) && !empty($res_size))) {
              $values_posted_back = (!empty($this->input->post())) ? TRUE : FALSE;

              $outer_loop = "";
              $inner_loop = array();
              //print_r($res_colors);exit;
              ?>
              <thead>
                <?php
                if (is_array($res_colors) && !empty($res_colors)) {
                  $outer_loop = $res_colors;

                  $outer_field_type = "color";
                  ?>
                <td><strong>Color</strong></td>
                  <?php
                }
                  ?>
                <?php
              
              if (is_array($res_size) && !empty($res_size)) {
                if ($outer_loop == "") {
                  $outer_loop = $res_size;

                  $outer_field_type = "size";
                } else {
                  $inner_loop = $res_size;
                  //print_r($inner_loop);exit;
                }
                ?>
                <td><strong>Size</strong></td>

              <?php } ?>

              <td><strong>Quantity</strong></td>
              <td><strong>Product Price</strong></td>
              <td><strong>Discounted Price</strong></td>
              </thead>
              <?php
              $loop_ctr = 0;
              foreach ($outer_loop as $key1 => $val1) {
                if (!empty($inner_loop)) {
                  //print_r($inner_loop);exit;
                  foreach ($inner_loop as $key2 => $val2) {
                    $size_id = $val2['size_id'];
                    if (array_key_exists('color_id', $val1)) {
                      $type = $val1['color_id'];
                    } 
                    //print_r($type);exit;


                    $loop_product_price = "";
                    $loop_product_discounted_price = "";
                    $loop_quantity = "";

                    if ($values_posted_back === TRUE) {
                      $product_price = $this->input->post('product_price');

                      $loop_product_price = $product_price[$loop_ctr];

                      $product_discounted_price = $this->input->post('product_discounted_price');

                      $loop_product_discounted_price = $product_discounted_price[$loop_ctr];

                      $quantity = $this->input->post('quantity');

                      $loop_quantity = $quantity[$loop_ctr];
                      
                    } elseif ($matrix_arr_filled === TRUE) {
                      if (array_key_exists($type, $matrix_arr_db)) {
                        if (array_key_exists($size_id, $matrix_arr_db[$type])) {
                          $loop_product_price = $matrix_arr_db[$type][$size_id]['product_price'];
                          $loop_product_price = formatNumber($loop_product_price, 2);
                          $loop_product_discounted_price = $matrix_arr_db[$type][$size_id]['product_discounted_price'];
                          $loop_product_discounted_price = $loop_product_discounted_price == 0 ? "" : formatNumber($loop_product_discounted_price, 2);
                          $loop_quantity = $matrix_arr_db[$type][$size_id]['quantity'];
                        }
                      }
                    }
                    ?>
                    <tr>
                    <?php if (isset($val1['color_id'])) { ?>
                        <td>

                          <select name="color[]" class="form-control" >
                            <option value="<?php echo $type; ?>" selected><?php echo $val1['color_name']; ?></option>
                          </select>
                        </td>
                    <?php }  ?>
                       
                      <td>
                        <select name="size[]" class="form-control" >
                          <option value="<?php echo $val2['size_id']; ?>" selected><?php echo $val2['size_name']; ?></option>
                        </select>
                      </td>
                      <td>
                        <input type="text" name="quantity[]" class="form-control" value="<?php if (isset($pro_base_val)) {
                echo substr($pro_base_val->product_qty, 0, 1);
              } else {
                echo $loop_quantity;
              } ?>" />
        <?php
        if (array_key_exists($loop_ctr, $post_err['quantity'])) {
          echo '<div class="required">' . $post_err['quantity'][$loop_ctr] . '</div>';
        }
        ?>
                      </td>
                      <td>
                        <input type="text" name="product_price[]" class="form-control" value="<?php if (isset($pro_base_val)) {
          echo $pro_base_val->product_price;
        } else {
          echo $loop_product_price;
        } ?>" />
                        <?php
                        if (array_key_exists($loop_ctr, $post_err['product_price'])) {
                          echo '<div class="required">' . $post_err['product_price'][$loop_ctr] . '</div>';
                        }
                        ?>
                      </td>
                      <td>
                        <input type="text" name="product_discounted_price[]" class="form-control" value="<?php if (isset($pro_base_val)) {
                          echo $pro_base_val->product_discounted_price;
                        } else {
                          echo $loop_product_discounted_price;
                        } ?>" />
                        <?php
                        if (array_key_exists($loop_ctr, $post_err['product_discounted_price'])) {
                          echo '<div class="required">' . $post_err['product_discounted_price'][$loop_ctr] . '</div>';
                        }
                        ?>
                      </td>
                    </tr>
                        <?php
                        $loop_ctr++;
                      }
                    } else {
                      $loop_product_price = "";
                      $loop_product_discounted_price = "";
                      $loop_quantity = "";

                      if ($outer_field_type == 'color') {
                        $size_id = 0;

                        $color_id = $val1['color_id'];
                      } else {
                        $size_id = $val1['size_id'];

                        $color_id = 0;
                      }

                      if ($values_posted_back === TRUE) {
                        $product_price = $this->input->post('product_price');

                        $loop_product_price = $product_price[$loop_ctr];

                        $product_discounted_price = $this->input->post('product_discounted_price');

                        $loop_product_discounted_price = $product_discounted_price[$loop_ctr];

                        $quantity = $this->input->post('quantity');

                        $loop_quantity = $quantity[$loop_ctr];
                      } elseif ($matrix_arr_filled === TRUE) {
                        if (array_key_exists($color_id, $matrix_arr_db)) {
                          if (array_key_exists($size_id, $matrix_arr_db[$color_id])) {
                            $loop_product_price = $matrix_arr_db[$color_id][$size_id]['product_price'];
                            $loop_product_price = formatNumber($loop_product_price, 2);
                            $loop_product_discounted_price = $matrix_arr_db[$color_id][$size_id]['product_discounted_price'];
                            $loop_product_discounted_price = $loop_product_discounted_price == 0 ? "" : formatNumber($loop_product_discounted_price, 2);
                            $loop_quantity = $matrix_arr_db[$color_id][$size_id]['quantity'];
                          }
                        }
                      }
                      ?>
                  <tr>
                    <td>
                  <?php
                  if ($outer_field_type == 'color') {
                    ?>
                        <select name="color[]" class="form-control">
                          <option value="<?php echo $val1['color_id']; ?>" selected><?php echo $val1['color_name']; ?></option>
                        </select>
                    <?php
                  } else {
                    ?>
                        <select name="size[]" class="form-control">
                          <option value="<?php echo $val1['size_id']; ?>" selected><?php echo $val1['size_name']; ?></option>
                        </select>
                    <?php
                  }
                  ?>
                    </td>
                    <td>
                      <input type="text" name="quantity[]" value="<?php echo $loop_quantity; ?>" class="form-control" />
                      <?php
                      if (array_key_exists($loop_ctr, $post_err['quantity'])) {
                        echo '<div class="required">' . $post_err['quantity'][$loop_ctr] . '</div>';
                      }
                      ?>
                    </td>
                    <td>
                      <input type="text" name="product_price[]" class="form-control" value="<?php echo $loop_product_price; ?>" />
                      <?php
                      if (array_key_exists($loop_ctr, $post_err['product_price'])) {
                        echo '<div class="required">' . $post_err['product_price'][$loop_ctr] . '</div>';
                      }
                      ?>
                    </td>
                    <td>
                      <input type="text" name="product_discounted_price[]" class="form-control" value="<?php echo $loop_product_discounted_price; ?>" />
      <?php
      if (array_key_exists($loop_ctr, $post_err['product_discounted_price'])) {
        echo '<div class="required">' . $post_err['product_discounted_price'][$loop_ctr] . '</div>';
      }
      ?>
                    </td>
                  </tr>
                      <?php
                      $loop_ctr++;
                    }
                  }
                  ?> 
                  <?php
                } else {
                  echo "<tr><td><center><strong> No record(s) found !</strong></center></td></tr>";
                }
                ?>
            <div class="form-group pull-right">

              <div class="col-md-6">                                  

                <!-- <input type="submit" name="sub" value="Save" class="btn btn-primary" /> -->
                <input type="hidden" name="ref_id" value="<?php echo $this->uri->segment(4); ?>" />
              </div>
            </div>
          </table>



              <div class="widget-header">
                <div class="row">
                  <div class="col-xl-6 col-md-6 col-sm-6 col-6">&nbsp;</div>
                  <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right">
                    <h4>
                      <a href="<?php echo base_url(); ?>wps-admin/news" class="btn btn-danger btn-sm mb-2"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                      <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-plus"></i> Save</button>
                      <input type="hidden" name="sub" value="Save" /> 
                      <!-- <button type="submit" class="btn btn-info btn-sm mb-2"><i class="fa fa-plus-square"></i> Save & New</button>
                      <button type="submit" class="btn btn-secondary btn-sm mb-2"><i class="fa fa-plus-square"></i> Save & Close</button> -->
                    </h4>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-wrapper">
        <div class="footer-section f-section-1">
          <p class="terms-conditions">All Rights Reserved. Powered By <a href="https://www.weblieu.com/" target="_blank">weblieu</a></p>
        </div>
        <div class="footer-section f-section-2">
          <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
        </div>
      </div>
    </div>
    <!--  END CONTENT AREA  -->
  </div>
  <!-- END MAIN CONTAINER -->
  <?php $this->load->view('includes/bottom'); ?>
  
  <?php die(); ?>
